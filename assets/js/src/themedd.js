jQuery(document).ready(function($) {

	$('body').addClass('js');

	/**
	 * EDD cart information in the header
	 */
	var cartTotalAmount = $('.nav-cart-total-amount');

	$('body').on('edd_cart_item_added', function( event, response ) {

		$( '.nav-cart' ).removeClass('empty');

		if ( typeof themedd_scripts !== 'undefined' ) {
			var textSingular = themedd_scripts.cartQuantityTextSingular,
				textPlural   = themedd_scripts.cartQuantityTextPlural,
				cartText     = ' ' + textPlural;

			if ( response.cart_quantity === '1' ) {
				cartText = ' ' + textSingular;
			}

			$('.nav-cart-quantity-text').html( cartText );
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

			$('.nav-cart-quantity-text').html( cartText );

		}

		cartTotalAmount.html( response.total );

	});

	var navMobile = '#' + themedd_scripts.navMobile;
	
	$(navMobile).on('show.bs.collapse', function (e) {

		var elementId = $(this).attr('id'), // ID of this collapsible menu.
			button = $("button[data-target='#" + elementId +"']"), // Find the corresponding button that triggered the call.
			textToChange = button.find('.navbar-toggler-text'); // Find the text to change.

		if ( textToChange.length ) {
			textToChange.text(button.data('text-menu-shown'));
		}

		toggleIcon( button, 'icon-menu-shown' );

	});

	$(navMobile).on('hide.bs.collapse', function (e) {

		var elementId = $(this).attr('id'), // ID of this collapsible menu.
			button = $("button[data-target='#" + elementId +"']"), // Find the corresponding button that triggered the call.
			textToChange = button.find('.navbar-toggler-text'); // Find the text to change.
	
		if ( textToChange.length ) {
			textToChange.text(button.data('text-menu-hidden'));
		}

		toggleIcon( button, 'icon-menu-hidden' );

	});

	// Toggle the icon.
	function toggleIcon( button, dataAttribute ) {

		var svgIcon = button.find('.icon use');

		if ( svgIcon.length ) {
			var	iconToToggle = button.data(dataAttribute);

			$(svgIcon).attr('href', '#icon-' + iconToToggle);
			$(svgIcon).get(0).setAttributeNS('http://www.w3.org/1999/xlink', 'href', '#icon-' + iconToToggle);
		}

	}

});