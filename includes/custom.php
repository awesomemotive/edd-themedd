<?php

/**
 * Post/entry meta shown in sidebar
 *
 * @since 1.0.0
 */
function themedd_post_meta() {

    if ( ! is_singular( 'post' ) ) {
        return;
    }

    ?>

    <footer class="entry-footer">
		<?php themedd_entry_meta(); ?>
		<?php
			edit_post_link(
				sprintf(
					/* translators: %s: Name of current post */
					__( 'Edit %s', 'themedd' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				),
				'<span class="edit-link">',
				'</span>'
			);
		?>
	</footer>

    <?php
}
add_action( 'themedd_primary_sidebar_start', 'themedd_post_meta' );
