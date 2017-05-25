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
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'themedd_custom_header_args', array(
		'width'            => 1480,
		'height'           => 280,
		'flex-height'      => true,
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

	$text_color = get_header_textcolor();

	// If no custom color for text is set, let's bail.
	if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) ) {
		return;
	}

	// If we get this far, we have custom styles.
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
 * Bind JS handlers to instantly live-preview changes.
 *
 * @since 1.0
 */
function themedd_customize_preview_js() {
	wp_enqueue_script( 'themedd-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), THEMEDD_VERSION, true );
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
			'selector'            => '.site-title a',
			'container_inclusive' => false,
			'render_callback'     => 'themedd_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'            => '.site-description',
			'container_inclusive' => false,
			'render_callback'     => 'themedd_customize_partial_blogdescription',
		) );

		// Rename the label to "Site Title Color" because this only affects the site title in this theme.
		$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'themedd' );

		// Add a description to the Site Title Color.
		$wp_customize->get_control( 'header_textcolor' )->description = __( 'The color of the site title.', 'themedd' );

		// Add a description to the "Background Color".
		$wp_customize->get_control( 'background_color' )->description = __( 'The color of the site\'s background.', 'themedd' );

		// Tagline color.
		$wp_customize->add_setting( 'colors[tagline_color]', array(
			'transport' => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagline_color', array(
			'label'       => __( 'Tagline Color', 'themedd' ),
			'description' => __( 'The site tagline (if set) color.', 'themedd' ),
			'section'     => 'colors',
			'settings'    => 'colors[tagline_color]',
		) ) );

		// Link colors.
		$wp_customize->add_setting( 'colors[link_color]', array(
			'transport' => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
			'label'       => __( 'Link Color', 'themedd' ),
			'description' => __( 'The color of general links.', 'themedd' ),
			'section'     => 'colors',
			'settings'    => 'colors[link_color]',
		) ) );

		// Primary menu background color.
		$wp_customize->add_setting( 'colors[menu_primary_background_color]', array(
			'transport' => 'postMessage',
		) );

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
			'transport' => 'postMessage',
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

		// Primary menu link hover/active color.
		$wp_customize->add_setting( 'colors[menu_primary_link_hover_color]', array(
			'transport' => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'menu_primary_link_hover_color',
			array(
				'label'       => __( 'Primary Menu Link Hover/Active Color', 'themedd' ),
				'description' => __( 'The color of primary menu links when hovered over, or are active.', 'themedd' ),
				'settings'    => 'colors[menu_primary_link_hover_color]',
				'section'     => 'colors',
			)
		));

		// Primary sub-menu background color.
		$wp_customize->add_setting( 'colors[menu_primary_sub_background_color]', array(
			'transport' => 'postMessage',
		) );

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

		// Primary sub-menu link color.
		$wp_customize->add_setting( 'colors[menu_primary_sub_link_color]', array(
			'transport' => 'postMessage',
		) );

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
			'transport' => 'postMessage',
		) );

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

		// Header background color.
		$wp_customize->add_setting( 'colors[header_background_color]', array(
			'transport' => 'postMessage',
		) );

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

		// Secondary menu link color.
		$wp_customize->add_setting( 'colors[menu_secondary_link_color]', array(
			'transport' => 'postMessage',
		) );

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
			'transport' => 'postMessage',
		) );

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
			'transport' => 'postMessage',
		) );

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
			'transport' => 'postMessage',
		) );

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

		/**
		 * Easy Digital Downloads section
		 */
		$wp_customize->add_section( 'easy_digital_downloads', array(
			'title'           => __( 'Easy Digital Downloads', 'themedd' ),
			'priority'        => 20,
			'active_callback' => 'themedd_is_edd_active'
		) );

		/**
		 * Distraction Free Checkout setting
		 */
		$wp_customize->add_setting( 'easy_digital_downloads[distraction_free_checkout]', array(
			'sanitize_callback' => 'themedd_sanitize_checkbox'
		) );

		$wp_customize->add_control( 'distraction_free_checkout', array(
			'label'       => __( 'Distraction Free Checkout', 'themedd' ),
			'settings'    => 'easy_digital_downloads[distraction_free_checkout]',
			'section'     => 'easy_digital_downloads',
			'type'        => 'checkbox',
			'description' => __( 'Header menus, footer widgets and sidebars will all be removed from checkout, allowing customers to complete their purchase with no distractions.', 'themedd' ),
		) );

		/**
		 * Show EDD related options
		 */
		if ( themedd_is_edd_active() ) {

			// Mobile cart icon color.
			$wp_customize->add_setting( 'colors[mobile_cart_icon_color]', array(
				'transport' => 'postMessage',
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
				'transport' => 'postMessage',
			) );

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

			// Cart count background color
			$wp_customize->add_setting( 'colors[cart_count_background_color]', array(
				'transport' => 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'cart_count_background_color',
				array(
					'label'       => __( 'Cart Count Background Color', 'themedd' ),
					'description' => sprintf( __( 'The background color of the cart count. Add a %s to the cart to see the cart count.', 'themedd' ), strtolower( edd_get_label_singular() ) ),
					'settings'    => 'colors[cart_count_background_color]',
					'section'     => 'colors',
				)
			));

			// Cart count color
			$wp_customize->add_setting( 'colors[cart_count_color]', array(
				'transport' => 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control(
				$wp_customize,
				'cart_count_color',
				array(
					'label'       => __( 'Cart Count Color', 'themedd' ),
					'description' => sprintf( __( 'The text color of the cart count. Add a %s to the cart to see the cart count.', 'themedd' ), strtolower( edd_get_label_singular() ) ),
					'settings'    => 'colors[cart_count_color]',
					'section'     => 'colors',
				)
			));
		}

	}

}
add_action( 'customize_register', 'themedd_customize_register' );

