<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_product_title_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PL Title - Product Page / Loop Layout', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_product_title';

		$this->fields_defaults = array(
			'background_layout' => array( 'light' ),
      'link_product'   => array( 'off' ),
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
				'header'   => array(
					'label'    => esc_html__( 'Title', 'divi-bodyshop-woocommerce' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .product_title",
    					'important' => 'all',
					),
					'font_size' => array(
						'default' => '30px',
					),
					'line_height' => array(
						'default' => '1em',
					),
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
          'main' => "{$this->main_css_element} .entry-title",
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
          'title_tag' => array(
            'label'       => __( 'Title HTML Tag', 'et_builder' ),
            'type'        => 'select',
            'options'     => array(
                "h1"=>"h1",
                "h2"=>"h2",
                "h3"=>"h3",
                "h4"=>"h4",
                "h5"=>"h5",
                "h6"=>"h6",
                 "p"=>"p"
            ),
            'description'        => esc_html__( 'What html tag you want for the title. For example on the product page you might want it as h1 but on the product loop you would not want h1 but maybe h3.)', 'divi-bodyshop-woocommerce' ),
          ),
        'link_product' => array(
        'label'             => esc_html__( 'Link Title to Product Page (if on category page)', 'et_builder' ),
        'type'              => 'yes_no_button',
        'option_category'   => 'layout',
        'option_category'   => 'configuration',
        'options'           => array(
        'on'  => esc_html__( 'Yes', 'et_builder' ),
        'off' => esc_html__( 'No', 'et_builder' ),
        ),
        'description'        => esc_html__( 'Enable this if you want to allow the user to click on the title to go to the product page.)', 'divi-bodyshop-woocommerce' ),
        ),
        'admin_label' => array(
            'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
            'type'        => 'text',
            'toggle_slug'     => 'main_content',
            'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
        ),
        '__getprotitle' => array(
        'type' => 'computed',
        'computed_callback' => array( 'db_product_title_code', 'get_pro_title' ),
        'computed_depends_on' => array(
        'admin_label'
        ),
        ),

    		);

    		return $fields;
    	}


      public static function get_pro_title ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
         echo the_title();
//*---------------------------------------------------------------------------------------------------*//
        $first = false;
    } else {

    }
  endwhile; wp_reset_query(); // Remember to reset

        $data = ob_get_clean();

      return $data;

      }



                  function render( $attrs, $content = null, $render_slug ) {

                    if( is_admin() ){
                      return;
                    }

                    $link_product		= $this->props['link_product'];
                    $title_tag		= $this->props['title_tag'];

                    if ($title_tag == "") {
                      $title_tag = "h1";
                    }
                    else {
                      $title_tag = $title_tag;
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();


                    global $product;

                    if ($link_product == 'on' ) {
                      if ( ! is_a( $product, 'WC_Product' ) ) {
                        return;
                      }
                      $product_id = $product->get_id();
                    $url = get_permalink( $product_id );
                    echo '<a href="'.$url.'" >';
                  }


			echo '<'.$title_tag.' itemprop="name" class="product_title entry-title">';
			echo $product->get_name();
			echo '</'.$title_tag.'>';

                    if ($link_product == 'on' ) {
                    echo '</a>';
                    }

                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_product_title_code;

?>
