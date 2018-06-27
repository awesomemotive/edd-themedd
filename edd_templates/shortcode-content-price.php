<?php
/**
 * Free download.
 */
if ( edd_is_free_download( get_the_ID() ) ) :
?>
	<div>
		<div><span class="edd_price" id="edd_price_<?php echo get_the_id(); ?>"><?php _e( 'Free', 'themedd' ); ?></span></div>
	</div>
<?php
/**
 * Variable priced download
 */
elseif ( edd_has_variable_prices( get_the_ID() ) ) :
?>
	<div>
		<div>
		<?php
			/* translators: Variable price start */
			esc_html_e( 'From', 'themedd' );
		?>
		<?php edd_price( get_the_ID() ); ?></a></div>
	</div>
<?php
/**
 * Normal priced download.
 */
elseif ( ! edd_has_variable_prices( get_the_ID() ) ) :
?>
	<div>
		<div><?php edd_price( get_the_ID() ); ?></div>
	</div>
<?php endif; ?>
