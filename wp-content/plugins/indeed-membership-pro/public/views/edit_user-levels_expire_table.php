<div class="ihc-manage-user-expire-wrapper">
<table class="wp-list-table widefat fixed tags ihc-manage-user-expire">
    <thead>
        <tr>
            <th><?php _e('Membership Name', 'ihc');?></th>
            <th><?php _e('Membership Type', 'ihc');?></th>
            <th><?php _e('Plan Details', 'ihc');?></th>
            <th><?php _e('Starts On', 'ihc');?></th>
            <th><?php _e('Expires On', 'ihc');?></th>
            <th style="width:50px"><?php _e('Status', 'ihc');?></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $accessTypes = array(
                  'unlimited'       => 'LifeTime',
                  'limited'         => 'Limited',
                  'date_interval'   => 'Date Range',
                  'regular_period'  => 'Regular Period',
            );
            $i = 1;
            foreach ($user_levels as $v){
              $v = (int)$v;
              $temp_data = ihc_get_level_by_id($v);
              if ($temp_data){
				 $placeholder = array();
                $time = ihc_get_start_expire_date_for_user_level($uid, $v);
                $placeholder['start_time'] = '';
                $placeholder['expire_time'] = '';
                if (!$time['start_time']){
                  $placeholder['start_time'] = '----/--/----';
                }
                if (!$time['expire_time']){
                  $placeholder['expire_time'] = '----/--/----';
                }

                if (!isset($temp_data['access_type'])){
                  $temp_data['access_type'] = 'LifeTime';
                }

				$per ='';

				switch($temp_data['access_type']){
					case 'regular_period':
						$additional_details = '';
						if($temp_data['access_regular_time_type'] == 'D'){
							if($temp_data['access_regular_time_value'] == 1){
								$additional_details =  __('daily', 'ihc');
								$per =' / day';
							}elseif($temp_data['access_regular_time_value'] > 1){
								$additional_details =  __('on every ', 'ihc').$temp_data['access_regular_time_value'].__(' days', 'ihc');
								$per =' / '.$temp_data['access_regular_time_value'].' days';
							}
						}
						if($temp_data['access_regular_time_type'] == 'W'){
							if($temp_data['access_regular_time_value'] == 1){
								$additional_details =  __('weekly', 'ihc');
								$per =' / week';
							}elseif($temp_data['access_regular_time_value'] > 1){
								$additional_details = __('on every ', 'ihc').$temp_data['access_regular_time_value'].__(' weeks', 'ihc');
								$per =' / '.$temp_data['access_regular_time_value'].' weeks';
							}
						}
						if($temp_data['access_regular_time_type'] == 'M'){
							if($temp_data['access_regular_time_value'] == 1){
								$additional_details = __('monthly', 'ihc');
								$per =' / month';
							}elseif($temp_data['access_regular_time_value'] > 1){
								$additional_details = __('on every ', 'ihc').$temp_data['access_regular_time_value'].__(' months', 'ihc');
								$per =' / '.$temp_data['access_regular_time_value'].' months';
							}
						}
						if($temp_data['access_regular_time_type'] == 'Y'){
							if($temp_data['access_regular_time_value'] == 1){
								$additional_details = __('yearly', 'ihc');
								$per =' / year';
							}elseif($temp_data['access_regular_time_value'] > 1){
								$additional_details = __('on every ', 'ihc').$temp_data['access_regular_time_value'].__(' years', 'ihc');
								$per =' / '.$temp_data['access_regular_time_value'].' years';
							}
						}

						if ($temp_data['billing_type'] == 'bl_limited' && $temp_data['billing_limit_num'] > 1){
							$additional_details = $additional_details.__(' for ', 'ihc').$temp_data['billing_limit_num'].__(' times', 'ihc');
						}
						$reccurence = '';
						$r = array(
									 'bl_onetime' => __('One Time', 'ihc'),
									 'bl_ongoing'=>__('On Going', 'ihc'),
									 'bl_limited'=> __('Limited', 'ihc'),
						);
						if (!empty($temp_data['billing_type']) && !empty($r[$temp_data['billing_type']])){
							$reccurence = $r[$temp_data['billing_type']];
						}
					   break;

					   case 'limited':
						$additional_details = '';
						if($temp_data['access_limited_time_type'] == 'D'){
							if($temp_data['access_limited_time_value'] == 1){
								$additional_details =  __('only for one day', 'ihc');
								$per =' / day';
							}elseif($temp_data['access_limited_time_value'] > 1){
								$additional_details =  __('only for ', 'ihc').$temp_data['access_limited_time_value'].__(' days', 'ihc');
								$per =' / '.$temp_data['access_limited_time_value'].' days';
							}
						}
						if($temp_data['access_limited_time_type'] == 'W'){
							if($temp_data['access_limited_time_value'] == 1){
								$additional_details =  __('only for one week', 'ihc');
								$per =' / week';
							}elseif($temp_data['access_limited_time_value'] > 1){
								$additional_details = __('only for ', 'ihc').$temp_data['access_limited_time_value'].__(' weeks', 'ihc');
								$per =' / '.$temp_data['access_limited_time_value'].' weeks';
							}
						}
						if($temp_data['access_limited_time_type'] == 'M'){
							if($temp_data['access_limited_time_value'] == 1){
								$additional_details = __('only for one month', 'ihc');
								$per =' / month';
							}elseif($temp_data['access_limited_time_value'] > 1){
								$additional_details = __('only for ', 'ihc').$temp_data['access_limited_time_value'].__(' months', 'ihc');
								$per =' / '.$temp_data['access_limited_time_value'].' months';
							}
						}
						if($temp_data['access_limited_time_type'] == 'Y'){
							if($temp_data['access_limited_time_value'] == 1){
								$additional_details = __('only for one year', 'ihc');
								$per =' / year';
							}elseif($temp_data['access_limited_time_value'] > 1){
								$additional_details = __('only for ', 'ihc').$temp_data['access_limited_time_value'].__(' years', 'ihc');
								$per =' / '.$temp_data['access_limited_time_value'].' years';
							}
						}

					   break;

						case 'date_interval':
								$additional_details = __('between  ', 'ihc'). ihc_convert_date_to_us_format($temp_data['access_interval_start']).__(' and ', 'ihc').  ihc_convert_date_to_us_format($temp_data['access_interval_end']);
						break;

					default:
								$additional_details = '-';
					}

				$status = ihc_get_user_level_status_for_ac($uid, $v);

                echo '<tr class="'. ($i%2==0 ? 'alternate':'') .'" id="tr_level_user_' . $v . '_' . $uid . '">';
                 echo '<td  class="ihc-levels-table-name" style="color: #21759b; font-weight:bold; width:120px;font-size: 14px;">' . $temp_data['label'] . '</td>';
                 echo '<td class="ihc-levels-table-access-type" style="color: #888; font-weight:bold; width:120px; font-size: 14px;font-weight: 500;">' . @$accessTypes[ $temp_data['access_type'] ] . '</td>';
				 echo '<td>' . $additional_details . '</td>';
                  echo '<td>' . indeed_create_form_element( array('type'=>'text',
                                            'name'=>'start_time_levels['.$v.']',
                                            'class'=>'start_input_text',
                                            'value' => $time['start_time'],
                                            'placeholder' => $placeholder['start_time']
                                            )
                            )
                          . '</td>';
                          if ( $time['expire_time'] == '' || $time['expire_time'] == '0000-00-00 00:00:00' ){
                              $placeholder = '';
                              $theValue = '';
                          } else {
                              $placeholder = $time['expire_time'];
                              $theValue = $time['expire_time'];
                          }
                    echo '<td>' . indeed_create_form_element( array('type'=>'text',
                                            'name'=>'expire_levels['.$v.']',
                                            'class'=>'expire_input_text',
                                            'value' => $theValue,
                                            'placeholder' => $placeholder
                                            )
                            )
                          . '</td>';

					echo '<td> <span id="ihc-current-user-level-status" class="ihc-level-status ihc-level-status-' . $status . '">' . $status . '</span></td>';

                        echo  '</tr>';
              }
            $i++;
            }
        ?>
    </tbody>
</table>
</div>
