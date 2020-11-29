<?php
/**
 * My Account Dashboard Template
 */

if ( ! is_user_logged_in() ) {
	return esc_html__( 'You need to logged in first', 'jet-woo-builder' );
}

wc_get_template( 'myaccount/dashboard.php', array(
	'current_user' => get_user_by( 'id', get_current_user_id() ),
) );