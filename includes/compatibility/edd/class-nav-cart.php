<?php
/**
 * EDD Nav Cart
 *
 * @since 1.0.3
 */
final class Themedd_EDD_Nav_Cart {

    /**
     * Holds the instance
     *
     * Ensures that only one instance of Themedd_EDD_Nav_Cart exists in memory at any one
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
     * Main Themedd_EDD_Nav_Cart Instance
     *
     * Insures that only one instance of Themedd_EDD_Nav_Cart exists in memory at any one
     * time. Also prevents needing to define globals all over the place.
     *
     * @since 1.0.3
     * @static var array $instance
     * 
     * @return The one true Themedd_EDD_Nav_Cart
    */    
    public static function instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Themedd_EDD_Nav_Cart ) ) {
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
        add_filter( 'edd_get_cart_quantity', array( $this, 'set_cart_quantity'   ), 10, 2 );
        add_filter( 'wp_nav_menu_items',     array( $this, 'add_to_menus'  ), 10, 2 );
        add_action( 'template_redirect',     array( $this, 'add_to_secondary_menu' ), 10 );
    }

    /**
     * Make the total quantity blank when no items exist in the cart.
     *
     * @since 1.0.0
     * 
     * @return $total_quantity string
     */
    public function set_cart_quantity( $total_quantity, $cart ) {
    
        if ( ! $cart ) {
            $total_quantity = '';
        }
    
        return $total_quantity;
    }

    /**
     * Apppends the cart to the secondary menu.
     *
     * @since 1.0.0
     */
    public function add_to_secondary_menu() {
        
        if ( 'secondary_menu' === $this->cart_position() && true === $this->show_cart() ) {
			add_action( 'themedd_secondary_menu_after', array( $this, 'load_cart' ), 10, 1 );
        }

    }

    /**
     * Load the EDD cart
     *
     * @since 1.0.3
     */
    public function load_cart() {
        echo $this->cart( array( 'list_item' => false ) );
    }

    /**
     * Add cart to menus.
     *
     * @since 1.0.0
     * 
     * @return string $items The HTML list content for the menu items.
     */
    public function add_to_menus( $items, $args ) {

        if ( 'mobile-menu' === $args->menu_id ) {

            $mobile_cart_link = $this->cart(
                apply_filters( 'themedd_edd_mobile_menu', array(
                    'classes' => array( 'navCart navCart-mobile' ),
                ) )
            );

            $items = $mobile_cart_link . $items;
        }
        
        if ( 'primary-menu' === $args->menu_id && 'primary_menu' === $this->cart_position() ) {
            $items = $items . $this->cart();
        }

        return $items;

    }

    /**
     * Determine where the cart should be shown.
     *
     * Possible options are secondary_menu | primary_menu
     *
     * @since 1.0.0
     * 
     * @return string $position The position of the cart.
     */
    public function cart_position() {

        $position = 'secondary_menu';

        return apply_filters( 'themedd_edd_cart_position', $position );
    }

    /**
     * Determines whether the nav cart is being shown.
     *
     * @since 1.0.3
     *
     * @return boolean $show_cart True if cart is enabled, false otherwise.
     */
    public static function show_cart() {
        
        $show_cart = false;

        // There is a cart when there is at least a cart icon, or an option selected (which isn't "none") for the cart options. 
        if ( self::show_cart_icon() || 'none' !== self::cart_option() ) {
            $show_cart = true;
        }

        /**
		 * Whether or not the cart is shown.
		 *
		 * @param boolean $show_cart True if cart is enabled, false otherwise.
		 * @since 1.0.0
		 */
        return apply_filters( 'themedd_edd_show_cart', $show_cart );

    }

    /**
     * Determines whether the cart icon is being shown.
     *
     * @since 1.0.0
     *
     * @return boolean $show_cart_icon true if cart is enabled, false otherwise.
     */
    public static function show_cart_icon() {

        $edd_theme_options = get_theme_mod( 'easy_digital_downloads' );
        $show_cart_icon = isset( $edd_theme_options['cart_icon'] ) && true === $edd_theme_options['cart_icon'] ? true : false;
        
        /**
         * Set to "true" if no options exist in theme mods array.
         * This is because the option is enabled by default in the customizer.
         */
        if ( ! isset( $edd_theme_options['cart_icon'] ) ) {
            $show_cart_icon = true;
        }

        /**
		 * Whether the cart icon is shown.
		 *
		 * @param boolean $show_cart_icon True if cart is enabled, false otherwise.
         * 
		 * @since 1.0.3
		 */
        return apply_filters( 'themedd_edd_show_cart_icon', $show_cart_icon );
    }    

    /**
     * Cart option.
     *
     * @since 1.0.0
     * @see themedd_customize_cart_options()
     *
     * @return string $cart_option The cart option to show. item_quantity | cart_total | all | none
     */
     public static function cart_option() {

        $edd_theme_options = get_theme_mod( 'easy_digital_downloads' );
        $cart_option       = isset( $edd_theme_options['cart_options'] ) ? $edd_theme_options['cart_options'] : 'all';
        
        /**
		 * Filter the cart option.
		 *
		 * @param string $cart_option The cart option to show. item_quantity | cart_total | all | none
		 * @since 1.0.0
         */     
        return apply_filters( 'themedd_edd_cart_option', $cart_option );
    }     

    /**
     * The Cart.
     *
     * The cart contains:
     *
     * 1. The cart icon
     * 2. The cart quantity
     * 3. The cart total
     *
     * @since 1.0.0
     * @return string $html The HTML of the cart to be shown.
     */
    public function cart( $args = array() ) {

        // Return early if nothing is set to be shown.
        if ( true !== self::show_cart() ) {
            return;
        }
    
        ob_start();
    
        // Set up defaults.
        $defaults = apply_filters( 'themedd_edd_cart_defaults',
            array(
                'classes'     => array( 'navCart' ),
                'cart_link'   => isset( $args['cart_link'] ) ? $args['cart_link'] : edd_get_checkout_uri(),
                'list_item'   => isset( $args['list_item'] ) && $args['list_item'] === false ? false : true,
                'text_before' => isset( $args['text_before'] ) ? $args['text_before'] : '',
                'text_after'  => isset( $args['text_after'] ) ? $args['text_after'] : '',
            )
        );
    
        $cart_items = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : '';
    
        $defaults['classes'][] = ! $cart_items ? 'empty' : '';
    
        $args = wp_parse_args( $args, $defaults );
    
        $cart_items = function_exists( 'edd_get_cart_contents' ) ? edd_get_cart_contents() : '';
    
        // Whether or not to include list item markup.
        $list_item = $args['list_item'];
    
        // Cart link.
        $cart_link = $args['cart_link'];
    
        if ( ! ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) ) : ?>
    
            <?php if ( $list_item ) : ?>
            <li class="nav-action checkout menu-item">
            <?php endif; ?>
    
                <a class="<?php echo implode( ' ', array_filter( $args['classes'] ) ); ?>" href="<?php echo $cart_link; ?>">
    
                    <?php
    
                    echo $this->cart_icon();
    
                    if ( $args['text_before'] ) {
                        echo '<span class="navCart-textBefore">' . $args['text_before'] . '</span>';
                    }
    
                    if ( 'none' !== self::cart_option() ) {
                        echo '<span class="navCart-cartQuantityAndTotal">';
    
                        if ( 'all' === self::cart_option() || 'item_quantity' === self::cart_option() ) {
                            echo self::cart_quantity();
                        }
    
                        if ( 'all' === self::cart_option() || 'cart_total' === self::cart_option() ) {
                            echo self::cart_total();
                        }
    
                        echo '</span>';
    
                    }
    
                    if ( $args['text_after'] ) {
                        echo '<span class="navCart-textAfter">' . $args['text_after'] . '</span>';
                    }
    
                    ?>
    
                </a>
            <?php if ( $list_item ) : ?>
            </li>
            <?php endif; ?>
    
        <?php endif;
    
        $html = ob_get_contents();
        ob_end_clean();
    
        return $html;
    
        ?>
    
    <?php }

    /**
     * The cart icon.
     *
     * @since 1.0.0
     * 
     * @return string $html The HTML of the nav cart icon.
     */
    public function cart_icon() {
        
        if ( ! self::show_cart_icon() ) {
            return;
        }
    
        ob_start();
        ?>
        <div class="navCart-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414"><path fill="none" d="M0 0h24v24H0z"/><path d="M5.1.5c.536 0 1 .37 1.12.89l1.122 4.86H22.35c.355 0 .688.163.906.442.217.28.295.644.21.986l-2.3 9.2c-.128.513-.588.872-1.116.872H8.55c-.536 0-1-.37-1.12-.89L4.185 2.8H.5V.5h4.6z" fill-rule="nonzero"/><circle cx="6" cy="20" r="2" transform="matrix(-1.14998 0 0 1.14998 25.8 -1.8)"/><circle cx="14" cy="20" r="2" transform="matrix(-1.14998 0 0 1.14998 25.8 -1.8)"/></svg>
        </div>
        <?php
    
        $html = apply_filters( 'themedd_edd_cart_icon', ob_get_contents() );
        ob_end_clean();
    
        return $html;
    }

    /**
     * Cart quantity.
     *
     * @since 1.0.0
     *
     * @return string Cart quantity.
     */
    public static function cart_quantity() {
        
        // Cart quantity.
        $count = edd_get_cart_quantity();
    
        if ( empty( $count ) ) {
            $count = '0';
        }
    
        $cart_quantity = '<span class="edd-cart-quantity">' . $count . '</span>'; // This class name must match exactly in order for EDD to update the count
        $cart_quantity = apply_filters( 'themedd_edd_cart_quantity', $cart_quantity );
    
        // Cart quantity text.
        $cart_quantity_text = self::cart_quantity_text();
    
        if ( apply_filters( 'themedd_edd_cart_quantity_text', true ) ) {
            // Set the default to be plural. Used for anything greater than 1 or 0.
            // Example: 0 items, 2 items.
            $item_text = ' ' . $cart_quantity_text['plural'];
    
            // Show the singular if there's only 1 item in cart.
            if ( 1 === $count ) {
                $item_text = ' ' . $cart_quantity_text['singular'];
            }
    
            $cart_quantity_text = '<span class="navCart-quantityText">' . $item_text . '</span>';
    
        } else {
            $cart_quantity_text = '';
        }
    
        ?>
        <span class="navCart-quantity"><?php echo $cart_quantity; ?><?php echo $cart_quantity_text; ?></span>
        <?php
    }

    /**
     * Cart quantity text.
     *
     * @since 1.0.0
     *
     * @return array $cart_quantity_text Cart quantity singular and plural name
     */
    public static function cart_quantity_text() {
        
        $cart_quantity_text = apply_filters( 'themedd_edd_cart_quantity_text', 
            array(
                'singular' => __( 'item', 'themedd' ),
                'plural'   => __( 'items', 'themedd' )
            )
        );
    
        return $cart_quantity_text;

    }

    /**
     * Cart total.
     *
     * @since 1.0.0
     *
     * @return string cart total
     */
    public static function cart_total() {
    
        if ( 'all' === self::cart_option() ) {
            $sep = apply_filters( 'themedd_edd_cart_total_separator', '-' );
            $sep = '<span class="navCart-cartTotalSeparator"> ' . $sep . ' </span>';
        } else {
            $sep = '';
        }
 
        ?>
        <span class="navCart-total"><?php echo $sep; ?><span class="navCart-cartTotalAmount"><?php echo edd_currency_filter( edd_format_amount( edd_get_cart_total() ) ); ?></span></span>
        <?php
    }
    
}

/**
  * The main function responsible for returning the one true Themedd_EDD_Nav_Cart instance to functions everywhere.
  * 
  * Use this function like you would a global variable, except without needing to declare the global.
  * 
  * Example: <?php $themedd_edd_nav_cart = themedd_edd_nav_cart(); ?>
  *
  * @since 1.0.3
  * @return object The one true Themedd_EDD_Nav_Cart Instance.
  */
function themedd_edd_nav_cart() {
    return Themedd_EDD_Nav_Cart::instance();
}

themedd_edd_nav_cart();