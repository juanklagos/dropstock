<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_my_addresses_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP Addresses - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_woo_addresses';

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
                                                'label'    => esc_html__( 'Address Heading', 'divi-bodyshop-woocommerce' ),
                                                'css'      => array(
                                                        'main' => "{$this->main_css_element} .woocommerce-Address-title h3",
                                                ),
                                                'font_size' => array('default' => '24px'),
                                                'line_height'    => array('default' => '1.5em'),
                                ),
                                'address'   => array(
                                                  'label'    => esc_html__( 'Address', 'divi-bodyshop-woocommerce' ),
                                                  'css'      => array(
                                                          'main' => "{$this->main_css_element} address",
                                                  ),
                                                  'font_size' => array('default' => '24px'),
                                                  'line_height'    => array('default' => '1.5em'),
                                  ),
                                  'link'   => array(
                                                    'label'    => esc_html__( 'Edit Link', 'divi-bodyshop-woocommerce' ),
                                                    'css'      => array(
                                                            'main' => "{$this->main_css_element} .addresses .title a.edit",
                                                    ),
                                                    'font_size' => array('default' => '24px'),
                                                    'line_height'    => array('default' => '1.5em'),
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
                    //     'button' => array(
                    //   'button' => array(
                    //     'label' => esc_html__( 'Button', 'divi-bodyshop-woocommerce' ),
                    //     'css' => array(
                    //       'main' => "#acc-address .button",
                    //       'plugin_main' => "#acc-address .button",
                    //     ),
                    //     'box_shadow'  => array(
                    //       'css' => array(
                    //         'main' => "#acc-address .button",
                    //       ),
                    //     ),
                    //   ),
                    // ),
        		);

                  }




                  function get_fields() {
    		$fields = array(
        'hide_shipping' => array(
        'label'           => __( 'Hide Shipping Address?', 'divi-bodyshop-woocommerce' ),
        'type'            => 'yes_no_button',
        'toggle_slug'     => 'main_content',
        'options'         => array(
        'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
        'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
        ),
        ),
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__getaddresses' => array(
            'type' => 'computed',
            'computed_callback' => array( 'db_woo_my_addresses_code', 'get_acc_addresses' ),
            'computed_depends_on' => array(
              'admin_label'
            ),
          ),

    		);

    		return $fields;
    	}


      public static function get_acc_addresses( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}


                            ob_start();
        global $woocommerce;
        $customer_id = get_current_user_id();

        if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
          $get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
            'billing' => __( 'Billing address', 'woocommerce' ),
            'shipping' => __( 'Shipping address', 'woocommerce' ),
          ), $customer_id );
        } else {
          $get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
            'billing' => __( 'Billing address', 'woocommerce' ),
          ), $customer_id );
        }

        $oldcol = 1;
        $col    = 1;
        ?>
        <p>
          <?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
        </p>

        <?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>

          <div class="u-columns woocommerce-Addresses col2-set addresses">
        <?php endif; ?>

        <?php foreach ( $get_addresses as $name => $title ) : ?>

          <div class="u-column<?php echo ( ( $col = $col * -1 ) < 0 ) ? 1 : 2; ?> col-<?php echo ( ( $oldcol = $oldcol * -1 ) < 0 ) ? 1 : 2; ?> woocommerce-Address <?php echo $name; ?>">
            <header class="woocommerce-Address-title title">
              <h3><?php echo $title; ?></h3>
              <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php _e( 'Edit', 'woocommerce' ); ?></a>
            </header>
            <address>
              <?php
                $address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
                  'first_name'  => get_user_meta( $customer_id, $name . '_first_name', true ),
                  'last_name'   => get_user_meta( $customer_id, $name . '_last_name', true ),
                  'company'     => get_user_meta( $customer_id, $name . '_company', true ),
                  'address_1'   => get_user_meta( $customer_id, $name . '_address_1', true ),
                  'address_2'   => get_user_meta( $customer_id, $name . '_address_2', true ),
                  'city'        => get_user_meta( $customer_id, $name . '_city', true ),
                  'state'       => get_user_meta( $customer_id, $name . '_state', true ),
                  'postcode'    => get_user_meta( $customer_id, $name . '_postcode', true ),
                  'country'     => get_user_meta( $customer_id, $name . '_country', true ),
                ), $customer_id, $name );

                $formatted_address = WC()->countries->get_formatted_address( $address );

                if ( ! $formatted_address ) {
                  _e( 'You have not set up this type of address yet.', 'woocommerce' );
                } else {
                  echo $formatted_address;
                }
              ?>
            </address>
          </div>

        <?php endforeach; ?>

        <?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
          </div>
        <?php endif;
      $data = ob_get_clean();

      //////////////////////////////////////////////////////////////////////

      return $data;


      }


                  function render( $attrs, $content = null, $render_slug ) {

                    if (is_admin()) {
                        return;
                    }


                    $hide_shipping  			= $this->props['hide_shipping'];

                    if( $hide_shipping == 'on' ){
                			$this->add_classname( 'hide-shipping' );
                		}

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                  ob_start();

                      global $woocommerce;
                      $customer_id = get_current_user_id();

                      if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
                      	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
                      		'billing' => __( 'Billing address', 'woocommerce' ),
                      		'shipping' => __( 'Shipping address', 'woocommerce' ),
                      	), $customer_id );
                      } else {
                      	$get_addresses = apply_filters( 'woocommerce_my_account_get_addresses', array(
                      		'billing' => __( 'Billing address', 'woocommerce' ),
                      	), $customer_id );
                      }

                      $oldcol = 1;
                      $col    = 1;
                      ?>
                      <p>
                      	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', __( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); ?>
                      </p>

                      <?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>

                      	<div class="u-columns woocommerce-Addresses col2-set addresses">
                      <?php endif; ?>

                      <?php foreach ( $get_addresses as $name => $title ) : ?>

                      	<div class="u-column<?php echo ( ( $col = $col * -1 ) < 0 ) ? 1 : 2; ?> col-<?php echo ( ( $oldcol = $oldcol * -1 ) < 0 ) ? 1 : 2; ?> woocommerce-Address <?php echo $name; ?>">
                      		<header class="woocommerce-Address-title title">
                      			<h3><?php echo $title; ?></h3>
                      			<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php _e( 'Edit', 'woocommerce' ); ?></a>
                      		</header>
                      		<address>
                      			<?php
                      				$address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
                      					'first_name'  => get_user_meta( $customer_id, $name . '_first_name', true ),
                      					'last_name'   => get_user_meta( $customer_id, $name . '_last_name', true ),
                      					'company'     => get_user_meta( $customer_id, $name . '_company', true ),
                      					'address_1'   => get_user_meta( $customer_id, $name . '_address_1', true ),
                      					'address_2'   => get_user_meta( $customer_id, $name . '_address_2', true ),
                      					'city'        => get_user_meta( $customer_id, $name . '_city', true ),
                      					'state'       => get_user_meta( $customer_id, $name . '_state', true ),
                      					'postcode'    => get_user_meta( $customer_id, $name . '_postcode', true ),
                      					'country'     => get_user_meta( $customer_id, $name . '_country', true ),
                      				), $customer_id, $name );

                      				$formatted_address = WC()->countries->get_formatted_address( $address );

                      				if ( ! $formatted_address ) {
                      					_e( 'You have not set up this type of address yet.', 'woocommerce' );
                      				} else {
                      					echo $formatted_address;
                      				}
                      			?>
                      		</address>
                      	</div>

                      <?php endforeach; ?>

                      <?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
                      	</div>
                      <?php endif;
                  $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_woo_my_addresses_code;

?>
