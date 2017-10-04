<?php

// Compatibility with other plugins

/**
 * AffiliateWP
 *
 * @see https://affiliatewp.com
 */
if ( themedd_is_affiliatewp_active() ) {
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/class-affiliatewp.php' );
}

/**
 * Subtitles
 *
 * @see https://wordpress.org/plugins/subtitles/
 */
if ( themedd_is_subtitles_active() ) {
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/class-subtitles.php' );
}

/**
 * Easy Digital Downloads
 *
 * @see https://easydigitaldownloads.com
 */
if ( themedd_is_edd_active() ) {

	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/functions.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/functions-download-grid.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/functions-download-author.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/functions-download-meta.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/functions-download-details.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/actions.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/filters.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-nav-cart.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-widget-download-author.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-widget-download-details.php' );

	// EDD - Software Licensing
	if ( themedd_is_edd_sl_active() ) {
		require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-software-licensing.php' );
	}

	// EDD - Frontend Submissions
	if ( themedd_is_edd_fes_active() ) {
		require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-frontend-submissions.php' );
	}

	// EDD - Recommended Products
	if ( themedd_is_edd_recommended_products_active() ) {
		require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-recommended-products.php' );
	}

	// EDD - Cross-sell/Upsell
	if ( themedd_is_edd_cross_sell_upsell_active() ) {
		require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-cross-sell-upsell.php' );
	}

	// EDD - Points and Rewards
	if ( themedd_is_edd_points_and_rewards_active() ) {
		require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-points-and-rewards.php' );
	}

	// EDD - Reviews
	if ( themedd_is_edd_reviews_active() ) {
		require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-reviews.php' );
	}

	/**
	 * EDD - Coming Soon
	 *
	 * @since 1.0.2
	 */
	if ( themedd_is_edd_coming_soon_active() ) {
		require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/class-coming-soon.php' );
	}

}
