<?php
/**
 * The template for displaying search results pages
 */

get_header();

if ( have_posts() ) {
	$page_title = __( 'Search Results', 'themedd' );
} else {
	$page_title = __( 'Nothing Found', 'themedd' );
}

themedd_header(
	array(
		'title'    => $page_title,
		'subtitle' => sprintf( __( 'You searched for "%s"', 'themedd' ), get_search_query() ),
	)
);
?>

<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php if ( themedd_is_edd_active() && Themedd_Search::is_product_search_results() ) : ?>

			<div class="entry-content content-wrapper">
				<div<?php themedd_classes( array( 'classes' => themedd_edd_downloads_list_wrapper_classes() ) ); ?>>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/download-grid' ); ?>
					<?php endwhile; ?>
				</div>
			</div>
			<?php themedd_edd_download_nav(); ?>

			<?php else : ?>

				<?php while ( have_posts() ) : the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );

				// End the loop.
				endwhile; ?>

			<?php themedd_paging_nav(); ?>

			<?php endif; ?>

		<?php

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>
	</main>
</div>

<?php get_footer(); ?>