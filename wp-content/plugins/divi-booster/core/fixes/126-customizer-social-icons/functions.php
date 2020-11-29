<?php
if (!defined('ABSPATH')) { exit(); } // No direct access

// Register the icon styles
function db121_enqueue_scripts() { 
	$icons = db121_get_icons();
	if (empty($icons)) { return; }
	
	wp_register_style('db121_socicons', plugin_dir_url(__FILE__).'icons.css', array(), BOOSTER_VERSION);
	
	// Load the icon styles
	wp_enqueue_style('db121_socicons'); // Divi-specific socicon CSS
	wp_enqueue_style('dbdb-icons-socicon'); // Socicon font
	add_action('wp_head', 'dbdb_icons_socicon_inline_css');
}
add_action('wp_enqueue_scripts', 'db121_enqueue_scripts');

// === Define supported networks 
function db121_get_networks() {
	return array(''=>'--- Select Icon ---') + dbdb_icons_socicon_network_names();
}

// Convert json string to an array
// - returns an empty array on error
function db121_json2arr($val) {
	$result = json_decode($val, true); 
	return is_array($result)?$result:array(); 
}

/* Add customizer section */
add_action('customize_register', 'db121_customize_register');
function db121_customize_register($wp_customize){
	
	/* Custom controls */
	class DB121_Customize_Control extends WP_Customize_Control {
		
		public function render_content() {
		
			// Load the model
			$model = db121_json2arr($this->value()); 
			
			// Load the customizer jquery
			include(dirname(__FILE__).'/customizer.js.php'); 
			?>

			<input type="text" id="model_icons" <?php $this->link(); ?> value="<?php esc_attr_e($this->value()); ?>" style="display:none;"/>

			<?php 
			
			// Include the box template and new box button
			include(dirname(__FILE__).'/templates/box.php');
			include(dirname(__FILE__).'/templates/add-new.php');

		}
    }
	
	// Register "divi booster" customizer section 
	$wp_customize->add_panel('divibooster-main', array(
		'title'=>'Divi Booster',
		'priority' => 30 // make sure it shows above widgets / menus to stop jumping
	));
	
	// Register social media customizer sub-section
	$wp_customize->add_section('divibooster-social-icons', array(
		'title' => 'Social Media Icons',
		'panel' => 'divibooster-main'
	) );
	
	// Register the setting
	$wp_customize->add_setting('wtfdivi[fixes][126-customizer-social-icons][icons]', array(
		'type' => 'option',
		'transport' => 'refresh',
		'default'=>'[{"id":"","name":"(No network set)","url":""}]'
		)
	);
	$wp_customize->add_control(
		new DB121_Customize_Control($wp_customize, 'db121_control',
			array(
				'label'      => 'Select Icon',
				'section'    => 'divibooster-social-icons',
				'settings'   => 'wtfdivi[fixes][126-customizer-social-icons][icons]'
			)
		)
	); 
}

// === Add Icons to page

add_filter('et_html_top_header', 'db126_add_icons_to_html'); // Divi 3.1+
add_action('wp_head', 'db121_icon_js'); // JS fallback, footer icons and Extra

function db126_add_icons_to_html($html) {
	$icons = db121_get_icons();
	if (empty($icons) || !is_array($icons)) { return $html; }
	foreach($icons as $k=>$icon) { 
		if (!empty($icon['id'])) {
			$html = preg_replace(
				'/('.preg_quote('<ul class="et-social-icons"', '/').'.*?)('.preg_quote('</ul>', '/').')/s', 
				'\\1 '.db126_icon_html_divi($icon).'\\2', 
				$html
			);
		}
	}
	return $html;
}

function db121_icon_js() {
	$icons = db121_get_icons();
	if (empty($icons)) { return; }
	?>
	<script>
	jQuery(function($) {
		<?php 
		foreach($icons as $k=>$icon) { 
			$id = empty($icon['id'])?false:$icon['id'];
			if ($id) {
				?>
				if ($('#top-header .socicon-<?php esc_attr_e($id); ?>').length === 0) {
					$('#top-header .et-social-icons').append(<?php echo json_encode(db126_icon_html_divi($icon)); ?>);
					$('#top-header .et-extra-social-icons').append(<?php echo json_encode(db126_icon_html_extra($icon)); ?>);
				}
				if ($('#footer-bottom .socicon-<?php esc_attr_e($id); ?>').length === 0) {
					$('#footer-bottom .et-social-icons').append(<?php echo json_encode(db126_icon_html_divi($icon)); ?>);
					$('#footer-bottom .et-extra-social-icons').append(<?php echo json_encode(db126_icon_html_extra($icon)); ?>);
				}
				if ($('.et_slide_in_menu_container .socicon-<?php esc_attr_e($id); ?>').length === 0) {
					$('.et_slide_in_menu_container .et-social-icons').append(<?php echo json_encode(db126_icon_html_divi($icon)); ?>);
					$('.et_slide_in_menu_container .et-extra-social-icons').append(<?php echo json_encode(db126_icon_html_extra($icon)); ?>);
				}
				<?php 
			}
		}
		?>
	});
	</script>
	<?php  
}

function db121_get_icons() {
	$option = get_option('wtfdivi');
	if (empty($option['fixes']['126-customizer-social-icons']['icons'])) { return array(); }
	$icons = json_decode($option['fixes']['126-customizer-social-icons']['icons'], true); // decode json to php array
	// Exits
	if (empty($icons) || !is_array($icons)) { return array(); } // Icons not set
	if (count($icons) == 1) { return array(); } // Only have the icon template, no actual icons
	return $icons;
}

function db126_icon_html_divi($icon) {
	$id = empty($icon['id'])?false:$icon['id'];
	$networks = db121_get_networks();
	$span = isset($networks[$id])?'<span>'.esc_html($networks[$id]).'</span>':'';
	return '<li class="et-social-icon"><a href="'.esc_attr(db126_get_icon_url($icon)).'" class="icon socicon socicon-'.esc_attr($id).'">'.$span.'</a></li>';
}

function db126_icon_html_extra($icon) {
	$id = empty($icon['id'])?false:$icon['id'];
	return '<li class="et-extra-social-icon"><a href="'.esc_attr(db126_get_icon_url($icon)).'" class="et-extra-icon et-extra-icon-background-hover socicon socicon-'.esc_attr($id).'"></a></li>';
}

function db126_get_icon_url($icon) {
	$url = empty($icon['url'])?'':$icon['url'];
	$scheme = parse_url($url, PHP_URL_SCHEME);
	$path = parse_url($url, PHP_URL_PATH);
	$url = (empty($scheme) && !empty($path))?"http://$url":$url; // add the scheme if missing
	return $url;
}

// In customizer preview, replace the red circle on icon links with an alert box, so it doesn't look like there has been an error adding the link
function db121_improve_customizer_warning() {
	if (is_customize_preview()) {
		?>
		<style>
		.et-social-icon > a.customize-unpreviewable { cursor: pointer !important; }
		</style>
		<script>
		jQuery(function($){
			/* Improve customizer link disabled notification */
			$(document).on('click', '.et-social-icon > a.customize-unpreviewable', function(){ 
				alert('External links are disabled in the customizer preview.'); 
			});
		});
		</script>
		<?php
	}
}
add_action('wp_head', 'db121_improve_customizer_warning');