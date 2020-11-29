<?php
/*
Plugin Name: Indeed Ultimate Membership Pro
Plugin URI: https://www.wpindeed.com/
Description: The most complete and easy to use Membership Plugin, ready to allow or restrict your content, Page for certain Users.
Version: 9.4
Author: WPIndeed Development
Author URI: https://www.wpindeed.com
Text Domain: ihc
Domain Path: /languages

@package        Indeed Ultimate Membership Pro
@author           WPIndeed Development
*/


///setting the paths
if (!defined('IHC_PATH')){
	define('IHC_PATH', plugin_dir_path(__FILE__));
}
if (!defined('IHC_URL')){
	define('IHC_URL', plugin_dir_url(__FILE__));
}
if (!defined('IHC_PROTOCOL')){
	if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
		define('IHC_PROTOCOL', 'https://');
	} else {
		define('IHC_PROTOCOL', 'http://');
	}
}
update_option('ihc_license_set', 1);
update_option('ihc_envato_code', 'GPL001122334455AA6677BB8899CC000');
//LANGUAGES
add_action('init', 'ihc_load_language');
function ihc_load_language(){
	load_plugin_textdomain( 'ihc', false, dirname(plugin_basename(__FILE__)).'/languages/' );
}

require_once IHC_PATH . 'utilities.php';
require_once IHC_PATH  . 'autoload.php';
require_once IHC_PATH . 'classes/Ihc_Db.class.php';
if (is_admin()){
	//go to admin
	require_once IHC_PATH . 'admin/Main.php';
} else {
	//go to public
	require_once IHC_PATH . 'public/Main.php';
}
require_once IHC_PATH  . 'public/static-data.php';

/************************ MODULES *************************/

/// WooCommerce
require_once IHC_PATH . 'classes/Ihc_Custom_Woo_Endpoint.class.php';
$ihc_woo_object = new Ihc_Custom_Woo_Endpoint();

/// BuddyPress
require_once IHC_PATH . 'classes/Ihc_Custom_BP_Endpoint.class.php';
$ihc_bp_object = new Ihc_Custom_BP_Endpoint();

/// Woo payment integration
require_once IHC_PATH . 'classes/IhcPaymentViaWoo.class.php';
$IhcPaymentViaWoo = new IhcPaymentViaWoo();

require_once IHC_PATH . 'classes/Ihc_Workflow_Restrictions.class.php';
$Ihc_Workflow_Restrictions = new Ihc_Workflow_Restrictions();

require_once IHC_PATH . 'classes/Ihc_User_Logs.class.php';
$Ihc_User_Logs = new Ihc_User_Logs();

require_once IHC_PATH . 'classes/IhcWooProductCustomPrices.class.php';
$IhcWooProductCustomPrices = new IhcWooProductCustomPrices();

require_once IHC_PATH . 'classes/IhcUserSitesActions.class.php';
$IhcUserSitesActions = new IhcUserSitesActions();

/// register custom redirect
if (get_option('ihc_register_redirects_by_level_enable')){
		require_once IHC_PATH . 'classes/Ihc_Register_Redirects.class.php';
		$Ihc_Register_Redirects = new Ihc_Register_Redirects();
}


require_once IHC_PATH . 'classes/Ihc_Actions_On_Events.php';
$Ihc_Actions_On_Events = new Ihc_Actions_On_Events();

/// GDPR
$Ihc_GDPR = new \Indeed\Ihc\Ihc_GDPR();

/// Zapier
$ihcZapier = new \Indeed\Ihc\Services\ZapierSendData();

/// infusionSoft
$ihcInfusionSoft = new \Indeed\Ihc\Services\InfusionSoft();

/// kissmetrics
$ihcKissmetrics = new \Indeed\Ihc\Services\Kissmetrics();

$ihcFilters = new \Indeed\Ihc\Filters();

$WPMLActions = new \Indeed\Ihc\Services\WPMLActions();

require_once IHC_PATH . 'classes/RegisterElementorWidgets.php';

$ihcGutenbergEditorIntegration = new \Indeed\Ihc\Services\GutenbergEditorIntegration();

$ihcMediaSecurity = new \Indeed\Ihc\UploadFilesSecurity();

$ihcGeneralActions = new \Indeed\Ihc\GeneralActions();

$ihcWpLoginCustomCss = new \Indeed\Ihc\WpLogin();

$IhcJsAlerts = new \Indeed\Ihc\JsAlerts();

$ihcElCheck = new \Indeed\Ihc\Services\ElCheck();

/******************** END MODULES **************************/

//on activating the plugin
function ihc_initiate_plugin(){
	/*
	 * @param none
	 * @return none
	 */

	/// IF PHP >5.3 don't activate plugin
	if (defined('PHP_VERSION') && version_compare(PHP_VERSION, 5.6, '<')){
		deactivate_plugins(plugin_basename( __FILE__ ));
		die('Ultimate Membership Pro requires PHP version greater than 5.6, Your current PHP is v.' . PHP_VERSION . ' . Update Your PHP and try again!');
	}

	require_once IHC_PATH . 'classes/Ihc_Db.class.php';
	Ihc_Db::add_new_role();
	Ihc_Db::save_settings_into_db();
	Ihc_Db::create_tables();
	Ihc_Db::create_notifications();
	Ihc_Db::create_default_pages();
	Ihc_Db::create_default_redirects();
	Ihc_Db::create_extra_redirects();
	Ihc_Db::create_default_lockers();
	Ihc_Db::create_demo_levels();

	$WPMLActions = new \Indeed\Ihc\Services\WPMLActions();
	$WPMLActions->registerNotifications();
	$WPMLActions->registerTaxes();
}
register_activation_hook( __FILE__, 'ihc_initiate_plugin' );

add_action('init', 'ihc_check_plugin_version');
function ihc_check_plugin_version(){
	/*
	 * @param none
	 * @return none
	 */
	$check = get_option('ihc_license_set');
	if ($check!==FALSE){
		if ($check==0)
			define('IHCACTIVATEDMODE', false);
		else
			define('IHCACTIVATEDMODE', true);
	} else {
		define('IHCACTIVATEDMODE', true);
	}
}

function ihc_admin_global_notice(){
	if (current_user_can('manage_options')){
		echo ihc_inside_dashboard_error_license(TRUE);
	}
}
add_action('admin_notices', 'ihc_admin_global_notice');

