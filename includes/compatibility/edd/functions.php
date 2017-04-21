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

	if ( get_post_meta( get_the_ID(), '_edd_hide_purchase_link', true ) ) {
		return; // Do not show if auto output is disabled
	}
	
	$external_download_url  = function_exists( 'edd_download_meta_get_download_meta' ) ? edd_download_meta_get_download_meta( '_edd_download_meta_url' ) : '';
	$external_download_text = apply_filters( 'themedd_external_download_text', __( 'Visit site', 'themedd' ) );

	if ( $external_download_url ) { ?>

		<div class="edd_download_purchase_form">
			<a href="<?php echo esc_url( $external_download_url ); ?>" class="button wide external" target="_blank">
				<span><?php echo $external_download_text; ?></span>
				<svg class="external" width="16px" height="16px">
					<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/assets/images/svg-defs.svg#icon-external'; ?>"></use>
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
			'list_item' => isset( $args['list_item'] ) && $args['list_item'] === false ? false : true,
			'text'      => isset( $args['text'] ) ? $args['text'] : '',
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

	// text
	$text = $args['text'] ? '<span class="nav-cart-text">' . $args['text'] . '</span>' : '';

	// CSS classes
	$classes = $args['classes'] ? ' ' . implode( ' ', $args['classes'] ) : '';

	if ( ! ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) ) : ?>

        <?php if ( $list_item ) : ?>
		<li class="nav-action checkout menu-item">
        <?php endif; ?>

			<a class="nav-cart<?php echo $classes; ?>" href="<?php echo $cart_link; ?>">
                <?php echo themedd_edd_cart_icon(); ?> <?php echo $text; ?>
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
	ob_start();
?>

	<div class="nav-cart-icon">

		<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414"><path fill="none" d="M0 0h24v24H0z"/><path d="M5.1.5c.536 0 1 .37 1.12.89l1.122 4.86H22.35c.355 0 .688.163.906.442.217.28.295.644.21.986l-2.3 9.2c-.128.513-.588.872-1.116.872H8.55c-.536 0-1-.37-1.12-.89L4.185 2.8H.5V.5h4.6z" fill-rule="nonzero"/><circle cx="6" cy="20" r="2" transform="matrix(-1.14998 0 0 1.14998 25.8 -1.8)"/><circle cx="14" cy="20" r="2" transform="matrix(-1.14998 0 0 1.14998 25.8 -1.8)"/></svg>

		<?php if ( apply_filters( 'themedd_edd_cart_icon_count', true ) ) : ?>
		<span class="cart-count"><span class="edd-cart-quantity"><?php echo edd_get_cart_quantity(); ?></span></span>
		<?php endif; ?>

	</div>

<?php
	$content = apply_filters( 'themedd_edd_cart_icon', ob_get_contents() );
    ob_end_clean();

    return $content;

}
