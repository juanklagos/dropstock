<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function divi_bodyshop_woo_check_minicart() {


  function divi_bodyshop_woo_check_minicart_output_header() {
    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );





$minicart_padding_bottom= $titan->getOption( 'minicart_padding_bottom');
$check_enable_minicart = $titan->getOption( 'enable_minicart');
$mini_cart_style = $titan->getOption( 'mini_cart_style');

$check_minicart_width = $titan->getOption( 'minicart_width');
$check_minicart_horizontal_distance = $titan->getOption( 'minicart_horizontal_distance');
$check_minicart_vertical_distance = $titan->getOption( 'minicart_vertical_distance');
$atc_pupup_disable_mobile = $titan->getOption( 'atc_pupup_disable_mobile');


// // GET OPTIONS
//
// if ($atc_pupup_disable_mobile == "1") {
//   $atc_pupup_disable_mobile_dis = "@media only screen and (max-width: 767px) {
//     body #page-container .bodycommerce-minicart, body .CartClick {display: none !important;}
//   }";
// }
// else {
//   $atc_pupup_disable_mobile_dis = "";
// }

// background
$check_mini_cart_background = $titan->getOption( 'mini_cart_background');
$mini_cart_generic_text_color = $titan->getOption( 'mini_cart_generic_text_color');
$check_mini_cart_remove_shadow = $titan->getOption( 'mini_cart_remove_shadow');
// Subtotal
$check_mini_cart_subtotal_text_size = $titan->getOption( 'mini_cart_subtotal_text_size');
$check_mini_cart_subtotal_text_colour = $titan->getOption( 'mini_cart_subtotal_text_color');
// Product
$check_mini_cart_product_title_text_size = $titan->getOption( 'mini_cart_product_title_text_size');
$check_mini_cart_product_title_text_colour = $titan->getOption( 'mini_cart_product_title_text_color');
$check_mini_cart_product_image_size = $titan->getOption( 'mini_cart_product_image_size');

// Quntity & Price
$check_mini_cart_product_quantity_price_text_size = $titan->getOption( 'mini_cart_product_quantity_price_text_size');
$check_mini_cart_product_quantity_price_text_colour = $titan->getOption( 'mini_cart_product_quantity_price_text_color');
// Remove
$check_mini_cart_remove_text_size = $titan->getOption( 'mini_cart_remove_text_size'); // text size
$check_mini_cart_remove_text_colour = $titan->getOption( 'mini_cart_remove_text_color'); // color
$mini_cart_remove_icon_color = $titan->getOption( 'mini_cart_remove_icon_color'); // background color
$mini_cart_remove_icon_color_hover = $titan->getOption( 'mini_cart_remove_icon_color_hover'); // color on hover
$mini_cart_remove_icon_bg_color_hover = $titan->getOption( 'mini_cart_remove_icon_bg_color_hover'); // bg on hover


$mini_cart_button_display_type = $titan->getOption( 'mini_cart_button_display_type');

// buttons
$check_mini_cart_use_custom_style_button = $titan->getOption( 'mini_cart_use_custom_style_button');
$check_mini_cart_field_button_text_size = $titan->getOption( 'mini_cart_field_button_text_size');
$check_mini_cart_field_button_text_color = $titan->getOption( 'mini_cart_field_button_text_color');
$check_mini_cart_field_button_background_color = $titan->getOption( 'mini_cart_field_button_background_color');
$check_mini_cart_field_button_border_width = $titan->getOption( 'mini_cart_field_button_border_width');
$check_mini_cart_field_button_border_color = $titan->getOption( 'mini_cart_field_button_border_color');
$check_mini_cart_field_button_border_radius = $titan->getOption( 'mini_cart_field_button_border_radius');
$check_mini_cart_field_button_letter_spacing = $titan->getOption( 'mini_cart_field_button_letter_spacing');
$check_mini_cart_field_add_button_icon = $titan->getOption( 'mini_cart_field_add_button_icon');
$check_mini_cart_field_button_icon = $titan->getOption( 'mini_cart_field_button_icon');
$check_mini_cart_field_button_icon_color = $titan->getOption( 'mini_cart_field_button_icon_color');
$check_mini_cart_field_button_icon_placement = $titan->getOption( 'mini_cart_field_button_icon_placement');
$check_mini_cart_field_button_icon_only_show_hover = $titan->getOption( 'mini_cart_field_button_icon_only_show_hover');
// Buttons hover
$check_mini_cart_button_hover_text_color = $titan->getOption( 'mini_cart_button_hover_text_color');
$check_mini_cart_button_hover_background_color = $titan->getOption( 'mini_cart_button_hover_background_color');
$check_mini_cart_button_hover_border_color = $titan->getOption( 'mini_cart_button_hover_border_color');
$check_mini_cart_button_hover_border_radius = $titan->getOption( 'mini_cart_button_hover_border_radius');
$check_mini_cart_button_hover_letter_spacing = $titan->getOption( 'mini_cart_button_hover_letter_spacing');

$minicart_remove_basket_button = $titan->getOption( 'minicart_remove_basket_button');


$removefromright = $check_mini_cart_product_image_size + 10;

// GET OPTIONS END


if ($mini_cart_button_display_type == 1) {
  $mini_cart_button_display_type_dis = '';
} else {
  $mini_cart_button_display_type_dis = '
  body .bodycommerce-minicart .dropdown-minicart .woocommerce-mini-cart__buttons .wc-forward {
    display: inline-block !important;
    margin-right: 10px;
  }
  body .bodycommerce-minicart .dropdown-minicart .woocommerce-mini-cart__buttons .wc-forward.checkout {
    margin-right: 0px;
    float: right;
  }
  ';
}


if ($check_enable_minicart == 1) {

// BUTONS Styles

if ($check_mini_cart_field_button_icon == "") {$check_mini_cart_field_button_icon_display = "35";}else {  $check_mini_cart_field_button_icon_display = $check_mini_cart_field_button_icon;}
/*
if ($check_mini_cart_use_border == "yes") {
  $display_protect_border = 'border:'.$check_mini_cart_input_border_width.'px '.$check_mini_cart_input_border_style.' '.$check_mini_cart_border_color.' !important;';
}
else {
  $display_protect_border = '';
}
*/
if ($check_mini_cart_use_custom_style_button == "yes") {

$display_mini_cart_button_default_syle = '
.bodycommerce-minicart .button.wc-forward, .bc-added-modal-container .bc-added-buttons .button {
font-size:'.$check_mini_cart_field_button_text_size.'px !important;
color:'.$check_mini_cart_field_button_text_color.' !important;
background-color:'.$check_mini_cart_field_button_background_color.' !important;
border-width: '.$check_mini_cart_field_button_border_width.'px !important;
border-color: '.$check_mini_cart_field_button_border_color.' !important;
border-radius: '.$check_mini_cart_field_button_border_radius.'px !important;
letter-spacing: '.$check_mini_cart_field_button_letter_spacing.'px !important;
}


.bodycommerce-minicart .button.wc-forward:hover, .bc-added-modal-container .bc-added-buttons .button:hover {
color:'.$check_mini_cart_button_hover_text_color.' !important;
background-color:'.$check_mini_cart_button_hover_background_color.' !important;
border-color:'.$check_mini_cart_button_hover_border_color.' !important;
border-radius:'.$check_mini_cart_button_hover_border_radius.'px !important;
letter-spacing:'.$check_mini_cart_button_hover_letter_spacing.'px !important;
}
';



if ($check_mini_cart_field_add_button_icon == "yes") {

// HOVER OR NOT

if ($check_mini_cart_field_button_icon_only_show_hover == "yes") {

// RIGHT OR LEFT
  if ($check_mini_cart_field_button_icon_placement == "right") {
    $display_mini_cart_button_icon = sprintf('.bodycommerce-minicart a.button.wc-forward:after, .bc-added-modal-container .bc-added-buttons .button:after {content:"\%s" !important;color:%s; !important}',$check_mini_cart_field_button_icon_display, $check_mini_cart_field_button_icon_color );
    $display_mini_cart_button_icon_placement = sprintf('.bodycommerce-minicart a.button.wc-forward:before, .bc-added-modal-container .bc-added-buttons .button:before{content:none !important;} .bodycommerce-minicart .button.wc-forward:hover, .bc-added-modal-container .bc-added-buttons .button:hover {padding-left: 1em !important; padding-right: 2em !important;}' );
  }
  else {
    $display_mini_cart_button_icon = sprintf('.bodycommerce-minicart a.button.wc-forward:before, .bc-added-modal-container .bc-added-buttons .button:before {display:block !important;content:"\%s" !important;color:%s !important;} .bodycommerce-minicart .button.wc-forward:hover:before, .bc-added-modal-container .bc-added-buttons .button:hover:before {opacity: 1 !important;}',$check_mini_cart_field_button_icon_display, $check_mini_cart_field_button_icon_color );
    $display_mini_cart_button_icon_placement = sprintf('.bodycommerce-minicart a.button.wc-forward:after, .bc-added-modal-container .bc-added-buttons .button:after{content:none !important;} .bodycommerce-minicart .button.wc-forward:hover, .bc-added-modal-container .bc-added-buttons .button:hover {padding-right: 1em !important; padding-left: 2em !important;}');
  }
}
else {
  // RIGHT OR LEFT
    if ($check_mini_cart_field_button_icon_placement == "right") {
      $display_mini_cart_button_icon = sprintf('.bodycommerce-minicart a.button.wc-forward:after, .bc-added-modal-container .bc-added-buttons .button:after {content:"\%s" !important;color:%s;opacity:1 !important;margin-left: 0;}.bodycommerce-minicart .button.wc-forward, .bc-added-modal-container .bc-added-buttons .button {padding-left: 1em !important; padding-right: 2em !important;}',$check_mini_cart_field_button_icon_display, $check_mini_cart_field_button_icon_color);
      $display_mini_cart_button_icon_placement = sprintf('.bodycommerce-minicart a.button.wc-forward:before, .bc-added-modal-container .bc-added-buttons .button:before{content:none !important;}');
    }
    else {
      $display_mini_cart_button_icon = sprintf('.bodycommerce-minicart a.button.wc-forward:before, .bc-added-modal-container .bc-added-buttons .button:before {display:block !important;content:"\%s" !important;color:%s;opacity:1;}.bodycommerce-minicart .button.wc-forward, .bc-added-modal-container .bc-added-buttons .button {padding-right: 1em !important; padding-left: 2em !important;}',$check_mini_cart_field_button_icon_display, $check_mini_cart_field_button_icon_color );
      $display_mini_cart_button_icon_placement = sprintf('.bodycommerce-minicart a.button.wc-forward:after, .bc-added-modal-container .bc-added-buttons .button:after{content:none !important;}');
    }
}



}
elseif ($check_mini_cart_field_add_button_icon == "no") {
$display_mini_cart_button_icon = '.bodycommerce-minicart a.button.wc-forward:before, .bodycommerce-minicart a.button.wc-forward:after, .bc-added-modal-container .bc-added-buttons .button:before, .bc-added-modal-container .bc-added-buttons .button:after { content: none !important;}
.bodycommerce-minicart .button.wc-forward, .bc-added-modal-container .bc-added-buttons .button {padding: 0.3em 1em !important;}  ';
$display_mini_cart_button_icon_placement = '';
}
else {
  # code...
}

}
else {
  $display_mini_cart_button_default_syle = '';
  $display_mini_cart_button_icon = '';
  $display_mini_cart_button_icon_placement = '';
}

if ($check_mini_cart_remove_shadow == "yes") {
  $check_mini_cart_remove_shadow_display = "box-shadow:none !important;";
}
else {
  $check_mini_cart_remove_shadow_display = "-webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);";
}

if ($minicart_remove_basket_button == "enabled") {
  $disable_basket_button = "
  .bodycommerce-minicart .woocommerce-mini-cart__buttons .button {
    display: none !important;
  }
  .bodycommerce-minicart .woocommerce-mini-cart__buttons .button.checkout {
    display: block !important;
    width: 100%;
text-align: center;
  }

  ";
}
else {
  $disable_basket_button = "";
}


$mini_cart_slide_overlay_color = $titan->getOption( 'mini_cart_slide_overlay_color');
$mini_cart_slide_close_icon = $titan->getOption( 'mini_cart_slide_close_icon');
$mini_cart_slide_close_icon_color = $titan->getOption( 'mini_cart_slide_close_icon_color');
$mini_cart_slide_close_icon_right = $titan->getOption( 'mini_cart_slide_close_icon_right');
$mini_cart_slide_close_icon_top = $titan->getOption( 'mini_cart_slide_close_icon_top'); //
$mini_cart_slide_header_text_size = $titan->getOption( 'mini_cart_slide_header_text_size');
$mini_cart_slide_header_text_color = $titan->getOption( 'mini_cart_slide_header_text_color');
$mini_cart_slide_divider_height = $titan->getOption( 'mini_cart_slide_divider_height');
$mini_cart_slide_divider_color = $titan->getOption( 'mini_cart_slide_divider_color');
$mini_cart_slide_bottom_font_size = $titan->getOption( 'mini_cart_slide_bottom_font_size');
$mini_cart_slide_bottom_line_height = $titan->getOption( 'mini_cart_slide_bottom_line_height');
$mini_cart_slide_bottom_font_color = $titan->getOption( 'mini_cart_slide_bottom_font_color');
$mini_cart_slide_total_font_size = $titan->getOption( 'mini_cart_slide_total_font_size');
$mini_cart_slide_total_font_color = $titan->getOption( 'mini_cart_slide_total_font_color');
$mini_cart_slide_bottom_remove_font_color = $titan->getOption( 'mini_cart_slide_bottom_remove_font_color');
$mini_cart_slide_close_icon_font_size = $titan->getOption( 'mini_cart_slide_close_icon_font_size');
$mini_cart_popup_overlay_color = $titan->getOption( 'mini_cart_popup_overlay_color' );
  $mini_cart_slide_close_icon_dis = sprintf('content: "\%s";', $mini_cart_slide_close_icon);

if ($mini_cart_style == "slide-in") {


  $mini_cart_style_dis = '
  

  .bodycommerce-minicart header {
      width: 100%;
      height: 55px
  }

  .bc-minicart-slide-bottom span  {
    font-size: '.$mini_cart_slide_bottom_font_size.'px  !important;
    color: '.$mini_cart_slide_bottom_font_color.'  !important;
    line-height: '.$mini_cart_slide_bottom_line_height.'em;
    }

    .bc-minicart-slide-bottom .total span  {
      font-size: '.$mini_cart_slide_total_font_size.'px  !important;
      color: '.$mini_cart_slide_total_font_color.'  !important;
      }

    .bc-minicart-slide-bottom .woocommerce-remove-coupon {
    color: '.$mini_cart_slide_bottom_remove_font_color.'  !important;
    }

  .bodycommerce-minicart header .slidein-header-text {
    font-size: '.$mini_cart_slide_header_text_size.'px  !important;
    color: '.$mini_cart_slide_header_text_color.'  !important;
  }

  .bodycommerce-minicart .close {
    position: absolute !important;
    top: '.$mini_cart_slide_close_icon_top.'px;
    right: '.$mini_cart_slide_close_icon_right.'px;
    z-index: 10;
    width: 43px;
    height: 43px;
    cursor: pointer;
  }

  .bodycommerce-minicart .close:after {
    text-shadow: 0 0;
    font-family: "ETmodules" !important;
    font-weight: normal;
    font-style: normal;
    font-variant: normal;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    line-height: 1;
    text-transform: none;
    speak: none;
    '.$mini_cart_slide_close_icon_dis.'
    position: absolute;
    left: 0;
    top: 0;
    font-size: '.$mini_cart_slide_close_icon_font_size.'px  !important;
    color: '.$mini_cart_slide_close_icon_color.'  !important;
  }

  body .bodycommerce-minicart {
    max-width: 474px;
  position: fixed;
  top: 0;
  right: -100%;
  width: 100%;
  height: 100vh;
  z-index: 9999999999999999999999999999999;
  background-color: #fff;
  transition: right .75s cubic-bezier(.5,0,.5,1);
  overflow: hidden;
      max-height: 100%;
      display: block;
  }

  body .bodycommerce-minicart .woocommerce-mini-cart.cart_list {
    max-height: 70vh;
    overflow-y: auto;
  }

  @media (max-height: 990px) {
    body .bodycommerce-minicart .woocommerce-mini-cart.cart_list {
      max-height: 60vh;
    }
  }

  @media (max-height: 750px) {
    body .bodycommerce-minicart .woocommerce-mini-cart.cart_list {
      max-height: 50vh;
    }
  }

  #main-header {
        z-index: 9999999;
  }

  body .bodycommerce-minicart .bodycommerce-minicart-container {
    height: 100%;
  }

  body .bodycommerce-minicart.active, body .bodycommerce-minicart.active-always {
    opacity: 1;
          right: 0;
  }
  .bc-minicart-slide-bottom  {
    position: absolute;
    bottom: 0;
    width: 100%;
    left: 0;
    right: 0;
    padding: 24px;
    z-index: 999;
    background-color: '.$check_mini_cart_background.'  !important;
    }

     body .et_pb_fullwidth_menu .nav li ul.woocommerce-mini-cart,
     body.woocommerce #page-container #et-boc .bodycommerce-minicart .woocommerce-mini-cart.cart_list {
       background-color: '.$check_mini_cart_background.'  !important;
       }

    .bodycommerce-minicart .costs>div {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }
    .bodycommerce-minicart .costs span {
        font-weight: 400
    }
    .bodycommerce-minicart .costs .total {
        border-top: '.$mini_cart_slide_divider_height.'px solid '.$mini_cart_slide_divider_color.';
        margin-top: 10px;
        padding: 10px 0 0;
    }
    .bodycommerce-minicart .costs .total span {
        font-weight: 500;
        color: #004c45
    }
    .bodycommerce-minicart .costs {
        margin-bottom: 15px
    }

  .bodycommerce-minicart .woocommerce-mini-cart-item  {
    padding: 0 0 15px 80px;
    margin-bottom: 15px;
position: relative;
    border-bottom: '.$mini_cart_slide_divider_height.'px solid '.$mini_cart_slide_divider_color.';
    }

    .woocommerce .bodycommerce-minicart-container ul.cart_list li dl,
    .woocommerce .bc-added-modal-container ul.cart_list li dl {
        margin: 0;
        padding-left: 0;
        border-left: none;
        padding-top: 5px;

    }

    .woocommerce .bodycommerce-minicart-container ul.cart_list li dl dd,
    .woocommerce .bc-added-modal-container ul.cart_list li dl dd {
      margin-bottom: 0;
    }

    .slidein-header-text {
        font-size: 22px;
        text-align: center;
        font-weight: 400;
        text-transform: uppercase;
        text-align: center;
        margin: 4px 0;
        font-weight: 500
    }



.CartClick {
  position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
z-index: 99999999;
background-color: '.$mini_cart_slide_overlay_color.'  !important;
    display: none;
}

.CartClick.active-always {
  display:block;
  opacity:0;
  -webkit-animation: fadein 1.5s forwards; /* Safari, Chrome and Opera > 12.1 */
     -moz-animation: fadein 1.5s forwards; /* Firefox < 16 */
      -ms-animation: fadein 1.5s forwards; /* Internet Explorer */
       -o-animation: fadein 1.5s forwards; /* Opera < 12.1 */
          animation: fadein 1.5s forwards;
}

@keyframes fadein {
    from { opacity: 0; }
    to   { opacity: 1; }
}

/* Firefox < 16 */
@-moz-keyframes fadein {
    from { opacity: 0; }
    to   { opacity: 1; }
}

/* Safari, Chrome and Opera > 12.1 */
@-webkit-keyframes fadein {
    from { opacity: 0; }
    to   { opacity: 1; }
}

/* Internet Explorer */
@-ms-keyframes fadein {
    from { opacity: 0; }
    to   { opacity: 1; }
}

/* Opera < 12.1 */
@-o-keyframes fadein {
    from { opacity: 0; }
    to   { opacity: 1; }
}

@media (max-width: 881px) {
  .bodycommerce-minicart {
    left: auto !important;
  }
}

@media only screen and (max-width: 767px) {
  body .bodycommerce-minicart {
   display: block !important;
}
}

  ';
} else {
  $mini_cart_style_dis = '

  @media all and (max-width: 980px) {
  .bodycommerce-minicart .close {
    position: absolute !important;
    top: '.$mini_cart_slide_close_icon_top.'px;
    right: '.$mini_cart_slide_close_icon_right.'px;
    z-index: 10;
    width: 43px;
    height: 43px;
    cursor: pointer;
  }

  .bodycommerce-minicart .close::after {
    text-shadow: 0 0;
    font-family: "ETmodules" !important;
    font-weight: normal;
    font-style: normal;
    font-variant: normal;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    line-height: 1;
    text-transform: none;
    speak: none;
    '.$mini_cart_slide_close_icon_dis.'
    position: absolute;
    left: 0;
    top: 0;
    font-size: '.$mini_cart_slide_close_icon_font_size.'px  !important;
    color: '.$mini_cart_slide_close_icon_color.'  !important;
  }
}
  ';
}

