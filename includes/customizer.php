<?php

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Themedd 1.0.0
 */
function themedd_custom_header() {

	$default_background_color = 'f5f5f5';

	/**
	 * Filter the arguments used when adding 'custom-background' support in Themedd
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 * @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'themedd_custom_background_args', array(
		'default-color' => $default_background_color,
	) ) );

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
		'width'                  => 1480,
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

	$text_color = get_header_textcolor();

	// If no custom color for text is set, let's bail.
	if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) ) {
		return;
	}

	// If we get this far, we have custom styles.
	?>

	<style type="text/css" id="twentyfourteen-header-css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
	.site-branding .site-title,
	.site-description {
		clip: rect(1px, 1px, 1px, 1px);
		position: absolute;
	}
	<?php
		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-title a {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
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
	wp_enqueue_script( 'themedd-customize-preview', get_template_directory_uri() . '/assets/js/customize-preview.js', array( 'jquery', 'customize-preview' ), THEMEDD_VERSION, true );
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
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

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

		// Rename the label to "Site Title Color" because this only affects the site title in this theme.
		$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'themedd' );

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