/**
 * Output styling to <head>
 *
 * @since 1.0
 */
function themedd_colors_output_customizer_styling() { ?>

	<?php

		$colors = get_theme_mod( 'colors' );

		// Get the header text color. Themedd uses this for the site title color
		$site_title_color = get_header_textcolor();

		if ( $colors ) {
			$colors = array_filter( $colors );
		}

		if ( empty( $colors ) ) {
			return;
		}

	?>

		<style id="themedd-custom-css" type="text/css">
		<?php

		// Site title hover color.
		if ( $site_title_color ) {
			echo '.site-title a, .site-title a:hover { color: #' . $site_title_color . ';}';
		}

		// Link color.
		if ( isset( $colors['tagline_color'] ) ) {
			echo '.site-description { color:' . $colors['tagline_color'] . ';}';
		}

		// Link color.
		if ( isset( $colors['link_color'] ) ) {
			echo 'a { color:' . $colors['link_color'] . ';}';
		}

		// Site header background.
		if ( isset( $colors['header_background_color'] ) ) {
			echo '#masthead { background:' . $colors['header_background_color'] . ';}';
		}

		// Primary menu background color.
		if ( isset( $colors['menu_primary_background_color'] ) ) {
			echo '#site-header-menu { background:' . $colors['menu_primary_background_color'] . ';}';

			//
			echo '#mobile-menu { background:' . $colors['menu_primary_background_color'] . ';}';
		}

		// Primary menu link color.
		if ( isset( $colors['menu_primary_link_color'] ) ) {
			echo '.main-navigation a { color:' . $colors['menu_primary_link_color'] . ';}';

			//
			echo '#mobile-menu a { color:' . $colors['menu_primary_link_color'] . ';}';

			// dropdown toggle
			echo '.dropdown-toggle { color:' . $colors['menu_primary_link_color'] . ';}';
		}

		// Primary menu link hover/active color
		if ( isset( $colors['menu_primary_link_hover_color'] ) ) {
			echo '.main-navigation li:hover > a, .main-navigation li.focus > a, .main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a { color:' . $colors['menu_primary_link_hover_color'] . ';}';

			// mobile menu styles
			echo '#mobile-menu a:hover,	#mobile-menu a:focus, #mobile-menu .current-menu-item > a, #mobile-menu .current_page_ancestor > a { color:' . $colors['menu_primary_link_hover_color'] . ';}';

			// dropdown toggle styles
			echo '.dropdown-toggle:hover, .dropdown-toggle:focus { color:' . $colors['menu_primary_link_hover_color'] . ';}';

		}

		// Primary sub-menu background color.
		if ( isset( $colors['menu_primary_sub_background_color'] ) ) {
			echo '.main-navigation ul ul li { background:' . $colors['menu_primary_sub_background_color'] . ';}';
			echo '.main-navigation ul ul { border-color:' . $colors['menu_primary_sub_background_color'] . ';}';
		}

		// Primary sub-menu link color.
		if ( isset( $colors['menu_primary_sub_link_color'] ) ) {
			echo '.main-navigation .sub-menu a { color:' . $colors['menu_primary_sub_link_color'] . ';}';
		}

		// Primary sub-menu link hover color.
		if ( isset( $colors['menu_primary_sub_link_hover_color'] ) ) {
			echo '.main-navigation .sub-menu li:hover > a, .main-navigation .sub-menu li.focus > a { color:' . $colors['menu_primary_sub_link_hover_color'] . ';}';
		}

		// Secondary menu link color.
		if ( isset( $colors['menu_secondary_link_color'] ) ) {
			echo '#site-header-secondary-menu a { color:' . $colors['menu_secondary_link_color'] . ';}';
		}

		// Secondary menu link hover color.
		if ( isset( $colors['menu_secondary_link_hover_color'] ) ) {
			echo '#site-header-secondary-menu a:hover { color:' . $colors['menu_secondary_link_hover_color'] . ';}';
		}

		// Mobile cart icon color.
		if ( isset( $colors['mobile_cart_icon_color'] ) ) {
			echo '.nav-cart.mobile .nav-cart-icon, .items-in-cart .nav-cart.mobile .nav-cart-icon { fill:' . $colors['mobile_cart_icon_color'] . ';}';
		}

		// Cart icon color.
		if ( isset( $colors['cart_icon_color'] ) ) {
			echo '.nav-cart-icon, .items-in-cart .nav-cart-icon { fill:' . $colors['cart_icon_color'] . ';}';
		}

		// Cart count background color.
		if ( isset( $colors['cart_count_background_color'] ) ) {
			echo '.cart-count { background:' . $colors['cart_count_background_color'] . ';}';
		}

		// Cart count color.
		if ( isset( $colors['cart_count_color'] ) ) {
			echo '.cart-count { color:' . $colors['cart_count_color'] . ';}';
		}

		// Button background color.
		if ( isset( $colors['button_background_color'] ) ) {
			echo '.button, button, input[type="submit"], #submit { background:' . $colors['button_background_color'] . '; border-color: ' . $colors['button_background_color'] . '; }';
		}

		// Button background hover color.
		if ( isset( $colors['button_background_hover_color'] ) ) {
			echo '.button:hover, .button:focus, button:hover, input[type="submit"]:hover, #submit:hover { background:' . $colors['button_background_hover_color'] . '; border-color: ' . $colors['button_background_hover_color'] . '; }';
		}

		?>
	</style>

<?php }
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
