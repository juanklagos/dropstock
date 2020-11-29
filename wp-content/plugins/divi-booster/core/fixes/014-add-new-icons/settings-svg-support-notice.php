<?php

add_action('db014_setting_after', 'db014_svg_support_notice');

if (!function_exists('db014_svg_support_notice')) {
	function db014_svg_support_notice() {
		if (!db014_svg_supported()) { ?>
			<p>Note: to use SVGs, add SVG support to WordPress with a plugin such as <a href="https://wordpress.org/plugins/svg-support/" target="_blank">SVG Support</a>.</p>
		<?php
		}
	}
}

if (!function_exists('db014_svg_supported')) {
	function db014_svg_supported() {
		$svg_support_plugin_enabled = is_plugin_active('svg-support/svg-support.php');
		$svg_supported = $svg_support_plugin_enabled;
		return apply_filters('db014_svg_supported', $svg_supported);
	}
}