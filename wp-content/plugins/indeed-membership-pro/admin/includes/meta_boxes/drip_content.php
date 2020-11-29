<?php
wp_enqueue_style( 'ihc_jquery-ui.min.css', IHC_URL . 'admin/assets/css/jquery-ui.min.css');
global $post;
$meta_arr = ihc_post_metas($post->ID);

if ($meta_arr['ihc_mb_type']=='show' && !empty($meta_arr['ihc_mb_who'])){
	$show_options = 'block';
	$show_not_available = 'none';
} else {
	$show_options = 'none';
	$show_not_available = 'block';
}
?>

<div id="ihc_drip_content_meta_box" style="display: <?php echo $show_options;?>">

	<div style="margin-top:15px;">
		<!--label for="tag-showup" style="font-weight:bold; margin:15px 0; "><?php _e('Enable:', 'ihc');?></label-->
		<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
			<?php $checked = ($meta_arr['ihc_drip_content'] == 1) ? 'checked' : '';?>
			<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#ihc_drip_content_h');" <?php echo $checked;?> />
			<div class="switch" style="display:inline-block;"></div>
		</label>
		<input type="hidden" value="<?php echo $meta_arr['ihc_drip_content'];?>" name="ihc_drip_content" id="ihc_drip_content_h" />
	</div>
	<div>
	 <p><?php _e("Set to release content at regular intervals by create a schedule of your content", 'ihc')?></p>
	</div>
	<div style="margin: 10px -12px; padding: 10px 10px 20px 10px; border-top: 1px solid #efefef;background-color: #f5f5f5; border-bottom: 2px solid rgba(31, 181, 172, 1.0);"><?php
		_e('<b>Available for: </b>', 'ihc');

		$posible_values = array('all'=>__('All', 'ihc'), 'reg'=>__('Registered Users','ihc'), 'unreg'=>__('Unregistered Users','ihc') );
		$levels = get_option('ihc_levels');
		if ($levels){
			foreach ($levels as $id=>$level){
				$posible_values[$id] = $level['name'];
			}
		}
		if (strpos($meta_arr['ihc_mb_who'], ',')!==FALSE){
			$values = explode(',', $meta_arr['ihc_mb_who']);
		} else {
			$values[] = $meta_arr['ihc_mb_who'];
		}
		$print_levels = array();
		?>
		<div id="ihc_drip_content_list_targets">
		<?php
		if (count($values)>0){
			foreach ($values as $v){
				if (!empty($posible_values[$v])){
				?>
					<span id="ihc_drip_target-<?php echo $v;?>" ><?php echo $posible_values[$v];?></span>
				<?php
				}
			}
		}
		?>
		</div>
	</div>

	<?php if ( function_exists( 'register_block_type' ) ) : // Gutenberg ?>
		<div style="margin-top: 10px; padding-top: 5px;margin-bottom: 10px;">
				<h3 class="ihc-meta-drip-subtitle"><?php _e("Release Time", 'ihc');?></h3>
				<div style="margin: 15px 0px;">

						<div  class="ihc-inside-bootstrap-slide" id="ihc_slide_2" >

									<div style="margin-bottom: 10px;" >
											<div class="title-select"><?php _e('Type of release time', 'ihc');?></div>
											<select name="ihc_drip_start_type" class="js-ump-select-drip-content-start-time">
													<option value="1" <?php if ( $meta_arr['ihc_drip_start_type'] == 1 ){echo 'selected';}?> ><?php _e( 'Instantanly Subscription', 'ihc');?></option>
													<option value="2" <?php if ( $meta_arr['ihc_drip_start_type'] == 2 ){echo 'selected';}?> ><?php _e( 'After Subscription', 'ihc');?></option>
													<option value="3" <?php if ( $meta_arr['ihc_drip_start_type'] == 3 ){echo 'selected';}?> ><?php _e( 'On Specific Date', 'ihc');?></option>
											</select>
									</div>

								<div class="js-ump-select-drip-content-start-time-after-subscription ihc-inside-bootstrap-slide-div-2" <?php if ( $meta_arr['ihc_drip_start_type'] != 2 ) echo 'style="display: none;"'; ?> >
										<div class="title-select"><?php _e('After Subscription:', 'ihc');?></div>
										<div>
												<input type="number" min="0" value="<?php echo $meta_arr['ihc_drip_start_numeric_value'];?>" name="ihc_drip_start_numeric_value" style="width: 51px;" />
												<select name="ihc_drip_start_numeric_type" style="vertical-align: top !important;"><?php
														foreach (array('days'=>'Days', 'weeks'=>'Weeks', 'months'=>'Months') as $k=>$v){
														?>
																<option value="<?php echo $k;?>" <?php if ($meta_arr['ihc_drip_start_numeric_type']==$k) echo 'selected';?> ><?php echo $v;?></option>
														<?php
														}
												?></select>
										</div>
								</div>

								<div class="js-ump-select-drip-content-start-time-on-specific-date ihc-inside-bootstrap-slide-div-3" <?php if ( $meta_arr['ihc_drip_start_type'] != 3 ) echo 'style="display: none;"'; ?> >
										<div class="ihc-inside-bootstrap-slide-div-3">
												<div class="title-select"><?php _e('On Specific Date:', 'ihc');?></div>
												<input type="text" value="<?php echo $meta_arr['ihc_drip_start_certain_date'];?>" name="ihc_drip_start_certain_date" id="ihc_drip_start_certain_date"/>
												<div style="font-size:11px; color:#999; font-style:italic"><?php _e('Pick the desired date when the Page will be available', 'ihc');?></div>
										</div>
								</div>
						</div>

				</div>
				<div class="ihc-clear"></div>
		</div>

		<div style="margin-top: 10px;padding-top: 5px; margin: 10px -12px; padding: 10px 10px 20px 10px;margin-bottom: 0px; padding-bottom: 0px; background: #fcfcfc; border-top: 1px solid #efefef;border-bottom: 1px solid #efefef;">
			<h3 class="ihc-meta-drip-subtitle" ><?php _e("Expiration Time", 'ihc')?></h3>
			<div style="margin: 15px 0px;">

				<div class="ihc-inside-bootstrap-slide" id="ihc_slide_3" >

					<div class="">
							<div class="title-select"><?php _e('Type of expiration time', 'ihc');?></div>
							<select name="ihc_drip_end_type" class="js-ump-select-drip-content-end-time" >
									<option value="1" <?php if ( $meta_arr['ihc_drip_end_type'] == 1 ){echo 'selected';}?> ><?php _e( 'Never', 'ihc');?></option>
									<option value="2" <?php if ( $meta_arr['ihc_drip_end_type'] == 2 ){echo 'selected';}?> ><?php _e( 'After certain Period', 'ihc');?></option>
									<option value="3" <?php if ( $meta_arr['ihc_drip_end_type'] == 3 ){echo 'selected';}?> ><?php _e( 'On Specific Date', 'ihc');?></option>
							</select>
					</div>


					<div class="js-ump-select-drip-content-end-time-after-subscription" <?php if ( $meta_arr['ihc_drip_end_type'] != 2 ) echo 'style="display: none;"'; ?> >
							<div class="title-select"><?php _e('After certain Period:', 'ihc');?></div>
							<div>
									<input type="number" min="0" value="<?php echo $meta_arr['ihc_drip_end_numeric_value'];?>" name="ihc_drip_end_numeric_value" style="width: 51px;" />
									<select name="ihc_drip_end_numeric_type" style="vertical-align: top !important;"><?php
										foreach (array('days'=>'Days', 'weeks'=>'Weeks', 'months'=>'Months') as $k=>$v){
											?>
											<option value="<?php echo $k;?>" <?php if ($meta_arr['ihc_drip_end_numeric_type']==$k) echo 'selected';?> ><?php echo $v;?></option>
											<?php
										}
									?></select>
							</div>
					</div>

					<div class="js-ump-select-drip-content-end-time-on-specific-date" <?php if ( $meta_arr['ihc_drip_end_type'] != 3 ) echo 'style="display: none;"'; ?> >
						<div class="ihc-inside-bootstrap-slide-div-3">
								<div class="title-select"><?php _e('On Specific Date', 'ihc');?></div>
								<input type="text" value="<?php echo $meta_arr['ihc_drip_end_certain_date'];?>" name="ihc_drip_end_certain_date" id="ihc_drip_end_certain_date"/>
						</div>
					</div>

				</div>
			</div>
		</div>

	<?php else :?>
	<div style="margin-top: 10px; padding-top: 5px;">
		<h3 class="ihc-meta-drip-subtitle"><?php _e("Release Time", 'ihc')?></h3>
		<div style="margin: 15px 0px;">
			<input id="ihc_drip_start_type" type="text" name="ihc_drip_start_type" />
			<div class="ihc-inside-bootstrap-slide" id="ihc_slide_1">
				<div class="ihc-inside-bootstrap-slide-div-1"><div class="title-select"><?php _e('Instantanly Subscription', 'ihc');?></div>
				<span style="font-size:11px; color:#999; font-style:italic"><?php _e('after the user bought the Subscription access', 'ihc');?></span>
				</div>
				<div class="ihc-inside-bootstrap-slide-div-2">
					<div class="title-select"><?php _e('After Subscription:', 'ihc');?></div>
					<div>
					<input type="number" min="0" value="<?php echo $meta_arr['ihc_drip_start_numeric_value'];?>" name="ihc_drip_start_numeric_value" style="width: 51px;" />
					<select name="ihc_drip_start_numeric_type" style="vertical-align: top !important;"><?php
						foreach (array('days'=>'Days', 'weeks'=>'Weeks', 'months'=>'Months') as $k=>$v){
							?>
							<option value="<?php echo $k;?>" <?php if ($meta_arr['ihc_drip_start_numeric_type']==$k) echo 'selected';?> ><?php echo $v;?></option>
							<?php
						}
					?></select>
					</div>
				</div>
				<div class="ihc-inside-bootstrap-slide-div-3">
					<div class="title-select"><?php _e('On Specific Date:', 'ihc');?></div>
					<input type="text" value="<?php echo $meta_arr['ihc_drip_start_certain_date'];?>" name="ihc_drip_start_certain_date" id="ihc_drip_start_certain_date"/>

					<div style="font-size:11px; color:#999; font-style:italic"><?php _e('Pick the desired date when the Page will be available', 'ihc');?></div>

				</div>
			</div>
			<div class="ihc-clear"></div>
		</div>
	</div>

	<div style="    margin-top: 10px;padding-top: 5px; margin: 10px -12px; padding: 10px 10px 20px 10px;margin-bottom: 0px; padding-bottom: 0px; background: #fcfcfc; border-top: 1px solid #efefef;border-bottom: 1px solid #efefef;">
		<h3 class="ihc-meta-drip-subtitle"><?php _e("Expiration Time", 'ihc')?></h3>
		<div style="margin: 15px 0px;">
			<input id="ihc_drip_end_type" type="text" name="ihc_drip_end_type"/>
			<div class="ihc-inside-bootstrap-slide" id="ihc_slide_2">
				<div class="ihc-inside-bootstrap-slide-div-1"><div class="title-select"><?php _e('Never', 'ihc');?></div>
				<span style="font-size:11px; color:#999; font-style:italic"><?php _e('once is available the content will not expire', 'ihc');?></span>
				</div>
				<div class="ihc-inside-bootstrap-slide-div-2">
					<div class="title-select"><?php _e('After certain Period:', 'ihc');?></div>
					<input type="number" min="0" value="<?php echo $meta_arr['ihc_drip_end_numeric_value'];?>" name="ihc_drip_end_numeric_value" style="width: 51px;" />
					<select name="ihc_drip_end_numeric_type" style="vertical-align: top !important;"><?php
						foreach (array('days'=>'Days', 'weeks'=>'Weeks', 'months'=>'Months') as $k=>$v){
							?>
							<option value="<?php echo $k;?>" <?php if ($meta_arr['ihc_drip_end_numeric_type']==$k) echo 'selected';?> ><?php echo $v;?></option>
							<?php
						}
					?></select>
				</div>
				<div class="ihc-inside-bootstrap-slide-div-3">
					<div class="title-select"><?php _e('On Specific Date', 'ihc');?></div>
					<input type="text" value="<?php echo $meta_arr['ihc_drip_end_certain_date'];?>" name="ihc_drip_end_certain_date" id="ihc_drip_end_certain_date"/>
				</div>
			</div>
		</div>
	</div>

