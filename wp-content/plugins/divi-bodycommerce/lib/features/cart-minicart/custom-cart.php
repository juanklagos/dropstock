<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);

if (isset($mydata['enable_minicart'][0])) {
$check_enable_minicart = $mydata['enable_minicart'][0];
}
else {
  $check_enable_minicart = "0";
}

if (isset($mydata['enable_cart_custom_icon'][0])) {
$check_enable_cart_custom_icon = $mydata['enable_cart_custom_icon'][0];
}
else {
  $check_enable_cart_custom_icon = "0";
}


if ($check_enable_minicart == 1) {

///// WHEN NORMAL RELOAD //////
if ( ! function_exists( 'et_show_cart_total' ) ) {
function et_show_cart_total( $args = array() ) {
if ( ! is_admin() ) {
  ?><span class="shop-cart"><?php
  if ( ! class_exists( 'woocommerce' ) ) {
    return;
  }
  $defaults = array(
    'no_text' => false,
  );
  $args = wp_parse_args( $args, $defaults );
  if (is_object( WC()->cart ) ) {
  $items_number = WC()->cart->get_cart_contents_count();
} else {
  $items_number = "";
}


	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
	$minicart_remove_item_text = $titan->getOption( 'minicart_remove_item_text' );
$check_enable_cart_custom_icon = $titan->getOption( 'enable_cart_custom_icon');

$check_cart_custom_icon_enable_numbers = $titan->getOption( 'cart_custom_icon_enable_numbers' );

$cart_custom_icon_disable_empty_number = $titan->getOption( 'cart_custom_icon_disable_empty_number' );

$check_cart_custom_icon_enable_text_after_get = $titan->getOption( 'cart_custom_icon_enable_text_after' );
$check_cart_custom_icon_enable_text_after_plural_get = $titan->getOption( 'cart_custom_icon_enable_text_after_plural' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Cart Text After', $check_cart_custom_icon_enable_text_after_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Cart Text After Plural', $check_cart_custom_icon_enable_text_after_plural_get );
$check_cart_custom_icon_enable_text_after = apply_filters( 'wpml_translate_single_string', $check_cart_custom_icon_enable_text_after_get, 'divi-bodyshop-woocommerce', 'Cart Text After' );
$check_cart_custom_icon_enable_text_after_plural = apply_filters( 'wpml_translate_single_string', $check_cart_custom_icon_enable_text_after_plural_get, 'divi-bodyshop-woocommerce', 'Cart Text After Plural' );
$check_BodyCommerce_cart_icon = $titan->getOption( 'enable_cart_custom_icon_select' );

$atc_pupup_disable_mobile = $titan->getOption( 'atc_pupup_disable_mobile' );
if ($atc_pupup_disable_mobile == '1') {$atc_pupup_disable_mobile_name = 'disable_minicart_mobile';} else {$atc_pupup_disable_mobile_name = 'enable_minicart_mobile';}

    $minicart_activate = $titan->getOption( 'minicart_activate' );

    $custom_cart_icon_upload = $titan->getOption( 'custom_cart_icon_upload' );
      if ($custom_cart_icon_upload == "") {
      $path = '/lib/cart-icon-styles/'.$check_BodyCommerce_cart_icon.'.php';
    } else {
    $path = '/lib/cart-icon-styles/users-custom-cart.php';
    }


	if ($minicart_remove_item_text == 1){

if ($check_enable_cart_custom_icon == 1) {
  // CUSTOM CART ICON
  $getCartURL = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
  $cartCount = esc_html( sprintf(
    _nx( '%1$s '.$check_cart_custom_icon_enable_text_after.'', '%1$s '.$check_cart_custom_icon_enable_text_after_plural.'', $items_number, 'WooCommerce items number', 'divi-bodyshop-woocommerce' ),
    number_format_i18n( $items_number )
  ));

      ?>
      <?php if ($minicart_activate == 1) { ?>
      <span data-url="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-first">
      <?php } else { ?>
      <span data-url="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-first">
      <?php } ?>
      <div class="cart-icon <?php echo $atc_pupup_disable_mobile_name ?>"><?php include(DE_DB_WOO_PATH . $path); ?>

        <?php if ($check_cart_custom_icon_enable_numbers == 1){ ?>
          <?php
if(isset($cart_custom_icon_disable_empty_number)){
          if ($cart_custom_icon_disable_empty_number == 1 && $items_number == "0") {
          }
          else { ?>
        <div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
      <?php }
} else {
?>
<div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
<?php
}
      ?>
      <?php } else {
        # code...
      }
    ?>

      </div>
    </span>
      <?php
}
else {
    // NO CUSTOM CART ICON
    printf(
	    '<span data-url="%1$s" class="et-cart-info cart-link-span 2">
	      <span>%2$s</span>
	    </span>',
	    function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url(),
	    ( ! $args['no_text']
	      ? esc_html( sprintf(
	        _nx( '%1$s', '%1$s', $items_number, 'WooCommerce items number', 'divi-bodyshop-woocommerce' ),
	        number_format_i18n( $items_number )
	      ) )
	      : ''
	    )
	  );
}

	}
	else {

    if ($check_enable_cart_custom_icon == 1) {
      // CUSTOM CART ICON
      $getCartURL = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
      $cartCount = esc_html( sprintf(
        _nx( '%1$s '.$check_cart_custom_icon_enable_text_after.'', '%1$s '.$check_cart_custom_icon_enable_text_after_plural.'', $items_number, 'WooCommerce items number', 'divi-bodyshop-woocommerce' ),
        number_format_i18n( $items_number )
      ));

          ?>
          <?php if ($minicart_activate == 1) { ?>
          <span data-url="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-second">
          <?php } else { ?>
          <span data-url="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-second">
          <?php } ?>
          <div class="cart-icon <?php echo $atc_pupup_disable_mobile_name ?>"><?php include(DE_DB_WOO_PATH . $path); ?>

            <?php if ($check_cart_custom_icon_enable_numbers == 1){ ?>
              <?php
  if(isset($cart_custom_icon_disable_empty_number)){
              if ($cart_custom_icon_disable_empty_number == 1 && $items_number == "0") {
              }
              else { ?>
            <div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
          <?php }
  } else {
    ?>
  <div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
  <?php
  }
          ?>
          <?php } else {
            # code...
          }
        ?>

          </div>
        </span>
          <?php
    }
    else {
        // NO CUSTOM CART ICON
        printf(
    	    '<span data-url="%1$s" class="et-cart-info cart-link-span 4">
    	      <span>%2$s</span>
    	    </span>',
    	    function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url(),
    	    ( ! $args['no_text']
    	      ? esc_html( sprintf(
    	        _nx( '%1$s', '%1$s', $items_number, 'WooCommerce items number', 'divi-bodyshop-woocommerce' ),
    	        number_format_i18n( $items_number )
    	      ) )
    	      : ''
    	    )
    	  );
    }

	}


  global $woocommerce;

  $mydata = get_option( 'divi-bodyshop-woo_options' );
  $mydata = unserialize($mydata);

  $check_minicart_remove_option = $mydata['minicart_remove_option'][0] ?: "";
  $minicart_remove_option_text_get = $mydata['minicart_remove_option_text'] ?: "";

  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Mini Cart Remove Text', $minicart_remove_option_text_get );
  $minicart_remove_option_text = apply_filters( 'wpml_translate_single_string', $minicart_remove_option_text_get, 'divi-bodyshop-woocommerce', 'Mini Cart Remove Text' );

  $mini_cart_style = $mydata['mini_cart_style'] ?: "";



  if ($check_minicart_remove_option == "1") {
    $check_minicart_remove_option_display = $minicart_remove_option_text;
    $check_minicart_remove_option_display_css = "";
  }
  else {
    $check_minicart_remove_option_display = "&times;";
    $check_minicart_remove_option_display_css = "remove";
  }


  ?>

  <?php if ($mini_cart_style == "slide-in") {
  ?><div class="CartClick overlay"></div><?php
} else { }?>

 <div class="bodycommerce-minicart one">
   <?php if ($mini_cart_style == "slide-in") {
     echo do_shortcode("[bodycommerce_slide_in_mini_cart]");
    } else {
      echo do_shortcode("[bodycommerce_default_mini_cart]");
     } ?>
</div>

<?php
$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);

$enable_minicart2 = $mydata['enable_minicart'] ?: "";
$check_auto_show_minicart = $mydata['auto_show_minicart'] ?: "";
$check_auto_show_minicart_delay = $mydata['auto_show_minicart_delay'] ?: "3";
$close_auto_show = $mydata['close_auto_show'] ?: "1";
if (isset($close_auto_show) && $close_auto_show == '1') {
$check_auto_show_minicart_close_time = $mydata['auto_show_minicart_close_time'] ?: "6";
} else {
$check_auto_show_minicart_close_time = '9999';
}
$minicart_hover_delay_time = $mydata['minicart_hover_delay_time'] ?: "";
if ($minicart_hover_delay_time == "") {
  $minicart_hover_delay_time = "800";
}

$minicart_activate = $mydata['minicart_activate'][0];
$atc_pupup_disable_mobile = $mydata['atc_pupup_disable_mobile'] ?: "";

if ($enable_minicart2 == 1) {

	if ($minicart_activate == 1) {
    $cart_link = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
		?>
		<script>
		jQuery(document).ready(function($){


      $(".et-cart-info").click(function(event) {

        <?php
        if ($atc_pupup_disable_mobile == "1") {
        ?>
        if ($(window).width() < 767) {
        var cart_url = $(this).attr('data-url');
        window.location.href = cart_url;
        console.log('done 1');
        }
        else {
        }
        <?php
        }
        ?>

        <?php if ($mini_cart_style == "drop-down-icon") {
          ?>
          if ($(window).width() < 767) {
            <?php
            if ($atc_pupup_disable_mobile == "1") {
            ?>
            location.href='<?php echo esc_url( $cart_link ); ?>'
            <?php
          } else {
            ?>
            event.preventDefault();
            $(".bodycommerce-minicart").toggleClass('active');
            $(".CartClick").fadeIn();
            console.log('slide 1');
            $("body").toggleClass('slidein-minicart-active');
            <?php
          }
            ?>
          }
          else {
          event.preventDefault();
          // $(".bodycommerce-minicart").toggleClass('active');
          $(".bodycommerce-minicart").toggleClass('active');
          $(".CartClick").fadeIn();
          console.log('slide 2');
          $("body").toggleClass('slidein-minicart-active');
          }
          <?php
        } else {
          ?>
          event.preventDefault();
          // $(".bodycommerce-minicart").toggleClass('active');
          $(".bodycommerce-minicart").addClass('active');
          $(".CartClick").fadeIn();
          console.log('slide 3');
          $("body").addClass('slidein-minicart-active');
          <?php
        }
        ?>
			      });
            $(".CartClick").click(function(event) {
                   event.preventDefault();
              if (!$(this).hasClass("active-always")) {
                     // $(".bodycommerce-minicart").toggleClass('active');
                     $(".bodycommerce-minicart").removeClass('active');
                     console.log('slide 4');
                     $("body").removeClass('slidein-minicart-active');
                     $(".CartClick").fadeOut();
                     }
                  });
                    $(document).on('touchstart click', ".close" , function(event){
                           event.preventDefault();
                             $(".bodycommerce-minicart").removeClass('active-always');
                             $(".bodycommerce-minicart").removeClass('active');
                             console.log('slide 5');
                                $("body").removeClass('slidein-minicart-active');
                                $(".CartClick").removeClass('active-always');
                                $(".CartClick").fadeOut();
                        });
						<?php
						if ($check_auto_show_minicart == 1) { ?>
						var showdelay = <?php echo $check_auto_show_minicart_delay ?>;
						<?php if ($check_auto_show_minicart_close_time == "") {} else {?>
              var closedelay = <?php echo $check_auto_show_minicart_close_time ?>;
              var closedelaytime=closedelay*1000;
               <?php } ?>
               var section = 4;
						var showdelaytime=showdelay*1000;
	$(".ajax_add_to_cart").click(function(){
							setTimeout(function(){
								$(".bodycommerce-minicart").addClass('active-always');
                console.log('slide 6');
                $("body").addClass('slidein-minicart-active');
  							$(".CartClick").addClass('active-always');},showdelaytime);
                <?php if ($check_auto_show_minicart_close_time == "") { } else { ?>
                  setTimeout(function(){
                  $(".bodycommerce-minicart").removeClass('active-always');
                  console.log('slide 7');
                  $("body").removeClass('slidein-minicart-active');
                  $(".CartClick").removeClass('active-always');
                },closedelaytime);
                <?php } ?>
							});

              <?php if ($check_auto_show_minicart_close_time == "") { ?>
                          $(".CartClick").click(function(event) {
                                   event.preventDefault();
                                          $(".bodycommerce-minicart").removeClass('active-always');
                                          $(".CartClick").fadeOut();
                                });
                                  $(document).on('touchstart click', ".close" , function(event){
                                         event.preventDefault();
                                              $(".bodycommerce-minicart").removeClass('active-always');
                                              $(".CartClick").fadeOut();
                                      });
                  <?php } else { }?>

								<?php } ?>
			});
			</script>
      </span>
<?php
	}
	else {
?>
<script>
if (typeof jQuery == 'undefined') {} else {
    jQuery(document).ready(function($) {

        $(document).on('touchstart click', ".close" , function(event){
               event.preventDefault();
          if (!$(".bodycommerce-minicart").hasClass("active-always")) {
               // $(".bodycommerce-minicart").toggleClass('active');
               $(".bodycommerce-minicart").removeClass('active');
               console.log('slide 8');
               $("body").removeClass('slidein-minicart-active');
               $(".CartClick").fadeOut();
             }
            });
        $("body").addClass('woocommerce bc-woocommerce');
        $(function() {
                $('.et-cart-info').hover(function() {
                    if ( $(window).width() > 767 ){
                        $(".bodycommerce-minicart").addClass('active');
                        $("body").addClass('minicart-active');
                    }
                }, function() {
                    if ( $(window).width() > 767 ){
                        setTimeout(function() {
                            var isHovered_minicart = $('.bodycommerce-minicart').is(":hover");
                            var isHovered_icon = $('.et-cart-info').is(":hover");
                            if (isHovered_minicart || isHovered_icon) {} else {
                                $(".bodycommerce-minicart").removeClass('active');
                                $("body").removeClass('minicart-active');
                            }
                        }, <?php echo $minicart_hover_delay_time ?>);
                    }
                });

                $('.et-cart-info').click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if ( $(window).width() > 767 ){
                        location.href = $(this).data('url');
                    }else{
                        if ($(this).find('.cart-icon').hasClass('disable_minicart_mobile')) {
                            document.location.href = $(this).data('url');
                        } else {
                            $("body").addClass('slidein-minicart-active');
                            $(".bodycommerce-minicart").addClass('active');
                            $("body").addClass('minicart-active');
                        }
                    }
                });
        });
        $(function() {
            if ( $(window).width() > 767 ){
                $('.bodycommerce-minicart').hover(function() {
                    $(".bodycommerce-minicart").addClass('active');
                    $("body").addClass('minicart-active');
                }, function() {
                    $(".bodycommerce-minicart").removeClass('active');
                    $("body").removeClass('minicart-active');
                });    
            }
        });
        <?php if ($check_auto_show_minicart == 1) { ?>
        var showdelay = <?php echo $check_auto_show_minicart_delay ?>;
        var closedelay = <?php echo $check_auto_show_minicart_close_time ?>;
        var section = 1;
        var showdelaytime = showdelay * 1000;
        var closedelaytime = closedelay * 1000;
        $(".single_add_to_cart_button").click(function() {
            setTimeout(function() {
                $(".bodycommerce-minicart").addClass('active-always');
                console.log('slide 9');
                $("body").addClass('slidein-minicart-active');
                $("body").addClass('minicart-active');
                $(".CartClick").addClass('active-always');
            }, showdelaytime);
            setTimeout(function() {
                $(".bodycommerce-minicart").removeClass('active-always');
                $("body").removeClass('minicart-active');
                console.log('slide 10');
                $("body").removeClass('slidein-minicart-active');
                $(".CartClick").removeClass('active-always');
            }, closedelaytime)
        })
        <?php } ?>
    });
}</script>
</span>
<?php
}
}
else {
  # code...
}


 }
}
}

