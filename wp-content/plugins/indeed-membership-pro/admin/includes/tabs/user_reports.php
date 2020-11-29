<?php
if (!empty($_GET['do_cleanup_logs'])){
	$older_then = indeed_get_unixtimestamp_with_timezone() - $_GET['older_then'] * 24 * 60 * 60;
	Ihc_Db::delete_logs('user_logs', $older_then);
}
ihc_save_update_metas('user_reports');//save update metas
$data['metas'] = ihc_return_meta_arr('user_reports');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('User Reports', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold User Reports', 'ihc');?></h2>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_user_reports_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_user_reports_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_user_reports_enabled" value="<?php echo $data['metas']['ihc_user_reports_enabled'];?>" id="ihc_user_reports_enabled" />
			</div>

			<?php $we_have_logs = Ihc_User_Logs::get_count_logs('user_logs');?>
			<?php if ($we_have_logs):?>
				<div class="iump-form-line">
					<?php _e('Clean Up Users Reports older then:', 'ihc');?>
					<select id="older_then_select">
						<option value="">...</option>
						<option value="1"><?php _e('One Day', 'ihc');?></option>
						<option value="7"><?php _e('One Week', 'ihc');?></option>
						<option value="30"><?php _e('One Month', 'ihc');?></option>
					</select>
					<div class="button button-primary button-large" onClick="ihcDoCleanUpLogs('<?php echo admin_url('admin.php?page=ihc_manage&tab=user_reports');?>');"><?php _e('Clean Up', 'ihc');?></div>
				</div>
				<div class="iump-form-line">
					<a href="<?php echo admin_url('admin.php?page=ihc_manage&tab=view_user_logs&type=user_logs');?>" target="_blank"><?php _e('View All User Reports', 'ihc');?></a>
				</div>
			<?php endif;?>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>



</form>
