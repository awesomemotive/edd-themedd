<?php

/**
 * EDD Price Enhancements
 *
 * While enabled:
 *
 * 1. Prices from purchase buttons are removed
 * 2. Prices are automatically shown when using the [downloads] shortcode (unless "price" is set to "no")
 *
 * @since 1.0.0
 *
 * @return boolean true
 */
function themedd_edd_price_enhancements() {
	return apply_filters( 'themedd_edd_price_enhancements', true );
}

/**
 * Get a download's price.
 * Will either output "Free", "From $5.00" (lowest variable price), or "$5.00".
 *
 * @param int $download_id The download to get the price for.
 * @since 1.0.0
 */
function themedd_edd_price( $download_id = 0 ) {

	// Return early if price enhancements has been disabled.
	if ( false === themedd_edd_price_enhancements() ) {
		return;
	}

	if ( empty( $download_id ) ) {
		$download_id = get_the_ID();
	}

	if ( edd_is_free_download( $download_id ) ) {
		$price = '<span id="edd_price_' . $download_id . '" class="edd_price">' . __( 'Free', 'themedd' ) . '</span>';
	} elseif ( edd_has_variable_prices( $download_id ) ) {
		$price = '<span id="edd_price_' . $download_id . '" class="edd_price">' . __( 'From', 'themedd' ) . '&nbsp;' . edd_currency_filter( edd_format_amount( edd_get_lowest_price_option( $download_id ) ) ) . '</span>';
	} else {
		$price = edd_price( $download_id, false );
	}

	return apply_filters( 'themedd_edd_price', $price, $download_id );

}

/**
 * Download navigation
 * This is used by archive-download.php, taxonomy-download_category.php, taxonomy-download_tag.php
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_edd_download_nav' ) ) :
	function themedd_edd_download_nav() {

		global $wp_query;

		$options = themedd_edd_download_grid_options();

		// Exit early if pagination has been set to false.
		if ( true !== $options['pagination'] ) {
			return;
		}

		$big          = 999999;
		$search_for   = array( $big, '#038;' );
		$replace_with = array( '%#%', '&' );

		$pagination = paginate_links( array(
			'base'      => str_replace( $search_for, $replace_with, get_pagenum_link( $big ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
			'type'      => 'array',
			'prev_text' => __( 'Previous', 'themedd' ),
			'next_text' => __( 'Next', 'themedd' ),
		) );
		?>

		<?php if ( ! empty( $pagination ) ) : ?>
		<nav aria-label="<?php _e( 'Product navigation', 'themedd' ); ?>" class="navigation mb-10">
			<ul class="pagination justify-content-center">
				<?php foreach ( $pagination as $page ) :
					$page = str_replace( 'page-numbers', 'page-link', $page );
					$active = strpos( $page, 'current' ) !== false ? ' active' : '';
				?>
					<li class="page-item<?php echo $active; ?>"><?php echo $page; ?></li>
				<?php endforeach; ?>
			</ul>
		</nav>
		<?php endif; ?>

	<?php
	}
endif;

/**
 * Distraction Free Checkout
 *
 * @since 1.0.0
 *
 * @return boolean true if Distraction Free Checkout is enabled, false otherwise
 */
function themedd_edd_distraction_free_checkout() {
	$edd_theme_options         = get_theme_mod( 'easy_digital_downloads' );
	$distraction_free_checkout = isset( $edd_theme_options['distraction_free_checkout'] ) && true === $edd_theme_options['distraction_free_checkout'] ? true : false;

	return apply_filters( 'themedd_edd_distraction_free_checkout', $distraction_free_checkout );
}

/**
 * Display vendor contact form
 *
 * @since 1.0.0
 *
 * @return boolean true if vendor contact form is enabled, false otherwise
 */
function themedd_edd_fes_vendor_contact_form() {
	$edd_theme_options   = get_theme_mod( 'easy_digital_downloads' );
	$vendor_contact_form = isset( $edd_theme_options['fes_vendor_contact_form'] ) && true === $edd_theme_options['fes_vendor_contact_form'] ? true : false;

	// Set "true" to be the default if no options exist in theme mods array.
	if ( ! isset( $edd_theme_options['fes_vendor_contact_form'] ) ) {
		return true;
	}

	return $vendor_contact_form;
}

/**
 * Custom Post Type Archive Title
 *
 * @since 1.0.3
 *
 * @return string $post_type_archive_title
 */
 function themedd_edd_post_type_archive_title() {
	$edd_theme_options       = get_theme_mod( 'easy_digital_downloads' );
	$post_type_archive_title = isset( $edd_theme_options['post_type_archive_title'] ) ? $edd_theme_options['post_type_archive_title'] : '';

	return apply_filters( 'themedd_edd_post_type_archive_title', $post_type_archive_title );
}


/**
 * Determine if there is a product image.
 *
 * @since 1.1
 */
function themedd_edd_has_product_image( $download_id = 0 ) {

	$download_id = ! empty( $download_id ) ? $download_id : ''; // has_post_thumbnail will check the current post if no ID is passed

	if ( has_post_thumbnail( $download_id ) ) {
		return true;
	}

	return false;
}

/**
 * Determines the classes of the buttons.
 *
 * @since 1.1
 */
function themedd_edd_button_classes() {
	$classes = array( 'btn', 'btn-purchase', 'btn-lg' );

	return $classes;
}

/**
 * Product title.
 *
 * @since 1.1
 */
function themedd_edd_product_title( $download_id = 0 ) {
	$download_id = ! empty( $download_id ) ? $download_id : get_the_ID();
	do_action( 'themedd_edd_product_title_before' );
?>
	<h1 class="product-title mb-1 mb-lg-1"><?php echo get_the_title( $download_id ); ?></h1>
<?php
	do_action( 'themedd_edd_product_title_after' );
}

/**
 * Product price.
 *
 * @since 1.1
 */
function themedd_edd_product_price( $args = array() ) {
	$download_id = ! empty( $args['download_id'] ) ? $args['download_id'] : get_the_ID();

	$classes = ! empty( $args['classes'] ) ? $args['classes'] : array();
	$classes[] = 'product-price';

	do_action( 'themedd_edd_product_price_before' );
?>
	<div<?php themedd_classes( array( 'classes' => $classes ) ); ?>>
		<?php echo themedd_edd_price( $download_id ); ?>
	</div>
	<?php
	do_action( 'themedd_edd_product_price_after' );
}

/**
 * Download purchase link.
 *
 * @since 1.1
 */
function themedd_edd_purchase_link( $args = array() ) {

	$download_id = ! empty( $args['download_id'] ) ? $args['download_id'] : get_the_ID();

	if ( get_post_meta( $download_id, '_edd_hide_purchase_link', true ) ) {
		return; // Do not show if auto output is disabled
	}

	// Get the current button classes.
	$classes = themedd_edd_button_classes();

	// Add a new class
	$classes[] = ! empty( $args['classes'] ) ? implode( ' ' , $args['classes'] ) : '';

	do_action( 'themedd_edd_product_purchase_link_before' );
	?>
	<div class="product-purchase-link">
		<?php echo edd_get_purchase_link( array( 'download_id' => $download_id, 'class' => themedd_classes( array( 'classes' => $classes, 'echo' => false ) ) ) ); ?>
	</div>
<?php
	do_action( 'themedd_edd_product_purchase_link_after' );
}