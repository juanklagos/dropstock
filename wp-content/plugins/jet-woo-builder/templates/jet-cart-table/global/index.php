<?php
/**
 * Cart Table Template
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
		<tr>
			<?php
				foreach ( $table_items as $item ) {
					echo '<th class="product-' . esc_attr( $item['cart_table_items'] ) . ' elementor-repeater-item-' . $item['_id'] . '">' . esc_html__( $item['cart_table_heading_title'], 'jet-woo-builder' ) . '</th>';
				}
			?>
		</tr>
		</thead>
		<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<?php
							foreach ( $table_items as $item ) {
								switch ( $item['cart_table_items'] ) {
									case 'remove':
										echo '<td class="product-remove elementor-repeater-item-' . $item['_id'] . '">';
											echo apply_filters(
												'woocommerce_cart_item_remove_link',
												sprintf(
													'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
													esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
													esc_html__( 'Remove this item', 'woocommerce' ),
													esc_attr( $product_id ),
													esc_attr( $_product->get_sku() )
												),
												$cart_item_key
											);
										echo '</td>';
										break;

									case 'thumbnail':
										echo '<td class="product-thumbnail elementor-repeater-item-' . $item['_id'] . '">';
											$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

											if ( ! $product_permalink ) {
												echo $thumbnail;
											} else {
												printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
											}
										echo '</td>';
										break;

									case 'name':
										echo '<td class="product-name elementor-repeater-item-' . $item['_id'] . '" data-title="' . esc_html( $item['cart_table_heading_title'] ) . '">';
											if ( ! $product_permalink ) {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
											} else {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
											}

											do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

											echo wc_get_formatted_cart_item_data( $cart_item );

											if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
											}
										echo '</td>';
										break;

									case 'price':
										echo '<td class="product-price elementor-repeater-item-' . $item['_id'] . '" data-title="' . esc_html( $item['cart_table_heading_title'] ) . '">';
											echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
										echo '</td>';
										break;

									case 'quantity':
										echo '<td class="product-quantity elementor-repeater-item-' . $item['_id'] . '" data-title="' . esc_html( $item['cart_table_heading_title'] ) . '">';
											if ( $_product->is_sold_individually() ) {
												$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
											} else {
												$product_quantity = woocommerce_quantity_input(
													array(
														'input_name'   => "cart[{$cart_item_key}][qty]",
														'input_value'  => $cart_item['quantity'],
														'max_value'    => $_product->get_max_purchase_quantity(),
														'min_value'    => '0',
														'product_name' => $_product->get_name(),
													),
													$_product,
													false
												);
											}

											echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
										echo '</td>';
										break;

									case 'subtotal':
										echo '<td class="product-subtotal elementor-repeater-item-' . $item['_id'] . '" data-title="' . esc_html( $item['cart_table_heading_title'] ) . '">';
											echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
										echo '</td>';
										break;

									default:
										break;
								}
							}
						?>
					</tr>
					<?php
				}
			}
		?>

		<?php do_action( 'woocommerce_cart_contents' ); ?>

		<?php if ( $table_buttons['coupon_form']['enable'] === 'yes' || $table_buttons['update_cart_button']['enable'] === 'yes' ) : ?>

			<tr>
				<td colspan="<?php echo count( $table_items ); ?>" class="actions">

					<?php if ( wc_coupons_enabled() && $table_buttons['coupon_form']['enable'] === 'yes' ) { ?>
						<div class="coupon">
							<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( $table_buttons['coupon_form']['placeholder'], 'jet-woo-builder' ); ?>" />
							<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( $table_buttons['coupon_form']['button_text'], 'jet-woo-builder' ); ?>"><?php esc_attr_e( $table_buttons['coupon_form']['button_text'], 'jet-woo-builder' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<?php if ( $table_buttons['update_cart_button']['enable'] === 'yes' ) { ?>
						<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( $table_buttons['update_cart_button']['button_text'], 'jet-woo-builder' ); ?>"><?php esc_html_e( $table_buttons['update_cart_button']['button_text'], 'jet-woo-builder' ); ?></button>
					<?php } ?>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
