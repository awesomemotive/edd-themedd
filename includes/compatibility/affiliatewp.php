<?php

/**
 * Dequeue AffiliateWP forms styling
 *
 * @since 1.0
 * @return void
 */
function themedd_affwp_styles() {

    global $post;

    // Dequeue AffiliateWP's forms.css file
    wp_dequeue_style( 'affwp-forms' );

    if ( ! is_object( $post ) ) {
        return;
    }

    $file_path = 'css/affiliatewp.min.css';
    $child_theme_style_sheet  = trailingslashit( get_stylesheet_directory() ) . $file_path;
    $parent_theme_style_sheet = trailingslashit( get_template_directory() ) . $file_path;

    if ( file_exists( $child_theme_style_sheet ) ) {
        $url = trailingslashit( get_stylesheet_directory_uri() ) . $file_path;
    } else {
        $url = trailingslashit( get_template_directory_uri() ) . $file_path;
    }

    wp_register_style( 'themedd-affiliatewp', $url, array(), THEMEDD_VERSION, 'all' );

    if ( has_shortcode( $post->post_content, 'affiliate_area' ) || has_shortcode( $post->post_content, 'affiliate_registration' ) || apply_filters( 'affwp_force_frontend_scripts', false ) ) {
        // Enqueue our own styling for AffiliateWP
        wp_enqueue_style( 'themedd-affiliatewp' );
    }

}
add_action( 'wp_enqueue_scripts', 'themedd_affwp_styles' );

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

            echo '<div class="col-xs-12 col-sm-8">';
            echo '<div class="box register">';
            affiliate_wp()->templates->get_template_part( 'register' );
            echo '</div>';
            echo '</div>';
        }

        if ( ! is_user_logged_in() ) {

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
 * @since 1.0
 */
function themedd_affwp_body_classes( $classes ) {
	global $post;

	// add a shop class if we're on a page where the [downloads] shortcode is used
	if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'affiliate_area' ) ) {
		$classes[] = 'affiliate-area';
	}

	return $classes;
}
add_filter( 'body_class', 'themedd_affwp_body_classes' );
