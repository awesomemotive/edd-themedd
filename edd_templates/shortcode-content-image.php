<?php 
$options = themedd_edd_download_grid_options();

if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail( get_the_ID() ) ) : ?>
	<div class="edd_download_image mb-3">
		<a href="<?php the_permalink(); ?>" class="d-block">
			<?php echo get_the_post_thumbnail( get_the_ID(), $options['size'], array( 'class' => 'card-img-top' ) ); ?>
		</a>
	</div>
<?php endif; ?>
