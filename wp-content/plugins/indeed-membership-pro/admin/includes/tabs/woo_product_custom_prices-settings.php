<div class="ihc-subtab-menu">
	<a class="ihc-subtab-menu-item" href="<?php echo admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=manage');?>"><?php _e('Manage Discounts', 'ihc');?></a>
	<a class="ihc-subtab-menu-item ihc-subtab-selected" href="<?php echo admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=settings');?>"><?php _e('Settings', 'ihc');?></a>
	<div class="ihc-clear"></div>
</div>

<?php
ihc_save_update_metas('woo_product_custom_prices');//save update metas
$data['metas'] = ihc_return_meta_arr('woo_product_custom_prices');//getting metas
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<form action="" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('WooCommerce Products Discount', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<h2><?php _e('Activate/Hold WooCommerce Products Custom Prices', 'ihc');?></h2>
                <p style="max-width:800px;"><?php _e('Provides special WooCommerce product prices for Users that have assigned a specific Subscription/Level', 'ihc');?></p>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_woo_product_custom_prices_enabled']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_woo_product_custom_prices_enabled');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_woo_product_custom_prices_enabled" value="<?php echo $data['metas']['ihc_woo_product_custom_prices_enabled'];?>" id="ihc_woo_product_custom_prices_enabled" />
			</div>

			<div class="iump-form-line">
				<h2><?php _e('On multiple discount values for the same Product show the:', 'ihc');?></h2>
				<select name="ihc_woo_product_custom_prices_tiebreaker">
					<?php
						$possible = array(
											'smallest'=> __('Smallest final Price', 'ihc'),
											'biggest'=> __('Biggest final Price', 'ihc'),
						);
						foreach ($possible as $key => $value):
					?>
					<option value="<?php echo $key;?>" <?php if ($data['metas']['ihc_woo_product_custom_prices_tiebreaker']==$key) echo 'selected';?> ><?php echo $value;?></option>
					<?php endforeach;?>
				</select>
                <p style="max-width:800px; margin-top:30px;"><?php _e('When a user have multiple Subscriptions assigned that will provide a different discount for Woo Products but only one price is available, this option will decide which final price will be listed.', 'ihc');?></p>
			</div>

			<div class="iump-form-line">
				<h2><?php _e('Show the New and Old Price also:', 'ihc');?></h2>
				<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
					<?php $checked = ($data['metas']['ihc_woo_product_custom_prices_like_discount']) ? 'checked' : '';?>
					<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_woo_product_custom_prices_like_discount');" <?php echo $checked;?> />
					<div class="switch" style="display:inline-block;"></div>
				</label>
				<input type="hidden" name="ihc_woo_product_custom_prices_like_discount" value="<?php echo $data['metas']['ihc_woo_product_custom_prices_like_discount'];?>" id="ihc_woo_product_custom_prices_like_discount" />
			</div>

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>

</form>
