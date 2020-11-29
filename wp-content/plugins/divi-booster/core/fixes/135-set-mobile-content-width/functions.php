<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

function db135_user_css($plugin) { 
	list($name, $option) = $plugin->get_setting_bases(__FILE__); ?>

@media only screen and (max-width: 980px) {
	#top-header > .container,
	#main-header > .container,
	#et_search_outer > .container,
	body.single #main-content > .container,
	body.page:not(.et-tb-has-template) div.et_pb_row,
	body.page.et-tb-has-template .et-l--post > .et_builder_inner_content > .et_pb_section > .et_pb_row,
	body.single-project div.et_pb_row,
	body.single-project div.et_pb_row.et_pb_row_fullwidth {
       width: <?php echo intval(@$option['mobilewidth']); ?>% !important; 
   }
}

<?php 
}
add_action('wp_head.css', 'db135_user_css');
