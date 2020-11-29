<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Woo_Customhook_Widget extends \Elementor\Widget_Base {

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
		return 'woo-custom-hook';
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
		return esc_html__( 'Woo Custom Hook', 'woocommerce' );
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
		return [ 'dtwcbe-woo-general' ];
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
			'section_customhook',
			[
				'label' => esc_html__( 'Custom Hook', 'elementor' ),
				'tab' => Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'wc_customhook_warning',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Add a custom_hook for your action hook, the plugin or theme action hook. e.g. your_woocommerce_custom_hook. It will be used for do_action( "your_woocommerce_custom_hook" )', 'woocommerce-builder-elementor' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);
		$this->add_control(
			'custom_hook',
			[
				'label' => esc_html__( 'Custom Hook', 'woocommerce-builder-elementor' ),
				'type' => Elementor\Controls_Manager::TEXT,
				'placeholder' => esc_html( 'custom_hook' ),
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
		/**
		 * Hook: wcf_woocommerce_custom_hook.
		 *
		 */
		$Hook = strip_tags($settings['custom_hook']);
		if($Hook)
			do_action( "{$Hook}" );
		
	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Woo_Customhook_Widget());
