<div class="ihc-subtab-menu">
	<a class="ihc-subtab-menu-item <?php echo (isset($_REQUEST['new_level']) && $_REQUEST['new_level'] =='true') ? 'ihc-subtab-selected' : '';?>" href="<?php echo $url.'&tab=levels&new_level=true';?>"> <?php _e('Add New Membership', 'ihc');?></a>
	<a class="ihc-subtab-menu-item <?php echo (!isset($_REQUEST['new_level'])) ? 'ihc-subtab-selected' : '';?>" href="<?php echo $url.'&tab=levels';?>"><?php _e('Manage Memberships', 'ihc');?></a>
	<a class="ihc-subtab-menu-item" href="<?php echo $url.'&tab=subscription_plan';?>"><?php _e('Subscription Plan Showcase', 'ihc');?></a>
	<div class="ihc-clear"></div>
</div>
<?php

echo ihc_inside_dashboard_error_license();
echo ihc_check_default_pages_set();//set default pages message
echo ihc_check_payment_gateways();
echo ihc_is_curl_enable();
do_action( "ihc_admin_dashboard_after_top_menu" );
?>
<div class="iump-wrapper">
<div id="col-right" style="vertical-align:top; width: 100%;">
<?php
include_once IHC_PATH . 'admin/includes/functions/levels.php';

