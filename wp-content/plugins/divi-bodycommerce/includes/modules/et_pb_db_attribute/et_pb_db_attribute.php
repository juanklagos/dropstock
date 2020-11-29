<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_attribute_module extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PL Attributes - Product Page / Loop Layout', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_attribute';

                    $this->settings_modal_toggles = array(

      			'general' => array(
      				'toggles' => array(
      					'main_settings' => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
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
              'headings' => array(
                  'label' => esc_html__('Title', 'divi-bodyshop-woocommerce'),
                  'css' => array(
                      'main' => "{$this->main_css_element} h3",
                  ),
                  'font_size' => array('default' => '30px'),
                  'line_height' => array('default' => '1.5em'),
              ),
        				'attr_text'   => array(
        					'label'    => esc_html__( 'Attribute Text', 'divi-bodyshop-woocommerce' ),
        					'css'      => array(
        						'main' => "{$this->main_css_element} .term-item",
        					),
        					'font_size' => array(
        						'default' => '14px',
        					),
        					'line_height' => array(
        						'default' => '1.5em',
        					),
        				),
          				'attr_prefix'   => array(
          					'label'    => esc_html__( 'Attribute Prefix', 'divi-bodyshop-woocommerce' ),
          					'css'      => array(
          						'main' => "{$this->main_css_element} .db_attribute_term_list .term-prefix",
          					),
          					'font_size' => array(
          						'default' => '14px',
          					),
          					'line_height' => array(
          						'default' => '1.5em',
          					),
          				),
            				'attr_whole'   => array(
            					'label'    => esc_html__( 'Whole Attribute', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} .et_pb_module_inner",
            					),
            					'font_size' => array(
            						'default' => '14px',
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

                    $attr = array();

                    if ($taxonomies = get_taxonomies(false, 'objects')) {
                        foreach ($taxonomies as $taxonomy) {
                            if (substr($taxonomy->name, 0, 3) == 'pa_') {
                                $attr[$taxonomy->name] = $taxonomy->label;
                            }
                        }
                    }


                      $fields = array(
                        'title' => array(
                            'label' => __('Title', 'divi-bodyshop-woocommerce'),
                            'type' => 'text',
                            'option_category' => 'layout',
                            'toggle_slug' => 'main_settings',
                            'description' => __('If you want to include a title then use this setting and a heading will be added above the list of attributes', 'divi-bodyshop-woocommerce'),
                        ),
                        'prefix' => array(
                            'label' => __('Prefix', 'divi-bodyshop-woocommerce'),
                            'type' => 'text',
                            'option_category' => 'layout',
                            'toggle_slug' => 'main_settings',
                            'description' => __('Text to be added immediately before the list of attributes. Can be used for lead in text or a slightly more subtle title.', 'divi-bodyshop-woocommerce'),
                        ),
                        'attribute' => array(
                            'label' => esc_html__('Attribute', 'divi-bodyshop-woocommerce'),
                            'type' => 'select',
                    				'computed_affects' => array(
                    					'__getattribute',
                    				),
                            'options' => $attr,
                            'option_category' => 'layout',
                            'toggle_slug' => 'main_settings',
                            'description' => 'Which attribute should be shown? This will display a list of attributes if the product has them. If not the module will be hidden'
                        ),
                        'separator' => array(
                            'label' => esc_html__('Separator', 'divi-bodyshop-woocommerce'),
                            'type' => 'text',
                    				'computed_affects' => array(
                    					'__getattribute',
                    				),
                            'option_category' => 'layout',
                            'toggle_slug' => 'main_settings',
                            'description' => 'When there is more than one term to display what should separate them. Eg | or ,',
                        ),
                        'link_attr' => array(
                        'toggle_slug' => 'main_settings',
                                'label'             => esc_html__( 'Link to attribute archive page', 'divi-bodyshop-woocommerce' ),
                                'type'              => 'yes_no_button',
                                'default'           => 'off',
                                'options'           => array(
                                  'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                                  'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                                ),
                                'description'        => esc_html__( 'If you want to link the attribute to the archive page, enable this', 'divi-bodyshop-woocommerce' ),
                              ),
                        '__getattribute' => array(
                        'type' => 'computed',
                        'computed_callback' => array( 'db_attribute_module', 'get_attribute' ),
                        'computed_depends_on' => array(
                        'attribute'
                        ),
                        ),
                      );

                      return $fields;
                  }


                  public static function get_attribute ( $args = array(), $conditional_tags = array(), $current_page = array() ){
                    if (!is_admin()) {
                			return;
                		}
                    ob_start();
                                        $separator = $args['separator'];

                    if ($taxonomies = get_taxonomies(false, 'objects')) {
                                        $first_att = true;
                        foreach ($taxonomies as $taxonomy) {

                          if ( $first_att )  {

                            if (substr($taxonomy->name, 0, 3) == 'pa_') {
                                $first_attribute = $taxonomy->name;
                              $first_att = false;
                            }

                          }
                          else {
                            $first_attribute = "";
                          }

                        }
                    }

                    $attribute = $first_attribute;



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
                                    $product_terms = wp_get_object_terms(get_the_ID(), $attribute);
                                    $term_array = array();

                                    if (!empty($product_terms)) {
                                        if (!is_wp_error($product_terms)) {
                                            foreach ($product_terms as $term) {
                                                $term_array[] = '<span class="term-item">' . $term->name . '</span>';
                                            }

                                        }
                                    } else {
                                        if ($attr2 = get_post_meta(get_the_ID(), '_product_attributes', true)) {
                                            $no_pa = substr($attribute, 3);

                                            if (isset($attr2[$no_pa]['value'])) {
                                                if ($attr3 = $attr2[$no_pa]['value']) {
                                                    $term_array[] = '<span class="term-item">' . $attr3 . '</span>';
                                                }
                                            }
                                        }
                                    }

                                    //////////////////////////////////////////////////////
                                    $content = "";

                                    if (count($term_array) > 0) {

                                        $content .= '<span class="db_attribute_term_list">';

                                        $content .= implode($separator, $term_array);
                                        $content .= '</span>';

                                      return $content;

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

                    $title = $this->props['title'];
                    $prefix = $this->props['prefix'];
                    $attribute = $this->props['attribute'];
                    $separator = $this->props['separator'];
                    $link_attr = $this->props['link_attr'];


                  //////////////////////////////////////////////////////////////////////

                                  if( is_admin() ){
                                    return;
                                  }


                                  $product_terms = wp_get_object_terms(get_the_ID(), $attribute);
                                  $term_array = array();

                                  if (!empty($product_terms)) {
                                      if (!is_wp_error($product_terms)) {
                                          foreach ($product_terms as $term) {
                                              $archive_link = get_term_link( $term->slug, $attribute );
                                              if($link_attr == "on") {
                                              $term_array[] = '<span class="term-item"><a href="' . $archive_link. '">' . $term->name . '</a></span>';
                                              } else {
                                              $term_array[] = '<span class="term-item">' . $term->name . '</span>';
                                              }

                                          }

                                      }
                                  } else {
                                      if ($attr2 = get_post_meta(get_the_ID(), '_product_attributes', true)) {
                                          $no_pa = substr($attribute, 3);

                                          if (isset($attr2[$no_pa]['value'])) {
                                              if ($attr3 = $attr2[$no_pa]['value']) {
                                                  $term_array[] = '<span class="term-item">' . $attr3 . '</span>';
                                              }
                                          }
                                      }
                                  }

                                  //////////////////////////////////////////////////////

                                  if (count($term_array) > 0) {
                                      if ($title) {
                                          $content .= '<h3>' . $title . '</h3>';
                                      }

                                      $content .= '<span class="db_attribute_term_list">';

                                      if ($prefix) {
                                          $content .= '<span class="term-prefix">' . $prefix . '</span> ';
                                      }

                                      $content .= implode($separator, $term_array);
                                      $content .= '</span>';
                                  }

                                  return $content;

                  }
              }

            new db_attribute_module;

?>
