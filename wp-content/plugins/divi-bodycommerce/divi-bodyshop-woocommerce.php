<?php
/*
Plugin Name: Divi BodyCommerce
Plugin URL: https://diviengine.com/product/divi-bodycommerce/
Description: Divi BodyCommerce is a dynamic toolkit for people that use Divi and WooCommerce together. It empowers you to build beautiful e-commerce websites that look unique and custom built
Version: 4.7.2.9.2
WC tested up to: 4.3.1
Author: Divi Engine
Author URI: https://diviengine.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: divi-bodyshop-woocommerce
Domain Path: /languages
@author      diviengine.com
@copyright   2019 diviengine.com

Father God, I pray that you bless the people who interact and who own this website - I pray the blessing to be one that goes beyond worldly treasures but understanding the deep love you have for them. In Jesus name, Amen

The Way of Love - 1 Corinthians 13 MSG
If I speak with human eloquence and angelic ecstasy but don’t love, I’m nothing but the creaking of a rusty gate.
If I speak God’s Word with power, revealing all his mysteries and making everything plain as day, and if I have faith that says to a mountain, “Jump,” and it jumps, but I don’t love, I’m nothing.
If I give everything I own to the poor and even go to the stake to be burned as a martyr, but I don’t love, I’ve gotten nowhere. So, no matter what I say, what I believe, and what I do, I’m bankrupt without love.

Love never gives up.
Love cares more for others than for self.
Love doesn’t want what it doesn’t have.
Love doesn’t strut,
Doesn’t have a swelled head,
Doesn’t force itself on others,
Isn’t always "me first,"
Doesn’t fly off the handle,
Doesn’t keep score of the sins of others,
Doesn’t revel when others grovel,
Takes pleasure in the flowering of truth,
Puts up with anything,
Trusts God always,
Always looks for the best,
Never looks back,
But keeps going to the end.

Love never dies. Inspired speech will be over some day; praying in tongues will end; understanding will reach its limit. We know only a portion of the truth, and what we say about God is always incomplete. But when the Complete arrives, our incompletes will be canceled.
When I was an infant at my mother’s breast, I gurgled and cooed like any infant. When I grew up, I left those infant ways for good.
We don’t yet see things clearly. We’re squinting in a fog, peering through a mist. But it won’t be long before the weather clears and the sun shines bright! We’ll see it all then, see it all as clearly as God sees us, knowing him directly just as he knows us!
But for right now, until that completeness, we have three things to do to lead us toward that consummation: Trust steadily in God, hope unswervingly, love extravagantly. And the best of the three is love.
*/


if (! defined('ABSPATH')) exit;

define('DE_DB_WOO_VERSION', '4.7.2.9.2');

define('DE_DB_AUTHOR', 'Divi Engine');
define('DE_DB_WOO_PATH',   plugin_dir_path(__FILE__));
define('DE_DB_WOO_URL',    plugins_url('', __FILE__));
define('DE_DB_WOO_PRODUCT_ID', 'WP-DE-DB-WOO');
define('DE_DB_WOO_INSTANCE', str_replace(array ("https://" , "http://"), "", home_url()));
define('DE_DB_PRODUCT_URL', 'https://diviengine.com/product/divi-bodycommerce/');
define('DE_DB_WOO_APP_API_URL', 'https://diviengine.com/index.php');
define('DE_DB_URL', 'https://www.diviengine.com');




/**
 * Check if WooCommerce is installed.
 *
 * @see    Woocommerce_Bc_Missing_Wc_notice
 * @return void
 */
function Woocommerce_Bc_Missing_Wc_notice() {
    echo '<div class="error"><p><strong>' . sprintf(esc_html__('Divi BodyCommerce requires WooCommerce to be installed and active. You can download %s here.', 'divi-bodyshop-woocommerce'), '<a href="https://woocommerce.com/" target="_blank">WooCommerce</a>') . '</strong></p></div>';
}


/**
 * Display WooCommerce Missing Notice.
 *
 * @see    function Woocommerce_Gateway_Bc_Checkwoo_init
 * @return void
 */
function Woocommerce_Gateway_Bc_Checkwoo_init() {
    if (! class_exists('WooCommerce')) {
        add_action('admin_notices', 'Woocommerce_Bc_Missing_Wc_notice');
        return;
    }
}
add_action('plugins_loaded', 'Woocommerce_Gateway_Bc_Checkwoo_init');

/**
 * Adds Divi Builder to the Order Bump.
 *
 * @see    function Divi_Bodycommerce_Builder_Post_types
 * @return void
 */
function Divi_Bodycommerce_Builder_Post_types( $post_types ) {
    $post_types[] = 'bc_orderbump';

    return $post_types;
}
add_filter('et_builder_third_party_post_types', 'Divi_Bodycommerce_Builder_Post_types');

/**
 * Flushed permalinks on activation.
 *
 * @see    function Bodycommerce_Activate_hook
 * @return void
 */
function Bodycommerce_Activate_hook() {
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'Bodycommerce_Activate_hook');



$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (isset($mydata['settings_remove_french_translation'][0])) {
  if ($mydata['settings_remove_french_translation'][0] == "1") {} else {
 function bodycommerce_load_languages() {
   load_plugin_textdomain( 'divi-bodyshop-woocommerce', false, basename( dirname( __FILE__ ) ) . '/languages' );
   load_plugin_textdomain( 'titan-framework', false, basename( dirname( __FILE__ ) ) . '/titan-framework/languages' );
 }
 add_action( 'plugins_loaded', 'bodycommerce_load_languages' );
}
} else {
  function bodycommerce_load_languages() {
    load_plugin_textdomain( 'divi-bodyshop-woocommerce', false, basename( dirname( __FILE__ ) ) . '/languages' );
    load_plugin_textdomain( 'titan-framework', false, basename( dirname( __FILE__ ) ) . '/titan-framework/languages' );
  }
  add_action( 'plugins_loaded', 'bodycommerce_load_languages' );
}


require_once dirname( __FILE__ ) .'/functions.php';
require_once dirname( __FILE__ ) .'/lib/features/other-woo-options.php';
require_once dirname( __FILE__ ) .'/lib/features/sharing-icons.php';
require_once dirname( __FILE__ ) .'/lib/features/checkout-fields.php';
require_once dirname( __FILE__ ) .'/lib/features/custom-tabs.php';
require_once dirname( __FILE__ ) .'/lib/features/custom-css-js.php';
require_once dirname( __FILE__ ) .'/lib/features/cart-minicart/custom-cart.php';
require_once dirname( __FILE__ ) .'/lib/features/cart-minicart/minicart-settings.php';
require_once dirname( __FILE__ ) .'/lib/features/cart-minicart/custom-cart-css.php';
require_once dirname( __FILE__ ) .'/lib/features/checkout-funnel/checkout-order-bump.php';
require_once dirname( __FILE__ ) .'/lib/features/ajax-add-to-cart.php';

function dbc_get_theme_details(){
	$theme = wp_get_theme(get_template());
	if( !defined( 'DIVIENGINE_BC_THEME_NAME' ) ){
        define( 'DIVIENGINE_BC_THEME_NAME', strtolower($theme->Name) );
	}
}
dbc_get_theme_details();


$db_settings = get_option( 'divi-bodyshop-woo_options' );
$enable_variation_swatches = unserialize($db_settings);
if (isset($enable_variation_swatches['enable_variation_swatches'][0])) {
$check_enable_variation_swatches = $enable_variation_swatches['enable_variation_swatches'][0];
}
else { $check_enable_variation_swatches = "1"; }

if ($check_enable_variation_swatches == "0") {
} else {
require_once dirname( __FILE__ ) .'/lib/features/variation-swatches.php';
}


