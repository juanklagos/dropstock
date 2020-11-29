<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

list($name, $option) = $this->get_setting_bases(__FILE__); ?>

@media only screen and (max-width: 980px) {
	#et-top-navigation span.mobile_menu_bar:before, /* hamburger / mobile menu button */
	#et-top-navigation span.mobile_menu_bar:after 	/* slide-in menu close button */
	{
		color: <?php esc_html_e(@$option['buttoncol']); ?> !important;
	}
}
