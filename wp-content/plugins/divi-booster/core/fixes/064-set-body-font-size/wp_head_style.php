<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

list($name, $option) = $this->get_setting_bases(__FILE__); ?>

body { font-size:<?php esc_html_e(@$option['fontsize']); ?>% !important; }