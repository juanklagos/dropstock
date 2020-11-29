<?php
function ihc_post_metas($post_id, $return_name=FALSE){
	/*
	 * @param int, bool
	 * @return array
	 */
	$arr = array(
					'ihc_mb_type' 										=> 'show',
					'ihc_mb_who' 											=> '',
					'ihc_mb_block_type' 							=> 'redirect',
					'ihc_mb_redirect_to' 							=> -1,
					'ihc_replace_content' 						=> '',
					//DRIP CONTENT
					'ihc_drip_content' 								=> 0,
					'ihc_drip_start_type' 						=> 1,
					'ihc_drip_end_type' 							=> 1,
					'ihc_drip_start_numeric_type' 		=> 'days',
					'ihc_drip_start_numeric_value' 		=> '',
					'ihc_drip_end_numeric_type' 			=> 'days',
					'ihc_drip_end_numeric_value' 			=> '',
					'ihc_drip_start_certain_date' 		=> '',
					'ihc_drip_end_certain_date' 			=> '',
	);

	$arr = apply_filters( 'ihc_filter_post_meta', $arr );

	if($return_name==TRUE) return $arr;
	foreach($arr as $k=>$v){
		$data = get_post_meta($post_id, $k, true);
		if( $data!==FALSE && $data!='' )
			$arr[$k] = $data;
	}
	return $arr;
}

function ihc_get_all_pages(){
	/*
	 * @param none
	 * @return array
	 */
	$arr = array();
	$args = array(
			'sort_order' => 'ASC',
			'sort_column' => 'post_title',
			'hierarchical' => 1,
			'child_of' => 0,
			'parent' => -1,
			'number' => '',
			'offset' => 0,
			'post_type' => 'page',
			'post_status' => 'publish'
	);
	$pages = get_pages($args);
	if (isset($pages) && count($pages)>0){
		foreach ($pages as $page){
			if ($page->post_title=='') $page->post_title = '(no title)';
			$arr[$page->ID] = $page->post_title;
		}
	}
	return $arr;
}


function ihc_locker_meta_keys(){
	/*
	 * @param none
	 * @return array
	 */
	//meta keys for ihc_lockers
	$arr = array(
					'ihc_locker_name' => 'Untitled Locker',
					'ihc_locker_custom_content' => '<h2>This content is locked</h2>
													Login To Unlock The Content!',
					'ihc_locker_custom_css' => '.ihc-locker-wrap{}',
					'ihc_locker_template' => '',
					'ihc_locker_login_template' => '',
					'ihc_locker_login_form' => 1,
					'ihc_locker_additional_links' => 1,
					'ihc_locker_display_sm' => 0,
				 );
	return $arr;
}

function ihc_return_meta($name, $id=false){
	/*
	 * @param string, string|bool
	 * @return ...
	 */
	$data = get_option($name);
	if ($data!==FALSE){
		if($data && isset($data[$id])) return $data[$id];
		return $data;
	}
	else return FALSE;
}

function ihc_return_meta_arr($type, $only_name=false, $return_default=false){
	/*
	 * @param string, bool, bool
	 * @return array
	 */
	//all metas
	switch ($type){
		case 'payment':
			$arr = array(
							'ihc_currency' 								=> 'USD',
							'ihc_currency_position' 			=> 'right',
							'ihc_num_of_decimals'					=> 2,
							'ihc_decimals_separator'			=> '.',
							'ihc_thousands_separator'			=> ',',
							'ihc_custom_currency_code' 		=> '',
							'ihc_payment_set' 						=> 'predefined',
							'ihc_payment_selected' 				=> 'bank_transfer',
							'ihc_payment_logs_on' 				=> 0,
							'ihc_payment_workflow'				=> 'new',
						);
		break;
		case 'payment_paypal':
			$arr = array(
							'ihc_paypal_email' => '',
							'ihc_paypal_sandbox' => 0,
							'ihc_paypal_return_page' => -1,
							'ihc_paypal_return_page_on_cancel'	=> -1,
							'ihc_paypal_status' => 0,
							'ihc_paypal_label' => 'PayPal',
							'ihc_paypal_select_order' => 1,
							/*developer */
							'ihc_paypal_short_description' => '',
							/*end developer*/
							'ihc_paypal_merchant_account_id' => '',
							'ihc_paypapl_locale_code' => 'en_US',
						);
		break;
		case 'payment_stripe':
			$arr = array(
							'ihc_stripe_secret_key' => '',
							'ihc_stripe_publishable_key' => '',
							'ihc_stripe_status' => 0,
							'ihc_stripe_label' => 'Stripe',
							'ihc_stripe_select_order' => 2,
							'ihc_stripe_short_description' => '',
							'ihc_stripe_locale_code' => 'en',
							'ihc_stripe_popup_image' => '',
							'ihc_stripe_bttn_value' => '',
			);
		break;
		case 'payment_authorize':
			$arr = array(
							'ihc_authorize_login_id' => '',
							'ihc_authorize_transaction_key' => '',
							'ihc_authorize_sandbox' => 0,
							'ihc_authorize_status' => 0,
							'ihc_authorize_label' => 'Authorize',
							'ihc_authorize_select_order' => 3,
							'ihc_authorize_short_description' => ''
			);
		break;
		case 'payment_twocheckout':
			$arr = array(
							'ihc_twocheckout_status' => 0,
							'ihc_twocheckout_sandbox' => 0,
							'ihc_twocheckout_api_user' => '',
							'ihc_twocheckout_api_pass' => '',
							'ihc_twocheckout_private_key' => '',
							'ihc_twocheckout_account_number' => '',
							'ihc_twocheckout_secret_word' => '',
							'ihc_twocheckout_return_url'	=> -1,
							'ihc_twocheckout_label' => '2Checkout',
							'ihc_twocheckout_select_order' => 4,
							'ihc_twocheckout_short_description' => ''
			);
		break;
		case 'payment_bank_transfer':
			$arr = array(
					'ihc_bank_transfer_status' => 1,
					'ihc_bank_transfer_message' => '<p>Hi {username},</p>
<br/>
<p>Please proceed the bank transfer payment for: {currency}{amount}</p>

<p><strong>Payment Details:</strong> Subscription {level_name} for {username} with Identification: {user_id}_{level_id}</p>

<br/>

<strong>Bank Details:</strong><br/>

IBAN:xxxxxxxxxxxxxxxxxxxx<br/>

Bank NAME<br/>',
					'ihc_bank_transfer_label' => 'Bank Transfer',
					'ihc_bank_transfer_select_order' => 5,
					'ihc_bank_transfer_short_description' => ''
			);
		break;
		case 'payment_braintree':
			$arr = array(
					'ihc_braintree_status' => 0,
					'ihc_braintree_sandbox' => 0,
					'ihc_braintree_merchant_id' => '',
					'ihc_braintree_public_key' => '',
					'ihc_braintree_private_key' => '',
					'ihc_braintree_label' => 'Braintree',
					'ihc_braintree_select_order' => 6,
					'ihc_braintree_short_description' => ''
			);
			break;
		case 'payment_mollie':
			$arr = array(
					'ihc_mollie_status' 					=> 0,
					'ihc_mollie_api_key' 					=> '',
					'ihc_mollie_label' 						=> 'Mollie',
					'ihc_mollie_select_order' 		=> 8,
					'ihc_mollie_short_description' => '',
					'ihc_mollie_return_page'			=> -1,
			);
			break;
		case 'payment_paypal_express_checkout':
			$arr = array(
						'ihc_paypal_express_checkout_status' 						=> 0,
						'ihc_paypal_express_checkout_label' 						=> 'PayPal Express Checkout',
						'ihc_paypal_express_checkout_signature'					=> '',
						'ihc_paypal_express_checkout_user'							=> '',
						'ihc_paypal_express_checkout_password'					=> '',
						'ihc_paypal_express_checkout_sandbox' 					=> 0,
						'ihc_paypal_express_checkout_select_order' 			=> 9,
						'ihc_paypal_express_short_description'					=> '',
						'ihc_paypal_express_return_page'								=> -1,
						'ihc_paypal_express_return_page_on_cancel'			=> -1,
			);
			break;
		case 'payment_pagseguro':
			$arr = array(
						'ihc_pagseguro_status' 						=> 0,
						'ihc_pagseguro_label' 						=> 'Pagseguro',
						'ihc_pagseguro_email'							=> '',
						'ihc_pagseguro_token'							=> '',
						'ihc_pagseguro_select_order' 			=> 9,
						'ihc_pagseguro_short_description' => '',
						'ihc_pagseguro_sandbox' 					=> 0,
			);
			break;
		case 'payment_stripe_checkout_v2':
			$arr = array(
						'ihc_stripe_checkout_v2_secret_key'					=> '',
						'ihc_stripe_checkout_v2_publishable_key'		=> '',
						'ihc_stripe_checkout_v2_status'							=> 0,
						'ihc_stripe_checkout_v2_select_order' 			=> 11,
						'ihc_stripe_checkout_v2_short_description' => '',
						'ihc_stripe_checkout_v2_locale_code' 				=> 'en',
						'ihc_stripe_checkout_v2_label' 							=> 'Stripe Checkout',
						'ihc_stripe_checkout_v2_success_page'				=> -1,
						'ihc_stripe_checkout_v2_cancel_page'				=> -1,
						'ihc_stripe_checkout_v2_use_user_email'			=> 0,
			);
			break;
		case 'login':
			$arr = array(
						   'ihc_login_remember_me' => 1,
						   'ihc_login_register' => 1,
						   'ihc_login_pass_lost' => 1,
						   'ihc_login_template' => 'ihc-login-template-11',
						   'ihc_login_custom_css' => '',
						   'ihc_login_show_sm' => 0,
						   'ihc_login_show_recaptcha' => 0,
						);
		break;
		case 'login-messages':
			$arr = array(
							'ihc_login_succes' => 'Welcome on our Website!',
							'ihc_login_pending' => 'Your account was not been approved yet. Please, try again later',
							'ihc_social_login_failed' => 'You are not registered with this social network. Please register first!',
							'ihc_login_error' => 'Invalid Email Address or Password entered',
							'ihc_reset_msg_pass_err' => 'Invalid Email Address or Username entered',
							'ihc_reset_msg_pass_ok' => 'A new password has been sent to your email address',
							'ihc_login_error_email_pending' => 'E-mail address has not been verified yet',
							'ihc_login_error_on_captcha' => 'Captcha Error',
							'ihc_login_error_ajax' => 'Please complete all required fields!',
						);
		break;
		case 'general-defaults':
			$arr = array(
							//default pages
							'ihc_general_login_default_page' => '',
							'ihc_general_register_default_page'=>'',
							'ihc_general_lost_pass_page' => '',
							'ihc_general_logout_page' => '',
							'ihc_general_user_page' => '',
							'ihc_general_tos_page' => '',
							'ihc_subscription_plan_page' => '',
							'ihc_general_register_view_user' => '',
							//redirects
							'ihc_general_redirect_default_page' => '',
							'ihc_general_logout_redirect' => '',
							'ihc_general_register_redirect' => '',
							'ihc_general_login_redirect' => '',
							'ihc_general_password_redirect' => '',
							/// prevent listing hidden post, pages
							'ihc_listing_show_hidden_post_pages' => 0,
						);
		break;
		case 'general-captcha':
			//recapcha
			$arr = array(
							'ihc_recaptcha_version'							=> 'v2',
							'ihc_recaptcha_public' 							=> '',
							'ihc_recaptcha_private' 						=> '',
							'ihc_recaptcha_public_v3'						=> '',
							'ihc_recaptcha_private_v3'					=> '',
			);
		break;
		case 'general-subscription':
			$arr = array(
							'ihc_level_template' => 'ihc_level_template_5',
							'ihc_select_level_custom_css' => '.ich_level_wrap{}',
						);
		break;
		case 'general-msg':
			$arr = array(
							'ihc_general_update_msg' => 'Successfully Update!',
						);
		break;
		case 'register':
			$arr = array(
							'ihc_register_template' => 'ihc-register-9',
							'ihc_register_admin_notify' => 1,
							'ihc_register_pass_min_length' => 6,
							'ihc_register_pass_options' => 1,
							'ihc_register_new_user_level' => -1,//'none'
							'ihc_register_new_user_role' => 'subscriber',
							'ihc_register_custom_css' => '',
							'ihc_register_terms_c' => 'Accept our Terms&Conditions',
							'ihc_subscription_type' => 'subscription_plan',
							'ihc_register_opt-in' => 0,
							'ihc_register_opt-in-type' => 'email_list',
							'ihc_register_show_level_price' => 1,
							'ihc_register_auto_login' => 0,
							'ihc_register_double_email_verification' => 0,
							'ihc_automatically_switch_role' => 0,
							'ihc_automatically_new_role' => 'subscriber',
						);
		break;
		case 'register-msg':
			$arr = array(
							//messages
							'ihc_register_username_taken_msg' => 'Username is taken',
							'ihc_register_error_username_msg' => 'Invalid Username',
							'ihc_register_email_is_taken_msg' => 'Email address is taken',
							'ihc_register_invalid_email_msg' => 'You must enter a valid Email Address.',
							'ihc_register_emails_not_match_msg' => 'Email Addresses do not match!',
							'ihc_register_pass_not_match_msg' => 'Password do not match',
							'ihc_register_pass_letter_digits_msg' => 'Password must contains characters and digits!',
							'ihc_register_pass_let_dig_up_let_msg' => 'Password must contains characters, digits and minimum one uppercase letter!',
							'ihc_register_pass_min_char_msg' => 'Password must contains minimum {X} characters!',
							'ihc_register_pending_user_msg' => 'Your Account has not been approved yet. Please try again later!',
							'ihc_register_err_req_fields' => 'Please complete all required fields!',
							'ihc_register_err_recaptcha' => 'Captcha Error',
							'ihc_register_err_tos' => 'Error On Terms & Conditions',
							'ihc_register_success_meg' => '<h4>Successfully Register!</h4>
<br/>',
							'ihc_register_update_msg' => 'Successfully Updated!',
							'ihc_register_unique_value_exists' => 'This value already exists.',
						);
		break;
		case 'register-custom-fields':
			$arr = array(
							'ihc_user_fields' => ihc_native_user_field(),
						);
		break;
		case 'opt_in':
			$arr = array(
							'ihc_main_email' => '',
							//aweber
							'ihc_aweber_auth_code' => '',
							'ihc_aweber_list' => '',
							'ihc_aweber_consumer_key' => '',
							'ihc_aweber_consumer_secret' => '',
							'ihc_aweber_acces_key' => '',
							'ihc_aweber_acces_secret' => '',
							//mailchimp
							'ihc_mailchimp_api' => '',
							'ihc_mailchimp_id_list' => '',
							//get response
							'ihc_getResponse_api_key' => '',
							'ihc_getResponse_token' => '',
							//campaign monitor
							'ihc_cm_api_key' => '',
							'ihc_cm_list_id' => '',
							//icontact
							'ihc_icontact_user' => '',
							'ihc_icontact_appid' => '',
							'ihc_icontact_pass' => '',
							'ihc_icontact_list_id' => '',
							//constant contact
							'ihc_cc_user' => '',
							'ihc_cc_pass' => '',
							'ihc_cc_list' => '',
							//Wysija Contact
							'ihc_wysija_list_id' => '',
							//MyMail
							'ihc_mymail_list_id' => '',
							//Mad Mimi
							'ihc_madmimi_username' => '',
							'ihc_madmimi_apikey' => '',
							'ihc_madmimi_listname' => '',
							//indeed email list
							'ihc_email_list' => '',
							// active campaign
							'ihc_active_campaign_apiurl' => '',
							'ihc_active_campaign_apikey' => '',
							'ihc_active_campaign_listId' => '',
						);
		break;
		case 'notifications':
			$arr = array(
							'ihc_notification_email_from' => '',
							'ihc_notification_before_time' => 5,
							'ihc_notification_before_time_second' => 3,
							'ihc_notification_before_time_third' => 1,
							'ihc_notification_name' => '',
							'ihc_notification_email_addresses' => '',
						);
		break;
		case 'extra_settings':
			$arr = array(
							'ihc_grace_period' => '',
							'ihc_debug_payments_db' => '',
							'ihc_upload_extensions' => 'txt,doc,pdf,jpg,jpeg,png,gif,mp3,zip',
							'ihc_upload_max_size' => 5,
							'ihc_avatar_max_size' => 1,
						);
			break;
		case 'account_page':
			$arr = array(	'ihc_ap_theme' => 'ihc-ap-theme-3',
							'ihc_ap_edit_show_avatar' => 1,
							'ihc_ap_edit_show_level' => 1,
							'ihc_ap_tabs' => 'overview,profile,subscription,logout,help,transactions,orders,social',
							'ihc_ap_welcome_msg' => '<span class="iump-user-page-mess-special">Hello</span> <span class="iump-user-page-mess-special"> {last_name} {first_name}</span>,
														<span class="iump-user-page-mess">You are logged as</span><span class="iump-user-page-mess-special"> {username}</span>
														<div class="iump-user-page-mess"><span>{flag}</span>Member since {user_registered}</div>
														',
							'ihc_account_page_custom_css' => '',
							'ihc_ap_social_plus_message' => '',

							'ihc_ap_overview_menu_label' => 'Dashboard',
							'ihc_ap_overview_title' => 'Dashboard',
							'ihc_ap_overview_msg' => '<p>Welcome to our Membership platform. Check for valuable content and sign to our Subscriptions.</p><p>From Membership dashboard you may manage <strong>your Subscriptions</strong>, check <strong>recent orders</strong> or edit your <strong>account details</strong>.</p>',
							'ihc_ap_overview_icon_class' => '',
							'ihc_ap_overview_icon_code' => 'f015',
							'ihc_ap_profile_menu_label' => 'Profile Details',
							'ihc_ap_profile_title' => 'Edit your Account',
							'ihc_ap_profile_msg' => '',
							'ihc_ap_profile_icon_class' => '',
							'ihc_ap_profile_icon_code' => 'f007',
							'ihc_ap_subscription_menu_label' => 'Subscriptions',
							'ihc_ap_subscription_title' => '',
							'ihc_ap_subscription_msg' => '',
							'ihc_ap_subscription_icon_class' => '',
							'ihc_ap_subscription_icon_code' => 'f0a1',
							'ihc_ap_subscription_table_enable' => 1,
							'ihc_ap_subscription_plan_enable' => 1,
							'ihc_ap_social_menu_label' => 'Social Plus',
							'ihc_ap_social_title' => 'Social Plus',
							'ihc_ap_social_icon_class' => '',
							'ihc_ap_social_icon_code' => 'f0e6',
							'ihc_ap_social_msg' => '',
							'ihc_ap_transactions_menu_label' => 'Transactions',
							'ihc_ap_transactions_title' => 'Transactions',
							'ihc_ap_transactions_msg' => '',
							'ihc_ap_transactions_icon_class' => '',
							'ihc_ap_transactions_icon_code' => 'f155',
							'ihc_ap_orders_menu_label' => 'Orders',
							'ihc_ap_orders_title' => 'Orders',
							'ihc_ap_orders_msg' => '',
							'ihc_ap_orders_icon_class' => '',
							'ihc_ap_orders_icon_code' => 'f0d6',
							'ihc_ap_membeship_gifts_menu_label' => 'Membership Gifts',
							'ihc_ap_membeship_gifts_title' => 'Membership Gifts',
							'ihc_ap_membeship_gifts_msg' => '[ihc-list-gifts]',
							'ihc_ap_membeship_gifts_icon_class' => '',
							'ihc_ap_membeship_gifts_icon_code' => 'f06b',
							'ihc_ap_membership_cards_menu_label' => 'Membership Cards',
							'ihc_ap_membership_cards_title' => 'Membership Cards',
							'ihc_ap_membership_cards_msg' => '[ihc-membership-card]',
							'ihc_ap_membership_cards_icon_class' => '',
							'ihc_ap_membership_cards_icon_code' => 'f022',
							'ihc_ap_help_menu_label' => 'Help',
							'ihc_ap_help_title' => 'Help',
							'ihc_ap_help_msg' => 'If you have any question or need help please do not hesitate to contact us.',
							'ihc_ap_help_icon_class' => '',
							'ihc_ap_help_icon_code' => 'f059',
							'ihc_ap_pushover_notifications_menu_label' => 'Pushover Notifications',
							'ihc_ap_pushover_notifications_title' => 'Pushover Notifications',
							'ihc_ap_pushover_notifications_msg' => '',
							'ihc_ap_pushover_notifications_icon_class' => '',
							'ihc_ap_pushover_notifications_icon_code' => 'f0f3',
							'ihc_ap_logout_menu_label' => 'LogOut',
							'ihc_ap_logout_icon_class' => '',
							'ihc_ap_logout_icon_code' => 'f08b',
							'ihc_ap_affiliate_icon_class' => '',
							'ihc_ap_affiliate_icon_code' => 'f0e8',

							'ihc_ap_user_sites_label' => 'Your Sites',
							'ihc_ap_user_sites_title' => 'Your Sites',
							'ihc_ap_user_sites_icon_code' => 'f0e8',
							'ihc_ap_user_sites_icon_class' => '',
							'ihc_ap_user_sites_msg' => '',

							'ihc_ap_footer_msg' => '',
							'ihc_ap_top_background_image' => '',
							'ihc_ap_edit_background' => 1,
							'ihc_ap_top_template' => 'ihc-ap-top-theme-4',
							'ihc_ap_edit_show_level' => 1,
					);
			break;
		case 'fb':
			$arr = array(
							'ihc_fb_app_id' => '',
							'ihc_fb_app_secret' => '',
							'ihc_fb_status' => 0,
						);
			break;
		case 'tw':
			$arr = array(
							'ihc_tw_app_key' => '',
							'ihc_tw_app_secret' => '',
							'ihc_tw_status' => 0,
			);
			break;
		case 'in':
			$arr = array(
							'ihc_in_app_key' => '',
							'ihc_in_app_secret' => '',
							'ihc_in_status' => 0,
			);
			break;
		case 'tbr':
			$arr = array(
							'ihc_tbr_app_key' => '',
							'ihc_tbr_app_secret' => '',
							'ihc_tbr_status' => 0,
			);
			break;
		case 'ig':
				$arr = array(
					'ihc_ig_app_id' => '',
					'ihc_ig_app_secret' => '',
					'ihc_ig_status' => 0,
				);
			break;
		case 'vk':
				$arr = array(
					'ihc_vk_app_id' => '',
					'ihc_vk_app_secret' => '',
					'ihc_vk_status' => 0,
				);
			break;
		case 'goo':
				$arr = array(
					'ihc_goo_app_id' => '',
					'ihc_goo_app_secret' => '',
					'ihc_goo_status' => 0,
				);
			break;
		case 'social_media':
			$arr = array(
							"ihc_sm_template" => "ihc-sm-template-1",
							"ihc_sm_custom_css" => ".ihc-sm-wrapp-fe{}",
							"ihc_sm_show_label" => 1,
							'ihc_sm_top_content' => '<div class="ihc-top-social-login"> - OR - </div>',
							'ihc_sm_bottom_content' => '',
						);
			break;
		case 'double_email_verification':
			$arr = array(
							'ihc_double_email_expire_time' => -1,
							'ihc_double_email_redirect_success' => '',
							'ihc_double_email_redirect_error' => '',
							'ihc_double_email_delete_user_not_verified' => -1,
						);
			break;
		case 'licensing':
			$arr = array(
							'ihc_license_set' => 0,
							'ihc_envato_code' => '',
						);
			break;
		case 'listing_users':
			$arr = array(
							'ihc_listing_users_custom_css' => '',
							'ihc_listing_users_responsive_small' => 1,
							'ihc_listing_users_responsive_medium' => 2,
							'ihc_listing_users_responsive_large' => 0,
							'ihc_listing_users_target_blank' => 0,
						);
			break;
		case 'listing_users_inside_page':
			$arr = array(
							'ihc_listing_users_inside_page_content' => '<div class="iump-user-page-avatar">
<img src="{AVATAR_HREF}" />
</div>
<div class="ihc-account-page-top-mess">
<p><span class="iump-user-page-name"> {first_name} {last_name}</span>,</p>
<p><span class="iump-user-page-mess">Username:</span><span class="iump-user-page-mess-special"> {username}</span>
</p>
<p><span class="iump-user-page-mess">and his/her awesome e-mail address is : <strong>{user_email}</strong></span></p>
{IHC_SOCIAL_MEDIA_LINKS}
</div>
<div class="iump-clear"></div>',
							'ihc_listing_users_inside_page_custom_css' => '.ihc-public-wrapp-visitor-user{

}',
							'ihc_listing_users_inside_page_type' => 'basic',
							'ihc_listing_users_inside_page_show_avatar' => 1,
							'ihc_listing_users_inside_page_show_level' => 1,
							'ihc_listing_users_inside_page_show_banner' => 1,
							'ihc_listing_users_inside_page_show_since' => 1,
							'ihc_listing_users_inside_page_show_name' => 1,
							'ihc_listing_users_inside_page_show_username' => 1,
							'ihc_listing_users_inside_page_show_email' => 1,
							'ihc_listing_users_inside_page_show_website' => 1,
							'ihc_listing_users_inside_page_show_flag' => 1,
							'ihc_listing_users_inside_page_show_custom_fields' => '',
							'ihc_listing_users_inside_page_extra_custom_content' => '',
							'ihc_listing_users_inside_page_color_scheme' => '',
							'ihc_listing_users_inside_page_template' => 'template-1',
							'ihc_listing_users_inside_page_banner_href' => '',
			);
			break;
		case 'affiliate_options':
			$arr = array(
							'ihc_ap_show_aff_tab' => 0,
							'ihc_ap_aff_msg' => '[uap-user-become-affiliate]',
			);
			break;
		case 'ihc_taxes_settings':
			$arr = array(
							'ihc_enable_taxes' => 0,
							'ihc_show_taxes' => 0,
							'ihc_default_tax_label' => '',
							'ihc_default_tax_value' => 0,
			);
			break;
		case 'admin_workflow':
			$arr = array(
							'ihc_admin_workflow_dashboard_notifications'  => 1,
							'ihc_debug_payments_db' 											=> '',
							'ihc_order_prefix_code' 											=> 'IUMP',
							'ihc_keep_data_after_delete'									=> 0,
							'ihc_wp_login_custom_css'											=> 1,
							'ihc_wp_login_logo_image'											=> '',
			);
			break;
		case 'public_workflow':
			$arr = array(
							'ihc_listing_show_hidden_post_pages' 	=> 0,
							'ihc_grace_period' 										=> '',
							'ihc_use_gravatar' 										=> 1,
							'ihc_use_buddypress_avatar' 					=> 0,
							'ihc_email_blacklist' 								=> '',
							'ihc_default_country'									=> 'US',
			);
			break;
		case 'ihc_woo':
			$arr = array(
							'ihc_woo_account_page_enable' => 0,
							'ihc_woo_account_page_name' => '',
							'ihc_woo_account_page_menu_position' => 5,
			);
			break;
		case 'ihc_bp':
			$arr = array(
							'ihc_bp_account_page_enable' => 0,
							'ihc_bp_account_page_name' => '',
							'ihc_bp_account_page_position' => 5,
			);
			break;
		case 'ihc_membership_card':
			$arr = array(
							'ihc_membership_card_enable' => 0,
							'ihc_membership_card_image' => IHC_URL . 'assets/images/default-logo.png',
							'ihc_membership_card_size' => 'ihc-membership-card-medium',
							'ihc_membership_card_template' => 'ihc-membership-card-2',
							'ihc_membership_member_since_enable' => 1,
							'ihc_membership_member_since_label' => __('Member Since: ', 'ihc'),
							'ihc_membership_member_level_label' => __('Level: ', 'ihc'),
							'ihc_membership_member_level_expire' => 1,
							'ihc_membership_member_level_expire_label' => __('Level Expire Date: ', 'ihc'),
							'ihc_membership_member_show_uid' => 0,
							'ihc_membership_member_uid_label' => __('User Id', 'ihc'),
							'ihc_membership_card_custom_css' => '.ihc-membership-card-wrapp{}',
							'ihc_membership_card_exclude_levels' => '',
			);
			break;
		case 'ihc_cheat_off':
			$arr = array(
							'ihc_cheat_off_enable' => 0,
							'ihc_cheat_off_cookie_time' => 365,
							'ihc_cheat_off_redirect' => '',
			);
			break;
		case 'ihc_invitation_code':
			$arr = array(
							'ihc_invitation_code_enable' => 0,
							'ihc_invitation_code_err_msg' => __('Your Invitation Code is wrong.', 'ihc'),
			);
			break;
		case 'download_monitor_integration':
			$arr = array(
							'ihc_download_monitor_enabled' => 0,
							'ihc_download_monitor_limit_type' => 'files',
							'ihc_download_monitor_values' => '',
			);
			break;
		case 'register_lite':
			$arr = array(
							'ihc_register_lite_enabled' => 0,
							'ihc_register_lite_template' => 'ihc-register-3',
							'ihc_register_lite_custom_css' => '',
							'ihc_register_lite_opt_in' => 0,
							'ihc_register_lite_opt_in_type' => '',
							'ihc_register_lite_double_email_verification' => '',
							'ihc_register_lite_user_role' => 'subscriber',
							'ihc_register_lite_auto_login' => 1,
							'ihc_register_lite_redirect' => '',
			);
			break;
		case 'individual_page':
			$arr = array(
							'ihc_individual_page_enabled' => 0,
							'ihc_individual_page_parent' => -1,
							'ihc_individual_page_default_content' => '',
							'ihc_individual_page_title' => 'IUMP Individual Page: {username}',
							'ihc_individual_page_slug_prefix' => 'iump_individual_page_',
			);
			break;
		case 'level_restrict_payment':
			$arr = array(
							'ihc_level_restrict_payment_enabled' => 0,
							'ihc_levels_default_payments' => '',
							'ihc_level_restrict_payment_values' => '',
			);
			break;
		case 'level_subscription_plan_settings':
			$arr = array(
							'ihc_level_subscription_plan_settings_enabled' => 0,
							'ihc_show_renew_link' => 1,
							'ihc_show_delete_link' => 1,
							'ihc_level_subscription_plan_settings_restr_levels' => '',
							'ihc_level_subscription_plan_settings_condt' => '',
			);
			break;
		case 'gifts':
			$arr = array(
							'ihc_gifts_enabled' => 0,
							'ihc_gifts_user_get_multiple_on_recurring' => 0,
			);
			break;
		case 'login_level_redirect':
			$arr = array(
							'ihc_login_level_redirect_on' => 0,
							'ihc_login_level_redirect_rules' => '',
							'ihc_login_level_redirect_priority' => '',
			);
			break;
		case 'register_redirects_by_level':
			$arr = array(
							'ihc_register_redirects_by_level_enable' => 0,
							'ihc_register_redirects_by_level_rules' => '',
			);
			break;
		case 'wp_social_login':
			$arr = array(
							'ihc_wp_social_login_on' => 0,
							'ihc_wp_social_login_redirect_page' => '',
							'ihc_wp_social_login_default_role' => '',
							'ihc_wp_social_login_default_level' => '',
			);
			break;
		case 'list_access_posts':
			$arr = array(
							'ihc_list_access_posts_on' => 0,
							'ihc_list_access_posts_title' => '',
							'ihc_list_access_posts_item_details' => 'post_title',
							'ihc_list_access_posts_custom_css' => '.iump-list-access-posts-wrapp{}',
							'ihc_list_access_posts_order_by' => 'post_date',
							'ihc_list_access_posts_order_type' => 'DESC',
							'ihc_list_access_posts_template' => '',
							'ihc_list_access_posts_order_limit' => '',
							'ihc_list_access_posts_per_page_value' => 25,
							'ihc_list_access_posts_order_post_type' => 'post,page',
							'ihc_list_access_posts_order_exclude_levels' => '',
			);
			break;
		case 'invoices':
			$arr = array(
							'ihc_invoices_on' => 0,
							'ihc_invoices_only_completed_payments' => 0,
							'ihc_invoices_company_field' => '<div><b>Your CompanyName LLC</b></div>
<div>Unique Code: #99991239</div>
<div>Company Address: Your Email Address</div>',
							'ihc_invoices_bill_to' => '<div><b>Bill to</b></div>
<div><b>Name: </b>{first_name} {last_name} </div>
<div><b>E-mail: </b>{user_email} </div>
<div><b>Address: </b>{CUSTOM_FIELD_addr1}</div>',
							'ihc_invoices_title' => 'Your Order Invoice',
							'ihc_invoices_template' => '',
							'ihc_invoices_logo' => IHC_URL . 'assets/images/default-logo1.png',
							'ihc_invoices_custom_css' => '',
							'ihc_invoices_footer' => 'If you have any questions about this Invoice, please contact us!',
			);
			break;
		case 'woo_payment':
			$arr = array(
							'ihc_woo_payment_on' => 0,
			);
			break;
		case 'badges':
			$arr = array(
							'ihc_badges_on' => 0,
							'ihc_badge_custom_css' => '.iump-badge-wrapper .iump-badge {
    width: 50px;
}',
			);
			break;
		case 'login_security':
			$arr = array(
							'ihc_login_security_on' => 0,
							'ihc_login_security_allowed_retries' => 3,
							'ihc_login_security_lockout_time' => 15,
							'ihc_login_security_max_lockouts' => 3,
							'ihc_login_security_extended_lockout_time' => 24,
							'ihc_login_security_reset_retries' => 24,
							'ihc_login_security_notify_admin' => 2,
							'ihc_login_security_black_list' => '',
							'ihc_login_security_lockout_attempt_message' => __('You have {number} login attempts remain.', 'ihc'),
							'ihc_login_security_lockout_message' => __('Login Form is locked for 15 minutes.', 'ihc'),
							'ihc_login_security_extended_lockout_message' => __('You have made too many failed login attempts. Login Form will be locked for 24 hours.', 'ihc'),
			);
			break;
		case 'workflow_restrictions':
			$arr = array(
							'ihc_workflow_restrictions_on' => 0,
							'ihc_workflow_restrictions_timelimit' => 30,
							'ihc_workflow_restrictions_post_views' => array(),
							'ihc_workflow_restrictions_posts_created' => array(),
							'ihc_workflow_restrictions_comments_created' => array(),
			);
			break;
		case 'subscription_delay':
			$arr = array(
							'ihc_subscription_delay_on' => 0,
							'ihc_subscription_delay_time' => array(),
							'ihc_subscription_delay_type' => array(),
			);
			break;
		case 'level_dynamic_price':
			$arr = array(
							'ihc_level_dynamic_price_on' => 0,
							'ihc_level_dynamic_price_step' => 0.01,
							'ihc_level_dynamic_price_levels_on' => 0,
							'ihc_level_dynamic_price_levels_min' => array(),
							'ihc_level_dynamic_price_levels_max' => array(),
			);
			break;
		case 'user_reports':
			$arr = array('ihc_user_reports_enabled'=>0);
			break;
		case 'pushover':
			$arr = array(
							'ihc_pushover_enabled' => 0,
							'ihc_pushover_app_token' => '',
							'ihc_pushover_admin_token' => '',
							'ihc_pushover_url' => '',
							'ihc_pushover_url_title' => '',
							'ihc_pushover_sound' => 'bike',
			);
			break;
		case 'account_page_menu':
			$arr = array(
							'ihc_account_page_menu_enabled' => 0,
							'ihc_account_page_menu_order' => array(),
			);
			break;
		case 'mycred':
			$arr = array(
							'ihc_mycred_enabled' => 0,
			);
			break;
		case 'api':
			$arr = array(
							'ihc_api_enabled' => 0,
							'ihc_api_hash' => '',
							'ihc_api_actions' => array(
														'verify_user_level' => 1,
														'user_approve' => 1,
														'user_add_level' => 1,
														'user_get_details' => 1,
														'user_activate_level' => 1,
														'get_user_field_value' => 1,
														'get_user_levels' => 1,
														'get_user_level_details' => 1,
														'get_user_posts' => 1,
														'search_users' => 1,
														'list_levels' => 1,
														'get_level_users' => 1,
														'get_level_details' => 1,
														'orders_listing' => 1,
														'order_get_status' => 1,
														'order_get_data' => 1,
							),
			);
			break;
		case 'woo_product_custom_prices':
			$arr = array(
							'ihc_woo_product_custom_prices_enabled' => 1,
							'ihc_woo_product_custom_prices_tiebreaker' => 'biggest',
							'ihc_woo_product_custom_prices_like_discount' => 0,
			);
			break;
		case 'drip_content_notifications':
			$arr = array(
							'ihc_drip_content_notifications_enabled' => 0,
							'ihc_drip_content_notifications_logs_enabled' => 0,
							'ihc_drip_content_notifications_sleep' => 0,
			);
			break;
		case 'user_sites':
			$arr = array(
							'ihc_user_sites_enabled' => 0,
							'ihc_user_sites_levels' => array(),
			);
			break;
		case 'zapier':
			$arr = array(
					'ihc_zapier_enabled'									=> 0,
					'ihc_zapier_new_user_webhook'					=> '',
					'ihc_zapier_new_user_enabled'					=> 0,
					'ihc_zapier_new_order_webhook'				=> '',
					'ihc_zapier_new_order_enabled'				=> 0,
					'ihc_zapier_order_completed_webhook'  => '',
					'ihc_zapier_order_completed_enabled'  => 0,
			);
			break;
		case 'infusionSoft':
			$arr = array(
					'ihc_infusionSoft_enabled'									=> 0,
					'ihc_infusionSoft_id'												=> '',
					'ihc_infusionSoft_api_key'									=> '',
					'ihc_infusionSoft_levels_groups'						=> array(),
			);
			break;
		case 'kissmetrics':
			$arr = array(
					'ihc_kissmetrics_enabled'															=> 0,
					'ihc_kissmetrics_apikey'															=> '',
					'ihc_kissmetrics_events_user_register'								=> 0,
					'ihc_kissmetrics_events_user_register_label'					=> __( 'Registered!', 'ihc' ),
					'ihc_kissmetrics_events_user_get_level'								=> 0,
					'ihc_kissmetrics_events_user_get_level_label'					=> __( 'User get level ', 'ihc' ) . '%level%',
					'ihc_kissmetrics_events_user_finish_payment'					=> 0,
					'ihc_kissmetrics_events_user_finish_payment_label'		=> __( 'User has finish the payment for level ', 'ihc' ) . '%level%',
					'ihc_kissmetrics_events_user_login'										=> 0,
					'ihc_kissmetrics_events_user_login_label'							=> __( 'User has login. ', 'ihc' ),
					'ihc_kissmetrics_events_remove_user_level'						=> 0,
					'ihc_kissmetrics_events_remove_user_level_label'			=> __( 'Level ', 'ihc') . '%level%' . __( ' has been removed from this user.', 'ihc'),
			);
			break;
		case 'direct_login':
			$arr = array(
					'ihc_direct_login_enabled'					=> 0,
			);
			break;
		case 'reason_for_cancel':
			$arr = array(
					'ihc_reason_for_cancel_enabled'				=> 0,
					'ihc_reason_for_cancel_resons'				=> "I have no time,
The content of your website don't satisfy me"
			);
			break;
		default:
			// used for add-ons
			$arr = array();
			break;
	}
	$arr = apply_filters( 'ihc_default_options_group_filter', $arr, $type );
	// @description Settings group. @param list of settings (array), type of settings group (array)

	if ($return_default){
		//return default values
		return $arr;
	}

	if (isset($arr)){
		if ($only_name){
			return $arr;
		}
		foreach ($arr as $k=>$v){
			$data = get_option($k);
			if ($data!==FALSE){
				$arr[$k] = $data;
			} else {
				add_option($k, $v);
			}
		}
		return $arr;
	}
	return FALSE;
}