if (isset($_POST['ihc_save_level']) && isset( $_POST['save_level'] ) && wp_verify_nonce( $_POST['save_level'], 'ihc_save_level' ) ){
	unset( $_POST['ihc_save_level'] );
	unset( $_POST['save_level'] );
	$results = \Indeed\Ihc\Db\Memberships::save( $_POST );
	if ( $results['success'] ){
			$_POST['id'] = $results['id'];
			$lid = ihc_save_level( $_POST );//save
	}
	if ($lid){
		/// MAGIC FEAT SETTINGS
		if (ihc_is_magic_feat_active('level_restrict_payment')){
			if (isset($_POST['ihc_level_restrict_payment_values'])){
				$ihc_level_restrict_payment_values = get_option('ihc_level_restrict_payment_values');
				$ihc_level_restrict_payment_values[$lid] = $_POST['ihc_level_restrict_payment_values'];
				update_option('ihc_level_restrict_payment_values', $ihc_level_restrict_payment_values);
			}
			if (isset($_POST['ihc_levels_default_payments'])){
				$ihc_levels_default_payments = get_option('ihc_levels_default_payments');
				$ihc_levels_default_payments[$lid] = $_POST['ihc_levels_default_payments'];
				update_option('ihc_levels_default_payments', $ihc_levels_default_payments);
			}
		}
		if (ihc_is_magic_feat_active('level_subscription_plan_settings')){
			if (isset($_POST['ihc_level_subscription_plan_settings_restr_levels'])){
				$restrict_arr = get_option('ihc_level_subscription_plan_settings_restr_levels');
				$restrict_arr[$lid] = $_POST['ihc_level_subscription_plan_settings_restr_levels'];
				update_option('ihc_level_subscription_plan_settings_restr_levels', $restrict_arr);
			}
			if (isset($_POST['ihc_level_subscription_plan_settings_condt'])){
				$conditions = get_option('ihc_level_subscription_plan_settings_condt');
				$conditions[$lid] = $_POST['ihc_level_subscription_plan_settings_condt'];
				update_option('ihc_level_subscription_plan_settings_condt', $conditions);
			}
		}
		do_action( 'ihc_admin_edit_save_level_after_submit_form', $lid, $_POST );
	}

	if ( !empty( $_POST['new_woo_product'] ) ){
		\Ihc_Db::unsign_woo_product_level_relation($lid);/// remove old relation
		update_post_meta($_POST['new_woo_product'], 'iump_woo_product_level_relation', $lid);/// update
	}

}

	if(isset($_REQUEST['edit_level']) || isset($_REQUEST['new_level'])){
		//add edit level
		?>
		<script>
			//date picker
			jQuery(document).ready(function() {
			    jQuery('#access_interval_start').datepicker({
			        dateFormat : 'dd-mm-yy'
			    });
			    jQuery('#access_interval_end').datepicker({
			        dateFormat : 'dd-mm-yy'
			    });
			});
		</script>
		<form method="post" action="<?php echo $url.'&tab=levels';?>">
			<div class="ihc-stuffbox">
				<?php
				if(isset($_REQUEST['edit_level'])){
					$level_data = ihc_return_meta('ihc_levels', $_REQUEST['edit_level']);
					$label = __('Edit Membership Plan', 'ihc');
				}else{
					$order = 0;
					$level_arr = get_option('ihc_levels');
					if ($level_arr && count($level_arr)) $order = count($level_arr);
					$level_data = array( 'name'=>'',
										 'payment_type' => 'free',
										 'price' => '',
										 'label' => '',
										 //developer
										 'short_description' => '',
										 //end developer
										 'description'=>'',
										 'price_text' => '',
										 'order' => $order,
										 'access_type' => 'unlimited',
										 'access_limited_time_type' => 'D',
										 'access_limited_time_value' => '',
										 'access_interval_start' => '',
										 'access_interval_end' => '',
										 'access_regular_time_type' => 'D',
										 'access_regular_time_value' => '',
										 'billing_type' => '',
										 'billing_limit_num' => '2',
										 'show_on' => '1',
										 'afterexpire_level' => -1,
										 'custom_role_level' => '',
										 'start_date_content' => '0',
										 'special_weekdays' => '',
										 //trial
										 'access_trial_time_value' => '',
										 'access_trial_time_type' => 'D',
										 'access_trial_price' => '',
										 'access_trial_couple_cycles' => 1,
										 'access_trial_type' => 1,
										);
					$label = __('Add New Membership Plan', 'ihc');
				}

				/////////for old versions of indeed membership pro
				$check_arr = array( 'access_type'=>'unlimited',
									'access_limited_time_type'=>'D',
									'access_limited_time_value' => '',
									'access_interval_start' => '',
									'access_interval_end' => '',
									'access_regular_time_type' => 'D',
									'access_regular_time_value' => '',
									'billing_type' => '',
									'billing_limit_num' => 2,
									'show_on' => '1',
									'price_text' => '',
									'afterexpire_level' => -1,
									'custom_role_level' => '',
									'start_date_content' => '0',
									'special_weekdays' => '',
									//developer
									'short_description' => '',
									//end developer
									//trial
									'access_trial_time_value' => '',
									'access_trial_time_type' => 'D',
									'access_trial_price' => '',
									'access_trial_couple_cycles' => 1,
									'access_trial_type' => 1,
									);
				foreach ($check_arr as $k=>$v){
					if (!isset($level_data[$k])){
						$level_data[$k] = $v;
					}
				}

				/////////for old versions of indeed membership pro

				?>
				<h3>
					<?php echo $label?>
				</h3>

				<div class="inside">
                 <div class="iump-form-line iump-no-border">
                 <h2><?php _e('Main Membership details', 'ihc');?></h2>
                 <p><?php _e('Customize Membership with a public name and a unique slug', 'ihc');?></p>
                 </div>
                 <div class="iump-form-line iump-no-border">
                <div class="row" style="margin-left:0px;">
                	<div class="col-xs-4">
                             <div class="input-group">
                                <span class="input-group-addon"><?php _e('Membership Name', 'ihc');?></span>
                                <input name="label" class="form-control" type="text" value="<?php echo $level_data['label'];?>" placeholder="<?php _e('suggestive Membership Name', 'ihc');?>"/>
                             </div>
                     </div>
                 </div>
                 </div>

                 <div class="iump-form-line iump-no-border">
                <div class="row" style="margin-left:0px;">
                	<div class="col-xs-4">
                             <div class="input-group">
                                <span class="input-group-addon"><?php _e('Membership Slug', 'ihc');?></span>
                                <input name="name" class="form-control" type="text" value="<?php echo $level_data['name'];?>" id="level_slug_id" onBlur="ihcUpdateLevelSlugSpan();"   placeholder="<?php _e('ex: unique_plan_slug', 'ihc');?>"/>
                                <input type="hidden" name="order" value="<?php echo $level_data['order'];?>" />
                            </div>
                            <p><?php _e('Slug must be uinque and based only on lowercase characters without extra spaces or symbols. Slug will not be visible for customers or on front-end side.', 'ihc');?></p>
                    </div>

                </div>
                </div>
								<!-- developer -->
								 <div class="iump-form-line iump-no-border">
									 <div class="row" style="margin-left:0px;">
										<div class="col-xs-4">
																<div class="input-group">
																	 <h4><?php _e('Membership Short Description', 'ihc');?></h4>
																	   <textarea name="short_description" class="form-control" rows="2" cols="125" placeholder="<?php _e('write a short description', 'ihc');?>"><?php echo isset( $level_data['short_description'] ) ? stripslashes($level_data['short_description']) : ''; ?></textarea>
								 								 </div>
											</div>
										</div>
									</div>
								<!-- end developer-->
					<div class="iump-special-line ihc-level-access-section">
					<h2><?php _e('Membership Access', 'ihc');?></h2>
					<p><?php _e('If you wish to have Recurring steps choose "Regular Period" type. All others have OneTime step.', 'ihc');?></p>
						<div class="iump-form-line iump-no-border form-required">
							<label for="tag-name" class="iump-labels"><?php _e('Access Type', 'ihc');?></label>

								<select name="access_type" onChange="ihcAccessPaymentType(this.value);" class="iump-form-select ihc-form-element ihc-form-element-select ihc-form-select" style="max-width:400px;">
									<?php
										$v_arr = array( 'unlimited' => 'LifeTime',
														'limited' => 'Limited Time',
														'date_interval' => 'Date Range',
														'regular_period' => 'Recurring Subscription',
													);
										foreach ($v_arr as $k=>$v){
											$selected = ($level_data['access_type']==$k) ? 'selected' : '';
											?>
												<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
											<?php
										}
									?>
								</select>

						</div>

						<div id="limited_access_metas" style="margin-top: 10px; display: <?php if ($level_data['access_type']=='limited') echo 'block'; else echo 'none';?>">
							<div>
								<label for="tag-name" class="iump-labels"><?php _e('Only for:', 'ihc');?></label>
								<input type="number" value="<?php echo $level_data['access_limited_time_value'];?>" name="access_limited_time_value" min="1" max="31" style="vertical-align:middle; margin-right:5px; width:97px;"/>
								<select name="access_limited_time_type" style="min-width:150px;">
									<?php
										$time_types = array('D'=>'Days', 'W'=>'Weeks', 'M'=>'Months', 'Y'=>'Years',);
										foreach ($time_types as $k=>$v){
											$selected = ($level_data['access_limited_time_type']==$k) ? 'selected' : '';
											?>
												<option value="<?php echo $k;?>" <?php echo $selected;?>><?php echo $v;?></option>
											<?php
										}
									?>
								</select>
							</div>
							<div>


							</div>
						</div>

						<div id="date_interval_access_metas" style="margin-top: 10px; display: <?php if ($level_data['access_type']=='date_interval') echo 'block'; else echo 'none';?>">
							<div style="margin-bottom:10px;">
								<label for="tag-name" class="iump-labels"><?php _e('Starts on:', 'ihc');?></label>
								<input type="text" value="<?php echo $level_data['access_interval_start'];?>" name="access_interval_start" id="access_interval_start" />
							</div>
							<div>
								<label for="tag-name" class="iump-labels"><?php _e('Expires on:', 'ihc');?></label>
								<input type="text" value="<?php echo $level_data['access_interval_end'];?>" name="access_interval_end" id="access_interval_end"/>
							</div>
						</div>

						<div id="regular_period_access_metas" style="margin-top: 10px; display: <?php if ($level_data['access_type']=='regular_period') echo 'block'; else echo 'none';?>">
							<div>
								<label for="tag-name" class="iump-labels"><?php _e('Subscription Cycle:', 'ihc');?></label>
								<input type="number" value="<?php echo $level_data['access_regular_time_value'];?>" name="access_regular_time_value" min="1"  style="vertical-align:middle; margin-right:5px;  width:97px;"/>
								<select name="access_regular_time_type" style="min-width:150px;">
									<?php
										$time_types = array('D'=>'Days', 'W'=>'Weeks', 'M'=>'Months', 'Y'=>'Years',);
										foreach ($time_types as $k=>$v){
											$selected = ($level_data['access_regular_time_type']==$k) ? 'selected' : '';
											?>
												<option value="<?php echo $k;?>" <?php echo $selected;?>><?php echo $v;?></option>
											<?php
										}
									?>
								</select>
							</div>
							<?php
								$pay_stat = ihc_check_payment_status('braintree');
								$display = ($pay_stat['active']=='braintree-active' && $pay_stat['settings']=='Completed') ? 'block' : 'none';
							?>
							<div style=" margin: 5px 0 0 180px; max-width: 700px; <?php echo 'display: ' . $display; ?> ">
								<?php echo __('<strong>Braintree</strong> gateway supports only "Months" period time and you have to create a Plan in Your Braintree Account Page with Plan ID set as  ', 'ihc') . '<strong><span class="plan-slug-name"></span></strong>';?>
							</div>
							<?php
								$pay_stat = ihc_check_payment_status('authorize');
								$display = ($pay_stat['active']=='authorize-active' && $pay_stat['settings']=='Completed') ? 'block' : 'none';
							?>
							<div style=" margin: 5px 0 0 180px; <?php echo 'display: ' . $display; ?>">
								<?php echo __('<strong>Authorize.net</strong> gateway requires the minimum time value for recurring payments at least 7 days.', 'ihc');?>
							</div>
                            <?php
								$pay_stat = ihc_check_payment_status('paypal');
								$display = ($pay_stat['active']=='paypal-active' && $pay_stat['settings']=='Completed') ? 'block' : 'none';
							?>
							<div style=" margin: 5px 0 0 180px; <?php echo 'display: ' . $display; ?>">
								<?php echo __('<strong>PayPal</strong> gateway allows recurring periods no more than 12 months.', 'ihc');?>
							</div>
						</div>
						<div class="iump-form-line iump-no-border form-required" id="set_expired_level" style="margin-top: 30px; display: <?php if (isset($level_data['access_type']) && $level_data['access_type']!='unlimited') echo 'block'; else echo 'none';?>">
							<div>
								<label for="tag-name" class="iump-labels"><?php _e('After Expire move to:', 'ihc');?></label>

								<select name="afterexpire_level">
									<option value="-1" <?php if ($level_data['afterexpire_level']=='-1') echo 'selected';?>>...</option>
									<?php
									$additional_levels = get_option('ihc_levels');
									if (isset($_GET['edit_level'])){
										if (isset($additional_levels[$_GET['edit_level']])){
											unset($additional_levels[$_GET['edit_level']]);
										}
									}
										if (isset($additional_levels) && count($additional_levels)){
											foreach ($additional_levels as $k=>$v){
													$selected = ($level_data['afterexpire_level']==$k) ? 'selected' : '';
													?>
														<option value="<?php echo $k;?>" <?php echo $selected;?>><?php echo $v['name'];?></option>
													<?php
											}
										}
									?>
								</select>
							</div>
						</div>
					 </div>
					<div class="inside" style="margin-bottom:30px;">
                     <div class="iump-form-line iump-no-border">
						<h2><?php _e('Additional Access Settings', 'ihc');?></h2>
                        <p><?php _e('Optional setttings that may be necessary to customize membership workflow.', 'ihc');?></p>
                    </div>
						<div class="iump-form-line iump-no-border">
							<h4><?php _e('Custom Member WordPress Role', 'ihc');?></h4>
                            <div style="font-style:italic; color:#999;"><?php _e('Available only during the registration step for new Registered users.', 'ihc');?></div>
                            <div>
							<select name="custom_role_level"  class="iump-form-select ihc-form-element ihc-form-element-select ihc-form-select" >
								<option value="-1"><?php _e('...Default Register option', 'ihc');?></option>
								<?php
									$roles = ihc_get_wp_roles_list();
									if ($roles){
										foreach ($roles as $k=>$v){
											$selected = ($level_data['custom_role_level']==$k) ? 'selected' : '';
											?>
												<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
											<?php
										}
									}
								?>
							</select>
                            </div>

						</div>

						<div class="iump-form-line iump-no-border" style="display: none;">
							<h4><?php _e('Show Only Content created Starting with the Assigned Date', 'ihc');?></h4>
							<div style="margin-top:10px;">
							<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
								<?php $checked = ($level_data['start_date_content'] == 1) ? 'checked' : '';?>
								<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#start_date_content');" <?php echo $checked;?> />
								<div class="switch" style="display:inline-block;"></div>
							</label>
							<input type="hidden" value="<?php echo $level_data['start_date_content'];?>" name="start_date_content" id="start_date_content" />
							</div>
							<div style="font-style:italic; color:#999; margin-top:4px;"><?php _e('Available only for Pages and Posts', 'ihc');?></div>
						</div>

						<div class="iump-form-line iump-no-border" style="margin-top:10px;">

							<h4><?php _e('Special Week days Membership is running', 'ihc');?></h4>
                            <div style="font-style:italic; color:#999;"><?php _e('Based on Server/Website Time', 'ihc');?></div>
                            <div>
							<select name="special_weekdays"  class="iump-form-select ihc-form-element ihc-form-element-select ihc-form-select" >
								<?php
									$day_type = array(
														 '' => __('Entire Week', 'ihc'),
														 'weekdays' => __('WeekDays', 'ihc'),
														 'weekend' => __('WeekEnd', 'ihc'),
														);
									foreach($day_type as $k=>$v){
										?>
											<option value="<?php echo $k;?>" <?php if($k==$level_data['special_weekdays'])echo 'selected';?> ><?php echo $v;?></option>
										<?php
									}
								?>
							</select>
                            </div>

							<div style="color:#999;"><?php _e('Ex: Membership "Test01" has the Special Week Days set to WeekDays. "Test01" is restricted from viewing certain content on the website. During the WeekEnd "Test01" will not be restricted. ', 'ihc');?></div>
						</div>
					</div>


					<div class="iump-special-line ihc-level-billing-section">
						<h2><?php _e('Membership Billing', 'ihc');?></h2>

						<div class="iump-form-line iump-no-border form-required">
							<label for="tag-name" class="iump-labels"><?php _e('Payment Type', 'ihc');?></label>
							<select class="iump-form-select ihc-form-element ihc-form-element-select ihc-form-select" name="payment_type" onChange="ihcSelectShDiv(this, '#payment_options', 'payment');" style="max-width:400px;">
								<?php
									$price_type = array(
														 'free' => __('Free', 'ihc'),
														 'payment' => __('Payment', 'ihc'),
														);
									foreach($price_type as $k=>$v){
										?>
											<option value="<?php echo $k;?>" <?php if($k==$level_data['payment_type'])echo 'selected';?> ><?php echo $v;?></option>
										<?php
									}
								?>
							</select>
						</div>

					<div id="payment_options"  style="<?php if ($level_data['payment_type']=='free') echo 'display: none;'; else echo 'display: block;' ?>" >
						<div class="iump-form-line iump-no-border" id="level_price_wd" style="" >
							<div>
								<label for="tag-name" class="iump-labels"><?php _e('Membership Price', 'ihc');?></label>
                                <div style="display:inline-block;     max-width: 400px; vertical-align: middle;">
                                	<div class="input-group">
                                        <input type="number" min="0.01" value="<?php echo $level_data['price'];?>" name="price" step="0.01" class="form-control"/>
                                        <div class="input-group-addon">
                                        <?php
                                            $currency = get_option('ihc_currency');
                                            if ($currency==FALSE){
                                                $currency = 'USD';
                                            }
                                            echo $currency;
                                        ?>
                                        </div>
                                     </div>
                                </div>
								<div style="font-size: 11px; margin-left: 185px;"><?php _e("<strong>Stripe Standard</strong> gateway requires at least 0.50".$currency." subscription price")?></div>
							</div>
						</div>

						<div class="iump-form-line iump-no-border form-required">
							<label for="tag-name" class="iump-labels" id="billind_rec_label"><?php _e('Recurring Subscription Time', 'ihc');?></label>
							<select disabled="disabled" id="billing_type_1" style="<?php if ($level_data['access_type']=='regular_period') echo 'display: none;'; else echo 'display: inline-block;' ?>">
								<option value="bl_onetime" >One Time</option>
							</select>
							<select name="billing_type" id="billing_type_2" onChange="ihcCheckBillingType(this.value);" style="<?php if ($level_data['access_type']=='regular_period') echo 'display: inline-block;'; else echo 'display: none;' ?>">
								<option value="bl_ongoing" <?php if (!empty($level_data['billing_type']) && $level_data['billing_type']=='bl_ongoing') echo 'selected';?> >On Going</option>
								<option value="bl_limited" <?php if (!empty($level_data['billing_type']) && $level_data['billing_type']=='bl_limited') echo 'selected';?> >Limited</option>
							</select>
						</div>

						<?php
							$display = 'none';
							if ($level_data['access_type']=='regular_period' && isset($level_data['billing_type']) && $level_data['billing_type']=='bl_limited'){
								$display = 'block';
							}
						?>
						<div class="iump-form-line iump-no-border" id="regular_period_billing" style="display: <?php echo $display;?>;">
							<label for="tag-name" class="iump-labels"><?php _e('Max no of Periods', 'ihc');?></label>
							<input type="number" min="2" value="<?php if (!empty($level_data['billing_limit_num'])) echo $level_data['billing_limit_num'];?>" max="52" name="billing_limit_num"  />
						</div>

						<?php
							$display = 'none';
							if ($level_data['access_type']=='regular_period' && isset($level_data['payment_type']) && $level_data['payment_type']=='payment'){
								$display = 'block';
							}
						?>
						<div class="iump-no-border" id="trial_period_billing" style=" margin: 10px 0; display: <?php echo $display;?>;">
                        <h2><?php _e('Trial/Initial Payment Settings', 'ihc');?></h2>
                        <p><?php _e('Setup trial or initial payment details only if you wish your Subscription to have one. Otherwise leave next fields <strong>empty</strong>', 'ihc');?></p>
							<div class="iump-form-line iump-no-border" >
								<label for="tag-name" class="iump-labels" style="letter-spacing: -0.3px;"><?php _e('Trial/Initial Payment Price', 'ihc');?></label>
                                <div style="display:inline-block;     max-width: 400px; vertical-align: middle;">
                                          <div class="input-group">
                                                  <input type="number" value="<?php echo $level_data['access_trial_price'];?>" name="access_trial_price" min="0" step="0.01" style="vertical-align:middle; margin-right:5px;"  class="form-control"/>
                                                  <div class="input-group-addon">
                                                  <?php
                                                      echo $currency;
                                                  ?>
                                                  </div>
                                      </div>
                                </div>
                                <div style="font-size: 12px;margin-left: 185px;   font-weight: bold; color: #cf414a; margin-bottom:5px;"><?php
									_e('If you wish to setup Trial/Initial Payment as free you must set the price to 0'. $currency.'', 'ihc');
								?></div>
								<div style="font-size: 11px;margin-left: 185px;   font-weight: bold;"><?php
									_e('Stripe Standard and Braintree supports only 0'. $currency.' Trial/Initial Payment price ', 'ihc');
								?></div>
							</div>
							<div class="iump-form-line iump-no-border">
								<label for="tag-name" class="iump-labels"><?php _e('Trial Period Type', 'ihc');?></label>
								<select name="access_trial_type" onChange="ihcChangeTrialType(this.value);">
									<?php
										$types = array('1' => __('Certain Period', 'ihc'), '2' => __('Couple cycles subscription payments', 'ihc'));
										foreach ($types as $k=>$v){
											$selected = ($level_data['access_trial_type']==$k) ? 'selected' : '';
											?>
												<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
											<?php
										}
									?>
								</select>
							</div>
							<div class=""  id="trial_certain_period" style="display: <?php if ($level_data['access_trial_type']==1) echo 'block'; else echo 'none';?>;">
								<label for="tag-name" class="iump-labels"><?php _e('Trial Certain Period', 'ihc');?></label>
								<input type="number" value="<?php echo $level_data['access_trial_time_value'];?>" name="access_trial_time_value" min="1" max="31" style="vertical-align:middle; margin-right:5px; width:97px;"/>
									<select name="access_trial_time_type" style="min-width:200px;">
										<?php
											$access_time_types = array('D'=>'Days', 'W'=>'Weeks', 'M'=>'Months', 'Y'=>'Years',);
											foreach ($access_time_types as $k=>$v){
												$selected = ($level_data['access_trial_time_type']==$k) ? 'selected' : '';
												?>
													<option value="<?php echo $k;?>" <?php echo $selected;?>><?php echo $v;?></option>
												<?php
											}
										?>
									</select>
								<div style="font-size: 11px;margin-left: 185px; font-weight: bold;"><?php
									_e('Certain Period workflow is not supported by Authorize.net and 2Checkout gateways.', 'ihc');
								?></div>
							</div>
							<div class="iump-form-line iump-no-border"  id="trial_couple_cycles" style="display: <?php if ($level_data['access_trial_type']==2) echo 'block'; else echo 'none';?>;">
								<label for="tag-name" class="iump-labels"><?php _e('Trial Couple Cycles:', 'ihc');?></label>
								<input type="number" value="<?php echo $level_data['access_trial_couple_cycles'];?>" name="access_trial_couple_cycles" min="1" style="vertical-align:middle; margin-right:5px;"/>
                                <?php
								$pay_stat = ihc_check_payment_status('twocheckout');
								$display = ($pay_stat['active']=='twocheckout-active' && $pay_stat['settings']=='Completed') ? 'block' : 'none';
									?>
								<div style="font-size: 11px; margin-left: 185px;  font-weight: bold;  <?php echo 'display: ' . $display; ?>" ><?php
									_e('Not more than 1 cycle for 2Checkout gateways.', 'ihc');
								?></div>
								<div class="ihc-clear"></div>
                                <?php
								$pay_stat = ihc_check_payment_status('braintree');
								$display = ($pay_stat['active']=='braintree-active' && $pay_stat['settings']=='Completed') ? 'block' : 'none';
									?>
								<div style="font-size: 11px;margin-left: 185px; <?php echo 'display: ' . $display; ?>" ><?php
									_e('If You use Braintree the trial period must be set into Plan Details too.', 'ihc');
								?></div>
							</div>

						</div>

					</div>


					</div>
					<div class="form-field inside" style="margin-bottom:25px;">
                     	<div class="iump-form-line iump-no-border">
							<h2>"Membership Plan" Page details</h2>
                    	</div>
						<div class="iump-form-line iump-no-border">
						<h4><?php _e('Show/Hide in Subscription Plan showcase', 'ihc');?></h4>
                        <p><?php _e('If you choose to hide the membership on front-end showcase, it will still be active but users will not find it into default Subscription plan showcase to Sign Up on their own choice', 'ihc');?></p>
						<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
								<?php $checked = ($level_data['show_on'] == 1) ? 'checked' : '';?>
								<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '#show_on');" <?php echo $checked;?> />
								<div class="switch" style="display:inline-block;"></div>
							</label>
							<input type="hidden" value="<?php echo $level_data['show_on'];?>" name="show_on" id="show_on" />
						</div>
                        <div  class="iump-form-line iump-no-border">
						<h4><?php _e('Membership Description', 'ihc');?></h4>
                        <p><?php _e('How membership is described on Subscription Plan showcase may attract customers to Sign Up', 'ihc');?></p>
                        <div style="max-width:900px;">
						<?php
							$settings = array(
												'media_buttons' => true,
												'textarea_name'=>'description',
												'textarea_rows' => 5,
												'tinymce' => true,
												'quicktags' => true,
												'teeny' => true,
											);
							wp_editor(ihc_correct_text($level_data['description']), 'tag-description', $settings);
						?>
						</div>
						<h4><?php _e('Membership Price details', 'ihc');?></h4>
						<input name="price_text" type="text" value="<?php echo $level_data['price_text'];?>" style="max-width:200px;">
						<div style="font-size: 11px;" ><?php
									_e('It will not change the Membership price but just describes the costs.', 'ihc');
								?>
                       </div>
					  </div>
					</div>
					<div class="ihc-stuffbox-submit-wrap iump-submit-form">
						<input type="hidden" name="save_level" value="<?php echo wp_create_nonce( 'ihc_save_level' );?>" />
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" id="ihc_submit_bttn" name="ihc_save_level" class="button button-primary button-large" />
					</div>

					<?php
						if(isset($_REQUEST['edit_level'])){
							?>
							<input type="hidden" name="level_id" value="<?php echo $_REQUEST['edit_level'];?>" />
							<?php
						}
					?>
				</div>
			</div>

