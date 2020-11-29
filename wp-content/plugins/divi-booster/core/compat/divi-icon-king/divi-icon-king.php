<?php

add_filter('DBDBCustomIcon_font_icon_symbols_priority', 'dbdb_compat_diviiconking_defer_icon_registration');
add_action('dbdb_014-add-new-icons_after', 'dbdb_compat_diviiconking_add_icon_picker_filter_link');

if (!function_exists('dbdb_compat_diviiconking_add_icon_picker_filter_link')) {
	function dbdb_compat_diviiconking_add_icon_picker_filter_link() {
		add_action('db_admin_jquery', 'dbdb_compat_diviiconking_add_icon_picker_filter_link_jquery');
		add_action('db_vb_jquery', 'dbdb_compat_diviiconking_add_icon_picker_filter_link_jquery');
	}
}

if (!function_exists('dbdb_compat_diviiconking_add_icon_picker_filter_link_jquery')) {
	function dbdb_compat_diviiconking_add_icon_picker_filter_link_jquery() {
		?>
		// Add filter link if Divi Icon King used
		$(document).on( 'click', '.dikg_icon_filter__btn', function() {
			$('[data-icon^=wtfdivi]').attr('data-family', 'divi-booster').removeClass('gtm-divi-king-icon--elegant-themes').toggleClass('gtm-divi-king-icon--divi-booster', true);
			if ($('.dikg_icon_filter__control_option[data-value=divi-booster]').length === 0) {
				$('.dikg_icon_filter__control_option[data-value=elegant-themes]').after($('<span class="dikg_icon_filter__control_option dikg_icon_filter__control_option--inactive dikg_icon_filter__control_family dikg_icon_filter__control_option--active" data-value="divi-booster">Divi Booster</span>'));
			}
		});
		<?php
	}
}

if (!function_exists('dbdb_compat_diviiconking_defer_icon_registration')) {
	function dbdb_compat_diviiconking_defer_icon_registration($priority) {
		return max($priority, 50); // Prevents Divi Icon King from deleting registered icons
	}
}