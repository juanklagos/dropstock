<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$check_BodyCommerce_sale_badge_color_primary = $titan->getOption( 'BodyCommerce_sale_badge_color_primary' );
$check_BodyCommerce_sale_badge_color_secondary = $titan->getOption( 'BodyCommerce_sale_badge_color_secondary' );
$check_BodyCommerce_sale_badge_edge_distance = $titan->getOption( 'BodyCommerce_sale_badge_edge_distance' );
$check_BodyCommerce_sale_badge_top_distance = $titan->getOption( 'BodyCommerce_sale_badge_top_distance' );
$check_BodyCommerce_sale_badge_position = $titan->getOption( 'BodyCommerce_sale_badge_position' );
$check_BodyCommerce_sale_badge_size = $titan->getOption( 'BodyCommerce_sale_badge_size' );
$check_BodyCommerce_sale_badge_text_color = $titan->getOption( 'BodyCommerce_sale_badge_text_color' );
$check_BodyCommerce_sale_badge_text_size = $titan->getOption( 'BodyCommerce_sale_badge_text_size' );
$check_BodyCommerce_sale_badge_text_position = $titan->getOption( 'BodyCommerce_sale_badge_text_position' );
$check_BodyCommerce_sale_badge_text_line_height = $titan->getOption( 'BodyCommerce_sale_badge_text_line_height' );
$check_BodyCommerce_sale_badge_edge_distance_text = $titan->getOption( 'BodyCommerce_sale_badge_edge_distance_text' );
$check_BodyCommerce_sale_badge_top_distance_text = $titan->getOption( 'BodyCommerce_sale_badge_top_distance_text' );

if ($check_BodyCommerce_sale_badge_color_primary == "rgba(255,255,255,0)") {
  $check_BodyCommerce_sale_badge_color_primary_display = "";
}
else {
  $check_BodyCommerce_sale_badge_color_primary_display = 'background-color: '.$check_BodyCommerce_sale_badge_color_primary.' !important;';
}

if ($check_BodyCommerce_sale_badge_position == "right"){
  $check_BodyCommerce_sale_badge_position_display = "left: auto !important;";
}
else {
  $check_BodyCommerce_sale_badge_position_display = "right: auto !important;";
}

$check_other_settings_absolute_relative_text = $titan->getOption( 'other_settings_absolute_relative_text' );


if ($check_other_settings_absolute_relative_text == 0){
$css_button = '

<style id="bodycommerce-sale-badge-default">
.bodycommerce-sale-badge {position:relative;}

.woocommerce span.onsale, .woocommerce-page span.onsale {
    '.$check_BodyCommerce_sale_badge_color_primary_display.'
    '.$check_BodyCommerce_sale_badge_position.': '.$check_BodyCommerce_sale_badge_edge_distance.'px !important;
    top: '.$check_BodyCommerce_sale_badge_top_distance.'px !important;
font-size: '.$check_BodyCommerce_sale_badge_text_size.'px;
color: '.$check_BodyCommerce_sale_badge_text_color.';
'.$check_BodyCommerce_sale_badge_position_display.'
}

.bodycommerce-sale-badge svg polygon, .bodycommerce-sale-badge svg circle {
    fill: '.$check_BodyCommerce_sale_badge_color_secondary.' !important;}

.bodycommerce-percentage {
  position: absolute;
    z-index: 101;
    '.$check_BodyCommerce_sale_badge_position.': '.$check_BodyCommerce_sale_badge_edge_distance_text.'px;
    top: '.$check_BodyCommerce_sale_badge_top_distance_text.'px;
    width: '.$check_BodyCommerce_sale_badge_size.'px;
    font-size: '.$check_BodyCommerce_sale_badge_text_size.'px;
    color: '.$check_BodyCommerce_sale_badge_text_color.';
    line-height: '.$check_BodyCommerce_sale_badge_text_line_height.'px;
    text-align: '.$check_BodyCommerce_sale_badge_text_position.';
  }

    </style>';
}
else {
  $css_button = '

  <style id="bodycommerce-sale-badge star">
  .bodycommerce-sale-badge {position:absolute;
    '.$check_BodyCommerce_sale_badge_position.': '.$check_BodyCommerce_sale_badge_edge_distance.'px !important;
    top: '.$check_BodyCommerce_sale_badge_top_distance.'px !important;}

.woocommerce span.onsale, .woocommerce-page span.onsale {
      '.$check_BodyCommerce_sale_badge_color_primary_display.'

  font-size: '.$check_BodyCommerce_sale_badge_text_size.'px;
  color: '.$check_BodyCommerce_sale_badge_text_color.';
  '.$check_BodyCommerce_sale_badge_position_display.'
  }

  .bodycommerce-sale-badge svg polygon, .bodycommerce-sale-badge svg circle {
      fill: '.$check_BodyCommerce_sale_badge_color_secondary.' !important;}

  .bodycommerce-percentage {
    position: relative;
      z-index: 101;
      '.$check_BodyCommerce_sale_badge_position.': '.$check_BodyCommerce_sale_badge_edge_distance_text.'px;
      top: '.$check_BodyCommerce_sale_badge_top_distance_text.'px;
      width: '.$check_BodyCommerce_sale_badge_size.'px;
      font-size: '.$check_BodyCommerce_sale_badge_text_size.'px;
      color: '.$check_BodyCommerce_sale_badge_text_color.';
      line-height: '.$check_BodyCommerce_sale_badge_text_line_height.'px;
      text-align: '.$check_BodyCommerce_sale_badge_text_position.';
    }

      </style>';
}



?>
