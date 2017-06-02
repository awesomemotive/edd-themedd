<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
themedd_page_header( array( 'title' => __( 'Oops! That page can&rsquo;t be found.', 'themedd' ) ) );
?>

<div class="content-wrapper<?php echo themedd_wrapper_classes(); ?>">

	<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
		<main id="main" class="site-main" role="main">

            <section class="error-404 not-found">
                <div class="page-content">
                    <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'themedd' ); ?></p>

                    <?php get_search_form(); ?>
                </div>
            </section>

		</main>
	</div>

	<?php themedd_get_sidebar(); ?>

</div>

<?php get_footer(); ?>
