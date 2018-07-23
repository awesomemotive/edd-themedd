<?php
/**
 * Themedd Search Class
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

final class Themedd_Search {

	/**
	 * Holds the instance
	 *
	 * Ensures that only one instance of Themedd_Search exists in memory at any one
	 * time and it also prevents needing to define globals all over the place.
	 *
	 * TL;DR This is a static property that holds the singleton instance.
	 *
	 * @var object
	 * @static
	 * @since 1.0.3
	 */
	private static $instance;

	/**
	 * Main Themedd_Search Instance
	 *
	 * Insures that only one instance of Themedd_Search exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0.3
	 * @static var array $instance
	 * @return The one true Themedd_Search
	 */    
	public static function instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Themedd_Search ) ) {
			self::$instance = new self;
			self::$instance->hooks();
		}

		return self::$instance;
	}

	/**
	 * Constructor Function
	 *
	 * @since 1.0.3
	 *
	 * @access private
	 */
	private function __construct() {
		self::$instance = $this;
	}

	/**
	 * Setup the default hooks and actions
	 *
	 * @since 1.0.3
	 *
	 * @return void
	 */
	private function hooks() {
		add_filter( 'themedd_show_sidebar', array( $this, 'hide_sidebar' ) );
	}

	/**
	 * 
	 * Search form shown in header
	 * 
	 * @since 1.1
	 */
	public function search_form( $args = array() ) {

		// Return if header search is not enabled.
		if ( ! ( true === $this->show_header_search() ) ) {
			return false;
		}

		if ( themedd_edd_is_distraction_free_checkout() ) {
			return false;
		}
		
		$defaults = array(
			'classes' => array()
		);

		$args = wp_parse_args( $args, $defaults );

		$args['classes'][] = 'form-inline search-form';

		$unique_id = esc_attr( uniqid( 'search-form-' ) );

		$search_text = true === self::restrict_header_search() ? apply_filters( 'themedd_search_products_text', esc_attr_x( 'Search products', 'placeholder', 'themedd' ) ) : apply_filters( 'themedd_search_text', esc_attr_x( 'Search', 'placeholder', 'themedd' ) );

		ob_start();
		?>

		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="<?php echo themedd_output_classes( $args['classes'] ); ?>">
			<div class="input-group w-100">
				<label for="<?php echo $unique_id; ?>">
					<?php
					$search_label = true === self::restrict_header_search() ? _x( 'Search products:', 'label', 'themedd' ) : _x( 'Search for:', 'label', 'themedd' );
					?>
					<span class="sr-only"><?php echo $search_label; ?></span>
				</label>	
				
				<input type="search" id="<?php echo $unique_id; ?>" class="search-field form-control" placeholder="<?php echo $search_text; ?>" value="<?php echo get_search_query(); ?>" name="s" />

				<?php if ( apply_filters( 'themedd_show_search_button', true ) ) : ?>
				<div class="input-group-append">
					<button type="submit" class="search-submit btn btn-search"><span class="sr-only"><?php echo _x( 'Search', 'submit button', 'themedd' ); ?></span><?php echo self::search_icon(); ?></button>
				</div>
				<?php endif; ?>

				<?php 
				// Only search downloads.
				if ( true === self::restrict_header_search() ) : ?>
				<input type="hidden" name="post_type" value="download" />
				<?php endif; ?>

			</div>
		</form>
	
		<?php
		return ob_get_clean();
	}

	/**
	 * Hide the sidebar on the search results page, if downloads are being displayed.
	 *
	 * @param boolean $return Whether to hide the sidebar or not.
	 * @since 1.0.3
	 * 
	 * @return boolean $return Whether to hide the sidebar or not.
	 */
	public function hide_sidebar( $return ) {

		if ( themedd_is_edd_active() && self::is_product_search_results() ) {
			$return = false;
		}

		return $return;

	}

	/**
	 * Determine if we're searching products (downloads) only.
	 *
	 * @since 1.0.3
	 * 
	 * @return boolean $return True if searching products, false otherwise.
	 */
	public static function is_product_search_results() {
		
		$return = false;

		if ( isset( $_GET['post_type'] ) && 'download' === $_GET['post_type'] ) {
			$return = true;
		}

		return $return;
	}

	/**
	 * The search icon displayed all search forms.
	 *
	 * @since 1.0.3
	 * 
	 * @return string $content The HTML of the SVG
	 */
	public static function search_icon() {
		
		ob_start();
	?>
		<svg width="16" height="16" viewBox="0 0 16 16" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:10;">
			<g>
				<circle cx="6.607" cy="6.607" r="5.201" style="fill:none;stroke-width:2px;"/>
				<path d="M10.284,10.284L14.408,14.408" style="fill:none;stroke-width:2px;stroke-linecap:round;"/>
			</g>
		</svg>
	<?php
		
		$html = apply_filters( 'themedd_search_icon', ob_get_contents() );
		ob_end_clean();

		return $html;

	}

	/**
	 * Whether or not the header search is enabled.
	 *
	 * @since 1.0.3
	 *
	 * @return boolean $show_header_search True if the header search is enabled, false otherwise.
	 */
	public function show_header_search() {
		
		$theme_options      = get_theme_mod( 'theme_options' );
		$show_header_search = isset( $theme_options['header_search'] ) && true === $theme_options['header_search'] ? true : false;

		/**
		 * Whether or not the header search should be shown.
		 *
		 * @param boolean $show_header_search True if the header search is enabled, false otherwise.
		 * @since 1.0.3
		 */
		return apply_filters( 'themedd_show_header_search', $show_header_search );
		
	}

	/**
	 * Restrict header search
	 * Restricts the header search to only search products (downloads).
	 *
	 * @since 1.0.3
	 *
	 * @return boolean $restrict_header_search True if restrict header search is enabled, false otherwise.
	 */
	public static function restrict_header_search() {
		
		$edd_theme_options      = get_theme_mod( 'easy_digital_downloads' );
		$restrict_header_search = isset( $edd_theme_options['restrict_header_search'] ) && true === $edd_theme_options['restrict_header_search'] ? true : false;

		/**
		 * Filters the restrict header search option.
		 *
		 * @param boolean $restrict_header_search True if restricted search is enabled, false otherwise.
		 * @since 1.0.3
		 */
		return apply_filters( 'themedd_edd_restrict_header_search', $restrict_header_search );

	}

}

/**
 * The main function responsible for returning the one true Themedd_Search instance to functions everywhere.
 * 
 * Use this function like you would a global variable, except without needing to declare the global.
 * 
 * Example: <?php $themedd_search = themedd_search(); ?>
 *
 * @since 1.0.3
 * @return object The one true Themedd_Search Instance.
 */
function themedd_load_search() {
	return Themedd_Search::instance();
}