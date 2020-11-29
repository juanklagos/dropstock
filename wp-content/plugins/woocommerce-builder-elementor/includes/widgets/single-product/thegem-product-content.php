<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_thegem_product_content_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'woocommerce-thegem-product-content';
	}

	public function get_title() {
		return esc_html__( 'TheGem Product Content', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'TheGem' , 'Content' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		if( !is_product() ) { return ''; }
		global $product, $post;
		
		thegem_woocommerce_single_product_page_content();
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_thegem_product_content_Widget());