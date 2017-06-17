<?php

/**
 * Determine where the cart link should be displayed
 *
 * @since 1.0.0
 */
function themedd_edd_cart_link_position() {
	return apply_filters( 'themedd_edd_cart_link_position', 'secondary_menu' );
}

/**
 * Cart link in main navigation
 *
 * This link contains:
 *
 * 1. The cart icon
 * 2. The cart quantity
 * 3. The cart total
 *
 * @since 1.0.0
 * @return string
 */
function themedd_edd_cart_link( $args = array() ) {

    if ( ! apply_filters( 'themedd_nav_cart', true ) ) {
        return;
    }

    ob_start();

	// Set up defaults.
	$defaults = apply_filters( 'themedd_edd_cart_link_defaults',
		array(
			'classes'     => array( 'navCart' ),
			'cart_link'   => isset( $args['cart_link'] ) ? $args['cart_link'] : edd_get_checkout_uri(),
			'list_item'   => isset( $args['list_item'] ) && $args['list_item'] === false ? false : true,
			'text_before' => isset( $args['text_before'] ) ? $args['text_before'] : '',
			'text_after'  => isset( $args['text_after'] ) ? $args['text_after'] : '',
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

	if ( ! ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) ) : ?>

        <?php if ( $list_item ) : ?>
		<li class="nav-action checkout menu-item">
        <?php endif; ?>

			<a class="<?php echo implode( ' ', array_filter( $args['classes'] ) ); ?>" href="<?php echo $cart_link; ?>">

				<?php

				if ( themedd_edd_display_cart_icon() ) {
					echo themedd_edd_cart_icon();
				}

				if ( $args['text_before'] ) {
					echo '<span class="navCart-textBefore">' . $args['text_before'] . '</span>';
				}

				echo '<span class="navCart-cartQuantityAndTotal">';

				if ( 'all' === themedd_edd_display_cart_options() || 'item_quantity' === themedd_edd_display_cart_options() ) {
					echo themedd_edd_cart_quantity();
				}

				if ( 'all' === themedd_edd_display_cart_options() || 'cart_total' === themedd_edd_display_cart_options() ) {
					echo themedd_edd_cart_total();
				}

				if ( $args['text_after'] ) {
					echo '<span class="navCart-textAfter">' . $args['text_after'] . '</span>';
				}

				echo '</span>';

				?>

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
	<div class="navCart-icon">
		<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414"><path fill="none" d="M0 0h24v24H0z"/><path d="M5.1.5c.536 0 1 .37 1.12.89l1.122 4.86H22.35c.355 0 .688.163.906.442.217.28.295.644.21.986l-2.3 9.2c-.128.513-.588.872-1.116.872H8.55c-.536 0-1-.37-1.12-.89L4.185 2.8H.5V.5h4.6z" fill-rule="nonzero"/><circle cx="6" cy="20" r="2" transform="matrix(-1.14998 0 0 1.14998 25.8 -1.8)"/><circle cx="14" cy="20" r="2" transform="matrix(-1.14998 0 0 1.14998 25.8 -1.8)"/></svg>
	</div>
	<?php

	$content = apply_filters( 'themedd_edd_cart_icon', ob_get_contents() );
    ob_end_clean();

    return $content;
}

/**
 * Cart quantity
 *
 * @since 1.0.0
 *
 * @return string cart quantity
 */
function themedd_edd_cart_quantity() {

	// Cart quantity.
	$count = edd_get_cart_quantity();

	if ( empty( edd_get_cart_quantity() ) ) {
		$count = '0';
	}

	$cart_quantity = '<span class="edd-cart-quantity">' . $count . '</span>'; // This class name must match exactly in order for EDD to update the count
	$cart_quantity = apply_filters( 'themedd_edd_cart_quantity', $cart_quantity );

	// Cart quantity text.
	$cart_quantity_text = themedd_cart_quantity_text();

	if ( apply_filters( 'themedd_edd_cart_quantity_text', true ) ) {
		// Set the default to be plural. Used for anything greater than 1 or 0.
		// Example: 0 items, 2 items.
		$item_text = ' ' . $cart_quantity_text['plural'];

		// Show the singular if there's only 1 item in cart.
		if ( 1 === edd_get_cart_quantity() ) {
			$item_text = ' ' . $cart_quantity_text['singular'];
		}

		$cart_quantity_text = '<span class="navCart-quantityText">' . $item_text . '</span>';

	} else {
		$cart_quantity_text = '';
	}

	?>
	<span class="navCart-quantity"><?php echo $cart_quantity; ?><?php echo $cart_quantity_text; ?></span>
	<?php
}

/**
 * Cart quantity text
 *
 * @since 1.0.0
 *
 * @return array cart quantity singular and plural name
 */
function themedd_cart_quantity_text() {

	$cart_quantity_text = apply_filters( 'themedd_cart_quantity_text', array(
		'singular' => __( 'item', 'themedd' ),
		'plural'   => __( 'items', 'themedd' )
	));

	return $cart_quantity_text;
}

/**
 * Cart total
 *
 * @since 1.0.0
 *
 * @return string cart total
 */
function themedd_edd_cart_total() {

	if ( 'all' === themedd_edd_display_cart_options() ) {
		$sep = apply_filters( 'themedd_edd_cart_total_separator', '-' );
		$sep = '<span class="navCart-cartTotalSeparator"> ' . $sep . ' </span>';
	} else {
		$sep = '';
	}

	?>
	<span class="navCart-total"><?php echo $sep; ?><span class="navCart-cartTotalAmount"><?php echo edd_currency_filter( edd_format_amount( edd_get_cart_total() ) ); ?></span></span>
	<?php
}

/**
 * Display cart icon
 *
 * @since 1.0.0
 *
 * @return boolean true if cart is enabled, false otherwise
 */
function themedd_edd_display_cart_icon() {
	$edd_theme_options = get_theme_mod( 'easy_digital_downloads' );

	// Set "true" to be the default if no options exist in theme mods array.
	if ( ! isset( $edd_theme_options['cart_icon'] ) ) {
		return true;
	}

	return $edd_theme_options['cart_icon'];
}

/**
 * Display cart options
 *
 * @since 1.0.0
 *
 * @return boolean true if cart is enabled, false otherwise
 */
function themedd_edd_display_cart_options() {
	$edd_theme_options = get_theme_mod( 'easy_digital_downloads' );

	return isset( $edd_theme_options['cart_options'] ) ? $edd_theme_options['cart_options'] : 'all';
}
