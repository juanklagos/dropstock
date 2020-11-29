<?php

if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}


// if (is_admin()) {
	$module_files = glob( __DIR__ . '/modules/*/*.php' );
	// Load custom Divi Builder modules
	foreach ( (array) $module_files as $module_file ) {
		if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file ) ) {
			require_once $module_file;
		}
	}
// } else {
//
//
// if ( is_singular() ) {
//
// 	$post_id = "99";
//
// 	if ( et_builder_bfb_enabled() || et_core_is_fb_enabled() || !et_pb_is_pagebuilder_used( $post_id ) ) {
// 		return;
// 	}
// 	$content = get_the_content( false, false, $post_id );
// 	// Find all registered tag names in $content.
// 	// preg_match_all( '@\[et_pb_db_([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
// 	preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
// 	// Only need unique tag names
// 	$unique_matches = array_unique( $matches[1] );
// 	// echo '<pre>' . print_r( $unique_matches, true ) . '</pre>';
//
// $our_modules = glob( __DIR__ . '/modules/*/*.php' );
//
//
//
// foreach($unique_matches as $item) {
// echo $item;
//
// 	foreach ( (array) $our_modules as $our_module ) {
//
// 	$strimmed_val = str_replace(__DIR__, "",$our_module);
//
// 	if (strpos($strimmed_val, $item) !== false) {
// 	    require_once dirname( __FILE__ ) .'/modules/'.$item.'/'.$item.'.php';
// 	}
//
// 	}
//
//
// }
//
// }
// }
