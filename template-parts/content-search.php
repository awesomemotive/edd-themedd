<?php
/**
 * The template part for displaying results in search pages
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( themedd_classes( array( 'classes' => array( 'mb-5', 'mb-lg-10' ), 'echo' => false ) ) ); ?>>
	<?php themedd_post_thumbnail(); ?>
	<header class="entry-header content-wrapper mb-3">
		<h2 class="entry-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo get_the_title(); ?>
			</a>
		</h2>
		<?php echo themedd_posted_on(); ?>
	</header>
	<div class="entry-summary content-wrapper">
		<?php the_excerpt(); ?>
	</div>
</article>
