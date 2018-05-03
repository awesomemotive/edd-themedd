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

	$classes = apply_filters( 'themedd_footer_widgets_classes', array( 'footer-widgets', 'container', 'columns-' . intval( $widget_columns ) ), $widget_columns );

	if ( $widget_columns > 0 ) : ?>

		<?php do_action( 'themedd_footer_widgets_before' ); ?>

		<?php if ( apply_filters( 'themedd_footer_widgets_show', true ) ) : ?>
		<section class="<?php echo implode( ' ', $classes ); ?>">
			<div class="row">
			<?php do_action( 'themedd_footer_widgets_start' ); ?>

			<?php
			$i = 0;
			while ( $i < $widget_columns ) : $i++;

				if ( is_active_sidebar( 'footer-' . $i ) ) :
					$widget_column_classes = apply_filters( 'themedd_footer_widget_classes', array( themedd_footer_widget_column_classes( $widget_columns ), 'footer-widget', 'widget-column', 'footer-widget-' . intval( $i ) ) );
				?>
				<div class="<?php echo implode( ' ', array_filter( $widget_column_classes ) ); ?>">
					<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
				</div>
				<?php endif;
			endwhile; ?>

			<?php do_action( 'themedd_footer_widgets_end' ); ?>
			</div>
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
function themedd_copyright() {
	echo apply_filters( 'themedd_copyright', '<p>' . sprintf( __( 'Copyright &copy; %s %s', 'themedd' ), date( 'Y' ), get_bloginfo( 'name' ) ) . '</p>' );
}
add_action( 'themedd_site_info', 'themedd_copyright' );

/**
 * Footer widget column classes
 *
 * @since 1.0.0
 * @param int $widget_columns The number of widget columns in use
 *
 * @return string $classes The classes to be added
 */
function themedd_footer_widget_column_classes( $widget_columns ) {

	switch ( $widget_columns ) {

		case 4:
			$classes = 'col-xs-12 col-sm-6 col-lg-3';
			break;

		case 3:
			$classes = 'col-xs-12 col-sm-6 col-lg-4';
			break;

		case 2:
		case 1:
			$classes = 'col-xs-12 col-sm-6';
			break;

	}

	return apply_filters( 'themedd_footer_widget_column_classes', $classes, $widget_columns );

}
