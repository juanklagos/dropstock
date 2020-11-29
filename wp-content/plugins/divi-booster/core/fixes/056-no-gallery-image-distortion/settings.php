<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

function db056_add_setting($plugin) {  
	$plugin->setting_start(); 
	$plugin->techlink('https://divibooster.com/prevent-distortion-on-divi-gallery-images/'); 
	$plugin->checkbox(__FILE__); ?> Show small gallery images actual size (don't expand to fill available area)<?php
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('modules-gallery', 'db056_add_setting');