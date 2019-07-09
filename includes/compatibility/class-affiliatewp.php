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
		add_action( 'template_redirect', array( $this, 'shortcode' ) );
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_filter( 'affwp_login_form', array( $this, 'login_form' ) );
		add_filter( 'affwp_register_form', array( $this, 'registration_form' ) );
		add_filter( 'themedd_show_sidebar', array( $this, 'hide_sidebar' ) );
	}

	/**
	 * Hide sidebar on affiliate area.
	 *
	 * @since 1.0.0
	 */
	public function hide_sidebar( $return ) {

		if ( is_page( affiliate_wp()->settings->get( 'affiliates_page' ) ) ) {
			$return = false;
		}

		return $return;
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
	 * Remove [affiliate_area] shortcode and add our own
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function shortcode() {
		remove_shortcode( 'affiliate_area', array( affiliate_wp(), 'affiliate_area' ) );
		add_shortcode( 'affiliate_area', array( $this, 'affiliate_area' ) );
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
	 * Renders the affiliate area
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function affiliate_area( $atts, $content = null ) {

		// See https://github.com/AffiliateWP/AffiliateWP/issues/867
		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			return;
		}

		affwp_enqueue_script( 'affwp-frontend', 'affiliate_area' );

		/**
		 * Filters the display of the login form
		 *
		 * @since AffiliateWP 2.0
		 * @param bool $show Whether to show the login form. Default true.
		 */
		$show_login = apply_filters( 'affwp_affiliate_area_show_login', true );

	    ob_start();

	    if ( is_user_logged_in() && affwp_is_affiliate() ) {
	        affiliate_wp()->templates->get_template_part( 'dashboard' );

	    } elseif ( is_user_logged_in() && affiliate_wp()->settings->get( 'allow_affiliate_registration' ) && true === self::show_registration() ) {

			echo '<div class="box">';

			if ( function_exists( 'affwp_afgf_get_registration_form_id' ) && affwp_afgf_get_registration_form_id() ) {
				gravity_form( affwp_afgf_get_registration_form_id() );
			} else {
				affiliate_wp()->templates->get_template_part( 'register' );
			}

			echo '</div>';

	    } else {

	        if ( ! affiliate_wp()->settings->get( 'allow_affiliate_registration' ) ) {
	            echo '<div class="wrapper slim">';
	        }

	        if ( ! affiliate_wp()->settings->get( 'allow_affiliate_registration' ) ) {
	            echo '<div class="row">';
	            echo '<div class="col-xs-12">';
	            affiliate_wp()->templates->get_template_part( 'no', 'access' );
	            echo '</div>';
	            echo '</div>';
	        }

	        $class = '';

	        echo '<div class="row' . $class . '">';

	        if ( affiliate_wp()->settings->get( 'allow_affiliate_registration' ) && true === self::show_registration() ) {

	            echo '<div class="col-xs-12 col-sm-8">';
				echo '<div class="box">';

				if ( function_exists( 'affwp_afgf_get_registration_form_id' ) && affwp_afgf_get_registration_form_id() ) {
					gravity_form( affwp_afgf_get_registration_form_id() );
				} else {
					affiliate_wp()->templates->get_template_part( 'register' );
				}


	            echo '</div>';
	            echo '</div>';
	        }

	        if ( ! is_user_logged_in() && true === $show_login ) {

	            $class = affiliate_wp()->settings->get( 'allow_affiliate_registration' ) ? ' col-sm-4' : ' col-sm-12';

	            echo '<div class="col-xs-12' . $class . '">';
	            echo '<div class="box login">';
				affiliate_wp()->templates->get_template_part( 'login' );
	            echo '</div>';
	            echo '</div>';
	        }

	        echo '</div>';

	        if ( ! affiliate_wp()->settings->get( 'allow_affiliate_registration' ) ) {
	            echo '</div>';
	        }

	    }

	    return ob_get_clean();

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

		// Apply a "slim" class when the user is logged in, affiliate registration is allowed, and the registration form can be shown.
		if (
			is_user_logged_in() &&
			affiliate_wp()->settings->get( 'allow_affiliate_registration' ) &&
			true === self::show_registration() &&
			! ( affwp_is_active_affiliate() && affwp_is_affiliate() )
		) {
			$classes[] = 'slim';
		}

		return $classes;

	}

	/**
	 * Wrap [affilate_login] login form in div
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function login_form() {
		ob_start();
	?>

	<div class="box login">
	<?php affiliate_wp()->templates->get_template_part( 'login' ); ?>
	<div>

	<?php
		return ob_get_clean();
	}

	/**
	 * Wrap [affilate_registration] form in div
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function registration_form() {
		ob_start();
	?>

	<div class="box register">
	<?php affiliate_wp()->templates->get_template_part( 'register' ); ?>
	<div>

	<?php
		return ob_get_clean();
	}


}
new Themedd_AffiliateWP;
