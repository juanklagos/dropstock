<?php

require_once IHC_PATH . 'classes/PaymentGateways/stripe/init.php';

ini_set('display_errors','on');

Ihc_User_Logs::write_log( __('Stripe Payment Webhook: Start process' . indeed_get_unixtimestamp_with_timezone(), 'ihc'), 'payments');

$publishable_key = get_option('ihc_stripe_publishable_key');
$secret_key = get_option('ihc_stripe_secret_key');
if (empty($secret_key)){
	/// out
	Ihc_User_Logs::write_log( __('Stripe Payment Webhook: Secret key is not set properly.', 'ihc'), 'payments');
	die();
}
\Stripe\Stripe::setApiKey($secret_key);

$body = @file_get_contents('php://input');
$event_arr = json_decode($body, TRUE);

$event_arr['ihc_payment_type'] = 'stripe';//set payment type

//insert this request into debug payments table
if (get_option('ihc_debug_payments_db')){
	ihc_insert_debug_payment_log('stripe', $event_arr );
}
if(isset($event_arr['id'])){

	if ( $event_arr['id'] == 'evt_00000000000000' ){
			echo '============= Ultimate Membership Pro - STRIPE WEBHOOK ============= ';
			echo '<br/><br/>Your test is successfully.';
			die;
	}

	$event = \Stripe\Event::retrieve($event_arr['id']);
} else {
	echo '============= Ultimate Membership Pro - STRIPE WEBHOOK ============= ';
	echo '<br/><br/>No Event sent. Come later';
	die();
}
Ihc_User_Logs::write_log( __('Stripe Payment Webhook: Event: '.json_encode($event), 'ihc'), 'payments');
if (is_array($event_arr) && is_array($event_arr['data']) && is_array($event_arr['data']['object']) && isset($event_arr['data']['object']['customer'])){
	$the_key = $event_arr['data']['object']['customer'];
} else {
	$the_key = '';
}

