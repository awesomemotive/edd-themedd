<?php
/**
 * Modifications to EDD's checkout template file.
 */

/**
 * Renders the Discount Code field which allows users to enter a discount code.
 * This field is only displayed if there are any active discounts on the site else
 * it's not displayed.
 *
 * @since 1.1
 * @return void
*/
function themedd_edd_discount_field() {

	if ( isset( $_GET['payment-mode'] ) && edd_is_ajax_disabled() ) {
		return; // Only show before a payment method has been selected if ajax is disabled
	}

	if ( ! edd_is_checkout() ) {
		return;
	}

	if ( edd_has_active_discounts() && edd_get_cart_total() ) :

		$color = edd_get_option( 'checkout_color', 'blue' );
		$color = ( $color == 'inherit' ) ? '' : $color;
		$style = edd_get_option( 'button_style', 'button' );
	?>
		<fieldset id="edd_discount_code" class="mb-4">
			<div id="edd_show_discount" style="display:none;">
				<?php _e( 'Have a discount code?', 'easy-digital-downloads' ); ?> <a href="#" class="edd_discount_link"><?php echo _x( 'Click to enter it', 'Entering a discount code', 'easy-digital-downloads' ); ?></a>
			</div>
			<div id="edd-discount-code-wrap" class="edd-cart-adjustment">
				<label class="edd-label" for="edd-discount">
					<?php _e( 'Discount', 'easy-digital-downloads' ); ?>
				</label>
				<span class="edd-description"><?php _e( 'Enter a coupon code if you have one.', 'easy-digital-downloads' ); ?></span>
				<div class="edd-discount-code-field-wrap input-group">
					<input class="edd-input form-control" type="text" id="edd-discount" name="edd-discount" placeholder="<?php _e( 'Enter discount', 'easy-digital-downloads' ); ?>"/>
					<input type="submit" class="edd-apply-discount btn btn-primary edd-submit <?php echo $color . ' ' . $style; ?>" value="<?php echo _x( 'Apply', 'Apply discount at checkout', 'easy-digital-downloads' ); ?>" />
				</div>

				<span class="edd-discount-loader edd-loading" id="edd-discount-loader" style="display:none;"></span>
				<div id="edd-discount-error-wrap" class="alert alert-danger mt-3" role="alert" aria-hidden="true" style="display:none;"></div>
			</div>
		</fieldset>
<?php
	endif;
}
remove_action( 'edd_checkout_form_top', 'edd_discount_field', -1 );
add_action( 'edd_checkout_form_top', 'themedd_edd_discount_field', -1 );