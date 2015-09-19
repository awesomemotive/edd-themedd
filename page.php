<?php
/**
 * The template for displaying all pages
 *
 * @package Trustedd
 */

get_header(); ?>

<div class="wrapper">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'content', 'page' );

			endwhile;
		?>
		</main>
	</div>

	<?php get_sidebar(); ?>

</div>

<?php
get_footer();
