<?php // Compatibility with https://wordpress.org/plugins/post-types-order/

add_action('dbdb_portfolio_projectOrder_reverse_preGetPosts', 'dbdb_postTypesOrder_ignoreCustomSort');
add_action('dbdb_portfolio_projectOrder_random_preGetPosts', 'dbdb_postTypesOrder_ignoreCustomSort');
add_action('dbdb_portfolio_projectOrder_byId_preGetPosts', 'dbdb_postTypesOrder_ignoreCustomSort');

function dbdb_postTypesOrder_ignoreCustomSort($query) {
	$query->set('ignore_custom_sort', true);
}