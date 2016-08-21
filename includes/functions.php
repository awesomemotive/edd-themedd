<?php

/**
 * Is EDD active?
 *
 * @return bool
 */
function themedd_is_edd_active() {
	return class_exists( 'Easy_Digital_Downloads' );
}

/**
 * Is EDD Software Licensing active?
 *
 * @return bool
 */
function themedd_is_edd_sl_active() {
	return class_exists( 'EDD_Software_Licensing' );
}

/**
 * Is EDD Recurring active?
 *
 * @return bool
 */
function themedd_is_edd_recurring_active() {
	return class_exists( 'EDD_Recurring' );
}

/**
 * Is AffiliateWP active?
 *
 * @return bool
 */
function themedd_is_affiliatewp_active() {
	return class_exists( 'Affiliate_WP' );
}

/**
 * Is Subtitles active?
 *
 * @return bool
 */
function themedd_is_subtitles_active() {
	return class_exists( 'Subtitles' );
}

/**
 * Is Gravity Forms active?
 *
 * @return bool
 */
function themedd_is_gforms_active() {
	return class_exists( 'GFForms' );
}


/**
 * Posts that should have the lightbox code included
 */
function themedd_enable_popup( $post_id = 0 ) {

	$lightbox = false;

	$posts = apply_filters( 'themedd_lightbox_posts',
		array()
	);

	$changelog = get_post_meta( get_the_ID(), '_edd_sl_changelog', true );

	if ( in_array( $post_id, $posts ) || $changelog ) {
		$lightbox = true;
	}

	return apply_filters( 'themedd_enable_popup', $lightbox );
}
