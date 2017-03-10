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
function themedd_edd_download_info() {

    if ( ! is_singular( 'download' ) ) {
        return;
    }

    ?>
	<div class="download-info">
		<?php
            echo '<h1 class="download-title">' . get_the_title() . '</h1>';
            echo themedd_edd_price();
            themedd_edd_purchase_link();
        ?>
	</div>
<?php
}
add_action( 'themedd_sidebar_download', 'themedd_edd_download_info' );

// add the download info just after the featured image so it can be shown at mobile sizes
add_action( 'themedd_entry_content_start', 'themedd_edd_download_info' );

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
