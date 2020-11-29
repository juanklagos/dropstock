<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

$checkout_page_enable = $titan->getOption( 'checkout_page_enable' );
$checkout_page_style = $titan->getOption( 'checkout_page_style' );
$divi_specific_checkout = $titan->getOption( 'divi_specific_checkout' );

$checkout_page_multistep_style = $titan->getOption( 'checkout_page_multistep_style' );

$check_other_settings_progress_bar_login_title_get = $titan->getOption( 'other_settings_progress_bar_login_title');
$check_other_settings_progress_bar_billing_title_get = $titan->getOption( 'other_settings_progress_bar_billing_title');
$check_other_settings_progress_bar_shipping_title_get = $titan->getOption( 'other_settings_progress_bar_shipping_title');
$check_other_settings_progress_bar_order_info_title_get = $titan->getOption( 'other_settings_progress_bar_order_info_title');
$check_other_settings_progress_bar_payment_info_title_get = $titan->getOption( 'other_settings_progress_bar_payment_info_title');


do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Multi Step / Accordion Login Title', $check_other_settings_progress_bar_login_title_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Multi Step 1 / Accordian Billing Title', $check_other_settings_progress_bar_billing_title_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Multi Step 2 / Accordian Shipping Title', $check_other_settings_progress_bar_shipping_title_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Multi Step 3 / Accordian Order Information Title', $check_other_settings_progress_bar_order_info_title_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Multi Step 4 / Accordian Complete Title', $check_other_settings_progress_bar_payment_info_title_get );
$check_other_settings_progress_bar_login_title = apply_filters( 'wpml_translate_single_string', $check_other_settings_progress_bar_login_title_get, 'divi-bodyshop-woocommerce', 'Multi Step / Accordion Login Title' );
$check_other_settings_progress_bar_billing_title = apply_filters( 'wpml_translate_single_string', $check_other_settings_progress_bar_billing_title_get, 'divi-bodyshop-woocommerce', 'Multi Step 1 / Accordian Billing Title' );
$check_other_settings_progress_bar_shipping_title = apply_filters( 'wpml_translate_single_string', $check_other_settings_progress_bar_shipping_title_get, 'divi-bodyshop-woocommerce', 'Multi Step 2 / Accordian Shipping Title' );
$check_other_settings_progress_bar_order_info_title = apply_filters( 'wpml_translate_single_string', $check_other_settings_progress_bar_order_info_title_get, 'divi-bodyshop-woocommerce', 'Multi Step 3 / Accordian Order Information Title' );
$check_other_settings_progress_bar_payment_info_title = apply_filters( 'wpml_translate_single_string', $check_other_settings_progress_bar_payment_info_title_get, 'divi-bodyshop-woocommerce', 'Multi Step 4 / Accordian Complete Title' );


// $check_other_settings_step_billing_title = $titan->getOption( 'other_settings_step_billing_title');
// $check_other_settings_step_order_title = $titan->getOption( 'other_settings_step_order_title');
// $check_other_settings_step_payment_title = $titan->getOption( 'other_settings_step_payment_title');
// $check_other_settings_step_different_address_title = $titan->getOption( 'other_settings_step_different_address_title');

$check_other_settings_next_button_text_get = $titan->getOption( 'other_settings_next_button_text');
$check_other_settings_previous_button_text_get = $titan->getOption( 'other_settings_previous_button_text');

do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Checkout Multi Step Next Button Text', $check_other_settings_next_button_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Checkout Multi Step Previous Button Text', $check_other_settings_previous_button_text_get );
$check_other_settings_next_button_text = apply_filters( 'wpml_translate_single_string', $check_other_settings_next_button_text_get, 'divi-bodyshop-woocommerce', 'Checkout Multi Step Next Button Text' );
$check_other_settings_previous_button_text = apply_filters( 'wpml_translate_single_string', $check_other_settings_previous_button_text_get, 'divi-bodyshop-woocommerce', 'Checkout Multi Step Previous Button Text' );


$check_checkout_onepage_columns = $titan->getOption( 'checkout_onepage_columns');
$check_checkout_onepage_style = $titan->getOption( 'checkout_onepage_style');


$multistep_order = $titan->getOption( 'multistep_order_new' );

