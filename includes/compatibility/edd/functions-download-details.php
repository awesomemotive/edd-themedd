<?php
/**
 * Download details functions
 */

/**
 * Download details options.
 *
 * @since 1.0.0
 *
 * @return array $options Download Details options
 */
function themedd_edd_download_details_options( $args = array() ) {

	// Defaults.
	$defaults = array(
		'show'           => true,
		'sale_count'     => false,
		'date_published' => false,
		'categories'     => true,
		'tags'           => true,
		'version'        => false
	);

	if ( themedd_is_edd_fes_active() ) {
		$defaults['date_published'] = true;
		$defaults['sale_count']     = true;
	}

	if ( themedd_is_edd_sl_active() ) {
		$defaults['version'] = true;
	}

	$args = wp_parse_args( $args, $defaults );

	return apply_filters( 'themedd_edd_download_details_options', $args );

}

/**
 * Determine if the current download has any download details.
 *
 * @since 1.0.0
 */
function themedd_edd_has_download_details() {

	$return = false;

	$options = themedd_edd_download_details_options();

	// Get the download's categories.
	$categories = get_the_term_list( get_the_ID(), 'download_category', '', ', ', '' );

	// If categories exist, the download details can be shown.
	if ( true === $options['categories'] && $categories ) {
		$return = true;
	}

	// Get the download's tags.
	$tags = get_the_term_list( get_the_ID(), 'download_tag', '', ', ', '' );

	// If downoad tags exist, the download details can be shown.
	if ( true === $options['tags'] && $tags ) {
		$return = true;
	}

	// If any value in the array is true, and either tags or categories exists, then there are download details.
	if ( in_array( (bool) true, $options ) && $tags || $categories ) {
		$return = true;
	}

	return $return;

}

/**
 * Determine if the download details can be shown
 *
 * @since 1.0.0
 */
function themedd_edd_show_download_details() {

	$options = themedd_edd_download_details_options();

	if ( isset( $options['show'] ) && true === $options['show'] && themedd_edd_has_download_details() ) {
		return true;
	}

	return false;
}
