<?php

/**
 * Download price
 *
 * @since 1.0.0
 */
function themedd_edd_price() {

	if ( edd_is_free_download( get_the_ID() ) ) {
		 $price = '<span class="edd_price">' . __( 'Free', 'themedd' ) . '</span>';
	} elseif (  edd_has_variable_prices( get_the_ID() ) ) {
		$price =  '<div itemprop="price" class="edd_price">' . __( 'From', 'themedd' ) . ' ' . edd_price( get_the_ID(), false ) . '</div>';
	} else {
		$price = edd_price( get_the_ID() );
	}

	return $price;

}

if ( ! function_exists( 'themedd_edd_purchase_link' ) ) :
/**
 * Download purchase link
 *
 * @since 1.0.0
 */
function themedd_edd_purchase_link() {

	$external_download_url  = function_exists( 'edd_download_meta_get_download_meta' ) ? edd_download_meta_get_download_meta( '_edd_download_meta_url' ) : '';
	$external_download_text = apply_filters( 'themedd_external_download_text', __( 'Visit site', 'themedd' ) );

	if ( $external_download_url ) { ?>

		<div class="edd_download_purchase_form">
			<a href="<?php echo esc_url( $external_download_url ); ?>" class="button wide external" target="_blank">
				<span><?php echo $external_download_text; ?></span>
				<svg class="external" width="16px" height="16px">
					<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-external'; ?>"></use>
				</svg>
			</a>
		</div>

		<?php
	} else {
		echo edd_get_purchase_link();
	}

}
endif;

/**
 * Determine where the cart link icon should be displayed
 * @since 1.0.0
 */
function themedd_edd_cart_link_position() {
	return apply_filters( 'themedd_edd_cart_link_position', 'secondary_menu' );
}

/**
 * Cart link in main navigation
 *
 * @since 1.0.0
 * @return [type] [description]
 */
function themedd_edd_cart_link( $args = array() ) {

    if ( ! apply_filters( 'themedd_show_nav_cart', true ) ) {
        return;
    }

    ob_start();

	$defaults = apply_filters( 'themedd_edd_cart_link_defaults',
		array(
			'classes'   => array( 'animate' ),
			'cart_link' => function_exists( 'edd_get_checkout_uri' ) ? edd_get_checkout_uri() : '',
			'list_item' => isset( $args['list_item'] ) && $args['list_item'] === false ? false : true
		)
	);

	$cart_items = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : '';
	$defaults['classes'][] = ! $cart_items ? 'empty' : '';

	$args = wp_parse_args( $args, $defaults );

    $cart_items   = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : '';

	// whether or not to include list item markup
	$list_item = $args['list_item'];

	// cart link
	$cart_link = $args['cart_link'];

	// CSS classes
	$classes = $args['classes'] ? ' ' . implode( ' ', $args['classes'] ) : '';

	if ( ! ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) ) : ?>

        <?php if ( $list_item ) : ?>
		<li class="nav-action checkout menu-item">
        <?php endif; ?>

			<a class="nav-cart<?php echo $classes; ?>" href="<?php echo $cart_link; ?>">
                <?php echo themedd_edd_cart_icon(); ?>
            </a>
        <?php if ( $list_item ) : ?>
		</li>
        <?php endif; ?>

	<?php endif;

    $content = ob_get_contents();
    ob_end_clean();

    return $content;

    ?>

<?php }

/**
 * The cart icon
 *
 * @since 1.0.0
 */
function themedd_edd_cart_icon() {
    $cart_items = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : '';

	ob_start();
?>

	<?php if ( apply_filters( 'themedd_edd_cart_icon_count', true ) ) : ?>
	<span class="cart-count"><span class="edd-cart-quantity"><?php echo edd_get_cart_quantity(); ?></span></span>
	<?php endif; ?>

	<svg id="nav-cart-icon" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
		<defs>
		<style>
			.cart-frame {
				fill: none;
			}
		</style>
		</defs>
		<?php if ( $cart_items ) : ?>
		  <title><?php _e( 'Checkout now', 'themedd' ); ?></title>
		<?php else : ?>
		  <title><?php _e( 'Go to checkout', 'themedd' ); ?></title>
		<?php endif; ?>
		<g id="frame">
			<rect class="cart-frame" width="48" height="48" />
		</g>
		<g id="cart">
			<circle class="cart-wheel" cx="34.7" cy="37" r="3"/>
			<circle class="cart-wheel" cx="22.6" cy="37" r="3"/>
		<?php if ( $cart_items && apply_filters( 'themedd_edd_cart_icon_full', false ) ) : ?>
			<path class="cart-items" d="M40.7,13.2c0.3-0.7,0.1-1.5-0.5-1.9l-4.6-3c-0.1,0-0.1-0.1-0.2-0.1c-0.8-0.4-1.7-0.1-2,0.7l-3.3,6.4v-2.7v0
				c0-0.8-0.7-1.5-1.5-1.5h-6c0,0,0,0-0.1,0c-0.8,0.1-1.5,0.8-1.4,1.6v3h3v-1.5h3v1.5h6.3l1.9-3.9l2,1.3l-1.3,2.5h3.4L40.7,13.2z"/>
		<?php endif; ?>
			<path class="cart-main" d="M16.5,9.5h-6.1v3h4.9l4.3,18.6c0.2,0.7,0.8,1.2,1.5,1.2h15.3c0.7,0,1.3-0.5,1.5-1.2l3-12.2c0-0.1,0-0.2,0-0.3
			c0-0.8-0.7-1.5-1.5-1.5H19.4L18,10.7C17.8,10,17.2,9.5,16.5,9.5L16.5,9.5z"/>
		</g>
	</svg>

    <?php

	$content = apply_filters( 'themedd_edd_cart_icon', ob_get_contents(), $cart_items );
    ob_end_clean();

    return $content;
}

/**
 * Determine if a customer can upgrade their license (Software licensing plugin)
 *
 * @since 1.0.0
 */
function themedd_edd_can_upgrade_license() {

	if ( ! themedd_is_edd_sl_active() ) {
		return;
	}

	$can_upgrade = false;

	$license_keys = edd_software_licensing()->get_license_keys_of_user();

	if ( $license_keys ) {
		foreach ( $license_keys as $license ) {
			 if ( edd_sl_license_has_upgrades( $license->ID ) && 'expired' !== edd_software_licensing()->get_license_status( $license->ID ) ) {
				$can_upgrade = true;
				break;
			 }
		}
	}

	return $can_upgrade;

}
