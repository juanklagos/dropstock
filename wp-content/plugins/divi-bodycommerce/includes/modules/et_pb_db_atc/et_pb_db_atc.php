<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_add_to_cart_code extends ET_Builder_Module {

  public static $single_variable_button_text, $simple_button_text, $variable_button_text, $sub_button_text, $var_sub_button_text, $grouped_button_text, $external_button_text, $ots_button_text, $default_button_text, $p;
	public static function change_button_text( $btn_text ){
    global $product;


  if ( !$product->is_in_stock() ) {

return __( esc_html__( self::$ots_button_text ), 'woocommerce' ); /*change 'Add to Cart' for Out Of Stock Products */

} else {

    $product_type = $product->get_type();
    switch ( $product_type ) {
    case 'subscription':
    return __( esc_html__( self::$sub_button_text ), 'woocommerce' ); /*change 'Options' for Simple Subscriptions */
    case 'variable-subscription':
    return __( esc_html__( self::$var_sub_button_text ), 'woocommerce' ); /*change 'Options' for Variable Subscriptions */
    case 'variable':
    return __( esc_html__( self::$variable_button_text ), 'woocommerce' ); /*change 'Options' for Variable Products */
    case 'simple':
    return __( esc_html__( self::$simple_button_text ), 'woocommerce' ); /*change 'Add to Cart' for Simple Products */
    case 'grouped':
    return __( esc_html__( self::$grouped_button_text ), 'woocommerce' ); /*change 'Add to Cart' for Grouped Products */
    case 'external':
    return __( esc_html__( self::$external_button_text ), 'woocommerce' ); /*change 'Add to Cart' for External Products */
    break;
    default:
  	return __( esc_html__( self::$default_button_text ), 'woocommerce' );
	}

}

}

public static function change_button_text_single( $button ){
  global $product;

if ( ! $product->managing_stock() && ! $product->is_in_stock() ) {

return __( esc_html__( self::$ots_button_text ), 'woocommerce' ); /*change 'Add to Cart' for Out Of Stock Products */

} else {


  $product_type = $product->get_type();
  switch ( $product_type ) {
  case 'subscription':
  return __( esc_html__( self::$sub_button_text ), 'woocommerce' ); /*change 'Options' for Simple Subscriptions */
  case 'variable-subscription':
  return __( esc_html__( self::$var_sub_button_text ), 'woocommerce' ); /*change 'Options' for Variable Subscriptions */
  case 'variable':
  return __( esc_html__( self::$single_variable_button_text ), 'woocommerce' ); /*change 'Options' for Variable Products */
  case 'simple':
  return __( esc_html__( self::$simple_button_text ), 'woocommerce' ); /*change 'Add to Cart' for Simple Products */
  case 'grouped':
  return __( esc_html__( self::$grouped_button_text ), 'woocommerce' ); /*change 'Add to Cart' for Grouped Products */
  case 'external':
  return __( esc_html__( self::$external_button_text ), 'woocommerce' ); /*change 'Add to Cart' for External Products */
  break;
  default:
  return __( esc_html__( self::$default_button_text ), 'woocommerce' );
}

}

}

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PL Add To Cart - Product Page / Loop Layout', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_atc';

                    $this->settings_modal_toggles = array(

      			'general' => array(
              'toggles' => array(
					'hide_out_stock_button' => esc_html__( 'Add to Cart Button', 'divi-bodyshop-woocommerce' ),
					'quantity' => esc_html__( 'Quantity', 'divi-bodyshop-woocommerce' ),
					'variations' => esc_html__( 'Variations', 'divi-bodyshop-woocommerce' ),
					'stock' => esc_html__( 'Stock', 'divi-bodyshop-woocommerce' ),
				      ),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->fields_defaults = array(
                        'hide_out_stock' 	=> array( 'off' ),
                  			// 'show_quantity' 		=> array( 'on' ),
                  			'hide_variation_price' 	=> array( 'off' ),
                  		);



                      $this->advanced_fields = array(
        			'fonts' => array(
				'quantity_input'   => array(
					'label'    => esc_html__( 'Quantity', 'divi-bodyshop-woocommerce' ),
					'css'      => array(
						'main' => array(
							"body.woocommerce {$this->main_css_element} .quantity input.qty",
						),
						'important' => 'all',
					),
					'font_size' => array(
						'default' => '20px',
					),
					'line_height' => array(
						'default' => '2em',
					),
				),
				'variation_description'   => array(
					'label'    => esc_html__( 'Variation Description', 'divi-bodyshop-woocommerce' ),
					'css'      => array(
						'main' => array(
							"body.woocommerce {$this->main_css_element} .woocommerce-variation-description, body.woocommerce {$this->main_css_element} .variations label",
						),
						'important' => 'all',
					),
					'font_size' => array(
						'default' => '14px',
					),
					'line_height' => array(
						'default' => '1.3em',
					),
				),
				'variation_prices'   => array(
					'label'    => esc_html__( 'Variation Price', 'divi-bodyshop-woocommerce' ),
					'css'      => array(
						'main' => array(
							"body.woocommerce {$this->main_css_element} .woocommerce-variation-price, body.woocommerce {$this->main_css_element} .woocommerce-variation-price .price",
						),
						'important' => 'all',
					),
					'font_size' => array(
						'default' => '17px',
					),
					'line_height' => array(
						'default' => '1.3em',
					),
				),
				'variation_reset'   => array(
					'label'    => esc_html__( 'Variation Reset', 'divi-bodyshop-woocommerce' ),
					'css'      => array(
						'main' => array(
							"body.woocommerce {$this->main_css_element} .reset_variations",
						),
						'important' => 'all',
					),
				),
				'atc_stock_in'   => array(
					'label'    => esc_html__( 'In Stock', 'divi-bodyshop-woocommerce' ),
					'css'      => array(
						'main' => array(
							"body.woocommerce {$this->main_css_element} .in-stock",
						),
						'important' => 'all',
					),
				),
				'atc_stock_back'   => array(
					'label'    => esc_html__( 'Out of Stock', 'divi-bodyshop-woocommerce' ),
					'css'      => array(
						'main' => array(
							"body.woocommerce {$this->main_css_element} .out-of-stock",
						),
						'important' => 'all',
					),
				),
				'atc_stock_out'   => array(
					'label'    => esc_html__( 'Backorder Stock', 'divi-bodyshop-woocommerce' ),
					'css'      => array(
						'main' => array(
							"body.woocommerce {$this->main_css_element} .available-on-backorder",
						),
						'important' => 'all',
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
              'button' => array(
      'button' => array(
        'label' => esc_html__( 'Button', 'divi-bodyshop-woocommerce' ),
        'css' => array(
          'main' => "{$this->main_css_element} .button",
          'important' => 'all',
        ),
        'box_shadow'  => array(
          'css' => array(
            'main' => "{$this->main_css_element} .button",
                'important' => 'all',
          ),
        ),
			'margin_padding' => array(
				'css'           => array(
					'main' => "{$this->main_css_element} .button",
					'important' => 'all',
				),
			),
        'use_alignment' => true,
      ),
'button_disabled' => array(
'label' => esc_html__( 'Disabled Button', 'divi-bodyshop-woocommerce' ),
'css' => array(
  'main' => "{$this->main_css_element} .button.disabled",
  'important' => 'all',
),
'box_shadow'  => array(
  'css' => array(
    'main' => ".woocommerce {$this->main_css_element} a.button.disabled",
  ),
),
),
    ),
        		);

            $this->help_videos = array(
              array(
                'id'   => esc_html__( 'n2karNiwJ3A', 'divi-bodyshop-woocommerce' ), // YouTube video ID
                'name' => esc_html__( 'BodyCommcerce Product Page Template Guide', 'divi-bodyshop-woocommerce' ),
              ),
            );
          }

                  function get_fields() {
                      $fields = array(
      'hide_out_stock' => array(
      'label'           => __( 'Hide out of stock', 'divi-bodyshop-woocommerce' ),
      'type'            => 'yes_no_button',
      'option_category' => 'configuration',
      'options'         => array(
        'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
        'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
        ),
        'description'       => __( 'If you want the button to not show if the product is out of stock, enable this', 'divi-bodyshop-woocommerce' ),
        'toggle_slug'       => 'hide_out_stock_button',
      ),
'variation_archive_page' => array(
'label'           => __( 'Enable variation options on archive page', 'divi-bodyshop-woocommerce' ),
'type'            => 'yes_no_button',
'option_category' => 'configuration',
'options'         => array(
'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
),
'default' => 'off',
'description'       => __( 'If you want to show the variation options on the category page so you can select the options from there, enable this', 'divi-bodyshop-woocommerce' ),
'toggle_slug'       => 'hide_out_stock_button',
),
'fullwidth_button' => array(
'label'           => __( 'Fullwidth Button?', 'divi-bodyshop-woocommerce' ),
'type'            => 'yes_no_button',
'option_category' => 'configuration',
'options'         => array(
'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
),
'default' => 'off',
'description'       => __( 'Enable this if you want your button to go full width', 'divi-bodyshop-woocommerce' ),
'toggle_slug'       => 'hide_out_stock_button',
),


'button_quantity_alignment' => array(
'label'           => __( 'Button & Quantity Alignment', 'divi-bodyshop-woocommerce' ),
'type'            => 'select',
'option_category' => 'configuration',
'options'           => array(
'left'  => esc_html__( 'Left', 'divi-bodyshop-woocommerce' ),
'center' => esc_html__( 'Center', 'divi-bodyshop-woocommerce' ),
'right' => esc_html__( 'Right', 'divi-bodyshop-woocommerce' ),
),
'default' => 'left',
'description'       => __( 'Choose the alignment of the button and quality elements. They will be aligned together', 'divi-bodyshop-woocommerce' ),
'toggle_slug'       => 'hide_out_stock_button',
),

'variations_alignment' => array(
'label'           => __( 'Variations Alignment', 'divi-bodyshop-woocommerce' ),
'type'            => 'select',
'option_category' => 'configuration',
'options'           => array(
'left'  => esc_html__( 'Left', 'divi-bodyshop-woocommerce' ),
'center' => esc_html__( 'Center', 'divi-bodyshop-woocommerce' ),
'right' => esc_html__( 'Right', 'divi-bodyshop-woocommerce' ),
),
'default' => 'left',
'description'       => __( 'Choose the alignment of the variations', 'divi-bodyshop-woocommerce' ),
'toggle_slug'       => 'hide_out_stock_button',
),
			'simple_button_text' => array(
				'label'           => esc_html__( 'Simple Product Button Text', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'default'			=> esc_html__( 'Add to Basket', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Add to Basket', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'hide_out_stock_button',
			),
			'single_variable_button_text' => array(
				'label'           => esc_html__( 'Single Variable Product Button Text', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Add to Basket', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'hide_out_stock_button',
			),
			'variable_button_text' => array(
				'label'           => esc_html__( 'Archive Variable Product Button Text (archive page only)', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'default'			=> esc_html__( 'Select Options', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Select Options', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'hide_out_stock_button',
			),
			'sub_button_text' => array(
				'label'           => esc_html__( 'Subscription Product Button Text', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'default'			=> esc_html__( 'Add to cart', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Add to cart', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'hide_out_stock_button',
			),
			'var_sub_button_text' => array(
				'label'           => esc_html__( 'Variable-Subscription Product Button Text (archive page only)', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'default'			=> esc_html__( 'Select Options', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Select Options', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'hide_out_stock_button',
			),
			'grouped_button_text' => array(
				'label'           => esc_html__( 'Grouped Product Button Text', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'default'			=> esc_html__( 'Add to cart', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Add to cart', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'hide_out_stock_button',
			),
			'external_button_text' => array(
				'label'           => esc_html__( 'External Product Button Text', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'default'			=> esc_html__( 'Buy now', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Buy now', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'hide_out_stock_button',
			),
			'ots_button_text' => array(
				'label'           => esc_html__( 'Out of Stock Product Button Text', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'default'			=> esc_html__( 'Out of stock', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Out of stock', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'hide_out_stock_button',
			),
			'default_button_text' => array(
				'label'           => esc_html__( 'Default Button Text', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'default'			=> esc_html__( 'Read More', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text - if you are using another plugin - the button might default to this one. Default is: Read More', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'hide_out_stock_button',
			),

      'hide_view_cart_text' => array(
      'label'           => __( 'Remove View Cart Link? (on archive pages)', 'divi-bodyshop-woocommerce' ),
      'type'            => 'yes_no_button',
      'option_category' => 'configuration',
      'options'         => array(
      'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
      'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
      ),
      'default'           => 'off',
      'description'       => __( 'If you want to remove the "view cart" text when adding something to the cart, enable this', 'divi-bodyshop-woocommerce' ),
      'toggle_slug'       => 'hide_out_stock_button',
      ),
	'show_quantity' => array(
				'label' => esc_html__( 'Show Quantity Input (if enabled)', 'divi-bodyshop-woocommerce' ),
				'type' => 'yes_no_button',
				'option_category'   => 'configuration',
				'toggle_slug'       => 'hide_out_stock_button',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
				),
				'toggle_slug'       => 'quantity',
			),
			'hide_variation_price' => array(
				'label' => esc_html__( 'Hide Variation Price', 'divi-bodyshop-woocommerce' ),
				'type' => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
				),
				'toggle_slug'       => 'variations',
			),
			'variation_label_ontop' => array(
				'label' => esc_html__( 'Variation Label on Top?', 'divi-bodyshop-woocommerce' ),
				'type' => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
				),
				'description'     => esc_html__( 'If you want to have the label on top of the variation options, enable this', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'variations',
			),
			'variation_reset' => array(
				'label' => esc_html__( 'Hide Variation Reset', 'divi-bodyshop-woocommerce' ),
				'type' => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
				),
				'toggle_slug'       => 'variations',
			),
			'button_alignment' => array(
				'label'            => esc_html__( 'Button Alignment', 'et_builder' ),
				'type'             => 'text_align',
				'option_category'  => 'configuration',
				'options'          => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'alignment',
				'description'      => esc_html__( 'Here you can define the alignment of Button', 'et_builder' ),
			),
			'hide_stock' => array(
				'label' => esc_html__( 'Hide Stock Amount', 'divi-bodyshop-woocommerce' ),
				'type' => 'yes_no_button',
				'option_category'   => 'configuration',
				'options'           => array(
					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
				),
				'toggle_slug'       => 'stock',
			),
                      );

                      return $fields;
                  }




                	public function get_button_alignment() {


                		$text_orientation = isset( $this->props['button_alignment'] ) ? $this->props['button_alignment'] : '';

                		return et_pb_get_alignment( $text_orientation );
                	}

                  function render( $attrs, $content = null, $render_slug ) {

                                        global $product;

                    $single_variable_button_text_get     	= $this->props['single_variable_button_text'];

                      if (isset($single_variable_button_text_get)) {
                        if ($single_variable_button_text_get == "") {
                          if (isset($product)){
                          self::$single_variable_button_text = $product->single_add_to_cart_text();
                        } else {
                        self::$single_variable_button_text = "Add to Basket";
                        }

                        } else {
                    self::$single_variable_button_text     	= $single_variable_button_text_get;
                  }
                  } else {
                    if (isset($product)){
                    self::$single_variable_button_text = $product->single_add_to_cart_text();
                  } else {
                  self::$single_variable_button_text = "Add to Basket";
                  }
                  }

                  self::$simple_button_text     	= $this->props['simple_button_text'];
                  self::$variable_button_text     	= $this->props['variable_button_text'];
                  self::$sub_button_text     	= $this->props['sub_button_text'];
                  self::$var_sub_button_text     	= $this->props['var_sub_button_text'];
                  self::$grouped_button_text     	= $this->props['grouped_button_text'];
                  self::$external_button_text     	= $this->props['external_button_text'];
                  self::$ots_button_text     	= $this->props['ots_button_text'];
                  self::$default_button_text     	= $this->props['default_button_text'];


                  $hide_out_stock				= $this->props['hide_out_stock'];
		              $show_quantity				= $this->props['show_quantity'];
		              $hide_variation_price		= $this->props['hide_variation_price'];
		              $variation_label_ontop		= $this->props['variation_label_ontop'];
                  $variation_reset		= $this->props['variation_reset'];

                  $custom_button  			= $this->props['custom_button'];
                  $custom_icon          		= $this->props['button_icon'];
                  $button_bg_color       		= $this->props['button_bg_color'];
                  $button_use_icon  			= $this->props['button_use_icon'];
                  $button_icon 				= $this->props['button_icon'];
                  $button_icon_placement 		= $this->props['button_icon_placement'];

                  $hide_stock 		= $this->props['hide_stock'];



                  $button_text_color       		= $this->props['button_text_color'];
                  $button_text_color__hover_test = isset($this->props['button_text_color__hover']);
                  if ($button_text_color__hover_test == true) {
                  $button_text_color__hover       		= $this->props['button_text_color__hover'];
                }

                  $custom_button_disabled  			= $this->props['custom_button_disabled'];
                  $custom_icon_button_disabled         		= $this->props['button_disabled_icon'];
                  $button_bg_color_button_disabled       		= $this->props['button_disabled_bg_color'];
                  $button_use_icon_button_disabled  			= $this->props['button_disabled_use_icon'];
                  $button_icon_button_disabled 				= $this->props['button_disabled_icon'];
                  $button_icon_placement_button_disabled 		= $this->props['button_disabled_icon_placement'];

                  $variation_archive_page 		= $this->props['variation_archive_page'];
                  $fullwidth_button		= $this->props['fullwidth_button'];

                  $button_quantity_alignment		= $this->props['button_quantity_alignment'];
                  $variations_alignment		= $this->props['variations_alignment'];
                  $hide_view_cart_text		= $this->props['hide_view_cart_text'];



              		$button_alignment             = $this->get_button_alignment();

                  $data = '';

                  //////////////////////////////////////////////////////////////////////

                  if( is_admin() ){
                    return;
                  }

                  ob_start();
                  if( $button_quantity_alignment != 'left' ){
              			$this->add_classname( 'align_button_quanity_' . $button_quantity_alignment  );
              		}
                  if( $variations_alignment != 'left' ){
              			$this->add_classname( 'align_variations_' . $variations_alignment  );
              		}
                  if( $show_quantity == 'off' ){
              			$this->add_classname( 'hide-quantity' );
              		}
                  if( $variation_label_ontop == 'on' ){
              			$this->add_classname( 'variation-label-ontop' );
              		}
                  if( $fullwidth_button == 'on' ){
              			$this->add_classname( 'fullwidth-button' );
              		}
                  if( $hide_variation_price == 'on' ){
              			$this->add_classname( 'hide-variation-price' );
              		}
                  if( $variation_reset == 'on' ){
              			$this->add_classname( 'hide-variation-reset' );
              		}
                  if( $hide_stock == 'on' ){
              			$this->add_classname( 'hide-stock-amount' );
              		}
                  if( $hide_view_cart_text == 'on' ){
              			$this->add_classname( 'hide-view-cart-text' );
              		}




                  $this->add_classname( 'et_pb_bc_btn' );
                  $this->add_classname( 'et_pb_button_alignment_' . $button_alignment . '' );


              		add_filter( 'add_to_cart_text', array( $this, 'change_button_text' ) );
                  add_filter( 'woocommerce_product_add_to_cart_text', array( $this, 'change_button_text' ) );
                  add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'change_button_text_single' ) );

                  global $product;
                  $q_object = get_queried_object();
                  if(isset($q_object->taxonomy)) {
                  $taxonomy = $q_object->taxonomy;
                } else {
                  $taxonomy = "";
                }

                  if ( is_product_category() || is_shop() || is_product_tag() || is_tax( $taxonomy ) ) {

                    if ( !$product->is_in_stock() && $hide_out_stock == "on" ) {
                    }
                    else if ( !$product->is_in_stock() ) {
                  woocommerce_template_loop_add_to_cart();
                    }
                    else {
                    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
                    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
                    $get_other_settings_add_to_basket_quantity_archive = $titan->getOption( 'other_settings_add_to_basket_quantity_archive' );
                    if ($get_other_settings_add_to_basket_quantity_archive == 1) {
                      if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
                    woocommerce_template_single_add_to_cart();
                  } else {
                    if ($variation_archive_page == "on") {
                      woocommerce_template_single_add_to_cart();
                    }
                    else {
                  woocommerce_template_loop_add_to_cart();
                }
                  }
                    }
                    else {
                      if ($variation_archive_page == "on") {
                        woocommerce_template_single_add_to_cart();
                      }
                      else {
                    woocommerce_template_loop_add_to_cart();
                  }
                    }
                    }

                  } else if ( is_product() ) {

                    if ( !$product->is_in_stock() && $hide_out_stock == "on" ) {
                    }
                    else if ( !$product->is_in_stock() ) {
                  woocommerce_template_single_add_to_cart();
                    }
                    else {
                    woocommerce_template_single_add_to_cart();
                    }
                  }
                  else {
                    return;
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
                      // button text
                      if( !empty( $button_text_color ) ){
                          ET_Builder_Element::set_style( $render_slug, array(
                              'selector'    => 'body #page-container %%order_class%% .button',
                              'declaration' => "color:". esc_attr( $button_text_color ) ."!important;",
                          ) );
                      }
                      // button text hover
                      if( !empty( $button_text_color__hover ) ){
                          ET_Builder_Element::set_style( $render_slug, array(
                              'selector'    => 'body #page-container %%order_class%% .button:hover',
                              'declaration' => "color:". esc_attr( $button_text_color__hover ) ."!important;",
                          ) );
                      }
                  }


                  if( $custom_button_disabled == 'on' ){

                    // button icon
                    if( $button_icon_button_disabled !== '' ){
                      $addToCartIconContent = DEBC_INIT::et_icon_css_content( esc_attr($button_icon_button_disabled) );

                      $addToCartIconSelector = '';
                      if( $button_icon_placement_button_disabled == 'right' ){
                        $addToCartIconSelector = '%%order_class%% li.product .button.disabled:after';
                      }elseif( $button_icon_placement_button_disabled == 'left' ){
                        $addToCartIconSelector = '%%order_class%% li.product .button.disabled:before';
                      }

                      if( !empty( $addToCartIconContent ) && !empty( $addToCartIconSelector ) ){
                        ET_Builder_Element::set_style( $render_slug, array(
                          'selector' => $addToCartIconSelector,
                          'declaration' => "content: '{$addToCartIconContent}'!important;font-family:ETmodules!important;"
                          )
                        );
                      }
                    }

                    // button background
                    if( !empty( $button_bg_color_button_disabled ) ){
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => 'body #page-container %%order_class%% .button.disabled',
                        'declaration' => "background-color:". esc_attr( $button_bg_color_button_disabled ) ."!important;",
                      ) );
                    }
                  }


                  $data = ob_get_clean();
                  //////////////////////////////////////////////////////////////////////


                  return $data;

                  }
              }

            new db_add_to_cart_code;

?>
