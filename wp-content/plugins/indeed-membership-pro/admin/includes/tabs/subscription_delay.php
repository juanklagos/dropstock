<?php
$levels = get_option('ihc_levels');
//ihc_save_update_metas('level_restrict_payment');//save update metas
if (!empty($_POST['ihc_save'])){
	update_option('ihc_subscription_delay_on', $_POST['ihc_subscription_delay_on']);

	if (isset($_POST['ihc_subscription_delay_time'])){
		$ihc_subscription_delay_time = array();
		foreach ($levels as $id=>$leveldata){
			$ihc_subscription_delay_time[$id] = (isset($_POST['ihc_subscription_delay_time'][$id])) ? $_POST['ihc_subscription_delay_time'][$id] : '';
		}
		update_option('ihc_subscription_delay_time', $ihc_subscription_delay_time);
	}

	if (isset($_POST['ihc_subscription_delay_type'])){
		$ihc_subscription_delay_type = array();
		foreach ($levels as $id=>$leveldata){
			$ihc_subscription_delay_type[$id] = (isset($_POST['ihc_subscription_delay_type'][$id])) ? $_POST['ihc_subscription_delay_type'][$id] : '';
		}
		update_option('ihc_subscription_delay_type', $ihc_subscription_delay_type);
	}

}
$data['metas'] = ihc_return_meta_arr('subscription_delay');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Subscription Delay', 'ihc');?></h3>

		<div class="inside">
			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold Subscription Delay', 'ihc');?></h2>
				<p><?php _e('Each level / subscription will become active after a custom delay time instead of when it was assigned. This option is available only when the level is assigned for the first time and not when user renews the subscription.', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_subscription_delay_on']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_subscription_delay_on');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_subscription_delay_on" value="<?php echo $data['metas']['ihc_subscription_delay_on'];?>" id="ihc_subscription_delay_on" />
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

	<?php if ($levels):?>
		<div class="ihc-stuffbox">
			<h3 class="ihc-h3"><?php _e('Delay Time', 'ihc');?></h3>
			<div class="inside">
				<h4><?php _e('Levels', 'ihc');?></h4>
				<div class="iump-form-line">
					<?php foreach ($levels as $id=>$level):?>
						<?php $value = (isset($data['metas']['ihc_subscription_delay_time'][$id])) ? $data['metas']['ihc_subscription_delay_time'][$id] : '';?>
						<div class="row" style="margin-left:0px;">
						<div class="col-xs-4" style="margin-bottom: 10px;">
						   <div class="input-group" style="margin:0px 0 15px 0;">
							<span class="input-group-addon" id="basic-addon1"><?php echo $level['label'];?></span>
							<input type="number" min="0" class="form-control" value="<?php echo $value;?>" name="ihc_subscription_delay_time[<?php echo $id;?>]" />
						   </div>
						</div>
						<div class="col-xs-3" style="margin-bottom: 10px;">
							<select name="ihc_subscription_delay_type[<?php echo $id;?>]" style="height: 34px; padding: 6px 12px;"><?php
								$possible_values = array('h' => __('Hours', 'ihc'), 'd' => __('Days', 'ihc'));
								foreach ($possible_values as $type=>$label):
									$value = (isset($data['metas']['ihc_subscription_delay_type'][$id])) ? $data['metas']['ihc_subscription_delay_type'][$id] : '';
									$checked = ($value==$type) ? 'selected' : '';
									?>
								<option value="<?php echo $type;?>" <?php echo $checked;?> ><?php echo $label;?></option>
									<?php
								endforeach;
							?></select>
						</div>
					</div>
				  <?php endforeach;?>
				</div>
				<div class="ihc-submit-form" style="margin-top: 20px;">
					<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
				</div>
			</div>
		</div>
	<?php endif;?>
</form>
