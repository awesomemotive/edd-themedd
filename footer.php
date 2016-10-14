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
