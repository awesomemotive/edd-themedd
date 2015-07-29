<?php
/**
 * Download meta
 * Provides custom fields for entering specific information about the download
 * @since 1.0.0
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Scripts
 *
 * @since 1.0.0
*/

function trustedd_edd_download_meta_scripts( $hook ) {

	if ( get_post_type() == 'download' && ( $hook == 'post.php' || $hook == 'post-new.php' ) ) {

		wp_enqueue_script( 'trustedd-download-info-datepicker', TRUSTEDD_THEME_URL . 'js/admin.js', array( 'jquery-ui-datepicker' ), TRUSTEDD_THEME_VERSION, true );

		wp_localize_script( 'trustedd-download-info-datepicker', 'datepicker_vars',
			array(
				'dateformat' => apply_filters( 'trustedd_download_meta_datepicker_format', 'mm/dd/yy' )
			)
		);

		wp_enqueue_style( 'jquery-ui-css', trailingslashit( EDD_PLUGIN_URL ) . 'assets/css/jquery-ui-fresh.css' );

	}

}
add_action( 'admin_enqueue_scripts', 'trustedd_edd_download_meta_scripts' );

/**
 * Add meta Box
 *
 * @since 1.0.0
 */
function trustedd_meta_box() {

	add_meta_box(
        'trustedd_meta_box',
        sprintf( esc_html__( '%s Meta', 'trustedd' ), edd_get_label_singular() ),
        'trustedd_download_meta_add_fields',
        'download',
        'side'
    );

}
add_action( 'add_meta_boxes', 'trustedd_meta_box' );

/**
 * Metabox callback
 *
 * @since 1.0.0
*/
function trustedd_download_meta_add_fields( $post, $metabox ) {

?>

    <?php do_action( 'trustedd_download_meta_add_fields', $post->ID ); ?>

	<?php wp_nonce_field( 'trustedd_download_meta', 'trustedd_download_meta' ); ?>

<?php }


/**
 * Release date field
 *
 * @since 1.0
 */
function trustedd_download_meta_release_date( $post_id ) {

	$release_date = ! empty( get_post_meta( $post_id, '_trustedd_download_date_released', true ) ) ? date_i18n( get_option( 'date_format' ), strtotime( get_post_meta( $post_id, '_trustedd_download_date_released', true ) ) ) : '';
?>

	<p><strong><?php _e( 'Date Released', 'trustedd' ); ?></strong></p>
	<p>
		<label for="trustedd-download-release-date" class="screen-reader-text">
			<?php _e( 'Release Date', 'trustedd' ); ?>
		</label>
		<input class="widefat edd-download-meta-datepicker" type="text" name="trustedd_download_date_released" id="trustedd-download-release-date" value="<?php echo esc_attr( $release_date ); ?>" size="30" />
	</p>

	<?php
}
add_action( 'trustedd_download_meta_add_fields', 'trustedd_download_meta_release_date' );

/**
 * Last updated field
 *
 * @since 1.0
 */
function trustedd_download_meta_last_updated( $post_id ) {

	$release_date = ! empty( get_post_meta( $post_id, '_trustedd_download_date_updated', true ) ) ? date_i18n( get_option( 'date_format' ), strtotime( get_post_meta( $post_id, '_trustedd_download_date_updated', true ) ) ) : '';
?>

	<p><strong><?php _e( 'Date Last Updated', 'trustedd' ); ?></strong></p>
	<p>
		<label for="trustedd-download-release-date" class="screen-reader-text">
			<?php _e( 'Date Last Updated', 'trustedd' ); ?>
		</label>
		<input class="widefat edd-download-meta-datepicker" type="text" name="trustedd_download_date_updated" id="trustedd-download-date-updated" value="<?php echo esc_attr( $release_date ); ?>" size="30" />
	</p>

	<?php
}
add_action( 'trustedd_download_meta_add_fields', 'trustedd_download_meta_last_updated' );

/**
 * Download version field
 *
 * @since 1.0
 */
function trustedd_download_meta_version( $post_id ) {
	?>

	<?php if ( ! trustedd_is_edd_sl_active() ) : ?>
	<p><strong><?php _e( 'Version', 'trustedd' ); ?></strong></p>
	<p>
		<label for="trustedd-download-version" class="screen-reader-text">
			<?php _e( 'Version', 'trustedd' ); ?>
		</label>
		<input class="widefat" type="text" name="trustedd_download_version" id="trustedd-download-version" value="<?php echo esc_attr( get_post_meta( $post_id, '_trustedd_download_version', true ) ); ?>" size="30" />
	</p>
	<?php endif; ?>

	<?php
}
add_action( 'trustedd_download_meta_add_fields', 'trustedd_download_meta_version' );

