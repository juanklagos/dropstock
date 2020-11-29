<?php
namespace Indeed\Ihc\Gateways;

class StripeCheckout extends \Indeed\Ihc\Gateways\PaymentAbstract
{
    protected $paymentType                    = 'stripe_checkout_v2'; // slug. cannot be empty.

    protected $paymentRules                   = [
                'canDoRecurring'						                  => true, // does current payment gateway supports recurring payments.
                'canDoTrial'							                    => true, // does current payment gateway supports trial subscription
                'canDoTrialFree'						                  => true, // does current payment gateway supports free trial subscription
                'canApplyCouponOnRecurringForFirstPayment'		=> true, // if current payment gateway support coupons on recurring payments only for the first transaction
                'canApplyCouponOnRecurringForFirstFreePayment'=> true, // if current payment gateway support coupons with 100% discount on recurring payments only for the first transaction.
                'canApplyCouponOnRecurringForEveryPayment'	  => true, // if current payment gateway support coupons on recurring payments for every transaction
                'paymentMetaSlug'                             => 'payment_stripe_checkout_v2', // payment gateway slug. exenple: paypal, stripe, etc.
                'returnUrlAfterPaymentOptionName'             => 'ihc_stripe_checkout_v2_success_page', // option name ( in wp_option table ) where it's stored the return URL after a payment is done.
                'returnUrlOnCancelPaymentOptionName'          => 'ihc_stripe_checkout_v2_cancel_page', // option name ( in wp_option table ) where it's stored the return URL after a payment is canceled.
                'paymentGatewayLanguageCodeOptionName'        => 'ihc_stripe_checkout_v2_locale_code', // option name ( in wp_option table ) where it's stored the language code.
    ]; // some payment does not support all our features
    protected $intervalSubscriptionRules      = [
                    'daysSymbol'                    => 'day',
                    'weeksSymbol'                   => 'week',
                    'monthsSymbol'                  => 'month',
                    'yearsSymbol'                   => 'year',
                    'daysSupport'                   => true,
                    'daysMinLimit'                  => 1,
                    'daysMaxLimit'                  => 365,
                    'weeksSupport'                  => true,
                    'weeksMinLimit'                 => 1,
                    'weeksMaxLimit'                 => 52,
                    'monthsSupport'                 => true,
                    'monthsMinLimit'                => 1,
                    'monthsMaxLimit'                => 12,
                    'yearsSupport'                  => true,
                    'yearsMinLimit'                 => 1,
                    'yearsMaxLimit'                 => 1,
                    'maximumRecurrenceLimit'        => 52, // leave this empty for unlimited
                    'minimumRecurrenceLimit'        => 2,
                    'forceMaximumRecurrenceLimit'   => false,
    ];
    protected $intervalTrialRules             = [
                              'daysSymbol'               => 'day',
                              'weeksSymbol'              => '',
                              'monthsSymbol'             => '',
                              'yearsSymbol'              => '',
                              'supportCertainPeriod'     => true,
                              'supportCycles'            => false,
                              'cyclesMinLimit'           => 1,
                              'cyclesMaxLimit'           => '',
                              'daysSupport'              => true,
                              'daysMinLimit'             => 1,
                              'daysMaxLimit'             => 365,
                              'weeksSupport'             => false,
                              'weeksMinLimit'            => '',
                              'weeksMaxLimit'            => '',
                              'monthsSupport'            => false,
                              'monthsMinLimit'           => '',
                              'monthsMaxLimit'           => '',
                              'yearsSupport'             => false,
                              'yearsMinLimit'            => '',
                              'yearsMaxLimit'            => '',
    ];

    protected $stopProcess                    = false;
    protected $inputData                      = []; // input data from user
    protected $paymentOutputData              = [];
    protected $paymentSettings                = []; // api key, some credentials used in different payment types

    protected $paymentTypeLabel               = 'Stripe Checkout V2'; // label of payment
    protected $redirectUrl                    = ''; // redirect to payment gateway or next page
    protected $defaultRedirect                = ''; // redirect home
    protected $errors                         = [];
    protected $multiply                       = '';


