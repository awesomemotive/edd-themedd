<?php
/**
 * Download grid functions
 */

/**
 * Downloads list wrapper classes
 * These classes are applied wherever a downloads grid is outputted and used by:
 *
 * 1. The [downloads] shortcode
 * 2. archive-download.php
 * 3. taxonomy-download_category.php
 * 4. taxonomy-download_tag.php
 *
 * @since 1.0.0
 *
 * @param string $wrapper_class The class passed in from the [downloads] shortcode
 * @param array $atts The shortcode args passed in from the [downloads] shortcode
 *
 * @return string $classes The classes to be added
 */
function themedd_edd_downloads_list_wrapper_classes( $wrapper_class = '', $atts = array() ) {

	// Get the download grid options.
	$options = themedd_edd_download_grid_options();

	// Set up default $classes array.
	$classes = array( $wrapper_class );

	// [downloads] shortcode is being used
	if ( ! empty( $atts ) ) {

		// Add downloads class.
		$classes[] = 'edd_download_columns_' . $atts['columns'];

		$has_price   = $atts['price'] == 'yes' ? true : false;
		$has_excerpt = $atts['excerpt'] == 'yes' ? true : false;
		$buy_button  = $atts['buy_button'] == 'yes' ? true : false;
		$thumbnails  = $atts['thumbnails'] == 'true' ? true : false;

	} else {
		/**
		 * The download grid is being outputted by either:
		 *
		 * archive-download.php
		 * taxonomy-download_category.php
		 * taxonomy-download_tag.php
		 */

		// The [downloads] shortcode already has the following class applied so only add it for archive-download.php, taxonomy-download_category.php and taxonomy-download_tag.php.
		$classes[] = 'edd_downloads_list';

		// Add downloads class.
		$classes[] = 'edd_download_columns_' . $options['columns'];

		$has_price   = true === $options['price'] ? true : false;
		$has_excerpt = true === $options['excerpt'] ? true : false;
		$buy_button  = true === $options['buy_button'] ? true : false;
		$thumbnails  = true === $options['thumbnails'] ? true : false;

	}

	$classes[] = true === $has_price ? 'has-price' : 'no-price';
	$classes[] = true === $has_excerpt ? 'has-excerpt' : '';
	$classes[] = true === $buy_button ? 'has-buy-button' : 'no-buy-button';
	$classes[] = true === $thumbnails ? 'has-thumbnails' : 'no-thumbnails';

	// Add has-download-meta class.
	$classes[] = themedd_edd_has_download_meta() ? 'has-download-meta' : '';

	$classes = implode( ' ', array_filter( $classes ) );

	// Finally, make sure that any classes can be added via EDD's filter
	$classes = apply_filters( 'edd_downloads_list_wrapper_class', $classes, $atts );

	return $classes;
}

/**
 * Download grid options.
 *
 * Used by all download grids:
 * 
 * via the [downloads] shortcode
 * archive-download.php
 * taxonomy-download_category.php
 * taxonomy-download_tag.php
 *
 * @since 1.0.0
 * 
 * @param array $atts Attributes from [downloads] shortcode (if passed in).
 * 
 * @return array $options Download grid options
 */
function themedd_edd_download_grid_options( $atts = array() ) {

	/**
	 * Do some homekeeping on the [downloads] shortcode.
	 * 
	 * Converts the various "yes", "no, "true" etc into a format that the $options array uses.
	 */
	if ( ! empty( $atts ) ) {
		
		// Buy button.
		if ( isset( $atts['buy_button'] ) && 'yes' === $atts['buy_button'] ) {
			$atts['buy_button'] = true;
		}

		// Price.
		if ( isset( $atts['price'] ) && 'yes' === $atts['price'] ) {
			$atts['price'] = true;
		}

		// Excerpt.
		if ( isset( $atts['excerpt'] ) && 'yes' === $atts['excerpt'] ) {
			$atts['excerpt'] = true;
		}

		// Full content.
		if ( isset( $atts['full_content'] ) && 'yes' === $atts['full_content'] ) {
			$atts['full_content'] = true;
		}

		// Thumbnails.
		if ( isset( $atts['thumbnails'] ) ) {
			if ( 'true' === $atts['thumbnails'] || 'yes' === $atts['thumbnails'] ) {
				$atts['thumbnails'] = true;
			}
		}

	}

	// Options.
	$options = array(
		'title'        => true, // This is unique to Themedd.
		'excerpt'      => true,
		'full_content' => false,
		'price'        => true,
		'buy_button'   => true,
		'columns'      => 3,
		'thumbnails'   => true,
		'pagination'   => true,
		'number'       => 9,
		'order'        => 'DESC',
		'orderby'      => 'post_date'
	);

	// Merge the arrays.
	$options = wp_parse_args( $atts, $options );

	// Return the options.
	return apply_filters( 'themedd_edd_download_grid_options', $options );

}

/**
 * The download footer
 *
 * Appears at the bottom of a download in the download grid.
 * The download grid appears:
 *
 * 1. Wherever the [downloads] shortcode is used.
 * 2. The custom post type archive page (/downloads), unless it has been disabled.
 * 3. archive-download.php
 * 4. taxonomy-download_category.php
 * 5. taxonomy-download_tag.php
 *
 * @param array $atts Attributes from [downloads] shortcode.
 * @since 1.0.0
 */
function themedd_edd_download_footer( $atts = array() ) {

	// Pass the shortcode options into the download grid options.
	$download_grid_options = themedd_edd_download_grid_options( $atts );

	// Get the download ID.
	$download_id = get_the_ID();

	/**
	 * Show the download footer.
	 *
	 * The download footer will be shown if one of the following is true:
	 * 
	 * - The price is shown.
	 * - The buy button is shown.
	 * - The download meta is loaded into the download footer.
	 * - The themedd_edd_download_footer filter hook has been set to true.
	 */
	if (
		true === $download_grid_options['buy_button']                                ||
		true === $download_grid_options['price']                                     ||
		true === apply_filters( 'themedd_edd_download_footer', false, $download_id ) ||
		'after' === themedd_edd_download_meta_position()
	) : 
	?>

	<div class="downloadFooter">
		<?php

		/**
		 * Fires at the start of the download footer.
		 *
		 * @since 1.0.2
		 * @since 1.0.3 Added $download_id
		 * 
		 * @param int $download_id The ID of the download.
		 */
		do_action( 'themedd_edd_download_footer_start', $download_id );

		/**
		 * Show the price.
		 */
		if ( true === $download_grid_options['price'] ) :
			edd_get_template_part( 'shortcode', 'content-price' );
			do_action( 'edd_download_after_price', $download_id );
		endif;

		/**
		 * Show the buy button.
		 */
		if ( true === $download_grid_options['buy_button'] ) {
			edd_get_template_part( 'shortcode', 'content-cart-button' );
		}

		/**
		 * Fires at the end of the download footer.
		 *
		 * @since 1.0.2
		 * @since 1.0.3 Added $download_id
		 * 
		 * @param int $download_id The ID of the download.
		 */
		do_action( 'themedd_edd_download_footer_end', $download_id );

		?>
	</div>
	<?php endif; ?>

	<?php
}

/**
 * The price shown in the download meta
 *
 * @since 1.0.0
 * @uses themedd_edd_price()
 */
if ( ! function_exists( 'themedd_edd_download_meta_price' ) ):
	function themedd_edd_download_meta_price() {
		return themedd_edd_price();
	}
endif;
