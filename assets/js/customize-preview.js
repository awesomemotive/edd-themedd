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
				.not('.button, button, input[type="submit"], #submit')
				.not('.edd_download_title a')
				.not('.main-navigation a')
				.not('.site-title a')
				.not('#site-header-secondary-menu a')
				.not('.entry-title a')
				.not('#mobile-menu a')
				.not('.posted-on a')
				.not( '.site-footer a' )
				.css('color', to ? to : defaults.link_color );
		});

	});

	// Link hover color.
	wp.customize('colors[link_hover_color]', function( value ) {

		value.bind(function( to ) {

			jQuery('a')
				.not('.main-navigation a')
				.not('.button, button, input[type="submit"], #submit')
				.not('.edd_download_title a')
				.not('.site-title a')
				.not('#site-header-secondary-menu a')
				.not('.entry-title a')
				.not('#mobile-menu a')
				.not('.posted-on a')
				.not('.site-footer a')
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
			jQuery('.button, button, input[type="submit"], #submit')
				.not('.customize-partial-edit-shortcut-button') // don't affect the customizer edit buttons
				.not('.dropdown-toggle') // don't affect the dropdown toggle on the mobile menu
				.not('.menu-toggle') // don't affect the mobile menu toggle
				.css('background', to ? to : defaults.button_background_color )
				.css('border-color', to ? to : defaults.button_background_color );
		});

	});

	// Button text color.
	wp.customize('colors[button_text_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.button, button, input[type="submit"], #submit')
				.not('.customize-partial-edit-shortcut-button') // don't affect with the customizer edit buttons
				.not('.dropdown-toggle') // don't affect the dropdown toggle on the mobile menu
				.not('.menu-toggle') // don't affect the mobile menu toggle
				.css('color', to ? to : defaults.button_text_color );
		});

	});

	// Button background hover color.
	wp.customize('colors[button_background_hover_color]', function( value ) {

		value.bind(function( to ) {

			jQuery('.button, button, input[type="submit"], #submit').hover(function(e) {

				var previous = wp.customize('colors[button_background_color]')._value;

				jQuery(this)
					.not('.dropdown-toggle') // don't affect the dropdown toggle on the mobile menu
					.not('.menu-toggle') // don't affect the mobile menu toggle
					.not('.customize-partial-edit-shortcut-button') // don't affect the customizer edit buttons
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
			jQuery('#navbar-primary, .toggled-on #mobile-menu').css('background', to ? to : defaults.menu_primary_background_color );
		});

	});

	// Primary menu link color.
	wp.customize('colors[menu_primary_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.main-navigation a')
				.not('.main-navigation .sub-menu a')
				.not('.primary-menu > li.current-menu-item a, .primary-menu > li.current_page_ancestor a') // don't affect the currently active menu link
				.css('color', to ? to : defaults.menu_primary_link_color );

		});

	});

	// Primary menu link hover color.
	wp.customize('colors[menu_primary_link_hover_color]', function( value ) {
		value.bind(function( to ) {

			jQuery('.main-navigation li').hover(function(e) {
				jQuery(this)
					.find( '> a' )
					.not('.main-navigation .sub-menu a')
					.not('.primary-menu > li.current-menu-item a, .primary-menu > li.current_page_ancestor a') // don't affect the currently active menu link
					.css('color', e.type === 'mouseenter' ? to : wp.customize('colors[menu_primary_link_color]')._value )
			})

		});
	});

	// Primary menu active link color.
	wp.customize('colors[menu_primary_link_active_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.main-navigation .current-menu-item > a, .main-navigation .current_page_ancestor > a, .main-navigation .current_page_ancestor > a:hover, .main-navigation li.current_page_ancestor:hover > a')
				.not('.main-navigation .sub-menu a')
				.css('color', to ? to : defaults.menu_primary_link_active_color );
		});

	});

	// Primary menu link background hover color.
	wp.customize('colors[menu_primary_link_background_hover_color]', function( value ) {

		value.bind(function( to ) {

			// Reset the hover style when the color is cleared.
			if ( '' === wp.customize( 'colors[menu_primary_link_background_hover_color]' )._value ) {
				jQuery( 'head' ).append( '<style class="hover-styles">.primary-menu > li:hover { background-color: transparent; }</style>' );
			}

			jQuery('.primary-menu > li').hover(function(e) {

				jQuery(this)
				.not('.primary-menu > li.current-menu-item, .primary-menu > li.current_page_ancestor')
				.css('background-color', e.type === 'mouseenter' ? to : '' )

			})

		});

	});

	// Primary menu link background active color.
	wp.customize('colors[menu_primary_link_background_active_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.primary-menu > li.current-menu-item, .primary-menu > li.current_page_ancestor').css('background', to ? to : '' );
		});

	});

	/**
	 * Sub-menus
	 */

	// Primary sub-menu background color.
	wp.customize('colors[menu_primary_sub_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.main-navigation ul ul li, .main-navigation ul ul').css('background', to ? to : defaults.menu_primary_sub_background_color );
		});

	});

	// Primary sub-menu background hover color.
	wp.customize('colors[menu_primary_sub_background_hover_color]', function( value ) {

		value.bind(function( to ) {

			// Reset the hover style when the color is cleared.
			if ( '' === wp.customize( 'colors[menu_primary_sub_background_hover_color]' )._value ) {
				jQuery( 'head' ).append( '<style class="hover-styles">.main-navigation .sub-menu li:hover { background-color: transparent; }</style>' );
			}

			jQuery('.main-navigation .sub-menu li').hover(function(e) {
				jQuery(this)
				.not('.main-navigation .sub-menu .current-menu-item') // don't affect menu items that are already active
				.css('background-color', e.type === 'mouseenter' ? to : '' )
			})

		});

	});

	// Primary sub-menu background active color.
	wp.customize('colors[menu_primary_sub_background_active_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.main-navigation .sub-menu .current-menu-item, .main-navigation .sub-menu .current_page_ancestor, .main-navigation .sub-menu .current_page_item').css('background', to ? to : wp.customize('colors[menu_primary_sub_background_color]')._value );
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
			jQuery('.main-navigation .sub-menu a, .main-navigation .sub-menu li:hover > a, .main-navigation .sub-menu li.focus > a').hover(function(e) {
				jQuery(this)
					.not('.main-navigation .sub-menu .current-menu-item a') // don't affect menu items that are already active
					.css('color', e.type === 'mouseenter' ? to : wp.customize('colors[menu_primary_sub_link_color]')._value )
			})
		});

	});

	// Primary sub-menu link active color.
	wp.customize('colors[menu_primary_sub_link_active_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.main-navigation .sub-menu .current-menu-item a').css('color', to ? to : '' );
		});

	});

	/**
	 * Secondary menu
	 */

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
			jQuery('.navCart-mobile .navCart-icon')
				.css('fill', to ? to : defaults.cart_icon_color );
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
			jQuery('#mobile-menu').css('background', to ? to : defaults.menu_mobile_background_color );
		});

	});

	// Mobile menu link color.
	wp.customize('colors[menu_mobile_link_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#mobile-menu a, .dropdown-toggle').css('color', to ? to : defaults.menu_mobile_link_color );
		});

	});

	/**
	 * Header search
	 */
	
	// Header search box background color.
	wp.customize('colors[header_search_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.site-header-menu .search-form .search-field, .site-header-menu .search-form .search-submit')
			.css('background', to ? to : defaults.header_search_background_color )
		});

	});

	// Header search box text color.
	wp.customize('colors[header_search_text_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.site-header-menu .search-form .search-field')
			.css('color', to ? to : defaults.header_search_text_color )
		});

	});

	// Header search box icon color.
	wp.customize('colors[header_search_icon_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('.site-header-menu .search-form .search-submit svg *')
			.css('stroke', to ? to : defaults.header_search_icon_color )
		});

	});

	// Mobile search box background color.
	wp.customize('colors[menu_mobile_search_background_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#mobile-menu .search-form .search-field, #mobile-menu .search-form .search-submit')
			.css('background', to ? to : defaults.menu_mobile_search_background_color )
		});

	});

	// Mobile search box text color.
	wp.customize('colors[menu_mobile_search_text_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#mobile-menu .search-form .search-field')
			.css('color', to ? to : defaults.menu_mobile_search_text_color )
		});

	});

	// Mobile search box icon color.
	wp.customize('colors[menu_mobile_search_icon_color]', function( value ) {

		value.bind(function( to ) {
			jQuery('#mobile-menu .search-form .search-submit svg *')
			.css('stroke', to ? to : defaults.menu_mobile_search_icon_color )
		});

	});	

} )( jQuery );