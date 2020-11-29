<?php // Handles dynamic content within added module fields

// === Mark fields as dynamic content enabled ===

add_filter('db_pb_slide_field_button_text_2', 'db_set_field_dynamic_content_text');
add_filter('db_pb_slide_field_button_link_2', 'db_set_field_dynamic_content_url');

function db_set_field_dynamic_content_text($field) {
	$field['dynamic_content'] = 'text';
	return $field;
}

function db_set_field_dynamic_content_url($field) {
	$field['dynamic_content'] = 'url';
	return $field;
}


// === Resolve dynamic content in added module fields ===

add_filter('db_pb_slide_args_button_text_2', 'db_resolve_dynamic_content');
add_filter('db_pb_slide_args_button_link_2', 'db_resolve_dynamic_content');

function db_resolve_dynamic_content($content) {
	
	// Parse the dynamic content into an ET_Builder_Value object
	if (!function_exists('et_builder_parse_dynamic_content')) {
		return $content;
	}
	$et_builder_value = et_builder_parse_dynamic_content($content);
	
	$post_id = dbdb_get_current_post_id();
	if (!$post_id) {
		return $content; 
	}
	
	// Resolve the content
	if (!method_exists($et_builder_value, 'resolve')) {
		return $content;
	}
	$content = $et_builder_value->resolve($post_id);
	
	// Return the content
	return $content;
}
