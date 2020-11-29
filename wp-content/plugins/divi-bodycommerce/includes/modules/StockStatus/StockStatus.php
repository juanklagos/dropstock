<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_product_stock_status_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PL Stock Status - Product Page / Loop Layout', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_db_stock_status';

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
                      'instock'   => array(
                                        'label'    => esc_html__( 'In Stock Text', 'divi-bodyshop-woocommerce' ),
                                        'css'      => array(
                                                'main' => "{$this->main_css_element} .stock",
                                        ),
                                        'color' => array('default' => '#1ba20b'),
                        ),
                        'outstock'   => array(
                                          'label'    => esc_html__( 'Out of Stock text', 'divi-bodyshop-woocommerce' ),
                                          'css'      => array(
                                                  'main' => "{$this->main_css_element} .out-of-stock",
                                          ),
                                          'color' => array('default' => '#fa3e3e'),
                          ),
                          'backorder'   => array(
                                            'label'    => esc_html__( 'Back-Order text', 'divi-bodyshop-woocommerce' ),
                                            'css'      => array(
                                                    'main' => "{$this->main_css_element} .available-on-backorder, {$this->main_css_element} .backorders",
                                            ),
                                            'color' => array('default' => '#1ba20b'),
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

            $this->help_videos = array(
              array(
                'id'   => esc_html__( 'n2karNiwJ3A', 'divi-bodyshop-woocommerce' ), // YouTube video ID
                'name' => esc_html__( 'BodyCommcerce Product Page Template Guide', 'divi-bodyshop-woocommerce' ),
              ),
            );
          }

                  function get_fields() {
                      $fields = array(
                        'instock_text' => array(
                          'label'           => esc_html__( 'In Stock', 'et_builder' ),
                          'type'            => 'text',
                          'description'     => esc_html__( 'Define the in stock text', 'et_builder' ),
                          'toggle_slug'     => 'main_content',
                          'default'         => 'in stock',
                        ),
                          'outstock_text' => array(
                            'label'           => esc_html__( 'Out Of Stock', 'et_builder' ),
                            'type'            => 'text',
                            'description'     => esc_html__( 'Define the out of stock text', 'et_builder' ),
                            'toggle_slug'     => 'main_content',
                            'default'         => 'out of stock',
                          ),
                            'backorder_text' => array(
                              'label'           => esc_html__( 'Backordered', 'et_builder' ),
                              'type'            => 'text',
                              'description'     => esc_html__( 'Define the backordered text', 'et_builder' ),
                              'toggle_slug'     => 'main_content',
                              'default'         => 'Available on back-order',
                            ),
                    'change_to_variation_stock' => array(
                      'label'             => esc_html__( 'Change to selected variable stock status', 'divi-bodyshop-woocommerce' ),
                      'type'              => 'yes_no_button',
                      'option_category'   => 'configuration',
                      'options' => array(
                        'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                        'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                      ),
                      'toggle_slug' => 'main_content',
                      'description'       => __( 'When you enable this, the stock will change to the selected variation. <b>Works only with variable products</b>. We will also hide the stock on the add to cart module', 'divi-bodyshop-woocommerce' ),
                    ),
                        			'hide_stock_text' => array(
                        				'label' => esc_html__( 'Hide Stock Text when stock is 0 or less? (Manage Stock)', 'divi-bodyshop-woocommerce' ),
                        				'type' => 'yes_no_button',
                        				'option_category' => 'configuration',
                                'description'     => esc_html__( 'This will hide the stock status when the manage stock is enabled at product level when the product quantity is less than 0.', 'et_builder' ),
                        				'options' => array(
                        					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                        					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                        				),
                        				'toggle_slug' => 'main_content',
                        			),
                          			'hide_backorder_text' => array(
                          				'label' => esc_html__( 'Hide Backorder Text (Manage Stock)', 'divi-bodyshop-woocommerce' ),
                          				'type' => 'yes_no_button',
                          				'option_category' => 'configuration',
                                  'description'     => esc_html__( 'This will hide the backorder when the manage stock is enabled at product level.', 'et_builder' ),
                          				'options' => array(
                          					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                          					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                          				),
                          				'toggle_slug' => 'main_content',
                          			),
                            			'hide_remaining_text' => array(
                            				'label' => esc_html__( 'Hide Remaining Stock Text (Manage Stock)', 'divi-bodyshop-woocommerce' ),
                            				'type' => 'yes_no_button',
                            				'option_category' => 'configuration',
                                    'description'     => esc_html__( 'This will hide the remaining stock when the manage stock is enabled at product level.', 'et_builder' ),
                            				'options' => array(
                            					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                            					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                            				),
                            				'toggle_slug' => 'main_content',
                            			),
                              			'hide_number_text' => array(
                              				'label' => esc_html__( 'Hide Stock Number', 'divi-bodyshop-woocommerce' ),
                              				'type' => 'yes_no_button',
                              				'option_category' => 'configuration',
                                      'description'     => esc_html__( 'This will hide the stock number so it will only say "in stock" instead of "3 in stock" for example.', 'et_builder' ),
                              				'options' => array(
                              					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                              					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                              				),
                              				'toggle_slug' => 'main_content',
                              			),
                      );

                      return $fields;
                  }

                  function render( $attrs, $content = null, $render_slug ) {


                    $instock_text     = $this->props['instock_text'];
                    $outstock_text     = $this->props['outstock_text'];
                    $backorder_text    = $this->props['backorder_text'];
                    $change_to_variation_stock  = $this->props['change_to_variation_stock'];

                    $hide_stock_text    = $this->props['hide_stock_text'];
                    $hide_backorder_text    = $this->props['hide_backorder_text'];
                    $hide_remaining_text    = $this->props['hide_remaining_text'];
                    $hide_number_text    = $this->props['hide_number_text'];




                  //////////////////////////////////////////////////////////////////////

                                  if( is_admin() ){
                                    return;
                                  }


                                                                    ob_start();

                                  global $product;

                                  if( $change_to_variation_stock == 'on' && $product->is_type( 'variable' ) ){
                                    $this->add_classname( 'change_to_variation_stock' );
                ?>
                                    <div class='bodycommerce-changes-variation-stock'></div>
                                    <input type="hidden" id="change_stock_instock" name="change_stock_instock" value="<?php echo $instock_text ?>">
                                    <input type="hidden" id="change_stock_outofstock" name="change_stock_outofstock" value="<?php echo $outstock_text ?>">
                                    <input type="hidden" id="change_stock_backorder" name="change_stock_backorder" value="<?php echo $backorder_text ?>">
                <?php
                                  }

                                  $stock_amount = $product->get_stock_quantity();

                                  if ($hide_number_text == "on") {
                                    $getamount = "";
                                  } else {
                                  $getamount = wc_format_stock_quantity_for_display( $stock_amount, $product );
                                }

                                if ( $stock_amount <= get_option( 'woocommerce_notify_low_stock_amount' ) ) {

                                  if ( $getamount <= '0' && $getamount != "" && $hide_stock_text == "on" ) {
                                          $this->add_classname('remove-stock');
                                  }

                                }


                                      // $display      = __( '<div class="stock">'.$instock_text.'</div>', 'woocommerce' );

// print_r($product);

                                       switch ( get_option( 'woocommerce_stock_format' ) ) {
                                         case 'low_amount':
                                           if ( $stock_amount <= get_option( 'woocommerce_notify_low_stock_amount' ) ) {
                                             /* translators: %s: stock amount */
                                             $display = sprintf( __( '<div class="stock">%s '.$instock_text.'</div>', 'woocommerce' ), $getamount );
                                           }
                                           break;
                                         case '':
                                           /* translators: %s: stock amount */
                                           $display = sprintf( __( '<div class="stock">%s '.$instock_text.'</div>', 'woocommerce' ), $getamount );
                                           break;
                                       }

                                       if ( $product->backorders_allowed() && $product->backorders_require_notification() && $hide_backorder_text != "on" ) {
                                         $display .= '<div class="backorders"> ' . __( $backorder_text , 'woocommerce' ) . '</div>';
                                       }

                                       if ( $product->is_in_stock() ) {
                                       $stock_status = $product->get_availability();
                                         if ($stock_status['class'] == "available-on-backorder") {
                                           $display = sprintf( __( '<div class="stock available-on-backorder">'.$backorder_text.'</div>', 'woocommerce' ) );
                                         } else {
                                         $display = sprintf( __( '<div class="stock">'.$instock_text.'</div>', 'woocommerce' ) );
                                       }
                                       }
                                       else {
                                         $display = sprintf( __( '<div class="out-of-stock">'.$outstock_text.'</div>', 'woocommerce' ) );
                                       }

                                       echo $display;

                                       if ( $product->get_stock_quantity() && $hide_remaining_text != "on" ) { // if manage stock is enabled
                                     if ( number_format($product->get_stock_quantity(),0,'','') < 3 ) { // if stock is low
                                     echo '<div class="remaining">Only ' . $getamount . ' left in stock!</div>';
                                     } else {
                                     echo '<div class="remaining">' . $getamount . ' left in stock</div>';
                                     		}
                                     	}

                                       $data = ob_get_clean();

                                   //////////////////////////////////////////////////////////////////////

                                return $data;
                  }
              }

            new db_product_stock_status_code;

?>
