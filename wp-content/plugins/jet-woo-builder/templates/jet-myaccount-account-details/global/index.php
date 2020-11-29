<?php
/**
 * My Account Details Template
 */

if ( ! is_user_logged_in() ) {
	return esc_html__( 'You need to logged in first', 'jet-woo-builder' );
}

do_action('woocommerce_account_edit-account_endpoint');