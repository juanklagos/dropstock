<?php
$dashboard_notifications = get_option('ihc_admin_workflow_dashboard_notifications');
if ($dashboard_notifications!==FALSE && $dashboard_notifications!=0){
	$new_users = Ihc_Db::get_dashboard_notification_value('users');
	$new_orders = Ihc_Db::get_dashboard_notification_value('orders');
}

$url = get_admin_url() . 'admin.php?page=ihc_manage';


$tab = 'dashboard';
if(isset($_REQUEST['tab'])) $tab = $_REQUEST['tab'];

$tabs_arr = array(
					'users' => __('Members', 'ihc'),
					'affiliates' => __('Ultimate Affiliates', 'ihc'),
					'levels' => __('Memberships', 'ihc'),
					'payment_settings' => __('Payment Services', 'ihc'),
					'locker' => __('Inside Lockers', 'ihc'),
					'showcases' => __('Showcases', 'ihc'),
					'social_login' => __("Social Login", 'ihc'),
					'coupons' => __("Coupons", "ihc"),
					'block_url' => __('Access Rules', 'ihc'),
					'orders' => __('Payment History', 'ihc'),
					'notifications' => __('Notifications', 'ihc'),
					'magic_feat' => __( 'Extensions', 'ihc'),
					'general' => __('General Options', 'ihc'),
				  );