<?php endif;?>

</div>

<div id="ihc_drip_content_empty_meta_box" style="display: <?php echo $show_not_available;?>">
	<?php _e("First you must select 'Show Page Only' from 'Locker' and add some Targets in order to access this feature!", 'ihc');?>
</div>


<script>


			jQuery( document ).ready(function(){
					jQuery( '.js-ump-select-drip-content-start-time' ).on( 'change', function(){
							var currentValue = jQuery( '.js-ump-select-drip-content-start-time' ).val();
							switch ( currentValue ){
									case '1':
										jQuery( '.js-ump-select-drip-content-start-time-after-subscription' ).css( 'display', 'none' );
										jQuery( '.js-ump-select-drip-content-start-time-on-specific-date' ).css( 'display', 'none' );
										break;
									case '2':
										jQuery( '.js-ump-select-drip-content-start-time-after-subscription' ).css( 'display', 'block' );
										jQuery( '.js-ump-select-drip-content-start-time-on-specific-date' ).css( 'display', 'none' );
										break;
									case '3':
										jQuery( '.js-ump-select-drip-content-start-time-after-subscription' ).css( 'display', 'none' );
										jQuery( '.js-ump-select-drip-content-start-time-on-specific-date' ).css( 'display', 'block' );
										break;
							}
					});

					jQuery( '.js-ump-select-drip-content-end-time' ).on( 'click', function(){
							var currentValue = jQuery( '.js-ump-select-drip-content-end-time' ).val();
							switch ( currentValue ){
								case '1':
									jQuery( '.js-ump-select-drip-content-end-time-after-subscription' ).css( 'display', 'none' );
									jQuery( '.js-ump-select-drip-content-end-time-on-specific-date' ).css( 'display', 'none' );
									break;
								case '2':
									jQuery( '.js-ump-select-drip-content-end-time-after-subscription' ).css( 'display', 'block' );
									jQuery( '.js-ump-select-drip-content-end-time-on-specific-date' ).css( 'display', 'none' );
									break;
								case '3':
									jQuery( '.js-ump-select-drip-content-end-time-after-subscription' ).css( 'display', 'none' );
									jQuery( '.js-ump-select-drip-content-end-time-on-specific-date' ).css( 'display', 'block' );
									break;
							}
					});

			});



	jQuery(document).ready(function() {
		jQuery('#ihc_drip_start_certain_date').datepicker({
			dateFormat : 'dd-mm-yy',
			onClose: function( selectedDate ){
				jQuery( "#ihc_drip_end_certain_date" ).datepicker( "option", "minDate", selectedDate );
		    }
		});
		jQuery('#ihc_drip_end_certain_date').datepicker({
			dateFormat : 'dd-mm-yy',
			onClose: function( selectedDate ) {
				jQuery( "#ihc_drip_start_certain_date" ).datepicker( "option", "maxDate", selectedDate );
		    }
		});
	});

</script>
