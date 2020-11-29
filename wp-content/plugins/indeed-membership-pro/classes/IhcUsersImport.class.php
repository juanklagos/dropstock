<?php
if ( class_exists('IhcUsersImport') ) return;


class IhcUsersImport{

	/*
	 * @var string
	 */
	protected $file 			= '';
	/*
	 * @var int
	 */
	private $doRewrite 		= 0;
	/*
	 * @var array
	 */
	private $levels_data  = array();

	private $updatedUsers = array();

	private $totalUsers 	= 0;

	/*
	 * @param none
	 * @return none
	 */
	public function __construct(){
		$this->levels_data = get_option('ihc_levels');
	}

	public function getUpdatedUsers()
	{
			return count($this->updatedUsers);
	}

	public function getTotalUsers()
	{
			return $this->totalUsers;
	}

	/*
	 * @param string
	 * @return none
	 */
	public function setFile($filename=''){
		if ($filename){
			$this->file = $filename;
		}
	}


	/*
	 * @param int
	 * @return none
	 */
	public function setDoRewrite($value=0){
		$this->doRewrite = $value;
	}

	/*
	 * @param none
	 * @return none
	 */
	public function run(){
		if ($this->file){
			$file_handler = fopen($this->file, 'r');
			$keys = fgetcsv($file_handler);
			while ( ($temp_array = fgetcsv($file_handler))!==FALSE ){
				$user_data = array();
				$uid = 0;

				foreach ($temp_array as $k=>$v){
					if (isset($keys[$k])){
						$user_data[$keys[$k]] = $v;
					}
				}

				if (empty($user_data['user_email']) || !is_email($user_data['user_email'])){
					continue;
				}
				/// assign user
				if (!email_exists($user_data['user_email'])){
					if (empty($user_data['user_login'])){
						/// username not set
						$user_data['user_login'] = $user_data['user_email'];
					}
					if (!username_exists($user_data['user_login'])){
						if (empty($user_data['user_pass'])){
							/// let's generate one
							$user_data['user_pass'] = wp_generate_password(10);
							$do_send_notification_with_pass = TRUE;
						}
						$uid = wp_insert_user(array(
												'user_email' => $user_data['user_email'],
												'user_login' => $user_data['user_login'],
												'user_pass' => $user_data['user_pass'],
						));
						$this->totalUsers++;
						if (!empty($do_send_notification_with_pass) && !empty($uid)){
							$do_send_notification_with_pass = FALSE;
							$this->send_notification_with_pass($uid, $user_data['user_pass']);
						}
					}
				}
				if (empty($uid)){
					$uid = Ihc_Db::get_wpuid_by_email($user_data['user_email']);
				}
				unset($user_data['user_email']);
				if (isset($user_data['user_login'])) unset($user_data['user_login']);
				if (isset($user_data['user_pass'])) unset($user_data['user_pass']);

				/// assign user level
				if (!empty($user_data['level_slug'])){
					$lid = Ihc_Db::get_lid_by_level_slug($user_data['level_slug']);
					if ($lid>-1 && (!Ihc_Db::user_has_level($uid, $lid) || $this->doRewrite==1) ){
						if (!isset($user_data['start_time']) || $user_data['start_time']=='0000-00-00 00:00:00' ){
								$user_data['start_time'] = 0;
						} else {
								$user_data['start_time'] = strtotime( $user_data['start_time'] );
						}
						if (!isset($user_data['expire_time']) || $user_data['expire_time']=='0000-00-00 00:00:00' ){
								$user_data['expire_time'] = 0;
						} else {
								$user_data['expire_time'] = strtotime( $user_data['expire_time'] );
						}
						ihc_handle_levels_assign($uid, $lid, $user_data['start_time'], $user_data['expire_time'] );
						if ( in_array( $uid, $this->updatedUsers ) ){
								$this->updatedUsers[] = $uid;
						}
					}
					if (isset($user_data['start_time'])) unset($user_data['start_time']);
					if (isset($user_data['expire_time'])) unset($user_data['expire_time']);
					if (isset($user_data['level_slug'])) unset($user_data['level_slug']);
				}
				/// assign user data

				foreach ($user_data as $meta_key => $meta_value){
				  if( !in_array($meta_key, array('level_slug','start_time','expire_time')) ){
							$temp_meta_value = Ihc_Db::does_user_meta_exists($uid, $meta_key, $meta_value);

							if ($temp_meta_value===FALSE){
								update_user_meta($uid, $meta_key, $meta_value);
							}
				  }
				}

			}
			fclose($file_handler);
			unlink($this->file);
		}
	}

	/*
	 * @param int (user id)
	 * @param string (password)
	 * @return none
	 */
	private function send_notification_with_pass($uid=0, $password=''){
		ihc_send_user_notifications($uid, 'register_lite_send_pass_to_user', FALSE, array('{NEW_PASSWORD}' => $password));
	}

}
