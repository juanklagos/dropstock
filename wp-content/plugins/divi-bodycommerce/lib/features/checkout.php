<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bodycommerce_checkout_css_head() {
if ( ! is_admin() ) {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );


  $checkout_page_enable = $titan->getOption( 'checkout_page_enable' );
  $check_checkout_page_style = $titan->getOption( 'checkout_page_style');
  $check_checkout_page_multistep_style = $titan->getOption( 'checkout_page_multistep_style');

  //Background
  $check_checkout_page_background_color = $titan->getOption( 'checkout_page_background_color'); // done
  $check_checkout_page_padding = $titan->getOption( 'checkout_page_padding'); // done

    //Inputs
    $check_checkout_page_input_background_color = $titan->getOption( 'checkout_page_input_background_color'); // DONE
    $check_checkout_page_input_border_color = $titan->getOption( 'checkout_page_input_border_color'); // DONE
    $check_checkout_page_input_border_width = $titan->getOption( 'checkout_page_input_border_width'); // DONE
    $check_checkout_page_input_border_radius = $titan->getOption( 'checkout_page_input_border_radius'); // DONE
    $check_checkout_page_input_text_color = $titan->getOption( 'checkout_page_input_text_color'); // DONE
    $check_checkout_page_input_label_text_color = $titan->getOption( 'checkout_page_input_label_text_color'); // DONE
    $check_checkout_page_input_validated_color = $titan->getOption( 'checkout_page_input_validated_color'); // DONE


  //Payment
  $check_checkout_page_payment_background_color = $titan->getOption( 'checkout_page_payment_background_color'); // DONE
  $check_checkout_page_payment_info_background_color = $titan->getOption( 'checkout_page_payment_info_background_color'); // DONE


  // buttons
  $check_checkout_page_use_custom_style_button = $titan->getOption( 'checkout_page_use_custom_style_button'); // DONE
  $check_checkout_page_field_button_text_size = $titan->getOption( 'checkout_page_field_button_text_size'); // DONE
  $check_checkout_page_field_button_text_color = $titan->getOption( 'checkout_page_field_button_text_color'); // DONE
  $check_checkout_page_field_button_background_color = $titan->getOption( 'checkout_page_field_button_background_color'); // DONE
  $check_checkout_page_field_button_border_width = $titan->getOption( 'checkout_page_field_button_border_width'); // DONE
  $check_checkout_page_field_button_border_color = $titan->getOption( 'checkout_page_field_button_border_color'); // DONE
  $check_checkout_page_field_button_border_radius = $titan->getOption( 'checkout_page_field_button_border_radius'); // DONE
  $check_checkout_page_field_button_letter_spacing = $titan->getOption( 'checkout_page_field_button_letter_spacing'); // DONE
  $check_checkout_page_field_add_button_icon = $titan->getOption( 'checkout_page_field_add_button_icon'); // DONE
  $check_checkout_page_field_button_icon = $titan->getOption( 'checkout_page_field_button_icon'); // DONE
  $check_checkout_page_field_button_icon_color = $titan->getOption( 'checkout_page_field_button_icon_color'); // DONE
  $check_checkout_page_field_button_icon_placement = $titan->getOption( 'checkout_page_field_button_icon_placement'); // DONE
  $check_checkout_page_field_button_icon_only_show_hover = $titan->getOption( 'checkout_page_field_button_icon_only_show_hover'); // DONE
  // Buttons hover
  $check_checkout_page_button_hover_text_color = $titan->getOption( 'checkout_page_button_hover_text_color'); // DONE
  $check_checkout_page_button_hover_background_color = $titan->getOption( 'checkout_page_button_hover_background_color'); // DONE
  $check_checkout_page_button_hover_border_color = $titan->getOption( 'checkout_page_button_hover_border_color'); // DONE
  $check_checkout_page_button_hover_border_radius = $titan->getOption( 'checkout_page_button_hover_border_radius'); // DONE
  $check_checkout_page_button_hover_letter_spacing = $titan->getOption( 'checkout_page_button_hover_letter_spacing'); // DONE


  //Multi Step
  $check_checkout_page_progress_bar_title_text_color = $titan->getOption( 'checkout_page_progress_bar_title_text_color');
  $check_checkout_page_progress_bar_default_color = $titan->getOption( 'checkout_page_progress_bar_default_color');
  $check_checkout_page_progress_bar_active_color = $titan->getOption( 'checkout_page_progress_bar_active_color');
  $check_checkout_page_progress_bar_text_default_color = $titan->getOption( 'checkout_page_progress_bar_text_default_color');
  $check_checkout_page_progress_bar_text_active_color = $titan->getOption( 'checkout_page_progress_bar_text_active_color');
  $checkout_multi_circle_style = $titan->getOption( 'checkout_multi_circle_style');


  //ACCORDIAN
    $check_checkout_page_accordian_icon = $titan->getOption( 'checkout_page_accordian_icon');
    $check_checkout_page_accordian_icon_color = $titan->getOption( 'checkout_page_accordian_icon_color');

    if ($check_checkout_page_accordian_icon == "") {$check_checkout_page_accordian_icon_display = "e050";}else {  $check_checkout_page_accordian_icon_display = $check_checkout_page_accordian_icon;}
    $css_accordian_icon = sprintf('.db_accordian_checkout .et_pb_toggle_title:before {content:"\%s" !important;color:%s; !important}',$check_checkout_page_accordian_icon_display, $check_checkout_page_accordian_icon_color );


    $check_checkout_page_accordian_open_title_font_size = $titan->getOption( 'checkout_page_accordian_open_title_font_size');
    $check_checkout_page_accordian_open_title_font_color = $titan->getOption( 'checkout_page_accordian_open_title_font_color');
    $check_checkout_page_accordian_open_title_background_color = $titan->getOption( 'checkout_page_accordian_open_title_background_color');
    $check_checkout_page_accordian_closed_title_font_size = $titan->getOption( 'checkout_page_accordian_closed_title_font_size');
    $check_checkout_page_accordian_closed_title_font_color = $titan->getOption( 'checkout_page_accordian_closed_title_font_color');
    $check_checkout_page_accordian_closed_title_background_color = $titan->getOption( 'checkout_page_accordian_closed_title_background_color');



if ($checkout_multi_circle_style == "oneline") {
  $checkout_multi_circle_style_dis = "
  #progressbar.multi-circles {padding-left: 0 !important;display: flex !important;}
  #progressbar.multi-circles li:before {display: inline-block;}
  #progressbar.multi-circles li span {display: none;}
  #progressbar.multi-circles li.active.selected span {display: inline-block;padding-left: 5px;}
  #progressbar.multi-circles li {flex: 1;}
  #progressbar.multi-circles li.active.selected {flex: 3;text-align: left;}
  ";
} else {
  $checkout_multi_circle_style_dis = "";
}







if ($check_checkout_page_progress_bar_default_color == "") {
  $check_checkout_page_progress_bar_default_color_display = "#ececec";
}
else {
  $check_checkout_page_progress_bar_default_color_display = $check_checkout_page_progress_bar_default_color;
}


$accent_color = get_option( 'et_divi' );
if (isset($accent_color["accent_color"])) {
$accent_color_value = $accent_color["accent_color"];
}
else {
  $accent_color_value = "";
}

if ($accent_color_value == "") {
$accent_color_value_show = "#2ea3f2";
}
else {

  $accent_color_value_show = $accent_color_value;
}

if ($check_checkout_page_progress_bar_active_color == "") {
  $check_checkout_page_progress_bar_active_color_display = $accent_color_value_show;
}
else {
  $check_checkout_page_progress_bar_active_color_display = $check_checkout_page_progress_bar_active_color;
}

if ($check_checkout_page_progress_bar_text_default_color == ""){
  $check_checkout_page_progress_bar_text_default_color_display = "#000";
}
else {
  $check_checkout_page_progress_bar_text_default_color_display = $check_checkout_page_progress_bar_text_default_color;
}

if ($check_checkout_page_progress_bar_text_active_color == ""){
  $check_checkout_page_progress_bar_text_active_color_display = "#fff";
}
else {
  $check_checkout_page_progress_bar_text_active_color_display = $check_checkout_page_progress_bar_text_active_color;
}


if ($checkout_page_enable == "1"){
  if(is_user_logged_in()):?><script>var pmsc_user_login = 'user_login';</script>
<?php else: ?><script>var pmsc_user_login = '';</script>
    <?php endif;
}







if ($check_checkout_page_use_custom_style_button == "enabled"){

  if ($check_checkout_page_field_button_icon == "") {$check_checkout_page_field_button_icon_display = "35";}else {  $check_checkout_page_field_button_icon_display = $check_checkout_page_field_button_icon;}

  $display_checkout_page_button_default_syle = '
  .button.bodynext, .button.bodyprev, form.checkout .button {
  font-size:'.$check_checkout_page_field_button_text_size.'px !important;
  color:'.$check_checkout_page_field_button_text_color.' !important;
  background-color:'.$check_checkout_page_field_button_background_color.' !important;
  border-width: '.$check_checkout_page_field_button_border_width.'px !important;
  border-color: '.$check_checkout_page_field_button_border_color.' !important;
  border-radius: '.$check_checkout_page_field_button_border_radius.'px !important;
  letter-spacing: '.$check_checkout_page_field_button_letter_spacing.'px !important;
  }


  .button.bodynext:hover, .button.bodyprev:hover, form.checkout .button:hover {
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
      $display_checkout_page_button_icon = sprintf('.woocommerce #payment #place_order, .woocommerce-page #payment #place_order:after, form.checkout .button:after, .button.bodynext:after, .button.bodyprev:after {content:"\%s" !important;color:%s !important}',$check_checkout_page_field_button_icon_display, $check_checkout_page_field_button_icon_color );
      $display_checkout_page_button_icon_placement = sprintf('.woocommerce #payment #place_order, .woocommerce-page #payment #place_order:before, form.checkout .button:after, .button.bodynext:before, .button.bodyprev:before{content:none !important;} .bodycommerce-minicart .button.wc-forward:hover {padding-left: 1em !important; padding-right: 2em !important;}' );
    }
    else {
      $display_checkout_page_button_icon = sprintf('.woocommerce #payment #place_order, .woocommerce-page #payment #place_order:before, form.checkout .button:before, .button.bodynext:before, .button.bodyprev:before {display:block !important;content:"\%s" !important;color:%s !important;} .bodycommerce-minicart .button.wc-forward:hover:before {opacity: 1 !important;}',$check_checkout_page_field_button_icon_display, $check_checkout_page_field_button_icon_color );
      $display_checkout_page_button_icon_placement = sprintf('.woocommerce #payment #place_order, .woocommerce-page #payment #place_order:after, form.checkout .button:after, .button.bodynext:after, .button.bodyprev:after{content:none !important;} .bodycommerce-minicart .button.wc-forward:hover {padding-right: 1em !important; padding-left: 2em !important;}');
    }
  }
  else {
    // RIGHT OR LEFT
      if ($check_checkout_page_field_button_icon_placement == "right") {
        $display_checkout_page_button_icon = sprintf('.woocommerce #payment #place_order, .woocommerce-page #payment #place_order:after, form.checkout .button:after, .button.bodynext:after, .button.bodyprev:after {content:"\%s" !important;color:%s;opacity:1 !important;margin-left: 0;}.bodycommerce-minicart .button.wc-forward {padding-left: 1em !important; padding-right: 2em !important;}',$check_checkout_page_field_button_icon_display, $check_checkout_page_field_button_icon_color);
        $display_checkout_page_button_icon_placement = sprintf('.woocommerce #payment #place_order, .woocommerce-page #payment #place_order:before, form.checkout .button:before, .button.bodynext:before, .button.bodyprev:before {content:none !important;}');
      }
      else {
        $display_checkout_page_button_icon = sprintf('.woocommerce #payment #place_order, .woocommerce-page #payment #place_order:before, form.checkout .button:before, .button.bodynext:before, .button.bodyprev:before  {display:block !important;content:"\%s" !important;color:%s;opacity:1;}.bodycommerce-minicart .button.wc-forward {padding-right: 1em !important; padding-left: 2em !important;}',$check_checkout_page_field_button_icon_display, $check_checkout_page_field_button_icon_color );
        $display_checkout_page_button_icon_placement = sprintf('.woocommerce #payment #place_order, .woocommerce-page #payment #place_order:after, form.checkout .button:after, .button.bodynext:after, .button.bodyprev:after{content:none !important;}');
      }
  }



  }
  elseif ($check_checkout_page_field_add_button_icon == "no") {
  $display_checkout_page_button_icon = 'form.checkout .button:before, form.checkout .button:after, .button.bodynext:before, .button.bodyprev:before , .button.bodynext:after, .button.bodyprev:after { content: none !important;}
  .bodycommerce-minicart .button.wc-forward, .bodycommerce-shoppify-bottom-controls .button {padding: 0.3em 1em !important;}  ';
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



  // BUTTON Styles end



$css_woo_bodyshop =  '<style id="bodycommerce-checkout">';
$css_woo_bodyshop .= '

.woocommerce-checkout #main-content .container:before, .woocommerce-checkout #sidebar {display:none;}
.woocommerce-checkout #left-area {width:100%;padding-right:0;}

.woocommerce #payment.woocommerce-checkout-payment {background-color:'.$check_checkout_page_payment_background_color.';}
.woocommerce #payment.woocommerce-checkout-payment .payment_box {background-color: '.$check_checkout_page_payment_info_background_color.';}

.woocommerce #page-container .checkout-area form .form-row input.text,
.woocommerce #page-container .checkout-area form .form-row input.title,
.woocommerce #page-container .checkout-area form .form-row input[type=email],
.woocommerce #page-container .checkout-area form .form-row input[type=password],
.woocommerce #page-container .checkout-area form .form-row input[type=tel],
.woocommerce #page-container .checkout-area form .form-row input[type=text],
.woocommerce #page-container .checkout-area form .form-row select,
.woocommerce #page-container .checkout-area form .form-row textarea {
background-color:'.$check_checkout_page_input_background_color.' !important;
border: '.$check_checkout_page_input_border_width.'px solid '.$check_checkout_page_input_border_color.' !important;
border-radius:'.$check_checkout_page_input_border_radius.'px !important;
color:'.$check_checkout_page_input_text_color.' !important;

}

