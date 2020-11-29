<?php
if (class_exists('IndeedImport') && !class_exists('Ihc_Indeed_Import')):
	
class Ihc_Indeed_Import extends IndeedImport{
	
	/*
	 * @param string ($entity_name)
	 * @param string ($entity_opt)
	 * @param object ($xml_object)
	 * @return none
	 */
	protected function do_import_custom_table($entity_name, $entity_opt, &$xml_object){
		global $wpdb;
		$table = $wpdb->prefix . $entity_name;
		
		if (!$xml_object->$entity_name->Count()){
			return;
		}
		
		switch ($entity_name){
			case 'ihc_notifications':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->notification_type}', 
											'{$object->level_id}', 
											'{$object->subject}', 
											'{$object->message}',
											'{$object->pushover_message}',
											'{$object->pushover_status}',
											'{$object->status}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}
				break;
			case 'ihc_user_levels':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->user_id}', 
											'{$object->level_id}', 
											'{$object->start_time}', 
											'{$object->update_time}',
											'{$object->expire_time}',
											'{$object->notification}',
											'{$object->status}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}				
				break;
			case 'ihc_debug_payments':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->source}', 
											'{$object->message}', 
											'{$object->insert_time}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}					
				break;
			case 'indeed_members_payments':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->txn_id}', 
											'{$object->u_id}', 
											'{$object->payment_data}',
											'{$object->history}', 
											'{$object->orders}', 
											'{$object->paydate}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}								
				break;
			case 'ihc_coupons':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->code}', 
											'{$object->settings}', 
											'{$object->submited_coupons_count}',
											'{$object->status}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}							
				break;
			case 'ihc_orders':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->uid}', 
											'{$object->lid}', 
											'{$object->amount_type}',
											'{$object->amount_value}', 
											'{$object->automated_payment}',
											'{$object->status}',
											'{$object->create_date}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}					
				break;
			case 'ihc_orders_meta':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->id}', 
											'{$object->order_id}', 
											'{$object->meta_key}',
											'{$object->meta_value}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}						
				break;
			case 'ihc_taxes':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->country_code}', 
											'{$object->state_code}', 
											'{$object->amount_value}',
											'{$object->label}',
											'{$object->description}',
											'{$object->status}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}								
				break;
			case 'ihc_dashboard_notifications':
				///				
				break;
			case 'ihc_cheat_off':
				///						
				break;
			case 'ihc_invitation_codes':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->code}', 
											'{$object->settings}', 
											'{$object->submited}',
											'{$object->repeat_limit}',
											'{$object->status}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}
				break;
			case 'ihc_gift_templates':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->lid}', 
											'{$object->settings}', 
											'{$object->status}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}						
				break;
			case 'ihc_security_login':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->username}', 
											'{$object->ip}', 
											'{$object->log_time}', 
											'{$object->attempts_count}', 
											'{$object->locked}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}						
				break;
			case 'ihc_user_logs':
				foreach ($xml_object->$entity_name->children() as $meta_key=>$object){
					$insert_string = "VALUES(null, 
											'{$object->uid}', 
											'{$object->lid}', 
											'{$object->log_type}', 
											'{$object->log_content}', 
											'{$object->create_date}'
					)";
					$this->do_basic_insert($table, $insert_string);
				}								
				break;
		}
	
	}	
	
	
	/*
	 * @param string (table name)
	 * @param string (insert values)
	 * @return none
	 */
	private function do_basic_insert($table='', $insert_values=''){
		global $wpdb;
		$wpdb->query("INSERT INTO $table $insert_values;");
	}
}	
	
endif;
