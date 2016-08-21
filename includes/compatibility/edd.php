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
 * EDD Recurring
 * Modify URL to update payment method
 */

function themedd_edd_recurring_update_url( $url, $subscription ) {
	$url = add_query_arg( array( 'action' => 'update', 'subscription_id' => $subscription->id ), '#tabs=1' );

	return $url;
}
add_filter( 'edd_subscription_update_url', 'themedd_edd_recurring_update_url', 10, 2 );

/**
 * EDD Software licensing
 * Loads the SL templates into our existing licenses tab
 */
function themedd_edd_sl_load_templates() {

	if ( empty( $_GET['action'] ) || 'manage_licenses' != $_GET['action'] ) {
		return;
	}

	if ( empty( $_GET['payment_id'] ) ) {
		return;
	}

	if ( isset( $_GET['license_id'] ) && isset( $_GET['view'] ) && 'upgrades' == $_GET['view'] ) {

		// load our new tab content
		edd_get_template_part( 'licenses', 'upgrades' );

	} else {

		$view = isset( $_GET['license_id'] ) ? 'single' : 'overview';

		edd_get_template_part( 'licenses', 'manage-' . $view );
	}

}
add_action( 'themedd_licenses_tab', 'themedd_edd_sl_load_templates' );

/**
 * Remove the existing licenses tab content when "Manage Sites" or "View Upgrades" links are clicked
 */
function themedd_edd_sl_remove_content() {

	/**
	 * Make sure this only runs from account page. Consider adding setting to EDD customizer to get correct account page
	 */
	if ( is_page( 'account' ) ) {
		remove_filter( 'the_content', 'edd_sl_override_history_content', 9999 );
	}

	if ( empty( $_GET['action'] ) || 'manage_licenses' != $_GET['action'] ) {
		return;
	}

	if ( empty( $_GET['payment_id'] ) ) {
		return;
	}

	if ( isset( $_GET['license_id'] ) && isset( $_GET['view'] ) && 'upgrades' == $_GET['view'] ) {
		// remove existing tab content
		remove_action( 'themedd_licenses_tab', 'themedd_account_tab_licenses_content' );
	} else {
		remove_action( 'themedd_licenses_tab', 'themedd_account_tab_licenses_content' );
	}

}
add_action( 'template_redirect', 'themedd_edd_sl_remove_content' );
