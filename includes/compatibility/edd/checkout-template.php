<?php
/**
 * Modifications to EDD's checkout template file.
 *
 * @since 1.1
 */

// Remove EDD's edd_user_info_fields actions
remove_action( 'edd_purchase_form_after_user_info', 'edd_user_info_fields' );
remove_action( 'edd_register_fields_before', 'edd_user_info_fields' );

add_action( 'edd_purchase_form_after_user_info', 'themedd_edd_user_info_fields' );
add_action( 'edd_register_fields_before', 'themedd_edd_user_info_fields' );

/**
 * Shows the User Info fields in the Personal Info box, more fields can be added
 * via the hooks provided.
 *
 * @since 1.1
 * @return void
 * 
 * @todo Open issue on this to make it easier to edit.
 */
function themedd_edd_user_info_fields() {

	$customer = EDD()->session->get( 'customer' );
	$customer = wp_parse_args( $customer, array( 'first_name' => '', 'last_name' => '', 'email' => '' ) );

	if ( is_user_logged_in() ) {
		$user_data = get_userdata( get_current_user_id() );

		foreach( $customer as $key => $field ) {

			if ( 'email' == $key && empty( $field ) ) {
				$customer[ $key ] = $user_data->user_email;
			} elseif ( empty( $field ) ) {
				$customer[ $key ] = $user_data->$key;
			}

		}
	}

	$customer = array_map( 'sanitize_text_field', $customer );
	?>
	<fieldset id="edd_checkout_user_info" class="p-3 p-sm-4 bg-light mb-3 mb-sm-5">
		<legend><?php echo apply_filters( 'edd_checkout_personal_info_text', esc_html__( 'Personal Info', 'easy-digital-downloads' ) ); ?></legend>
		<?php do_action( 'edd_purchase_form_before_email' ); ?>

		<div class="form-group" id="edd-email-wrap">
			<label class="edd-label" for="edd-email">
				<?php esc_html_e( 'Email Address', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'edd_email' ) ) { ?>
					<span class="required">*</span>
				<?php } ?>
			</label>
			<input class="edd-input required form-control" type="email" name="edd_email" placeholder="<?php esc_html_e( 'Email address', 'easy-digital-downloads' ); ?>" id="edd-email" value="<?php echo esc_attr( $customer['email'] ); ?>" aria-describedby="edd-email-description"<?php if( edd_field_is_required( 'edd_email' ) ) {  echo ' required '; } ?>/>
			<small class="edd-description form-text text-muted" id="edd-email-description"><?php esc_html_e( 'We will send the purchase receipt to this address.', 'easy-digital-downloads' ); ?></small>
		</div>

		<?php do_action( 'edd_purchase_form_after_email' ); ?>
		
		<div class="form-group" id="edd-first-name-wrap">
			<label class="edd-label" for="edd-first">
				<?php esc_html_e( 'First Name', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'edd_first' ) ) { ?>
					<span class="required">*</span>
				<?php } ?>
			</label>
			<input class="edd-input required form-control" type="text" name="edd_first" placeholder="<?php esc_html_e( 'First Name', 'easy-digital-downloads' ); ?>" id="edd-first" value="<?php echo esc_attr( $customer['first_name'] ); ?>"<?php if( edd_field_is_required( 'edd_first' ) ) {  echo ' required '; } ?> aria-describedby="edd-first-description" />
			<small class="edd-description form-text text-muted" id="edd-first-description"><?php esc_html_e( 'We will use this to personalize your account experience.', 'easy-digital-downloads' ); ?></small>
		</div>
		
		<div class="form-group" id="edd-last-name-wrap">
			<label class="edd-label" for="edd-last">
				<?php esc_html_e( 'Last Name', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'edd_last' ) ) { ?>
					<span class="required">*</span>
				<?php } ?>
			</label>
			
			<input class="edd-input form-control<?php if( edd_field_is_required( 'edd_last' ) ) { echo ' required'; } ?>" type="text" name="edd_last" id="edd-last" placeholder="<?php esc_html_e( 'Last Name', 'easy-digital-downloads' ); ?>" value="<?php echo esc_attr( $customer['last_name'] ); ?>"<?php if( edd_field_is_required( 'edd_last' ) ) {  echo ' required '; } ?> aria-describedby="edd-last-description" />
			<small class="edd-description form-text text-muted" id="edd-last-description"><?php esc_html_e( 'We will use this as well to personalize your account experience.', 'easy-digital-downloads' ); ?></small>
		</div>

		<?php do_action( 'edd_purchase_form_user_info' ); ?>
		<?php do_action( 'edd_purchase_form_user_info_fields' ); ?>

	</fieldset>
	<?php
}

