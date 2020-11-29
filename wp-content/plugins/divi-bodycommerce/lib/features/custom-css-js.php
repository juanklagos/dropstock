<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function divi_bodycommerce_custom_css_js() {
include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

  $bodycommerce_custom_css = $titan->getOption( 'bodycommerce_custom_css' );
  $bodycommerce_custom_js = $titan->getOption( 'bodycommerce_custom_js' );

// CUSTOM CSS
  if ($bodycommerce_custom_css != "") {
    function divi_bodycommerce_custom_css_head()  {
      include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
      $bodycommerce_custom_css = $titan->getOption( 'bodycommerce_custom_css' );
      $bodycommerce_custom_css_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $bodycommerce_custom_css );
      ?>
<style id="bodycommerce-custom-css-code"><?php echo $bodycommerce_custom_css_min ?></style>
      <?php
    }
    add_action( 'wp_head', 'divi_bodycommerce_custom_css_head' );
  }

  // CUSTOM JS
    if ($bodycommerce_custom_js != "") {
      function divi_bodycommerce_custom_js_footer()  {
        include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
        $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
        $bodycommerce_custom_js = $titan->getOption( 'bodycommerce_custom_js' );
        ?>
<?php echo $bodycommerce_custom_js ?>
        <?php
      }
      add_action( 'wp_footer', 'divi_bodycommerce_custom_js_footer' );
    }

}
add_action( 'tf_create_options', 'divi_bodycommerce_custom_css_js' );
?>
