<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$check_cart_custom_icon_width = $titan->getOption( 'cart_custom_icon_width' );
?>
<svg style="width:<?php echo $check_cart_custom_icon_width ?>px;max-height:<?php echo $check_cart_custom_icon_width ?>px;float:left;" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 36 36">
  <g>
    <g>
      <path d="M16,15h4c2.761,0,5-2.239,5-5V6h-2v4c0,1.657-1.343,3-3,3h-4c-1.657,0-3-1.343-3-3V6h-2v4C11,12.761,13.239,15,16,15z     M2,0v31c0,2.761,2.239,5,5,5h22c2.761,0,5-2.239,5-5V0H2z M32,31c0,1.657-1.343,3-3,3H7c-1.657,0-3-1.343-3-3V2h28V31z"/>
    </g>
  </g>
</svg>

<?php  ?>
