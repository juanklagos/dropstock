<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function divi_bodyshop_woo_check_checkout_fields() {


/**
* ADD FIELD TO SHIPPING OR BILLING
*/

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'bodycommerce_custom_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function bodycommerce_custom_checkout_fields( $fields ) {

  $ids = array();
  $args = array( 'post_type' => 'bc_checkout');
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post();
  array_push( $ids, get_the_ID() );

  // END LOOP
  endwhile;
  foreach (array_unique($ids) as $key => $value) {

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );


        $get_db_checkout_field_location = $titan->getOption( 'db_checkout_field_location', $value  );

        $get_db_checkout_field_label_get = $titan->getOption( 'db_checkout_field_label', $value  );
        $get_db_checkout_field_placeholder_get = $titan->getOption( 'db_checkout_field_placeholder', $value  );


        do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', $get_db_checkout_field_label_get . ' checkout label', $get_db_checkout_field_label_get );
        do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', $get_db_checkout_field_label_get . ' checkout placeholder', $get_db_checkout_field_placeholder_get );
        $get_db_checkout_field_label = apply_filters( 'wpml_translate_single_string', $get_db_checkout_field_label_get, 'divi-bodyshop-woocommerce', $get_db_checkout_field_label_get . ' checkout label' );
        $get_db_checkout_field_placeholder = apply_filters( 'wpml_translate_single_string', $get_db_checkout_field_placeholder_get, 'divi-bodyshop-woocommerce', $get_db_checkout_field_label_get . ' checkout placeholder' );


        $get_db_checkout_field_required = $titan->getOption( 'db_checkout_field_required', $value  );
        $get_db_checkout_field_width = $titan->getOption( 'db_checkout_field_width', $value  );
        $get_db_checkout_field_required = $titan->getOption( 'db_checkout_field_required', $value  );
        $get_db_checkout_field_id = $titan->getOption( 'db_checkout_field_id', $value  );
        $db_checkout_field_type = $titan->getOption( 'db_checkout_field_type', $value  );







        if ($get_db_checkout_field_required == 1 ) {
          $get_db_checkout_field_required_display = true;
        }
        else {
          $get_db_checkout_field_required_display = false;
        }


if ($get_db_checkout_field_width == "full") {
  $get_db_checkout_field_width_display = "form-row-wide";
}
else if ( $get_db_checkout_field_width == "half-first" ) {
  $get_db_checkout_field_width_display = "form-row-first";
}
else {
  $get_db_checkout_field_width_display = "form-row-last";
}

        $id = $titan->getOption( 'db_checkout_field_id', $value  );


        if ($get_db_checkout_field_location == "shipping" || $get_db_checkout_field_location == "billing"){

     $fields[$get_db_checkout_field_location][$id] = array(
    'label'     => __($get_db_checkout_field_label, 'woocommerce'),
    'type'      => $db_checkout_field_type,
    'placeholder'   => _x($get_db_checkout_field_placeholder, 'placeholder', 'woocommerce'),
    'required'   => $get_db_checkout_field_required_display,
    'class'     => array($get_db_checkout_field_width_display),
    'clear'     => true
     );


}
else {
  /**
  * ADD CUSTOM FIELD AFTER NOTES
  */
  // add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

  add_action('woocommerce_after_order_notes', function($checkout) use($value) {



      include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

      $get_db_checkout_field_label = $titan->getOption( 'db_checkout_field_label', $value  );
      $get_db_checkout_field_placeholder = $titan->getOption( 'db_checkout_field_placeholder', $value  );
      $get_db_checkout_field_required = $titan->getOption( 'db_checkout_field_required', $value  );
      $db_checkout_field_type = $titan->getOption( 'db_checkout_field_type', $value  );



      if ($get_db_checkout_field_required == 1 ) {
        $get_db_checkout_field_required_display = true;
      }
      else {
        $get_db_checkout_field_required_display = false;
      }

      $get_db_checkout_field_width = $titan->getOption( 'db_checkout_field_width', $value  );

  if ($get_db_checkout_field_width == "full") {
  $get_db_checkout_field_width_display = "form-row-wide";
  }
  else if ( $get_db_checkout_field_width == "half-first" ) {
  $get_db_checkout_field_width_display = "form-row-first";
  }
  else {
  $get_db_checkout_field_width_display = "form-row-last";
  }

  $id = $titan->getOption( 'db_checkout_field_id', $value  );

  echo '<div>';
      woocommerce_form_field( $id, array(
          'type'          => $db_checkout_field_type,
          'class'     => array($get_db_checkout_field_width_display),
          'clear'     => true,
          'label'         => __($get_db_checkout_field_label),
          'required'   => $get_db_checkout_field_required_display,
          'placeholder'   => __($get_db_checkout_field_placeholder),
          ), $checkout->get_value( $id ));

      echo '</div>';


   });
}
}

     return $fields;
}






