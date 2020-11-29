<?php
if (!defined('ABSPATH')) { exit(); } // No direct access

function db134_vb_css() { 
	?>
	/* === Older visual builders (3.0.x-ish) === */
	.et-fb-page-settings-bar :not(.et-fb-button-group--save-changes) > .et-fb-button--publish { 
		position: fixed; 
		left: 30px; 
		bottom: 75px; 
	}
	.et-fb-page-settings-bar :not(.et-fb-button-group--save-changes) > .et-fb-button--save-draft { 
		position: fixed; 
		left: 104px; 
		bottom: 75px; 
	} 

	/* Latest visual builder */
	.et-fb-button-group--save-changes { 
		position: fixed !important; 
		margin-top: -70px; 
		left: 30px !important; 
	}
	.et-fb-button-group--save-changes .et-fb-button--help, 
	.et-fb-button-group--save-changes .et-fb-button--quick-actions { 
		margin-right: 8px !important; 
	}
	<?php 
}
add_action('db_vb_css', 'db134_vb_css');