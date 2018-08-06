<?php

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
if ( ! function_exists( 'themedd_setup' ) ) :

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
		add_theme_support( 'customize-selective-refresh-widgets' );

		themedd_set_post_thumbnail_size();

		// Register menus
		register_nav_menus( array(
			'primary'   => __( 'Primary Menu', 'themedd' ),
			'secondary' => __( 'Secondary Menu', 'themedd' ),
			'mobile'    => __( 'Mobile Menu', 'themedd' ),
			'social'    => __( 'Social Links Menu', 'themedd' )
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

		/**
		 * Enable support for custom logo
		 *
		 * @since 1.0.0
		 */
		add_theme_support( 'custom-logo', array(
			'width'       => 250,
			'height'      => 50,
			'flex-height' => true,
			'flex-width'  => true
		) );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Support wide images in WordPress 5.0
		 *
		 * @since 1.1
		 */
		add_theme_support( 'align-wide' );

	}
endif;
add_action( 'after_setup_theme', 'themedd_setup' );

/**
 * Set the post thumbnail size (aka featured image)
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_set_post_thumbnail_size' ) ) :
	function themedd_set_post_thumbnail_size() {
		set_post_thumbnail_size( 770, 9999 );
	}
endif;

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function themedd_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'themedd_content_width', 770 );
}
add_action( 'after_setup_theme', 'themedd_content_width', 0 );

/**
 * Filters the maximum image width to be included in a ‘srcset’ attribute.
 * This increases the max width to 2880 (from the default of 1600) so we can
 * properly serve images to retina displays based on the featured image size. 
 * 
 * @since 1.1
 * 
 * @param int $max_width The maximum image width to be included in the 'srcset'. Default '1600'.
 * @param array $size_array Array of width and height values in pixels (in that order).
 */
function themedd_max_srcset_image_width( $max_width, $size_array ) {
	$max_width = 2880;

	return $max_width;
}
add_filter( 'max_srcset_image_width', 'themedd_max_srcset_image_width', 10, 2 );