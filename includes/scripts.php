<?php
/**
 * Enqueue scripts and styles
 *
 * @since  1.0
 */
function themedd_enqueue_scripts() {

	// Loads our main stylesheet.
	wp_enqueue_style( 'themedd', get_stylesheet_uri(), array(), THEMEDD_THEME_VERSION );

	/**
	 * Themedd JS
	 */
	wp_register_script( 'themedd-js', get_template_directory_uri() . '/js/rcp-parent-theme.min.js', array( 'jquery' ), THEMEDD_THEME_VERSION, true );
	wp_enqueue_script( 'themedd-js' );

	wp_localize_script( 'themedd-js', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'themedd' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'themedd' ) . '</span>',
	) );

	/**
	 * Comments
	 */
	wp_register_script( 'comment-reply', '', '', '',  true );

	// We don't need the script on pages where there is no comment form and not on the homepage if it's a page. Neither do we need the script if comments are closed or not allowed. In other words, we only need it if "Enable threaded comments" is activated and a comment form is displayed.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'themedd_enqueue_scripts' );
