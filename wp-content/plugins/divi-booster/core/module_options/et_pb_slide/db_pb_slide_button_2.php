<?php

add_filter('dbmo_et_pb_slide_whitelisted_fields', 'db_pb_slide_button_2_register_fields');
add_filter('dbmo_et_pb_slide_fields', 'db_pb_slide_button_2_add_fields');
add_filter('db_pb_slide_args_button_link_2', 'db_pb_slide_canonicalize_url');
add_filter('db_pb_slide_filter_content_classes', 'db_pb_slide_add_second_more_button_class', 10, 2);
add_filter('db_pb_slide_filter_content_args', 'db_pb_slide_button_2_content_args');
add_filter('db_pb_slide_filter_content_content', 'db_pb_slide_button_2_content_content', 10, 2);

function db_pb_slide_button_2_content_args($args) {
	$args = wp_parse_args($args, array(
		'button_text_2' => '',
		'button_link_2' => '#'
	));
	$args['button_text_2'] = apply_filters('db_pb_slide_args_button_text_2', $args['button_text_2']);
	$args['button_link_2'] = apply_filters('db_pb_slide_args_button_link_2', $args['button_link_2']);
	return $args;
}

function db_pb_slide_button_2_content_content($content, $args) {
	
	$button_2_text = empty($args['button_text_2'])?'':$args['button_text_2'];
	$button_2_url = empty($args['button_link_2'])?'':$args['button_link_2'];
	
	if (!empty($args['button_text_2'])) {
		
		// Set button CSS
		dbdb_set_module_style('et_pb_slide', array(
			'selector'    => '%%order_class%%.db_second_more_button .et_pb_more_button',
			'declaration' => 'margin-left: 15px; margin-right: 15px;'
		));
		
		// Add button - old Divi markup
		$content = preg_replace(
			'#(<a href=".*?" class="(et_pb_more_button[^"]+et_pb_button[^"]*)"([^>]*)>.*?</a>)#', 
			'\\1<a href="'.esc_attr($button_2_url).'" class="\\2 db_pb_button_2"\\3>'.esc_html($button_2_text).'</a>', 
			$content); 
			
		// Add button - new Divi markup	
		$content = preg_replace(
			'#(<a class="(et_pb_button[^"]+et_pb_more_button[^"]*)" href=".*?"([^>]*)>.*?</a>)#', 
			'\\1<a class="\\2 db_pb_button_2" href="'.esc_attr($button_2_url).'"\\3>'.esc_html($button_2_text).'</a>',
			$content); 		
	}
	
	return $content;
}


function db_pb_slide_button_2_register_fields($fields) {
	$fields[] = 'button_text_2';
	$fields[] = 'button_link_2';
	return $fields;
}

function db_pb_slide_button_2_add_fields($fields) {
	
	$new_fields = array(); 
	
	foreach($fields as $k=>$v) {
		$new_fields[$k] = $v;
		
		// Add second button text option
		if ($k === 'button_text') { 
			$new_fields['button_text_2'] = apply_filters(
				'db_pb_slide_field_button_text_2', 
				array(
					'label' => 'Button #2 Text',
					'type' => 'text',
					'option_category' => 'basic_option',
					'description' => 'Define the text for the second slide button. '.divibooster_module_options_credit(),
					'default' => '',
					'toggle_slug'=>'main_content'
				)
			);
		}
		
		// Add second button link option
		if ($k === 'button_link') {
			$new_fields['button_link_2'] = apply_filters(
				'db_pb_slide_field_button_link_2', 
				array(
					'label' => dbdb_is_divi('3.16', '>=')?'Button #2 Link URL':'Button #2 URL',
					'type' => 'text',
					'option_category' => 'basic_option',
					'description' => 'Input a destination URL for the second slide button. '.divibooster_module_options_credit(),
					'default' => '#',
					'toggle_slug'=>dbdb_is_divi('3.16', '>=')?'link_options':'link',
				)
			);
		}
		
	}
	
	return $new_fields;
}

function db_pb_slide_add_second_more_button_class($classes, $args) {
	if (!empty($args['button_text_2'])) {
		$classes[] = 'db_second_more_button';
	}
	return $classes;
}