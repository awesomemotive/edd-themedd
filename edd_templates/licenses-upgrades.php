<?php
/**
 * Changes made
 * Modified "go back" link
 * Added "Upgrades" heading
 */

$payment_id  = absint( $_GET['payment_id' ] );
$license_id  = absint( $_GET['license_id' ] );
$download_id = absint( edd_software_licensing()->get_download_id( $license_id ) );
$upgrades    = edd_sl_get_license_upgrades( $license_id );
$user_id     = edd_software_licensing()->get_user_id( $license_id );

if( ! current_user_can( 'edit_shop_payments' ) && $user_id != get_current_user_id() ) {
	return;
}

$color = edd_get_option( 'checkout_color', 'gray' );
$color = ( $color == 'inherit' ) ? '' : $color;

?>

<?php if ( is_page('account') ) : ?>
<p><a href="<?php echo site_url( 'account'); ?>" class="edd-manage-license-back edd-submit button"><?php _e( 'Go back', 'edd_sl' ); ?></a></p>
<?php else : ?>
<p><a href="<?php echo esc_url( remove_query_arg( array( 'view', 'license_id', 'edd_sl_error', '_wpnonce' ) ) ); ?>" class="edd-manage-license-back edd-submit button <?php echo esc_attr( $color ); ?>"><?php _e( 'Go back', 'edd_sl' ); ?></a></p>
<?php endif; ?>



<h5>Upgrades</h5>

<?php edd_sl_show_errors(); ?>
<table id="edd_sl_license_upgrades" class="edd_sl_table">
	<thead>
		<tr class="edd_sl_license_row">
			<?php do_action('edd_sl_license_upgrades_header_before'); ?>
			<th class="edd_sl_url"><?php echo edd_get_label_singular(); ?></th>
			<th class="edd_sl_actions"><?php _e( 'Upgrade Cost', 'edd_sl' ); ?></th>
			<th class="edd_sl_actions"><?php _e( 'Actions', 'edd_sl' ); ?></th>
			<?php do_action('edd_sl_license_upgrades_header_after'); ?>
		</tr>
	</thead>
	<?php if ( $upgrades ) : ?>
		<?php foreach ( $upgrades as $upgrade_id => $upgrade ) : ?>
			<tr class="edd_sl_license_row">
				<?php do_action( 'edd_sl_license_upgrades_row_start', $license_id ); ?>
				<td>
					<?php echo get_the_title( $upgrade['download_id'] ); ?>
					<?php if( isset( $upgrade['price_id'] ) && edd_has_variable_prices( $upgrade['download_id'] ) ) : ?>
						- <?php echo edd_get_price_option_name( $upgrade['download_id'], $upgrade['price_id'] ); ?>
					<?php endif; ?>
				</td>
				<td><?php echo edd_currency_filter( edd_sanitize_amount( edd_sl_get_license_upgrade_cost( $license_id, $upgrade_id ) ) ); ?></td>
				<td><a href="<?php echo esc_url( edd_sl_get_license_upgrade_url( $license_id, $upgrade_id ) ); ?>" title="<?php esc_attr_e( 'Upgrade License', 'edd_sl' ); ?>"><?php _e( 'Upgrade License', 'edd_sl' ); ?></a></td>
				<?php do_action( 'edd_sl_license_upgrades_row_end', $license_id ); ?>
			</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr class="edd_sl_license_row">
			<?php do_action( 'edd_sl_license_upgrades_row_start', $license_id ); ?>
			<td colspan="3"><?php _e( 'No upgrades available for this license', 'edd_sl' ); ?></td>
			<?php do_action( 'edd_sl_license_upgrades_row_end', $license_id ); ?>
		</tr>
	<?php endif; ?>
</table>
