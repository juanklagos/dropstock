<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function divi_bodycommerce_check_other_options() {
include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );


// Fix WooCommerce button
$check_other_settings_button_fix = $titan->getOption( 'other_settings_button_fix' );
    if ( 1 == $check_other_settings_button_fix) {


      function divi_bodycommerce_sinlge_product()  {
      $a = get_option( 'et_divi' );
      echo "<style id='bodycommerce-button-fix'>body.et_pb_button_helper_class .et_pb_button, body.et_pb_button_helper_class .et_pb_module.et_pb_button, .woocommerce.et_pb_button_helper_class a.button.alt, .woocommerce-page.et_pb_button_helper_class a.button.alt, .woocommerce.et_pb_button_helper_class button.button.alt, .woocommerce-page.et_pb_button_helper_class button.button.alt, .woocommerce.et_pb_button_helper_class input.button.alt, .woocommerce-page.et_pb_button_helper_class input.button.alt, .woocommerce.et_pb_button_helper_class #respond input#submit.alt, .woocommerce-page.et_pb_button_helper_class #respond input#submit.alt, .woocommerce.et_pb_button_helper_class #content input.button.alt, .woocommerce-page.et_pb_button_helper_class #content input.button.alt, .woocommerce.et_pb_button_helper_class a.button, .woocommerce-page.et_pb_button_helper_class a.button, .woocommerce.et_pb_button_helper_class button.button, .woocommerce-page.et_pb_button_helper_class button.button, .woocommerce.et_pb_button_helper_class input.button, .woocommerce-page.et_pb_button_helper_class input.button, .woocommerce.et_pb_button_helper_class #respond input#submit, .woocommerce-page.et_pb_button_helper_class #respond input#submit, .woocommerce.et_pb_button_helper_class #content input.button, .woocommerce-page.et_pb_button_helper_class #content input.button{color:#fff;}body .et_pb_button:hover, .woocommerce a.button.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce #content input.button.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce a.button:hover, .woocommerce-page a.button:hover, .woocommerce button.button:hover, .woocommerce-page button.button:hover, .woocommerce input.button:hover, .woocommerce-page input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce-page #respond input#submit:hover, .woocommerce #content input.button:hover, .woocommerce-page #content input.button:hover{color:#ffffff;}</style>";
      }
      add_action( 'wp_head', 'divi_bodycommerce_sinlge_product', 15 );

    } else {
    //      echo "Is off.";
    }

// Remove add to cart message
$check_other_settings_remove_add_to_cart_message = $titan->getOption( 'other_settings_remove_add_to_cart_message' );

if ($check_other_settings_remove_add_to_cart_message == 1) {
add_filter( 'wc_add_to_cart_message_html', '__return_null' );
}
else {
  # code...
}

// Change the add to cart notice text


  $check_other_settings_add_to_cart_message_text = $titan->getOption( 'other_settings_add_to_cart_message_text' );
  $check_other_settings_add_to_cart_message_button_text = $titan->getOption( 'other_settings_add_to_cart_message_button_text' );
if ($check_other_settings_add_to_cart_message_text != ""){
add_filter( 'wc_add_to_cart_message_html', 'divi_bodycommerce_change_add_to_cart_message_text' );

function divi_bodycommerce_change_add_to_cart_message_text($products) {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $check_other_settings_add_to_cart_message_text = $titan->getOption( 'other_settings_add_to_cart_message_text' );
  $check_other_settings_add_to_cart_message_button_text = $titan->getOption( 'other_settings_add_to_cart_message_button_text' );

  $check_other_settings_add_to_cart_message_text_display = $check_other_settings_add_to_cart_message_text;


if ($check_other_settings_add_to_cart_message_button_text == "") {
  $check_other_settings_add_to_cart_message_button_text_display = "View basket";
}
else {
  $check_other_settings_add_to_cart_message_button_text_display = $check_other_settings_add_to_cart_message_button_text;
}

global $woocommerce;
$return_to  = get_permalink(wc_get_page_id('cart'));
$message    = sprintf('<a href="%s" class="button wc-forwards">%s</a> %s', $return_to, __($check_other_settings_add_to_cart_message_button_text_display, 'woocommerce'), __($check_other_settings_add_to_cart_message_text_display, 'woocommerce') );
return $message;
}
}
else {
  # code...
}


// PAGINCATION TOP
$check_other_settings_pagination_top = $titan->getOption( 'other_settings_pagination_top' );

if ($check_other_settings_pagination_top == 1){

add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 10 );
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
}
else {
  # code...
}

// Password Strength
$check_other_settings_user_password = $titan->getOption( 'other_settings_user_password' );

if ($check_other_settings_user_password == 1 ){
  function bodycommerce_user_remove_password_strength() {
	if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
		wp_dequeue_script( 'wc-password-strength-meter' );
	}
}
add_action( 'wp_print_scripts', 'bodycommerce_user_remove_password_strength', 100 );
}
else {
  # code...
}


// SHort desc title
$check_other_settings_short_desc_title = $titan->getOption( 'other_settings_short_desc_title' );

if ($check_other_settings_short_desc_title == "") {

}
else {

  function bodycommerce_filter_short_description( $desc ){
  	global $product;
    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$check_other_settings_short_desc_title = $titan->getOption( 'other_settings_short_desc_title' );
  	if ( is_single( $product->get_id() ) ) {
      $new_desc = '<h3 class="bc-short-desc-title">'.$check_other_settings_short_desc_title.'</h3>';
  		$new_desc .= $desc;
  	return $new_desc;
  }
  }
  add_filter( 'woocommerce_short_description', 'bodycommerce_filter_short_description' );
}

// Breadcrumb separator
$check_other_settings_breadcrumb_separator = $titan->getOption( 'other_settings_breadcrumb_separator' );

if ($check_other_settings_breadcrumb_separator == "") {

}
else {
  add_filter( 'woocommerce_breadcrumb_defaults', 'bodycommerce_woocommerce_breadcrumbs_separator' );
  function bodycommerce_woocommerce_breadcrumbs_separator() {
    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$check_other_settings_breadcrumb_separator = $titan->getOption( 'other_settings_breadcrumb_separator' );
  	return array(
  			'delimiter'   => ' '.$check_other_settings_breadcrumb_separator.' ',
  			'wrap_before' => '<div class="bc-breadcrumb-wrap"><nav class="bc-woocommerce-breadcrumb" itemprop="breadcrumb">',
  			'wrap_after'  => '</nav></div>',
  			'before'      => '',
  			'after'       => '',
  			'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
  		);
  }
}


// REMOVE SALES Badge
$check_other_settings_remove_sale_badge = $titan->getOption( 'other_settings_remove_sale_badge' );

if ($check_other_settings_remove_sale_badge == 1) {
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
}
else {
  # code...
}

// SALES BADGE Percentage
$check_other_settings_percentage_sales_enable = $titan->getOption( 'other_settings_percentage_sales_enable' );

if ($check_other_settings_percentage_sales_enable == 1) {

  // FIX FOR SITES ALREADY USING SALES BADGE - WILL FILTER OUT
  add_filter('woocommerce_sale_flash', 'bodycommerce_woocommerce_savings_on_sales_flash');

  function bodycommerce_woocommerce_savings_on_sales_flash()
  {

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
      $check_other_settings_percentage_sales_before_get = $titan->getOption( 'other_settings_percentage_sales_before' );
      $check_other_settings_percentage_sales_after_get = $titan->getOption( 'other_settings_percentage_sales_after' );
      do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sale Percentage Before', $check_other_settings_percentage_sales_before_get );
      do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sale Percentage After', $check_other_settings_percentage_sales_after_get );
      $check_other_settings_percentage_sales_before = apply_filters( 'wpml_translate_single_string', $check_other_settings_percentage_sales_before_get, 'divi-bodyshop-woocommerce', 'Sale Percentage Before' );
      $check_other_settings_percentage_sales_after = apply_filters( 'wpml_translate_single_string', $check_other_settings_percentage_sales_after_get, 'divi-bodyshop-woocommerce', 'Sale Percentage After' );
$check_other_settings_sale_badge_percentage_sign = $titan->getOption( 'other_settings_sale_badge_percentage_sign' );


  global $post, $product;
  	if ( ! $product->is_in_stock() ) return;

    if( $product->is_type( 'grouped' ) ){
return;
    }

if ( '' === $product->get_price() || 0 == $product->get_price() ) {
} else {

  	$sale_price = get_post_meta( $product->get_id(), '_price', true);
  	$regular_price = get_post_meta( $product->get_id(), '_regular_price', true);
    if (empty($regular_price)){ //then this is a variable product
      
  		$available_variations = $product->get_available_variations();
      $variation_id=$available_variations[0]['variation_id'];
      if ($variation_id !== "") { 
  		$variation= new WC_Product_Variation( $variation_id );
  		$regular_price = $variation->get_regular_price();
      $sale_price = $variation->get_sale_price();
      }
      
  	}


    if (is_numeric($regular_price) && is_numeric($sale_price)) {

    $difference = $regular_price - $sale_price;
    $division = $difference / $regular_price;
    $savings = round ($division * 100);
    if ($savings > "0") {
        if ($check_other_settings_sale_badge_percentage_sign == 1) {
  	$sale_flash = '<span class="onsale">'.$check_other_settings_percentage_sales_before.' ' . $savings . '% '.$check_other_settings_percentage_sales_after.'</span>';
  }
  else {
  $sale_flash = '<span class="onsale">'.$check_other_settings_percentage_sales_before.''.$check_other_settings_percentage_sales_after.'</span>';
  }

  	return $sale_flash;
  }
  }

  }

  }
    // FIX FOR SITES ALREADY USING SALES BADGE - WILL FILTER OUT


// Sales badge css

function bodycommerce_sale_badge_css()  {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  	$check_BodyCommerce_sale_badge_design = $titan->getOption( 'BodyCommerce_sale_badge_design' );

$path = '/lib/sale-badge-styles/'.$check_BodyCommerce_sale_badge_design.'.css.php';
include(DE_DB_WOO_PATH . $path);


$css_button_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_button );
echo $css_button_min;

}
add_action( 'wp_head', 'bodycommerce_sale_badge_css', 15 );



}
else {
  # code...
}