/**
 * Outputs the default credit card address fields
 *
 * @since 1.1
 * @return void
 */
function themedd_edd_default_cc_address_fields() {

	$logged_in = is_user_logged_in();
	$customer  = EDD()->session->get( 'customer' );
	$customer  = wp_parse_args( $customer, array( 'address' => array(
		'line1'   => '',
		'line2'   => '',
		'city'    => '',
		'zip'     => '',
		'state'   => '',
		'country' => ''
	) ) );

	$customer['address'] = array_map( 'sanitize_text_field', $customer['address'] );

	if( $logged_in ) {

		$user_address = get_user_meta( get_current_user_id(), '_edd_user_address', true );

		foreach( $customer['address'] as $key => $field ) {

			if ( empty( $field ) && ! empty( $user_address[ $key ] ) ) {
				$customer['address'][ $key ] = $user_address[ $key ];
			} else {
				$customer['address'][ $key ] = '';
			}

		}

	}

	/**
	 * Billing Address Details.
	 *
	 * Allows filtering the customer address details that will be pre-populated on the checkout form.
	 *
	 * @since 2.8
	 *
	 * @param array $address The customer address.
	 * @param array $customer The customer data from the session
	 */
	$customer['address'] = apply_filters( 'edd_checkout_billing_details_address', $customer['address'], $customer );

	ob_start(); ?>
	<fieldset id="edd_cc_address" class="cc-address p-3 p-sm-4 bg-light">
		<legend><?php _e( 'Billing Details', 'easy-digital-downloads' ); ?></legend>
		<?php do_action( 'edd_cc_billing_top' ); ?>

		<div class="form-group" id="edd-card-address-wrap">
			<label for="card_address" class="edd-label">
				<?php _e( 'Billing Address', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'card_address' ) ) { ?>
					<span class="required">*</span>
				<?php } ?>
			</label>
			<input type="text" id="card_address" name="card_address" class="card-address edd-input form-control<?php if( edd_field_is_required( 'card_address' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Address line 1', 'easy-digital-downloads' ); ?>" value="<?php echo $customer['address']['line1']; ?>"<?php if( edd_field_is_required( 'card_address' ) ) {  echo ' required '; } ?>/>
			<small class="edd-description form-text text-muted"><?php _e( 'The primary billing address for your credit card.', 'easy-digital-downloads' ); ?></small>
		</div>

		<div class="form-group" id="edd-card-address-2-wrap">
			<label for="card_address_2" class="edd-label">
				<?php _e( 'Billing Address Line 2 (optional)', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'card_address_2' ) ) { ?>
					<span class="required">*</span>
				<?php } ?>
			</label>
			
			<input type="text" id="card_address_2" name="card_address_2" class="card-address-2 edd-input form-control<?php if( edd_field_is_required( 'card_address_2' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Address line 2', 'easy-digital-downloads' ); ?>" value="<?php echo $customer['address']['line2']; ?>"<?php if( edd_field_is_required( 'card_address_2' ) ) {  echo ' required '; } ?>/>
			<small class="edd-description form-text text-muted"><?php _e( 'The suite, apt no, PO box, etc, associated with your billing address.', 'easy-digital-downloads' ); ?></small>
		</div>

		<div class="form-group" id="edd-card-city-wrap">
			<label for="card_city" class="edd-label">
				<?php _e( 'Billing City', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'card_city' ) ) { ?>
					<span class="required">*</span>
				<?php } ?>
			</label>
			
			<input type="text" id="card_city" name="card_city" class="card-city edd-input form-control<?php if( edd_field_is_required( 'card_city' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'City', 'easy-digital-downloads' ); ?>" value="<?php echo $customer['address']['city']; ?>"<?php if( edd_field_is_required( 'card_city' ) ) {  echo ' required '; } ?>/>
			<small class="edd-description form-text text-muted"><?php _e( 'The city for your billing address.', 'easy-digital-downloads' ); ?></small>
		</div>

		<div class="form-group" id="edd-card-zip-wrap">
			<label for="card_zip" class="edd-label">
				<?php _e( 'Billing Zip / Postal Code', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'card_zip' ) ) { ?>
					<span class="required">*</span>
				<?php } ?>
			</label>
			
			<input type="text" size="4" id="card_zip" name="card_zip" class="card-zip edd-input form-control<?php if( edd_field_is_required( 'card_zip' ) ) { echo ' required'; } ?>" placeholder="<?php _e( 'Zip / Postal Code', 'easy-digital-downloads' ); ?>" value="<?php echo $customer['address']['zip']; ?>"<?php if( edd_field_is_required( 'card_zip' ) ) {  echo ' required '; } ?>/>
			<small class="edd-description form-text text-muted"><?php _e( 'The zip or postal code for your billing address.', 'easy-digital-downloads' ); ?></small>
		</div>

		<div class="form-group" id="edd-card-country-wrap">
			<label for="billing_country" class="edd-label">
				<?php _e( 'Billing Country', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'billing_country' ) ) { ?>
					<span class="required">*</span>
				<?php } ?>
			</label>
			
			<select name="billing_country" id="billing_country" class="billing_country edd-select custom-select<?php if( edd_field_is_required( 'billing_country' ) ) { echo ' required'; } ?>"<?php if( edd_field_is_required( 'billing_country' ) ) {  echo ' required '; } ?>>
				<?php

				$selected_country = edd_get_shop_country();

				if( ! empty( $customer['address']['country'] ) && '*' !== $customer['address']['country'] ) {
					$selected_country = $customer['address']['country'];
				}

				$countries = edd_get_country_list();
				foreach( $countries as $country_code => $country ) {
				  echo '<option value="' . esc_attr( $country_code ) . '"' . selected( $country_code, $selected_country, false ) . '>' . $country . '</option>';
				}
				?>
			</select>
			<small class="edd-description form-text text-muted"><?php _e( 'The country for your billing address.', 'easy-digital-downloads' ); ?></small>
		</div>

		<div class="form-group" id="edd-card-state-wrap">
			<label for="card_state" class="edd-label">
				<?php _e( 'Billing State / Province', 'easy-digital-downloads' ); ?>
				<?php if( edd_field_is_required( 'card_state' ) ) { ?>
					<span class="required">*</span>
				<?php } ?>
			</label>
			
			<?php
			$selected_state = edd_get_shop_state();
			$states         = edd_get_shop_states( $selected_country );

			if( ! empty( $customer['address']['state'] ) ) {
				$selected_state = $customer['address']['state'];
			}

			if( ! empty( $states ) ) : ?>
			<select name="card_state" id="card_state" class="card_state edd-select custom-select<?php if( edd_field_is_required( 'card_state' ) ) { echo ' required'; } ?>">
				<?php
					foreach( $states as $state_code => $state ) {
						echo '<option value="' . $state_code . '"' . selected( $state_code, $selected_state, false ) . '>' . $state . '</option>';
					}
				?>
			</select>
			<?php else : ?>
			<?php $customer_state = ! empty( $customer['address']['state'] ) ? $customer['address']['state'] : ''; ?>
			<input type="text" size="6" name="card_state" id="card_state" class="card_state edd-input form-control" value="<?php echo esc_attr( $customer_state ); ?>" placeholder="<?php _e( 'State / Province', 'easy-digital-downloads' ); ?>"/>
			<?php endif; ?>
			<small class="edd-description form-text text-muted"><?php _e( 'The state or province for your billing address.', 'easy-digital-downloads' ); ?></small>
		</div>
		<?php do_action( 'edd_cc_billing_bottom' ); ?>
	</fieldset>
	<?php
	echo ob_get_clean();
}
remove_action( 'edd_after_cc_fields', 'edd_default_cc_address_fields' );
add_action( 'edd_after_cc_fields', 'themedd_edd_default_cc_address_fields' );


