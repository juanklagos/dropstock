<?php
/*
 * Deprecated
 * Used in version <8.3.3
 */
 require_once '../../../../../wp-load.php';

	Ihc_User_Logs::set_user_id(@$_GET['uid']);
	Ihc_User_Logs::set_level_id(@$_GET['lid']);
	Ihc_User_Logs::write_log( __('PayPal Payment: Start process', 'ihc'), 'payments');

	$paypal_email = get_option('ihc_paypal_email');
	$currency = get_option('ihc_currency');
	$levels = get_option('ihc_levels');
	$sandbox = get_option('ihc_paypal_sandbox');
	$r_url = get_option('ihc_paypal_return_page');

	if(!$r_url || $r_url==-1){
		$r_url = get_option('page_on_front');
	}
	$r_url = get_permalink($r_url);
	if (!$r_url){
		$r_url = get_home_url();
	}

	if ($sandbox){
		$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		Ihc_User_Logs::write_log( __('PayPal Payment: set Sandbox mode', 'ihc'), 'payments');
	} else{
		$url = 'https://www.paypal.com/cgi-bin/webscr';
		Ihc_User_Logs::write_log( __('PayPal Payment: set Live mode', 'ihc'), 'payments');
	}

	$err = false;
	//LEVEL
	if (isset($levels[$_GET['lid']])){
		$level_arr = $levels[$_GET['lid']];
		if ($level_arr['payment_type']=='free' || $level_arr['price']=='') $err = true;
	} else {
		Ihc_User_Logs::write_log( __('PayPal Payment: Level is free, no payment required.', 'ihc'), 'payments');
		$err = true;
	}
	// USER ID
	if (isset($_GET['uid']) && $_GET['uid']){
		$uid = $_GET['uid'];
	} else {
		$uid = get_current_user_id();
	}
	if (!$uid){
		$err = true;
		Ihc_User_Logs::write_log( __('PayPal Payment: Error, user id not set.', 'ihc'), 'payments');
	} else {
		Ihc_User_Logs::write_log( __('PayPal Payment: set user id @ ', 'ihc') . $uid, 'payments');
	}


	/*************************** DYNAMIC PRICE ***************************/
	if (ihc_is_magic_feat_active('level_dynamic_price') && isset($_GET['ihc_dynamic_price'])){
		$temp_amount = $_GET['ihc_dynamic_price'];
		if (ihc_check_dynamic_price_from_user($_GET['lid'], $temp_amount)){
			$level_arr['price'] = $temp_amount;
			Ihc_User_Logs::write_log( __('PayPal Payment: Dynamic price on - Amount is set by the user @ ', 'ihc') . $level_arr['price'] . $currency, 'payments');
		}
	}
	/**************************** DYNAMIC PRICE ***************************/


	if ($err){
		////if level it's not available for some reason, go back to prev page
		Ihc_User_Logs::write_log( __('PayPal Payment: stop process, redirect home.', 'ihc'), 'payments');
		header( 'location:'. $r_url );
		exit();
	} else {
		$custom_data = json_encode(array('user_id' => $uid, 'level_id' => $_GET['lid']));
	}

	//$notify_url = str_replace('public/', 'paypal_ipn.php', plugin_dir_url(__FILE__));
	$site_url = site_url();
	$site_url = trailingslashit($site_url);
	$notify_url = add_query_arg('ihc_action', 'paypal', $site_url);

	Ihc_User_Logs::write_log( __('PayPal Payment: set ipn url @ ', 'ihc') . $notify_url, 'payments');

	$reccurrence = FALSE;
	if (isset($level_arr['access_type']) && $level_arr['access_type']=='regular_period'){
		$reccurrence = TRUE;
		Ihc_User_Logs::write_log( __('PayPal Payment: Recurrence payment set.', 'ihc'), 'payments');
	}


	$q = '?';
	if ($reccurrence){
		$q .= 'cmd=_xclick-subscriptions&';
	} else {
		$q .= 'cmd=_xclick&';
	}


	Ihc_User_Logs::write_log( __('PayPal Payment: set admin paypal e-mail @ ', 'ihc') . $paypal_email, 'payments');

	$q .= 'business=' . urlencode($paypal_email) . '&';
	$q .= 'item_name=' . urlencode($level_arr['name']) . '&';
	$q .= 'currency_code=' . $currency . '&';

	//coupons
	$coupon_data = array();
	if (!empty($_GET['ihc_coupon'])){
		$coupon_data = ihc_check_coupon($_GET['ihc_coupon'], $_GET['lid']);
		Ihc_User_Logs::write_log( __('PayPal Payment: the user used the following coupon: ', 'ihc') . $_GET['ihc_coupon'], 'payments');
	}

	if ($reccurrence){
		//====================RECCURENCE
		//coupon on reccurence
		if ($coupon_data){
			if (!empty($coupon_data['reccuring'])){
				//everytime the price will be reduced
				$level_arr['price'] = ihc_coupon_return_price_after_decrease($level_arr['price'], $coupon_data, TRUE, $_GET['uid'], $_GET['lid']);
				if (isset($level_arr['access_trial_price'])){
					$level_arr['access_trial_price'] = ihc_coupon_return_price_after_decrease($level_arr['access_trial_price'], $coupon_data, FALSE);
				}
			} else {
				//only one time
				if (!empty($level_arr['access_trial_price'])){
					$level_arr['access_trial_price'] = ihc_coupon_return_price_after_decrease($level_arr['access_trial_price'], $coupon_data, TRUE, $_GET['uid'], $_GET['lid']);
				} else {
					$level_arr['access_trial_price'] = ihc_coupon_return_price_after_decrease($level_arr['price'], $coupon_data, TRUE, $_GET['uid'], $_GET['lid']);
					$level_arr['access_trial_type'] = 2;
				}
				if (empty($level_arr['access_trial_type'])){
					$level_arr['access_trial_type'] = 2;
				}
			}
		}

		//trial block
		if (isset($level_arr['access_trial_price']) && $level_arr['access_trial_price']!==''){   /// !empty($level_arr['access_trial_type']) &&
			/// TAXES
			$country = (isset($_GET['ihc_country'])) ? $_GET['ihc_country'] : '';
			$state = (isset($_GET['ihc_state'])) ? $_GET['ihc_state'] : '';
			$taxes_price = ihc_get_taxes_for_amount_by_country($country, $state, $level_arr['access_trial_price']);
			if ($taxes_price && !empty($taxes_price['total'])){
				$level_arr['access_trial_price'] += $taxes_price['total'];
			}

			$q .= 'a1=' . urlencode($level_arr['access_trial_price']) . '&';//price
			if ($level_arr['access_trial_type']==1){
				//certain period
				$q .= 't1=' . urlencode($level_arr['access_trial_time_type']) . '&';//type of time
				$q .= 'p1=' . urlencode($level_arr['access_trial_time_value']) . '&';// time value
				Ihc_User_Logs::write_log( __('PayPal Payment: Trial time value set @ ', 'ihc') . $level_arr['access_trial_time_value'] . ' ' .$level_arr['access_trial_time_type'] , 'payments');
			} else {
				//one subscription
				$q .= 't1=' . $level_arr['access_regular_time_type'] . '&';//type of time
				$q .= 'p1=' . $level_arr['access_regular_time_value'] . '&';//time value
				Ihc_User_Logs::write_log( __('PayPal Payment: Trial time value set @ ', 'ihc') . $level_arr['access_regular_time_value'] . ' ' .$level_arr['access_regular_time_type'] , 'payments');
			}
			$trial = TRUE;
		}
		//end of trial

		/// TAXES
		$country = (isset($_GET['ihc_country'])) ? $_GET['ihc_country'] : '';
		$state = (isset($_GET['ihc_state'])) ? $_GET['ihc_state'] : '';
		$taxes_price = ihc_get_taxes_for_amount_by_country($country, $state, $level_arr['price']);
		if ($taxes_price && !empty($taxes_price['total'])){
			$level_arr['price'] += $taxes_price['total'];
			Ihc_User_Logs::write_log( __('PayPal Payment: taxes value set @ ', 'ihc') . $taxes_price['total'] . $currency, 'payments');
		}

		$q .= 'a3=' . urlencode($level_arr['price']) . '&';
		Ihc_User_Logs::write_log( __('PayPal Payment: amount set @ ', 'ihc') . $level_arr['price'] . $currency, 'payments');
		$q .= 't3=' . $level_arr['access_regular_time_type'] . '&';
		$q .= 'p3=' . $level_arr['access_regular_time_value'] . '&';
		$q .= 'src=1&';//set the rec
		if ($level_arr['billing_type']=='bl_ongoing'){
			//$rec = 52;
			$rec = 0;
		} else {
			if (isset($level_arr['billing_limit_num'])){
				$rec = (int)$level_arr['billing_limit_num'];
			} else {
				$rec = 52;
			}
		}
		Ihc_User_Logs::write_log( __('PayPal Payment: recurrence number: ', 'ihc') . $rec, 'payments');
		$q .= 'srt='.$rec.'&';//num of rec
		$q .= 'no_note=1&';
		if (!empty($trial)){
			$q .= 'modify=0&';
		} else {
			//$q .= 'modify=1&';
		}
	} else {
		//====================== single payment

		//coupon
		if ($coupon_data){
			$level_arr['price'] = ihc_coupon_return_price_after_decrease($level_arr['price'], $coupon_data, TRUE, $_GET['uid'], $_GET['lid']);
		}

		/// TAXES
		$country = (isset($_GET['ihc_country'])) ? $_GET['ihc_country'] : '';
		$state = (isset($_GET['ihc_state'])) ? $_GET['ihc_state'] : '';
		$taxes_price = ihc_get_taxes_for_amount_by_country($country, $state, $level_arr['price']);
		if ($taxes_price && !empty($taxes_price['total'])){
			$level_arr['price'] += $taxes_price['total'];
			Ihc_User_Logs::write_log( __('PayPal Payment: taxes value: ', 'ihc') . $taxes_price['total'] . $currency, 'payments');
		}

		$q .= 'amount=' . urlencode($level_arr['price']) . '&';
		Ihc_User_Logs::write_log( __('PayPal Payment: amount set @ ', 'ihc') . $level_arr['price'] . $currency, 'payments');
		$q .= 'paymentaction=sale&';
	}


	$locale = get_option('ihc_paypapl_locale_code');
	$currentLocale = indeed_get_current_language_code();
	if ( $currentLocale && $locale!=$currentLocale ){
			$locale = $currentLocale;
	}

	if ($locale){
			$q .= 'lc=' . $locale . '&';
	} else {
			$q .= 'lc=EN_US&';
	}
	$q .= 'return=' . urlencode($r_url) . '&';
	$q .= 'cancel_return=' . urlencode($r_url) . '&';
	$q .= 'notify_url=' . urlencode($notify_url) . '&';
	$q .= 'rm=2&';
	$q .= 'no_shipping=1&';
	$q .= 'custom=' . $custom_data;

	Ihc_User_Logs::write_log( __('PayPal Payment: Request submited.', 'ihc'), 'payments');
	header( 'location:' . $url . $q );
	exit();
