<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_thankyou_details extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.TP Order Details - Thank You', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_thankyou_details';

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
                              'title_text' => array(
                                  'label' => esc_html__('Title', 'et_builder'),
                                  'css' => array(
                                      'main' => ".woocommerce {$this->main_css_element} h2",
                                  ),
                              ),
                              'table_head' => array(
                                  'label' => esc_html__('Table Head', 'et_builder'),
                                  'css' => array(
                                      'main' => ".woocommerce {$this->main_css_element} table.shop_table thead th",
                                  ),
                              ),
                                  'products' => array(
                                      'label' => esc_html__('Product Name & Quantity', 'et_builder'),
                                      'css' => array(
                                          'main' => ".woocommerce {$this->main_css_element} table.shop_table td.product-name a, .woocommerce {$this->main_css_element} table.shop_table td.product-name",
                                      ),
                                  ),
                                      'product_total' => array(
                                          'label' => esc_html__('Product Total', 'et_builder'),
                                          'css' => array(
                                              'main' => ".woocommerce {$this->main_css_element} table.shop_table td.product-total .amount",
                                          ),
                                      ),
                                          'total_title' => array(
                                              'label' => esc_html__('Order Total Title', 'et_builder'),
                                              'css' => array(
                                                  'main' => ".woocommerce {$this->main_css_element} table.shop_table tfoot th",
                                              ),
                                          ),
                                              'total_value' => array(
                                                  'label' => esc_html__('Order Total Value', 'et_builder'),
                                                  'css' => array(
                                                      'main' => ".woocommerce {$this->main_css_element} table.shop_table tfoot td",
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
            '__getthankyoudetails' => array(
              'type' => 'computed',
              'computed_callback' => array( 'db_woo_thankyou_details', 'get_thankyou_details' ),
              'computed_depends_on' => array(
                'admin_label'
              ),
            ),
    		);

    		return $fields;
    	}


      public static function get_thankyou_details( $args = array(), $conditional_tags = array(), $current_page = array() ){

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


        $order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
        $show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
        $show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
        $downloads             = $order->get_downloadable_items();
        $show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

        if ( $show_downloads ) {
        	wc_get_template( 'order/order-downloads.php', array( 'downloads' => $downloads, 'show_title' => true ) );
        }
        ?>
        <section class="woocommerce-order-details">
        	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>


        	<h2 class="woocommerce-order-details__title"><?php _e( 'Order details', 'woocommerce' ); ?></h2>


        	<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

        		<thead>
        			<tr>
        				<th class="woocommerce-table__product-name product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
        				<th class="woocommerce-table__product-table product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
        			</tr>
        		</thead>

        		<tbody>
        			<?php
        			do_action( 'woocommerce_order_details_before_order_table_items', $order );

        			foreach ( $order_items as $item_id => $item ) {
        				$product = $item->get_product();

        				wc_get_template( 'order/order-details-item.php', array(
        					'order'			     => $order,
        					'item_id'		     => $item_id,
        					'item'			     => $item,
        					'show_purchase_note' => $show_purchase_note,
        					'purchase_note'	     => $product ? $product->get_purchase_note() : '',
        					'product'	         => $product,
        				) );
        			}

        			do_action( 'woocommerce_order_details_after_order_table_items', $order );
        			?>
        		</tbody>

        		<tfoot>
        			<?php
        				foreach ( $order->get_order_item_totals() as $key => $total ) {
        					?>
        					<tr>
        						<th scope="row"><?php echo $total['label']; ?></th>
        						<td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : $total['value']; ?></td>
        					</tr>
        					<?php
        				}
        			?>
        			<?php if ( $order->get_customer_note() ) : ?>
        				<tr>
        					<th><?php _e( 'Note:', 'woocommerce' ); ?></th>
        					<td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
        				</tr>
        			<?php endif; ?>
        		</tfoot>
        	</table>

        	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
        </section>

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

                    $remove_borders = $this->props['remove_borders'];
                    $remove_title = $this->props['remove_title'];


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

do_action( 'woocommerce_before_thankyou', $order->get_id() );

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

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template( 'order/order-downloads.php', array( 'downloads' => $downloads, 'show_title' => true ) );
}
?>
<section class="woocommerce-order-details">
	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

<?php if ($remove_title == "off") { ?>
	<h2 class="woocommerce-order-details__title"><?php _e( 'Order details', 'woocommerce' ); ?></h2>
<?php } ?>

	<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">

		<thead>
			<tr>
				<th class="woocommerce-table__product-name product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
				<th class="woocommerce-table__product-table product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php
			do_action( 'woocommerce_order_details_before_order_table_items', $order );

			foreach ( $order_items as $item_id => $item ) {
				$product = $item->get_product();

				wc_get_template( 'order/order-details-item.php', array(
					'order'			     => $order,
					'item_id'		     => $item_id,
					'item'			     => $item,
					'show_purchase_note' => $show_purchase_note,
					'purchase_note'	     => $product ? $product->get_purchase_note() : '',
					'product'	         => $product,
				) );
			}

			do_action( 'woocommerce_order_details_after_order_table_items', $order );
			?>
		</tbody>

		<tfoot>
			<?php
				foreach ( $order->get_order_item_totals() as $key => $total ) {
					?>
					<tr>
						<th scope="row"><?php echo $total['label']; ?></th>
						<td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : $total['value']; ?></td>
					</tr>
					<?php
				}
			?>
			<?php if ( $order->get_customer_note() ) : ?>
				<tr>
					<th><?php _e( 'Note:', 'woocommerce' ); ?></th>
					<td><?php echo wptexturize( $order->get_customer_note() ); ?></td>
				</tr>
			<?php endif; ?>
		</tfoot>
	</table>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
</section>

<?php
                $content = ob_get_clean();

                if( $remove_borders == 'on' ){
                  $this->add_classname( 'no-borders' );
                }


                //////////////////////////////////////////////////////////////////////

                return $content;
                  }
              }

            new db_woo_thankyou_details;

?>
