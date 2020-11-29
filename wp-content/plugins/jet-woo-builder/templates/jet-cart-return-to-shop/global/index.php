<?php
/**
 * Cart Return to Shop Template
 */

$settings    = $this->get_settings_for_display();
$button_text = esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) ) );

if ( ! empty( $settings['cart_return_to_shop_button_text'] ) ) {
	$button_text = esc_html__( $settings['cart_return_to_shop_button_text'], 'jet-woo-builder' );
}

if ( wc_get_page_id( 'shop' ) > 0 ) :
	$button_link = esc_url( wc_get_page_permalink( 'shop' ) );

	if ( ! empty( $settings['cart_return_to_shop_button_link'] ) ) {
		$button_link = esc_url( $settings['cart_return_to_shop_button_link'] );
	} ?>

	<p class="return-to-shop">
		<a class="button wc-backward" href="<?php echo $button_link; ?>">
			<?php echo $button_text; ?>
		</a>
	</p>

<?php endif; ?>