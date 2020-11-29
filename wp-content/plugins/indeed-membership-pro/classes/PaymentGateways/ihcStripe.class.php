<?php
if(!class_exists('ihcStripe')){
	class ihcStripe{
		private $publishable_key = FALSE;
		private $secret_key = FALSE;
		private $level_data = array();
		private $currency = 'USD';

		public function __construct(){
			//set keys
			$this->publishable_key = get_option('ihc_stripe_publishable_key');
			$this->secret_key = get_option('ihc_stripe_secret_key');
			$this->level_data = get_option('ihc_levels');
			$this->currency = get_option('ihc_currency');

			//load stripe libs
			require_once IHC_PATH . 'classes/PaymentGateways/stripe/init.php';
			\Stripe\Stripe::setApiKey($this->secret_key);

			//multiply
			$this->multiply = ihcStripeMultiplyForCurrency( $this->currency );
		}

		public function payment_fields($level_id, $bind=TRUE){
			if (isset($this->level_data[$level_id])){

				/// popup stuff
				$top_logo = get_option('ihc_stripe_popup_image');
				$button_label = get_option('ihc_stripe_bttn_value');
				$locale_code = get_option('ihc_stripe_locale_code');
				$currentLocale = indeed_get_current_language_code();
				if ( $currentLocale && $locale_code!=$currentLocale ){
						$locale_code = $currentLocale;
				}
				if ($locale_code){
						$locale = 'locale: "' . $locale_code . '", ';
				} else {
						$locale = 'locale: "auto", ';
				}
				if ($top_logo){
						$image = 'image: "' . $top_logo . '", ';
				} else {
						$image = '';
				}
				if ($button_label){
						$bttn = 'panelLabel: "' . $button_label . '", ';
				} else {
						$bttn = '';
				}

				$amount = $this->level_data[$level_id]['price'] * $this->multiply;
				if ( $this->multiply == 100 && $amount>0 && $amount<50){
					$amount = 50;
				}

				$str = '
				<script src="https://checkout.stripe.com/checkout.js"></script>
				<script>
				var iump_stripe = StripeCheckout.configure({
					key: "' . $this->publishable_key . '",
					' . $locale . '
					' . $image . '
					' . $bttn . '
					token: function(response) {
						var input = jQuery("<input type=hidden name=stripeToken id=stripeToken />").val(response.id);
						var email = jQuery("<input type=hidden name=stripeEmail id=stripeEmail />").val(response.email);
						jQuery(".ihc-form-create-edit").append(input);
						jQuery(".ihc-form-create-edit").append(email);
						jQuery(".ihc-form-create-edit").submit();
					}
				});
				';

				if ($bind){
					$str .= '
								jQuery(document).ready(function(){
									jQuery("#ihc_submit_bttn").bind("click", function(e){
										var multiply = ' . $this->multiply . ';
										e.preventDefault();
										if (jQuery("#stripeToken").val() && jQuery("#stripeEmail").val()){
											jQuery(".ihc-form-create-edit").submit();
											return true;
										}
										var p = jQuery("#iumpfinalglobalp").val();
										p = p * multiply;
										';
					if($this->level_data[$level_id]['access_type'] != 'regular_period'){
						$str .='
										if (p==0){
												jQuery(".ihc-form-create-edit").submit();
												return;
										}
								';
					}
					$str .='
										if ( multiply == 100 && p>0 && p<50){
 											p = 50;
										}

										iump_stripe.open({
														name: jQuery("#iump_site_name").val(),
														description: jQuery("#iumpfinalglobal_ll").val(),
														email: jQuery("[name=user_email]").val(),
														amount: p,
														currency: jQuery("#iumpfinalglobalc").val()
										});
									});
								});
							';
				}

				$str .= "</script>";

				return $str;
			}
		}

		public function charge($post_data, $insert_order=FALSE){
			/*
			 * @param array
			 * @return array
			 */
			if (isset($this->level_data[$post_data['lid']])){

				///LOGS
				Ihc_User_Logs::set_user_id(@$post_data['uid']);
				Ihc_User_Logs::set_level_id($post_data['lid']);
				Ihc_User_Logs::write_log( __('Stripe Payment: Start process', 'ihc'), 'payments');

				$order_extra_metas = array();
				$reccurrence = FALSE;
				if (isset($this->level_data[$post_data['lid']]['access_type']) && $this->level_data[$post_data['lid']]['access_type']=='regular_period'){
					$reccurrence = TRUE;
				}

				/*************************** DYNAMIC PRICE ***************************/
				if (ihc_is_magic_feat_active('level_dynamic_price') && isset($post_data['ihc_dynamic_price'])){
					$temp_amount = $post_data['ihc_dynamic_price'];
					if (ihc_check_dynamic_price_from_user($post_data['lid'], $temp_amount)){
						$this->level_data[$post_data['lid']]['price'] = $temp_amount;
						Ihc_User_Logs::write_log( __('Stripe Payment: Dynamic price on - Amount is set by the user @ ', 'ihc') . $temp_amount . $this->currency, 'payments');
					}
				}
				/**************************** DYNAMIC PRICE ***************************/

				//DISCOUNT
				if (!empty($post_data['ihc_coupon'])){
					$coupon_data = ihc_check_coupon($post_data['ihc_coupon'], $post_data['lid']);
					if ($coupon_data && (!empty($coupon_data['reccuring']) || !$reccurrence)){
						//available only for single payment or discount on all recurring payments
						$order_extra_metas['discount_value'] = ihc_get_discount_value($this->level_data[$post_data['lid']]['price'], $coupon_data);
						$order_extra_metas['coupon_used'] = $post_data['ihc_coupon'];
						$this->level_data[$post_data['lid']]['price'] = ihc_coupon_return_price_after_decrease(
																		$this->level_data[$post_data['lid']]['price'],
																		$coupon_data,
																		TRUE,
																		$post_data['uid'],
																		$post_data['lid']);
						Ihc_User_Logs::write_log( __('Stripe Payment: the user used the following coupon: ', 'ihc') . $post_data['ihc_coupon'], 'payments');
					}

				}

				$amount = $this->level_data[$post_data['lid']]['price'];

				$amount = $amount * $this->multiply;
				if ( $this->multiply == 100 && $amount> 0 && $amount<50){
					$amount = 50;// 0.50 cents minimum amount for stripe transactions
				}

				/// TAXES
				$state = (isset($post_data['ihc_state'])) ? $post_data['ihc_state'] : '';
				$country = isset($post_data['ihc_country']) ? $post_data['ihc_country'] : '';
				$taxes_data = ihc_get_taxes_for_amount_by_country($country, $state, $amount);
				if ($taxes_data && !empty($taxes_data['total'])){
					$amount += $taxes_data['total'];
					$order_extra_metas['tax_value'] = $taxes_data['total'];
				}

				$amount = round($amount);

				$customer_arr = array(
						'email' => $post_data['stripeEmail'],
						'card'  => $post_data['stripeToken'],
				);


				if ($reccurrence){
					Ihc_User_Logs::write_log( __('Stripe Payment: Recurrence payment set.', 'ihc'), 'payments');
					$ihc_plan_code = 'ihc_plan_' . rand(1,10000);
					switch ($this->level_data[$post_data['lid']]['access_regular_time_type']){
						case 'D':
							$this->level_data[$post_data['lid']]['access_regular_time_type'] = 'day';
							break;
						case 'W':
							$this->level_data[$post_data['lid']]['access_regular_time_type'] = 'week';
							break;
						case 'M':
							$this->level_data[$post_data['lid']]['access_regular_time_type'] = 'month';
							break;
						case 'Y':
							$this->level_data[$post_data['lid']]['access_regular_time_type'] = 'year';
							break;
					}

					///trial
					$trial_period_days = 0;
					if (!empty($this->level_data[$post_data['lid']]['access_trial_type'])){
						if ($this->level_data[$post_data['lid']]['access_trial_type']==1 && isset($this->level_data[$post_data['lid']]['access_trial_time_value'])
								&& $this->level_data[$post_data['lid']]['access_trial_time_value'] !=''){
							switch ($this->level_data[$post_data['lid']]['access_trial_time_type']){
								case 'D':
									$trial_period_days = $this->level_data[$post_data['lid']]['access_trial_time_value'];
									break;
								case 'W':
									$trial_period_days = $this->level_data[$post_data['lid']]['access_trial_time_value'] * 7;
									break;
								case 'M':
									$trial_period_days = $this->level_data[$post_data['lid']]['access_trial_time_value'] * 31;
									break;
								case 'Y':
									$trial_period_days = $this->level_data[$post_data['lid']]['access_trial_time_value'] * 365;
									break;
							}
						} else if ($this->level_data[$post_data['lid']]['access_trial_type']==2 && isset($this->level_data[$post_data['lid']]['access_trial_couple_cycles'])
									&& $this->level_data[$post_data['lid']]['access_trial_couple_cycles']!=''){
							switch ($this->level_data[$post_data['lid']]['access_regular_time_type']){
								case 'day':
									$trial_period_days = $this->level_data[$post_data['lid']]['access_regular_time_value'] * $this->level_data[$post_data['lid']]['access_trial_couple_cycles'];
									break;
								case 'week':
									$trial_period_days = $this->level_data[$post_data['lid']]['access_regular_time_value'] * $this->level_data[$post_data['lid']]['access_trial_couple_cycles'] * 7;
									break;
								case 'month':
									$trial_period_days = $this->level_data[$post_data['lid']]['access_regular_time_value'] * $this->level_data[$post_data['lid']]['access_trial_couple_cycles'] * 31;
									break;
								case 'year':
									$trial_period_days = $this->level_data[$post_data['lid']]['access_regular_time_value'] * $this->level_data[$post_data['lid']]['access_trial_couple_cycles'] * 365;
									break;
							}
						}
					}
					//end of trial

					//v.7.1 - Recurring Level with Coupon 100% => 1 free Trial cycle
					if($trial_period_days == 0){
						if(isset($coupon_data)){
							$discounted_value = ihc_get_discount_value($amount, $coupon_data);

							if($amount - $discounted_value == 0){
							  $order_extra_metas['discount_value'] = $discounted_value;
							  $order_extra_metas['coupon_used'] = $post_data['ihc_coupon'];
							  switch ($this->level_data[$post_data['lid']]['access_regular_time_type']){
								  case 'day':
									  $trial_period_days = $this->level_data[$post_data['lid']]['access_regular_time_value'];
									  break;
								  case 'week':
									  $trial_period_days = $this->level_data[$post_data['lid']]['access_regular_time_value']  * 7;
									  break;
								  case 'month':
									  $trial_period_days = $this->level_data[$post_data['lid']]['access_regular_time_value'] * 31;
									  break;
								  case 'year':
									  $trial_period_days = $this->level_data[$post_data['lid']]['access_regular_time_value']  * 365;
									  break;
							  }

							  Ihc_User_Logs::write_log( __('Stripe Payment: the user used the following coupon: ', 'ihc') . $post_data['ihc_coupon'], 'payments');				}
						}
					}


					$plan = array(
							"amount" => $amount,
							"interval_count" => $this->level_data[$post_data['lid']]['access_regular_time_value'],
							"interval" => $this->level_data[$post_data['lid']]['access_regular_time_type'],
							"product" => array(
    						"name" => "Recurring for " . $this->level_data[$post_data['lid']]['name'] ),
							"currency" => $this->currency,
							"id" => $ihc_plan_code,
							//"trial_period_days" => $trial_period_days,

					);
					$trial_end = "now";
					if (!empty($trial_period_days)){
						Ihc_User_Logs::write_log( __('Stripe Payment: Trial time value set @ ', 'ihc') . $trial_period_days . __(' days.', 'ihc'), 'payments');
						//$plan['trial_period_days'] = $trial_period_days;
						$trial_end = strtotime("+ ".$trial_period_days." days");
					}

					$return_data_plan = \Stripe\Plan::create($plan);
					try {
							$return_data_plan = \Stripe\Plan::create($plan);
					} catch (Exception $e){
							//Ihc_User_Logs::write_log( __('Stripe Payment: Plan Error:', 'ihc') . $e, 'payments');
					}

					//$customer_arr['plan'] = $ihc_plan_code;


					try {
							$customer = \Stripe\Customer::create($customer_arr);
					} catch (Exception $e){
							return false;
					}


					$resource =  \Stripe\Subscription::create(array(
						"customer" 				=> $customer->id,
						'items' 					=> [['plan' => $return_data_plan->id]],
						"trial_end" 			=> $trial_end,
					));
					//end of reccurence
				}else{
					try {
							$customer = \Stripe\Customer::create($customer_arr);
					} catch (Exception $e){
							return false;
					}
				}

				Ihc_User_Logs::write_log( __('Stripe Payment: amount set @ ', 'ihc') . $amount . $this->currency, 'payments');

				$sub_id = '';
				if ($reccurrence){
					/// RECCURRING PAYMENT
					$plan = \Stripe\Plan::retrieve($ihc_plan_code);
					//$plan->delete();//delete the plan
					if ( isset( $resource->id ) ){
						$sub_id = $resource->id;
					}
				} else {
					/// SINGLE PAYMENT
					try {
    					$charge = \Stripe\Charge::create(array(
																		'customer' => $customer->id,
																		'amount'   => $amount,
																		'currency' => $this->currency,
							));
					    $success = 1;
					    $paymentProcessor="Credit card (www.stripe.com)";
					} catch (Exception $e) {
							$error1 = $e->getMessage();
							$cardError = true;
					}
					/*
					$charge = \Stripe\Charge::create(array(
							'customer' => $customer->id,
							'amount'   => $amount,
							'currency' => $this->currency,

					));
					*/
				}

				$amount = $amount / $this->multiply;
				$response_return = array(
						'amount' => urlencode($amount),
						'currency' => $this->currency,
						'level' => $post_data['lid'],
						'item_name' => $this->level_data[$post_data['lid']]['name'],
						'customer' => $customer->id,
				);
				if ( !empty( $cardError ) ){
						$response_return[ 'cardErrors' ] = true;
				}
				if ($sub_id){
					$response_return['subscription'] = $sub_id;
				}

				if (!empty($insert_order)){
					$saved_amount = $amount;

					//v.7.1. - Payments from account page for Recurring Levels with Trial or Coupons 100%
					if(!empty($trial_period_days) && $trial_period_days > 0)
						$saved_amount = 0;
					ihc_insert_update_order($post_data['uid'], $post_data['lid'], $saved_amount, 'pending', 'stripe', $order_extra_metas);
				}

				if ($reccurrence && isset($customer->id)){
					//$response_return['message'] = "success";
					Ihc_User_Logs::write_log( __('Stripe Payment: Successfully Finish the payment.', 'ihc'), 'payments');
					$response_return['message'] = "pending";
					$response_return['trans_id'] = $customer->id;
				} else if (!empty($charge) && $charge->paid) {
					//$response_return['message'] = "success";
					Ihc_User_Logs::write_log( __('Stripe Payment: Successfully Finish the payment.', 'ihc'), 'payments');
					$response_return['message'] = "pending";
					$response_return['trans_id'] = $charge->customer;
				} else {
					Ihc_User_Logs::write_log( __('Stripe Payment: Error.', 'ihc'), 'payments');
					$response_return['message'] = "error";
				}

				return $response_return;
			}
		}

		public function cancel_subscription($transaction_id=''){
			/*
			 * @param string (txn_id)
			 * @return none
			 */
			if ($transaction_id){
				global $wpdb;
				$q = $wpdb->prepare("SELECT payment_data FROM " . $wpdb->prefix . "indeed_members_payments WHERE txn_id=%s ", $transaction_id);
				$data = $wpdb->get_row($q);
				$arr = json_decode($data->payment_data, TRUE);
				if (!empty($arr['customer']) && !empty($arr['subscription'])){
					$customer = \Stripe\Customer::retrieve($arr['customer']);
					if ($customer){
						if (isset($customer->subscriptions) && !empty($customer->subscriptions->data)){
							foreach ($customer->subscriptions->data as $k=>$temp_obj){
								if (!empty($temp_obj->id) && $temp_obj->id==$arr['subscription']){
									$it_exists = TRUE;
									break;
								}
							}
							if ($it_exists){
								@$subscription = $customer->subscriptions->retrieve($arr['subscription']);
								if (!empty($subscription)){
									try {
										@$value = $subscription->cancel();
									} catch (Stripe\Error\InvalidRequest $e){}
									return $value;
								}
							}
						}

					}
				}
			}
		}

	}//end of class ihcStripe

}
