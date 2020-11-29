<?php

ihc_save_update_metas('infusionSoft');//save update metas
$data['metas'] = ihc_return_meta_arr('infusionSoft');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

$levels = get_option('ihc_levels');
$object = new \Indeed\Ihc\Services\InfusionSoft();
$tags = $object->getContactGroups();


?>
<form action="" method="post">

	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Ultimate Membership Pro - InfusionSoft', 'ihc');?></h3>
		<div class="inside">
		<div class="iump-form-line">
				<h2><?php _e('Activate/Hold InfusionSoft', 'ihc');?></h2>
                <p><?php _e('Synchronize your InfusionSoft contacts based on Tags. For each user status or Level a Tag is associated. ', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_infusionSoft_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_infusionSoft_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_infusionSoft_enabled" value="<?php echo $data['metas']['ihc_infusionSoft_enabled'];?>" id="ihc_infusionSoft_enabled" />
			</div>
      <div class="iump-form-line">
      <h4><?php _e('Step 1: Set InfusionSoft credentials', 'ihc');?></h4>
      </div>
      <div class="iump-form-line">
      	<div class="input-group" style="margin:0px 0 15px 0;">
       	<span class="input-group-addon" ><?php _e('Account ID', 'ihc');?></span>
        <input type="text" name="ihc_infusionSoft_id" class="form-control"  style="width: 50%;" value="<?php echo $data['metas']['ihc_infusionSoft_id'];?>" id="ihc_infusionSoft_id" />
        </div>
      </div>

      <div class="iump-form-line">
      	<div class="input-group" style="margin:0px 0 15px 0;">
        <span class="input-group-addon" ><?php _e('Api Key', 'ihc');?></span>
        <input type="text" name="ihc_infusionSoft_api_key" class="form-control" style="width: 50%;" value="<?php echo $data['metas']['ihc_infusionSoft_api_key'];?>" id="ihc_infusionSoft_api_key" />
        </div>
      </div>
      <div class="iump-form-line">
      <h4><?php _e('Step 2: Create Tags for users into your InfusionSoft account', 'ihc');?></h4>

      </div>
			<div class="ihc-submit-form" style="margin-top: 20px; margin-bottom:40px;">
				<h4><?php _e('Step 3: Submit credentials with "Save Changes" button in order to syncronize UMP with Infusionsoft settings.', 'ihc');?></h4>
                <input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />

			</div>
		</div>
	</div>


	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Step 4: Assign UMP levels to InfusionSoft Tags', 'ihc');?></h3>
		<div class="inside">
				<?php if ( $tags ):?>
						<?php foreach ( $levels as $lid => $levelData ):?>
								<div class="iump-form-line">
									<label style="width: 10%"><?php echo $levelData['name'];?></label>
									<select name="ihc_infusionSoft_levels_groups[<?php echo $lid;?>]">
											<?php foreach ( $tags as $id => $label ):?>
													<?php $selected = (isset($data['metas']['ihc_infusionSoft_levels_groups'][$lid]) && $data['metas']['ihc_infusionSoft_levels_groups'][$lid]==$id) ? 'selected' : '';?>
													<option value="<?php echo $id;?>" <?php echo $selected;?> ><?php echo $label;?></option>
											<?php endforeach;?>
									</select>
								</div>
						<?php endforeach;?>
					<div class="ihc-submit-form" style="margin-top: 20px;">
							<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
						</div>
				<?php else :?>
						<?php _e( 'No tags, of you are not connected to your InfusionSoft account.', 'ihc' );?>
				<?php endif;?>
		</div>
	</div>
</form>

<?php
