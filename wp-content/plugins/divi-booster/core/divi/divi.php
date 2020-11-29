<?php // Divi / theme functions

if (!function_exists('dbdb_css_selector')) {
	function dbdb_css_selector($key) {
		$selectors = array(
			'page_layout_select_box' => '#et_settings_meta_box select#et_pb_page_layout'
		);
		return isset($selectors[$key])?$selectors[$key]:false;
	}
}

// Alternative to WP's __return_false() - can be used with remove_filter without affecting other plugins
if (!function_exists('dbdb_return_false')) {
	function dbdb_return_false() {
		return false;
	}
}

// Safe wrapper for et_get_option
if (!function_exists('dbdb_et_get_option')) {
	function dbdb_et_get_option($option_name, $default_value='') {
		return function_exists('et_get_option')?et_get_option($option_name, $default_value):$default_value;
	}
}

if (!function_exists('dbdb_is_divi_2_4_up')) {
	function dbdb_is_divi_2_4_up() { 
		return dbdb_is_divi('2.3.9', '>='); // Include 2.3.9 as it was beta version of 2.4 functionality
	}
}

if (!function_exists('dbdb_is_divi')) {
	function dbdb_is_divi($version=false, $comparison='==') {
		return (dbdb_theme_name() === 'Divi' && (!$version || dbdb_theme_version($version, $comparison)));
	}
}

if (!function_exists('dbdb_is_extra')) {
	function dbdb_is_extra($version=false, $comparison='==') {
		return (dbdb_theme_name() === 'Extra' && (!$version || dbdb_theme_version($version, $comparison)));
	}
}

if (!function_exists('dbdb_theme_version')) {
	function dbdb_theme_version($version=false, $comparison='==') {
		$theme = wp_get_theme(get_template());
		$theme_version = $theme->get('Version');
		return $version?version_compare($theme_version, $version, $comparison):$theme_version;
	}
}

if (!function_exists('dbdb_theme_name')) {
	function dbdb_theme_name() {
		
		// Check template name
		$template = get_template();
		if (strpos($template, 'Divi') !== false) { 
			return 'Divi'; 
		}
		if (strpos($template, 'Extra') !== false) { 
			return 'Extra'; 
		}
		
		// Check theme name
		$theme = wp_get_theme($template);
		if (isset($theme->Name)) {
			if (strpos($theme->Name, 'Divi') !== false) { 
				return 'Divi'; 
			}
			if (strpos($theme->Name, 'Extra') !== false) { 
				return 'Extra'; 
			}
			return $theme->Name;
		}
		
		return false;
	}
}

// Wrapper for ET_Builder_Module::set_style
if (!function_exists('dbdb_set_module_style')) {
	function dbdb_set_module_style($module_slug, $style) {
		if (is_callable('ET_Builder_Module::set_style')) {
			ET_Builder_Module::set_style($module_slug, $style);
		}
	}
}