$other_settings_multistep_val_text_get = $titan->getOption( 'other_settings_multistep_val_text' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Multi-Step Validation Error Message', $other_settings_multistep_val_text_get );
$other_settings_multistep_val_text = apply_filters( 'wpml_translate_single_string', $other_settings_multistep_val_text_get, 'divi-bodyshop-woocommerce', 'Multi-Step Validation Error Message' );

$other_settings_multistep_guest_checkout_text_get = $titan->getOption( 'other_settings_multistep_guest_checkout_text' );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Guest checkout introduction text', $other_settings_multistep_guest_checkout_text_get );
$other_settings_multistep_guest_checkout_text = apply_filters( 'wpml_translate_single_string', $other_settings_multistep_guest_checkout_text_get, 'divi-bodyshop-woocommerce', 'Guest checkout introduction text' );



$checkout_custom_layout = $titan->getOption( 'checkout_custom_layout' );

$checkout_page_shopify_enable_shipping = $titan->getOption( 'checkout_page_shopify_enable_shipping' );

$checkout_page_shopify_cart_text_get = $titan->getOption( 'checkout_page_shopify_cart_text' );
$checkout_page_shopify_customer_info_text_get = $titan->getOption( 'checkout_page_shopify_customer_info_text' );
$checkout_page_shopify_shipping_info_text_get = $titan->getOption( 'checkout_page_shopify_shipping_info_text' );
$checkout_page_shopify_payment_method_text_get = $titan->getOption( 'checkout_page_shopify_payment_method_text' );
$checkout_page_shopify_return_text_get = $titan->getOption( 'checkout_page_shopify_return_text' );
$checkout_page_shopify_continue_text_get = $titan->getOption( 'checkout_page_shopify_continue_text' );
$checkout_page_shopify_complete_text_get = $titan->getOption( 'checkout_page_shopify_complete_text' );
$checkout_page_shopify_cp_placeholder_text_get = $titan->getOption( 'checkout_page_shopify_cp_placeholder_text' );
$checkout_page_shopify_cp_apply_text_get = $titan->getOption( 'checkout_page_shopify_cp_apply_text' );




do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Shopify Style Cart', $checkout_page_shopify_cart_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Shopify Style Customer Information', $checkout_page_shopify_customer_info_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Shopify Style Shipping Information', $checkout_page_shopify_shipping_info_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Shopify Style Payment Method', $checkout_page_shopify_payment_method_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Shopify Style Return to', $checkout_page_shopify_return_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Shopify Style Continue to', $checkout_page_shopify_continue_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Shopify Style Complete Order', $checkout_page_shopify_complete_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Shopify Style Coupon Placeholder', $checkout_page_shopify_cp_placeholder_text_get );
do_action( 'wpml_register_single_string', 'divi-bodyshop-woocommerce', 'Shopify Style Coupon Apply', $checkout_page_shopify_cp_apply_text_get );
$checkout_page_shopify_cart_text = apply_filters( 'wpml_translate_single_string', $checkout_page_shopify_cart_text_get, 'divi-bodyshop-woocommerce', 'Shopify Style Cart' );
$checkout_page_shopify_customer_info_text = apply_filters( 'wpml_translate_single_string', $checkout_page_shopify_customer_info_text_get, 'divi-bodyshop-woocommerce', 'Shopify Style Customer Information' );
$checkout_page_shopify_shipping_info_text = apply_filters( 'wpml_translate_single_string', $checkout_page_shopify_shipping_info_text_get, 'divi-bodyshop-woocommerce', 'Shopify Style Shipping Information' );
$checkout_page_shopify_payment_method_text = apply_filters( 'wpml_translate_single_string', $checkout_page_shopify_payment_method_text_get, 'divi-bodyshop-woocommerce', 'Shopify Style Payment Method' );
$checkout_page_shopify_return_text = apply_filters( 'wpml_translate_single_string', $checkout_page_shopify_return_text_get, 'divi-bodyshop-woocommerce', 'Shopify Style Return to' );
$checkout_page_shopify_continue_text = apply_filters( 'wpml_translate_single_string', $checkout_page_shopify_continue_text_get, 'divi-bodyshop-woocommerce', 'Shopify Style Continue to' );
$checkout_page_shopify_complete_text = apply_filters( 'wpml_translate_single_string', $checkout_page_shopify_complete_text_get, 'divi-bodyshop-woocommerce', 'Shopify Style Complete Order' );
$checkout_page_shopify_cp_placeholder_text = apply_filters( 'wpml_translate_single_string', $checkout_page_shopify_cp_placeholder_text_get, 'divi-bodyshop-woocommerce', 'Shopify Style Coupon Placeholder' );
$checkout_page_shopify_cp_apply_text = apply_filters( 'wpml_translate_single_string', $checkout_page_shopify_cp_apply_text_get, 'divi-bodyshop-woocommerce', 'Shopify Style Coupon Apply' );


if ($divi_specific_checkout == "") {
	$divi_specific_checkout = "defalut";
}


