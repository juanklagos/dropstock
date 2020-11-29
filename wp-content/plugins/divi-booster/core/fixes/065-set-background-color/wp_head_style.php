<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

list($name, $option) = $this->get_setting_bases(__FILE__); ?>

#main-content, .et_pb_section {
	background-color: <?php esc_html_e(@$option['bgcol']); ?> !important;
} 