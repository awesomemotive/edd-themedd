<?php
global $affwp_login_redirect;
affiliate_wp()->login->print_errors();
?>

<form id="affwp-login-form" class="affwp-form" action="" method="post">
	<?php
	/**
	 * Fires at the top of the affiliate login form template
	 */
	do_action( 'affwp_affiliate_login_form_top' );
	?>

	<fieldset>
		<legend class="mb-4"><?php _e( 'Log into your account', 'affiliate-wp' ); ?></legend>

		<?php
		/**
		 * Fires immediately prior to the affiliate login form template fields.
		 */
		do_action( 'affwp_login_fields_before' );
		?>

		<div class="form-group">
			<label for="affwp-login-user-login"><?php _e( 'Username', 'affiliate-wp' ); ?></label>
			<input id="affwp-login-user-login" class="required form-control form-control-lg" type="text" name="affwp_user_login" title="<?php esc_attr_e( 'Username', 'affiliate-wp' ); ?>" />
		</div>

		<div class="form-group">
			<label for="affwp-login-user-pass"><?php _e( 'Password', 'affiliate-wp' ); ?></label>
			<input id="affwp-login-user-pass" class="password required form-control form-control-lg" type="password" name="affwp_user_pass" />
			<p class="mt-2 small affwp-lost-password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'affiliate-wp' ); ?></a>
			</p>
		</div>

		<div class="form-group custom-control custom-checkbox">
			<input id="affwp-user-remember" class="custom-control-input" type="checkbox" name="affwp_user_remember" value="1" />
			<label class="affwp-user-remember custom-control-label" for="affwp-user-remember"><?php _e( 'Remember Me', 'affiliate-wp' ); ?></label>
		</div>

		<div class="form-group">
			<input type="hidden" name="affwp_redirect" value="<?php echo esc_url( $affwp_login_redirect ); ?>"/>
			<input type="hidden" name="affwp_login_nonce" value="<?php echo wp_create_nonce( 'affwp-login-nonce' ); ?>" />
			<input type="hidden" name="affwp_action" value="user_login" />
			<input type="submit" class="btn btn-primary btn-lg" value="<?php esc_attr_e( 'Log In', 'affiliate-wp' ); ?>" />
		</div>

		<?php
		/**
		 * Fires immediately after the affiliate login form template fields.
		 */
		do_action( 'affwp_login_fields_after' );
		?>
	</fieldset>

	<?php
	/**
	 * Fires at the bottom of the affiliate login form template (inside the form element).
	 */
	do_action( 'affwp_affiliate_login_form_bottom' );
	?>
</form>
