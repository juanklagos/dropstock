<?php
namespace Indeed\Ihc\PaymentGateways;
/*
Created v.7.4
Deprecated starting with v.9.3
*/
class Mollie extends \Indeed\Ihc\PaymentGateways\PaymentAbstract
{
    protected $attributes       = array();
    protected $redirectUrl      = '';
    protected $abort            = false;
    protected $paymentTypeLabel = 'Mollie Payment';
    protected $currency         = '';

    /**
     * @param none
     * @return none
     */
    public function __construct()
    {
        include_once IHC_PATH . 'classes/PaymentGateways/mollie/vendor/autoload.php';
        $this->currency = get_option('ihc_currency');
    }

    /**
     * @param none
     * @return none
     */
  	public function doPayment()
    {
        \Ihc_User_Logs::set_user_id(@$this->attributes['uid']);
        \Ihc_User_Logs::set_level_id(@$this->attributes['lid']);
        \Ihc_User_Logs::write_log( __('Mollie Payment: Start process', 'ihc'), 'payments');

        $settings = ihc_return_meta_arr('payment_mollie');
        $mollie = new \Mollie\Api\MollieApiClient();

        try {
            $mollie->setApiKey($settings['ihc_mollie_api_key']);
        } catch ( \Mollie\Api\Exceptions\ApiException $e ){
            return $this;
        }

        $levels = get_option('ihc_levels');
        $levelData = $levels[$this->attributes['lid']];

        $siteUrl = site_url();
        $siteUrl = trailingslashit($siteUrl);
        $webhook = add_query_arg('ihc_action', 'mollie', $siteUrl);
        $redirectUrl = get_option( 'ihc_mollie_return_page' );
        $redirectUrl = get_permalink( $redirectUrl );
        if( !$redirectUrl || $redirectUrl == -1 ){
          $redirectUrl = $siteUrl;
        }
        $amount = $levelData['price'];

        $reccurrence = FALSE;
    		if (isset($levelData['access_type']) && $levelData['access_type']=='regular_period'){
    			$reccurrence = TRUE;
    			\Ihc_User_Logs::write_log( __('Mollie Payment: Recurrence payment set.', 'ihc'), 'payments');
    		}
    		$couponData = array();
    		if (!empty($this->attributes['ihc_coupon'])){
    			$couponData = ihc_check_coupon($this->attributes['ihc_coupon'], $this->attributes['lid']);
    			\Ihc_User_Logs::write_log( __('Mollie Payment: the user used the following coupon: ', 'ihc') . $this->attributes['ihc_coupon'], 'payments');
    		}

        if ($reccurrence){

            /// RECCURING
            /********************************* COUPON *****************************/
            if ($couponData){
                if ( empty( $couponData['reccuring'] ) ){
                    $firstPaymentAmount = ihc_coupon_return_price_after_decrease($levelData['price'], $couponData, true, $this->attributes['uid'], $this->attributes['lid']);
                } else {
                    //everytime the price will be reduced
                    $levelData['price'] = ihc_coupon_return_price_after_decrease($levelData['price'], $couponData, true, $this->attributes['uid'], $this->attributes['lid']);
                }
            }
            /********************************* end of COUPON *****************************/

            $amount = $levelData['price'];
            \Ihc_User_Logs::write_log( __('Mollie Payment: amount set @ ', 'ihc') . $amount . $this->currency, 'payments');

            if ($levelData['billing_type']=='bl_ongoing'){
              $recurringLimit = '';
            } else {
              if (isset($levelData['billing_limit_num']) && $levelData['billing_limit_num']!='' ){
                $recurringLimit = (int)$levelData['billing_limit_num'];
              } else {
                $recurringLimit = '';
              }
            }
            $interval = $levelData['access_regular_time_value'];
            switch ($levelData['access_regular_time_type']){
              case 'D':
                if ( $interval > 365 ){
                    $interval = 365;
                }
                $interval .= ' days';
                break;
              case 'W':
                if ( $interval > 52 ){
                    $interval = 52;
                }
                $interval .= ' weeks';
                break;
              case 'M':
                if ( $interval > 12 ){
                    $interval = 12;
                }
                $interval .= ' months';
                break;
              case 'Y':
                $interval = '12 months';
                break;
            }
            \Ihc_User_Logs::write_log( __('Mollie Payment: recurrence number: ', 'ihc') . $recurringLimit, 'payments');

            /*************************** DYNAMIC PRICE ***************************/
            if (ihc_is_magic_feat_active('level_dynamic_price') && isset($this->attributes['ihc_dynamic_price'])){
                $temp_amount = $this->attributes['ihc_dynamic_price'];
                if (ihc_check_dynamic_price_from_user($this->attributes['lid'], $temp_amount)){
                    $amount = $temp_amount;
                    \Ihc_User_Logs::write_log( __('Mollie Payment: Dynamic price on - Amount is set by the user @ ', 'ihc') . $amount . $this->currency, 'payments');
                }
            }
            /**************************** end of DYNAMIC PRICE ***************************/

            $start_time = date( 'Y-m-d' );

            /********************************* TRIAL *****************************/
            $trialData = $this->checkTrial( $levelData );
            if ( isset( $trialData['startTime'] ) ){
                $start_time = $trialData['startTime'];
            }
            if ( isset( $trialData['startAmount'] ) ){
                 $firstPaymentAmount = $trialData['startAmount'];
            }
            /********************************* end of TRIAL *****************************/

            /// TAXES
            $amount = $this->addTaxes( $amount );
			      $amount = number_format( (float)$amount, 2, '.', '' );

            // Create customer.
            $customer = $mollie->customers->create([
                "name"    => \Ihc_Db::getUserFulltName($this->attributes['uid']),
                "email"   => \Ihc_Db::user_get_email($this->attributes['uid']),
            ]);

            // Setting up the first payment.
            if ( $amount == 0.00 ){
                return $this;
            }
            $paymentParams = [
                "amount"          => [
                                    "currency" => $this->currency,
                                    "value"    => $amount,
                ],
                "description"     => __('Buy ', 'ihc') . $levelData['label'],
                "redirectUrl"     => $redirectUrl,
                "webhookUrl"      => $webhook,
                "metadata"        => [
                                    "order_id" => @$this->attributes['orderId'],
                ],
                "sequenceType"    => \Mollie\Api\Types\SequenceType::SEQUENCETYPE_FIRST,
            ];
            if ( isset( $firstPaymentAmount ) ){
                $paymentParams['amount']['value'] = $this->addTaxes( $firstPaymentAmount );
                $paymentParams['amount']['value'] = number_format( (float)$paymentParams['amount']['value'], 2, '.', '' );
                $paymentParams['description'] = __('Buy ', 'ihc') . $levelData['label']
                                                . __( '. For trial period you pay: ', 'ihc' )
                                                . $paymentParams['amount']['value'] . $this->currency
                                                . __( '. After trial period you will pay: ', 'ihc' )
                                                . $amount . $this->currency;
            }

            $payment = $customer->createPayment( $paymentParams );

            // prevent first payment on subscription. by default mollie will charge two times on same call.
            if ( $recurringLimit!='' && $recurringLimit > 1 ){
                $recurringLimit = $recurringLimit - 1;
            }
            if ( strpos( $interval, 's') !== false ){
                $temporaryInterval = str_replace( 's', '', $interval );
                $start_time = strtotime( $start_time );
                $start_time = strtotime( $temporaryInterval, $start_time );
                $start_time = date( 'Y-m-d', $start_time );
            }

            // Charging periodically with subscriptions
            $SubscriptionParams = [
                "amount"      => [
                    "currency"    => $this->currency,
                    "value"       => $amount,
                ],
                "startDate"   => $start_time,
				        "interval"    => $interval,
                "description" => __('Sign for ', 'ihc') . $levelData['label'].__(' subscription', 'ihc'),
                "webhookUrl"  => $webhook,
                "method"      => NULL,
            ];
            if ( $recurringLimit ){
                $SubscriptionParams['times'] = $recurringLimit;
            }
            $subscriptionObject = $customer->createSubscription( $SubscriptionParams );
            $subscriptionData = [
                'subscriptionId'    => $subscriptionObject->id,
                'customerId'        => $subscriptionObject->customerId,
            ];

            // save $subscriptionObject->id
            $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
            $orderMeta->save( $this->attributes['orderId'], 'subscription_id', $subscriptionObject->id  );

        } else {
            $amount = $levelData['price'];
            /// SINGLE payment_type
            if ($couponData){
      				$amount = ihc_coupon_return_price_after_decrease($amount, $couponData, true, $this->attributes['uid'], $this->attributes['lid']);
      			}

            /*************************** DYNAMIC PRICE ***************************/
            if (ihc_is_magic_feat_active('level_dynamic_price') && isset($this->attributes['ihc_dynamic_price'])){
              $temp_amount = $this->attributes['ihc_dynamic_price'];
              if (ihc_check_dynamic_price_from_user($this->attributes['lid'], $temp_amount)){
                $amount = $temp_amount;
                \Ihc_User_Logs::write_log( __('Mollie Payment: Dynamic price on - Amount is set by the user @ ', 'ihc') . $amount . $this->currency, 'payments');
              }
            }
            /**************************** DYNAMIC PRICE ***************************/

            /// TAXES
            $amount = $this->addTaxes( $amount );

            $amount = number_format((float)$amount, 2, '.', '');

            // Setting up the payment.
            $payment = $mollie->payments->create([
                "amount" => [
                    "currency"    => $this->currency,
                    "value"       => $amount,
                ],
                "description"     => __('Buy ', 'ihc') . $levelData['label'],
                "redirectUrl"     => $redirectUrl,
                "webhookUrl"      => $webhook,
				"method"		  => NULL,
                //"method"          => \Mollie\Api\Types\PaymentMethod::CREDITCARD,
            ]);
        }

        $paymentId = $payment->id;
        $this->redirectUrl = $payment->getCheckoutUrl();

        $transactionData = array(
                      'lid'                 => $this->attributes['lid'],
                      'uid'                 => $this->attributes['uid'],
                      'ihc_payment_type'    => 'mollie',
                      'amount'              => $amount,
                      'message'             => 'pending',
                      'currency'            => $this->currency,
                      'item_name'           => $levelData['name'],
        );
        if (!empty($subscriptionData)){
            $transactionData = $transactionData + $subscriptionData;
        }
        /// save the transaction without saving the order
        ihc_insert_update_transaction($this->attributes['uid'], $paymentId, $transactionData, true); /// will save the order too

        /// update indeed_members_payments table, add order id
        \Ihc_Db::updateTransactionAddOrderId($paymentId, @$this->attributes['orderId']);
        $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
        $orderMeta->save( $this->attributes['orderId'], 'transaction_id', $paymentId );

        return $this;
    }

