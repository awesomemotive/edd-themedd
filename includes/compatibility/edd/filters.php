<?php

/**
 * Remove the purchase button from the Download Details widget,
 * if the themedd_edd_price_outside_button filter is set to true
 *
 * @since 1.0.0
 */
function themedd_edd_download_details_widget_purchase_button( $purchase_link, $download_id ) {

	if ( themedd_edd_price_enhancements() ) {
		return '';
	}

}
add_filter( 'edd_product_details_widget_purchase_button', 'themedd_edd_download_details_widget_purchase_button', 10, 2 );

/**
 * Filter the settings from EDD's "Styles" tab (pre EDD v3.0)
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
	unset( $settings['button_text']['checkout_color'] );
	unset( $settings['main']['checkout_color'] );

	// Remove the button style selector.
	unset( $settings['button_text']['button_style'] );

	return $settings;
}
add_filter( 'edd_settings_misc', 'themedd_edd_settings_styles' );

/**
 * For EDD 2.x, use the `edd_settings_styles` filter to remove style settings.
 *
 * @return void
 */
if ( ! function_exists( 'edd_get_orders' ) ) {
	add_filter( 'edd_settings_styles', 'themedd_edd_settings_styles' );
}

/**
 * Filter the purchase link defaults
 *
 * @since 1.0.0
 */
function themedd_edd_purchase_link_defaults( $defaults ) {

	// Remove button class.
	$defaults['color'] = '';

	// Remove the price from the purchase button
	if ( themedd_edd_price_enhancements() ) {
		$defaults['price'] = (bool) false;
	}

	$classes = explode( ' ', $defaults['class'] );

	// Make the button larger on single download page.
	if ( is_singular( 'download' ) ) {
		$classes[] = 'btn-lg';
	}

	$defaults['class'] = implode( ' ', $classes );

	return $defaults;

}
add_filter( 'edd_purchase_link_defaults', 'themedd_edd_purchase_link_defaults' );

/**
 * Filter the [downloads] shortcode's default attributes.
 *
 * @since 1.0.0 Filtered the price
 * @since 1.0.3 Filtered other attributes
 *
 * @param array  $out       The output array of shortcode attributes.
 * @param array  $pairs     The supported attributes and their defaults.
 * @param array  $atts      The user defined shortcode attributes.
 * @param string $shortcode The shortcode name.
 *
 * @return array $out       The output array of shortcode attributes.
 */
function themedd_edd_shortcode_atts_downloads( $out, $pairs, $atts, $shortcode ) {

	/**
	 * Get the download grid options.
	 */
	$download_grid_options = themedd_edd_download_grid_options( $out );

	/**
	 * Filter the pagination.
	 *
	 * @since 1.0.3
	 */
	if ( false === $download_grid_options['pagination'] ) {
		$out['pagination'] = 'false';
	} else if ( true === $download_grid_options['pagination'] ) {
		$out['pagination'] = 'true';
	}

	/**
	 * Sets the number of download columns shown.
	 *
	 * @since 1.0.3
	 */
	$out['columns'] = $download_grid_options['columns'];

	/**
	 * Sets the number of downloads shown.
	 *
	 * @since 1.0.3
	 */
	$out['number'] = $download_grid_options['number'];

	/**
	 * Sets the "order".
	 *
	 * @since 1.0.3
	 */
	$out['order'] = $download_grid_options['order'];

	/**
	 * Sets the "orderby"
	 *
	 * @since 1.0.3
	 */
	$out['orderby'] = $download_grid_options['orderby'];

	/**
	 * Sets the price attribute to "yes" automatically if not set on the [downloads] shortcode.
	 *
	 * @since 1.0.0
	 */
	if ( ! isset( $atts['price'] ) && false !== $download_grid_options['price'] ) {
		$out['price'] = 'yes';
	}

	/**
	 * Adds an "align" shortcode attribute
	 *
	 * @since 1.1
	 */
	if ( isset( $atts['align'] ) ) {
		if ( 'wide' === $atts['align'] ) {
			$out['align'] = 'wide';
		}

		if ( 'full' === $atts['align'] ) {
			$out['align'] = 'full';
		}
	}

	return $out;

}
add_filter( 'shortcode_atts_downloads', 'themedd_edd_shortcode_atts_downloads', 10, 4 );

