<?php
namespace Indeed\Ihc\Db;

/*
Save:
\Indeed\Ihc\Db\UserSubscriptionsMeta::save( $subscriptionId, $metaKey, $metaValue );
Get meta for subscription:
\Indeed\Ihc\Db\UserSubscriptionsMeta::getOne( $subscriptionId, $metaKey );
Get all metas for subscription:
\Indeed\Ihc\Db\UserSubscriptionsMeta::getAllForSubscription( $subscriptionId );
Delete one meta:
\Indeed\Ihc\Db\UserSubscriptionsMeta::deleteOne( $subscriptionId, $metaKey );
Delete all metas for subscription:
\Indeed\Ihc\Db\UserSubscriptionsMeta::deleteAllForSubscription( $subscriptionId );
*/

class UserSubscriptionsMeta
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
    public static function createTable()
    {
        global $wpdb;
        $dbPrefix = self::$tablePrefix == '' ? $wpdb->prefix : self::$tablePrefix;

        if ($wpdb->get_var( "show tables like '{$dbPrefix}ihc_user_subscriptions_meta'" ) != $dbPrefix . 'ihc_user_subscriptions_meta' ){
            require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
            $sql = "CREATE TABLE {$dbPrefix}ihc_user_subscriptions_meta (
                                  id BIGINT(20) NOT NULL AUTO_INCREMENT,
                                  subscription_id BIGINT(20) NOT NULL,
                                  meta_key VARCHAR(300) NOT NULL,
                                  meta_value TEXT,
                                  PRIMARY KEY (`id`),
                                  INDEX idx_ihc_user_subscriptions_meta_subscription_id (`subscription_id`)
            );
            ";
            dbDelta ( $sql );
        }
    }

    /**
     * @param int
     * @param string
     * @param string
     * @return bool
     */
    public static function save( $subscriptionId=0, $metaKey='', $metaValue='' )
    {
        global $wpdb;
        if ( !$subscriptionId || $metaKey == '' ){
            return false;
        }
        if ( self::getOne( $subscriptionId, $metaKey ) !== false ){
            // update
            $query = $wpdb->prepare( "UPDATE {$wpdb->prefix}ihc_user_subscriptions_meta SET
                                        meta_value=%s
                                        WHERE
                                        meta_key=%s
                                        AND
                                        subscription_id=%d
            ", $metaValue, $metaKey, $subscriptionId );
        } else {
            // create
            $query = $wpdb->prepare( "INSERT INTO {$wpdb->prefix}ihc_user_subscriptions_meta
                                        VALUES( null, %d, %s, %s );", $subscriptionId, $metaKey, $metaValue );
        }
        $wpdb->query( $query );
    }

    /**
     * @param int
     * @param string
     * @return mixed
     */
    public static function getOne( $subscriptionId=0, $metaKey='' )
    {
        global $wpdb;
        if ( !$subscriptionId ){
            return false;
        }
        $query = $wpdb->prepare( "SELECT meta_value
                                      FROM {$wpdb->prefix}ihc_user_subscriptions_meta
                                      WHERE
                                      subscription_id=%d
                                      AND
                                      meta_key=%s
        ", $subscriptionId, $metaKey );
        $metaValue = $wpdb->get_var( $query );
        if ( $metaValue === null ){
            return false;
        }
        return $metaValue;
    }

    /**
     * @param int
     * @return array
     */
    public static function getAllForSubscription( $subscriptionId=0 )
    {
        global $wpdb;
        if ( !$subscriptionId ){
            return [];
        }
        $query = $wpdb->prepare( "SELECT meta_key, meta_value
                                      FROM {$wpdb->prefix}ihc_user_subscriptions_meta
                                      WHERE
                                      subscription_id=%d
        ", $subscriptionId );
        $allMetas = $wpdb->get_results( $query );
        if ( !$allMetas ){
            return [];
        }
        foreach ( $allMetas as $object ){
            $metas[$object->meta_key] = $object->meta_value;
        }
        return $metas;
    }

    /**
     * @param int
     * @param string
     * @return bool
     */
    public static function deleteOne( $subscriptionId=0, $metaKey='' )
    {
        global $wpdb;
        if ( !$subscriptionId || $metaKey == '' ){
            return false;
        }
        $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}ihc_user_subscriptions_meta WHERE id=%d AND meta_key=%s;", $subscriptionId, $metaKey );
        return $wpdb->query( $query );
    }

    /**
     * @param int
     * @return bool
     */
    public static function deleteAllForSubscription( $subscriptionId=0 )
    {
      global $wpdb;
      if ( !$subscriptionId ){
          return false;
      }
      $query = $wpdb->prepare( "DELETE FROM {$wpdb->prefix}ihc_user_subscriptions_meta WHERE subscription_id=%d;", $subscriptionId );
      return $wpdb->query( $query );
    }
}
