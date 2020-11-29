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

$check_other_settings_absolute_relative_text = $titan->getOption( 'other_settings_absolute_relative_text' );

if ($check_other_settings_absolute_relative_text == 0){
$css_button = '

<style id="bodycommerce-sale-badge star">
.bodycommerce-sale-badge {position:relative;}

.bodycommerce-sale-badge svg {
  fill: '.$check_BodyCommerce_sale_badge_color_primary.';
  position: absolute;
    z-index: 100;
    '.$check_BodyCommerce_sale_badge_position.': '.$check_BodyCommerce_sale_badge_edge_distance.'px;
    top: '.$check_BodyCommerce_sale_badge_top_distance.'px;
  width: '.$check_BodyCommerce_sale_badge_size.'px;
height: '.$check_BodyCommerce_sale_badge_size.'px;
}

.bodycommerce-sale-badge svg path.primary, .bodycommerce-sale-badge svg polygon.primary {
    fill: '.$check_BodyCommerce_sale_badge_color_primary.' !important;
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
    '.$check_BodyCommerce_sale_badge_position.': '.$check_BodyCommerce_sale_badge_edge_distance.'px;
    top: '.$check_BodyCommerce_sale_badge_top_distance.'px;
  }

  .bodycommerce-sale-badge svg {
    fill: '.$check_BodyCommerce_sale_badge_color_primary.';
    position: absolute;
      z-index: 100;
    width: '.$check_BodyCommerce_sale_badge_size.'px;
  height: '.$check_BodyCommerce_sale_badge_size.'px;
  }

  .bodycommerce-sale-badge svg path.primary, .bodycommerce-sale-badge svg polygon.primary {
  	  fill: '.$check_BodyCommerce_sale_badge_color_primary.' !important;
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
