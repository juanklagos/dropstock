<?php
/*
 * Login form   [ihc-login-form] - ihc_login_form
 * LogOut Link   [ihc-logout-link] - ihc_logout_link
 * Register Form   [ihc-register] - ihc_register_form
 * Locker   [ihc-hide-content] - ihc_hide_content_shortcode
 * Reset Password Form   [ihc-pass-reset] - ihc_lost_pass_form
 * User Page   [ihc-user-page] - ihc_user_page_shortcode
 * Subscription Plan   [ihc-select-level] - ihc_print_level_link
 * User Data [ihc-user] - ihc_print_user_data
 * User Listing [ihc-list-users] - ihc_public_listing_users
 * View User Page [ihc-view-user-page] - ihc_public_view_user_page
 */
add_shortcode( 'ihc-login-form', 'ihc_login_form' );
add_shortcode( 'ihc-logout-link', 'ihc_logout_link' );
add_shortcode( 'ihc-register', 'ihc_register_form' );
add_shortcode( 'ihc-hide-content', 'ihc_hide_content_shortcode' );
add_shortcode( 'ihc-pass-reset', 'ihc_lost_pass_form' );
add_shortcode( 'ihc-user-page', 'ihc_user_page_shortcode' );
add_shortcode( 'ihc-select-level', 'ihc_user_select_level' );
add_shortcode( 'ihc-level-link', 'ihc_print_level_link' );
add_shortcode( 'ihc-lgoin-fb', 'ihc_print_fb_login' );
add_shortcode( 'ihc-user', 'ihc_print_user_data' );
add_shortcode( 'ihc-list-users', 'ihc_public_listing_users' );
add_shortcode( 'ihc-visitor-inside-user-page', 'ihc_public_visitor_inside_user_page' );
add_shortcode( 'ihc-membership-card', 'ihc_membership_card' );
add_shortcode( 'ihc-register-lite', 'ihc_do_lite_register' );
add_shortcode( 'ihc-individual-page-link', 'ihc_link_to_individual_page' );
add_shortcode( 'ihc-list-gifts', 'ihc_do_list_gifts' );
add_shortcode( 'ihc-list-all-access-posts', 'ihc_list_all_access_posts' );
add_shortcode( 'ihc-list-user-levels', 'ihc_list_user_levels' );
add_shortcode( 'ihc-suspend-account', 'ihc_suspend_account_bttn' );
add_shortcode( 'ihc-login-popup', 'ihc_login_popup' );
add_shortcode( 'ihc-register-form-for-popup', 'ihc_register_form_for_modal' );
add_shortcode( 'ihc-register-popup', 'ihc_register_popup' );

if (!function_exists('ihc_login_form')):
function ihc_login_form($attr=array()){
	/*
	 * Attributes:  template , remember , register , lost_pass , social , captcha .
	 * @param array
	 * @return string
	 */
	///////////// LOGIN FORM
	$str = '';
	if (!IHCACTIVATEDMODE){
		$str .= ihc_public_notify_trial_version();
	}
	$msg = '';
	$user_type = ihc_get_user_type();
	if ($user_type!='unreg'){
		////////////REGISTERED USER
		if ($user_type=='pending'){
			//pending user
			$msg = ihc_correct_text(get_option('ihc_register_pending_user_msg', true));
			if ($msg){
				$str .= '<div class="ihc-login-pending">' . $msg . '</div>';
			}
		} else {
			//already logged in
			if ($user_type=='admin'){
				$str .= '<div class="ihc-warning-message">' . __('<strong>Administrator Info</strong>: Login Form is not showing up once you\'re logged. You may check how it it looks for testing purpose by openeing the page into a separate incognito browser window. <i>(this message will not be visible for other users)</i>', 'ihc') . '</div>';
			}
		}
	} else {
		/////////////UNREGISTERED
		$meta_arr = ihc_return_meta_arr('login');
		if (!empty($attr['template'])){
			$meta_arr['ihc_login_template'] = $attr['template'];
		}
		if (isset($attr['remember'])){
			$meta_arr['ihc_login_remember_me'] = $attr['remember'];
		}
		if (isset($attr['register'])){
			$meta_arr['ihc_login_register'] = $attr['register'];
		}
		if (isset($attr['lost_pass'])){
			$meta_arr['ihc_login_pass_lost'] = $attr['lost_pass'];
		}
		if (isset($attr['social'])){
			$meta_arr['ihc_login_show_sm'] = $attr['social'];
		}
		if (isset($attr['captcha'])){
			$meta_arr['ihc_login_show_recaptcha'] = $attr['captcha'];
		}

		if (ihc_is_magic_feat_active('login_security')){
			require_once IHC_PATH . 'classes/Ihc_Security_Login.class.php';
			$security_object = new Ihc_Security_Login();
			if ($security_object->is_ip_on_black_list()){
				$show_form = FALSE;
				$hide_form_message = __('You are not allowed to see this Page.', 'ihc');
			} else {
				$show_form = $security_object->show_login_form();
				if (!$show_form){
					$hide_form_message = $security_object->get_locked_message();
				}
			}
		} else {
			$show_form = TRUE;
		}
		if ($show_form){
			$str .= ihc_print_form_login($meta_arr);
		}  else if (!empty($hide_form_message)){
			$str .= '<div class="ihc-wrapp-the-errors">' . $hide_form_message . '</div>';
		}
	}

	//print the message
	if (isset($_GET['ihc_success_login']) && $_GET['ihc_success_login']){
		/************************** SUCCESS ***********************/
		$msg .= get_option('ihc_login_succes');
		if (!empty($msg)){
			$str .= '<div class="ihc-login-success">' . ihc_correct_text($msg) . '</div>';
		}
	}
	return $str;
}
endif;

