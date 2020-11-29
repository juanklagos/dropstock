<?php 

// Hook - user jquery
function db_user_jquery() { ?>

	<?php 
	do_action('db_user_js'); 
	?>
	
	jQuery(function($){
		<?php do_action('db_user_jquery'); ?>
	});
<?php
}
add_action('wp_footer.js', 'db_user_jquery');