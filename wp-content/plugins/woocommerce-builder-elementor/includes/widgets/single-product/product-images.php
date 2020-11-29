<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_Image_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'single-product-images';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Woo Product Images', 'woocommerce-builder-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-images';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'image', 'product', 'gallery', 'lightbox' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_control(
			'wc_style_warning',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'The style of this widget is often affected by your theme and plugins. If you experience any such issue, try to switch to a basic theme and deactivate related plugins.', 'elementor' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'sale_flash',
			[
				'label' => esc_html__( 'Sale Flash', 'elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'elementor' ),
				'label_off' => esc_html__( 'Hide', 'elementor' ),
				'render_type' => 'template',
				'return_value' => 'yes',
				'default' => 'yes',
				'prefix_class' => '',
			]
		);
		$this->add_control(
			'sale_flash_top',
			[
				'label' => esc_html__( 'Top', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'.woocommerce {{WRAPPER}} span.onsale' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'sale_flash!' => '',
				],
			]
		);
		$this->add_control(
			'sale_flash_left',
			[
				'label' => esc_html__( 'Left', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'selectors' => [
					'.woocommerce {{WRAPPER}} span.onsale' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'sale_flash!' => '',
				],
			]
		);

		$this->add_control(
			'heading_gallery_style',
			[
				'label' => esc_html__( 'Gallery', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'product_gallery_type',
			[
				'label' => esc_html__( 'Gallery Style', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Theme default', 'woocommerce-builder-elementor' ),
					'gallery-slider' => esc_html__( 'Gallery Slider', 'woocommerce-builder-elementor' ),
				],
				'default' => '',
			]
		);
		
		$this->add_control(
			'gallery_slider_style',
			[
				'label' => esc_html__( 'Gallery Slider Style', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'woocommerce-builder-elementor' ),
					'vertical' => esc_html__( 'Vertical', 'woocommerce-builder-elementor' ),
				],
				'default' => 'horizontal',
				'condition' => [
					'product_gallery_type' => 'gallery-slider',
				],
			]
		);
		
		$this->add_control(
			'gallery_thumbs_vertical',
			[
				'label' => esc_html__( 'Gallery Thumbnails Style', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Left', 'elementor' ),
					'right' => esc_html__( 'Right', 'elementor' ),
				],
				'default' => 'left',
				'condition' => [
					'product_gallery_type' => 'gallery-slider',
					'gallery_slider_style' => 'vertical',
				],
			]
		);
		
		$this->add_control(
			'thumbs_show',
			[
				'label' => esc_html__( 'Thumbnails to show', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 4,
				'condition' => [
					'product_gallery_type' => 'gallery-slider',
				],
			]
		);
		
		$this->add_control(
			'heading_image_style',
			[
				'label' => esc_html__( 'Image', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '.woocommerce {{WRAPPER}} .woocommerce-product-gallery__trigger + .woocommerce-product-gallery__wrapper,
				.woocommerce {{WRAPPER}} .flex-viewport, .woocommerce {{WRAPPER}} .flex-control-thumbs img',
				'separator' => 'before',
			]
		);
		
		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .woocommerce-product-gallery__trigger + .woocommerce-product-gallery__wrapper,
					.woocommerce {{WRAPPER}} .flex-viewport' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);
		
		$this->add_control(
			'heading_thumbs_style',
			[
				'label' => esc_html__( 'Thumbnails', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'thumbs_border',
				'selector' => '.woocommerce {{WRAPPER}} .flex-control-thumbs img, .woocommerce-product-gallery #product-thumbnails-carousel .slick-slide:hover img, .woocommerce-product-gallery #product-thumbnails-carousel .slick-current img',
			]
		);
		
		$this->add_responsive_control(
			'thumbs_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'.woocommerce {{WRAPPER}} .flex-control-thumbs img, .woocommerce-product-gallery #product-thumbnails-carousel .slick-slide:hover img, .woocommerce-product-gallery #product-thumbnails-carousel .slick-current img'
					=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);
		
		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		echo DTWCBE_Single_Product_Elementor::_render( $this->get_name(), $settings );
	}
	
	protected function _content_template() {
		
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_Image_Widget());