function ihc_send_notification_before_after_expire(){
	/*
	 * @param none
	 * @return none
	 */
	global $wpdb;
	$table = $wpdb->prefix . "ihc_user_levels";
	$notification_table = $wpdb->prefix . "ihc_notifications";

	$mail_sent_to_uid = array();

	/// FIRST BEFORE EXPIRE
	$first_before_expire = $wpdb->get_results("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM $notification_table WHERE notification_type='before_expire' ORDER BY id DESC LIMIT 1;");
	$first_before_expire_admin = $wpdb->get_results("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM $notification_table WHERE notification_type='admin_before_user_expire_level' ORDER BY id DESC LIMIT 1;");
	if ($first_before_expire || $first_before_expire_admin){
		$days = get_option("ihc_notification_before_time");
		if (!$days){
			$days = 5;
		}
		$lowerThan = indeed_get_unixtimestamp_with_timezone() + $days * 24 * 60 * 60;
		$graterThan = indeed_get_unixtimestamp_with_timezone() + ($days - 1) * 24 * 60 * 60;
		$now = indeed_get_unixtimestamp_with_timezone();
		$u_ids = $wpdb->get_results("SELECT id,user_id,level_id,start_time,update_time,expire_time,notification,status FROM `".$wpdb->prefix."ihc_user_levels`
										WHERE 1=1
										AND UNIX_TIMESTAMP(expire_time) > $now
										AND UNIX_TIMESTAMP(expire_time) <= $lowerThan
										AND UNIX_TIMESTAMP(expire_time) > $graterThan
		;");
		if ($u_ids){
			foreach ($u_ids as $u_data){
				$sent = FALSE;
				$uid = $u_data->user_id;
				if ($first_before_expire){
					$sent = ihc_send_user_notifications($uid, 'before_expire', $u_data->level_id);
				}
				if ($first_before_expire_admin){
					$sent = ihc_send_user_notifications($uid, 'admin_before_user_expire_level', $u_data->level_id);/// SEND NOTIFICATION TO ADMIN
				}
				if ($sent){
					// $wpdb->query("UPDATE " . $wpdb->prefix . "ihc_user_levels SET notification='1' WHERE id=" . $u_data->id . "; ");
					$mail_sent_to_uid[] = $u_data->user_id;
				}
			}
		}
	}

	/// SECOND BEFORE EXPIRE
	$second_before_expire = $wpdb->get_results("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM $notification_table WHERE notification_type='second_before_expire' ORDER BY id DESC LIMIT 1;");
	$second_before_expire_admin = $wpdb->get_results("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM $notification_table WHERE notification_type='admin_second_before_user_expire_level' ORDER BY id DESC LIMIT 1;");
	if ($second_before_expire || $second_before_expire_admin){
		$days = get_option("ihc_notification_before_time_second");
		if (!$days){
			$days = 3;
		}
		$lowerThan = indeed_get_unixtimestamp_with_timezone() + $days * 24 * 60 * 60;
		$graterThan = indeed_get_unixtimestamp_with_timezone() + ($days - 1) * 24 * 60 * 60;
		$now = indeed_get_unixtimestamp_with_timezone();
		$u_ids = $wpdb->get_results("SELECT id,user_id,level_id,start_time,update_time,expire_time,notification,status FROM $table
										WHERE 1=1
										AND UNIX_TIMESTAMP(expire_time) > $now
										AND UNIX_TIMESTAMP(expire_time) <= $lowerThan
										AND UNIX_TIMESTAMP(expire_time) > $graterThan
		;");
		if ($u_ids){
			foreach ($u_ids as $u_data){
				$sent = FALSE;
				$uid = $u_data->user_id;
				if (in_array($uid, $mail_sent_to_uid)){
					continue;
				}
				if ($second_before_expire){
					$sent = ihc_send_user_notifications($uid, 'second_before_expire', $u_data->level_id);
				}
				if ($second_before_expire_admin){
					$sent = ihc_send_user_notifications($uid, 'admin_second_before_user_expire_level', $u_data->level_id);
				}
				if ($sent){
					// $wpdb->query("UPDATE $table SET notification='-1' WHERE id=" . $u_data->id . ";");
					$mail_sent_to_uid[] = $uid;
				}
			}
		}
	}

	/// THIRD BEFORE EXPIRE
	$third_before_expire = $wpdb->get_results("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM $notification_table WHERE `notification_type`='third_before_expire' ORDER BY id DESC LIMIT 1;");
	$third_before_expire_admin = $wpdb->get_results("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM $notification_table WHERE `notification_type`='admin_third_before_user_expire_level' ORDER BY id DESC LIMIT 1;");
	if ($third_before_expire || $third_before_expire_admin){
		$days = get_option("ihc_notification_before_time_third");
		if (!$days){
			$days = 1;
		}
		$lowerThan = indeed_get_unixtimestamp_with_timezone() + $days * 24 * 60 * 60;
		$graterThan = indeed_get_unixtimestamp_with_timezone() + ($days - 1) * 24 * 60 * 60;
		$now = indeed_get_unixtimestamp_with_timezone();
		$u_ids = $wpdb->get_results("SELECT id,user_id,level_id,start_time,update_time,expire_time,notification,status FROM $table
										WHERE 1=1
										AND UNIX_TIMESTAMP(expire_time) > $now
										AND UNIX_TIMESTAMP(expire_time) <= $lowerThan
										AND UNIX_TIMESTAMP(expire_time) > $graterThan
		;");
		if ($u_ids){
			foreach ($u_ids as $u_data){
				$sent = FALSE;
				$uid = $u_data->user_id;
				if (in_array($uid, $mail_sent_to_uid)){
					continue;
				}
				if ($third_before_expire){
					$sent = ihc_send_user_notifications($uid, 'third_before_expire', $u_data->level_id);
				}
				if ($third_before_expire_admin){
					$sent =	ihc_send_user_notifications($uid, 'admin_third_before_user_expire_level', $u_data->level_id);
				}
				if ($sent){
					//$wpdb->query("UPDATE $table SET notification='-2' WHERE id=" . $u_data->id . ";");
					$mail_sent_to_uid[] = $uid;
				}
			}
		}
	}

	//// LEVEL EXPIRED
	$expire = $wpdb->get_results("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM $notification_table WHERE `notification_type`='expire' ORDER BY id DESC LIMIT 1;");
	$expire_to_admin = $wpdb->get_results("SELECT id,notification_type,level_id,subject,message,pushover_message,pushover_status,status FROM $notification_table WHERE `notification_type`='admin_user_expire_level' ORDER BY id DESC LIMIT 1;");
	if ($expire || $expire_to_admin){
		$lowerThan = indeed_get_unixtimestamp_with_timezone() - 24 * 60 * 60;
		$graterThan = indeed_get_unixtimestamp_with_timezone() - 2 * 24 * 60 * 60;
		$u_ids = $wpdb->get_results("SELECT id,user_id,level_id,start_time,update_time,expire_time,notification,status FROM `".$wpdb->prefix."ihc_user_levels`
										WHERE 1=1
										AND UNIX_TIMESTAMP( expire_time ) <= $lowerThan
										AND UNIX_TIMESTAMP( expire_time ) > $graterThan
		;"); // old version was : 	AND DATE(expire_time)=DATE(NOW()) instead of : AND UNIX_TIMESTAMP( expire_time ) < ( UNIX_TIMESTAMP( NOW() ) - ( 24 * 60 * 60 ) )
		if ($u_ids){
			foreach ($u_ids as $u_data){
				$sent = FALSE;
				if ($expire){
					$sent = ihc_send_user_notifications($u_data->user_id, 'expire', $u_data->level_id);
				}
				if ($expire_to_admin){
					$sent = ihc_send_user_notifications($u_data->user_id, 'admin_user_expire_level', $u_data->level_id);/// SEND NOTIFICATION TO ADMIN
				}
				do_action('ihc_action_level_has_expired', $u_data->user_id, $u_data->level_id);
				// @description run when level has expired. @param user id (integer), level id (integer)
				if ($sent){
					//$wpdb->query("UPDATE `".$wpdb->prefix."ihc_user_levels` SET notification='2' WHERE id=" . $u_data->id . "; ");
				}
			}
		}
	}
}
add_action( 'ihc_notifications_job', 'ihc_send_notification_before_after_expire', 82 );


////downgrade level
function ihc_check_if_level_expire_downgrade(){
	/*
	 * main function for "add another level after expire current level"
	 * @param none
	 * @return none
	 */
	global $wpdb;
	$grace_period = get_option('ihc_grace_period');
	$q = "SELECT id,user_id,level_id,start_time,update_time,expire_time,notification,status FROM `" . $wpdb->prefix . "ihc_user_levels`
			WHERE 1=1
			AND DATE(expire_time)<=DATE(NOW())
			AND DATE(expire_time)>DATE('0000-00-00 00:00:00')";
	$u_ids = $wpdb->get_results($q);
	if ($u_ids){
		foreach ($u_ids as $u_data){
			if ($grace_period){
				$expire_time_after_grace = strtotime($u_data->expire_time) + $grace_period * 24 * 60 * 60;
				if ($expire_time_after_grace>indeed_get_unixtimestamp_with_timezone()){
					continue;
				}
			}
			if (isset($u_data->level_id) && isset($u_data->user_id)){
				$added = ihc_downgrade_levels_when_expire($u_data->user_id, $u_data->level_id);
				if ($added){
					//ihc_delete_user_level_relation($u_data->level_id, $u_data->user_id);//remove the older level
				}
			}
		}
	}
}
add_action( 'ihc_check_level_downgrade', 'ihc_check_if_level_expire_downgrade', 83);

function ihc_run_check_verify_email_status(){
	/*
	 * Search for users that not verified their email address, and delete them if it's time.
	 * @param none
	 * @return none
	 */
	$time_limit = (int)get_option('ihc_double_email_delete_user_not_verified');
	if ($time_limit>-1){
		$time_limit = $time_limit * 24 * 60 * 60;
		global $wpdb;
		$data = $wpdb->get_results("SELECT user_id FROM " . $wpdb->prefix . "usermeta
										WHERE meta_key='ihc_verification_status'
										AND meta_value='-1';");
		if (!empty($data)){

			if (!function_exists('wp_delete_user')){
				require_once ABSPATH . 'wp-admin/includes/user.php';
			}

			foreach ($data as $k=>$v){
				if (!empty($v->user_id)){
					$time_data = $wpdb->get_row("SELECT user_registered FROM " . $wpdb->prefix . "users
							WHERE ID='" . $v->user_id . "';");
					if (!empty($time_data->user_registered)){
						$time_to_delete = strtotime($time_data->user_registered)+$time_limit;
						if ( $time_to_delete < indeed_get_unixtimestamp_with_timezone() ){
							//delete user
							wp_delete_user( $v->user_id );
							$wpdb->query("DELETE FROM " . $wpdb->prefix . "ihc_user_levels WHERE user_id='" . $v->user_id . "';");
							//send notification
							ihc_send_user_notifications($v->user_id, 'delete_account');
						}
					}
				}
			}
		}
	}
}
add_action( 'ihc_check_verify_email_status', 'ihc_run_check_verify_email_status', 84);

//2checkout ajax ins
add_action('wp_ajax_ihc_twocheckout_ins', 'twocheckout_ins_ihc');
add_action('wp_ajax_nopriv_ihc_twocheckout_ins', 'twocheckout_ins_ihc');
function twocheckout_ins_ihc(){
	require_once IHC_PATH . "twocheckout_ins.php";
	exit;
}


//delete attachment ajax
add_action('wp_ajax_nopriv_ihc_delete_attachment_ajax_action', 'ihc_delete_attachment_ajax_action');
add_action('wp_ajax_ihc_delete_attachment_ajax_action', 'ihc_delete_attachment_ajax_action');
function ihc_delete_attachment_ajax_action()
{
		if ( !ihcPublicVerifyNonce() ){
				die;
		}
		$uid = isset($_POST['user_id']) ? esc_sql($_POST['user_id']) : 0;
		$field_name = isset($_POST['field_name']) ? esc_sql($_POST['field_name']) : '';
		$attachment_id = isset($_POST['attachemnt_id']) ? esc_sql($_POST['attachemnt_id']) : 0;
		if (function_exists('is_user_logged_in') && is_user_logged_in()){
				$current_user = wp_get_current_user();
			  if ( !empty($uid) && $uid == $current_user->ID ){
						/// registered users
						if (!empty($attachment_id)){
								$verify_attachment_id  = get_user_meta($uid, $field_name, TRUE);
								if ($verify_attachment_id==$attachment_id){
										wp_delete_attachment($attachment_id, TRUE);
										update_user_meta($uid, $field_name, '');
										echo 0;
										die();
								}
						}
			  } else if (current_user_can('administrator')){
					 /// ADMIN, no extra checks
					 wp_delete_attachment($attachment_id, TRUE);
					 update_user_meta($uid, $field_name, '');
				}
		} else if ($uid==-1){
				/// unregistered user
				$hash_from_user = isset($_POST['h']) ? esc_sql($_POST['h']) : '';
				$attachment_url = wp_get_attachment_url($attachment_id);
				$attachment_hash = md5($attachment_url);
				if (empty($hash_from_user) || empty($attachment_hash) || $hash_from_user!==$attachment_hash){
						echo 1;die;
				} else {
						wp_delete_attachment($attachment_id, TRUE);
						echo 0;die;
				}
		}
		echo 1;
		die();
}

add_action("wp_ajax_nopriv_ihc_check_coupon_code_via_ajax", "ihc_check_coupon_code_via_ajax");
add_action('wp_ajax_ihc_check_coupon_code_via_ajax', 'ihc_check_coupon_code_via_ajax');
function ihc_check_coupon_code_via_ajax(){
	/*
	 * RETURN VALUE AFTER COUPON DISCOUNT AND ADDING TAXES
	 * use this only for stripe
	 * @param none
	 * @return array or int 0
	 */
	if ( !ihcPublicVerifyNonce() ){
 			die;
 	}
	if (!empty($_REQUEST['code']) && !empty($_REQUEST['lid'])){
		$coupon_data = ihc_check_coupon(esc_sql($_REQUEST['code']), esc_sql($_REQUEST['lid']));
		if ($coupon_data){
			$level_data = ihc_get_level_by_id(esc_sql($_REQUEST['lid']));
			$reccurence = FALSE;
			if (!empty($level_data['access_type']) && $level_data['access_type']=='regular_period'){
				$reccurence = TRUE;
			}
			if ($level_data['price'] && $coupon_data && (!empty($coupon_data['reccuring']) || !$reccurence) ){
				if ($coupon_data['discount_type']=='percentage'){
					$price = $level_data['price'] - ($level_data['price']*$coupon_data['discount_value']/100);
				} else {
					$price = $level_data['price'] - $coupon_data['discount_value'];
				}
				$price = $price * 100;
				$price = round($price, 2);

				echo json_encode(array('price'=>$price));
				die();
			}
		}
	}
	die();
}

add_filter('send_password_change_email', 'ihc_update_passowrd_filter', 99, 2);
function ihc_update_passowrd_filter($return, $user_data){
	/*
	 * send custom e-mail notification when user change his password
	 * @param return - boolean, $user_data - array
	 * @return boolean
	 */
	if (isset($user_data['ID']) && $return){
		$sent_mail = ihc_send_user_notifications($user_data['ID'], 'change_password');
		if ($sent_mail){
			return FALSE;
		}
	}
	return $return;
}


add_action("wp_ajax_nopriv_ihc_check_reg_field_ajax", "ihc_check_reg_field_ajax");
add_action('wp_ajax_ihc_check_reg_field_ajax', 'ihc_check_reg_field_ajax');
function ihc_check_reg_field_ajax()
{
	if ( !ihcPublicVerifyNonce() ){
			// echo 0;
			die;
	}
	$register_msg = ihc_return_meta_arr('register-msg');
	if (isset($_REQUEST['type']) && isset($_REQUEST['value'])){
		echo ihc_check_value_field(esc_sql($_REQUEST['type']), esc_sql($_REQUEST['value']), esc_sql($_REQUEST['second_value']), $register_msg);
		//echo ihc_check_value_field( $_REQUEST['type'], $_REQUEST['value'], $_REQUEST['second_value'], $register_msg);
	} else if (isset($_REQUEST['fields_obj'])){
		$arr = esc_sql($_REQUEST['fields_obj']);
		$return_arr = array();
		foreach ($arr as $k=>$v){
			if (isset($v['is_unique_field'])){
				if (ihc_meta_value_exists($v['type'], $v['value'])){
					$unique_msg = get_option('ihc_register_unique_value_exists');
					if (empty($unique_msg)){
						$unique_msg = __('This value already exists.', 'ihc');
					}
					$return_arr[] = array( 'type' => $v['type'], 'value' => $unique_msg );
				} else {
					$return_arr[] = array( 'type' => $v['type'], 'value' => 1 );
				}
			} else {
				$return_arr[] = array( 'type' => $v['type'], 'value' => ihc_check_value_field($v['type'], $v['value'], $v['second_value'], $register_msg) );
			}
		}
		echo json_encode($return_arr);
	}
	die();
}

function ihc_check_value_field($type='', $value='', $val2='', $register_msg=array()){
	if (isset($value) && $value!=''){
		switch ($type){
			case 'user_login':
				if (!validate_username($value)){
					$return = stripslashes( $register_msg['ihc_register_error_username_msg'] );
				}
				if (username_exists($value)) {
					$return = stripslashes( $register_msg['ihc_register_username_taken_msg'] );
				}
				break;
			case 'user_email':
				if (!is_email($value)) {
					$return = stripslashes( $register_msg['ihc_register_invalid_email_msg'] );
				}
				if (email_exists($value)){
					$return = stripslashes( $register_msg['ihc_register_email_is_taken_msg'] );//ihc_correct_text(  );
				}
				$blacklist = get_option('ihc_email_blacklist');
				if(isset($blacklist)){
					$blacklist = explode(',',preg_replace('/\s+/', '', $blacklist));

					if( count($blacklist) > 0 && in_array($value,$blacklist)){
						$return = stripslashes( $register_msg['ihc_register_email_is_taken_msg'] );
					}
				}
				$return = apply_filters( 'ump_filter_public_check_email_message', $return, $value );

				break;
			case 'confirm_email':
				if ($value==$val2){
					$return = 1;
				} else {
					$return = stripslashes( $register_msg['ihc_register_emails_not_match_msg'] );
				}
				break;
			case 'pass1':
				$register_metas = ihc_return_meta_arr('register');
				if ($register_metas['ihc_register_pass_options']==2){
					//characters and digits
					if (!preg_match('/[a-z]/', $value)){
						$return = stripslashes( $register_msg['ihc_register_pass_letter_digits_msg'] );
					}
					if (!preg_match('/[0-9]/', $value)){
						$return = stripslashes( $register_msg['ihc_register_pass_letter_digits_msg'] );
					}
				} else if ($register_metas['ihc_register_pass_options']==3){
					//characters, digits and one Uppercase letter
					if (!preg_match('/[a-z]/', $value)){
						$return = stripslashes( $register_msg['ihc_register_pass_let_dig_up_let_msg'] );
					}
					if (!preg_match('/[0-9]/', $value)){
						$return = stripslashes( $register_msg['ihc_register_pass_let_dig_up_let_msg'] );
					}
					if (!preg_match('/[A-Z]/', $value)){
						$return = stripslashes( $register_msg['ihc_register_pass_let_dig_up_let_msg'] );
					}
				}
				//check the length of password
				if($register_metas['ihc_register_pass_min_length']!=0){
					if (strlen($value)<$register_metas['ihc_register_pass_min_length']){
						$return = str_replace( '{X}', $register_metas['ihc_register_pass_min_length'], $register_msg['ihc_register_pass_min_char_msg'] );
						$return = stripslashes( $return );
					}
				}
				break;
			case 'pass2':
				if ($value==$val2){
					$return = 1;
				} else {
					$return = stripslashes( $register_msg['ihc_register_pass_not_match_msg'] );
				}
				break;
			case 'tos':
				if ($value==1){
					$return = 1;
				} else {
					$return = stripslashes( $register_msg['ihc_register_err_tos'] );
				}
				break;

			default:
				//required conditional field
				$check = ihc_required_conditional_field_test($type, $value);
				if ($check){
					$return = $check;
				} else {
					$return = 1;
				}
				break;
		}
		if (empty($return)){
			$return = 1;
		}
		return $return;
	} else {
		$check = ihc_required_conditional_field_test($type, $value);//Check for required conditional field
		if ($check){
			return $check;
		} else {
			return stripslashes( $register_msg['ihc_register_err_req_fields'] );
		}
	}
}



add_action("wp_ajax_nopriv_ihc_ap_reset_custom_banner", "ihc_ap_reset_custom_banner");
add_action('wp_ajax_ihc_ap_reset_custom_banner', 'ihc_ap_reset_custom_banner');
function ihc_ap_reset_custom_banner()
{
		if ( !ihcPublicVerifyNonce() ){
				die;
		}
		global $current_user;
		$uid = isset($current_user->ID) ? $current_user->ID : 0;
		if (empty($uid)){
				die;
		}
		$banner = isset($_POST['oldBanner']) ? esc_sql($_POST['oldBanner']) : '';
		if (empty($banner)){
				die;
		}
		update_user_meta($uid, 'ihc_user_custom_banner_src', $banner);
		die;
}

add_action("wp_ajax_nopriv_ihc_check_logic_condition_value", "ihc_check_logic_condition_value");
add_action('wp_ajax_ihc_check_logic_condition_value', 'ihc_check_logic_condition_value');
function ihc_check_logic_condition_value()
{
	/*
	 * @param none
	 * @return none (print 1 the test was passed, 0 otherwise)
	 */
	if ( !ihcPublicVerifyNonce() ){
  		die;
  }
	if (isset($_REQUEST['val']) && isset($_REQUEST['field'])){
		$fields_meta = ihc_get_user_reg_fields();
		$field = esc_sql($_REQUEST['field']);
		$request_value = esc_sql($_REQUEST['val']);
		$key = ihc_array_value_exists($fields_meta, $field, 'name');
		if ($key!==FALSE){
			if (isset($fields_meta[$key]['conditional_logic_corresp_field_value'])){
				if ($fields_meta[$key]['conditional_logic_cond_type']=='has'){
					//has value
					if ($fields_meta[$key]['conditional_logic_corresp_field_value']==$request_value){
						echo 1;
						die();
					}
				} else {
					//contain value
					if (strpos($request_value, $fields_meta[$key]['conditional_logic_corresp_field_value'])!==FALSE){
						echo 1;
						die();
					}
				}
			}
		}
	}
	echo 0;
	die();
}


add_action("wp_ajax_nopriv_ihc_check_lid_price", "ihc_check_lid_price");
add_action('wp_ajax_ihc_check_lid_price', 'ihc_check_lid_price');
function ihc_check_lid_price()
{
	if ( !ihcPublicVerifyNonce() ){
			echo 0;
			die;
	}
	if (isset($_REQUEST['level_id'])){
		$lid = esc_sql($_REQUEST['level_id']);
		$lid = (int)$lid;
		$data = ihc_get_level_by_id($lid);
		if ($data['payment_type']=='free'){
			echo 1;
			die();
		}
	}
	echo 0;
	die();
}

add_action("wp_ajax_nopriv_ihc_check_unique_value_field_register", "ihc_check_unique_value_field_register");
add_action('wp_ajax_ihc_check_unique_value_field_register', 'ihc_check_unique_value_field_register');
function ihc_check_unique_value_field_register()
{
	/*
	 * @param none
	 * @return none
	 */
	 if ( !ihcPublicVerifyNonce() ){
  			echo 0;
  			die;
  	}
	$meta_key = (empty($_REQUEST['meta_key'])) ? '' : esc_sql($_REQUEST['meta_key']);
	$meta_value = (empty($_REQUEST['meta_value'])) ? '' : esc_sql($_REQUEST['meta_value']);
	if (ihc_meta_value_exists($meta_key, $meta_value)){
		$unique_msg = get_option('ihc_register_unique_value_exists');
		if (empty($unique_msg)){
			$unique_msg = __('This value already exists.', 'ihc');
		}
		echo $unique_msg;
		die();
	}
	echo 1;
	die();
}

add_action("wp_ajax_nopriv_ihc_check_invitation_code_via_ajax", "ihc_check_invitation_code_via_ajax");
add_action('wp_ajax_ihc_check_invitation_code_via_ajax', 'ihc_check_invitation_code_via_ajax');
function ihc_check_invitation_code_via_ajax()
{
	/*
	 * @param none
	 * @return none
	 */
	 if ( !ihcPublicVerifyNonce() ){
				 die;
		 }
	$code = esc_sql(@$_REQUEST['c']);
	if (empty($code) || !Ihc_Db::invitation_code_check($code)){
		$err_msg = get_option('ihc_invitation_code_err_msg');
		if (!$err_msg){
			echo __('Your Invitation Code is wrong.', 'ihc');
		} else {
			echo $err_msg;
		}
		die();
	}
	echo 1;
	die();
}

add_action("wp_ajax_nopriv_ihc_get_amount_plus_taxes", "ihc_get_amount_plus_taxes");
add_action('wp_ajax_ihc_get_amount_plus_taxes', 'ihc_get_amount_plus_taxes');
function ihc_get_amount_plus_taxes()
{
	/*
	 * @param none
	 * @return none
	 */
	 if ( !ihcPublicVerifyNonce() ){
				 echo 0;
				 die;
		}
	if (!empty($_REQUEST['price'])){
		$price = esc_sql($_REQUEST['price']);
		$state = (isset($_REQUEST['state'])) ? esc_sql($_REQUEST['state']) : '';
		$country = isset($_REQUEST['country']) ? esc_sql($_REQUEST['country']) : '';
		$taxes_data = ihc_get_taxes_for_amount_by_country($country, $state, $price);
		if ($taxes_data && !empty($taxes_data['total'])){
			$price += $taxes_data['total'];
			$price = round($price);
		}
		echo $price;
		die();
	}
	echo @$_REQUEST['price'];
	die();
}

add_action("wp_ajax_nopriv_ihc_get_amount_plus_taxes_by_uid", "ihc_get_amount_plus_taxes_by_uid");
add_action('wp_ajax_ihc_get_amount_plus_taxes_by_uid', 'ihc_get_amount_plus_taxes_by_uid');
function ihc_get_amount_plus_taxes_by_uid()
{
	/*
	 * @param none
	 * @return none
	 */
	 if ( !ihcPublicVerifyNonce() ){
				 die;
	 }
	 if (!empty($_REQUEST['uid']) && !empty($_REQUEST['price'])){
	 	$price = esc_sql($_REQUEST['price']);
		$uid = esc_sql($_REQUEST['uid']);
	 	$ihc_country = get_user_meta($uid, 'ihc_country', TRUE);
	 	$state = get_user_meta($uid, 'ihc_state', TRUE);
		$taxes_data = ihc_get_taxes_for_amount_by_country($ihc_country, $state, $price);
		if ($taxes_data && !empty($taxes_data['total'])){
			$price += $taxes_data['total'];
			$price = round($price);
		}
	 	echo $price;
		die();
	 }
	 echo @$_REQUEST['price'];
	 die();
}

add_action("wp_ajax_nopriv_ihc_get_cart_via_ajax", "ihc_get_cart_via_ajax");
add_action('wp_ajax_ihc_get_cart_via_ajax', 'ihc_get_cart_via_ajax');
function ihc_get_cart_via_ajax()
{
	/*
	 * @param none
	 * @return none
	 */
	if ( !ihcPublicVerifyNonce() ){
  		die;
  }
	$currency = get_option("ihc_currency");
 	$data['template'] = '';
	$lid = esc_sql(@$_REQUEST['lid']);
	$country = empty($_REQUEST['country']) ? '' : esc_sql($_REQUEST['country']);
	$state = (isset($_REQUEST['state'])) ? esc_sql($_REQUEST['state']) : '';
	$paymentGateway = isset($_POST['payment_type']) ? esc_sql($_POST['payment_type']) : '';

	$trialObject = new Indeed\Ihc\Db\TrialData();
	$trialObject->setVariable('lid', $lid)
							->setVariable('currency', $currency)
							->setVariable('country', $country)
							->setVariable('state', $state)
							->run();

 	$level_data = ihc_get_level_by_id($lid);
	$data['level_label'] = ihc_correct_text($level_data['label']);
	@$data['final_price'] = $level_data['price'];

	/*************************** DYNAMIC PRICE ***************************/
	if (isset($_REQUEST['a']) && $_REQUEST['a']!=-1 && ihc_is_magic_feat_active('level_dynamic_price')){
		if (ihc_check_dynamic_price_from_user($lid, esc_sql($_REQUEST['a']) )) {
			$data['final_price'] = esc_sql($_REQUEST['a']);
		}
	}
	/*************************** DYNAMIC PRICE ***************************/

	/// LEVEL PRICE
	if ($level_data['payment_type']=='payment'){
		$data['level_price'] = ihc_format_price_and_currency($currency, $data['final_price']);
	} else {
		$data['level_price'] = __("Free", "ihc");
		$data['final_price'] = 0;
	}

	/// COUPON
	if (!empty($_REQUEST['coupon'])){
		$coupon_data = ihc_check_coupon(esc_sql($_REQUEST['coupon']), $lid);
		if ($coupon_data){
			if ($coupon_data['reccuring']==0 && $paymentGateway=='stripe'){
				$finalPrice = ihc_coupon_return_price_after_decrease($data['final_price'], $coupon_data, FALSE);
				$data['discount_value'] = ihc_get_discount_value($data['final_price'], $coupon_data);
				$data['discount_value']	 = '-' . ihc_format_price_and_currency($currency, $data['discount_value']);
				if ( (int)$finalPrice==0  && ihc_is_level_reccuring( $lid )){
						//$data['final_price'] = $finalPrice;
				} else if ( !ihc_is_level_reccuring( $lid ) ){
						$data['final_price'] = $finalPrice;
				}
			} else {
					$data['discount_value'] = ihc_get_discount_value($data['final_price'], $coupon_data);
					$data['final_price'] = ihc_coupon_return_price_after_decrease($data['final_price'], $coupon_data, FALSE);
					$data['discount_value']	 = '-' . ihc_format_price_and_currency($currency, $data['discount_value']);
			}
		}
	}

	/// TAXES
	if (!empty($data['final_price']) && ihc_is_magic_feat_active('taxes')){
		$taxes = ihc_get_taxes_for_amount_by_country($country, $state, $data['final_price']);
		/// view tax value
		$total_taxes = $taxes['total'];
		$data['total_taxes'] = $taxes['print_total'];
		$data['taxes_details'] = $taxes['items'];
		$data['print_taxes'] = get_option('ihc_show_taxes');
	}

	/// FINAL PRICE
	if (isset($total_taxes)){
		$data['final_price'] += $total_taxes;
	}
	if (isset($data['final_price'])){
		$data['price_number'] = $data['final_price'];
		$data['final_price'] = ihc_format_price_and_currency($currency, $data['final_price']);
	}

	$data['show_full_cart'] = get_option("ihc_register_show_level_price");

	$fullPath = IHC_PATH . 'public/views/cart.php';
	$searchFilename = 'cart.php';
	$template = apply_filters('ihc_filter_on_load_template', $fullPath, $searchFilename );

	ob_start();
	require $template;
	$str = ob_get_contents();
	ob_end_clean();
	echo $str;
	die();
}

add_action('admin_bar_menu', 'ihc_add_custom_admin_bar_item', 998);
function ihc_add_custom_admin_bar_item(){
	/*
	 * @param none
	 * @return none
	 */
	global $wp_admin_bar, $wpdb;
	if (!is_super_admin() || !is_admin_bar_showing()){
		return;
	}
	if (!empty($_GET['page']) && $_GET['page']=='ihc_manage' && !empty($_GET['tab'])){
		switch ($_GET['tab']){
			case 'users':
				Ihc_Db::reset_dashboard_notification('users');
				break;
			case 'orders':
				Ihc_Db::reset_dashboard_notification('orders');
				break;
		}
	}
	?>
	<style>
		.ihc-top-bar-count{
				    display: inline-block !important;
				    vertical-align: top !important;
					padding: 2px 7px !important;
				    background-color: #d54e21 !important;
				    color: #fff !important;
				    font-size: 9px !important;
				    line-height: 17px !important;
				    font-weight: 600 !important;
				    margin: 5px !important;
				    vertical-align: top !important;
				    -webkit-border-radius: 10px !important;
				    border-radius: 10px !important;
				    z-index: 26 !important;
		}
	</style>
	<?php

	if (!is_super_admin() || !is_admin_bar_showing() || get_option('ihc_admin_workflow_dashboard_notifications')==0){
		return;
	}
	$new_users = Ihc_Db::get_dashboard_notification_value('users');
	$new_orders = Ihc_Db::get_dashboard_notification_value('orders');

	$wp_admin_bar->add_menu(array(
				'id'    => 'ihc_users',
				'title' => '<span class="ihc-top-bar-count">' . $new_users . '</span>' . __('New Users', 'ihc'),
				'href'  => admin_url('admin.php?page=ihc_manage&tab=users'),
				'meta'  => array('class' => 'ihc-top-notf-admin-menu-bar'),
	));
	$wp_admin_bar->add_menu(array(
				'id'    => 'ihc_orders',
				'title' => '<span class="ihc-top-bar-count">' . $new_orders . '</span>' . __('New Orders', 'ihc'),
				'href'  => admin_url('admin.php?page=ihc_manage&tab=orders'),
				'meta'  => array('class' => 'ihc-top-notf-admin-menu-bar'),
	));
}

add_action('admin_bar_menu', 'ihc_add_custom_top_menu_dashboard', 997);
function ihc_add_custom_top_menu_dashboard(){
	/*
	 * =============== DASHBOARD TOP MENU =================
	 * @param none
	 * @return none
	 */
	global $wp_admin_bar;
	if (!is_super_admin() || !is_admin_bar_showing()){
		return;
	}

	/// PARENT
	$wp_admin_bar->add_menu(array(
				'id'    => 'ihc_dashboard_menu',
				'title' => 'Ultimate Membership Pro',
				'href'  => admin_url('admin.php?page=ihc_manage'),
				'meta'  => array(),
	));
	///ITEMS
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu', 'id'=>'ihc_dashboard_menu_pages', 'title'=>__('Membership Pages', 'ihc'), 'href'=>'#', 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu', 'id'=>'ihc_dashboard_menu_showcases', 'title'=>__('Showcases', 'ihc'), 'href'=>'#', 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu', 'id'=>'ihc_dashboard_menu_payment_gateways', 'title'=>__('Payment Gateways', 'ihc'), 'href'=>'#', 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu', 'id'=>'magic_feat', 'title'=>__('Extensions', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=magic_feat'), 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu', 'id'=>'ihc_dashboard_menu_levels', 'title'=>__('Levels', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=levels'), 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu', 'id'=>'ihc_dashboard_menu_notifications', 'title'=>__('Notifications', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=notifications'), 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu', 'id'=>'ihc_dashboard_menu_shortcodes', 'title'=>__('Shortcodes', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=user_shortcodes'), 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu', 'id'=>'general', 'title'=>__('General Options', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=general'), 'meta'=>array()));
		$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu', 'id'=>'block_url', 'title'=>__('Lock Rules', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=block_url'), 'meta'=>array()));
	/// SHOWCASES
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu_showcases', 'id'=>'ihc_dashboard_menu_showcases_rf', 'title'=>__('Register Form', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=register'), 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu_showcases', 'id'=>'ihc_dashboard_menu_showcases_lf', 'title'=>__('Login Form', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=login'), 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu_showcases', 'id'=>'ihc_dashboard_menu_showcases_sp', 'title'=>__('Subscription Plan', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=subscription_plan'), 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu_showcases', 'id'=>'ihc_dashboard_menu_showcases_ap', 'title'=>__('Account Page', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=account_page'), 'meta'=>array()));
	$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu_showcases', 'id'=>'ihc_dashboard_menu_showcases_lu', 'title'=>__('Members List', 'ihc'), 'href'=>admin_url('admin.php?page=ihc_manage&tab=listing_users'), 'meta'=>array()));

	/// PAYMENT GATEWAYS
	$gateways = ihc_get_active_payments_services();
	if ( isset($gateways['stripe_checkout_v2']) ){
			unset( $gateways['stripe_checkout_v2'] );
			$gateways['stripe_checkout'] = __( 'Stripe Checkout', 'ihc' );
	}
	foreach ($gateways as $k=>$v){
		$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu_payment_gateways', 'id'=>'ihc_dashboard_menu_gateway_' . $k, 'title'=>$v, 'href'=>admin_url('admin.php?page=ihc_manage&tab=payment_settings&subtab=' . $k), 'meta'=>array()));
	}


	$magicFeatures = ihcGetListOfMagicFeatures();
	foreach ( $magicFeatures as $k => $magicFeature ){
			$wp_admin_bar->add_menu(array('parent'=>'magic_feat', 'id'=>'magic_feat_' . $k, 'title'=> $magicFeature['label'], 'href'=> $magicFeature['link'], 'meta'=>array()));
	}


	/// DEFAULT PAGES
	$array = array(
					'ihc_general_login_default_page' 				=> __('Login', 'ihc'),
					'ihc_general_register_default_page' 		=> __('Register', 'ihc'),
					'ihc_subscription_plan_page' 						=> __('Subscription Plan', 'ihc'),
					'ihc_general_lost_pass_page' 						=> __('Lost Password', 'ihc'),
					'ihc_general_logout_page' 							=> __('LogOut', 'ihc'),
					'ihc_general_user_page' 								=> __('User Account Page', 'ihc'),
					'ihc_general_tos_page' 									=> __('TOS', 'ihc'),
	);
	foreach ($array as $k=>$v){
		$page = get_option($k);
		$permalink = get_permalink($page);
		if ($permalink){
			$wp_admin_bar->add_menu(array('parent'=>'ihc_dashboard_menu_pages', 'id'=>'ihc_dashboard_menu_pages_' . $k, 'title'=>$v, 'href'=>$permalink, 'meta'=>array('target'=>'_blank')));
		}
	}
}

