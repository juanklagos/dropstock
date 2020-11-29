<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_payment_methods_code extends ET_Builder_Module {



public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP Payment Methods - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_woo_payment_methods';

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
                                                'label'    => esc_html__( 'Table Heading', 'divi-bodyshop-woocommerce' ),
                                                'css'      => array(
                                                        'main' => "{$this->main_css_element} .nobr",
                                                ),
                                                'font_size' => array('default' => '24px'),
                                                'line_height'    => array('default' => '1.5em'),
                                ),
                                'paragraphs'   => array(
                                                  'label'    => esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ),
                                                  'css'      => array(
                                                          'main' => "{$this->main_css_element} table.account-payment-methods-table tr td",
                                                  ),
                                                  'font_size' => array('default' => '24px'),
                                                  'line_height'    => array('default' => '1.5em'),
                                  ),
                              ),
                        'border' => array( ),
                  			'custom_margin_padding' => array(
                  				'css' => array(
                  					'important' => 'all',
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

        		);

                  }

                  function get_fields() {
    		$fields = array(

    		);

    		return $fields;
    	}



                  function render( $attrs, $content = null, $render_slug ) {

                  // $button_text = $this->props['button_text'];

                    if (is_admin()) {
                        return;
                    }

                    $custom_button  			= $this->props['custom_button'];
                    $custom_icon          		= $this->props['button_icon'];
                    $button_bg_color       		= $this->props['button_bg_color'];
                    $button_use_icon  			= $this->props['button_use_icon'];
                    $button_icon 				= $this->props['button_icon'];
                    $button_icon_placement 		= $this->props['button_icon_placement'];


                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                  ob_start();

                  echo do_shortcode( "[db_woo_get_payment_methods]" );

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



                  $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  //  $data = str_replace(
                  //   'class="button"',
                  //   'class="button"' . $custom_icon
                  //   , $data
                  // );

                  return $data;
                  }
              }

            new db_woo_payment_methods_code;

?>
