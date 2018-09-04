<?php

/**
 * Load the "skip" link onto the themedd_site_header hook found in /header.php.
 *
 * @since 1.0.0
 */
function themedd_skip_link() {
	?>
	<a id="skippy" class="sr-only sr-only-focusable" href="#content">
		<div class="container">
			<span class="skiplink-text"><?php esc_html_e( 'Skip to main content', 'themedd' ); ?></span>
		</div>
	</a>
<?php
}
add_action( 'themedd_site_header', 'themedd_skip_link' );

/**
 * Load the header section onto the themedd_site_header hook found in /header.php.
 *
 * @since 1.0.0
 */
function themedd_site_header() {

	// Get the position of the cart.
	$cart_position = themedd_is_edd_active() ? themedd_edd_load_nav_cart()->cart_position() : false;

	// Get the breakpoint at which the menus switch (mobile menu vs primary menu).
	$breakpoint = themedd_menu_breakpoint();

	// Set up default container classes.
	$container_classes = array( 'container py-3 justify-content-center' );

	// Centers .site-branding when Distraction Free checkout is enabled, otherwise left aligns it.
	$container_classes[] = themedd_edd_is_distraction_free_checkout() ? 'text-center' : 'justify-content-' . $breakpoint . '-start';
	?>
	<header id="masthead" class="site-header" role="banner">

		<div class="navbar navbar-expand-<?php echo $breakpoint; ?> px-0 py-0">
			<?php echo themedd_navbar_toggler(); ?>
		</div>

		<div id="navbar-mobile" class="navbar px-0 px-<?php echo $breakpoint; ?>-3 py-0 d-<?php echo $breakpoint; ?>-none">
			<div class="container">
				<nav class="navbar-collapse collapse" id="nav-mobile">
					<?php echo themedd_header_search( array( 'form_classes' => array( 'py-2 pt-3' ) ) ); ?>
					<?php echo themedd_nav_cart( array( 'nav_cart_classes' => array( 'py-2' ) ) ); ?>
					<?php echo themedd_mobile_menu(); ?>
				</nav>
			</div>
		</div>

		<div class="navbar navbar-expand-<?php echo $breakpoint; ?> px-0 py-0">
			<div class="<?php echo themedd_output_classes( $container_classes ); ?>">

				<?php echo themedd_site_branding(); ?>

				<?php if ( themedd_nav_cart() || themedd_secondary_navigation() || themedd_header_search() ) : ?>
				<nav id="nav-secondary" class="navbar-collapse collapse justify-content-end">
					<?php echo themedd_secondary_navigation( array( 'menu_classes' => array( 'navbar-right' ) ) ); ?>
					<?php if ( 'secondary_menu' === $cart_position ) { echo themedd_nav_cart( array( 'nav_cart_classes' => array( 'ml-lg-3' ) ) ); } ?>
					<?php echo themedd_header_search( array( 'form_classes' => array( 'ml-3' ) ) ); ?>
				<?php endif; ?>

			</div>
		</div>

		<?php if ( themedd_primary_navigation() ) : ?>
		<div id="navbar-primary" class="navbar navbar-expand-<?php echo $breakpoint; ?> px-0 py-0">
			<div class="container">
				<nav class="navbar-collapse collapse" id="nav-primary">
					<?php echo themedd_primary_navigation( array( 'menu_classes' => array( 'navbar-left' ) ) ); ?>
					<?php if ( 'primary_menu' === $cart_position ) { echo themedd_nav_cart( array( 'nav_cart_classes' => array( 'ml-auto' ) ) ); } ?>
				</nav>
			</div>
		</div>
		<?php endif; ?>

	</header>
<?php
}
add_action( 'themedd_site_header', 'themedd_site_header' );

/**
 * Navbar toggler.
 *
 * @since 1.1
 */