//// ACTIONS

add_action('ihc_action_after_cancel_subscription', 'ihc_send_notf_after_cancel_subscription', 1, 2);
function ihc_send_notf_after_cancel_subscription($uid=0, $lid=0){
	/*
	 * @param int, int
	 * @return none
	 */
	 ///CANCEL SUBSCRIPTION USER
	 ihc_send_user_notifications($uid, 'ihc_cancel_subscription_notification-user', $lid);
	 ///CANCEL SUBSCRIPTION Admin
	 ihc_send_user_notifications($uid, 'ihc_cancel_subscription_notification-admin', $lid);
}

add_action('ihc_action_after_subscription_delete', 'ihc_send_notf_after_delete_subscription', 1, 2);
function ihc_send_notf_after_delete_subscription($uid=0, $lid=0){
	/*
	 * @param int, int
	 * @return none
	 */
	 ///DELETE SUBSCRIPTION USER
	 ihc_send_user_notifications($uid, 'ihc_delete_subscription_notification-user', $lid);
	 ///DELETE SUBSCRIPTION Admin
	 ihc_send_user_notifications($uid, 'ihc_delete_subscription_notification-admin', $lid);
}

add_action('ihc_action_after_order_placed', 'ihc_send_notf_after_order_placed', 1, 2);
function ihc_send_notf_after_order_placed($uid=0, $lid=0){
	/*
	 * @param int, int
	 * @return none
	 */
	 ///ORDER PLACED USER
	 ihc_send_user_notifications($uid, 'ihc_order_placed_notification-user', $lid);
	 ///ORDER PLACED Admin
	 ihc_send_user_notifications($uid, 'ihc_order_placed_notification-admin', $lid);
}

