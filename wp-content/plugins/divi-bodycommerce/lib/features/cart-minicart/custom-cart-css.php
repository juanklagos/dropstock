<?php
if ( ! defined( 'ABSPATH' ) ) exit;

  function divi_bodycommerce_custom_cart_css() {
    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

$check_enable_cart_custom_icon = $titan->getOption( 'enable_cart_custom_icon');
$check_cart_custom_icon_color = $titan->getOption( 'cart_custom_icon_color');
$check_cart_custom_icon_icon_postion_left = $titan->getOption( 'cart_custom_icon_icon_postion_left');
$check_cart_custom_icon_icon_postion_top = $titan->getOption( 'cart_custom_icon_icon_postion_top');
$check_cart_custom_icon_number_postion_left = $titan->getOption( 'cart_custom_icon_number_postion_left');
$check_cart_custom_icon_number_postion_top = $titan->getOption( 'cart_custom_icon_number_postion_top');
$check_cart_custom_icon_number_background_color = $titan->getOption( 'cart_custom_icon_number_background_color');
$check_cart_custom_icon_number_background_color_hover = $titan->getOption( 'cart_custom_icon_number_background_color_hover');
$check_cart_custom_icon_number_background_border_radius = $titan->getOption( 'cart_custom_icon_number_background_border_radius');
$check_cart_custom_icon_number_background_width = $titan->getOption( 'cart_custom_icon_number_background_width');
$check_cart_custom_icon_number_background_height = $titan->getOption( 'cart_custom_icon_number_background_height');
$check_cart_custom_icon_number_text_color = $titan->getOption( 'cart_custom_icon_number_text_color');
$check_cart_custom_icon_number_text_font_size = $titan->getOption( 'cart_custom_icon_number_text_font_size');
$check_cart_custom_icon_background_color = $titan->getOption( 'cart_custom_icon_background_color');
$check_cart_custom_icon_background_padding_left = $titan->getOption( 'cart_custom_icon_background_padding_left');
$check_cart_custom_icon_background_padding_right = $titan->getOption( 'cart_custom_icon_background_padding_right');
$check_cart_custom_icon_background_padding_top = $titan->getOption( 'cart_custom_icon_background_padding_top');

$check_cart_custom_icon_background_padding_top_top = $check_cart_custom_icon_background_padding_top + 5;


$check_cart_custom_icon_number_style = $titan->getOption( 'cart_custom_icon_number_style');



if ($check_cart_custom_icon_number_background_width == "0") {
  $check_cart_custom_icon_number_background_width_display = " width: 14px;";
} else {
  $check_cart_custom_icon_number_background_width_display = "width: ".$check_cart_custom_icon_number_background_width."px;";
}

if ($check_cart_custom_icon_number_background_height == "0") {
  $check_cart_custom_icon_number_background_heighth_display = "height: 14px;";
} else {
  $check_cart_custom_icon_number_background_heighth_display = "height: ".$check_cart_custom_icon_number_background_height."px;";
}


if ($check_cart_custom_icon_number_style == "default") {
  $check_cart_custom_icon_number_style_css = '.cart-count  {
    right: '.$check_cart_custom_icon_number_postion_left.'px;
    top: '.$check_cart_custom_icon_number_postion_top.'px;
  }

  .cart-count p {
  color: '.$check_cart_custom_icon_number_text_color.';
  font-size: '.$check_cart_custom_icon_number_text_font_size.'px;
}


  ';
}
else if ($check_cart_custom_icon_number_style == "circle") {
 $check_cart_custom_icon_number_style_css =  '.cart-count  {
 background-color: '.$check_cart_custom_icon_number_background_color.';
 border-radius: '.$check_cart_custom_icon_number_background_border_radius.'px;
 right: '.$check_cart_custom_icon_number_postion_left.'px;
 top: '.$check_cart_custom_icon_number_postion_top.'px;
 '.$check_cart_custom_icon_number_background_width_display.'
 '.$check_cart_custom_icon_number_background_heighth_display.'
 text-align: center;
 -webkit-transition: background-color 0.4s, color 0.4s, transform 0.4s, opacity 0.4s ease-in-out;
 	-moz-transition: background-color 0.4s, color 0.4s, transform 0.4s, opacity 0.4s ease-in-out;
 	transition: background-color 0.4s, color 0.4s, transform 0.4s, opacity 0.4s ease-in-out;
   }

 .cart-count p {
 color: '.$check_cart_custom_icon_number_text_color.';
 font-size: '.$check_cart_custom_icon_number_text_font_size.'px;
 position:absolute;
 top:50%;
 left:50%;
 transform:translate(-50%,-50%);
}


.cart-count:hover {
  background-color:'.$check_cart_custom_icon_number_background_color_hover.';
}

';
}
else {
  # code...
}




if ($check_enable_cart_custom_icon == 1)
{
$css_cart_icon =  sprintf('<style id="bodycommerce-cart-icon">');

$css_cart_icon .= '
.cart-icon svg path {fill : '.$check_cart_custom_icon_color.';}

.cart-icon,
body .column-cart .et_pb_module .cart-icon {
  position:relative;
  top: '.$check_cart_custom_icon_icon_postion_top.'px !important;
  right: '.$check_cart_custom_icon_icon_postion_left.'px !important;
  background-color: '.$check_cart_custom_icon_background_color.';
  padding: '.$check_cart_custom_icon_background_padding_top_top.'px '.$check_cart_custom_icon_background_padding_right.'px '.$check_cart_custom_icon_background_padding_top.'px '.$check_cart_custom_icon_background_padding_left.'px;
  overflow: hidden;
}

.cart-icon svg {
  position:relative;
}

.cart-count {
  position:relative;
  float: left;
}


'.$check_cart_custom_icon_number_style_css.'

';

$css_cart_icon .= '</style>';
//minify it
$css_cart_icon_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_cart_icon );
echo $css_cart_icon_min;
}
else {
  # code...
}
    }
  add_action( 'wp_head', 'divi_bodycommerce_custom_cart_css', 15 );

  ?>