////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////// ADD TO CART AUTO UPDATE/////////////////////////


$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);

$atc_pupup_enable = $mydata['atc_pupup_enable'][0] ?: "";

if ($atc_pupup_enable == 1) {

add_filter('woocommerce_add_to_cart_fragments', 'db_woo_modal_pop_up_add_to_cart');

function db_woo_modal_pop_up_add_to_cart( $fragments, $args = array() ) {
include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$atc_pupup_successfully_added_to_cart_get= $titan->getOption( 'atc_pupup_successfully_added_to_cart' );
$atc_pupup_continue_shopping_btn_text_get= $titan->getOption( 'atc_pupup_continue_shopping_btn_text' );
$atc_pupup_continue_shopping_btn_url_get= $titan->getOption( 'atc_pupup_continue_shopping_btn_url' );

do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Successfully added to cart Text for Pop Up', $atc_pupup_successfully_added_to_cart_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Continue Shopping Button Text for Pop Up', $atc_pupup_continue_shopping_btn_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Continue Shopping Button URL for Pop Up', $atc_pupup_continue_shopping_btn_url_get );
$atc_pupup_successfully_added_to_cart = apply_filters( 'wpml_translate_single_string', $atc_pupup_successfully_added_to_cart_get, 'divi-bodyshop-woocommerce', 'Successfully added to cart Text for Pop Up' );
$atc_pupup_continue_shopping_btn_text = apply_filters( 'wpml_translate_single_string', $atc_pupup_continue_shopping_btn_text_get, 'divi-bodyshop-woocommerce', 'Continue Shopping Button Text for Pop Up' );
$atc_pupup_continue_shopping_btn_url = apply_filters( 'wpml_translate_single_string', $atc_pupup_continue_shopping_btn_url_get, 'divi-bodyshop-woocommerce', 'Continue Shopping Button URL for Pop Up' );

if ($atc_pupup_continue_shopping_btn_url == "#" || $atc_pupup_continue_shopping_btn_url == "") {
  $preventdefault_css = "preventdefault";
  $continuejs = "return false;";
} else {
  $preventdefault_css = "";
  $continuejs = "location.href='" . $atc_pupup_continue_shopping_btn_url . "'";
}


$check_minicart_remove_option= $titan->getOption( 'minicart_remove_option' );
$minicart_remove_option_text_get= $titan->getOption( 'minicart_remove_option_text' );

do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Mini Cart Remove Text', $minicart_remove_option_text_get );
$minicart_remove_option_text = apply_filters( 'wpml_translate_single_string', $minicart_remove_option_text_get, 'divi-bodyshop-woocommerce', 'Mini Cart Remove Text' );
  $drop_down_mini_cart_total_subtotal = $titan->getOption( 'drop_down_mini_cart_total_subtotal' );

if ($check_minicart_remove_option == "1") {
  $check_minicart_remove_option_display = $minicart_remove_option_text;
}
else {
  $check_minicart_remove_option_display = "&times;";
}
ob_start();


	?>
		<div class="bc-added-modal-container">
			<div class="close-modal"></div>
			<h4><?php echo esc_html__( $atc_pupup_successfully_added_to_cart, 'divi-bodyshop-woocommerce' ); ?></h4>
      <?php if ($drop_down_mini_cart_total_subtotal == "sub-total") { ?>
      <p class="woocommerce-mini-cart__total total"><strong><?php _e( 'Subtotal', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>
    <?php } else { ?>
        <p class="woocommerce-mini-cart__total total"><strong><?php _e( 'Total', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_total(); ?></p>
      <?php } ?>
				<hr>
				<?php do_action( 'woocommerce_before_mini_cart' ); ?>

				<?php if ( ! WC()->cart->is_empty() ) : ?>
				<ul class="woocommerce-mini-cart cart_list product_list_widget">
					<?php
						do_action( 'woocommerce_before_mini_cart_contents' );

						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
								$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
								$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
								?>
								<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
									<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<span data-url="%s" class="cart-link-span remove-mini-cart remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">%s</span>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										__( 'Remove this item', 'woocommerce' ),
										esc_attr( $product_id ),
										esc_attr( $cart_item_key ),
										esc_attr( $_product->get_sku() ),
                    $check_minicart_remove_option_display
									), $cart_item_key );
									?>
									<?php if ( empty( $product_permalink ) ) : ?>
										<?php echo $thumbnail . $product_name; ?>
									<?php else : ?>
										<span onclick="location.href='<?php echo esc_url( $product_permalink ); ?>'" data-url="<?php echo esc_url( $product_permalink ); ?>" class="cart-link-span">
											<?php echo $thumbnail . $product_name; ?>
										</span>
									<?php endif; ?>
									<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
									<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
								</li>
								<?php
							}
						}

						do_action( 'woocommerce_mini_cart_contents' );
					?>
				</ul>
				<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
					<hr>
				<div class="bc-added-buttons">
