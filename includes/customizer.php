<?php

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Themedd 1.0.0
 */
function themedd_custom_header() {

	// Get the default colors to compare against.
	$defaults = themedd_customize_color_defaults();

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
	add_theme_support( 'custom-background', apply_filters( 'themedd_customize_custom_background_args', array(
		'default-color' => $defaults['background_color'],
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Themedd
	 *
	 * @since Themedd 1.0.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type int      $width            Width in pixels of the custom header image. Default 1480.
	 *     @type int      $flex-width       Whether to allow flexible-width header images. Default true.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'themedd_customize_custom_header_args', array(
		'flex-width'       => true,
		'width'            => 1480, // Recommended width.
		'flex-height'      => true,
		'height'           => 280, // Recommended height.
		'wp-head-callback' => 'themedd_header_style',
	) ) );

}
add_action( 'after_setup_theme', 'themedd_custom_header' );


/**
 * Set default colors
 *
 * @since 1.0.0
 *
 * @return array $defaults
 */
function themedd_customize_color_defaults() {

	$light_grey   = '#f5f5f5';
	$dark_grey    = '#222222';
	$medium_grey  = '#a2a2a2';
	$white        = '#ffffff';
	$body         = '#696969';
	$primary      = '#448fd5';
	$button_hover = '#2f83d0';
	$link_hover   = '#215b92';

	$defaults = array(
		'background_color'                          => $white,
		'header_background_color'                   => $white,
		'header_textcolor'                          => $dark_grey,
		'header_search_background_color'            => $light_grey,
		'header_search_text_color'                  => $body,
		'header_search_icon_color'                  => $body,
		'site_title_color'                          => $dark_grey,
		'menu_primary_sub_background_hover_color'   => '',
		'menu_primary_sub_background_color'         => $dark_grey,
		'link_color'                                => $primary,
		'link_hover_color'                          => $link_hover,
		'menu_primary_sub_background_active_color'  => '',
		'menu_primary_sub_link_color'               => $medium_grey,
		'menu_primary_sub_link_hover_color'         => $white,
		'menu_primary_sub_link_active_color'        => $white,
		'menu_secondary_link_color'                 => $body,
		'menu_secondary_link_hover_color'           => $dark_grey,
		'menu_primary_background_color'             => '',
		'menu_primary_link_color'                   => $body,
		'menu_primary_link_hover_color'             => $dark_grey,
		'menu_primary_link_background_hover_color'  => '',
		'menu_primary_link_background_active_color' => '',
		'menu_primary_link_active_color'            => $dark_grey,
		'mobile_cart_icon_color'                    => $dark_grey,
		'tagline_color'                             => $medium_grey,
		'cart_icon_color'                           => $dark_grey,
		'button_background_color'                   => $primary,
		'button_background_hover_color'             => $button_hover,
		'button_text_color'                         => $white,
		'menu_mobile_button_background_color'       => '#343a40',
		'menu_mobile_background_color'              => '',
		'menu_mobile_link_color'                    => $dark_grey,
		'menu_mobile_button_text_color'             => $white,
		'menu_mobile_search_background_color'       => $light_grey,
		'menu_mobile_search_text_color'             => $body,
		'menu_mobile_search_icon_color'             => $body,
		'footer_background_color'                   => $white,
		'footer_text_color'                         => $medium_grey,
		'footer_link_color'                         => $medium_grey,
		'footer_heading_color'                      => $dark_grey,
		'footer_link_hover_color'                   => $dark_grey,
		'footer_site_info_color'                    => $medium_grey
	);

	return apply_filters( 'themedd_customize_color_defaults', $defaults );

}

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

	// Get the header text color.
	$text_color = get_header_textcolor();

	// Get the default colors to compare against.
	$defaults = themedd_customize_color_defaults();

	// If no custom color for text is set, let's bail.
	if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) ) {
		return;
	}

	?>

	<style type="text/css" id="themedd-header-css">
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
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) && ( '#' . $text_color !== $defaults['header_textcolor'] ) ) :
	?>
		#masthead .site-title a, #masthead .site-title a:hover { color: #<?php echo esc_attr( $text_color ); ?>; }
	<?php endif; ?>
	</style>

	<?php
}
endif;

/**
 * Bind JS handlers to instantly live-preview changes.
 *
 * @since 1.0.0
 */
