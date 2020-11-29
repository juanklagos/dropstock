<?php
include_once(dirname(__FILE__).'/add-site-title-and-tagline-to-header.php');

if (!dbdb_enabled('133-header-title-and-tagline')) {
	remove_action('init', 'db133_load');
}

