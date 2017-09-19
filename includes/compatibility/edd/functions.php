<?php

/**
 * EDD Price Enhancements
 *
 * While enabled:
 *
 * 1. Prices from purchase buttons are removed
 * 2. Prices are automatically shown when using the [downloads] shortcode (unless "price" is set to "no")
 *
 * @since 1.0.0
 *
 * @return boolean true
 */
function themedd_edd_price_enhancements() {
	return apply_filters( 'themedd_edd_price_enhancements', true );
}

/**
 * Download navigation
 * This is used by archive-download.php, taxonomy-download_category.php, taxonomy-download_tag.php
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_edd_download_nav' ) ) :
	function themedd_edd_download_nav() {

		global $wp_query;

		$options = themedd_edd_download_grid_options();

		// Exit early if pagination has been set to false.
		if ( true !== $options['pagination'] ) {
			return;
		}

		$big          = 999999;
		$search_for   = array( $big, '#038;' );
		$replace_with = array( '%#%', '&' );

		$pagination = paginate_links( array(
			'base'    => str_replace( $search_for, $replace_with, get_pagenum_link( $big ) ),
			'format'  => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total'   => $wp_query->max_num_pages
		) );
		?>

		<?php if ( ! empty( $pagination ) ) : ?>
		<div id="edd_download_pagination" class="navigation">
			<?php echo $pagination; ?>
		</div>
		<?php endif; ?>

	<?php
	}
endif;

/**
 * Distraction Free Checkout
 *
 * @since 1.0.0
 *
 * @return boolean true if Distraction Free Checkout is enabled, false otherwise
 */
function themedd_edd_distraction_free_checkout() {
	$edd_theme_options         = get_theme_mod( 'easy_digital_downloads' );
	$distraction_free_checkout = isset( $edd_theme_options['distraction_free_checkout'] ) && true === $edd_theme_options['distraction_free_checkout'] ? true : false;

	return apply_filters( 'themedd_edd_distraction_free_checkout', $distraction_free_checkout );
}

/**
 * Display vendor contact form
 *
 * @since 1.0.0
 *
 * @return boolean true if vendor contact form is enabled, false otherwise
 */
function themedd_edd_fes_vendor_contact_form() {
	$edd_theme_options   = get_theme_mod( 'easy_digital_downloads' );
	$vendor_contact_form = isset( $edd_theme_options['fes_vendor_contact_form'] ) && true === $edd_theme_options['fes_vendor_contact_form'] ? true : false;

	// Set "true" to be the default if no options exist in theme mods array.
	if ( ! isset( $edd_theme_options['fes_vendor_contact_form'] ) ) {
		return true;
	}

	return $vendor_contact_form;
}
