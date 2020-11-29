<?php
/**
 * My Account Order Template
 */

if ( ! is_user_logged_in() ) {
	return esc_html__( 'You need to logged in first', 'jet-woo-builder' );
}

global $wp;

if ( isset( $wp->query_vars['orders'] ) ) {

	$value = $wp->query_vars['orders'];
	do_action( 'woocommerce_account_orders_endpoint', $value );

} elseif ( isset( $wp->query_vars['view-order'] ) ) {

	$myaccount_url = get_permalink();
	$value = $wp->query_vars['view-order'];
	do_action( 'woocommerce_account_view-order_endpoint', $value );

}else{

	$value = '';
	do_action( 'woocommerce_account_orders_endpoint', $value );

}