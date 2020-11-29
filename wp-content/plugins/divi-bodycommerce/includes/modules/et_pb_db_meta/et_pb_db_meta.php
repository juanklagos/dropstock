<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_meta_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PL Meta - Product Page / Loop Layout', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_meta';

		$this->fields_defaults = array(
			'show_cats'  		=> array( 'on' ),
			'show_tags'  		=> array( 'on' ),
			'show_sku'  		=> array( 'on' ),
			'single_line'  		=> array( 'off' ),
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
        				'meta'   => array(
        					'label'    => esc_html__( 'Meta', 'divi-bodyshop-woocommerce' ),
        					'css'      => array(
        						'main' => "{$this->main_css_element} .product_meta, {$this->main_css_element} .product_meta a",
        					),
        					'font_size' => array(
        						'default' => '14px',
        					),
        					'line_height' => array(
        						'default' => '1.3em',
        					),
        				),
          				'metatitle'   => array(
          					'label'    => esc_html__( 'Meta Title', 'divi-bodyshop-woocommerce' ),
          					'css'      => array(
          						'main' => "{$this->main_css_element} .product_meta .sku_wrapper .metatitle, {$this->main_css_element} .product_meta .posted_in .metatitle, {$this->main_css_element} .product_meta .tagged_as .metatitle",
          					),
          					'font_size' => array(
          						'default' => '14px',
          					),
          					'line_height' => array(
          						'default' => '1.3em',
          					),
          				),
            				'metavalue'   => array(
            					'label'    => esc_html__( 'Meta Value', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} .product_meta .sku, {$this->main_css_element} .product_meta a",
            					),
            					'font_size' => array(
            						'default' => '14px',
            					),
            					'line_height' => array(
            						'default' => '1.3em',
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
    			'show_cats' => array(
    				'label' => esc_html__( 'Show Categories', 'divi-bodyshop-woocommerce' ),
    				'type' => 'yes_no_button',
    				'option_category' => 'configuration',
    				'options' => array(
    					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
    					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    				),
    				'toggle_slug' => 'main_content',
    			),
    			'remove_links_cats' => array(
    				'label' => esc_html__( 'Remove Link to categories', 'divi-bodyshop-woocommerce' ),
    				'type' => 'yes_no_button',
    				'option_category' => 'configuration',
    				'description' => esc_html__( 'Enabling this will remove the link to the categories', 'divi-bodyshop-woocommerce' ),
    				'options' => array(
    					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
    				),
    				'toggle_slug' => 'main_content',
    			),
    			'show_tags' => array(
    				'label' => esc_html__( 'Show Tags', 'divi-bodyshop-woocommerce' ),
    				'type' => 'yes_no_button',
    				'option_category' => 'configuration',
    				'options' => array(
    					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
    					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    				),
    				'toggle_slug' => 'main_content',
    			),
    			'remove_links_tags' => array(
    				'label' => esc_html__( 'Remove Link to tags', 'divi-bodyshop-woocommerce' ),
    				'type' => 'yes_no_button',
    				'option_category' => 'configuration',
    				'description' => esc_html__( 'Enabling this will remove the link to the tags', 'divi-bodyshop-woocommerce' ),
    				'options' => array(
    					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
    				),
    				'toggle_slug' => 'main_content',
    			),
    			'show_sku' => array(
    				'label' => esc_html__( 'Show SKU', 'divi-bodyshop-woocommerce' ),
    				'type' => 'yes_no_button',
    				'option_category' => 'configuration',
    				'options' => array(
    					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
    					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    				),
    				'toggle_slug' => 'main_content',
    			),
    			'separate_line' => array(
    				'label' => esc_html__( 'Put meta items on separate lines', 'divi-bodyshop-woocommerce' ),
    				'type' => 'yes_no_button',
    				'option_category' => 'configuration',
    				'description' => esc_html__( 'Enabling this will show Categories, Tags and SKU each in a separate line', 'divi-bodyshop-woocommerce' ),
    				'options' => array(
    					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
    				),
    				'toggle_slug' => 'main_content',
    			),
    			'separate_line_each' => array(
    				'label' => esc_html__( 'Put title & value on seperate lines for each meta item', 'divi-bodyshop-woocommerce' ),
    				'type' => 'yes_no_button',
    				'option_category' => 'configuration',
    				'description' => esc_html__( 'Enabling this will put the titles and values of Categories, Tags and SKU each in a separate line', 'divi-bodyshop-woocommerce' ),
    				'options' => array(
    					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
    				),
    				'toggle_slug' => 'main_content',
    			),
    			'remove_border' => array(
    				'label' => esc_html__( 'Remove border above', 'divi-bodyshop-woocommerce' ),
    				'type' => 'yes_no_button',
    				'option_category' => 'configuration',
    				'description' => esc_html__( 'Enabling this will remove the border that appears above the meta items', 'divi-bodyshop-woocommerce' ),
    				'options' => array(
    					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
    				),
    				'toggle_slug' => 'main_content',
    			),
    			'remove_titles' => array(
    				'label' => esc_html__( 'Remove titles', 'divi-bodyshop-woocommerce' ),
    				'type' => 'yes_no_button',
    				'option_category' => 'configuration',
    				'description' => esc_html__( 'Enabling this will remove the titles for example the word "Category:"', 'divi-bodyshop-woocommerce' ),
    				'options' => array(
    					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    					'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
    				),
    				'toggle_slug' => 'main_content',
    			),
          'admin_label' => array(
              'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
              'type'        => 'text',
              'toggle_slug'     => 'main_content',
              'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
          ),
          '__getprometa' => array(
          'type' => 'computed',
          'computed_callback' => array( 'db_meta_code', 'get_pro_meta' ),
          'computed_depends_on' => array(
          'admin_label'
          ),
          ),
    		);

    		return $fields;
    	}

      public static function get_pro_meta ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
