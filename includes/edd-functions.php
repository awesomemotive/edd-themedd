<?php

/**
 * Remove download meta styling
 */
remove_action( 'wp_head', 'edd_download_meta_styles' );

/**
 * Add categories icon to download meta
 */
function themedd_download_meta_icon_categories() {
	?>
	<img src="<?php echo get_template_directory_uri() . '/images/svgs/download-categories.svg'; ?>" width="24" />
	<?php
}
add_action( 'edd_download_meta_categories', 'themedd_download_meta_icon_categories' );

/**
 * Add tags icon to download meta
 */
function themedd_download_meta_icon_tags() {
	?>
	<img src="<?php echo get_template_directory_uri() . '/images/svgs/download-tags.svg'; ?>" width="24" />
	<?php
}
add_action( 'edd_download_meta_tags', 'themedd_download_meta_icon_tags' );

/**
 * Add last updated icon
 */
function themedd_download_meta_icon_last_updated() {
	?>

	<img src="<?php echo get_template_directory_uri() . '/images/svgs/download-last-updated.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_last_updated', 'themedd_download_meta_icon_last_updated' );

/**
 * Add release date icon
 */
function themedd_download_meta_icon_release_date() {
	?>

	<img src="<?php echo get_template_directory_uri() . '/images/svgs/download-released.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_release_date', 'themedd_download_meta_icon_release_date' );

/**
 * Add documentation icon
 */
function themedd_download_meta_icon_documentation() {
	?>

	<img src="<?php echo get_template_directory_uri() . '/images/svgs/download-documentation.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_documentation', 'themedd_download_meta_icon_documentation' );

/**
 * Add version icon
 */
function themedd_download_meta_icon_version() {
	?>

	<img src="<?php echo get_template_directory_uri() . '/images/svgs/download-version.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_version', 'themedd_download_meta_icon_version' );


/**
 * Remove and deactivate all styling included with EDD
 *
 * @since 1.0
 */
remove_action( 'wp_enqueue_scripts', 'edd_register_styles' );

/**
 * Remove the purchase link at the bottom of the download page
 *
 * @since 1.0
 */
remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 */
function themedd_edd_body_classes( $classes ) {
	global $post;

	// add a shop class if we're on a page where the [downloads] shortcode is used
	if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'downloads' ) ) {
		$classes[] = 'edd-shop';
	}

	$cart_items = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : '';

	if ( $cart_items ) {
		$classes[] = 'items-in-cart';
	}

	return $classes;
}
add_filter( 'body_class', 'themedd_edd_body_classes' );

/**
 * Is EDD Software Licensing active
 */
function themedd_is_edd_sl_active() {
	return class_exists( 'EDD_Software_Licensing' );
}

/**
 * EDD purchase link defaults
 *
 * @since 1.0
 */
function themedd_purchase_link_defaults( $defaults ) {
	// add a class of "small" to the add to cart button
	if ( is_singular( 'download' ) ) {
		$defaults['class'] .= ' wide';
	}


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

// get EDD currency
$currency = function_exists( 'edd_get_currency' ) ? edd_get_currency() : '';


/**
 * Wrap currency symbol in span
 *
 * @since 1.0
 */
function themedd_currency_before( $formatted, $currency, $price ) {

	// prevent filter when returning discount amount at checkout
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return $formatted;
	}

	$symbol = edd_currency_symbol( $currency );

	if ( $symbol ) {
		$formatted = '<span class="currency">' . $symbol . '</span>' . $price;
	}

	return $formatted;
}
add_filter( 'edd_' . strtolower( $currency ) . '_currency_filter_before', 'themedd_currency_before', 10, 3 );

/**
 * Wrap currency symbol in span
 *
 * @since 1.0
 */
function themedd_currency_after( $formatted, $currency, $price ) {

	// prevent filter when returning discount amount at checkout
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return $formatted;
	}

	$symbol = edd_currency_symbol( $currency );

	if ( $symbol ) {
		$formatted = $price . '<span class="currency">' . $symbol . '</span>';
	}

	return $formatted;
}

// remove decimal places when not needed
add_filter( 'edd_' . strtolower( $currency ) . '_currency_filter_after', 'themedd_currency_after', 10, 3 );

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
 * The combined price and purchase button shown on the single download page
 *
 * @since 1.0.0
 */
function themedd_edd_pricing() {
	?>
	<aside>
		<?php echo themedd_edd_price(); ?>
		<?php themedd_edd_purchase_link(); ?>
	</aside>
<?php
}
add_action( 'themedd_sidebar_download', 'themedd_edd_pricing' );

/**
 * Filter the purchase link defaults
 *
 * @since 1.0.0
 */
function themedd_edd_purchase_link_defaults( $args ) {

	// free downloads
	if ( edd_is_free_download( get_the_ID() ) ) {
		$args['text'] = __( 'Add to cart', 'themedd' );
	}

	return $args;
}
add_filter( 'edd_purchase_link_defaults', 'themedd_edd_purchase_link_defaults' );

/**
 * Lightboxes
 */
function themedd_load_popup() {

	if ( themedd_enable_popup() ) :
	?>
	<script type="text/javascript">

		jQuery(document).ready(function($) {

		//inline
		$('.popup-content').magnificPopup({
			type: 'inline',
			fixedContentPos: true,
			fixedBgPos: true,
			overflowY: 'scroll',
			closeBtnInside: true,
			preloader: false,
			callbacks: {
				beforeOpen: function() {
				this.st.mainClass = this.st.el.attr('data-effect');
				}
			},
			midClick: true,
			removalDelay: 300
        });

		});
	</script>

<?php endif;
}
add_action( 'wp_footer', 'themedd_load_popup', 100 );


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
 * Determine where the cart link icon should be displayed
 * @since 1.0.0
 */
function themedd_cart_link_position() {
	return apply_filters( 'themedd_cart_link_position', 'secondary_menu' );
}

/**
 * Append extra links to primary navigation
 *
 * @since 1.0.0
*/
function themedd_wp_nav_menu_items( $items, $args ) {

	if ( 'primary' !== $args->theme_location ) {
		return $items;
	}

	$items = apply_filters( 'themedd_wp_nav_menu_items', $items );

	if ( 'primary_menu' == themedd_cart_link_position() ) {
		$items .= themedd_edd_cart_link();
	}

    return $items;

}
add_filter( 'wp_nav_menu_items', 'themedd_wp_nav_menu_items', 10, 2 );


 // $items = apply_filters( "wp_nav_menu_{$menu->slug}_items", $items, $args );

/**
 * Add cart link to secondary menu
 *
 * @since 1.0.0
 */
function themedd_secondary_menu_after() {

	if ( 'secondary_menu' !== themedd_cart_link_position() ) {
		return;
	}

    echo themedd_edd_cart_link( array( 'list_item' => false ) );
}
add_action( 'themedd_secondary_menu_after', 'themedd_secondary_menu_after' );

/**
 * Add cart link to mobile menu
 *
 * @since 1.0.0
 */
function themedd_menu_toggle_before() {
    echo themedd_edd_cart_link( array( 'list_item' => false, 'classes' => array( 'mobile' ) ) );
}
add_action( 'themedd_menu_toggle_before', 'themedd_menu_toggle_before' );

/**
 * Append buy now link to main navigation
 *
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
		<li class="action checkout menu-item">
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
 * @since 1.0
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
 * Make the total quantity blank when no items exist in the cart
 */
function themedd_edd_get_cart_quantity( $total_quantity, $cart ) {

	if ( ! $cart ) {
		$total_quantity = '';
	}

	return $total_quantity;
}
add_filter( 'edd_get_cart_quantity', 'themedd_edd_get_cart_quantity', 10, 2 );
