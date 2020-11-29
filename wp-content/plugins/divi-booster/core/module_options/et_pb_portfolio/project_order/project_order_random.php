<?php

add_filter('dbdb_portfolio_order_options', 'dbmo_et_pb_portfolio_project_order_option_random');

function dbmo_et_pb_portfolio_project_order_option_random($options) {
	$options['random'] = esc_html__('Random', 'et_builder');
	return $options;
}

add_filter('et_pb_module_shortcode_attributes', 'db_add_pre_get_portfolio_projects_random', 10, 3);
add_filter('et_module_shortcode_output', 'db_remove_pre_get_portfolio_projects_random');

function db_add_pre_get_portfolio_projects_random($props, $atts, $slug) {
	if (DBDB_module_slug::is_portfolio($slug)) {
		if (isset($atts['db_project_order']) && $atts['db_project_order'] === 'random') {
			add_action('pre_get_posts', 'db_randomize_portfolio_module_projects'); 
		}
	}
	return $props;
}

function db_remove_pre_get_portfolio_projects_random($content) {
	remove_action('pre_get_posts', 'db_randomize_portfolio_module_projects');
	return $content;
}

function db_randomize_portfolio_module_projects($query) {	
	$query->set('orderby', 'rand');
	do_action('dbdb_portfolio_projectOrder_random_preGetPosts', $query);
	//$query->set('ignore_custom_sort', true); // Ignore "Post Type Order" plugin ordering
}