?>
<script>
	var ihc_messages = {
					email_server_check: "<?php _e('An E-mail was sent to your Admin address. Check your inbox or Spam/Junk Folder!', 'ihc');?>",
};
</script>
<?php $plugin_vs = get_ump_version(); ?>
<div class="ihc-dashboard-wrap">
	<div class="ihc-admin-header">
		<div class="ihc-top-menu-section">
			<div class="ihc-dashboard-logo">
			<a href="<?php echo $url.'&tab=dashboard';?>">
				<img src="<?php echo IHC_URL;?>admin/assets/images/dashboard-logo.jpg"/>
				<div class="ihc-plugin-version"><?php echo $plugin_vs; ?></div>
			</a>
			</div>
			<div class="ihc-dashboard-menu">
            	<div class="ihc-admin-mobile-bttn-wrapp"><i class="ihc-admin-mobile-bttn"></i></div>
				<ul  class="ihc-dashboard-menu-items">
				<?php
					foreach($tabs_arr as $k=>$v){
						$selected = '';
						$menu_tab = $tab;
						switch($tab){
							case 'register':
											$menu_tab='showcases';
											break;
							case 'login':
											$menu_tab='showcases';
											break;
							case 'subscription_plan':
											$menu_tab='showcases';
											break;
							case 'account_page':
											$menu_tab='showcases';
											break;
						}


						if($menu_tab==$k) $selected = 'selected';

						if (!IHCACTIVATEDMODE && $k=='coupons'){
							$tab_url = '';
							$dezactivated_class = 'ihc-inactive-tab';
						} else {
							$dezactivated_class = '';
							$tab_url = $url . '&tab=' . $k;
						}
						if($k=='affiliates'){
							$dezactivated_class = 'ihc-affiliates_menu '.$dezactivated_class;
						}
						if($k=='magic_feat'){
							$dezactivated_class = 'ihc-magic_feat_menu '.$dezactivated_class;
						}
							?>
								<li class="<?php echo $selected;?>">
									<?php
									if ($k=='users' && !empty($new_users)){
										echo '<div class="ihc-dashboard-notification-top">' . $new_users . '</div>';
									} else if ($k=='orders' && !empty($new_orders)){
										echo '<div class="ihc-dashboard-notification-top">' . $new_orders . '</div>';
									}
									?>
									<a href="<?php echo $tab_url;?>" title="<?php echo $v;?>">
										<div class="ihc-page-title <?php echo $dezactivated_class;?>">
											<i class="fa-ihc fa-ihc-menu fa-<?php echo $k;?>-ihc"></i>
											<div><?php echo $v;?></div>
										</div>
									</a>
								</li>
							<?php

					}
				?>

				</ul>
			</div>
		</div>
	</div>
	<?php
		//tabs
		switch($tab){
			case 'dashboard':
				include_once IHC_PATH . 'admin/includes/tabs/dashboard.php';
			break;
			case 'users':
				include_once IHC_PATH . 'admin/includes/tabs/users.php';
			break;
			case 'levels':
				include_once IHC_PATH . 'admin/includes/tabs/levels.php';
			break;
			case 'locker':
				include_once IHC_PATH . 'admin/includes/tabs/locker.php';
			break;
			case 'register':
				include_once IHC_PATH . 'admin/includes/tabs/register.php';
			break;
			case 'login':
				include_once IHC_PATH . 'admin/includes/tabs/login.php';
			break;
			case 'general':
				include_once IHC_PATH . 'admin/includes/tabs/general.php';
			break;
			case 'block_url':
				include_once IHC_PATH . 'admin/includes/tabs/block_url.php';
			break;
			case 'opt_in':
				include_once IHC_PATH . 'admin/includes/tabs/opt_in.php';
			break;
			case 'payment_settings':
				include_once IHC_PATH . 'admin/includes/tabs/payment_settings.php';
			break;
			case 'help':
				include_once IHC_PATH . 'admin/includes/tabs/help.php';
			break;
			case 'notifications':
				include_once IHC_PATH . 'admin/includes/tabs/notifications.php';
			break;
			case 'showcases':
				include_once IHC_PATH . 'admin/includes/tabs/showcases.php';
			break;
			case 'subscription_plan':
				include_once IHC_PATH . 'admin/includes/tabs/subscription_plan.php';
			break;
			case 'social_login':
				include_once IHC_PATH . 'admin/includes/tabs/social_login.php';
			break;
			case 'account_page':
				include_once IHC_PATH . 'admin/includes/tabs/account_page.php';
			break;
			case 'coupons':
				include_once IHC_PATH . 'admin/includes/tabs/coupons.php';
			break;
			case 'user_shortcodes':
				include_once IHC_PATH . 'admin/includes/tabs/user_shortcodes.php';
			break;
			case 'listing_users':
				include_once IHC_PATH . 'admin/includes/tabs/listing_users.php';
			break;
			case 'affiliates':
				include_once IHC_PATH . 'admin/includes/tabs/affiliates.php';
			break;
			case 'new_transaction':
				include_once IHC_PATH . 'admin/includes/tabs/new_transaction.php';
				break;
			case 'magic_feat':
				require_once IHC_PATH . 'admin/includes/tabs/magic_feat.php';
				break;
			case 'taxes':
				require_once IHC_PATH . 'admin/includes/tabs/taxes.php';
				break;
			case 'add_edit_taxes':
				require_once IHC_PATH . 'admin/includes/tabs/add_edit_taxes.php';
				break;
			case 'orders':
				require_once IHC_PATH . 'admin/includes/tabs/orders.php';
				break;
			case 'payments':
				include_once IHC_PATH . 'admin/includes/tabs/list_payments.php';
				break;
			case 'redirect_links':
				require_once IHC_PATH . 'admin/includes/tabs/redirect_links.php';
				break;
			case 'custom_currencies':
				require_once IHC_PATH . 'admin/includes/tabs/custom_currencies.php';
				break;
			case 'bp_account_page':
				require_once IHC_PATH . 'admin/includes/tabs/bp_account_page.php';
				break;
			case 'woo_account_page':
				require_once IHC_PATH . 'admin/includes/tabs/woo_account_page.php';
				break;
			case 'membership_card':
				require_once IHC_PATH . 'admin/includes/tabs/membership_card.php';
				break;
			case 'cheat_off':
				require_once IHC_PATH . 'admin/includes/tabs/cheat_off.php';
				break;
			case 'invitation_code':
				require_once IHC_PATH . 'admin/includes/tabs/invitation_code.php';
				break;
			case 'invitation_code-add_new':
				require_once IHC_PATH . 'admin/includes/tabs/invitation_code_add_new.php';
				break;
			case 'download_monitor_integration':
				require_once IHC_PATH . 'admin/includes/tabs/download_monitor_integration.php';
				break;
			case 'register_lite':
				require_once IHC_PATH . 'admin/includes/tabs/register_lite.php';
				break;
			case 'individual_page':
				require_once IHC_PATH . 'admin/includes/tabs/individual_page.php';
				break;
			case 'level_restrict_payment':
				require_once IHC_PATH . 'admin/includes/tabs/level_restrict_payment.php';
				break;
			case 'level_subscription_plan_settings':
				require_once IHC_PATH . 'admin/includes/tabs/level_subscription_plan_settings.php';
				break;
			case 'gifts':
				require_once IHC_PATH . 'admin/includes/tabs/gifts.php';
				break;
			case 'add_new_gift':
				require_once IHC_PATH . 'admin/includes/tabs/add_new_gift.php';
				break;
			case 'generated-gift-code':
				require_once IHC_PATH . 'admin/includes/tabs/list_gift_codes.php';
				break;
			case 'login_level_redirect':
				require_once IHC_PATH . 'admin/includes/tabs/login_level_redirect.php';
				break;
			case 'register_redirects_by_level':
				require_once IHC_PATH . 'admin/includes/tabs/magic_feat_custom_register_redirects.php';
				break;
			case 'wp_social_login':
				require_once IHC_PATH . 'admin/includes/tabs/wp_social_login.php';
				break;
			case 'list_access_posts':
				require_once IHC_PATH . 'admin/includes/tabs/list_access_posts.php';
				break;
			case 'invoices':
				require_once IHC_PATH . 'admin/includes/tabs/invoices.php';
				break;
			case 'woo_payment':
				require_once IHC_PATH . 'admin/includes/tabs/woo_payment.php';
				break;
			case 'badges':
				require_once IHC_PATH . 'admin/includes/tabs/badges.php';
				break;
			case 'login_security':
				require_once IHC_PATH . 'admin/includes/tabs/login_security.php';
				break;
			case 'workflow_restrictions':
				require_once IHC_PATH . 'admin/includes/tabs/workflow_restrictions.php';
				break;
			case 'subscription_delay':
				require_once IHC_PATH . 'admin/includes/tabs/subscription_delay.php';
				break;
			case 'level_dynamic_price':
				require_once IHC_PATH . 'admin/includes/tabs/level_dynamic_price.php';
				break;
			case 'view_user_logs':
				require_once IHC_PATH . 'admin/includes/tabs/view_user_logs.php';
				break;
			case 'user_reports':
				require_once IHC_PATH . 'admin/includes/tabs/user_reports.php';
				break;
			case 'pushover':
				require_once IHC_PATH . 'admin/includes/tabs/pushover.php';
				break;
			case 'account_page_menu':
				require_once IHC_PATH . 'admin/includes/tabs/account_page_menu.php';
				break;
			case 'mycred':
				require_once IHC_PATH . 'admin/includes/tabs/mycred.php';
				break;
			case 'api':
				require_once IHC_PATH . 'admin/includes/tabs/api.php';
				break;
			case 'import_export':
				require_once IHC_PATH . 'admin/includes/tabs/import_export.php';
				break;
			case 'woo_product_custom_prices':
				$temp_subtab = isset($_GET['subtab']) ? $_GET['subtab'] : 'manage';
				switch ($temp_subtab){
					case 'manage':
						require_once IHC_PATH . 'admin/includes/tabs/woo_product_custom_prices-manage.php';
						break;
					case 'add_edit':
						require_once IHC_PATH . 'admin/includes/tabs/woo_product_custom_prices-add_edit.php';
						break;
					case 'settings':
						require_once IHC_PATH . 'admin/includes/tabs/woo_product_custom_prices-settings.php';
						break;
				}
				break;
			case 'drip_content_notifications':
				require_once IHC_PATH . 'admin/includes/tabs/drip_content_notifications.php';
				break;
			case 'view_drip_content_notifications_logs':
				require_once IHC_PATH . 'admin/includes/tabs/drip_content_notifications_logs.php';
				break;
			case 'user_sites':
				require_once IHC_PATH . 'admin/includes/tabs/user_sites.php';
				break;
			case 'import_users':
				require_once IHC_PATH . 'admin/includes/tabs/import_users.php';
				break;
			case 'add_new_order':
				require_once IHC_PATH . 'admin/includes/tabs/add_new_order.php';
				break;
			case 'zapier':
				require_once IHC_PATH . 'admin/includes/tabs/zapier.php';
				break;
			case 'infusionSoft':
				require_once IHC_PATH . 'admin/includes/tabs/infusionSoft.php';
				break;
		  case 'kissmetrics':
				require_once IHC_PATH . 'admin/includes/tabs/kissmetrics.php';
				break;
			case 'direct_login':
				require_once IHC_PATH . 'admin/includes/tabs/direct_login.php';
				break;
			case 'reason_for_cancel':
				require_once IHC_PATH . 'admin/includes/tabs/reason_for_cancel.php';
				break;
			default :
				do_action( 'ump_print_admin_page', $tab );
				break;
		}

	?>

