<?php
/**
 * WooCommerce Page Builder For Elementor Template functions
 *
 * Functions for the templating system.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function dtwpb_woocommerce_account_view_order_backorder( $myaccount_url ){
	?>
	<h2><a href="<?php echo esc_url($myaccount_url); ?>" title="<?php echo apply_filters('woocommerce_account_view_order_backorder', esc_html__('Back to Order list', 'woocommerce-builder-elementor')); ?>"><?php echo apply_filters('woocommerce_account_view_order_backorder', esc_html__('Back to Order list', 'woocommerce-builder-elementor')); ?></a></h2>
	<?php
}