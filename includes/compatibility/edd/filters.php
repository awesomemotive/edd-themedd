<?php


/**
 * Filter the settings from EDD's "Styles" tab
 *
 * @since 1.0
 * @param array $settings The "Styles" tab settings array
 */
function themedd_edd_settings_styles( $settings ) {

	// Remove "Style Settings" heading.
	unset( $settings['main']['style_settings'] );

	// Remove "Disable Styles" option. Styling is already disabled and controlled via Themedd.
	unset( $settings['main']['disable_styles'] );

	// Remove "Default Button Color" option since Themedd controls all button styling
	unset( $settings['main']['checkout_color'] );

	return $settings;
}
add_filter( 'edd_settings_styles', 'themedd_edd_settings_styles' );

/**
 * Filter the purchase link defaults
 *
 * @since 1.0.0
 */
function themedd_edd_purchase_link_defaults( $args ) {

	// Remove button class.
	$args['color'] = '';

	// Free downloads.
	if ( edd_is_free_download( get_the_ID() ) ) {
		$args['text'] = __( 'Add to cart', 'themedd' );
	}

	return $args;
}
add_filter( 'edd_purchase_link_defaults', 'themedd_edd_purchase_link_defaults' );

/**
 * Set the default EDD checkout image size
 *
 * @since 1.0
 */
function themedd_edd_checkout_image_size() {
	return array( 100, 50 );
}
add_filter( 'edd_checkout_image_size', 'themedd_edd_checkout_image_size' );

/**
 * Append extra links to primary navigation
 *
 * @since 1.0.0
*/
function themedd_wp_nav_menu_items( $items, $args ) {

	$items = apply_filters( 'themedd_wp_nav_menu_items', $items );

	if ( 'primary_menu' == themedd_edd_cart_link_position() ) {
		$items .= themedd_edd_cart_link( array( 'text' => __( 'Checkout', 'themedd' ) ) );
	}

    return $items;

}
add_filter( 'wp_nav_menu_primary_items', 'themedd_wp_nav_menu_items', 10, 2 );

/**
 * Mobile navigation - Add cart link to mobile navigation
 *
 * @since 1.0.0
*/
function themedd_wp_nav_menu_mobile_items( $items, $args ) {

	$items = apply_filters( 'themedd_wp_nav_menu_items', $items );

	$mobile_cart_link = themedd_edd_cart_link(

		apply_filters( 'themedd_edd_mobile_menu', array(
			'list_item' => true,
			'classes'   => array( 'mobile' ),
			'text'      => __( 'Checkout', 'themedd' )
		) )

	);

    return $items . $mobile_cart_link;

}
add_filter( 'wp_nav_menu_mobile_items', 'themedd_wp_nav_menu_mobile_items', 10, 2 );

/**
 * Make the total quantity blank when no items exist in the cart
 *
 * @since 1.0.0
 */
function themedd_edd_get_cart_quantity( $total_quantity, $cart ) {

	if ( ! $cart ) {
		$total_quantity = '';
	}

	return $total_quantity;
}
add_filter( 'edd_get_cart_quantity', 'themedd_edd_get_cart_quantity', 10, 2 );


/**
 * Renders the Purchase button on the Checkout
 *
 * @since 1.0.0
 */
function themedd_edd_checkout_button_purchase() {

	$label = edd_get_option( 'checkout_label', '' );

	if ( edd_get_cart_total() ) {
		$complete_purchase = ! empty( $label ) ? $label : __( 'Purchase', 'easy-digital-downloads' );
	} else {
		$complete_purchase = ! empty( $label ) ? $label : __( 'Free Download', 'easy-digital-downloads' );
	}

	ob_start();
?>

	<div id="edd-purchase-button-wrap">
		<input type="submit" class="edd-submit" id="edd-purchase-button" name="edd-purchase" value="<?php echo $complete_purchase; ?>" />
	</div>

<?php
	return ob_get_clean();
}
add_filter( 'edd_checkout_button_purchase', 'themedd_edd_checkout_button_purchase', 10, 2 );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 */
function themedd_edd_body_classes( $classes ) {

	$cart_items = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : '';

	if ( $cart_items ) {
		$classes[] = 'items-in-cart';
	}

	if ( edd_is_checkout() && themedd_edd_distraction_free_checkout() ) {
		$classes[] = 'edd-checkout-distraction-free';
	}

	return $classes;

}
add_filter( 'body_class', 'themedd_edd_body_classes' );

/**
 * EDD purchase link defaults
 *
 * @since 1.0.0
 */
function themedd_purchase_link_defaults( $defaults ) {

	$defaults['price'] = (bool) false;

	return $defaults;

}
add_filter( 'edd_purchase_link_defaults', 'themedd_purchase_link_defaults' );

/**
 * Downloads wrapper classes
 *
 * @since 1.0.0
 */
function themedd_edd_downloads_list_wrapper_class( $wrapper_class, $atts ) {

	$classes = array( $wrapper_class );

	if ( $atts['price'] == 'yes' ) {
		$classes[] = 'has-price';
	} else {
		$classes[] = 'no-price';
	}

	if ( $atts['excerpt'] == 'yes' ) {
		$classes[] = 'has-excerpt';
	}

	if ( $atts['buy_button'] == 'yes' ) {
		$classes[] = 'has-buy-button';
	} else {
		$classes[] = 'no-buy-button';
	}

	if ( $atts['thumbnails'] ) {
		$classes[] = 'has-thumbnails';
	} else {
		$classes[] = 'no-thumbnails';
	}

	return implode( ' ', $classes );

}
add_filter( 'edd_downloads_list_wrapper_class', 'themedd_edd_downloads_list_wrapper_class', 10, 2 );

/**
 * Add classes to each EDD download
 *
 * @since 1.0.0
 */
function themedd_edd_download_class( $classes, $id, $atts, $i ) {

	$classes .= ' mb-xs-4 mb-sm-0';

	return $classes;

}
add_filter( 'edd_download_class', 'themedd_edd_download_class', 10, 4 );

/**
 * EDD Recurring
 * Modify URL to update payment method
 *
 * @since 1.0.0
 */
function themedd_edd_recurring_update_url( $url, $subscription ) {
	$url = add_query_arg( array( 'action' => 'update', 'subscription_id' => $subscription->id ), '#tabs=1' );

	return $url;
}
add_filter( 'edd_subscription_update_url', 'themedd_edd_recurring_update_url', 10, 2 );
