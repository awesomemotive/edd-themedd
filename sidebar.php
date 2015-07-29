<?php
/**
 * The Sidebar containing the main widget area
 *
 * @since 1.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-downloads' ) ) : ?>
<div id="secondary">
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-downloads' ); ?>
	</div>
</div>
<?php endif; ?>