$check_other_settings_percentage_sales_enable_new = $titan->getOption( 'other_settings_percentage_sales_enable_new' );
$check_other_settings_percentage_sales_enable_free = $titan->getOption( 'other_settings_percentage_sales_enable_free' );
$other_settings_percentage_sales_enable_ofs = $titan->getOption( 'other_settings_percentage_sales_enable_ofs' );

if ($check_other_settings_percentage_sales_enable_new == 1) {

  function bodycommerce_new_badge_css()  {
    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
    	$check_BodyCommerce_sale_badge_design_new = $titan->getOption( 'BodyCommerce_sale_badge_design_new' );

  $path_new = '/lib/new-badge-styles/'.$check_BodyCommerce_sale_badge_design_new.'.css.php';
  include(DE_DB_WOO_PATH . $path_new);

  $css_button_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_button );
  echo $css_button_min;

  }
  add_action( 'wp_head', 'bodycommerce_new_badge_css', 15 );

}
else {
  # code...
}


if ($check_other_settings_percentage_sales_enable_free == 1) {
  function bodycommerce_free_badge_css()  {
    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
      $check_BodyCommerce_sale_badge_design_free = $titan->getOption( 'BodyCommerce_sale_badge_design_free' );

  $path_free = '/lib/free-badge-styles/'.$check_BodyCommerce_sale_badge_design_free.'.css.php';
  include(DE_DB_WOO_PATH . $path_free);

  $css_button_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_button );
  echo $css_button_min;

  }
  add_action( 'wp_head', 'bodycommerce_free_badge_css', 15 );
}
else {
  # code...
}

if ($other_settings_percentage_sales_enable_ofs == 1) {
  function bodycommerce_ofs_badge_css()  {
    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
      $BodyCommerce_sale_badge_design_ofs = $titan->getOption( 'BodyCommerce_sale_badge_design_ofs' );

  $path_free = '/lib/ofs-badge-styles/'.$BodyCommerce_sale_badge_design_ofs.'.css.php';
  include(DE_DB_WOO_PATH . $path_free);

  $css_button_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_button );
  echo $css_button_min;

  }
  add_action( 'wp_head', 'bodycommerce_ofs_badge_css', 15 );
}
else {
  # code...
}

// SALES BADGE PERCENTAGE


// Default placeholder


$check_other_settings_default_product_image= $titan->getOption( 'other_settings_default_product_image' );

if ($check_other_settings_default_product_image == "") {

}
else {

$imageSrc = $check_other_settings_default_product_image; // For the default value
if ( is_numeric( $check_other_settings_default_product_image ) ) {

add_filter( 'woocommerce_placeholder_img_src', 'bodycommerce_custom_woocommerce_placeholder', 10 );
function bodycommerce_custom_woocommerce_placeholder( $image_url ) {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $check_other_settings_default_product_image= $titan->getOption( 'other_settings_default_product_image' );
  $imageAttachment = wp_get_attachment_image_src( $check_other_settings_default_product_image , $size = 'full', $icon = false );
  $imageSrc = $imageAttachment[0];
  $image_url = $imageSrc;  // change this to the URL to your custom placeholder
  return $image_url;
}
}

}


// better display of variations

$other_settings_better_variation= $titan->getOption( 'other_settings_better_variation' );
  if ( 1 == $other_settings_better_variation) {
    add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );
    add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' );
} else {

}



// only one purchase
$check_other_settings_buy_one_item_only = $titan->getOption( 'other_settings_buy_one_item_only' );

if ($check_other_settings_buy_one_item_only == 1) {
add_filter( 'woocommerce_add_cart_item_data', 'bodycommerce_allow_one_item_only' );
function bodycommerce_allow_one_item_only( $cart_item_data ) {
	global $woocommerce;
	$woocommerce->cart->empty_cart();
	return $cart_item_data;
}
}
else {
  # code...
}



// price for logged in users only
$check_other_settings_price_logged_in = $titan->getOption( 'other_settings_price_logged_in' );

