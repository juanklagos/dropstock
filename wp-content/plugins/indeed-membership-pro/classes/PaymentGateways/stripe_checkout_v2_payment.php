<?php
require_once '../../../../../wp-load.php';
require_once 'stripe_checkout_v2/vendor/autoload.php';

if ( empty( $_GET['sessionId'] ) ){
    die;
}

$key = get_option( 'ihc_stripe_checkout_v2_publishable_key' );
$secretKey = get_option( 'ihc_stripe_checkout_v2_secret_key' );
if ( !$secretKey || !$key ){
    die;
}
\Stripe\Stripe::setApiKey( $secretKey );
$session = \Stripe\Checkout\Session::retrieve( $_GET['sessionId'] );
if ( !$session ){
    die;
}
?>
<script src="https://js.stripe.com/v3"></script>
<script>
/// redirect to checkout
var stripe = Stripe( '<?php echo $key;?>' );
stripe.redirectToCheckout({
  sessionId: '<?php echo $_GET['sessionId'];?>'
}).then(function (result) {});

</script>
