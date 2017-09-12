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

themedd_page_header( array( 'title' => $page_title, 'subtitle' => sprintf( __( 'You searched for "%s"', 'themedd' ), get_search_query() ) ) );

?>
<div class="content-wrapper<?php echo themedd_wrapper_classes(); ?>">

	<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'search' );

				// End the loop.
				endwhile;

				themedd_paging_nav();

			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main>
	</div>

	<?php themedd_get_sidebar(); ?>

</div>

<?php get_footer(); ?>
