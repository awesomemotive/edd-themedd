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
		<nav aria-label="<?php _e( 'Product navigation', 'themedd' ); ?>" class="navigation">
			<ul class="pagination justify-content-center mt-5">
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