<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// NEW BADGE

$check_BodyCommerce_sale_badge_color_primary_free = $titan->getOption( 'BodyCommerce_sale_badge_color_primary_free' );
$check_BodyCommerce_sale_badge_color_secondary_free = $titan->getOption( 'BodyCommerce_sale_badge_color_secondary_free' );
$check_BodyCommerce_sale_badge_color_quaternary_free = $titan->getOption( 'BodyCommerce_sale_badge_color_quaternary_free' );
$check_BodyCommerce_sale_badge_edge_distance_free = $titan->getOption( 'BodyCommerce_sale_badge_edge_distance_free' );
$check_BodyCommerce_sale_badge_top_distance_free = $titan->getOption( 'BodyCommerce_sale_badge_top_distance_free' );
$check_BodyCommerce_sale_badge_position_free = $titan->getOption( 'BodyCommerce_sale_badge_position_free' );
$check_BodyCommerce_sale_badge_size_free = $titan->getOption( 'BodyCommerce_sale_badge_size_free' );
$check_BodyCommerce_sale_badge_text_color_free = $titan->getOption( 'BodyCommerce_sale_badge_text_color_free' );
$check_BodyCommerce_sale_badge_text_size_free = $titan->getOption( 'BodyCommerce_sale_badge_text_size_free' );
$check_BodyCommerce_sale_badge_text_position_free = $titan->getOption( 'BodyCommerce_sale_badge_text_position_free' );
$check_BodyCommerce_sale_badge_text_line_height_free = $titan->getOption( 'BodyCommerce_sale_badge_text_line_height_free' );
$check_BodyCommerce_sale_badge_edge_distance_text_free = $titan->getOption( 'BodyCommerce_sale_badge_edge_distance_text_free' );
$check_BodyCommerce_sale_badge_top_distance_text_free = $titan->getOption( 'BodyCommerce_sale_badge_top_distance_text_free' );

$check_other_settings_absolute_relative_text_free = $titan->getOption( 'other_settings_absolute_relative_text_free' );

if ($check_other_settings_absolute_relative_text_free == 0){
$css_button = '

<style id="bodycommerce-free-badge star">

.bodycommerce-free-badge {position:relative;}
.bodycommerce-free-badge svg {
  fill: '.$check_BodyCommerce_sale_badge_color_secondary_free.';
  position: absolute;
    z-index: 100;
    '.$check_BodyCommerce_sale_badge_position_free.': '.$check_BodyCommerce_sale_badge_edge_distance_free.'px;
    top: '.$check_BodyCommerce_sale_badge_top_distance_free.'px;
  width: '.$check_BodyCommerce_sale_badge_size_free.'px;
height: '.$check_BodyCommerce_sale_badge_size_free.'px;
}

.bodycommerce-free-badge svg .primary {
	  fill: '.$check_BodyCommerce_sale_badge_color_primary_free.' !important;
}
.bodycommerce-free-badge svg .quaternary {
	  fill: '.$check_BodyCommerce_sale_badge_color_quaternary_free.' !important;
}

.bodycommerce-free-text {
  position: absolute;
    z-index: 101;
    '.$check_BodyCommerce_sale_badge_position_free.': '.$check_BodyCommerce_sale_badge_edge_distance_text_free.'px;
    top: '.$check_BodyCommerce_sale_badge_top_distance_text_free.'px;
    width: '.$check_BodyCommerce_sale_badge_size_free.'px;
    font-size: '.$check_BodyCommerce_sale_badge_text_size_free.'px;
    color: '.$check_BodyCommerce_sale_badge_text_color_free.';
    line-height: '.$check_BodyCommerce_sale_badge_text_line_height_free.'px;
		text-align: '.$check_BodyCommerce_sale_badge_text_position_free.';
	}

		</style>';
  }
  else {
    $css_button = '

    <style id="bodycommerce-free-badge star">

    .bodycommerce-free-badge {position:absolute;
      '.$check_BodyCommerce_sale_badge_position_free.': '.$check_BodyCommerce_sale_badge_edge_distance_free.'px;
      top: '.$check_BodyCommerce_sale_badge_top_distance_free.'px;}
    .bodycommerce-free-badge svg {
      fill: '.$check_BodyCommerce_sale_badge_color_secondary_free.';
      position: absolute;
        z-index: 100;
      width: '.$check_BodyCommerce_sale_badge_size_free.'px;
    height: '.$check_BodyCommerce_sale_badge_size_free.'px;
    }

    .bodycommerce-free-badge svg .primary {
    	  fill: '.$check_BodyCommerce_sale_badge_color_primary_free.' !important;
    }
    .bodycommerce-free-badge svg .quaternary {
    	  fill: '.$check_BodyCommerce_sale_badge_color_quaternary_free.' !important;
    }

    .bodycommerce-free-text {
      position: relative;
        z-index: 101;
        '.$check_BodyCommerce_sale_badge_position_free.': '.$check_BodyCommerce_sale_badge_edge_distance_text_free.'px;
        top: '.$check_BodyCommerce_sale_badge_top_distance_text_free.'px;
        width: '.$check_BodyCommerce_sale_badge_size_free.'px;
        font-size: '.$check_BodyCommerce_sale_badge_text_size_free.'px;
        color: '.$check_BodyCommerce_sale_badge_text_color_free.';
        line-height: '.$check_BodyCommerce_sale_badge_text_line_height_free.'px;
    		text-align: '.$check_BodyCommerce_sale_badge_text_position_free.';
    	}

    		</style>';
  }
?>
