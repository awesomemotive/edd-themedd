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
 * The combined price and purchase button shown on the single download page
 *
 * @since 1.0.0
 * @uses themedd_edd_price()
 * @uses themedd_edd_purchase_link()
 */
if ( ! function_exists( 'themedd_edd_download_info' ) ) :
function themedd_edd_download_info() {

    if ( ! is_singular( 'download' ) ) {
        return;
    }

	do_action( 'themedd_edd_download_info_start', get_the_ID() );

	// Display download price.
	if ( themedd_edd_price_enhancements() ) {
		echo themedd_edd_price();
	}

	do_action( 'themedd_edd_download_info_after_price', get_the_ID() );

	// Display purchase link.
    themedd_edd_purchase_link();

	do_action( 'themedd_edd_download_info_end', get_the_ID() );

}
endif;

/**
 * Download price
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_edd_price' ) ) :
function themedd_edd_price() {

	if ( edd_is_free_download( get_the_ID() ) ) {
		 $price = '<span class="edd_price">' . __( 'Free', 'themedd' ) . '</span>';
	} elseif (  edd_has_variable_prices( get_the_ID() ) ) {
		$price =  '<div itemprop="price" class="edd_price">' . __( 'From', 'themedd' ) . '&nbsp;' . edd_price( get_the_ID(), false ) . '</div>';
	} else {
		$price = edd_price( get_the_ID() );
	}

	return $price;

}
endif;

/**
 * Download purchase link
 *
 * @since 1.0.0
 */
function themedd_edd_purchase_link() {

	if ( get_post_meta( get_the_ID(), '_edd_hide_purchase_link', true ) ) {
		return; // Do not show if auto output is disabled
	}

	echo edd_get_purchase_link();

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

		$options = themedd_download_grid_options();

		// Exit early if pagination has been set to false.
		if ( true !== $options['pagination'] ) {
			return;
		}

		$big          = 999999;
		$search_for   = array( $big, '#038;' );
		$replace_with = array( '%#%', '&' );

		$pagination = paginate_links( array(
			'base'    => str_replace( $search_for, $replace_with, get_pagenum_link( $big ) ),
			'format'  => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total'   => $wp_query->max_num_pages
		) );
		?>

		<?php if ( ! empty( $pagination ) ) : ?>
		<div id="edd_download_pagination" class="navigation">
			<?php echo $pagination; ?>
		</div>
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

	return $distraction_free_checkout;
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