function themedd_customize_preview_js() {
	wp_enqueue_script( 'themedd-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), THEMEDD_VERSION, true );

	wp_localize_script( 'themedd-customize-preview', 'defaults', themedd_customize_color_defaults() );

	wp_enqueue_style( 'themedd-customize-preview', get_theme_file_uri( '/assets/css/customize-preview.css' ), array(), THEMEDD_VERSION );
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

	// Default colors.
	$defaults = themedd_customize_color_defaults();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {

		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'            => '.site-title a',
			'container_inclusive' => false,
			'render_callback'     => 'themedd_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'            => '.site-description',
			'container_inclusive' => false,
			'render_callback'     => 'themedd_customize_partial_blogdescription',
		) );

		$wp_customize->selective_refresh->add_partial( 'easy_digital_downloads[cart_icon]', array(
			'selector'            => '.navCart-icon',
			'container_inclusive' => true,
			'render_callback'     => 'themedd_customize_partial_cart_icon',
		) );

		$wp_customize->selective_refresh->add_partial( 'easy_digital_downloads[cart_options]', array(
			'selector'            => '.navCart-cartQuantityAndTotal',
			'container_inclusive' => true,
			'render_callback'     => 'themedd_customize_partial_cart_options',
		) );

		$wp_customize->selective_refresh->add_partial( 'theme_options[header_search]', array(
			'selector'            => array( '.site-header-menu .search-form', '#mobile-menu .menu-item-search' ),
			'container_inclusive' => true,
			'render_callback'     => 'themedd_customize_partial_header_search',
		) );

	}

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'themedd' );

	// Add a description to the Site Title Color.
	$wp_customize->get_control( 'header_textcolor' )->description = __( 'The color of the site title.', 'themedd' );

	// Move the Site Title color to the "Header" section of the "colors" panel
	$wp_customize->get_control( 'header_textcolor' )->section = 'header_colors';

	// Set the default color of the Site Title setting.
	$wp_customize->get_setting( 'header_textcolor' )->default = $defaults['header_textcolor'];

	// Add a description to the "Background Color".
	$wp_customize->get_control( 'background_color' )->description = __( 'The color of the site\'s background.', 'themedd' );

	// Move the Background color to the "General" section of the "colors" panel
	$wp_customize->get_control( 'background_color' )->section = 'general_colors';

	// Set the default color of the Background Color setting.
	$wp_customize->get_setting( 'background_color' )->default = $defaults['background_color'];

	// Tagline color.
	$wp_customize->add_setting( 'colors[tagline_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['tagline_color']
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagline_color', array(
		'label'       => __( 'Tagline Color', 'themedd' ),
		'description' => __( 'The color of the site tagline (if set).', 'themedd' ),
		'section'     => 'header_colors',
		'settings'    => 'colors[tagline_color]',
	) ) );

	/**
	 * Add (actually replaces) the "Colors" section
	 */
	$wp_customize->add_panel( 'colors', array(
		'priority'        => 21,
		'capability'      => 'edit_theme_options',
		'theme_supports'  => '',
		'title'           => __( 'Colors', 'themedd' ),
		'active_callback' => 'themedd_customize_color_options'
	) );

	/**
	 * Add the "general" colors section
	 */
	$wp_customize->add_section( 'general_colors', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'General', 'themedd' ),
		'panel'          => 'colors',
	) );

	/**
	 * Add the "Header" colors section
	 */
	$wp_customize->add_section( 'header_colors', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'Header', 'themedd' ),
		'panel'          => 'colors',
	) );

	/**
	 * Add the "Footer" colors section
	 */
	$wp_customize->add_section( 'footer_colors', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'Footer', 'themedd' ),
		'panel'          => 'colors',
	) );

	/**
	 * Add the "Mobile Menu" colors section
	 */
	$wp_customize->add_section( 'mobile_device_colors', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'Mobile Devices', 'themedd' ),
		'panel'          => 'colors',
	) );

	// Header background color.
	$wp_customize->add_setting( 'colors[header_background_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['header_background_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'header_background_color',
		array(
			'label'       => __( 'Header Background Color', 'themedd' ),
			'description' => __( 'The background color of the site header.', 'themedd' ),
			'settings'    => 'colors[header_background_color]',
			'section'     => 'header_colors',
		)
	));

	/**
	 * Primary menu
	 */

	// Primary menu background color.
	$wp_customize->add_setting( 'colors[menu_primary_background_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_primary_background_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_primary_background_color',
		array(
			'label'       => __( 'Primary Menu Background Color', 'themedd' ),
			'description' => __( 'The background color of the primary menu.', 'themedd' ),
			'settings'    => 'colors[menu_primary_background_color]',
			'section'     => 'header_colors',
		)
	));

	// Primary menu link color.
	$wp_customize->add_setting( 'colors[menu_primary_link_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_primary_link_color']
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_primary_link_color',
		array(
			'label'       => __( 'Primary Menu Link Color', 'themedd' ),
			'description' => __( 'The color of primary menu links.', 'themedd' ),
			'settings'    => 'colors[menu_primary_link_color]',
			'section'     => 'header_colors',
		)
	));

	// Primary menu link hover color.
	$wp_customize->add_setting( 'colors[menu_primary_link_hover_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_primary_link_hover_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_primary_link_hover_color',
		array(
			'label'       => __( 'Primary Menu Link Hover Color', 'themedd' ),
			'description' => __( 'The hover color of primary menu links.', 'themedd' ),
			'settings'    => 'colors[menu_primary_link_hover_color]',
			'section'     => 'header_colors',
		)
	));

	// Primary menu link active color.
	$wp_customize->add_setting( 'colors[menu_primary_link_active_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_primary_link_active_color']
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_primary_link_active_color',
		array(
			'label'       => __( 'Primary Menu Link Active Color', 'themedd' ),
			'description' => __( 'The active color of primary menu links.', 'themedd' ),
			'settings'    => 'colors[menu_primary_link_active_color]',
			'section'     => 'header_colors',
		)
	));

	// Primary menu link background hover color.
	$wp_customize->add_setting( 'colors[menu_primary_link_background_hover_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_primary_link_background_hover_color']
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_primary_link_background_hover_color',
		array(
			'label'       => __( 'Primary Menu Link Background Hover Color', 'themedd' ),
			'description' => __( 'The background hover color of primary menu links.', 'themedd' ),
			'settings'    => 'colors[menu_primary_link_background_hover_color]',
			'section'     => 'header_colors',
		)
	));

	// Primary menu link background active color.
	$wp_customize->add_setting( 'colors[menu_primary_link_background_active_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_primary_link_background_active_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_primary_link_background_active_color',
		array(
			'label'       => __( 'Primary Menu Link Background Active Color', 'themedd' ),
			'description' => __( 'The background active color of primary menu links.', 'themedd' ),
			'settings'    => 'colors[menu_primary_link_background_active_color]',
			'section'     => 'header_colors',
		)
	));

	/**
	 * Sub-menu
	 */

	 // Primary sub-menu link color.
 	$wp_customize->add_setting( 'colors[menu_primary_sub_link_color]', array(
 		'transport'         => 'postMessage',
 		'sanitize_callback' => 'sanitize_hex_color',
 		'default'           => $defaults['menu_primary_sub_link_color']
 	));

 	$wp_customize->add_control( new WP_Customize_Color_Control(
 		$wp_customize,
 		'menu_primary_sub_link_color',
 		array(
 			'label'       => __( 'Primary Sub-menu Link Color', 'themedd' ),
 			'description' => __( 'The color of primary sub-menu links.', 'themedd' ),
 			'settings'    => 'colors[menu_primary_sub_link_color]',
 			'section'     => 'header_colors',
 		)
 	));

 	// Primary sub-menu link hover color.
 	$wp_customize->add_setting( 'colors[menu_primary_sub_link_hover_color]', array(
 		'transport'         => 'postMessage',
 		'sanitize_callback' => 'sanitize_hex_color',
 		'default'           => $defaults['menu_primary_sub_link_hover_color']
 	));

 	$wp_customize->add_control( new WP_Customize_Color_Control(
 		$wp_customize,
 		'menu_primary_sub_link_hover_color',
 		array(
 			'label'       => __( 'Primary Sub-menu Link Hover Color', 'themedd' ),
 			'description' => __( 'The hover color of primary sub-menu links.', 'themedd' ),
 			'settings'    => 'colors[menu_primary_sub_link_hover_color]',
 			'section'     => 'header_colors',
 		)
 	));

 	// Primary sub-menu link active color.
 	$wp_customize->add_setting( 'colors[menu_primary_sub_link_active_color]', array(
 		'transport'         => 'postMessage',
 		'sanitize_callback' => 'sanitize_hex_color',
 		'default'           => $defaults['menu_primary_sub_link_active_color']
 	));

 	$wp_customize->add_control( new WP_Customize_Color_Control(
 		$wp_customize,
 		'menu_primary_sub_link_active_color',
 		array(
 			'label'       => __( 'Primary Sub-menu Link Active Color', 'themedd' ),
 			'description' => __( 'The active color of primary sub-menu links.', 'themedd' ),
 			'settings'    => 'colors[menu_primary_sub_link_active_color]',
 			'section'     => 'header_colors',
 		)
 	));

	// Primary sub-menu background color.
	$wp_customize->add_setting( 'colors[menu_primary_sub_background_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_primary_sub_background_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_primary_sub_background_color',
		array(
			'label'       => __( 'Primary Sub-menu Background Color', 'themedd' ),
			'description' => __( 'The background color of primary sub-menus.', 'themedd' ),
			'settings'    => 'colors[menu_primary_sub_background_color]',
			'section'     => 'header_colors',
		)
	));

	// Primary sub-menu link background hover color.
	$wp_customize->add_setting( 'colors[menu_primary_sub_background_hover_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_primary_sub_background_hover_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_primary_sub_background_hover_color',
		array(
			'label'       => __( 'Primary Sub-menu Background Hover Color', 'themedd' ),
			'description' => __( 'The background hover color of primary sub-menu links.', 'themedd' ),
			'settings'    => 'colors[menu_primary_sub_background_hover_color]',
			'section'     => 'header_colors',
		)
	));

	// Primary sub-menu link background active color.
	$wp_customize->add_setting( 'colors[menu_primary_sub_background_active_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_primary_sub_background_active_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_primary_sub_background_active_color',
		array(
			'label'       => __( 'Primary Sub-menu Background Active Color', 'themedd' ),
			'description' => __( 'The background active color of primary sub-menu links.', 'themedd' ),
			'settings'    => 'colors[menu_primary_sub_background_active_color]',
			'section'     => 'header_colors',
		)
	));

	/**
	 * Secondary menu
	 */

	// Secondary menu link color.
	$wp_customize->add_setting( 'colors[menu_secondary_link_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_secondary_link_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_secondary_link_color',
		array(
			'label'       => __( 'Secondary Menu Link Color', 'themedd' ),
			'description' => __( 'The color of secondary menu links.', 'themedd' ),
			'settings'    => 'colors[menu_secondary_link_color]',
			'section'     => 'header_colors',
		)
	));

	// Secondary menu link hover/active color.
	$wp_customize->add_setting( 'colors[menu_secondary_link_hover_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_secondary_link_hover_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_secondary_link_hover_color',
		array(
			'label'       => __( 'Secondary Menu Link Hover', 'themedd' ),
			'description' => __( 'The hover color of secondary menu links.', 'themedd' ),
			'settings'    => 'colors[menu_secondary_link_hover_color]',
			'section'     => 'header_colors',
		)
	));


	// Link color.
	$wp_customize->add_setting( 'colors[link_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['link_color'],
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'link_color',
		array(
			'label'       => __( 'Link Color', 'themedd' ),
			'description' => __( 'The color of general links.', 'themedd' ),
			'section'     => 'general_colors',
			'settings'    => 'colors[link_color]',
		)
	));

	// Link hover color.
	$wp_customize->add_setting( 'colors[link_hover_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['link_hover_color'],
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'link_hover_color',
		array(
			'label'       => __( 'Link Hover Color', 'themedd' ),
			'description' => __( 'The hover color of general links.', 'themedd' ),
			'section'     => 'general_colors',
			'settings'    => 'colors[link_hover_color]',
		)
	));

	// Button background color.
	$wp_customize->add_setting( 'colors[button_background_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['button_background_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'button_background_color',
		array(
			'label'       => __( 'Button Background Color', 'themedd' ),
			'description' => __( 'The background color of buttons.', 'themedd' ),
			'settings'    => 'colors[button_background_color]',
			'section'     => 'general_colors',
		)
	));

	// Button background hover color.
	$wp_customize->add_setting( 'colors[button_background_hover_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['button_background_hover_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'button_background_hover_color',
		array(
			'label'       => __( 'Button Background Hover Color', 'themedd' ),
			'description' => __( 'The background hover color of buttons.', 'themedd' ),
			'settings'    => 'colors[button_background_hover_color]',
			'section'     => 'general_colors',
		)
	));

	// Button text color.
	$wp_customize->add_setting( 'colors[button_text_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['button_text_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'button_text_color',
		array(
			'label'       => __( 'Button Text Color', 'themedd' ),
			'description' => __( 'The button text color.', 'themedd' ),
			'settings'    => 'colors[button_text_color]',
			'section'     => 'general_colors',
		)
	));

	/**
	 * Easy Digital Downloads section
	 */
	$wp_customize->add_section( 'easy_digital_downloads', array(
		'title'           => __( 'Easy Digital Downloads', 'themedd' ),
		'priority'        => 22,
		'active_callback' => 'themedd_is_edd_active'
	));

	if ( themedd_is_edd_active() ) {
		/**
		* "Restrict Header Search" setting
		*/
		$wp_customize->add_setting( 'easy_digital_downloads[restrict_header_search]', array(
			'sanitize_callback' => 'themedd_sanitize_checkbox'
		));

		$wp_customize->add_control( 'restrict_header_search', array(
			'label'       => __( 'Restrict Header Search', 'themedd' ),
			'settings'    => 'easy_digital_downloads[restrict_header_search]',
			'section'     => 'easy_digital_downloads',
			'type'        => 'checkbox',
			'description' => sprintf( __( 'If enabled, the header search will only search %s. Requires the "Header Search" option from Theme Options to be enabled.', 'themedd' ), strtolower( edd_get_label_plural() ) ),
		));

		/**
		* Distraction Free Checkout setting
		*/
		$wp_customize->add_setting( 'easy_digital_downloads[distraction_free_checkout]', array(
			'sanitize_callback' => 'themedd_sanitize_checkbox'
		));

		$wp_customize->add_control( 'distraction_free_checkout', array(
			'label'       => __( 'Distraction Free Checkout', 'themedd' ),
			'settings'    => 'easy_digital_downloads[distraction_free_checkout]',
			'section'     => 'easy_digital_downloads',
			'type'        => 'checkbox',
			'description' => __( 'Header menus, footer widgets and sidebars will all be removed from checkout, allowing customers to complete their purchase with no distractions.', 'themedd' ),
		));
	}

	/**
	 * Frontend Submissions - Display vendor contact form
	*/
	if ( themedd_is_edd_fes_active() ) {
		$wp_customize->add_setting( 'easy_digital_downloads[fes_vendor_contact_form]', array(
			'sanitize_callback' => 'themedd_sanitize_checkbox',
			'default'           => true
		));

		$wp_customize->add_control( 'fes_vendor_contact_form', array(
			'label'       => __( 'Display Vendor Contact Form', 'themedd' ),
			'settings'    => 'easy_digital_downloads[fes_vendor_contact_form]',
			'section'     => 'easy_digital_downloads',
			'type'        => 'checkbox',
			'description' => __( 'Display the vendor contact form on the vendor page.', 'themedd' ),
		));
	}

	if ( themedd_is_edd_active() ) {
		/**
		* Cart icon setting
		*/
		$wp_customize->add_setting( 'easy_digital_downloads[cart_icon]', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'themedd_sanitize_checkbox',
			'default'           => true
		));

		$wp_customize->add_control( 'cart_icon', array(
			'label'    => __( 'Display Cart Icon', 'themedd' ),
			'settings' => 'easy_digital_downloads[cart_icon]',
			'section'  => 'easy_digital_downloads',
			'type'     => 'checkbox',

		));

		/**
		* Cart options setting
		*/
		$wp_customize->add_setting( 'easy_digital_downloads[cart_options]', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'themedd_sanitize_cart_options',
			'default'           => 'all'
		));

		$wp_customize->add_control( 'cart_options', array(
			'label'       => __( 'Item Quantity and Cart Total', 'themedd' ),
			'description' => __( 'Display either the item quantity or cart total, both the item quantity and cart total, or nothing at all.', 'themedd' ),
			'settings'    => 'easy_digital_downloads[cart_options]',
			'section'     => 'easy_digital_downloads',
			'type'        => 'select',
			'choices'     => themedd_customize_cart_options()
		));


		/**
		* Custom Post Type Archive page title.
		* This option does not show if the archive page has been disabled.
		*/
		if ( ! ( defined( 'EDD_DISABLE_ARCHIVE' ) && true === EDD_DISABLE_ARCHIVE ) ) {

			$wp_customize->add_setting( 'easy_digital_downloads[post_type_archive_title]', array(
				'sanitize_callback' => 'sanitize_text_field'
			));

			$slug = defined( 'EDD_SLUG' ) ? EDD_SLUG : 'downloads';

			$wp_customize->add_control( 'post_type_archive_title', array(
				'label'       => __( 'Custom Post Type Archive Title', 'themedd' ),
				'settings'    => 'easy_digital_downloads[post_type_archive_title]',
				'section'     => 'easy_digital_downloads',
				'type'        => 'text',
				'description' => sprintf( __( 'Configure the title for the Custom Post Type Archive Title page at %s', 'themedd' ), esc_url( home_url( $slug ) ) ),
			));
			
		}
	}

	/**
	 * Theme Options section
	 */
	$wp_customize->add_section( 'theme_options', array(
		'title'    => __( 'Theme Options', 'themedd' ),
		'priority' => 21,
	));

	/**
	 * Full-width layout
	 */
	$wp_customize->add_setting( 'theme_options[layout_full_width]', array(
		'sanitize_callback' => 'themedd_sanitize_checkbox'
	));

	$wp_customize->add_control( 'theme_options[layout_full_width]', array(
		'label'       => __( 'Full Width Layout', 'themedd' ),
		'description' => __( 'Display a full width layout. This will be noticeable once colors have been configured.', 'themedd' ),
		'settings'    => 'theme_options[layout_full_width]',
		'section'     => 'theme_options',
		'type'        => 'checkbox',

	));

	/**
	 * Display excerpts setting
	 */
	$wp_customize->add_setting( 'theme_options[display_excerpts]', array(
		'sanitize_callback' => 'themedd_sanitize_checkbox'
	));

	$wp_customize->add_control( 'theme_options[display_excerpts]', array(
		'label'       => __( 'Display Excerpts', 'themedd' ),
		'description' => __( 'Display excerpts for posts instead of the full content.', 'themedd' ),
		'settings'    => 'theme_options[display_excerpts]',
		'section'     => 'theme_options',
		'type'        => 'checkbox',

	));

	/**
	 * Enable search in header
	 */
	$wp_customize->add_setting( 'theme_options[header_search]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'themedd_sanitize_checkbox',
		'default'           => false
	));

	$wp_customize->add_control( 'theme_options[header_search]', array(
		'label'       => __( 'Header Search', 'themedd' ),
		'description' => __( 'Displays a search box in the header and mobile menu.', 'themedd' ),
		'settings'    => 'theme_options[header_search]',
		'section'     => 'theme_options',
		'type'        => 'checkbox',

	));	

	/**
	 * Mobile Menu
	 */

	// Mobile menu button background color.
	$wp_customize->add_setting( 'colors[menu_mobile_button_background_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_mobile_button_background_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_mobile_button_background_color',
		array(
			'label'       => __( 'Mobile Menu Button Background Color', 'themedd' ),
			'description' => __( 'The background color of the mobile menu button.', 'themedd' ),
			'settings'    => 'colors[menu_mobile_button_background_color]',
			'section'     => 'mobile_device_colors',
		)
	));

	// Mobile menu button text color.
	$wp_customize->add_setting( 'colors[menu_mobile_button_text_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_mobile_button_text_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_mobile_button_text_color',
		array(
			'label'       => __( 'Mobile Menu Button Text Color', 'themedd' ),
			'description' => __( 'The text color of the mobile menu button.', 'themedd' ),
			'settings'    => 'colors[menu_mobile_button_text_color]',
			'section'     => 'mobile_device_colors',
		)
	));

	// Mobile menu background color.
	$wp_customize->add_setting( 'colors[menu_mobile_background_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_mobile_background_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_mobile_background_color',
		array(
			'label'       => __( 'Mobile Menu Background Color', 'themedd' ),
			'description' => __( 'The background color of the mobile menu.', 'themedd' ),
			'settings'    => 'colors[menu_mobile_background_color]',
			'section'     => 'mobile_device_colors',
		)
	));

	// Mobile menu link color.
	$wp_customize->add_setting( 'colors[menu_mobile_link_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_mobile_link_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_mobile_link_color',
		array(
			'label'       => __( 'Mobile Menu Link Color', 'themedd' ),
			'description' => __( 'The link color of the mobile menu.', 'themedd' ),
			'settings'    => 'colors[menu_mobile_link_color]',
			'section'     => 'mobile_device_colors',
		)
	));

	/**
	 * Footer styling
	 */

	// Footer background color.
 	$wp_customize->add_setting( 'colors[footer_background_color]', array(
 		'transport'         => 'postMessage',
 		'sanitize_callback' => 'sanitize_hex_color',
 		'default'           => $defaults['footer_background_color']
 	));

 	$wp_customize->add_control( new WP_Customize_Color_Control(
 		$wp_customize,
 		'footer_background_color',
		array(
			'label'       => __( 'Footer Background Color', 'themedd' ),
			'description' => __( 'The background color of the footer.', 'themedd' ),
			'settings'    => 'colors[footer_background_color]',
			'section'     => 'footer_colors',
		)
 	));

	// Footer text color.
	$wp_customize->add_setting( 'colors[footer_text_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['footer_text_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'footer_text_color',
		array(
			'label'       => __( 'Footer Text Color', 'themedd' ),
			'description' => __( 'The color of footer text.', 'themedd' ),
			'section'     => 'footer_colors',
			'settings'    => 'colors[footer_text_color]',
		)
	));

	// Footer link color.
	$wp_customize->add_setting( 'colors[footer_link_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['footer_link_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'footer_link_color',
		array(
			'label'       => __( 'Footer Link Color', 'themedd' ),
			'description' => __( 'The color of footer links.', 'themedd' ),
			'section'     => 'footer_colors',
			'settings'    => 'colors[footer_link_color]',
		)
	));

	// Footer link hover color.
	$wp_customize->add_setting( 'colors[footer_link_hover_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['footer_link_hover_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'footer_link_hover_color',
		array(
			'label'       => __( 'Footer Link Hover Color', 'themedd' ),
			'description' => __( 'The hover color of footer links.', 'themedd' ),
			'section'     => 'footer_colors',
			'settings'    => 'colors[footer_link_hover_color]',
		)
	));

	// Footer heading color.
	$wp_customize->add_setting( 'colors[footer_heading_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['footer_heading_color']
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'footer_heading_color',
		array(
			'label'       => __( 'Footer Heading Color', 'themedd' ),
			'description' => __( 'The color of footer headings.', 'themedd' ),
			'section'     => 'footer_colors',
			'settings'    => 'colors[footer_heading_color]',
		)
	));

	// Footer site info color.
	$wp_customize->add_setting( 'colors[footer_site_info_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['footer_site_info_color']
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'footer_site_info_color',
		array(
			'label'       => __( 'Footer Site Info Color', 'themedd' ),
			'description' => __( 'The color of footer site info.', 'themedd' ),
			'section'     => 'footer_colors',
			'settings'    => 'colors[footer_site_info_color]',
		)
	));

	/**
	 * Show EDD related options
	 */
	if ( themedd_is_edd_active() ) {

		// Mobile cart icon color.
		$wp_customize->add_setting( 'colors[mobile_cart_icon_color]', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['mobile_cart_icon_color']
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'mobile_cart_icon_color',
			array(
				'label'       => __( 'Mobile Menu Cart Icon Color', 'themedd' ),
				'description' => __( 'The color of the cart icon in the mobile menu.', 'themedd' ),
				'settings'    => 'colors[mobile_cart_icon_color]',
				'section'     => 'mobile_device_colors',
			)
		));

		// Cart icon color
		$wp_customize->add_setting( 'colors[cart_icon_color]', array(
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
			'default'           => $defaults['cart_icon_color']
		));

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'cart_icon_color',
			array(
				'label'       => __( 'Cart Icon Color', 'themedd' ),
				'description' => __( 'The color of the cart icon.', 'themedd' ),
				'settings'    => 'colors[cart_icon_color]',
				'section'     => 'header_colors',
			)
		));

	}
	
	// Header Search Background Color
	$wp_customize->add_setting( 'colors[header_search_background_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['header_search_background_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_background_color',
		array(
			'label'       => __( 'Header Search Background Color', 'themedd' ),
			'description' => __( 'The background color of the search box in the header.', 'themedd' ),
			'settings'    => 'colors[header_search_background_color]',
			'section'     => 'header_colors',
		)
	));

	// Header Search Text Color
	$wp_customize->add_setting( 'colors[header_search_text_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['header_search_text_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_text_color',
		array(
			'label'       => __( 'Header Search Text Color', 'themedd' ),
			'description' => __( 'The color of the search box text in the header.', 'themedd' ),
			'settings'    => 'colors[header_search_text_color]',
			'section'     => 'header_colors',
		)
	));

	// Header Search icon Color
	$wp_customize->add_setting( 'colors[header_search_icon_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['header_search_icon_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'header_search_icon_color',
		array(
			'label'       => __( 'Header Search Icon Color', 'themedd' ),
			'description' => __( 'The color of the search box icon in the header.', 'themedd' ),
			'settings'    => 'colors[header_search_icon_color]',
			'section'     => 'header_colors',
		)
	));

	// Mobile Search Background Color
	$wp_customize->add_setting( 'colors[menu_mobile_search_background_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_mobile_search_background_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_mobile_search_background_color',
		array(
			'label'       => __( 'Mobile Search Background Color', 'themedd' ),
			'description' => __( 'The background color of the search box in the mobile menu.', 'themedd' ),
			'settings'    => 'colors[menu_mobile_search_background_color]',
			'section'     => 'mobile_device_colors',
		)
	));

	// Mobile Search Text Color
	$wp_customize->add_setting( 'colors[menu_mobile_search_text_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_mobile_search_text_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_mobile_search_text_color',
		array(
			'label'       => __( 'Mobile Search Text Color', 'themedd' ),
			'description' => __( 'The color of the search box text in the mobile menu.', 'themedd' ),
			'settings'    => 'colors[menu_mobile_search_text_color]',
			'section'     => 'mobile_device_colors',
		)
	));

	// Mobile Search icon Color
	$wp_customize->add_setting( 'colors[menu_mobile_search_icon_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['menu_mobile_search_icon_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'menu_mobile_search_icon_color',
		array(
			'label'       => __( 'Mobile Search Icon Color', 'themedd' ),
			'description' => __( 'The color of the search box icon in the mobile menu.', 'themedd' ),
			'settings'    => 'colors[menu_mobile_search_icon_color]',
			'section'     => 'mobile_device_colors',
		)
	));

}
add_action( 'customize_register', 'themedd_customize_register' );

