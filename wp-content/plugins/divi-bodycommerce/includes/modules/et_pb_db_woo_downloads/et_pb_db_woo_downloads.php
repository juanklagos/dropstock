<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_downloads_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP Downloads - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_woo_downloads';

		$this->fields_defaults = array(
		);

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
      				),
      			),
      			'advanced' => array(
      				'toggles' => array(
      					'text' => esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
      				),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
                        'fonts' => array(
                          'headings'   => array(
                                                'label'    => esc_html__( 'Table Heading', 'et_builder' ),
                                                'css'      => array(
                                                        'main' => "{$this->main_css_element} .nobr",
                                                ),
                                                'font_size' => array('default' => '24px'),
                                                'line_height'    => array('default' => '1.5em'),
                                ),
                                'download_name'   => array(
                                                  'label'    => esc_html__( 'Download Name', 'et_builder' ),
                                                  'css'      => array(
                                                          'main' => "{$this->main_css_element} .download-product a",
                                                  ),
                                                  'font_size' => array('default' => '24px'),
                                                  'line_height'    => array('default' => '1.5em'),
                                  ),
                                  'paragraph'   => array(
                                                    'label'    => esc_html__( 'Information', 'et_builder' ),
                                                    'css'      => array(
                                                            'main' => "{$this->main_css_element} .download-remaining, {$this->main_css_element} .download-expires",
                                                    ),
                                                    'font_size' => array('default' => '24px'),
                                                    'line_height'    => array('default' => '1.5em'),
                                    ),
                              ),
                                    'button' => array(
                                  'button' => array(
                                    'label' => esc_html__( 'File Link/Button', 'et_builder' ),
                                    'css' => array(
                                      'main' => "{$this->main_css_element} .download-file a",
                                      'plugin_main' => "{$this->main_css_element}.et_pb_module",
                                    ),
                                    'box_shadow'  => array(
                                      'css' => array(
                                        'main' => "{$this->main_css_element} .download-file a",
                                            'important' => 'all',
                                      ),
                                    ),
                            			'margin_padding' => array(
                            				'css'           => array(
                            					'main' => "{$this->main_css_element} .download-file a",
                            					'important' => 'all',
                            				),
                            			),
                                  ),
                                ),
        		);

                  }

                  function get_fields() {
    		$fields = array(
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__getdownloads' => array(
            'type' => 'computed',
            'computed_callback' => array( 'db_woo_downloads_code', 'get_acc_downloads' ),
            'computed_depends_on' => array(
              'admin_label'
            ),
          ),

    		);

    		return $fields;
    	}


      public static function get_acc_downloads( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}

                ob_start();

        global $woocommerce;
        $data = '';
      //////////////////////////////////////////////////////////////////////


      $downloads     = WC()->customer->get_downloadable_products();
      $has_downloads = (bool) $downloads;

      do_action( 'woocommerce_before_account_downloads', $has_downloads ); ?>

      <?php if ( $has_downloads ) : ?>

      	<?php do_action( 'woocommerce_before_available_downloads' ); ?>

      	<?php do_action( 'woocommerce_available_downloads', $downloads ); ?>

      	<?php do_action( 'woocommerce_after_available_downloads' ); ?>

      <?php else : ?>
      	<div class="woocommerce-Message woocommerce-Message--info woocommerce-info">
      		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
      			<?php esc_html_e( 'Browse products', 'woocommerce' ); ?>
      		</a>
      		<?php esc_html_e( 'No downloads available yet.', 'woocommerce' ); ?>
      	</div>
      <?php endif; ?>

      <?php do_action( 'woocommerce_after_account_downloads', $has_downloads );

        $data = ob_get_clean();

       //////////////////////////////////////////////////////////////////////

      return $data;


      }


                  function render( $attrs, $content = null, $render_slug ) {

                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();
                    if ( ! is_admin() ) {
                      $downloads     = WC()->customer->get_downloadable_products();
                $has_downloads = (bool) $downloads;

                do_action( 'woocommerce_before_account_downloads', $has_downloads ); ?>

                <?php if ( $has_downloads ) : ?>

                	<?php do_action( 'woocommerce_before_available_downloads' ); ?>

                	<?php do_action( 'woocommerce_available_downloads', $downloads ); ?>

                	<?php do_action( 'woocommerce_after_available_downloads' ); ?>

                <?php else : ?>
                	<div class="woocommerce-Message woocommerce-Message--info woocommerce-info">
                		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                			<?php esc_html_e( 'Browse products', 'woocommerce' ); ?>
                		</a>
                		<?php esc_html_e( 'No downloads available yet.', 'woocommerce' ); ?>
                	</div>
                <?php endif; ?>

                <?php do_action( 'woocommerce_after_account_downloads', $has_downloads );
                
                  }
                  else {
                    # code...
                  }
                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_woo_downloads_code;

?>
