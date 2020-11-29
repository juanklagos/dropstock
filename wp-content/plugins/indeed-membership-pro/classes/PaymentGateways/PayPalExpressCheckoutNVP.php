<?php
namespace Indeed\Ihc\PaymentGateways;
/*
Created v.7.4
Deprecated starting with v.9.3
*/
class PayPalExpressCheckoutNVP
{
    private $user			                    = '';
  	private $password		                  = '';
  	private $signature 		                = '';
  	private $sandbox		                  = 0;
  	private $returnUrl 		                = '';
  	private $cancelUrl		                = '';
  	private $token			                  = '';
  	private $payerId		                  = '';
  	private $isAuthorized	                = false;
    private $endpoint                     = '';
    private $siteUrl                      = '';
    private $currency                     = '';
    private $standardDescription          = 'SignUp Subscription';

    public function __construct()
    {
        $this->siteUrl = site_url();
        $this->siteUrl = trailingslashit($this->siteUrl);

        $this->returnUrl	= $this->siteUrl . '?ihc_action=paypal_express_complete_payment';
        $this->cancelUrl	= $this->siteUrl . '?ihc_action=paypal_express_cancel_payment';
        $this->user			  = get_option('ihc_paypal_express_checkout_user');
        $this->password		= get_option('ihc_paypal_express_checkout_password');
        $this->signature	= get_option('ihc_paypal_express_checkout_signature');
        $this->sandbox		= get_option('ihc_paypal_express_checkout_sandbox');
        $this->currency   = get_option('ihc_currency');

        if ($this->sandbox){
            $this->endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
        } else {
            $this->endpoint = 'https://api-3t.paypal.com/nvp';
        }
    }

    private function sendRequest($body='')
    {
        try {
            $response = wp_remote_post($this->endpoint, array(
                'timeout' 				=> 60,
                'sslverify' 			=> FALSE,
                'httpversion' 		=> '1.1',
                'body' 					  => $body,
              )
            );
            parse_str(wp_remote_retrieve_body($response), $bodyResponse);
            return $bodyResponse;
        } catch (Exception $e){
            return false;
        }
    }

