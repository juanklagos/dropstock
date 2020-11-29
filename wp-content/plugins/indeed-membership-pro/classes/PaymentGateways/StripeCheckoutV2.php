<?php
namespace Indeed\Ihc\PaymentGateways;

/*
Created v.7.4
Deprecated starting with v.9.3
*/

class StripeCheckoutV2 extends \Indeed\Ihc\PaymentGateways\PaymentAbstract
{
    protected $attributes       = array();
    protected $redirectUrl      = '';
    protected $abort            = false;
    protected $paymentTypeLabel = 'Stripe Checkout V2 Payment';
    protected $currency         = '';
    protected $options          = [];
    protected $sessionId        = '';
    protected $levelData        = [];
    private   $paymentIntent    = '';
    private   $amount           = 0;
    private   $successUrl       = '';
    private   $cancelUrl        = '';
    private   $locale           = '';

    public function __construct()
    {
        include IHC_PATH . 'classes/PaymentGateways/stripe_checkout_v2/vendor/autoload.php';
        $this->currency = get_option('ihc_currency');
        $this->options = ihc_return_meta_arr('payment_stripe_checkout_v2');//getting metas
        $this->siteUrl = get_option( 'siteurl' );
        $this->multiply = ihcStripeMultiplyForCurrency( $this->currency );
    }

    private function setLocale()
    {
        $this->locale = $this->options['ihc_stripe_checkout_v2_locale_code'];
        $currentLocale = indeed_get_current_language_code();
        if ( $currentLocale && $this->locale!=$currentLocale ){
            $this->locale = $currentLocale;
        }
        if ( empty( $this->locale ) ){
            $this->locale = 'auto';
        }
    }

    private function setSuccessUrl()
    {
        if ( !empty ( $this->options['ihc_stripe_checkout_v2_success_page'] ) && $this->options['ihc_stripe_checkout_v2_success_page'] > -1 ){
            $this->successUrl = $this->options['ihc_stripe_checkout_v2_success_page'];
            $this->successUrl = get_permalink( $this->successUrl );
        }
        if ( empty( $this->successUrl ) ){
            $this->successUrl = $this->siteUrl;
        }
    }

    private function setCancelUrl()
    {
        if ( !empty ( $this->options['ihc_stripe_checkout_v2_cancel_page'] ) && $this->options['ihc_stripe_checkout_v2_cancel_page'] > -1 ){
            $this->cancelUrl = $this->options['ihc_stripe_checkout_v2_cancel_page'];
            $this->cancelUrl = get_permalink( $this->cancelUrl );
        }
        if ( empty( $this->cancelUrl ) ){
            $this->cancelUrl = $this->siteUrl;
        }
    }

