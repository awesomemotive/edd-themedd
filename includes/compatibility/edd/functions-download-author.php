<?php

/**
 * Download author options
 *
 * @since 1.0.0
 */
function themedd_edd_download_author_options( $args = array() ) {

	// Set some defaults for the download sidebar when the widget is not in use.
	$defaults = apply_filters( 'themedd_edd_download_author_defaults', array(
		'avatar'      => true,
		'avatar_size' => 80,
		'store_name'  => true,
		'name'        => true,
		'signup_date' => true,
		'website'     => true,
		'title'       => __( 'Author details', 'themedd' ),
	) );

	// Merge any args passed in from the widget with the defaults.
	$args = wp_parse_args( $args, $defaults );

	// If Frontend Submissions is active, show the author details by default.
	if ( themedd_is_edd_fes_active() ) {
		$args['show'] = true;
	}

	/**
	 * Return the final $args
	 * Developers can use this filter hook to override options from widget settings or on a per-download basis.
	 */
	return apply_filters( 'themedd_edd_download_author_options', $args );

}

/**
 * Determine if the author details can be shown
 */
function themedd_edd_show_download_author( $options = array() ) {

	// If no options are passed in, use the default options.
	if ( empty( $options ) ) {
		$options = themedd_edd_download_author_options();
	}

	if ( isset( $options['show'] ) && true === $options['show'] && true === themedd_edd_has_download_author( $options ) ) {
		return true;
	}

	return false;

}

/**
 * Determine if the current download has any author details.
 *
 * @since 1.0.0
 */
function themedd_edd_has_download_author( $options = array() ) {

	// Remove "show" from the $options array since we don't want to check against it.
	unset( $options['show'] );

	// If (bool) true exists anywhere in the $options array then there are author details that need to be shown.
	if ( in_array( (bool) true, $options, true ) ) { // Uses strict mode.
		return true;
	}

	return false;

}

/**
 * Output the product author.
 *
 * @since 1.1
 */
function themedd_download_author( $post ) {

	// Get the author options.
	$author_options = themedd_edd_download_author_options();

	/**
	 * Show the Author Details
	 */
	if ( themedd_edd_show_download_author() ) : ?>
	<section class="widget product-author">
		<?php
		/**
		 * Author avatar
		 */
		$user       = new WP_User( $post->post_author );
		$vendor_url = themedd_is_edd_fes_active() ? (new Themedd_EDD_Frontend_Submissions)->author_url( get_the_author_meta( 'ID', $post->post_author ) ) : '';

		if ( true === $author_options['avatar'] ) : ?>

			<div class="product-author-avatar mb-3">
			<?php if ( $vendor_url ) : ?>
				<a href="<?php echo $vendor_url; ?>"><?php echo get_avatar( $user->ID, $author_options['avatar_size'], '', get_the_author_meta( 'display_name' ), array( 'class' => 'rounded-circle' ) ); ?></a>
			<?php else : ?>
				<?php echo get_avatar( $user->ID, $author_options['avatar_size'], '', get_the_author_meta( 'display_name' ), array( 'class' => 'rounded-circle' ) ); ?>
			<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php
		/**
		 * Author's store name.
		 */
		if ( true === $author_options['store_name'] ) :
			$store_name = get_the_author_meta( 'name_of_store', $post->post_author );
		?>

			<?php if ( themedd_is_edd_fes_active() && ! empty( $store_name ) ) : ?>
			<h2 class="widget-title"><?php echo $store_name; ?></h2>
			<?php endif; ?>

		<?php endif; ?>

		<?php
		$title = $author_options['title'];
		if ( $title ) : ?>
		<h2 class="widget-title"><?php echo $title; ?></h2>
		<?php endif; ?>

		<dl class="product-meta">

		<?php do_action( 'themedd_edd_sidebar_download_author_list_start', $author_options ); ?>

		<?php
		/**
		 * Author name.
		 */
		if ( true === $author_options['name'] ) : ?>

			<dt><?php _e( 'Author', 'themedd' ); ?></dt>
			<dd>
				<?php if ( themedd_is_edd_fes_active() ) : ?>
					<a class="vendor-url" href="<?php echo $vendor_url; ?>">
						<?php echo $user->display_name; ?>
					</a>
				<?php else : ?>
					<?php echo $user->display_name; ?>
				<?php endif; ?>
			</dd>
		<?php endif; ?>

		<?php
		/**
		 * Author signup date.
		 */
		if ( true === $author_options['signup_date'] ) : ?>
			<dt><?php _e( 'Author since', 'themedd' ); ?></dt>
			<dd><?php echo date_i18n( get_option( 'date_format' ), strtotime( $user->user_registered ) ); ?></dd>
		<?php endif; ?>

		<?php
		/**
		 * Author website.
		 */
		$website = get_the_author_meta( 'user_url', $post->post_author );

		if ( ! empty( $website ) && true === $author_options['website'] ) : ?>

		<dt><?php _e( 'Website', 'themedd' ); ?></dt>
		<dd class="product-author-value"><a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener"><?php echo esc_url( $website ); ?></a></dd>
		<?php endif; ?>

		<?php do_action( 'themedd_edd_sidebar_download_author_list_end', $author_options ); ?>

		</dl>

	</section>
	<?php endif;
}
add_action( 'themedd_edd_sidebar_download', 'themedd_download_author', 20, 1 );