/**
 * Download URL field
 *
 * @since 1.0
 */
function trustedd_download_meta_url( $post_id ) {
?>

	<p><strong><?php _e( 'External Download URL', 'trustedd' ); ?></strong></p>
	<p>
		<label for="trustedd-download-url" class="screen-reader-text">
			<?php _e( 'External Download URL', 'trustedd' ); ?>
		</label>
		<input class="widefat" type="text" name="trustedd_download_url" id="trustedd-download-url" value="<?php echo esc_attr( get_post_meta( $post_id, '_trustedd_download_url', true ) ); ?>" size="30" />
	</p>

	<?php
}
add_action( 'trustedd_download_meta_add_fields', 'trustedd_download_meta_url' );

/**
 * Download documentation URL
 *
 * @since 1.0
 */
function trustedd_download_meta_doc_url( $post_id ) {
	?>

	<p><strong><?php _e( 'Documentation URL', 'trustedd' ); ?></strong></p>
	<p>
		<label for="trustedd-doc-url" class="screen-reader-text">
			<?php _e( 'Documentation URL', 'trustedd' ); ?>
		</label>
		<input class="widefat" type="text" name="trustedd_doc_url" id="trustedd-doc-url" value="<?php echo esc_attr( get_post_meta( $post_id, '_trustedd_doc_url', true ) ); ?>" size="30" />
	</p>

	<?php
}
add_action( 'trustedd_download_meta_add_fields', 'trustedd_download_meta_doc_url' );

/**
 * Save function
 *
 * @since 1.0.0
*/
function trustedd_download_meta_save( $post_id ) {

	if ( ( isset( $_POST['post_type'] ) && 'download' == $_POST['post_type'] )  ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
	    	return;
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
	    	return;
	}

	if ( ! isset( $_POST['trustedd_download_meta'] ) || ! wp_verify_nonce( $_POST['trustedd_download_meta'], 'trustedd_download_meta' ) ) {
		return;
	}

	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
		return;
	}

	if ( isset( $post->post_type ) && 'revision' == $post->post_type ) {
		return;
	}

	if ( ! current_user_can( 'edit_product', $post_id ) ) {
		return;
	}

	$fields = apply_filters( 'trustedd_download_meta_save', array(
			'trustedd_download_date_released',
			'trustedd_download_date_updated',
			'trustedd_download_version',
			'trustedd_download_url',
			'trustedd_doc_url',
		)
	);




	// if ( isset( $_POST['trustedd_download_meta'] ) ) {
	//
	// }

	$empty_fields = true;

	foreach ( $fields as $field ) {

		if ( ! empty( $_POST[ $field ] ) ) {
			$empty_fields = false;
		}



		$new = ( isset( $_POST[ $field ] ) ? esc_attr( $_POST[ $field ] ) : '' );

        // sanitize URL fields
        if ( $field == 'trustedd_download_url' || $field == 'trustedd_doc_url' ) {
            $new = esc_url_raw( $_POST[ $field ] );
        }

        $new = apply_filters( 'trustedd_download_meta_save_fields', $new, $field );

		$meta_key = '_' . $field;

		// Get the meta value of the custom field key.
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		// If a new meta value was added and there was no previous value, add it.
		if ( $new && '' == $meta_value ) {
            add_post_meta( $post_id, $meta_key, $new, true );
        }

		// If the new meta value does not match the old value, update it.
		elseif ( $new && $new != $meta_value ) {
            update_post_meta( $post_id, $meta_key, $new );
        }

		// If there is no new meta value but an old value exists, delete it.
		elseif ( '' == $new && $meta_value ) {
            delete_post_meta( $post_id, $meta_key, $meta_value );
        }
	}

	// set a flag if there is download meta
	if ( ! $empty_fields ) {
		update_post_meta( $post_id, '_trustedd_has_download_meta', true );
	} else {
		delete_post_meta( $post_id, '_trustedd_has_download_meta' );
	}

}
add_action( 'save_post', 'trustedd_download_meta_save', 1 );

/**
 * Check for the existance of download meta
 *
 * @since  1.0.0
 */
function trustedd_has_download_meta( $download_id ) {
	return get_post_meta( $download_id, '_trustedd_has_download_meta', true );
}

