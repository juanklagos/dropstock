<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_shop_cat_title_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.ARP Category Title/Header - Archive Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_shop_cat_title';

		$this->fields_defaults = array(
      'text_position' 		=> array( 'top' ),
      'hide_description' 		=> array( 'show' ),
      'hide_image' 		=> array( 'show' ),
      'image_style' 		=> array( 'background' ),
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
        					'label'    => esc_html__( 'Category Title', 'divi-bodyshop-woocommerce' ),
        					'css'      => array(
        						'main' => "{$this->main_css_element} h1, {$this->main_css_element} h2, {$this->main_css_element} h3, {$this->main_css_element} h4",
        					),
        					'font_size' => array(
        						'default' => '30px',
        					),
        					'line_height' => array(
        						'default' => '1.5em',
        					),
        				),
          				'description'   => array(
          					'label'    => esc_html__( 'Category Description', 'divi-bodyshop-woocommerce' ),
          					'css'      => array(
          						'main' => "{$this->main_css_element} .et_pb_module_inner, {$this->main_css_element} .et_pb_module_inner p",
          					),
          					'font_size' => array(
          						'default' => '30px',
          					),
          					'line_height' => array(
          						'default' => '1.5em',
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
          'text_position' => array(
          'label'             => esc_html__( 'Text Position (normal image only)', 'divi-bodyshop-woocommerce' ),
          'type'              => 'select',
          'options'           => array(
          "top"  => esc_html__( 'Top', 'divi-bodyshop-woocommerce' ),
          "right" => esc_html__( 'Right', 'divi-bodyshop-woocommerce' ),
          "bottom" => esc_html__( 'Bottom', 'divi-bodyshop-woocommerce' ),
          ),
          'description'        => esc_html__( 'Where do you want the text to show relative to the image.', 'divi-bodyshop-woocommerce' ),
          ),
          'hide_title' => array(
          'label'             => esc_html__( 'Remove Title', 'divi-bodyshop-woocommerce' ),
          'type'              => 'select',
          'options'           => array(
          "hide"  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
          "show" => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
          ),
          'default' => 'show',
          ),
            'title_tag' => array(
              'label'       => __( 'Title HTML Tag', 'et_builder' ),
              'type'        => 'select',
              'options'     => array(
                  "h1"=>"h1",
                  "h2"=>"h2",
                  "h3"=>"h3",
                  "h4"=>"h4",
                  "h5"=>"h5",
                  "h6"=>"h6",
                   "p"=>"p"
              ),
              'default' => 'h1',
              'description' => __( 'the number of related items to show. Defaults to 3', 'et_builder' ),
            ),
          'hide_description' => array(
          'label'             => esc_html__( 'Remove Descriptions', 'divi-bodyshop-woocommerce' ),
          'type'              => 'select',
          'options'           => array(
          "hide"  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
          "show" => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
          ),
          'description'        => esc_html__( 'If you want to hide the descriptions, check this.', 'divi-bodyshop-woocommerce' ),
          ),
          'hide_image' => array(
          'label'             => esc_html__( 'Remove Image', 'divi-bodyshop-woocommerce' ),
          'type'              => 'select',
          'options'           => array(
          "hide"  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
          "show" => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
          ),
          'description'        => esc_html__( 'If you want to hide the image, check this.', 'divi-bodyshop-woocommerce' ),
          ),
          'image_style' => array(
          'label'             => esc_html__( 'Image Style', 'divi-bodyshop-woocommerce' ),
          'type'              => 'select',
          'options'           => array(
          "normal"  => esc_html__( 'Normal', 'divi-bodyshop-woocommerce' ),
          "background" => esc_html__( 'Background', 'divi-bodyshop-woocommerce' ),
          ),
          'description'        => esc_html__( 'If you have the image not hidden, choose how you want it displayed.', 'divi-bodyshop-woocommerce' ),
          ),
                      'background_layout' => array(
                                      'label'             => esc_html__( 'Text Color', 'divi-bodyshop-woocommerce' ),
                                      'type'              => 'select',
                                      'option_category'   => 'configuration',
                                      'options'           => array(
                                        'light' => esc_html__( 'Dark', 'divi-bodyshop-woocommerce' ),
                                        'dark'  => esc_html__( 'Light', 'divi-bodyshop-woocommerce' ),
                                      ),
                                      'description'       => esc_html__( 'Here you can choose the value of your text. If you are working with a dark background, then your text should be set to light. If you are working with a light background, then your text should be dark.', 'divi-bodyshop-woocommerce' ),
                      ),
                      'text_orientation' => array(
                                      'label'             => esc_html__( 'Text Orientation', 'divi-bodyshop-woocommerce' ),
                                      'type'              => 'select',
                                      'option_category'   => 'layout',
                                      'options'           => et_builder_get_text_orientation_options(),
                                      'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'divi-bodyshop-woocommerce' ),
                      ),
                      'max_width' => array(
                                      'label'           => esc_html__( 'Max Width', 'et_builder' ),
                                      'type'            => 'text',
                                      'option_category' => 'layout',
                                      'mobile_options'  => true,
                                      'tab_slug'        => 'advanced',
                                      'validate_unit'   => true,
                      ),
                      'max_width_tablet' => array(
                                      'type'      => 'skip',
                                      'tab_slug'  => 'advanced',
                      ),
                      'max_width_phone' => array(
                                      'type'      => 'skip',
                                      'tab_slug'  => 'advanced',
                      ),
    		);

    		return $fields;
    	}

                  function render( $attrs, $content = null, $render_slug ) {


                    $text_orientation     = $this->props['text_orientation'];
                    $text_position    = $this->props['text_position'];
                    $hide_description   = $this->props['hide_description'];
                    $hide_image    = $this->props['hide_image'];
                    $image_style    = $this->props['image_style'];
                    $max_width            = $this->props['max_width'];
                    $max_width_tablet     = $this->props['max_width_tablet'];
                    $max_width_phone      = $this->props['max_width_phone'];

                    $hide_title      = $this->props['hide_title'];
                    $title_tag      = $this->props['title_tag'];



                    if ( '' !== $max_width_tablet || '' !== $max_width_phone || '' !== $max_width ) {
                                    $max_width_values = array(
                                      'desktop' => $max_width,
                                      'tablet'  => $max_width_tablet,
                                      'phone'   => $max_width_phone,
                                    );

                                    et_pb_generate_responsive_css( $max_width_values, '%%order_class%%', 'max-width', $render_slug );
                    }

                    if ( is_rtl() && 'left' === $text_orientation ) {
                                    $text_orientation = 'right';
                    }

                    //////////////////////////////////////////////////////////////////////

                    ob_start();
global $shortname, $themename;
                    if (is_admin()) {
                        return;
                    }
                    // SHOP PAGE
                    if ( is_search() ) {
                      $page_title = sprintf( esc_html__( 'Search results for "%s"', $themename ), esc_attr( get_search_query() ) );
                      ?>
                      <h1><?php echo $page_title; ?> </h1>
                      <?php
                    }
                    // Search PAGE
                    else if (is_shop()) {
                      $shop_id = get_option( 'woocommerce_shop_page_id' );
                      $shop = get_page($shop_id);


                      $title = $shop->post_title;

                      echo $title;
                    }
                    // CAT PAGE
                    else {


                      global $wp_query;
                        $cat = $wp_query->get_queried_object();
                         $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                          $image = wp_get_attachment_url( $thumbnail_id );
                            $title = single_term_title('', false);

                    if ($hide_title == "hide") {
                    $display_cat_title = "";
                      }
                      else {
                      $display_cat_title = '<'.$title_tag.' itemprop="name" class="shop_title entry-title woocommerce-products-header__title page-title">' . $title . '</'.$title_tag.'>';;
                      }



                    if ($hide_image == "hide") {
                    $hide_image_display = "1";
                    }
                    else {
                    $hide_image_display  = "";
                    }

                            if($text_position == "top"){
                            echo $display_cat_title;
                            if ($hide_description == "hide") {
                              $display_cat_description = "";
                            }
                            else {
                              echo category_description($cat->term_id);
                            }

                              if ( $hide_image == "show" ) {
                                if ($image_style == "normal") {
                                 echo '<span class="et_portfolio_image"><img src="'. $image. '" alt="'.  $cat->name. '" /></span>';
                                 }
                                 else {
                                 }

                               }
                               else {
                               }
                            }
                            else if ($text_position == "right") {
                              if ( $hide_image == "show" ) {
                                if ($image_style == "normal") {
                                 echo '<span class="et_portfolio_image" style="float: left;padding-right: 20px;"><img src="'. $image. '" alt="'.  $cat->name. '" /></span>';
                               }
                               else {
                               }
                               }
                               else {
                               }
                               echo $display_cat_title;
                               if ($hide_description == "hide") {
                                 $display_cat_description = "";
                               }
                               else {
                                   echo category_description($cat->term_id);
                               }
                            }
                            else {

                                if ( $hide_image == "show" ) {
                               if ($image_style == "normal") {
                                echo '<span class="et_portfolio_image"><img src="'. $image. '" alt="'.  $cat->name. '" /></span>';
                                }
                                else {
                                }
                              }
                              else {
                              }
                               echo $display_cat_title;
                               if ($hide_description == "hide") {
                                 $display_cat_description = "";
                               }
                               else {
                                   echo category_description($cat->term_id);
                               }
                            }

if ( $hide_image == "show" ) {
                            if ( 'background' == $image_style ) {
                              ET_Builder_Element::set_style( $render_slug, array(
                                'selector'    => '%%order_class%%',
                                'declaration' => "background-image: url(". esc_attr( $image ) .");",
                              ) );
                            }
}
else {
  // code...
}

                    }



                    $data = ob_get_contents();


                    ob_end_clean();




                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_shop_cat_title_code;

?>