add_action('ihc_action_after_subscription_activated', 'ihc_send_notf_after_subscription_activated', 1, 2);
function ihc_send_notf_after_subscription_activated($uid=0, $lid=0){
	/*
	 * @param int, int
	 * @reutnr none
	 */
	 /// send notification to user
	 ihc_send_user_notifications($uid, 'ihc_subscription_activated_notification', $lid);
	 /// give a gift
	 if (ihc_is_magic_feat_active('gifts')){
		 require_once IHC_PATH . 'classes/Ihc_Gifts.class.php';
		 $gift_object = new Ihc_Gifts($uid, $lid);
	 }
}

add_action('ihc_new_subscription_action', 'ihc_send_notf_on_new_subscription', 1, 2);
function ihc_send_notf_on_new_subscription($uid=0, $lid=0){
	/*
	 * @param int, int
	 * @reutnr none
	 */
	 ihc_send_user_notifications($uid, 'ihc_new_subscription_assign_notification-admin', $lid);
}


add_action('wsl_hook_process_login_before_wp_safe_redirect', 'ihc_wp_social_login_do_redirect', 99, 0);
function ihc_wp_social_login_do_redirect(){
	/*
	 * @param none
	 * @return none, will do redirect if it's case
	 */
	if (ihc_is_magic_feat_active('wp_social_login')){
		$redirect = get_option('ihc_wp_social_login_redirect_page');
		if ($redirect && $redirect!=-1){
			$url = get_permalink($redirect);
			if (!empty($url)){
				wp_safe_redirect($url);
				die();
			}
		}
	}
}