/**
 * Output styling to <head>
 *
 * @since 1.0
 */
if ( ! function_exists( 'themedd_colors_output_customizer_styling' ) ) :
	function themedd_colors_output_customizer_styling() { ?>

		<?php

		// Return early if color panel has been disabled.
		if ( ! apply_filters( 'themedd_customize_color_options', true ) ) {
			return;
		}
		
		$colors = get_theme_mod( 'colors' );

		if ( ! empty( $colors ) ) : ?>
			<style id="themedd-custom-css" type="text/css">
			<?php

			/**
			 * Mobile menu
			 */

			// Mobile menu button background color.
			$color = themedd_customize_get_color( 'menu_mobile_button_background_color' );
			
			if ( $color ) {
				echo '.navbar-toggler { background:' . $color . '; border-color: ' . $color . '; }';
			}

			// Mobile menu button text (and icon) color.
			$color = themedd_customize_get_color( 'menu_mobile_button_text_color' );

	 		if ( $color ) {
	 			echo '.navbar-toggler-text { color:' . $color . '; }' . '.navbar-toggler .icon { color:' . $color . '; }';
			}

			// Mobile menu background color.
			$color = themedd_customize_get_color( 'menu_mobile_background_color' );
			if ( $color ) {
	 			echo '#navbar-mobile { background:' .  $color . '; }';
	 		}

			// Mobile menu link color.
			$color = themedd_customize_get_color( 'menu_mobile_link_color' );
			if ( $color ) {
				echo '#navbar-mobile .nav-link, #navbar-mobile .nav-cart { color:' . $color . '; }';
			}

			// Mobile cart icon color.
			$color = themedd_customize_get_color( 'mobile_cart_icon_color' );
			if ( $color ) {
				echo '#nav-mobile .nav-cart-icon .icon { color:' . $color . '; }';
			}

			// Mobile search background color.
			$color = themedd_customize_get_color( 'menu_mobile_search_background_color' );
			if ( $color ) {
				echo '#nav-mobile .search-field, #nav-mobile .btn-search { background-color:' . $color . '; border-color:' . $color . '; }';
			}

			// Mobile search text color.
			$color = themedd_customize_get_color( 'menu_mobile_search_text_color' );
			if ( $color ) {
				echo '#nav-mobile .search-field { color:' . $color . '; }';
			}

			// Mobile search icon color. 
			$color = themedd_customize_get_color( 'menu_mobile_search_icon_color' );
			if ( $color ) {
				echo '#nav-mobile .icon-search { color:' . $color . '; }';
			}
			
			/**
			 * Footer
			 */
			// Footer background color.
			$color = themedd_customize_get_color( 'footer_background_color' );
			if ( $color ) {
				echo '.site-footer { background-color:' . $color . '; }';
			}

			// Footer text color.
			$color = themedd_customize_get_color( 'footer_text_color' );
			if ( $color ) {
				echo '.site-footer { color:' . $color . '; }';
			}

			?>
		</style>
		<?php endif; ?>

	<?php }
