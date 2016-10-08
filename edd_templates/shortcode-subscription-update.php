<?php
/**
 *  EDD Template File for [edd_recurring_history] shortcode with the 'update' action
 */


/**
 * Changes made
 *
 * Added "button" CSS class to back link
 */

//For logged in users only
if ( is_user_logged_in() ):

	//Get subscription
	$subscriber = new EDD_Recurring_Subscriber( get_current_user_id(), true );

	$subscription_id = false;
	if ( isset( $_GET['subscription_id'] ) && is_numeric( $_GET['subscription_id'] ) ) {
		$subscription_id = absint( $_GET['subscription_id'] );
		$subscription = new EDD_Subscription( $subscription_id );
	}

	edd_print_errors();

	if ( ! empty( $subscription->id ) && $subscription->customer_id == $subscriber->id ) :

		$download   = new EDD_Download( $subscription->product_id );
		$subscriber = new EDD_Recurring_Subscriber( $subscription->customer_id );

		if ( is_page( 'account' ) ) {
			$action_url = edd_get_current_page_url() . '#tabs=1';
		} else {
			$action_url = remove_query_arg( array( 'subscription_id', 'updated' ), edd_get_current_page_url() );
		}

		?>

		<?php /*
		<a href="<?php echo $action_url; ?>">&larr;&nbsp;<?php _e( 'Back', 'edd-recurring' ); ?></a>
		*/ ?>

		<p><a href="<?php echo $action_url; ?>" class="button"><?php _e( 'Go back', 'edd-recurring' ); ?></a></p>

		<h3><?php printf( __( 'Update payment method for <em>%s</em>', 'edd-recurring' ), $download->post_title ); ?></h3>
		<form action="<?php echo $action_url; ?>" id="edd-recurring-form" method="POST">
			<input name="edd-recurring-update-gateway" type="hidden" value="<?php echo $subscription->gateway; ?>" />
			<?php echo wp_nonce_field( 'update-payment', 'edd_recurring_update_nonce', true, false ); ?>

			<div id="edd_checkout_form_wrap">
				<?php
				do_action( 'edd_recurring_before_update', $subscription_id );

				do_action( 'edd_recurring_update_payment_form', $subscription );

				do_action( 'edd_recurring_after_update', $subscription_id );
				?>
			</div>

			<input type="hidden" name="edd_action" value="recurring_update_payment" />
			<input type="hidden" name="subscription_id" value="<?php echo $subscription->id; ?>" />
			<input type="submit" name="edd-recurring-update-submit" id="edd-recurring-update-submit" value="<?php echo esc_attr( __( 'Update Payment Method', 'edd-recurring' ) ); ?>" />
		</form>
	<?php else : ?>
		<p class="edd-no-purchases edd-alert edd-alert-error"><?php _e( 'Invalid Subscription ID', 'edd-recurring' ); ?></p>
	<?php endif; //end if subscription

endif; //end is_user_logged_in()
