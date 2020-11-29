<?php
/**
 * Checkout Login Form Template
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ) { ?>
	<div class="woocommerce-form-login-toggle">
		<?php wc_print_notice( apply_filters( 'woocommerce_checkout_login_message', esc_html__( 'Returning customer?', 'woocommerce' ) ) . ' <a href="#" class="showlogin">' . esc_html__( 'Click here to login', 'woocommerce' ) . '</a>', 'notice' ); ?>
	</div>
	<?php

	woocommerce_login_form(
		array(
			'message'  => esc_html__( 'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.', 'woocommerce' ),
			'redirect' => wc_get_checkout_url(),
			'hidden'   => true,
		)
	);
} else {
	woocommerce_checkout_login_form();
}

