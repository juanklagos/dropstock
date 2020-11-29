<?php $excluded_from_cancel = array( 'braintree', 'bank_transfer');?>
<?php $needReasons = ihc_is_magic_feat_active( 'reason_for_cancel' );?>
<?php $allPaymentTypes = ihc_list_all_payments();?>
<div class="ihc-ap-wrap">
	<?php if (!empty($data['title'])):?>
		<h3><?php echo do_shortcode($data['title']);?></h3>
	<?php endif;?>
	<?php if (!empty($data['content'])):?>
		<p><?php echo do_shortcode($data['content']);?></p>
	<?php endif;?>


	<?php
			if ($levels_str!='' && $data['show_table']){
				$levels_arr = explode(',', $levels_str);
				?>
				<table class="ihc-account-subscr-list">
					<thead>
						<tr>
							<td class="ihc-subscription-table-level"><?php _e("Membership", 'ihc');?></td>
							<td><?php _e("Status", 'ihc');?></td>
							<td class="ihc-remove-onmobile ihc-content-center"><?php _e("Plan Details", 'ihc');?></td>
							<td class="ihc-remove-onmobile"><?php _e("Starts On", 'ihc');?></td>
							<td><?php _e("Expires On", 'ihc');?></td>
							<td class="ihc-remove-onmobile"><?php _e("Access", 'ihc');?></td>
							<td class="ihc-remove-onmobile ihc-content-right"><?php _e("Amount", 'ihc');?></td>
                            <td class="ihc-subscription-table-actions ihc-content-center"><?php _e("Actions", 'ihc');?></td>
						</tr>
					</thead>
				<?php
				$i = 0;
				$show_meta_links = ihc_return_meta_arr('level_subscription_plan_settings');
				//$check_renew = (empty($show_meta_links['ihc_show_renew_link'])) ? 0 : $show_meta_links['ihc_show_renew_link'];
				$show_delete = (empty($show_meta_links['ihc_show_delete_link'])) ? 0 : $show_meta_links['ihc_show_delete_link'];
				$show_renew = TRUE;

				foreach ($levels_arr as $level_id){
					$time_data = ihc_get_start_expire_date_for_user_level($this->current_user->ID, $level_id);
					if (strtotime($time_data['expire_time'])>indeed_get_unixtimestamp_with_timezone()){
						$expire = $time_data['expire_time'];
					} else if (strtotime($time_data['expire_time'])<0) {
						$expire = __('--', 'ihc');//not active yet
					} else {
						$expire = __('Expired', 'ihc');
					}
					$show_cancel = ihc_show_cancel_level_link($this->current_user->ID, $level_id);

					$show_renew = ihc_show_renew_level_link($level_id);
					if (empty($show_meta_links['ihc_show_renew_link'])){
						$show_renew = FALSE;
					}

					$payment_type = get_option('ihc_payment_selected');

					$level_data = ihc_get_level_by_id($level_id);
					if (empty($level_data)){
						continue;
					}

					$hidden_div = 'ihc_ap_subscription_l_' . $i;
					$status = ihc_get_user_level_status_for_ac($this->current_user->ID, $level_id);

					// first we search into order meta for payment type
					$orderId = \Ihc_Db::getLastOrderIdByUserAndLevel( $this->current_user->ID, $level_id );
					$orderMetaObject = new \Indeed\Ihc\Db\OrderMeta();
					$payment_type_for_this_level = $orderMetaObject->get( $orderId, 'ihc_payment_type' );
					if ( $payment_type_for_this_level === '' || $payment_type_for_this_level === false ){
							// if we don't get the answer, it's probably an old implementation so we search in deprecated table indeed_members_payments
							$payment_type_for_this_level = Ihc_Db::get_payment_tyoe_by_userId_levelId($this->current_user->ID, $level_id);
					}

					?>
					<tr>
						<td  class="ihc-level-name-wrapp ihc-content-left"><span class="ihc-level-name"><span class="ihc-level-status-set-<?php echo $status;?>"><?php echo $level_data['label'];?></span></span>

						</td>
					<td class="ihc_account_level_status"><span class="ihc-level-status-set-<?php echo $status;?>"><?php echo $status;?></span></td>


                    <td class="ihc-level-type-wrapp ihc-remove-onmobile ihc-content-center">

					<?php switch($level_data['access_type']){
						case 'unlimited':
							echo __('LifeTime', 'ihc');
							break;
						case 'limited':
							echo __('OneTime', 'ihc');
							break;
						case 'date_interval':
							echo __('Date Range', 'ihc');
							break;
						case 'regular_period':
							echo __('Subscription', 'ihc');
							break;
						default:
							echo __('Regular', 'ihc');
					}?>

					<?php
					$per ='';

					if ($level_data['access_type'] == 'regular_period'){
						$additional_details = '';
						if($level_data['access_regular_time_type'] == 'D'){
							if($level_data['access_regular_time_value'] == 1){
								$additional_details =  __('daily', 'ihc');
								$per =' / day';
							}elseif($level_data['access_regular_time_value'] > 1){
								$additional_details =  __('on every ', 'ihc').$level_data['access_regular_time_value'].__(' days', 'ihc');
								$per =' / '.$level_data['access_regular_time_value'].' days';
							}
						}
						if($level_data['access_regular_time_type'] == 'W'){
							if($level_data['access_regular_time_value'] == 1){
								$additional_details =  __('weekly', 'ihc');
								$per =' / week';
							}elseif($level_data['access_regular_time_value'] > 1){
								$additional_details = __('on every ', 'ihc').$level_data['access_regular_time_value'].__(' weeks', 'ihc');
								$per =' / '.$level_data['access_regular_time_value'].' weeks';
							}
						}
						if($level_data['access_regular_time_type'] == 'M'){
							if($level_data['access_regular_time_value'] == 1){
								$additional_details = __('monthly', 'ihc');
								$per =' / month';
							}elseif($level_data['access_regular_time_value'] > 1){
								$additional_details = __('on every ', 'ihc').$level_data['access_regular_time_value'].__(' months', 'ihc');
								$per =' / '.$level_data['access_regular_time_value'].' months';
							}
						}
						if($level_data['access_regular_time_type'] == 'Y'){
							if($level_data['access_regular_time_value'] == 1){
								$additional_details = __('yearly', 'ihc');
								$per =' / year';
							}elseif($level_data['access_regular_time_value'] > 1){
								$additional_details = __('on every ', 'ihc').$level_data['access_regular_time_value'].__(' years', 'ihc');
								$per =' / '.$level_data['access_regular_time_value'].' years';
							}
						}

						if ($level_data['billing_type'] == 'bl_limited' && $level_data['billing_limit_num'] > 1){
							$additional_details = $additional_details.__(' for ', 'ihc').$level_data['billing_limit_num'].__(' times', 'ihc');
						}
						$reccurence = '';
						$r = array(
									 'bl_onetime' => __('One Time', 'ihc'),
									 'bl_ongoing'=>__('On Going', 'ihc'),
									 'bl_limited'=> __('Limited', 'ihc'),
						);
						if (!empty($level_data['billing_type']) && !empty($r[$level_data['billing_type']])){
							$reccurence = $r[$level_data['billing_type']];
						}
						echo ' - '.$additional_details;
					}
					?>

                    </td>

                    <td class="ihc-level-start-time-wrapp ihc-remove-onmobile"><?php echo ihc_convert_date_to_us_format($time_data['start_time']);?></td>

					<?php
					if ($expire && $expire!='--' && $expire!=__('Expired', 'ihc')){
						?><td class="ihc-level-end-time-wrapp"><?php echo ihc_convert_date_to_us_format($expire);?></td><?php
					} else {
						?><td class="ihc-level-end-time-wrapp"><?php echo $expire; ?></td>
						<?php
					}?>

                    <?php

					$paid_type = $level_data['payment_type'];
					if ($paid_type == 'payment') $paid_type = __('Paid', 'ihc');
					else $paid_type = __('Free', 'ihc');
					?>
                    <td class="ihc-level-paid-status-wrapp ihc-remove-onmobile ihc-content-capitalize"><?php echo $paid_type;?></td>



					<?php
					if ($level_data['price'] && $level_data['payment_type']=='payment'){
						$currency = get_option('ihc_currency');

						$price = ihc_format_price_and_currency($currency, $level_data['price']);
					} else {
						$price = '--';
					}

					$via ='';
					$paymentTypeLabel = isset( $allPaymentTypes[$payment_type_for_this_level] ) ? $allPaymentTypes[$payment_type_for_this_level] : $payment_type_for_this_level;
					if($payment_type_for_this_level) $via = 'via <span>'.$paymentTypeLabel.'</span>';
					?>
                    <td class="ihc-level-price-wrapp ihc-remove-onmobile ihc-subscription-table-price"><?php echo $price.$per; ?><div class="ihc-level-payment-via"><?php echo $via; ?></div></td>

                    <td>
                    <div class="ihc-subscription-table-actions ihc-content-right" id="<?php echo $hidden_div;?>">
								<?php
									if ($show_renew){
										$include_stripe_script = TRUE;
										$renew_label = __('Renew', 'ihc');
										$time_arr = ihc_get_start_expire_date_for_user_level($this->current_user->ID, $level_id);
										if (isset($time_arr['expire_time']) && $time_arr['expire_time']=='0000-00-00 00:00:00'){
											//it's for the first time
											$renew_label = __('Finish payment', 'ihc');
										}
										?>
										<div class="iump-subscription-table-button">
                                          <span class="iump-renew-subscription-button" onClick="ihcRenewFunction('#ihc_renew_level', '#ihc_form_ap_subscription_page', <?php echo $level_id;?>, '<?php echo $level_data['label'];?>',  '<?php echo $level_data['price'];?>');">
										    <?php echo $renew_label;?>
                                          </span>
                                        </div>
										<?php
									} else if (ihc_is_level_on_hold($this->current_user->ID, $level_id)){

										$include_stripe_script = TRUE;
										?>
                                        <div class="iump-subscription-table-button">
										  <span class="iump-renew-subscription-button" onClick="ihcRenewFunction('#ihc_renew_level', '#ihc_form_ap_subscription_page', <?php echo $level_id;?>, '<?php echo $level_data['label'];?>',  '<?php echo $level_data['price'];?>');">
										  <?php echo __('Finish payment', 'ihc');?>
                                          </span>
                                        </div>
										<?php
									} else {
										///finish payment
										$include_stripe_script = TRUE;
										$time_arr = ihc_get_start_expire_date_for_user_level($this->current_user->ID, $level_id);
										if (isset($time_arr['expire_time']) && ($time_arr['expire_time']=='0000-00-00 00:00:00' || ($time_arr['expire_time']==FALSE && $time_arr['start_time']==FALSE))){
											//it's for the first time
											$renew_label = __('Finish payment', 'ihc');
											?>
                                            <div class="iump-subscription-table-button">
											  <span class="iump-renew-subscription-button" onClick="ihcRenewFunction('#ihc_renew_level', '#ihc_form_ap_subscription_page', <?php echo $level_id;?>, '<?php echo $level_data['label'];?>',  '<?php echo $level_data['price'];?>');">
											  <?php echo $renew_label;?>
                                              </span>
                                            </div>
											<?php
										}
									}
									if ($show_cancel){
										if ($payment_type_for_this_level && !in_array($payment_type_for_this_level, $excluded_from_cancel)):
										?>
                        <div class="iump-subscription-table-button">
														<span class="iump-cancel-subscription-button" data-lid="<?php echo $level_id;?>" >
																<?php _e('Cancel', 'ihc');?>
                            </span>
                        </div>
										<?php
										endif;
									}

								?>
								<?php if ($show_delete):?>
                    <div class="iump-subscription-table-button">
											  <span class="iump-delete-subscription-button" data-lid="<?php echo $level_id;?>">
														<?php _e('Remove', 'ihc');?>
                        </span>
                    </div>
								<?php endif;?>
							</div>
                    </td>
					</tr><?php
					$i++;
				}
				$default_payment = get_option('ihc_payment_selected');
				?>
			<?php do_action( 'ump_public_account_page_subscription_table-row', $this->current_user->ID );?>
			</table>
					<form id="ihc_form_ap_subscription_page" name="ihc_ap_subscription_page" method="post" data-modal="<?php echo $needReasons;?>" >
						<input type="hidden" name="ihc_delete_level" value="" id="ihc_delete_level" />
						<input type="hidden" name="ihc_cancel_level" value="" id="ihc_cancel_level" />
						<input type="hidden" name="ihc_renew_level" value="" id="ihc_renew_level" />
						<input type="hidden" name="ihcaction" value="renew_cancel_delete_level_ap" />
				<?php
				$the_payment_type = ( ihc_check_payment_available($default_payment) ) ? $default_payment : '';
				if (!defined('IHC_HIDDEN_PAYMENT_PRINT')) define('IHC_HIDDEN_PAYMENT_PRINT', TRUE);
					?><input type="hidden" value="<?php echo $the_payment_type;?>" name="ihc_payment_gateway" />
				</form><?php
				if (($payment_type=='stripe' || !empty($include_stripe)) && !empty($include_stripe_script)){
					echo ihc_stripe_renew_script('#ihc_form_ap_subscription_page');
				}
			}
		if ($data['show_subscription_plan']){
			echo ihc_user_select_level();	/// FALSE, FALSE
		}
	?>

