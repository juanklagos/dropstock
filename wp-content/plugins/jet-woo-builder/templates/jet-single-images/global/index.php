<?php
/**
 * Images template
 */

$settings      = $this->get_settings();
$nav_direction = $settings['control_nav_direction'];
$nav_position  = $nav_direction === 'vertical' ? 'jet-single-images-nav-' . $settings['control_nav_v_position'] : '';

echo '<div class="jet-single-images__wrap jet-single-images-nav-' . $nav_direction . ' ' . $nav_position . '">';
	printf( '<div class="jet-single-images__loading">%s</div>', __( 'Loading...', 'jet-woo-builder' ) );
	woocommerce_show_product_images();
echo '</div>';
