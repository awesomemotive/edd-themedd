<?php

/**
 * EDD - Coming Soon
 *
 * @since 1.0.2
 */
class Themedd_EDD_Coming_Soon {

	/**
	 * Get things started.
	 *
	 * @access  public
	 * @since   1.0.2
	*/
	public function __construct() {
		
		// Removing the "Coming Soon" notice at the end of the single download.
		remove_filter( 'the_content', array( EDD_Coming_Soon(), 'single_download' ) );

		// Add "Coming Soon" (or custom status text) to the download sidebar
	}

}
new Themedd_EDD_Coming_Soon;
