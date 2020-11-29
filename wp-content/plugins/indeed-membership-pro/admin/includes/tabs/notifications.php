<?php
echo ihc_inside_dashboard_error_license();
echo ihc_check_default_pages_set();
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<div class="iump-wrapper">
<?php
$notification_arr = array(
		'admin_user_register' => __('New Registered User', 'ihc'), // - Admin Notification
		'admin_before_user_expire_level' => __('First Alert Before Level Expire', 'ihc'),
		'admin_second_before_user_expire_level' => __('Second Alert Before Level Expire', 'ihc'),
		'admin_third_before_user_expire_level' => __('Third Alert Before Level Expire', 'ihc'),
		'admin_user_expire_level' => __('After Level Expired', 'ihc'),
		'admin_user_payment' => __('New Payment Completed', 'ihc'),
		'admin_user_profile_update' => __('User Profile Update', 'ihc'),

		'ihc_cancel_subscription_notification-admin' => __('When the Subscription was Canceled', 'ihc'),
		'ihc_delete_subscription_notification-admin' => __('When the Subscription was Deleted', 'ihc'),
		'ihc_order_placed_notification-admin' => __('New Order placed', 'ihc'),
		'ihc_new_subscription_assign_notification-admin' => __('New Subscription assign', 'ihc'),

		'register' => __('New Account', 'ihc'), //Register
		'register_lite_send_pass_to_user' => __('Register Lite - Send password to user', 'ihc'),
		'review_request' => __('New Account Review Request', 'ihc'), //register with pending
		'before_expire' => __('First Alert Before Level Expire', 'ihc'),
		'second_before_expire' => __('Second Alert Before Level Expire', 'ihc'),
		'third_before_expire' => __('Third Alert Before Level Expire', 'ihc'),
		'expire' => __('After Level Expired', 'ihc'),
		'email_check' => __('Double E-mail Verification Request', 'ihc'),
		'email_check_success' => __('Double E-mail Verification Validated', 'ihc'),
		'reset_password_process' => __('Reset Password Start Process', 'ihc'),
		'reset_password' => __('Reset Password Request', 'ihc'),
		'change_password' => __('Changed Password Inform', 'ihc'),
		'approve_account' => __('Approve Account'),
		'delete_account' => __('Deleted Account Inform', 'ihc'),
		'payment' => __('New Payment Completed', 'ihc'),
		'user_update' => __('User Profile Updates', 'ihc'),
		'bank_transfer' => __('Bank Transfer Payment Details', 'ihc'),

		'ihc_order_placed_notification-user' => __('Order placed', 'ihc'),
		'ihc_subscription_activated_notification' => __('Subscription Activated', 'ihc'),
		'ihc_delete_subscription_notification-user' => __('When the Subscription was Deleted', 'ihc'),
		'ihc_cancel_subscription_notification-user' => __('When the Subscription was Canceled', 'ihc'),

		'drip_content-user' => __('When Post become available', 'ihc'),
);

