(function (document, uses, requestAnimationFrame, CACHE, IE9TO11) {
	function embed(svg, g) {
		if (g) {
			var
			viewBox = g.getAttribute('viewBox'),
			fragment = document.createDocumentFragment(),
			clone = g.cloneNode(true);

			if (viewBox) {
				svg.setAttribute('viewBox', viewBox);
			}

			while (clone.childNodes.length) {
				fragment.appendChild(clone.childNodes[0]);
			}

			svg.appendChild(fragment);
		}
	}

	function onload() {
		var xhr = this, x = document.createElement('x'), s = xhr.s;

		x.innerHTML = xhr.responseText;

		xhr.onload = function () {
			s.splice(0).map(function (array) {
				embed(array[0], x.querySelector('#' + array[1].replace(/(\W)/g, '\\$1')));
			});
		};

		xhr.onload();
	}

	function onframe() {
		var use;

		while ((use = uses[0])) {
			var
			svg = use.parentNode,
			url = use.getAttribute('xlink:href').split('#'),
			url_root = url[0],
			url_hash = url[1];

			svg.removeChild(use);

			if (url_root.length) {
				var xhr = CACHE[url_root] = CACHE[url_root] || new XMLHttpRequest();

				if (!xhr.s) {
					xhr.s = [];

					xhr.open('GET', url_root);

					xhr.onload = onload;

					xhr.send();
				}

				xhr.s.push([svg, url_hash]);

				if (xhr.readyState === 4) {
					xhr.onload();
				}

			} else {
				embed(svg, document.getElementById(url_hash));
			}
		}

		requestAnimationFrame(onframe);
	}

	if (IE9TO11) {
		onframe();
	}
})(
	document,
	document.getElementsByTagName('use'),
	window.requestAnimationFrame || window.setTimeout,
	{},
	/Trident\/[567]\b/.test(navigator.userAgent) || (navigator.userAgent.match(/AppleWebKit\/(\d+)/) || [])[1] < 537
);
;jQuery(document).ready(function($) {

	/**
	 * EDD cart information in the header
	 */
	var cartTotalAmount = $('.nav-cart-total-amount');

	$('body').on('edd_cart_item_added', function( event, response ) {

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