<?php $schema = edd_add_schema_microdata() ? 'itemscope itemtype="http://schema.org/Product" ' : ''; ?>

<div <?php echo $schema; ?>class="edd_download mb-xs-4 mb-sm-0" id="edd_download_<?php echo get_the_ID(); ?>">
	<div class="edd_download_inner">

		<?php

		do_action( 'edd_download_before' );

		edd_get_template_part( 'shortcode', 'content-image' );

		do_action( 'edd_download_after_thumbnail' );

		edd_get_template_part( 'shortcode', 'content-title' );

		do_action( 'edd_download_after_title' );

		edd_get_template_part( 'shortcode', 'content-excerpt' );

		do_action( 'edd_download_after_content' );

		edd_get_template_part( 'shortcode', 'content-price' );

		do_action( 'edd_download_after_price' );

		edd_get_template_part( 'shortcode', 'content-cart-button' );

		do_action( 'edd_download_after' );

		?>

	</div>
</div>