<div class="continueshopping <?php _e($preventdefault_css,'divi_bodycommerce'); ?> <?php _e($atc_pupup_continue_shopping_btn_text,'divi_bodycommerce'); ?>">
<a onclick="<?php _e($continuejs,'divi_bodycommerce'); ?>" data-url="<?php _e($atc_pupup_continue_shopping_btn_url,'divi_bodycommerce'); ?>" class="cart-link-span et_pb_button button"><?php _e($atc_pupup_continue_shopping_btn_text,'divi_bodycommerce'); ?></a>
</div>
<div class="checkoutbuttons">
				<p class="bc-added-buttons_checkout buttons"><?php do_action( 'bodycommerce_minicart_button_text' ); ?></p>
</div>
</div>
			 <?php else : ?>
				<p class="woocommerce-mini-cart__empty-message"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></p>
			 <?php endif; ?>
			 <?php do_action( 'woocommerce_after_mini_cart' ); ?>
			</div>
	<?php
	$fragments['.bc-added-modal-container'] = ob_get_clean();
		 return $fragments;
}


add_action('wp_footer', 'db_woo_modal_pop_up_add_to_cart_html');
function db_woo_modal_pop_up_add_to_cart_html(){

?>
<div id="bodycommerce_added_to_cart_popup">
	<div class="bc-added-modal-container">
		<div class="close-modal"></div>
	</div>
</div>
<script>
jQuery(document).ready(function( $ ) {$(document).on('click', '.close-modal', function (e) {e.preventDefault();$("#bodycommerce_added_to_cart_popup").removeClass("active");});$(document).on('click', '.continueshopping.preventdefault .button', function (e) {e.preventDefault();$("#bodycommerce_added_to_cart_popup").removeClass("active");});});
</script>
<?php

}


