<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function create_db_checkout_post_type() {


    register_post_type( 'bc_checkout',
        array(
            'labels' => array(
                'name' => 'BC Checkout Fields',
                'singular_name' => 'BC Checkout Field',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New BC Checkout Field',
                'edit' => 'Edit',
                'edit_item' => 'Edit BC Checkout Field',
                'new_item' => 'New BC Checkout Field',
                'view' => 'View',
                'view_item' => 'View BC Checkout Field',
                'search_items' => 'Search BC Checkout Field',
                'not_found' => 'No BC Checkout found',
                'not_found_in_trash' => 'No BC Checkout Field found in Trash',
                'parent' => 'Parent BC Checkout Field'
            ),

            'public' => false,
            'query_var' => false,
            'show_ui' => TRUE,
            'exclude_from_search' => true,
            'publicaly_queryable' => false,
            'query_var' => false,
            'supports' => array( 'title', 'custom-fields', ),
            'has_archive' => false,
            'show_in_menu' => 'divi-engine',
            'menu_position' => 3
        )
    );


}
add_action( 'init', 'create_db_checkout_post_type' );



?>
