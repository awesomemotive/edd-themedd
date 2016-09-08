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
	define( 'THEMEDD_VERSION', '1.3.6' );
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
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'account.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'functions.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'scripts.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'template-tags.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'header.php' );
require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'custom.php' );


// Compatibility with other plugins

// AffiliateWP
if ( themedd_is_affiliatewp_active() ) {
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/affiliatewp.php' );
}

// EDD functions
if ( themedd_is_edd_active() ) {
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'compatibility/edd.php' );
	require_once( trailingslashit( THEMEDD_INCLUDES_DIR ) . 'edd-functions.php' );
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function themedd_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'themedd_content_width', 771 );
}
add_action( 'after_setup_theme', 'themedd_content_width', 0 );

if ( ! function_exists( 'themedd_setup' ) ) :

/**
 * Themedd setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since 1.0
 */
function themedd_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on themedd, use a find and replace
	 * to change 'themedd' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'themedd', get_template_directory() . '/languages' );

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
 	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
 	 */
 	add_theme_support( 'post-thumbnails' );
 	set_post_thumbnail_size( 771, 0, true );

	add_image_size( 'themedd-post-thumbnail', 771, 346, true );
	add_image_size( 'themedd-medium', 771, 386, true );
	add_image_size( 'themedd-large', 1200, 600, true );

	// Register menus
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'themedd' ),
		'secondary' => __( 'Secondary Menu', 'themedd' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
 	add_theme_support( 'html5', array(
 		'search-form',
 		'comment-form',
 		'comment-list',
 		'gallery',
 		'caption',
 	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif;
add_action( 'after_setup_theme', 'themedd_setup' );

/**
 * Register widget area
 *
 * @since 1.0
 *
 * @return void
 */
function themedd_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'themedd' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'themedd' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Download Sidebar', 'themedd' ),
		'id'            => 'sidebar-download',
		'description'   => esc_html__( 'Add widgets here to appear in your download sidebar.', 'themedd' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'themedd_widgets_init' );

/**
 * Filter sidebars
 * Allows sidebars to be disabled completely or on a specific post/page/download
 * Allows sidebars to be swapped out on specific posts/pages/downloads
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
				$classes[] = 'col-xs-12 col-md-8';
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

	$classes[] = 'col-xs-12 col-md-4';


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

	return ' ' . implode( ' ', $classes );
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 */
function themedd_body_classes( $classes ) {

	if ( is_page_template() ) {

		// page templates don't have a sidebar
		if (
			is_page_template( 'page-templates/slim.php' ) ||
			is_page_template( 'page-templates/wide.php' ) ||
			is_page_template( 'page-templates/full-width.php' ) ||
			is_page_template( 'page-templates/no-sidebar.php' )
		) {
			$classes[] = 'no-sidebar';
		}

		// full-width template
		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'width-full';
		}

		// wide template
		if ( is_page_template( 'page-templates/wide.php' ) ) {
			$classes[] = 'width-wide';
		}

		// slim template
		if ( is_page_template( 'page-templates/slim.php' ) ) {
			$classes[] = 'width-slim';
		}


	} else {

		/**
		 * If a sidebar has been removed
		 */
		if ( apply_filters( 'themedd_show_sidebar', true ) ) {

            if ( is_active_sidebar( 'sidebar-1' ) && ( is_singular( 'post' ) || is_home() || is_singular( 'download' ) ) ) {
				$classes[] = 'has-sidebar';
			}

		}
	}

	// Primary menu active
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-primary-menu';
	}

	// Secondary menu active
	if ( has_nav_menu( 'secondary' ) ) {
		$classes[] = 'has-secondary-menu';
	}

	return $classes;

}
add_filter( 'body_class', 'themedd_body_classes' );

/**
 * Controls the CSS classes applied to the main wrappers
 * Useful for overriding the wrapper widths etc
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
 * Copyright
 *
 * @since 1.0.0
 */
function themedd_copyright() {
	echo apply_filters( 'themedd_copyright', '<p>' . sprintf( __( 'Copyright &copy; %s %s', 'themedd' ), date('Y'), get_bloginfo( 'name' ) ) . '</p>' );
}
add_action( 'themedd_credits', 'themedd_copyright' );