add_action('wp_head', 'db_woo_modal_pop_up_add_to_cart_css');
function db_woo_modal_pop_up_add_to_cart_css(){

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $mini_cart_popup_close_size = $titan->getOption( 'mini_cart_popup_close_size' );
  $mini_cart_popup_close_color = $titan->getOption( 'mini_cart_popup_close_color' );
  $mini_cart_popup_overlay_color = $titan->getOption( 'mini_cart_popup_overlay_color' );

	$css_ajax_pop_up_class = 'pop_up_atc';
	$css_ajax_pop_up =  sprintf('<style id="bodyshop-%s"> ', $css_ajax_pop_up_class);
	$css_ajax_pop_up .= '#bodycommerce_added_to_cart_popup {display: none;}
#bodycommerce_added_to_cart_popup.active {
	display: block;
	position: fixed;
	z-index: 999999999999999999;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: '.$mini_cart_popup_overlay_color.';
	color: #fff;
	display: flex;
	justify-content: center;
	align-items: center;
}
.bc-added-modal-container {
	background-color: #fff;
width: 80%;
max-width: 800px;
margin: auto;
padding: 30px;
color: #000;
position: relative;
overflow-y: auto;
max-height: 80vh;
}
#bodycommerce_added_to_cart_popup .close-modal {
	position: absolute;
	right: 0;
	top: 0;
}
#bodycommerce_added_to_cart_popup .close-modal::after {
	font-family: "ETmodules" !important;
