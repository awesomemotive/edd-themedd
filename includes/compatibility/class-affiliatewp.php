<?php

/**
 * AffiliateWP
 */
class Themedd_AffiliateWP {

	/**
	 * Get things started.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_filter( 'template_include', array( $this, 'template_affiliate_area' ), 99 );
	}

	/**
	 * Load custom template for the Affiliate Area.
	 *
	 * @since 1.1
	 */
	function template_affiliate_area( $template ) {

		if ( $this->is_affiliate_area() ) {
			$file = array( 'affiliatewp/affiliate-area.php' );
			$new_template = locate_template( $file );
			if ( ! empty( $new_template ) ) {
				return $new_template;
			}
		}

		return $template;

	}

	/**
	 * Determine if the current page is the Affiliate Area.
	 *
	 * @since 1.1
	 */
	public function is_affiliate_area() {
		return is_page( affiliate_wp()->settings->get( 'affiliates_page' ) );
	}

	/**
	 * Enqueue custom styling.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function styles() {

		global $post;

		// Dequeue AffiliateWP's forms.css file.
	    wp_dequeue_style( 'affwp-forms' );

		if ( ! is_object( $post ) ) {
	        return;
	    }

		$style_deps  = array();

		if ( isset( $_REQUEST['tab'] ) && 'graphs' === sanitize_key( $_REQUEST['tab'] ) ) {
			$style_deps[] = 'jquery-ui-css';
		}

		$suffix = defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ? '' : '.min';

		// Load styles.
		if ( has_shortcode( $post->post_content, 'affiliate_area' ) || has_shortcode( $post->post_content, 'affiliate_registration' ) || apply_filters( 'affwp_force_frontend_scripts', true ) ) {
	        // Enqueue our own styling for AffiliateWP
			wp_enqueue_style( 'themedd-affiliatewp', get_theme_file_uri( '/assets/css/affiliatewp' . $suffix . '.css' ), $style_deps, THEMEDD_VERSION );
	    }

	}

	/**
	 * Helper function for determining if the affiliate registration form can be shown.
	 *
	 * @access private
	 * @since AffiliateWP 2.0
	 * @param bool $show Whether to show the registration form. Default true.
	 */
	private static function show_registration() {
		return apply_filters( 'affwp_affiliate_area_show_registration', true );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function body_classes( $classes ) {
		global $post;

		if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'affiliate_area' ) ) {
			$classes[] = 'affiliate-area';
		} else {
			return $classes;
		}

		return $classes;

	}

}
new Themedd_AffiliateWP;
