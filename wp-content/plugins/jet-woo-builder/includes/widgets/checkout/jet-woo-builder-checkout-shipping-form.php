<?php
/**
 * Class: Jet_Woo_Builder_Checkout_Shipping_Form
 * Name: Checkout Shipping Form
 * Slug: jet-checkout-shipping-form
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

class Jet_Woo_Builder_Checkout_Shipping_Form extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-checkout-shipping-form';
	}

	public function get_title() {
		return esc_html__( 'Checkout Shipping Form', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-checkout-shipping-form';
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
			'jet-woo-builder/jet-checkout-shipping-form/css-scheme',
			array(
				'heading' => '.woocommerce-shipping-fields #ship-to-different-address',
				'label'   => '.shipping_address .woocommerce-shipping-fields__field-wrapper .form-row label',
				'input'   => '.shipping_address .woocommerce-shipping-fields__field-wrapper .form-row .woocommerce-input-wrapper > *',
			)
		);

		$this->start_controls_section(
			'checkout_shipping_form_title',
			array(
				'label' => esc_html__( 'Shipping Form', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'checkout_shipping_form_title_text',
			array(
				'label'       => esc_html__( 'Custom Title', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ship to a different address?', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Type your title here', 'jet-woo-builder' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_shipping_heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_heading_style_controls( $this, 'checkout_shipping', $css_scheme['heading'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_shipping_label_styles',
			array(
				'label' => esc_html__( 'Label', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_label_style_controls( $this, 'checkout_shipping', $css_scheme['label'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'checkout_shipping_input_styles',
			array(
				'label' => esc_html__( 'Input', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_input_style_controls( $this, 'checkout_shipping', $css_scheme['input'] );

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();

		include $this->__get_global_template( 'index' );

		$this->__close_wrap();

	}

}
