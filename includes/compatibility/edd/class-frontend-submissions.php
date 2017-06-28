<?php

/**
 * EDD Frontend Submissions
 */
class Themedd_EDD_Frontend_Submissions {

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_filter( 'template_include', array( $this, 'vendor_page' ), 10, 1 );
		add_filter( 'fes_vendor-contact_form_title', array( $this, 'contact_form_title' ), 10, 1 );
	}

	/**
	 * Set the title of the vendor contact form
	 *
	 * @since 1.0.0
	 */
	public function contact_form_title( $title ) {
		return apply_filters( 'themedd_edd_fes_contact_form_title', __( 'Contact vendor', 'themedd' ) );
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

		// Load styles.
		if (
			fes_is_frontend() &&
			( is_page( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) || is_page( EDD_FES()->helper->get_option( 'fes-vendor-page', false ) ) )
		) {
			wp_enqueue_style( 'themedd-edd-fes' );
		}

	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function body_classes( $classes ) {
		global $post;

		if ( isset( $_GET['task'] ) && 'edit-product' === $_GET['task'] ) {
			$classes[] = 'fes-edit-download';
		}

		if ( isset( $_GET['task'] ) && 'edit-order' === $_GET['task'] ) {
			$classes[] = 'fes-edit-order';
		}

		return $classes;
	}

	/**
	 * Get the FES vendor URL
	 *
	 * @since 1.0.0
	 */
	public function author_url( $author = null ) {

		if ( ! $author ) {
			$author = wp_get_current_user();
		} else {
			$author = new WP_User( $author );
		}

		if ( ! class_exists( 'EDD_Front_End_Submissions' ) ) {
			return get_author_posts_url( $author->ID, $author->user_nicename );
		}

		return EDD_FES()->vendors->get_vendor_store_url( $author->ID );
	}

	/**
	 * Load the vendor page.
	 *
	 * @since 1.0.0
	 */
	public function vendor_page( $template ) {

		if ( is_page( EDD_FES()->helper->get_option( 'fes-vendor-page', false ) ) ) {

			// Provide the path to our new template.
			// This template can be overridden from a child theme.
			$new_template = locate_template( array( 'template-parts/vendor-page.php' ) );

			// Only load our new template if it can be found and there's not already a page template assigned.
			if ( '' !== $new_template && ! is_page_template() ) {
				// Return our new template.
				return $new_template;
			}

		}

		// Return the current template as before.
		return $template;

	}

}
new Themedd_EDD_Frontend_Submissions;
