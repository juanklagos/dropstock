<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_cart_products extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.CP Cart Products - Cart Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_cart_products';

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
                              'table_text' => array(
                                  'label' => esc_html__('Table', 'et_builder'),
                                  'css' => array(
                                      'main' => ".woocommerce {$this->main_css_element} table td, .woocommerce {$this->main_css_element} table td a",
                                  ),
                                  'font_size' => array('default' => '14px'),
                                  'line_height' => array('default' => '1.4em'),
                              ),
                                  'table_header' => array(
                                      'label' => esc_html__('Table Header', 'et_builder'),
                                      'css' => array(
                                          'main' => ".woocommerce {$this->main_css_element} table.shop_table th",
                              						'important' => 'all',
                                      ),
                                      'font_size' => array('default' => '14px'),
                                      'line_height' => array('default' => '1.4em'),
                                  ),

                          ),
			'borders'    => array(

  'default' => array(
    'css' => array(
      'main' => array(
        'border_radii'  => ".woocommerce %%order_class%% table.shop_table",
        'border_styles' => ".woocommerce %%order_class%% table.shop_table",
      ),
    ),
  ),
			),
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main'    => '%%order_class%% table.shop_table',
						'overlay' => 'inset',
					),
				),
				'image'   => array(
					'label'           => esc_html__( 'Logo Box Shadow', 'et_builder' ),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'image_settings',
					'css'             => array(
						'main'    => '%%order_class%% .et_pb_menu__logo-wrap .et_pb_menu__logo',
						'overlay' => 'inset',
					),
				),
			),
                          'button' => array(
                              'button' => array(
                                  'label' => esc_html__('Button', 'et_builder'),
                                  'css' => array(
                                      'main' => $this->main_css_element . ' .button',
                                      'plugin_main' => "{$this->main_css_element}.et_pb_module",
                                  ),
                                  'box_shadow'  => array(
                                    'css' => array(
                                      'main' => $this->main_css_element . ' .button',
                                          'important' => 'all',
                                    ),
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

			'form_field'           => array(
				'form_field' => array(
					'label'         => esc_html__( 'Coupon Field', 'et_builder' ),
					'css'           => array(
						'main'                   => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text',
						'background_color'       => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text',
						'background_color_hover' => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text:hover',
						'focus_background_color' => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text:focus',
						'focus_background_color_hover' => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text:focus:hover',
						'placeholder_focus'      => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text:focus::-webkit-input-placeholder',
						'padding'                => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text',
						'margin'                 => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text',
						'form_text_color'        => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text',
						'form_text_color_hover'  => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text:hover',
						'focus_text_color'       => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text:focus',
						'focus_text_color_hover' => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text:focus:hover',
						'important'         => array(
              'main',
              'background_color',
              'background_color_hover',
              'focus_background_color',
              'focus_background_color_hover',
              'placeholder_focus',
              'padding',
              'margin',
              'form_text_color',
              'form_text_color_hover',
              'focus_text_color',
              'focus_text_color_hover'
             ),
					),
					'box_shadow'    => false,
					'border_styles' => false,
					'font_field'    => array(
						'css' => array(
							'main'  => implode( ', ', array(
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text::placeholder",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text::-webkit-input-placeholder",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text::-moz-placeholder",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text:-ms-input-placeholder",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text[type=checkbox] + label",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text[type=radio] + label",
							) ),
							'hover' => array(
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text:hover",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text:hover::placeholder",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text:hover::-webkit-input-placeholder",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text:hover::-moz-placeholder",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text:hover:-ms-input-placeholder",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text[type=checkbox]:hover + label",
								"{$this->main_css_element} .woocommerce-cart-form table.cart td.actions .coupon .input-text[type=radio]:hover + label",
							),
						),
					),
					'margin_padding' => array(
						'css'        => array(
							'main'    => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text',
							'padding' => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text',
							'margin'  => '%%order_class%% .woocommerce-cart-form table.cart td.actions .coupon .input-text',
						),
					),
				),
			),
                      );

                  }

                  function get_fields() {
    		$fields = array(
          'remove_thumbs' => array(
              'label' => esc_html__('Remove Product Image?', 'divi-bodyshop-woocommerce'),
              'type' => 'yes_no_button',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                  'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
              ),
              'affects' => array(
                  'image_size'
              ),
              'description' => 'Should the product image field be removed from the table?',
          ),
          'image_size' => array(
              'label' => esc_html__('Image Size', 'divi-bodyshop-woocommerce'),
              'type' => 'select',
              'option_category' => 'configuration',
              'options' => array(
                  'original' => esc_html__('-- Default --', 'divi-bodyshop-woocommerce'),
                  'small' => esc_html__('Small', 'divi-bodyshop-woocommerce'),
                  'medium' => esc_html__('Medium', 'divi-bodyshop-woocommerce'),
                  'large' => esc_html__('large', 'divi-bodyshop-woocommerce'),
              ),
              'depends_show_if' => 'off',
              'toggle_slug' => 'main_settings',
              'description' => esc_html__('Set the size of the image in the cart.', 'divi-bodyshop-woocommerce'),
          ),
          'remove_link' => array(
              'label' => esc_html__('Remove Product Links?', 'divi-bodyshop-woocommerce'),
              'type' => 'yes_no_button',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                  'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
              ),
              'description' => 'Should the product links be removed from the product name field?',
          ),
          'remove_coupon' => array(
              'label' => esc_html__('Remove Coupon Form?', 'divi-bodyshop-woocommerce'),
              'type' => 'yes_no_button',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                  'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
              ),
              'description' => 'Should the coupon form be removed from the table?',
          ),
          'remove_borders' => array(
              'label' => esc_html__('Remove Borders?', 'divi-bodyshop-woocommerce'),
              'type' => 'yes_no_button',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                  'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
              ),
              'description' => 'Should the borders on the table be removed?',
          ),
          'remove_update_button' => array(
              'label' => esc_html__('Remove Update Cart Button?', 'divi-bodyshop-woocommerce'),
              'type' => 'yes_no_button',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                  'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
              ),
              'description' => 'Remove the update cart button?',
          ),
          'quanity_alignment' => array(
              'label' => esc_html__('Quantity Alignment', 'divi-bodyshop-woocommerce'),
              'type' => 'select',
              'toggle_slug' => 'main_settings',
              'options' => array(
                  'left' => esc_html__('Left', 'divi-bodyshop-woocommerce'),
                  'right' => esc_html__('Right', 'divi-bodyshop-woocommerce'),
              ),
              'default' => 'left',
          ),
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__getcartproducts' => array(
            'type' => 'computed',
            'computed_callback' => array( 'db_woo_cart_products', 'get_cart_products' ),
            'computed_depends_on' => array(
              'admin_label'
            ),
          ),
    		);

    		return $fields;
    	}

      public static function get_cart_products( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}


        ob_start();
        $data = '';

        ?>

        <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
      <?php do_action( 'woocommerce_before_cart_table' ); ?>

      <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <thead>
          <tr>
            <th class="product-remove">&nbsp;</th>
            <th class="product-thumbnail">&nbsp;</th>
            <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
            <th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
            <th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
            <th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php do_action( 'woocommerce_before_cart_contents' ); ?>

          <?php
          foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
              $product_url =  get_permalink( $product_id );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
              $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
              ?>
              <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                <td class="product-remove">
                  <?php
                    // @codingStandardsIgnoreLine
                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                      '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                      esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                      __( 'Remove this item', 'woocommerce' ),
                      esc_attr( $product_id ),
                      esc_attr( $_product->get_sku() )
                    ), $cart_item_key );
                  ?>
                </td>

                <td class="product-thumbnail">

                <a href="<?php echo $product_url ?>">

                <?php
                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                if ( ! $product_permalink ) {
                  echo wp_kses_post( $thumbnail );
                } else {
                  printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
                }
                ?>

              </a>
                </td>

                <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">

                <a href="<?php echo $product_url ?>">

                <?php
                if ( ! $product_permalink ) {
                  echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                } else {
                  echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                }

                // Meta data.
                echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                // Backorder notification.
                if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                  echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>' ) );
                }
                ?>
              </a>
                </td>

                <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                  <?php
                    echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                  ?>
                </td>

                <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                <?php
                if ( $_product->is_sold_individually() ) {
                  $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                } else {
                  $product_quantity = woocommerce_quantity_input( array(
                    'input_name'   => "cart[{$cart_item_key}][qty]",
                    'input_value'  => $cart_item['quantity'],
                    'max_value'    => $_product->get_max_purchase_quantity(),
                    'min_value'    => '0',
                    'product_name' => $_product->get_name(),
                  ), $_product, false );
                }

                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                ?>
                </td>

                <td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
                  <?php
                    echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                  ?>
                </td>
              </tr>
              <?php
            }
          }
          ?>

          <?php do_action( 'woocommerce_cart_contents' ); ?>

          <tr>
            <td colspan="6" class="actions">

              <?php if ( wc_coupons_enabled() ) { ?>
                <?php if (wc_coupons_enabled() ) { ?>
                <div class="coupon">
                  <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
                  <?php do_action( 'woocommerce_cart_coupon' ); ?>
                </div>
              <?php } ?>
              <?php } ?>
              <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

              <?php do_action( 'woocommerce_cart_actions' ); ?>

              <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            </td>
          </tr>

          <?php do_action( 'woocommerce_after_cart_contents' ); ?>
        </tbody>
      </table>
      <?php do_action( 'woocommerce_after_cart_table' ); ?>
    </form>

    <?php

    $data = ob_get_clean();

        return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {

                    $remove_thumbs = $this->props['remove_thumbs'];
                    $remove_link = $this->props['remove_link'];
                    $remove_coupon = $this->props['remove_coupon'];
                    $remove_borders = $this->props['remove_borders'];
                    $image_size = $this->props['image_size'];
                    $remove_update_button = $this->props['remove_update_button'];


                    $custom_button  			= $this->props['custom_button'];
                    $button_use_icon  			= $this->props['button_use_icon'];
                    $button_icon 				= $this->props['button_icon'];
                    $button_icon_placement 		= $this->props['button_icon_placement'];
                    $button_bg_color       		= $this->props['button_bg_color'];
                    $quanity_alignment      		= $this->props['quanity_alignment'];

                    $custom_button_vb = DEBC_INIT::et_icon_css_content( esc_attr($button_icon) );


                    if ( $quanity_alignment != '' ) {
                      $this->add_classname('align-' . $quanity_alignment );
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
                    }

                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();


                    if ($remove_link == 'on') {
                        add_filter('woocommerce_cart_item_permalink', '__return_false', 99, 99);
                    }

                    $output = '';

                    ?>

                    <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                  <?php do_action( 'woocommerce_before_cart_table' ); ?>

                  <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                    <thead>
                      <tr>
                        <th class="product-remove">&nbsp;</th>
                        <?php if ($remove_thumbs != 'on') { ?>
                        <th class="product-thumbnail">&nbsp;</th>
                      <?php } ?>
                        <th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
                        <th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
                        <th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
                        <th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                      <?php
                      foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                          $product_url =  get_permalink( $product_id );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                          $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                          ?>
                          <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                            <td class="product-remove">
                              <?php
                                // @codingStandardsIgnoreLine
                                echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                  '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                  esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                  __( 'Remove this item', 'woocommerce' ),
                                  esc_attr( $product_id ),
                                  esc_attr( $_product->get_sku() )
                                ), $cart_item_key );
                              ?>
                            </td>
                <?php if ($remove_thumbs != 'on') {
                  ?>
                            <td class="product-thumbnail">
                              <?php if ($remove_link == "off") { ?>
                            <a href="<?php echo $product_url ?>">
                            <?php } ?>
                            <?php
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                            if ( ! $product_permalink ) {
                              echo wp_kses_post( $thumbnail );
                            } else {
                              printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
                            }
                            ?>
                              <?php if ($remove_link == "off") { ?>
                          </a>
                          <?php } ?>
                            </td>
                <?php } ?>
                            <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                              <?php if ($remove_link == "off") { ?>
                            <a href="<?php echo $product_url ?>">
                            <?php } ?>
                            <?php
                            if ( ! $product_permalink ) {
                              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                            } else {
                              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                            }

                            // Meta data.
                            echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                            // Backorder notification.
                            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>' ) );
                            }
                            ?>
                              <?php if ($remove_link == "off") { ?>
                          </a>
                          <?php } ?>
                            </td>

                            <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                              <?php
                                echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                              ?>
                            </td>

                            <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                            <?php
                            if ( $_product->is_sold_individually() ) {
                              $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                            } else {
                              $product_quantity = woocommerce_quantity_input( array(
                                'input_name'   => "cart[{$cart_item_key}][qty]",
                                'input_value'  => $cart_item['quantity'],
                                'max_value'    => $_product->get_max_purchase_quantity(),
                                'min_value'    => '0',
                                'product_name' => $_product->get_name(),
                              ), $_product, false );
                            }

                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                            ?>
                            </td>

                            <td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
                              <?php
                                echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                              ?>
                            </td>
                          </tr>
                          <?php
                        }
                      }
                      ?>

                      <?php do_action( 'woocommerce_cart_contents' ); ?>

                      <tr>
                        <td colspan="6" class="actions">

                          <?php if ( wc_coupons_enabled() ) { ?>
                            <?php if (wc_coupons_enabled() && $remove_coupon != 'on') { ?>
                            <div class="coupon">
                              <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
                              <?php do_action( 'woocommerce_cart_coupon' ); ?>
                            </div>
                          <?php } ?>
                          <?php } ?>
                          <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

                          <?php do_action( 'woocommerce_cart_actions' ); ?>

                          <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                        </td>
                      </tr>

                      <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                    </tbody>
                  </table>
                  <?php do_action( 'woocommerce_after_cart_table' ); ?>
                </form>

                <?php

                $content = ob_get_clean();

                if( $remove_borders == 'on' ){
                  $this->add_classname( 'no-borders' );
                }

                if( $remove_update_button == 'on' ){
                  $this->add_classname( 'no-update-cart-button' );
                }


                if ($remove_thumbs == 'off') {
                  $this->add_classname( 'image_size_' . $image_size . '' );
                }

                //////////////////////////////////////////////////////////////////////

                return $content;
                  }
              }

            new db_woo_cart_products;

?>
