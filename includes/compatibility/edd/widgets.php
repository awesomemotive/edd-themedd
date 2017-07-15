<?php
/**
 * Widgets
 *
 * "Download Author" and "Download Details" Widgets based on the Vendd theme: https://easydigitaldownloads.com/downloads/vendd/
 */

/**
 * Download Author Information Widget
 *
 * This widget is designed to replace the default author info widget that
 * displays in the Themedd download sidebar by default. This purely exists
 * as an alternative to the default so that you can control your sidebar
 * and rearrange items.
 *
 * @since 1.0.0
 */
class Themedd_Author_Details extends WP_Widget {

	/**
	 * Register the widget
	 */
	public function __construct() {

		parent::__construct(
			'themedd_download_author',
			'Themedd' . ': ' . sprintf( __( '%s Author', 'themedd' ), edd_get_label_singular() ),
			array(
				'description' => sprintf( __( 'Display the %s author\'s details.', 'themedd' ), strtolower( edd_get_label_singular() ) ),
				'classname'   => 'downloadAuthor'
			)
		);

	}

	/**
	 * Output the content of the widget
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		global $post;

		$author  = new WP_User( $post->post_author );

		if ( themedd_is_edd_fes_active() ) {
			$vendor_url = (new Themedd_EDD_Frontend_Submissions)->author_url( get_the_author_meta( 'ID', $author->post_author ) );
		}

		$vendor_store = get_the_author_meta( 'name_of_store', $post->post_author );
		$avatar       = isset( $instance['avatar'] )      ? $instance['avatar']      : 1;
		$store_name   = isset( $instance['store_name'] )  ? $instance['store_name']  : 1;
		$name         = isset( $instance['name'] )        ? $instance['name']        : 1;
		$signup_date  = isset( $instance['signup_date'] ) ? $instance['signup_date'] : 1;

		$show_website = isset( $instance['website'] ) ? $instance['website'] : 1;

		$website      = get_the_author_meta( 'user_url', $post->post_author );

		// Return early if not a single download.
		if ( 'download' !== get_post_type( $post ) ) {
			return;
		}

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		/**
		 * Avatar
		 */
		if ( $avatar ) {

			if ( themedd_is_edd_fes_active() ) : ?>
				<div class="downloadAuthor-avatar">
					<a class="vendor-url" href="<?php echo esc_url( $vendor_url ); ?>"><?php echo get_avatar( $author->ID, themedd_edd_download_author_avatar_size() ); ?></a>
				</div>
			<?php else : ?>
				<div class="downloadAuthor-avatar">
					<?php echo get_avatar( $author->ID, themedd_edd_download_author_avatar_size() ); ?>
				</div>
			<?php endif;

		}

		/**
		 * Author's store name.
		 */
		if ( $store_name ) : ?>
			<h2 class="widget-title"><?php echo $vendor_store; ?></h2>
		<?php endif; ?>

		<ul>
			<?php
			/**
			 * Author name
			 */
			if ( $name ) : ?>
				<li class="downloadAuthor-author">
					<span class="downloadAuthor-name"><?php _e( 'Author:', 'themedd' ); ?></span>
					<span class="downloadAuthor-value">
						<?php if ( themedd_is_edd_fes_active() ) : ?>
							<a class="vendor-url" href="<?php echo esc_url( $vendor_url ); ?>">
								<?php echo $author->display_name; ?>
							</a>
						<?php else : ?>
							<?php echo $author->display_name; ?>
						<?php endif; ?>
					</span>
				</li>
			<?php endif; ?>

