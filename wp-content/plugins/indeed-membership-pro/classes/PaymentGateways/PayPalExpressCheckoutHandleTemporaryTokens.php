<?php
namespace Indeed\Ihc\PaymentGateways;
/*
Created v.7.4
Deprecated starting with v.9.3
*/
class PayPalExpressCheckoutHandleTemporaryTokens
{
    private $optionName = 'ihc_paypal_express_temp_tokens';

    public function save($token='')
    {
        $data = get_option($this->optionName);
        if (in_array($token, $data)){
            return false;
        }
        $data[] = $token;
        update_option($this->optionName, $data);
    }

    public function exists($token='')
    {
        $data = get_option($this->optionName);
        if (in_array($token, $data)){
            return true;
        }
        return false;
    }

    public function remove($token='')
    {
        $data = get_option($this->optionName);
        if (!in_array($token, $data)){
            return false;
        }
        $key = array_search($token, $data);
        if ($key===FALSE || !isset($data[$key])){
            return false;
        }
        unset($data[$key]);
        update_option($this->optionName, $data);
    }
}