.woocommerce #page-container .checkout-area  form .form-row label, .checkout-area form .form-row label {
color:'.$check_checkout_page_input_label_text_color.';
}

.woocommerce #page-container .checkout-area form .form-row.woocommerce-validated .select2-container,
.woocommerce #page-container .checkout-area form .form-row.woocommerce-validated input.input-text, 
.woocommerce #page-container .checkout-area form .form-row.woocommerce-validated select {
      border-color: '.$check_checkout_page_input_validated_color.';
}

.selected{
  color:red;
}
.bodynext {float:right;}



.fs-title {
  font-size: 15px;
  text-transform: uppercase;
  color: #2c3e50;
  margin-bottom: 10px;
}
.fs-subtitle {
  font-weight: normal;
  font-size: 13px;
  color: #666;
  margin-bottom: 20px;
}

#progressbar {
  margin-bottom: 30px;
  overflow: hidden;
  /*CSS counters to number the steps*/
  counter-reset: step;
}




#progressbar li {
  list-style-type: none;
  color: '.$check_checkout_page_progress_bar_title_text_color.';
  font-size: 13px;
  float: left;
  position: relative;
  text-align: center;
}
#progressbar.four li {
width: 25%;
}
#progressbar.five li {
width: 20%;
}
.checkout-area {background-color:'.$check_checkout_page_background_color.';padding:'.$check_checkout_page_padding.'px;}