    /**
     * @param none
     * @return object
     */
    public function charge()
    {
        include IHC_PATH . 'classes/gateways/libraries/stripe-checkout/vendor/autoload.php';
        $this->multiply = ihcStripeMultiplyForCurrency( $this->paymentOutputData['currency'] );
        \Stripe\Stripe::setApiKey( $this->paymentSettings['ihc_stripe_checkout_v2_secret_key'] );

        /// locale
        $this->setLocale();

        $this->paymentOutputData['amount'] = $this->paymentOutputData['amount'] * $this->multiply;
        if ( $this->multiply==100 && $this->paymentOutputData['amount']> 0 && $this->paymentOutputData['amount']<50){
            $this->paymentOutputData['amount'] = 50;// 0.50 cents minimum amount for stripe transactions
        }
        $this->paymentOutputData['amount'] = round( $this->paymentOutputData['amount'], 0 );

        if ( $this->paymentOutputData['is_recurring'] ){
            // recurring
            $this->sessionId = $this->getSessionIdForRecurringPayment();
        } else {
            // single payment
            $this->sessionId = $this->getSessionIdForSinglePayment();
        }

        if ( $this->sessionId ){
            $this->redirectUrl = IHC_URL . 'classes/PaymentGateways/stripe_checkout_v2_payment.php?sessionId=' . $this->sessionId . '&key=' . $this->paymentSettings['ihc_stripe_checkout_v2_publishable_key'];
        } else {
            /// go home
            $this->redirectUrl = '';
        }

		    return $this;
    }

    /**
     * @param none
     * @return string
     */
    private function getSessionIdForSinglePayment()
    {
        $sessionData = [
          'payment_method_types'    => ['card'],
          "line_items" => [[
                  "name"        => $this->paymentOutputData['level_label'],
                  "description" => " " . strip_tags( $this->paymentOutputData['level_description'] ),
                  "amount"      => $this->paymentOutputData['amount'],
                  "currency"    => $this->paymentOutputData['currency'],
                  "quantity"    => 1,
          ]],
          'client_reference_id'       => $this->paymentOutputData['uid'] . '_' . $this->paymentOutputData['lid'], // {uid}_{lid}
          'success_url'               => $this->returnUrlAfterPayment,
          'cancel_url'                => $this->cancelUrlAfterPayment,
          'locale'                    => $this->locale,
        ];

        if ( !empty( $this->paymentSettings['ihc_stripe_checkout_v2_use_user_email'] ) ){
            $sessionData['customer_email'] = $this->paymentOutputData['customer_email'];
        }

        $session = \Stripe\Checkout\Session::create( $sessionData );

        /// save payment intent
        $this->paymentIntent = isset( $session->payment_intent ) ? $session->payment_intent : '';
        $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
        $orderMeta->save( $this->paymentOutputData['order_id'], 'order_identificator', $this->paymentIntent );

        return isset( $session->id ) ? $session->id : 0;
    }

