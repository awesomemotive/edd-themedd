<?php

/**
 * Load the "skip" link onto the themedd_header hook found in /header.php.
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
add_action( 'themedd_header', 'themedd_skip_link' );

/**
 * Load the header section onto the themedd_header hook found in /header.php.
 *
 * @since 1.0.0
 */
function themedd_header() {
?>
    <header id="masthead" class="site-header" role="banner">
        <?php do_action( 'themedd_header_masthead' ); ?>
    </header>
<?php
}
add_action( 'themedd_header', 'themedd_header' );

/**
 * Load div.site-header-main inside header#masthead.
 *
 * @see themedd_header()
 * @since 1.0.3
 */
function themedd_header_masthead() {
?>
    <div class="site-header-main">
        <?php do_action( 'themedd_site_header_main' ); ?>
    </div>
<?php
}
add_action( 'themedd_header_masthead', 'themedd_header_masthead' );

/**
 * Load the site branding (site title, site description, logo) inside div.site-header-wrap.
 *
 * @since 1.0.0
 */
function themedd_site_branding() {
	?>
	<div class="navbar navbar-expand-lg navbar-light px-0">
		<div class="container<?php if ( edd_is_checkout() && themedd_edd_distraction_free_checkout() && edd_get_cart_contents() ) { echo ' justify-content-center text-center'; } ?>">

			<div class="site-branding">
					
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand">
							<?php do_action( 'themedd_site_branding_site_title_before' ); ?>
							<span><?php bloginfo( 'name' ); ?></span>
							<?php do_action( 'themedd_site_branding_site_title_after' ); ?>
						</a>
					</h1>
				<?php else : ?>
					<p class="site-title mb-0">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="navbar-brand">
							<?php do_action( 'themedd_site_branding_site_title_before' ); ?>
							<span><?php bloginfo( 'name' ); ?></span>
							<?php do_action( 'themedd_site_branding_site_title_after' ); ?>
						</a>
					</p>
				<?php endif; ?>

				<?php
				/**
				 * Description
				 */
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description mb-0 d-none d-sm-block"><?php echo $description; ?></p>
				<?php endif; ?>

			</div>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<?php do_action( 'themedd_site_branding_end' ); ?>

		</div>
	</div>

	<?php
}
add_action( 'themedd_site_header_main', 'themedd_site_branding' );

/**
 * Loads the site navigation onto the themedd_masthead action hook
 *
 * @since 1.0.0
 */
function themedd_primary_menu() {

    if ( has_nav_menu( 'primary' ) ) : ?>

		<div id="site-header-menu" class="site-header-menu">
			<nav class="navbar navbar-expand-lg navbar-light px-0">
				<div class="container">

					<div class="collapse navbar-collapse" id="navbar">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'depth'				=> 2, // 1 = with dropdowns, 0 = no dropdowns.
								'container'			=> '',
								'container_class'	=> '',
								'container_id'		=> '',
								'menu_id'           => 'menu-primary',
								'menu_class'		=> 'navbar-nav mr-auto',
								'fallback_cb'		=> 'WP_Bootstrap_Navwalker::fallback',
								'walker'			=> new WP_Bootstrap_Navwalker()
							)
						);
					?>
					</div>
				</div>
			</nav>
	    </div>

    <?php endif;
}
add_action( 'themedd_site_header_main', 'themedd_primary_menu' );

/**
 * Loads the site's secondary menu
 *
 * This contains:
 *
 * 1. The secondary navigation (if set)
 * 2. The EDD cart (if enabled)
 * 3. The header search box (if enabled)  
 *
 * @since 1.0.0
 */
function themedd_secondary_menu() {

    /**
     * Only show the secondary menu if there's something hooked onto it
     */
    if ( has_action( 'themedd_secondary_menu' ) ) : ?>
	<div id="site-header-secondary-menu" class="site-header-menu">
        <?php do_action( 'themedd_secondary_menu' ); ?>
    </div>
    <?php endif;
}
add_action( 'themedd_site_branding_end', 'themedd_secondary_menu' );

/**
 * Loads the site's secondary navigation
 *
 * @since 1.0.0
 */
function themedd_secondary_navigation() {
	?>
	
	<nav class="navbar navbar-expand-lg navbar-light px-0">
		<div class="container">

			<div class="collapse navbar-collapse" id="navbar2">
			<?php
				wp_nav_menu(
					array(
						'theme_location'   => 'secondary',
						'depth'            => 2, // 1 = with dropdowns, 0 = no dropdowns.
						'container'	       => '',
						'container_class'  => '',
						'container_id'     => '',
						'menu_id'          => 'menu-secondary',
						'menu_class'       => 'navbar-nav mr-auto',
						'fallback_cb'      => 'WP_Bootstrap_Navwalker::fallback',
						'walker'           => new WP_Bootstrap_Navwalker()
					)
				);
			?>
			</div>

			<?php do_action( 'themedd_secondary_menu_after' ); ?>
		</div>
	</nav>

    <?php
}

/**
 * Themedd custom header
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
add_action( 'themedd_header', 'themedd_header_image' );

/**
 * Themedd custom logo
 *
 * @since 1.0.0
 */
function themedd_header_logo() {
	themedd_the_custom_logo();
}
add_action( 'themedd_site_branding_start', 'themedd_header_logo' );
