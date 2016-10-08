<?php
/**
 * Account
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Set up account tabs
 *
 * @since 1.0.0
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
 * Add licenses tab
 *
 * @since 1.0.0
 */
function themedd_licenses() {

	ob_start();

	do_action( 'themedd_licenses_tab' );

	return ob_get_clean();

}

/**
 * Load license tab content
 *
 * @since 1.0.0
 */
function themedd_account_tab_licenses_content() {
	edd_get_template_part( 'license', 'keys' );
}
add_action( 'themedd_licenses_tab', 'themedd_account_tab_licenses_content' );


/**
 * Profile editor
 *
 * @since 1.0.0
 */
function themedd_profile_editor() {
	return do_shortcode( '[edd_profile_editor]' );
}

/**
 * Purchase history
 *
 * @since 1.0.0
 */
function themedd_purchase_history() {
	return do_shortcode( '[purchase_history]' );
}

/**
 * Subscriptions
 *
 * @since 1.0.0
 */
function themedd_edd_subscriptions() {
	return do_shortcode( '[edd_subscriptions]' );
}

/**
 * Add an "Affiliate Area" link to the bottom of the account section
 *
 * @since 1.0.0
 */
function themedd_account_tab_affiliate_area() {
	?>

	<?php if ( function_exists( 'affwp_is_affiliate' ) && affwp_is_affiliate() ) : ?>
	<li class="follow-link" data-link="affiliate-area"><a href="<?php echo affwp_get_affiliate_area_page_url(); ?>">Affiliate Area</a></li>
	<?php endif; ?>

	<?php
}
add_action( 'themedd_account_tabs_after', 'themedd_account_tab_affiliate_area' );
