<?php
namespace Indeed\Ihc;
/*
$object = new \Indeed\Ihc\AssignLevel($uid, $lid);
return $object->setStartTime($start_time)->setEndTime($end_time)->proceed();
@since 7.4
*/

class AssignLevel
{

    private $uid          = 0;
    private $lid          = 0;
    private $startTime    = '';
    private $endTime      = '';
    private $levelData    = array();
    private $currentTime  = '';

    public function __construct($uid=0, $lid=0)
    {
        $this->uid          = $uid;
        $this->lid          = $lid;
        $this->currentTime  = indeed_get_unixtimestamp_with_timezone();
    }

    public function setStartTime($startTime='')
    {
        if ($startTime){
            $this->startTime = $startTime;
        }
        return $this;
    }

    public function setEndTime($endTime='')
    {
        if ($endTime){
            $this->endTime = $endTime;
        }
        return $this;
    }

    public function setLevelData()
    {
        $this->levelData = ihc_get_level_by_id($this->lid);
        return $this;
    }

    public function proceed()
    {
      global $wpdb;

      if (empty($this->uid) || empty($this->lid)){
          return false;
      }

      $this->setLevelData();
      $startTime  = $this->getStartTime();
      $startTime  = indeed_get_current_time_with_timezone( $startTime );
      $endTime    = $this->getEndTime();
      $endTime    = indeed_get_current_time_with_timezone($endTime);
      $updateTime = indeed_get_current_time_with_timezone();

      if ($this->userGotLevel()){
          $query = $wpdb->prepare("INSERT INTO {$wpdb->prefix}ihc_user_levels VALUES(null, {$this->uid}, {$this->lid}, '$startTime', '$endTime', 0, 1);");
      } else {
          $query = $wpdb->prepare("
              UPDATE {$wpdb->prefix}ihc_user_levels
                  SET
                  start_time='$startTime',
                  update_time='$updateTime',
                  expire_time='$endTime',
                  notification=0,
                  status=1
                  WHERE
                  user_id={$this->uid}
                  AND level_id={$this->lid};
          ");
      }
      $wpdb->query($q);
      do_action('ihc_new_subscription_action', $this->uid, $this->lid);
    }

    private function userGotLevel()
    {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare("SELECT user_id FROM {$wpdb->prefix}ihc_user_levels WHERE user_id={$this->uid} AND level_id={$this->lid} "));
    }

    public function getStartTime()
    {
        if ($this->startTime){
            return $this->startTime;
        }

        if (empty($this->levelData['access_type'])){
          $this->levelData['access_type'] = 'unlimited';
        }

        if ( $this->levelData['access_type']=='date_interval' && !empty($this->levelData['access_interval_start']) ){
          $this->startTime = strtotime($this->levelData['access_interval_start']);
        } else {
          $this->startTime = $this->currentTime;
          ////// MAGIC FEAT - SUBSCRIPTION DELAY /////
          if (ihc_is_magic_feat_active('subscription_delay')){
            $delayTime = \Ihc_Db::level_get_delay_time($this->lid);
            if ($delayTime!==FALSE){
              $this->startTime = $this->startTime + $delayTime;
            }
          }
          ////// MAGIC FEAT - SUBSCRIPTION DELAY /////
        }
        return $this->startTime;
    }

    public function getEndTime()
    {
        if ($this->endTime){
            return $this->endTime;
        }

        if ($this->levelData['payment_type']!='free'){ /// $this->is_public &&
          //end time will be expired, updated when payment
          $this->endTime = \Ihc_Db::user_get_expire_time_for_level($this->uid, $this->lid);
          if ($this->endTime===FALSE || strtotime($this->endTime)<$this->currentTime){
            $this->endTime = '0000-00-00 00:00:00';
          }
        } else {
          //it's admin or free so we set the correct expire time
          switch ($this->levelData['access_type']){
            case 'unlimited':
              $this->endTime = strtotime('+10 years', $this->currentTime);//unlimited will be ten years
              break;
            case 'limited':
              if (!empty($this->levelData['access_limited_time_type']) && !empty($this->levelData['access_limited_time_value'])){
                $multiply = ihc_get_multiply_time_value($this->levelData['access_limited_time_type']);
                $this->endTime = $this->currentTime + $multiply * $this->levelData['access_limited_time_value'];
              }
              break;
            case 'date_interval':
              if (!empty($this->levelData['access_interval_end'])){
                $this->endTime = strtotime($this->levelData['access_interval_end']);
              }
              break;
            case 'regular_period':
              if (!empty($this->levelData['access_regular_time_type']) && !empty($this->levelData['access_regular_time_value'])){
                $multiply = ihc_get_multiply_time_value($this->levelData['access_regular_time_type']);
                $this->endTime = $this->currentTime + $multiply * $this->levelData['access_regular_time_value'];
              }
              break;
          }

          /// user logs
          \Ihc_User_Logs::set_user_id($this->uid);
          \Ihc_User_Logs::set_level_id($this->lid);
          $username = \Ihc_Db::get_username_by_wpuid($this->uid);
          $levelName = \Ihc_Db::get_level_name_by_lid($this->lid);
          \Ihc_User_Logs::write_log($levelName . __(' become active for ', 'ihc') . $username, 'user_logs');
          do_action('ihc_action_after_subscription_activated', $this->uid, $this->lid);

          return $this->endTime;
        }
    }

}
