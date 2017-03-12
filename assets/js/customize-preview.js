/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

    // Site title.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$('.site-title a').text( to );
		} );
	} );

	// Site description.
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$('.site-description').text(to);
		} );
	} );

	// Add custom-background-image body class when background image is added.
	wp.customize( 'background_image', function( value ) {
		value.bind( function( to ) {
			$('body').toggleClass( 'custom-background-image', '' !== to );
		} );
	} );

	// Header text color (aka Site Title Color)
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title,  .site-description' ).css( {
					'clip': 'auto',
					'position': 'static'
				} );

				$( '.site-title a' ).css( {
					'color': to
				} );
			}
		} );
	} );

	// Default colors.
	var defaults = {
		'tagline_color' : '#a2a2a2',
		'link_color' : '#448fd5',
		'header_background_color' : '#ffffff',
		'menu_primary_background_color' : 'transparent',
		'menu_primary_link_color' : '#222222',
		'menu_primary_sub_background_color' : '#ffffff',
		'menu_primary_sub_link_color' : '#787878',
		'menu_secondary_link_color' : '#787878',
		'cart_icon_color' : '#222222',
		'cart_count_background_color' : '#448fd5',
		'cart_count_color' : '#ffffff',
		'button_background_color' : '#222222',
		'button_background_hover_color' : '#448fd5',
		'menu_mobile_background_color' : 'transparent',
		'menu_mobile_link_color' : '#222222'
	};

	// Tagline color.
	wp.customize('colors[tagline_color]', function( value ) {
		value.bind(function( to ) {
			jQuery('.site-description').css('color', to ? to : defaults.tagline_color );
		});
	});

	// Link color.
	wp.customize('colors[link_color]', function( value ) {
		value.bind(function( to ) {

			jQuery('a')
				.not('.main-navigation a')
				.not('.site-title a')
				.not('#site-header-secondary-menu a')
				.not('.entry-title a')
				.not('.posted-on a')
				.css('color', to ? to : defaults.link_color );
		});

	});

	// Header background color.
	wp.customize('colors[header_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#masthead')
				.css('background', to ? to : defaults.header_background_color );
		});

	});

	// Button background color.
	wp.customize('colors[button_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.button, button, input[type="submit"], #submit')
				.not('.customize-partial-edit-shortcut-button') // don't affect with the customizer edit buttons
				.css('background', to ? to : defaults.button_background_color )
				.css('border-color', to ? to : defaults.button_background_color );
		});

	});

	// Button background hover color.
	wp.customize('colors[button_background_hover_color]', function( value ) {

		value.bind(function( to ) {
			var previous = wp.customize('colors[button_background_color]')._value;

			jQuery('.button, button, input[type="submit"], #submit').hover(function(e) {
				jQuery(this)
					.css('background', e.type === 'mouseenter' ? to : previous )
					.css('border-color', e.type === 'mouseenter' ? to : previous )
			})
		});

	});

	// Primary menu background color.
	wp.customize('colors[menu_primary_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#site-header-menu, .toggled-on #mobile-menu').css('background', to ? to : defaults.menu_primary_background_color );
		});

	});

	// Primary menu link color.
	wp.customize('colors[menu_primary_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.main-navigation a')
				.not('.main-navigation .sub-menu a')
				.css('color', to ? to : defaults.menu_primary_link_color );

				jQuery('#mobile-menu a, .dropdown-toggle').css('color', to ? to : defaults.menu_primary_link_color );
		});

	});

	// Primary menu link hover color.
	wp.customize('colors[menu_primary_link_hover_color]', function( value ) {
		value.bind(function( to ) {

			var previous = wp.customize('colors[menu_primary_link_color]')._value;

			jQuery('.main-navigation a, #mobile-menu a, .dropdown-toggle').hover(function(e) {
				jQuery(this)
					.not('.main-navigation .sub-menu a')
					.css('color', e.type === 'mouseenter' ? to : previous )
			})

		});
	});

	// Primary sub-menu background color.
	wp.customize('colors[menu_primary_sub_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.main-navigation ul ul li').css('background', to ? to : defaults.menu_primary_sub_background_color );
			jQuery('.main-navigation ul ul').css('border-color', to ? to : defaults.menu_primary_sub_background_color );
		});

	});

	// Primary sub-menu link color.
	wp.customize('colors[menu_primary_sub_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.main-navigation .sub-menu a').css('color', to ? to : defaults.menu_primary_sub_link_color );
		});

	});

	// Primary sub-menu link hover color.
	wp.customize('colors[menu_primary_sub_link_hover_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.main-navigation .sub-menu a').hover(function(e) {
				jQuery(this)
					.css('color', e.type === 'mouseenter' ? to : wp.customize('colors[menu_primary_sub_link_color]')._value )
			})
		});

	});

	// Secondary menu link color.
	wp.customize('colors[menu_secondary_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#site-header-secondary-menu a')
				.css('color', to ? to : defaults.menu_secondary_link_color );
		});

	});

	// Secondary menu link hover color.
	wp.customize('colors[menu_secondary_link_hover_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#site-header-secondary-menu a').hover(function(e) {
				jQuery(this)
					.css('color', e.type === 'mouseenter' ? to : wp.customize('colors[menu_secondary_link_color]')._value )
			})
		});

	});

	// Mobile cart icon color.
	wp.customize('colors[mobile_cart_icon_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.nav-cart.mobile .nav-cart-icon')
				.css('fill', to ? to : defaults.cart_icon_color );
		});

	});

	// Cart icon color.
	wp.customize('colors[cart_icon_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.nav-cart-icon')
				.not('.nav-cart.mobile .nav-cart-icon')
				.css('fill', to ? to : defaults.cart_icon_color );
		});

	});

	// Cart count background color.
	wp.customize('colors[cart_count_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.cart-count').css('background', to ? to : defaults.cart_count_background_color );
		});

	});

	// Cart count color.
	wp.customize('colors[cart_count_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.cart-count').css('color', to ? to : defaults.cart_count_color );
		});

	});

	// Mobile menu background color.
	wp.customize('colors[menu_mobile_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#mobile-menu').css('background', to ? to : defaults.menu_mobile_background_color );
		});

	});

	// Mobile menu navigation color.
	wp.customize('colors[menu_mobile_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#mobile-menu a').css('color', to ? to : defaults.menu_mobile_link_color );
		});

	});

} )( jQuery );
