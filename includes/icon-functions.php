<?php
/**
 * SVG icons related functions and filters.
 * Based off the Twenty Seventeen theme.
 */

/**
 * Add SVG definitions to the footer.
 * 
 * @since 1.1
 */
function themedd_include_svg_icons() {
	// Define SVG sprite file.
	$svg_icons = get_parent_theme_file_path( '/assets/images/svg-icons.svg' );

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}
add_action( 'wp_footer', 'themedd_include_svg_icons', 9999 );

/**
 * Return SVG markup.
 * 
 * @since 1.1
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function themedd_get_svg( $args = array() ) {
	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return __( 'Please define default parameters in the form of an array.', 'themedd' );
	}

	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return __( 'Please define an SVG icon filename.', 'themedd' );
	}

	// Set defaults.
	$defaults = array(
		'icon'     => '',
		'title'    => '',
		'desc'     => '',
		'fallback' => false,
		'size'     => '24',
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Set aria hidden.
	$aria_hidden = ' aria-hidden="true"';

	// Set ARIA.
	$aria_labelledby = '';

	/*
	 * Themedd doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
	 *
	 * However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
	 *
	 * Example 1 with title: <?php echo themedd_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
	 *
	 * Example 2 with title and description: <?php echo themedd_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
	 *
	 * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
	 */
	if ( $args['title'] ) {
		$aria_hidden     = '';
		$unique_id       = uniqid();
		$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

		if ( $args['desc'] ) {
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
		}
	}

	// Begin SVG markup.
	$svg = '<svg width="'.esc_attr( $args['size'] ).'" height="'.esc_attr( $args['size'] ).'" class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

	// Display the title.
	if ( $args['title'] ) {
		$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

		// Display the desc only if the title is already set.
		if ( $args['desc'] ) {
			$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}
	}

	/*
	 * Display the icon.
	 *
	 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
	 *
	 * See https://core.trac.wordpress.org/ticket/38387.
	 */
	$svg .= ' <use href="#icon-' . esc_html( $args['icon'] ) . '" xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use> ';

	// Add some markup to use as a fallback for browsers that do not support SVGs.
	if ( $args['fallback'] ) {
		$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
	}

	$svg .= '</svg>';

	return $svg;
}

/**
 * Display SVG icons in social links menu.
 *
 * @since 1.1
 * 
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function themedd_nav_menu_social_icons( $item_output, $item, $depth, $args ) {

	// Get supported social icons.
	$social_icons = themedd_social_links_icons();

	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social-links' === $args->container_class ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . themedd_get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
			}
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'themedd_nav_menu_social_icons', 10, 4 );

/**
 * Add padding utility classes to the list items.
 *
 * @since 1.1
 */
function themedd_nav_menu_css_class( $classes, $item, $args, $depth ) {

	if ( 'social-links' === $args->container_class ) {
		$classes[] = 'pb-2 pr-2 pb-md-0';
	}

	return $classes;

}
add_filter( 'nav_menu_css_class', 'themedd_nav_menu_css_class', 10, 4 );

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * @since 1.1
 * @return array $social_links_icons
 */
function themedd_social_links_icons() {

	// Supported social links icons.
	$social_links_icons = array(
		'codepen.io'      => 'codepen',
		'dribbble.com'    => 'dribbble',
		'facebook.com'    => 'facebook',
		'flickr.com'       => 'flickr',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'pinterest.com'   => 'pinterest-p',
		'soundcloud.com'  => 'soundcloud',
		'tumblr.com'      => 'tumblr',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'youtube.com'     => 'youtube',
	);

	/**
	 * Filter Themedd social links icons.
	 *
	 * @since 1.1
	 *
	 * @param array $social_links_icons Array of social links icons.
	 */
	return apply_filters( 'themedd_social_links_icons', $social_links_icons );
}