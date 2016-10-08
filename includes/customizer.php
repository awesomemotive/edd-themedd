<?php

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Themedd 1.0.0
 */
function themedd_custom_header() {
	/**
	 * Filter the arguments used when adding 'custom-header' support in Themedd
	 *
	 * @since Themedd 1.0.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'themedd_custom_header_args', array(
		'width'                  => 1188,
		'height'                 => 280,
		'flex-height'            => true,
	) ) );
}
add_action( 'after_setup_theme', 'themedd_custom_header' );
