<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_reviews_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PP Reviews - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_reviews';

		$this->fields_defaults = array(
			'show_heading' => array( 'on' ),
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
      				'header' => array(
      					'label'    => esc_html__( 'Heading', 'divi-bodyshop-woocommerce' ),
      					'css'      => array(
      						'main' => "{$this->main_css_element} .woocommerce-Reviews-title",
      					),
      					'font_size' => array(
      						'default' => '26px',
      					),
      					'line_height' => array(
      						'default' => '1em',
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
      					'label' => esc_html__( 'Submit Button', 'divi-bodyshop-woocommerce' ),
      					'css' => array(
      						'main' => "%%order_class%% #review_form #respond .form-submit [name='submit']",
          					'important' => 'all',
      					),
      					'box_shadow'  => array(
      						'css' => array(
      							'main' => "%%order_class%% #review_form #respond .form-submit [name='submit']",
            					'important' => 'all',
      						),
      					),
                'margin_padding' => array(
                'css'           => array(
                  'main' => "{$this->main_css_element} #review_form #respond .form-submit [name='submit']",
                  'important' => 'all',
                ),
                ),
      				),
      			),
      		);

		$this->custom_css_fields = array(
			'header' => array(
				'label' => esc_html__( 'Heading', 'divi-bodyshop-woocommerce' ),
				'selector' => "{$this->main_css_element} .woocommerce-Reviews-title",
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
			'show_heading' => array(
				'label' => esc_html__( 'Show Heading', 'divi-bodyshop-woocommerce' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array(
					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
				),
				'toggle_slug' => 'main_content',
			),
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
                        'admin_label' => array(
                            'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                            'type'        => 'text',
                            'toggle_slug'     => 'main_content',
                            'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                        ),
                        '__getproreviews' => array(
                        'type' => 'computed',
                        'computed_callback' => array( 'db_reviews_code', 'get_pro_reviews' ),
                        'computed_depends_on' => array(
                        'admin_label'
                        ),
                        ),
                      );

                      return $fields;
                  }

                  public static function get_pro_reviews ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
	                    comments_template();
//*---------------------------------------------------------------------------------------------------*//
                    $first = false;
                } else {

                }
              endwhile; wp_reset_query(); // Remember to reset

                    $data = ob_get_clean();

                  return $data;

                  }

                  function render( $attrs, $content = null, $render_slug ) {

                    $show_heading     				= $this->props['show_heading'];
                    $star_primary             = $this->props['star_primary'];
                    $star_secondary           = $this->props['star_secondary'];
                    $button_use_icon          	= $this->props['button_use_icon'];
                    $custom_icon          		= $this->props['button_icon'];
                    $button_custom        		= $this->props['custom_button'];
                    $button_bg_color       		= $this->props['button_bg_color'];

                    $data = '';

                  //////////////////////////////////////////////////////////////////////

                                  ob_start();
                                  if( is_admin() ){
                                    return;
                                  }


                                  comments_template();




                                    if( !empty( $star_secondary ) ){

                              				ET_Builder_Element::set_style( $render_slug, array(
                              					'selector'    => 'body.woocommerce %%order_class%% .star-rating:before, body.woocommerce-page %%order_class%% .star-rating:before',
                              					'declaration' => "color: ". esc_attr( $star_secondary ) ."!important;",
                              				) );
                              			}


                                    if( !empty( $star_primary ) ){

                              				ET_Builder_Element::set_style( $render_slug, array(
                              					'selector'    => 'body.woocommerce %%order_class%% .comment-form-rating .stars a , body.woocommerce %%order_class%% .star-rating span::before, body.woocommerce-page %%order_class%% .star-rating span::before',
                              					'declaration' => "color: ". esc_attr( $star_primary ) ."!important;",
                              				) );
                              			}

                                    if( $show_heading == 'off' ){

                            				ET_Builder_Element::set_style( $render_slug, array(
                            					'selector'    => '%%order_class%% .woocommerce-Reviews-title',
                            					'declaration' => "display: none !important;",
                            				) );
                            			}


                                  if( $button_use_icon == 'on' && $custom_icon != '' && $button_custom == 'on' ){
                                  $custom_icon = 'data-icon="'. esc_attr( et_pb_process_font_icon( $custom_icon ) ) .'"';

                                  ET_Builder_Element::set_style( $render_slug, array(
                                    'selector'    => "%%order_class%% #review_form #respond .form-submit [name='submit']:after",
                                    'declaration' => "content: attr(data-icon);",
                                  ) );
                                }else{
                                  ET_Builder_Element::set_style( $render_slug, array(
                                    'selector'    => "%%order_class%% #review_form #respond .form-submit [name='submit']:hover",
                                    'declaration' => "padding: .3em 1em;",
                                  ) );
                                }

          $data = ob_get_clean();


                                   //////////////////////////////////////////////////////////////////////

                                   $data = str_replace(
                                     'class="submit"',
                                     'class="submit"' . $custom_icon
                                     , $data
                                   );

                                return $data;
                  }
              }

            new db_reviews_code;

?>
