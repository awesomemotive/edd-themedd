<?php
$download_grid_options = themedd_edd_download_grid_options();
?>

<div class="<?php echo esc_attr( apply_filters( 'edd_download_class', 'edd_download', get_the_ID(), '', '' ) ); ?>" id="edd_download_<?php the_ID(); ?>">

	<div class="edd_download_inner">

		<?php 
			if ( true === $download_grid_options['thumbnails'] ) {
				edd_get_template_part( 'shortcode', 'content-image' );
				do_action( 'edd_download_after_thumbnail' );
			}
		?>

		<div class="edd-download-body">
		<?php
		do_action( 'edd_download_before' );

		/**
		 * Used by themedd_edd_download_meta_before_title()
		 */
		do_action( 'edd_download_before_title' );

		if ( true === $download_grid_options['title'] ) {
			edd_get_template_part( 'shortcode', 'content-title' );
		}

		do_action( 'edd_download_after_title' );

		if ( true === $download_grid_options['excerpt'] && true !== $download_grid_options['full_content'] ) {
			edd_get_template_part( 'shortcode', 'content-excerpt' );
			do_action( 'edd_download_after_content' );
		} elseif ( true === $download_grid_options['full_content'] ) {
			edd_get_template_part( 'shortcode', 'content-full' );
			do_action( 'edd_download_after_content' );
		}
		?>
		</div>

		<?php
			themedd_edd_download_footer();
			do_action( 'edd_download_after' );
		?>

	</div>
</div>
