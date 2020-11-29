<?php

// === Add setting ===

add_filter('dbdb_portfolio_order_options', 'dbdb_portfolio_order_option_by_id');
add_filter('dbmo_et_pb_portfolio_whitelisted_fields', 'dbmo_et_pb_portfolio_project_order_register_id_field');
add_filter('dbmo_et_pb_filterable_portfolio_whitelisted_fields', 'dbmo_et_pb_portfolio_project_order_register_id_field'); 
add_filter('dbmo_et_pb_fullwidth_portfolio_whitelisted_fields', 'dbmo_et_pb_portfolio_project_order_register_id_field'); 
add_filter('dbmo_et_pb_portfolio_fields', 'dbdb_portfolio_order_option_by_id_field', 11);
add_filter('dbmo_et_pb_filterable_portfolio_fields', 'dbdb_portfolio_order_option_by_id_field', 11);
add_filter('dbmo_et_pb_fullwidth_portfolio_fields', 'dbdb_portfolio_order_option_by_id_field', 11);

function dbdb_portfolio_order_option_by_id($options) {
	$options['by_id'] = esc_html__('By ID', 'et_builder');
	return $options;
}

function dbmo_et_pb_portfolio_project_order_register_id_field($fields) {
	$fields[] = 'db_project_order_ids';
	return $fields;
}

function dbdb_portfolio_order_option_by_id_field($fields) {
	$fields['db_project_order_ids'] = array(
		'label' => 'Project IDs',
		'type' => 'text',
		'option_category' => 'layout',
		'default' => '',
		'description' => 'Enter a comma-separated list of project ids. '.divibooster_module_options_credit(),
		'tab_slug' => 'advanced',
		'toggle_slug' => 'layout',
		'show_if' => array(
			'db_project_order' => 'by_id',
		)
	);
	return $fields;
}

// === Apply option ===

(new DBDB_portfolio_by_id())->add_filters();

class DBDB_portfolio_by_id {
	
	private $projects;
		
	function __construct() {
		$this->projects = new DBDB_idlist();
	}
	
	function add_filters() {
		add_filter('et_pb_module_shortcode_attributes', array($this, 'add_pre_get_posts_filter'), 10, 3);
		add_filter('et_module_shortcode_output', array($this, 'remove_pre_get_posts_filter'));
	}
	
	function add_pre_get_posts_filter($props, $atts, $slug) {
		if (DBDB_module_slug::is_portfolio($slug)) {
			if (isset($atts['db_project_order']) && $atts['db_project_order'] === 'by_id') {
				if (isset($atts['db_project_order_ids'])) {
					$this->projects->set_ids_from_comma_separated_str($atts['db_project_order_ids']);
					add_action('pre_get_posts', array($this, 'set_query_order'));
				}
			}
		}
		return $props;
	}
	
	function remove_pre_get_posts_filter($content) {
		remove_action('pre_get_posts', array($this, 'set_query_order'));
		return $content;
	}

	function set_query_order($query) {	
		$query->set('post__in', $this->projects->ids());
		$query->set('orderby', 'post__in');
		do_action('dbdb_portfolio_projectOrder_byId_preGetPosts', $query);
	}
}
