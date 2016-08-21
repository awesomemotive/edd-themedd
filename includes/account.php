<?php
/**
 * Account
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Set up account tabs
 */
function themedd_account_tabs() {

	$tabs = array(
		'purchases' => array(
			'tab_title'         => 'Purchases',
			'tab_order'         => 2,
			'tab_content'       => themedd_purchase_history(),
			'tab_content_title' => 'Purchases',
		),
		'profile' => array(
			'tab_title'         => 'Profile',
			'tab_order'         => 3,
			'tab_content'       => themedd_profile_editor(),
			'tab_content_title' => 'Edit your profile',
		)
	);

	/**
	 * Add a "subscriptions" tab is EDD Recurring is active
	 */
	if ( themedd_is_edd_recurring_active() ) {
		$tabs['subscriptions']['tab_title']         = 'Subscriptions';
		$tabs['subscriptions']['tab_order']         = 1;
		$tabs['subscriptions']['tab_content']       = themedd_edd_subscriptions();
		$tabs['subscriptions']['tab_content_title'] = 'Subscriptions';
	}

	/**
	 * Add a "licenses" tab is EDD Software Licensing is active
	 */
	if ( themedd_is_edd_sl_active() ) {
		$tabs['licenses']['tab_title']         = 'Licenses';
		$tabs['licenses']['tab_order']         = 0;
		$tabs['licenses']['tab_content']       = themedd_licenses();
		$tabs['licenses']['tab_content_title'] = 'Licenses';
	}

	$tabs = apply_filters( 'themedd_account_tabs', $tabs );

	// sort tabs
	usort( $tabs, function( $a, $b ) {
	    return $a['tab_order'] - $b['tab_order'];
	});

	return $tabs;

}

/**
 *
 */
function themedd_licenses() {

	ob_start();

	do_action( 'themedd_licenses_tab' );

	return ob_get_clean();

}

/**
 * Load license tab content
 */
function themedd_account_tab_licenses_content() {
	edd_get_template_part( 'license', 'keys' );
}
add_action( 'themedd_licenses_tab', 'themedd_account_tab_licenses_content' );


/**
 *
 */
function themedd_profile_editor() {
	return do_shortcode( '[edd_profile_editor]' );
}

/**
 *
 */
function themedd_purchase_history() {
	return do_shortcode( '[purchase_history]' );
}

/**
 *
 */
function themedd_edd_subscriptions() {
	return do_shortcode( '[edd_subscriptions]' );
}
