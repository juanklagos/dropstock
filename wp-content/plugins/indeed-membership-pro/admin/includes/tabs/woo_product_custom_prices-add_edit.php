<div class="ihc-subtab-menu">
	<a class="ihc-subtab-menu-item" href="<?php echo admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=manage');?>"><?php _e('Manage Discounts', 'ihc');?></a>
	<a class="ihc-subtab-menu-item" href="<?php echo admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=settings');?>"><?php _e('Settings', 'ihc');?></a>
	<div class="ihc-clear"></div>
</div>
<?php
if (isset($_GET['id'])){
	$id = $_GET['id'];
} else {
	$id = 0;
}
$data['metas'] = Ihc_Db::ihc_woo_product_custom_price_get_item($id);
$data['metas']['levels'] = Ihc_Db::ihc_woo_product_custom_price_lid_product_get_lid_list($id);
$data['metas']['products'] = Ihc_Db::ihc_woo_product_custom_price_lid_product_get_products_list($id);
if ($data['metas']['levels']){
	$data['metas']['levels'] = implode(',', $data['metas']['levels']);
} else {
	$data['metas']['levels'] = '';
}
if ($data['metas']['products']){
	$data['metas']['products'] = implode(',', $data['metas']['products']);
} else {
	$data['metas']['products'] = '';
}
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>

