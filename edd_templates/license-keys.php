<?php
/**
 *
 * Changes made
 * 1. The "Manage Sites" link has been modified so it redirects to the same page
 * 1. The "View Upgrades" Link has been modified so it redirects to the same page
 */

$color = edd_get_option( 'checkout_color', 'gray' );
$color = ( $color == 'inherit' ) ? '' : $color;

if ( is_user_logged_in() ) :
	$license_keys = edd_software_licensing()->get_license_keys_of_user();
	?>
	<?php do_action( 'edd_sl_license_keys_before' ); ?>
	<table id="edd_sl_license_keys" class="edd_sl_table">
		<thead>
			<tr class="edd_sl_license_row">
				<?php do_action('edd_sl_license_keys_header_before'); ?>
				<th class="edd_sl_item"><?php _e( 'Item', 'edd_sl' ); ?></th>
				<th class="edd_sl_details"><?php _e( 'License Details', 'edd_sl' ); ?></th>
				<?php do_action('edd_sl_license_keys_header_after'); ?>
			</tr>
		</thead>
		<?php if ( $license_keys ) : ?>
			<?php foreach ( $license_keys as $license ) : ?>
				<?php $payment_id = edd_software_licensing()->get_payment_id( $license->ID ); ?>
				<tr class="edd_sl_license_row">
					<?php do_action( 'edd_sl_license_keys_row_start', $license->ID ); ?>
					<td>
						<div class="edd_sl_item_name">
							<?php echo edd_software_licensing()->get_download_name( $license->ID ); ?>
							<?php if( $price_id = edd_software_licensing()->get_price_id( $license->ID ) ) : ?>
								<span class="edd_sl_key_sep">&nbsp;&ndash;&nbsp;</span>
								<span class="edd_sl_key_price_option"><?php echo edd_get_price_option_name( edd_software_licensing()->get_download_id( $license->ID ), $price_id ); ?></span>
							<?php endif; ?>
						</div>
						<input type="text" readonly="readonly" class="edd_sl_license_key" value="<?php echo esc_attr( edd_software_licensing()->get_license_key( $license->ID ) ); ?>" />
					</td>
					<td>
						<span class="edd_sl_status_label"><?php _e( 'Status:', 'edd_sl' ); ?>&nbsp;</span>
						<span class="edd_sl_license_status edd-sl-<?php echo edd_software_licensing()->get_license_status( $license->ID ); ?>">
							<?php echo edd_software_licensing()->get_license_status( $license->ID ); ?>
						</span>
						<div class="edd_sl_item_expiration">
							<span class="edd_sl_expires_label edd_sl_expiries_label"><?php 'expired' === edd_software_licensing()->get_license_status( $license->ID ) ? _e( 'Expired:', 'edd_sl' ) : _e( 'Expires:', 'edd_sl' ); ?>&nbsp;</span>
							<?php if( edd_software_licensing()->is_lifetime_license( $license->ID ) ) : ?>
								<?php _e( 'Never', 'edd_sl' ); ?>
							<?php else: ?>
								<?php echo date_i18n( 'F j, Y', edd_software_licensing()->get_license_expiration( $license->ID ) ); ?>
							<?php endif; ?>
						</div>
						<span class="edd_sl_limit_label"><?php _e( 'Activations:', 'edd_sl' ); ?>&nbsp;</span>
						<span class="edd_sl_limit_used"><?php echo edd_software_licensing()->get_site_count( $license->ID ); ?></span>
						<span class="edd_sl_limit_sep">&nbsp;/&nbsp;</span>
						<span class="edd_sl_limit_max"><?php echo edd_software_licensing()->license_limit( $license->ID ); ?></span>
						<?php if( ! edd_software_licensing()->force_increase() ) : ?>
							<br/><a href="<?php echo esc_url( add_query_arg( array( 'license_id' => $license->ID, 'action' => 'manage_licenses', 'payment_id' => $payment_id ) ) ); ?>"><?php _e( 'Manage Sites', 'edd_sl' ); ?></a>
						<?php endif; ?>
						<?php if( edd_sl_license_has_upgrades( $license->ID ) && 'expired' !== edd_software_licensing()->get_license_status( $license->ID ) ) : ?>
							<span class="edd_sl_limit_sep">&nbsp;&ndash;&nbsp;</span>
							<a href="<?php echo esc_url( add_query_arg( array( 'view' => 'upgrades', 'license_id' => $license->ID, 'action' => 'manage_licenses', 'payment_id' => $payment_id ) ) ); ?>"><?php _e( 'View Upgrades', 'edd_sl' ); ?></a>
						<?php elseif ( edd_sl_license_has_upgrades( $license->ID ) && 'expired' == edd_software_licensing()->get_license_status( $license->ID ) ) : ?>
							<span class="edd_sl_limit_sep">&nbsp;&ndash;&nbsp;</span>
							<span class="edd_sl_no_upgrades"><?php _e( 'Renew to upgrade', 'edd_sl' ); ?></span>
						<?php endif; ?>
						<?php if( edd_sl_renewals_allowed() ) : ?>
							<?php if( 'expired' === edd_software_licensing()->get_license_status( $license->ID ) ) : ?>
								<span class="edd_sl_key_sep">&nbsp;&ndash;&nbsp;</span>
								<a href="<?php echo edd_software_licensing()->get_renewal_url( $license->ID ); ?>" title="<?php esc_attr_e( 'Renew license', 'edd_sl' ); ?>"><?php _e( 'Renew license', 'edd_sl' ); ?></a>
							<?php elseif( ! edd_software_licensing()->is_lifetime_license( $license->ID ) && edd_software_licensing()->can_extend( $license->ID ) ) : ?>
								<span class="edd_sl_key_sep">&nbsp;&ndash;&nbsp;</span>
								<a href="<?php echo edd_software_licensing()->get_renewal_url( $license->ID ); ?>" title="<?php esc_attr_e( 'Extend license', 'edd_sl' ); ?>"><?php _e( 'Extend license', 'edd_sl' ); ?></a>
							<?php endif; ?>
						<?php endif; ?>
						<br/>
						<a class="edd_sl_purchase_number" href="<?php echo esc_url( edd_get_success_page_uri( '?payment_key=' . edd_get_payment_key( $payment_id ) ) ); ?>" title="<?php esc_attr_e( 'View Purchase Record', 'edd_sl' ); ?>"><?php printf( __( 'Purchase #%d', 'edd_sl' ), edd_get_payment_number( $payment_id ) ); ?></a>
						<?php do_action( 'edd_sl_license_key_details', $license->ID ); ?>
					</td>
					<?php do_action( 'edd_sl_license_keys_row_end', $license->ID ); ?>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr class="edd_sl_license_row">
				<td colspan="2"><?php _e( 'You currently have no licenses', 'edd_sl' ); ?></td>
			</tr>
		<?php endif; ?>
	</table>
	<?php do_action( 'edd_sl_license_keys_after' ); ?>
<?php else : ?>
	<p class="edd-alert edd-alert-warn">
		<?php _e( 'You must be logged in to view license keys.', 'edd_sl' ); ?>
	</p>
	<?php echo edd_login_form(); ?>
<?php endif; ?>