			<?php
			/**
			 * Author signup date.
			 */
			if ( $signup_date ) : ?>
				<li class="downloadAuthor-authorSince">
					<span class="downloadAuthor-name"><?php _e( 'Author since:', 'themedd' ); ?></span>
					<span class="downloadAuthor-value"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $author->user_registered ) ); ?></span>
				</li>
			<?php endif; ?>

			<?php
			/**
			 * Author website.
			 */
			if ( $show_website && ! empty( $website ) ) : ?>
				<li class="downloadAuthor-website">
					<span class="downloadAuthor-name"><?php _e( 'Website:', 'themedd' ); ?></span>
					<span class="downloadAuthor-value"><a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener"><?php echo esc_url( $website ); ?></a></span>
				</li>
			<?php endif; ?>

		</ul>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		// Default settings.
		$defaults = array(
			'avatar'      => 1,
			'store_name'  => 1,
			'name'        => 1,
			'signup_date' => 1,
			'website'     => 1,
		);

		$instance    = wp_parse_args( (array) $instance, $defaults );

		$avatar      = isset( $instance['avatar'] )      ? (bool) $instance['avatar']      : true;
		$store_name  = isset( $instance['store_name'] )  ? (bool) $instance['store_name']  : true;
		$name        = isset( $instance['name'] )        ? (bool) $instance['name']        : true;
		$signup_date = isset( $instance['signup_date'] ) ? (bool) $instance['signup_date'] : true;
		$website     = isset( $instance['website'] )     ? (bool) $instance['website']     : true;

		?>
		<p class="themedd-widget-usage"><em><?php _e( 'Only for use in Download Sidebar', 'themedd' ); ?></em></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'themedd' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar' ) ); ?>" <?php checked( $avatar ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar' ) ); ?>"><?php _e( 'Show Author Avatar', 'themedd' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'store_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'store_name' ) ); ?>" <?php checked( $store_name ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'store_name' ) ); ?>"><?php _e( 'Show Store Name', 'themedd' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" <?php checked( $name ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>"><?php _e( 'Show Author Name', 'themedd' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'signup_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'signup_date' ) ); ?>" <?php checked( $signup_date ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'signup_date' ) ); ?>"><?php _e( 'Show Author Sign-up Date', 'themedd' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'website' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'website' ) ); ?>" <?php checked( $website ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'website' ) ); ?>"><?php _e( 'Show Website', 'themedd' ); ?></label>
		</p>

		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {

		$instance                = $old_instance;
		$instance['title']       = ( ! empty( $new_instance['title'] ) )   ? strip_tags( $new_instance['title'] ) : '';
		$instance['avatar']      = ! empty( $new_instance['avatar'] )      ? 1 : 0;
		$instance['store_name']  = ! empty( $new_instance['store_name'] )  ? 1 : 0;
		$instance['name']        = ! empty( $new_instance['name'] )        ? 1 : 0;
		$instance['signup_date'] = ! empty( $new_instance['signup_date'] ) ? 1 : 0;
		$instance['website']     = ! empty( $new_instance['website'] )     ? 1 : 0;

		return $instance;

	}

}

/**
 * Themedd Download Details Information Widget
 *
 * This widget is designed to replace the default download info widget that
 * displays in the Themedd download sidebar by default. This purely exists
 * as an alternative to the default so that you can control your sidebar
 * and rearrange items.
 *
 * @since 1.0.0
 */
class Themedd_Download_Details extends WP_Widget {

	/**
	 * Register the widget
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct(
			'themedd_download_details',
			'Themedd' . ': ' . sprintf( __( '%s Details', 'themedd' ), edd_get_label_singular() ),
			array(
			'description' => sprintf( __( 'Display the %s details such as date published and total sales.', 'themedd' ), strtolower( edd_get_label_singular() ) ),
			'classname'   => 'downloadDetails'
			)
		);

	}

	/**
	 * Output the content of the widget
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		global $post;

		$author          = new WP_User( $post->post_author );
		$published       = isset( $instance['published'] )  ? $instance['published']  : 1;
		$sales           = isset( $instance['sales'] )      ? $instance['sales']      : 1;
		$licensed        = isset( $instance['licensed'] )   ? $instance['licensed']   : 1;
		$version         = isset( $instance['version'] )    ? $instance['version']    : 1;
		$show_categories = isset( $instance['categories'] ) ? $instance['categories'] : 1;
		$show_tags       = isset( $instance['tags'] )       ? $instance['tags']       : 1;

		// Return early if not a single download.
		if ( 'download' !== get_post_type( $post ) ) {
			return;
		}

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		?>

		<ul>
			<?php
			/**
			 * Published
			 */
			if ( $published ) : ?>
				<li class="downloadDetails-published">
					<?php
						$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
						$time_string = sprintf( $time_string,
							esc_attr( get_the_date( 'c' ) ),
							esc_html( get_the_date() ),
							esc_attr( get_the_modified_date( 'c' ) ),
							esc_html( get_the_modified_date() )
						);
					?>
					<span class="downloadDetails-name"><?php _e( 'Published:', 'themedd' ); ?></span>
					<span class="downloadDetails-value"><?php echo $time_string; ?></span>
				</li>
			<?php endif; ?>

			<?php
			/**
			 * Sale count
			 */

			$sale_count = false;
			$sales      = edd_get_download_sales_stats( $post->ID );

			// Whether to display sale count or not.
			if (
				// Display sale count when FES is activated.
				themedd_is_edd_fes_active() ||

				// Display sale count when filter is set to true.
				apply_filters( 'themedd_edd_display_sale_count', false, $post ) ||

				// Display sale count when the Download Meta plugin is activated and the display sales checkbox is enabled
				( themedd_is_edd_download_meta_active() && get_post_meta( $post->ID, '_edd_download_meta_sale_count', true ) )
			) {
				$sale_count = true;
			}

			if ( $sale_count ) : ?>
				<li class="downloadDetails-sales">
					<span class="downloadDetails-name"><?php _e( 'Sales:', 'themedd' ); ?></span>
					<span class="downloadDetails-value"><?php echo $sales; ?></span>
				</li>
			<?php endif; ?>

