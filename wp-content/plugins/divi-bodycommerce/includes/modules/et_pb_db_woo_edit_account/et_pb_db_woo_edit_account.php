<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_edit_account_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP Edit Account - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_woo_edit_account';

		$this->fields_defaults = array(
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
                          'form_field'   => array(
                            'label'    => esc_html__( 'Form Field', 'et_builder' ),
                            'css'      => array(
                              'main' => array(
                                "{$this->main_css_element} .woocommerce-EditAccountForm input[type=text]",
                                ".woocommerce {$this->main_css_element} form .form-row input.input-text, .woocommerce form .form-row textarea",
                                ".woocommerce {$this->main_css_element} form .form-row input.input-text, .woocommerce form .form-row .input-text",
                                "{$this->main_css_element} .woocommerce-EditAccountForm input[type=email]",
                                "{$this->main_css_element} .woocommerce-EditAccountForm input[type=password]",
                              ),
                              'important' => 'plugin_only',
                            ),
                          ),
                            'form_field_label'   => array(
                              'label'    => esc_html__( 'Form Field Label', 'et_builder' ),
                              'css'      => array(
                                'main' => array(
                                  "{$this->main_css_element} .woocommerce-EditAccountForm label",
                                ),
                                'important' => 'plugin_only',
                              ),
                            ),
                        ),
                        'border' => array(
                          'css'      => array(
                            'main' => sprintf(
                              '%1$s .woocommerce-EditAccountForm input[type=text],
                              %1$s .woocommerce-EditAccountForm input[type=email],
                              %1$s .woocommerce-EditAccountForm input[type=password]',
                              $this->main_css_element
                            ),
                            'important' => 'plugin_only',
                          ),
                          'settings' => array(
                            'color' => 'alpha',
                          ),
                        ),
                        'button' => array(
                      'button' => array(
                        'label' => esc_html__( 'Button', 'et_builder' ),
                        'css' => array(
                          'main' => "{$this->main_css_element} .button",
                          'plugin_main' => "{$this->main_css_element}",
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
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__geteditaccount' => array(
            'type' => 'computed',
            'computed_callback' => array( 'db_woo_edit_account_code', 'get_edit_account' ),
            'computed_depends_on' => array(
              'admin_label'
            ),
          ),

    		);

    		return $fields;
    	}


      public static function get_edit_account( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}

        ob_start();

        $data = '';

        if (is_user_logged_in() ) {
            global $woocommerce;
            $user_id = get_current_user_id();
            $user = get_userdata( $user_id );
            ?>
  <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

  <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

  <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
    <label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="<?php esc_html_e( 'First name', 'woocommerce' ); ?>"/>
  </p>
  <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
    <label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" placeholder="<?php esc_html_e( 'Last name', 'woocommerce' ); ?>" />
  </p>
  <div class="clear"></div>

  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" placeholder="<?php esc_html_e( 'Display name', 'woocommerce' ); ?>"/> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
  </p>
  <div class="clear"></div>

  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
    <label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
    <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" placeholder="<?php esc_html_e( 'Email address', 'woocommerce' ); ?>" />
  </p>

  <fieldset>
    <legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
      <label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
      <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" placeholder="<?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?>"/>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
      <label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
      <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" placeholder="<?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?>"/>
    </p>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
      <label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
      <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" placeholder="<?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?>"/>
    </p>
  </fieldset>
  <div class="clear"></div>

  <?php do_action( 'woocommerce_edit_account_form' ); ?>

  <p>
    <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
    <button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
    <input type="hidden" name="action" value="save_account_details" />
  </p>

  <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form> <?php    } else {

                 }
        $data = ob_get_clean();

       //////////////////////////////////////////////////////////////////////

      return $data;


      }

                  function render( $attrs, $content = null, $render_slug ) {

                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();

    	       do_action( 'claimstar_accountdetails' );

                    if (is_user_logged_in() ) {
                        global $woocommerce;
                        $user_id = get_current_user_id();
                        $user = get_userdata( $user_id );
                        ?>
              <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

            	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

            	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            		<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="<?php esc_html_e( 'First name', 'woocommerce' ); ?>"/>
            	</p>
            	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            		<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" placeholder="<?php esc_html_e( 'Last name', 'woocommerce' ); ?>" />
            	</p>
            	<div class="clear"></div>

            	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            		<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" placeholder="<?php esc_html_e( 'Display name', 'woocommerce' ); ?>"/> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
            	</p>
            	<div class="clear"></div>

            	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            		<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" placeholder="<?php esc_html_e( 'Email address', 'woocommerce' ); ?>" />
            	</p>

            	<fieldset>
            		<legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

            		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            			<label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
            			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" placeholder="<?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?>"/>
            		</p>
            		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            			<label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
            			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" placeholder="<?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?>"/>
            		</p>
            		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            			<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
            			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" placeholder="<?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?>"/>
            		</p>
            	</fieldset>
            	<div class="clear"></div>

            	<?php do_action( 'woocommerce_edit_account_form' ); ?>

            	<p>
            		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
            		<button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
            		<input type="hidden" name="action" value="save_account_details" />
            	</p>

            	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
            </form> <?php    } else {

                             }
                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_woo_edit_account_code;

?>
