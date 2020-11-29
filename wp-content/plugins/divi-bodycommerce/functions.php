<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include('titan-framework/titan-framework-embedder.php');

function divi_bodyshop_woocommerce_options() {
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

$get_divi_engine_menu = get_option('divi-engine-menu', null);
if ($get_divi_engine_menu == "" || $get_divi_engine_menu == "bodyshop-woo-added") {
  update_option('divi-engine-menu', 'bodyshop-woo-added');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$icon = plugins_url( 'images/dash-icon.svg', __FILE__ );
$admin_panel2 = $titan->createAdminPanel( array( 'name' => 'Divi Engine', 'capability' => 'edit_pages' , 'icon' => $icon . '' , 'id' => 'divi-engine',) );
$welcometab = $admin_panel2->createTab( array('name' => 'Welcome',) );
$welcometab->createOption( array(
'name' => ''.esc_html__( "Welcome to Divi Engine!", 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );
$welcometab->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( "Firstly we would like to thank you for purchasing one of our plugins! We hope that you find it useful in your web design adventures.", 'divi-bodyshop-woocommerce' ).''
) );

$welcometab->createOption( array(
'name' => ''.esc_html__( "Tech Support", 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );
$welcometab->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'We know from time to time, things may not go to plan due to the number of different setups on WordPress sites.', 'divi-bodyshop-woocommerce' ).'<br>'.esc_html__( 'Dont worry, we are here to help. First take a look at our documentation (see below), if you cannot find a solution, use our support section on our site and we will help you resolve any issues.', 'divi-bodyshop-woocommerce' ).'<br>
<a href="https://diviengine.com/support/" target="_blank"><img style="position: relative;left: 0;top: 12px;width: 200px;transform: translateY(0);" src="'.DE_DB_WOO_URL . '/images/admin-area/support-ticket.png"></a>
  ',
) );

$welcometab->createOption( array(
'name' => ''.esc_html__( "Documentation", 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );
$welcometab->createOption( array(
'type' => 'note',
'desc' => '<h4>'.esc_html__( "We have created documentation for all our plugins - you can read up on them using the links below.", 'divi-bodyshop-woocommerce' ).'</h4>
<a style="text-decoration: none;font-size: 17px;color: #1e136e;font-weight: 500;" href="https://help.diviengine.com/category/36-divi-nitro/" target="_blank"><img style="position:relative;left:0;top:0;transform: translateY(0);width: 50px;" src="'.DE_DB_WOO_URL . '/images/admin-area/divi-nitro-plugin-featured-150x150.png"><span style="position: relative;top: -13px;left: 10px;">'.esc_html__( "Divi Nitro", 'divi-bodyshop-woocommerce' ).'</span></a><br>
<a style="text-decoration: none;font-size: 17px;color: #1e136e;font-weight: 500;" href="https://help.diviengine.com/category/9-divi-bodycommerce" target="_blank"><img style="position:relative;left:0;top:0;transform: translateY(0);width: 50px;" src="'.DE_DB_WOO_URL . '/images/admin-area/divi-bodycommerce-plugin-featured-150x150.png"><span style="position: relative;top: -13px;left: 10px;">'.esc_html__( "Divi BodyCommerce", 'divi-bodyshop-woocommerce' ).'</span></a><br>
<a style="text-decoration: none;font-size: 17px;color: #1e136e;font-weight: 500;" href="https://help.diviengine.com/category/43-divi-protect/" target="_blank"><img style="position:relative;left:0;top:0;transform: translateY(0);width: 50px;" src="'.DE_DB_WOO_URL . '/images/admin-area/divi-protect-plugin-featured-150x150.png"><span style="position: relative;top: -13px;left: 10px;">'.esc_html__( "Divi Protect", 'divi-bodyshop-woocommerce' ).'</span></a><br>
<a style="text-decoration: none;font-size: 17px;color: #1e136e;font-weight: 500;" href="https://help.diviengine.com/category/45-divi-mega-menu/" target="_blank"><img style="position:relative;left:0;top:0;transform: translateY(0);width: 50px;" src="'.DE_DB_WOO_URL . '/images/admin-area/divi-mega-menu-plugin-featured-150x150.png"><span style="position: relative;top: -13px;left: 10px;">'.esc_html__( "Divi Mega Menu", 'divi-bodyshop-woocommerce' ).'</span></a><br>
<h4>'.esc_html__( "Divi Nitro video documentation", 'divi-bodyshop-woocommerce' ).'</h4>
<iframe width="560" height="315" src="https://www.youtube.com/embed/ds_iCldaiwE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<h4>Divi BodyCommerce video documentation</h4>
<iframe width="560" height="315" src="https://www.youtube.com/embed/U9gPHMvQ2Js" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
'
) );
$welcometab->createOption( array(
'name' => ''.esc_html__( "Feedback", 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );
$welcometab->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( "We would love to hear from you, good or bad! We would really appreciate it if you could leave a review on our product page so that it helps others!", 'divi-bodyshop-woocommerce' ).''
) );

$welcometab->createOption( array(
'name' => ''.esc_html__( "Got an idea?", 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );
$welcometab->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( "If you have an idea or would like us to implement a feature that you would benefit from, please dont hesitate to contact us about it", 'divi-bodyshop-woocommerce' ).' <a href="https://diviengine.com/contact/" target="_blank">'.esc_html__( "here", 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( "as we really want to make all our plugins better for everyone!", 'divi-bodyshop-woocommerce' ).''
) );
}
else {
  # code...
}




$boshyshop_woocommerce_settings_admin = $titan->createAdminPanel( array( 'name' => 'BodyCommerce', 'id' => 'divi-bodyshop-woo-settings', 'parent' => 'divi-engine', 'position' => '1') );
$product_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Product Page", 'divi-bodyshop-woocommerce' ).'',) );
$category_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Shop/Category Pages", 'divi-bodyshop-woocommerce' ).'',) );
$tag_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Tags Page", 'divi-bodyshop-woocommerce' ).'',) );
$attribute_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Attribute Archive Page", 'divi-bodyshop-woocommerce' ).'',) );

$my_account_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Account Pages", 'divi-bodyshop-woocommerce' ).'',) );
$login_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Login Page", 'divi-bodyshop-woocommerce' ).'',) );
$cart_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Cart Page", 'divi-bodyshop-woocommerce' ).'',) );
$checkout_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Checkout Page", 'divi-bodyshop-woocommerce' ).'',) );
$search_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Search Results Page", 'divi-bodyshop-woocommerce' ).'',) );
$thakyou_page = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Thank You Page", 'divi-bodyshop-woocommerce' ).'',) );
$email_templates = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Email Template", 'divi-bodyshop-woocommerce' ).'',) );
$mini_cart = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Mini Cart/Pop Up Settings", 'divi-bodyshop-woocommerce' ).'',) );
$cart_icon = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Cart Icon Settings", 'divi-bodyshop-woocommerce' ).'',) );
$sale_badge = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Sale/New/Free Badge", 'divi-bodyshop-woocommerce' ).'',) );
$variation_swatches = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Variation Swatches", 'divi-bodyshop-woocommerce' ).'',) );
$sharing_icons = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Sharing Icons", 'divi-bodyshop-woocommerce' ).'',) );
$pagination = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Pagination", 'divi-bodyshop-woocommerce' ).'',) );

$order_bump = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Order Bump", 'divi-bodyshop-woocommerce' ).'',) );
$settings = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Settings", 'divi-bodyshop-woocommerce' ).'',) );

$licensestab = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "License", 'divi-bodyshop-woocommerce' ).'',) );
$divienginesettings = $boshyshop_woocommerce_settings_admin->createTab( array('name' => ''.esc_html__( "Divi Engine Settings", 'divi-bodyshop-woocommerce' ).'',) );

$boshyshop_settings_mods = $titan->createAdminPanel( array( 'name' => ''.esc_html__( "BodyCommerce Mods", 'divi-bodyshop-woocommerce' ).'', 'id' => 'divi-bodycommerce-mods', 'parent' => 'divi-engine', 'position' => '2') );
$other_settings_global = $boshyshop_settings_mods->createTab( array('name' => ''.esc_html__( "Global Mods", 'divi-bodyshop-woocommerce' ).'',) );
$other_settings_archive = $boshyshop_settings_mods->createTab( array('name' => ''.esc_html__( "Archive Page Mods", 'divi-bodyshop-woocommerce' ).'',) );
$other_settings_single = $boshyshop_settings_mods->createTab( array('name' => ''.esc_html__( "Single Page Mods", 'divi-bodyshop-woocommerce' ).'',) );
$other_settings_user = $boshyshop_settings_mods->createTab( array('name' => ''.esc_html__( "User/Customer Mods", 'divi-bodyshop-woocommerce' ).'',) );
$other_settings_checkout = $boshyshop_settings_mods->createTab( array('name' => ''.esc_html__( "Checkout Mods", 'divi-bodyshop-woocommerce' ).'',) );
$other_settings_admin = $boshyshop_settings_mods->createTab( array('name' => ''.esc_html__( "Admin Dash Mods", 'divi-bodyshop-woocommerce' ).'',) );
$other_settings_form_field = $boshyshop_settings_mods->createTab( array('name' => ''.esc_html__( "Form Field Customizer", 'divi-bodyshop-woocommerce' ).'',) );
$other_settings_shortcodes = $boshyshop_settings_mods->createTab( array('name' => ''.esc_html__( "Shortcodes", 'divi-bodyshop-woocommerce' ).'',) );
$other_settings_custom_code = $boshyshop_settings_mods->createTab( array('name' => ''.esc_html__( "Custom CSS/JS", 'divi-bodyshop-woocommerce' ).'',) );

