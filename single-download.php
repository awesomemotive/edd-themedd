<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<?php
// Start the loop.
while ( have_posts() ) : the_post(); ?>

<header class="entry-header">
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
</header>

<div class="wrapper<?php echo trustedd_wrapper_classes(); ?>">

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php trustedd_post_thumbnail(); ?>

            	<div class="entry-content">

            		<?php do_action( 'trustedd_entry_content_start' ); ?>

            		<?php the_content(); ?>

            		<?php
            			wp_link_pages( array(
            				'before' => '<div class="page-links">' . __( 'Pages:', 'trustedd' ),
            				'after'  => '</div>',
            			) );
            		?>

            		<?php do_action( 'trustedd_entry_content_end' ); ?>

            	</div>
            </article>

            <?php

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

	           ?>

		</main>
	</div>

    <?php
        trustedd_get_sidebar();
    ?>

</div>

<?php
// End the loop.
endwhile;
?>


<?php get_footer(); ?>
