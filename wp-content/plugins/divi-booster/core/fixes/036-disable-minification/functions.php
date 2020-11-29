<?php 
if (!defined('ABSPATH')) { exit(); } // No direct access

remove_filter('dbdb_cache_file_content_wp_head.css', 'booster_minify_css');