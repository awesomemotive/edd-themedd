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
 * @param array $args
 *
 * @return array $classes The classes to be added
 */
function themedd_edd_downloads_list_wrapper_classes( $args = array() ) {

	$defaults = array(
		'atts'    => array(),
		'classes' => array()
	);

	$args = wp_parse_args( $args, $defaults );

	// Get the download grid options.
	$options = themedd_edd_download_grid_options();

	$atts = $args['atts'];

	// Set up default $classes array.
	$classes = $args['classes'];

	// [downloads] shortcode is being used
	if ( ! empty( $atts ) ) {

		$has_price   = $atts['price'] == 'yes' ? true : false;
		$has_excerpt = $atts['excerpt'] == 'yes' ? true : false;
		$buy_button  = $atts['buy_button'] == 'yes' ? true : false;
		$thumbnails  = $atts['thumbnails'] == 'true' ? true : false;

		$align_class = isset( $atts['align'] ) && ! empty( $atts['align'] ) ? $atts['align'] : '';

		$classes[] = 'edd_download_columns_' . $atts['columns'];

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

		$has_price   = true === $options['price'] ? true : false;
		$has_excerpt = true === $options['excerpt'] ? true : false;
		$buy_button  = true === $options['buy_button'] ? true : false;
		$thumbnails  = true === $options['thumbnails'] ? true : false;

		// Add columns class. This is already defined by the shortcode but we need to add it again to make it available.
		$classes[] = 'edd_download_columns_' . $options['columns'];

	}

	// If no align has been set in themedd_edd_download_grid_options(), add one if it was passed in.
	if ( empty( $options['align'] ) ) {
		$classes[] = ! empty( $align_class ) ? 'align' . $align_class : '';
	} else {
		// Not empty, it's been filtered, so add it
		$classes[] = 'align' . $options['align'];
	}

	$classes[] = true === $has_price ? 'has-price' : 'no-price';
	$classes[] = true === $has_excerpt ? 'has-excerpt' : '';
	$classes[] = true === $buy_button ? 'has-buy-button' : 'no-buy-button';
	$classes[] = true === $thumbnails ? 'has-thumbnails' : 'no-thumbnails';

	$classes[] = 'mb-10';

	// Add has-download-meta class.
	$classes[] = themedd_edd_has_download_meta() ? 'has-download-meta' : '';

	$classes = array_values( array_filter( array_unique( $classes ) ) );

	return apply_filters( 'themedd_edd_downloads_list_wrapper_classes', $classes );
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
		'orderby'      => 'post_date',
		'align'        => '',
		'size'         => 'themedd-standard-image'
	);

	// Set alignment to "wide" for various pages.
	if (
		is_post_type_archive( 'download' ) ||
		is_tax( 'download_category' ) ||
		is_tax( 'download_tag' ) ||
		is_search()
	) {
		$options['align'] = 'wide';
	}

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

	$defaults = apply_filters( 'themedd_edd_download_footer_defaults',
		array(
			'footer_classes' => array( 'mt-auto' )
		)
	);

	$atts = wp_parse_args( $atts, $defaults );

	$atts['footer_classes'][] = 'edd-download-footer';

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

	<div<?php themedd_classes( array( 'classes' => $atts['footer_classes'], 'context' => 'download_footer' ) ); ?>>
		<?php

		/**
		 * Fires at the start of the download footer.
		 *
		 * @since 1.0.2
		 * @since 1.0.3 Added $download_id
		 *
		 * @param int $download_id The ID of the download.
		 */
		do_action( 'themedd_edd_download_footer_start', $download_id, $download_grid_options );

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
		do_action( 'themedd_edd_download_footer_end', $download_id, $download_grid_options );

		?>
	</div>
	<?php endif; ?>

	<?php
}