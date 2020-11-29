<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bodycommerce_global_css_head() {
if ( ! is_admin() ) {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

// General

$global_notice_background_color = $titan->getOption( 'global_notice_background_color'); // DONE
$notice_heading_text_size = $titan->getOption( 'notice_heading_text_size'); // DONE
$global_notice_text_color = $titan->getOption( 'global_notice_text_color'); // DONE
$global_notice_background_pad_top = $titan->getOption( 'global_notice_background_pad_top'); // DONE
$global_notice_background_pad_bot = $titan->getOption( 'global_notice_background_pad_bot'); // DONE
$global_notice_background_pad_right = $titan->getOption( 'global_notice_background_pad_right'); // DONE
$global_notice_background_pad_left = $titan->getOption( 'global_notice_background_pad_left'); // DONE

$gloabl_notice_heading_link_text_size = $titan->getOption( 'gloabl_notice_heading_link_text_size'); // DONE
$global_notice_heading_link_text_color = $titan->getOption( 'global_notice_heading_link_text_color'); // DONE


// Varition swatchs
$variation_label_width = $titan->getOption( 'variation_label_width' );
$variation_label_height = $titan->getOption( 'variation_label_height' );
$variation_image_width = $titan->getOption( 'variation_image_width' );
$variation_image_hieght = $titan->getOption( 'variation_image_hieght' );
$variation_color_width = $titan->getOption( 'variation_color_width' );
$variation_color_height = $titan->getOption( 'variation_color_height' );



  // buttons
  $check_checkout_page_use_custom_style_button = $titan->getOption( 'notice_button_use_custom_style_button'); // DONE
  $check_checkout_page_field_button_text_size = $titan->getOption( 'notice_button_text_size'); // DONE
  $check_checkout_page_field_button_text_color = $titan->getOption( 'global_notice_button_text_color'); // DONE
  $check_checkout_page_field_button_background_color = $titan->getOption( 'global_notice_button_background_color'); // DONE
  $check_checkout_page_field_button_border_width = $titan->getOption( 'global_notice_button_border_width'); // DONE
  $check_checkout_page_field_button_border_color = $titan->getOption( 'global_notice_button_border_color'); // DONE
  $check_checkout_page_field_button_border_radius = $titan->getOption( 'global_notice_button_border_radius'); // DONE
  $check_checkout_page_field_button_letter_spacing = $titan->getOption( 'global_notice_button_letter_spacing'); // DONE
  $check_checkout_page_field_add_button_icon = $titan->getOption( 'global_notice_add_button_icon'); // DONE
  $check_checkout_page_field_button_icon = $titan->getOption( 'global_notice_button_icon'); // DONE
  $check_checkout_page_field_button_icon_color = $titan->getOption( 'global_notice_button_icon_color'); // DONE
  $check_checkout_page_field_button_icon_placement = $titan->getOption( 'global_notice_button_icon_placement'); // DONE
  $check_checkout_page_field_button_icon_only_show_hover = $titan->getOption( 'global_notice_button_icon_only_show_hover'); // DONE
  // Buttons hover
  $check_checkout_page_button_hover_text_color = $titan->getOption( 'global_notice_button_hover_text_color'); // DONE
  $check_checkout_page_button_hover_background_color = $titan->getOption( 'global_notice_button_hover_background_color'); // DONE
  $check_checkout_page_button_hover_border_color = $titan->getOption( 'global_notice_button_hover_border_color'); // DONE
  $check_checkout_page_button_hover_border_radius = $titan->getOption( 'global_notice_button_hover_border_radius'); // DONE
  $check_checkout_page_button_hover_letter_spacing = $titan->getOption( 'global_notice_button_hover_letter_spacing'); // DONE



if ($check_checkout_page_use_custom_style_button == "enabled"){

  if ($check_checkout_page_field_button_icon == "") {$check_checkout_page_field_button_icon_display = "35";}else {  $check_checkout_page_field_button_icon_display = $check_checkout_page_field_button_icon;}

  $display_checkout_page_button_default_syle = '
  .woocommerce-message a.button.wc-forward {
  font-size:'.$check_checkout_page_field_button_text_size.'px !important;
  color:'.$check_checkout_page_field_button_text_color.' !important;
  background-color:'.$check_checkout_page_field_button_background_color.' !important;
  border-width: '.$check_checkout_page_field_button_border_width.'px !important;
  border-color: '.$check_checkout_page_field_button_border_color.' !important;
  border-radius: '.$check_checkout_page_field_button_border_radius.'px !important;
  letter-spacing: '.$check_checkout_page_field_button_letter_spacing.'px !important;
  }


  .woocommerce-message a.button.wc-forward:hover {
  color:'.$check_checkout_page_button_hover_text_color.' !important;
  background-color:'.$check_checkout_page_button_hover_background_color.' !important;
  border-color:'.$check_checkout_page_button_hover_border_color.' !important;
  border-radius:'.$check_checkout_page_button_hover_border_radius.'px !important;
  letter-spacing:'.$check_checkout_page_button_hover_letter_spacing.'px !important;
  }
  ';



  if ($check_checkout_page_field_add_button_icon == "yes") {

  // HOVER OR NOT

  if ($check_checkout_page_field_button_icon_only_show_hover == "yes") {

  // RIGHT OR LEFT
    if ($check_checkout_page_field_button_icon_placement == "right") {
      $display_checkout_page_button_icon = sprintf('.woocommerce-message a.button.wc-forward:after {content:"\%s" !important;color:%s; !important}',$check_checkout_page_field_button_icon_display, $check_checkout_page_field_button_icon_color );
      $display_checkout_page_button_icon_placement = sprintf('.woocommerce-message a.button.wc-forward:before{content:none !important;} .bodycommerce-minicart .button.wc-forward:hover {padding-left: 1em !important; padding-right: 2em !important;}' );
    }
    else {
      $display_checkout_page_button_icon = sprintf('.woocommerce-message a.button.wc-forward:before {display:block !important;content:"\%s" !important;color:%s !important;} .bodycommerce-minicart .button.wc-forward:hover:before {opacity: 1 !important;}',$check_checkout_page_field_button_icon_display, $check_checkout_page_field_button_icon_color );
      $display_checkout_page_button_icon_placement = sprintf('.woocommerce-message a.button.wc-forward:after{content:none !important;} .bodycommerce-minicart .button.wc-forward:hover {padding-right: 1em !important; padding-left: 2em !important;}');
    }
  }
  else {
    // RIGHT OR LEFT
      if ($check_checkout_page_field_button_icon_placement == "right") {
        $display_checkout_page_button_icon = sprintf('.woocommerce-message a.button.wc-forward:after {content:"\%s" !important;color:%s;opacity:1 !important;margin-left: 0;}',$check_checkout_page_field_button_icon_display, $check_checkout_page_field_button_icon_color);
        $display_checkout_page_button_icon_placement = sprintf('.woocommerce-message a.button.wc-forward:before {content:none !important;}');
      }
      else {
        $display_checkout_page_button_icon = sprintf('.woocommerce-message a.button.wc-forward:before  {display:block !important;content:"\%s" !important;color:%s;opacity:1;}',$check_checkout_page_field_button_icon_display, $check_checkout_page_field_button_icon_color );
        $display_checkout_page_button_icon_placement = sprintf('.woocommerce-message a.button.wc-forward:after{content:none !important;}');
      }
  }



  }
  elseif ($check_checkout_page_field_add_button_icon == "no") {
  $display_checkout_page_button_icon = '.woocommerce-message a.button.wc-forward:after { content: none !important;}';
  $display_checkout_page_button_icon_placement = '';
  }
  else {
    # code...
  }

  }
  else {
    $display_checkout_page_button_default_syle = '';
    $display_checkout_page_button_icon = '';
    $display_checkout_page_button_icon_placement = '';
  }




if ($gloabl_notice_heading_link_text_size != "0") {
  $gloabl_notice_heading_link_text_size_display = '
    font-size: '.$gloabl_notice_heading_link_text_size.'px !important;
';
} else {$gloabl_notice_heading_link_text_size_display = "";}

if ($global_notice_heading_link_text_color != "") {
  $global_notice_heading_link_text_color_display = '
    color: '.$global_notice_heading_link_text_color.' !important;
';
} else {$global_notice_heading_link_text_color_display = "";}



if ($global_notice_background_color != "") {
  $display_background = '
    background-color: '.$global_notice_background_color.';
';
} else {$display_background = "";}

if ($notice_heading_text_size != "0") {
  $notice_heading_text_size_background_display = '
    font-size: '.$notice_heading_text_size.'px !important;
';
} else {$notice_heading_text_size_background_display = "";}

if ($global_notice_text_color != "") {
  $global_notice_text_color_display = '
    color: '.$global_notice_text_color.' !important;
';
} else {$global_notice_text_color_display = "";}





if ($global_notice_background_pad_top != "0") {
  $global_notice_background_pad_top_display = '
    padding-top: '.$global_notice_background_pad_top.'px !important;
';
} else {$global_notice_background_pad_top_display = "";}

if ($global_notice_background_pad_bot != "0") {
  $global_notice_background_pad_bot_display = '
    padding-bottom: '.$global_notice_background_pad_bot.'px !important;
';
} else {$global_notice_background_pad_bot_display = "";}

if ($global_notice_background_pad_right != "0") {
  $global_notice_background_pad_right_display = '
    padding-right: '.$global_notice_background_pad_right.'px !important;
';
} else {$global_notice_background_pad_right_display = "";}

if ($global_notice_background_pad_left != "0") {
  $global_notice_background_pad_left_display = '
    padding-left: '.$global_notice_background_pad_left.'px !important;
';
} else {$global_notice_background_pad_left_display = "";}

  // BUTTON Styles end



$css_woo_bodyshop =  '<style id="bodycommerce-global">';
$css_woo_bodyshop .= '

.woocommerce .woocommerce-error, .woocommerce .woocommerce-info, .woocommerce .woocommerce-message {
  '.$global_notice_background_pad_top_display.'
  '.$global_notice_background_pad_bot_display.'
  '.$global_notice_background_pad_right_display.'
  '.$global_notice_background_pad_left_display.'
  '.$notice_heading_text_size_background_display.'
  '.$global_notice_text_color_display.'
  '.$display_background.'
}

.woocommerce .woocommerce-error a, .woocommerce .woocommerce-info a, .woocommerce .woocommerce-message a {
  '.$global_notice_heading_link_text_color_display.'
  '.$gloabl_notice_heading_link_text_size_display.'
}

  '.$display_checkout_page_button_default_syle.'
  '.$display_checkout_page_button_icon.'
  '.$display_checkout_page_button_icon_placement.'


  .color-variable-item {
    width: '.$variation_color_width.'px !important;
    height: '.$variation_color_height.'px !important;
  }

.image-variable-item {
      width: '.$variation_image_width.'px !important;
      height: '.$variation_image_hieght.'px !important;
    }

  .button-variable-item {
        width: '.$variation_label_width.'px !important;
        height: '.$variation_label_height.'px !important;
      }






';



$css_woo_bodyshop .= '</style>';
//minify it
$css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
echo $css_woo_bodyshop_min;


}

}

add_action('wp_head','bodycommerce_global_css_head');
 ?>
