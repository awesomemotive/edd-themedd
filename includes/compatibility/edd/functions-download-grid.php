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

	// Set up $classes array.
	$classes = array();

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

	return implode( ' ', array_filter( $classes ) );
}

/**
 * Download grid options.
 *
 * Used by:
 * archive-download.php
 * taxonomy-download_category.php
 * taxonomy-download_tag.php
 *
 * @since 1.0.0
 *
 * @return array $options Download grid options
 */
function themedd_edd_download_grid_options() {

	$options = array(
		'title'        => true,
		'excerpt'      => true,
		'full_content' => false,
		'price'        => true,
		'buy_button'   => true,
		'columns'      => 3,
		'thumbnails'   => true,
		'pagination'   => true,
		'number'       => 9
	);

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
 *
 * @since 1.0.0
 */
function themedd_edd_download_footer( $atts = array() ) {

	/**
	 * Show the download footer.
	 *
	 * The download footer will be shown if:
	 * 1. The price is shown.
	 * 2. The buy button is shown.
	 * 3. Another function is loaded onto the themedd_edd_download_footer_end hook.
	 */
	if ( themedd_edd_show_download_footer( $atts ) ) : ?>
	<div class="downloadFooter">
		<?php

		do_action( 'themedd_edd_download_footer_start' );

		/**
		 * Show the price.
		 */
		if ( themedd_edd_show_price( $atts ) ) :
			edd_get_template_part( 'shortcode', 'content-price' );
			do_action( 'edd_download_after_price' );
		endif;

		/**
		 * Show the buy button.
		 */
		if ( themedd_edd_show_buy_button( $atts ) ) {
			edd_get_template_part( 'shortcode', 'content-cart-button' );
		}

		// Used by the download meta.
		do_action( 'themedd_edd_download_footer_end' );

		?>
	</div>
	<?php endif; ?>

	<?php
}

/**
 * Determine if the download footer can be shown.
 * The download footer contains the buy button, the price and optionally the download meta.
 *
 * @since 1.0.0
 */
function themedd_edd_show_download_footer( $atts ) {

	if (
		true === themedd_edd_show_buy_button( $atts ) ||    // Show download footer if the buy button can be shown.
		true === themedd_edd_show_price( $atts ) ||         // Show the download footer is the price has been enabled from themedd_edd_download_grid_options().
		'after' === themedd_edd_download_meta_position() || // Show the download footer if the download meta has been placed in the download footer.
		has_action( 'themedd_edd_download_footer_end' )     // SHow the download footer if anything has been loaded onto the themedd_edd_download_footer_end hook.
	) {
		return true;
	}

	return false;

}

/**
 * Determine if the price can be shown.
 *
 * @since 1.0.0
 */
function themedd_edd_show_price( $atts ) {

	$return = false;

	$download_meta = themedd_edd_download_meta_options();

	// [downloads] shortcode is being used
	if ( ! empty( $atts ) ) {

		if ( isset( $atts['price'] ) && 'yes' === $atts['price'] && true !== $download_meta['price'] ) {
			$return = true;
		}

	} else {

		$options = themedd_edd_download_grid_options();

		// The download grid is being shown without using the [downloads] shortcode
		if ( true === $options['price'] && true !== $download_meta['price'] ) {
			$return = true;
		}

	}

	return apply_filters( 'themedd_edd_show_price', $return );

}

/**
 * Determine if the buy button can be shown.
 *
 * @since 1.0.0
 */
function themedd_edd_show_buy_button( $atts ) {

	$return = false;

	// [downloads] shortcode is being used
	if ( isset( $atts['buy_button'] ) && 'yes' === $atts['buy_button'] ) {
		$return = true;
	} else {

		// The download grid is being shown without using the [downloads] shortcode

		$options = themedd_edd_download_grid_options();

		if ( true === $options['buy_button'] ) {
			$return = true;
		}

	}

	return apply_filters( 'themedd_edd_show_buy_button', $return );

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
