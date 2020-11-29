<?php
namespace Indeed\Ihc\PaymentGateways;
/*
@since v.7.4
Deprecated starting with v.9.3
*/
class PayPalStandard extends \Indeed\Ihc\PaymentGateways\PaymentAbstract
{

  protected $attributes       = array();
  protected $redirectUrl      = '';
  protected $abort            = false;
  protected $paymentTypeLabel = 'Paypal Payment';
  protected $currency         = '';

    public function __construct()
    {
        $this->currency = get_option('ihc_currency');
    }

  	public function doPayment()
    {
      \Ihc_User_Logs::set_user_id(@$this->attributes['uid']);
      \Ihc_User_Logs::set_level_id(@$this->attributes['lid']);
      \Ihc_User_Logs::write_log( __('PayPal Payment: Start process', 'ihc'), 'payments');

      $paypal_email = get_option('ihc_paypal_email');
      $levels = get_option('ihc_levels');
      $sandbox = get_option('ihc_paypal_sandbox');
      $r_url = get_option('ihc_paypal_return_page');
      $cancelUrl = get_option( 'ihc_paypal_return_page_on_cancel' );

      if(!$r_url || $r_url==-1){
        $r_url = get_option('page_on_front');
      }
      $r_url = get_permalink($r_url);
      if (!$r_url){
        $r_url = get_home_url();
      }

      if( !$cancelUrl || $cancelUrl == -1 ){
        $cancelUrl = get_option('page_on_front');
      }
      $cancelUrl = get_permalink($cancelUrl);
      if ( !$cancelUrl ){
        $cancelUrl = get_home_url();
      }


      if ($sandbox){
        $this->redirectUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        \Ihc_User_Logs::write_log( __('PayPal Payment: set Sandbox mode', 'ihc'), 'payments');
      } else{
        $this->redirectUrl = 'https://www.paypal.com/cgi-bin/webscr';
        \Ihc_User_Logs::write_log( __('PayPal Payment: set Live mode', 'ihc'), 'payments');
      }

      $err = false;
      if (isset($levels[$this->attributes['lid']])){
        $level_arr = $levels[$this->attributes['lid']];
        if ($level_arr['payment_type']=='free' || $level_arr['price']=='') $err = true;
      } else {
        \Ihc_User_Logs::write_log( __('PayPal Payment: Level is free, no payment required.', 'ihc'), 'payments');
        $err = true;
      }
      // USER ID
      if (!empty($this->attributes['uid'])){
        $uid = $this->attributes['uid'];
      } else {
        $uid = get_current_user_id();
      }
      if (!$uid){
        $err = true;
        \Ihc_User_Logs::write_log( __('PayPal Payment: Error, user id not set.', 'ihc'), 'payments');
      } else {
        \Ihc_User_Logs::write_log( __('PayPal Payment: set user id @ ', 'ihc') . $uid, 'payments');
      }


      if ($err){
        ////if level it's not available for some reason, go back to prev page
        \Ihc_User_Logs::write_log( __('PayPal Payment: stop process, redirect home.', 'ihc'), 'payments');
        header( 'location:'. $r_url );
        exit();
      } else {
        $custom_data = json_encode(array('user_id' => $uid, 'level_id' => $this->attributes['lid'] ));
      }

      $site_url = site_url();
      $site_url = trailingslashit($site_url);
      $notify_url = add_query_arg('ihc_action', 'paypal', $site_url);

      \Ihc_User_Logs::write_log( __('PayPal Payment: set ipn url @ ', 'ihc') . $notify_url, 'payments');

      $reccurrence = FALSE;
      if (isset($level_arr['access_type']) && $level_arr['access_type']=='regular_period'){
        $reccurrence = TRUE;
        \Ihc_User_Logs::write_log( __('PayPal Payment: Recurrence payment set.', 'ihc'), 'payments');
      }


      $this->redirectUrl .= '?';
      if ($reccurrence){
        $this->redirectUrl .= 'cmd=_xclick-subscriptions&';
      } else {
        $this->redirectUrl .= 'cmd=_xclick&';
      }

      \Ihc_User_Logs::write_log( __('PayPal Payment: set admin paypal e-mail @ ', 'ihc') . $paypal_email, 'payments');

      $this->redirectUrl .= 'business=' . urlencode($paypal_email) . '&';
      $this->redirectUrl .= 'item_name=' . urlencode($level_arr['name']) . '&';
      $this->redirectUrl .= 'currency_code=' . $this->currency . '&';


      ///DYNAMIC PRICE
      $level_arr['price'] = $this->applyDynamicPrice($level_arr['price']);


      //COUPONS
      $coupon_data = array();

      if (!empty($this->attributes['ihc_coupon'])){
        $coupon_data = ihc_check_coupon($this->attributes['ihc_coupon'], $this->attributes['lid'] );
        \Ihc_User_Logs::write_log( __('PayPal Payment: the user used the following coupon: ', 'ihc') . $this->attributes['ihc_coupon'], 'payments');
      }

      if ($reccurrence){
        //====================RECCURENCE
        //coupon on reccurence
        if ($coupon_data){
          if (!empty($coupon_data['reccuring'])){
            //everytime the price will be reduced
            $level_arr['price'] = ihc_coupon_return_price_after_decrease($level_arr['price'], $coupon_data, TRUE, $this->attributes['uid'], $this->attributes['lid']);
            if (isset($level_arr['access_trial_price'])){
              $level_arr['access_trial_price'] = ihc_coupon_return_price_after_decrease($level_arr['access_trial_price'], $coupon_data, FALSE);
            }
          } else {
            //only one time
            if (isset($level_arr['access_trial_price']) && $level_arr['access_trial_price']!==''){
              $level_arr['access_trial_price'] = ihc_coupon_return_price_after_decrease($level_arr['access_trial_price'], $coupon_data, TRUE, $uid, $this->attributes['lid']);
            } else {
              $level_arr['access_trial_price'] = ihc_coupon_return_price_after_decrease($level_arr['price'], $coupon_data, TRUE, $uid, $this->attributes['lid']);
              $level_arr['access_trial_type'] = 2;
            }
            if (empty($level_arr['access_trial_type'])){
              $level_arr['access_trial_type'] = 2;
            }
          }
        }

        //trial block
        if (isset($level_arr['access_trial_price']) && $level_arr['access_trial_price']!==''){   /// !empty($level_arr['access_trial_type']) &&
          /// TAXES
          $country = (isset($this->attributes['ihc_country'])) ? $this->attributes['ihc_country'] : '';
          $state = (isset($this->attributes['ihc_state'])) ? $this->attributes['ihc_state'] : '';
          $taxes_price = ihc_get_taxes_for_amount_by_country($country, $state, $level_arr['access_trial_price']);
          if ($taxes_price && !empty($taxes_price['total'])){
            $level_arr['access_trial_price'] += $taxes_price['total'];
          }

          $this->redirectUrl .= 'a1=' . urlencode($level_arr['access_trial_price']) . '&';//price
          if ($level_arr['access_trial_type']==1){
            //certain period
            $this->redirectUrl .= 't1=' . urlencode($level_arr['access_trial_time_type']) . '&';//type of time
            $this->redirectUrl .= 'p1=' . urlencode($level_arr['access_trial_time_value']) . '&';// time value
            \Ihc_User_Logs::write_log( __('PayPal Payment: Trial time value set @ ', 'ihc') . $level_arr['access_trial_time_value'] . ' ' .$level_arr['access_trial_time_type'] , 'payments');
          } else {
            //one subscription
			$multiply = 1;
			if( isset($level_arr['access_trial_couple_cycles']) ){
			 		$multiply = $level_arr['access_trial_couple_cycles'];
			}
            $this->redirectUrl .= 't1=' . $level_arr['access_regular_time_type'] . '&';//type of time
            $this->redirectUrl .= 'p1=' . $multiply * $level_arr['access_regular_time_value'] . '&';//time value
            \Ihc_User_Logs::write_log( __('PayPal Payment: Trial time value set @ ', 'ihc') . $level_arr['access_regular_time_value'] . ' ' .$level_arr['access_regular_time_type'] , 'payments');
          }
          $trial = TRUE;
        }
        //end of trial

        /// TAXES
        $level_arr['price'] = $this->addTaxes($level_arr['price']);

        $this->redirectUrl .= 'a3=' . urlencode($level_arr['price']) . '&';
        \Ihc_User_Logs::write_log( __('PayPal Payment: amount set @ ', 'ihc') . $level_arr['price'] . $this->currency, 'payments');
        $this->redirectUrl .= 't3=' . $level_arr['access_regular_time_type'] . '&';
        $this->redirectUrl .= 'p3=' . $level_arr['access_regular_time_value'] . '&';
        $this->redirectUrl .= 'src=1&';//set the rec
        if ($level_arr['billing_type']=='bl_ongoing'){
          //$rec = 52;
          $rec = 0;
        } else {
          if (isset($level_arr['billing_limit_num'])){
            $rec = (int)$level_arr['billing_limit_num'];
          } else {
            $rec = 52;
          }
        }
        \Ihc_User_Logs::write_log( __('PayPal Payment: recurrence number: ', 'ihc') . $rec, 'payments');
        $this->redirectUrl .= 'srt='.$rec.'&';//num of rec
        $this->redirectUrl .= 'no_note=1&';
        if (!empty($trial)){
          $this->redirectUrl .= 'modify=0&';
        } else {
          //$this->redirectUrl .= 'modify=1&';
        }
      } else {
        //====================== single payment

        //coupon
        if ($coupon_data){
          $level_arr['price'] = ihc_coupon_return_price_after_decrease($level_arr['price'], $coupon_data, TRUE, $uid, $this->attributes['lid']);
        }

        /// TAXES
        $level_arr['price'] = $this->addTaxes($level_arr['price']);

        $this->redirectUrl .= 'amount=' . urlencode($level_arr['price']) . '&';
        \Ihc_User_Logs::write_log( __('PayPal Payment: amount set @ ', 'ihc') . $level_arr['price'] . $this->currency, 'payments');
        $this->redirectUrl .= 'paymentaction=sale&';
      }

      $locale = get_option('ihc_paypapl_locale_code');
      if ($locale){
          $this->redirectUrl .= 'lc=' . $locale . '&';
      } else {
          $this->redirectUrl .= 'lc=EN_US&';
      }
      $this->redirectUrl .= 'return=' . urlencode( $r_url ) . '&';
      $this->redirectUrl .= 'cancel_return=' . urlencode( $cancelUrl ) . '&';
      $this->redirectUrl .= 'notify_url=' . urlencode($notify_url) . '&';
      $this->redirectUrl .= 'rm=2&';
      $this->redirectUrl .= 'no_shipping=1&';
      $this->redirectUrl .= 'custom=' . $custom_data;

      return $this;
    }

