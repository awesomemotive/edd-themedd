<?php
/**
 * Download grid functions
 */


/**
 * Downloads list wrapper classes
 * These classes are applied wherever a downloads grid is outputted and used by:
 *
 * 1. The [downloads] shortcode
 * 2. archive-download.php
 * 3. taxonomy-download_category.php
 * 4. taxonomy-download_tag.php
 *
 * @since 1.0.0
 *
 * @param string $wrapper_class The class passed in from the [downloads] shortcode
 * @param array $atts The shortcode args passed in from the [downloads] shortcode
 *
 * @return string $classes The classes to be added
 */
function themedd_edd_downloads_list_wrapper_classes( $wrapper_class = '', $atts = array() ) {

	// Get the download grid options.
	$options = themedd_download_grid_options();

	// Set up $classes array.
	$classes = array();

	// [downloads] shortcode is being used
	if ( ! empty( $atts ) ) {

		// Add downloads class.
		$classes[] = 'edd_download_columns_' . $atts['columns'];

		$has_price   = $atts['price'] == 'yes' ? true : false;
		$has_excerpt = $atts['excerpt'] == 'yes' ? true : false;
		$buy_button  = $atts['buy_button'] == 'yes' ? true : false;
		$thumbnails  = $atts['thumbnails'] == 'true' ? true : false;

	} else {
		/**
		 * The download grid is being outputted by either:
		 *
		 * archive-download.php
		 * taxonomy-download_category.php
		 * taxonomy-download_tag.php
		 */

		// The [downloads] shortcode already has the following class applied so only add it for archive-download.php, taxonomy-download_category.php and taxonomy-download_tag.php.
		$classes[] = 'edd_downloads_list';

		// Add downloads class.
		$classes[] = 'edd_download_columns_' . themedd_edd_download_columns();

		$has_price   = true === $options['price'] ? true : false;
		$has_excerpt = true === $options['excerpt'] ? true : false;
		$buy_button  = true === $options['buy_button'] ? true : false;
		$thumbnails  = true === $options['thumbnails'] ? true : false;

	}

	$classes[] = true === $has_price ? 'has-price' : 'no-price';
	$classes[] = true === $has_excerpt ? 'has-excerpt' : '';
	$classes[] = true === $buy_button ? 'has-buy-button' : 'no-buy-button';
	$classes[] = true === $thumbnails ? 'has-thumbnails' : 'no-thumbnails';

	// Add has-download-meta class.
	$classes[] = themedd_edd_has_download_meta() ? 'has-download-meta' : '';

	return implode( ' ', array_filter( $classes ) );
}

/**
 * Download grid options
 * Used by archive-download.php, taxonomy-download_category.php, taxonomy-download_tag.php
 *
 * @since 1.0.0
 *
 * @return array $options Download grid options
 */
function themedd_download_grid_options() {

	$options = array(
		'excerpt'      => true,
		'full_content' => false,
		'price'        => true,
		'buy_button'   => true,
		'columns'      => 3,
		'thumbnails'   => true,
		'pagination'   => true,
		'number'       => 9,
	);

	return apply_filters( 'themedd_download_grid_options', $options );

}

/**
 * The download footer
 *
 * Appears at the bottom of a download in the download grid.
 *
 * @since 1.0.0
 */
function themedd_edd_download_footer( $atts = array() ) {

	$options = themedd_download_grid_options();

	/**
	 * Return early if:
	 *
	 * The [downloads] shortcode does not have a buy button
	 * The position of the download meta is not "after" and there's no download meta
	 *
	 */
	if ( ! (
		isset( $atts['buy_button'] ) && 'yes' === $atts['buy_button'] ||
		true === $options['buy_button'] ||
		( 'after' === themedd_edd_download_meta_position() && themedd_edd_has_download_meta() ) ||
		is_post_type_archive( 'download' ) ||
		is_tax( 'download_category' ) ||
		is_tax( 'download_tag' )
	) ) {
		return;
	}

	?>
	<div class="downloadFooter">
		<?php

		/**
		 * Load the default EDD purchase button
		 */
		if (
			( isset( $atts['buy_button'] ) && 'yes' === $atts['buy_button'] ) ||
			( true === $options['buy_button'] ) &&
			is_post_type_archive( 'download' ) ||
			is_tax( 'download_category' ) ||
			is_tax( 'download_tag' )
		) {
			edd_get_template_part( 'shortcode', 'content-cart-button' );
		}

		do_action( 'themedd_edd_download_footer_end' );

		?>
	</div>

	<?php
}

/**
 * Download meta position
 *
 * Appears in a download on the download grid (either with the [downloads] shortcode or archive-download.php)
 * Possible options are "after_title" (default) or "after".
 *
 * @since 1.0.0
 */
function themedd_edd_download_meta_position() {
	return apply_filters( 'themedd_edd_download_meta_position', 'after_title' );
}

/**
 * Load the download meta before the download title
 *
 * @since 1.0.0
 */
