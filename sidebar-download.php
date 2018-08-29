<?php
/**
 * The Sidebar for the single-download.php containing the main widget area
 *
 * @since 1.0.0
 */

// Get the author options.
$author_options = themedd_edd_download_author_options();

// Get the download options.
$download_options = themedd_edd_download_details_options();

?>
<div id="secondary" class="<?php echo themedd_secondary_classes(); ?>">

	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'themedd_edd_sidebar_download_start' ); ?>

		<?php if ( ! dynamic_sidebar( 'sidebar-download' ) ) : ?>

		<section class="widget widget_edd_product_details">
			<?php
			/**
			 * The price and purchase button are loaded onto this hook.
			 * This hook is also added to EDD's Download Details widget.
			 */
			do_action( 'themedd_edd_download_info', $post->ID ); ?>
		</section>

		<?php do_action( 'themedd_edd_sidebar_download_product_details_after' ); ?>

		<?php
		/**
		 * Show the Author Details
		 */
		if ( themedd_edd_show_download_author() ) : ?>

		<section class="widget download-author">

			<?php
			/**
			 * Author avatar
			 */
			$user       = new WP_User( $post->post_author );
			$vendor_url = themedd_is_edd_fes_active() ? (new Themedd_EDD_Frontend_Submissions)->author_url( get_the_author_meta( 'ID', $post->post_author ) ) : '';

			if ( true === $author_options['avatar'] ) : ?>

				<div class="download-author-avatar">
				<?php if ( $vendor_url ) : ?>
					<a href="<?php echo $vendor_url; ?>"><?php echo get_avatar( $user->ID, $author_options['avatar_size'], '', get_the_author_meta( 'display_name' ) ); ?></a>
				<?php else : ?>
					<?php echo get_avatar( $user->ID, $author_options['avatar_size'], '', get_the_author_meta( 'display_name' ) ); ?>
				<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php
			/**
			 * Author's store name.
			 */
			if ( true === $author_options['store_name'] ) :
				$store_name = get_the_author_meta( 'name_of_store', $post->post_author );
			?>

				<?php if ( themedd_is_edd_fes_active() && ! empty( $store_name ) ) : ?>
				<h2 class="widget-title"><?php echo $store_name; ?></h2>
				<?php endif; ?>

			<?php endif; ?>

			<ul>

			<?php do_action( 'themedd_edd_sidebar_download_author_list_start', $author_options ); ?>

			<?php
			/**
			 * Author name.
			 */
			if ( true === $author_options['name'] ) : ?>

				<li class="download-author-author">
					<span class="download-author-name"><?php _e( 'Author:', 'themedd' ); ?></span>
					<span class="download-author-value">
						<?php if ( themedd_is_edd_fes_active() ) : ?>
							<a class="vendor-url" href="<?php echo $vendor_url; ?>">
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
			if ( true === $author_options['signup_date'] ) : ?>

				<li class="download-author-author-signup-date">
					<span class="download-author-name"><?php _e( 'Author since:', 'themedd' ); ?></span>
					<span class="download-author-value"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $user->user_registered ) ); ?></span>
				</li>
			<?php endif; ?>

			<?php
			/**
			 * Author website.
			 */
			$website = get_the_author_meta( 'user_url', $post->post_author );

			if ( ! empty( $website ) && true === $author_options['website'] ) : ?>

			<li class="download-author-website">
				<span class="download-author-name"><?php _e( 'Website:', 'themedd' ); ?></span>
				<span class="download-author-value"><a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener"><?php echo esc_url( $website ); ?></a></span>
			</li>
			<?php endif; ?>

			<?php do_action( 'themedd_edd_sidebar_download_author_list_end', $author_options ); ?>

			</ul>

		</section>

		<?php endif; ?>

		<?php do_action( 'themedd_edd_sidebar_download_author_after' ); ?>

		<?php
		/**
		 * Show the Download Details
		 */
		if ( themedd_edd_show_download_details() ) : ?>

		<section class="widget download-details">

			<?php
			/**
			 * Widget title.
			 */
			if ( ! empty( $download_options['title'] ) ) : ?>
			<h2 class="widget-title"><?php echo $download_options['title']; ?></h2>
			<?php endif; ?>

			<ul>

				<?php do_action( 'themedd_edd_sidebar_download_details_list_start', $download_options ); ?>

				<?php
				/**
				 * Date published.
				 */
				if ( true === $download_options['date_published'] ) : ?>
				<li class="download-details-date-published">
					<span class="download-details-name"><?php _e( 'Published:', 'themedd' ); ?></span>
					<span class="download-details-value"><?php echo themedd_edd_download_date_published(); ?></span>
				</li>
				<?php endif; ?>

				<?php
				/**
				 * Sale count.
				 */
				if ( true === $download_options['sale_count'] ) :
					$sales = edd_get_download_sales_stats( $post->ID );
				?>
				<li class="download-details-sales">
					<span class="download-details-name"><?php _e( 'Sales:', 'themedd' ); ?></span>
					<span class="download-details-value"><?php echo $sales; ?></span>
				</li>
				<?php endif; ?>

				<?php
				/**
				 * Version.
				 */
				if ( true === $download_options['version'] ) :

					$version = themedd_edd_download_version( $post->ID );

					if ( $version ) : ?>
					<li class="download-details-version">
						<span class="download-details-name"><?php _e( 'Version:', 'themedd' ); ?></span>
						<span class="download-details-value"><?php echo $version; ?></span>
					</li>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				/**
				 * Download categories.
				 */
				if ( true === $download_options['categories'] ) :

					$categories = themedd_edd_download_categories( $post->ID );

					if ( $categories ) : ?>
					<li class="download-details-categories">
						<span class="download-details-name"><?php _e( 'Categories:', 'themedd' ); ?></span>
						<span class="download-details-value"><?php echo $categories; ?></span>
					</li>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				/**
				 * Download tags.
				 */
				if ( true === $download_options['tags'] ) :

					$tags = themedd_edd_download_tags( $post->ID );

					if ( $tags ) : ?>
					<li class="download-details-tags">
						<span class="download-details-name"><?php _e( 'Tags:', 'themedd' ); ?></span>
						<span class="download-details-value"><?php echo $tags; ?></span>
					</li>
					<?php endif; ?>
				<?php endif; ?>

				<?php do_action( 'themedd_edd_sidebar_download_details_list_end', $download_options ); ?>

			</ul>
		</section>
		<?php endif; ?>

		<?php endif; // end sidebar widget area ?>

		<?php do_action( 'themedd_edd_sidebar_download_end' ); ?>

	</div>

</div>
