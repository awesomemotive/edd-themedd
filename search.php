<?php
/**
 * The template for displaying search results pages
 */

get_header(); ?>

<div class="wrapper<?php echo trustedd_wrapper_classes(); ?>">

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'trustedd' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
				</header><!-- .page-header -->

				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'content', 'search' );

				// End the loop.
				endwhile;

				// Previous/next page navigation.
				the_posts_pagination( array(
					'prev_text'          => esc_html__( 'Previous page', 'trustedd' ),
					'next_text'          => esc_html__( 'Next page', 'trustedd' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'trustedd' ) . ' </span>',
				) );

			// If no content, include the "No posts found" template.
			else :
				get_template_part( 'content', 'none' );

			endif;
			?>

		</main>
	</section>

	<?php trustedd_get_sidebar(); ?>

</div>

<?php get_footer(); ?>
