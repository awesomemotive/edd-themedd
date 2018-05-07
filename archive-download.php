<?php
/**
 * Downloads archive page.
 * This is used by default unless EDD_DISABLE_ARCHIVE is set to true.
 */
get_header();

$title = themedd_edd_post_type_archive_title();

if ( $title ) {
	themedd_page_header( array( 'title' => $title ) );
}

?>

<div class="<?php echo themedd_wrapper_classes(); ?>">

	<main id="main" class="site-main" role="main">
		<div class="entry-content">
		<?php if ( have_posts() ) : ?>
			<div class="<?php echo themedd_edd_downloads_list_wrapper_classes(); ?>">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/download-grid' ); ?>

			<?php endwhile; ?>

			<?php
			/**
			* Download pagination
			*/
			themedd_edd_download_nav();
			?>

			</div>

			<?php endif; ?>
		</div>
	</main>

</div>

<?php
get_footer();
