<?php
namespace Indeed\Ihc;

class Ajax
{
    /**
     * @param none
     * @return none
     */
    public function __construct()
    {
        add_action('wp_ajax_ihc_admin_send_email_popup', array($this, 'ihc_admin_send_email_popup') );
        add_action('wp_ajax_ihc_admin_do_send_email', array($this, 'ihc_admin_do_send_email') );
        add_action('wp_ajax_ihc_generate_direct_link', array($this, 'ihc_generate_direct_link') );
        add_action('wp_ajax_ihc_generate_direct_link_by_uid', array($this, 'ihc_generate_direct_link_by_uid') );
        add_action('wp_ajax_ihc_direct_login_delete_item', array($this, 'ihc_direct_login_delete_item') );
        add_action('wp_ajax_ihc_save_reason_for_cancel_delete_level', array($this, 'ihc_save_reason_for_cancel_delete_level') );
        add_action('wp_ajax_nopriv_ihc_save_reason_for_cancel_delete_level', array($this, 'ihc_save_reason_for_cancel_delete_level') );
        add_action( 'wp_ajax_ihc_close_admin_notice', array( $this, 'ihc_close_admin_notice' ) );
        add_action( 'wp_ajax_ihc_remove_media_post', array( $this, 'ihc_remove_media_post' ) );
        add_action( 'wp_ajax_nopriv_ihc_remove_media_post', array( $this, 'ihc_remove_media_post' ) );
        add_action( 'wp_ajax_nopriv_ihc_update_list_notification_constants', array( $this, 'ihc_update_list_notification_constants' ) );
        add_action( 'wp_ajax_ihc_update_list_notification_constants', array( $this, 'ihc_update_list_notification_constants' ) );
        add_action( 'wp_ajax_ihc_admin_list_users_total_spent_values', array( $this, 'usersTotalSpentValues') );
    }

