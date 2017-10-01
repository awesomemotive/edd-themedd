<?php

/**
 * Load the search form in the mobile menu.
 *
 * @since 1.0.3
*/
function themedd_search_mobile_menu( $items, $args ) {

    if ( true !== themedd_header_search_box() ) {
        return $items;
    }

    if ( 'mobile-menu' === $args->menu_id ) {
        $items = '<li>' . get_search_form( false ) . '</li>' . $items;
    }

    return $items;
    
}
add_filter( 'wp_nav_menu_items', 'themedd_search_mobile_menu', 10, 2 );

/**
 * Load the search form in the secondary menu.
 *
 * @since 1.0.3
 */
function themedd_search_secondary_menu() {

    if ( true !== themedd_header_search_box() ) {
        return;
    }

    get_search_form();
    
}
add_action( 'themedd_secondary_menu_after', 'themedd_search_secondary_menu' );

/**
 * The search icon.
 *
 * @since 1.0.3
 */
function themedd_search_icon() {

    ob_start();
?>
	<svg width="16" height="16" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:10;">
		<g>
			<circle cx="6.607" cy="6.607" r="5.201" style="fill:none;stroke-width:2px;"/>
			<path d="M10.284,10.284L14.408,14.408" style="fill:none;stroke-width:2px;stroke-linecap:round;"/>
		</g>
	</svg>
<?php
    
    $content = apply_filters( 'themedd_search_icon', ob_get_contents() );
    ob_end_clean();

    return $content;
}

/**
 * Whether or not the header search box is enabled.
 *
 * @since 1.0.3
 *
 * @return boolean true if the search in header is enabled, false otherwise
 */
 function themedd_header_search_box() {

	$theme_options     = get_theme_mod( 'theme_options' );
	$header_search_box = isset( $theme_options['header_search_box'] ) && true === $theme_options['header_search_box'] ? true : false;

    return apply_filters( 'themedd_header_search_box', $header_search_box );
}