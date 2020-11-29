<?php
/**
 * Class: Jet_Woo_Builder_Checkout_Billing
 * Name: Checkout Billing Form
 * Slug: jet-checkout-billing
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

class Jet_Woo_Builder_Checkout_Billing extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-checkout-billing';
	}

	public function get_title() {
		return esc_html__( 'Checkout Billing Form', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-checkout-billing-form';
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
			'jet-woo-builder/jet-checkout-billing/css-scheme',
			array(
				'heading' => '.woocommerce-billing-fields > h3',
				'label'   => '.woocommerce-billing-fields .form-row label',
				'input'   => '.elementor-jet-checkout-billing .form-row .woocommerce-input-wrapper > *:not(.woocommerce-password-strength):not(.woocommerce-password-hint):not(.show-password-input)',
			)
		);

		$this->start_controls_section(
			'checkout_billing_form_title',
			array(
				'label' => esc_html__( 'Content', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'checkout_billing_form_title_text',
			array(
				'label'       => esc_html__( 'Heading', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Billing details', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type your heading here', 'jet-woo-builder' ),
			)
		);

		if ( get_option('woocommerce_enable_guest_checkout') === 'yes' ) {
			$this->add_control(
				'checkout_billing_form_label_title_text',
				array(
					'label'       => esc_html__( 'Create Account Label', 'jet-woo-builder' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Create an account?', 'jet-woo-builder' ),
					'placeholder' => esc_html__( 'Type your label here', 'jet-woo-builder' ),
				)
			);
		}

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_billing_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'checkout_billing', $css_scheme['heading'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_billing_label_styles',
			array(
				'label' => esc_html__( 'Label', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_label_style_controls( $this, 'checkout_billing', $css_scheme['label'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_billing_input_styles',
			array(
				'label' => esc_html__( 'Input', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_input_style_controls( $this, 'checkout_billing', $css_scheme['input'] );

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

	}

}
