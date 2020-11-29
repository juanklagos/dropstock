<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_upsell_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PP Up-Sell - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_upsell';

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
      					'text' => esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
      				),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
        			'fonts' => array(
                'text'   => array(
                                'label'    => esc_html__( 'Text', 'et_builder' ),
                                'css'      => array(
                                        'main' => "{$this->main_css_element}",
                                ),
                                'font_size' => array('default' => '14px'),
                                'line_height'    => array('default' => '1.5em'),
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

                  }

                  function get_fields() {
      $options = DEBC_INIT::get_divi_layouts();

                      $fields = array(
                      'custom_loop' => array(
                      				'label'             => esc_html__( 'Custom Loop layout for the Products?', 'et_builder' ),
                      				'type'              => 'yes_no_button',
                      				'computed_affects' => array(
                      					'__getproupsell',
                      				),
                      				'options'           => array(
                      					'off' => esc_html__( 'No', 'et_builder' ),
                      					'on'  => esc_html__( 'Yes', 'et_builder' ),
                      				),
                      				'affects'=>array(
                              'link_whole_gird',
                      					'loop_layout'
                      				),
                      				'description'        => esc_html__( 'Enable this if you want to use a custom layout - otherwise leave it off to be the default layout', 'et_builder' ),
                      			),
                      'loop_layout' => array(
                      'label'             => esc_html__( 'Loop Layout', 'et_builder' ),
                      'type'              => 'select',
                      'option_category'   => 'layout',
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
                                                  'description' => __( 'the number of upsell items to show. Defaults to 3', 'et_builder' ),
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


                                  'remove_title' => array(
                                          'label'             => esc_html__( 'Remove "You may also like" title?', 'et_builder' ),
                                          'type'              => 'yes_no_button',
                                          'options'           => array(
                                            'off' => esc_html__( 'No', 'et_builder' ),
                                            'on'  => esc_html__( 'Yes', 'et_builder' ),
                                          ),
                                          'description'        => esc_html__( 'Enable this if you want to remove the title "You may also like..."', 'et_builder' ),
                                        ),
                                        'admin_label' => array(
                                            'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                                            'type'        => 'text',
                                            'toggle_slug'     => 'main_content',
                                            'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
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
                                        '__getproupsell' => array(
                                        'type' => 'computed',
                                        'computed_callback' => array( 'db_upsell_code', 'get_pro_upsell' ),
                                        'computed_depends_on' => array(
                                        'admin_label',
                                        'custom_loop'
                                        ),
                                        ),
                            );

                      return $fields;
                  }


                  public static function get_pro_upsell ( $args = array(), $conditional_tags = array(), $current_page = array() ){
                    if (!is_admin()) {
                      			return;
                      		}
                    ob_start();

                    if (is_admin()) {
                        return;
                    }

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
                woocommerce_upsell_display((3 ? 3:3));
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

                    $loop_layout           = $this->props['loop_layout'];
                    $link_whole_gird           = $this->props['link_whole_gird'];
                    $to_show       = $this->props['to_show'];
                    $custom_loop        = $this->props['custom_loop'];
                    $cols           = $this->props['columns'];
                    $columns_tablet           = $this->props['columns_tablet'];
                    $columns_mobile          = $this->props['columns_mobile'];
                    $remove_title          = $this->props['remove_title'];

                    $equal_height 		= $this->props['equal_height'];
                    $align_last_bottom 		= $this->props['align_last_bottom'];

                    $out_of_stock 		= $this->props['out_of_stock'];

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


                  //////////////////////////////////////////////////////////////////////

                  if ( $equal_height == 'on' ) {
                    $this->add_classname('same-height-cards');
                  }
                  if ( $align_last_bottom == 'on' ) {
                    $this->add_classname('align-last-module');
                  }

                  		if( function_exists( 'is_product' ) && is_product() ){

                  if ($custom_loop == 'on') {
                                                // woocommerce_upsell_display(($to_show ? $to_show:3));
                                                $output = sprintf(
                                                '<div class="et_pb_upsells_wrapper et_pb_db_shop_loop">'
                                                );

                                                global $post;

                  $product = new WC_Product($post->ID);
                  $upsells = $product->get_upsell_ids();

                  if(empty($upsells)){
                         return;
                     }

                  $upsell_list =  join(",",$upsells);

                  $upsell_array = array_map( 'trim', explode( ',', $upsell_list ) );

                  if(empty($upsell_array)){
                          return;
                      }

                  $args = array(
                     'post_type'             => 'product',
                     'post_status'           => 'publish',
                      'posts_per_page'      => $to_show,
                     'post__in'            => $upsell_array
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

<?php if ($remove_title == "on") {
}
else { ?>
                  		<h2><?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ) ?></h2>

                    <?php } ?>

                  <?php

                  if ( have_posts() ) {

                    $i = 0;

                  echo '<ul class="et_pb_row_bodycommerce bc_product_grid product bc_product bc_product_' . $cols . ' bc_pro_tab_'. $columns_tablet .'  bc_pro_mob_'. $columns_mobile .'">';

                    while ( have_posts() ) {
                    the_post();
                    $post_link = get_permalink(get_the_ID());
                echo '<li class="bc_product">';

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
                  else {
                    ob_start();
                      woocommerce_upsell_display(($to_show ? $to_show:3));

                        $output = ob_get_contents();
                        ob_end_clean();

                        $this->add_classname( 'et_pb_db_shop_loop' );
                        $this->add_classname( 'bc_default_desk_' . $cols . '' );
                        $this->add_classname( 'bc_default_tab_'. $columns_tablet .'' );
                        $this->add_classname( 'bc_default_mob_'. $columns_mobile .'' );
                  }

                  if( $remove_title == 'on' ){
                    $this->add_classname( 'no-title' );
                  }

                                    return $output;
}

                                   //////////////////////////////////////////////////////////////////////

                  }
              }

            new db_upsell_code;

?>
