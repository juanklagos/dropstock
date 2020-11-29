<?php
namespace \Indeed\Ihc\Db;

class UserSubscriptions
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
    }
}
