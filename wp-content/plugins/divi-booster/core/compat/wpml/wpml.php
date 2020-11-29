<?php

add_action('wpml_st_loaded', 'DBDB_wpml::init');

if (!class_exists('DBDB_wpml')) {
	class DBDB_wpml {
		
		static function init() {
			add_action('dbdb_compile_patch_files_after', 'DBDB_wpml::generate_translated_cache_files', 10, 2);
			add_filter('dbdb_cachedir', 'DBDB_wpml::set_cachedir_language');
			add_filter('dbdb_cacheurl', 'DBDB_wpml::set_cacheurl_language');
		}

		static function set_cachedir_language($cachedir) {
			if (!is_admin() && self::wpml_active()){
				$lang = self::current_language();
				if (!empty($lang)) {
					$cachedir .= $lang.'/';
					return $cachedir;
				}
			}
			return $cachedir;
		}

		static function set_cacheurl_language($cacheurl) {
			if (!is_admin() && self::wpml_active()){
				$lang = self::current_language();
				if (!empty($lang)) {
					$url = new DBDB_url($cacheurl);
					$path = $url->path().$lang.'/';
					$result = $url->setPath($path)->url();
					return $result;
				}
			}
			return $cacheurl;
		}

		static function generate_translated_cache_files($plugin, $files) {
			if (self::wpml_active()){
				$original_language = self::current_language();		
				foreach(self::active_languages() as $code=>$data) {
					self::set_language($code);
					foreach($files as $in=>$out) {
						$content = $plugin->patch_file_content($out, $in);
						$lang_dir = $plugin->cachedir()."/{$code}";
						wp_mkdir_p($lang_dir);
						file_put_contents($lang_dir."/{$out}", $content);
					}
				}
				self::set_language($original_language);
			}
		}
		
		private static function active_languages() {
			$result = apply_filters('wpml_active_languages', array());
			return is_array($result)?$result:array();
		}

		private static function set_language($code) {
			global $sitepress;
			if (!empty($code) && isset($sitepress) && is_callable(array($sitepress, 'switch_lang'))) {
				$sitepress->switch_lang($code);
			}
		}

		private static function current_language() {
			return apply_filters('wpml_current_language', false);
		}

		private static function wpml_active() {
			return apply_filters('wpml_setting', false, 'setup_complete');
		}
	}
}
