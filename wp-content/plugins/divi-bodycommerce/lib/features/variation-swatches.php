<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$mydata = get_option( 'divi-bodyshop-woo_options' );
$mydata = unserialize($mydata);
if (isset($mydata['variation_striketrhough'][0])) {
$variation_striketrhough = $mydata['variation_striketrhough'][0];
}
else {
  $variation_striketrhough = "0";
}
if ($variation_striketrhough == 1) {
  if ( ! is_admin() ) {

    function wcbv_variation_is_active( $active, $variation ) {
     if( ! $variation->is_in_stock() ) {
     return false;
     }
     return $active;
    }
    add_filter( 'woocommerce_variation_is_active', 'wcbv_variation_is_active', 10, 2 );

add_filter( 'woocommerce_variation_option_name', 'customizing_variations_terms_name', 10, 1 );
function customizing_variations_terms_name( $term_name ){



    global $product;
    if( $product instanceof WC_Product && $product->is_type( 'variable' ) || $product instanceof WC_Product && $product->is_type( 'subscription-variation' ) ) {

    if(is_admin())
        return $term_name;

    $second_loop_stoped = false;


    $product_variations = $product->get_available_variations();


    foreach($product_variations as $variation){

        $variation_id = $variation['variation_id'];
        $variation_obj = new WC_Product_Variation( $variation_id );

        if ( version_compare( WC_VERSION, '3.0', '<' ) )
        {
            $stock_status = $variation_obj->stock_status;
            $stock_qty = intval($variation_obj->stock);

            $attributes_arr = $variation_obj->get_variation_attributes();
        }
        else
        {
            $stock_status = $variation_obj->get_stock_status();
            $stock_qty = $variation_obj->get_stock_quantity();

            $attributes_arr = $variation_obj->get_attributes();
        }

        if(count($attributes_arr) != 1)
            return $term_name;

        foreach( $attributes_arr as $attr_key => $term_slug){


            $term_key = str_replace('attribute_', '', $attr_key );
            if ($term_key != "") {
            $term_obj = get_term_by( 'slug', $term_slug, $term_key );
            if( $term_obj->name == $term_name ){
                $second_loop_stoped = true;
                break;
            }
          }


        }
        if($second_loop_stoped)
            break;
    }
    if( $stock_qty>0 )
        return $stock_status;
    else
        return $stock_status;


      } else {
      return $term_name;
      }

}


}
}


if ( ! function_exists( 'bodycommerce_is_ie11' ) ):
  function bodycommerce_is_ie11() {
    global $is_IE;

    if ( ! isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) ) {
      return false;
    }

    $ua   = $_SERVER[ 'HTTP_USER_AGENT' ];
    $is11 = preg_match( "/Trident\/7.0;(.*)rv:11.0/", $ua, $match ) !== false;

    return $is_IE && $is11;

  }
endif;



if ( ! function_exists( 'bodycommerce_get_all_image_sizes' ) ):
  function bodycommerce_get_all_image_sizes() {
    return apply_filters( 'bodycommerce_get_all_image_sizes', array_reduce( get_intermediate_image_sizes(), function ( $carry, $item ) {
      $carry[ $item ] = ucwords( str_ireplace( array( '-', '_' ), ' ', $item ) );

      return $carry;
    }, array() ) );
  }
endif;



if ( ! function_exists( 'bodycommerce_available_attributes_types' ) ):
  function bodycommerce_available_attributes_types( $type = false ) {
    $types = array();

    $types[ 'color' ] = array(
      'title'   => esc_html__( 'Color', 'divi-bodyshop-woocommerce' ),
      'output'  => 'bodycommerce_color_variation_attribute_options',
      'preview' => 'bodycommerce_color_variation_attribute_preview'
    );

    $types[ 'image' ] = array(
      'title'   => esc_html__( 'Image', 'divi-bodyshop-woocommerce' ),
      'output'  => 'bodycommerce_image_variation_attribute_options',
      'preview' => 'bodycommerce_image_variation_attribute_preview'
    );

    $types[ 'button' ] = array(
      'title'   => esc_html__( 'Label', 'divi-bodyshop-woocommerce' ),
      'output'  => 'bodycommerce_button_variation_attribute_options',
      'preview' => 'bodycommerce_button_variation_attribute_preview'
    );

    $types = apply_filters( 'bodycommerce_available_attributes_types', $types );

    if ( $type ) {
      return isset( $types[ $type ] ) ? $types[ $type ] : array();
    }

    return $types;
  }
endif;

if ( ! function_exists( 'bodycommerce_color_variation_attribute_preview' ) ):
  function bodycommerce_color_variation_attribute_preview( $term_id, $attribute, $fields ) {

    $key   = $fields[ 0 ][ 'id' ];
    $value = sanitize_hex_color( get_term_meta( $term_id, $key, TRUE ) );
    $color = get_term_meta( $term_id, 'product_attribute_color', TRUE );

    printf( '<div class="wvs-preview wvs-color-preview" style="width: 40px;height: 40px;background-color:%s;"></div>', esc_attr( $color ) );
  }
