<?php
namespace Indeed\Ihc;
/*
 * @since 7.4
 */

class Updates
{
    /**
     * @var string
     */
    private $optionName = 'ihc_plugin_current_version';

    /**
     * @param none
     * @return none
     */
    public function __construct()
    {
        add_action( 'init', array( $this, 'check' ) );
    }

    /**
     * @param none
     * @return none
     */
    public function check()
    {
        $currentVersion = indeed_get_plugin_version( IHC_PATH . 'indeed-membership-pro.php' );
        $versionValueInDatabase = get_option( $this->optionName );
        if ( !$versionValueInDatabase ){
            $versionValueInDatabase = '7.3';
        }

        if ( version_compare( '7.3', $versionValueInDatabase ) >= 0 ){ // if the version is 7.3 or lower
            $this->oldUpdates();// DEPRECATED
        }

        if ( version_compare( '8', $versionValueInDatabase )==1 ){
            $this->addIndexes();
        }

        if ( version_compare( $currentVersion, $versionValueInDatabase )==1 ){
            $this->updateRegisterFields();
            update_option( $this->optionName, $currentVersion );
        }

        if ( version_compare( '8.7', $versionValueInDatabase )==1 ){
            $this->removeCsvOldFiles();
            $this->removeOldExportFiles();
        }

        if ( version_compare( '9.4', $versionValueInDatabase )==1 ){
            \Ihc_Db::create_tables();
        }
    }

    /**
     * @param none
     * @return none
     */
    public function updateRegisterFields()
    {
        $data = get_option( 'ihc_user_fields' );
        if ( !$data ){
            return false;
        }
        foreach ( $data as $fieldData ){
            if ( !isset( $fieldData['display_on_modal'] ) ){
                $fieldData['display_on_modal'] = 0;
            }
        }
        ///
        require_once IHC_PATH . 'admin/includes/functions/register.php'; /// double check this

        if ( ihc_array_value_exists( $data, 'ihc_optin_accept', 'name' ) === false ){
            $fieldData = array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'ihc_optin_accept', 'label' => __( 'Accept Opt-in', 'ihc' ), 'type'=>'single_checkbox', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' );
            ihc_save_user_field($fieldData);
        }
        if ( ihc_array_value_exists( $data, 'ihc_memberlist_accept', 'name' ) === false ){
            $fieldData = array( 'display_admin'=>0, 'display_public_reg'=>0, 'display_public_ap'=>0, 'display_on_modal'=> 0, 'name'=>'ihc_memberlist_accept', 'label' => __( 'Accept display on Memberlist', 'ihc' ), 'type'=>'single_checkbox', 'native_wp' => 0, 'req' => 0, 'sublevel' => '' );
            ihc_save_user_field($fieldData);
        }
    }

    /**
     * @since version 9
     * @param none
     * @return none
     */
    public function addIndexes()
    {
        $this->userLevelsIndex();
        $this->userLogsIndex();
        $this->membersPaymentsIndex();
        $this->ordersIndex();
        $this->orderMetaIndex();
    }

    /**
     * @since version 9
     * @param none
     * @return none
     */
    private function userLevelsIndex()
    {
        global $wpdb;
        $indexList = $wpdb->get_results( "SHOW INDEX FROM {$wpdb->prefix}ihc_user_levels;");
        if ( !$indexList ){
            return;
        }
        foreach ( $indexList as $indexObject ){
            if ( isset( $indexObject->Key_name ) && $indexObject->Key_name == 'idx_ihc_user_levels_user_id' ){
                return;
            }
        }
        $wpdb->query( "CREATE INDEX idx_ihc_user_levels_user_id ON {$wpdb->prefix}ihc_user_levels(user_id)" );
    }

    /**
     * @since version 9
     * @param none
     * @return none
     */
    private function userLogsIndex()
    {
        global $wpdb;
        $indexList = $wpdb->get_results( "SHOW INDEX FROM {$wpdb->prefix}ihc_user_logs;" );
        if ( !$indexList ){
            return;
        }
        foreach ( $indexList as $indexObject ){
            if ( isset( $indexObject->Key_name ) && $indexObject->Key_name == 'idx_ihc_user_logs_uid' ){
                return;
            }
        }
        $wpdb->query( "CREATE INDEX idx_ihc_user_logs_uid ON {$wpdb->prefix}ihc_user_logs(uid)" );
    }

