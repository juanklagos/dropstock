<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

class DEBC_INIT{

	protected static $required_item = array();
	public static $product_layout_id = '0';
	public static $page_layout 	= false;
	public static $product_builder_used = 'divi_library';
	public $layout_type = false;
	public static $plugin_settings = false;
	public static $notices = '';

	public function __construct(){

		// on plugin activation
		register_activation_hook( DE_DB_WOO_URL . 'divi-bodyshop-woocommerce.php', array( $this, 'on_plugin_activation' ) );

		if( get_transient( 'divi_woocommerce_required_check' ) ){
			add_action( 'admin_notices', array( $this, 'woocommerce_divi_are_required_notice_activation' ) );
			delete_transient( 'divi_woocommerce_required_check' );
		}

		// enqueue scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 99 );


		// clear modules cache
		add_action( 'et_builder_ready', function(){
			add_action( 'admin_head', array( $this, 'clear_modules_cache' ), 999 );
		} );

		// add product vb assets
		add_action( 'wp_footer', array( $this, 'load_product_vb_assets' ) );
		add_filter( 'et_pb_templates_loading_amount', function(){ return 57; } );

	}


	public function clear_modules_cache(){
	?>
		<script>
			var module_start = 'et_pb_templates_et_pb_db_';

			var MOD_ARRAY = [
				module_start + 'woo_view_order',
				module_start + 'action_shortcode',
				module_start + 'add_info',
				module_start + 'attribute',
				module_start + 'breadcrumbs',
				module_start + 'content',
				module_start + 'images',
				module_start + 'atc',
				module_start + 'meta',
				module_start + 'pro_navigation',
				module_start + 'price',
				module_start + 'before',
				module_start + 'product_summary',
				module_start + 'rating',
				module_start + 'related_products',
				module_start + 'reviews',
				module_start + 'short_desc',
				module_start + 'tabs',
				module_start + 'product_title',
				module_start + 'upsell',
				module_start + 'account_nav',
				module_start + 'woo_avatar',
				module_start + 'woo_downloads',
				module_start + 'woo_edit_account',
				module_start + 'woo_edit_addresses',
				module_start + 'woo_user_name',
				module_start + 'sharing',
				module_start + 'shop_cat_title',
				module_start + 'shop_cat_loop',
				module_start + 'shop_loop',
				module_start + 'shop_after',
				module_start + 'shop_button',
				module_start + 'shop_thumbnail',
				module_start + 'woo_addresses',
				module_start + 'woo_orders',
				module_start + 'woo_get_name',
				module_start + 'cart_products',
				module_start + 'cart_total',
				module_start + 'login_form',
				module_start + 'register_form',
				module_start + 'products_search',
				module_start + 'notices',
				module_start + 'product_carousel',
				module_start + 'product_slider',
				module_start + 'pro_before',
				module_start + 'thankyou_overview',
				module_start + 'thankyou_details',
				module_start + 'thankyou_cust_details',
				module_start + 'thankyou_payment_details',
				module_start + 'login_password_lost',
				module_start + 'login_password_confirmation',
				module_start + 'login_password_reset',
				'et_pb_templates_et_db_stock_status',
			];

			for(var module in localStorage){
				if(MOD_ARRAY.indexOf(module) != -1){
					localStorage.removeItem(module);
				}
			}
		</script>
	<?php
	}




	// load front end scripts
	public function load_scripts(){
		wp_enqueue_script( 'bodycommerce-general-js', DE_DB_WOO_URL . '/scripts/frontend-general.min.js', array( 'jquery' ), DE_DB_WOO_VERSION, true );
	}


	// buffering woocommerce functions
	public static function content_buffer( $func ){

		$output = '';
		if( function_exists( $func ) ){
			ob_start();
			$func();
			$output = ob_get_contents();
			ob_end_clean();
		}
		return $output;

	}