<?php
$lid = (isset($_GET['edit_level'])) ? $_GET['edit_level'] : -1;
$levels = get_option('ihc_levels');
?>

	<!-- BEGIN RESTRICT PAYMENT -->
	<?php if (ihc_is_magic_feat_active('level_restrict_payment') && $lid!=-1 && $levels[$lid]['payment_type']!='free'):?>
		<?php
			$data['metas'] = ihc_return_meta_arr('level_restrict_payment');//getting metas
			$default_payment = get_option('ihc_payment_selected');
			$payments = ihc_get_active_payments_services();
			if ($lid!=-1 && !empty($data['metas']['ihc_levels_default_payments'][$lid])){
				$default_payment_for_level = $data['metas']['ihc_levels_default_payments'][$lid];
			} else {
				$default_payment_for_level = -1;
			}
			$temp_payments = $payments;
			unset($temp_payments[$default_payment]);
			$current_default_label = $payments[$default_payment];
		?>
		<div class="ihc-stuffbox ihc-stuffbox-magic-feat">
				<h3 class="ihc-h3"><?php _e('Payment Gateways restriction', 'ihc');?> <span style="color:#222 !important;">(<?php _e('Magic Feature', 'ihc');?>)</span></h3>
			<div class="inside">
				<div class="iump-form-line">
					<div>
						<h4><?php _e('Default Payment:', 'ihc');?></h4>
						<select name="ihc_levels_default_payments">
							<option value="-1" <?php if ($k==-1) echo 'selected';?> ><?php echo __('Current Default Payment ', 'ihc') . '(' . $current_default_label . ')';?></option>
							<?php foreach ($temp_payments as $k=>$v):?>
								<?php $selected = ($k==$default_payment_for_level) ? 'selected' : '';?>
								<option value="<?php echo $k;?>" <?php echo $selected;?> ><?php echo $v;?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
				<div class="iump-form-line">
					<?php
						if ($lid!=-1 && isset($data['metas']['ihc_level_restrict_payment_values'][$lid])){
							$excluded_values = $data['metas']['ihc_level_restrict_payment_values'][$lid];
							$excluded_values_array = explode(',', $excluded_values);
						} else {
							$excluded_values = '';
							$excluded_values_array = array();
						}
					?>
						<h4><?php _e('Payment Available:', 'ihc');?></h4>
						<?php foreach ($payments as $k=>$v):?>
							<?php $checked = (!in_array($k, $excluded_values_array)) ? 'checked' : '';?>
							<div class="ihc-inline-block-item">
								<input type="checkbox" onClick="ihcAddToHiddenWhenUncheck(this, '<?php echo $k;?>', '<?php echo '#' . $lid . 'excludedforlevel';?>');" <?php echo $checked;?> />
								<img src="<?php echo IHC_URL . 'assets/images/'.$k.'.png';?>" class="ihc-payment-icon ihc-payment-select-img-selected" style="margin:0 14px 0 5px;   width: auto !important; height:35px;" />
							</div>
						<?php endforeach;?>
						<input type="hidden" name="ihc_level_restrict_payment_values" value="<?php echo $excluded_values;?>" id="<?php echo $lid . 'excludedforlevel';?>"/>
				</div>

				<div class="ihc-submit-form" style="margin-top: 20px;">
					<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save_level" class="button button-primary button-large" />
				</div>
			</div>
		</div>
	<?php endif;?>
	<!-- END OF RESTRICT PAYMENT -->


	<!-- BEGIN Level - Subscription Plan Display Details -->
	<?php if (ihc_is_magic_feat_active('level_subscription_plan_settings')):?>
		<?php
			$data['metas'] = ihc_return_meta_arr('level_subscription_plan_settings');//getting metas
			$hidden_value = ($lid!=-1 && !empty($data['metas']['ihc_level_subscription_plan_settings_condt'][$lid])) ? $data['metas']['ihc_level_subscription_plan_settings_condt'][$lid] : '';
			$hidden_arr = array();
			if (!empty($hidden_value)){
				$hidden_arr = explode(',', $hidden_value);
			}
		?>
			<div class="ihc-stuffbox ihc-stuffbox-magic-feat">
					<h3 class="ihc-h3"><?php _e('Subscription Plan Display Details', 'ihc');?> <span style="color:#222 !important;">(<?php _e('Magic Feature', 'ihc');?>)</span></h3>
				<div class="inside">
					<div class="iump-form-line">
						<label><?php _e('Activate Restriction', 'ihc');?></label>
						<div>
							<label class="iump_label_shiwtch" style="margin:10px 0 10px -10px;">
								<?php $checked = ($lid!=-1 && !empty($data['metas']['ihc_level_subscription_plan_settings_restr_levels'][$lid])) ? 'checked' : '';?>
								<input type="checkbox" class="iump-switch" onClick="iumpCheckAndH(this, '<?php echo '#ihc_level_subscription_plan_settings_restr_levels'.$lid;?>');" <?php echo $checked;?> />
								<div class="switch" style="display:inline-block;"></div>
							</label>
							<input type="hidden" name="ihc_level_subscription_plan_settings_restr_levels" value="<?php echo $hidden_value;?>" id="<?php echo 'ihc_level_subscription_plan_settings_restr_levels'.$lid;?>" />
						</div>
					</div>

					<div class="iump-form-line">
						<h4><?php _e('User never bought:', 'ihc');?></h4>
						<div>
							<?php $checked = (in_array('unreg', $hidden_arr)) ? 'checked' : '';?>
							<input type="checkbox" <?php echo $checked;?> onClick="ihcMakeInputhString(this, 'unreg', '<?php echo '#levelcond';?>');" /><span style="font-weight:bold; vertical-align:bottom;"> <?php _e('UnRegistered Users', 'ihc');?></span>
						</div>
						<div>
							<?php $checked = (in_array('no_pay', $hidden_arr)) ? 'checked' : '';?>
							<input type="checkbox" <?php echo $checked;?> onClick="ihcMakeInputhString(this, 'no_pay', '<?php echo '#levelcond';?>');" /><span style="font-weight:bold; vertical-align:bottom;"> <?php _e('Registered Users with no payment made', 'ihc');?></span>
						</div>
						<h4 style="margin-top: 24px;"><?php _e('User already bought: ', 'ihc');?></h4>
						<?php foreach ($levels as $levelid=>$larr):?>
							<?php $spanclass = ($levelid==$lid) ? 'ihc-magic-feat-bold-span' : '';?>
							<div style="margin: 0px 4px; margin-right:12px; display: inline-block; vertical-align: top; font-weight:bold;">
								<?php $checked = (in_array($levelid, $hidden_arr)) ? 'checked' : '';?>
								<input type="checkbox" <?php echo $checked;?> onClick="ihcMakeInputhString(this, '<?php echo $levelid;?>', '<?php echo '#levelcond';?>');" /> <span style="vertical-align: bottom;"  class="<?php echo $spanclass;?>"><?php echo $larr['label'];?></span>
							</div>
						<?php endforeach;?>
						<input type="hidden" name="ihc_level_subscription_plan_settings_condt" id="<?php echo 'levelcond';?>" value="<?php echo $hidden_value;?>" />
					</div>

					<div class="ihc-submit-form" style="margin-top: 20px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save_level" class="button button-primary button-large" />
					</div>
				</div>
			</div>
	<?php endif;?>
	<!-- END Level - Subscription Plan Display Details -->

	<!-- START WooCommerce Payment Inttegration -->
	<?php if (ihc_is_magic_feat_active('woo_payment') && $lid!=-1 && $levels[$lid]['payment_type']!='free'):?>
			<div class="ihc-stuffbox ihc-stuffbox-magic-feat">
					<h3 class="ihc-h3"><?php _e('WooCommerce Product - Level Relation', 'ihc');?> <span style="color:#222 !important;">(<?php _e('Magic Feature', 'ihc');?>)</span></h3>
				<div class="inside">
					<div class="iump-form-line">
						<?php
							$product_id = Ihc_Db::get_woo_product_id_for_lid($lid);
							if ($product_id):
								$product_name = get_the_title($product_id);
						?>
							<div id="iump_current_product_level"><?php _e('Current Product assign: ', 'ihc');?><a href="<?php echo admin_url('post.php?post=' . $product_id . '&action=edit');?>" target="_blank"><?php echo $product_name;?></a>
								<i class="fa-ihc ihc-icon-remove-e" style="cursor: pointer;" onclick="jQuery('#iump_change_level_product_relation').css('display', 'block');jQuery('#iump_current_product_level').css('display', 'none');"></i>
							</div>
						<?php
							$display_hidden = 'display: none;';
							else :
								$display_hidden = 'display: block;';
							endif;
						?>
						<div id="iump_change_level_product_relation" style="<?php echo $display_hidden;?>">
							<span><?php _e('Products', 'ihc');?></span>
							<input type="text"  class="form-control" value="" name="" id="reference_search" />
							<input type="hidden" name="new_woo_product" value=""/>
						</div>
					</div>
					<div class="ihc-submit-form" style="margin-top: 20px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save_level" class="button button-primary button-large" />
					</div>
				</div>
			</div>
			<script>
			jQuery(function() {
			    /// REFERENCE SEARCH
				jQuery( "#reference_search" ).bind( "keydown", function(event){
					if ( event.keyCode === jQuery.ui.keyCode.TAB &&
						jQuery(this).autocomplete( "instance" ).menu.active){
					 	event.preventDefault();
					}
				}).autocomplete({
					focus: function( event, ui ){},
					minLength: 0,
					source: '<?php echo IHC_URL . 'admin/ajax-custom.php';?>',
					select: function( event, ui ) {
						jQuery('[name=new_woo_product]').val(ui.item.id);
						jQuery('#reference_search').val(ui.item.label);
					 	return false;
					}
				});
			});

			</script>
	<?php endif;?>
	<!-- END WooCommerce Payment Inttegration -->

	<!-- HOOK some extra html here --->
			<?php do_action('ihc_level_admin_html', $level_data, $lid );?>
	<!-- /HOOK some extra html here --->

	<!-- BADGES -->
	<?php if (ihc_is_magic_feat_active('badges')):?>
			<div class="ihc-stuffbox ihc-stuffbox-magic-feat">
				<h3 class="ihc-h3"><?php _e('Membership Badges', 'ihc');?> <span style="color:#222 !important;">(<?php _e('Magic Feature', 'ihc');?>)</span></h3>
				<div class="inside">
					<div class="iump-form-line">
						<?php if (empty($level_data['badge_image_url'])) $level_data['badge_image_url'] = '';?>
						<input type="text" class="form-control" onclick="openMediaUp(this);" value="<?php echo $level_data['badge_image_url'];?>" name="badge_image_url" id="badge_image_url" style="width: 90%;display: inline; float:none; min-width:500px;">
						<i class="fa-ihc ihc-icon-remove-e" onclick="jQuery('#badge_image_url').val('');" title="Remove Badge"></i>
					</div>
					<div class="ihc-submit-form" style="margin-top: 20px;">
						<input type="submit" value="<?php _e('Save Changes', 'ihc');?>" name="ihc_save_level" class="button button-primary button-large" />
					</div>
				</div>
			</div>
	<?php endif;?>
	<!-- BADGES -->

