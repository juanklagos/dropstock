<?php

add_filter('et_pb_all_fields_unprocessed_et_pb_social_media_follow_network', 'dbdbsmsn_add_social_media_follow_fields');
add_filter('et_pb_social_media_follow_network_shortcode_output', 'dbdbsmsn_replace_network_names_in_shortcode_output');
add_filter('wp_head', 'dbdbsmsn_set_builder_styles');

//add_filter('wp_enqueue_scripts', 'dbdbsmsn_load_socicon');

add_filter('et_module_shortcode_output', 'dbdbsmsn_set_frontend_styles', 10, 3);

if (!function_exists('dbdbsmsn_set_frontend_styles')) {
	function dbdbsmsn_set_frontend_styles($html, $render_slug, $module) {
		if ($render_slug === 'et_pb_social_media_follow_network' && isset($module->props['social_network'])) {
			dbdbsmsn_load_socicon();
			$selected_network = $module->props['social_network'];
			$networks = dbdbsmsn_networks();
			if (isset($networks[$selected_network]['code'])) {
				ET_Builder_Element::set_style($render_slug, array(
					'selector'    => '%%order_class%% a.icon:before',
					'declaration' => 'content: "'.$networks[$selected_network]['code'].'";font-family: "Socicon" !important;'
					)
				);
			}
		}
		return $html;
	}
}

if (!function_exists('dbdbsmsn_replace_network_names_in_shortcode_output')) {
	function dbdbsmsn_replace_network_names_in_shortcode_output($html) {
		if (!empty($_GET['et_fb'])) { // Don't process in visual builder
			return $html; 
		}
		if (is_array($html)) { // HTML has been rendered as builder data, so leave it alone
			return $html;
		}
		foreach(dbdbsmsn_networks() as $id=>$network) {
			$name = preg_quote(isset($network['name'])?$network['name']:'');
			$slug = preg_quote($id);
			$html = preg_replace('/title="([^"]*)'.$slug.'([^"]*)"/', 'title="\\1'.$name.'\\2"', $html); // double quotes
			$html = preg_replace("/title='([^']*)".$slug."([^']*)'/", "title='\\1".$name."\\2'", $html); // single quotes
		}
		return $html;
	}
}

if (!function_exists('dbdbsmsn_load_socicon')) {
	function dbdbsmsn_load_socicon() { 
		wp_enqueue_style('dbc_et_pb_social_media_follow_network', 
			'https://d1azc1qln24ryf.cloudfront.net/114779/Socicon/style-cf.css?u8vidh'
		);
	}
}

if (!function_exists('dbdbsmsn_set_builder_styles')) {
	function dbdbsmsn_set_builder_styles() { 
		if (empty($_GET['et_fb'])) { 
			return; 
		}
		dbdbsmsn_load_socicon();
		?>
		<style>
		<?php foreach(dbdbsmsn_networks() as $id=>$network) { ?>
			.et-social-<?php esc_html_e($id); ?> a.icon:before,
			.et-db #et-boc .et-l .et_pb_social_icon.et-social-<?php esc_html_e($id); ?> a.icon:before /* TB override */
			{
				content: "<?php esc_attr_e($network['code']); ?>";
				font-family: 'Socicon' !important;
			}
		<?php } ?>
		</style>
		<?php
	}
}

if (!function_exists('dbdbsmsn_add_social_media_follow_fields')) {
	function dbdbsmsn_add_social_media_follow_fields($fields) {
		if (isset($fields['social_network'])) {
			$select = new dbdbsmsn_SocialNetworksField($fields['social_network']);
			foreach(dbdbsmsn_networks() as $id=>$network) {
				if (!$select->has_option($id)) {
					$select->add_option($id, $network['name'], array('color'=>$network['color']));
				}
			}
			$fields['social_network'] = $select->get_field();
		}
		return apply_filters('dbdbsmsn_add_social_media_follow_fields', $fields);
	}
}

if (!class_exists('dbdbsmsn_SocialNetworksField')) {
	class dbdbsmsn_SocialNetworksField {
		
		private $_field;
		
		function __construct($field) {
			$this->_field = $field;
			if (!isset($this->_field['options']) || !is_array($this->_field['options'])) {
				$this->_field['options'] = array();
			}
		}
		
		function has_option($network_id) {
			return isset($this->_field['options'][$network_id]);
		}
		
		function add_option($network_id, $name, $data) {
			$this->_field['options'][$network_id] = array(
				'value' => $name,
				'data' => $data
			);
			if (isset($this->_field['value_overwrite'])) {
				if (isset($data['color'])) {
					$this->_field['value_overwrite'][$network_id] = $data['color'];
				}
			}
		}
		
		function get_field() {
			return $this->_field;
		}
	}
}

if (!function_exists('dbdbsmsn_networks')) {
	function dbdbsmsn_networks() {
		return array(
			'dbdb-tripadvisor' => array(
				'name' => 'TripAdvisor',
				'code' => '\\e088',
				'color' => '#4B7E37',
			)
		);
	}
}