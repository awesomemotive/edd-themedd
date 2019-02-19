<?php
/**
 * Download category custom taxonomy.
 */
get_header();

themedd_header( array(
	'title'    => single_term_title( '', false ),
	'subtitle' => term_description(),
));

?>
<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
	<main id="main" class="site-main" role="main">
		<div class="entry-content content-wrapper">
		<?php if ( have_posts() ) : ?>
			<div class="<?php echo themedd_edd_downloads_list_wrapper_classes(); ?>">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/download-grid' ); ?>
			<?php endwhile; ?>
			</div>
			<?php themedd_edd_download_nav(); ?>
		<?php endif; ?>
		</div>
	</main>
</div>
<?php
get_footer();
