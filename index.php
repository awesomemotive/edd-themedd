<?php
/**
 * The main template file.
 */

get_header();

if ( ! is_front_page() ) {
	themedd_header(
		array(
			'title'          => get_the_title( get_option( 'page_for_posts', true ) ),
			'header_classes' => array( 'page-header', 'text-sm-center' ),
		)
	);
}
?>
<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
	<main id="main" class="site-main" role="main">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				endwhile;

				themedd_paging_nav();
			else :
				// If no content, include the "No posts found" template.
				get_template_part( 'template-parts/content', 'none' );
			endif;
		?>
	</main>
</div>
<?php themedd_get_sidebar(); ?>

<?php
get_footer();
