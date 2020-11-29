<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

list($name, $option) = $this->get_setting_bases(__FILE__); ?>

@media only screen and ( min-width:981px ) {
	#main-header { min-height: <?php esc_html_e(@$option['normal']); ?>px !important; }
	#main-header.et-fixed-header { min-height: <?php esc_html_e(@$option['shrunk']); ?>px !important;  }
}