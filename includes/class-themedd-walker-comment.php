<?php
/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 *
 * @since 1.1
 */
class Themedd_Walker_Comment extends Walker_Comment {

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 * @global int $comment_depth
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 * @param int    $depth  Optional. Depth of the current comment. Default 0.
	 * @param array  $args   Optional. Uses 'style' argument for type of HTML list. Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$GLOBALS['comment_depth'] = $depth + 1;

		switch ( $args['style'] ) {
			case 'div':
				break;
			case 'ol':
				$output .= '<ol class="children pl-5 pl-md-10">' . "\n";
				break;
			case 'ul':
			default:
				$output .= '<ul class="children pl-5 pl-md-10">' . "\n";
				break;
		}
	}

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
		$has_avatars = get_option( 'show_avatars' );

		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>

			<div class="d-flex mt-10 align-items-start<?php if ( $has_avatars ) { echo ' has-avatars'; } ?>">

				<?php
					$comment_author_link = get_comment_author_link( $comment );
					$comment_author_url  = get_comment_author_url( $comment );

					$post_author_badge_classes = array( 'post-author-badge' );
					$post_author_badge_classes[] = ! $has_avatars ? 'ml-2' : '';

					// Post author badge.
					$post_author_badge = themedd_is_comment_by_post_author( $comment ) ?
					sprintf( '<span class="' . themedd_classes( array( 'classes' => $post_author_badge_classes, 'echo' => false ) ) . '" aria-hidden="true">%s</span>', themedd_get_svg( array( 'icon' => 'checked', 'size' => 16 ) ) ) : '';

					// Avatar classes.
					$avatar_classes = 'rounded-circle';

					// Avatar with post author badge (if applicable).
					$avatar = get_avatar( $comment, $args['avatar_size'], '', get_the_author_meta( 'display_name' ), array( 'class' => $avatar_classes ) ) . $post_author_badge;
				?>

				<div class="comment-author-avatar">
				<?php
					if ( 0 != $args['avatar_size'] && $has_avatars ) {
						if ( empty( $comment_author_url ) ) {
							echo $avatar;
						} else {
							printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url );
							echo $avatar;
							echo '</a>';
						}

					}
				?>
				</div>

				<div class="comment-wrap">
					<article id="div-comment-<?php comment_ID(); ?>" class="comment-body mb-3">
						<footer class="comment-meta mb-3">
							<div class="comment-author vcard">
								<?php
								$show_post_author_badge = ! $has_avatars ? $post_author_badge : '';

								printf(
									/* translators: %s: comment author link */
									wp_kses(
										__( '%s <span class="sr-only says">says:</span>', 'themedd' ),
										array(
											'span' => array(
												'class' => array(),
											),
										)
									),
									'<span class="fn h5 d-flex mb-0">' . $comment_author_link . $show_post_author_badge . '</span>'
								);

								?>
							</div>

							<div class="comment-metadata">
								<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
									<?php
										/* translators: 1: comment date, 2: comment time */
										$comment_timestamp = sprintf( __( '%1$s at %2$s', 'themedd' ), get_comment_date( '', $comment ), get_comment_time() );
									?>
									<time class="small" datetime="<?php comment_time( 'c' ); ?>" title="<?php echo $comment_timestamp; ?>">
										<?php echo $comment_timestamp; ?>
									</time>
								</a>
								<?php edit_comment_link( __( 'Edit', 'themedd' ), '<span class="edit-link-sep small">&mdash;</span> ' ); ?>
							</div>

							<?php if ( '0' == $comment->comment_approved ) : ?>
							<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'themedd' ); ?></p>
							<?php endif; ?>
						</footer>

						<div class="comment-content">
						<?php comment_text(); ?>
						</div>

					</article>

					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '<div class="comment-reply">',
								'after'     => '</div>',
							)
						)
					);
					?>
				</div>
			</div>
		<?php
	}
}