function ihc_native_user_field(){
	/*
	 * @param none
	 * @return array
	 */
	//$arr[] = array('display_public_reg'=>'', 'display_public_ap'=>'', 'display_admin'=>'', 'name'=>'', 'label'=>'', 'type'=>'', 'native_wp' => '', 'req' => '' );
	//order will be each key . ex: array( n=>array())
	//arr[]['display'] 0 not show, 1 show, 2 show always cannot be removed from register form
	//arr['req'] 0 not, 1 require, 2 if is selected it will be automatically require
	$arr = array(
			array( 'display_admin'=>2, 'display_public_reg'=>2, 'display_public_ap'=>2, 'display_on_modal'=> 2, 'name'=>'user_login', 'label'=>'Username', 'type'=>'text', 'native_wp' => 1, 'req' => 1, 'sublevel' => '' ),
			array( 'display_admin'=>2, 'display_public_reg'=>2, 'display_public_ap'=>2, 'display_on_modal'=> 2, 'name'=>'user_email', 'label'=>'Email', 'type'=>'text', 'native_wp' => 1, 'req' => 1, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'confirm_email', 'label'=>'Confirm Email', 'type'=>'text', 'native_wp' => 0, 'req' => 2, 'sublevel' => '' ),
			array( 'display_admin'=>1, 'display_public_reg'=>1, 'display_public_ap'=>1, 'display_on_modal'=> 0, 'name'=>'first_name', 'label'=>'First Name', 'type'=>'text', 'native_wp' => 1, 'req' => 1, 'sublevel' => '' ),
			array( 'display_admin'=>1, 'display_public_reg'=>1, 'display_public_ap'=>1, 'display_on_modal'=> 0, 'name'=>'last_name', 'label'=>'Last Name', 'type'=>'text', 'native_wp' => 1, 'req' => 1, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'user_url', 'label'=>'Website', 'type'=>'text', 'native_wp' => 1, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>1, 'display_public_reg'=>2, 'display_public_ap'=>1, 'display_on_modal'=> 1, 'name'=>'pass1', 'label'=>'Password', 'type'=>'password', 'native_wp' => 1, 'req' => 1, 'sublevel' => '' ),
			array( 'display_admin'=>1, 'display_public_reg'=>1, 'display_public_ap'=>1, 'display_on_modal'=> 0, 'name'=>'pass2', 'label'=>'Confirm Password', 'type'=>'password', 'native_wp' => 1, 'req' => 2, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'description', 'label'=>'Biographical Info', 'type'=>'textarea', 'native_wp' => 1, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'phone', 'label'=>'Phone', 'type'=>'number', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'addr1', 'label'=>'Address 1', 'type'=>'textarea', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'addr2', 'label'=>'Address 2', 'type'=>'textarea', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'zip', 'label'=>'Zip', 'type'=>'text', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'city', 'label'=>'City', 'type'=>'text', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'thestate', 'label'=>'State', 'type'=>'text', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'country', 'label'=>'Country', 'type'=>'text', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>1, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'ihc_country', 'label'=>'Country', 'type'=>'ihc_country', 'native_wp' => 0, 'req' => 2, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'ihc_state', 'label'=>'State', 'type'=>'ihc_state', 'native_wp' => 1, 'req' => 2, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>1, 'display_public_ap'=>1, 'display_on_modal'=> 0, 'name'=>'ihc_avatar', 'label'=>'Avatar', 'type'=>'upload_image', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>1, 'display_public_reg'=>1, 'display_public_ap'=>1, 'display_on_modal'=> 0, 'name'=>'tos', 'label'=>'Accept', 'type'=>'checkbox', 'native_wp' => 0, 'req' => 2, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'ihc_optin_accept', 'label' => __( 'I would like to subscribe to newsletter list ', 'ihc' ), 'type'=>'single_checkbox', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'ihc_memberlist_accept', 'label' => __( 'Show my profile on public Members Directory', 'ihc' ), 'type'=>'single_checkbox', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>1, 'display_public_reg'=>0, 'display_public_ap'=>1, 'display_on_modal'=> 0, 'name'=>'recaptcha', 'label'=>'Capcha', 'type'=>'capcha', 'native_wp' => 0, 'req' => 2, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>1, 'display_on_modal'=> 0, 'name'=>'ihc_social_media', 'label'=>'-', 'type'=>'social_media', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'ihc_invitation_code_field', 'label'=>'Invitation Code', 'type'=>'ihc_invitation_code_field', 'native_wp' => 0, 'req' => 2, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'ihc_dynamic_price', 'label'=>'Price', 'type'=>'ihc_dynamic_price', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>1, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'ihc_coupon', 'label'=>'Coupon', 'type'=>'text', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
			array( 'display_admin'=>0, 'display_public_reg'=>1, 'display_public_ap'=>1, 'display_on_modal'=> 0, 'name'=>'payment_select', 'label'=>'Select Payment', 'type'=>'payment_select', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' ),
	);

	return $arr;
}

function ihc_get_user_reg_fields(){
	/*
	 * @param none
	 * @return array
	 */
	$option_name = 'ihc_user_fields';
	$data = get_option($option_name);
	if ($data!==FALSE){
		return $data;
	} else {
		$data = ihc_native_user_field();
		add_option($option_name, $data);
		return $data;
	}
}

function ihc_print_form_password($meta_arr){
	/*
	 * @param attr
	 * @return string with form for lost password
	 */
	$str = '';

	if($meta_arr['ihc_login_custom_css']){
		$str .= '<style>'.$meta_arr['ihc_login_custom_css'].'</style>';
	}

	$nonce = wp_create_nonce( 'ihc_lost_password_nonce' );
	$str .= '<div class="ihc-pass-form-wrap '.$meta_arr['ihc_login_template'].'">';
	$str .= '<form action="" method="post" >'
					. '<input name="ihcaction" type="hidden" value="reset_pass">'
					. '<input type="hidden" name="ihc_lost_password_nonce" value="' . $nonce . '" />';

	switch($meta_arr['ihc_login_template']){

	case 'ihc-login-template-3':
		$str .=  '<div class="impu-form-line-fr">'
						. '<input type="text" value="" name="email_or_userlogin" placeholder="' . __('Username or E-mail', 'ihc') . '" />'
					. '</div>'
					. '<div class="impu-form-submit">'
						. '<input type="submit" value="' . __('Get New Password', 'ihc') . '" name="Submit" class="button button-primary button-large">'
					. '</div>';
	break;

	case 'ihc-login-template-4':
		$str .=  '<div class="impu-form-line-fr">'
						. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" name="email_or_userlogin" placeholder="'.__('Username or E-mail', 'ihc').'" />'
					. '</div>'
					. '<div class="impu-form-submit">'
						. '<input type="submit" value="' . __('Get New Password', 'ihc') . '" name="Submit" class="button button-primary button-large">'
					. '</div>';
	break;

	case 'ihc-login-template-8':
		$str .=  '<div class="impu-form-line-fr">'
						. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" name="email_or_userlogin" placeholder="'.__('Username or E-mail', 'ihc').'" />'
					. '</div>'
					. '<div class="impu-form-submit">'
						. '<input type="submit" value="' . __('Get New Password', 'ihc') . '" name="Submit" class="button button-primary button-large">'
					. '</div>';
	break;

	case 'ihc-login-template-9':
		$str .=  '<div class="impu-form-line-fr">'
						. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" name="email_or_userlogin" placeholder="'.__('Username or E-mail', 'ihc').'" />'
					. '</div>'
					. '<div class="impu-form-submit">'
						. '<input type="submit" value="' . __('Get New Password', 'ihc') . '" name="Submit" class="button button-primary button-large">'
					. '</div>';
	break;

	case 'ihc-login-template-10':
		$str .=  '<div class="impu-form-line-fr">'
						. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" name="email_or_userlogin" placeholder="'.__('Username or E-mail', 'ihc').'" />'
					. '</div>'
					. '<div class="impu-form-submit">'
						. '<input type="submit" value="' . __('Get New Password', 'ihc') . '" name="Submit" class="button button-primary button-large">'
					. '</div>';
	break;

	case 'ihc-login-template-11':
		$str .=  '<div class="impu-form-line-fr">'
						. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" name="email_or_userlogin" placeholder="'.__('Username or E-mail', 'ihc').'" />'
					. '</div>'
					. '<div class="impu-form-submit">'
						. '<input type="submit" value="' . __('Get New Password', 'ihc') . '" name="Submit" class="button button-primary button-large">'
					. '</div>';
	break;

	case 'ihc-login-template-12':
		$str .=  '<div class="impu-form-line-fr">'
						. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" name="email_or_userlogin" placeholder="'.__('Username or E-mail', 'ihc').'" />'
					. '</div>'
					. '<div class="impu-form-submit">'
						. '<input type="submit" value="' . __('Get New Password', 'ihc') . '" name="Submit" class="button button-primary button-large">'
					. '</div>';
	break;

	case 'ihc-login-template-13':
		$str .=  	'<div class="impu-form-pass-additional-content">'
					.__('To reset your password, please enter your email address or username below', 'ihc')
					. '</div>'
					.'<div class="impu-form-line-fr">'
						. '<input type="text" value="" name="email_or_userlogin" placeholder="' . __('Enter your username or email', 'ihc') . '" />'
					. '</div>'
					. '<div class="impu-form-submit">'
						. '<input type="submit" value="' . __('Reset my password', 'ihc') . '" name="Submit" class="button button-primary button-large">'
					. '</div>';
	break;

	default:
		$str .=  '<div class="impu-form-line-fr">'
					. '<span class="impu-form-label-fr impu-form-label-username">' . __('Username or E-mail', 'ihc') . ': </span>'
						. '<input type="text" value="" name="email_or_userlogin" />'
					. '</div>'
					. '<div class="impu-form-submit">'
						. '<input type="submit" value="' . __('Get New Password', 'ihc') . '" name="Submit" class="button button-primary button-large">'
					. '</div>';
	break;
	}
	$str .=   '</form>';
	$str .= '</div>';
	return $str;
}

function ihc_print_form_login($meta_arr){
	/*
	 * @param array
	 * @return string
	 */
	$str = '';
	if($meta_arr['ihc_login_custom_css']){
		$str .= '<style>'.$meta_arr['ihc_login_custom_css'].'</style>';
	}

	$sm_string = (!empty($meta_arr['ihc_login_show_sm'])) ? ihc_print_social_media_icons('login', array(), @$meta_arr['is_locker']) : '';

	$nonce = wp_create_nonce( 'ihc_login_nonce' );

	$str .= '<div class="ihc-login-form-wrap '.$meta_arr['ihc_login_template'].'">'
			.'<form action="" method="post" id="ihc_login_form">'
			. '<input type="hidden" name="ihcaction" value="login" />'
			. '<input type="hidden" name="ihc_login_nonce" value="' . $nonce . '" />';

	if (!empty($meta_arr['is_locker'])){
		$str .= '<input type="hidden" name="locker" value="1" />';
	}

	$captcha = '';
	if (!empty($meta_arr['ihc_login_show_recaptcha'])){
			$captchaType = get_option( 'ihc_recaptcha_version' );
			if ( $captchaType !== false && $captchaType == 'v3' ){
					$captchaKey = get_option('ihc_recaptcha_public_v3');
			} else {
					$captchaKey = get_option('ihc_recaptcha_public');
			}

			if ( !empty( $captchaKey ) ){
					$view = new \Indeed\Ihc\IndeedView();
					$captchaData = array(
							'class' 		=> '',
							'key'				=> $captchaKey,
							'langCode'	=> indeed_get_current_language_code(),
							'type'			=> $captchaType,
					);
					$captcha = $view->setTemplate( IHC_PATH . 'public/views/login-captcha.php' )->setContentData( $captchaData, true)->getOutput();
			}
	}

	$user_field_id = 'iump_login_username';
	$password_field_id = 'iump_login_password';

	switch($meta_arr['ihc_login_template']){

	case 'ihc-login-template-2':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-username">'.__('Username', 'ihc').':</span>'
				. '<input type="text" value="" name="log" id="' . $user_field_id . '" />'
				. '</div>'
				. '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-pass">'.__('Password', 'ihc').':</span>'
				. '<input type="password" value="" name="pwd" id="' . $password_field_id . '" />'
				. '</div>';
		//>>>>
		$str .= $sm_string;
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-form-line-fr impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-fr impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>

		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div class="impu-form-line-fr impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}
			}
			if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}
		$str .= '</div>';
		}
		//>>>>

		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.'/>'
				 . '</div>';
		//>>>>
	break;

	case 'ihc-login-template-3':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">'
				. '<input type="text" value="" name="log" id="' . $user_field_id . '" placeholder="'.__('Username', 'ihc').'"/>'
				. '</div>'
				. '<div class="impu-form-line-fr">'
				. '<input type="password" value="" id="' . $password_field_id . '" name="pwd" placeholder="'.__('Password', 'ihc').'"/>'
				. '</div>';
		//>>>>
		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}

		$str .= $captcha;

		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.'/>'
				 . '</div>';

		$str .= $sm_string;
		$str .= '<div class="impu-temp3-bottom">';
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>

		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}
			}
			if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}

			$str .= '</div>';
		}
		//>>>>
		$str .= '<div class="iump-clear"></div>';
		$str .= '</div>';

		break;

	case 'ihc-login-template-4':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" id="' . $user_field_id . '" name="log" placeholder="'.__('Username', 'ihc').'"/>'
				. '</div>'
				. '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-pass-ihc"></i><input type="password" value="" id="' . $password_field_id . '" name="pwd" placeholder="'.__('Password', 'ihc').'"/>'
				. '</div>';
		//>>>>
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>

		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.' />'
				 . '</div>';

		$str .= $sm_string;
		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}
			}
			if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}

		$str .= '</div>';
		}
		//>>>>

		break;
	case 'ihc-login-template-5':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-username">'.__('Username', 'ihc').':</span>'
				. '<input type="text" value="" id="' . $user_field_id . '" name="log" />'
				. '</div>'
				. '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-pass">'.__('Password', 'ihc').':</span>'
				. '<input type="password" value="" id="' . $password_field_id . '" name="pwd" />'
				. '</div>';
		//>>>>
		$str .=    '<div class="impu-temp5-row">';
		$str .=    '<div class="impu-temp5-row-left">';
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-fr impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>
		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-line-fr impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}
			}
			if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}
		$str .= '</div>';
		}
		//>>>>
		$str .= '</div>';

		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.'/>'
				 . '</div>';
		//>>>>
		$str .= '<div class="iump-clear"></div>';


		$str .= $sm_string;

		$str .= '</div>';

		break;
		case 'ihc-login-template-6':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-username">'.__('Username', 'ihc').':</span>'
				. '<input type="text" value="" name="log" id="' . $user_field_id . '" />'
				. '</div>'
				. '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-pass">'.__('Password', 'ihc').':</span>'
				. '<input type="password" value="" id="' . $password_field_id . '" name="pwd" />'
				. '</div>';
		//>>>>
		$str .= $sm_string;
		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}
			}
			if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}
		$str .= '</div>';
		}
		//>>>>
		$str .=    '<div class="impu-temp6-row">';
		$str .=    '<div class="impu-temp6-row-left">';
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-fr impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>

		$str .= '</div>';

		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.'/>'
				 . '</div>';
		//>>>>
		$str .= '<div class="iump-clear"></div>';
		$str .= '</div>';

		break;

		case 'ihc-login-template-7':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-username">'.__('Username', 'ihc').':</span>'
				. '<input type="text" value="" name="log" id="' . $user_field_id . '"/>'
				. '</div>'
				. '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-pass">'.__('Password', 'ihc').':</span>'
				. '<input type="password" value="" id="' . $password_field_id . '" name="pwd" />'
				. '</div>';
		//>>>>
		$str .= $sm_string;
		$str .=    '<div class="impu-temp5-row">';
		$str .=    '<div class="impu-temp5-row-left">';
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-fr impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>
		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}
			}
			if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}
		$str .= '</div>';
		}
		//>>>>
		$str .= '</div>';

		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.'/>'
				 . '</div>';
		//>>>>
		$str .= '<div class="iump-clear"></div>';
		$str .= '</div>';

		break;

	case 'ihc-login-template-8':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" id="' . $user_field_id . '" name="log" placeholder="'.__('Username', 'ihc').'"/>'
				. '</div>'
				. '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-pass-ihc"></i><input type="password" value="" id="' . $password_field_id . '" name="pwd" placeholder="'.__('Password', 'ihc').'"/>'
				. '</div>';
		//>>>>
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>

		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.' />'
				 . '</div>';

		$str .= $sm_string;

		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}
			}
			if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}

		$str .= '</div>';
		}
		//>>>>

		break;
	case 'ihc-login-template-9':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" id="' . $user_field_id . '" name="log" placeholder="'.__('Username', 'ihc').'"/>'
				. '</div>'
				. '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-pass-ihc"></i><input type="password" value="" id="' . $password_field_id . '" name="pwd" placeholder="'.__('Password', 'ihc').'"/>'
				. '</div>';
		//>>>>
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>
		if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}
		$str .= '<div class="ihc-clear"></div>';
		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.' />'
				 . '</div>';

		$str .= $sm_string;
		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg">'.__('Dont have an account?', 'ihc').'<a href="'.$register_page.'">'.__('Sign Up', 'ihc').'</a></div>';
				}
			}


		$str .= '</div>';
		}
		//>>>>

		break;
	case 'ihc-login-template-10':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" id="' . $user_field_id . '" name="log" placeholder="'.__('Username', 'ihc').'"/>'
				. '</div>'
				. '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-pass-ihc"></i><input type="password" value="" id="' . $password_field_id . '" name="pwd" placeholder="'.__('Password', 'ihc').'"/>'
				. '</div>';
		//>>>>
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>
		if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}
		$str .= '<div class="ihc-clear"></div>';
		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.' />'
				 . '</div>';

		$str .= $sm_string;
		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg">'.__('Dont have an account?', 'ihc').'<a href="'.$register_page.'">'.__('Sign Up', 'ihc').'</a></div>';
				}
			}
		$str .= '</div>';
		}
		//>>>>

		break;
	case 'ihc-login-template-11':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" id="' . $user_field_id . '" name="log" placeholder="'.__('Username', 'ihc').'"/>'
				. '</div>'
				. '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-pass-ihc"></i><input type="password" value="" id="' . $password_field_id . '" name="pwd" placeholder="'.__('Password', 'ihc').'"/>'
				. '</div>';
		//>>>>
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>
		if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}
		$str .= '<div class="ihc-clear"></div>';
		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.' />'
				 . '</div>';

		$str .= $sm_string;
		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg">'.__('Dont have an account?', 'ihc').'<a href="'.$register_page.'">'.__('Sign Up', 'ihc').'</a></div>';
				}
			}


		$str .= '</div>';
		}
		//>>>>

		break;

	case 'ihc-login-template-12':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-username-ihc"></i><input type="text" value="" id="' . $user_field_id . '" name="log" placeholder="'.__('Username', 'ihc').'"/>'
				. '</div>'
				. '<div class="impu-form-line-fr">'
				. '<i class="fa-ihc fa-pass-ihc"></i><input type="password" value="" id="' . $password_field_id . '" name="pwd" placeholder="'.__('Password', 'ihc').'"/>'
				. '</div>';
		//>>>>
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-remember">'.__('Remember Me', 'ihc').'</span> </div>';
		}
		//>>>>
		if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}
		$str .= '<div class="ihc-clear"></div>';
		$str .= $captcha;

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.' />'
				 . '</div>';

		$str .= $sm_string;
		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg">'.__('Dont have an account?', 'ihc').'<a href="'.$register_page.'">'.__('Sign Up', 'ihc').'</a></div>';
				}
			}
		$str .= '</div>';
		}
		//>>>>

		break;

	case 'ihc-login-template-13':
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-username">'.__('Username or Email', 'ihc').'</span>'
				. '<input type="text" value="" id="' . $user_field_id . '" name="log" />'
				. '</div>'
				. '<div class="impu-form-line-fr" style="margin-bottom:30px;">' . '<span class="impu-form-label-fr impu-form-label-pass">'.__('Password', 'ihc').'</span>'
				. '<input type="password" value="" id="' . $password_field_id . '" name="pwd" />'
				. '</div>';
		//>>>>

		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-temp5-row">';
			$str .= '<div class="impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-fr impu-form-label-remember">'.__('Keep me signed in', 'ihc').'</span> </div>';
			$str .= '</div>';
		}
		//>>>>

		$str .= '<div class="impu-temp5-row">';
		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}
		$str .= '<div class="impu-temp5-row-left">';
		$str .=    '<div class="impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.'/>'
				 . '</div>';
		$str .= '</div>';
		//>>>>
		if($meta_arr['ihc_login_register']){
		$str .= '<div class="impu-temp5-row-right">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="ihc-register-link"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}
			}
		$str .= '</div>';
		}

		$str .= '<div class="iump-clear"></div>';

		$str .= '</div>';
		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_pass_lost']){
			$str .= '<div class="impu-temp5-row">';
			$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			$str .= '</div>';
		}

		//>>>>

		$str .= $captcha;
		$str .= $sm_string;

		break;

	default:
		//<<<< FIELDS
		$str .= '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-username">'.__('Username', 'ihc').':</span>'
				. '<input type="text" value="" name="log" id="' . $user_field_id . '" />'
				. '</div>'
				. '<div class="impu-form-line-fr">' . '<span class="impu-form-label-fr impu-form-label-pass">'.__('Password', 'ihc').':</span>'
				. '<input type="password" value="" name="pwd" id="' . $password_field_id . '" />'
				. '</div>';
		//>>>>
		$str .= $sm_string;
		//<<<< REMEMBER ME
		if($meta_arr['ihc_login_remember_me']){
			$str .= '<div class="impu-form-line-fr impu-remember-wrapper"><input type="checkbox" value="forever" name="rememberme" class="impu-form-input-remember" /><span class="impu-form-label-fr impu-form-label-remember">'.__('Remember Me').'</span> </div>';
		}
		//>>>>

		//<<<< ADDITIONAL LINKS
		if($meta_arr['ihc_login_register'] || $meta_arr['ihc_login_pass_lost']){
		$str .= '<div  class="impu-form-line-fr impu-form-links">';
			if($meta_arr['ihc_login_register']){
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}
			}
			if($meta_arr['ihc_login_pass_lost']){
				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}
			}
		$str .= '</div>';
		}
		//>>>>

		//SUBMIT BUTTON
		$disabled = '';
		if(isset($meta_arr['preview']) && $meta_arr['preview']){
			$disabled = 'disabled';
		}

		$str .= $captcha;

		$str .=    '<div class="impu-form-line-fr impu-form-submit">'
					. '<input type="submit" value="'.__('Log In', 'ihc').'" name="Submit" '.$disabled.' class="button button-primary button-large"/>'
				 . '</div>';
		//>>>>
		break;
	}

	$str .=   '</form>';

	/// ERROR MESSAGE
	 if (!empty($_GET['ihc_pending_email'])){
		/************************ PENDING EMAIL ********************/
		$login_faild = get_option('ihc_login_error_email_pending', true);
		if (empty($login_faild)){
			$arr = ihc_return_meta_arr('login-messages', false, true);
			//print_r($arr);
			if (isset($arr['ihc_login_error_email_pending']) && $arr['ihc_login_error_email_pending']){
				$login_faild = $arr['ihc_login_error_email_pending'];
			} else {
				$login_faild = __('Error', 'ihc');
			}
		}
		$str .= '<div class="ihc-login-error-wrapper"><div class="ihc-login-error">' . ihc_correct_text($login_faild) . '</div></div>';
	} else if (!empty($_GET['ihc_login_fail'])){
		/************************** FAIL *****************************/
		$login_faild = ihc_correct_text( get_option('ihc_login_error', true) );
		if (empty($login_faild)){
			$arr = ihc_return_meta_arr('login-messages', false, true);
			if (isset($arr['ihc_login_error']) && $arr['ihc_login_error']){
				$login_faild = $arr['ihc_login_error'];
			} else {
				$login_faild = __('Error', 'ihc');
			}
		}
		$str .= '<div class="ihc-login-error-wrapper"><div class="ihc-login-error">' . ihc_correct_text($login_faild) . '</div></div>';
	} else if (!empty($_GET['ihc_login_pending'])){
		/*********************** PENDING ******************************/
		$str .= '<div class="ihc-login-pending">' . ihc_correct_text(get_option('ihc_login_pending', true)) . '</div>';
	} else if (!empty($_GET['ihc_social_login_failed'])){
		/*********************** Social Login - Error ******************************/
		$errMessage = get_option('ihc_social_login_failed', true );
		if ( $errMessage == '' ){
				$errMessage = __( 'You are not registered with this social network. Please register first!', 'ihc' );
		}
		$errMessage = ihc_correct_text( $errMessage );
		$str .= '<div class="ihc-login-error-wrapper">' . $errMessage . '</div>';
	} else if (!empty($_GET['ihc_fail_captcha'])){
		$login_faild = ihc_correct_text(get_option('ihc_login_error_on_captcha'));
		if (!$login_faild){
			$login_faild = __('Captcha Error', 'ihc');
		}
		$str .= '<div class="ihc-login-error-wrapper"><div class="ihc-login-error">' . $login_faild . '</div></div>';
	}
	if (!empty($_GET['ihc_login_block'])){
		require_once IHC_PATH . 'classes/Ihc_Security_Login.class.php';
		$security_object = new Ihc_Security_Login();
		$message = $security_object->get_error_attempt_message();
		if ($message){
			$str .= '<div class="ihc-login-error-wrapper"><div class="ihc-login-error">' . $message . '</div></div>';
		}
	}
	/// ERROR MESSAGE

	$str .= '</div>';

	$err_msg = __('Please complete all require fields!', 'ihc');
	$custom_err_msg = get_option('ihc_login_error_ajax');
	if ($custom_err_msg){
		$err_msg = $custom_err_msg;
	}
	$str .= "<script>
		jQuery(document).ready(
			function(){
				jQuery('#$user_field_id').on('blur', function(){
					ihcCheckLoginField('log', '$err_msg');
				});
				jQuery('#$password_field_id').on('blur', function(){
					ihcCheckLoginField('pwd', '$err_msg');
				});
				jQuery('#ihc_login_form').on('submit', function(e){
					e.preventDefault();
					var u = jQuery('#ihc_login_form [name=log]').val();
					var p = jQuery('#ihc_login_form [name=pwd]').val();
					if (u!='' && p!=''){
						jQuery('#ihc_login_form').unbind('submit').submit();
					} else {
						ihcCheckLoginField('log', '$err_msg');
						ihcCheckLoginField('pwd', '$err_msg');
						return FALSE;
					}
				});
			}
		);
	</script>";

	return $str;
}


