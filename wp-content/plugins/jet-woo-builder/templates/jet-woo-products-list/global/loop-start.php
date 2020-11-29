<?php
/**
 * Products list loop start template
 */
	
$settings = $this->get_settings();

$classes = array(
	'jet-woo-products-list',
);

$layout = $this->get_attr( 'products_layout' );

if ( $layout ) {
	$classes[] = 'products-layout-' . $layout;
}

$popup_enable = ! empty( $settings['jet_woo_builder_cart_popup'] ) ? esc_attr( $settings['jet_woo_builder_cart_popup'] ) : false;
$popup_id     = ! empty( $settings['jet_woo_builder_cart_popup_template'] ) ? esc_attr( $settings['jet_woo_builder_cart_popup_template'] ) : '';

?>

<ul class="<?php echo implode( ' ', $classes ); ?>" <?php do_action( 'jet-woo-builder/popup-generator/after-added-to-cart/cart-popup', $popup_enable, $popup_id ); ?>>