<?php

/**
 * Load the featured image on the themedd_article_start hook
 * This allows us to remove the featured image dynamically where needed
 *
 * @since 1.0.0
 */
function themedd_load_post_thumbnail() {
	themedd_post_thumbnail();
}
add_action( 'themedd_article_start', 'themedd_load_post_thumbnail' );

/**
 * Load the post header on the themedd_single_start hook
 * This allows us to remove the header dynamically where needed
 *
 * @since 1.0.0
 */
function themedd_load_post_header() {
	themedd_post_header();
}
add_action( 'themedd_single_start', 'themedd_load_post_header' );

/**
 * Load the biography template after the entry content
 *
 * @since 1.0.0
 */
function themedd_load_biography() {

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	if ( '' !== get_the_author_meta( 'description' ) ) {
		get_template_part( 'template-parts/biography' );
	}

}
add_action( 'themedd_entry_content_end', 'themedd_load_biography' );
