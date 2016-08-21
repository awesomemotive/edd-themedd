<?php

/**
 * Remove styling from subtitles plugin
 */
if ( class_exists( 'Subtitles' ) && method_exists( 'Subtitles', 'subtitle_styling' ) ) {
    remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
}

/**
 * Modify subtitles
 * @todo move to child theme
 * @since 1.0.0
 */
function themedd_modify_subtitles( $title ) {
    global $post;

    // Remove subtitles from the download grid
    if ( isset( $post->post_content ) && in_the_loop() && has_shortcode( $post->post_content, 'downloads' ) ) {
        add_filter( 'subtitle_view_supported', '__return_false' );
    }

    return $title;
}
add_filter( 'the_title', 'themedd_modify_subtitles' );

/**
 * Filter subtitle markup
 *
 * @since 1.0.0
 */
function themedd_subtitle_markup( $markup ) {

    $markup['before'] = '<span class="subtitle">';

    return $markup;
}
add_filter( 'subtitle_markup', 'themedd_subtitle_markup' );
