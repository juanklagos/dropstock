<?php
/**
 * Archive category item template
 */
?>

<li <?php wc_product_cat_class( ' jet-woo-builder-archive-item-' . $category->term_id, $category ); ?>>
	<?php
		$template = apply_filters( 'jet-woo-builder/current-template/template-id', jet_woo_builder_integration_woocommerce()->get_current_archive_category_template() );
		$content  = jet_woo_builder()->parser->get_template_content( $template );

		echo apply_filters( 'jet-woo-builder/elementor-views/frontend/archive-item-content', $content, $template, $category );
	?>
</li>