endif;
add_action( 'wp_head', 'themedd_colors_output_customizer_styling' );

/**
 * Get the value of a color control.
 *
 * @since 1.1
 * @param string $control The name of the control.
 * 
 * @return string $color The color value of the control.
 */
function themedd_customize_get_color( $control = '' ) {

	if ( empty( $control ) ) {
		return false;
	}

	/**
	 * Get the theme_mods colors array.
	 * These are the colors saved to the theme_mods_{theme} options row.
	 */
	$colors = get_theme_mod( 'colors' );

	/**
	 * Get the default colors array.
	 * These default colors are used by the customizer when a color is not set,
	 * or when the "Default" button is clicked.
	 */
	$color_defaults = themedd_customize_color_defaults();

	/**
	 * Get the color overrides array.
	 * By default this is empty but passing colors to this array will override
	 * any color set by the customizer.
	 */
	$color_overrides = themedd_customize_color_overrides();

	if ( array_key_exists( $control, $color_overrides ) ) {
		// Color is being overridden.
		$color = $color_overrides[$control];
	} else {
		if ( ! empty( $colors[$control] && $colors[$control] !== $color_defaults[$control] ) ) {
			// Color must be set and must not be the same as the color in the $defaults array.
			$color = $colors[$control];
		} else {
			$color = false;
		}
	}

	// Return the color.
	return $color;

}

