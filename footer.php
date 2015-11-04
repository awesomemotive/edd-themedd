<?php
/**
 * The template for displaying the footer
 */
?>

<?php do_action( 'trustedd_content_end' ); ?>

</div>

<?php do_action( 'trustedd_content_after' ); ?>

	<footer id="colophon" class="site-footer col-xs-12" role="contentinfo">

		<?php do_action( 'trustedd_footer_start' ); ?>

		<?php if ( has_nav_menu( 'primary' ) && apply_filters( 'trusted_footer_primary_menu', true ) ) : ?>
			<nav class="main-navigation" role="navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'     => 'primary-menu',
					 ) );
				?>
			</nav>
		<?php endif; ?>

		<?php do_action( 'trustedd_footer_before_site_info' ); ?>

		<div class="wrapper full-width site-info">
			<?php do_action( 'trusted_credits' ); ?>

			<?php printf( __( 'Copyright &copy; %s, %s', 'trustedd' ), date('Y'), get_bloginfo( 'name' ) ); ?>
		</div>

		<?php do_action( 'trustedd_footer_end' ); ?>

	</footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
