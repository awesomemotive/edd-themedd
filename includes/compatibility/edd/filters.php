<?php

/**
 * Remove the purchase button from the Download Details widget,
 * if the themedd_edd_price_outside_button filter is set to true
 *
 * @since 1.0.0
 */
function themedd_edd_download_details_widget_purchase_button( $purchase_link, $download_id ) {

	if ( apply_filters( 'themedd_edd_price_outside_button', true ) ) {
		return '';
	}

}
add_filter( 'edd_product_details_widget_purchase_button', 'themedd_edd_download_details_widget_purchase_button', 10, 2 );

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
function themedd_edd_purchase_link_defaults( $defaults ) {

	// Remove button class.
	$defaults['color'] = '';

	// Free downloads.
	if ( edd_is_free_download( get_the_ID() ) ) {
		$defaults['text'] = __( 'Add to cart', 'themedd' );
	}

	// Remove the price from the purchase button
	if ( apply_filters( 'themedd_edd_price_outside_button', true ) ) {
		$defaults['price'] = (bool) false;
	}

	return $defaults;

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

	if ( edd_is_checkout() && themedd_edd_distraction_free_checkout() && ! empty( edd_get_cart_contents() ) ) {
		$classes[] = 'edd-checkout-distraction-free';
	}

	return $classes;

}
add_filter( 'body_class', 'themedd_edd_body_classes' );


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

	/**
	 * Add a class if there is download meta
	 */
	if ( themedd_edd_has_download_meta() ) {
		$classes[] = 'has-download-meta';
	}

	return implode( ' ', $classes );

}
add_filter( 'edd_downloads_list_wrapper_class', 'themedd_edd_downloads_list_wrapper_class', 10, 2 );

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

/**
 * Filter the page header classes for the single download page.
 *
 * @since 1.0.0
 *
 * @return array $classes
 */
function themedd_edd_page_header_classes( $classes ) {

	if ( is_singular( 'download' ) ) {
		$classes[] = 'center-xs';
		$classes[] = 'mb-md-2';
	}

	return $classes;
}
add_filter( 'themedd_page_header_classes', 'themedd_edd_page_header_classes' );

/**
 * Filter the content of the [downloads] shortcode, at least until the downloads shortcode is a bit more flexible.
 *
 * This:
 *
 * 1. Removes unneeded markup such as the clearing divs
 * 2. Adds a themedd_edd_download_footer() function. This houses the purchase button (if enabled) and the download meta
 */
function themedd_edd_downloads_shortcode( $display, $atts, $buy_button, $columns, $null, $downloads, $excerpt, $full_content, $price, $thumbnails, $query ) {

	$i = 1;

	$wrapper_class = 'edd_download_columns_' . $columns;

	ob_start();

	?>
	<div class="edd_downloads_list <?php echo apply_filters( 'edd_downloads_list_wrapper_class', $wrapper_class, $atts ); ?>">
		<?php while ( $downloads->have_posts() ) : $downloads->the_post(); ?>
			<?php $schema = edd_add_schema_microdata() ? 'itemscope itemtype="http://schema.org/Product" ' : ''; ?>
			<div <?php echo $schema; ?>class="<?php echo apply_filters( 'edd_download_class', 'edd_download', get_the_ID(), $atts, $i ); ?>" id="edd_download_<?php echo get_the_ID(); ?>">
				<div class="<?php echo apply_filters( 'edd_download_inner_class', 'edd_download_inner', get_the_ID(), $atts, $i ); ?>">
					<?php

					do_action( 'edd_download_before' );

					if ( 'false' != $atts['thumbnails'] ) :
						edd_get_template_part( 'shortcode', 'content-image' );
						do_action( 'edd_download_after_thumbnail' );
					endif;

					do_action( 'edd_download_before_title' );

					edd_get_template_part( 'shortcode', 'content-title' );
					do_action( 'edd_download_after_title' );

					if ( $atts['excerpt'] == 'yes' && $atts['full_content'] != 'yes' ) {
						edd_get_template_part( 'shortcode', 'content-excerpt' );
						do_action( 'edd_download_after_content' );
					} else if ( $atts['full_content'] == 'yes' ) {
						edd_get_template_part( 'shortcode', 'content-full' );
						do_action( 'edd_download_after_content' );
					}

					if ( $atts['price'] == 'yes' ) {
						edd_get_template_part( 'shortcode', 'content-price' );
						do_action( 'edd_download_after_price' );
					}

					themedd_edd_download_footer( $atts );

					do_action( 'edd_download_after' );

					?>

				</div>
			</div>

		<?php $i++; endwhile; ?>

		<?php wp_reset_postdata(); ?>

		<?php if ( filter_var( $atts['pagination'], FILTER_VALIDATE_BOOLEAN ) ) : ?>

		<?php
			$pagination = false;

			if ( is_single() ) {
				$pagination = paginate_links( apply_filters( 'edd_download_pagination_args', array(
					'base'    => get_permalink() . '%#%',
					'format'  => '?paged=%#%',
					'current' => max( 1, $query['paged'] ),
					'total'   => $downloads->max_num_pages
				), $atts, $downloads, $query ) );
			} else {
				$big = 999999;
				$search_for   = array( $big, '#038;' );
				$replace_with = array( '%#%', '&' );
				$pagination = paginate_links( apply_filters( 'edd_download_pagination_args', array(
					'base'    => str_replace( $search_for, $replace_with, get_pagenum_link( $big ) ),
					'format'  => '?paged=%#%',
					'current' => max( 1, $query['paged'] ),
					'total'   => $downloads->max_num_pages
				), $atts, $downloads, $query ) );
			}
		?>

			<?php if ( ! empty( $pagination ) ) : ?>
			<div id="edd_download_pagination" class="navigation">
				<?php echo $pagination; ?>
			</div>
			<?php endif; ?>

		<?php endif; ?>

	</div>

	<?php

	$display = ob_get_clean();

	return $display;
}
add_filter( 'downloads_shortcode', 'themedd_edd_downloads_shortcode', 10, 11 );
