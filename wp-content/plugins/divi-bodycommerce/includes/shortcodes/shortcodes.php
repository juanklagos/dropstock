<?php
/**
 * Attributes shortcode callback.
 */
function bodycommerce_attricutes_shortcode( $atts ) {
    global $product;
    if( ! is_object( $product ) || ! $product->has_attributes() ){
        return;
    }
    // parse the shortcode attributes
    $args = shortcode_atts( array(
        'attributes' => array_keys( $product->get_attributes() ), // by default show all attributes
    ), $atts );
    // is pass an attributes param, turn into array
    if( is_string( $args['attributes'] ) ){
        $args['attributes'] = array_map( 'trim', explode( ',' , $args['attributes'] ) );
    }
    // start with a null string because shortcodes need to return not echo a value
    $html = '';
    if( ! empty( $args['attributes'] ) ){
        foreach ( $args['attributes'] as $attribute ) {
            // get the WC-standard attribute taxonomy name
            $taxonomy = strpos( $attribute, 'pa_' ) === false ? wc_attribute_taxonomy_name( $attribute ) : $attribute;
            if( taxonomy_is_product_attribute( $taxonomy ) ){
                // Get the attribute label.
                $attribute_label = wc_attribute_label( $taxonomy );
                $html .= get_the_term_list( $product->get_id(), $taxonomy, '<span class="term-prefix">' , ', ', '</span>' );
            }
        }
        // if we have anything to display, wrap it in a <ul> for proper markup
        // OR: delete these lines if you only wish to return the <li> elements
        if( $html ){
            $html = '<span class="db_attribute_term_list">' . strip_tags ( $html ) . '</span>';
        }
    }

    return $html;
}
add_shortcode( 'bc_display_attributes', 'bodycommerce_attricutes_shortcode' );


/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/

// Do module shortcode

function use_divi_layout_builder_shortcode_id($moduleid) {
    extract(shortcode_atts(array('id' =>'*'),$moduleid));
    return do_shortcode('[et_pb_section global_module="'.$id.'"][/et_pb_section]');
}
add_shortcode('showmodule', 'use_divi_layout_builder_shortcode_id');


/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/

// orders get
function shortcode_db_woo_orders( $atts ) {
    extract( shortcode_atts( array(
        'order_count' => -1
    ), $atts ) );

    $args = [
    'author' => 'id',
    'post_status' => 'any',
    'post_type' => 'shop_order'
];

$query = new WP_Query($args);
$orderCountByCustomer = $query->found_posts;

    ob_start();
		$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
			'numberposts' => $order_count,
			'meta_key'    => '_customer_user',
			'meta_value'  => get_current_user_id(),
			'post_type'   => wc_get_order_types( 'view-orders' ),
			'post_status' => array_keys( wc_get_order_statuses() ),
		) ) );

		if ( ! $customer_orders ) {
  $aUrl = get_permalink( wc_get_page_id( 'shop' ) );
?>
<div class="clearfix"></div>

<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
		<a class="woocommerce-Button button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php esc_html_e( 'Browse products', 'woocommerce' ); ?>
		</a>
		<?php esc_html_e( 'No order has been made yet.', 'woocommerce' ); ?>
	</div>
<?php
}
else {
    wc_get_template( 'myaccount/my-orders.php', array(
        'current_user'  => get_user_by( 'id', get_current_user_id() ),
        'order_count'   => $order_count
    ) );
  }
    return ob_get_clean();
}
add_shortcode('db_woo_orders', 'shortcode_db_woo_orders');


/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/

