<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// NEW BADGE

$check_BodyCommerce_sale_badge_design = $titan->getOption( 'BodyCommerce_sale_badge_design' );

  // NEW BADGE

  $check_BodyCommerce_sale_badge_color_primary_ofs = $titan->getOption( 'BodyCommerce_sale_badge_color_primary_ofs' );
  // $check_BodyCommerce_sale_badge_color_secondary_ofs = $titan->getOption( 'BodyCommerce_sale_badge_color_secondary_ofs' );
  $check_BodyCommerce_sale_badge_edge_distance_ofs = $titan->getOption( 'BodyCommerce_sale_badge_edge_distance_ofs' );
  $check_BodyCommerce_sale_badge_top_distance_ofs = $titan->getOption( 'BodyCommerce_sale_badge_top_distance_ofs' );
  $check_BodyCommerce_sale_badge_position_ofs = $titan->getOption( 'BodyCommerce_sale_badge_position_ofs' );
  $check_BodyCommerce_sale_badge_size_ofs = $titan->getOption( 'BodyCommerce_sale_badge_size_ofs' );
  $check_BodyCommerce_sale_badge_text_color_ofs = $titan->getOption( 'BodyCommerce_sale_badge_text_color_ofs' );
  $check_BodyCommerce_sale_badge_text_size_ofs = $titan->getOption( 'BodyCommerce_sale_badge_text_size_ofs' );
  $check_BodyCommerce_sale_badge_text_position_ofs = $titan->getOption( 'BodyCommerce_sale_badge_text_position_ofs' );
  $check_BodyCommerce_sale_badge_text_line_height_ofs = $titan->getOption( 'BodyCommerce_sale_badge_text_line_height_ofs' );
  $check_BodyCommerce_sale_badge_edge_distance_text_ofs = $titan->getOption( 'BodyCommerce_sale_badge_edge_distance_text_ofs' );
  $check_BodyCommerce_sale_badge_top_distance_text_ofs = $titan->getOption( 'BodyCommerce_sale_badge_top_distance_text_ofs' );

  $check_other_settings_absolute_relative_text_ofs = $titan->getOption( 'other_settings_absolute_relative_text_ofs' );

  if ($check_other_settings_absolute_relative_text_ofs == 0){
  $css_button = '
  <style id="bodycommerce-ofs-badge star">
  .bodycommerce-ofs-badge {position:relative;}
  .bodycommerce-ofs-badge svg {
    fill: '.$check_BodyCommerce_sale_badge_color_primary_ofs.';
    position: absolute;
      z-index: 100;
      '.$check_BodyCommerce_sale_badge_position_ofs.': '.$check_BodyCommerce_sale_badge_edge_distance_ofs.'px;
      top: '.$check_BodyCommerce_sale_badge_top_distance_ofs.'px;
    width: '.$check_BodyCommerce_sale_badge_size_ofs.'px;
  height: '.$check_BodyCommerce_sale_badge_size_ofs.'px;
  }
  .bodycommerce-ofs-badge svg path {
  	  fill: '.$check_BodyCommerce_sale_badge_color_primary_ofs.' !important;
  }
  .bodycommerce-ofs-text {
    position: absolute;
      z-index: 101;
      '.$check_BodyCommerce_sale_badge_position_ofs.': '.$check_BodyCommerce_sale_badge_edge_distance_text_ofs.'px;
      top: '.$check_BodyCommerce_sale_badge_top_distance_text_ofs.'px;
      width: '.$check_BodyCommerce_sale_badge_size_ofs.'px;
      font-size: '.$check_BodyCommerce_sale_badge_text_size_ofs.'px;
      color: '.$check_BodyCommerce_sale_badge_text_color_ofs.';
      line-height: '.$check_BodyCommerce_sale_badge_text_line_height_ofs.'px;
  		text-align: '.$check_BodyCommerce_sale_badge_text_position_ofs.';
  	}
  		</style>';
    }
    else {
      $css_button = '
      <style id="bodycommerce-ofs-badge star">
      .bodycommerce-ofs-badge {position:absolute;  top: '.$check_BodyCommerce_sale_badge_top_distance_ofs.'px;
      '.$check_BodyCommerce_sale_badge_position_ofs.': '.$check_BodyCommerce_sale_badge_edge_distance_ofs.'px;
    }
      .bodycommerce-ofs-badge svg {
        fill: '.$check_BodyCommerce_sale_badge_color_primary_ofs.';
        position: absolute;
        z-index: 100;
        width: '.$check_BodyCommerce_sale_badge_size_ofs.'px;
        height: '.$check_BodyCommerce_sale_badge_size_ofs.'px;
      }
      .bodycommerce-ofs-badge svg path {
      	  fill: '.$check_BodyCommerce_sale_badge_color_primary_ofs.' !important;
      }
      .bodycommerce-ofs-text {
        position: relative;
          z-index: 101;
          '.$check_BodyCommerce_sale_badge_position_ofs.': '.$check_BodyCommerce_sale_badge_edge_distance_text_ofs.'px;
          top: '.$check_BodyCommerce_sale_badge_top_distance_text_ofs.'px;
          width: '.$check_BodyCommerce_sale_badge_size_ofs.'px;
          font-size: '.$check_BodyCommerce_sale_badge_text_size_ofs.'px;
          color: '.$check_BodyCommerce_sale_badge_text_color_ofs.';
          line-height: '.$check_BodyCommerce_sale_badge_text_line_height_ofs.'px;
      		text-align: '.$check_BodyCommerce_sale_badge_text_position_ofs.';
      	}

      		</style>';
    }

?>