if ($check_other_settings_price_logged_in == 1)
{
  add_filter('woocommerce_get_price_html','bodycommerce_members_only_price');
  function bodycommerce_members_only_price($price){

      include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
        $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $other_settings_price_logged_in_custom_message = $titan->getOption( 'other_settings_price_logged_in_custom_message' );

  if(is_user_logged_in() ){
  	return $price;
  }
  else {

if ($other_settings_price_logged_in_custom_message == "") {
      return '<a href="' .get_permalink(wc_get_page_id('myaccount')). '">'.esc_html__( 'Login', 'divi-bodyshop-woocommerce' ).'</a> or <a href="'.site_url('/wp-login.php?action=register&redirect_to=' . get_permalink()).'">'.esc_html__( 'Register', 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( 'to view price!', 'divi-bodyshop-woocommerce' ).'';
} else {
  return $other_settings_price_logged_in_custom_message;
}
    }
  }
}
else {
  # code...
}


// atc button for logged in users only
$other_settings_atc_button_logged_in = $titan->getOption( 'other_settings_atc_button_logged_in' );

if ($other_settings_atc_button_logged_in == 1)
{

add_action( 'wp_head', 'bodycommerce_hide_add_cart_not_logged_in' );
function bodycommerce_hide_add_cart_not_logged_in() {
if ( ! is_user_logged_in() ) {
?>
<style>.button.add_to_cart_button, .et_pb_db_atc .button, .et_pb_wc_add_to_cart .button, .single_add_to_cart_button  {display: none !important;}.logged-in .button.add_to_cart_button, .logged-in .et_pb_db_atc .button, .logged-in .et_pb_wc_add_to_cart .button, .logged-in .single_add_to_cart_button  {display: none !important;}</style>
<?php
}
}

}
else {
  # code...
}


// archive sorting label text
function bodycommerce_sorting_label_text( $orderby ) {

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$check_other_settings_sorting_label_default_get = $titan->getOption( 'other_settings_sorting_label_default' );
$check_other_settings_sorting_label_popularity_get = $titan->getOption( 'other_settings_sorting_label_popularity' );
$check_other_settings_sorting_label_ave_rating_get = $titan->getOption( 'other_settings_sorting_label_ave_rating' );
$check_other_settings_sorting_label_newness_get = $titan->getOption( 'other_settings_sorting_label_newness' );
$check_other_settings_sorting_label_low_high_get = $titan->getOption( 'other_settings_sorting_label_low_high' );
$check_other_settings_sorting_label_high_low_get = $titan->getOption( 'other_settings_sorting_label_high_low' );

do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sorting - Default', $check_other_settings_sorting_label_default_get );
$check_other_settings_sorting_label_default = apply_filters( 'wpml_translate_single_string', $check_other_settings_sorting_label_default_get, 'divi-bodyshop-woocommerce', 'Sorting - Default' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sorting - Popularity', $check_other_settings_sorting_label_popularity_get );
$check_other_settings_sorting_label_popularity = apply_filters( 'wpml_translate_single_string', $check_other_settings_sorting_label_popularity_get, 'divi-bodyshop-woocommerce', 'Sorting - Popularity' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sorting - Rating', $check_other_settings_sorting_label_ave_rating_get );
$check_other_settings_sorting_label_ave_rating = apply_filters( 'wpml_translate_single_string', $check_other_settings_sorting_label_ave_rating_get, 'divi-bodyshop-woocommerce', 'Sorting - Rating' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sorting - Newness', $check_other_settings_sorting_label_newness_get );
$check_other_settings_sorting_label_newness = apply_filters( 'wpml_translate_single_string', $check_other_settings_sorting_label_newness_get, 'divi-bodyshop-woocommerce', 'Sorting - Newness' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sorting - Price Low High', $check_other_settings_sorting_label_low_high_get );
$check_other_settings_sorting_label_low_high = apply_filters( 'wpml_translate_single_string', $check_other_settings_sorting_label_low_high_get, 'divi-bodyshop-woocommerce', 'Sorting - Price Low High' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sorting - Price High Low', $check_other_settings_sorting_label_high_low_get );
$check_other_settings_sorting_label_high_low = apply_filters( 'wpml_translate_single_string', $check_other_settings_sorting_label_high_low_get, 'divi-bodyshop-woocommerce', 'Sorting - Price High Low' );

	$orderby["menu_order"] = __($check_other_settings_sorting_label_default, 'woocommerce');
  $orderby["popularity"] = __($check_other_settings_sorting_label_popularity, 'woocommerce');
  $orderby["rating"] = __($check_other_settings_sorting_label_ave_rating, 'woocommerce');
  $orderby["date"] = __($check_other_settings_sorting_label_newness, 'woocommerce');
  $orderby["price"] = __($check_other_settings_sorting_label_low_high, 'woocommerce');
  $orderby["price-desc"] = __($check_other_settings_sorting_label_high_low, 'woocommerce');
	return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "bodycommerce_sorting_label_text", 20 );

/*
// product tabs order

add_filter( 'woocommerce_product_tabs', 'bodycommerce_remove_product_tabs', 98 );
function bodycommerce_remove_product_tabs( $tabs ) {
include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$get_other_settings_tabs_order = $titan->getOption( 'other_settings_tabs_order' );


if (in_array("description", $get_other_settings_tabs_order)) {
}else {
unset( $tabs['description'] );
}

if (in_array("reviews", $get_other_settings_tabs_order)) {
}else {
unset( $tabs['reviews'] );
}

if (in_array("additional_information", $get_other_settings_tabs_order)) {
}else {
unset( $tabs['additional_information'] );
}



    return $tabs;

}

// product tabs order

add_filter( 'woocommerce_product_tabs', 'bodycommerce_reorder_product_tabs', 98 );
function bodycommerce_reorder_product_tabs( $tabs ) {


  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $get_other_settings_tabs_order = $titan->getOption( 'other_settings_tabs_order' );

if (sizeof($get_other_settings_tabs_order) == 3) {
$tabs[$get_other_settings_tabs_order[0]]['priority'] = 5;
$tabs[$get_other_settings_tabs_order[1]]['priority'] = 10;
$tabs[$get_other_settings_tabs_order[2]]['priority'] = 15;
}

if (sizeof($get_other_settings_tabs_order) == 2) {
$tabs[$get_other_settings_tabs_order[0]]['priority'] = 5;
$tabs[$get_other_settings_tabs_order[1]]['priority'] = 10;
}

if (sizeof($get_other_settings_tabs_order) == 1) {
$tabs[$get_other_settings_tabs_order[0]]['priority'] = 5;
}

return $tabs;
}
*/
// product under image - archive

$get_other_settings_archive_desc_under_imager = $titan->getOption( 'other_settings_archive_desc_under_image' );

if ($get_other_settings_archive_desc_under_imager == 1) {
add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_single_excerpt', 5);
}
else {
  # code...
}



// Add custom checkbox to checkout page

$get_other_settings_checkout_custom_check_enable = $titan->getOption( 'other_settings_checkout_custom_check_enable' );

if ($get_other_settings_checkout_custom_check_enable == 1){



add_action('woocommerce_after_order_notes', 'bodycommerce_checkout_field');
function bodycommerce_checkout_field( $checkout ) {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $get_other_settings_checkout_custom_check_title = $titan->getOption( 'other_settings_checkout_custom_check_title' );
  $get_other_settings_checkout_custom_check_label = $titan->getOption( 'other_settings_checkout_custom_check_label' );

   echo '<div id="my-new-field"><h3>'.__($get_other_settings_checkout_custom_check_title).'</h3>';
   woocommerce_form_field( 'bodycommerce_checkbox', array(
       'type'          => 'checkbox',
       'class'         => array('input-checkbox'),
       'label'         => __($get_other_settings_checkout_custom_check_label),
       'required'  => true,
       ), $checkout->get_value( 'bodycommerce_checkbox' ));
   echo '</div>';
}



add_action('woocommerce_checkout_process', 'bodycommerce_checkout_field_process');
function bodycommerce_checkout_field_process() {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $get_other_settings_checkout_custom_check_error = $titan->getOption( 'other_settings_checkout_custom_check_error' );
   global $woocommerce;
   if (!$_POST['bodycommerce_checkbox'])
        $woocommerce->add_notice( __($get_other_settings_checkout_custom_check_error) );
}
add_action('woocommerce_checkout_update_order_meta', 'bodycommerce_checkout_field_update_order_meta');
function bodycommerce_checkout_field_update_order_meta( $order_id ) {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $get_other_settings_checkout_custom_check_title = $titan->getOption( 'other_settings_checkout_custom_check_title' );
   if ($_POST['bodycommerce_checkbox']) update_post_meta( $order_id, $get_other_settings_checkout_custom_check_title, esc_attr($_POST['bodycommerce_checkbox']));
}
}
else {
  # code...
}


// Change default country selected at checkout
$get_other_settings_checkout_default_country = $titan->getOption( 'other_settings_checkout_default_country' );
if ($get_other_settings_checkout_default_country == "" || $get_other_settings_checkout_default_country == "select") {

}
  else {
    add_filter( 'default_checkout_billing_country', 'bodycommerce_change_default_checkout_country' );
    function bodycommerce_change_default_checkout_country() {
      include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
      $get_other_settings_checkout_default_country = $titan->getOption( 'other_settings_checkout_default_country' );
      return ''.$get_other_settings_checkout_default_country.''; // country code
    }
  }

// remove breadcrumbs

$get_other_settings_breadcrumb_remove = $titan->getOption( 'other_settings_breadcrumb_remove' );

if ($get_other_settings_breadcrumb_remove == 1 ){
  add_action( 'init', 'bodycommerce_remove_breadcrumbs' );
function bodycommerce_remove_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
}
else {
  # code...
}


// bypass logout "are you sure"
function bodycommerce_bypass_logout_confirmation() {
    global $wp;

    if ( isset( $wp->query_vars['customer-logout'] ) ) {
        wp_redirect( str_replace( '&amp;', '&', wp_logout_url( wc_get_page_permalink( 'myaccount' ) ) ) );
        exit;
    }
}

add_action( 'template_redirect', 'bodycommerce_bypass_logout_confirmation' );



if (!current_user_can('edit_posts')) {
	add_filter('show_admin_bar', '__return_false');
}


// archive product button
$get_other_settings_button_below_product = $titan->getOption( 'other_settings_button_below_product' );

if ($get_other_settings_button_below_product == ""){}
  else {
     add_action( 'woocommerce_after_shop_loop_item', 'bodycommerce_view_product_button', 10);
    function bodycommerce_view_product_button() {

        include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
        $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
        $get_other_settings_button_below_product = $titan->getOption( 'other_settings_button_below_product' );

    global $product;
    $link = $product->get_permalink();
    echo do_shortcode('<div class="cat-actions"><a href="'.$link.'" class="button addtocartbutton">'.$get_other_settings_button_below_product.'</a></div>');

    }
  }


$get_product_page_template = $titan->getOption( 'product_page_template' );
if ($get_product_page_template == 0) {
}
else {
  function divi_bodycommerce_sinlge_product_breadcrumb_remove()  {
  echo "<style id='bodycommerce-single-prodcut'>.woocommerce.single-product #left-area > .woocommerce-breadcrumb {display:none;}</style>";
  }
  add_action( 'wp_head', 'divi_bodycommerce_sinlge_product_breadcrumb_remove', 15 );
}


$product_free_price_name = $titan->getOption( 'product_free_price_name' );
if ($product_free_price_name == "") {
}
else {
  add_filter('woocommerce_get_price_html', 'changeFreePriceNotice', 10, 2);
function changeFreePriceNotice($price, $product) {

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$product_free_price_name_get = $titan->getOption( 'product_free_price_name' );

do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Free Product Price Name', $product_free_price_name_get );
$product_free_price_name = apply_filters( 'wpml_translate_single_string', $product_free_price_name_get, 'divi-bodyshop-woocommerce', 'Free Product Price Name' );

		if ( $price == wc_price( 0.00 ) )
		return $product_free_price_name;
	else
		return $price;
}}




//////// Admin Change name and icon

add_action( 'admin_menu', 'rename_woocoomerce_admin_menu', 999 );
 function rename_woocoomerce_admin_menu()
 {
   include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
   $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
 $get_other_settings_admin_woo_name = $titan->getOption( 'other_settings_admin_woo_name' );

if ($get_other_settings_admin_woo_name != ""){

		 global $menu;
		 // Pinpoint menu item
		 $woo = recursive_array_search_php( 'WooCommerce', $menu );
		 // Validate
		 if( !$woo )
				 return;
		 $menu[$woo][0] = $get_other_settings_admin_woo_name;
   }
   else {
     # code...
   }
 }
 function recursive_array_search_php( $needle, $haystack )
 {
		 foreach( $haystack as $key => $value )
		 {
				 $current_key = $key;
				 if(
						 $needle === $value
						 OR (
								 is_array( $value )
								 && recursive_array_search_php( $needle, $value ) !== false
						 )
				 )
				 {
						 return $current_key;
				 }
		 }
		 return false;

 }

 add_action( 'admin_head', 'replace_woocommerce_dashcons' );
function replace_woocommerce_dashcons() {

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $get_other_settings_admin_woo_icon = $titan->getOption( 'other_settings_admin_woo_icon' );

if ($get_other_settings_admin_woo_icon != ""){
  $content =  sprintf('<style type="text/css">#adminmenu #toplevel_page_woocommerce .menu-icon-generic div.wp-menu-image::before {content:"\%s" !important;font-family: dashicons !important;}</style>',$get_other_settings_admin_woo_icon );

echo $content;
}
else {
  # code...
}
 }

//////// Admin Change name and icon



function custom_quantity_field_archive() {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$get_other_settings_add_to_basket_quantity_archive = $titan->getOption( 'other_settings_add_to_basket_quantity_archive' );

if ($get_other_settings_add_to_basket_quantity_archive == 1) {
 $product = wc_get_product( get_the_ID() );
 if ( ! $product->is_sold_individually() && 'variable' != $product->get_type() && $product->is_purchasable() ) {
   woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
 }
}
else {
  # code...
}
}
add_action( 'woocommerce_after_shop_loop_item', 'custom_quantity_field_archive', 0, 9 );



include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$get_other_settings_add_to_basket_archive = $titan->getOption( 'other_settings_add_to_basket_archive' );

if ($get_other_settings_add_to_basket_archive == 1) {
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 1 );
}
else{
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 1 );

}


$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$get_notice_product_added_cart = $titan->getOption( 'notice_product_added_cart' );
if ($get_notice_product_added_cart != "") {

add_filter('wc_add_to_cart_message_html', 'change_add_to_cart_notice', 10, 2);
function change_add_to_cart_notice($message,$products) {
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $get_notice_product_added_cart_get = $titan->getOption( 'notice_product_added_cart' );
  $notice_product_added_cart_btn_get = $titan->getOption( 'notice_product_added_cart_btn' );

  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Product was successfully added to cart message', $get_notice_product_added_cart_get );
    do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Product was successfully added to cart message button', $notice_product_added_cart_btn_get );
  $get_notice_product_added_cart = apply_filters( 'wpml_translate_single_string', $get_notice_product_added_cart_get, 'divi-bodyshop-woocommerce', 'Product was successfully added to cart message' );
$notice_product_added_cart_btn = apply_filters( 'wpml_translate_single_string', $notice_product_added_cart_btn_get, 'divi-bodyshop-woocommerce', 'Product was successfully added to cart message button' );

  if($notice_product_added_cart_btn == "") {
    $notice_product_added_cart_btn_display = "View Basket";
  }
  else {
    $notice_product_added_cart_btn_display = $notice_product_added_cart_btn;
  }


global $woocommerce;
$return_to  = get_permalink(wc_get_page_id('cart'));
$message    = sprintf('<a href="%s" class="button wc-forward">%s</a> %s', $return_to, esc_html__($notice_product_added_cart_btn_display, 'woocommerce'), esc_html__($get_notice_product_added_cart, 'woocommerce') );
return $message;


}
}
else{

}

// ajax add to cart notify text


$other_settings_ajax_add_to_cart_text_notify = $titan->getOption( 'other_settings_ajax_add_to_cart_text_notify' );
if ($other_settings_ajax_add_to_cart_text_notify != "") {
  add_action('wp_footer', 'ajax_atc_notify_txt');
  function ajax_atc_notify_txt(){


      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
      $other_settings_ajax_add_to_cart_text_notify_get = $titan->getOption( 'other_settings_ajax_add_to_cart_text_notify' );
      do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Added to Cart Notify Text', $other_settings_ajax_add_to_cart_text_notify_get );
      $other_settings_ajax_add_to_cart_text_notify = apply_filters( 'wpml_translate_single_string', $other_settings_ajax_add_to_cart_text_notify_get, 'divi-bodyshop-woocommerce', 'Added to Cart Notify Text' );

      $other_settings_ajax_add_to_cart_text_notify_time = $titan->getOption( 'other_settings_ajax_add_to_cart_text_notify_time' );
      $ajax_add_to_cart_text_notify_btn_bg_color = $titan->getOption( 'ajax_add_to_cart_text_notify_btn_bg_color' );
      $ajax_add_to_cart_text_notify_btn_text_color = $titan->getOption( 'ajax_add_to_cart_text_notify_btn_text_color' );

    ?>
<input class="db_atc_notify_txt" type="hidden" value="<?php echo esc_html__( $other_settings_ajax_add_to_cart_text_notify, 'divi-bodyshop-woocommerce' ); ?>">
<input class="db_atc_notify_txt_time" type="hidden" value="<?php echo esc_attr__( $other_settings_ajax_add_to_cart_text_notify_time, 'divi-bodyshop-woocommerce' ); ?>">
<input class="db_atc_notify_bg_color" type="hidden" value="<?php echo esc_attr__( $ajax_add_to_cart_text_notify_btn_bg_color, 'divi-bodyshop-woocommerce' ); ?>">
<input class="db_atc_notify_text_color" type="hidden" value="<?php echo esc_attr__( $ajax_add_to_cart_text_notify_btn_text_color, 'divi-bodyshop-woocommerce' ); ?>">
    <?php
  }
}
else {
  // code...
}

$other_settings_straight_to_checkout = $titan->getOption( 'other_settings_straight_to_checkout' );
if ($other_settings_straight_to_checkout == 1) {
  add_filter('woocommerce_add_to_cart_redirect', 'bodycommerce_straight_checkout');
  function bodycommerce_straight_checkout() {
   global $woocommerce;
   $checkout_url = wc_get_checkout_url();
   return $checkout_url;
  }
}
else {
  // code...
}

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (isset($mydata['other_settings_admin_woo_products_name_plural'][0])) {

if ($mydata['other_settings_admin_woo_products_name_plural'][0] != "") {
  add_filter( 'woocommerce_register_post_type_product', 'custom_post_type_label_woo' );

  function custom_post_type_label_woo( $args ){

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
    $other_settings_admin_woo_products_name_plural = $titan->getOption( 'other_settings_admin_woo_products_name_plural' );
    $other_settings_admin_woo_products_name_singular = $titan->getOption( 'other_settings_admin_woo_products_name_singular' );


      $labels = array(
          'name'               => __( $other_settings_admin_woo_products_name_plural, 'divi-bodyshop-woocommerce' ),
          'singular_name'      => __( $other_settings_admin_woo_products_name_singular, 'divi-bodyshop-woocommerce' ),
          'menu_name'          => _x( $other_settings_admin_woo_products_name_plural, 'Admin menu name', 'divi-bodyshop-woocommerce' ),
          'add_new'            => __( 'Add '.$other_settings_admin_woo_products_name_singular.'', 'divi-bodyshop-woocommerce' ),
          'add_new_item'       => __( 'Add New '.$other_settings_admin_woo_products_name_singular.'', 'divi-bodyshop-woocommerce' ),
          'edit'               => __( 'Edit  '.$other_settings_admin_woo_products_name_singular.'', 'divi-bodyshop-woocommerce' ),
          'edit_item'          => __( 'Edit  '.$other_settings_admin_woo_products_name_singular.'', 'divi-bodyshop-woocommerce' ),
          'new_item'           => __( 'New  '.$other_settings_admin_woo_products_name_singular.'', 'divi-bodyshop-woocommerce' ),
          'view'               => __( 'View  '.$other_settings_admin_woo_products_name_singular.'', 'divi-bodyshop-woocommerce' ),
          'view_item'          => __( 'View  '.$other_settings_admin_woo_products_name_singular.'', 'divi-bodyshop-woocommerce' ),
          'search_items'       => __( 'Search '.$other_settings_admin_woo_products_name_plural.'', 'divi-bodyshop-woocommerce' ),
          'not_found'          => __( 'No  '.$other_settings_admin_woo_products_name_plural.' found', 'divi-bodyshop-woocommerce' ),
          'not_found_in_trash' => __( 'No '.$other_settings_admin_woo_products_name_plural.' found in trash', 'divi-bodyshop-woocommerce' ),
          'parent'             => __( 'Parent  '.$other_settings_admin_woo_products_name_singular.'', 'divi-bodyshop-woocommerce' )
      );

      $args['labels'] = $labels;
      return $args;
  }
}


}

// CUSTOM QUANTITY


$custom_quantity_field = $titan->getOption( 'custom_quantity_field' );
if ($custom_quantity_field == 1) {
  add_action('wp_footer', 'custom_quantity_field_footer');
  add_action('wp_head', 'custom_quantity_field_head');

  function custom_quantity_field_footer(){
    ?>
<script>
jQuery(document).ready(function(t){t(".cart .quantity").prepend('<button type="button" class="sub"></button>'),t(".cart .quantity").append('<button type="button" class="add"></button>'),t(".shop_table .quantity").prepend('<button type="button" class="sub"></button>'),t(".shop_table .quantity").append('<button type="button" class="add"></button>'),t(".quantity :input").bind("keyup mouseup",function(){var n=t(this).attr("max");""==n&&(n="999");var i=t(this).val(),a=parseInt(n);i>=a&&t(this).val(a)}),t(document).on("click",".add",function(){var n=t(this).closest(".quantity").find("input").attr("max");""==n&&(n="999");var i=t(this).closest(".quantity").find("input").val(),a=parseInt(n);i>=a?t(this).closest(".quantity").find("input").val(a):(t(this).closest(".quantity").find("input").val(+t(this).closest(".quantity").find("input").val()+1),t(this).closest(".woocommerce-cart-form").find(".button").prop("disabled",!1))}),t(document).on("click",".sub",function(){var n=t(this).closest(".quantity").find("input").attr("max");""==n&&(n="999");var i=t(this).closest(".quantity").find("input").val(),a=parseInt(n);i>a?t(this).closest(".quantity").find("input").val(a):t(this).closest(".quantity").find(".qty").val()>1&&(t(this).closest(".quantity").find(".qty").val()>1&&t(this).closest(".quantity").find(".qty").val(+t(this).closest(".quantity").find(".qty").val()-1),t(this).closest(".woocommerce-cart-form").find(".button").prop("disabled",!1))}),t(document).ajaxSuccess(function(){t(".quantity .sub").remove(),t(".quantity .add").remove(),t(".quantity").prepend('<button type="button" class="sub"></button>'),t(".quantity").append('<button type="button" class="add"></button>')})});

</script>
    <?php
  }


  function custom_quantity_field_head(){

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
    $quantity_width = $titan->getOption( 'quantity_width' ); // done
    $quantity_max_width = $titan->getOption( 'quantity_max_width' ); // done
    $quantity_background_color = $titan->getOption( 'quantity_background_color' ); // done
    $quantity_number_color = $titan->getOption( 'quantity_number_color' ); // done
    $quantity_minus_icon = $titan->getOption( 'quantity_minus_icon' ); // done
    $quantity_number_minus_color = $titan->getOption( 'quantity_number_minus_color' ); // done
    $quantity_number_minus_size = $titan->getOption( 'quantity_number_minus_size' ); // done
    $quantity_add_icon = $titan->getOption( 'quantity_add_icon' ); // done
    $quantity_number_add_color = $titan->getOption( 'quantity_number_add_color' ); // done
    $quantity_number_add_size = $titan->getOption( 'quantity_number_add_size' ); // done
    $quantity_border_style = $titan->getOption( 'quantity_border_style' );
    $quantity_border_size = $titan->getOption( 'quantity_border_size' );
    $quantity_border_color = $titan->getOption( 'quantity_border_color' );
    $quantity_border_radius = $titan->getOption( 'quantity_border_radius' );
    $quantity_border_width = $titan->getOption( 'quantity_border_width' );
    $quantity_border_height = $titan->getOption( 'quantity_border_height' );

    if ($quantity_border_height == "0") {
      $quantity_border_height_dis = "";
    }
    else {
      $quantity_border_height_dis = "height: " . $quantity_border_height . "px";
    }

    $render_minus_icon = sprintf('content: "\%s";', $quantity_minus_icon);
    $render_add_icon = sprintf('content: "\%s";', $quantity_add_icon);

 $css_woo_bodyshop =  '<style id="bodycommerce_custom_quantity_input">';

$css_woo_bodyshop .= '



.woocommerce-page .product form.cart .quantity, .woocommerce-page .shop_table .quantity, .archive.woocommerce .quantity, body.woocommerce .quantity{
  text-decoration: none;
  -webkit-appearance: none;
  -moz-appearance: textfield;
  outline: 0;
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  border-style: '. $quantity_border_style .';
  border-width: '. $quantity_border_size .'px;
  border-color: '. $quantity_border_color .';
  border-radius: '. $quantity_border_radius .'px !important;
  border-width: '. $quantity_border_width . 'px;
  background-color: '. $quantity_background_color .';
  position: relative;
  min-width: '. $quantity_max_width .'px !important;
  width: '. $quantity_width .'px !important;
  '.$quantity_border_height_dis.';
  overflow: hidden;
margin: 0 20px 0 0!important;
}

.woocommerce-page .shop_table .quantity, body.woocommerce .quantity {
    display: inline-block;
}
.woocommerce-page .product form.cart .quantity input[type=number].qty, .woocommerce-page .shop_table .quantity input[type=number].qty, .archive.woocommerce .quantity input[type=number].qty, body.woocommerce .quantity input[type=number].qty {
    border: none !important;
    text-decoration: none!important;
    -webkit-appearance: none!important;
    -moz-appearance: textfield!important;
    appearance: none!important;
    outline: 0!important;
    -webkit-box-shadow: none!important;
    -moz-box-shadow: none!important;
    box-shadow: none!important;
    background-color: transparent!important;
    color: '. $quantity_number_color .' !important;
    width: 100%;
    text-align: center;
    -webkit-appearance: none !important;
    margin: 0;
}
.sub, .add{
    text-decoration: none;
    position: absolute;
    top: 0;
    bottom: 0;
    line-height: 46px;
    font-size: 25px;
    padding: 0 12px;
    background-color: transparent;
    border: none;
    cursor: pointer;
    min-width: 40px;
}
.sub {
	    left: 0;
}

.add {
      right: 0;
}

.sub::after, .add::after {
  position: absolute;
  font-family: "ETmodules";
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
}

.sub::after {
  '. $render_minus_icon .'
  color: '. $quantity_number_minus_color .';
  font-size: '. $quantity_number_minus_size .'px;
}

.add::after {
  '. $render_add_icon .'
  color: '. $quantity_number_add_color .';
  font-size: '. $quantity_number_add_size .'px;
}


.woocommerce-page form .quantity input[type=number]::-webkit-inner-spin-button,.woocommerce-page form .quantity input[type=number]::-webkit-outer-spin-button, body.woocommerce .quantity input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance:none;margin:0
}

 body.woocommerce .quantity input[type=number]::-webkit-inner-spin-button, body.woocommerce .quantity input[type=number], .woocommerce-page form .quantity input[type=number],.woocommerce-page .shop_table .quantity input[type=number]::-webkit-inner-spin-button,.woocommerce-page .shop_table .quantity input[type=number]::-webkit-outer-spin-button{-webkit-appearance:none;margin:0}.woocommerce-page .shop_table .quantity input[type=number],
.woocommerce-page .product form.cart .quantity input[type="number"].qty, .woocommerce-page .shop_table .quantity input[type="number"].qty{
  -webkit-appearance: none !important;
    -webkit-appearance: textfield !important;
}


';
$css_woo_bodyshop .= '</style>';
//minify it
$css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
echo $css_woo_bodyshop_min;
  }


}
else {
  // code...
}



// CUSTOM SELECT FIELD

$custom_select_field = $titan->getOption( 'custom_select_field' );
$custom_select_field_select2 = $titan->getOption( 'custom_select_field_select2' );
if ($custom_select_field == 1) {
  add_action('wp_head', 'custom_select_field_head');
  add_action('wp_footer', 'custom_select_field_footer');
  if ($custom_select_field_select2 == 1) {
  add_action( 'wp_enqueue_scripts', 'disable_select2_dropdown', 100 );
  function disable_select2_dropdown() {
    if ( class_exists( 'woocommerce' ) ) {
      wp_dequeue_style( 'selectWoo' );
      wp_deregister_style( 'selectWoo' );

      wp_dequeue_script( 'selectWoo');
      wp_deregister_script('selectWoo');

}
  }
}



  function custom_select_field_footer(){
    ?>
<script>jQuery(document).ready(function(e){e(".woocommerce-page select").parent().addClass("custom-dropdown"),e(".woocommerce-page select.bodycommerce-variation-raw-select").parent().removeClass("custom-dropdown"),e(".woocommerce-page select#rating").parent().removeClass("custom-dropdown")});</script>
    <?php
  }
  function custom_select_field_head(){

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

    $custom_select_background_color = $titan->getOption( 'custom_select_background_color' );
    $custom_select_text_color = $titan->getOption( 'custom_select_text_color' );
    $custom_select_font_size = $titan->getOption( 'custom_select_font_size' );
    $custom_select_pad_top = $titan->getOption( 'custom_select_pad_top' );
    $custom_select_pad_bottom = $titan->getOption( 'custom_select_pad_bottom' );
    $custom_select_pad_right = $titan->getOption( 'custom_select_pad_right' );
    $custom_select_pad_left = $titan->getOption( 'custom_select_pad_left' );
    $custom_select_border_style = $titan->getOption( 'custom_select_border_style' );
    $custom_select_border_size = $titan->getOption( 'custom_select_border_size' );
    $custom_select_border_color = $titan->getOption( 'custom_select_border_color' );
    $custom_select_border_radius = $titan->getOption( 'custom_select_border_radius' );
    $custom_select_icon = $titan->getOption( 'custom_select_icon' );
    $custom_select_color = $titan->getOption( 'custom_select_color' );
    $custom_select_size = $titan->getOption( 'custom_select_icon_size' );
    $custom_select_icon_background_color = $titan->getOption( 'custom_select_icon_background_color' );
    $custom_select_dis_right = $titan->getOption( 'custom_select_dis_right' );
    $custom_select_icon_background_width = $titan->getOption( 'custom_select_icon_background_width' );

    $render_custom_select_icon = sprintf('content: "\%s";', $custom_select_icon);

 $css_woo_bodyshop =  '<style id="bodycommerce_custom_select_input">';
$css_woo_bodyshop .= '

.woocommerce .product form.cart .reset_variations {
position: absolute;
    bottom: -25px;
}

.variations select, .woocommerce .product form.cart .variations td select, .woocommerce form .form-row select, .woocommerce-page form .form-row select, .orderby, body.woocommerce div.product form.cart .variations td select {
  background-color: '.$custom_select_background_color.';
  color: '.$custom_select_text_color.' !important;
  font-size: '.$custom_select_font_size.'px;
  padding-top: '.$custom_select_pad_top.'px;
  padding-bottom: '.$custom_select_pad_bottom.'px;
  padding-right: '.$custom_select_pad_right.'px;
  padding-left: '.$custom_select_pad_left.'px;
  border: 0;
  margin: 0;
  text-indent: 0.01px;
  text-overflow: "";
  -moz-appearance: none !important;
  -webkit-appearance: none !important;
  -moz-appearance: none !important;
  appearance: none;
  display: block;
  width: 100%;
  border-style: '. $custom_select_border_style .' !important;
  border-width: '. $custom_select_border_size .'px;
  border-color: '. $custom_select_border_color .';
  border-radius: '. $custom_select_border_radius .'px !important;
}

.custom-dropdown {
  position: relative;
  display: block;
  vertical-align: middle !important;
}



.woocommerce .product form.cart .variations td {
  padding: 0 !important;
}

.woocommerce .product form.cart .variations .custom-dropdown {
  margin-left: 20px;
}

.custom-dropdown select::-ms-expand {
    display: none;
}

.custom-dropdown::before,
.custom-dropdown::after {
  content: "";
  position: absolute;
  pointer-events: none;
}

.custom-dropdown::after {
  height: 1em;
      line-height: 1;
      right: '.$custom_select_dis_right.'px;
      top: 50%;
      margin-top: -.5em;
      position: absolute;
      font-family: "ETmodules";
    '.$render_custom_select_icon.'
      font-size: '.$custom_select_size.'px;
      color: '.$custom_select_color.';
      z-index: 10;
}



.custom-dropdown::before {
  width: '.$custom_select_icon_background_width.'px;
  right: 0;
  top: 0;
  bottom: 0;
  border-radius: 0 3px 3px 0;
  background-color: '.$custom_select_icon_background_color.';
  z-index: 4;
}

.custom-dropdown::after {
  color: rgba(0,0,0,.6);
}

.custom-dropdown select[disabled] {
  color: rgba(0,0,0,.25);
} ';
$css_woo_bodyshop .= '</style>';
//minify it
$css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
echo $css_woo_bodyshop_min;
  }

}
else {
  // code...
}


// CUSTOM INPUT FIELD

$custom_input_field = $titan->getOption( 'custom_input_field' );
$custom_input_field_placeholder = $titan->getOption( 'custom_input_field_placeholder' );
if ($custom_input_field == 1) {
  add_action('wp_head', 'custom_input_field_head');
  if ($custom_input_field_placeholder == 1) {
  add_action('wp_footer', 'custom_input_field_footer');
}

  function custom_input_field_footer(){
    ?>
    <script>jQuery(document).ready(function(t){t("input").each(function(e,a){var r=t('label[for="'+t(this).attr("id")+'"]');t(this).attr("placeholder",r.text())})});</script>
    <style>.checkout-areaform .form-row label, .checkout-area form .form-row label {display: none;}</style>
    <?php
  }
  function custom_input_field_head(){

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
    $custom_input_background_color = $titan->getOption( 'custom_input_background_color' );
    $custom_input_text_color = $titan->getOption( 'custom_input_text_color' );
    $custom_input_placeholder_text_color = $titan->getOption( 'custom_input_placeholder_text_color' );
    $custom_input_font_size = $titan->getOption( 'custom_input_font_size' );
    $custom_input_pad_top = $titan->getOption( 'custom_input_pad_top' );
    $custom_input_pad_bottom = $titan->getOption( 'custom_input_pad_bottom' );
    $custom_input_pad_right = $titan->getOption( 'custom_input_pad_right' );
    $custom_input_pad_left = $titan->getOption( 'custom_input_pad_left' );
    $custom_input_border_style = $titan->getOption( 'custom_input_border_style' );
    $custom_input_border_size = $titan->getOption( 'custom_input_border_size' );
    $custom_input_border_color = $titan->getOption( 'custom_input_border_color' );
    $custom_input_border_radius = $titan->getOption( 'custom_input_border_radius' );
    $custom_input_error_border_color = $titan->getOption( 'custom_input_error_border_color' );
    $custom_input_valid_border_color = $titan->getOption( 'custom_input_valid_border_color' );



 $css_woo_bodyshop =  '<style id="bodycommerce_custom_select_input">';
$css_woo_bodyshop .= '


.woocommerce form .form-row input.input-text, .woocommerce form .form-row textarea {
  background-color: '.$custom_input_background_color.';
  color: '.$custom_input_text_color.' !important;
  font-size: '.$custom_input_font_size.'px;
  padding-top: '.$custom_input_pad_top.'px;
  padding-bottom: '.$custom_input_pad_bottom.'px;
  padding-right: '.$custom_input_pad_right.'px;
  padding-left: '.$custom_input_pad_left.'px;
  margin: 0;
  border-radius: 0 !important;
  text-indent: 0.01px;
  text-overflow: "";
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
  display: block;
  width: 100%;
  border-style: '. $custom_input_border_style .' !important;
  border-width: '. $custom_input_border_size .'px;
  border-color: '. $custom_input_border_color .';
  border-radius: '. $custom_input_border_radius .'px !important;
}

::-webkit-input-placeholder { /* Chrome/Opera/Safari */
color: '.$custom_input_placeholder_text_color.' !important;
}
/* CONTROLS PLACEHOLDER TEXT */
::-moz-placeholder { /* Firefox 19+ */
color: '.$custom_input_placeholder_text_color.' !important;
}
/* CONTROLS PLACEHOLDER TEXT */
:-ms-input-placeholder { /* IE 10+ */
color: '.$custom_input_placeholder_text_color.' !important;
}
/* CONTROLS PLACEHOLDER TEXT */
:-moz-placeholder { /* Firefox 18- */
color: '.$custom_input_placeholder_text_color.' !important;
}


.checkout-area form .form-row.woocommerce-validated input.input-text {
border-color: '. $custom_input_valid_border_color .';
}

.woocommerce form .form-row.woocommerce-invalid input.input-text {
border-color: '. $custom_input_error_border_color .';

}

';
$css_woo_bodyshop .= '</style>';
//minify it
$css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
echo $css_woo_bodyshop_min;
  }

}
else {
  // code...
}


$divi_search_products = $titan->getOption( 'divi_search_products' );
if ($divi_search_products == 1) {

add_action('wp_footer', 'divi_search_products_header');
function divi_search_products_header(){
  ?>
<script>jQuery(document).ready(function(e){e(".et-search-form").append('<input type="hidden" name="post_type" value="product" />'),e(".et_pb_menu__search-form").each(function(p,t){e(".et_pb_menu__search-form").append('<input type="hidden" name="post_type" value="product" />')})});</script>
  <?php
}

}

// Active swatch name
$variation_swatch_label_text = $titan->getOption( 'variation_swatch_label_text' );
if ($variation_swatch_label_text == 1) {

add_action('wp_footer', 'variation_active_name');
function variation_active_name(){

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $variation_text_between_swatch_label_text = $titan->getOption( 'variation_text_between_swatch_label_text' );

if ($variation_text_between_swatch_label_text == "") {
  $between = " ";
}
else {
  $between = ' '. $variation_text_between_swatch_label_text . ' ';
}

  ?>
<script>
jQuery(document).ready(function(t){
  t(".variable-item").click(function(){var e=t(this).closest(".variable-item").attr("data-wvstooltip"),a=t(this).closest("ul").attr("data-attribute_name_title");t(this).closest("tr").find("label").html(a+"<?php echo $between ?>"+e)})
});
</script>
  <?php
}
}

// CHANGE THE LINK OF THE BREADCRUMBS HOME TO SHOP

$other_settings_breadcrumb_home_shop = $titan->getOption( 'other_settings_breadcrumb_home_shop' );
if ($other_settings_breadcrumb_home_shop == 1) {

add_filter( 'woocommerce_breadcrumb_home_url', 'bodycommerce_breadcrumbs_home_shop' );
function bodycommerce_breadcrumbs_home_shop() {
$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
return $shop_page_url;
}
}




$other_settings_breadcrumb_home_shop_text = $titan->getOption( 'other_settings_breadcrumb_home_shop_text' );
if ($other_settings_breadcrumb_home_shop_text != "") {

add_filter( 'woocommerce_breadcrumb_defaults', 'bodycommmerce_change_breadcrumbs_home_text' );
function bodycommmerce_change_breadcrumbs_home_text( $defaults ) {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$other_settings_breadcrumb_home_shop_text_get = $titan->getOption( 'other_settings_breadcrumb_home_shop_text' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Change breadcrumbs home text', $other_settings_breadcrumb_home_shop_text_get );
$other_settings_breadcrumb_home_shop_text = apply_filters( 'wpml_translate_single_string', $other_settings_breadcrumb_home_shop_text_get, 'divi-bodyshop-woocommerce', 'Change breadcrumbs home text' );
    // Change the breadcrumb home text from 'Home' to 'Apartment'
	$defaults['home'] = $other_settings_breadcrumb_home_shop_text;
	return $defaults;
}

}





$other_settings_user_password_confirm = $titan->getOption( 'other_settings_user_password_confirm' );
if ($other_settings_user_password_confirm == 1) {

  // ----- validate password match on the registration page
  function bodycommerce_registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
  	global $woocommerce;
  	extract( $_POST );
  	if ( strcmp( $password, $password2 ) !== 0 ) {
  		return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
  	}
  	return $reg_errors;
  }
  add_filter('woocommerce_registration_errors', 'bodycommerce_registration_errors_validation', 10,3);

  // ----- add a confirm password fields match on the registration page
  function bodycommerce_register_form_password_repeat() {
    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $other_settings_user_password_confirm_text_get = $titan->getOption( 'other_settings_user_password_confirm_text' );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Confrim Password Text', $other_settings_user_password_confirm_text_get );
  $other_settings_user_password_confirm_text = apply_filters( 'wpml_translate_single_string', $other_settings_user_password_confirm_text_get, 'divi-bodyshop-woocommerce', 'Confrim Password Text' );
  	?>
  	<p class="form-row form-row-wide">
  		<label for="reg_password2"><?php _e( $other_settings_user_password_confirm_text, 'woocommerce' ); ?> <span class="required">*</span></label>
  		<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
  	</p>
  	<?php
  }
  add_action( 'woocommerce_register_form', 'bodycommerce_register_form_password_repeat' );

  // ----- Validate confirm password field match to the checkout page
  function bodycommerce_woocommerce_confirm_password_validation( $posted ) {
      $checkout = WC()->checkout;
      if ( ! is_user_logged_in() && ( $checkout->must_create_account || ! empty( $posted['createaccount'] ) ) ) {
          if ( strcmp( $posted['account_password'], $posted['account_confirm_password'] ) !== 0 ) {
              wc_add_notice( __( 'Passwords do not match.', 'woocommerce' ), 'error' );
          }
      }
  }
  add_action( 'woocommerce_after_checkout_validation', 'bodycommerce_woocommerce_confirm_password_validation', 10, 2 );

  // ----- Add a confirm password field to the checkout page
  function bodycommerce_oocommerce_confirm_password_checkout( $checkout ) {
      if ( get_option( 'woocommerce_registration_generate_password' ) == 'no' ) {

          $fields = $checkout->get_checkout_fields();

          $fields['account']['account_confirm_password'] = array(
              'type'              => 'password',
              'label'             => __( 'Confirm password', 'woocommerce' ),
              'required'          => true,
              'placeholder'       => _x( 'Confirm password', 'placeholder', 'woocommerce' )
          );

          $checkout->__set( 'checkout_fields', $fields );
      }
  }
  add_action( 'woocommerce_checkout_init', 'bodycommerce_oocommerce_confirm_password_checkout', 10, 1 );

}





// Change My Account Name
$my_account_menu_text_change = $titan->getOption( 'my_account_menu_text_change' );
$my_account_menu_text_change_css = $titan->getOption( 'my_account_menu_text_change_css' );
if ($my_account_menu_text_change == "" || $my_account_menu_text_change_css == "") {
}
else {

add_action('wp_footer', 'bodycommerce_change_my_account_name');
function bodycommerce_change_my_account_name(){

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $my_account_menu_text_change_get = $titan->getOption( 'my_account_menu_text_change' );

  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'My Account Menu Text Change', $my_account_menu_text_change_get );
  $my_account_menu_text_change = apply_filters( 'wpml_translate_single_string', $my_account_menu_text_change_get, 'divi-bodyshop-woocommerce', 'My Account Menu Text Change' );

  $my_account_menu_text_change_css = $titan->getOption( 'my_account_menu_text_change_css' );

  if ( is_user_logged_in() ) {
  } else {
  ?>
<script>jQuery(document).ready(function( $ ) {$(".<?php echo $my_account_menu_text_change_css ?> a").html("<?php echo $my_account_menu_text_change ?>");});</script>
  <?php
}
}
}

// Overwrite German Market
$settings_german_market_overwrite = $titan->getOption( 'settings_german_market_overwrite' );
if ($settings_german_market_overwrite == 1) {

add_filter( 'german_market_add_woocommerce_de_templates_force_original', function( $boolean, $template_name ) {
  if ( $template_name != 'checkout/terms.php' ) { return true; }
  return $boolean;
  }, 10, 2 );

}


$other_settings_custom_login_redirect = $titan->getOption( 'other_settings_custom_login_redirect' );
if ($other_settings_custom_login_redirect != "") {

function custom_registration_redirect() {

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $other_settings_custom_login_redirect = $titan->getOption( 'other_settings_custom_login_redirect' );

  if ($other_settings_custom_login_redirect == "/") {
    return home_url('/');
  } else {
    return home_url('/' . $other_settings_custom_login_redirect);
  }
}
add_action('woocommerce_registration_redirect', 'custom_registration_redirect', 2);

}




add_action('wp_footer', 'bodycommerce_same_height_cards');
function bodycommerce_same_height_cards(){
  ?>
<script>
jQuery(document).ready(function(e){
  jQuery('.same-height-cards .et_pb_row_bodycommerce').each(function(){
    var highestBox = 0;jQuery('li', this).each(function(){
      if(jQuery(this).height() > highestBox) {
        highestBox = jQuery(this).height();
      }
    });
    var margin_bottom =	jQuery(this).find(".et_pb_section").css("marginBottom");
    console.log("margin-bottom: " + margin_bottom);
    if (margin_bottom == "") {
    var new_height = highestBox - margin_bottom.slice(0,-2);
  } else {
  var new_height = highestBox;
  }
    console.log("highest: " + highestBox);
    console.log("margin_bottom: " + margin_bottom);
    console.log("new_height: " + new_height);
    jQuery('li',this).height(new_height);
    jQuery('li',this).css("margin-bottom", margin_bottom);
    jQuery('li .et_pb_section',this).css("height", "100%");
    jQuery('li .et_pb_row',this).css("height", "100%");
  });
});
</script>
  <?php

}


// Put original Divi cart icon at end
// $settings_divi_cart_end_primary_menu = $titan->getOption( 'settings_divi_cart_end_primary_menu' );
// if ($settings_divi_cart_end_primary_menu == 1) {
//
//   add_filter( 'wp_nav_menu_items', 'bodycommerce_add_cart_end_primary_menu', 10, 2 );
//   function bodycommerce_add_cart_end_primary_menu ( $items, $args ) {
//
//     include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
//     $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
//     $settings_divi_cart_end_primary_menu_choose = $titan->getOption( 'settings_divi_cart_end_primary_menu_choose' );
//
//
//     if( $args->theme_location == $settings_divi_cart_end_primary_menu_choose ) {
//           $items .= do_shortcode('[bodycommerce_cart_icon]');
//     }
//
// return $items;
//   }
//
// }



// Hide BC modules
$settings_hide_modules = $titan->getOption( 'settings_hide_modules' );
if ($settings_hide_modules == 1) {

  add_action('admin_head', 'divi_engine_admin_css_hide_modules');

  function divi_engine_admin_css_hide_modules() {
    echo '<style>
  .et_db_stock_status,.et_fb_db_account_nav,.et_fb_db_action_shortcode,.et_fb_db_add_info,.et_fb_db_atc,.et_fb_db_attribute,.et_fb_db_breadcrumbs,.et_fb_db_cart_products,.et_fb_db_cart_total,.et_fb_db_checkout_after_cust_details,.et_fb_db_checkout_before_cust_details,.et_fb_db_checkout_before_order_review,.et_fb_db_checkout_billing,.et_fb_db_checkout_coupon,.et_fb_db_checkout_order_review,.et_fb_db_checkout_payment,.et_fb_db_checkout_shipping,.et_fb_db_content,.et_fb_db_crosssell,.et_fb_db_images,.et_fb_db_login_form,.et_fb_db_login_password_confirmation,.et_fb_db_login_password_lost,.et_fb_db_login_password_reset,.et_fb_db_meta,.et_fb_db_notices,.et_fb_db_price,.et_fb_db_pro_before,.et_fb_db_pro_navigation,.et_fb_db_product_carousel,.et_fb_db_product_slider,.et_fb_db_product_summary,.et_fb_db_product_title,.et_fb_db_products_search,.et_fb_db_rating,.et_fb_db_register_form,.et_fb_db_related_products,.et_fb_db_reviews,.et_fb_db_sharing,.et_fb_db_shop_after,.et_fb_db_shop_button,.et_fb_db_shop_cat_loop,.et_fb_db_shop_cat_title,.et_fb_db_shop_loop,.et_fb_db_shop_thumbnail,.et_fb_db_short_desc,.et_fb_db_single_image,.et_fb_db_tabs,.et_fb_db_thankyou_cust_details,.et_fb_db_thankyou_details,.et_fb_db_thankyou_overview,.et_fb_db_thankyou_payment_details,.et_fb_db_upsell,.et_fb_db_woo_add_payment_method,.et_fb_db_woo_addresses,.et_fb_db_woo_avatar,.et_fb_db_woo_downloads,.et_fb_db_woo_edit_account,.et_fb_db_woo_edit_addresses,.et_fb_db_woo_get_name,.et_fb_db_woo_orders,.et_fb_db_woo_payment_methods,.et_fb_db_woo_user_name,.et_fb_db_woo_view_order,.et_pb_db_account_nav,.et_pb_db_action_shortcode,.et_pb_db_add_info,.et_pb_db_atc,.et_pb_db_attribute,.et_pb_db_breadcrumbs,.et_pb_db_cart_products,.et_pb_db_cart_total,.et_pb_db_checkout_after_cust_details,.et_pb_db_checkout_before_cust_details,.et_pb_db_checkout_before_order_review,.et_pb_db_checkout_billing,.et_pb_db_checkout_coupon,.et_pb_db_checkout_order_review,.et_pb_db_checkout_payment,.et_pb_db_checkout_shipping,.et_pb_db_content,.et_pb_db_crosssell,.et_pb_db_images,.et_pb_db_login_form,.et_pb_db_login_password_confirmation,.et_pb_db_login_password_lost,.et_pb_db_login_password_reset,.et_pb_db_meta,.et_pb_db_notices,.et_pb_db_price,.et_pb_db_pro_before,.et_pb_db_pro_navigation,.et_pb_db_product_carousel,.et_pb_db_product_slider,.et_pb_db_product_summary,.et_pb_db_product_title,.et_pb_db_products_search,.et_pb_db_rating,.et_pb_db_register_form,.et_pb_db_related_products,.et_pb_db_reviews,.et_pb_db_sharing,.et_pb_db_shop_after,.et_pb_db_shop_button,.et_pb_db_shop_cat_loop,.et_pb_db_shop_cat_title,.et_pb_db_shop_loop,.et_pb_db_shop_thumbnail,.et_pb_db_short_desc,.et_pb_db_single_image,.et_pb_db_tabs,.et_pb_db_thankyou_cust_details,.et_pb_db_thankyou_details,.et_pb_db_thankyou_overview,.et_pb_db_thankyou_payment_details,.et_pb_db_upsell,.et_pb_db_woo_add_payment_method,.et_pb_db_woo_addresses,.et_pb_db_woo_avatar,.et_pb_db_woo_downloads,.et_pb_db_woo_edit_account,.et_pb_db_woo_edit_addresses,.et_pb_db_woo_get_name,.et_pb_db_woo_orders,.et_pb_db_woo_payment_methods,.et_pb_db_woo_user_name,.et_pb_db_woo_view_order{display:none!important}
  </style>';
  }

  add_action('wp_head', 'divi_engine_frontend_css_hide_modules');

  function divi_engine_frontend_css_hide_modules() {
    echo '<style>
.et_db_stock_status,.et_fb_db_account_nav,.et_fb_db_action_shortcode,.et_fb_db_add_info,.et_fb_db_atc,.et_fb_db_attribute,.et_fb_db_breadcrumbs,.et_fb_db_cart_products,.et_fb_db_cart_total,.et_fb_db_checkout_after_cust_details,.et_fb_db_checkout_before_cust_details,.et_fb_db_checkout_before_order_review,.et_fb_db_checkout_billing,.et_fb_db_checkout_coupon,.et_fb_db_checkout_order_review,.et_fb_db_checkout_payment,.et_fb_db_checkout_shipping,.et_fb_db_content,.et_fb_db_crosssell,.et_fb_db_images,.et_fb_db_login_form,.et_fb_db_login_password_confirmation,.et_fb_db_login_password_lost,.et_fb_db_login_password_reset,.et_fb_db_meta,.et_fb_db_notices,.et_fb_db_price,.et_fb_db_pro_before,.et_fb_db_pro_navigation,.et_fb_db_product_carousel,.et_fb_db_product_slider,.et_fb_db_product_summary,.et_fb_db_product_title,.et_fb_db_products_search,.et_fb_db_rating,.et_fb_db_register_form,.et_fb_db_related_products,.et_fb_db_reviews,.et_fb_db_sharing,.et_fb_db_shop_after,.et_fb_db_shop_button,.et_fb_db_shop_cat_loop,.et_fb_db_shop_cat_title,.et_fb_db_shop_loop,.et_fb_db_shop_thumbnail,.et_fb_db_short_desc,.et_fb_db_single_image,.et_fb_db_tabs,.et_fb_db_thankyou_cust_details,.et_fb_db_thankyou_details,.et_fb_db_thankyou_overview,.et_fb_db_thankyou_payment_details,.et_fb_db_upsell,.et_fb_db_woo_add_payment_method,.et_fb_db_woo_addresses,.et_fb_db_woo_avatar,.et_fb_db_woo_downloads,.et_fb_db_woo_edit_account,.et_fb_db_woo_edit_addresses,.et_fb_db_woo_get_name,.et_fb_db_woo_orders,.et_fb_db_woo_payment_methods,.et_fb_db_woo_user_name,.et_fb_db_woo_view_order{display:none!important}
  </style>';
  }

}

// CUSTOM CART ICON IN MENU
add_filter('wp_nav_menu_items', 'do_shortcode');


// Remove view basket link

$ajax_add_to_cart_remove_basket_link = $titan->getOption( 'ajax_add_to_cart_remove_basket_link' );
if ($ajax_add_to_cart_remove_basket_link == "1") {
add_action('wp_head', 'ajax_remove_view_basket');
function ajax_remove_view_basket(){

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

$css_woo_bodyshop =  '<style id="bc_remove_ajax_view_basket">';
$css_woo_bodyshop .= '
a.added_to_cart {display:none !important}
';
$css_woo_bodyshop .= '</style>';
//minify it
$css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
echo $css_woo_bodyshop_min;
}
} else {
  // code...
}

// Remove loading animation on icon when using ajax add to cart

$ajax_add_to_cart_disable_spinning = $titan->getOption( 'ajax_add_to_cart_disable_spinning' );
if ($ajax_add_to_cart_disable_spinning == "1") {
add_action('wp_head', 'ajax_disable_spinning');
function ajax_disable_spinning(){

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

$css_woo_bodyshop =  '<style id="bc_disable_spinning_ajax">';
$css_woo_bodyshop .= '
.add_to_cart_button::after {
-webkit-animation:none !important;
animation:none !important;
}
';
$css_woo_bodyshop .= '</style>';
//minify it
$css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
echo $css_woo_bodyshop_min;
}
} else {
  // code...
}


// Remove view basket link


add_action('wp_footer', 'other_settings_ajax_add_to_cart_disable_products');
function other_settings_ajax_add_to_cart_disable_products(){

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $other_settings_ajax_add_to_cart_disable_products = $titan->getOption( 'other_settings_ajax_add_to_cart_disable_products' );

  if ($other_settings_ajax_add_to_cart_disable_products == "") {
    ?>
    <script>
    jQuery(document).ready(function($){
  $(".single_add_to_cart_button").addClass("ajax_add_to_cart");
    });
    </script>
      <?php
  } else {
?>
<script>
jQuery(document).ready(function($){
  $(".single_add_to_cart_button").addClass("ajax_add_to_cart");
  $(".<?php echo $other_settings_ajax_add_to_cart_disable_products ?> .single_add_to_cart_button").removeClass("ajax_add_to_cart");
});
</script>
  <?php
}
}



// END
    }
  add_action( 'tf_create_options', 'divi_bodycommerce_check_other_options' );


 ?>
