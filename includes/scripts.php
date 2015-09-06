<?php
/**
 * Enqueue scripts and styles
 *
 * @since  1.0
 */
function trustedd_enqueue_scripts() {

	// Loads our main stylesheet.
	wp_enqueue_style( 'trustedd-css', get_stylesheet_uri(), array(), TRUSTEDD_THEME_VERSION );

	/**
	 * Trustedd JS
	 */
	wp_register_script( 'trustedd-js', get_template_directory_uri() . '/js/trustedd.min.js', array( 'jquery' ), TRUSTEDD_THEME_VERSION, true );
	wp_enqueue_script( 'trustedd-js' );

	/**
	 * Comments
	 */
	wp_register_script( 'comment-reply', '', '', '',  true );

	// We don't need the script on pages where there is no comment form and not on the homepage if it's a page. Neither do we need the script if comments are closed or not allowed. In other words, we only need it if "Enable threaded comments" is activated and a comment form is displayed.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/magnific-popup.js', array( 'jquery' ), TRUSTEDD_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'trustedd_enqueue_scripts' );