// If it is custom checkout
if ($checkout_page_enable == "yes") {


	if ($checkout_custom_layout != "") {

		wc_print_notices();


		do_action( 'woocommerce_before_checkout_form', $checkout );

		// If checkout registration is disabled and not logged in, the user cannot checkout
		if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

		?>

		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

		<?php

	  $checkout_custom_layout_display = '[showmodule id="'.$checkout_custom_layout.'"]';
	  echo do_shortcode( ''.$checkout_custom_layout_display.'' );

		?>

		</form>

		<?php do_action( 'woocommerce_after_checkout_form', $checkout );


	}
	else {

?>

<?php
if ($checkout_page_style == "shopify" && $divi_specific_checkout == "defalut") {

	?>
	<div id="bodycommerce-shopify-checkout" class="et_pb_section">
		<div class="et_pb_row">
			<?php

	do_action( 'woocommerce_before_checkout_form', $checkout );

	// If checkout registration is disabled and not logged in, the user cannot checkout.
	if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
		echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
		return;
	}

	?>
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="et_pb_column et_pb_column_3_5">


		<ul id="bodycommerce-shopify-breadcrumbs" class="etabs">
	<li>
		<?php $cart_url = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $woocommerce->cart->get_cart_url(); ?>
		<a href="<?php echo esc_url( $cart_url ) ?>"><?php echo esc_html__( $checkout_page_shopify_cart_text, 'divi-bodyshop-woocommerce' ); ?></a>
	</li>
				<li class="tab customer_details active">
			<a href="#customer-info" data-tab="customer_details" class="bodycommerce-shoppify-next-prev-tab next-tab"><?php echo esc_html__( $checkout_page_shopify_customer_info_text, 'divi-bodyshop-woocommerce' ); ?></a>
		</li>
		<?php if ($checkout_page_shopify_enable_shipping == "1") { ?>
						<li class="tab shipping_details">
			<a href="#shipping-method" data-tab="shipping_details" class="bodycommerce-shoppify-next-prev-tab next-tab"><?php echo esc_html__( $checkout_page_shopify_shipping_info_text, 'divi-bodyshop-woocommerce' ); ?></a>
		</li>
	<?php } ?>
			<li class="tab payment_methods" >
		<a href="#payment-method" data-tab="payment_methods" class="bodycommerce-shoppify-next-prev-tab next-tab"><?php echo esc_html__( $checkout_page_shopify_payment_method_text, 'divi-bodyshop-woocommerce' ); ?></a>
	</li>
	</ul>







		<?php if ( $checkout->get_checkout_fields() ) : ?>

			<div id="customer_details" class="bodycommerce-shopify-tabs active-tab">

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>


					<?php do_action( 'woocommerce_checkout_billing' ); ?>

					<div class="bodycommerce-shoppify-bottom-controls">
							<div class="previous-button">
								<a href="<?php echo esc_url( $cart_url ) ?>">« <?php echo esc_html__( $checkout_page_shopify_return_text, 'divi-bodyshop-woocommerce' ) ?> <?php echo esc_html__( $checkout_page_shopify_cart_text, 'divi-bodyshop-woocommerce' ) ?></a>
							</div>
					 		<?php if ($checkout_page_shopify_enable_shipping == "1") { ?>
										<a href="javascript:;" data-tab="shipping_details" class="et_pb_button button bodycommerce-shoppify-next-prev-tab next-tab"><?php echo esc_html__( $checkout_page_shopify_continue_text, 'divi-bodyshop-woocommerce' ) ?> <?php echo esc_html__( $checkout_page_shopify_shipping_info_text, 'divi-bodyshop-woocommerce' ) ?>	</a>
									<?php } else { ?>
												<a href="javascript:;" data-tab="payment_methods" class="button bodycommerce-shoppify-next-prev-tab next-tab"><?php echo esc_html__( $checkout_page_shopify_continue_text, 'divi-bodyshop-woocommerce' ) ?> <?php echo esc_html__( $checkout_page_shopify_payment_method_text, 'divi-bodyshop-woocommerce' ) ?></a>
									<?php } ?>
					</div>



				</div>
				<?php if ($checkout_page_shopify_enable_shipping == "1") { ?>

				<!-- Shipping Details -->
								<div id="shipping_details" class="bodycommerce-shopify-tabs">
									<?php do_action( 'woocommerce_checkout_shipping' ); ?>

											<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

									<div class="bodycommerce-shoppify-bottom-controls">
											<div class="previous-button">
												<a href="javascript:;" data-tab="customer_details" class="bodycommerce-shoppify-next-prev-tab">« <?php echo esc_html( $checkout_page_shopify_return_text ) ?> <?php echo esc_html( $checkout_page_shopify_customer_info_text ) ?></a>
											</div>
														<a href="javascript:;" data-tab="payment_methods" class="button bodycommerce-shoppify-next-prev-tab next-tab"><?php echo esc_html__( $checkout_page_shopify_continue_text, 'divi-bodyshop-woocommerce' ) ?> <?php echo esc_html__( $checkout_page_shopify_payment_method_text, 'divi-bodyshop-woocommerce' ) ?></a>
									</div>

								</div>

				<?php } ?>


		<?php endif; ?>


		<div id="payment_methods" class="bodycommerce-shopify-tabs">

			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>


			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

			<?php
			if ( WC()->cart->needs_payment() ) {
				$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
				WC()->payment_gateways()->set_current_gateway( $available_gateways );
			} else {
				$available_gateways = array();
			}

			wc_get_template(
				'checkout/payment.php',
				array(
					'checkout'           => WC()->checkout(),
					'available_gateways' => $available_gateways,
					'order_button_text'  => apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ),
				)
			);
			 ?>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

			<div class="bodycommerce-shoppify-bottom-controls">
					<div class="previous-button">
				 <?php if ($checkout_page_shopify_enable_shipping == "1") { ?>
						<a href="javascript:;" data-tab="shipping_details" class="bodycommerce-shoppify-prev-tab bodycommerce-shoppify-next-prev-tab">« <?php echo esc_html( $checkout_page_shopify_return_text ) ?> <?php echo esc_html__( $checkout_page_shopify_shipping_info_text, 'divi-bodyshop-woocommerce' ) ?></a>
					<?php } else { ?>
						<a href="javascript:;" data-tab="customer_details" class="bodycommerce-shoppify-prev-tab bodycommerce-shoppify-next-prev-tab">« <?php echo esc_html( $checkout_page_shopify_return_text ) ?> <?php echo esc_html( $checkout_page_shopify_customer_info_text ) ?></a>
					<?php } ?>
					</div>
								<a href="javascript:;" class="button completeorder"><?php echo esc_html__( $checkout_page_shopify_complete_text, 'divi-bodyshop-woocommerce' ) ?></a>
			</div>

		 </div>




	</div>
	<div class="et_pb_column et_pb_column_2_5">

		<table id="bodycommerce-shopify-table" class="shop_table woocommerce-checkout-review-order-table">

			<tbody>

				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">


							<td class="product-thumbnail">
							<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $product_permalink ) {
								echo wp_kses_post( $thumbnail );
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
							}
							?>
							</td>

							<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
							<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
							} else {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<p>%s</p>', $_product->get_name() ), $cart_item, $cart_item_key ) );
							}

							// Meta data.
							echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

							// Backorder notification.
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>' ) );
							}
							?>
							</td>

							<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
							<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</td>

							<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
							</td>
						</tr>
						<?php
					}
				}
				?>


			</tbody>
			<tfoot>

				<tr class="cart-subtotal">
					<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
					<td><?php wc_cart_totals_subtotal_html(); ?></td>
				</tr>

				<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
					<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
						<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
					</tr>
				<?php endforeach; ?>

				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

					<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

					<?php wc_cart_totals_shipping_html(); ?>

					<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

				<?php endif; ?>

				<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
					<tr class="fee">
						<th><?php echo esc_html( $fee->name ); ?></th>
						<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
					</tr>
				<?php endforeach; ?>

				<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
					<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
						<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited ?>
							<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
								<th><?php echo esc_html( $tax->label ); ?></th>
								<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr class="tax-total">
							<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
							<td><?php wc_cart_totals_taxes_total_html(); ?></td>
						</tr>
					<?php endif; ?>
				<?php endif; ?>

				<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

				<tr class="order-total">
					<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
					<td><?php wc_cart_totals_order_total_html(); ?></td>
				</tr>

				<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

			</tfoot>
		</table>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

			<?php if (wc_coupons_enabled() ) { ?>


		<div class="bc-shopify-dummy">
			<div class="bodycommerce-shopify-coupon">
			<p class="form-row form-row-first inputcode">
							<input type="text" class="input-text coupon-module" placeholder="<?php esc_attr_e( $checkout_page_shopify_cp_placeholder_text, 'divi-bodyshop-woocommerce' ); ?>" value="" />
			</p>
							<p class="form-row form-row-last submitcode">
							<input type="button" class="button" value="<?php esc_html_e( $checkout_page_shopify_cp_apply_text, 'divi-bodyshop-woocommerce' ); ?>" />
			</p>
			</div>
							<div class="clear"></div>
							<input type="text" class="errorcode-text" value="<?php echo $other_settings_multistep_val_text ?>" hidden>
		</div>

		<script>
jQuery(document).ready(function($){
	$( ".bc-shopify-dummy .button" ).click(function() {
  var val = $( ".bc-shopify-dummy .coupon-module" ).val();
	console.log(val);
	$("#bodycommerce-shopify-coupon .coupon-module").val(val);
	$( "#bodycommerce-shopify-coupon .button" ).trigger( "click" );
});
});
		</script>

			<?php } ?>

