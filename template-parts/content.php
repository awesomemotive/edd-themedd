<?php
/**
 * The template part for displaying content
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'mb-5', 'mb-lg-10', 'content-wrapper' ) ); ?>>

	<?php
		themedd_header(
			array(
				'heading_size'    => 'h2',
				'posted_on'       => true,
				'heading_classes' => array( 'entry-title' ),
				'permalink'       => esc_url( get_permalink() ),
				'header_classes'  => array( 'text-center', 'mb-5' )
			)
		);
	?>

	<?php themedd_post_thumbnail( array( 'classes' => array( 'alignwide' ) ) ); ?>

	<?php if ( is_search() || is_archive() || themedd_display_excerpts() ) : ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div>

	<?php else : ?>

		<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					__( 'Continue reading %s', 'themedd' ),
					the_title( '<span class="sr-only">"', '"</span>', false )
				) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'themedd' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="sr-only">' . __( 'Page', 'themedd' ) . ' </span>%',
					'separator'   => '<span class="sr-only">, </span>',
				) );
			?>
		</div>

	<?php endif; ?>

</article>
