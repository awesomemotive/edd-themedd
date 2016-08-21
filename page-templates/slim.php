<?php
/**
 * Template name: Slim
 *
 */

get_header(); ?>

<?php themedd_post_header(); ?>

<div id="column-wrapper" class="wrapper<?php echo themedd_wrapper_classes(); ?>">

	<div id="primary" class="content-area <?php echo themedd_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile;
		?>
		</main>
	</div>

</div>

<?php
get_footer();