/**
 * Renders the Discount Code field which allows users to enter a discount code.
 * This field is only displayed if there are any active discounts on the site else
 * it's not displayed.
 *
 * @since 1.1
 * @return void
*/
function themedd_edd_discount_field() {

	if( isset( $_GET['payment-mode'] ) && edd_is_ajax_disabled() ) {
		return; // Only show before a payment method has been selected if ajax is disabled
	}

	if( ! edd_is_checkout() ) {
		return;
	}

	if ( edd_has_active_discounts() && edd_get_cart_total() ) :

		$color = edd_get_option( 'checkout_color', 'blue' );
		$color = ( $color == 'inherit' ) ? '' : $color;
		$style = edd_get_option( 'button_style', 'button' );
?>
		<fieldset id="edd_discount_code" class="mb-3">
			<div class="form-group" id="edd_show_discount" style="display:none;">
				<?php _e( 'Have a discount code?', 'easy-digital-downloads' ); ?> <a href="#" class="edd_discount_link"><?php echo _x( 'Click to enter it', 'Entering a discount code', 'easy-digital-downloads' ); ?></a>
			</div>
			<div id="edd-discount-code-wrap" class="edd-cart-adjustment">
				<label class="edd-label" for="edd-discount">
					<?php _e( 'Discount', 'easy-digital-downloads' ); ?>
				</label>
				
				<div class="edd-discount-code-field-wrap input-group">
					<input class="edd-input form-control" type="text" id="edd-discount" name="edd-discount" placeholder="<?php _e( 'Enter discount', 'easy-digital-downloads' ); ?>"/>
					<input type="submit" class="edd-apply-discount edd-submit button btn btn-primary <?php echo $color . ' ' . $style; ?>" value="<?php echo _x( 'Apply', 'Apply discount at checkout', 'easy-digital-downloads' ); ?>" />
				</div>
				<small class="edd-description form-text text-muted"><?php _e( 'Enter a coupon code if you have one.', 'easy-digital-downloads' ); ?></small>
				<span class="edd-discount-loader edd-loading" id="edd-discount-loader" style="display:none;"></span>
				<div id="edd-discount-error-wrap" class="alert alert-danger mt-3" role="alert" aria-hidden="true" style="display:none;"></div>
			</div>
		</fieldset>
<?php
	endif;
}
remove_action( 'edd_checkout_form_top', 'edd_discount_field', -1 );
add_action( 'edd_checkout_form_top', 'themedd_edd_discount_field', -1 );


