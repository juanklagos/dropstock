<?php
ihc_save_update_metas('account_page_menu');//save update metas
$data['metas'] = ihc_return_meta_arr('account_page_menu');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );

if ( !empty($_GET['delete']) && empty($_POST['ihc_account_page_menu_add_new-the_slug']) ){
	Ihc_Db::account_page_menu_delete_custom_item($_GET['delete']);
}
if (!empty($_POST['ihc_account_page_menu_add_new-the_slug']) && !empty($_POST['ihc_account_page_menu_add_new-the_slug'])){
	Ihc_Db::account_page_menu_save_custom_item($_POST);
}
$menu_items = Ihc_Db::account_page_get_menu();
$standard_tabs = Ihc_Db::account_page_get_menu(TRUE);

$standard_tabs = apply_filters( 'ihc_admin_account_page_menu_standard_tabs', $standard_tabs );
// @description filter for listing the account page menu standard tabs items on admin section. @param array

?>
<style>
	<?php foreach ($menu_items as $slug => $item):?>
		<?php echo '.fa-' . $slug . '-account-ihc:before';?>{
			content: '\<?php echo $item['icon'];?>';
			font-size: 20px;
		}
	<?php endforeach;?>
</style>
<div class="iump-wrapper">
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Account Page - Customize Menu', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold Customize Menu', 'ihc');?></h2>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_account_page_menu_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_account_page_menu_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_account_page_menu_enabled" value="<?php echo $data['metas']['ihc_account_page_menu_enabled'];?>" id="ihc_account_page_menu_enabled" />
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>


	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('Add new Menu Item', 'ihc');?></h3>
		<div class="inside">
			<div class="iump-form-line">
				<div class="row" style="margin-left:0px;">
					<div class="col-xs-4" style="margin-bottom: 10px;">

				   		<div class="input-group" style="margin:0px 0 15px 0;">
									<span class="input-group-addon" id="basic-addon1"><?php _e('Slug', 'ihc');?></span>
									<input type="text" name="ihc_account_page_menu_add_new-the_slug" class="form-control" value="">
				   		</div>

				   		<div class="input-group" style="margin:0px 0 15px 0;">
									<span class="input-group-addon" id="basic-addon1"><?php _e('Label', 'ihc');?></span>
									<input type="text" name="ihc_account_page_menu_add_new-the_label" class="form-control" value="">
				   		</div>

							<div class="input-group" style="margin:0px 0 15px 0;">
									<span class="input-group-addon" id="basic-addon1"><?php _e('Link', 'ihc');?></span>
									<input type="text" name="ihc_account_page_menu_add_new-url" class="form-control" value="" />
							</div>
							<div style="display: block;  margin-bottom:30px;"><?php _e( '(Optional)', 'ihc' );?></div>

				   		<div class="input-group" style="margin:0px 0 15px 0;">
							<label><?php _e('Icon', 'ihc');?></label>
							<div class="ihc-icon-select-wrapper">
								<div class="ihc-icon-input">
									<div id="indeed_shiny_select" class="ihc-shiny-select-html"></div>
								</div>
				   				<div class="ihc-icon-arrow"><i class="fa-ihc fa-arrow-ihc"></i></div>
								<div class="ihc-clear"></div>
							</div>
						</div>
					</div>
				</div>
			 </div>


			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('ReOrder Menu Items', 'ihc');?></h3>
		<div class="inside">
			<div class="ihc-sortable-table-wrapp">
				<table class="wp-list-table widefat fixed tags ihc-admin-tables" id="ihc_reorder_menu_items" style="width:100%;position:relative;">
					<thead>
						<tr>
							<th class="manage-column"><?php _e('Slug', 'ihc');?></th>
							<th class="manage-column"><?php _e('Label', 'ihc');?></th>
							<th class="manage-column"><?php _e('Icon', 'ihc');?></th>
							<th class="manage-column"><?php _e('Link', 'ihc');?></th>
							<th class="manage-column" style="width: 70px;"><?php _e('Delete', 'ihc');?></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th class="manage-column"><?php _e('Slug', 'ihc');?></th>
							<th class="manage-column"><?php _e('Label', 'ihc');?></th>
							<th class="manage-column"><?php _e('Icon', 'ihc');?></th>
							<th class="manage-column"><?php _e('Link', 'ihc');?></th>
							<th class="manage-column" style="width: 70px;"><?php _e('Delete', 'ihc');?></th>
						</tr>
					</tfoot>
					<tbody style="width:100%;">
						<?php $k = 0;?>
						<?php foreach ($menu_items as $slug=>$item):?>
							<tr class="<?php if($k%2==0) echo 'alternate';?>" id="tr_<?php echo $slug;?>" style="width:100%;">

								<td style="position:relative; width:30%; min-width:200px;"><input type="hidden" value="<?php echo $k;?>" name="ihc_account_page_menu_order[<?php echo $slug;?>]" class="ihc_account_page_menu_order" /><?php echo $slug;?></td>
								<td style="position:relative; min-width:200px; width:30%;color: #21759b; font-weight:bold;font-family: 'Oswald', arial, sans-serif !important;font-size: 14px;font-weight: 400;"><?php echo $item['label'];?></td>
								<td style="position:relative; width:20%; min-width:100px;"><i class="<?php echo 'fa-ihc fa-' . $slug . '-account-ihc';?>"></i></td>
								<td style="position:relative; width:20%; min-width:100px;"><?php if ( isset( $item['url'] ) ) echo $item['url'];?></td>
								<td style="position:relative; width:20%; min-width:100px;">
									<?php
										if (isset($standard_tabs[$slug])){
											echo '-';
										} else {
											?>
											<a href="<?php echo admin_url('admin.php?page=ihc_manage&tab=account_page_menu&delete=') . $slug;?>">
											<i class="fa-ihc ihc-icon-remove-e"></i>
											<?php
										}
									?>
								</a></td>
							</tr>
							<?php $k++;?>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

</form>

<?php
$font_awesome = Ihc_Db::get_font_awesome_codes();
?>
<style>
<?php foreach ($font_awesome as $base_class => $code):?>
	<?php echo '.' . $base_class . ':before';?>{
		content: '\<?php echo $code;?>'
	}
<?php endforeach;?>
</style>
<script>
jQuery(document).ready(function(){
	var indeed_shiny_object = new indeedShinySelect({
				selector: '#indeed_shiny_select',
				item_selector: '.ihc-font-awesome-popup-item',
				option_name_code: 'ihc_account_page_menu_add_new-the_icon_code',
				option_name_icon: 'ihc_account_page_menu_add_new-the_icon_class',
				default_icon: '',
				default_code: '',
				init_default: false,
				second_selector: '.ihc-icon-arrow'
	});
});
</script>

</div>
