<?php
/**
 * JetWooBuilder Elementor common controls class
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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Builder_Common_Controls' ) ) {

	/**
	 * Define Jet_Woo_Builder_Parser class
	 */
	class Jet_Woo_Builder_Common_Controls {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.7.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Init common controls.
		 */
		public function __construct() {
		}

		/**
		 * Register button widgets style controls
		 *
		 * @param $obj
		 * @param $css_scheme
		 * @since 1.7.0
		 */
		public function register_button_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_button_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_button_padding',
				array(
					'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->start_controls_tabs( $id . '_button_style_tabs' );

			$obj->start_controls_tab(
				$id . '_button_normal_styles',
				array(
					'label' => esc_html__( 'Normal', 'jet-woo-builder' ),
				)
			);

			$obj->add_control(
				$id . '_button_normal_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'color: {{VALUE}} !important',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'     => $id . '_button_normal_background',
					'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_button_normal_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_button_normal_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->start_controls_tab(
				$id . '_button_hover_styles',
				array(
					'label' => esc_html__( 'Hover', 'jet-woo-builder' ),
				)
			);

			$obj->add_control(
				$id . '_button_hover_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme . ':hover' => 'color: {{VALUE}} !important',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'     => $id . '_button_hover_background',
					'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme . ':hover',
				)
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_button_hover_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme . ':hover',
				)
			);

			$obj->add_responsive_control(
				$id . '_button_hover_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->end_controls_tab();

			$obj->end_controls_tabs();

		}

		/**
		 * Register heading widgets style controls
		 *
		 * @param $obj
		 * @param $css_scheme
		 * @since 1.7.0
		 */
		public function register_heading_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_heading_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_control(
				$id . '_heading_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_heading_margin',
				array(
					'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_heading_align',
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
						'{{WRAPPER}} ' . $css_scheme => 'text-align: {{VALUE}}',
					),
					'classes'   => 'elementor-control-align',
				)
			);

		}

		/**
		 * Register input widgets style controls
		 *
		 * @param $obj
		 * @param $css_scheme
		 * @since 1.7.0
		 */
		public function register_input_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_input_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_control(
				$id . '_input_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'color: {{VALUE}}',
						'{{WRAPPER}} .select2-container .select2-selection .select2-selection__rendered' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'     => $id . '_input_background',
					'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme . ', {{WRAPPER}} .select2-container .select2-selection',
				)
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_input_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_input_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_input_margin',
				array(
					'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_input_padding',
				array(
					'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme                                                  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .select2-container .select2-selection .select2-selection__arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		}

		/**
		 * Register label widgets style controls
		 *
		 * @param $obj
		 * @param $css_scheme
		 * @since 1.7.0
		 */
		public function register_label_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_label_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_control(
				$id . '_label_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_control(
				$id . '_label_required_color',
				array(
					'label'     => esc_html__( 'Required Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme . ' abbr' => 'color: {{VALUE}}',
						'{{WRAPPER}} ' . $css_scheme . ' .required' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_label_margin',
				array(
					'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_label_align',
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
						'justify' => array(
							'title' => esc_html__( 'Justified', 'jet-woo-builder' ),
							'icon' => 'eicon-text-align-justify',
						),
					),
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme => 'text-align: {{VALUE}}',
					),
					'classes'   => 'elementor-control-align',
				)
			);

		}

		/**
		 * Register form widgets style controls
		 *
		 * @param $obj
		 * @param $css_scheme
		 * @since 1.7.0
		 */
		public function register_form_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $id . '_form_typography',
					'label'    => esc_html__( 'Typography', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme . ' p',
				)
			);

			$obj->add_control(
				$id . '_form_text_color',
				array(
					'label'     => esc_html__( 'Color', 'jet-woo-builder' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} ' . $css_scheme . ' p' => 'color: {{VALUE}}',
					),
				)
			);

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'     => $id . '_form_background',
					'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_form_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_form_border_radius',
				array(
					'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_form_margin',
				array(
					'label'      => esc_html__( 'Margin', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_form_padding',
				array(
					'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

		}

		/**
		 * Register table cell widgets style controls
		 *
		 * @param $obj
		 * @param $css_scheme
		 * @since 1.7.0
		 */
		public function register_table_cell_style_controls( $obj, $id, $css_scheme ) {

			$obj->add_group_control(
				Group_Control_Background::get_type(),
				array(
					'name'     => $id . '_cell_background',
					'label'    => esc_html__( 'Background', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_group_control(
				Group_Control_Border::get_type(),
				array(
					'name'     => $id . '_cell_border',
					'label'    => esc_html__( 'Border', 'jet-woo-builder' ),
					'selector' => '{{WRAPPER}} ' . $css_scheme,
				)
			);

			$obj->add_responsive_control(
				$id . '_cell_padding',
				array(
					'label'      => esc_html__( 'Padding', 'jet-woo-builder' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => array( 'px', 'em', '%' ),
					'selectors'  => array(
						'{{WRAPPER}} ' . $css_scheme => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					),
				)
			);

			$obj->add_responsive_control(
				$id . '_cell_align',
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
						'{{WRAPPER}} ' . $css_scheme => 'text-align: {{VALUE}}',
					),
					'classes'   => 'elementor-control-align',
				)
			);

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.7.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

	}

}

/**
 * Returns instance of Jet_Woo_Builder_Common_Controls
 *
 * @since 1.7.0
 * @return object
 */
function jet_woo_builder_common_controls() {
	return Jet_Woo_Builder_Common_Controls::get_instance();
}
