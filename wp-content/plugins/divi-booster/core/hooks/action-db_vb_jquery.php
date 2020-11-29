<?php

function db_vb_jquery() { 
	if (isset($_GET['et_fb']) && $_GET['et_fb'] === '1') {
		?>
		<script>
		
		<?php 
		do_action('db_vb_js'); 
		
		if (has_action('db_vb_jquery_ready')) {
			?>
			jQuery(function($){
				<?php do_action('db_vb_jquery_ready'); ?> 
			});
			<?php	
		}
		?>
		</script>
		<?php
	}
}
add_action('wp_footer', 'db_vb_jquery');