<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

function db145_add_setting($plugin) { 
	$plugin->setting_start();  
	$plugin->techlink('https://divibooster.com/changing-the-divi-mobile-header-menu-button/');
	$plugin->checkbox(__FILE__); ?> Mobile menu button color: <?php $plugin->colorpicker(__FILE__, 'buttoncol', '#2ea3f2', true);
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('header-mobile', 'db145_add_setting');	