// BUTTON Styles end

$css_minicart =  sprintf('<style id="bodyshop-woo-minicart">');

$css_minicart .= '

.woocommerce ul.cart_list li, .woocommerce ul.product_list_widget li {
    display: block !important;
    padding-right: 0 !important;
    font-size: inherit !important;
}


'.$mini_cart_style_dis.'
'.$disable_basket_button.'

.mini_cart_item, .woocommerce-mini-cart__empty-message,.et_slide_menu_top .bodycommerce-minicart-container,
.dropdown-minicart .woocommerce-mini-cart__total.total {
color: '.$mini_cart_generic_text_color.'  !important;
}

.bodycommerce-minicart {
    position: absolute;
    right: '.$check_minicart_horizontal_distance.'px;
    display: none;
    top: '.$check_minicart_vertical_distance.'px;
    z-index: 99999999999999999999;
    width: '.$check_minicart_width.'px;
    max-height:80vh;
    overflow-Y: auto;
}

.minicart-active .bodycommerce_main_content::before {
  content: "";
  display: block;
  position: fixed;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  background-color: '.$mini_cart_popup_overlay_color.'  !important;
  z-index: 10;
}

.minicart-active .et-l--header .et_pb_section.section_with_cart {
z-index: 11;
}

.bodycommerce-minicart ul.woocommerce-mini-cart {
  visibility: visible;
    opacity: 1;
}

