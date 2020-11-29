<?php
/*
Plugin Name: Divi Booster
Plugin URI: 
Description: Bug fixes and enhancements for Elegant Themes' Divi Theme.
Author: Dan Mossop
Version: 3.3.5
Author URI: https://divibooster.com
*/	

define('BOOSTER_VERSION', '3.3.5'); 

if (!function_exists('dbdb_file')) {
	function dbdb_file() {
		return __FILE__;
	}
}

if (!function_exists('dbdb_path')) {
	function dbdb_path($relpath='') {
		return plugin_dir_path(dbdb_file()).$relpath;
	}
}

if (!function_exists('dbdb_plugin_basename')) {
	function dbdb_plugin_basename() {
		return plugin_basename(dbdb_file());
	}
}

if (!function_exists('dbdb_slug')) {
	function dbdb_slug() {
		return 'divi-booster';
	}
}

if (!function_exists('dbdb_update_url')) {
	function dbdb_update_url() {
		return apply_filters('dbdb_update_url', 'https://d3mraia2v9t5x8.cloudfront.net/updates.json');
	}
}

// Run unit tests if applicable
if (defined('DB_UNIT_TESTS') && DB_UNIT_TESTS && file_exists(dbdb_path('tests/tests.php'))) {
	include_once(dbdb_path('tests/tests.php'));
}


// === Configuration === //
$slug = 'wtfdivi';
define('BOOSTER_DIR', dirname(dbdb_file()));
define('BOOSTER_CORE', BOOSTER_DIR.'/core');
define('BOOSTER_SLUG', 'divi-booster');
define('BOOSTER_SLUG_OLD', $slug);
define('BOOSTER_VERSION_OPTION', 'divibooster_version');
define('BOOSTER_SETTINGS_PAGE_SLUG', BOOSTER_SLUG_OLD.'_settings');
define('BOOSTER_NAME', __('Divi Booster', BOOSTER_SLUG));

// Error Handling
define('BOOSTER_OPTION_LAST_ERROR', 'wtfdivi_last_error');
define('BOOSTER_OPTION_LAST_ERROR_DESC', 'wtfdivi_last_error_details');

// Directories
define('BOOSTER_DIR_FIXES', BOOSTER_CORE.'/fixes/');

// === Setup ===		
include(BOOSTER_CORE.'/index.php'); // Load the plugin framework
booster_enable_updates(dbdb_file()); // Enable auto-updates for this plugin

include(BOOSTER_CORE.'/update_patches.php'); // Apply update patches

// === Build the plugin ===

$sections = array(
	'general'=>'Site-wide Settings',
	'general-icons'=>'Icons',
	'general-layout'=>'Layout',
	'general-links'=>'Links',
	'general-speed'=>'Site Speed',
	'header'=>'Header',
	'header-top'=>'Top Header',
	'header-main'=>'Main Header',
	'header-mobile'=>'Mobile Header',
	'posts'=>'Posts',
	'sidebar'=>'Sidebar',
	'footer'=>'Footer',
	'pagebuilder'=>'Divi Builder',
	'pagebuilder-divi'=>'General',
	'pagebuilder-classic'=>'Classic Builder',
	'pagebuilder-visual'=>'Visual Builder',
	'modules'=>'Modules',
	'modules-accordion'=>'Accordion',
	//'modules-blurb'=>'Blurb',
	'modules-countdown'=>'Countdown',
	'modules-gallery'=>'Gallery',
	'modules-headerfullwidth'=>'Header (Full Width)',
	'modules-map'=>'Map',
	'modules-portfolio'=>'Portfolio',
	'modules-portfoliofiltered'=>'Portfolio (Filterable)',
	'modules-portfoliofullwidth'=>'Portfolio (Full Width)',
	'modules-postnav'=>'Post Navigation',
	'modules-postslider'=>'Post Slider',
	'modules-pricing'=>'Pricing Table',
	'modules-subscribe'=>'Signup',
	'modules-slider'=>'Slider',
	'modules-text'=>'Text',
	'plugins'=>'Plugins',
	'plugins-edd'=>'Easy Digital Downloads',
	'plugins-woocommerce'=>'WooCommerce',
	'plugins-other'=>'Other',
	'customcss'=>'CSS Manager',
	'developer'=>'Developer Tools',
	'developer-export'=>'Import / Export',
	'developer-css'=>'Generated CSS',
	'developer-js'=>'Generated JS',
	'developer-footer-html'=>'Generated Footer HTML',
	'developer-htaccess'=>'Generated .htaccess Rules',
	'deprecated'=>'Deprecated (now available in Divi)',
	'deprecated-divi4'=>'Divi 4',
	'deprecated-divi24'=>'Divi 2.4',
	'deprecated-divi23'=>'Pre Divi 2.4'
);