</form>

			</div>


	<?php if (wc_coupons_enabled() ) { ?>


		<form id="bodycommerce-shopify-coupon" class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none !important;">
	<div class="bodycommerce-shopify-coupon">
	<p class="form-row form-row-first inputcode" style="display:none !important;" >
					<input type="text" onkeypress="bodycommerce_check_submit_checkout_coupon();" class="input-text coupon-module" placeholder="<?php esc_attr_e( $checkout_page_shopify_cp_placeholder_text, 'divi-bodyshop-woocommerce' ); ?>" value="" />
	</p>


	<p class="form-row form-row-last submitcode" style="display:none !important;">
					<input type="button" class="button" onclick="bodycommerce_submit_checkout_coupon();" value="<?php esc_html_e( $checkout_page_shopify_cp_apply_text, 'divi-bodyshop-woocommerce' ); ?>" />
	</p>
	</div>

			<div class="clear"></div>

			<input type="text" class="errorcode-text" value="<?php echo $other_settings_multistep_val_text ?>" hidden>
	</form>


	<?php } ?>


	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>


		</div>
	</div>

	<script>
	jQuery(document).ready(function($){

	$("#ship-to-different-address-checkbox").prop( "checked", false );


				$(document).on('touchstart click', ".previous-button .bodycommerce-shoppify-next-prev-tab" , function(event){
					jQuery('.noforward').remove();
					var datatab = $(this).attr('data-tab');
					$(".bodycommerce-shopify-tabs").hide();
					$(".bodycommerce-shopify-tabs").removeClass("active-tab");
					$(".tab").removeClass("active");

					setTimeout(
							function()
				{
					$("#" + datatab).fadeIn();
					$("#" + datatab).addClass("active-tab");
					$(".tab." + datatab).addClass("active");

					}, 200);

					if ($(window).width() < 980) {
					var fromtop = $("#bodycommerce-shopify-checkout .et_pb_column_3_5");
			    $('html,body').unbind().animate({scrollTop: $(fromtop).offset().top-50},'slow');
				} else {
						$("html, body").animate({ scrollTop: 0 }, "slow");
				}
				});

			$(document).on('touchstart click', ".bodycommerce-shoppify-next-prev-tab.next-tab" , function(event){

					var carryon = "yes";
				if ( $(".active-tab").is("#shipping_details") ) {
					 if ($('#ship-to-different-address-checkbox').is(':checked')) {
		 			$( ".active-tab .validate-required" ).each(function( index ) {
		   		var input_req = $(this).find("input").val();
		 	if (input_req == "") {
		 	carryon = "no";
			$(this).addClass("woocommerce-invalid");
		 	} else {
		 	}

		 			});
				 } else {


$( ".active-tab .woocommerce-additional-fields .validate-required" ).each(function( index ) {


	var errorcode = $(".errorcode-text").val();
	var input_req = $(this).find("input").val();


	if ( $(this).find('input[type="email"]').length ) {
	var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		var input_req_email = $(this).find('input[type="email"]').val();
		if (testEmail.test(input_req_email)) { // passes
	$(this).find("input").removeClass("validate-error");
		} else { // fails
	 	carryon = "no";
		$(this).addClass("woocommerce-invalid");
		$(this).find("input").addClass("validate-error");
		if ( jQuery(this).closest('.form-row').find('.noforward').length ) {
		}
		else {
		jQuery('.noforward').remove();
		jQuery(this).closest('.form-row').append('<span class="noforward">' + errorcode + '</span>');
		  }
		}
	}

	if ( $(this).find('input[type="tel"]').length ) {
		var input_req_email = $(this).find('input[type="tel"]').val();
		if (input_req_email.length > 4) { // passes
	$(this).find("input").removeClass("validate-error");
		} else { // fails
	 	carryon = "no";
		$(this).addClass("woocommerce-invalid");
		$(this).find("input").addClass("validate-error");
		if ( jQuery(this).closest('.form-row').find('.noforward').length ) {
		}
		else {
		jQuery('.noforward').remove();
		jQuery(this).closest('.form-row').append('<span class="noforward">' + errorcode + '</span>');
		  }
		}

	}

if ( $(this).find('input[type="checkbox"]').length ) {
if ($(this).find('input[type="checkbox"]').is(":checked")) {
} else {
jQuery('.noforward').remove();
carryon = "no";
$(this).addClass("woocommerce-invalid");
jQuery(this).closest('.form-row').append('<span class="noforward">' + errorcode + '</span>');
}
}

});


				 }
			 } else {
	 			$( ".active-tab .validate-required" ).each(function( index ) {
	   		var input_req = $(this).find("input").val();
		    var errorcode = $(".errorcode-text").val();
	 	if (input_req == "") {
	 	carryon = "no";
		$(this).addClass("woocommerce-invalid");
		$(this).find("input").addClass("validate-error");
		if ( jQuery(this).closest('.form-row').find('.noforward').length ) {
		}
		else {
		jQuery('.noforward').remove();
		jQuery(this).closest('.form-row').append('<span class="noforward">' + errorcode + '</span>');
		  }
	 	} else {

	$(this).find("input").removeClass("validate-error");
	if ( $(this).find('input[type="email"]').length ) {
	var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
		var input_req_email = $(this).find('input[type="email"]').val();
		if (testEmail.test(input_req_email)) { // passes
	$(this).find("input").removeClass("validate-error");
		} else { // fails
	 	carryon = "no";
		$(this).addClass("woocommerce-invalid");
		$(this).find("input").addClass("validate-error");
		if ( jQuery(this).closest('.form-row').find('.noforward').length ) {
		}
		else {
		jQuery('.noforward').remove();
		jQuery(this).closest('.form-row').append('<span class="noforward">' + errorcode + '</span>');
		  }
		}
	}

	if ( $(this).find('input[type="tel"]').length ) {
		var input_req_email = $(this).find('input[type="tel"]').val();
		if (input_req_email.length > 4) { // passes
	$(this).find("input").removeClass("validate-error");
		} else { // fails
	 	carryon = "no";
		$(this).addClass("woocommerce-invalid");
		$(this).find("input").addClass("validate-error");
		if ( jQuery(this).closest('.form-row').find('.noforward').length ) {
		}
		else {
		jQuery('.noforward').remove();
		jQuery(this).closest('.form-row').append('<span class="noforward">' + errorcode + '</span>');
		  }
		}

	}

	if ( $(this).find('input[type="checkbox"]').length ) {

if ($(this).find('input[type="checkbox"]').is(":checked")) {
} else {
carryon = "no";
$(this).addClass("woocommerce-invalid");
jQuery(this).closest('.form-row').append('<span class="noforward">' + errorcode + '</span>');
}

}

	 	}

	 			});

			 }



			if (carryon == "yes") {

	    jQuery('.noforward').remove();
			var datatab = $(this).attr('data-tab');
			$(".bodycommerce-shopify-tabs").hide();
			$(".bodycommerce-shopify-tabs").removeClass("active-tab");
			$(".tab").removeClass("active");

			setTimeout(
					function()
		{
			$("#" + datatab).fadeIn();
			$("#" + datatab).addClass("active-tab");
			$(".tab." + datatab).addClass("active");

			}, 200);

			if ($(window).width() < 980) {
			var fromtop = $("#bodycommerce-shopify-checkout .et_pb_column_3_5");
	    $('html,body').unbind().animate({scrollTop: $(fromtop).offset().top-50},'slow');
		} else {
				$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	} else {
			$("html, body").animate({ scrollTop: 0 }, "slow");
	}


		});


		$(document).on('touchstart click', ".completeorder" , function(event){
		$('#place_order').trigger('click');
		});



	});

	function bodycommerce_check_submit_checkout_coupon() {
			jQuery(this).keypress(function (e) {
					if (e.which == 13) {
							bodycommerce_submit_checkout_coupon();
					}
			});
	}

	function bodycommerce_submit_checkout_coupon() {
			if (jQuery('.coupon-module').length) {
					jQuery('.coupon-module').parent().removeClass('woocommerce-invalid').removeClass('woocommerce-validated');

					var coupon = jQuery('.coupon-module').val();

					if (coupon != '') {
							jQuery('#coupon_code').val(coupon);
							jQuery('.checkout_coupon').submit();
					} else {
							jQuery('.coupon-module').parent().addClass('woocommerce-invalid').removeClass('woocommerce-validated');
					}
			}

			return false;
	}
	</script>

<?php


} else if ($checkout_page_style == "multistep" && $divi_specific_checkout == "defalut") {

// do_action( 'woocommerce_before_checkout_form', $checkout );
/**** MULTI STEP START *****/

// woocommerce_enable_checkout_login_reminder

$get_woocommerce_enable_checkout_login_reminder = get_option('woocommerce_enable_checkout_login_reminder', null);

if ( $get_woocommerce_enable_checkout_login_reminder == "no" && !is_user_logged_in() ) {

	$bodycommerce_login = "none";
	$bodycommerce_select_div = "class='selected stepone active'";
	$bodycommerce_columns ="four";

} else if(!is_user_logged_in()) {
	$bodycommerce_not_logged_in = "class='selected stepnone active'";
	$bodycommerce_columns ="five";
	$bodycommerce_select_div = "class='stepone'";
}  else {
	$bodycommerce_login = "none";
	$bodycommerce_select_div = "class='selected stepone active'";
	$bodycommerce_columns ="four";
}

	$shipping_enabled = get_option( 'woocommerce_ship_to_countries' );

	if ($shipping_enabled == "disabled") {
		$datastep = "2";
		$datastep2 = "3";
		$cssstep = "steptwo";
		$cssstep2 = "stepthree";
	}
	else {
		$datastep = "3";
		$datastep2 = "4";
		$cssstep = "stepthree";
		$cssstep2 = "stepfour";
	}

	 ?>
<div class="checkout-area">

<?php if ($checkout_page_multistep_style == "circles"){?>
<ul id="progressbar" class="<?php echo $bodycommerce_columns ?> multi-circles">

		<li style="display:<?php echo (isset($bodycommerce_login) && !empty($bodycommerce_login))?$bodycommerce_login:''; ?>;" <?php echo (isset($bodycommerce_not_logged_in) && !empty($bodycommerce_not_logged_in))?$bodycommerce_not_logged_in:'';?> data-step="0"><span><?php _e( $check_other_settings_progress_bar_login_title, 'divi-bodyshop-woocommerce' ); ?></span></li>
		<li <?php echo (isset($bodycommerce_select_div) && !empty($bodycommerce_select_div))?$bodycommerce_select_div:''; ?> data-step='1'><span> <?php _e( $check_other_settings_progress_bar_billing_title, 'divi-bodyshop-woocommerce' ); ?></span> </li>

<?php if ($shipping_enabled == "disabled") {
} else { ?>
		<li data-step='2' class='steptwo'><span><?php _e( $check_other_settings_progress_bar_shipping_title, 'divi-bodyshop-woocommerce' ); ?></span></li>
<?php } ?>

		<li  data-step='<?php echo $datastep; ?>' class='<?php echo $cssstep; ?>'><span><?php _e( $check_other_settings_progress_bar_order_info_title, 'divi-bodyshop-woocommerce' ); ?></span></li>
		<li  data-step='<?php echo $datastep2; ?>' class='<?php echo $cssstep2; ?>'><span><?php _e( $check_other_settings_progress_bar_payment_info_title, 'divi-bodyshop-woocommerce' ); ?></span></li>

	</ul>
<?php }
else if ($checkout_page_multistep_style == "arrows") {
?>
<ul id="progressbar" class="arrow <?php echo $bodycommerce_columns ?>">

		<li style="display:<?php echo (isset($bodycommerce_login) && !empty($bodycommerce_login))?$bodycommerce_login:''; ?>;" <?php echo (isset($bodycommerce_not_logged_in) && !empty($bodycommerce_not_logged_in))?$bodycommerce_not_logged_in:'';?> data-step="0">
<div class="arrow-outer">
	<div class="arrow-text">
			<?php _e( $check_other_settings_progress_bar_login_title, 'divi-bodyshop-woocommerce' ); ?>
		</div>
</div>
		</li>
		<li <?php echo (isset($bodycommerce_select_div) && !empty($bodycommerce_select_div))?$bodycommerce_select_div:''; ?> data-step='1'>
			<div class="arrow-outer">
				<div class="arrow-text">
				<?php _e( $check_other_settings_progress_bar_billing_title, 'divi-bodyshop-woocommerce' ); ?>
					</div>
			</div>
		</li>

		<?php if ($shipping_enabled == "disabled") {
		} else { ?>

		<li data-step='2' class='steptwo'>
			<div class="arrow-outer">
				<div class="arrow-text">
				<?php _e( $check_other_settings_progress_bar_shipping_title, 'divi-bodyshop-woocommerce' ); ?>
					</div>
			</div>
</li>
<?php } ?>


		<li  data-step='<?php echo $datastep; ?>' class='<?php echo $cssstep; ?>'>
			<div class="arrow-outer">
				<div class="arrow-text">
				<?php _e( $check_other_settings_progress_bar_order_info_title, 'divi-bodyshop-woocommerce' ); ?>
					</div>
			</div>
		</li>
		<li  data-step='<?php echo $datastep2; ?>' class='<?php echo $cssstep2; ?>'>
			<div class="arrow-outer">
				<div class="arrow-text">
							<?php _e( $check_other_settings_progress_bar_payment_info_title, 'divi-bodyshop-woocommerce' ); ?>
					</div>
			</div>
		</li>

	</ul>
<?php
}
else {
	# code...
}

if ( $get_woocommerce_enable_checkout_login_reminder == "no" && !is_user_logged_in() ) {
	}
	else if(!is_user_logged_in()) {
?>
	<div class="login_form checkoutsection active" id="pmsc_0">

		<?php
		woocommerce_login_form(
		                    array(
		                        'message'  => __( $other_settings_multistep_guest_checkout_text, 'woocommerce' ),
		                        'redirect' => wc_get_page_permalink( 'checkout' ),
		                        'hidden'   => false
		                    )
		                );
		?>

	</div>

	<?php
}
else {
	# code...
}

		// If checkout registration is disabled and not logged in, the user cannot checkout
		if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
			echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
			return;
		}

		?>

		<div class="pmsc_coupan_form">

			<?php do_action('bodycommerce_before_checkout_coupon_form');?>

		</div>


		<form id="multistep" name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

			<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

