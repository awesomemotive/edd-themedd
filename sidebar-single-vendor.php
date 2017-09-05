<?php
/**
 * The Sidebar for the vendor page
 *
 * @since 1.0.0
 */
$vendor_id = absint( fes_get_vendor()->ID );
?>
<div id="secondary" class="<?php echo themedd_secondary_classes(); ?>">

	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">

		<?php do_action( 'themedd_edd_fes_sidebar_single_vendor_start' ); ?>

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
			?>
			<div class="downloadAuthor-avatar">
				<?php echo get_avatar( $vendor_id, 80 ); ?>
			</div>

			<?php
			/**
			 * Vendor's name.
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
				<p><a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener"><?php _e( 'Visit website', 'themedd' ); ?></a></p>
			</div>
			<?php endif; ?>

			<?php
			/**
			 * Vendor's contact form.
			 */
			if ( themedd_edd_fes_vendor_contact_form() ) : ?>

				<?php echo (new FES_Forms)->render_vendor_contact_form( $vendor_id ); ?>

			<?php endif; ?>

		</section>

		<?php do_action( 'themedd_edd_fes_sidebar_single_vendor_end' ); ?>

	</div>

</div>
