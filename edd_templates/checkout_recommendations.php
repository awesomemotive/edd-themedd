<?php

$cart_items = edd_get_cart_contents();
$count      = (int) edd_get_option( 'edd_rp_suggestion_count', 3 );

?>

<?php if ( $cart_items ) :
	$post_ids = wp_list_pluck( $cart_items, 'id' );
	$user_id = ( is_user_logged_in() ) ? get_current_user_id() : false;
	$suggestion_data = edd_rp_get_multi_suggestions( $post_ids, $user_id );

	if ( is_array( $suggestion_data ) && !empty( $suggestion_data ) ) :
	$suggestions = array_keys( $suggestion_data );

	$suggested_downloads = new WP_Query( array( 'post__in' => $suggestions, 'post_type' => 'download' ) );

	if ( $suggested_downloads->have_posts() ) :

		$single = __( 'this item', 'edd-rp-txt' );
		$plural = __( 'these items', 'edd-rp-txt' );
		$cart_items_text = _n( $single, $plural, count( $post_ids ), 'edd-rp-txt' );
		?>
		<div id="edd-rp-checkout-wrapper">
			<h5 id="edd-rp-checkout-header"><?php echo sprintf( __( 'Users who purchased %s, also purchased:', 'edd-rp-txt' ), $cart_items_text ); ?></h5>
			<div id="edd-rp-items-wrapper" class="mb-xs-2 edd-rp-checkout edd_downloads_list edd_download_columns_<?php echo $count; ?>">
				<?php while ( $suggested_downloads->have_posts() ) : ?>
					<?php $suggested_downloads->the_post();	?>
					<div class="edd_download edd-rp-item <?php echo ( ! current_theme_supports( 'post-thumbnails' ) ) ? 'edd-rp-nothumb' : ''; ?>">
						<div class="edd_download_inner">

							<?php do_action( 'edd_rp_item_before' ); ?>

							<?php if ( current_theme_supports( 'post-thumbnails' ) && has_post_thumbnail( get_the_ID() ) ) :?>
								<div class="edd_download_image">
									<a href="<?php the_permalink(); ?>">
									<?php echo get_the_post_thumbnail( get_the_ID() ); ?>
									</a>
								</div>
							<?php endif; ?>

							<?php do_action( 'edd_rp_item_after_thumbnail' ); ?>

							<h3 class="edd_download_title">
								<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
							</h3>

							<?php do_action( 'edd_rp_item_after_title' ); ?>

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
						</div>
						<?php do_action( 'edd_rp_item_after' ); ?>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

	<?php endif; ?>

<?php endif; ?>
