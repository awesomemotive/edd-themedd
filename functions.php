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
if ( ! defined( 'TRUSTEDD_THEME_VERSION' ) ) {
	define( 'TRUSTEDD_THEME_VERSION', '1.0' );
}

if ( ! defined( 'TRUSTEDD_INCLUDES_DIR' ) ) {
	define( 'TRUSTEDD_INCLUDES_DIR', trailingslashit( get_template_directory() ) . 'includes' );
}

if ( ! defined( 'TRUSTEDD_THEME_URL' ) ) {
	define( 'TRUSTEDD_THEME_URL', trailingslashit( get_template_directory_uri() ) );
}


/**
 * Includes
 *
 * @since 1.0.0
*/
require_once( trailingslashit( TRUSTEDD_INCLUDES_DIR ) . 'functions.php' );
require_once( trailingslashit( TRUSTEDD_INCLUDES_DIR ) . 'scripts.php' );
require_once( trailingslashit( TRUSTEDD_INCLUDES_DIR ) . 'template-tags.php' );
require_once( trailingslashit( TRUSTEDD_INCLUDES_DIR ) . 'custom.php' );

// EDD functions
if ( trustedd_is_edd_active() ) {
	require_once( trailingslashit( TRUSTEDD_INCLUDES_DIR ) . 'edd-functions.php' );
}

// temp
require_once( trailingslashit( TRUSTEDD_INCLUDES_DIR ) . 'pricing.php' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function trustedd_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'trustedd_content_width', 585 );
}
add_action( 'after_setup_theme', 'trustedd_content_width', 0 );

if ( ! function_exists( 'trustedd_setup' ) ) :

/**
 * Trustedd setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since 1.0
 */
function trustedd_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on trustedd, use a find and replace
	 * to change 'trustedd' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'trustedd', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( 'css/editor-style.css' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 720, 360, true );

	add_image_size( 'trustedd-post-thumbnail', 566, 283, true );
	add_image_size( 'trustedd-large', 720, 360, true );

	// Register menu
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'trustedd' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	// add subtitles to downloads
	add_post_type_support( 'download', 'subtitles' );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif;
add_action( 'after_setup_theme', 'trustedd_setup' );

/**
 * Register widget area
 *
 * @since 1.0
 *
 * @return void
 */
function trustedd_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Downloads Sidebar', 'trustedd' ),
		'id'            => 'sidebar-downloads',
		'description'   => __( 'Downloads sidebar', 'trustedd' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>'
	) );

}
add_action( 'widgets_init', 'trustedd_widgets_init' );
