<?php
/**
 * Checkout Form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'jet-woo-builder' ) ) );
	return;
}

?>
<div class="jet-woo-builder-woocommerce-checkout">
	<?php
		$template     = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_checkout_template() );
		$top_template = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_top_checkout_template() );

		if ( $top_template ) {
			echo jet_woo_builder()->parser->get_template_content( $top_template );
		} else { ?>
			<section class="elementor-section-boxed elementor-section" data-element_type="section">
				<div class="elementor-container elementor-column-gap-default">
					<?php echo ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0', '<' ) ) ? '<div class="elementor-row">' : '' ?>
						<div class="elementor-element elementor-element-c5165a6 elementor-column elementor-col-100 elementor-top-column" data-id="c5165a6" data-element_type="column">
							<?php echo ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0', '<' ) ) ? '<div class="elementor-column-wrap  elementor-element-populated">' : '' ?>
								<div class="elementor-widget-wrap">
									<?php
										woocommerce_checkout_coupon_form();
										woocommerce_checkout_login_form();
									?>
								</div>
							<?php echo ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0', '<' ) ) ? '</div>' : '' ?>
						</div>
					<?php echo ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0', '<' ) ) ? '</div>' : '' ?>
				</div>
			</section>
		<?php }
	?>

	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
		<?php echo jet_woo_builder()->parser->get_template_content( $template ); ?>
		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
	</form>

</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