function ihc_print_social_media_icons($type='login', $already_registered_sm=array(), $is_locker=FALSE){
	/*
	 * @param string (login, register, update), array, bool
	 * @return string
	 */

	//$current_url = IHC_PROTOCOL . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$current_url = IHC_PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$metas = ihc_return_meta_arr('social_media');

	$arr = array(
			"fb" => "Facebook",
			"tw" => "Twitter",
			"goo" => "Google",
			"in" => "LinkedIn",
			"vk" => "Vkontakte",
			"ig" => "Instagram",
			"tbr" => "Tumblr",
	);

	$str = '';
	foreach ($arr as $k=>$v){
		$data = ihc_check_social_status($k);
		$label = (empty($metas['ihc_sm_show_label'])) ? "" : '<span class="ihc-sm-item-label">'.$v.'</span>';

		if ($data['settings']=='Completed' && $data['active']){
			$extra_class = 'ihc-' . $k;
			$icon = '<i class="fa-ihc-sm fa-ihc-' . $k . '"></i>';
			if ($type=='login'){
				$href = IHC_URL . 'public/social_handler.php?sm_login=' . $k . '&ihc_current_url=' . urlencode($current_url);
				if (!empty($is_locker)){
					$href .= '&is_locker=1';
				}
				$str .= '<div class="ihc-sm-item ' . $extra_class . '"><a href="' . $href . '">' . $icon . $label . '</a></div>';
			} else if ($type=='register'){
				$str .= '<div onClick="ihcRunSocialReg(\''.$k.'\');" class="ihc-sm-item ' . $extra_class . '">' . $icon . $label . '<div class="iump-clear"></div></div>';
			} else if ($type=='update'){
				$already_class = '';
				if ($already_registered_sm && in_array($k, $already_registered_sm)){
					$already_class = ' ihc-sm-already-reg';
					$str .= '<div class="ihc-sm-item ' . $extra_class . ' ' . $already_class . '"><a href="javascript:void(0)" onClick="ihcRemoveSocial(\'' . $k . '\');">' . $icon . $label . '<div class="iump-clear"></div></a></div>';
				} else {
					$href = IHC_URL . 'public/social_handler.php?reg_ext_usr=' . $k . '&ihc_current_url=' . urlencode($current_url);
					$str .= '<div class="ihc-sm-item ' . $extra_class . '"><a href="' . $href . '">' . $icon . $label . '<div class="iump-clear"></div></a></div>';
				}
			}
		}
	}
	if ($str){
		if ($type=='login'){
			$str = '<div>' . ihc_correct_text($metas['ihc_sm_top_content']) . '</div>' . $str . '<div>' . ihc_correct_text($metas['ihc_sm_bottom_content']) . '</div>';
		}
		$str = '<div class="ihc-sm-wrapp-fe ' . @$metas['ihc_sm_template'] . '">' . $str . '</div>';
		if (!empty($metas['ihc_sm_custom_css'])){
			$str = '<style>' . $metas['ihc_sm_custom_css'] . '</style>' . $str;
		}
	}
	return $str;
}

function ihc_print_links_login(){
	/*
	 * @param none
	 * @return string
	 */
	$str ='';
	$str .= '<div  class="impu-form-line-fr impu-form-links">';
				$pag_id = get_option('ihc_general_register_default_page');
				if($pag_id!==FALSE){
					$register_page = get_permalink( $pag_id );
					if (!$register_page) $register_page = get_home_url();
					$str .= '<div class="impu-form-links-reg"><a href="'.$register_page.'">'.__('Register', 'ihc').'</a></div>';
				}


				$pag_id = get_option('ihc_general_lost_pass_page');
				if($pag_id!==FALSE){
					$lost_pass_page = get_permalink( $pag_id );
					if (!$lost_pass_page) $lost_pass_page = get_home_url();
					$str .= '<div class="impu-form-links-pass"><a href="'.$lost_pass_page.'">'.__('Lost your password?', 'ihc').'</a></div>';
				}

		$str .= '</div>';
	return $str;
}

function ihc_get_level_by_id($id){
	/*
	 * @param int
	 * @return array|bool
	 */
	$data = get_option('ihc_levels');
	if ($data!==FALSE){
		foreach ($data as $k=>$v){
			if ((int)$k==(int)$id){
				return $v;
			}
		}
	}
	return FALSE;
}

function ihc_format_str_like_wp( $str ){
	/*
	 * @param string
	 * @return string
	 */
	 /*
	$str = preg_replace("/\n\n+/", "\n\n", $str);
	$str_arr = preg_split('/\n\s*\n/', $str, -1, PREG_SPLIT_NO_EMPTY);
	$str = '';

	foreach ( $str_arr as $str_val ) {
		$str .= '<p>' . trim($str_val, "\n") . "</p>\n";//trim($str_val, "\n") . "\n";
	}
	*/
	$str = wpautop( $str );
	return $str;
}

function ihc_array_value_exists($haystack, $needle, $key){
	/*
	 * @param array, string, string
	 * @return string|int, bool
	 */
	foreach ($haystack as $k=>$v){
		if ( isset( $v[$key] ) && $v[$key]==$needle ){
			return $k;
		}
	}
	return FALSE;
}

function ihc_is_array_value_multi_exists($haystack=array(), $needle='', $key=''){
	/*
	 * @param array, string, string
	 * @return int
	 */
	$c = 0;
	foreach ($haystack as $k=>$v){
		if ($v[$key]==$needle){
			$c++;
		}
	}
	return $c;
}

function ihc_array_key_recursive($arr, $key){
	/*
	 * @param array, string|int
	 * @return string|int, bool
	 */
	foreach ($arr as $k=>$v){
		if (array_key_exists($key, $v)) return $k;
	}
	return FALSE;
}


function ihc_correct_text( $str, $wp_editor_content=false, $escAttr=false )
{
	/*
	 * @param string, bool
	 * @return string
	 */
	$str = stripcslashes( htmlspecialchars_decode( $str ) );
	if ( $escAttr ){
			$str = esc_attr( $str );
	}
	if ($wp_editor_content){
			return ihc_format_str_like_wp($str);
	}
	return $str;
}

///////////forms utility

function indeed_create_form_element($attr=array()){
	/*
	 * @param string
	 * @return string
	 */
	foreach (array('name', 'id', 'value', 'class', 'other_args', 'disabled', 'placeholder', 'multiple_values', 'user_id', 'sublabel') as $k){
		if (!isset($attr[$k])){
			$attr[$k] = '';
		}
	}

	$str = '';
	if (isset($attr['type']) && $attr['type']){
		switch ($attr['type']){
			case 'text':
			case 'conditional_text':
				$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
				$str = '<input type="text" name="'.$attr['name'].'" '. $id_field .' class="'.$attr['class'].'" value="' . ihc_correct_text($attr['value'], false, true ) . '" placeholder="'.$attr['placeholder'].'" '.$attr['other_args'].' '.$attr['disabled'].' />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'number':
				foreach (array('max', 'min') as $k){
					if (!isset($attr[$k])){
						$attr[$k] = '';
					}
				}
				$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
				$str = '<input type="number" name="'.$attr['name'].'" '. $id_field .' class="'.$attr['class'].'" value="'.$attr['value'].'"  '.$attr['other_args'].' '.$attr['disabled'].' min="' . $attr['min'] . '" max="' . $attr['max'] . '" />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'textarea':
				$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
				$str = '<textarea name="'.$attr['name'].'" '. $id_field .' class="iump-form-textarea '.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].' >' . ihc_correct_text($attr['value'], false, true ) . '</textarea>';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'password':
				wp_register_script( 'ihc_passwordStrength', IHC_URL . 'assets/js/passwordStrength.js', array(), null );
				wp_localize_script('ihc_passwordStrength', 'ihcPasswordStrengthLabels', json_encode( array(__('Very Weak', 'ihc'), __('Weak', 'ihc'), __('Good', 'ihc'), __('Strong', 'ihc')) ));
				wp_enqueue_script('ihc_passwordStrength');

				$ruleOne = (int)get_option('ihc_register_pass_min_length');
				$ruleTwo = (int)get_option('ihc_register_pass_options');

				$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
				$str .= '<input type="password" name="'.$attr['name'].'" '. $id_field .' class="'.$attr['class'].'" value="'.$attr['value'].'" placeholder="'.$attr['placeholder'].'" '.$attr['other_args'].' data-rules="' . $ruleOne . ',' . $ruleTwo . '"/>';
				$str .= '<div class="ihc-strength-wrapper">';
				$str .= '<ul class="ihc-strength"><li class="point"></li><li class="point"></li><li class="point"></li><li class="point"></li><li class="point"></li></ul>';
				$str .= '<div class="ihc-strength-label"></div>';
				$str .= '</div>';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}

				break;

			case 'hidden':
				$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
				$str = '<input type="hidden" name="'.$attr['name'].'" '. $id_field .' class="'.$attr['class'].'" value="'.$attr['value'].'" '.$attr['other_args'].' />';
				break;

			case 'single_checkbox':
				$str = "";
				$checked = empty($attr['value']) ? '' : 'checked';
				$str .= '<div class="ihc-tos-wrap" id="' . $attr['id'] . '">'
				    		. '<input type="checkbox" value="1" name="' . $attr['name'] . '" class="' . $attr['class'] . '" '.$checked.' />'
								. $attr['label'];
				if (!empty($attr['sublabel'])){
						$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				$str .= '</div>';
				break;

			case 'checkbox':
				$str = '';
				if ($attr['multiple_values']){
					$id = 'ihc_checkbox_parent_' . rand(1,1000);
					$str .= '<div class="iump-form-checkbox-wrapper" id="' . $id . '">';
					foreach ($attr['multiple_values'] as $v){
						if (is_array($attr['value'])){
							$checked = (in_array($v, $attr['value'])) ? 'checked' : '';
						} else {
							$checked = ($v==$attr['value']) ? 'checked' : '';
						}
						$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
						$str .= '<div class="iump-form-checkbox">';
						$str .= '<input type="checkbox" name="'.$attr['name'].'[]" '. $id_field .' class="'.$attr['class'].'" value="' . ihc_correct_text($v, false, true ) . '" '.$checked.' '.$attr['other_args'].' '.$attr['disabled'].'  />';
						$str .= ihc_correct_text($v);
						$str .= '</div>';
					}
					$str .= '</div>';
				}
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'radio':
				$str = '';
				if ($attr['multiple_values']){
					$id = 'ihc_radio_parent_' . rand(1,1000);
					$str .= '<div class="iump-form-radiobox-wrapper" id="' . $id . '">';
					foreach ($attr['multiple_values'] as $v){
						$checked = ($v==$attr['value']) ? 'checked' : '';
						$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
						$str .= '<div class="iump-form-radiobox">';
						$str .= '<input type="radio" name="'.$attr['name'].'" '. $id_field .' class="'.$attr['class'].'" value="' . ihc_correct_text( $v, false, true ) . '" '.$checked.' '.$attr['other_args'].' '.$attr['disabled'].'  />';
						$str .= ihc_correct_text($v);
						$str .= '</div>';
					}
					$str .= '</div>';
				}
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'select':
				$str = '';
				$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
				if ($attr['multiple_values']){
					$str .= '<select name="'.$attr['name'].'" '. $id_field .' class="iump-form-select '.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].' >';
					if ($attr['multiple_values']){
						foreach ($attr['multiple_values'] as $k=>$v){
							$selected = ($k==$attr['value']) ? 'selected' : '';
							$str .= '<option value="'.$k.'" '.$selected.'>' . ihc_correct_text( $v, false, true ) . '</option>';
						}
					}
					$str .= '</select>';
				}
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'multi_select':
				$str = '';
				$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
				if ($attr['multiple_values']){
					$str .= '<select name="'.$attr['name'].'[]" '. $id_field .' class="iump-form-multiselect '.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].' multiple>';
					foreach ($attr['multiple_values'] as $k=>$v){
						if (is_array($attr['value'])){
							$selected = (in_array($v, $attr['value'])) ? 'selected' : '';
						} else {
							$selected = ($v==$attr['value']) ? 'selected' : '';
						}
						$str .= '<option value="'.$k.'" '.$selected.'>' . ihc_correct_text( $v, false, true ) . '</option>';
					}
					$str .= '</select>';
				}
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'submit':
				$id_field = (isset($attr['id']) && $attr['id'] != "" ) ? 'id="'.$attr['id'].'"' : '';
				$str = '<input type="submit" value="' . ihc_correct_text( $attr['value'], false, true ) . '" name="'.$attr['name'].'" '. $id_field .' class="'.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].' />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'date':
				wp_enqueue_script('jquery-ui-datepicker');
				if (empty($attr['class'])){
					$attr['class'] = 'ihc-date-field';
				}
				$str = '';

				global $ihc_jquery_ui_min_css;
				if (empty($ihc_jquery_ui_min_css)){
					$ihc_jquery_ui_min_css = TRUE;
					$str .= '<link rel="stylesheet" type="text/css" href="' . IHC_URL . 'admin/assets/css/jquery-ui.min.css"/>' ;
				}

				if (empty($attr['callback'])){
					$attr['callback'] = '';
				}

				$str .= '<script>
					jQuery(document).ready(function() {
						var currentYear = new Date().getFullYear() + 10;
						jQuery(".'.$attr['class'].'").datepicker({
							dateFormat : "dd-mm-yy",
							changeMonth: true,
						    changeYear: true,
							yearRange: "1900:"+currentYear,
							onClose: function(r) {
								' . $attr['callback'] . '
							}
					});
				});
				</script>
				';
				$str .= '<input type="text" value="'.$attr['value'].'" name="'.$attr['name'].'" id="'.$attr['id'].'" class="iump-form-datepicker '.$attr['class'].'" '.$attr['other_args'].' '.$attr['disabled'].'   placeholder="'.$attr['placeholder'].'" />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'file':
				wp_enqueue_script( 'ihc-jquery_form_module' );
				wp_enqueue_script( 'ihc-jquery_upload_file' );
				$upload_settings = ihc_return_meta_arr('extra_settings');
				$max_size = $upload_settings['ihc_upload_max_size'] * 1000000;
				$rand = rand(1,10000);
				$str .= '<div id="ihc_fileuploader_wrapp_' . $rand . '" class="ihc-wrapp-file-upload  ihc-wrapp-file-field" style=" vertical-align: text-top;">';
				$str .= '<div class="ihc-file-upload ihc-file-upload-button">' . __("Upload", 'ihc') . '</div>
						<script>
							jQuery(document).ready(function() {
								jQuery("#ihc_fileuploader_wrapp_' . $rand . ' .ihc-file-upload").uploadFile({
									onSelect: function (files) {
											jQuery("#ihc_fileuploader_wrapp_' . $rand . ' .ajax-file-upload-container").css("display", "block");
											var check_value = jQuery("#ihc_upload_hidden_'.$rand.'").val();
											if (check_value!="" ){
												alert("To add a new image please remove the previous one!");
												return false;
											}
                							return true;
            						},
									url: "'.IHC_URL.'public/ajax-upload.php",
									fileName: "ihc_file",
									dragDrop: false,
									showFileCounter: false,
									showProgress: true,
									showFileSize: false,
									maxFileSize: ' . $max_size . ',
									allowedTypes: "' . $upload_settings['ihc_upload_extensions'] . '",
									onSuccess: function(a, response, b, c){
										if (response){
											var obj = jQuery.parseJSON(response);
											if (typeof obj.secret!="undefined"){
													jQuery("#ihc_fileuploader_wrapp_' . $rand . '").attr("data-h", obj.secret);
											}
											jQuery("#ihc_fileuploader_wrapp_' . $rand . ' .ihc-file-upload").prepend("<div onClick=\"ihcDeleteFileViaAjax("+obj.id+", -1, \'#ihc_fileuploader_wrapp_' . $rand . '\', \'' . $attr['name'] . '\', \'#ihc_upload_hidden_'.$rand.'\');\" class=\'ihc-delete-attachment-bttn\'>Remove</div>");
											switch (obj.type){
												case "image":
													jQuery("#ihc_fileuploader_wrapp_' . $rand . ' .ihc-file-upload").prepend("<img src="+obj.url+" class=\'ihc-member-photo\' /><div class=\'ihc-clear\'></div>");
												break;
												case "other":
													jQuery("#ihc_fileuploader_wrapp_' . $rand . ' .ihc-file-upload").prepend("<div class=ihc-icon-file-type></div><div class=ihc-file-name-uploaded>"+obj.name+"</div>");
												break;
											}
											jQuery("#ihc_upload_hidden_'.$rand.'").val(obj.id);
											setTimeout(function(){
												jQuery("#ihc_fileuploader_wrapp_' . $rand . ' .ajax-file-upload-container").css("display", "none");
											}, 3000);
										}
									}
								});
							});
						</script>';
				if ($attr['value']){
					$attachment_type = ihc_get_attachment_details($attr['value'], 'extension');
					$url = wp_get_attachment_url($attr['value']);
					switch ($attachment_type){
						case 'jpg':
						case 'jpeg':
						case 'png':
						case 'gif':
							//print the picture
							$str .= '<img src="' . $url . '" class="ihc-member-photo" /><div class="ihc-clear"></div>';
							break;
						default:
							//default file type
							$str .= '<div class="ihc-icon-file-type"></div>';
							break;
					}
					$attachment_name = ihc_get_attachment_details($attr['value']);
					$str .= '<div class="ihc-file-name-uploaded"><a href="' . $url . '" target="_blank">' . $attachment_name . '</a></div>';
					$str .= '<div onClick=\'ihcDeleteFileViaAjax(' . $attr['value'] . ', '.$attr['user_id'].', "#ihc_fileuploader_wrapp_' . $rand . '", "' . $attr['name'] . '", "#ihc_upload_hidden_' . $rand . '");\' class="ihc-delete-attachment-bttn">Remove</div>';
				}
				$str .= '<input type="hidden" value="'.$attr['value'].'" name="' . $attr['name'] . '" id="ihc_upload_hidden_'.$rand.'" />';
				$str .= "</div>";
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;


			case 'upload_image':
					$data = $attr;
					$data['rand'] = rand(1, 10000);
					$data['imageClass'] = 'ihc-member-photo';
					if (empty($data['user_id'])){
					 		$data['user_id'] = -1;
					}
					$data['imageUrl'] = '';
					if ( !empty($data['value']) ){
							if (strpos($data['value'], "http")===0){
									$data['imageUrl'] = $data['value'];
							} else {
									$tempData = \Ihc_Db::getMediaBaseImage($data['value']);
									if (!empty($tempData)){
										$data['imageUrl'] = $tempData;
									}
							}
					}
					$viewObject = new \Indeed\Ihc\IndeedView();
					$str = $viewObject->setTemplate(IHC_PATH.'public/views/upload_image.php')->setContentData( $data )->getOutput();
				break;

			case 'plain_text':
				$str = ihc_correct_text( $attr['value'] );
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'unique_value_text':
				if (empty($attr['id'])){
					$attr['id'] = $attr['name'] . '_' . 'unique';
				}
				$str = '<input type="text" data-search-unique="true" onBlur="ihcCheckUniqueValueField(\'' . $attr['name'] . '\');" name="'.$attr['name'].'" id="'.$attr['id'].'" class="'.$attr['class'].'" value="' . ihc_correct_text( $attr['value'], false, true ) . '" placeholder="'.$attr['placeholder'].'" '.$attr['other_args'].' '.$attr['disabled'].' />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;

			case 'ihc_country':
				wp_enqueue_style( 'ihc_select2_style' );
				wp_enqueue_script( 'ihc-select2' );

				if (empty($attr['id'])){
					$attr['id'] = $attr['name'] . '_field';
				}
				$countries = ihc_get_countries();
				$update_cart = 'ihcUpdateCart();';
				if (isset($attr['form_type']) && $attr['form_type']=='edit'){
					$update_cart = '';
				}

				$onchange = 'onChange="ihcUpdateStateField( true );';

				if (!isset($attr['is_public']) || $attr['is_public']===FALSE){
					$onchange = 'onChange="ihcUpdateStateField();';
				}
				if (isset($attr['ihc_form_type']) && $attr['ihc_form_type']=='edit'){
					$onchange = 'onChange="ihcUpdateStateField();';
				}

				if ( empty( $attr['value'] ) ){
						$attr['value'] = ihcGetDefaultCountry();
				}
				$str .= '<select name="' . $attr['name'] . '" id="' . $attr['id'] . '" ' . $onchange . ' ' . $update_cart . '">'; /// onChange="ihc_update_tax_field();
				foreach ($countries as $k=>$v):
					$selected = ($attr['value']==$k) ? 'selected' : '';
					$str .= '<option value="' . $k . '" ' . $selected . '>' . $v . '</option>';
				endforeach;
				$str .= '</select>';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				$str .= '<ul id="ihc_countries_list_ul" style="display: none;">';

				$str .= '</ul>';
				if ( empty( $attr['is_modal'] ) ){
					$str .= '
					<script>
							jQuery(document).ready(function(){
									jQuery("#' . $attr['id'] . '").select2({
										placeholder: "Select Your Country",
										allowClear: true,
										selectionCssClass: "ihc-select2-dropdown"
									});
							});
					</script>';
				}

				break;

			case 'ihc_state':
				$str = '<input type="text" onBlur="ihcUpdateCart();" name="' . $attr['name'] . '" id="' . $attr['id'] . '" class="' . $attr['class'] . '" value="' . ihc_correct_text($attr['value']) . '" placeholder="' . $attr['placeholder'] . '" ' . $attr['other_args'] . ' ' . $attr['disabled'] . ' />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;
			case 'ihc_invitation_code_field':
				$str = '<input type="text" onBlur="ihcCheckInvitationCode();" name="ihc_invitation_code_field" id="ihc_invitation_code_field" class="'.$attr['class'].'" value="' . ihc_correct_text($attr['value']) . '" placeholder="'.$attr['placeholder'].'" '.$attr['other_args'].' '.$attr['disabled'].' />';
				if (!empty($attr['sublabel'])){
					$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($attr['sublabel']) . '</label>';
				}
				break;
			case 'ihc_dynamic_price':
				if (strcmp($attr['form_type'], 'create')===0 && ihc_is_magic_feat_active('level_dynamic_price') && !empty($attr['lid'])){
					/// only for create
					$lid = $attr['lid'];
					$temp_settings = ihc_return_meta_arr('level_dynamic_price');//getting metas
					if (!empty($temp_settings['ihc_level_dynamic_price_levels_on'][$lid])){
						$temp_level_data = get_option('ihc_levels');
						$level_price = (isset($temp_level_data[$lid]) && isset($temp_level_data[$lid]['price'])) ? $temp_level_data[$lid]['price'] : 0;
						$min = isset($temp_settings['ihc_level_dynamic_price_levels_min'][$lid]) && $temp_settings['ihc_level_dynamic_price_levels_min'][$lid]!='' ? $temp_settings['ihc_level_dynamic_price_levels_min'][$lid] : 0;
						$max = isset($temp_settings['ihc_level_dynamic_price_levels_max'][$lid]) && $temp_settings['ihc_level_dynamic_price_levels_max'][$lid]!='' ? $temp_settings['ihc_level_dynamic_price_levels_max'][$lid] : $level_price;
						$step = isset($temp_settings['ihc_level_dynamic_price_step']) ? $temp_settings['ihc_level_dynamic_price_step'] : 0.01;
						$str .= "<input type='number' onChange='ihcDynamicPriceUpdateGlobal();' onBlur='ihcDynamicPriceUpdateGlobal();' min='$min' max='$max' class='{$attr['class']}' step='$step' value='$level_price' name='ihc_dynamic_price' id='ihc_dynamic_price' />";
					}
				}
				break;
		}
	}
	return $str;
}



function ihc_from_simple_array_to_k_v($arr){
	/*
	 * @param array
	 * @return array
	 */
	$return_arr = array();
	foreach ($arr as $v){
		$return_arr[$v] = $v;
	}
	return $return_arr;
}

function indeed_form_start($action=false, $method=false, $other_stuff=''){
	/*
	 * @param bool, bool, string
	 * @return string
	 */
	$str = '<form action="';
	if($action) $str .= $action;
	else $str .= '';
	$str .= '" method="';
	if($method) $str .= $method;
	else $str .= 'post';
	$str .= '" ';
	$str .= $other_stuff;
	$str .= '>';
	return $str;
}

function indeed_form_end(){
	/*
	 * @param none
	 * @return string
	 */
	return '</form>';
}

function ihc_reorder_arr($arr){
	/*
	 * @param array
	 * @return array
	 */
	if (isset($arr) && count($arr)>0 && $arr !== false){
		$new_arr = false;
		foreach ($arr as $k=>$v){
			$order = $v['order'];
			while (!empty($new_arr[$order])){
				$order++;
			}
			$new_arr[$order][$k] = $v;
		}
		if ($new_arr && count($new_arr)){
			ksort($new_arr);
			foreach ($new_arr as $k=>$v){
				$return_arr[key($v)] = $v[key($v)];
			}
			return $return_arr;
		}
	}
	return $arr;
}

function ihc_check_show($arr=array()){
	/*
	 * @param array
	 * @return array
	 */
	if ($arr!==FALSE && count($arr)>0){
		$new_arr = array();
		foreach ($arr as $k=>$v){
			if (isset($v['show_on'])){
				if($v['show_on'] == 1)
					$new_arr[$k] = $v;
			} else {
				$new_arr[$k] = $v;
			}
		}
		return $new_arr;
	}
	return $arr;
}

function ihc_check_level_restricted_conditions($levels=array()){
	/*
	 * @param array
	 * @return array
	 */
	 $metas = ihc_return_meta_arr('level_subscription_plan_settings');
	 if (!empty($metas['ihc_level_subscription_plan_settings_enabled']) && $levels){
	 	 global $current_user;
		 $uid = (empty($current_user->ID)) ? 0 : $current_user->ID;
		 if (empty($uid)){
		 	 /// will check only for unreg
		 	 foreach ($levels as $id=>$level){
		 	 	if (empty($metas['ihc_level_subscription_plan_settings_restr_levels']) || empty($metas['ihc_level_subscription_plan_settings_restr_levels'][$id])){
		 	 		continue;
		 	 	} else {
		 	 		/// CHECK IF MUST BLOCK THIS LEVEL
		 	 		if ($metas['ihc_level_subscription_plan_settings_condt'] && !empty($metas['ihc_level_subscription_plan_settings_condt'][$id])){
		 	 			$array_check = explode(',', $metas['ihc_level_subscription_plan_settings_condt'][$id]);
						if (in_array('unreg', $array_check)){
							unset($levels[$id]);
						}
		 	 		}
		 	 	}
		 	 }
		 } else {
			 $user_bought_something = Ihc_Db::does_this_user_bought_something($uid);
			 $user_levels = Ihc_Db::get_user_levels($uid);

			 	 foreach ($levels as $id=>$level){
			 	 	if (empty($metas['ihc_level_subscription_plan_settings_restr_levels']) || empty($metas['ihc_level_subscription_plan_settings_restr_levels'][$id])){
			 	 		continue;
			 	 	} else {
			 	 		/// CHECK IF MUST BLOCK THIS LEVEL
			 	 		if ($metas['ihc_level_subscription_plan_settings_condt'] && !empty($metas['ihc_level_subscription_plan_settings_condt'][$id])){
			 	 			$array_check = explode(',', $metas['ihc_level_subscription_plan_settings_condt'][$id]);
							if (!$user_bought_something && in_array('no_pay', $array_check)){
								unset($levels[$id]);
							}
							foreach ($user_levels as $current_level=>$current_level_data){
								if (in_array($current_level, $array_check)){
									unset($levels[$id]);
								}
							}
			 	 		}
			 	 	}
			 	 }

		 }
	 }
	 return $levels;
}

function ihc_return_cc_list($ips_cc_user, $ips_cc_pass){
	/*
	 * @param string, string
	 * @return array
	 */
	if (!class_exists('cc')){
		include_once IHC_PATH .'classes/services/email_services/constantcontact/class.cc.php';
	}
	$list = array();
	$cc = new cc($ips_cc_user, $ips_cc_pass);
	$lists = $cc->get_lists('lists');
	if ($lists){
		foreach ((array) $lists as $v){
			$list[$v['id']] = array('name' => $v['Name']);
		}
	}
	return $list;
}


function ihc_get_all_post_types(){
	/*
	 * use this in front-end, returns all the custom post type available in db
	 * @param none
	 * @return array
	 */
	global $wpdb;
	$arr = array();
	$data = $wpdb->get_results('SELECT DISTINCT post_type FROM ' . $wpdb->prefix . 'posts WHERE post_status="publish";');
	if ($data && count($data)){
		foreach ($data as $obj){
			$arr[] = $obj->post_type;
		}
		$exclude = array('bp-email', 'edd_log', 'nav_menu_item', 'bp-email');
		foreach ($exclude as $e){
			if ($k=array_search($e, $arr)){
				unset($arr[$k]);
				unset($k);
			}
		}
	}
	return $arr;
}

