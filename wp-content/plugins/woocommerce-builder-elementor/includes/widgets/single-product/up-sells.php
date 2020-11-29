<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Upsells_Widget extends DTWCBE_Product_Base {

	public function get_name() {
		return 'single-product-upsells';
	}

	public function get_title() {
		return esc_html__( 'Woo Product Upsells', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-upsell';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'upsells' , 'product' , 'single product' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_upsells',
			[
				'label' => esc_html__( 'Upsells', 'woocommerce' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'prefix_class' => 'woocommerce-builder-elementorducts-columns%s-',
				'default' => 4,
				'min' => 1,
				'max' => 12,
			]
		);
		
		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order by', 'woocommerce' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'rand',
				'options' => [
					'date' => esc_html__( 'Date', 'woocommerce' ),
					'title' => esc_html__( 'Title', 'woocommerce' ),
					'price' => esc_html__( 'Price', 'woocommerce' ),
					'popularity' => esc_html__( 'Popularity', 'woocommerce' ),
					'rating' => esc_html__( 'Rating', 'woocommerce' ),
					'rand' => esc_html__( 'Random', 'woocommerce' ),
					'menu_order' => esc_html__( 'Menu Order', 'woocommerce' ),
				],
			]
		);
		
		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'woocommerce' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'desc' => esc_html__( 'DESC', 'woocommerce' ),
					'asc' => esc_html__( 'ASC', 'woocommerce' ),
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'show_heading',
			[
				'label' => esc_html__( 'Heading', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_off' => esc_html__( 'Hide', 'elementor' ),
				'label_on' => esc_html__( 'Show', 'elementor' ),
				'default' => 'yes',
				'return_value' => 'yes',
				'prefix_class' => 'show-heading-',
			]
		);
		
		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}}.dtwcbe-elementor-wc-products .products > h2' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}.dtwcbe-elementor-wc-products .products > h2',
				'condition' => [
					'show_heading!' => '',
				],
			]
		);
		
		$this->add_responsive_control(
			'heading_text_align',
			[
				'label' => esc_html__( 'Text Align', 'elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}.dtwcbe-elementor-wc-products .products > h2' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);
		
		$this->add_responsive_control(
			'heading_spacing',
			[
				'label' => esc_html__( 'Spacing', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}}.dtwcbe-elementor-wc-products .products > h2' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);
		
		$this->end_controls_section();
		
		parent::_register_controls();
		
	}
	
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		$post_type = get_post_type();
			
		echo DTWCBE_Single_Product_Elementor::_render( $this->get_name(), $settings );
			
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Upsells_Widget());