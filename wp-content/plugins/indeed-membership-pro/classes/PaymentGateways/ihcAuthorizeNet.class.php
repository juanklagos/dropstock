<?php
if(!class_exists('ihcAuthorizeNet')){
	class ihcAuthorizeNet{
		private $loginID = '';
		private $transactionKey = '';
		private $sandbox = 0;
		private $currency = 'USD';
		private $levels = array();
		private $response_return = array('code'=> 0, 'message' => '');
		private $amount_paid = 0;

		/////////
		public function __construct(){
			$this->loginID = get_option('ihc_authorize_login_id');
			$this->transactionKey = get_option('ihc_authorize_transaction_key');
			$this->currency = get_option('ihc_currency');
			$this->levels = get_option('ihc_levels');
			$this->sandbox = get_option('ihc_authorize_sandbox');
		}

		public function charge($data){

			//remove the Charge step
			return TRUE;

			$current_level = $this->levels[$data['lid']];
			$current_level = $this->convertUnit($current_level);
			if ($current_level['billing_type'] == 'bl_limited' && isset($current_level['billing_limit_num']) && $current_level['billing_limit_num'] > 0){
				$totalOccurrences = $current_level['billing_limit_num'];
			} else {
				$totalOccurrences = 9999;
			}

			Ihc_User_Logs::set_user_id(@$data['uid']);
			Ihc_User_Logs::set_level_id($data['lid']);
			Ihc_User_Logs::write_log( __('Authorize Payment: Start process', 'ihc'), 'payments');

			$amount = $current_level['price'];

			/*************************** DYNAMIC PRICE ***************************/
			if (ihc_is_magic_feat_active('level_dynamic_price') && isset($data['ihc_dynamic_price'])){
				$temp_amount = $data['ihc_dynamic_price'];
				if (ihc_check_dynamic_price_from_user($data['lid'], $temp_amount)){
					$amount = $temp_amount;
					Ihc_User_Logs::write_log( __('Authorize Payment: Dynamic price on - Amount is set by the user @ ', 'ihc') . $amount . $this->currency, 'payments');
				}
			}
			/**************************** DYNAMIC PRICE ***************************/

			//TRIAL?
			if (isset($current_level['access_trial_price']) && $current_level['access_trial_price']!=''
				&& isset($current_level['access_trial_couple_cycles']) && $current_level['access_trial_couple_cycles']!=''){
					$amount = $current_level['access_trial_price'];
					Ihc_User_Logs::write_log( __('Authorize Payment: Set trial price @ ', 'ihc') . $amount . $this->currency, 'payments');
			}
			//TRIAL

			/////coupon
			if (!empty($data['ihc_coupon'])){
				$coupon_data = ihc_check_coupon($data['ihc_coupon'], $data['lid']);
				$amount = ihc_coupon_return_price_after_decrease($amount, $coupon_data, TRUE, $data['uid'], $data['lid']);
				Ihc_User_Logs::write_log( __('Authorize Payment: the user used the following coupon:', 'ihc') . $data['ihc_coupon'], 'payments');
			}

			///TAXES
			$country = isset($data['ihc_country']) ? $data['ihc_country'] : '';
			$state = (isset($data['ihc_state'])) ? $data['ihc_state'] : '';
			$taxes_price = ihc_get_taxes_for_amount_by_country($country, $state, $amount);
			if ($taxes_price && !empty($taxes_price['total'])){
				$amount += $taxes_price['total'];
				Ihc_User_Logs::write_log( __('Authorize Payment: amount set @', 'ihc') . $amount . $this->currency, 'payments');
			}


			$post_values = array(
					"x_login"			=> $this->loginID,
					"x_tran_key"		=> $this->transactionKey,

					"x_version"					=> "3.1",
					"x_delim_data"			=> "TRUE",
					"x_delim_char"			=> "|",
					"x_relay_response"	=> "FALSE",

					'x_fp_timestamp'		=> indeed_get_unixtimestamp_with_timezone(),

					"x_type"			=> "AUTH_CAPTURE",
					"x_method"			=> "CC",
					"x_card_num"		=> $data['ihcpay_card_number'],
					"x_exp_date"		=> $data['ihcpay_card_expire'],

					"x_amount"			=> $amount,
					"x_tax" 			=> 0,
					"x_description"		=> "Level " . $current_level['label'],

					"x_first_name"		=> $data['ihcpay_first_name'],
					"x_last_name"		=> $data['ihcpay_last_name'],
					"x_address"			=> '',
					"x_city"			=> '',
					"x_state"			=> '',
					"x_zip"				=> '',
					"x_country"			=> '',
					"x_invoice_num"		=> '',
					"x_phone"			=> '',
					"x_email"			=> ''
			);

			$post_string = "";
			foreach ($post_values as $k=>$v){
				$post_string .= $k . "=" . urlencode(str_replace("#", "%23", $v)) . "&";
			}
			$post_string = rtrim( $post_string, "& " );
			if ($this->sandbox){
				$url = 'https://test.authorize.net/gateway/transact.dll';
				Ihc_User_Logs::write_log( __('Authorize Payment: sandbox mode set.', 'ihc'), 'payments');
			} else{
				$url = 'https://secure.authorize.net/gateway/transact.dll';
				Ihc_User_Logs::write_log( __('Authorize Payment: live mode set.', 'ihc'), 'payments');
			}

			Ihc_User_Logs::write_log( __('Authorize Payment: Init cURL.', 'ihc'), 'payments');
			$curl_req = curl_init($url);
			curl_setopt($curl_req, CURLOPT_HEADER, 0);
			if ($current_level['access_type']=='regular_period'){
				curl_setopt($curl_req, CURLOPT_RETURNTRANSFER, 1);
			} else {
				curl_setopt($curl_req, CURLOPT_RETURNTRANSFER, 0);
			}
			curl_setopt($curl_req, CURLOPT_POSTFIELDS, $post_string);
			curl_setopt($curl_req, CURLOPT_POST, 1); /// send via post
			curl_setopt($curl_req, CURLOPT_SSL_VERIFYPEER, FALSE);
			$response = curl_exec($curl_req);
			curl_close ($curl_req); // close curl object

			if (isset($response[0]) && $response[0] == 1){
				$this->amount_paid = $amount;
				Ihc_User_Logs::write_log( __('Authorize Payment: Payment made.', 'ihc'), 'payments');
				return TRUE;
			} else {
				Ihc_User_Logs::write_log( __('Authorize Payment: Error on curl action.', 'ihc'), 'payments');
				return FALSE;
			}
		}

		public function subscribe($data){
			if ($this->sandbox){
				$host = "https://apitest.authorize.net";
			} else {
				$host = 'https://api.authorize.net';
			}
			$url = $host . "/xml/v1/request.api";

			$current_level = $this->levels[$data['lid']];
			$current_level = $this->convertUnit($current_level);
			if ($current_level['billing_type'] == 'bl_limited' && isset($current_level['billing_limit_num']) && $current_level['billing_limit_num'] > 0){
				$totalOccurrences = $current_level['billing_limit_num'];
			} else {
				$totalOccurrences = 9999;
			}

			/////coupon
			if (!empty($data['ihc_coupon'])){
				$coupon_data = ihc_check_coupon($data['ihc_coupon'], $data['lid']);
				if (!empty($coupon_data['reccuring'])){
					//discount from every payment
					$current_level['price'] = ihc_coupon_return_price_after_decrease( $current_level['price'], $coupon_data, TRUE, $data['uid'], $data['lid']);
				} else {
					//discount just on this payment

				}
			}

			//TRIAL
			if (isset($current_level['access_trial_price']) && $current_level['access_trial_price']!=''
				&& isset($current_level['access_trial_couple_cycles']) && $current_level['access_trial_couple_cycles']!=''){
				$totalOccurrences = $totalOccurrences + $current_level['access_trial_couple_cycles'];
			}
			//TRIAL

			$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
			"<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
			"<merchantAuthentication>".
			"<name>" . $this->loginID . "</name>".
			"<transactionKey>" . $this->transactionKey . "</transactionKey>".
			"</merchantAuthentication>".
			"<refId>" . 'ihc_' . rand( 0, 100 ) . time() . "</refId>".
			"<subscription>".
			"<name>" . $current_level['label'] . "</name>".
			"<paymentSchedule>".
			"<interval>".
			"<length>".  $current_level['access_regular_time_value'] ."</length>".
			"<unit>". $current_level['access_regular_time_type'] ."</unit>".
			"</interval>".
			"<startDate>" . date("Y-m-d") . "</startDate>". //
			"<totalOccurrences>". $totalOccurrences . "</totalOccurrences>";

			//TRIAL
			if (isset($current_level['access_trial_price']) && $current_level['access_trial_price']!=''
				&& isset($current_level['access_trial_couple_cycles']) && $current_level['access_trial_couple_cycles']!=''){
				$content .= "<trialOccurrences>" . $current_level['access_trial_couple_cycles'] . "</trialOccurrences>";
			}
			//TRIAL

			$amount = $current_level['price'];

			$content .= "</paymentSchedule>".
			"<amount>" . urlencode($amount) . "</amount>";

			//TRIAL
			if (isset($current_level['access_trial_price']) && $current_level['access_trial_price']!=''
				&& isset($current_level['access_trial_couple_cycles']) && $current_level['access_trial_couple_cycles']!=''){
				$content .= "<trialAmount>" . urlencode($current_level['access_trial_price']) . "</trialAmount>";
				$amount = $current_level['access_trial_price'];
			}
			//TRIAL

			///TAXES
			$country = isset($data['ihc_country']) ? $data['ihc_country'] : '';
 			$state = (isset($data['ihc_state'])) ? $data['ihc_state'] : '';
			$taxes_price = ihc_get_taxes_for_amount_by_country($country, $state, $amount);
			if ($taxes_price && !empty($taxes_price['total'])){
				$amount += $taxes_price['total'];
			}

			$content .= "<payment>".
			"<creditCard>".
			"<cardNumber>" . $data['ihcpay_card_number'] . "</cardNumber>".
			"<expirationDate>" . $data['ihcpay_card_expire']  . "</expirationDate>".
			"</creditCard>".
			"</payment>".
			"<billTo>".
			"<firstName>". $data['ihcpay_first_name'] . "</firstName>".
			"<lastName>" . $data['ihcpay_last_name'] . "</lastName>".
			"<address></address>".
			"<city></city>".
			"<state></state>".
			"<zip></zip>".
			"<country></country>".
			"</billTo>".
			"</subscription>".
			"</ARBCreateSubscriptionRequest>";//'2015-09-04'

			//return $content;
			//send the xml via curl
			$response = $this->send_request_via_curl($content, $url);

			///

			if (!empty($response)) {
				list ($refId, $resultCode, $code, $text, $subscriptionId) = $this->parse_return($response);
				if($resultCode == "Ok"){
					$this->response_return['code'] = 2;
					$this->response_return['trans_id'] = $subscriptionId;
					$this->response_return['message'] = "success";	//saved on checkout page
				} else {
					$this->response_return['code'] = 1;
					$this->response_return['message'] = $text;
				}
			} else {
				$this->response_return['code'] = 0;
				$this->response_return['message'] = "Could not connect to Authorize.net";
			}

			if (!empty($this->amount_paid)){
				$this->response_return['amount'] = urlencode($this->amount_paid);
			} else {
				$this->response_return['amount'] = urlencode($amount);
			}
			$this->response_return['currency']	= $this->currency;
			$this->response_return['level'] = $data['lid'];
			$this->response_return['item_name']= $current_level['name'];

			return $this->response_return;
		}

		public function payment_fields(){
			$str = '';

			if($this->sandbox){
					$str .= __('Sandbox mode ', 'ihc');
					$sandbox_values = array('ihcpay_card_number' => '4111111111111111',
											'ihcpay_card_expire' => date('my', strtotime('+1 year')),
											'ihcpay_first_name' => 'John',
											'ihcpay_last_name' => 'Doe'
								);
			}

			$payment_fields = array(
								1 => array(
											'name' => 'ihcpay_card_number',
											'type' => 'number',
											'label' => 'Card Number'
											),
								2 => array(
											'name' => 'ihcpay_card_expire',
											'type' => 'number',
											'label' => 'Expiration Date',
											'sublabel' => 'ex: mmyy'
											),
								3 => array(
											'name' => 'ihcpay_first_name',
											'type' => 'text',
											'label' => 'First Name',
											),
								4 => array(
											'name' => 'ihcpay_last_name',
											'type' => 'text',
											'label' => 'Last Name',
											),
								);
			foreach($payment_fields as $v){
				$str .= '<div class="iump-form-line-register">';
				$str .= '<label class="iump-labels-register">';
				$str .= '<span style="color: red;">*</span>';
				$str .= $v['label'];
				$str .= '</label>';

				$post_submited_value = '';
				if(isset($_POST[$v['name']])){
					 $post_submited_value = $_POST[$v['name']];
				}elseif($this->sandbox){
					$post_submited_value = $sandbox_values[$v['name']];
				}
				$str .= indeed_create_form_element(array('type'=>$v['type'], 'name'=>$v['name'], 'value' => $post_submited_value, 'disabled' => '' ));
				if (isset($v['sublabel']) && $v['sublabel'] != '')
					$str .= '<span class="iump-sublabel-register">'.$v['sublabel'].'</span>';
				$str .= '</div>';
			}

			global $ihc_pay_error;
			if (!empty($ihc_pay_error)){
				if (!empty($ihc_pay_error['not_empty'])){
					$str .= '<div class="iump-authorize-register-notice">' . $ihc_pay_error['not_empty'] . '</div>';
				}
				if (!empty($ihc_pay_error['wrong_expiration'])){
					$str .= '<div class="iump-authorize-register-notice">' . $ihc_pay_error['wrong_expiration'] . '</div>';
				}
				if (!empty($ihc_pay_error['invalid_card'])){
					$str .= '<div class="iump-authorize-register-notice">' . $ihc_pay_error['invalid_card'] . '</div>';
				}
				if (!empty($ihc_pay_error['invalid_first_name'])){
					$str .= '<div class="iump-authorize-register-notice">' . $ihc_pay_error['invalid_first_name'] . '</div>';
				}
				if (!empty($ihc_pay_error['invalid_last_name'])){
					$str .= '<div class="iump-authorize-register-notice">' . $ihc_pay_error['invalid_last_name'] . '</div>';
				}
			}

			return $str;
		}

		private function convertUnit($level){

		  switch($level['access_regular_time_type']){
		  	case 'D':
					$level['access_regular_time_type'] = 'days';
					if ($level['access_regular_time_value'] < 7) $level['access_regular_time_value'] = 7;
					break;
			case 'W':
					$level['access_regular_time_type'] = 'days';
					$level['access_regular_time_value'] = 7*$level['access_regular_time_value'];
					break;
			case 'M':
					$level['access_regular_time_type'] = 'months';
					break;
			case 'Y':
					$level['access_regular_time_type'] = 'months';
					$level['access_regular_time_value'] = 12*$level['access_regular_time_value'];
					break;
		  }
		 return $level;
		}

		public function cancel_subscription($subscription_id){
			//$subscription_id = subscription_transaction_id
			if ($this->sandbox){
				$url = "https://apitest.authorize.net/xml/v1/request.api";
			} else {
				$url = "https://api.authorize.net/xml/v1/request.api";
			}

			$content =
			"<?xml version=\"1.0\" encoding=\"utf-8\"?>".
			"<ARBCancelSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
			"<merchantAuthentication>".
			"<name>" . $this->loginID . "</name>".
			"<transactionKey>" . $this->transactionKey . "</transactionKey>".
			"</merchantAuthentication>" .
			"<subscriptionId>" . $subscription_id . "</subscriptionId>".
			"</ARBCancelSubscriptionRequest>";

			//send the xml via curl
			$response = $this->send_request_via_curl($content, $url);
			return $response;
		}

		private function send_request_via_curl($content, $url){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			return $response;
		}

		private function parse_return($content){
			$refId = '00';
			$resultCode = $this->substring_between($content,'<resultCode>','</resultCode>');
			$code = $this->substring_between($content,'<code>','</code>');
			$text = $this->substring_between($content,'<text>','</text>');
			$subscriptionId = $this->substring_between($content,'<subscriptionId>','</subscriptionId>');
			return array ($refId, $resultCode, $code, $text, $subscriptionId);
		}

		private function substring_between($haystack,$start,$end){
			if (strpos($haystack,$start) === false || strpos($haystack,$end) === false){
				return false;
			} else {
				$start_position = strpos($haystack,$start)+strlen($start);
				$end_position = strpos($haystack,$end);
				return substr($haystack,$start_position,$end_position-$start_position);
			}
		}


	}//end of class UserAddEdit
}
