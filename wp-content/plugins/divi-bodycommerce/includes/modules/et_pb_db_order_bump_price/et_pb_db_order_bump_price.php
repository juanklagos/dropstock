<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_order_bump_price_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.CF Order Bump Price - Checkout Funnel', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_order_bump_price';

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
                  				'price_text'   => array(
                  					'label'    => esc_html__( 'Price', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                  						'main' => "{$this->main_css_element} .price,{$this->main_css_element} p.price span, {$this->main_css_element} .woocommerce-Price-amount.amount, .entry-summary {$this->main_css_element} p.price span, {$this->main_css_element} .bodycommerce-changes-variation-price",
                      					'important' => 'all',
                  					),
                  					'font_size' => array(
                  						'default' => '17px',
                  					),
                  					'line_height' => array(
                  						'default' => '1.3em',
                  					),
                  				),
                    				'txt_before'   => array(
                    					'label'    => esc_html__( 'Before Text', 'divi-bodyshop-woocommerce' ),
                    					'css'      => array(
                    						'main' => ".entry-summary {$this->main_css_element} p.price .bc-price-before",
					                           'important' => 'all',
                    					),
                    					'font_size' => array(
                    						'default' => '17px',
                    					),
                    					'line_height' => array(
                    						'default' => '1.3em',
                    					),
                    				),
                      				'txt_after'   => array(
                      					'label'    => esc_html__( 'After Text', 'divi-bodyshop-woocommerce' ),
                      					'css'      => array(
                      						'main' => ".entry-summary {$this->main_css_element} p.price .bc-price-after",
  					                           'important' => 'all',
                      					),
                      					'font_size' => array(
                      						'default' => '17px',
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
                          'title' => array(
                              'label'       => __( 'Title', 'et_builder' ),
                              'type'        => 'text',
                              'toggle_slug' => 'main_content',
                              'description' => __( 'If you want a title on the price module then use this box and an H2 will be added above the price.', 'et_builder' ),
                          ),
                              'txt_before' => array(
                                  'label'       => __( 'Text directly before', 'et_builder' ),
                                  'type'        => 'text',
                                  'toggle_slug' => 'main_content',
                                  'description' => __( 'If you want to add text directly before on the same line, add it here', 'et_builder' ),
                              ),
                                  'txt_after' => array(
                                      'label'       => __( 'Text directly after', 'et_builder' ),
                                      'type'        => 'text',
                                      'toggle_slug' => 'main_content',
                                      'description' => __( 'If you want to add text directly after on the same line, add it here', 'et_builder' ),
                                  ),
                          'admin_label' => array(
                              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                              'type'        => 'text',
                              'toggle_slug'     => 'main_content',
                              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                          ),
                          '__getbumpproprice' => array(
                          'type' => 'computed',
                          'computed_callback' => array( 'db_order_bump_price_code', 'get_pro_order_bump_price' ),
                          'computed_depends_on' => array(
                          'admin_label'
                          ),
                          ),
                      );

                      return $fields;
                  }

                  public static function get_pro_order_bump_price ( $args = array(), $conditional_tags = array(), $current_page = array() ){
                    if (!is_admin()) {
                			return;
                		}

                    ob_start();

                    $args = array(
                      'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => '3',
                    'orderby' => 'ID',
                    'order' => 'ASC',
                  );

                    $loop = new WP_Query( $args );

                    $first = true;
                    while ( $loop->have_posts() ) : $loop->the_post();

                      if ( $first )  {
//*---------------------------------------------------------------------------------------------------*//

global $post;
$product = new WC_Product( $post->ID );

if( $title != '' ){
  ?><h2><?php echo $title?></h2><?php
}
$amount = DEBC_INIT::get_order_bump_discount();


$newsubtotal = ($product->get_price() / 100) * $amount;
$final_price = wc_price( $product->get_price() - $newsubtotal );
$price_bodycommerce = sprintf( '<s>%s</s> %s', $product->get_price_html(), $final_price );

?>
<span class="price"><span class="bc-price-before"><?php echo $txt_before ?></span><?php echo $price_bodycommerce ?><span class="bc-price-after"><?php echo $txt_after ?></span>
<?php

//*---------------------------------------------------------------------------------------------------*//
                    $first = false;
                } else {

                }
              endwhile; wp_reset_query(); // Remember to reset

                    $data = ob_get_clean();

                  return $data;

                  }

                  function render( $attrs, $content = null, $render_slug ) {

                    $title  = $this->props['title'];
                    $txt_before  = $this->props['txt_before'];
                    $txt_after  = $this->props['txt_after'];


                  $data = '';

                  //////////////////////////////////////////////////////////////////////

                  if( is_admin() ){
                          return;
                          }

        			global $product;


              ob_start();
              if( $title != '' ){
                ?><h2><?php echo $title?></h2><?php
              }
              $amount = DEBC_INIT::get_order_bump_discount();


              $newsubtotal = ($product->get_price() / 100) * $amount;
              $final_price = wc_price( $product->get_price() - $newsubtotal );
              $price_bodycommerce = sprintf( '<s>%s</s> %s', $product->get_price_html(), $final_price );

      ?>
      	<span class="price"><span class="bc-price-before"><?php echo $txt_before ?></span><?php echo $price_bodycommerce ?><span class="bc-price-after"><?php echo $txt_after ?></span>
      <?php


                  $data = ob_get_clean();
                  //////////////////////////////////////////////////////////////////////
                  return $data;

                  }
              }

            new db_order_bump_price_code;

?>
