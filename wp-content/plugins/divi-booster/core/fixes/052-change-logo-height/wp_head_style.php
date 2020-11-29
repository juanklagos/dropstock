<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

list($name, $option) = $this->get_setting_bases(__FILE__); ?>

@media only screen and ( min-width:981px ) {
	#logo { 
		height: <?php esc_html_e(@$option['normal']); ?>px; 
		max-height: <?php esc_html_e(@$option['normal']); ?>px !important; 
		padding-bottom:18px; 
	}
	.et-fixed-header #logo { 
		max-height: <?php esc_html_e(@$option['shrunk']); ?>px !important; 
	}	
	body:not(.dbdb_divi_2_4_up) .et-fixed-header #logo {  
		padding-bottom:10px !important; 
	}
	.et-fixed-header div#page-container { 
		padding-top: <?php esc_html_e(@$option['normal'])+18+18; ?>px !important; 
	}
	
	body.dbdb_divi_2_4_up .et_header_style_left .et_menu_container { 
		height:<?php esc_html_e(@$option['normal']+36); ?>px!important; 
	}
	body.dbdb_divi_2_4_up .et-fixed-header .et_menu_container { 
		height:<?php esc_html_e(@$option['shrunk']+20); ?>px!important; 
	}
	body.dbdb_divi_2_4_up #logo { 
		max-height:100% !important; 
		margin-top:18px; 
		margin-bottom:18px !important; 
		border-sizing:border-box !important; 
		padding-bottom:0px !important
	}
	body.dbdb_divi_2_4_up .et-fixed-header #logo { 
		margin-top:0px !important; 
		margin-bottom:0px !important; 
		padding-bottom: 0px !important;
	}
}