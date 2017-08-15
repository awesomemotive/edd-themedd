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
		'version'        => false,
		'title'          => sprintf( __( '%s Details', 'themedd' ), edd_get_label_singular() ),
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
 * Determine if the download details can be shown.
 *
 * @since 1.0.0
 */
function themedd_edd_show_download_details( $options = array() ) {

	// If no options are passed in, use the default options.
	if ( empty( $options ) ) {
		$options = themedd_edd_download_details_options();
	}

	if ( isset( $options['show'] ) && true === $options['show'] && true === themedd_edd_has_download_details( $options ) ) {
		return true;
	}

	return false;

}

/**
 * Determine if the current download has any download details.
 *
 * @since 1.0.0
 */
function themedd_edd_has_download_details( $options = array() ) {

	$download_id = get_the_ID();

	// If download categories are enabled and exist, the download details can be shown.
	if ( true === $options['categories'] && themedd_edd_download_categories( $download_id ) ) {
		return true;
	}

	// If download tags are enabled and exist, the download details can be shown.
	if ( true === $options['tags'] && themedd_edd_download_tags( $download_id ) ) {
		return true;
	}

	// If version number is allowed, and the download has a version number, the download details can be shown.
	if ( true === $options['version'] && themedd_edd_download_version( $download_id ) ) {
		return true;
	}

	return false;

}

/**
 * Get the download categories of a download, given its ID
 *
 * @since 1.0.0
 */
function themedd_edd_download_categories( $download_id = 0 ) {

	if ( ! $download_id ) {
		return false;
	}

	$categories = get_the_term_list( $download_id, 'download_category', '', ', ', '' );

	if ( $categories ) {
		return $categories;
	}

	return false;

}

/**
 * Get the download tags of a download, given its ID.
 *
 * @since 1.0.0
 */
function themedd_edd_download_tags( $download_id = 0 ) {

	if ( ! $download_id ) {
		return false;
	}

	$tags = get_the_term_list( $download_id, 'download_tag', '', ', ', '' );

	if ( $tags ) {
		return $tags;
	}

	return false;

}

/**
 * Get the version number of a download, given its ID.
 *
 * @since 1.0.0
 */
function themedd_edd_download_version( $download_id = 0 ) {

	if ( ! $download_id ) {
		return false;
	}

	if ( themedd_is_edd_sl_active() && (new Themedd_EDD_Software_Licensing)->has_licensing_enabled() ) {
		// Get version number from EDD Software Licensing.
		return get_post_meta( $download_id, '_edd_sl_version', true );
	}

	return false;

}

/**
 * Date published
 *
 * @since 1.0.0
 */
function themedd_edd_download_date_published() {

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	return $time_string;

}