/**
 * Renders the payment mode form by getting all the enabled payment gateways and
 * outputting them as radio buttons for the user to choose the payment gateway. If
 * a default payment gateway has been chosen from the EDD Settings, it will be
 * automatically selected.
 *
 * @since 1.1
 * @return void
 */
function themedd_edd_payment_mode_select() {
	$gateways = edd_get_enabled_payment_gateways( true );
	$page_URL = edd_get_current_page_url();
	$chosen_gateway = edd_get_chosen_gateway();
	?>
	<div id="edd_payment_mode_select_wrap" class="p-3 p-sm-4 bg-light mb-3 mb-sm-5">
		<?php do_action('edd_payment_mode_top'); ?>
		<?php if( edd_is_ajax_disabled() ) { ?>
		<form id="edd_payment_mode" action="<?php echo $page_URL; ?>" method="GET">
		<?php } ?>
			<fieldset id="edd_payment_mode_select">
				<legend><?php _e( 'Select Payment Method', 'easy-digital-downloads' ); ?></legend>
				<?php do_action( 'edd_payment_mode_before_gateways_wrap' ); ?>


				<div id="edd-payment-mode-wrap">
					<?php

					do_action( 'edd_payment_mode_before_gateways' );

					foreach ( $gateways as $gateway_id => $gateway ) :

						$label         = apply_filters( 'edd_gateway_checkout_label_' . $gateway_id, $gateway['checkout_label'] );
						$checked       = checked( $gateway_id, $chosen_gateway, false );
						$checked_class = $checked ? ' edd-gateway-option-selected' : '';
						?>

						<?php
						echo '<div class="d-block d-sm-inline-flex form-check form-check-inline">';
						
						echo '<input type="radio" name="payment-mode" class="edd-gateway form-check-input" id="edd-gateway-' . esc_attr( $gateway_id ) . '" value="' . esc_attr( $gateway_id ) . '"' . $checked . '>';
						
						echo '<label for="edd-gateway-' . esc_attr( $gateway_id ) . '" class="form-check-label edd-gateway-option' . $checked_class . '" id="edd-gateway-option-' . esc_attr( $gateway_id ) . '">' . esc_html( $label ) . '</label>';

						echo '</div>';

					endforeach;

					do_action( 'edd_payment_mode_after_gateways' );

					?>
				</div>
				<?php do_action( 'edd_payment_mode_after_gateways_wrap' ); ?>
			</fieldset>
			<fieldset id="edd_payment_mode_submit" class="edd-no-js">
				<p id="edd-next-submit-wrap">
					<?php echo edd_checkout_button_next(); ?>
				</p>
			</fieldset>
		<?php if( edd_is_ajax_disabled() ) { ?>
		</form>
		<?php } ?>
	</div>
	<div id="edd_purchase_form_wrap"></div><!-- the checkout fields are loaded into this-->

	<?php do_action('edd_payment_mode_bottom');
}
remove_action( 'edd_payment_mode_select', 'edd_payment_mode_select' );
add_action( 'edd_payment_mode_select', 'themedd_edd_payment_mode_select' );


