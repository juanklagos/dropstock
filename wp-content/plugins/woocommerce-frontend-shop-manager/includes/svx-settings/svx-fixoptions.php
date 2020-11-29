<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $GLOBALS['svx'] ) && version_compare( $GLOBALS['svx'], '1.3.8' ) == 0 ) :

if ( !class_exists( 'SevenVXFix' ) ) {

	class SevenVXFix {

		public static $version = '1.3.8';

		public static $plugins;
		public static $autoload;
		public static $std;
		public static $settings;
		public static $lang;

		public static function init() {
			$class = __CLASS__;
			new $class;
		}

		function __construct() {

			self::$autoload = get_option( 'svx_autoload' );

			self::$plugins = apply_filters( 'svx_plugins', array() );
			self::$std = apply_filters( 'svx_plugins_settings_short', array() );

			if ( self::$autoload === false ) {
				$this->fix_options();
			}

			foreach( self::$std as $plg ) {
				foreach( $plg['settings'] as $k => $v ) {
					if ( isset( $v['translate'] ) ) {
						$k = $k . self::language();
					}
					if ( $v['autoload'] === true ) {
						add_filter( 'pre_option_' . $k, __CLASS__ . '::auto_switch', 10, 2 );
					}
					else {
						add_filter( 'pre_option_' . $k, __CLASS__ . '::opt_switch', 10, 2 );
					}
				}
			}

		}

		public function refresh_plugin( $slug ) {
			$opt = get_option( 'svx_settings_' . $slug );
			if ( $opt !== false ) {
				foreach( $opt as $k => $v ) {
					self::$settings[$k] = $v;
				}
			}
		}

		public function refresh_autoload() {
			self::$autoload = get_option( 'svx_autoload', false );
		}

		public static function fix_options_plugin( $slug ) {
			$opt = array(
				'auto' => get_option( 'svx_autoload', array() )
			);

			foreach( self::$std[$slug]['settings'] as $k => $v ) {
				if ( $v['autoload'] === true ) {
					remove_filter( 'pre_option_' . $k, __CLASS__ . '::auto_switch', 10, 2 );
					$opt['auto'][$k] = get_option( $k );
					add_filter( 'pre_option_' . $k, __CLASS__ . '::auto_switch', 10, 2 );
				}
				else {
					remove_filter( 'pre_option_' . $k, __CLASS__ . '::opt_switch', 10, 2 );
					$opt['std'][$k] = get_option( $k );
					add_filter( 'pre_option_' . $k, __CLASS__ . '::opt_switch', 10, 2 );
				}
				delete_option( $k );
			}
			if ( isset( $opt['std'] ) ) {
				update_option( 'svx_settings_' . $slug, $opt['std'], false );
			}
			update_option( 'svx_autoload', $opt['auto'], true );
		}

		public function fix_options() {
			$opt = array();

			foreach( self::$std as $plg ) {
				foreach( $plg['settings'] as $k => $v ) {
					if ( $v['autoload'] === true ) {
						$opt['auto'][$k] = get_option( $k );
					}
					else {
						$opt['std'][$k] = get_option( $k );
					}
					delete_option( $k );
				}
				if ( isset( $opt['std'] ) ) {
					update_option( 'svx_settings_' . $plg['slug'], $opt['std'], false );
				}
			}
			if ( isset( $opt['auto'] ) ) {
				update_option( 'svx_autoload', $opt['auto'], true );
			}
		}

		public static function auto_switch( $replace, $option ) {

			if ( isset( self::$autoload[$option] ) ) {
				return self::$autoload[$option];
			}

			return false;

		}

		public static function check_plugin( $option ) {

			$slug = '';

			if ( substr( $option, 0, 17 ) == 'wc_settings_ivpa_' || substr( $option, 0, 18 ) == 'wc_ivpa_attribute_' ) {
				$slug = 'improved_options';
			}
			else if ( substr( $option, 0, 16 ) == 'wc_settings_isb_' || substr( $option, 0, 9 ) == 'wcmn_isb_' ) {
				$slug = 'improved_badges';
			}
			else if ( substr( $option, 0, 6 ) == 'wcwar_' ) {
				$slug = 'warranties_and_returns';
			}
			else if ( substr( $option, 0, 17 ) == 'wc_settings_wfsm_') {
				$slug = 'live_editor';
			}
			else if ( substr( $option, 0, 15 ) == 'wc_settings_spp' ) {
				$slug = 'share_print_pdf';
			}
			else if ( substr( $option, 0, 8 ) == 'wcmn_pl_' ) {
				$slug = 'product_loops';
			}
			else if ( substr( $option, 0, 9 ) == 'wcmn_seo_' ) {
				$slug = 'seo_for_woocommerce';
			}

			if ( $slug !== '' ) {
				$opt = get_option( 'svx_settings_' . $slug );
				if ( is_array( $opt ) ) {
					foreach( $opt as $k => $v ) {
						self::$settings[$k] = $v;
					}
				}
				else {
					self::fix_options_plugin( $slug );
				}
				return true;
			}

			return false;

		}

		public static function opt_switch( $replace, $option ) {
			if ( !isset( self::$settings[$option] ) || isset( self::$settings[$option] ) && self::$settings[$option] === false ) {
				$check = self::check_plugin( $option );
				if ( $check === true ) {
					if ( isset( self::$settings[$option] ) ) {
						return self::$settings[$option];
					}
				}
			}
			else {

				return self::$settings[$option];
			}

			return false;

		}

		public static function language() {
			if ( self::$lang ) {
				return self::$lang;
			}

			self::$lang = '';

			if ( class_exists( 'SitePress' ) ) {
				$default =  '_' . apply_filters( 'wpml_default_language', NULL );
				$language =  '_' . apply_filters( 'wpml_current_language', NULL );
				if ( $default !== $language ) {
					$doit = $language;
				}
			}

			if ( isset( $doit ) ) {
				self::$lang = $doit;
			}

			return self::$lang;
		}

	}

	function SevenVXFix() {
		return SevenVXFix::init();
	}

	SevenVXFix::init();

}

endif;

?>