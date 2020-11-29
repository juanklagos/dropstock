<?php
namespace Indeed\Ihc;
/*
@since 7.4
@deprecated since 9.3
This class works with 'payment workflow' option set as 'Standard'.
*/
class CancelSubscription
{
    private $uid                  = 0;
    private $lid                  = 0;
    private $paymentGateway       = '';
    private $transactionId        = '';
    private $paymentData          = array();
    private $stopRedirectIfCase   = false;

    public function __construct($uid=0, $lid=0)
    {
        $this->uid            = $uid;
        $this->lid            = $lid;
        $this->setPaymentData();
    }

    private function setPaymentData()
    {
        global $wpdb;
      	$table = $wpdb->prefix . "indeed_members_payments";
      	$q = $wpdb->prepare("SELECT txn_id, payment_data FROM $table WHERE u_id=%d ORDER BY paydate DESC;", $this->uid);
      	$data = $wpdb->get_results($q);
        foreach ($data as $obj){
          $arr = json_decode($obj->payment_data, TRUE);
          if ( !isset($arr['lid'] ) || $arr['lid'] != $this->lid ){
              continue;
          }
          $completed = FALSE;
          if (!empty($arr['payment_status'])){
            $completed = TRUE;
          } else if (isset($arr['x_response_code']) && ($arr['x_response_code'] == 1)){
            $completed = TRUE;
          } else if (isset($arr['code']) && ($arr['code'] == 2)){
            $completed = TRUE;
          } else if (isset($arr['message']) && $arr['message']=='success'){
            $completed = TRUE;
          }

          if (!$completed){
            continue;
          }

          if ($this->isPayPalGateway($arr)){
              break;
          }

          if (isset($arr['ihc_payment_type'])){
            //in case we know the payment type
            $this->paymentGateway = $arr['ihc_payment_type'];
            if ($this->paymentGateway=='stripe' || $this->paymentGateway=='twocheckout' || $this->paymentGateway=='authorize' || $this->paymentGateway=='stripe_checkout_v2' ){
                $this->transactionId = $obj->txn_id;
                break;
            }
          } else {
            //don't know from where the payment was made
            $this->paymentGateway = get_option('ihc_payment_selected');
            if (isset($arr['level']) && $arr['level']==$l_id){
              $this->transactionId = $obj->txn_id;
            }
          }
        }//end of foreach
    }

    private function isPayPalGateway($arr=array())
    {
        if (!isset($arr['custom'])){
            return false;
        } else {
            $custom = json_decode($arr['custom'], TRUE);
            if ($custom['level_id']==$this->lid){
              //it's paypal and it's the level we want
              $this->transactionId = $obj->txn_id;
              $this->paymentGateway = 'paypal';
            }
        }
    }


    public function proceed()
    {
        if ( ( !$this->transactionId || !$this->uid ) && !$this->paymentGateway ){
            return;
        }

    		switch ( $this->paymentGateway ){
    			case 'paypal':
            //after we cancel the subscription in payment service, we must modify the status in our db
            $this->modifyStatusInDb();
            $object = new \Indeed\Ihc\PaymentGateways\PayPalStandard();
            $object->cancelSubscription( $this->stopRedirectIfCase );
    				break;
    			case 'stripe':
    				if (!class_exists('ihcStripe')){
    					require_once IHC_PATH . 'classes/PaymentGateways/ihcStripe.class.php';
    				}
    				$obj = new \ihcStripe();
    				$obj->cancel_subscription( $this->transactionId );
            //after we cancel the subscription in payment service, we must modify the status in our db
            $this->modifyStatusInDb();
    				break;
    			case 'twocheckout':
    				ihc_cancel_twocheckout_subscription( $this->transactionId );
            //after we cancel the subscription in payment service, we must modify the status in our db
            $this->modifyStatusInDb();
    				break;
    			case 'authorize':
    				if (!class_exists('ihcAuthorizeNet')){
    					require_once IHC_PATH . 'classes/PaymentGateways/ihcAuthorizeNet.class.php';
    				}
    				$obj = new \ihcAuthorizeNet();
    				$unsubscribe = $obj->cancel_subscription( $this->transactionId );
            //after we cancel the subscription in payment service, we must modify the status in our db
            $this->modifyStatusInDb();
    				break;
          case 'pagseguro':
            $obj = new \Indeed\Ihc\PaymentGateways\Pagseguro();
            $unsubscribe = $obj->cancelSubscription( $this->transactionId );
            //after we cancel the subscription in payment service, we must modify the status in our db
            $this->modifyStatusInDb();
            break;
          case 'stripe_checkout_v2':
            $obj = new \Indeed\Ihc\PaymentGateways\StripeCheckoutV2();
            $unsubscribe = $obj->cancelSubscription( $this->transactionId );
            if ( $unsubscribe ){
                //after we cancel the subscription in payment service, we must modify the status in our db
                $this->modifyStatusInDb();
            }
            break;
          case 'paypal_express_checkout':
            $this->modifyStatusInDb();
            $object = new \Indeed\Ihc\PaymentGateways\PayPalExpressCheckout();
            $object->cancelSubscription( $this->transactionId );
            break;
          default:
            $paymentObject = apply_filters( 'ihc_payment_gateway_create_payment_object', false, $this->paymentGateway );
            // @description

            if ( $paymentObject ){
                $paymentObject->cancelSubscription( $this->transactionId );
                //after we cancel the subscription in payment service, we must modify the status in our db
                $this->modifyStatusInDb();
            }
            break;
    		}
    }

    private function modifyStatusInDb()
    {
        global $wpdb;
        $table = $wpdb->prefix . "ihc_user_levels";
        $q = $wpdb->prepare("UPDATE $table SET status='0' WHERE user_id=%d AND level_id=%d;", $this->uid, $this->lid);
        $wpdb->query($q);
        do_action('ihc_action_after_cancel_subscription', $this->uid, $this->lid);
        // @description run after cancel subscription. @param user id (integer), level id (integer)
    }


    public function stopRedirectIfCase($value=false)
    {
        $this->stopRedirectIfCase = $value;
        return $this;
    }


}
