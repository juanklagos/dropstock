<?php
if ( ! defined( 'ABSPATH' ) ) exit;



$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);

if (isset($mydata['order_bump_enable'][0])) {
$order_bump_enable = $mydata['order_bump_enable'][0];
}
else {
  $order_bump_enable = "0";
}


if ($order_bump_enable == 1) {

function bodycommerce_orderbump_enqueue_js() {
wp_enqueue_script( 'bodycommerce-order-bump-js', plugins_url() . '/divi-bodycommerce/scripts/orderbump-ajax.js', array('jquery'), '', true );
wp_localize_script( 'bodycommerce-order-bump-js', 'ajax_object',
  array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
);
}
add_action( 'wp_enqueue_scripts', 'bodycommerce_orderbump_enqueue_js',99 );



  $mydata = get_option( 'divi-bodyshop-woo_options' );
  $mydata = unserialize($mydata);

  if (isset($mydata['order_bump_product_postion'])) {
  $order_bump_product_postion = $mydata['order_bump_product_postion'];
  }
  else {
    $order_bump_product_postion = "woocommerce_review_order_before_payment";
  }

function bodycommerce_checkout_funnel_order_bump () {

 

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $order_bump_template = $titan->getOption( 'order_bump_template' );
  $order_bump_product_type = $titan->getOption( 'order_bump_product_type' );


 if(isset($order_bump_product_type)) {

   $order_bump_id_combine 	= DEBC_INIT::get_order_bump_id();

   
   

   if (is_array($order_bump_id_combine)) {
    $order_bump_keys = array_keys($order_bump_id_combine);
    $order_bump_main_product = $order_bump_keys[0];
   } else {
     if (is_empty($order_bump_keys)) {
      $order_bump_main_product = "";
     } else {
    $order_bump_main_product = $order_bump_id_combine;
     }
   }


   if (is_array($order_bump_id_combine)) {
    $order_bump_values = array_values($order_bump_id_combine);
    $order_bump_upsell = $order_bump_values[0];
    $upsell_id = $order_bump_upsell;
   } else {
     if (is_empty($order_bump_keys)) {
     } else {
    $order_bump_upsell = $order_bump_id_combine;
    $upsell_id = $order_bump_upsell;
     }
   }




if ( isset($upsell_id) ) {



      $product_cart_id = WC()->cart->generate_cart_id( $upsell_id );
     $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );

     if ( !$in_cart ) {

$product = wc_get_product( $upsell_id );

if ( $product->is_in_stock() ) {

  

$get_regular_price = $product->get_regular_price();
$get_sale_price = $product->get_sale_price();
$get_price = $product->get_price();
$title = get_the_title($upsell_id);

?>
<div class="bc_order_bump_cont">

  <?php

if ( $product->is_type( 'simple' ) ) {
  $params = array(
   'p' => $upsell_id,
   'post_type' => 'product'
  );
} else if ( $product->is_type( 'variable' ) ) {
    $params = array(
     'p' => $upsell_id,
     'post_type' => 'product'
    );
}else {
  $params = array(
   'p' => $upsell_id,
   'post_type' => 'product_variation'
  );
}

    query_posts( $params );

    if ( have_posts() ) {
while ( have_posts() ) {

    the_post();
    global $product;

    if ($order_bump_template != "") {
    echo do_shortcode('[et_pb_row global_module="'.$order_bump_template.'"][/et_pb_row]');
  }

        } // endwhile
        wp_reset_query();
      }

if ( $product->is_type( 'variable' ) ) {
  ?>
  <input type="hidden" value="<?php echo $upsell_id ?>" class="variation_is_here">
  <input type="hidden" value="<?php echo $order_bump_main_product ?>" class="main_product_id">
<?php } else { ?>
<input type="hidden" value="<?php echo $upsell_id ?>" class="product_id">
<input type="hidden" value="<?php echo $order_bump_main_product ?>" class="main_product_id">

<?php } ?>

</div>
<?php
}

}

}

}

}

