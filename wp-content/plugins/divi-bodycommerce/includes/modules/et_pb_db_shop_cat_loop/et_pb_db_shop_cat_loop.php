<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_shop_cat_loop_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.ARP Category Loop - Archive Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_shop_cat_loop';

                    $this->fields_defaults = array(
                    'loop_layout'         => array( 'on' ),
                    'fullwidth'         => array( 'on' ),
                    'columns'         => array( '3' ),
                    'show_pagination'   => array( 'on' ),
                    'cat_order'   => array( '1' ),
                    'hide_empty'   => array( 'on' ),
                    'column_style'   => array( 'text-ontop' ),
                    );

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
      				),
      			),
            'advanced' => array(
              'toggles' => array(
                'overlay' => esc_html__( 'Overlay', 'divi-bodyshop-woocommerce' ),
                'image'   => esc_html__( 'Image', 'divi-bodyshop-woocommerce' ),
              ),
            ),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
        			'fonts' => array(
                'text'   => array(
                                'label'    => esc_html__( 'Title', 'divi-bodyshop-woocommerce' ),
                                'css'      => array(
                                        'main' => "{$this->main_css_element} h3, .woocommerce {$this->main_css_element} ul.products li.product h3, .woocommerce-page ul.products li.product h3, .woocommerce-page.et-db #et-boc .et-l {$this->main_css_element} ul.products li.product h3",
                                					'important' => 'all',
                                ),
                                'font_size' => array('default' => '14px'),
                                'line_height'    => array('default' => '1.5em'),
                ),
                  'description'   => array(
                                  'label'    => esc_html__( 'Description', 'divi-bodyshop-woocommerce' ),
                                  'css'      => array(
                                          'main' => "{$this->main_css_element} .cat_desc",
                                  					'important' => 'all',
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

            $this->help_videos = array(
              array(
                'id'   => esc_html__( 'n2karNiwJ3A', 'divi-bodyshop-woocommerce' ), // YouTube video ID
                'name' => esc_html__( 'BodyCommcerce Product Page Template Guide', 'divi-bodyshop-woocommerce' ),
              ),
            );
          }

                  function get_fields() {
                      $fields = array(
                        'fullwidth' => array(
                        'label'             => esc_html__( 'Layout', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'select',
                        'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        'option_category'   => 'layout',
                        'options'           => array(
                        'list'  => esc_html__( 'List', 'divi-bodyshop-woocommerce' ),
                        'off' => esc_html__( 'Grid', 'divi-bodyshop-woocommerce' ),
                        ),
                        'affects'=>array(
                        'columns',
                        'columns_tablet',
                        'columns_mobile',
                        'column_style',
                        'hover_icon',
                        'zoom_icon_color',
                        'hover_overlay_color',
                        ),
                        'description'        => esc_html__( 'Choose if you want it displayed as a list or a grid layout', 'divi-bodyshop-woocommerce' ),
                        'toggle_slug'       => 'main_content',
                        ),

                        'show_all_cat' => array(
                          'label'             => esc_html__( 'Show all categories', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'layout',
                          'options'           => array(
                            'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                            'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                          ),
                  				'description' => esc_html__( 'If on a category page, it will show the categories in that particular category. If you want to show ALL of them, enable this.', 'divi-bodyshop-woocommerce' ),
                          'toggle_slug'       => 'main_content',
                        ),

                        'hide_empty' => array(
                          'label'             => esc_html__( 'Hide Empty Categories?', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'layout',
                          'options'           => array(
                            'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                            'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                          ),
                  				'description' => esc_html__( 'If you want to hide empty categories, enable this.', 'divi-bodyshop-woocommerce' ),
                          'toggle_slug'       => 'main_content',
                        ),

                        'show_count' => array(
                          'label'             => esc_html__( 'Show Product Count?', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'layout',
                          'options'           => array(
                            'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                            'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                          ),
                          'default'           => 'off',
                  				'description' => esc_html__( 'Enable this if you want to show the product count in brackets next to the title.', 'divi-bodyshop-woocommerce' ),
                          'toggle_slug'       => 'main_content',
                        ),

                        'back_to_shop' => array(
                          'label'             => esc_html__( 'Back to Shop Link', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'yes_no_button',
                          'option_category'   => 'layout',
                          'options'           => array(
                            'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                            'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                          ),
                          'affects'=>array(
                          'back_to_shop_text',
                          'back_to_shop_image',
                          'back_to_shop_position'
                          ),
                  				'description' => esc_html__( 'If you want a button that will take them back to the shop, or to the main page where all the categories are, enable this.', 'divi-bodyshop-woocommerce' ),
                          'toggle_slug'       => 'main_content',
                        ),
                        'back_to_shop_text' => array(
                        'option_category'   => 'layout',
                          'label'             => esc_html__( 'Back to shop text', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'text',
                          'depends_show_if'   => 'on',
                          'toggle_slug'       => 'main_content',
                          'default'           => 'All',
                          'description'       => esc_html__( 'Choose what you want the text to say', 'divi-bodyshop-woocommerce' ),
                        ),
                    			'back_to_shop_image' => array(
                    				'label'              => esc_html__( 'Back to shop Image', 'et_builder' ),
                    				'type'               => 'upload',
                            'option_category'   => 'layout',
                            'toggle_slug'       => 'main_content',
                            'depends_show_if'   => 'on',
                    				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
                    				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
                    				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
                    				'affects'            => array(
                    					'alt',
                    	    				),
                    				'description'        => esc_html__( 'Upload the image for the back to shop category item, if you do not set it, we wont show the image', 'et_builder' ),
                    			),
                        'back_to_shop_position' => array(
                        'label'             => esc_html__( 'Back to shop position', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'select',
                        'option_category'   => 'layout',
                        'toggle_slug'       => 'main_content',
                        'options'           => array(
                        'start'  => esc_html__( 'Start of category list', 'divi-bodyshop-woocommerce' ),
                        'end' => esc_html__( 'End of category list', 'divi-bodyshop-woocommerce' ),
                        ),
                        'default'           => 'start',
                        'depends_show_if' => 'on',
                        'description'        => esc_html__( 'Choose where you want the link to appear on the category list', 'divi-bodyshop-woocommerce' ),
                        ),

                        'column_style' => array(
                        'label'             => esc_html__( 'Column Style', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'select',
                        'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        'option_category'   => 'layout',
                        'options'           => array(
                        'text-ontop'  => esc_html__( 'Title Above Image', 'divi-bodyshop-woocommerce' ),
                        'text-appeartop'  => esc_html__( 'Title On Top Image', 'divi-bodyshop-woocommerce' ),
                        'text-below' => esc_html__( 'Title Below Image', 'divi-bodyshop-woocommerce' ),
                        ),
                        'affects'            => array(
                          'tile_hover_not',
                              ),
                        'depends_show_if' => 'off',
                        'description'        => esc_html__( 'Choose the style of the grid layout', 'divi-bodyshop-woocommerce' ),
                        'toggle_slug'       => 'main_content',
                        ),


                                                'tile_hover_not' => array(
                                                  'label'             => esc_html__( 'Show Title on Hover?', 'divi-bodyshop-woocommerce' ),
                                                  'type'              => 'yes_no_button',
                                                  'option_category'   => 'layout',
                                                  'options'           => array(
                                                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                                                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                                                  ),
                                                  'default'           => 'on',
                                                  'depends_show_if' => 'text-appeartop',
                                          				'description' => esc_html__( 'If you want to hide empty categories, enable this.', 'divi-bodyshop-woocommerce' ),
                                                  'toggle_slug'       => 'main_content',
                                                ),



                        'columns' => array(
                        'label'             => esc_html__( 'Grid Columns', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'select',
                        'computed_affects' => array(
                          '__getcategoryarchive',
                        ),
                        'option_category'   => 'layout',
                        'options'           => array(
                        1  => esc_html__( 'One', 'divi-bodyshop-woocommerce' ),
                        2  => esc_html__( 'Two', 'divi-bodyshop-woocommerce' ),
                        3 => esc_html__( 'Three', 'divi-bodyshop-woocommerce' ),
                        4 => esc_html__( 'Four', 'divi-bodyshop-woocommerce' ),
                        5 => esc_html__( 'Five', 'divi-bodyshop-woocommerce' ),
                        6 => esc_html__( 'Six', 'divi-bodyshop-woocommerce' ),
                        ),
                        'depends_show_if' => 'off',
                        'description'        => esc_html__( 'How many columns do you want to see', 'divi-bodyshop-woocommerce' ),
                        'toggle_slug'       => 'main_content',
                        ),
                        'columns_tablet' => array(
                        'label'             => esc_html__( 'Tablet Grid Columns', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'select',
                        'option_category'   => 'layout',
                        'toggle_slug'       => 'main_content',
                        'default'   => '2',
                        'options'           => array(
                        1  => esc_html__( 'One', 'divi-bodyshop-woocommerce' ),
                        2  => esc_html__( 'Two', 'divi-bodyshop-woocommerce' ),
                        3 => esc_html__( 'Three', 'divi-bodyshop-woocommerce' ),
                        4 => esc_html__( 'Four', 'divi-bodyshop-woocommerce' ),
                        ),
                        'depends_show_if' => 'off',
                        'description'        => esc_html__( 'How many columns do you want to see on tablet', 'divi-bodyshop-woocommerce' ),
                        ),
                        'columns_mobile' => array(
                        'label'             => esc_html__( 'Mobile Grid Columns', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'select',
                        'option_category'   => 'layout',
                        'toggle_slug'       => 'main_content',
                        'default'   => '1',
                        'options'           => array(
                        1  => esc_html__( 'One', 'divi-bodyshop-woocommerce' ),
                        2  => esc_html__( 'Two', 'divi-bodyshop-woocommerce' ),
                        ),
                        'depends_show_if' => 'off',
                        'description'        => esc_html__( 'How many columns do you want to see on mobile', 'divi-bodyshop-woocommerce' ),
                        ),
                        'text_orientation' => array(
                                        'label'             => esc_html__( 'Text Orientation', 'divi-bodyshop-woocommerce' ),
                                        'type'              => 'select',
                                        'option_category'   => 'layout',
                                        'options'           => et_builder_get_text_orientation_options(),
                                        'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'divi-bodyshop-woocommerce' ),
                                        'toggle_slug'       => 'main_content',
                        ),
                        'hide_description' => array(
                        'label'             => esc_html__( 'Hide Descriptions', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'select',
                        'options'           => array(
                        "off"  => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                        "on" => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                        ),
                        'description'        => esc_html__( 'If you want to only show the title and image and hide the descriptions, check this.', 'divi-bodyshop-woocommerce' ),
                        'toggle_slug'       => 'main_content',
                        ),
                        'cat_order' => array(
                        'label'             => esc_html__( 'Category Orderby', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'select',
                				'computed_affects' => array(
                					'__getcategoryarchive',
                				),
                        'options'           => array(
                        "1"  => esc_html__( 'Name', 'divi-bodyshop-woocommerce' ),
                        "2" => esc_html__( 'Category Order', 'divi-bodyshop-woocommerce' ),
                        ),
                        'description'        => esc_html__( 'Select how you want the categories ordered.', 'divi-bodyshop-woocommerce' ),
                        'toggle_slug'       => 'main_content',
                        ),
                        'zoom_icon_color' => array(
                          'label'             => esc_html__( 'Zoom Icon Color', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'color-alpha',
                          'custom_color'      => true,
                          'depends_show_if'   => 'off',
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'overlay',
                        ),
                        'hover_overlay_color' => array(
                          'label'             => esc_html__( 'Hover Overlay Color', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'color-alpha',
                          'custom_color'      => true,
                          'depends_show_if'   => 'off',
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'overlay',
                        ),
                        'hover_icon' => array(
                          'label'               => esc_html__( 'Hover Icon Picker', 'divi-bodyshop-woocommerce' ),
                          'type'                => 'text',
                          'option_category'     => 'configuration',
                          'class'               => array( 'et-pb-font-icon' ),
                          'renderer'            => 'select_icon',
                          'renderer_with_field' => true,
                          'depends_show_if'     => 'off',
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'overlay',
                        ),
                        '__getcategoryarchive' => array(
                          'type' => 'computed',
                          'computed_callback' => array( 'db_shop_cat_loop_code', 'get_cat_archive' ),
                          'computed_depends_on' => array(
                          'fullwidth',
                          'column_style',
                          'columns',
                          'cat_order'
                          ),
                        ),

                      );

                      return $fields;
                  }


                  public static function get_cat_archive ( $args = array(), $conditional_tags = array(), $current_page = array() ){
                    if (!is_admin()) {
                			return;
                		}

                    ob_start();

                    $column_style           = $args['column_style'];
                    $fullwidth           = $args['fullwidth'];
                    $cols                   = $args['columns'];
                    $cat_order              = $args['cat_order'];


                    $taxonomy     = 'product_cat';
                    $orderby      = 'title';
                    $show_count   = 0;      // 1 for yes, 0 for no
                    $pad_counts   = 0;      // 1 for yes, 0 for no
                    $hierarchical = 1;      // 1 for yes, 0 for no
                    $title        = '';
                    $empty        = 0;

                    if ($cat_order == 1) { // NAME
                      $get_categories_args = array(
                        'taxonomy'     => $taxonomy,
                        'orderby'      => $orderby,
                        'show_count'   => $show_count,
                        'pad_counts'   => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li'     => $title,
                        'hide_empty'   => 1
                      );
                    }
                    else if ($cat_order == 2) { // CAT ORDER
                      $get_categories_args = array(
                             'show_count'   => $show_count,
                             'pad_counts'   => $pad_counts,
                             'hierarchical' => $hierarchical,
                             'title_li'     => $title,
                             'hide_empty'   => 1,
                             'taxonomy' => $taxonomy,
                             'menu_order' => 'asc',
                      );
                    }
                    else {
                      $get_categories_args = array(
                        'taxonomy'     => $taxonomy,
                        'orderby'      => $orderby,
                        'show_count'   => $show_count,
                        'pad_counts'   => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li'     => $title,
                        'hide_empty'   => 1
                      );
                    }

                    $all_categories = get_categories( $get_categories_args );

                    if ( $all_categories != "0" ) {
                    $shortcodes = '';

                    $i = 0;
                    echo '<div class="et_pb_db_shop_loop">';
                    if ($fullwidth == 'off') { //grid
                    echo '<ul class="et_pb_row_bodycommerce products bc_product_grid bc_product_' . $cols . ' bc_pro_tab_'. $columns_tablet .' bc_pro_mob_'. $columns_mobile .'">';
                    }
                  else if ($fullwidth  == 'list') {
                  echo '<ul class="et_pb_row_bodycommerce products">';
                  }

                    foreach ($all_categories as $cat) {
                      if($cat->category_parent == 0) {


/////////////////

                            if ($fullwidth == 'off') { //grid

                              echo '<li class="category-name_'. $cat->slug .' et_pb_db_cat_column product bc_product">';


                            } else if ($fullwidth != 'off') {
                              $category_id = $cat->term_id;
                              echo '<a href="'. get_term_link($cat->slug, 'product_cat') .'">';


                              $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                                    $image = wp_get_attachment_url( $thumbnail_id );
                                    if ( $image ) {
                                      ?>
                                      <span class="et_portfolio_image">
                                        <img src="<?php echo $image; ?>" alt="<?php echo $cat->name; ?>" />

                                      </span>
                                      <?php
                                  }

                              echo '<h3 style="padding-top:20px;">'. $cat->name .' <span class="catcount">('. $cat->count .')</span></h3></a>';


              echo '<div class="cat_desc"><p>' . $cat->description . '</p></div>';

                          }

                    if ($column_style == "text-ontop" && $fullwidth == 'off' ){


                      $category_id = $cat->term_id;
                      echo '<a href="'. get_term_link($cat->slug, 'product_cat') .'"><h3>'. $cat->name .' <span class="catcount">('. $cat->count .')</span></h3>';


                      $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                            $image = wp_get_attachment_url( $thumbnail_id );
                            if ( $image ) {
                    ?>
                    <span class="et_portfolio_image">
                      <img src="<?php echo $image; ?>" alt="<?php echo $cat->name; ?>" />

                    </span>
                    <?php


                          }

                          echo '</a>';
            echo '<div class="cat_desc"><p>' . $cat->description . '</p></div>';

                    }
                    else if ($column_style == "text-below" && $fullwidth == 'off') {


                      $category_id = $cat->term_id;
                      echo '<a href="'. get_term_link($cat->slug, 'product_cat') .'">';


                      $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                            $image = wp_get_attachment_url( $thumbnail_id );
                            if ( $image ) {
                              ?>
                              <span class="et_portfolio_image">
                                <img src="<?php echo $image; ?>" alt="<?php echo $cat->name; ?>" />

                              </span>
                              <?php
                          }

                          echo '<h3>'. $cat->name .' <span class="catcount">('. $cat->count .')</span></h3></a>';
          echo '<div class="cat_desc"><p>' . $cat->description . '</p></div>';
                    }

echo '</li>';

/////////////////

                                }
                            }

                            echo '</ul>';
                                                echo '</div>';



                    wp_reset_query();
                    } else {
                    if ( et_is_builder_plugin_active() ) {
                    include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
                    } else {
                    get_template_part( 'includes/no-results', 'index' );
                    }
                    }

                    $data = ob_get_clean();

                  return $data;

                  }



                  function render( $attrs, $content = null, $render_slug ) {

                    $background_layout = '';
                    $cols                   = $this->props['columns'];
                    $columns_tablet           = $this->props['columns_tablet'];
                    $columns_mobile          = $this->props['columns_mobile'];
                    $column_style           = $this->props['column_style'];
                    $text_orientation       = $this->props['text_orientation'];
                    $hide_description       = $this->props['hide_description'];
                    $cat_order              = $this->props['cat_order'];

                    $fullwidth           = $this->props['fullwidth'];
                		$zoom_icon_color     = $this->props['zoom_icon_color'];
                		$hover_overlay_color = $this->props['hover_overlay_color'];
                		$hover_icon          = $this->props['hover_icon'];

                    $show_all_cat          = $this->props['show_all_cat'];


                    $back_to_shop          = $this->props['back_to_shop'];
                    $back_to_shop_text          = $this->props['back_to_shop_text'];
                    $back_to_shop_image          = $this->props['back_to_shop_image'];
                    $back_to_shop_position          = $this->props['back_to_shop_position'];

                    $hide_empty          = $this->props['hide_empty'];
                    $tile_hover_not          = $this->props['tile_hover_not'];

                    $show_count          = $this->props['show_count'];


                    if ( $tile_hover_not == 'off' ) {
                      $this->add_classname('show-title-always');
                    }
                    if ( $show_count == 'on' ) {
                      $this->add_classname('show-catcount');
                    }


$back_shop = "";
if ($fullwidth == 'off') { // grid
if ($back_to_shop == "on") {
$shop_page_url = wc_get_page_permalink( 'shop' );

if ($back_to_shop_image != "") {
  $back_image = '<span class="et_portfolio_image"><img src="'.$back_to_shop_image.'" alt="'.$back_to_shop_text.'" /><span class="et_overlay"></span></span>';
} else {
  $back_image = "";
}

$back_shop = '
<li class="et_pb_db_cat_column product bc_product">
<a href="'.$shop_page_url.'"><h3>'.$back_to_shop_text.'</h3>
'.$back_image.'
</a>
</li>
';

}
} else {
if ($back_to_shop == "on") {

  if ($back_to_shop_image != "") {
    $back_image = '<span class="et_portfolio_image"><img src="'.$back_to_shop_image.'" alt="'.$back_to_shop_text.'" /><span class="et_overlay"></span></span>';
  } else {
    $back_image = "";
  }

$shop_page_url = wc_get_page_permalink( 'shop' );
  $back_shop = '
  <a href="'.$shop_page_url.'"><h3 style="padding-top:20px;">'.$back_to_shop_text.'</h3>
  '.$back_image.'
  </a>
  ';
}
}


                  //////////////////////////////////////////////////////////////////////


                  if( is_admin() ){
                    return;
                  }

                  ob_start();

                                  global $paged;


                                  $container_is_closed = false;

                                  $overlay = "";
                                  // Set inline style
                                  if ( '' !== $zoom_icon_color ) {
                                    ET_Builder_Element::set_style( $render_slug, array(
                                      'selector'    => '%%order_class%% .et_overlay:before',
                                      'declaration' => sprintf(
                                        'color: %1$s !important;',
                                        esc_html( $zoom_icon_color )
                                      ),
                                    ) );


                                  }

                                  if ( '' !== $hover_overlay_color ) {
                                    ET_Builder_Element::set_style( $render_slug, array(
                                      'selector'    => '%%order_class%% .et_overlay',
                                      'declaration' => sprintf(
                                        'background-color: %1$s;
                                        border-color: %1$s;',
                                        esc_html( $hover_overlay_color )
                                      ),
                                    ) );
                                  }


                                  // setup overlay
                                  if ( 'on' !== $fullwidth ) {
                                    $data_icon = '' !== $hover_icon
                                      ? sprintf(
                                        ' data-icon="%1$s"',
                                        esc_attr( et_pb_process_font_icon( $hover_icon ) )
                                      )
                                      : '';


                                    $overlay = sprintf( '<span class="et_overlay%1$s"%2$s></span>',
                                      ( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
                                      $data_icon
                                    );
                                  }

                                  if ( is_rtl() && 'left' === $text_orientation ) {
                                                  $text_orientation = 'right';
                                  }




                                  if ($fullwidth == 'list') {
                                  echo '<style>.et_shop_image {display:inline-block;}</style>';
                                  } else {
                                  }





                                  if ( is_shop() || $show_all_cat == "on" ) {

                                    if ($hide_empty == "off") {
                                      $hide_empty = 0;
                                    } else {
                                      $hide_empty = 1;
                                    }


                                    $taxonomy     = 'product_cat';
                                    $orderby      = 'title';
                                    $show_count   = 0;      // 1 for yes, 0 for no
                                    $pad_counts   = 0;      // 1 for yes, 0 for no
                                    $hierarchical = 1;      // 1 for yes, 0 for no
                                    $title        = '';
                                    $empty        = 0;

                          if ($cat_order == 1) { // NAME
                            $args = array(
                              'taxonomy'     => $taxonomy,
                              'orderby'      => $orderby,
                              'show_count'   => $show_count,
                              'pad_counts'   => $pad_counts,
                              'hierarchical' => $hierarchical,
                              'title_li'     => $title,
                              'hide_empty'   => $hide_empty
                            );
                          }
                          else if ($cat_order == 2) { // CAT ORDER
                            $args = array(
                                   'show_count'   => $show_count,
                                   'pad_counts'   => $pad_counts,
                                   'hierarchical' => $hierarchical,
                                   'title_li'     => $title,
                                   'hide_empty'   => $hide_empty,
                                   'taxonomy' => $taxonomy,
                                   'menu_order' => 'asc',
                            );
                          }
                          else {
                            $args = array(
                              'taxonomy'     => $taxonomy,
                              'orderby'      => $orderby,
                              'show_count'   => $show_count,
                              'pad_counts'   => $pad_counts,
                              'hierarchical' => $hierarchical,
                              'title_li'     => $title,
                              'hide_empty'   => $hide_empty
                            );
                          }



                                  $all_categories = get_categories( $args );


                                  if ( $all_categories != "0" ) {
                                  $shortcodes = '';

                                  $i = 0;
                                  echo '<div class="et_pb_db_shop_loop">';
                                  if ($fullwidth == 'off') { //grid
                                  echo '<ul class="et_pb_row_bodycommerce products bc_product_grid bc_product_' . $cols . ' bc_pro_tab_'. $columns_tablet .' bc_pro_mob_'. $columns_mobile .'">';
                                  }
                                else if ($fullwidth  == 'list') {
                                echo '<ul class="et_pb_row_bodycommerce products">';
                                }

                                if ($back_to_shop_position == "start") {
                                    echo $back_shop;
                                  }

                          foreach ($all_categories as $cat) {
                            if($cat->category_parent == 0) {


/////////////////

                                  if ($fullwidth == 'off') { //grid

                                    echo '<li class="category-name_'. $cat->slug .' et_pb_db_cat_column product">';

                                  } else if ($fullwidth != 'off') {
                                    $category_id = $cat->term_id;
                                    echo '<a href="'. get_term_link($cat->slug, 'product_cat') .'">';


                                    $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                                          $image = wp_get_attachment_url( $thumbnail_id );
                                          if ( $image ) {
                                            ?>
                                            <span class="et_portfolio_image">
                                              <img src="<?php echo $image; ?>" alt="<?php echo $cat->name; ?>" />
                                            <?php echo $overlay; ?>
                                            </span>
                                            <?php
                                        }

                                    echo '<h3 style="padding-top:20px;">'. $cat->name .' <span class="catcount">('. $cat->count .')</span></h3></a>';


                                    if ($hide_description == 'on') {
                                    }
                                    else {
                                    echo "<p>";
                                    echo '<div class="cat_desc"><p>' . $cat->description . '</p></div>';
                                    echo "</p>";
                          }

                                }
                          if ($column_style == "text-ontop" && $fullwidth == 'off' ){


                            $category_id = $cat->term_id;
                            echo '<a href="'. get_term_link($cat->slug, 'product_cat') .'"><h3>'. $cat->name .' <span class="catcount">('. $cat->count .')</span></h3>';


                            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                                  $image = wp_get_attachment_url( $thumbnail_id );
                                  if ( $image ) {
                          ?>
                          <span class="et_portfolio_image">
                            <img src="<?php echo $image; ?>" alt="<?php echo $cat->name; ?>" />
                          <?php echo $overlay; ?>
                          </span>
                          <?php


                                }

                                echo '</a>';
                              if ($hide_description == 'on') {
                              }
                              else {
                                echo '<div class="cat_desc"><p>' . $cat->description . '</p></div>';
                          }

                          }
                          else if ($column_style == "text-below" && $fullwidth == 'off') {


                            $category_id = $cat->term_id;
                            echo '<a href="'. get_term_link($cat->slug, 'product_cat') .'">';


                            $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                                  $image = wp_get_attachment_url( $thumbnail_id );
                                  if ( $image ) {
                                    ?>
                                    <span class="et_portfolio_image">
                                      <img src="<?php echo $image; ?>" alt="<?php echo $cat->name; ?>" />
                                    <?php echo $overlay; ?>
                                    </span>
                                    <?php
                                }

                                echo '<h3>'. $cat->name .' <span class="catcount">('. $cat->count .')</span></h3></a>';
                                if ($hide_description == 'on') {
                                }
                                else {
                          echo '<div class="cat_desc"><p>' . $cat->description . '</p></div>';
                          }
                          } else if ($column_style == "text-appeartop" && $fullwidth == 'off') {

                          $category_id = $cat->term_id;
                          echo '<a href="'. get_term_link($cat->slug, 'product_cat') .'">';
                          ?><div class="appeartop_text_cont"><?php

                          $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                          $image = wp_get_attachment_url( $thumbnail_id );
                          if ( $image ) {
                            ?>
                            <span class="et_portfolio_image">
                              <img src="<?php echo $image; ?>" alt="<?php echo $cat->name; ?>" />
                            <?php echo $overlay; ?>
                            <span class="appeartop_text">
                              <?php

                                                        echo '<h3>'. $cat->name .' <span class="catcount">('. $cat->count .')</span></h3>';
                                                        if ($hide_description == 'on') {
                                                        }
                                                        else {
                                                        echo  $cat->description;
                                                        }
                              ?>
                            </span>
                            </span>

                            <?php
                          } else {
                            echo '<h3>'. $cat->name .' <span class="catcount">('. $cat->count .')</span></h3>';
                            if ($hide_description == 'on') {
                            }
                            else {
                            echo  $cat->description;
                            }
                          }
                          ?>
                          </div>
                          </a>
                          <?php
                          }

                          if ($fullwidth == 'off') { //grid
                                                  echo '</li>';
                        }

/////////////////

                                      }
                                  }

                                  if ($back_to_shop_position == "end") {
                                  echo $back_shop;
                                  }

                    echo '</ul>';
                                        echo '</div>';



                                  wp_reset_query();
                                  } else {
                                  if ( et_is_builder_plugin_active() ) {
                                  include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
                                  } else {
                                  get_template_part( 'includes/no-results', 'index' );
                                  }
                                  }

                                }

else if (is_product_category()) {


                          global $post;
                          $cate = get_queried_object();
                          $cateID = $cate->term_id;

                          if ($hide_empty == "off") {
                            $hide_empty = false;
                          } else {
                            $hide_empty = true;
                          }


                          if ($cat_order == 1) { // NAME
                          $terms = get_terms('product_cat', array('hide_empty' => $hide_empty, 'orderby' => 'ASC', 'parent' => $cateID, ));
                          }
                          else if ($cat_order == 2) { // CAT ORDER
                          $terms = get_terms('product_cat', array('hide_empty' => $hide_empty, 'menu_order' => 'asc', 'parent' => $cateID, ));
                          }
                          else {
                          $terms = get_terms('product_cat', array('hide_empty' => $hide_empty, 'orderby' => 'ASC', 'parent' => $cateID, ));
                          }

                          ///////////////// CATEGORY


                          if ( $terms != "0" ) {

                          $shortcodes = '';

                          $i = 0;
                          echo '<div class="et_pb_db_shop_loop">';
                          if ($fullwidth == 'off') { //grid
                          echo '<ul class="et_pb_row_bodycommerce products bc_product_grid bc_product_' . $cols . ' bc_pro_tab_'. $columns_tablet .' bc_pro_mob_'. $columns_mobile .'">';
                          }
                        else if ($fullwidth  == 'list') {
                        echo '<ul class="et_pb_row_bodycommerce products">';
                        }


                        if ($back_to_shop_position == "start") {
                            echo $back_shop;
                          }



                          foreach ( $terms as $term ){
                            $category_id = $term->term_id;
                            $category_name = $term->name;
                            $category_slug = $term->slug;
                            $category_description = $term->description;



                            if ($fullwidth == 'off') { //grid

                              echo '<li class="category-name_'. $cate->slug .' et_pb_db_cat_column product bc_product ">';

                            }

                          ///////////

                          if ($fullwidth != 'off') {
                            $category_id = $term->term_id;
                            echo '<a href="'. get_term_link($category_slug, 'product_cat') .'">';


                            $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                            $image = wp_get_attachment_url( $thumbnail_id );
                            if ( $image ) {
                              ?>
                              <span class="et_portfolio_image">
                                <img src="<?php echo $image; ?>" alt="<?php echo $category_name; ?>" />
                              <?php echo $overlay; ?>
                              </span>
                              <?php
                            }
                            echo '<h3 style="padding-top:20px;">'. $category_name .'</h3></a>';
                            if ($hide_description == 'on') {
                            }
                            else {
                            echo "<p>";
                            echo  $category_description;
                            echo "</p>";
                          }
                          }


                          if ($column_style == "text-ontop" && $fullwidth == 'off' ){

                          $category_id = $term->term_id;
                          echo '<a href="'. get_term_link($category_slug, 'product_cat') .'"><h3>'. $category_name .'</h3>';


                          $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                          $image = wp_get_attachment_url( $thumbnail_id );
                          if ( $image ) {
                            ?>
                            <span class="et_portfolio_image">
                              <img src="<?php echo $image; ?>" alt="<?php echo $category_name; ?>" />
                            <?php echo $overlay; ?>
                            </span>
                            <?php
                          }

                          echo '</a>';
                          if ($hide_description == 'on') {
                          }
                          else {
                          echo  $category_description;
                          }

                          }
                          else if ($column_style == "text-below"  && $fullwidth == 'off') {



                          echo '<a href="'. get_term_link($category_slug, 'product_cat') .'">';


                          $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                          $image = wp_get_attachment_url( $thumbnail_id );
                          if ( $image ) {
                            ?>
                            <span class="et_portfolio_image">
                              <img src="<?php echo $image; ?>" alt="<?php echo $category_name; ?>" />
                            <?php echo $overlay; ?>
                            </span>
                            <?php
                          }

                          echo '<h3>'. $category_name .'</h3></a>';
                          if ($hide_description == 'on') {
                          }
                          else {
                          echo  $category_description;
                          }
                          } else if ($column_style == "text-appeartop"  && $fullwidth == 'off') {



                          echo '<a href="'. get_term_link($category_slug, 'product_cat') .'">';
                          ?><div class="appeartop_text_cont"><?php

                          $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                          $image = wp_get_attachment_url( $thumbnail_id );
                          if ( $image ) {
                            ?>
                            <span class="et_portfolio_image">
                              <img src="<?php echo $image; ?>" alt="<?php echo $category_name; ?>" />
                            <?php echo $overlay; ?>
                            <span class="appeartop_text">
                              <?php

                                                        echo '<h3>'. $category_name .'</h3>';
                                                        if ($hide_description == 'on') {
                                                        }
                                                        else {
                                                        echo  $category_description;
                                                        }
                              ?>
                            </span>
                            </span>

                          </div>
                        </a>
                            <?php
                          }

                          }



  if ($fullwidth == 'off') { //grid
                          echo '</li>';
}
                        /////////////////


                                                          }


                          if ($back_to_shop_position == "end") {
                          echo $back_shop;
                          }
                          echo '</ul>';
                          echo '</div>';



                          wp_reset_query();
                          } else {
                          if ( et_is_builder_plugin_active() ) {
                          include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
                          } else {
                          get_template_part( 'includes/no-results', 'index' );
                          }
                          }

                          ////////////// CATEGORY

                                }


                              //////
                                  $data = ob_get_clean();

                                   //////////////////////////////////////////////////////////////////////

                                return $data;
                  }
              }

            new db_shop_cat_loop_code;

?>
