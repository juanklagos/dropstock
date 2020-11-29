<?php
namespace Indeed\Ihc;
if ( !class_exists('UserAddEdit') ){
    require_once IHC_PATH . 'classes/UserAddEdit.class.php';
}

class RegisterOnModal extends \UserAddEdit
{
    public function save_update_user()
    {
        $this->payment_gateway = '';
        return parent::save_update_user();
    }
}
