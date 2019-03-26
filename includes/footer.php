<?php

/**
 * Display the footer.
 *
 * @since 1.1
 */
function themedd_footer() {
	?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php do_action( 'themedd_footer' ); ?>
	</footer>
	<?php
}
add_action( 'themedd_content_after', 'themedd_footer' );

/**
 * Display the footer widgets
 *
 * @since 1.0.0
 */
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

	$classes = apply_filters( 'themedd_footer_widgets_classes', array( 'footer-widgets', 'py-5', 'columns-' . intval( $widget_columns ) ), $widget_columns );

	if ( $widget_columns > 0 ) : ?>

		<?php do_action( 'themedd_footer_widgets_before' ); ?>

		<?php if ( apply_filters( 'themedd_footer_widgets_show', true ) ) : ?>

		<section class="<?php echo implode( ' ', $classes ); ?>">
			<div class="container">
				<?php do_action( 'themedd_footer_widgets_start' ); ?>

				<?php
				$i = 0;
				while ( $i < $widget_columns ) : $i++;

					if ( is_active_sidebar( 'footer-' . $i ) ) :
						$widget_column_classes = apply_filters( 'themedd_footer_widget_classes', array( 'footer-widget', 'widget-column', 'footer-widget-' . intval( $i ) ) );
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
add_action( 'themedd_footer', 'themedd_footer_widgets' );

/**
 * Themedd footer bottom.
 *
 * @since 1.1
 */
function themedd_footer_bottom() {

	$container_classes = array( 'py-4' );

	if ( has_nav_menu( 'social' ) && ! themedd_edd_is_distraction_free_checkout() ) {
		$container_classes[] = 'd-md-flex justify-content-md-between align-items-center container';
		$copyright_classes[] = 'order-md-1';
	}
	?>
	<section class="footer-bottom">
		<div<?php themedd_classes( array( 'classes' => $container_classes ) ); ?>>
			<?php
			/**
			 * Display the social links.
			 *
			 * @since 1.1
			 */
			if ( has_nav_menu( 'social' ) && ! themedd_edd_is_distraction_free_checkout() ) {
				echo themedd_social_links_menu( array( 'theme_location' => 'social', 'classes' => array( 'order-md-2 mb-3 mb-md-0' ) ) );
			}

			/**
			 * Copyright notice.
			 */
			echo themedd_copyright();
			?>
		</div>
	</section>
	<?php
}
add_action( 'themedd_footer', 'themedd_footer_bottom' );

/**
 * Copyright notice.
 *
 * @since 1.0.0
 */
function themedd_copyright() {

	$classes = array( 'site-info' );

	if ( has_nav_menu( 'social' ) && ! themedd_edd_is_distraction_free_checkout() ) {
		$classes[] = 'order-md-1';
	} else {
		// Center the copyright when there is no social menu.
		$classes[] = 'text-center';
	}

	return apply_filters( 'themedd_copyright', '<div class="' . themedd_classes( array( 'classes' => $classes, 'echo' => false ) ) . '"><p class="mb-0">' . sprintf( __( '&copy; %s %s', 'themedd' ), date( 'Y' ), get_bloginfo( 'name' ) ) . '</p></div>', $classes );
}

/**
 * Social Links Menu.
 *
 * @since 1.1
 */
function themedd_social_links_menu( $args = array() ) {

	$defaults = apply_filters( 'themedd_social_links_menu_defaults',
		array(
			'menu'           => '',
			'theme_location' => '',
			'classes'        => array(),
			'icons'          => true,
			'text_before'    => ''
		)
	);

	$args = wp_parse_args( $args, $defaults );

	if ( ! empty( $args['text_before'] ) ) {
		$args['classes'][] = 'd-flex flex-column flex-md-row align-items-md-center has-text-before';
	}

	if ( $args['icons'] ) {
		$args['classes'][] = 'has-icons';
	}

	$args['classes'][] = 'social-navigation';
	?>
	<nav<?php themedd_classes( array( 'classes' => $args['classes'] ) ); ?> aria-label="<?php esc_attr_e( 'Social Links Menu', 'themedd' ); ?>">
		<?php if ( ! empty( $args['text_before'] ) ) : ?>
		<span class="mr-md-2 mb-2 mb-md-0"><?php echo $args['text_before']; ?></span>
		<?php endif; ?>

		<?php
			wp_nav_menu(
				array(
					'menu'            => $args['menu'],
					'theme_location'  => $args['theme_location'],
					'menu_class'      => 'social-links-menu p-0 m-0',
					'container_class' => 'social-links',
					'depth'           => 1,
					'link_before'     => $args['icons'] ? '<span class="screen-reader-text">' : '',
					'link_after'      => $args['icons'] ? '</span>' . themedd_get_svg( array( 'icon' => 'link' ) ) : '',
				)
			);
		?>
	</nav>
	<?php
}

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
			$classes = 'col-12 col-sm-6 col-lg-3';
			break;

		case 3:
			$classes = 'col-12 col-sm-6 col-lg-4';
			break;

		case 2:
		case 1:
			$classes = 'col-12 col-sm-6';
			break;

	}

	return apply_filters( 'themedd_footer_widget_column_classes', $classes, $widget_columns );

}