#progressbar li:before {
  content: counter(step);
  counter-increment: step;
  width: 40px;
  display: block;
  font-size: 14px;
  color: '.$check_checkout_page_progress_bar_text_default_color_display.';
  background: '.$check_checkout_page_progress_bar_default_color_display.';
  border-radius: 42px;
  margin: 0 auto 5px auto;
  height: 40px;
  line-height: 2.8em;
  text-align: center;
}

#progressbar li:after {
  content: "";
width: 70%;
height: 2px;
background: '.$check_checkout_page_progress_bar_default_color_display.';
position: absolute;
left: 64%;
top: 50%;
z-index: 0;
transform: translateY(-50%);
}

#progressbar.five li:after {width: 60%;left: 68%;}

#progressbar li:last-child:after {
  content: none;
}

.arrow-text {color: '.$check_checkout_page_progress_bar_text_default_color_display.';}
.active .arrow-text {color: '.$check_checkout_page_progress_bar_text_active_color_display.';}

#progressbar li.active:before,
#progressbar li.active:after {
  background: '.$check_checkout_page_progress_bar_active_color_display.';
  color: '.$check_checkout_page_progress_bar_text_active_color_display.';
}
#display {background-color: #fff;padding: 5%;}
.checkout-process-btn-containter {padding: 20px 0;}
#next {float: right;}
.display {display: none;}
.display.active {display: block;}
.next {float: right;}
.previous {float: left;}