$enable_custom_pagination = unserialize($db_settings);
if (isset($enable_custom_pagination['enable_custom_pagination'][0])) {
$enable_custom_pagination_check = $enable_custom_pagination['enable_custom_pagination'][0];
}
else { $enable_custom_pagination_check = "1"; }

if ($enable_custom_pagination_check == "1") {
require_once dirname( __FILE__ ) .'/lib/features/pagination.php';
} else {
}


if (isset($enable_variation_swatches['settings_disable_checkout_head_css'][0])) {
$check_settings_disable_checkout_head_css = $enable_variation_swatches['settings_disable_checkout_head_css'][0];
}
else { $check_settings_disable_checkout_head_css = "0"; }

if ($check_settings_disable_checkout_head_css == "0") {
require_once dirname( __FILE__ ) .'/lib/features/checkout.php';
} else {
}



require_once dirname( __FILE__ ) .'/lib/custom-post.php';

include(DE_DB_WOO_PATH . '/includes/classes/class-wvs-term-meta.php');

include(DE_DB_WOO_PATH . '/includes/classes/class.wooslt.php');
include(DE_DB_WOO_PATH . '/includes/classes/class.licence.php');
include(DE_DB_WOO_PATH . '/includes/classes/class.options.php');
include(DE_DB_WOO_PATH . '/includes/classes/class.updater.php');


include(DE_DB_WOO_PATH . '/includes/classes/init.class.php');
include(DE_DB_WOO_PATH . '/includes/shortcodes/shortcodes.php');
include(DE_DB_WOO_PATH . '/includes/shortcodes/builder-shortcodes.php');


// initialise Divi Modules
if ( !function_exists( 'de_bc_initialise_ext' ) ) {
    function de_bc_initialise_ext()
    {
        require_once plugin_dir_path( __FILE__ ) . 'includes/DEBodyCommerce.php';
    }
    add_action( 'divi_extensions_init', 'de_bc_initialise_ext' );
}



////////////////////////////////////////////////

 // get post id for vb
 function bc_get_post_id_vb(){

 	if( isset( $_REQUEST['et_post_id'] ) ){ // phpcs:ignore
 		$post_id = absint( $_REQUEST['et_post_id'] ); // phpcs:ignore
 	}elseif( isset( $_REQUEST['current_page']['id'] ) ){ // phpcs:ignore
 		$post_id = absint( $_REQUEST['current_page']['id'] ); // phpcs:ignore
 	}else{
 		$post_id = false;
 	}
 	return $post_id;
 }



////////////////////////////////////////////////

// CHECKOUT



remove_action('woocommerce_before_checkout_form','woocommerce_checkout_login_form',10);
remove_action('woocommerce_before_checkout_form','woocommerce_checkout_coupon_form',10);

remove_action('woocommerce_checkout_order_review','woocommerce_order_review',10);
remove_action('woocommerce_checkout_order_review','woocommerce_checkout_payment',20);

add_action('bodycommerce_before_checkout_login_form','woocommerce_checkout_login_form',10);
add_action('bodycommerce_before_checkout_coupon_form','woocommerce_checkout_coupon_form',10);

add_action( 'bodycommerce_checkout_order_review', 'woocommerce_order_review', 10 );
add_action( 'bodycommerce_checkout_order_payment', 'woocommerce_checkout_payment', 20 );


	function bodycommerce_multi_step_checkout_script() {
	if ( ! is_admin() ) {
		include('titan-framework/titan-framework-embedder.php');
		$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
		$checkout_page_enable = $titan->getOption( 'checkout_page_enable' );
if ($checkout_page_enable == "1"){

	  wp_enqueue_script( 'bodycommerce-multi-checkout', plugins_url() . '/divi-bodycommerce/scripts/db-multi-checkout.min.js', array('jquery'), DE_DB_WOO_VERSION, true );


	}
}
}

add_action('wp_head','bodycommerce_multi_step_checkout_script');