/**
 * Show Payment Icons by getting all the accepted icons from the EDD Settings
 * then outputting the icons.
 *
 * @since 1.0
 * @return void
*/
function themedd_edd_show_payment_icons() {

	if( edd_show_gateways() && did_action( 'edd_payment_mode_top' ) ) {
		return;
	}

	$payment_methods = edd_get_option( 'accepted_cards', array() );

	if( empty( $payment_methods ) ) {
		return;
	}

	echo '<div class="edd-payment-icons mb-2 mb-sm-5">';

	foreach( $payment_methods as $key => $card ) {

		if( edd_string_is_image_url( $key ) ) {

			echo '<img class="payment-icon" src="' . esc_url( $key ) . '"/>';

		} else {

			$card = strtolower( str_replace( ' ', '', $card ) );

			if( has_filter( 'edd_accepted_payment_' . $card . '_image' ) ) {

				$image = apply_filters( 'edd_accepted_payment_' . $card . '_image', '' );

			} else {

				$image = edd_locate_template( 'images' . DIRECTORY_SEPARATOR . 'icons' . DIRECTORY_SEPARATOR . $card . '.png', false );

				// Replaces backslashes with forward slashes for Windows systems
				$plugin_dir  = wp_normalize_path( WP_PLUGIN_DIR );
				$content_dir = wp_normalize_path( WP_CONTENT_DIR );
				$image       = wp_normalize_path( $image );

				$image = str_replace( $plugin_dir, WP_PLUGIN_URL, $image );
				$image = str_replace( $content_dir, WP_CONTENT_URL, $image );

			}

			if( edd_is_ssl_enforced() || is_ssl() ) {

				$image = edd_enforced_ssl_asset_filter( $image );

			}

			echo '<img class="payment-icon" src="' . esc_url( $image ) . '"/>';
		}

	}

	echo '</div>';
}
remove_action( 'edd_payment_mode_top', 'edd_show_payment_icons' );
remove_action( 'edd_checkout_form_top', 'edd_show_payment_icons' );
add_action( 'edd_payment_mode_top', 'themedd_edd_show_payment_icons' );
add_action( 'edd_checkout_form_top', 'themedd_edd_show_payment_icons' );

/**
 * Shows the final purchase total at the bottom of the checkout page
 *
 * @since 1.5
 * @return void
 */
function themedd_edd_checkout_final_total() {
	?>
	<div id="edd_final_total_wrap" class="h2 text-center mb-3 mb-sm-5">
		<?php _e( 'Purchase Total:', 'easy-digital-downloads' ); ?>
		<span class="edd_cart_amount" data-subtotal="<?php echo edd_get_cart_subtotal(); ?>" data-total="<?php echo edd_get_cart_total(); ?>"><?php edd_cart_total(); ?></span>
	</div>
	<?php
	}
