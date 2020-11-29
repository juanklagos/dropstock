<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_checkout_order_review extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.CHP Order Review - Checkout Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_checkout_order_review';

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
                            'table_title'   => array(
                                                  'label'    => esc_html__( 'Table Titles', 'divi-bodyshop-woocommerce' ),
                                                  'css'      => array(
                                                          'main' => "{$this->main_css_element} thead .product-name, {$this->main_css_element} thead .product-total",
                                                  ),
                                  ),
                                    'product_title'   => array(
                                                          'label'    => esc_html__( 'Product Titles', 'divi-bodyshop-woocommerce' ),
                                                          'css'      => array(
                                                                  'main' => "{$this->main_css_element} .cart_item .product-name",
                                                          ),
                                          ),
                                            'product_total'   => array(
                                                                  'label'    => esc_html__( 'Product Totals', 'divi-bodyshop-woocommerce' ),
                                                                  'css'      => array(
                                                                          'main' => "{$this->main_css_element} .cart_item .product-total",
                                                                  ),
                                                  ),
                                                    'product_quantity'   => array(
                                                                          'label'    => esc_html__( 'Product Quantity', 'divi-bodyshop-woocommerce' ),
                                                                          'css'      => array(
                                                                                  'main' => "{$this->main_css_element} .cart_item .product-quantity",
                                                                          ),
                                                          ),
                                                            'table_footer_title'   => array(
                                                                                  'label'    => esc_html__( 'Table Footer Titles (subtotal, shipping and total)', 'divi-bodyshop-woocommerce' ),
                                                                                  'css'      => array(
                                                                                          'main' => "{$this->main_css_element} tfoot tr th",
                                                                                  ),
                                                                  ),
                                                                    'table_footer_total'   => array(
                                                                                          'label'    => esc_html__( 'Table Footer Totals', 'divi-bodyshop-woocommerce' ),
                                                                                          'css'      => array(
                                                                                                  'main' => "{$this->main_css_element} tfoot .amount, {$this->main_css_element} tfoot .woocommerce-shipping-methods",
                                                                                          ),
                                                                          ),
                          ),
                          'button' => array(
                          ),
                          'background' => array(
                              'settings' => array(
                                  'color' => 'alpha',
                              ),
                          ),
                          'border' => array(
                              'css' => array(
                                  'important' => 'all',
                              ),
                          ),
                          'custom_margin_padding' => array(
                              'css' => array(
                                  'important' => 'all',
                              ),
                          ),
                      );

                  }

                  function get_fields() {
                    $fields = array(
                    'remove_borders' => array(
                        'label' => esc_html__('Remove Borders?', 'divi-bodyshop-woocommerce'),
                        'type' => 'yes_no_button',
                        'toggle_slug' => 'main_settings',
                        'options' => array(
                            'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                            'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
                        ),
                        'description' => 'Should the borders on the table be removed?',
                    ),
                      'admin_label' => array(
                          'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                          'type'        => 'text',
                          'toggle_slug'     => 'main_content',
                          'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                      ),
                        '__getcheckoutorderreview' => array(
                          'type' => 'computed',
                          'computed_callback' => array( 'db_woo_checkout_order_review', 'get_checkout_order_review' ),
                          'computed_depends_on' => array(
                            'admin_label'
                          ),
                        ),
                		);

    		return $fields;
    	}



      public static function get_checkout_order_review ( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
          return;
        }

                ob_start();

                ?>
                <div style="display:none !important;">
                  <?php
  do_action( 'woocommerce_before_checkout_form', $checkout );
                ?>
              </div>

                	<form name="checkout" method="post" class="checkout woocommerce-checkout billingsection" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
                  <?php
                  wc_get_template(
              			'checkout/review-order.php',
              			array(
              				'checkout' => WC()->checkout(),
              			)
              		);
                    ?>
                  </form>
                            <?php
        $data = ob_get_clean();

      return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {


                    $remove_borders = $this->props['remove_borders'];

                    if (is_admin()) {
                        return;
                    }



                    if( $remove_borders == 'on' ){
                      $this->add_classname( 'no-borders' );
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();

                    wc_get_template(
                			'checkout/review-order.php',
                			array(
                				'checkout' => WC()->checkout(),
                			)
                		);

                $content = ob_get_clean();



                //////////////////////////////////////////////////////////////////////

                return $content;
                  }
              }

            new db_woo_checkout_order_review;

?>
