jQuery(document).ready(function($) {

	$('body').addClass('js');

	/**
	 * EDD cart information in the header
	 */
	var cartTotalAmount = $('.navCart-cartTotalAmount');

	$('body').on('edd_cart_item_added', function( event, response ) {

		$( '.navCart' ).removeClass('empty');

		if ( typeof cartQuantityText !== 'undefined' ) {
			var textSingular = cartQuantityText.singular,
				textPlural   = cartQuantityText.plural,
				cartText     = ' ' + textPlural;

			if ( response.cart_quantity === '1' ) {
				cartText = ' ' + textSingular;
			}

			$('.navCart-quantityText').html( cartText );
		}

		cartTotalAmount.html( response.total );

	});

});