endif;


if ( ! function_exists( 'bodycommerce_image_variation_attribute_preview' ) ):
  function bodycommerce_image_variation_attribute_preview( $term_id, $attribute, $fields ) {

    $key           = $fields[ 0 ][ 'id' ];
    $attachment_id = absint( get_term_meta( $term_id, $key, TRUE ) );
    $image         = wp_get_attachment_image_url( $attachment_id );
   $image_url = get_term_meta( $term_id, 'product_attribute_image', TRUE );

    printf( '<img src="%s" class="wvs-preview wvs-image-preview" style="width: 40px;"/>', esc_attr( $image_url ) );
  }
endif;


if ( ! function_exists( 'bodycommerce_product_attributes_types' ) ):
  function bodycommerce_product_attributes_types( $selector ) {

    foreach ( bodycommerce_available_attributes_types() as $key => $options ) {
      $selector[ $key ] = $options[ 'title' ];
    }

    return $selector;
  }
endif;


function bodycommerce_get_available_product_variations() {
		if ( is_ajax() && isset( $_GET[ 'product_id' ] ) ) {
			$product_id           = absint( $_GET[ 'product_id' ] );
			$product              = wc_get_product( $product_id );
			$available_variations = array_values( $product->get_available_variations() );

			wp_send_json_success( wp_json_encode( $available_variations ) );
		} else {
			wp_send_json_error();
		}
}


if ( ! function_exists( 'bodycommerce_taxonomy_meta_fields' ) ):
  function bodycommerce_taxonomy_meta_fields( $field_id = false ) {

    $fields = array();

    $fields[ 'color' ] = array(
      array(
        'label' => esc_html__( 'Color', 'divi-bodyshop-woocommerce' ), // <label>
        'desc'  => esc_html__( 'Enter in the color code', 'divi-bodyshop-woocommerce' ), // description
        'id'    => 'product_attribute_color', // name of field
        'type'  => 'color'
      )
    );

    $fields[ 'image' ] = array(
      array(
        'label' => esc_html__( 'Image', 'divi-bodyshop-woocommerce' ), // <label>
        'desc'  => esc_html__( 'Enter Image URL Here', 'divi-bodyshop-woocommerce' ), // description
        'id'    => 'product_attribute_image', // name of field
        'type'  => 'image'
      )
    );

    $fields = apply_filters( 'bodycommerce_product_taxonomy_meta_fields', $fields );

    if ( $field_id ) {
      return isset( $fields[ $field_id ] ) ? $fields[ $field_id ] : array();
    }

    return $fields;

  }
endif;

if ( ! function_exists( 'bodycommerce_is_color_attribute' ) ):
  function bodycommerce_is_color_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'color';
  }
endif;


if ( ! function_exists( 'bodycommerce_is_image_attribute' ) ):
  function bodycommerce_is_image_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'image';
  }
endif;

if ( ! function_exists( 'bodycommerce_is_button_attribute' ) ):
  function bodycommerce_is_button_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'button';
  }
endif;


if ( ! function_exists( 'bodycommerce_is_radio_attribute' ) ):
  function bodycommerce_is_radio_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'radio';
  }
endif;


if ( ! function_exists( 'bodycommerce_is_select_attribute' ) ):
  function bodycommerce_is_select_attribute( $attribute ) {
    if ( ! is_object( $attribute ) ) {
      return false;
    }

    return $attribute->attribute_type == 'select';
  }
endif;

if ( ! function_exists( 'bodycommerce_get_product_attribute_color' ) ):
  function bodycommerce_get_product_attribute_color( $term ) {
    if ( ! is_object( $term ) ) {
      return false;
    }

    return get_term_meta( $term->term_id, 'product_attribute_color', TRUE );
  }
endif;


if ( ! function_exists( 'bodycommerce_get_product_attribute_image' ) ):
  function bodycommerce_get_product_attribute_image( $term ) {
    if ( ! is_object( $term ) ) {
      return false;
    }

    return get_term_meta( $term->term_id, 'product_attribute_image', TRUE );
  }
endif;


if ( ! function_exists( 'bodycommerce_add_product_taxonomy_meta' ) ) {
  function bodycommerce_add_product_taxonomy_meta() {

    $fields         = bodycommerce_taxonomy_meta_fields();
    $meta_added_for = apply_filters( 'bodycommerce_product_taxonomy_meta_for', array_keys( $fields ) );

    if ( function_exists( 'wc_get_attribute_taxonomies' ) ):

      $attribute_taxonomies = wc_get_attribute_taxonomies();
      if ( $attribute_taxonomies ) :
        foreach ( $attribute_taxonomies as $tax ) :
          $product_attr      = wc_attribute_taxonomy_name( $tax->attribute_name );
          $product_attr_type = $tax->attribute_type;
          if ( in_array( $product_attr_type, $meta_added_for ) ) :
            bodyc_commerce_add_term_meta( $product_attr, 'product', $fields[ $product_attr_type ] );

            do_action( 'bodycommerce_wc_attribute_taxonomy_meta_added', $product_attr, $product_attr_type );
          endif;
        endforeach;
      endif;
    endif;
  }
}


