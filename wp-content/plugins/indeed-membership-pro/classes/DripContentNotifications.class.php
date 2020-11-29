<?php 
if (!class_exists('DripContentNotifications')):
	
class DripContentNotifications{
	/**
	 * @var array
	 */
	private $email_templates = array();
	/**
	 * @var object (Ihc_User_Logs)
	 */
	private $logModule;
	/**
	 * @var string
	 */
	private $logType = 'drip_content_notifications';
	/**
	 * @var string (cron || admin)
	 */
	private $startBy = 'cron';
	/**
	 * @var int
	 */
	private $countNotificationsOnSpecificDate = 0;
	/**
	 * @var int
	 */
	private $countAfterSubscriptionXTime = 0;
	/**
	 * @var int (second between sending notifications)
	 */
	private $sleepTime = 10;
	/**
	 * @var int (max execution time)
	 */
	private $executionTime = 3600;/// one hour
	
	
	/**
	 * @param none
	 * @return none
	 */
	public function __construct(){
		$on = get_option('ihc_drip_content_notifications_enabled');
		if (!$on) return; /// MODULE INACTIVE
		
		@set_time_limit($this->executionTime);
		$this->sleepTime = get_option('ihc_drip_content_notifications_sleep');
		$this->startLogModule();
		$this->runOnSpecificDate();
		$this->runOnAfterSubscriptionXTime();
		$content = __('Process end! Total number of notifications sent: ', 'ihc') . ($this->countNotificationsOnSpecificDate + $this->countAfterSubscriptionXTime) . '.';
		$this->logModule->write_log($content, $this->logType);		
	}
	
	
	/**
	 * @param string
	 * @return none
	 */
	public function setStartBy($type='cron'){
		$this->startBy = $type;
	}

	
	/**
	 * @param none
	 * @return none
	 */
	private function runOnSpecificDate(){
		global $wpdb;
		
		$content = __('Start sending notifications for posts that are available on current date.', 'ihc');
		$this->logModule->write_log($content, $this->logType);	
		
		$table = $wpdb->prefix . 'postmeta';
		$current = date('d-m-Y');
		$q = "
			SELECT DISTINCT d.post_id as post_id, d.meta_value as target_levels 
				FROM $table a 
				INNER JOIN $table b 
				ON a.post_id=b.post_id
				INNER JOIN $table c
				ON c.post_id=a.post_id
				INNER JOIN $table d
				ON d.post_id=a.post_id
				WHERE 
				(a.meta_key='ihc_drip_content' AND a.meta_value=1)
				AND 
				(b.meta_key='ihc_drip_start_type' AND b.meta_value=3)
				AND
				(c.meta_key='ihc_drip_start_certain_date' AND c.meta_value='$current' )	
				AND 
				d.meta_key='ihc_mb_who'
		";

		$post_data = $wpdb->get_results($q);
		
		if ($post_data){
			foreach ($post_data as $post_object){
				$this->posts_links[$post_object->post_id] = get_permalink($post_object->post_id);
				$dynamic_data = array('{POST_LINK}' => $this->posts_links[$post_object->post_id]);
				$users = $this->searchUsers($post_object->target_levels);
				if (!empty($users)){
					foreach ($users as $temp_array){
						$lid = isset($temp_array->lid) ? $temp_array->lid : -1;
						if (!isset($this->email_templates[$lid])){
							$this->email_templates[$lid] = $this->getNotification($lid);
						}
						if (!empty($this->email_templates[$lid]['message'])){
							ihc_send_user_notifications($temp_array->uid, 'drip_content-user', $lid, $dynamic_data, @$this->email_templates[$lid]['subject'], 
														$this->email_templates[$lid]['message']);
							$this->countNotificationsOnSpecificDate++;							
							sleep($this->sleepTime);
						}
					}
				}
			}
		}
		$content = __('End sending notifications for posts that are available on current date. Total number : ', 'ihc') . $this->countAfterSubscriptionXTime;
		$this->logModule->write_log($content, $this->logType);			
	}
	
	
	/**
	 * @param none
	 * @return none
	 */
	private function runOnAfterSubscriptionXTime(){
		global $wpdb;
				
		$content = __('Start sending notifications for posts that are available after a specified subscription time.', 'ihc');
		$this->logModule->write_log($content, $this->logType);	
		
		$table = $wpdb->prefix . 'postmeta';
		$current = date('d-m-Y');
		$q = "
			SELECT DISTINCT d.post_id as post_id, d.meta_value as target_levels, e.meta_value as interval_type, f.meta_value as interval_value
				FROM $table a 
				INNER JOIN $table b 
				ON a.post_id=b.post_id
				INNER JOIN $table c
				ON c.post_id=a.post_id
				INNER JOIN $table d
				ON d.post_id=a.post_id
				INNER JOIN $table e
				ON e.post_id=a.post_id
				INNER JOIN $table f
				ON f.post_id=a.post_id
				WHERE 
				(a.meta_key='ihc_drip_content' AND a.meta_value=1)
				AND 
				(b.meta_key='ihc_drip_start_type' AND b.meta_value=2)
				AND
				d.meta_key='ihc_mb_who'
				AND 
				e.meta_key='ihc_drip_start_numeric_type'
				AND
				f.meta_key='ihc_drip_start_numeric_value'
		";	
		$post_data = $wpdb->get_results($q);
		if ($post_data){
			foreach ($post_data as $post_object){
				$this->posts_links[$post_object->post_id] = get_permalink($post_object->post_id);
				$dynamic_data = array('{POST_LINK}' => $this->posts_links[$post_object->post_id]);				
				switch ($post_object->interval_type){
					case 'days':
						$after_time = $post_object->interval_value;
						break;
					case 'weeks':
						$after_time = $post_object->interval_value * 7;						
						break;
					case 'months':
						$after_time = $post_object->interval_value * 30;						
						break;
				}
				$users = $this->searchUsers($post_object->target_levels, $after_time);
				
				if (!empty($users)){
					foreach ($users as $temp_array){
						$lid = isset($temp_array->lid) ? $temp_array->lid : -1;
						if (!isset($this->email_templates[$lid])){
							$this->email_templates[$lid] = $this->getNotification($lid);
						}						
						if (!empty($this->email_templates[$lid]['message'])){
							ihc_send_user_notifications($temp_array->uid, 'drip_content-user', $lid, $dynamic_data, @$this->email_templates[$lid]['subject'], 
														$this->email_templates[$lid]['message']);							
							$this->countAfterSubscriptionXTime++;	
							sleep($this->sleepTime);						
						}
					}
				}				
			}
		}
		$content = __('End sending notifications for posts that are available after a specified subscription time. Total number : ', 'ihc') . $this->countAfterSubscriptionXTime;
		$this->logModule->write_log($content, $this->logType);		
	}
	
	
	/**
	 * @param string (level ids, 'reg')
	 * @param int (number of days after user subscription date)
	 * @return array (with email address)
	 */
	private function searchUsers($level_ids='', $x_days_after_subscription=0){		
		global $wpdb;
		$users_table = $wpdb->base_prefix . 'users';
		if (strpos($level_ids, '-1')!==FALSE){
			/// all users
			$q = "SELECT ID as uid, user_email FROM $users_table;";
			$data = $wpdb->get_results($q);
			return $data;
		} else {
			/// only for some levels
			$user_level_table = $wpdb->prefix . 'ihc_user_levels';
			$q = "
				SELECT a.user_id as uid, a.level_id as lid, b.user_email as user_email
					FROM $user_level_table a
					INNER JOIN $users_table b 
					ON a.user_id=b.ID
			";
			$q .= "	WHERE 1=1 ";
			$q .= " AND UNIX_TIMESTAMP(a.expire_time)>UNIX_TIMESTAMP(NOW()) ";
			$levels = explode(',', $level_ids);
			if ($levels){
				$q .= " AND (";
				foreach ($levels as $lid){
					if (!empty($or)){
						$q .= " OR ";
					}
					$q .= " a.level_id=$lid ";
					$or = TRUE;
				}
				$q .= " ) ";
			}
			if ($x_days_after_subscription>0){
				$date = date('Y-m-d', strtotime("-$x_days_after_subscription days"));
				$start = $date . ' 00:00:00';
				$end = $date . ' 23:59:59';
				$q .= " AND 
						( UNIX_TIMESTAMP(a.start_time)>UNIX_TIMESTAMP('$start') AND UNIX_TIMESTAMP(a.start_time)<UNIX_TIMESTAMP('$end') )
				";
			}
			$user_data = $wpdb->get_results($q);
						
			return $user_data;
		}
		return array();
	}
	 
	
	/**
	 * @param int (level_id) , -1 means registered with no level
	 * @return string (the notification text)
	 */
	private function getNotification($lid=-1){
		global $wpdb;
		$data = array();
		$table = $wpdb->prefix . 'ihc_notifications';
		$standard_q = "
			SELECT subject, message
				FROM $table
				WHERE 
				notification_type='drip_content-user'
				AND 
				level_id=%d
				AND 
				status=1
				ORDER BY id DESC LIMIT 1;
		";
		if ($lid>-1){
			$q = $wpdb->prepare($standard_q, $lid);
			$data = $wpdb->get_row($q);
		}		
		if (!empty($data)){
			$data = (array)$data;
		} else {
			$q = $wpdb->prepare($standard_q, -1);
			$data = $wpdb->get_row($q);
			$data = (array)$data;			
		}
		return $data;
	}
	
	
	/**
	 * @param none
	 * @return none
	 */
	private function startLogModule(){
		require_once IHC_PATH . 'classes/Ihc_User_Logs.class.php';
		$this->logModule = new Ihc_User_Logs();
		$this->logModule->set_user_id(-1);/// no user, action made by wp ajax 
		$this->logModule->set_level_id(-1);/// no level
		$content = __('Process start by: ', 'ihc') . $this->startBy . '.';
		$this->logModule->write_log($content, $this->logType);
	}
	
}	
	
endif;