remove_action( 'edd_purchase_form_before_submit', 'edd_checkout_final_total', 999 );
add_action( 'edd_purchase_form_before_submit', 'themedd_edd_checkout_final_total', 999 );

/**
 * Renders the credit card info form.
 *
 * @since 1.1
 * @return void
 */
function themedd_edd_get_cc_form() {
	ob_start(); ?>

	<?php do_action( 'edd_before_cc_fields' ); ?>

	<fieldset id="edd_cc_fields" class="edd-do-validate p-3 p-sm-4 bg-light mb-3 mb-sm-5">
		<legend><?php _e( 'Credit Card Info', 'easy-digital-downloads' ); ?></legend>
		<?php if( is_ssl() ) : ?>
			<div id="edd_secure_site_wrapper">
				<span class="padlock">
					<svg class="edd-icon edd-icon-lock" xmlns="http://www.w3.org/2000/svg" width="18" height="28" viewBox="0 0 18 28" aria-hidden="true">
						<path d="M5 12h8V9c0-2.203-1.797-4-4-4S5 6.797 5 9v3zm13 1.5v9c0 .828-.672 1.5-1.5 1.5h-15C.672 24 0 23.328 0 22.5v-9c0-.828.672-1.5 1.5-1.5H2V9c0-3.844 3.156-7 7-7s7 3.156 7 7v3h.5c.828 0 1.5.672 1.5 1.5z"/>
					</svg>
				</span>
				<span><?php _e( 'This is a secure SSL encrypted payment.', 'easy-digital-downloads' ); ?></span>
			</div>
		<?php endif; ?>

		<div class="form-group" id="edd-card-number-wrap">
			<label for="card_number" class="edd-label">
				<?php _e( 'Card Number', 'easy-digital-downloads' ); ?>
				<span class="required">*</span>
				<span class="card-type"></span>
			</label>
			<input type="tel" pattern="^[0-9!@#$%^&* ]*$" autocomplete="off" name="card_number" id="card_number" class="card-number edd-input required form-control" placeholder="<?php _e( 'Card number', 'easy-digital-downloads' ); ?>" />
			<small class="edd-description form-text text-muted" id="edd-last-description"><?php esc_html_e( 'The (typically) 16 digits on the front of your credit card.', 'easy-digital-downloads' ); ?></small>
		</div>

		<div class="form-group" id="edd-card-cvc-wrap">
			<label for="card_cvc" class="edd-label">
				<?php _e( 'CVC', 'easy-digital-downloads' ); ?>
				<span class="required">*</span>
			</label>

			<input type="tel" pattern="[0-9]{3,4}" size="4" maxlength="4" autocomplete="off" name="card_cvc" id="card_cvc" class="card-cvc edd-input required form-control" placeholder="<?php _e( 'Security code', 'easy-digital-downloads' ); ?>" />
			<small class="edd-description form-text text-muted" id="edd-last-description"><?php esc_html_e( 'The 3 digit (back) or 4 digit (front) value on your card.', 'easy-digital-downloads' ); ?></small>
		</div>

		<div class="form-group" id="edd-card-name-wrap">
			<label for="card_name" class="edd-label">
				<?php _e( 'Name on the Card', 'easy-digital-downloads' ); ?>
				<span class="required">*</span>
			</label>
			
			<input type="text" autocomplete="off" name="card_name" id="card_name" class="card-name edd-input required form-control" placeholder="<?php _e( 'Card name', 'easy-digital-downloads' ); ?>" />
			<small class="edd-description form-text text-muted" id="edd-last-description"><?php esc_html_e( 'The name printed on the front of your credit card.', 'easy-digital-downloads' ); ?></small>
		</div>

		<?php do_action( 'edd_before_cc_expiration' ); ?>

		<div class="form-row card-expiration">
			<div class="form-group col-md-6">
				<label for="card_exp_month" class="edd-label">
					<?php _e( 'Expiration Month', 'easy-digital-downloads' ); ?>
					<span class="required">*</span>
				</label>
				
				<select id="card_exp_month" name="card_exp_month" class="card-expiry-month edd-select edd-select-small required custom-select">
					<?php for( $i = 1; $i <= 12; $i++ ) { echo '<option value="' . $i . '">' . sprintf ('%02d', $i ) . '</option>'; } ?>
				</select>
				<small class="edd-description form-text text-muted"><?php _e( 'The month your credit card expires, typically on the front of the card.', 'easy-digital-downloads' ); ?></small>
			</div>

			<div class="form-group col-md-6">
				<label for="card_exp_year" class="edd-label">
					<?php _e( 'Expiration Year', 'easy-digital-downloads' ); ?>
					<span class="required">*</span>
				</label>
				<select id="card_exp_year" name="card_exp_year" class="card-expiry-year edd-select edd-select-small required custom-select">
					<?php for( $i = date('Y'); $i <= date('Y') + 30; $i++ ) { echo '<option value="' . $i . '">' . substr( $i, 2 ) . '</option>'; } ?>
				</select>
				<small class="edd-description form-text text-muted"><?php _e( 'The year your credit card expires, typically on the front of the card.', 'easy-digital-downloads' ); ?></small>
			</div>

		</div>

		<?php do_action( 'edd_after_cc_expiration' ); ?>

	</fieldset>
	<?php
	do_action( 'edd_after_cc_fields' );

	echo ob_get_clean();
}
remove_action( 'edd_cc_form', 'edd_get_cc_form' );
add_action( 'edd_cc_form', 'themedd_edd_get_cc_form' );

