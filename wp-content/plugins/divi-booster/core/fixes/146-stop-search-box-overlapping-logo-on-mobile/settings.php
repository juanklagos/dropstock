<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

function db146_add_setting($plugin) {  
	$option = new DBDBOption146_StopSearchBoxOverlappingLogo();
	$plugin->setting_start($option->settingsPageClass()); 
	$plugin->techlink($option->docUrl()); 
	$plugin->checkbox(__FILE__); 
	esc_html_e($option->title());
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting((new DBDBOption146_StopSearchBoxOverlappingLogo())->settingsPageSubsection(), 'db146_add_setting');