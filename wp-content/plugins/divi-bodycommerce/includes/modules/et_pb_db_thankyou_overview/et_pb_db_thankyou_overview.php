<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_thankyou_overview extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.TP Order Overview - Thank You', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_thankyou_overview';

		$this->fields_defaults = array(
    'remove_order_number' 	=> array( 'off' ),
    'remove_date' 	=> array( 'off' ),
    'remove_email' 	=> array( 'off' ),
    'remove_total' 	=> array( 'off' ),
    'remove_payment_method' 	=> array( 'off' ),
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
                              'title' => array(
                                  'label' => esc_html__('Title', 'et_builder'),
                                  'css' => array(
                                      'main' => ".woocommerce {$this->main_css_element} ul.order_details li",
                                  ),
                              ),
                                  'value' => array(
                                      'label' => esc_html__('Value', 'et_builder'),
                                      'css' => array(
                                          'main' => ".woocommerce {$this->main_css_element} ul.order_details li strong",
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
          'remove_order_number' => array(
              'label' => esc_html__('Remove Order Number', 'divi-bodyshop-woocommerce'),
              'type' => 'yes_no_button',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                  'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
              ),
              'description' => 'if you want to hide the order number, enable this',
          ),
            'remove_date' => array(
                'label' => esc_html__('Remove Order Date', 'divi-bodyshop-woocommerce'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_settings',
                'options' => array(
                    'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                    'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
                ),
                'description' => 'if you want to hide the order date, enable this',
            ),
              'remove_email' => array(
                  'label' => esc_html__('Remove Order Email', 'divi-bodyshop-woocommerce'),
                  'type' => 'yes_no_button',
                  'toggle_slug' => 'main_settings',
                  'options' => array(
                      'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                      'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
                  ),
                  'description' => 'if you want to hide the order email, enable this',
              ),
                'remove_total' => array(
                    'label' => esc_html__('Remove Order Total', 'divi-bodyshop-woocommerce'),
                    'type' => 'yes_no_button',
                    'toggle_slug' => 'main_settings',
                    'options' => array(
                        'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                        'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
                    ),
                    'description' => 'if you want to hide the order total, enable this',
                ),
                  'remove_payment_method' => array(
                      'label' => esc_html__('Remove Order Payment Method', 'divi-bodyshop-woocommerce'),
                      'type' => 'yes_no_button',
                      'toggle_slug' => 'main_settings',
                      'options' => array(
                          'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                          'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
                      ),
                      'description' => 'if you want to hide the order payment method, enable this',
                  ),
                    'divider_border_color' => array(
                        'label' => esc_html__('Divider Border Colour', 'divi-bodyshop-woocommerce'),
                        'type' => 'color-alpha',
                        'toggle_slug' => 'main_settings',
                        'default'   => '#d3ced2',
                        'description' => 'Choose the color of the border',
                    ),
                      'divider_border_style' => array(
                          'label' => esc_html__('Divider Border Style', 'divi-bodyshop-woocommerce'),
                          'type' => 'select',
                          'toggle_slug' => 'main_settings',
                          'options' => array(
                            'none' => esc_html__('None', 'divi-bodyshop-woocommerce'),
                            'dashed' => esc_html__('Dashed', 'divi-bodyshop-woocommerce'),
                            'dotted' => esc_html__('Dotted', 'divi-bodyshop-woocommerce'),
                            'solid' => esc_html__('Solid', 'divi-bodyshop-woocommerce'),
                            'double' => esc_html__('Double', 'divi-bodyshop-woocommerce'),
                            'groove' => esc_html__('Groove', 'divi-bodyshop-woocommerce'),
                            'ridge' => esc_html__('Ridge', 'divi-bodyshop-woocommerce'),
                            'inset' => esc_html__('Inset', 'divi-bodyshop-woocommerce'),
                            'outset' => esc_html__('Outset', 'divi-bodyshop-woocommerce'),
                          ),
                          'default'     => 'dashed',
                          'description' => 'if you want to hide the order payment method, enable this',
                      ),
                      'admin_label' => array(
                          'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                          'type'        => 'text',
                          'toggle_slug'     => 'main_content',
                          'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                      ),
                      '__getthankyouoverview' => array(
                        'type' => 'computed',
                        'computed_callback' => array( 'db_woo_thankyou_overview', 'get_thankyou_overview' ),
                        'computed_depends_on' => array(
                          'admin_label'
                        ),
                      ),
    		);

    		return $fields;
    	}


      public static function get_thankyou_overview( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
          			return;
          		}

      ob_start();


  $order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed');

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


    
      ?>

      <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

        <li class="woocommerce-order-overview__order order">
          <?php _e( 'Order number:', 'woocommerce' ); ?>
          <strong><?php echo $order->get_order_number(); ?></strong>
        </li>

        <li class="woocommerce-order-overview__date date">
          <?php _e( 'Date:', 'woocommerce' ); ?>
          <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
        </li>

        <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
          <li class="woocommerce-order-overview__email email">
            <?php _e( 'Email:', 'woocommerce' ); ?>
            <strong><?php echo $order->get_billing_email(); ?></strong>
          </li>
        <?php endif; ?>

        <li class="woocommerce-order-overview__total total">
          <?php _e( 'Total:', 'woocommerce' ); ?>
          <strong><?php echo $order->get_formatted_order_total(); ?></strong>
        </li>

        <?php if ( $order->get_payment_method_title() ) : ?>
          <li class="woocommerce-order-overview__payment-method method">
            <?php _e( 'Payment method:', 'woocommerce' ); ?>
            <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
          </li>
        <?php endif; ?>


      </ul>

      <?php

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


                    $remove_order_number = $this->props['remove_order_number'];
                    $remove_date = $this->props['remove_date'];
                    $remove_email = $this->props['remove_email'];
                    $remove_total = $this->props['remove_total'];
                    $remove_payment_method = $this->props['remove_payment_method'];

                    $divider_border_color = $this->props['divider_border_color'];
                    $divider_border_style = $this->props['divider_border_style'];




                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();

$main_css_element_name = $this->main_css_element;
?>

<style>
.woocommerce ul.order_details li {
  border-style: <?php echo $divider_border_style ?>;
  border-color: <?php echo $divider_border_color ?>;
}
</style>

<?php

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
  ?>

  <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
<?php if ($remove_order_number == "off") { ?>
    <li class="woocommerce-order-overview__order order">
      <?php _e( 'Order number:', 'woocommerce' ); ?>
      <strong><?php echo $order->get_order_number(); ?></strong>
    </li>
<?php } ?>
<?php if ($remove_date == "off") { ?>
    <li class="woocommerce-order-overview__date date">
      <?php _e( 'Date:', 'woocommerce' ); ?>
      <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
    </li>
<?php } ?>
<?php if ($remove_email == "off") { ?>
    <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
      <li class="woocommerce-order-overview__email email">
        <?php _e( 'Email:', 'woocommerce' ); ?>
        <strong><?php echo $order->get_billing_email(); ?></strong>
      </li>
    <?php endif; ?>
<?php } ?>
<?php if ($remove_total == "off") { ?>
    <li class="woocommerce-order-overview__total total">
      <?php _e( 'Total:', 'woocommerce' ); ?>
      <strong><?php echo $order->get_formatted_order_total(); ?></strong>
    </li>
<?php } ?>
<?php if ($remove_payment_method == "off") { ?>
    <?php if ( $order->get_payment_method_title() ) : ?>
      <li class="woocommerce-order-overview__payment-method method">
        <?php _e( 'Payment method:', 'woocommerce' ); ?>
        <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
      </li>
    <?php endif; ?>
<?php } ?>

  </ul>

  <?php


                $content = ob_get_clean();



                //////////////////////////////////////////////////////////////////////

                return $content;
                  }
              }

            new db_woo_thankyou_overview;

?>
