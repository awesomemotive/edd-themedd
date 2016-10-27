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

	if ( is_page_template() ) {

		// page templates don't have a sidebar
		if (
			is_page_template( 'page-templates/slim.php' ) ||
			is_page_template( 'page-templates/wide.php' ) ||
			is_page_template( 'page-templates/full-width.php' ) ||
			is_page_template( 'page-templates/no-sidebar.php' )
		) {
			$classes[] = 'no-sidebar';
		}

		// full-width template
		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'width-full';
		}

		// wide template
		if ( is_page_template( 'page-templates/wide.php' ) ) {
			$classes[] = 'width-wide';
		}

		// slim template
		if ( is_page_template( 'page-templates/slim.php' ) ) {
			$classes[] = 'width-slim';
		}


	} else {

		/**
		 * If a sidebar has been removed
		 */
		if ( apply_filters( 'themedd_show_sidebar', true ) ) {

            if ( is_active_sidebar( 'sidebar-1' ) && ( is_singular( 'post' ) || is_home() || is_singular( 'download' ) ) ) {
				$classes[] = 'has-sidebar';
			}

		}
	}

	// Primary menu active
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-primary-menu';
	}

	// Secondary menu active
	if ( has_nav_menu( 'secondary' ) ) {
		$classes[] = 'has-secondary-menu';
	}

	return $classes;

}
add_filter( 'body_class', 'themedd_body_classes' );
