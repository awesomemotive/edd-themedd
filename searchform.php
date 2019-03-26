<?php
/**
 * Template for displaying search forms in Themedd
 */
$search_text = apply_filters( 'themedd_search_text', esc_attr_x( 'Search', 'placeholder', 'themedd' ) );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="search" aria-label="Search" class="search-field form-control" placeholder="<?php echo $search_text; ?>" value="<?php echo get_search_query(); ?>" name="s" />

		<?php if ( apply_filters( 'themedd_show_search_button', true ) ) : ?>
		<div class="input-group-append">
			<button type="submit" class="search-submit btn btn-search"><span class="sr-only"><?php echo _x( 'Search', 'submit button', 'themedd' ); ?></span><?php echo Themedd_Search::search_icon(); ?></button>
		</div>
		<?php endif; ?>
	</div>
</form>