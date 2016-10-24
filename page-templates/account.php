<?php
/**
 * Template Name: Account
 *
 */

get_header();

?>

<div id="tabs">

	<?php themedd_post_header(); ?>

	<section class="container-fluid account mb-xs-4">
		<div class="wrapper">

			<?php
			/**
			 * Logout message
			 */
			if ( isset( $_GET['logout'] ) && $_GET['logout'] == 'success' ) { ?>
				<p class="alert notice">
					You have been successfully logged out
				</p>
			<?php } ?>

			<?php if ( ! is_user_logged_in() ) : ?>
				<div class="row center-xs">
					<div class="col-xs-12 col-sm-7">
						<?php echo edd_login_form(); ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( is_user_logged_in() ) : ?>
			<div class="row container-fluid">

				<div class="col-xs-12 col-md-2 account-nav">

					<ul>
					<?php foreach ( themedd_account_tabs() as $key => $tab ) : ?>
						<li>
							<a href="#tab-<?php echo $key; ?>"><?php echo $tab['tab_title']; ?></a>
						</li>
					<?php endforeach; ?>

					</ul>

					<?php do_action( 'themedd_account_tabs_after' ); ?>

				</div>

				<div class="col-xs-12 col-md-10 account-content">
					<div>

						<?php foreach ( themedd_account_tabs() as $key => $tab ) : ?>

						<div id="tab-<?php echo $key; ?>">
							<h2><?php echo $tab['tab_content_title']; ?></h2>
							<?php echo $tab['tab_content']; ?>
						</div>

						<?php endforeach; ?>

					</div>
				</div>

			</div>
			<?php endif; ?>
		</div>
	</section>

</div>
<?php
get_footer();