if ( ! function_exists( 'bodycommerce_product_option_terms' ) ) :
  function bodycommerce_product_option_terms( $attribute_taxonomy, $i ) {

			global $post, $thepostid, $product_object;
			if ( in_array( $attribute_taxonomy->attribute_type, array_keys( bodycommerce_available_attributes_types() ) ) ) {

				$taxonomy = wc_attribute_taxonomy_name( $attribute_taxonomy->attribute_name );

				$product_id = $thepostid;

				if ( is_null( $thepostid ) && isset( $_POST[ 'post_id' ] ) ) {
					$product_id = absint( $_POST[ 'post_id' ] );
				}

				$args = array(
					'orderby'    => 'name',
					'hide_empty' => 0,
				);

				?>
                <select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'divi-bodyshop-woocommerce' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo $i; ?>][]">
					<?php
						$all_terms = get_terms( $taxonomy, apply_filters( 'woocommerce_product_attribute_terms', $args ) );
						if ( $all_terms ) :
							foreach ( $all_terms as $term ) :
								echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( has_term( absint( $term->term_id ), $taxonomy, $product_id ), true, false ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
							endforeach;
						endif;
					?>
                </select>
				<?php do_action( 'before_bodycommerce_product_option_terms_button', $attribute_taxonomy, $taxonomy ); ?>
                <button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'divi-bodyshop-woocommerce' ); ?></button>
                <button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'divi-bodyshop-woocommerce' ); ?></button>

				<?php
				$fields = bodycommerce_taxonomy_meta_fields( $attribute_taxonomy->attribute_type );

				if ( ! empty( $fields ) ): ?>
                    <button class="button fr plus bodycommerce_add_new_attribute" data-dialog_title="<?php printf( esc_html__( 'Add new %s', 'divi-bodyshop-woocommerce' ), esc_attr( $attribute_taxonomy->attribute_label ) ) ?>"><?php esc_html_e( 'Add new', 'divi-bodyshop-woocommerce' ); ?></button>
				<?php else: ?>
                    <button class="button fr plus add_new_attribute"><?php esc_html_e( 'Add new', 'divi-bodyshop-woocommerce' ); ?></button>
				<?php endif; ?>
				<?php
				do_action( 'after_bodycommerce_product_option_terms_button', $attribute_taxonomy, $taxonomy, $product_id );
			}
		}
endif;

if ( ! function_exists( 'bodycommerce_get_wc_attribute_taxonomy' ) ):
  function bodycommerce_get_wc_attribute_taxonomy( $attribute_name ) {

    $transient = sprintf( 'bodycommerce_get_wc_attribute_taxonomy_%s', $attribute_name );

    if ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || isset( $_GET[ 'bodycommerce_clear_transient' ] ) ) {
      delete_transient( $transient );
    }

    if ( false === ( $attribute_taxonomy = get_transient( $transient ) ) ) {
      global $wpdb;

      $attribute_name     = str_replace( 'pa_', '', wc_sanitize_taxonomy_name( $attribute_name ) );
      $attribute_taxonomy = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name='{$attribute_name}'" );
      set_transient( $transient, $attribute_taxonomy );
    }

    return apply_filters( 'bodycommerce_get_wc_attribute_taxonomy', $attribute_taxonomy, $attribute_name );
  }
endif;


add_action( 'woocommerce_attribute_updated', function ( $attribute_id, $attribute, $old_attribute_name ) {
  $transient     = sprintf( 'bodycommerce_get_wc_attribute_taxonomy_%s', wc_attribute_taxonomy_name( $attribute[ 'attribute_name' ] ) );
  $old_transient = sprintf( 'bodycommerce_get_wc_attribute_taxonomy_%s', wc_attribute_taxonomy_name( $old_attribute_name ) );
  delete_transient( $transient );
  delete_transient( $old_transient );
}, 20, 3 );

add_action( 'woocommerce_attribute_deleted', function ( $attribute_id, $attribute_name, $taxonomy ) {
  $transient = sprintf( 'bodycommerce_get_wc_attribute_taxonomy_%s', $taxonomy );
  delete_transient( $transient );
}, 20, 3 );

if ( ! function_exists( 'bodycommerce_wc_product_has_attribute_type' ) ):
  function bodycommerce_wc_product_has_attribute_type( $type, $attribute_name ) {
    $attribute = bodycommerce_get_wc_attribute_taxonomy( $attribute_name );

    return apply_filters( 'bodycommerce_wc_product_has_attribute_type', ( isset( $attribute->attribute_type ) && ( $attribute->attribute_type == $type ) ), $type, $attribute_name, $attribute );
  }
endif;

