<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php trustedd_post_thumbnail( 'large' ); ?>

	<?php if ( is_search() ) : ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
	<?php else : ?>

	<div class="entry-content">
		<?php
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyfourteen' ) );
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfourteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div>

	<?php endif; ?>

</article>
