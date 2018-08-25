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

	// Header text color (aka Site Title Color)
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {

			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'position': 'static'
				} );

				$( '.site-title a' ).css( {
					'color': to
				} );
			}

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

	/**
	 * General
	 */

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
				.not('.btn, .edd_download_title a, .site-header a, .site-footer a')
				.css('color', to ? to : defaults.link_color );	
		});

	});

	// Link hover color.
	wp.customize('colors[link_hover_color]', function( value ) {

		value.bind(function( to ) {

			jQuery('a')
				.not('.btn, .edd_download_title a, .site-header a, .site-footer a')
				.hover(function(e) {

				var previousColor = wp.customize('colors[link_color]')._value;

				jQuery(this).css('color', e.type === 'mouseenter' ? to : previousColor )

			})

		});

	});

	// Header background color.
	wp.customize('colors[header_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#masthead')
				.css('background-color', to ? to : defaults.header_background_color );
		});

	});

	/**
	 * Footer
	 */

	// Footer background color.
 	wp.customize('colors[footer_background_color]', function( value ) {

 		value.bind(function( to ) {
 			jQuery('.site-footer')
 				.css('background-color', to ? to : defaults.footer_background_color );
 		});

 	});

	// Footer text color.
 	wp.customize('colors[footer_text_color]', function( value ) {

 		value.bind(function( to ) {
 			jQuery('.site-footer')
 				.css('color', to ? to : defaults.footer_text_color );
 		});

 	});

	// Footer heading color.
	wp.customize('colors[footer_heading_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6')
				.css('color', to ? to : defaults.footer_heading_color );
		});

	});

	// Footer link color.
	wp.customize('colors[footer_link_color]', function( value ) {

		value.bind(function( to ) {

			if ( wp.customize('colors[footer_link_color]')._value === '' ) {
				previousColor = wp.customize('colors[link_color]')._value;
			} else {
				previousColor = 'footer_link_color';
			}

			jQuery('.site-footer a').css('color', to ? to : previousColor );
		});

	});

	// Footer link hover color.
	wp.customize('colors[footer_link_hover_color]', function( value ) {

		value.bind(function( to ) {

			jQuery('.site-footer a').hover(function(e) {

				// If no footer link color is set, make the previous color the link color
				if ( wp.customize('colors[footer_link_color]')._value === '' ) {
					previousColor = wp.customize('colors[link_color]')._value;
				} else {
					previousColor = wp.customize('colors[footer_link_color]')._value;
				}

				jQuery(this).css('color', e.type === 'mouseenter' ? to : previousColor )
			})

		});

	});

	// Footer site info color.
 	wp.customize('colors[footer_site_info_color]', function( value ) {

 		value.bind(function( to ) {
 			jQuery('.site-info')
 				.css('color', to ? to : defaults.footer_site_info_color );
 		});

 	});

	/**
	 * Buttons
	 */

	// Button background color.
	wp.customize('colors[button_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.btn')
				.not('.customize-partial-edit-shortcut-button, .site-header .btn') // don't affect the mobile menu toggle
				.css('background', to ? to : defaults.button_background_color )
				.css('border-color', to ? to : defaults.button_background_color );
		});

	});

	// Button text color.
	wp.customize('colors[button_text_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.btn')

				.not('.customize-partial-edit-shortcut-button, .site-header .btn') // don't affect with the customizer edit buttons
				.css('color', to ? to : defaults.button_text_color );
		});

	});

	// Button background hover color.
	wp.customize('colors[button_background_hover_color]', function( value ) {

		value.bind(function( to ) {

			jQuery('.btn').hover(function(e) {

				var previous = wp.customize('colors[button_background_color]')._value;

				jQuery(this)
					.css('background', e.type === 'mouseenter' ? to : previous )
					.css('border-color', e.type === 'mouseenter' ? to : previous )
			})
		});

	});

	/**
	 * Primary menu
	 */

	// Primary menu background color.
	wp.customize('colors[menu_primary_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-primary').css('background', to ? to : defaults.menu_primary_background_color );
		});

	});

	// Primary menu link color.
	wp.customize('colors[menu_primary_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-primary .navbar-nav .nav-link')
				.css('color', to ? to : defaults.menu_primary_link_color );
		});

	});

	// Primary menu link hover color.
	wp.customize('colors[menu_primary_link_hover_color]', function( value ) {
		value.bind(function( to ) {

			jQuery('#navbar-primary .navbar-nav .nav-link').hover(function(e) {
				jQuery(this)
					.css('color', e.type === 'mouseenter' ? to : wp.customize('colors[menu_primary_link_color]')._value )
			})

		});
	});

	// Primary menu active link color.
	wp.customize('colors[menu_primary_link_active_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-primary .navbar-nav .active > .nav-link')
				.css('color', to ? to : defaults.menu_primary_link_active_color );
		});

	});

	// Primary menu link background hover color.
	wp.customize('colors[menu_primary_link_background_hover_color]', function( value ) {

		value.bind(function( to ) {

			// Reset the hover style when the color is cleared.
			if ( '' === wp.customize( 'colors[menu_primary_link_background_hover_color]' )._value ) {
				jQuery( 'head' ).append( '<style class="hover-styles">#navbar-primary .navbar-nav .nav-item:hover { background-color: transparent; }</style>' );
			}

			jQuery('#navbar-primary .navbar-nav .nav-item').hover(function(e) {

				jQuery(this)
					.css('background-color', e.type === 'mouseenter' ? to : '' )

			})

		});

	});

	// Primary menu link background active color.
	wp.customize('colors[menu_primary_link_background_active_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-primary .navbar-nav .nav-item.active	').css('background', to ? to : '' );
		});

	});

	/**
	 * Sub-menus
	 */

	// Primary sub-menu link color.
	wp.customize('colors[menu_primary_sub_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-primary .dropdown-menu a').css('color', to ? to : defaults.menu_primary_sub_link_color );
		});

	});

	// Primary sub-menu link hover color.
	wp.customize('colors[menu_primary_sub_link_hover_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-primary .dropdown-item').hover(function(e) {
				jQuery(this)
					.css('color', e.type === 'mouseenter' ? to : wp.customize('colors[menu_primary_sub_link_color]')._value )
			})
		});

	});

	// Primary sub-menu link active color.
	wp.customize('colors[menu_primary_sub_link_active_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-primary .navbar-nav .nav-item.active > .dropdown-item').css('color', to ? to : '' );
		});

	});

	// Primary sub-menu background color.
	wp.customize('colors[menu_primary_sub_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-primary .dropdown-menu')
				.css('backgroundColor', to ? to : defaults.menu_primary_sub_background_color )
				.css('borderColor', to ? to : defaults.menu_primary_sub_background_color );
		});

	});

	// Primary sub-menu background hover color.
	wp.customize('colors[menu_primary_sub_background_hover_color]', function( value ) {

		value.bind(function( to ) {

			// Reset the hover style when the color is cleared.
			if ( '' === wp.customize( 'colors[menu_primary_sub_background_hover_color]' )._value ) {
				jQuery( 'head' ).append( '<style class="hover-styles">#navbar-primary .dropdown-item:hover { background-color: transparent; }</style>' );
			}

			jQuery('#navbar-primary .dropdown-item').hover(function(e) {
				jQuery(this)
					.css('background-color', e.type === 'mouseenter' ? to : '' )
			})

		});

	});

	// Primary sub-menu background active color.
	wp.customize('colors[menu_primary_sub_background_active_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-primary .navbar-nav .nav-item.active > .dropdown-item').css('backgroundColor', to ? to : wp.customize('colors[menu_primary_sub_background_color]')._value );
		});

	});

	/**
	 * Secondary menu
	 */

	// Secondary menu link color.
	wp.customize('colors[menu_secondary_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#nav-secondary .navbar-nav .nav-link')
				.css('color', to ? to : defaults.menu_secondary_link_color );
		});

	});

	// Secondary menu link hover color.
	wp.customize('colors[menu_secondary_link_hover_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#nav-secondary .navbar-nav .nav-link').hover(function(e) {
				jQuery(this)
					.css('color', e.type === 'mouseenter' ? to : wp.customize('colors[menu_secondary_link_color]')._value )
			})
		});

	});

	// Cart icon color.
	wp.customize('colors[cart_icon_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.navCart-icon')
				.not('.navCart-mobile .navCart-icon')
				.css('fill', to ? to : defaults.cart_icon_color );
		});

	});

	/**
	 * Mobile menu
	 */

	// Mobile cart icon color.
	wp.customize('colors[mobile_cart_icon_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#nav-mobile .nav-cart-icon .icon')
				.css('color', to ? to : defaults.cart_icon_color );
		});

	});

	// Mobile menu button background color.
	wp.customize('colors[menu_mobile_button_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.navbar-toggler')
				.css('background', to ? to : '' )
				.css('border-color', to ? to : '' );
		});

	});

	// Mobile menu button text color.
	wp.customize('colors[menu_mobile_button_text_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.navbar-toggler-text').css('color', to ? to : '' )
			jQuery('.navbar-toggler .icon').css('color', to ? to : '' )
		});

	});

	// Mobile menu background color.
	wp.customize('colors[menu_mobile_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-mobile').css('background', to ? to : 'transparent' );
		});

	});

	// Mobile menu link color.
	wp.customize('colors[menu_mobile_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#navbar-mobile .nav-link, #navbar-mobile .nav-cart').css('color', to ? to : defaults.menu_mobile_link_color );
		});

	});

	/**
	 * Header search
	 */

	// Header search box background color.
	wp.customize('colors[header_search_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.navbar .search-field, .navbar .btn-search')
				.css('backgroundColor', to ? to : defaults.header_search_background_color )
				.css('borderColor', to ? to : defaults.header_search_background_color )
				.css('transition', 'none');

			jQuery('.navbar .search-form .form-control:focus')
				.css('backgroundColor', to ? to : defaults.header_search_background_color )
		});

	});

	// Header search box text color.
	wp.customize('colors[header_search_text_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.navbar .search-form .form-control')
			.css('color', to ? to : defaults.header_search_text_color )
		});

	});

	// Header search box icon color.
	wp.customize('colors[header_search_icon_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.navbar .icon-search')
			.css('color', to ? to : defaults.header_search_icon_color )
		});

	});

	// Mobile search box background color.
	wp.customize('colors[menu_mobile_search_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#nav-mobile .search-field, #nav-mobile .btn-search')
				.css('backgroundColor', to ? to : defaults.menu_mobile_search_background_color )
				.css('borderColor', to ? to : defaults.menu_mobile_search_background_color )

			// Turn off transitions.
			jQuery('#nav-mobile .form-control, #nav-mobile .btn-search').css('transition', 'none');

		});

	});

	// Mobile search box text color.
	wp.customize('colors[menu_mobile_search_text_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#nav-mobile .search-field')
			.css('color', to ? to : defaults.menu_mobile_search_text_color )
		});

	});

	// Mobile search box icon color.
	wp.customize('colors[menu_mobile_search_icon_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#nav-mobile .icon-search')
			.css('color', to ? to : defaults.menu_mobile_search_icon_color )
		});

	});	

} )( jQuery );