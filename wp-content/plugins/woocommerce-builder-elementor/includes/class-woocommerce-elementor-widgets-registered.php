<?php
/**
 * DTWCBE_WooCommerce_Builder_Elementor_Widgets_Registered setup
 *
 * @package WooCommerce-Builder-Elementor
 *
 */

defined( 'ABSPATH' ) || exit;

class DTWCBE_WooCommerce_Builder_Elementor_Widgets_Registered{
	
	private static $_instance = null;
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct(){
		add_action( 'elementor/widgets/widgets_registered', array($this, 'init_widgets' ) );
	}
	
	public function init_widgets(){
		
		$widgets_manager = array(
			'global/breadcrumb.php',
			'global/woo-output-all-notices.php',
			'global/woo-customhook.php',
			
			'single-product/product-images.php',
			'single-product/title.php',
			'single-product/rating.php',
			'single-product/price.php',
			'single-product/short-description.php',
			'single-product/add-to-cart.php',
			'single-product/meta.php',
			'single-product/share.php',
			'single-product/tabs.php',
			'single-product/additional-information.php',
			'single-product/content.php',
			'single-product/reviews.php',
			'single-product/product-base.php',
			'single-product/related.php',
			'single-product/up-sells.php',
			'single-product/custom-key.php',
			
			'archive-product/archive-title.php',
			'archive-product/archive-description.php',
			'archive-product/archive-products.php',
			
			'cart/cart-table.php',
			'cart/cart-totals.php',
			'cart/cross-sells.php',
			'cart/empty-cart-message.php',
			'cart/return-to-shop.php',
			
			'checkout/form-login.php',
			'checkout/checkout_coupon_form.php',
			'checkout/form-billing.php',
			'checkout/form-additional.php',
			'checkout/form-shipping.php',
			'checkout/review-order.php',
			'checkout/payment.php',
			
			'thankyou/thankyou.php',
			'thankyou/order_details.php',
			'thankyou/customer_details.php',
			
			'myaccount/dashboard.php',
			'myaccount/orders.php',
			'myaccount/downloads.php',
			'myaccount/form-edit-address.php',
			'myaccount/form-edit-account.php',
			'myaccount/extra-endpoint.php',
			'myaccount/logout.php',
			
			'myaccount/form-login.php',
			'myaccount/form-register.php',
		);
		
		// Support WooCommerce Product Configurator by Iconic
		if ( class_exists( 'jckpc' ) ) {
			$widgets_manager[] = 'single-product/iconic-woo-product-configurator/iconic-woo-product-configurator.php';
		}
		// Support WooThumbs - Awesome Product Imagery by Iconic
		if ( class_exists( 'Iconic_WooThumbs' ) ) {
			$widgets_manager[] = 'single-product/iconic-woothumbs/iconic-woothumbs.php';
		}
		// Single product - WooCommerce Frontend Manager - WC Lovers
		if( class_exists('WCFM') ){
			$widgets_manager[] = 'single-product/wc-frontend-manager/wcfm-enquiry-button.php';
		}
		// Support WooCommerce Multivendor Marketplace - WC Lovers
		if ( class_exists( 'WCFMmp' ) ) {
			$widgets_manager[] = 'single-product/wc-multivendor-marketplace/wcfmmp-sold-by.php';
		}
		
		// Support German Market plugin
		if ( class_exists( 'Woocommerce_German_Market' ) ) {
			$widgets_manager[] = 'single-product/woocommerce-german-market/woocommerce_de_price_with_tax_hint_single.php';
		}
		
		// Support Germanized for WooCommerce plugin
		if ( class_exists( 'WooCommerce_Germanized' ) ) {
			$widgets_manager[] = 'single-product/woocommerce-germanized/price-unit.php';
			if ( get_option( 'woocommerce_gzd_display_product_detail_tax_info' ) == 'yes' || get_option( 'woocommerce_gzd_display_product_detail_shipping_costs' ) == 'yes' ){
				$widgets_manager[] = 'single-product/woocommerce-germanized/legal-info.php';
			}
			if ( get_option( 'woocommerce_gzd_display_product_detail_delivery_time' ) == 'yes' ){
				$widgets_manager[] = 'single-product/woocommerce-germanized/delivery-time-info.php';
			}
		}
		// Single product - Support WooCommerce Simple Auction plugin
		if ( class_exists( 'WooCommerce_simple_auction' ) ) {
			$widgets_manager[] = 'single-product/woocommerce-simple-auctions/auction-bid.php';
			$widgets_manager[] = 'single-product/woocommerce-simple-auctions/auction-pay.php';
		}
		/*
		 * Support WooCommerce Memberships
		 * Sell memberships that provide access to restricted content, products, discounts, and more!
		 * By: WooCommerce
		 * Author: SkyVerge
		 * Author URI: https://www.woocommerce.com/
		 */
		if ( class_exists( 'WC_Memberships_Loader' ) ) {
			$widgets_manager[] = 'single-product/woocommerce-memberships/purchasing-discount-message.php';
			$widgets_manager[] = 'single-product/woocommerce-memberships/purchasing-restricted-message.php';
			$widgets_manager[] = 'myaccount/woocommerce-memberships/memberships.php';
		}
		if ( class_exists( 'WC_Bookings' ) ) {
			$widgets_manager[] = 'myaccount/woocommerce-bookings/bookings.php';
		}
		if ( class_exists( 'WC_Subscriptions' ) ) {
			$widgets_manager[] = 'myaccount/woocommerce-subscriptions/subscriptions.php';
		}
		//Support WooCommerce Points and Rewards by WooCommerce
		if ( class_exists( 'WC_Points_Rewards' ) ) {
			$widgets_manager[] = 'myaccount/woocommerce-points-and-rewards/woocommerce-points-and-rewards.php';
		}
		//Support YITH WooCommerce Wishlist plugin
		if ( defined( 'YITH_WCWL' ) ) {
			$widgets_manager[] = 'single-product/yith/wishlist.php';
		}
		if ( defined( 'YITH_WOOCOMPARE' ) ) {
			$widgets_manager[] = 'single-product/yith/compare.php';
		}
		
		$isTheme = get_option( 'template' );
		if( $isTheme == 'thegem' ){
			$widgets_manager[] = 'single-product/thegem-product-description.php';
			$widgets_manager[] = 'single-product/thegem-product-navigation.php';
			$widgets_manager[] = 'single-product/thegem-product-content.php';
		}
		
		foreach ($widgets_manager as $widget){
			require_once( __DIR__ . '/widgets/'.$widget );
		}
		
	}
}

DTWCBE_WooCommerce_Builder_Elementor_Widgets_Registered::instance();