if ( ! function_exists( 'bodycommerce_variable_items_wrapper' ) ):
  function bodycommerce_variable_items_wrapper( $contents, $type, $args, $saved_attribute = array() ) {

    $attribute = $args[ 'attribute' ];

    $css_classes = apply_filters( 'bodycommerce_variable_items_wrapper_class', array( "{$type}-variable-wrapper" ), $type, $args, $saved_attribute );


    $data = sprintf( '<span class="active-option"></span><ul class="%s variable-items-wrapper %s" data-attribute_name="%s" data-attribute_name_title="%s">%s</ul>', esc_attr( wc_variation_attribute_name( $attribute ) ) , implode( ' ', $css_classes ), esc_attr( wc_variation_attribute_name( $attribute ) ), esc_attr( wc_attribute_label( $attribute ) ), $contents );

    return apply_filters( 'bodycommerce_variable_items_wrapper', $data, $contents, $type, $args, $saved_attribute );
  }
endif;

if ( ! function_exists( 'bodycommerce_variable_item' ) ):
  function bodycommerce_variable_item( $type, $options, $args, $saved_attribute = array() ) {

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );


    $variation_label_width = $titan->getOption( 'variation_label_width' );
    $variation_label_height = $titan->getOption( 'variation_label_height' );

    $variation_image_width = $titan->getOption( 'variation_image_width' );
    $variation_image_hieght = $titan->getOption( 'variation_image_hieght' );

    $variation_color_width = $titan->getOption( 'variation_color_width' );
    $variation_color_height = $titan->getOption( 'variation_color_height' );




    $product   = $args[ 'product' ];
    $attribute = $args[ 'attribute' ];
    $data      = '';

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );
        $name  = uniqid( wc_variation_attribute_name( $attribute ) );
        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            $selected_class = ( sanitize_title( $args[ 'selected' ] ) == $term->slug ) ? 'active-variation' : '';
            $tooltip        = trim( apply_filters( 'bodycommerce_color_variable_item_tooltip', $term->name, $term, $args ) );

            $tooltip_html_attr = ! empty( $tooltip ) ? sprintf( 'data-wvstooltip="%s"', esc_attr( $tooltip ) ) : '';

            if ( wp_is_mobile() ) {
              $tooltip_html_attr .= ! empty( $tooltip ) ? ' tabindex="2"' : '';
            }


            switch ( $type ):
              case 'color':
              $data .= sprintf( '<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-value="%3$s" style="width:%6$spx;height:%7$spx;">', $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ), $variation_color_width, $variation_color_height );


                 $color = get_term_meta( $term->term_id, 'product_attribute_color', TRUE );
                $data  .= sprintf( '<span class="variable-item-span variable-item-span-%s" style="background-color:%s;"></span>', esc_attr( $type ), esc_attr( $color ) );
                break;

              case 'image':
              $data .= sprintf( '<li %1$s class="variable-item image-variation %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-value="%3$s" style="width:%6$spx;height:%7$spx;">', $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ), $variation_image_width, $variation_image_hieght );

                 $image_url = get_term_meta( $term->term_id, 'product_attribute_image', TRUE );
                $data          .= sprintf( '<span></span><img class="bc-variation-image" alt="%s" src="%s" width="%s" height="%s" style="width:%spx;height:%spx;"/>', esc_attr( $term->name ), esc_attr( $image_url ), $variation_image_width, $variation_image_hieght, $variation_image_width, $variation_image_hieght );
                break;

              case 'button':
              $data .= sprintf( '<li %1$s class="variable-item label-variation %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-value="%3$s" style="width:%6$spx;height:%7$spx;line-height:%7$spx;">', $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ), $variation_label_width, $variation_label_height );

                $data .= sprintf( '<span class="variable-item-span variable-item-span-%s">%s</span>', esc_attr( $type ), esc_html( $term->name ) );
                break;

              case 'radio':
              $data .= sprintf( '<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-value="%3$s">', $tooltip_html_attr, esc_attr( $type ), esc_attr( $term->slug ), esc_attr( $selected_class ), esc_html( $term->name ) );

                $id   = uniqid( $term->slug );
                $data .= sprintf( '<input name="%1$s" id="%2$s" class="wvs-radio-variable-item" %3$s  type="radio" value="%4$s" data-value="%4$s" /><label for="%2$s">%5$s</label>', $name, $id, checked( sanitize_title( $args[ 'selected' ] ), $term->slug, false ), esc_attr( $term->slug ), esc_html( $term->name ) );
                break;

              default:
                $data .= apply_filters( 'bodycommerce_variable_default_item_content', '', $term, $args, $saved_attribute );
                break;
            endswitch;
            $data .= '</li>';
          }
        }
      }
    }

    return apply_filters( 'bodycommerce_variable_item', $data, $type, $options, $args, $saved_attribute );
  }
endif;


