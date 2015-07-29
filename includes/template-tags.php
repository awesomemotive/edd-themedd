<?php
/**
 * Template tags
 */

if ( ! function_exists( 'trustedd_post_thumbnail' ) ) :
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since 1.0.0
 */

function trustedd_post_thumbnail() {

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

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



function trustedd_post_thumbnail_old( $size = 'thumbnail', $link = false ) {

	if ( post_password_required() || ! has_post_thumbnail() ) {
		return;
	}

	if ( $link ) : ?>

	<a title="<?php the_title_attribute(); ?>" class="post-thumbnail" href="<?php the_permalink(); ?>">
		<?php the_post_thumbnail( $size ); ?>
	</a>


	<?php else : ?>
		<?php the_post_thumbnail( $size ); ?>

	<?php endif;
}