$pagination->createOption( array(
'type' => 'save',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( 'Enable Custom Pagination', 'divi-bodyshop-woocommerce' ).'',
'id' => 'enable_custom_pagination',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to use our custom pagination, enable this.', 'divi-bodyshop-woocommerce' ).'',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( 'Pagination style', 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_style',
'type' => 'radio-image',
'options' => array(
'p1' => DE_DB_WOO_URL . '/images/pagination/p1.JPG',
'p2' => DE_DB_WOO_URL . '/images/pagination/p2.JPG',
'p3' => DE_DB_WOO_URL . '/images/pagination/p3.JPG',
'p4' => DE_DB_WOO_URL . '/images/pagination/p4.JPG',
'p5' => DE_DB_WOO_URL . '/images/pagination/p5.JPG',
'p6' => DE_DB_WOO_URL . '/images/pagination/p6.JPG',
'p7' => DE_DB_WOO_URL . '/images/pagination/p7.JPG',
'p8' => DE_DB_WOO_URL . '/images/pagination/p8.JPG',
'p9' => DE_DB_WOO_URL . '/images/pagination/p9.JPG',
'p10' => DE_DB_WOO_URL . '/images/pagination/p10.JPG',
'p11' => DE_DB_WOO_URL . '/images/pagination/p11.JPG',
),
'default' => 'p1',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Next/Previous Style", 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_nextprev_style',
'type' => 'select',
'options' => array(
'text' => ''.esc_html__( "Text", 'divi-bodyshop-woocommerce' ).'',
'arrows' => ''.esc_html__( "Arrows", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'text',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Pagination primary color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_primary_color',
'type' => 'color',
'default' => '#1d0d6f',
'alpha'  => 'true',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Pagination primary color hover", 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_primary_color_hover',
'type' => 'color',
'default' => '#100051',
'alpha'  => 'true',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Pagination secondary color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_secondary_color',
'type' => 'color',
'default' => 'rgba(29,13,111,0.6)',
'alpha'  => 'true',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Text color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_text_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Active text color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_active_text_color',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Arrow color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_arrow_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Previous text", 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_prev_text',
'type' => 'text',
'default' => "prev",
'desc' => ''.esc_html__( "If you are using text and not arrows, change what it says here.", 'divi-bodyshop-woocommerce' ).'',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Next Text", 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_next_text',
'type' => 'text',
'default' => "next",
'desc' => ''.esc_html__( "If you are using text and not arrows, change what it says here.", 'divi-bodyshop-woocommerce' ).'',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Previous Icon", 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_prev_icon',
'type' => 'text',
'default' => "34",
'desc' => ''.esc_html__( 'Enter in the number for the divi icon - You can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">'.esc_html__( 'HERE.', 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( 'Just scroll down till you see the icons and some letter below. <br>Copy the numbers and letters that appear after "x". ', 'divi-bodyshop-woocommerce' ).'<br>'.esc_html__( 'So', 'divi-bodyshop-woocommerce' ).' "&amp;#x21;" - '.esc_html__( 'copy just the "21".', 'divi-bodyshop-woocommerce' ).' <br>"&amp;#xe016;" - '.esc_html__( 'copy the "e016"', 'divi-bodyshop-woocommerce' ).'',
) );

$pagination->createOption( array(
'name' => ''.esc_html__( "Next Icon", 'divi-bodyshop-woocommerce' ).'',
'id' => 'pagination_next_icon',
'type' => 'text',
'default' => "35",
'desc' => ''.esc_html__( 'Enter in the number for the divi icon - You can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">'.esc_html__( 'HERE.', 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( 'Just scroll down till you see the icons and some letter below. <br>Copy the numbers and letters that appear after "x". ', 'divi-bodyshop-woocommerce' ).'<br>'.esc_html__( 'So', 'divi-bodyshop-woocommerce' ).' "&amp;#x21;" - '.esc_html__( 'copy just the "21".', 'divi-bodyshop-woocommerce' ).' <br>"&amp;#xe016;" - '.esc_html__( 'copy the "e016"', 'divi-bodyshop-woocommerce' ).'',
) );

$pagination->createOption( array(
'type' => 'save',
) );

$sharing_icons->createOption( array(
'type' => 'save',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( 'Sharing icon style', 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_style',
'type' => 'radio-image',
'options' => array(
'none' => DE_DB_WOO_URL . '/images/sharing-icons/none.JPG',
'button' => DE_DB_WOO_URL . '/images/sharing-icons/buttons.JPG',
'icons' => DE_DB_WOO_URL . '/images/sharing-icons/icons.JPG',
),
'default' => 'none',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( 'text before', 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_text_before',
'type' => 'text',
'default' => 'Share on',
'desc' => ''.esc_html__( 'Enter in the text you want shown before the icons', 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( "Enable Twitter", 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_twitter',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( "Enable Facebook", 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_facebook',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( "Enable LinkedIn", 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_linkedin',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( "Enable Pinterest", 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_pinterest',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( "Enable Whatsapp", 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_whatsapp',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( "Enable Email", 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_email',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( "Enable Print", 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_print',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( 'Email Subject (before product name)', 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_email_subject',
'type' => 'text',
'default' => 'Check out this product - ',
'desc' => ''.esc_html__( 'Enter in the text you want shown before the subject when sharing via email', 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( 'Email Body (before product link)', 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_email_body',
'type' => 'text',
'default' => 'Take a look at the product out this site: ',
'desc' => ''.esc_html__( 'Enter in the text you want shown before the link on the body when sharing via email', 'divi-bodyshop-woocommerce' ).'',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( "Text/Icon color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_btn_color',
'type' => 'color',
'default' => '#ffffff',
'desc' => ''.esc_html__( "Set the color of the text or icon", 'divi-bodyshop-woocommerce' ).'',
'alpha'  => 'true',
) );

$sharing_icons->createOption( array(
'name' => ''.esc_html__( "Button border radius", 'divi-bodyshop-woocommerce' ).'',
'id' => 'sharing_icon_btn_border_radius',
'type' => 'number',
'default' => '5',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$sharing_icons->createOption( array(
'type' => 'save',
) );





$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Below are some settings for you to customise the form fields on your site such as the quantity or select boxes, this will change it globally.", 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );


$other_settings_form_field->createOption( array(
'type' => 'save',
) );

$other_settings_form_field->createOption( array(
'type' => 'note',
'desc' => '<p class="title">Input/Textbox Field</p>'
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Enable custom input/textbox field", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_field',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( "If you would like to have a custom look for your select drop down fields - enable this.", 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Disable Placeholders", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_field_placeholder',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( "If you want to remove the labels of the inputs and instead move them to be placeholders, enable this.", 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Background color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_background_color',
'type' => 'color',
'default' => 'rgba(255,255,255,0)',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Text color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_text_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Placeholder Text color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_placeholder_text_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Font size", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_font_size',
'type' => 'number',
'desc' => ''.esc_html__( "Set the size of the text in the input.", 'divi-bodyshop-woocommerce' ).'',
'default' => '16',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Padding top", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_pad_top',
'type' => 'number',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Padding bottom", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_pad_bottom',
'type' => 'number',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Padding right", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_pad_right',
'type' => 'number',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Padding left", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_pad_left',
'type' => 'number',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input border style", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_border_style',
'type' => 'select',
'desc' => ''.esc_html__( "If you want a border - select the style here.", 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'none' => ''.esc_html__( "None", 'divi-bodyshop-woocommerce' ).'',
'dotted' => ''.esc_html__( "Dotted", 'divi-bodyshop-woocommerce' ).'',
'dashed' => ''.esc_html__( "Dashed", 'divi-bodyshop-woocommerce' ).'',
'solid' => ''.esc_html__( "Solid", 'divi-bodyshop-woocommerce' ).'',
'double' => ''.esc_html__( "Double", 'divi-bodyshop-woocommerce' ).'',
'groove' => ''.esc_html__( "Groove", 'divi-bodyshop-woocommerce' ).'',
'ridge' => ''.esc_html__( "Ridge", 'divi-bodyshop-woocommerce' ).'',
'inset' => ''.esc_html__( "Inset", 'divi-bodyshop-woocommerce' ).'',
'outset' => ''.esc_html__( "Outset", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'none',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input border size", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_border_size',
'type' => 'number',
'desc' => ''.esc_html__( "Set the size of the border.", 'divi-bodyshop-woocommerce' ).'',
'default' => '1',
'min' => '1',
'max' => '20',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input border color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_border_color',
'type' => 'color',
'default' => 'rgba(255,255,255,0)',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input invalid border color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_error_border_color',
'type' => 'color',
'default' => '#dd3333',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input valid border color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_valid_border_color',
'type' => 'color',
'default' => '#59d600',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input border radius", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_input_border_radius',
'type' => 'number',
'desc' => ''.esc_html__( "Set the radius of the border.", 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '0',
'max' => '20',
'step' => '1',
'unit' => 'px',
) );





$other_settings_form_field->createOption( array(
'type' => 'note',
'desc' => '<p class="title">Quantity Field</p>'
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Enable custom quantity field", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_quantity_field',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( "If you would like to have a custom look for your quantity field - enable this.", 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Quantity style", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_style',
'type' => 'select',
'desc' => ''.esc_html__( "Select where you want the quantity icons to be", 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'leftright' => ''.esc_html__( "Horizontally left and right of number", 'divi-bodyshop-woocommerce' ).'',
// 'topbottom' => ''.esc_html__( "Vertically on the side of the number", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'leftright',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Width", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_width',
'type' => 'number',
'desc' => ''.esc_html__( "Set the width of the quantity box.", 'divi-bodyshop-woocommerce' ).'',
'default' => '100',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => '%',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Max Width", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_max_width',
'type' => 'number',
'desc' => ''.esc_html__( "Set the max width of the quantity box.", 'divi-bodyshop-woocommerce' ).'',
'default' => '110',
'min' => '1',
'max' => '500',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Background color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_background_color',
'type' => 'color',
'default' => 'rgba(255,255,255,0)',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Number color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_number_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( 'Minus icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_minus_icon',
'type' => 'text',
'default' => '4b',
'desc' => ''.esc_html__( 'Enter in the number for the divi icon - You can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">'.esc_html__( 'HERE.', 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( 'Just scroll down till you see the icons and some letter below. <br>Copy the numbers and letters that appear after "x". ', 'divi-bodyshop-woocommerce' ).'<br>'.esc_html__( 'So', 'divi-bodyshop-woocommerce' ).' "&amp;#x21;" - '.esc_html__( 'copy just the "21".', 'divi-bodyshop-woocommerce' ).' <br>"&amp;#xe016;" - '.esc_html__( 'copy the "e016"', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Minus icon color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_number_minus_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Minus icon size", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_number_minus_size',
'type' => 'number',
'desc' => ''.esc_html__( "Set the size of the icon.", 'divi-bodyshop-woocommerce' ).'',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( 'Plus icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_add_icon',
'type' => 'text',
'default' => '4c',
'desc' => ''.esc_html__( 'Enter in the number for the divi icon - You can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">'.esc_html__( 'HERE.', 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( 'Just scroll down till you see the icons and some letter below. <br>Copy the numbers and letters that appear after "x". ', 'divi-bodyshop-woocommerce' ).'<br>'.esc_html__( 'So', 'divi-bodyshop-woocommerce' ).' "&amp;#x21;" - '.esc_html__( 'copy just the "21".', 'divi-bodyshop-woocommerce' ).' <br>"&amp;#xe016;" - '.esc_html__( 'copy the "e016"', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Plus icon color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_number_add_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Plus icon size", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_number_add_size',
'type' => 'number',
'desc' => ''.esc_html__( "Set the size of the icon.", 'divi-bodyshop-woocommerce' ).'',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Quantity border style", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_border_style',
'type' => 'select',
'desc' => ''.esc_html__( "If you want a border - select the style here.", 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'none' => ''.esc_html__( "None", 'divi-bodyshop-woocommerce' ).'',
'dotted' => ''.esc_html__( "Dotted", 'divi-bodyshop-woocommerce' ).'',
'dashed' => ''.esc_html__( "Dashed", 'divi-bodyshop-woocommerce' ).'',
'solid' => ''.esc_html__( "Solid", 'divi-bodyshop-woocommerce' ).'',
'double' => ''.esc_html__( "Double", 'divi-bodyshop-woocommerce' ).'',
'groove' => ''.esc_html__( "Groove", 'divi-bodyshop-woocommerce' ).'',
'ridge' => ''.esc_html__( "Ridge", 'divi-bodyshop-woocommerce' ).'',
'inset' => ''.esc_html__( "Inset", 'divi-bodyshop-woocommerce' ).'',
'outset' => ''.esc_html__( "Outset", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'none',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Quantity border size", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_border_size',
'type' => 'number',
'desc' => ''.esc_html__( "Set the size of the border.", 'divi-bodyshop-woocommerce' ).'',
'default' => '1',
'min' => '1',
'max' => '20',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Quantity border color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_border_color',
'type' => 'color',
'default' => 'rgba(255,255,255,0)',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Quantity border radius", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_border_radius',
'type' => 'number',
'desc' => ''.esc_html__( "Set the radius of the border.", 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '0',
'max' => '20',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Quantity width", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_border_width',
'type' => 'number',
'default' => '1',
'min' => '0',
'max' => '20',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Quantity height", 'divi-bodyshop-woocommerce' ).'',
'id' => 'quantity_border_height',
'type' => 'number',
'default' => '0',
'min' => '0',
'max' => '500',
'desc' => ''.esc_html__( "Set the height of the quantity box - set as 0 to not have a set height", 'divi-bodyshop-woocommerce' ).'',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'type' => 'note',
'desc' => '<p class="title">Select Drop Down Field</p>'
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Enable custom select field", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_field',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( "If you would like to have a custom look for your select drop down fields - enable this.", 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Disable Select2", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_field_select2',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( "If you have a custom select box on checkout for example, select2 will render it differently so enable this to keep it consistent (and it will speed up your site as will remove some scripts)", 'divi-bodyshop-woocommerce' ).'',
) );


$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Background color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_background_color',
'type' => 'color',
'default' => 'rgba(255,255,255,0)',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Text color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_text_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Font size", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_font_size',
'type' => 'number',
'desc' => ''.esc_html__( "Set the size of the text in the input.", 'divi-bodyshop-woocommerce' ).'',
'default' => '16',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Padding top", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_pad_top',
'type' => 'number',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Padding bottom", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_pad_bottom',
'type' => 'number',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Padding right", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_pad_right',
'type' => 'number',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Padding left", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_pad_left',
'type' => 'number',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input border style", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_border_style',
'type' => 'select',
'desc' => ''.esc_html__( "If you want a border - select the style here.", 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'none' => ''.esc_html__( "None", 'divi-bodyshop-woocommerce' ).'',
'dotted' => ''.esc_html__( "Dotted", 'divi-bodyshop-woocommerce' ).'',
'dashed' => ''.esc_html__( "Dashed", 'divi-bodyshop-woocommerce' ).'',
'solid' => ''.esc_html__( "Solid", 'divi-bodyshop-woocommerce' ).'',
'double' => ''.esc_html__( "Double", 'divi-bodyshop-woocommerce' ).'',
'groove' => ''.esc_html__( "Groove", 'divi-bodyshop-woocommerce' ).'',
'ridge' => ''.esc_html__( "Ridge", 'divi-bodyshop-woocommerce' ).'',
'inset' => ''.esc_html__( "Inset", 'divi-bodyshop-woocommerce' ).'',
'outset' => ''.esc_html__( "Outset", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'none',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input border size", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_border_size',
'type' => 'number',
'desc' => ''.esc_html__( "Set the size of the border.", 'divi-bodyshop-woocommerce' ).'',
'default' => '1',
'min' => '1',
'max' => '20',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input border color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_border_color',
'type' => 'color',
'default' => 'rgba(255,255,255,0)',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Input border radius", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_border_radius',
'type' => 'number',
'desc' => ''.esc_html__( "Set the radius of the border.", 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '0',
'max' => '20',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( 'Select icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_icon',
'type' => 'text',
'default' => '33',
'desc' => ''.esc_html__( 'Enter in the number for the divi icon - You can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">'.esc_html__( 'HERE.', 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( 'Just scroll down till you see the icons and some letter below. <br>Copy the numbers and letters that appear after "x". ', 'divi-bodyshop-woocommerce' ).'<br>'.esc_html__( 'So', 'divi-bodyshop-woocommerce' ).' "&amp;#x21;" - '.esc_html__( 'copy just the "21".', 'divi-bodyshop-woocommerce' ).' <br>"&amp;#xe016;" - '.esc_html__( 'copy the "e016"', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Icon color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Icon size", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_icon_size',
'type' => 'number',
'desc' => ''.esc_html__( "Set the size of the icon.", 'divi-bodyshop-woocommerce' ).'',
'default' => '18',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Icon distance from right", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_dis_right',
'type' => 'number',
'desc' => ''.esc_html__( "Change how far away from the right you want the icon", 'divi-bodyshop-woocommerce' ).'',
'default' => '6',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Icon background color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_icon_background_color',
'type' => 'color',
'default' => 'rgba(255,255,255,0)',
'alpha'  => 'true',
) );

$other_settings_form_field->createOption( array(
'name' => ''.esc_html__( "Icon background width", 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_select_icon_background_width',
'type' => 'number',
'default' => '40',
'min' => '1',
'max' => '150',
'step' => '1',
'unit' => 'px',
) );



$other_settings_form_field->createOption( array(
'type' => 'save',
) );


$other_settings_custom_code->createOption( array(
'name' => ''.esc_html__( "Add some custom CSS/JS (great when exporting/importing settings)", 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );

$other_settings_custom_code->createOption( array(
    'name' => ''.esc_html__( "Custom CSS", 'divi-bodyshop-woocommerce' ).'',
    'id' => 'bodycommerce_custom_css',
    'type' => 'code',
    'desc' => ''.esc_html__( "Put your custom CSS rules here. Do not put <style> tags as we will do this for you. We will automatically minify your CSS so no need to minify it here.", 'divi-bodyshop-woocommerce' ).'',
    'lang' => 'css',
) );


$other_settings_custom_code->createOption( array(
    'name' => ''.esc_html__( "Custom JavaScript", 'divi-bodyshop-woocommerce' ).'',
    'id' => 'bodycommerce_custom_js',
    'type' => 'code',
    'desc' => ''.esc_html__( "Put your additional javascript rules here. Dont forget to add your <script> tags as this allows you to add multiple for yourself.", 'divi-bodyshop-woocommerce' ).'',
    'lang' => 'javascript',
) );

$other_settings_custom_code->createOption( array(
'type' => 'save',
) );


$other_settings_shortcodes->createOption( array(
'name' => ''.esc_html__( "Below is a list of shortcodes you can use on your site - click to copy the shortcode and paste it in the text or code module to display it", 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );

$other_settings_shortcodes->createOption( array(
'type' => 'note',
'desc' => '<h3 class="shortcodetitle">'.esc_html__( "Cart Icon:", 'divi-bodyshop-woocommerce' ).'</h3>'.esc_html__( " Displays the Cart/Basket icon", 'divi-bodyshop-woocommerce' ).'<pre data-shortcode="bodycommerce_cart_icon">[bodycommerce_cart_icon]<span class="hover-tooltip">'.esc_html__( "Click to copy", 'divi-bodyshop-woocommerce' ).'</span></pre>'
) );

$other_settings_shortcodes->createOption( array(
'type' => 'note',
'desc' => '<h3 class="shortcodetitle">'.esc_html__( "Product Reviews:", 'divi-bodyshop-woocommerce' ).'</h3>'.esc_html__( " Displays the product reviews module", 'divi-bodyshop-woocommerce' ).' <pre data-shortcode="bodycommerce_reviews">[bodycommerce_reviews]<span class="hover-tooltip">'.esc_html__( "Click to copy", 'divi-bodyshop-woocommerce' ).'</span></pre>'
) );

$other_settings_shortcodes->createOption( array(
'type' => 'note',
'desc' => '<h3 class="shortcodetitle">'.esc_html__( "User Name:", 'divi-bodyshop-woocommerce' ).'</h3>'.esc_html__( " Displays the customers user name", 'divi-bodyshop-woocommerce' ).' <pre data-shortcode="db_woo_get_name">[db_woo_get_name]<span class="hover-tooltip">'.esc_html__( "Click to copy", 'divi-bodyshop-woocommerce' ).'</span></pre>'
) );

$other_settings_shortcodes->createOption( array(
'type' => 'note',
'desc' => '<h3 class="shortcodetitle">'.esc_html__( "Product Attribute:", 'divi-bodyshop-woocommerce' ).'</h3>'.esc_html__( ' Displays all attrubutes or chosen ones. ', 'divi-bodyshop-woocommerce' ).' <pre data-shortcode="bc_display_attributes">[bc_display_attributes]<span class="hover-tooltip">'.esc_html__( "Click to copy", 'divi-bodyshop-woocommerce' ).'</span></pre><br>
'.esc_html__( 'You can modify the shortcode to show a specific attribute by using [bc_display_attributes attributes="color|size"] as an example. show multiple by seperating with | or one by only adding one', 'divi-bodyshop-woocommerce' ).''
) );

$other_settings_shortcodes->createOption( array(
'type' => 'note',
'desc' => '<h3 class="shortcodetitle">'.esc_html__( "Rating Stars Single Page:", 'divi-bodyshop-woocommerce' ).'</h3>'.esc_html__( " Displays the rating stars shown on the single product page", 'divi-bodyshop-woocommerce' ).' <pre data-shortcode="bodycommerce_single_rating_stars">[bodycommerce_single_rating_stars]<span class="hover-tooltip">'.esc_html__( "Click to copy", 'divi-bodyshop-woocommerce' ).'</span></pre>'
) );

$other_settings_shortcodes->createOption( array(
'type' => 'note',
'desc' => '<h3 class="shortcodetitle">'.esc_html__( "Rating Stars Category Page:", 'divi-bodyshop-woocommerce' ).'</h3>'.esc_html__( " Displays the rating stars shown on the category page", 'divi-bodyshop-woocommerce' ).' <pre data-shortcode="bodycommerce_category_rating_stars">[bodycommerce_category_rating_stars]<span class="hover-tooltip">'.esc_html__( "Click to copy", 'divi-bodyshop-woocommerce' ).'</span></pre>'
) );

$other_settings_shortcodes->createOption( array(
'type' => 'note',
'desc' => '<h3 class="shortcodetitle">'.esc_html__( "Product Description:", 'divi-bodyshop-woocommerce' ).'</h3>'.esc_html__( " Displays the product full description", 'divi-bodyshop-woocommerce' ).' <pre data-shortcode="bodycommerce_description">[bodycommerce_description]<span class="hover-tooltip">'.esc_html__( "Click to copy", 'divi-bodyshop-woocommerce' ).'</span></pre>'
) );

$divienginesettings->createOption( array(
'name' => 'Login Style',
'id' => 'divi_specific_login',
'type' => 'select',
'options' => array(
'lostpasswordabove' => 'Lost password above',
'defalut' => 'Defalut',
),
'default' => 'Defalut',
) );

$divienginesettings->createOption( array(
'name' => 'Checkout Style',
'id' => 'divi_specific_checkout',
'type' => 'select',
'options' => array(
'divienginestyle' => 'Divi Engine Style',
'defalut' => 'defalut',
),
'default' => 'defalut',
) );

$divienginesettings->createOption( array(
'type' => 'save',
) );


// VARIATION SWATCHES

$variation_swatches->createOption( array(
'type' => 'save',
) );



$variation_swatches->createOption( array(
  'name' => ''.esc_html__( 'Main Settings', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'heading',
  ) );


$variation_swatches->createOption( array(
'name' => ''.esc_html__( 'Enable Vairation Swatches', 'divi-bodyshop-woocommerce' ).'',
'id' => 'enable_variation_swatches',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to use our variation swatches, enable this.', 'divi-bodyshop-woocommerce' ).'',
) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Variation Style", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_style',
'type' => 'select',
'desc' => ''.esc_html__( "Select the way you want the variation fields to appear.", 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'square' => ''.esc_html__( "Square", 'divi-bodyshop-woocommerce' ).'',
'circle' => ''.esc_html__( "Circle", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'square',
) );

$variation_swatches->createOption( array(
  'name' => ''.esc_html__( "Enable active swatch name", 'divi-bodyshop-woocommerce' ).'',
  'id' => 'variation_swatch_label_text',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
  'desc' => ''.esc_html__( "If you want to have the text of the selected option appear after the label, enable this. For example if you have the label 'Colour', it will be 'Colour Blue' when you select the blue option", 'divi-bodyshop-woocommerce' ).'',
  ) );
  
  $variation_swatches->createOption( array(
  'name' => ''.esc_html__( "Text between label and active swatch name", 'divi-bodyshop-woocommerce' ).'',
  'id' => 'variation_text_between_swatch_label_text',
  'type' => 'text',
  'default' => "",
  'desc' => ''.esc_html__( "If you want some text to appear between, for example you could have the text 'chosen is:' and it will say 'Colour chosen is: Blue' for example.", 'divi-bodyshop-woocommerce' ).'',
  ) );


$variation_swatches->createOption( array(
  'name' => ''.esc_html__( 'Label Variation Type', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'heading',
  ) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Label Width", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_label_width',
'type' => 'number',
'desc' => ''.esc_html__( "Set how wide you want the label to be.", 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '500',
'step' => '1',
'unit' => 'px',
) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Label Height", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_label_height',
'type' => 'number',
'desc' => ''.esc_html__( "Set how high you want the label to be.", 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '500',
'step' => '1',
'unit' => 'px',
) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Label background color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_label_background_color',
'type' => 'color',
'default' => 'rgba(255,255,255,0)',
'alpha'  => 'true',
) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Label text color", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_label_text_color',
'type' => 'color',
'default' => '#000',
'alpha'  => 'true',
) );


$variation_swatches->createOption( array(
  'name' => ''.esc_html__( 'Colour Variation Type', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'heading',
  ) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Colour Width", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_color_width',
'type' => 'number',
'desc' => ''.esc_html__( "Set how wide you want the color to be.", 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '500',
'step' => '1',
'unit' => 'px',
) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Colour Height", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_color_height',
'type' => 'number',
'desc' => ''.esc_html__( "Set how high you want the color to be.", 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '500',
'step' => '1',
'unit' => 'px',
) );






$variation_swatches->createOption( array(
  'name' => ''.esc_html__( 'Image Variation Type', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'heading',
  ) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Image Width", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_image_width',
'type' => 'number',
'desc' => ''.esc_html__( "Set how wide you want the image to be.", 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '500',
'step' => '1',
'unit' => 'px',
) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Image Height", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_image_hieght',
'type' => 'number',
'desc' => ''.esc_html__( "Set how high you want the image to be.", 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '500',
'step' => '1',
'unit' => 'px',
) );


$variation_swatches->createOption( array(
  'name' => ''.esc_html__( 'Out of Stock Settings', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'heading',
  ) );

$variation_swatches->createOption( array(
'name' => ''.esc_html__( "Out Of Stock Strike Through?", 'divi-bodyshop-woocommerce' ).'',
'id' => 'variation_striketrhough',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( "If you would like your out of stock button variant swatches to not be clickable and have a line through them (diagonally) - enable this", 'divi-bodyshop-woocommerce' ).'',
) );

$variation_swatches->createOption( array(
  'name' => ''.esc_html__( "Out Of Stock hide?", 'divi-bodyshop-woocommerce' ).'',
  'id' => 'variation_hide_ofs',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( "YES", 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( "NO", 'divi-bodyshop-woocommerce' ).'',
  'desc' => ''.esc_html__( "If you want to hide the options that are not available when selecting a variation, enable this", 'divi-bodyshop-woocommerce' ).'',
  ) );

	$variation_swatches->createOption( array(
		'name' => ''.esc_html__( "Ajax variation threshold amount", 'divi-bodyshop-woocommerce' ).'',
		'id' => 'variation_ajax_threshold_amount',
		'type' => 'number',
		'default' => '100',
		'desc' => ''.esc_html__( "If variations of product is more than this value, please increase this value.", 'divi-bodyshop-woocommerce' ).'',
	) );

$variation_swatches->createOption( array(
  'name' => ''.esc_html__( 'Appearance', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'heading',
  ) );

  $variation_swatches->createOption( array(
    'name' => ''.esc_html__( "Choose active style", 'divi-bodyshop-woocommerce' ).'',
    'id' => 'variation_swatch_active_colour',
    'type' => 'select',
    'desc' => ''.esc_html__( 'Choose how you want the active colour to show when you select it - you can make the others fade out or a border for example.', 'divi-bodyshop-woocommerce' ).'',
    'options' => array(
    'fade' => ''.esc_html__( "Fade out not active", 'divi-bodyshop-woocommerce' ).'',
    'border' => ''.esc_html__( "Add border on active", 'divi-bodyshop-woocommerce' ).'',
    ),
    'default' => 'fade',
    ) );
    
    $variation_swatches->createOption( array(
    'name' => ''.esc_html__( "If border - Border colour", 'divi-bodyshop-woocommerce' ).'',
    'id' => 'variation_label_colour_border_colour_normal',
    'type' => 'color',
    'default' => 'rgba(0,0,0,0)',
    'alpha'  => 'true',
    ) );
    
    $variation_swatches->createOption( array(
    'name' => ''.esc_html__( "If border - Border inside colour", 'divi-bodyshop-woocommerce' ).'',
    'id' => 'variation_label_colour_border_inside_colour_normal',
    'type' => 'color',
    'default' => 'rgba(0,0,0,0)',
    'alpha'  => 'true',
    ) );
    
    $variation_swatches->createOption( array(
    'name' => ''.esc_html__( "If border - Active Border colour", 'divi-bodyshop-woocommerce' ).'',
    'id' => 'variation_label_colour_border_colour',
    'type' => 'color',
    'default' => '#000',
    'alpha'  => 'true',
    ) );
    
    $variation_swatches->createOption( array(
    'name' => ''.esc_html__( "If border - Active Border inside colour", 'divi-bodyshop-woocommerce' ).'',
    'id' => 'variation_label_colour_border_inside_colour',
    'type' => 'color',
    'default' => '#fff',
    'alpha'  => 'true',
    ) );
    
    $variation_swatches->createOption( array(
    'name' => ''.esc_html__( "If border - Border width", 'divi-bodyshop-woocommerce' ).'',
    'id' => 'variation_label_colour_border_width',
    'type' => 'number',
    'default' => '2',
    'min' => '0',
    'max' => '10',
    'step' => '1',
    'unit' => 'px',
    ) );

$variation_swatches->createOption( array(
'type' => 'save',
) );


// ORDER BUMP


$order_bump->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( "BodyCommerce Order Bump", 'divi-bodyshop-woocommerce' ).'</p>'
) );

$order_bump->createOption( array(
'name' => ''.esc_html__( 'Enable Order Bump', 'divi-bodyshop-woocommerce' ).'',
'id' => 'order_bump_enable',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to use our order bump, enable this.', 'divi-bodyshop-woocommerce' ).'',
) );


$order_bump->createOption( array(
'name' => ''.esc_html__( "Product Type to show", 'divi-bodyshop-woocommerce' ).'',
'id' => 'order_bump_product_type',
'type' => 'select',
'desc' => ''.esc_html__( 'Choose what product you want to show at checkout.', 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'specific' => ''.esc_html__( "Specific Product (choose below)", 'divi-bodyshop-woocommerce' ).'',
'upsell' => ''.esc_html__( "First Up-Sell Product", 'divi-bodyshop-woocommerce' ).'',
'crosssell' => ''.esc_html__( "First Cross-Sell Product", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'specific',
) );

$order_bump->createOption( array(
'name' => ''.esc_html__( 'Specific Product', 'divi-bodyshop-woocommerce' ).'',
 'id' => 'order_bump_product',
 'type' => 'select-posts',
 'desc' => ''.esc_html__( 'If you want to show a specific product, choose it here', 'divi-bodyshop-woocommerce' ).'',
 'post_type' => 'product',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['order_bump_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['order_bump_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$order_bump->createOption( array(
'name' => ''.esc_html__( 'Select Order Bump Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'order_bump_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Please choose the template for your order bump.', 'divi-bodyshop-woocommerce' ).'',
) );


$order_bump->createOption( array(
'name' => ''.esc_html__( 'Percentage Off', 'divi-bodyshop-woocommerce' ).'',
'id' => 'order_bump_percentage',
'type' => 'number',
'desc' => ''.esc_html__( 'Set the percentage you want the customer to get off the order bump', 'divi-bodyshop-woocommerce' ).'',
'default' => '30',
'min' => '0',
'max' => '100',
'step' => '1',
'unit' => '%',
) );

$order_bump->createOption( array(
'name' => ''.esc_html__( "Order Bump Position", 'divi-bodyshop-woocommerce' ).'',
'id' => 'order_bump_product_postion',
'type' => 'select',
'desc' => ''.esc_html__( 'Choose where you want it to display on the checkout page.', 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'woocommerce_before_checkout_form' => ''.esc_html__( "Before Checkout Form", 'divi-bodyshop-woocommerce' ).'',
'woocommerce_checkout_after_order_review' => ''.esc_html__( "After Order Review", 'divi-bodyshop-woocommerce' ).'',
'woocommerce_review_order_before_payment' => ''.esc_html__( "Before Payment", 'divi-bodyshop-woocommerce' ).'',
'woocommerce_review_order_after_payment' => ''.esc_html__( "After Payment", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'woocommerce_review_order_before_payment',
) );

$order_bump->createOption( array(
'name' => ''.esc_html__( 'Order Bump Suffix', 'divi-bodyshop-woocommerce' ).'',
'id' => 'order_bump_suffix',
'type' => 'text',
'desc' => ''.esc_html__( 'If you want to have some text after the product name to identify which product has been added to cart, add it here', 'divi-bodyshop-woocommerce' ).'',
) );

$order_bump->createOption( array(
'type' => 'save',
) );

// SETTINGS

$settings->createOption( array(
'type' => 'save',
) );




$settings->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( "BodyCommerce Frontend Scripts", 'divi-bodyshop-woocommerce' ).'</p>'
) );

$settings->createOption( array(
'name' => ''.esc_html__( "Ajax Add To Cart Jquery Method", 'divi-bodyshop-woocommerce' ).'',
'id' => 'ajax_atc_js_method_1',
'type' => 'select',
'desc' => ''.esc_html__( 'Select the way you want the ajax add to cart to work. The default should work on most sites but for some that have other ways to changing the qunaitity field, the "dynamic version" will check for an update of the quantity field every half a second.', 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'1' => ''.esc_html__( "Original", 'divi-bodyshop-woocommerce' ).'',
'2' => ''.esc_html__( "Dynamic", 'divi-bodyshop-woocommerce' ).'',
),
'default' => '1',
) );

$settings->createOption( array(
'name' => ''.esc_html__( "Main CSS Method", 'divi-bodyshop-woocommerce' ).'',
'id' => 'main_css_method',
'type' => 'select',
'desc' => ''.esc_html__( 'Select the main CSS method - "old version" will be depreciated soon but this is here to help with the transition to CSS grid for the product loops.', 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'new' => ''.esc_html__( "New (CSS grid)", 'divi-bodyshop-woocommerce' ).'',
'old' => ''.esc_html__( "Old Version", 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'new',
) );

$settings->createOption( array(
'name' => ''.esc_html__( 'Disable BodyCommerce Gallery JS File', 'divi-bodyshop-woocommerce' ).'',
'id' => 'settings_disable_gallery_js_file',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'This file js file is responsible for the custom product gallery functionality - if you are not using them, disabling this is advised to save load time on your website.', 'divi-bodyshop-woocommerce' ).'',
) );

// $settings->createOption( array(
// 'name' => ''.esc_html__( 'Disable BodyCommerce CSS file', 'divi-bodyshop-woocommerce' ).'',
// 'id' => 'settings_disable_css_file',
// 'type' => 'enable',
// 'default' => false,
// 'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
// 'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
// 'desc' => ''.esc_html__( 'We try and load all the css only for the settings you use, the css that we cannot load this way goes into this file. You can disable it if you wish, just check that all looks fine on your site - it might have no impact or it might such as the css for the gallerys.', 'divi-bodyshop-woocommerce' ).'',
// ) );

$settings->createOption( array(
'name' => ''.esc_html__( 'Disable general head CSS', 'divi-bodyshop-woocommerce' ).'',
'id' => 'settings_disable_general_head_css',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to disable the general head css (global css such as the notices), enable this.', 'divi-bodyshop-woocommerce' ).'',
) );

$settings->createOption( array(
'name' => ''.esc_html__( 'Disable checkout head CSS', 'divi-bodyshop-woocommerce' ).'',
'id' => 'settings_disable_checkout_head_css',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to disable the checkout head css, enable this.', 'divi-bodyshop-woocommerce' ).'',
) );

$settings->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( "Other Settings", 'divi-bodyshop-woocommerce' ).'</p>'
) );

// $settings->createOption( array(
// 'name' => ''.esc_html__( 'Display Divi cart at end of a menu (choose menu below)', 'divi-bodyshop-woocommerce' ).'',
// 'id' => 'settings_divi_cart_end_primary_menu',
// 'type' => 'enable',
// 'default' => false,
// 'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
// 'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
// 'desc' => ''.esc_html__( 'Enable this to put the original Divi cart icon at the end of the menu. This will allow the mini cart and custom cart icon to work when using the new "Menu" module and enabling the cart icon. Disable it in the module and enable this', 'divi-bodyshop-woocommerce' ).'',
// ) );
//
// $settings->createOption( array(
// 'name' => ''.esc_html__( "Choose menu for Divi cart (setting above)", 'divi-bodyshop-woocommerce' ).'',
// 'id' => 'settings_divi_cart_end_primary_menu_choose',
// 'type' => 'select',
// 'options' => array(
// 'primary-menu' => ''.esc_html__( "Primary", 'divi-bodyshop-woocommerce' ).'',
// 'secondary-menu' => ''.esc_html__( "Secondary", 'divi-bodyshop-woocommerce' ).'',
// ),
// 'default' => 'primary-menu',
// ) );

/**/

// $settings->createOption( array(
// 'name' => ''.esc_html__( 'Disable Divi Layout Queries in Modules', 'divi-bodyshop-woocommerce' ).'',
// 'id' => 'disable_library_queries',
// 'type' => 'enable',
// 'default' => false,
// 'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
// 'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
// 'desc' => ''.esc_html__( 'Enable this if you do not want the Divi Modules to search for the library layouts. If you enable this, you will need to manually add the ID of the library layout and cannot select it.', 'divi-bodyshop-woocommerce' ).'',
// ) );

$settings->createOption( array(
  'name' => ''.esc_html__( 'Disable Custom Tabs', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'settings_disable_custom_tabs',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  'desc' => ''.esc_html__( 'If you want to disable the custom tabs, enable this.', 'divi-bodyshop-woocommerce' ).'',
  ) );

$settings->createOption( array(
'name' => ''.esc_html__( 'Overwrite German Market templates', 'divi-bodyshop-woocommerce' ).'',
'id' => 'settings_german_market_overwrite',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to overwrite the German Market templates if you are facing compatibility issues - enable this (https://marketpress.de/shop/plugins/woocommerce-german-market/).', 'divi-bodyshop-woocommerce' ).'',
) );

$settings->createOption( array(
'name' => ''.esc_html__( 'Disable different product templates per category?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'settings_disable_product_cat_admin',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you have too many categories, it sometimes wont save the product page - enable this to remove those categoies so it saves', 'divi-bodyshop-woocommerce' ).'',
) );

$settings->createOption( array(
'name' => ''.esc_html__( 'Disable new Carousel feature?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'settings_disable_carousel_feature',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you have any issue with new feature - enable this to rollback carousel module version', 'divi-bodyshop-woocommerce' ).'',
) );

$settings->createOption( array(
'name' => ''.esc_html__( 'Hide BodyCommerce modules in builder?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'settings_hide_modules',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to hide all the BodyCommerce modules when using the Divi Builder, enable this', 'divi-bodyshop-woocommerce' ).'',
) );

$settings->createOption( array(
'name' => ''.esc_html__( 'Disable Settings Translation?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'settings_remove_french_translation',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want English text only and to remove the French translation, enable this', 'divi-bodyshop-woocommerce' ).'',
) );

$settings->createOption( array(
'name' => ''.esc_html__( 'Remove WooCommerce class on certain pages', 'divi-bodyshop-woocommerce' ).'',
'id' => 'settings_remove_woo_class',
'type' => 'text',
'default' => "",
'desc' => ''.esc_html__( 'Add the post ID, comma seperated with no spaces such as "53,123,42". This will stop our code such as the mini cart from not working on these pages', 'divi-bodyshop-woocommerce' ).'',
) );

$settings->createOption( array(
'desc' => ''.esc_html__( 'Import/Export Settings', 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );

$settings->createOption( array(
'desc' => ''.esc_html__( 'Here you can export and import the settings of BodyCommerce. It will ONLY export/import the settings in Divi Engine > BodyCommerce and Divi Engine > BodyCommerce Mods', 'divi-bodyshop-woocommerce' ).'',
'type' => 'note',
) );


$settings->createOption(array(
    'name' => 'Upload your setting file',
    'id' => 'setting_file_upload',
    'type' => 'file',
    'label' => 'Choose File',
    'placeholder' => 'Choose File'
));
$settings->createOption(array(
    'id' => "import_setting_btn",
    'name' => 'Import Settings',
    'type' => 'ajax-button',
    'action' => 'divi_bc_import_action',
    'label' => __('Save Settings', 'default'),
    'data_filter_callback' => 'import_settings_data_filter_callback',
    'success_callback' => 'import_settings',
    'class' => array('button-primary', 'button-secondary')
));
$settings->createOption(array(
    'name' => 'Export Settings',
    'type' => 'ajax-button',
    'action' => 'divi_bc_export_action',
    'label' => __('Download', 'default'),
    'success_callback' => 'export_settings',
    'class' => array('button-primary', 'button-secondary')
));

$settings->createOption( array(
'type' => 'save',
) );


// // CUSTOM PRODUCT fields
//
// $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
// $custom_pro_fields_meta = $titan->createMetaBox( array(
//        'name'      => ''.esc_html__( "Divi BodyCommerce Custom Prodcut Fields", 'divi-bodyshop-woocommerce' ).'',
//        'post_type' => array('bc_custom_fields' ),
//        'priority'  => 'low'
//    ) );
//
//       $custom_pro_fields_meta->createOption( array(
//       'name' => ''.esc_html__( 'Unique ID', 'divi-bodyshop-woocommerce' ).'',
//       'id' => 'bc_custom_field_id',
//       'type' => 'text',
//       'desc' => ''.esc_html__( 'Give your field a unique ID that will be responsible for saving the information to the database- NO SPACES ALLOWED', 'divi-bodyshop-woocommerce' ).'',
//       ) );
//
//    $custom_pro_fields_meta->createOption( array(
//    'name' => ''.esc_html__( 'Field Name/Label', 'divi-bodyshop-woocommerce' ).'',
//    'id' => 'bc_custom_field_label',
//    'type' => 'text',
//    'is_code' => true,
//    'desc' => ''.esc_html__( "Choose a name for the field", 'divi-bodyshop-woocommerce' ).'',
//    ) );
//
//    $custom_pro_fields_meta->createOption( array(
//    'name' => ''.esc_html__( 'Placeholder (if applicable)', 'divi-bodyshop-woocommerce' ).'',
//    'id' => 'bc_custom_field_placeholder',
//    'type' => 'text',
//    'desc' => ''.esc_html__( 'Type your preferred placeholder', 'divi-bodyshop-woocommerce' ).'',
//    ) );
//
//    $custom_pro_fields_meta->createOption( array(
//    'name' => ''.esc_html__( 'Field Type', 'divi-bodyshop-woocommerce' ).'',
//    'id' => 'bc_custom_field_type',
//    'type' => 'select',
//    'options' => array(
//    'text' => ''.esc_html__( 'Text', 'divi-bodyshop-woocommerce' ).'',
//    'number' => ''.esc_html__( 'Number', 'divi-bodyshop-woocommerce' ).'',
//    'textarea' => ''.esc_html__( 'Textarea', 'divi-bodyshop-woocommerce' ).'',
//    ),
//    'default' => 'text',
//    'desc' => ''.esc_html__( 'Choose the type of checkout field', 'divi-bodyshop-woocommerce' ).'.',
//    ) );




// CHECKOUT fields

$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$chackout_fields_meta = $titan->createMetaBox( array(
       'name'      => ''.esc_html__( "Divi BodyCommerce Custom Checkout Fields", 'divi-bodyshop-woocommerce' ).'',
       'post_type' => array('bc_checkout' ),
       'priority'  => 'low'
   ) );

   $chackout_fields_meta->createOption( array(
   'name' => ''.esc_html__( 'Field Name/Label', 'divi-bodyshop-woocommerce' ).'',
   'id' => 'db_checkout_field_label',
   'type' => 'textarea',
   'is_code' => true,
   'desc' => ''.esc_html__( "Choose a name for the field - something like - Billing Colour. You can use code here so you can link to your terms page if you want", 'divi-bodyshop-woocommerce' ).'',
   ) );

   $chackout_fields_meta->createOption( array(
   'name' => ''.esc_html__( 'Field Type', 'divi-bodyshop-woocommerce' ).'',
   'id' => 'db_checkout_field_type',
   'type' => 'select',
   'options' => array(
   'text' => ''.esc_html__( 'Text', 'divi-bodyshop-woocommerce' ).'',
   'textarea' => ''.esc_html__( 'Textarea', 'divi-bodyshop-woocommerce' ).'',
   'checkbox' => ''.esc_html__( 'Checkbox', 'divi-bodyshop-woocommerce' ).'',
   ),
   'default' => 'text',
   'desc' => ''.esc_html__( 'Choose the type of checkout field', 'divi-bodyshop-woocommerce' ).'.',
   ) );

   $chackout_fields_meta->createOption( array(
   'name' => ''.esc_html__( 'Placeholder (if applicable)', 'divi-bodyshop-woocommerce' ).'',
   'id' => 'db_checkout_field_placeholder',
   'type' => 'text',
   'desc' => ''.esc_html__( 'Type your preferred placeholder such as "Red"', 'divi-bodyshop-woocommerce' ).'',
   ) );

   $chackout_fields_meta->createOption( array(
   'name' => ''.esc_html__( 'Unique ID', 'divi-bodyshop-woocommerce' ).'',
   'id' => 'db_checkout_field_id',
   'type' => 'text',
   'desc' => ''.esc_html__( 'Give your field a unique ID that will be responsible for saving the information to the database - something like - "billing_color" - NO SPACES ALLOWED', 'divi-bodyshop-woocommerce' ).'',
   ) );

   $chackout_fields_meta->createOption( array(
'name' => ''.esc_html__( 'Required Field', 'divi-bodyshop-woocommerce' ).'',
'id' => 'db_checkout_field_required',
'type' => 'checkbox',
'desc' => ''.esc_html__( 'Do you want this field to be required', 'divi-bodyshop-woocommerce' ).'',
'default' => false,
) );
$chackout_fields_meta->createOption( array(
'name' => ''.esc_html__( 'Error Message', 'divi-bodyshop-woocommerce' ).'',
'id' => 'db_checkout_field_error_message',
'type' => 'text',
'desc' => ''.esc_html__( 'Type the message you want to appear when someone doesnt enter in the required field.', 'divi-bodyshop-woocommerce' ).'',
) );
$chackout_fields_meta->createOption( array(
'name' => ''.esc_html__( 'Field Width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'db_checkout_field_width',
'type' => 'select',
'options' => array(
'full' => ''.esc_html__( '100% Width', 'divi-bodyshop-woocommerce' ).'',
'half-first' => ''.esc_html__( '50% Width First', 'divi-bodyshop-woocommerce' ).'',
'half-last' => ''.esc_html__( '50% Width Last', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'full',
'desc' => ''.esc_html__( 'Choose if you want the field to be fullwidth or 50% width', 'divi-bodyshop-woocommerce' ).'.',
) );
$chackout_fields_meta->createOption( array(
'name' => ''.esc_html__( 'Display Field on View Order page?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'db_checkout_field_order_page',
'type' => 'checkbox',
'default' => true,
) );
$chackout_fields_meta->createOption( array(
'name' => ''.esc_html__( 'Add the custom field to email?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'db_checkout_field_add_email',
'type' => 'checkbox',
'default' => true,
) );

$chackout_fields_meta->createOption( array(
'name' => ''.esc_html__( 'Where to add the field', 'divi-bodyshop-woocommerce' ).'',
'id' => 'db_checkout_field_location',
'type' => 'select',
'options' => array(
'billing' => ''.esc_html__( 'Billing', 'divi-bodyshop-woocommerce' ).'',
'shipping' => ''.esc_html__( 'Shipping', 'divi-bodyshop-woocommerce' ).'',
'after_order_notes' => ''.esc_html__( 'After order Notes', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'after_order_notes',
'desc' => ''.esc_html__( 'Choose where you want to add the custom field to on the checkout page', 'divi-bodyshop-woocommerce' ).'',
) );
$chackout_fields_meta->createOption( array(
'name' => ''.esc_html__( 'Checkbox True Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'db_checkout_checkbox_true',
'type' => 'text',
'desc' => ''.esc_html__( 'Add the text you want to show on the email and order when the checkbox is true.', 'divi-bodyshop-woocommerce' ).'',
) );
$chackout_fields_meta->createOption( array(
'name' => ''.esc_html__( 'Checkbox False Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'db_checkout_checkbox_false',
'type' => 'text',
'desc' => ''.esc_html__( 'Add the text you want to show on the email and order when the checkbox is false.', 'divi-bodyshop-woocommerce' ).'',
) );






   // Product custom tabs

$settings_quick_edit = $titan->getOption( 'settings_disable_custom_tabs' );

if ($settings_quick_edit != 1) {

  
$bodycommerce_meta_box = $titan->createMetaBox( array(
'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 1', 'divi-bodyshop-woocommerce' ).'',
'post_type' => array('product' ),
'priority'  => 'low'
) );
$bodycommerce_meta_box->createOption( array(
'name' => ''.esc_html__( 'Tab 1 - Title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_custom_tab_1',
'type' => 'text',
) );
$bodycommerce_meta_box->createOption( array(
'name' => ''.esc_html__( 'Tab 1 - Content', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_custom_tab_1_content',
'type' => 'editor',
'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
<p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
) );
$bodycommerce_meta_box->createOption( array(
'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
'type' => 'note',
) );
$bodycommerce_meta_box->createOption( array(
'name' => ''.esc_html__( 'Tab 1 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_custom_tab_1_content_layout',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
) );
$bodycommerce_meta_box->createOption( array(
'name' => ''.esc_html__( 'Add another tab?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_custom_tab_1_another_tab',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );


  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 2', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 2 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_2',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 2 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_2_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 2 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_2_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Add another tab?', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_2_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 3', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 3 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_3',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 3 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_3_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 3 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_3_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_3_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 4', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 4 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_4',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 4 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_4_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 4 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_4_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_4_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 5', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 5 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_5',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 5 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_5_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 5 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_5_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_5_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 6', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 6 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_6',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 6 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_6_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 6 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_6_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_6_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 7', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 7 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_7',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 7 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_7_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 7 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_7_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_7_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 8', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 8 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_8',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 8 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_8_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 8 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_8_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_8_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 9', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 9 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_9',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 9 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_9_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 9 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_9_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_9_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 10', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 10 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_10',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 10 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_10_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 10 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_10_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_10_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 11', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 11 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_11',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 11 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_11_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 11 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_11_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_11_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 12', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 12 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_12',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 12 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_12_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 12 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_12_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_12_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 13', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 13 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_13',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 13 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_13_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 13 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_13_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_13_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 14', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 14 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_14',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 14 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_14_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 14 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_14_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_14_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 15', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 15 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_15',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 15 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_15_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 15 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_15_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_15_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 16', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 16 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_16',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 16 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_16_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 16 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_16_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_16_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 17', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 17 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_17',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 17 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_17_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 17 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_17_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_17_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 18', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 18 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_18',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 18 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_18_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 18 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_18_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_18_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 19', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 19 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_19',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 19 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_19_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 19 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_19_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => 'Add another tab?',
  'id' => 'product_custom_tab_19_another_tab',
  'type' => 'enable',
  'default' => false,
  'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
  'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
  ) );

  $bodycommerce_meta_box = $titan->createMetaBox( array(
  'name'      => ''.esc_html__( 'Divi BodyCommerce Custom Tab 20', 'divi-bodyshop-woocommerce' ).'',
  'post_type' => array('product' ),
  'priority'  => 'low'
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 20 - Title', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_20',
  'type' => 'text',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 20 - Content', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_20_content',
  'type' => 'editor',
  'desc' => ''.esc_html__( 'Use this simple editor to show the content you want in the tab, alternatively you can use the layout selector below.', 'divi-bodyshop-woocommerce' ).'',
  'default' => '<h3>'.esc_html__( 'Title', 'divi-bodyshop-woocommerce' ).'</h3>
  <p>'.esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ).'</p>',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'desc' => ''.esc_html__( 'OR', 'divi-bodyshop-woocommerce' ).'',
  'type' => 'note',
  ) );
  $bodycommerce_meta_box->createOption( array(
  'name' => ''.esc_html__( 'Tab 20 - Content Layout', 'divi-bodyshop-woocommerce' ).'',
  'id' => 'product_custom_tab_20_content_layout',
  'type' => 'select-posts',
  'post_type' => 'et_pb_layout',
  'desc' => ''.esc_html__( 'Choose the predefined layout that you want shown as the content, this will override the text above.', 'divi-bodyshop-woocommerce' ).'',
  ) );

}

  // Product template meta

  $bodycommerce_meta_box = $titan->createMetaBox( array(
         'name'      => ''.esc_html__( 'Divi BodyCommerce Layout', 'divi-bodyshop-woocommerce' ).'',
         'post_type' => array('product' ),
         'priority'  => 'low'
     ) );


     // $post_id = $_GET['post'];
     // $admin_url = get_admin_url();
     // $layout = get_post_meta( $post_id, 'divi-bodyshop-woo_product_template_override', true );
     // if ($layout == "") {$link = "";} else {
     // $html_link = ''.$admin_url.'post.php?post='.$layout.'&action=edit';
     // $link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
     // }

     $bodycommerce_meta_box->createOption( array(
     'name' => ''.esc_html__( 'Select Template Override', 'divi-bodyshop-woocommerce' ).'',
     'id' => 'product_template_override',
     'type' => 'select-posts',
     'post_type' => 'et_pb_layout',
     'desc' => ''.esc_html__( 'If you want to override the layout of the product page that you set in the main settings, choose it here.', 'divi-bodyshop-woocommerce' ),
     ) );

     $bodycommerce_meta_box->createOption( array(
     'name' => ''.esc_html__( 'Select Primary Category for Template Override', 'divi-bodyshop-woocommerce' ).'',
     'id' => 'product_template_override_primary',
  'type' => 'select-categories',
     'taxonomy' => 'product_cat',
     'desc' => ''.esc_html__( 'If you have multiple categories and your product is looking at the wrong category template, specify the "primary" category for it to look for for templating.', 'divi-bodyshop-woocommerce' ),
     ) );




// Login page
$login_page->createOption( array(
'type' => 'save',
) );


$login_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Login Page Template', 'divi-bodyshop-woocommerce' ).'</p>'
) );



$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['login_page_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['login_page_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$login_page->createOption( array(
'name' => ''.esc_html__( 'Select Login Page Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'login_page_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['login_page_lost_password'])) {
  $page_template = "";
} else {
  $page_template = $mydata['login_page_lost_password'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$login_page->createOption( array(
'name' => ''.esc_html__( 'Select Lost Password Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'login_page_lost_password',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['login_password_reset_confirmation'])) {
  $page_template = "";
} else {
  $page_template = $mydata['login_password_reset_confirmation'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$login_page->createOption( array(
'name' => ''.esc_html__( 'Select Password Reset Confirmation Message Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'login_password_reset_confirmation',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );


$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['login_page_password_reset'])) {
  $page_template = "";
} else {
  $page_template = $mydata['login_page_password_reset'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}


$login_page->createOption( array(
'name' => ''.esc_html__( 'Select Password Reset Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'login_page_password_reset',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );


$login_page->createOption( array(
'type' => 'save',
) );

//Cart PAGE

$cart_page->createOption( array(
'type' => 'save',
) );

$cart_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Cart Page Template', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['cart_page_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['cart_page_template'] ?: "";
}


$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$cart_page->createOption( array(
'name' => ''.esc_html__( 'Select Cart Page Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_page_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['cart_empty_page_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['cart_empty_page_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$cart_page->createOption( array(
'name' => ''.esc_html__( 'Select Cart Empty Page Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_empty_page_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$cart_page->createOption( array(
'name' => ''.esc_html__( 'Make the Cart Page Fullwidth?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_page_fullwidth',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$cart_page->createOption( array(
'name' => ''.esc_html__( 'Remove cart page title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_page_remove_title',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$cart_page->createOption( array(
'type' => 'save',
) );
// Checkout page


$checkout_page->createOption( array(
'type' => 'save',
) );

$checkout_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Custom Checkout Page', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['checkout_custom_layout'])) {
  $page_template = "";
} else {
  $page_template = $mydata['checkout_custom_layout'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}


$checkout_page->createOption( array(
'name' => '',
'id' => 'checkout-set-page',
'type' => 'text',
'default' => 'checkout',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Enable Custom Checkout Layout?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_enable',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );




$checkout_page->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( "Create a layout with our modules and assign it below", 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Select Checkout Page Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_custom_layout',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => "".$link.""
.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).
"<br><strong>"
.esc_html__('Leave the select checkout page template blank (-Select-) if you wish to use our custom checkout style instead (below)', 'divi-bodyshop-woocommerce' ).
"</strong>",
) );



$checkout_page->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( "OR use one of our premade layouts below", 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Custom Checkout Style', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_style',
'type' => 'select',
'options' => array(
'multistep' => ''.esc_html__( 'Multi-Step', 'divi-bodyshop-woocommerce' ).'',
'accordian' => ''.esc_html__( 'Accordion', 'divi-bodyshop-woocommerce' ).'',
'one-page' => ''.esc_html__( 'One Page (cart and checkout)', 'divi-bodyshop-woocommerce' ).'',
'payment-right' => ''.esc_html__( 'Payment Right', 'divi-bodyshop-woocommerce' ).'',
'shopify' => ''.esc_html__( 'Shopify Style', 'divi-bodyshop-woocommerce' ).'',
// 'enigne' => 'Divi Engine Style',
),
'multistep' => 'right',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Remove checkout title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_remove_title',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Make checkout page fullwidth', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_fullwidth',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );



$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Guest checkout introduction text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_multistep_guest_checkout_text',
'type' => 'text',
'default' => ''.esc_html__( 'If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the next step.', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Change the text that appears just above the login form when a guest tries to checkout.', 'divi-bodyshop-woocommerce' ).'',
) );


$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Style Your Checkout Area', 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );

$checkout_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Background', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Checkout Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Checkout Padding', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_padding',
'type' => 'number',
'desc' => ''.esc_html__( 'Set the padding around the whole checkout area (inputs and progess bar)', 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '300',
'step' => '1',
'unit' => 'px',
) );


$checkout_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Inputs', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Input Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_input_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Input Border Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_input_border_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Input Border Width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_input_border_width',
'type' => 'number',
'default' => '1',
'min' => '0',
'max' => '20',
'step' => '1',
'unit' => 'px',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Input Border Radius', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_input_border_radius',
'type' => 'number',
'default' => '3',
'min' => '0',
'max' => '150',
'step' => '1',
'unit' => 'px',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Input Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_input_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Input Label Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_input_label_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Input Validated Border Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_input_validated_color',
'type' => 'color',
'default' => '#69bf29',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the border color that appears when you successfully complete an input. To test, click in a field that is not required and click off. (default Woo is green)', 'divi-bodyshop-woocommerce' ).'',
) );


$checkout_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Payment Section', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Payment Section Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_payment_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Payment Section Info Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_payment_info_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the background color that has a little message about the payment type.', 'divi-bodyshop-woocommerce' ).'',
) );


$checkout_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Buttons', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Use Custom Styles for Button', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_use_custom_style_button',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Text Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_text_size',
'type' => 'number',
'default' => '20',
'max' => '100',
'min' => '1',
'unit' => 'px'
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Border Width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_border_width',
'type' => 'number',
'default' => '2',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Border Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_border_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Border Radius', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_border_radius',
'type' => 'number',
'default' => '3',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Letter Spacing', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_letter_spacing',
'type' => 'number',
'default' => '0',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Add Button icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_add_button_icon',
'type' => 'select',
'options' => array(
'yes' => ''.esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ).'',
'no' => ''.esc_html__( 'No', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'yes',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Divi Icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_icon',
'type' => 'text',
'desc' => ''.esc_html__( 'Enter in the number for the divi icon - You can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">'.esc_html__( 'HERE.', 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( 'Just scroll down till you see the icons and some letter below. <br>Copy the numbers and letters that appear after "x". ', 'divi-bodyshop-woocommerce' ).'<br>'.esc_html__( 'So', 'divi-bodyshop-woocommerce' ).' "&amp;#x21;" - '.esc_html__( 'copy just the "21".', 'divi-bodyshop-woocommerce' ).' <br>"&amp;#xe016;" - '.esc_html__( 'copy the "e016"', 'divi-bodyshop-woocommerce' ).'',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Icon Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_icon_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Icon Placement', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_icon_placement',
'type' => 'select',
'options' => array(
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'right',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Only Show icon On Hover For Button', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_field_button_icon_only_show_hover',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );
$checkout_page->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'Button Hover', 'divi-bodyshop-woocommerce' ).'<br><hr>'
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Hover Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_button_hover_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Hover Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_button_hover_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Hover Border Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_button_hover_border_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Hover Border Radius', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_button_hover_border_radius',
'type' => 'number',
'default' => '3',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Button Hover Letter Spacing', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_button_hover_letter_spacing',
'type' => 'number',
'default' => '0',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

//////////////////
/// Multi-Step ///
/////////////////

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi-Step Specific Settings', 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi Step / Accordion Login Title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_progress_bar_login_title',
'type' => 'text',
'default' => ''.esc_html__( 'Login', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Change the name of the Login title on the progress bar', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi Step 1 / Accordian Billing Title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_progress_bar_billing_title',
'type' => 'text',
'default' => ''.esc_html__( 'Billing', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Change the name of the Billing title on the progress bar', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi Step 2 / Accordian Shipping Title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_progress_bar_shipping_title',
'type' => 'text',
'default' => ''.esc_html__( 'Shipping', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Change the name of the Shipping title on the progress bar', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi Step 3 / Accordian Order Information Title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_progress_bar_order_info_title',
'type' => 'text',
'default' => ''.esc_html__( 'Order Info', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Change the name of the Order info title on the progress bar', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi Step 4 / Accordian Complete Title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_progress_bar_payment_info_title',
'type' => 'text',
'default' => ''.esc_html__( 'Complete', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Change the name of the Payment Info title on the progress bar', 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi-Step Style', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_multistep_style',
'type' => 'select',
'options' => array(
'circles' => ''.esc_html__( 'Circles', 'divi-bodyshop-woocommerce' ).'',
'arrows' => ''.esc_html__( 'Arrows', 'divi-bodyshop-woocommerce' ).'',
),
'multistep' => 'right',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi-step mobile numbers style', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_multi_circle_style',
'type' => 'select',
'options' => array(
'100' => ''.esc_html__( '100% width, one of top of each other', 'divi-bodyshop-woocommerce' ).'',
'oneline' => ''.esc_html__( 'One line and hide titles of not active tabs', 'divi-bodyshop-woocommerce' ).'',
),
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi-Step Order', 'divi-bodyshop-woocommerce' ).'',
'id' => 'multistep_order_new',
'type' => 'sortable',
'visible_button' => false,
'desc' => ''.esc_html__( 'Change the order of the steps. Login and complete will stay 1st and last', 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'value2' => ''.esc_html__( 'Billing', 'divi-bodyshop-woocommerce' ).'',
'value3' => ''.esc_html__( 'Shipping', 'divi-bodyshop-woocommerce' ).'',
'value4' => ''.esc_html__( 'Order Info', 'divi-bodyshop-woocommerce' ).'',
)
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Multi-Step Validation Error Message', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_multistep_val_text',
'type' => 'text',
'default' => ''.esc_html__( 'Please fill in the required field', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Change the text that will be shown when there is an error or a field not filled in when using multistep', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Next Button Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_next_button_text',
'type' => 'text',
'default' => ''.esc_html__( 'Continue', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Change the text of the "next" button', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Previous Button Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_previous_button_text',
'type' => 'text',
'default' => ''.esc_html__( 'Previous', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Change the text of the "previous" button', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Progress Bar Title Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_progress_bar_title_text_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the names of the steps.', 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Progress Bar Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_progress_bar_default_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the default color of the circles or the arrows', 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Progress Bar Background Active Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_progress_bar_active_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the active color of the circles or the arrows - this is when the process is complete', 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Progress Bar Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_progress_bar_text_default_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the text ontop of the default background (numbers in circles) & (numbers and text in arrows)', 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Progress Bar Text Active Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_progress_bar_text_active_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the text ontop of the active background (numbers in circles) & (numbers and text in arrows)', 'divi-bodyshop-woocommerce' ).''
) );




/////////////////
/// ACCORDIAN ///
////////////////

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Accordion Specific Settings', 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Toggle Icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_accordian_icon',
'type' => 'text',
'desc' => ''.esc_html__( 'Enter in the number for the accordion icon - You can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">'.esc_html__( 'HERE', 'divi-bodyshop-woocommerce' ).'</a>. '.esc_html__( 'Just scroll down till you see the icons and some letter below. Copy the numbers and letters that appear after "x".', 'divi-bodyshop-woocommerce' ).' <br>'.esc_html__( 'So "&amp;#x21;" - copy just the "21".', 'divi-bodyshop-woocommerce' ).' <br>"&amp;#xe016;" - '.esc_html__( 'copy the "e016"', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Toggle Icon Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_accordian_icon_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the icon', 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Open Title Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_accordian_open_title_font_size',
'type' => 'number',
'default' => '16',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Open Title Font Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_accordian_open_title_font_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the open title text', 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Open Title Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_accordian_open_title_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the open background color', 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Closed Title Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_accordian_closed_title_font_size',
'type' => 'number',
'default' => '16',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Closed Title Font Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_accordian_closed_title_font_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the closed title text', 'divi-bodyshop-woocommerce' ).''
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Closed Title Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_accordian_closed_title_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the closed background color', 'divi-bodyshop-woocommerce' ).''
) );





/////////////////
/// ONE PAGE ///
////////////////

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'One Page Checkout Specific Settings', 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Checkout Columns', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_onepage_columns',
'type' => 'select',
'options' => array(
'1' => ''.esc_html__( 'One', 'divi-bodyshop-woocommerce' ).'',
'2' => ''.esc_html__( 'Two', 'divi-bodyshop-woocommerce' ).'',
),
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'One Page Style', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_onepage_style',
'type' => 'select',
'options' => array(
'default' => ''.esc_html__( 'Default', 'divi-bodyshop-woocommerce' ).'',
'payment-right' => ''.esc_html__( 'Payment Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'default',
) );


// $checkout_page->createOption( array(
// 'name' => 'General Settings',
// 'type' => 'heading',
// ) );

// $checkout_page->createOption( array(
// 'name' => 'Billing Title Text',
// 'id' => 'other_settings_step_billing_title',
// 'type' => 'text',
// 'default' => 'Billing details',
// 'desc' => 'Change the name of the billing title text - default is "Billing details"',
// ) );
//
// $checkout_page->createOption( array(
// 'name' => 'Order Title Text',
// 'id' => 'other_settings_step_order_title',
// 'type' => 'text',
// 'default' => 'Your order',
// 'desc' => 'Change the name of the order title text - default is "Your order"',
// ) );
//
// $checkout_page->createOption( array(
// 'name' => 'Payment Title Text',
// 'id' => 'other_settings_step_payment_title',
// 'type' => 'text',
// 'default' => 'Payment Info',
// 'desc' => 'Change the name of the payment title text - default is "Payment Info"',
// ) );
//
// $checkout_page->createOption( array(
// 'name' => 'Deliver to Another Adress Title Text',
// 'id' => 'other_settings_step_different_address_title',
// 'type' => 'text',
// 'default' => 'Deliver to a different address?',
// 'desc' => 'Change the name of the payment title text - default is "Payment Info"',
// ) );

//////////////////
/// SHopify Styule ///
/////////////////

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Shopify Style Specific Settings', 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Enable Shipping Method', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_enable_shipping',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Cart Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_cart_text',
'type' => 'text',
'default' => ''.esc_html__( 'cart', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Customer Information Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_customer_info_text',
'type' => 'text',
'default' => ''.esc_html__( 'customer Information', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Shipping Information Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_shipping_info_text',
'type' => 'text',
'default' => ''.esc_html__( 'shipping Information', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Payment Method Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_payment_method_text',
'type' => 'text',
'default' => ''.esc_html__( 'payment Method', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Return to Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_return_text',
'type' => 'text',
'default' => ''.esc_html__( 'Return to', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Continue to Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_continue_text',
'type' => 'text',
'default' => ''.esc_html__( 'Continue to', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Complete order text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_complete_text',
'type' => 'text',
'default' => ''.esc_html__( 'Complete order', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Coupon Placeholder Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_cp_placeholder_text',
'type' => 'text',
'default' => ''.esc_html__( 'Enter Promo Code', 'divi-bodyshop-woocommerce' ).'',
) );

$checkout_page->createOption( array(
'name' => ''.esc_html__( 'Coupon Apply Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'checkout_page_shopify_cp_apply_text',
'type' => 'text',
'default' => ''.esc_html__( 'Apply', 'divi-bodyshop-woocommerce' ).'',
) );



$checkout_page->createOption( array(
'type' => 'save',
) );


// CATEGORY PAGE TEMPLATES

$category_page->createOption( array(
'type' => 'save',
) );

$category_page->createOption( array(
'name' => '',
'id' => 'category-template-set-page',
'type' => 'text',
'default' => 'category-template',
) );

$category_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Shop/Category Page Template', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$category_page->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'To create an archive/shop template, you will need to create two divi layouts.', 'divi-bodyshop-woocommerce' ).'<br>
'.esc_html__( '1) Archive Page - this is where you will create the header, sidebar, footer and other elements you may want. You will need to add our "Product Loop" module to display the products.', 'divi-bodyshop-woocommerce' ).'<br>
'.esc_html__( '2) Product Loop - This is where you create the individual product items in the loop such as the title, price, short description etc etc. Think of this as how you want one of the product "cards" to be seen, then it will be looped for as many products in the category.', 'divi-bodyshop-woocommerce' ).''
) );


$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['archive_page_shop_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['archive_page_shop_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$category_page->createOption( array(
'name' => ''.esc_html__( 'Select Shop Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'archive_page_shop_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['archive_page_category_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['archive_page_category_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$category_page->createOption( array(
'name' => ''.esc_html__( 'Select Category Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'archive_page_category_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );


$category_page->createOption( array(
'name' => ''.esc_html__( 'Different Category Templates Per Category?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'category_page_enable_multiple_templates',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want different templates for different shop categories', 'divi-bodyshop-woocommerce' ).'<br><br>
'.esc_html__( 'NOTE: You will have to set a "main" template above for it to work - for something to fall back on in case you dont set a layout', 'divi-bodyshop-woocommerce' ).'',
) );


  $output = array();
   $categories = get_terms( array(
   'orderby'      => 'name',
   'hide_empty'   => false,
   ) );
   foreach( $categories as $category ) {
        if ($category->taxonomy == 'product_cat' ) {


          $mydata = get_option( 'divi-bodyshop-woo_options' );
          $mydata = unserialize($mydata);
          if (!isset($mydata['custom_category_'.$category->slug.''])) {
            $page_template = "";
          } else {
            $page_template = $mydata['custom_category_'.$category->slug.''] ?: "";
          }


          $admin_url = get_admin_url();
          if ($page_template == "") {$link = "";} else {
          $html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
          $link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
          }

          $category_page->createOption( array(
               'name' => ''.$category->name.'',
               'id' => 'custom_category_'.$category->slug.'',
               'type' => 'select-posts',
               'post_type' => 'et_pb_layout',
               'desc' => ''.$link.''.esc_html__( 'Select the template/layout that you want to display as the category template for', 'divi-bodyshop-woocommerce' ).' '.$category->name.' - '.esc_html__( 'it will override the default one.', 'divi-bodyshop-woocommerce' ).'',
               'taxonomy' => 'product_cat',
             ) );


}
}


$category_page->createOption( array(
'type' => 'save',
) );

// TAG PAGE TEMPLATES

$tag_page->createOption( array(
'type' => 'save',
) );

// $tag_page->createOption( array(
// 'name' => '',
// 'id' => 'tag-template-set-page',
// 'type' => 'text',
// 'default' => 'category-template',
// ) );

$tag_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Tag Page Template', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$tag_page->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'If you have tags assigned to your products and someone clicks the tag - it willt take them to another page where it will show all the products for this tag. Here you can specify a default layout for this.', 'divi-bodyshop-woocommerce' ).''
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['tag_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['tag_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$tag_page->createOption( array(
'name' => ''.esc_html__( 'Select Main Tag Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'tag_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default the archive page template.', 'divi-bodyshop-woocommerce' ).'',
) );


$tag_page->createOption( array(
'name' => ''.esc_html__( 'Different Templates Per Tag?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'tag_page_enable_multiple_templates',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want different templates for different product tags', 'divi-bodyshop-woocommerce' ).'<br><br>
'.esc_html__( 'NOTE: You will have to set a "main" template above for it to work - for something to fall back on in case you dont set a layout', 'divi-bodyshop-woocommerce' ).'',
) );


  $output = array();
   $categories = get_terms( array(
   'orderby'      => 'name',
   'hide_empty'   => false,
   ) );
   foreach( $categories as $category ) {



        if ($category->taxonomy == 'product_tag' ) {

          $mydata = get_option( 'divi-bodyshop-woo_options' );
          $mydata = unserialize($mydata);
          if (!isset($mydata['custom_tag_'.$category->slug.''])) {
            $page_template = "";
          } else {
            $page_template = $mydata['custom_tag_'.$category->slug.''] ?: "";
          }


          $admin_url = get_admin_url();
          if ($page_template == "") {$link = "";} else {
          $html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
          $link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
          }

          $tag_page->createOption( array(
               'name' => ''.$category->name.'',
               'id' => 'custom_tag_'.$category->slug.'',
               'type' => 'select-posts',
               'post_type' => 'et_pb_layout',
               'desc' => ''.$link.''.esc_html__( 'Select the template/layout that you want to display as the category template for', 'divi-bodyshop-woocommerce' ).' '.$category->name.' - '.esc_html__( 'it will override the default one.', 'divi-bodyshop-woocommerce' ).'',
               'taxonomy' => 'product_cat',
             ) );

}
}


$tag_page->createOption( array(
'type' => 'save',
) );

// ATT PAGE

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['attr_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['attr_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$attribute_page->createOption( array(
'name' => ''.esc_html__( 'Select Main Attribute Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'attr_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default the archive page template.', 'divi-bodyshop-woocommerce' ).'',
) );

$attribute_page->createOption( array(
'type' => 'save',
) );
// THANK YOU PAGE


$thakyou_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Thank You Page Template', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$thakyou_page->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'Specify the page you want to display for your thank you page', 'divi-bodyshop-woocommerce' ).''
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['thankyou_page_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['thankyou_page_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$thakyou_page->createOption( array(
'name' => ''.esc_html__( 'Select thank you page template', 'divi-bodyshop-woocommerce' ),
'id' => 'thankyou_page_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$thakyou_page->createOption( array(
'type' => 'save',
) );

// SEARCH TEMPLATE


$search_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Search Results Page Template', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$search_page->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'Specify the page you want to display for your search results', 'divi-bodyshop-woocommerce' ).''
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['search_page_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['search_page_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$search_page->createOption( array(
'name' => ''.esc_html__( 'Select search page template', 'divi-bodyshop-woocommerce' ),
'id' => 'search_page_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$search_page->createOption( array(
'name' => ''.esc_html__( 'Override divi search?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'divi_search_products',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want to override the Divi search to ONLY search products and therefore use our custom search template above.', 'divi-bodyshop-woocommerce' ).'',
) );

$search_page->createOption( array(
'type' => 'save',
) );
// Product Template

// $product_page->createOption( array(
// 'name' => '',
// 'id' => 'product-template-set-page',
// 'type' => 'text',
// 'default' => 'product-template',
// ) );



$product_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Product Page Template', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['product_page_template'])) {
  $page_template = "";
} else {
  $page_template = $mydata['product_page_template'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$product_page->createOption( array(
'name' => ''.esc_html__( 'Select Main Product Page Template', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_page_template',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );
$product_page->createOption( array(
'name' => ''.esc_html__( 'Make the Product Page Fullwidth?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_page_fullwidth',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );




$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (isset($mydata['settings_disable_product_cat_admin'])) {
if ($mydata['settings_disable_product_cat_admin'] == "1") {

} else {

$product_page->createOption( array(
'name' => ''.esc_html__( 'Different Product Templates Per Category?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_page_enable_multiple_templates',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want different templates for different shop categories', 'divi-bodyshop-woocommerce' ).'<br><br>
'.esc_html__( 'NOTE: You will have to set a "main" template above for it to work - for something to fall back on in case you dont set a layout', 'divi-bodyshop-woocommerce' ).'',
) );


$output = array();
 $categories = get_terms( array(
 'orderby'      => 'name',
 'hide_empty'   => false,
 ) );
 foreach( $categories as $category ) {
      if ($category->taxonomy == 'product_cat' ) {

        $mydata = get_option( 'divi-bodyshop-woo_options' );
        $mydata = unserialize($mydata);
        if (!isset($mydata['custom_product_'.$category->slug.''])) {
          $page_template = "";
        } else {
          $page_template = $mydata['custom_product_'.$category->slug.''] ?: "";
        }

        $admin_url = get_admin_url();
        if ($page_template == "") {$link = "";} else {
        $html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
        $link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
        }

        $product_page->createOption( array(
             'name' => ''.$category->name.'',
             'id' => 'custom_product_'.$category->slug.'',
             'type' => 'select-posts',
             'post_type' => 'et_pb_layout',
             'desc' => ''.$link.''.esc_html__( 'Select the template/layout that you want to display as the product template for the products in the category', 'divi-bodyshop-woocommerce' ).' '.$category->name.' - '.esc_html__( 'it will override the default one.', 'divi-bodyshop-woocommerce' ).'',
             'taxonomy' => 'product_cat',
           ) );


}
}
}
} else {

$product_page->createOption( array(
'name' => ''.esc_html__( 'Different Product Templates Per Category?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_page_enable_multiple_templates',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want different templates for different shop categories', 'divi-bodyshop-woocommerce' ).'<br><br>
'.esc_html__( 'NOTE: You will have to set a "main" template above for it to work - for something to fall back on in case you dont set a layout', 'divi-bodyshop-woocommerce' ).'',
) );


$output = array();
 $categories = get_terms( array(
 'orderby'      => 'name',
 'hide_empty'   => false,
 ) );
 foreach( $categories as $category ) {
      if ($category->taxonomy == 'product_cat' ) {

        $mydata = get_option( 'divi-bodyshop-woo_options' );
        $mydata = unserialize($mydata);
        if (!isset($mydata['custom_product_'.$category->slug.''])) {
          $page_template = "";
        } else {
          $page_template = $mydata['custom_product_'.$category->slug.''] ?: "";
        }

        $admin_url = get_admin_url();
        if ($page_template == "") {$link = "";} else {
        $html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
        $link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
        }

        $product_page->createOption( array(
             'name' => ''.$category->name.'',
             'id' => 'custom_product_'.$category->slug.'',
             'type' => 'select-posts',
             'post_type' => 'et_pb_layout',
             'desc' => ''.$link.''.esc_html__( 'Select the template/layout that you want to display as the product template for the products in the category', 'divi-bodyshop-woocommerce' ).' '.$category->name.' - '.esc_html__( 'it will override the default one.', 'divi-bodyshop-woocommerce' ).'',
             'taxonomy' => 'product_cat',
           ) );


}
}
}



$product_page->createOption( array(
'type' => 'save',
) );

// sale Badge
$sale_badge->createOption( array(
'type' => 'save',
) );

$sale_badge->createOption( array(
'name' => '',
'id' => 'sale-badge-set-page',
'type' => 'text',
'default' => 'sale-badge',
) );

$sale_badge->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Sale Badge', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Enable Improved Sale Badge?', 'divi-bodyshop-woocommerce' ).' ',
'id' => 'other_settings_percentage_sales_enable',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want to display the product percentage saving on your special priced products rather than just the text "Sale!"', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Select Badge Design', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_design',
'type' => 'radio-image',
'options' => array(
'default' => DE_DB_WOO_URL . '/images/sales-badge/default.svg',
'star' => DE_DB_WOO_URL . '/images/sales-badge/star.svg',
'tag' => DE_DB_WOO_URL . '/images/sales-badge/tag.svg',
'sign' => DE_DB_WOO_URL . '/images/sales-badge/sign.svg',
'arrow-down' => DE_DB_WOO_URL . '/images/sales-badge/arrow-down.svg',
'sharp-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/sharp-ribbon.svg',
'down-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/down-ribbon.svg',
'single-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/single-ribbon.svg',
'christmas-tag' => DE_DB_WOO_URL . '/images/sales-badge/christmas-tag.svg',
'christmas-tree' => DE_DB_WOO_URL . '/images/sales-badge/christmas-tree.svg',
'christmas-ball' => DE_DB_WOO_URL . '/images/sales-badge/christmas-ball.svg',
),
'default' => 'default',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Primary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_primary',
'type' => 'color',
'default' => '#fa3e3e',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the main color of the badge, if only one color this will be used.', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Secondary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_secondary',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the secondary color of the badge, it will only be used if there are two colors - for example the Sign badge (forth along)', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Quaternary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_quaternary',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the quaternary(third) color of the badge, it will only be used if there are three colors - for example the Chistmas badges', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Position', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_position',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'right',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Edge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_edge_distance',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far left or right you want to the sale badge to be from the edge.(horizontal)', 'divi-bodyshop-woocommerce' ).'',
'default' => '10',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_top_distance',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far left or right you want to the sale badge to be from the top.(vertical)', 'divi-bodyshop-woocommerce' ).'',
'default' => '10',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_size',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how big you want the badge to be', 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '10',
'max' => '400',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Sale Badge Text', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Add Percentage?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_sale_badge_percentage_sign',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to remove the percentage amount and just have text, disable this.', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Absolute or Relative Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_absolute_relative_text',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'RELATIVE', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'ABSOLUTE', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Select absolute if you want to move the text independent of the badge. Select relative if you want the text to move when you move the badge so it is dependent on the position of the badge.', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Edge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_edge_distance_text',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far left or right you want to the sale badge text to be from the edge.(horizontal)', 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_top_distance_text',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far up or down you want to the sale badge text to be from the top.(vertical)', 'divi-bodyshop-woocommerce' ).'',
'default' => '10',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text Before Percentage', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_percentage_sales_before',
'type' => 'textarea',
'desc' => ''.esc_html__( 'Type the text you want before - for example you could have "-" to show it is the percentage off.', 'divi-bodyshop-woocommerce' ).' <br>
'.esc_html__( 'You can add a new line by adding "&lt;br&gt;" after the word, the next word after this will appear on a new line. So if you want the percentage to appear below this text, add "&lt;br&gt;" at the end of our word/s.', 'divi-bodyshop-woocommerce' ).''
) );
$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text After Percentage', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_percentage_sales_after',
'type' => 'textarea',
'desc' => ''.esc_html__( 'Type the text you want after - for example you could have "OFF" to show it is the percentage off', 'divi-bodyshop-woocommerce' ).' <br>
'.esc_html__( 'You can add a new line by adding', 'divi-bodyshop-woocommerce' ).' "&lt;br&gt;" '.esc_html__( 'after the word, the next word after this will appear on a new line. So if you want the percentage to appear below this text, add', 'divi-bodyshop-woocommerce' ).' "&lt;br&gt;" '.esc_html__( 'at the end of our word/s.', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_color',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the text', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_size',
'type' => 'number',
'desc' => ''.esc_html__( 'Change the font size of the badge', 'divi-bodyshop-woocommerce' ).'',
'default' => '18',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text Alignment', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_position',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'center' => ''.esc_html__( 'Center', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'center',
) );


$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Line Height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_line_height',
'type' => 'number',
'desc' => ''.esc_html__( 'If you have text after the percentage, you can change how far away it is below', 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );



// NEW BADGE

$sale_badge->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'New Badge', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Enable Improved New Badge?', 'divi-bodyshop-woocommerce' ).' ',
'id' => 'other_settings_percentage_sales_enable_new',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want to display a custom badge for new products, set the time a new product is referred to as new', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Display Time', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_new_display_time',
'type' => 'number',
'desc' => ''.esc_html__( 'Choose the amount of days you want the new badge to be shown for.', 'divi-bodyshop-woocommerce' ).'',
'default' => '30',
'min' => '0',
'max' => '360',
'step' => '1',
'unit' => ''.esc_html__( 'days', 'divi-bodyshop-woocommerce' ).'',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Select Badge Design', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_design_new',
'type' => 'radio-image',
'options' => array(
'default' => DE_DB_WOO_URL . '/images/sales-badge/default.svg',
'star' => DE_DB_WOO_URL . '/images/sales-badge/star.svg',
'tag' => DE_DB_WOO_URL . '/images/sales-badge/tag.svg',
'sign' => DE_DB_WOO_URL . '/images/sales-badge/sign.svg',
'arrow-down' => DE_DB_WOO_URL . '/images/sales-badge/arrow-down.svg',
'sharp-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/sharp-ribbon.svg',
'down-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/down-ribbon.svg',
'single-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/single-ribbon.svg',
'christmas-tag' => DE_DB_WOO_URL . '/images/sales-badge/christmas-tag.svg',
'christmas-tree' => DE_DB_WOO_URL . '/images/sales-badge/christmas-tree.svg',
'christmas-ball' => DE_DB_WOO_URL . '/images/sales-badge/christmas-ball.svg',
),
'default' => 'default',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Primary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_primary_new',
'type' => 'color',
'default' => '#fa3e3e',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the main color of the badge, if only one color this will be used.', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Secondary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_secondary_new',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the secondary color of the badge, it will only be used if there are two colors - for example the Sign badge (forth along)', 'divi-bodyshop-woocommerce' ).'',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Quaternary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_quaternary_new',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the quaternary(third) color of the badge, it will only be used if there are three colors - for example the Chistmas badges', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Position', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_position_new',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'right',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Edge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_edge_distance_new',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far left or right you want to the new badge to be from the edge.(horizontal)', 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_top_distance_new',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far up or down you want to the new badge to be from the top.(vertical)', 'divi-bodyshop-woocommerce' ).'',
'default' => '10',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_size_new',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how big you want the badge to be', 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '10',
'max' => '400',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'New Badge Text', 'divi-bodyshop-woocommerce' ).'</p>'
) );


$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Absolute or Relative Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_absolute_relative_text_new',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'RELATIVE', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'ABSOLUTE', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Select absolute if you want to move the text independent of the badge. Select relative if you want the text to move when you move the badge so it is dependent on the position of the badge.', 'divi-bodyshop-woocommerce' ).'',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Edge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_edge_distance_text_new',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far left or right you want to the new badge text to be from the edge.(horizontal)', 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_top_distance_text_new',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far up or down you want to the new badge text to be from the top.(vertical)', 'divi-bodyshop-woocommerce' ).'',
'default' => '10',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text On Badge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_new_sale_badge_text',
'type' => 'textarea',
'desc' => ''.esc_html__( 'Type the text you want to be shown on the badge - for example "New".', 'divi-bodyshop-woocommerce' ).' <br>
'.esc_html__( 'You can add a new line by adding "&lt;br&gt;" after the word, the next word after this will appear on a new line.', 'divi-bodyshop-woocommerce' ).'',
'default' => "NEW"
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_color_new',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the text', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_size_new',
'type' => 'number',
'desc' => ''.esc_html__( 'Change the font size of the badge', 'divi-bodyshop-woocommerce' ).'',
'default' => '18',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text Alignment', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_position_new',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'center' => ''.esc_html__( 'Center', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'center',
) );


$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Line Height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_line_height_new',
'type' => 'number',
'desc' => ''.esc_html__( 'If you have text after the percentage, you can change how far away it is below', 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );


// FREE BADGE

$sale_badge->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Free Badge', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Enable Improved Free Badge?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_percentage_sales_enable_free',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want to display a custom badge for free products.', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Select Badge Design', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_design_free',
'type' => 'radio-image',
'options' => array(
'default' => DE_DB_WOO_URL . '/images/sales-badge/default.svg',
'star' => DE_DB_WOO_URL . '/images/sales-badge/star.svg',
'tag' => DE_DB_WOO_URL . '/images/sales-badge/tag.svg',
'sign' => DE_DB_WOO_URL . '/images/sales-badge/sign.svg',
'arrow-down' => DE_DB_WOO_URL . '/images/sales-badge/arrow-down.svg',
'sharp-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/sharp-ribbon.svg',
'down-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/down-ribbon.svg',
'single-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/single-ribbon.svg',
'christmas-tag' => DE_DB_WOO_URL . '/images/sales-badge/christmas-tag.svg',
'christmas-tree' => DE_DB_WOO_URL . '/images/sales-badge/christmas-tree.svg',
'christmas-ball' => DE_DB_WOO_URL . '/images/sales-badge/christmas-ball.svg',
),
'default' => 'default',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Primary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_primary_free',
'type' => 'color',
'default' => '#fa3e3e',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the main color of the badge, if only one color this will be used.', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Secondary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_secondary_free',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the secondary color of the badge, it will only be used if there are two colors - for example the Sign badge (forth along)', 'divi-bodyshop-woocommerce' ).'',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Quaternary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_quaternary_free',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the quaternary(third) color of the badge, it will only be used if there are three colors - for example the Chistmas badges', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Position', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_position_free',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'right',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Edge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_edge_distance_free',
'type' => 'number',
'desc' => 'Set how far left or right you want to the free badge to be from the edge.(horizontal)',
'default' => '0',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_top_distance_free',
'type' => 'number',
'desc' => 'Set how far up or down you want to the free badge to be from the top.(vertical)',
'default' => '10',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_size_free',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how big you want the badge to be', 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '10',
'max' => '400',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'type' => 'note',
'desc' => '<p class="title">Free Badge Text</p>'
) );


$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Absolute or Relative Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_absolute_relative_text_free',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'RELATIVE', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'ABSOLUTE', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Select absolute if you want to move the text independent of the badge. Select relative if you want the text to move when you move the badge so it is dependent on the position of the badge.', 'divi-bodyshop-woocommerce' ).'',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Edge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_edge_distance_text_free',
'type' => 'number',
'desc' => 'Set how far left or right you want to the free badge text to be from the edge.(horizontal)',
'default' => '0',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_top_distance_text_free',
'type' => 'number',
'desc' => 'Set how far up or down you want to the free badge text to be from the top.(vertical)',
'default' => '10',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text On Badge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_free_sale_badge_text',
'type' => 'textarea',
'desc' => ''.esc_html__( 'Type the text you want to be shown on the badge - for example "New".', 'divi-bodyshop-woocommerce' ).' <br>
You can add a free line by adding "&lt;br&gt;" after the word, the next word after this will appear on a free line.',
'default' => 'FREE'
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_color_free',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the text', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_size_free',
'type' => 'number',
'desc' => ''.esc_html__( 'Change the font size of the badge', 'divi-bodyshop-woocommerce' ).'',
'default' => '18',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text Alignment', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_position_free',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'center' => ''.esc_html__( 'Center', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'center',
) );


$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Line Height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_line_height_free',
'type' => 'number',
'desc' => ''.esc_html__( 'If you have text after the percentage, you can change how far away it is below', 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

// OUT OF STOCK BADGE

$sale_badge->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Out Of Stock Badge', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Enable Improved Out Of Stock Badge?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_percentage_sales_enable_ofs',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want to display a custom badge for out of stock products.', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Select Badge Design', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_design_ofs',
'type' => 'radio-image',
'options' => array(
'default' => DE_DB_WOO_URL . '/images/sales-badge/default.svg',
'star' => DE_DB_WOO_URL . '/images/sales-badge/star.svg',
'tag' => DE_DB_WOO_URL . '/images/sales-badge/tag.svg',
'sign' => DE_DB_WOO_URL . '/images/sales-badge/sign.svg',
'arrow-down' => DE_DB_WOO_URL . '/images/sales-badge/arrow-down.svg',
'sharp-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/sharp-ribbon.svg',
'down-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/down-ribbon.svg',
'single-ribbon' => DE_DB_WOO_URL . '/images/sales-badge/single-ribbon.svg',
'christmas-tag' => DE_DB_WOO_URL . '/images/sales-badge/christmas-tag.svg',
'christmas-tree' => DE_DB_WOO_URL . '/images/sales-badge/christmas-tree.svg',
'christmas-ball' => DE_DB_WOO_URL . '/images/sales-badge/christmas-ball.svg',
),
'default' => 'default',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Primary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_primary_ofs',
'type' => 'color',
'default' => '#fa3e3e',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the main color of the badge, if only one color this will be used.', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Secondary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_secondary_ofs',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the secondary color of the badge, it will only be used if there are two colors - for example the Sign badge (forth along)', 'divi-bodyshop-woocommerce' ).'',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Quaternary Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_color_quaternary_ofs',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the quaternary(third) color of the badge, it will only be used if there are three colors - for example the Chistmas badges', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Position', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_position_ofs',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'right',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Edge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_edge_distance_ofs',
'type' => 'number',
'desc' => 'Set how far left or right you want to the free badge to be from the edge.(horizontal)',
'default' => '0',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_top_distance_ofs',
'type' => 'number',
'desc' => 'Set how far up or down you want to the free badge to be from the top.(vertical)',
'default' => '10',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_size_ofs',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how big you want the badge to be', 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '10',
'max' => '400',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'type' => 'note',
'desc' => '<p class="title">Out Of Stock Badge Text</p>'
) );


$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Absolute or Relative Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_absolute_relative_text_ofs',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'RELATIVE', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'ABSOLUTE', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Select absolute if you want to move the text independent of the badge. Select relative if you want the text to move when you move the badge so it is dependent on the position of the badge.', 'divi-bodyshop-woocommerce' ).'',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Edge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_edge_distance_text_ofs',
'type' => 'number',
'desc' => 'Set how far left or right you want to the free badge text to be from the edge.(horizontal)',
'default' => '0',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Distance from Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_top_distance_text_ofs',
'type' => 'number',
'desc' => 'Set how far up or down you want to the free badge text to be from the top.(vertical)',
'default' => '10',
'min' => '-100',
'max' => '1500',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text On Badge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_ofs_sale_badge_text',
'type' => 'textarea',
'desc' => ''.esc_html__( 'Type the text you want to be shown on the badge - for example "Out of stock".', 'divi-bodyshop-woocommerce' ).' <br>
You can add a free line by adding "&lt;br&gt;" after the word, the next word after this will appear on a free line.',
'default' => 'Out of stock'
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_color_ofs',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Change the color of the text', 'divi-bodyshop-woocommerce' ).''
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_size_ofs',
'type' => 'number',
'desc' => ''.esc_html__( 'Change the font size of the badge', 'divi-bodyshop-woocommerce' ).'',
'default' => '18',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Text Alignment', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_position_ofs',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'center' => ''.esc_html__( 'Center', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'center',
) );


$sale_badge->createOption( array(
'name' => ''.esc_html__( 'Line Height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_sale_badge_text_line_height_ofs',
'type' => 'number',
'desc' => ''.esc_html__( 'If you have text after the percentage, you can change how far away it is below', 'divi-bodyshop-woocommerce' ).'',
'default' => '60',
'min' => '0',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );


$sale_badge->createOption( array(
'type' => 'save',
) );
// Email

$email_templates->createOption( array(
'type' => 'save',
) );

$email_templates->createOption( array(
'name' => '',
'id' => 'email-template-set-page',
'type' => 'text',
'default' => 'email',
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Use Custom Email Template?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'enable_email_template',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$email_templates->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Customise Your Email Template', 'divi-bodyshop-woocommerce' ).'</p><br>
          '.esc_html__( 'You can use the settings below to customise the email and preview how it will look at the bottom of this page. You will need to save your changes for it to change on the preview.', 'divi-bodyshop-woocommerce' ).''
) );

$email_templates->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( '1. Appearance', 'divi-bodyshop-woocommerce' ).'</p>'
) );


$email_templates->createOption( array(
'name' => ''.esc_html__( 'Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_bg_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'This is the color that sits behind the main body.', 'divi-bodyshop-woocommerce' ).''
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Accent Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_accent_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'The accent color is the color used for links etc - just like Divi Accent Colour, this will be used for links and h1,h2,h3', 'divi-bodyshop-woocommerce' ).''
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Body Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_body_bg_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'The background color of the actual email', 'divi-bodyshop-woocommerce' ).''
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Enable Body Shadow', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_enable_body_shadow',
'type' => 'enable',
'default' => true,
'yes' => ''.esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ).'',
'no' => ''.esc_html__( 'No', 'divi-bodyshop-woocommerce' ).'',
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Enable Body Border', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_enable_body_border',
'type' => 'enable',
'default' => true,
'yes' => ''.esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ).'',
'no' => ''.esc_html__( 'No', 'divi-bodyshop-woocommerce' ).'',
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Paragraph Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'Colour of the text in the email (no the links)', 'divi-bodyshop-woocommerce' ).''
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Page width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_page_width',
'type' => 'number',
'desc' => ''.esc_html__( 'Set the width of your page, please note that it is not recommended to go over 800px for emails.', 'divi-bodyshop-woocommerce' ).'',
'default' => '600',
'min' => '0',
'max' => '1000',
'step' => '1',
'unit' => 'px',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Border Radius', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_border_radius',
'type' => 'number',
'default' => '0',
'min' => '0',
'max' => '200',
'step' => '1',
'unit' => 'px',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'h1 Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_h1_font_size',
'type' => 'number',
'default' => '25',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'h2 Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_h2_font_size',
'type' => 'number',
'default' => '14',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'h3 Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_h3_font_size',
'type' => 'number',
'default' => '13',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Paragraph Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_p_font_size',
'type' => 'number',
'default' => '12',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Paragraph Line Height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_paragraph_line_height',
'type' => 'number',
'default' => '1.7',
'min' => '1',
'max' => '3',
'step' => '0.1',
'unit' => 'em',
) );

$email_templates->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( '2. Header', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Header Logo', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_header_logo',
'type' => 'upload',
'desc' => ''.esc_html__( 'Upload your logo', 'divi-bodyshop-woocommerce' ).'',
'size' => 'full',
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Header Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_header_bg_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );$email_templates->createOption( array(
'name' => ''.esc_html__( 'Header Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_header_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Text/Logo Alignment', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_header_alignment',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'center' => ''.esc_html__( 'Center', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'center',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Logo Height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_header_logo_height',
'type' => 'number',
'default' => '100',
'min' => '1',
'max' => '600',
'step' => '1',
'unit' => 'px',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Padding Below Logo', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_header_logo_padding_below',
'type' => 'number',
'default' => '0',
'min' => '0',
'max' => '500',
'step' => '1',
'unit' => 'px',
) );

$email_templates->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( '3. Order Details Table', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$email_templates->createOption( array(
'name' => 'Content Before Table',
'id' => 'BodyCommerce_content_before_table',
'type' => 'editor',
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Table Border Width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_table_border_width',
'type' => 'number',
'default' => '1',
'min' => '0',
'max' => '10',
'step' => '1',
'unit' => 'px',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Table Border Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_table_border_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Table Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_table_bg_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Enable Product Image', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_enable_image',
'type' => 'enable',
'default' => false,
'yes' => ''.esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ).'',
'no' => ''.esc_html__( 'No', 'divi-bodyshop-woocommerce' ).'',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Product Image Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_enable_image_size',
'type' => 'select',
'options' => array(
'32' => '32px x 32px',
'64' => '64px x 64px',
'150' => '150px x 150px',
),
'default' => '32',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Show SKU to customer?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_customer_sku',
'type' => 'enable',
'default' => false,
'yes' => ''.esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ).'',
'no' => ''.esc_html__( 'No', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'By default the SKU is not sent to the customer, enable this if you want this to be sent to them.', 'divi-bodyshop-woocommerce' ).''
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Content After Table', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_content_after_table',
'type' => 'editor',
) );

$email_templates->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( '4. Footer', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Footer Logo', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_footer_logo',
'type' => 'upload',
'desc' => ''.esc_html__( 'Upload your logo', 'divi-bodyshop-woocommerce' ).'',
'size' => 'full',
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Footer Logo Link', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_footer_logo_link',
'type' => 'text',
'desc' => ''.esc_html__( 'Add a link for your footer logo', 'divi-bodyshop-woocommerce' ).'',
'default' => '',
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Footer Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_footer_bg_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Footer Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_footer_text_color',
'type' => 'color',
'default' => '#c09bb9',
'alpha'  => 'true',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Text/Logo Alignment', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_footer_alignment',
'type' => 'select',
'options' => array(
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
'center' => ''.esc_html__( 'Center', 'divi-bodyshop-woocommerce' ).'',
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'center',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Logo height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_footer_logo_height',
'type' => 'number',
'default' => '100',
'min' => '1',
'max' => '600',
'step' => '1',
'unit' => 'px',
) );
$email_templates->createOption( array(
'name' => ''.esc_html__( 'Footer Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'BodyCommerce_email_footer_text',
'type' => 'editor',
) );


// Appearance
$get_BodyCommerce_email_bg_color = $titan->getOption( 'BodyCommerce_email_bg_color' ); //DONE
$get_BodyCommerce_email_accent_color = $titan->getOption( 'BodyCommerce_email_accent_color' ); //DONE
$get_BodyCommerce_email_body_bg_color = $titan->getOption( 'BodyCommerce_email_body_bg_color' );//DONE
$get_BodyCommerce_email_text_color = $titan->getOption( 'BodyCommerce_email_text_color' );//DONE
$get_BodyCommerce_email_page_width = $titan->getOption( 'BodyCommerce_email_page_width' );//DONE
$get_BodyCommerce_email_border_radius = $titan->getOption( 'BodyCommerce_email_border_radius' );//DONE
$get_BodyCommerce_email_h1_font_size = $titan->getOption( 'BodyCommerce_email_h1_font_size' );// DONE
$get_BodyCommerce_email_h2_font_size = $titan->getOption( 'BodyCommerce_email_h2_font_size' );// DONE
$get_BodyCommerce_email_h3_font_size = $titan->getOption( 'BodyCommerce_email_h3_font_size' );//DONE
$get_BodyCommerce_email_p_font_size = $titan->getOption( 'BodyCommerce_email_p_font_size' );//DONE
$get_BodyCommerce_email_paragraph_line_height = $titan->getOption( 'BodyCommerce_email_paragraph_line_height' );//DONE

$BodyCommerce_enable_body_shadow = $titan->getOption( 'BodyCommerce_enable_body_shadow' );
$BodyCommerce_enable_body_border = $titan->getOption( 'BodyCommerce_enable_body_border' );

if ($BodyCommerce_enable_body_shadow == 1) {$BodyCommerce_enable_body_shadow_dis = "box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important;"; } else {$BodyCommerce_enable_body_shadow_dis = ""; };
if ($BodyCommerce_enable_body_border == 1) {$BodyCommerce_enable_body_border_dis = "border: 1px solid #dedede;"; } else {$BodyCommerce_enable_body_border_dis = "border:none;"; };

// Header
$get_BodyCommerce_email_header_logo = $titan->getOption( 'BodyCommerce_email_header_logo' ); // DONE
if (is_array($get_BodyCommerce_email_header_logo)) {
$get_BodyCommerce_email_header_logo_attachment = wp_get_attachment_image_src( $get_BodyCommerce_email_header_logo, $size = 'full', $icon = false);
$header_logo = $get_BodyCommerce_email_header_logo_attachment[0];
} else {
  $header_logo = "";
}
$get_BodyCommerce_email_header_logo_height = $titan->getOption( 'BodyCommerce_email_header_logo_height' ); //DONE
$get_BodyCommerce_email_header_logo_padding_below = $titan->getOption( 'BodyCommerce_email_header_logo_padding_below' ); //DONE
$get_BodyCommerce_email_header_bg_color = $titan->getOption( 'BodyCommerce_email_header_bg_color' );//DONE

if ($get_BodyCommerce_email_header_bg_color == ""){ $get_BodyCommerce_email_header_bg_color_display = "#96588a";}else {$get_BodyCommerce_email_header_bg_color_display = $get_BodyCommerce_email_header_bg_color;}

$get_BodyCommerce_email_header_text_color = $titan->getOption( 'BodyCommerce_email_header_text_color' ); //DONE
if ($get_BodyCommerce_email_header_text_color == "") {$get_BodyCommerce_email_header_text_color_display = "#ffffff";} else {$get_BodyCommerce_email_header_text_color_display = $get_BodyCommerce_email_header_text_color;}
$get_BodyCommerce_email_header_alignment = $titan->getOption( 'BodyCommerce_email_header_alignment' ); //DONE

// Order Details
$get_BodyCommerce_email_table_border_width = $titan->getOption( 'BodyCommerce_email_table_border_width' ); //DONE
$get_BodyCommerce_email_table_border_color = $titan->getOption( 'BodyCommerce_email_table_border_color' ); //DONE //DONE
$get_BodyCommerce_email_table_bg_color = $titan->getOption( 'BodyCommerce_email_table_bg_color' ); //DONE

// Footer
$get_BodyCommerce_email_footer_logo = $titan->getOption( 'BodyCommerce_email_footer_logo' );//DONE
if ($get_BodyCommerce_email_footer_logo) {
$get_BodyCommerce_email_footer_logo_attachment = wp_get_attachment_image_src( $get_BodyCommerce_email_footer_logo, $size = 'full', $icon = false );
$footer_logo = $get_BodyCommerce_email_footer_logo_attachment[0];
} else {
  $footer_logo = "";
}
$BodyCommerce_email_footer_logo_link = $titan->getOption( 'BodyCommerce_email_footer_logo_link' );//DONE
$get_BodyCommerce_email_footer_logo_height = $titan->getOption( 'BodyCommerce_email_footer_logo_height' );//DONE
$get_BodyCommerce_email_footer_bg_color = $titan->getOption( 'BodyCommerce_email_footer_bg_color' );//DONE
$get_BodyCommerce_email_footer_text_color = $titan->getOption( 'BodyCommerce_email_footer_text_color' );//DONE
$get_BodyCommerce_email_footer_alignment = $titan->getOption( 'BodyCommerce_email_footer_alignment' );//DONE
$get_BodyCommerce_email_footer_text = $titan->getOption( 'BodyCommerce_email_footer_text' );//DONE


$get_BodyCommerce_content_before_table = $titan->getOption( 'BodyCommerce_content_before_table' );//DONE
$get_BodyCommerce_content_after_table = $titan->getOption( 'BodyCommerce_content_after_table' );//DONE


$get_BodyCommerce_enable_image = $titan->getOption( 'BodyCommerce_enable_image' );
$get_BodyCommerce_enable_image_size = $titan->getOption( 'BodyCommerce_enable_image_size' );
$get_BodyCommerce_customer_sku = $titan->getOption( 'BodyCommerce_customer_sku' );

if ($get_BodyCommerce_enable_image == "yes" ) {
  $test_product_image = DE_DB_WOO_URL . "/images/T_7_front.jpg";
  $test_product_image2 = DE_DB_WOO_URL . "/images/T_5_front.jpg";

  $product_image_bc1 = '<img src="'.$test_product_image.'" height="'.$get_BodyCommerce_enable_image_size.'" width="'.$get_BodyCommerce_enable_image_size.'">';
  $product_image_bc2 = '<img src="'.$test_product_image2.'" height="'.$get_BodyCommerce_enable_image_size.'" width="'.$get_BodyCommerce_enable_image_size.'">';
}
else {
$product_image_bc1 = '';
$product_image_bc2 = '';
}

if ($get_BodyCommerce_customer_sku == "yes") {
  $test_product_sku = "(#sku001)";
  $test_product_sku2 = "(#sku002)";
}
else {
  $test_product_sku = "";
  $test_product_sku2 = "";
}

$email_templates->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( '5. Preview your email', 'divi-bodyshop-woocommerce' ).'</p>'
) );

$email_templates->createOption( array(
'name' => ''.esc_html__( 'Email Preview', 'divi-bodyshop-woocommerce' ).'',
'type' => 'custom',
'custom' => '
<div class="info">
<p>'.esc_html__( 'You need to save this page before it displayed the correct preview.', 'divi-bodyshop-woocommerce' ).'</p>
</div>
<div id="wrapper" dir="ltr" style="'.$get_BodyCommerce_email_bg_color.'; margin: 0;  -webkit-text-size-adjust: none !important; width: 100%;">
			<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
      <tr>
<td align="center" valign="top" style="background-color: '.$get_BodyCommerce_email_bg_color.'; padding-bottom:0;">
						<div id="template_header_image">
													</div>
						<table border="0" cellpadding="0" cellspacing="0" width="'.$get_BodyCommerce_email_page_width.'" id="template_container" style="display: block;'.$BodyCommerce_enable_body_shadow_dis.''.$BodyCommerce_enable_body_border_dis.'" >
<tr class="header" style="    background-color: transparent; display: block; width:'.$get_BodyCommerce_email_page_width.'px">

<td align="'.$get_BodyCommerce_email_header_alignment.'" valign="top" style="display: block;margin-bottom: 0;background-color:'.$get_BodyCommerce_email_header_bg_color_display.';padding: 36px 48px;border-radius: '.$get_BodyCommerce_email_border_radius.'px '.$get_BodyCommerce_email_border_radius.'px 0px 0px;">

            			<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: '.$get_BodyCommerce_email_header_bg_color_display.'; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;"><tr style="background-color:'.$get_BodyCommerce_email_header_bg_color_display.';>
<td id="header_wrapper" style="padding: 36px 48px; display: block;padding: 36px 48px;">
<img src="'.$header_logo.'" height="'.$get_BodyCommerce_email_header_logo_height.'" style="padding-bottom:'.$get_BodyCommerce_email_header_logo_padding_below.'px;">
												<p id="h1" style="color: '.$get_BodyCommerce_email_header_text_color_display.'; font-size: '.$get_BodyCommerce_email_h1_font_size.'px; font-weight: 300; line-height: 150%; margin: 0; -webkit-font-smoothing: antialiased;">'.esc_html__( 'Thank you for your order (h1)', 'divi-bodyshop-woocommerce' ).'</p>
											</td>
										</tr></table>
<!-- End Header -->
</td>
							</tr>
<tr class="body" style="border-right: none !important;border-left: none !important;background-color:'.$get_BodyCommerce_email_body_bg_color.';display: block;width:'.$get_BodyCommerce_email_page_width.'px">
<td align="center" valign="top" style="padding:0;">
									<!-- Body -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_body">

                  <tr style="background-color:'.$get_BodyCommerce_email_body_bg_color.';">
<td valign="top" id="body_content" style="background-color:'.$get_BodyCommerce_email_body_bg_color.';padding:0;">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%"><tr>
<td valign="top" style="padding: 48px;background-color:'.$get_BodyCommerce_email_body_bg_color.';">
															<div id="body_content_inner" style="color:'.$get_BodyCommerce_email_text_color.'; font-size: '.$get_BodyCommerce_email_p_font_size.'px; line-height: 150%; text-align: left;">
                              <p id="h2" style="color: '.$get_BodyCommerce_email_accent_color.'; display: block; font-size: '.$get_BodyCommerce_email_h2_font_size.'px; font-weight: bold; line-height: 130%; margin: 16px 0 8px; text-align: left;">Lorem ipsum dolor (h2)</p>
<p style="margin: 0 0 16px;font-size: '.$get_BodyCommerce_email_p_font_size.'px;line-height:'.$get_BodyCommerce_email_paragraph_line_height.'">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquet diam a facilisis eleifend. Cras ac justo felis. Mauris faucibus, orci eu blandit fermentum, lorem nibh sollicitudin mi, sit amet interdum metus urna ut lacus.</p>
<p style="margin: 0 0 16px;font-size: '.$get_BodyCommerce_email_p_font_size.'px;line-height:'.$get_BodyCommerce_email_paragraph_line_height.'">Phasellus quis varius augue. Fusce eu euismod leo, a accumsan tellus. Quisque vitae dolor eu justo cursus egestas. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sit amet sapien odio. Sed pellentesque arcu mi, quis malesuada lectus lacinia et. Cras a tempor leo.</p>
<p id="h3" style="color: '.$get_BodyCommerce_email_accent_color.'; display: block; font-size: '.$get_BodyCommerce_email_h3_font_size.'px; font-weight: bold; line-height: 130%; margin: 16px 0 8px; text-align: left;">Lorem ipsum dolor (h3)</p>
<p style="margin: 0 0 16px;font-size: '.$get_BodyCommerce_email_p_font_size.'px;line-height:'.$get_BodyCommerce_email_paragraph_line_height.'">Fusce eu euismod leo, a accumsan tellus. Quisque vitae dolor eu justo cursus egestas. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed sit amet sapien odio. Sed pellentesque arcu mi, quis malesuada lectus lacinia et. Cras a tempor leo.</p>
															</div>
														</td>
													</tr></table>


<table border="0" cellpadding="20" cellspacing="0" width="100%"><tr>
<td valign="top" style="padding: 20px 48px;">
      <div id="body_content_inner" style="color:'.$get_BodyCommerce_email_text_color.'; font-size: '.$get_BodyCommerce_email_p_font_size.'px; line-height: 150%; text-align: left;">
'.$get_BodyCommerce_content_before_table.'
    </div>
    </td>
  </tr>
  </table>


                          <table id="divi-engine-order-items-table" cellspacing="0" cellpadding="6" style="width: 100%; color: #000000; font-size: 14px; padding:0px 48px 48px 48px;">
<thead><tr style="background-color:'.$get_BodyCommerce_email_table_bg_color.';">
<th id="divi-engine-th-title-product" class="divi-engine-order-items-table-element" scope="col" style="padding: 6px; border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; height: 20px;">Product</th>
<th id="divi-engine-th-title-quantity" class="divi-engine-order-items-table-element" scope="col" style="padding: 6px; border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; height: 20px;">Quantity</th>
<th id="divi-engine-th-title-price" class="divi-engine-order-items-table-element" scope="col" style="padding: 6px; border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; background: #ffffff; height: 20px;">Price</th>
</tr></thead>
<tbody>
<tr style="background-color:'.$get_BodyCommerce_email_table_bg_color.';">
<td class="divi-engine-order-items-table-element not_last" style="text-align: left; vertical-align: middle; word-wrap: break-word; border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">
<table class="divi-engine-order-items-table-product-title" style="color: #000000; font-size: 14px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;"><tr style="background-color:'.$get_BodyCommerce_email_table_bg_color.';">
<td class="divi-engine-no-border" style="vertical-align: middle; padding: 0 !important; border: none !important; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">
'.$product_image_bc1.'
<span style="display: block;">Happy Ninja '.$test_product_sku.'</span>

</td>
</tr></table>
</td>
<td class="divi-engine-order-items-table-el-quantity-not_last" style="vertical-align: middle; border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">1</td>
<td class="divi-engine-order-items-table-el-price-not_last" style="vertical-align: middle; border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">$30.00</td>
</tr>
<tr style="background-color:'.$get_BodyCommerce_email_table_bg_color.';">
<td class="divi-engine-order-items-table-element last" style="text-align: left; vertical-align: middle; word-wrap: break-word; border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">
<table class="divi-engine-order-items-table-product-title" style="color: #000000; font-size: 14px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;"><tr style="background-color:'.$get_BodyCommerce_email_table_bg_color.';">
<td class="divi-engine-no-border" style="vertical-align: middle; padding: 0 !important; border: none !important; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">

'.$product_image_bc2.'
<span style="display: block;">Ninja Silhouette '.$test_product_sku2.'</span>

</td>
</tr></table>
</td>
<td class="divi-engine-order-items-table-el-quantity-last" style="vertical-align: middle; border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">3</td>
<td class="divi-engine-order-items-table-el-price-last" style="vertical-align: middle; border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">$23.00</td>
</tr>
</tbody>
<tfoot>
<tr style="background-color:'.$get_BodyCommerce_email_table_bg_color.';">
<th class="divi-engine-order-items-table-element divi-engine-order-items-table-element-bigtop not_last" scope="row" colspan="2" style="border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; padding: 12px;">Subtotal</th>
<td class="divi-engine-order-items-table-element divi-engine-order-items-table-element-bigtop not_last" style="border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">$99,00</td>
</tr>
<tr style="background-color:'.$get_BodyCommerce_email_table_bg_color.';">
<th class="divi-engine-order-items-table-element  not_last" scope="row" colspan="2" style="border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; padding: 12px;">Shipping</th>
<td class="divi-engine-order-items-table-element  not_last" style="border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">Free Shipping</td>
</tr>
<tr style="background-color:'.$get_BodyCommerce_email_table_bg_color.';">
<th class="divi-engine-order-items-table-element  not_last" scope="row" colspan="2" style="border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; padding: 12px;">Payment</th>
<td class="divi-engine-order-items-table-element  not_last" style="border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">PayPal</td>
</tr>
<tr style="background-color:'.$get_BodyCommerce_email_table_bg_color.';">
<th class="divi-engine-order-items-table-element  last" scope="row" colspan="2" style="border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; padding: 12px;">Total</th>
<td class="divi-engine-order-items-table-element  last" style="border: '.$get_BodyCommerce_email_table_border_width.'px solid '.$get_BodyCommerce_email_table_border_color.'; border-collapse: collapse; border-spacing: 0; text-align: left; padding: 12px; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif;">$99,00</td>
</tr>
</tfoot>
</table>

<table border="0" cellpadding="20" cellspacing="0" width="100%"><tr>
<td valign="top" style="padding: 20px 48px;">
      <div id="body_content_inner" style="color:'.$get_BodyCommerce_email_text_color.'; font-size: '.$get_BodyCommerce_email_p_font_size.'px; line-height: 150%; text-align: left;">
'.$get_BodyCommerce_content_after_table.'
    </div>
    </td>
  </tr>
  </table>

</div>
</td>
</tr></table>
<!-- End Content -->
</td>
										</tr></table>
<!-- End Body -->
</td>
							</tr>
<tr class="footer" style="background-color:'.$get_BodyCommerce_email_bg_color.';">
<td align="center" valign="top"style="padding:0;border-radius: 0px 0px '.$get_BodyCommerce_email_border_radius.'px '.$get_BodyCommerce_email_border_radius.'px;">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="'.$get_BodyCommerce_email_page_width.'" id="template_footer"><tr style="background-color:'.$get_BodyCommerce_email_footer_bg_color.';">
<td valign="top" style="padding: 0; -webkit-border-radius: 6px;">
												<table border="0" cellpadding="10" cellspacing="0" width="100%"><tr style="background-color:'.$get_BodyCommerce_email_footer_bg_color.';">
<td colspan="2" valign="middle" id="credit" style="color:'.$get_BodyCommerce_email_footer_text_color.';padding: 48px; -webkit-border-radius: 6px; border: 0;text-align: '.$get_BodyCommerce_email_footer_alignment.';">
<a href="'.$BodyCommerce_email_footer_logo_link.'"><img src="'.$footer_logo.'" height="'.$get_BodyCommerce_email_footer_logo_height.'"></a>
                            	'.$get_BodyCommerce_email_footer_text.'
														</td>
													</tr></table>
</td>
										</tr></table>
<!-- End Footer -->
</td>
							</tr>
</table>
</td>
				</tr></table>
</div>


',
) );

$email_templates->createOption( array(
'type' => 'save',
) );


// account

$my_account_page->createOption( array(
'type' => 'save',
) );


$my_account_page->createOption( array(
'type' => 'heading',
'desc' => ''.esc_html__( 'Account Page Templates', 'divi-bodyshop-woocommerce' ).''
) );

$my_account_page->createOption( array(
'type' => 'note',
'desc' => '<a href="https://help.diviengine.com/category/9-divi-bodycommerceaccount-section/" target="_blank">'.esc_html__( 'Read about how to create your account section here', 'divi-bodyshop-woocommerce' ).'</a><br>
          '.esc_html__( 'Select the layout that you want to replace the default account navigation. Make sure you include the links to the relevant pages for your account NAVIGATION - see below:', 'divi-bodyshop-woocommerce' ).'<br>
          '.esc_html__( '1) Orders: yourdomain.com/my-account/orders/', 'divi-bodyshop-woocommerce' ).'<br>
          '.esc_html__( '2) Downloads: yourdomain.com/my-account/downloads/', 'divi-bodyshop-woocommerce' ).'<br>
          '.esc_html__( '3) Addresses: yourdomain.com/my-account/edit-address/', 'divi-bodyshop-woocommerce' ).'<br>
          '.esc_html__( '4) Edit Account: yourdomain.com/my-account/edit-account/', 'divi-bodyshop-woocommerce' ).'<br>
          '.esc_html__( '5) Log Out: yourdomain.com/my-account/customer-logout/', 'divi-bodyshop-woocommerce' ).'<br>
          '
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_acount_page_layout_before'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_acount_page_layout_before'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account Before Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_page_layout_before',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have it as nothing. If you want a layout before the account section, add it here.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_acount_page_nav_layout'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_acount_page_nav_layout'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account Navigation Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_page_nav_layout',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );


$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_acount_page_dash_layout'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_acount_page_dash_layout'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account Dashboard Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_page_dash_layout',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_acount_page_orders_layout'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_acount_page_orders_layout'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account Orders Page Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_page_orders_layout',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_account_orders_view_order'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_account_orders_view_order'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account View Orders Page Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_account_orders_view_order',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_acount_page_edit_account_layout'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_acount_page_edit_account_layout'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account Edit Account Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_page_edit_account_layout',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_acount_page_my_addresses_layout'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_acount_page_my_addresses_layout'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account My Addresses Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_page_my_addresses_layout',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

// $mydata = get_option( 'divi-bodyshop-woo_options' );
// $mydata = get_option( 'divi-bodyshop-woo_options' );
// $mydata = unserialize($mydata);
// if (!isset($mydata['my_acount_page_edit_addresses_layout'])) {
//   $page_template = "";
// } else {
//   $page_template = $mydata['my_acount_page_edit_addresses_layout'] ?: "";
// }

// $admin_url = get_admin_url();
// if ($page_template == "") {$link = "";} else {
// $html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
// $link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
// }
//
// $my_account_page->createOption( array(
// 'name' => ''.esc_html__( 'Select Account Edit Addresses Layout', 'divi-bodyshop-woocommerce' ).'',
// 'id' => 'my_acount_page_edit_addresses_layout',
// 'type' => 'select-posts',
// 'post_type' => 'et_pb_layout',
// 'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template. This is the template that shows when click on "edit" on one of the addresses', 'divi-bodyshop-woocommerce' ).'',
// ) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_acount_page_my_payment_details_layout'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_acount_page_my_payment_details_layout'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account Payment Methods Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_page_my_payment_details_layout',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

// $mydata = get_option( 'divi-bodyshop-woo_options' );
// $mydata = unserialize($mydata);
// if (!isset($mydata['my_acount_page_my_payment_details_layout_add'])) {
//   $page_template = "";
// } else {
//   $page_template = $mydata['my_acount_page_my_payment_details_layout_add'] ?: "";
// }

// $admin_url = get_admin_url();
// if ($page_template == "") {$link = "";} else {
// $html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
// $link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
// }
//
// $my_account_page->createOption( array(
// 'name' => ''.esc_html__( 'Select Account Add Payment Method Layout', 'divi-bodyshop-woocommerce' ).'',
// 'id' => 'my_acount_page_my_payment_details_layout_add',
// 'type' => 'select-posts',
// 'post_type' => 'et_pb_layout',
// 'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
// ) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_acount_page_downloads_layout'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_acount_page_downloads_layout'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account Downloads Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_page_downloads_layout',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have the default WooCommerce template.', 'divi-bodyshop-woocommerce' ).'',
) );

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (!isset($mydata['my_acount_page_layout_after'])) {
  $page_template = "";
} else {
  $page_template = $mydata['my_acount_page_layout_after'] ?: "";
}

$admin_url = get_admin_url();
if ($page_template == "") {$link = "";} else {
$html_link = ''.$admin_url.'post.php?post='.$page_template.'&action=edit';
$link = '<a class="button btn" href="'.$html_link.'" target="_blank">'.esc_html__( 'Edit this layout', 'divi-bodyshop-woocommerce' ).'</a><br>';
}

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Select Account After Layout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_page_layout_after',
'type' => 'select-posts',
'post_type' => 'et_pb_layout',
'desc' => ''.$link.''.esc_html__( 'Leave or change to -Select- to have it as nothing. If you want a layout after the account section, add it here.', 'divi-bodyshop-woocommerce' ).'',
) );


$my_account_page->createOption( array(
'type' => 'heading',
'desc' => ''.esc_html__( 'Account Page Settings', 'divi-bodyshop-woocommerce' ).''
) );


$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Make the account page fullwidth?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_fullwidth',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );
$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Endpoints Padding not Built with Divi Builder', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_fullwidth_end_padding',
'type' => 'number',
'desc' => ''.esc_html__( 'Set the padding on the order details page and edit addresses', 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '0',
'max' => '600',
'step' => '1',
'unit' => 'px',
) );
$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Remove Default Woo Headings?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_remove_headings',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );
$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Remove Account Notices', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_remove_notices',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'This will remove the messages you get - for example if you update the address, it will remove the notification text.', 'divi-bodyshop-woocommerce' ).'',
) );

$my_account_page->createOption( array(
'name' => 'Navigation Position',
'id' => 'my_acount_layout',
'type' => 'enable',
'default' => false,
'enabled' => 'LEFT',
'disabled' => 'ON TOP',
'desc' => ''.esc_html__( 'Select where you want the navigation to be in relation to the other endpoints.', 'divi-bodyshop-woocommerce' ).'',
) );
$my_account_page->createOption( array(
'name' => ''.esc_html__( 'If left, Width of Left Pane', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_layout_width',
'type' => 'number',
'desc' => ''.esc_html__( 'Set the width of the left pane in %', 'divi-bodyshop-woocommerce' ).'',
'default' => '40',
'min' => '0',
'max' => '100',
'step' => '1',
'unit' => '%',
) );

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'If left pane, make the nav and content same height?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_left_right_same_height',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$my_account_page->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Other Endpoints', 'divi-bodyshop-woocommerce' ).'</p>',
) );

$my_account_page->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'If you have other plugins that create extra endpoints on the account area, you can use the settings below to make them look like your other endpoints (width and padding)', 'divi-bodyshop-woocommerce' ).'<br><br>'
.esc_html__( 'NOTE: it takes the settings above to match if the nav bar is on the left or ontop. So if you have it set to 20% above, the other endpoints will be 80% wide.', 'divi-bodyshop-woocommerce' ).'',
) );

$my_account_page->createOption( array(
'name' => ''.esc_html__( 'Not Full Width?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_acount_other_endpoints_fullwidth',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want the endpoint to not be fullwidth so it matches the Divi sections, enable this. This doesnt override the above setting. If you enable this it will make it 80% of the percentage above if that makes sense.', 'divi-bodyshop-woocommerce' ).'',
) );

$my_account_page->createOption( array(
'name' => 'Padding',
'id' => 'my_acount_other_endpoints_padding',
'type' => 'number',
'desc' => ''.esc_html__( 'Set the padding on top and bottom of the first section (could be header or a div) so that it matches Divi - default is 54px', 'divi-bodyshop-woocommerce' ).'',
'default' => '54',
'min' => '0',
'max' => '1000',
'step' => '1',
'unit' => 'px',
) );

$my_account_page->createOption( array(
'type' => 'save',
) );



///// MINI CART SETTINGS

$mini_cart->createOption( array(
'type' => 'save',
) );

// $mini_cart->createOption( array(
// 'name' => '',
// 'id' => 'mini-cart-set-page',
// 'type' => 'text',
// 'default' => 'mini cart',
// ) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Use Mini Cart?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'enable_minicart',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Note, this adds the class "woocommerce" to the body tag on each page so that the mini cart will work. If it is causing problem with your css then let us know and I will find a way around this.', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Mini Cart Style', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_style',
'type' => 'select',
'options' => array(
'drop-down-icon' => ''.esc_html__( 'Drop down from icon', 'divi-bodyshop-woocommerce' ).'',
'slide-in' => ''.esc_html__( 'Slide in', 'divi-bodyshop-woocommerce' ).'',
),
'desc' => ''.esc_html__( 'If you are using ajax add to cart, you might need to add a product to the cart after changing this so that the HTML fragments get refreshed. If not you might see the HTML structure of the other mini cart style.', 'divi-bodyshop-woocommerce' ).'',
'default' => 'drop-down-icon',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Mini Cart Activate', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_activate',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'CLICK', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'HOVER', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Choose how you want the mini cart to be activated - by clicking on the cart or hovering.', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Hover close delay time', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_hover_delay_time',
'type' => 'number',
'desc' => ''.esc_html__( 'If you are using hover, choose the delay time it takes from when you hover the icon to go away. This is useful when you have no padding as it would close the mini cart when exiting, but this delay will delay the close to allow time to hover down to the mini cart.', 'divi-bodyshop-woocommerce' ).'',
'default' => '800',
'min' => '0',
'max' => '10000',
'step' => '1',
'unit' => 'ms',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Remove text "item" on default cart icon?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_remove_item_text',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'This will remove the text "item/s" text that appears after the cart icon (if not using the custom cart icon below).', 'divi-bodyshop-woocommerce' ).'',
) );
/*
$mini_cart->createOption( array(
'name' => 'Show Mini Cart on Hover or Click?',
'id' => 'minicart_hover_click',
'type' => 'enable',
'default' => false,
'enabled' => 'CLICK',
'disabled' => 'HOVER',
) );
*/
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Mini Cart Width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_width',
'type' => 'number',
'desc' => ''.esc_html__( 'Set the width of how big you want your mini cart to be.', 'divi-bodyshop-woocommerce' ).'',
'default' => '360',
'min' => '0',
'max' => '600',
'step' => '1',
'unit' => 'px',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Horizontal Distance', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_horizontal_distance',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far left or right you want to the mini cart to be from its original position.(horizontal)', 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '-300',
'max' => '300',
'step' => '1',
'unit' => 'px',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Vertical Distance', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_vertical_distance',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far up or down you want to the mini cart to be from its original position.(vertically)', 'divi-bodyshop-woocommerce' ).'',
'default' => '45',
'min' => '-300',
'max' => '300',
'step' => '1',
'unit' => 'px',
) );


$menu_height = get_option( 'et_divi' );
if (isset($menu_height["menu_height"])) {
$menu_height_value = $menu_height["menu_height"];
$menu_height_value_display = $menu_height_value / 2;
}
else {
  $menu_height_value = "";
  $menu_height_value_display = "";
}


if ($menu_height_value_display == "") {
  $menu_height_value_display_final = "33";
}
else {
  $menu_height_value_display_final = $menu_height_value_display;
}

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Mini Cart Padding Bottom', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_padding_bottom',
'type' => 'number',
'desc' => ''.esc_html__( 'Set the padding at the bottom of your cart icon (so that when you move your mouse down it will activate the minicart). By default we work it out and add padding so it matches the height of your menu. If for some reason it is not working and adding more space a the bottom of your header, change the amount here.', 'divi-bodyshop-woocommerce' ).'',
'default' => $menu_height_value_display_final,
'min' => '0',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Remove link - text or icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_remove_option',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'TEXT', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'ICON', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Choose to have the default "x" icon or have the word "Remove" instead - this is what the user will click to remove the particular product from the cart.', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => 'Remove Text',
'id' => 'minicart_remove_option_text',
'type' => 'text',
'default' => 'Remove',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Replace basket button with "Continue Shopping"', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_place_basket_with_continue',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to remove the basket icon and replace it with "Continue Shopping" button, enable this.', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Remove basket button', 'divi-bodyshop-woocommerce' ).'',
'id' => 'minicart_remove_basket_button',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to remove the basket button so it is only checkout, enable this. It will also make the checkout button fullwidth.', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => 'Disable Mini Cart on Mobile',
'id' => 'atc_pupup_disable_mobile',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );


$mini_cart->createOption( array(
'type' => 'heading',
'desc' => ''.esc_html__( 'Ajax Mini Cart Settings', 'divi-bodyshop-woocommerce' ).'',
) );

$SiteURL = get_site_url();

$mini_cart->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'Do you want to improve the user experience when adding a product to your cart?', 'divi-bodyshop-woocommerce' ).'<br>
          '.esc_html__( 'ENABLE AJAX ADD TO CART', 'divi-bodyshop-woocommerce' ).'<br>
          '.esc_html__( 'Enable Ajax Add to Cart in our General Mods tab ', 'divi-bodyshop-woocommerce' ).'<a href="'.$SiteURL.'/wp-admin/admin.php?page=divi-bodycommerce-mods">'.esc_html__( 'here', 'divi-bodyshop-woocommerce' ).'</a><br>
          '.esc_html__( 'Once you have done that, then come back here and enable Ajax Mini Cart', 'divi-bodyshop-woocommerce' ).'
          ',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Ajax Mini Cart/Pop Up', 'divi-bodyshop-woocommerce' ).'',
'id' => 'ajax_minicart',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'This enables the mini cart to also auto update when you add a product to the cart. If you have this disabled it wont update until you reload the page.', 'divi-bodyshop-woocommerce' ).'',
) );


$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Auto show mini cart after update', 'divi-bodyshop-woocommerce' ).'',
'id' => 'auto_show_minicart',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => 'Enable this if you want to have the mini cart pop up after you add the product to the cart. You can set for how long below.',
) );

$mini_cart->createOption( array(
'name' => 'Auto show delay',
'id' => 'auto_show_minicart_delay',
'type' => 'number',
'desc' => 'Set how long it takes before the mini cart pops up.',
'default' => '2',
'min' => '0',
'max' => '10',
'step' => '0.1',
'unit' => 'seconds',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Close mini cart after auto show?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'close_auto_show',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => 'If you have auto show enabled and you want it to auto close, enable this. If you want it to not close and stay open, disable this.',
) );

$mini_cart->createOption( array(
'name' => 'Time to close',
'id' => 'auto_show_minicart_close_time',
'type' => 'number',
'desc' => 'How long do you want the cart to be shown for and then close so that it is not there forever..',
'default' => '5',
'min' => '0',
'max' => '10',
'step' => '0.1',
'unit' => 'seconds',
) );

$mini_cart->createOption( array(
'name' => 'Enable ajax add to cart Pop Up',
'id' => 'atc_pupup_enable',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => 'Enable this is you want a modal pop up of the carts content when the user adds to cart. You will need ajax add to cart and ajax mini cart/pop up enabled ',
) );

$mini_cart->createOption( array(
'name' => 'Successfully added to cart Text for Pop Up',
'id' => 'atc_pupup_successfully_added_to_cart',
'type' => 'text',
'default' => 'Successfully added to cart',
'desc' => 'Default is "Successfully added to cart", add your custom text if you want one.',
) );

$mini_cart->createOption( array(
'name' => 'Continue Shopping Button Text for Pop Up',
'id' => 'atc_pupup_continue_shopping_btn_text',
'type' => 'text',
'default' => 'Continue Shopping',
'desc' => 'Default is "Continue Shopping", add your custom button text if you want one.',
) );

$mini_cart->createOption( array(
'name' => 'Continue Shopping Button URL for Pop Up',
'id' => 'atc_pupup_continue_shopping_btn_url',
'type' => 'text',
'default' => '#',
'desc' => 'Set a custom URL of the continue shopping button.',
) );

// $mini_cart->createOption( array(
// 'type' => 'note',
// 'desc' => '<p class="title">Mini Cart Mobile Settings</p>'
// ) );
//
// $mini_cart->createOption( array(
// 'name' => ''.esc_html__( 'Select Mobile Mini Cart Style', 'divi-bodyshop-woocommerce' ).'',
// 'id' => 'mini_cart_mobile_style',
// 'type' => 'select',
// 'options' => array(
// 'default' => ''.esc_html__( 'Default', 'divi-bodyshop-woocommerce' ).'',
// 'slidein' => ''.esc_html__( 'Slide In', 'divi-bodyshop-woocommerce' ).'',
// ),
// 'default' => 'yes',
// ) );

$mini_cart->createOption( array(
'name' => 'Style Your Mini Cart / Add to cart pop up',
'type' => 'heading',
) );

$mini_cart->createOption( array(
'type' => 'note',
'desc' => '<p class="title">Background</p>'
) );

$mini_cart->createOption( array(
'name' => 'Mini Cart Background Colour',
'id' => 'mini_cart_background',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => 'Mini Cart Generic Text Colour',
'id' => 'mini_cart_generic_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => 'Remove Shadow',
'id' => 'mini_cart_remove_shadow',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => 'Mini Cart/Pop Up Overlay Colour',
'id' => 'mini_cart_popup_overlay_color',
'type' => 'color',
'default' => 'rgba(0, 0, 0, 0.50)',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Pop Up Close Button Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_popup_close_size',
'type' => 'number',
'default' => '56',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

$mini_cart->createOption( array(
'name' => 'Pop Up Close Button Colour',
'id' => 'mini_cart_popup_close_color',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'type' => 'note',
'desc' => '<p class="title">Subtotal Text</p>'
) );

$mini_cart->createOption( array(
'name' => 'Subtotal Text Size',
'id' => 'mini_cart_subtotal_text_size',
'type' => 'number',
'default' => '20',
'max' => '100',
'min' => '1',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => 'Subtotal Text Colour',
'id' => 'mini_cart_subtotal_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'type' => 'note',
'desc' => '<p class="title">Product</p>'
) );
$mini_cart->createOption( array(
'name' => 'Product Image Size',
'id' => 'mini_cart_product_image_size',
'type' => 'number',
'default' => '32',
'max' => '500',
'min' => '1',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => 'Product Title Text Size',
'id' => 'mini_cart_product_title_text_size',
'type' => 'number',
'default' => '14',
'max' => '100',
'min' => '1',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => 'Product Title Text Colour',
'id' => 'mini_cart_product_title_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => 'Product Quantity & Price Text Size',
'id' => 'mini_cart_product_quantity_price_text_size',
'type' => 'number',
'default' => '14',
'max' => '100',
'min' => '1',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => 'Product Quantity & Price Text Colour',
'id' => 'mini_cart_product_quantity_price_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => 'Remove Text/Icon Size',
'id' => 'mini_cart_remove_text_size',
'type' => 'number',
'default' => '14',
'max' => '100',
'min' => '1',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => 'Remove Text/Icon Colour',
'id' => 'mini_cart_remove_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => 'Remove Text/Icon Background Colour',
'id' => 'mini_cart_remove_icon_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => 'Remove Text/Icon Colour On Hover',
'id' => 'mini_cart_remove_icon_color_hover',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => 'Remove Text/Icon Background Colour On Hover',
'id' => 'mini_cart_remove_icon_bg_color_hover',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );


$mini_cart->createOption( array(
'type' => 'note',
'desc' => '<p class="title">Buttons</p><br><hr>'
) );
$mini_cart->createOption( array(
'name' => 'View Basket Button Text',
'id' => 'mini_cart_view_btn_text',
'type' => 'text',
'default' => 'View Basket',
'desc' => 'Default is "View Basket", add your custom button text if you want one.',
) );
$mini_cart->createOption( array(
'name' => 'Checkout Button Text',
'id' => 'mini_cart_checkout_btn_text',
'type' => 'text',
'default' => 'Checkout',
'desc' => 'Default is "Checkout", add your custom button text if you want one.',
) );
$mini_cart->createOption( array(
'name' => 'Mini Cart Button Display',
'id' => 'mini_cart_button_display_type',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'Stacked', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'Next to each other', 'divi-bodyshop-woocommerce' ).'',
) );
$mini_cart->createOption( array(
'name' => 'Use Custom Styles for Button',
'id' => 'mini_cart_use_custom_style_button',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Text Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_text_size',
'type' => 'number',
'default' => '20',
'max' => '100',
'min' => '1',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Border Width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_border_width',
'type' => 'number',
'default' => '2',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Border Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_border_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Border Radius', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_border_radius',
'type' => 'number',
'default' => '3',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Letter Spacing', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_letter_spacing',
'type' => 'number',
'default' => '0',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Add Button icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_add_button_icon',
'type' => 'select',
'options' => array(
'yes' => ''.esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ).'',
'no' => ''.esc_html__( 'No', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'yes',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Divi Icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_icon',
'type' => 'text',
'desc' => 'Enter in the number for the divi icon - You can see a full list <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">HERE</a>. Just scroll down till you see the icons and some letter below. <br>Copy the numbers and letters that appear after "x". <br>So "&amp;#x21;" - copy just the "21". <br>"&amp;#xe016;" - copy the "e016"',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Icon Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_icon_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Icon Placement', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_icon_placement',
'type' => 'select',
'options' => array(
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'right',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Only Show icon On Hover For Button', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_field_button_icon_only_show_hover',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );
$mini_cart->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'Button Hover', 'divi-bodyshop-woocommerce' ).'<br><hr>'
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Hover Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_button_hover_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Hover Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_button_hover_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Hover Border Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_button_hover_border_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Hover Border Radius', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_button_hover_border_radius',
'type' => 'number',
'default' => '3',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Button Hover Letter Spacing', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_button_hover_letter_spacing',
'type' => 'number',
'default' => '0',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );


$mini_cart->createOption( array(
'name' => 'Drop Down Mini Cart / Pop Up Settings',
'type' => 'heading',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Total or Sub Total', 'divi-bodyshop-woocommerce' ).'',
'id' => 'drop_down_mini_cart_total_subtotal',
'type' => 'select',
'options' => array(
'total' => ''.esc_html__( 'Show Total Price', 'divi-bodyshop-woocommerce' ).'',
'sub-total' => ''.esc_html__( 'Show Sub Total Price', 'divi-bodyshop-woocommerce' ).'',
),
'desc' => ''.esc_html__( 'On the drop down mini cart it will show the sub total at the top by default. If you want to show the total, change it here.', 'divi-bodyshop-woocommerce' ).'',
'default' => 'sub-total',
) );

$mini_cart->createOption( array(
'name' => 'Slide in Mini Cart Settings',
'type' => 'heading',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Overlay Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_overlay_color',
'type' => 'color',
'default' => 'rgba(0,0,0,.7)',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Close Icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_close_icon',
'type' => 'text',
'default' => '4d',
'desc' => ''.esc_html__( 'Enter in the number for the divi icon - You can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">'.esc_html__( 'HERE.', 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( 'Just scroll down till you see the icons and some letter below. ', 'divi-bodyshop-woocommerce' ). '<br>' .esc_html__( 'Copy the numbers and letters that appear after "x". ', 'divi-bodyshop-woocommerce' ). '<br>'.esc_html__( 'So', 'divi-bodyshop-woocommerce' ).' "&amp;#x21;" - '.esc_html__( 'copy just the "21".', 'divi-bodyshop-woocommerce' ).' <br>"&amp;#xe016;" - '.esc_html__( 'copy the "e016"', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Close Icon Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_close_icon_font_size',
'type' => 'number',
'default' => '24',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Close Icon Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_close_icon_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Close Icon Position Right', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_close_icon_right',
'type' => 'number',
'default' => '30',
'max' => '400',
'min' => '0',
'unit' => 'px'
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Close Icon Position Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_close_icon_top',
'type' => 'number',
'default' => '30',
'max' => '400',
'min' => '0',
'unit' => 'px'
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Header Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_header_text',
'type' => 'text',
'default' => 'YOUR CART',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Header Text Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_header_text_size',
'type' => 'number',
'default' => '18',
'max' => '200',
'min' => '1',
'unit' => 'px'
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Header Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_header_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Divider Line Height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_divider_height',
'type' => 'number',
'default' => '2',
'max' => '20',
'min' => '0',
'unit' => 'px'
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Divider Line Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_divider_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Bottom Costs Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_bottom_font_size',
'type' => 'number',
'default' => '18',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Bottom Text Line Height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_bottom_line_height',
'type' => 'number',
'default' => '1',
'max' => '5',
'step' => '0.1',
'min' => '0',
'unit' => 'em'
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Bottom Costs Font Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_bottom_font_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Bottom Costs Remove Font Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_bottom_remove_font_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Total Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_total_font_size',
'type' => 'number',
'default' => '18',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Total Font Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_total_font_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Subtotal Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_subtotal_text',
'type' => 'text',
'default' => 'Subtotal',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Show Subtotal', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_show_subtotal',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Discount Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_discount_text',
'type' => 'text',
'default' => 'Discount',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Show Discount', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_show_discount',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Shipping Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_shipping_text',
'type' => 'text',
'default' => 'Shipping',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Show Shipping', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_show_shipping',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Tax Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_tax_text',
'type' => 'text',
'default' => 'Tax',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Show Tax', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_show_tax',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Total Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_total_text',
'type' => 'text',
'default' => 'Total',
) );

$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Show Total', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_show_total',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );


$mini_cart->createOption( array(
'name' => ''.esc_html__( 'Quantity Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'mini_cart_slide_quantity_text',
'type' => 'text',
'default' => 'Quantity',
) );



$mini_cart->createOption( array(
'type' => 'save',
) );



$cart_icon->createOption( array(
'type' => 'save',
) );

// CUSTOM CART Icon

$cart_icon->createOption( array(
'type' => 'heading',
'name' => ''.esc_html__( 'Custom Cart Icon', 'divi-bodyshop-woocommerce' ).'',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Use Custom Cart Icon?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'enable_cart_custom_icon',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => 'NO'
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Select custom icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'enable_cart_custom_icon_select',
'type' => 'radio-image',
'options' => array(
'shopping-bag-1' => DE_DB_WOO_URL . '/images/cart-icon/shopping-bag-1.svg',
'shopping-bag-2' => DE_DB_WOO_URL . '/images/cart-icon/shopping-bag-2.svg',
'shopping-bag-3' => DE_DB_WOO_URL . '/images/cart-icon/shopping-bag-3.svg',
'shopping-cart-1' => DE_DB_WOO_URL . '/images/cart-icon/shopping-cart-1.svg',
'shopping-cart-2' => DE_DB_WOO_URL . '/images/cart-icon/shopping-cart-2.svg',
'shopping-cart-3' => DE_DB_WOO_URL . '/images/cart-icon/shopping-cart-3.svg',
'shopping-basket-1' => DE_DB_WOO_URL . '/images/cart-icon/shopping-basket-1.svg',
),
'default' => 'shopping-bag-1',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Upload custom cart icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'custom_cart_icon_upload',
'type' => 'upload',
'size' => 'full',
'desc' => ''.esc_html__( 'If you want your own icon, upload it here.', 'divi-bodyshop-woocommerce' ).'',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Icon Width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_width',
'type' => 'number',
'default' => '25',
'max' => '400',
'min' => '0',
'unit' => 'px'
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Icon Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Icon Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Icon Background Padding Left', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_background_padding_left',
'type' => 'number',
'default' => '10',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Icon Background Padding Right', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_background_padding_right',
'type' => 'number',
'default' => '10',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Icon Background Padding Top/Bottom', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_background_padding_top',
'type' => 'number',
'default' => '5',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Enable Numbers', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_enable_numbers',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable or disable the number count of how many products are in the cart.', 'divi-bodyshop-woocommerce' ).'',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Disable number when cart is empty', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_disable_empty_number',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want to hide the number "0" when the cart is empty.', 'divi-bodyshop-woocommerce' ).'',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Text After Numbers (singular).', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_enable_text_after',
'type' => 'text',
'default' => 'Items',
'desc' => ''.esc_html__( 'This adds text after the numbers in the cart - the default is "items" by Divi. To remove this text, leave this box blank. This is the option for when there is only one product added.', 'divi-bodyshop-woocommerce' ).'',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Text After Numbers (plural).', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_enable_text_after_plural',
'type' => 'text',
'default' => 'Items',
'desc' => ''.esc_html__( 'This adds text after the numbers in the cart - the default is "items" by Divi. To remove this text, leave this box blank. This is the option for when there is more than one product added.', 'divi-bodyshop-woocommerce' ).'',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Icon Position From The Right', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_icon_postion_left',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far right you want to the cart icon to be.(horizontal).', 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '-100',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Icon Position From The Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_icon_postion_top',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far from the top you want to the cart icon to be.(vertically)', 'divi-bodyshop-woocommerce' ).'',
'default' => '-10',
'min' => '-100',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$cart_icon->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Cart Icon Number Count Appearance', 'divi-bodyshop-woocommerce' ).'</p>',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Select Style', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_style',
'type' => 'radio-image',
'options' => array(
'default' => DE_DB_WOO_URL . '/images/cart-icon/default-number.svg',
'circle' => DE_DB_WOO_URL . '/images/cart-icon/circle-number.svg',
),
'default' => 'default',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Number Count Position From The Right', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_postion_left',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far right you want to the cart icon number count to be.(horizontal)', 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '-100',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Number Count Position From The Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_postion_top',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how far from the top you want to the cart icon number count to be.(vertically)', 'divi-bodyshop-woocommerce' ).'',
'default' => '0',
'min' => '-100',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Number Count Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_background_color',
'type' => 'color',
'default' => '#dd3333',
'alpha'  => 'true',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Number Count Background Colour HOVER', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_background_color_hover',
'type' => 'color',
'default' => '#000000',
'alpha'  => 'true',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Number Count Background Border Radius', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_background_border_radius',
'type' => 'number',
'default' => '100',
'min' => '0',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Number Count Background Width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_background_width',
'type' => 'number',
'default' => '25',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Number Count Background Height', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_background_height',
'type' => 'number',
'default' => '25',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Number Count Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_text_color',
'type' => 'color',
'default' => '#ffffff',
'alpha'  => 'true',
) );

$cart_icon->createOption( array(
'name' => ''.esc_html__( 'Number Count Text Font Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'cart_custom_icon_number_text_font_size',
'type' => 'number',
'default' => '14',
'min' => '1',
'max' => '100',
'step' => '1',
'unit' => 'px',
) );

$cart_icon->createOption( array(
'type' => 'save',
) );

// GLOBAL SETTINGS
$other_settings_global->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Global Settings', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Ajax Add to Cart', 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Enable Ajax Add to Cart?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_ajax_add_to_cart',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'This option will enable ajax add to cart. When a customer clicks add to cart, it will prevent the page to reload. You can use this in conjunction with our Mini Cart.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Disable Ajax to Cart for specific product types', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_ajax_add_to_cart_disable_products',
'type' => 'text',
'desc' => ''.esc_html__( 'If you want to disable ajax add to cart for specific products, add a custom css class here which will be a container of the button. For example you can add "grouped_form" to disable it for the grouped products', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Added to Cart Notify Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_ajax_add_to_cart_text_notify',
'type' => 'text',
'desc' => ''.esc_html__( 'If you want to have the text on the button to change once the product has been added to cart, add it here, then specify how long you want it to stay before it changes back to the original text below.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Add to Cart Notify Text Time', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_ajax_add_to_cart_text_notify_time',
'type' => 'number',
'desc' => ''.esc_html__( 'Set how long you want the button text to show for', 'divi-bodyshop-woocommerce' ).'',
'default' => '4000',
'min' => '0',
'max' => '10000',
'step' => '500',
'unit' => 'ms',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notify Button Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'ajax_add_to_cart_text_notify_btn_bg_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notify Button Background Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'ajax_add_to_cart_text_notify_btn_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Remove View Cart Link?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'ajax_add_to_cart_remove_basket_link',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you enable ajax add to cart and want to remove the text that appears after the button ("View Basket") - enable this.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Disable Icon Spinning', 'divi-bodyshop-woocommerce' ).'',
'id' => 'ajax_add_to_cart_disable_spinning',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you have ajax add to cart and click on "add to cart" - default you get a icon spinning. If you want to disable this so it does not spin, enable this.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Other General', 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Default Product Image', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_default_product_image',
'type' => 'upload',
'size' => 'full',
'desc' => ''.esc_html__( 'Change the placeholder image that is shown if no image is added to the product - it could be your logo.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Enable Better Variation Display?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_better_variation',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you enable this option, it will display the variations in the cart/mini-cart and checkout better. Instead of having them all on one line, it will put each on a seperate line with the label for each variation too.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Enable WooCommerce Button Fix?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_button_fix',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'This option will add some css to the head of your site that will make sure that all WooCommerce buttons use the correct text color as in the customiser.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Breadcrumb separator', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_breadcrumb_separator',
'type' => 'text',
'desc' => ''.esc_html__( 'Add a symbol or whatever you want to separate the breadcrumb links, for example ">". We have also added a wrap class called: "bc-breadcrumb-wrap" and all the links in a nav called: "bc-woocommerce-breadcrumb" - you can use this for further development.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Remove Breadcrumbs', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_breadcrumb_remove',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Breadcrumbs home link to shop', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_breadcrumb_home_shop',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' =>  ''.esc_html__( 'If you want to have the home link to your shop page and not your homepage, enable this', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Change breadcrumbs home text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_breadcrumb_home_shop_text',
'type' => 'text',
'desc' => ''.esc_html__( 'If you want to change the text of the home link on the breadcrumbs, write it here.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Remove title page title from breadcrumbs?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_breadcrumb_remove_title',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' =>  ''.esc_html__( 'If you want to remove the title on the breadcrumbs for example the product name, enable this', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Remove Sale Badge', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_remove_sale_badge',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'This will remove the sale badge on the archive and single product pages', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Free Product Price Name', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_free_price_name',
'type' => 'text',
'desc' => ''.esc_html__( 'If you would like to change the price text from "0.00" to something else like "FREE!" - enter in the text here. If not, leave it blank.', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'My Account Menu Text Change', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_account_menu_text_change',
'type' => 'text',
'desc' => ''.esc_html__( 'If you want to change the "My Account" menu name for when the user is not logged in to something like "Login" or similar, add the text here. You will need to provide the CSS class of the menu item - add a css class below', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'My Account Menu Text Change CSS class', 'divi-bodyshop-woocommerce' ).'',
'id' => 'my_account_menu_text_change_css',
'type' => 'text',
'desc' => ''.esc_html__( 'Go to your menu and add a custom CSS class - maybe something like "myaccount". To add this go to the top of the screen and click on screen options, then check the box named "css classes". Now add a custom css class to your menu item. Then add this custom css class here so we know which menu item to change.', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'WooCommerce Notice Boxes', 'divi-bodyshop-woocommerce' ).'',
'type' => 'heading',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Product was successfully added to cart message', 'divi-bodyshop-woocommerce' ).'',
'id' => 'notice_product_added_cart',
'type' => 'text',
'desc' => ''.esc_html__( 'If you would like to change the text for the notice that appears when you add a product to the cart, specify it here', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Product was successfully added to cart message BUTTON', 'divi-bodyshop-woocommerce' ).'',
'id' => 'notice_product_added_cart_btn',
'type' => 'text',
'desc' => ''.esc_html__( 'If you would like to change the text for the button that appears when you add a product to the cart, specify it here', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Heading Text Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'notice_heading_text_size',
'type' => 'number',
'max' => '100',
'min' => '1',
'default' => '16',
'unit' => 'px'
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Heading Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Heading Link Text Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'gloabl_notice_heading_link_text_size',
'type' => 'number',
'max' => '100',
'min' => '1',
'default' => '16',
'unit' => 'px',
'desc' => ''.esc_html__( 'For example click to enter coupon at checkout', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Heading Link Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_heading_link_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
'desc' => ''.esc_html__( 'For example click to enter coupon at checkout', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Background Padding Top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_background_pad_top',
'type' => 'number',
'max' => '100',
'default' => '15',
'min' => '1',
'unit' => 'px'
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Background Padding Bottom', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_background_pad_bot',
'type' => 'number',
'max' => '100',
'default' => '15',
'min' => '1',
'unit' => 'px'
) );


$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Background Padding Right', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_background_pad_right',
'type' => 'number',
'max' => '100',
'default' => '25',
'min' => '1',
'unit' => 'px'
) );


$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Background Padding Left', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_background_pad_left',
'type' => 'number',
'max' => '100',
'default' => '25',
'min' => '1',
'unit' => 'px'
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Use Custom Styles for Notice Button', 'divi-bodyshop-woocommerce' ).'',
'id' => 'notice_button_use_custom_style_button',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Text Size', 'divi-bodyshop-woocommerce' ).'',
'id' => 'notice_button_text_size',
'type' => 'number',
'default' => '20',
'max' => '100',
'min' => '1',
'unit' => 'px'
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Border Width', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_border_width',
'type' => 'number',
'default' => '2',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Border Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_border_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Button Border Radius', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_border_radius',
'type' => 'number',
'default' => '3',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Letter Spacing', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_letter_spacing',
'type' => 'number',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Add Button icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_add_button_icon',
'type' => 'select',
'options' => array(
'yes' => ''.esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ).'',
'no' => ''.esc_html__( 'No', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'yes',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Divi Icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_icon',
'type' => 'text',
'desc' => ''.esc_html__( 'Enter in the number for the divi icon - You can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">'.esc_html__( 'HERE.', 'divi-bodyshop-woocommerce' ).'</a> '.esc_html__( 'Just scroll down till you see the icons and some letter below. ', 'divi-bodyshop-woocommerce' ). '<br>' .esc_html__( 'Copy the numbers and letters that appear after "x". ', 'divi-bodyshop-woocommerce' ). '<br>'.esc_html__( 'So', 'divi-bodyshop-woocommerce' ).' "&amp;#x21;" - '.esc_html__( 'copy just the "21".', 'divi-bodyshop-woocommerce' ).' <br>"&amp;#xe016;" - '.esc_html__( 'copy the "e016"', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Icon Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_icon_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Icon Placement', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_icon_placement',
'type' => 'select',
'options' => array(
'right' => ''.esc_html__( 'Right', 'divi-bodyshop-woocommerce' ).'',
'left' => ''.esc_html__( 'Left', 'divi-bodyshop-woocommerce' ).'',
),
'default' => 'right',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Only Show icon On Hover For Notice Button', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_icon_only_show_hover',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_global->createOption( array(
'type' => 'note',
'desc' => ''.esc_html__( 'Button Hover', 'divi-bodyshop-woocommerce' ).'<br><hr>'
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Hover Text Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_hover_text_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Hover Background Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_hover_background_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Hover Border Colour', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_hover_border_color',
'type' => 'color',
'default' => '',
'alpha'  => 'true',
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Hover Border Radius', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_hover_border_radius',
'type' => 'number',
'default' => '3',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );
$other_settings_global->createOption( array(
'name' => ''.esc_html__( 'Notice Button Hover Letter Spacing', 'divi-bodyshop-woocommerce' ).'',
'id' => 'global_notice_button_hover_letter_spacing',
'type' => 'number',
'default' => '0',
'max' => '100',
'min' => '0',
'unit' => 'px'
) );


$other_settings_global->createOption( array(
'type' => 'save',
) );

// ARCIVE SETTINGS PAGE
$other_settings_archive->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Archive Page', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Enable Add to Basket', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_add_to_basket_archive',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want to have the add to basket button on your category pages when possible', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Enable Add to Basket Quantity', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_add_to_basket_quantity_archive',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want to have a quantity field next to the add to cart button on your archive pages', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Move Pagination to top', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_pagination_top',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want the pagination at the top of your products on the archive page - click yes', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Description Under Image', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_archive_desc_under_image',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this to show the product description underneath the image', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Add View Product Button', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_button_below_product',
'type' => 'text',
'desc' => ''.esc_html__( 'If you want to add a button below each of the product that when clicked goes to the product page, add the name of the button text here. For example, it could be "Shop Now".', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_archive->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Product Sorting - Change the labels for the sorting dropdown', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Default Sorting', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_sorting_label_default',
'type' => 'text',
'placeholder' => 'Default sorting',
'default' => 'Default sorting',
) );

$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Sort by Popularity', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_sorting_label_popularity',
'type' => 'text',
'placeholder' => 'Sort by popularity',
'default' => 'Sort by popularity',
) );

$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Sort by Average Rating', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_sorting_label_ave_rating',
'type' => 'text',
'placeholder' => 'Sort by average rating',
'default' => 'Sort by average rating',
) );
$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Sort by Newness', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_sorting_label_newness',
'type' => 'text',
'placeholder' => 'Sort by newness',
'default' => 'Sort by newness',
) );
$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Sort by Price: Low to High', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_sorting_label_low_high',
'type' => 'text',
'placeholder' => 'Sort by price: low to high',
'default' => 'Sort by price: low to high',
) );
$other_settings_archive->createOption( array(
'name' => ''.esc_html__( 'Sort by Price: High to Low', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_sorting_label_high_low',
'type' => 'text',
'placeholder' => 'Sort by price: high to low',
'default' => 'Sort by price: high to low',
) );


$other_settings_archive->createOption( array(
'type' => 'save',
) );


// PRODUCT PAGE SETTINGS
$other_settings_single->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Product Page', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$other_settings_single->createOption( array(
'name' => ''.esc_html__( 'Single Product Short Description Title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_short_desc_title',
'type' => 'text',
'desc' => ''.esc_html__( 'If you want to add a title just above the short description on a product page - add the wording you want here. To remove it, leave this box blank.', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_single->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Add To Cart Settings', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$other_settings_single->createOption( array(
'name' => ''.esc_html__( 'Add to Cart Notification Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_add_to_cart_message_text',
'type' => 'text',
'desc' => ''.esc_html__( 'Change the text that appears when you add a product to your cart. Leave it blank to leave it as the default.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_single->createOption( array(
'name' => ''.esc_html__( 'Add to Cart Notification Button Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_add_to_cart_message_button_text',
'type' => 'text',
'desc' => ''.esc_html__( 'Change the text of the button (default is "View Basket"). Leave it blank to leave it as the default.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_single->createOption( array(
'name' => ''.esc_html__( 'Remove Add to Cart Notification', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_remove_add_to_cart_message',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'This will remove the "add to cart" message that appears when you add a product to the cart on a single product page.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_single->createOption( array(
'name' => ''.esc_html__( 'Product Tabs Order', 'divi-bodyshop-woocommerce' ).'',
'id' => 'product_tabs_reorder',
'type' => 'sortable',
'visible_button' => false,
'desc' => ''.esc_html__( 'Change the order of the tabs on a global scale.', 'divi-bodyshop-woocommerce' ).'',
'options' => array(
'description' => ''.esc_html__( 'Description', 'divi-bodyshop-woocommerce' ).'',
'additional_information' => ''.esc_html__( 'Additional Information', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_1' => ''.esc_html__( 'Custom Tab 1 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_2' => ''.esc_html__( 'Custom Tab 2 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_3' => ''.esc_html__( 'Custom Tab 3 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_4' => ''.esc_html__( 'Custom Tab 4 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_5' => ''.esc_html__( 'Custom Tab 5 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_6' => ''.esc_html__( 'Custom Tab 6 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_7' => ''.esc_html__( 'Custom Tab 7 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_8' => ''.esc_html__( 'Custom Tab 8 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_9' => ''.esc_html__( 'Custom Tab 9 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_10' => ''.esc_html__( 'Custom Tab 10 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_11' => ''.esc_html__( 'Custom Tab 11 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_12' => ''.esc_html__( 'Custom Tab 12 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_13' => ''.esc_html__( 'Custom Tab 13 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_14' => ''.esc_html__( 'Custom Tab 14 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_15' => ''.esc_html__( 'Custom Tab 15 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_16' => ''.esc_html__( 'Custom Tab 16 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_17' => ''.esc_html__( 'Custom Tab 17 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_18' => ''.esc_html__( 'Custom Tab 18 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_19' => ''.esc_html__( 'Custom Tab 19 (if using)', 'divi-bodyshop-woocommerce' ).'',
'bc_custom_tab_20' => ''.esc_html__( 'Custom Tab 20 (if using)', 'divi-bodyshop-woocommerce' ).'',
'reviews' => ''.esc_html__( 'Reviews', 'divi-bodyshop-woocommerce' ).'',
)
) );




$other_settings_single->createOption( array(
'type' => 'save',
) );

// CUSTOMER/USER SETTINGS
$other_settings_user->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'User/Customer Settings', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$other_settings_user->createOption( array(
'name' => ''.esc_html__( 'Remove password strength meter', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_user_password',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Remove the password strength meter when a user tried to create an account on your site. It can be annoying and lead to loss of sales.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_user->createOption( array(
'name' => ''.esc_html__( 'Enable password confirmation on register form', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_user_password_confirm',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'If you want to add a "confirm password field to the register page, enable this. You need to go to WooCommerce > Settings > Accounts & Privacy > When creating an account, automatically generate an account password. Check this.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_user->createOption( array(
'name' => ''.esc_html__( 'Comfirm Password Text', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_user_password_confirm_text',
'type' => 'text',
'default' => "Confirm Password",
'desc' => ''.esc_html__( 'Add the text you want to be shown for "Confirm Password".', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_user->createOption( array(
'name' => ''.esc_html__( 'Buy One Item Only', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_buy_one_item_only',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want the customer to purchase one item ONLY.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_user->createOption( array(
'name' => ''.esc_html__( 'Show Price for Logged In Users only', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_price_logged_in',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want the price for your product to only be displayed is a user is logged in.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_user->createOption( array(
'name' => ''.esc_html__( 'Show add to cart button for Logged In Users only', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_atc_button_logged_in',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want the add to cart button for your product to only be displayed is a user is logged in.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_user->createOption( array(
'name' => 'Custom message for logged out users',
'id' => 'other_settings_price_logged_in_custom_message',
'type' => 'editor',
'desc' => ''.esc_html__( 'If you are using the setting above (show price for logged in users only), you can add some custom HTML here that will be shown to the visitors that are not logged in.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_user->createOption( array(
'name' => ''.esc_html__( 'Disable Toolbar for Customers', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_disable_toolbar_customers',
'type' => 'enable',
'default' => true,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you dont want the customers to see the WordPress toolbar.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_user->createOption( array(
'name' => ''.esc_html__( 'Custom Registration Redirect', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_custom_login_redirect',
'type' => 'text',
'default' => "",
'desc' => ''.esc_html__( 'If you want the user, when registering, to be redirected to another URL and not the account area - enter the slug here. For example you could add "contact" for the contact page. If you want the home page, add "/".', 'divi-bodyshop-woocommerce' ).'',
) );

$other_settings_user->createOption( array(
'type' => 'save',
) );



// CHECKOUT SETTINGS
$other_settings_checkout->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Checkout Settings', 'divi-bodyshop-woocommerce' ).'</p>'
) );


$other_settings_checkout->createOption( array(
'name' => ''.esc_html__( 'Default Country at checkout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_checkout_default_country',
'type' => 'select',
'desc' => ''.esc_html__( 'Select the default country that is selected at checkout', 'divi-bodyshop-woocommerce' ).'',
'options' => array(

  'select' => ''.esc_html__( 'Select', 'divi-bodyshop-woocommerce' ).'',
  'AF' => 'Afghanistan',	'AX' => '&#197;land Islands',	'AL' => 'Albania',	'DZ' => 'Algeria',	'AS' => 'American Samoa',	'AD' => 'Andorra',	'AO' => 'Angola',	'AI' => 'Anguilla',	'AQ' => 'Antarctica',	'AG' => 'Antigua and Barbuda',	'AR' => 'Argentina',	'AM' => 'Armenia',	'AW' => 'Aruba',	'AU' => 'Australia',	'AT' => 'Austria',	'AZ' => 'Azerbaijan',	'BS' => 'Bahamas',	'BH' => 'Bahrain',	'BD' => 'Bangladesh',	'BB' => 'Barbados',	'BY' => 'Belarus',	'BE' => 'Belgium',	'PW' => 'Belau',	'BZ' => 'Belize',	'BJ' => 'Benin',	'BM' => 'Bermuda',	'BT' => 'Bhutan',	'BO' => 'Bolivia',	'BQ' => 'Bonaire, Saint Eustatius and Saba',	'BA' => 'Bosnia and Herzegovina',	'BW' => 'Botswana',	'BV' => 'Bouvet Island',	'BR' => 'Brazil',	'IO' => 'British Indian Ocean Territory',	'VG' => 'British Virgin Islands',	'BN' => 'Brunei',	'BG' => 'Bulgaria',	'BF' => 'Burkina Faso',	'BI' => 'Burundi',	'KH' => 'Cambodia',	'CM' => 'Cameroon',	'CA' => 'Canada',	'CV' => 'Cape Verde',	'KY' => 'Cayman Islands',	'CF' => 'Central African Republic',	'TD' => 'Chad',	'CL' => 'Chile',	'CN' => 'China',
	'CX' => 'Christmas Island',	'CC' => 'Cocos (Keeling) Islands',	'CO' => 'Colombia',	'KM' => 'Comoros',	'CG' => 'Congo (Brazzaville)',	'CD' => 'Congo (Kinshasa)',	'CK' => 'Cook Islands',	'CR' => 'Costa Rica',	'HR' => 'Croatia',	'CU' => 'Cuba',	'CW' => 'Cura&ccedil;ao',	'CY' => 'Cyprus',	'CZ' => 'Czech Republic',	'DK' => 'Denmark',	'DJ' => 'Djibouti',	'DM' => 'Dominica',	'DO' => 'Dominican Republic',	'EC' => 'Ecuador',	'EG' => 'Egypt',	'SV' => 'El Salvador',	'GQ' => 'Equatorial Guinea',	'ER' => 'Eritrea',	'EE' => 'Estonia',	'ET' => 'Ethiopia',	'FK' => 'Falkland Islands',	'FO' => 'Faroe Islands',	'FJ' => 'Fiji',	'FI' => 'Finland',	'FR' => 'France',	'GF' => 'French Guiana',	'PF' => 'French Polynesia',	'TF' => 'French Southern Territories',	'GA' => 'Gabon',	'GM' => 'Gambia',	'GE' => 'Georgia',	'DE' => 'Germany',	'GH' => 'Ghana',	'GI' => 'Gibraltar',	'GR' => 'Greece',	'GL' => 'Greenland',	'GD' => 'Grenada',	'GP' => 'Guadeloupe',	'GU' => 'Guam',	'GT' => 'Guatemala',	'GG' => 'Guernsey',	'GN' => 'Guinea',	'GW' => 'Guinea-Bissau',	'GY' => 'Guyana',	'HT' => 'Haiti',	'HM' => 'Heard Island and McDonald Islands',	'HN' => 'Honduras',	'HK' => 'Hong Kong',	'HU' => 'Hungary',	'IS' => 'Iceland',	'IN' => 'India',	'ID' => 'Indonesia',	'IR' => 'Iran',	'IQ' => 'Iraq',	'IE' => 'Ireland',	'IM' => 'Isle of Man',	'IL' => 'Israel',	'IT' => 'Italy',	'CI' => 'Ivory Coast',	'JM' => 'Jamaica',	'JP' => 'Japan',	'JE' => 'Jersey',	'JO' => 'Jordan',	'KZ' => 'Kazakhstan',	'KE' => 'Kenya',	'KI' => 'Kiribati',	'KW' => 'Kuwait',	'KG' => 'Kyrgyzstan',	'LA' => 'Laos',	'LV' => 'Latvia',	'LB' => 'Lebanon',	'LS' => 'Lesotho',	'LR' => 'Liberia',	'LY' => 'Libya',	'LI' => 'Liechtenstein',	'LT' => 'Lithuania',	'LU' => 'Luxembourg',	'MO' => 'Macao S.A.R., China',	'MK' => 'Macedonia',	'MG' => 'Madagascar',	'MW' => 'Malawi',	'MY' => 'Malaysia',	'MV' => 'Maldives',	'ML' => 'Mali',	'MT' => 'Malta',	'MH' => 'Marshall Islands',	'MQ' => 'Martinique',	'MR' => 'Mauritania',	'MU' => 'Mauritius',	'YT' => 'Mayotte',	'MX' => 'Mexico',	'FM' => 'Micronesia',	'MD' => 'Moldova',	'MC' => 'Monaco',	'MN' => 'Mongolia',	'ME' => 'Montenegro',	'MS' => 'Montserrat',	'MA' => 'Morocco',	'MZ' => 'Mozambique',	'MM' => 'Myanmar',	'NA' => 'Namibia',	'NR' => 'Nauru',	'NP' => 'Nepal',	'NL' => 'Netherlands',	'NC' => 'New Caledonia',	'NZ' => 'New Zealand',	'NI' => 'Nicaragua',	'NE' => 'Niger',	'NG' => 'Nigeria',	'NU' => 'Niue',	'NF' => 'Norfolk Island',	'MP' => 'Northern Mariana Islands',	'KP' => 'North Korea',	'NO' => 'Norway',	'OM' => 'Oman',	'PK' => 'Pakistan',	'PS' => 'Palestinian Territory',	'PA' => 'Panama',	'PG' => 'Papua New Guinea',	'PY' => 'Paraguay',	'PE' => 'Peru',	'PH' => 'Philippines',	'PN' => 'Pitcairn',	'PL' => 'Poland',	'PT' => 'Portugal',	'PR' => 'Puerto Rico',	'QA' => 'Qatar',	'RE' => 'Reunion',	'RO' => 'Romania',	'RU' => 'Russia',	'RW' => 'Rwanda',	'BL' => 'Saint Barth&eacute;lemy',	'SH' => 'Saint Helena',	'KN' => 'Saint Kitts and Nevis',	'LC' => 'Saint Lucia',	'MF' => 'Saint Martin (French part)',	'SX' => 'Saint Martin (Dutch part)',	'PM' => 'Saint Pierre and Miquelon',	'VC' => 'Saint Vincent and the Grenadines',	'SM' => 'San Marino',	'ST' => 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe',	'SA' => 'Saudi Arabia',	'SN' => 'Senegal',	'RS' => 'Serbia',	'SC' => 'Seychelles',	'SL' => 'Sierra Leone',	'SG' => 'Singapore',	'SK' => 'Slovakia',	'SI' => 'Slovenia',	'SB' => 'Solomon Islands',	'SO' => 'Somalia',	'ZA' => 'South Africa',	'GS' => 'South Georgia/Sandwich Islands',	'KR' => 'South Korea',	'SS' => 'South Sudan',	'ES' => 'Spain',	'LK' => 'Sri Lanka',	'SD' => 'Sudan',	'SR' => 'Suriname',	'SJ' => 'Svalbard and Jan Mayen',	'SZ' => 'Swaziland',	'SE' => 'Sweden',	'CH' => 'Switzerland',	'SY' => 'Syria',	'TW' => 'Taiwan','TJ' => 'Tajikistan','TZ' => 'Tanzania','TH' => 'Thailand','TL' => 'Timor-Leste','TG' => 'Togo','TK' => 'Tokelau','TO' => 'Tonga','TT' => 'Trinidad and Tobago','TN' => 'Tunisia','TR' => 'Turkey','TM' => 'Turkmenistan','TC' => 'Turks and Caicos Islands','TV' => 'Tuvalu','UG' => 'Uganda','UA' => 'Ukraine','AE' => 'United Arab Emirates','GB' => 'United Kingdom (UK)','US' => 'United States (US)','UM' => 'United States (US) Minor Outlying Islands','VI' => 'United States (US) Virgin Islands','UY' => 'Uruguay','UZ' => 'Uzbekistan','VU' => 'Vanuatu','VA' => 'Vatican','VE' => 'Venezuela','VN' => 'Vietnam','WF' => 'Wallis and Futuna','EH' => 'Western Sahara','WS' => 'Samoa','YE' => 'Yemen','ZM' => 'Zambia','ZW' => 'Zimbabwe',
),
) );

$other_settings_checkout->createOption( array(
'name' => ''.esc_html__( 'Go Straight to Checkout', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_straight_to_checkout',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want the user to go straight to checkout when adding a product to cart.', 'divi-bodyshop-woocommerce' ).'<br><b>'.esc_html__( 'NOTE: You need to disable ajax add to cart and redirect to cart page in WooCommerce settings', 'divi-bodyshop-woocommerce' ).'</b>',
) );

$other_settings_checkout->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'Add a Custom Checkbox to checkout - for example agree to terms etc... (note this is depreciated, please use the one in BC Checkout Fields)', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$other_settings_checkout->createOption( array(
'name' => ''.esc_html__( 'Enable Custom Checkbox at Checkout?', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_checkout_custom_check_enable',
'type' => 'enable',
'default' => false,
'enabled' => ''.esc_html__( 'YES', 'divi-bodyshop-woocommerce' ).'',
'disabled' => ''.esc_html__( 'NO', 'divi-bodyshop-woocommerce' ).'',
'desc' => ''.esc_html__( 'Enable this if you want to use the custom checkbox feature at checkout', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_checkout->createOption( array(
'name' => ''.esc_html__( 'Custom Checkbox Title', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_checkout_custom_check_title',
'type' => 'text',
'desc' => ''.esc_html__( 'This is the title of the checkbox', 'divi-bodyshop-woocommerce' ).'',
'placeholder' => 'Agree to our terms?',
'default' => 'Agree to our terms?',
) );
$other_settings_checkout->createOption( array(
'name' => ''.esc_html__( 'Custom Checkbox Label', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_checkout_custom_check_label',
'type' => 'textarea',
'is_code' => true,
'desc' => ''.esc_html__( 'This is the label of the checkbox - it is code so that you can use links to important documents', 'divi-bodyshop-woocommerce' ).'',
'placeholder' => 'I have read and agree to the terms.',
'default' => 'I have read and agree to the terms.',
) );
$other_settings_checkout->createOption( array(
'name' => ''.esc_html__( 'Custom Checkbox Error', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_checkout_custom_check_error',
'type' => 'text',
'desc' => ''.esc_html__( 'This is the error message that appears if they dont check the checkbox', 'divi-bodyshop-woocommerce' ).'',
'placeholder' => 'Please agree to our terms and conditions',
'default' => 'Please agree to our terms and conditions',
) );

$other_settings_checkout->createOption( array(
'type' => 'save',
) );






$other_settings_admin->createOption( array(
'type' => 'note',
'desc' => '<p class="title">'.esc_html__( 'WordPress Admin Dash Settings.', 'divi-bodyshop-woocommerce' ).'</p>'
) );
$other_settings_admin->createOption( array(
'name' => ''.esc_html__( 'Change the name of WooCommerce on dash', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_admin_woo_name',
'type' => 'text',
'desc' => ''.esc_html__( 'Change the name of WooCommerce in the dash to another such as the store name', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_admin->createOption( array(
'name' => ''.esc_html__( 'Change WooCommerce Dash Icon', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_admin_woo_icon',
'type' => 'text',
'desc' => ''.esc_html__( 'Change the dash icon of WooCommcerce menu item, you can see a full list', 'divi-bodyshop-woocommerce' ).' <a href="https://developer.wordpress.org/resource/dashicons/#cart" target="_blank">'.esc_html__( 'here', 'divi-bodyshop-woocommerce' ).'</a>'.esc_html__( 'Just copy the code and paste it here, for example the shopping cart would be', 'divi-bodyshop-woocommerce' ).'<strong>f174</strong>'.esc_html__( ' - you can see it below the icon.', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_admin->createOption( array(
'name' => ''.esc_html__( 'Change the name of Products on dash (plural)', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_admin_woo_products_name_plural',
'type' => 'text',
'desc' => ''.esc_html__( 'Change the name of Products in the dash to another such as the Books', 'divi-bodyshop-woocommerce' ).'',
) );
$other_settings_admin->createOption( array(
'name' => ''.esc_html__( 'Change the name of Product on dash (singular)', 'divi-bodyshop-woocommerce' ).'',
'id' => 'other_settings_admin_woo_products_name_singular',
'type' => 'text',
'desc' => ''.esc_html__( 'Change the name of Products in the dash to another such as the Book', 'divi-bodyshop-woocommerce' ).'',
) );


$other_settings_admin->createOption( array(
'type' => 'save',
) );






/// LICENSE

$licensestab->createOption(array(
    'name' => 'Divi BodyCommerce Software License',
    'type' => 'heading',
));


if (isset($_GET['page']) && ($_GET['page'] == 'divi-bodyshop-woo-settings')) { // phpcs:ignore
$de_dn_option = new DE_DB_WOO_options_interface();

$licensestab->createOption(array(
    'type' => 'custom',
    'custom' => $de_dn_option->admin_menu(),
));

    add_action('init', array($de_dn_option, 'options_update'), 1);
}

}
add_action( 'tf_create_options', 'divi_bodyshop_woocommerce_options' );



//Setting Code Start
add_action('wp_ajax_divi_bc_export_action', 'divi_bc_export_action');

function divi_bc_export_action() {
    // Do something
    $mydata = get_option('divi-bodyshop-woo_options');
    $mydata = unserialize($mydata);
    $export_data = [];
    foreach ($mydata as $key => $value) {
        $export_data[] = array($key, $value);
    }

    wp_send_json_success(__($export_data, 'default'));
}

add_action('wp_ajax_divi_bc_import_action', 'divi_bc_import_action');

function divi_bc_import_action() {
  $setting_csv = file_get_contents(wp_get_attachment_url($_REQUEST['file_id'])); // phpcs:ignore
  $lines = explode("\n", $setting_csv); // split data by new lines
  $linevalues = [];
  foreach ($lines as $i => $line) {

      $values = explode(',', $line);
      $key = $values[0];
      $value = $values[1];
      if (count($values) > 2) {
          unset($values[0]);
          $value = implode($values, ",");
          $value = trim( $value,'"');
      }
      $linevalues[$key] = trim($value);
  }

  $linevalues = serialize($linevalues);

  update_option('divi-bodyshop-woo_options', $linevalues);
  wp_send_json_success(__('Successfully imported', 'default'));
}