			<?php
			/**
			 * Version.
			 */
			if ( function_exists( 'edd_download_meta_has_edd_sl_enabled' ) && edd_download_meta_has_edd_sl_enabled() && (new Themedd_EDD_Software_Licensing)->has_licensing_enabled() ) {
				// Get version number from EDD Software Licensing.
				$version = get_post_meta( get_the_ID(), '_edd_sl_version', true );
			} elseif ( themedd_is_edd_download_meta_active() ) {
				// Get version number from EDD Download Meta
				$version = get_post_meta( get_the_ID(), '_edd_download_meta_version', true );
			} else {
				// No version number.
				$version = '';
			}
			?>

			<?php if ( $version ) : ?>
			<li class="downloadDetails-version">
				<span class="downloadDetails-name"><?php _e( 'Version:', 'themedd' ); ?></span>
				<span class="downloadDetails-value"><?php echo $version; ?></span>
			</li>
			<?php endif; ?>

			<?php
			/**
			 * Download categories.
			 */
			if ( $show_categories ) :

				$categories = get_the_term_list( $post->ID, 'download_category', '', ', ', '' );

				if ( $categories ) : ?>
					<li class="downloadDetails-categories">
						<span class="downloadDetails-name"><?php _e( 'Categories:', 'themedd' ); ?></span>
						<span class="downloadDetails-value"><?php echo $categories; ?></span>
					</li>
				<?php endif; ?>

		 	<?php endif; ?>

			<?php
			/**
			 * Tags.
			 */
			if ( $show_tags ) :

				$tags = get_the_term_list( $post->ID, 'download_tag', '', ', ', '' );

				if ( $tags ) : ?>
				<li class="downloadDetails-tags">
					<span class="downloadDetails-name"><?php _e( 'Tags:', 'themedd' ); ?></span>
					<span class="downloadDetails-value"><?php echo $tags; ?></span>
				</li>
				<?php endif; ?>

			<?php endif; ?>

		</ul>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		// Default settings.
		$defaults = array(
			'published'  => 1,
			'sales'      => 1,
			'version'    => 1,
			'categories' => 1,
			'tags'       => 1,
		);

		$instance   = wp_parse_args( (array) $instance, $defaults );

		$published  = isset( $instance['published'] )  ? (bool) $instance['published']  : true;
		$sales      = isset( $instance['sales'] )      ? (bool) $instance['sales']      : true;
		$version    = isset( $instance['version'] )    ? (bool) $instance['version']    : true;
		$categories = isset( $instance['categories'] ) ? (bool) $instance['categories'] : true;
		$tags       = isset( $instance['tags'] )       ? (bool) $instance['tags']       : true;

		?>
		<p class="themedd-widget-usage"><em><?php _e( 'Only for use in Download Sidebar', 'themedd' ); ?></em></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'themedd' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'published' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'published' ) ); ?>" <?php checked( $published ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'published' ) ); ?>"><?php _e( 'Show Published Date', 'themedd' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'sales' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sales' ) ); ?>" <?php checked( $sales ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sales' ) ); ?>"><?php _e( 'Show Sales Total', 'themedd' ); ?></label>
		</p>

		<?php if ( themedd_is_edd_sl_active() ) : ?>
			<p>
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'version' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'version' ) ); ?>" <?php checked( $version ); ?>/>
				<label for="<?php echo esc_attr( $this->get_field_id( 'version' ) ); ?>"><?php _e( 'Show Version Number', 'themedd' ); ?></label>
			</p>
		<?php endif; ?>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'categories' ) ); ?>" <?php checked( $categories ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>"><?php _e( 'Show Categories', 'themedd' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tags' ) ); ?>" <?php checked( $tags ); ?>/>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>"><?php _e( 'Show Tags', 'themedd' ); ?></label>
		</p>

		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {

		$instance               = $old_instance;
		$instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['published']  = ! empty( $new_instance['published'] )   ? 1 : 0;
		$instance['sales']      = ! empty( $new_instance['sales'] )       ? 1 : 0;
		$instance['categories'] = ! empty( $new_instance['categories'] )  ? 1 : 0;
		$instance['tags']       = ! empty( $new_instance['tags'] )        ? 1 : 0;

		if ( themedd_is_edd_sl_active() ) {
			$instance['licensed'] = ! empty( $new_instance['licensed'] ) ? 1 : 0;
			$instance['version']  = ! empty( $new_instance['version'] )  ? 1 : 0;
		}

		return $instance;

	}

}


/**
 * Register the widgets.
 *
 * @since 1.0.0
 */
function themedd_register_widgets() {
	register_widget( 'Themedd_Author_Details' );
	register_widget( 'Themedd_Download_Details' );
}
add_action( 'widgets_init', 'themedd_register_widgets' );
