<?php
/**
 * The template part for displaying an Author biography
 */
?>

<div class="author-info">

	<div class="author-avatar">
		<?php
		/**
		 * Filter the Themedd author bio avatar size.
		 *
		 * @since Themedd 1.0
		 *
		 * @param int $size The avatar height and width size in pixels.
		 */
		$author_bio_avatar_size = apply_filters( 'themedd_author_bio_avatar_size', 80 );

		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size, '', get_the_author_meta( 'display_name' ) );
		?>
	</div>

	<div class="author-description">

		<p class="author-bio">
			<strong><?php _e( 'About the author:', 'themedd' ); ?></strong>
			<?php the_author_meta( 'description' ); ?>
		</p>

		<?php do_action( 'themedd_author_description_end' ); ?>

	</div>
</div>