<form action="<?php echo admin_url('admin.php?page=ihc_manage&tab=woo_product_custom_prices&subtab=manage');?>" method="post">
	<div class="ihc-stuffbox">
		<h3 class="ihc-h3"><?php _e('WooCommerce Discounts', 'ihc');?></h3>
		<div class="inside">

			<div class="iump-form-line">
				<div class="row" style="margin-left:0px;">
					<div class="col-xs-5">
						<h4><?php _e('Activate/Hold', 'ihc');?></h4>
						<p><?php _e('Activate or deactivate a discount without needing to delete it.', 'ihc');?></p>
						<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
							<?php $checked = ($data['metas']['status']) ? 'checked' : '';?>
							<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#the_status');" <?php echo $checked;?> />
							<div class="switch" style="display:inline-block;"></div>
						</label>
						<input type="hidden" name="status" value="<?php echo $data['metas']['status'];?>" id="the_status" />
					</div>
				</div>
			</div>

			<div class="ihc-line-break"></div>

			<div class="iump-form-line">
				<div class="row" style="margin-left:0px;">
					<div class="col-xs-5">
						<div class="input-group" style="">
						<span class="input-group-addon" id="basic-addon1"><?php _e('Name', 'ihc');?></span>
						<input type="text" class="form-control" name="slug" value="<?php echo $data['metas']['slug'];?>" />
						</div>
					</div>
				</div>
			</div>

			<div class="ihc-line-break"></div>

			<div class="iump-form-line">
				<div class="row" style="margin-left:0px;">
				<div class="col-xs-5">
					<h4 style="font-size: 24px;"><?php _e('Discount Amount', 'ihc');?></h4>
					<p><?php _e('Set the value and type of Discount', 'ihc');?></p>
					<div style="margin-bottom:15px;">
						<select name="discount_type" class="form-control m-bot15">
							<?php
								$types = array('%'=>__('Percentage Value', 'ihc'), 'flat' => __('Flat Value', 'ihc') );
								foreach ($types as $k => $v):?>
							<option value="<?php echo $k;?>" <?php if ($data['metas']['discount_type']==$k) echo 'selected';?> ><?php echo $v;?></option>
							<?php endforeach;?>
						</select>
					</div>
					<div class="input-group" style="margin:0px 0 5px 0;">
						<span class="input-group-addon" id="basic-addon1"><?php _e('Value', 'ihc');?></span>
						<input type="number" class="form-control" name="discount_value" value="<?php echo $data['metas']['discount_value'];?>" min=0 step="0.01" />
					</div>
				</div>
				</div>
			</div>

			<div class="iump-form-line iump-special-line">
				<div class="row" style="margin-left:0px;">
					<div class="col-xs-5">
						<h4 style="font-size: 24px;"><?php _e('Targeting', 'ihc');?></h4>
						<p><?php _e('Users with certain levels will get a special price for some products.' , 'ihc');?></p>
						<br/>
						<h4><?php _e('Levels', 'ihc');?></h4>
						<div style="margin:0px 0 5px 0;">
							<p><?php _e('Discount available only for users that have one of the selected levels.', 'ihc');?></p>
							<?php
							$posible_values = array( -2 => '...', -1 => __('All', 'ihc') );
							$levels = get_option('ihc_levels');
							if ($levels){
								foreach ($levels as $id=>$level){
									$posible_values[$id] = $level['name'];
								}
							}
							?>
							<select class="form-control" id="ihc-change-target-user-set" onChange="ihcWriteLevelTagValue(this, '#list_levels_hidden', '#ihc_tags_field_2', 'ihc_select_tag_' );" style="width: 100%;    padding: 16px 0px;">
								<?php
									foreach ($posible_values as $k=>$v){
										?>
										<option value="<?php echo $k;?>"><?php echo $v;?></option>
										<?php
									}
								?>
							</select>
							<input type="hidden" name="levels" class="form-control" id="list_levels_hidden" value="<?php echo $data['metas']['levels'];?>" />
						</div>
						<div id="ihc_tags_field_2">
			            	<?php if (isset($data['metas']['levels'])):
			                    	if (strpos($data['metas']['levels'], ',')!==FALSE){
			                    		$values = explode(',', $data['metas']['levels']);
			                    	} else {
			                        	$values[] = $data['metas']['levels'];
			                        }
			                        if (count($values)){
			                        	foreach ($values as $value){
			                        		if (isset($posible_values[$value])){
			                        			?>
					                        		<div id="ihc_select_tag_<?php echo $value;?>" class="ihc-tag-item">
					                        	    	<?php echo $posible_values[$value];?>
					                        	    	<div class="ihc-remove-tag" onclick="ihcremoveTagForEditPost('<?php echo $value;?>', '#ihc_select_tag_', '#list_levels_hidden');" title="<?php _e('Removing tag', 'ihc');?>">x</div>
					                        	    </div>
					                        	<?php
			                        		}
			                        	}//end of foreach
			                        }
			                        ?>
			                    <div class="ihc-clear"></div>
			                    <?php endif; ?>
						</div>
						<br/>
						<h4><?php _e('Products', 'ihc');?></h4>
						<p><?php _e('You can chose a list of products, a list of categories, or all products.', 'ihc');?></p>
						<select onChange="jQuery('#product_search').autocomplete( 'option', { source: '<?php echo IHC_URL . 'admin/ajax-custom.php';?>?woo_type='+this.value } );ihcChangeSearchWooType();" id="search_woo_type" class="form-control" name="settings[woo_item_type]">
							<?php
								if (empty($data['metas']['settings']['woo_item_type'])){
									$data['metas']['settings']['woo_item_type'] = '';
								}
								$possible_values = array(
															'-1' => '...',
															'all' => __('All', 'ihc'),
															'category' => __('Specific Categories', 'ihc'),
															'product' => __('Specific Products', 'ihc'),
								);
								foreach ($possible_values as $k => $v){
									$selected = $data['metas']['settings']['woo_item_type']==$k ? 'selected' : '';
									?>
									<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
									<?php
								}
							?>
						</select>

						<div id="woo_the_search_box" style="display: <?php if ($data['metas']['settings']['woo_item_type']=='category' || $data['metas']['settings']['woo_item_type']=='product') echo 'block'; else echo 'none';?>">
							<div class="input-group" style="margin:5px 0 5px 0;">
								<span class="input-group-addon" id="the_search_label"><?php
									$label = __('Search ', 'ihc');
									if ($data['metas']['settings']['woo_item_type']=='products'){
										$label .= __('Product', 'ihc');
									} else if ($data['metas']['settings']['woo_item_type']=='categories'){
										$label .= __('Category', 'ihc');
									}
								echo $label;?></span>
								<input type="text" class="form-control" id="product_search"/>
								<input type="hidden" name="products" class="form-control" id="product_search_input" value="<?php echo @$data['metas']['products'];?>"/>
							</div>
							<div id="ihc_reference_search_tags"><?php
								if (!empty($data['metas']['products'])){
									$data['metas']['products'] = explode(',', $data['metas']['products']);
									foreach ($data['metas']['products'] as $value){
										if ($value){
											$id = 'ihc_reference_tag_' . $value;
											if ($data['metas']['settings']['woo_item_type']=='category'){
												/// get cat by id
												$title = Ihc_Db::get_category_name($value);
											} else {
												/// get product title
												$title = get_the_title($value);
											}
											?>
											<div id="<?php echo $id;?>" class="ihc-tag-item"><?php echo $title;?><div class="ihc-remove-tag" onclick="ihcRemoveTag('<?php echo $value;?>', '#<?php echo $id;?>', '#product_search_input');" title="Removing tag">x</div></div>
											<?php
										}
									}
								}
							?></div>
						</div>

						<div id="ihc_woo_all_products" style="display: <?php if ($data['metas']['settings']['woo_item_type']=='all') echo 'block'; else echo 'none';?>"><div class="ihc-tag-item"><?php _e('All Products', 'ihc');?></div></div>

					</div>
				</div>
			</div>

			<div class="iump-form-line">
				<div class="row" style="margin-left:0px;">
				<div class="col-xs-4">
					<h4 style="font-size: 24px;"><?php _e('Date Range', 'ihc');?></h4>
					<p><?php _e('The discount will be active during a certain time interval based on your selling strategy.', 'ihc');?></p>
					<input type="text" style="max-width:40%; display:inline-block;" class="form-control" id="start_date_input" name="start_date" value="<?php echo $data['metas']['start_date'];?>"  /> - <input type="text"  style="max-width:40%; display:inline-block;" class="form-control" id="end_date_input" name="end_date" value="<?php echo $data['metas']['end_date'];?>"  />
				</div>
				</div>
			</div>


			<div class="ihc-line-break"></div>

			<?php
				if (empty($data['metas']['settings']['color'])){
					$data['metas']['settings']['color'] = ihc_generate_color_hex();
				}
			?>

			<div class="iump-form-line">
				<div class="row" style="margin-left:0px;">
					<div class="col-xs-5">
						<div class="input-group" style="margin:0px 0 5px 0;">
							<h4 style="font-size: 24px;"><?php _e("Color Scheme", 'ihc');?></h4>
							<div class="ihc-user-list-wrap">
		                    	<ul id="colors_ul" class="colors_ul">
		                        <?php
		                        	$color_scheme = array(
		                        							'#0a9fd8',
		                        							'#38cbcb',
		                        							'#27bebe',
		                        							'#0bb586',
		                        							'#94c523',
		                        							'#6a3da3',
		                        							'#f1505b',
		                        							'#ee3733',
		                        							'#f36510',
		                        							'#f8ba01',
									);
		                            $i = 0;
		                                    foreach ($color_scheme as $color){
		                                        if( $i==5 ) echo "<div class='clear'></div>";
		                                        $class = ($data['metas']['settings']['color']==$color) ? 'color-scheme-item-selected' : 'color-scheme-item';
		                                        ?>
		                                            <li class="<?php echo $class;?>" onClick="ihcChangeColorScheme(this, '<?php echo $color;?>', '#color_scheme');" style="background-color: <?php echo $color;?>;"></li>
		                                        <?php
		                                        $i++;
		                                    }
		                        ?>
									<div class='clear'></div>
		                        </ul>
		                        <input type="hidden" name="settings[color]" id="color_scheme" value="<?php echo $data['metas']['settings']['color'];?>" />
							</div>
						</div>
					</div>
				</div>
			</div>

			<input type="hidden" name="id" value="<?php echo $data['metas']['id'];?>" />

			<div class="ihc-submit-form" style="margin-top: 20px;">
				<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save" class="button button-primary button-large" />
			</div>

		</div>
	</div>
