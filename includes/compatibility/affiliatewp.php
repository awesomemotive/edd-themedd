<?php

/**
 * Dequeue AffiliateWP forms styling
 *
 * @since 1.0
 * @return void
 */
function themedd_dequeue_affwp_styles() {
    wp_dequeue_style( 'affwp-forms' );
}
add_action( 'wp_enqueue_scripts', 'themedd_dequeue_affwp_styles' );

/**
 * Forces the affiliate area page to be full-width
 *
 * @since 1.0
 * @return array
 */
function themedd_affwp_force_full_width( $classes ) {

	if ( is_page( affiliate_wp()->settings->get( 'affiliates_page' ) ) && is_user_logged_in() ) {
		$classes[] = 'full-width';
	}

    if ( is_page( affiliate_wp()->settings->get( 'affiliates_page' ) ) && ! is_user_logged_in() && affiliate_wp()->settings->get( 'allow_affiliate_registration' ) ) {
		$classes[] = 'wide';
	}

	return $classes;

}
add_filter( 'themedd_wrapper_classes', 'themedd_affwp_force_full_width' );


remove_shortcode( 'affiliate_area', array( affiliate_wp(), 'affiliate_area' ) );
add_shortcode( 'affiliate_area', 'themedd_affiliate_area' );

/**
 *  Renders the affiliate area
 *
 *  @since 1.0
 *  @return string
 */
function themedd_affiliate_area( $atts, $content = null ) {

    // See https://github.com/AffiliateWP/AffiliateWP/issues/867
    if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
        return;
    }

    ob_start();

    if ( is_user_logged_in() && affwp_is_affiliate() ) {

        affiliate_wp()->templates->get_template_part( 'dashboard' );

    } elseif ( is_user_logged_in() && affiliate_wp()->settings->get( 'allow_affiliate_registration' ) ) {

        affiliate_wp()->templates->get_template_part( 'register' );

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

        //$class = ! affiliate_wp()->settings->get( 'allow_affiliate_registration' ) ? ' center-xs' : '';
        $class = '';

        echo '<div class="row' . $class . '">';

        if ( affiliate_wp()->settings->get( 'allow_affiliate_registration' ) ) {

            echo '<div class="col-xs-12 col-sm-6">';
            echo '<div class="box register">';
            affiliate_wp()->templates->get_template_part( 'register' );
            echo '</div>';
            echo '</div>';
        }

        if ( ! is_user_logged_in() ) {

            $class = affiliate_wp()->settings->get( 'allow_affiliate_registration' ) ? ' col-sm-6' : ' col-sm-12';

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