</div>

<?php if ( $needReasons && !empty( $levels_arr ) ): ?>
	<?php $prefedinedReasons = stripslashes(get_option('ihc_reason_for_cancel_resons'));?>
	<div id="ihc_reasons_modal">
			<label><?php _e( 'Reason', 'ihc' );?></label>
			<?php if ( $prefedinedReasons ):?>
				<?php $reasons = explode( ',', $prefedinedReasons );?>
				<div>
						<select id="ihc_reason_predefined_type" style="width: 90%;" >
								<option value=0>...</option>
								<?php foreach ( $reasons as $reason ):?>
										<?php $reason = trim($reason);?>
										<option value="<?php echo $reason;?>" ><?php echo $reason;?></option>
								<?php endforeach;?>
						</select>
				</div>
		  <?php endif;?>
			<textarea style="width: 90%; height: 200px;padding: 5px; margin-top: 10px;" id="ihc_the_reason_textarea" placeholder="<?php _e('Other', 'ihc');?>"></textarea>
			<input type="hidden" value="" id="ihc_reason_type" />
			<div class="ihc-standard-cancel-bttn" id="ihc_close_modal_bttn"><?php _e('Cancel', 'ihc');?></div>
			<div class="ihc-standard-bttn" id="ihc_submit_subscription_form"><?php _e('Submit', 'ihc');?></div>
	</div>
<?php endif;?>

<!-- Trigger to open Modal -->
<?php
wp_enqueue_style( 'ihc_iziModal' );
wp_enqueue_script( 'ihc_iziModal_js' );
wp_enqueue_script( 'IhcRemoveCancelLevels', IHC_URL . 'assets/js/IhcRemoveCancelLevels.js', array(), null );
?>
