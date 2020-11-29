<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_wcfmmp_sold_by_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'woocommerce-product-wcfmmp-sold-_by';
	}

	public function get_title() {
		return esc_html__( 'WC Multivendor Marketplace Show Sold by', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'Multivendor' , 'Marketplace' , 'Sold by' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		if( !is_product() ) { return ''; }
		
		if( !class_exists('WCFMmp') ){
			return '';
		}
		/**
		 * Show Sold by at Single Product Page
		 * WCFMmp_Frontend -> wcfmmp_sold_by_single_product
		 */
		global $WCFM, $WCFMmp, $product;
			
		if( !apply_filters( 'wcfmmp_is_allow_single_product_sold_by', true ) ) return;
			
		if( $WCFMmp->wcfmmp_vendor->is_vendor_sold_by() ) {
			$product_id = $product->get_id();
				
			$vendor_sold_by_template = $WCFMmp->wcfmmp_vendor->get_vendor_sold_by_template();
				
			if( $vendor_sold_by_template == 'tab' ) {
					
			} elseif( $vendor_sold_by_template == 'advanced' ) {
				$WCFMmp->template->get_template( 'sold-by/wcfmmp-view-sold-by-advanced.php', array( 'product_id' => $product_id ) );
			} else {
				$WCFMmp->template->get_template( 'sold-by/wcfmmp-view-sold-by-simple.php', array( 'product_id' => $product_id ) );
			}
		}
		
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_wcfmmp_sold_by_Widget());