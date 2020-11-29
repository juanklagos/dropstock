<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce-builder-elementor-templates/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 9.9.9.9
 */

defined( 'ABSPATH' ) || exit;

global $product;

$theme = wc_get_theme_slug_for_templates();
?>

<?php
	/**
	 * Hook: woocommerce_before_single_product.
	 *
	 * @hooked wc_print_notices - 10
	 */
	do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 
	 $class = 'dtwcbe-product-page elementor summary';
	 if( $theme == 'jupiter' ){
	 	$class .=' mk-product style-default';
	 }
	 if( $theme == 'superfood' ){
	 	$class .=' eltdf-single-product-content';
	 }
	 
	 $class = apply_filters('dtwcbe_woocommerce_page_class',$class);
?>
<?php 
if( $theme == 'salient' || $theme == 'ic' ){
	$nectar_options        = get_nectar_theme_options(); 
	$product_style         = (!empty($nectar_options['product_style'])) ? $nectar_options['product_style'] : 'classic';
	$product_gallery_style = (!empty($nectar_options['single_product_gallery_type'])) ? $nectar_options['single_product_gallery_type'] : 'default';
	$product_hide_sku      = (!empty($nectar_options['woo_hide_product_sku'])) ? $nectar_options['woo_hide_product_sku'] : 'false';
?>
<div itemscope data-project-style="<?php echo esc_attr($product_style); ?>" data-hide-product-sku="<?php echo esc_attr($product_hide_sku); ?>" data-gallery-style="<?php echo esc_attr($product_gallery_style); ?>" data-tab-pos="<?php echo (!empty($nectar_options['product_tab_position'])) ? esc_attr($nectar_options['product_tab_position']) : 'default'; ?>" id="product-<?php the_ID(); ?>" <?php wc_product_class($class, $product); ?>>
<?php 
}else{ ?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( $class, $product ); ?>>
<?php } ?>
	<?php
	/**
	 * DTWCBE_Single_Product_Elementor Hooks
	 *
	 * @hooked DTWCBE_Single_Product_Elementor -> the_product_page_content() - 10.
	 * @hooked DTWCBE_Single_Product_Elementor -> product_data() - 30.
	 */
	do_action( 'dtwcbe_product_elementor' );
	?>
</div>