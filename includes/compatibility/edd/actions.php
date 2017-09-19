<?php

/**
 * Adds themedd_edd_price() and themedd_edd_purchase_link() to the download details widget.
 *
 * @since 1.0.0
 */
function themedd_edd_download_details_widget( $instance, $download_id ) {

	do_action( 'themedd_edd_download_info', $download_id );

}
add_action( 'edd_product_details_widget_before_purchase_button', 'themedd_edd_download_details_widget', 10, 2 );

/**
 * Download price
 *
 * @since 1.0.0
 */
function themedd_edd_price( $download_id ) {

	// Return early if price enhancements has been disabled.
	if ( false === themedd_edd_price_enhancements() ) {
		return;
	}

	if ( edd_is_free_download( $download_id ) ) {
		$price = '<span class="edd_price">' . __( 'Free', 'themedd' ) . '</span>';
	} elseif ( edd_has_variable_prices( $download_id ) ) {
		$price = '<div itemprop="price" class="edd_price">' . __( 'From', 'themedd' ) . '&nbsp;' . edd_currency_filter( edd_format_amount( edd_get_lowest_price_option( $download_id ) ) ) . '</div>';
		
	} else {
		$price = edd_price( $download_id, false );
	}

	echo $price;

}
add_action( 'themedd_edd_download_info', 'themedd_edd_price', 10, 1 );

/**
 * Download purchase link
 *
 * @since 1.0.0
 */
function themedd_edd_purchase_link( $download_id ) {

	if ( get_post_meta( $download_id, '_edd_hide_purchase_link', true ) ) {
		return; // Do not show if auto output is disabled
	}

	echo edd_get_purchase_link();

}
add_action( 'themedd_edd_download_info', 'themedd_edd_purchase_link', 10, 1 );

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
 * Add cart link to secondary menu
 *
 * @since 1.0.0
 */
function themedd_edd_secondary_menu_after() {

	if ( 'secondary_menu' !== themedd_edd_cart_position() ) {
		return;
	}

    echo themedd_edd_cart( array( 'list_item' => false ) );
}
add_action( 'themedd_secondary_menu_after', 'themedd_edd_secondary_menu_after' );

/**
 * Alter EDD download loops.
 * Affects archive-download.php, taxonomy-download-category.php and taxonomy-download-category.php
 *
 * @since  1.0.0
 *
 * @return void
 */
if ( ! function_exists( 'themedd_edd_pre_get_posts' ) ):
	function themedd_edd_pre_get_posts( $query ) {

		$options = themedd_edd_download_grid_options();

		// Defaults to 9 downloads like EDD's [downloads] shortcode.
		$downloads_per_page = $options['number'];

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

/**
 * Template redirect actions
 *
 * @since  1.0.0
 *
 * @return void
 */
if ( ! function_exists( 'themedd_edd_set_distraction_free_checkout' ) ):
function themedd_edd_set_distraction_free_checkout() {

	/**
	 * Distraction Free Checkout
	 * Removes various distractions from the EDD checkout page to improve the customer's buying experience.
	 */
	if ( edd_is_checkout() && themedd_edd_distraction_free_checkout() && edd_get_cart_contents() ) {

		// Remove page header.
		add_filter( 'themedd_page_header', '__return_false' );

		// Remove the primary navigation.
		remove_action( 'themedd_site_header_main_end', 'themedd_primary_menu' );

		// Remove the primary navigation if moved to the themedd_site_header_main hook.
		remove_action( 'themedd_site_header_main', 'themedd_primary_menu' );

		// Remove the mobile menu.
		remove_action( 'themedd_site_header_main', 'themedd_menu_toggle' );

		// Remove the secondary menu.
		remove_action( 'themedd_site_header_main', 'themedd_secondary_menu' );

		// Remove the footer.
		remove_action( 'themedd_footer', 'themedd_footer_widgets' );

		// Remove the sidebar.
		add_filter( 'themedd_show_sidebar', '__return_false' );

		// Remove the custom header (if any)
		remove_action( 'themedd_masthead_after', 'themedd_header_image' );
	}

}
endif;
add_action( 'template_redirect', 'themedd_edd_set_distraction_free_checkout' );
