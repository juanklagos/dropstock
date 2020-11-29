<?php
if (!defined('ABSPATH')) { exit(); } // No direct access

// Add to wp_footer as doesn't work when set in wp_footer.js hook for some reason
add_action('wp_footer', 'db140_configure_image_links_to_open_in_lightbox'); 

function db140_configure_image_links_to_open_in_lightbox($plugin) { 
	?>
	<script>
	jQuery(function($) {
			
			var $links = $('.entry-content a, .et_pb_post_content a').filter(db_is_image_link).not(db_is_gallery_image_link);
			$links.filter(db_has_child_img).addClass('et_pb_lightbox_image'); 
			$links.not(db_has_child_img).magnificPopup({type:'image'});
			
			dbdb_enableLightboxOnMapModuleImages();

			function dbdb_enableLightboxOnMapModuleImages() {
				setTimeout(
					function() {
						$('.et_pb_map a')
							.filter(db_is_image_link)
							.filter(db_has_child_img)
							.magnificPopup({type:'image'});
					}, 
					2000
				);
			}
			
			function db_has_child_img() {
				return ($(this).children('img').length);
			}
			
			function db_is_image_link() {
				return (/\.(?:jpg|jpeg|gif|png|bmp)$/i.test($(this).attr('href')));
			}
			
			function db_is_gallery_image_link() {
				return ($(this).parent().hasClass("et_pb_gallery_image")); 
			}
		}
	);
	</script>
	<?php 
}
