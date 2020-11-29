<?php
/**
 * Class: Jet_Woo_Builder_Cart_Table
 * Name: Cart Table
 * Slug: jet-cart-table
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

class Jet_Woo_Builder_Cart_Table extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-cart-table';
	}

	public function get_title() {
		return esc_html__( 'Cart Table', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-cart-table';
	}

	public function get_jet_help_url() {
		return '';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'cart' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-cart-table/css-scheme',
			array(
				'table'         => '.woocommerce-cart-form',
				'heading'       => '.shop_table.cart thead th',
				'cell'          => '.shop_table.cart tr.cart_item td',
				'image'         => '.shop_table.cart tr.cart_item td.product-thumbnail img',
				'title'         => '.shop_table.cart tr.cart_item td.product-name',
				'product_price' => '.shop_table.cart tr.cart_item td.product-price .amount',
				'total_price'   => '.shop_table.cart tr.cart_item td.product-subtotal .amount',
				'update_button' => '.shop_table.cart tr td.actions .button[name="update_cart"]',
				'coupon_button' => '.shop_table.cart td.actions .coupon .button',
				'remove_button' => '.shop_table.cart td.product-remove .remove',
				'input'         => '.shop_table.cart td.actions .coupon input.input-text',
				'label'         => '.shop_table.cart td.actions .coupon label',
				'product_count' => '.shop_table.cart td.product-quantity .quantity input.input-text',
			)
		);

		$this->start_controls_section(
			'cart_table_content',
			array(
				'label' => esc_html__( 'Manage Table', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'cart_table_items',
			array(
				'label'   => esc_html__( 'Table Item', 'jet-woo-builder' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'remove',
				'options' => array(
					'remove'    => esc_html__( 'Remove', 'jet-woo-builder' ),
					'thumbnail' => esc_html__( 'Image', 'jet-woo-builder' ),
					'name'      => esc_html__( 'Product Title', 'jet-woo-builder' ),
					'price'     => esc_html__( 'Price', 'jet-woo-builder' ),
					'quantity'  => esc_html__( 'Quantity', 'jet-woo-builder' ),
					'subtotal'  => esc_html__( 'Total', 'jet-woo-builder' ),
				)
			)
		);

		$repeater->add_control(
			'cart_table_heading_title',
			array(
				'label'       => esc_html__( 'Heading Title', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Product Title', 'jet-woo-builder' ),
			)
		);

		$repeater->add_control(
			'cart_table_cell_width',
			array(
				'label'      => esc_html__( 'Column Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .shop_table.shop_table_responsive.cart tr td{{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shop_table.shop_table_responsive.cart tr th{{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'cart_table_items_list',
			array(
				'label'       => esc_html__( 'Table Item List', 'jet-woo-builder' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'cart_table_items'         => 'remove',
						'cart_table_heading_title' => esc_html__( 'Remove', 'jet-woo-builder' ),
					),
					array(
						'cart_table_items'         => 'thumbnail',
						'cart_table_heading_title' => esc_html__( 'Thumbnail', 'jet-woo-builder' ),
					),
					array(
						'cart_table_items'         => 'name',
						'cart_table_heading_title' => esc_html__( 'Product Title', 'jet-woo-builder' ),
					),
					array(
						'cart_table_items'         => 'price',
						'cart_table_heading_title' => esc_html__( 'Price', 'jet-woo-builder' ),
					),
					array(
						'cart_table_items'         => 'quantity',
						'cart_table_heading_title' => esc_html__( 'Quantity', 'jet-woo-builder' ),
					),
					array(
						'cart_table_items'         => 'subtotal',
						'cart_table_heading_title' => esc_html__( 'Total', 'jet-woo-builder' ),
					)
				),
				'title_field' => '{{{ cart_table_heading_title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_action_controls',
			array(
				'label' => esc_html__( 'Action Controls', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'cart_table_show_update_button',
			array(
				'label'        => esc_html__( 'Show Update Cart Button', 'jet-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'cart_table_update_button_text',
			array(
				'label'       => esc_html__( 'Update Cart Button Text', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Update Cart', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Update Cart Button Text', 'jet-woo-builder' ),
				'condition'   => array(
					'cart_table_show_update_button' => 'yes',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'cart_table_show_coupon_form',
			array(
				'label'        => esc_html__( 'Show Coupon Form', 'jet-woo-builder' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-woo-builder' ),
				'label_off'    => esc_html__( 'No', 'jet-woo-builder' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before'
			)
		);

		$this->add_control(
			'cart_table_coupon_form_button_text',
			array(
				'label'       => esc_html__( 'Coupon Form Button Text', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Apply Coupon', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Apply Coupon Button Text', 'jet-woo-builder' ),
				'condition'   => array(
					'cart_table_show_coupon_form' => 'yes',
				),
				'label_block' => true,
			)
		);

		$this->add_control(
			'cart_table_coupon_form_placeholder_text',
			array(
				'label'       => esc_html__( 'Coupon Form Placeholder Text', 'jet-woo-builder' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Coupon Code', 'jet-woo-builder' ),
				'placeholder' => esc_html__( 'Coupon Code Placeholder Text', 'jet-woo-builder' ),
				'condition'   => array(
					'cart_table_show_coupon_form' => 'yes',
				),
				'label_block' => true,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_general_styles',
			array(
				'label' => esc_html__( 'General', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'cart_table_general_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_table_general_border',
				'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
			)
		);

		$this->add_responsive_control(
			'cart_table_general_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['table'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cart_table_general_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['table'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_heading_styles',
			array(
				'label' => esc_html__( 'Table Heading', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'cart_table_heading_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['heading'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'cart_table_heading_background',
				'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['heading'],
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cart_table_heading_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['heading'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_table_heading_border',
				'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['heading'],
			)
		);

		$this->add_responsive_control(
			'cart_table_heading_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['heading'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cart_table_heading_align',
			array(
				'label'        => esc_html__( 'Text Alignment', 'jet-woo-builder' ),
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
					'justify' => array(
						'title' => esc_html__( 'Justified', 'jet-woo-builder' ),
						'icon' => 'eicon-text-align-justify',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['heading'] => 'text-align: {{VALUE}}',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_cell_styles',
			array(
				'label' => esc_html__( 'Table Cells', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cart_table_cell_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['cell'],
			)
		);

		$this->add_control(
			'cart_table_cell_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cell'] => 'color: {{VALUE}}',
				),
			)
		);

		jet_woo_builder_common_controls()->register_table_cell_style_controls( $this, 'cart_table', $css_scheme['cell'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_product_image_styles',
			array(
				'label' => esc_html__( 'Image', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'cart_product_image_width',
			array(
				'label'      => esc_html__( 'Image Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => array(
					'px' => array(
						'min'  => 10,
						'max'  => 200,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 200,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 75,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cart_product_image_border',
				'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['image'],
			)
		);

		$this->add_responsive_control(
			'cart_product_image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cart_product_image_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_product_title_styles',
			array(
				'label' => esc_html__( 'Title', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'cart_table_product_title_typography',
				'label'     => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector'  => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->start_controls_tabs( 'cart_table_product_title_color_style_tabs' );

		$this->start_controls_tab(
			'cart_table_product_title_color_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'cart_table_product_title_normal_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['title'] . ' a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cart_table_product_title_color_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'cart_table_product_title_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] . ':hover'=> 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['title'] . ' a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_price_styles',
			array(
				'label' => esc_html__( 'Prices', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'cart_table_product_price_color',
			array(
				'label'     => esc_html__( 'Product Price Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['product_price'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cart_table_product_price_typography',
				'label'    => esc_html__( 'Product Price Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['product_price'],
			)
		);

		$this->add_control(
			'cart_table_total_price_color',
			array(
				'label'     => esc_html__( 'Total Price Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['total_price'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cart_table_total_price_typography',
				'label'    => esc_html__( 'Total Price Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['total_price'],
			)
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'cart_table_product_count_styles',
			array(
				'label' => esc_html__( 'Product Count', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_input_style_controls( $this, 'cart_table_product_count', $css_scheme['product_count'] );

		$this->add_responsive_control(
			'cart_table_product_count_input_width',
			array(
				'label'      => esc_html__( 'Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 40,
						'max' => 1000,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['product_count'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_remove_button_styles',
			array(
				'label' => esc_html__( 'Remove Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'archive_stars_font_size',
			array(
				'label'      => esc_html__( 'Font Size', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 60,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['remove_button'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'cart_table_remove', $css_scheme['remove_button'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_update_button_styles',
			array(
				'label' => esc_html__( 'Update Cart Button', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'cart_table_update', $css_scheme['update_button'] );

		$this->end_controls_section();

		$this->start_controls_section(
			'cart_table_apply_coupon_styles',
			array(
				'label' => esc_html__( 'Apply Coupon', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'cart_table_apply_coupon_button_title',
			array(
				'label'     => esc_html__( 'Button', 'jet-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
			)
		);

		jet_woo_builder_common_controls()->register_button_style_controls( $this, 'cart_table_apply_coupon', $css_scheme['coupon_button'] );

		$this->add_control(
			'cart_table_apply_coupon_label_title',
			array(
				'label'     => esc_html__( 'Label', 'jet-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cart_table_apply_coupon_label_typography',
				'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
			)
		);

		$this->add_control(
			'cart_table_apply_coupon_label_color',
			array(
				'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			)
		);



		$this->add_control(
			'cart_table_apply_coupon_input_title',
			array(
				'label'     => esc_html__( 'Input', 'jet-woo-builder' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		jet_woo_builder_common_controls()->register_input_style_controls( $this, 'cart_table_apply_coupon', $css_scheme['input'] );

		$this->add_control(
			'cart_table_apply_coupon_input_width',
			array(
				'label'      => esc_html__( 'Input Box Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					)
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['input'] => 'width: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';
		$settings        = $this->get_settings_for_display();
		$table_items     = isset( $settings['cart_table_items_list'] ) ? $settings['cart_table_items_list']: array();
		$table_buttons   = array(
			'update_cart_button'  => array(
				'enable'      => $settings['cart_table_show_update_button'],
				'button_text' => $settings['cart_table_update_button_text'],
			),
			'coupon_form'         => array(
				'enable'        => $settings['cart_table_show_coupon_form'],
				'button_text'   => $settings['cart_table_coupon_form_button_text'],
				'placeholder'   => $settings['cart_table_coupon_form_placeholder_text'],
			),
		);

		$this->__open_wrap();

		Jet_Woo_Builder_Shortcode_Cart::output( $atts = array(), $table_items, $table_buttons );
			
		$this->__close_wrap();

	}
}

/**
 * Class Jet_Woo_Builder_Shortcode_Cart
 * Used on the cart page, the cart shortcode displays the cart contents and interface for coupon codes and other cart
 * bits and pieces.
 *
 * @package WooCommerce/Shortcodes/Cart
 * @version 2.3.0
 */
class Jet_Woo_Builder_Shortcode_Cart extends \WC_Shortcode_Cart {

	public static function output( $atts = '', $table_items = array(), $table_buttons = array() ) {

		wc_maybe_define_constant( 'WOOCOMMERCE_CART', true );

		$atts        = shortcode_atts( array(), $atts, 'woocommerce_cart' );
		$nonce_value = wc_get_var( $_REQUEST['woocommerce-shipping-calculator-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) );

		if ( ! empty( $_POST['calc_shipping'] ) && ( wp_verify_nonce( $nonce_value, 'woocommerce-shipping-calculator' ) || wp_verify_nonce( $nonce_value, 'woocommerce-cart' ) ) ) {
			self::calculate_shipping();

			WC()->cart->calculate_totals();
		}

		do_action( 'woocommerce_check_cart_items' );

		WC()->cart->calculate_totals();

		if ( WC()->cart->is_empty() ) {
			wc_get_template( 'cart/cart-empty.php');
		} else {
			include jet_woo_builder()->plugin_path( 'templates/jet-cart-table/global/index.php' );
		}
	}

}
