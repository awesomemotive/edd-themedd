<?php
/**
 * The template for displaying the footer
 */
?>

<?php do_action( 'trustedd_content_end' ); ?>

</div>

<?php do_action( 'trustedd_content_after' ); ?>

	<footer id="footer">
		<div class="wrapper aligncenter">
			<section class="section copyright">
				<div class="wrapper">
					<?php printf( __( 'Copyright &copy; %s, %s', 'trustedd' ), date('Y'), get_bloginfo( 'name' ) ); ?>
				</div>
			</section>
		</div>
	</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>