function bodycomerce_enqueue_styles_frontend() {

    include('titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
    $settings_disable_gallery_js_file = $titan->getOption( 'settings_disable_gallery_js_file' );
    $main_css_method = $titan->getOption( 'main_css_method' );

  if ($settings_disable_gallery_js_file == "1"){
  }
  else {
  wp_enqueue_style( 'bc-venobox', DE_DB_WOO_URL . '/styles/venobox.css' , array(), DE_DB_WOO_VERSION, 'all' );
}

if ($main_css_method == 'old') {
wp_dequeue_style( 'divi-bodyshop-woocommerce-styles' );
wp_enqueue_style( 'bc-old-main-css', DE_DB_WOO_URL . '/styles/style-old.min.css' , array(), DE_DB_WOO_VERSION, 'all' );
}

}
add_action( 'wp_enqueue_scripts', 'bodycomerce_enqueue_styles_frontend', 999999999 );

//////////////////////////////////////////////






add_filter( 'woocommerce_locate_template', 'bodycommerce_woo_templates', 1, 3 );
   function bodycommerce_woo_templates( $template, $template_name, $template_path ) {
     global $woocommerce;
     $_template = $template;
     if ( ! $template_path )
        $template_path = $woocommerce->template_url;

     $plugin_path  = untrailingslashit( plugin_dir_path( __FILE__ ) )  . '/includes/templates/woocommerce/';

    // Look within passed path within the theme - this is priority
    $template = locate_template(
    array(
      $template_path . $template_name,
      $template_name
    )
   );

   if( ! $template && file_exists( $plugin_path . $template_name ) )
    $template = $plugin_path . $template_name;

   if ( ! $template )
    $template = $_template;

   return $template;
}



if (isset($enable_variation_swatches['settings_disable_general_head_css'][0])) {
$settings_disable_general_head_css = $enable_variation_swatches['settings_disable_general_head_css'][0];
}
else { $settings_disable_general_head_css = "0"; }

if ($settings_disable_general_head_css == "0") {
require_once dirname( __FILE__ ) .'/lib/global-head-css.php';
function bodyshop_woo_display_css() {

include('titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

$get_my_acount_fullwidth = $titan->getOption( 'my_acount_fullwidth' );
$product_page_fullwidth = $titan->getOption( 'product_page_fullwidth' );
$cart_page_fullwidth = $titan->getOption( 'cart_page_fullwidth' );
$cart_page_remove_title = $titan->getOption( 'cart_page_remove_title' );

$get_my_acount_remove_headings = $titan->getOption( 'my_acount_remove_headings' );
$get_my_acount_layout = $titan->getOption( 'my_acount_layout' );
$get_my_acount_fullwidth_end_padding = $titan->getOption( 'my_acount_fullwidth_end_padding' );
$get_my_acount_layout_width = $titan->getOption( 'my_acount_layout_width' );
$get_my_acount_layout_width_other = 100 - $get_my_acount_layout_width;

$get_other_endpoint_width = $get_my_acount_layout_width_other - 20;
$get_other_endpoint_width_margin_right = 10;


$my_acount_left_right_same_height = $titan->getOption( 'my_acount_left_right_same_height' );

$get_my_acount_other_endpoints_fullwidth = $titan->getOption( 'my_acount_other_endpoints_fullwidth' );
$get_my_acount_other_endpoints_padding = $titan->getOption( 'my_acount_other_endpoints_padding' );

$get_my_acount_remove_notices = $titan->getOption( 'my_acount_remove_notices' );
$get_checkout_page_remove_title = $titan->getOption( 'checkout_page_remove_title' );
$get_checkout_page_fullwidth = $titan->getOption( 'checkout_page_fullwidth' );


if ($get_checkout_page_remove_title == 1) {
    echo "<style>.woocommerce-checkout .entry-title {display:none !important;}</style>";
}
else {
}

if ($get_checkout_page_fullwidth == 1) {
    echo "<style>.woocommerce-checkout #main-content .container {width:100%; max-width:100%;}.woocommerce-checkout #main-content #left-area {width:100% !important;padding-right: 0 !important;}.woocommerce-checkout #sidebar, .woocommerce-cart #main-content .container::before, .woocommerce-cart .main_title {display:none;}</style>";
}
else {
}



if ($get_my_acount_other_endpoints_fullwidth != 1) {
		$get_my_acount_other_endpoints_fullwidth_display = "";
    $get_my_acount_other_endpoints_fullwidth_display_left = "";
}
	else {
		$get_my_acount_other_endpoints_fullwidth_display = '.woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ h1, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ h2, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ h3, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ div:not(.et_pb_section) {    position: relative;width: 80%;max-width: 1080px;    margin: 0 auto;}';
		$get_my_acount_other_endpoints_fullwidth_display_left = '.woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ h1, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ h2, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ h3, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ div:not(.et_pb_section), .woocommerce-account.logged-in .entry-content .woocommerce > * {    position: relative;width: '.$get_other_endpoint_width.'%;max-width: 1080px;    margin: 0 auto; margin-right: '.$get_other_endpoint_width_margin_right.'%;}';

	}

if ($get_my_acount_other_endpoints_padding == "") {
	$get_my_acount_other_endpoints_padding_display = "";
}
else {
	$get_my_acount_other_endpoints_padding_display = '	.woocommerce-account.logged-in .entry-content .woocommerce .clearfix + h1, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix + h2, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix + h3 {padding: '.$get_my_acount_other_endpoints_padding.'px 0;}';
}

if ($my_acount_left_right_same_height == 1) {
  $my_acount_left_right_same_height_dis = "
.bc-account-content-container {display: flex;}
.bc-account-content-container .bc-account-content .et_pb_section, .bc-account-content-container .bc-account-content .et_pb_row, .bc-account-content-container .bc-account-content .et_pb_column {height: 100%;};
  ";
} else {
  $my_acount_left_right_same_height_dis = "";
}

$css_woo_bodyshop_class = "fullwidth";

if ($get_my_acount_layout == 1){

  $css_woo_bodyshop =  sprintf('<style id="bodyshop-%s"> ', $css_woo_bodyshop_class);
  $css_woo_bodyshop .= '

.bc-account-content-container .bc-account-nav {
  width: '.$get_my_acount_layout_width.'%; float: left;
}

.bc-account-content-container .bc-account-content {
  width: '.$get_my_acount_layout_width_other.'%;float: right;
}

@media only screen and (max-width: 980px) {
.bc-account-content-container .bc-account-nav, .bc-account-content-container .bc-account-content {width: 100%;}
.bc-account-content-container {
  display: block;
}
}

'.$my_acount_left_right_same_height_dis.'

'.$get_my_acount_other_endpoints_fullwidth_display_left.'
'.$get_my_acount_other_endpoints_padding_display.'
	';
  $css_woo_bodyshop .= '</style>';
  //minify it
  $css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
  echo $css_woo_bodyshop_min; // phpcs:ignore
}
else {
	$css_woo_bodyshop =  sprintf('<style id="bodyshop-%s"> ', $css_woo_bodyshop_class);
	$css_woo_bodyshop .= '
	'.$get_my_acount_other_endpoints_fullwidth_display.'
	'.$get_my_acount_other_endpoints_padding_display.'
	';
  $css_woo_bodyshop .= '</style>';
  //minify it
  $css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
  echo $css_woo_bodyshop_min; // phpcs:ignore
}

        if ($get_my_acount_fullwidth == 1) {
            $css_woo_bodyshop_class = "woo-full";
            $css_woo_bodyshop = '';
            $css_woo_bodyshop .=  sprintf('<style id="bodyshop-%s"> ', $css_woo_bodyshop_class);
            $css_woo_bodyshop .= '
            .woocommerce-account #main-content .container {width:100%; max-width:100%;}
            .woocommerce-account #left-area {padding-right:0 !important;width:100% !important;}
            .woocommerce-account #sidebar, .et_right_sidebar #main-content .container:before {display:none !important;}
            .woocommerce-account #main-content .et_pb_section.et_pb_section_0 > .et_pb_row {
            	width: 100%;
            	max-width: 100%;
            	padding: 0;
              }
            .woocommerce-account .et_pb_section.et_pb_section_0 {
            	padding: 0;
              }
            ';
            $css_woo_bodyshop .= '</style>';
            //minify it
            $css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
            echo $css_woo_bodyshop_min; // phpcs:ignore
            } else { }

if ($product_page_fullwidth == 1){
$css_woo_bodyshop_class = "woo-full-product";
$css_woo_bodyshop = '';
$css_woo_bodyshop .=  sprintf('<style id="bodyshop-%s"> ', $css_woo_bodyshop_class);
$css_woo_bodyshop .= '
.single-product #main-content .container {width:100%; max-width:100%;}
.single-product #main-content #left-area {width:100% !important;padding-right: 0 !important;}
';
$css_woo_bodyshop .= '</style>';
//minify it
$css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
echo $css_woo_bodyshop_min; // phpcs:ignore
}
else {

}

if ($cart_page_fullwidth == 1){

  $css_woo_bodyshop_class = "woo-full-woocommerce-cart";
  $css_woo_bodyshop = '';
  $css_woo_bodyshop .=  sprintf('<style id="bodyshop-%s"> ', $css_woo_bodyshop_class);
  $css_woo_bodyshop .= '
  .woocommerce-cart #main-content .container {width:100%; max-width:100%;}
  .woocommerce-cart #main-content #left-area {width:100% !important;padding-right: 0 !important;}
  .woocommerce-cart #sidebar, .woocommerce-cart #main-content .container::before, .woocommerce-cart .main_title {display:none;}
  ';
  $css_woo_bodyshop .= '</style>';
  //minify it
  $css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
  echo $css_woo_bodyshop_min; // phpcs:ignore
}else {
  // code...
}

if ($cart_page_remove_title == 1) {
  $css_woo_bodyshop_class = "bodycommerce-cart-title";
  $css_woo_bodyshop = '';
  $css_woo_bodyshop .=  sprintf('<style id="bodyshop-%s"> ', $css_woo_bodyshop_class);
  $css_woo_bodyshop .= '
  .woocommerce-cart .main_title {display:none;}
  ';
  $css_woo_bodyshop .= '</style>';
  //minify it
  $css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
  echo $css_woo_bodyshop_min; // phpcs:ignore
} else {
  // code...
}


if ($get_my_acount_remove_headings == 1){
  $css_woo_bodyshop_class = "woo-heading";
  $css_woo_bodyshop = '';
  $css_woo_bodyshop .=  sprintf('<style id="bodyshop-%s"> ', $css_woo_bodyshop_class);
  $css_woo_bodyshop .= '
  .woocommerce-account .entry-title.main_title {display:none;}
  ';
  $css_woo_bodyshop .= '</style>';
  //minify it
  $css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
  echo $css_woo_bodyshop_min; // phpcs:ignore
}
else {
  # code...
}

  $css_woo_bodyshop .= '<style id="bodycommerce">';
  $css_woo_bodyshop .= '

.et_pb_db_shop_cat_loop .et_pb_row_bodycommerce {clear: both;}

  .stock::first-letter, .out-of-stock::first-letter {
    text-transform: capitalize;
  }

.woocommerce-form .et_pb_contact p .woocommerce-form__label-for-checkbox input[type="checkbox"] {
	    -webkit-appearance: checkbox !important;
}

  #main-content .container {padding-top: 0px !important;}
.woocommerce-customer-details, .woocommerce-order-downloads, .woocommerce-account.logged-in .entry-content .woocommerce .col.s12, .woocommerce-account.logged-in .entry-content .woocommerce .woocommerce-order-details, .woocommerce-account.logged-in .entry-content .woocommerce > p {padding: '.$get_my_acount_fullwidth_end_padding.'px;}
  .et_pb_db_shop_loop_list .et_pb_row, .et_pb_db_shop_loop_grid .et_pb_row_bodycommerce, .et_pb_db_shop_loop_grid .et_pb_row_bodycommerce .et_pb_row {
    width: 100%;
    max-width: inherit;
    padding-left: 0;
    padding-right: 0;
}
.et_pb_gutters3 .et_pb_column_4_4 .et_pb_blog_grid.et_pb_db_shop_loop_grid .column.size-1of3, .et_pb_gutters3.et_pb_row .et_pb_column_4_4 .et_pb_blog_grid.et_pb_db_shop_loop_grid .column.size-1of3 {
    width: auto !important;
    margin-right: auto;
}

.et_pb_dc_product_column .et_pb_row {
    padding: 0;
}


.et_pb_db_shop_loop_list .et_pb_section, .et_pb_db_shop_loop_grid .et_pb_section {
    padding: 0;
}


.archive.woocommerce .quantity, .woocommerce .et_pb_shop .quantity {float:left;}
.archive.woocommerce .add_to_cart_button, .woocommerce .et_pb_shop .add_to_cart_button {margin-top:0;}

.woocommerce .cart-collaterals.cart-collaterals-bc .cart_totals, .woocommerce-page .cart-collaterals.cart-collaterals-bc .cart_totals {width: 100%;}

.et_pb_db_cart_products.image_size_small .cart .product-thumbnail img {
    width: 60px;
}

.et_pb_db_cart_products.image_size_medium .cart .product-thumbnail img {
    width: 150px;
}

.et_pb_db_cart_products.image_size_large .cart .product-thumbnail img {
    width: 300px;
}

.et_pb_module.no-borders table,
.et_pb_module.no-borders table td,
.et_pb_module.no-borders table th,
.et_pb_module.no-borders .cart-collaterals .cart_totals table th,
.et_pb_module.no-borders .cart-collaterals .cart_totals table td,
.woocommerce .et_pb_module.no-borders table.shop_table tbody th,
.woocommerce .et_pb_module.no-borders table.shop_table tfoot td,
.woocommerce .et_pb_module.no-borders table.shop_table tfoot th,
.woocommerce .et_pb_module.no-borders .woocommerce-customer-details address,
.woocommerce .et_pb_module.no-borders .cart-subtotal td {
    border: none !important;
}

.et_pb_module.no-title .woocommerce-column__title {
display: none;
}

.woocommerce-form .et_pb_contact p input[type="checkbox"] {display: inline-block;margin-right: 10px;}

/*
.et_pb_db_navigation {
	display: flex;
}
*/

.img_pos_top a {
	display: flex;
flex-direction: column;
}

.img_pos_bottom a {
	display: flex;
flex-direction: column-reverse;
}


.et_pb_db_navigation.et_pb_text_align_left {
		display: flex;
		justify-content: flex-start;
		width: 100%;
}

.et_pb_db_navigation.et_pb_text_align_center {
	display: flex;
	justify-content: center;
	width: 100%;
}

.et_pb_db_navigation.et_pb_text_align_right {
		display: flex;
		justify-content: flex-end;
		width: 100%;
}

.db_pro_prev_product {
	margin: 0 2% 0 0;
	max-width: 48%;
	float: left;
}

.db_pro_next_product {
	margin: 0 0 0 2%;
	    max-width: 48%;
	    float: left;
}
.et_pb_text_align_edge_to_edge{
	overflow: hidden
}
.et_pb_text_align_edge_to_edge .db_pro_prev_product {float:left;}
.et_pb_text_align_edge_to_edge .db_pro_next_product {float: right;}

.et_pb_gutters3 .et_pb_column_2_3 .et_pb_dc_product_column.et_pb_column_1_3, .et_pb_gutters3 .et_pb_column_2_3 .et_pb_db_cat_column.et_pb_column_1_3 {
    width: 30%;
    margin-right: 5%;
}

.et_pb_row.et_pb_row_bodycommerce .et_pb_dc_product_column.et_pb_column_1_4 {margin: 0 3.8% 2.992em 0;width: 21.05%;}
.et_pb_row.et_pb_row_bodycommerce .et_pb_dc_product_column.et_pb_column_1_3 {margin-right: 3%;width: 31.333%;}

.woocommerce #respond input#submit.loading::after, .woocommerce a.button.loading::after, .woocommerce button.button.loading::after, .woocommerce input.button.loading::after {
	top: 10px;
	right: 2px;
}

@media only screen and (max-width: 980px) {
  .woocommerce-account.logged-in .entry-content .woocommerce .et_pb_section:nth-child(1),   .woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ h3, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ h1,.woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ h2, .woocommerce-account.logged-in .entry-content .woocommerce .clearfix ~ div, .woocommerce-account.logged-in .entry-content .woocommerce .et_pb_section, .woocommerce-account.logged-in .entry-content .woocommerce .col.s12, .woocommerce-account.logged-in .entry-content .woocommerce .woocommerce-order-details, .woocommerce-account.logged-in .entry-content .woocommerce > p {
		width: 100%;
		margin 0;
	}
}
  ';
  $css_woo_bodyshop .= '</style>';
  //minify it
  $css_woo_bodyshop_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_woo_bodyshop );
  echo $css_woo_bodyshop_min; // phpcs:ignore
	echo '<style>.et_pb_db_shop_thumbnail a, .et_pb_db_shop_thumbnail img.secondary-image {padding: inherit;}.secondary-image {position: absolute;top: 0; left: 0;opacity: 0;	-webkit-transition: opacity .5s ease;-o-transition: opacity .5s ease;transition: opacity .5s ease;}.secondary-image + img{-webkit-transition: opacity .5s ease;-o-transition: opacity .5s ease;transition: opacity .5s ease;}.et_pb_db_shop_thumbnail:hover .secondary-image + img {opacity:0;}.et_pb_db_shop_thumbnail:hover .secondary-image {opacity:1 !important;}</style>';


}
add_action('wp_head', 'bodyshop_woo_display_css');

} else {
}

