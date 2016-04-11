<?php
/**
 * Archive.php
 * controls styling for categories, tags etc
 */

get_header(); ?>

<div id="column-wrapper" class="wrapper<?php echo themedd_wrapper_classes(); ?>">

	<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">
			<?php
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );

					endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'template-parts/content', 'none' );

				endif;
			?>
		</main>
	</div>

	<?php themedd_get_sidebar(); ?>

</div>

<?php
get_footer();
