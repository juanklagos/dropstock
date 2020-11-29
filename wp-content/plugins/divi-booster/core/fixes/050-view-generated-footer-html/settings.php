<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

function db050_add_setting($plugin) { 
	$plugin->setting_start(); 
	$plugin->hiddencheckbox(__FILE__); ?> Generated Footer HTML: <a href="<?php esc_html_e($plugin->cacheurl()); ?>wp_footer.txt" target="_blank">wp_footer.txt</a><?php
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('developer-footer-html', 'db050_add_setting');