<?php
if (!defined('ABSPATH')) { exit(); } // No direct access

/* === Add footer via jQuery as default === */
// -- Provides support for old versions of Divi
// -- Maintains functionality of shortcodes (et_option filter strips script tags)
// -- Keeps dates correct around New Year, even if caching in place

add_action('db_user_jquery', 'db067_add_footer_jquery_fallback');

function db067_add_footer_jquery_fallback() {
		
	// Get the custom footer from the Divi Booster settings
	$footerhtml = db067_get_footer_credit();
	
	// Process shortcodes in the footer html
	$footerhtml = do_shortcode($footerhtml);
	
	// Output the footer jQuery
	?>
	$('#footer-info').html(<?php echo json_encode($footerhtml); ?>);
	<?php
}

// [year] shortcode => 2019
function wtfdivi067_year_shortcode() { return '<span class="divibooster_year"></span><script>jQuery(function($){$(".divibooster_year").text(new Date().getFullYear());});</script>'; }
add_shortcode('year', 'wtfdivi067_year_shortcode');

// [yr] shortcode => 19
function wtfdivi067_yr_shortcode() { return '<span class="divibooster_yr"></span><script>jQuery(function($){$(".divibooster_yr").text(new Date().getFullYear().toString().substr(2,2));});</script>'; }
add_shortcode('yr', 'wtfdivi067_yr_shortcode');

// [copy] shortcode => &copy;
function wtfdivi067_copy_shortcode() { return '&copy;'; }
add_shortcode('copy', 'wtfdivi067_copy_shortcode');


/* === Add footer via et_option filter === */
// -- Better for SEO, etc

add_filter('et_get_option_et_divi_custom_footer_credits', 'db067_set_footer_credit');

function db067_set_footer_credit($credit) {

	// Get the custom footer from the Divi Booster settings
	$footerhtml = db067_get_footer_credit();
	
	// Do nothing if no custom footer set
	if (!$footerhtml) { return $credit; }
	
	// Process custom shortcodes as simple string replacements
	$footerhtml = str_ireplace('[copy]', '&copy;', $footerhtml);
	$footerhtml = str_ireplace('[yr]', date('y'), $footerhtml);
	$footerhtml = str_ireplace('[year]', date('Y'), $footerhtml);

	// Process shortcodes in the footer html
	$footerhtml = do_shortcode($footerhtml);

	return $footerhtml;
}

/* === Helper functions === */

function db067_get_footer_credit() {
	
	$option = get_option('wtfdivi');
	
	// Do nothing if something is wrong with the option
	if (!$option) { 
		return false; 
	}
	
	// Get the footer data
	if (!isset($option['fixes']['067-edit-footer-html'])) { 
		return false; 
	}
	$footer_data = $option['fixes']['067-edit-footer-html'];
	
	// Do nothing if custom footer not enabled
	if (empty($footer_data['enabled']) || !$footer_data['enabled']) {
		return false; 
	}
	
	// Get the footer HTML
	$footerhtml = (empty($footer_data['footerhtml']) || !is_string($footer_data['footerhtml']))?'':$footer_data['footerhtml'];
	$footerhtml = preg_replace('#</?p(\s[^>]*)?>#i', '', $footerhtml); // Strip paragraph tags as it breaks the formatting 
	$footerhtml = str_replace('”', '"', $footerhtml); // Fix bad double quotes
	
	return $footerhtml;
}

/* === Preserve Divi footer in Divi Den Pro === */

add_action('init', 'db067_ddp_preserve_footer');

function db067_ddp_preserve_footer() {
	
	// Ensure WP's plugin.php is loaded 
	include_once(ABSPATH.'wp-admin/includes/plugin.php');
	
	// If Divi Den Pro installed, modify the footer id
	if (is_plugin_active('ddpro/ddpro.php')) {
		add_action('wp_footer', 'db067_ddp_change_footer_id', 9);
		add_action('wp_footer', 'db067_ddp_restore_footer_id', 11);
	}
}

function db067_ddp_change_footer_id() {
	?>
	<script>
	(function($) {
		$('footer#main-footer').attr("id","main-footer-tmp");
	})(jQuery);
	</script>
	<?php
}

function db067_ddp_restore_footer_id() {
	?>
	<script>
	(function($) {
		$('footer#main-footer-tmp').attr("id","main-footer");
	})(jQuery);
	</script>
	<?php
}

/* === END: Keep Divi footer in Divi Den Pro === */