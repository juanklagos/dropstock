<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_checkout_payment extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.CHP Payment - Checkout Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_checkout_payment';

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
                            'general'   => array(
                                                  'label'    => esc_html__( 'General', 'divi-bodyshop-woocommerce' ),
                                                  'css'      => array(
                                                          'main' => "{$this->main_css_element}",
                                                  ),
                                  ),
                                    'payment_titles'   => array(
                                                          'label'    => esc_html__( 'Payment Title', 'divi-bodyshop-woocommerce' ),
                                                          'css'      => array(
                                                                  'main' => "{$this->main_css_element} .wc_payment_methods label",
                                                          ),
                                          ),
                                            'payment_description'   => array(
                                                                  'label'    => esc_html__( 'Payment Description', 'divi-bodyshop-woocommerce' ),
                                                                  'css'      => array(
                                                                          'main' => "{$this->main_css_element} .wc_payment_methods .payment_box p",
                                                                  ),
                                                  ),
                                                    'terms'   => array(
                                                                          'label'    => esc_html__( 'Terms and Conditions', 'divi-bodyshop-woocommerce' ),
                                                                          'css'      => array(
                                                                                  'main' => "{$this->main_css_element} .woocommerce-terms-and-conditions-wrapper p",
                                                                          ),
                                                          ),
                                                            'terms_link'   => array(
                                                                                  'label'    => esc_html__( 'Terms and Conditions Link', 'divi-bodyshop-woocommerce' ),
                                                                                  'css'      => array(
                                                                                          'main' => "{$this->main_css_element} .woocommerce-terms-and-conditions-wrapper a",
                                                                                  ),
                                                                  ),
                          ),
                          'button' => array(
                        'button' => array(
                          'label' => esc_html__( 'Payment Button', 'divi-bodyshop-woocommerce' ),
                          'css' => array(
                            'main' => "{$this->main_css_element} #payment .button",
                                'important' => 'all',
                          ),
                          'box_shadow'  => array(
                            'css' => array(
                              'main' => "{$this->main_css_element} #payment .button",
                                  'important' => 'all',
                            ),
                          ),
                          'margin_padding' => array(
                          'css'           => array(
                            'main' => "{$this->main_css_element} #payment .button",
                            'important' => 'all',
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
                			'bg_color' => array(
                				'label'             => esc_html__( 'Background Color', 'divi-bodyshop-woocommerce' ),
                				'type'              => 'color-alpha',
                				'custom_color'      => true,
                        'default'           => '#ebe9eb',
                				'toggle_slug'       => 'main_content',
                			),
                  			'description_bg_color' => array(
                  				'label'             => esc_html__( 'Payment Description Background Color', 'divi-bodyshop-woocommerce' ),
                  				'type'              => 'color-alpha',
                  				'custom_color'      => true,
                          'default'           => '#dfdcde',
                  				'toggle_slug'       => 'main_content',
                  			),
                      'admin_label' => array(
                          'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                          'type'        => 'text',
                          'toggle_slug'     => 'main_content',
                          'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                      ),
                        '__getcheckoutpayment' => array(
                          'type' => 'computed',
                          'computed_callback' => array( 'db_woo_checkout_payment', 'get_checkout_payment' ),
                          'computed_depends_on' => array(
                            'admin_label'
                          ),
                        ),
                		);

    		return $fields;
    	}


      public static function get_checkout_payment ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
                  if ( WC()->cart->needs_payment() ) {
              			$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
              			WC()->payment_gateways()->set_current_gateway( $available_gateways );
              		} else {
              			$available_gateways = array();
              		}

              		wc_get_template(
              			'checkout/payment.php',
              			array(
              				'checkout'           => WC()->checkout(),
              				'available_gateways' => $available_gateways,
              				'order_button_text'  => apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ),
              			)
              		);
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



                    $custom_button  			= $this->props['custom_button'];
                    $button_use_icon  			= $this->props['button_use_icon'];
                    $button_icon 				= $this->props['button_icon'];
                    $button_icon_placement 		= $this->props['button_icon_placement'];
                    $button_bg_color       		= $this->props['button_bg_color'];


                    $bg_color  			= $this->props['bg_color'];
                    $description_bg_color  			= $this->props['description_bg_color'];

                    // button icon and background
                    if( $custom_button == 'on' ){

                        // button icon
                        if( $button_icon !== '' ){
                            $iconContent = DEBC_INIT::et_icon_css_content( esc_attr($button_icon) );

                            $iconSelector = '';
                            if( $button_icon_placement == 'right' ){
                                $iconSelector = '%%order_class%% .button:after';
                            }elseif( $button_icon_placement == 'left' ){
                                $iconSelector = '%%order_class%% .button:before';
                            }

                            if( !empty( $iconContent ) && !empty( $iconSelector ) ){
                                ET_Builder_Element::set_style( $render_slug, array(
                                    'selector' => $iconSelector,
                                    'declaration' => "content: '{$iconContent}'!important;font-family:ETmodules!important;"
                                    )
                                );
                            }
                }

                // fix the button padding if has no icon
                if( $button_use_icon == 'off' ){
                  ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => 'body.woocommerce %%order_class%% .button',
                    'declaration' => "padding: 0.3em 1em!important"
                    )
                  );
                }


                if( $button_use_icon == 'off' ){
                  $this->add_classname( 'button-no-icon' );
                }

                        // button background
                        if( !empty( $button_bg_color ) ){
                            ET_Builder_Element::set_style( $render_slug, array(
                                'selector'    => 'body #page-container %%order_class%% .button',
                                'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
                            ) );
                        }
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();

                    ?>
                    <style>
                    #add_payment_method #payment, .woocommerce-cart #payment, .woocommerce-checkout #payment {
                      background-color: <?php echo $bg_color ?> !important;
                    }
                    #add_payment_method #payment div.payment_box, .woocommerce-cart #payment div.payment_box, .woocommerce-checkout #payment div.payment_box {
                      background-color: <?php echo $description_bg_color ?> !important;
                    }
                    #add_payment_method #payment div.payment_box::before, .woocommerce-cart #payment div.payment_box::before, .woocommerce-checkout #payment div.payment_box::before {
                      border: 1em solid <?php echo $description_bg_color ?> !important;
                          border-right-color: transparent !important;
                          border-left-color: transparent !important;
                          border-top-color: transparent !important;
                    }
                    </style>
                    <?php

                    if ( WC()->cart->needs_payment() ) {
                			$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
                			WC()->payment_gateways()->set_current_gateway( $available_gateways );
                		} else {
                			$available_gateways = array();
                		}

                		wc_get_template(
                			'checkout/payment.php',
                			array(
                				'checkout'           => WC()->checkout(),
                				'available_gateways' => $available_gateways,
                				'order_button_text'  => apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ),
                			)
                		);

                $content = ob_get_clean();



                //////////////////////////////////////////////////////////////////////

                return $content;
                  }
              }

            new db_woo_checkout_payment;

?>