.woocommerce ul.cart_list li img, .woocommerce ul.product_list_widget li img {width: '.$check_mini_cart_product_image_size.'px;}
.woocommerce ul.cart_list li, .woocommerce ul.product_list_widget li {
    position: relative;
}
.bodycommerce-minicart .button.checkout.wc-forward {float:none;}

.et-cart-info {position: relative;}
span.shop-cart {position:relative;}

.bodycommerce-minicart a.button.wc-forward:after, 
.bodycommerce-minicart a.button.wc-forward:before {
  display: inline-block;
}

.et_button_no_icon .bodycommerce-minicart a.button.wc-forward:after, 
.et_button_no_icon .bodycommerce-minicart a.button.wc-forward:before {
  display: none;
}

.bodycommerce-minicart.active {
    display: block;
}

.bodycommerce-minicart-container {
    background-color: #fff !important;
    padding: 24px;
    border-radius: 0 0 2px 2px;
}

.bodycommerce-minicart {
-webkit-box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
}

.bodycommerce-minicart.active-always {
    display: block !important;
}
'.$display_mini_cart_button_default_syle.'
'.$display_mini_cart_button_icon.'
'.$display_mini_cart_button_icon_placement.'



'.$mini_cart_button_display_type_dis.'

.bodycommerce-minicart-container {
  background-color:'.$check_mini_cart_background.' !important; 
  '.$check_mini_cart_remove_shadow_display.'
}

