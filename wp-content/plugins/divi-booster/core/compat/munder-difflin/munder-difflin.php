<?php
// Munder Difflin (<2.0) uses a custom version of divi-custom-script, so include modified version as wp_footer.js dependency
add_filter('wtfdivi-js-dependencies', 'dbdb_compat_munderdifflin_add_custom_script_as_dependency');

if (!function_exists('dbdb_compat_munderdifflin_add_custom_script_as_dependency')) {
	function dbdb_compat_munderdifflin_add_custom_script_as_dependency($dependencies) {
		if (wp_script_is('divi-custom-script-child', 'enqueued')) { 
			$dependencies[] = 'divi-custom-script-child';
		}
		return $dependencies;
	}
}