if (!function_exists('ihc_logout_link')):
function ihc_logout_link($attr=array()){
	/*
	 * @param array
	 * @return string
	 */
	///////////// LOGOUT FORM
	$str = '';
	if (is_user_logged_in()){
		$meta_arr = ihc_return_meta_arr('login');
		if($meta_arr['ihc_login_custom_css']){
			$str .= '<style>' . stripslashes($meta_arr['ihc_login_custom_css']) . '</style>';
		}
		if (!empty($attr['template'])){
			$meta_arr['ihc_login_template'] = $attr['template'];
		}
		$str .= '<div class="ihc-logout-wrap '.$meta_arr['ihc_login_template'].'">';
			$link = add_query_arg( 'ihcdologout', 'true', get_permalink() );//name was ihcaction, value was logout
			$str .= '<a href="'.$link.'">'.__('Log Out', 'ihc').'</a>';
		$str .= '</div>';
	}
	return $str;
}
endif;

if (!function_exists('ihc_hide_content_shortcode')):
function ihc_hide_content_shortcode($meta_arr=array(), $content=''){
	/*
	 * @param array, string
	 * @return string
	 */
	///GETTING USER TYPE
	$current_user = ihc_get_user_type();
	if ($current_user=='admin') return do_shortcode($content);//admin can view anything

	if (isset($meta_arr['ihc_mb_who'])){
		if ($meta_arr['ihc_mb_who']!=-1 && $meta_arr['ihc_mb_who']!=''){
			$target_users = explode(',', $meta_arr['ihc_mb_who']);
		} else {
			$target_users = FALSE;
		}

	} else {
		return do_shortcode($content);
	}

	////TESTING USER
	global $post;
	$block = ihc_test_if_must_block($meta_arr['ihc_mb_type'], $current_user, $target_users, @$post->ID, TRUE);

	//IF NOT BLOCKING, RETURN THE CONTENT
	if (!$block){
		return do_shortcode($content);
	}

	//LOCKER HTML
	if (isset($meta_arr['ihc_mb_template'])){
		include_once IHC_PATH . 'public/layouts-locker.php';
		return ihc_print_locker_template($meta_arr['ihc_mb_template']);
	}

	//IF SOMEHOW IT CAME UP HERE, RETURN CONTENT
	return do_shortcode($content);
}
endif;

if (!function_exists('ihc_lost_pass_form')):
function ihc_lost_pass_form(){
	/*
	 * @param none
	 * @return string
	 */
	$str = '';
	if (!is_user_logged_in()){
		$meta_arr = ihc_return_meta_arr('login');
		$str .= ihc_print_form_password($meta_arr);

		global $ihc_reset_pass;
		if ($ihc_reset_pass){
			if ($ihc_reset_pass==1){
				//reset ok
				$message = get_option('ihc_reset_msg_pass_ok');
				$message = stripslashes( $message );
				return '<span class="ihc-reset-pass-success-msg">' . $message . '</span>';
			} else {
				//reset error
				$err_msg = get_option('ihc_reset_msg_pass_err');
				$err_msg = stripslashes( $err_msg );
				if ($err_msg){
					$str .= '<div class="ihc-wrapp-the-errors">' . $err_msg . '</div>';
				}
			}
		}
	} else {
		$user_type = ihc_get_user_type();
		if ($user_type=='admin'){
			$str .= '<div class="ihc-warning-message">' . __('<strong>Administrator Info</strong>: Lost Password Form is not showing up once you\'re logged. You may check how it it looks for testing purpose by openeing the page into a separate incognito browser window. <i>(this message will not be visible for other users)</i>', 'ihc') . '</div>';

		}
	}
	return $str;
}
endif;

if (!function_exists('ihc_user_page_shortcode')):
function ihc_user_page_shortcode($attr=array()){
	/*
	 * @param array
	 * @return string
	 */
	$str = '';
	if (is_user_logged_in()){
		if (!class_exists('ihcAccountPage')){
			require_once IHC_PATH . 'classes/ihcAccountPage.class.php';
		}
		$obj = new ihcAccountPage($attr);
		$tab = isset($_GET['ihc_ap_menu']) ? $_GET['ihc_ap_menu'] : '';
		$str .= $obj->print_page($tab);
	}
	return $str;
}
endif;

