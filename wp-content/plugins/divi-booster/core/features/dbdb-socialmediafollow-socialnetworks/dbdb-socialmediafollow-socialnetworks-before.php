<?php

add_filter('dbdbsmsn_networks', 'dbdbsmsn_remove_built_in_networks');
add_filter('dbdbsmsn_add_social_media_follow_fields', 'dbdbsmsn_sort_network_options');

// Load socicon locally, overriding external load in -main.php
if (!function_exists('dbdbsmsn_load_socicon')) {
	function dbdbsmsn_load_socicon() { 
		wp_enqueue_style('dbdb-icons-socicon'); 
		add_action('wp_footer', 'dbdb_icons_socicon_inline_css');
	}
}

// Get full list of social networks
if (!function_exists('dbdbsmsn_networks')) {
	function dbdbsmsn_networks() {
		$networks = array();
		foreach(dbdb_icons_socicon_data() as $id=>$network) {
			$networks['dbdb-'.$id] = $network;
		}
		return apply_filters('dbdbsmsn_networks', $networks);
	}
}

if (!function_exists('dbdbsmsn_remove_built_in_networks')) {
	function dbdbsmsn_remove_built_in_networks($networks) {
		unset($networks['dbdb-facebook']);
		unset($networks['dbdb-twitter']);
		unset($networks['dbdb-googleplus']);
		unset($networks['dbdb-pinterest']);
		unset($networks['dbdb-linkedin']);
		unset($networks['dbdb-tumblr']);
		unset($networks['dbdb-instagram']);
		unset($networks['dbdb-skype']);
		unset($networks['dbdb-flickr']);
		unset($networks['dbdb-myspace']);
		unset($networks['dbdb-dribbble']);
		unset($networks['dbdb-youtube']);
		unset($networks['dbdb-vimeo']);
		unset($networks['dbdb-rss']);
		return $networks;
	}
}

if (!function_exists('dbdbsmsn_sort_network_options')) {
	function dbdbsmsn_sort_network_options($fields) {
		if (isset($fields['social_network']['options']) && is_array($fields['social_network']['options'])) {
			uasort($fields['social_network']['options'], 'dbdbsmsm_sort_networks_alphabetically'); 
		}
		return $fields;
	}
}

if (!function_exists('dbdbsmsm_sort_networks_alphabetically')) {
	function dbdbsmsm_sort_networks_alphabetically($a, $b) {
		// Sort non-network items (e.g. "Select a network") first.
		if (!isset($a['value'])) { return -1; } 
		if (!isset($b['value'])) { return 1; }
		// Sort alphabetically
		return strcasecmp($a['value'], $b['value']);
	}
}