font-weight: normal;
font-style: normal;
font-variant: normal;
-webkit-font-smoothing: antialiased;
-moz-osx-font-smoothing: grayscale;
line-height: 1;
text-transform: none;
speak: none;
font-size: '.$mini_cart_popup_close_size.'px;
color: '.$mini_cart_popup_close_color.';
z-index: 9999999;
cursor: pointer;
    content: "\4d";
}
#bodycommerce_added_to_cart_popup .jde_hint {
	display: none;
}
.bc-added-buttons {display: flex;}
.bc-added-buttons > div {flex: 1;}
.bc-added-buttons_checkout {text-align: right;}

@media all and (max-width: 980px) {
	.bc-added-buttons {
	    display: block;
	}
	.bc-added-buttons > div {
    text-align: center;
}
.bc-added-buttons_checkout {
    text-align: center;
}
}

@media all and (max-width: 450px) {
.bc-added-buttons .et_pb_button, .bc-added-buttons .button {
	display: block !important;
}
}

</style>';

$css_ajax_pop_up .= '</style>';
//minify it
$css_ajax_pop_up_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_ajax_pop_up );
echo $css_ajax_pop_up_min;

}

}

//////////////

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);

$check_ajax_minicart = $mydata['ajax_minicart'][0] ?: "";

