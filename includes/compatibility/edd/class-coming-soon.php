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

		// Remove the price on a single download page when the download is coming soon.
		add_action( 'template_redirect', array( $this, 'remove_price' ) );

		// Remove the "Coming Soon" text at the end of a download in the download grid.
		remove_action( 'edd_download_after', array( edd_coming_soon(), 'display_text' ) );
		
		// Add the "Coming Soon text back, but at the start of the download footer, so it's above the voting form.
		add_action( 'themedd_edd_download_footer_start', array( edd_coming_soon(), 'display_text' ), 10, 1 );

		// Allow the download footer to show.
		add_filter( 'themedd_edd_download_footer', array( $this, 'show_download_footer' ), 10, 2 );

		// Filter the download grid options.
		add_filter( 'themedd_edd_download_grid_options', array( $this, 'download_grid_options' ), 10, 1 );
		
	}

	/**
	 * Filters the download grid options.
	 *
	 * @access  public
	 * @since   1.0.3
	 */
	public function download_grid_options( $options ) {

		// Get the download ID.
		$download_id = get_the_ID();

		/**
		 * Disable the price for "coming soon" downloads.
		 */
		if ( edd_coming_soon_is_active( $download_id ) ) {
			$options['price'] = false;
		}

		/**
		 * Prevent the shortcode-content-cart-button.php template file from loading if the download is "Coming Soon" and voting isn't enabled.
		 * This essentially removes the empty HTML markup: <div class="edd_download_buy_button"></div>
		 */
		if ( edd_coming_soon_is_active( $download_id ) && ! edd_coming_soon_voting_enabled( $download_id ) ) {
			$options['buy_button'] = false;
		}

		return $options;
	}

	/**
	 * Show the download footer so the coming soon text can show.
	 *
	 * @access  public
	 * @since   1.0.3
	 */
	public function show_download_footer( $show, $download_id ) {

		if ( edd_coming_soon_is_active( $download_id ) ) {
			$show = true;
		}

		return $show;
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

}
new Themedd_EDD_Coming_Soon;
