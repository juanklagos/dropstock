<?php
namespace Indeed\Ihc;

class UploadFilesSecurity
{
    public function __construct()
    {
        if ( is_admin() ){
            return;
        }
        add_action( 'init', array( $this, 'process' ), 999 );
        add_action( 'ump_on_register_action', array( $this, 'removeCookieAndMediaHash'), 999 );
    }

    public function process()
    {
        $currentUri = IHC_PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if ( !ihcIsRegisterPage($currentUri) ){
            return;
        }
        $registerFields = ihc_get_user_reg_fields();
        $key = ihc_array_value_exists( $registerFields, 'file', 'type' );
        do {
            $hash = ihc_random_str( 18 );
        } while ( \Ihc_Db::doesMediaHashExists( $hash ) );
        \Ihc_Db::saveMediaHash( $hash );
        setcookie( 'ihcMedia', $hash, time() + 3600, COOKIEPATH, COOKIE_DOMAIN, false );
    }

    public function removeCookieAndMediaHash()
    {
        if ( !isset( $_COOKIE['ihcMedia'] ) ){
            return;
        }
        $hash = $_COOKIE['ihcMedia'];
        if ( \Ihc_Db::doesMediaHashExists( $hash ) ){
            \Ihc_Db::deleteMediaHash( $hash );
        }
        unset( $_COOKIE['ihcMedia'] );
    }
}
