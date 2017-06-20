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
		add_action( 'themedd_page_header_before', array( $this, 'page_header_before' ) );
		add_action( 'themedd_page_header_end', array( $this, 'page_header_end' ) );
		add_filter( 'subtitle_markup', array( $this, 'markup' ) );
		add_filter( 'subtitle_view_supported', array( $this, 'supported_views' ) );
	}

	/**
	 * Turn off subtitles
	 * Subtitles are only allowed in the themedd_page_header() function
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
	 * Enable support for subtitles within themedd's page header
	 * Subtitles don't usually appear because the title is rendered outside of the loop
	 *
	 * @since 1.0.0
	 */
	public function page_header_before( ) {
	   add_filter( 'subtitle_view_supported', '__return_true' );
	}

	/**
	 * Remove support for subtitles after the header has been rendered
	 * This is so the subtitles don't leak out and affect things like sharing icons etc
	 *
	 * @since 1.0.0
	 */
	public function page_header_end( ) {
		add_filter( 'subtitle_view_supported', '__return_false' );
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
