<?php
// Slide In Mini Cart
function bodycommerce_slide_in_mini_cart( $atts ){
ob_start();

if (is_object( WC()->cart ) ) {

$defaults = array(
  'no_text' => false,
);
$items_number = WC()->cart->get_cart_contents_count();
include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
$minicart_remove_item_text = $titan->getOption( 'minicart_remove_item_text' );
$check_BodyCommerce_cart_icon = $titan->getOption( 'enable_cart_custom_icon_select' );
$check_enable_cart_custom_icon = $titan->getOption( 'enable_cart_custom_icon');
$cart_custom_icon_disable_empty_number = $titan->getOption( 'cart_custom_icon_disable_empty_number' );


$mini_cart_slide_header_text_get = $titan->getOption( 'mini_cart_slide_header_text');

$mini_cart_slide_subtotal_text_get = $titan->getOption( 'mini_cart_slide_subtotal_text');
$mini_cart_slide_discount_text_get = $titan->getOption( 'mini_cart_slide_discount_text');
$mini_cart_slide_shipping_text_get = $titan->getOption( 'mini_cart_slide_shipping_text');
$mini_cart_slide_tax_text_get = $titan->getOption( 'mini_cart_slide_tax_text');
$mini_cart_slide_total_text_get = $titan->getOption( 'mini_cart_slide_total_text');
$mini_cart_slide_quantity_text_get = $titan->getOption( 'mini_cart_slide_quantity_text');


do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Slide in mini-cart header text', $mini_cart_slide_header_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Slide in mini-cart subtotal text', $mini_cart_slide_subtotal_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Slide in mini-cart discount text', $mini_cart_slide_discount_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Slide in mini-cart shipping text', $mini_cart_slide_shipping_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Slide in mini-cart tax text', $mini_cart_slide_tax_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Slide in mini-cart total text', $mini_cart_slide_total_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Slide in mini-cart quantity text', $mini_cart_slide_quantity_text_get );

$mini_cart_slide_header_text = apply_filters( 'wpml_translate_single_string', $mini_cart_slide_header_text_get, 'divi-bodyshop-woocommerce', 'Slide in mini-cart header text' );
$mini_cart_slide_subtotal_text = apply_filters( 'wpml_translate_single_string', $mini_cart_slide_subtotal_text_get, 'divi-bodyshop-woocommerce', 'Slide in mini-cart subtotal text' );
$mini_cart_slide_discount_text = apply_filters( 'wpml_translate_single_string', $mini_cart_slide_discount_text_get, 'divi-bodyshop-woocommerce', 'Slide in mini-cart discount text' );
$mini_cart_slide_shipping_text = apply_filters( 'wpml_translate_single_string', $mini_cart_slide_shipping_text_get, 'divi-bodyshop-woocommerce', 'Slide in mini-cart shipping text' );
$mini_cart_slide_tax_text = apply_filters( 'wpml_translate_single_string', $mini_cart_slide_tax_text_get, 'divi-bodyshop-woocommerce', 'Slide in mini-cart tax text' );
$mini_cart_slide_total_text = apply_filters( 'wpml_translate_single_string', $mini_cart_slide_total_text_get, 'divi-bodyshop-woocommerce', 'Slide in mini-cart total text' );
$mini_cart_slide_quantity_text = apply_filters( 'wpml_translate_single_string', $mini_cart_slide_quantity_text_get, 'divi-bodyshop-woocommerce', 'Slide in mini-cart quantity text' );

$mini_cart_slide_show_subtotal = $titan->getOption( 'mini_cart_slide_show_subtotal');
$mini_cart_slide_show_discount = $titan->getOption( 'mini_cart_slide_show_discount');
$mini_cart_slide_show_shipping = $titan->getOption( 'mini_cart_slide_show_shipping');
$mini_cart_slide_show_tax = $titan->getOption( 'mini_cart_slide_show_tax');
$mini_cart_slide_show_total = $titan->getOption( 'mini_cart_slide_show_total');

$check_cart_custom_icon_enable_numbers = $titan->getOption( 'cart_custom_icon_enable_numbers' );
$check_cart_custom_icon_enable_text_after = $titan->getOption( 'cart_custom_icon_enable_text_after' );
$check_cart_custom_icon_enable_text_after_plural = $titan->getOption( 'cart_custom_icon_enable_text_after_plural' );
$check_BodyCommerce_cart_icon = $titan->getOption( 'enable_cart_custom_icon_select' );
$check_minicart_remove_option = $titan->getOption( 'minicart_remove_option' );
$minicart_remove_option_text_get = $titan->getOption( 'minicart_remove_option_text' );

do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Mini Cart Remove Text', $minicart_remove_option_text_get );
$minicart_remove_option_text = apply_filters( 'wpml_translate_single_string', $minicart_remove_option_text_get, 'divi-bodyshop-woocommerce', 'Mini Cart Remove Text' );

$mini_cart_style = $titan->getOption( 'mini_cart_style');


$custom_cart_icon_upload = $titan->getOption( 'custom_cart_icon_upload' );
  if ($custom_cart_icon_upload == "") {
  $path = '/lib/cart-icon-styles/'.$check_BodyCommerce_cart_icon.'.php';
} else {
$path = '/lib/cart-icon-styles/users-custom-cart.php';
}


if ($check_minicart_remove_option == "1") {
  $check_minicart_remove_option_display = $minicart_remove_option_text;
  $check_minicart_remove_option_display_css = "";
}
else {
  $check_minicart_remove_option_display = "&times;";
  $check_minicart_remove_option_display_css = "remove";
}


        ?>
<div class="bodycommerce-minicart-container">
  <header>
          <p class="slidein-header-text"><?php echo esc_html__( $mini_cart_slide_header_text, 'divi-bodyshop-woocommerce' ); ?> </p>
          <span class="close">
          </span>
        </header>
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


            <span class="item-img">
              <?php if ( empty( $product_permalink ) ) : ?>
                <?php echo $thumbnail; ?>
              <?php else : ?>
                <a href="<?php echo esc_url( $product_permalink ); ?>">
                  <?php echo $thumbnail; ?>
                </a>
              <?php endif; ?>
                                </span>
                                <div class="item-contents">
                                  <div class="item-upper">
                                    <span class="item-name">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}
						?>
                                    </span>
                                    <span class="cart-item-quantity">
                                      <?php echo esc_html__( $mini_cart_slide_quantity_text, 'divi-bodyshop-woocommerce' ); ?>: <?php echo $cart_item['quantity'] ?>
                                    </span>
                                    <span class="cart-item-price">
                                      <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?>
                                    </span>


                                      <span class="delete cart-item-delete">
                                        <?php
                                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                          '<a href="%s" class="remove-mini-cart %s remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">%s</a>',
                                          esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                          $check_minicart_remove_option_display_css,
                                          __( 'Remove this item', 'woocommerce' ),
                                          esc_attr( $product_id ),
                                          esc_attr( $cart_item_key ),
                                          esc_attr( $_product->get_sku() ),
                                          $check_minicart_remove_option_display
                                        ), $cart_item_key );
                                        ?>
                                      </span>

                                  </div>
                                  <div class="item-lower">
                                    <div class="actions-nav">
                                    </div>
                                  </div>
                                </div>



          </li>



          <?php
        }
      }

      do_action( 'woocommerce_mini_cart_contents' );
    ?>
  </ul>
  <div class="bc-minicart-slide-bottom">

    <div class="costs">






