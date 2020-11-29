<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
	$check_BodyCommerce_sale_badge_design = $titan->getOption( 'BodyCommerce_sale_badge_design' );
	$check_BodyCommerce_sale_badge_design_new = $titan->getOption( 'BodyCommerce_sale_badge_design_new' );
	$check_BodyCommerce_sale_badge_design_free = $titan->getOption( 'BodyCommerce_sale_badge_design_free' );
	$BodyCommerce_sale_badge_design_ofs = $titan->getOption( 'BodyCommerce_sale_badge_design_ofs' );

$check_other_settings_percentage_sales_before_get = $titan->getOption( 'other_settings_percentage_sales_before' );
$check_other_settings_percentage_sales_after_get = $titan->getOption( 'other_settings_percentage_sales_after' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sale Percentage Before', $check_other_settings_percentage_sales_before_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sale Percentage After', $check_other_settings_percentage_sales_after_get );
$check_other_settings_percentage_sales_before = apply_filters( 'wpml_translate_single_string', $check_other_settings_percentage_sales_before_get, 'divi-bodyshop-woocommerce', 'Sale Percentage Before' );
$check_other_settings_percentage_sales_after = apply_filters( 'wpml_translate_single_string', $check_other_settings_percentage_sales_after_get, 'divi-bodyshop-woocommerce', 'Sale Percentage After' );



$check_other_settings_sale_badge_percentage_sign = $titan->getOption( 'other_settings_sale_badge_percentage_sign' );

$check_BodyCommerce_sale_badge_new_display_time = $titan->getOption( 'BodyCommerce_sale_badge_new_display_time' );

$check_other_settings_new_sale_badge_text_get = $titan->getOption( 'other_settings_new_sale_badge_text' );
$check_other_settings_free_sale_badge_text_get = $titan->getOption( 'other_settings_free_sale_badge_text' );
$other_settings_ofs_sale_badge_text_get = $titan->getOption( 'other_settings_ofs_sale_badge_text' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'New Badge Text', $check_other_settings_new_sale_badge_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Free Badge Text', $check_other_settings_free_sale_badge_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Out Of Stock Badge Text', $other_settings_ofs_sale_badge_text_get );
$check_other_settings_new_sale_badge_text = apply_filters( 'wpml_translate_single_string', $check_other_settings_new_sale_badge_text_get, 'divi-bodyshop-woocommerce', 'New Badge Text' );
$check_other_settings_free_sale_badge_text = apply_filters( 'wpml_translate_single_string', $check_other_settings_free_sale_badge_text_get, 'divi-bodyshop-woocommerce', 'Free Badge Text' );
$other_settings_ofs_sale_badge_text = apply_filters( 'wpml_translate_single_string', $other_settings_ofs_sale_badge_text_get, 'divi-bodyshop-woocommerce', 'Out Of Stock Badge Text' );


$check_other_settings_percentage_sales_enable_new = $titan->getOption( 'other_settings_percentage_sales_enable_new' );
$check_other_settings_percentage_sales_enable_free = $titan->getOption( 'other_settings_percentage_sales_enable_free' );
$other_settings_percentage_sales_enable_ofs = $titan->getOption( 'other_settings_percentage_sales_enable_ofs' );

global $post, $product;
?>
<?php

$product_id = $product->get_id();
$price_amount = $product->get_price();

$pfx_date = get_the_date('Y-m-d');
$someDate = new \DateTime($pfx_date);
$now = new \DateTime();
$date_difference = $someDate->diff($now)->days;

