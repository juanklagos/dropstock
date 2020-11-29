<?php
namespace Indeed\Ihc;
/*
@since 7.4
*/
class Filters
{

    public function __construct()
    {
        add_filter( 'wp_nav_menu_objects', array( $this, 'ihc_filter_public_nav_menu' ), 999, 1 );
    }

    public function ihc_filter_public_nav_menu( $items=array() )
    {
        if ( !$items ){
            return $items;
        }
        foreach ($items as $itemData){
            if (stripos( $itemData->url, '?ihc-modal=login' )){
                $itemData->url = ''; // #
                $itemData->classes[] = 'ihc-modal-trigger-login';
                add_action( 'get_footer', array($this, 'ihc_insert_modal_login'), 999, 1 );
                continue;
            }
            if (stripos( $itemData->url, '?ihc-modal=register' )){
                $itemData->url = '';// #createuser
                $itemData->classes[] = 'ihc-modal-trigger-register';
                add_action( 'get_footer', array($this, 'ihc_insert_modal_register'), 999, 1 );
                continue;
            }
        }
        return $items;
    }

    public function ihc_insert_modal_login( $name='' )
    {
        echo ihc_login_popup( array('trigger' => 'ihc-modal-trigger-login') );
    }

    public function ihc_insert_modal_register( $name='' )
    {
        echo ihc_register_popup( array('trigger' => 'ihc-modal-trigger-register') );
    }

}
