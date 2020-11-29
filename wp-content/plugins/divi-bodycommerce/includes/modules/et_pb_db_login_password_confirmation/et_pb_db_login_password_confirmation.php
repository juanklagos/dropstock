<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_login_password_confirmation_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.LP Password Confirmation Message - Login Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_login_password_confirmation';

		$this->fields_defaults = array(
    'redirect'   => array( 'on' ),
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
                                                'label'    => esc_html__( 'Heading', 'divi-bodyshop-woocommerce' ),
                                                'css'      => array(
                                                        'main' => "{$this->main_css_element} h1.main_title",
                                                ),
                                                'font_size' => array('default' => '24px'),
                                                'line_height'    => array('default' => '1.5em'),
                                ),
                                  'input_label'   => array(
                                                    'label'    => esc_html__( 'Input Label', 'divi-bodyshop-woocommerce' ),
                                                    'css'      => array(
                                                            'main' => "{$this->main_css_element} .et_pb_contact label.input-text",
                                                    ),
                                                    'font_size' => array('default' => '24px'),
                                                    'line_height'    => array('default' => '2em'),
                                    ),
                                    'input'   => array(
                                                      'label'    => esc_html__( 'Input', 'divi-bodyshop-woocommerce' ),
                                                      'css'      => array(
                                                              'main' => "{$this->main_css_element} .et_pb_contact input.input-text",
                                                      ),
                                                      'font_size' => array('default' => '24px'),
                                                      'line_height'    => array('default' => '1.5em'),
                                      ),
                              ),
                              'button' => array(
                            'button' => array(
                              'label' => esc_html__( 'Button', 'et_builder' ),
                              'css' => array(
                                'main' => "{$this->main_css_element} .button",
                                'plugin_main' => "{$this->main_css_element}.et_pb_module",
                              ),
                              'box_shadow'  => array(
                                'css' => array(
                                  'main' => "{$this->main_css_element} .button",
                                      'important' => 'all',
                                ),
                              ),
                            ),
                          ),
        		);

                  }

                  function get_fields() {
    		$fields = array(
        'remove_heading' => array(
                'label'             => esc_html__( 'Remove Heading', 'et_builder' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                  'off' => esc_html__( 'No', 'et_builder' ),
                  'on'  => esc_html__( 'Yes', 'et_builder' ),
                ),
                'option_category' => 'configuration',
                'description'        => esc_html__( 'Enable this if you want to remove the Heading', 'et_builder' ),
                'toggle_slug'     => 'main_content',
              ),
              'admin_label' => array(
                  'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                  'type'        => 'text',
                  'toggle_slug'     => 'main_content',
                  'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
              ),
              '__getloginpasswordconfirm' => array(
                'type' => 'computed',
                'computed_callback' => array( 'db_login_password_confirmation_code', 'get_login_password_confirm' ),
                'computed_depends_on' => array(
                  'admin_label'
                ),
              ),
    		);

    		return $fields;
    	}

      public static function get_login_password_confirm ( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
          return;
        }
                ob_start();

                wc_print_notice( __( 'Password reset email has been sent.', 'woocommerce' ) );
                ?>

                <p><?php echo esc_html( apply_filters( 'woocommerce_lost_password_confirmation_message', __( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.', 'woocommerce' ) ) ); ?></p>

                <?php
        $data = ob_get_clean();

      return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {


                    if (is_admin()) {
                        return;
                    }


                      $remove_heading      = $this->props['remove_heading'];



                                            $custom_button  			= $this->props['custom_button'];
                                            $button_use_icon  			= $this->props['button_use_icon'];
                                            $button_icon 				= $this->props['button_icon'];
                                            $button_icon_placement 		= $this->props['button_icon_placement'];
                                            $button_bg_color       		= $this->props['button_bg_color'];



                      // button icon and background
                      if( $custom_button == 'on' ){

                          // button icon
                          if( $button_icon !== '' ){
                              $iconContent = DEBC_INIT::et_icon_css_content( esc_attr($button_icon) );

                              $iconSelector = '';
                              if( $button_icon_placement == 'right' ){
                                  $iconSelector = '%%order_class%% .button:after';
                              }elseif( $button_icon_placement == 'left' ){
                                  $iconSelector = '%%order_class%% .button:before';
                              }

                              if( !empty( $iconContent ) && !empty( $iconSelector ) ){
                                  ET_Builder_Element::set_style( $render_slug, array(
                                      'selector' => $iconSelector,
                                      'declaration' => "content: '{$iconContent}'!important;font-family:ETmodules!important;"
                                      )
                                  );
                              }
                  }

                  // fix the button padding if has no icon
                  if( $button_use_icon == 'off' ){
                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector' => 'body.woocommerce %%order_class%% .button',
                      'declaration' => "padding: 0.3em 1em!important"
                      )
                    );
                  }

                          // button background
                          if( !empty( $button_bg_color ) ){
                              ET_Builder_Element::set_style( $render_slug, array(
                                  'selector'    => 'body #page-container %%order_class%% .button',
                                  'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
                              ) );
                          }
                      }



                      if( $remove_heading == 'on' ){

                        ET_Builder_Element::set_style( $render_slug, array(
                          'selector'    => '.woocommerce-lost-password .main_title',
                          'declaration' => "display: none !important;",
                        ) );
                      }



                              //////////////////////////////////////////////////////////////////////

                              ob_start();


                              if( $remove_heading == 'on' ){

                        				ET_Builder_Element::set_style( $render_slug, array(
                        					'selector'    => '%%order_class%% .login-title',
                        					'declaration' => "display: none !important;",
                        				) );
                        			}


  wc_print_notice( __( 'Password reset email has been sent.', 'woocommerce' ) );
  ?>

  <p><?php echo esc_html( apply_filters( 'woocommerce_lost_password_confirmation_message', __( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.', 'woocommerce' ) ) ); ?></p>

<?php

                              $content = ob_get_clean();


                              return $content;
                  }
              }

            new db_login_password_confirmation_code;

?>
