<?php

/**
 * Is EDD active
 *
 * @return bool
 */
function trustedd_is_edd_active() {
	return class_exists( 'Easy_Digital_Downloads' );
}

/**
 * Posts that should have the lightbox code included
 */
function trustedd_enable_popup( $post_id = 0 ) {

	$lightbox = false;

	$posts = apply_filters( 'trustedd_lightbox_posts',
		array()
	);

	$changelog = get_post_meta( get_the_ID(), '_edd_sl_changelog', true );

	if ( in_array( $post_id, $posts ) || $changelog ) {
		$lightbox = true;
	}

	return apply_filters( 'trustedd_enable_popup', $lightbox );
}