woocommerce_template_single_meta();
//*---------------------------------------------------------------------------------------------------*//
        $first = false;
    } else {

    }
  endwhile; wp_reset_query(); // Remember to reset

        $data = ob_get_clean();

      return $data;

      }

                  function render( $attrs, $content = null, $render_slug ) {

                    $show_cats			= $this->props['show_cats'];
                    $show_tags			= $this->props['show_tags'];
                    $show_sku			= $this->props['show_sku'];
                    $separate_line		= $this->props['separate_line'];
                    $separate_line_each		= $this->props['separate_line_each'];
                    $remove_border		= $this->props['remove_border'];
                    $remove_titles		= $this->props['remove_titles'];
                    $remove_links_cats		= $this->props['remove_links_cats'];
                    $remove_links_tags		= $this->props['remove_links_tags'];


                    if( $remove_links_cats == 'on' ){
                      $this->add_classname('remove-cat-link');
                    }


                    if( $remove_links_tags == 'on' ){
                      $this->add_classname('remove-tags-link');
                    }


                    if( $show_cats == 'off' ){
                      $this->add_classname('hide-cats');
                    }

                    if( $show_tags == 'off' ){
                      $this->add_classname('hide-tags');
                    }

                    if( $show_sku == 'off' ){
                      $this->add_classname('hide-sku');
                    }

                    if( $separate_line == 'on' ){
                      $this->add_classname('separate-line');
                    }

                    if( $separate_line_each == 'on' ){
                      $this->add_classname('separate-line-each');
                    }

                    if ( $remove_border == 'on' ) {
                      $this->add_classname('remove-border');
                    }

                    if ( $remove_titles == 'on' ) {
                      $this->add_classname('hide-titles');
                    }

                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    if( is_admin() ){
                      return;
                    }

                    ob_start();
                    woocommerce_template_single_meta();

                    ?>
<script>
jQuery(document).ready(function($){
  $( ".variations select" ).change(function() {
  $(".sku_wrapper .sku").attr("data-o_content", "");
  });
});
</script>
                    <?php

                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_meta_code;

?>
