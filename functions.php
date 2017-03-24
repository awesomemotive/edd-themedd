<?php

/**
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */

/**
 * Constants
 *
 * @since 1.0.0
*/
if ( ! defined( 'THEMEDD_VERSION' ) ) {
	define( 'THEMEDD_VERSION', '1.0.0' );
}

if ( ! defined( 'THEMEDD_INCLUDES_DIR' ) ) {
	define( 'THEMEDD_INCLUDES_DIR', trailingslashit( get_template_directory() ) . 'includes' );
}

if ( ! defined( 'THEMEDD_THEME_URL' ) ) {
	define( 'THEMEDD_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}

/**
 * Includes
 *
 * @since 1.0.0
*/

require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'functions.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'scripts.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'template-tags.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'header.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'custom.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'actions.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'filters.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'customizer.php' );

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
