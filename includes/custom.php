<?php

/**
 * Remove styling from subtitles plugin
 */
if ( class_exists( 'Subtitles' ) && method_exists( 'Subtitles', 'subtitle_styling' ) ) {
    remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
}

/**
 * Modify subtitles
 * @todo move to child theme
 * @since 1.0.0
 */
function trustedd_modify_subtitles( $title ) {
  global $post;

  // Remove subtitles from the download grid
  if ( isset( $post->post_content ) && in_the_loop() && ! has_shortcode( $post->post_content, 'downloads' ) ) {
    add_filter( 'subtitle_view_supported', '__return_false' );
  }

  // allow subtitles on pages, and outside of the loop
  if ( is_singular() ) {
      add_filter( 'subtitle_view_supported', '__return_true' );
  }

  return $title;
}
add_filter( 'the_title', 'trustedd_modify_subtitles' );




/**
 * Filter subtitle markup
 *
 * @since 1.0.0
 */
function trustedd_subtitle_markup( $markup ) {

    $markup['before'] = '<span class="subtitle">';

    return $markup;
}
add_filter( 'subtitle_markup', 'trustedd_subtitle_markup' );

/**
 * Load the header
 *
 * @since 1.0
 */
function trustedd_header() {
    ?>

    <?php do_action( 'trustedd_header_start' ); ?>

    <header id="masthead" class="site-header" role="banner">

        <?php do_action( 'trustedd_masthead_start' ); ?>

        <div class="site-header-main">
        <?php do_action( 'trustedd_masthead' ); ?>
        </div>

        <?php do_action( 'trustedd_masthead_end' ); ?>

    </header>

    <?php do_action( 'trustedd_header_end' ); ?>

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

        <?php do_action( 'trustedd_site_branding_start' ); ?>

        <?php if ( is_front_page() && is_home() ) : ?>
            <h1 class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php do_action( 'trustedd_site_branding_before_site_title' ); ?>
                    <span><?php bloginfo( 'name' ); ?></span>
                    <?php do_action( 'trustedd_site_branding_after_site_title' ); ?>
                </a>
            </h1>
        <?php else : ?>
            <p class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <?php do_action( 'trustedd_site_branding_before_site_title' ); ?>
                    <span><?php bloginfo( 'name' ); ?></span>
                    <?php do_action( 'trustedd_site_branding_after_site_title' ); ?>
                </a>
            </p>
        <?php endif;

        $description = get_bloginfo( 'description', 'display' );
        if ( $description || is_customize_preview() ) : ?>
            <p class="site-description"><?php echo $description; ?></p>
        <?php endif; ?>

        <?php do_action( 'trustedd_site_branding_end' ); ?>

    </div>

	<?php
}
add_action( 'trustedd_masthead', 'trustedd_site_branding' );

/**
 * Post/entry meta shown in sidebar
 *
 * @since 1.0.0
 */
function trustedd_post_meta() {

    if ( ! is_singular( 'post' ) ) {
        return;
    }

    ?>

    <footer class="entry-footer">
		<?php trustedd_entry_meta(); ?>
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit %s', 'trustedd' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer>

    <?php
}
add_action( 'trustedd_primary_sidebar_start', 'trustedd_post_meta' );
