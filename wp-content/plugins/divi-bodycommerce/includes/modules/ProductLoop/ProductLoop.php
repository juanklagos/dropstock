<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_shop_loop_code extends ET_Builder_Module {

    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => DE_DB_PRODUCT_URL,
        'author'     => DE_DB_AUTHOR,
        'author_uri' => DE_DB_URL,
    );

    function init() {
        $this->name       = esc_html__( '.ARP Product Loop - Archive Pages', 'divi-bodyshop-woocommerce' );
        $this->slug = 'et_pb_db_shop_loop';


        $this->fields_defaults = array(
            'cat_loop_style'        => array( 'off' ),
            'fullwidth'             => array( 'list' ),
            'columns'               => array( '3' ),
            'show_pagination'       => array( 'on' ),
            'show_add_to_cart'      => array( 'on' ),
            'show_sorting_menu'     => array( 'off' ),
            'show_results_count'    => array( 'off' ),
        );

        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'main_content'      => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
                    'custom_content'    => esc_html__( 'Custom Layout Options', 'divi-bodyshop-woocommerce' ),
                    'default_content'   => esc_html__( 'Default Style Options', 'divi-bodyshop-woocommerce' ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'text'      => esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
                    'overlay'   => esc_html__( 'Overlay', 'divi-bodyshop-woocommerce' ),
                    'product'   => esc_html__( 'Product', 'et_builder' ),
                ),
            ),
        );


        $this->main_css_element = '%%order_class%%';


        $this->advanced_fields = array(
            'fonts' => array(
                'title' => array(
                    'label'    => esc_html__( 'Default Layout - Title', 'divi-bodyshop-woocommerce' ),
                    'css'      => array(
                        'main' => "%%order_class%% ul.products li.product .woocommerce-loop-product__title",
                        'important' => 'plugin_only',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1em',
                    ),
                ),
                'price' => array(
                    'label'    => esc_html__( 'Default Layout - Price', 'divi-bodyshop-woocommerce' ),
                    'css'      => array(
                        'main' => "%%order_class%% ul.products li.product .price, %%order_class%% ul.products li.product .price .amount",
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'range_settings' => array(
                            'min'  => '1',
                            'max'  => '100',
                            'step' => '1',
                        ),
                        'default' => '1.7em',
                    ),
                ),
                'excerpt' => array(
                    'label'    => esc_html__( 'Default Layout - Excerpt', 'divi-bodyshop-woocommerce' ),
                    'css'      => array(
                        'main' => "%%order_class%% ul.products li.product .woocommerce-product-details__short-description",
                        'important' => 'plugin_only',
                    ),
                    'font_size' => array(
                        'default' => '14px',
                    ),
                    'line_height' => array(
                        'default' => '1em',
                    ),
                ),
                'cattitle' => array(
                    'label'    => esc_html__( 'Default Layout - Category Title', 'divi-bodyshop-woocommerce' ),
                    'css'      => array(
                        'main' => "%%order_class%% ul.products .woocommerce-loop-category__title",
                        'important' => 'all',
                    ),
                ),
                'catcount' => array(
                    'label'    => esc_html__( 'Default Layout - Category Count', 'divi-bodyshop-woocommerce' ),
                    'css'      => array(
                        'main' => "%%order_class%% ul.products .woocommerce-loop-category__title .count",
                        'important' => 'all',
                    ),
                ),
            ),
            'background' => array(
                'settings' => array(
                    'color' => 'alpha',
                ),
            ),
			'button' => array(
				'add_to_cart_button' => array(
					'label' => esc_html__( 'Default Layout - Add To Cart Button', 'divi-bodyshop-woocommerce' ),
					'css' => array(
						'main' => "%%order_class%% ul.products li.product .button",
						'important' => 'all',
					),
					'box_shadow' => array(
						'css' => array(
							'main' => "%%order_class%% ul.products li.product .button",
						),
					),
				),
			),
			'box_shadow' => array(
				'default' => array(),
				'product' => array(
					'label' => esc_html__( 'Default Layout - Product Box Shadow', 'divi-bodyshop-woocommerce' ),
					'css' => array(
						'main' => "%%order_class%% .products .product",
					),
					'option_category' => 'layout',
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'product',
				),
			),
		);


        $this->custom_css_fields = array(
			'product' => array(
				'label'    => esc_html__( 'Default Layout - Product', 'divi-bodyshop-woocommerce' ),
				'selector' => '%%order_class%% li.product',
			),
			'onsale' => array(
				'label'    => esc_html__( 'Default Layout - Onsale', 'divi-bodyshop-woocommerce' ),
				'selector' => '%%order_class%% li.product .onsale',
			),
			'image' => array(
				'label'    => esc_html__( 'Default Layout - Image', 'divi-bodyshop-woocommerce' ),
				'selector' => '%%order_class%% .et_shop_image',
			),
			'overlay' => array(
				'label'    => esc_html__( 'Default Layout - Overlay', 'divi-bodyshop-woocommerce' ),
				'selector' => '%%order_class%% .et_overlay,  %%order_class%% .et_pb_extra_overlay',
			),
			'title' => array(
				'label'    => esc_html__( 'Default Layout - Title', 'divi-bodyshop-woocommerce' ),
				'selector' => '%%order_class%% .woocommerce-loop-product__title',
			),
			'rating' => array(
				'label'    => esc_html__( 'Default Layout - Rating', 'divi-bodyshop-woocommerce' ),
				'selector' => '%%order_class%% .star-rating',
			),
			'price' => array(
				'label'    => esc_html__( 'Default Layout - Price', 'divi-bodyshop-woocommerce' ),
				'selector' => "body.woocommerce {$this->main_css_element} .et_pb_post .et_pb_post_type ul.products li.product .price, {$this->main_css_element} .et_pb_post .et_pb_post_type ul.products li.product .price",
			),
			'price_old' => array(
				'label'    => esc_html__( 'Default Layout - Old Price', 'divi-bodyshop-woocommerce' ),
				'selector' => '%%order_class%% li.product .price del span.amount',
			),
			'excerpt' => array(
				'label'    => esc_html__( 'Default Layout - Product Excerpt', 'divi-bodyshop-woocommerce' ),
				'selector' => '%%order_class%% li.product .woocommerce-product-details__short-description',
			),
			'add_to_cart' => array(
				'label'    => esc_html__( 'Default Layout - Add To Cart Button', 'divi-bodyshop-woocommerce' ),
				'selector' => '%%order_class%% li.product a.button',
			),
		);


        $this->help_videos = array(
            array(
                'id'   => esc_html__( '9EtJRhTf9_o', 'divi-bodyshop-woocommerce' ), // CATEGORY VIDEO
                'name' => esc_html__( 'BodyCommcerce Product Page Template Guide', 'divi-bodyshop-woocommerce' ),
            ),
        );
    }



    function get_fields() {

        $options_posttype = DEBC_INIT::get_divi_post_types();
        $options = DEBC_INIT::get_divi_layouts();

        //////////////////////////////

        $fields = array(
            'cat_loop_style' => array(
                'toggle_slug'       => 'main_content',
                'label'             => esc_html__( 'Loop Style', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'default'           => 'on',
                'option_category'   => 'configuration',
                'affects'=>array(
                    'loop_layout'
                ),
                'computed_affects' => array(
                    '__products',
                ),
                'options' => array(
                    'on' => esc_html__( 'Default', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'Custom Layout', 'divi-bodyshop-woocommerce' ),
                ),
                'description'        => esc_html__( 'Choose the loop style you want, default will result in the normal WooCommerce style but if you want to creare your own one using a loop layout created in the Divi Library, choose custom.', 'divi-bodyshop-woocommerce' ),
            ),
            'loop_layout' => array(
                'toggle_slug'       => 'main_content',
                'label'             => esc_html__( 'Loop Layout', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'depends_show_if'   => 'off',
                'default'           => 'none',
                'options'           => $options,
                'description'       => esc_html__( 'Choose the layout you have made for each product in the loop.', 'divi-bodyshop-woocommerce' ),
            ),
            'show_sorting_menu' => array(
                'label' => esc_html__( 'Show OrderBy Menu', 'divi-bodyshop-woocommerce' ),
                'type' => 'yes_no_button',
                'options_category' => 'configuration',
                'options' => array(
                	'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                	'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'on',
                'description' => esc_html__( 'Show/Hide the sorting dropdown menu in the frontend.', 'divi-bodyshop-woocommerce' ),
                'toggle_slug' => 'main_content',
            ),
            'show_results_count' => array(
                'label' => esc_html__( 'Show Results Count', 'divi-bodyshop-woocommerce' ),
                'type' => 'yes_no_button',
                'options_category' => 'configuration',
                'options' => array(
                    'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'on',
                'description' => esc_html__( 'Show/Hide products count.', 'divi-bodyshop-woocommerce' ),
                'toggle_slug' => 'main_content',
            ),

            'enable_pagination' => array(
                'label'             => esc_html__( 'Enable Pagination', 'divi-bodyshop-woocommerce' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'on',
                'toggle_slug'       => 'main_content',
            ),

            'disable_products_has_cat' => array(
                'label'             => esc_html__( 'Disable products when category has child categories?', 'divi-bodyshop-woocommerce' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'off',
                'toggle_slug'       => 'main_content',
                'description'       => esc_html__( 'Only works on categories. If you are on a category page and the category has sub-categories, you can disable the products to be shown with this setting.', 'divi-bodyshop-woocommerce' ),
            ),

            'equal_height' => array(
                'label'             => esc_html__( 'Equal Height Grid Cards', 'divi-bodyshop-woocommerce' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'affects'           =>array(
                    'equal_height_mob'
                ),
                'description'       => esc_html__( 'Enable this if you have the grid layout and want all your cards to be the same height.', 'divi-bodyshop-woocommerce' ),
                'toggle_slug'       => 'main_content',
            ),

            'equal_height_mob' => array(
                'label'             => esc_html__( 'Equal Height  on mobile?', 'divi-bodyshop-woocommerce' ),
                'type'              => 'yes_no_button',
                'option_category'   => 'configuration',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'default'           => 'off',
                'depends_show_if'   => 'on',
                'description'       => esc_html__( 'We will disable equal height on mobile. If you want it to stay, enable this..', 'divi-bodyshop-woocommerce' ),
                'toggle_slug'       => 'main_content',
            ),

            // 'product_type' => array(
            //     'label' => esc_html__('Type', 'divi-bodyshop-woocommerce'),
            //     'type' => 'select',
            //     'option_category' => 'configuration',
            //     'options' => array(
            //         'original' => esc_html__('Default (ALL)', 'divi-bodyshop-woocommerce'),
            // 				'recent'  => esc_html__( 'Recent Products', 'divi-bodyshop-woocommerce' ),
            // 				'featured' => esc_html__( 'Featured Products', 'divi-bodyshop-woocommerce' ),
            // 				'sale' => esc_html__( 'Sale Products', 'divi-bodyshop-woocommerce' ),
            // 				'best_selling' => esc_html__( 'Best Selling Products', 'divi-bodyshop-woocommerce' ),
            // 				'top_rated' => esc_html__( 'Top Rated Products', 'divi-bodyshop-woocommerce' ),
            //     ),
            //     'default' => 'original',
            //     'toggle_slug'       => 'main_content',
            //     'description' => esc_html__('Choose which type of products you would like to display', 'divi-bodyshop-woocommerce'),
            // ),

            'no_results_layout' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'No Results Layout', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'option_category'   => 'layout',
                'default'           => 'none',
                'options'           => $options,
                'description'       => esc_html__( 'Choose the layout you want to appear when there are no products.', 'divi-bodyshop-woocommerce' ),
            ),
            'hide_non_purchasable' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Hide non purchasable products?', 'divi-bodyshop-woocommerce' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                ),
                'default'            => 'off',
                'description'        => esc_html__( 'If you want to hide non purchasable products, enable this.', 'divi-bodyshop-woocommerce' ),
            ),
            'link_whole_gird' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Link each layout to product', 'divi-bodyshop-woocommerce' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                ),
                'description'        => esc_html__( 'Enable this if you want to link each loop layout to the product. For example if you want the whole "grid card" to link to the product page. NB: You need to have no other links on the loop layout so do not link the image or the title to the product page.', 'divi-bodyshop-woocommerce' ),
            ),
            'align_last_bottom' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Align last module at the bottom', 'divi-bodyshop-woocommerce' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                ),
                'description'        => esc_html__( 'Enable this to align the last module (probably the add to cart) at the bottom. Works well when using the equal height.', 'divi-bodyshop-woocommerce' ),
            ),
            'fullwidth' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Layout', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'option_category'   => 'layout',
                'options'           => array(
                    'list'  => esc_html__( 'List', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'Grid', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'off',
                'affects'=>array(
                    'columns',
                    'columns_tablet',
                    'columns_mobile'
                ),
                'description'        => esc_html__( 'Choose if you want it displayed as a list or a grid layout', 'divi-bodyshop-woocommerce' ),
            ),
            'columns' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Grid Columns', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'option_category'   => 'layout',
                'options'           => array(
                    2  => esc_html__( 'Two', 'divi-bodyshop-woocommerce' ),
                    3 => esc_html__( 'Three', 'divi-bodyshop-woocommerce' ),
                    4 => esc_html__( 'Four', 'divi-bodyshop-woocommerce' ),
                    5 => esc_html__( 'Five', 'divi-bodyshop-woocommerce' ),
                    6 => esc_html__( 'Six', 'divi-bodyshop-woocommerce' ),
                ),
                'depends_show_if' => 'off',
                'description'        => esc_html__( 'How many columns do you want to see', 'divi-bodyshop-woocommerce' ),
            ),
            'columns_tablet' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Tablet Grid Columns', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'option_category'   => 'layout',
                'default'   => '2',
                'options'           => array(
                    1  => esc_html__( 'One', 'divi-bodyshop-woocommerce' ),
                    2  => esc_html__( 'Two', 'divi-bodyshop-woocommerce' ),
                    3 => esc_html__( 'Three', 'divi-bodyshop-woocommerce' ),
                    4 => esc_html__( 'Four', 'divi-bodyshop-woocommerce' ),
                ),
                'depends_show_if' => 'off',
                'description'        => esc_html__( 'How many columns do you want to see on tablet', 'divi-bodyshop-woocommerce' ),
            ),
            'columns_mobile' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Mobile Grid Columns', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'option_category'   => 'layout',
                'default'   => '1',
                'options'           => array(
                    1  => esc_html__( 'One', 'divi-bodyshop-woocommerce' ),
                    2  => esc_html__( 'Two', 'divi-bodyshop-woocommerce' ),
                ),
                'depends_show_if'   => 'off',
                'description'       => esc_html__( 'How many columns do you want to see on mobile', 'divi-bodyshop-woocommerce' ),
            ),
            // 'sort_order' => array(
            // 'label'             => esc_html__( 'Product Sort Order', 'divi-bodyshop-woocommerce' ),
            // 'type'              => 'select',
            // 'options'           => array(
            // "default"  => esc_html__( 'Default', 'divi-bodyshop-woocommerce' ),
            // "name"  => esc_html__( 'Name', 'divi-bodyshop-woocommerce' ),
            // "popularity" => esc_html__( 'Popularity', 'divi-bodyshop-woocommerce' ),
            // "rating" => esc_html__( 'Averagez Rating', 'divi-bodyshop-woocommerce' ),
            // "recent" => esc_html__( 'Most Recent', 'divi-bodyshop-woocommerce' ),
            // "price_asc" => esc_html__( 'Price Asc', 'divi-bodyshop-woocommerce' ),
            // "price_desc" => esc_html__( 'Price Desc', 'divi-bodyshop-woocommerce' ),
            // "random" => esc_html__( 'Random', 'divi-bodyshop-woocommerce' ),
            // ),
            // 'description'        => esc_html__( 'Select the sort order of the loop', 'divi-bodyshop-woocommerce' ),
            // 'toggle_slug'       => 'main_content',
            // ),
            // 'et_shortcode' => array(
            // 'toggle_slug'       => 'custom_content',
            // 'option_category'   => 'layout',
            // 'label'             => esc_html__( 'ET Shortcode for loop layout', 'divi-bodyshop-woocommerce' ),
            // 'type'              => 'select',
            // 'options'           => array(
            // 'et_pb_row'  => esc_html__( 'et_pb_row', 'divi-bodyshop-woocommerce' ),
            // 'et_pb_section' => esc_html__( 'et_pb_section', 'divi-bodyshop-woocommerce' ),
            // ),
            // 'default' => 'et_pb_row',
            // 'description'        => esc_html__( 'Choose what you want the loop layout shortcode to be. By default the row will be fine but if you have this module inside a speciality section it can cause issues with the html structure - so change it to be the section to see.', 'divi-bodyshop-woocommerce' ),
            // ),
            'custom_loop' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Custom Loop Query', 'divi-bodyshop-woocommerce' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                ),
                'affects'=>array(
                    'post_type',
                    'post_type_choose', 
                    'posts_number', 
                    'include_tags', 
                    'include_cats', 
                    'featured_only', 
                    'popular_only', 
                    'on_sale_only', 
                    'outofstock_only', 
                    'new_only', 
                    'sort_order', 
                    'order_asc_desc'
                ),
                'description'        => esc_html__( 'Enable this to create your own query, you can set the post number and to include products with specific tags only.', 'divi-bodyshop-woocommerce' ),
            ),
            'post_type_choose' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Post Type', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'options'           => $options_posttype,
                'default'           => 'product',
                'depends_show_if'   => 'on',
                'description'       => esc_html__( 'Choose the post type you want to display', 'divi-bodyshop-woocommerce' ),
            ),
            'posts_number' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Posts Number', 'divi-bodyshop-woocommerce' ),
                'type'              => 'text',
                'depends_show_if'   => 'on',
                'description'       => esc_html__( 'Choose how many posts you would like to display per page. Divi sometimes overrides this. To set it go to Divi > Theme Options and change the value "Number of Products displayed on WooCommerce archive pages"', 'divi-bodyshop-woocommerce' ),
            ),
            'include_cats' => array(
                'toggle_slug'       => 'custom_content',
                'label'           => esc_html__( 'Include Categories', 'divi-bodyshop-woocommerce' ),
                'type'            => 'text',
                'depends_show_if'   => 'on',
                'description'     => esc_html__( 'Add a list of categories that you ONLY want to show. This will remove all products that dont have these. (comma-seperated)', 'divi-bodyshop-woocommerce' ),
            ),
            'include_tags' => array(
                'toggle_slug'       => 'custom_content',
                'label'           => esc_html__( 'Include Tags', 'divi-bodyshop-woocommerce' ),
                'type'            => 'text',
                'depends_show_if'   => 'on',
                'description'     => esc_html__( 'Add a list of tags that you ONLY want to show. This will remove all products that dont have these tags. (comma-seperated)', 'divi-bodyshop-woocommerce' ),
            ),
            'featured_only' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Display featured products?', 'et_builder' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'depends_show_if'   => 'on',
            ),
            'popular_only' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Display Most Popular products?', 'et_builder' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'depends_show_if'   => 'on',
            ),
            'on_sale_only' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Display On Sale products?', 'et_builder' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'depends_show_if'   => 'on',
            ),
            'outofstock_only' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Out of Stock products only?', 'et_builder' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'depends_show_if'   => 'on',
            ),
            'new_only' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'New products only?', 'et_builder' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'depends_show_if'   => 'on',
                'affects'=>array(
                    'new_time'
                ),
            ),
            'new_time' => array(
                'toggle_slug'       => 'custom_content',
                'label'           => esc_html__( 'Number of days', 'divi-bodyshop-woocommerce' ),
                'type'            => 'text',
                'depends_show_if'   => 'on',
                'description'     => esc_html__( 'Define the number of days you want to show the products', 'divi-bodyshop-woocommerce' ),
            ),
            'show_hidden_prod' => array(
                'toggle_slug'       => 'custom_content',
                'label'             => esc_html__( 'Show Hidden Products?', 'et_builder' ),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'on'  => esc_html__( 'Yes', 'et_builder' ),
                    'off' => esc_html__( 'No', 'et_builder' ),
                ),
                'depends_show_if'   => 'on',
                'default'           => 'off',
            ),
            'sort_order' => array(
                'toggle_slug'       => 'custom_content',
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
                'toggle_slug'       => 'custom_content',
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

            // DEFAULT
            'display_type' => array(
                'label'             => esc_html__( 'Display Type', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'option_category'   => 'layout',
                'options'           => array(
                    'grid'      => esc_html__( 'Grid', 'divi-bodyshop-woocommerce' ),
                    'list_view' => esc_html__( 'Classic Blog', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'grid',
                'affects' => array(
                    'columns_number',
                ),
                'toggle_slug'       => 'default_content',
            ),
            'columns_number' => array(
                'label'             => esc_html__( 'Columns Number', 'divi-bodyshop-woocommerce' ),
                'type'              => 'select',
                'option_category'   => 'layout',
                'options'           => array(
                    '0' => esc_html__( '-- Default --', 'divi-bodyshop-woocommerce' ),
                    '6' => sprintf( esc_html__( '%1$s Columns', 'divi-bodyshop-woocommerce' ), esc_html( '6' ) ),
                    '5' => sprintf( esc_html__( '%1$s Columns', 'divi-bodyshop-woocommerce' ), esc_html( '5' ) ),
                    '4' => sprintf( esc_html__( '%1$s Columns', 'divi-bodyshop-woocommerce' ), esc_html( '4' ) ),
                    '3' => sprintf( esc_html__( '%1$s Columns', 'divi-bodyshop-woocommerce' ), esc_html( '3' ) ),
                    '2' => sprintf( esc_html__( '%1$s Columns', 'divi-bodyshop-woocommerce' ), esc_html( '2' ) ),
                    '1' => esc_html__( '1 Column', 'divi-bodyshop-woocommerce' ),
                ),
                'computed_affects'  => array(
                    '__products',
                ),
                'depends_show_if'   => 'grid',
                'default'           => '3',
                'description'       => esc_html__( 'Choose how many columns to display. Default is 3.', 'divi-bodyshop-woocommerce' ),
                'toggle_slug'       => 'default_content',
            ),
            'show_rating' => array(
                'label'     => esc_html__( 'Show Rating', 'divi-bodyshop-woocommerce' ),
                'type'      => 'yes_no_button',
                'options_category' => 'configuration',
                'options' => array(
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'on',
                'toggle_slug' => 'default_content',
                'affects' => array(
                    'stars_color',
                ),
            ),
            'show_price' => array(
                'label' => esc_html__( 'Show Price', 'divi-bodyshop-woocommerce' ),
                'type' => 'yes_no_button',
                'options_category' => 'configuration',
                'options' => array(
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'on',
                'toggle_slug' => 'default_content',
            ),
            'show_excerpt' => array(
                'label' => esc_html__( 'Show Excerpt', 'divi-bodyshop-woocommerce' ),
                'type' => 'yes_no_button',
                'options_category' => 'configuration',
                'options' => array(
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                ),
                'toggle_slug' => 'default_content',
                'computed_affects' => array(
                    '__products',
                ),
            ),
            'show_add_to_cart' => array(
                'label' => esc_html__( 'Show Add To Cart Button', 'divi-bodyshop-woocommerce' ),
                'type' => 'yes_no_button',
                'options_category' => 'configuration',
                'options' => array(
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                ),
                'toggle_slug' => 'default_content',
                'computed_affects' => array(
                    '__products',
                ),
            ),
            'sale_badge_color' => array(
                'label'             => esc_html__( 'Sale Badge Color', 'divi-bodyshop-woocommerce' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'toggle_slug'       => 'default_content',
            ),
            'stars_color' => array(
                'label'         => esc_html__( 'Rating Stars Color', 'divi-bodyshop-woocommerce' ),
                'type'          => 'color-alpha',
                'toggle_slug'   => 'default_content',
            ),
            'use_overlay' => array(
                'label' => esc_html__( 'Use Overlay', 'divi-bodyshop-woocommerce' ),
                'type' => 'yes_no_button',
                'options' => array(
                    'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'on',
                'affects' => array(
                    'icon_hover_color',
                    'hover_overlay_color',
                    'hover_icon',
                ),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'overlay',
            ),
            'icon_hover_color' => array(
                'label'             => esc_html__( 'Icon Color', 'divi-bodyshop-woocommerce' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'depends_show_if' 	=> 'on',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'overlay',
            ),
            'hover_overlay_color' => array(
                'label'             => esc_html__( 'Overlay Color', 'divi-bodyshop-woocommerce' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'depends_show_if' 	=> 'on',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'overlay',
            ),
            'hover_icon' => array(
                'label'               => esc_html__( 'Icon Picker', 'divi-bodyshop-woocommerce' ),
                'type'                => 'select_icon',
                'option_category'     => 'configuration',
                'class'               => array( 'et-pb-font-icon' ),
                'default'			  => 'P',
                'depends_show_if'     => 'on',
                'tab_slug'            => 'advanced',
                'toggle_slug'         => 'overlay',
            ),
            'product_background' => array(
                'label'             => esc_html__( 'Product Background', 'divi-bodyshop-woocommerce' ),
                'type'              => 'color-alpha',
                'custom_color'      => true,
                'toggle_slug'       => 'default_content',
            ),
            'product_padding' => array(
                'label'             => esc_html__( 'Product Padding', 'divi-bodyshop-woocommerce' ),
                'type'              => 'range',
                'default'			=> '0px',
                'toggle_slug'       => 'default_content',
            ),
            '__products' => array(
                'type' => 'computed',
                'computed_callback' => array( 'db_shop_loop_code', 'get_products' ),
                'computed_depends_on' => array(
                    'columns_number',
                    'show_add_to_cart',
                    'show_excerpt',
                    'loop_layout',
                    'cat_loop_style',
                    'fullwidth',
                    'include_tags',
                    'include_cats',
                    'posts_number',
                    'custom_loop',
                    'sort_order',
                    'order_asc_desc'
                ),
            ),
        );

        return $fields;
    }


    // GET COMPUTED PRODUCTS
    public static function get_products( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
            return;
        }

        if( isset( $args['cat_loop_style'] ) && $args['cat_loop_style'] == 'on' ){
            global $post, $columns;

            $term 				= false;
            $shortcode_options	= '';
            $post_id 			= bodycommerce_post_id_vb();
            $post 				= get_post( $post_id );
            $columns			= isset( $args['columns_number'] ) && absint( $args['columns_number'] ) > 0 ? absint( $args['columns_number'] ) : 3;

            // columns
            add_filter( 'loop_shop_columns', function($c){
                global $columns;
                return $columns;
            }, 9999 );

            // get the current posts per page
            $limit = 9;

            // add to cart
            if( isset( $args['show_add_to_cart'] ) && $args['show_add_to_cart'] == 'on' ){
                add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 9 );
            }

            if( isset( $args['show_excerpt'] ) && $args['show_excerpt'] == 'on' ){
                add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 8 );
            }

            add_action( 'woocommerce_shop_loop_item_title', array( 'db_shop_loop_code', 'product_details_wrapper_start' ), 0 );
            add_action( 'woocommerce_shop_loop_subcategory_title', array( 'db_shop_loop_code', 'product_details_wrapper_start' ), 0 );
            add_action( 'woocommerce_after_shop_loop_item', array( 'db_shop_loop_code', 'product_details_wrapper_end' ), 10 );
            add_action( 'woocommerce_after_subcategory', array( 'db_shop_loop_code', 'product_details_wrapper_end' ), 10 );
            add_action( 'woocommerce_before_shop_loop_item_title', array( 'db_shop_loop_code', 'product_image_wrapper_start' ), 0 );
            add_action( 'woocommerce_before_subcategory_title', array( 'db_shop_loop_code', 'product_image_wrapper_start' ), 0 );
            add_action( 'woocommerce_before_shop_loop_item_title', array( 'db_shop_loop_code', 'product_image_wrapper_end' ), 20 );
            add_action( 'woocommerce_before_subcategory_title', array( 'db_shop_loop_code', 'product_image_wrapper_end' ), 20 );

            remove_all_actions('woocommerce_after_shop_loop');
            $shortcode = "[products paginate='true' limit='{$limit}' {$shortcode_options}]";
            $shop = do_shortcode( $shortcode );

            return $shop;

        }else if( isset( $args['cat_loop_style'] ) && $args['cat_loop_style'] == 'off' ){
            $shop = "<div class='no-html-output'><p>We do not have compatibility for the custom layout yet, only for the default layout. We are working on this still. It will still work as expected on the front-end, you will just not get a live preview.</p></div>";

            return $shop;

        }

    }

    // END COMPUTED PRODUCTS
    public function change_columns_number( $c ){

        $columns = 3;
        if( absint( $this->columns ) > 0 ){
            $columns = absint( $this->columns );
        }
        return $columns;
    }

    public static function product_details_wrapper_start(){
        echo "<div class='de_db_product_details'>";
    }
    public static function product_details_wrapper_end(){
        echo "</div>";
    }
    public static function product_image_wrapper_start(){
        echo "<div class='de_db_product_image'>";
    }
    public static function product_image_wrapper_end(){
        echo "</div>";
    }

    function render( $attrs, $content = null, $render_slug ) {

        if( is_admin() ){
            return;
        }

        $cat_loop_style         = $this->props['cat_loop_style'];
        $background_layout      = '';
        $loop_layout            = $this->props['loop_layout'];
        $cols                   = $this->props['columns'];
        $columns_tablet         = $this->props['columns_tablet'];
        $columns_mobile         = $this->props['columns_mobile'];
        $module_id              = $this->props['module_id'];
        $module_class           = $this->props['module_class'];
        $fullwidth              = $this->props['fullwidth'];
        // $show_pagination     = $this->props['show_pagination'];
        $include_tags           = $this->props['include_tags'];
        $include_cats           = $this->props['include_cats'];
        $posts_number           = $this->props['posts_number'];
        $custom_loop            = $this->props['custom_loop'];
        $post_type_choose       = $this->props['post_type_choose'];
        $sort_order             = $this->props['sort_order'];
        $order_asc_desc         = $this->props['order_asc_desc'];
        $featured_only          = $this->props['featured_only'];
        $popular_only           = $this->props['popular_only'];
        $on_sale_only           = $this->props['on_sale_only'];
        $outofstock_only        = $this->props['outofstock_only'];
        $link_whole_gird        = $this->props['link_whole_gird'];
        $new_only               = $this->props['new_only'];
        $new_time               = $this->props['new_time'];

        // $product_type        = $this->props['product_type'];

        // DEFAULT
        $display_type		 					= $this->props['display_type'];
        $show_sorting_menu		 				= $this->props['show_sorting_menu'];
        $show_results_count		 				= $this->props['show_results_count'];
        $show_rating        					= $this->props['show_rating'];
        $show_price        						= $this->props['show_price'];
        $show_excerpt            				= $this->props['show_excerpt'];
        $show_add_to_cart        				= $this->props['show_add_to_cart'];
        $enable_pagination         				= $this->props['enable_pagination'];
        $this->columns                 			= $this->props['columns_number'];
        $sale_badge_color        				= $this->props['sale_badge_color'];
        $stars_color      		 				= $this->props['stars_color'];
        $use_overlay        					= $this->props['use_overlay'];
        $icon_hover_color        				= $this->props['icon_hover_color'];
        $hover_overlay_color     				= $this->props['hover_overlay_color'];
        $hover_icon              				= $this->props['hover_icon'];
        $product_background              		= $this->props['product_background'];
        $product_padding              			= $this->props['product_padding'];

        $custom_add_to_cart_button  			= $this->props['custom_add_to_cart_button'];
        $add_to_cart_button_bg_color  			= $this->props['add_to_cart_button_bg_color'];
        $add_to_cart_button_icon 				= $this->props['add_to_cart_button_icon'];
        $add_to_cart_button_icon_placement 		= $this->props['add_to_cart_button_icon_placement'];

        $equal_height_mob 		= $this->props['equal_height_mob'];
        $equal_height 		    = $this->props['equal_height'];
        $align_last_bottom 		= $this->props['align_last_bottom'];
        $hide_non_purchasable 	= $this->props['hide_non_purchasable'];
        // $et_shortcode 		= $this->props['et_shortcode'];
        $disable_products_has_cat = $this->props['disable_products_has_cat'];
        $no_results_layout 		= $this->props['no_results_layout'];
        $show_hidden_prod 		= $this->props['show_hidden_prod'];

        //////////////////////////////////////////////////////////////////////

        if ( $equal_height == 'on' ) {
            $this->add_classname('same-height-cards');
        }
        if ( $align_last_bottom == 'on' ) {
            $this->add_classname('align-last-module');
        }

        ob_start();

        if (is_product_category() && $disable_products_has_cat == "on") {
            global $post;
            $cate = get_queried_object();
            $cateID = $cate->term_id;
            $terms = get_terms('product_cat', array('orderby' => 'ASC', 'parent' => $cateID, ));
            if ($terms) {
                return;
            }
        }

        if ($cat_loop_style == "off") { // CUSTOM LAYOUT

            if( $show_sorting_menu == 'off' ){
                remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
            }
            if( $show_results_count == 'off' ){
                remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
            }

            global $paged;

            $module_class = ET_Builder_Element::add_module_order_class( $module_class, $render_slug );

            $container_is_closed = false;

            if ($fullwidth == 'list') {
                $module_class .= ' et_pb_db_shop_loop_list et_pb_db_shop_loop_hide custom-layout';
                echo '<style>.et_shop_image {display:inline-block;}</style>';
            } else {
                $module_class .= ' et_pb_db_shop_loop_grid et_pb_db_shop_loop_hide custom-layout';
            }

            $et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );

            if ($custom_loop == 'on') { // CUSTOM LOOP

                $product_visibility_terms  = wc_get_product_visibility_term_ids();
                $product_visibility_not_in = array( is_search() && $main_query ? $product_visibility_terms['exclude-from-search'] : $product_visibility_terms['exclude-from-catalog'] );
                if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
                    $product_visibility_not_in[] = $product_visibility_terms['outofstock'];
                }

                $args = array(
                    'post_type'         => 'product',
                    'orderby'           => $sort_order,
                    'order'             => $order_asc_desc,
                    'post_status'       => 'publish',
                    'paged'             => $et_paged
                );

                if ( !empty( $posts_number ) ){
                    $args['posts_per_page'] = (int) $posts_number;
                }

                if ($include_tags != "") {
                    $args['product_tag'] = $include_tags;
                }

                if ($include_cats != "") {
                    $args['product_cat'] = $include_cats;
                }

                if ( !empty( $post_type_choose ) ) {
                    $args['post_type']   = $post_type_choose;
                }

                // FEATURED
                if ($featured_only == "on") {
                    $tax_query[] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                        'operator' => 'IN',
                    );

                    $args['tax_query'] = $tax_query;
                }

                // POPULAR
                if ($popular_only == "on") {
                    $customclass = "popular-products";
                    $args['meta_key'] = 'total_sales';
                    $args['orderby']  = 'meta_value_num';
                }

                // ON SALE
                if ($on_sale_only == "on") {
                    $customclass = "onsale-products";
                    $products_on_sale = wc_get_product_ids_on_sale();
                    $args['post__in'] = $products_on_sale;            
                }

                // NEW PRODUCT
                if ($new_only == "on") {
                    $customclass = "new-products";
                    $args['date_query'] = array(
                        array(
                            'after'     => '-'.$new_time.' days',
                            'column'    => 'post_date',
                        )
                    );
                }

                if ( is_single() && ! isset( $args['post__not_in'] ) ) {
                    $args['post__not_in'] = array( get_the_ID() );
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

                $wc_query = new WC_Query();
                $ordering = $wc_query->get_catalog_ordering_args();
                $args['orderby'] = $ordering['orderby'];
                $args['order']  = $ordering['order'];

                if ( !empty( $ordering['meta_key'] ) ){
                    $args['meta_key'] = $ordering['meta_key'];
                }

                if ( $hide_non_purchasable == "on" ){
                    $args['meta_query'] = array(
                        array(
                            'key'     => '_price',
                            'value'   => '',
                            'compare' => '!='
                        )
                    );
                }

                query_posts( $args );
            
            } // END CUSTOM LOOP

            global $wp_query;
            $wp_query->set( 'wc_query', 'product_query' );

            if ($loop_layout == "none") {
                echo "</div>";
                echo "<h1>You have selected a custom layout but have not selected a loop layout for your products</h1>
                Please create a <a href='https://www.youtube.com/watch?v=mLiUJ_hvBjE' target='_blank'>custom loop layout</a> and specify it in the settings, or change the layout style to be default.";
            } else {

                if ( have_posts() ) {

                    do_action( 'woocommerce_before_shop_loop' );

                    woocommerce_product_loop_start();

                    $product_id = null;
                    $class = '';
                    $shortcodes = '';

                    $i = 0;

                    if ($fullwidth == 'off') { //grid
                        echo '<ul class="et_pb_row_bodycommerce custom-loop-layout products bc_product_grid bc_product_' . $cols . ' bc_pro_tab_'. $columns_tablet .' bc_pro_mob_'. $columns_mobile .'">';
                    }
                    else if ($fullwidth  == 'list') {
                        echo '<ul class="et_pb_row_bodycommerce custom-loop-layout products">';
                    }

                    while ( have_posts() ) {
                        the_post();

                        global $product;
                        $post_link = get_permalink(get_the_ID());

                        if ( !($hide_non_purchasable == "on" 
                            && ( !$product->is_type('grouped') && !$product->is_type('external') ) 
                            && $product->is_purchasable() === false) ) {

                            if( get_option('woocommerce_hide_out_of_stock_items') == "yes" && ( ! $product->managing_stock() && ! $product->is_in_stock() ) ){
                            } else {

                                if ($fullwidth == 'off') {
                                    echo '<li class="'. esc_attr( implode( " ", wc_get_product_class( $class, $product_id ) ) ) . ' ">';
                                    if ($link_whole_gird == "on") {
                    ?>
                                    <div class="bc-link-whole-grid-card" data-link-url="<?php echo $post_link ?>">
                    <?php   
                                    }

                                    // echo do_shortcode('[' . $et_shortcode . ' global_module="' . $loop_layout . '"][/' . $et_shortcode . ']');
                                    echo apply_filters('the_content', get_post_field('post_content', $loop_layout));

                                    if ($link_whole_gird == "on") {
                    ?>
                                    </div>  
                    <?php       
                                    }
                                    echo '</li>';
                                }else if ($fullwidth  == 'list') {
                                    echo '<li class="'. esc_attr( implode( " ", wc_get_product_class( $class, $product_id ) ) ) . ' bc_product" style="width: 100%;margin-right: 0;">';

                                    if ($link_whole_gird == "on") {
                    ?>
                                    <div class="bc-link-whole-grid-card" data-link-url="<?php echo $post_link ?>">
                    <?php
                                    }
                                    // echo do_shortcode('[' . $et_shortcode . ' global_module="' . $loop_layout . '"][/' . $et_shortcode . ']');
                                    echo apply_filters('the_content', get_post_field('post_content', $loop_layout));

                                    if ($link_whole_gird == "on") {
                    ?>
                                    </div>  
                    <?php       
                                    }

                                    echo '</li>';
                                }
                            }
                        }
                    } // endwhile

                    echo '</ul>';

                    woocommerce_product_loop_end();

                    wp_reset_query();

                    if ( 'on' === $enable_pagination ) {
                        do_action( 'woocommerce_after_shop_loop' );
                    }

                    if ($equal_height_mob == "off") {
            ?>
                <style>@media only screen and (max-width:767px) {.woocommerce .et_pb_db_shop_loop.same-height-cards ul.products li.product {height: auto!important}}</style>
            <?php
                    }
                } else {
            ?>
                </div>
            <?php

                    if ($no_results_layout == 'none') {
                        if ( et_is_builder_plugin_active() ) {
                            include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
                        } else {
                            get_template_part( 'includes/no-results', 'index' );
                        }
                    } else {
                        echo apply_filters('the_content', get_post_field('post_content', $no_results_layout));
                    }

                }
            }

            $posts = ob_get_contents();

            ob_end_clean();

            $class = " et_pb_module et_pb_bg_layout_{$background_layout}";

            $output = sprintf(
                '<div%4$s class="MyPosts %1$s%3$s%5$s"%6$s>
                %2$s</div>',
                ( $fullwidth == 'list' ? 'et_pb_posts' : 'et_pb_blog_grid clearfix' ),
                $posts,
                esc_attr( $class ),
                ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
                ( 'on' !== $fullwidth ? ' data-columns' : '' )
            );

            if ( 'off' == $fullwidth ) {
                $output = sprintf( '<div class="et_pb_blog_grid_wrapper">%1$s</div>', $output );
            } else if ( 'list' == $fullwidth ) {
                $output = sprintf( '<div class="et_pb_woo_list_wrapper">%1$s</div>', $output );
            }

            return $output;

        } // END CUSTOM LAYOUT
        // DEFAULT
        else if ($cat_loop_style == "on") {

            if( $show_sorting_menu == 'off' ){
                remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
            }
            if( $show_results_count == 'off' ){
                remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
            }
            if( $show_rating == 'off' ){
                remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
            }
            if( $show_price == 'off' ){
                remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
            }
            if( $show_excerpt == 'on' ){
                add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 8 );
            }
            if( $show_add_to_cart == 'on' ){
                add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 9 );
            }
            if( $enable_pagination == 'off' ){
                remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
            }

            add_action( 'woocommerce_shop_loop_item_title', array( 'db_shop_loop_code', 'product_details_wrapper_start' ), 0 );
            add_action( 'woocommerce_after_shop_loop_item', array( 'db_shop_loop_code', 'product_details_wrapper_end' ), 10 );

            add_action( 'woocommerce_before_shop_loop_item_title', array( 'db_shop_loop_code', 'product_image_wrapper_start' ), 0 );
            add_action( 'woocommerce_before_shop_loop_item_title', array( 'db_shop_loop_code', 'product_image_wrapper_end' ), 20 );

            // list view
            if( $display_type == 'list_view' ){
                $this->add_classname( 'de_db_list_view' );
                $this->columns = 1;
            }

            // columns
            add_filter( 'loop_shop_columns', array( $this, 'change_columns_number' ), 9999 );

            // show add to cart
            if( $show_add_to_cart == 'on' ){
                // add to cart button icon and background
                if( $custom_add_to_cart_button == 'on' ){
                    // button icon
                    if( $add_to_cart_button_icon !== '' ){
                        
                        $addToCartIconContent = DEBC_INIT::et_icon_css_content( esc_attr($add_to_cart_button_icon) );
                        $addToCartIconSelector = '';
                        if( $add_to_cart_button_icon_placement == 'right' ){
                            $addToCartIconSelector = '%%order_class%% li.product .button:after';
                        }elseif( $add_to_cart_button_icon_placement == 'left' ){
                            $addToCartIconSelector = '%%order_class%% li.product .button:before';
                        }

                        if( !empty( $addToCartIconContent ) && !empty( $addToCartIconSelector ) ){
                            ET_Builder_Element::set_style( $render_slug, array(
                                'selector' => $addToCartIconSelector,
                                'declaration' => "content: '{$addToCartIconContent}'!important;font-family:ETmodules!important;"
                            ) );
                        }
                    }

                    // button background
                    if( !empty( $add_to_cart_button_bg_color ) ){
                        ET_Builder_Element::set_style( $render_slug, array(
                            'selector'    => 'body #page-container %%order_class%% .button',
                            'declaration' => "background-color:". esc_attr( $add_to_cart_button_bg_color ) ."!important;",
                        ) );
                    }
                }
            }

            if( $use_overlay == 'off' ){
                $this->add_classname( 'hide_overlay' );
            }elseif( $use_overlay == 'on' ){
                // icon
                if( !empty( $hover_icon ) ){
                    $icon_color = !( empty( $icon_hover_color ) ) ? 'color: ' . esc_attr( $icon_hover_color ) . ';' : '';

                    ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%% .et_overlay:before, %%order_class%% .et_pb_extra_overlay:before',
                        'declaration' => "content: '". esc_attr( DEBC_INIT::et_icon_css_content( $hover_icon ) ) ."'; font-family: 'ETmodules' !important; {$icon_color}",
                    ) );
                }

                // hover background color
                if( !empty( $hover_overlay_color ) ){

                    ET_Builder_Element::set_style( $render_slug, array(
                      'selector'    => '%%order_class%% .et_overlay, %%order_class%% .et_pb_extra_overlay',
                      'declaration' => "background: ". esc_attr( $hover_overlay_color ) .";",
                    ) );
                }
            }

            // stars color
            if( !empty( $stars_color ) ){
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => 'body.woocommerce %%order_class%% .star-rating span:before, body.woocommerce-page %%order_class%% .star-rating span:before, %%order_class%% .star-rating span:before',
                    'declaration' => "color: ". esc_attr( $stars_color ) ."!important;",
                ) );
            }

            if ( '' !== $sale_badge_color ) {
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => '%%order_class%% span.onsale',
                    'declaration' => sprintf(
                        'background-color: %1$s !important;',
                        esc_html( $sale_badge_color )
                    ),
                ) );
            }

            if ( '' !== $product_background ) {
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => "%%order_class%% .products .product",
                    'declaration' => sprintf(
                        'background-color: %1$s !important;',
                        esc_html( $product_background )
                    ),
                ) );
            }

            if ( '' !== $product_padding ) {
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector'    => "%%order_class%% .products .product",
                    'declaration' => sprintf(
                        'padding: %1$s !important;',
                        esc_html( $product_padding )
                    ),
                ) );
            }

            /**
             * Products Loop Start
             * If the module is used inside a product archive page, load the default loop to maintain compatibility with 3rd party plugins
             * But if the module is used in any other page, use the [products] shortcode
             * */
            if( ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() ) || ( function_exists( 'is_shop' ) && is_shop() ) ){
                ob_start();
                /**
                 * This loop is from archive-product.php
                 * @version 3.4.0 => WC
                 */
                if ( have_posts() ) {

                    /**
                     * Hook: woocommerce_before_shop_loop.
                     *
                     * @hooked wc_print_notices - 10
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action( 'woocommerce_before_shop_loop' );

                    woocommerce_product_loop_start();

                    if ( function_exists( 'wc_get_loop_prop' ) && wc_get_loop_prop( 'total' ) ) {
                        while ( have_posts() ) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             *
                             * @hooked WC_Structured_Data::generate_product_data() - 10
                             */
                            do_action( 'woocommerce_shop_loop' );

                            wc_get_template_part( 'content', 'product' );
                        }
                    }else{
                        // for WooCommerce Versions before 3.3
                        while ( have_posts() ) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             *
                             * @hooked WC_Structured_Data::generate_product_data() - 10
                             */
                            do_action( 'woocommerce_shop_loop' );

                            wc_get_template_part( 'content', 'product' );
                        }
                    }

                    woocommerce_product_loop_end();

                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action( 'woocommerce_after_shop_loop' );
                } else {
                    /**
                     * Hook: woocommerce_no_products_found.
                     *
                     * @hooked wc_no_products_found - 10
                     */
                    do_action( 'woocommerce_no_products_found' );
                }
                $loop = ob_get_clean();
                $loop = "<div class='woocommerce default-style columns-". (int)$this->columns ."'>" . $loop . "</div>";
            }else{
                $columns = esc_attr($this->columns);
                global $shortname; // theme name
                $limit = function_exists( 'et_get_option' ) ? (int) et_get_option( $shortname . '_woocommerce_archive_num_posts', '9' ) : 9;
                $pagination = $enable_pagination == 'on' ? 'true' : 'false';

                $shortcode = "[products columns='{$columns}' limit='{$limit}' paginate='{$pagination}']";
                $loop = do_shortcode( $shortcode );
            }

            /* Products Loop Start */

            /* reset in case the module used twice start */
            if( $show_sorting_menu == 'off' ){
                add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
            }
            if( $show_results_count == 'off' ){
                add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
            }
            if( $show_rating == 'off' ){
                add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
            }
            if( $show_price == 'off' ){
                add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
            }
            if( $show_excerpt == 'on' ){
                remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_excerpt', 8 );
            }
            if( $show_add_to_cart == 'on' ){
                remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 9 );
            }
            if( $enable_pagination == 'off' ){
                add_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
            }

            remove_filter( 'loop_shop_columns', array( $this, 'change_columns_number' ), 9999 );
            remove_action( 'woocommerce_shop_loop_item_title', array( 'db_shop_loop_code', 'product_details_wrapper_start' ), 0 );
            remove_action( 'woocommerce_after_shop_loop_item', array( 'db_shop_loop_code', 'product_details_wrapper_end' ), 10 );
            remove_action( 'woocommerce_before_shop_loop_item_title', array( 'db_shop_loop_code', 'product_image_wrapper_start' ), 0 );
            remove_action( 'woocommerce_before_shop_loop_item_title', array( 'db_shop_loop_code', 'product_image_wrapper_end' ), 20 );
            
            $output = $loop;
            
            return $output;
        }
    }
}

new db_shop_loop_code;

?>