    /**
     * @since version 9
     * @param none
     * @return none
     */
    private function membersPaymentsIndex()
    {
        global $wpdb;
        $indexList = $wpdb->get_results( "SHOW INDEX FROM {$wpdb->prefix}indeed_members_payments;" );
        if ( !$indexList ){
            return;
        }
        foreach ( $indexList as $indexObject ){
            if ( isset( $indexObject->Key_name ) && $indexObject->Key_name == 'idx_indeed_members_payments_uid' ){
                return;
            }
        }
        $wpdb->query( "CREATE INDEX idx_indeed_members_payments_uid ON {$wpdb->prefix}indeed_members_payments(u_id)" );
    }

    /**
     * @since version 9
     * @param none
     * @return none
     */
    private function ordersIndex()
    {
        global $wpdb;
        $indexList = $wpdb->get_results( "SHOW INDEX FROM {$wpdb->prefix}ihc_orders;" );
        if ( !$indexList ){
            return;
        }
        foreach ( $indexList as $indexObject ){
            if ( isset( $indexObject->Key_name ) && $indexObject->Key_name == 'idx_ihc_orders_uid' ){
                return;
            }
        }
        $wpdb->query( "CREATE INDEX idx_ihc_orders_uid ON {$wpdb->prefix}ihc_orders(uid)" );
    }

    /**
     * @since version 9
     * @param none
     * @return none
     */
    private function orderMetaIndex()
    {
        global $wpdb;
        $indexList = $wpdb->get_results( "SHOW INDEX FROM {$wpdb->prefix}ihc_orders_meta;" );
        if ( !$indexList ){
            return;
        }
        foreach ( $indexList as $indexObject ){
            if ( isset( $indexObject->Key_name ) && $indexObject->Key_name == 'idx_ihc_orders_meta_order_id' ){
                return;
            }
        }
        $wpdb->query( "CREATE INDEX idx_ihc_orders_meta_order_id ON {$wpdb->prefix}ihc_orders_meta(order_id)" );
    }

    /**
     * @param none
     * @return none
     */
    private function removeCsvOldFiles()
    {
        $directory = IHC_PATH;
        $files = scandir( $directory );
        foreach ( $files as $file ){
            $fileFullPath = $directory . $file;
            if ( file_exists( $fileFullPath ) && filetype( $fileFullPath ) == 'file' ){
                $extension = pathinfo( $fileFullPath, PATHINFO_EXTENSION );
        				if ( $extension == 'csv' && $file == 'users.csv' ){
                    unlink( $fileFullPath );
                }
            }
        }
    }

    /**
     * @param none
     * @return none
     */
    private function removeOldExportFiles()
    {
        $directory = IHC_PATH;
        $files = scandir( $directory );
        foreach ( $files as $file ){
            $fileFullPath = $directory . $file;
            if ( file_exists( $fileFullPath ) && filetype( $fileFullPath ) == 'file' ){
                $extension = pathinfo( $fileFullPath, PATHINFO_EXTENSION );
                if ( $extension == 'xml' && $file == 'export.xml' ){
                    unlink( $fileFullPath );
                }
            }
        }
    }

