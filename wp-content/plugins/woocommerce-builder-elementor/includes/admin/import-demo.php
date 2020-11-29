<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class DTWCBE_Improt_Demo{
		
	public function __construct(){
		add_action('wp_ajax_dtwcbe_import_demo_data', array($this,'ajax_import_demo'));
	}
	
	public static function output(){
		
		if ( DTWCBE_WooCommerce_Builder_Elementor()->registration->is_registered() ){
		
		$config_demos = self::config_demos();
		
		if ( count( $config_demos ) < 0 ) {
			return;
		}
		reset( $config_demos );
		?>
		<div class="dtwcbe-import-demo">
			<form class="dtwcbe-importer" action="?page=dtwcbe-import-demo" method="post">
				<h1 class="dtwcbe-admin-title"><?php esc_html_e('Choose the demo for import','woocommerce-builder-elementor')?></h1>
				<p class="dtwcbe-admin-subtitle"><?php esc_html_e('The demo will give you the layout of the demo version. The style of the demo version is often affected by your theme and plugins.','woocommerce-builder-elementor');?></p>
				<div class="dtwcbe-importer-list">
					<?php foreach ( $config_demos as $name => $import ) {
					?>
						<div class="dtwcbe-importer-item" data-demo-id="<?php echo $name; ?>">
	
							<input class="dtwcbe-importer-item-radio" id="demo_main" type="radio" value="<?php echo $name; ?>" name="demo">
							<label class="dtwcbe-importer-item-preview" for="demo_<?php echo $name; ?>" title="<?php esc_html_e( 'Click to choose', 'woocommerce-builder-elementor' ) ?>">
								<h2 class="dtwcbe-importer-item-title"><?php echo $import['title']; ?>
									<a class="btn" href="<?php echo $import['preview_url']; ?>" target="_blank" title="<?php esc_html_e( 'View this demo in a new tab', 'woocommerce-builder-elementor' ) ?>"><?php esc_html_e( 'Preview', 'woocommerce-builder-elementor' ) ?></a>
								</h2>
								<img src="<?php echo DTWCBE_URL . 'dummy-data/'. $name .'/preview.jpg' ?>" alt="<?php echo esc_attr($import['title']);?>">
							</label>
	
							<div class="dtwcbe-importer-item-options">
								<div class="dtwcbe-importer-item-options-h">
									<input type="hidden" name="action" value="import-demo">
									<input class="dtwcbe-button-import run_import_demo_data" type="submit" value="<?php esc_html_e('Import','woocommerce-builder-elementor')?>">
								</div>
							</div>
	
							<div class="dtwcbe-importer-message progress">
								<div class="dtwcbe-importer-preloader"></div>
								<h2><?php esc_html_e('Importing Demo Content...','woocommerce-builder-elementor')?></h2>
								<p><?php esc_html_e( 'Don\'t close or refresh this page to not interrupt the import.', 'woocommerce-builder-elementor' ) ?></p>
							</div>
	
							<div class="dtwcbe-importer-message done">
								<h2><?php esc_html_e('Import completed successfully!','woocommerce-builder-elementor')?></h2>
								<p><?php echo sprintf( __( 'Let\'s see the <a href="%s">Templates</a>.', 'woocommerce-builder-elementor' ), admin_url( 'edit.php?post_type=dtwcbe_woo_library' ) ) ?></p>
							</div>
	
						</div>
					<?php } ?>
				</div>
			</form>
			<script>
				jQuery(document).ready(function() {
					var import_running = false;
	
					jQuery('.dtwcbe-importer-item-preview').click(function(){
						var $this_item = jQuery(this).closest('.dtwcbe-importer-item'),
							demoName = $this_item.attr('data-demo-id');
	
						jQuery('.dtwcbe-importer-item').removeClass('selected');
						$this_item.addClass('selected');
	
	
						$this_item.find('.run_import_demo_data').off('click').click(function(){
							if(import_running) return false;
	
							jQuery('.dtwcbe-importer').addClass('importing');
							console.log(demoName);
							jQuery.ajax({
								type: 'POST',
								url: '<?php echo admin_url('admin-ajax.php'); ?>',
								data: {
									security: '<?php echo wp_create_nonce( 'dtwcbe_import_demo_data' )?>',
									action: 'dtwcbe_import_demo_data',
									demo: demoName
								},
								success: function(response, textStatus, XMLHttpRequest){
									console.log(response);
									
									if(response != 'imported'){
										jQuery('.dtwcbe-importer-message.done h2').html(response.error_title);
										jQuery('.dtwcbe-importer-message.done p').html(response.error_description);
										jQuery('.dtwcbe-importer').addClass('error');
	
									}else{
										// Import is completed
										jQuery('.dtwcbe-importer').addClass('success');
										import_running = false;
									}
								},
								error: function(MLHttpRequest, textStatus, errorThrown){
									
									jQuery('.dtwcbe-importer-message.done h2').html('<?php esc_html_e('Error has occured','woocommerce-builder-elementor')?>');
									jQuery('.dtwcbe-importer-message.done p').html('');
									jQuery('.dtwcbe-importer').addClass('error');
								}
							});
	
							return false;
	
						});
	
					});
	
				});
			</script>
		</div>
		<?php
		}else{
			?>
			<div class="woocommerce-builder-elementor-important-notice" style="border-left: 4px solid #dc3232;">
				<h3 style="color: #dc3232; margin-top: 0;"><?php esc_html_e( 'The Demos Can Only Be Imported With A Valid Token Registration', 'woocommerce-builder-elementor' ); ?></h3>
				<?php /* translators: "Product Registration" link. */ ?>
				<p><?php printf( esc_html__( 'Please visit the %s page and enter a valid token to import the full Demos.', 'woocommerce-builder-elementor' ), '<a href="' . esc_url_raw( admin_url( 'edit.php?post_type=dtwcbe_woo_library&dtwcbe_woo_library_type=registration' ) ) . '">' . esc_attr__( 'Registration', 'woocommerce-builder-elementor' ) . '</a>' ); ?></p>
			</div>
			<?php
		}
	}
	
	public function ajax_import_demo(){
		
		if ( ! check_ajax_referer( 'dtwcbe_import_demo_data', 'security', FALSE ) ) {
			wp_send_json_error(
			array(
			'message' => __( 'An error has occurred. Please reload the page and try again.' ),
			)
			);
		}
		
		@set_time_limit(0);
		
		$demo_version = 'main';
		if( isset( $_POST['demo'] ) ){
			$demo_version = $_POST['demo'];
		}
		
		$dummy_data_xml_file = DTWCBE_PATH . 'dummy-data/'. $demo_version .'/dummy-data.xml';
		
		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
		
		if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
			include ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		}
		
		if ( ! class_exists('WP_Import') ) { // if WP importer doesn't exist
			include DTWCBE_PATH . 'includes/lib/wordpress-importer/wordpress-importer.php';
		}
		
		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;
			ob_start();
			$wp_import->import($dummy_data_xml_file);
			ob_end_clean();
				
			// Flush rules after install
			flush_rewrite_rules();
		
			echo 'imported';
		
			die();
		
		}else{
			wp_send_json(
			array(
			'success' => FALSE,
			'error_title' => __( 'Error has occured', 'woocommerce-builder-elementor' ),
			'error_description' => '',
			)
			);
		}
	}
	
	public static function config_demos(){
		return array(
			'product-1' => array(
				'title' => 'Product Layout #1',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe1/product/t-shirt-with-logo/',
				'type'	=> 'product',
			),
			'product-2' => array(
				'title' => 'Product Layout #2',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe2/product/t-shirt',
				'type'	=> 'product',
			),
			'product-3' => array(
				'title' => 'Product Layout #3',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe3/product/long-sleeve-tee/',
				'type'	=> 'product',
			),
			'shop-1' => array(
				'title' => 'Shop Layout #1',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe1/shop/',
				'type'	=> 'archive',
			),
			'shop-2' => array(
				'title' => 'Shop Layout #2',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe2/shop/',
				'type'	=> 'archive',
			),
			'shop-3' => array(
				'title' => 'Shop Layout #3',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe3/shop/',
				'type'	=> 'archive',
			),
			'cat-1' => array(
				'title' => 'Category Layout #1',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe1/product-category/clothing/',
				'type'	=> 'archive',
			),
			'cat-2' => array(
				'title' => 'Category Layout #2',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe2/product-category/clothing/',
				'type'	=> 'archive',
			),
			'cat-3' => array(
				'title' => 'Category Layout #3',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe3/product-category/clothing/',
				'type'	=> 'archive',
			),
			'cart-1' => array(
				'title' => 'Cart Layout #1',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe1/cart/',
				'type'	=> 'cart',
			),
			'cart-2' => array(
				'title' => 'Cart Layout #2',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe2/cart/',
				'type'	=> 'cart',
			),
			'cart-3' => array(
				'title' => 'Cart Layout #3',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe3/cart/',
				'type'	=> 'cart',
			),
			'checkout-1' => array(
				'title' => 'Checkout Layout #1',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe1/checkout/',
				'type'	=> 'checkout',
			),
			'checkout-2' => array(
				'title' => 'Checkout Layout #2',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe2/checkout/',
				'type'	=> 'checkout',
			),
			'checkout-3' => array(
				'title' => 'Checkout Layout #3',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe3/checkout/',
				'type'	=> 'checkout',
			),
			'myaccount-1' => array(
				'title' => 'My Account Layout #1',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe1/my-account/',
				'type'	=> 'myaccount',
			),
			'myaccount-2' => array(
				'title' => 'My Account Layout #2',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe2/my-account/',
				'type'	=> 'myaccount',
			),
			'myaccount-3' => array(
				'title' => 'My Account Layout #3',
				'preview_url' => 'http://demo.dawnthemes.com/woocommerce-builder-elementor/wcbe3/my-account/',
				'type'	=> 'myaccount',
			),
		);
	}
	
	// End Class
}
new DTWCBE_Improt_Demo();