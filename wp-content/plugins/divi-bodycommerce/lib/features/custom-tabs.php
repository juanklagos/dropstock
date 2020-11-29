<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab_bodycommerce' );
function woo_new_product_tab_bodycommerce( $tabs ) {


    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

$get_product_custom_tab_1 = $titan->getOption( 'product_custom_tab_1', get_the_ID()  );
$get_product_custom_tab_2 = $titan->getOption( 'product_custom_tab_2', get_the_ID()  );
$get_product_custom_tab_3 = $titan->getOption( 'product_custom_tab_3', get_the_ID()  );
$get_product_custom_tab_4 = $titan->getOption( 'product_custom_tab_4', get_the_ID()  );
$get_product_custom_tab_5 = $titan->getOption( 'product_custom_tab_5', get_the_ID()  );
$get_product_custom_tab_6 = $titan->getOption( 'product_custom_tab_6', get_the_ID()  );
$get_product_custom_tab_7 = $titan->getOption( 'product_custom_tab_7', get_the_ID()  );
$get_product_custom_tab_8 = $titan->getOption( 'product_custom_tab_8', get_the_ID()  );
$get_product_custom_tab_9 = $titan->getOption( 'product_custom_tab_9', get_the_ID()  );
$get_product_custom_tab_10 = $titan->getOption( 'product_custom_tab_10', get_the_ID()  );
$get_product_custom_tab_11 = $titan->getOption( 'product_custom_tab_11', get_the_ID()  );
$get_product_custom_tab_12 = $titan->getOption( 'product_custom_tab_12', get_the_ID()  );
$get_product_custom_tab_13 = $titan->getOption( 'product_custom_tab_13', get_the_ID()  );
$get_product_custom_tab_14 = $titan->getOption( 'product_custom_tab_14', get_the_ID()  );
$get_product_custom_tab_15 = $titan->getOption( 'product_custom_tab_15', get_the_ID()  );
$get_product_custom_tab_16 = $titan->getOption( 'product_custom_tab_16', get_the_ID()  );
$get_product_custom_tab_17 = $titan->getOption( 'product_custom_tab_17', get_the_ID()  );
$get_product_custom_tab_18 = $titan->getOption( 'product_custom_tab_18', get_the_ID()  );
$get_product_custom_tab_19 = $titan->getOption( 'product_custom_tab_19', get_the_ID()  );
$get_product_custom_tab_20 = $titan->getOption( 'product_custom_tab_20', get_the_ID()  );

if ( ! empty( $get_product_custom_tab_1 )){

	$tabs['bc_custom_tab_1'] = array(
		'title' 	=> __( $get_product_custom_tab_1, 'woocommerce' ),
		'priority' 	=> 25,
		'callback' 	=> 'bc_custom_tab_1_callback'
	);

}

if ( ! empty( $get_product_custom_tab_2 )){

	$tabs['bc_custom_tab_2'] = array(
		'title' 	=> __( $get_product_custom_tab_2, 'woocommerce' ),
		'priority' 	=> 26,
		'callback' 	=> 'bc_custom_tab_2_callback'
	);

}

if ( ! empty( $get_product_custom_tab_3 )){

	$tabs['bc_custom_tab_3'] = array(
		'title' 	=> __( $get_product_custom_tab_3, 'woocommerce' ),
		'priority' 	=> 27,
		'callback' 	=> 'bc_custom_tab_3_callback'
	);

}

if ( ! empty( $get_product_custom_tab_4 )){

	$tabs['bc_custom_tab_4'] = array(
		'title' 	=> __( $get_product_custom_tab_4, 'woocommerce' ),
		'priority' 	=> 28,
		'callback' 	=> 'bc_custom_tab_4_callback'
	);

}

if ( ! empty( $get_product_custom_tab_5 )){

	$tabs['bc_custom_tab_5'] = array(
		'title' 	=> __( $get_product_custom_tab_5, 'woocommerce' ),
		'priority' 	=> 29,
		'callback' 	=> 'bc_custom_tab_5_callback'
	);

}

if ( ! empty( $get_product_custom_tab_6 )){

	$tabs['bc_custom_tab_6'] = array(
		'title' 	=> __( $get_product_custom_tab_6, 'woocommerce' ),
		'priority' 	=> 30,
		'callback' 	=> 'bc_custom_tab_6_callback'
	);

}

if ( ! empty( $get_product_custom_tab_7 )){

	$tabs['bc_custom_tab_7'] = array(
		'title' 	=> __( $get_product_custom_tab_7, 'woocommerce' ),
		'priority' 	=> 31,
		'callback' 	=> 'bc_custom_tab_7_callback'
	);

}

if ( ! empty( $get_product_custom_tab_8 )){

	$tabs['bc_custom_tab_8'] = array(
		'title' 	=> __( $get_product_custom_tab_8, 'woocommerce' ),
		'priority' 	=> 32,
		'callback' 	=> 'bc_custom_tab_8_callback'
	);

}

if ( ! empty( $get_product_custom_tab_9 )){

	$tabs['bc_custom_tab_9'] = array(
		'title' 	=> __( $get_product_custom_tab_9, 'woocommerce' ),
		'priority' 	=> 33,
		'callback' 	=> 'bc_custom_tab_9_callback'
	);

}

if ( ! empty( $get_product_custom_tab_10 )){

	$tabs['bc_custom_tab_10'] = array(
		'title' 	=> __( $get_product_custom_tab_10, 'woocommerce' ),
		'priority' 	=> 34,
		'callback' 	=> 'bc_custom_tab_10_callback'
	);

}

if ( ! empty( $get_product_custom_tab_11 )){

	$tabs['bc_custom_tab_11'] = array(
		'title' 	=> __( $get_product_custom_tab_11, 'woocommerce' ),
		'priority' 	=> 35,
		'callback' 	=> 'bc_custom_tab_11_callback'
	);

}

if ( ! empty( $get_product_custom_tab_12 )){

	$tabs['bc_custom_tab_12'] = array(
		'title' 	=> __( $get_product_custom_tab_12, 'woocommerce' ),
		'priority' 	=> 36,
		'callback' 	=> 'bc_custom_tab_12_callback'
	);

}

if ( ! empty( $get_product_custom_tab_13 )){

	$tabs['bc_custom_tab_13'] = array(
		'title' 	=> __( $get_product_custom_tab_13, 'woocommerce' ),
		'priority' 	=> 37,
		'callback' 	=> 'bc_custom_tab_13_callback'
	);

}

if ( ! empty( $get_product_custom_tab_14 )){

	$tabs['bc_custom_tab_14'] = array(
		'title' 	=> __( $get_product_custom_tab_14, 'woocommerce' ),
		'priority' 	=> 38,
		'callback' 	=> 'bc_custom_tab_14_callback'
	);

}

if ( ! empty( $get_product_custom_tab_15 )){

	$tabs['bc_custom_tab_15'] = array(
		'title' 	=> __( $get_product_custom_tab_15, 'woocommerce' ),
		'priority' 	=> 39,
		'callback' 	=> 'bc_custom_tab_15_callback'
	);

}

if ( ! empty( $get_product_custom_tab_16 )){

	$tabs['bc_custom_tab_16'] = array(
		'title' 	=> __( $get_product_custom_tab_16, 'woocommerce' ),
		'priority' 	=> 39,
		'callback' 	=> 'bc_custom_tab_16_callback'
	);

}

if ( ! empty( $get_product_custom_tab_17 )){

	$tabs['bc_custom_tab_17'] = array(
		'title' 	=> __( $get_product_custom_tab_17, 'woocommerce' ),
		'priority' 	=> 39,
		'callback' 	=> 'bc_custom_tab_17_callback'
	);

}

if ( ! empty( $get_product_custom_tab_18 )){

	$tabs['bc_custom_tab_18'] = array(
		'title' 	=> __( $get_product_custom_tab_18, 'woocommerce' ),
		'priority' 	=> 39,
		'callback' 	=> 'bc_custom_tab_18_callback'
	);

}

if ( ! empty( $get_product_custom_tab_19 )){

	$tabs['bc_custom_tab_19'] = array(
		'title' 	=> __( $get_product_custom_tab_19, 'woocommerce' ),
		'priority' 	=> 39,
		'callback' 	=> 'bc_custom_tab_19_callback'
	);

}

if ( ! empty( $get_product_custom_tab_20 )){

	$tabs['bc_custom_tab_20'] = array(
		'title' 	=> __( $get_product_custom_tab_20, 'woocommerce' ),
		'priority' 	=> 39,
		'callback' 	=> 'bc_custom_tab_20_callback'
	);

}

return $tabs;


}
function bc_custom_tab_1_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_1_content_layout = $titan->getOption( 'product_custom_tab_1_content_layout', get_the_ID()  );
	$get_product_custom_tab_1_content = $titan->getOption( 'product_custom_tab_1_content', get_the_ID()  );


	// $get_product_custom_tab_1_content_clean = str_replace('[db_woo_get_name]','do_shortcode( "[db_woo_get_name]" )',$get_product_custom_tab_1_content);

	if ( $get_product_custom_tab_1_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_1_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_1_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_2_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_2_content_layout = $titan->getOption( 'product_custom_tab_2_content_layout', get_the_ID()  );
	$get_product_custom_tab_2_content = $titan->getOption( 'product_custom_tab_2_content', get_the_ID()  );

	if ( $get_product_custom_tab_2_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_2_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_2_content_layout.'"][/et_pb_section]');
	}
}