if ( ! function_exists( 'bodycommerce_color_variation_attribute_options' ) ) :
  function bodycommerce_color_variation_attribute_options( $args = array() ) {

    $args = wp_parse_args( $args, array(
      'options'          => false,
      'attribute'        => false,
      'product'          => false,
      'selected'         => false,
      'name'             => '',
      'id'               => '',
      'class'            => '',
      'type'             => '',
      'show_option_none' => esc_html__( 'Choose an option', 'divi-bodyshop-woocommerce' )
    ) );

    $type                  = $args[ 'type' ];
    $options               = $args[ 'options' ];
    $product               = $args[ 'product' ];
    $attribute             = $args[ 'attribute' ];
    $name                  = $args[ 'name' ] ? $args[ 'name' ] : wc_variation_attribute_name( $attribute );
    $id                    = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
    $class                 = $args[ 'class' ];
    $show_option_none      = $args[ 'show_option_none' ] ? TRUE : false;
    $show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
      $attributes = $product->get_variation_attributes();
      $options    = $attributes[ $attribute ];
    }

    if ( $product && taxonomy_exists( $attribute ) ) {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' hide bodycommerce-variation-raw-select bodycommerce-variation-raw-type-' . esc_attr( $type ) . '" style="display:none" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    } else {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    }

    if ( $args[ 'show_option_none' ] ) {
      echo '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
    }

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        // Get terms if this is a taxonomy - ordered. We need the names too.
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
          }
        }
      } else {
        foreach ( $options as $option ) {
          // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
          $selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
          echo '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
        }
      }
    }

    echo '</select>';

    $content = bodycommerce_variable_item( $type, $options, $args );

    echo bodycommerce_variable_items_wrapper( $content, $type, $args );

  }
endif;


if ( ! function_exists( 'bodycommerce_image_variation_attribute_options' ) ) :
  function bodycommerce_image_variation_attribute_options( $args = array() ) {

    $args = wp_parse_args( $args, array(
      'options'          => false,
      'attribute'        => false,
      'product'          => false,
      'selected'         => false,
      'name'             => '',
      'id'               => '',
      'class'            => '',
      'type'             => '',
      'show_option_none' => esc_html__( 'Choose an option', 'divi-bodyshop-woocommerce' )
    ) );

    $type                  = $args[ 'type' ];
    $options               = $args[ 'options' ];
    $product               = $args[ 'product' ];
    $attribute             = $args[ 'attribute' ];
    $name                  = $args[ 'name' ] ? $args[ 'name' ] : wc_variation_attribute_name( $attribute );
    $id                    = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
    $class                 = $args[ 'class' ];
    $show_option_none      = $args[ 'show_option_none' ] ? TRUE : false;
    $show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
      $attributes = $product->get_variation_attributes();
      $options    = $attributes[ $attribute ];
    }


    if ( $product && taxonomy_exists( $attribute ) ) {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' hide bodycommerce-variation-raw-select bodycommerce-variation-raw-type-' . esc_attr( $type ) . '" style="display:none" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    } else {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    }


    if ( $args[ 'show_option_none' ] ) {
      echo '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
    }

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        // Get terms if this is a taxonomy - ordered. We need the names too.
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
          }
        }
      } else {
        foreach ( $options as $option ) {
          // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
          $selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
          echo '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
        }
      }
    }

    echo '</select>';

    $content = bodycommerce_variable_item( $type, $options, $args );

    echo bodycommerce_variable_items_wrapper( $content, $type, $args );
  }
endif;

if ( ! function_exists( 'bodycommerce_button_variation_attribute_options' ) ) :
  function bodycommerce_button_variation_attribute_options( $args = array() ) {

    $args = wp_parse_args( $args, array(
      'options'          => false,
      'attribute'        => false,
      'product'          => false,
      'selected'         => false,
      'name'             => '',
      'id'               => '',
      'class'            => '',
      'type'             => '',
      'show_option_none' => esc_html__( 'Choose an option', 'divi-bodyshop-woocommerce' )
    ) );

    $type                  = $args[ 'type' ];
    $options               = $args[ 'options' ];
    $product               = $args[ 'product' ];
    $attribute             = $args[ 'attribute' ];
    $name                  = $args[ 'name' ] ? $args[ 'name' ] : wc_variation_attribute_name( $attribute );
    $id                    = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
    $class                 = $args[ 'class' ];
    $show_option_none      = $args[ 'show_option_none' ] ? TRUE : false;
    $show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'woocommerce' ); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
      $attributes = $product->get_variation_attributes();
      $options    = $attributes[ $attribute ];
    }

    if ( $product && taxonomy_exists( $attribute ) ) {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' hide bodycommerce-variation-raw-select bodycommerce-variation-raw-type-' . esc_attr( $type ) . '" style="display:none" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    } else {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    }

    if ( $args[ 'show_option_none' ] ) {
      echo '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
    }

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        // Get terms if this is a taxonomy - ordered. We need the names too.
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
          }
        }
      } else {
        foreach ( $options as $option ) {
          // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
          $selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
          echo '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
        }
      }
    }

    echo '</select>';

    $content = bodycommerce_variable_item( $type, $options, $args );

    echo bodycommerce_variable_items_wrapper( $content, $type, $args );
  }
