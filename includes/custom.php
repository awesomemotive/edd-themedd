<?php

/**
 * Remove styling from subtitles plugin
 */
if ( class_exists( 'Subtitles' ) && method_exists( 'Subtitles', 'subtitle_styling' ) ) {
    remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
}

/**
 * Remove subtitles from download grid
 *
 * @since 1.0.0
 */
function trustedd_remove_subtitles() {

    global $post;

    if ( ! class_exists( 'Subtitles' ) ) {
        return;
    }

    if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'downloads' ) ) {
        remove_filter( 'the_title', array( Subtitles::getInstance(), 'the_subtitle' ), 10, 2 );
    }

}
add_action( 'template_redirect', 'trustedd_remove_subtitles' );

/**
 * Load the header
 *
 * @since 1.0
 */
function trustedd_header() {
    ?>

    <header id="masthead" class="site-header" role="banner">

    <?php do_action( 'trustedd_masthead_start' ); ?>

        <div class="wrapper">

            <?php do_action( 'trustedd_masthead' ); ?>

        </div>

    </header>

    <?php
}
add_action( 'trustedd_header', 'trustedd_header' );


/**
 * Load our site logo
 *
 * @since 1.0
 */
function trustedd_site_branding() {

	?>
	<div class="site-branding">
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		</h1>
		<?php if ( get_bloginfo( 'description' ) ) : ?>
		<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'trustedd_masthead', 'trustedd_site_branding' );

/**
 * Load our site navigation
 *
 * @since 1.0
 */
function trustedd_navigation() {
	?>

	<nav id="site-navigation" class="main-navigation" role="navigation">
		<a href="#menu" class="menu-link"><?php _e( 'Menu', 'trustedd' ); ?></a>
		<?php
			wp_nav_menu(
				apply_filters( 'trustedd_navigation', array(
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'menu',
					'theme_location' => 'primary',
					'container'      => '',
				))
			);
		?>
	</nav>

	<?php
}
add_action( 'trustedd_masthead', 'trustedd_navigation' );


/**
 * Modify the CSS class assigned to the page.php template dynamically
 *
 * @since 1.0
 */
function trustedd_page_wrapper_classes() {

	global $post;

    $body_classes = get_body_class();

    if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'downloads' ) ) {
		$class = ' extra-wide';
	} else {
        $class = ' slim';
    }

	return $class;
}
