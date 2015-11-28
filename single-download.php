<?php
/**
 * The template for displaying all single downloads
 */

get_header(); ?>

<header class="page-header<?php echo trustedd_page_header_classes(); ?>">
    <?php the_title( '<h1 class="download-title">', '</h1>' ); ?>
</header>

<div class="wrapper wide<?php echo trustedd_wrapper_classes(); ?>">

	<div id="primary" class="content-area <?php echo trustedd_primary_classes(); ?>">

		<main id="main" class="site-main" role="main">

            <?php
    		// Start the loop.
    		while ( have_posts() ) : the_post();

    			/*
    			 * Include the post format-specific template for the content. If you want to
    			 * use this in a child theme, then include a file called called content-___.php
    			 * (where ___ is the post format) and that will be used instead.
    			 */
    			get_template_part( 'template-parts/content', 'download' );

    			// If comments are open or we have at least one comment, load up the comment template.
    			if ( comments_open() || get_comments_number() ) :
    				comments_template();
    			endif;

    		// End the loop.
    		endwhile;
    		?>

		</main>
	</div>

    <?php
        trustedd_get_sidebar();
    ?>

</div>


<?php get_footer(); ?>
