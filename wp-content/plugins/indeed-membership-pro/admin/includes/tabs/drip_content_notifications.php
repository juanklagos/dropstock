<?php
if (!empty($_GET['do_cleanup_logs'])){
	$older_then = indeed_get_unixtimestamp_with_timezone() - $_GET['older_then'] * 24 * 60 * 60;
	Ihc_Db::delete_logs('drip_content_notifications', $older_then);
}
ihc_save_update_metas('drip_content_notifications');//save update metas
$data['metas'] = ihc_return_meta_arr('drip_content_notifications');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Drip Content Notifications', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold Drip Content Notifications', 'ihc');?></h2>
                <p><?php _e('Alert members when a new post is released by "Drip Content" strategy.', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_drip_content_notifications_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_drip_content_notifications_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_drip_content_notifications_enabled" value="<?php echo $data['metas']['ihc_drip_content_notifications_enabled'];?>" id="ihc_drip_content_notifications_enabled" />
			</div>

			<div class="iump-form-line">
            	<h2><?php _e('Time between notifications', 'ihc');?></h2>
				<input type="number" min="0" style="width: 60px !important; min-width: 60px !important;" name="ihc_drip_content_notifications_sleep" value="<?php echo $data['metas']['ihc_drip_content_notifications_sleep'];?>" /> <?php _e('Seconds', 'ihc');?>
			</div>

			<div class="iump-form-line">
            	<h2><?php _e('Proceed the Notification script manually', 'ihc');?></h2>
				<span onClick="ihcRunAjaxProcess('drip_content_notifications');" style="margin-left: 10px;" class="button button-primary button-large" target="_blank"><?php _e('Run Now', 'ihc');?></span>
				<div style="display: inline-block; vertical-align: top;"><span class="spinner" id="ihc_ajax_run_process_spinner"></span></div>
			</div>

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold Drip notificaiton Logs', 'ihc');?></h2>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_drip_content_notifications_logs_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_drip_content_notifications_logs_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_drip_content_notifications_logs_enabled" value="<?php echo $data['metas']['ihc_drip_content_notifications_logs_enabled'];?>" id="ihc_drip_content_notifications_logs_enabled" />
			</div>

			<?php $we_have_logs = Ihc_User_Logs::get_count_logs('drip_content_notifications');?>
			<?php if ($we_have_logs):?>
				<div class="iump-form-line">
					<?php _e('Clean Up Logs older than:', 'ihc');?>
					<select id="older_then_select">
						<option value="">...</option>
						<option value="1"><?php _e('One Day', 'ihc');?></option>
						<option value="7"><?php _e('One Week', 'ihc');?></option>
						<option value="30"><?php _e('One Month', 'ihc');?></option>
					</select>
					<div class="button button-primary button-large" onClick="ihcDoCleanUpLogs('<?php echo admin_url('admin.php?page=ihc_manage&tab=drip_content_notifications');?>');"><?php _e('Clean Up', 'ihc');?></div>
				</div>
				<div class="iump-form-line">
					<a href="<?php echo admin_url('admin.php?page=ihc_manage&tab=view_drip_content_notifications_logs');?>" target="_blank"><?php _e('View Logs', 'ihc');?></a>
				</div>
			<?php endif;?>


			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>
</form>
