<?php // Code run on wp-admin/plugins.php

add_filter('plugin_action_links_'.dbdb_plugin_basename(), 'add_plugin_action_settings_link');
			
function add_plugin_action_settings_link($links) {
	if (is_array($links)) { 
		$links[] = '<a href="'.esc_attr(dbdb_settings_page_url()).'">Settings</a>';
	}
	return $links;
} 