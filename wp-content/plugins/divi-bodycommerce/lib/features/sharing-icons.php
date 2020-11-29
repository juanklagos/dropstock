<?php
if ( ! defined( 'ABSPATH' ) ) exit;


function bodycommerce_social_sharing_buttons($sharinglinks) {
include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

  $sharing_icon_style = $titan->getOption( 'sharing_icon_style' );
  $sharing_icon_btn_color = $titan->getOption( 'sharing_icon_btn_color' );
  $sharing_icon_btn_border_radius = $titan->getOption( 'sharing_icon_btn_border_radius' );

  $sharing_icon_twitter = $titan->getOption( 'sharing_icon_twitter' );
  $sharing_icon_facebook = $titan->getOption( 'sharing_icon_facebook' );
  $sharing_icon_linkedin = $titan->getOption( 'sharing_icon_linkedin' );
  $sharing_icon_pinterest = $titan->getOption( 'sharing_icon_pinterest' );
  $sharing_icon_email = $titan->getOption( 'sharing_icon_email' );
  $sharing_icon_email_subject = $titan->getOption( 'sharing_icon_email_subject' );
  $sharing_icon_email_body = $titan->getOption( 'sharing_icon_email_body' );
  $sharing_icon_print = $titan->getOption( 'sharing_icon_print' );
  $sharing_icon_whatsapp = $titan->getOption( 'sharing_icon_whatsapp' );

  $sharing_icon_text_before_get = $titan->getOption( 'sharing_icon_text_before' );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Sharing Icons Before Text', $sharing_icon_text_before_get );
  $sharing_icon_text_before = apply_filters( 'wpml_translate_single_string', $sharing_icon_text_before_get, 'divi-bodyshop-woocommerce', 'Sharing Icons Before Text' );


  if ($sharing_icon_style == "none") {}
  else {


    $css_woo_bodyshop =  '<style id="bodycommerce_sharing_icons">';
   $css_woo_bodyshop .= '


   .bodycommerce-link {
   padding: 2px 8px 4px 8px !important;
   color: '.$sharing_icon_btn_color.';
   font-size: 12px;
   border-radius: '.$sharing_icon_btn_border_radius.'px;
   margin-right: 5px;
   cursor: pointer;
   -moz-background-clip: padding;
   -webkit-background-clip: padding-box;
   box-shadow: inset 0 -3px 0 rgba(0,0,0,.2);
   -moz-box-shadow: inset 0 -3px 0 rgba(0,0,0,.2);
   -webkit-box-shadow: inset 0 -3px 0 rgba(0,0,0,.2);
   margin-top: 2px;
   display: inline-block;
   text-decoration: none;
   }

   .bodycommerce-link:hover,.bodycommerce-link:active {
   color: white;
   }

   .bodycommerce-twitter {
   background: #00aced;
   }

   .bodycommerce-twitter:hover,.bodycommerce-twitter:active {
   background: #0084b4;
   }

   .bodycommerce-facebook {
   background: #3B5997;
   }

   .bodycommerce-facebook:hover,.bodycommerce-facebook:active {
   background: #2d4372;
   }

   .bodycommerce-pinterest {
   background: #bd081c;
   }

   .bodycommerce-pinterest:hover,.bodycommerce-pinterest:active {
   background: #9e0818;
   }

   .bodycommerce-email {
   background: #738a8d;
   }

   .bodycommerce-email:hover,.bodycommerce-email:active {
   background: #617375;
   }

   .bodycommerce-print {
   background: #20292f;
   }

   .bodycommerce-print:hover,.bodycommerce-print:active {
   background: #000000;
   }

   .bodycommerce-linkedin {
   background: #0074A1;
   }

   .bodycommerce-linkedin:hover,.bodycommerce-linkedin:active {
   background: #006288;
   }

   .bodycommerce-whatsapp {
   background: #43d854;
   }

   .bodycommerce-whatsapp:hover,.bodycommerce-whatsapp:active {
   background: #009688;
   }

   .bodycommerce-social {
   margin: 20px 0px 25px 0px;
   -webkit-font-smoothing: antialiased;
   font-size: 12px;
   }      ';

if ($sharing_icon_style == "icons") {
 $css_woo_bodyshop .= '

 /* icons */
 .bodycommerce-social.icons .bodycommerce-link {
   font-size: 0;
 box-shadow: none;
 -moz-box-shadow: none;
 -webkit-box-shadow: none;
 width: 35px;
 height: 35px;
 position: relative;
 }

 .bodycommerce-social.icons .bodycommerce-link:after {
   font-family: "ETmodules" !important;
       font-size: 15px;
       color: '.$sharing_icon_btn_color.';
       z-index: 10;
       content: "\4d";
       position: absolute;
       left: 50%;
       top: 50%;
       transform: translate(-50%,-50%);
 }

 .bodycommerce-social.icons .bodycommerce-twitter:after {
 content: "\e097";
 }
 .bodycommerce-social.icons .bodycommerce-facebook:after {
 content: "\e093";
 }
 .bodycommerce-social.icons .bodycommerce-linkedin:after {
 content: "\e09d";
 }
 .bodycommerce-social.icons .bodycommerce-pinterest:after {
 content: "\e095";
 }
 .bodycommerce-social.icons .bodycommerce-whatsapp:after {
content:"";
background: url('.DE_DB_WOO_URL.'/images/sharing-icons/whatsapp.svg);
width: 28px;
height: 28px;
background-size: 20px;
background-repeat: no-repeat;
background-position: center;
 }
 .bodycommerce-social.icons .bodycommerce-email:after {
 content: "\e076";
 }
 .bodycommerce-social.icons .bodycommerce-print:after {
 content: "\e0fa";
 }

';
}

   $css_woo_bodyshop .= '</style>';
   //minify it
   $css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
   echo $css_woo_bodyshop_min;





global $post;
if ( is_single() ) {
$bodycommerceURL = urlencode(get_permalink());
$bodycommerceTitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
$bodycommerceThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
$twitterURL = 'https://twitter.com/intent/tweet?text='.$bodycommerceTitle.'&amp;url='.$bodycommerceURL.'';
$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$bodycommerceURL;
$whatsappURL = 'https://wa.me/?text='.$bodycommerceTitle . ' ' . $bodycommerceURL;
$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$bodycommerceURL.'&amp;title='.$bodycommerceTitle;
$emailURL = 'mailto:?subject='.$sharing_icon_email_subject.' '.$bodycommerceTitle.'&amp;body='.$sharing_icon_email_body.' '.$bodycommerceURL;
// pinterest is about pictures and so, we add the media
$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$bodycommerceURL.'&amp;media='.$bodycommerceThumbnail[0].'&amp;description='.$bodycommerceTitle;

$sharinglinks .= '<div class="bodycommerce-social icons">';

$sharinglinks .= '<h5>'.$sharing_icon_text_before.'</h5>';

if ($sharing_icon_twitter == 1) {
$sharinglinks .= '<a class="bodycommerce-link bodycommerce-twitter" href="'. $twitterURL .'" target="_blank">Twitter</a>';
}
if ($sharing_icon_facebook == 1) {
$sharinglinks .= '<a class="bodycommerce-link bodycommerce-facebook" href="'.$facebookURL.'" target="_blank">Facebook</a>';
}
if ($sharing_icon_linkedin == 1) {
$sharinglinks .= '<a class="bodycommerce-link bodycommerce-linkedin" href="'.$linkedInURL.'" target="_blank">LinkedIn</a>';
}
if ($sharing_icon_pinterest == 1) {
$sharinglinks .= '<a class="bodycommerce-link bodycommerce-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank">Pin it</a>';
}
if ($sharing_icon_whatsapp == 1) {
$sharinglinks .= '<a class="bodycommerce-link bodycommerce-whatsapp" href="'.$whatsappURL.'" target="_blank">Whatsapp</a>';
}
if ($sharing_icon_email == 1) {
$sharinglinks .= '<a class="bodycommerce-link bodycommerce-email" href="'.$emailURL.'" target="_blank">Email</a>';
}
if ($sharing_icon_print == 1) {
$sharinglinks .= '<a class="bodycommerce-link bodycommerce-print" href="#" onclick="window.print();" target="_blank">Print</a>';
}

$sharinglinks .= '</div>';
echo $sharinglinks;
} else {
// if not a post/page then don't include sharing button
echo $sharinglinks;
} }
}
add_filter( 'woocommerce_share', 'bodycommerce_social_sharing_buttons');
 ?>