if ( ! $product->is_in_stock() ) {
  if ($other_settings_percentage_sales_enable_ofs == 1) {
  ?>
  <div class="bodycommerce-ofs-badge">

  <?php

  if ($BodyCommerce_sale_badge_design_ofs == "default"){

   echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( $other_settings_ofs_sale_badge_text, 'woocommerce' ) . '</span>', $post, $product );
  }
  else {

    $path = '/lib/sale-badge-styles/'.$BodyCommerce_sale_badge_design_ofs.'.php';
  include(DE_DB_WOO_PATH . $path);
  ?>
  <div class="bodycommerce-ofs-text">
    <?php
    echo $other_settings_ofs_sale_badge_text; ?>
  </div>

  <?php
  }
   ?>

  </div>
  <?php
}
} else if ( $product->is_on_sale() ) {

  ?>

	<?php

  $check_other_settings_percentage_sales_enable = $titan->getOption( 'other_settings_percentage_sales_enable' );

  if ($check_other_settings_percentage_sales_enable == 1) {
 if ($check_BodyCommerce_sale_badge_design == "default"){

	echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
}
else {
// START CUSTOMISATION
// START PERCENTAGE
global $woocommerce, $product, $post;
  if ( ! $product->is_in_stock() ) return;
  $sale_price = $product->get_sale_price();
  $regular_price = $product->get_regular_price();
  $grouped = false;

    if( $product->is_type( 'grouped' ) ){
$grouped = true;
    }

  if ($product->is_type( 'variable' )){ //then this is a variable product

    $available_variations = $product->get_available_variations();
    $variation_id=$available_variations[0]['variation_id'];
    $variation= new WC_Product_Variation( $variation_id );
    $regular_price = $product->get_variation_regular_price();
    $sale_price = $product->get_variation_sale_price();
    // $grouped = true;
  }




  if ($grouped == false ) {
    $difference = $regular_price - $sale_price;
    $division = $difference / $regular_price;
    $savings = round ($division * 100);
  }

  ?>
	<div class="bodycommerce-sale-badge">

<?php

$path = '/lib/sale-badge-styles/'.$check_BodyCommerce_sale_badge_design.'.php';
include(DE_DB_WOO_PATH . $path);

?>

	<div class="bodycommerce-percentage">
    <?php
    if ($check_other_settings_sale_badge_percentage_sign == 1) {
      if ($grouped == true ) {
        $sale_flash = '<span class="bodycommerce-percentage-text">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>';
      }
      else {
    	$sale_flash = '<span class="bodycommerce-percentage-text">'.$check_other_settings_percentage_sales_before.' ' . $savings . '% '.$check_other_settings_percentage_sales_after.'</span>';
          }
    }
  else {
    $sale_flash = '<span class="bodycommerce-percentage-text">'.$check_other_settings_percentage_sales_before.''.$check_other_settings_percentage_sales_after.'</span>';
  }
  	echo $sale_flash; ?>
</div>
</div>

<?php
// END CUSTOMISATION

}

}
else {

  	echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
}



} else if ($price_amount == "0") {
  if ($check_other_settings_percentage_sales_enable_free == 1) {
    ?>
    <div class="bodycommerce-free-badge">

    <?php

    if ($check_BodyCommerce_sale_badge_design_free == "default"){

     echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( $check_other_settings_free_sale_badge_text, 'woocommerce' ) . '</span>', $post, $product );
    }
    else {

    $path = '/lib/sale-badge-styles/'.$check_BodyCommerce_sale_badge_design_free.'.php';
    include(DE_DB_WOO_PATH . $path);

    ?>

    <div class="bodycommerce-free-text">
      <?php
      echo $check_other_settings_free_sale_badge_text; ?>
    </div>

    <?php
    }
     ?>

    </div>
    <?php
  }
}
// NEW
else if($date_difference <= $check_BodyCommerce_sale_badge_new_display_time) {
  if ($check_other_settings_percentage_sales_enable_new == 1) {
  ?>
  <div class="bodycommerce-new-badge">

  <?php

  if ($check_BodyCommerce_sale_badge_design_new == "default"){

   echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( $check_other_settings_new_sale_badge_text, 'woocommerce' ) . '</span>', $post, $product );
  }
  else {

    $path = '/lib/sale-badge-styles/'.$check_BodyCommerce_sale_badge_design_new.'.php';
  include(DE_DB_WOO_PATH . $path);
  ?>
  <div class="bodycommerce-new-text">
    <?php
    echo $check_other_settings_new_sale_badge_text; ?>
  </div>

  <?php
  }
   ?>

  </div>
  <?php
}
}
else {

}

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