/**
 * Color overrides.
 * 
 * Any color options added to this array will completely override the color set
 * from the customizer and the resulting theme_mods colors array.
 * 
 * @since 1.1
 *
 * @return array $colors
 */
function themedd_customize_color_overrides() {
	$colors = array();
	return apply_filters( 'themedd_customize_color_overrides', $colors );
}

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

/**
 * Render the header search for the selective refresh partial.
 *
 * @since 1.0.3
 * @see themedd_customize_register()
 *
 * @return void
 */
function themedd_customize_partial_header_search() {
	themedd_load_search()->search_form();
}

/**
 * Render the cart icon for the selective refresh partial.
 *
 * @since 1.0.0
 * @see themedd_customize_register()
 *
 * @return void
 */
 function themedd_customize_partial_cart_icon() {
	echo themedd_edd_load_nav_cart()->cart_icon();
}

/**
 * Render the cart quantity and total for the selective refresh partial.
 *
 * @since 1.0.0
 * @see themedd_customize_register()
 *
 * @return void
 */
function themedd_customize_partial_cart_options() {

	$cart_option = themedd_edd_load_nav_cart()->cart_option();

	switch ( $cart_option ) {

		case 'all':
			echo themedd_edd_load_nav_cart()->cart_quantity();
			echo themedd_edd_load_nav_cart()->cart_total();

			break;

		case 'item_quantity':
			echo themedd_edd_load_nav_cart()->cart_quantity();
			break;	
		
		case 'cart_total':
			echo themedd_edd_load_nav_cart()->cart_total();
			break;
		
	}

}

