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

	$args = wp_parse_args( $args, $defaults );

	// If Frontend Submissions is active, show the author details by default.
	if ( themedd_is_edd_fes_active() ) {
		$args['show'] = true;
	}

	return apply_filters( 'themedd_edd_author_details_options', $args );

}

/**
 * Determine if the author details can be shown
 */
function themedd_edd_show_author_details( $options = array() ) {

	// If no options are passed in, use the default options.
	if ( empty( $options ) ) {
		$options = themedd_edd_author_details_options();
	}

	if ( isset( $options['show'] ) && true === $options['show'] && true === themedd_edd_has_author_details( $options ) ) {
		return true;
	}

	return false;
}

/**
 * Determine if the current download has any author details.
 *
 * @since 1.0.0
 */
function themedd_edd_has_author_details( $options = array() ) {

	// Remove "show" from the $options array since we don't want to check against it.
	unset( $options['show'] );

	// If (bool) true exists anywhere in the $options array then there are author details that need to be shown.
	if ( in_array( (bool) true, $options, true ) ) { // Uses strict mode.
		return true;
	}

	return false;

}
