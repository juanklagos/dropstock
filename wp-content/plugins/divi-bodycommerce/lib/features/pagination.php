<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'woocommerce_pagination' ) ) {
// REMOVE PAGINATION
remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
function woocommerce_pagination() {
		bodycommerce_pagination();
	}
add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10);

}

// CUSTOM PAGINATION
function bodycommerce_pagination() {

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $pagination_style = $titan->getOption( 'pagination_style');
  $pagination_nextprev_style = $titan->getOption( 'pagination_nextprev_style');
  $pagination_prev_text = $titan->getOption( 'pagination_prev_text');
  $pagination_next_text = $titan->getOption( 'pagination_next_text');

  $total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
  $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
  $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
  $format  = isset( $format ) ? $format : '';

  if ( $total <= 1 ) {
  	return;
  }

	if ( wc_get_loop_prop( 'is_shortcode' ) ) {
$format = '?product-page=%#%';
$base = esc_url_raw( add_query_arg( 'product-page', '%#%', false ) );
} else {
$format  = isset( $format ) ? $format : '';
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
}

  ?>
  <nav class="bodycommerce-pagination <?php echo $pagination_style ?> <?php echo $pagination_nextprev_style ?>">
  	<?php
echo paginate_links( apply_filters( 'woocommerce_pagination_args', array( // WPCS: XSS ok.
					'total'   => wc_get_loop_prop( 'total_pages' ),
					'current' => wc_get_loop_prop( 'current_page' ),
					'format'  => $format,
					'base'    => $base,
					'type'         => 'list',
					'end_size'     => 3,
					'mid_size'     => 3, // change how many between
					'prev_text'    => __($pagination_prev_text),
					'next_text'    => __($pagination_next_text),
				) ) );
				?>
  </nav>
  <?php
}


// CUSTOM PAGINATION CSS
add_action('wp_head','pagination_css');

