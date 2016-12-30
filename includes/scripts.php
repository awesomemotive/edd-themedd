<?php

if ( ! function_exists( 'themedd_styles' ) ) :
function themedd_styles() {
	// Theme stylesheet.
	wp_enqueue_style( 'themedd', get_stylesheet_uri(), array(), THEMEDD_VERSION );
}
add_action( 'wp_enqueue_scripts', 'themedd_styles' );
endif;

/**
 * Enqueue scripts and styles
 *
 * @since 1.0.0
 */
function themedd_scripts() {

	wp_register_script( 'comment-reply', '', '', '',  true );

	wp_enqueue_script( 'themedd-js', get_template_directory_uri() . '/assets/js/themedd.min.js', array( 'jquery' ), THEMEDD_VERSION, true );

	wp_localize_script( 'themedd-js', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . esc_html__( 'expand child menu', 'themedd' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . esc_html__( 'collapse child menu', 'themedd' ) . '</span>',
	) );

	/**
	 * Comments
	 */

	// We don't need the script on pages where there is no comment form and not on the homepage if it's a page. Neither do we need the script if comments are closed or not allowed. In other words, we only need it if "Enable threaded comments" is activated and a comment form is displayed.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'themedd_scripts' );

/**
 * Lightboxes
 */
function themedd_load_popup() {

	if ( themedd_enable_popup() ) :
	?>
	<script type="text/javascript">

		jQuery(document).ready(function($) {

		//inline
		$('.popup-content').magnificPopup({
			type: 'inline',
			fixedContentPos: true,
			fixedBgPos: true,
			overflowY: 'scroll',
			closeBtnInside: true,
			preloader: false,
			callbacks: {
				beforeOpen: function() {
				this.st.mainClass = this.st.el.attr('data-effect');
				}
			},
			midClick: true,
			removalDelay: 300
        });

		});
	</script>

<?php endif;
}
add_action( 'wp_footer', 'themedd_load_popup', 100 );
