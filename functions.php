<?php

/**
 * Note: Do not add any custom code here. Please use a child theme or custom functionality plugin so that your customizations are not lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */

/**
 * Themedd only works with WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
	require get_template_directory() . '/includes/back-compat.php';
	return;
}

/**
 * Constants
 *
 * @since 1.0.0
*/
if ( ! defined( 'THEMEDD_VERSION' ) ) {
	define( 'THEMEDD_VERSION', '1.0.0' );
}

if ( ! defined( 'THEMEDD_AUTHOR' ) ) {
	define( 'THEMEDD_AUTHOR', 'Easy Digital Downloads' );
}

if ( ! defined( 'THEMEDD_NAME' ) ) {
	define( 'THEMEDD_NAME', 'Themedd' );
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
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'setup.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'class-themedd.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'functions.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'scripts.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'template-tags.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'header.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'footer.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'actions.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'filters.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'customizer.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility.php' );

/**
 * Admin page
 */
function themedd_updater() {
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . '/updater/theme-updater.php' );
}
add_action( 'after_setup_theme', 'themedd_updater' );
