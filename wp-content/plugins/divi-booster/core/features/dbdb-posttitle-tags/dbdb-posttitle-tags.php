<?php
/*
Plugin Name: Divi Booster Feature - Show Tags in Post Title Module
Plugin URI: 
Description: Candidate Divi Booster feature
Author: Divi Booster
Version: 0.1
Author URI: http://www.divibooster.com
*/


// === Settings === 

add_filter('et_pb_all_fields_unprocessed_et_pb_post_title', 'dbdb_posttitle_add_tags_option');
add_filter('dbdbptst_show_tags', 'dbdb_posttitle_show_tags_based_on_module_setting', 10, 2);

if (!function_exists('dbdb_posttitle_add_tags_option')) {
	function dbdb_posttitle_add_tags_option($fields) {
		if (isset($fields['meta']['affects']) && is_array($fields['meta']['affects'])) {
			$fields['meta']['affects'][] = 'dbdb_show_tags';
		}
		return $fields + array(
			'dbdb_show_tags' => array(
				'label'             => esc_html__( 'Show Post Tags', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'default_on_front'  => 'off',
				'depends_show_if'   => 'on',
				'toggle_slug'       => 'elements',
				'description'       => esc_html__( 'Here you can choose whether or not display the Tags in Post Meta.', 'et_builder' ),
				'mobile_options'    => true,
				'hover'             => 'tabs',
			),
		);
	}
}

if (!function_exists('dbdb_posttitle_show_tags_based_on_module_setting')) {
	function dbdb_posttitle_show_tags_based_on_module_setting($enabled, $module) {
		return (isset($module->props) && 
				isset($module->props['dbdb_show_tags']) && 
				$module->props['dbdb_show_tags'] === 'on');
	}
}

// === Apply Feature === 

add_filter('et_module_shortcode_output', 'dbdb_posttitle_add_tags_to_output', 10, 3);

if (!function_exists('dbdb_posttitle_add_tags_to_output')) {
	function dbdb_posttitle_add_tags_to_output($html, $render_slug, $module) {
		if ($render_slug === 'et_pb_post_title' && is_string($html)) {
			if (dbdbptst_show_meta($module) && dbdbptst_show_tags($module)) {
				$meta_container_regex = '/(<p class="[^"]*et_pb_title_meta_container[^"]*">)(.*?)(<\/p>)/';
				if (!preg_match($meta_container_regex, $html)) {
					$html = preg_replace(
						'/(<div class="et_pb_title_container">)(.*?)(<\/div>)/s', 
						'\\1\\2<p class="et_pb_title_meta_container"></p>\\3', 
						$html);
				}
				$html = preg_replace_callback($meta_container_regex, 'dbdb_posttitle_add_tags_to_meta', $html);
				if (is_callable('ET_Builder_Element::set_style')) {
					ET_Builder_Element::set_style($render_slug, array(
						'selector'    => '%%order_class%% .dbdb_posttitle_tags a:not(:last-child):after',
						'declaration' => 'content: ",";'
						)
					);
				}
			}
		}
		return $html;
	}
}

if (!function_exists('dbdbptst_show_tags')) {
	function dbdbptst_show_tags($module) {
		return apply_filters('dbdbptst_show_tags', true, $module);
	}
}

if (!function_exists('dbdbptst_show_meta')) {
	function dbdbptst_show_meta($module) {
		return (isset($module->props) && isset($module->props['meta']) && $module->props['meta'] === 'on');
	}
}

if (!function_exists('dbdb_posttitle_add_tags_to_meta')) {
	function dbdb_posttitle_add_tags_to_meta($match) {
		if (is_array($match) && isset($match[1]) && isset($match[2]) && isset($match[3])) {
			$taxonomy = (get_post_type() === 'project')?'project_tag':'post_tag';
			$tags = get_the_term_list(get_the_id(), $taxonomy, '', ' ', '');
			if ($tags) {
				$meta_elements = array_filter(explode(' | ', $match[2]));
				$meta_elements[] = '<span class="dbdb_posttitle_tags">'.$tags.'</span>';
				return $match[1].implode(' | ', $meta_elements).$match[3];
			}
		}
		return isset($match[0])?$match[0]:'';
	}
}