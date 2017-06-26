<?php
/**
 * The Sidebar for the single-download.php containing the main widget area
 *
 * @since 1.0.0
 */
?>
<div id="secondary" class="<?php echo themedd_secondary_classes(); ?>">

	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'themedd_sidebar_download_start' ); ?>

		<?php if ( ! dynamic_sidebar( 'sidebar-download' ) ) : ?>

		<?php
		/**
		 * The price and purchase button
		 */
		?>
		<section class="widget widget_edd_product_details">
		<?php echo themedd_edd_download_info(); ?>
		</section>

		<?php
		/**
		 * Author Details
		 */
		?>
		<?php if ( themedd_is_edd_fes_active() || apply_filters( 'themedd_edd_download_author', false, $post ) ) : ?>

			<section class="widget downloadAuthor">
				<?php
					$user       = new WP_User( $post->post_author );
					$vendor_url = themedd_is_edd_fes_active() ? (new Themedd_EDD_Frontend_Submissions)->author_url( get_the_author_meta( 'ID', $post->post_author ) ) : '';
				?>

				<?php
				/**
				 * Author avatar
				 */
				if ( apply_filters( 'themedd_edd_download_author_avatar', true, $post ) ) : ?>
					<div class="downloadAuthor-avatar">
					<?php if ( $vendor_url ) : ?>
						<a href="<?php echo $vendor_url; ?>"><?php echo get_avatar( $user->ID, themedd_edd_download_author_avatar_size() ); ?></a>
					<?php else : ?>
						<?php echo get_avatar( $user->ID, themedd_edd_download_author_avatar_size() ); ?>
					<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php

				// Only display store name if it exists and is set to show
				$store_name = get_the_author_meta( 'name_of_store', $post->post_author );

				if ( themedd_is_edd_fes_active() && apply_filters( 'themedd_edd_fes_store_name', true, $post ) && ! empty( $store_name ) ) : ?>
					<h2 class="widget-title"><?php echo $store_name; ?></h2>
				<?php endif; ?>

				<ul>
					<?php if ( apply_filters( 'themedd_edd_download_author_name', true, $post ) ) : ?>
						<li class="downloadAuthor-author">

							<span class="downloadAuthor-name"><?php _e( 'Author:', 'themedd' ); ?></span>
							<span class="downloadAuthor-value">
								<?php if ( themedd_is_edd_fes_active() ) : ?>
									<a href="<?php echo $vendor_url; ?>">
										<?php echo $user->display_name; ?>
									</a>
								<?php else : ?>
									<?php echo $user->display_name; ?>
								<?php endif; ?>
							</span>

						</li>
					<?php endif; ?>

					<?php if ( apply_filters( 'themedd_edd_download_author_since', true, $post ) ) : ?>
						<li class="downloadAuthor-authorSince">
							<span class="downloadAuthor-name"><?php _e( 'Author since:', 'themedd' ); ?></span>
							<span class="downloadAuthor-value"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $user->user_registered ) ); ?></span>
						</li>
					<?php endif; ?>

					<?php

					$website = get_the_author_meta( 'user_url', $post->post_author );

					if ( ! empty( $website ) && apply_filters( 'themedd_edd_download_author_website', true, $post ) ) : ?>
					<li class="downloadAuthor-website">
						<span class="downloadAuthor-name"><?php _e( 'Website:', 'themedd' ); ?></span>
						<span class="downloadAuthor-value"><a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener"><?php echo esc_url( $website ); ?></a></span>
					</li>
					<?php endif; ?>

				</ul>
			</section>

		<?php endif; ?>

		<?php
		/**
		 * Download Details
		 */
		?>
		<section class="widget downloadDetails">
			<h2 class="widget-title"><?php echo sprintf( __( '%s Details', 'themedd' ), edd_get_label_plural() ); ?></h2>

			<ul>
				<li class="downloadDetails-published">
					<?php
						$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
						$time_string = sprintf( $time_string,
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() ),
							esc_attr( get_the_modified_date( 'c' ) ),
							esc_html( get_the_modified_date() )
						);
					?>
					<span class="downloadDetails-name"><?php _e( 'Published:', 'themedd' ); ?></span>
					<span class="downloadDetails-value"><?php echo $time_string; ?></span>
				</li>

				<?php
				/**
				 * Sale count.
				 */
				$sale_count = false;
				$sales      = edd_get_download_sales_stats( $post->ID );

				// Whether to display sale count or not.
				if (
					// Display sale count when FES is activated.
					themedd_is_edd_fes_active() ||

					// Display sale count when filter is set to true.
					apply_filters( 'themedd_edd_download_details_sale_count', false, $post ) ||

					// Display sale count when the Download Meta plugin is activated and the display sales checkbox is enabled
					( themedd_is_edd_download_meta_active() && get_post_meta( $post->ID, '_edd_download_meta_sale_count', true ) )
				) {
					$sale_count = true;
				}

				?>

				<?php if ( $sale_count ) : ?>
				<li class="downloadDetails-sales">
					<span class="downloadDetails-name"><?php _e( 'Sales:', 'themedd' ); ?></span>
					<span class="downloadDetails-value"><?php echo $sales; ?></span>
				</li>
				<?php endif; ?>

				<?php
				/**
				 * Version.
				 */
				if ( function_exists( 'edd_download_meta_has_edd_sl_enabled' ) && edd_download_meta_has_edd_sl_enabled() && themedd_is_edd_sl_active() && (new Themedd_EDD_Software_Licensing)->has_licensing_enabled() ) {
					// Get version number from EDD Software Licensing.
					$version = get_post_meta( get_the_ID(), '_edd_sl_version', true );
				} elseif ( themedd_is_edd_download_meta_active() ) {
					// Get version number from EDD Download Meta.
					$version = get_post_meta( get_the_ID(), '_edd_download_meta_version', true );
				} else {
					// No version number.
					$version = '';
				}
				?>

				<?php if ( $version && apply_filters( 'themedd_edd_download_details_version', true, $post ) ) : ?>
				<li class="downloadDetails-version">
					<span class="downloadDetails-name"><?php _e( 'Version:', 'themedd' ); ?></span>
					<span class="downloadDetails-value"><?php echo $version; ?></span>
				</li>
				<?php endif; ?>

				<?php
				/**
				 * Download categories.
				 */
				$categories = get_the_term_list( $post->ID, 'download_category', '', ', ', '' );

				if ( $categories && apply_filters( 'themedd_edd_download_details_categories', true, $post ) ) : ?>
					<li class="downloadDetails-categories">
						<span class="downloadDetails-name"><?php _e( 'Categories:', 'themedd' ); ?></span>
						<span class="downloadDetails-value"><?php echo $categories; ?></span>
					</li>
				<?php endif; ?>

				<?php
				/**
				 * Download tags.
				 */
				$tags = get_the_term_list( $post->ID, 'download_tag', '', ', ', '' );

				if ( $tags && apply_filters( 'themedd_edd_download_details_tags', true, $post ) ) : ?>
					<li class="downloadDetails-tags">
						<span class="downloadDetails-name"><?php _e( 'Tags:', 'themedd' ); ?></span>
						<span class="downloadDetails-value"><?php echo $tags; ?></span>
					</li>
				<?php endif; ?>

			</ul>
		</section>

		<?php endif; // end sidebar widget area ?>

		<?php do_action( 'themedd_sidebar_download_end' ); ?>

	</div>

</div>
