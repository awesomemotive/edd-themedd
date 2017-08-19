<?php

/**
 * EDD - Points and Rewards
 */
class Themedd_EDD_Points_And_Rewards {

	/**
	 * Get things started.
	 *
	 * @access  public
	 * @since   1.0.0
	*/
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );

		// Remove default message before content.
		global $edd_points_render;

		remove_action( 'edd_before_download_content', array( $edd_points_render, 'edd_points_message_content' ) );

		// Points message.
		add_action( 'themedd_edd_download_info_price_after', array( $edd_points_render, 'edd_points_message_content' ), 10, 1 );

		// Remove the "Complete your order and earn 20 Points for a discount on a future purchase." and re-hook it with new callback.
		remove_action( 'edd_before_purchase_form', array( $edd_points_render, 'edd_points_checkout_message_content' ) );
		add_action( 'edd_before_purchase_form', array( $this, 'checkout_message' ) );

		// Rehook "Use 2000 Points for a $20 discount on this order." message with "Apply Discount" button.
		remove_action( 'edd_before_purchase_form', array( $edd_points_render, 'edd_points_redeem_point_markup' ) );
		add_action( 'edd_before_purchase_form', array( $this, 'redeem_points' ) );

	}

	/**
	 * Styles.
	 *
	 * @access public
	 * @since  1.0.0
	*/
	public function styles() {

		// Dequeue styles
	    wp_dequeue_style( 'edd-points-public-style' );

		// Get the suffix (.min) if SCRIPT_DEBUG is enabled.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Get the file path of the CSS file.
		$file_path = '/assets/css/edd-points-and-rewards' . $suffix . '.css';

		// Register the styles.
		wp_register_style( 'themedd-edd-points-and-rewards', get_theme_file_uri( $file_path ), array(), filemtime( get_theme_file_path( $file_path ) ), 'all' );

		// Enqueue the styles.
		wp_enqueue_style( 'themedd-edd-points-and-rewards' );

	}

	/**
	 * Show message for checkout/redeemed product point.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function checkout_message( $postid ) {

		global $edd_options, $current_user, $edd_points_render;

		$edd_points_msg = $edd_options['edd_points_cart_messages'];

		// Get cart data.
		$cartdata = edd_get_cart_contents();

		// Total points earned.
		$totalpoints_earned = $edd_points_render->model->edd_points_get_user_checkout_points( $cartdata );

		// Points label.
		$points_label = $edd_points_render->model->edd_points_get_points_label( $totalpoints_earned );

		$points_replace   = array( "{points}", "{points_label}" );
		$replace_message  = array( $totalpoints_earned, $points_label );
		$message          = $edd_points_render->model->edd_points_replace_array( $points_replace, $replace_message, $edd_points_msg );

		if ( ! empty( $message ) && ! empty( $totalpoints_earned ) ) {
			echo '<div class="edd-alert edd-alert-info"><p>' . $message . '</p></div>';
		}

	}

	/**
	 * Redeem Points Markup
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function redeem_points() {

		global $current_user, $edd_options, $edd_points_render;

		if ( ! isset( $_GET['payment-mode'] ) && count( edd_get_enabled_payment_gateways() ) > 1 && ! edd_is_ajax_enabled() ) {
			return; // Only show once a payment method has been selected if ajax is disabled
		}

		// get points plural label
		$plurallabel = isset( $edd_options['edd_points_label']['plural'] ) && !empty( $edd_options['edd_points_label']['plural'] ) ? $edd_options['edd_points_label']['plural'] : 'Point';

		// get discount got by user via points
		$gotdiscount = EDD()->fees->get_fee( 'points_redeem' );

		// get message from settings
		$redemptionmessage = $edd_options['edd_points_reedem_cart_messages'];

		//calculate discount towards points
		$available_discount = $edd_points_render->model->edd_points_get_discount_for_redeeming_points();

		$button_color = isset( $edd_options['checkout_color'] ) ? $edd_options['checkout_color'] : '';

		if ( ! empty( $available_discount ) && !empty( $redemptionmessage ) && empty( $gotdiscount ) ) {

			//get discounte price from points
			$discountedpoints = $edd_points_render->model->edd_points_calculate_points( $available_discount );

			//get points label to show to user
			$points_label = $edd_points_render->model->edd_points_get_points_label( $discountedpoints );

			//display price to show to user
			$displaydiscprice = edd_currency_filter( $available_discount );

			//show message on checkout page
			$points_replace  = array( "{points}","{points_label}", "{points_value}" );
			$replace_message = array( $discountedpoints , $points_label, $displaydiscprice );
			$message		 = $edd_points_render->model->edd_points_replace_array( $points_replace, $replace_message, $redemptionmessage );

			?>
			<div class="edd-points-redeem-points-wrap">
				<p class="edd-points-redeem-message"><?php echo $message; ?></p>
				<form method="POST" action="">
					<input type="submit" id="edd_points_apply_discount" name="edd_points_apply_discount" class="button edd-submit <?php echo $button_color; ?> edd-points-apply-discount-button" value="<?php _e( 'Apply Discount', 'eddpoints' ); ?>" />
				</form>
			</div>
			<?php

		} //end if cart total not empty

		//if points discount applied then show remove link
		if ( ! empty( $gotdiscount ) ) {

			$removfeesurl = add_query_arg( array( 'edd_points_remove_discount' => 'remove' ), edd_get_current_page_url() );
			?>
				<div class="edd-points-checkout-message">
					<p class="edd-points-remove-discount-message"><?php printf( __( 'Remove %s Discount', 'eddpoints' ), $plurallabel ); ?></p>
					<a href="<?php echo $removfeesurl;?>" class="button edd-point-remove-discount-link edd-points-float-right"><?php _e( 'Remove', 'eddpoints' ); ?></a>
				</div>
			<?php
		}
	}

}
new Themedd_EDD_Points_And_Rewards;
