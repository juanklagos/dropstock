<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_checkout_coupon extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.CHP Coupon - Checkout Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_checkout_coupon';

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
                                            'input'   => array(
                                                                  'label'    => esc_html__( 'Inputs', 'divi-bodyshop-woocommerce' ),
                                                                  'css'      => array(
                                                                          'main' => ".woocommerce form {$this->main_css_element} .input-text.coupon-module, {$this->main_css_element} .input-text.coupon-module",
                                                                  ),
                                                                  'line_height'    => array('default' => '1.5em'),
                                                  ),
                                                                    'message'   => array(
                                                                                          'label'    => esc_html__( 'Submit message (below input)', 'divi-bodyshop-woocommerce' ),
                                                                                          'css'      => array(
                                                                                                  'main' => "{$this->main_css_element} .bc-coupon-message",
                                                                                          ),
                                                                                          'line_height'    => array('default' => '1.5em'),
                                                                          ),
                          ),

                          'button' => array(
                  'button' => array(
                    'label' => esc_html__( 'Button', 'divi-bodyshop-woocommerce' ),
                    'css' => array(
                      'main' => "{$this->main_css_element} .button",
                      'important' => 'all',
                    ),
                    'box_shadow'  => array(
                      'css' => array(
                        'main' => ".woocommerce  {$this->main_css_element} .button",
                      ),
                    ),
                  ),
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
                      'placeholder' => array(
                'label' => esc_html__('Placeholder', 'divi-bodyshop-woocommerce'),
                'type' => 'text',
                'toggle_slug' => 'main_settings',
                'default'     => 'Enter coupon code',
                'description' => esc_html__('Placeholder text for the input. Defaults to "Enter coupon code"', 'et_builder'),
            ),
            'apply_text' => array(
                'label' => esc_html__('Apply Button Text', 'divi-bodyshop-woocommerce'),
                'type' => 'text',
                'toggle_slug' => 'main_settings',
                'default'     => 'Apply Coupon',
                'description' => esc_html__('The text to show on the coupon submit button. Defaults to "Apply Coupon"', 'et_builder'),
            ),
                    'admin_label' => array(
                        'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                        'type'        => 'text',
                        'toggle_slug'     => 'main_content',
                        'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                    ),
                        '__getcheckoutcoupon' => array(
                          'type' => 'computed',
                          'computed_callback' => array( 'db_woo_checkout_coupon', 'get_checkout_coupon' ),
                          'computed_depends_on' => array(
                            'admin_label'
                          ),
                        ),
                    );

        return $fields;
      }


      public static function get_checkout_coupon ( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
          return;
        }

                ob_start();
                ?>

                            <?php
        $data = ob_get_clean();

      return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {

                            $placeholder              				= $this->props['placeholder'];
                            $apply_text              				= $this->props['apply_text'];


                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();

                    ?>
                    <p class="form-row form-row-first">
                                        <input type="text" onkeypress="bodycommerce_check_submit_checkout_coupon();" class="input-text coupon-module" placeholder="<?php echo $placeholder ?>" value="" />
                                    </p>

                                    <p class="form-row form-row-last">
                                        <input type="button" class="button" onclick="bodycommerce_submit_checkout_coupon();" value="<?php echo $apply_text ?>" />
                                    </p>

                                    <div class="clear"></div>
                                    <script>
                                    function bodycommerce_check_submit_checkout_coupon() {
                                        jQuery(this).keypress(function (e) {
                                            if (e.which == 13) {
                                                bodycommerce_submit_checkout_coupon();
                                            }
                                        });
                                    }

                                    function bodycommerce_submit_checkout_coupon() {
                                        if (jQuery('.coupon-module').length) {
                                            jQuery('.coupon-module').parent().removeClass('woocommerce-invalid').removeClass('woocommerce-validated');

                                            var coupon = jQuery('.coupon-module').val();

                                            if (coupon != '') {
                                                jQuery('#coupon_code').val(coupon);
                                                jQuery('.checkout_coupon').submit();
                                            } else {
                                                jQuery('.coupon-module').parent().addClass('woocommerce-invalid').removeClass('woocommerce-validated');
                                            }
                                        }

                                        return false;
                                    }
                                    </script>
                    <?php

                $content = ob_get_clean();



                //////////////////////////////////////////////////////////////////////

                return $content;
                  }
              }

            new db_woo_checkout_coupon;

?>
