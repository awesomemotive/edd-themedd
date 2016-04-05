<?php
/**
 * Template tags
 */


if ( ! function_exists( 'themedd_comment_nav' ) ) :
/**
* Display navigation to next/previous comments when applicable.
*
* 1.0
*/
function themedd_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'themedd' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'themedd' ) ) ) {
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				}

				if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'themedd' ) ) ) {
					printf( '<div class="nav-next">%s</div>', $next_link );
				}
			?>
		</div>
	</nav>
	<?php
	endif;
}
endif;


 if ( ! function_exists( 'themedd_entry_meta' ) ) :
 /**
  * Prints HTML with meta information for the categories, tags.
  *
  * Create your own themedd_entry_meta() to override in a child theme.
  *
  * @since 1.0
  */
 function themedd_entry_meta() {
 	if ( 'post' == get_post_type() ) {
 		$author_avatar_size = apply_filters( 'themedd_author_avatar_size', 49 );
 		printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
 			get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
 			esc_html_x( 'Author', 'Used before post author name.', 'themedd' ),
 			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
 			esc_html( get_the_author() )
 		);
 	}

 	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
 		themedd_entry_date();
 	}

 	$format = get_post_format();
 	if ( current_theme_supports( 'post-formats', $format ) ) {
 		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
 			sprintf( '<span class="screen-reader-text">%s </span>', esc_html_x( 'Format', 'Used before post format.', 'themedd' ) ),
 			esc_url( get_post_format_link( $format ) ),
 			esc_html( get_post_format_string( $format ) )
 		);
 	}

 	if ( 'post' == get_post_type() ) {
 		themedd_entry_taxonomies();
 	}

 	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
 		echo '<span class="comments-link">';
 		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'themedd' ), get_the_title() ) );
 		echo '</span>';
 	}
 }
 endif;


if ( ! function_exists( 'themedd_entry_date' ) ) :
/**
* Print HTML with date information for current post.
*
* Create your own themedd_entry_date() to override in a child theme.
*
* @since 1.0
*/
function themedd_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		esc_html_x( 'Posted on', 'Used before publish date.', 'themedd' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

if ( ! function_exists( 'themedd_entry_taxonomies' ) ) :
/**
 * Print HTML with category and tags for current post.
 *
 * Create your own themedd_entry_taxonomies() to override in a child theme.
 *
 * @since 1.0
 */
function themedd_entry_taxonomies() {

	$categories_list = get_the_category_list( esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'themedd' ) );
	if ( $categories_list && themedd_categorized_blog() ) {
		printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			esc_html_x( 'Categories', 'Used before category names.', 'themedd' ),
			$categories_list
		);
	}

	$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'themedd' ) );

	if ( $tags_list ) {
		printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			esc_html_x( 'Tags', 'Used before tag names.', 'themedd' ),
			$tags_list
		);
	}

}
endif;


if ( ! function_exists( 'themedd_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own themedd_excerpt() function to override in a child theme.
	 *
	 * @since 1.0
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function themedd_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) : ?>
			<div class="<?php echo $class; ?>">
				<?php the_excerpt(); ?>
			</div><!-- .<?php echo $class; ?> -->
		<?php endif;
	}
endif;


if ( ! function_exists( 'themedd_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a 'Continue reading' link.
 *
 * @since 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function themedd_excerpt_more() {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		sprintf( _x( 'Continue reading %s', 'Name of current post', 'themedd' ), '<span class="screen-reader-text">' . esc_html( get_the_title( get_the_ID() ) ) . '</span>' )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'themedd_excerpt_more' );
endif;

/**
 * Determine whether blog/site has more than one category.
 *
 * @since 1.0
 *
 * @return bool True if there is more than one category, false otherwise.
 */
function themedd_categorized_blog() {

	if ( false === ( $all_the_cool_cats = get_transient( 'themedd_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'themedd_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so themedd_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so themedd_categorized_blog should return false.
		return false;
	}

}

if ( ! function_exists( 'themedd_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since 1.0.0
 */

function themedd_post_thumbnail() {

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}


	if ( ! apply_filters( 'themedd_post_thumbnail', true ) ) {
		return;
	}

	if ( is_singular() ) : ?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div>

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
		?>
	</a>

	<?php endif; // End is_singular()
}
endif;
