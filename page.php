<?php
/**
 * The template for displaying all pages
 *
 * @package Trustedd
 */

get_header(); ?>

<div class="wrapper<?php echo trustedd_page_wrapper_classes();?>">

	<div id="primary" class="content-area">

		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				// Include the page content template.
				get_template_part( 'content', 'page' );

			endwhile;
		?>
	</div>
</div>

<?php
get_footer();
