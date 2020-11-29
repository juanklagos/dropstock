<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_add_payment_method_code extends ET_Builder_Module {



public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP Add Payment Method - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_woo_add_payment_method';

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
                          'main_heading'   => array(
                                            'label'    => esc_html__( 'Main Heading', 'divi-bodyshop-woocommerce' ),
                                            'css'      => array(
                                                    'main' => "{$this->main_css_element} h2",
                                            ),
                                            'font_size' => array('default' => '24px'),
                                            'line_height'    => array('default' => '1.5em'),
                            ),
                              'headings'   => array(
                                                'label'    => esc_html__( 'Table Heading', 'divi-bodyshop-woocommerce' ),
                                                'css'      => array(
                                                        'main' => "{$this->main_css_element} .nobr",
                                                ),
                                                'font_size' => array('default' => '24px'),
                                                'line_height'    => array('default' => '1.5em'),
                                ),
                                'paragraphs'   => array(
                                                  'label'    => esc_html__( 'Paragraph', 'divi-bodyshop-woocommerce' ),
                                                  'css'      => array(
                                                          'main' => "{$this->main_css_element} table.my_account_orders tr td",
                                                  ),
                                                  'font_size' => array('default' => '24px'),
                                                  'line_height'    => array('default' => '1.5em'),
                                  ),
                                  'link'   => array(
                                                    'label'    => esc_html__( 'Order ID Link', 'divi-bodyshop-woocommerce' ),
                                                    'css'      => array(
                                                            'main' => "{$this->main_css_element} .order-number a",
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
                        'button' => array(
                'button' => array(
                  'label' => esc_html__( 'Button', 'divi-bodyshop-woocommerce' ),
                  'css' => array(
                    'main' => "{$this->main_css_element} .button",
                    'important' => 'all',
                  ),
                  'box_shadow'  => array(
                    'css' => array(
                      'main' => ".woocommerce  {$this->main_css_element} .button",
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

    		);

    		return $fields;
    	}



                  function render( $attrs, $content = null, $render_slug ) {

                  // $button_text = $this->props['button_text'];

                    if (is_admin()) {
                        return;
                    }

                    $custom_button  			= $this->props['custom_button'];
                    $custom_icon          		= $this->props['button_icon'];
                    $button_bg_color       		= $this->props['button_bg_color'];
                    $button_use_icon  			= $this->props['button_use_icon'];
                    $button_icon 				= $this->props['button_icon'];
                    $button_icon_placement 		= $this->props['button_icon_placement'];


                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                  ob_start();

                  $available_gateways = WC()->payment_gateways->get_available_payment_gateways();

                  if ( $available_gateways ) : ?>
                  	<form id="add_payment_method" method="post">
                  		<div id="payment" class="woocommerce-Payment">
                  			<ul class="woocommerce-PaymentMethods payment_methods methods">
                  				<?php
                  				// Chosen Method.
                  				if ( count( $available_gateways ) ) {
                  					current( $available_gateways )->set_current();
                  				}

                  				foreach ( $available_gateways as $gateway ) {
                  					?>
                  					<li class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $gateway->id ); ?> payment_method_<?php echo esc_attr( $gateway->id ); ?>">
                  						<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> />
                  						<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>"><?php echo wp_kses_post( $gateway->get_title() ); ?> <?php echo wp_kses_post( $gateway->get_icon() ); ?></label>
                  						<?php
                  						if ( $gateway->has_fields() || $gateway->get_description() ) {
                  							echo '<div class="woocommerce-PaymentBox woocommerce-PaymentBox--' . esc_attr( $gateway->id ) . ' payment_box payment_method_' . esc_attr( $gateway->id ) . '" style="display: none;">';
                  							$gateway->payment_fields();
                  							echo '</div>';
                  						}
                  						?>
                  					</li>
                  					<?php
                  				}
                  				?>
                  			</ul>

                  			<div class="form-row">
                  				<?php wp_nonce_field( 'woocommerce-add-payment-method', 'woocommerce-add-payment-method-nonce' ); ?>
                  				<button type="submit" class="woocommerce-Button woocommerce-Button--alt button alt" id="place_order" value="<?php esc_attr_e( 'Add payment method', 'woocommerce' ); ?>"><?php esc_html_e( 'Add payment method', 'woocommerce' ); ?></button>
                  				<input type="hidden" name="woocommerce_add_payment_method" id="woocommerce_add_payment_method" value="1" />
                  			</div>
                  		</div>
                  	</form>
                  <?php else : ?>
                  	<p class="woocommerce-notice woocommerce-notice--info woocommerce-info"><?php esc_html_e( 'New payment methods can only be added during checkout. Please contact us if you require assistance.', 'woocommerce' ); ?></p>
                  <?php endif;

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



                  $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  //  $data = str_replace(
                  //   'class="button"',
                  //   'class="button"' . $custom_icon
                  //   , $data
                  // );

                  return $data;
                  }
              }

            new db_woo_add_payment_method_code;

?>
