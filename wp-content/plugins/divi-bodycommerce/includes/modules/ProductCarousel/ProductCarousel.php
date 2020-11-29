<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_product_carousel_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.G Product Carousel - Global', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_product_carousel';

                    $this->fields_defaults = array(
                    'show_pagination'   => array( 'on' ),
                    );

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Main Settings', 'divi-bodyshop-woocommerce' ),
      					'carousel_settings' => esc_html__( 'Carousel Settings', 'divi-bodyshop-woocommerce' ),
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
        $options = DEBC_INIT::get_divi_layouts();

    		$fields = array(
          'loop_layout' => array(
          'label'             => esc_html__( 'Loop Layout', 'divi-bodyshop-woocommerce' ),
          'type'              => 'select',
          'toggle_slug'       => 'main_content',
          'option_category'   => 'layout',
          'default'           => 'none',
          'options'           => $options,
          'description'        => esc_html__( 'Choose the layout you have made for each product in the loop.', 'divi-bodyshop-woocommerce' ),
          ),
          'link_whole_gird' => array(
          'option_category'   => 'layout',
          'toggle_slug'       => 'main_content',
                  'label'             => esc_html__( 'Link each layout to product', 'divi-bodyshop-woocommerce' ),
                  'type'              => 'yes_no_button',
                  'options'           => array(
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                  ),
                  'description'        => esc_html__( 'Enable this if you want to link each loop layout to the product. For example if you want the whole "grid card" to link to the product page. NB: You need to have no other links on the loop layout so do not link the image or the title to the product page.', 'divi-bodyshop-woocommerce' ),
                ),
          'featured_only' => array(
            'label'             => esc_html__( 'Display featured products?', 'et_builder' ),
            'type'              => 'yes_no_button',
            'toggle_slug'       => 'main_content',
            'option_category'   => 'layout',
            'options'           => array(
              'on'  => esc_html__( 'Yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
          ),
          'popular_only' => array(
            'label'             => esc_html__( 'Display Most Popular products?', 'et_builder' ),
            'type'              => 'yes_no_button',
            'toggle_slug'       => 'main_content',
            'option_category'   => 'layout',
            'options'           => array(
              'on'  => esc_html__( 'Yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
          ),
          'on_sale_only' => array(
            'toggle_slug'       => 'main_content',
            'label'             => esc_html__( 'Display On Sale products?', 'et_builder' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'layout',
            'options'           => array(
                'on'  => esc_html__( 'Yes', 'et_builder' ),
                'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'default'           => 'off',
          ),
          'new_only' => array(
            'toggle_slug'       => 'main_content',
            'label'             => esc_html__( 'Display New products?', 'et_builder' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'layout',
            'options'           => array(
                'on'  => esc_html__( 'Yes', 'et_builder' ),
                'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'default'           => 'off',
            'depends_show_if'   => 'on',
            'affects'=>array(
                'new_time'
            ),
          ),
          'new_time' => array(
                'toggle_slug'       => 'main_content',
                'label'           => esc_html__( 'Number of days', 'divi-bodyshop-woocommerce' ),
                'type'            => 'text',
                'depends_show_if'   => 'on',
                'description'     => esc_html__( 'Define the number of days you want to show the products', 'divi-bodyshop-woocommerce' ),
          ),
          'hide_non_purchasable' => array(
          'toggle_slug'       => 'main_content',
          'option_category'   => 'layout',
                  'label'             => esc_html__( 'Hide non purchasable products?', 'divi-bodyshop-woocommerce' ),
                  'type'              => 'yes_no_button',
                  'options'           => array(
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                  ),
                  'default'            => 'off',
                  'description'        => esc_html__( 'If you want to hide non purchasable products, enable this.', 'divi-bodyshop-woocommerce' ),
                ),

          'carousel_type' => array(
            'label'             => esc_html__( 'Carousel Type', 'et_builder' ),
            'type'              => 'select',
            'option_category'   => 'layout',
            'toggle_slug'       => 'main_content',
            'options'           => array(
              'default'  => esc_html__( 'Default', 'et_builder' ),
              'current-cat'  => esc_html__( 'Current Category', 'et_builder' ),
              'related'   => esc_html__( 'Related Products', 'et_builder' ),
              'upsell'  => esc_html__( 'Up-Sell Products', 'et_builder' ),
              'crosssell'  => esc_html__( 'Cross-Sell Products', 'et_builder' ),
            ),
            'default' => 'default',
            'description'       => esc_html__( 'Choose related or up-sell if you want to use these as the carousel, if not leave as default.', 'et_builder' ),
          ),


          'show_hidden_prod' => array(
            'toggle_slug'       => 'main_content',
              'label'             => esc_html__( 'Show Hidden Products?', 'et_builder' ),
              'type'              => 'yes_no_button',
              'options'           => array(
                'on'  => esc_html__( 'Yes', 'et_builder' ),
                'off' => esc_html__( 'No', 'et_builder' ),
              ),
              'default'           => 'off',
          ),
          'posts_number' => array(
                'label'             => esc_html__( 'Posts Number', 'divi-bodyshop-woocommerce' ),
                'type'              => 'text',
          'toggle_slug'       => 'main_content',
                'depends_show_if'   => 'on',
                'description'       => esc_html__( 'Choose how many posts you would like to display per page.', 'divi-bodyshop-woocommerce' ),
            ),
          'sort_order' => array(
            'toggle_slug'       => 'main_content',
              'label'             => esc_html__( 'What do you want to sort your products by?', 'divi-bodyshop-woocommerce' ),
              'type'              => 'select',
              'options'           => array(
              'date' => sprintf( esc_html__( 'Date', 'divi-bodyshop-woocommerce' ) ),
              'title' => esc_html__( 'Title', 'divi-bodyshop-woocommerce' ),
              'ID' => esc_html__( 'ID', 'divi-bodyshop-woocommerce' ),
              'rand' => esc_html__( 'Random', 'divi-bodyshop-woocommerce' ),
              'menu_order' => esc_html__( 'Menu Order', 'divi-bodyshop-woocommerce' ),
              'name' => esc_html__( 'Name', 'divi-bodyshop-woocommerce' ),
              'modified' => esc_html__( 'Modified', 'divi-bodyshop-woocommerce' ),
              ),
              'depends_show_if'   => 'on',
              'default' => 'date',
              'description'       => esc_html__( 'Choose what you want to sort the product by.', 'divi-bodyshop-woocommerce' ),
            ),
            'order_asc_desc' => array(
            'toggle_slug'       => 'main_content',
              'label'             => esc_html__( 'Sort Order', 'divi-bodyshop-woocommerce' ),
              'type'              => 'select',
              'options'           => array(
                'ASC' => esc_html__( 'Ascending', 'divi-bodyshop-woocommerce' ),
                'DESC' => sprintf( esc_html__( 'Descending', 'divi-bodyshop-woocommerce' ) ),
              ),
              'depends_show_if'   => 'on',
              'default' => 'ASC',
              'description'       => esc_html__( 'Choose the sort order of the products.', 'divi-bodyshop-woocommerce' ),
            ),

          'posts_number_desktop' => array(
          				'default'           => 5,
          				'label'             => esc_html__( 'Desktop Images Number in view', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'       => 'carousel_settings',
          			),
          			'posts_number_desktop_slide' => array(
          				'default'           => 1,
          				'label'             => esc_html__( 'Desktop Images Number to Slide', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'       => 'carousel_settings',
          			),
          			'posts_number_tablet' => array(
          				'default'           => 4,
          				'label'             => esc_html__( 'Tablet Portrait Images Number in view', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'       => 'carousel_settings',
          			),
          			'posts_number_slide_tablet' => array(
          				'default'           => 1,
          				'label'             => esc_html__( 'Tablet Portrait Images Number to Slide', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'       => 'carousel_settings',
          			),
          			'posts_number_tablet_land' => array(
          				'default'           => 3,
          				'label'             => esc_html__( 'Tablet Landscape Images Number in view', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'       => 'carousel_settings',
          			),
          			'posts_number_slide_tablet_land' => array(
          				'default'           => 1,
          				'label'             => esc_html__( 'Tablet Landscape Images Number to Slide', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'       => 'carousel_settings',
          			),
          			'posts_number_mobile' => array(
          				'default'           => 1,
          				'label'             => esc_html__( 'Mobile Images Number in view', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'       => 'carousel_settings',
          			),
          			'posts_number_slide_mobile' => array(
          				'default'           => 1,
          				'label'             => esc_html__( 'Mobile Images Number to Slide', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'       => 'carousel_settings',
          			),
          			'carousel_spacing' => array(
          				'default'           => 10,
          				'label'             => esc_html__( 'Spacing between slides', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Define the number between each slides in pixels.', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'       => 'carousel_settings',
          			),
                'left_icon' => array(
                'default'           => "34",
                'label'             => esc_html__( 'Left Icon Code', 'divi-bodyshop-woocommerce' ),
                'type'              => 'text',
                'option_category'   => 'configuration',
                'description'       => esc_html__( 'Set the icon code by going to https://www.elegantthemes.com/blog/resources/elegant-icon-font and scroll down till you see the icons. Input the code that appears after the "x"', 'divi-bodyshop-woocommerce' ),
                'toggle_slug'         => 'carousel_settings',
              ),
              'right_icon' => array(
                'default'           => "35",
                'label'             => esc_html__( 'Right Icon Code', 'divi-bodyshop-woocommerce' ),
                'type'              => 'text',
                'option_category'   => 'configuration',
                'description'       => esc_html__( 'Set the icon code by going to https://www.elegantthemes.com/blog/resources/elegant-icon-font and scroll down till you see the icons. Input the code that appears after the "x"', 'divi-bodyshop-woocommerce' ),
                'toggle_slug'         => 'carousel_settings',
              ),
          			'arrows_color' => array(
          				'label'             => esc_html__( 'Arrows Color', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'color-alpha',
          				'custom_color'      => true,
          				'toggle_slug'       => 'carousel_settings',
          			),
          			'autoplay_speed' => array(
          				'default'           => "",
          				'label'             => esc_html__( 'Autoplay and delay', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'If you would like it to autoplay - add the delay time of each slide. To remove autoplay - set no text here. Time in milliseconds, example 5 seconds would be "5000".', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'         => 'carousel_settings',
          			),
          			'slide_speed' => array(
          				'default'           => "300",
          				'label'             => esc_html__( 'Slide speed', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'text',
          				'option_category'   => 'configuration',
          				'description'       => esc_html__( 'Set the speed of the slide in milliseconds, for example 1 second will be "1000".', 'divi-bodyshop-woocommerce' ),
          				'toggle_slug'         => 'carousel_settings',
          			),


                'equal_height' => array(
                  'label'             => esc_html__( 'Equal Height Grid Cards', 'divi-bodyshop-woocommerce' ),
                  'type'              => 'yes_no_button',
                  'option_category'   => 'configuration',
                  'toggle_slug'       => 'main_content',
                  'options'           => array(
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                  ),
                  'description' => esc_html__( 'Enable this if you have the grid layout and want all your cards to be the same height.', 'divi-bodyshop-woocommerce' ),
                  ),
                  'align_last_bottom' => array(
                  'toggle_slug'       => 'main_content',
                  'label'             => esc_html__( 'Align last module at the bottom', 'divi-bodyshop-woocommerce' ),
                  'type'              => 'yes_no_button',
                  'options'           => array(
                  'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                  'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                  ),
                  'description'        => esc_html__( 'Enable this to align the last module (probably the add to cart) at the bottom. Works well when using the equal height.', 'divi-bodyshop-woocommerce' ),
                  ),
          'custom_loop' => array(
          				'label'             => esc_html__( 'Custom Loop', 'divi-bodyshop-woocommerce' ),
          				'type'              => 'yes_no_button',
                  'toggle_slug'       => 'main_content',
          				'options'           => array(
          					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
          					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
          				),
          				'affects'=>array(
          					'post_type'
          					, 'include_tags'
          					, 'include_cats'
                    // , '#et_pb_sale_products_only'
          				),
          				'description'        => esc_html__( 'Enable this to create your own loop, you can set the post number and to include products with specific tags only.', 'divi-bodyshop-woocommerce' ),
          			),
                // 'sale_products_only' => array(
                // 				'label'             => esc_html__( 'Sale Products ONLY', 'divi-bodyshop-woocommerce' ),
                // 				'type'              => 'yes_no_button',
                // 				'options'           => array(
                // 					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                // 					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                // 				),
                // 				'description'        => esc_html__( 'Enable this to only show your sale products', 'divi-bodyshop-woocommerce' ),
                // 			),
          			'include_tags' => array(
          				'label'           => esc_html__( 'Include Tags ONLY', 'divi-bodyshop-woocommerce' ),
          				'type'            => 'text',
                  'toggle_slug'       => 'main_content',
          				'depends_show_if'   => 'on',
          				'description'     => esc_html__( 'Add a list of tags that you ONLY want to show. This will remove all products that dont have these tags. (comma-seperated)', 'divi-bodyshop-woocommerce' ),
          			),
          			'include_cats' => array(
          				'label'           => esc_html__( 'Include Categories ONLY', 'divi-bodyshop-woocommerce' ),
          				'type'            => 'text',
                  'toggle_slug'       => 'main_content',
          				'depends_show_if'   => 'on',
          				'description'     => esc_html__( 'Add a list of categories that you ONLY want to show. This will remove all products that dont have these. (comma-seperated)', 'divi-bodyshop-woocommerce' ),
          			),
                            'admin_label' => array(
                                'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                                'type'        => 'text',
                                'toggle_slug'     => 'carousel_settings',
                                'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                            ),
                '__getprocarousel' => array(
                  'type' => 'computed',
                  'computed_callback' => array( 'db_product_carousel_code', 'get_product_carousel_code' ),
                  'computed_depends_on' => array(
                    'admin_label'
                  ),
                ),
    		);

    		return $fields;
    	}


      public static function get_product_carousel_code ( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}


        $shop = "<div class='no-html-output'><p>We do not have compatibility for the carousel yet. We are working on this still. It will still work as expected on the front-end, you will just not get a live preview.</p></div>";

        return $shop;

      }

    function render( $attrs, $content = null, $render_slug ) {

        if (is_admin()) {
            return;
        }

        $background_layout = '';
        $loop_layout           = $this->props['loop_layout'];

        $link_whole_gird           = $this->props['link_whole_gird'];


        $module_id           = $this->props['module_id'];
        $module_class        = $this->props['module_class'];


        $include_tags      = $this->props['include_tags'];
        $include_cats     = $this->props['include_cats'];
        $posts_number      = $this->props['posts_number'];
        $custom_loop        = $this->props['custom_loop'];
        // $sale_products_only       = $this->props['sale_products_only'];

        $left_icon             = $this->props['left_icon']; // Left Icon
        $right_icon            = $this->props['right_icon']; // Right Icon
        $autoplay_speed           = $this->props['autoplay_speed']; // autoplay_speed
        $slide_speed           = $this->props['slide_speed']; // slide_speed
        $arrows_color       = $this->props['arrows_color'];   //Arrows Color

        $posts_number_desktop          = $this->props['posts_number_desktop'];                           // desktop number
        $posts_number_desktop_slide        = $this->props['posts_number_desktop_slide'];                 // desktop number slides
        $posts_number_tablet          = $this->props['posts_number_tablet'];                             // tablet number
        $posts_number_slide_tablet          = $this->props['posts_number_slide_tablet'];                 // tablet number slides
        $posts_number_tablet_land          = $this->props['posts_number_tablet_land'];                   // tablet landscape number
        $posts_number_slide_tablet_land          = $this->props['posts_number_slide_tablet_land'];       // tablet landscape number slides
        $posts_number_mobile          = $this->props['posts_number_mobile'];                             // mobile number
        $posts_number_slide_mobile          = $this->props['posts_number_slide_mobile'];                 // mobile number slides

        $featured_only              = $this->props['featured_only'];
        $popular_only              = $this->props['popular_only'];

        $on_sale_only               = $this->props['on_sale_only'];
        $new_only                   = $this->props['new_only'];
        $new_time                   = $this->props['new_time'];

        $hide_non_purchasable              = $this->props['hide_non_purchasable'];


        $show_hidden_prod 		= $this->props['show_hidden_prod'];
        $sort_order       = $this->props['sort_order'];
        $order_asc_desc        = $this->props['order_asc_desc'];
        $carousel_type              = $this->props['carousel_type'];

        $carousel_spacing              = $this->props['carousel_spacing'];


        $equal_height 		= $this->props['equal_height'];
        $align_last_bottom 		= $this->props['align_last_bottom'];

        $num = mt_rand(100000,999999);
        $css_class              = $render_slug . "_" . $num;

        global $paged;


        $container_is_closed = false;



        wp_enqueue_script( 'bodycommmerce-carousel-js',  DE_DB_WOO_URL . '/scripts/carousel.min.js', array(), DE_DB_WOO_VERSION, true );
        wp_enqueue_style( 'bodycommmerce-carousel-css', DE_DB_WOO_URL . '/styles/carousel.min.css', array(), DE_DB_WOO_VERSION );


        $output = sprintf(
            '<div class="'.$css_class.' et_pb_carousel_wrapper products">'
        );



        if ( $equal_height == 'on' ) {
            $this->add_classname('same-height-cards');
        }
        if ( $align_last_bottom == 'on' ) {
            $this->add_classname('align-last-module');
        }

        // include categories
        // if ($include_cats != "") {
        //    $args = array( 'product_cat' => $include_cats );
        // }
        // else {
        //   $include_cats_display = "";
        //   }

        $mydata = get_option( 'divi-bodyshop-woo_options' );
        $mydata = unserialize($mydata);
        if ( isset( $mydata['settings_disable_carousel_feature'] ) && $mydata['settings_disable_carousel_feature'] == "1" ) {

            if ($custom_loop == 'on') {

                $args = array(
                    'posts_per_page'    => (int) $posts_number,
                    'post_type'         => 'product',
                    'orderby'           => $sort_order,
                    'order'             => $order_asc_desc,
                    'post_status'       => 'publish'
                );

                // include tags
                if ($include_tags != "") {
                    $args = array(
                        'product_tag'       => $include_tags,
                        'posts_per_page'    => (int) $posts_number,
                        'orderby'           => $sort_order,
                        'order'             => $order_asc_desc,
                        'post_type'         => 'product',
                        'post_status'       => 'publish'
                    );
                }else {
                }
                
                // include categories
                if ($include_cats != "") {

                    if ($featured_only == "on") {
                        $customclass = "featured-products";
                        $tax_query[] = array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                            'operator' => 'IN',
                        );

                        $args = array(
                            'product_cat'       => $include_cats,
                            'posts_per_page'    => (int) $posts_number,
                            'orderby'           => $sort_order,
                            'order'             => $order_asc_desc,
                            'post_type'         => 'product',
                            'tax_query'         => $tax_query,
                            'post_status'       => 'publish'
                        );
                    }else if ($popular_only == "on") {
                        $customclass = "popular-products";
                        $args = array(
                            'product_cat'       => $include_cats,
                            'posts_per_page'    => (int) $posts_number,
                            'post_type'         => 'product',
                            'orderby'           => $sort_order,
                            'order'             => $order_asc_desc,
                            'post_status'       => 'publish',
                            'meta_key'          => 'total_sales',
                            'orderby'           => 'meta_value_num',
                        );

                    }else if ($on_sale_only == "on") {
                        $customclass = "onsale-products";
                        $products_on_sale = wc_get_product_ids_on_sale();

                        $args = array(
                            'posts_per_page'    =>  (int) $posts_number,
                            'product_cat'       => $include_cats,
                            'post_type'         => 'product',
                            'post_status'       => 'publish',
                            'post__in'          => $products_on_sale,
                            'orderby'           => $sort_order,
                            'order'             => $order_asc_desc
                        );
                    
                    }else if ($new_only == "on") {
                        $customclass = "new-products";
                        $args = array(
                            'posts_per_page'    =>  (int) $posts_number,
                            'product_cat'       => $include_cats,
                            'post_type'         => 'product',
                            'date_query'        => array(
                                array(
                                    'after'     => '-'.$new_time.' days',
                                    'column'    => 'post_date',
                                ),
                            ),
                            'post_status'       => 'publish',
                            'orderby'           => $sort_order,
                            'order'             => $order_asc_desc
                        );

                    } else {
                        $args = array(
                            'product_cat'       => $include_cats,
                            'posts_per_page'    => (int) $posts_number,
                            'orderby'           => $sort_order,
                            'order'             => $order_asc_desc,
                            'post_type'         => 'product',
                            'post_status'       => 'publish'
                        );
                    }
                }else {
                }

                if ( is_single() && ! isset( $args['post__not_in'] ) ) {
                    $args['post__not_in'] = array( get_the_ID() );
                }

                $args = apply_filters('db_carosel_module_args', $args);
                query_posts( $args );

            }else {
                if ($carousel_type == "default") {
                    if ($featured_only == "on") {
                        $customclass = "featured-products";
                        $tax_query[] = array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'name',
                            'terms'    => 'featured',
                            'operator' => 'IN',
                        );
                        $args = array(
                            'posts_per_page'    => (int) $posts_number,
                            'post_type'         => 'product',
                            'post_status'       => 'publish',
                            'tax_query'         => $tax_query,
                            'orderby'           => $sort_order,
                            'order'             => $order_asc_desc,
                        );
                    }else if ($popular_only == "on") {
                        $customclass = "popular-products";
                        $args = array(
                            'posts_per_page'    => (int) $posts_number,
                            'post_type'         => 'product',
                            'post_status'       => 'publish',
                            'orderby'           => $sort_order,
                            'order'             => $order_asc_desc,
                            'meta_key'          => 'total_sales',
                            'orderby'           => 'meta_value_num',
                        );
                    } else {
                        $args = array(
                            'post_type'         => 'product',
                            'post_status'       => 'publish',
                            'orderby'           => $sort_order,
                            'order'             => $order_asc_desc,
                            'posts_per_page'    => '-1',
                        );
                    }

                    if ($show_hidden_prod == "off") {
                        $args['tax_query'] = array(
                            array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'name',
                                'terms'    => 'exclude-from-catalog',
                                'operator' => 'NOT IN',
                            ),
                        );
                    } else {

                        if ($featured_only == "on") {
                        } else {
                        
                            if ( ! empty( $product_visibility_not_in ) ) {
                                $tax_query[] = array(
                                    'taxonomy' => 'product_visibility',
                                    'field'    => 'term_taxonomy_id',
                                    'terms'    => $product_visibility_not_in,
                                    'operator' => 'NOT IN',
                                );
                            }
                        }
                    }
                } else if ($carousel_type == "current-cat") {
                    $category = get_queried_object();
                    $cpt_cat = $category->term_id;

                    if ($featured_only == "on") {
                        $customclass = "featured-products";
                        $args = array(
                            'posts_per_page' => (int) $posts_number,
                            'post_type'   => 'product',
                            'post_status'    => 'publish',
                            'tax_query'           => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'term_id',
                                    'terms'    => $cpt_cat,
                                ),
                                array(
                                    'taxonomy' => 'product_visibility',
                                    'field'    => 'name',
                                    'terms'    => 'featured',
                                    'operator' => 'IN',
                                ),
                            ),
                            'orderby'        => $sort_order,
                            'order' => $order_asc_desc,
                        );
                    }else if ($popular_only == "on") {
                        $customclass = "popular-products";
                        $args = array(
                            'posts_per_page' => (int) $posts_number,
                            'post_type'   => 'product',
                            'post_status'    => 'publish',
                            'orderby'        => $sort_order,
                            'order' => $order_asc_desc,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'term_id',
                                    'terms'    => $cpt_cat,
                                ),
                            ),
                            'meta_key' => 'total_sales',
                            'orderby' => 'meta_value_num',
                        );
                    } else {
                        $args = array(
                            'post_type'             => 'product',
                            'post_status'           => 'publish',
                            'orderby'        => $sort_order,
                            'order' => $order_asc_desc,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field'    => 'term_id',
                                    'terms'    => $cpt_cat,
                                ),
                            ),
                            'posts_per_page' => (int) $posts_number,
                        );
                    }

                    if ($show_hidden_prod == "off") {
                        $args['tax_query'] = array(
                            array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'name',
                                'terms'    => 'exclude-from-catalog',
                                'operator' => 'NOT IN',
                            ),
                        );
                    } else {
                        if ($featured_only == "on") {
                        } else {
                            if ( ! empty( $product_visibility_not_in ) ) {
                                $tax_query[] = array(
                                    'taxonomy' => 'product_visibility',
                                    'field'    => 'term_taxonomy_id',
                                    'terms'    => $product_visibility_not_in,
                                    'operator' => 'NOT IN',
                                );
                            }
                        }
                    }
                } else if ($carousel_type == "related") {
                    
                    global $post;

                    $tax_array[] = "";

                    $cats = wp_get_post_terms( $post->ID, "product_cat" );
                    foreach ( $cats as $cat ) {
                        $tax_array[] = $cat->term_id;
                    }

                    $tags = wp_get_post_terms( $post->ID, "product_tag" );
                    foreach ( $tags as $tag ) {
                        $tax_array[] = $tag->term_id;
                    }

                    // RELATED

                    $args = array(
                        'post_type'             => 'product',
                        'post_status'           => 'publish',
                        'posts_per_page'      =>  (int) $posts_number,
                        'orderby'        => $sort_order,
                        'order' => $order_asc_desc,
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'name',
                                'terms'    => 'exclude-from-catalog',
                                'operator' => 'NOT IN',
                            ),
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'id',
                                'terms' => $tax_array
                            )
                        )
                    );
                } else if ($carousel_type == "crosssell") {

                    global $post, $product, $woocommerce;
                    $crosssel_ids = array();
                    $items = $woocommerce->cart->get_cart();
        
                    foreach ( $items as $item ) {
                        $check_cross = get_post_meta( $item['product_id'], '_crosssell_ids', true );
                        if ($check_cross == "") {
                        }else {
                            $crosssel_ids = array_unique( array_merge( get_post_meta( $item['product_id'], '_crosssell_ids', true ), $crosssel_ids )) ;
                        }
                    }

                    if( !empty( $crosssel_ids ) ) {

                        $args = array(
                            'post_type'             => 'product',
                            'post_status'           => 'publish',
                            'orderby'        => $sort_order,
                            'order' => $order_asc_desc,
                            'posts_per_page'      => $to_show,
                            'post__in'            => $crosssel_ids
                        );

                        if ( is_single() && ! isset( $args['post__not_in'] ) ) {
                            $args['post__not_in'] = array( get_the_ID() );
                        }

                        if ($out_of_stock == "off" || $out_of_stock == "") {
                            $args['meta_query'] = array (
                                array(
                                    'key' => '_stock_status',
                                    'value' => 'outofstock',
                                    'compare' => '!=',
                                )
                            );
                        }
                    } else {
                        return;
                    }
                } else {
                    // UP SELL
                    global $post;

                    $product = new WC_Product($post->ID);
                    $upsells = $product->get_upsell_ids();

                    if(empty($upsells)){
                        return;
                    }

                    $upsell_list =  join(",",$upsells);

                    $upsell_array = array_map( 'trim', explode( ',', $upsell_list ) );

                    if(empty($upsell_array)){
                        return;
                    }

                    $args = array(
                        'post_type'             => 'product',
                        'post_status'           => 'publish',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'name',
                                'terms'    => 'exclude-from-catalog',
                                'operator' => 'NOT IN',
                            ),
                        ),
                        'posts_per_page'      =>  (int) $posts_number,
                        'post__in'            => $upsell_array
                    );
                }

                if ( is_single() && ! isset( $args['post__not_in'] ) ) {
                    $args['post__not_in'] = array( get_the_ID() );
                }

                query_posts( $args );
            }
        } else {
            $args = array(
                'posts_per_page'    => (int) $posts_number,
                'post_type'         => 'product',
                'orderby'           => $sort_order,
                'order'             => $order_asc_desc,
                'post_status'       => 'publish'
            );

            if ($featured_only == "on") {
                $customclass = "featured-products";
                $tax_query[] = array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                );

                $args['tax_query'] = $tax_query;
            }       
            if ($on_sale_only == "on") {
                $customclass = "onsale-products";
                $products_on_sale = wc_get_product_ids_on_sale();
                $args['post__in'] = $products_on_sale;            
            }
            if ($new_only == "on") {
                $customclass = "new-products";
                $args['date_query'] = array(
                    array(
                        'after'     => '-'.$new_time.' days',
                        'column'    => 'post_date',
                    )
                );
            }

            $product_visibility_terms  = wc_get_product_visibility_term_ids();
            $product_visibility_not_in = array( is_search() && $main_query ? $product_visibility_terms['exclude-from-search'] : $product_visibility_terms['exclude-from-catalog'] );
            if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
              $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
            }

            if ($show_hidden_prod == "off") {

                if ( ! empty( $product_visibility_not_in ) ) {
                    $args['tax_query'][] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'term_taxonomy_id',
                        'terms'    => $product_visibility_not_in,
                        'operator' => 'NOT IN',
                    );
                    if ( $featured_only == "on" ){
                        $args['tax_query']['relation'] = 'AND';
                    }
                }
            }

            if ( $custom_loop == 'on' ){
                if ($include_tags != "") {
                    $args['product_tag'] = $include_tags;
                }

                if ($include_cats != "") {
                    $args['product_cat'] = $include_cats;
                }
            }else{
                if ( $carousel_type == "current-cat" ){
                    $category = get_queried_object();
                    $cpt_cat = $category->term_id;

                    $args['tax_query']['relation'] = 'AND';
                    $args['tax_query'][] = array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $cpt_cat,
                    );
                } else if ( $carousel_type == "related" ) {
                    
                    global $post;

                    $cat_array = array();
                    $tag_array = array();

                    $cats = wp_get_post_terms( $post->ID, "product_cat" );
                    foreach ( $cats as $cat ) {
                        $cat_array[] = $cat->term_id;
                    }

                    $tags = wp_get_post_terms( $post->ID, "product_tag" );
                    foreach ( $tags as $tag ) {
                        $tag_array[] = $tag->term_id;
                    }

                    // RELATED
                    $args['tax_query'][] = array(
                        'relation' => 'OR',
                        array(
                            'taxonomy'  => 'product_cat',
                            'field'     => 'id',
                            'terms'     => $cat_array,
                            'operator'  => 'IN'
                        ),
                        array(
                            'taxonomy'  => 'product_tag',
                            'field'     => 'id',
                            'terms'     => $tag_array,
                            'operator'  => 'IN'
                        )
                    );
                } else if ( $carousel_type == "crosssell" ) {
                    global $post, $product, $woocommerce;
                    $crosssel_ids = array();
                    $items = $woocommerce->cart->get_cart();
        
                    foreach ( $items as $item ) {
                        $check_cross = get_post_meta( $item['product_id'], '_crosssell_ids', true );
                        if ($check_cross == "") {
                        }else {
                            $crosssel_ids = array_unique( array_merge( get_post_meta( $item['product_id'], '_crosssell_ids', true ), $crosssel_ids )) ;
                        }
                    }

                    if ( !empty( $args['post__in'] ) ){
                        $new_ids = array_intersect( $args['post__in'], $crosssel_ids );
                    }else{
                        $new_ids = $crosssel_ids;
                    }

                    if( !empty( $new_ids ) ) {
                        $args['post__in'] = $new_ids;
                    } else {
                        return;
                    }
                } else if ( $carousel_type == "upsell" ) {
                    global $post;

                    $product = new WC_Product($post->ID);
                    $upsells = $product->get_upsell_ids();

                    if(empty($upsells)){
                        return;
                    }

                    $upsell_list =  join(",", $upsells);

                    $upsell_array = array_map( 'trim', explode( ',', $upsell_list ) );

                    if(empty($upsell_array)){
                        return;
                    }

                    if ( !empty( $args['post__in'] ) ){
                        $new_ids = array_intersect( $args['post__in'] , $upsell_array );
                    }else{
                        $new_ids = $upsell_array;
                    }

                    if ( !empty( $new_ids ) ){
                        $args['post__in'] = $new_ids;    
                    }else{
                        return;
                    }                    
                }
            }

                // POPULAR
                if ($popular_only == "on") {
                    $customclass = "popular-products";
                    $args['meta_key'] = 'total_sales';
                    $args['orderby']  = 'meta_value_num';
                    $args['order']  = 'desc';
                }

            if ( is_single() && ! isset( $args['post__not_in'] ) ) {
                $args['post__not_in'] = array( get_the_ID() );
            }

            $args = apply_filters('db_carosel_module_args', $args);
            query_posts( $args );
        }

        // $products = new WP_Query($args);

        ob_start();

        if ( have_posts() ) {

            while ( have_posts() ) {
                the_post();
                global $product;
                $post_link = get_permalink(get_the_ID());

                if ($hide_non_purchasable == "on" && $product->is_purchasable() === false) {

                } else {

                    if ($link_whole_gird == "on") {
                        ?>
                        <div class="bc-link-whole-grid-card" data-link-url="<?php echo $post_link ?>">
                        <?php   
                      }

                      echo '<div class="product-wrapper">';
                      echo apply_filters('the_content', get_post_field('post_content', $loop_layout));
                      echo '</div>';

                    if ($link_whole_gird == "on") {
                        ?>
                        </div>  
                        <?php       
                      }
                }
            }

            wp_reset_query();
        }

        $output .= ob_get_contents();
        ob_end_clean();

        $output .= '</div>';

        if ($autoplay_speed != "") {
            $autospeed = $autoplay_speed;
            $autoplay = "autoplay: true,";
        }else {
            $autospeed = "0";
            $autoplay = "autoplay: false,";
        }

        $output .= 
            '<script>
                jQuery(document).ready(function($){
                    $(".'.$css_class.'.et_pb_carousel_wrapper").slick({
                        dots: false,
                        infinite: true,
                        slidesToShow: '.$posts_number_desktop.',
                        slidesToScroll:'.$posts_number_desktop_slide.',
                        '.$autoplay.'
                        autoplaySpeed: '.$autospeed.',
                        responsive: [
                            {
                                breakpoint: 1030,
                                settings: {
                                    slidesToShow: '.$posts_number_tablet.',
                                    slidesToScroll: '.$posts_number_slide_tablet.',
                                } 
                            },
                            {
                                breakpoint: 980,
                                settings: {
                                    slidesToShow: '.$posts_number_tablet_land.',
                                    slidesToScroll: '.$posts_number_slide_tablet_land.'
                                } 
                            },
                            {
                                breakpoint: 580,
                                settings: {
                                    slidesToShow: '.$posts_number_mobile.',
                                    slidesToScroll: '.$posts_number_slide_mobile.'
                                } 
                            }
                        ]
                    });
                });
            </script>';

        $css_styles = '<style id="bodycommerce-'.$css_class.'-carousel-custom-css">';
        $css_styles .= sprintf(
            '<style>
                .test {
                    display: none;
                }
                .%4$s.et_pb_carousel_wrapper .slick-prev::before {
                    font-family: ETmodules !important;
                    content: "\%1$s";
                    left: -22px;
                }
                .%4$s.et_pb_carousel_wrapper .slick-next::before {
                    font-family: ETmodules !important;
                    content: "\%2$s";
                    right: -22px;
                }
                .%4$s.et_pb_carousel_wrapper .slick-prev {
                    left: -50px;
                    z-index: 99999999999999999;
                }
                .%4$s.et_pb_carousel_wrapper .slick-next {
                    right: -50px;
                    z-index: 99999999999999999;
                }

                .%4$s.et_pb_carousel_wrapper .slick-next::before, .%4$s.et_pb_carousel_wrapper .slick-prev::before {
                    font-size: 57px;
                    opacity: 1;
                    top: -22px;
                    text-shadow: 0px 0px 9px rgba(150, 150, 150, 1);
                    color: %3$s;
                }
                .%4$s.et_pb_carousel_wrapper .slick-slide {
                    margin: 0 %5$spx;
                }
                .%4$s.et_pb_carousel_wrapper .slick-list {
                    margin: 0 -%5$spx;
                }
            </style>',
            $left_icon,
            $right_icon,
            $arrows_color,
            $css_class,
            $carousel_spacing
        );

        $css_styles .= '</style>';
        //minify it
        $css_styles_min = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_styles );
        $output .= $css_styles_min; // phpcs:ignore

        if( isset($customclass) ){
            $this->add_classname( $customclass );
        }

        return $output;

    }
}

new db_product_carousel_code;

?>