/**
 * Stripe uses its own credit card form because the card details are tokenized.
 *
 * We don't want the name attributes to be present on the fields in order to prevent them from getting posted to the server.
 *
 * @since       1.1
 * @return      void
 */
function themedd_edds_credit_card_form( $echo = true ) {

	if ( ! themedd_is_edd_stripe_active() ) {
		return;
	}

	global $edd_options;

	if( edd_get_option( 'stripe_checkout', false ) ) {
		return;
	}

	ob_start(); ?>

	<?php if ( ! wp_script_is ( 'edd-stripe-js' ) ) : ?>
		<?php edd_stripe_js( true ); ?>
	<?php endif; ?>

	<?php do_action( 'edd_before_cc_fields' ); ?>

	<fieldset id="edd_cc_fields" class="edd-do-validate p-3 p-sm-4 bg-light mb-3 mb-sm-5">
		<legend><?php _e( 'Credit Card Info', 'edds' ); ?></legend>
		<?php if( is_ssl() ) : ?>
			<div id="edd_secure_site_wrapper">
				<span class="padlock">
					<svg class="edd-icon edd-icon-lock" xmlns="http://www.w3.org/2000/svg" width="18" height="28" viewBox="0 0 18 28" aria-hidden="true">
						<path d="M5 12h8V9c0-2.203-1.797-4-4-4S5 6.797 5 9v3zm13 1.5v9c0 .828-.672 1.5-1.5 1.5h-15C.672 24 0 23.328 0 22.5v-9c0-.828.672-1.5 1.5-1.5H2V9c0-3.844 3.156-7 7-7s7 3.156 7 7v3h.5c.828 0 1.5.672 1.5 1.5z"/>
					</svg>
				</span>
				<span><?php _e( 'This is a secure SSL encrypted payment.', 'edds' ); ?></span>
			</div>
		<?php endif; ?>

		<?php
		$user  = get_userdata( get_current_user_id() );
		$email = $user ? $user->user_email : '';
		$existing_cards = edd_stripe_get_existing_cards( $email );
		?>
		<?php if ( ! empty( $existing_cards ) ) { edd_stripe_existing_card_field_radio( get_current_user_id() ); } ?>

		<div class="edd-stripe-new-card" <?php if ( ! empty( $existing_cards ) ) { echo 'style="display: none;"'; } ?>>
			<?php do_action( 'edd_stripe_new_card_form' ); ?>
			<?php do_action( 'edd_after_cc_expiration' ); ?>
		</div>

	</fieldset>
	<?php

	do_action( 'edd_after_cc_fields' );

	$form = ob_get_clean();

	if ( false !== $echo ) {
		echo $form;
	}

	return $form;
}
remove_action( 'edd_stripe_cc_form', 'edds_credit_card_form' );
add_action( 'edd_stripe_cc_form', 'themedd_edds_credit_card_form' );


