<?php
//////////////////////////////LEVELS
function ihc_save_level($post_data=array(), $install=FALSE){
	/*
	 * @param array
	 * @return none
	 */
	if (isset($post_data['name']) && $post_data['name']!=''){
		$option_name = 'ihc_levels';
		$data = get_option($option_name);
		if ( !empty($data) && is_array( $data ) && count($data)>=3 && (!defined('IHCACTIVATEDMODE') || !IHCACTIVATEDMODE)){
			if (!$install){
				echo '<div class="ihc-admin-err-level">' . __("You cannot add more than one level on Trial Version!", 'ihc') . '</div>';
			}
			return;
		}
		$arr = array(
							'name'=>'',
							'payment_type'=>'',
							'price'=>'',
						    'label'=>'',
								//developer
								'short_description' => '',
								//end developer
							'description'=>'',
							'price_text' => '',
							'order' => '',
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
							'custom_role_level' => '-1',
							'start_date_content' => '0',
							'special_weekdays' => '',
							//trial
							'access_trial_time_value' => '',
							'access_trial_time_type' => 'D',
							'access_trial_price' => '',
							'access_trial_couple_cycles' => '',
							'access_trial_type' => 1,
							///magic feat
							'badge_image_url' => '',
		);

		$arr = apply_filters('ihc_save_level_meta_names_filter', $arr);
		// @description filter fired when save level. @param array with level data

		foreach ($arr as $k=>$v){
			$arr[$k] = (isset($post_data[$k])) ? $post_data[$k] : '';
		}

		//if it's not regular period type of level ... force billing_type to be bl_onetime
		if (isset($arr['access_type']) && $arr['access_type']!='regular_period'){
			$arr['billing_type'] = 'bl_onetime';
		}

		$arr = apply_filters('ihc_save_level_filter', $arr);

		if ($data!==FALSE){
			if (isset($post_data['level_id']) && $post_data['level_id']!=''){
				//update level
				$id = $post_data['level_id'];
			} else {
				/// create level
				//end($data);
				//$id = key($data);
				$id = ihc_get_biggest_key_from_array($data);
				$id++;
				$arr['name'] = ihc_make_string_simple($arr['name']);
			}
			$check = ihc_array_value_exists($data, $post_data['name'], 'name');
			if ($check!==FALSE && $check!=$id){
				if (!$install){
					echo '<div class="ihc-admin-err-level">' . __("A Level with this name ", 'ihc') . $post_data['name'] . __(" already exists! Please choose another name!", 'ihc') . '</div>';
				}
				return 0;
			}
			$data[$id] = $arr;
			update_option($option_name, $data);
			return $id;
		} else {
			//create the first level
			$data[1] = $arr;
			update_option($option_name, $data);
			return 1;
		}
	}
}

function ihc_delete_level($lid=-1){
	/*
	 * delete LEVEL from wp_options, ihc_user_levels and user_meta
	 * @param none
	 * @return none
	 */
	//delete level wp option
	global $wpdb;
	$data = get_option('ihc_levels');
	foreach ($data as $k=>$v){
		if ($k==$lid){
			unset($data[$k]);
		}
	}
	update_option('ihc_levels', $data);
	do_action('ihc_delete_level_action', $lid);

	$table = $wpdb->prefix . 'ihc_user_levels';
	$table_b = $wpdb->base_prefix . 'users';
	$q = $wpdb->prepare("SELECT a.user_id as uid FROM $table a INNER JOIN $table_b b ON a.user_id=b.ID WHERE 1=1 AND a.level_id=%d", $lid);
	$users = $wpdb->get_results($q);
	$q = $wpdb->prepare("DELETE FROM $table WHERE level_id=%d ", $lid);
	$wpdb->query($q);
	if ($users){
		foreach ($users as $object){
			$u_levels = get_user_meta($object->uid, 'ihc_user_levels', TRUE);
			if ($u_levels){
				$u_levels_arr = explode(",", $u_levels);
				if ($u_levels_arr){
					foreach ($u_levels_arr as $k=>$u_lid){
						if ($u_lid==$lid){
							unset($u_levels_arr[$k]);
							$level_str = implode(',', $u_levels_arr);
							update_user_meta($object->uid, 'ihc_user_levels', $level_str);
							break;
						}
					}
				}
			}
		}
	}

	$table = $wpdb->prefix . 'postmeta';
	$data = $wpdb->get_results("SELECT post_id, meta_value FROM $table WHERE meta_key='ihc_mb_who';");
	if ($data){
		foreach ($data as $object){
			if ($object->meta_value){
				$post_levels = explode(',', $object->meta_value);
				if ($post_levels){
					foreach ($post_levels as $k=>$u_lid){
						if ($u_lid==$lid){
							unset($post_levels[$k]);
							$level_str = implode(',', $post_levels);
							$q = $wpdb->prepare("UPDATE $table SET meta_value=%s WHERE post_id=%d AND meta_key='ihc_mb_who';", $level_str, $object->post_id);
							$wpdb->query($q);
							break;
						}
					}
				}
			}
		}
	}
}