/**
*process
*/

add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
  $ids = array();
  $args = array( 'post_type' => 'bc_checkout');
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post();
  array_push( $ids, get_the_ID() );

  // END LOOP
  endwhile;
  foreach (array_unique($ids) as $key => $value) {

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

    $get_db_checkout_field_required = $titan->getOption( 'db_checkout_field_required', $value  );
        $get_db_checkout_field_error_message = $titan->getOption( 'db_checkout_field_error_message', $value  );

if ($get_db_checkout_field_required == 1){

$id = $titan->getOption( 'db_checkout_field_id', $value  );

    if ( ! $_POST[$id] )
        wc_add_notice( __( $get_db_checkout_field_error_message ), 'error' );


      }
      else {
        # code...
      }
}
  }


/**
 * UPDATE ORDER
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
  $ids = array();
  $args = array( 'post_type' => 'bc_checkout');
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post();
  array_push( $ids, get_the_ID() );

  // END LOOP
  endwhile;
  foreach (array_unique($ids) as $key => $value) {
    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
      $get_db_checkout_field_label = $titan->getOption( 'db_checkout_field_label', $value  );
        $db_checkout_field_id = $titan->getOption( 'db_checkout_field_id', $value  );

$id = $titan->getOption( 'db_checkout_field_id', $value  );

    if ( ! empty( $_POST[$id] ) ) {

        update_post_meta( $order_id, $db_checkout_field_id, sanitize_text_field( $_POST[$id] ) );
    }


  }

}


/**
* ADD TO ORDER PAGE SHIPPING
*/
//

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta_shipping_billing', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta_shipping_billing($order){
    $ids = array();
    $args = array( 'post_type' => 'bc_checkout');
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
    array_push( $ids, get_the_ID() );

    // END LOOP
    endwhile;
    foreach (array_unique($ids) as $key => $value) {
      include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );


          $get_db_checkout_field_location = $titan->getOption( 'db_checkout_field_location', $value  );

          $get_db_checkout_field_placeholder = $titan->getOption( 'db_checkout_field_placeholder', $value  );
          $get_db_checkout_field_required = $titan->getOption( 'db_checkout_field_required', $value  );

          $get_db_checkout_field_order_page = $titan->getOption( 'db_checkout_field_order_page', $value  );

          $db_checkout_checkbox_true = $titan->getOption( 'db_checkout_checkbox_true', $value  );

          $db_checkout_checkbox_false = $titan->getOption( 'db_checkout_checkbox_false', $value  );

          if ($get_db_checkout_field_order_page == 1){

$id = $titan->getOption( 'db_checkout_field_id', $value  );

          if ($get_db_checkout_field_location == "shipping"){

            $db_checkout_field_id = $titan->getOption( 'db_checkout_field_id', $value );
            $db_checkout_field_label = $titan->getOption( 'db_checkout_field_label', $value );

            $get_field_data = get_post_meta( $order->get_order_number(), $db_checkout_field_id, true );
            
            if ($get_field_data == "1" && $db_checkout_checkbox_true !== "") {
              $get_field_data = $db_checkout_checkbox_true;
            }
            if ($get_field_data == "0" && $db_checkout_checkbox_false !== "") {
              $get_field_data = $db_checkout_checkbox_false;
            }

              if ($get_field_data != "") {
          		echo '<strong>' . $db_checkout_field_label . ':</strong> ' . $get_field_data . '<br>';
            }

}
else {
  # code...
}
}
else {
  # code...
}
}
}

