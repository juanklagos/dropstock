<?php
/**
 * Class: Jet_Woo_Builder_Single_Images
 * Name: Single Images
 * Slug: jet-single-images
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

class Jet_Woo_Builder_Single_Images extends Jet_Woo_Builder_Base {

	public function get_name() {
		return 'jet-single-images';
	}

	public function get_title() {
		return esc_html__( 'Single Images', 'jet-woo-builder' );
	}

	public function get_script_depends() {
		return array( 'flexslider', 'zoom', 'wc-single-product' );
	}

	public function get_icon() {
		return 'jet-woo-builder-icon-images';
	}

	public function get_jet_help_url() {
		return 'https://crocoblock.com/knowledge-base/articles/jetwoobuilder-how-to-create-and-set-a-single-product-page-template/';
	}

	public function get_categories() {
		return array( 'jet-woo-builder' );
	}

	public function show_in_panel() {
		return jet_woo_builder()->documents->is_document_type( 'single' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-woo-builder/jet-single-images/css-scheme',
			array(
				'images'               => '.jet-woo-builder .jet-single-images__wrap div.images',
				'main_image'           => '.jet-woo-builder .jet-single-images__wrap .woocommerce-product-gallery > .flex-viewport',
				'thumbnails_wrapper'   => '.jet-woo-builder .jet-single-images__wrap .flex-control-thumbs',
				'thumbnails_h_wrapper' => '.jet-woo-builder .jet-single-images__wrap:not(.jet-single-images-nav-vertical) .flex-control-thumbs',
				'thumbnails'           => '.jet-woo-builder .jet-single-images__wrap .flex-control-thumbs > li',
				'thumbnails_img'       => '.jet-woo-builder .jet-single-images__wrap .flex-control-thumbs > li > img'
			)
		);

		$this->start_controls_section(
			'section_single_main_image_style',
			array(
				'label' => esc_html__( 'Main Image', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'main_image_description',
			array(
				'raw'             => esc_html__( 'This controls works only with main gallery image.', 'jet-woo-builder' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_control(
			'main_image_background_color',
			array(
				'label' => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['main_image']  => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'main_image_width',
			array(
				'label'      => esc_html__( 'Images Block Width (%)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 100,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['images'] => 'width: {{SIZE}}% !important; float: none !important;',
				),
			)
		);

		$this->add_responsive_control(
			'main_image_margin',
			array(
				'label'      => __( 'Margin', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['main_image'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'main_image_border',
				'selector' => '{{WRAPPER}} ' . $css_scheme['main_image'],
			)
		);

		$this->add_responsive_control(
			'main_image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['main_image'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'main_image_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['main_image'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_single_image_thumbnails_style',
			array(
				'label' => esc_html__( 'Thumbnails', 'jet-woo-builder' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'control_nav_direction',
			array(
				'label'     => esc_html__( 'Direction:', 'jet-woo-builder' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'horizontal',
				'options'   => array(
					'vertical'   => esc_html__( 'Vertical', 'jet-woo-builder' ),
					'horizontal' => esc_html__( 'Horizontal', 'jet-woo-builder' ),
				),
			)
		);

		$this->add_control(
			'control_nav_v_position',
			array(
				'label'     => esc_html__( 'Position :', 'jet-woo-builder' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => array(
					'left'  => array(
						'title' => esc_html__( 'Start', 'jet-woo-builder' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
					),
					'right' => array(
						'title' => esc_html__( 'End', 'jet-woo-builder' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
					),
				),
				'condition' => array(
					'control_nav_direction' => 'vertical'
				),
			)
		);

		$this->add_control(
			'image_thumbnails_background_color',
			array(
				'label' => esc_html__( 'Background Color', 'jet-woo-builder' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnails'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'image_thumbnails_width',
			array(
				'label'      => esc_html__( 'Thumbnails Width (%)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 11,
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnails'] => 'width: {{SIZE}}%;',
				),
			)
		);

		$this->add_responsive_control(
			'image_thumbnails_padding',
			array(
				'label'      => __( 'Padding(%)', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnails']         => 'padding: {{TOP}}% {{RIGHT}}% {{BOTTOM}}% {{LEFT}}%; margin:0!important;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_thumbnails_border',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnails_img'],
			)
		);

		$this->add_responsive_control(
			'image_thumbnails_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-woo-builder' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnails_img'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_thumbnails_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['thumbnails_img'],
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		global $product;

		$product = wc_get_product();

		if ( empty( $product ) ) {
			return;
		}

		if ( true === $this->__set_editor_product() ) {
			$this->__open_wrap();
			include $this->__get_global_template( 'index' );
			$this->__close_wrap();
			$this->__reset_editor_product();
		}

		// On render widget from Editor - trigger the init manually.
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) { ?>
			<script>
				jQuery( '.woocommerce-product-gallery' ).each( function() {
					jQuery( this ).wc_product_gallery();
				} );
			</script>
		<?php
		}
	}
}
