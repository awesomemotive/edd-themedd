<?php

/**
 * Is EDD active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_edd_active() {
	return class_exists( 'Easy_Digital_Downloads' );
}

/**
 * Is EDD Software Licensing active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_edd_sl_active() {
	return class_exists( 'EDD_Software_Licensing' );
}

/**
 * Is EDD Recurring active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_edd_recurring_active() {
	return class_exists( 'EDD_Recurring' );
}

/**
 * Is AffiliateWP active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_affiliatewp_active() {
	return class_exists( 'Affiliate_WP' );
}

/**
 * Is EDD Download Meta active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_edd_download_meta_active() {
	return class_exists( 'EDD_Download_Meta' );
}

/**
 * Posts that should have the lightbox code included
 *
 * @since 1.0.0
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

/**
 * Filter sidebars
 * Allows sidebars to be disabled completely or on a specific post/page/download
 * Allows sidebars to be swapped out on specific posts/pages/downloads
 *
 * @since 1.0.0
 */
function themedd_get_sidebar() {

	// disable sidebar
	if ( ! apply_filters( 'themedd_show_sidebar', true ) ) {
		return false;
	}

	$sidebar = '';

	// switch out sidebar for singular download pages
	if ( is_singular( 'download' ) ) {
		$sidebar = 'download';
	}

	return get_sidebar( apply_filters( 'themedd_get_sidebar', $sidebar ) );
}

/**
 * Themedd primary div classes
 *
 * @since 1.0.0
 */
function themedd_primary_classes() {
	$classes = array();

	if ( ! is_active_sidebar( 'sidebar-1' ) && ! is_singular( 'download' ) ) {
		$classes[] = 'col-xs-12';
	} else {

		if (
			is_page_template( 'page-templates/slim.php' ) ||
			is_page_template( 'page-templates/wide.php' ) ||
			is_page_template( 'page-templates/full-width.php' ) ||
			is_page_template( 'page-templates/no-sidebar.php' )
		) {
			$classes[] = 'col-xs-12';

		} else {

			// 2 column layout unless sidebar is removed
			if ( apply_filters( 'themedd_show_sidebar', true ) ) {
				$classes[] = 'col-xs-12 col-md-7';
			} else {
				$classes[] = 'col-xs-12';
			}

		}

	}

	$classes = apply_filters( 'themedd_primary_classes', $classes );

	return ' ' . implode( ' ', $classes );
}

/**
 * Themedd secondary div classes
 *
 * @since 1.0.0
 */
function themedd_secondary_classes() {
	$classes = array();

	$classes[] = 'col-xs-12 col-md-5';

	$classes = apply_filters( 'themedd_secondary_classes', $classes );

	return implode( ' ', $classes );
}

/**
 * Themedd page header div classes
 *
 * @since 1.0.0
 */
function themedd_page_header_classes( $more_classes = array() ) {

	$classes = apply_filters( 'themedd_page_header_classes', array( 'col-xs-12 pv-xs-2 pv-sm-3 pv-lg-4' ) );

	if ( is_array( $more_classes ) ) {
		$classes = array_merge( $classes, $more_classes );
	}

	if ( ! empty( $classes ) ) {
		return ' ' . implode( ' ', $classes );
	}

}

/**
 * Controls the CSS classes applied to the main wrappers
 * Useful for overriding the wrapper widths etc
 *
 * @since 1.0.0
 */
function themedd_wrapper_classes() {

	$classes = array();

	// allow filtering of the wrapper classes
	$classes = apply_filters( 'themedd_wrapper_classes', $classes );

	if ( $classes ) {
		return ' ' . implode( ' ', $classes );
	}

	return implode( ' ', $classes );
}