if ($check_ajax_minicart == 1) {
// AUTOUPDATE
add_filter('woocommerce_add_to_cart_fragments', 'DB_WOO_add_to_cart_fragment');

function DB_WOO_add_to_cart_fragment( $fragments, $args = array() ) {
ob_start();

  ?> <span class="shop-cart"><?php
  if ( ! class_exists( 'woocommerce' ) ) {
    return;
  }
  $defaults = array(
    'no_text' => false,
  );
  $args = wp_parse_args( $args, $defaults );
  if (is_object( WC()->cart ) ) {
  $items_number = WC()->cart->get_cart_contents_count();
} else {
  $items_number = "";
}
	include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
	$minicart_remove_item_text = $titan->getOption( 'minicart_remove_item_text' );
  $check_BodyCommerce_cart_icon = $titan->getOption( 'enable_cart_custom_icon_select' );
  $check_enable_cart_custom_icon = $titan->getOption( 'enable_cart_custom_icon');
  $cart_custom_icon_disable_empty_number = $titan->getOption( 'cart_custom_icon_disable_empty_number' );

  $check_cart_custom_icon_enable_numbers = $titan->getOption( 'cart_custom_icon_enable_numbers' );

  $check_cart_custom_icon_enable_text_after_get = $titan->getOption( 'cart_custom_icon_enable_text_after' );
  $check_cart_custom_icon_enable_text_after_plural_get = $titan->getOption( 'cart_custom_icon_enable_text_after_plural' );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Cart Text After', $check_cart_custom_icon_enable_text_after_get );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Cart Text After Plural', $check_cart_custom_icon_enable_text_after_plural_get );
  $check_cart_custom_icon_enable_text_after = apply_filters( 'wpml_translate_single_string', $check_cart_custom_icon_enable_text_after_get, 'divi-bodyshop-woocommerce', 'Cart Text After' );
  $check_cart_custom_icon_enable_text_after_plural = apply_filters( 'wpml_translate_single_string', $check_cart_custom_icon_enable_text_after_plural_get, 'divi-bodyshop-woocommerce', 'Cart Text After Plural' );

    $check_BodyCommerce_cart_icon = $titan->getOption( 'enable_cart_custom_icon_select' );
      $minicart_activate = $titan->getOption( 'minicart_activate' );
    $mini_cart_style = $titan->getOption( 'mini_cart_style');

    $atc_pupup_disable_mobile = $titan->getOption( 'atc_pupup_disable_mobile' );
    if ($atc_pupup_disable_mobile == '1') {$atc_pupup_disable_mobile_name = 'disable_minicart_mobile';} else {$atc_pupup_disable_mobile_name = 'enable_minicart_mobile';}


    $custom_cart_icon_upload = $titan->getOption( 'custom_cart_icon_upload' );
      if ($custom_cart_icon_upload == "") {
      $path = '/lib/cart-icon-styles/'.$check_BodyCommerce_cart_icon.'.php';
    } else {
    $path = '/lib/cart-icon-styles/users-custom-cart.php';
    }

	if ($minicart_remove_item_text == 1){

    if ($check_enable_cart_custom_icon == 1) {
      // CUSTOM CART ICON
      $getCartURL = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
      $cartCount = esc_html( sprintf(
        _nx( '%1$s '.$check_cart_custom_icon_enable_text_after.'', '%1$s '.$check_cart_custom_icon_enable_text_after_plural.'', $items_number, 'WooCommerce items number', 'divi-bodyshop-woocommerce' ),
        number_format_i18n( $items_number )
      ));

          ?>

            <?php if ($minicart_activate == 1) { ?>
            <span data-url="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-third">
            <?php } else { ?>
            <span data-url="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-third">
            <?php } ?>

          <div class="cart-icon <?php echo $atc_pupup_disable_mobile_name ?>"><?php include(DE_DB_WOO_PATH . $path); ?>

            <?php if ($check_cart_custom_icon_enable_numbers == 1){ ?>
              <?php
  if(isset($cart_custom_icon_disable_empty_number)){
              if ($cart_custom_icon_disable_empty_number == 1 && $items_number == "0") {
              }
              else { ?>
            <div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
          <?php }
  } else {
    ?>
  <div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
  <?php
  }
          ?>
          <?php } else {
            # code...
          }
        ?>

          </div>
        </span>
          <?php
    }
    else {
        // NO CUSTOM CART ICON
        printf(
    	    '<span data-url="%1$s" class="cart-link-span et-cart-info bc-forth">
    	      <span>%2$s</span>
    	    </span>',
    	    function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url(),
    	    ( ! $args['no_text']
    	      ? esc_html( sprintf(
    	        _nx( '%1$s', '%1$s', $items_number, 'WooCommerce items number', 'divi-bodyshop-woocommerce' ),
    	        number_format_i18n( $items_number )
    	      ) )
    	      : ''
    	    )
    	  );
    }

	}
	else {

    if ($check_enable_cart_custom_icon == 1) {
      // CUSTOM CART ICON
      $getCartURL = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
      $cartCount = esc_html( sprintf(
        _nx( '%1$s '.$check_cart_custom_icon_enable_text_after.'', '%1$s '.$check_cart_custom_icon_enable_text_after_plural.'', $items_number, 'WooCommerce items number', 'divi-bodyshop-woocommerce' ),
        number_format_i18n( $items_number )
      ));

          ?>

          <?php if ($minicart_activate == 1) { ?>
          <span data-url="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-fith <?php echo $minicart_activate ?>">
          <?php } else { ?>
          <span data-url="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-fith">
          <?php } ?>
              <div class="cart-icon <?php echo $atc_pupup_disable_mobile_name ?>"><?php include(DE_DB_WOO_PATH . $path); ?>

                <?php if ($check_cart_custom_icon_enable_numbers == 1){ ?>
                  <?php
      if(isset($cart_custom_icon_disable_empty_number)){
                  if ($cart_custom_icon_disable_empty_number == 1 && $items_number == "0") {
                  }
                  else { ?>
                <div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
              <?php }
      } else {
        ?>
      <div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
      <?php
      }
              ?>
              <?php } else {
                # code...
              }
            ?>

          </div>
        </span>
          <?php
    }
    else {
        // NO CUSTOM CART ICON
        printf(
    	    '<span data-url="%1$s" class="cart-link-span et-cart-info  bc-sixth">
    	      <span>%2$s</span>
    	    </span>',
    	    function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url(),
    	    ( ! $args['no_text']
    	      ? esc_html( sprintf(
    	        _nx( '%1$s', '%1$s', $items_number, 'WooCommerce items number', 'divi-bodyshop-woocommerce' ),
    	        number_format_i18n( $items_number )
    	      ) )
    	      : ''
    	    )
    	  );
    }

	}
  global $woocommerce;

  $mydata = get_option( 'divi-bodyshop-woo_options' );
  $mydata = unserialize($mydata);

  $check_minicart_remove_option = $mydata['minicart_remove_option'][0] ?: "";
  $minicart_remove_option_text = $mydata['minicart_remove_option_text'] ?: "";

  if ($check_minicart_remove_option == "1") {
    $check_minicart_remove_option_display = $minicart_remove_option_text;
    $check_minicart_remove_option_display_css = "";
  }
  else {
    $check_minicart_remove_option_display = "&times;";
    $check_minicart_remove_option_display_css = "remove";
  }


  ?>

  <?php if ($mini_cart_style == "slide-in") {
  ?><div class="CartClick overlay"></div><?php
} else { }?>

 <div class="bodycommerce-minicart two">

   <?php if ($mini_cart_style == "slide-in") {
     echo do_shortcode("[bodycommerce_slide_in_mini_cart]");
    } else {
      echo do_shortcode("[bodycommerce_default_mini_cart]");
     } ?>
</div>

<?php
$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);

$enable_minicart2 = $mydata['enable_minicart'] ?: "";
$check_auto_show_minicart = $mydata['auto_show_minicart'] ?: "";
$check_auto_show_minicart_delay = $mydata['auto_show_minicart_delay'] ?: "3";

if (isset($mydata['close_auto_show'])) {
  $close_auto_show = $mydata['close_auto_show'] ?: "0";
} else {
  $close_auto_show = "0";
}



if (isset($close_auto_show) && $close_auto_show == '1') {
$check_auto_show_minicart_close_time = $mydata['auto_show_minicart_close_time'] ?: "6";
} else {
$check_auto_show_minicart_close_time = '9999';
}
$minicart_hover_delay_time = $mydata['minicart_hover_delay_time'] ?: "";
if ($minicart_hover_delay_time == "") {
  $minicart_hover_delay_time = "800";
}

$minicart_activate = $mydata['minicart_activate'] ?: "";

$atc_pupup_disable_mobile = $mydata['atc_pupup_disable_mobile'] ?: "";

