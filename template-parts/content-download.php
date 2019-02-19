<?php
/**
 * The template used for displaying a download's content.
 * Loaded by single-download.php
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'container' ) ); ?>>

	<?php
	/**
	 * Product title.
	 */
	?>
	<header class="product-header mb-lg-5">
		<?php themedd_edd_product_title(); ?>
	</header>

	<?php
	/**
	 * Product purchase section.
	 */
	?>
	<?php
		$classes = array( 'product-purchase', 'mb-7' );
		// Add some top margin if no product image.
		$classes[] = themedd_edd_has_product_image() ? 'mt-lg-3' : '';
	?>
	<section<?php themedd_classes( array( 'classes' => $classes ) ); ?>>
		<?php do_action( 'themedd_edd_product_purchase_start' ); ?>

		<div>
			<?php themedd_edd_product_price( array( 'classes' => array( 'mb-3' ) ) ); ?>
			<?php themedd_edd_purchase_link( array( 'classes' => array() ) ); ?>
		</div>

		<?php do_action( 'themedd_edd_product_purchase_end' ); ?>
	</section>

	<?php
	/**
	 * The product content section.
	 * This contains the product's image and its description.
	 */
	?>
	<section class="product-content">
		<?php do_action( 'themedd_edd_product_content_start' ); ?>
		<?php themedd_post_thumbnail( array( 'size' => 'themedd-standard-image' ) ); ?>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<?php do_action( 'themedd_edd_product_content_end' ); ?>
	</section>

	<?php
	/**
	 * The download sidebar.
	 * By default this contains a "Product details" section. This can be overridden
	 * by adding widgets into the "Download sidebar" area.
	 */
	themedd_get_sidebar( 'download' );
	?>
</article>