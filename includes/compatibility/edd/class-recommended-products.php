<?php

/**
 * EDD - Recommended Products
 *
 * @since 1.0.0
 */
class Themedd_EDD_Recommended_Products {

	/**
	 * Get things started.
	 *
	 * @access  public
	 * @since   1.0.0
	*/
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
	}

	/**
	 * Enqueue custom styling.
	 *
	 * @access  public
	 * @since   1.0.0
	 */
	public function styles() {

		// Dequeue styles.
	    wp_dequeue_style( 'edd-rp-styles' );

	}

}
new Themedd_EDD_Recommended_Products;