    /**
     * @param none
     * @return none
     */
    public function oldUpdates()
    {
        \Ihc_Db::create_tables();
        \Ihc_Db::update_tables_structure();

        if ( get_option('ihc_update_version13') === false ){

          \Ihc_Db::add_new_role();

          /// REGISTER FIELDS
          $data = get_option('ihc_user_fields');
          if ($data){
              require_once IHC_PATH . 'admin/includes/functions/register.php';
              //////////////// AVATAR
              if (ihc_array_value_exists($data, 'ihc_avatar', 'name')===FALSE){
                $field_data = array('name'=>'ihc_avatar', 'type'=>'upload_image', 'label'=>'Avatar');
                ihc_save_user_field($field_data);
              }
              //////////////// COUPON
              if (ihc_array_value_exists($data, 'ihc_coupon', 'name')===FALSE){
                $field_data = array('name'=>'ihc_coupon', 'type'=>'text', 'label'=>'Coupon');
                ihc_save_user_field($field_data);
              }
              //////////////// SELECT PAYMENT
              if (ihc_array_value_exists($data, 'payment_select', 'name')===FALSE){
                $field_data = array('name'=>'payment_select', 'type'=>'payment_select', 'label'=>'Select Payment', 'theme'=>'ihc-select-payment-theme-1');
                ihc_save_user_field($field_data);
              }
              //////////////// SOCIAL MEDIA
              if (ihc_array_value_exists($data, 'ihc_social_media', 'name')===FALSE){
                $field_data = array('name'=>'ihc_social_media', 'type'=>'social_media', 'label'=>'-');
                ihc_save_user_field($field_data);
              }
              //////// IHC_COUNTRY
              if (ihc_array_value_exists($data, 'ihc_country', 'name')===FALSE){
                $field_data = array('name'=>'ihc_country', 'type'=>'ihc_country', 'label'=>'Country', 'native_wp' => 0);
                ihc_save_user_field($field_data);
              } else {
                $temp_field_id = ihc_array_value_exists($data, 'ihc_country', 'name');
                $field_data = array('name'=>'ihc_country', 'native_wp' => 0, 'id'=>$temp_field_id);
                ihc_update_register_fields($field_data);
              }
              //////// ihc_invitation_code_field
              if (ihc_array_value_exists($data, 'ihc_invitation_code_field', 'name')===FALSE){
                $field_data = array('display_admin'=>0, 'display_public_reg'=>1, 'display_public_ap'=>0, 'name'=>'ihc_invitation_code_field', 'label'=>'Invitation Code', 'type'=>'ihc_invitation_code_field', 'native_wp' => 0, 'req' => 2, 'sublevel' => '');
                ihc_save_user_field($field_data);
              }
              //////// IHC_STATE
              if (ihc_array_value_exists($data, 'ihc_state', 'name')===FALSE){
                $field_data = array('name'=>'ihc_state', 'type'=>'ihc_state', 'label'=>'State');
                ihc_save_user_field($field_data);
              }
              if (ihc_array_value_exists($data, 'ihc_dynamic_price', 'name')===FALSE){
                $field_data = array('name'=>'ihc_dynamic_price', 'type'=>'ihc_dynamic_price', 'label'=>'Price');
                ihc_save_user_field($field_data);
              }

              ///////////// PASSWORD FIELD UPDATE
              $register_arr = get_option('ihc_user_fields');
              $key = ihc_array_value_exists($register_arr, 'pass1', 'name');
              $update_arr = $register_arr[$key];
              $update_arr['id'] = $key;
              if ($update_arr['display_admin']==2){
                $update_arr['display_admin'] = 1;
              }
              if ($update_arr['display_public_ap']==2){
                $update_arr['display_public_ap'] = 1;
              }
              ihc_update_register_fields($update_arr);

              $data = get_option('ihc_user_fields');
              foreach ($data as $k => $v){
                $new_data[$k] = $v;
                if (isset($new_data[$k]['display'])){
                  $new_data[$k]['display_admin'] = $new_data[$k]['display'];
                  $new_data[$k]['display_public_reg'] = $new_data[$k]['display'];
                  $new_data[$k]['display_public_ap'] = $new_data[$k]['display'];
                  $new_data[$k]['display_on_modal'] = $new_data[$k]['display'];
                  unset($new_data[$k]['display']);
                }
                if (empty($new_data[$k]['sublabel'])){
                  $new_data[$k]['sublabel'] = '';
                }
              }
              update_option('ihc_user_fields', $new_data);
            }

            /// NOTIFICATIONS
            \Ihc_Db::create_notifications();

            //UPDATE STRIPE TRANSACTIONS
            ihc_update_stripe_subscriptions();
            update_option('ihc_update_version13', 1);//ihc_update_version
        }
    }

}
