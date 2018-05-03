<?php
/**
 * The template for displaying the footer
 */
?>

	<?php do_action( 'themedd_content_end' ); ?>

	</div>

	<?php do_action( 'themedd_content_after' ); ?>

	<footer id="colophon" class="site-footer py-4" role="contentinfo">
		<?php do_action( 'themedd_footer' ); ?>
	</footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
