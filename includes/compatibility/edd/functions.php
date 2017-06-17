<?php

/**
 * Download price
 *
 * @since 1.0.0
 */
function themedd_edd_price() {

	if ( edd_is_free_download( get_the_ID() ) ) {
		 $price = '<span class="edd_price">' . __( 'Free', 'themedd' ) . '</span>';
	} elseif (  edd_has_variable_prices( get_the_ID() ) ) {
		$price =  '<div itemprop="price" class="edd_price">' . __( 'From', 'themedd' ) . ' ' . edd_price( get_the_ID(), false ) . '</div>';
	} else {
		$price = edd_price( get_the_ID() );
	}

	return $price;

}

if ( ! function_exists( 'themedd_edd_purchase_link' ) ) :
/**
 * Download purchase link
 *
 * @since 1.0.0
 */
function themedd_edd_purchase_link() {

	if ( get_post_meta( get_the_ID(), '_edd_hide_purchase_link', true ) ) {
		return; // Do not show if auto output is disabled
	}

	$external_download_url  = function_exists( 'edd_download_meta_get_download_meta' ) ? edd_download_meta_get_download_meta( '_edd_download_meta_url' ) : '';
	$external_download_text = apply_filters( 'themedd_external_download_text', __( 'Visit site', 'themedd' ) );

	if ( $external_download_url ) { ?>

		<div class="edd_download_purchase_form">
			<a href="<?php echo esc_url( $external_download_url ); ?>" class="button wide external" target="_blank">
				<span><?php echo $external_download_text; ?></span>
				<svg class="external" width="16px" height="16px">
					<use xlink:href="<?php echo get_stylesheet_directory_uri() . '/assets/images/svg-defs.svg#icon-external'; ?>"></use>
				</svg>
			</a>
		</div>

		<?php
	} else {
		echo edd_get_purchase_link();
	}

}
endif;







/**
 * Get the number of download columns
 * Used on the download-archive.php page
 *
 * @since 1.0.0
 */
function themedd_edd_download_columns() {
	// Default to 3 like the [downloads] shortcode.
	return apply_filters( 'themedd_edd_download_columns', 3 );
}

/**
 * Download navigation
 * This is used by archive-download.php
 *
 * @since 1.0.0
 */
function themedd_edd_download_nav() {

	global $wp_query;

	$big          = 999999;
	$search_for   = array( $big, '#038;' );
	$replace_with = array( '%#%', '&' );

	$pagination = paginate_links( array(
		'base'      => str_replace( $search_for, $replace_with, get_pagenum_link( $big ) ),
		'format'    => '?paged=%#%',
		'current'   => max( 1, get_query_var( 'paged' ) ),
		'total'     => $wp_query->max_num_pages,
		'prev_text' => __( 'Previous', 'themedd' ),
		'next_text' => __( 'Next', 'themedd' ),
	) );
	?>

	<?php if ( ! empty( $pagination ) ) : ?>
	<div id="edd_download_pagination" class="navigation">
		<?php echo $pagination; ?>
	</div>
	<?php endif; ?>

<?php
}

/**
 * Distraction Free Checkout
 *
 * @since 1.0.0
 *
 * @return boolean true if Distraction Free Checkout is enabled, false otherwise
 */
function themedd_edd_distraction_free_checkout() {
	$edd_theme_options         = get_theme_mod( 'easy_digital_downloads' );
	$distraction_free_checkout = isset( $edd_theme_options['distraction_free_checkout'] ) ? true : false;

	return $distraction_free_checkout;
}
