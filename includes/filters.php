<?php
/**
 * Add custom body classes.
 *
 * @since 1.0.0
 */
function themedd_body_classes( $classes ) {

	if ( ! themedd_has_sidebar() ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;

}
add_filter( 'body_class', 'themedd_body_classes' );

/**
 * Add custom body classes, based on customizer options
 *
 * @since 1.0.0
 */
function themedd_customizer_body_classes( $classes ) {

	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	if ( themedd_layout_full_width() ) {
		$classes[] = 'layout-full-width';
	}

	return $classes;
}
add_filter( 'body_class', 'themedd_customizer_body_classes' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @since 1.0.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
if ( ! function_exists( 'themedd_excerpt_more' ) ) :
function themedd_excerpt_more( $link ) {

	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		sprintf( __( 'Continue reading<span class="sr-only"> "%s"</span>', 'themedd' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'themedd_excerpt_more' );
endif;

/**
 * Add a spacing utility class to top-level anchor links
 * 
 * @since 1.1
 */
function themedd_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

	if ( ! isset( $atts['class'] ) ) {
		return $atts;
	}

	// Only apply class to top-level menu links
	if ( 'dropdown-item' !== $atts['class'] ) {
		$atts['class'] .= ' px-lg-3';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'themedd_nav_menu_link_attributes', 10, 4 );

/**
 * Modify the comment form defaults
 * 
 * @since 1.1
 */
function themedd_comment_form_defaults( $defaults ) {
	
	// Add the .form-control class to the comment field.
	$defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label> <textarea id="comment" class="form-control form-control-lg" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>';

	// Add additional class names to the submit button.
	$defaults['class_submit'] .= ' btn btn-primary btn-lg';

	return $defaults;

}
add_filter( 'comment_form_defaults', 'themedd_comment_form_defaults' );

/**
 * Modify the comment form defaults fields
 * 
 * @since 1.1
 */
function themedd_comment_form_default_fields( $fields ) {

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$html_req  = ( $req ? " required='required'" : '' );

	// Add the .form-control class to the input fields.
	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input class="form-control form-control-lg" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $html_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            '<input class="form-control form-control-lg" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req  . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
		            '<input class="form-control form-control-lg" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
	);

	return $fields;

}
add_filter( 'comment_form_default_fields', 'themedd_comment_form_default_fields' );
