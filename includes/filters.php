<?php
/**
 * Add custom body classes.
 *
 * @since 1.0.0
 */
function themedd_body_classes( $classes ) {

	if ( true === themedd_has_sidebar() ) {
		$classes[] = 'has-sidebar';
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

	$link = sprintf( '<p class="link-more mb-0"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		sprintf( __( 'Continue reading<span class="sr-only"> "%s"</span>', 'themedd' ), get_the_title( get_the_ID() ) )
	);

	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'themedd_excerpt_more' );
endif;

/**
 * Modify the comment form defaults
 *
 * @since 1.1
 */
function themedd_comment_form_defaults( $defaults ) {

	// Add the .form-control class to the comment field.
	$defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label> <textarea id="comment" class="form-control form-control-lg" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>';

	// Adjust height of comment form.
	$comment_field = $defaults['comment_field'];
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	// Add additional class names to the submit button.
	$defaults['class_submit'] .= ' btn btn-primary btn-lg';

	// Remove <small> and </small>.
	$defaults['cancel_reply_before'] = null;
	$defaults['cancel_reply_after'] = null;

	// Add various classes to the reply title.
	$defaults['title_reply_before'] = '<h3 id="reply-title" class="comment-reply-title h4 my-5 d-flex justify-content-between">';

	// Remove bottom margin from submit <p> tag
	$defaults['submit_field'] = '<p class="form-submit mb-0">%1$s %2$s</p>';

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

/**
 * Filter the navigation markup template.
 *
 * @since 1.1
 */
function themedd_navigation_markup_template( $template, $class ) {

	$css_classes = array( 'nav-links d-flex justify-content-between' );

	switch ( $class ) {
		case 'comment-navigation':
			$css_classes[] = 'py-4';
			break;

		default:
			$css_classes[] = '';
			break;
	}

	ob_start();
	?>

	<nav class="navigation %1$s" role="navigation">
		<h2 class="screen-reader-text">%2$s</h2>
		<div<?php themedd_classes( array( 'classes' => $css_classes ) ); ?>>%3$s</div>
	</nav>

<?php

	return ob_get_clean();
}
add_filter( 'navigation_markup_template', 'themedd_navigation_markup_template', 10, 2 );

/**
 * Filter the edit comment link.
 *
 * @since 1.1
 */
function themedd_edit_comment_link( $link, $comment_id, $text ) {
	$comment = get_comment();
	$link = '<a class="comment-edit-link small" href="' . esc_url( get_edit_comment_link( $comment ) ) . '">' . $text . '</a>';

	return $link;
}
add_filter( 'edit_comment_link', 'themedd_edit_comment_link', 10, 3 );

/**
 * Filter the HTML content for cancel comment reply link.
 *
 * @since 1.1
 */
function themedd_cancel_comment_reply_link( $formatted_link, $link, $text ) {
	$style = isset( $_GET['replytocom'] ) ? '' : ' style="display:none;"';

	$formatted_link = '<a rel="nofollow" class="mb-0 align-self-end" id="cancel-comment-reply-link" href="' . $link . '"' . $style . '>' . $text . '</a>';

	return $formatted_link;
}
add_filter( 'cancel_comment_reply_link', 'themedd_cancel_comment_reply_link', 10, 3 );
