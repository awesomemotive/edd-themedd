<?php

/**
 * Download author options
 *
 * @since 1.0.0
 */
function themedd_edd_author_details_options( $args = array() ) {

	// Defaults.
	$defaults = array(
		'avatar'      => true,
		'avatar_size' => 80,
		'store_name'  => true,
		'name'        => true,
		'signup_date' => true,
		'website'     => true
	);

	if ( themedd_is_edd_fes_active() ) {
		$defaults['show'] = true;
	}

	$args = wp_parse_args( $args, $defaults );

	return apply_filters( 'themedd_edd_author_details_options', $args );

}

/**
 * Determine if the current download has any author details.
 *
 * @since 1.0.0
 */
function themedd_edd_has_author_details() {

	$options = themedd_edd_author_details_options();

	// If any value in the array is true then there is author details
	if ( in_array( (bool) true, $options ) ) {
		return true;
	}

	return false;
}

/**
 * Determine if the author details can be shown
 */
function themedd_edd_show_author_details() {

	$options = themedd_edd_author_details_options();

	if ( themedd_is_edd_fes_active() && themedd_edd_has_author_details() && true === $options['show'] ) {
		return true;
	}

	if ( isset( $options['show'] ) && true === $options['show'] && themedd_edd_has_author_details() ) {
		return true;
	}

	return false;
}
