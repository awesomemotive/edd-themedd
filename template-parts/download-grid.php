<?php
$schema        = edd_add_schema_microdata() ? 'itemscope itemtype="http://schema.org/Product" ' : '';
$download_meta = themedd_edd_download_meta_options();
?>

<div <?php echo $schema; ?>class="edd_download mb-xs-4 mb-sm-0" id="edd_download_<?php echo get_the_ID(); ?>">
	<div class="edd_download_inner">

		<?php

		do_action( 'edd_download_before' );

		edd_get_template_part( 'shortcode', 'content-image' );

		do_action( 'edd_download_after_thumbnail' );

		do_action( 'edd_download_before_title' );

		edd_get_template_part( 'shortcode', 'content-title' );

		do_action( 'edd_download_after_title' );

		edd_get_template_part( 'shortcode', 'content-excerpt' );

		do_action( 'edd_download_after_content' );

		// Only show the standard price if the download meta does not include the price.
		if ( false === $download_meta['price'] ) {
			edd_get_template_part( 'shortcode', 'content-price' );
		}

		do_action( 'edd_download_after_price' );

		themedd_edd_download_footer();

		do_action( 'edd_download_after' );

		?>

	</div>
</div>
