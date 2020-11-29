<?php
namespace Indeed\Ihc;
/*
@since 8.0
*/

class WpLogin
{

    public function __construct()
    {
        $enabled = get_option( 'ihc_wp_login_custom_css' );
        if ( !$enabled ){
            return;
        }
        add_action( 'login_init', array( $this, 'loginInit' ), 9999 );
		    add_action( 'login_head', array( $this, 'loginHead' ), 9999 );
		    add_action( 'login_footer', array( $this, 'loginFooter' ), 9999 );

    }

	public function loginInit()
    {
		wp_enqueue_script('jquery');
	}

    public function loginHead()
    {
        wp_enqueue_style( 'ihc_wp_login_style', IHC_URL . 'assets/css/wp_login_custom.css', array(), false, 'all' );
        $customLogo = get_option( 'ihc_wp_login_logo_image' );
        if ( $customLogo ):?>
            <style>
                body.login div#login h1 a{
					background: url(<?php echo $customLogo;?>) top center no-repeat !important;
                }
            </style>
        <?php
        endif;
		    ?>
		    <script type="text/javascript">
            jQuery(function () {
                jQuery('input#user_login').attr('placeholder', 'Username');
                jQuery('input#user_email').attr('placeholder', 'E-mail');
                jQuery('input#user_pass').attr('placeholder', 'Password');
            });
        </script>
        <?php
    }

	public function loginFooter()
    {
	}

}