function internet_explorer_jquery() {
?>
<script>
jQuery(document).ready(function(i){const c=window.navigator.userAgent;function t(c){i(".bc_product_grid").each(function(t,o){var n,s,d,r=i(this).find("li.product"),e=(n=i(this),s=c,d=void 0,i(n.attr("class").split(" ")).each(function(){this.indexOf(s)>-1&&(d=this)}),d).replace(c,""),u=1,h=1;i(r).each(function(i,c){u++});var l=Math.ceil(u/e),a=l*e;i(r).each(function(c,t){var o=(h-1)%e+1,n=Math.ceil(h*l/a);i(this).closest(".bc_product_grid").find("li.product:nth-child("+h+")").css("-ms-grid-row",""+n),i(this).closest(".bc_product_grid").find("li.product:nth-child("+h+")").css("-ms-grid-column",""+o),h++})})}/MSIE|Trident/.test(c)&&i(window).on("resize",function(){i(window).width()>=981?(col_size="bc_product_",t(col_size)):(col_size="bc_pro_mob_",t(col_size))})});
</script>
<?php
  }
  add_action('wp_head', 'internet_explorer_jquery');


function internet_explorer_css() {
?>

<style>
.bc_product_1{display:-ms-grid;-ms-grid-columns:1fr}.bc_product_2{display:-ms-grid;-ms-grid-columns:1fr 1fr}.bc_product_3{display:-ms-grid;-ms-grid-columns:1fr 1fr 1fr}.bc_product_4{display:-ms-grid;-ms-grid-columns:1fr 1fr 1fr 1fr}.bc_product_5{display:-ms-grid;-ms-grid-columns:1fr 1fr 1fr 1fr 1fr}.bc_product_6{display:-ms-grid;-ms-grid-columns:1fr 1fr 1fr 1fr 1fr 1fr}@media(max-width:980px){body .bc_pro_mob_1{display:-ms-grid;-ms-grid-columns:1fr}body .bc_pro_mob_2{display:-ms-grid;-ms-grid-columns:1fr 1fr}}@media screen and (-ms-high-contrast:active),(-ms-high-contrast:none){.woocommerce #main-content .et_pb_gutters4 .et_pb_db_shop_loop ul.bc_product_grid li.product,ul.bc_product_grid li.product>*{margin-left:8%!important;margin-right:8%!important}.woocommerce.et_pb_gutters3 #main-content .et_pb_db_shop_loop ul.bc_product_grid li.product,ul.bc_product_grid li.product>*{margin-left:5.5%!important;margin-right:5.5%!important}.woocommerce #main-content .et_pb_gutters2 .et_pb_db_shop_loop ul.bc_product_grid li.product,ul.bc_product_grid li.product>*{margin-left:3%!important;margin-right:3%!important}.woocommerce #main-content .et_pb_gutters1 .et_pb_db_shop_loop ul.bc_product_grid li.product,ul.bc_product_grid li.product>*{margin-left:0!important;margin-right:0!important}}
</style>

<?php
}
add_action('wp_head', 'internet_explorer_css');



$get_divi_engine_css = get_option('divi-engine-css', null);
if ($get_divi_engine_css == "" || $get_divi_engine_css == "bodyshop-woo-added" ) {
  update_option('divi-engine-css', 'bodyshop-woo-added');

add_action( 'admin_enqueue_scripts', 'load_divi_engine_style_woo' , 20);
function load_divi_engine_style_woo() {
$cssfile = plugins_url( 'styles/divi-engine.css', __FILE__ );
// $cssfile_font = 'https://fonts.googleapis.com/css?family=Roboto';

 wp_enqueue_style( 'divi_engine_admin_css', $cssfile , false, DE_DB_WOO_VERSION );
  // wp_enqueue_style( 'divi_engine_admin_css_roboto', $cssfile_font , false, DE_DB_WOO_VERSION );
}

}

add_action( 'admin_enqueue_scripts', 'load_divi_bodyshop_woo_js' , 20);
          function load_divi_bodyshop_woo_js($hook_suffix) {
          $jsfile = plugins_url( 'scripts/admin.min.js', __FILE__ );
          $importjsfile = plugins_url( 'import_export.js', __FILE__ );
          wp_enqueue_script( 'divi-bodycommerce-admin-script', $jsfile, array( 'jquery' ), DE_DB_WOO_VERSION );
          wp_enqueue_script( 'divi-bodycommerce-admin-import-export', $importjsfile, array( 'jquery' ), DE_DB_WOO_VERSION );

       }

       /// admin script for product pages
add_action( 'admin_enqueue_scripts', 'load_divi_bodycommerce_product_js' , 11);
          function load_divi_bodycommerce_product_js($hook_suffix) {
            if ( 'product' === get_post_type() ) {
          $jsfile = plugins_url( 'scripts/product-admin.js', __FILE__ );
          wp_enqueue_script( 'divi-bodycommerce-product-admin-script', $jsfile, array( 'jquery' ), DE_DB_WOO_VERSION );
        }
       }


       add_action( 'admin_enqueue_scripts', 'load_style_woo' , 20);
       function load_style_woo() {
       $cssfile = plugins_url( 'styles/divi-bodycommerce.min.css', __FILE__ );
        wp_enqueue_style( 'divi_bodyshop_woo_admin_css', $cssfile , false, DE_DB_WOO_VERSION );
       }


register_uninstall_hook( __FILE__, 'bodyshop_woo_uninstall_hook' );


function bodyshop_woo_uninstall_hook() {
delete_option( 'divi-engine-menu' );
delete_option( 'divi-engine-css' );
delete_option( 'divi-bodyshop-woo_options' );
}








// product category for module


if ( ! function_exists( 'et_builder_include_categories_option_product' ) ) :
function et_builder_include_categories_option_product( $args = array() ) {

$terms = get_terms( 'product_cat', $args );


	$defaults = apply_filters( 'et_builder_include_categories_defaults', array (
		'use_terms' => true,
		'term_name' => 'product_cat',
	) );

	$args = wp_parse_args( $args, $defaults );

	$term_args = apply_filters( 'et_builder_include_categories_option_product_args', array( 'hide_empty' => false, ) );

	$output = "\t" . "<% var et_pb_include_categories_temp = typeof et_pb_include_categories !== 'undefined' ? et_pb_include_categories.split( ',' ) : []; %>" . "\n";

	if ( $args['use_terms'] ) {
		$cats_array = get_terms( $args['term_name'], $term_args );
	} else {
		$cats_array = get_categories( apply_filters( 'et_builder_get_categories_args', 'hide_empty=0' ) );
	}

	if ( empty( $cats_array ) ) {
		$output = '<p>' . esc_html__( "You currently don't have any products assigned to a category.", 'et_builder' ) . '</p>';
	}

  foreach ( $terms as $term ) {

		$contains = sprintf(
			'<%%= _.contains( et_pb_include_categories_temp, "%1$s" ) ? checked="checked" : "" %%>',
			esc_html( $term->name )
		);

		$output .= sprintf(
			'%4$s<label><input type="checkbox" name="et_pb_include_categories" value="%1$s"%3$s> %2$s</label><br/>',
			esc_attr( $term->term_id ),
			esc_html( $term->name ),
			$contains,
			"\n\t\t\t\t\t"
		);
	}

	$output = '<div id="et_pb_include_categories">' . $output . '</div>';

	return apply_filters( 'et_builder_include_categories_option_product_html', $output );
}
endif;


/////------------------------------------------------------------------------
add_action('plugins_loaded', 'bodycommerce_init');
    function bodycommerce_init() {
        add_filter( 'template_include', 'bodycommerce_include_woo_templates_include', 99 );
    }


function bodycommerce_include_woo_templates_include( $template ) {
    $base_template = basename($template);

    if ($base_template == 'single-product.php') {
        $product_layout = bodycommerce_single_layout();

                        if ($product_layout) {
                            $template = dirname(__FILE__) . '/includes/templates/master-template.php';
                        }


    } else if ($base_template == 'archive-product.php' || $base_template == 'taxonomy-product_cat.php' || $base_template == 'taxonomy-product_tag.php' ) {

        $product_layout = bodycommerce_archive_layout();
    if ($product_layout) {
        $template = dirname(__FILE__) . '/includes/templates/master-template.php';
    }
// }
    }
    else if ( is_wc_endpoint_url( 'order-received' ) ) {

      $product_layout = bodycommerce_thankyou_layout();
  if ($product_layout) {
      $template = dirname(__FILE__) . '/includes/templates/master-template.php';
  }

    }
    else if ( is_cart() && is_checkout() && 0 == WC()->cart->get_cart_contents_count() && ! is_wc_endpoint_url( 'order-pay' ) && ! is_wc_endpoint_url( 'order-received' ) ) {

      $product_layout = bodycommerce_blank_cart_layout();
  if ($product_layout) {
      $template = dirname(__FILE__) . '/includes/templates/master-template.php';
  }

    }

    return $template;
}


function bodycommerce_single_layout() {
  include('titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  global $wpdb;
  $get_product_page_enable_multiple_templates = $titan->getOption( 'product_page_enable_multiple_templates' );
  $product_template_override = $titan->getOption( 'product_template_override', get_the_ID() );

  $product_layout = $titan->getOption( 'product_page_template' );


/// KEEP THIS CODE
global $post;
$terms = get_the_terms( $post->ID, 'product_cat' );
// get last cat
if (is_array($terms)) {
$last_cat_child = array_slice($terms, -1, 1, true);
$last_cat_child = array_values($last_cat_child);
$term_child_slug_first = $last_cat_child["0"];
}
else {
$term_child_slug_first = "";
}




$term_child_slug = get_term($term_child_slug_first);

  $child_name = "underfined";
  $term_parent_name = "underfined";
  if (isset($term_child_slug->slug)) {

$child_slug = $term_child_slug->slug;
$check_product_page_category_child = $titan->getOption( 'custom_product_'.$child_slug.'' );

if ($check_product_page_category_child != "") {
  $child_name = $term_child_slug->name;
}
else {
  $child_name = "underfined";
}

$product_parent_categories_all_hierachy = get_ancestors( $term_child_slug->term_id, 'product_cat' );
$last_parent_cat = array_slice($product_parent_categories_all_hierachy, -1, 1, true);
if (empty($last_parent_cat)) {
}
else {

if (!isset($last_parent_cat[0])) {
  $term_parent_name = "underfined";
}
else {
if( $term = get_term_by( 'id', $last_parent_cat[0], 'product_cat' ) ){

		$term_parent_slug = $term->slug;
		$check_product_page_category_parent = $titan->getOption( 'custom_product_'.$term_parent_slug.'' );



if ($check_product_page_category_parent != "") {
  $term_parent_name = $term->name;
}
else {
  $term_parent_name = "underfined";
}
}
}


}

}
else {
  $child_name = "underfined";
  $term_parent_name = "underfined";
}
/// KEEP THIS CODE



global $post, $product;
$defaultCategory = $titan->getOption( 'product_template_override_primary' ) ?: "";
if( $defaultCategory != "" ){
$defaultCategory_term = get_term_by( 'id', $defaultCategory, 'product_cat' );
if ($defaultCategory_term != "") {
$defaultCategory_term_name = $defaultCategory_term->name;
$defaultCategory_term_slug = $defaultCategory_term->slug;
$check_defaultCategory_template = $titan->getOption( 'custom_product_'.$defaultCategory_term_slug.'' );
} else {
  $defaultCategory_term_name = "";
}
} else {
  $defaultCategory_term_name = "";
}

if ($product_template_override != "") {
    $display_layout = $product_template_override;
}
else if( $defaultCategory_term_name != "" && ! empty( $defaultCategory ) ) {
	$display_layout = $check_defaultCategory_template;
}
else if ( is_product() && has_term( $child_name, 'product_cat', $post->ID ) && $get_product_page_enable_multiple_templates == 1  ) {
	$display_layout = $check_product_page_category_child;
}
else if ( is_product() && has_term( $term_parent_name, 'product_cat', $post->ID ) && $get_product_page_enable_multiple_templates == 1  ) {
	$display_layout = $check_product_page_category_parent;
}
else {
  $display_layout = $product_layout;
}

?>  <?php
    // product schema data
    if( class_exists( 'WC_Structured_Data' ) ){
      $wc_str_data = new WC_Structured_Data();
      $wc_str_data->generate_product_data();
    }
    return $display_layout;
    ?>

 <?php

}

function bodycommerce_archive_layout() {


  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );


  $get_category_page_enable_multiple_templates = $titan->getOption( 'category_page_enable_multiple_templates' );

  $category_layout = $titan->getOption( 'category_page_template' );
  $archive_page_shop_template = $titan->getOption( 'archive_page_shop_template' );
  $archive_page_category_template = $titan->getOption( 'archive_page_category_template' );

  $tag_template = $titan->getOption( 'tag_template' );
    $attr_template = $titan->getOption( 'attr_template' );
  $tag_page_enable_multiple_templates = $titan->getOption( 'tag_page_enable_multiple_templates' );

  $search_page_template = $titan->getOption( 'search_page_template' );


					if (is_shop()) {

if (is_search()) {
            $display_layout = $search_page_template;
}
else {
            $display_layout = $archive_page_shop_template;
}




          }

					else {

if ( is_tax( 'product_cat' ) ) {
global $wp_query;
$cat = get_queried_object();
$cat_id = $cat->id;
$cat_slug = $cat->slug;

$cat_slug = 'custom_category_'.$cat->slug.'';

$check_category_page_category = $titan->getOption( $cat_slug );


global $post, $product;
if ($archive_page_category_template != "" && $get_category_page_enable_multiple_templates != 1) {
  $display_layout = $archive_page_category_template;
}
else if ($check_category_page_category == "" && $get_category_page_enable_multiple_templates == 1) {
   $display_layout = $archive_page_category_template;
 }
 else  {
   $display_layout = $check_category_page_category;
 }
	} else if ( is_tax( 'product_tag' ) ) {

    global $wp_query;
    $tag = get_queried_object();


    $cat_id = $tag->term_id;
    $tag_slug = $tag->slug;

    $tag_slug = 'custom_tag_'.$tag->slug.'';


    $check_tag_category_id = $titan->getOption( $tag_slug );


    global $post, $product;
    if ($tag_template != "" && $tag_page_enable_multiple_templates != 1) {
      $display_layout = $tag_template;
    }
    else if ($check_tag_category_id == "" && $tag_page_enable_multiple_templates == 1) {
       $display_layout = $tag_template;
     }
     else if ($tag_template == "" && $tag_page_enable_multiple_templates == 0) {
        $display_layout = $archive_page_category_template;
      }
     else  {
       $display_layout = $check_tag_category_id;
     }

} else if ( is_tax() && function_exists( 'taxonomy_is_product_attribute') ) {
  $display_layout = $attr_template;
 }
else {
  $display_layout = $archive_page_category_template;
}



          }

              return $display_layout;
}

function bodycommerce_thankyou_layout() {
  
  global $wp;

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

  $thankyou_page_template = $titan->getOption( 'thankyou_page_template' );

  $display_layout = $thankyou_page_template;

  $order_id  = absint( $wp->query_vars['order-received'] );

  $order = wc_get_order($order_id);

  // check if order cust id = current user id
  $order_key = $_GET['key'];

  if ( !$order || !hash_equals($order->get_order_key(), $order_key ) ){
    return false;
  }

  $user_id = $order->get_user_id();
  $current_user_id = get_current_user_id();
  if ($current_user_id !== $user_id) {
    return false;
  }

  return $display_layout;
}

function bodycommerce_blank_cart_layout() {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

  $get_cart_empty_page_template = $titan->getOption( 'cart_empty_page_template' );

    $display_layout = $get_cart_empty_page_template;

              return $display_layout;
}


function bodycommerce_include_woo_templates() {
      $product_layout = false;

      get_header('shop');

      if (is_single()) {
          $product_layout = bodycommerce_single_layout();
          $entry_summary = '<div class="product ' . ( get_post_type() == 'product' ? 'post-' . get_the_ID() : '' ) . '">
                          <div class="entry-summary">';
      } else if (is_archive()) {
          $product_layout = bodycommerce_archive_layout();
          $entry_summary = '<div class="archive-bc-page">
                          <div class="entry-summary">';
      } else if (is_wc_endpoint_url( 'order-received' )) {
          $product_layout = bodycommerce_thankyou_layout();
          $entry_summary = '<div class="thankyou-bc-page">
                          <div class="entry-summary">';
      }
      else if ( is_cart() && is_checkout() && 0 == WC()->cart->get_cart_contents_count() && ! is_wc_endpoint_url( 'order-pay' ) && ! is_wc_endpoint_url( 'order-received' ) ) {
          $product_layout = bodycommerce_blank_cart_layout();
          $entry_summary = '<div class="cart-checkout-bc-page">
                          <div class="entry-summary">';
      }


      if ($product_layout) {

        global $shortcode_tags, $post;

        $section = do_shortcode('[et_pb_section global_module="' . $product_layout . '"][/et_pb_section]');

        // $section = apply_filters('the_content', get_post_field('post_content', $product_layout));

  			$layout_display = $section;

      }


      $theme = wp_get_theme();
      $parent = $theme->parent();

      if ($parent == "") {
      $theme_name = $theme;
      } else {
      $theme_name = $parent;
    }


$layout_display_dis = '<div id="main-content" class="bodycommerce_main_content">';
$layout_display_dis .= '<div id="et-boc" class="et-boc">';
$layout_display_dis .= '<div class="et-l et-l--body">';
  $layout_display_dis .= $entry_summary;

    if ( stristr( $layout_display, 'woocommerce-message' ) === false ) {
      wc_print_notices();
    }
  $layout_display_dis .= $layout_display;
  $layout_display_dis .= '</div></div></div></div></div>';




          echo apply_filters( 'bodycommerce_include_woo_templates', $layout_display_dis ); // phpcs:ignore
      // do_action( 'woocommerce_after_shop_loop' );
      get_footer('shop');
  }







function db_woo_remove_reviews($tabs)
{
    unset($tabs['reviews']);
    return $tabs;
}

////--------------------------------------------------------------------------

///---------------------------------------------------




add_action( 'init', function() {
  ps_register_shortcode_ajax( 'ajax_filter_get_posts', 'ajax_filter_get_posts' );
} );

function ps_register_shortcode_ajax( $callable, $action ) {

  if ( empty( $_POST['action'] ) || $_POST['action'] != $action )
    return;

  call_user_func( $callable );
}




add_action( 'bodycommerce_checkoutbilling', 'bodycommerce_checkoutbilling' );
function bodycommerce_checkoutbilling() {
global $woocommerce;
do_action( 'woocommerce_checkout_before_customer_details' );
do_action( 'woocommerce_checkout_billing' );
}


add_action( 'bodycommerce_checkoutshipping', 'bodycommerce_checkoutshipping' );
function bodycommerce_checkoutshipping() {
	do_action( 'woocommerce_before_checkout_shipping_form' );
	do_action( 'woocommerce_checkout_shipping' );
  do_action( 'woocommerce_checkout_after_customer_details' );
}


add_action( 'bodycommerce_checkoutorder', 'bodycommerce_checkoutorder' );
function bodycommerce_checkoutorder() {

?>
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				<?php
				include('titan-framework/titan-framework-embedder.php');
			  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
			  $check_other_settings_step_order_title = $titan->getOption( 'other_settings_step_order_title' );

				if ( isset($check_other_settings_step_order_title) ) {
					$check_other_settings_step_order_title = $check_other_settings_step_order_title;
				}
				else{
					$check_other_settings_step_order_title = "Your order";
				}
				 ?>

<h3 id="order_review_heading"><?php echo $check_other_settings_step_order_title ?></h3>

<div class="coupan_form">

 <?php do_action( 'bodycommerce_checkout_order_review' ); ?>

</div>



<input type="checkbox" name="payment_method" value="" data-order_button_text="" style="display: none;" />
<?php

}

// GET ACCENT COLOR
if ( ! function_exists( 'et_builder_accent_color_bodycommerce' ) ) :
function et_builder_accent_color_bodycommerce( $default_color = '#7EBEC5' ) {
	$accent_color = ! et_is_builder_plugin_active() ? et_get_option( 'accent_color', $default_color ) : $default_color;

	return apply_filters( 'et_builder_accent_color_bodycommerce', $accent_color );
}
endif;

/***** Add woocommerce class to body ****/

function bodycommerce_add_woocommerce_class( $classes ) {
  include('titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $settings_remove_woo_class = $titan->getOption( 'settings_remove_woo_class' );
  if (is_array($settings_remove_woo_class)) {
	$settings_remove_woo_class_arr = explode(",",$settings_remove_woo_class);

	if ( is_page( $settings_remove_woo_class_arr ) ) {
	} else {
    $classes[] = 'woocommerce';
    return $classes;
}
} else {
  $classes[] = 'woocommerce';
  return $classes;
}

}
add_filter( 'body_class','bodycommerce_add_woocommerce_class', 9999999);


/***** Custom register validation ******/

function bodycommerce_register_validate_extra_fields( $username, $email, $validation_errors ) {

      if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
              $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
       }
       if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
              $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
       }
         return $validation_errors;
}