  	public function redirect()
    {
        \Ihc_User_Logs::write_log( __('PayPal Payment: Request submited.', 'ihc'), 'payments');
        header( 'location:' . $this->redirectUrl);
        exit();
    }

    public function webhook()
    {
      ini_set('display_errors','on');

      if (get_option('ihc_debug_payments_db')){
        ihc_insert_debug_payment_log('paypal', $_POST);
      }
      //file_put_contents( IHC_PATH . 'log.log', serialize( $_POST ) . ' ----- ', FILE_APPEND );

      \Ihc_User_Logs::write_log( __('PayPal Payment IPN: Start process', 'ihc'), 'payments');

      if ( ( isset($_POST['payment_status']) || isset($_POST['txn_type']) ) && isset($_POST['custom']) ){

        $debug = FALSE;
        $path = str_replace('paypal_ipn.php', '', __FILE__);
        $log_file = $path . 'paypal.log';
        $raw_post_data = file_get_contents('php://input');
        \Ihc_User_Logs::write_log( __('PayPal Payment IPN: Extract data from response.', 'ihc'), 'payments');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
          $keyval = explode ('=', $keyval);
          if (count($keyval) == 2)
            $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
          $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
          if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
          } else {
            $value = urlencode($value);
          }
          $req .= "&$key=$value";
        }
        // Post IPN data back to PayPal to validate the IPN data is genuine
        // Without this step anyone can fake IPN data
        $sandbox = get_option('ihc_paypal_sandbox');
        if ($sandbox){
          $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
          \Ihc_User_Logs::write_log( __('PayPal Payment IPN: Set Sandbox mode.', 'ihc'), 'payments');
        } else {
          $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
          \Ihc_User_Logs::write_log( __('PayPal Payment IPN: Set live mode.', 'ihc'), 'payments');
        }

