<?php
$levels = get_option('ihc_levels');
$levels = array('reg' => array('label' => __('Users with no active level', 'ihc'))) + $levels;
//ihc_save_update_metas('level_restrict_payment');//save update metas
if (!empty($_POST['ihc_save'])){
	update_option('ihc_workflow_restrictions_timelimit', $_POST['ihc_workflow_restrictions_timelimit']);
	update_option('ihc_workflow_restrictions_on', $_POST['ihc_workflow_restrictions_on']);
	if (isset($_POST['ihc_workflow_restrictions_post_views'])){
		$ihc_workflow_restrictions_post_views = array();
		$ihc_workflow_restrictions_post_views['unreg'] = (isset($_POST['ihc_workflow_restrictions_post_views']['unreg'])) ? $_POST['ihc_workflow_restrictions_post_views']['unreg'] : '';

		foreach ($levels as $id=>$leveldata){
			$ihc_workflow_restrictions_post_views[$id] = (isset($_POST['ihc_workflow_restrictions_post_views'][$id])) ? $_POST['ihc_workflow_restrictions_post_views'][$id] : '';
		}
		update_option('ihc_workflow_restrictions_post_views', $ihc_workflow_restrictions_post_views);
	}
	if (isset($_POST['ihc_workflow_restrictions_posts_created'])){
		$ihc_workflow_restrictions_posts_created = array();
		foreach ($levels as $id=>$leveldata){
			$ihc_workflow_restrictions_posts_created[$id] = (isset($_POST['ihc_workflow_restrictions_posts_created'][$id])) ? $_POST['ihc_workflow_restrictions_posts_created'][$id] : '';
		}
		update_option('ihc_workflow_restrictions_posts_created', $ihc_workflow_restrictions_posts_created);
	}
	if (isset($_POST['ihc_workflow_restrictions_comments_created'])){
		$ihc_workflow_restrictions_comments_created = array();
		foreach ($levels as $id=>$leveldata){
			$ihc_workflow_restrictions_comments_created[$id] = (isset($_POST['ihc_workflow_restrictions_comments_created'][$id])) ? $_POST['ihc_workflow_restrictions_comments_created'][$id] : '';
		}
		update_option('ihc_workflow_restrictions_comments_created', $ihc_workflow_restrictions_comments_created);
	}
}
$data['metas'] = ihc_return_meta_arr('workflow_restrictions');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('WP Workflow Restrictions', 'ihc');?></h3>
		<div class="inside">
			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold this WP WorkFlow Restrictions', 'ihc');?></h2>
				<p><?php _e('You can restrict how many posts can be viewed, released and how many comments can be submitted for each level / subscription.', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_workflow_restrictions_on']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_workflow_restrictions_on');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_workflow_restrictions_on" value="<?php echo $data['metas']['ihc_workflow_restrictions_on'];?>" id="ihc_workflow_restrictions_on" />
			<p><?php _e('If a user has multiple levels assigned, it will be take in consideration the level with the highest number of views / submissions.', 'ihc');?></p>
			</div>

			<div class="iump-form-line">
				<h4><?php _e('Time Limit', 'ihc');?></h4>
				<div class="row" style="margin-left:0px;">
					<div class="col-xs-5">
						<div class="input-group" style="margin:0px 0 15px 0;">
							<span class="input-group-addon" id="basic-addon1"><?php _e('Days', 'ihc');?></span>
							<input type="number" min="0" class="form-control" value="<?php echo $data['metas']['ihc_workflow_restrictions_timelimit'];?>" name="ihc_workflow_restrictions_timelimit" />
						</div>
					</div>
				</div>
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

	<?php if ($levels):?>
		<div class="ihc-stuffbox">
			<h3 class="ihc-h3"><?php _e('Restrict Posts Views', 'ihc');?></h3>
			<div class="inside">
				<h4><?php _e('Levels Limits', 'ihc');?></h4>
				<p><?php _e('Set for each level how many posts can be viewed by a user with that level. Leave blank for unlimited views.', 'ihc');?></p>
				<div class="iump-form-line">
						<div class="row" style="margin-left:0px;">
							<div class="col-xs-5">
								<?php $value = (isset($data['metas']['ihc_workflow_restrictions_post_views']['unreg'])) ? $data['metas']['ihc_workflow_restrictions_post_views']['unreg'] : '';?>
								<div class="input-group" style="margin:0px 0 15px 0;">
									<span class="input-group-addon" id="basic-addon1"><?php _e('Unregistered Users', 'ihc');?></span>
									<input type="number" min="1" class="form-control" value="<?php echo $value;?>" name="ihc_workflow_restrictions_post_views[unreg]" />
								</div>
							</div>
						</div>
					<?php foreach ($levels as $id=>$level):?>
						<?php $value = (isset($data['metas']['ihc_workflow_restrictions_post_views'][$id])) ? $data['metas']['ihc_workflow_restrictions_post_views'][$id] : '';?>
						<div class="row" style="margin-left:0px;">
							<div class="col-xs-5">
								<div class="input-group" style="margin:0px 0 15px 0;">
									<span class="input-group-addon" id="basic-addon1"><?php echo $level['label'];?></span>

									<input type="number" min="0" class="form-control" value="<?php echo $value;?>" name="ihc_workflow_restrictions_post_views[<?php echo $id;?>]" />
								</div>
							</div>
						</div>
				  <?php endforeach;?>
				</div>
				<div class="ihc-submit-form" style="margin-top: 20px;">
					<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
				</div>
			</div>
		</div>
		<div class="ihc-stuffbox">
			<h3 class="ihc-h3"><?php _e('Restrict Posts Created', 'ihc');?></h3>
			<div class="inside">
				<h4><?php _e('Levels Limits', 'ihc');?></h4>
				<p><?php _e('Set for each level how many WP posts can be submitted by a user with that level. Leave blank for unlimited submissions.', 'ihc');?></p>
				<p style="font-weight:bold;"><?php _e('The Submitted Posts that are not allowed to become Public because of this restriction will be set with a Pending Review status', 'ihc');?></p>

				<div class="iump-form-line">
					<?php foreach ($levels as $id=>$level):?>
						<?php $value = (isset($data['metas']['ihc_workflow_restrictions_posts_created'][$id])) ? $data['metas']['ihc_workflow_restrictions_posts_created'][$id] : '';?>
						<div class="row" style="margin-left:0px;">
						<div class="col-xs-5">
							<div class="input-group" style="margin:0px 0 15px 0;">
								<span class="input-group-addon" id="basic-addon1"><?php echo $level['label'];?></span>

								<input type="number" min="0" class="form-control" value="<?php echo $value;?>" name="ihc_workflow_restrictions_posts_created[<?php echo $id;?>]" />
							</div>
						</div>
						</div>
					<?php endforeach;?>
				</div>
				<div class="ihc-submit-form" style="margin-top: 20px;">
					<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
				</div>
			</div>
		</div>
		<div class="ihc-stuffbox">
			<h3 class="ihc-h3"><?php _e('Restrict Comments Created', 'ihc');?></h3>
			<div class="inside">
				<h4><?php _e('Levels Limits', 'ihc');?></h4>
				<p><?php _e('Set for each level how many WP comments can be submitted by a user with that level. Leave blank for unlimited comments.', 'ihc');?></p>

				<div class="iump-form-line">
					<?php foreach ($levels as $id=>$level):?>
						<?php $value = (isset($data['metas']['ihc_workflow_restrictions_comments_created'][$id])) ? $data['metas']['ihc_workflow_restrictions_comments_created'][$id] : '';?>
						<div class="row" style="margin-left:0px;">
						<div class="col-xs-5">
							<div class="input-group" style="margin:0px 0 15px 0;">
								<span class="input-group-addon" id="basic-addon1"><?php echo $level['label'];?></span>

								<input type="number" min="0" class="form-control" value="<?php echo $value;?>" name="ihc_workflow_restrictions_comments_created[<?php echo $id;?>]" />
							</div>
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