add_action( 'woocommerce_register_post', 'bodycommerce_register_validate_extra_fields', 10, 3 );

/***** ADD CUSTOM REGISTER TO DATABASE ****/

function bodycommerce_register_save_extra_fields($customer_id) {
    //First name field
    if (isset($_POST['billing_first_name'])) {
        update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    }
    //Last name field
    if (isset($_POST['billing_last_name'])) {
        update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
    }
    //Phone field
    if (isset($_POST['billing_phone'])) {
        update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
}

add_action('woocommerce_created_customer', 'bodycommerce_register_save_extra_fields');


/* REMOVE PAYMENT BELOW ON RIGHT CHECKOUT */
$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (isset($mydata['checkout_page_style'][0])) {

if ($mydata['checkout_page_style'] == "payment-right") {

add_action( 'after_setup_theme', 'remove_payment_action_riught_chgeckout', 0 );
function remove_payment_action_riught_chgeckout() {
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
	add_action( 'woocommerce_checkout_after_order_review', 'woocommerce_checkout_payment', 20 );
}
}

}


// add_action ('', 'bodycommerce_before_right_checkout');






// function wc_billing_field_strings( $translated_text, $text, $domain ) {
//
// 	$mydata = get_option( 'divi-bodyshop-woo_options' );
// 	$mydata = unserialize($mydata);
//
// 	if (!isset($mydata['other_settings_step_billing_title'])) {
// 		$check_other_settings_step_billing_title = "Billing details";
// 			}	else {
// 		$check_other_settings_step_billing_title = $mydata['other_settings_step_billing_title'];
// 				}
//
//
// 		if (!isset($mydata['other_settings_step_different_address_title'])) {
// 		$check_other_settings_step_different_address_title = "Deliver to a different address?";
// 	 } else {
// 	 	$check_other_settings_step_different_address_title = $mydata['other_settings_step_different_address_title'];
// 	 }
//
//
// if (!isset($mydata['other_settings_step_order_title'])) {
// $check_other_settings_step_order_title = "Your order";
// }
// else {
// 	$check_other_settings_step_order_title = $mydata['other_settings_step_order_title'];
// }
//
//     switch ( $translated_text ) {
//
// 	        case 'Billing details' :
//             $translated_text = __( $check_other_settings_step_billing_title, 'woocommerce' );
//             break;
//
// 			  case 'Deliver to a different address?' :
// 		        $translated_text = __( $check_other_settings_step_different_address_title, 'woocommerce' );
// 		        break;
//
// 			  case 'Your order' :
// 		        $translated_text = __( $check_other_settings_step_order_title, 'woocommerce' );
// 		        break;
//     }
//     return $translated_text;
// }
// add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );


// ADD SKU TO SEARCH
function bodycommerce_product_search_join( $join, $query ) {
    if ( ! $query->is_main_query() || is_admin() || ! is_search() || ! is_woocommerce() ) {
        return $join;
    }
    global $wpdb;
    $join .= " LEFT JOIN {$wpdb->postmeta} iconic_post_meta ON {$wpdb->posts}.ID = iconic_post_meta.post_id ";
    return $join;
}
add_filter( 'posts_join', 'bodycommerce_product_search_join', 10, 2 );

function bodycommerce_product_search_where( $where, $query ) {
    if ( ! $query->is_main_query() || is_admin() || ! is_search() || ! is_woocommerce() ) {
        return $where;
    }
    global $wpdb;
    $where = preg_replace(
        "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
        "({$wpdb->posts}.post_title LIKE $1) OR (iconic_post_meta.meta_key = '_sku' AND iconic_post_meta.meta_value LIKE $1)", $where );
    return $where;
}
add_filter( 'posts_where', 'bodycommerce_product_search_where', 10, 2 );



function my_woocommerce_widget_shopping_cart_button_view_cart() {
  include('titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

  $minicart_place_basket_with_continue = $titan->getOption( 'minicart_place_basket_with_continue' );

  $mini_cart_view_btn_text_get = $titan->getOption( 'mini_cart_view_btn_text' );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'View Basket Button Text Mini Cart', $mini_cart_view_btn_text_get );
  $mini_cart_view_btn_text = apply_filters( 'wpml_translate_single_string', $mini_cart_view_btn_text_get, 'divi-bodyshop-woocommerce', 'View Basket Button Text Mini Cart' );


if ($minicart_place_basket_with_continue == "1") {
  $atc_pupup_continue_shopping_btn_text_get= $titan->getOption( 'atc_pupup_continue_shopping_btn_text' );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Continue Shopping Button Text for Pop Up', $atc_pupup_continue_shopping_btn_text_get );
  $atc_pupup_continue_shopping_btn_text = apply_filters( 'wpml_translate_single_string', $atc_pupup_continue_shopping_btn_text_get, 'divi-bodyshop-woocommerce', 'Continue Shopping Button Text for Pop Up' );
  $atc_pupup_continue_shopping_btn_url_get= $titan->getOption( 'atc_pupup_continue_shopping_btn_url' );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Continue Shopping Button URL for Pop Up', $atc_pupup_continue_shopping_btn_url_get );
  $atc_pupup_continue_shopping_btn_url = apply_filters( 'wpml_translate_single_string', $atc_pupup_continue_shopping_btn_url_get, 'divi-bodyshop-woocommerce', 'Continue Shopping Button URL for Pop Up' );
  if ($atc_pupup_continue_shopping_btn_url == "#" || $atc_pupup_continue_shopping_btn_url == "") {
    $preventdefault_css = "preventdefault";
  } else {
    $preventdefault_css = "";
  }

?>
<a onclick="location.href='<?php _e($atc_pupup_continue_shopping_btn_url,'divi_bodycommerce'); ?>'" data-url="<?php _e($atc_pupup_continue_shopping_btn_url,'divi_bodycommerce'); ?>" class="cart-link-span et_pb_button button continueshoppingminicart preventdefault"><?php _e($atc_pupup_continue_shopping_btn_text,'divi_bodycommerce'); ?></a>
<script>
jQuery(document).ready(function( $ ) {
$(document).on('click', '.continueshoppingminicart', function (e) {
  e.preventDefault();
  $("#bodycommerce_added_to_cart_popup").removeClass("active");
  $(".bodycommerce-minicart").removeClass('active-always');
  $(".bodycommerce-minicart").removeClass('active');
  $("body").removeClass('minicart-active');
  console.log('continue shopping');
  $("body").removeClass('slidein-minicart-active');
  $(".CartClick").removeClass('active-always');
  $(".CartClick").fadeOut();
});
});
</script>
<?php
} else {
  	echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="et_pb_button button wc-forward">' . esc_html__( $mini_cart_view_btn_text, 'woocommerce' ) . '</a>';
}


}


function my_woocommerce_widget_shopping_cart_proceed_to_checkout() {

  include('titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $mini_cart_checkout_btn_text_get = $titan->getOption( 'mini_cart_checkout_btn_text' );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Checkout Button Text Mini Cart', $mini_cart_checkout_btn_text_get );
  $mini_cart_checkout_btn_text = apply_filters( 'wpml_translate_single_string', $mini_cart_checkout_btn_text_get, 'divi-bodyshop-woocommerce', 'Checkout Button Text Mini Cart' );


echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="et_pb_button button checkout wc-forward">' . esc_html__( $mini_cart_checkout_btn_text, 'woocommerce' ) . '</a>';
}
add_action( 'bodycommerce_minicart_button_text', 'my_woocommerce_widget_shopping_cart_button_view_cart', 10 );
add_action( 'bodycommerce_minicart_button_text', 'my_woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );






	// get post id for vb
function bodycommerce_post_id_vb(){

	if( isset( $_REQUEST['et_post_id'] ) ){
		$post_id = absint( $_REQUEST['et_post_id'] );
	}elseif( isset( $_REQUEST['current_page']['id'] ) ){
		$post_id = absint( $_REQUEST['current_page']['id'] );
	}else{
		$post_id = false;
	}
	return $post_id;
}



// fix dynamic html not rendering on the site when using shop manager role
function bodycommerce_manager_cap() {
    $role = get_role( 'shop_manager' );
    if( '' != $role ) {
      $role->add_cap( 'unfiltered_html' );
    }
}
add_action( 'admin_init', 'bodycommerce_manager_cap');




add_filter( 'et_pb_menu_module_cart_output', 'my_fancy_filter_function', 9999999 );

function my_fancy_filter_function( ) {
	if ( ! class_exists( 'woocommerce' ) || ! WC()->cart ) {
		return '';
	}
	$output = '<div class="bc_menu_cart">';
	$output .= do_shortcode( '[bodycommerce_cart_icon]' );
	$output .= '</div>';

	return $output;
}

// Limit Excerpt Length by number of Words
function bc_shorten_excerpt( $limit, $ending, $ending_url ) {
$excerpt = explode(' ', get_the_excerpt(), $limit);
if (count($excerpt)>=$limit) {
array_pop($excerpt);

if ($ending_url == '') {
$excerpt = implode(" ",$excerpt). ' ' .$ending;
} else {
$excerpt = implode(" ",$excerpt). ' <a href="'.$ending_url.'">'.$ending.'</a>';
}

} else {
$excerpt = implode(" ",$excerpt);
}
$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
return $excerpt;
}




// function divi_child_theme_setup() {
//     if ( ! class_exists('ET_Builder_Module') ) {
//         return;
//     }
//
//     if(is_admin()) {
//       return;
//     }
//
//     $post_id = get_the_id();
//     echo $post_id;
//
//     // if ( et_builder_bfb_enabled() || et_core_is_fb_enabled() || !et_pb_is_pagebuilder_used( $post_id ) ) {
//     //   return;
//     // }
//     $content = get_the_content( false, false, $post_id );
//     // Find all registered tag names in $content.
//     // preg_match_all( '@\[et_pb_db_([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
//     preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
//     // Only need unique tag names
//     $unique_matches = array_unique( $matches[1] );
//     echo '<pre>' . print_r( $unique_matches, true ) . '</pre>';
//
//     remove_shortcode( 'et_pb_db_images' );
//
// }
//
// add_action( 'wp', 'divi_child_theme_setup', 9999 );


// global $DE_DB_WOO;
// $DE_DB_WOO = new DE_DB_WOO()
?>
