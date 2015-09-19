<?php
/**
 * The template for displaying the footer
 */
?>

<?php do_action( 'trustedd_content_end' ); ?>

</div>

<?php do_action( 'trustedd_content_after' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">

		<?php do_action( 'trustedd_footer_start' ); ?>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="main-navigation" role="navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'     => 'primary-menu',
					 ) );
				?>
			</nav>
		<?php endif; ?>

		<div class="site-info">
			<?php
				do_action( 'trusted_footer' );
			?>

			<?php printf( __( 'Copyright &copy; %s, %s', 'trustedd' ), date('Y'), get_bloginfo( 'name' ) ); ?>
		</div>

		<?php do_action( 'trustedd_footer_end' ); ?>

	</footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
