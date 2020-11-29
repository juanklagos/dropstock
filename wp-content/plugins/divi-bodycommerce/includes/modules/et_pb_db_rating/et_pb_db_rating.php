<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_rating_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PL Rating - Product Page / Loop Layout', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_rating';

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
      				'reviews_count'   => array(
      					'label'    => esc_html__( 'Rating', 'divi-bodyshop-woocommerce' ),
      					'css'      => array(
      						'main' => "{$this->main_css_element} .woocommerce-product-rating, {$this->main_css_element} .woocommerce-product-rating a.woocommerce-review-link, {$this->main_css_element} .star-rating",
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
                        'star_primary' => array(
                          'label'             => esc_html__( 'Primary Star Color', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'color-alpha',
                          'custom_color'      => true,
                          'toggle_slug' => 'main_content',
                          'description'       => esc_html__( 'This will chanege the color of the primary stars (the ones that indicate the number rating)', 'divi-bodyshop-woocommerce' ),
                        ),
                        'star_secondary' => array(
                          'label'             => esc_html__( 'Secondary Star Color', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'color-alpha',
                          'custom_color'      => true,
                          'toggle_slug' => 'main_content',
                          'description'       => esc_html__( 'This will chanege the color of the secondary stars (the ones that indicate the missing number rating)', 'divi-bodyshop-woocommerce' ),
                        ),
                        'rating_placeholder' => array(
                  				'label' => esc_html__( 'Placeholder', 'divi-bodyshop-woocommerce' ),
                  				'type' => 'yes_no_button',
                  				'description' => esc_html__( 'Activating this will add gray stars as a placeholder if the product has no rating', 'divi-bodyshop-woocommerce' ),
                  				'options' => array(
                  					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                  					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                  				),
                  				'affects' => array(
                  					'placeholder_stars_color',
                  				),
                  				'toggle_slug' => 'main_content',
                  			),
                  			'placeholder_stars_color' => array(
                  				'label'             => esc_html__( 'Placeholder Stars Color', 'divi-bodyshop-woocommerce' ),
                  				'type'     => 'color-alpha',
                  				'default' => '#d3ced2',
                  				'toggle_slug' => 'main_content',
                  				'depends_show_if' => 'on',
                  			),
                        'center_ratings' => array(
                  				'label' => esc_html__( 'Center Rating Stars?', 'divi-bodyshop-woocommerce' ),
                  				'type' => 'yes_no_button',
                  				'description' => esc_html__( 'If you want to center the rating stars, enable this', 'divi-bodyshop-woocommerce' ),
                  				'options' => array(
                  					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                  					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                  				),
                  				'toggle_slug' => 'main_content',
                  			),
                        'admin_label' => array(
                            'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                            'type'        => 'text',
                            'toggle_slug'     => 'main_content',
                            'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                        ),
                        '__getprorating' => array(
                        'type' => 'computed',
                        'computed_callback' => array( 'db_rating_code', 'get_pro_rating' ),
                        'computed_depends_on' => array(
                        'admin_label'
                        ),
                        ),
                      );

                      return $fields;
                  }


                  public static function get_pro_rating ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
                    woocommerce_template_single_rating();
//*---------------------------------------------------------------------------------------------------*//
                    $first = false;
                } else {

                }
              endwhile; wp_reset_query(); // Remember to reset

                    $data = ob_get_clean();

                  return $data;

                  }

                  function render( $attrs, $content = null, $render_slug ) {

                    $rating_placeholder       = $this->props['rating_placeholder'];
		                $placeholder_stars_color  = $this->props['placeholder_stars_color'];
                    $star_primary             = $this->props['star_primary'];
                    $star_secondary           = $this->props['star_secondary'];
                    $center_ratings           = $this->props['center_ratings'];

                  //////////////////////////////////////////////////////////////////////

                  if ( $center_ratings == 'on' ) {
                    $this->add_classname('center-ratings');
                  }

                    if( is_admin() ){
                      return;
                    }

                                  ob_start();

                                  $data = '';


                                  if ( is_product() ) {
                                    woocommerce_template_single_rating();
                                  } else {
                                    woocommerce_template_loop_rating();
                                  }


                                  $data = ob_get_clean();
                                    if( !empty( $star_secondary ) ){

                              				ET_Builder_Element::set_style( $render_slug, array(
                              					'selector'    => 'body.woocommerce %%order_class%% .star-rating:before, body.woocommerce-page %%order_class%% .star-rating:before',
                              					'declaration' => "color: ". esc_attr( $star_secondary ) ."!important;",
                              				) );
                              			}

                                    if( !empty( $star_primary ) ){

                              				ET_Builder_Element::set_style( $render_slug, array(
                              					'selector'    => 'body.woocommerce %%order_class%% .star-rating span::before, body.woocommerce-page %%order_class%% .star-rating span::before',
                              					'declaration' => "color: ". esc_attr( $star_primary ) ."!important;",
                              				) );
                              			}

                                			// placeholder
                                			if( $data == '' && $rating_placeholder == 'on' ){
                                				$data = '<a href="#reviews"><div class="star-rating"></div></a>';

                                				if( !empty( $placeholder_stars_color ) ){

                                					ET_Builder_Element::set_style( $render_slug, array(
                                            'selector'    => 'body.woocommerce %%order_class%% .star-rating:before, body.woocommerce-page %%order_class%% .star-rating:before',
                                						'declaration' => "color: ". esc_attr( $placeholder_stars_color ) ."!important;",
                                					) );
                                				}
                                			}





                                   //////////////////////////////////////////////////////////////////////

                                return $data;
                  }
              }

            new db_rating_code;

?>