endif;


if ( ! function_exists( 'bodycommerce_radio_variation_attribute_options' ) ) :
  function bodycommerce_radio_variation_attribute_options( $args = array() ) {

    $args = wp_parse_args( $args, array(
      'options'          => false,
      'attribute'        => false,
      'product'          => false,
      'selected'         => false,
      'name'             => '',
      'id'               => '',
      'class'            => '',
      'type'             => '',
      'show_option_none' => esc_html__( 'Choose an option', 'divi-bodyshop-woocommerce' )
    ) );

    $type                  = $args[ 'type' ];
    $options               = $args[ 'options' ];
    $product               = $args[ 'product' ];
    $attribute             = $args[ 'attribute' ];
    $name                  = $args[ 'name' ] ? $args[ 'name' ] : wc_variation_attribute_name( $attribute );
    $id                    = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
    $class                 = $args[ 'class' ];
    $show_option_none      = $args[ 'show_option_none' ] ? TRUE : false;
    $show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'woocommerce' );

    if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
      $attributes = $product->get_variation_attributes();
      $options    = $attributes[ $attribute ];
    }

    if ( $product && taxonomy_exists( $attribute ) ) {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . ' hide bodycommerce-variation-raw-select bodycommerce-variation-raw-type-' . esc_attr( $type ) . '" style="display:none" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    } else {
      echo '<select id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
    }

    if ( $args[ 'show_option_none' ] ) {
      echo '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
    }

    if ( ! empty( $options ) ) {
      if ( $product && taxonomy_exists( $attribute ) ) {
        // Get terms if this is a taxonomy - ordered. We need the names too.
        $terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

        foreach ( $terms as $term ) {
          if ( in_array( $term->slug, $options ) ) {
            echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
          }
        }
      } else {
        foreach ( $options as $option ) {
          // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
          $selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
          echo '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
        }
      }
    }

    echo '</select>';

    $content = bodycommerce_variable_item( $type, $options, $args );

    echo bodycommerce_variable_items_wrapper( $content, $type, $args );
  }
endif;

if ( ! function_exists( 'bodycommerce_variation_attribute_options_html' ) ):
  function bodycommerce_variation_attribute_options_html( $html, $args ) {

    // IE 11 Fallback to default select box
    if ( bodycommerce_is_ie11() ) {
      return $html;
    }

    ob_start();

    $available_type_keys = array_keys( bodycommerce_available_attributes_types() );
    $available_types     = bodycommerce_available_attributes_types();
    $default             = TRUE;

    foreach ( $available_type_keys as $type ) {
      if ( bodycommerce_wc_product_has_attribute_type( $type, $args[ 'attribute' ] ) ) {
        $output_callback = apply_filters( 'bodycommerce_variation_attribute_options_callback', $available_types[ $type ][ 'output' ], $available_types, $type, $args, $html );
        $output_callback( apply_filters( 'bodycommerce_variation_attribute_options_args', array(
          'options'    => $args[ 'options' ],
          'attribute'  => $args[ 'attribute' ],
          'product'    => $args[ 'product' ],
          'selected'   => $args[ 'selected' ],
          'type'       => $type,
          'is_archive' => ( isset( $args[ 'is_archive' ] ) && $args[ 'is_archive' ] )
        ) ) );
        $default = false;
      }
    }

    if ( $default ) {
      echo $html;
    }

    $data = ob_get_clean();

    return apply_filters( 'bodycommerce_variation_attribute_options_html', $data, $args );
  }
endif;

function add_bodycommerce_pro_preview_tab( $tabs ) {
  $tabs[ 'bodycommerce-variation-swatches-pro' ] = array(
    'label'    => esc_html__( 'Swatches Settings', 'divi-bodyshop-woocommerce' ),
    'target'   => 'wvs-pro-product-variable-swatches-options',
    'class'    => array( 'show_if_variable', 'variations_tab' ),
    'priority' => 65,
  );

  return $tabs;
}




