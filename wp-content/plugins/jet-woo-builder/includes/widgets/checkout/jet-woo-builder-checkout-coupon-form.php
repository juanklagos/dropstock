<?php
/**
 * Class: Jet_Woo_Builder_Checkout_Coupon_Form
 * Name: Checkout Coupon Form
 * Slug: jet-checkout-coupon-form
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Checkout_Coupon_Form extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-checkout-coupon-form';
	}

	public function get_title() {
		return esc_html__( 'Checkout Coupon Form', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-checkout-coupon-form';
	}

	public function get_jet_help_url() {
		return '';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'checkout' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-checkout-coupon-form/css-scheme',
			array(
				'message' => '.woocommerce-form-coupon-toggle .woocommerce-info',
				'form'    => '.checkout_coupon.woocommerce-form-coupon',
				'input'   => '.checkout_coupon.woocommerce-form-coupon input.input-text',
				'button'  => '.checkout_coupon.woocommerce-form-coupon button.button',
			)
		);

		$this->start_controls_section(
			'checkout_coupon_form_heading',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'checkout_coupon_form_heading_notice_text',
			array(
				'label'       => esc_html__( 'Notice', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Have a coupon?', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type your notice here', 'jet-woo-builder' ),
			)
		);


		$this->add_control(
			'checkout_coupon_form_heading_link_text',
			array(
				'label'       => esc_html__( 'Show Coupon', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Click here to enter your code', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type your show coupon text here', 'jet-woo-builder' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_coupon_message_styles',
			array(
				'label' => esc_html__( 'Message', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'checkout_coupon_message_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['message'] . ', {{WRAPPER}} ' . $css_scheme['message'] . ' a',
			)
		);

		$this->add_control(
			'checkout_coupon_message_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['message'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'checkout_coupon_message_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['message'] . ':before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'checkout_coupon_message_link_color',
			array(
				'label'     => esc_html__( 'Link Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['message'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'checkout_coupon_message_link_hover_color',
			array(
				'label'     => esc_html__( 'Link Hover Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['message'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'checkout_coupon_message_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['message'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'checkout_coupon_message_border',
				'label'       => esc_html__( 'Border', 'jet-woo-builder' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['message'],
			)
		);

		$this->add_responsive_control(
			'checkout_coupon_message_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['message'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'checkout_coupon_message_margin',
			array(
				'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['message'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'checkout_coupon_message_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['message'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'checkout_coupon_message_align',
			array(
				'label'        => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'jet-woo-builder' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jet-woo-builder' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'jet-woo-builder' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['message'] => 'text-align: {{VALUE}}',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_coupon_form_styles',
			array(
				'label' => esc_html__( 'Form', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_form_style_controls( $this, 'checkout_coupon', $css_scheme['form'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_coupon_form_input_styles',
			array(
				'label' => esc_html__( 'Input', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_input_style_controls( $this, 'checkout_coupon_form', $css_scheme['input'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_coupon_form_button_styles',
			array(
				'label' => esc_html__( 'Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'checkout_coupon_form', $css_scheme['button'] );

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		add_filter( 'woocommerce_checkout_coupon_message', array( $this, 'get_custom_checkout_coupon_form_message' ) );

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

		remove_filter( 'woocommerce_checkout_coupon_message', array( $this, 'get_custom_checkout_coupon_form_message' ) );

	}

	/**
	 * Custom checkout coupon message.
	 *
	 * @return string
	 */
	public function get_custom_checkout_coupon_form_message() {

		$settings    = $this->get_settings_for_display();
		$format      = '%s <a href="#" class="showcoupon"> %s </a>';
		$notice      = ! empty( $settings['checkout_coupon_form_heading_notice_text'] ) ? $settings['checkout_coupon_form_heading_notice_text'] : 'Have a coupon?';
		$show_coupon = ! empty( $settings['checkout_coupon_form_heading_link_text'] ) ? $settings['checkout_coupon_form_heading_link_text'] : 'Click here to enter your code';

		return sprintf( $format, esc_html__( $notice, 'jet-woo-builder' ), esc_html__( $show_coupon, 'jet-woo-builder' ) );

	}
}
