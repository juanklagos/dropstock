<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_action_shortcode_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.G Action/Shortcode - Global', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_action_shortcode';


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


                      $this->button_css = "%%order_class%%";

                      $this->advanced_fields = array(
                        'fonts' => array(
                  				'notice_text'   => array(
                  					'label'    => esc_html__( 'Notice', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                              'main' => "{$this->main_css_element}",
                              'important' => 'all'
                  					),
                  					'font_size' => array(
                  						'default' => '18px',
                  					),
                  					'line_height' => array(
                  						'default' => '1.1em',
                  					),
                  				),
                  			),
                  			'box_shadow'            => array(
                  				'default' => array(
                  					'css' => array(
                              'main' => "{$this->main_css_element}",
                              'important' => 'all'
                  					),
                  				),
                  			),
                  			'background' => array(
                  				'css' => array(
                            'main' => "{$this->main_css_element}",
                            'important' => 'all'
                  				),
                  				'settings' => array(
                  					'color' => 'alpha',
                  				),
                  			),
                  			'border' => array(
                  				'css' => array(
                            'main' => "{$this->main_css_element}",
                            'important' => 'all'
                  				),
                  			),
			'custom_margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
                  			'button' => array(
                  				'button' => array(
                  					'label' => esc_html__( 'Notice Button', 'divi-bodyshop-woocommerce' ),
                  					'css' => array(
                  						'main' => "{$this->button_css} button, {$this->button_css} .button",
                  						'important' => 'all',
                  					),
                  					'box_shadow'  => array(
                  						'css' => array(
                  							'main' => 'body #page-container %%order_class%% .button',
                  						),
                  					),
                  				),
                  			),
                  		);

                                        }


                                        function get_fields() {
                          		$fields = array(
                    			'action_name' => array(
                    				'label'           => esc_html__( 'Action Name', 'divi-bodyshop-woocommerce' ),
                    				'type'            => 'text',
                    				'computed_affects' => array(
                    					'__getactionshortcode',
                    				),
                    				'option_category' => 'basic_option',
                    				'description'     => esc_html__( 'If you want to add a custom plugins action to your page, add the text here without the and it will render. For example if the action is do_action("action_name");, just add "action_name"', 'divi-bodyshop-woocommerce' ),
                    			),
                      'shortcode_name' => array(
                        'label'           => esc_html__( 'Shortcode Name (without [])', 'divi-bodyshop-woocommerce' ),
                        'type'            => 'text',
                				'computed_affects' => array(
                					'__getactionshortcode',
                				),
                        'option_category' => 'basic_option',
                        'description'     => esc_html__( 'If you want to add a custom plugins shortcode to your page, add the text here without the [] and it will render. For example if the shortcode is [shortcode_name], just add "shortcode_name"', 'divi-bodyshop-woocommerce' ),
                      ),
                      'admin_label' => array(
                          'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                          'type'        => 'text',
                          'toggle_slug'     => 'main_content',
                          'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                      ),
                      '__getactionshortcode' => array(
                        'type' => 'computed',
                        'computed_callback' => array( 'db_action_shortcode_code', 'get_action_shortcode' ),
                        'computed_depends_on' => array(
                          'admin_label',
                          'action_name',
                          'shortcode_name'
                        ),
                      ),

                          );

                          return $fields;
                      }

                      public static function get_action_shortcode ( $args = array(), $conditional_tags = array(), $current_page = array() ){

                        if (!is_admin()) {
                    			return;
                    		}

                                ob_start();


                                $action_name  			= $args['action_name'];
                                $shortcode_name  			= $args['shortcode_name'];

                                if ($action_name != "") {
                                                      do_action(''.$action_name.'');
                                } else {}

                                if ($shortcode_name != "") {
                                                      echo do_shortcode('['.$shortcode_name.']');
                                } else {}


                        $data = ob_get_clean();

                      return $data;

                      }



                  function render( $attrs, $content = null, $render_slug ) {


                                      $action_name  			= $this->props['action_name'];
                                      $shortcode_name  			= $this->props['shortcode_name'];

                                      $custom_button  			= $this->props['custom_button'];
                                      $button_use_icon  			= $this->props['button_use_icon'];
                                      $button_icon 				= $this->props['button_icon'];
                                      $button_icon_placement 		= $this->props['button_icon_placement'];



                    if (is_admin()) {
                        return;
                    }


                      ob_start();

if ($action_name != "") {
                      do_action(''.$action_name.'');
} else {}

if ($shortcode_name != "") {
                      echo do_shortcode('['.$shortcode_name.']');
} else {}



                  $content = ob_get_clean();

                  //////////////////////////////////////////////////////////////////////



                  return $content;



              	}
              }

            new db_action_shortcode_code;

?>
