<?php


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
	set_post_thumbnail_size( 771, 9999 );

	// Register menus
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'themedd' ),
		'secondary' => __( 'Secondary Menu', 'themedd' ),
		'mobile'    => __( 'Mobile Menu', 'themedd' )
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
	add_theme_support( 'custom-logo' );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'themedd_setup' );

/**
 * Show the date and author in the header on single posts
 *
 * @since 1.0.0
 */
function themedd_show_posted_on() {

	if ( is_singular( 'post' ) ) {
		themedd_posted_on();
	}

}
add_action( 'themedd_page_header_wrapper_start', 'themedd_show_posted_on' );

/**
 * Show the featured image on the themedd_article_start hook.
 * This allows us to remove the featured image dynamically where needed.
 *
 * @since 1.0.0
 */
function themedd_show_post_thumbnail() {
	themedd_post_thumbnail();
}
add_action( 'themedd_article_start', 'themedd_show_post_thumbnail' );

/**
 * Show the entry footer info (Categories and tags + edit link).
 *
 * @since 1.0.0
 */
function themedd_show_entry_footer() {

	if ( is_singular( 'post' ) ) {
		themedd_entry_footer();
	}

}
add_action( 'themedd_entry_content_end', 'themedd_show_entry_footer' );

/**
 * Load the biography template after the entry content on a single post.
 *
 * @since 1.0.0
 */
function themedd_show_author_biography() {

	if ( is_singular( 'post' ) && '' !== get_the_author_meta( 'description' ) ) {
		get_template_part( 'template-parts/biography' );
	}

}
add_action( 'themedd_entry_content_end', 'themedd_show_author_biography' );
