<?php
/**
 * The Sidebar for the vendor page
 *
 * @since 1.0.0
 */
$vendor_id = absint( fes_get_vendor()->ID );
$vendor_options = themedd_edd_author_details_options();
?>
<div id="secondary" class="<?php echo themedd_secondary_classes(); ?>">

	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php
		/**
		 * The vendor profile and contact form (if enabled)
		 */
		?>
		<section class="widget downloadAuthor">

			<?php
			/**
			 * Vendor's avatar.
			 */
			if ( apply_filters( 'themedd_edd_download_author_avatar', true, $post ) ) : ?>
				<div class="downloadAuthor-avatar">
					<?php echo get_avatar( $vendor_id, $vendor_options['avatar_size'] ); ?>
				</div>
			<?php endif; ?>

			<?php
			/**
			 * Vendor name
			 */
			$user_info    = get_userdata( $vendor_id );
			$display_name = $user_info->display_name;
			?>
			<h2 class="widget-title"><?php echo $display_name; ?></h2>

			<?php
			/**
			 * Vendor's description.
			 */
			$description = get_the_author_meta( 'description', $vendor_id );
			if ( $description ) : ?>
			<div class="downloadAuthor-description">
				<p><?php echo $description; ?></p>
			</div>
			<?php endif; ?>

			<?php
			/**
			 * Vendor's website.
			 */
			$website = get_the_author_meta( 'user_url', $vendor_id );
			if ( $website ) : ?>
			<div class="downloadAuthor-website">
				<p><a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener">Visit website</a></p>
			</div>
			<?php endif; ?>

			<?php
			/**
			 * Vendor contact form.
			 */
			if ( themedd_edd_fes_vendor_contact_form() ) : ?>

				<?php echo (new FES_Forms)->render_vendor_contact_form( $vendor_id ); ?>

			<?php endif; ?>

		</section>



	</div>

</div>
