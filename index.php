<?php
/**
 * The main template file
 */

get_header(); ?>

<div class="wrapper<?php echo trustedd_wrapper_classes(); ?>">

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

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

            <?php

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

	           ?>

		</main>
	</div>

	<?php trustedd_get_sidebar(); ?>

</div>


<?php
get_footer();
