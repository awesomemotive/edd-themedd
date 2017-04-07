<?php

/**
 * Display the footer widgets
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_footer_widgets' ) ) :
function themedd_footer_widgets() {

	if ( is_active_sidebar( 'footer-4' ) ) {
		$widget_columns = apply_filters( 'themedd_footer_widget_regions', 4 );
	} elseif ( is_active_sidebar( 'footer-3' ) ) {
		$widget_columns = apply_filters( 'themedd_footer_widget_regions', 3 );
	} elseif ( is_active_sidebar( 'footer-2' ) ) {
		$widget_columns = apply_filters( 'themedd_footer_widget_regions', 2 );
	} elseif ( is_active_sidebar( 'footer-1' ) ) {
		$widget_columns = apply_filters( 'themedd_footer_widget_regions', 1 );
	} else {
		$widget_columns = apply_filters( 'themedd_footer_widget_regions', 0 );
	}

	$columns = apply_filters( 'themedd_footer_widgets_classes', array( 'footer-widgets', 'wrapper' ) );

	if ( apply_filters( 'themedd_footer_widgets_columns_class', true ) ) {
		$columns[] = 'columns-' . intval( $widget_columns );
	}

	if ( $widget_columns > 0 ) : ?>

		<?php do_action( 'themedd_footer_widgets_before' ); ?>

		<?php if ( apply_filters( 'themedd_footer_widgets_show', true ) ) : ?>
		<section class="<?php echo implode( ' ', $columns ); ?>">
			<?php do_action( 'themedd_footer_widgets_start' ); ?>
			<?php
			$i = 0;
			while ( $i < $widget_columns ) : $i++;
				if ( is_active_sidebar( 'footer-' . $i ) ) : ?>

					<div class="widget-column footer-widget-<?php echo intval( $i ); ?>">
						<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
					</div>

				<?php endif;
			endwhile; ?>

			<?php do_action( 'themedd_footer_widgets_end' ); ?>
		</section>
		<?php endif; ?>

		<?php do_action( 'themedd_footer_widgets_after' ); ?>

	<?php endif;

}
endif;
add_action( 'themedd_footer', 'themedd_footer_widgets' );

/**
 * Display the site info
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_site_info' ) ) :
function themedd_site_info() {
	?>
	<section class="site-info wrapper">
			<?php do_action( 'themedd_site_info' ); ?>
	</section>
	<?php
}
endif;
add_action( 'themedd_footer', 'themedd_site_info' );

/**
 * Copyright
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'themedd_copyright' ) ) :
function themedd_copyright() {
	echo apply_filters( 'themedd_copyright', '<p>' . sprintf( __( 'Copyright &copy; %s %s', 'themedd' ), date( 'Y' ), get_bloginfo( 'name' ) ) . '</p>' );
}
endif;
add_action( 'themedd_site_info', 'themedd_copyright' );
