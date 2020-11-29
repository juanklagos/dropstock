<?php
/**
 * Class: Jet_Woo_Builder_Archive_Add_To_Cart
 * Name: Add To Cart
 * Slug: jet-woo-builder-archive-add-to-cart
 */

namespace Elementor;

use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Jet_Woo_Builder_Archive_Add_To_Cart extends Jet_Woo_Builder_Base {

	private $source = false;

	public function get_name() {
		return 'jet-woo-builder-archive-add-to-cart';
	}

	public function get_title() {
		return esc_html__( 'Add to Cart', 'jet-woo-builder' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-add-to-cart';
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/woocommerce-jetwoobuilder-settings-how-to-create-and-set-a-custom-categories-archive-template/';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'archive' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-archive-add-to-cart/css-scheme',
			array(
				'wrapper' => '.jet-woo-builder-archive-add-to-cart',
				'button'  => '.jet-woo-builder-archive-add-to-cart .button',
			)
		);

		$this->start_controls_section(
			'section_archive_add_to_cart_style',
			array(
				'label'      => esc_html__( 'Add To Cart', 'jet-woo-builder' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'        => 'archive_add_to_cart_typography',
				'scheme'      => Scheme_Typography::TYPOGRAPHY_4,
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
				'placeholder' => '1px',
			)
		);

		$this->add_responsive_control(
			'button_width',
			array(
				'label'      => esc_html__( 'Button Width', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'%',
					'px',
				),
				'range'      => array(
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
					'px' => array(
						'min' => 50,
						'max' => 1000,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_archive_add_to_cart_style' );

		$this->start_controls_tab(
			'tab_archive_add_to_cart_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_add_to_cart_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}};',
				),

			)
		);

		$this->add_control(
			'archive_add_to_cart_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_add_to_cart_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_archive_add_to_cart_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_add_to_cart_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_background_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'archive_add_to_cart_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_add_to_cart_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_archive_add_to_cart_added',
			array(
				'label' => esc_html__( 'Added', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_add_to_cart_disabled_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.added' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_background_disabled_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.added' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_added_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.added' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} ' . $css_scheme['button'] . '.added' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_add_to_cart_added_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . '.added',
			)
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_archive_add_to_cart_loading',
			array(
				'label' => esc_html__( 'Loading', 'jet-woo-builder' ),
			)
		);

		$this->add_control(
			'archive_add_to_cart_loading_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.loading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_background_loading_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.loading' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'archive_add_to_cart_loading_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'jet-woo-builder' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . '.loading' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'archive_add_to_cart_loading_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . '.loading',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'archive_add_to_cart_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
				'separator'   => 'before'

			)
		);

		$this->add_control(
			'archive_add_to_cart_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'archive_add_to_cart_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before'
			)
		);

		$this->add_responsive_control(
			'archive_add_to_cart_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
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
					'{{WRAPPER}} ' . $css_scheme['wrapper'] => 'text-align: {{VALUE}};',
				),
				'classes'   => 'elementor-control-align',
			)
		);

		$this->end_controls_section();

	}

	/**
	 * Returns CSS selector for nested element
	 *
	 * @param  [type] $el [description]
	 *
	 * @return [type]     [description]
	 */
	public function css_selector( $el = null ) {
		return sprintf( '{{WRAPPER}} .%1$s %2$s', $this->get_name(), $el );
	}

	public static function render_callback( $settings = array() ) {
		global $product;

		if ( ! is_a( $product, 'WC_Product' ) ) {
			return;
		}
		
		$ajax_add_to_cart_enabled = 'yes' === get_option( 'woocommerce_enable_ajax_add_to_cart' ) ? true : false;
		$popup_enable = ! empty( $settings['jet_woo_builder_cart_popup'] ) ? esc_attr( $settings['jet_woo_builder_cart_popup'] ) : false;
		$popup_id     = ! empty( $settings['jet_woo_builder_cart_popup_template'] ) ? esc_attr( $settings['jet_woo_builder_cart_popup_template'] ) : '';

		$args['class'] = implode(
			' ',
			array_filter(
				array(
					'button',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() && $ajax_add_to_cart_enabled ? 'ajax_add_to_cart' : '',
				)
			)
		);
		
		if ( $popup_enable ) {
			echo '<div class="jet-woo-builder-archive-add-to-cart" data-cart-popup-enable=' . json_encode( $popup_enable ) . ' data-cart-popup-id=' . $popup_id . ' >';
		} else {
			echo '<div class="jet-woo-builder-archive-add-to-cart">';
		}
		woocommerce_template_loop_add_to_cart( $args );
		echo '</div>';

	}

	protected function render() {
		$this->__open_wrap();

		$settings = $this->get_settings();
		$settings = apply_filters( 'jet-woo-builder/jet-woo-archive-add-to-cart/settings', $settings, $this );
		
		$macros_settings = array(
			'jet_woo_builder_cart_popup'          => json_encode( ! empty( $settings['jet_woo_builder_cart_popup'] ) ? esc_attr( $settings['jet_woo_builder_cart_popup'] ) : false ),
			'jet_woo_builder_cart_popup_template' => ! empty( $settings['jet_woo_builder_cart_popup_template'] ) ? esc_attr( $settings['jet_woo_builder_cart_popup_template'] ) : '',
		);

		if ( jet_woo_builder_tools()->is_builder_content_save() ) {
			echo jet_woo_builder()->parser->get_macros_string( $this->get_name(), $macros_settings );
		} else {
			echo self::render_callback( $macros_settings );
		}

		$this->__close_wrap();
	}

}