add_action('wp_footer', 'variant_swatches_footer');
function variant_swatches_footer(){

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $variation_swatch_active_colour = $titan->getOption( 'variation_swatch_active_colour' );

  $variation_label_colour_border_colour = $titan->getOption( 'variation_label_colour_border_colour' );
  $variation_label_colour_border_inside_colour = $titan->getOption( 'variation_label_colour_border_inside_colour' );
  $variation_label_colour_border_width = $titan->getOption( 'variation_label_colour_border_width' );

  
  $variation_hide_ofs = $titan->getOption( 'variation_hide_ofs' );


$variant_options = get_option( '_transient_wc_attribute_taxonomies' );


if ( isset($variation_hide_ofs) && $variation_hide_ofs == "1" ) {
  ?>

  <script>
  jQuery(document).ready(function( $ ) {
    $("body").addClass("hide_ots_variation");
  });
  </script>
  <?php
}

   ?>

<script>
jQuery(document).ready(function( $ ) {
  $(".variations_form").each(function(){
    if($('.variations tr', this).length <= 1) {
      console.log("less than one tr");
      <?php foreach($variant_options as $item) {
        $attribute_name = $item->attribute_name;
        $attribute_type = $item->attribute_type; ?>

        $("#pa_<?php echo $attribute_name ?> option").each(function(){
          var value = $(this).val();
          var name = $(this).text();
          if ( $(this).prop("disabled") ) {
            var name = "outofstock";
          } else {
            var name = name;
          }

          $(this).closest(".variations").find(".attribute_pa_<?php echo $attribute_name ?>.variable-items-wrapper .button-variable-item-" + value + "").addClass(name);
          $(this).closest(".variations").find(".attribute_pa_<?php echo $attribute_name ?>.variable-items-wrapper .color-variable-item-" + value + "").addClass(name);
          $(this).closest(".variations").find(".attribute_pa_<?php echo $attribute_name ?>.variable-items-wrapper .image-variable-item-" + value + "").addClass(name);
        });

        <?php } ?>

      }
    });

    $(".variations select.bodycommerce-variation-raw-select").each(function(){
      var select_name = $(this).attr("data-attribute_name");
      var value = $(this).val();
      <?php if ($variation_swatch_active_colour == "fade") { ?>
        $("."+select_name+" .variable-item").css("opacity","0.3");
        $(this).closest(".value").find(".variable-item[data-value='"+value+"']").addClass("active");
        <?php }else { ?><?php } ?>
      });

      <?php foreach($variant_options as $item) {
        $attribute_name = $item->attribute_name;
        $attribute_type = $item->attribute_type; ?>

        $(document).on('click', '.attribute_pa_<?php echo $attribute_name ?> .variable-item', function(){
          var click_value = $(this).attr("data-value");
    
          $(this).closest(".product").find("#pa_<?php echo $attribute_name ?>").val(click_value);
          $(this).closest(".product").find("#pa_<?php echo $attribute_name ?>").change();
          <?php if ($variation_swatch_active_colour == "fade") { ?>
            $(this).closest(".variations").find(".attribute_pa_<?php echo $attribute_name ?> .variable-item").css("opacity","0.3");
            $(this).closest(".variations").find(".attribute_pa_<?php echo $attribute_name ?> .variable-item").removeClass("active");
            $(this).addClass("active");
            <?php }else { ?>
              $(".attribute_pa_<?php echo $attribute_name ?> .variable-item").removeClass("active-variation");
              $(this).addClass("active-variation");
              <?php } ?>

              $(".variations tr").each(function(){

                $(this).find("li.variable-item").removeClass("visible");

                if ( $("body").hasClass("hide_ots_variation") ) {
                  $(this).find("li.variable-item").addClass("hidethis");
             

                $(this).find("select > option").each(function(){
                  var option_val = this.value;
                  var target = $(this).closest("tr").find("li.variable-item[data-value='"+option_val+"']");
 
                  if ( $(target).length ) {
                    console.log("yes: " + option_val)
                    target.removeClass("hidethis");
                    target.addClass("visible");
                  } 
                });

              }

              });

            });
            <?php } ?>
            $(".variable-item.outofstock").unbind("click");
            $(".reset_variations").click(function() {
              $(".variable-item").css("opacity","1");
            });
          });
</script>

<script>
jQuery(document).ready(function(a){
  a(document).on("click",".variable-item",function(){
    a(this).closest(".variations").find(".variable-item").addClass("outofstock"),
    a(this).closest(".variations_form").find(".variations select.bodycommerce-variation-raw-select option").each(function(){
      var e=a(this).val();
      a(this).closest(".variations_form").find(".variable-item[data-value='"+e+"']").removeClass("outofstock");
      if(a(this).hasClass("enabled"))
      var t="instock";
      else t="outofstock";
      a(this).closest(".variations_form").find(".variable-item[data-value='"+e+"']").addClass(t)
    })
  })
});
</script>
<?php

}