function ihc_get_post_types_be(){
	/*
	 * @param none
	 * @return all custom post type that are registered
	 * use this for back-end actions
	 */
	$args = array('public'=>true, '_builtin'=>false);
	$data = get_post_types($args);
	if (!function_exists('is_plugin_active')){
	 	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	if (is_plugin_active('download-monitor/download-monitor.php')){
		$data[] = 'dlm_download';
	}
	return $data;
}


function ihc_get_post_id_by_cpt_name($custom_post_type='', $post_name=''){
	/*
	 * @param string, string
	 * @return int (id of post, >0 )
	 */
	global $wpdb;
	$table = $wpdb->prefix . 'posts';
	$q = $wpdb->prepare("SELECT ID FROM $table WHERE post_type=%s AND post_name=%s ", $custom_post_type, $post_name);
	$data = $wpdb->get_row($q);
	if (!empty($data->ID)){
		return $data->ID;
	}
	return FALSE;
}

function ihc_get_wp_roles_list(){
	/*
	 * @param none
	 * @return array with all wp roles available without administrator
	 */
	global $wp_roles;
	$roles = $wp_roles->get_names();
    if (!empty($roles)){
    	unset($roles['administrator']);// remove admin role from our list
    	return $roles;
    }
	return FALSE;
}

function ihc_get_multiply_time_value($time_type){
	/*
	 * @param string D,W,M,Y
	 * @return time in seconds
	 */
	$multiply = FALSE;
	switch ($time_type){
		case 'D':
			$multiply = 60*60*24;
		break;
		case 'W':
			$multiply = 60*60*24*7;
		break;
		case 'M':
			$multiply = 60*60*24*31;
		break;
		case 'Y':
			$multiply = 60*60*24*365;
		break;
	}
	return $multiply;
}

function ihc_delete_user_level_relation($l_id=FALSE, $u_id=FALSE){
	/*
	 * delete user meta level, delete relation from table ihc_user_levels
	 * @param level id and user id
	 * @return none
	 */
	if ($u_id && $l_id){
		/*
		$levels_str = get_user_meta($u_id, 'ihc_user_levels', true);
		$levels_arr = explode(',', $levels_str);
		if (!is_array($l_id)){
			$lid_arr[] = $l_id;
		}
		$levels_arr = array_diff($levels_arr, $lid_arr);
		$levels_str = implode(',', $levels_arr);
		update_user_meta($u_id, 'ihc_user_levels', $levels_str);
		*/
		global $wpdb;
		$table_name = $wpdb->prefix . "ihc_user_levels";
		$u_id = esc_sql($u_id);
		$l_id = esc_sql($l_id);
		$wpdb->query('DELETE FROM ' . $table_name . ' WHERE user_id="'.$u_id.'" AND level_id="'.$l_id.'";');
		ihc_downgrade_levels_when_expire($u_id, $l_id);

		do_action('ihc_action_after_subscription_delete', $u_id, $l_id);
		// @description Action that run after delete user level. @param user id (integer), level id (integer)
	}
}

function ihc_update_user_level_expire($level_data, $l_id, $u_id){
	/*
	 * ====================== ACTIVATE LEVEL========================
	 * update expire level for a user with the right expire time
	 * use this only when user has made the payment
	 * @param:
	 * - array with level metas
	 * - level id int
	 * - user id int
	 * - custom expire time
	 * @return none
	 */
	global $wpdb;
	$table = $wpdb->prefix . 'ihc_user_levels';

	if (empty($level_data)){
		$temp_level_data = get_option('ihc_levels');
		if (isset($temp_level_data[$l_id])){
			$level_data = $temp_level_data[$l_id];
		}
	}

	if (empty($level_data['access_type'])){
		$level_data['access_type'] = 'unlimited';
	}

	$current_time = indeed_get_unixtimestamp_with_timezone();
	//getting the current expire time, if it's exists. Old expire time will be current time
	$q = $wpdb->prepare("SELECT expire_time, start_time FROM $table WHERE user_id=%d AND level_id=%d ;", $u_id, $l_id);
	$data = $wpdb->get_row($q);
	if ($data && isset($data->expire_time) && isset($data->start_time)){ //&& !empty($data->expire_time)
		$expire_time = strtotime($data->expire_time);
		$start_time = strtotime($data->start_time);
		if ( $expire_time>0 && $expire_time>indeed_get_unixtimestamp_with_timezone() && $expire_time>$start_time){ /// level has not expired yet
			$current_time = $expire_time;
		} else if ($start_time>$current_time){ /// made for magic feat
			$current_time = $start_time;
		}
	}

	/// LOGS
	Ihc_User_Logs::set_user_id($u_id);
	Ihc_User_logs::set_level_id($l_id);
	$username = Ihc_Db::get_username_by_wpuid($u_id);
	$level_name = Ihc_Db::get_level_name_by_lid($l_id);
	if (empty($expire_time) || $expire_time<0){
		Ihc_User_Logs::write_log(__('Level ', 'ihc') . $level_name . __(' become active for User ', 'ihc') . $username, 'user_logs');
		$first_time = TRUE;
	} else {
		Ihc_User_Logs::write_log(__('Level ', 'ihc') . $level_name . __(' was renewed by User ', 'ihc') . $username, 'user_logs');
		$first_time = FALSE;
	}
	/// LOGS

	//set end time
	switch ($level_data['access_type']){
		case 'unlimited':
			$end_time = strtotime('+10 years', $current_time);//unlimited will be ten years
		break;
		case 'limited':
			if (!empty($level_data['access_limited_time_type']) && !empty($level_data['access_limited_time_value'])){
				$multiply = ihc_get_multiply_time_value($level_data['access_limited_time_type']);
				$end_time = $current_time + $multiply * $level_data['access_limited_time_value'];
			}
		break;
		case 'date_interval':
			if (!empty($level_data['access_interval_end'])){
				$end_time = strtotime($level_data['access_interval_end']);
			}
		break;
		case 'regular_period':
			if (!empty($level_data['access_regular_time_type']) && !empty($level_data['access_regular_time_value'])){
				$multiply = ihc_get_multiply_time_value($level_data['access_regular_time_type']);
				$end_time = $current_time + $multiply * $level_data['access_regular_time_value'];
			}
		break;
	}

	$update_time = indeed_get_current_time_with_timezone();
	// end time will be automated set @wp timezone
	$end_time = indeed_timestamp_to_date_without_timezone( $end_time );

	$q = $wpdb->prepare("UPDATE $table SET update_time='$update_time', expire_time='$end_time', notification=0, status=1 WHERE user_id=%d AND level_id=%d ", $u_id, $l_id);
	$result = $wpdb->query($q);

	do_action('ihc_action_after_subscription_activated', $u_id, $l_id, $first_time);
	// @description Action that run after a subscription(level) is activated. @param user id (integer), level id (integer), flag if it's first time activated (boolean).
}

function ihc_set_level_trial_time_for_no_pay($l_id=-1, $u_id=0, $no_action_fired=FALSE){
	/**
	 * SET THE TRIAL TIME
	 * @param int (level id)
	 * @param int (user id)
	 * @param boolean (true to stop the ihc_action_after_subscription_activated action)
	 * @return none
	 */

	global $wpdb;
	$level_data = ihc_get_level_by_id($l_id);//getting details about current level
	$table = $wpdb->prefix . 'ihc_user_levels';
	$current_time = indeed_get_unixtimestamp_with_timezone();
	$q = $wpdb->prepare("SELECT expire_time FROM $table WHERE user_id=%d AND level_id=%d ;", $u_id, $l_id);
	$data = $wpdb->get_row($q);
	if ($data && !empty($data->expire_time)){
		$expire_time = strtotime($data->expire_time);
		if ($expire_time>0){
			$current_time = $expire_time;
			$first_time = FALSE;
		} else {
			$first_time = TRUE;
		}
	}
	if (!empty($level_data['access_trial_type'])){
		if ($level_data['access_trial_type']==1){
			$multiply = ihc_get_multiply_time_value($level_data['access_trial_time_type']);
			$time_to_add = $level_data['access_trial_time_value'];
		} else {
			///couple of circles
			$multiply = ihc_get_multiply_time_value($level_data['access_regular_time_type']);
			if ( $level_data['access_trial_couple_cycles'] != '' && $level_data['access_trial_couple_cycles'] > 1 ){
					$time_to_add = $level_data['access_regular_time_value'] * $level_data['access_trial_couple_cycles']; // $level_data['access_regular_time_value'];
			} else {
					$time_to_add = $level_data['access_regular_time_value'];
			}
		}

		//if no Trial is set but 100% discount applied
		if(isset($multiply) && $multiply > 0 && isset($time_to_add) && $time_to_add > 0){
			$end_time = $current_time + $multiply * $time_to_add;
		}else{
			$multiply = ihc_get_multiply_time_value($level_data['access_regular_time_type']);
			$time_to_add = $level_data['access_regular_time_value'];
		}

		$end_time = $current_time + $multiply * $time_to_add;

		$update_time = indeed_get_current_time_with_timezone();
		$end_time = indeed_timestamp_to_date_without_timezone( $end_time );

		$q = $wpdb->prepare("UPDATE $table SET update_time='$update_time', expire_time='$end_time', notification=0, status=1 WHERE user_id=%d AND level_id=%d ", $u_id, $l_id);
		$wpdb->query($q);
		if ($no_action_fired) return;
		do_action('ihc_action_after_subscription_activated', $u_id, $l_id, $first_time);
		// @description Action that run after a subscription(level) is activated. @param user id (integer), level id (integer), flag if it's first time activated (boolean).

	}
}

function ihc_get_start_expire_date_for_user_level($u_id, $l_id){
	/*
	 * @param int, int
	 * @return array
	 */
	global $wpdb;
	$table = $wpdb->prefix . 'ihc_user_levels';
	$q = $wpdb->prepare("SELECT expire_time, start_time FROM $table WHERE user_id=%d AND level_id=%d ", $u_id, $l_id);
	$data = $wpdb->get_row($q);
	$arr['start_time'] = (isset($data->start_time)) ? $data->start_time : FALSE;
	$arr['expire_time'] = (isset($data->expire_time)) ? $data->expire_time : FALSE;
	return $arr;
}

function ihc_set_time_for_user_level($u_id, $l_id, $start, $expire){
	/*
	 * @param user id, level id, start time , expire time
	 * @return none
	 */
	global $wpdb;
	$update_time = indeed_get_current_time_with_timezone();

	$table = $wpdb->prefix . 'ihc_user_levels';
	$where_condition = $wpdb->prepare("user_id=%d AND level_id=%d ", $u_id, $l_id);
	$q = "SELECT id FROM $table WHERE $where_condition;";
	$exists = $wpdb->get_row($q);
	if (isset($exists->id)){
		//it's gonna be an update
		$q = "UPDATE $table SET update_time='', start_time=";
		if (!$start){
			$q .= 'null';
		} else {
			$q .= "'" . $start . "'";
		}
		$q .= ", expire_time=";
		if (!$expire){
			$q .= "null,";
		} else {
			$q .= "'" . $expire . "',";
		}
		$q .= " notification=0 ";
		$q .= " WHERE $where_condition;";
	} else {
		//go create new row in db
		$q = $wpdb->prepare("INSERT INTO $table VALUES (null, %d, %d,", $u_id, $l_id);
		if (!$start){
			$q .= 'null';
		} else {
			$q .= "'" . $start . "'";
		}
		$q .=  ", '$update_time'";
		$q .= ", expire_time=";
		if (!$expire){
			$q .= "null";
		} else {
			$q .= "'" . $expire . "'";
		}
		$q .= ", 0, 1)";
	}
	$wpdb->query($q);
}

function ihc_insert_update_transaction($u_id, $txn_id, $post_data, $dont_save_order=FALSE){
	/*
	 * @param user id, trascation id, post data from paypal
	 * @return none
	 */
	//remove quotes from post data

	foreach ($post_data as $k=>$v){
		if (is_string($post_data[$k])){
			if (strpos($post_data[$k], "'")!==FALSE){
				$post_data[$k] = stripslashes($post_data[$k]);
				$post_data[$k] = str_replace("'", "", $post_data[$k]);
			} else if (strpos($post_data[$k], "\'")!==FALSE){
				$post_data[$k] = stripslashes($post_data[$k]);
				$post_data[$k] = str_replace("\'", "", $post_data[$k]);
			}
		}
	}

	global $wpdb;
	$table = $wpdb->prefix . 'indeed_members_payments';
	$q = $wpdb->prepare("SELECT id,txn_id,u_id,payment_data,history,orders,paydate FROM $table WHERE txn_id=%s;", $txn_id);
	$exists = $wpdb->get_row($q);
	if ($exists){
		/************** UPDATE ***************/
		$history = '';
		$q = $wpdb->prepare("SELECT history FROM $table WHERE txn_id=%s ;", $txn_id);
		$history_data = $wpdb->get_row($q);
		if ($history_data && isset($history_data->history)){
			//$history_data = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $history_data->history);
			@$history = unserialize($history_data->history);
		} else {
			$q = $wpdb->prepare("SELECT payment_data FROM $table WHERE txn_id=%s;", $txn_id);
			$history_data = $wpdb->get_row($q);
			if (isset($history_data->payment_data)){
				$temp = (array)json_decode($history_data->payment_data);
				if (isset($temp['custom'])) unset($temp['custom']);
				if (isset($temp['transaction_subject'])) unset($temp['transaction_subject']);
				$history[] = $temp;
			}
		}
		//remove custom from history
		$post_data_history = $post_data;
		if (isset($post_data_history['custom'])) unset($post_data_history['custom']);
		if (isset($post_data_history['transaction_subject'])) unset($post_data_history['transaction_subject']);
		$history[indeed_get_unixtimestamp_with_timezone()] = $post_data_history;
		$history_string = serialize($history);

		$q = $wpdb->prepare("UPDATE $table SET history=%s WHERE txn_id=%s ", $history_string, $txn_id);
		$wpdb->query($q);

		//////////update payment_data (last $_REQUEST )
		$post_data = json_encode($post_data);
		$q = $wpdb->prepare("UPDATE $table SET payment_data=%s WHERE txn_id=%s ", $post_data, $txn_id);
		$wpdb->query($q);

	} else {
		/************* insert ************/

		/////the history
		$post_data_history = $post_data;
		if (isset($post_data_history['custom'])) unset($post_data_history['custom']);
		if (isset($post_data_history['transaction_subject'])) unset($post_data_history['transaction_subject']);
		$history[ indeed_get_unixtimestamp_with_timezone() ] = $post_data_history;
		$history_str = serialize($history);

		////the payment data
		$post_data = json_encode($post_data);

		/// since version 8.6, before we used NOW() function in mysql
		$currentDate = indeed_get_current_time_with_timezone();

		$q = $wpdb->prepare("INSERT INTO $table VALUES (null, %s, %d, %s, %s, null, %s );", $txn_id, $u_id, $post_data, $history_str, $currentDate );
		$wpdb->query($q);
	}

	if ($dont_save_order){
		return;
	}
	/// ORDER
	require_once IHC_PATH . 'classes/Orders.class.php';
	$object = new Ump\Orders();
	$object->do_insert_update($txn_id);
}

function ihc_insert_update_order($uid=0, $lid=0, $amount_value=0, $status='pending', $payment_gateway='', $extra_fields=array(), $amount_type=''){
	/*
	 * @param int, int, float, string
	 * @return int
	 */
	if (!empty($uid) && isset($lid) && isset($amount_value)){
		require_once IHC_PATH . 'classes/Orders.class.php';
		$object = new Ump\Orders();
		if (empty($amount_type)){
				$amount_type = get_option('ihc_currency');
		}
		$order_id = $object->do_insert(array(
									'uid' 							=> $uid,
									'lid' 							=> $lid,
									'amount_type' 			=> $amount_type,
									'amount' 						=> $amount_value,
									'status' 						=> $status,
									'ihc_payment_type'  => $payment_gateway,
									'extra_fields' 			=> $extra_fields,
		));
		return $order_id;
	}
}

if ( !function_exists( 'ihc_user_has_level' ) ):
	/**
	 * DEPRECATED
	 * @param int
	 * @param int
	 * @return bool
	 */
function ihc_user_has_level($u_id, $l_id)
{
  $hasLevel = \Ihc_Db::user_has_level( $u_id, $l_id );
	if ( !$hasLevel ){
			return false;
	}
	$isActive = \Ihc_Db::is_user_level_active( $u_id, $l_id );
	if ( $isActive ){
			return true;
	}
	return false;
}
endif;

function ihc_user_has_level_admin($uid, $lid){
	/*
	 * @param int, int
	 * @return bool
	 */

	global $wpdb;
	$data = $wpdb->get_row("SELECT id FROM " . $wpdb->prefix . "ihc_user_levels
								WHERE user_id='" . $uid . "'
								AND level_id='" . $lid . "';");
	if ($data!==FALSE && isset($data->id)){
		return TRUE;
	}
	return FALSE;
}

function ihc_insert_debug_payment_log($source, $data){
	/*
	 * insert into ihc_debug_payments
	 * @param source = type of payment service (paypall)
	 * data = the request from payment service
	 * @return none
	 */
	global $wpdb;
	$table = $wpdb->prefix . "ihc_debug_payments";
	$time = indeed_get_current_time_with_timezone();

	$data = serialize($data);
	$q = $wpdb->prepare("INSERT INTO $table VALUES(null, %s, %s, %s);", $source, $data, $time );
	$wpdb->query($q);
}

function ihc_send_user_notifications($u_id=FALSE, $notification_type='', $l_id=FALSE, $dynamic_data=array(), $subject='', $message=''){
	/*
	 * main function for notification module
	 * send e-mail to user
	 * @param:
	 * user id ($u_id) - int,
	 * notification type ($notification_type) - string
	 * optional level id ($l_id) - int, -1 means all levels
	 * dynamic_data - array
	 * subject - string
	 * message - string
	 * @return TRUE if mail was sent, FALSE otherwise
	 */
	global $wpdb;
	$sent = FALSE;
	if ($u_id && $notification_type){
		$admin_case = array(
							'admin_user_register',
							'admin_before_user_expire_level',
							'admin_second_before_user_expire_level',
							'admin_third_before_user_expire_level',
							'admin_user_expire_level',
							'admin_user_payment',
							'admin_user_profile_update',
							'ihc_cancel_subscription_notification-admin',
							'ihc_delete_subscription_notification-admin',
							'ihc_order_placed_notification-admin',
							'ihc_new_subscription_assign_notification-admin',
		);

		if (empty($subject) || empty($message)){ /// SEARCH INTO DB FOR NOTIFICATION TEMPLATE
			if ($l_id!==FALSE && $l_id>-1){
				$q = $wpdb->prepare("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM " . $wpdb->prefix . "ihc_notifications
										WHERE 1=1
										AND notification_type=%s
										AND level_id=%d
										ORDER BY id DESC LIMIT 1;", $notification_type, $l_id);
				$data = $wpdb->get_row($q);
				if ($data){
						$subject = @$data->subject;
						$message = @$data->message;

						$domain = 'ihc';
						$languageCode = get_user_meta( $u_id, 'ihc_locale_code', true );
						$wmplName = $notification_type . '_title_' . $l_id;
						$subject = apply_filters( 'wpml_translate_single_string', $subject, $domain, $wmplName, $languageCode );
						$wmplName = $notification_type . '_message_' . $l_id;
						$message = apply_filters( 'wpml_translate_single_string', $message, $domain, $wmplName, $languageCode );
				}
			}
			if ($l_id===FALSE || $l_id==-1 || empty($data)){
				$q = $wpdb->prepare("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM " . $wpdb->prefix . "ihc_notifications
										WHERE 1=1
										AND notification_type=%s
										AND level_id='-1'
										ORDER BY id DESC LIMIT 1;", $notification_type);
				$data = $wpdb->get_row($q);
				if ($data){
						$subject = @$data->subject;
						$message = @$data->message;

						$domain = 'ihc';
						$languageCode = get_user_meta( $u_id, 'ihc_locale_code', true );
						$wmplName = $notification_type . '_title_-1';
						$subject = apply_filters( 'wpml_translate_single_string', $subject, $domain, $wmplName, $languageCode );
						$wmplName = $notification_type . '_message_-1';
						$message = apply_filters( 'wpml_translate_single_string', $message, $domain, $wmplName, $languageCode );
				}
			}
		}

		if (!empty($message)){
			$from_name = get_option('ihc_notification_name');
			if (!$from_name){
				$from_name = get_option("blogname");
			}
			//user levels
			$level_list_data = \Ihc_Db::getUserLevelsAsList( $u_id, true );
			if (isset($level_list_data)){
				$level_list_data = explode(',', $level_list_data);
				foreach ($level_list_data as $id){
					$temp_level_data = ihc_get_level_by_id($id);
					if ( isset( $temp_level_data['label'] ) ){
							$level_list_arr[] = $temp_level_data['label'];
					}
				}
				if ( !empty( $level_list_arr ) ){
					$level_list = implode(',', $level_list_arr);
				}
			}
			//user data
			$u_data = get_userdata($u_id);
			$user_email = '';
			if ($u_data && !empty($u_data->data) && !empty($u_data->data->user_email)){
				$user_email = $u_data->data->user_email;
			}
			//from email
			$from_email = get_option('ihc_notification_email_from');
			if (!$from_email){
				$from_email = get_option('admin_email');
			}
			$message = ihc_replace_constants($message, $u_id, $l_id, $l_id, $dynamic_data);
			$subject = ihc_replace_constants($subject, $u_id, $l_id, $l_id, $dynamic_data);
			$message = stripslashes(htmlspecialchars_decode(ihc_format_str_like_wp($message)));
			$message = apply_filters('ihc_send_notification_filter_message', $message, $u_id, $l_id, $notification_type);
			// @description Filter for notification message. @param the message (text), user id (integer), level id (integer), notification type (string)

			$message = "<html><head></head><body>" . $message . "</body></html>";
			if ($subject && $message && $user_email){
				if (in_array($notification_type, $admin_case)){
					/// SEND NOTIFICATION TO ADMIN, (we change the destination)
					$admin_email = get_option('ihc_notification_email_addresses');
					if (empty($admin_email)){
						$user_email = get_option('admin_email');
					} else {
						$user_email = $admin_email;
					}
				}
				if (!empty($from_email) && !empty($from_name)){
					$headers[] = "From: $from_name <$from_email>";
				}
				$headers[] = 'Content-Type: text/html; charset=UTF-8';
				$sent = wp_mail($user_email, $subject, $message, $headers);
			}
		}
		/// PUSHOVER
		if (ihc_is_magic_feat_active('pushover')){
			$send_to_admin = in_array($notification_type, $admin_case) ? TRUE : FALSE;
			require_once IHC_PATH . 'classes/services/Ihc_Pushover.class.php';
			$pushover_object = new Ihc_Pushover();
			$pushover_object->send_notification($u_id, $l_id, $notification_type, $send_to_admin);
		}
		/// PUSHOVER
	}
	return $sent;
}

function ihc_get_uid_lid_by_stripe($stripe_txn_id=''){
	/*
	 * @param transaction id - string
	 * @return array
	 */
	global $wpdb;
	$q = $wpdb->prepare("SELECT id,txn_id,u_id,payment_data,history,orders,paydate FROM " . $wpdb->prefix ."indeed_members_payments WHERE `txn_id`=%s ;", $stripe_txn_id);
	$db_data = $wpdb->get_row($q);
	$data = array();
	if ($db_data){
		if (isset($db_data->u_id)){
			$data['uid'] = $db_data->u_id;
		}
		if (isset($db_data->payment_data)){
			$data_db_json = json_decode($db_data->payment_data, TRUE);
			if (isset($data_db_json['level'])){
				$data['lid'] = $data_db_json['level'];
			}
			$data['payment_data'] = $data_db_json;
		}
	}
	return $data;
}

function ihc_get_lid_uid_by_txn_id($txn_id=''){
	/*
	 * @param string
	 * @return array
	 */
	global $wpdb;
	$table = $wpdb->prefix . "indeed_members_payments";
	$q = $wpdb->prepare("SELECT payment_data FROM $table WHERE txn_id=%s;", $txn_id);
	$data = $wpdb->get_row($q);
	if ($data && !empty($data->payment_data)){
		$temp = json_decode($data->payment_data, TRUE);
		return $temp;
	}
	return array();
}

function ihc_twocheckout_submit($u_id, $l_id, $code='', $ihc_country=FALSE){
	/*
	 * Redirect to 2checkout payment
	 * @param int, int, string, string
	 * @return none
	 */

	Ihc_User_Logs::set_user_id($u_id);
	Ihc_User_Logs::set_level_id($l_id);
	Ihc_User_Logs::write_log( __('2Checkout Payment: Start process', 'ihc'), 'payments');

	$level_data = get_option('ihc_levels');
	$amount = $level_data[$l_id]['price'];
	$currency = get_option('ihc_currency');
	$checkout_account_num = get_option('ihc_twocheckout_account_number');
	$custom_currency_code = get_option('ihc_custom_currency_code');
	if ($custom_currency_code){
		$currency = $custom_currency_code;
	}

	/*************************** DYNAMIC PRICE ***************************/
	if (ihc_is_magic_feat_active('level_dynamic_price') && isset($_POST['ihc_dynamic_price'])){
		$temp_amount = $_POST['ihc_dynamic_price'];
		if (ihc_check_dynamic_price_from_user($l_id, $temp_amount)){
			$amount = $temp_amount;
			Ihc_User_Logs::write_log( __('2Chekcout Payment: Dynamic price on - Amount is set by the user @ ', 'ihc') . $amount . $currency, 'payments');
		}
	}
	/**************************** DYNAMIC PRICE ***************************/

	//========= DISCOUNT
	if ($code){
		$coupon_data = ihc_check_coupon($code, $l_id);
		if ($coupon_data){
			Ihc_User_Logs::write_log( __('2Checkout Payment: the user used the following coupon: ', 'ihc') . $code, 'payments');
			if (isset($level_data[$l_id]['access_type']) && $level_data[$l_id]['access_type']=='regular_period'){
				//discount on recurring payment
				if (empty($coupon_data['reccuring'])){
					//just one time
					$discount_once = -($amount - ihc_coupon_return_price_after_decrease($amount, $coupon_data, TRUE, $u_id, $l_id));
				} else {
					//on every payment
					$amount = ihc_coupon_return_price_after_decrease($amount, $coupon_data, TRUE, $u_id, $l_id);
				}
			} else {
				//discount on single payment
				$amount = ihc_coupon_return_price_after_decrease($amount, $coupon_data, TRUE, $u_id, $l_id);
			}
		}
	}

	///TAXES
	$state = get_user_meta($u_id, 'ihc_state', TRUE);
	$country = ($ihc_country==FALSE) ? '' : $ihc_country;
	$taxes_data = ihc_get_taxes_for_amount_by_country($country, $state, $amount);
	if ($taxes_data && !empty($taxes_data['total'])){
		$taxes = $taxes_data['total'];
		$amount += $taxes;
		Ihc_User_Logs::write_log( __('2Checkout Payment: taxes value: ', 'ihc') . $taxes . $currency, 'payments');
	}

	$li_0_name = (empty($level_data[$l_id]['label'])) ? 'Level ' . $l_id : $level_data[$l_id]['label'];

	Ihc_User_Logs::write_log( __('2Checkout Payment: amount set @ ', 'ihc') . $amount . $currency, 'payments');

	$params_arr = array(
			'sid' => $checkout_account_num,
			'mode' => '2CO',
			'pay_method' => 'CC',
			'li_0_type' => 'product',
			'li_0_name' => $li_0_name,
			'li_0_product_id' => $l_id,
			'li_0_quantity' => 1,
			'li_0_price' => $amount,
			'li_0_tangible' => 'N',
			'li_0_description' => json_encode(array("u_id" => $u_id, "l_id" => $l_id)),
			'currency_code' => $currency,
			'x_receipt_link_url' => admin_url("admin-ajax.php") . "?action=ihc_twocheckout_ins",//
			'purchase_step' => 'billing-information',
	);

	//====================== RECURRING
	if (isset($level_data[$l_id]['access_type']) && $level_data[$l_id]['access_type']=='regular_period'){

		switch ($level_data[$l_id]['access_regular_time_type']){
			case 'D':
				$weeks = $level_data[$l_id]['access_regular_time_value'] / 7;
				if ($weeks<1){
					$weeks = 1;
				}
				$reccurence_time = ceil($weeks) . ' Week';
				$billing = ceil($weeks) . ' Week';
				break;
			case 'W':
				$reccurence_time = $level_data[$l_id]['access_regular_time_value'] . ' Week';
				$billing = $level_data[$l_id]['billing_limit_num'] . ' Week';
				break;
			case 'M':
				$reccurence_time = $level_data[$l_id]['access_regular_time_value'] . ' Month';
				$billing = $level_data[$l_id]['billing_limit_num'] . ' Month';
				break;
			case 'Y':
				$reccurence_time = $level_data[$l_id]['access_regular_time_value'] . ' Year';
				$billing = $level_data[$l_id]['billing_limit_num'] . ' Year';
				break;
		}
		$params_arr['li_0_recurrence'] = $reccurence_time;//billing frequency. Ex. �1 Week� to bill order once a week. (Can use # Week, # Month, or # Year)
		$params_arr['li_0_duration'] = $billing;//how long to continue billing. Ex. �1 Year�, to continue billing for 1 year. (Forever or # Week, # Month, # Year)

		//trial for a single subscribe payment
		if (isset($level_data[$l_id]['access_trial_type']) && $level_data[$l_id]['access_trial_type']==2 && isset($level_data[$l_id]['access_trial_couple_cycles']) && $level_data[$l_id]['access_trial_couple_cycles']>0){
			////DISCOUNT
			$params_arr['li_0_startup_fee'] = $level_data[$l_id]['access_trial_price'] - $amount;
			if (!empty($discount_once)){
				//discount just once on recurring with trial period
				$params_arr['li_0_startup_fee'] = $params_arr['li_0_startup_fee'] + $discount_once;
			}
		} else if (!empty($discount_once)){
			//discount just once on recurring without trial period
			$params_arr['li_0_startup_fee'] = $discount_once;
		}

		/// TAXES
		if (isset($params_arr['li_0_startup_fee']) && !empty($ihc_country)){
			$state = get_user_meta($u_id, 'ihc_state', TRUE);
			$country = ($ihc_country==FALSE) ? '' : $ihc_country;
			$taxes_data = ihc_get_taxes_for_amount_by_country($country, $state, $params_arr['li_0_startup_fee']);
			if ($taxes_data && !empty($taxes_data['total'])){
				$taxes = $taxes_data['total'];
				$params_arr['li_0_startup_fee'] += $taxes;
				Ihc_User_Logs::write_log( __('2Checkout Payment: taxes value: ', 'ihc') . $taxes . $currency, 'payments');
			}
		}
	}

	$sandbox = get_option('ihc_twocheckout_sandbox');
	if ($sandbox){
		// $base_url = "sandbox.2checkout.com";
		$base_url = "www.2checkout.com";
		$params_arr['demo'] = 'Y';
		Ihc_User_Logs::write_log( __('2Checkout Payment: Set Sandbox mode.', 'ihc'), 'payments');
	} else {
		$base_url = "www.2checkout.com";
		Ihc_User_Logs::write_log( __('2Checkout Payment: Set Live mode.', 'ihc'), 'payments');
	}

	$params_str = '';
	foreach ($params_arr as $k=>$v){
		if (empty($params_str)){
			$params_str = '?';
		} else {
			$params_str .= '&';
		}
		$params_str .= urlencode($k) . "=" . urlencode($v);
	}

	Ihc_User_Logs::write_log( __('2Checkout Payment: Submit data to 2checkout.', 'ihc'), 'payments');
	$redirect_url = 'https://' . $base_url . '/checkout/purchase' . $params_str;

	//logout user...
	//wp_logout();
	wp_redirect( $redirect_url );
	exit();
}

function ihc_print_bank_transfer_order($u_id, $l_id){
	/*
	 * print the bank transfer message
	 * @param int, int, string, int
	 * @return string
	 */
	$msg = get_option('ihc_bank_transfer_message');
	if (!empty($_GET['cp'])){
		$discount_type = 'percentage';
		$discount_value = $_GET['cp'];
	} else if (!empty($_GET['cc'])) {
		$discount_type = 'flat';
		$discount_value = $_GET['cc'];
	}
	//get amount
	$level_data = ihc_get_level_by_id($l_id);
	$orderId = \Ihc_Db::getLastOrderIdByUserAndLevel( $u_id, $l_id );
	$orderAmount = \Ihc_Db::getOrderAmount( $orderId );
	$amount = isset( $orderAmount ) ? $orderAmount : '';

	$currency = get_option( 'ihc_currency' );
	$amount = ihc_format_price_and_currency( $currency, $amount );
	$msg = str_replace('{amount}', $amount, $msg);
	$msg = str_replace('{currency}', '', $msg);

	$msg = ihc_replace_constants($msg, $u_id, $l_id, $l_id);

	//ihc_send_user_notifications($u_id, 'bank_transfer', $l_id);

	return '<div class="ihc-bank-transfer-msg" id="ihc_bt_success_msg">' . ihc_correct_text($msg) . '</div>';
}

function ihc_get_amount_after_discount_for_bt_show($discount_type='', $discount_value=0, $amount=0){
	/*
	 * @param string, int, string, int
	 * @return string
	 */
	if ($discount_type=='percentage'){
		$amount = $amount - ($amount*$discount_value/100);
	} else {
		$amount = $amount - $discount_value;
	}
	$amount = round($amount, 2);
	return $amount;
}

function ihc_downgrade_levels_when_expire($uid, $lid){
	/*
	 * add after expire level for specified user
	 * @param user id, level id
	 * @return bool, true if succeed
	 */
	$level_data = ihc_get_level_by_id($lid);
	if (isset($level_data['afterexpire_level']) && $level_data['afterexpire_level']!=-1){
		$succees = ihc_handle_levels_assign($uid, $level_data['afterexpire_level']);//assign the new level expire time and stuff...
		if ($succees){
			return TRUE;
		}
	}
	return FALSE;
}

function ihc_handle_levels_assign($uid=0, $lid=-1, $custom_start_time=0, $custom_end_time=0){
	if ($uid && $lid!=-1){
		$level_data = ihc_get_level_by_id($lid);//getting details about current level
		$current_time = indeed_get_unixtimestamp_with_timezone();

		///USER LOGS
		Ihc_User_Logs::set_user_id($uid);
		Ihc_User_Logs::set_level_id($lid);
		$username = Ihc_Db::get_username_by_wpuid($uid);
		$level_name = Ihc_Db::get_level_name_by_lid($lid);
		Ihc_User_Logs::write_log($username . __(' chose Level ', 'ihc') . $level_name, 'user_logs');

		if (empty($level_data['access_type'])){
			$level_data['access_type'] = 'unlimited';
		}

		//set start time
		if ( $level_data['access_type']=='date_interval' && !empty($level_data['access_interval_start']) ){
			$start_time = strtotime($level_data['access_interval_start']);
		} else {
			$start_time = $current_time;
			////// MAGIC FEAT - SUBSCRIPTION DELAY /////
			if (ihc_is_magic_feat_active('subscription_delay')){
				$delay_time = Ihc_Db::level_get_delay_time($lid);
				if ($delay_time!==FALSE){
					$start_time = $start_time + $delay_time;
				}
			}
			////// MAGIC FEAT - SUBSCRIPTION DELAY /////
		}

		//set end time
		if ($level_data['payment_type']=='payment'){
			//end time will be expired, updated when payment
			$end_time = Ihc_Db::user_get_expire_time_for_level($uid, $lid);
			if ($end_time===FALSE || strtotime($end_time)<indeed_get_unixtimestamp_with_timezone()){
				$end_time = '0000-00-00 00:00:00';
			}
		} else {
			//it's free so we set the correct expire time
			switch ($level_data['access_type']){
				case 'unlimited':
					$end_time = strtotime('+10 years', $current_time);//unlimited will be ten years
					break;
				case 'limited':
					if (!empty($level_data['access_limited_time_type']) && !empty($level_data['access_limited_time_value'])){
						$multiply = ihc_get_multiply_time_value($level_data['access_limited_time_type']);
						$end_time = $current_time + $multiply * $level_data['access_limited_time_value'];
					}
					break;
				case 'date_interval':
					if (!empty($level_data['access_interval_end'])){
						$end_time = strtotime($level_data['access_interval_end']);
					}
					break;
				case 'regular_period':
					if (!empty($level_data['access_regular_time_type']) && !empty($level_data['access_regular_time_value'])){
						$multiply = ihc_get_multiply_time_value($level_data['access_regular_time_type']);
						$end_time = $current_time + $multiply * $level_data['access_regular_time_value'];
					}
					break;
			}//end of switch
			$end_time = indeed_timestamp_to_date_without_timezone( $end_time );

			/// user logs
			Ihc_User_Logs::set_user_id($uid);
			Ihc_User_Logs::set_level_id($lid);
			$username = Ihc_Db::get_username_by_wpuid($uid);
			$level_name = Ihc_Db::get_level_name_by_lid($lid);
			Ihc_User_Logs::write_log($level_name . __(' become active for ', 'ihc') . $username, 'user_logs', $lid);
		}

		$update_time = indeed_timestamp_to_date_without_timezone( $current_time );
		if (!empty($custom_start_time)){
			$start_time = indeed_timestamp_to_date_without_timezone( $custom_start_time );
		} else {
			$start_time = indeed_timestamp_to_date_without_timezone( $start_time );
		}
		if (!empty($custom_end_time)){
			$end_time = indeed_timestamp_to_date_without_timezone( $custom_end_time );
		}

		global $wpdb;
		$table = $wpdb->prefix . 'ihc_user_levels';
		$q = $wpdb->prepare("SELECT id,user_id,level_id,start_time,update_time,expire_time,notification,status FROM $table WHERE user_id=%d AND level_id=%d", $uid, $lid);
		$exists = $wpdb->get_row($q);

		//if ( $end_time != '0000-00-00 00:00:00' ){ // && !empty($custom_end_time)
		//		$end_time = indeed_timestamp_to_date_without_timezone( $end_time );
		//}

		if (!empty($exists)){
			/// UPDATE
			//$q = $wpdb->prepare("DELETE FROM $table WHERE user_id=%d AND level_id=%d ;", $uid, $lid);
			//$wpdb->query($q);//assure that pair user_id - level_id entry not exists
			$q = $wpdb->prepare("UPDATE $table SET
										start_time=%s,
										update_time=%s,
										expire_time=%s,
										notification=0,
										status=1
										WHERE
										user_id=%d
										AND level_id=%d;",  $start_time, $update_time, $end_time, $uid, $lid);
		} else {
			/// INSERT
			$q = $wpdb->prepare("INSERT INTO $table	VALUES(null, %d, %d, %s, %s, %s, 0, 1);", $uid, $lid, $start_time, $update_time, $end_time);
		}
		$wpdb->query($q);
		do_action('ihc_new_subscription_action', $uid, $lid);
		// @description Action that run after a subscription(level) is activated. @param user id (integer), level id (integer)

		return TRUE;
	}
	return FALSE;
}

/**
 * generate csv file with all users
 * @param none
 * @return string, link to csv file or empty string
 */
if ( !function_exists( 'ihc_make_csv_user_list' ) ):
function ihc_make_csv_user_list( $attributes=array() )
{

	global $wpdb;
	$levelDetails = \Ihc_Db::getLevelsDetails();
	$possibles = array(
		'search_user',
		'levels',
		'roles',
		'order',
		'levelStatus',
		'approvelRequest',
		'emailVerification',
		'advancedOrder',
	);
	$applyFilters = false;
	foreach ( $possibles as $possible ){
			if ( isset( $attributes[$possible] ) ){
				$applyFilters = true;
			}
	}

	$searchUsers = new \Indeed\Ihc\Db\SearchUsers();
	$searchUsers->setLimit( 0 )
							->setOffset( 0 )
							->setLid( -1 );
	if ( $applyFilters ){
			$limit = (isset($attributes['ihc_limit'])) ? $attributes['ihc_limit'] : 25;
			$start = 0;
			if(isset($attributes['ihcdu_page'])){
				$pg = $attributes['ihcdu_page'] - 1;
				$start = (int)$pg * $limit;
			}
			$search_query = isset($attributes['search_user']) ? $attributes['search_user'] : '';
			$filter_role = isset($attributes['roles']) ? $attributes['roles'] : '';
			$search_level = isset($attributes['levels']) ? $attributes['levels'] : -1;
			$order = isset($attributes['order']) ? $attributes['order'] : 'user_registered_desc'; // user_registered_desc
			$approveRequest = isset( $attributes['approvelRequest'] ) && $attributes['approvelRequest'] ? true : false;
			$advancedOrder = isset( $attributes['advancedOrder'] ) ? $attributes['advancedOrder'] : '';
			$levelStatus = isset( $attributes['levelStatus'] ) ? $attributes['levelStatus'] : '';
			$emailVerification = isset( $attributes['emailVerification'] ) && $attributes['emailVerification'] ? 1 : 0;
			$searchUsers = new \Indeed\Ihc\Db\SearchUsers();

			$searchUsers->setLimit(0)
									//->setLimit( $limit )
									//->setOffset( $start )
									->setOrder( $order )
									->setLid( $search_level )
									->setSearchWord( $search_query )
									->setRole( $filter_role )
									->setAdvancedOrder( $advancedOrder )
									->setLevelStatus( $levelStatus )
									->setOnlyDoubleEmailVerification( $emailVerification )
									->setApprovelRequest( $approveRequest );
	}
	$users = $searchUsers->getResults();

	if ($users){
		//if we have users
		//$hash = md5( 'users' . indeed_get_unixtimestamp_with_timezone() . 'ump');
		$hash = bin2hex( random_bytes( 20 ) );
		$file_path = IHC_PATH . 'temporary/' . $hash . '.csv';
		$file_link = IHC_URL . 'temporary/' . $hash . '.csv';

		// remove old files
		if (file_exists($file_path)){
				unlink($file_path);
		}
		$directory = IHC_PATH . 'temporary/';
		$files = scandir( $directory );
		foreach ( $files as $file ){
				$fileFullPath = $directory . $file;
				if ( file_exists( $fileFullPath ) && filetype( $fileFullPath ) == 'file' ){
						$extension = pathinfo( $fileFullPath, PATHINFO_EXTENSION );
						if ( $extension == 'csv' ){
								unlink( $fileFullPath );
						}
				}
		}

		// create file
		$file_resource = fopen($file_path, 'w');

		$register_fields = ihc_get_user_reg_fields();
		foreach ($register_fields as $k=>$v){
			if ($v['name']=='pass1' || $v['name']=='pass2' || $v['name']=='tos' || $v['name']=='recaptcha' || $v['name']=='confirm_email' || $v['name']=='ihc_social_media' || $v['name'] == 'ihc_dynamic_price' ){
				unset($register_fields[$k]);
			} else {
				if (isset($v['native_wp']) && $v['native_wp']){
					$data[] = __($v['label'], 'ihc');
				} else {
					$data[] = $v['label'];
				}
			}
		}
		$data[] = __('Level', 'ihc');
		$data[] = __('Start time', 'ihc');
		$data[] = __('Expire time', 'ihc');
		$data[] = __('WP User Roles', 'ihc');
		$data[] = __('Join Date', 'ihc');

		/// top of CSV file
		fputcsv($file_resource, $data, ",");
		unset($data);

		foreach ($users as $user){

				foreach ($register_fields as $v){
						if (isset($user->{$v['name']})){
								$the_user_data[] = $user->{$v['name']};
						} else {
								$user_data = get_user_meta($user->ID, $v['name'], true);
								if ($user_data!==FALSE){
										if (is_array($user_data)){
											$the_user_data[] = implode(",", $user_data);
										} else {
											$the_user_data[] = $user_data;
										}
								} else {
										$the_user_data[] = ' ';
								}
						}
				}

				$levels = array();
				if ( $user->levels && stripos( $user->levels, ',' ) !== false ){
						$levels = explode( ',', $user->levels );
				} else {
						$levels[] = $user->levels;
				}
				//$levels = Ihc_Db::get_user_levels($user->ID);
				if ($levels){
						/// with levels
						foreach ($levels as $level_data){
								if ( $level_data == -1 ){
										/// NO LEVELS
										$data = $the_user_data;
										$data[] = '-'; /// LEVEL
										$data[] = '-'; /// start TIME
										$data[] = '-'; /// Expire TIME
										$data[] = $user->roles;
										$data[] = $user->user_registered;
										fputcsv($file_resource, $data, ",");
										unset($data);
										continue;
								}
								if ( strpos( $level_data, '|' ) !== false ){
										$levelDataArray = explode( '|', $level_data );
								} else {
										$levelDataArray = array();
								}

								$lid = isset( $levelDataArray[0] ) ? $levelDataArray[0] : '';
								$level_data = array(
											'level_id'		=> $lid,
											'start_time'	=> isset( $levelDataArray[1] ) ? $levelDataArray[1] : '',
											'expire_time' => isset( $levelDataArray[2] ) ? $levelDataArray[2] : '',
											'level_slug'	=> isset( $levelDetails[$lid]['slug'] ) ? $levelDetails[$lid]['slug'] : '',
											'label'				=> isset( $levelDetails[$lid]['label'] ) ? $levelDetails[$lid]['label'] : '',
								);

								$data = $the_user_data;
								$data[] = $level_data['label']; /// LEVEL
								$data[] = $level_data['start_time']; /// start TIME
								$data[] = $level_data['expire_time']; /// Expire TIME
								$data[] = $user->roles;
								$data[] = $user->user_registered;
								fputcsv($file_resource, $data, ",");
								unset($data);
						}
				} else {
						/// NO LEVELS
						$data = $the_user_data;
						$data[] = '-'; /// LEVEL
						$data[] = '-'; /// start TIME
						$data[] = '-'; /// Expire TIME
						$data[] = $user->roles;
						$data[] = $user->user_registered;
						fputcsv($file_resource, $data, ",");
						unset($data);
				}
				unset($the_user_data);
		} /// end of foreach  users
		fclose($file_resource);
		return $file_link;
	}
	return '';
}
endif;

function ihc_get_attachment_details($id, $return_type='name'){
	/*
	 * @param attachment id, what to return: name or extension
	 * @return string :
	 */
	$attachment_data = wp_get_attachment_url($id);
	if (isset($attachment_data)){
		$attachment_arr = explode('/', $attachment_data);
		if (isset($attachment_arr)){
			end($attachment_arr);
			$attachment_name = $attachment_arr[key($attachment_arr)];
			if ($return_type=='name'){
				return $attachment_name;
			}
			$attachment_type = explode('.', $attachment_name);
			if (isset($attachment_type)){
				end($attachment_type);
				if (isset($attachment_type[key($attachment_type)])){
					return $attachment_type[key($attachment_type)];
				}
			}
		}
	}
	return 'Unknown';
}


function ihc_replace_constants( $string='', $uid=0, $current_lid=-1, $lid=-1, $dynamic_data=array() ){
	if ($uid){
		/// first we replace the dynamic data passed as arg
		if (!empty($dynamic_data)){
			foreach ($dynamic_data as $k=>$v){
				$string = str_replace($k, $v, $string);
			}
		}
		/// extract constants
		preg_match_all("/{([^}]*)}/", $string, $results);
		if (isset($results[1])){
			foreach ($results[1] as $constant){
				$replace = '';
				switch ($constant){
					case 'user_id':
					case 'uid':
						$replace = $uid;
						break;
					case 'level_id':
					case 'lid':
						$replace = $lid;
						break;
					case 'username':
						$replace = Ihc_Db::get_user_col_value($uid, 'user_login'); /// uid, col_name
						break;
					case 'CUSTOM_FIELD_user_url':
						$replace = Ihc_Db::get_user_col_value($uid, 'user_url'); /// uid, col_name
						break;
					case 'user_login':
					case 'user_email':
					case 'user_url':
					case 'user_nicename':
					case 'user_registered':
					case 'display_name':
						$replace = Ihc_Db::get_user_col_value($uid, $constant); /// uid, col_name
						if ($constant=='user_registered'){
							$replace = ihc_convert_date_to_us_format($replace);
						}
						break;
					case 'first_name':
						$replace = get_user_meta($uid, 'first_name', true);
						break;
					case 'last_name':
						$replace = get_user_meta($uid, 'last_name', true);
						break;
					case 'current_level':
						if ($current_lid>-1){
							$current_level_data = ihc_get_level_by_id($current_lid);
							$replace = $current_level_data['label'];
						}
						break;
					case 'level_expire_time':
						if ($lid>-1){
							$time = ihc_get_start_expire_date_for_user_level($uid, $lid);
							$replace = ihc_convert_date_to_us_format($time['expire_time']);
						} else if ($current_lid>-1){
							$time = ihc_get_start_expire_date_for_user_level($uid, $current_lid);
							$replace = ihc_convert_date_to_us_format($time['expire_time']);
						}
						break;
					case 'current_level_expire_date':
						if ($lid>-1){
							$time = ihc_get_start_expire_date_for_user_level($uid, $current_lid);
							$replace = ihc_convert_date_to_us_format($time['expire_time']);
						}
						break;
					case 'level_list':
						$level_list = Ihc_Db::get_user_levels($uid);
						if (!empty($level_list)){
							foreach ($level_list as $id=>$t_arr){
								$level_list_arr[] = $t_arr['label'];
							}
							if ($level_list_arr){
								$replace = implode(',', $level_list_arr);
							}
						}
						break;
					case 'account_page':
						$account_page = get_option("ihc_general_user_page");
						if ($account_page){
							$replace = get_permalink($account_page);
						}
						break;
					case 'login_page':
						$login_page = get_option("ihc_general_login_default_page");
						if ($login_page){
							$replace = get_permalink($login_page);
						}
						break;
					case 'blogname':
						$replace = get_option("blogname");
						break;
					case 'blogurl':
					case 'site_url':
						$replace = get_option("siteurl");
						break;
					case 'level_name':
						if ($lid>-1){
							$level_data = ihc_get_level_by_id($lid);
							$replace = $level_data['label'];
						}
						break;
					case 'amount':
						if (isset($dynamic_data['order_id'])){
							$replace = Ihc_Db::getOrderAmount($dynamic_data['order_id']);
						} else if ($lid>-1){
							$level_data = ihc_get_level_by_id($lid);
							$replace = $level_data['price'];
							$state = get_user_meta($uid, 'ihc_state', TRUE);
							$country = get_user_meta($uid, 'ihc_country', TRUE);
							$taxes_data = ihc_get_taxes_for_amount_by_country($country, $state, $replace);
							if (isset($taxes_data['total'])){
								$replace = $replace + $taxes_data['total'];
							}
						}
						break;
					case 'currency':
						$replace = get_option('ihc_currency');
						$currency_custom_code = get_option('ihc_custom_currency_code');
	                    if (!empty($currency_custom_code)){
	                         $replace = $currency_custom_code;
	                    }
						break;
					case 'current_date':
						$replace = ihc_convert_date_to_us_format(date('Y-m-d H:i:s'));
						break;
					case 'ihc_avatar':
						$avatar = ihc_get_avatar_for_uid($uid);
						if (!empty($avatar)){
							$replace = '<img src="' . $avatar . '" class=""/>';
						}
						break;
					case 'flag':
						$replace = ihc_user_get_flag($uid);
						break;
					default:
						if (strpos($constant, 'CUSTOM_FIELD_')!==FALSE){
							$search_key = str_replace("CUSTOM_FIELD_", "", $constant);
							$replace = get_user_meta($uid, $search_key, TRUE);
							if (is_array($replace)){
								$replace = implode(',', $replace);
							}
						} else {
							///search data into wp_usermeta
							$replace = get_user_meta($uid, $constant, TRUE);
							if (is_array($replace)){
								$replace = implode(',', $replace);
							}
						}
						break;
				} /// end of switch
				$string = str_replace("{" . $constant . "}", $replace, $string);
			} ///end of foreach
		}
	}
	return $string;
}


function ihc_user_get_flag($uid=0, $class='ihc-public-flag'){
	/*
	 * @param int (user id), string (class of image)
	 * @return string (image)
	 */
	$flag = get_user_meta($uid, 'ihc_country', true);
	if (empty($flag)){
		return '';
	} else {
		$countries = ihc_get_countries();
		$key = $flag;
		$flag = strtolower($flag);
		$country = $countries[strtoupper($key)];
		$title = (empty($country)) ? '' : $country;
		return '<img src="' . IHC_URL . 'assets/flags/' . $flag . '.svg" class="' . $class . '" title="' . $title . '" />';
	}
}

function ihc_random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
	/*
	 * @param length - int, keyspace - string
	 * @return string
	 */
	$str = '';
	$max = mb_strlen($keyspace, '8bit') - 1;
	for ($i = 0; $i < $length; ++$i) {
		$str .= $keyspace[rand(0, $max)];
	}
	return $str;
}

function ihc_generate_alias_name($length=6, $check=array()){
	/*
	 * @param length, array
	 * @return string
	 */
	$keyspace = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$str = '';
	$max = mb_strlen($keyspace, '8bit') - 1;
	for ($i = 0; $i < $length; ++$i) {
		$str .= $keyspace[rand(0, $max)];
	}
	while (in_array($str, $check)){
		ihc_generate_alias_name($length, $check);
	}
	return $str;
}

function ihc_cancel_twocheckout_subscription($transaction_id){
	/*
	 * @param string
	 * @return boolean
	 */
	require_once IHC_PATH . 'classes/PaymentGateways/twocheckout/Twocheckout.php';
	//set API connection vars
	$api_user = get_option('ihc_twocheckout_api_user');
	$api_pass = get_option('ihc_twocheckout_api_pass');
	$api_private_key = get_option('ihc_twocheckout_private_key');
	$account_num = get_option('ihc_twocheckout_account_number');
	$sandbox = get_option('ihc_twocheckout_sandbox');

	Twocheckout::sellerId($account_num);
	Twocheckout::privateKey($api_private_key);
	Twocheckout::username($api_user);
	Twocheckout::password($api_pass);
	Twocheckout::$verifySSL = false;

	$params = array();
	$params['sale_id'] = $transaction_id;
	if($sandbox){
		Twocheckout::sandbox(true);
		$params['demo'] = 'Y';
	} else {
		Twocheckout::sandbox(false);
	}
	try {
		$result = Twocheckout_Sale::stop( $params );
	} catch(Exception $e){

	}

	// Successfully cancelled
	if (isset($result['response_code']) && $result['response_code'] === 'OK') {
		return true;
	} else {
		//fail
		return false;
	}
}

function ihc_show_cancel_level_link($u_id, $l_id){
	/*
	 * @param user id, level id
	 * @return bool, true if we can show the cancel buntton
	 */
	$level_data = ihc_get_level_by_id($l_id);
	if (isset($level_data['access_type']) && $level_data['access_type']=='regular_period'){//only for reccurence
		global $wpdb;
		$u_id = esc_sql($u_id);
		$l_id = esc_sql($l_id);
		$data = $wpdb->get_row("SELECT status FROM " . $wpdb->prefix . "ihc_user_levels WHERE user_id='" . $u_id . "' AND level_id='" . $l_id . "';");
		if ($data && $data->status){
			return TRUE;
		}
	}
	return FALSE;
}

/*
function ihc_cancel_level($u_id, $l_id, $dont_redirect_paypal=FALSE){

	$txn_id = '';
	$payment_type = '';
	global $wpdb;
	$table = $wpdb->prefix . "indeed_members_payments";
	$q = $wpdb->prepare("SELECT txn_id, payment_data FROM $table WHERE u_id=%d ORDER BY paydate DESC;", $u_id);
	$data = $wpdb->get_results($q);
	//we need to select last transaction that involved this level id
	foreach ($data as $obj){
		$arr = json_decode($obj->payment_data, TRUE);

		$completed = FALSE;
		if (!empty($arr['payment_status'])){
			$completed = TRUE;
		} else if (isset($arr['x_response_code']) && ($arr['x_response_code'] == 1)){
			$completed = TRUE;
		} else if (isset($arr['code']) && ($arr['code'] == 2)){
			$completed = TRUE;
		} else if (isset($arr['message']) && $arr['message']=='success'){
			$completed = TRUE;
		}

		if (!$completed){
			continue;
		}

		if (isset($arr['ihc_payment_type'])){
			//in case we know the payment type
			$payment_type = $arr['ihc_payment_type'];
			switch ($arr['ihc_payment_type']){
				case 'paypal':
					$custom = json_decode(stripslashes($arr['custom']), TRUE);
					if (isset($custom['level_id']) && $custom['level_id']==$l_id){
						//it what we looking for
						$txn_id = $obj->txn_id;
						$payment_type = 'paypal';
						break 2;
					}
					break;
				case 'stripe':
				case 'twocheckout':
				case 'authorize':
					if (isset($arr['level']) && $arr['level']==$l_id){
						$txn_id = $obj->txn_id;
						break 2;
					}
					break;
			}//end of switch
		} else {
			//don't know from where the payment was made
			$payment_type = get_option('ihc_payment_selected');
			if (isset($arr['custom'])){
				$custom = json_decode($arr['custom'], TRUE);
				if ($custom['level_id']==$l_id){
					//it's paypal and it's the level we want
					$txn_id = $obj->txn_id;
					$payment_type = 'paypal';
					break;
				}
			} else if (isset($arr['level']) && $arr['level']==$l_id){
				$txn_id = $obj->txn_id;
			}
		}

	}//end of foreach

	if ($txn_id && $payment_type){
		//if we have the transaction id, payment type && user id we can go further
		switch ($payment_type){
			case 'paypal':
				if (!empty($dont_redirect_paypal)){
					break;
				}
				$sandbox = get_option('ihc_paypal_sandbox');
				$alias = get_option('ihc_paypal_email');
				$merchant_id = get_option('ihc_paypal_merchant_account_id');
				if ($merchant_id){
					$alias = $merchant_id;
				}
				if ($sandbox){
					$url = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=" . urlencode($alias);
				} else {
					$url = "https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=" . urlencode($alias);
				}
				wp_redirect($url);
				exit();
				break;
			case 'stripe':
				if (!class_exists('ihcStripe')){
					require_once IHC_PATH . 'classes/PaymentGateways/ihcStripe.class.php';
				}
				$obj = new ihcStripe();
				$obj->cancel_subscription($txn_id);
				break;
			case 'twocheckout':
				ihc_cancel_twocheckout_subscription($txn_id);
				break;
			case 'authorize':
				if (!class_exists('ihcAuthorizeNet')){
					require_once IHC_PATH . 'classes/PaymentGateways/ihcAuthorizeNet.class.php';
				}
				$obj = new ihcAuthorizeNet();
				$unsubscribe = $obj->cancel_subscription($txn_id);
				break;
		}

		//after we cancel the subscription in payment service, we must modify the status in our db
		$table = $wpdb->prefix . "ihc_user_levels";
		$q = $wpdb->prepare("UPDATE $table SET status='0' WHERE user_id=%d AND level_id=%d;", $u_id, $l_id);
		$wpdb->query($q);
		do_action('ihc_action_after_cancel_subscription', $u_id, $l_id);
	}
}
*/

function ihc_show_renew_level_link($l_id){
	/*
	 * @param level id
	 * @return bool, true if we must show to renew level link
	 */
	$level_data = ihc_get_level_by_id($l_id);
	if (isset($level_data['access_type']) && $level_data['access_type']=='limited'){
		return TRUE;
	}
	return FALSE;
}


function ihc_stripe_renew_script($form_id){
	/*
	 * @param string
	 * @return string
	 */
	$publishable_key = get_option('ihc_stripe_publishable_key');
	global $current_user;
	$uid = (!empty($current_user) && !empty($current_user->ID)) ? $current_user->ID : 0;
	$email = !empty($current_user->user_email) ? $current_user->user_email : '';
	if ($email){
			$email = 'email: "' . $email . '", ';
	} else {
			$email = '';
	}
	$top_logo = get_option('ihc_stripe_popup_image');
	$button_label = get_option('ihc_stripe_bttn_value');
	$locale_code = get_option('ihc_stripe_locale_code');
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
	$multiply =  ihcStripeMultiplyForCurrency( get_option( 'ihc_currency') );

	$str ='';
	$str .= '<script src="https://checkout.stripe.com/checkout.js"></script>
	<script>
	var renew_stripe = StripeCheckout.configure({
		key: "' . $publishable_key . '",
		' . $locale . '
		' . $image . '
		' . $bttn . '
		' . $email . '
		token: function(response) {
			var input = jQuery("<input type=hidden name=stripeToken id=stripeToken />").val(response.id);
			var email = jQuery("<input type=hidden name=stripeEmail id=stripeEmail />").val(response.email);
			jQuery("' . $form_id . '").append(input);
			jQuery("' . $form_id . '").append(email);
			jQuery("' . $form_id . '").submit();
		}
	});

	function ihc_stripe_renew_payment(l_name, l_amount, lid){
		var multiply = ' . $multiply . ';
		var l_amount = l_amount * multiply;
		if ( multiply == 100 && l_amount>0 && l_amount<50){
			l_amount = 50;
		}
		jQuery("#ihc_renew_level").val(lid);
		if (jQuery("#ihc_coupon").val()){
			jQuery.ajax({
						type : "post",
						url : "' . IHC_URL . 'public/ajax-custom.php",
						data : {
							    ihc_coupon: jQuery("#ihc_coupon").val(),
							    l_id: lid,
							    initial_price: l_amount
						},
						success: function (data) {
							if (data!=0){
								if (jQuery("#ihc_coupon").val()){
									jQuery("' . $form_id . '").append("<input type=hidden value=" + jQuery("#ihc_coupon").val() + " name=ihc_coupon />");
								}
								var obj = jQuery.parseJSON(data);
								if (typeof obj.price!="undefined"){
									var l_amount = obj.price;
									if (multiply==100 && l_amount>0 && l_amount<50){
										l_amount = 50;
									}


								if(l_amount == 0)
									return;
									///
										jQuery.ajax({
													type: "post",
													url: decodeURI(window.ihc_site_url)+"/wp-admin/admin-ajax.php",
										   	 		data: {
										   	 				action: "ihc_get_amount_plus_taxes_by_uid",
										               		uid: "' . $uid . '",
										               		price: l_amount,
										   	 		},
										   	 		success: function(data){
										   	 				if (data){
										   	 					var l_amount = data;
										   	 				}
															renew_stripe.open({
																name: l_name,
																email:"'.$current_user->user_email.'",
																description: "Level "+lid,
																amount: l_amount,
															});
										   	 		}
										});
									///
								}
							}
						}
			});
		} else {
			jQuery.ajax({
					type: "post",
					url: decodeURI(window.ihc_site_url)+"/wp-admin/admin-ajax.php",
		   	 		data: {
		   	 				action: "ihc_get_amount_plus_taxes_by_uid",
		               		uid: "' . $uid . '",
		               		price: l_amount,
		   	 		},
		   	 		success: function(data){
	   	 				if (data){
	   	 					var l_amount = data;
	  	 				}
						renew_stripe.open({
							name: l_name,
							email:"'.$current_user->user_email.'",
							description: "Level "+lid,
							amount: l_amount,
						});
					}
			});
		}
	}
	</script>';
	return $str;
}

function ihc_get_user_level_status_for_ac($u_id, $l_id){
	/*
	 * @param int, int
	 * @return string
	 */
	$status = __('Active', 'ihc');
	global $wpdb;
	$u_id = esc_sql($u_id);
	$l_id = esc_sql($l_id);
	$data = $wpdb->get_row("SELECT id,user_id,level_id,start_time,update_time,expire_time,notification,status FROM " . $wpdb->prefix ."ihc_user_levels WHERE user_id='$u_id' AND level_id='$l_id' ");
	if ($data){
		if ($data->status==0){
			$status =  __('Canceled', 'ihc');
		} else {
			$grace_period = get_option('ihc_grace_period');
			if ($grace_period===FALSE){
					return $status;
			}
			$expire_time_after_grace = strtotime($data->expire_time) + (int)$grace_period * 24 * 60 * 60;
			if ($expire_time_after_grace<0){
				$status = __("Hold", 'ihc');
			} else if (indeed_get_unixtimestamp_with_timezone()>$expire_time_after_grace){
				$status = __("Expired", 'ihc');
			} else if (strtotime($data->start_time)>indeed_get_unixtimestamp_with_timezone()){
				$status = __("Inactive", 'ihc');
			}
		}
	}
	return $status;
}

function ihc_is_level_on_hold($uid=0, $lid=0){
	/*
	 * @param int, int
	 * @return boolean
	 */
	$bool = FALSE;
	global $wpdb;
	$table = $wpdb->prefix . "ihc_user_levels";
	$uid = esc_sql($uid);
	$lid = esc_sql($lid);
	$data = $wpdb->get_row("SELECT id,user_id,level_id,start_time,update_time,expire_time,notification,status FROM $table WHERE user_id=$uid AND level_id=$lid;");
	if ($data){
		if ($data->status==0){
			return $bool;
		} else {
			$grace_period = get_option('ihc_grace_period');
			$expire_time_after_grace = strtotime($data->expire_time) + (int)$grace_period * 24 * 60 * 60;
			if ($expire_time_after_grace<0){
				return TRUE;
			}
		}
	}
	return $bool;
}

function ihc_set_level_status($u_id='', $l_id='', $status=''){
	/*
	 * @param: user id, level id, status
	 * status must be : 1 (in case the level can be renew) or 2 (in case of level it's renewed)
	 * @return none
	 */
	global $wpdb;
	$table = $wpdb->prefix . 'ihc_user_levels';
	$q = $wpdb->prepare("SELECT id,user_id,level_id,start_time,update_time,expire_time,notification,status FROM $table WHERE user_id=%d AND level_id=%d ;", $u_id, $l_id);
	$exists = $wpdb->get_row($q);
	if ($exists){
		$q = $wpdb->prepare("UPDATE $table SET status='$status' WHERE user_id=%d AND level_id=%d ;", $u_id, $l_id);
		$wpdb->query($q);
	}
}

function ihc_check_social_status($type){
	/*
	 * @param string name of social media
	 * @return array
	 */
	$return = array();
	$return['active'] = '';
	$return['status'] = 0;
	$return['settings'] = 'Uncompleted';
	switch ($type){
		case 'fb':
			$arr = ihc_return_meta_arr('fb');
			if (!empty($arr['ihc_fb_app_id']) && !empty($arr['ihc_fb_app_secret'])){
				$return['settings'] = 'Completed';
			}
			if (!empty($arr['ihc_fb_status'])){
				$return['status'] = 1;
				$return['active'] = 'fb-active';
			}
			break;
		case 'tw':
			$arr = ihc_return_meta_arr('tw');
			if (!empty($arr['ihc_tw_app_key']) && !empty($arr['ihc_tw_app_secret'])){
				$return['settings'] = 'Completed';
			}
			if (!empty($arr['ihc_tw_status'])){
				$return['status'] = 1;
				$return['active'] = 'tw-active';
			}
			break;
		case 'in':
			$arr = ihc_return_meta_arr('in');
			if (!empty($arr['ihc_in_app_key']) && !empty($arr['ihc_in_app_secret'])){
				$return['settings'] = 'Completed';
			}
			if (!empty($arr['ihc_in_status'])){
				$return['status'] = 1;
				$return['active'] = 'in-active';
			}
			break;
		case 'tbr':
			$arr = ihc_return_meta_arr('tbr');
			if (!empty($arr['ihc_tbr_app_key']) && !empty($arr['ihc_tbr_app_secret'])){
				$return['settings'] = 'Completed';
			}
			if (!empty($arr['ihc_tbr_status'])){
				$return['status'] = 1;
				$return['active'] = 'tbr-active';
			}
			break;
		case 'ig':
			$arr = ihc_return_meta_arr('ig');
			if (!empty($arr['ihc_ig_app_id']) && !empty($arr['ihc_ig_app_secret'])){
				$return['settings'] = 'Completed';
			}
			if (!empty($arr['ihc_ig_status'])){
				$return['status'] = 1;
				$return['active'] = 'ig-active';
			}
			break;
		case 'vk':
			$arr = ihc_return_meta_arr('vk');
			if (!empty($arr['ihc_vk_app_id']) && !empty($arr['ihc_vk_app_secret'])){
				$return['settings'] = 'Completed';
			}
			if (!empty($arr['ihc_vk_status'])){
				$return['status'] = 1;
				$return['active'] = 'vk-active';
			}
			break;
		case 'goo':
			$arr = ihc_return_meta_arr('goo');
			if (!empty($arr['ihc_goo_app_id']) && !empty($arr['ihc_goo_app_secret'])){
				$return['settings'] = 'Completed';
			}
			if (!empty($arr['ihc_goo_status'])){
				$return['status'] = 1;
				$return['active'] = 'goo-active';
			}
			break;
	}
	return $return;
}

function ihc_generate_color_hex(){
	/*
	 * @param none
	 * @return string
	 */
	$colors =  array('#0a9fd8', '#38cbcb', '#27bebe', '#0bb586', '#94c523', '#6a3da3', '#f1505b', '#ee3733', '#f36510', '#f8ba01');
	return $colors[rand(0, (count($colors)-1) )];
}

//=================== COUPONS
function ihc_create_coupon($post_data=array()){
	/*
	 * @param post_data (array)
	 * @return boolean
	 */
	if ($post_data){
		global $wpdb;
		if (!empty($post_data['how_many_codes'])){
			// ============== MULTIPLE COUPONS ===============//
			$settings = serialize($post_data);
			$prefix = $post_data['code_prefix'];
			$prefix_length = strlen($post_data['code_prefix']);
			$length = $post_data['code_length'] - $prefix_length;
			$limit = $post_data['how_many_codes'];
			unset($post_data['how_many_codes']);
			unset($post_data['code_prefix']);
			unset($post_data['code_length']);
			if (empty($post_data['discount_value'])){
				return;
			}
			while ($limit){
				$code = ihc_random_str($length);
				$code = $prefix . $code;
				$code = str_replace(' ', '', $code);
				$code = ihc_make_string_simple($code);
				$data = $wpdb->get_row("SELECT id,code,settings,submited_coupons_count,status FROM " . $wpdb->prefix ."ihc_coupons WHERE code='" . $code . "';");
				if ($data){
					continue;
				}
				$wpdb->query("INSERT INTO " . $wpdb->prefix ."ihc_coupons VALUES( '', '" . $code ."', '" . $settings . "', 0, 1);");
				$limit--;
			}
		} else {
			//============== SINGLE COUPON ==================//
			if (empty($post_data['code']) || empty($post_data['discount_value'])){
				return FALSE;
			}
			//check if this code already exists
			$data = $wpdb->get_row("SELECT id,code,settings,submited_coupons_count,status FROM " . $wpdb->prefix ."ihc_coupons WHERE code='" . $post_data['code'] . "';");
			if ($data){
				return FALSE;
			}
			$code = str_replace(' ', '', $post_data['code']);
			$code = ihc_make_string_simple($code);
			unset($post_data['code']);
			if (isset($post_data['special_status'])){
				$status = $post_data['special_status'];
				unset($post_data['special_status']);
			} else {
				$status = 1;
			}
			$settings = serialize($post_data);
			$wpdb->query("INSERT INTO " . $wpdb->prefix ."ihc_coupons VALUES( '', '" . $code ."', '" . $settings . "', 0, $status);");
			return TRUE;
		}
	}
}

function ihc_update_coupon($post_data=array()){
	/*
	 * @param post_data (array)
	 * @return none
	 */
	if ($post_data){
		if (empty($post_data['code']) || empty($post_data['discount_value'])){
			return FALSE;
		}
		global $wpdb;
		$id = esc_sql($post_data['id']);
		unset($post_data['id']);
		$data = $wpdb->get_row("SELECT id,code,settings,submited_coupons_count,status FROM " . $wpdb->prefix ."ihc_coupons WHERE id='" . $id . "';");
		if ($data){
			$code = str_replace(' ', '', $post_data['code']);
			$code = ihc_make_string_simple($post_data['code']);
			unset($post_data['code']);
			unset($post_data['id']);
			$settings = serialize($post_data);
			$wpdb->query("UPDATE " . $wpdb->prefix ."ihc_coupons
							SET code='" . $code . "', settings='" . $settings . "'
							WHERE id='".$id."';
			");
		}
	}
}

function ihc_delete_coupon($id){
	/*
	 * @param id (int)
	 * @return none
	 */
	global $wpdb;
	$q = $wpdb->prepare("SELECT id,code,settings,submited_coupons_count,status FROM ".$wpdb->prefix."ihc_coupons WHERE id=%d;", $id);
	$exists = $wpdb->get_row($q);
	if ($exists){
		$q = $wpdb->prepare("DELETE FROM ".$wpdb->prefix."ihc_coupons WHERE id=%d;", $id);
		$wpdb->query($q);
	}
}

function ihc_submit_coupon($code='', $uid=0, $lid=0){
	/*
	 * todo: a class for submit coupon
	 * @param string
	 * @return boolean
	 */
	global $wpdb;
	//check if this code already exists
	$code = str_replace(' ', '', $code);
	if (defined('IHC_COUPON_SUBMITED')){
			return; /// preventing from accidently submit the same coupon twice
	} else {
			define('IHC_COUPON_SUBMITED', 1);
	}
	$q = $wpdb->prepare("SELECT submited_coupons_count FROM " . $wpdb->prefix ."ihc_coupons WHERE code=%s ;", $code);
	$data = $wpdb->get_row($q);
	if (isset($data->submited_coupons_count)){
		$submited_coupons_count = (int)$data->submited_coupons_count;
		$submited_coupons_count++;
		$table = $wpdb->prefix ."ihc_coupons";
		$q = $wpdb->prepare("UPDATE $table
								SET submited_coupons_count=%d
								WHERE code=%s;", $submited_coupons_count, $code );
		$wpdb->query($q);

		do_action('ump_coupon_code_submited', $code,  $uid, $lid);
		// @description Run after coupon code was submited. @param coupon code, user id, level id.

		return TRUE;
	}
	return FALSE;
}

function ihc_get_coupon_by_code($code=''){
	/*
	 * @param string
	 * @return array
	 */
	$return_data = array();
	if ($code){
		global $wpdb;
		$code = str_replace(' ', '', $code);
		$q = $wpdb->prepare("SELECT id,code,settings,submited_coupons_count,status FROM " . $wpdb->prefix . "ihc_coupons	WHERE code=%s ;", $code);
		$data = $wpdb->get_row($q);
		if ($data){
			$return_data = unserialize($data->settings);
			$return_data['code'] = $data->code;
			$return_data['submited_coupons_count'] = $data->submited_coupons_count;
		}
	}
	return $return_data;
}

function ihc_get_all_coupons(){
	/*
	 * @param none
	 * @return array
	 */
	$return_data = array();
	global $wpdb;
	$data = $wpdb->get_results("SELECT id,code,settings,submited_coupons_count,status FROM " . $wpdb->prefix . "ihc_coupons WHERE status=1;");
	if ($data){
		foreach ($data as $obj){
			$return_data[$obj->id]['code'] = $obj->code;
			$return_data[$obj->id]['settings'] = unserialize($obj->settings);
			$return_data[$obj->id]['submited_coupons_count'] = $obj->submited_coupons_count;
		}
	}
	return $return_data;
}

function ihc_get_coupon_by_id($id=0){
	/*
	 * @param string
	 * @return array
	 */
	$arr = array();
	if ($id){
		global $wpdb;
		$q = $wpdb->prepare("SELECT id,code,settings,submited_coupons_count,status FROM " . $wpdb->prefix . "ihc_coupons	WHERE id=%d ", $id);
		$data = $wpdb->get_row($q);
		if ($data && isset($data->code) && isset($data->settings)){
			$arr = unserialize($data->settings);
			$arr['code'] = $data->code;
		}
	} else {
		$arr = array(
						"code" => "",
						"discount_type" => "percentage",
						"discount_value" => '10',
						"period_type" => "unlimited",
						"repeat" => "10",
						"target_level" => "",
						"reccuring" => "1",
						"start_time" => '',
						"end_time" => '',
						"box_color" => ihc_generate_color_hex(),
						"description" => "",
					);
	}
	return $arr;
}


function ihc_check_coupon($coupon='', $level_id=-1)
{
	$empty = array();
	if (!$coupon || $level_id==-1){
		return $empty;
	}
	$coupon_data = ihc_get_coupon_by_code($coupon);
	if ($coupon_data){

		if (!empty($coupon_data['repeat']) && ($coupon_data['repeat']<=$coupon_data['submited_coupons_count'])){
			//out of repeat number
			return $empty;
		}

		if ($coupon_data['period_type']=='date_range' && !empty($coupon_data['start_time']) && !empty($coupon_data['end_time'])){
			//we must check the time
			$start_time = strtotime($coupon_data['start_time']);
			$end_time = strtotime($coupon_data['end_time']);
			$current_time = indeed_get_unixtimestamp_with_timezone();
			if ($start_time>$current_time){
				//not begin coupon time
				return $empty;
			}
			if ($current_time>$end_time){
				//out of date
				return $empty;
			}
		}
		if ($coupon_data['target_level']>-1){
			if ($coupon_data['target_level']!=$level_id){
				//it's not the target level
				return $empty;
			}
		}
		return array(
						"discount_type" => $coupon_data['discount_type'],
						"discount_value" => $coupon_data['discount_value'],
						"reccuring" => $coupon_data['reccuring'],
						"code" => $coupon,
		);
	}
	return $empty;
}


function ihc_coupon_return_price_after_decrease($price=0, $coupon_data=array(), $update_coupon_count=TRUE, $uid=0, $lid=0){
	/*
	 * @param price int, coupon data array, update coupon count bool
	 * @return price int
	 */
	if ($price && $coupon_data){
		if ($coupon_data['discount_type']=='percentage'){
			$price = $price - ($price*$coupon_data['discount_value']/100);
		} else {
			$price = $price - $coupon_data['discount_value'];
		}
		$price = round($price, 2);

		if ($price<0){
			$price = 0; //// price cannot be negative
		}

		if ($update_coupon_count){
			//lets update the coupon count in db
			ihc_submit_coupon($coupon_data['code'], $uid, $lid);
		}
	}
	return $price;
}

function ihc_get_discount_value($price=0, $coupon_data=array()){
	/*
	 * @param int, int
	 * @return none
	 */
	if ($price && $coupon_data){
		if ($coupon_data['discount_type']=='percentage'){
			return ($price*$coupon_data['discount_value']/100);
		} else {
			return $coupon_data['discount_value'];
		}
	}
}


function ihc_dont_pay_after_discount($level_id, $coupon, $level_arr, $update_coupon_count=FALSE){
	/*
	 * if the price after discount is 0 will return TRUE
	 * @param level_id - int, coupon - string, level_arr - array, update_coupon_count - array
	 * @return boolean
	 */
	if (!empty($coupon)){
		if (isset($level_arr['access_type']) && $level_arr['access_type']!='regular_period'){
			//not reccurence
			$coupon_data = ihc_check_coupon($coupon, $level_id);
			$level_arr['price'] = ihc_coupon_return_price_after_decrease($level_arr['price'], $coupon_data, FALSE);
			if ($level_arr['price']==0){
				if ($update_coupon_count){
					//update coupon count
					ihc_submit_coupon($coupon);
				}
				return TRUE;
			}
		}
	}
	return FALSE;
}

function ihc_get_redirect_link_by_label($name='', $uid=0){
	/*
	 * @param string, int (USER ID used for login first redirect, when current_user is not available)
	 * @return string
	 */
	if ($name=='#individual_page#'){
		if (empty($uid)){
			global $current_user;
			if (!empty($current_user->ID)){
				$uid = $current_user->ID;
			}
		}
		if (!empty($uid)){
			$individual_page = get_user_meta($uid, 'ihc_individual_page', TRUE);
			if ($individual_page){
				$redirect_to = get_permalink($individual_page);
				if ($redirect_to){
					return $redirect_to;
				}
			}
		}
	} else {
		$data = get_option("ihc_custom_redirect_links_array");
		if (isset($data[$name])){
			return $data[$name];
		}
	}
	return '';
}

function ihc_run_opt_in($email='', $target_opt_in=''){
	/*
	 * @param string
	 * @return none
	 */
	if (!$target_opt_in){
		$target_opt_in = get_option('ihc_register_opt-in-type');
	}
	do_action('ihc_run_opt_in_action', $email, $target_opt_in);
	// @description Run on opt in. @param email (string), type of service for opt-in (string)

	if ($target_opt_in && $email){
		if (!class_exists('IhcMailServices')){
			require_once IHC_PATH . 'classes/IhcMailServices.class.php';
		}
		$uid = \Ihc_Db::get_wpuid_by_email( $email );
		if ( isset( $_POST['first_name'] ) ){
				$firstName = esc_sql( $_POST['first_name'] );
		} else {
				$firstName = get_user_meta( 'first_name', $uid, true );
		}
		if ( !$firstName ){
				$firstName = '';
		}
		if ( isset( $_POST['last_name'] ) ){
				$lastName = esc_sql( $_POST['last_name'] );
		} else {
				$lastName = get_user_meta( 'last_name', $uid, true );
		}
		if ( !$lastName ){
				$lastName = '';
		}

		$indeed_mail = new IhcMailServices();
		$indeed_mail->dir_path = IHC_PATH . 'classes';
		switch ($target_opt_in){
			case 'aweber':
				$awListOption = get_option('ihc_aweber_list');
				if ($awListOption){
					$aw_list = str_replace('awlist', '', $awListOption);
					$consumer_key = get_option( 'ihc_aweber_consumer_key' );
					$consumer_secret = get_option( 'ihc_aweber_consumer_secret' );
					$access_key = get_option( 'ihc_aweber_acces_key' );
					$access_secret = get_option( 'ihc_aweber_acces_secret' );
					if ($consumer_key && $consumer_secret && $access_key && $access_secret){
						$return = $indeed_mail->indeed_aWebberSubscribe( $consumer_key, $consumer_secret, $access_key, $access_secret, $aw_list, $email, $firstName . ' ' . $lastName );
					}
				}
				break;

			case 'email_list':
				$email_list = get_option('ihc_email_list');
				$email_list .= $email . ',';
				update_option('ihc_email_list', $email_list);
				break;

			case 'mailchimp':
				$mailchimp_api = get_option( 'ihc_mailchimp_api' );
				$mailchimp_id_list = get_option( 'ihc_mailchimp_id_list' );
				if ($mailchimp_api && $mailchimp_id_list){
					$indeed_mail->indeed_mailChimp( $mailchimp_api, $mailchimp_id_list, $email, $firstName, $lastName );
				}
				break;

			case 'get_response':
				$api_key = get_option('ihc_getResponse_api_key');
				$token = get_option('ihc_getResponse_token');
				/*
				// old api. deprecated
				if ($api_key && $token){
					$indeed_mail->indeed_getResponse( $api_key, $token, $email, $firstName . ' ' . $lastName );
				}
				*/
				// sincer ump v 8.6
				require_once IHC_PATH . 'classes/services/email_services/get_response_v3/vendor/autoload.php';
				$client = \Getresponse\Sdk\GetresponseClientFactory::createWithApiKey( $api_key );
				$newContact = new \Getresponse\Sdk\Operation\Model\NewContact(
				       new \Getresponse\Sdk\Operation\Model\CampaignReference( $token ),
				       $email
				);
				if ( $firstName && $lastName ){
						$newContact->setName( $firstName . ' ' . $lastName );
				}
				$createContact = new \Getresponse\Sdk\Operation\Contacts\CreateContact\CreateContact($newContact);
				$createContactResponse = $client->call($createContact);
				break;

			case 'campaign_monitor':
				$listId = get_option('ihc_cm_list_id');
				$apiID = get_option('ihc_cm_api_key');
				if ($listId && $apiID){
					$indeed_mail->indeed_campaignMonitor( $listId, $apiID, $email, $firstName . ' ' . $lastName );
				}
				break;

			case 'icontact':
				$appId = get_option('ihc_icontact_appid');
				$apiPass = get_option('ihc_icontact_pass');
				$apiUser = get_option('ihc_icontact_user');
				$listId = get_option('ihc_icontact_list_id');
				if ($appId && $apiPass && $apiUser && $listId){
					$indeed_mail->indeed_iContact( $apiUser, $appId, $apiPass, $listId, $email, $firstName, $lastName );
				}
				break;

			case 'constant_contact':
				$apiUser = get_option('ihc_cc_user');
				$apiPass = get_option('ihc_cc_pass');
				$listId = get_option('ihc_cc_list');
				if ($apiUser && $apiPass && $listId){
					$indeed_mail->indeed_constantContact($apiUser, $apiPass, $listId, $email, $firstName, $lastName );
				}
				break;

			case 'wysija':
				$listID = get_option('ihc_wysija_list_id');
				if ($listID){
					$indeed_mail->indeed_wysija_subscribe( $listID, $email, $firstName, $lastName );
				}
				break;

			case 'mymail':
				$listID = get_option('ihc_mymail_list_id');
				if ($listID){
					$indeed_mail->indeed_myMailSubscribe( $listID, $email, $firstName, $lastName );
				}
				break;

			case 'madmimi':
				$username = get_option('ihc_madmimi_username');
				$api_key =  get_option('ihc_madmimi_apikey');
				$listName = get_option('ihc_madmimi_listname');
				if ($username && $api_key && $listName){
					$indeed_mail->indeed_madMimi( $username, $api_key, $listName, $email, $firstName, $lastName );
				}
				break;
			case 'active_campaign':
				$api_url = get_option('ihc_active_campaign_apiurl');
				$api_key =  get_option('ihc_active_campaign_apikey');
				if ($api_url && $api_key){
					$indeed_mail->add_contanct_to_active_campaign( $api_url, $api_key, $email, $firstName, $lastName );
				}
				break;
			default:
				do_action( 'ump_public_action_optin_custom_service', $target_opt_in, $email, $firstName, $lastName );
				break;
		}
	}
}

function ihc_get_custom_constant_fields(){
	/*
	 * @param none
	 * @return array
	 */
	$data = get_option('ihc_user_fields');
	foreach ($data as $arr){
		$fields["{CUSTOM_FIELD_" . $arr['name'] ."}"] = $arr['name'];
	}
	$diff = array('ihc_social_media', 'ihc_coupon', 'recaptcha', 'tos', 'pass2', 'pass1', 'user_login', 'user_email', 'confirm_email', 'first_name', 'last_name', 'ihc_avatar');
	$fields = array_diff($fields, $diff);
	return $fields;
}

function ihc_update_stripe_subscriptions(){
	/*
	 * Update Stripe Transactions ID, run this just once on update plugin.
	 * @param none
	 * @return none
	 */
	global $wpdb;
	$data = $wpdb->get_results("SELECT id, txn_id, payment_data FROM " . $wpdb->prefix . "indeed_members_payments
									WHERE txn_id LIKE 'ch_%';");
	if (count($data)){

		//loading stripe libs
		require_once IHC_PATH . 'classes/stripe/init.php';
		$secret_key = get_option('ihc_stripe_secret_key');
		\Stripe\Stripe::setApiKey($secret_key);

		foreach ($data as $obj){
			$payment_data = json_decode($obj->payment_data);
			if (!empty($payment_data->customer)){
				$replace_txn_id = $payment_data->customer;
			} else {
				$stripe_obj = \Stripe\Charge::retrieve($obj->txn_id);
				if (!empty($stripe_obj->customer)){
					$replace_txn_id = $stripe_obj->customer;
				}
				unset($stripe_obj);
			}
			if (!empty($replace_txn_id)){
				$wpdb->query("UPDATE " . $wpdb->prefix . "indeed_members_payments
								SET txn_id='" . $replace_txn_id . "'
								WHERE id= '" . $obj->id . "';
						");
				unset($replace_txn_id);
			}
		}//end foreach
	}
}

function ihc_get_active_payments_services($only_keys=FALSE){
	/*
	 * @param none
	 * @return array
	 */
	$arr = array();
	if (!function_exists('ihc_check_payment_status')){
		require_once IHC_PATH . 'admin/includes/functions.php';
	}
	$gateways = ihc_list_all_payments();

	$gateways_without_labels = array();
	foreach ($gateways as $key=>$value){
		$order = get_option('ihc_' . $key . '_select_order');
		if ($order===FALSE){
			$order = array_search($key, array_keys($gateways));
		}
		while (!empty($gateways_without_labels[$order])){
			$order = $order+1;
		}
		$gateways_without_labels[$order] = $key;
	}
	ksort($gateways_without_labels);

	foreach ($gateways_without_labels as $k){
		$data = ihc_check_payment_status($k);
		if ($data['status'] && $data['settings']=='Completed'){
			if ($only_keys){
				$arr[] = $k;
			} else {
				$arr[$k] = $gateways[$k];
			}
		}
	}
	return $arr;
}

function ihc_get_active_payment_services(){
	/*
	 * @param none
	 * @return array
	 */
	 $array = array();
	 $gateways = ihc_list_all_payments();
	 foreach ($gateways as $k=>$v){
		$data = ihc_check_payment_status($k);
		if ($data['status'] && $data['settings']=='Completed'){
			$array[$k] = $gateways[$k];
		}
	 }
	 return $array;

}

function ihc_is_level_reccuring($lid=-1){
	/*
	 * @param int
	 * @return bool
	 */
	if ($lid>-1){
		$level_data = ihc_get_level_by_id($lid);
		if (!empty($level_data['access_type']) && $level_data['access_type']=='regular_period'){
			return TRUE;
		}
	}
	return FALSE;
}

function ihc_print_payment_select($default_payment='', $field_data = array(), $payments_available, $is_reccurence=0, $required_field=FALSE){
	/*
	 * @param string, array, array, int, bool
	 * @return string
	 */
	$str = '';
	if (empty($field_data['theme'])){
		$field_data['theme'] = 'ihc-select-payment-theme-1';
	}
	$css_class = $field_data['theme'];
	$str .= '<div class="iump-form-line-register ' . $css_class . ' ' . @$field_data['class'] . '">';
	$str .= '<label class="iump-labels-register">';
	if ($required_field){
		$str .= '<span style="color: red;">*</span>';
	}
	if (!empty($field_data['label'])){
		$str .= ihc_correct_text($field_data['label']);
	} else {
		$str .= __('Select Payment Method', 'ihc');
	}
	$str .= '</label>';

	if ($field_data['theme']=='ihc-select-payment-theme-3') {
		$str .= '<select onChange="ihcPaymentGatewayUpdate(this.value, ' . $is_reccurence . ');">';
	}

	foreach ($payments_available as $k => $v){

		$onclick = "ihcPaymentGatewayUpdate('" . $k . "', " . $is_reccurence . ");";

		$label = get_option('ihc_' . $k . '_label');
		if (empty($label)){
			$label = $v;
		}

		if ($field_data['theme']=='ihc-select-payment-theme-1'){
			$selected = ($default_payment==$k) ? 'checked' : '';
			$str .= '<div class="iump-form-paybox"><input type="radio" name="ihc_payment_gateway_radio" value="' . $k . '" onClick="' . $onclick . '" ' . $selected . ' />' . ihc_correct_text($label) . '</div>';
		} else if ($field_data['theme']=='ihc-select-payment-theme-2'){
			$paymentLogo = IHC_URL . 'assets/images/' . $k . '.png';
			$paymentLogo = apply_filters( 'ihc_filter_payment_logo', $paymentLogo, $k );
			// @description Payment gateway logo that is displayed on reigster/subscription page. @param url to logo (string), payment gateway type (string).

			$onclick = "ihcPaymentSelectIcon('".$k."');" . $onclick;
			$class = ($default_payment==$k) ? 'ihc-payment-select-img-selected' : '';
			$str .= '<div class="iump-form-paybox" onClick="' . $onclick . '" class="ihc-payment-icon-wrap">';
			$str .= '<img src="'.$paymentLogo.'" class="ihc-payment-icon ' . $class . '" id="ihc_payment_icon_' . $k . '"/>';
			$str .= '</div>';
		} else if ($field_data['theme']=='ihc-select-payment-theme-3'){
			$selected = ($default_payment==$k) ? 'selected' : '';
			$str .= '<option value="' . $k . '" ' . $selected . '>' . ihc_correct_text($label) . '</option>';
		}
	}

	if ($field_data['theme']=='ihc-select-payment-theme-3') {
		$str .= '</select>';
	}
	if (!empty($field_data['sublabel'])){
		$str .= '<label class="iump-form-sublabel">' . ihc_correct_text($field_data['sublabel']) . '</label>';
	}
	$str .= '</div>';
	return $str;
}
function ihc_check_payment_available($type=''){
	/*
	 * check if a payment service it's enabled and has the required keys set
	 * @param string - type of payment
	 * @return bool
	 */
	$status = false;
	if ($type){
		$payment_metas = ihc_return_meta_arr('payment_' . $type);
		switch ($type){
			case 'paypal':
				if (!empty($payment_metas['ihc_paypal_email']) && !empty($payment_metas['ihc_paypal_status'])){
					$status = true;
				}
				break;
			case 'authorize':
				if (!empty($payment_metas['ihc_authorize_login_id']) && !empty($payment_metas['ihc_authorize_transaction_key']) && !empty($payment_metas['ihc_authorize_status'])){
					$status = true;
				}
				break;
			case 'twocheckout':
				if (!empty($payment_metas['ihc_twocheckout_status']) && !empty($payment_metas['ihc_twocheckout_api_user'])
						&& !empty($payment_metas['ihc_twocheckout_api_pass']) && !empty($payment_metas['ihc_twocheckout_private_key'])
						&& !empty($payment_metas['ihc_twocheckout_account_number']) && !empty($payment_metas['ihc_twocheckout_secret_word'])){
					$status = true;
				}
				break;
			case 'bank_transfer':
				if (!empty($payment_metas['ihc_bank_transfer_status']) && !empty($payment_metas['ihc_bank_transfer_message'])){
					$status = true;
				}
				break;
			case 'stripe':
				if (!empty($payment_metas['ihc_stripe_secret_key']) && !empty($payment_metas['ihc_stripe_publishable_key']) && !empty($payment_metas['ihc_stripe_status'])){
					$status = true;
				}
				break;
			case 'braintree':
				if ($payment_metas['ihc_braintree_status'] == 1 && !empty($payment_metas['ihc_braintree_merchant_id']) && !empty($payment_metas['ihc_braintree_public_key']) && !empty($payment_metas['ihc_braintree_private_key'])){
					$status = true;
				}
				break;
			case 'mollie':
				if (!empty($payment_metas['ihc_mollie_status']) && !empty($payment_metas['ihc_mollie_api_key'])){
					$status = true;
				}
				break;
			case 'pagseguro':
				if (!empty($payment_metas['ihc_pagseguro_status']) && !empty($payment_metas['ihc_pagseguro_email']) && !empty($payment_metas['ihc_pagseguro_token'])){
					$status = true;
				}
				break;
			case 'paypal_express_checkout':
				if (!empty($payment_metas['ihc_paypal_express_checkout_signature']) && !empty($payment_metas['ihc_paypal_express_checkout_user'])
					&& !empty($payment_metas['ihc_paypal_express_checkout_password']) && !empty($payment_metas['ihc_paypal_express_checkout_status'])){
						$status = true;
				}
				break;
			case 'stripe_checkout_v2':
				if (!empty($payment_metas['ihc_stripe_checkout_v2_secret_key']) && !empty($payment_metas['ihc_stripe_checkout_v2_publishable_key']) && !empty($payment_metas['ihc_stripe_checkout_v2_status'])){
						$status = true;
				}
				break;
		}
	}
	$status = apply_filters( 'ihc_payment_gateway_status', $status, $type );
	// @description Run on check if payment gateway is available. @param bool ( true if available )

	return $status;
}

function ihc_switch_role_for_user($uid=0){
	/*
	 * Switch User Role when Complete a Payment.
	 * @param int
	 * @return none
	 */
	$do_switch = get_option('ihc_automatically_switch_role');
	if ($do_switch && $uid){
		$data = get_userdata($uid);
		if ($data && isset($data->roles) && isset($data->roles[0])){
			$role = get_option('ihc_automatically_new_role');
			if (empty($role)){
				$role = 'subscriber';
			}
			$arr['role'] = $role;
			$arr['ID'] = $uid;
			wp_update_user($arr);
		}
	}
}

function ihc_get_currencies_list($return='all'){
	/*
	 * @param string : all, basic, custom
	 * @return array
	 */
	$basic = array(
			'AUD' => 'Australian Dollar (A $)',
			'CAD' => 'Canadian Dollar (C $)',
			'EUR' => 'Euro (&#8364;)',
			'GBP' => 'British Pound (&#163;)',
			'JPY' => 'Japanese Yen (&#165;)',
			'USD' => 'U.S. Dollar ($)',
			'NZD' => 'New Zealand Dollar ($)',
			'CHF' => 'Swiss Franc',
			'HKD' => 'Hong Kong Dollar ($)',
			'SGD' => 'Singapore Dollar ($)',
			'SEK' => 'Swedish Krona',
			'DKK' => 'Danish Krone',
			'PLN' => 'Polish Zloty',
			'NOK' => 'Norwegian Krone',
			'HUF' => 'Hungarian Forint',
			'CZK' => 'Czech Koruna',
			'ILS' => 'Israeli New Shekel',
			'MXN' => 'Mexican Peso',
			'BRL' => 'Brazilian Real (only for Brazilian members)',
			'MYR' => 'Malaysian Ringgit (only for Malaysian members)',
			'PHP' => 'Philippine Peso',
			'TWD' => 'New Taiwan Dollar',
			'THB' => 'Thai Baht',
			'TRY' => 'Turkish Lira (only for Turkish members)',
			'RUB' => 'Russian Ruble',
	);
	$data = get_option('ihc_currencies_list');
	if ($return=='all'){
		if ($data!==FALSE && is_array($data)){
			return $basic+$data;
		}
		return $basic;
	} else if ($return=='basic'){
		return $basic;
	} else {
		return $data;
	}
}

function ihc_get_user_type(){
	/*
	 * @param none
	 * @return string
	 */
	$type = 'unreg';
	if (function_exists('is_user_logged_in') && is_user_logged_in()){
		if (current_user_can('administrator')) return 'admin';
		//pending user
		global $current_user;
		if ($current_user){
			if (isset($current_user->roles[0]) && $current_user->roles[0]=='pending_user'){
				$type = 'pending';
			}else{
				$type = 'reg';
				$current_user = wp_get_current_user();
				$levels = \Ihc_Db::getUserLevelsAsList( $current_user->ID, true );
				$levels = apply_filters( 'ihc_public_get_user_levels', $levels, $current_user->ID );

				if ($levels!==FALSE && $levels!=''){
						$type = $levels;
				}
			}
		}
	}
	return $type;
}

function ihc_required_conditional_field_test($name='', $match_string=''){
	/*
	 * @param string, string
	 * @return string with error if it's case, empty string if it's ok
	 */
	$fields_meta = ihc_get_user_reg_fields();
	$key = ihc_array_value_exists($fields_meta, $name, 'name');
	if ($key!==FALSE && isset($fields_meta[$key]) && isset($fields_meta[$key]['type'])
		&& $fields_meta[$key]['type']=='conditional_text' && !empty($fields_meta[$key]['conditional_text'])){
		if ($fields_meta[$key]['conditional_text']!=$match_string){
			return ihc_correct_text($fields_meta[$key]['error_message']);
		}
	}
	return '';
}

function ihc_get_public_register_fields($exclude_field=''){
	/*
	 * used only in register.php admin section,
	 * @param string
	 * @return array
	 */
	$return = array();
	$fields_meta = ihc_get_user_reg_fields();
	foreach ($fields_meta as $arr){
		if ($arr['display_public_reg']>0 && !in_array($arr['type'], array('payment_select', 'social_media', 'upload_image', 'plain_text', 'file', 'capcha')) && $arr['name']!='tos'){
			if ($exclude_field && $exclude_field==$arr['name']){
				continue;
			}
			$return[$arr['name']] = $arr['name'];
		}
	}
	return $return;
}

function ihc_check_field_is_in_logic_conditional($field_name=''){
	/*
	 * check if this field it's mentionated in other fields conditions
	 * @param name of field
	 * @return boolean
	 */
	$fields_meta = ihc_get_user_reg_fields();
	$key = ihc_array_value_exists($fields_meta, $field_name, 'name');
	if ($key!==FALSE){
		if (!empty($fields_meta[$key]['conditional_logic_corresp_field']) && $fields_meta[$key]['conditional_logic_corresp_field']!=-1){
			return TRUE;
		}
	}
	return FALSE;
}

function ihc_check_envato_customer($code=''){
	/*
	 * @param stirng
	 * @return boolean
	 */
	if (!empty($code)){
		if (!class_exists('Envato_marketplace')){
			require_once IHC_PATH . 'classes/Envato_marketplace.class.php';
		}
		$api_key = 'z4dqvsth70g7qsr4f385fxjdt6wz9dfg';
		$user_name = 'azzaroco';
		$item_id = '12159253';
		$envato_object = new Envato_marketplaces($api_key);
		$buyer_verify = $envato_object->verify_purchase($user_name, $code);

		if ( isset($buyer_verify) && isset($buyer_verify->buyer)  && $buyer_verify->item->id==$item_id ){
					return TRUE;
				}
		//OLD API
		/*if ( isset($buyer_verify) && isset($buyer_verify->buyer)  && $buyer_verify->item_id==$item_id ){
			return TRUE;
		}*/
	}
	return FALSE;
}

function ihc_envato_licensing($code=''){
	update_option('ihc_license_set', 1);
update_option('ihc_envato_code', $code);
return TRUE;
	/*
	 * @param string
	 * @return boolean
	 */
	$return = FALSE;
	if (ihc_check_envato_customer($code)){
		update_option('ihc_license_set', 1);
		$return = TRUE;
	} else {
		update_option('ihc_license_set', 0);
		$return = FALSE;
	}
	update_option('ihc_envato_code', $code);
	return $return;
}

function ihc_envato_check_license(){
	/*
	 * @param none
	 * @return bool
	 */
	$check = get_option('ihc_license_set');
	if ($check!==FALSE){
		if ($check==1)
			return TRUE;
		return FALSE;
	}
	return TRUE;
}

function ihc_inside_dashboard_error_license($global=FALSE){
	/*
	 * @param none
	 * @return string
	 */
	$url = get_admin_url() . 'admin.php?page=ihc_manage&tab=help';
	if (!IHCACTIVATEDMODE){
		$hide = get_option( 'ihc_hide_admin_license_notice' );
		$currentPage = isset($_GET['page']) ? $_GET['page'] : '';
		if ( $currentPage != 'ihc_manage' && $hide ){
				return '';
		}
		if ($global) $class = 'error ihc-license-warning';
		else $class = 'ihc-error-global-dashboard-message';
		return "<div class='$class'>
							<div class='ihc-close-notice ihc-js-close-admin-dashboard-notice'>x</div>
							<p>This is a Trial Version of <strong>Ultimate Membership Pro</strong> plugin. Please add your purchase code into Licence section to enable the Full Ultimate Membership Pro Version. Check your <a href='" . $url . "'>licence section</a>.</p></div>";
	}
	return '';
}

function ihc_public_notify_trial_version(){
	/*
	 * @param none
	 * @return string
	 */
	$str = '';
	$str .= '<div class="ihc-public-trial-version">';
	$str .= __("This is a Trial Version of <strong>Ultimate Membership Pro</strong> plugin. Please add your purchase code into Licence section to enable the Full Ultimate Membership Pro Version.", 'ihc');
	$str .= '</div>';
	return $str;
}

function ihc_make_string_simple($str=''){
	/*
	 * @param string
	 * @return string
	 */
	if (!empty($str)){
		$str = trim($str);
		$str = str_replace(' ', '_', $str);
		$str = preg_replace("/[^A-Za-z0-9_]/", '', $str);//remove all non-alphanumeric chars
	}
	return $str;
}

function ihc_return_transaction_amount_for_user_level($payment_history='', $payment_data=''){
	/*
	 * @param string, string
	 * @return float
	 */
	$count = 0;
	if (!empty($payment_history)){
		@$history_data = unserialize($payment_history);
		if ($history_data && is_array($history_data)){
			// calculating with recurring payments from entire history
			foreach ($history_data as $arr){
				$amount = 0;
				if (isset($arr['amount'])){
					if (isset($arr['ihc_payment_type']) && !empty($arr['ihc_payment_type']) && $arr['ihc_payment_type']=='stripe' && ((empty($arr['type']) || $arr['type']!='charge.succeeded')) ){
						$amount = 0;//stripe first row entry
					} else if ( !empty($arr['ihc_payment_type']) && $arr['ihc_payment_type']=='mollie' && isset( $arr['message'] ) && $arr['message'] == 'pending' ) {
						continue;
					} else {
						$amount = (float)$arr['amount'];
					}
				} else if (isset($arr['mc_gross'])){
					$amount = (float)$arr['mc_gross'];
				} else if (isset($arr['x_amount'])){
					$amount = (float)$arr['x_amount'];
				}
				$count += $amount;
			}
		} else {
			$history_not_available = TRUE;
		}
	} else {
		$history_not_available = FALSE;
	}
	if (!empty($history_not_available)){
		$amount = 0;
		if (isset($obj->payment_data)){
			$arr = json_decode($payment_data, TRUE);
			if (isset($arr['amount'])){
				$amount = (float)$arr['amount'];
			} else if (isset($arr['mc_gross'])){
				$amount = (float)$arr['mc_gross'];
			} else if (isset($arr['x_amount'])){
				$amount = (float)$arr['x_amount'];
			}
		}
		$count = $count + $amount;
	}
	return $count;
}

function ihc_get_user_id_by_user_login($u_login=''){
	/*
	 * @param string
	 * @return int
	 */
	if (!empty($u_login)){
		global $wpdb;
		$q = $wpdb->prepare("SELECT ID FROM " . $wpdb->base_prefix . "users WHERE user_login=%s ;", $u_login);
		$data = $wpdb->get_row($q);
		if (!empty($data->ID)){
			return $data->ID;
		}
	}
	return 0;
}

function ihc_get_avatar_for_uid($uid){
	/*
	 * @param int
	 * @return string
	 */
	$avatar_url = IHC_URL . 'assets/images/no-avatar.png';
	if (!empty($uid)){
		$avatar = get_user_meta( $uid, 'ihc_avatar', true );
		if (!empty($avatar)){
			if (strpos($avatar, "http")===0){
				$avatar_url = $avatar;
			} else {
				$avatar_url = \Ihc_Db::getMediaBaseImage( $avatar );
				if ( $avatar_url && strpos($avatar_url, "http")===0 ){
						return $avatar_url;
				}
				$avatar_data = wp_get_attachment_image_src($avatar, 'full');
				if (!empty($avatar_data[0])){
					$avatar_url = $avatar_data[0];
				}
			}
		} else {
			$temp_metas = ihc_return_meta_arr('public_workflow');
			if ($temp_metas['ihc_use_gravatar']){
				/// GRAVATAR
				if (function_exists('get_avatar_url')){
					$avatar = get_avatar_url($uid);
				} else if (function_exists('get_avatar')){
					/// < wp 4.2
    				$avatar = get_avatar($uid);
    				preg_match("/src='(.*?)'/i", $avatar, $matches);
    				$avatar = $matches[1];
				}

			} else if ($temp_metas['ihc_use_buddypress_avatar'] && function_exists('bp_core_fetch_avatar')){
				/// BUDDYPRESS
				$avatar = bp_core_fetch_avatar(array('item_id' => $uid, 'html' => FALSE, 'type' => 'full'));
			}
			if (!empty($avatar)){
				$avatar_url = $avatar;
			}
		}
	}
	return $avatar_url;
}

function ihc_get_admin_ids_list(){
	/*
	 * @param none
	 * @return array
	 */
	$ids = array();
	$data = get_users(array('role' => 'administrator'));
	if ($data && is_array($data)){
		foreach ($data as $user) {
			$ids[] = $user->ID;
		}
	}
	return $ids;
}

function ihc_return_user_sm_profile_visit($uid=0){
	/*
	 * @param int
	 * @return string
	 */
	$str = '';
	if ($uid){
		$sm_base = array(
									'ihc_fb' => 'https://www.facebook.com/',/// profile.php?id=
									'ihc_tw' => 'https://twitter.com/intent/user?user_id=',
									'ihc_in' => 'https://www.linkedin.com/profile/view?id=',
									'ihc_tbr' => 'https://www.tumblr.com/blog/',
									'ihc_ig' => 'http://instagram.com/_u/',
									'ihc_vk' => 'http://vk.com/id',
									'ihc_goo' => 'https://plus.google.com/',
		);
		foreach ($sm_base as $k=>$v){
			$data = get_user_meta($uid, $k, TRUE);
			if (!empty($data)){
				$class = str_replace('_', '-', $k);
				$str .= "<div class='ihc-account-page-sm-icon " . $class . "' style='display: inline-block;'>";
				$str .= "<a href='" . $v . $data . "'>";
				$str .= "<i class='fa-ihc-sm fa-" . $class . "'></i>";
				$str .= '</a>';
				$str .= "</div>";
			}
		}
	}
	if ($str){
		$str = "<div class='ihc-ap-sm-top-icons-wrap'>" . $str . "</div>";
	}
	return $str;
}

function ihc_save_rewrite_rule_for_register_view_page($page_id=0){
	/*
	 * @param int
	 * @return none
	 */
	if ($page_id){
		$post_name = get_post_field('post_name', $page_id);
		if (!empty($post_name)){
			add_rewrite_rule("$post_name/([^/]+)/?", 'index.php?pagename=' . $post_name . '&ihc_name=$matches[1]', 'top');
			add_rewrite_rule("$post_name/([^/]+)/?",'index.php?page_id=' . $page_id . '&ihc_name=$matches[1]', 'top');
			flush_rewrite_rules();
		}
	}
}

function ihc_is_uap_active(){
	/*
	 * @param none
	 * @return boolean
	 */
	 if (!function_exists('is_plugin_active')){
	 	include_once ABSPATH . 'wp-admin/includes/plugin.php';
	 }
	 if (file_exists(WP_CONTENT_DIR . '/plugins/indeed-affiliate-pro/indeed-affiliate-pro.php') && is_plugin_active('indeed-affiliate-pro/indeed-affiliate-pro.php')){
		if (get_option('uap_license_set')==1){
			return TRUE;
		}
	}
	return FALSE;
}

function ihc_get_payment_id_by_order_id($order_id=0){
	/*
	 * @param int
	 * @return int
	 */
	if ($order_id){
		global $wpdb;
		$p = $wpdb->prefix . 'indeed_members_payments';
		$o = $wpdb->prefix . 'ihc_orders';

		$q = $wpdb->prepare("SELECT p.orders as orders, p.id as id FROM $p p INNER JOIN $o o ON p.u_id=o.uid WHERE o.id=%d", $order_id);
		$data = $wpdb->get_results($q);

		if ($data){
			foreach ($data as $object){
				if (isset($object->orders)){
					$temp_data = unserialize($object->orders);
					if ($temp_data && in_array($order_id, $temp_data)){
						return $object->id;
					}
				}
			}
		}
	}
	return 0;
}

function ihc_meta_value_exists($meta_key='', $meta_value=''){
	/*
	 * @param string
	 * @return boolean
	 */
	if ($meta_key && $meta_value){
		global $wpdb;
		$table = $wpdb->base_prefix . 'usermeta';
		$q = $wpdb->prepare("SELECT umeta_id,user_id,meta_key,meta_value FROM $table WHERE meta_value=%s AND meta_key=%s ;", $meta_value, $meta_key);
		$data = $wpdb->get_results($q);
		if (!empty($data)){
			return TRUE;
		}
	}
	return FALSE;
}

function ihc_save_metas_group($group='', $post_data=array()){
	/*
	 * @param string, array
	 * @return none
	 */
	$data = ihc_return_meta_arr($group, true);
	foreach ($data as $k=>$v){
		if (isset($post_data[$k])){
			$data_db = get_option($k);
			if ($data_db!==FALSE){
				update_option($k, $post_data[$k]);
			} else {
				add_option($k, $post_data[$k]);
			}
		}
	}
}

function ihc_get_taxes_for_amount_by_country($country='', $state='', $amount=0){
	/*
	 * @param string, float || int
	 * @return array
	 */
	 $array = array();
	 if (!get_option('ihc_enable_taxes')){
	 	return $array;
	 }
	 $currency = get_option('ihc_currency');
	 if (!empty($country)){
		 $data = Ihc_Db::get_taxes_by_country($country, $state);
		 if ($data){
			$array['total'] = 0;
			$array['currency'] = get_option("ihc_currency");
			foreach ($data as $tax){
				$temp['label'] = $tax['label'];
				$temp['value'] = $tax['amount_value'] * $amount / 100;
				$temp['value'] = round($temp['value'], 2);
				$temp['print_value'] = ihc_format_price_and_currency($currency, $temp['value']);
				$array['items'][] = $temp;
				$array['total'] += $temp['value'];
			}
			$array['print_total'] = ihc_format_price_and_currency($currency, $array['total']);
			return $array;
		 }
	 }
	//use the defaults
	$taxes_settings = ihc_return_meta_arr('ihc_taxes_settings');
	if (!empty($taxes_settings['ihc_default_tax_label']) && !empty($taxes_settings['ihc_default_tax_value'])){
		$array['currency'] = get_option("ihc_currency");
		$item['label'] = $taxes_settings['ihc_default_tax_label'];
		$item['value'] = $taxes_settings['ihc_default_tax_value'] * $amount / 100;
		$item['value'] = round($item['value'], 2);
		$item['print_value'] = ihc_format_price_and_currency($currency, $item['value']);
		$array['items'][] = $item;
		$array['total'] = $item['value'];
		$array['print_total'] = ihc_format_price_and_currency($currency, $array['total']);
	}
	return $array;
}

function ihc_convert_date_to_us_format($date=''){
	/*
	 * @param string
	 * @return string
	 */
	if ($date && $date!='-' && is_string($date)){
		@$date = strtotime($date);
		//$format = 'F j, Y';
		$format = get_option('date_format');
		$return_date = date_i18n($format, $date);
		return $return_date;
	}
	return $date;
}
function ihc_convert_date_time_to_us_format($date=''){
	/*
	 * @param string
	 * @return string
	 */
	if ($date && $date!='-' && is_string($date)){
		@$date = strtotime($date);
		//$format = 'F j, Y';
		$date_format = get_option('date_format');
		$time_format = get_option('time_format');
		$return_date = date_i18n($date_format . ' '. $time_format, $date);
		return $return_date;
	}
	return $date;
}
function ihc_get_user_orders_count($user_id=''){
	global $wpdb;

	$count = 0;
	$table = $wpdb->prefix . 'ihc_orders';
		$q = $wpdb->prepare("SELECT COUNT(id) AS count FROM $table WHERE uid=%d ", $user_id);
		$data = $wpdb->get_results($q);
		if (!empty($data)){
			$count = $data[0]->count;
		}
	return $count;

}

function insert_order_from_renew_level($uid=0, $lid=0, $ihc_coupon='', $ihc_country=FALSE, $payment_gateway='', $status=''){
	/*
	 * @param int, int, string, string, string, string
	 * @return none
	 */
	if (!empty($uid) && $lid!==FALSE){
		$extra_order_info = array();
		$levels = get_option('ihc_levels');
		$amount = $levels[$lid]['price'];
		if ($ihc_coupon){
			$coupon_data = ihc_check_coupon($ihc_coupon, $lid);
			$extra_order_info['discount_value'] = ihc_get_discount_value($amount, $coupon_data);
			$extra_order_info['coupon_used'] = $ihc_coupon;
			$amount = ihc_coupon_return_price_after_decrease($amount, $coupon_data, TRUE, $uid, $lid);
		}

		/// TAXES
		$state = get_user_meta($uid, 'ihc_state', TRUE);
		$country = ($ihc_country==FALSE) ? '' : $ihc_country;
		$taxes_data = ihc_get_taxes_for_amount_by_country($country, $state, $amount);
		if ($taxes_data && !empty($taxes_data['total'])){
			$amount += $taxes_data['total'];
			$extra_order_info['tax_value'] = $taxes_data['total'];
		}

		if ($payment_gateway=='stripe' && $amount<0.50){
			$amount = 0.50;/// minimum for stripe.
		}
		$order_id = ihc_insert_update_order($uid, $lid, $amount, $status, $payment_gateway, $extra_order_info);
		return $order_id;
	}
}

function ihc_user_level_first_time($uid=0, $lid=0){
	/*
	 * Return TRUE if user use this level for the first time.
	 * @param int, int
	 * @return
	 */
	global $wpdb;
	$table = $wpdb->prefix . 'ihc_user_levels';
	$current_time = indeed_get_unixtimestamp_with_timezone();
	$q = $wpdb->prepare("SELECT expire_time FROM $table WHERE user_id=%d AND level_id=%d ", $uid, $lid);
	$data = $wpdb->get_row($q);
	if ($data && !empty($data->expire_time)){
		$time = strtotime($data->expire_time);
		if ($time<0){
			return TRUE;
		}
		return FALSE;
	}
	return TRUE;
}

function ihc_is_magic_feat_active($type=''){
	/*
	 * @param string
	 * @return boolean
	 */
	 $active = false;
	 if ($type){
	 	switch ($type){
			case 'taxes':
				$active = get_option('ihc_enable_taxes');
				break;
			case 'bp_account_page':
				$active = get_option('ihc_bp_account_page_enable');
				break;
			case 'woo_account_page':
				$active = get_option('ihc_woo_account_page_enable');
				break;
			case 'membership_card':
				$active = get_option('ihc_membership_card_enable');
				break;
			case 'cheat_off':
				$active = get_option('ihc_cheat_off_enable');
				break;
			case 'invitation_code':
				$active = get_option('ihc_invitation_code_enable');
				break;
			case 'download_monitor_integration':
				$active = get_option('ihc_download_monitor_enabled');
				break;
			case 'register_lite':
				$active = get_option('ihc_register_lite_enabled');
				break;
			case 'individual_page':
				$active = get_option('ihc_individual_page_enabled');
				break;
			case 'level_restrict_payment':
				$active = get_option('ihc_level_restrict_payment_enabled');
				break;
			case 'level_subscription_plan_settings':
				$active = get_option('ihc_level_subscription_plan_settings_enabled');
				break;
			case 'gifts':
				$active = get_option('ihc_gifts_enabled');
				break;
			case 'login_level_redirect':
				$active = get_option('ihc_login_level_redirect_on');
				break;
			case 'register_redirects_by_level':
				$active = get_option('ihc_register_redirects_by_level_enable');
				break;
			case 'wp_social_login':
				$active = get_option('ihc_wp_social_login_on');
				break;
			case 'list_access_posts':
				$active = get_option('ihc_list_access_posts_on');
				break;
			case 'invoices':
				$active = get_option('ihc_invoices_on');
				break;
			case 'woo_payment':
				$active = get_option('ihc_woo_payment_on');
				break;
			case 'badges':
				$active = get_option('ihc_badges_on');
				break;
			case 'login_security':
				$active = get_option('ihc_login_security_on');
				break;
			case 'workflow_restrictions':
				$active = get_option('ihc_workflow_restrictions_on');
				break;
			case 'subscription_delay':
				$active = get_option('ihc_subscription_delay_on');
				break;
			case 'level_dynamic_price':
				$active = get_option('ihc_level_dynamic_price_on');
				break;
			case 'user_reports':
				$active = get_option('ihc_user_reports_enabled');
				break;
			case 'pushover':
				$active = get_option('ihc_pushover_enabled');
				break;
			case 'account_page_menu':
				$active = get_option('ihc_account_page_menu_enabled');
				break;
			case 'mycred':
				$active = get_option('ihc_mycred_enabled');
				break;
			case 'api':
				$active = get_option('ihc_api_enabled');
				break;
			case 'woo_product_custom_prices':
				$active = get_option('ihc_woo_product_custom_prices_enabled');
				break;
			case 'drip_content_notifications':
				$active = get_option('ihc_drip_content_notifications_enabled');
				break;
			case 'user_sites':
				$active = get_option('ihc_user_sites_enabled');
				break;
			case 'zapier':
				$active = get_option('ihc_zapier_enabled');
				break;
			case 'infusionSoft':
				$active = get_option( 'ihc_infusionSoft_enabled' );
				break;
			case 'kissmetrics':
				$active = get_option( 'ihc_kissmetrics_enabled' );
				break;
			case 'direct_login':
				$active = get_option( 'ihc_direct_login_enabled' );
				break;
			case 'reason_for_cancel':
				$active = get_option( 'ihc_reason_for_cancel_enabled' );
				break;
	 	}
	 }
	 $active = apply_filters( 'ihc_is_magic_feat_active_filter', $active, $type );
	 // @description Filter if a magic feature is active. @param is active (boolean), type of magic feature (string)

	 return $active;
}

function get_terms_for_post_id($post_id=0){
	/*
	 * @param int
	 * @return array
	 */
	 $array = array();
	 if ($post_id){
	 	 global $wpdb;
	 	 $table = $wpdb->prefix . 'term_relationships';
		 $q = $wpdb->prepare("SELECT term_taxonomy_id FROM $table WHERE object_id=%d ", $post_id);
		 $data = $wpdb->get_results($q);
		 if (!empty($data)){
		 	foreach ($data as $object){
		 		$array[] = $object->term_taxonomy_id;
		 	}
		 }
	 }
	 return $array;
}

function ihc_get_all_terms_with_names(){
	/*
	 * @param none
	 * @retunr array
	 */
	 $array = array();
	 global $wpdb;
	 $table = $wpdb->prefix . 'terms';
	 $table_2 = $wpdb->prefix . 'term_relationships';
	 $data = $wpdb->get_results("SELECT term_id, name FROM $table t1 INNER JOIN $table_2 t2 ON t2.term_taxonomy_id=t1.term_id;");
	 if (!empty($data)){
	 	foreach ($data as $object){
	 		$array[$object->term_id] = $object->name;
	 	}
		$exclude = array('settings-verify-email-change', 'groups-membership-request-accepted', 'groups-membership-request-rejected', 'friends-request',
		'core-user-registration', 'core-user-registration-with-blog',
		);
		foreach ($exclude as $e){
			if ($k=array_search($e, $array)){
				unset($array[$k]);
				unset($k);
			}
		}
	 }
	 return $array;
}


function ihc_do_write_into_htaccess($extensions='mp3|mp4|avi|pdf|zip|rar|doc|gz|tar|docx|xls|xlsx|PDF'){
	/*
	 * @param none
	 * @return none
	 */
	 $file = ABSPATH . '.htaccess';
	 if (file_exists($file) && is_writable($file)){
	 	/// READ FROM HTACCESS
		$data = file_get_contents($file);
		$resource = fopen($file, 'r');
		$data = fread($resource, filesize($file));
		fclose($resource);
		unset($resource);
		$path_to_check_file = WP_CONTENT_DIR . '/plugins/indeed-membership-pro/public/check-file-permissions.php';
		$string_to_write = '#BEGIN Ultimate Membership Pro Rules
	<IfModule mod_rewrite.c>
		RewriteCond %{REQUEST_URI} !^/(wp-content/themes|wp-content/plugins|wp-admin|wp-includes)
		RewriteCond %{REQUEST_URI} \.(' . $extensions . ')$
		RewriteRule . ' . $path_to_check_file . ' [L]
	</IfModule>
#END Ultimate Membership Pro Rules';
		if (strpos($data, $string_to_write)===FALSE){
			$data = $data . $string_to_write;
			$resource = fopen($file, 'w+');
			fwrite($resource, $data);/// WRITE THE NEW CONTENT
			fclose($resource);
		}
	 }
}

if ( !function_exists( 'ihc_format_price_and_currency' ) ):
/**
 * @param string
 * @param string
 * @return string
 */
function ihc_format_price_and_currency( $currency='', $price_value='' )
{
	 $output = '';
	 $settings = ihc_return_meta_arr('payment');
	 // $currency_custom_code = get_option('ihc_custom_currency_code');
	 if ( !empty( $settings['ihc_custom_currency_code'] ) ){
	 		$currency = $settings['ihc_custom_currency_code'];
	 }
	 if ( isset( $settings['ihc_num_of_decimals'] ) && isset( $settings['ihc_decimals_separator'] ) && isset( $settings['ihc_thousands_separator'] ) ){
	 		$price_value = number_format( $price_value, $settings['ihc_num_of_decimals'], $settings['ihc_decimals_separator'], $settings['ihc_thousands_separator'] );
	 }

	 // $rl = get_option('ihc_currency_position');
	 if ( $settings['ihc_currency_position'] == 'left' ){
	 		$output = $currency . $price_value;
	 } else {
	 		$output = $price_value . $currency;
	 }
	 return $output;
}
endif;

if ( !function_exists( 'ihc_format_price_and_currency_with_price_wrapp' ) ):
/**
 * @param string
 * @param string
 * @param string
 * @return string
 */
function ihc_format_price_and_currency_with_price_wrapp( $currency='', $price_value='', $priceHtmlAttr='' )
{
	 $output = '';
	 $settings = ihc_return_meta_arr('payment');
	 // $currency_custom_code = get_option('ihc_custom_currency_code');
	 if ( !empty( $settings['ihc_custom_currency_code'] ) ){
	 		$currency = $settings['ihc_custom_currency_code'];
	 }
	 if ( isset( $settings['ihc_num_of_decimals'] ) && isset( $settings['ihc_decimals_separator'] ) && isset( $settings['ihc_thousands_separator'] ) ){
	 		$price_value = number_format( $price_value, $settings['ihc_num_of_decimals'], $settings['ihc_decimals_separator'], $settings['ihc_thousands_separator'] );
	 }

	 // $rl = get_option('ihc_currency_position');
	 if ( $settings['ihc_currency_position'] == 'left' ){
	 		$output = $currency . "<span $priceHtmlAttr>" . $price_value . '</span>';
	 } else {
	 		$output = "<span $priceHtmlAttr>" . $price_value . '</span>' . $currency;
	 }
	 return $output;
}
endif;

function ihc_get_levels_with_payment(){
	/*
	 * @param none
	 * @return array
	 */
	 $data = get_option('ihc_levels');
	 if ($data){
	 	foreach ($data as $key=>$array){
	 		if ($array['payment_type']=='free'){
	 			unset($data[$key]);
	 		}
	 	}
		return $data;
	 }
	 return array();
}

function ihc_get_state_field_str($country=''){
	/*
	 * @param string
	 * @return string
	 */
	$str = '';
	switch ($country){
		case 'US':
			include IHC_PATH . 'public/static-data.php';
			$states = indeedUsCaStates();
			$str .= "<select class='iump-form-select ' name='ihc_state' onChange='ihcUpdateCart();'>";
			foreach ($states['US'] as $prefix => $label){
				$str .= "<option value='$prefix'>$label</option>";
			}
			$str .= "</select>";
			break;
		case 'CA':
			include IHC_PATH . 'public/static-data.php';
			$states = indeedUsCaStates();
			$str .= "<select class='iump-form-select ' name='ihc_state' onChange='ihcUpdateCart();'>";
			foreach ($states['CA'] as $prefix => $label){
				$str .= "<option value='$prefix'>$label</option>";
			}
			$str .= "</select>";
			break;
		default:
			$str .= "<input type='text' name='ihc_state' value='' class='' onBlur='ihcUpdateCart();' />";
			break;
	}
	return $str;
}

function ihc_do_show_hide_admin_bar_on_public(){
	/*
	 * @param none
	 * @return none
	 */
	 if (!current_user_can('administrator')){
		if (function_exists('is_user_logged_in') && is_user_logged_in()){
			/// ONLY REGISTERED USERS
			$uid = get_current_user_id();
			$user = new WP_User($uid);
			if ($user && !empty($user->roles) && !empty($user->roles[0]) && !in_array( 'administrator', $user->roles ) ){//$user->roles[0]!='administrator'){
				$allowed_roles = get_option('ihc_dashboard_allowed_roles');
				if ($allowed_roles){
					$roles = explode(',', $allowed_roles);
					$show = FALSE;
					foreach ( $roles as $role ){
							if ( !empty( $role ) && !empty( $user->roles ) && in_array( $role, $user->roles ) ){
								$show = TRUE;
							}
					}
				} else {
					$show = FALSE;
				}
				show_admin_bar($show);
			}
		}
	}
}

if (!function_exists('indeed_debug_var')):
function indeed_debug_var($variable){
	/*
	 * print the array into '<pre>' tags
	 * @param array, string, int ... anything
	 * @return none (echo)
	 */
	 if (is_array($variable) || is_object($variable)){
		 echo '<pre>';
		 print_r($variable);
		 echo '</pre>';
	 } else {
	 	var_dump($variable);
	 }
}
endif;

if (!function_exists('ihc_get_custom_field_label')):
function ihc_get_custom_field_label($slug=''){
	/*
	 * Return Label of custom register field by slug
	 * @param string
	 * @return string
	 */
	 $data = get_option('ihc_user_fields');
	 if ($data){
	 	 $key = ihc_array_value_exists($data, $slug, 'name');
		 if (isset($data[$key]) && isset($data[$key]['label'])){
		 	return $data[$key]['label'];
		 }
	 }
	 return '';
}
endif;

if (!function_exists('ihc_listing_user_get_filter_fields')):
function ihc_listing_user_get_filter_fields(){
	/*
	 * @param none
	 * @return array
	 */
  	 $return = array();
	 $data = get_option('ihc_user_fields');
	 $allow = array('select', 'multi_select', 'checkbox', 'radio', 'date', 'number', 'ihc_country');
	 $not_allow_names = array('tos');
	 if ($data){
	 	foreach ($data as $k=>$array){
	 		if (in_array($array['type'], $allow) && !in_array($array['name'], $not_allow_names)){
	 			$return[$array['name']] = $array['label'];
	 		}
	 	}
	 }
	return $return;
}
endif;

if (!function_exists('ihc_register_field_get_type_by_slug')):
function ihc_register_field_get_type_by_slug($slug=''){
	/*
	 * @param string
	 * @return string
	 */
	 if ($slug){
	 	 $data = get_option('ihc_user_fields');
		 $key = ihc_array_value_exists($data, $slug, 'name');
		 if ($key!==FALSE && isset($data[$key])){
		 	return $data[$key]['type'];
		 }
	 }
}
endif;

if (!function_exists('ihc_make_level_expire_for_user')):
function ihc_make_level_expire_for_user($uid=0, $lid=0){
	/*
	 * @param int, int
	 * 2return none
	 */
	 if ($uid && $lid!==FALSE){
	 	 global $wpdb;
		 $table = $wpdb->prefix . 'ihc_user_levels';
		 $q = $wpdb->prepare("UPDATE $table SET expire_time='0000-00-00 00:00:00', notification=0 WHERE user_id=%d AND level_id=%d ", $uid, $lid);
		 $wpdb->query($q);
	 }
}
endif;

if (!function_exists('ihc_suspend_account')):
function ihc_suspend_account($uid=0){
	/*
	 * @param int
	 * @return boolean
	 */
	 if ($uid){
	 	 /// CANCEL & DELETE * THE LEVELS
	 	 $levels = Ihc_Db::get_user_levels($uid);
		 if ($levels){
		 	 foreach ($levels as $lid=>$array){
		 	 	 ihc_delete_user_level_relation($lid, $uid);
				 /// ihc_cancel_level($uid, $lid, true);
				 $cancel = new \Indeed\Ihc\CancelSubscription($uid, $lid);
				 $cancel->stopRedirectIfCase(true)->proceed();
		 	 }
		 }

		 /// MAKE ROLE SUSPEND
		 wp_update_user(array('ID'=>$uid, 'role'=>'suspended'));
		 return TRUE;
	 }
	 return FALSE;
}
endif;

if (!function_exists('ihc_get_register_form_fields_order')):
function ihc_get_register_form_fields_order(){
	/*
	 * @param none
	 * @return array
	 */
	$array_return = array();
	$data = get_option('ihc_user_fields');
	ksort($data);
	$array_return = array();
	foreach ($data as $key=>$array){
		$array_return[$array['name']] = $key;
	}
	return $array_return;
}
endif;


if (!function_exists('ihc_register_form_get_order_values')):
function ihc_register_form_get_order_values($name=''){
	/*
	 * @param string
	 * @eturn array
	 */
	 if ($name){
		$data = get_option('ihc_user_fields');
		$key = ihc_array_value_exists($data, $name, 'name');
		if (isset($data[$key]) && isset($data[$key]['values'])){
			return $data[$key]['values'];
		}
	 }
}
endif;

if (!function_exists('ihc_check_dynamic_price_from_user')):
function ihc_check_dynamic_price_from_user($lid=0, $amount=0){
	/*
	 * @param int($lid), float($amount)
	 * @return boolean (TRUE if ok)
	 */
	if ($lid){
		$temp_settings = ihc_return_meta_arr('level_dynamic_price');
		if (!empty($temp_settings['ihc_level_dynamic_price_levels_on'][$lid])){
			$min = isset($temp_settings['ihc_level_dynamic_price_levels_min'][$lid]) ? $temp_settings['ihc_level_dynamic_price_levels_min'][$lid] : 0;
			if ($min<=$amount){
				return TRUE;
			}
		}
	}
	return FALSE;
}
endif;

if (!function_exists('ihc_reorder_menu_items')):
function ihc_reorder_menu_items($order=array(), $array=array()){
	/*
	 * @param array, array
	 * @return array
	 */
	 if (!empty($order) && is_array($order)){
		 $return_array = array();
		 foreach ($order as $key=>$value){
		 	 if (isset($array[$key])){
		 	 	 $return_array[$key] = $array[$key];
				 unset($array[$key]);
		 	 }
		 }
		 if (!empty($array)){
		 	$return_array = array_merge($return_array, $array);
		 }
		 return $return_array;
	 }
	 return $array;
}
endif;

if (!function_exists('ihc_do_user_approve')):
function ihc_do_user_approve($uid=0){
	/*
	 * Approve User and send a nice notification.
	 * @param int
	 * @return bool
	 */
	if ($uid){
		$data = get_userdata($uid);
		if ($data && isset($data->roles) && isset($data->roles[0]) && $data->roles[0]=='pending_user'){
			$default_role = get_option('default_role');
			$user_id = wp_update_user(array( 'ID' => $uid, 'role' => $default_role));
			if ($user_id==$uid){
				ihc_send_user_notifications($user_id, 'approve_account');
				return TRUE;
			}
		}
	}
	return FALSE;
}
endif;

if (!function_exists('ihc_generate_random_string')):
function ihc_generate_random_string($length=10){
	/*
	 * @param int
	 * @return string
	 */
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $output = '';
    for ($i = 0; $i < $length; $i++){
        $output .= $chars[rand(0, strlen($chars))];
    }
    return $output;
}
endif;

/**
 * Convert array of objects into array of array
 * @param mixed (array or object)
 * @return array
 */
if (!function_exists('indeed_convert_to_array')):
function indeed_convert_to_array($input=null){
	foreach ($input as $object){
		$array[] = (array)$object;
	}
	return $array;
}
endif;

if (!function_exists('indeed_preg_match_callback')):
function indeed_preg_match_callback($matches){
	return 's:' . strlen($matches[2]) . ':"' . $matches[2] . '";';
}
endif;

/**
 * @param array
 * @return int
 */
if (!function_exists('ihc_get_biggest_key_from_array')):
function ihc_get_biggest_key_from_array($input=array()){
		$max = 0;
		foreach ($input as $key=>$value){
  		if ($key>$max) $max = $key;
		}
		return $max;
}
endif;

/**
 * DEPRECATED
 */
function get_user_levels_list($user_id = 0){

	$level_array =array();
	$user_levels='';

	$level_array = Ihc_Db::get_user_levels($user_id);

	$i=1;
	foreach ($level_array as $key => $object){
		$user_levels .= $key;
		if ($i < count($level_array)) $user_levels .= ',';
		$i++;
	}

	return $user_levels;
}

function ihc_get_user_pending_trial_order($user_id='', $level_id='', $level_data){
	global $wpdb;

	$count = 0;
	$table = $wpdb->prefix . 'ihc_orders';
		$q = $wpdb->prepare("SELECT COUNT(id) AS count FROM $table
											WHERE
											uid=%d
											AND lid=%d
											AND amount_value=%s
											AND status='pending'
											ORDER BY create_date DESC
											LIMIT 1
				", $user_id, $level_id, 0);
		$data = $wpdb->get_results($q);
		if (!empty($data)){
			$count = $data[0]->count;
		}
		if($count == 0){
			$q = $wpdb->prepare("SELECT COUNT(id) AS count FROM $table
											WHERE
											uid=%d
											AND lid=%d
											AND amount_value=%s
											AND status='pending'
											ORDER BY create_date DESC
											LIMIT 1
				", $user_id, $level_id, $level_data['access_trial_price']);
			$datas = $wpdb->get_results($q);
			if (!empty($datas) && $datas[0]->count > 0){
				$count = $level_data['access_trial_price'];
			}
		}
	return $count;

}

# dump and die
if (!function_exists('dd')):
function dd($variable){
		indeed_debug_var($variable);
		die;
}
endif;

if (!function_exists('ihcGetTransactionDetails')):
function ihcGetTransactionDetails($txnId='')
{
		global $wpdb;
		if (empty($txnId)){
				return false;
		}
		$data = $wpdb->get_row($wpdb->prepare("SELECT payment_data, orders, u_id FROM {$wpdb->prefix}indeed_members_payments WHERE txn_id=%s; ", $txnId));
		if (empty($data)){
				return false;
		}
		$paymentData = json_decode($data->payment_data, TRUE);
		if (!empty($paymentData['lid'])){
				$lid = $paymentData['lid'];
		} else if (!empty($paymentData['level'])){
				$lid = $paymentData['level'];
		}

		$array = array(
				'uid'								=> $data->u_id,
				'lid'								=> $lid,
				'amount'						=> $paymentData['amount'],
				'orders'						=> unserialize($data->orders),
				'ihc_payment_type'  => $paymentData['ihc_payment_type'],
		);

		return $array;
}
endif;

if (!function_exists('ihcActAsIpn')):
function ihcActAsIpn($uid=0, $lid=0, $transactionId='', $paymentData=array())
{
    $levelData = ihc_get_level_by_id($paymentData['lid']);//getting details about current level
    ihc_update_user_level_expire($levelData, $paymentData['lid'], $paymentData['uid']);
    ihc_switch_role_for_user($paymentData['uid']);
    $paymentData['message'] = 'success';
    $paymentData['status'] = 'Completed';
    ihc_insert_update_transaction($paymentData['uid'], $transactionId, $paymentData);
}
endif;

if (!function_exists('ihc_get_current_user')):
function ihc_get_current_user(){
	global $current_user;
	return isset($current_user->ID) ? $current_user->ID : 0;
}
endif;

if ( !function_exists( 'ihc_list_all_payments' ) ):
function ihc_list_all_payments()
{
		$paymentGateways = array(
								'paypal' 										=> 'PayPal Standard',
							  'authorize' 								=> 'Authorize',
							  'stripe' 										=> 'Stripe Standard',
								'stripe_checkout_v2'				=> 'Stripe Checkout',
							  'twocheckout' 							=> '2Checkout',
							 	'bank_transfer' 						=> 'Bank Transfer',
								'braintree' 								=> 'Braintree',
								'mollie'										=> 'Mollie',
								'pagseguro'									=> 'Pagseguro',
								'paypal_express_checkout'		=> 'PayPal Express Checkout',
		);
		$paymentGateways = apply_filters( 'ihc_payment_gateways_list', $paymentGateways );
		// @description List of payment gateways. @param list of payment gateways ( array )

		return $paymentGateways;
}
endif;

if (!function_exists('indeed_get_plugin_version')):
function indeed_get_plugin_version( $base_file_path='' ){
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$plugin_data = get_plugin_data( $base_file_path, false, false);
		return $plugin_data['Version'];
}
endif;

if ( !function_exists('indeed_is_plugin_active') ):
function indeed_is_plugin_active( $pluginBaseFile='' )
{
		if ( !$pluginBaseFile ){
				return false;
		}
		if (!function_exists('is_plugin_active')){
				include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if (is_plugin_active($pluginBaseFile)){
				return true;
		}
		return false;
}
endif;

if ( !function_exists('indeed_get_current_language_code') ):
function indeed_get_current_language_code()
{
		$languageCode = get_locale();
		if ( !$languageCode ){
				return false;
		}
		$language = explode( '_', $languageCode );
		if ( isset($language[0]) ){
				return $language[0];
		}
		return $languageCode;
}
endif;

if ( !function_exists('ihc_order_like_register') ):
function ihc_order_like_register( $items=array() )
{
		$registerFields = ihc_get_user_reg_fields();
		ksort( $registerFields );
		foreach ( $registerFields as $registerField ){
				if ( in_array( $registerField['name'], $items ) ){
						$returnArray[] = $registerField['name'];
						unset( $items[ $registerField['name'] ] );
				}
		}
		if ( !empty( $items ) ){
				$returnArray = $returnArray + $items;
		}
		return $returnArray;
}
endif;

if ( !function_exists('ihc_level_time_left') ):
function ihc_level_time_left($expire_time)
{
    $cur_time   = indeed_get_unixtimestamp_with_timezone();
    $time_elapsed   = $expire_time - $cur_time;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    // Seconds
    if($seconds <= 60){
        return "just now";
    }
    //Minutes
    else if($minutes <=60){
        if($minutes==1){
            return __('1 minute left','ihc');
        }
        else{
            return "$minutes".__(' minutes left','ihc');
        }
    }
    //Hours
    else if($hours <=24){
        if($hours==1){
            return __('1 hour left','ihc');
        }else{
            return "$hours".__(' hours left','ihc');
        }
    }
    //Days
    else if($days <= 7){
        if($days==1){
            return __('1 day left','ihc');
        }else{
            return "$days".__(' days left','ihc');
        }
    }
    //Weeks
    else if($weeks <= 4.3){
        if($weeks==1){
            return __('1 week left','ihc');
        }else{
            return "$weeks".__(' weeks left','ihc');
        }
    }
    //Months
    else if($months <=12){
        if($months==1){
            return __('1 month left','ihc');
        }else{
            return "$months".__(' months left','ihc');
        }
    }
    //Years
    else{
        if($years==1){
            return __('1 year left','ihc');
        }else{
            return "$years".__(' years left','ihc');
        }
    }
}
endif;

if ( !function_exists('ihc_prepare_level_show_format') ):
function ihc_prepare_level_show_format( $item=array() )
{

	$current_time = indeed_get_unixtimestamp_with_timezone();
	$format = get_option('date_format');
	$grace_period = get_option('ihc_grace_period');
	$item = array_merge($item, array(
					'level_status' => '',
					'start_time_format' => date_i18n('M j'),
					'expire_time_format' => FALSE,
					'time_class' => '',
					'bar_width' => 0,
					'bar_class' => '',
					'tooltip_class' => '',
					'tooltip_message' => '',
					'extra_message' => ''
					)
			);
	$level_data = ihc_get_level_by_id($item['level_id']);

	$start_time = strtotime($item['start_time']);
	$expire_time = strtotime($item['expire_time']) + ((int)$grace_period * 24 * 60 *60);

	if(date('Y') != date('Y', $start_time))
			$item ['start_time_format'] = date_i18n('M j, y', $start_time);
	else
			$item ['start_time_format'] = date_i18n('M j', $start_time);

	if ($item['expire_time'] > 0){
		if ($current_time>$expire_time){
			$item ['level_status'] = 'expired';
		}
		else{
			$item ['level_status'] = 'active';

			$item ['tooltip_message'] = ihc_level_time_left($expire_time);
			$item ['bar_width'] = ($expire_time - $current_time)*100/($expire_time - $start_time);
		}
		if(date('Y') != date('Y', $expire_time))
			$item ['expire_time_format'] = date_i18n('M j, y', $expire_time);
		else
			$item ['expire_time_format'] = date_i18n('M j', $expire_time);
	}else{
		$item ['level_status'] = 'hold';
	}
	switch($item ['level_status']){
		case 'active':
			 if(isset($level_data['access_type']) && $level_data['access_type'] == 'unlimited'){
			 	$item ['bar_width'] = '100';
				$item ['time_class'] = 'ihc-level-skin-hide';
			 	$item ['tooltip_message'] = __('LifeTime','ihc');
			 }
			 if($item ['bar_width'] < 10){
				$item ['bar_class'] = 'ihc-level-skin-bar-expiresoon';
				$item ['extra_message'] = __('Subscription will expire soon','ihc');
			 }
			 break;
		case 'expired':
			$item ['bar_width'] = '100';
			$item ['bar_class'] = 'ihc-level-skin-bar-expired';
			$item ['tooltip_class'] = 'ihc-level-skin-single-expired';
			$item ['tooltip_message'] = __('Expired','ihc');
			$item ['extra_message'] = __('Subscription period has expired','ihc');
			break;
		case 'hold':
			$item ['bar_width'] = '100';
			$item ['bar_class'] = 'ihc-level-skin-bar-hold';
			$item ['tooltip_class'] = 'ihc-level-skin-single-hold';
			$item ['tooltip_message'] = __('On hold','ihc');
			$item ['time_class'] = 'ihc-level-skin-hide';
			$item ['extra_message'] = __('No payment confirmation received','ihc');
			break;
	}

   if($item ['bar_width'] == 100){
	  $item ['bar_class'] .= ' ihc-level-skin-bar-full';
   }


	return $item;
}
endif;

if ( !function_exists('ihc_return_individual_page_link') ):
function ihc_return_individual_page_link($user_id = 0){
	 $output = '';
	 if ($user_id != 0){
	 	 $individual_page = get_user_meta($user_id, 'ihc_individual_page', TRUE);
		 if ($individual_page){
		 	 $permalink = get_permalink($individual_page);
			 if ($permalink){
			 	$output = $permalink;
			 }
		 }
	 }
	 return $output;
}
endif;

if ( !function_exists('ihcIsRegisterPage') ):
function ihcIsRegisterPage( $url )
{
		$registerPage = get_option('ihc_general_register_default_page');
		if ( !$registerPage || $registerPage==-1 ){
				return false;
		}
		$permalink = get_permalink($registerPage);
		if ( strpos( $url, $permalink) !== false ){
				return true;
		}
		return false;
}
endif;

if (!function_exists('indeed_get_uid')):
function indeed_get_uid(){
		global $current_user;
		if (isset($current_user->ID) && $current_user->ID > 0 ){
				return $current_user->ID;
		}
		return 0;
}
endif;

if ( !function_exists( 'ihcGetListOfMagicFeatures' ) ):
function ihcGetListOfMagicFeatures()
{
	$list = array(
									'taxes' => array(
														'label' => __('Taxes', 'ihc'),
														'description' => __('Add additional tax charges which can be based on the user location by using the Country field', 'ihc'),
														'icon' => 'fa-taxes-ihc',
														'extra_class' => '',
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=taxes') : '',
														'enabled' => ihc_is_magic_feat_active('taxes'),
									),
									'opt_in' => array(
														'label' => __('Opt-in Settings', 'ihc'),
														'description' => __('Store your subscribers email address in a well known email marketing platform', 'ihc'),
														'icon' => 'fa-opt_in-ihc',
														'extra_class' => '',
														'link' => admin_url('admin.php?page=ihc_manage&tab=opt_in'),
														'enabled' => TRUE,
									),
									'woo_payment' => array(
														'label' => __('WooCommerce Payment Integration', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=woo_payment') : '',
														'icon' => 'fa-woo-ihc',
														'extra_class' => 'iump-woo-payment-special-color',
														'description' => '',
														'enabled' => ihc_is_magic_feat_active('woo_payment'),
									),
									'redirect_links' => array(
														'label' => __('Redirect Links', 'ihc'),
														'description' => __('Set custom links from inside or outside of your website that can be used for redirects inside the system', 'ihc'),
														'icon' => 'fa-links-ihc',
														'extra_class' => '',
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=redirect_links') : '',
														'enabled' => TRUE,
									),
									'bp_account_page' => array(
														'label' => __('BuddyPress Account Page Integration', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=bp_account_page') : '',
														'icon' => 'fa-bp-ihc',
														'extra_class' => '',
														'description' => '',
														'enabled' => ihc_is_magic_feat_active('bp_account_page'),
									),
									'woo_account_page' => array(
														'label' => __('WooCommerce Account Page Integration', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=woo_account_page') : '',
														'icon' => 'fa-woo-ihc',
														'extra_class' => '',
														'description' => '',
														'enabled' => ihc_is_magic_feat_active('woo_account_page'),
									),
									'membership_card' => array(
														'label' => __('Membership Card', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=membership_card') : '',
														'icon' => 'fa-membership_card-ihc',
														'extra_class' => '',
														'description' => __('Printable membership cards for assigned active levels', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('membership_card'),
									),
									'cheat_off' => array(
														'label' => __('Cheat Off', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=cheat_off') : '',
														'icon' => 'fa-cheat_off-ihc',
														'extra_class' => '',
														'description' => __('Prevent your customers from sharing their login credentials by keeping only one user logged in at a time', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('cheat_off'),
									),
									'invitation_code' => array(
														'label' => __('Invitation Code', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=invitation_code') : '',
														'icon' => 'fa-invitation_code-ihc',
														'extra_class' => '',
														'description' => __('Restrict register process to only allow invited users who have a valid code.', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('invitation_code'),
									),
									'download_monitor_integration' => array(
														'label' => __('Download Monitor Integration', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=download_monitor_integration') : '',
														'icon' => 'fa-download_monitor_integration-ihc',
														'extra_class' => '',
														'description' => __('Restrict the number of downloads based on subscription / levels', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('download_monitor_integration'),
									),
									'register_lite' => array(
														'label' => __('Register Lite', 'ihc'),
														'link' => admin_url('admin.php?page=ihc_manage&tab=register_lite'),
														'icon' => 'fa-register_lite-ihc',
														'extra_class' => '',
														'description' => __('Let your users register by using only their email address', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('register_lite'),
									),
									'individual_page' => array(
														'label' => __('Individual Page', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=individual_page') : '',
														'icon' => 'fa-individual_page-ihc',
														'extra_class' => '',
														'description' => __('Each user will have an individual page', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('individual_page'),
									),
									'woo_product_custom_prices' => array(
														'label' => __('WooCommerce Products Discount', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices') : '',
														'icon' => 'fa-woo-ihc',
														'extra_class' => 'iump-woo-discounts-special-color',
														'description' => '',
														'enabled' => ihc_is_magic_feat_active('woo_product_custom_prices'),
									),
									'level_restrict_payment' => array(
														'label' => __('Levels vs Payments', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=level_restrict_payment') : '',
														'icon' => 'fa-level_restrict_payment-ihc',
														'extra_class' => '',
														'description' => __('Restrict each level to be paid only through a specific payment gateway', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('level_restrict_payment'),
									),
									'level_subscription_plan_settings' => array(
														'label' => __('Levels Plus', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=level_subscription_plan_settings') : '',
														'icon' => 'fa-level_subscription_paln_settings-ihc',
														'extra_class' => '',
														'description' => __('Decide which levels should be available, based on the user current assigned level', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('level_subscription_plan_settings'),
									),
									'gifts' => array(
														'label' => __('Membership Gifts', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=gifts') : '',
														'icon' => 'fa-gifts-ihc',
														'extra_class' => '',
														'description' => __('Your customers will be able to buy Levels as gifts', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('gifts'),
									),
									'login_level_redirect' => array(
														'label' => __('Login Redirects+', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=login_level_redirect') : '',
														'icon' => 'fa-sign-in-ihc',
														'extra_class' => '',
														'description' => __('Set a custom redirect after login based on the user assigned level(s)', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('login_level_redirect'),
									),
									'wp_social_login' => array(
														'label' => __('Wp Social Login Integration', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=wp_social_login') : '',
														'icon' => 'fa-wp_social_login-ihc',
														'extra_class' => '',
														'description' => __('Integrated for a lite register/login with social accounts', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('wp_social_login'),
									),
									'list_access_posts' => array(
														'label' => __('List Access Posts', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=list_access_posts') : '',
														'icon' => 'fa-list_access_posts-ihc',
														'extra_class' => '',
														'description' => __('Display all the posts that a user can see based on his subscriptions', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('list_access_posts'),
									),
									'invoices' => array(
														'label' => __('Order Invoices', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=invoices') : '',
														'icon' => 'fa-invoices-ihc',
														'extra_class' => '',
														'description' => __('Provides printable invoices for each order in the account page or system dashboard', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('invoices'),
									),
									'custom_currencies' => array(
														'label' => __('Custom Currencies', 'ihc'),
														'description' => __('Add new currencies (with custom symbols) alongside the predefined list', 'ihc'),
														'icon' => 'fa-currencies-ihc',
														'extra_class' => '',
														'link' => admin_url('admin.php?page=ihc_manage&tab=custom_currencies'),
														'enabled' => TRUE,
									),
									'badges' => array(
														'label' => __('Membership Badges', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=badges') : '',
														'icon' => 'fa-badges-ihc',
														'extra_class' => '',
														'description' => __('Add a custom badge for each level for a better approach', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('badges'),
									),
									'login_security' => array(
														'label' => __('Security Login', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=login_security') : '',
														'icon' => 'fa-login_security-ihc',
														'extra_class' => '',
														'description' => __('Fight against brute-force attacks by blocking login for the IP after it reaches the maximum allowed retries', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('login_security'),
									),
									'workflow_restrictions' => array(
														'label' => __('WP Workflow Restrictions', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=workflow_restrictions') : '',
														'icon' => 'fa-workflow_restrictions-ihc',
														'extra_class' => '',
														'description' => __('Limit post views, WP post submissions, WP comments based on levels', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('workflow_restrictions'),
									),
									'subscription_delay' => array(
														'label' => __('Subscription Delay', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=subscription_delay') : '',
														'icon' => 'fa-subscription_delay-ihc',
														'extra_class' => '',
														'description' => __('Set a delay for each level start time', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('subscription_delay'),
									),

									'level_dynamic_price' => array(
														'label' => __('Level Dynamic Price', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=level_dynamic_price') : '',
														'icon' => 'fa-level_dynamic_price-ihc',
														'extra_class' => '',
														'description' => __('Mimic Donations by letting the client decide how much to pay for levels', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('level_dynamic_price'),
									),

									'user_reports' => array(
														'label' => __('User Reports', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=user_reports') : '',
														'icon' => 'fa-user_reports-ihc',
														'extra_class' => '',
														'description' => __('Follow the actions of the most important users', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('user_reports'),
									),

									'pushover' => array(
														'label' => __('Pushover Notifications', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=pushover') : '',
														'icon' => 'fa-pushover-ihc',
														'extra_class' => '',
														'description' => __('Users receive notifications on mobile via Pushover', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('pushover'),
									),

									'account_page_menu' => array(
														'label' => __('Account Custom Tabs', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=account_page_menu') : '',
														'icon' => 'fa-account_page_menu-ihc',
														'extra_class' => '',
														'description' => __('Create and reorder account page menu items', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('account_page_menu'),
									),

									'mycred' => array(
														'label' => __('MyCred Points', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=mycred') : '',
														'icon' => 'fa-mycred-ihc',
														'extra_class' => '',
														'description' => __('Reward with myCred points when a subscription is purchased', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('mycred'),
									),

									'api' => array(
														'label' => __('API Gate', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=api') : '',
														'icon' => 'fa-api-ihc',
														'extra_class' => '',
														'description' => __('Manage UMP details via API module', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('api'),
									),

									'drip_content_notifications' => array(
														'label' => __('Drip Content Notifications', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=drip_content_notifications') : '',
														'icon' => 'fa-drip_content_notifications-ihc',
														'extra_class' => 'iump-dripcontentnotifications-special-color',
														'description' => __('Alert members when a new post is released by Drip Content', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('drip_content_notifications'),
									),

									'user_sites' => array(
														'label' => __('MultiSite Subscriptions', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=user_sites') : '',
														'icon' => 'fa-user_sites-ihc',
														'extra_class' => '',
														'description' => __('Provides SingleSites based on purchased subscriptions', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('user_sites'),
									),

									'import_users' => array(
														'label' => __('Import Users&Levels', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=import_users') : '',
														'icon' => 'fa-import_users-ihc',
														'extra_class' => '',
														'description' => __('Import and update main users details and levels', 'ihc'),
														'enabled' => TRUE,
									),

									'register_redirects_by_level' => array(
														'label' => __('Register Redirects+', 'ihc'),
														'link' => (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=register_redirects_by_level') : '',
														'icon' => 'fa-register_redirects_by_level-ihc',
														'extra_class' => '',
														'description' => __('Set a custom redirect after register based on the user assigned level(s)', 'ihc'),
														'enabled' => ihc_is_magic_feat_active('register_redirects_by_level'),
									),

									'zapier'	=> array(
														'label'						=> __('Zapier', 'ihc'),
														'link' 						=> (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=zapier') : '',
														'icon'						=> 'fa-zapier-ihc',
														'extra_class' 		=> '',
														'description'			=> __('Connect UMP with other apps via Zapier platform with multiple triggers available', 'ihc'),
														'enabled'					=> ihc_is_magic_feat_active('zapier'),
									),

									'infusionSoft'	=> array(
														'label'						=> __('Infusion Soft', 'ihc'),
														'link' 						=> (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=infusionSoft') : '',
														'icon'						=> 'fa-infusionSoft-ihc',
														'extra_class' 		=> '',
														'description'			=> __('Synchronize your InfusionSoft contacts based on Tags. For each user status or Level a Tag is associated.', 'ihc'),
														'enabled'					=> ihc_is_magic_feat_active('infusionSoft'),
									),

									'kissmetrics'		=> array(
														'label'						=> __('Kissmetrics', 'ihc'),
														'link' 						=> (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=kissmetrics') : '',
														'icon'						=> 'fa-kissmetrics-ihc',
														'extra_class' 		=> '',
														'description'			=> __('Track multiple membership events and User actions with Kissmetrics service', 'ihc'),
														'enabled'					=> ihc_is_magic_feat_active('kissmetrics'),
									),
									'direct_login'		=> array(
														'label'						=> __('Direct Login', 'ihc'),
														'link' 						=> (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=direct_login') : '',
														'icon'						=> 'fa-direct_login-ihc',
														'extra_class' 		=> '',
														'description'			=> __('Users can login without standard credentials but with a special temporary link available', 'ihc'),
														'enabled'					=> ihc_is_magic_feat_active('direct_login'),
									),
									'reason_for_cancel'			=> array(
														'label'						=> __('Reason for Cancelling', 'ihc'),
														'link' 						=> (IHCACTIVATEDMODE) ? admin_url('admin.php?page=ihc_manage&tab=reason_for_cancel') : '',
														'icon'						=> 'fa-reason_for_cancel-ihc',
														'extra_class' 		=> '',
														'description'			=> __('Track the reasons why users cancel/delete their Levels.', 'ihc'),
														'enabled'					=> ihc_is_magic_feat_active('reason_for_cancel'),
									),
	);
	$list = apply_filters( 'ihc_magic_feature_list', $list );
	// @description Magic feature list. @param list of magic features ( array )

	$list[ 'new_extension' ] = array(
                'label'						=> __( 'Add new Extensions', 'ihc' ),
                'link' 						=> 'https://store.wpindeed.com/',
                'icon'						=> 'fa-new-extension-ihc',
                'extra_class' 		=> 'ihc-new-extension-box',
                'description'			=> '',
                'enabled'					=> 1,
        );

	return $list;
}
endif;

if ( !function_exists( 'ihcNotificationConstants' ) ):
/**
 * @param string
 * @return string
 */
function ihcNotificationConstants( $type='' )
{
		$constants = array(
							'{username}'										=> '',
							'{user_email}'									=> '',
							'{first_name}'									=> '',
							'{last_name}'										=> '',
							'{account_page}'								=> '',
							'{login_page}'									=> '',
							'{current_level}'								=> '',
							'{current_level_expire_date}'		=> '',
							'{level_list}'									=> '',
							'{blogname}'										=> '',
							'{blogurl}'											=> '',
							'{currency}'										=> '',
							'{amount}'											=>'',
							'{level_name}'									=> '',
							'{current_date}' 								=> '',
		);
		// remove some constants
		switch ( $type ){
				case 'admin_user_register':
				case 'admin_user_payment':
				case 'register':
				case 'register_lite_send_pass_to_user':
				case 'payment':
				case 'bank_transfer':
				case 'expire':
				case 'ihc_new_subscription_assign_notification-admin':
				case 'ihc_order_placed_notification-admin':
				case 'ihc_cancel_subscription_notification-admin':
				case 'bank_transfer':
				case 'ihc_order_placed_notification-user':
				case 'ihc_subscription_activated_notification':
				case 'ihc_delete_subscription_notification-user':
				case 'ihc_cancel_subscription_notification-user':

					break;
				case 'admin_before_user_expire_level':
				case 'admin_second_before_user_expire_level':
				case 'admin_third_before_user_expire_level':
				case 'admin_user_expire_level':
				case 'admin_user_profile_update':
				case 'before_expire':
				case 'second_before_expire':
				case 'third_before_expire':
				case 'user_update':
				case 'ihc_delete_subscription_notification-admin':
					unset( $constants['{amount}'] );
					unset( $constants['{currency}'] );
					break;
				case 'reset_password_process':
			  case 'reset_password':
				case 'email_check':
				case 'email_check_success':
				case 'change_password':
				case 'approve_account':
				case 'delete_account':
				case 'drip_content-user':
				case 'review_request':
				case 'register_lite_send_pass_to_user':
					unset( $constants['{amount}'] );
					unset( $constants['{currency}'] );
					unset( $constants['{current_level_expire_date}'] );
					unset( $constants['{level_list}'] );
					unset( $constants['{level_name}'] );
					unset( $constants['{current_level}'] );
					break;
		}
		// adding some
		switch ( $type ){
				case 'reset_password':
					$constants['{NEW_PASSWORD}'] = '';
					break;
				case 'reset_password_process':
					$constants['{password_reset_link}'] = '';
					break;
				case 'drip_content-user':
					$constants['{POST_LINK}'] = '';
					break;
				case 'email_check':
					$constants['{verify_email_address_link}'] = '';
					break;
		}
		return $constants;
}
endif;

if ( !function_exists('indeed_get_unixtimestamp_with_timezone') ):
/**
 * Return unixtimestamp with the timezone set in Wp Admin dashboard.
 * @param int ( timestamp )
 * @return int
 */
function indeed_get_unixtimestamp_with_timezone( $time='' )
{
		if ( '' == $time ){
				$time = time();
		}
		$date = new DateTime();
		$date->setTimestamp( $time );
		$date->setTimezone( new DateTimeZone('UTC') );
		$time = $date->format('Y-m-d H:i:s');
		$time = get_date_from_gmt( $time );
		return strtotime( $time );
}
endif;

if ( !function_exists('indeed_get_current_time_with_timezone') ):
/**
 * Return date with the timezone set in Wp Admin dashboard.
 * @param int ( timestamp )
 * @return string
 */
function indeed_get_current_time_with_timezone( $time='' )
{
		if ( '' == $time ){
				$time = time();
		}
		$date = new DateTime();
		$date->setTimestamp( $time );
		$date->setTimezone( new DateTimeZone('UTC') );
		$time = $date->format('Y-m-d H:i:s');
		return get_date_from_gmt( $time, 'Y-m-d H:i:s' );
}
endif;

if ( !function_exists( 'indeed_timestamp_to_date_without_timezone' ) ):
/**
 * Convert a timestamp to 'Y-m-d H:i:s' format
 * @param int
 * @return string
 */
function indeed_timestamp_to_date_without_timezone( $timestamp='', $format='Y-m-d H:i:s' )
{
		if ( '' == $timestamp ){
				$timestamp = time();
		}
		$date = new DateTime();
		$date->setTimestamp( $timestamp );
		$date->setTimezone( new DateTimeZone('UTC') );
		return $date->format( $format );
}
endif;

if ( !function_exists( 'indeedObjectToArray' ) ):
function indeedObjectToArray( $object=null )
{
    if ( is_object( $object ) || is_array( $object ) ){
        $return = (array)$object;
        foreach ($return as &$item) {
            $item = indeedObjectToArray($item);
        }
        return $return;
    } else {
        return $object;
    }
}
endif;

if ( !function_exists( 'indeedIsAdmin' ) ):
function indeedIsAdmin()
{
		global $current_user;
		if ( empty( $current_user->ID ) ){
				return false;
		}
		$userData = get_userdata( $current_user->ID );
		if ( !$userData || empty( $userData->roles ) ){
				return false;
		}
		if ( !in_array( 'administrator', $userData->roles ) ){
				return false;
		}
		return true;
}
endif;

if ( !function_exists( 'ihcAdminVerifyNonce' ) ):
function ihcAdminVerifyNonce()
{
		$nonce = isset( $_SERVER['HTTP_X_CSRF_UMP_ADMIN_TOKEN'] ) ? $_SERVER['HTTP_X_CSRF_UMP_ADMIN_TOKEN']	: '';
		if ( wp_verify_nonce( $nonce, 'umpAdminNonce' ) ) {
				return true;
		}
		return false;
}
endif;

if ( !function_exists( 'ihcPublicVerifyNonce' ) ):
function ihcPublicVerifyNonce()
{
		$nonce = isset( $_SERVER['HTTP_X_CSRF_UMP_TOKEN'] ) ? $_SERVER['HTTP_X_CSRF_UMP_TOKEN']	: '';
		if ( wp_verify_nonce( $nonce, 'umpPublicNonce' ) ) {
				return true;
		}
		return false;
}
endif;

if ( !function_exists( 'ihcStripeMultiplyForCurrency') ):
function ihcStripeMultiplyForCurrency( $currency='' )
{
		$zeroDecimal = [
											'BIF',
											'CLP',
											'DJF',
											'GNF',
											'JPY',
											'KMF',
											'KRW',
											'MGA',
											'PYG',
											'RWF',
											'UGX',
											'VND',
											'VUV',
											'XAF',
											'XOF',
											'XPF',
		];
		$currency = strtoupper( $currency );
		if ( in_array( $currency, $zeroDecimal ) ){
				return 1;
		}
		return 100;
}
endif;

if ( !function_exists( 'ihcGetDefaultCountry' ) ):
function ihcGetDefaultCountry()
{
		$country = get_option( 'ihc_default_country' );
		if ( !is_string( $country ) ){
				$locale = get_locale();
				if ( strpos( $locale, '_' ) !== false ){
						$localeData = explode( '_', $locale );
						$country = isset( $localeData[1] ) ? $localeData[1] : '';
				}
		}
		return apply_filters( 'ihc_filter_the_default_country', $country );
}
endif;

/**
 * @param array
 * @return array
 */
if ( !function_exists( 'indeedFilterVarArrayElements' ) ):
function indeedFilterVarArrayElements( $data=[] )
{
		if ( !is_array( $data ) || count( $data ) == 0 ){
				return $data;
		}
		foreach ( $data as $key => $value ){
				$data[$key] = filter_var( $value, FILTER_SANITIZE_STRING );
		}
		return $data;
}
endif;

if ( !function_exists( 'ihc_payment_workflow' ) ):
/**
 * @param none
 * @return string
 */
function ihc_payment_workflow()
{
		$paymentWorkflow = get_option( 'ihc_payment_workflow' );
		if ( $paymentWorkflow == '' || $paymentWorkflow === false ){
				$paymentWorkflow = 'new';
		}
		$paymentWorkflow = apply_filters( 'ihc_filter_payment_workflow', $paymentWorkflow );
		return $paymentWorkflow;
}
endif;

if ( !function_exists( 'ihc_print_array_in_depth') ):
function ihc_print_array_in_depth( $array=[] )
{
	foreach ( $array as $key => $value ){
			if ( is_array( $value ) ){
					ihc_print_array_in_depth( $value );
			} else {
					echo $key, ': ', $value, '<br/>';
			}
	}
}
endif;

/**
 *  DEPRACATED
 */
function ihc_do_complete_level_assign_from_ap($uid=0, $lid=0, $start_time=0, $end_time=0)
{
	$succees = ihc_handle_levels_assign($uid, $lid, $start_time, $end_time);
	if ($succees){
		return TRUE;
	}
	return FALSE;
}
