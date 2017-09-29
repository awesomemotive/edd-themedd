<?php
/**
 * Template for displaying search forms in Themedd
 */

$unique_id   = esc_attr( uniqid( 'search-form-' ) );
$search_text = apply_filters( 'themedd_search_text', esc_attr_x( 'Search', 'placeholder', 'themedd' ) );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; ?>">
		<span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'themedd' ); ?></span>
		<input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php echo $search_text; ?>" value="<?php echo get_search_query(); ?>" name="s" />
	</label>
	
	<?php if ( apply_filters( 'themedd_search_button', true ) ) : ?>
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'themedd' ); ?></span><?php echo themedd_search_icon(); ?></button>
	<?php endif; ?>
</form>