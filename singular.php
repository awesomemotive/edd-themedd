<?php
/**
 * The template for displaying all pages, single posts and attachments
 *
 * This is a new template file that WordPress introduced in
 * version 4.3. Note that it uses conditional logic to display
 * different content based on the post type.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>

<?php if ( is_singular( 'page' ) ) : ?>
    <header class="page-header<?php echo themedd_page_header_classes(); ?>">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
	</header>

<?php else : ?>
    <header class="page-header<?php echo themedd_page_header_classes(); ?>">
		<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
	</header>
<?php endif; ?>


<div id="column-wrapper" class="wrapper<?php echo themedd_wrapper_classes(); ?>">
    <div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
    	<main id="main" class="site-main" role="main">
    		<?php
    		// Start the loop.
    		while ( have_posts() ) : the_post();

    			// Include the page content template.
    			if ( is_singular( 'page' ) ) {
    				get_template_part( 'template-parts/content', 'page' );
    			} else {
    				get_template_part( 'template-parts/content', 'single' );
    			}

    			// If comments are open or we have at least one comment, load up the comment template.
    			if ( comments_open() || get_comments_number() ) {
    				comments_template();
    			}

    			if ( is_singular( 'attachment' ) ) {
    				// Parent post navigation
    				the_post_navigation( array(
    					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'themedd' ),
    				) );
    			}

    			// End of the loop.
    		endwhile;
    		?>

    	</main><!-- .site-main -->



    </div>

    <?php themedd_get_sidebar(); ?>

</div>

<?php get_footer(); ?>
