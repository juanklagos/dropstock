<?php
/**
 * Empty cart page template
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="jet-woo-builder-woocommerce-empty-cart">
	<?php
		$template = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_empty_cart_template() );

		echo jet_woo_builder()->parser->get_template_content( $template, true );
	?>
</div>
