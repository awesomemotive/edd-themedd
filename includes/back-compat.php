<?php
/**
 * Themedd back compat functionality
 *
 * Prevents Themedd from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package WordPress
 * @subpackage Themedd
 * @since Themedd 1.0
 */

/**
 * Prevent switching to Themedd on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Themedd 1.0
 */
function themedd_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'themedd_upgrade_notice' );
}
add_action( 'after_switch_theme', 'themedd_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Themedd on WordPress versions prior to 4.7.
 *
 * @since Themedd 1.0
 *
 * @global string $wp_version WordPress version.
 */
function themedd_upgrade_notice() {
	$message = sprintf( __( 'Themedd requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'themedd' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Themedd 1.0
 *
 * @global string $wp_version WordPress version.
 */
function themedd_customize() {
	wp_die( sprintf( __( 'Themedd requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'themedd' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'themedd_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Themedd 1.0
 *
 * @global string $wp_version WordPress version.
 */
function themedd_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Themedd requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'themedd' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'themedd_preview' );

/**
 * Filter the settings from EDD's "Styles" tab (pre EDD v3.0)
 *
 * @since 1.0
 * @param array $settings The "Styles" tab settings array
 */
function themedd_edd_settings_styles( $settings ) {
	// Remove "Style Settings" heading.
	unset( $settings['main']['style_settings'] );

	// Remove "Disable Styles" option. Styling is already disabled and controlled via Themedd.
	unset( $settings['main']['disable_styles'] );

	// Remove "Default Button Color" option since Themedd controls all button styling
	unset( $settings['main']['checkout_color'] );

	return $settings;
}