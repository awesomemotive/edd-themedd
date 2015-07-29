<?php if ( '0' == edd_get_download_price( get_the_ID() ) ) : 
// Free download
?>
	<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<div itemprop="price" class="edd_price">
			Free
		</div>
	</div>

<?php elseif ( edd_has_variable_prices( get_the_ID() ) ) : 
// Variable priced download
?>

	<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<div itemprop="price" class="edd_price">
			From <?php edd_price( get_the_ID() ); ?>
		</div>
	</div>

<?php elseif ( ! edd_has_variable_prices( get_the_ID() ) ) : 
// normal priced download
?>
	<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<div itemprop="price" class="edd_price">
			<?php edd_price( get_the_ID() ); ?>
		</div>
	</div>
<?php endif; ?>

