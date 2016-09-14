<?php
/**
 * Enqueue scripts and styles
 *
 * @since  1.0
 */
function themedd_enqueue_scripts() {

	// register scripts
	wp_register_script( 'themedd-js', get_template_directory_uri() . '/js/themedd.min.js', array( 'jquery' ), THEMEDD_VERSION, true );
	wp_register_script( 'account-js', get_template_directory_uri() . '/js/account.min.js', array( 'jquery' ), THEMEDD_VERSION );
	wp_register_script( 'comment-reply', '', '', '',  true );

	if ( themedd_is_edd_sl_active() ) {
		wp_register_style( 'edd-sl-styles', plugins_url( '/css/edd-sl.css', EDD_SL_PLUGIN_FILE ), false, EDD_SL_VERSION );
	}

	// Loads our main stylesheet.
	wp_enqueue_style( 'themedd', get_stylesheet_uri(), array(), THEMEDD_VERSION );

	/**
	 * Themedd JS
	 */
	wp_enqueue_script( 'themedd-js' );

	wp_localize_script( 'themedd-js', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'themedd' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'themedd' ) . '</span>',
	) );

	/**
	 * Comments
	 */

	// We don't need the script on pages where there is no comment form and not on the homepage if it's a page. Neither do we need the script if comments are closed or not allowed. In other words, we only need it if "Enable threaded comments" is activated and a comment form is displayed.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}



	// load jQuery UI + tabs for account page
	if ( is_page_template( 'page-templates/account.php' ) ) {

		/**
		 * Account page
		 */
		wp_enqueue_script( 'jquery-ui-tabs' );

		// load jQuery UI
		wp_enqueue_script( 'jquery-ui-core' );

		// load account JS
		wp_enqueue_script( 'account-js' );

		// load EDD SL's CSS styles
		wp_enqueue_style( 'edd-sl-styles' );

	}

}
add_action( 'wp_enqueue_scripts', 'themedd_enqueue_scripts' );