    /**
     * @param none
     * @return none
     */
    public function ihc_admin_send_email_popup()
    {
        if ( !indeedIsAdmin() ){
            die;
        }
        if ( !ihcAdminVerifyNonce() ){
            die;
        }
        $uid = empty($_POST['uid']) ? 0 : esc_sql($_POST['uid']);
        if (empty($uid)){
            die;
        }
        $toEmail = \Ihc_Db::get_user_col_value($uid, 'user_email');
        if (empty($toEmail)){
            die;
        }
        $fromEmail = '';
        $fromEmail = get_option('ihc_notifications_from_email_addr');
        if (empty($fromEmail)){
            $fromEmail = get_option('admin_email');
        }
        $view = new \Indeed\Ihc\IndeedView();
        $view->setTemplate(IHC_PATH . 'admin/includes/tabs/send_email_popup.php');
        $view->setContentData([
                                'toEmail' 		=> $toEmail,
                                'fromEmail' 	=> $fromEmail,
                                'fullName'		=> \Ihc_Db::getUserFulltName($uid),
                                'website'			=> get_option('blogname')
        ], true);
        echo $view->getOutput();
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function ihc_admin_do_send_email()
    {
        if ( !indeedIsAdmin() ){
            die;
        }
        if ( !ihcAdminVerifyNonce() ){
            die;
        }
        $to = empty($_POST['to']) ? '' : esc_sql($_POST['to']);
        $from = empty($_POST['from']) ? '' : esc_sql($_POST['from']);
        $subject = empty($_POST['subject']) ? '' : esc_sql($_POST['subject']);
        $message = empty($_POST['message']) ? '' : stripslashes(htmlspecialchars_decode(ihc_format_str_like_wp($_POST['message'])));
        $headers = [];

        if (empty($to) || empty($from) || empty($subject) || empty($message)){
            die;
        }

        $from_name = get_option('ihc_notification_name');
        $from_name = stripslashes($from_name);
        if (!empty($from) && !empty($from_name)){
          $headers[] = "From: $from_name <$from>";
        } else if ( !empty( $from ) ){
          $headers[] = "From: <$from>";
        }
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $sent = wp_mail($to, $subject, $message, $headers);
        echo $sent;
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function ihc_generate_direct_link()
    {
        if ( !indeedIsAdmin() ){
            die;
        }
        if ( !ihcAdminVerifyNonce() ){
            die;
        }
        if ( empty( $_POST['username'] ) ){
            echo 'Error';
            die;
        }
        $uid = \Ihc_Db::get_wpuid_by_username( $_POST['username'] );
        if ( empty($uid) ){
            echo 'Error';
            die;
        }
        $expireTime = isset($_POST['expire_time']) ? $_POST['expire_time'] : 24;
        if ($expireTime<1){
            $expireTime = 24;
        }
        $expireTime = $expireTime * 60 * 60;
        $directLogin = new \Indeed\Ihc\Services\DirectLogin();
        echo $directLogin->getDirectLoginLinkForUser( $uid, $expireTime );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function ihc_generate_direct_link_by_uid()
    {
        if ( !indeedIsAdmin() ){
            die;
        }
        if ( !ihcAdminVerifyNonce() ){
            die;
        }
        if ( empty( $_POST['uid'] ) ){
            echo 'Error';
            die;
        }
        $directLogin = new \Indeed\Ihc\Services\DirectLogin();
        echo $directLogin->getDirectLoginLinkForUser( $_POST['uid'] );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function ihc_direct_login_delete_item()
    {
        if ( !indeedIsAdmin() ){
            echo 0;
            die;
        }
        if ( !ihcAdminVerifyNonce() ){
            echo 0;
            die;
        }
        if ( empty( $_POST['uid'] ) ){
            die;
        }
        $uid = esc_sql($_POST['uid']);
        $directLogin = new \Indeed\Ihc\Services\DirectLogin();
        $directLogin->resetTokenForUser( $uid );
        echo 1;
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function ihc_save_reason_for_cancel_delete_level()
    {
        if ( empty($_POST['lid']) || empty($_POST['reason']) || empty($_POST['action_type']) ){
           die;
        }
        if ( !ihcPublicVerifyNonce() ){
            die;
        }
        $uid = ihc_get_current_user();
        if ( !$uid ){
            die;
        }
        $reasonDbObject = new \Indeed\Ihc\Db\ReasonsForCancelDeleteLevels();
        $made = $reasonDbObject->save(array(
            'uid'         => $uid,
            'lid'         => esc_sql($_POST['lid']),
            'reason'      => esc_sql($_POST['reason']),
            'action_type' => esc_sql($_POST['action_type']),
        ));
        if ( $made ){
            echo 1;
            die;
        }
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function ihc_close_admin_notice()
    {
        if ( !indeedIsAdmin() ){
            die;
        }
        if ( !ihcAdminVerifyNonce() ){
            die;
        }
        update_option( 'ihc_hide_admin_license_notice', 1 );
        echo 1;
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function ihc_remove_media_post()
    {
        if ( empty( $_POST['postId'] ) ){
            return;
        }
        if ( !ihcPublicVerifyNonce() ){
            die;
        }
        wp_delete_attachment( esc_sql( $_POST['postId'] ), true );
        die;
    }

    /**
     * @param none
     * @return none
     */
    public function ihc_update_list_notification_constants()
    {
        if ( !indeedIsAdmin() ){
            die;
        }
        if ( !ihcAdminVerifyNonce() ){
            die;
        }
        if ( empty( $_POST['notificationType'] ) ){
            die;
        }
        $data = ihcNotificationConstants( esc_sql( $_POST['notificationType'] ) );
        if ( !$data ){
            die;
        }
        foreach ( $data as $constant => $value ){
            echo '<div>' . $constant . '</div>';
        }
        die;
    }

    /**
     * @param none
     * @return string
     */
    public function usersTotalSpentValues()
    {
        global $wpdb;
        if ( !indeedIsAdmin() ){
            die;
        }
        if ( !ihcAdminVerifyNonce() ){
            die;
        }
        if ( empty( $_POST['users'] ) ){
            die;
        }
        $ids = esc_sql( $_POST['users'] );
        $queryString = $wpdb->prepare( "SELECT SUM(amount_value) AS sum, uid FROM {$wpdb->prefix}ihc_orders WHERE uid IN ($ids) GROUP BY uid" );
        $data = $wpdb->get_results( $queryString );
        if ( !$data ){
            die;
        }
        foreach ( $data as $object ){
            $array[$object->uid] = $object->sum;
        }
        echo json_encode( $array );
        die;
    }

}
