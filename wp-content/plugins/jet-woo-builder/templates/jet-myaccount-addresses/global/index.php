<?php
/**
 * My Account Addresses Template
 */

if ( ! is_user_logged_in() ) {
	return esc_html__( 'You need to logged in first', 'jet-woo-builder' );
}

global $wp;

$type = '';

if( isset( $wp->query_vars['edit-address'] ) ) {
	$type = wc_edit_address_i18n( sanitize_title( $wp->query_vars['edit-address'] ), true );
}

echo '<div class="my-accouunt-form-edit-address">';
	WC_Shortcode_My_Account::edit_address( $type );
echo '</div>';