/**
 * Sanitize checkbox
 *
 * @since 1.0.0
 * @param boolean $checked
 *
 * @return boolean true if checked, false otherwise
 */
function themedd_sanitize_checkbox( $checked ) {
	return ( isset( $checked ) && true === $checked ? true : false );
}

/**
 * Sanitization callback for cart options.
 *
 * @since 1.0.0
 *
 * @param  string $value option name value.
 * @return string option name.
 */
function themedd_sanitize_cart_options( $value ) {

	$options = themedd_customize_cart_options();

	if ( ! array_key_exists( $value, $options ) ) {
		$value = 'all';
	}

	return $value;
}

/**
 * Cart options
 *
 * @since 1.0.0
 *
 * @return array cart options
 */
function themedd_customize_cart_options() {
	return array(
		'item_quantity' => __( 'Display item quantity only', 'themedd' ),
		'cart_total'    => __( 'Display cart total only', 'themedd' ),
		'all'           => __( 'Display item quantity and cart total', 'themedd' ),
		'none'          => __( 'Display nothing', 'themedd' )
	);
}

/**
 * Determine if the "colors" panel is active
 *
 * @since 1.0.0
 *
 * @return boolean true if color panel can be shown, false otherwise.
 */
function themedd_customize_color_options() {

	if ( apply_filters( 'themedd_customize_color_options', true ) ) {
		return true;
	}

	return false;

}
