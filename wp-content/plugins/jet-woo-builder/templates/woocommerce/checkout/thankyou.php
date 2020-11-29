<?php
/**
 * Thank you page
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="jet-woo-builder-woocommerce-thankyou woocommerce-order">

	<?php
		$template = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_thankyou_template() );

		echo jet_woo_builder()->parser->get_template_content( $template );
	?>

</div>
