<?php
/**
 * Add custom body classes.
 *
 * @since 1.0.0
 */
function themedd_body_classes( $classes ) {

	if (
		! is_active_sidebar( 'sidebar-1' ) && ! is_singular( 'download' ) ||
		! apply_filters( 'themedd_show_sidebar', true ) ||
		is_page_template( 'page-templates/full-width.php' ) ||
		is_page_template( 'page-templates/slim.php' )
	) {
		$classes[] = 'no-sidebar';
	}

	/**
	 * Add a "slim" body class when:
	 *
	 * 1. Using the slim page template.
	 * 2. When viewing a single post with no sidebar
	 */
	if (
		is_page_template( 'page-templates/slim.php' ) ||
		( is_singular( 'post' ) && in_array( 'no-sidebar', $classes ) ) ||
		in_array( 'blog', $classes ) && in_array( 'no-sidebar', $classes )
	) {
		$classes[] = 'slim';
	}

	return $classes;

}
add_filter( 'body_class', 'themedd_body_classes' );

/**
 * Add custom body classes, based on customizer options
 *
 * @since 1.0.0
 */
function themedd_customizer_body_classes( $classes ) {

	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	if ( themedd_layout_full_width() ) {
		$classes[] = 'layout-full-width';
	}

	return $classes;
}
add_filter( 'body_class', 'themedd_customizer_body_classes' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @since 1.0.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
if ( ! function_exists( 'themedd_excerpt_more' ) ) :
function themedd_excerpt_more( $link ) {

	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'themedd' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'themedd_excerpt_more' );
endif;