    /**
     * @param none
     * @return string
     */
    private function getSessionIdForRecurringPayment()
    {
        $ihcPlanCode = $this->paymentOutputData['uid'] . '_' . $this->paymentOutputData['lid'] . '_' . indeed_get_unixtimestamp_with_timezone();
        $plan = array(
            "amount"          => $this->paymentOutputData['amount'],
            "interval_count"  => $this->paymentOutputData['interval_value'],
            "interval"        => $this->paymentOutputData['interval_type'],
            "product"         => array(
                                  "name"    => $this->paymentOutputData['level_label'],
                                  'type'    => 'service',
            ),
            "currency"        => $this->paymentOutputData['currency'],
            "id"              => $ihcPlanCode,
        );

        $return_data_plan = \Stripe\Plan::create( $plan );

        $sessionAttributes = [
            'payment_method_types'      => ['card'],
            'subscription_data'         => [
              "items"                   => [[
                  'plan'        => $ihcPlanCode, /// ID of plan
                  'quantity'    => 1,
              ]],
              'metadata'                => [
                          'uid'                 => $this->paymentOutputData['uid'],
                          'lid'                 => $this->paymentOutputData['lid'],
                          'order_id'            => $this->paymentOutputData['order_id'],
                          'order_identificator' => $this->paymentOutputData['order_identificator'],
              ]
            ],
            'client_reference_id'       => $this->paymentOutputData['order_id'], // {uid}_{lid}
            'success_url'               => $this->returnUrlAfterPayment,
            'cancel_url'                => $this->cancelUrlAfterPayment,
            'locale'                    => $this->locale,
        ];


        if ( !empty( $this->paymentOutputData['first_amount'] ) ) {
            $sessionAttributes['line_items'][] = [
                    "name"        => __('Initial payment', 'ihc'),
                    "description" => __('Initial payment', 'ihc'),
                    "amount"      => ($this->paymentOutputData['first_amount'] * $this->multiply),
                    "currency"    => $this->paymentOutputData['currency'],
                    "quantity"    => 1,
            ];
        }

        if ( isset( $this->paymentOutputData['first_payment_interval_value'] ) ){
            $sessionAttributes['subscription_data']['trial_period_days'] = $this->paymentOutputData['first_payment_interval_value'];
        }

        if ( !empty( $this->paymentSettings['ihc_stripe_checkout_v2_use_user_email'] ) ){
            $sessionAttributes['customer_email'] = $this->paymentOutputData['customer_email'];
        }

        $session = \Stripe\Checkout\Session::create( $sessionAttributes );

        return isset( $session->id ) ? $session->id : 0;
    }

    private function setLocale()
    {
        $this->locale = $this->paymentSettings['ihc_stripe_checkout_v2_locale_code'];
        $currentLocale = indeed_get_current_language_code();
        if ( $currentLocale && $this->locale!=$currentLocale ){
            $this->locale = $currentLocale;
        }
        if ( empty( $this->locale ) ){
            $this->locale = 'auto';
        }
    }

