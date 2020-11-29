<?php
/**
 * Cart page template
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

?>

<div class="jet-woo-builder-woocommerce-cart">
	<?php
		wc_print_notices();

		$template = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_cart_template() );

		echo jet_woo_builder()->parser->get_template_content( $template );
	?>
</div>

<?php

do_action('woocommerce_after_cart');
