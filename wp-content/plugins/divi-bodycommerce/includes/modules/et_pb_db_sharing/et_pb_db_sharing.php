<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_sharing_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PP Sharing - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_sharing';

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
                      'icons'   => array(
                                      'label'    => esc_html__( 'Icon / Button Text', 'et_builder' ),
                                      'css'      => array(
                                              'main' => "{$this->main_css_element} .bodycommerce-social.icons .bodycommerce-link:after, {$this->main_css_element} .bodycommerce-link",
                                      ),
                                      'font_size' => array('default' => '14px'),
                                      'line_height'    => array('default' => '1.5em'),
                      ),
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
              'border' => array(
                'css' => array(
                  'main' => "{$this->main_css_element} .bodycommerce-link",
                  'important' => 'all'
                ),
              ),
              'custom_margin_padding' => array(
                'css' => array(
                    'main' => "{$this->main_css_element} .bodycommerce-link",
                  'important' => 'all',
                ),
              ),
        		);

                  }

    function get_fields() {
    		$fields = array(
          'twitter' => array(
            'label'             => esc_html__( 'Twitter Background Color', 'divi-bodyshop-woocommerce' ),
            'type'              => 'color-alpha',
            'custom_color'      => true,
            'default'           => '#00aced',
          ),
            'twitter_hover' => array(
              'label'             => esc_html__( 'Twitter Background Color Hover', 'divi-bodyshop-woocommerce' ),
              'type'              => 'color-alpha',
              'custom_color'      => true,
              'default'           => '#0084b4',
            ),
              'facebook' => array(
                'label'             => esc_html__( 'Facebook Background Color', 'divi-bodyshop-woocommerce' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'default'           => '#3B5997',
              ),
                'facebook_hover' => array(
                  'label'             => esc_html__( 'Facebook Background Color Hover', 'divi-bodyshop-woocommerce' ),
                  'type'              => 'color-alpha',
                  'custom_color'      => true,
                  'default'           => '#2d4372',
                ),
                  'linkedin' => array(
                    'label'             => esc_html__( 'Linkedin Background Color', 'divi-bodyshop-woocommerce' ),
                    'type'              => 'color-alpha',
                    'custom_color'      => true,
                    'default'           => '#0074A1',
                  ),
                    'linkedin_hover' => array(
                      'label'             => esc_html__( 'Linkedin Background Color Hover', 'divi-bodyshop-woocommerce' ),
                      'type'              => 'color-alpha',
                      'custom_color'      => true,
                      'default'           => '#006288',
                    ),
                      'pinterest' => array(
                        'label'             => esc_html__( 'Pinterest Background Color', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'color-alpha',
                        'custom_color'      => true,
                        'default'           => '#bd081c',
                      ),
                        'pinterest_hover' => array(
                          'label'             => esc_html__( 'Pinterest Background Color Hover', 'divi-bodyshop-woocommerce' ),
                          'type'              => 'color-alpha',
                          'custom_color'      => true,
                          'default'           => '#9e0818',
                        ),
                          'whatsapp' => array(
                            'label'             => esc_html__( 'Whatsapp Background Color', 'divi-bodyshop-woocommerce' ),
                            'type'              => 'color-alpha',
                            'custom_color'      => true,
                            'default'           => '#43d854',
                          ),
                            'whatsapp_hover' => array(
                              'label'             => esc_html__( 'Whatsapp Background Color Hover', 'divi-bodyshop-woocommerce' ),
                              'type'              => 'color-alpha',
                              'custom_color'      => true,
                              'default'           => '#009688',
                            ),
                              'email' => array(
                                'label'             => esc_html__( 'Email Background Color', 'divi-bodyshop-woocommerce' ),
                                'type'              => 'color-alpha',
                                'custom_color'      => true,
                                'default'           => '#738a8d',
                              ),
                                'email_hover' => array(
                                  'label'             => esc_html__( 'Email Background Color Hover', 'divi-bodyshop-woocommerce' ),
                                  'type'              => 'color-alpha',
                                  'custom_color'      => true,
                                  'default'           => '#617375',
                                ),
                                  'print' => array(
                                    'label'             => esc_html__( 'Print Background Color', 'divi-bodyshop-woocommerce' ),
                                    'type'              => 'color-alpha',
                                    'custom_color'      => true,
                                    'default'           => '#20292f',
                                  ),
                                    'print_hover' => array(
                                      'label'             => esc_html__( 'Print Background Color Hover', 'divi-bodyshop-woocommerce' ),
                                      'type'              => 'color-alpha',
                                      'custom_color'      => true,
                                      'default'           => '#000000',
                                    ),
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__getprosharing' => array(
          'type' => 'computed',
          'computed_callback' => array( 'db_sharing_code', 'get_pro_sharing' ),
          'computed_depends_on' => array(
          'admin_label'
          ),
          ),
    		);

    		return $fields;
    	}

      public static function get_pro_sharing ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
                    woocommerce_template_single_sharing();
//*---------------------------------------------------------------------------------------------------*//
        $first = false;
    } else {

    }
  endwhile; wp_reset_query(); // Remember to reset

        $data = ob_get_clean();

      return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {

                    $data = '';
                            $twitter = $this->props['twitter'];
                            $twitter_hover = $this->props['twitter_hover'];
                            $facebook = $this->props['facebook'];
                            $facebook_hover = $this->props['facebook_hover'];
                            $linkedin = $this->props['linkedin'];
                            $linkedin_hover = $this->props['linkedin_hover'];
                            $pinterest = $this->props['pinterest'];
                            $pinterest_hover = $this->props['pinterest_hover'];
                            $whatsapp = $this->props['whatsapp'];
                            $whatsapp_hover = $this->props['whatsapp_hover'];
                            $print = $this->props['print'];
                            $print_hover = $this->props['print_hover'];
                            $email = $this->props['email'];
                            $email_hover = $this->props['email_hover'];
                  //////////////////////////////////////////////////////////////////////

                    ob_start();
                    if( is_admin() ){
                      return;
                    }


                    woocommerce_template_single_sharing();

                    ?>
                    <style>
                    .bodycommerce-twitter {
                    background: <?php echo $twitter ?>;
                    }

                    .bodycommerce-twitter:hover,.bodycommerce-twitter:active {
                    background: <?php echo $twitter_hover ?>;
                    }

                    .bodycommerce-facebook {
                    background: <?php echo $facebook ?>;
                    }

                    .bodycommerce-facebook:hover,.bodycommerce-facebook:active {
                    background: <?php echo $facebook_hover ?>;
                    }

                    .bodycommerce-pinterest {
                    background: <?php echo $pinterest ?>;
                    }

                    .bodycommerce-pinterest:hover,.bodycommerce-pinterest:active {
                    background: <?php echo $pinterest_hover ?>;
                    }

                    .bodycommerce-email {
                    background: <?php echo $email ?>;
                    }

                    .bodycommerce-email:hover,.bodycommerce-email:active {
                    background: <?php echo $email_hover ?>;
                    }

                    .bodycommerce-print {
                    background: <?php echo $print ?>;
                    }

                    .bodycommerce-print:hover,.bodycommerce-print:active {
                    background: <?php echo $print_hover ?>;
                    }

                    .bodycommerce-linkedin {
                    background: <?php echo $linkedin ?>;
                    }

                    .bodycommerce-linkedin:hover,.bodycommerce-linkedin:active {
                    background: <?php echo $linkedin_hover ?>;
                    }

                    .bodycommerce-whatsapp {
                    background: <?php echo $whatsapp ?>;
                    }

                    .bodycommerce-whatsapp:hover,.bodycommerce-whatsapp:active {
                    background: <?php echo $whatsapp_hover ?>;
                    }
                    </style>
                    <?php

                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_sharing_code;

?>
