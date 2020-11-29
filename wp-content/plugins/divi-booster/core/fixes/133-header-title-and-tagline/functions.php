<?php
if (!defined('ABSPATH')) { exit(); } // No direct access

add_action('wp_footer.js', 'db133_add_title_and_tagline_via_jquery_as_fallback');

function db133_add_title_and_tagline_via_jquery_as_fallback($plugin) { ?>
	jQuery(function($) {
		if (!$('#logo-text').length) {
			$('#logo').after(<?php echo json_encode(db133_title_and_tagline_html()); ?>);
		}
	});
<?php 
}

// === Add Layout option ===

add_action('wp_head.css', 'db133_load_layout_css');

function db133_load_layout_css() {
	$layout = dbdb_option('133-header-title-and-tagline', 'layout', 'horizontal');
	include(dirname(__FILE__)."/layout/layout_horizontal.css"); // Includes shared css, so always load
	if (in_array($layout, array('vertical', 'title_only', 'tagline_only'))) {
		include(dirname(__FILE__)."/layout/layout_{$layout}.css");
	}
}