/**
 * ADD TO ORDER PAGE CUSTOM
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );



function my_custom_checkout_field_display_admin_order_meta($order){
  $ids = array();
  $args = array( 'post_type' => 'bc_checkout');
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post();
  array_push( $ids, get_the_ID() );

  // END LOOP
  endwhile;
  foreach (array_unique($ids) as $key => $value) {

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$get_db_checkout_field_order_page = $titan->getOption( 'db_checkout_field_order_page', $value  );
$get_db_checkout_field_location = $titan->getOption( 'db_checkout_field_location', $value  );
$db_checkout_checkbox_true = $titan->getOption( 'db_checkout_checkbox_true', $value  );
$db_checkout_checkbox_false = $titan->getOption( 'db_checkout_checkbox_false', $value  );

if ($get_db_checkout_field_order_page == 1){
$id = $titan->getOption( 'db_checkout_field_id', $value  );
if ($get_db_checkout_field_location != "shipping"){


  $db_checkout_field_id = $titan->getOption( 'db_checkout_field_id', $value );
  $db_checkout_field_label = $titan->getOption( 'db_checkout_field_label', $value );

            $get_field_data = get_post_meta( $order->get_order_number(), $db_checkout_field_id, true );
            
            if ($get_field_data == "1" && $db_checkout_checkbox_true !== "") {
              $get_field_data = $db_checkout_checkbox_true;
            }
            if ($get_field_data == "0" && $db_checkout_checkbox_false !== "") {
              $get_field_data = $db_checkout_checkbox_false;
            }

              if ($get_field_data != "") {
          		echo '<strong>' . $db_checkout_field_label . ':</strong> ' . $get_field_data . '<br>';
            }

}
else {
  # code...
}
}
else {
  # code...
}

  }
}

// /**
// * ADD TO EMAIL
//  */
// add_filter('woocommerce_email_order_meta_keys', 'my_custom_order_meta_keys');
//
// function my_custom_order_meta_keys( $keys ) {
//   $ids = array();
//   $args = array( 'post_type' => 'bc_checkout');
//   $loop = new WP_Query( $args );
//   while ( $loop->have_posts() ) : $loop->the_post();
//   array_push( $ids, get_the_ID() );
//
//   // END LOOP
//   endwhile;
//   foreach (array_unique($ids) as $key => $value) {
//
//     include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
//     $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
//             $get_db_checkout_field_add_email = $titan->getOption( 'db_checkout_field_add_email', $value  );
//
//     if ($get_db_checkout_field_add_email == 1){
//
// $id = $titan->getOption( 'db_checkout_field_id', $value );
//
//     $field_name = the_title();
//
//      $keys[] = $field_name;
//      return $keys;
//    }
//    else {
//      # code...
//    }
//    }
// }





add_action( 'woocommerce_email_order_meta', 'bodycommerce_add_field_to_email', 10, 3 );
/*
 * @param $order Order Object
 * @param $sent_to_admin If this email is for administrator or for a customer
 * @param $plain_text HTML or Plain text (can be configured in WooCommerce > Settings > Emails)
 */
function bodycommerce_add_field_to_email( $order, $sent_to_admin, $plain_text ){
  $ids = array();
  $args = array( 'post_type' => 'bc_checkout');
  $loop = new WP_Query( $args );
  while ( $loop->have_posts() ) : $loop->the_post();
  array_push( $ids, get_the_ID() );

  // END LOOP
  endwhile;
  foreach (array_unique($ids) as $key => $value) {

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
    $get_db_checkout_field_add_email = $titan->getOption( 'db_checkout_field_add_email', $value  );

    if ($get_db_checkout_field_add_email == 1){


      $db_checkout_field_id = $titan->getOption( 'db_checkout_field_id', $value );
      $db_checkout_field_label = $titan->getOption( 'db_checkout_field_label', $value );
      $db_checkout_checkbox_true = $titan->getOption( 'db_checkout_checkbox_true', $value  );
      $db_checkout_checkbox_false = $titan->getOption( 'db_checkout_checkbox_false', $value  );

      $get_field_data = get_post_meta( $order->get_order_number(), $db_checkout_field_id, true );
            
      if ($get_field_data == "1" && $db_checkout_checkbox_true !== "") {
        $get_field_data = $db_checkout_checkbox_true;
      }
      if ($get_field_data == "0" && $db_checkout_checkbox_false !== "") {
        $get_field_data = $db_checkout_checkbox_false;
      }

        if ($get_field_data != "") {
    		echo '<strong>' . $db_checkout_field_label . ':</strong> ' . $get_field_data . '<br>';
      }


    }
    else {
      # code...
    }
    }


}



// invoicing and packing slips plugin integration

add_action( 'wpo_wcpdf_after_order_details', 'wpo_wcpdf_custom_text', 10, 2 );
function wpo_wcpdf_custom_text ($template_type, $order) {
    if ($template_type == 'invoice') {
      $ids = array();
      $args = array( 'post_type' => 'bc_checkout');
      $loop = new WP_Query( $args );
      while ( $loop->have_posts() ) : $loop->the_post();
      array_push( $ids, get_the_ID() );

      // END LOOP
      endwhile;
      foreach (array_unique($ids) as $key => $value) {

        include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
        $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

        $get_db_checkout_field_label = $titan->getOption( 'db_checkout_field_label', $value  );
        $get_db_checkout_field_id = $titan->getOption( 'db_checkout_field_id', $value  );

      $checkoutfield_id_dis = $order->get_meta($get_db_checkout_field_id);
      if ($checkoutfield_id_dis != "") {
        ?>
        <div class="custom-text">
        <?php echo $get_db_checkout_field_label ?>: <?php echo $checkoutfield_id_dis; ?>
        </div>
        <?php
}
else {
  // code...
}
  }

    }
}



}
add_action( 'tf_create_options', 'divi_bodyshop_woo_check_checkout_fields' );
 ?>
