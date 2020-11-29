<?php

add_filter('db_pb_slide_filter_content_classes', 'db_pb_slide_background_url_class', 10, 2);
add_filter('db_pb_slide_filter_content_extra_attributes', 'db_pb_slide_background_url_add_data_attrib', 10, 2);
add_filter('wp_footer', 'db_pb_slide_background_url_css');
add_filter('wp_footer', 'db_pb_slide_background_url_js');
add_filter('db_pb_slide_filter_content_args', 'db_pb_slide_background_url_content_args');
add_filter('db_pb_slide_args_db_background_url', 'db_pb_slide_canonicalize_url');


add_filter('dbmo_et_pb_slide_whitelisted_fields', 'dbmo_et_pb_slide_background_url_register_fields');
add_filter('dbmo_et_pb_slide_fields', 'dbmo_et_pb_slide_background_url_add_fields');

function dbmo_et_pb_slide_background_url_register_fields($fields) {
	$fields[] = 'db_background_url';
	return $fields;
}

function dbmo_et_pb_slide_background_url_add_fields($fields) {
	
	// Add background link URL option
	$fields['db_background_url'] = array(
		'label' => 'Background Link URL',
		'type' => 'text',
		'option_category' => 'basic_option',
		'description' => 'Input a destination URL for clicks on the slide background. '.divibooster_module_options_credit(),
		'default' => '',
		'toggle_slug'=>'background'
	);
	
	return $fields;
}

function db_pb_slide_background_url_content_args($args) {
	$args = wp_parse_args($args, array(
		'db_background_url' => ''
	));
	$args['db_background_url'] = apply_filters('db_pb_slide_args_db_background_url', $args['db_background_url']);
	return $args;
}

function db_pb_slide_background_url_class($classes, $args) {
	if (!empty($args['db_background_url'])) {
		$classes[] = 'db_background_url';
	}
	return $classes;
}

function db_pb_slide_background_url_add_data_attrib($attrib_str, $args) {
	if (!empty($args['db_background_url'])) {
		$attrib_str .= 'data-db_background_url="'.esc_html($args['db_background_url']).'"';
	}
	return $attrib_str;
}

function db_pb_slide_background_url_css() { 
	?>
	<style>
	.et_pb_slide.db_background_url:hover{
		cursor:pointer;
	}
	</style>
	<?php 
}

function db_pb_slide_background_url_js() {
	?>
	<script>
	jQuery(function($){
		$(".db_background_url").click(function(){
			var url = $(this).data('db_background_url');
			if (url.indexOf('#') == 0 || url.indexOf('.') == 0) {
				et_pb_smooth_scroll($(url), false, 800);
			} else {
				document.location=url;
			}
		});
	});
	</script>
	<?php
}