<?php

/**
 * EDD - Download Meta
 *
 * @since 1.0.0
 */
class Themedd_EDD_Download_Meta {

	/**
	 * Get things started.
	 *
	 * @access  public
	 * @since   1.0.0
	*/
	public function __construct() {

		/**
		 * Remove download meta styling
		 */
		remove_action( 'wp_head', 'edd_download_meta_styles' );

	}


}
new Themedd_EDD_Download_Meta;