</div>
<div class="ihc-footer-wrap">
	<div class="ihc-additional-help">
	<div class="ihc-footer-text"><strong>Ultimate Membership Pro v. <?php echo $plugin_vs; ?></strong> Wordpress Plugin by <a href="https://codecanyon.net/user/azzaroco/portfolio?ref=azzaroco" target="_blank">azzaroco</a></div>
	<a href="https://codecanyon.net/item/ultimate-membership-pro-wordpress-plugin/12159253?ref=azzaroco" target="_blank" title="Support us with 5-stars Rating for further development" class="button float_right ihc-black-button" style="margin-right: 5px;"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 5-stars Rating </a>
	<a href="http://help.wpindeed.com/ultimate-membership-pro/" target="_blank" title="Knowledge Base" class="button float_right ihc-green-button" style="margin-right: 5px;"><i class="fa fa-book"></i> Knowledge Base</a>
    <a href="https://www.youtube.com/playlist?list=PLmOiaKgLhsFlhpkMb_fHKV45u4qZ1IZHd" target="_blank" title="Video Tutorials" class="button float_right ihc-red-button" style="margin-right: 5px;"><i class="fa fa-book"></i> Video Tutorials</a>
    <a href="https://store.wpindeed.com/addon/category/ultimate-membership-pro/" target="_blank" title="Video Tutorials" class="button float_right ihc-blue-button" style="margin-right: 5px;"><i class="fa fa-book"></i> Extra AddOns</a>
	<a href="http://codecanyon.net/downloads/" target="_blank" title="Download Item" class="button float_right" style="margin-right: 5px;"><i class="fa fa-download"></i> Download</a>
	</div>
</div>
<div class="ihc-right-menu">
	<?php
		$right_menu = array(
							'user_shortcodes' => 'Shortcodes',
							'import_export' => __('Import/Export', 'ihc'),
							'help' => __('Help', 'ihc')
		);
		foreach ($right_menu as $k=>$v){
		?>
		<div class="ihc-right-menu-item">
			<a href="<?php echo $url . '&tab=' . $k;?>" title="<?php echo $v;?>">
				<div class="ihc-page-title <?php echo $dezactivated_class;?>">
					<i class="fa-ihc fa-ihc-menu fa-<?php echo $k;?>-ihc"></i>
					<div class="ihc-right-menu-title"><?php echo $v;?></div>
				</div>
			</a>
		</div>
		<?php
		}
	?>
</div>
<?php wp_enqueue_script('ihc-back_end');?>
