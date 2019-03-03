<?php
global $post;
$suggestion_data = edd_rp_get_suggestions( $post->ID );
$count = (int) edd_get_option( 'edd_rp_suggestion_count', 3 );

if ( is_array( $suggestion_data ) && !empty( $suggestion_data ) ) :
	$suggestions = array_keys( $suggestion_data );

	$suggested_downloads = new WP_Query( array( 'post__in' => $suggestions, 'post_type' => 'download' ) );

	if ( $suggested_downloads->have_posts() ) : ?>
		<div id="edd-rp-single-wrapper">
			<h5 id="edd-rp-single-header"><?php echo sprintf( __( 'Users who purchased %s, also purchased:', 'themedd' ), get_the_title() ); ?></h5>
			<div id="edd-rp-items-wrapper" class="mb-xs-2 edd_downloads_list edd_download_columns_<?php echo $count; ?> edd-rp-single">
				<?php while ( $suggested_downloads->have_posts() ) : ?>
					<?php $suggested_downloads->the_post();	?>
					<div class="edd_download edd-rp-item <?php echo ( !current_theme_supports( 'post-thumbnails' ) ) ? 'edd-rp-nothumb' : ''; ?>">
						<div class="edd_download_inner">

							<?php do_action( 'edd_rp_item_before' ); ?>

							<?php if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( get_the_ID() ) ) :?>
								<div class="edd-download-image">
									<a href="<?php the_permalink(); ?>">
									<?php echo get_the_post_thumbnail( get_the_ID() ); ?>
									</a>
								</div>
							<?php endif; ?>

							<?php do_action( 'edd_rp_item_after_thumbnail' ); ?>

							<h3 class="edd_download_title">
								<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
							</h3>

							<?php if ( ! edd_has_variable_prices( get_the_ID() ) ) : ?>
								<?php edd_price( get_the_ID() ); ?>
							<?php endif; ?>

							<?php do_action( 'edd_rp_item_after_price' ); ?>

							<div class="edd_download_buy_button">
								<?php
								$purchase_link_args = array(
									'download_id' => get_the_ID(),
									'price' => false,
									'direct' => false,
								);
								$purchase_link_args = apply_filters( 'edd_rp_purchase_link_args', $purchase_link_args );
								echo edd_get_purchase_link( $purchase_link_args );
								?>
							</div>

							<?php do_action( 'edd_rp_item_after' ); ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

<?php endif; ?>
