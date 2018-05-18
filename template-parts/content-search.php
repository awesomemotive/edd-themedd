<?php
/**
 * The template part for displaying results in search pages
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php 
		themedd_header( 
			array(
				'posted_on'       => true,
				'heading_size'    => 'h2',
				'heading_classes' => array( 'entry-title' ),
				'permalink'       => esc_url( get_permalink() ),
				'header_classes'  => themedd_has_sidebar() ? array( 'entry-header', 'mb-3' ) : array( 'entry-header', 'py-5', 'py-lg-5' )
			) 
		); 
	?>

	<?php themedd_post_thumbnail(); ?>

	<div class="entry-summary content-wrapper">
		<?php the_excerpt(); ?>
	</div>

</article>
