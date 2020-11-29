<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

add_filter('body_class', 'dbdb128_apply_page_layout_class', 11);

function dbdb128_apply_page_layout_class($classes) {
	foreach($classes as $key=>$class) {
		if ($class === 'et_no_sidebar' && dbdb_is_pagebuilder_used()) {
			$selected_layout = dbdb128_get_page_layout(dbdb_get_current_post_id());
			if ($selected_layout) {
				$classes[$key] = $selected_layout;
			}
		}
	}
	return $classes;
}

function divibooster128_admin_css() { 
?>
<style>
/* Show the layout settings */
.et_pb_page_layout_settings { 
	display:block !important; 
}</style>
<?php
};

function divibooster128_admin_js() { 
	?>
	<script>
	jQuery(function($){
		<?php if (!dbdb128_get_page_layout(dbdb_get_current_post_id()) && dbdb_is_pagebuilder_used()) { ?>
			dbdb128_setSelectedPageLayout('et_full_width_page');
		<?php } ?>
		$('#et_pb_toggle_builder:not(.et_pb_builder_is_used)').click(function(){
			 dbdb128_setSelectedPageLayout('et_full_width_page');
		});
		
		$(document).on('click', '[data-action="deactivate_builder"] .et_pb_prompt_proceed', function() { 
			dbdb128_setSelectedPageLayout('et_right_sidebar');
		});
		
		function dbdb128_setSelectedPageLayout(layout_val) {
			$(<?php echo json_encode(dbdb_css_selector('page_layout_select_box')); ?>).val(layout_val);
		}
	});
	</script>
	<?php
};

function divibooster128_user_css() {  ?>
/* make the rows fill the content area */
.page-template-default.et_pb_pagebuilder_layout:not(.et_full_width_page) #content-area #left-area .et_pb_row {
	width: 100%;
}

/* Hide the page title / featured image */
.page-template-default.et_pb_pagebuilder_layout:not(.et_full_width_page) .et_featured_image, 
.page-template-default.et_pb_pagebuilder_layout:not(.et_full_width_page) .main_title { 
	display: none; 
}

/* Remove excess padding at start */
.page-template-default.et_pb_pagebuilder_layout:not(.et_full_width_page) #main-content .container { 
	padding-top: 0px; 
}
.page-template-default.et_pb_pagebuilder_layout:not(.et_full_width_page) #sidebar { 
	margin-top: 58px; 
}
<?php
};

// Only make available in Divi. Would kill extra as et_pb_is_pagebuilder_used() not pluggable.
if (dbdb_is_divi()) {
	
	// Register the user CSS
	add_action('wp_head.css', 'divibooster128_user_css');	
	
	$supported_post_types = array('page');
	
	// Get the current post type
	$current_post_type = '';
	if (isset($_GET['post_type'])) {
		$current_post_type = $_GET['post_type'];
	} elseif (isset($_GET['post'])) {
		$current_post_type = get_post_type($_GET['post']);
	}
	
	if (in_array($current_post_type, $supported_post_types)) {
		
		// Register the admin / CSS
		add_action('admin_head', 'divibooster128_admin_css');
		add_action('admin_head', 'divibooster128_admin_js');
	
		// Override et_pb_is_pagebuilder_used() to make page.php think pagebuilder not used
		if (!function_exists('et_pb_is_pagebuilder_used')) {
			
			function et_pb_is_pagebuilder_used( $page_id = 0 ) {
				
				if ( 0 === $page_id && function_exists('et_core_page_resource_get_the_ID')) {
					$page_id = et_core_page_resource_get_the_ID();
				}
				
				try {
					// Get the function caller
					$bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
					$caller = array_shift($bt);
					
					// If called from within page.php template, 
					if (isset($caller['file']) and basename($caller['file'])==='page.php') {
						
						$layout = dbdb128_get_page_layout($page_id);
						
						// and we are using a sidebar
						if ($layout!=='et_full_width_page') {
							
							// pretend that this isn't pagebuilder
							return false;
						}
					}
				} catch (Exception $e) {}
				
				// Otherwise, return normal result
				return ('on' === get_post_meta($page_id, '_et_pb_use_builder', true));
			}
		}
	}
}

function dbdb128_get_page_layout($post_id) {
	return get_post_meta($post_id, '_et_pb_page_layout', true);
}


/* === Begin: enable page layout option for learndash === */

$supported_post_types = array(
	'sfwd-courses',			// learndash courses
	'sfwd-lessons',			// learndash lessons,
	'sfwd-quiz',			// learndash quizes
	'sfwd-topic',			// learndash topics
	'sfwd-certificates'		// learndash certificates
);

// Get the current post type
$current_post_type = '';
if (isset($_GET['post_type'])) {
	$current_post_type = $_GET['post_type'];
} elseif (isset($_GET['post'])) {
	$current_post_type = get_post_type($_GET['post']);
}

add_action('wp_head', 'divibooster128_user_css_learndash');

// If the current post type is supported
if (in_array($current_post_type, $supported_post_types)) {
	add_action('admin_head', 'divibooster128_admin_css_learndash');
}

function divibooster128_admin_css_learndash() { ?>
<style>
/* Show the layout settings */
.et_pb_page_layout_settings { 
	display:block !important; 
}
</style>
<?php
};

function divibooster128_user_css_learndash() { 
	$supported_post_types = array(
		'sfwd-courses',			// learndash courses
		'sfwd-lessons',			// learndash lessons,
		'sfwd-quiz',			// learndash quizes
		'sfwd-topic',			// learndash topics
		'sfwd-certificates'		// learndash certificates
	);
	$post_id = dbdb_get_current_post_id();
	if ($post_id && in_array(get_post_type($post_id), $supported_post_types)) {
?>
<style>
/* === Style learndash pages === */

/* Set the main learndash content to the standard Divi content width */
.et_pb_pagebuilder_layout.et_full_width_page .entry-content > .learndash > *:not(.et_pb_section) {
	width: 80%;
	max-width: 1080px;
	margin: 10px auto;
}

/* Convert span tag items (course status, etc) into block elements so width obeyed */
.et_pb_pagebuilder_layout.et_full_width_page .entry-content > .learndash > span {
	display: block;
}
.et_pb_pagebuilder_layout.et_full_width_page .entry-content > .learndash > br {
	display: none; 
}

/* Make the Divi Builder content full-width */
.et_pb_pagebuilder_layout.et_full_width_page .entry-content > .learndash > .learndash_content { 
	width: 100%; 
	max-width: 100%;
}

/* Set row width on sidebar layouts to match page builder on posts format */
.et_pb_pagebuilder_layout.et_right_sidebar .entry-content > .learndash .et_pb_row,
.et_pb_pagebuilder_layout.et_left_sidebar .entry-content > .learndash .et_pb_row,
.et_pb_pagebuilder_layout.et_right_sidebar .sfwd-certificates .et_pb_row,
.et_pb_pagebuilder_layout.et_left_sidebar .sfwd-certificates .et_pb_row {
	width: 100%;
}
.et_pb_pagebuilder_layout.et_right_sidebar .entry-content > .learndash .et_pb_with_background .et_pb_row, 
.et_pb_pagebuilder_layout.et_left_sidebar .entry-content > .learndash .et_pb_with_background .et_pb_row,
.et_pb_pagebuilder_layout.et_right_sidebar .sfwd-certificates .et_pb_with_background .et_pb_row,
.et_pb_pagebuilder_layout.et_left_sidebar .sfwd-certificates .et_pb_with_background .et_pb_row {
	width: 80%;
}
</style>
<?php
	}
};

/* === End enable page layout option for learndash === */