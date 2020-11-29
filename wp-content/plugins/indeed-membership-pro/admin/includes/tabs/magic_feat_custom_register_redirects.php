<?php
$levels = get_option('ihc_levels');
if (!empty($_POST['ihc_save'])){
	update_option('ihc_register_redirects_by_level_enable', $_POST['ihc_register_redirects_by_level_enable']);
}
if (!empty($_POST['ihc_register_redirects_by_level_rules'])){
	$priorities = array();
	$values = array();
	foreach ($levels as $lid=>$arr){
		if (isset($_POST['ihc_register_redirects_by_level_rules'][$lid])){
			$values[$lid] = $_POST['ihc_register_redirects_by_level_rules'][$lid];
		}

	}
	update_option('ihc_register_redirects_by_level_rules', $values);
}
$check = get_option('ihc_register_redirects_by_level_enable');
$values = get_option('ihc_register_redirects_by_level_rules');
$default = get_option('ihc_general_register_redirect');

echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

$pages_arr = ihc_get_all_pages() + ihc_get_redirect_links_as_arr_for_select();
$pages_arr[-1] = '...';
?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Register Redirects based on Level(s)', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold Custom Redirects action', 'ihc');?></h2>
				<p style="max-width:70%;"><?php _e('Replace the default redirect after register with a custom one based on the user assigned level.', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($check) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_register_redirects_by_level_enable');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_register_redirects_by_level_enable" value="<?php echo (int)$check;?>" id="ihc_register_redirects_by_level_enable" />
			</div>

			<?php if ($levels):?>
				<div class="iump-form-line">
				<h2><?php _e('Custom Redirections:', 'ihc');?></h2>
				<?php foreach ($levels as $id=>$array):?>
					<?php
						$value = (isset($values[$id])) ? $values[$id] : $default;
					?>
					<div class="iump-form-line">
						<span class="iump-labels-special"><?php echo $array['label'];?></span>
						<select name="ihc_register_redirects_by_level_rules[<?php echo $id;?>]">
							<?php foreach ($pages_arr as $post_id=>$title):?>
								<?php $selected = ($value==$post_id) ? 'selected' : '';?>
								<option value="<?php echo $post_id;?>" <?php echo $selected;?> ><?php echo $title;?></option>
							<?php endforeach;?>
						</select>
					</div>
				<?php endforeach;?>
				</div>
      <?php endif;?>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>
		</div>
	</div>

</form>
