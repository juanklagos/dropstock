<?php
$levels = get_option('ihc_levels');
if (!empty($_POST['ihc_save'])){
	update_option('ihc_login_level_redirect_on', $_POST['ihc_login_level_redirect_on']);
}
if (!empty($_POST['ihc_login_level_redirect_rules'])){
	$priorities = array();
	$values = array();
	foreach ($levels as $lid=>$arr){
		if (isset($_POST['ihc_login_level_redirect_rules'][$lid])){
			$values[$lid] = $_POST['ihc_login_level_redirect_rules'][$lid];
		}
		if (isset($_POST['ihc_login_level_redirect_priority'][$lid])){
			$key = $_POST['ihc_login_level_redirect_priority'][$lid];
			while (isset($priorities[$key])){
				$key++;
			}
			$priorities[$key] = $lid;
		}
	}
	update_option('ihc_login_level_redirect_rules', $values);
	if ($priorities){
		$i = 1;
		ksort($priorities);
		$store_value = array();
		foreach ($priorities as $lid){
			$store_value[$i] = $lid;
			$i++;
		}
		update_option('ihc_login_level_redirect_priority', $store_value);
	}
}
$check = get_option('ihc_login_level_redirect_on');
$values = get_option('ihc_login_level_redirect_rules');
$default = get_option('ihc_general_login_redirect');
$priorities = get_option('ihc_login_level_redirect_priority');

echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

$pages_arr = ihc_get_all_pages() + ihc_get_redirect_links_as_arr_for_select();
$pages_arr[-1] = '...';
?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Login Redirects based on Level(s)', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold Custom Redirects action', 'ihc');?></h2>
				<p style="max-width:70%;"><?php _e('Replace the default redirect after login with a custom one based on the user assigned level. Because UMP is a MultiLevel system, a user can have multiple levels assigned but only one redirect can take place. You can set level priorities to manage that.', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($check) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_login_level_redirect_on');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_login_level_redirect_on" value="<?php echo (int)$check;?>" id="ihc_login_level_redirect_on" />
			</div>
			<p style="max-width:70%; font-weight:bold;"><?php _e('Important: In order for the custom Login Redirect to work, the level of the user needs to be active. If expired or on hold, the custom redirect will not work.', 'ihc');?></p>

			<?php if ($levels):?>
				<div class="iump-form-line">
				<h2><?php _e('Custom Redirections:', 'ihc');?></h2>
				<?php foreach ($levels as $id=>$array):?>
					<?php
						$value = (isset($values[$id])) ? $values[$id] : $default;
					?>
					<div class="iump-form-line">
						<span class="iump-labels-special"><?php echo $array['label'];?></span>
						<select name="ihc_login_level_redirect_rules[<?php echo $id;?>]">
							<?php foreach ($pages_arr as $post_id=>$title):?>
								<?php $selected = ($value==$post_id) ? 'selected' : '';?>
								<option value="<?php echo $post_id;?>" <?php echo $selected;?> ><?php echo $title;?></option>
							<?php endforeach;?>
						</select>
					</div>
				<?php endforeach;?>
				</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>
		</div>
	</div>
	<div class="ihc-stuffbox">
		<h3><?php _e('Levels Priorities:', 'ihc');?></h3>
		<div class="inside">
					<p style="max-width:70%;"><?php _e('Because UMP is a MultiLevel system, a user can have multiple levels assigned but only one redirect can take place. You can set level priorities to manage that.', 'ihc');?></p>
					<?php $i = 1;?>
					<?php foreach ($levels as $id=>$array):?>
						<?php
							if ($priorities && is_array($priorities)){
								$key = array_search($id, $priorities);
							}

							if (!empty($key)){
								$priority = $key;
							} else {
								$priority = $i;
							}
						?>
						<span class="iump-labels-special"><?php echo $array['label'];?></span>
						<input type="number" min="1" name="ihc_login_level_redirect_priority[<?php echo $id;?>]" value="<?php echo $priority;?>" />
						<?php $i++;?>
					<?php endforeach;?>

			<?php endif;?>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>
</form>