    /**
     * @param none
     * @return none
     */
    public function webhook()
    {
        include IHC_PATH . 'classes/gateways/libraries/stripe-checkout/vendor/autoload.php';
        // process the data from payment gateway, ussualy comes on $_POST variables.
        $timestamp = indeed_get_unixtimestamp_with_timezone();
        $response = @file_get_contents( 'php://input' );
        $responseData = json_decode( $response, true );

        if ( empty( $responseData ) ){
          echo '============= Ultimate Membership Pro - Stripe Checkout IPN ============= ';
          echo '<br/><br/>No Payments details sent. Come later';
          exit;
        }

        $currency = isset( $responseData['data']['object']['currency'] ) ? $responseData['data']['object']['currency'] : '';
        $this->multiply = ihcStripeMultiplyForCurrency( $currency );

        if ( !isset( $responseData['type'] ) ){
            return;
        }

        switch ( $responseData['type'] ){
            case 'charge.succeeded':
              /// Single Payment
              $transactionId = isset($responseData['data']['object']['payment_intent']) ? $responseData['data']['object']['payment_intent'] : false;
              $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
              $orderId = $orderMeta->getIdFromMetaNameMetaValue( 'order_identificator', $transactionId );
              if ( $orderId == false ){
                  // out
                  $this->webhookData['payment_status'] = 'other';
                  break;
              }
              $orderObject = new \Indeed\Ihc\Db\Orders();
              $orderData = $orderObject->setId( $orderId )
                                       ->fetch()
                                       ->get();

              $amount = isset( $responseData['data']['object']['amount'] ) ? $responseData['data']['object']['amount'] : 0;
              if ( $amount > 0 ){
                  $amount = $amount / $this->multiply;
              }
              $orderIdentificator = $transactionId;
              $this->webhookData = [
                                      'transaction_id'              => $transactionId,
                                      'uid'                         => isset( $orderData->uid ) ? $orderData->uid : 0,
                                      'lid'                         => isset( $orderData->lid ) ? $orderData->lid : 0,
                                      'order_identificator'         => $orderIdentificator,
                                      'amount'                      => $amount,
                                      'currency'                    => $currency,
                                      'payment_details'             => $responseData,
                                      'payment_status'              => 'completed',
              ];
              break;

			//case 'invoice.payment_succeeded':  PREVIOUS STRIPE API VERSION
			case 'invoice.paid':
              // Recurring payment
              $subscriptionId = isset( $responseData['data']['object']['subscription'] ) ? $responseData['data']['object']['subscription'] : '';
              $amount = isset( $responseData['data']['object']['amount_paid'] ) ? $responseData['data']['object']['amount_paid'] : 0;
              if ( $amount > 0 ){
                  $amount = $amount / $this->multiply;
              }

              $transactionId = isset($responseData['data']['object']['payment_intent']) ? $responseData['data']['object']['payment_intent'] : false;
              if ( $transactionId === false ){
                  // is free trial
                  $transactionId = isset($responseData['data']['object']['id']) ? $responseData['data']['object']['id'] : false;
              }

              $metaData = isset( $responseData['data']['object']['lines']['data'][0]['metadata'] ) ? $responseData['data']['object']['lines']['data'][0]['metadata'] : '';
              if ( empty( $metaData ) ){
                  $metaData = isset( $responseData['data']['object']['lines']['data'][1]['metadata'] ) ? $responseData['data']['object']['lines']['data'][1]['metadata'] : '';
              }
              $orderIdentificator =  isset( $metaData['order_identificator'] ) ? $metaData['order_identificator'] : '';

              $this->webhookData = [
                                          'transaction_id'              => $transactionId,
                                          'uid'                         => isset( $metaData['uid'] ) ? $metaData['uid'] : 0,
                                          'lid'                         => isset( $metaData['lid'] ) ? $metaData['lid'] : 0,
                                          'order_identificator'         => $orderIdentificator,
                                          'subscription_id'             => isset( $subscriptionId ) ? $subscriptionId : '',
                                          'amount'                      => $amount,
                                          'currency'                    => $currency,
                                          'payment_details'             => $responseData,
                                          'payment_status'              => 'completed',
              ];
              break;

            case 'charge.refunded':
              /// REFUND
              $transactionId = isset($responseData['data']['object']['payment_intent']) ? $responseData['data']['object']['payment_intent'] : false;
              $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
              $orderId = $orderMeta->getIdFromMetaNameMetaValue( 'order_identificator', $transactionId );
              if ( $orderId == false ){
                  // out
                  $this->webhookData['payment_status'] = 'other';
                  break;
              }
              $orderObject = new \Indeed\Ihc\Db\Orders();
              $orderData = $orderObject->setId( $orderId )
                                       ->fetch()
                                       ->get();

              $orderIdentificator = $transactionId;
              $this->webhookData = [
                                      'transaction_id'              => $transactionId,
                                      'uid'                         => isset( $orderData->uid ) ? $orderData->uid : 0,
                                      'lid'                         => isset( $orderData->lid ) ? $orderData->lid : 0,
                                      'order_identificator'         => $orderIdentificator,
                                      'amount'                      => '',
                                      'currency'                    => '',
                                      'payment_details'             => $responseData,
                                      'payment_status'              => 'refund',
              ];
              break;
            case 'charge.dispute.funds_withdrawn':
              /// make level expired - failed
              $transactionId = isset($responseData['data']['object']['payment_intent']) ? $responseData['data']['object']['payment_intent'] : false;
              $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
              $orderId = $orderMeta->getIdFromMetaNameMetaValue( 'order_identificator', $transactionId );
              if ( $orderId == false ){
                  // out
                  $this->webhookData['payment_status'] = 'other';
                  break;
              }
              $orderObject = new \Indeed\Ihc\Db\Orders();
              $orderData = $orderObject->setId( $orderId )
                                       ->fetch()
                                       ->get();

              $orderIdentificator = $transactionId;
              $this->webhookData = [
                                      'transaction_id'              => $transactionId,
                                      'uid'                         => isset( $orderData->uid ) ? $orderData->uid : 0,
                                      'lid'                         => isset( $orderData->lid ) ? $orderData->lid : 0,
                                      'order_identificator'         => $orderIdentificator,
                                      'amount'                      => '',
                                      'currency'                    => '',
                                      'payment_details'             => $responseData,
                                      'payment_status'              => 'failed',
              ];
              break;
            case 'subscription_schedule.canceled':
              // CANCEL
              $subscriptionId = isset( $responseData['data']['object']['subscription'] ) ? $responseData['data']['object']['subscription'] : '';

              $transactionId = isset($responseData['data']['object']['payment_intent']) ? $responseData['data']['object']['payment_intent'] : false;
              if ( $transactionId === false ){
                  // is free trial
                  $transactionId = isset($responseData['data']['object']['id']) ? $responseData['data']['object']['id'] : false;
              }

              $metaData = isset( $responseData['data']['object']['lines']['data'][0]['metadata'] ) ? $responseData['data']['object']['lines']['data'][0]['metadata'] : '';
              if ( empty( $metaData ) ){
                  $metaData = isset( $responseData['data']['object']['lines']['data'][1]['metadata'] ) ? $responseData['data']['object']['lines']['data'][1]['metadata'] : '';
              }
              $orderIdentificator =  isset( $metaData['order_identificator'] ) ? $metaData['order_identificator'] : '';

              $this->webhookData = [
                                          'transaction_id'              => $transactionId,
                                          'uid'                         => isset( $metaData['uid'] ) ? $metaData['uid'] : 0,
                                          'lid'                         => isset( $metaData['lid'] ) ? $metaData['lid'] : 0,
                                          'order_identificator'         => $orderIdentificator,
                                          'subscription_id'             => isset( $subscriptionId ) ? $subscriptionId : '',
                                          'amount'                      => '',
                                          'currency'                    => '',
                                          'payment_details'             => $responseData,
                                          'payment_status'              => 'cancel',
              ];
              break;
            default:
              $this->webhookData['payment_status'] = 'other';
              break;
        }

        // after you create this array, the system will automatically know what to do.
    }

