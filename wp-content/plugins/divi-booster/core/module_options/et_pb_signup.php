<?php 

add_filter('dbmo_et_pb_signup_whitelisted_fields', 'dbmo_et_pb_signup_register_fields');
add_filter('dbmo_et_pb_signup_fields', 'dbmo_et_pb_signup_add_fields');
add_filter('db_pb_signup_content', 'db_pb_signup_filter_content', 10, 2);
add_action('wp_head', 'db_pb_signup_css');

function db_pb_signup_css() { ?>
<style>
@media only screen and (min-width: 981px) {
    .et_pb_module.db_inline_form .et_pb_newsletter_fields > p { 
        flex: auto !important;
    }
    .et_pb_module.db_inline_form .et_pb_newsletter_fields p.et_pb_newsletter_field {
        margin-right: 2%; 
    }
}
</style>
<?php 
}

function dbmo_et_pb_signup_register_fields($fields) {
	$fields[] = 'db_inline_form';
	return $fields;
}

function dbmo_et_pb_signup_add_fields($fields) {
	
	$fields['db_inline_form'] = array(
		'label'           => esc_html__('Inline Form', 'et_builder'),
		'type'            => 'yes_no_button',
		'option_category' => 'configuration',
		'options'         => array(
			'on'  => esc_html__( 'Yes', 'et_builder' ),
			'off' => esc_html__( 'No', 'et_builder' ),
		),
		'default'         => 'off',
		'toggle_slug'     => 'layout',
		'tab_slug'        => 'advanced',
		'description' => 'Display optin form in an inline layout. '.divibooster_module_options_credit()
	);
	
	return $fields;
}

function db_pb_signup_filter_content($content, $args) {
	
	if (isset($args['db_inline_form']) && $args['db_inline_form'] === 'on') {
		$content = db_pb_signup_add_class_to_module_div($content, 'db_inline_form');
	}
	
	return $content;
}

function db_pb_signup_add_class_to_module_div($content, $class) {
	return preg_replace('/^('.preg_quote('<div class="et_pb_module ').')/', '\\1'.$class.' ', $content);
}