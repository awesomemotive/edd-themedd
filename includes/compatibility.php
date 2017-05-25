<?php

// Compatibility with other plugins

// AffiliateWP
if ( themedd_is_affiliatewp_active() ) {
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/class-affiliatewp.php' );
}

// EDD functions
if ( themedd_is_edd_active() ) {

	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/functions.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/actions.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/filters.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/software-licensing.php' );

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

	// EDD Download Meta
	if ( themedd_is_edd_download_meta_active() ) {
		require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd/download-meta.php' );
	}

}
