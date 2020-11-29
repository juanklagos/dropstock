<?php

namespace Indeed\Ihc\PaymentGateways;

/*

@since 7.4

*/

class Pagseguro extends \Indeed\Ihc\PaymentGateways\PaymentAbstract

{

    protected $attributes       = array();

    protected $redirectUrl      = '';

    protected $abort            = false;

    protected $paymentTypeLabel = 'Pagseguro Payment';

    protected $currency         = '';



    public function __construct()

    {

        $this->currency = get_option('ihc_currency');

    }



    public function doPayment()

    {

        \Ihc_User_Logs::set_user_id( @$this->attributes['uid'] );

        \Ihc_User_Logs::set_level_id( @$this->attributes['lid'] );

        \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(': Start process', 'ihc'), 'payments' );



        $settings = ihc_return_meta_arr('payment_pagseguro');



        $levels = get_option('ihc_levels');

        $levelData = $levels[$this->attributes['lid']];



        $siteUrl = site_url();

        $siteUrl = trailingslashit($siteUrl);

        $webhook = add_query_arg( 'ihc_action', 'pagseguro', $siteUrl );

        $amount = $levelData['price'];



        $reccurrence = FALSE;

        if ( isset( $levelData['access_type'] ) && $levelData['access_type']=='regular_period' ){

          $reccurrence = TRUE;

          \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(': Recurrence payment set.', 'ihc'), 'payments' );

        }

        $couponData = array();

        if (!empty($this->attributes['ihc_coupon'])){

          $couponData = ihc_check_coupon( $this->attributes['ihc_coupon'], $this->attributes['lid'] );

          \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __( ': the user used the following coupon: ', 'ihc' ) . $this->attributes['ihc_coupon'], 'payments' );

        }



        if ( $reccurrence ){

          // ------------------- RECURRING PAYMENT -----------------

          if ( $settings['ihc_pagseguro_sandbox'] ){

              $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/request';

          } else {

              $url = 'https://ws.pagseguro.uol.com.br/v2/pre-approvals/request';

          }

          if ($levelData['billing_type']=='bl_ongoing'){

            //$rec = 52;

            $recurringLimit = 52;

          } else {

            if (isset($levelData['billing_limit_num'])){

              $recurringLimit = (int)$levelData['billing_limit_num'];

            } else {

              $recurringLimit = 52;

            }

          }



          switch ($levelData['access_regular_time_type']){

            case 'M':

              $intervalType = 'Monthly';

          		$preApprovalFinalDate = date( 'Y-m-d H:i:s', strtotime( "+$recurringLimit month", time() ) );

              break;

            case 'Y':

              $intervalType = 'Yearly';

          		$preApprovalFinalDate = date( 'Y-m-d H:i:s', strtotime( "+$recurringLimit year", time() ) );

              break;

            default:

              $intervalType = 'Weekly';

          		$preApprovalFinalDate = date( 'Y-m-d H:i:s', strtotime( "+$recurringLimit week", time() ) );

              break;

          }



          if ($couponData){

              if (!empty($couponData['reccuring'])){

                  //everytime the price will be reduced

                  $amount = ihc_coupon_return_price_after_decrease($levelData['price'], $couponData, true, $this->attributes['uid'], $this->attributes['lid']);

              } else {

                  // only one time

                  if (!empty($levelData['access_trial_price'])){

                    $levelData['access_trial_price'] = ihc_coupon_return_price_after_decrease($levelData['access_trial_price'], $couponData, TRUE, $uid, $this->attributes['lid']);

                  } else {

                    $levelData['access_trial_price'] = ihc_coupon_return_price_after_decrease($levelData['price'], $couponData, TRUE, $uid, $this->attributes['lid']);

                    $levelData['access_trial_type'] = 2;

                  }

                  if (empty($levelData['access_trial_type'])){

                    $levelData['access_trial_type'] = 2;

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

              $trialTimeType = $levelData['access_trial_time_type'];//type of time

              $trialTimeValue = $levelData['access_trial_time_value'];//time value

              \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(': Trial time value set @ ', 'ihc') . $levelData['access_trial_time_value'] . ' ' .$levelData['access_trial_time_type'] , 'payments');

            } else {

              //one subscription

              $trialTimeType = $levelData['access_regular_time_type'];//type of time

              $trialTimeValue = $levelData['access_regular_time_value'];//time value

              \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(': Trial time value set @ ', 'ihc') . $levelData['access_regular_time_value'] . ' ' .$levelData['access_regular_time_type'] , 'payments');

            }



            switch ($trialTimeType){

                case 'D':

                  $trialTimeType = 'Days';

                  break;

                case 'W':

                  $trialTimeType = 'Days';

                  $trialTimeValue = $trialTimeValue * 7;

                  break;

                case 'M':

                  $trialTimeType = 'Months';

                  break;

                case 'Y':

                  $trialTimeType = 'Years';

                  break;

            }

            $trial = TRUE;

          }

          //end of trial



          /*************************** DYNAMIC PRICE ***************************/

          if (ihc_is_magic_feat_active('level_dynamic_price') && isset($this->attributes['ihc_dynamic_price'])){

              $temp_amount = $this->attributes['ihc_dynamic_price'];

              if (ihc_check_dynamic_price_from_user($this->attributes['lid'], $temp_amount)){

                  $amount = $temp_amount;

                  \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(': Dynamic price on - Amount is set by the user @ ', 'ihc') . $amount . $this->currency, 'payments');

              }

          }

          /**************************** DYNAMIC PRICE ***************************/



          $amount = number_format( (float)$amount, 2, '.', '' );

          $preApprovalMaxTotalAmount = $recurringLimit * $amount;

          $preApprovalMaxTotalAmount = number_format( (float)$preApprovalMaxTotalAmount, 2, '.', '' );





          $requestData = array(

                                  'email'                                   => $settings['ihc_pagseguro_email'],

                                  'token'                                   => $settings['ihc_pagseguro_token'],

                                  'currency'                                => $this->currency,

                                  'preApprovalCharge'                       => 'auto',

                                  'preApprovalName'                         => 'Assinatura',

                                  'preApprovalAmountPerPayment'             => $amount,

                                  'preApprovalPeriod'                       => $intervalType,

                                  'preApprovalMaxTotalAmount'               => $preApprovalMaxTotalAmount,

                                  'reference'                               => $this->attributes['orderId'],

                                  'redirectURL'                             => $siteUrl,

                                  'notificationURL'                         => $webhook,

          );



          if ( ( !empty($trial) || !empty($couponData) ) && isset($levelData['access_trial_price'])){

              $levelData['access_trial_price'] = number_format( (float)$levelData['access_trial_price'], 2, '.', '' );

              $requestData['preApprovalMembershipFee'] = $levelData['access_trial_price'];

          }

          // if (isset($trialTimeType)){

          //     $requestData['preApprovalTrialPeriod'] = $trialTimeType;

          // }

          if (isset($trialTimeValue)){

              $requestData['preApprovalTrialPeriodDuration'] = $trialTimeValue;

          }



          $requestData = http_build_query($requestData);

          $curl = curl_init($url);

          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

          curl_setopt($curl, CURLOPT_POST, true);

          curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

          curl_setopt($curl, CURLOPT_POSTFIELDS, $requestData);

          $xml= curl_exec($curl);





          if($xml == 'Unauthorized'){

          	 return $this;

          }

          curl_close($curl);



          $xml = simplexml_load_string($xml);

          if(count($xml->error) > 0){

              return $this;

          }

          $token = (string)$xml->code;

          if ( $settings['ihc_pagseguro_sandbox'] ){

                $this->redirectUrl = 'https://sandbox.pagseguro.uol.com.br/v2/pre-approvals/request.html?code=' . $token;

          } else {

                $this->redirectUrl = 'https://pagseguro.uol.com.br/v2/pre-approvals/request.html?code=' . $token;

          }



        } else {

          // ------------------- SINGLE PAYMENT ----------------

          /// SINGLE payment_type

          if ($couponData){

            $amount = ihc_coupon_return_price_after_decrease($amount, $couponData, TRUE, $this->attributes['uid'], $this->attributes['lid']);

          }



          /// TAXES

          $amount = $this->addTaxes($amount);



          /*************************** DYNAMIC PRICE ***************************/

          if (ihc_is_magic_feat_active('level_dynamic_price') && isset($this->attributes['ihc_dynamic_price'])){

            $temp_amount = $this->attributes['ihc_dynamic_price'];

            if (ihc_check_dynamic_price_from_user($this->attributes['lid'], $temp_amount)){

              $amount = $temp_amount;

              \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(': Dynamic price on - Amount is set by the user @ ', 'ihc') . $amount . $this->currency, 'payments');

            }

          }

          /**************************** DYNAMIC PRICE ***************************/

          $amount = number_format((float)$amount, 2, '.', '');



          $xml = xmlwriter_open_memory();

          xmlwriter_set_indent($xml, 1);

          $res = xmlwriter_set_indent_string($xml, ' ');



          xmlwriter_start_document($xml, '1.0', 'UTF-8', 'yes');



          xmlwriter_start_element($xml, 'checkout');



          	/// currency

          	xmlwriter_start_element( $xml, 'currency' );

          	xmlwriter_text($xml, $this->currency);

          	xmlwriter_end_element($xml);



          	/// reference

          	xmlwriter_start_element($xml, 'reference');

          			xmlwriter_start_cdata($xml);

          					xmlwriter_text( $xml, $this->attributes['orderId'] ); /// generate this or put the order id here

          			xmlwriter_end_cdata($xml);

          	xmlwriter_end_element($xml);



            xmlwriter_start_element($xml, 'sender');

          		/// email

          		xmlwriter_start_element($xml, 'email');

          				xmlwriter_start_cdata($xml);

          						xmlwriter_text($xml, \Ihc_Db::user_get_email($this->attributes['uid']) );

          				xmlwriter_end_cdata($xml);

          		xmlwriter_end_element($xml);

            xmlwriter_end_element($xml);



          	/// items

          	xmlwriter_start_element( $xml, 'items' );

          			/// item

          			xmlwriter_start_element( $xml, 'item' );

          					/// id

          					xmlwriter_start_element( $xml, 'id' );

          						xmlwriter_text( $xml, $this->attributes['lid'] . '_' . $this->attributes['uid'] );

          					xmlwriter_end_element( $xml );

          					/// description

          					xmlwriter_start_element( $xml, 'description' );

          						xmlwriter_start_cdata( $xml );

          								xmlwriter_text( $xml, $levelData['description'] );

          						xmlwriter_end_cdata( $xml );

          					xmlwriter_end_element( $xml );

          					/// amount

          					xmlwriter_start_element( $xml, 'amount' );

          						xmlwriter_text( $xml, $amount );

          					xmlwriter_end_element( $xml );

          					/// quantity

          					xmlwriter_start_element( $xml, 'quantity' );

          						xmlwriter_text( $xml, '1' );

          					xmlwriter_end_element( $xml );

          			xmlwriter_end_element( $xml );

          	xmlwriter_end_element( $xml );



          	/// redirectURL

          	xmlwriter_start_element( $xml, 'redirectURL' );

          		xmlwriter_start_cdata( $xml );

          				xmlwriter_text( $xml, $siteUrl );

          		xmlwriter_end_cdata( $xml );

          	xmlwriter_end_element( $xml );

          	/// notificationURL

          	xmlwriter_start_element( $xml, 'notificationURL' );

          		xmlwriter_start_cdata( $xml );

          				xmlwriter_text( $xml, $webhook );

          		xmlwriter_end_cdata( $xml );

          	xmlwriter_end_element( $xml );

          	/// maxUses

          	xmlwriter_start_element( $xml, 'maxUses' );

          		xmlwriter_text( $xml, '1' );

          	xmlwriter_end_element( $xml );

          	/// maxAge

          	xmlwriter_start_element( $xml, 'maxAge' );

          		xmlwriter_text( $xml, '120' );

          	xmlwriter_end_element( $xml );



          xmlwriter_end_element( $xml );

          xmlwriter_end_document( $xml );





          if ( $settings['ihc_pagseguro_sandbox'] ){

              $checkoutUrl = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout';

          } else {

              $checkoutUrl = 'https://ws.pagseguro.uol.com.br/v2/checkout';

          }



          $xml = xmlwriter_output_memory($xml);

          $url = add_query_arg( array( 'email' => $settings['ihc_pagseguro_email'], 'token' => $settings['ihc_pagseguro_token'] ), $checkoutUrl );



          $params = array(

          	'method'  	       => 'POST',

          	'timeout' 	       => 60,

          	'body' 		         => $xml,

          	'headers'	         => array( 'Content-Type' => 'application/xml;charset=UTF-8' ),

          );



          $response = wp_safe_remote_post( $url, $params );



          $domObject = new \DOMDocument();

          $responseData = $domObject->loadXML( $response['body'] );

          $finalResponse = simplexml_import_dom( $domObject );

          $token = (string)$finalResponse->code;

          if ( $settings['ihc_pagseguro_sandbox'] ){

              $this->redirectUrl = 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $token;

          } else {

              $this->redirectUrl = 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=' . $token;

          }





        }



        if ( empty( $token ) ){

            return $this;

        }

        $paymentId = $token;



        $transactionData = array(

                      'lid'                 => $this->attributes['lid'],

                      'uid'                 => $this->attributes['uid'],

                      'ihc_payment_type'    => 'pagseguro',

                      'amount'              => $amount,

                      'message'             => 'pending',

                      'currency'            => $this->currency,

                      'item_name'           => $levelData['name'],

        );



        /// save the transaction without saving the order

        ihc_insert_update_transaction( $this->attributes['uid'], $paymentId, $transactionData, true ); /// will save the order too



        /// update indeed_members_payments table, add order id

        \Ihc_Db::updateTransactionAddOrderId( $paymentId, @$this->attributes['orderId'] );



        return $this;

    }



    public function redirect()

    {

        \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(' : Request submited.', 'ihc'), 'payments' );

        header( 'location:' . $this->redirectUrl );

        exit();

    }



    public function webhook()

    {

        if ( empty($_POST) ){

            return false;

        }

        if ( empty($_POST['notificationCode']) || empty($_POST['notificationType']) || $_POST['notificationType']!='transaction' ){

            return false;

        }

        $filename = IHC_PATH . 'temporary_files/' . esc_sql($_POST['notificationCode']) . '.log';

        if ( file_exists( $filename ) ){

            sleep( 30 );

        }

        if ( file_exists( $filename ) ){

            sleep( 30 );

        }

        if ( file_exists( $filename ) ){

            unlink( $filename );

        }

        file_put_contents( $filename, '' );



        header( 'HTTP/1.1 200 OK' );



        $settings = ihc_return_meta_arr('payment_pagseguro');

        if ( $settings['ihc_pagseguro_sandbox'] ){

            $notificationUrl = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/';

        } else {

            $notificationUrl = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/';

        }

        $notificationUrl .= esc_sql($_POST['notificationCode']);

        $notificationUrl = add_query_arg( array( 'email' => $settings['ihc_pagseguro_email'], 'token' => $settings['ihc_pagseguro_token'] ), $notificationUrl);



        $params = array(

          'method'        => 'GET',

          'timeout'       => 60,

        );

        $response = wp_safe_remote_post( $notificationUrl, $params );

        if ( empty( $response['body'] ) ){

            return false;

        }



        $dom = new \DOMDocument();

        $dom->loadXML( $response['body'] );



        if ( !isset( $dom->getElementsByTagName('reference')->item(0)->nodeValue ) || !isset($dom->getElementsByTagName('status')->item(0)->nodeValue) || !isset( $dom->getElementsByTagName('code')->item(0)->nodeValue ) ){

            return false;

        }



        //file_put_contents( IHC_PATH . 'log.log', $response['body']);



        $orderId = $dom->getElementsByTagName('reference')->item(0)->nodeValue;

        $status = $dom->getElementsByTagName('status')->item(0)->nodeValue;

        $transactionCode = $dom->getElementsByTagName('code')->item(0)->nodeValue;

        $transactionCode = str_replace( '-', '', $transactionCode );
		
		//needs payment details
        $paymentData = ihcGetTransactionDetails( $transactionCode );
	
		
		if ($paymentData ){
        	//TRANSACTION EXIST
			$lastOrderId = \Ihc_Db::getLastOrderIdForTransaction( $transactionCode );
			
			//>>>>>FOR DOUBLE NOTIFICATIONS OF THE SAME ITERATION
			if (\Ihc_Db::getOrderStatus( $lastOrderId )=='Completed' ){
                  unlink( $filename );
                  exit;
              }
			//<<<<< 
			 
		}else{
			//TRANSACTION DOES NOT EXIST
			
			//check payment details based on initial OrderID
            $txnId = \Ihc_Db::getTxnIdByOrder( $orderId );
			
			//>>>>to be sure that ihc_insert_update_transaction() does not create a new ORDER || only for FIRST ITERATION
			if( \Ihc_Db::getOrderStatus( $orderId  )!= 'Completed'){				
               \Ihc_Db::changeTxnId($txnId, $transactionCode);
			}
			//<<<<<
			
            $paymentData = ihcGetTransactionDetails( $txnId );
			
			$lastOrderId = $orderId; //epecially for trial case
		}
		
		
		/*
        if ($paymentData ){
        	//TRANSACTION EXIST
			$lastOrderId = $orderId;
        	//$lastOrderId = \Ihc_Db::getLastOrderIdForTransaction( $transactionCode );
		}else{
			//TRANSACTION DOES NOT EXIST
			//check payment details based on initial OrderID
            $txnId = \Ihc_Db::getTxnIdByOrder( $orderId );
			if( \Ihc_Db::getOrderStatus( $orderId  )!= 'Completed'){
               \Ihc_Db::changeTxnId($txnId, $transactionCode);
			}
            $paymentData = ihcGetTransactionDetails( $txnId );
		}
*/

        switch ( $status ){

            case 1:

              break;

            case 2:

              break;

            case 3:

            case 4:

              //check for first iteration
			 /* if ( ($txnId != $transactionCode) && \Ihc_Db::getOrderStatus( $lastOrderId )=='Completed' ){
                  unlink( $filename );
                  exit;
              }*/

              $levelData = ihc_get_level_by_id($paymentData['lid']);//getting details about current level

              $paymentData['message'] = 'success';

              $paymentData['status'] = 'Completed';



              if ( ihc_user_level_first_time( $paymentData['uid'], $paymentData['lid'] ) && \Ihc_Db::level_has_trial_period( $paymentData['lid'] ) ){

                  /// Trial

                  ihc_set_level_trial_time_for_no_pay( $paymentData['lid'], $paymentData['uid'] );

                  \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __( ' IPN: Update user level expire time (Trial).', 'ihc' ), 'payments' );

                  ihc_send_user_notifications( $paymentData['uid'], 'payment', $paymentData['lid'] );//send notification to user

                  ihc_send_user_notifications( $paymentData['uid'], 'admin_user_payment', $paymentData['lid'] );//send notification to admin

                  do_action( 'ihc_payment_completed', $paymentData['uid'], $paymentData['lid'] );

                  ihc_switch_role_for_user( $paymentData['uid'] );

                  // file_put_contents( IHC_PATH . 'paymentData.log', serialize($paymentData) );



                  ihc_insert_update_transaction( $paymentData['uid'], $transactionCode, $paymentData, true );

                  \Ihc_Db::updateOrderStatus( $lastOrderId, 'Completed' );

                  unlink( $filename );

                  exit;

              }



              /// success

              ihc_update_user_level_expire($levelData, $paymentData['lid'], $paymentData['uid']);

              ihc_switch_role_for_user($paymentData['uid']);

              ihc_insert_update_transaction($paymentData['uid'], $transactionCode, $paymentData, false);

              \Ihc_User_Logs::write_log( __("Pagseguro Payment Webhook: Update user level expire time.", 'ihc'), 'payments');

              //send notification to user

              ihc_send_user_notifications($paymentData['uid'], 'payment', $paymentData['lid']);

              ihc_send_user_notifications($paymentData['uid'], 'admin_user_payment', $paymentData['lid']);//send notification to admin

              do_action( 'ihc_payment_completed', $paymentData['uid'], $paymentData['lid'] );

              break;

            case 5:

              /// on hold

              break;

            case 6:

            case 7:

              /// cancelled, refunded

              ihc_delete_user_level_relation($paymentData['lid'], $paymentData['uid']);

              break;

        }

        unlink( $filename );

        exit;

    }



    public function cancelSubscription($preApprovalCode='')

    {

        if (empty($preApprovalCode)) return false;

        $settings = ihc_return_meta_arr('payment_pagseguro');

        if ( $settings['ihc_pagseguro_sandbox'] ){

            $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/cancel/';

        } else {

            $url = 'https://ws.pagseguro.uol.com.br/v2/pre-approvals/cancel/';

        }



        $url .= $preApprovalCode . '?email=' . $settings['ihc_pagseguro_email'] . '&token=' . $settings['ihc_pagseguro_token'];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HEADER, 0);

        $data = curl_exec($ch);

        curl_close($ch);

        return $data;

    }



}

