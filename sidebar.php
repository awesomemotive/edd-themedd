<?php
/**
 * The Sidebar containing the main widget area
 *
 * @since 1.0.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<div id="secondary" class="<?php echo trustedd_secondary_classes(); ?>">
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'trustedd_primary_sidebar_start' ); ?>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

	</div>
</div>
<?php endif; ?>
