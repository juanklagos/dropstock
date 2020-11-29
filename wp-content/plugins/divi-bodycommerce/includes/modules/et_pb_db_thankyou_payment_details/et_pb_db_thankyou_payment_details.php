<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_thankyou_payment_details extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.TP Payment Details - Thank You', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_thankyou_payment_details';

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
                              'table_head' => array(
                                  'label' => esc_html__('Titles', 'et_builder'),
                                  'css' => array(
                                      'main' => ".woocommerce {$this->main_css_element} h1, .woocommerce {$this->main_css_element} h2, .woocommerce {$this->main_css_element} h3, .woocommerce {$this->main_css_element} h4",
                                  ),
                              ),
                                  'products' => array(
                                      'label' => esc_html__('Paragraph', 'et_builder'),
                                      'css' => array(
                                          'main' => ".woocommerce {$this->main_css_element}, .woocommerce {$this->main_css_element} p",
                                      ),
                                  ),
                          ),
                          'background' => array(
                              'settings' => array(
                                  'color' => 'alpha',
                              ),
                          ),
                          'border' => array(
                              'css' => array(
                                  'important' => 'all',
                              ),
                          ),
                          'custom_margin_padding' => array(
                              'css' => array(
                                  'important' => 'all',
                              ),
                          ),
                      );

                  }

                  function get_fields() {
    		$fields = array(
          'remove_title' => array(
              'label' => esc_html__('Remove Title?', 'divi-bodyshop-woocommerce'),
              'type' => 'yes_no_button',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                  'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
              ),
              'default' => 'off',
              'description' => 'If you want to remove the title, enable this.',
          ),
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__getthankyoupaymentdetails' => array(
            'type' => 'computed',
            'computed_callback' => array( 'db_woo_thankyou_payment_details', 'get_thankyou_payment_details' ),
            'computed_depends_on' => array(
              'admin_label'
            ),
          ),
          );

          return $fields;
          }


          public static function get_thankyou_payment_details( $args = array(), $conditional_tags = array(), $current_page = array() ){

            if (is_admin()) {
                return;
            }


          ob_start();


          $order_statuses = array('wc-completed');

          $customer_user_id = get_current_user_id();

          $customer_orders = wc_get_orders( array(
          'meta_key' => '_customer_user',
          'meta_value' => $customer_user_id,
          'post_status' => $order_statuses,
          'numberposts' => -1
          ) );


          $first = true;

          foreach($customer_orders as $order ){

          if ( $first )  {

          //*--------------------------------------------------------------------------*//

          $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;

          $order = wc_get_order($order_id);

           do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );

          //*--------------------------------------------------------------------------*//

          $first = false;
          } else {

          }

          }


          $data = ob_get_clean();

          //////////////////////////////////////////////////////////////////////

          return $data;


          }

                  function render( $attrs, $content = null, $render_slug ) {


                    $remove_title = $this->props['remove_title'];

                    if ($remove_title == 'on') {
                      $this->add_classname( 'details-no-title' );
                    }

                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                  ob_start();



global $wp;
    // Get the order ID
$order_id  = absint( $wp->query_vars['order-received'] );

$order = wc_get_order($order_id);

// check if order cust id = current user id
if( ! is_a($order, 'WC_Order') ) {
    $order_id = $post->ID;
    $order = wc_get_order($order_id);
} else {
    $order_id = $order->id;
}
$user_id = $order->get_user_id();
$current_user_id = get_current_user_id();
if ($current_user_id !== $user_id) {
    return;
}
// END check customer id

 do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );

                $content = ob_get_clean();


                //////////////////////////////////////////////////////////////////////

                return $content;
                  }
              }

            new db_woo_thankyou_payment_details;

?>
