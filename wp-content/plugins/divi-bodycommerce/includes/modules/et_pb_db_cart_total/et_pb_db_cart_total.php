<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_cart_total extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.CP Cart Totals - Cart Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_cart_total';

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
                              'table_text' => array(
                                  'label' => esc_html__('Table', 'et_builder'),
                                  'css' => array(
                                      'main' => "{$this->main_css_element} table td, {$this->main_css_element} table td a, {$this->main_css_element} table th",
                                  ),
                                  'font_size' => array('default' => '14px'),
                                  'line_height' => array('default' => '1.4em'),
                              ),
                                  'table_header' => array(
                                      'label' => esc_html__('Table Header', 'et_builder'),
                                      'css' => array(
                                          'main' => ".woocommerce {$this->main_css_element} table.shop_table th",
                              						'important' => 'all',
                                      ),
                                      'font_size' => array('default' => '14px'),
                                      'line_height' => array('default' => '1.4em'),
                                  ),
                                      'table_total' => array(
                                          'label' => esc_html__('Total', 'et_builder'),
                                          'css' => array(
                                              'main' => ".woocommerce {$this->main_css_element} table.shop_table .order-total td",
                                  						'important' => 'all',
                                          ),
                                          'font_size' => array('default' => '14px'),
                                          'line_height' => array('default' => '1.4em'),
                                      ),
                                      'table_amount' => array(
                                          'label' => esc_html__('Amount', 'et_builder'),
                                          'css' => array(
                                              'main' => ".woocommerce {$this->main_css_element} table.shop_table .amount",
                                  						'important' => 'all',
                                          ),
                                          'font_size' => array('default' => '14px'),
                                          'line_height' => array('default' => '1.4em'),
                                      ),
                          ),
                          'button' => array(
                              'button' => array(
                                  'label' => esc_html__('Button', 'et_builder'),
                                  'css' => array(
                                      'main' => $this->main_css_element . ' .checkout-button.button',
                                      'plugin_main' => "{$this->main_css_element}.et_pb_module",
                                  ),
                                  'box_shadow'  => array(
                                    'css' => array(
                                      'main' => $this->main_css_element . ' .button',
                                          'important' => 'all',
                                    ),
                                  ),
                                  'margin_padding' => array(
                                  'css'           => array(
                                    'main' => "{$this->main_css_element} .button",
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
          'remove_crosssell' => array(
              'label' => esc_html__('Remove Cross Sell Section?', 'et_builder'),
              'type' => 'yes_no_button',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'off' => esc_html__('No', 'et_builder'),
                  'on' => esc_html__('Yes', 'et_builder'),
              ),
              'description' => 'If you want to remove the cross sell section, enable this.',
          ),
            'remove_shipping' => array(
                'label' => esc_html__('Remove Shipping?', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_settings',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
                'description' => 'If you want to remove the shipping section, enable this.',
            ),
          'remove_borders' => array(
              'label' => esc_html__('Remove Borders?', 'et_builder'),
              'type' => 'yes_no_button',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'off' => esc_html__('No', 'et_builder'),
                  'on' => esc_html__('Yes', 'et_builder'),
              ),
              'description' => 'Should the borders on the table be removed?',
          ),
            'remove_title' => array(
                'label' => esc_html__('Remove Title?', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_settings',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
                'description' => 'This will remove the title above the table',
            ),
            'admin_label' => array(
                'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                'type'        => 'text',
                'toggle_slug'     => 'main_content',
                'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
            ),
            '__getcarttotals' => array(
              'type' => 'computed',
              'computed_callback' => array( 'db_woo_cart_total', 'get_cart_totals' ),
              'computed_depends_on' => array(
                'admin_label'
              ),
            ),
    		);

    		return $fields;
    	}


      public static function get_cart_totals( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}

        ob_start();

        echo '<div class="cart-collaterals cart-collaterals-bc">';
        do_action('woocommerce_cart_collaterals');
        echo '</div>';


        $data = ob_get_clean();

            return $data;

          }

                  function render( $attrs, $content = null, $render_slug ) {

                    $remove_shipping = $this->props['remove_shipping'];

                    $remove_borders = $this->props['remove_borders'];
                    $remove_title = $this->props['remove_title'];
                    $remove_crosssell = $this->props['remove_crosssell'];

                    $custom_button  			= $this->props['custom_button'];
                    $button_use_icon  			= $this->props['button_use_icon'];
                    $button_icon 				= $this->props['button_icon'];
                    $button_icon_placement 		= $this->props['button_icon_placement'];
                    $button_bg_color       		= $this->props['button_bg_color'];

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

                        // button background
                        if( !empty( $button_bg_color ) ){
                            ET_Builder_Element::set_style( $render_slug, array(
                                'selector'    => 'body #page-container %%order_class%% .button',
                                'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
                            ) );
                        }
                    }

                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                  ob_start();

                  echo '<div class="cart-collaterals cart-collaterals-bc">';
                  do_action('woocommerce_cart_collaterals');
                  echo '</div>';

                  $content = ob_get_clean();

                  if( $remove_shipping == 'on' ){
                    $this->add_classname( 'no-shipping' );
                  }

                  if( $remove_borders == 'on' ){
                    $this->add_classname( 'no-borders' );
                  }
                  if( $remove_title == 'on' ){
                  $this->add_classname( 'no-title' );
                  }
                  if( $remove_crosssell == 'on' ){
                  $this->add_classname( 'no-crosssell' );
            remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 30 );
                  }


                  //////////////////////////////////////////////////////////////////////



                  return $content;
                  }
              }

            new db_woo_cart_total;

?>
