<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Review_Order_Widget extends \Elementor\Widget_Base {

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
		return 'review-order';
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
		return esc_html__( 'Checkout Review Order', 'woocommerce-builder-elementor' );
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
		return [ 'dtwcbe-woo-checkout' ];
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
		// Heading
		$this->start_controls_section(
			'heading_style',
			array(
				'label' => esc_html__( 'Heading', 'elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'heading_typography',
				'label'     => esc_html__( 'Typography', 'elementor' ),
				'selector'  => '{{WRAPPER}} #order_review_heading',
			)
		);
		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #order_review_heading' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'heading_align',
			[
				'label'        => esc_html__( 'Alignment', 'elementor' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'prefix_class' => '',
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} #order_review_heading' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_thead_style',
			array(
				'label' => esc_html__( 'Table Head', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'thead_color',
			[
				'label'     => esc_html__( 'Head Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table thead' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'thead_typography',
				'label'     => esc_html__( 'Head Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-checkout-review-order-table thead th',
			)
		);
		$this->add_control(
			'thead_background',
			[
				'label'     => esc_html__( 'Head Background Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table thead' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'thead_border',
				'placeholder' => '1px',
				'default' => '0',
				'selector' => '{{WRAPPER}} .woocommerce-checkout-review-order-table thead tr th',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'thead_padding',
			[
				'label' => esc_html__( 'Head Padding', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table thead tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_trow_style',
			array(
				'label' => esc_html__( 'Table Body', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'trow_padding',
			[
				'label' => esc_html__( 'Table Body Item Padding', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'trow_color',
			[
				'label'     => esc_html__( 'Body Text Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table tbody' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'trow_typography',
				'label'     => esc_html__( 'Table Body Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-checkout-review-order-table tbody',
			)
		);
		$this->add_control(
			'trow_odd_background',
			[
				'label'     => esc_html__( 'Table Odd Rows Background Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table tbody tr:nth-child(odd)' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'trow_even_background',
			[
				'label'     => esc_html__( 'Table Even Rows Background Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table tbody tr:nth-child(even)' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'trow_border',
				'placeholder' => '1px',
				'default' => '0',
				'selector' => '{{WRAPPER}} .woocommerce-checkout-review-order-table tbody tr td',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_tfoot_style',
			array(
				'label' => esc_html__( 'Table Footer', 'woocommerce-builder-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'tfoot_padding',
			[
				'label' => esc_html__( 'Table Footer Item Padding', 'woocommerce-builder-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table tfoot tr td, {{WRAPPER}} .woocommerce-checkout-review-order-table tfoot tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tfoot_color',
			[
				'label'     => esc_html__( 'Table Footer Text Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table tfoot' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'tfoot_typography',
				'label'     => esc_html__( 'Table Footer Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-checkout-review-order-table tfoot',
			)
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'      => 'tfoot_th_typography',
				'label'     => esc_html__( 'Table Footer Header Cell Typography', 'woocommerce-builder-elementor' ),
				'selector'  => '{{WRAPPER}} .woocommerce-checkout-review-order-table tfoot th',
			)
		);
		$this->add_control(
			'tfoot_td_background',
			[
				'label'     => esc_html__( 'Table Footer Column Background Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table tfoot tr td' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tfoot_th_background',
			[
				'label'     => esc_html__( 'Table Footer Header Column Background Color', 'woocommerce-builder-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-checkout-review-order-table tfoot tr th' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'tfoot_border',
				'placeholder' => '1px',
				'default' => '0',
				'selector' => '{{WRAPPER}} .woocommerce-checkout-review-order-table tfoot tr td, {{WRAPPER}} .woocommerce-checkout-review-order-table tfoot tr th',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();


		if ( class_exists( 'Woocommerce_German_Market' ) ){
			// payment_methods
			$this->start_controls_section(
				'payment_style',
				array(
					'label' => esc_html__( 'Payment', 'woocommerce-builder-elementor' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array(
					'name'      => 'payment_typography',
					'label'     => esc_html__( 'Typography', 'elementor' ),
					'selector'  => '{{WRAPPER}} #payment',
				)
			);
			$this->add_control(
				'payment_color',
				[
					'label' => esc_html__( 'Color', 'elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} #payment' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_section();
			
			// Place order
			$this->start_controls_section(
				'place_order_style',
				array(
					'label' => esc_html__( 'Button', 'woocommerce-builder-elementor' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				)
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				array(
					'name'      => 'place_order_typography',
					'label'     => esc_html__( 'Typography', 'elementor' ),
					'selector'  => '{{WRAPPER}} #place_order',
				)
			);
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'place_order_border',
					'selector' => '{{WRAPPER}} #place_order',
					'exclude' => [ 'color' ],
				]
			);
			$this->add_responsive_control(
				'place_order_padding',
				[
					'label' => esc_html__( 'Padding', 'elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em' ],
					'selectors' => [
						'{{WRAPPER}} #place_order' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			/////
			$this->start_controls_tabs( 'place_order_style_tabs' );
			
			$this->start_controls_tab( 'place_order_style_normal',
				[
					'label' => esc_html__( 'Normal', 'woocommerce-builder-elementor' ),
				]
			);
			
			$this->add_control(
				'place_order_text_color',
				[
					'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} #place_order' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->add_control(
				'place_order_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} #place_order' => 'background-color: {{VALUE}}',
					],
				]
			);
			
			$this->add_control(
				'place_order_border_color',
				[
					'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} #place_order' => 'border-color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'place_order_box_shadow',
					'selector' => '{{WRAPPER}} #place_order',
				]
			);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab( 'place_order_style_hover',
				[
					'label' => esc_html__( 'Hover', 'woocommerce-builder-elementor' ),
				]
			);
			
			$this->add_control(
				'place_order_text_color_hover',
				[
					'label' => esc_html__( 'Text Color', 'woocommerce-builder-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} #place_order:hover' => 'color: {{VALUE}}',
					],
				]
			);
			
			$this->add_control(
				'place_order_bg_color_hover',
				[
					'label' => esc_html__( 'Background Color', 'woocommerce-builder-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} #place_order:hover' => 'background-color: {{VALUE}}',
					],
				]
			);
			
			$this->add_control(
				'place_order_border_color_hover',
				[
					'label' => esc_html__( 'Border Color', 'woocommerce-builder-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} #place_order:hover' => 'border-color: {{VALUE}}',
					],
				]
			);
			
			$this->add_group_control(
				\Elementor\Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'place_order_box_shadow_hover',
					'selector' => '{{WRAPPER}} #place_order:hover',
				]
			);
			
			$this->add_control(
				'place_order_transition',
				[
					'label' => esc_html__( 'Transition Duration', 'woocommerce-builder-elementor' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'default' => [
						'size' => 0.2,
					],
					'range' => [
						'px' => [
							'max' => 2,
							'step' => 0.1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} #place_order' => 'transition: all {{SIZE}}s',
					],
				]
			);
			
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

		}

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
		
		// Support German Market
		if ( class_exists( 'Woocommerce_German_Market' ) && get_option( 'woocommerce_de_secondcheckout', 'off' ) == 'off' ) { ?>

			<?php if ( get_option( 'gm_deactivate_checkout_hooks', 'off' ) == 'off' ) { ?>
				<h3 id="order_review_heading"><?php esc_html_e( 'Payment Method', 'woocommerce-german-market' ); ?></h3>
			<?php } else { ?>
				<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
			<?php } ?>

			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_de_checkout_payment' ); ?>
				
				<?php if ( get_option( 'gm_deactivate_checkout_hooks', 'off' ) == 'off' ) { ?>
					<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
				<?php } ?>
				
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>

		<?php } else { ?>
			<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php woocommerce_order_review(); ?>
			</div>
		<?php } ?>
		
		<?php do_action( 'woocommerce_checkout_after_order_review' );
	}
	
	protected function _content_template() {}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Review_Order_Widget());