.bodycommerce-minicart .woocommerce-mini-cart__total.total, .woocommerce-mini-cart__total.total {
  font-size:'.$check_mini_cart_subtotal_text_size.'px !important; 
  color:'.$check_mini_cart_subtotal_text_colour.' !important;
}

.woocommerce-mini-cart-item.mini_cart_item a, .bodycommerce-minicart .woocommerce-mini-cart.cart_list li a {
  font-size:'.$check_mini_cart_product_title_text_size.'px !important; 
  color:'.$check_mini_cart_product_title_text_colour.' !important;
}


.woocommerce-mini-cart-item.mini_cart_item a.remove-mini-cart , 
.bodycommerce-minicart .woocommerce-mini-cart.cart_list li a.remove-mini-cart {
   position: absolute; 
   font-size:'.$check_mini_cart_remove_text_size.'px !important; 
   color:'.$check_mini_cart_remove_text_colour.' !important;
   background-color: '.$mini_cart_remove_icon_color.'!important;
  }


  .woocommerce-mini-cart-item.mini_cart_item a.remove-mini-cart:hover , 
.bodycommerce-minicart .woocommerce-mini-cart.cart_list li a.remove-mini-cart:hover {
  color:'.$mini_cart_remove_icon_color_hover.' !important;
  background-color: '.$mini_cart_remove_icon_bg_color_hover.'!important;
}

.woocommerce-mini-cart-item.mini_cart_item .quantity {font-size:'.$check_mini_cart_product_quantity_price_text_size.'px !important; color:'.$check_mini_cart_product_quantity_price_text_colour.' !important;}







@media all and (max-width: 881px) {
  .bodycommerce-minicart {
  position: fixed;
  top: 0;
  width: 100vw;
  left: 0;
}
#main-header {
      z-index: 999999;
}

}

';



$css_minicart .= '</style>';
//minify it
$css_minicart_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_minicart );
echo $css_minicart_min;


}
else {
}
  }
add_action( 'wp_head', 'divi_bodyshop_woo_check_minicart_output_header', 15 );



}
add_action( 'tf_create_options', 'divi_bodyshop_woo_check_minicart' );