    /**
     * @param array
     * @return array
     */
    private function checkTrial( $levelData=[] )
    {
        if ( empty( $levelData['access_trial_type'] ) || empty( $levelData['access_trial_price'] ) ){
            return [];
        }
        $trialPeriod = 0;
        if ($levelData['access_trial_type']==1 && isset($levelData['access_trial_time_value']) && $levelData['access_trial_time_value'] !=''){
            switch ($levelData['access_trial_time_type']){
              case 'D':
                $trialPeriod = $levelData['access_trial_time_value'];
                break;
              case 'W':
                $trialPeriod = $levelData['access_trial_time_value'] * 7;
                break;
              case 'M':
                $trialPeriod = $levelData['access_trial_time_value'] * 31;
                break;
              case 'Y':
                $trialPeriod = $levelData['access_trial_time_value'] * 365;
                break;
            }
        } else if ( $levelData['access_trial_type']==2 && isset($levelData['access_trial_couple_cycles'] ) && $levelData['access_trial_couple_cycles']!=''){
            switch ($levelData['access_regular_time_type']){
              case 'day':
                $trialPeriod = $levelData['access_regular_time_value'] * $levelData['access_trial_couple_cycles'];
                break;
              case 'week':
                $trialPeriod = $levelData['access_regular_time_value'] * $levelData['access_trial_couple_cycles'] * 7;
                break;
              case 'month':
                $trialPeriod = $levelData['access_regular_time_value'] * $levelData['access_trial_couple_cycles'] * 31;
                break;
              case 'year':
                $trialPeriod = $levelData['access_regular_time_value'] * $levelData['access_trial_couple_cycles'] * 365;
                break;
            }
        }
        if ( $trialPeriod <= 0 ){
            return [];
        }

        $startTime = date('Y-m-d', strtotime("+ " . $trialPeriod . " days"));
        \Ihc_User_Logs::write_log( __('Mollie Payment: Trial Time ends on ', 'ihc') . $trialPeriod, 'payments');
        return [
                  'startTime'     => $startTime,
                  'startAmount'   => $levelData['access_trial_price'],
        ];
    }

