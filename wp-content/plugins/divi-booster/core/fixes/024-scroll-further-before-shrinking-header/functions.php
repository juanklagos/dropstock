<?php
add_action('wp_head.css', 'db024_hide_centered_header_on_scroll');

function db024_hide_centered_header_on_scroll() {
	?>
	body.et_hide_fixed_logo .et-fixed-header .centered-inline-logo-wrap {
		width: 0 !important;
	}
	<?php
}