add_action('wsl_hook_process_login_after_wp_insert_user', 'ihc_wp_social_login_after_register_action', 99, 3);
function ihc_wp_social_login_after_register_action($user_id=0, $provider='', $hybridauth_user_profile=''){
 	/*
	 * @param none
	 * @return none
	 */
	 if ($user_id){
	 	if (ihc_is_magic_feat_active('wp_social_login')){
	 		/// STORE AVATAR
	 		if (!empty($hybridauth_user_profile) && !empty($hybridauth_user_profile->photoURL)){
	 			update_user_meta($user_id, 'ihc_avatar', $hybridauth_user_profile->photoURL);
	 		}

			///ROLE
			$role = get_option('ihc_wp_social_login_default_role');
			if ($role){
				$u = new WP_User($user_id);
				$u->set_role($role);
			}

			/// LEVEL
			$lid = get_option('ihc_wp_social_login_default_level');
			if ($lid!='' && $lid!=-1){
				$level_data = get_option('ihc_levels');
				$level_data = isset($level_data[$lid]) ? $level_data[$lid] : array();
				ihc_handle_levels_assign($user_id, $lid);/// this will only add the level to user, but expire time is on hold
				ihc_update_user_level_expire($level_data, $lid, $user_id); /// update expire time
			}
		}
	 }
}