if (!function_exists('ihc_register_form')):
function ihc_register_form($attr=array()){
	/*
	 * @param array
	 * @return string
	 */
	$str = '';

	if (!IHCACTIVATEDMODE){
		$str .= ihc_public_notify_trial_version();
	}

	$user_type = ihc_get_user_type();
	if ($user_type=='unreg'){
		///////ONLY UNREGISTERED CAN SEE THE REGISTER FORM

		if (isset($_GET['ihc_register'])) return;

			/// TEMPLATE
			if (!empty($attr['template'])){
				$template = $attr['template'];
			} else {
				$template = get_option('ihc_register_template');
			}

			$showForm = true;
			$showForm = apply_filters( 'ump_show_register_form', $showForm );
			if ( !$showForm ){
					return '';
			}

			/// DOUBLE EMAIL VERIFICATION
			$shortcodes_attr['double_email'] = (isset($attr['double_email'])) ? $attr['double_email'] : FALSE;
			/// ROLE
			$shortcodes_attr['role'] = (isset($attr['role'])) ? $attr['role'] : FALSE;
			/// Autologin
			$shortcodes_attr['autologin'] = (isset($attr['autologin'])) ? $attr['autologin'] : FALSE;
			/// Predefined Level
			$shortcodes_attr['level'] = (isset($attr['level'])) ? $attr['level'] : FALSE;

			$custom_style = get_option('ihc_register_custom_css');
			$str .= '<style>' . stripslashes($custom_style) . '</style>';

			global $ihc_error_register;
			if (empty($ihc_error_register)){
				$ihc_error_register = array();
			}
			if (!class_exists('UserAddEdit')){
				include_once IHC_PATH . 'classes/UserAddEdit.class.php';
			}
			$args = array(
					'user_id' 					=> false,
					'type' 							=> 'create',
					'tos' 							=> true,
					'captcha' 					=> true,
					'action' 						=> '',
					'is_public' 				=> true,
					'register_template' => $template,
					'print_errors' 			=> $ihc_error_register,
					'shortcodes_attr' 	=> $shortcodes_attr,
					'is_modal'					=> isset($attr['is_modal']) ? $attr['is_modal'] : false,
			);
			$obj_form = new UserAddEdit();
			$obj_form->setVariable($args);//setting the object variables
			$str .= '<div class="iump-register-form '.$template.'">' . $obj_form->form() . '</div>';
	} else {
		//already logged in
		if ($user_type=='admin'){
			$str .= '<div class="ihc-warning-message">' . __('<strong>Administrator Info</strong>: Register Form  is not showing up once you\'re logged. You may check how it it looks for testing purpose by openeing the page into a separate incognito browser window. <i>(this message will not be visible for other users)</i>', 'ihc') . '</div>';
		}
	}
	return $str;
}
endif;

if (!function_exists('ihc_user_select_level')):
function ihc_user_select_level($attr=array()){   /// $template='', $custom_css=''
	/*
	 * @param array
	 * @return string
	 */
	////////////////// AUTHORIZE RECURRING PAYMENT
	if (!empty($_GET['ihc_authorize_fields']) && !empty($_GET['lid'])){
		$authorize_str = ihc_authorize_reccuring_payment();
		if (!empty($authorize_str)){
			return $authorize_str;
		}
	}
	////////////////// AUTHORIZE RECURRING PAYMENT

	//// BRAINTREE
	if (!empty($_GET['ihc_braintree_fields']) && !empty($_GET['lid'])){
		$output = ihc_braintree_payment_for_reg_users();
		if (!empty($output)){
			return $output;
		}
	}
	//// BRAINTREE

	$levels = get_option('ihc_levels');
	if ($levels){
		$register_url = '';

		$levels = ihc_reorder_arr($levels);
		$levels = ihc_check_show($levels); /// SHOW/HIDE
		$levels = ihc_check_level_restricted_conditions($levels); /// MAGIC FEAT.

		$levels = apply_filters( 'ihc_public_subscription_plan_list_levels', $levels );
		// @description used in public section - subcription plan. @param list of levels to display ( array )

		if ( !empty( $attr['id'] ) ){
				if ( strpos( $attr['id'], '″' ) !== false ){
						$attr['id'] = str_replace( '″', '', $attr['id'] );
				}
				$onlyIds = strpos( $attr['id'], ',' ) === false ? array($attr['id']) : explode( ',', $attr['id'] );

				foreach ( $levels as $id => $levelData ){
						if ( !in_array( $id, $onlyIds ) ){
								unset( $levels[$id] );
						}
				}
		}

		/// TEMPLATE
		$template = (empty($attr['template'])) ? '' : $attr['template'];
		if (!$template){
			$template = get_option('ihc_level_template');
			if (!$template){
				$template = 'ihc_level_template_1';
			}
		}

		/// CUSTOM CSS
		$custom_css = (empty($attr['css'])) ? '' : $attr['css'];

		$register_page = get_option('ihc_general_register_default_page');
		if ($register_page){
			$register_url = get_permalink($register_page);
		}

		$fields = get_option('ihc_user_fields');
		///PRINT COUPON FIELD
		$num = ihc_array_value_exists($fields, 'ihc_coupon', 'name');
		$coupon_field = ($num===FALSE || empty($fields[$num]['display_public_ap'])) ? FALSE : TRUE;
		////PRINT SELECT PAYMENT
		$key = ihc_array_value_exists($fields, 'payment_select', 'name');
		$select_payment = ($key===FALSE || empty($fields[$key]['display_public_ap'])) ? FALSE : TRUE;

		$str = '';

		$u_type = ihc_get_user_type();
		if ($u_type!='unreg' && $u_type!='pending'){ /// && $u_type!='admin'
			global $current_user;
			$taxes = Ihc_Db::get_taxes_rate_for_user(@$current_user->ID);
			$register_template = get_option('ihc_register_template');
			$default_payment = get_option('ihc_payment_selected');
			if ($select_payment && empty( $attr['is_admin_preview'] ) ){
				$payments_available = ihc_get_active_payments_services();
				$register_fields_arr = ihc_get_user_reg_fields();
				$key = ihc_array_value_exists($register_fields_arr, 'payment_select', 'name');
				if (!empty($payments_available) && count($payments_available)>1 && $key!==FALSE && !empty($register_fields_arr[$key]['display_public_ap'])){
					$payment_select_string = ihc_print_payment_select($default_payment, $register_fields_arr[$key], $payments_available, 0);
				}
			}

			$the_payment_type = ( ihc_check_payment_available($default_payment) ) ? $default_payment : '';
			ob_start();
			require IHC_PATH . 'public/views/account_page-subscription_page-top_content.php';
			$str = ob_get_contents();
			ob_end_clean();
		}

		///bt message
		if (!empty($_GET['ihc_lid'])){
			global $current_user;
			$str = ihc_print_bank_transfer_order($current_user->ID, @$_GET['ihc_lid']);
			global $stop_printing_bt_msg;
			$stop_printing_bt_msg = TRUE;
		}
		include_once IHC_PATH . 'public/layouts-subscription.php';
		$str .= ihc_print_subscription_layout($template, $levels, $register_url, $custom_css, $select_payment);
		return $str;
	}
	return '';
}
endif;