if ($event && isset($event->data->object->id) && $the_key){
	$data = ihc_get_uid_lid_by_stripe($the_key);
	if (count($data)>0 && isset($data['uid']) && isset($data['lid'])){
			//Ihc_User_Logs::write_log( __('Stripe Payment Webhook: User have been found.', 'ihc'), 'payments');
			//Ihc_User_Logs::write_log( __('Stripe Payment Webhook: Data: '.json_encode($data), 'ihc'), 'payments');
	}else{
			$delay = 10;
			Ihc_User_Logs::write_log( __('Stripe Payment Webhook: User have not been found. Try again in '.$delay.' secs', 'ihc'), 'payments');

			for($i=0; $i<$delay; $i++){
				sleep(1);
			}
			$data = ihc_get_uid_lid_by_stripe($the_key);
	}

	//Check if duplicate event is received based on Event ID and stored transactions
	if(isset($data['payment_data']) && isset($event->id)){
			$pos = strpos($data['payment_data']['id'], $event->id);

			if($pos === FALSE){
				//everything is fine
			}else{
				//event already managed
				//erase $data array
				Ihc_User_Logs::set_user_id($data['uid']);
				Ihc_User_Logs::set_level_id($data['lid']);

				Ihc_User_Logs::write_log( __('Stripe Payment Webhook: Event already managed. Nothing to do more.', 'ihc'), 'payments');
				$data = array();
				unset($data);
				http_response_code(200);
				exit();
			}
	}

	if (count($data)>0 && isset($data['uid']) && isset($data['lid'])){
		//we have user id and level id for processing

		Ihc_User_Logs::set_user_id($data['uid']);
		Ihc_User_Logs::set_level_id($data['lid']);

		if ($event->type=='charge.succeeded'){
			////// PAYMENT MADE
			Ihc_User_Logs::write_log( __("Stripe Payment Webhook: charge Succeeded.", 'ihc'), 'payments');
			$event_arr['level'] = $data['lid'];
			$level_data = ihc_get_level_by_id($data['lid']);//getting details about current level

			$data_body = json_decode($body, TRUE);
			$multiply = ihcStripeMultiplyForCurrency( get_option('ihc_currency') );
			$current_transaction_amount = $data_body['data']['object']['amount']/$multiply;
			unset($data_body['data']);
			sleep(10);

				//Check Trial for new Stripe API
				/*if(isset($level_data['access_trial_price']) && $level_data['access_trial_price'] == 0){

					if(ihc_get_user_pending_trial_order($data['uid'], $data['lid']) > 0){
						Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Trial Special.", 'ihc'), 'payments');

						ihc_set_level_trial_time_for_no_pay($data['lid'], $data['uid']);
					}else{
						ihc_update_user_level_expire($level_data, $data['lid'], $data['uid']);
					}
				}else{

				}*/

			ihc_update_user_level_expire($level_data, $data['lid'], $data['uid']);
			Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Updated user (".$data['uid'].") level (".$data['lid'].") expire time.", 'ihc'), 'payments');
			ihc_switch_role_for_user($data['uid']);


			$data_db = array_merge($data['payment_data'], $data_body);
			$data_db['message'] = 'success';


			if($data_db['amount'] != $current_transaction_amount || $data_db['amount'] == 0 || $data_db['amount'] == NULL){
				Ihc_User_Logs::write_log( __('Stripe Payment Webhook: Update the right amount '.$current_transaction_amount, 'ihc'), 'payments');
				$data_db['amount'] = $current_transaction_amount;
			}

			ihc_insert_update_transaction($data['uid'], $the_key, $data_db);


			http_response_code(200);
			//send notification to user
			ihc_send_user_notifications($data['uid'], 'payment', $data['lid']);
			ihc_send_user_notifications($data['uid'], 'admin_user_payment', $data['lid']);//send notification to admin
			do_action( 'ihc_payment_completed', $data['uid'], $data['lid'] );
			// @description run on payment complete. @param user id (integer), level id (integer)

		} else if ($event->type=='customer.subscription.created' && $event->data->object->status=="trialing"){
			////// TRIAL
			sleep(10);
			Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Subscription Created.", 'ihc'), 'payments');
			$event_arr['level'] = $data['lid'];
			$level_data = ihc_get_level_by_id($data['lid']);//getting details about current level
			Ihc_User_Logs::write_log( __("Stripe Payment Webhook: TEST".$level_data['access_trial_price'], 'ihc'), 'payments');
			$check_pending_orders = ihc_get_user_pending_trial_order($data['uid'], $data['lid'], $level_data);
			if($check_pending_orders > 0){
					Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Trial Set.", 'ihc'), 'payments');

					ihc_set_level_trial_time_for_no_pay($data['lid'], $data['uid']);
					Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Updated user (".$data['uid'].") level (".$data['lid'].") expire time.", 'ihc'), 'payments');
					ihc_switch_role_for_user($data['uid']);
					$data_body = json_decode($body, TRUE);
					unset($data_body['data']);
					if ($check_pending_orders > 1){
						$data_body['amount'] = $check_pending_orders;
					}else{
						$data_body['amount'] = 0;
					}
					$data_db = array_merge($data['payment_data'], $data_body);
					$data_db['message'] = 'success';
					ihc_insert_update_transaction($data['uid'], $the_key, $data_db);


					http_response_code(200);

					ihc_send_user_notifications($data['uid'], 'payment', $data['lid']);//send notification to user
					ihc_send_user_notifications($data['uid'], 'admin_user_payment', $data['lid']);//send notification to admin
					do_action( 'ihc_payment_completed', $data['uid'], $data['lid'] );
					// @description run on payment complete. @param user id (integer), level id (integer)
				}

					/*ihc_set_level_trial_time_for_no_pay($data['lid'], $data['uid']);
					ihc_switch_role_for_user($data['uid']);
					$data_body = json_decode($body, TRUE);
					unset($data_body['data']);
					$data_body['amount'] = 0;
					$data_db = array_merge($data['payment_data'], $data_body);
					$data_db['message'] = 'success';
					ihc_insert_update_transaction($data['uid'], $the_key, $data_db);

					Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Update user level expire time.", 'ihc'), 'payments');

					ihc_send_user_notifications($data['uid'], 'payment', $data['lid']);//send notification to user
					ihc_send_user_notifications($data['uid'], 'admin_user_payment', $data['lid']);//send notification to admin
					*/
			http_response_code(200);

		} else if ($event->type=='invoiceitem.deleted' || $event->type=='charge.refunded') {
			//suspend the account?

			require_once IHC_PATH . 'public/functions.php';

					/*$expired = ihc_is_user_level_expired($data['uid'], $data['lid'], FALSE, TRUE);
					if ($expired){
						//delete user - level relationship
						Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Delete user level.", 'ihc'), 'payments');
						ihc_delete_user_level_relation($data['lid'], $data['uid']);
					}*/

				Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Delete user level.", 'ihc'), 'payments');
				ihc_delete_user_level_relation($data['lid'], $data['uid']);

				$data_body = json_decode($body, TRUE);

				//refunded value is provided with positive value and decimal fraction
				$data_body['amount'] = -($data_body['data']['object']['amount_refunded']/100);
				unset($data_body['data']);
				$data_db = array_merge($data['payment_data'], $data_body);
				$data_db['message'] = 'success';
				ihc_insert_update_transaction($data['uid'], $the_key, $data_db);

			http_response_code(200);
		}
	} else {
		Ihc_User_Logs::write_log( __("Stripe Payment Webhook: Error. Unknown user id or level id.", 'ihc'), 'payments');
		http_response_code(200);
	}
}
http_response_code(200);
exit();
