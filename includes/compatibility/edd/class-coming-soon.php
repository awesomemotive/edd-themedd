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
		
		// Add "Coming Soon" (or custom status text) to the download sidebar, just above the voting form.
		add_action( 'themedd_edd_download_info', array( $this, 'add_coming_soon_notice' ), 9 );
		
		// Change the HTML of the coming soon title
		add_filter( 'edd_coming_soon_display_text', array( $this, 'coming_soon_notice_html' ), 10, 2 );

		// Removing the "Coming Soon" notice (or custom text) from the end of the single download.
		remove_action( 'edd_after_download_content', array( edd_coming_soon(), 'coming_soon_notice' ), 10, 1 );

		// Remove the icon class.
		add_filter( 'edd_cs_btn_icon', array( $this, 'remove_icon' ) );

		// Remove the price when the download is coming soon.
		add_action( 'template_redirect', array( $this, 'remove_price' ) );

		// Hide various elements in the download grid for "Coming Soon" downloads.
		add_filter( 'themedd_edd_show_price', array( $this, 'hide_download_grid_price' ), 10, 1 );
		add_filter( 'themedd_edd_show_buy_button', array( $this, 'hide_download_grid_buy_button' ), 10, 1 );
		
		// Remove the "Coming Soon" text at the end of a download in the download grid.
		remove_action( 'edd_download_after', array( edd_coming_soon(), 'display_text' ) );
		
		// Add the "Coming Soon text back, but at the start of the download footer, so it's above the voting form.
		add_action( 'themedd_edd_download_footer_start', array( edd_coming_soon(), 'display_text' ), 1 );

	}

	/**
	 * Remove the price for a coming soon download on the single download page.
	 *
	 * @access  public
	 * @since   1.0.2
	 */
	public function remove_price() {
		
		// No need to go any further if price enhancements has been disabled.
		if ( false === themedd_edd_price_enhancements() ) {
			return;
		}

		if ( is_singular( 'download' ) && edd_coming_soon_is_active( get_the_ID() ) ) {
			remove_action( 'themedd_edd_download_info', 'themedd_edd_price', 10, 1 );
		}

	}

	/**
	 * Remove the price for a coming soon download on the single download page.
	 *
	 * @access  public
	 * @since   1.0.2
	 */
	public function add_coming_soon_notice() {
		echo edd_coming_soon()->get_custom_status_text();
	}

	/**
	 * Modify coming soon notice HTML
	 *
	 * @access  public
	 * @since   1.0.2
	 */
	public function coming_soon_notice_html( $html, $custom_text ) {
		
		if ( is_singular( 'download' ) ) {
			$html = '<h2 class="widget-title">' . $custom_text . '</h2>';
		} else {
			$html = '<strong>' . $custom_text . '</strong>';
		}

		return $html;
	}

	/**
	 * Remove the icon HTML from inside the button
	 *
	 * @access  public
	 * @since   1.0.2
	 */
	public function remove_icon( $icon ) {
		return '';
	}

	/**
	 * Hide the price of "coming soon" downloads in the download grid.
	 *
	 * @access  public
	 * @since   1.0.2
	 */
	public function hide_download_grid_price( $return ) {
		
		if ( edd_coming_soon_is_active( get_the_ID() ) ) {
			$return = false;
		}

		return $return;

	}

	/**
	 * Prevent the shortcode-content-cart-button.php template file from loading if the download is "Coming Soon" and voting isn't enabled.
	 * This essentially hides an empty div in the download footer.
	 *
	 * @access  public
	 * @since   1.0.2
	 */
	public function hide_download_grid_buy_button( $return ) {

		$download_id = get_the_ID();

		if ( edd_coming_soon_is_active( $download_id ) && ! edd_coming_soon_voting_enabled( $download_id ) ) {
			$return = false;
		}

		return $return;

	}

}
new Themedd_EDD_Coming_Soon;
