<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();

themedd_header( 
	array( 
		'title'          => __( 'Oops! That page can&rsquo;t be found.', 'themedd' ), 
		'subtitle'       => __( 'It looks like nothing was found at this location. Maybe try a search?', 'themedd' ),
		'header_classes' => array( 'py-5', 'py-lg-10', 'text-center' ),
	) 
);
?>
<div class="<?php echo themedd_output_classes( themedd_wrapper_classes() ); ?>">
	<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">
			<section class="error-404 not-found">
				<div class="content-wrapper">
					<?php get_search_form(); ?>
				</div>
			</section>
		</main>
	</div>
	<?php themedd_get_sidebar(); ?>
</div>

<?php get_footer(); ?>
