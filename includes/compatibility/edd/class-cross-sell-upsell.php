<?php

/**
 * EDD - Cross-sell/Upsell
 */
class Themedd_EDD_Cross_Sell_Upsell {

	/**
	 * Get things started.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_filter( 'edd_csau_html', array( $this, 'html' ), 10, 5 );
	}

	/**
	 * Styles.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function styles() {
		// Dequeue styles.
	    wp_dequeue_style( 'edd-csau-css' );
	}

	/**
	 * HTML.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function html( $html, $downloads, $heading, $columns, $class_list ) {

		// columns
		if ( $columns ) {
			$classes[] = 'edd_download_columns_' . $columns;
		}

		$classes[] = 'edd_downloads_list';
		$classes[] = 'edd-csau-products';
		$classes[] = 'mb-xs-2';

		// filter array and remove empty values
		$classes    = array_filter( $classes );
		$classes    = ! empty( $classes ) ? implode( ' ', $classes ) : '';
		$class_list = ! empty( $classes ) ? 'class="' . $classes  . '"' : '';

		ob_start();

		?>

		<?php if ( $heading ) : ?>
		<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<div <?php echo $class_list; ?>>
		<?php
		$i = 1;
		while ( $downloads->have_posts() ) : $downloads->the_post(); ?>
			<?php $schema = edd_add_schema_microdata() ? 'itemscope itemtype="http://schema.org/Product" ' : ''; ?>

			<div <?php echo $schema; ?>class="<?php echo apply_filters( 'edd_download_class', 'edd_download', get_the_ID(), '', $i ); ?>" id="edd_download_<?php echo get_the_ID(); ?>">
				<div class="edd_download_inner">

					<?php

					do_action( 'edd_csau_download_before' );

					$show_excerpt = apply_filters( 'edd_csau_show_excerpt', true );
					$show_price   = apply_filters( 'edd_csau_show_price', true );
					$show_button  = apply_filters( 'edd_csau_upsell_show_button', true );

					edd_get_template_part( 'shortcode', 'content-image' );
					edd_get_template_part( 'shortcode', 'content-title' );

					if ( $show_price ) {
						edd_get_template_part( 'shortcode', 'content-price' );
					}

					if ( $show_excerpt ) {
						edd_get_template_part( 'shortcode', 'content-excerpt' );
					}

					// if the download is not in the cart, show the add to cart button

					if ( edd_is_checkout() ) {

						if ( ! edd_item_in_cart( get_the_ID() ) ) {
							$text = apply_filters( 'edd_csau_cross_sell_add_to_cart_text', __( 'Add to cart', 'themedd' ) );
							$price = apply_filters( 'edd_csau_cross_sell_show_button_price', false );

							if ( $show_button ) : ?>

							<div class="edd_download_buy_button">
								<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID(), 'text' => $text, 'price' => $price ) ); ?>
							</div>
							<?php endif; ?>

						<?php } else {
							echo apply_filters( 'edd_csau_added_to_cart_text', '<span class="edd-cart-added-alert">'. __( 'Added to cart', 'themedd' ) . '</span>' );
						}
					} else {
						$text        = apply_filters( 'edd_csau_upsell_add_to_cart_text', __( 'Add to cart', 'themedd' ) );
						$price       = apply_filters( 'edd_csau_upsell_show_button_price', false );
						$show_button = apply_filters( 'edd_csau_upsell_show_button', true );

						if ( $show_button ) :
					?>
						<div class="edd_download_buy_button">
							<?php echo edd_get_purchase_link( array( 'download_id' => get_the_ID(), 'text' => $text, 'price' => $price ) ); ?>
						</div>
						<?php endif; ?>
					<?php }

					do_action( 'edd_csau_download_after' );

					?>
				</div>
			</div>
		<?php $i++; endwhile; wp_reset_postdata(); ?>

		</div>

		<?php

		$html = ob_get_clean();

		return $html;
	}
}
new Themedd_EDD_Cross_Sell_Upsell;
