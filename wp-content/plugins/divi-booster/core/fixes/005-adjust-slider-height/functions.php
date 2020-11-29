<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

function db005_user_css($plugin) { 
	
	$height = intval(dbdb_option('005-adjust-slider-height', 'sliderheight'));
	
	if ($height) {
		?>
		@media only screen and (min-width:981px) {
			.et_pb_slider:not(.et_pb_gallery), 
			.et_pb_slider:not(.et_pb_gallery) .et_pb_container { 
				height: <?php esc_html_e($height); ?>px !important; 
			}
			.et_pb_slider:not(.et_pb_gallery), 
			.et_pb_slider:not(.et_pb_gallery) .et_pb_slide { 
				max-height: <?php esc_html_e($height); ?>px; 
			}
			.et_pb_slider:not(.et_pb_gallery) .et_pb_slide_description { 
				position: relative; 
				top:25%; 
				padding-top: 15px !important;
				padding-bottom: 15px !important;
				margin-top: -15px !important;
				height:auto !important; 
			}
		}
		<?php 
	}
}
add_action('wp_head.css', 'db005_user_css');