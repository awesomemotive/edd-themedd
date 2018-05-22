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
 * Is EDD Stripe active?
 *
 * @since 1.1
 * @return bool
 */
function themedd_is_edd_stripe_active() {
	return class_exists( 'EDD_Stripe' );
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
 * Is EDD Coming Soon active?
 *
 * @since 1.0.2
 * @return bool
 */
function themedd_is_edd_coming_soon_active() {
	return class_exists( 'EDD_Coming_Soon' );
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
 * Is EDD Reviews active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_edd_reviews_active() {
	return class_exists( 'EDD_Reviews' );
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
 * Is the subtitles plugin active?
 *
 * @since 1.0.0
 * @return bool
 */
function themedd_is_subtitles_active() {
	return class_exists( 'Subtitles' );
}

/**
 * Wrapper for get_sidebar()
 *
 * Allows sidebars to be disabled completely, or on a specific post/page/download
 * Allows sidebars to be swapped out on specific posts/pages/downloads
 *
 * @since 1.0.0
 */
function themedd_get_sidebar( $sidebar = '' ) {

	// Disable all sidebars.
	if ( ! apply_filters( 'themedd_show_sidebar', true ) ) {
		return false;
	}

	return get_sidebar( apply_filters( 'themedd_get_sidebar', $sidebar ) );
}

/**
 * Controls the CSS classes applied to the main wrappers.
 *
 * @since 1.0.0
 */
function themedd_wrapper_classes() {

	$classes = array();

	if ( themedd_has_sidebar() ) {
		$classes[] = 'container';
	} elseif( ! themedd_has_sidebar() ) {
		$classes[] = 'container-fluid';
	}

	// Allow filtering of the wrapper classes.
	return apply_filters( 'themedd_wrapper_classes', $classes );

}

/**
 * Themedd primary div classes
 *
 * @since 1.0.0
 */
function themedd_primary_classes() {

	$classes = array();

	if ( themedd_has_sidebar() ) {
		$classes = array( 'col-12 col-lg-8' );
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

	$classes   = array();
	$classes[] = 'col-12 col-lg-4';

	$classes = apply_filters( 'themedd_secondary_classes', $classes );

	if ( $classes ) {
		return implode( ' ', $classes );
	}
}

/**
 * Determines if the current page has a sidebar.
 *
 * @since 1.1
 */
function themedd_has_sidebar() {

	if ( ! ( 
			! is_active_sidebar( 'sidebar-1' ) && ! is_singular( 'download' ) ||
			! apply_filters( 'themedd_show_sidebar', true ) ||
			is_page_template( 'page-templates/full-width.php' ) ||
			is_page_template( 'page-templates/slim.php' ) ||
			is_search() && Themedd_Search::is_product_search_results()
		)
	) {
		return true;
	}

	return false;

}

/**
 * Display post excerpts
 *
 * @since 1.0.0
 *
 * @return boolean true if post excerpts are enabled, false otherwise
 */
function themedd_display_excerpts() {
	$theme_options    = get_theme_mod( 'theme_options' );
	$display_excerpts = isset( $theme_options['display_excerpts'] ) && true === $theme_options['display_excerpts'] ? true : false;

	return $display_excerpts;
}

/**
 * Full-width layout.
 *
 * @since 1.0.0
 *
 * @return boolean true if the full-width layout is enabled, false otherwise
 */
function themedd_layout_full_width() {
	$theme_options     = get_theme_mod( 'theme_options' );
	$layout_full_width = isset( $theme_options['layout_full_width'] ) && true === $theme_options['layout_full_width'] ? true : false;

	return $layout_full_width;
}

/**
 * Whether we are viewing the EDD checkout with Distraction Free Checkout enabled.
 *
 * @since 1.1
 *
 * @return boolean
 */
function themedd_edd_is_distraction_free_checkout() {
	return themedd_is_edd_active() && edd_is_checkout() && themedd_edd_distraction_free_checkout() && edd_get_cart_contents();
}