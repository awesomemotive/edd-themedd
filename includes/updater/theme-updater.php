<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package themedd
 */

// Includes the files needed for the theme updater
if ( ! class_exists( 'Themedd_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new Themedd_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://easydigitaldownloads.com',
		'item_name'      => 'Themedd',
		'theme_slug'     => 'themedd',
		'version'        => THEMEDD_VERSION,
		'author'         => THEMEDD_AUTHOR,
		'download_id'    => '', // Optional, used for generating a license renewal link
		'renew_url'      => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => THEMEDD_NAME . _x( ' License', 'part of the WordPress dashboard Themedd menu title', 'themedd' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'themedd' ),
		'license-key'               => __( 'License Key', 'themedd' ),
		'license-action'            => __( 'License Action', 'themedd' ),
		'deactivate-license'        => __( 'Deactivate License', 'themedd' ),
		'activate-license'          => __( 'Activate License', 'themedd' ),
		'status-unknown'            => __( 'License status is unknown.', 'themedd' ),
		'renew'                     => __( 'Renew?', 'themedd' ),
		'unlimited'                 => __( 'unlimited', 'themedd' ),
		'license-key-is-active'     => __( 'License key is active.', 'themedd' ),
		'expires%s'                 => __( 'Expires %s.', 'themedd' ),
		'lifetime'                  => __( 'Lifetime License.', 'themedd' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'themedd' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'themedd' ),
		'license-key-expired'       => __( 'License key has expired.', 'themedd' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'themedd' ),
		'license-is-inactive'       => __( 'License is inactive.', 'themedd' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'themedd' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'themedd' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'themedd' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'themedd' ),
		'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'themedd' )
	)
);
