<?php 
// Backwards compatible version of et_builder_should_load_framework filter. 
// - Used to trigger load of Divi Builder framework


// === Wrap the built-in filter for current versions === //

add_filter('et_builder_should_load_framework', 'db_apply_et_builder_should_load_framework_filter');

function db_apply_et_builder_should_load_framework_filter($should_load) {

	// Apply our version of filter
	$should_load = apply_filters('db_builder_should_load_framework', $should_load);
	
	return $should_load;
}

// === Pre-Divi 3.0.99 version - uses a workaround as no et_builder_should_load_framework filter available === //
// - Tells Divi this is the role editor page as there is a filter for that. This triggers the framework load.

add_filter('et_divi_role_editor_page', 'db_apply_et_builder_should_load_framework_filter_backwards_compat');

function db_apply_et_builder_should_load_framework_filter_backwards_compat($page) {
	
	// Only use on Divi pre-3.0.99
	if (dbdb_is_divi('3.0.99', '>=')) {
		return $page;
	}
	
	// Do nothing if no page param
	if (!isset($_GET['page'])) { 
		return $page; 
	}
	
	// Apply our version of filter
	$should_load = apply_filters('db_builder_should_load_framework', false);
	
	// If should load, return current page slug as role editor page to get Divi to load the builder
	return $should_load?$_GET['page']:$page;
}