function themedd_navbar_toggler( $args = array() ) {

	if ( themedd_edd_is_distraction_free_checkout() ) {
		return false;
	}

	$toggler_defaults = themedd_navbar_toggler_defaults( $args );

	$args = wp_parse_args( $args, $toggler_defaults );

	$target = $args['target'];

	// No target, no menu.
	if ( empty( $target ) ) {
		return false;
	}

	// Must have either text or icon, otherwise don't show menu.
	if ( empty( $args['text_menu_hidden'] ) && empty( $args['icon_menu_hidden'] ) ) {
		return false;
	}

	// Add button classes that should never change.
	$args['button_classes'][] = 'navbar-toggler collapsed';

	// Text for when menu is hidden. Default: Menu
	$text_menu_hidden = ! empty( $args['text_menu_hidden'] ) ? $args['text_menu_hidden'] : '';

	if ( $text_menu_hidden ) {
		$data_text_menu_hidden = ' data-text-menu-hidden="' . $text_menu_hidden . '"';
	} else {
		$data_text_menu_hidden = '';
	}

	// Text for when menu is shown. Default: Close
	$text_menu_shown = ! empty( $args['text_menu_shown'] ) ? $args['text_menu_shown'] : '';

	if ( $text_menu_shown ) {
		$data_text_menu_shown = ' data-text-menu-shown="' . $text_menu_shown . '"';
	} else {
		$data_text_menu_shown = '';
	}

	// Icon for when menu is hidden. Default: menu
	$icon_menu_hidden = ! empty( $args['icon_menu_hidden'] ) ? $args['icon_menu_hidden'] : '';

	if ( $icon_menu_hidden ) {
		$data_icon_menu_hidden = ' data-icon-menu-hidden="' . $icon_menu_hidden . '"';
	} else {
		$data_icon_menu_hidden = '';
	}

	// Icon for when menu is shown. Default: close-menu
	$icon_menu_shown = ! empty( $args['icon_menu_shown'] ) ? $args['icon_menu_shown'] : '';

	if ( $icon_menu_shown ) {
		$data_icon_menu_shown = ' data-icon-menu-shown="' . $icon_menu_shown . '"';
	} else {
		$data_icon_menu_shown = '';
	}

	if ( themedd_mobile_menu_theme_location() ) : ?>
	<button class="<?php echo themedd_output_classes( $args['button_classes'] ); ?>" type="button"<?php echo $data_text_menu_hidden . $data_text_menu_shown . $data_icon_menu_hidden . $data_icon_menu_shown; ?> data-toggle="collapse" data-target="#<?php echo $target; ?>" aria-controls="<?php echo $target; ?>" aria-expanded="false" aria-label="<?php echo $args['aria_label']; ?>">
		<?php if ( $icon_menu_hidden ) { 
			echo themedd_get_svg( array( 'icon' => $icon_menu_hidden ) ); 
		} ?>

		<?php if ( $text_menu_hidden ) : ?>
		<span class="navbar-toggler-text ml-1"><?php echo $text_menu_hidden; ?></span>
		<?php endif; ?>
	</button>
	<?php endif;
}

/**
 * Get the theme location for the mobile menu.
 *
 * @since 1.1
 */
function themedd_mobile_menu_theme_location() {

	if ( has_nav_menu( 'mobile' ) ) {
		$theme_location = 'mobile';
	} elseif ( has_nav_menu( 'primary' ) ) {
		$theme_location = 'primary';
	} else {
		$theme_location = false;
	}
	
	return $theme_location;

}

/**
 * Loads the mobile menu.
 *
 * @since 1.1
 */
function themedd_mobile_menu() {
	
	if ( themedd_mobile_menu_theme_location() ) {
		wp_nav_menu(
			array(
				'theme_location' => themedd_mobile_menu_theme_location(),
				'depth'          => 2,
				'menu_id'        => 'menu-mobile',
				'menu_class'     => 'navbar-nav',
				'walker'         => new WP_Bootstrap_Navwalker()
			)
		);
	}

}

/**
 * Loads the primary navigation.
 *
 * @since 1.0.0
 */
function themedd_primary_navigation( $args = array() ) {

	// Return false if there is no menu assigned or we're on EDD checkout with Distraction Free Checkout enabled.
	if ( ! has_nav_menu( 'primary' ) || themedd_edd_is_distraction_free_checkout() ) {
		return false;
	}

	$defaults = array(
		'menu_classes' => array()
	);

	$args = wp_parse_args( $args, $defaults );

	// Add any default menu classes that cannot be overridden.
	$args['menu_classes'][] = 'navbar-nav';

	ob_start();

	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'depth'           => 2,
			'container'       => '',
			'container_class' => '',
			'container_id'    => '',
			'menu_id'         => 'menu-primary',
			'menu_class'      => implode( ' ', $args['menu_classes'] ),
			'fallback_cb'     => '',
			'walker'          => new WP_Bootstrap_Navwalker()
		)
	);

	return ob_get_clean();
}

