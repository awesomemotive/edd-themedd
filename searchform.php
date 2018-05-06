<?php
/**
 * Template for displaying search forms in Themedd
 */
$unique_id   = esc_attr( uniqid( 'search-form-' ) );
$search_text = apply_filters( 'themedd_search_text', esc_attr_x( 'Search', 'placeholder', 'themedd' ) );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group mb-3">
		<label for="<?php echo $unique_id; ?>"><span class="sr-only"><?php echo _x( 'Search for:', 'label', 'themedd' ); ?></span></label>	
		<input type="search" id="<?php echo $unique_id; ?>" class="search-field form-control" placeholder="<?php echo $search_text; ?>" value="<?php echo get_search_query(); ?>" name="s" />

		<?php if ( apply_filters( 'themedd_show_search_button', true ) ) : ?>
		<div class="input-group-append">
			<button type="submit" class="search-submit btn btn-primary"><span class="sr-only"><?php echo _x( 'Search', 'submit button', 'themedd' ); ?></span><?php echo Themedd_Search::search_icon(); ?></button>
		</div>
		<?php endif; ?>
	</div>
</form>