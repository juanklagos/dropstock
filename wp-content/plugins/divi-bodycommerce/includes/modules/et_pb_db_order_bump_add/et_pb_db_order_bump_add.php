<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_order_bump_add_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.CF Order Bump Add - Checkout Funnel', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_order_bump_add';


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


                      $this->button_css = "%%order_class%%";

                      $this->advanced_fields = array(
                        'fonts' => array(
                  			),
                  			'box_shadow'            => array(
                  				'default' => array(
                  					'css' => array(
                              'main' => "{$this->main_css_element}",
                              'important' => 'all'
                  					),
                  				),
                  			),
                  			'background' => array(
                  				'css' => array(
                            'main' => "{$this->main_css_element}",
                            'important' => 'all'
                  				),
                  				'settings' => array(
                  					'color' => 'alpha',
                  				),
                  			),
                  			'border' => array(
                  				'css' => array(
                            'main' => "{$this->main_css_element}",
                            'important' => 'all'
                  				),
                  			),
			'custom_margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
                  			'button' => array(
                  			),
			'form_field'    => array(
				'form_field' => array(
					'label'          => esc_html__( 'Field', 'et_builder' ),
					'css'            => array(
						'background_color'       => '%%order_class%% .input[type="checkbox"] + label i',
						'main'                         => '%%order_class%% .input',
						'background_color'             => ' %%order_class%% .input[type="checkbox"] + label i',
						'background_color_hover'       => '%%order_class%% .input[type="checkbox"] + label:hover i',
						'focus_background_color'       => '%%order_class%% .input[type="checkbox"]:active + label i',
						'focus_background_color_hover' => '.input[type="checkbox"]:active:hover + label i',
						'form_text_color'              => '%%order_class%% .input[type="checkbox"] + label, %%order_class%% .input[type="checkbox"]:checked + label i:before',
						'form_text_color_hover'        => '%%order_class%% .input[type="checkbox"]:hover + label, %%order_class%% .input[type="checkbox"]:checked:hover + label i:before',
						'focus_text_color'             => '%%order_class%% .input[type="checkbox"]:active + label, %%order_class%% .input[type="checkbox"]:checked:active + label i:before',
						'focus_text_color_hover'       => '%%order_class%% .input[type="checkbox"]:active:hover + label, %%order_class%% .input[type="checkbox"]:checked:active:hover + label i:before',
					),
					'margin_padding' => false,
					'box_shadow'     => false,
					'border_styles'  => false,
					'font_field'     => array(
						'css' => array(
							'main'      => implode( ',', array(
								"{$this->main_css_element} .input[type=checkbox] + label",
							) ),
							'important' => 'plugin_only',
						),
					),
				),
			),
                  		);

                                        }


                                        function get_fields() {
                          		$fields = array(
                                'checkbox_label' => array(
                                  'label'           => esc_html__( 'Checkbox Label', 'divi-bodyshop-woocommerce' ),
                                  'type'            => 'text',
                                  'computed_affects' => array(
                                    '__getorderbumpadd',
                                  ),
                                  'option_category' => 'basic_option',
                                  'description'     => esc_html__( 'Write the text you want to appear after the checkbox', 'divi-bodyshop-woocommerce' ),
                                ),
                      'admin_label' => array(
                          'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                          'type'        => 'text',
                          'toggle_slug'     => 'main_content',
                          'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                      ),
                      '__getorderbumpadd' => array(
                        'type' => 'computed',
                        'computed_callback' => array( 'db_order_bump_add_code', 'get_order_bump_add_shortcode' ),
                        'computed_depends_on' => array(
                          'admin_label',
                          'checkbox_label'
                        ),
                      ),

                          );

                          return $fields;
                      }

                      public static function get_order_bump_add_shortcode ( $args = array(), $conditional_tags = array(), $current_page = array() ){
                        if (!is_admin()) {
                    			return;
                    		}


                        ob_start();

                        $args = array(
                          'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => '3',
                        'orderby' => 'ID',
                        'order' => 'ASC',
                      );

                        $loop = new WP_Query( $args );

                        $first = true;
                        while ( $loop->have_posts() ) : $loop->the_post();

                          if ( $first )  {
                    //*---------------------------------------------------------------------------------------------------*//


                    global $post;
                    $product = new WC_Product( $post->ID );
                    include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
                    $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
                    $order_bump_product = $titan->getOption( 'order_bump_product' );


                      ?>
        <div class="et_pb_contact">
          <p>
                      <span class="et_pb_contact_field_checkbox">
            <input type="checkbox" id="bc_order_bump" class="input" name="bc_order_bump" value="Order Bump">
            <label for="bc_order_bump"><i></i><?php echo esc_attr( $args['checkbox_label'] ); ?></label>
          </span>
        </p>
      </div>
                      <?php

                    //*---------------------------------------------------------------------------------------------------*//
                        $first = false;
                    } else {

                    }
                    endwhile; wp_reset_query(); // Remember to reset

                        $data = ob_get_clean();

                      return $data;

                      }



                  function render( $attrs, $content = null, $render_slug ) {

                    global $product;

                    $checkbox_label       		= $this->props['checkbox_label'];

                    if (is_admin()) {
                        return;
                    }


                      ob_start();

                      include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
                      $titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );
                      $order_bump_product = $titan->getOption( 'order_bump_product' );

if ( $product->is_type( 'variable' ) ) {
  woocommerce_template_single_add_to_cart();
?>
<div class="et_pb_contact">
  <p>
              <span class="et_pb_contact_field_checkbox">
    <input type="checkbox" id="bc_order_bump" class="input" name="bc_order_bump" value="Order Bump">
    <label for="bc_order_bump"><i></i><?php echo $checkbox_label ?></label>
  </span>
</p>
</div>
<?php
} else {
                        ?>
          <div class="et_pb_contact">
            <p>
                        <span class="et_pb_contact_field_checkbox">
							<input type="checkbox" id="bc_order_bump" class="input" name="bc_order_bump" value="Order Bump">
							<label for="bc_order_bump"><i></i><?php echo $checkbox_label ?></label>
						</span>
          </p>
        </div>
                        <?php
}


                  $content = ob_get_clean();

                  //////////////////////////////////////////////////////////////////////



                  return $content;



              	}
              }

            new db_order_bump_add_code;

?>