if (!function_exists('ihc_print_level_link')):
/**
 * @param array
 * @param string
 * @param bool
 * @param bool
 * @return string
 */
function ihc_print_level_link( $attr, $content='', $print_payments=false, $subscription_plan=false ){

	if (!empty($_POST['stripeToken']) && (empty($_GET['ihc_register']) || $_GET['ihc_register']!='create_message') && !defined('IHC_PAYMENT_WITH_STRIPE_WAS_MADE') ){  // && empty( $subscription_plan )
		/// STRIPE PAYMENT
		ihc_pay_new_lid_with_stripe($_POST);//available in functions.php
		define( 'IHC_PAYMENT_WITH_STRIPE_WAS_MADE', true );
		unset($_POST['stripeToken']);
	} else if (isset($_GET['ihc_success_bt'])){
		/// BT PAYMENT
		add_filter('the_content', 'ihc_filter_print_bank_transfer_message', 79, 1);
	} else if (!empty($_GET['ihc_authorize_fields']) && !empty($_GET['lid'])){
		/// AUTHORIZE RECURRING PAYMENT
		add_filter('the_content', 'ihc_filter_reccuring_authorize_payment', 81, 1);
	} else if (!empty($_GET['ihc_braintree_fields']) && !empty($_GET['lid'])){
		/// BRAINTREE RECURRING PAYMENT
		add_filter('the_content', 'ihc_filter_reccuring_braintree_payment', 81, 1);
	}

	if (!empty($content)){
		$str = $content;
	} else {
		$str =  __('Sign Up', 'ihc');
	}

	$href = '';
	if (!isset($attr['class'])){
		$attr['class'] = '';
	}
	if (!isset($attr['item_class'])){
		$attr['item_class'] = '';
	}

	/// $purchased = ihc_user_has_level(get_current_user_id(), $attr['id']);
	$purchased = FALSE;

	if (!empty($purchased)){
		return ' <div class="ihc-level-item-link ihc-purchased-level"><span class="'.$attr['class'].' " >' .__('Purchased', 'ihc'). '</span></div> ';
	} else {
		$url = FALSE;
		$u_type = ihc_get_user_type();
		if ($u_type!='unreg' && $u_type!='pending'){//is_user_logged_in()
			///////////////////////////////// REGISTERED USER
			$payments_available = ihc_get_active_payments_services(TRUE);
			$level_data = ihc_get_level_by_id($attr['id']);

			if (in_array('stripe', $payments_available) || get_option('ihc_payment_selected')=='stripe'){
				/****************** STRIPE *********************/
				if ($level_data['payment_type']=='payment'){
					add_filter("the_content", "ihc_add_stripe_public_form", 80, 1);//available in functions.php
					add_action("ulp_after_single_course", "ihc_add_stripe_public_form", 99, 2);
				}
			}

				$page = get_option('ihc_general_user_page');
				$url = get_permalink($page);
				$url = add_query_arg('ihcnewlevel', 'true', $url );//add_query_arg( 'ihcaction', 'paynewlid', $url );
				$url = add_query_arg('lid', $attr['id'], $url );
				$url = add_query_arg('urlr', urlencode(IHC_PROTOCOL . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']), $url ); ///  $_SERVER['SERVER_NAME']

				$onClick = 'ihcBuyNewLevelFromAp(\''.$level_data['label'].'\', \''.$level_data['price'].'\', '.$attr['id'].', \'' . $url . '\');';

				if (!defined('IHC_HIDDEN_PAYMENT_PRINT')){ // !$subscription_plan &&
					$default_payment = get_option('ihc_payment_selected');
					$the_payment_type = ( ihc_check_payment_available($default_payment) ) ? $default_payment : '';
					$str .= '<input type=hidden name=ihc_payment_gateway value=' . $the_payment_type . ' />';
					define('IHC_HIDDEN_PAYMENT_PRINT', TRUE);
				}


			return '<div onClick="' . $onClick . '" class="ihc-level-item-link ' . $attr['item_class'] . '" style="cursor: pointer;">' . $str . '</div>';

		} else {
			//////////////////////////////// NEW USER
			if (isset($attr['register_page'])){
				$url = add_query_arg( 'lid', $attr['id'], $attr['register_page'] );
			} else {
				$page = get_option('ihc_general_register_default_page');
				$url = get_permalink($page);
				$url = add_query_arg( 'lid', $attr['id'], $url );
			}
			return '<div onClick="ihcBuyNewLevel(\'' . $url . '\');" class="ihc-level-item-link ' . $attr['item_class'] . '" style="cursor: pointer;">' . $str . '</div>';
		}
		return $str;
	}
}
endif;

if (!function_exists('ihc_print_user_data')):
function ihc_print_user_data($attr){
	/*
	 * @param array
	 * @return string
	 */
	$str = '';
	if (!empty($attr['field'])){
		global $current_user;
		if (!empty($current_user->ID)){
			$search = "{" . $attr['field'] . "}";
			$return = ihc_replace_constants($search, $current_user->ID);
			if ($search!=$return){
				$str = $return;
			}
		}
	}
	return $str;
}
endif;

if (!function_exists('ihc_public_listing_users')):
function ihc_public_listing_users($input=array()){
	/*
	 * @param array
	 * @return string
	 */
	$input['current_page'] = (empty($_REQUEST['ihcUserList_p'])) ? 1 : esc_sql($_REQUEST['ihcUserList_p']);
	if (!class_exists('ListingUsers')){
		require_once IHC_PATH . 'classes/ListingUsers.class.php';
	}
	$obj = new ListingUsers($input);
	$output = $obj->run();
	return $output;
}
endif;

if (!function_exists('ihc_public_visitor_inside_user_page')):
function ihc_public_visitor_inside_user_page(){
	/*
	 * @param
	 * @return string
	 */
	if (!empty($_GET['ihc_name'])){
		$name = $_GET['ihc_name'];
	} else {
		$name = get_query_var('ihc_name');
	}

	if (!empty($name)){
		$name = urldecode($name);
		$uid = ihc_get_user_id_by_user_login($name);
		if ($uid>0){
			$output = '';
			$content = '';
			$css = '';

			$shortcode_attr = ihc_return_meta_arr('listing_users_inside_page');

			///AVATAR
			$data['avatar_url'] = ihc_get_avatar_for_uid($uid);

			///SOCIAL MEDIA ICONS WITH LINKS
			$data['sm_links'] = ihc_return_user_sm_profile_visit($uid);

			///CUSTOM CSS
			if (!empty($shortcode_attr['ihc_listing_users_inside_page_custom_css'])){
				$shortcode_attr['ihc_listing_users_inside_page_custom_css'] = stripslashes($shortcode_attr['ihc_listing_users_inside_page_custom_css']);
				$css = '<style>' . $shortcode_attr['ihc_listing_users_inside_page_custom_css'] . '</style>';
			}

			if ($shortcode_attr['ihc_listing_users_inside_page_type']=='custom'){
				/// getting user data

				/// FLAG
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_flag'])){
					$data['flag'] = ihc_user_get_flag($uid);
				}
				/// AVATAR
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_avatar'])){
					$data['avatar'] = $data['avatar_url'];
				}
				/// SINCE
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_since'])){
					$data['since'] = ihc_convert_date_to_us_format(Ihc_Db::user_get_register_date($uid));
				}
				/// WEBSITE
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_website'])){
					$data['website'] = Ihc_Db::user_get_website($uid);
				}
				/// NAME
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_name'])){
					$first_name = get_user_meta($uid, 'first_name', TRUE);
					$last_name = get_user_meta($uid, 'last_name', TRUE);
					$data['name'] = $first_name . ' ' . $last_name;
				}
				/// USERNAME
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_username'])){
					$data['username'] = $name;
				}
				/// EMAIL
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_email'])){
					$data['email'] = Ihc_Db::user_get_email($uid);
				}
				/// LEVELS
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_level'])){
					$data['levels'] = Ihc_Db::get_user_levels($uid);
				}
				/// CUSTOM FIELDS
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_custom_fields'])){
					$temp_fields = explode(',', $shortcode_attr['ihc_listing_users_inside_page_show_custom_fields']);
					$temp_fields = ihc_order_like_register( $temp_fields );
				 	foreach ($temp_fields as $field){
				 		$label = ihc_get_custom_field_label($field);
						$type = ihc_register_field_get_type_by_slug($field);
						switch($type){
						 case 'date':
						 			$data['custom_fields'][$label] = ihc_convert_date_to_us_format(get_user_meta($uid, $field, TRUE));
						 			break;
						case 'checkbox':
						case 'multi_select':
										$values = get_user_meta($uid, $field, TRUE);
										if(!empty($values)){
											$data['custom_fields'][$label] = '';
											foreach($values as $key => $value){
												$data['custom_fields'][$label] .= $value;
												if($key < count($values)-1)
													$data['custom_fields'][$label] .= ', ';
											}
										}
									break;
						default:
									$data['custom_fields'][$label] = get_user_meta($uid, $field, TRUE);
									if ($type=='text'){
										if (strpos($data['custom_fields'][$label], 'http')!==FALSE || strpos($data['custom_fields'][$label], 'www.')!==FALSE){
											$data['custom_fields'][$label] = '<a href="' . $data['custom_fields'][$label] . '" target="_blank">' . $data['custom_fields'][$label] . '</a>';
										}
									}
							break;
						}
				 	}
				}
				/// the content
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_extra_custom_content'])){
					$data['content'] = stripslashes($shortcode_attr['ihc_listing_users_inside_page_extra_custom_content']);
				}
				/// COLOR SCHEME
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_color_scheme'])){
					$data['color_scheme_class'] = $shortcode_attr['ihc_listing_users_inside_page_color_scheme'];
				} else {
					$data['color_scheme_class'] = '';
				}

				if (!empty($shortcode_attr['ihc_listing_users_inside_page_show_banner'])){
					if (!empty($shortcode_attr['ihc_listing_users_inside_page_banner_href'])){
					$data['banner'] = $shortcode_attr['ihc_listing_users_inside_page_banner_href'];
					}else{
						$data['banner'] = 'default';
					}
				} else {
					$data['banner'] = '';
				}

				$customBanner = get_user_meta($uid, 'ihc_user_custom_banner_src', true);
				if (!empty($customBanner)){
						$data['banner'] = $customBanner;
				}
				$data['ihc_badges_on'] = get_option( 'ihc_badges_on' );
				$data['ihc_badge_custom_css'] = get_option('ihc_badge_custom_css');

				/// output
				if (!empty($shortcode_attr['ihc_listing_users_inside_page_template'])){
					switch ($shortcode_attr['ihc_listing_users_inside_page_template']){
						case 'template-2':
							$templatePath = IHC_PATH . 'public/views/view_user/template_2.php';
							$templatePath = apply_filters('ihc_filter_on_load_template', $templatePath, 'view_user/template_2.php' );
							ob_start();
							require $templatePath;
							$content = ob_get_contents();
							ob_end_clean();
							break;
						case 'template-1':
						default:
							$templatePath = IHC_PATH . 'public/views/view_user/template_1.php';
							$templatePath = apply_filters('ihc_filter_on_load_template', $templatePath, 'view_user/template_1.php' );
							ob_start();
							require $templatePath;
							$content = ob_get_contents();
							ob_end_clean();
							break;
					}
				}
			} else {
				$data['content'] = get_option('ihc_listing_users_inside_page_content');
				$data['content'] = stripslashes($data['content']);
				$content = ihc_replace_constants($data['content'], $uid, FALSE, FALSE, array('{AVATAR_HREF}'=>$data['avatar_url'], '{IHC_SOCIAL_MEDIA_LINKS}'=>$data['sm_links'] ));
				$content = '<div class="ihc-public-wrapp-visitor-user">' . $content . '</div>';
			}

			$output = $css . $content;
			return $output;
		}
	}
	return '';
}
endif;

