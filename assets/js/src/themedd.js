jQuery(document).ready(function($) {

	$('body').addClass('js');

	/**
	 * EDD cart information in the header
	 */
	var cartTotalAmount = $('.navCart-cartTotalAmount');

	$('body').on('edd_cart_item_added', function( event, response ) {

		$( '.navCart' ).removeClass('empty');

		if ( typeof themedd_scripts !== 'undefined' ) {
			var textSingular = themedd_scripts.cartQuantityTextSingular,
				textPlural   = themedd_scripts.cartQuantityTextPlural,
				cartText     = ' ' + textPlural;

			if ( response.cart_quantity === '1' ) {
				cartText = ' ' + textSingular;
			}

			$('.navCart-quantityText').html( cartText );
		}

		cartTotalAmount.html( response.total );

	});

	$('body').on('edd_cart_item_removed', function( event, response ) {

		if ( typeof themedd_scripts !== 'undefined' ) {

			var textSingular = themedd_scripts.cartQuantityTextSingular,
				textPlural   = themedd_scripts.cartQuantityTextPlural,
				cartText     = ' ' + textPlural;

			if ( response.cart_quantity === '1' ) {
				cartText = ' ' + textSingular;
			}

			if ( response.cart_quantity === '' ) {
				cartText = '0 ' + textPlural;
			}

			$('.navCart-quantityText').html( cartText );

		}

		cartTotalAmount.html( response.total );

	});

});