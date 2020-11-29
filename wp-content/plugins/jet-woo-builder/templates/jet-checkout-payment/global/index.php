<?php
/**
 * Checkout Payment Template
 */

if ( ! is_ajax() ){
	do_action( 'woocommerce_review_order_before_payment' );
}

woocommerce_checkout_payment();

if ( ! is_ajax() ){
	do_action( 'woocommerce_review_order_after_payment' );
}