if (!function_exists('ihc_membership_card')):
function ihc_membership_card($attr=array()){
	/*
	 * @param none
	 * @return string
	 */
	 global $current_user;
	 if (empty($current_user->ID)){
	 	return '';
	 }
	 $output = '';
	 $data['metas'] = ihc_return_meta_arr('ihc_membership_card');

	 if (!empty($attr['template'])){
			$data['metas']['ihc_membership_card_template'] = $attr['template'];
		}
	if (isset($attr['size'])){
			$data['metas']['ihc_membership_card_size'] = $attr['size'];
		}
	if (isset($attr['exclude_levels'])){
			$data['metas']['ihc_membership_card_exclude_levels'] = $attr['exclude_levels'];
		}

	 if ($data['metas']['ihc_membership_card_enable']){
	 	 $data['levels'] = Ihc_Db::get_user_levels($current_user->ID, TRUE);
		 @$exclude_levels = explode(',', @$data['metas']['ihc_membership_card_exclude_levels']);
		 $data['full_name'] = '';
		 $user_data = get_userdata($current_user->ID);
		 if (!empty($user_data->first_name) && !empty($user_data->last_name)){
			 $data['full_name'] = $user_data->first_name . ' ' . $user_data->last_name;
		 }
		 if (!empty($user_data->data) && !empty($user_data->data->user_registered)){
		 	$data['member_since'] = ihc_convert_date_to_us_format($user_data->data->user_registered);
		 }

		 if (!empty($data['levels'])){
			$fullPath = IHC_PATH . 'public/views/membership_card.php';
			$searchFilename = 'membership_card.php';
			$template = apply_filters('ihc_filter_on_load_template', $fullPath, $searchFilename );
			wp_enqueue_script( 'ihc-print-this' );
			$output .= '	<script>
					var printhisopt = {
						importCSS: true,
			            importStyle: true,
			            loadCSS:"'.IHC_URL.'assets/css/style.css",
			         	debug: false,
			        	printContainer: true,
			        	pageTitle: "",
			        	removeInline: true,
			        	printDelay: 333,
			        	header: null,
			        	formValues: false,
			        };
							jQuery(document).ready(function(){
									jQuery(".fa-print-ihc").on("click", function(e){
											var idToPrint = jQuery( e.target ).attr( "data-id-to-print" );
											jQuery( "#" + idToPrint ).printThis(printhisopt);
									});
							});
				</script>';
		 	foreach ($data['levels'] as $lid => $level_data){
		 		if (in_array($lid, $exclude_levels)){
		 			continue;
		 		}
		 		ob_start();
				include $template;
				$output .= ob_get_contents();
				ob_end_clean();
		 	}
		 }else{
			$output = '<div class="ihc-additional-message">'. __("No Membership Cards available based on your Subscriptions. SignUp on new Subscriptions or renew the existent one.", 'ihc').'</div>';
		 }
	 }
	 return $output;
}
endif;