    public function doPayment()
    {
        \Stripe\Stripe::setApiKey( $this->options['ihc_stripe_checkout_v2_secret_key'] );
        $levels = get_option('ihc_levels');
        $this->levelData = $levels[$this->attributes['lid']];

        /// lacale
        $this->setLocale();
        /// success url
        $this->setSuccessUrl();
        /// cancel url
        $this->setCancelUrl();

        if ( isset($this->levelData['access_type']) && $this->levelData['access_type']=='regular_period' ){
            \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __( ': Recurrence payment set.', 'ihc' ), 'payments');
            $this->sessionId = $this->getSessionIdForRecurringPayment();
        } else {
            \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __( ': single payment set.', 'ihc' ), 'payments');
            $this->sessionId = $this->getSessionIdForSinglePayment();
        }

        /// save transaction
        $transactionData = array(
                      'lid'                 => $this->attributes['lid'],
                      'uid'                 => $this->attributes['uid'],
                      'ihc_payment_type'    => 'stripe_checkout_v2',
                      'amount'              => $this->amount,
                      'currency'            => $this->currency,
                      'item_name'           => $this->levelData['name'],
                      'payment_status'      => 'pending',
        );

        /// save transaction
        $IndeedMembersPayments = new \Indeed\Ihc\Db\IndeedMembersPayments();
        $IndeedMembersPayments->setTxnId( $this->paymentIntent )
                              ->setUid( $this->attributes['uid'] )
                              ->setPaymentData( $transactionData )
                              ->setHistory( $transactionData )
                              ->setOrders( $this->attributes['orderId'] )
                              ->save();

        /// save txn_id into order meta
        $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
        $orderMeta->save( $this->attributes['orderId'], 'txn_id', $this->paymentIntent );

        return $this;
    }

    private function getSessionIdForSinglePayment()
    {
        $couponData = $this->getCouponData();
        $this->amount = $this->levelData['price'];
        /// coupon
        if ( $couponData ){
          $this->amount = ihc_coupon_return_price_after_decrease( $this->amount, $couponData, true, $this->attributes['uid'], $this->attributes['lid'] );
        }

        /// TAXES
        $this->amount = $this->addTaxes( $this->amount );
        /// dynamic price
        $this->amount = $this->applyDynamicPrice( $this->amount );
        $amount = $this->amount * $this->multiply;
        if ( $this->multiply==100 && $amount> 0 && $amount<50){
            $amount = 50;// 0.50 cents minimum amount for stripe transactions
        }

        $sessionData = [
          'payment_method_types'    => ['card'],
          "line_items" => [[
                  "name"        => $this->levelData['label'],
                  "description" => " ".strip_tags($this->levelData['description']),
                  "amount"      => $amount,
                  "currency"    => $this->currency,
                  "quantity"    => 1
          ]],
          'client_reference_id'       => $this->attributes['uid'] . '_' . $this->attributes['lid'], // {uid}_{lid}
          'success_url'               => $this->successUrl,
          'cancel_url'                => $this->cancelUrl,
          'locale'                    => $this->locale,
        ];

        if ( !empty( $this->options['ihc_stripe_checkout_v2_use_user_email'] ) ){
            $sessionData['customer_email'] = \Ihc_Db::user_get_email( $this->attributes['uid'] );
        }

        $session = \Stripe\Checkout\Session::create( $sessionData );

        /// save payment intent
        $this->paymentIntent = isset( $session->payment_intent ) ? $session->payment_intent : '';

        return isset( $session->id ) ? $session->id : 0;
    }

    private function getSessionIdForRecurringPayment()
    {
        $couponData = $this->getCouponData();

	    $this->amount = $this->levelData['price'];

		 /// TAXES
        //$this->amount = $this->addTaxes( $this->amount );

        /// DYNAMIC PRICE
        $this->amount = $this->applyDynamicPrice( $this->amount );

        \Ihc_User_Logs::write_log( __('Stripe Checkout Payment: Recurrence payment set.', 'ihc'), 'payments');
        switch ($this->levelData['access_regular_time_type']){
          case 'D':
            $this->levelData['access_regular_time_type'] = 'day';
            break;
          case 'W':
            $this->levelData['access_regular_time_type'] = 'week';
            break;
          case 'M':
            $this->levelData['access_regular_time_type'] = 'month';
            break;
          case 'Y':
            $this->levelData['access_regular_time_type'] = 'year';
            break;
        }

        ///CHECK IF TRIAL/INITIAL PAYMENT IS SETUP
        $trial_period_days = $this->setTrialDaysPeriod();

        if ( $trial_period_days == 0 && !empty( $couponData ) ){
            // COUPONS WITHOUT TRIAL
            $discountedValue = ihc_get_discount_value( $this->amount, $couponData );
            if ( $couponData['reccuring'] == 1 ){
                 //COUPON APPLIED FOREVER
                $this->amount = $this->amount - $discountedValue;
            } else {
                 //COUPON JUST ONCE - will become a Trial period
                if ( $discountedValue ){
                    $trialAmount = $this->amount - $discountedValue;
                }
                $trial_period_days = $this->setTimeForSingleTimeCoupon();
            }
            \Ihc_User_Logs::write_log( __('Stripe Checkout Payment: the user used the following coupon: ', 'ihc') . $this->attributes['ihc_coupon'], 'payments');

        } else if ( $trial_period_days > 0 && !empty( $couponData ) ) {
            // COUPONS WITH TRIAL
            if ( isset( $this->levelData['access_trial_price'] ) && $this->levelData['access_trial_price'] != ''
                    && ( !empty($this->levelData['access_trial_time_value']) || !empty($this->levelData['access_trial_couple_cycles']) ) ){
                $trialAmount = $this->levelData['access_trial_price'];
            }

			 if ( $couponData['reccuring'] == 1 ){
				 //COUPON APPLIED FOREVER
				 //FIRST TRIAL
				  if ( $trialAmount ){
					   $discountedValueTrial = ihc_get_discount_value( $trialAmount, $couponData );
					    if ( $discountedValueTrial ){
								$trialAmount = $trialAmount - $discountedValueTrial;
                   	 	}
				  }
				  //THEN REGULAR AMOUNT
				  $discountedValue = ihc_get_discount_value( $this->amount , $couponData );
					    if ( $discountedValue ){
								$this->amount = $this->amount  - $discountedValue;
                    }
			 }else{
				 //COUPON JUST ONCE
				  if ( $trialAmount ){
						  $discountedValue = ihc_get_discount_value( $trialAmount, $couponData );
						   if ( $discountedValue ){
								$trialAmount = $trialAmount - $discountedValue;
							}
				  }
			 }
			\Ihc_User_Logs::write_log( __('Stripe Checkout Payment: User apply following Coupon: ', 'ihc') . $this->attributes['ihc_coupon'], 'payments');

			/*
            if ( $trialAmount ){
                $discountedValue = ihc_get_discount_value( $trialAmount, $couponData );
                if ( $couponData['reccuring'] == 1 ){
                    /// forever discount
                    $amount = $trialAmount - $discountedValue;
                    $amount= $this->addTaxes( $amount );
                } else {
                    // only once
                    if ( $discountedValue ){
                        $trialAmount = $trialAmount - $discountedValue;
                        $trialAmount = $this->addTaxes( $trialAmount );
                        $trialAmount = round( $trialAmount, 2 );
                    }
                }



                \Ihc_User_Logs::write_log( __('Stripe Checkout Payment: the user used the following coupon: ', 'ihc') . $this->attributes['ihc_coupon'], 'payments');
            }*/

        } else if ( $trial_period_days > 0 ){
            // TRIAL WITHOUT COUPONS
            if ( empty( $trialAmount ) ){
                if ( isset( $this->levelData['access_trial_price'] ) && $this->levelData['access_trial_price'] != ''
                      && ( !empty($this->levelData['access_trial_time_value']) || !empty($this->levelData['access_trial_couple_cycles']) ) ){
                    $trialAmount = $this->levelData['access_trial_price'];
                }
            }
        }

		 /// TAXES
        $this->amount = $this->addTaxes( $this->amount );

        $amount = $this->amount * $this->multiply;
        if ( $this->multiply==100 && $amount> 0 && $amount<50){
            $amount = 50;// 0.50 cents minimum amount for stripe transactions
        }
		    $this->amount = round( $this->amount, 0 );

        $ihcPlanCode = $this->attributes['uid'] . '_' . $this->attributes['lid'] . '_' . indeed_get_unixtimestamp_with_timezone();
        $plan = array(
            "amount"          => $amount,
            "interval_count"  => $this->levelData['access_regular_time_value'],
            "interval"        => $this->levelData['access_regular_time_type'],
            "product"         => array(
                                  "name"    => $this->levelData['label'],
                                  'type'    => 'service',
            ),
            "currency"        => $this->currency,
            "id"              => $ihcPlanCode,
        );

        $return_data_plan = \Stripe\Plan::create($plan);

        $sessionAttributes = [
            'payment_method_types'      => ['card'],
            'subscription_data'         => [
              "items"                   => [[
                  'plan'        => $ihcPlanCode, /// ID of plan
                  'quantity'    => 1,
              ]],
              'metadata'                => [
                  'uid'         => $this->attributes['uid'],
                  'lid'         => $this->attributes['lid'],
                  'order_id'    => $this->attributes['orderId']
              ]
            ],
            'client_reference_id'       => $this->attributes['orderId'], // {uid}_{lid}
            'success_url'               => $this->successUrl,
            'cancel_url'                => $this->cancelUrl,
            'locale'                    => $this->locale,
        ];

        if ( !empty( $trialAmount ) ){

			//taxes INCLUDING FOR TRIAL
            $trialAmount = $this->addTaxes( $trialAmount );
            $trialAmount = round( $trialAmount, 2 );

            $sessionAttributes['line_items'][] = [
                    "name"        => __('Initial payment', 'ihc'),
                    "description" => __('Initial payment', 'ihc'),
                    "amount"      => ($trialAmount * $this->multiply),
                    "currency"    => $this->currency,
                    "quantity"    => 1
            ];
        }

        if ( $trial_period_days ){
            $sessionAttributes['subscription_data']['trial_period_days'] = $trial_period_days;
        }

        if ( !empty( $this->options['ihc_stripe_checkout_v2_use_user_email'] ) ){
            $sessionAttributes['customer_email'] = \Ihc_Db::user_get_email( $this->attributes['uid'] );
        }

        $session = \Stripe\Checkout\Session::create( $sessionAttributes );

        /// save payment intent
        $this->paymentIntent = $this->attributes['orderId'];

        return isset( $session->id ) ? $session->id : 0;
    }

    private function setTimeForSingleTimeCoupon()
    {
        switch ( $this->levelData['access_regular_time_type'] ) {
            case 'day':
              $days = $this->levelData['access_regular_time_value'];
              break;
            case 'week':
              $days = $this->levelData['access_regular_time_value'] * 7;
              break;
            case 'month':
              $days = $this->levelData['access_regular_time_value'] * 31;
              break;
            case 'year':
              $days = $this->levelData['access_regular_time_value'] * 365;
              break;
        }
        return $days;
    }

    private function setTrialDaysPeriod()
    {
        $trial_period_days = 0;
        if (!empty($this->levelData['access_trial_type'])){
          if ($this->levelData['access_trial_type']==1 && isset($this->levelData['access_trial_time_value'])
              && $this->levelData['access_trial_time_value'] !=''){
            switch ($this->levelData['access_trial_time_type']){
              case 'D':
                $trial_period_days = $this->levelData['access_trial_time_value'];
                break;
              case 'W':
                $trial_period_days = $this->levelData['access_trial_time_value'] * 7;
                break;
              case 'M':
                $trial_period_days = $this->levelData['access_trial_time_value'] * 31;
                break;
              case 'Y':
                $trial_period_days = $this->levelData['access_trial_time_value'] * 365;
                break;
            }
          } else if ($this->levelData['access_trial_type']==2 && isset($this->levelData['access_trial_couple_cycles'])
                && $this->levelData['access_trial_couple_cycles']!=''){
            switch ($this->levelData['access_regular_time_type']){
              case 'day':
                $trial_period_days = $this->levelData['access_regular_time_value'] * $this->levelData['access_trial_couple_cycles'];
                break;
              case 'week':
                $trial_period_days = $this->levelData['access_regular_time_value'] * $this->levelData['access_trial_couple_cycles'] * 7;
                break;
              case 'month':
                $trial_period_days = $this->levelData['access_regular_time_value'] * $this->levelData['access_trial_couple_cycles'] * 31;
                break;
              case 'year':
                $trial_period_days = $this->levelData['access_regular_time_value'] * $this->levelData['access_trial_couple_cycles'] * 365;
                break;
            }
          }
        }
        return $trial_period_days;
    }

    private function getCouponData()
    {
        $couponData = array();
        if ( !empty( $this->attributes['ihc_coupon'] ) ){
            $couponData = ihc_check_coupon( $this->attributes['ihc_coupon'], $this->attributes['lid'] );
            \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __( ': the user used the following coupon: ', 'ihc' ) . $this->attributes['ihc_coupon'], 'payments');
        }
        return $couponData;
    }


    public function redirect()
    {
        if ( $this->sessionId ){
            /// redirect
            \Ihc_User_Logs::write_log( $this->paymentTypeLabel . __(': Request submited.', 'ihc'), 'payments');
            $redirect = IHC_URL . 'classes/PaymentGateways/stripe_checkout_v2_payment.php?sessionId=' . $this->sessionId . '&key=' . $this->options['ihc_stripe_checkout_v2_publishable_key'];
        } else {
            /// go home
            $redirect = $this->siteUrl;
        }
        header( 'location:' . $redirect );
        exit();
    }

    public function webhook()
    {
        $timestamp = indeed_get_unixtimestamp_with_timezone();
        $response = @file_get_contents( 'php://input' );

        \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Start process.", 'ihc'), 'payments');

        if ( !$response ){
            \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Exit. No response available.", 'ihc'), 'payments');
            exit;
        }
        $responseData = json_decode( $response, true );
        if ( !$responseData || empty( $responseData['type'] ) ){
            \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Exit. No response type available.", 'ihc'), 'payments');
            exit;
        }

        \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Set rresponse type @" . @$responseData['type'], 'ihc'), 'payments');
        switch ( $responseData['type'] ){
			       case 'invoice.paid':
              $transactionIdentificator = isset($responseData['data']['object']['payment_intent']) ? $responseData['data']['object']['payment_intent'] : '';
              $dataFromDb = ihcGetTransactionDetails( $transactionIdentificator );

              if ( !$dataFromDb ){
                  /// recurring payment
                  $this->approveRecurringPAymentLevel( $responseData );
              }
              break;
            case 'charge.succeeded':
              $transactionIdentificator = isset($responseData['data']['object']['payment_intent']) ? $responseData['data']['object']['payment_intent'] : '';
              $dataFromDb = ihcGetTransactionDetails( $transactionIdentificator );

              if ( $dataFromDb ){
                  /// single payment
                  $this->approveSinglePaymentLevel( $responseData, $transactionIdentificator, $dataFromDb );
              }
              break;
            case 'charge.refunded':    /// make level expired
            case 'charge.dispute.funds_withdrawn':
              $this->refund( $responseData );
              break;
        }
    }

    private function approveSinglePaymentLevel( $transactionDetails=[], $transactionIdentificator='', $data=[] )
    {
        \Ihc_User_Logs::set_user_id( $data['uid'] );
        \Ihc_User_Logs::set_level_id( $data['lid'] );
        \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Start approve single payment.", 'ihc'), 'payments');
        end($data['orders']);
        $orderId = current($data['orders']);

        $orderObject = new \Indeed\Ihc\Db\Orders();
        $orderData = $orderObject->setId( $orderId )->fetch()->get();
        if ( isset( $orderData->status ) && $orderData->status != 'pending'){
            \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: This order already has been approved.", 'ihc'), 'payments');
            exit();
        }

        $levels = get_option('ihc_levels');
        $levelData = $levels[$data['lid']];
        $currentTransactionAmount = $transactionDetails['data']['object']['amount']/$this->multiply;
        //unset($transactionDetails['data']);
        //sleep(10);

        ihc_update_user_level_expire( $levelData, $data['lid'], $data['uid'] );
        \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Updated user (".$data['uid'].") level (".$data['lid'].") expire time.", 'ihc'), 'payments');
        ihc_switch_role_for_user($data['uid']);

        $dataDb = $data;//array_merge( $data, $transactionDetails['data']['object'] );
        $dataDb['message'] = 'success';
        $dataDb['status'] = 'Completed';/// this is very important

        if ( $dataDb['amount'] != $currentTransactionAmount || $dataDb['amount'] == 0 || $dataDb['amount'] == NULL ){
            \Ihc_User_Logs::write_log( __('Stripe Checkout Payment Webhook: Update the right amount ' . $currentTransactionAmount, 'ihc'), 'payments');
            $dataDb['amount'] = $currentTransactionAmount;
        }

        \Ihc_Db::updateOrderStatus( $orderId, 'Completed' );

        \Ihc_User_Logs::write_log( __('Stripe Checkout Payment Webhook: Single Payment - Make Order Completed.', 'ihc'), 'payments');

        $paymentData = [
                      "uid"               => $data['uid'],
                      "lid"               => $data['lid'],
                      "amount"            => $currentTransactionAmount,
                      "ihc_payment_type"  => "stripe_checkout_v2",
                      "message"           => "success",
                      "status"            => "Completed",
                      "payment_status"    => "Completed",
        ];

        $IndeedMembersPayments = new \Indeed\Ihc\Db\IndeedMembersPayments();
        $IndeedMembersPayments->setTxnId( $transactionIdentificator )
                              ->setUid( $data['uid'] )
                              ->setPaymentData( $paymentData )
                              ->setHistory( $paymentData )
                              ->setOrders( $currentOrderId ) // $orderId
                              ->save();

        \Ihc_User_Logs::write_log( __('Stripe Checkout Payment Webhook: Single Payment - Completed.', 'ihc'), 'payments');

        //send notification to user
        ihc_send_user_notifications($data['uid'], 'payment', $data['lid']);
        ihc_send_user_notifications($data['uid'], 'admin_user_payment', $data['lid']);//send notification to admin
        do_action( 'ihc_payment_completed', $data['uid'], $data['lid'] );
        // @description run on payment complete. @param user id (integer), level id (integer)

        http_response_code(200);
        exit();
    }

    private function approveRecurringPAymentLevel( $transactionDetails=[] )
    {
        \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Start approve recurring payment.", 'ihc'), 'payments');
        if ( empty( $this->options['ihc_stripe_checkout_v2_secret_key'] ) ){
            exit;
        }
        \Stripe\Stripe::setApiKey( $this->options['ihc_stripe_checkout_v2_secret_key'] );
        $doExit = false;
        $isTrial = false;

        $charge = false;
        $chargeId = isset( $transactionDetails['data']['object']['charge'] ) ? $transactionDetails['data']['object']['charge'] : '';
        $customerId = isset( $transactionDetails['data']['object']['customer'] ) ? $transactionDetails['data']['object']['customer'] : '';
        if ( $chargeId ){
            $charge = \Stripe\Charge::retrieve( $chargeId );
        }

        $metaData = isset( $transactionDetails['data']['object']['lines']['data'][0]['metadata'] ) ? $transactionDetails['data']['object']['lines']['data'][0]['metadata'] : '';

        if ( !isset( $metaData['order_id'] ) ){
            $metaData = isset( $transactionDetails['data']['object']['lines']['data'][1]['metadata'] ) ? $transactionDetails['data']['object']['lines']['data'][1]['metadata'] : '';
            $isTrial = true;
        }
        $transactionId = isset( $metaData['order_id'] ) ? $metaData['order_id'] : '';

        $currentOrderId = \Ihc_Db::getLastOrderByTxnId( $transactionId );
        $order = new \Indeed\Ihc\Db\Orders();
        $orderStatus = $order->setId( $currentOrderId )->fetch()->getStatus();
        $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
        $orderMetaChargeId = $orderMeta->get( $currentOrderId, 'charge_id' );

        if ( $orderStatus == 'Completed' && $orderMetaChargeId == $chargeId ){
            /// order already exists
            \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Exit. This charge has already been saved.", 'ihc'), 'payments');
            http_response_code(200);
            exit;
        }

        if ( empty($charge) || empty($charge->status) || $charge->status != 'succeeded' ){
            $doExit = true;
            $subscription = \Stripe\Subscription::retrieve( $transactionDetails['data']['object']['subscription'] );
            if ( $subscription->status == 'trialing' && $subscription->trial_end > indeed_get_unixtimestamp_with_timezone() && $subscription->trial_start < indeed_get_unixtimestamp_with_timezone() ){
                $doExit = false;
                $isTrial = true;
            }
        }

        if ( $doExit ){
            http_response_code(200);
            exit;
        }

        /// check if charge succeded
        if ( empty( $transactionId ) ){
            \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Empty Transaction Id.", 'ihc'), 'payments');
            http_response_code(200);
            exit;
        }

        $data = ihcGetTransactionDetails( $transactionId );
        \Ihc_User_Logs::set_user_id( $data['uid'] );
        \Ihc_User_Logs::set_level_id( $data['lid'] );
        if ( empty( $data ) ){
            http_response_code(200);
            exit;
        }

        $levels = get_option('ihc_levels');
        $levelData = $levels[$data['lid']];
        $currentTransactionAmount = $transactionDetails['data']['object']['amount'] / $this->multiply;

        if ( $isTrial ){
            \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Set Trial Time.", 'ihc'), 'payments');
            ihc_set_level_trial_time_for_no_pay( $metaData['lid'], $metaData['uid'] );
        } else {
            ihc_update_user_level_expire( $levelData, $data['lid'], $data['uid'] );
        }
        \Ihc_User_Logs::write_log( __("Stripe Checkout Payment Webhook: Updated user (".$data['uid'].") level (".$data['lid'].") expire time.", 'ihc'), 'payments');
        ihc_switch_role_for_user($data['uid']);

        $dataDb = $data;//array_merge( $data, $transactionDetails['data']['object'] );
        $dataDb['message'] = 'success';
        $dataDb['status'] = 'Completed';

        if ( ($dataDb['amount'] != $currentTransactionAmount || $dataDb['amount'] == 0 || $dataDb['amount'] == NULL) && !$isTrial ){
            \Ihc_User_Logs::write_log( __('Stripe Checkout Payment Webhook: Update the right amount ' . $currentTransactionAmount, 'ihc'), 'payments');
            $dataDb['amount'] = $currentTransactionAmount;
        }

        //ihc_insert_update_transaction( $data['uid'], $transactionIdentificator, $dataDb, true );
        if ( $orderStatus == 'Completed' ){
            /// insert new order
            $orderObject = new \Indeed\Ihc\Db\Orders();
            $currentOrderId = $orderObject->setData( [
                                                'amount_value'      => $transactionDetails['data']['object']['amount_paid'] / $this->multiply,
                                                'amount_type'       => $transactionDetails['data']['object']['currency'],
                                                'uid'               => $metaData['uid'],
                                                'lid'               => $metaData['lid'],
                                                'automated_payment' => 1,
                                                'status'            => 'Completed',
            ] )->save();
            \Ihc_User_Logs::write_log( __('Stripe Checkout Payment Webhook: Recurring Payment - Save the order.', 'ihc'), 'payments');
        } else {
            /// update
            \Ihc_Db::updateOrderStatus( $currentOrderId, 'Completed' );
            \Ihc_User_Logs::write_log( __('Stripe Checkout Payment Webhook: Recurring Payment - Update the order.', 'ihc'), 'payments');
        }
        /// save txn_id
        $orderMeta->save( $currentOrderId, 'txn_id', $transactionId );
        /// save charge_id
        $orderMeta->save( $currentOrderId, 'charge_id', $chargeId );
        $orderMeta->save( $currentOrderId, 'customer_id', $customerId );
        $orderMeta->save( $currentOrderId, 'ihc_payment_type', 'stripe_checkout_v2' );

        $paymentData = [
                          "uid"               => $metaData['uid'],
                          "lid"               => $metaData['lid'],
                          "amount"            => $currentTransactionAmount,
                          "ihc_payment_type"  => "stripe_checkout_v2",
                          "message"           => "success",
                          "status"            => "Completed",
                          "payment_status"    => "Completed",
        ];
        $IndeedMembersPayments = new \Indeed\Ihc\Db\IndeedMembersPayments();
        $IndeedMembersPayments->setTxnId( $transactionId )
                              ->setUid( $metaData['uid'] )
                              ->setPaymentData( $paymentData )
                              ->setHistory( $paymentData )
                              ->setOrders( $orderId )
                              ->save();

        \Ihc_User_Logs::write_log( __('Stripe Checkout Payment Webhook: Recurring Payment - Completed.', 'ihc'), 'payments');

        // update subscription plan
        if ( isset( $transactionDetails['data']['object']['attempted'] ) && $transactionDetails['data']['object']['attempted'] == 1 ){
            $levelsData = get_option( 'ihc_levels' );
            if ( isset($levelsData[$data['lid']] ) && isset($levelsData[$data['lid']]['billing_type']) && $levelsData[$data['lid']]['billing_type'] == 'bl_limited' ){
                $done = \Stripe\SubscriptionSchedule::create([
                        'customer'    => $transactionDetails['data']['object']['customer'],
                        'start_date'  => $transactionDetails['data']['object']['created'],
                        'end_behavior' => 'cancel',
                        'phases'      => [
                                            [
                                              'plans' => [
                                                [
                                                  'price'     => @$transactionDetails['data']['object']['lines']['data'][0]['plan']['id'],
                                                  'plan'      => @$transactionDetails['data']['object']['lines']['data'][0]['plan']['id'],
                                                  'quantity'  => 1,
                                                ],
                                              ],
                                              'iterations' => $levelsData[$data['lid']]['billing_limit_num'],/// modify this
                                            ],
                        ],
                ]);
            }
        }
        // end of update subscription plan

        //send notification to user
        ihc_send_user_notifications($data['uid'], 'payment', $data['lid']);
        ihc_send_user_notifications($data['uid'], 'admin_user_payment', $data['lid']);//send notification to admin
        do_action( 'ihc_payment_completed', $data['uid'], $data['lid'] );
        // @description run on payment complete. @param user id (integer), level id (integer)

        http_response_code(200);
        exit();
    }

    public function refund( $transactionDetails=[] )
    {
        if ( empty( $this->options['ihc_stripe_checkout_v2_secret_key'] ) ){
            http_response_code(200);
            exit;
        }
        \Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Refund process start.", 'ihc'), 'payments');
        \Stripe\Stripe::setApiKey( $this->options['ihc_stripe_checkout_v2_secret_key'] );

        $invoiceId = isset( $transactionDetails['data']['object']['invoice'] ) ? $transactionDetails['data']['object']['invoice'] : '';

        $data = \Stripe\Invoice::retrieve( $invoiceId );
        $metaData = isset($data['lines']['data'][0]['metadata']) ? $data['lines']['data'][0]['metadata'] : [];

        $uid = isset( $metaData['uid'] ) ? $metaData['uid'] : '';
        $lid = isset( $metaData['lid'] ) ? $metaData['lid'] : '';

        if ( !$uid || !$lid ){
            \Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Refund process stopped! User id or level id doesn't exists.", 'ihc'), 'payments');
            http_response_code(200);
            exit;
        }

        \Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Delete user level.", 'ihc'), 'payments');
        ihc_delete_user_level_relation( $lid, $uid );

        http_response_code(200);

    }

    public function cancelSubscription( $transactionId='' )
    {
        if ( !$transactionId ){
            return false;
        }
        if ( empty( $this->options['ihc_stripe_checkout_v2_secret_key'] ) ){
            return false;
        }

        $orderId = \Ihc_Db::getLastOrderByTxnId( $transactionId );
        $orderMetas = new \Indeed\Ihc\Db\OrderMeta();
        $chargeId = $orderMetas->get( $orderId, 'charge_id' );
        $lid = \Ihc_Db::getLidByOrder( $orderId );

        \Stripe\Stripe::setApiKey( $this->options['ihc_stripe_checkout_v2_secret_key'] );

        if ( $chargeId === null || $chargeId == '' ){
            /// get from customer_id - lid . this is for the case when recurring is with trial without any payment made
            $customerId = $orderMetas->get( $orderId, 'customer_id' );
            if ( !$customerId ){
                return false;
            }
            $customer = \Stripe\Customer::retrieve( $customerId );
            if ( !$customer ){
                return false;
            }


            foreach ( $customer->subscriptions as $subscription ){
            		if ( isset( $subscription['metadata']->lid ) && $subscription['metadata']->lid == $lid ){ /// add extra condition here
            				$subscriptionId = $subscription->id;
                    break;
            		}
            }

        } else {
            $chargeObject = \Stripe\Charge::retrieve( $chargeId );
            $customerId = $chargeObject->customer;
            $invoiceObject = \Stripe\Invoice::retrieve( $chargeObject->invoice );

            if ( isset( $invoiceObject->lines->data[0]->id ) && strpos( $invoiceObject->lines->data[0]->id, 'sub' ) === 0 ){
                $subscriptionId = $invoiceObject->lines->data[0]->id;
            } else if ( isset( $invoiceObject->lines->data[0]->subscription ) && strpos( $invoiceObject->lines->data[0]->subscription, 'sub' ) === 0 ){
                $subscriptionId = $invoiceObject->lines->data[0]->subscription;
            }

            if ( empty( $subscriptionId ) ){
                for ( $i=1; $i<count($invoiceObject->lines->data); $i++ ){
                    if ( isset( $invoiceObject->lines->data[$i]->id ) && strpos( $invoiceObject->lines->data[$i]->id, 'sub' ) === 0 ){
                        $subscriptionId = $invoiceObject->lines->data[$i]->id;
                    } else if ( isset( $invoiceObject->lines->data[$i]->subscription ) && strpos( $invoiceObject->lines->data[$i]->subscription, 'sub' ) === 0 ){
                        $subscriptionId = $invoiceObject->lines->data[$i]->subscription;
                    }
                }
            }

        }

        if ( !$subscriptionId ){
            return false;
        }

        // new api
        $subscription = \Stripe\Subscription::retrieve( $subscriptionId);

        if ( empty( $subscription ) ) {
            return false;
        }

        $result = $subscription->cancel();

        return $result;

        /*
        $customer = \Stripe\Customer::retrieve( $customerId );

        if ( !$customer ){
            return false;
        }
        if ( !isset($customer->subscriptions) || empty($customer->subscriptions->data)){
            return false;
        }

        $exists = false;
        foreach ( $customer->subscriptions->data as $k => $temp_obj ){
            if ( !empty( $temp_obj->id ) && $temp_obj->id == $subscriptionId ){
                $exists = true;
                break;
            }
        }
        if ( !$exists ){
            return false;
        }

        @$subscription = $customer->subscriptions->retrieve( $subscriptionId );

        if ( empty($subscription) ){
            return false;
        }
        try {
            @$value = $subscription->cancel();
        } catch (Stripe\Error\InvalidRequest $e){
            $value = false;
        }
        return $value;
        */
    }

}