<?php if ( $get_woocommerce_enable_checkout_login_reminder == "yes" && !is_user_logged_in() ) { ?>
				<div class="col-1_billing ui-tabs-panel checkoutsection" id='pmsc_1' style="display:none">
<?php } else if ( $get_woocommerce_enable_checkout_login_reminder == "no" && !is_user_logged_in() ) { ?>
				<div class="col-1_billing ui-tabs-panel checkoutsection active" id='pmsc_1' style="display:none">
<?php
} else { ?>
				<div class="col-1_billing ui-tabs-panel checkoutsection active" id='pmsc_1' style="display:none">

<?php } ?>


<?php

if (empty($multistep_order)) {
	$multistep_order = array ("value2", "value3", "value4");
}

if ($multistep_order[0] == "value2") {
do_action( 'woocommerce_checkout_billing' );
}
elseif ($multistep_order[0] == "value3") {
	echo do_action( 'bodycommerce_checkoutshipping' );
}
elseif ($multistep_order[0] == "value4") {
echo do_action("bodycommerce_checkoutorder");
}
else {
do_action( 'woocommerce_checkout_before_customer_details' );
	echo do_action("bodycommerce_checkoutbilling");
}

 ?>


				</div>

<?php
/////////////////
// SHIPPING START
/////////////////
$shipping_enabled = get_option( 'woocommerce_ship_to_countries' );