if (!function_exists('ihc_do_lite_register')):
function ihc_do_lite_register(){
	/*
	 * @param none
	 * @return string
	 */
	$output = '';
	if (!IHCACTIVATEDMODE){
		$output .= ihc_public_notify_trial_version();
	}
	$user_type = ihc_get_user_type();
	if ($user_type=='unreg'){
		///////ONLY UNREGISTERED CAN SEE THE REGISTER FORM
		if (isset($_GET['ihc_register'])) return;

		$data['metas'] = ihc_return_meta_arr('register_lite');
		if (!empty($data['metas']['ihc_register_lite_enabled'])){
		 	if (!class_exists('LiteRegister')){
		 		include_once IHC_PATH . 'classes/LiteRegister.class.php';
		 	}

			/// TEMPLATE
			if (!empty($attr['template'])){
				$shortcodes_attr['template'] = $attr['template'];
			}
			/// DOUBLE EMAIL VERIFICATION
			$shortcodes_attr['double_email'] = (isset($attr['double_email'])) ? $attr['double_email'] : FALSE;
			/// ROLE
			$shortcodes_attr['role'] = (isset($attr['role'])) ? $attr['role'] : FALSE;
			/// Autologin
			$shortcodes_attr['autologin'] = (isset($attr['autologin'])) ? $attr['autologin'] : FALSE;
			/// Predefined Level
			$shortcodes_attr['level'] = (isset($attr['level'])) ? $attr['level'] : FALSE;

			global $ihc_error_register;
			$object = new LiteRegister();
			$object->setVariable(array(
										'user_id' => FALSE,
										'type' => 'create',
										'is_public' => TRUE,
										'print_errors' => $ihc_error_register,
										'lite_register_metas' => $data['metas'],
										'shortcodes_attr' => $shortcodes_attr,
			));
			$output = $object->form();
		}
	} else {
		//already logged in
		if ($user_type=='admin'){
			$output .= '<div class="ihc-warning-message">' . __('<strong>Administrator Info</strong>: Register Lite Form is not showing up once you\'re logged. You may check how it it looks for testing purpose by openeing the page into a separate incognito browser window. <i>(this message will not be visible for other users)</i>', 'ihc') . '</div>';
		}
	}
	return $output;
}
endif;

