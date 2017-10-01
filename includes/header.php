<?php

/**
 * Load the "skip" link onto the themedd_header hook found in /header.php.
 *
 * @since 1.0.0
 */
function themedd_skip_link() {
?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'themedd' ); ?></a>
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
 * Load div.site-header-wrap inside div.site-header-main.
 *
 * @since 1.0.3
 */
function themedd_site_header_main() {
    $site_header_wrap_classes = apply_filters( 'themedd_header_site_header_wrap_classes', array( 'site-header-wrap', 'between-xs' ) );
?>
    <div class="<?php echo implode( ' ', array_filter( $site_header_wrap_classes ) ); ?>">
        <?php do_action( 'themedd_site_header_wrap' ); ?>
    </div>
<?php
}
add_action( 'themedd_site_header_main', 'themedd_site_header_main' );

/**
 * Load the menu toggle inside div.site-header-wrap.
 * This displays a "Menu" button, and when clicked changes to "Close Menu"
 *
 * @since 1.0.0
 */
function themedd_menu_toggle() {
    if ( ! ( has_nav_menu( 'primary' ) || has_nav_menu( 'mobile' ) ) ) {
        return;
    }
?>
    <div id="menu-toggle-wrap">
        <button id="menu-toggle" class="menu-toggle"><?php esc_html_e( 'Menu', 'themedd' ); ?></button>
    </div>
<?php
}
add_action( 'themedd_site_header_wrap', 'themedd_menu_toggle' );

/**
 * Loads the mobile menu onto the themedd_site_header_wrap action hook
 *
 * @since 1.0.0
 */
function themedd_mobile_menu() {
    
    // Use the mobile menu if it exists, otherwise fallback to primary.
    $theme_location = has_nav_menu( 'mobile' ) ? 'mobile' : 'primary';

    wp_nav_menu(
        apply_filters( 'themedd_mobile_menu', array(
            'menu_id'         => 'mobile-menu',
            'menu_class'      => 'menu',
            'theme_location'  => $theme_location,
            'container_class' => 'mobile-navigation',
        ))
    );

}
add_action( 'themedd_site_header_wrap', 'themedd_mobile_menu' );

/**
 * Load the site branding (site title, site description, logo) inside div.site-header-wrap.
 *
 * @since 1.0.0
 */
function themedd_site_branding() {
?>

	<div class="<?php echo implode( ' ', array_filter( apply_filters( 'themedd_site_branding_classes', array( 'site-branding', 'center-xs', 'start-sm' ) ) ) ); ?>">
        
        <?php do_action( 'themedd_site_branding_start' ); ?>

        <?php if ( is_front_page() && is_home() ) : ?>
            <h1 class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php do_action( 'themedd_site_branding_site_title_before' ); ?>
                    <span><?php bloginfo( 'name' ); ?></span>
                    <?php do_action( 'themedd_site_branding_site_title_after' ); ?>
                </a>
            </h1>
        <?php else : ?>
            <p class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
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
            <p class="site-description"><?php echo $description; ?></p>
        <?php endif; ?>

        <?php do_action( 'themedd_site_branding_end' ); ?>

    </div>

	<?php
}
add_action( 'themedd_site_header_wrap', 'themedd_site_branding' );

/**
 * Loads the site navigation onto the themedd_masthead action hook
 *
 * @since 1.0.0
 */
function themedd_primary_menu() {

    if ( has_nav_menu( 'primary' ) ) : ?>

		<div id="site-header-menu" class="site-header-menu">
	    	<nav id="site-navigation" class="main-navigation" role="navigation">
	            <?php
				wp_nav_menu(
					apply_filters( 'themedd_primary_menu', array(
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'primary-menu menu',
						'theme_location' => 'primary',
						'container'      => '',
					))
				);
	    		?>
	    	</nav>
	    </div>

    <?php endif;
}
add_action( 'themedd_site_header_main', 'themedd_primary_menu' );

/**
 * Loads the site's secondary navigation
 *
 * @since 1.0.0
 */
function themedd_secondary_menu() {

    /**
     * Show #site-header-secondary-menu if the secondary menu is active or cart icon is still positioned there
     */
	if ( has_nav_menu( 'secondary' ) || 'secondary_menu' === apply_filters( 'themedd_edd_cart_position', 'secondary_menu' ) ) : ?>
	<div id="site-header-secondary-menu" class="site-header-menu">

        <?php do_action( 'themedd_secondary_menu_before' ); ?>

        <?php if ( has_nav_menu( 'secondary' ) ) : ?>
    	<nav id="secondary-navigation" class="secondary-navigation" role="navigation">
            <?php
			wp_nav_menu(
                apply_filters( 'themedd_secondary_menu', 
                    array(
                        'menu_id'        => 'secondary-menu',
                        'menu_class'     => 'menu',
                        'theme_location' => 'secondary',
                        'depth'          => 1,
                        'container'      => '',
                    )
                )
			);
    		?>
    	</nav>
        <?php endif; ?>

        <?php do_action( 'themedd_secondary_menu_after' ); ?>

    </div>
    <?php endif; ?>

	<?php
}
add_action( 'themedd_site_header_wrap', 'themedd_secondary_menu' );

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
