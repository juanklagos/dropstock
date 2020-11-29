<?php

// === Setup ===

add_filter('db_pb_slide_content', 'db_pb_slide_filter_content', 10, 2);

// === Load Settings ===

include_once(dirname(__FILE__).'/db_pb_slide_button_2.php');
include_once(dirname(__FILE__).'/db_pb_slide_background_url.php');


// Tidy up URLs (adding http if missing, etc)
function db_pb_slide_canonicalize_url($url) {
	
	if (!empty($url)) {
		// If scheme missing, add http
		if (!parse_url($url, PHP_URL_SCHEME) && // No scheme
			!in_array(substr($url, 0, 1), array('#', '/')) // Not hash or root / protocol relative
		) {
			$url = 'http://'.$url;
		}
	}
	
	return $url;
}

// Process slide options
function db_pb_slide_filter_content($content, $args) {
	
	$args = apply_filters('db_pb_slide_filter_content_args', $args);
	
	// Filter the module classes / add attributes
	$class_regex = '/('.preg_quote('<div class="et_pb_slide ', '/').')([^"]*)('.preg_quote('"', '/').')/';
	if (preg_match($class_regex, $content, $m) && isset($m[2])) {
		$classes = isset($m[2])?explode(' ', $m[2]):array();
		$classes = apply_filters('db_pb_slide_filter_content_classes', $classes, $args);
		$attribs = apply_filters('db_pb_slide_filter_content_extra_attributes', '', $args);
		$content = preg_replace($class_regex, '\\1'.implode(' ', $classes).'\\3 '.$attribs, $content);
	}

	$content = apply_filters('db_pb_slide_filter_content_content', $content, $args);
	
	return $content;
}

