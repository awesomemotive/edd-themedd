<?php
/**
 * The template for displaying all pages
 *
 * @package Trustedd
 */

get_header(); ?>

<div class="wrapper<?php echo trustedd_wrapper_classes(); ?>">

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				
			endwhile;
		?>
		</main>
	</div>

	<?php trustedd_get_sidebar(); ?>

</div>

<?php
get_footer();