	// render ET font icons content css property
	public static function et_icon_css_content( $font_icon ){
		$icon = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $font_icon ) );

		return '\\' . $icon;
	}



	// load the visual builder assets
	public function load_product_vb_assets(){
		if( class_exists( 'woocommerce' ) && isset( $_GET['et_fb'] ) && (int)$_GET['et_fb'] == 1 ){
			global $product;

			if( is_product() ){

				// remove the default additional info heading
				add_filter( 'woocommerce_product_additional_information_heading', function(){
					return false;
				} );

				// product categories
				if( version_compare( WC()->version, '3.0.0', '>=' ) ){
					$categories = wc_get_product_category_list( get_the_ID(), ' / ', '<div class="product_categories"><span class="posted_in">', '</span></div>' );
				}else{
					$categories = $product->get_categories( ' / ', '<div class="product_categories"><span class="posted_in">', '</span></div>' );
				}

				// product featured image
				if( has_post_thumbnail() ){
					$featured_image = get_the_post_thumbnail_url();
					$has_featured_image = '1';
				}else{
					$featured_image = esc_url( wc_placeholder_img_src() );
					$has_featured_image = '0';
				}

				// product gallery images
				if( version_compare( WC()->version, '3.0.0', '>=' ) ){
					$attachment_ids = $product->get_gallery_image_ids();
				}else{
					$attachment_ids = $product->get_gallery_attachment_ids();
				}

				$attachment_urls = array();

				if( count( $attachment_ids ) ){

					$attachment_urls[] = $featured_image;

					foreach( $attachment_ids as $id ){
						if( count( $image = wp_get_attachment_image_src( $id, 'full' ) ) ){
							$attachment_urls[] = esc_url( $image[0] );
						}
					}
				}

				// product reviews
				$product_reviews = comments_open( get_the_ID() ) ? self::content_buffer( 'comments_template' ) : '';

				$helpers = array(
					'is_product'			=> 1,
					'title' 				=> self::content_buffer( 'woocommerce_template_single_title' ),
					'additional_info' 		=> self::content_buffer( 'woocommerce_product_additional_information_tab' ),
					'product_excerpt'		=> self::content_buffer( 'woocommerce_template_single_excerpt' ),
					'product_meta'			=> self::content_buffer( 'woocommerce_template_single_meta' ),
					'product_price'			=> self::content_buffer( 'woocommerce_template_single_price' ),
					'product_rating'		=> self::content_buffer( 'woocommerce_template_single_rating' ),
					'product_cats'			=> $categories,
					'featured_image'		=> $featured_image,
					'has_featured_image'	=> $has_featured_image,
					'product_gallery_images' => $attachment_urls,
					'product_reviews'		=> $product_reviews,
				);


			}else{
				$helpers = array(
					'is_product' 	=> 0,
					'error_message' => esc_html__( 'This module works only on product pages.', 'divi-bodyshop-woocommerce' ),
				);
			}
			$helpers['path_url'] = DE_DB_WOO_URL;

			// breadcrumb
			$helpers['breadcrumb'] = self::content_buffer( 'woocommerce_breadcrumb' );

			/* Translated text */
			$produtc_title 		=  esc_html__( 'Product Title!', 'divi-bodyshop-woocommerce' );
			$helpers['text'] 	=  array(
				'quantity' 			=> esc_html__( 'Quantity', 'woocommerce' ),
				'color' 			=> esc_html__( 'Color', 'divi-bodyshop-woocommerce' ),
				'size' 				=> esc_html__( 'Size', 'divi-bodyshop-woocommerce' ),
				'choose_option' 	=> __( 'Choose an option', 'woocommerce' ),
				'variation_desc' 	=> esc_html__( 'Here will be the selected variation description if you set it in the product editing page.', 'divi-bodyshop-woocommerce' ),
				'instock'			=> __( 'In stock', 'woocommerce' ),
				'add_to_cart' 		=> __( 'Add to cart', 'woocommerce' ),
				'view_cart' 		=> esc_html__( 'View cart', 'woocommerce' ),
				'notice' 			=> esc_html__( 'The product has been added to your cart.', 'divi-bodyshop-woocommerce' ),
				'product_title'		=> $produtc_title,
				'product_cats'		=> '<a href="#">' . esc_html__( 'Category Name', 'divi-bodyshop-woocommerce' ) . '</a>' . ' / ' . '<a href="#">' . esc_html__( 'Another Category', 'divi-bodyshop-woocommerce' ) . '</a>',
				'description'		=> esc_html__( 'Description', 'woocommerce' ),
				'additional_info'	=> esc_html__( 'Additional information', 'woocommerce' ),
				'reviews'			=> esc_html__( 'Reviews', 'woocommerce' ),
				'sku'				=> esc_html__( 'SKU', 'woocommerce' ),
				'categories'		=> esc_html__( 'Categories', 'woocommerce' ),
				'tags'				=> esc_html__( 'Tags', 'woocommerce' ),
				'customer_reviews' 	=> sprintf( _n( '%s customer review', '%s customer reviews', 2, 'woocommerce' ), '<span class="count">2</span>' ),
				'comments_count' 	=> sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', 2, 'woocommerce' ) ), 2, '<span>' . $produtc_title . '</span>' ),
				'add_review'		=> __( 'Add a review', 'woocommerce' ),
				'your_rating'		=> esc_html__( 'Your rating', 'woocommerce' ),
			);

			wp_localize_script( 'bodycommerce-general-js', 'DEBC_Helpers', $helpers );
		}
	}



	public static function wc_notices(){

		if( !is_admin() && function_exists( 'wc_print_notices' ) ){
			ob_start();
			wc_print_notices();

			self::$notices = ob_get_clean();
		}

		return self::$notices;
	}



	public static function get_order_bump_id(  ){

		include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
	  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
	  $order_bump_template = $titan->getOption( 'order_bump_template' );
	  $order_bump_product_type = $titan->getOption( 'order_bump_product_type' );


	 if(isset($order_bump_product_type)) {


	if ($order_bump_product_type == "specific") {
	$order_bump_product = $titan->getOption( 'order_bump_product' );
	$order_bump_id_combine = array(
    "7777777777777" => $order_bump_product
);

	} else if ($order_bump_product_type == "upsell") {

	    $get_product_id_arr  = array();
			$get_product_upsell_arr  = array();
	  foreach( WC()->cart->get_cart() as $cart_item ){
	      $product_id = $cart_item['product_id'];
	      $product = new WC_Product($product_id);
	      $upsells = $product->get_upsell_ids();
	      if (isset( $upsells[0])) {
	      $upsell_id = $upsells[0];
	      $get_product_id_arr[] = $product_id;
	      $get_product_upsell_arr[] = $upsell_id;
	    }
	  }


	  if (!empty($get_product_upsell_arr)) {

			$order_bump_id_combine = array_combine($get_product_id_arr, $get_product_upsell_arr);
			$order_bump_keys = array_keys($order_bump_id_combine);
			$order_bump_values = array_values($order_bump_id_combine);

	  }

		// $upsell_id = $get_product_id_arr[0];


	} else if ($order_bump_product_type == "crosssell") {


		$get_product_id_arr  = array();
		$get_product_upsell_arr  = array();
	foreach( WC()->cart->get_cart() as $cart_item ){
			$product_id = $cart_item['product_id'];
			$product = new WC_Product($product_id);
			$upsells = $product->get_cross_sell_ids();
			if (isset( $upsells[0])) {
			$upsell_id = $upsells[0];
			$get_product_id_arr[] = $product_id;
			$get_product_upsell_arr[] = $upsell_id;
		}
	}


	if (!empty($get_product_upsell_arr)) {

		$order_bump_id_combine = array_combine($get_product_id_arr, $get_product_upsell_arr);


	}


	} else {

	}
if (isset($order_bump_id_combine)) {
return $order_bump_id_combine;
}

}

	}


