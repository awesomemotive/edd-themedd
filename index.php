<?php
/**
 * The main template file
 */

get_header(); ?>

<div class="wrapper wide">
	<div id="primary" class="content-area">
		<?php
			if ( have_posts() ) :

				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;

			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'content', 'none' );

			endif;
		?>

	</div>
</div>

<?php
get_footer();
