<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

add_action('init', 'db014_register_icons');

do_action('dbdb_014-add-new-icons_after');

function db014_register_icons($icons) {
	if (!class_exists('DBDBCustomIcon')) { return; }
	DBDBCustomIcon::setup();
	foreach(db014_get_icon_urls() as $id=>$url) {
		if (!empty($url)) {
			(new DBDBCustomIcon($id, $url))->init();
		}
	}
}

function db014_get_icon_urls() {
	$urls = array();
	$urlmax = dbdb_option('014-add-new-icons', 'urlmax', 0);
	for($i=0; $i<=$urlmax; $i++) {
		$urls["wtfdivi014-url$i"] = dbdb_option('014-add-new-icons', "url$i", '');
	}
	return $urls;
}