// orders get
function db_woo_get_payment_methods( $atts ) {
ob_start();

$saved_methods = wc_get_customer_saved_methods_list( get_current_user_id() );
$has_methods   = (bool) $saved_methods;
$types         = wc_get_account_payment_methods_types();

do_action( 'woocommerce_before_account_payment_methods', $has_methods ); ?>

<?php if ( $has_methods ) : ?>

	<table class="woocommerce-MyAccount-paymentMethods shop_table shop_table_responsive account-payment-methods-table">
		<thead>
			<tr>
				<?php foreach ( wc_get_account_payment_methods_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $column_id ); ?> payment-method-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<?php foreach ( $saved_methods as $type => $methods ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited ?>
			<?php foreach ( $methods as $method ) : ?>
				<tr class="payment-method<?php echo ! empty( $method['is_default'] ) ? ' default-payment-method' : ''; ?>">
					<?php foreach ( wc_get_account_payment_methods_columns() as $column_id => $column_name ) : ?>
						<td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $column_id ); ?> payment-method-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php
							if ( has_action( 'woocommerce_account_payment_methods_column_' . $column_id ) ) {
								do_action( 'woocommerce_account_payment_methods_column_' . $column_id, $method );
							} elseif ( 'method' === $column_id ) {
								if ( ! empty( $method['method']['last4'] ) ) {
									/* translators: 1: credit card type 2: last 4 digits */
									echo sprintf( esc_html__( '%1$s ending in %2$s', 'woocommerce' ), esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) ), esc_html( $method['method']['last4'] ) );
								} else {
									echo esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) );
								}
							} elseif ( 'expires' === $column_id ) {
								echo esc_html( $method['expires'] );
							} elseif ( 'actions' === $column_id ) {
								foreach ( $method['actions'] as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
									echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>&nbsp;';
								}
							}
							?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</table>

<?php else : ?>

	<p class="woocommerce-Message woocommerce-Message--info woocommerce-info"><?php esc_html_e( 'No saved methods found.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_payment_methods', $has_methods ); ?>

<?php if ( WC()->payment_gateways->get_available_payment_gateways() ) : ?>
	<a class="button" href="<?php echo esc_url( wc_get_endpoint_url( 'add-payment-method' ) ); ?>"><?php esc_html_e( 'Add payment method', 'woocommerce' ); ?></a>
<?php endif;

return ob_get_clean();
}
add_shortcode( 'db_woo_get_payment_methods', 'db_woo_get_payment_methods' );

// orders get
function db_woo_get_payment_methods_add( $atts ) {
ob_start();



return ob_get_clean();
}
add_shortcode( 'db_woo_get_payment_methods_add', 'db_woo_get_payment_methods_add' );

// get Name
function db_woo_get_name( $atts ){
ob_start();
$user_info = get_userdata(get_current_user_id());
		$first_name = $user_info->first_name;
		$last_name = $user_info->last_name;
    $display_name = $user_info->display_name;
		echo " " .$display_name;
return ob_get_clean();
}
add_shortcode( 'db_woo_get_name', 'db_woo_get_name' );


/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/

// PRODUCT REVIEWS MODULE
function bodycommerce_reviews( $atts ){
ob_start();
comments_template();
return ob_get_clean();
}
add_shortcode( 'bodycommerce_reviews', 'bodycommerce_reviews' );


/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/

// CART ICON
function bodycommerce_cart_icon( $atts ){
ob_start();
et_show_cart_total();
return ob_get_clean();
}
add_shortcode( 'bodycommerce_cart_icon', 'bodycommerce_cart_icon' );

/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/

// SINGLE RATINGS
function bodycommerce_single_rating_stars( $atts ){
ob_start();
woocommerce_template_single_rating();
return ob_get_clean();
}
add_shortcode( 'bodycommerce_single_rating_stars', 'bodycommerce_single_rating_stars' );

/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/

// CATEGORY RATINGS
function bodycommerce_category_rating_stars( $atts ){
ob_start();
woocommerce_template_loop_rating();
return ob_get_clean();
}
add_shortcode( 'bodycommerce_category_rating_stars', 'bodycommerce_category_rating_stars' );

/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/

// CATEGORY RATINGS
function bodycommerce_description( $atts ){
ob_start();
the_content();
return ob_get_clean();
}
add_shortcode( 'bodycommerce_description', 'bodycommerce_description' );

/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/
/************************************************************************************************************************/


 ?>