/// PAYMENT GATE
function ihc_gate_add_query_vars_filter($vars=array()){
	/*
	 * @param array
	 * @return array
	 */
	$vars[] = "ihc_action";
	$vars[] = "ihc_name";
	$vars[] = "ihc";
	return $vars;
}
add_filter('query_vars', 'ihc_gate_add_query_vars_filter', 99);


add_action('pre_get_posts', 'ihc_payment_gate_check', 999);
function ihc_payment_gate_check(){
	/*
	 * @param string
	 * @return none
	 */
	if (!empty($_GET['ihc_action'])){
		$ihc_action = $_GET['ihc_action'];
	} else {
		global $wp_query;
		if (!empty($wp_query)) $ihc_action = get_query_var('ihc_action');
	}
	 if (!empty($ihc_action)){
	 	$no_load = TRUE;
	 	switch ($ihc_action){
			case 'paypal':
				// PayPal Standard - Webhook
				if ( ihc_payment_workflow() == 'new' ){
					// new
					$object = new \Indeed\Ihc\Gateways\PayPalStandard();
					$object->webhookPayment();
				} else {
					// standard
					$object = new \Indeed\Ihc\PaymentGateways\PayPalStandard();
					$object->webhook();
				}
				break;
			case 'stripe':
				// Stripe Standard - Webhook
				require_once IHC_PATH . 'classes/PaymentGateways/stripe_webhook.php';
				break;
			case 'twocheckout':
				// TwoCheckout - Webhook
				if ( ihc_payment_workflow() == 'new' ){
					// new
					$object = new \Indeed\Ihc\Gateways\TwoCheckout();
					$object->webhookPayment();
				} else {
					// standard
					require_once IHC_PATH . 'classes/PaymentGateways/twocheckout_ins.php';
				}
				break;
			case 'authorize':
				// Authorize - Webhook
				require_once IHC_PATH . 'classes/PaymentGateways/authorize_response.php';
				break;
			case 'braintree':
				// Braintree - Webhook
				if ( version_compare( phpversion(), '7.2', '>=' ) ){
						// braintree v2
						require_once IHC_PATH . 'classes/PaymentGateways/braintree_webhook_v2.php';
				} else {
						// braintree v1
						require_once IHC_PATH . 'classes/PaymentGateways/braintree_webhook.php';
				}
				break;
			case 'mollie':
				// Mollie - Webhook
				if ( ihc_payment_workflow() == 'new' ){
					// new
					$object = new \Indeed\Ihc\Gateways\Mollie();
					$object->webhookPayment();
				} else {
					// standard
					$paymentGatewayObject = new \Indeed\Ihc\PaymentGateways\Mollie();
					$paymentGatewayObject->webhook();
				}
				break;
			case 'arrive':
				require_once IHC_PATH . 'public/action-reset_password.php';
				break;
			case 'user_activation':
				require_once IHC_PATH . 'public/action-user_activation.php';
				break;
			case 'paypal_express_complete_payment':
				// PayPal Express - Complete Recurring Payment
				if ( ihc_payment_workflow() == 'new' ){
					// new
					$object = new \Indeed\Ihc\Gateways\Libraries\PayPalExpress\PayPalExpressCheckoutNVP();
					$object->confirmAuthorization()
								 ->getExpressCheckoutDetails()
								 ->createRecurringProfile()
								 ->redirectToSuccessPage();
				} else {
					// standard
					$object = new \Indeed\Ihc\PaymentGateways\PayPalExpressCheckoutNVP();
					$object->confirmAuthorization()
								 ->getExpressCheckoutDetails()
								 ->createRecurringProfile()
								 ->redirectHome();
				}
				break;
			case 'paypal_express_single_payment_complete_payment':
				// PayPal Express - Complete Single Payment
				if ( ihc_payment_workflow() == 'new' ){
					// new
					$object = new \Indeed\Ihc\Gateways\Libraries\PayPalExpress\PayPalExpressCheckoutNVP();
					$object->completeSinglePayment()
								 ->redirectToSuccessPage();
				} else {
					// standard
					$object = new \Indeed\Ihc\PaymentGateways\PayPalExpressCheckoutNVP();
					$object->completeSinglePayment()
								 ->redirectHome();
				}
				break;
			case 'paypal_express_checkout_ipn':
				// PayPal Express - Webhook
				if ( ihc_payment_workflow() == 'new' ){
					// new
					$object = new \Indeed\Ihc\Gateways\PayPalExpressCheckout();
					$object->webhookPayment();
				} else {
					// standard
					$object = new \Indeed\Ihc\PaymentGateways\PayPalExpressCheckout();
					$object->webhook();
				}
				break;
			case 'paypal_express_cancel_payment':
				// PayPal Express - Cancel Payment
				if ( ihc_payment_workflow() == 'new' ){
					// new
					$object = new \Indeed\Ihc\Gateways\Libraries\PayPalExpress\PayPalExpressCheckoutNVP();
					$object->redirectHome();
				} else {
					// standard
					$object = new \Indeed\Ihc\PaymentGateways\PayPalExpressCheckoutNVP();
					$object->redirectHome();
				}
				break;
			case 'pagseguro':
				// Pagseguro - Webhook
				if ( ihc_payment_workflow() == 'new' ){
					// new
					$object = new \Indeed\Ihc\Gateways\Pagseguro();
					$object->webhookPayment();
				} else {
					// standard
					$object = new \Indeed\Ihc\PaymentGateways\Pagseguro();
					$object->webhook();
				}
				break;
			case 'dl':
				$token = isset($_GET['token']) ? $_GET['token'] : '';
				$directLogin = new \Indeed\Ihc\Services\DirectLogin();
				$directLogin->handleRequest($token);
				break;
			case 'stripe_checkout':
				// Stripe Checkout - Webhook
				if ( ihc_payment_workflow() == 'new' ){
					// new
					$object = new \Indeed\Ihc\Gateways\StripeCheckout();
					$object->webhookPayment();
				} else {
					// standard
					$object = new \Indeed\Ihc\PaymentGateways\StripeCheckoutV2();
					$object->webhook();
				}
				break;
			case 'social_login':
				$ihcLoadWp = true;
				require IHC_PATH . 'public/social_handler.php';
				break;
			default:
				$paymentObject = apply_filters( 'ihc_payment_gateway_create_payment_object', false, $ihc_action );
				// @description

				if ( $paymentObject ){
					if ( ihc_payment_workflow() == 'new' ){
						// new
						$paymentObject->webhookPayment();
					} else {
						// standard
						$paymentObject->webhook();
					}
				} else {
						$home = get_home_url();
						wp_safe_redirect($home);
				}


				exit;
				break;
	 	}
	 }
}


