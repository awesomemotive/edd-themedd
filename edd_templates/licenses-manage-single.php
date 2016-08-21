<?php
/**
 * Changes made:
 *
 *
 */

$payment_id  = absint( $_GET['payment_id' ] );
$license_id  = absint( $_GET['license_id' ] );
$download_id = absint( edd_software_licensing()->get_download_id( $license_id ) );
$download    = new EDD_Download( $download_id );
$user_id     = edd_get_payment_user_id( $payment_id );

if( ! current_user_can( 'edit_shop_payments' ) && $user_id != get_current_user_id() ) {
	return;
}

$color = edd_get_option( 'checkout_color', 'gray' );
$color = ( $color == 'inherit' ) ? '' : $color;

// Retrieve all sites for the specified license
$sites = edd_software_licensing()->get_sites( $license_id );
?>

<?php if ( is_page('account') ) : ?>
<p><a href="<?php echo site_url( 'account' ); ?>" class="edd-manage-license-back edd-submit button"><?php _e( 'Go back', 'edd_sl' ); ?></a></p>
<?php else : ?>
<p><a href="<?php echo esc_url( remove_query_arg( array( 'license_id', 'edd_sl_error', '_wpnonce' ) ) ); ?>" class="edd-manage-license-back edd-submit button <?php echo esc_attr( $color ); ?>"><?php _e( 'Go back', 'edd_sl' ); ?></a></p>
<?php endif; ?>



<?php edd_sl_show_errors(); ?>
<h5 class="edd-sl-manage-license-header"><?php _e( 'Manage License', 'edd_sl' ); ?></h5>
<p class="edd-sl-manage-license-details">
	<span class="edd-sl-manage-license-key"><?php _e( 'License', 'edd_sl' ); ?>: <?php echo '<code>' . edd_software_licensing()->get_license_key( $license_id ) . '</code>'; ?></span>
	<span class="edd-sl-manage-license-product"><?php _e( 'Product', 'edd_sl' ); ?>: <span><?php echo $download->get_name(); ?></span></span>
</p>
<table id="edd_sl_license_sites" class="edd_sl_table">
	<thead>
		<tr class="edd_sl_license_row">
			<?php do_action('edd_sl_license_sites_header_before'); ?>
			<th class="edd_sl_url"><?php _e( 'Site URL', 'edd_sl' ); ?></th>
			<th class="edd_sl_actions"><?php _e( 'Actions', 'edd_sl' ); ?></th>
			<?php do_action('edd_sl_license_sites_header_after'); ?>
		</tr>
	</thead>
	<?php if ( $sites ) : ?>
		<?php foreach ( $sites as $site ) : ?>
			<tr class="edd_sl_license_row">
				<?php do_action( 'edd_sl_license_sites_row_start', $license_id ); ?>
				<td><?php echo $site; ?></td>
				<td><a href="<?php echo wp_nonce_url( add_query_arg( array( 'edd_action' => 'deactivate_site', 'site_url' => $site, 'license' => $license_id ) ), 'edd_deactivate_site_nonce', '_wpnonce' ); ?>"><?php _e( 'Deactivate Site', 'edd_sl' ); ?></a></td>
				<?php do_action( 'edd_sl_license_sites_row_end', $license_id ); ?>
			</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr class="edd_sl_license_row">
			<?php do_action( 'edd_sl_license_sites_row_start', $license_id ); ?>
			<td colspan="2"><?php _e( 'No sites have been activated for this license', 'edd_sl' ); ?></td>
			<?php do_action( 'edd_sl_license_sites_row_end', $license_id ); ?>
		</tr>
	<?php endif; ?>
</table>

<?php $status   = edd_software_licensing()->get_license_status( $license_id ); ?>
<?php $at_limit = edd_software_licensing()->is_at_limit( $license_id, $download_id ); ?>

<?php if ( ! $at_limit && ( $status == 'active' || $status == 'inactive' ) ) : ?>
<form method="post" id="edd_sl_license_add_site_form" class="edd_sl_form">
	<div>
		<span><?php _e( 'Use this form to authorize a new site URL for this license. Enter the full site URL.', 'edd_sl' ); ?></span>
		<input type="text" name="site_url" class="edd-input" value="http://"/>
		<input type="submit" class="button-primary button" value="<?php _e( 'Add Site', 'edd_sl' ); ?>"/>
		<input type="hidden" name="license_id" value="<?php echo esc_attr( $license_id ); ?>"/>
		<input type="hidden" name="edd_action" value="insert_site"/>
		<?php wp_nonce_field( 'edd_add_site_nonce', 'edd_add_site_nonce', true ); ?>
	</div>
</form>
<?php endif; ?>
