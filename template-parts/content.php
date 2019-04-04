<?php
/**
 * The template part for displaying content
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( themedd_classes( array( 'classes' => array( 'mb-5', 'mb-lg-10' ), 'echo' => false ) ) ); ?>>

	<?php themedd_post_thumbnail( array( 'classes' => array( 'mb-4' ) ) ); ?>

	<header class="entry-header content-wrapper mb-3">
		<h2 class="entry-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_title(); ?>
			</a>
		</h2>
		<?php echo themedd_posted_on(); ?>
	</header>

	<?php if ( is_search() || is_archive() || themedd_display_excerpts() ) : ?>

		<div class="entry-summary content-wrapper">
			<?php the_excerpt(); ?>
			<?php do_action( 'themedd_entry_summary_end' ); ?>
		</div>

	<?php else : ?>

		<div class="entry-content content-wrapper">
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
