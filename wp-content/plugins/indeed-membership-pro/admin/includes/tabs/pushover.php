<?php
if ( !empty( $_POST['ihc_save'] ) && isset( $_POST['ihc_pushover_enabled'] ) ){
		if ( empty( $_POST['ihc_pushover_enabled'] ) ){
				\Ihc_Db::deactivateApTab( 'pushover' );
		} else {
				\Ihc_Db::activateApTab( 'pushover' );
		}
}
ihc_save_update_metas('pushover');//save update metas
$data['metas'] = ihc_return_meta_arr('pushover');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Pushover Notifications', 'ihc');?></h3>
		<div class="inside">

		  <div class="iump-form-line">
				<h2><?php _e('Activate/Hold Pushover Notifications', 'ihc');?></h2>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_pushover_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_pushover_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_pushover_enabled" value="<?php echo $data['metas']['ihc_pushover_enabled'];?>" id="ihc_pushover_enabled" />
		  </div>
		  <div class="iump-form-line">
			<div class="row" style="margin-left:0px;">
				<div class="col-xs-4" style="margin-bottom: 10px;">
			   		<div class="input-group" style="margin:0px 0 15px 0;">
						<span class="input-group-addon" id="basic-addon1"><?php _e('App Token', 'ihc');?></span>
						<input type="text" name="ihc_pushover_app_token" class="form-control" value="<?php echo $data['metas']['ihc_pushover_app_token'];?>" />
			   		</div>
				</div>
			</div>

			<div class="row" style="margin-left:0px;">
				<div class="col-xs-4" style="margin-bottom: 10px;margin:0px 0 15px 0;">
			   		<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><?php _e('Admin Personal User Token', 'ihc');?></span>
						<input type="text" name="ihc_pushover_admin_token" class="form-control" value="<?php echo $data['metas']['ihc_pushover_admin_token'];?>" />
			   		</div>
					<div style="font-size: 11px; color: #333; padding-left: 10px;">
						<?php _e("Use this to get 'Admin Notifications' on Your own device.", 'ihc');?>
					</div>
				</div>
			</div>

			<div class="row" style="margin-left:0px;">
				<div class="col-xs-4" style="margin-bottom: 10px;">
			   		<div class="input-group" style="margin:0px 0 15px 0;">
						<span class="input-group-addon" id="basic-addon1"><?php _e('URL', 'ihc');?></span>
						<input type="text" name="ihc_pushover_url" class="form-control" value="<?php echo $data['metas']['ihc_pushover_url'];?>" />
			   		</div>
				</div>
			</div>

			<div class="row" style="margin-left:0px;">
				<div class="col-xs-4" style="margin-bottom: 10px;">
			   		<div class="input-group" style="margin:0px 0 15px 0;">
						<span class="input-group-addon" id="basic-addon1"><?php _e('URL Title', 'ihc');?></span>
						<input type="text" name="ihc_pushover_url_title" class="form-control" value="<?php echo $data['metas']['ihc_pushover_url_title'];?>" />
			   		</div>
				</div>
			</div>
			<div class="row" style="margin-left:0px;">
				<div style="font-size: 11px; color: #333; padding-left: 10px;">
					<ul class="ihc-info-list">
						<li><?php echo __("1. Go to ", 'ihc') . '<a href="https://pushover.net/" target="_blank">https://pushover.net/</a>' . __(" and login with your credentials or sign up for a new account.", 'ihc');?></li>
						<li><?php echo __("2. After that go to ", 'ihc') . '<a href="https://pushover.net/apps/build" target="_blank">https://pushover.net/apps/build</a>' .  __(" and create a new App.", 'ihc');?></li>
						<li><?php _e("3. Set the type of App to 'Application'.", 'ihc');?></li>
						<li><?php _e("4. Copy and paste API Token/Key.", 'ihc');?></li>
					</ul>
				</div>
			</div>
		 </div>
		 <div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>
	   </div>
	</div>
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Notification Sound', 'ihc');?></h3>
		<div class="inside">
		  <div class="iump-form-line">
				<h4><?php _e('Default Sound for mobile notification', 'ihc');?></h4>
				<select name="ihc_pushover_sound">
					<?php
						$possible = array(
											'bike' => __('Bike', 'ihc'),
											'bugle' => __('Bugle', 'ihc'),
											'cash_register' => __('Cash Register', 'ihc'),
											'classical' => __('Classical', 'ihc'),
											'cosmic' => __('Cosmic', 'ihc'),
											'falling' => __('Falling', 'ihc'),
											'gamelan' => __('Gamelan', 'ihc'),
											'incoming' => __('Incoming', 'ihc'),
											'intermission' => __('Intermission', 'ihc'),
											'magic' => __('Magic', 'ihc'),
											'mechanical' => __('Mechanical', 'ihc'),
											'piano_bar' => __('Piano Bar', 'ihc'),
											'siren' => __('Siren', 'ihc'),
											'space_alarm' => __('Space Alarm', 'ihc'),
											'tug_boat' => __('Tug Boat', 'ihc'),
						);
					?>
					<?php foreach ($possible as $k=>$v):?>
						<?php $selected = ($data['metas']['ihc_pushover_sound']==$k) ? 'selected' : '';?>
						<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
					<?php endforeach;?>
 				</select>
		</div>



			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

</form>