</form>

<script>
var search_cats_label = '<?php _e('Search Categories', 'ihc');?>';
var search_prod_label = '<?php _e('Search Products', 'ihc');?>';
var ihc_woo_search_type = jQuery('#search_woo_type').val();

jQuery(document).ready(function(){
    var ihc_from = jQuery('#start_date_input').datepicker({
        dateFormat : 'yy-mm-dd'
    })
    .on( "change", function() {
        ihc_to.datepicker( "option", "minDate", this.value );
    });
    var ihc_to = jQuery('#end_date_input').datepicker({
        dateFormat : 'yy-mm-dd'
    })
    .on( "change", function() {
        ihc_from.datepicker( "option", "maxDate", this.value );
    });
});

function ihc_split(v){
	if (v.indexOf(',')!=-1){
	    return v.split( /,\s*/ );
	} else if (v!=''){
		return [v];
	}
	return [];
}
function ihc_extract(t) {
    return ihc_split(t).pop();
}

jQuery(function() {
    /// REFERENCE SEARCH
	jQuery( "#product_search" ).bind( "keydown", function(event){
		if ( event.keyCode === jQuery.ui.keyCode.TAB &&
			jQuery(this).autocomplete( "instance" ).menu.active){
		 	event.preventDefault();
		}
	}).autocomplete({
		focus: function( event, ui ){},
		minLength: 0,
		source: '<?php echo IHC_URL . 'admin/ajax-custom.php';?>?woo_type=' + ihc_woo_search_type,
		select: function( event, ui ) {
			var input_id = '#product_search_input';
			var terms = ihc_split(jQuery(input_id).val());//get items from input hidden
			var v = ui.item.id;
			var l = ui.item.label;
			if (!contains(terms, v)){
				terms.push(v);
			 	ihcAutocompleteWriteTag(v, input_id, '#ihc_reference_search_tags', 'ihc_reference_tag_', l);// print the new shiny box
			}
			var str_value = terms.join( "," );
			jQuery(input_id).val(str_value);//send to input hidden
			this.value = '';//reset search input
			return false;
		}
	});
});
function contains(a, obj) {
    return a.some(function(element){return element == obj;})
}
</script>
