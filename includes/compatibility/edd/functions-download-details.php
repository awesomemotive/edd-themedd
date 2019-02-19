<?php
/**
 * Download details functions
 */

/**
 * Download details options.
 *
 * @since  1.0.0
 * @param  array $args Download Details options passed in from the Themedd: Download Details widget
 *
 * @return array $args The final Download Details options
 */
function themedd_edd_download_details_options( $args = array() ) {

	// Set some defaults for the download sidebar when the widget is not in use.
	$defaults = apply_filters( 'themedd_edd_download_details_defaults', array(
		'show'           => true,
		'title'          => __( 'Product details', 'themedd' ),
		'date_published' => false,
		'sale_count'     => false,
		'version'        => false,
		'categories'     => true,
		'tags'           => true,
	) );

	// Set some defaults when Frontend Submissions is activated.
	if ( themedd_is_edd_fes_active() ) {
		$defaults['title']          = sprintf( __( '%s Details', 'themedd' ), edd_get_label_singular() );
		$defaults['date_published'] = true;
		$defaults['sale_count']     = true;
	}

	// Set some defaults when Software Licensing is activated.
	if ( themedd_is_edd_sl_active() ) {
		$defaults['version'] = true;
	}

	// Merge any args passed in from the widget with the defaults.
	$args = wp_parse_args( $args, $defaults );

	/**
	 * Return the final $args
	 * Developers can use this filter hook to override options from widget settings or on a per-download basis.
	 */
	return apply_filters( 'themedd_edd_download_details_options', $args );

}



/**
 * Determine if the current download has any download details.
 *
 * @since 1.0.0
 */
function themedd_edd_has_download_details( $options = array() ) {

	$return = false;

	$download_id = get_the_ID();

	if (
		true === $options['categories'] && themedd_edd_download_categories( $download_id ) || // Download categories are enabled and exist.
		true === $options['tags'] && themedd_edd_download_tags( $download_id )             || // Download tags are enabled and exist.
		true === $options['sale_count']                                                    || // Sale count has been enabled from the "Themedd: Download Details" widget.
		true === $options['date_published']                                                || // Date published as been enabled from the "Themedd: Download Details" widget.
		true === $options['version'] && themedd_edd_download_version( $download_id )          // Version number is allowed, and the download has a version number, the download details can be shown.
	) {
		$return = true;
	}

	return apply_filters( 'themedd_edd_has_download_details', $return, $options );

}

/**
 * Get the download categories of a download, given its ID
 *
 * @since 1.0.0
 */
function themedd_edd_download_categories( $download_id = 0, $before = '', $sep = ', ', $after = '' ) {

	if ( ! $download_id ) {
		return false;
	}

	$categories = get_the_term_list( $download_id, 'download_category', $before, $sep, $after );

	if ( $categories ) {
		return $categories;
	}

	return false;

}

/**
 * Get the download tags of a download, given its ID.
 *
 * @since 1.0.0
 */
function themedd_edd_download_tags( $download_id = 0, $before = '', $sep = ', ', $after = '' ) {

	if ( ! $download_id ) {
		return false;
	}

	$tags = get_the_term_list( $download_id, 'download_tag', $before, $sep, $after );

	if ( $tags ) {
		return $tags;
	}

	return false;

}

/**
 * Get the version number of a download, given its ID.
 *
 * @since 1.0.0
 */
function themedd_edd_download_version( $download_id = 0 ) {

	if ( ! $download_id ) {
		return false;
	}

	if ( themedd_is_edd_sl_active() && (new Themedd_EDD_Software_Licensing)->has_licensing_enabled() ) {
		// Get version number from EDD Software Licensing.
		return get_post_meta( $download_id, '_edd_sl_version', true );
	}

	return false;

}

/**
 * Date published
 *
 * @since 1.0.0
 */
function themedd_edd_download_date_published() {

	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	return $time_string;

}

/**
 * Determine if the download details can be shown.
 *
 * @since 1.0.0
 */
function themedd_edd_show_download_details( $options = array() ) {

	// If no options are passed in, use the default options.
	if ( empty( $options ) ) {
		$options = themedd_edd_download_details_options();
	}

	if ( isset( $options['show'] ) && true === $options['show'] && true === themedd_edd_has_download_details( $options ) ) {
		return true;
	}

	return false;

}

/**
 * Output the product details.
 *
 * @param array $widget_args The widget args from the download details widget.
 * @param array $widget_options The widget options from the download details widget.
 *
 * @since 1.1
 */
function themedd_edd_product_details( $post, $widget_args = array(), $widget_options = array() ) {

	if ( empty( $widget_options ) ) {
		// Get the download options.
		$options = themedd_edd_download_details_options();
	} else {
		$options = $widget_options;
	}

	/**
	 * Show the Download Details
	 */
	if ( themedd_edd_show_download_details() ) : ?>

	<?php if ( empty( $widget_args ) ) : ?>
	<section class="widget product-details">
	<?php endif; ?>

		<?php
		/**
		 * Widget title.
		 */
		if ( empty( $widget_args ) && ! empty( $options['title'] ) ) : ?>
		<h2 class="widget-title"><?php echo $options['title']; ?></h2>
		<?php endif; ?>

		<dl class="product-meta">

			<?php do_action( 'themedd_edd_sidebar_download_details_list_start', $options ); ?>

			<?php
			/**
			 * Date published.
			 */
			if ( true === $options['date_published'] ) : ?>
			<dt><?php _e( 'Published', 'themedd' ); ?></dt>
			<dd><?php echo themedd_edd_download_date_published(); ?></dd>
			<?php endif; ?>

			<?php
			/**
			 * Sale count.
			 */
			if ( true === $options['sale_count'] ) :
				$sales = edd_get_download_sales_stats( $post->ID );
			?>
			<dt><?php _e( 'Sales', 'themedd' ); ?></dt>
			<dd><?php echo $sales; ?></dd>
			<?php endif; ?>

			<?php
			/**
			 * Version.
			 */
			if ( true === $options['version'] ) :
				$version = themedd_edd_download_version( $post->ID );
				if ( $version ) : ?>
				<dt><?php _e( 'Version', 'themedd' ); ?></dt>
				<dd><?php echo $version; ?></dd>
				<?php endif; ?>
			<?php endif; ?>

			<?php
			/**
			 * Download categories.
			 */
			if ( true === $options['categories'] ) :
				$categories = get_the_terms( $post->ID, 'download_category' );

				if ( $categories ) : ?>
					<dt><?php _e( 'Categories', 'themedd' ); ?></dt>
					<?php foreach( $categories as $category ) : ?>
					<dd>
						<a href="<?php echo get_term_link( $category, 'download_category' )?>"><?php echo $category->name; ?></a>
					</dd>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endif; ?>

			<?php
			/**
			 * Download tags.
			 */
			if ( true === $options['tags'] ) :
				$tags = get_the_terms( $post->ID, 'download_tag' );

				if ( $tags ) : ?>
					<dt><?php _e( 'Tags', 'themedd' ); ?></dt>
					<?php foreach( $tags as $tag ) : ?>
					<dd>
						<a href="<?php echo get_term_link( $tag, 'download_tag' )?>"><?php echo $tag->name; ?></a>
					</dd>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endif; ?>

			<?php do_action( 'themedd_edd_sidebar_download_details_list_end', $options ); ?>

		</dl>

	<?php if ( empty( $widget_args ) ) : ?>
	</section>
	<?php endif; ?>

	<?php endif; ?>

<?php
}
add_action( 'themedd_edd_sidebar_download', 'themedd_edd_product_details', 11, 3 );