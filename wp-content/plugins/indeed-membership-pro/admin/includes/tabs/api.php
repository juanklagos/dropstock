<?php
ihc_save_update_metas('api');//save update metas
if (isset($_POST['ihc_api_actions'])){
	$save = array();
	foreach ($_POST['ihc_api_actions'] as $k=>$v){
		$save[$k] = $v;
	}
	update_option('ihc_api_actions', $save);
}
$data['metas'] = ihc_return_meta_arr('api');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Ultimate Membership Pro - API Gate', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold API Gate', 'ihc');?></h2>
				<p><?php _e('Manage your membership system and access data from it through an API with access based on URL calls.', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_api_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_api_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_api_enabled" value="<?php echo $data['metas']['ihc_api_enabled'];?>" id="ihc_api_enabled" />
			</div>

			<?php
			if (empty($data['metas']['ihc_api_hash'])){
				$data['metas']['ihc_api_hash'] = ihc_generate_random_string(rand(25, 35));
			}
			?>
			<div class="iump-form-line">
				<h2><?php _e('API Secret Hash', 'ihc');?></h2>
				<p><?php _e('Only with the right hash key can a call be provided, otherwise access to the membership system will not be provided.', 'ihc');?></p>
				<input type="text" name="ihc_api_hash" value="<?php echo $data['metas']['ihc_api_hash'];?>" id="ihc_api_hash" />
				<span style="font-size: 11px;color: #fff; padding: 6px 9px;-webkit-border-radius: 3px;box-radius: 3px; background-color: rgba(240, 80, 80, 0.8);cursor: pointer;" onclick="ihcGenerateCode('#ihc_api_hash', <?php echo rand(25, 35);?>);ihcDoUpdateHashField();"><?php _e('Generate Code', 'ihc');?></span>
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>


<?php
$base_link = IHC_URL . 'apigate.php?ihch=';
$actions = array(
					'verify_user_level' => array(
						'label' => __('"Verify User Level" API Call', 'ihc'),
						'return' => __("True if User got the level and it's active. (Boolean Value)", 'ihc'),
						'params' => array('uid' => __('User Id', 'ihc'), 'lid' => __('Level Id', 'ihc'))
					),
					'user_approve' => array(
						'label' => __('"Approve User" API Call', 'ihc'),
						'return' => __("True if user has been approved. (Boolean Value)", 'ihc'),
						'params' => array('uid' => __('User Id', 'ihc')),
					),
					'user_add_level' => array(
						'label' => __('"Add new level for User" API Call', 'ihc'),
						'return' => __("True if the Level was succesfully added to User. (Boolean Value)", 'ihc'),
						'params' => array('uid' => __('User Id', 'ihc'), 'lid' => __('Level Id', 'ihc')),
					),
					'user_get_details' => array(
						'label' => __('"Get all User Data"  API Call', 'ihc'),
						'return' => __("List of all User Metas. (Array)", 'ihc'),
						'params' => array('uid' => __('User Id', 'ihc')),
					),
					'user_activate_level' => array(
						'label' => __('"Activate User Level" API Call', 'ihc'),
						'return' => __("True if the Level was succesfully activated. (Boolean)", 'ihc'),
						'params' => array('uid' => __('User Id', 'ihc'), 'lid' => __('Level Id', 'ihc')),
					),
					'get_user_field_value' => array(
						'label' => __('"Get User Field Value" API Call', 'ihc'),
						'return' => __("The value of required field. (String, Boolean, Integer or Array)", 'ihc'),
						'params' => array('uid' => __('User Id', 'ihc'), 'field' => __('Field Name', 'ihc')),
					),
					'get_user_levels' => array(
						'label' => __('"Get User Levels" API Call', 'ihc'),
						'return' => __("A List of User Levels. (Array)", 'ihc'),
						'params' => array('uid' => __('User Id', 'ihc')),
					),
					'get_user_level_details' => array(
						'label' => __('"Get User Level Details" API Call', 'ihc'),
						'return' => __("Create time, Update time and Expiration time. (Array)", 'ihc'),
						'params' => array('uid' => __('User Id', 'ihc'), 'lid' => __('Level Id', 'ihc')),
					),
					'get_user_posts' => array(
						'label' => __('"Get User Available Posts" API Call', 'ihc'),
						'return' => __("List of Posts that User can see. (Array)", 'ihc'),
						'params' => array('uid' => __('User Id', 'ihc'), 'limit' => __('Limit', 'ihc'), 'order_by' => __('Order By', 'ihc'), 'order' => __('Order', 'ihc'), 'post_types' => __('Post Types', 'ihc') ),
					),
					'search_users' => array(
						'label' => __('"Search User" API Call', 'ihc'),
						'return' => __("List of User Ids. (Array)", 'ihc'),
						'params' => array('term_name' => __('Term Name', 'ihc'), 'term_value' => __('Term Value', 'ihc')),
					),
					'list_levels' => array(
						'label' => __('"List all Levels" API Call', 'ihc'),
						'return' => __("List of Levels. (Array)", 'ihc'),
						'params' => array(),
					),
					'get_level_users' => array(
						'label' => __('"Get Level Users" API Call', 'ihc'),
						'return' => __("List of Users that have a certain Level. (Array)", 'ihc'),
						'params' => array('lid' => __('Level Id', 'ihc')),
					),
					'get_level_details' => array(
						'label' => __('"Get Level details" API Call', 'ihc'),
						'return' => __("List of Users that have a certain Level. (Array)", 'ihc'),
						'params' => array('lid' => __('Level Id', 'ihc')),
					),
					'orders_listing' => array(
						'label' => __('"Listing Orders" API Call', 'ihc'),
						'return' => __("List of Orders. (Array)", 'ihc'),
						'params' => array('limit' => __('Limit', 'ihc'), 'uid' => __('User Id', 'ihc')),
					),
					'order_get_status' => array(
						'label' => __('"Get Order status" API Call', 'ihc'),
						'return' => __("Order status. (String)", 'ihc'),
						'params' => array('order_id' => __('Order Id', 'ihc')),
					),
					'order_get_data' => array(
						'label' => __('"Get Order data" API Call', 'ihc'),
						'return' => __("Order Data. (Array)", 'ihc'),
						'params' => array('order_id' => __('Order Id', 'ihc')),
					),
);
foreach ($actions as $slug=>$array):?>
	<?php
		if (empty($data['metas']['ihc_api_actions'][$slug])){
			$value = 0;
		} else {
			$value = 1;
		}

	?>
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php echo $array['label'];?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php echo __('Activate/Hold ', 'ihc') . $array['label'];?></h2>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($value) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '<?php echo '#ihc_api_actions' . $slug;?>');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_api_actions[<?php echo $slug;?>]" value="<?php echo $value;?>" id="<?php echo 'ihc_api_actions' . $slug;?>" />
			</div>
			<h4 style="margin-left:20px;"><?php _e('API Link', 'ihc');?></h4>
			<div class="ihc-api-link">
			<a href="" target="_blank"><?php echo $base_link;?><span class="ihc-base-api-link-hash"><?php echo $data['metas']['ihc_api_hash'];?></span><?php echo '&action='.$slug;
				$i = 1;
				if (!empty($array['params'])){
					foreach ($array['params'] as $k=>$v){
						echo '&' . $k . '=exemple_' . $i;
						$i++;
					}
				}
			?></a>
			</div>
			<div class="ihc-api-details">
				<div style="margin-bottom:10px;"><?php echo '<span>'.__('Action name: ', 'ihc') .'</span>' . $slug;?></div>
				<div><span><?php _e('Params available:', 'ihc');?></span></div>
				<?php
				if (!empty($array['params'])){
					foreach ($array['params'] as $k=>$v){
						?>
						<div><?php echo '<strong>'.$v . ' : '.'</strong>' . $k;?></div>
						<?php
					}
				}
				?>
				<div style="margin-top:10px;"><?php echo '<span>'.__('Return : ', 'ihc').'</span>' . $array['return'];?></div>
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>
<?php endforeach;?>

</form>

<?php
