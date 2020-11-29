<?php
if (!defined('ABSPATH')) { exit(); } // No direct access

add_filter('wp_nav_menu_objects', 'db105_add_location_class_to_menu', 10, 2);

if (!function_exists('db105_add_location_class_to_menu')) {
	function db105_add_location_class_to_menu($menu_items, $args) {
		if (is_array($menu_items)) {
			foreach($menu_items as $item) {
				if (isset($args->theme_location) && isset($item->classes) && is_array($item->classes)) {
					$item->classes[] = 'dbdb_'.$args->theme_location;
				}
			}
		}
		return $menu_items;
	}
}