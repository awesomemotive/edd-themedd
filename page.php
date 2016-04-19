<?php
/**
 * The template for displaying pages
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<header class="page-header<?php echo themedd_page_header_classes(); ?>">
	<h1 class="page-title"><?php echo get_the_title( get_the_ID() ); ?></h1>
</header>
<?php endwhile; ?>

<div id="column-wrapper" class="wrapper<?php echo themedd_wrapper_classes(); ?>">
    <div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
    	<main id="main" class="site-main" role="main">

		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>

	   </main>

    </div>

    <?php themedd_get_sidebar(); ?>

</div>

<?php get_footer(); ?>
