<?php

/**
 * Loads the header onto the themedd_header action hook found in /header.php
 *
 * @since 1.0.0
 */
function themedd_header() {
	$site_header_wrap_classes = apply_filters( 'themedd_header_site_header_wrap_classes', array( 'site-header-wrap', 'between-xs' ) );
	?>

    <?php do_action( 'themedd_masthead_before' ); ?>

    <header id="masthead" class="site-header" role="banner">

        <?php do_action( 'themedd_masthead_start' ); ?>

        <div class="site-header-main">
			<?php do_action( 'themedd_site_header_main_start' ); ?>
            <div class="<?php echo implode( ' ', array_filter( $site_header_wrap_classes ) ); ?>">
                <?php do_action( 'themedd_site_header_main' ); ?>
            </div>
            <?php do_action( 'themedd_site_header_main_end' ); ?>
        </div>

        <?php do_action( 'themedd_masthead_end' ); ?>

    </header>

    <?php do_action( 'themedd_masthead_after' ); ?>

    <?php
}
add_action( 'themedd_header', 'themedd_header' );

/**
 * Load the skip link
 *
 * @since 1.0.0
 */
function themedd_skip_link() {
	?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'themedd' ); ?></a>
	<?php
}
add_action( 'themedd_masthead_before', 'themedd_skip_link' );

/**
 * Load the menu toggle
 *
 * @since 1.0.0
 */
function themedd_menu_toggle() {

    if ( ! has_nav_menu( 'mobile' ) ) {
        return;
    }

    ?>

    <?php do_action( 'themedd_menu_toggle_wrap_before' ); ?>

    <div id="menu-toggle-wrap">

        <?php do_action( 'themedd_menu_toggle_before' ); ?>

        <button id="menu-toggle" class="menu-toggle"><?php esc_html_e( 'Menu', 'themedd' ); ?></button>

        <?php do_action( 'themedd_menu_toggle_after' ); ?>

    </div>

    <?php do_action( 'themedd_menu_toggle_wrap_after' ); ?>

    <?php
}
// place the mobile menu toggle into the site header
add_action( 'themedd_site_header_main', 'themedd_menu_toggle' );

/**
 * Load our site logo
 *
 * @since 1.0.0
 */
function themedd_site_branding() {
	?>

    <?php do_action( 'themedd_site_branding_before' ); ?>

    <div class="site-branding">

        <?php do_action( 'themedd_site_branding_start' ); ?>

        <?php if ( is_front_page() && is_home() ) : ?>
            <h1 class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php do_action( 'themedd_site_branding_before_site_title' ); ?>
                    <span><?php bloginfo( 'name' ); ?></span>
                    <?php do_action( 'themedd_site_branding_after_site_title' ); ?>
                </a>
            </h1>
        <?php else : ?>
            <p class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php do_action( 'themedd_site_branding_before_site_title' ); ?>
                    <span><?php bloginfo( 'name' ); ?></span>
                    <?php do_action( 'themedd_site_branding_after_site_title' ); ?>
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

    <?php do_action( 'themedd_site_branding_after' ); ?>

	<?php
}
add_action( 'themedd_site_header_main', 'themedd_site_branding' );

/**
 * Loads the site navigation onto the themedd_masthead action hook
 *
 * @since 1.0.0
 */
function themedd_primary_menu() {
	?>

    <?php if ( has_nav_menu( 'primary' ) ) : ?>

		<?php do_action( 'themedd_primary_menu_start' ); ?>

		<div id="site-header-menu" class="site-header-menu">

	    	<nav id="site-navigation" class="main-navigation" role="navigation">
	            <?php
	    			wp_nav_menu(
	    				apply_filters( 'themedd_primary_menu', array(
	    					'menu_class'     => 'primary-menu menu',
	    					'theme_location' => 'primary',
	    					'container'      => '',
	    				))
	    			);
	    		?>
	    	</nav>

	    </div>

    <?php endif; ?>

	<?php
}
add_action( 'themedd_site_header_main_end', 'themedd_primary_menu' );

/**
 * Loads the mobile menu onto the themedd_menu_toggle_wrap_after action hook
 *
 * @since 1.0.0
 */
function themedd_mobile_menu() {

    wp_nav_menu(
        apply_filters( 'themedd_mobile_menu', array(
            'menu_id'         => 'mobile-menu',
            'menu_class'      => 'menu',
            'theme_location'  => 'mobile',
            'container_class' => 'mobile-navigation',
        ))
    );

}
add_action( 'themedd_menu_toggle_wrap_after', 'themedd_mobile_menu' );

/**
 * Loads the site's secondary navigation
 *
 * @since 1.0.0
 */
function themedd_secondary_menu() {

    /**
     * Show #site-header-secondary-menu if the secondary menu is active or cart icon is still positioned there
     */
	if ( has_nav_menu( 'secondary' ) || 'secondary_menu' === apply_filters( 'themedd_edd_cart_link_position', 'secondary_menu' ) ) : ?>
	<div id="site-header-secondary-menu" class="site-header-menu">

        <?php do_action( 'themedd_secondary_menu_before' ); ?>

        <?php if ( has_nav_menu( 'secondary' ) ) : ?>
    	<nav id="secondary-navigation" class="secondary-navigation" role="navigation">
            <?php
			wp_nav_menu(
				apply_filters( 'themedd_secondary_menu', array(
					'menu_id'        => 'secondary-menu',
					'menu_class'     => 'menu',
					'theme_location' => 'secondary',
					'depth'          => 1,
					'container'      => '',
				))
			);
    		?>
    	</nav>
        <?php endif; ?>

        <?php do_action( 'themedd_secondary_menu_after' ); ?>

    </div>
    <?php endif; ?>

	<?php
}
add_action( 'themedd_site_header_main', 'themedd_secondary_menu' );

/**
 * Themedd custom header
 *
 * @since 1.0.0
 */
function themedd_header_image() {
?>

<?php if ( get_header_image() ) : ?>
    <?php
        /**
         * Filter the default themedd custom header sizes attribute.
         *
         * @since Themedd 1.0.0
         *
         * @param string $custom_header_sizes sizes attribute
         * for Custom Header. Default '(max-width: 709px) 85vw,
         * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
         */
        $custom_header_sizes = apply_filters( 'themedd_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1188px' );
    ?>
    <div class="header-image">
        <img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
    </div>
<?php endif;

}
add_action( 'themedd_masthead_after', 'themedd_header_image' );


/**
 * Themedd custom logo
 *
 * @since 1.0.0
 */
function themedd_header_logo() {
	themedd_the_custom_logo();
}
add_action( 'themedd_site_branding_start', 'themedd_header_logo' );
