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
        add_action( 'template_redirect',  array( $this, 'secondary_navigation_search' ), 20 );
        add_filter( 'wp_nav_menu_items', array( $this, 'mobile_menu_search' ), 20, 2 );
        add_filter( 'themedd_show_sidebar', array( $this, 'hide_sidebar' ) );
    }

    /**
     * Load the search form in the mobile menu.
     *
     * A priority of 20 is used so it loads after the nav cart has been loaded, since
     * It needs to prepend the search form to $items.
     *
     * @since 1.0.3
     * @param string $items The HTML list content for the menu items.
     * @param object $args An object containing wp_nav_menu() arguments.
     *
     * @return string $items The HTML list content for the menu items.
     */
    public function mobile_menu_search( $items, $args ) {

        if ( true !== $this->display_header_search_box() ) {
            return $items;
        }

        if ( 'mobile-menu' === $args->menu_id ) {
            add_filter( 'get_search_form', array( $this, 'search_form' ) );    
            $items = '<li>' . get_search_form( false ) . '</li>' . $items;
            remove_filter( 'get_search_form', array( $this, 'search_form' ) );
        }

        return $items;
        
    }

    /**
     * Load the search form inside the secondary menu.
     *
     * @since 1.0.3
     */
    public function themedd_search_form() {
        
        if ( true !== $this->display_header_search_box() ) {
            return;
        }

        add_filter( 'get_search_form', array( $this, 'search_form' ) );
        get_search_form();
        remove_filter( 'get_search_form', array( $this, 'search_form' ) );
    }

    /**
     * Show a unique search form for searching downloads.
     *
     * @param string $form The search form HTML output.
     * @since 1.0.3
     * 
     * @return string $form The search form HTML output.
     */
    public function search_form( $form ) {
        
        if ( true !== self::enhanced_search() ) {
            return $form;
        }

        ob_start();
    
        $unique_id   = esc_attr( uniqid( 'search-form-' ) );
        $search_text = apply_filters( 'themedd_header_search_box_text', esc_attr_x( 'Search products', 'placeholder', 'themedd' ) );
        ?>
        
        <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <label for="<?php echo $unique_id; ?>">
                <span class="screen-reader-text"><?php echo _x( 'Search products:', 'label', 'themedd' ); ?></span>
                <input type="search" id="<?php echo $unique_id; ?>" class="search-field" placeholder="<?php echo $search_text; ?>" value="<?php echo get_search_query(); ?>" name="s" />
            </label>
            
            <?php if ( apply_filters( 'themedd_search_button', true ) ) : ?>
            <button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'themedd' ); ?></span><?php echo self::search_icon(); ?></button>
            <?php endif; ?>

            <?php 
            /**
             * Only search downloads
             */
            ?>
            <input type="hidden" name="post_type" value="download" />
            
        </form>
        
        <?php
    
        $form = ob_get_contents();
        ob_end_clean();
    
        return $form;
    
    }

    /**
     * Display the header search box into the secondary menu.
     *
     * @since 1.0.3
     */
    public function secondary_navigation_search() {
    
        // Load the header search box.
        if ( true === $this->display_header_search_box() ) {
            add_action( 'themedd_secondary_menu', array( $this, 'themedd_search_form' ) );
        }
    
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
     * Whether or not the header search box is enabled.
     *
     * @since 1.0.3
     *
     * @return boolean $display_header_search_box True if the header search box is enabled, false otherwise.
     */
    public function display_header_search_box() {
        
        $theme_options             = get_theme_mod( 'theme_options' );
        $display_header_search_box = isset( $theme_options['header_search_box'] ) && true === $theme_options['header_search_box'] ? true : false;
    
        /**
         * Filter the display of the header search box.
         *
         * @param boolean $display_header_search_box True if the header search box is enabled, false otherwise.
         * @since 1.0.3
         */
        return apply_filters( 'themedd_display_header_search_box', $display_header_search_box );
        
    }

    /**
     * Whether or not the enhanced search option is enabled or not.
     *
     * @since 1.0.3
     *
     * @return boolean $enhanced_search True if enhanced search box is enabled, false otherwise.
     */
     public static function enhanced_search() {
        
        $edd_theme_options = get_theme_mod( 'easy_digital_downloads' );
        $enhanced_search   = isset( $edd_theme_options['enhanced_search'] ) && true === $edd_theme_options['enhanced_search'] ? true : false;
    
        /**
         * Filter the display of the enhanced search.
         *
         * @param boolean $enhanced_search True if enhanced search is enabled, false otherwise.
         * @since 1.0.3
         */
        return apply_filters( 'themedd_edd_enhanced_search', $enhanced_search );
        
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
function themedd_search() {
    return Themedd_Search::instance();
}

themedd_search();