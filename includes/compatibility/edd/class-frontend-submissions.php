<?php

/**
 * EDD Frontend Submissions
 */
class Themedd_EDD_Frontend_Submissions {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
	}

	/**
	 * Enqueue custom styling.
	 */
	public function styles() {

		// Dequeue the styling so it doesn't matter if the admin option is enabled or not.
		wp_dequeue_style( 'fes-css' );

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Get the file path of the CSS file.
		$file_path = '/assets/css/edd-fes' . $suffix . '.css';

		// Register the styles.
		wp_register_style( 'themedd-edd-fes', get_theme_file_uri( $file_path ), array(), filemtime( get_theme_file_path( $file_path ) ), 'all' );

		// Load styles if we're on the frontend and the dashboard page.
		if ( fes_is_frontend() && is_page( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) ) {
			wp_enqueue_style( 'themedd-edd-fes' );
		}

	}

}
new Themedd_EDD_Frontend_Submissions;
