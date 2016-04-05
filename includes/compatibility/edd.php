<?php

/**
 * Enqueue frontend scripts
 *
 * @since 3.2
 */
function themedd_edd_remove_css() {

	// remove software licensing CSS file
	wp_dequeue_style( 'edd-sl-styles' );

}
add_action( 'wp_enqueue_scripts', 'themedd_edd_remove_css' );