if (!function_exists('ihc_link_to_individual_page')):
function ihc_link_to_individual_page(){
	/*
	 * @param none
	 * @return string
	 */
	 $output = '';
	 global $current_user;
	 if (!empty($current_user->ID)){
	 	 $individual_page = get_user_meta($current_user->ID, 'ihc_individual_page', TRUE);
		 if ($individual_page){
		 	 $permalink = get_permalink($individual_page);
			 if ($permalink){
			 	$output = '<a href="' . $permalink . '" class="ihc-individual-page-link">' . __('Individual Page', 'ihc') . '</a>';
			 }
		 }
	 }
	 return $output;
}
endif;

if (!function_exists('ihc_do_list_gifts')):
function ihc_do_list_gifts(){
	/*
	 * @param none
	 * @retunr string
	 */
	$output = '';
	global $current_user;
	if (!empty($current_user) && !empty($current_user->ID)){
		$gifts = Ihc_Db::get_gifts_by_uid($current_user->ID);
		$levels = get_option('ihc_levels');
		$levels[-1]['label'] = __('All', 'ihc');
		$currency = get_option('ihc_currency');
		if ($gifts){
			$fullPath = IHC_PATH . 'public/views/listing_gifts.php';
			$searchFilename = 'listing_gifts.php';
			$template = apply_filters('ihc_filter_on_load_template', $fullPath, $searchFilename );

			ob_start();
			include $template;
			$output .= ob_get_contents();
			ob_end_clean();
		}else{
			$output = '<div class="ihc-additional-message">'. __("No Membership Gifts have been received yet", 'ihc').'</div>';
		}
	}
	return $output;
}
endif;

if (!function_exists('ihc_list_all_access_posts')):
function ihc_list_all_access_posts($attr=array()){
	/*
	 * @param array
	 * @return string
	 */
	global $current_user;
	$uid = (empty($current_user->ID)) ? 0 : $current_user->ID;
	if ($uid && ihc_is_magic_feat_active('list_access_posts')){
		 require_once IHC_PATH . 'classes/ListOfAccessPosts.class.php';
		 $levels = Ihc_Db::get_user_levels($uid, TRUE);
		 $levels = array_keys($levels);
		 $metas = ihc_return_meta_arr('list_access_posts');
		 if (!empty($attr['limit'])){
		 	$metas['ihc_list_access_posts_order_limit'] = $attr['limit'];
		 }
		 if (!empty($attr['template'])){
		 	$metas['ihc_list_access_posts_template'] = $attr['template'];
		 }
		 if (!empty($attr['order_by'])){
		 	$metas['ihc_list_access_posts_order_by'] = $attr['order_by'];
		 }
		 if (!empty($attr['order'])){
		 	$metas['ihc_list_access_posts_order_type'] = $attr['order'];
		 }
		 if (!empty($attr['post_types'])){
		 	$metas['ihc_list_access_posts_order_post_type'] = $attr['post_types'];
		 }
		 if (!empty($attr['levels_in'])){
		 	$metas['ihc_list_access_posts_order_exclude_levels'] = $attr['levels_in'];
		 }
		 if (!empty($metas['ihc_list_access_posts_order_exclude_levels'])){
			 $exclude = explode(',', $metas['ihc_list_access_posts_order_exclude_levels']);
			 if ($exclude){
				 $levels = array_diff($levels, $exclude);
			 }
		 }
		 if ($levels){
			 $object = new ListOfAccessPosts($levels, $metas);
			 return $object->output();
		 }
	}
	return '';
}
endif;

if (!function_exists('ihc_list_user_levels')):
function ihc_list_user_levels($attr=array()){
	/*
	 * @param array.
	 * Available Shortcode params:
	 * 		- exclude_expire (display expired levels - TRUE || FALSE),, default FALSE
	 * 		- badges (display levels as badges - TRUE || FALSE), default FALSE
	 * @return string
	 */
	 $output = '';
	 global $current_user;
	 if ($current_user){
	 	$uid = isset($current_user->ID) ? $current_user->ID : 0;
	 	if ($uid){
	 		$data['custom_css'] = '';
			if (empty($attr['exclude_expire'])){
				$attr['exclude_expire'] = FALSE;
			}
			if (empty($attr['badges'])){
				$attr['badges'] = FALSE;
			} else {
				$data['badges_metas'] = ihc_return_meta_arr('badges');
				if (empty($data['badges_metas']['ihc_badges_on'])){
					$data['badges'] = FALSE;
				} else if (!empty($data['badges_metas']['ihc_badge_custom_css'])){
					$data['custom_css'] = $data['badges_metas']['ihc_badge_custom_css'];
				}
			}
	 		$data['levels'] = Ihc_Db::get_user_levels($uid, $attr['exclude_expire']);

			$fullPath = IHC_PATH . 'public/views/listing_levels.php';
			$searchFilename = 'listing_levels.php';
			$template = apply_filters('ihc_filter_on_load_template', $fullPath, $searchFilename );

	 		ob_start();
			include $template;
			$output .= ob_get_contents();
			ob_end_clean();
	 	}
	 }
     return $output;
}
endif;

