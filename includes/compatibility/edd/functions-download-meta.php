<?php
/**
 * Download meta functions
 */

/**
 * Determine if there's download meta.
 *
 * @since 1.0.0
 *
 * @return bool true if download meta, false otherwise.
 */
function themedd_edd_has_download_meta() {

	$has_download_meta = false;

	// Get the download meta options
	$options = themedd_edd_download_meta_options();

	if (
		true === $options['price'] ||
		true === $options['author_name'] ||
		true === $options['avatar']
	) {
		$has_download_meta = true;
	}

	return $has_download_meta;

}

/**
 * Download meta position.
 *
 * Appears in a download on the download grid (either with the [downloads] shortcode or archive-download.php)
 *
 * Possible values are:
 * after_title (default)
 * after
 * before_title
 *
 * @since 1.0.0
 * @return string $position The position of the download meta
 */
function themedd_edd_download_meta_position() {

	$options  = themedd_edd_download_meta_options();
	$position = $options['position'];

	return $position;

}

/**
 * Download meta options.
 *
 * @since 1.0.0
 *
 * @return array $options Download meta options
 */
function themedd_edd_download_meta_options() {

	$options = array(
		'echo'        => true,
		'position'    => 'after_title', // See themedd_edd_download_meta_position() for possible values.
		'price'       => false,
		'price_link'  => false, // Whether or not the price is linked through to the download.
		'author_name' => false,
		'author_link' => true,
		'author_by'   => __( 'by', 'themedd' ),
		'avatar'      => false,
		'avatar_size' => 32 // Size of avatar, in pixels.
	);

	// Display author name (which will be their store name) and avatar if FES is active.
	if ( themedd_is_edd_fes_active() ) {
		$options['author_name'] = true;
		$options['avatar']      = true;
	}

	return apply_filters( 'themedd_edd_download_meta_options', $options );

}

/**
 * Load the download meta.
 *
 * @since 1.0.3
 */
function themedd_edd_load_download_meta() {
	
	// Return early if download meta has been disabled.
	if ( ! apply_filters( 'themedd_edd_download_meta', true, get_the_ID() ) ) {
		return;
	}

	add_action( 'themedd_edd_download_footer_end', 'themedd_edd_download_meta_after' );
	add_action( 'edd_download_after_title', 'themedd_edd_download_meta_after_title' );
	add_action( 'edd_download_before_title', 'themedd_edd_download_meta_before_title' );
}
add_action( 'template_redirect', 'themedd_edd_load_download_meta' );

/**
 * Display the download meta in the download footer.
 *
 * @since 1.0.0
 */
function themedd_edd_download_meta_after() {
	$position = themedd_edd_download_meta_position();

	if ( 'after' !== $position ) {
		return;
	}

	themedd_edd_display_download_meta( array( 'position' => $position ) );
}

/**
 * Display the download meta after the download title.
 *
 * @since 1.0.0
 */
function themedd_edd_download_meta_after_title() {
	$position = themedd_edd_download_meta_position();

	if ( 'after_title' !== $position ) {
		return;
	}

	themedd_edd_display_download_meta( array( 'position' => $position ) );
}

/**
 * Display the download meta before the download title.
 *
 * @since 1.0.0
 */
function themedd_edd_download_meta_before_title() {
	$position = themedd_edd_download_meta_position();

	if ( 'before_title' !== $position ) {
		return;
	}

	themedd_edd_display_download_meta( array( 'position' => $position ) );
}
	
/**
 * Display the download meta
 *
 * @since 1.0.0
 */
function themedd_edd_display_download_meta( $args = array() ) {

	global $post;

	$options = themedd_edd_download_meta_options();

	$args = wp_parse_args( $args, $options );

	if ( empty( $args['position'] ) ) {
		$args['position'] = 'after_title';
	}

	// Avatar display.
	$avatar = $args['avatar'];

	// Avatar size.
	$avatar_size = $args['avatar_size'];

	// Author Name.
	$author = $args['author_name'];

	// Author Link.
	$author_link = $args['author_link'];

	// Author "by"
	$author_by = $args['author_by'] ? $args['author_by'] . '&nbsp;' : '';

	// Price.
	$price = $args['price'];

	// Price link.
	$price_link = $args['price_link'];

	// Classes.
	$classes = array( 'edd-download-meta', 'd-sm-flex', 'align-items-sm-center', 'justify-content-sm-between' );
	
	if ( 'after_title' === $args['position'] || 'before_title' === $args['position'] ) {
		$classes[] = 'mb-3';
	}

	if ( 'after' === $args['position'] ) {
		$classes[] = 'mt-3';
	}

	$echo = true;

	// Don't output download meta if everything has been turned off.
	if ( ! $price && ! $author && ! $avatar ) {
		return;
	}

	ob_start();
	?>

	<div class="<?php echo implode( ' ', array_filter( $classes ) ); ?>">

		<?php do_action( 'themedd_edd_download_meta_start' ); ?>

		<?php
		/**
		 * Price
		 */
		if ( $price ) : ?>

			<?php if ( $price_link ) : ?>
				<a href="<?php the_permalink(); ?>" class="edd-download-meta-price"><?php echo themedd_edd_price(); ?></a>
			<?php else : ?>
				<div class="edd-download-meta-price"><?php echo themedd_edd_price(); ?></div>
			<?php endif; ?>

		<?php endif; ?>

		<?php

		$vendor_name = get_the_author_meta( 'display_name', $post->post_author );

		/**
		 * FES - link through to vendor page
		 */
		if ( themedd_is_edd_fes_active() ) :

			$vendor_url         = (new Themedd_EDD_Frontend_Submissions)->author_url( get_the_author_meta( 'ID', $post->post_author ) );
			$vendor_store_name  = get_the_author_meta( 'name_of_store', $post->post_author );

			?>

			<?php if ( $author_link ) : ?>
				<a class="edd-download-meta-author d-flex align-items-center mt-2 mt-sm-0" href="<?php echo $vendor_url; ?>">
			<?php else : ?>
				<div class="edd-download-meta-author d-flex align-items-center mt-2 mt-sm-0">
			<?php endif; ?>

				<?php
				/**
				 * Avatar.
				 */
				?>
				<?php if ( $avatar ) : ?>
				<span class="edd-download-meta-author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), $avatar_size, '', $vendor_store_name ); ?>
				</span>
				<?php endif; ?>

				<?php if ( $author ) : ?>
				<span class="edd-download-meta-author-name">
					<?php echo ! empty( $vendor_store_name ) ? $author_by . $vendor_store_name : $vendor_name; ?>
				</span>
				<?php endif; ?>

			<?php if ( $author_link ) : ?>
				</a>
			<?php else : ?>
				</div>
			<?php endif; ?>

		<?php else : ?>

			<div class="edd-download-meta-author d-flex align-items-center mt-2 mt-sm-0">

				<?php if ( $avatar ) : ?>
				<span class="edd-download-meta-author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), $avatar_size, '', $vendor_name ); ?>
				</span>
				<?php endif; ?>

				<?php if ( $author ) : ?>
				<span class="edd-download-meta-author-name">
					<?php echo $author_by . get_the_author_meta( 'display_name', $post->post_author ); ?>
				</span>
				<?php endif; ?>

			</div>

		<?php endif; ?>

		<?php do_action( 'themedd_edd_download_meta_end' ); ?>

	</div>

	<?php

	if ( $echo ) {
		echo ob_get_clean();
	} else {
		return ob_get_clean();
	}

}