function bc_custom_tab_3_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_3_content_layout = $titan->getOption( 'product_custom_tab_3_content_layout', get_the_ID()  );
	$get_product_custom_tab_3_content = $titan->getOption( 'product_custom_tab_3_content', get_the_ID()  );

	if ( $get_product_custom_tab_3_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_3_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_3_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_4_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_4_content_layout = $titan->getOption( 'product_custom_tab_4_content_layout', get_the_ID()  );
	$get_product_custom_tab_4_content = $titan->getOption( 'product_custom_tab_4_content', get_the_ID()  );

	if ( $get_product_custom_tab_4_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_4_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_4_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_5_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_5_content_layout = $titan->getOption( 'product_custom_tab_5_content_layout', get_the_ID()  );
	$get_product_custom_tab_5_content = $titan->getOption( 'product_custom_tab_5_content', get_the_ID()  );

	if ( $get_product_custom_tab_5_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_5_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_5_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_6_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_6_content_layout = $titan->getOption( 'product_custom_tab_6_content_layout', get_the_ID()  );
	$get_product_custom_tab_6_content = $titan->getOption( 'product_custom_tab_6_content', get_the_ID()  );

	if ( $get_product_custom_tab_6_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_6_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_6_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_7_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_7_content_layout = $titan->getOption( 'product_custom_tab_7_content_layout', get_the_ID()  );
	$get_product_custom_tab_7_content = $titan->getOption( 'product_custom_tab_7_content', get_the_ID()  );

	if ( $get_product_custom_tab_7_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_7_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_7_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_8_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_8_content_layout = $titan->getOption( 'product_custom_tab_8_content_layout', get_the_ID()  );
	$get_product_custom_tab_8_content = $titan->getOption( 'product_custom_tab_8_content', get_the_ID()  );

	if ( $get_product_custom_tab_8_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_8_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_8_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_9_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_9_content_layout = $titan->getOption( 'product_custom_tab_9_content_layout', get_the_ID()  );
	$get_product_custom_tab_9_content = $titan->getOption( 'product_custom_tab_9_content', get_the_ID()  );

	if ( $get_product_custom_tab_9_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_9_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_9_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_10_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_10_content_layout = $titan->getOption( 'product_custom_tab_10_content_layout', get_the_ID()  );
	$get_product_custom_tab_10_content = $titan->getOption( 'product_custom_tab_10_content', get_the_ID()  );

	if ( $get_product_custom_tab_10_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_10_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_10_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_11_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_11_content_layout = $titan->getOption( 'product_custom_tab_11_content_layout', get_the_ID()  );
	$get_product_custom_tab_11_content = $titan->getOption( 'product_custom_tab_11_content', get_the_ID()  );

	if ( $get_product_custom_tab_11_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_11_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_11_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_12_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_12_content_layout = $titan->getOption( 'product_custom_tab_12_content_layout', get_the_ID()  );
	$get_product_custom_tab_12_content = $titan->getOption( 'product_custom_tab_12_content', get_the_ID()  );

	if ( $get_product_custom_tab_12_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_12_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_12_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_13_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_13_content_layout = $titan->getOption( 'product_custom_tab_13_content_layout', get_the_ID()  );
	$get_product_custom_tab_13_content = $titan->getOption( 'product_custom_tab_13_content', get_the_ID()  );

	if ( $get_product_custom_tab_13_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_13_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_13_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_14_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_14_content_layout = $titan->getOption( 'product_custom_tab_14_content_layout', get_the_ID()  );
	$get_product_custom_tab_14_content = $titan->getOption( 'product_custom_tab_14_content', get_the_ID()  );

	if ( $get_product_custom_tab_14_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_14_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_14_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_15_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_15_content_layout = $titan->getOption( 'product_custom_tab_15_content_layout', get_the_ID()  );
	$get_product_custom_tab_15_content = $titan->getOption( 'product_custom_tab_15_content', get_the_ID()  );

	if ( $get_product_custom_tab_15_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_15_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_15_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_16_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_16_content_layout = $titan->getOption( 'product_custom_tab_16_content_layout', get_the_ID()  );
	$get_product_custom_tab_16_content = $titan->getOption( 'product_custom_tab_16_content', get_the_ID()  );

	if ( $get_product_custom_tab_16_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_16_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_16_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_17_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_17_content_layout = $titan->getOption( 'product_custom_tab_17_content_layout', get_the_ID()  );
	$get_product_custom_tab_17_content = $titan->getOption( 'product_custom_tab_17_content', get_the_ID()  );

	if ( $get_product_custom_tab_17_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_17_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_17_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_18_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_18_content_layout = $titan->getOption( 'product_custom_tab_18_content_layout', get_the_ID()  );
	$get_product_custom_tab_18_content = $titan->getOption( 'product_custom_tab_18_content', get_the_ID()  );

	if ( $get_product_custom_tab_18_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_18_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_18_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_19_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_19_content_layout = $titan->getOption( 'product_custom_tab_19_content_layout', get_the_ID()  );
	$get_product_custom_tab_19_content = $titan->getOption( 'product_custom_tab_19_content', get_the_ID()  );

	if ( $get_product_custom_tab_19_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_19_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_19_content_layout.'"][/et_pb_section]');
	}

}

function bc_custom_tab_20_callback() {
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

	$get_product_custom_tab_20_content_layout = $titan->getOption( 'product_custom_tab_20_content_layout', get_the_ID()  );
	$get_product_custom_tab_20_content = $titan->getOption( 'product_custom_tab_20_content', get_the_ID()  );

	if ( $get_product_custom_tab_20_content_layout == "") {
		echo do_shortcode( $get_product_custom_tab_20_content );
	}
	else {
		echo do_shortcode('[et_pb_section global_module="'.$get_product_custom_tab_20_content_layout.'"][/et_pb_section]');
	}

}


// RE-ORDER TABS
add_filter( 'woocommerce_product_tabs', 'bodycommerce_reorder_tabs', 98 );
function bodycommerce_reorder_tabs( $tabs ) {
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

  $product_tabs_order = $titan->getOption( 'product_tabs_reorder');

  if ( $product_tabs_order ) {
      $priority = 1;
      foreach ( $product_tabs_order as $value ) {
        if ( isset( $tabs[$value] ) ) {
          $tabs[$value]['priority'] = $priority;
        $priority += 1;
      }
      }
  }

    return $tabs;
}
 ?>