add_action('wp_head', 'variant_swatches_head');
function variant_swatches_head(){

  include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
  $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
  $variation_style = $titan->getOption( 'variation_style' );
  $variation_swatch_active_colour = $titan->getOption( 'variation_swatch_active_colour' );
  $variation_label_colour_border_width = $titan->getOption( 'variation_label_colour_border_width' );
  $variation_label_colour_border_colour_normal = $titan->getOption( 'variation_label_colour_border_colour_normal' );
  $variation_label_colour_border_inside_colour_normal = $titan->getOption( 'variation_label_colour_border_inside_colour_normal' );
    $variation_label_colour_border_colour = $titan->getOption( 'variation_label_colour_border_colour' );
    $variation_label_colour_border_inside_colour = $titan->getOption( 'variation_label_colour_border_inside_colour' );

  $variation_label_background_color = $titan->getOption( 'variation_label_background_color' );
  $variation_label_text_color = $titan->getOption( 'variation_label_text_color' );



if ($variation_style == "square") {
  $variation_style_display = "";
}
else if ($variation_style == "circle") {
  $variation_style_display = "border-radius: 50%;overflow: hidden;outline: 0;margin-right: 10px;";
}
else {
  $variation_style_display = "";
}

  ?>
<style>
<?php if ($variation_swatch_active_colour == "fade") { ?><?php } else { ?>.variations .variable-item {border: <?php echo $variation_label_colour_border_width ?>px solid <?php echo $variation_label_colour_border_colour_normal ?>;}.variations .variable-item span {box-shadow: <?php echo $variation_label_colour_border_inside_colour_normal ?> 0px 0px 0px <?php echo $variation_label_colour_border_width ?>px inset;}.variations .variable-item.active-variation {border: <?php echo $variation_label_colour_border_width ?>px solid <?php echo $variation_label_colour_border_colour ?>;}.variations .variable-item.active-variation span {box-shadow: <?php echo $variation_label_colour_border_inside_colour ?> 0px 0px 0px <?php echo $variation_label_colour_border_width ?>px inset;}<?php } ?>.variable-item {background-color: <?php echo $variation_label_background_color ?>;color: <?php echo $variation_label_text_color ?>;margin: 1px 1px 0 0;outline: 1px solid #63605a;<?php echo $variation_style_display ?>display: inline-block;border: none;height: 40px;line-height: 40px;width: 55px;text-align: center;cursor: pointer;}.variable-item span {<?php echo $variation_style_display ?>}.variable-item.outofstock{background:linear-gradient(to top right,transparent 0,transparent calc(50% - .8px),#ccc 50%,transparent calc(50% + .8px),transparent);background-color:rgba(0,0,0,0);cursor:no-drop}.color-variable-item.outofstock span,.image-variable-item.outofstock img{opacity:.3}.color-variable-item.outofstock,.image-variable-item.outofstock{opacity:1!important}.variable-item span,.variable-item-span-color{position:absolute;width:100%;height:100%;left:0}.color-variable-item,.variable-item{position:relative}}
</style>
<?php
}

function bodycommerce_variation_swatches() {

}

function get_stock_variations_from_product(){
    global $product;
    $variations = $product->get_available_variations();
    foreach($variations as $variation){
         $variation_id = $variation['variation_id'];
         $variation_obj = new WC_Product_variation($variation_id);
         $stock = $variation_obj->get_stock_quantity();
         echo $stock;
    }
}




add_action( 'wp_ajax_nopriv_bodycommerce_get_available_variations', 'bodycommerce_get_available_product_variations' );

add_action( 'wp_ajax_bodycommerce_get_available_variations', 'bodycommerce_get_available_product_variations' );

add_filter( 'product_attributes_type_selector', 'bodycommerce_product_attributes_types' );



add_action( 'admin_init', 'bodycommerce_add_product_taxonomy_meta' );

add_action( 'woocommerce_product_option_terms', 'bodycommerce_product_option_terms', 10, 2 );


add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'bodycommerce_variation_attribute_options_html', 200, 2 );


function bodyc_commerce_add_term_meta( $taxonomy, $post_type, $fields ) {
				return new bodycommerce_Term_Meta( $taxonomy, $post_type, $fields );
			}

      add_action( 'admin_enqueue_scripts', 'admin_enqueue_scripts'  );
           function admin_enqueue_scripts() {
              $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';



              wp_localize_script( 'bodycommerce-variation-swatches-admin', 'WVSPluginObject', array(
                'media_title'   => esc_html__( 'Enter Image URL Here', 'divi-bodyshop-woocommerce' ),
                'dialog_title'  => esc_html__( 'Add Attribute', 'divi-bodyshop-woocommerce' ),
                'dialog_save'   => esc_html__( 'Add', 'divi-bodyshop-woocommerce' ),
                'dialog_cancel' => esc_html__( 'Cancel', 'divi-bodyshop-woocommerce' ),
                'button_title'  => esc_html__( 'Use Image', 'divi-bodyshop-woocommerce' ),
                'add_media'     => esc_html__( 'Add Media', 'divi-bodyshop-woocommerce' ),
                'ajaxurl'       => esc_url( admin_url( 'admin-ajax.php', 'relative' ) ),
                'nonce'         => wp_create_nonce( 'bodycommerce_plugin_nonce' ),
              ) );
            }

add_filter( 'woocommerce_ajax_variation_threshold', 'bodycommerce_ajax_variation_threshold', 10, 1 );

function bodycommerce_ajax_variation_threshold( $threshold_amount ){

    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
    $variation_ajax_threshold_amount = $titan->getOption( 'variation_ajax_threshold_amount' );

    if ($variation_ajax_threshold_amount == "") {
        return $threshold_amount;
    }
    else {
        return $variation_ajax_threshold_amount;
    }
}


add_action('wp_head', 'variant_swatches_header');
function variant_swatches_header(){
  ?>
  <style>
.et_pb_wc_add_to_cart form.cart .variations td.value span:after {
  display: none !important;
}
</style>
<?php
}