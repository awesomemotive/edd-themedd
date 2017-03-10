<?php

/**
 * EDD Software licensing
 * Loads the SL templates into our existing licenses tab
 *
 * @since 1.0.0
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
 * Determine if a customer can upgrade their license (Software licensing plugin)
 *
 * @since 1.0.0
 */
function themedd_edd_can_upgrade_license() {

	if ( ! themedd_is_edd_sl_active() ) {
		return;
	}

	$can_upgrade = false;

	$license_keys = edd_software_licensing()->get_license_keys_of_user();

	if ( $license_keys ) {
		foreach ( $license_keys as $license ) {
			 if ( edd_sl_license_has_upgrades( $license->ID ) && 'expired' !== edd_software_licensing()->get_license_status( $license->ID ) ) {
				$can_upgrade = true;
				break;
			 }
		}
	}

	return $can_upgrade;

}