if ( !function_exists('ihc_register_form_for_modal') ):
function ihc_register_form_for_modal($attr=array()){
		/*
		 * @param array
		 * @return string
		 */
		$str = '';
		
		if (!IHCACTIVATEDMODE){
			$str .= ihc_public_notify_trial_version();
		}

		$user_type = ihc_get_user_type();
		if ($user_type=='unreg'){
			///////ONLY UNREGISTERED CAN SEE THE REGISTER FORM

			if (isset($_GET['ihc_register'])) return;

				/// TEMPLATE
				if (!empty($attr['template'])){
					$template = $attr['template'];
				} else {
					$template = get_option('ihc_register_template');
				}

				/// DOUBLE EMAIL VERIFICATION
				$shortcodes_attr['double_email'] = (isset($attr['double_email'])) ? $attr['double_email'] : FALSE;
				/// ROLE
				$shortcodes_attr['role'] = (isset($attr['role'])) ? $attr['role'] : FALSE;
				/// Autologin
				$shortcodes_attr['autologin'] = (isset($attr['autologin'])) ? $attr['autologin'] : FALSE;
				/// Predefined Level
				$shortcodes_attr['level'] = (isset($attr['level'])) ? $attr['level'] : FALSE;

				$custom_style = get_option('ihc_register_custom_css');
				$str .= '<style>' . stripslashes($custom_style) . '</style>';

				global $ihc_error_register;
				if (empty($ihc_error_register)){
					$ihc_error_register = array();
				}
				$args = array(
						'user_id' 					=> false,
						'type' 							=> 'create',
						'tos' 							=> true,
						'captcha' 					=> true,
						'action' 						=> '',
						'is_public' 				=> true,
						'register_template' => $template,
						'print_errors' 			=> $ihc_error_register,
						'shortcodes_attr' 	=> $shortcodes_attr,
						'is_modal'					=> isset($attr['is_modal']) ? $attr['is_modal'] : false,
				);
				$obj_form = new \Indeed\Ihc\RegisterOnModal();
				$obj_form->setVariable($args);//setting the object variables
				$str .= '<div class="iump-register-form '.$template.'">' . $obj_form->form() . '</div>';
		} else {
			//already logged in
			if ($user_type=='admin'){
				$str .= '<div class="ihc-warning-message">' . __('<strong>Administrator Info</strong>:  Register Form is not showing up once you\'re logged. You may check how it it looks for testing purpose by openeing the page into a separate incognito browser window. <i>(this message will not be visible for other users)</i>', 'ihc') . '</div>';
			}
		}
		return $str;
}
endif;

if (!function_exists('ihc_suspend_account_bttn')):
function ihc_suspend_account_bttn($attr=array()){
	/*
	 * @param array
	 * @return string
	 */
	 global $current_user;
	 $output = '';
	 if (!empty($current_user->ID)){
		 $fullPath = IHC_PATH . 'public/views/suspend_account.php';
		 $searchFilename = 'suspend_account.php';
		 $template = apply_filters('ihc_filter_on_load_template', $fullPath, $searchFilename );

	 	ob_start();
		include $template;
		$output .= ob_get_contents();
		ob_end_clean();
	 }
	 return $output;
}
endif;

if ( !function_exists('ihc_login_popup') ):
function ihc_login_popup( $attr=array(), $content='' )
{
		// don't show on register page
		global $post, $current_user;
		$isLoginPage = false;
		$loginPostId = get_option('ihc_general_login_default_page');
		if ( isset( $post->ID ) && $loginPostId == $post->ID ){
				$isLoginPage = true;
		}
		if ( !$isLoginPage && isset( $post->ID ) ){
				$pageContent = get_post_field('post_content', $post->ID );
				if ( strpos( $pageContent, '[ihc-login-form]' ) !== false ){
						$isLoginPage = true;
				}
		}

		$fullPath = IHC_PATH . 'public/views/login_popup.php';
		$searchFilename = 'login_popup.php';
		$template = apply_filters('ihc_filter_on_load_template', $fullPath, $searchFilename );
		$data = array(
				'content'							=> $content,
				'trigger'							=> empty($attr['trigger']) ? false : $attr['trigger'],
				'isLoginPage'					=> $isLoginPage,
				'uid'								  => isset( $current_user->ID ) ? $current_user->ID : 0,
		);

		$view = new \Indeed\Ihc\IndeedView();
		return $view->setTemplate( $template )->setContentData( $data, true )->getOutput();
}
endif;

if ( !function_exists('ihc_register_popup') ):
function ihc_register_popup( $attr=array(), $content='' )
{
		// don't show on register page
		global $post, $current_user;
		$isRegisterPage = false;
		$registerPostId = get_option('ihc_general_register_default_page');
		if ( isset( $post->ID ) && $registerPostId == $post->ID ){
				$isRegisterPage = true;
		}
		if ( !$isRegisterPage && isset( $post->ID ) ){
				$pageContent = get_post_field('post_content', $post->ID );
				if ( strpos( $pageContent, '[ihc-register]' ) !== false || strpos( $pageContent, '[ihc-register-lite]' ) !== false ){
						$isRegisterPage = true;
				}
		}

		$fullPath = IHC_PATH . 'public/views/register_popup.php';
		$searchFilename = 'register_popup.php';
		$template = apply_filters('ihc_filter_on_load_template', $fullPath, $searchFilename );
		$data = array(
				'content'							=> $content,
				'trigger'							=> empty($attr['trigger']) ? false : $attr['trigger'],
				'isRegisterPage'			=> $isRegisterPage,
				'uid'									=> isset( $current_user->ID ) ? $current_user->ID : 0,
		);

		$view = new \Indeed\Ihc\IndeedView();
		return $view->setTemplate( $template )->setContentData( $data, true )->getOutput();
}
endif;
