<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_notices_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.G Notices - Global', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_notices';


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


                      $this->main_css_element = 'body.woocommerce %%order_class%% .woocommerce-error, body.woocommerce %%order_class%% .woocommerce-info, body.woocommerce %%order_class%% .woocommerce-message';
                      $this->button_css = "%%order_class%%";

                      $this->advanced_fields = array(
                        'fonts' => array(
                  				'notice_text'   => array(
                  					'label'    => esc_html__( 'Notice', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                              'main' => "{$this->main_css_element}",
                              'important' => 'all'
                  					),
                  					'font_size' => array(
                  						'default' => '18px',
                  					),
                  					'line_height' => array(
                  						'default' => '1.1em',
                  					),
                  				),
                  			),
                  			'box_shadow'            => array(
                  				'default' => array(
                  					'css' => array(
                              'main' => "{$this->main_css_element}",
                              'important' => 'all'
                  					),
                  				),
                  			),
                  			'background' => array(
                  				'css' => array(
                            'main' => "{$this->main_css_element}",
                            'important' => 'all'
                  				),
                  				'settings' => array(
                  					'color' => 'alpha',
                  				),
                  			),
                  			'border' => array(
                  				'css' => array(
                            'main' => "{$this->main_css_element}",
                            'important' => 'all'
                  				),
                  			),
			'custom_margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
                  			'button' => array(
                  				'button' => array(
                  					'label' => esc_html__( 'Notice Button', 'divi-bodyshop-woocommerce' ),
                  					'css' => array(
                  						'main' => "{$this->button_css} .button",
                  						'important' => 'all',
                  					),
                  					'box_shadow'  => array(
                  						'css' => array(
                  							'main' => 'body #page-container %%order_class%% .button',
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
                        '__getnotices' => array(
                          'type' => 'computed',
                          'computed_callback' => array( 'db_notices_code', 'get_checkout_notices' ),
                          'computed_depends_on' => array(
                            'admin_label'
                          ),
                        ),
                    );

        return $fields;
      }


                  public static function get_checkout_notices ( $args = array(), $conditional_tags = array(), $current_page = array() ){
                    if (!is_admin()) {
                			return;
                		}

                            ob_start();

        ?>
        <div class="woocommerce">
        <div class="woocommerce-message" role="alert">
        		<a href="" tabindex="1" class="button wc-forward">View basket</a> This is a preview of the notice that appears.
        </div>
                </div>
        <?php

                    $data = ob_get_clean();

                  return $data;

                  }


                  function render( $attrs, $content = null, $render_slug ) {



                                      $custom_button  			= $this->props['custom_button'];
                                      $button_use_icon  			= $this->props['button_use_icon'];
                                      $button_icon 				= $this->props['button_icon'];
                                      $button_icon_placement 		= $this->props['button_icon_placement'];



                    if (is_admin()) {
                        return;
                    }


                      ob_start();
                	wc_print_notices();

                  if ( is_page( 'cart' ) || is_cart() ) {
	                do_action( 'woocommerce_before_cart' );
                }

                if ( is_page( 'checkout' ) || is_checkout() ) {

?>
<div class="bc-checkout-notices"></div>
<?php

              }




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

            		if( !empty( $button_bg_color ) && $custom_button == 'on' ){

            			ET_Builder_Element::set_style( $render_slug, array(
            				'selector'    => 'body #page-container %%order_class%% .button',
            				'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
            			) );
            		}

                  $content = ob_get_clean();

                  //////////////////////////////////////////////////////////////////////



                  return $content;



              	}
              }

            new db_notices_code;

?>
