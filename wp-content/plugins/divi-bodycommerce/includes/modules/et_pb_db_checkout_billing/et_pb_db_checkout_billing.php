<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_checkout_billing extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.CHP Billing - Checkout Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_checkout_billing';

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
                          'title'   => array(
                                                'label'    => esc_html__( 'Title', 'divi-bodyshop-woocommerce' ),
                                                'css'      => array(
                                                        'main' => ".woocommerce form {$this->main_css_element} h3, .woocommerce {$this->main_css_element} form h3",
                                                ),
                                                'font_size' => array('default' => '22px'),
                                                'line_height'    => array('default' => '1.5em'),
                                ),
                                  'label'   => array(
                                                        'label'    => esc_html__( 'Labels', 'divi-bodyshop-woocommerce' ),
                                                        'css'      => array(
                                                                'main' => ".woocommerce form {$this->main_css_element} .form-row label, .woocommerce {$this->main_css_element} form .form-row label",
                                                        ),
                                                        'line_height'    => array('default' => '1.5em'),
                                        ),
                                          'input'   => array(
                                                                'label'    => esc_html__( 'Inputs', 'divi-bodyshop-woocommerce' ),
                                                                'css'      => array(
                                                                        'main' => ".woocommerce form {$this->main_css_element} .form-row input.input-text, .woocommerce form {$this->main_css_element} .form-row input, .woocommerce {$this->main_css_element} form .form-row input.input-text",
                                                                ),
                                                                'line_height'    => array('default' => '1.5em'),
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
                      'admin_label' => array(
                          'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                          'type'        => 'text',
                          'toggle_slug'     => 'main_content',
                          'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                      ),
                        '__getcheckoutbilling' => array(
                          'type' => 'computed',
                          'computed_callback' => array( 'db_woo_checkout_billing', 'get_checkout_billing' ),
                          'computed_depends_on' => array(
                            'admin_label'
                          ),
                        ),
                		);

    		return $fields;
    	}


      public static function get_checkout_billing ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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

                      do_action( 'woocommerce_checkout_billing' );
                    ?>
                  </form>
                            <?php
        $data = ob_get_clean();

      return $data;

      }


                  function render( $attrs, $content = null, $render_slug ) {



                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();


    do_action( 'woocommerce_checkout_billing' );

                $content = ob_get_clean();



                //////////////////////////////////////////////////////////////////////

                return $content;
                  }
              }

            new db_woo_checkout_billing;

?>
