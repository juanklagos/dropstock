<?php
/**
 * Handle JetWooBuilder ajax requests
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Builder_Ajax_Handlers' ) ) {

	/**
	 * Define Jet_Woo_Builder_Ajax_Handlers class
	 */
	class Jet_Woo_Builder_Ajax_Handlers {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Init Handler
		 */
		public function __construct() {

			//Ajax single add to cart
			if ( 'yes' === jet_woo_builder_shop_settings()->get( 'use_ajax_add_to_cart' ) ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'jet_woo_builder_ajax_single_add_to_cart_scripts' ), 99 );
			}

			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				add_action( 'wp_ajax_jet_woo_builder_get_layout', array( $this, 'get_switcher_template' ) );
				add_action( 'wp_ajax_nopriv_jet_woo_builder_get_layout', array( $this, 'get_switcher_template' ) );
			}

		}

		/**
		 * Enqueue single product ajax add to cart script
		 *
		 * @return void
		 */
		public function jet_woo_builder_ajax_single_add_to_cart_scripts() {

			wp_enqueue_script(
				'jet-woo-builder-ajax-single-add-to-cart',
				jet_woo_builder()->plugin_url( 'assets/js/ajax-single-add-to-cart.js' ),
				array( 'jquery' ),
				jet_woo_builder()->get_version(),
				true
			);

		}

		/**
		 * Processing switcher template ajax
		 *
		 * @return void
		 */
		public function get_switcher_template() {

			$args                = json_decode( stripslashes( $_POST['query'] ), true );
			$args['post_status'] = 'publish';
			$layout              = absint( $_POST['layout'] );
			$filters_query       = ! empty( $_POST['filters'] ) ? $_POST['filters'] : array();

			wc_setcookie( 'jet_woo_builder_layout', $layout, strtotime('+1 year') );

			if ( ! empty( $filters_query ) && function_exists( 'jet_smart_filters' ) ) {

				jet_smart_filters()->query->get_query_from_request( $filters_query );

				foreach ( jet_smart_filters()->query->_query as $key => $var ) {
					$args[$key] = $var;
				}

			}

			if ( ! class_exists( 'Elementor\Jet_Woo_Builder_Base' ) ) {
				require_once jet_woo_builder()->plugin_path( 'includes/base/class-jet-woo-builder-base.php' );
			}

			if ( ! class_exists( 'Elementor\Jet_Woo_Builder_Products_Loop' ) ) {
				require_once jet_woo_builder()->plugin_path( 'includes/widgets/shop/jet-woo-builder-products-loop.php' );
			}

			query_posts( $args );

			jet_woo_builder_integration_woocommerce()->current_template_archive = $layout;

			Elementor\Jet_Woo_Builder_Products_Loop::products_loop();

			die;

		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
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