if ($shipping_enabled == "disabled") {
	$id_after = "pmsc_2";
	$id_after2 = "pmsc_3";
}
else {
	$id_after = "pmsc_3";
	$id_after2 = "pmsc_4";
?>

				<div class="col-2_shipping ui-tabs-panel ui-tabs-hide checkoutsection" id="pmsc_2" style="display:none">

					<?php

					if ($multistep_order[1] == "value2") {
					do_action( 'woocommerce_checkout_before_customer_details' );
					echo do_action("bodycommerce_checkoutbilling");
					}
					elseif ($multistep_order[1] == "value3") {
						echo do_action( 'bodycommerce_checkoutshipping' );
					}
					elseif ($multistep_order[1] == "value4") {
					echo do_action("bodycommerce_checkoutorder");
					}
					else {
						echo do_action("bodycommerce_checkoutshipping");
					}


				   ?>
			   </div>

				 <?php
				 }
/////////////////
// SHIPPING END
/////////////////
				 ?>

				<?php endif; ?>




			   <div id="<?php echo $id_after; ?>" class="woocommerce-checkout-review-order checkoutsection" style="display:none">

<?php

if ($multistep_order[2] == "value2") {
do_action( 'woocommerce_checkout_before_customer_details' );
echo do_action("bodycommerce_checkoutbilling");
}
elseif ($multistep_order[2] == "value3") {
	echo do_action( 'bodycommerce_checkoutshipping' );
}
elseif ($multistep_order[2] == "value4") {
echo do_action("bodycommerce_checkoutorder");
}
else {
	echo do_action("bodycommerce_checkoutorder");
}

 ?>

				</div>

				<div class="ui-tabs-panel ui-tabs-hide checkoutsection" id="<?php echo $id_after2; ?>" style="display:none">

					<h3 id="phoen_order_review_heading"></h3>

					<?php do_action( 'bodycommerce_checkout_order_payment' ); ?>


				</div>

				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>


		</form>
		<div>
			<button name="prev" style="display:none" class="button et_pb_button bodyprev"><?php _e( $check_other_settings_previous_button_text, 'divi-bodyshop-woocommerce' ); ?></button>
			<button name="next" class="button et_pb_button bodynext"><?php _e( $check_other_settings_next_button_text, 'divi-bodyshop-woocommerce' ); ?></button>
		</div>