<?php if ($mini_cart_slide_show_subtotal == "1") { ?>
                          <div class="subtotal">
                            <span class="title"><?php echo esc_html__( $mini_cart_slide_subtotal_text, 'divi-bodyshop-woocommerce' ); ?></span>
                            <span class="value"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                          </div>
<?php } ?>
<?php if ($mini_cart_slide_show_discount == "1") { ?>
                          <div class="discount">
                            <span class="title"><?php echo esc_html__( $mini_cart_slide_discount_text, 'divi-bodyshop-woocommerce' ); ?></span>
                            <span class="value"><?php
                            foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                        			<?php wc_cart_totals_coupon_html( $coupon ); ?>
                        		<?php endforeach;
                            ?></span>
                          </div>
<?php } ?>
<?php if ($mini_cart_slide_show_shipping == "1") { ?>
                          <div class="shipping">
                            <span class="title"><?php echo esc_html__( $mini_cart_slide_shipping_text, 'divi-bodyshop-woocommerce' ); ?></span>
                            <span class="value"><?php echo WC()->cart->get_cart_shipping_total(); ?></span>
                          </div>
<?php } ?>
<?php if ($mini_cart_slide_show_tax == "1") { ?>
                          <div class="tax">
                            <span class="title"><?php echo esc_html__( $mini_cart_slide_tax_text, 'divi-bodyshop-woocommerce' ); ?></span>
                            <span class="value"><?php echo sprintf( '%s', wc_price( WC()->cart->get_taxes_total( true, true ) ) ); ?></span>
                          </div>
<?php } ?>
<?php if ($mini_cart_slide_show_total == "1") { ?>
                          <div class="total">
                            <span class="title"><?php echo esc_html__( $mini_cart_slide_total_text, 'divi-bodyshop-woocommerce' ); ?></span>
                            <span class="value"><?php
                            echo WC()->cart->get_total(); ?></span>
                          </div>
<?php } ?>
        </div>


  <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
  <p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'bodycommerce_minicart_button_text' ); ?></p>
