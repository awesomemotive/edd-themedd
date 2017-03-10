<?php

/**
 * Remove download meta styling
 */
remove_action( 'wp_head', 'edd_download_meta_styles' );

/**
 * Add categories icon to download meta
 *
 * @since 1.0.0
 */
function themedd_download_meta_icon_categories() {
	?>
	<img src="<?php echo get_template_directory_uri() . '/assets/images/svgs/download-categories.svg'; ?>" width="24" />
	<?php
}
add_action( 'edd_download_meta_categories', 'themedd_download_meta_icon_categories' );

/**
 * Add tags icon to download meta
 *
 * @since 1.0.0
 */
function themedd_download_meta_icon_tags() {
	?>
	<img src="<?php echo get_template_directory_uri() . '/assets/images/svgs/download-tags.svg'; ?>" width="24" />
	<?php
}
add_action( 'edd_download_meta_tags', 'themedd_download_meta_icon_tags' );

/**
 * Add last updated icon
 */
function themedd_download_meta_icon_last_updated() {
	?>

	<img src="<?php echo get_template_directory_uri() . '/assets/images/svgs/download-last-updated.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_last_updated', 'themedd_download_meta_icon_last_updated' );

/**
 * Add release date icon
 */
function themedd_download_meta_icon_release_date() {
	?>

	<img src="<?php echo get_template_directory_uri() . '/assets/images/svgs/download-released.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_release_date', 'themedd_download_meta_icon_release_date' );

/**
 * Add documentation icon
 */
function themedd_download_meta_icon_documentation() {
	?>

	<img src="<?php echo get_template_directory_uri() . '/assets/images/svgs/download-documentation.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_documentation', 'themedd_download_meta_icon_documentation' );

/**
 * Add version icon
 */
function themedd_download_meta_icon_version() {
	?>

	<img src="<?php echo get_template_directory_uri() . '/assets/images/svgs/download-version.svg'; ?>" width="24" />

	<?php
}
add_action( 'edd_download_meta_version', 'themedd_download_meta_icon_version' );
