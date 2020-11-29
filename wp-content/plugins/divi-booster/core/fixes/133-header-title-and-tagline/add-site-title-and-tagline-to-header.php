<?php

add_action('init', 'db133_load');

if (!function_exists('db133_load')) {
	function db133_load() {	
		add_action('et_html_logo_container', 'db133_add_title_and_tagline');
	}
}
 
if (!function_exists('db133_add_title_and_tagline')) {
	function db133_add_title_and_tagline($content){
		$logo_regex = '#<img[^>]*?id="logo"[^>]*?/>#';
		$result = preg_replace_callback($logo_regex, 'db133_add_title_and_tagline_callback', $content);
		return apply_filters('db133_add_title_and_tagline', $result, $content);
	}
}

if (!function_exists('db133_add_title_and_tagline_callback')) {
	function db133_add_title_and_tagline_callback($m) {
		$logo = isset($m[0])?$m[0]:'';
		$markup = $logo.db133_title_and_tagline_html();
		return apply_filters('db133_add_title_and_tagline_callback', $markup, $m);
	}
}

if (!function_exists('db133_title_and_tagline_html')) {
	function db133_title_and_tagline_html() {
		return apply_filters(
			'db133_title_and_tagline_html',
			db133_title_and_tagline_html_from_data(db133_title_and_tagline_data())
		);
	}
}

if (!function_exists('db133_title_and_tagline_html_from_data')) {
	function db133_title_and_tagline_html_from_data($data) {
		$data = wp_parse_args($data, array(
			'title' => '',
			'title_tag' => '',
			'tagline' => '',
			'tagline_tag' => ''		
		));
		$result = '';
		if (!empty($data['title_tag']) && !empty($data['tagline_tag'])) {
			$result = sprintf(
				'<div id="db_title_and_tagline">
					<%2$s id="logo-text">%1$s</%2$s>
					<%4$s id="logo-tagline" class="logo-tagline">%3$s</%4$s>
				</div>', 
				esc_html($data['title']),
				esc_html($data['title_tag']),
				esc_html($data['tagline']),
				esc_html($data['tagline_tag'])
			);
		}
		return apply_filters('db133_title_and_tagline_html_from_data', $result, $data);
	}
}

if (!function_exists('db133_title_and_tagline_data')) {
	function db133_title_and_tagline_data() {
		return apply_filters(
			'db133_title_and_tagline_data', 
			array(
				'title' => db133_site_title(),
				'title_tag' => db133_site_title_tag(),
				'tagline' => db133_site_tagline(),
				'tagline_tag' => db133_site_tagline_tag()
			)
		);
	}
}

if (!function_exists('db133_site_title')) {
	function db133_site_title() {
		return apply_filters('db133_site_title', get_bloginfo('name'));
	}
}

if (!function_exists('db133_site_tagline')) {
	function db133_site_tagline() {
		return apply_filters('db133_site_tagline', get_bloginfo('description'));
	}
}

if (!function_exists('db133_site_title_tag')) {
	function db133_site_title_tag() {
		$tag = dbdb_option('133-header-title-and-tagline', 'titleHeaderLevel', 'h1');
		return apply_filters('db133_site_title_tag', $tag);
	}
}

if (!function_exists('db133_site_tagline_tag')) {
	function db133_site_tagline_tag() {
		return apply_filters('db133_site_tagline_tag', 'h5');
	}
}