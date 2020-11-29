<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_view_order_code extends ET_Builder_Module {



public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP View Order - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_woo_view_order';

		$this->fields_defaults = array(
		);

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
        					'highlights' => esc_html__( 'Highlights', 'divi-bodyshop-woocommerce' ),
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

                              'table_title'   => array(
                                                    'label'    => esc_html__( 'Table Titles', 'divi-bodyshop-woocommerce' ),
                                                    'css'      => array(
                                                            'main' => "{$this->main_css_element} thead .product-name, {$this->main_css_element} thead .product-total",
                                                    ),
                                    ),
                                      'product_title'   => array(
                                                            'label'    => esc_html__( 'Product Titles', 'divi-bodyshop-woocommerce' ),
                                                            'css'      => array(
                                                                    'main' => "{$this->main_css_element} .product-name, {$this->main_css_element} .product-name a",
                                                            ),
                                            ),
                                              'product_total'   => array(
                                                                    'label'    => esc_html__( 'Product Totals', 'divi-bodyshop-woocommerce' ),
                                                                    'css'      => array(
                                                                            'main' => "{$this->main_css_element} .product-total",
                                                                    ),
                                                    ),
                                                      'product_quantity'   => array(
                                                                            'label'    => esc_html__( 'Product Quantity', 'divi-bodyshop-woocommerce' ),
                                                                            'css'      => array(
                                                                                    'main' => "{$this->main_css_element} .product-quantity",
                                                                            ),
                                                            ),
                                                              'table_footer_title'   => array(
                                                                                    'label'    => esc_html__( 'Table Footer Titles (subtotal, shipping and total)', 'divi-bodyshop-woocommerce' ),
                                                                                    'css'      => array(
                                                                                            'main' => "{$this->main_css_element} tfoot tr th",
                                                                                    ),
                                                                    ),
                                                                      'table_footer_total'   => array(
                                                                                            'label'    => esc_html__( 'Table Footer Totals', 'divi-bodyshop-woocommerce' ),
                                                                                            'css'      => array(
                                                                                                    'main' => "{$this->main_css_element} tfoot .amount, {$this->main_css_element} tfoot .woocommerce-shipping-methods, {$this->main_css_element} tfoot td",
                                                                                            ),
                                                                            ),
                                        'customer_details' => array(
                                            'label' => esc_html__('Customer Details', 'et_builder'),
                                            'css' => array(
                                                'main' => ".woocommerce {$this->main_css_element} .woocommerce-customer-details address",
                                            ),
                                        ),
                                            'number_text' => array(
                                                'label' => esc_html__('Customer Number', 'et_builder'),
                                                'css' => array(
                                                    'main' => ".woocommerce {$this->main_css_element} .woocommerce-customer-details .woocommerce-customer-details--phone",
                                                ),
                                            ),
                                                'email_text' => array(
                                                    'label' => esc_html__('Customer Email', 'et_builder'),
                                                    'css' => array(
                                                        'main' => ".woocommerce {$this->main_css_element} .woocommerce-customer-details .woocommerce-customer-details--email",
                                                    ),
                                                ),
                                                    'highlighted_text' => array(
                                                        'label' => esc_html__('Highlighted', 'et_builder'),
                                                        'css' => array(
                                                            'main' => ".woocommerce {$this->main_css_element} mark",
                                                        ),
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
  			'show_order_overview' => array(
  				'label' => esc_html__( 'Show Order Overview', 'divi-bodyshop-woocommerce' ),
  				'type' => 'yes_no_button',
  				'options' => array(
  					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
  					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
  				),
  				'default' => 'on',
  			),
  			'show_order_notes' => array(
  				'label' => esc_html__( 'Show Order Notes', 'divi-bodyshop-woocommerce' ),
  				'type' => 'yes_no_button',
  				'options' => array(
  					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
  					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
  				),
  				'default' => 'on',
  			),
  			'show_order_details' => array(
  				'label' => esc_html__( 'Show Order Details', 'divi-bodyshop-woocommerce' ),
  				'type' => 'yes_no_button',
  				'options' => array(
  					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
  					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
  				),
  				'default' => 'on',
  			),
          'remove_borders' => array(
              'label' => esc_html__('Remove Borders?', 'divi-bodyshop-woocommerce'),
              'type' => 'yes_no_button',
              'options' => array(
                  'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                  'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
              ),
              'description' => 'Should the borders on the table be removed?',
          ),
            'highlight_color' => array(
              'label'             => esc_html__( 'Highlight Color', 'divi-bodyshop-woocommerce' ),
              'type'              => 'color-alpha',
              'custom_color'      => true,
              'toggle_slug'       => 'highlights',
              'default'           => '#ffff00',
            ),
            'remove_highlight' => array(
                'label' => esc_html__('Remove Highlights?', 'divi-bodyshop-woocommerce'),
                'type' => 'yes_no_button',
                'toggle_slug'       => 'highlights',
                'options' => array(
                    'off' => esc_html__('No', 'divi-bodyshop-woocommerce'),
                    'on' => esc_html__('Yes', 'divi-bodyshop-woocommerce'),
                ),
                'description' => 'If you want to remove the yellow highlights, enable this.',
            ),
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
            '__get_view_order' => array(
              'type' => 'computed',
              'computed_callback' => array( 'db_woo_view_order_code', 'get_view_order' ),
              'computed_depends_on' => array(
                'admin_label'
              ),
            ),
    		);

    		return $fields;
    	}

      public static function get_view_order( $args = array(), $conditional_tags = array(), $current_page = array() ){

        if (!is_admin()) {
    			return;
    		}

              ob_start();

      $data = '';

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



                //////////////////////////////////////////////////////////////////////

    $order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;

    $order = new WC_Order( $order_id );


      ?>
      <span id="show_order_overview">
      <p><?php
        /* translators: 1: order number 2: order date 3: order status */
        printf(
          __( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
          '<mark class="order-number">' . $order->get_order_number() . '</mark>',
          '<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
          '<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
        );
      ?></p></span>

<span id="show_order_notes">
      <?php if ( $notes = $order->get_customer_order_notes() ) : ?>
        <h2><?php _e( 'Order updates', 'woocommerce' ); ?></h2>
        <ol class="woocommerce-OrderUpdates commentlist notes">
          <?php foreach ( $notes as $note ) : ?>
          <li class="woocommerce-OrderUpdate comment note">
            <div class="woocommerce-OrderUpdate-inner comment_container">
              <div class="woocommerce-OrderUpdate-text comment-text">
                <p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
                <div class="woocommerce-OrderUpdate-description description">
                  <?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
                </div>
                  <div class="clear"></div>
                </div>
              <div class="clear"></div>
            </div>
          </li>
          <?php endforeach; ?>
        </ol>
      <?php endif;
      ?>

    </span>

  <span id="show_order_details">
      <?php do_action( 'woocommerce_view_order', $order_id );
?>
    </span>
<?php
    $data = ob_get_clean();


    //////////////////////////////////////////////////////////////////////

    $first = false;
} else {

}

}


    return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {

                  // $button_text = $this->props['button_text'];
$show_order_overview = $this->props['show_order_overview'];
$show_order_notes = $this->props['show_order_notes'];
$show_order_details = $this->props['show_order_details'];

$remove_borders = $this->props['remove_borders'];
$remove_highlight = $this->props['remove_highlight'];
$highlight_color = $this->props['highlight_color'];



if( $remove_borders == 'on' ){
  $this->add_classname( 'no-borders' );
}

if( $remove_highlight == 'on' ){
  $this->add_classname( 'no-highlights' );
}


                    if (is_admin()) {
                        return;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                  ob_start();

                  global $wp;

                  extract( shortcode_atts( array(
                      'order_count' => -1
                  ), $attrs ) );

                  $args = [
                  'author' => 'id',
                  'post_status' => 'any',
                  'post_type' => 'shop_order'
              ];

              $query = new WP_Query($args);

      $order_id = $wp->query_vars['view-order'];
      $order = new WC_Order( $order_id );

if ($show_order_overview == "off") {
}
else {
                  ?>
                  <p><?php
                  	/* translators: 1: order number 2: order date 3: order status */
                  	printf(
                  		__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
                  		'<mark class="order-number">' . $order->get_order_number() . '</mark>',
                  		'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>',
                  		'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>'
                  	);
                  ?></p>
<?php } ?>
<?php
if ($show_order_notes == "off") {
}
else {
 ?>
                  <?php if ( $notes = $order->get_customer_order_notes() ) : ?>
                  	<h2><?php _e( 'Order updates', 'woocommerce' ); ?></h2>
                  	<ol class="woocommerce-OrderUpdates commentlist notes">
                  		<?php foreach ( $notes as $note ) : ?>
                  		<li class="woocommerce-OrderUpdate comment note">
                  			<div class="woocommerce-OrderUpdate-inner comment_container">
                  				<div class="woocommerce-OrderUpdate-text comment-text">
                  					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); ?></p>
                  					<div class="woocommerce-OrderUpdate-description description">
                  						<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
                  					</div>
                  	  				<div class="clear"></div>
                  	  			</div>
                  				<div class="clear"></div>
                  			</div>
                  		</li>
                  		<?php endforeach; ?>
                  	</ol>
                  <?php endif; ?>
                <?php } ?>
                <?php
                if ($show_order_details == "off") {
                }
                else {
                 ?>
                  <?php do_action( 'woocommerce_view_order', $order_id );
                }


?>
<style>
.et_pb_db_woo_view_order mark {
   background-color: <?php echo $highlight_color ?>;
 }
</style>
<?php


                $data = ob_get_clean();

               //////////////////////////////////////////////////////////////////////

              return $data;
                  }
              }

            new db_woo_view_order_code;

?>
