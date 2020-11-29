<?php
if (class_exists('Ihc_Create_Orders_Manually')) return;

class Ihc_Create_Orders_Manually{
    private $_post_data = array();
    private $_status = 0;
    private $_reason = '';

    public function __construct($post_data=array()){
        $this->_post_data = $post_data;
    }

    public function process(){
        $uid = Ihc_Db::get_wpuid_by_username($this->_post_data['username']);
        if (empty($uid)){
            $this->_status = 0;
            $this->_reason = __('Wrong Username provided.', 'ihc');
            return;
        }

        if (empty($this->_post_data['create_date'])){
            $this->_status = 0;
            $this->_reason = __('No created date provided.', 'ihc');
            return;
        }

        if (empty($this->_post_data['lid'])){
            $this->_status = 0;
            $this->_reason = __('No level provided.', 'ihc');
            return;
        }

        if (empty($this->_post_data['ihc_payment_type'])){
            $this->_status = 0;
            $this->_reason = __('No payment gateway provided.', 'ihc');
            return;
        }

        ihc_handle_levels_assign($uid, $this->_post_data['lid']);
        
        $order_id = ihc_insert_update_order($uid,
                                            $this->_post_data['lid'],
                                            $this->_post_data['amount_value'],
                                            'pending',
                                            $this->_post_data['ihc_payment_type'],
                                            array(),
                                            $this->_post_data['amount_type']
        );

        if ($order_id){
            $this->_status = 1;
        } else {
            $this->_status = 0;
            $this->_reason = __('Error', 'ihc');
        }

    }

    public function get_status(){
        return $this->_status;
    }

    public function get_reason(){
        return $this->_reason;
    }

}
