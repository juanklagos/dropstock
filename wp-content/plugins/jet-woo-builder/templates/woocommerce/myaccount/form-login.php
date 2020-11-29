<?php
/**
 * Login Form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<div class="jet-woo-builder-woocommerce-myaccount-login-page">
	<?php do_action( 'woocommerce_before_customer_login_form' ); ?>
	<div id="customer_login">
		<?php
			$template = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_form_login_template() );

			echo jet_woo_builder()->parser->get_template_content( $template );
		?>
	</div>
	<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
</div>

