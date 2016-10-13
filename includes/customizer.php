<?php

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Themedd 1.0.0
 */
function themedd_custom_header() {

	/**
	 * Filter the arguments used when adding 'custom-header' support in Themedd
	 *
	 * @since Themedd 1.0.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'themedd_custom_header_args', array(
		'width'                  => 1188,
		'height'                 => 280,
		'flex-height'            => true,
		'wp-head-callback'       => 'themedd_header_style',
	) ) );

}
add_action( 'after_setup_theme', 'themedd_custom_header' );

if ( ! function_exists( 'themedd_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own themedd_header_style() function to override in a child theme.
 *
 * @since Themedd 1.0.0
 *
 * @see themedd_custom_header().
 */
function themedd_header_style() {

	// If the header text option is untouched, let's bail.
	if ( display_header_text() ) {
		return;
	}

	// If the header text has been hidden.
	?>
	<style type="text/css" id="themedd-header-css">
		.site-branding {
			margin: 0 auto 0 0;
		}

		.site-branding .site-title,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	</style>
	<?php
}
endif;

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Themedd 1.0.0
 */
function themedd_customize_preview_js() {
	wp_enqueue_script( 'themedd-customize-preview', get_template_directory_uri() . '/js/customize-preview.js', array( 'jquery', 'customize-preview' ), THEMEDD_VERSION, true );
}
add_action( 'customize_preview_init', 'themedd_customize_preview_js' );

/**
 * Adds postMessage support for site title and description for the Customizer.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function themedd_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'themedd_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'themedd_customize_partial_blogdescription',
		) );

	}

}
add_action( 'customize_register', 'themedd_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since 1.0.0
 * @see themedd_customize_register()
 *
 * @return void
 */
function themedd_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since 1.0.0
 * @see themedd_customize_register()
 *
 * @return void
 */
function themedd_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