/**
 * Display the markup for the Stripe new card form
 *
 * @since 1.1
 * @return void
 */
function themedd_edd_stripe_new_card_form() {
	?>
	<div class="form-group" id="edd-card-number-wrap">
		<div class="d-flex justify-content-between">
			<label for="card_number" class="edd-label">
				<?php _e( 'Card Number', 'edds' ); ?>
				<span class="edd-required-indicator">*</span>
			</label>
			<span class="card-type"></span>
		</div>	
		<input type="tel" pattern="^[0-9!@#$%^&* ]*$" id="card_number" class="card-number edd-input required form-control" placeholder="<?php _e( 'Card number', 'edds' ); ?>" autocomplete="cc-number" />
		<small class="edd-description form-text text-muted" id="edd-last-description"><?php esc_html_e( 'The (typically) 16 digits on the front of your credit card.', 'edds' ); ?></small>
	</div>
	
	<div class="form-group" id="edd-card-cvc-wrap">
		<label for="card_cvc" class="edd-label">
			<?php _e( 'CVC', 'edds' ); ?>
			<span class="edd-required-indicator">*</span>
		</label>
		<input type="tel" pattern="[0-9]{3,4}" size="4" id="card_cvc" class="card-cvc edd-input required form-control" placeholder="<?php _e( 'Security code', 'edds' ); ?>" autocomplete="cc-csc" />
		<small class="edd-description form-text text-muted" id="edd-last-description"><?php esc_html_e( 'The 3 digit (back) or 4 digit (front) value on your card.', 'edds' ); ?></small>
	</div>

	<div class="form-group" id="edd-card-name-wrap">
		<label for="card_name" class="edd-label">
			<?php _e( 'Name on the Card', 'edds' ); ?>
			<span class="edd-required-indicator">*</span>
		</label>
		<input type="text" id="card_name" class="card-name edd-input required form-control" placeholder="<?php _e( 'Card name', 'edds' ); ?>" autocomplete="cc-name" />
		<small class="edd-description form-text text-muted" id="edd-last-description"><?php esc_html_e( 'The name printed on the front of your credit card.', 'edds' ); ?></small>
	</div>

	<?php do_action( 'edd_before_cc_expiration' ); ?>

	<div class="form-row card-expiration">
		<div class="form-group col-md-6">
			<label for="card_exp_month" class="edd-label">
				<?php _e( 'Expiration Month', 'edds' ); ?>
				<span class="required">*</span>
			</label>

			<select id="card_exp_month" name="card_exp_month" class="card-expiry-month edd-select edd-select-small required custom-select" autocomplete="cc-exp-month">
				<?php for( $i = 1; $i <= 12; $i++ ) { echo '<option value="' . $i . '">' . sprintf ('%02d', $i ) . '</option>'; } ?>
			</select>
			<small class="edd-description form-text text-muted"><?php _e( 'The month your credit card expires, typically on the front of the card.', 'edds' ); ?></small>

		</div>

		<div class="form-group col-md-6">
			<label for="card_exp_year" class="edd-label">
				<?php _e( 'Expiration Year', 'easy-digital-downloads' ); ?>
				<span class="required">*</span>
			</label>

			<select id="card_exp_year" name="card_exp_year" class="card-expiry-year edd-select edd-select-small required custom-select" autocomplete="cc-exp-year">
				<?php for( $i = date('Y'); $i <= date('Y') + 30; $i++ ) { echo '<option value="' . $i . '">' . substr( $i, 2 ) . '</option>'; } ?>
			</select>
			<small class="edd-description form-text text-muted"><?php _e( 'The year your credit card expires, typically on the front of the card.', 'edds' ); ?></small>
		</div>

	</div>

	<?php
}
remove_action( 'edd_stripe_new_card_form', 'edd_stripe_new_card_form' );
add_action( 'edd_stripe_new_card_form', 'themedd_edd_stripe_new_card_form' );