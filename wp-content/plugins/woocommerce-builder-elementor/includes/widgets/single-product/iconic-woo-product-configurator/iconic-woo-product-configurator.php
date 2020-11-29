<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_iconic_wpc_gallery_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'woocommerce-product-iconic-wpc-gallery';
	}

	public function get_title() {
		return esc_html__( 'Iconic Product Configurator Image', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'Iconic' , 'Product' , 'Configurator', 'Image' ];
	}

	protected function _register_controls(){
		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'zoom_img',
			[
				'label' => esc_html__( 'Hover Zoom effect', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'elementor' ),
				'label_off' => esc_html__( 'No', 'elementor' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'prefix_class' => '',
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		if ( get_post_type() == 'product'  ) {
			$settings = $this->get_settings_for_display();
			$class = 'dtwcbe-iconic-pc-images '; 
			$class .= ($settings['zoom_img'] == 'yes' ? '' : 'no-zoom_img');
			$html = '<div class="'.$class.'">';
			ob_start();
			echo do_shortcode(' [iconic-wpc-gallery] ');
			$html .= ob_get_clean();
			$html .= '</div>';
			
			return $html;
		}
		
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_iconic_wpc_gallery_Widget());