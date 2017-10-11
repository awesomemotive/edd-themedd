<?php
/**
 * A single download inside of the [downloads] shortcode.
 *
 * @since 2.9.0
 *
 * @package EDD
 * @category Template
 * @author Easy Digital Downloads
 * @version 1.0.0
 */

global $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i;

$download_grid_options = themedd_edd_download_grid_options();
$schema_microdata      = edd_add_schema_microdata() ? 'itemscope itemtype="http://schema.org/Product" ' : '';
?>

<div <?php echo $schema_microdata; ?>class="<?php echo esc_attr( apply_filters( 'edd_download_class', 'edd_download', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>" id="edd_download_<?php the_ID(); ?>">

	<div class="<?php echo esc_attr( apply_filters( 'edd_download_inner_class', 'edd_download_inner', get_the_ID(), $edd_download_shortcode_item_atts, $edd_download_shortcode_item_i ) ); ?>">

		<?php
			do_action( 'edd_download_before' );

			if ( 
				'false' !== $edd_download_shortcode_item_atts['thumbnails'] ||
				( 'true' !== $edd_download_shortcode_item_atts['thumbnails'] && false !== $download_grid_options['thumbnails'] )
			) :
				edd_get_template_part( 'shortcode', 'content-image' );
				do_action( 'edd_download_after_thumbnail' );
			endif;

			/**
			 * Used by themedd_edd_download_meta_before_title()
			 */
			do_action( 'edd_download_before_title' );

			if ( true === $download_grid_options['title'] ) {
				edd_get_template_part( 'shortcode', 'content-title' );
			}

			do_action( 'edd_download_after_title' );
			
			/**
			 * Display either the download's excerpt or full content.
			 */
			if (
				/**
				 * Show the excerpt if any of these these shortcodes are used:
				 * 
				 * [downloads] (except is the default)
				 * [downloads excerpt="yes"]
				 * [downloads full_content="no"]
				 */
				( 
					'yes' === $edd_download_shortcode_item_atts['excerpt'] && 
					'yes' !== $edd_download_shortcode_item_atts['full_content']
				) 
				
				||
			
				/**
				 * Show the excerpt if:
				 * 
				 * "excerpt" is set to "yes" on the [downloads] shortcode
				 * AND
				 * "full_content" is NOT set to "yes" on the [downloads] shortcode.
				 * AND
				 * "excerpt" is not set to "false" via the themedd_edd_download_grid_options filter hook. 
				 */
				( 
					'yes' === $edd_download_shortcode_item_atts['excerpt'] && 
					'yes' !== $edd_download_shortcode_item_atts['full_content'] && 
					false !== $download_grid_options['excerpt']
				)
			) :
				
				// Show the excerpt.
				edd_get_template_part( 'shortcode', 'content-excerpt' );

				do_action( 'edd_download_after_content' );

			elseif (
				/**
				 * Show the full_content if [downloads full_content="yes"]
				 */
				( 'yes' === $edd_download_shortcode_item_atts['full_content'] ) 
				
				||

				/**
				 * Show the full_content if:
				 * 
				 * "full_content" is set to "true" via the themedd_edd_download_grid_options filter hook.
				 * AND
				 * "full_content" is NOT set to "no" on the [downloads] shortcode.
				 */
				( 
					true === $download_grid_options['full_content'] && 
					'no' !== $edd_download_shortcode_item_atts['full_content']
				)
			) :
				
				// Show the full content.
				edd_get_template_part( 'shortcode', 'content-full' );
				
				do_action( 'edd_download_after_content' );
				
			endif;

			/**
			 * Download footer
			 */
			themedd_edd_download_footer( $edd_download_shortcode_item_atts );

			do_action( 'edd_download_after' );

		?>
	</div>

</div>