    /**
     * @param int
     * @param int
     * @return none
     */
    public function afterRefund( $uid=0, $lid=0 )
    {

    }

    /**
     * @param int
     * @param int
     * @param string
     * @return none
     */
    public function cancel( $uid=0, $lid=0, $transactionId='' )
    {
        include IHC_PATH . 'classes/gateways/libraries/stripe-checkout/vendor/autoload.php';

      if ( !$transactionId ){
          return false;
      }
      if ( empty( $this->paymentSettings['ihc_stripe_checkout_v2_secret_key'] ) ){
          return false;
      }

      \Stripe\Stripe::setApiKey( $this->paymentSettings['ihc_stripe_checkout_v2_secret_key'] );

      // try to get subscription_id from order meta ( new workflow )
      $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
      $orderId = $orderMeta->getIdFromMetaNameMetaValue( 'transaction_id', $transactionId );
      if ( $orderId ){
          $subscriptionId = $orderMeta->get( $orderId, 'subscription_id' );
      }
      if ( isset( $subscriptionId ) && $subscriptionId !== '' ){
        $subscription = \Stripe\Subscription::retrieve( $subscriptionId );
        try {
        		@$value = $subscription->cancel();
        } catch (Stripe\Error\InvalidRequest $e){
        		$value = false;
        }
        return $value;
      }

      $orderId = \Ihc_Db::getLastOrderByTxnId( $transactionId );
      $orderMetas = new \Indeed\Ihc\Db\OrderMeta();
      $chargeId = $orderMetas->get( $orderId, 'charge_id' );
      $lid = \Ihc_Db::getLidByOrder( $orderId );

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

      $subscription = \Stripe\Subscription::retrieve( $subscriptionId );

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
