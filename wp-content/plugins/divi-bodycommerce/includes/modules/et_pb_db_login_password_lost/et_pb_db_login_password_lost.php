<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_login_password_lost_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.LP Lost Password Form - Login Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_login_password_lost';

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
                                  'paragraph'   => array(
                                                        'label'    => esc_html__( 'Paragrapgh', 'divi-bodyshop-woocommerce' ),
                                                        'css'      => array(
                                                                'main' => "{$this->main_css_element} p",
                                                        ),
                                                        'font_size' => array('default' => '24px'),
                                                        'line_height'    => array('default' => '1.5em'),
                                        ),
                                  'input_label'   => array(
                                                    'label'    => esc_html__( 'Input Label', 'divi-bodyshop-woocommerce' ),
                                                    'css'      => array(
                                                            'main' => "{$this->main_css_element} form .form-row label",
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
                              'margin_padding' => array(
                              'css'           => array(
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
              '__getloginpasswordlost' => array(
                'type' => 'computed',
                'computed_callback' => array( 'db_login_password_lost_code', 'get_login_password_lost' ),
                'computed_depends_on' => array(
                  'admin_label'
                ),
              ),
    		);

    		return $fields;
    	}


      public static function get_login_password_lost ( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
          return;
        }
                ob_start();

                do_action( 'woocommerce_before_lost_password_form' );
                ?>

                <form method="post" class="woocommerce-ResetPassword lost_reset_password">
                  <div class="et_pb_contact">
                    <p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

                  	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
                  		<label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label>
                  		<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
                  	</p>

                  	<div class="clear"></div>

                  	<?php do_action( 'woocommerce_lostpassword_form' ); ?>

                  	<p class="woocommerce-form-row form-row">
                  		<input type="hidden" name="wc_reset_password" value="true" />
                  		<button type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
                  	</p>

                  	<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
                </div>
                </form>
                <?php
                do_action( 'woocommerce_after_lost_password_form' );

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
                                            $button_text_color       		= $this->props['button_text_color'];
                                            $button_text_color__hover_test = isset($this->props['button_text_color__hover']);
                                            if ($button_text_color__hover_test == true) {
                                            $button_text_color__hover       		= $this->props['button_text_color__hover'];
                                          }



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
                          // button text
                          if( !empty( $button_text_color ) ){
                              ET_Builder_Element::set_style( $render_slug, array(
                                  'selector'    => 'body #page-container %%order_class%% .woocommerce-Button',
                                  'declaration' => "color:". esc_attr( $button_text_color ) ."!important;",
                              ) );
                          }
                          // button text hover
                          if( !empty( $button_text_color__hover ) ){
                              ET_Builder_Element::set_style( $render_slug, array(
                                  'selector'    => 'body #page-container %%order_class%% .woocommerce-Button:hover',
                                  'declaration' => "color:". esc_attr( $button_text_color__hover ) ."!important;",
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
                                  'selector'    => '.woocommerce-lost-password .main_title',
                                  'declaration' => "display: none !important;",
                                ) );
                              }


do_action( 'woocommerce_before_lost_password_form' );
?>

<form method="post" class="woocommerce-ResetPassword lost_reset_password">
  <div class="et_pb_contact">
    <p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

  	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
  		<label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label>
  		<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
  	</p>

  	<div class="clear"></div>

  	<?php do_action( 'woocommerce_lostpassword_form' ); ?>

  	<p class="woocommerce-form-row form-row">
  		<input type="hidden" name="wc_reset_password" value="true" />
  		<button type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
  	</p>

  	<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
</div>
</form>
<?php
do_action( 'woocommerce_after_lost_password_form' );

                              $content = ob_get_clean();


                              return $content;
                  }
              }

            new db_login_password_lost_code;

?>
