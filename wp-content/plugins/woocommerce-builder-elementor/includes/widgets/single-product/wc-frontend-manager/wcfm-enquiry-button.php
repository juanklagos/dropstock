<?php
/**
 * WooCommerce Page Builder For Elementor Widget.
 *
 * @package WooCommerce-Builder-Elementor
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DTWCBE_Single_Product_wcfm_enquiry_button_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'woocommerce-product-wcfm-enquiry-button';
	}

	public function get_title() {
		return esc_html__( 'WC Frontend Manager Enquiry Button', 'woocommerce-builder-elementor' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'dtwcbe-woo-single-product' ];
	}
	
	public function get_keywords() {
		return [ 'woocommerce', 'Frontend' , 'Manager' , 'Enquiry', 'Button' ];
	}

	protected function _register_controls(){

	}

	protected function render() {
		if( !is_product() ) { return ''; }
		
		if( !class_exists('WCFM') ){
			return '';
		}
		/**
		 * Enquiry Button on Single Product Page
		 * WCFM_Enquiry -> wcfm_enquiry_button
		 * @since 3.3.5
		 */
		global $WCFM, $post;
		if( apply_filters( 'wcfm_is_pref_enquiry_button', true ) ) {
		
			$vendor_id = 0;
			$product_id = 0;
			if( is_product() && $post && is_object( $post ) ) {
				$product_id = $post->ID;
				$vendor_id = $WCFM->wcfm_vendor_support->wcfm_get_vendor_id_from_product( $product_id );
			}
		
			$button_style = '';
			$wcfm_options = $WCFM->wcfm_options;
			if( isset( $wcfm_options['wc_frontend_manager_button_background_color_settings'] ) ) { $button_style .= 'background: ' . $wcfm_options['wc_frontend_manager_button_background_color_settings'] . ';border-bottom-color: ' . $wcfm_options['wc_frontend_manager_button_background_color_settings'] . ';'; }
			if( isset( $wcfm_options['wc_frontend_manager_button_text_color_settings'] ) ) { $button_style .= 'color: ' . $wcfm_options['wc_frontend_manager_button_text_color_settings'] . ';'; }
		
			$wcfm_enquiry_button_label  = isset( $wcfm_options['wcfm_enquiry_button_label'] ) ? $wcfm_options['wcfm_enquiry_button_label'] : __( 'Ask a Question', 'wc-frontend-manager' );
		
			$base_color = '';
			if( isset( $wcfm_options['wc_frontend_manager_base_highlight_color_settings'] ) ) { $base_color = $wcfm_options['wc_frontend_manager_base_highlight_color_settings']; }
			?>
			<div class="wcfm_ele_wrapper wcfm_catalog_enquiry_button_wrapper">
				<div class="wcfm-clearfix"></div>
				<a href="#" class="wcfm_catalog_enquiry" data-store="<?php echo $vendor_id; ?>" data-product="<?php echo $product_id; ?>" style="<?php echo $button_style; ?>"><span class="fa fa-question-circle-o"></span>&nbsp;&nbsp;<span class="add_enquiry_label"><?php _e( $wcfm_enquiry_button_label, 'wc-frontend-manager' ); ?></span></a>
				<?php if( $base_color ) { ?>
					<style>a.wcfm_catalog_enquiry:hover{background: <?php echo $base_color; ?> !important;border-bottom-color: <?php echo $base_color; ?> !important;}</style>
				<?php } ?>
				<div class="wcfm-clearfix"></div>
			</div>
			<?php
		}
	}
	
}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new DTWCBE_Single_Product_wcfm_enquiry_button_Widget());