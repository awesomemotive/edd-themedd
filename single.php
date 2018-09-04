<?php
/**
 * The template for displaying all single posts and attachments
 */

get_header();
themedd_header( array( 'posted_on' => true ) ); 
?>

<?php do_action( 'themedd_single_start' ); ?>

<div class="<?php echo themedd_output_classes( themedd_wrapper_classes() ); ?>">
	<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the single post content template.
			get_template_part( 'template-parts/content', 'single' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			if ( is_singular( 'attachment' ) ) {
				echo '<div class="container">';
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'themedd' ),
				) );
				echo '</div>';
			} elseif ( is_singular( 'post' ) ) {
				echo '<div class="container content-wrapper">';

				// Previous/next post navigation.
				the_post_navigation( array(
					'next_text' => '<span class="meta-nav d-block" aria-hidden="true">' . __( 'Next', 'themedd' ) . '</span> ' .
						'<span class="sr-only">' . __( 'Next post:', 'themedd' ) . '</span> ' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="meta-nav d-block" aria-hidden="true">' . __( 'Previous', 'themedd' ) . '</span> ' .
						'<span class="sr-only">' . __( 'Previous post:', 'themedd' ) . '</span> ' .
						'<span class="post-title">%title</span>',
				) );

				echo '</div>';
			}

			// End of the loop.
		endwhile;
		?>

		</main>
	</div>

	<?php themedd_get_sidebar(); ?>
</div>

<?php get_footer(); ?>
