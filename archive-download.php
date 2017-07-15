<?php
/**
 * Downloads archive page.
 * This is used by default unless EDD_DISABLE_ARCHIVE is set to true.
 */
get_header();
?>

<div class="content-wrapper<?php echo themedd_wrapper_classes(); ?>">

	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) :

			$classes   = array( 'edd_downloads_list' );
			$classes[] = 'edd_download_columns_' . themedd_edd_download_columns();
			$classes[] = themedd_edd_has_download_meta() ? 'has-download-meta' : '';
			?>
			<div class="<?php echo implode( ' ', array_filter( $classes ) ); ?>">


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
	</main>

</div>

<?php
get_footer();
