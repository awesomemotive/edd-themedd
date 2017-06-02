<?php
/**
 * The template used for displaying page content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * The featured image is loaded onto this hook
	 */
	 do_action( 'themedd_article_start' ); ?>

	<div class="entry-content">

		<?php do_action( 'themedd_entry_content_start' ); ?>

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'themedd' ),
				'after'  => '</div>',
			) );
		?>

		<?php themedd_entry_footer(); ?>

		<?php do_action( 'themedd_entry_content_end' ); ?>

	</div>

</article>