if ($enable_minicart2 == 1) {

	if ($minicart_activate == 1) {
		?>
    <script>
    jQuery(document).ready(function($){

      $(".et-cart-info").click(function(event) {
<?php
if ($atc_pupup_disable_mobile == "1") {
?>
if ($(window).width() < 767) {
var cart_url = $(this).attr('data-url');
window.location.href = cart_url;
console.log('done 2');
}
else {
}
<?php
}
?>


<?php if ($mini_cart_style == "drop-down-icon") {
  ?>
  if ($(window).width() < 767) {
    <?php
    if ($atc_pupup_disable_mobile == "1") {
    ?>
    location.href='<?php echo esc_url( $cart_link ); ?>'
    <?php
  } else {
    ?>
    event.preventDefault();
    console.log('drop down disable');
    $(".bodycommerce-minicart").toggleClass('active');
    $(".CartClick").fadeIn();
    console.log('slide 11');
    $("body").toggleClass('slidein-minicart-active');
    <?php
  }
    ?>
  }
  else {
  event.preventDefault();
  // $(".bodycommerce-minicart").toggleClass('active');
  $(".bodycommerce-minicart").toggleClass('active');
  $(".CartClick").fadeIn();
  console.log('slide 12');
  $("body").toggleClass('slidein-minicart-active');
  }
  <?php
} else {
          ?>
          event.preventDefault();
          // $(".bodycommerce-minicart").toggleClass('active');
          $(".bodycommerce-minicart").addClass('active');
          console.log("yes");
          $(".CartClick").fadeIn();
          <?php
        }
        ?>
            });

            $(".CartClick").click(function(event) {
                     event.preventDefault();
                     if (!$(this).hasClass("active-always")) {
                            // $(".bodycommerce-minicart").toggleClass('active');
                            $(".bodycommerce-minicart").removeClass('active');
                            console.log('slide 13');
                            $("body").removeClass('slidein-minicart-active');
                            $(".CartClick").fadeOut();
                            }
                  });
                    $(document).on('touchstart click', ".close" , function(event){
                           event.preventDefault();
                             $(".bodycommerce-minicart").removeClass('active-always');
                             $(".bodycommerce-minicart").removeClass('active');
                             console.log('slide 14');
                                $("body").removeClass('slidein-minicart-active');
                                $(".CartClick").removeClass('active-always');
                                $(".CartClick").fadeOut();
                        });
            <?php
            if ($check_auto_show_minicart == 1) { ?>
            var showdelay = <?php echo $check_auto_show_minicart_delay ?>;
            <?php if ($check_auto_show_minicart_close_time == "") {} else {?>
              var closedelay = <?php echo $check_auto_show_minicart_close_time ?>;
              var closedelaytime=closedelay*1000;
               <?php } ?>
               var section = 2;
            var showdelaytime=showdelay*1000;
    $(".ajax_add_to_cart").click(function(){
              setTimeout(function(){
                $(".bodycommerce-minicart").addClass('active-always');
                console.log('slide 15');
                $("body").addClass('slidein-minicart-active');
                $(".CartClick").addClass('active-always');
              },showdelaytime);

              <?php if ($check_auto_show_minicart_close_time == "") { } else { ?>
                setTimeout(function(){
                $(".bodycommerce-minicart").removeClass('active-always');
                console.log('slide 16');
                $("body").removeClass('slidein-minicart-active');
                $(".CartClick").removeClass('active-always');
              },closedelaytime);
              <?php } ?>

              });

  <?php if ($check_auto_show_minicart_close_time == "") { ?>
              $(".CartClick").click(function(event) {
                       event.preventDefault();
                              $(".bodycommerce-minicart").removeClass('active-always');
                              $(".CartClick").fadeOut();
                    });
                      $(document).on('touchstart click', ".close" , function(event){
                             event.preventDefault();
                                  $(".bodycommerce-minicart").removeClass('active-always');
                                  $(".CartClick").fadeOut();
                          });
      <?php } else { }?>


                <?php } ?>
      });
      </script>

      </span>
<?php
	}
	else {

?>
<script>
if (typeof jQuery == 'undefined') {} else {
jQuery(document).ready(function($){

    $(document).on('touchstart click', ".close" , function(event){
           event.preventDefault();

           $(".bodycommerce-minicart").removeClass('active');
           console.log('slide 17');
           $("body").removeClass('slidein-minicart-active');
           $(".CartClick").fadeOut();

        });

  $("body").addClass('woocommerce bc-woocommerce');
  $(function() {
    $('.et-cart-info').hover(function() {
        if ( $(window).width() > 767 ){
            $(".bodycommerce-minicart").addClass('active');
            $("body").addClass('minicart-active');
        }
    }, function() {
        if ( $(window).width() > 767 ){
            setTimeout(function() {
                var isHovered_minicart = $('.bodycommerce-minicart').is(":hover");
                var isHovered_icon = $('.et-cart-info').is(":hover");
                if (isHovered_minicart || isHovered_icon) {} else {
                    $(".bodycommerce-minicart").removeClass('active');
                    $("body").removeClass('minicart-active');
                }
            }, <?php echo $minicart_hover_delay_time ?>);
        }
    });

    $('.et-cart-info').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        if ( $(window).width() > 767 ){
            location.href = $(this).data('url');
        }else{
            if ($(this).find('.cart-icon').hasClass('disable_minicart_mobile')) {
                document.location.href = $(this).data('url');
            } else {
                $("body").addClass('slidein-minicart-active');
                $(".bodycommerce-minicart").addClass('active');
                $("body").addClass('minicart-active');
            }
        }
    });
  });
  $(function() {
    if ($(window).width() > 767) {
      $('.bodycommerce-minicart').hover(function() {
          $(".bodycommerce-minicart").addClass('active');
          $("body").addClass('minicart-active');
      }, function() {
          $(".bodycommerce-minicart").removeClass('active');
          $("body").removeClass('minicart-active');
      });
    }
  });
<?php if ($check_auto_show_minicart == 1) { ?>
  var showdelay = <?php echo $check_auto_show_minicart_delay ?>;
  var closedelay = <?php echo $check_auto_show_minicart_close_time ?>;
  var section = 3;
  var showdelaytime = showdelay * 1000;
  var closedelaytime = closedelay * 1000;
  $(".single_add_to_cart_button").click(function() {
      setTimeout(function() {
          $(".bodycommerce-minicart").addClass('active-always');
          console.log('slide 18');
          $("body").addClass('slidein-minicart-active');
          $("body").addClass('minicart-active');
          $(".CartClick").addClass('active-always');
      }, showdelaytime);
      setTimeout(function() {
          $(".bodycommerce-minicart").removeClass('active-always');
          $("body").removeClass('minicart-active');
          console.log('slide 19');
          $("body").removeClass('slidein-minicart-active');
          $(".CartClick").removeClass('active-always');
      }, closedelaytime)
  })
<?php } ?>
});
}
</script>
</span>
<?php
}
}
else {
  # code...
}

