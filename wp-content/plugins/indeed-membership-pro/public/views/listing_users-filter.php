<?php if ($this->filter_form_fields):?>
<div class="iump-listing-users-filter">
<div class="iump-filter-title"><?php _e("Search for specific Members", 'ihc');?></div>
<form action="<?php echo $base_url;?>" method="get">
	<?php foreach ($this->filter_form_fields as $field):?>

		<?php switch ($field['type']):
			case 'number':
				global $ihc_jquery_ui_min_css;
				if (empty($ihc_jquery_ui_min_css)){
					$ihc_jquery_ui_min_css = TRUE;
					?><link rel="stylesheet" type="text/css" href="<?php echo IHC_URL . 'admin/assets/css/jquery-ui.min.css';?>"/><?php
				}
				$hidden_min = '';
				$hidden_max = '';
				if (!isset($field['values']['min'])){
					$field['values']['min'] = '';
				}
				if (!isset($field['values']['max'])){
					$field['values']['max'] = '';
				}

				if (isset($_GET[$field['name']]) && isset($_GET[$field['name']][0]) && $_GET[$field['name']][0]!=''){
					$current['min'] = $_GET[$field['name']][0];
					$hidden_min = $_GET[$field['name']][0];
				} else {
					$current['min'] = $field['values']['min'];
				}
				if (isset($_GET[$field['name']]) && isset($_GET[$field['name']][1]) && $_GET[$field['name']][1]!=''){
					$current['max'] = $_GET[$field['name']][1];
					$hidden_max = $_GET[$field['name']][1];
				} else {
					$current['max'] = $field['values']['max'];
				}

				if ($field['values']['min']!=$field['values']['max']):
				?>
				<div class="iump-filter-row">
					<label><?php echo $field['label'];?></label>
					<div style="display: inline-block; margin-left: 10px;" id="<?php echo 'iump_slider_' . $field['name'] . '_view_values';?>">
						<?php echo $current['min'] . ' - ' . $current['max'];?>
					</div>
					<div id="<?php echo 'iump_slider_' . $field['name'];?>"></div>
				</div>
				<script>
				  jQuery(document).ready(function(){
					    jQuery("<?php echo '#iump_slider_' . $field['name'];?>").slider({
						      range: true,
						      min: <?php echo $field['values']['min'];?>,
						      max: <?php echo $field['values']['max'];?>,
						      values: [<?php echo $current['min'];?>, <?php echo $current['max'];?>],
						      slide: function( event, ui ){
						      		jQuery('<?php echo '#' . $field['name'] . 'min';?>').val(ui.values[0]);
						      		jQuery('<?php echo '#' . $field['name'] . 'max';?>').val(ui.values[1]);
						      		jQuery('<?php echo '#iump_slider_' . $field['name'] . '_view_values';?>').html(ui.values[0] + ' - ' + ui.values[1]);
						      }
					    });
				  });
				  </script>
				  <?php endif;?>
				  <input type="hidden" name="<?php echo $field['name'];?>[0]" value="<?php echo $hidden_min;?>" id="<?php echo $field['name'] . 'min';?>" />
				  <input type="hidden" name="<?php echo $field['name'];?>[1]" value="<?php echo $hidden_max;?>" id="<?php echo $field['name'] . 'max';?>" />
				<?php
				break;
			case 'select':
					//if ($field['values']):
					?>
						<div class="iump-filter-row iump-filter-country">
							<label><?php echo $field['label'];?></label>
							<select name="<?php echo $field['name'];?>" id="" class="iump-form-select" >
								<option value="" selected><?php _e('All', 'ihc');?></option>
							<?php
								$get_value = (isset($_GET[$field['name']])) ? $_GET[$field['name']] : '';
								if ($field['values']):
									foreach ($field['values'] as $k){
										$selected = ($get_value==$k) ? 'selected' : '';
										?>
										<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo ihc_correct_text($k);?></option>
										<?php
									}
								endif;
							?>
							</select>
						</div>
					<?php
					//endif;
				break;
			case 'ihc_country':
					//if ($field['values']):
					?>
						<div class="iump-filter-row iump-filter-country">
							<label><?php echo $field['label'];?></label>
							<select name="<?php echo $field['name'];?>" id="" class="iump-form-select" >
								<option value="" selected><?php _e('All', 'ihc');?></option>
							<?php
								$get_value = (isset($_GET[$field['name']])) ? $_GET[$field['name']] : '';
								if ($field['values']):
									foreach ($field['values'] as $k){
										$selected = ($get_value==$k) ? 'selected' : '';
										?>
										<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $countries[$k];?></option>
										<?php
									}
								endif;
							?>
							</select>
						</div>
					<?php
					//endif;
				break;
			case 'multi_select':
				//if ($field['values']):
				?>
				<div class="iump-filter-row iump-filter-multi">
					<label><?php echo $field['label'];?></label>
					<select name="<?php echo $field['name'];?>[]" id="" class="iump-form-select" multiple >
						<option value="" selected><?php _e('All', 'ihc');?></option>
					<?php
						$get_value = (isset($_GET[$field['name']])) ? $_GET[$field['name']] : array();
						if ($field['values']):
							foreach ($field['values'] as $k){
								$selected = (in_array($k, $get_value)) ? 'selected' : '';
								?><option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo ihc_correct_text($k);?></option><?php
							}
						endif;
					?>
					</select>
				</div>
				<?php
				//endif;
				break;
			case 'radio':
				if ($field['values']):
					?>
					<div class="iump-filter-row iump-filter-radio">
						<label><?php echo $field['label'];?></label>
						<div class="iump-form-radiobox-wrapper">
							<div class="iump-form-radiobox">
								<input type="radio" name="<?php echo $field['name'];?>" value="" checked />
								<?php _e('All', 'ihc');?>
							</div>
						<?php
						$get_value = (isset($_GET[$field['name']])) ? $_GET[$field['name']] : array();
						foreach ($field['values'] as $v){
							$checked = ($get_value==$v) ? 'checked' : '';
							?><div class="iump-form-radiobox">
							<input type="radio" name="<?php echo $field['name'];?>" value="<?php echo ihc_correct_text($v);?>" <?php echo $checked;?> />
							<?php echo ihc_correct_text($v);?>
							</div><?php
						}?>
						</div>
					</div>
					<?php
				endif;
				break;
			case 'checkbox':
				if ($field['values']):
				$get_value = (isset($_GET[$field['name']])) ? $_GET[$field['name']] : array();
				?>
				<div class="iump-filter-row iump-filter-check">
					<label><?php echo $field['label'];?></label>
					<div class="iump-form-checkbox-wrapper">
						<div class="iump-form-checkbox">
							<?php $checked = (empty($get_value)) ? 'checked' : '';?>
							<input type="checkbox" name="<?php echo $field['name'];?>[]" value="" onClick="ihcDeselectAll('<?php echo $field['name'];?>', this);" <?php echo $checked;?> />
							<?php _e('All', 'ihc');?>
						</div>
				<?php
				foreach ($field['values'] as $v){
					if (is_array($get_value)){
						$checked = (in_array($v, $get_value)) ? 'checked' : '';
					} else {
						$checked = ($v==$get_value) ? 'checked' : '';
					}
					?>
						<div class="iump-form-checkbox">
							<input type="checkbox" name="<?php echo $field['name'];?>[]" value="<?php echo ihc_correct_text($v);?>" <?php echo $checked;?> />
							<?php echo ihc_correct_text($v);?>
						</div>
					<?php
				}
				?>
					</div>
				</div>
				<?php
				endif;
				break;
			case 'date':
				wp_enqueue_script('jquery-ui-datepicker');
				$min_value = '';
				$max_value = '';
				global $ihc_jquery_ui_min_css;
				if (empty($ihc_jquery_ui_min_css)){
					$ihc_jquery_ui_min_css = TRUE;
					?><link rel="stylesheet" type="text/css" href="<?php echo IHC_URL . 'admin/assets/css/jquery-ui.min.css';?>"/><?php
				}
				$start_id = 'iump_start_' . $field['name'];
				$end_id = 'iump_end_' . $field['name'];
				if (isset($_GET[$field['name']]) && isset($_GET[$field['name']][0])){
					$field['values']['min'] = $_GET[$field['name']][0];
					$min_value = $_GET[$field['name']][0];
					$min_value = filter_var( $min_value, FILTER_SANITIZE_STRING );
					$min_value = preg_replace( "([^0-9-])", '', $min_value );
				}
				if (isset($_GET[$field['name']]) && isset($_GET[$field['name']][1])){
					$field['values']['max'] = $_GET[$field['name']][1];
					$max_value = $_GET[$field['name']][1];
					$max_value = filter_var( $max_value, FILTER_SANITIZE_STRING );
					$max_value = preg_replace( "([^0-9-])", '', $max_value );
				}
				?>
				<script>
					jQuery(document).ready(function() {
						var currentYear = new Date().getFullYear() + 20;
						jQuery("#<?php echo $start_id;?>").datepicker({
							dateFormat : "dd-mm-yy",
							changeMonth: true,
						    changeYear: true,
							yearRange: "1900:"+currentYear,
							onClose: function(r){}
						});
						jQuery("#<?php echo $end_id;?>").datepicker({
							dateFormat : "dd-mm-yy",
							changeMonth: true,
						    changeYear: true,
							yearRange: "1900:"+currentYear,
							onClose: function(r){}
						});
					});
				</script>
				<div class="iump-filter-row iump-filter-date">
					<label><?php echo $field['label'];?></label>
					<input type="text" value="<?php echo $min_value;?>" name="<?php echo $field['name'] . '[0]';?>" id="<?php echo $start_id;?>" class="iump-form-datepicker" style="width:45%;" />
					<span style="width:7%; text-align:center;  display: inline-block;" >-</span>
					<input type="text" value="<?php echo $max_value;?>" name="<?php echo $field['name'] . '[1]';?>" id="<?php echo $end_id;?>" class="iump-form-datepicker"  style="width:45%;" />
				</div>
				<?php
				break;

		endswitch;?>
	<?php endforeach;?>
	<input type="hidden" name="iump_filter" value="0" />
	<div class="iump-filter-submit">
		<input type="submit" name="filter" value="<?php echo __('Search', 'ihc');?>"/>
		<input type="submit" name="reset" value="<?php _e('Reset', 'ihc');?>" id="iump_reset_bttn" />
	</div>
</form>
</div>
<script>
	jQuery(document).ready(function(){
		jQuery('#iump_reset_bttn').on("click", function(event){
		  	event.preventDefault();
		  	window.location.href = '<?php echo $base_url;?>';
		  	return false;
		});
		jQuery("[name=filter]").on('click', function(event){
			event.preventDefault();
			jQuery.each(this.form, function(index, field){
				if (field.value==''){
					field.name = '';
				}
			});
			jQuery('[name=iump_filter]').val(1);
			this.form.submit();
		});
	});
</script>
<?php endif;?>