    public function getAuthorizeURL()
    {
        if (!$this->token){
            return false;
        }
        if ($this->sandbox){
            return 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->token;
        } else {
            return 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $this->token;
        }
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setRecurringPayment($description='')
  	{
    		/// Recurring - STEP 1
        if (empty($description)){
            $description = $this->standardDescription;
        }
    		$body = array(
    			'USER' 								              => $this->user,
    			'PWD'								                => $this->password,
    			'SIGNATURE'							            => $this->signature,
    			'METHOD'							              => 'SetExpressCheckout',
    			'VERSION'							              => 86,
    			'L_BILLINGTYPE0'					          => 'RecurringPayments',
    			'L_BILLINGAGREEMENTDESCRIPTION0'	  => $description,
    			'cancelUrl'							            => $this->cancelUrl,
    			'returnUrl'							            => $this->returnUrl,
    		);
    		$response = $this->sendRequest($body);
        if (!isset($response['TOKEN'])){
            return $this;
        }
        $this->token = $response['TOKEN'];
        return $this;
  	}

    public function setSinglePayment($amount=0)
    {
        /// Single Payment - STEP 1
        $this->returnUrl	= $this->siteUrl . '?ihc_action=paypal_express_single_payment_complete_payment';
        $this->cancelUrl	= $this->siteUrl . '?ihc_action=paypal_express_single_payment_cancel_payment';
        $body = array(
          'USER' 								              => $this->user,
          'PWD'								                => $this->password,
          'SIGNATURE'							            => $this->signature,
          'METHOD'							              => 'SetExpressCheckout',
          'VERSION'							              => 93,
          'PAYMENTREQUEST_0_PAYMENTACTION'	  => 'SALE',
          'PAYMENTREQUEST_0_AMT'	            => $amount,
          'PAYMENTREQUEST_0_CURRENCYCODE'     => $this->currency,
          'cancelUrl'							            => $this->cancelUrl,
          'returnUrl'							            => $this->returnUrl,
          //'INITAMT'                           => 12,
        );
        $response = $this->sendRequest($body);
        if (!isset($response['TOKEN'])){
            return $this;
        }
        $this->token = $response['TOKEN'];

        $tokenObject = new \Indeed\Ihc\PaymentGateways\PayPalExpressCheckoutHandleTemporaryTokens();
        $tokenObject->save($this->token);
        return $this;
    }

    public function completeSinglePayment()
    {
        /// Single Payment - Step 2
        if (empty($_GET['token']) || empty($_GET['PayerID'])){
            return $this;
        }
        $this->token = esc_sql($_GET['token']);
        $this->payerId = esc_sql($_GET['PayerID']);

        $tokenObject = new \Indeed\Ihc\PaymentGateways\PayPalExpressCheckoutHandleTemporaryTokens();
        if (!$tokenObject->exists($this->token)){
            return $this;
        }
        $tokenObject->remove($this->token);

        $paymentData = \Ihc_Db::PayPalExpressCheckoutGetPaymentDataByToken($this->token);
        if (empty($paymentData)){
            return $this;
        }
        $body = array(
            'USER' 								              => $this->user,
            'PWD'								                => $this->password,
            'SIGNATURE'							            => $this->signature,
            'METHOD'							              => 'DoExpressCheckoutPayment',
            'VERSION'							              => 93,
            'TOKEN'                             => $this->token,
            'PAYERID'                           => $this->payerId,
            'PAYMENTREQUEST_0_PAYMENTACTION'	  => 'SALE',
            'PAYMENTREQUEST_0_AMT'	            => $paymentData['amount'],
            'PAYMENTREQUEST_0_CURRENCYCODE'     => $paymentData['currency'],
        );
        $response = $this->sendRequest($body);

        if (empty($response['PAYMENTINFO_0_TRANSACTIONID'])){
            return $this;
        }
        \Ihc_Db::changeTxnId($this->token, $response['PAYMENTINFO_0_TRANSACTIONID']);
        return $this;
    }

  	public function confirmAuthorization()
  	{
    		/// Recurring Payment - STEP 2
    		if (!empty($_GET['token'])){
    			$this->isAuthorized = true;
          $this->token        = esc_sql($_GET['token']);
    		}
    		return $this;
  	}

  	public function getExpressCheckoutDetails()
  	{
    		/// Recurring Payment - SETP 3
    		if (empty($this->isAuthorized)){
    			return $this;
    		}
    		$body = array(
    			'USER' 			   => $this->user,
    			'PWD'			     => $this->password,
    			'SIGNATURE'		 => $this->signature,
    			'METHOD'		   => 'GetExpressCheckoutDetails',
    			'VERSION'		   => 86,
    			'TOKEN'			   => $this->token,
    		);

    		$response = $this->sendRequest($body);
    		$this->token         = $response['TOKEN'];
        $this->payerId       = $response['PAYERID'];
        return $this;
  	}

  	public function createRecurringProfile()
  	{
    		/// Recurring Payment - STEP 4
    		if (empty($this->isAuthorized)){
    			return $this;
    		}
    		if (!$this->token || !$this->payerId){
    			return $this;
    		}
        $paymentData = \Ihc_Db::PayPalExpressCheckoutGetPaymentDataByToken($this->token);
        if (empty($paymentData)){
            return $this;
        }
        if (empty($paymentData['description'])){
            $paymentData['description'] = $this->standardDescription;
        }

        $body = array(
    			'USER' 				          => $this->user,
    			'PWD'				            => $this->password,
    			'SIGNATURE'			        => $this->signature,
    			'METHOD'			          => 'CreateRecurringPaymentsProfile',
    			'VERSION'			          => 86,
    			'TOKEN'				          => $this->token,
    			'PAYERID'			          => $this->payerId,
    			'PROFILESTARTDATE'	    => date('Y-m-d H:i:s'),
    			'DESC'				          => $paymentData['description'],
    			'BILLINGPERIOD' 	      => $paymentData['intervalType'],
    			'BILLINGFREQUENCY'	    => $paymentData['intervalValue'],
          'TOTALBILLINGCYCLES'    => $paymentData['recurringLimit'],
    			'AMT'				            => $paymentData['amount'],
    			'CURRENCYCODE' 		      => $this->currency,
    			'COUNTRYCODE' 		      => $paymentData['countryCode'],
    			'MAXFAILEDPAYMENTS'	    => 2,
          /// 'TRIALBILLINGPERIOD'    => '',
          /// 'TRIALBILLINGFREQUENCY'   => '',
          /// 'TRIALTOTALBILLINGCYCLES' => '',
          /// 'TRIALAMT'                => '',
    		);

        if (!empty($paymentData['access_trial_time_value'])){
            $body['TRIALBILLINGFREQUENCY'] = $paymentData['access_trial_time_value'];
            if (isset($paymentData['access_trial_type'])){
                $body['TRIALBILLINGPERIOD'] = $paymentData['access_trial_type'];
            }
            if (isset($paymentData['access_trial_couple_cycles'])){
                $body['TRIALTOTALBILLINGCYCLES'] = $paymentData['access_trial_couple_cycles'];
            } else {
                $body['TRIALTOTALBILLINGCYCLES'] = 1;
            }
            if (isset($paymentData['access_trial_price'])){
                $body['TRIALAMT'] = $paymentData['access_trial_price'];
            }
        }

    		$response = $this->sendRequest($body);


        \Ihc_Db::changeTxnId($this->token, $response['PROFILEID']);

        // $this->makeLevelActiveOnFreeTrial( $paymentData, $response );

        return $this;
  	}

    private function makeLevelActiveOnFreeTrial( $paymentData=array(), $responseFromPayPal=array() )
    {
        if ( !isset($responseFromPayPal['PROFILESTATUS']) || $responseFromPayPal['PROFILESTATUS']!='ActiveProfile' ){
            return;
        }
        if ( empty($paymentData['access_trial_time_value']) || (isset($paymentData['access_trial_price']) && $paymentData['access_trial_price']>0) ){
            return;
        }
        if ( empty($responseFromPayPal['PROFILEID']) ){
            return;
        }
        $userLevelDetails = \Ihc_Db::getUidLidByTxnId($responseFromPayPal['PROFILEID']);
        if ( !$userLevelDetails ){
            return;
        }
        $levelData = ihc_get_level_by_id($userLevelDetails['lid']);
        \Ihc_User_Logs::write_log( __("PayPal Payment IPN: Update user level expire time.", 'ihc'), 'payments');
        ihc_update_user_level_expire($levelData, $userLevelDetails['lid'], $userLevelDetails['uid']);
        ihc_send_user_notifications($userLevelDetails['uid'], 'payment', $userLevelDetails['lid']);//send notification to user
        ihc_send_user_notifications($userLevelDetails['uid'], 'admin_user_payment', $userLevelDetails['lid']);//send notification to admin
        ihc_switch_role_for_user($userLevelDetails['uid']);
        ihc_insert_update_transaction($userLevelDetails['uid'], $responseFromPayPal['PROFILEID'], $paymentData);
    }

    public function redirectHome()
    {
        wp_redirect( $this->siteUrl, 302 );
        exit;
    }
}
