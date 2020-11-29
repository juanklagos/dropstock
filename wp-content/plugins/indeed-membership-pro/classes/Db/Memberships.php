<?php
/**
 * @since version 9.4
 getting all the memberships ( levels in old ump ):
 $memberships = \Indeed\Ihc\Db\Memberships::getAll();
 get one membership by name :
 $memberships = \Indeed\Ihc\Db\Memberships::getOneByName( $name='' );
 get one membership by id:
 $memberships = \Indeed\Ihc\Db\Memberships::getOne( $id=0 );
 delete one membership:
 \Indeed\Ihc\Db\Memberships::deleteOne( $id=0 );
 get membership name:
 \Indeed\Ihc\Db\Memberships::getMembershipName( $id=0 );
 get membership label:
 \Indeed\Ihc\Db\Memberships::getMembershipLabel( $id=0 );
 get membership short-description:
 \Indeed\Ihc\Db\Memberships::getMembershipShortDescription( $id=0 );
 */
namespace Indeed\Ihc\Db;

class Memberships
{
    private static $tablePrefix = '';

    /**
     * @param string
     * @return none
     */
    public static function setTablePrefix( $prefix='' )
    {
        self::$tablePrefix = $prefix;
    }

    /**
     * @param none
     * @return bool
     */
    public static function createTables()
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
  			if ($wpdb->get_var( "show tables like '{$dbPrefix}ihc_memberships'" ) != $dbPrefix . 'ihc_memberships' ){
    				require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    				$sql = "CREATE TABLE {$dbPrefix}ihc_memberships (
    															id int(11) NOT NULL AUTO_INCREMENT,
    															name VARCHAR(200) NOT NULL,
    															label VARCHAR(200) NOT NULL,
                                  short_description VARCHAR(400),
                                  payment_type VARCHAR(50),
                                  price DECIMAL(12, 2) DEFAULT 0,
    															status TINYINT(1) DEFAULT 1,
                                  the_order INT(6),
    															created_at INT(11),
    															PRIMARY KEY (`id`),
    															INDEX idx_ihc_memberships_id (`id`)
    				);
    				";
    				dbDelta ( $sql );
  			}
        if ($wpdb->get_var( "show tables like '{$dbPrefix}ihc_memberships_meta'" ) != $dbPrefix . 'ihc_memberships_meta' ){
            require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
            $sql = "CREATE TABLE {$dbPrefix}ihc_memberships_meta (
                                  id INT(11) NOT NULL AUTO_INCREMENT,
                                  membership_id INT(11) NOT NULL,
                                  meta_key VARCHAR(300) NOT NULL,
                                  meta_value TEXT,
                                  PRIMARY KEY (`id`),
                                  INDEX idx_ihc_memberships_meta_membership_id (`membership_id`)
            );
            ";
            dbDelta ( $sql );
        }
    }

    /**
     * @param none
     * @return bool
     */
    public static function importLevels()
    {
        $memberships = get_option( 'ihc_levels' );
        if ( !$memberships || !is_array( $memberships ) ){
            return false;
        }
        foreach ( $memberships as $id => $membershipData ){
            $membershipData['id'] = $id;
            self::save( $membershipData );
        }
    }

    /**
     * @param array
     * @return array
     */
    public static function save( $data=[] )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$data ){
            return [
                      'success'     => false,
                      'reason'      => __( 'No data provided.', 'ihc' ),
            ];
        }
        $membershipDefaultValues = [
                      'level_id'            => 0,
                      'name'                => '',
                      'label'               => '',
                      'short_description'   => '',
                      'payment_type'        => '',
                      'price'               => '',
                      'status'              => '',
                      'order'               => '',
                      'created_at'          => time(),
        ];
        foreach ( $membershipDefaultValues as $key => $value ){
           if ( !isset( $data[$key] ) ){
              $data[$key] = $value;
           }
        }
        if ( !empty( $data['level_id'] ) && self::getOne( $data['level_id'] ) ){
            // update
            $query = $wpdb->prepare( "UPDATE {$dbPrefix}ihc_memberships
                                        SET
                                        name=%s,
                                        label=%s,
                                        short_description=%s,
                                        payment_type=%s,
                                        price=%s,
                                        status=%s,
                                        the_order=%s
                                        WHERE
                                        id=%d
            ", $data['name'], $data['label'], $data['short_description'], $data['payment_type'],
               $data['price'], $data['status'], $data['order'], $data['level_id'] );
            $result = $wpdb->query( $query );
        } else {
            if ( self::getOneByName( $data['name'] ) ){
                return [
                          'success'     => false,
                          'reason'      => __( 'Membership name already exists.', 'ihc' ),
                ];
            }
            // create
            $query = $wpdb->prepare( "INSERT INTO {$dbPrefix}ihc_memberships
                                        VALUES( %s, %s, %s, %s, %s, %s, %s, %s, %s )
            ", $data['level_id'],
               $data['name'],
               $data['label'],
               $data['short_description'],
               $data['payment_type'],
               $data['price'],
               $data['status'],
               $data['order'],
               $data['created_at']
            );
            $result = $wpdb->query( $query );
            $data['level_id'] = $wpdb->insert_id;
        }
        if ( $result === false || $data['level_id'] == 0 ){
          return [
                    'success'     => false,
                    'reason'      => __( 'Something went wrong.', 'ihc' ),
          ];
        }
        // meta
        foreach ( $data as $key => $value ){
            if ( isset( $membershipDefaultValues[$key] ) ){
                continue;
            }
            self::saveMeta( $data['level_id'], $key, $value );
        }
        return [
                  'success'     => true,
                  'reason'      => __( 'Completed.', 'ihc' ),
                  'id'          => $data['level_id'],
        ];
    }

    /**
     * @param int
     * @return bool
     */
    public static function deleteOne( $id=0 )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$id ){
            return false;
        }
        $query = $wpdb->prepare( "DELETE FROM {$dbPrefix}ihc_memberships WHERE id=%d;", $id );
        $wpdb->query( $query );
        $query = $wpdb->prepare( "DELETE FROM {$dbPrefix}ihc_memberships_meta WHERE membership_id=%d;", $id );
        return $wpdb->query( $query );
    }

    /**
     * @param int
     * @return array
     */
    public static function getOne( $id=0 )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$id ){
            return false;
        }
        $query = $wpdb->prepare( "SELECT * FROM {$dbPrefix}ihc_memberships
                                    WHERE id=%d
        ", $id );
        $membership = $wpdb->get_row( $query );
        if ( !$membership ){
            return false;
        }
        $membership = (array)$membership;
        $metas = self::getAllMetaForMembership( $id );
        return array_merge( $membership, $metas );
    }


      /**
        * @param string
        * @return array
        */
    public static function getOneByName( $name='' )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( $name == '' ){
          return false;
        }
        $query = $wpdb->prepare( "SELECT * FROM {$dbPrefix}ihc_memberships WHERE name=%s;", $name );
        $membership = $wpdb->get_row( $query );
        if ( !$membership ){
          return false;
        }
        $membership = (array)$membership;
        $metas = self::getAllMetaForMembership( $membership['id'] );
        return array_merge( (array)$membership, $metas );
    }

    /**
     * @param int
     * @return string
     */
    public static function getMembershipName( $id=0 )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$id ){
            return '';
        }
        $query = $wpdb->prepare( "SELECT name FROM {$dbPrefix}ihc_memberships WHERE id=%d", $id );
        return $wpdb->get_var( $query );
    }

   /**
    * @param int
    * @return string
    */
    public static function getMembershipLabel( $id=0 )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$id ){
          return '';
        }
        $query = $wpdb->prepare( "SELECT label FROM {$dbPrefix}ihc_memberships WHERE id=%d", $id );
        return $wpdb->get_var( $query );
    }

    /**
     * @param int
     * @return string
     */
    public static function getMembershipShortDescription( $id=0 )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$id ){
          return '';
        }
        $query = $wpdb->prepare( "SELECT short_description FROM {$dbPrefix}ihc_memberships WHERE id=%d", $id );
        return $wpdb->get_var( $query );
    }

    /**
     * @param none
     * @return array
     */
    public static function getAll()
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        $query = "SELECT * FROM {$dbPrefix}ihc_memberships
                        ORDER BY id ASC
        ";
        $memberships = $wpdb->get_results( $query );

        if ( !$memberships ){
            return false;
        }
        foreach ( $memberships as $object ){
            $metas = self::getAllMetaForMembership( $object->id );
            $returnData[$object->id] = array_merge( (array)$object, $metas );
        }
        return $returnData;
    }

    /**
     * @param int
     * @param string
     * @return bool
     */
    public static function getAllMetaForMembership( $membershipId=0 )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$membershipId ){
            return false;
        }
        $query = $wpdb->prepare( "SELECT meta_key, meta_value
                            FROM {$dbPrefix}ihc_memberships_meta
                            WHERE membership_id=%d;", $membershipId );
        $all = $wpdb->get_results( $query );
        if ( !$all ){
            return [];
        }
        foreach ( $all as $object ){
            $meta[ $object->meta_key ] = $object->meta_value;
        }
        return $meta;
    }


    /**
     * @param int
     * @param string
     * @return bool
     */
    public static function getOneMeta( $membershipId=0, $metaKey='' )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$membershipId || $metaKey == '' ){
            return false;
        }
        $query = $wpdb->prepare( "SELECT meta_value
                            FROM {$dbPrefix}ihc_memberships_meta
                            WHERE membership_id=%d
                            AND meta_key=%s;", $membershipId, $metaKey );
        return $wpdb->get_var( $query );
    }

    /**
     * @param int
     * @param string
     * @return bool
     */
    public static function deleteOneMeta( $membershipId=0, $metaKey='' )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$membershipId ){
            return false;
        }
        $query = $wpdb->prepare( "DELETE FROM
                                    {$dbPrefix}ihc_memberships_meta
                                    WHERE membership_id=%d AND meta_key=%s;", $membershipId, $metaKey );
        return $wpdb->query( $query );
    }

    /**
     * @param int
     * @param string
     * @return bool
     */
    public static function deleteAllMetaForMembership( $membershipId=0 )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$membershipId ){
            return false;
        }
        $query = $wpdb->prepare( "DELETE FROM
                                    {$dbPrefix}ihc_memberships_meta
                                    WHERE membership_id=%d;", $membershipId );
        return $wpdb->query( $query );
    }

    /**
     * @param int
     * @param string
     * @param string
     * @return bool
     */
    public static function saveMeta( $membershipId=0, $metaKey='', $metaValue='' )
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;
        if ( !$membershipId || $metaKey == '' ){
            return false;
        }
        if ( self::getOneMeta( $membershipId, $metaKey ) ){
            // update
            $query = $wpdb->prepare( "UPDATE {$dbPrefix}ihc_memberships_meta
                                        SET meta_value=%s
                                        WHERE
                                        membership_id=%d
                                        AND
                                        meta_key=%s
            ", $metaValue, $membershipId, $metaKey );
        } else {
            // create
            $query = $wpdb->prepare( "INSERT INTO {$dbPrefix}ihc_memberships_meta
                                        VALUES( NULL, %d, %s, %s );
            ", $membershipId, $metaKey, $metaValue );
        }
        return $wpdb->query( $query );
    }

}
