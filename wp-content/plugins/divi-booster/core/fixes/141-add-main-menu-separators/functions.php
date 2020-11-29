<?php
if (!defined('ABSPATH')) { exit(); } // No direct access

add_filter('body_class', 'db141_body_class');

function db141_body_class($classes) {
        $classes[] = 'db141_show_header_separators';
        return $classes;
}

function db141_user_css($plugin) { 
	
	// Get color of menu links
	$detect_legacy_primary_nav_color = dbdb_et_get_option('primary_nav_text_color', 'Dark');
	if ( $detect_legacy_primary_nav_color == 'Light' ) {
		$legacy_primary_nav_color = '#ffffff';
	} else {
		$legacy_primary_nav_color = 'rgba(0,0,0,0.6)';
	}
	$menu_link = dbdb_et_get_option('menu_link', $legacy_primary_nav_color);
	
	// Output CSS for separators
	?>
	
	/* Style the separators */
	.db141_show_header_separators.et_header_style_left #top-menu > .menu-item + .menu-item:before,
	.db141_show_header_separators.et_header_style_centered #top-menu > .menu-item + .menu-item:before,
	.db141_show_header_separators.et_header_style_split #top-menu > .menu-item + .menu-item:before
	{
		position: absolute;
		left: -15px; /* Half of default 22px right padding and 4px adjust to center (to compensate for space char between li) */
		content: '|';
		font-size: smaller;
		color: <?php esc_html_e($menu_link); ?>;
	}
	
	
    /* Handle positioning for mega menus */
	.db141_show_header_separators.et_header_style_left #top-menu > .menu-item + .mega-menu:before {
	    position: relative;
	    top: 1.1em;
	}
	<?php 
}
add_action('wp_head.css', 'db141_user_css');