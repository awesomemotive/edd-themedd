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

		<?php do_action( 'themedd_sidebar_download_product_details_after' ); ?>

		<?php
		/**
		 * Author Details
		 */
		?>
		<?php if ( themedd_is_edd_fes_active() && apply_filters( 'themedd_edd_download_author', true, $post ) || apply_filters( 'themedd_edd_download_author', false, $post ) ) : ?>

			<section class="widget downloadAuthor">

				<?php
				/**
				 * Author avatar
				 */
				$user       = new WP_User( $post->post_author );
				$vendor_url = themedd_is_edd_fes_active() ? (new Themedd_EDD_Frontend_Submissions)->author_url( get_the_author_meta( 'ID', $post->post_author ) ) : '';

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
				/**
				 * Author's store name.
				 */
				if ( apply_filters( 'themedd_edd_download_author_store_name', true, $post ) ) :
					$store_name = get_the_author_meta( 'name_of_store', $post->post_author );
				?>

					<?php if ( themedd_is_edd_fes_active() && ! empty( $store_name ) ) : ?>
					<h2 class="widget-title"><?php echo $store_name; ?></h2>
					<?php endif; ?>
				<?php endif; ?>

				<ul>
				<?php
				/**
				 * Author name.
				 */
				 if ( apply_filters( 'themedd_edd_download_author_name', true, $post ) ) : ?>
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

				<?php
				/**
				 * Author signup date.
				 */
				if ( apply_filters( 'themedd_edd_download_author_signup_date', true, $post ) ) : ?>
					<li class="downloadAuthor-authorSignupDate">
						<span class="downloadAuthor-name"><?php _e( 'Author since:', 'themedd' ); ?></span>
						<span class="downloadAuthor-value"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $user->user_registered ) ); ?></span>
					</li>
				<?php endif; ?>

				<?php
				/**
				 * Author website.
				 */
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

		<?php do_action( 'themedd_sidebar_download_author_after' ); ?>

		<?php
		/**
		 * Download Details
		 */
		?>
		<section class="widget downloadDetails">
			<h2 class="widget-title"><?php echo sprintf( __( '%s Details', 'themedd' ), edd_get_label_singular() ); ?></h2>

			<ul>

				<?php if ( apply_filters( 'themedd_edd_download_details_date_published', true, $post ) ) : ?>
				<li class="downloadDetails-datePublished">
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
				<?php endif; ?>

				<?php
				/**
				 * Sale count.
				 */
				if (
					themedd_is_edd_fes_active() && apply_filters( 'themedd_edd_download_details_sale_count', true, $post ) ||
					apply_filters( 'themedd_edd_download_details_sale_count', false, $post )
				) :
					$sales = edd_get_download_sales_stats( $post->ID );
					?>
				<li class="downloadDetails-sales">
					<span class="downloadDetails-name"><?php _e( 'Sales:', 'themedd' ); ?></span>
					<span class="downloadDetails-value"><?php echo $sales; ?></span>
				</li>
				<?php endif; ?>

				<?php
				/**
				 * Version.
				 */
				if (
					themedd_is_edd_sl_active() && apply_filters( 'themedd_edd_download_details_version', true, $post ) ||
					themedd_is_edd_sl_active() && apply_filters( 'themedd_edd_download_details_version', false, $post )
				) :

					if ( themedd_is_edd_sl_active() && (new Themedd_EDD_Software_Licensing)->has_licensing_enabled() ) {
						// Get version number from EDD Software Licensing.
						$version = get_post_meta( get_the_ID(), '_edd_sl_version', true );
					} else {
						// No version number.
						$version = '';
					}

					if ( $version ) : ?>
					<li class="downloadDetails-version">
						<span class="downloadDetails-name"><?php _e( 'Version:', 'themedd' ); ?></span>
						<span class="downloadDetails-value"><?php echo $version; ?></span>
					</li>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				/**
				 * Download categories.
				 */
				$categories = get_the_term_list( $post->ID, 'download_category', '', ', ', '' );

				if ( $categories && apply_filters( 'themedd_edd_download_details_categories', true, $post )	) : ?>
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
