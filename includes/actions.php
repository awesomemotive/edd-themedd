<?php

/**
 * Show the entry footer info (Categories and tags + edit link).
 *
 * @since 1.0.0
 */
function themedd_show_entry_footer() {
	if ( is_singular( 'post' ) ) {
		themedd_entry_footer();
	}
}
add_action( 'themedd_entry_article_end', 'themedd_show_entry_footer' );

/**
 * Show the entry meta.
 *
 * @since 1.1
 */
function themedd_show_entry_meta( $args ) {
	if ( $args['posted_on'] ) {
		echo themedd_posted_on( $args['show_author'] );
	}
}
add_action( 'themedd_header_container_end', 'themedd_show_entry_meta', 10, 1 );

/**
 * Load the biography template after the entry content on a single post.
 *
 * @since 1.0.0
 */
function themedd_show_author_biography() {
	if ( is_singular( 'post' ) && (bool) get_the_author_meta( 'description' ) ) {
		get_template_part( 'template-parts/biography' );
	}
}
add_action( 'themedd_entry_article_end', 'themedd_show_author_biography' );

/**
 * Displays a "Continue reading" link below the post's entry summary
 *
 * @since 1.1
 */
function themedd_more_link() {
	?>
	<p class="more-link">
		<a href="<?php echo esc_url( get_permalink() ); ?>"><?php printf( __( 'Read now<span class="sr-only"> "%s"</span>', 'themedd' ), get_the_title( get_the_ID() ) ); ?></a>
	</p>
<?php
}
add_action( 'themedd_entry_summary_end', 'themedd_more_link' );
