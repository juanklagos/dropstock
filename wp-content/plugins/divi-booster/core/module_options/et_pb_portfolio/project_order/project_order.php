<?php

include_once(dirname(__FILE__).'/project_order_random.php');
include_once(dirname(__FILE__).'/project_order_reverse.php');
include_once(dirname(__FILE__).'/project_order_by_id.php');

add_filter('dbmo_et_pb_portfolio_whitelisted_fields', 'dbmo_et_pb_portfolio_project_order_register_fields');
add_filter('dbmo_et_pb_filterable_portfolio_whitelisted_fields', 'dbmo_et_pb_portfolio_project_order_register_fields'); 
add_filter('dbmo_et_pb_fullwidth_portfolio_whitelisted_fields', 'dbmo_et_pb_portfolio_project_order_register_fields'); 

add_filter('dbmo_et_pb_portfolio_fields', 'dbmo_et_pb_portfolio_add_fields');
add_filter('dbmo_et_pb_filterable_portfolio_fields', 'dbmo_et_pb_portfolio_add_fields');
add_filter('dbmo_et_pb_fullwidth_portfolio_fields', 'dbmo_et_pb_portfolio_add_fields');

function dbmo_et_pb_portfolio_project_order_register_fields($fields) {
	$fields[] = 'db_project_order';
	return $fields;
}

function dbmo_et_pb_portfolio_add_fields($fields) {
	$fields['db_project_order'] = array(
		'label' => 'Project Order',
		'type' => 'select',
		'option_category' => 'layout',
		'options' => dbdb_portfolio_order_options(),
		'default' => 'default',
		'description' => 'Adjust the order in which projects are displayed. '.divibooster_module_options_credit(),
		'tab_slug' => 'advanced',
		'toggle_slug' => 'layout'
	);
	return $fields;
}

if (!function_exists('dbdb_portfolio_order_options')) {
	function dbdb_portfolio_order_options() {
		$result = array(
			'default' => esc_html__('Default', 'et_builder')
		);
		return apply_filters('dbdb_portfolio_order_options', $result);
	}
}