add_filter($order_bump_product_postion, 'bodycommerce_checkout_funnel_order_bump' );



function divi_bodycommerce_orderbump_handler() {
  ob_start();
global $woocommerce;
      // $coupon_code = DEBC_INIT::get_order_bump_coupon_code();
      $amount = DEBC_INIT::get_order_bump_discount();
      $discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product

  $added = $_POST['added'];
  $main_product_id = $_POST['main_product_id'];
  $product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
  $variation_id = $_POST['variation_id'];
  $variation = $_POST['variation'];
  $variation_data = $_POST['variation_data'];
  $quantity = "1";

  if ($added == "true") {

if ($variation_id == "none") {

    $added_test = "addedproduct";
error_log("Simple Product", 0);
$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

WC()->cart->add_to_cart($product_id, $quantity, 0, array(), array('order-bump' => true, 'main-product' => $main_product_id));
// Return fragments

// WC()->cart->apply_coupon( $coupon_code ); // APPLY COUPON

} else {
$added_test = "addedproduct";
 error_log("Variation Product", 0);
$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation  );

WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation_data, array('order-bump' => true, 'main-product' => $main_product_id));

}

WC_AJAX::get_refreshed_fragments();


} else if ($added == "false") {

  $product = wc_get_product( $product_id );
  if ( $product->is_type( 'simple' ) ) {

  $added_test = "removed simple";
    foreach( WC()->cart->get_cart() as $key=>$item){
                if($item['product_id']==$product_id){
                    WC()->cart->remove_cart_item( $key );
                }
              }
  } else {
  $added_test = "removed variation";
  foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {

          if ($cart_item['variation_id'] == $product_id) {
              //remove single product
              $woocommerce->cart->remove_cart_item($cart_item_key);
          }
      }
  }




      // Return fragments
      // WC_AJAX::get_refreshed_fragments();
} else {
  $added_test = "else";
}



$return = array(
    'added' => $added,
    'postsadded' => $added_test,
    'product_id' => $product_id
);
ob_end_clean();

wp_send_json($return);
wp_die();


}
add_action( 'wp_ajax_divi_bodycommerce_orderbump_handler', 'divi_bodycommerce_orderbump_handler' );
add_action( 'wp_ajax_nopriv_divi_bodycommerce_orderbump_handler', 'divi_bodycommerce_orderbump_handler' );


// function divi_bodycommerce_orderbump_remove_handler() {
//   ob_start();
//   $coupon_code = DEBC_INIT::get_order_bump_coupon_code();
//   $added = esc_attr( $_POST['added'] );
//
//   if ($added == "true") {
//
// } else if ($added == "false") {
//
//         $coupon_data = new WC_Coupon($coupon_code);
//         if(!empty($coupon_data->id))
//         {
//             wp_delete_post($coupon_data->id);
//         }
//
//
// } else {
// }
//
// ob_end_clean();
//
// wp_die();
//
// }
// add_action( 'wp_ajax_divi_bodycommerce_orderbump_remove_handler', 'divi_bodycommerce_orderbump_remove_handler' );
// add_action( 'wp_ajax_nopriv_divi_bodycommerce_orderbump_remove_handler', 'divi_bodycommerce_orderbump_remove_handler' );



add_filter( 'woocommerce_cart_item_subtotal', 'bodycommerce_show_discounted_price_cart_item', 99, 3 );


