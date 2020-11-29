<?php
/**
 * Loop item title
 */

$title = $category->name;
$title_tag = ! empty( $this->get_attr( 'title_html_tag' ) ) ? $this->get_attr( 'title_html_tag' ) : 'h5';

if ( 'yes' !== $this->get_attr( 'show_title' ) ) {
	return;
}

echo '<' . $title_tag . ' class="jet-woo-category-title">';
echo '<a href="' . jet_woo_builder_tools()->get_term_permalink( $category->term_id ) . '" class="jet-woo-category-title__link">' . $title . '</a>';
echo '</' . $title_tag . '>';
