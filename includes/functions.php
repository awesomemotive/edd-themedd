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
 * Is EDD Frontend Submissions active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_edd_fes_active() {
	return class_exists( 'EDD_Front_End_Submissions' );
}

/**
 * Is EDD Recommended Products active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_edd_recommended_products_active() {
	return class_exists( 'EDDRecommendedDownloads' );
}

/**
 * Is EDD Cross-sell & Upsell active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_edd_cross_sell_upsell_active() {
	return class_exists( 'EDD_Cross_Sell_And_Upsell' );
}

/**
 * Is EDD Points and Rewards active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_edd_points_and_rewards_active() {
	return function_exists( 'edd_points_plugin_loaded' );
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
 * Themedd page header div classes
 *
 * @since 1.0.0
 * @param array $more_classes Any more classes that need to be added.
 *
 * @return string Classes
 */
function themedd_page_header_classes( $more_classes = array() ) {

	// Set up the default classes.
	$classes = array( 'col-xs-12 pv-xs-2 pv-sm-3 pv-lg-4' );

	// Center the header content.
	if (
		is_page_template( 'page-templates/no-sidebar.php' ) ||
		is_page_template( 'page-templates/slim.php' ) ||
		is_tax( 'download_category' ) ||
		is_tax( 'download_tag' ) ||
		themedd_edd_distraction_free_checkout()
	) {
		$classes[] = 'center-xs';
	}

	// Merge any new classes passed in.
	if ( is_array( $more_classes ) ) {
		$classes = array_merge( $classes, $more_classes );
	}

	// Make the classes filterable.
	$classes = apply_filters( 'themedd_page_header_classes', $classes );

	// Return the classes in a string
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

/**
 * Themedd primary div classes
 *
 * @since 1.0.0
 */
function themedd_primary_classes() {

	$classes = array();

	if (
		is_active_sidebar( 'sidebar-1' ) &&
		! ( is_page_template( 'page-templates/no-sidebar.php' ) || is_page_template( 'page-templates/slim.php' ) || ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() && themedd_edd_distraction_free_checkout() ) ) ||
		is_singular( 'download' )
	) {
		$classes[] = 'col-xs-12';
		$classes[] = 'col-md-8';
	}

	$classes = apply_filters( 'themedd_primary_classes', $classes );

	if ( $classes ) {
		return ' ' . implode( ' ', $classes );
	}

}

/**
 * Themedd secondary div classes
 *
 * @since 1.0.0
 */
function themedd_secondary_classes() {

	$classes = array();

	$classes[] = 'col-xs-12 col-md-4';

	$classes = apply_filters( 'themedd_secondary_classes', $classes );

	if ( $classes ) {
		return implode( ' ', $classes );
	}
}

/**
 * Display post excerpts
 *
 * @since 1.0.0
 *
 * @return boolean true if post excerpts are enabled, false otherwise
 */
function themedd_display_excerpts() {
	$theme_options = get_theme_mod( 'theme_options' );
	return $theme_options['display_excerpts'];
}
