<?php
namespace Indeed\Ihc\Db;

class Orders
{
    private $id             = 0;
    private $data           = null;

    public function setData( $data = array() )
    {
        if ( !$data ){
            return;
        }
        foreach ( $data as $key => $value ){
            $this->data[ $key ] = $value;
        }
        return $this;
    }

    public function setId( $id=0 )
    {
        $this->id = $id;
        return $this;
    }

    public function fetch()
    {
        global $wpdb;
        $query = $wpdb->prepare( "SELECT id, uid, lid, amount_type, amount_value, automated_payment, status, create_date FROM {$wpdb->prefix}ihc_orders WHERE id=%d;", $this->id );
        $this->data = $wpdb->get_row( $query );
        $this->data = $this->data;
        return $this;
    }

    public function get()
    {
        return $this->data;
    }

    public function save()
    {
        global $wpdb;
        $query = $wpdb->prepare( "SELECT id, uid, lid, amount_type, amount_value, automated_payment, status, create_date FROM {$wpdb->prefix}ihc_orders WHERE id=%d;", $this->id );
        $writeData = $wpdb->get_row( $query );
        if ( $writeData ){
            /// update
            $writeData = (array)$writeData;
            foreach ( $this->data as $key => $value ){
                $writeData[$key] = $value;
            }
            $query = $wpdb->prepare( "UPDATE {$wpdb->prefix}ihc_orders SET
                                          uid=%d,
                                          lid=%d,
                                          amount_type=%s,
                                          amount_value=%s,
                                          automated_payment=%s,
                                          status=%s,
                                          create_date=%s
                                          WHERE id=%d;",
            $writeData['uid'], $writeData['lid'], $writeData['amount_type'], $writeData['amount_value'], $writeData['automated_payment'],
            $writeData['status'], $writeData['create_date'], $writeData['id'] );
            $wpdb->query( $query );
            do_action( 'ump_payment_check', $writeData['id'], 'update' );
            return $writeData['id'];
        } else {
            /// insert

            /// since version 8.6, before we used NOW() function in mysql
            $currentDate = indeed_get_current_time_with_timezone();

            $query = $wpdb->prepare( "INSERT INTO {$wpdb->prefix}ihc_orders
                                          VALUES( NULL, %d, %d, %s, %s, %d, %s, %s );",
            $this->data['uid'], $this->data['lid'], $this->data['amount_type'], $this->data['amount_value'], $this->data['automated_payment'],
            $this->data['status'], $currentDate );
            $wpdb->query( $query );

            do_action( 'ihc_action_after_order_placed', $this->data['uid'], $this->data['lid'] );
            do_action( 'ump_payment_check', $wpdb->insert_id, 'insert' );
            return $wpdb->insert_id;
        }

    }

    public function getStatus()
    {
        return isset( $this->data->status ) ? $this->data->status : false;
    }

    public function update( $colName='', $value='' )
    {
        global $wpdb;
        if ( !$colName || !$value || empty($this->id) ){
            return false;
        }
        $colName = esc_sql( $colName );
        $queryString = $wpdb->prepare( "UPDATE {$wpdb->prefix}ihc_orders SET $colName=%s WHERE id=%d;", $value, $this->id );

        $result = $wpdb->query( $queryString );
        do_action( 'ump_payment_check', $this->id, 'update' );
        return $result;
    }
}
