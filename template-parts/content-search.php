<?php
/**
 * The template part for displaying results in search pages
 *
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

	<?php themedd_post_thumbnail(); ?>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
</article>
