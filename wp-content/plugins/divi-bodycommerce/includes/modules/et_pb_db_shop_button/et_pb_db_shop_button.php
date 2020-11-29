<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_shop_button_code extends ET_Builder_Module {

  public static $button_text, $p;
	public static function change_button_text( $btn_text ){
		if( !empty( self::$button_text ) ){
			$btn_text = esc_html__( self::$button_text );
		}
		return $btn_text;
	}

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.LL View Product Btn - Loop Layout', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_shop_button';

                    $this->settings_modal_toggles = array(

      			'general' => array(
              'toggles' => array(
					'hide_out_stock_button' => esc_html__( 'Add to Cart Button', 'divi-bodyshop-woocommerce' ),
					'quantity' => esc_html__( 'Quantity', 'divi-bodyshop-woocommerce' ),
					'variations' => esc_html__( 'Variations', 'divi-bodyshop-woocommerce' ),
				      ),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->fields_defaults = array();



                      $this->advanced_fields = array(
                                      'button' => array(
                                        'button' => array(
                                          'label' => esc_html__( 'Button', 'et_builder' ),
                                          'css' => array(
                                            'main' => "{$this->main_css_element} .et_pb_button",
                                            'plugin_main' => "{$this->main_css_element}.et_pb_module",
                                          ),
                                          'box_shadow'  => array(
                                            'css' => array(
                                              'main' => "{$this->main_css_element} .et_pb_button",
                                                  'important' => 'all',
                                            ),
                                          ),
                                          'margin_padding' => array(
                                          'css'           => array(
                                            'main' => "{$this->main_css_element} .et_pb_button",
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
                                          'border' => array(),
                                          'custom_margin_padding' => array(
                                                  'css' => array(
                                                          'important' => 'all',
                                                  ),
                                          ),
                                  );
                      $this->custom_css_fields = array();

            $this->help_videos = array(
              array(
                'id'   => esc_html__( 'n2karNiwJ3A', 'divi-bodyshop-woocommerce' ), // YouTube video ID
                'name' => esc_html__( 'BodyCommcerce Product Page Template Guide', 'divi-bodyshop-woocommerce' ),
              ),
            );
          }

                  function get_fields() {
                      $fields = array(
			'title' => array(
				'label'           => esc_html__( 'Button Text', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text.', 'divi-bodyshop-woocommerce' ),
			),
      'custom_url' => array(
        'label'       => __( 'Custom URL End', 'divi-bodyshop-woocommerce' ),
        'type'        => 'text',
        'description' => __( 'If you want to add an extension after the URL such as an anchor link - add it here. For example add #buynow to go to a section on the product page that has the ID "buynow".', 'et_builder' ),
                  ),
                      );

                      return $fields;
                  }

                  function render( $attrs, $content = null, $render_slug ) {

                  self::$button_text      	= $this->props['title'];

                  $custom_url  = $this->props['custom_url'];
                  $title  = $this->props['title'];
                  $button_use_icon          	= $this->props['button_use_icon'];
                  $custom_icon          		= $this->props['button_icon'];
                  $button_custom        		= $this->props['custom_button'];
                  $button_bg_color       		= $this->props['button_bg_color'];

                  $data = '';

                  //////////////////////////////////////////////////////////////////////
                  if( is_admin() ){
                    return;
                  }

                  ob_start();
                  global $product;
                  $product_id = $product->get_id();
                  $url = get_permalink( $product_id );
                  ?>
                <a class="et_pb_button" href="<?php echo $url ?><?php echo $custom_url ?>"><?php echo $title; ?> </a>

                  <?php

        if( $button_use_icon == 'on' && $custom_icon != '' ){
  			$custom_icon = 'data-icon="'. esc_attr( et_pb_process_font_icon( $custom_icon ) ) .'"';
  			ET_Builder_Element::set_style( $render_slug, array(
  				'selector'    => 'body #page-container %%order_class%% .et_pb_button:after',
  				'declaration' => "content: attr(data-icon);",
  			) );
  		}else{
  			ET_Builder_Element::set_style( $render_slug, array(
  				'selector'    => 'body #page-container %%order_class%% .et_pb_button:hover',
  				'declaration' => "padding: .3em 1em;",
  			) );
  		}

  		if( !empty( $button_bg_color ) ){

  			ET_Builder_Element::set_style( $render_slug, array(
  				'selector'    => 'body #page-container %%order_class%% .et_pb_button',
  				'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
  			) );
  		}

                  $data = ob_get_clean();
                  //////////////////////////////////////////////////////////////////////

                  $data = str_replace(
              			'class="et_pb_button"',
              			'class="et_pb_button"' . $custom_icon
              			, $data
              		);

                  return $data;

                  }
              }

            new db_shop_button_code;

?>
