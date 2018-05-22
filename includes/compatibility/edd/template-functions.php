<?php

/**
 * Variable price output
 *
 * Outputs variable pricing options for each download or a specified downloads in a list.
 * The output generated can be overridden by the filters provided or by removing
 * the action and adding your own custom action.
 *
 * @since 1.1
 * @param int $download_id Download ID
 * @return void
 */
function themedd_edd_purchase_variable_pricing( $download_id = 0, $args = array() ) {
	global $edd_displayed_form_ids;

	// If we've already generated a form ID for this download ID, append -#
	$form_id = '';
	if ( $edd_displayed_form_ids[ $download_id ] > 1 ) {
		$form_id .= '-' . $edd_displayed_form_ids[ $download_id ];
	}

	$variable_pricing = edd_has_variable_prices( $download_id );

	if ( ! $variable_pricing ) {
		return;
	}

	$prices = apply_filters( 'edd_purchase_variable_prices', edd_get_variable_prices( $download_id ), $download_id );

	// If the price_id passed is found in the variable prices, do not display all variable prices.
	if ( false !== $args['price_id'] && isset( $prices[ $args['price_id'] ] ) ) {
		return;
	}

	$type   = edd_single_price_option_mode( $download_id ) ? 'checkbox' : 'radio';
	$mode   = edd_single_price_option_mode( $download_id ) ? 'multi' : 'single';
	$schema = edd_add_schema_microdata() ? ' itemprop="offers" itemscope itemtype="http://schema.org/Offer"' : '';

	// Filter the class names for the edd_price_options div
	$css_classes_array = apply_filters( 'edd_price_options_classes', array(
		'edd_price_options',
		'edd_' . esc_attr( $mode ) . '_mode'
	), $download_id );

	// Sanitize those class names and form them into a string
	$css_classes_string = implode( array_map( 'sanitize_html_class', $css_classes_array ), ' ' );

	if ( edd_item_in_cart( $download_id ) && ! edd_single_price_option_mode( $download_id ) ) {
		return;
	}

	do_action( 'edd_before_price_options', $download_id ); ?>
	<div class="<?php echo esc_attr( rtrim( $css_classes_string ) ); ?>">
		<ul>
			<?php
			if ( $prices ) :
				$checked_key = isset( $_GET['price_option'] ) ? absint( $_GET['price_option'] ) : edd_get_default_variable_price( $download_id );
				foreach ( $prices as $key => $price ) :
					echo '<li class="custom-control custom-radio" id="edd_price_option_' . $download_id . '_' . sanitize_key( $price['name'] ) . $form_id . '"' . $schema . '>';
						
							echo '<input type="' . $type . '" ' . checked( apply_filters( 'edd_price_option_checked', $checked_key, $download_id, $key ), $key, false ) . ' name="edd_options[price_id][]" id="' . esc_attr( 'edd_price_option_' . $download_id . '_' . $key . $form_id ) . '" class="custom-control-input ' . esc_attr( 'edd_price_option_' . $download_id ) . '" value="' . esc_attr( $key ) . '" data-price="' . edd_get_price_option_amount( $download_id, $key ) .'"/>&nbsp;';

							$item_prop = edd_add_schema_microdata() ? ' itemprop="description"' : '';

							

							if( edd_add_schema_microdata() ) {
								echo '<meta itemprop="price" content="' . esc_attr( $price['amount'] ) .'" />';
								echo '<meta itemprop="priceCurrency" content="' . esc_attr( edd_get_currency() ) .'" />';
							}
						
						echo '<label class="custom-control-label" for="' . esc_attr( 'edd_price_option_' . $download_id . '_' . $key . $form_id ) . '">';
						
						// Construct the default price output.
						$price_output = '<span class="edd_price_option_name"' . $item_prop . '>' . esc_html( $price['name'] ) . '</span><span class="edd_price_option_sep">&nbsp;&ndash;&nbsp;</span><span class="edd_price_option_price">' . edd_currency_filter( edd_format_amount( $price['amount'] ) ) . '</span>';

						// Filter the default price output
						$price_output = apply_filters( 'edd_price_option_output', $price_output, $download_id, $key, $price, $form_id, $item_prop );

						// Output the filtered price output
						echo $price_output;

						echo '</label>';
						do_action( 'edd_after_price_option', $key, $price, $download_id );
					echo '</li>';
				endforeach;
			endif;
			do_action( 'edd_after_price_options_list', $download_id, $prices, $type );
			?>
		</ul>
	</div><!--end .edd_price_options-->
<?php
	do_action( 'edd_after_price_options', $download_id );
}
remove_action( 'edd_purchase_link_top', 'edd_purchase_variable_pricing', 10, 2 );
add_action( 'edd_purchase_link_top', 'themedd_edd_purchase_variable_pricing', 10, 2 );

