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
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/affiliatewp.php' );
}

// EDD functions
if ( themedd_is_edd_active() ) {
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'edd/functions.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'edd/actions.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'edd/filters.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'edd/software-licensing.php' );
}

// EDD Download Meta
if ( themedd_is_edd_download_meta_active() ) {
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'edd/download-meta.php' );
}
