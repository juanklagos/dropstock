<?php
if ( ! defined( 'ABSPATH' ) ) exit;

//////////////////////////////////////////
/////////////// AJAX CART ///////////////
//////////////////////////////////////////

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (isset($mydata['other_settings_ajax_add_to_cart'][0])) {
$check_enable_ajax_cart = $mydata['other_settings_ajax_add_to_cart'][0];
}
else {
  $check_enable_ajax_cart = "0";
}
//$check_minicart_hover_click = $mydata['minicart_hover_click'][0];

if ($check_enable_ajax_cart == 1) {


	function bodycommerce_ajax_add_to_cart_script() {
    $mydata = get_option( 'divi-bodyshop-woo_options' );
    $mydata = unserialize($mydata);

    if (isset($mydata['other_settings_ajax_add_to_cart'][0])) {
    $other_settings_ajax_add_to_cart = $mydata['other_settings_ajax_add_to_cart'][0];

if ($other_settings_ajax_add_to_cart == 1) {


    if (isset($mydata['ajax_atc_js_method_1'][0])) {
    $check_ajax_atc_js_method_display = $mydata['ajax_atc_js_method_1'][0];
}
else {
$check_ajax_atc_js_method_display = "1";
}
if ($check_ajax_atc_js_method_display == 1) {
  wp_enqueue_script( 'bodycommerce-add-to-cart-ajax', plugins_url() . '/divi-bodycommerce/scripts/add-to-cart-ajax.min.js', array('jquery'), DE_DB_WOO_VERSION, true );
}
else {
  wp_enqueue_script( 'bodycommerce-add-to-cart-ajax-alternative', plugins_url() . '/divi-bodycommerce/scripts/add-to-cart-ajax-alter.min.js', array('jquery'), DE_DB_WOO_VERSION, true );
}


}
else {
  // code...
}



}
  }
	add_action( 'wp_enqueue_scripts', 'bodycommerce_ajax_add_to_cart_script',99 );


  // BUNDLE CALLBACK
  	add_action( 'wp_ajax_bodycommerce_ajax_add_to_cart_woo_bundle', 'bodycommerce_ajax_add_to_cart_woo_bundle_callback' );
  	add_action( 'wp_ajax_nopriv_bodycommerce_ajax_add_to_cart_woo_bundle', 'bodycommerce_ajax_add_to_cart_woo_bundle_callback' );

  	function bodycommerce_ajax_add_to_cart_woo_bundle_callback() {

  		ob_start();

  		$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) ); // phpcs:ignore
      $quantity = "0"; // phpcs:ignore
  		$grouped_data = $_POST['grouped_data']; // phpcs:ignore
      $testarray = array();

foreach ($grouped_data as $key => $value) {

    $product_id = str_replace("product-", '', $key) ;

    $quantity = $value;

    $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
    if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity  ) ) {
    do_action( 'woocommerce_ajax_added_to_cart', $product_id );
    }

  }

  if ( $passed_validation) {
WC_AJAX::get_refreshed_fragments();
}  else  {
// $this->json_headers(); // REMOVED AS WAS THROWING AN ERROR

// If there was an error adding to the cart, redirect to the product page to show any errors
$data = array(
  'error' => true,
  'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
  );
echo json_encode( $data );
}

  $return = array(
      'product_id' => $testarray
  );

  ob_end_clean();

        		die();


}




// VARIATION CALLBACK
	add_action( 'wp_ajax_bodycommerce_ajax_add_to_cart_woo', 'bodycommerce_ajax_add_to_cart_woo_callback' );
	add_action( 'wp_ajax_nopriv_bodycommerce_ajax_add_to_cart_woo', 'bodycommerce_ajax_add_to_cart_woo_callback' );

	function bodycommerce_ajax_add_to_cart_woo_callback() {

		ob_start();

		$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) ); // phpcs:ignore
    $quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] ); // phpcs:ignore
    // $product_quantity = $_POST['product_quantity'];
		$variation_id = $_POST['variation_id']; // phpcs:ignore
		$variation  = $_POST['variation']; // phpcs:ignore


      error_log("Variation Product", 0);
      $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation  );

      if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation  ) ) {
        do_action( 'woocommerce_ajax_added_to_cart', $product_id );
        if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
          wc_add_to_cart_message( $product_id );
        }

        // Return fragments
        WC_AJAX::get_refreshed_fragments();
      }  else  {
        // $this->json_headers(); // REMOVED AS WAS THROWING AN ERROR

        // If there was an error adding to the cart, redirect to the product page to show any errors
        $data = array(
          'error' => true,
          'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id  )
          );
        echo json_encode( $data );
      }

    		die();
	}

// SINGLE CALLBACK
add_action( 'wp_ajax_bodycommerce_ajax_add_to_cart_woo_single', 'bodycommerce_ajax_add_to_cart_woo_single_callback' );
add_action( 'wp_ajax_nopriv_bodycommerce_ajax_add_to_cart_woo_single', 'bodycommerce_ajax_add_to_cart_woo_single_callback' );
function bodycommerce_ajax_add_to_cart_woo_single_callback() {
  ob_start();
  $product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) ); // phpcs:ignore
  $quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] ); // phpcs:ignore
error_log("Simple Product", 0);
$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity  ) ) {
do_action( 'woocommerce_ajax_added_to_cart', $product_id );


// Return fragments
WC_AJAX::get_refreshed_fragments();
}  else  {
// $this->json_headers(); // REMOVED AS WAS THROWING AN ERROR

// If there was an error adding to the cart, redirect to the product page to show any errors
$data = array(
  'error' => true,
  'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
  );
echo json_encode( $data );
}

    		die();
	}

}
else {
  # code...
}


?>
