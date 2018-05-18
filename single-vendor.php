<?php
/**
 * The template for displaying the single vendor page in Frontend Submissions
 */

get_header();
themedd_page_header();
?>

<div class="<?php echo themedd_output_classes( themedd_wrapper_classes() ); ?>">

    <div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
    	<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

		// End of the loop.
		endwhile;
		?>

		</main>

    </div>

    <?php
	// Only load the single vendor sidebar if a vendor exists.
	if ( fes_get_vendor() ) {
		themedd_get_sidebar( 'single-vendor' );
	}
	?>

</div>

<?php get_footer(); ?>