add_action("wp_ajax_nopriv_ihc_check_coupon_status_via_ajax", "ihc_check_coupon_status_via_ajax");
add_action('wp_ajax_ihc_check_coupon_status_via_ajax', 'ihc_check_coupon_status_via_ajax');
function ihc_check_coupon_status_via_ajax()
{
	/*
	 * @param none
	 * @return none
	 */
	if ( !ihcPublicVerifyNonce() ){
			die;
	}
	$data['is_active'] = 0;
	$data['success_msg'] = __('Coupon applied successfully.', 'ihc');
	$data['err_msg'] = __('Coupon code is not valid.', 'ihc');
	if (!empty($_REQUEST['c']) && isset($_REQUEST['l'])){
		$check = ihc_check_coupon(esc_sql($_REQUEST['c']), esc_sql($_REQUEST['l']));
		if (empty($check)){
			$data['is_active'] = 0;
		} else {
			$data['is_active'] = 1;
		}
	}
	echo json_encode($data);
	die();
}


add_action("wp_ajax_nopriv_ihc_get_ihc_state_field", "ihc_get_ihc_state_field");
add_action('wp_ajax_ihc_get_ihc_state_field', 'ihc_get_ihc_state_field');
function ihc_get_ihc_state_field()
{
	/*
	 * @param none
	 * @return string
	 */
	if ( !ihcPublicVerifyNonce() ){
  		die;
  }
	if (isset($_REQUEST['country'])){
		echo ihc_get_state_field_str(esc_sql($_REQUEST['country']));
	}
	die;
}

