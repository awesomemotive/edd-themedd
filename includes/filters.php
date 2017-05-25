<?php
/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 */
function themedd_body_classes( $classes ) {

	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	if (
		! is_active_sidebar( 'sidebar-1' ) && ! is_singular( 'download' ) ||
		! apply_filters( 'themedd_show_sidebar', true ) ||
		is_page_template( 'page-templates/no-sidebar.php' )
	) {
		$classes[] = 'no-sidebar';
	}

	if ( is_page_template( 'page-templates/slim.php' ) ) {
		$classes[] = 'slim';
	}

	return $classes;

}
add_filter( 'body_class', 'themedd_body_classes' );
