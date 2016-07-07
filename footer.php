<?php
/**
 * The template for displaying the footer
 */
?>

<?php do_action( 'themedd_content_end' ); ?>

</div>

<?php do_action( 'themedd_content_after' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php do_action( 'themedd_footer_start' ); ?>

		<?php if ( has_nav_menu( 'primary' ) && apply_filters( 'themedd_footer_primary_menu', true ) ) : ?>
			<nav class="main-navigation" role="navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'     => 'primary-menu',
					 ) );
				?>
			</nav>
		<?php endif; ?>

		<?php do_action( 'themedd_footer_before_site_info' ); ?>

		<section class="site-info">
			<div class="wrapper">
				<?php do_action( 'themedd_credits' ); ?>
			</div>
		</section>

		<?php do_action( 'themedd_footer_end' ); ?>

	</footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
