<?php
/**
 * Plugin Name: JetWooBuilder For Elementor
 * Plugin URI:  https://crocoblock.com/plugins/jetwoobuilder/
 * Description: Your perfect asset in creating WooCommerce page templates using loads of special widgets & stylish page layouts
 * Version:     1.7.2
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * Text Domain: jet-woo-builder
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 * WC tested up to: 4.6
 * WC requires at least: 3.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Jet_Woo_Builder` doesn't exists yet.
if ( ! class_exists( 'Jet_Woo_Builder' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 */
	class Jet_Woo_Builder {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		private $version = '1.7.2';

		/**
		 * Holder for base plugin URL
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_url = null;

		/**
		 * Holder for base plugin path
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_path = null;

		/**
		 * Plugin properties
		 */
		public $module_loader;

		/**
		 * [$documents description]
		 * @var [type]
		 */
		public $documents;

		/**
		 * [$parser description]
		 * @var [type]
		 */
		public $parser;

		/**
		 * [$macros description]
		 * @var [type]
		 */
		public $macros;

		/**
		 * [$ajax_handlers description]
		 * @var null
		 */
		public $ajax_handlers = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {

			// Load the core functions/classes required by the rest of the plugin.
			add_action( 'after_setup_theme', array( $this, 'module_loader' ), - 20 );

			// Check if Elementor installed and activated.
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
				return;
			}

			// Check that WooCommerce active.
			add_action( 'plugins_loaded', array( $this, 'woocommerce_loaded' ) );

			// Internationalize the text strings used.
			add_action( 'init', array( $this, 'lang' ), - 999 );

			// Load files.
			add_action( 'init', array( $this, 'init' ), - 999 );

			// Jet Dashboard Init
			add_action( 'init', array( $this, 'jet_dashboard_init' ), -999 );

			// Register activation and deactivation hook.
			register_activation_hook( __FILE__, array( $this, 'activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
		}

		/**
		 * Load plugin framework
		 */
		public function module_loader() {

			require $this->plugin_path( 'includes/modules/loader.php' );

			$this->module_loader = new Jet_Woo_Builder_CX_Loader(
				array(
					$this->plugin_path( 'includes/modules/interface-builder/cherry-x-interface-builder.php' ),
					$this->plugin_path( 'includes/modules/post-meta/cherry-x-post-meta.php' ),
					$this->plugin_path( 'includes/modules/db-updater/cherry-x-db-updater.php' ),
					$this->plugin_path( 'includes/modules/vue-ui/cherry-x-vue-ui.php' ),
					$this->plugin_path( 'includes/modules/jet-dashboard/jet-dashboard.php' ),
					$this->plugin_path( 'includes/modules/jet-elementor-extension/jet-elementor-extension.php' ),
				)
			);
		}

		/**
		 * Returns plugin version
		 *
		 * @return string
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * Manually init required modules.
		 *
		 * @return void
		 */
		public function init() {
			if ( class_exists( 'WooCommerce' ) ) {

				$this->load_files();

				jet_woo_builder_assets()->init();
				jet_woo_builder_integration()->init();
				jet_woo_builder_integration_woocommerce()->init();
				jet_woo_builder_post_type()->init();
				jet_woo_builder_settings()->init();
				jet_woo_builder_shortocdes()->init();
				jet_woo_builder_shop_settings()->init();
				jet_woo_builder_compatibility()->init();
				jet_woo_builder_elementor_views()->init();

				$this->documents     = new Jet_Woo_Builder_Documents();
				$this->parser        = new Jet_Woo_Builder_Parser();
				$this->macros        = new Jet_Woo_Builder_Macros();
				$this->ajax_handlers = new Jet_Woo_Builder_Ajax_Handlers();

				if ( is_admin() ) {

					//Init JetWooBuilder Settings
					new \Jet_Woo_Builder\Settings();

					// Init DB upgrader
					require $this->plugin_path( 'includes/class-jet-woo-builder-db-upgrader.php' );

					jet_woo_builder_db_upgrader()->init();
				}

				//Init Rest Api
				new \Jet_Woo_Builder\Rest_Api();
			}
		}

		/**
		 * [jet_dashboard_init description]
		 * @return [type] [description]
		 */
		public function jet_dashboard_init() {

			if ( is_admin() ) {

				$jet_dashboard_module_data = $this->module_loader->get_included_module_data( 'jet-dashboard.php' );

				$jet_dashboard = \Jet_Dashboard\Dashboard::get_instance();

				$jet_dashboard->init( array(
					'path'           => $jet_dashboard_module_data['path'],
					'url'            => $jet_dashboard_module_data['url'],
					'cx_ui_instance' => array( $this, 'jet_dashboard_ui_instance_init' ),
					'plugin_data'    => array(
						'slug'         => 'jet-woo-builder',
						'file'         => 'jet-woo-builder/jet-woo-builder.php',
						'version'      => $this->get_version(),
						'plugin_links' => array(
							array(
								'label'  => esc_html__( 'Go to settings', 'jet-woo-builder' ),
								'url'    => add_query_arg( array( 'page' => 'jet-dashboard-settings-page', 'subpage' => 'jet-woo-builder-general-settings' ), admin_url( 'admin.php' ) ),
								'target' => '_self',
							),
						),
					),
				) );
			}
		}

		/**
		 * [jet_dashboard_ui_instance_init description]
		 * @return [type] [description]
		 */
		public function jet_dashboard_ui_instance_init() {
			$cx_ui_module_data = $this->module_loader->get_included_module_data( 'cherry-x-vue-ui.php' );

			return new CX_Vue_UI( $cx_ui_module_data );
		}

		/**
		 * Check that WooCommerce active
		 */
		function woocommerce_loaded() {

			if ( ! class_exists( 'WooCommerce' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_woocommerce_plugin' ] );

				return;
			}
		}

		/**
		 * [admin_notice_missing_main_plugin description]
		 * @return [type] [description]
		 */
		public function admin_notice_missing_main_plugin() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$elementor_link = sprintf(
				'<a href="%1$s">%2$s</a>',
				admin_url() . 'plugin-install.php?s=elementor&tab=search&type=term',
				'<strong>' . esc_html__( 'Elementor', 'jet-woo-builder' ) . '</strong>'
			);
			$message = sprintf(
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'jet-woo-builder' ),
				'<strong>' . esc_html__( 'JetWooBuilder', 'jet-woo-builder' ) . '</strong>',
				$elementor_link
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

			if ( ! class_exists( 'WooCommerce' ) ) {
				$woocommerce_link = sprintf(
					'<a href="%1$s">%2$s</a>',
					admin_url() . 'plugin-install.php?s=woocommerce&tab=search&type=term',
					'<strong>' . esc_html__( 'WooCommerce', 'jet-woo-builder' ) . '</strong>'
				);
				$message = sprintf(
					esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'jet-woo-builder' ),
					'<strong>' . esc_html__( 'JetWooBuilder', 'jet-woo-builder' ) . '</strong>',
					$woocommerce_link
				);
				printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
			}
		}
		/**
		 * [admin_notice_missing_main_plugin description]
		 * @return [type] [description]
		 */
		public function admin_notice_missing_woocommerce_plugin() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$woocommerce_link = sprintf(
				'<a href="%1$s">%2$s</a>',
				admin_url() . 'plugin-install.php?s=woocommerce&tab=search&type=term',
				'<strong>' . esc_html__( 'WooCommerce', 'jet-woo-builder' ) . '</strong>'
			);
			$message = sprintf(
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'jet-woo-builder' ),
				'<strong>' . esc_html__( 'JetWooBuilder', 'jet-woo-builder' ) . '</strong>',
				$woocommerce_link
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/**
		 * Check if theme has elementor
		 *
		 * @return boolean
		 */
		public function has_elementor() {
			return defined( 'ELEMENTOR_VERSION' );
		}

		/**
		 * Returns Elementor instance
		 *
		 * @return object
		 */
		public function elementor() {
			return \Elementor\Plugin::$instance;
		}

		/**
		 * Returns utility instance
		 *
		 * @return object
		 */
		public function utility() {
			$utility = $this->get_core()->modules['cherry-utility'];

			return $utility->utility;
		}

		/**
		 * Load required files.
		 *
		 * @return void
		 */
		public function load_files() {
			require $this->plugin_path( 'includes/class-jet-woo-builder-ajax-handler.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-assets.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-tools.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-post-type.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-documents.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-parser.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-macros.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-common-controls.php' );

			require $this->plugin_path( 'includes/components/elementor-views/manager.php' );

			require $this->plugin_path( 'includes/integrations/base/class-jet-woo-builder-integration.php' );
			require $this->plugin_path( 'includes/integrations/base/class-jet-woo-builder-integration-woocommerce.php' );

			require $this->plugin_path( 'includes/class-jet-woo-builder-template-functions.php' );
			require $this->plugin_path( 'includes/class-jet-woo-builder-shortcodes.php' );

			require $this->plugin_path( 'includes/settings/manager.php' );
			require $this->plugin_path( 'includes/settings/class-jet-woo-builder-settings.php' );
			require $this->plugin_path( 'includes/settings/class-jet-woo-builder-shop-settings.php' );

			require $this->plugin_path( 'includes/lib/compatibility/class-jet-woo-builder-compatibility.php' );

			require $this->plugin_path( 'includes/rest-api/rest-api.php' );
			require $this->plugin_path( 'includes/rest-api/endpoints/base.php' );
			require $this->plugin_path( 'includes/rest-api/endpoints/plugin-settings.php' );
		}

		/**
		 * Returns path to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 *
		 * @return string
		 */
		public function plugin_path( $path = null ) {

			if ( ! $this->plugin_path ) {
				$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path . $path;
		}

		/**
		 * Returns url to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 *
		 * @return string
		 */
		public function plugin_url( $path = null ) {

			if ( ! $this->plugin_url ) {
				$this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
			}

			return $this->plugin_url . $path;
		}

		/**
		 * Loads the translation files.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function lang() {
			load_plugin_textdomain( 'jet-woo-builder', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'jet-woo-builder/template-path', 'jet-woo-builder/' );
		}

		/**
		 * Returns path to template file.
		 *
		 * @return string|bool
		 */
		public function get_template( $name = null ) {

			$template = locate_template( $this->template_path() . $name );

			if ( ! $template ) {
				$template = $this->plugin_path( 'templates/' . $name );
			}

			if ( file_exists( $template ) ) {
				return $template;
			} else {
				return false;
			}
		}

		/**
		 * Compare WooCommerce version with your version
		 *
		 * @param string $version
		 *
		 * @return bool
		 */
		public static function wc_version_check( $version = '3.6' ) {

			if ( class_exists( 'WooCommerce' ) ) {
				global $woocommerce;

				if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
					return true;
				}
			}

			return false;
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function activation() {}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function deactivation() {}

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

if ( ! function_exists( 'jet_woo_builder' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function jet_woo_builder() {
		return Jet_Woo_Builder::get_instance();
	}
}

jet_woo_builder();
