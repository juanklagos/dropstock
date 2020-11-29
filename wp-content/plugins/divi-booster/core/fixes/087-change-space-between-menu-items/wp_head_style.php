<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

list($name, $option) = $this->get_setting_bases(__FILE__); ?>

ul#top-menu li.menu-item:not(:last-child) { 
	padding-right: <?php echo intval(@$option['menuitempadding']); ?>px !important; 
}
#et_top_search { 
	margin-left: <?php echo intval(@$option['menuitempadding']); ?>px !important; 
}

/* Adjust separator position, if used */
.db141_show_header_separators.et_header_style_left #top-menu > .menu-item + .menu-item:before,
.db141_show_header_separators.et_header_style_centered #top-menu > .menu-item + .menu-item:before,
.db141_show_header_separators.et_header_style_split #top-menu > .menu-item + .menu-item:before
{
	left: -<?php echo ((intval(@$option['menuitempadding'])/2)+4); ?>px !important; /* Half of right padding and 4px adjust to center (to compensate for space char between li) */
}