$fragments['.shop-cart'] = ob_get_clean();
	 return $fragments;

}
}
else {
  # code...
}






}
else
{

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// MINI CART NOT ENABLED
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ( ! function_exists( 'et_show_cart_total' ) ) {
function et_show_cart_total( $args = array() ) {
    global $woocommerce;
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $check_enable_cart_custom_icon = $titan->getOption( 'enable_cart_custom_icon');
  $check_BodyCommerce_cart_icon = $titan->getOption( 'enable_cart_custom_icon_select' );
  $check_cart_custom_icon_enable_numbers = $titan->getOption( 'cart_custom_icon_enable_numbers' );

  $check_cart_custom_icon_enable_text_after_get = $titan->getOption( 'cart_custom_icon_enable_text_after' );
  $check_cart_custom_icon_enable_text_after_plural_get = $titan->getOption( 'cart_custom_icon_enable_text_after_plural' );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Cart Text After', $check_cart_custom_icon_enable_text_after_get );
  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Cart Text After Plural', $check_cart_custom_icon_enable_text_after_plural_get );
  $check_cart_custom_icon_enable_text_after = apply_filters( 'wpml_translate_single_string', $check_cart_custom_icon_enable_text_after_get, 'divi-bodyshop-woocommerce', 'Cart Text After' );
  $check_cart_custom_icon_enable_text_after_plural = apply_filters( 'wpml_translate_single_string', $check_cart_custom_icon_enable_text_after_plural_get, 'divi-bodyshop-woocommerce', 'Cart Text After Plural' );

  $minicart_activate = $titan->getOption( 'minicart_activate' );
  $cart_custom_icon_disable_empty_number = $titan->getOption( 'cart_custom_icon_disable_empty_number' );

  $atc_pupup_disable_mobile = $titan->getOption( 'atc_pupup_disable_mobile' );
  if ($atc_pupup_disable_mobile == '1') {$atc_pupup_disable_mobile_name = 'disable_minicart_mobile';} else {$atc_pupup_disable_mobile_name = 'enable_minicart_mobile';}


  $custom_cart_icon_upload = $titan->getOption( 'custom_cart_icon_upload' );
    if ($custom_cart_icon_upload == "") {
    $path = '/lib/cart-icon-styles/'.$check_BodyCommerce_cart_icon.'.php';
  } else {
  $path = '/lib/cart-icon-styles/users-custom-cart.php';
  }
  if ( ! class_exists( 'woocommerce' ) || ! WC()->cart ) {
    return;
  }

  $defaults = array(
    'no_text' => false,
  );

  $args = wp_parse_args( $args, $defaults );

  if (is_object( WC()->cart ) ) {
  $items_number = WC()->cart->get_cart_contents_count();
} else {
  $items_number = "";
}

  if ($check_enable_cart_custom_icon == 1) {
    // CUSTOM CART ICON
    $getCartURL = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
    $cartCount = esc_html( sprintf(
      _nx( '%1$s '.$check_cart_custom_icon_enable_text_after.'', '%1$s '.$check_cart_custom_icon_enable_text_after_plural.'', $items_number, 'WooCommerce items number', 'divi-bodyshop-woocommerce' ),
      number_format_i18n( $items_number )
    ));

        ?>
        <?php if ($minicart_activate == 1) { ?>
        <a href="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-seventh">
        <?php } else { ?>
        <a href="<?php echo $getCartURL ?>" class="cart-link-span et-cart-info bc-seventh">
        <?php } ?>
        <div class="cart-icon <?php echo $atc_pupup_disable_mobile_name ?>"><?php include(DE_DB_WOO_PATH . $path); ?>

          <?php if ($check_cart_custom_icon_enable_numbers == 1){ ?>
            <?php
if(isset($cart_custom_icon_disable_empty_number)){
            if ($cart_custom_icon_disable_empty_number == 1 && $items_number == "0") {
            }
            else { ?>
          <div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
        <?php }
} else {
  ?>
<div class="cart-count"><p> <?php echo $cartCount ?></p> </div>
<?php
}
        ?>
        <?php } else {
          # code...
        }
      ?>

        </div>
      </a>
        <?php
  }
  else {
      // NO CUSTOM CART ICON
      $defaults = array(
        'no_text' => false,
      );
  
      $args = wp_parse_args( $args, $defaults );
  
      $items_number = WC()->cart->get_cart_contents_count();
  
      $url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : WC()->cart->get_cart_url();
  
      printf(
        '<a href="%1$s" class="et-cart-info no-custom-cart">
          <span>%2$s</span>
        </a>',
        esc_url( $url ),
        ( ! $args['no_text']
          ? esc_html( sprintf(
            _nx( '%1$s Item', '%1$s Items', $items_number, 'WooCommerce items number', 'Divi' ),
            number_format_i18n( $items_number )
          ) )
          : ''
        )
      );
  }

}
}

	}



 ?>
