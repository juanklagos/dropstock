<?php
/*
Plugin Name: Live Product Editor for WooCommerce
Plugin URI: https://xforwoocommerce.com
Description: XforWooCommerce Themes and Plugins! Visit https://xforwoocommerce.com
Author: 7VX LLC, USA CA
License: Codecanyon Split Licence
Version: 4.4.8
Requires at least: 4.5
Tested up to: 5.4.9
WC requires at least: 3.0.0
WC tested up to: 4.0.9
Author URI: https://xforwoocommerce.com
Text Domain: woocommerce-frontend-shop-manager
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !function_exists( 'XforWC' ) ) {
	require_once( 'includes/svx-settings/load.php' );

	if ( xforwccb() ) {	return false; }
}

$GLOBALS['svx'] = isset( $GLOBALS['svx'] ) && version_compare( $GLOBALS['svx'], '1.3.8') == 1 ? $GLOBALS['svx'] : '1.3.8';

if ( !class_exists( 'XforWC_Live_Editor' ) ) :

	final class XforWC_Live_Editor {

		public static $version = '4.4.8';

		protected static $_instance = null;

		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function __construct() {
			do_action( 'wfsm_loading' );

			$this->includes();

			if ( !function_exists( 'XforWC' ) ) {
				$this->single_plugin();
			}

			do_action( 'wfsm_loaded' );
		}

		private function single_plugin() {
			if ( is_admin() ) {
				register_activation_hook( __FILE__, array( $this, 'activate' ) );
			}

			add_action( 'init', array( $this, 'load_svx' ), 100 );

			//Legacy other plugins will be removed
			add_action( 'plugins_loaded', array( $this, 'fix_svx' ), 100 );

			// Texdomain only used if out of XforWC
			add_action( 'init', array( $this, 'textdomain' ), 0 );
		}

		public function activate() {
			if ( !class_exists( 'WooCommerce' ) ) {
				deactivate_plugins( plugin_basename( __FILE__ ) );

				wp_die( esc_html__( 'This plugin requires WooCommerce. Download it from WooCommerce official website', 'woocommerce-frontend-shop-manager' ) . ' &rarr; https://woocommerce.com' );
				exit;
			}
		}

		public function fix_svx() {
			include_once( 'includes/svx-settings/svx-fixoptions.php' );
		}

		public function load_svx() {
			if ( $this->is_request( 'admin' ) ) {
				include_once( 'includes/svx-settings/svx-settings.php' );
			}
		}

		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}

		public function includes() {

			if ( $this->is_request( 'admin' ) ) {

				include_once( 'includes/wfsm-settings.php' );

			}

			if ( $this->is_request( 'frontend' ) ) {
				$this->frontend_includes();
			}

		}

		public function frontend_includes() {
			include_once( 'includes/wfsm-frontend.php' );
		}

		public function textdomain() {

			$this->load_plugin_textdomain();

		}

		public function load_plugin_textdomain() {

			$domain = 'woocommerce-frontend-shop-manager';
			$dir = untrailingslashit( WP_LANG_DIR );
			$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

			if ( $loaded = load_textdomain( $domain, $dir . '/plugins/' . $domain . '-' . $locale . '.mo' ) ) {
				return $loaded;
			}
			else {
				load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
			}

		}

		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		public function plugin_basename() {
			return untrailingslashit( plugin_basename( __FILE__ ) );
		}

		public function ajax_url() {
			return admin_url( 'admin-ajax.php', 'relative' );
		}

		public function version() {
			return self::$version;
		}

		public function add_settings( $settings ) {

			if ( class_exists( 'XforWC_Live_Editor_Frontend' ) ) {

				if ( !empty( $settings ) && is_array( $settings ) ) {

					$opt_array = array();

					$i = 0;

					foreach( $settings as $setting ) {

						if ( !isset( $setting['name'] ) || !isset( $setting['settings'] ) ) {
							continue;
						}

						if ( is_array( $setting['settings'] ) ) {

							$opt_array[$i] = array(
								'name' => $setting['name']
							);

							foreach( $setting['settings'] as $option ) {
								if ( !isset( $option['key'] ) ) {
									continue;
								}

								$opt_array[$i]['key'][] = $option['key'];
								$opt_array[$i]['type'][] = isset( $option['type'] ) ? $option['type'] : 'input';
								$opt_array[$i]['setting-name'][] = isset( $option['setting-name'] ) ? $option['setting-name'] : esc_html__( 'Option', 'woocommerce-frontend-shop-manager' );
								$opt_array[$i]['options'][] = isset( $option['options'] ) ? $option['options'] : '';
								$opt_array[$i]['default'][] = isset( $option['default'] ) ? $option['default'] : '';
							}

						}
						$i++;

					}

					if ( !empty( $opt_array ) ) {
						if ( class_exists( 'XforWC_Live_Editor_Frontend' ) ) {
							XforWC_Live_Editor_Frontend::$settings['custom_settings'] = array_merge( XforWC_Live_Editor_Frontend::$settings['custom_settings'], $opt_array );
						}
						if ( class_exists( 'XforWC_Live_Editor_Settings' ) ) {
							XforWC_Live_Editor_Settings:$settings['custom_settings'] = array_merge( is_array(XforWC_Live_Editor_Settings::$settings['custom_settings'])?XforWC_Live_Editor_Settings::$settings['custom_settings']:array(), $opt_array );
						}
					}

				}

			}

			return;

		}

		public static function version_check( $version = '3.0.0' ) {
			if ( class_exists( 'WooCommerce' ) ) {
				global $woocommerce;
				if( version_compare( $woocommerce->version, $version, ">=" ) ) {
					return true;
				}
			}
			return false;
		}


	}

	add_filter( 'svx_plugins', 'svx_live_editor_add_plugin', 40 );
	add_filter( 'svx_plugins_settings_short', 'svx_live_editor_add_short' );

	function svx_live_editor_add_plugin( $plugins ) {

		$plugins['live_editor'] = array(
			'slug' => 'live_editor',
			'name' => esc_html__( 'Live Editor', 'woocommerce-frontend-shop-manager' )
		);

		return $plugins;

	}
	function svx_live_editor_add_short( $plugins ) {
		$plugins['live_editor'] = array(
			'slug' => 'live_editor',
			'settings' => array(
				'wc_settings_wfsm_logo' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_mode' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_style' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_archive_action' => array(
					'autoload' => true,
				),
				'wc_settings_wfsm_single_action' => array(
					'autoload' => true,
				),
				'wc_settings_wfsm_force_scripts' => array(
					'autoload' => true,
				),
				'wc_settings_wfsm_show_hidden_products' => array(
					'autoload' => true,
				),
				'wc_settings_wfsm_new_button' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_create_status' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_create_virtual' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_create_downloadable' => array(
					'autoload' => false,
				),
				'wfsm_settings_manager' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_vendor_max_products' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_default_permissions' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_custom_settings' => array(
					'autoload' => false,
				),
				'wc_settings_wfsm_vendor_groups' => array(
					'autoload' => false,
				),
			)
		);

		return $plugins;
	}

	function Wfsm() {
		return XforWC_Live_Editor::instance();
	}

	XforWC_Live_Editor::instance();

endif;

?>