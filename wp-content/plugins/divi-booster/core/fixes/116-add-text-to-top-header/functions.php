<?php

add_filter('et_html_top_header', 'db116_add_top_header_text'); // Use PHP if Divi 3.1+ and top header exists
add_action('db_user_jquery', 'db116_add_top_header_text_by_jquery'); // jQuery fallback
add_action('wp_head.css', 'db116_add_top_header_text_css');
add_filter('divibooster_setting_116-add-text-to-top-header_topheadertext', 'db116_do_shortcodes_in_top_header_text');

function db116_add_top_header_text($html) {

	// Add #et-info if missing
	if (strpos($html, '<div id="et-info"') === false) {
		str_replace('<div id="et-secondary-menu"', '<div id="et-info"></div><div id="et-secondary-menu"', $html);
	}
	
	// Add the top header text
	$text_html = '<span id="db-info-text">'.db116_header_text().'</span>';
	$html = str_replace('<div id="et-info">', '<div id="et-info">'.$text_html, $html);
	
	return $html;

}

function db116_add_top_header_text_by_jquery() {
	?>	
	// Add #et-info element if missing
	if (!$('#et-info').length) { 
	
		// Enable top header and container if not enabled
		if (!($('#top-header').length)) { 
			$('#page-container').prepend('<div id="top-header"><div class="container clearfix"></div></div>');
		}
	
		$('#top-header .container').prepend('<div id="et-info"></div>'); 
	}
	
	// Add the top header text (if not already set via PHP)
	if (!$('#db-info-text').length) {
		$('#et-info').prepend('<span id="db-info-text">'+<?php echo json_encode(db116_header_text()); ?>+'</span>');
	}
	<?php
}

function db116_header_text() {
	return dbdb_option('116-add-text-to-top-header', 'topheadertext', '');
}

function db116_add_top_header_text_css() {
	?>
	#db-info-text { margin:0 10px; }
	<?php
}

function db116_do_shortcodes_in_top_header_text($text) {
	return do_shortcode($text);
}