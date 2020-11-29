<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_product_before_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PP Pro Before - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_pro_before';

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
                                        'main' => "{$this->main_css_element} p",
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
                        'admin_label' => array(
                            'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                            'type'        => 'text',
                            'toggle_slug'     => 'main_content',
                            'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                        ),
                        '__getprobefore' => array(
                        'type' => 'computed',
                        'computed_callback' => array( 'db_product_before_code', 'get_pro_before' ),
                        'computed_depends_on' => array(
                        'admin_label'
                        ),
                        ),
                      );

                      return $fields;
                  }

                  public static function get_pro_before ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
                      do_action( 'woocommerce_before_single_product' );
//*---------------------------------------------------------------------------------------------------*//
                    $first = false;
                } else {

                }
              endwhile; wp_reset_query(); // Remember to reset

                    $data = ob_get_clean();

                  return $data;

                  }

                  function render( $attrs, $content = null, $render_slug ) {

                  //////////////////////////////////////////////////////////////////////


                                  if( is_admin() ){
                                    return;
                                  }
                                  ob_start();
                                  do_action( 'woocommerce_before_single_product' );
                                  $data = ob_get_clean();

                                   //////////////////////////////////////////////////////////////////////

                                return $data;
                  }
              }

            new db_product_before_code;

?>