/**
 * Download meta
 *
 * @since  1.0.0
 */
function trustedd_show_download_meta() {

	if ( ! trustedd_has_download_meta( get_the_ID() ) ) {
		return;
	}
?>
	<aside class="download-meta">
		<ul>
        <?php do_action( 'trustedd_download_meta' ); ?>
		</ul>
	</aside>
	<?php
}
add_action( 'trustedd_sidebar_download', 'trustedd_show_download_meta' );


/**
 * Version
 *
 * @since 1.0.0
 */
function trustedd_download_version() {

    // changelog
    // Show textarea if software licensing isn't installed
	$changelog = stripslashes( wpautop( get_post_meta( get_the_ID(), '_edd_sl_changelog', true ), true ) );

	if ( trustedd_is_edd_sl_active() ) {
		// EDD SL installed
		$version = get_post_meta( get_the_ID(), '_edd_sl_version', true );
	} else {
		// use fallback version number
		$version = get_post_meta( get_the_ID(), '_trustedd_download_version', true );
	}

?>

    <?php if ( $version ) : ?>
		<li>
			<img src="<?php echo get_template_directory_uri() . '/images/download-version.svg'; ?>" width="24" height="24">
			<span>Version <?php echo esc_attr( $version ); ?></span>
		</li>

		<?php /*
        <li><span>Version</span> v<?php echo esc_attr( $version ); ?>
            <?php if ( $changelog ) : ?>
                <br /><a href="#changelog" class="popup-content" data-effect="mfp-move-from-bottom">View changelog</a>

                <div id="changelog" class="popup entry-content mfp-with-anim mfp-hide">
                    <h1>Changelog</h1>
                    <?php echo $changelog; ?>
                </div>

            <?php endif; ?>
        </li>
		*/?>
    <?php endif; ?>
<?php }
add_action( 'trustedd_download_meta', 'trustedd_download_version' );

/**
 * Download release date
 *
 * @since 1.0.0
 */
function trustedd_download_released() {
	$released = ! empty( get_post_meta( get_the_ID(), '_trustedd_download_date_released', true ) ) ? date_i18n( get_option( 'date_format' ), strtotime( get_post_meta( get_the_ID(), '_trustedd_download_date_released', true ) ) ) : '';

	if ( $released ) : ?>
        <li>
			<img src="<?php echo get_template_directory_uri() . '/images/download-released.svg'; ?>" width="24" height="24">
			<span>Released <?php echo esc_attr( $released ); ?></span>
		</li>
    <?php endif; ?>

<?php }
add_action( 'trustedd_download_meta', 'trustedd_download_released' );

/**
 * Download last updated
 *
 * @since 1.0.0
 */
function trustedd_download_last_updated() {
	$updated = ! empty( get_post_meta( get_the_ID(), '_trustedd_download_date_updated', true ) ) ? date_i18n( get_option( 'date_format' ), strtotime( get_post_meta( get_the_ID(), '_trustedd_download_date_updated', true ) ) ) : '';

?>
    <?php if ( $updated ) : ?>
    <li>
		<img src="<?php echo get_template_directory_uri() . '/images/download-last-updated.svg'; ?>" width="24" height="24">
		<span>Updated <?php echo esc_attr( $updated ); ?></span>
	</li>
    <?php endif; ?>
<?php }
add_action( 'trustedd_download_meta', 'trustedd_download_last_updated' );

/**
 * Download documentation URL
 *
 * @since 1.0.0
 */
function trustedd_download_documentation() {
    // external doc url
    $documentation_url = get_post_meta( get_the_ID(), '_trustedd_doc_url', true );

    $external = ' target="blank"';
?>

    <?php if ( $documentation_url ) : ?>
        <li>
			<a href="<?php echo $documentation_url; ?>" class="download-meta-link"<?php echo $external; ?>>
				<img src="<?php echo get_template_directory_uri() . '/images/download-documentation.svg'; ?>" width="24" height="24">
				<span>View Documentation</span>
			</a>
		</li>
    <?php endif; ?>

<?php }
add_action( 'trustedd_download_meta', 'trustedd_download_documentation' );

/**
 * Get the download meta
 *
 * @since 1.0.0
 */
function trustedd_get_download_meta( $meta = '' ) {

	if ( ! $meta ) {
		return;
	}

	$meta = get_post_meta( get_the_ID(), $meta, true ) ? get_post_meta( get_the_ID(), $meta, true ) : '';

	if ( $meta ) {
		return $meta;
	}

	return false;

}
