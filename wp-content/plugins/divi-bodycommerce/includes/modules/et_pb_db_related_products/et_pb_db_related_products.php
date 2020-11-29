<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_related_products_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PP Related Products - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_related_products';

                    $this->fields_defaults = array(
                    'custom_loop'         => array( 'off' ),
                    'out_of_stock'         => array( 'on' ),
                    );

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
      				),
      			),
      			'advanced' => array(
      				'toggles' => array(
					      'overlay' => esc_html__( 'Overlay', 'et_builder' ),
      					'text' => esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
      				),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
                  			'fonts' => array(
                  				'header' => array(
                  					'label'    => esc_html__( 'Header', 'et_builder' ),
                  					'css'      => array(
                  						'main' => "{$this->main_css_element} .related > h2",
                  						'important' => array( 'size', 'font-size', 'plugin_all' ),
                  					),
                  					'font_size' => array(
                  						'default' => '26px',
                  					),
                  					'line_height' => array(
                  						'default' => '1em',
                  					),
                  				),
                  				'product_title' => array(
                  					'label'    => esc_html__( 'Product Title', 'et_builder' ),
                  					'css'      => array(
                  						'main' => "body.woocommerce {$this->main_css_element} ul.products li.product h2.woocommerce-loop-product__title, {$this->main_css_element} ul.products li.product h2.woocommerce-loop-product__title",
                  						'important' => array( 'size', 'font-size' ),
                  					),
                  					'font_size' => array(
                  						'default' => '26px',
                  					),
                  					'line_height' => array(
                  						'default' => '1em',
                  					),
                  				),
                  				'product_price' => array(
                  					'label'    => esc_html__( 'Price', 'et_builder' ),
                  					'css'      => array(
                  						'main' => "body.woocommerce {$this->main_css_element} ul.products li.product .price, {$this->main_css_element} ul.products li.product .price",
                  					),
                  					'font_size' => array(
                  						'default' => '14px',
                  					),
                  					'line_height' => array(
                  						'default' => '1.7em',
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
                  				'add_to_cart_button' => array(
                  					'label' => esc_html__( 'Add To Cart Button', 'et_builder' ),
                  					'css' => array(
                  						'main' => "{$this->main_css_element} ul.products li.product .button",
                  						'important' => 'all',
                  					),
                  					'box_shadow' => array(
                  						'css' => array(
                  							'main' => "{$this->main_css_element} ul.products li.product .button",
                  						),
                  					),
                  				),
                  			),
                  		);


                      		$this->custom_css_fields = array(
                      			'overlay'   => array(
                      				'label'    => esc_html__( 'Overlay', 'et_builder' ),
                      				'selector' => '.et_overlay',
                      			),
                      		);

                  }



                  function get_fields() {

$options = DEBC_INIT::get_divi_layouts();

                    $fields = array(
                    'remove_heading' => array(
                            'label'             => esc_html__( 'Remove Heading', 'et_builder' ),
                            'type'              => 'yes_no_button',
                            'options'           => array(
                              'off' => esc_html__( 'No', 'et_builder' ),
                              'on'  => esc_html__( 'Yes', 'et_builder' ),
                            ),
                            'description'        => esc_html__( 'Enable this if you want to remove the Heading', 'et_builder' ),
                          ),
                    'custom_loop' => array(
                    				'label'             => esc_html__( 'Custom Loop layout for the Products?', 'et_builder' ),
                    				'type'              => 'yes_no_button',
                    				'computed_affects' => array(
                    					'__getprorelated',
                    				),
                    				'options'           => array(
                    					'off' => esc_html__( 'No', 'et_builder' ),
                    					'on'  => esc_html__( 'Yes', 'et_builder' ),
                    				),
                    				'affects'=>array(
                            'link_whole_gird',
                    					'loop_layout',
                      					'equal_height',
                        					'align_last_bottom'
                    				),
                    				'description'        => esc_html__( 'Enable this if you want to use a custom layout - otherwise leave it off to be the default layout', 'et_builder' ),
                    			),
                    'loop_layout' => array(
                    'label'             => esc_html__( 'Loop Layout', 'et_builder' ),
                    'type'              => 'select',
                    'option_category'   => 'layout',
                    'default'   => '3',
                    'options'           => $options,
                    'description'        => esc_html__( 'Choose the layout you have made for each product in the loop.', 'et_builder' ),
                    ),
                    'link_whole_gird' => array(
                    'option_category'   => 'layout',
                            'label'             => esc_html__( 'Link each layout to product', 'divi-bodyshop-woocommerce' ),
                            'type'              => 'yes_no_button',
                            'options'           => array(
                              'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                              'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                            ),
                            'description'        => esc_html__( 'Enable this if you want to link each loop layout to the product. For example if you want the whole "grid card" to link to the product page. NB: You need to have no other links on the loop layout so do not link the image or the title to the product page.', 'divi-bodyshop-woocommerce' ),
                          ),
                          'equal_height' => array(
                            'label'             => esc_html__( 'Equal Height Grid Cards', 'divi-bodyshop-woocommerce' ),
                            'type'              => 'yes_no_button',
                            'option_category'   => 'layout',
                            'options'           => array(
                              'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                              'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                            ),
                            'description' => esc_html__( 'Enable this if you have the grid layout and want all your cards to be the same height.', 'divi-bodyshop-woocommerce' ),
                            ),
                            'align_last_bottom' => array(
                            'option_category'   => 'layout',
                            'label'             => esc_html__( 'Align last module at the bottom', 'divi-bodyshop-woocommerce' ),
                            'type'              => 'yes_no_button',
                            'options'           => array(
                            'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                            'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                            ),
                            'description'        => esc_html__( 'Enable this to align the last module (probably the add to cart) at the bottom. Works well when using the equal height.', 'divi-bodyshop-woocommerce' ),
                            ),
                            'out_of_stock' => array(
                              'label'             => esc_html__( 'Show out of stock products?', 'divi-bodyshop-woocommerce' ),
                              'type'              => 'yes_no_button',
                              'option_category'   => 'layout',
                              'options'           => array(
                                'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                                'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                              ),
                              'description' => esc_html__( 'Enable this if you want to display out of stock images.', 'divi-bodyshop-woocommerce' ),
                              ),
                    'to_show' => array(
                    'label'       => __( 'Items to show', 'et_builder' ),
                    'type'        => 'select',
                    'options'     => array(
					'1'    => esc_html__( 'one', 'et_builder' ),
					'2'  => esc_html__( 'Two', 'et_builder' ),
					'3'  => esc_html__( 'Three', 'et_builder' ),
					'4'    => esc_html__( 'Four', 'et_builder' ),
					'5'    => esc_html__( 'Five', 'et_builder' ),
					'6'    => esc_html__( 'Six', 'et_builder' ),
                    ),
                                                'description' => __( 'the number of related items to show. Defaults to 3', 'et_builder' ),
                                ),
                          'to_show_custom' => array(
                          'label'       => __( 'Items to show custom', 'et_builder' ),
                          'type'        => 'text',
                          'description' => __( 'If you want to define a custom number more than 6, write it here', 'et_builder' ),
                          ),
                                'columns' => array(
                                'label'             => esc_html__( 'Grid Columns', 'divi-bodyshop-woocommerce' ),
                                'type'              => 'select',
                                'option_category'   => 'layout',
                                'default'   => '3',
                                'options'           => array(
                                2  => esc_html__( 'Two', 'divi-bodyshop-woocommerce' ),
                                3 => esc_html__( 'Three', 'divi-bodyshop-woocommerce' ),
                                4 => esc_html__( 'Four', 'divi-bodyshop-woocommerce' ),
                                5 => esc_html__( 'Five', 'divi-bodyshop-woocommerce' ),
                                6 => esc_html__( 'Six', 'divi-bodyshop-woocommerce' ),
                                ),
                                'description'        => esc_html__( 'How many columns do you want to see', 'divi-bodyshop-woocommerce' ),
                                ),
                                'columns_tablet' => array(
                                'label'             => esc_html__( 'Tablet Grid Columns', 'divi-bodyshop-woocommerce' ),
                                'type'              => 'select',
                                'option_category'   => 'layout',
                                'default'   => '3',
                                'options'           => array(
                                1  => esc_html__( 'One', 'divi-bodyshop-woocommerce' ),
                                2  => esc_html__( 'Two', 'divi-bodyshop-woocommerce' ),
                                3 => esc_html__( 'Three', 'divi-bodyshop-woocommerce' ),
                                4 => esc_html__( 'Four', 'divi-bodyshop-woocommerce' ),
                                ),
                                'description'        => esc_html__( 'How many columns do you want to see on tablet', 'divi-bodyshop-woocommerce' ),
                                ),
                                'columns_mobile' => array(
                                'label'             => esc_html__( 'Mobile Grid Columns', 'divi-bodyshop-woocommerce' ),
                                'type'              => 'select',
                                'option_category'   => 'layout',
                                'default'   => '1',
                                'options'           => array(
                                1  => esc_html__( 'One', 'divi-bodyshop-woocommerce' ),
                                2  => esc_html__( 'Two', 'divi-bodyshop-woocommerce' ),
                                ),
                                'description'        => esc_html__( 'How many columns do you want to see on mobile', 'divi-bodyshop-woocommerce' ),
                                ),
                                'admin_label' => array(
                                    'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                                    'type'        => 'text',
                                    'toggle_slug'     => 'main_content',
                                    'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                                ),
                                '__getprorelated' => array(
                                'type' => 'computed',
                                'computed_callback' => array( 'db_related_products_code', 'get_pro_related' ),
                                'computed_depends_on' => array(
                                'admin_label',
                                'custom_loop'
                                ),
                                ),

			'icon_hover_color'    => array(
				'label'          => esc_html__( 'Overlay Icon Color', 'et_builder' ),
				'description'    => esc_html__( 'Pick a color to use for the icon that appears when hovering over a product.', 'et_builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'overlay',
				'mobile_options' => true,
			),
			'hover_overlay_color' => array(
				'label'          => esc_html__( 'Overlay Background Color', 'et_builder' ),
				'description'    => esc_html__( 'Here you can define a custom color for the overlay', 'et_builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'overlay',
				'mobile_options' => true,
			),
                          );

                    return $fields;
                }


                public static function get_pro_related ( $args = array(), $conditional_tags = array(), $current_page = array() ){
                  if (!is_admin()) {
                    			return;
                    		}
                  ob_start();


                  $getrelated = array(
                    'post_type' => 'product',
                  'post_status' => 'publish',
                  'posts_per_page' => '3',
                  'orderby' => 'ID',
                  'order' => 'ASC',
                );

                  $loop = new WP_Query( $getrelated );

                  $first = true;
                  while ( $loop->have_posts() ) : $loop->the_post();

                    if ( $first )  {
    //*---------------------------------------------------------------------------------------------------*//

if( $args['custom_loop'] == 'off' ){

              $getproducts = array();
              $defaults = array(
              'posts_per_page' => (3 ? 3:3),
              'columns'        => 3,
              'orderby'        => 'rand'
              );

          $getproducts = wp_parse_args( $getproducts, $defaults );

          woocommerce_related_products( $getproducts );

        }
    else if( $args['custom_loop'] == 'on' ){

          $shop = "<div class='no-html-output'><p>We do not have compatibility for the custom layout yet, only for the default layout. We are working on this still. It will still work as expected on the front-end, you will just not get a live preview.</p></div>";

          return $shop;
        }

    //*---------------------------------------------------------------------------------------------------*//
                  $first = false;
              } else {

              }
            endwhile; wp_reset_query(); // Remember to reset

                  $data = ob_get_clean();

                return $data;

                }

                  function render( $attrs, $content = null, $render_slug ) {


		$icon_hover_color_values   = et_pb_responsive_options()->get_property_values( $this->props, 'icon_hover_color' );
		$hover_overlay_color_value = et_pb_responsive_options()->get_property_values( $this->props, 'hover_overlay_color' );

		// Icon Hover Color.
		et_pb_responsive_options()->generate_responsive_css( $icon_hover_color_values, '%%order_class%% .et_overlay:before', 'color', $render_slug, ' !important;', 'color' );

		// Hover Overlay Color.
		et_pb_responsive_options()->generate_responsive_css(
			$hover_overlay_color_value,
			'%%order_class%% .et_overlay',
			array(
				'background-color',
				'border-color',
			),
			$render_slug,
			' !important;',
			'color'
		);

                    $loop_layout           = $this->props['loop_layout'];
                    $link_whole_gird           = $this->props['link_whole_gird'];
                    $to_show_dis       = $this->props['to_show'];
                    $to_show_custom       = $this->props['to_show_custom'];


                    $custom_loop        = $this->props['custom_loop'];
                		$remove_heading     			= $this->props['remove_heading'];
                    $cols           = $this->props['columns'];
                    $columns_tablet           = $this->props['columns_tablet'];
                    $columns_mobile          = $this->props['columns_mobile'];

                    $equal_height 		= $this->props['equal_height'];
                    $align_last_bottom 		= $this->props['align_last_bottom'];

                    $out_of_stock 		= $this->props['out_of_stock'];

if ($to_show_custom != "") {
  $to_show = $to_show_custom;
}
else {
  $to_show = $to_show_dis;
}


                    if (is_admin()) {
                        return;
                    }

                  //////////////////////////////////////////////////////////////////////

                  if ( $equal_height == 'on' ) {
                    $this->add_classname('same-height-cards');
                  }
                  if ( $align_last_bottom == 'on' ) {
                    $this->add_classname('align-last-module');
                  }

                  if( $remove_heading == 'on' ){
                    $this->add_classname('no-title');
            			}

                  if ($custom_loop == 'on') {
                                                // woocommerce_upsell_display(($to_show ? $to_show:3));
                                                $output = sprintf(
                                                '<div class="et_pb_related_wrapper et_pb_db_shop_loop">'
                                                );

                                                global $post;

if (isset($post->ID)) {
  $tax_array[] = "";

$cats = wp_get_post_terms( $post->ID, "product_cat" );
foreach ( $cats as $cat ) {
    $tax_array[] = $cat->term_id;
}

$tags = wp_get_post_terms( $post->ID, "product_tag" );
foreach ( $tags as $tag ) {
    $tax_array[] = $tag->term_id;
}


                  $args = array(
                     'post_type'             => 'product',
                     'post_status'           => 'publish',
                      'posts_per_page'      => $to_show,
                      'orderby'        => 'rand',
                      'tax_query' => array(
                                      'relation' => 'AND',
                                          array(
                                              'taxonomy' => 'product_visibility',
                                              'field'    => 'name',
                                              'terms'    => 'exclude-from-catalog',
                                              'operator' => 'NOT IN',
                                          ),
                                      array(
                                              'taxonomy' => 'product_cat',
                                              'field' => 'id',
                                              'terms' => $tax_array
                                      )
                              )
                  );

                  if ( is_single() && ! isset( $args['post__not_in'] ) ) {
                    $args['post__not_in'] = array( get_the_ID() );
                  }
              if ($out_of_stock == "off" || $out_of_stock == "") {
                $args['meta_query'] = array (
                  array(
                    'key' => '_stock_status',
                    'value' => 'outofstock',
                    'compare' => '!=',
                      )
                );
              }

                  	query_posts( $args );

                    $products = new WP_Query($args);

                  ob_start();

                  ?>

		<h2><?php esc_html_e( 'Related products', 'woocommerce' ); ?></h2>

                  <?php

                    if ( have_posts() ) {

                      $i = 0;

                    echo '<ul class="et_pb_row_bodycommerce products bc_product_grid bc_product_' . $cols . ' bc_pro_tab_'. $columns_tablet .' bc_pro_mob_'. $columns_mobile .'">';

                      while ( have_posts() ) {
                      the_post();
                      $post_link = get_permalink(get_the_ID());
                  echo '<li class="product bc_product">';


                  if ($link_whole_gird == "on") {
                    ?>
                    <div class="bc-link-whole-grid-card" data-link-url="<?php echo $post_link ?>">
                    <?php   
                  }

                    echo apply_filters('the_content', get_post_field('post_content', $loop_layout));

                    if ($link_whole_gird == "on") {
                      ?>
                      </div>  
                      <?php       
                    }

                    echo '</li>';
                    $i++;

                    }
                    echo '</ul>';
                    wp_reset_query();
                    }

                    $output .= ob_get_contents();
                    ob_end_clean();

                    $output .= sprintf(
                    '</div>'
                    );
                  }
                  }
                  else {
                    ob_start();

                    $args = array();
                                                  $defaults = array(
                                                        'posts_per_page' => ($to_show ? $to_show:$to_show),
                                                        'columns'        => $to_show,
                                                        'orderby'        => 'rand'
                                                  );

                          $args = wp_parse_args( $args, $defaults );

                          woocommerce_related_products( $args );

                        $output = ob_get_contents();
                        ob_end_clean();


                        $this->add_classname( 'bc_default_loop' );
                        $this->add_classname( 'bc_default_desk_' . $cols . '' );
                        $this->add_classname( 'bc_default_tab_'. $columns_tablet .'' );
                        $this->add_classname( 'bc_default_mob_'. $columns_mobile .'' );

                  }




                                    return $output;


                                   //////////////////////////////////////////////////////////////////////

                  }
              }

            new db_related_products_code;

?>
