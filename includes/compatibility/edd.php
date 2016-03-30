<?php

/**
 * Enqueue frontend scripts
 *
 * @since 3.2
 */
function trustedd_edd_remove_css() {

	// remove software licensing CSS file
	wp_dequeue_style( 'edd-sl-styles' );

}
add_action( 'wp_enqueue_scripts', 'trustedd_edd_remove_css' );