</div>
 <?php else : ?>
  <p class="woocommerce-mini-cart__empty-message"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></p>
 <?php endif; ?>
 <?php do_action( 'woocommerce_after_mini_cart' ); ?>
</div>
<?php

} else {
  // code...
}

return ob_get_clean();
}
add_shortcode( 'bodycommerce_slide_in_mini_cart', 'bodycommerce_slide_in_mini_cart' );



function bodycommerce_default_mini_cart( $atts ){
  ob_start();

if (is_object( WC()->cart ) ) {

  $defaults = array(
    'no_text' => false,
  );
  $items_number = WC()->cart->get_cart_contents_count();
  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $minicart_remove_item_text = $titan->getOption( 'minicart_remove_item_text' );
  $check_BodyCommerce_cart_icon = $titan->getOption( 'enable_cart_custom_icon_select' );
  $check_enable_cart_custom_icon = $titan->getOption( 'enable_cart_custom_icon');
  $cart_custom_icon_disable_empty_number = $titan->getOption( 'cart_custom_icon_disable_empty_number' );


  $check_cart_custom_icon_enable_numbers = $titan->getOption( 'cart_custom_icon_enable_numbers' );
  $check_cart_custom_icon_enable_text_after = $titan->getOption( 'cart_custom_icon_enable_text_after' );
  $check_cart_custom_icon_enable_text_after_plural = $titan->getOption( 'cart_custom_icon_enable_text_after_plural' );
  $check_BodyCommerce_cart_icon = $titan->getOption( 'enable_cart_custom_icon_select' );
  $check_minicart_remove_option = $titan->getOption( 'minicart_remove_option' );
  $minicart_remove_option_text_get = $titan->getOption( 'minicart_remove_option_text' );

  do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Mini Cart Remove Text', $minicart_remove_option_text_get );
  $minicart_remove_option_text = apply_filters( 'wpml_translate_single_string', $minicart_remove_option_text_get, 'divi-bodyshop-woocommerce', 'Mini Cart Remove Text' );

  $drop_down_mini_cart_total_subtotal = $titan->getOption( 'drop_down_mini_cart_total_subtotal' );

  $mini_cart_style = $titan->getOption( 'mini_cart_style');


  $custom_cart_icon_upload = $titan->getOption( 'custom_cart_icon_upload' );
    if ($custom_cart_icon_upload == "") {
    $path = '/lib/cart-icon-styles/'.$check_BodyCommerce_cart_icon.'.php';
  } else {
  $path = '/lib/cart-icon-styles/users-custom-cart.php';
  }


  if ($check_minicart_remove_option == "1") {
    $check_minicart_remove_option_display = $minicart_remove_option_text;
    $check_minicart_remove_option_display_css = "";
  }
  else {
    $check_minicart_remove_option_display = "&times;";
    $check_minicart_remove_option_display_css = "remove";
  }
?>
<div class="bodycommerce-minicart-container dropdown-minicart">
  <span class="close">
  </span>
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


            <span class="item-img">
              <?php if ( empty( $product_permalink ) ) : ?>
                <?php echo $thumbnail; ?>
              <?php else : ?>
                <a href="<?php echo esc_url( $product_permalink ); ?>">
                  <?php echo $thumbnail; ?>
                </a>
              <?php endif; ?>
                                </span>
                                <div class="item-contents">
                                  <div class="item-upper">
                                    <span class="item-name">
            <?php
            if ( ! $product_permalink ) {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
            } else {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
            }

            do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

            // Meta data.
            echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

            // Backorder notification.
            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
            }
            ?>
                                    </span>
                                    <span class="cart-item-quantity">
                                      <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                    </span>


                                      <span class="delete cart-item-delete">
                                        <?php
                                        echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                          '<a href="%s" class="remove-mini-cart %s remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">%s</a>',
                                          esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                          $check_minicart_remove_option_display_css,
                                          __( 'Remove this item', 'woocommerce' ),
                                          esc_attr( $product_id ),
                                          esc_attr( $cart_item_key ),
                                          esc_attr( $_product->get_sku() ),
                                          $check_minicart_remove_option_display
                                        ), $cart_item_key );
                                        ?>
                                      </span>

                                  </div>
                                  <div class="item-lower">
                                    <div class="actions-nav">
                                    </div>
                                  </div>
                                </div>



          </li>
          <?php
        }
      }

      do_action( 'woocommerce_mini_cart_contents' );
    ?>
  </ul>
  <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
  <p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'bodycommerce_minicart_button_text' ); ?></p>
 <?php else : ?>
  <p class="woocommerce-mini-cart__empty-message"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></p>
 <?php endif; ?>
 <?php do_action( 'woocommerce_after_mini_cart' ); ?>
</div>
<?php
}
else {

}
return ob_get_clean();
}
add_shortcode( 'bodycommerce_default_mini_cart', 'bodycommerce_default_mini_cart' );
?>