function bodycommerce_show_discounted_price_cart_item( $subtotal, $cart_item, $cart_item_key ){

  // This is necessary for WC 3.0+
      if ( is_admin() && ! defined( 'DOING_AJAX' ) )
          return;

      // Avoiding hook repetition (when using price calculations for example)
      if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
          return;

global $woocommerce;

include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$order_bump_id_combine 	= DEBC_INIT::get_order_bump_id();

if (!empty($order_bump_id_combine)) {
$order_bump_keys = array_keys($order_bump_id_combine);
$order_bump_values = array_values($order_bump_id_combine);

$order_bump_main_product = $order_bump_keys[0];
$order_bump_upsell = $order_bump_values[0];



// Note: use your own coupon code here

// $coupon_code = DEBC_INIT::get_order_bump_coupon_code();


// if (WC()->cart->has_discount($coupon_code)) {
if(array_key_exists("order-bump", $cart_item)){

$amount = DEBC_INIT::get_order_bump_discount();

$amount_100 = $amount / 100;
$newsubtotal = 1 - $amount_100;
$final_price = wc_price( ($cart_item['data']->get_price() / $newsubtotal) * $cart_item['quantity'] );

// $newsubtotal = wc_price( $cart_item['data']->get_price() * 0.01  );

$subtotal = sprintf( '<s class="order_bump_set">%s</s> %s', $final_price, $subtotal );

} else {

}

// }


return $subtotal;
}
}



function bodycommerce_set_price_name_cart_order_bump($cart_object) {

include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$order_bump_suffix_get = $titan->getOption( 'order_bump_suffix' );

do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Order Bump Suffix', $order_bump_suffix_get );
$order_bump_suffix = apply_filters( 'wpml_translate_single_string', $order_bump_suffix_get, 'divi-bodyshop-woocommerce', 'Order Bump Suffix' );

  // This is necessary for WC 3.0+
      if ( is_admin() && ! defined( 'DOING_AJAX' ) )
          return;




	foreach ($cart_object->get_cart() as $value) {

              $amount = DEBC_INIT::get_order_bump_discount();
              $newsubtotal = ($value['data']->get_price() / 100) * $amount;
              $finalprice = $value['data']->get_price() - $newsubtotal;

    if(array_key_exists("order-bump", $value)){
        $value['data']->set_price($finalprice);

        $get_name = $value['data']->get_name();
        $value['data']->set_name($get_name . $order_bump_suffix);

    } else {

    }


	}
}

add_action('woocommerce_before_calculate_totals', 'bodycommerce_set_price_name_cart_order_bump');



// add the action
add_action( 'woocommerce_cart_updated', 'action_woocommerce_cart_updated', 10, 0 );
// define the woocommerce_cart_updated callback
function action_woocommerce_cart_updated( ) {

  $cart = WC()->cart->get_cart();

  foreach( $cart as $cart_item ){

  if (isset($cart_item["order-bump"]) && $cart_item["order-bump"] == "1") {
    $order_bump_product = $cart_item["product_id"];

    if ($cart_item["main-product"] == "7777777777777") {
      $main_product = "specific_product";
    } else {
      $main_product = $cart_item["main-product"];
    }

  if ($main_product != "specific_product") { // if not a specifi product



      $product = wc_get_product( $main_product );
      if ( $product->is_type( 'simple' ) ) {

    $product_cart_id = WC()->cart->generate_cart_id( $cart_item["main-product"] );
   $in_cart = WC()->cart->find_product_in_cart( $product_cart_id );

   if ( !$in_cart ) { // if main product is not in the cart, remove
     foreach( WC()->cart->get_cart() as $key=>$item){
                           if($item['product_id']==$cart_item["product_id"]){
                     WC()->cart->remove_cart_item( $key );
                 }
               }
   }
  } else {



    $in_cart = false;

      $checkifincart  = array();
      foreach( WC()->cart->get_cart() as $cart_item ) {
         $product_in_cart = $cart_item['product_id'];

         if ( $product_in_cart == $main_product )
         $checkifincart[] = "yes";
      }


  if (in_array("yes", $checkifincart)) {

  } else {

        foreach( WC()->cart->get_cart() as $key=>$item){

                              if($item['product_id']==$order_bump_product){
                        WC()->cart->remove_cart_item( $key );
                    }
                  }

  }




  }

  } else {



   if ( WC()->cart->get_cart_contents_count() == 1 ) { // if only one in cart

     foreach( WC()->cart->get_cart() as $key=>$item){

                 if($item['product_id']==$cart_item["product_id"]){
                     WC()->cart->remove_cart_item( $key );
                 }
               }
   }



  }

  }

}

}



} // END IF ENABLE ORDER BUMP




?>