    /**
     * @param none
     * @return none
     */
    public function redirect()
    {
        if ( $this->redirectUrl ){
            // redirect to payment
            \Ihc_User_Logs::write_log( __('Mollie Payment: Request submited.', 'ihc'), 'payments');
            header( 'location:' . $this->redirectUrl );
            exit;
        } else {
            // redirect home ...
            \Ihc_User_Logs::write_log( __('Mollie Payment: Payment url to mollie is not available.', 'ihc'), 'payments');
            $url = get_option( 'home' );
            header( 'location:' . $url );
            exit;
        }
    }

    /**
     * @param none
     * @return bool
     */
    public function webhook()
    {
        $rand = rand( 0, 1000000);
		    \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Start Process.", 'ihc'), 'payments');

        $settings = ihc_return_meta_arr('payment_mollie');
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($settings['ihc_mollie_api_key']);
        $transactionId = esc_sql($_POST["id"]);
        \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Transaction id is: " . $transactionId, 'ihc'), 'payments');

        $payment = $mollie->payments->get( $transactionId );
        $paymentData = ihcGetTransactionDetails( $transactionId );
        \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Transaction data from mollie: " . serialize($payment), 'ihc'), 'payments');
        \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Payment data from database: " . serialize($paymentData), 'ihc'), 'payments');

        if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
            if ( empty( $payment->subscriptionId ) ){
                return $this->webhookSimplePayment( $transactionId, $payment );
            } else {
                return $this->webhookRecurringPayment( $payment->subscriptionId, $transactionId, $payment );
            }
        } elseif ($payment->isOpen()) {
        } elseif ($payment->isPending()) {
            /// pending
            ihc_delete_user_level_relation($paymentData['lid'], $paymentData['uid']);
        } elseif ($payment->isFailed()) {
            ihc_delete_user_level_relation($paymentData['lid'], $paymentData['uid']);
        } elseif ($payment->isExpired()) {
        } elseif ($payment->isCanceled()) {
            ihc_delete_user_level_relation($paymentData['lid'], $paymentData['uid']);
        } elseif ($payment->hasRefunds()) {
            ihc_delete_user_level_relation($paymentData['lid'], $paymentData['uid']);
        } elseif ($payment->hasChargebacks()) {}
    }

    /**
     * @param string
     * @param array
     * @return bool
     */
    private function webhookSimplePayment( $transactionId='', $paymentDataFromMollie=[] )
    {
        $paymentData = ihcGetTransactionDetails( $transactionId );
        if ( !$paymentData ){
            \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Stop process! No payment data for this transaction id.", 'ihc'), 'payments');
            return false;
        }
        $paymentData = $paymentData + $this->MollieObjectToArray( $paymentDataFromMollie );
        $paymentData['amount'] = isset( $paymentDataFromMollie->amount->value ) ? $paymentDataFromMollie->amount->value : 0;

        $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
        $orderId = $orderMeta->getIdFromMetaNameMetaValue( 'transaction_id', $transactionId );

        $orderObject = new \Indeed\Ihc\Db\Orders();
        $orderDetails = $orderObject->setId( $orderId )->fetch()->get();
        if ( !empty( $orderDetails->status ) && $orderDetails->status == 'Completed' ){
            \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Stop process! This transaction has already been saved.", 'ihc'), 'payments');
            return false;
        }

        $completed = $this->webhookMakeCompleted( $paymentData['uid'], $paymentData['lid'], $paymentData, $amountValue, $transactionId, $orderId );
        if ( $completed ){
            $order = new \Indeed\Ihc\Db\Orders();
            $order->setId( $orderId )->update( 'status', 'Completed' );
            \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Order completed!", 'ihc'), 'payments');
        }
    }

    /**
     * @param string
     * @param string
     * @param array
     * @return
     */
    private function webhookRecurringPayment( $subscriptionId='', $transactionId='', $paymentDataFromMollie=[] )
    {
        \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Start recurring payment.", 'ihc'), 'payments');
        $orderMeta = new \Indeed\Ihc\Db\OrderMeta();
        $firstOrderId = $orderMeta->getIdFromMetaNameMetaValue( 'subscription_id', $subscriptionId );
        if ( !$firstOrderId ){
            \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Stop process! No order for this subscription Id.", 'ihc'), 'payments');
            return false;
        }
        $orderObject = new \Indeed\Ihc\Db\Orders();
        $firstOrderDetails = $orderObject->setId( $firstOrderId )->fetch()->get();
        if ( !$firstOrderDetails ){
            \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Stop process! No data for this order.", 'ihc'), 'payments');
            return false;
        }
        $uid = isset( $firstOrderDetails->uid ) ? $firstOrderDetails->uid : 0;
        $lid = isset( $firstOrderDetails->lid ) ? $firstOrderDetails->lid : -1;

        $amount = isset( $paymentDataFromMollie->amount->value ) ? $paymentDataFromMollie->amount->value : 0;
        $currency = isset( $paymentDataFromMollie->amount->currency ) ? $paymentDataFromMollie->amount->currency : '';

        if ( !$uid || $lid==-1 ){
            \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Stop process! No user id or level id for this subscription Id.", 'ihc'), 'payments');
            return false;
        }

        $paymentData = $this->MollieObjectToArray( $paymentDataFromMollie );
        $paymentData['amount'] = $amount;
        $orderIdForTransaction = $orderMeta->getIdFromMetaNameMetaValue( 'transaction_id', $transactionId );
        if ( $orderIdForTransaction ){
            // check if is pending
            $orderDetails = $orderObject->setId( $orderIdForTransaction )->fetch()->get();
            if ( empty( $orderDetails->status ) || $orderDetails->status == 'Completed' ){
                // this transaction has been already marked as completed . so we out
                \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Stop process, this transaction has been already saved!", 'ihc'), 'payments');
                return false;
            } else {
                // update level access
                $orderId = $orderIdForTransaction;
                $completed = $this->webhookMakeCompleted( $uid, $lid, $paymentData, $amount, $transactionId, $orderId );
            }
        } else {
            // order id for this transaction does not eixsts
            $orderAttributes = [
                              'uid'             => $uid,
                              'lid'             => $lid,
                              'amount_type'     => $currency,
                              'amount'          => $amount,
                              'status'          => 'pending',
                              'payment_gateway' => 'mollie',
                              'extra_fields'    => '',
                              'ihc_coupon'      => '',
                              'ihc_state'       => get_user_meta( $uid, 'ihc_state', true ),
                              'ihc_country'     => get_user_meta( $uid, 'ihc_country', true ),
            ];
            // save the order
            $createOrder = new \Indeed\Ihc\CreateOrder( $orderAttributes, 'mollie' );
            $orderId = $createOrder->proceed()->getOrderId();
            \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Create new order for this transaction.", 'ihc'), 'payments');

            // save transaction id into meta order
            $orderMeta->save( $orderId, 'transaction_id', $transactionId );
            // save subscription id into meta order
            $orderMeta->save( $orderId, 'subscription_id', $subscriptionId );
            // make completed
            $completed = $this->webhookMakeCompleted( $uid, $lid, $paymentData, $amount, $transactionId, $orderId );
        }

        // make order completed
        if ( !empty( $completed ) ){
            $order = new \Indeed\Ihc\Db\Orders();
            $order->setId( $orderId )->update( 'status', 'Completed' );
            \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Order completed!", 'ihc'), 'payments');
        }
    }

    /**
     * @param int
     * @param int
     * @param array
     * @param mixed
     * @param string
     * @param int
     * @return bool
     */
    private function webhookMakeCompleted( $uid=0, $lid=0, $paymentData=[], $amountValue=0, $transactionId='', $orderId=0 )
    {
        /// update
        \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Update user level expire time.", 'ihc'), 'payments');
        $levelData = ihc_get_level_by_id( $lid );//getting details about current level
        ihc_update_user_level_expire( $levelData, $lid, $uid );
        ihc_switch_role_for_user( $uid );
        $paymentData['message'] = 'success';
        $paymentData['status'] = 'Completed';

        //Forcing for Trial with 0 amount.
        if ( isset($amountValue) && $amountValue == 0 ){
            $paymentData['amount'] = 0;
        }

        \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Payment completed.", 'ihc'), 'payments');

        $IndeedMembersPayments = new \Indeed\Ihc\Db\IndeedMembersPayments();
        $result = $IndeedMembersPayments->setTxnId( $transactionId )
                              ->setUid( $uid )
                              ->setPaymentData( $paymentData )
                              ->setHistory( $paymentData )
                              ->setOrders( $orderId )
                              ->save();
        \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Save transaction details.", 'ihc'), 'payments');

        //send notification to user
        ihc_send_user_notifications( $uid, 'payment', $lid );
        ihc_send_user_notifications( $uid, 'admin_user_payment', $lid );//send notification to admin
        \Ihc_User_Logs::write_log( __("Mollie Payment Webhook: Send notifications.", 'ihc'), 'payments');
        do_action( 'ihc_payment_completed', $uid, $lid );
        return $result;
    }

    /**
     * @param string
     * @return bool
     */
    public function cancelSubscription($transactionId='')
    {
        if (empty($transactionId)){
            return false;
        }
        $subscriptionData = \Ihc_Db::mollieGetSubscriptionDataByTransaction($transactionId);
        if (empty($subscriptionData) || empty($subscriptionData['customerId']) || empty($subscriptionData['subscriptionId'])){
            return false;
        }
        $settings = ihc_return_meta_arr('payment_mollie');
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($settings['ihc_mollie_api_key']);
        $customer = $mollie->customers->get($subscriptionData['customerId']);
        $canceledSubscription = $customer->cancelSubscription($subscriptionData['subscriptionId']);
        return $canceledSubscription;
    }

    /**
     * @param object
     * @return array
     */
    private function MollieObjectToArray( $object=null )
    {
        $array = (array)$object;
        $searchKey = [ 'settlementAmount', 'amountRefunded', 'amountRemaining', 'details' ];
        foreach ( $searchKey as $key ){
            if ( isset( $object->$key ) ){
                $array[$key] = (array)$object->$key;
            }
        }
        if ( isset( $object->$key ) ){
            $array['amount_object'] = (array)$object->amount;
        }
        return $array;
    }

}
