<div class="ihc-subtab-menu">
	<a class="ihc-subtab-menu-item ihc-subtab-selected" href="<?php echo admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=manage');?>"><?php _e('Manage Discounts', 'ihc');?></a>
	<a class="ihc-subtab-menu-item" href="<?php echo admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=settings');?>"><?php _e('Settings', 'ihc');?></a>
	<div class="ihc-clear"></div>
</div>
<?php
if (!empty($_POST['ihc_save'])){
	if (!empty($_POST['levels']) && !empty($_POST['products'])){
		$lids = explode(',', $_POST['levels']);
		$products = explode(',', $_POST['products']);
	}

	if (!empty($lids) && !empty($products)){
		$rule_id = Ihc_Db::ihc_woo_product_custom_price_save_item($_POST);
		if (!empty($_POST['id'])){
			Ihc_Db::ihc_woo_product_custom_price_lid_product_delete($_POST['id']);
		}
		foreach ($lids as $lid){
			foreach ($products as $product_id){
				Ihc_Db::ihc_woo_product_custom_price_lid_product_save($rule_id, $lid, $product_id, $_POST['settings']['woo_item_type']);
			}
		}
	}
}
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<div class="iump-page-title">Ultimate Membership Pro -
	<span class="second-text">
		<?php _e('WooCommerce Products Discount', 'ihc');?>
	</span>
</div>
<div class="clear"></div>
<a href="<?php echo admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=add_edit');?>" class="indeed-add-new-like-wp">
	<i class="fa-ihc fa-add-ihc"></i><?php _e('Add New Discount', 'ihc');?>
</a>
<div class="clear"></div>

<?php
$data = Ihc_Db::ihc_woo_products_custom_price_get_all();
if ($data){
    $the_currency =	get_option('ihc_currency');
	foreach ($data as $id => $item_data){
		$edit_url = admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=add_edit&id=' . $id);
		?>
		<div class="ihc-coupon-admin-box-wrap" >
				<div class="ihc-coupon-box-wrap <?php echo (empty($item_data['status'])) ? 'ihc-disabled-box' : '';?>" id="" style="background-color: <?php echo $item_data['settings']['color'];?>">
					<div class="ihc-coupon-box-main">
						<div class="ihc-coupon-box-title"><?php echo $item_data['slug'];?></div>
						<div class="ihc-coupon-box-content">
							<div class="ihc-coupon-box-levels"><?php
								_e("Target Levels: ", "ihc");
								if (!empty($item_data['levels'])){
									foreach ($item_data['levels'] as $templid){
										if ($templid==-1){
											$temp_levels[] = __('All', 'ihc');
										} else {
											$temp_levels[] = Ihc_Db::get_level_name_by_lid($templid);
										}
									}
									echo implode(', ', $temp_levels);
								} else {
									echo '-';
								}
							?>
							</div>
							<div class="ihc-coupon-box-levels"><?php
								if (!empty($item_data['products'])){
									foreach ($item_data['products'] as $tempproduct){
										if ($item_data['settings']['woo_item_type']=='category'){
											$temp_products[] = Ihc_Db::get_category_name($tempproduct);
										} else {
											if ($tempproduct==-1){
												$all_products = TRUE;
												break;
											} else {
												$temp_products[] = get_the_title($tempproduct);
											}
										}
									}
									if (!empty($all_products)){
										_e('Target Products: All', 'ihc');
									} else {
										if ($item_data['settings']['woo_item_type']=='category'){
											_e('Target Category: ', 'ihc');
										} else {
											_e('Target Products: ', 'ihc');
										}
										if (!empty($temp_products)){
											echo implode(', ', $temp_products);
										}
									}
								}
								if (!empty($temp_levels)){
									unset($temp_levels);
								}
								if (!empty($temp_products)){
									unset($temp_products);
								}
								if (!empty($all_products)){
									unset($all_products);
								}
							?>
							</div>
						</div>
						<div class="ihc-coupon-box-links-wrap ihcwoo-no-top-margin">
							<div class="ihc-coupon-box-links">
								<a href="<?php echo $edit_url;?>" class="ihc-coupon-box-link"><?php _e('Edit', 'ihc');?></a>
								<div class="ihc-coupon-box-link" onClick="ihcDoDeleteWooIhcRelation(<?php echo $id;?>, '<?php echo admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=manage');?>');">Delete</div>
							</div>
						</div>
					</div>
					<div class="ihc-coupon-box-bottom">
						<div class="ihc-coupon-box-bottom-disccount"><?php
								echo $item_data['discount_value'];
								if ($item_data['discount_type']=='%'){
									echo "%";
								} else {
									echo ' ' . $the_currency;
								}
							?></div>
						<div class="ihc-coupon-box-bottom-submitted"></div>

						<div class="ihc-coupon-box-bottom-date"><?php
							if (!empty($item_data['start_date']) && $item_data['start_date']!='0000-00-00 00:00:00'){
								echo __("From: ", "ihc") . '<span>'. $item_data['start_date'] . "</span><br/> ";
							}
							if (!empty($item_data['end_date']) && $item_data['end_date']!='0000-00-00 00:00:00'){
								echo __("Until: ", "ihc") . ' <span>'. $item_data['end_date'].'</span>';
							}
						?>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		<?php
	}
} else {
	?>
	<div class="ihc-warning-message"><?php _e(" No Rule available! Please create your first Rule.", "ihc");?></div>
	<?php
}
