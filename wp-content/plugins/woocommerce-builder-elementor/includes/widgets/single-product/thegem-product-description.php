<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_thegem_product_description_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'woocommerce-thegem-product-description';
	}

	public function get_title() {
		return esc_html__( 'TheGem Product Description', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'TheGem', 'Description' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		if( !is_product() ) { return ''; }
		global $product, $post;
		
		echo wpautop(do_shortcode(get_post_meta($post->ID, 'thegem_product_description', true)));
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_thegem_product_description_Widget());