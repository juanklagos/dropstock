<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_product_summary_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

public static $button_text;
public static function change_button_text( $btn_text ){
  if( !empty( self::$button_text ) ){
    $btn_text = esc_html__( self::$button_text );
  }
  return $btn_text;
}

                function init() {
                    $this->name       = esc_html__( '.PP Summary - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_product_summary';

                    $this->settings_modal_toggles = array(
                  			'general' => array(
                  				'toggles' => array(
                  					'add_to_cart_button' => esc_html__( 'Add to Cart Button', 'divi-bodyshop-woocommerce' ),
                  					'quantity' => esc_html__( 'Quantity', 'divi-bodyshop-woocommerce' ),
                  					'variations' => esc_html__( 'Variations', 'divi-bodyshop-woocommerce' ),
                  				),
                  			),
                  			'advanced' => array(
                  				'toggles' => array(
            					           'alignment'  => esc_html__( 'Alignment', 'et_builder' ),
                  					'misc'	=> esc_html__( 'Ratings', 'divi-bodyshop-woocommerce' ),
                  				),
                  			),

                  		);


                      $this->main_css_element = '%%order_class%%';
                      $this->fields_defaults = array(
                  			'show_quantity' 		=> array( 'on' ),
                  			'hide_variation_price' 	=> array( 'off' ),
                  		);


                      $this->advanced_fields = array(
                  			'fonts' => array(
                  				'header'   => array(
                  					'label'    => esc_html__( 'Title', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                  						'main' => "{$this->main_css_element} .product_title",
                  					),
                  					'font_size' => array(
                  						'default' => '30px',
                  					),
                  					'line_height' => array(
                  						'default' => '1em',
                  					),
                  				),
                  				'rating'   => array(
                  					'label'    => esc_html__( 'Rating', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                  						'main' => "{$this->main_css_element} .woocommerce-product-rating, {$this->main_css_element} .woocommerce-product-rating .woocommerce-review-link",
                  					),
                  					'font_size' => array(
                  						'default' => '14px',
                  					),
                  					'line_height' => array(
                  						'default' => '1.7em',
                  					),
                  				),
                  				'price'   => array(
                  					'label'    => esc_html__( 'Price', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                  						'main' => "body.woocommerce div.product {$this->main_css_element} p.price, {$this->main_css_element} p.price",
                  						'important' => 'all',
                  					),
                  					'font_size' => array(
                  						'default' => '17px',
                  					),
                  					'line_height' => array(
                  						'default' => '1em',
                  					),
                  				),
                  				'excerpt'   => array(
                  					'label'    => esc_html__( 'Excerpt', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                  						'main' => "{$this->main_css_element} .woocommerce-product-details__short-description",
                  					),
                  					'font_size' => array(
                  						'default' => '14px',
                  					),
                  					'line_height' => array(
                  						'default' => '1.4em',
                  					),
                  				),
                  				'quantity_input'   => array(
                  					'label'    => esc_html__( 'Quantity', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                  						'main' => array(
                  							"body.woocommerce {$this->main_css_element} .quantity input.qty, {$this->main_css_element} .quantity input.qty",
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
                  							"body.woocommerce {$this->main_css_element} .woocommerce-variation-description, {$this->main_css_element} .woocommerce-variation-description",
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
                  							"body.woocommerce {$this->main_css_element} .woocommerce-variation-price, body.woocommerce {$this->main_css_element} .woocommerce-variation-price .price, {$this->main_css_element} .woocommerce-variation-price .price",
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
                  				'meta'   => array(
                  					'label'    => esc_html__( 'Product Meta', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                  						'main' => "{$this->main_css_element} .product_meta, {$this->main_css_element} .product_meta a",
                  					),
                  					'font_size' => array(
                  						'default' => '14px',
                  					),
                  					'line_height' => array(
                  						'default' => '1.3em',
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
                  						'main' => "{$this->main_css_element} .cart .button",
                  						'important' => 'all',
                  					),
                  					'box_shadow'  => array(
                  						'css' => array(
                  							'main' => 'body #page-container %%order_class%% .cart .button',
                  						),
                  					),
                            'margin_padding' => array(
                            'css'           => array(
                              'main' => "{$this->main_css_element}  .cart .button",
                              'important' => 'all',
                            ),
                            ),
                  				),
                  			),
                  		);
                      $this->custom_css_fields = array(
                  			'title' => array(
                  				'label' => esc_html__( 'Title', 'divi-bodyshop-woocommerce' ),
                  				'selector' => "{$this->main_css_element} .product_title",
                  			),
                  			'price' => array(
                  				'label' => esc_html__( 'Price', 'divi-bodyshop-woocommerce' ),
                  				'selector' => "{$this->main_css_element} .price",
                  			),
                  			'rating' => array(
                  				'label' => esc_html__( 'Rating', 'divi-bodyshop-woocommerce' ),
                  				'selector' => "{$this->main_css_element} .woocommerce-product-rating .woocommerce-review-link",
                  			),
                  			'excerpt' => array(
                  				'label' => esc_html__( 'Excerpt', 'divi-bodyshop-woocommerce' ),
                  				'selector' => "{$this->main_css_element} .woocommerce-product-details__short-description",
                  			),
                  			'quantity' => array(
                  				'label' => esc_html__( 'Quantity', 'divi-bodyshop-woocommerce' ),
                  				'selector' => "body.woocommerce-page div.product {$this->main_css_element} form.cart .quantity, body.woocommerce-page div.product {$this->main_css_element} form.cart .quantity input.qty, {$this->main_css_element} form.cart .quantity, {$this->main_css_element} form.cart .quantity input.qty",
                  			),
                  			'variation_description' => array(
                  				'label' => esc_html__( 'Variation Description', 'divi-bodyshop-woocommerce' ),
                  				'selector' => "{$this->main_css_element} .woocommerce-variation-description",
                  			),
                  			'variation_prices' => array(
                  				'label' => esc_html__( 'Variation Prices', 'divi-bodyshop-woocommerce' ),
                  				'selector' => "{$this->main_css_element} .woocommerce-variation-price .price",
                  			),
                  			'product_meta' => array(
                  				'label' => esc_html__( 'Product Meta', 'divi-bodyshop-woocommerce' ),
                  				'selector' => "{$this->main_css_element} .product_meta, {$this->main_css_element} .product_meta a",
                  			),
                  			'button' => array(
                  				'label'    => esc_html__( 'Add To Cart Button', 'divi-bodyshop-woocommerce' ),
                  				'selector' => "body #page-container {$this->main_css_element} .cart .button",
                  				'no_space_before_selector' => true,
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
                			'button_text' => array(
                				'label'           => esc_html__( 'Button Text', 'divi-bodyshop-woocommerce' ),
                				'type'            => 'text',
                				'default'			=> esc_html__( 'Add To Cart', 'woocommerce' ),
                				'option_category' => 'basic_option',
                				'description'     => esc_html__( 'Input your desired button text. Default is: Add to cart', 'divi-bodyshop-woocommerce' ),
                				'toggle_slug'       => 'add_to_cart_button',
                			),
                			'show_quantity' => array(
                				'label' => esc_html__( 'Show Quantity Input', 'divi-bodyshop-woocommerce' ),
                				'type' => 'yes_no_button',
                				'option_category'   => 'configuration',
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
                			'stars_color' => array(
                				'label'             => esc_html__( 'Stars Color', 'divi-bodyshop-woocommerce' ),
                				'type'     => 'color-alpha',
                				'tab_slug' => 'advanced',
                				'toggle_slug' => 'misc',
                			),
          			'button_alignment' => array(
          				'label'            => esc_html__( 'Button Alignment', 'et_builder' ),
          				'description'      => esc_html__( 'Align your button to the left, right or center of the module.', 'et_builder' ),
          				'type'             => 'text_align',
          				'option_category'  => 'configuration',
          				'options'          => et_builder_get_text_orientation_options( array( 'justified' ) ),
          				'tab_slug'         => 'advanced',
          				'toggle_slug'      => 'alignment',
          				'description'      => esc_html__( 'Here you can define the alignment of Button', 'et_builder' ),
          			),
                		);

                		return $fields;
                	}

                  public function get_button_alignment( $device = 'desktop' ) {
              $suffix           = 'desktop' !== $device ? "_{$device}" : '';
              $text_orientation = isset( $this->props["button_alignment{$suffix}"] ) ? $this->props["button_alignment{$suffix}"] : '';

              return et_pb_get_alignment( $text_orientation );
            }

                  function render( $attrs, $content = null, $render_slug ) {

                    self::$button_text        = $this->props['button_text'];
                		$show_quantity			      = $this->props['show_quantity'];
                		$hide_variation_price   	= $this->props['hide_variation_price'];
                		$stars_color      		    = $this->props['stars_color'];

                    $custom_button  			= $this->props['custom_button'];
                    $custom_icon          		= $this->props['button_icon'];
                    $button_bg_color       		= $this->props['button_bg_color'];
                    $button_use_icon  			= $this->props['button_use_icon'];
                    $button_icon 				= $this->props['button_icon'];
                    $button_icon_placement 		= $this->props['button_icon_placement'];

                    $button_alignment                = $this->get_button_alignment();
                          // Button Alignment.
                    $button_alignments = sprintf( 'et_pb_button_alignment_%1$s', esc_attr( $button_alignment ) );


                      $this->add_classname( $button_alignments );
      

                		$data = '';
                		$hide_qty = '';

                  //////////////////////////////////////////////////////////////////////

                                  if( is_admin() ){
                                    return;
                                  }

                                  ob_start();

                                  if( function_exists( 'is_product' ) && is_product() ){



                              			if( $show_quantity == 'off' ){
                              				$this->add_classname( 'hide-quantity' );
                              			}

                              			// to prevent confliction with add to cart module
                              			remove_all_filters( 'woocommerce_product_single_add_to_cart_text' );
                              			add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'change_button_text' ) );


                              			do_action( 'woocommerce_single_product_summary' );


                              			remove_all_filters( 'woocommerce_product_single_add_to_cart_text' );



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

                              			if( $hide_variation_price == 'on' ){

                              				ET_Builder_Element::set_style( $render_slug, array(
                              					'selector'    => '%%order_class%% .woocommerce-variation-price',
                              					'declaration' => "display:none;",
                              				) );
                              			}

                              			if( !empty( $button_bg_color ) && $button_custom == 'on' ){

                              				ET_Builder_Element::set_style( $render_slug, array(
                              					'selector'    => 'body #page-container %%order_class%% .cart .button',
                              					'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
                              				) );
                              			}

                              			$output = str_replace(
                              				'class="single_add_to_cart_button button alt"',
                              				'class="single_add_to_cart_button button alt"' . $custom_icon
                              				, $data
                              			);

                              			if( !empty( $stars_color ) ){

                              				ET_Builder_Element::set_style( $render_slug, array(
                              					'selector'    => 'body.woocommerce %%order_class%% .star-rating span:before, body.woocommerce-page %%order_class%% .star-rating span:before',
                              					'declaration' => "color: ". esc_attr( $stars_color ) ."!important;",
                              				) );
                              			}
		                                  }

                                  $data = ob_get_clean();

                                   //////////////////////////////////////////////////////////////////////

                                return $data;

              }
            }

            new db_product_summary_code;

?>
