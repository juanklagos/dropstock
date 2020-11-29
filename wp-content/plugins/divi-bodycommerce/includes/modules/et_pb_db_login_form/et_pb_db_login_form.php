<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_login_form_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.LP Login Form - Login Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_login_form';

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
                                                        'main' => "{$this->main_css_element} h2.login-title",
                                                ),
                                                'font_size' => array('default' => '24px'),
                                                'line_height'    => array('default' => '1.5em'),
                                ),
                                'sub_heading'   => array(
                                                  'label'    => esc_html__( 'Sub Heading', 'divi-bodyshop-woocommerce' ),
                                                  'css'      => array(
                                                          'main' => "{$this->main_css_element} p.grey-txt",
                                                  ),
                                                  'font_size' => array('default' => '16px'),
                                                  'line_height'    => array('default' => '1.5em'),
                                  ),
                                  'input_label'   => array(
                                                    'label'    => esc_html__( 'Input Label', 'divi-bodyshop-woocommerce' ),
                                                    'css'      => array(
                                                            'main' => "{$this->main_css_element} .woocommerce-form label",
                                                    ),
                                                    'font_size' => array('default' => '24px'),
                                                    'line_height'    => array('default' => '2em'),
                                    ),
                                    'input'   => array(
                                                      'label'    => esc_html__( 'Input', 'divi-bodyshop-woocommerce' ),
                                                      'css'      => array(
                                                              'main' => ".woocommerce {$this->main_css_element} form .form-row input.input-text,
                                                              .woocommerce {$this->main_css_element} form .form-row input.input-text::placeholder,
                                                              .woocommerce {$this->main_css_element} form .form-row input.input-text:-ms-input-placeholder,
                                                              .woocommerce {$this->main_css_element} form .form-row input.input-text::-webkit-input-placeholder
                                                              ",
                                                      ),
                                                      'font_size' => array('default' => '24px'),
                                                      'line_height'    => array('default' => '1.5em'),
                                      ),
                                      'remeber_me'   => array(
                                                        'label'    => esc_html__( 'Remember Me', 'divi-bodyshop-woocommerce' ),
                                                        'css'      => array(
                                                                'main' => ".woocommerce {$this->main_css_element} #rememberme+span",
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
            'label'           => __( 'Header Text', 'divi-bodyshop-woocommerce' ),
            'type'            => 'text',
            'option_category' => 'configuration',
            'description'     => __( 'Enter in the text you want as the header - default is "Login"', 'divi-bodyshop-woocommerce' ),
            'toggle_slug'     => 'main_content',
        ),
        'sub_heading_text' => array(
            'label'           => __( 'Sub-Heading Text', 'divi-bodyshop-woocommerce' ),
            'type'            => 'text',
            'option_category' => 'configuration',
            'description'     => __( 'Enter in the text you want that appears just below the heading - by default there is nothing"', 'divi-bodyshop-woocommerce' ),
            'toggle_slug'     => 'main_content',
        ),

        'redirect' => array(
        'label'             => esc_html__( 'Redirect Logged In Users', 'divi-bodyshop-woocommerce' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'configuration',
        'options'           => array(
        'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
        'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
        'toggle_slug'     => 'main_content',
        ),
        'description'        => esc_html__( 'Enable this to redirect logged in users to the account section of your website. Disabling this is useful when customising the form.', 'divi-bodyshop-woocommerce' ),
        ),
        'custom_redirect_url' => array(
            'label'           => __( 'Custom Redirect URL', 'divi-bodyshop-woocommerce' ),
            'type'            => 'text',
            'option_category' => 'configuration',
            'description'     => __( 'Enter in a URL you want the user to go to when logged in. By default they will go to the my account page"', 'divi-bodyshop-woocommerce' ),
            'toggle_slug'     => 'main_content',
        ),
                    'admin_label' => array(
                        'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                        'type'        => 'text',
                        'toggle_slug'     => 'main_content',
                        'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                    ),
                    '__getloginform' => array(
                      'type' => 'computed',
                      'computed_callback' => array( 'db_login_form_code', 'get_login_form' ),
                      'computed_depends_on' => array(
                        'admin_label'
                      ),
                    ),
                );

    return $fields;
  }


  public static function get_login_form ( $args = array(), $conditional_tags = array(), $current_page = array() ){
    if (!is_admin()) {
      return;
    }
            ob_start();

            ?>

            <form class="woocommerce-form woocommerce-form-login login" method="post" style="border: none;padding: 0;">

              <?php do_action( 'woocommerce_login_form_start' ); ?>
<div class="et_pb_contact">
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide username-wrapper">
<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>" /><?php // @codingStandardsIgnoreLine ?>
</p>
<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide password-wrapper">
<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>" />
</p>

<?php do_action( 'woocommerce_login_form' ); ?>

<p class="form-row">
<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
<button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
</label>
</p>
<p class="woocommerce-LostPassword lost_password">
<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
</p>

<?php do_action( 'woocommerce_login_form_end' ); ?>

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
                      $remove_heading      = $this->props['remove_heading'];



                      $custom_button  			= $this->props['custom_button'];
                      $button_use_icon  			= $this->props['button_use_icon'];
                      $button_icon 				= $this->props['button_icon'];
                      $button_icon_placement 		= $this->props['button_icon_placement'];
                      $button_bg_color       		= $this->props['button_bg_color'];

                      $custom_redirect_url       		= $this->props['custom_redirect_url'];



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
                					'selector'    => '%%order_class%% .login-title',
                					'declaration' => "display: none !important;",
                				) );
                			}

                      if ($header_text == "") {
                        $header_text_display = "Login";
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

                          include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
                            $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
                          $divi_specific_login = $titan->getOption( 'divi_specific_login' );

  //////////////////////////// DIVI ENGINE LOGIN PAGE
  if ($divi_specific_login == "lostpasswordabove") {
                              ?>
                              <h2 class="login-title"><?php echo $header_text_display ?></h2>
                           <p class="grey-txt"><?php echo $sub_heading_text_display ?> </p>

                              <form class="woocommerce-form woocommerce-form-login login" method="post" style="border: none;padding: 0;">

                                <?php do_action( 'woocommerce_login_form_start' ); ?>
  <div class="et_pb_contact">
  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide username-wrapper">
    <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>" /><?php // @codingStandardsIgnoreLine ?>
  </p>
  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide password-wrapper">
    <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>" />
  </p>

  <?php do_action( 'woocommerce_login_form' ); ?>
  <p class="woocommerce-LostPassword lost_password">
    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot?', 'woocommerce' ); ?></a>
  </p>
  <p class="form-row">
    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
      <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
    </label>
    <button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
  </p>


  <?php do_action( 'woocommerce_login_form_end' ); ?>
  </div>
                              </form>

                              <script>
                              jQuery(document).ready(function( $ ) {
                                $("body").addClass("login-page");
                              });
                              </script>




  <?php } else {
if ( is_user_logged_in() ) {
} else {
  ?>
                              <h2 class="login-title"><?php echo $header_text_display ?></h2>
                           <p class="grey-txt"><?php echo $sub_heading_text_display ?> </p>

                              <form class="woocommerce-form woocommerce-form-login login" method="post" style="border: none;padding: 0;">

                                <?php do_action( 'woocommerce_login_form_start' ); ?>
  <div class="et_pb_contact">
  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide username-wrapper">
    <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>" /><?php // @codingStandardsIgnoreLine ?>
  </p>
  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide password-wrapper">
    <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>" />
  </p>

  <?php do_action( 'woocommerce_login_form' ); ?>

  <p class="form-row">
    <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
    <button type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?></button>
    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
      <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
    </label>
  </p>
  <p class="woocommerce-LostPassword lost_password">
    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
  </p>


  <?php do_action( 'woocommerce_login_form_end' ); ?>
  </div>

  <?php if ($custom_redirect_url !== "") { ?>
  <input type="hidden" name="redirect" value="<?php echo $custom_redirect_url; ?>" />
  <?php } ?>
                              </form>

                              <script>
                              jQuery(document).ready(function( $ ) {
                                $("body").addClass("login-page");
                              });
                              </script>
  <?php
}
} ?>

                              <?php
                              $content = ob_get_clean();


                              return $content;
                  }
              }

            new db_login_form_code;

?>
