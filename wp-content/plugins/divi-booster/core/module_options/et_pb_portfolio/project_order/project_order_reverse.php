<?php

add_filter('dbdb_portfolio_order_options', 'dbmo_et_pb_portfolio_project_order_option_reverse');

function dbmo_et_pb_portfolio_project_order_option_reverse($options) {
	$options['reverse'] = esc_html__('Reverse', 'et_builder');
	return $options;
}

add_filter('et_pb_module_shortcode_attributes', 'db_add_pre_get_portfolio_projects_reverse', 10, 3);
add_filter('et_module_shortcode_output', 'db_remove_pre_get_portfolio_projects_reverse');

function db_add_pre_get_portfolio_projects_reverse($props, $atts, $slug) {
	if (DBDB_module_slug::is_portfolio($slug)) {
		if (isset($atts['db_project_order']) && $atts['db_project_order'] === 'reverse') {
			add_action('pre_get_posts', 'db_reverse_portfolio_module_projects');
		}
	}
	return $props;
}

function db_remove_pre_get_portfolio_projects_reverse($content) {
	remove_action('pre_get_posts', 'db_reverse_portfolio_module_projects');
	return $content;
}

function db_reverse_portfolio_module_projects($query) {	
	$query->set('order', 'ASC');
	do_action('dbdb_portfolio_projectOrder_reverse_preGetPosts', $query);
}
