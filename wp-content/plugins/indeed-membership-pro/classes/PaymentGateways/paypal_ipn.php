<?php
/*
 * Deprecated
 * Used in version <8.3.3
 */

ini_set('display_errors','on');

//insert this request into debug payments table
if (get_option('ihc_debug_payments_db')){
	ihc_insert_debug_payment_log('paypal', $_POST);
}

Ihc_User_Logs::write_log( __('PayPal Payment IPN: Start process', 'ihc'), 'payments');

if ( ( isset($_POST['payment_status']) || isset($_POST['txn_type']) ) && isset($_POST['custom']) ){

	$debug = FALSE;
	$path = str_replace('paypal_ipn.php', '', __FILE__);
	$log_file = $path . 'paypal.log';
	$raw_post_data = file_get_contents('php://input');
	Ihc_User_Logs::write_log( __('PayPal Payment IPN: Extract data from response.', 'ihc'), 'payments');
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
		Ihc_User_Logs::write_log( __('PayPal Payment IPN: Set Sandbox mode.', 'ihc'), 'payments');
	} else {
		$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		Ihc_User_Logs::write_log( __('PayPal Payment IPN: Set live mode.', 'ihc'), 'payments');
	}

	$ch = curl_init($paypal_url);
	if ($ch == FALSE) {
		if ($debug) {
			error_log(date('[Y-m-d H:i e] '). "No CURL Enabled on this server ", 3, $log_file);
		}
		Ihc_User_Logs::write_log( __('PayPal Payment IPN: End Process. No CURL Enabled on this server. ', 'ihc'), 'payments');
		echo "No CURL Enabled on this server ";
		exit();
	}
	Ihc_User_Logs::write_log( __('PayPal Payment IPN: Send cURL request to PayPal.', 'ihc'), 'payments');
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
		Ihc_User_Logs::write_log( __("PayPal Payment IPN: cURL error - can't connect to PayPal to validate IPN message: ", 'ihc') . curl_error($ch) . PHP_EOL, 'payments');
		if ($debug) {
			error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, $log_file);
		}
		curl_close($ch);
		echo date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch);
		exit; /// out
	} else {
		//Log the entire HTTP response if debug is switched on.
		Ihc_User_Logs::write_log( __("PayPal Payment IPN: cURL error - HTTP response of validation request: ", 'ihc') . $res . PHP_EOL, 'payments');
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
		Ihc_User_Logs::write_log( __("PayPal Payment IPN: cURL request Verified.", 'ihc'), 'payments');
		if (isset($_POST['custom'])){
			$data = stripslashes($_POST['custom']);
			$data = json_decode($data, true);
			$level_data = ihc_get_level_by_id($data['level_id']);//getting details about current level
		}

		Ihc_User_Logs::write_log( __('PayPal Payment IPN: '.json_encode($_POST), 'ihc'), 'payments');

		Ihc_User_Logs::set_user_id($data['user_id']);
		Ihc_User_Logs::set_level_id($data['level_id']);
		Ihc_User_Logs::write_log( __("PayPal Payment IPN: set user id @ ", 'ihc') . $data['user_id'], 'payments');

		if (isset($_POST['payment_status'])){
			Ihc_User_Logs::write_log( __("PayPal Payment IPN: Payment status is ", 'ihc') . $_POST['payment_status'], 'payments');
			switch ($_POST['payment_status']){
				case 'Processed':
				case 'Completed':

					//v.7.1 - Cover Paid Trial with different period than Level Period. MUST be Double-Check
					if(isset($level_data['access_trial_time_value']) && $level_data['access_trial_time_value'] > 0 && ihc_user_level_first_time($data['user_id'],$data['level_id'])){
						Ihc_User_Logs::write_log( __("PayPal Payment IPN: Update user level expire time (Trial).", 'ihc'), 'payments');
						ihc_set_level_trial_time_for_no_pay($data['level_id'], $data['user_id']);
					}else{
						//payment made, put the right expire time
						Ihc_User_Logs::write_log( __("PayPal Payment IPN: Update user level expire time.", 'ihc'), 'payments');
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
					/*if (!function_exists('ihc_is_user_level_expired')){
						require_once IHC_PATH . 'public/functions.php';
					}
					$expired = ihc_is_user_level_expired($data['user_id'], $data['level_id'], FALSE, TRUE);
					if ($expired){
						//it's expired and we must delete user - level relationship
						Ihc_User_Logs::write_log( __("PayPal Payment IPN: Delete user level2.", 'ihc'), 'payments');
						ihc_delete_user_level_relation($data['level_id'], $data['user_id']);
					}*/
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
				  Ihc_User_Logs::write_log( __("PayPal Payment IPN: Update user level expire time (Trial).", 'ihc'), 'payments');
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
				Ihc_User_Logs::write_log( __("PayPal Payment IPN: Update user level expire time.", 'ihc'), 'payments');
				ihc_update_user_level_expire($level_data, $data['level_id'], $data['user_id']);
				ihc_send_user_notifications($data['user_id'], 'payment', $data['level_id']);//send notification to user
				ihc_send_user_notifications($data['user_id'], 'admin_user_payment', $data['level_id']);//send notification to admin
				do_action( 'ihc_payment_completed', $data['user_id'], $data['level_id'] );
				// @description run on payment complete. @param user id (integer), level id (integer)

				ihc_switch_role_for_user($data['user_id']);
				ihc_insert_update_transaction($data['user_id'], $insert_data['txn_id'], $insert_data);
			}
			header('HTTP/1.0 200 OK');
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

				/*if (!function_exists('ihc_is_user_level_expired')){
					require_once IHC_PATH . 'public/functions.php';
				}
				$expired = ihc_is_user_level_expired($data['user_id'], $data['level_id'], FALSE, TRUE);
				if ($expired){
					//it's expired and we must delete user - level relationship
					Ihc_User_Logs::write_log( __("PayPal Payment IPN: Delete user level1.", 'ihc'), 'payments');
					ihc_delete_user_level_relation($data['level_id'], $data['user_id']);
				}*/
				ihc_delete_user_level_relation($data['level_id'], $data['user_id']);
			break;
		}

		//header('HTTP/1.0 200 OK');
		exit();

	} else if (strcmp ($res, "INVALID") == 0) {
		Ihc_User_Logs::write_log( __("PayPal Payment IPN: cURL request is Invaild.", 'ihc'), 'payments');
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