function pagination_css() {

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $pagination_primary_color = $titan->getOption( 'pagination_primary_color');
  $pagination_primary_color_hover = $titan->getOption( 'pagination_primary_color_hover');
  $pagination_secondary_color = $titan->getOption( 'pagination_secondary_color');
  $quantity_text_color = $titan->getOption( 'quantity_text_color');
  $quantity_active_text_color = $titan->getOption( 'quantity_active_text_color');
  $pagination_arrow_color = $titan->getOption( 'pagination_arrow_color');
  $pagination_prev_icon = $titan->getOption( 'pagination_prev_icon');
  $pagination_next_icon = $titan->getOption( 'pagination_next_icon');

  $pagination_prev_icon_display = sprintf('content: "\%s";', $pagination_prev_icon);
  $pagination_next_icon_display = sprintf('content: "\%s";', $pagination_next_icon);

  $css_pagination =  sprintf('<style id="bodycommerce-custom-pagination">');

  $css_pagination .= '

  /* GENERAL */

  .bodycommerce-pagination {
  padding: 30px 0;
  text-align: center;
  }

  .bodycommerce-pagination ul {
  margin: 0;
  padding: 0;
  list-style-type: none;
  }

  .bodycommerce-pagination ul li{
        display: inline-block;
  }

  li .page-numbers {
  display: inline-block;
  padding: 10px 18px;
  color: '.$quantity_text_color.';
  -webkit-transition: all .4s;
  -moz-transition: all .4s;
  transition: all .4s
  }

  /* NEXT PREV */

  .arrows .prev:before, .arrows .next:before {
    text-shadow: 0 0;
    font-family: "ETmodules" !important;
    font-weight: normal;
    font-style: normal;
    font-variant: normal;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    line-height: 1;
    text-transform: none;
    speak: none;
    position: absolute;
    font-size: 17px;
    '.$pagination_prev_icon_display.'
    top: 50%;
    transform: translate(-50%, -50%);
    left: 50%;
    color: '.$pagination_arrow_color.'
  }


  .next {
    float: none !important;
  }

  .arrows .next:before {
    '.$pagination_next_icon_display.'
    }

  .arrows .prev, .arrows .next{
    font-size: 0;
      top: -6px;
      position: relative;
  }

  /* ONE */

  .p1 a{
    width: 40px;
    height: 40px;
    line-height: 40px;
    padding: 0;
    text-align: center;
  }

  .p1 li .page-numbers.current{
    background-color: '. $pagination_primary_color . ';
    border-radius: 100%;
    color: '.$quantity_active_text_color.';
  }

    .p1 li .page-numbers:hover{
      background-color: '. $pagination_primary_color_hover . ' !important;
      border-radius: 100%;
      color: '.$quantity_active_text_color.';
    }


  /* TWO */

  .p2 li .page-numbers.current{
    font-weight: bold;
    border-bottom: 3px solid '. $pagination_primary_color . ';
  }

  .p2 li .page-numbers:hover{
    border-bottom: 3px solid '. $pagination_primary_color_hover . ' !important;
  }

  /* THREE */

  .p3 li .page-numbers.current{
    background-color: '. $pagination_primary_color . ';
    color: '.$quantity_active_text_color.';
  }

  .p3 li .page-numbers:hover{
      background-color: '. $pagination_primary_color_hover . ';
      color: '.$quantity_active_text_color.';
  }

  /* FOUR */

  .p4 li{
    width: 40px;
    height: 40px;
    line-height: 40px;
    border-radius: 100%;
    padding: 0;
    text-align: center;
    position: relative;
    border: 3px solid '. $pagination_primary_color . ';
  }

  .p4 li .page-numbers {
    font-size: 0;
  }

  .p4 li:first-child, .p4 li:last-child {
    display: none;
  }

.p4 li .page-numbers:before{
  opacity: 0;
    content: "";
    width: 30px;
    height: 30px;
    border-radius: 100%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    -webkit-transition: all .4s;
    -moz-transition: all .4s;
    transition: all .4s
}

  .p4 li .page-numbers.current:before{
    opacity: 1;
    content: "";
    width: 30px;
    height: 30px;
    border-radius: 100%;
    background-color: '. $pagination_primary_color . ';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
  }

  .p4 li .page-numbers:hover::before{
    opacity: 1;
      background-color: '. $pagination_primary_color_hover . ';
  }

  /* FIVE */

  .p5 li .page-numbers{
    width: 30px;
    height: 5px;
    padding: 0;
    margin: auto 5px;
    background-color: ' .$pagination_secondary_color. ';
  }

  .p5 li .page-numbers.current{
    background-color: '. $pagination_primary_color . ';
    color: '.$quantity_active_text_color.';
  }

    .p5 li .page-numbers:hover {
      background-color: '. $pagination_primary_color_hover . ';
      color: '.$quantity_active_text_color.';
    }

  .p5 li .page-numbers {
    font-size: 0;
  }

  .p5 li:first-child, .p5 li:last-child {
    display: none;
  }

  /* SIX */

  .p6 li .page-numbers{
    width: 30px;
    height: 30px;
    border-radius: 100%;
    padding: 0;
    margin: auto 5px;
    text-align: center;
    position: relative;
    background-color: ' .$pagination_secondary_color. ';
  }

  .p6 li .page-numbers.current{
    background-color: '. $pagination_primary_color . ';
    color: '.$quantity_active_text_color.';
  }

  .p6 li .page-numbers:hover{
    background-color: '. $pagination_primary_color_hover . ' !important;
  }

  .p6 li .page-numbers {
    font-size: 0;
  }

  .p6 li:first-child, .p6 li:last-child {
    display: none;
  }

  /* SEVEN */

  .p7 li .page-numbers{
    border: 3px solid '. $pagination_primary_color . ';
    margin: auto 5px;
    color: '. $pagination_primary_color . ';
    font-weight: bold;
  }

  .p7 li .page-numbers.current{
    background-color: '. $pagination_primary_color . ';
    color: '.$quantity_active_text_color.';
  }

  .p7 li .page-numbers:hover {
    background-color: '. $pagination_primary_color_hover . ';
    color: '.$quantity_active_text_color.';
  }

  /* EIGHT */

  .p8 a{
    padding: 10px 18px;
    text-align: center;
    margin: auto 5px;
  }

  .p8 li .page-numbers {
  border-radius: 100%;
  }

  .p8 li .page-numbers.current{
    border: 3px solid '. $pagination_primary_color . ';
    border-radius: 100%;
    color: '.$quantity_active_text_color.';
  }

  .p8 li .page-numbers:hover {
          border: 3px solid '. $pagination_primary_color_hover . ';
          color: '.$quantity_active_text_color.';
      }

  /* NINE */

  .p9 a{
    padding: 10px 18px;
    text-align: center;
    margin: auto 5px;
  }

  .p9 li .page-numbers.current{
    border: 3px solid '. $pagination_primary_color . ';
    color: '.$quantity_active_text_color.';
  }

  .p9 li .page-numbers:hover {
          border: 3px solid '. $pagination_primary_color_hover . ';
          color: '.$quantity_active_text_color.';
      }

  /* TEN */

  .p10 li .page-numbers{
    background-color: '. $pagination_primary_color . ';
    margin: auto 5px;
    color: #fff;
    border: 3px solid '. $pagination_primary_color . ';
    position: relative;
  }

  .p10 li:first-of-type .page-numbers:before{
    content: "";
    position: absolute;
    left: -15px;
    border-top: 26px solid transparent;
    border-bottom: 26px solid transparent;
    border-right: 26px solid '. $pagination_primary_color . ';
  }

  .p10 li:last-of-type .page-numbers:after{
    content: "";
    position: absolute;
    top: -3px;
    right: -29px;
    border-top: 26px solid transparent;
    border-bottom: 26px solid transparent;
    border-left: 26px solid '. $pagination_primary_color . ';
  }

  .p10 li .page-numbers.current{
    font-weight: bold;
    background-color: transparent;
    color: inherit;
    color: '.$quantity_active_text_color.';
  }



  .p10 li .page-numbers:hover{
      font-weight: bold;
      background-color: transparent;
      color: inherit;
      color: '.$quantity_active_text_color.';
        border-color: '. $pagination_primary_color_hover . ' !important;
  }

  .p10.arrows .next:before {
    display: none;
  }

  .p10.arrows .prev, .p10.arrows .next {
    font-size: inherit !important;
    top: 0;
  }


  /* ELEVEN */

  .p11 li:first-of-type .page-numbers, .p11 li:last-of-type .page-numbers, .p11 li .page-numbers.current{
    background-color: '. $pagination_primary_color . ';
      font-weight: bold;
  }

    .p11 li .page-numbers.current{
  color: '.$quantity_active_text_color.';
}


    .p11 li .page-numbers:hover{
      background-color: '. $pagination_primary_color_hover . ';
      color: '.$quantity_active_text_color.';
      font-weight: bold;
}
  ';

  $css_pagination .= '</style>';
  //minify it
  $css_pagination_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_pagination );
  echo $css_pagination_min;
}

// CUSTOM PAGINATION JS
add_action('wp_footer','pagination_js');

function pagination_js() {
  ?>
<script>jQuery(document).ready(function( $ ) {$(document).on("click", 'li .page-numbers', function() {$("li .page-numbers").removeClass("current");$(this).addClass("current");});});</script>
<?php
}
?>
