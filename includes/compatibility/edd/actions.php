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
 * Remove the purchase link at the bottom of the single download page.
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
			// Display download title.
			echo '<h1 class="download-title">' . get_the_title() . '</h1>';

			// Display download price.
			echo themedd_edd_price();

			do_action( 'themedd_edd_download_info_after_price', get_the_ID() );

			// Display purchase link.
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

/**
 * Alter EDD download loops.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_edd_pre_get_posts' ) ):
	function themedd_edd_pre_get_posts( $query ) {

		// Default the number of downloads to 9, like EDD's [downloads] shortcode
		$downloads_per_page = apply_filters( 'themedd_edd_downloads_per_page', 9 );

		// Bail if in the admin or we're not working with the main WP query.
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		// Set the number of downloads to show.
		if (
			is_post_type_archive( 'download' ) || // archive-download.php page
			is_tax( 'download_category' ) ||      // taxonomy-download-category.php
			is_tax( 'download_tag' )              // taxonomy-download-category.php
		) {
			$query->set( 'posts_per_page', $downloads_per_page );
		}

	}
endif;
add_action( 'pre_get_posts', 'themedd_edd_pre_get_posts', 1 );
