<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="content-wrapper comments-area py-5">
	<?php if ( have_comments() ) : ?>

		<h2 class="comments-title">
			<?php
				printf( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title', 'themedd' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
			?>
		</h2>

		<?php
		// Show comment form at top if showing newest comments at the top.
		if ( comments_open() ) {
			themedd_comment_form( 'desc' );
		}
		?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'walker'      => new Themedd_Walker_Comment(),
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
				) );
			?>
		</ol>

		<?php themedd_comment_nav(); ?>

		<?php
		// Show comment form at bottom if showing newest comments at the bottom.
		if ( comments_open() && 'asc' === strtolower( get_option( 'comment_order', 'asc' ) ) ) :
			themedd_comment_form( 'asc' );
		endif;

		if ( ! comments_open() ) : ?>
			<p class="no-comments">
				<?php esc_html_e( 'Comments are closed.', 'themedd' ); ?>
			</p>
		<?php endif;

	else :

		// Show comment form when there are no comments
		themedd_comment_form( true );

	endif; // if have_comments(); ?>
</div>
