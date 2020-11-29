<?php

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	get_header( 'shop' );

	do_action( 'jet-woo-builder/full-width-page/before-content' );

	while ( have_posts() ) :
		the_post();

		include jet_woo_builder()->get_template( 'woocommerce/content-single-product.php' );

	endwhile;

	do_action( 'jet-woo-builder/full-width-page/after_content' );

	get_footer( 'shop' );