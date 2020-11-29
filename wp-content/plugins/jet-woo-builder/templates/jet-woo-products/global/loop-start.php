<?php
/**
 * Products loop start template
 */

$settings = $this->get_settings();
$classes  = array(
	'jet-woo-products',
	'jet-woo-products--' . $this->get_attr( 'presets' ),
	jet_woo_builder_tools()->gap_classes( $this->get_attr( 'columns_gap' ), $this->get_attr( 'rows_gap' ) ),
);
$equal    = $this->get_attr( 'equal_height_cols' );

if ( $equal ) {
	$classes[] = 'jet-equal-cols';
}

$popup_enable     = ! empty( $settings['jet_woo_builder_cart_popup'] ) ? esc_attr( $settings['jet_woo_builder_cart_popup'] ) : false;
$popup_id         = ! empty( $settings['jet_woo_builder_cart_popup_template'] ) ? esc_attr( $settings['jet_woo_builder_cart_popup_template'] ) : '';
$carousel_enabled = filter_var( $settings['carousel_enabled'], FILTER_VALIDATE_BOOLEAN );

$carousel_enabled ? array_push( $classes, 'swiper-wrapper' ) : array_push( $classes, 'col-row' );

?>

<div class="<?php echo implode( ' ', $classes ); ?>" <?php do_action( 'jet-woo-builder/popup-generator/after-added-to-cart/cart-popup', $popup_enable, $popup_id ); ?>>