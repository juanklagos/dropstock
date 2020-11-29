<?php
namespace Indeed\Ihc\PaymentGateways;
/*
Created v.7.4
Deprecated starting with v.9.3
*/
class PayPalExpressCheckout extends \Indeed\Ihc\PaymentGateways\PaymentAbstract
{
    protected $attributes       = array();
    protected $redirectUrl      = '';
    protected $abort            = false;
    protected $paymentTypeLabel = 'PayPal Express Checkout';
    protected $currency         = '';

    public function __construct()
    {
        $this->currency = get_option('ihc_currency');
    }

    public function doPayment()
    {
        $levels = get_option('ihc_levels');
        $levelData = $levels[$this->attributes['lid']];

        $amount = $levelData['price'];

        /*************************** DYNAMIC PRICE ***************************/
        if (ihc_is_magic_feat_active('level_dynamic_price') && isset($this->attributes['ihc_dynamic_price'])){
            $temp_amount = $this->attributes['ihc_dynamic_price'];
            if (ihc_check_dynamic_price_from_user($this->attributes['lid'], $temp_amount)){
                $amount = $temp_amount;
                \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment: Dynamic price on - Amount is set by the user @ ', 'ihc') . $amount . $this->currency, 'payments');
            }
        }
        /**************************** DYNAMIC PRICE ***************************/

        $reccurrence = FALSE;
        if (isset($levelData['access_type']) && $levelData['access_type']=='regular_period'){
          $reccurrence = TRUE;
          \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment: Recurrence payment set.', 'ihc'), 'payments');
        }

        $couponData = array();
        if (!empty($this->attributes['ihc_coupon'])){
          $couponData = ihc_check_coupon($this->attributes['ihc_coupon'], $this->attributes['lid']);
          \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment: the user used the following coupon: ', 'ihc') . $this->attributes['ihc_coupon'], 'payments');
        } else if (!empty($input['ihc_coupon'])){
          $couponData = ihc_check_coupon($this->attributes['ihc_coupon'], $this->attributes['lid']);
          \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment: the user used the following coupon: ', 'ihc') . $this->attributes['ihc_coupon'], 'payments');
        }

        if ($reccurrence){

            /// RECURRING PAYMENT STARTS

            if ($couponData){
              if (!empty($couponData['reccuring'])){
                //everytime the price will be reduced
                $levelData['price'] = ihc_coupon_return_price_after_decrease($levelData['price'], $couponData, TRUE, $this->attributes['uid'], $this->attributes['lid']);
                if (isset($levelData['access_trial_price'])){
                  $levelData['access_trial_price'] = ihc_coupon_return_price_after_decrease($levelData['access_trial_price'], $couponData, FALSE);
                }
              } else {
                //only one time
				 if (isset($levelData['access_trial_price']) && $levelData['access_trial_price']!==''){
                  $levelData['access_trial_price'] = ihc_coupon_return_price_after_decrease($levelData['access_trial_price'], $couponData, TRUE, $uid, $this->attributes['lid']);
                } else {
                  $levelData['access_trial_price'] = ihc_coupon_return_price_after_decrease($levelData['price'], $couponData, TRUE, $uid, $this->attributes['lid']);
                  $levelData['access_trial_type'] = 2;
                }
					//WHEN IS NO TRIAL AND COUPON "JUST ONCE" CREATE ONE.
					  if (empty($levelData['access_trial_type'])){
						$levelData['access_trial_type'] = 2;
					  }
					   if (empty($levelData['access_trial_couple_cycles'])){
						 $levelData['access_trial_couple_cycles']  = 1;
					  }
              }
            }

            //trial block
            if (isset($levelData['access_trial_price']) && $levelData['access_trial_price']!==''){
              /// TAXES
              $country = (isset($this->attributes['ihc_country'])) ? $this->attributes['ihc_country'] : '';
              $state = (isset($this->attributes['ihc_state'])) ? $this->attributes['ihc_state'] : '';
              $taxesPrice = ihc_get_taxes_for_amount_by_country($country, $state, $levelData['access_trial_price']);
              if ($taxesPrice && !empty($taxesPrice['total'])){
                $levelData['access_trial_price'] += $taxesPrice['total'];
              }


              if ($levelData['access_trial_type']==1){
                //certain period
                \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment: Trial time value set @ ', 'ihc') . $levelData['access_trial_time_value'] . ' ' .$levelData['access_trial_time_type'] , 'payments');
              } else {
                //one subscription
                $levelData['access_trial_time_type'] = $levelData['access_regular_time_type'];//type of time
                $levelData['access_trial_time_value'] = $levelData['access_regular_time_value'];//time value
                \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment: Trial time value set @ ', 'ihc') . $levelData['access_regular_time_value'] . ' ' .$levelData['access_regular_time_type'] , 'payments');
              }
              if (!empty($levelData['access_trial_couple_cycles'])){
                  $access_trial_couple_cycles = $levelData['access_trial_couple_cycles'];
              }
              $trial = TRUE;
            }
            //end of trial

            /// TAXES
            $levelData['price'] = $this->addTaxes($levelData['price']);

            $amount = $levelData['price'];
            \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __( ' Payment: amount set @ ', 'ihc') . $amount . $this->currency, 'payments');

            if ($levelData['billing_type']=='bl_ongoing'){
              //$rec = 52;
              $recurringLimit = 0;
            } else {
              if (isset($levelData['billing_limit_num'])){
                $recurringLimit = (int)$levelData['billing_limit_num'];
              } else {
                $recurringLimit = 52;
              }
            }
            $intervalValue = $levelData['access_regular_time_value'];
            switch ($levelData['access_regular_time_type']){
              case 'D':
                $intervalType = 'Day';
                break;
              case 'W':
                $intervalType = 'Week';
                break;
              case 'M':
                $intervalType = 'Month';
                break;
              case 'Y':
                $intervalType = 'Year';
                break;
            }
            \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment: recurrence number: ', 'ihc') . $recurringLimit, 'payments');

            $amount = number_format((float)$amount, 2, '.', '');

            $object = new \Indeed\Ihc\PaymentGateways\PayPalExpressCheckoutNVP();
            $redirect = $object->setRecurringPayment($levelData['label'])->getAuthorizeURL();
            if ($redirect){
                $this->redirectUrl = $redirect;
            }
            $token = $object->getToken();
            $extraPaymentData = array(
                'description'               => $levelData['label'],
                'recurringLimit'            => $recurringLimit,
                'intervalType'              => $intervalType,
                'intervalValue'             => $intervalValue,
                'countryCode'               => isset($this->attributes['ihc_country']) ? $this->attributes['ihc_country'] : 'US',
            ) ;

            /// TRIAL
            if ( !empty( $levelData['access_trial_time_value'] ) && isset( $levelData['access_trial_type'] ) && $levelData['access_trial_type']==1 ){ //  isset( $extraPaymentData['access_trial_type'] ) && $extraPaymentData['access_trial_type']==1
                /// CERTAIN PERIOD
                $extraPaymentData['access_trial_time_value'] = $levelData['access_trial_time_value'];
                if (isset($levelData['access_trial_price'])){
                    $extraPaymentData['access_trial_price'] = $levelData['access_trial_price'];
                }
                if (isset($levelData['access_trial_type'])){
                    $extraPaymentData['access_trial_type'] = $levelData['access_trial_type'];
                }
                switch ($levelData['access_trial_time_type']){
                  case 'D':
                    $extraPaymentData['access_trial_type'] = 'Day';
                    break;
                  case 'W':
                    $extraPaymentData['access_trial_type'] = 'Week';
                    break;
                  case 'M':
                    $extraPaymentData['access_trial_type'] = 'Month';
                    break;
                  case 'Y':
                    $extraPaymentData['access_trial_type'] = 'Year';
                    break;
                }
            } else if ( !empty( $levelData['access_trial_couple_cycles'] ) && isset($levelData['access_trial_type']) && $levelData['access_trial_type'] == 2 ){ /// && isset($extraPaymentData['access_trial_type']) && $extraPaymentData['access_trial_type'] == 2
                /// couple of cycles
				if (isset($levelData['access_trial_price'])){
                    $extraPaymentData['access_trial_price'] = $levelData['access_trial_price'];
                }
                $extraPaymentData['access_trial_type'] = $intervalType;
                $extraPaymentData['access_trial_time_value'] = $levelData['access_regular_time_value'];
                $extraPaymentData['access_trial_couple_cycles'] = $levelData['access_trial_couple_cycles'];
            }

			/// RECURRING PAYMENT ENDS

        } else {

            /// SINGLE PAYMENT STARTS

            if ($couponData){
              $amount = ihc_coupon_return_price_after_decrease($amount, $couponData, TRUE, $this->attributes['uid'], $this->attributes['lid']);
            }

            /// TAXES
            $levelData['price'] = $this->addTaxes($levelData['price']);

            /*************************** DYNAMIC PRICE ***************************/
            /*
            if (ihc_is_magic_feat_active('level_dynamic_price') && isset($this->attributes['ihc_dynamic_price'])){
              $temp_amount = $this->attributes['ihc_dynamic_price'];
              if (ihc_check_dynamic_price_from_user($this->attributes['lid'], $temp_amount)){
                $amount = $temp_amount;
                \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment: Dynamic price on - Amount is set by the user @ ', 'ihc') . $amount . $this->currency, 'payments');
              }
            }
            */
            /**************************** DYNAMIC PRICE ***************************/

            $amount = number_format((float)$amount, 2, '.', '');
            $object = new \Indeed\Ihc\PaymentGateways\PayPalExpressCheckoutNVP();
            $redirect = $object->setSinglePayment($amount)->getAuthorizeURL();
            if ($redirect){
                $this->redirectUrl = $redirect;
            }
            $token = $object->getToken();

			  /// SINGLE PAYMENT ENDS
        }

