<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_register_form_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.LP Register Form - Login Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_register_form';

                    $this->fields_defaults = array(
                    'redirect'   => array( 'on' ),
                    'first_name'   => array( 'off' ),
                    'last_name'   => array( 'off' ),
                    'phone'   => array( 'off' ),
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
                                                'label'    => esc_html__( 'Heading', 'et_builder' ),
                                                'css'      => array(
                                                        'main' => "{$this->main_css_element} h2.register-title",
                                                ),
                                                'font_size' => array('default' => '24px'),
                                                'line_height'    => array('default' => '1.5em'),
                                ),
                                'sub_heading'   => array(
                                                  'label'    => esc_html__( 'Sub Heading', 'et_builder' ),
                                                  'css'      => array(
                                                          'main' => "{$this->main_css_element} p.grey-txt",
                                                  ),
                                                  'font_size' => array('default' => '16px'),
                                                  'line_height'    => array('default' => '1.5em'),
                                  ),
                                  'input_label'   => array(
                                                    'label'    => esc_html__( 'Input Label', 'et_builder' ),
                                                    'css'      => array(
                                                            'main' => ".woocommerce {$this->main_css_element} form .form-row label",
                                                    ),
                                                    'font_size' => array('default' => '24px'),
                                                    'line_height'    => array('default' => '2em'),
                                    ),
                                    'input'   => array(
                                                      'label'    => esc_html__( 'Input', 'et_builder' ),
                                                      'css'      => array(
                                                              'main' => ".woocommerce {$this->main_css_element} form .form-row input.input-text",
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
          'header_text' => array(
              'label'           => __( 'Header Text', 'et_builder' ),
              'type'            => 'text',
              'option_category' => 'configuration',
              'toggle_slug'     => 'main_content',
              'description'     => __( 'Enter in the text you want as the header - default is "Register"', 'et_builder' ),
          ),
          'sub_heading_text' => array(
              'label'           => __( 'Sub-Heading Text', 'et_builder' ),
              'type'            => 'text',
              'option_category' => 'configuration',
              'toggle_slug'     => 'main_content',
              'description'     => __( 'Enter in the text you want that appears just below the heading - by default there is nothing"', 'et_builder' ),
          ),
          'redirect' => array(
          'label'             => esc_html__( 'Redirect Logged In Users', 'et_builder' ),
          'type'              => 'yes_no_button',
          'option_category'   => 'layout',
          'option_category'   => 'configuration',
          'toggle_slug'     => 'main_content',
          'options'           => array(
          'on'  => esc_html__( 'Yes', 'et_builder' ),
          'off' => esc_html__( 'No', 'et_builder' ),
          ),
          'description'        => esc_html__( 'Enable this to redirect logged in users to the account section of your website. Disabling this is useful when customising the form.', 'et_builder' ),
          ),
          'first_name' => array(
          'label'             => esc_html__( 'Enable First Name Field', 'et_builder' ),
          'type'              => 'yes_no_button',
          'option_category'   => 'layout',
          'option_category'   => 'configuration',
          'toggle_slug'     => 'main_content',
          'options'           => array(
          'on'  => esc_html__( 'Yes', 'et_builder' ),
          'off' => esc_html__( 'No', 'et_builder' ),
          ),
          'description'        => esc_html__( 'Enable this if you want to enable the first name in the registration form.', 'et_builder' ),
          ),
          'last_name' => array(
          'label'             => esc_html__( 'Enable Last Name Field', 'et_builder' ),
          'type'              => 'yes_no_button',
          'option_category'   => 'layout',
          'option_category'   => 'configuration',
          'toggle_slug'     => 'main_content',
          'options'           => array(
          'on'  => esc_html__( 'Yes', 'et_builder' ),
          'off' => esc_html__( 'No', 'et_builder' ),
          ),
          'description'        => esc_html__( 'Enable this if you want to enable the last name in the registration form.', 'et_builder' ),
          ),
          'phone' => array(
          'label'             => esc_html__( 'Enable Phone Number Field', 'et_builder' ),
          'type'              => 'yes_no_button',
          'option_category'   => 'layout',
          'option_category'   => 'configuration',
          'toggle_slug'     => 'main_content',
          'options'           => array(
          'on'  => esc_html__( 'Yes', 'et_builder' ),
          'off' => esc_html__( 'No', 'et_builder' ),
          ),
          'description'        => esc_html__( 'Enable this if you want to enable the phone number in the registration form.', 'et_builder' ),
          ),
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__getloginregister' => array(
            'type' => 'computed',
            'computed_callback' => array( 'db_register_form_code', 'get_login_register' ),
            'computed_depends_on' => array(
              'admin_label'
            ),
          ),
    		);

    		return $fields;
    	}

      public static function get_login_register ( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
          return;
        }
                ob_start();
                ?>

                <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> style="border: none;padding: 0;">
                                    <?php do_action( 'woocommerce_register_form_start' ); ?>
                <div class="et_pb_contact">
                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username', 'woocommerce' ); ?>"/><?php // @codingStandardsIgnoreLine ?>
                </p>

                <?php endif; ?>

                <p class="form-row form-row-first first-name">
                <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
                <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
                </p>




                <p class="form-row form-row-last last-name">
                <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
                <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
                </p>


                <div class="clear"></div>


                <p class="form-row form-row-wide phone">
                <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
                <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />
                </p>


                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Email address', 'woocommerce' ); ?>"/><?php // @codingStandardsIgnoreLine ?>
                </p>



                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide generate-password">
                <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>"/>
                </p>



                <?php do_action( 'woocommerce_register_form' ); ?>

                <p class="woocommerce-FormRow form-row">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
                </p>

                <?php do_action( 'woocommerce_register_form_end' ); ?>
                </div>
                </form>

                            <?php
        $data = ob_get_clean();

      return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {


                    if (is_admin()) {
                        return;
                    }



                      $header_text       = $this->props['header_text'];
                      $sub_heading_text       = $this->props['sub_heading_text'];
                      $redirect      = $this->props['redirect'];
                      $first_name      = $this->props['first_name'];
                      $last_name      = $this->props['last_name'];
                      $phone      = $this->props['phone'];
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
                					'selector'    => '%%order_class%% .register-title',
                					'declaration' => "display: none !important;",
                				) );
                			}

                      if ($header_text == "") {
                        $header_text_display = "Register";
                      }
                      else {
                        $header_text_display = $header_text;
                      }

                      if ($sub_heading_text == "") {
                        $sub_heading_text_display = "";
                      }
                      else {

                          $sub_heading_text_display = $sub_heading_text;
                      }






                              //////////////////////////////////////////////////////////////////////

                              ob_start();
                              if($redirect == 'on') {
                              if ( is_user_logged_in() ) {
                                ?>
                            <script>
                            window.location.replace("<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>");
                            </script>
                            <?php
                            }
                          }
                          else {
                            # code...
                          }
                              ?>
                              <h2 class="register-title"><?php echo $header_text_display ?></h2>
                          <p class="grey-txt"><?php echo $sub_heading_text_display ?> </p>

                <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> style="border: none;padding: 0;">
                                    <?php do_action( 'woocommerce_register_form_start' ); ?>
                <div class="et_pb_contact">
                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username', 'woocommerce' ); ?>"/><?php // @codingStandardsIgnoreLine ?>
                </p>

                <?php endif; ?>
                <?php if ($first_name == "on") { ?>
                <p class="form-row form-row-first">
                <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
                <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
                </p>
                <?php } ?>


                <?php if ($last_name == "on") { ?>
                <p class="form-row form-row-last">
                <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
                <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
                </p>
                <?php } ?>

                <div class="clear"></div>

                <?php if ($phone == "on") { ?>
                <p class="form-row form-row-wide">
                <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
                <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />
                </p>
                <?php } ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Email address', 'woocommerce' ); ?>"/><?php // @codingStandardsIgnoreLine ?>
                </p>

                <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>"/>
                </p>

                <?php endif; ?>

                <?php do_action( 'woocommerce_register_form' ); ?>

                <p class="woocommerce-FormRow form-row">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
                </p>

                <?php do_action( 'woocommerce_register_form_end' ); ?>
                </div>



                </form>

                <script>
                jQuery(document).ready(function( $ ) {
                $("body").addClass("register-page");
                });
                </script>

                              <?php
                              $content = ob_get_clean();


                              return $content;
                  }
              }

            new db_register_form_code;

?>
