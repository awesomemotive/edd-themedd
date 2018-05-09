<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
themedd_page_header( array( 'title' => __( 'Oops! That page can&rsquo;t be found.', 'themedd' ), 'subtitle' => __( 'It looks like nothing was found at this location. Maybe try a search?', 'themedd' ) ) );
?>

<div class="<?php echo themedd_wrapper_classes(); ?>">
	<?php if ( themedd_has_sidebar() ) : ?>
	<div class="row justify-content-center">
	<?php endif; ?>

		<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
			<main id="main" class="site-main" role="main">
				<section class="error-404 not-found">
					<div class="entry-content">
						<?php get_search_form(); ?>
					</div>
				</section>
			</main>
		</div>

		<?php themedd_get_sidebar(); ?>

	<?php if ( themedd_has_sidebar() ) : ?>	
	</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
