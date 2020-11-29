<?php
if (!empty($_REQUEST['ihc_login_security_black_list'])){
	$_REQUEST['ihc_login_security_black_list'] = preg_replace('/\s+/', '', $_REQUEST['ihc_login_security_black_list']);
}
ihc_save_update_metas('login_security');//save update metas
$data['metas'] = ihc_return_meta_arr('login_security');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Security Login', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold Security Login', 'ihc');?></h2>
				<p><?php _e('Fight against brute-force attacks by blocking login for the IP after it reaches the maximum allowed retries.', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_login_security_on']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_login_security_on');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_login_security_on" value="<?php echo $data['metas']['ihc_login_security_on'];?>" id="ihc_login_security_on" />
			</div>

			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Allowed Retries', 'ihc');?></label>
				<div class="row" style="margin-left:0px;">
				<div class="col-xs-3">
					<div class="input-group">
						<input type="number" class="form-control"  min="0" value="<?php echo $data['metas']['ihc_login_security_allowed_retries'];?>" name="ihc_login_security_allowed_retries" />
						<div class="input-group-addon"><?php _e('Retries', 'ihc');?></div>
					</div>
				</div>
				</div>
			</div>

			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Locked Time', 'ihc');?></label>
				<div class="row" style="margin-left:0px;">
				<div class="col-xs-3">
					<div class="input-group">
						<input type="number" class="form-control"  min="0" value="<?php echo $data['metas']['ihc_login_security_lockout_time'];?>" name="ihc_login_security_lockout_time" />
						<div class="input-group-addon"><?php _e('Minutes', 'ihc');?></div>
					</div>
				</div>
				</div>

			</div>

			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Maximum number of Lockouts', 'ihc');?></label>
				<div class="row" style="margin-left:0px;">
				<div class="col-xs-3">
					<div class="input-group">
						<input type="number" class="form-control"  min="0" value="<?php echo $data['metas']['ihc_login_security_max_lockouts'];?>" name="ihc_login_security_max_lockouts" />
						<div class="input-group-addon"><?php _e('Lockouts', 'ihc');?></div>
					</div>
				</div>
				</div>
			</div>

			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Extended Locked Time', 'ihc');?></label>
				<div class="row" style="margin-left:0px;">
				<div class="col-xs-3">
					<div class="input-group">
						<input type="number" class="form-control"  min="0" value="<?php echo $data['metas']['ihc_login_security_extended_lockout_time'];?>" name="ihc_login_security_extended_lockout_time"/>
						<div class="input-group-addon"><?php _e('Hours', 'ihc');?></div>
					</div>
				</div>
				</div>
			</div>

			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Reset Retries after', 'ihc');?></label>
				<div class="row" style="margin-left:0px;">
				<div class="col-xs-3">
					<div class="input-group">
						<input type="number" class="form-control"  min="0" value="<?php echo $data['metas']['ihc_login_security_reset_retries'];?>" name="ihc_login_security_reset_retries" />
						<div class="input-group-addon"><?php _e('Hours', 'ihc');?></div>
					</div>
				</div>
				</div>
			</div>

			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Notify Admin after', 'ihc');?></label>
				<div class="row" style="margin-left:0px;">
				<div class="col-xs-3">
					<div class="input-group">
						<input type="number" class="form-control"  min="0"  value="<?php echo $data['metas']['ihc_login_security_notify_admin'];?>" name="ihc_login_security_notify_admin"  />
						<div class="input-group-addon"><?php _e('retries', 'ihc');?></div>
					</div>
				</div>
				</div>
			</div>

			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Black IP list', 'ihc');?></label>
				<textarea name="ihc_login_security_black_list" style="width: 40%; height: 100px;"><?php echo $data['metas']['ihc_login_security_black_list'];?></textarea>
				<div class="ihc-general-options-link-pages"><?php _e('Write values separated by comma. Spaces are not allowed.', 'ihc');?></div>
			</div>


			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Fail Login Attempt Message', 'ihc');?></label>
				<textarea name="ihc_login_security_lockout_attempt_message" style="width: 40%; height: 100px;"><?php echo stripslashes($data['metas']['ihc_login_security_lockout_attempt_message']);?></textarea>
				<div class="ihc-general-options-link-pages"><?php _e('Where {number} is the remaining numbers of retries.', 'ihc');?></div>
			</div>

			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Locked Message', 'ihc');?></label>
				<textarea name="ihc_login_security_lockout_message" style="width: 40%; height: 100px;"><?php echo stripslashes($data['metas']['ihc_login_security_lockout_message']);?></textarea>
			</div>

			<div class="iump-form-line">
				<label class="iump-labels-special"><?php _e('Extended Locked Message', 'ihc');?></label>
				<textarea name="ihc_login_security_extended_lockout_message" style="width: 40%; height: 100px;"><?php echo stripslashes($data['metas']['ihc_login_security_extended_lockout_message']);?></textarea>
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

</form>
