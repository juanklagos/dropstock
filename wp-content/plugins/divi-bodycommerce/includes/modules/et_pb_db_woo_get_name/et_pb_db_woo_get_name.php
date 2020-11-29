<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_get_name_code extends ET_Builder_Module {



public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP Welcome Message - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_woo_get_name';

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
                              'headings'   => array(
                                                'label'    => esc_html__( 'Message', 'divi-bodyshop-woocommerce' ),
                                                'css'      => array(
                                                        'main' => "{$this->main_css_element}",
                                                ),
                                                'font_size' => array('default' => '24px'),
                                                'line_height'    => array('default' => '1.5em'),
                                ),
                              ),
                        'border' => array( ),
                  			'custom_margin_padding' => array(
                  				'css' => array(
                  					'important' => 'all',
                  				),
                  			),

        		);

                  }

                  function get_fields() {
    		$fields = array(
          'show_default_message' => array(
            'label'             => esc_html__( 'Show default welcome message?', 'divi-bodyshop-woocommerce' ),
            'type'              => 'yes_no_button',
            'options'           => array(
              'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
              'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
            ),
            'affects'=>array(
            'title',
            'suffix'
            ),
            'description' => __( 'If you want to display the default dashboard message that appears on WooCommerce, enable this.', 'divi-bodyshop-woocommerce' ),
            'default' => 'off',
          ),
          'title' => array(
                          'label'       => __( 'Message Prefix', 'divi-bodyshop-woocommerce' ),
                          'type'        => 'text',
                          'depends_show_if' => 'off',
                          'description' => __( 'Enter in a message that will appear before the users name. For example: Welcome, ....', 'divi-bodyshop-woocommerce' ),
          ),
            'suffix' => array(
                            'label'       => __( 'Message Suffix', 'divi-bodyshop-woocommerce' ),
                            'type'        => 'text',
                            'depends_show_if' => 'off',
                            'description' => __( 'Enter in a message that will appear after the users name.', 'divi-bodyshop-woocommerce' ),
            ),
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__getwelcomemessage' => array(
            'type' => 'computed',
            'computed_callback' => array( 'db_woo_get_name_code', 'get_welcome_message' ),
            'computed_depends_on' => array(
              'admin_label'
            ),
          ),
    		);

    		return $fields;
    	}

      public static function get_welcome_message( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}

        ob_start();

        echo do_shortcode( "[db_woo_get_name]" );

        $data = ob_get_clean();

        return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {

                $title = $this->props['title'];
                $suffix = $this->props['suffix'];
                $show_default_message = $this->props['show_default_message'];



                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                  ob_start();

                  if ($show_default_message == 'on') {
                    $user_info = get_userdata(get_current_user_id());
                    		$first_name = $user_info->first_name;
                    		$last_name = $user_info->last_name;
                        $display_name = $user_info->display_name;
                    ?>

                    <p>
                    	<?php
                    	printf(
                    		/* translators: 1: user display name 2: logout url */
                    		__( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ),
                    		'<strong>' . esc_html( $display_name ) . '</strong>',
                    		esc_url( wc_logout_url() )
                    	);
                    	?>
                    </p>

                    <p>
                    	<?php
                    	printf(
                    		__( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' ),
                    		esc_url( wc_get_endpoint_url( 'orders' ) ),
                    		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
                    		esc_url( wc_get_endpoint_url( 'edit-account' ) )
                    	);
                    	?>
                    </p>

                    <?php
                  } else {

                  echo esc_html__( $title, 'divi-bodyshop-woocommerce' );
                  echo do_shortcode( "[db_woo_get_name]" );
                  echo esc_html__( $suffix, 'divi-bodyshop-woocommerce' );

                }

                  $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////


                  return $data;
                  }
              }

            new db_woo_get_name_code;

?>