<input type="text" class="errorcode-text" value="<?php echo $other_settings_multistep_val_text ?>" hidden>

		<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</div>

<?php

/***** MULTISTEP END *****/
}
else if ( $checkout_page_style == "multistep" && $divi_specific_checkout == "divienginestyle" ) {


wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</div>


</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout );


}
else if ($checkout_page_style == "accordian") {

/***** ACCORDIAN START *****/


$get_woocommerce_enable_checkout_login_reminder = get_option('woocommerce_enable_checkout_login_reminder', null);

if ( $get_woocommerce_enable_checkout_login_reminder == "no" && !is_user_logged_in() ) {
$bodycommerce_login = "none";
$bodycommerce_logged_in = "et_pb_accordion_item_0";
$bodycommerce_logged_in_first = "et_pb_toggle_open";
}
else if(!is_user_logged_in()) {
$bodycommerce_not_logged_in = "et_pb_accordion_item_0";
$bodycommerce_not_logged_in_first = "et_pb_toggle_open";
$bodycommerce_logged_in_first = "et_pb_toggle_close";
}else{
$bodycommerce_login = "none";
$bodycommerce_logged_in = "et_pb_accordion_item_0";
$bodycommerce_logged_in_first = "et_pb_toggle_open";
}?>
<div class="db_accordian_checkout checkout-area">
<div class="et_pb_module et_pb_accordion  et_pb_accordion_0">



<div class="et_pb_module et_pb_toggle <?php echo (isset($bodycommerce_not_logged_in_first) && !empty($bodycommerce_not_logged_in_first))?$bodycommerce_not_logged_in_first:''; ?> <?php echo (isset($bodycommerce_not_logged_in) && !empty($bodycommerce_not_logged_in))?$bodycommerce_not_logged_in:''; ?>"  style="display:<?php echo (isset($bodycommerce_login) && !empty($bodycommerce_login))?$bodycommerce_login:''; ?>;">
<h5 class="et_pb_toggle_title"><?php echo $check_other_settings_progress_bar_login_title ?></h5>
<div class="et_pb_toggle_content clearfix">
	<?php
	woocommerce_login_form(
											array(
													'message'  => __( $other_settings_multistep_guest_checkout_text, 'woocommerce' ),
													'redirect' => wc_get_page_permalink( 'checkout' ),
													'hidden'   => false
											)
									);
	?>
</div>
</div>

<div class="pmsc_coupan_form">

	<?php do_action('bodycommerce_before_checkout_coupon_form');?>

</div>

		<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

<div class="et_pb_module et_pb_toggle <?php echo (isset($bodycommerce_logged_in_first) && !empty($bodycommerce_logged_in_first))?$bodycommerce_logged_in_first:''; ?> <?php echo (isset($bodycommerce_logged_in) && !empty($bodycommerce_logged_in))?$bodycommerce_logged_in:''; ?>">
<h5 class="et_pb_toggle_title"><?php echo $check_other_settings_progress_bar_billing_title ?></h5>
<div class="et_pb_toggle_content clearfix">



<?php do_action( 'woocommerce_checkout_billing' ); ?>



</div>
</div>

<?php
$shipping_enabled = get_option( 'woocommerce_ship_to_countries' );

if ($shipping_enabled == "disabled") {

}
else {

?>

<div class="et_pb_module et_pb_toggle et_pb_toggle_close">
<h5 class="et_pb_toggle_title"><?php echo $check_other_settings_progress_bar_shipping_title ?></h5>
<div class="et_pb_toggle_content clearfix">

						<?php

						do_action( 'woocommerce_before_checkout_shipping_form' );
						do_action( 'woocommerce_checkout_shipping' );


					   ?>
</div>
</div>

<?php } ?>

<div class="et_pb_module et_pb_toggle et_pb_toggle_close">
<h5 class="et_pb_toggle_title"><?php echo $check_other_settings_progress_bar_order_info_title ?></h5>
<div class="et_pb_toggle_content clearfix">
<?php	do_action( 'woocommerce_checkout_after_customer_details' ); ?>
<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				   <h3 id="order_review_heading"></h3>


				   <div class="coupan_form">

						<?php do_action( 'bodycommerce_checkout_order_review' ); ?>

					</div>



					<input type="checkbox" name="payment_method" value="" data-order_button_text="" style="display: none;" />
</div>
</div>

<div class="et_pb_module et_pb_toggle et_pb_toggle_close">
<h5 class="et_pb_toggle_title"><?php echo $check_other_settings_progress_bar_payment_info_title ?></h5>
<div class="et_pb_toggle_content clearfix">
	<h3 id="phoen_order_review_heading"></h3>

	<?php do_action( 'bodycommerce_checkout_order_payment' ); ?>
	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
</div>
</div>




</form>


</div>
</div>

<?php
/***** ACCORDIAN END *****/
}