/**
 * Loads the site's secondary navigation.
 *
 * @since 1.0.0
 */
function themedd_secondary_navigation( $args = array() ) {
	
	// Return false if there is no menu assigned or we're on EDD checkout with Distraction Free Checkout enabled.
	if ( ! ( has_nav_menu( 'secondary' ) ) || themedd_edd_is_distraction_free_checkout() ) {
		return false;
	}

	$defaults = array(
		'menu_classes' => array()
	);

	$args = wp_parse_args( $args, $defaults );

	// Add any default menu classes that cannot be overridden.
	$args['menu_classes'][] = 'navbar-nav';

	ob_start();

	wp_nav_menu(
		array(
			'theme_location'  => 'secondary',
			'depth'           => 2,
			'container'	      => '',
			'container_class' => '',
			'container_id'    => '',
			'menu_id'         => 'menu-secondary',
			'menu_class'      => implode( ' ', $args['menu_classes'] ),
			'fallback_cb'     => '',
			'walker'          => new WP_Bootstrap_Navwalker()
		)
	);

	return ob_get_clean();
}


/**
 * Load the nav cart.
 *
 * @since 1.1
 */
function themedd_nav_cart( $args = array() ) {

	// Easy Digital Downloads must be active.
	if ( ! themedd_is_edd_active() ) {
		return false;
	}

	return themedd_edd_load_nav_cart()->cart( $args );

}

/**
 * Load the header search.
 *
 * @since 1.1
 */
function themedd_header_search( $args = array() ) {
	return themedd_load_search()->header_search_form( $args );
}

/**
 * Load the site branding (site title, site description, logo).
 *
 * @since 1.0.0
 */
function themedd_site_branding() {
	$tag     = is_front_page() || is_home() ? 'h1' : 'p';
	$classes = array( 'site-title', 'mb-0', 'h1' );
	?>

	<div class="site-branding<?php if ( ! display_header_text() ) { echo ' sr-only'; } ?>">

		<?php do_action( 'themedd_site_branding_start' ); ?>

		<?php 
		/**
		 * Site title.
		 */
		?>
		<<?php echo $tag; ?> class="<?php echo themedd_output_classes( $classes ); ?>">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand mr-0">
				<?php //do_action( 'themedd_site_branding_site_title_before' ); ?>
				<span><?php bloginfo( 'name' ); ?></span>
				<?php //do_action( 'themedd_site_branding_site_title_after' ); ?>
			</a>
		</<?php echo $tag; ?>>

	<?php
	/**
	 * Site description.
	 */
	$description = get_bloginfo( 'description', 'display' );
	if ( $description || is_customize_preview() ) : ?>
		<p class="site-description mb-0 d-none d-<?php echo themedd_menu_breakpoint(); ?>-block"><?php echo $description; ?></p>
	<?php endif; ?>
	</div>

	<?php
}

/**
 * Themedd custom header.
 *
 * @since 1.0.0
 */
function themedd_header_image() {
    
    if ( get_header_image() ) : ?>

    <div class="header-image">

		<?php if ( themedd_layout_full_width() ) : ?>
			<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
		<?php else : ?>
			<?php
		        /**
		         * Filter the default themedd custom header sizes attribute.
		         *
		         * @since Themedd 1.0.0
		         *
		         * @param string $custom_header_sizes sizes attribute
		         * for Custom Header. Default '(max-width: 709px) 85vw,
		         * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1480px'.
		         */
		        $custom_header_sizes = apply_filters( 'themedd_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1480px' );
		    ?>
			<img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
		<?php endif; ?>

    </div>
<?php endif;
}
add_action( 'themedd_site_header', 'themedd_header_image' );

/**
 * Themedd custom logo.
 *
 * @since 1.0.0
 */
function themedd_header_logo() {
	themedd_the_custom_logo();
}
add_action( 'themedd_site_branding_start', 'themedd_header_logo' );