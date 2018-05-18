<?php
/**
 * Subtitles compatibility
 *
 * https://wordpress.org/plugins/subtitles/
 */
class Themedd_Subtitles {

	/**
	 * Get things started.
	 *
	 * @access public
	 * @since  1.0.0
	 */
	public function __construct() {

		/**
		 * Remove inline styling from subtitles plugin
		 *
		 * @since 1.0.0
		 */
		if ( class_exists( 'Subtitles' ) && method_exists( 'Subtitles', 'subtitle_styling' ) ) {
			remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
		}

		add_action( 'init', array( $this, 'add_subtitles_support' ) );
		add_filter( 'subtitle_markup', array( $this, 'markup' ) );
		add_filter( 'subtitle_view_supported', array( $this, 'supported_views' ) );
	}

	/**
	 * Turn off subtitles
	 * Subtitles are only allowed in the themedd_header() function
	 */
	public function supported_views() {
		return false;
	}

	/**
	 * Add subtitles support for the "download" custom post type
	 */
	public function add_subtitles_support() {
		add_post_type_support( 'download', 'subtitles' );
	}

	/**
	 * Filter subtitle markup
	 *
	 * @since 1.0.0
	 */
	public function markup( $markup ) {
	    $markup['before'] = '<span class="subtitle">';

	    return $markup;
	}

}
new Themedd_Subtitles;