if (isset($_GET['edit_notification']) || isset($_GET['add_notification'])){
	//add/edit

	$notification_id = (isset($_GET['edit_notification'])) ? @$_GET['edit_notification'] : FALSE;
	$meta_arr = ihc_get_notification_metas($notification_id);

	//$meta_arr['message'] = stripslashes( htmlspecialchars_decode( ihc_format_str_like_wp( $meta_arr['message'] ) ) );
$meta_arr['message'] = stripslashes( htmlspecialchars_decode( $meta_arr['message'] )  );
	?>
	<form method="post" action="<?php echo $url.'&tab=notifications';?>">

		<input type="hidden" value="<?php echo wp_create_nonce( 'ihc_admin_notifications_nonce' );?>" name="ihc_admin_notifications_nonce" />
		<?php
			if ($notification_id){
				?>
				<input type="hidden" name="notification_id" value="<?php echo $notification_id;?>" />
				<?php
			} else {
				?>
				<script>
					jQuery(document).ready(function(){
						ihcChangeNotificationTemplate();
					});
				</script>
				<?php
			}
		?>
		<div class="ihc-stuffbox">
			<h3><?php _e('Add new Notification', 'ihc');?></h3>
			<div class="inside">
				<div class="iump-form-line">
					<label class="iump-labels-special"><?php _e('Action:', 'ihc');?></label>
					<select name="notification_type" id="notification_type" class="ump-js-change-notification-type">
						<?php
							foreach ($notification_arr as $k=>$v){
								//Manually set optGroups
								switch($k){
									case 'admin_user_register':
											echo ' <optgroup label="' . __('----------Admin Notifications----------', 'ihc') . '"> </optgroup>';
											echo ' <optgroup label="' . __('Register Process', 'ihc') . '">';
										break;
									case 'register':
													echo ' <optgroup label="' . __('----------Users Notifications----------', 'ihc') . '"> </optgroup>';
													echo ' <optgroup label="Register Process">';
													break;

									case 'email_check':
													echo ' <optgroup label="Double Email Verification">';
													break;
									case 'before_expire':
									case 'admin_before_user_expire_level':
													echo ' <optgroup label="Level Expire">';
													break;
									case 'admin_user_payment':
													echo ' <optgroup label="User Actions">';
													break;
									case 'reset_password_process':
													echo ' <optgroup label="Password">';
													break;
									case 'approve_account':
										echo ' <optgroup label="Admin Actions">';
										break;
									case 'payment':
										echo ' <optgroup label="User Actions">';
										break;
									case 'drip_content-user':
										echo ' <optgroup label="Drip Content">';
										break;
								}
								?>
								<option value="<?php echo $k;?>" <?php if ($meta_arr['notification_type']==$k) echo 'selected';?>><?php echo $v;?></option>
								<?php
								switch($k){
									case 'ihc_new_subscription_assign_notification-admin':
									case 'review_request':
									case 'email_check_success':
									case 'expire':
									case 'admin_user_expire_level':
									case 'change_password':
									case 'delete_account':
									case 'admin_user_profile_update':
									case 'ihc_cancel_subscription_notification-user':
									case 'drip_content-user':
									//case 'bank_transfer':
										echo ' </optgroup>';
										break;
								}
							}
							do_action( 'ihc_admin_notification_type_select_field', $meta_arr['notification_type'] );
						?>
					</select>
				</div>
				<div class="iump-form-line">
					<label class="iump-labels-special"><?php _e('Level:', 'ihc');?></label>

					<select name="level_id">
						<option value="-1" <?php if ($meta_arr['level_id']==-1) echo 'selected';?>><?php _e( 'All', 'ihc' );?></option>
						<?php
						$levels = get_option('ihc_levels');
						if ($levels && count($levels)){
							foreach ($levels as $k=>$v){
								?>
									<option value="<?php echo $k;?>" <?php if ($meta_arr['level_id']==$k) echo 'selected';?>><?php echo $v['name'];?></option>
								<?php
							}
						}
						?>
					</select>
					<div style="color: #999;font-size: 10px; font-style: italic;"><?php
						echo __('Available only for:', 'ihc')
							. ', ' . $notification_arr['register']
							. ', ' . $notification_arr['review_request']
							. ', ' . $notification_arr['before_expire']
							. ', ' . $notification_arr['expire']
							. ', ' . $notification_arr['payment']
							. ', ' . $notification_arr['bank_transfer']
							. ', ' . $notification_arr['admin_user_register']
							. ', ' . $notification_arr['admin_user_expire_level']
							. ', ' . $notification_arr['admin_before_user_expire_level']
							. ', ' . $notification_arr['admin_user_payment']
							. '.';
					;?></div>
				</div>
				<div class="iump-form-line">
					<label class="iump-labels-special"><?php _e('Subject:', 'ihc');?></label>
					<input type="text" name="subject" value="<?php echo $meta_arr['subject'];?>" style="width: 450px;" id="notification_subject" />
				</div>
				<div class="iump-form-line" style="padding: 10px 0px 0px 5px;">
					<label class="iump-labels-special"><?php _e('Message:', 'ihc');?></label>
				</div>
				<div style="padding-left: 5px; width: 70%;display:inline-block;">
					<?php wp_editor( $meta_arr['message'], 'ihc_message', array('textarea_name'=>'message', 'quicktags'=>TRUE) );?>
				</div>
				<div style="width: 25%; display: inline-block; vertical-align: top;margin-left: 10px; color: color: rgba(125,138,157,1.0);">
						<?php	$constants = ihcNotificationConstants( $meta_arr['notification_type'] );?>
						<div class="ump-js-list-constants">
						<?php foreach ($constants as $k=>$v):?>
								<div><?php echo $k;?></div>
						<?php endforeach;?>
						</div>

						<?php
						$extra_constants = ihc_get_custom_constant_fields();
						echo "<h4>".__('Custom Fields constants', 'ihc')."</h4>";
						foreach ($extra_constants as $k=>$v){
							?>
							<div><?php echo $k;?></div>
							<?php
						}
					?>
				</div>

				<div class="ihc-clear"></div>
				<div style="margin-top: 15px;">
					<input type="submit" value="<?php if ($notification_id){_e('Update', 'ihc');} else{_e('Add New', 'ihc');}?>" name="ihc_save" class="button button-primary button-large">
				</div>
			</div>
		</div>
				<!-- PUSHOVER -->
				<?php if (ihc_is_magic_feat_active('pushover')):?>
				<div class="ihc-stuffbox ihc-stuffbox-magic-feat">
					<h3><?php _e('Pushover Notification', 'ihc');?></h3>
					<div class="inside">
						<div class="iump-form-line">
							<span class="iump-labels-special"><?php _e('Send Pushover Notification', 'ihc');?></span>
							<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
								<?php $checked = (empty($meta_arr['pushover_status'])) ? '' : 'checked';?>
								<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#pushover_status');" <?php echo $checked;?> />
								<div class="switch" style="display:inline-block;"></div>
							</label>
							<input type="hidden" name="pushover_status" value="<?php echo @$meta_arr['pushover_status'];?>" id="pushover_status" />
						</div>

						<div class="iump-form-line" style="padding: 10px 0px 0px 5px; max-width:600px;">
							<label class="iump-labels-special"><?php _e('Pushover Message:', 'ihc');?></label>
							<textarea name="pushover_message" style="width: 90%; height: 100px;" onBlur="ihcCheckFieldLimit(1024, this);"><?php echo stripslashes(@$meta_arr['pushover_message']);?></textarea>
							<div style="color: #777; font-weight:bold;font-size: 11px; font-style: italic;"><?php _e('Only Plain Text and up to ', 'ihc');?><span style="color:#000;">1024</span><?php _e(' characters are available!', 'ihc');?></div>
						</div>
						<div style="margin-top: 15px;">
							<input type="submit" value="<?php if ($notification_id){_e('Update', 'ihc');} else{_e('Add New', 'ihc');}?>" name="ihc_save" class="button button-primary button-large">
						</div>
					</div>
				</div>
				<?php else :?>
					<input type="hidden" name="pushover_message" value=""/>
					<input type="hidden" name="pushover_status" value=""/>
				<?php endif;?>
				<!-- PUSHOVER -->


	</form>

<script>
		jQuery( '.ump-js-change-notification-type' ).on( 'change', function( e ){
			ihcChangeNotificationTemplate();
			ihcNotificationLevelOnlyFor();
			jQuery( '.ump-js-list-constants' ).html('');
			jQuery.ajax({
					type : "post",
					url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
					data : {
										 action: "ihc_update_list_notification_constants",
										 notificationType: jQuery(e.target).val(),
								 },
					success: function (data) {
							jQuery( '.ump-js-list-constants' ).html( data );
					}
		 });

		});
</script>
<?php
} else {
	//listing
	$notification_arr = apply_filters( 'ihc_admin_list_notifications_types', $notification_arr );
	if (isset($_POST['ihc_save']) && !empty($_POST['ihc_admin_notifications_nonce']) && wp_verify_nonce( $_POST['ihc_admin_notifications_nonce'], 'ihc_admin_notifications_nonce' ) ){
		ihc_save_notification_metas($_POST);
	} else if (isset($_POST['delete_notification_by_id']) && !empty($_POST['ihc_admin_notifications_nonce']) && wp_verify_nonce( $_POST['ihc_admin_notifications_nonce'], 'ihc_admin_notifications_nonce' ) ){
		ihc_delete_notification($_POST['delete_notification_by_id']);
	}
	$data = ihc_get_all_notification_available();
	$exclude = apply_filters( 'ihc_admin_remove_notification_from_listing_by_type', [] );
		?>
		<div id="col-right" style="vertical-align:top;width: 100%;">
		<div class="iump-page-title">Ultimate Membership Pro -
							<span class="second-text">
								<?php _e('Notifications', 'ihc');?>
							</span>
						</div>
			<a href="<?php echo $url.'&tab=notifications&add_notification=true';?>" class="indeed-add-new-like-wp"><i class="fa-ihc fa-add-ihc"></i><?php _e('Add New Notification', 'ihc');?></a>
			<span class="ihc-top-message"><?php _e('...create your notification Templates!', 'ihc');?></span>
			<a href="javascript:void(0)" title="<?php _e('Let you know if your website is able to send emails independently of UMP settings. A test email should be received on Admin email address.', 'ihc');?>" class="button button-primary button-large ihc-remove-group-button" style="display:inline-block; float:right;margin-right:20px;" onClick="ihcCheckEmailServer();"><?php _e('Check SMTP Mail Server', 'ihc');?></a>
			<div class="ihc-clear"></div>
			<?php
			if ($data){
			?>
				<form id="delete_notification" method="post" action="">
						<input type="hidden" value="<?php echo wp_create_nonce( 'ihc_admin_notifications_nonce' );?>" name="ihc_admin_notifications_nonce" />
						<input type="hidden" value="" id="delete_notification_by_id" name="delete_notification_by_id"/>
				</form>
				<div class="iump-rsp-table">
				<div class="ihc-sortable-table-wrapp" style="margin: 20px 20px 20px 0px;" >
					<table class="wp-list-table widefat fixed tags ihc-admin-tables" id="ihc-levels-table">
						<thead>
							<tr>
								<th class="manage-column"><?php _e('Subject', 'ihc');?></th>
								<th class="manage-column"><?php _e('Action', 'ihc');?></th>
								<th class="manage-column"><?php _e('Goes to', 'ihc');?></th>
								<th class="manage-column ihc-text-center"><?php _e('Target Levels', 'ihc');?></th>
								<?php if (ihc_is_magic_feat_active('pushover')):?>
									<th class="manage-column ihc-text-center"><?php _e('Mobile Notification', 'ihc');?></th>
								<?php endif;?>
							</tr>
						</thead>

						<tfoot>
							<tr>
								<th class="manage-column"><?php _e('Subject', 'ihc');?></th>
								<th class="manage-column"><?php _e('Action', 'ihc');?></th>
								<th class="manage-column"><?php _e('Goes to', 'ihc');?></th>
								<th class="manage-column ihc-text-center"><?php _e('Target Levels', 'ihc');?></th>
								<?php if (ihc_is_magic_feat_active('pushover')):?>
									<th class="manage-column ihc-text-center"><?php _e('Mobile Notification', 'ihc');?></th>
								<?php endif;?>
							</tr>
						</tfoot>

						<tbody class="ui-sortable">
							<?php
								$admin_actions = array(
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
								foreach ($data as $item){
									if ( $exclude && in_array( $item->notification_type, $exclude ) ) { continue; }
								?>
								<tr onmouseover="ihcDhSelector('#notify_tr_<?php echo $item->id;?>', 1);" onmouseout="ihcDhSelector('#notify_tr_<?php echo $item->id;?>', 0);">
									<td><?php
										if (strlen($item->subject)>100){
											echo substr($item->subject, 0, 100) . ' ...';
										} else {
											echo $item->subject;
										}

										?>
										<div class ="ihc-buttons-rsp" style="visibility: hidden;" id="notify_tr_<?php echo $item->id;?>">
											<a class ="iump-btns" href="<?php echo $url.'&tab=notifications&edit_notification='.$item->id;?>"><?php _e('Edit', 'ihc');?></a> |
											<span class ="iump-btns" onClick="jQuery('#delete_notification_by_id').val(<?php echo $item->id;?>); jQuery('#delete_notification').submit();" style="color: red;cursor: pointer;"><?php _e('Delete', 'ihc');?></span>
										</div>
									</td>
									<td class="ihc-highlighted-label"><?php
										echo isset( $notification_arr[$item->notification_type] ) ? $notification_arr[$item->notification_type] : '';
									?></td>
									<td><?php
										if (in_array($item->notification_type, $admin_actions)){
											echo 'Admin';
										} else {
											echo 'User';
										}
									?></td>
									<td class="ihc-text-center"><?php
										if ($item->level_id==-1){
											echo 'All';
										} else {
											$level_data = ihc_get_level_by_id($item->level_id);
											echo $level_data['name'];
										}
									?></td>
									<?php if (ihc_is_magic_feat_active('pushover')):?>
										<td class="ihc-text-center">
											<?php if (!empty($item->pushover_status)):?>
												<i class="fa-ihc fa-pushover-on-ihc"></i>
											<?php endif;?>
										</td>
									<?php endif;?>
								</tr>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
				<?php
				}
				?>

		</div>
<script>

	jQuery(document).ready(function(){
		ihcNotificationLevelOnlyFor();
	});

</script>
<?php
}
?>
</div>
<?php