else if ($checkout_page_style == "one-page") {

if($check_checkout_onepage_columns == "1") {
	$check_checkout_onepage_columns_display = "et_pb_column_4_4";
}
else {
	$check_checkout_onepage_columns_display = "et_pb_column_1_2";
}

	// BASKET
?>

<div class="et_pb_row" style="width: 100%;max-width: 100%;">

<div class="et_pb_column <?php echo $check_checkout_onepage_columns_display ?>">

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove">&nbsp;</th>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
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

						<td class="product-remove">
							<?php
								// @codingStandardsIgnoreLine
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</td>

						<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo wp_kses_post( $thumbnail );
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
						}
						?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>' ) );
						}
						?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						} else {
							$product_quantity = woocommerce_quantity_input( array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $_product->get_max_purchase_quantity(),
								'min_value'    => '0',
								'product_name' => $_product->get_name(),
							), $_product, false );
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">



					<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

</div>


<div class="checkout-area" style="padding: 0;">
<?php if ($check_checkout_onepage_style == "default") { ?>


<div class="et_pb_column <?php echo $check_checkout_onepage_columns_display ?>">
<?php
// CHECKOUT
wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout );
?>

</div>

<?php } else if ($check_checkout_onepage_style == "payment-right") { ?>


<div class="et_pb_column <?php echo $check_checkout_onepage_columns_display ?>">
<?php


wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

<div>
<div class="et_pb_row" style="width: 100%;max-width: 100%;">

<div class="et_pb_column et_pb_column_1_2">
	<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

	<div class="col1-set" id="customer_details">
		<div class="col-1">
			<?php do_action( 'woocommerce_checkout_billing' ); ?>
		</div>

		<div class="col-1">
			<?php do_action( 'woocommerce_checkout_shipping' ); ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

<?php endif; ?>
</div>

<div class="et_pb_column et_pb_column_1_2" style="margin-right: 0 !important;">

	<?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="itsmshop_placeorder button alt" id="place_order" value="Place order" data-value="Place order" style="display: none;">Place order</button>' ); // @codingStandardsIgnoreLine ?>




	<div id="order_review" class="woocommerce-checkout-review-order">
		<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>


	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

</div>

</div>
</div>


</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout );

?>

</div>

<?php
}

?>

</div>
</div>

<?php

}
else if ($checkout_page_style == "enigne") {


wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout );


}
else if ($checkout_page_style == "payment-right") {


wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

?>

<div class="checkout-area">
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

<div class="et_pb_section" style="padding: 0 !important;">
<div class="et_pb_row" style="width: 100%;max-width: 100%;">

<div class="et_pb_column et_pb_column_1_2">
	<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

	<div class="col1-set" id="customer_details">
		<div class="col-1">
			<?php do_action( 'woocommerce_checkout_billing' ); ?>
		</div>

		<div class="col-1">
			<?php do_action( 'woocommerce_checkout_shipping' ); ?>
		</div>
	</div>

	<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

<?php endif; ?>
</div>

<div class="et_pb_column et_pb_column_1_2" style="margin-right: 0 !important;">

	<?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="itsmshop_placeorder button alt" id="place_order" value="Place order" data-value="Place order" style="display: none;">Place order</button>' ); // @codingStandardsIgnoreLine ?>




	<div id="order_review" class="woocommerce-checkout-review-order">
		<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>


	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

</div>

</div>
</div>


</form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout );


}
else {
	# code...
}

}
}
// ELSE NO CUSTOM CHECKOUT
else {


	do_action( 'woocommerce_before_checkout_form', $checkout );

	// If checkout registration is disabled and not logged in, the user cannot checkout.
	if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
		echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
		return;
	}

	?>

	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

		<?php if ( $checkout->get_checkout_fields() ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div class="col2-set" id="customer_details">
				<div class="col-1">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
				</div>

				<div class="col-2">
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>
			</div>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<?php endif; ?>

		<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

		<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

	</form>

	<?php do_action( 'woocommerce_after_checkout_form', $checkout );

}
?>