// 	public static function get_order_bump_coupon_code(  ){
// $couponcode = 'YESSIR';
// return $couponcode;
// 	}

	public static function get_order_bump_discount(  ){

		include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
		$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
		$order_bump_percentage = $titan->getOption( 'order_bump_percentage' );
$amount =  $order_bump_percentage;
return $amount;
	}



	public static function get_divi_layouts(  ){

		if (!is_admin()) {
			return;
		}

		$options = array();

		$layout_query = array(
			'post_type'=>'et_pb_layout'
			, 'posts_per_page'=>-1
			, 'meta_query' => array(
					array(
							'key' => '_et_pb_predefined_layout',
							'compare' => 'NOT EXISTS',
					),
			)
		);

		$options['none'] = 'No Layout (please choose one)';
		if ($layouts = get_posts($layout_query)) {
		foreach ($layouts as $layout) {
		$options[$layout->ID] = $layout->post_title;
		}
		}

		return $options;
	}



	public static function get_divi_post_types(  ){

		if (!is_admin()) {
			return;
		}

		$options_posttype = array();

		$args_posttype = array(
			'public'   => true,
		);

		$output = 'names'; // names or objects, note names is the default
		$operator = 'and'; // 'and' or 'or'

		$post_types = get_post_types( $args_posttype, $output, $operator );

		foreach ( $post_types  as $post_type ) {
		$options_posttype[$post_type] = $post_type;
		}

		return $options_posttype;
	}

	public static function get_image_sizes(  ){

		if (!is_admin()) {
			return;
		}

		$options = $col_options = array();
		$sizes = get_intermediate_image_sizes();

		foreach ($sizes as $size) {
				$options[$size] = $size;
		}

		for ($i = 1; $i <= 6; $i++) {
				$col_options[$i] = $i;
		}

		return $options;
	}


}

new DEBC_INIT();
