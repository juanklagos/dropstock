<?php
/**
 * Loop item title
 */

$title = jet_woo_builder_template_functions()->get_product_title();
$title = jet_woo_builder_tools()->trim_text(
	$title,
	$this->get_attr( 'title_length' ) ,
	$this->get_attr( 'title_trim_type' ),
	'...'
);
$title_link = jet_woo_builder_template_functions()->get_product_title_link();
$title_tag  = ! empty( $this->get_attr( 'title_html_tag' ) ) ? $this->get_attr( 'title_html_tag' ) : 'h5';

if ( 'yes' !== $this->get_attr( 'show_title' ) || '' === $title ) {
	return;
}

echo '<' . $title_tag . ' class="jet-woo-product-title"><a href="' . $title_link . '" rel="bookmark">' . $title . '</a></' . $title_tag . '>';

