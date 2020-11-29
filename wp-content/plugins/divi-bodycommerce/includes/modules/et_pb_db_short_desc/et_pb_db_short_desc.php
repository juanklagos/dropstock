<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_short_desc_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PL Short Description - Product Page / Loop Layout', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_short_desc';

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
                      'text'   => array(
                                      'label'    => esc_html__( 'Short Description', 'et_builder' ),
                                      'css'      => array(
                                              'main' => "{$this->main_css_element}",
                                      ),
                                      'font_size' => array('default' => '14px'),
                                      'line_height'    => array('default' => '1.5em'),
                      ),
        			),
        			'background' => array(
        				'settings' => array(
        					'color' => 'alpha',
        				),
        			),
        			'border' => array(),
        			'custom_margin_padding' => array(
        				'css' => array(
        					'important' => 'all',
        				),
        			),
        		);

            $this->help_videos = array(
              array(
                'id'   => esc_html__( 'n2karNiwJ3A', 'divi-bodyshop-woocommerce' ), // YouTube video ID
                'name' => esc_html__( 'BodyCommcerce Product Page Template Guide', 'divi-bodyshop-woocommerce' ),
              ),
            );
          }

    function get_fields() {
    		$fields = array(
'custom_length' => array(
'label'           => __( 'Custom Word Count?', 'divi-bodyshop-woocommerce' ),
'type'            => 'yes_no_button',
'toggle_slug'       => 'custom_content',
'option_category'   => 'layout',
'options'         => array(
'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
),
'affects'=>array(
'excert_limit',
'excert_readmore',
'excert_readmore_link'
),
'description'       => __( 'Enable this if you want to limit the number of words shown', 'divi-bodyshop-woocommerce' ),
),
          'excert_limit' => array(
              'label'       => __( 'Word Count', 'divi-bodyshop-woocommerce' ),
              'type'        => 'range',
              'depends_show_if' => 'on',
      				'default'			=> '20',
              'toggle_slug'       => 'custom_content',
              'option_category'   => 'layout',
			           'fixed_unit'       => ' words',
              'range_settings'  => array(
                'min'  => '0',
                'max'  => '500',
                'step' => '1',
                ''
              ),
              'description' => __( 'Choose the max number of words to be shown.', 'divi-bodyshop-woocommerce' ),
          ),
          'excert_readmore' => array(
              'label'       => __( 'Read More Text', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'       => 'custom_content',
              'option_category'   => 'layout',
              'default'           => '...',
              'depends_show_if' => 'on',
              'description' => __( 'Choose the text that will appear after the shortened short description text.', 'divi-bodyshop-woocommerce' ),
          ),
          'excert_readmore_link' => array(
              'label'       => __( 'Link Read More Text?', 'divi-bodyshop-woocommerce' ),
              'type'            => 'yes_no_button',
              'toggle_slug'       => 'custom_content',
              'option_category'   => 'layout',
              'depends_show_if' => 'on',
              'affects'=>array(
              'custom_url'
              ),
              'options' => array(
                'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
              ),
              'description' => __( 'If you want to link to the product page, enable this.', 'divi-bodyshop-woocommerce' ),
          ),
          'custom_url' => array(
            'label'       => __( 'Custom URL End', 'divi-bodyshop-woocommerce' ),
            'type'        => 'text',
            'toggle_slug'       => 'custom_content',
            'option_category'   => 'layout',
            'depends_show_if' => 'on',
            'description' => __( 'If you want to add an extension after the URL such as an anchor link - add it here. For example add #buynow to go to a section on the product page that has the ID "buynow".', 'et_builder' ),
                      ),
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__getproshortdesc' => array(
          'type' => 'computed',
          'computed_callback' => array( 'db_short_desc_code', 'get_pro_short_desc' ),
          'computed_depends_on' => array(
          'admin_label'
          ),
          ),
    		);

    		return $fields;
    	}


      public static function get_pro_short_desc ( $args = array(), $conditional_tags = array(), $current_page = array() ){

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
global $post, $woocommerce;
woocommerce_template_single_excerpt();
//*---------------------------------------------------------------------------------------------------*//
        $first = false;
    } else {

    }
  endwhile; wp_reset_query(); // Remember to reset

        $data = ob_get_clean();

      return $data;

      }


                  function render( $attrs, $content = null, $render_slug ) {


                    $custom_length           = $this->props['custom_length'];
                    $excert_limit           = $this->props['excert_limit'];
                    $excert_readmore           = $this->props['excert_readmore'];
                    $excert_readmore_link           = $this->props['excert_readmore_link'];
                    $custom_url           = $this->props['custom_url'];






                    $data = '';
                  //////////////////////////////////////////////////////////////////////
                    ob_start();
                    global $post, $product, $woocommerce;

                    if ($custom_length == "on") {
                    $limit = substr($excert_limit, 0, -6);
                    $ending = $excert_readmore;

                    if ($excert_readmore_link == 'on') {
                    global $product;

                    if( $product instanceof WC_Product ) {

                    $product_id = $product->get_id();
                    $url = get_permalink( $product_id );
                    $ending_url = $url . $custom_url;

                  } else {
                    $ending_url = '';
                  }

                  } else {
                    $ending_url = '';
                  }

                  echo bc_shorten_excerpt($limit, $ending, $ending_url);

                  } else {
                    woocommerce_template_single_excerpt();
                  }

                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_short_desc_code;

?>
