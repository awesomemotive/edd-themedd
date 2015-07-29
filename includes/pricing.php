<?php
/**
 * Temp pricing while I suss out styling etc
 */


function trustedd_pricing_table( $args = array() ) {

	$defaults = array(
		'columns' => 3
	);

	$args = wp_parse_args( $args, $defaults );

	$columns = $args['columns'];

	ob_start();

	if ( $args['options'] ) {

		$has_featured = false;

		foreach ( $args['options'] as $option ) {
			if ( array_key_exists( 'highlighted', $option ) ) {
				$has_featured = true;
				break;
			}
		}
	}

	?>
	<div class="pricing-table columns-<?php echo $columns;?><?php if ( $has_featured ) { echo ' has-featured'; } ?>">
		<div class="wrapper">

			<?php foreach ( $args['options'] as $option ) : 

			$id          = isset( $option['id'] ) ? $option['id'] : '';
			$price       = isset( $option['price'] ) ? $option['price'] : '';
			$price_slashed       = isset( $option['price_slashed'] ) ? $option['price_slashed'] : '';
			$button_text = isset( $option['button_text'] ) ? $option['button_text'] : __( 'Purchase', 'trustedd' );
			
			$features    = isset( $option['features'] ) ? $option['features'] : '';
			
			$highlighted = isset( $option['highlighted'] ) ? true : false;

			// title
			if ( isset( $option['title'] ) ) {
				$title = $option['title'];
			} elseif ( $id ) {
				$title = get_the_title( $id );
			} else {
				$title = '';
			}

			// button link
			if ( isset( $option['button_link'] ) ) {
				$button_link = $option['button_link'];
			} elseif ( $id ) {

				$button_link = function_exists( 'edd_get_checkout_uri' ) ? edd_get_checkout_uri() . '?edd_action=add_to_cart&amp;download_id=' . $id : '';

				if ( isset( $option['price_option'] ) ) {
					$button_link .= '&amp;edd_options&#91;price_id&#93;=' . $option['price_option'];
				} else {
					$button_link = function_exists( 'edd_get_checkout_uri' ) ? edd_get_checkout_uri() . '?edd_action=add_to_cart&amp;download_id=' . $id : '';
				}
				
			}

			// pricing
			if ( isset( $option['price'] ) ) {
				// custom price passed in
				$price = $option['price'];
			} elseif ( $id ) {
				
				if ( isset( $option['price_option'] ) ) {
					// get variable prices for the download
					$prices = function_exists( 'edd_get_variable_prices' ) ? edd_get_variable_prices( $id ) : '';

					if ( isset( $prices[$option['price_option']] ) ) {
						$price  = (float) $prices[$option['price_option']]['amount'];
					}
					
				} else {
					// download ID used
					$price = function_exists( 'edd_get_download_price' ) ? edd_get_download_price( $id ) : '';
				}

			}

			?>

				<div class="pricing-option <?php if ( $highlighted ) { echo ' is-highlighted'; } ?>">
					<div class="pricing-wrap">

						<?php if ( $highlighted ) : ?>
						<div class="highlighted">Most popular</div>
						<?php endif; ?>

						<?php if ( $title ) : ?>
							<h2><?php echo $title; ?></h2>
						<?php endif; ?>
						
						<?php if ( $price || $features ) : ?>
						<ul>

							<?php if ( $price ) : ?>
							<li class="pricing">
								<?php if ( $price_slashed ) : ?>
									<s><span class="currency">$</span><span class="price"><?php echo number_format( $price_slashed, 0, '.', ',' ); ?></span></s>
								<?php endif; ?>
								<span class="currency">$</span><span class="price"><?php echo number_format( $price, 0, '.', ',' ); ?></span>
							</li>
							<?php endif; ?>

							<?php if ( $features ) : ?>

								<?php foreach ( $option['features'] as $value ) : ?>
									
								<li class="feature"><?php echo $value; ?></li>

								<?php endforeach; ?>
							<?php endif; ?>

						</ul>	
						<?php endif; ?>

						<div class="pricing-footer">
							<a href="<?php echo esc_url( $button_link ); ?>" class="button small"><?php echo $button_text; ?></a>
						</div>
					</div>
				</div>

			<?php endforeach; ?>
			
		</div>
	</div>
	<?php

	$html = ob_get_clean();
	return $html;
}