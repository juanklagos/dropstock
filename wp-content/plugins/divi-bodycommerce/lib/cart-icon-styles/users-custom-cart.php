<?php
  $custom_cart_icon_upload = $titan->getOption( 'custom_cart_icon_upload' );
  $check_cart_custom_icon_width = $titan->getOption( 'cart_custom_icon_width' );
  $aa_img_attachment = wp_get_attachment_image_src( $custom_cart_icon_upload );
  $path = $aa_img_attachment[0];
  ?>
  <img style="width:<?php echo $check_cart_custom_icon_width ?>px;max-height:<?php echo $check_cart_custom_icon_width ?>px;float:left;" src="<?php echo $path ?>">

<?php  ?>
