<?php

/**
 * Loads the header onto the themedd_header action hook found in /header.php
 *
 * @since 1.0
 */
function themedd_header() {
    ?>

    <?php do_action( 'themedd_masthead_before' ); ?>

    <header id="masthead" class="site-header" role="banner">

        <?php do_action( 'themedd_masthead_start' ); ?>

        <div class="site-header-main">
            <div class="site-header-wrap">
                <?php do_action( 'themedd_site_header_main' ); ?>
            </div>
            <?php do_action( 'site_header_main_end' ); ?>
        </div>

        <?php do_action( 'themedd_masthead_end' ); ?>

    </header>

    <?php do_action( 'themedd_masthead_after' ); ?>

    <?php
}
add_action( 'themedd_header', 'themedd_header' );

/**
 * Default positioning of menus and site branding
 */
add_action( 'themedd_site_header_main', 'themedd_site_branding' );
add_action( 'themedd_site_header_main', 'themedd_secondary_menu' );
add_action( 'site_header_main_end', 'themedd_primary_menu');


/**
 * Load our site logo
 *
 * @since 1.0
 */
function themedd_site_branding() {
	?>

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
        <?php endif;

        $description = get_bloginfo( 'description', 'display' );
        if ( $description || is_customize_preview() ) : ?>
            <p class="site-description"><?php echo $description; ?></p>
        <?php endif; ?>

        <?php do_action( 'themedd_site_branding_end' ); ?>

    </div>

	<?php
}

/**
 * Loads the site navigation onto the themedd_masthead action hook
 *
 * @since 1.0
 */
function themedd_primary_menu() {
	?>

    <?php if ( has_nav_menu( 'primary' ) ) : ?>

		<div id="menu-toggle-wrap">
			<?php do_action( 'themedd_menu_toggle_before' ); ?>
			<button id="menu-toggle" class="menu-toggle"><?php esc_html_e( 'Menu', 'themedd' ); ?></button>
			<?php do_action( 'themedd_menu_toggle_after' ); ?>
		</div>

		<div id="site-header-menu" class="site-header-menu">

	    	<nav id="site-navigation" class="main-navigation" role="navigation">
	            <?php
	    			wp_nav_menu(
	    				apply_filters( 'themedd_primary_menu', array(
	    					'menu_id'        => 'primary-menu',
	    					'menu_class'     => 'menu',
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


/**
 * Loads the site's secondary navigation onto the themedd_masthead action hook
 *
 * @since 1.0
 */
function themedd_secondary_menu() {

    $cart_link_position = function_exists( 'themedd_cart_link_position' ) ? themedd_cart_link_position() : '';

    if ( 'secondary' !== $cart_link_position && ! has_nav_menu( 'secondary' ) ) {
		return;
	}

	?>

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
    					'container'      => '',
    				))
    			);
    		?>
    	</nav>
        <?php endif; ?>

        <?php do_action( 'themedd_secondary_menu_after' ); ?>

    </div>


	<?php
}
