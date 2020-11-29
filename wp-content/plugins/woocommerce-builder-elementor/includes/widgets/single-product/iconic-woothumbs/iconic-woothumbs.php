<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Woothumbs_Gallery_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'woocommerce-product-woothumbs-gallery';
	}

	public function get_title() {
		return esc_html__( 'Iconic WooThumbs - Awesome Product Imagery', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'woothumbs' , 'gallery' , 'Imagery', 'Imagery' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		if ( get_post_type() == 'product'  ) {
			echo do_shortcode(' [woothumbs-gallery] ');
		}
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Woothumbs_Gallery_Widget());