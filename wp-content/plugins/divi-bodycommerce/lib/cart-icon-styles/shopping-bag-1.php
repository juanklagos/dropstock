<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$check_cart_custom_icon_width = $titan->getOption( 'cart_custom_icon_width' );
?>
<svg style="width:<?php echo $check_cart_custom_icon_width ?>px;max-height:<?php echo $check_cart_custom_icon_width ?>px;float:left;" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 44 44">
  <g>
    <g>
      <path d="m35,8h-7v-3c0-2.761-2.239-5-5-5h-2c-2.761,0-5,2.239-5,5v3h-7l-5,36h36l-5-36zm-17-3c0-1.657 1.343-3 3-3h2c1.657,0 3,1.343 3,3v3h-8v-3zm-7,5h5v4h2v-4h8v4h2v-4h5l5,32h-32l5-32z"/>
    </g>
  </g>
</svg>
<?php  ?>
