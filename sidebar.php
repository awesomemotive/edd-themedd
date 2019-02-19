<?php
/**
 * The Sidebar containing the main widget area
 *
 * @since 1.0.0
 */

$classes = themedd_secondary_classes() ? 'class="' . themedd_secondary_classes() . '"' : '';
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<div id="secondary" <?php echo $classes; ?>>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'themedd_primary_sidebar_start' ); ?>

		<?php dynamic_sidebar( 'sidebar-1' ); ?>

		<?php do_action( 'themedd_primary_sidebar_end' ); ?>

	</div>
</div>
<?php endif; ?>
