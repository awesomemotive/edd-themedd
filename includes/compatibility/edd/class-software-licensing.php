<?php

/**
 * EDD - Software Licensing
 *
 * @since 1.0.0
 */
class Themedd_EDD_Software_Licensing {

	/**
	 * Get things started.
	 *
	 * @access  public
	 * @since   1.0.0
	*/
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Check to see if the download has licensing enabled.
	 */
	public function has_licensing_enabled() {

		$enabled = get_post_meta( get_the_ID(), '_edd_sl_enabled', true ) ? true : false;

		return $enabled;

	}

	/**
	 * Dequeue the CSS from the Software Licensing extension.
	 * All CSS styling for this extension is handled by Themedd.
	 *
	 * @since 1.0.0
	 */
	public function scripts() {
		// Remove software licensing CSS file.
		wp_dequeue_style( 'edd-sl-styles' );
	}

}
new Themedd_EDD_Software_Licensing();