        $ch = curl_init($paypal_url);
        if ($ch == FALSE) {
          if ($debug) {
            error_log(date('[Y-m-d H:i e] '). "No CURL Enabled on this server ", 3, $log_file);
          }
          \Ihc_User_Logs::write_log( __('PayPal Payment IPN: End Process. No CURL Enabled on this server. ', 'ihc'), 'payments');
          echo "No CURL Enabled on this server ";
          exit();
        }
        \Ihc_User_Logs::write_log( __('PayPal Payment IPN: Send cURL request to PayPal.', 'ihc'), 'payments');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        if ($debug) {
          curl_setopt($ch, CURLOPT_HEADER, 1);
          curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: membership-pro'));
        $res = curl_exec($ch);
        if (curl_errno($ch) != 0){ // cURL error
          \Ihc_User_Logs::write_log( __("PayPal Payment IPN: cURL error - can't connect to PayPal to validate IPN message: ", 'ihc') . curl_error($ch) . PHP_EOL, 'payments');
          if ($debug) {
            error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, $log_file);
          }
          curl_close($ch);
          echo date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch);
          exit; /// out
        } else {
          //Log the entire HTTP response if debug is switched on.
          \Ihc_User_Logs::write_log( __("PayPal Payment IPN: cURL error - HTTP response of validation request: ", 'ihc') . $res . PHP_EOL, 'payments');
          if ($debug) {
            error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, $log_file );
            error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, $log_file);
          }
          curl_close($ch);
        }
        // Inspect IPN validation result and act accordingly
        // Split response headers and payload, a better way for strcmp
        $tokens = explode("\r\n\r\n", trim($res));
        $res = trim(end($tokens));

        if (strcmp ($res, "VERIFIED") == 0) {
          \Ihc_User_Logs::write_log( __("PayPal Payment IPN: cURL request Verified.", 'ihc'), 'payments');
          if (isset($_POST['custom'])){
            $data = stripslashes($_POST['custom']);
            $data = json_decode($data, true);
            $level_data = ihc_get_level_by_id($data['level_id']);//getting details about current level
          }

          \Ihc_User_Logs::write_log( __('PayPal Payment IPN: '.json_encode($_POST), 'ihc'), 'payments');

          \Ihc_User_Logs::set_user_id($data['user_id']);
          \Ihc_User_Logs::set_level_id($data['level_id']);
          \Ihc_User_Logs::write_log( __("PayPal Payment IPN: set user id @ ", 'ihc') . $data['user_id'], 'payments');

          if (isset($_POST['payment_status'])){
            \Ihc_User_Logs::write_log( __("PayPal Payment IPN: Payment status is ", 'ihc') . $_POST['payment_status'], 'payments');
            switch ($_POST['payment_status']){
              case 'Processed':
              case 'Completed':

                //v.7.1 - Cover Paid Trial with different period than Level Period. MUST be Double-Check
                if(isset($level_data['access_trial_time_value']) && $level_data['access_trial_time_value'] > 0 && ihc_user_level_first_time($data['user_id'],$data['level_id'])){
                  \Ihc_User_Logs::write_log( __("PayPal Payment IPN: Update user level expire time (Trial).", 'ihc'), 'payments');
                  ihc_set_level_trial_time_for_no_pay($data['level_id'], $data['user_id']);
                }else{
                  //payment made, put the right expire time
                  \Ihc_User_Logs::write_log( __("PayPal Payment IPN: Update user level expire time.", 'ihc'), 'payments');
                  ihc_update_user_level_expire($level_data, $data['level_id'], $data['user_id']);
                }

                ihc_send_user_notifications($data['user_id'], 'payment', $data['level_id']);//send notification to user
                ihc_send_user_notifications($data['user_id'], 'admin_user_payment', $data['level_id']);//send notification to admin
                do_action( 'ihc_payment_completed', $data['user_id'], $data['level_id'] );
                // @description run on payment complete. @param user id (integer), level id (integer)

                ihc_switch_role_for_user($data['user_id']);

                break;
              case 'Pending':
                break;
              case 'Reversed':
              case 'Denied':
                ihc_delete_user_level_relation($data['level_id'], $data['user_id']);
                break;

              case 'Refunded':
                ihc_delete_user_level_relation($data['level_id'], $data['user_id']);
                do_action('ump_paypal_user_do_refund', $data['user_id'], $data['level_id'], @$_POST['txn_id']);
                // @description run on payment refund. @param user id (integer), level id (integer), transaction id (integer)

                break;
            }
            if (isset($_POST['txn_id'])){
              //set payment type
              $_POST['ihc_payment_type'] = 'paypal';
              //record transation

              ihc_insert_update_transaction($data['user_id'], $_POST['txn_id'], $_POST);
            }
            //header('HTTP/1.0 200 OK');
            exit();
          } else if (isset($_POST['txn_type']) && $_POST['txn_type']=='subscr_signup'){
            $insert_data = $_POST;
            $insert_data['txn_id'] = "txn_" . indeed_get_unixtimestamp_with_timezone() . "_{$data['user_id']}_{$data['level_id']}";
            $insert_data['payment_status'] = 'Completed';
            $insert_data['ihc_payment_type'] = 'paypal';
            if (!empty($_POST['period1'])){
              /// its trial
              if (isset($_POST['mc_amount1']) && (float)$_POST['mc_amount1']==0){
                ihc_set_level_trial_time_for_no_pay($data['level_id'], $data['user_id']);
                \Ihc_User_Logs::write_log( __("PayPal Payment IPN: Update user level expire time (Trial).", 'ihc'), 'payments');
                ihc_send_user_notifications($data['user_id'], 'payment', $data['level_id']);//send notification to user
                ihc_send_user_notifications($data['user_id'], 'admin_user_payment', $data['level_id']);//send notification to admin
                do_action( 'ihc_payment_completed', $data['user_id'], $data['level_id'] );
                // @description run on payment complete. @param user id (integer), level id (integer)

                ihc_switch_role_for_user($data['user_id']);
                ihc_insert_update_transaction($data['user_id'], $insert_data['txn_id'], $insert_data);
              }else{
                //Wait to receive the new response via 	payment_status = Completed
              }
            } else if (isset($_POST['mc_amount1']) && (int)$_POST['mc_amount1']==0){
              ///// Recurring, first payment was 0
              \Ihc_User_Logs::write_log( __("PayPal Payment IPN: Update user level expire time.", 'ihc'), 'payments');
              ihc_update_user_level_expire($level_data, $data['level_id'], $data['user_id']);
              ihc_send_user_notifications($data['user_id'], 'payment', $data['level_id']);//send notification to user
              ihc_send_user_notifications($data['user_id'], 'admin_user_payment', $data['level_id']);//send notification to admin
              do_action( 'ihc_payment_completed', $data['user_id'], $data['level_id'] );
              // @description run on payment complete. @param user id (integer), level id (integer)

              ihc_switch_role_for_user($data['user_id']);
              ihc_insert_update_transaction($data['user_id'], $insert_data['txn_id'], $insert_data);
            }
            //header('HTTP/1.0 200 OK');
            exit();
          }

          switch ($_POST['txn_type']) {
            case 'web_accept':
            case 'subscr_payment':

            break;

            case 'subscr_signup':

              break;
            case 'subscr_modify':

            break;

            case 'recurring_payment_profile_canceled':
            case 'recurring_payment_suspended':
            case 'recurring_payment_suspended_due_to_max_failed_payment':
            case 'recurring_payment_failed':
              ihc_delete_user_level_relation($data['level_id'], $data['user_id']);
            break;
          }

          //header('HTTP/1.0 200 OK');
          exit();

        } else if (strcmp ($res, "INVALID") == 0) {
          \Ihc_User_Logs::write_log( __("PayPal Payment IPN: cURL request is Invaild.", 'ihc'), 'payments');
          ///problems with connection
          if ($debug){
            error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, $log_file);
          }
          echo date('[Y-m-d H:i e] '). "Invalid IPN: $req";
          exit();
        }
      } else {
        echo '============= Ultimate Membership Pro - PAYPAL IPN ============= ';
        echo '<br/><br/>No Payments details sent. Come later';
        exit();
      }
      exit();
    }

    public function cancelSubscription( $dont_redirect_paypal=false )
    {
        if (!empty($dont_redirect_paypal)){
          return;
        }
        $sandbox = get_option('ihc_paypal_sandbox');
        $alias = get_option('ihc_paypal_email');
        $merchant_id = get_option('ihc_paypal_merchant_account_id');
        if ($merchant_id){
          $alias = $merchant_id;
        }
        if ($sandbox){
          $url = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=" . urlencode($alias);
        } else {
          $url = "https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=" . urlencode($alias);
        }
        wp_redirect($url);
        exit();
    }

}
