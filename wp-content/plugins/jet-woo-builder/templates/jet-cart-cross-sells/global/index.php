<?php
/**
 * Cart Cross Sells products Template
 */

$settings = $this->get_settings_for_display();

woocommerce_cross_sell_display( '', '', $settings['cross_sell_products_orderby'], $settings['cross_sell_products_order'] );
