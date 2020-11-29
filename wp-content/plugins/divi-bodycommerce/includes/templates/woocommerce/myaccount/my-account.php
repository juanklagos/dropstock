<?php
include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

$my_acount_page_layout_before = $titan->getOption( 'my_acount_page_layout_before' );
$my_acount_page_layout_after = $titan->getOption( 'my_acount_page_layout_after' );

/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version     2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="main-content" class="bodycommerce_main_content">
<div id="et-boc" class="et-boc">
<div class="et-l et-l--body">
<?php

if ($my_acount_page_layout_before != 0) {
	?><div class="bc-account-before-after"><?php
		$my_acount_page_layout_before_display = '[showmodule id="'.$my_acount_page_layout_before.'"]';
		echo do_shortcode( ''.$my_acount_page_layout_before_display.'' );
	?></div><?php
}

wc_print_notices();
?><div class="bc-account-content-container">
	<div class="bc-account-nav">
		 <?php
/**
 * My Account navigation.
 * @since 2.6.0
 */
do_action( 'woocommerce_account_navigation' ); ?>
</div>
<div class="bc-account-content">
<div class="clearfix"></div>
	<?php
		/**
		 * My Account content.
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_account_content' );

?></div></div> <?php

		if ($my_acount_page_layout_after != 0) {
			?><div class="account-before-after"><?php
				$my_acount_page_layout_after_display = '[showmodule id="'.$my_acount_page_layout_after.'"]';
				echo do_shortcode( ''.$my_acount_page_layout_after_display.'' );
			?></div><?php
		}
	?>
</div>
</div>
</div>
<?php
	?>
