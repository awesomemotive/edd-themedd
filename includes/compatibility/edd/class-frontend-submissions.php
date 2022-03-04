<?php

/**
 * EDD Frontend Submissions
 */
class Themedd_EDD_Frontend_Submissions {

	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_filter( 'fes_custom_css_updated', '__return_true' );
		add_action( 'template_redirect', array( $this, 'remove_body_classes' ) );

		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_filter( 'page_template', array( $this, 'single_vendor_page_template' ), 10, 3 );
		add_filter( 'fes_vendor-contact_form_title', array( $this, 'contact_form_title' ), 10, 1 );
		add_filter( 'shortcode_atts_downloads', array( $this, 'single_vendor_page_download_columns' ), 10, 4 );

	}

	/**
	 * Remove any default body classes from the single vendor page.
	 * These could be applied for example if the vendor page has a page template applied.
	 *
	 * @since 1.0.0
	 */
	public function remove_body_classes() {

		if ( $this->is_single_vendor_page() ) {
			remove_filter( 'body_class', 'themedd_body_classes' );
		}


	}

	/**
	 * Filter the [downloads] shortcode for the single vendor page.
	 * Sets the number of columns to 2.
	 *
	 * @since 1.0.0
	 */
	public function single_vendor_page_download_columns( $out, $pairs, $atts, $shortcode ) {

		if ( $this->is_single_vendor_page() ) {
			$out['columns'] = apply_filters( 'themedd_edd_fes_single_vendor_page_columns', 2 );
		}

		return $out;

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
			( is_page( EDD_FES()->helper->get_option( 'fes-vendor-dashboard-page', false ) ) || $this->is_vendor_page() )
		) {
			wp_enqueue_style( 'themedd-edd-fes' );
		}

	}

	/**
	 * Determine if the current page is the vendor page
	 *
	 * @since 1.0.0
	 *
	 * @return true if page is vendor page, false otherwise.
	 */
	public function is_vendor_page() {
		return is_page( EDD_FES()->helper->get_option( 'fes-vendor-page', false ) );
	}

	/**
	 * Determine if the current page is the single vendor page
	 *
	 * @since 1.0.0
	 *
	 * @return true if page is single vendor page, false otherwise.
	 */
	public function is_single_vendor_page() {
		return EDD_FES()->vendor_shop->get_queried_vendor();
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @access public
	 * @since  1.0.0
	 *
	 * @return array $classes
	 */
	public function body_classes( $classes ) {

		global $post;

		// Single vendor page.
		if ( $this->is_single_vendor_page() ) {

			$classes[] = 'edd-fes-single-vendor-page';

			/**
			 * Remove any unneeded body classes from the single vendor page when a page template is assigned to the main vendor page (/vendor)
			 */
			foreach( $classes as $key => $class ) {
				if ( in_array( $class, array(
					'page-template',
					'page-template-page-templates',
					'page-template-slim',
					'page-template-page-templatesslim-php',
					'page-template-full-width',
					'page-template-page-templatesfull-width-php'
				) ) ) {
					unset( $classes[$key] );
				}
			}

		}

		if ( $this->is_vendor_page() && ! $this->is_single_vendor_page() ) {
			$classes[] = 'edd-fes-vendor-page';
		}

		if ( isset( $_GET['task'] ) && 'edit-product' === $_GET['task'] ) {
			$classes[] = 'edd-fes-edit-download';
		}

		if ( isset( $_GET['task'] ) && 'edit-order' === $_GET['task'] ) {
			$classes[] = 'edd-fes-edit-order';
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
	 * Set the template for the single vendor page.
	 *
	 * @since 1.0.0
	 */
	public function single_vendor_page_template( $template, $type, $templates ) {

		if ( $this->is_single_vendor_page() ) {
			$template = get_theme_file_path( '/single-vendor.php' );
		}

		return $template;

	}

}
new Themedd_EDD_Frontend_Submissions;