add_action("wp_ajax_nopriv_ihc_remove_sm_from_user", "ihc_remove_sm_from_user");
add_action('wp_ajax_ihc_remove_sm_from_user', 'ihc_remove_sm_from_user');
function ihc_remove_sm_from_user()
{
	/*
	 * @param none
	 * @return string
	 */
	if ( !ihcPublicVerifyNonce() ){
  		die;
  }
	if (isset($_REQUEST['type'])){
		global $current_user;
		if (isset($current_user->ID)){
			delete_user_meta($current_user->ID, 'ihc_' . esc_sql($_REQUEST['type']) );
		}
	}
	die;
}

add_action("wp_ajax_nopriv_ihc_generate_invoice", "ihc_generate_invoice");
add_action('wp_ajax_ihc_generate_invoice', 'ihc_generate_invoice');
function ihc_generate_invoice()
{
	/*
	 * @param none
	 * @return string
	 */
	if (isset($_REQUEST['order_id'])){
		$order_id = esc_sql($_REQUEST['order_id']);
		$order_id = (int)$order_id;
		if (current_user_can('administrator')){
			/// is secure so get the uid from order table
			if ( !ihcAdminVerifyNonce() ){
					die;
			}
			$uid = Ihc_Db::get_uid_by_order_id($order_id);
			$check = TRUE;
		} else {
			if ( !ihcPublicVerifyNonce() ){
					 die;
			 }
			global $current_user;
			$uid = (isset($current_user->ID)) ? $current_user->ID : 0;
			$check = Ihc_Db::is_order_id_for_uid($uid, $order_id);	/// Security check
		}

		if ($check && $uid){
			require_once IHC_PATH . 'classes/Ihc_Invoice.class.php';
			$object = new Ihc_Invoice($uid, $order_id);
			echo $object->output(TRUE);
		}
	}
	die;
}

add_action('user_register', 'ihc_increment_dashboard_user_notification', 1, 1);
function ihc_increment_dashboard_user_notification($uid=0){
	/*
	 * @param int
	 * @return none
	 */
	 Ihc_Db::increment_dashboard_notification('users');
}

if (!function_exists('ihc_do_clean_security_table')):
function ihc_do_clean_security_table(){
	/*
	 * @param none
	 * @return none
	 */
	global $wpdb;
	$table = $wpdb->prefix . 'ihc_security_login';
	$current_time = indeed_get_unixtimestamp_with_timezone();
	$expire_hours = get_option('ihc_login_security_extended_lockout_time');
	if ($expire_hours===FALSE){
		$expire_hours = 24;
	}
	$expire = $expire_hours * 60 * 60;
	$wpdb->query("UPDATE $table SET attempts_count=0, locked=0 WHERE log_time+$expire<$current_time;");
}
endif;
add_action( 'ihc_clean_security_table', 'ihc_do_clean_security_table', 84);

function ihc_send_drip_content_notifications(){
	/*
	 * @param none
	 * @return none
	 */
	require_once IHC_PATH . 'classes/DripContentNotifications.class.php';
	$object = new DripContentNotifications();
}
add_action('ihc_drip_content_notifications', 'ihc_send_drip_content_notifications', 70);


add_action('ihc_action_after_subscription_activated', 'increment_user_limit_count', 1, 2);
function increment_user_limit_count($uid=0, $lid=0){
	if (get_option('ihc_download_monitor_enabled')){
		Ihc_Db::ihc_download_monitor_update_user_limit($uid, $lid);
	}
}


//===================== MyCred Integration Module ============================
if (ihc_is_magic_feat_active('mycred')):
add_filter('mycred_setup_hooks', 'ihc_my_cred_hook');
function ihc_my_cred_hook($installed){
	$installed['ihc_mycred'] = array(
		'title'       => __('Ultimate Membership Pro', 'ihc'),
		'description' => __('Ultimate Membership Pro - buy level hook.', 'ihc'),
		'callback'    => array('Ihc_My_Cred')
	);
	return $installed;
}
add_action('mycred_load_hooks', 'mycredpro_load_custom_hook');
function mycredpro_load_custom_hook(){
	require_once IHC_PATH . 'classes/services/Ihc_My_Cred.class.php';
}
endif;
//===================== END  MyCred Integration Module ============================


$ihcAjaxObject = new \Indeed\Ihc\Ajax();
// $ihcRestrictUlp = new \Indeed\Ihc\UmpRestrictUlp();
$ihcRewriteAvatar = new \Indeed\Ihc\RewriteDefaultWpAvatar();
$ihcLoadTemplate = new \Indeed\Ihc\LoadTemplates();

// nonce
// nonce to admin pages
add_action( 'admin_head', 'ihcAdminNonce' );
function ihcAdminNonce()
{
    $nonce = wp_create_nonce( 'umpAdminNonce' );
    echo "<meta name='ump-admin-token' content='$nonce'>";
}
// Nonce to front-end pages
add_action( 'wp_head', 'ihcPublicNonce' );
function ihcPublicNonce()
{
    $nonce = wp_create_nonce( 'umpPublicNonce' );
    echo "<meta name='ump-token' content='$nonce'>";
}
