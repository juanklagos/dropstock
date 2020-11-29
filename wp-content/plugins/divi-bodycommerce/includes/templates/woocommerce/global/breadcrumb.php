<?php

include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

$other_settings_breadcrumb_remove_title = $titan->getOption( 'other_settings_breadcrumb_remove_title' );
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo $wrap_before;


			if ($other_settings_breadcrumb_remove_title == 1) {
		?>
		<style>
		.breadcrumb-item:nth-last-child(2) .delimiter  {display: none !important;}
		</style>
		<?php } else {}


	foreach ( $breadcrumb as $key => $crumb ) {

			echo '<span class="breadcrumb-item">';
		echo $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			if ($other_settings_breadcrumb_remove_title == 1) {

			} else {
			echo esc_html( $crumb[0] );
		}
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
					echo '<span class="delimiter">';
			echo $delimiter;
						echo '</span>';
		}

			echo '</span>';
	}

	echo $wrap_after;

}
