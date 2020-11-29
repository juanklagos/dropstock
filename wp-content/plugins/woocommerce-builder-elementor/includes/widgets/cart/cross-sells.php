<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Cross_Sells_Widget extends DTWCBE_Product_Base {

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
		return 'cross-sells';
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
		return esc_html__( 'Cross Sells', 'woocommerce-builder-elementor' );
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
		return 'eicon-woocommerce';
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
		return [ 'dtwcbe-woo-cart' ];
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
			'section_cross_sells',
			[
				'label' => esc_html__( 'Cross Sells', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'limit',
			[
				'label' => esc_html__( 'Limit', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 4,
				'min' => 1,
				'max' => 12,
			]
		);
		
		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'woocommerce' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'prefix_class' => 'elementor-products-columns%s-',
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
					'rand' => esc_html__( 'Random', 'woocommerce' ),
					'date' => esc_html__( 'Publish Date', 'woocommerce' ),
					'modified' => esc_html__( 'Modified Date', 'woocommerce' ),
					'title' => esc_html__( 'Alphabetic', 'woocommerce' ),
					'popularity' => esc_html__( 'Popularity', 'woocommerce' ),
					'rating' => esc_html__( 'Rate', 'woocommerce' ),
					'price' => esc_html__( 'Price', 'woocommerce' ),
				],
			]
		);
		
		$this->add_control(
			'order',
			[
				'label' => _x( 'Order', 'Sorting order', 'woocommerce' ),
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
					'{{WRAPPER}}.dtwcbe-elementor-wc-products .cross-sells > h2' => 'color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}}.dtwcbe-elementor-wc-products .cross-sells > h2',
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
					'{{WRAPPER}}.dtwcbe-elementor-wc-products .cross-sells > h2' => 'text-align: {{VALUE}}',
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
					'{{WRAPPER}}.dtwcbe-elementor-wc-products .cross-sells > h2' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_heading!' => '',
				],
			]
		);
		
		$this->end_controls_section();
		
		parent::_register_controls();
		
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
		$post_type = get_post_type(); 
			
		echo DTWCBE_Cart_Elementor::_render( $this->get_name(), $settings );
			
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Cross_Sells_Widget());
