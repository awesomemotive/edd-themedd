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

	if ( false === themedd_has_sidebar() && ! is_singular( 'download' ) ) {
		return false;
	}

	return get_sidebar( apply_filters( 'themedd_get_sidebar', $sidebar ) );
}

/**
 * Determines if the current page has a sidebar.
 *
 * This function is used by themedd_body_classes() to add a "has-sidebar" body class.
 * @since 1.1
 */
function themedd_has_sidebar() {

	$has_sidebar = false;

	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() && ! is_singular( 'download' ) && ! is_post_type_archive( 'download' ) ) {
		$has_sidebar = true;
	}

	return apply_filters( 'themedd_has_sidebar', $has_sidebar );
}

/**
 * Themedd primary div classes
 *
 * @since 1.0.0
 */
function themedd_primary_classes() {

	$classes = array();
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
	$classes = apply_filters( 'themedd_secondary_classes', $classes );

	if ( ! empty( $classes ) ) {
		return implode( ' ', $classes );
	}
}

/**
 * Determines the page layout when a sidebar exists.
 * Possible values: content-sidebar | sidebar-content
 *
 * @since 1.1
 */
function themedd_content_sidebar_layout() {
	$layout = 'content-sidebar';
	return apply_filters( 'themedd_content_sidebar_layout', $layout );
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

	return apply_filters( 'themedd_layout_full_width', $layout_full_width );
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

/**
 * Navbar toggler defaults.
 *
 * @since 1.1
 */
function themedd_navbar_toggler_defaults( $args = array() ) {

	$defaults = array(
		'target'           => 'nav-mobile',
		'text_menu_hidden' => __( 'Menu', 'themedd' ),
		'text_menu_shown'  => __( 'Close', 'themedd' ),
		'icon_menu_hidden' => 'menu',
		'icon_menu_shown'  => 'close-menu',
		'button_classes'   => array( 'w-100 py-3 d-flex d-' . themedd_menu_breakpoint() . '-none justify-content-center align-items-center' ),
		'aria_label'       => __( 'Toggle navigation', 'themedd' ),
	);

	$args = wp_parse_args( $args, $defaults );

	return apply_filters( 'themedd_navbar_toggler_defaults', $args );
}

/**
 * Set the breakpoint at which the mobile menu is hidden, and the primary navigation is shown.
 * Possible values: sm | md (default) | lg | xl
 *
 * @since 1.1
 * @return string Breakpoint to hide mobile menu.
 */
function themedd_menu_breakpoint() {
	return apply_filters( 'themedd_menu_breakpoint', 'md' );
}

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since 1.1
 */
function themedd_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'themedd_javascript_detection', 0 );

/**
 * Returns true if comment is by author of the post.
 *
 * @since 1.1
 */
function themedd_is_comment_by_post_author( $comment = null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );

		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}