// === Set enabled-by-default fixes ===

add_filter('divibooster_fixes', 'db126_enable_feature_by_default');

function db126_enable_feature_by_default($fixes) {
	
	if (!is_array($fixes)) { return $fixes; }
	
	$enabled_by_default = array(
		'126-customizer-social-icons'
	);
	
	foreach($enabled_by_default as $fix) {
		if (!isset($fixes[$fix]['enabled'])) { 
			$fixes[$fix]['enabled'] = true;
		}
	}
	
	return $fixes;
}

// === Main plugin ===

if (!function_exists('dbdb_admin_menu_slug')) {
	function dbdb_admin_menu_slug() {
		if (dbdb_is_divi_2_4_up()) { // Recent Divis
			$result = 'et_divi_options';
		} elseif (dbdb_is_divi()) { // Early Divis
			$result = 'themes.php';
		} elseif (dbdb_is_extra()) { // Extra
			$result = 'et_extra_options';
		} else { // Assume Divi Builder
			$result = 'et_divi_options';
		}
		return $result;
	}
}

if (!function_exists('dbdb_settings_page_url')) {
	function dbdb_settings_page_url() {
		$page = (dbdb_admin_menu_slug()=='themes.php'?'themes.php':'admin.php');
		return admin_url($page.'?page=wtfdivi_settings');
	}
}

if (class_exists('wtfplugin_1_0')) {
	$wtfdivi = new wtfplugin_1_0(
		array(
			'plugin'=>array(
				'name'=>BOOSTER_NAME,
				'shortname'=>BOOSTER_NAME, // menu name
				'slug'=>$slug,
				'package_slug'=>dbdb_slug(),
				'plugin_file'=>dbdb_file(),
				'url'=>'https://divibooster.com/themes/divi/',
				'basename'=>plugin_basename(dbdb_file())
			),
			'sections'=>$sections
		)
	);
} else {
	add_action('admin_notices', 'db_admin_notice_main_class_missing');
}

// Store and return an instance of the plugin
function dbdb_plugin($instance=null) {
	static $plugin;
	if (!is_null($instance)) { 
		$plugin = $instance;
	}
	return $plugin;
}
dbdb_plugin($wtfdivi);

if (!function_exists('db_admin_notice_main_class_missing')) {
	function db_admin_notice_main_class_missing() {
		echo apply_filters('db_admin_notice_main_class_missing', '<div class="notice notice-error"><p>Error: The main Divi Booster class cannot be found. This suggests a corrupted plugin directory. Please try reinstalling Divi Booster, or <a href="https://divibooster.com/contact-form/" target="_blank">let me know</a>.</p></div>'); 
	}
}


// === Load the settings ===
function divibooster_load_settings($wtfdivi) {
	$settings_files = glob(BOOSTER_DIR_FIXES.'*/settings.php');
	if ($settings_files) { 
		foreach($settings_files as $file) { include_once($file); }
	}
}
add_action("$slug-before-settings-page", 'divibooster_load_settings');


// === Add settings page hook ===
function divibooster_settings_page_init() {
	global $pagenow, $plugin_page;
	if ($pagenow == 'admin.php' and $plugin_page == BOOSTER_SETTINGS_PAGE_SLUG) {
		do_action('divibooster_settings_page_init');
	}
}
add_action('admin_init', 'divibooster_settings_page_init');



// Load media library
function db_enqueue_media_loader() { wp_enqueue_media(); }
add_action('admin_enqueue_scripts', 'db_enqueue_media_loader', 11); // Priority > 10 to avoid visualizer plugin conflict

// =========================================================== //
// ==                          FOOTER                       == //
// =========================================================== //

// === Footer ===
function divibooster_footer() { ?>
<p>Spot a problem with this plugin? Want to make another change to the Divi Theme? <a href="https://divibooster.com/contact-form/">Let me know</a>.</p>
<p><i>This plugin is an independent product which is not associated with, endorsed by, or supported by Elegant Themes.</i></p>
<?php
}	
add_action($slug.'-plugin-footer', 'divibooster_footer');

