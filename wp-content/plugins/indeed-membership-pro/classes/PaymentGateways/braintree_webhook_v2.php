<?php
require_once IHC_PATH . 'classes/gateways/libraries/braintree/Braintree.php';

Ihc_User_Logs::write_log( __('Braintree Payment Webhook: Start process', 'ihc'), 'payments');

/// AUTH
$meta = ihc_return_meta_arr('payment_braintree');
$meta = ihc_return_meta_arr('payment_braintree');
$env = empty( $meta['ihc_braintree_sandbox'] ) ? 'production' : 'sandbox';
Braintree\Configuration::environment( $env );
Braintree\Configuration::merchantId( $meta['ihc_braintree_merchant_id'] );
Braintree\Configuration::publicKey( $meta['ihc_braintree_public_key'] );
Braintree\Configuration::privateKey( $meta['ihc_braintree_private_key'] );

if (!empty($_REQUEST["bt_signature"]) && !empty($_REQUEST["bt_payload"])){
	$webhookNotification = Braintree\WebhookNotification::parse($_REQUEST["bt_signature"], $_REQUEST["bt_payload"]);
	if (!empty($webhookNotification) && !empty($webhookNotification->subscription) && !empty($webhookNotification->subscription->id)){
		$transaction_id = $webhookNotification->subscription->id;


		$data = ihc_get_lid_uid_by_txn_id($transaction_id);

		Ihc_User_Logs::set_user_id(@$data['uid']);
		Ihc_User_Logs::set_level_id(@$data['lid']);

		switch ($webhookNotification->kind){
			case 'subscription_charged_successfully':
				if (isset($data['lid']) && isset($data['uid'])){
					///success
					$data['message'] = 'success';
					$level_data = ihc_get_level_by_id($data['lid']);//getting details about current level
					ihc_update_user_level_expire($level_data, $data['lid'], $data['uid']);
					ihc_switch_role_for_user($data['uid']);
					ihc_insert_update_transaction($data['uid'], $transaction_id, $data);
					ihc_send_user_notifications($data['uid'], 'payment', $data['lid']);//send notification to user
					ihc_send_user_notifications($data['uid'], 'admin_user_payment', $data['lid']);//send notification to admin
					do_action( 'ihc_payment_completed', $data['uid'], $data['lid'] );
					Ihc_User_Logs::write_log( __("Braintree Payment Webhook: Update user level expire time.", 'ihc'), 'payments');
				}
				break;
			case 'subscription_canceled':
			case 'subscription_charged_unsuccessfully':
			case 'subscription_expired':
				///FAIL
				if (!function_exists('ihc_is_user_level_expired')){
					require_once IHC_PATH . 'public/functions.php';
				}
				$expired = ihc_is_user_level_expired($data['uid'], $data['lid'], FALSE, TRUE);
				if ($expired){
					//it's expired and we must delete user - level relationship
					ihc_delete_user_level_relation($data['lid'], $data['uid']);
					Ihc_User_Logs::write_log( __("Braintree Payment Webhook: Delete user level.", 'ihc'), 'payments');
				}
				break;
		}
	}
} else if (!empty($_REQUEST['transaction_id'])){
	/// TESTING WEBHOOK
	$sampleNotification = Braintree\WebhookTesting::sampleNotification(
	    Braintree\WebhookNotification::SUBSCRIPTION_WENT_ACTIVE,
	    $_REQUEST['transaction_id']
	);

	$webhookNotification = Braintree\WebhookNotification::parse(
	    $sampleNotification['bt_signature'],
	    $sampleNotification['bt_payload']
	);

	echo $webhookNotification->subscription->id;

}
