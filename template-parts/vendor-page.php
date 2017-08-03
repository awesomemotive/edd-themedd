<?php
/**
 * The FES vendor page
 */

get_header();
themedd_page_header( array( 'classes' => 'center-xs' ) );
?>

<div class="content-wrapper<?php echo themedd_wrapper_classes(); ?>">

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
	// Only load vendor sidebar if a vendor exists.
	if ( fes_get_vendor() ) {
		themedd_get_sidebar( 'vendor-page' );
	}
	?>

</div>

<?php get_footer(); ?>