/**
 * Set the default EDD checkout image size.
 *
 * @since 1.0
 */
function themedd_edd_checkout_image_size() {
	return array( 100, 50 );
}
add_filter( 'edd_checkout_image_size', 'themedd_edd_checkout_image_size' );

/**
 * Renders the Purchase button on the Checkout.
 *
 * @since 1.0.0
 */
function themedd_edd_checkout_button_purchase() {
	$label = edd_get_checkout_button_purchase_label();
	ob_start();
?>
	<div id="edd-purchase-button-wrap">
		<input type="submit" class="edd-submit btn-lg btn-block" id="edd-purchase-button" name="edd-purchase" value="<?php echo $label; ?>" />
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

		$classes[] = 'edd-items-in-cart';

		if ( edd_is_checkout() && themedd_edd_distraction_free_checkout() ) {
			$classes[] = 'edd-checkout-distraction-free';
		}

	} else {
		$classes[] = 'edd-empty-cart';
	}


	return $classes;

}
add_filter( 'body_class', 'themedd_edd_body_classes' );

/**
 * Filter the downloads list wrapper class.
 *
 * @since 1.1
 *
 * @return string $classes The classes of the download wrapper
 */
function themedd_edd_downloads_list_wrapper_class( $classes, $atts ) {

	// Explode the $classes into an array to make it easier to work with.
	$classes = explode( ' ', $classes );

	$classes[] = themedd_edd_downloads_list_wrapper_classes( '', $atts );

	// Implode back into class names.
	return implode( ' ', $classes );

}
add_filter( 'edd_downloads_list_wrapper_class', 'themedd_edd_downloads_list_wrapper_class', 10, 2 );

/**
 * Filter the download class.
 *
 * @since 1.0.2
 *
 * @return string $class Classes for each download.
 */
function themedd_edd_download_class( $class, $download_id, $atts, $i ) {

	$themedd_classes = array();

	if ( themedd_edd_has_download_meta() ) {
		// Add classes based on the position of the download meta.
		switch ( themedd_edd_download_meta_position() ) {

			case 'before_title':
				$themedd_classes['download_meta_position'] = 'edd-download-meta-before-title';
				break;

			case 'after_title':
				$themedd_classes['download_meta_position'] = 'edd-download-meta-after-title';
				break;

			case 'after':
				$themedd_classes['download_meta_position'] = 'edd-download-meta-after';
				break;

		}
	}

	// Change classes based on column count.
	$options = themedd_edd_download_grid_options();

	// Get column count from shortcode attributes.
	if ( isset( $atts['columns'] ) ) {
		$columns = $atts['columns'];
	} else {
		// Else get column count from download grid options.
		$columns = $options['columns'];
	}

	// Columns.
	if ( $columns ) {

		switch ( $columns ) {

			case 1:
				$themedd_classes['column_classes'] = 'col-12';
				break;

			case 2:
				$themedd_classes['column_classes'] = 'col-12 col-lg-6';
				break;

			case 3:
				$themedd_classes['column_classes'] = 'col-12 col-lg-4';
				break;

			case 4:
				$themedd_classes['column_classes'] = 'col-12 col-md-6 col-xl-3';
				break;

		}

	}

	// Margin.
	$themedd_classes['margin'] = 'mb-7';

	// Return the original $class string with our new classes appended to the end.
	return $class .= ' ' . themedd_output_classes( apply_filters( 'themedd_edd_download_classes', $themedd_classes ) );

}
add_filter( 'edd_download_class', 'themedd_edd_download_class', 10, 4 );

/**
 * Filter the download inner class.
 *
 * @since 1.1
 *
 * @return string $classes The classes
 */
function themedd_edd_download_inner_class( $classes, $download_id, $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) {

	$classes = explode( ' ', $classes );

	$download_grid_options = themedd_edd_download_grid_options( $edd_download_shortcode_item_atts );

	return implode( ' ', $classes );

}
add_filter( 'edd_download_inner_class', 'themedd_edd_download_inner_class', 10, 4 );

