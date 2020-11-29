<?php

add_filter('dbmo_et_pb_accordion_whitelisted_fields', 'dbmo_et_pb_accordion_register_initial_state_field');
add_filter('dbmo_et_pb_accordion_fields', 'dbmo_et_pb_accordion_add_initial_state_field');
add_filter('db_pb_accordion_content', 'db_pb_accordion_add_initial_state_code_to_content', 10, 2);

function dbmo_et_pb_accordion_register_initial_state_field($fields) {
	$fields[] = 'db_initial_state';
	return $fields;
}

function dbmo_et_pb_accordion_add_initial_state_field($fields) {
	$new_fields = array(
		'db_initial_state' => array(
			'label' => 'Initial State',
			'type' => 'select',
			'option_category' => 'layout',
			'options' => array(
				'default'   => esc_html__( 'Default', 'et_builder' ),
				'all_closed'  => esc_html__( 'All Closed', 'et_builder' ),
				'all_open' => esc_html__( 'All Open', 'et_builder' ),
			),
			'description' => 'Set the initial open / closed state of the accordion. '.divibooster_module_options_credit(),
			'default' => 'default',
			'tab_slug'          => 'advanced',
			'toggle_slug'       => 'toggle_layout'
		)
	);
	return $new_fields + $fields;
}

// Process added options
function db_pb_accordion_add_initial_state_code_to_content($content, $args, $module='et_pb_accordion') {

	// Don't apply settings to excerpts
	if (!is_singular()) { return $content; }	

	// Get the class
	$order_class = divibooster_get_order_class_from_content('et_pb_accordion', $content);
	if (!$order_class) { return $content; }
	
	$js = '';
	
	// Set initial open / close state
	if (!empty($args['db_initial_state'])) {
		
		if ($args['db_initial_state'] === 'all_closed') {
			$js .= db_pb_accordion_js_all_closed($order_class);
		} elseif ($args['db_initial_state'] === 'all_open') {
			$js .= db_pb_accordion_js_all_open($order_class);
		}
	}
	
	if (!empty($js)) { $content.="<script>$js</script>"; }
	
	return $content;
}


function db_pb_accordion_js_all_closed($order_class) {
	return <<<END
jQuery(function($){
    $('.et_pb_accordion.{$order_class} .et_pb_toggle_open').toggleClass('et_pb_toggle_open et_pb_toggle_close');

    $('.et_pb_accordion.{$order_class} .et_pb_toggle').click(function() {
      var toggle = $(this);
      setTimeout(function(){
         toggle.closest('.et_pb_accordion').removeClass('et_pb_accordion_toggling');
      },700);
    });
});
END;
}

function db_pb_accordion_js_all_open($order_class) {
	return <<<END
jQuery(function($){
    $('.et_pb_accordion.{$order_class} .et_pb_toggle_close').toggleClass('et_pb_toggle_open et_pb_toggle_close');

    $('.et_pb_accordion.{$order_class} .et_pb_toggle').click(function() {
      var toggle = $(this);
      setTimeout(function(){
         toggle.closest('.et_pb_accordion').removeClass('et_pb_accordion_toggling');
      },700);
    });
});
END;
}