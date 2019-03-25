<?php
/**
 * Template tags
 */


/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function themedd_posted_on( $show_author = true ) {
	ob_start();
	?>
	<div<?php themedd_classes( array( 'classes' => array( 'entry-meta' ), 'context' => 'entry_meta' ) ); ?>>
		<span class="posted-on"><?php echo themedd_time_link(); ?></span>
		<?php if ( $show_author ) : ?>
		<span class="byline"><?php _e( 'by', 'themedd' ); ?> <?php themedd_posted_by(); ?></span>
		<?php endif; ?>
	</div>

	<?php
	return ob_get_clean();
}

if ( ! function_exists( 'themedd_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about the post's author.
	 */
	function themedd_posted_by() {

		// Allows us to retrieve the author's name outside of the loop.
		$post_author_id   = get_post_field( 'post_author', get_the_ID() );
		$post_author_name = get_the_author_meta( 'display_name', $post_author_id );
		$post_author_url  = get_author_posts_url( get_the_author_meta( 'ID', $post_author_id ) );

		printf(
			/* translators: 1: post author, only visible to screen readers. 2: author link. */
			'<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( $post_author_url ),
			esc_html( $post_author_name )
		);
	}
endif;

if ( ! function_exists( 'themedd_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function themedd_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return sprintf(
		/* translators: %s: post date */
		__( '<span class="sr-only">Posted on</span> %s', 'themedd' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
}
endif;

if ( ! function_exists( 'themedd_comment_form' ) ) :

	function themedd_comment_form( $order ) {
		if ( true === $order || strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) ) {

			comment_form(
				array(
					'logged_in_as' => null,
				)
			);
		}
	}
endif;

/**
* Display navigation to next/previous comments when applicable.
*
* @since 1.0.0
*/
if ( ! function_exists( 'themedd_comment_nav' ) ) :
	function themedd_comment_nav() {

		$prev_icon     = themedd_get_svg( array( 'icon' => 'chevron-left', 'size' => 24 ) );
		$next_icon     = themedd_get_svg( array( 'icon' => 'chevron-right', 'size' => 24 ) );
		$comments_text = __( 'Comments', 'themedd' );

		the_comments_navigation(
			array(
				'prev_text' => sprintf( '%s <span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', $prev_icon, __( 'Previous', 'themedd' ), __( 'Comments', 'themedd' ) ),
				'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span> %s', __( 'Next', 'themedd' ), __( 'Comments', 'themedd' ), $next_icon ),
			)
		);
	}
	endif;

if ( ! function_exists( 'themedd_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function themedd_entry_footer() {

	/* translators: used between list items, there is a space after the comma */
	$separate_meta = __( ', ', 'themedd' );

	// Get Categories for posts.
	$categories_list = get_the_category_list( $separate_meta );

	// Get Tags for posts.
	$tags_list = get_the_tag_list( '', $separate_meta );

	// We don't want to output .entry-footer if it will be empty, so make sure its not.
	if ( ( ( $categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<footer class="entry-footer content-wrapper py-4 small">';

			if ( 'post' === get_post_type() ) {
				if ( ( $categories_list ) || $tags_list ) {
					echo '<div class="cat-tags-links">';

						// Make sure there's more than one category before displaying.
						if ( $categories_list ) {
							echo '<div class="cat-links">' . __( 'Categories: ', 'themedd' ) . $categories_list . '</div>';
						}

						if ( $tags_list ) {
							echo '<div class="tags-links">' . __( 'Tags: ', 'themedd' ) . $tags_list . '</div>';
						}

					echo '</div>';
				}
			}

			themedd_edit_link();

		echo '</footer>';
	}
}
endif;

if ( ! function_exists( 'themedd_edit_link' ) ) :
/**
 * Returns an accessibility-friendly link to edit a post or page.
 *
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 */
function themedd_edit_link() {

	$link = edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit<span class="sr-only"> "%s"</span>', 'themedd' ),
			get_the_title()
		),
		'<span class="edit-link mt-4 d-block">',
		'</span>'
	);

	return $link;
}
endif;

/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since 1.0.0
 */

function themedd_post_thumbnail( $args = array() ) {

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	/**
	 * Allow developers to remove the post thumbnail.
	 */
	if ( ! apply_filters( 'themedd_post_thumbnail', true ) ) {
		return;
	}

	$defaults = apply_filters( 'themedd_post_thumbnail_defaults',
		array(
			'classes' => array(),
			'size'    => 'themedd-featured-image',
		)
	);

	$args = wp_parse_args( $args, $defaults );

	// Classes.
	$classes = $args['classes'];
	$classes[] = 'post-thumbnail mb-9';

	if ( ! is_singular() ) {
		$classes[] = 'd-block';
	}

	// Create the post thumbnail.
	$post_thumbnail = get_the_post_thumbnail( get_the_ID(), $args['size'] );

	if ( is_singular() ) : ?>

	<div<?php themedd_classes( array( 'classes' => $classes ) ); ?>>
		<?php echo $post_thumbnail; ?>
	</div>

	<?php else : ?>

	<a<?php themedd_classes( array( 'classes' => $classes ) ); ?>" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php echo $post_thumbnail; ?>
	</a>

	<?php endif;
}

/**
 * Output a class attribute with its values, given an array, or strings
 *
 * @since 1.1
 */
function themedd_classes( $args = array() ) {

	$classes = isset( $args['classes'] ) ? $args['classes'] : array();
	$context = ! empty( $args['context'] ) ? $args['context'] : '';
	$echo    = isset( $args['echo'] ) && false === $args['echo'] ? false : true;

	// Allow the classes to be filtered.
	$classes = apply_filters( 'themedd_classes', $classes, $context );

	if ( empty( $classes ) ) {
		return false;
	}

	// If working with an array, implode it into a string classes.
	if ( is_array( $classes ) ) {
		$classes = implode( ' ', array_filter( array_unique( $classes ) ) );
	}

	if ( false === $echo ) {

		// Returns a string of classes, separated by a space.
		return $classes;

	} else {

		// Echo the class attribute with the included class names.
		echo ' class="' . $classes . '"';

	}

}

/**
 * Display the post header
 *
 * @since 1.0.0
 */
function themedd_header( $args = array() ) {

	/**
	 * Allow header to be removed via filter.
	 */
	if ( ! apply_filters( 'themedd_header', true ) ) {
		return;
	}

	// Set up defaults.
	$defaults = array(
		'subtitle'        => ! empty( $args['subtitle'] ) ? $args['subtitle'] : '',
		'title'           => ! empty( $args['title'] ) ? $args['title'] : get_the_title(),
		'posted_on'       => false,
		'show_author'     => true,
		'permalink'       => ! empty( $args['permalink'] ) ? $args['permalink'] : '',
		'heading_size'    => ! empty( $args['heading_size'] ) ? $args['heading_size'] : 'h1',
		'header_classes'  => array(),
		'heading_classes' => array(),
	);
	$args = wp_parse_args( $args, $defaults );
	$args = apply_filters( 'themedd_header_args', $args );

	// Title.
	$title = $args['title'];

	$header_classes  = $args['header_classes'];
	$heading_classes = $args['heading_classes'];

	// Convert any strings into an array.
	if ( is_string( $header_classes ) ) {
		$header_classes = explode( ' ', $header_classes );
		$header_classes = array_filter( array_unique( $header_classes ) );
	}

	if ( is_string( $heading_classes ) ) {
		$heading_classes = explode( ' ', $heading_classes );
		$heading_classes = array_filter( array_unique( $heading_classes ) );
	}

	// Subtitle.
	$subtitle = $args['subtitle'];

	// Override subtitle if one exists from the subtitle plugin.
	if ( function_exists( 'get_the_subtitle' ) && get_the_subtitle() ) {
		$subtitle = get_the_subtitle();
	}

	// Permalink.
	$permalink = $args['permalink'];

	// Heading size.
	$heading_size = $args['heading_size'];
	?>
	<header<?php themedd_classes( array( 'classes' => $header_classes, 'context' => 'header_header' ) ); ?>>
		<?php do_action( 'themedd_header_start', $args ); ?>
		<div class="container">
			<?php do_action( 'themedd_header_container_start', $args ); ?>
				<<?php echo $heading_size; ?> <?php themedd_classes( array( 'classes' => $heading_classes, 'context' => 'header_heading' ) ); ?>>
				<?php
					if ( $permalink ) {
						echo '<a href="' . $permalink . '">' . $title . '</a>';
					} else {
						echo $title;
					}
				?>
				</<?php echo $heading_size; ?>>
				<?php if ( $subtitle ) : ?>
				<span class="lead"><?php echo $subtitle; ?></span>
				<?php endif; ?>
			<?php do_action( 'themedd_header_container_end', $args ); ?>
		</div>
		<?php do_action( 'themedd_header_end', $args ); ?>
	</header>
	<?php do_action( 'themedd_header_after', $args ); ?>
<?php
}

if ( ! function_exists( 'themedd_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since 1.0.0
 */
function themedd_paging_nav() {

	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$defaults = apply_filters( 'themedd_paging_nav',
		array(
			'next_posts_link'     => __( 'Older posts', 'themedd' ),
			'previous_posts_link' => __( 'Newer posts', 'themedd' ),
		)
	);
	?>
	<nav class="container navigation paging-navigation" role="navigation">

		<h1 class="sr-only"><?php _e( 'Posts navigation', 'themedd' ); ?></h1>

		<div class="nav-links d-flex justify-content-between">
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( $defaults['next_posts_link'] ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next ml-auto"><?php previous_posts_link( $defaults['previous_posts_link'] ); ?></div>
			<?php endif; ?>

		</div>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'themedd_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since 1.0.0
 */
function themedd_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;
