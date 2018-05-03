<?php

if ( ! function_exists( 'themedd_styles' ) ) :
function themedd_styles() {

	// Suffix.
	$suffix = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? '' : '.min';

	// Theme stylesheet.
	wp_enqueue_style( 'themedd', get_theme_file_uri( 'style' . $suffix . '.css' ), array(), THEMEDD_VERSION );

}
add_action( 'wp_enqueue_scripts', 'themedd_styles' );
endif;

/**
 * Enqueue scripts and styles
 *
 * @since 1.0.0
 */
function themedd_scripts() {

	wp_register_script( 'comment-reply', '', '', '',  true );

	// Suffix.
	$suffix = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'themedd-js', get_theme_file_uri( '/assets/js/themedd' . $suffix . '.js' ), array( 'jquery' ), THEMEDD_VERSION, true );

	// Load the nav cart.
	if ( class_exists( 'Themedd_EDD_Nav_Cart' ) ) {
		
		$cart_option = Themedd_EDD_Nav_Cart::cart_option();

		if ( 'item_quantity' === $cart_option || 'all' === $cart_option ) {
			
			$cart_quantity_text = Themedd_EDD_Nav_Cart::cart_quantity_text();
		
			// Cart text
			wp_localize_script( 'themedd-js', 'cartQuantityText', array(
				'singular' => $cart_quantity_text['singular'],
				'plural'   => $cart_quantity_text['plural']
			) );
		}

	}

	/**
	 * Comments
	 */

	// We don't need the script on pages where there is no comment form and not on the homepage if it's a page. Neither do we need the script if comments are closed or not allowed. In other words, we only need it if "Enable threaded comments" is activated and a comment form is displayed.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'themedd_scripts' );

/**
 *  Load the admin styles
 *
 *  @since 1.0
 *  @return void
 */
function themedd_admin_styles() {
	wp_enqueue_style( 'themedd-admin', get_theme_file_uri( '/assets/css/admin.css' ), array(), THEMEDD_VERSION );
}
add_action( 'admin_enqueue_scripts', 'themedd_admin_styles' );