/**
 * Filter the content of the [downloads] shortcode for EDD versions below v2.8.
 *
 * This:
 *
 * 1. Removes unneeded markup such as the clearing divs
 * 2. Adds a themedd_edd_download_footer() function. This houses the purchase button (if enabled) and the download meta
 */
function themedd_edd_downloads_shortcode( $display, $atts, $buy_button, $columns, $null, $downloads, $excerpt, $full_content, $price, $thumbnails, $query ) {

	/**
	 * Return early if using EDD 2.8 or later.
	 * The new edd_templates/shortcode-download.php template file now outputs the download grid.
	 */
	if ( version_compare( EDD_VERSION, '2.8', '>=' ) ) {
		return $display;
	}

	$i = 1;

	$wrapper_class = 'edd_download_columns_' . $columns;
	$download_grid_options = themedd_edd_download_grid_options( $atts );
	ob_start();

	?>
	<div class="edd_downloads_list <?php echo apply_filters( 'edd_downloads_list_wrapper_class', $wrapper_class, $atts ); ?>">
		<?php while ( $downloads->have_posts() ) : $downloads->the_post(); ?>
			<div class="<?php echo apply_filters( 'edd_download_class', 'edd_download', get_the_ID(), $atts, $i ); ?>" id="edd_download_<?php echo get_the_ID(); ?>">
				<div class="<?php echo apply_filters( 'edd_download_inner_class', 'edd_download_inner', get_the_ID(), $atts, $i ); ?>">
					<?php

					do_action( 'edd_download_before' );

					if ( true === $download_grid_options['thumbnails'] ) {
						edd_get_template_part( 'shortcode', 'content-image' );
						do_action( 'edd_download_after_thumbnail' );
					}

					do_action( 'edd_download_before_title' );

					if ( true === $download_grid_options['title'] ) {
						edd_get_template_part( 'shortcode', 'content-title' );
					}

					do_action( 'edd_download_after_title' );

					if ( true === $download_grid_options['excerpt'] && true !== $download_grid_options['full_content'] ) {
						// Show the excerpt.
						edd_get_template_part( 'shortcode', 'content-excerpt' );

						do_action( 'edd_download_after_content' );
					} elseif ( true === $download_grid_options['full_content'] ) {
						// Show the full content.
						edd_get_template_part( 'shortcode', 'content-full' );

						do_action( 'edd_download_after_content' );
					}

					/**
					 * Download footer
					 */
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

/**
 * Disable schema.org microdata until EDD core implements JSON-LD.
 * https://github.com/easydigitaldownloads/easy-digital-downloads/issues/5240
 *
 * @since 1.0.5
 * @return bool
 */
function themedd_edd_schema_microdata( $ret ) {
	return false;
}
add_filter( 'edd_add_schema_microdata', 'themedd_edd_schema_microdata', 10, 1 );

/**
 * Filter the item quantity input on the download grid.
 *
 * @since 1.1
 */
function themedd_edd_purchase_form_quantity_input( $quantity_input, $download_id, $args ) {
	ob_start();
	?>
	<div class="edd_download_quantity_wrapper">
		<input type="number" min="1" step="1" name="edd_download_quantity" class="edd-input edd-item-quantity form-control mb-2" value="1" />
	</div>
	<?php
	return ob_get_clean();
}
add_filter( 'edd_purchase_form_quantity_input', 'themedd_edd_purchase_form_quantity_input', 10, 3 );

/**
 * Filter the empty cart message.
 *
 * @since 1.1
 */
function themedd_edd_empty_cart_message() {

	$classes = array( 'edd_empty_cart' );

	if ( in_array( 'no-sidebar', get_body_class() ) ) {
		$classes[] = 'text-center';
	}

	// Center the empty cart message.
	return '<div class="' . themedd_output_classes( $classes ) . '">' . __( 'Your cart is empty.', 'themedd' ) . '</div>';
}
add_filter( 'edd_empty_cart_message', 'themedd_edd_empty_cart_message' );
