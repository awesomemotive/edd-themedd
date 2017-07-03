<?php

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Themedd 1.0.0
 */
function themedd_custom_header() {

	$default_background_color = 'ffffff';

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
	 *     @type int      $width            Width in pixels of the custom header image. Default 1480.
	 *     @type int      $flex-width       Whether to allow flexible-width header images. Default true.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'themedd_custom_header_args', array(
		'flex-width'       => true,
		'width'            => 1480, // Recommended width.
		'flex-height'      => true,
		'height'           => 280, // Recommended height.
		'wp-head-callback' => 'themedd_header_style',
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
		.site-title a, .site-title a:hover { color: #<?php echo esc_attr( $text_color ); ?>; }
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
 * Set default colors
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_customize_color_defaults' ) ) :
	function themedd_customize_color_defaults() {

		$defaults = array(
			'header_textcolor'                          => '#222222',
			'site_title_color'                          => '#222222',
			'menu_primary_sub_background_hover_color'   => '',
			'menu_primary_sub_background_color'         => '#f5f5f5',
			'link_color'                                => '#448fd5',
			'menu_primary_sub_background_active_color'  => '',
			'menu_primary_sub_link_color'               => '#787878',
			'menu_primary_sub_link_hover_color'         => '#222222',
			'menu_primary_sub_link_active_color'        => '#222222',
			'header_background_color'                   => '',
			'menu_secondary_link_color'                 => '#696969',
			'menu_secondary_link_hover_color'           => '#448fd5',
			'menu_primary_background_color'             => '',
			'menu_primary_link_color'                   => '#222222',
			'menu_primary_link_hover_color'             => '#448fd5',
			'menu_primary_link_background_hover_color'  => '',
			'menu_primary_link_background_active_color' => '',
			'menu_primary_link_active_color'            => '#448fd5',
			'mobile_cart_icon_color'                    => '#222222',
			'tagline_color'                             => '#222222',
			'cart_icon_color'                           => '#222222',
			'cart_count_background_color'               => '#448fd5',
			'button_background_color'                   => '#222222',
			'button_background_hover_color'             => '#448fd5',
			'button_text_color'                         => '#ffffff',
			'menu_mobile_button_background_color'       => '#222222',
			'menu_mobile_background_color'              => '#ffffff',
			'menu_mobile_link_color'                    => '#222222',
			'menu_mobile_button_text_color'             => '#ffffff',
			'cart_count_color'                          => '#ffffff',
			'footer_background_color'                   => '#ffffff',
			'footer_text_color'                         => '',
			'footer_link_color'                         => '',
			'footer_heading_color'                      => '',
			'footer_link_hover_color'                   => '',
		);

		return $defaults;
	}
endif;

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
			'container_inclusive' => false,
			'render_callback'     => 'themedd_customize_partial_cart_icon',
		) );

		$wp_customize->selective_refresh->add_partial( 'easy_digital_downloads[cart_options]', array(
			'selector'            => '.navCart-cartQuantityAndTotal',
			'container_inclusive' => false,
			'render_callback'     => 'themedd_customize_partial_cart_options',
		) );

	}

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'themedd' );

	// Add a description to the Site Title Color.
	$wp_customize->get_control( 'header_textcolor' )->description = __( 'The color of the site title.', 'themedd' );

	// Set the default color of the Site Title setting.
	$wp_customize->get_setting( 'header_textcolor' )->default = $defaults['header_textcolor'];

	// Add a description to the "Background Color".
	$wp_customize->get_control( 'background_color' )->description = __( 'The color of the site\'s background.', 'themedd' );

	// Tagline color.
	$wp_customize->add_setting( 'colors[tagline_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['tagline_color']
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagline_color', array(
		'label'       => __( 'Tagline Color', 'themedd' ),
		'description' => __( 'The site tagline (if set) color.', 'themedd' ),
		'section'     => 'colors',
		'settings'    => 'colors[tagline_color]',
	) ) );

	// Link colors.
	$wp_customize->add_setting( 'colors[link_color]', array(
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['link_color']
	));

	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize,
		'link_color',
		array(
			'label'       => __( 'Link Color', 'themedd' ),
			'description' => __( 'The color of general links.', 'themedd' ),
			'section'     => 'colors',
			'settings'    => 'colors[link_color]',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'description' => __( 'The color of primary menu links when hovered over.', 'themedd' ),
			'settings'    => 'colors[menu_primary_link_hover_color]',
			'section'     => 'colors',
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
			'description' => __( 'The color of primary menu links when active.', 'themedd' ),
			'settings'    => 'colors[menu_primary_link_active_color]',
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
		)
	));

	/**
	 * Sub-menu
	 */

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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
		)
	));

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
			'section'     => 'colors',
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
			'description' => __( 'The color of primary sub-menu links when hovered over.', 'themedd' ),
			'settings'    => 'colors[menu_primary_sub_link_hover_color]',
			'section'     => 'colors',
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
			'description' => __( 'The color of primary sub-menu links when active.', 'themedd' ),
			'settings'    => 'colors[menu_primary_sub_link_active_color]',
			'section'     => 'colors',
		)
	));

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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'description' => __( 'The color of secondary menu links when hovered over.', 'themedd' ),
			'settings'    => 'colors[menu_secondary_link_hover_color]',
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'description' => __( 'The background color of buttons when hovered over.', 'themedd' ),
			'settings'    => 'colors[button_background_hover_color]',
			'section'     => 'colors',
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
			'description' => __( 'The button text color of buttons.', 'themedd' ),
			'settings'    => 'colors[button_text_color]',
			'section'     => 'colors',
		)
	));

	/**
	 * Easy Digital Downloads section
	 */
	$wp_customize->add_section( 'easy_digital_downloads', array(
		'title'           => __( 'Easy Digital Downloads', 'themedd' ),
		'priority'        => 20,
		'active_callback' => 'themedd_is_edd_active'
	));

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
		'label'       => __( 'Item Quantity and Cart Price', 'themedd' ),
		'description' => __( 'Select to display the item quantity, cart total, or both.', 'themedd' ),
		'settings'    => 'easy_digital_downloads[cart_options]',
		'section'     => 'easy_digital_downloads',
		'type'        => 'select',
		'choices'     => themedd_customize_cart_options()
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
		'label'       => __( 'Full-width layout', 'themedd' ),
		'description' => __( 'Display a full-width layout. This will be noticeable once colors have been configured.', 'themedd' ),
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
		'label'       => __( 'Display excerpts', 'themedd' ),
		'description' => __( 'Display excerpts for posts instead of the full content.', 'themedd' ),
		'settings'    => 'theme_options[display_excerpts]',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
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
			'section'     => 'colors',
			'settings'    => 'colors[footer_heading_color]',
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
				'label'       => __( 'Mobile/Tablet Cart Icon Color', 'themedd' ),
				'description' => __( 'The color of the cart icon on mobiles/tablets. Use the mobile/tablet preview buttons below.', 'themedd' ),
				'settings'    => 'colors[mobile_cart_icon_color]',
				'section'     => 'colors',
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
				'label'       => __( 'Desktop Cart Icon Color', 'themedd' ),
				'description' => __( 'The color of the cart icon at Desktop resolution.', 'themedd' ),
				'settings'    => 'colors[cart_icon_color]',
				'section'     => 'colors',
			)
		));

	}

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

			$colors = get_theme_mod( 'colors' );

			// Get the default colors to compare against.
			$defaults = themedd_customize_color_defaults();

			if ( $colors ) {
				$colors = array_filter( $colors );
			}

			if ( ! empty( $colors ) ) : ?>
			<style id="themedd-custom-css" type="text/css">
			<?php

			// Tagline color.
			if ( isset( $colors['tagline_color'] ) && $colors['tagline_color'] !== $defaults['tagline_color'] ) {
				echo '.site-description { color:' . $colors['tagline_color'] . ';}';
			}

			// Link color.
			if ( isset( $colors['link_color'] ) && $colors['link_color'] !== $defaults['link_color'] ) {
				echo 'a { color:' . $colors['link_color'] . ';}';
			}

			// Site header background.
			if ( isset( $colors['header_background_color'] ) && $colors['header_background_color'] !== $defaults['header_background_color'] ) {
				echo '#masthead { background:' . $colors['header_background_color'] . ';}';
			}

			// Primary menu background color.
			if ( isset( $colors['menu_primary_background_color'] ) && $colors['menu_primary_background_color'] !== $defaults['menu_primary_background_color'] ) {
				echo '#site-header-menu, #mobile-menu { background-color:' . $colors['menu_primary_background_color'] . ';}';
			}

			// Primary menu link color.
			if ( isset( $colors['menu_primary_link_color'] ) && $colors['menu_primary_link_color'] !== $defaults['menu_primary_link_color'] ) {
				echo '.main-navigation a, #mobile-menu a, .dropdown-toggle { color:' . $colors['menu_primary_link_color'] . ';}';
			}

			// Primary menu link hover color.
			if ( isset( $colors['menu_primary_link_hover_color'] ) && $colors['menu_primary_link_hover_color'] !== $defaults['menu_primary_link_hover_color'] ) {

				echo '.main-navigation li:hover > a, .main-navigation li.focus > a { color:' . $colors['menu_primary_link_hover_color'] . ';}';

				// mobile menu styles
				echo '#mobile-menu a:hover,	#mobile-menu a:focus, #mobile-menu .current-menu-item > a, #mobile-menu .current_page_ancestor > a { color:' . $colors['menu_primary_link_hover_color'] . ';}';

				// dropdown toggle styles
				echo '.dropdown-toggle:hover, .dropdown-toggle:focus { color:' . $colors['menu_primary_link_hover_color'] . ';}';

			}

			// Primary menu link active color.
			if ( isset( $colors['menu_primary_link_active_color'] ) && $colors['menu_primary_link_active_color'] !== $defaults['menu_primary_link_active_color'] ) {
				echo '.main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a, .main-navigation .current_page_ancestor > a:hover, .main-navigation li.current_page_ancestor:hover > a { color:' . $colors['menu_primary_link_active_color'] . ';}';
			}

			// Primary menu link background hover color.
			if ( isset( $colors['menu_primary_link_background_hover_color'] ) && $colors['menu_primary_link_background_hover_color'] !== $defaults['menu_primary_link_background_hover_color'] ) {
				echo '.primary-menu > li:hover { background:' . $colors['menu_primary_link_background_hover_color'] . ';}';
			}

			// Primary menu link background active color.
			if ( isset( $colors['menu_primary_link_background_active_color'] ) && $colors['menu_primary_link_background_active_color'] !== $defaults['menu_primary_link_background_active_color'] ) {
				echo '.primary-menu > li.current-menu-item, .primary-menu > li.current_page_ancestor { background:' . $colors['menu_primary_link_background_active_color'] . ';}';
			}

			// Primary sub-menu background color.
			if ( isset( $colors['menu_primary_sub_background_color'] ) && $colors['menu_primary_sub_background_color'] !== $defaults['menu_primary_sub_background_color'] ) {
				echo '.main-navigation ul ul li { background:' . $colors['menu_primary_sub_background_color'] . ';}';
			}

			// Primary sub-menu link color.
			if ( isset( $colors['menu_primary_sub_link_color'] ) && $colors['menu_primary_sub_link_color'] !== $defaults['menu_primary_sub_link_color'] ) {
				echo '.main-navigation .sub-menu a { color:' . $colors['menu_primary_sub_link_color'] . ';}';
			}

			// Primary sub-menu link hover color.
			if ( isset( $colors['menu_primary_sub_link_hover_color'] ) && $colors['menu_primary_sub_link_hover_color'] !== $defaults['menu_primary_sub_link_hover_color'] ) {
				echo '.main-navigation .sub-menu li:hover > a, .main-navigation .sub-menu li.focus > a { color:' . $colors['menu_primary_sub_link_hover_color'] . ';}';
			}

			// Primary sub-menu link active color.
			if ( isset( $colors['menu_primary_sub_link_active_color'] ) && $colors['menu_primary_sub_link_active_color'] !== $defaults['menu_primary_sub_link_active_color'] ) {
				echo '.main-navigation .sub-menu .current-menu-item a { color:' . $colors['menu_primary_sub_link_active_color'] . ';}';
				echo '.main-navigation .sub-menu .current-menu-item a:hover { color:' . $colors['menu_primary_sub_link_active_color'] . ';}';
			}

			// Primary sub-menu background hover color.
			if ( isset( $colors['menu_primary_sub_background_hover_color'] ) && $colors['menu_primary_sub_background_hover_color'] !== $defaults['menu_primary_sub_background_hover_color'] ) {
				echo '.main-navigation .sub-menu li:hover { background:' . $colors['menu_primary_sub_background_hover_color'] . ';}';
			}

			// Primary sub-menu background active color.
			if ( isset( $colors['menu_primary_sub_background_active_color'] ) && $colors['menu_primary_sub_background_active_color'] !== $defaults['menu_primary_sub_background_active_color'] ) {
				echo '.main-navigation .sub-menu .current-menu-item { background:' . $colors['menu_primary_sub_background_active_color'] . ';}';
				echo '.main-navigation .sub-menu li.hover { background:' . $colors['menu_primary_sub_background_active_color'] . ';}';
				echo '.main-navigation .sub-menu .current-menu-item { background:' . $colors['menu_primary_sub_background_active_color'] . ';}';
			}

			// Secondary menu link color.
			if ( isset( $colors['menu_secondary_link_color'] ) && $colors['menu_secondary_link_color'] !== $defaults['menu_secondary_link_color'] ) {
				echo '#site-header-secondary-menu a { color:' . $colors['menu_secondary_link_color'] . ';}';
			}

			// Secondary menu link hover color.
			if ( isset( $colors['menu_secondary_link_hover_color'] ) && $colors['menu_secondary_link_hover_color'] !== $defaults['menu_secondary_link_hover_color'] ) {
				echo '#site-header-secondary-menu a:hover { color:' . $colors['menu_secondary_link_hover_color'] . ';}';
			}

			// Mobile cart icon color.
			if ( isset( $colors['mobile_cart_icon_color'] ) && $colors['mobile_cart_icon_color'] !== $defaults['mobile_cart_icon_color'] ) {
				echo '.navCart-mobile .navCart-icon { fill:' . $colors['mobile_cart_icon_color'] . ';}';
			}

			// Cart icon color.
			if ( isset( $colors['cart_icon_color'] ) && $colors['cart_icon_color'] !== $defaults['cart_icon_color'] ) {
				echo '.navCart-icon { fill:' . $colors['cart_icon_color'] . ';}';
			}

			// Cart count background color.
			if ( isset( $colors['cart_count_background_color'] ) && $colors['cart_count_background_color'] !== $defaults['cart_count_background_color'] ) {
				echo '.cart-count { background:' . $colors['cart_count_background_color'] . ';}';
			}

			// Cart count color.
			if ( isset( $colors['cart_count_color'] ) && $colors['cart_count_color'] !== $defaults['cart_count_color'] ) {
				echo '.cart-count { color:' . $colors['cart_count_color'] . ';}';
			}

			// Button background color.
			if ( isset( $colors['button_background_color'] ) && $colors['button_background_color'] !== $defaults['button_background_color'] ) {
				echo '.button, button, input[type="submit"], #submit { background:' . $colors['button_background_color'] . '; border-color: ' . $colors['button_background_color'] . '; }';
			}

			// Button background hover color.
			if ( isset( $colors['button_background_hover_color'] ) && $colors['button_background_hover_color'] !== $defaults['button_background_hover_color'] ) {
				echo '.button:hover, .button:focus, button:hover, input[type="submit"]:hover, #submit:hover { background:' . $colors['button_background_hover_color'] . '; border-color: ' . $colors['button_background_hover_color'] . '; }';
			}

			// Button text color.
			if ( isset( $colors['button_text_color'] ) && $colors['button_text_color'] !== $defaults['button_text_color'] ) {
				echo '.button, button, input[type="submit"], #submit { color:' . $colors['button_text_color'] . '; }';
				echo '.button:hover, button:hover, input[type="submit"]:hover, #submit:hover { color:' . $colors['button_text_color'] . '; }';
			}

			/**
			 * Mobile menu
			 */

			// Mobile menu button background color.
	 		if ( isset( $colors['menu_mobile_button_background_color'] ) && $colors['menu_mobile_button_background_color'] !== $defaults['menu_mobile_button_background_color'] ) {
	 			echo '#menu-toggle { background:' . $colors['menu_mobile_button_background_color'] . '; border-color: ' . $colors['menu_mobile_button_background_color'] . '; }';
	 		}

			// Mobile menu button background color.
	 		if ( isset( $colors['menu_mobile_button_text_color'] ) && $colors['menu_mobile_button_text_color'] !== $defaults['menu_mobile_button_text_color'] ) {
	 			echo '#menu-toggle { color:' . $colors['menu_mobile_button_text_color'] . '; }';
	 		}

			// Mobile menu background color.
	 		if ( isset( $colors['menu_mobile_background_color'] ) && $colors['menu_mobile_background_color'] !== $defaults['menu_mobile_background_color'] ) {
	 			echo '#mobile-menu { background:' . $colors['menu_mobile_background_color'] . '; }';
	 		}

			// Mobile menu link color.
			if ( isset( $colors['menu_mobile_link_color'] ) && $colors['menu_mobile_link_color'] !== $defaults['menu_mobile_link_color'] ) {
				echo '#mobile-menu a, #mobile-menu .current-menu-item > a, .dropdown-toggle { color:' . $colors['menu_mobile_link_color'] . '; }';

			}

			/**
			 * Site footer
			 */

			// Footer background color.
			if ( isset( $colors['footer_background_color'] ) && $colors['footer_background_color'] !== $defaults['footer_background_color'] ) {
				echo '.site-footer { background-color:' . $colors['footer_background_color'] . '; }';
			}

			// Footer text color.
			if ( isset( $colors['footer_text_color'] ) && $colors['footer_text_color'] !== $defaults['footer_text_color'] ) {
				echo '.site-footer { color:' . $colors['footer_text_color'] . '; }';
			}

			// Footer link color.
			if ( isset( $colors['footer_link_color'] ) && $colors['footer_link_color'] !== $defaults['footer_link_color'] ) {
				echo '.site-footer a { color:' . $colors['footer_link_color'] . '; }';
			}

			// Footer link hover color.
			if ( isset( $colors['footer_link_hover_color'] ) && $colors['footer_link_hover_color'] !== $defaults['footer_link_hover_color'] ) {
				echo '.site-footer a:hover { color:' . $colors['footer_link_hover_color'] . '; }';
			}

			// Footer heading color.
			if ( isset( $colors['footer_heading_color'] ) && $colors['footer_heading_color'] !== $defaults['footer_heading_color'] ) {
				echo '.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6 { color:' . $colors['footer_heading_color'] . '; }';
			}

			?>
		</style>
		<?php endif; ?>

	<?php }
endif;
add_action( 'wp_head', 'themedd_colors_output_customizer_styling' );


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
 * Render the cart icon for the selective refresh partial.
 *
 * @since 1.0.0
 * @see themedd_customize_register()
 *
 * @return void
 */
function themedd_customize_partial_cart_icon() {
	echo themedd_edd_cart_icon();
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

	if ( 'all' === themedd_edd_display_cart_options() ) {
		echo themedd_edd_cart_quantity();
		echo themedd_edd_cart_total();
	} elseif ( 'item_quantity' === themedd_edd_display_cart_options() ) {
		echo themedd_edd_cart_quantity();
	} elseif( 'cart_total' === themedd_edd_display_cart_options() ) {
		echo themedd_edd_cart_total();
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
		'all'           => __( 'Display item count and cart total', 'themedd' ),
		'none'          => __( 'Display nothing', 'themedd' )
	);
}