function themedd_edd_download_meta_before_title() {

	// Return early if download meta has been disabled.
	if ( ! apply_filters( 'themedd_edd_download_meta', true, get_the_ID() ) ) {
		return;
	}

	if ( 'before_title' === themedd_edd_download_meta_position() ) {
		themedd_edd_display_download_meta( array( 'position' => 'before_title' ) );
	}

}
add_action( 'edd_download_before_title', 'themedd_edd_download_meta_before_title' );

/**
 * Load the download meta after the download title
 *
 * @since 1.0.0
 */
function themedd_edd_download_meta_after_title() {

	// Return early if download meta has been disabled.
	if ( ! apply_filters( 'themedd_edd_download_meta', true, get_the_ID() ) ) {
		return;
	}

	if ( 'after_title' === themedd_edd_download_meta_position() ) {
		themedd_edd_display_download_meta( array( 'position' => 'after_title' ) );
	}

}
add_action( 'edd_download_after_title', 'themedd_edd_download_meta_after_title' );

/**
 * Load the download meta in Themedd's download footer
 *
 * @since 1.0.0
 */
function themedd_edd_download_meta_after() {

	// Return early if download meta has been disabled.
	if ( ! apply_filters( 'themedd_edd_download_meta', true, get_the_ID() ) ) {
		return;
	}

	if ( 'after' === themedd_edd_download_meta_position() ) {
		themedd_edd_display_download_meta( array( 'position' => 'after' ) );
	}

}
add_action( 'themedd_edd_download_footer_end', 'themedd_edd_download_meta_after' );

/**
 * Determine if there is download meta
 *
 * @since 1.0.0
 *
 * @return bool true if download meta, false otherwise.
 */
function themedd_edd_has_download_meta() {

	$has_meta = false;

	// Get the download meta options
	$options = themedd_edd_download_meta_options();

	if (
		true === $options['price'] ||
		true === $options['author_name'] ||
		true === $options['avatar']
	) {
		$has_meta = true;
	}

	return $has_meta;

}

/**
 * Download meta options
 *
 * @since 1.0.0
 *
 * @return array $options Download meta options
 */
function themedd_edd_download_meta_options() {

	$options = array(
		'echo'        => true,
		'price'       => false,
		'price_link'  => false, // Whether or not the price is linked through to the download.
		'author_name' => false,
		'author_link' => true,
		'author_by'   => __( 'by', 'themedd' ),
		'avatar'      => false,
		'avatar_size' => 32     // Size of avatar, in pixels.
	);

	// Display author name (which will be their store name) and avatar if FES is active.
	if ( themedd_is_edd_fes_active() ) {
		$options['author_name'] = true;
		$options['avatar']      = true;
	}

	return apply_filters( 'themedd_edd_download_meta_options', $options );
}


/**
 * Display the download meta
 *
 * @since 1.0.0
 */
function themedd_edd_display_download_meta( $args = array() ) {

	global $post;

	$options = themedd_edd_download_meta_options();
	$args    = wp_parse_args( $args, $options );

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
	$classes = array( 'eddDownloadMeta' );

	if ( 'after' === $args['position'] ) {
		$classes[] = 'eddDownloadMeta-after';
	} elseif ( 'after_title' === $args['position'] ) {
		$classes[] = 'eddDownloadMeta-afterTitle';
	} elseif ( 'before_title' === $args['position'] ) {
		$classes[] = 'eddDownloadMeta-beforeTitle';
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
				<a href="<?php the_permalink(); ?>" class="eddDownloadMeta-price"><?php echo themedd_edd_download_meta_price(); ?></a>
			<?php else : ?>
				<span class="eddDownloadMeta-price"><?php echo themedd_edd_download_meta_price(); ?></span>
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
				<a class="eddDownloadMeta-author" href="<?php echo $vendor_url; ?>">
			<?php else : ?>
				<span class="eddDownloadMeta-author">
			<?php endif; ?>

				<?php
				/**
				 * Avatar.
				 */
				?>
				<?php if ( $avatar ) : ?>
				<span class="eddDownloadMeta-authorAvatar">
					<?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), $avatar_size, null, $vendor_store_name ); ?>
				</span>
				<?php endif; ?>

				<?php if ( $author ) : ?>
				<span class="eddDownloadMeta-authorName">
					<?php echo ! empty( $vendor_store_name ) ? $author_by . $vendor_store_name : $vendor_name; ?>
				</span>
				<?php endif; ?>

			<?php if ( $author_link ) : ?>
				</a>
			<?php else : ?>
				</span>
			<?php endif; ?>

		<?php else : ?>

			<span class="eddDownloadMeta-author">

				<?php if ( $avatar ) : ?>
				<span class="eddDownloadMeta-authorAvatar">
					<?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), $avatar_size, null, $vendor_name ); ?>
				</span>
				<?php endif; ?>

				<?php if ( $author ) : ?>
				<span class="eddDownloadMeta-authorName">
					<?php echo $author_by . get_the_author_meta( 'display_name', $post->post_author ); ?>
				</span>
				<?php endif; ?>

			</span>

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

/**
 * The price shown in the download Meta
 *
 * @since 1.0.0
 * @uses themedd_edd_price()
 *
 */
if ( ! function_exists( 'themedd_edd_download_meta_price' ) ):
	function themedd_edd_download_meta_price() {
		return themedd_edd_price();
	}
endif;
