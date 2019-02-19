<?php
/**
 * The Sidebar for the single-download.php containing the main widget area
 *
 * @since 1.0.0
 */
?>
<div id="product-sidebar" class="widget-area" role="complementary">
	<?php
	do_action( 'themedd_edd_sidebar_download_start' );

	/**
	 * Any widgets added to the download sidebar will replace everything below.
	 */
	if ( ! dynamic_sidebar( 'sidebar-download' ) ) : ?>
		<?php do_action( 'themedd_edd_sidebar_download', $post ); ?>
	<?php endif;

	do_action( 'themedd_edd_sidebar_download_end' );
	?>
</div>
