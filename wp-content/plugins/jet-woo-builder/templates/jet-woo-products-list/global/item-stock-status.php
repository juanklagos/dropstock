<?php
/**
 * Loop item stock status
 */

global $product;

if ( 'yes' !== $this->get_attr( 'show_stock_status' ) ) {
	return;
}

if ( $product->is_on_backorder() ) {
	echo ! empty( $this->get_attr( 'on_backorder_status_text' ) ) ? sprintf( '<div class="jet-woo-product-stock-status jet-woo-product-stock-status__on-backorder">%s</div>', $this->get_attr( 'on_backorder_status_text' ) ) : '';
} elseif ( $product->is_in_stock() ) {
	echo ! empty( $this->get_attr( 'in_stock_status_text' ) ) ? sprintf( '<div class="jet-woo-product-stock-status jet-woo-product-stock-status__in-stock">%s</div>', $this->get_attr( 'in_stock_status_text' ) ) : '';
} else {
	echo ! empty( $this->get_attr( 'out_of_stock_status_text' ) ) ? sprintf( '<div class="jet-woo-product-stock-status jet-woo-product-stock-status__out-of-stock">%s</div>', $this->get_attr( 'out_of_stock_status_text' ) ) : '';
}