#progressbar.arrow li:before, #progressbar.arrow li:after {display:none;}

#progressbar.arrow li {    height: 70px;
  background: '.$check_checkout_page_progress_bar_default_color_display.';
  border-bottom-color: #555555;
  border-left-color: #dcdcdc;}

.arrow-outer:before {
  content: "";
  display: block;
  width: 0;
  height: 0;
  margin-left: 0;
  border-style: solid;
  right: 100%;
  z-index: 2;
  border-color: transparent transparent transparent #fff;
  margin-right: -30px;
  border-width: 41px 0 41px 30px;
  position: absolute;
  top: -6px;
}

.arrow-outer:after {
  content: "";
display: block;
width: 0;
height: 0;
border-style: solid;
margin-left: 0;
position: absolute;
top: 0;
left: 100%;
z-index: 3;
bottom: 0;
border-color: transparent transparent transparent  '.$check_checkout_page_progress_bar_default_color_display.';
border-width: 35px 0 35px 26px;
    }

    #progressbar.arrow li.active {background: '.$check_checkout_page_progress_bar_active_color_display.';}
    li.active .arrow-outer:after {border-color: transparent transparent transparent '.$check_checkout_page_progress_bar_active_color_display.';}

.arrow-text:before {
content: counter(step);
counter-increment: step;
padding-right: 10px;
}
.arrow-text{    margin-top: 21px;
  margin-left: 36px;}

  '.$display_checkout_page_button_default_syle.'
  '.$display_checkout_page_button_icon.'
  '.$display_checkout_page_button_icon_placement.'

  @media (max-width:767px){
#progressbar {display:block;}
  	#progressbar li:after {display:none;}
    .checkout-area {padding:0;}
  }

    @media (max-width:650px){
      	#progressbar li {
    	width: 100% !important;
    	}
'.$checkout_multi_circle_style_dis.'

    }

'.$css_accordian_icon.'

.db_accordian_checkout .et_pb_toggle_open .et_pb_toggle_title {font-size: '.$check_checkout_page_accordian_open_title_font_size.'px; color: '.$check_checkout_page_accordian_open_title_font_color.'; }
.db_accordian_checkout .et_pb_toggle_open {background-color: '.$check_checkout_page_accordian_open_title_background_color.';}

.db_accordian_checkout .et_pb_toggle_close .et_pb_toggle_title {font-size: '.$check_checkout_page_accordian_closed_title_font_size.'px; color: '.$check_checkout_page_accordian_closed_title_font_color.'; }
.db_accordian_checkout .et_pb_toggle_close {background-color: '.$check_checkout_page_accordian_closed_title_background_color.';}


';



$css_woo_bodyshop .= '</style>';
//minify it
$css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
echo $css_woo_bodyshop_min;


}

}

add_action('wp_head','bodycommerce_checkout_css_head');
 ?>
