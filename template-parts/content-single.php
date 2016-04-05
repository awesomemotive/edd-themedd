<?php
/**
 * The template used for displaying page content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php themedd_post_thumbnail(); ?>

	<?php //themedd_entry_date(); ?>

	<div class="entry-content">

		<?php do_action( 'themedd_entry_content_start' ); ?>

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'themedd' ),
				'after'  => '</div>',
			) );
		?>

		<?php do_action( 'themedd_entry_content_end' ); ?>

	</div>

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
	</footer><!-- .entry-footer -->

</article>
