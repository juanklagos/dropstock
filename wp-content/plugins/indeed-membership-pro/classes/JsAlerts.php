<?php
namespace Indeed\Ihc;

class JsAlerts
{
    /**
     * @var string
     */
    private static $error       = '';
    /**
     * @var string
     */
    private static $warning     = '';
    /**
     * @var string
     */
    private static $info        = '';

    /**
     * @param none
     * @return none
     */
    public function __construct()
    {
        add_action( 'the_content', [ $this, 'output' ], 9999, 1 );
    }

    /**
     * @param string
     * @return none
     */
    public static function setError( $text = '' )
    {
        setcookie( 'ihc_error', $text, time() + 60 * 60 , '/' );
    }

    /**
     * @param string
     * @return none
     */
    public static function setWarning( $text = '' )
    {
        setcookie( 'ihc_warning', $text, time() + 60 * 60 , '/' );
    }

    /**
     * @param string
     * @return none
     */
    public static function setInfo( $text = '' )
    {
        setcookie( 'ihc_info', $text, time() + 60 * 60 , '/' );
    }

    /**
     * @param string
     * @return none
     */
    public function output( $content = '' )
    {
        if ( !empty( $_COOKIE['ihc_error'] ) ){
            $data['error'] = $_COOKIE['ihc_error'];
        }
        if ( !empty( $_COOKIE['ihc_info'] ) ){
            $data['info'] = $_COOKIE['ihc_info'];
        }
        if ( !empty( $_COOKIE['ihc_warning'] ) ){
            $data['warning'] = $_COOKIE['ihc_warning'];
        }
        if ( empty( $data ) ){
            return $content;
        }
        $view = new \Indeed\Ihc\IndeedView();
        echo $view->setTemplate( IHC_PATH . 'public/views/js_alerts.php' )->setContentData( $data, true )->getOutput();
    }

}