</form>

		<?php
	} else {
		//manage
		?>

		<div class="iump-page-title">Ultimate Membership Pro -
			<span class="second-text">
				<?php _e('Membership Plans', 'ihc');?>
			</span>
		</div>

		<div class="clear"></div>
		<a href="<?php echo $url.'&tab=levels&new_level=true';?>" class="indeed-add-new-like-wp">
			<i class="fa-ihc fa-add-ihc"></i><?php _e('Add New Membership', 'ihc');?>
		</a>
		<span class="ihc-top-message"><?php _e('...free/paid Memberships with single payments or recurring Subscriptions!', 'ihc');?></span>
	<form style="margin-top:20px;">
			<div>
				<?php
					$levels = get_option('ihc_levels');
					$levels = ihc_reorder_arr($levels);
					$currency = get_option('ihc_currency');
					$woo_payment = ihc_is_magic_feat_active('woo_payment');
					if (!$currency) $currency = '';
					if($levels && count($levels)){
						?>
							<div onclick="ihcSortableOnOff(this, '#ihc-levels-table tbody');" class="ihc-sortable-off" id="ihc-bttn-on-off-sortable">
								<?php _e('ReOrder Memberships', 'ihc');?>
							</div>
							<div id="ihc-reorder-msg" style="display: none;"> << <?php _e('Now You can reorder Memberships.', 'ihc');?></div>

							<div class="iump-rsp-table ihc-sortable-table-wrapp">
								<table class="wp-list-table widefat fixed tags ihc-admin-tables" id='ihc-levels-table'>
									  <thead>
										<tr>
											  <th class="manage-column"  style="width:40px;">
												  <span>
													<?php _e('Show', 'ihc');?>
												  </span>
											  </th>
												<th class="manage-column" style="width:40px;">
												 <span>
												 <?php _e('ID', 'ihc');?>
												 </span>
											 </th>
											  <th class="manage-column">
												  <span>
													<?php _e('Slug', 'ihc');?>
												  </span>
											  </th>
											  <th class="manage-column">
												  <span>
													<?php _e('Name', 'ihc');?>
												  </span>
											  </th>
											  <?php if ($woo_payment):?>
											  <th class="manage-column">
												  <span>
													<?php _e('Woocommerce Product', 'ihc');?>
												  </span>
											  </th>
											  <?php endif;?>
											  <th class="manage-column" >
												  <span>
													<?php _e('Membership Type', 'ihc');?>
												  </span>
											  </th>
											  <th class="manage-column" >
												  <span>
													<?php _e('Billing Type', 'ihc');?>
												  </span>
											  </th>
											   <th class="manage-column" >
												  <span>
													<?php _e('Recurrences', 'ihc');?>
												  </span>
											  </th>
											  <th class="manage-column" >
												  <span>
													<?php _e('Price', 'ihc');?>
												  </span>
											  </th>
											  <th class="manage-column" >
												  <span>
													<?php _e('Membership Link', 'ihc');?>
												  </span>
											  </th>
									    </tr>
									  </thead>

									  <tfoot>
										<tr>
											  <th class="manage-column">
												  <span>
													<?php _e('Show', 'ihc');?>
												  </span>
											  </th>
												<th class="manage-column">
												 <span>
												 <?php _e('ID', 'ihc');?>
												 </span>
											 </th>
											  <th class="manage-column">
												  <span>
													<?php _e('Slug', 'ihc');?>
												  </span>
											  </th>
											  <th class="manage-column">
												  <span>
													<?php _e('Name', 'ihc');?>
												  </span>
											  </th>
											  <?php if ($woo_payment):?>
											  <th class="manage-column">
												  <span>
													<?php _e('Woocommerce Product', 'ihc');?>
												  </span>
											  </th>
											  <?php endif;?>
											  <th class="manage-column" >
												  <span>
													<?php _e('Membership Type', 'ihc');?>
												  </span>
											  </th>
											  <th class="manage-column" >
												  <span>
													<?php _e('Billing Type', 'ihc');?>
												  </span>
											  </th>
											   <th class="manage-column" >
												  <span>
													<?php _e('Recurrences', 'ihc');?>
												  </span>
											  </th>
											  <th class="manage-column" >
												  <span>
													<?php _e('Price', 'ihc');?>
												  </span>
											  </th>
											  <th class="manage-column" >
												  <span>
													<?php _e('Membership Link', 'ihc');?>
												  </span>
											  </th>
									    </tr>
									  </tfoot>
									  <tbody id="the-list">
								<?php
									$i = 1;
									foreach ($levels as $k=>$v){
										?>
											  <tr class="" onMouseOver="ihcDhSelector('#level_tr_<?php echo $k;?>', 1);" onMouseOut="ihcDhSelector('#level_tr_<?php echo $k;?>', 0);" id="level_sort_<?php echo $i;?>">

											      <input type="hidden" class="ihc-hidden-level-id" value="<?php echo $k;?>" />
											      <td class="column" style="width:20px;">
												  	<?php if(isset($v['show_on']) && $v['show_on'] == 0) echo '<div class="ihc_item_status_nonactive"></div>';
															else echo '<div class="ihc_item_status_active"></div>';
													?>
												  </td>
													<td class="column" style="width:20px;">
														<?php echo $k;?>
													</td>
											      <td class="column">
													<?php echo $v['name'];?>
													<div class="ihc-buttons-rsp" style="visibility:hidden;" id="level_tr_<?php echo $k;?>">
														<a class="iump-btns" href="<?php echo $url.'&tab=levels&edit_level='.$k;?>"><?php _e('Edit', 'ihc');?></a>

														<div class="iump-btns ihc-js-delete-level" data-id="<?php echo $k;?>"  style="color: red; cursor: pointer;"><?php _e('Delete', 'ihc');?></div>
													</div>
											      </td>
											      <td class="column" style="color: #21759b; font-size: 14px;font-weight: 700;">
													<?php echo $v['label'];?>
											      </td>
												  <?php if ($woo_payment):?>
												  <td class="column">
												  		<?php
												  			$product_id = Ihc_Db::get_woo_product_id_for_lid($k);
														if ($product_id):
															$product_name = get_the_title($product_id);
														?>
												  			<a href="<?php echo admin_url('post.php?post=' . $product_id . '&action=edit');?>" target="_blank"><?php echo $product_name;?></a>
												  		<?php else :?>
												  			-
												  		<?php endif;?>
												  </td>
												  <?php endif;?>
												   <td class="column">
												  	<span class="subcr-type-list"><?php
												  		$r = array( 'unlimited' => 'LifeTime',
												  					'limited' => 'Limited',
												  					'date_interval' => 'Date Range',
												  					'regular_period' => 'Regular Period',
												  		);
												  		if (!empty($v['access_type']) && !empty($v['access_type'])){
												  			echo $r[$v['access_type']];
												  		} else {
												  			echo __('Not set', 'ihc');
												  		}
												  	?></span>
											      </td>
											      <td class="column" style="color: #222; font-weight:bold;font-size: 13px; text-transform:capitalize;">
												  	<?php
														//Billing Type
												  		echo $v['payment_type'];
												  	?>
											      </td>
												   <td class="column" style="color: #888; font-size: 13px;font-weight: 600; text-transform:capitalize;">
												  	<?php
												  		//Recurrences
												  		$r = array('bl_onetime'=>'One Time', 'bl_ongoing'=>'On Going', 'bl_limited'=>'Limited');
												  		if (!empty($v['billing_type']) && !empty($r[$v['billing_type']])){
												  			echo $r[$v['billing_type']];
												  		}
												  	?>
											      </td>
											      <td class="column">
												  	<?php
												  		if ($v['price'] && $v['payment_type']=='payment') echo '<span class="level-payment-list">'.$v['price'] . ' ' . $currency.'</span>';
												  		else echo '-';
												  	?>
											      </td>
											      <td class="column">
											      	<div>[ihc-level-link id=<?php echo $k;?>]<?php echo  __('Your Content Here', 'ihc') ;?>[/ihc-level-link]</div>
											      </td>
											  </tr>
										<?php
										$i++;
									}
								?>
							    </tbody>
							</table>
							</div>

						<?php
					}else{
						?>

						<div class="ihc-warning-message"> <?php _e('No Memberships available! Please create your first Membership plan.', 'ihc');?></div>
						<?php
					}
				?>
			</div>
	</form>
		<?php
			if ($levels && count($levels)){
		?>
		<a href="<?php echo $url.'&tab=levels&new_level=true';?>" class="indeed-add-new-like-wp" style="display: inline-block; margin-top: 20px;">
			<i class="fa-ihc fa-add-ihc"></i><?php _e('Add New Membership', 'ihc');?>
		</a>

		<script>
		jQuery( '.ihc-js-delete-level' ).on( 'click', function(){
				var levelId = jQuery( this ).attr( 'data-id' );
				swal({
					title: "<?php _e( 'Are you sure that you want to delete this level?', 'ihc' );?>",
					text: "",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "OK",
					closeOnConfirm: true
				},
				function(){
						jQuery.ajax({
								type : 'post',
								url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
								data : {
													 action: 'ihc_admin_delete_level',
													 lid:			levelId,
											 },
								success: function (response) {
										location.reload();
								}
					 });
			 });
		});
		</script>


		<?php
		}
	}
?>

</div>
</div>

<script>
	jQuery(document).ready(function(){
		ihcUpdateLevelSlugSpan();
	});
</script>
