<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_user_name_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP User Name - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_woo_user_name';

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
                                                'label'    => esc_html__( 'Name', 'et_builder' ),
                                                'css'      => array(
                                                        'main' => "{$this->main_css_element}",
                                                ),
                                                'font_size' => array('default' => '24px'),
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

                  }

                  function get_fields() {
    		$fields = array(
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__get_username' => array(
            'type' => 'computed',
            'computed_callback' => array( 'db_woo_user_name_code', 'get_username' ),
            'computed_depends_on' => array(
              'admin_label'
            ),
          ),
    		);

    		return $fields;
    	}

      public static function get_username( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}

        $data = do_shortcode( "[db_woo_get_name]" );

        return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {

                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();
                    echo do_shortcode( "[db_woo_get_name]" );
                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_woo_user_name_code;

?>
