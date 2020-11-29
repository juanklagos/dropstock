<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

function db119_add_setting($plugin) { 
	$plugin->setting_start(); 
	$plugin->techlink('https://divibooster.com/make-divi-header-phone-number-into-clickable-link/'); 
	$plugin->checkbox(__FILE__); ?> Make phone number a "click to call" link
	<div class="db_subsetting">Dial this number: <?php $plugin->textpicker(__FILE__, 'phonenum'); ?> (optional)</div>
	<?php
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('header-top', 'db119_add_setting');	