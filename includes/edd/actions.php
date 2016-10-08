<?php

/**
 * Enqueue frontend scripts
 *
 * @since 1.0.0
 */
function themedd_edd_remove_css() {
	// remove software licensing CSS file
	wp_dequeue_style( 'edd-sl-styles' );
}
add_action( 'wp_enqueue_scripts', 'themedd_edd_remove_css' );

/**
 * Remove and deactivate all styling included with EDD
 *
 * @since 1.0.0
 */
remove_action( 'wp_enqueue_scripts', 'edd_register_styles' );

/**
 * Remove the purchase link at the bottom of the download page
 *
 * @since 1.0.0
 */
remove_action( 'edd_after_download_content', 'edd_append_purchase_link' );

/**
 * The combined price and purchase button shown on the single download page
 *
 * @since 1.0.0
 */
function themedd_edd_pricing() {
	?>
	<aside>
		<?php echo themedd_edd_price(); ?>
		<?php themedd_edd_purchase_link(); ?>
	</aside>
<?php
}
add_action( 'themedd_sidebar_download', 'themedd_edd_pricing' );

/**
 * Add cart link to secondary menu
 *
 * @since 1.0.0
 */
function themedd_edd_secondary_menu_after() {

	if ( 'secondary_menu' !== themedd_edd_cart_link_position() ) {
		return;
	}

    echo themedd_edd_cart_link( array( 'list_item' => false ) );
}
add_action( 'themedd_secondary_menu_after', 'themedd_edd_secondary_menu_after' );

/**
 * Add cart link to mobile menu
 *
 * @since 1.0.0
 */
function themedd_edd_menu_toggle_before() {
    echo themedd_edd_cart_link( array( 'list_item' => false, 'classes' => array( 'mobile' ) ) );
}
add_action( 'themedd_menu_toggle_before', 'themedd_edd_menu_toggle_before' );
