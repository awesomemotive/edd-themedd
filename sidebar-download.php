<?php
/**
 * The Sidebar for the single-download.php containing the main widget area
 *
 * @since 1.0.0
 */
?>
<div id="secondary">
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'trustedd_sidebar_download' ); ?>

        <?php if ( is_active_sidebar( 'sidebar-downloads' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-downloads' ); ?>
        <?php endif; ?>

		<?php do_action( 'trustedd_sidebar_download_end' ); ?>
	</div>
</div>
