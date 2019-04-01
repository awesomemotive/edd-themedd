<?php
/**
 * The template for displaying the Affiliate Area.
 */

get_header();
themedd_header(
	array(
		'header_classes' => array( 'page-header', 'text-sm-center' ),
	)
);
?>
<div id="primary" class="content-area<?php echo themedd_primary_classes(); ?>">
	<main id="main" class="site-main" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="container">
		<?php if ( is_user_logged_in() && affwp_is_affiliate() ) : ?>
			<?php the_content(); ?>
		<?php else: ?>
		<section class="affwp-login-register">
			<?php the_content(); ?>
		</section>
		<?php endif; ?>
		</div>
	<?php endwhile; ?>
	</main>
</div>
<?php get_footer(); ?>
