<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// NEW BADGE

$check_BodyCommerce_sale_badge_color_primary_new = $titan->getOption( 'BodyCommerce_sale_badge_color_primary_new' );
$check_BodyCommerce_sale_badge_color_secondary_new = $titan->getOption( 'BodyCommerce_sale_badge_color_secondary_new' );
$check_BodyCommerce_sale_badge_color_quaternary_new = $titan->getOption( 'BodyCommerce_sale_badge_color_quaternary_new' );
$check_BodyCommerce_sale_badge_edge_distance_new = $titan->getOption( 'BodyCommerce_sale_badge_edge_distance_new' );
$check_BodyCommerce_sale_badge_top_distance_new = $titan->getOption( 'BodyCommerce_sale_badge_top_distance_new' );
$check_BodyCommerce_sale_badge_position_new = $titan->getOption( 'BodyCommerce_sale_badge_position_new' );
$check_BodyCommerce_sale_badge_size_new = $titan->getOption( 'BodyCommerce_sale_badge_size_new' );
$check_BodyCommerce_sale_badge_text_color_new = $titan->getOption( 'BodyCommerce_sale_badge_text_color_new' );
$check_BodyCommerce_sale_badge_text_size_new = $titan->getOption( 'BodyCommerce_sale_badge_text_size_new' );
$check_BodyCommerce_sale_badge_text_position_new = $titan->getOption( 'BodyCommerce_sale_badge_text_position_new' );
$check_BodyCommerce_sale_badge_text_line_height_new = $titan->getOption( 'BodyCommerce_sale_badge_text_line_height_new' );
$check_BodyCommerce_sale_badge_edge_distance_text_new = $titan->getOption( 'BodyCommerce_sale_badge_edge_distance_text_new' );
$check_BodyCommerce_sale_badge_top_distance_text_new = $titan->getOption( 'BodyCommerce_sale_badge_top_distance_text_new' );


$check_other_settings_absolute_relative_text_new = $titan->getOption( 'other_settings_absolute_relative_text_new' );

if ($check_other_settings_absolute_relative_text_new == 0){
$css_button = '

<style id="bodycommerce-new-badge star">

.bodycommerce-new-badge {position:relative;}
.bodycommerce-new-badge svg {
  fill: '.$check_BodyCommerce_sale_badge_color_secondary_new.';
  position: absolute;
    z-index: 100;
    '.$check_BodyCommerce_sale_badge_position_new.': '.$check_BodyCommerce_sale_badge_edge_distance_new.'px;
    top: '.$check_BodyCommerce_sale_badge_top_distance_new.'px;
  width: '.$check_BodyCommerce_sale_badge_size_new.'px;
height: '.$check_BodyCommerce_sale_badge_size_new.'px;
}

.bodycommerce-new-badge svg .primary {
	  fill: '.$check_BodyCommerce_sale_badge_color_primary_new.' !important;
}
.bodycommerce-new-badge svg .quaternary {
	  fill: '.$check_BodyCommerce_sale_badge_color_quaternary_new.' !important;
}

.bodycommerce-new-text {
  position: absolute;
    z-index: 101;
    '.$check_BodyCommerce_sale_badge_position_new.': '.$check_BodyCommerce_sale_badge_edge_distance_text_new.'px;
    top: '.$check_BodyCommerce_sale_badge_top_distance_text_new.'px;
    width: '.$check_BodyCommerce_sale_badge_size_new.'px;
    font-size: '.$check_BodyCommerce_sale_badge_text_size_new.'px;
    color: '.$check_BodyCommerce_sale_badge_text_color_new.';
    line-height: '.$check_BodyCommerce_sale_badge_text_line_height_new.'px;
		text-align: '.$check_BodyCommerce_sale_badge_text_position_new.';
	}

		</style>';
  }
  else {
    $css_button = '

    <style id="bodycommerce-new-badge star">

    .bodycommerce-new-badge {position:absolute;
      '.$check_BodyCommerce_sale_badge_position_new.': '.$check_BodyCommerce_sale_badge_edge_distance_new.'px;
      top: '.$check_BodyCommerce_sale_badge_top_distance_new.'px;}
    .bodycommerce-new-badge svg {
      fill: '.$check_BodyCommerce_sale_badge_color_secondary_new.';
      position: absolute;
        z-index: 100;
      width: '.$check_BodyCommerce_sale_badge_size_new.'px;
    height: '.$check_BodyCommerce_sale_badge_size_new.'px;
    }

    .bodycommerce-new-badge svg .primary {
    	  fill: '.$check_BodyCommerce_sale_badge_color_primary_new.' !important;
    }
    .bodycommerce-new-badge svg .quaternary {
    	  fill: '.$check_BodyCommerce_sale_badge_color_quaternary_new.' !important;
    }

    .bodycommerce-new-text {
      position: relative;
        z-index: 101;
        '.$check_BodyCommerce_sale_badge_position_new.': '.$check_BodyCommerce_sale_badge_edge_distance_text_new.'px;
        top: '.$check_BodyCommerce_sale_badge_top_distance_text_new.'px;
        width: '.$check_BodyCommerce_sale_badge_size_new.'px;
        font-size: '.$check_BodyCommerce_sale_badge_text_size_new.'px;
        color: '.$check_BodyCommerce_sale_badge_text_color_new.';
        line-height: '.$check_BodyCommerce_sale_badge_text_line_height_new.'px;
    		text-align: '.$check_BodyCommerce_sale_badge_text_position_new.';
    	}

    		</style>';
  }
?>
