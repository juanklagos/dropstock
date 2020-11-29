<?php
//Ihc_User_Logs::write_log( __('Authorize Payment Response: Start process', 'ihc'), 'payments');

//insert this request into debug payments table
if (get_option('ihc_debug_payments_db')){
	ihc_insert_debug_payment_log('authorize', $_POST);
}

$r_url = get_home_url();

if ( isset($_POST['x_MD5_Hash']) && isset($_POST['x_response_code'])  && !empty($_POST['x_cust_id']) && !empty($_POST['x_po_num']) ){
	Ihc_User_Logs::write_log( __("Authorize Payment Response: OneTime payment process.", 'ihc'), 'payments');
	$level_id = $_POST['x_po_num'];
	$user_id = $_POST['x_cust_id'];
	$level_data = ihc_get_level_by_id($level_id);//getting details about current level

	Ihc_User_Logs::set_user_id($user_id);
	Ihc_User_Logs::set_level_id($level_id);

	switch ($_POST['x_response_code']){
		case '1':
			ihc_update_user_level_expire($level_data, $level_id, $user_id);
			ihc_switch_role_for_user($user_id);
			ihc_send_user_notifications($user_id, 'payment', $level_id);//send notification to user
			ihc_send_user_notifications($user_id, 'admin_user_payment', $level_id);//send notification to admin
			do_action( 'ihc_payment_completed', $user_id, $level_id );
			Ihc_User_Logs::write_log( __("Authorize Payment Response: Update user level expire time.", 'ihc'), 'payments');
			break;
		case '2':
		case '3':
			if (!function_exists('ihc_is_user_level_expired')){
				require_once IHC_PATH . 'public/functions.php';
			}
			$expired = ihc_is_user_level_expired($user_id, $level_id, FALSE, TRUE);
			if ($expired){
				//delete user - level relationship
				ihc_delete_user_level_relation($level_id, $user_id);
				Ihc_User_Logs::write_log( __("Authorize Payment Response: Delete user level.", 'ihc'), 'payments');
			}
			break;
		case '4':
			break;
	}

	if (isset($_POST['x_trans_id'])){
		//record transation
		$trans_id = $_POST['x_trans_id'];

		//For Testing mode when trans_id is not provided or is 0
		if ($_POST['x_trans_id'] == 0 && isset($_POST['x_invoice_num'])) $trans_id = $_POST['x_invoice_num'];

		$_POST['x_currency_code']= get_option('ihc_currency');
		$_POST['item_name']= $level_data['name'];
		$_POST['ihc_payment_type'] = 'authorize';
		Ihc_User_Logs::write_log( __("Authorize Payment Response: Insert/Update Transaction&Order.", 'ihc'), 'payments');
		ihc_insert_update_transaction($user_id, $trans_id, $_POST);
	}

} else if (isset($_POST['x_MD5_Hash']) && isset($_POST['x_subscription_id']) && isset($_POST['x_response_code'])){
	Ihc_User_Logs::write_log( __("Authorize Payment Response: Recurring payment process.", 'ihc'), 'payments');
	//ARB SECTION
	global $wpdb;
	$q = $wpdb->prepare("SELECT id,txn_id,u_id,payment_data,history,orders,paydate FROM {$wpdb->prefix}indeed_members_payments WHERE txn_id=%s ORDER BY paydate DESC LIMIT 1", $_POST['x_subscription_id']);
	$data = $wpdb->get_row($q);

	if ( isset($data->u_id) && isset($data->payment_data) ){
		$payment_data = json_decode($data->payment_data, TRUE);
		$level_data = ihc_get_level_by_id($payment_data['level']);//getting details about current level
		Ihc_User_Logs::write_log( __("Authorize Payment Response: Payment data.".$data->payment_data, 'ihc'), 'payments');
		Ihc_User_Logs::set_user_id($data->u_id);
		Ihc_User_Logs::set_level_id($payment_data['level']);

		//Avoid Duplicates after first charge
		$continue = 1;
		if(isset($_POST['x_trans_id'])){
			if(empty($payment_data['x_trans_id']) || $_POST['x_trans_id'] == $payment_data['x_trans_id']){
				$continue = 0;
			}
		}
		if($continue == 1){
		  switch ($_POST['x_response_code']){
			  case '1':
				  ihc_update_user_level_expire($level_data, $payment_data['level'], $data->u_id);
				  ihc_switch_role_for_user($data->u_id);
				  ihc_send_user_notifications($data->u_id, 'payment', $payment_data['level']);//send notification to user
				  ihc_send_user_notifications($data->u_id, 'admin_user_payment', $payment_data['level']);//send notification to admin
				  do_action( 'ihc_payment_completed', $data->u_id, $payment_data['level'] );
				  Ihc_User_Logs::write_log( __("Authorize Payment Response: Update user level expire time.", 'ihc'), 'payments');
				  break;
			  case '2':
			  case '3':
				  if (!function_exists('ihc_is_user_level_expired')){
					  require_once IHC_PATH . 'public/functions.php';
				  }
				  $expired = ihc_is_user_level_expired($data->u_id, $payment_data['level'], FALSE, TRUE);
				  if ($expired){
					  //delete user - level relationship
					  ihc_delete_user_level_relation($payment_data['level'], $data->u_id);
					  Ihc_User_Logs::write_log( __("Authorize Payment Response: Delete user level.", 'ihc'), 'payments');
				  }
				  break;
			  case '4':
				  break;
		  }
		}
		if (!empty($payment_data)){
			Ihc_User_Logs::write_log( __("Authorize Payment Response: Start Update Order.", 'ihc'), 'payments');
			$insert_data = $payment_data;
			$insert_data['code'] = $_POST['x_response_code'];
			if ($insert_data['code']==1){
				$insert_data['message'] = 'success';
			} else {
				$insert_data['message'] = $_POST['x_response_reason_text'];
			}
			$insert_data = array_merge($insert_data, $_POST);

			//set payment type
			$insert_data['ihc_payment_type'] = 'authorize';

			//record transation
			$_POST['x_currency_code']= get_option('ihc_currency');
			$_POST['item_name']= $level_data['name'];
			Ihc_User_Logs::write_log( __("Authorize Payment Response: Insert/Update Transaction&Order.", 'ihc'), 'payments');
			if($continue == 1){
				ihc_insert_update_transaction($data->u_id, $_POST['x_subscription_id'], $insert_data);
			}else{
				ihc_insert_update_transaction($data->u_id, $_POST['x_subscription_id'], $insert_data, TRUE);
			}
		}
	}
}
?>
<html>
 <head>
 <script type="text/javascript" charset"utf-8">
 window.location='<?php echo $r_url; ?>';
 </script>
 <noscript>
 <meta http-equiv="refresh" content="1;url=<?php echo $r_url; ?>">
 </noscript>
 </head>
 <body></body>
</html>
