<?php
/**
 * The template used for displaying a download's content.
 * Loaded by single-download.php
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'themedd_entry_article_start' ); ?>

    <?php themedd_post_thumbnail(); ?>

    <div class="entry-content content-wrapper">

        <?php do_action( 'themedd_entry_content_start' ); ?>

        <?php the_content(); ?>

        <?php do_action( 'themedd_entry_content_end' ); ?>

    </div>
</article>
