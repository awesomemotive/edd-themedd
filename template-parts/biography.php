<?php
/**
 * The template part for displaying an Author biography
 */

$has_avatars           = get_option( 'show_avatars' );
$author_info_classes   = array( 'author-info', 'py-3', 'my-5' );
$author_info_classes[] = $has_avatars ? 'd-md-flex' : '';
?>
<div class="content-wrapper">
	<div class="<?php echo themedd_output_classes( $author_info_classes ); ?>">
		<?php if ( $has_avatars ) : ?>
		<div class="author-avatar mb-3 mb-md-0 mr-md-4">
			<?php
			/**
			 * Filter the Themedd author bio avatar size.
			 *
			 * @since Themedd 1.0
			 *
			 * @param int $size The avatar height and width size in pixels.
			 */
			$author_bio_avatar_size = apply_filters( 'themedd_author_bio_avatar_size', 80 );

			echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size, '', get_the_author_meta( 'display_name' ), array( 'class' => 'rounded-circle' ) );
			?>
		</div>
		<?php endif; ?>
		
		<div class="author-description">
			<h4 class="author-title h5">
				<span class="author-heading">
					<?php
					printf(
						/* translators: %s: post author */
						__( 'About %s', 'themedd' ),
						esc_html( get_the_author() )
					);
					?>
				</span>
			</h4>
			<p class="author-bio mb-0">
				<?php the_author_meta( 'description' ); ?>
			</p>
			<?php do_action( 'themedd_author_description_end' ); ?>
		</div>
	</div>
</div>