        if (empty($token)){
            //STOP THE PROCESS
			return $this;
        }

        $transactionData = array(
                      'lid'                 => $this->attributes['lid'],
                      'uid'                 => $this->attributes['uid'],
                      'ihc_payment_type'    => 'paypal_express_checkout',
                      'amount'              => $amount,
                      'message'             => 'pending',
                      'currency'            => $this->currency,
                      'item_name'           => $levelData['name'],
                      'token'               => $token,
        );
        if (!empty($extraPaymentData)){
            $transactionData = $transactionData + $extraPaymentData;
        }

        ihc_insert_update_transaction($this->attributes['uid'], $token, $transactionData, true); /// will save the order too
        /// update indeed_members_payments table, add order id
        \Ihc_Db::updateTransactionAddOrderId($token, @$this->attributes['orderId']);
        return $this;

    }

    /**
     * @param string
     * @return none
     */
    public function redirect( $transactionId='' )
    {
        if (empty($this->redirectUrl)){
            $this->redirectUrl = get_site_url();
        }
        \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment: Request submited.', 'ihc'), 'payments');
        header( 'location:' . $this->redirectUrl);
        exit();
    }

    /**
     * @param string
     * @return none
     */
    public function cancelSubscription( $transactionId='' )
    {
        $sandbox = get_option('ihc_paypal_express_checkout_sandbox');
        if ($merchant_id){
          $alias = $merchant_id;
        }
        if ($sandbox){
          $url = "https://www.sandbox.paypal.com/";
        } else {
          $url = "https://www.paypal.com/";
        }
        wp_redirect($url);
        exit();
    }

    public function webhook()
    {
        //file_put_contents( IHC_PATH . 'log.log', serialize($_POST) . '#########' , FILE_APPEND );

        if ( !isset($_POST['payment_status']) && !isset($_POST['txn_type']) ){
        	echo '============= Ultimate Membership Pro - PAYPAL EXPRESS CHECKOUT IPN ============= ';
        	echo '<br/><br/>No Payments details sent. Come later';
        	exit();
        }

        $debug = false;
        $path = str_replace('paypal_ipn.php', '', __FILE__);
        $log_file = $path . 'paypal.log';
        $raw_post_data = file_get_contents('php://input');
        \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment IPN: Extract data from response.', 'ihc'), 'payments');
        $raw_post_array = explode('&', $raw_post_data);
        $postData = array();
        foreach ($raw_post_array as $keyval) {
        	  $keyval = explode ('=', $keyval);
        	  if (count($keyval) == 2)
        		    $postData[$keyval[0]] = urldecode($keyval[1]);
        }

        \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(" Payment IPN: cURL request Verified.", 'ihc'), 'payments');


        /// transaction id
        if (isset($postData['recurring_payment_id'])){
            $transactionId = $postData['recurring_payment_id'];
        } else if (isset($postData['txn_id'])){
            $transactionId = $postData['txn_id'];
        }

        $data = \Ihc_Db::getUidLidByTxnId($transactionId);
        if (empty($data)){
            exit();
        }
        $level_data = ihc_get_level_by_id($data['lid']);

        \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' Payment IPN: '.json_encode($_POST), 'ihc'), 'payments');

        \Ihc_User_Logs::set_user_id($data['uid']);
        \Ihc_User_Logs::set_level_id($data['lid']);
        \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(" Payment IPN: set user id @ ", 'ihc') . $data['uid'], 'payments');
        \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(" Payment IPN: paypal response: ", 'ihc') . serialize($postData) );

        if (isset($_POST['payment_status'])){

        		\Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(" Payment IPN: Payment status is ", 'ihc') . $_POST['payment_status'], 'payments');
        		switch ($_POST['payment_status']){
        			case 'Processed':
        			case 'Completed':
      					//v.7.1 - Cover Paid Trial with different period than Level Period. MUST be Double-Check
      					if(isset($level_data['access_trial_time_value']) && $level_data['access_trial_time_value'] > 0 && ihc_user_level_first_time( $data['uid'],$data['lid'] ) ){
      						\Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(" Payment IPN: Update user level expire time (Trial).", 'ihc'), 'payments');

                  $orderId = \Ihc_Db::getLastOrderIdForTransaction( $transactionId );
                  if ( $orderId ){
                      \Ihc_Db::updateOrderStatus( $orderId, 'Completed' );
                  }
                  $paymentData = ihcGetTransactionDetails($transactionId);
                  ihc_set_level_trial_time_for_no_pay($paymentData['lid'], $paymentData['uid']);
                  ihc_send_user_notifications($data['uid'], 'payment', $data['lid']);//send notification to user
                  ihc_send_user_notifications($data['uid'], 'admin_user_payment', $data['lid']);//send notification to admin
                  do_action( 'ihc_payment_completed', $data['uid'], $data['lid'] );
                  // @description run on payment complete. @param user id (integer), level id (integer)

                  ihc_switch_role_for_user($data['uid']);
                  exit();

      					} else {
      						//payment made, put the right expire time
      						\Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(" Payment IPN: Update user level expire time.", 'ihc'), 'payments');
      						ihc_update_user_level_expire($level_data, $data['lid'], $data['uid']);

                  /// check this
                  $orderId = \Ihc_Db::getLastOrderIdForTransaction( $transactionId );
                  if ( $orderId ){
                      \Ihc_Db::updateOrderStatus( $orderId, 'Completed' );
                  }

                  $dontInsertNewOrder = false;
                  $orderId = \Ihc_Db::getLastOrderIdForTransaction( $transactionId );
                  if ( $orderId && \Ihc_Db::getOrderStatus( $orderId ) != 'Completed' ){
                      \Ihc_Db::updateOrderStatus( $orderId, 'Completed' );
                      $dontInsertNewOrder = true;
                  }
                  $paymentData = ihcGetTransactionDetails($transactionId);
                  $paymentData['message'] = 'success';
                  $paymentData['status'] = 'Completed';
                  ihc_insert_update_transaction($data['uid'], $transactionId, $paymentData, $dontInsertNewOrder );
      					}
      					ihc_send_user_notifications($data['uid'], 'payment', $data['lid']);//send notification to user
      					ihc_send_user_notifications($data['uid'], 'admin_user_payment', $data['lid']);//send notification to admin
                do_action( 'ihc_payment_completed', $data['uid'], $data['lid'] );
                // @description run on payment complete. @param user id (integer), level id (integer)

                ihc_switch_role_for_user($data['uid']);
          			exit();
        				break;
      				case 'Pending':
        				break;
      				case 'Reversed':
      				case 'Denied':
      					ihc_delete_user_level_relation($data['lid'], $data['uid']);
          			exit();
        				break;
      				case 'Refunded':
    						ihc_delete_user_level_relation($data['lid'], $data['uid']);
    						do_action('ump_paypal_user_do_refund', $data['uid'], $data['lid'], $transactionId);
                // @description run on payment refund. @param user id (integer), level id (integer), transaction id (integer)

          			exit();
        				break;
      			}
        } else if (isset($_POST['txn_type']) && $_POST['txn_type']=='recurring_payment_profile_created'){

            if ( ((int)$postData['amount']==0) && ( trim( $postData['period_type'] ) == 'Trial' ) && ( trim( $postData['payer_status'] ) ) == 'verified' ){
                $paymentData = ihcGetTransactionDetails($transactionId);
                ihc_set_level_trial_time_for_no_pay($paymentData['lid'], $paymentData['uid']);
                ihc_send_user_notifications($data['uid'], 'payment', $data['lid']);//send notification to user
                ihc_send_user_notifications($data['uid'], 'admin_user_payment', $data['lid']);//send notification to admin
                do_action( 'ihc_payment_completed', $data['uid'], $data['lid'] );
                // @description run on payment complete. @param user id (integer), level id (integer)

                ihc_switch_role_for_user($data['uid']);
                $orderId = \Ihc_Db::getLastOrderIdForTransaction( $transactionId );
                if ( $orderId ){
                    \Ihc_Db::updateOrderStatus( $orderId, 'Completed' );
                }
                exit();
            }

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
        				ihc_delete_user_level_relation($data['lid'], $data['uid']);
        			  break;
        		}

        		//header('HTTP/1.0 200 OK');
        		exit();


    }

}
