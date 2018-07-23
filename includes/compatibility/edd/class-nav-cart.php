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
		add_filter( 'edd_get_cart_quantity', array( $this, 'set_cart_quantity' ), 10, 2 );
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
			return false;
		}

		// Return early if we're on the EDD checkout page.
		if ( function_exists( 'edd_is_checkout' ) && edd_is_checkout() ) {
			return false;
		}

		ob_start();

		// Set up defaults.
		$defaults = apply_filters( 'themedd_edd_cart_defaults',
			array(
				'classes'     => array( 'ml-lg-3' ),
				'cart_link'   => isset( $args['cart_link'] ) ? $args['cart_link'] : edd_get_checkout_uri(),
				'text_before' => isset( $args['text_before'] ) ? $args['text_before'] : '',
				'text_after'  => isset( $args['text_after'] ) ? $args['text_after'] : '',
				'cart_option' => ! empty( $args['cart_option'] ) ? $args['cart_option'] : self::cart_option(), // item_quantity | cart_total | all | none
			)
		);

		$args = wp_parse_args( $args, $defaults );

		// Cart link.
		$cart_link = $args['cart_link'];
		
		// Default classes.
		$args['classes'][] = 'nav-cart d-flex align-items-center';

		// Cart option.
		$cart_option = $args['cart_option'];
		?>
		<a class="<?php echo themedd_output_classes( $args['classes'] ); ?>" href="<?php echo $cart_link; ?>">
			<?php
			// Cart icon.
			echo $this->cart_icon();

			// Text before.
			if ( $args['text_before'] ) {
				echo '<span class="nav-cart-text-before align-self-center">' . $args['text_before'] . '</span>';
			}

			// Cart quantity and total.
			if ( 'none' !== $cart_option ) {
				echo '<span class="nav-cart-quantity-and-total align-self-center">';

				if ( 'all' === $cart_option || 'item_quantity' === $cart_option ) {
					echo self::cart_quantity();
				}

				if ( 'all' === $cart_option || 'cart_total' === $cart_option ) {
					echo self::cart_total( $args );
				}

				echo '</span>';

			}

			// Text after.
			if ( $args['text_after'] ) {
				echo '<span class="nav-cart-text-after align-self-center">' . $args['text_after'] . '</span>';
			}

			?>
		</a>
		<?php return ob_get_clean();
	}

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
		<div class="nav-cart-icon d-flex">
			<?php echo themedd_get_svg( array( 'icon' => 'cart' ) ); ?>
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

			$cart_quantity_text = '<span class="nav-cart-quantity-text">' . $item_text . '</span>';

		} else {
			$cart_quantity_text = '';
		}

		?>
		<span class="nav-cart-quantity"><?php echo $cart_quantity; ?><?php echo $cart_quantity_text; ?></span>
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
	public static function cart_total( $args ) {

		if ( 'all' === $args['cart_option'] ) {	
			$sep = apply_filters( 'themedd_edd_cart_total_separator', '-' );
			$sep = '<span class="nav-cart-total-separator"> ' . $sep . ' </span>';
		} else {
			$sep = '';
		}

		?>
		<span class="nav-cart-total"><?php echo $sep; ?><span class="nav-cart-total-amount"><?php echo edd_currency_filter( edd_format_amount( edd_get_cart_total() ) ); ?></span></span>
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
function themedd_edd_load_nav_cart() {
	return Themedd_EDD_Nav_Cart::instance();
}