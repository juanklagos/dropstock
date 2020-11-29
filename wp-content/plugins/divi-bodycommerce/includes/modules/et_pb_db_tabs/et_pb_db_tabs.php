<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_tabs_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

public static $tabs_to_remove = array();
public static function remove_tabs( $tabs ){
  if( count( self::$tabs_to_remove ) ){

    foreach( self::$tabs_to_remove as $tab ){
      unset( $tabs[$tab] );
    }
  }
  return $tabs;
}

                function init() {
                    $this->name       = esc_html__( '.PP Tabs - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_tabs';



		$this->fields_defaults = array(
			'show_desc' 					=> array( 'on' ),
			'remove_add_info' 				=> array( 'off' ),
			'remove_description'  		=> array( 'off' ),
			'remove_reviews'  		=> array( 'off' ),
			'remove_default_style' 			=> array( 'off' ),
			'tabs_head_text_orientation' 	=> array( 'left' ),
  'show_tabs' 	=> array( 'all' ),
		);

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
  					           'alignment'  => esc_html__( 'Alignment', 'et_builder' ),
      				),
      			),
            'advanced' => array(
        				'toggles' => array(
        					'misc'	=> esc_html__( 'Colors', 'divi-bodyshop-woocommerce' ),
        					'tabs_labels'	=> esc_html__( 'Tabs Headers', 'divi-bodyshop-woocommerce' ),
        					'active_tab_label'	=> esc_html__( 'Active Tab Header', 'divi-bodyshop-woocommerce' ),
        					'hover_tab_label'	=> esc_html__( 'Hover Tab Header', 'divi-bodyshop-woocommerce' ),
        					'text' => array(
        						'title'    => esc_html__( 'Product Description', 'et_builder' ),
        						'priority' => 45,
        						'tabbed_subtoggles' => true,
        						'bb_icons_support' => true,
        						'sub_toggles' => array(
        							'p'     => array(
        								'name' => 'P',
        								'icon' => 'text-left',
        							),
        							'a'     => array(
        								'name' => 'A',
        								'icon' => 'text-link',
        							),
        							'ul'    => array(
        								'name' => 'UL',
        								'icon' => 'list',
        							),
        							'ol'    => array(
        								'name' => 'OL',
        								'icon' => 'numbered-list',
        							),
        							'quote' => array(
        								'name' => 'QUOTE',
        								'icon' => 'text-quote',
        							),
        						),
        					),
        					'header' => array(
        						'title'    => esc_html__( 'Product Description Heading', 'et_builder' ),
        						'priority' => 46,
        						'tabbed_subtoggles' => true,
        						'sub_toggles' => array(
        							'h1' => array(
        								'name' => 'H1',
        								'icon' => 'text-h1',
        							),
        							'h2' => array(
        								'name' => 'H2',
        								'icon' => 'text-h2',
        							),
        							'h3' => array(
        								'name' => 'H3',
        								'icon' => 'text-h3',
        							),
        							'h4' => array(
        								'name' => 'H4',
        								'icon' => 'text-h4',
        							),
        							'h5' => array(
        								'name' => 'H5',
        								'icon' => 'text-h5',
        							),
        							'h6' => array(
        								'name' => 'H6',
        								'icon' => 'text-h6',
        							),
        						),
        					),
        					'customtabs' => array(
        						'title'    => esc_html__( 'Custom Tabs', 'et_builder' ),
        						'priority' => 47,
        						'tabbed_subtoggles' => true,
        						'bb_icons_support' => true,
        						'sub_toggles' => array(
        							'h1' => array(
        								'name' => 'H1',
        								'icon' => 'text-h1',
        							),
        							'h2' => array(
        								'name' => 'H2',
        								'icon' => 'text-h2',
        							),
        							'h3' => array(
        								'name' => 'H3',
        								'icon' => 'text-h3',
        							),
        							'h4' => array(
        								'name' => 'H4',
        								'icon' => 'text-h4',
        							),
        							'h5' => array(
        								'name' => 'H5',
        								'icon' => 'text-h5',
        							),
        							'h6' => array(
        								'name' => 'H6',
        								'icon' => 'text-h6',
        							),
        							'p'     => array(
        								'name' => 'P',
        								'icon' => 'text-left',
        							),
        							'a'     => array(
        								'name' => 'A',
        								'icon' => 'text-link',
        							),
        							'ul'    => array(
        								'name' => 'UL',
        								'icon' => 'list',
        							),
        							'ol'    => array(
        								'name' => 'OL',
        								'icon' => 'numbered-list',
        							),
        							'quote' => array(
        								'name' => 'QUOTE',
        								'icon' => 'text-quote',
        							),
        						),
        					),
        					'width' => array(
        						'title'    => esc_html__( 'Sizing', 'et_builder' ),
        						'priority' => 65,
        					),
        				),
        			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
              			'fonts' => array(
              				'header'   => array(
              					'label'    => esc_html__( 'Tabs Header', 'divi-bodyshop-woocommerce' ),
              					'css'      => array(
              						'main' => "body.woocommerce div.product %%order_class%% .woocommerce-tabs ul.tabs li a",
              					),
              					'font_size' => array(
              						'default' => '16px',
              					),
              					'line_height' => array(
              						'default' => '1.7em',
              					),
              					'important' => array(),
              					'toggle_slug' => 'tabs_labels',
              				),
              				'active_tab'   => array(
              					'label'    => esc_html__( 'Active Tab Header', 'divi-bodyshop-woocommerce' ),
              					'css'      => array(
              						'main' => "body.woocommerce div.product %%order_class%% .woocommerce-tabs ul.tabs li.active a",
              						'important' => 'all',
              					),
              					'font_size' => array(
              						'default' => '16px',
              					),
              					'line_height' => array(
              						'default' => '1.7em',
              					),
              					'toggle_slug' => 'active_tab_label',
              				),
              				'tab_header_hover'   => array(
              					'label'    => esc_html__( 'Tab Header Hover', 'divi-bodyshop-woocommerce' ),
              					'css'      => array(
              						'main' => "body.woocommerce div.product %%order_class%% .woocommerce-tabs ul.tabs li a:hover",
              						'important' => "all",

              					),
              					'font_size' => array(
              						'default' => '16px',
              					),
              					'line_height' => array(
              						'default' => '1.7em',
              					),
              					'toggle_slug' => 'hover_tab_label',
              				),
              				'text'   => array(
              					'label'    => esc_html__( 'Text', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Tabs-panel--description p",
              					),
              					'line_height' => array(
              						'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
              					),
              					'font_size' => array(
              						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
              					),
              					'toggle_slug' => 'text',
              					'sub_toggle'  => 'p',
              					'hide_text_align' => true,
              				),
              				'link'   => array(
              					'label'    => esc_html__( 'Link', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Tabs-panel--description a",
              						'color' => "%%order_class%% .woocommerce-Tabs-panel--description a",
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'font_size' => array(
              						'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
              					),
              					'toggle_slug' => 'text',
              					'sub_toggle'  => 'a',
              				),
              				'ul'   => array(
              					'label'    => esc_html__( 'Unordered List', 'et_builder' ),
              					'css'      => array(
              						'main'        => "%%order_class%% .woocommerce-Tabs-panel--description ul",
              						'color'       => "%%order_class%% .woocommerce-Tabs-panel--description ul",
              						'line_height' => "%%order_class%% .woocommerce-Tabs-panel--description ul li",
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'font_size' => array(
              						'default' => '14px',
              					),
              					'toggle_slug' => 'text',
              					'sub_toggle'  => 'ul',
              				),
              				'ol'   => array(
              					'label'    => esc_html__( 'Ordered List', 'et_builder' ),
              					'css'      => array(
              						'main'        => "%%order_class%% .woocommerce-Tabs-panel--description ol",
              						'color'       => "%%order_class%% .woocommerce-Tabs-panel--description ol",
              						'line_height' => "%%order_class%% .woocommerce-Tabs-panel--description ol li",
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'font_size' => array(
              						'default' => '14px',
              					),
              					'toggle_slug' => 'text',
              					'sub_toggle'  => 'ol',
              				),
              				'quote'   => array(
              					'label'    => esc_html__( 'Blockquote', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Tabs-panel--description blockquote, %%order_class%% .woocommerce-Tabs-panel--description blockquote p",
              						'color' => "%%order_class%% .woocommerce-Tabs-panel--description blockquote, %%order_class%% .woocommerce-Tabs-panel--description blockquote p",
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'font_size' => array(
              						'default' => '14px',
              					),
              					'toggle_slug' => 'text',
              					'sub_toggle'  => 'quote',
              				),
              				'header_1'   => array(
              					'label'    => esc_html__( 'Heading', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Tabs-panel--description h1",
              					),
              					'font_size' => array(
              						'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'header',
              					'sub_toggle'  => 'h1',
              				),
              				'header_2'   => array(
              					'label'    => esc_html__( 'Heading 2', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Tabs-panel--description h2",
              					),
              					'font_size' => array(
              						'default' => '26px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'header',
              					'sub_toggle'  => 'h2',
              				),
              				'header_3'   => array(
              					'label'    => esc_html__( 'Heading 3', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Tabs-panel--description h3",
              					),
              					'font_size' => array(
              						'default' => '22px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'header',
              					'sub_toggle'  => 'h3',
              				),
              				'header_4'   => array(
              					'label'    => esc_html__( 'Heading 4', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Tabs-panel--description h4",
              					),
              					'font_size' => array(
              						'default' => '18px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'header',
              					'sub_toggle'  => 'h4',
              				),
              				'header_5'   => array(
              					'label'    => esc_html__( 'Heading 5', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Tabs-panel--description h5",
              					),
              					'font_size' => array(
              						'default' => '16px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'header',
              					'sub_toggle'  => 'h5',
              				),
              				'header_6'   => array(
              					'label'    => esc_html__( 'Heading 6', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Tabs-panel--description h6",
              					),
              					'font_size' => array(
              						'default' => '14px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'header',
              					'sub_toggle'  => 'h6',
              				),
              				'attribute_name' => array(
              					'label'    => esc_html__( 'Attribute Name', 'divi-bodyshop-woocommerce' ),
              					'css'      => array(
              						'main' => "%%order_class%% table.shop_attributes th, %%order_class%% .woocommerce-product-attributes-item__label",
              					),
              					'font_size' => array(
              						'default' => '14px',
              					),
              					'line_height' => array(
              						'default' => '1.5em',
              					),
              				),
              				'attribute_values' => array(
              					'label'    => esc_html__( 'Attribute Values', 'divi-bodyshop-woocommerce' ),
              					'css'      => array(
              						'main' => "%%order_class%% table.shop_attributes td p, %%order_class%% table.shop_attributes td a, %%order_class%% .woocommerce-product-attributes-item__value",
              					),
              					'font_size' => array(
              						'default' => '14px',
              					),
              					'line_height' => array(
              						'default' => '1.5em',
              					),
              				),
              				'reviews_heading' => array(
              					'label'    => esc_html__( 'Reviews Heading', 'divi-bodyshop-woocommerce' ),
              					'css'      => array(
              						'main' => "%%order_class%% .woocommerce-Reviews-title",
              					),
              					'font_size' => array(
              						'default' => '14px',
              					),
              					'line_height' => array(
              						'default' => '1.5em',
              					),
              				),
              				'reviews_general' => array(
              					'label'    => esc_html__( 'Reviews General', 'divi-bodyshop-woocommerce' ),
              					'css'      => array(
              						'main' => ".woocommerce %%order_class%% #reviews #comments ol.commentlist li .meta, .woocommerce %%order_class%% #reviews .description, .woocommerce %%order_class%% #reviews .description p, .woocommerce %%order_class%% #review_form #respond",
              					),
              					'font_size' => array(
              						'default' => '14px',
              					),
              					'line_height' => array(
              						'default' => '1.5em',
              					),
              				),



                      'customtabs'   => array(
                        'label'    => esc_html__( 'Custom Tabs', 'et_builder' ),
                        'css'      => array(
                          'main' => "%%order_class%% .woocommerce-tabs .wc-tab:not(.woocommerce-Tabs-panel--description) p",
                        ),
                        'line_height' => array(
                          'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                        ),
                        'font_size' => array(
                          'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                        ),
                        'toggle_slug' => 'customtabs',
                        'sub_toggle'  => 'p',
                        'hide_text_align' => true,
                      ),



                      'header_1_customtabs'   => array(
              					'label'    => esc_html__( 'Heading', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .wc-tab:not(.woocommerce-Tabs-panel--description) h1",
              					),
              					'font_size' => array(
              						'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'customtabs',
              					'sub_toggle'  => 'h1',
              				),
              				'header_2_customtabs'   => array(
              					'label'    => esc_html__( 'Heading 2', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .wc-tab:not(.woocommerce-Tabs-panel--description) h2",
              					),
              					'font_size' => array(
              						'default' => '26px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'customtabs',
              					'sub_toggle'  => 'h2',
              				),
              				'header_3_customtabs'   => array(
              					'label'    => esc_html__( 'Heading 3', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .wc-tab:not(.woocommerce-Tabs-panel--description) h3",
              					),
              					'font_size' => array(
              						'default' => '22px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'customtabs',
              					'sub_toggle'  => 'h3',
              				),
              				'header_4_customtabs'   => array(
              					'label'    => esc_html__( 'Heading 4', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .wc-tab:not(.woocommerce-Tabs-panel--description) h4",
              					),
              					'font_size' => array(
              						'default' => '18px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'customtabs',
              					'sub_toggle'  => 'h4',
              				),
              				'header_5_customtabs'   => array(
              					'label'    => esc_html__( 'Heading 5', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .wc-tab:not(.woocommerce-Tabs-panel--description) h5",
              					),
              					'font_size' => array(
              						'default' => '16px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'customtabs',
              					'sub_toggle'  => 'h5',
              				),
              				'header_6_customtabs'   => array(
              					'label'    => esc_html__( 'Heading 6', 'et_builder' ),
              					'css'      => array(
              						'main' => "%%order_class%% .wc-tab:not(.woocommerce-Tabs-panel--description) h6",
              					),
              					'font_size' => array(
              						'default' => '14px',
              					),
              					'line_height' => array(
              						'default' => '1em',
              					),
              					'toggle_slug' => 'customtabs',
              					'sub_toggle'  => 'h6',
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
              			'button' => array(
              				'button' => array(
              					'label' => esc_html__( 'Submit Review Button', 'divi-bodyshop-woocommerce' ),
              					'css' => array(
              						'main' => "%%order_class%% #review_form #respond .form-submit input",
              					),
              					'box_shadow' => array(
              						'css' => array(
              							'main' =>  "%%order_class%% #review_form #respond .form-submit input",
              						),
              					),
                        'margin_padding' => array(
                        'css'           => array(
                          'main' => "{$this->main_css_element} #review_form #respond .form-submit input",
                          'important' => 'all',
                        ),
                        ),
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
          'show_tabs' => array(
              'label'           => __( 'What content do you want to show?', 'divi-bodyshop-woocommerce' ),
              'type'            => 'select',
              'option_category' => 'basic_option',
              'options'           => array(
                'all' => esc_html__( 'All (default shows all tabs)', 'divi-bodyshop-woocommerce' ),
                '1'  => esc_html__( 'Tab 1 Content', 'divi-bodyshop-woocommerce' ),
                '2'  => esc_html__( 'Tab 2 Content', 'divi-bodyshop-woocommerce' ),
                '3'  => esc_html__( 'Tab 3 Content', 'divi-bodyshop-woocommerce' ),
                '4'  => esc_html__( 'Tab 4 Content', 'divi-bodyshop-woocommerce' ),
                '5'  => esc_html__( 'Tab 5 Content', 'divi-bodyshop-woocommerce' ),
                '6'  => esc_html__( 'Tab 6 Content', 'divi-bodyshop-woocommerce' ),
                '7'  => esc_html__( 'Tab 7 Content', 'divi-bodyshop-woocommerce' ),
                '8'  => esc_html__( 'Tab 8 Content', 'divi-bodyshop-woocommerce' ),
                '9'  => esc_html__( 'Tab 9 Content', 'divi-bodyshop-woocommerce' ),
                '10'  => esc_html__( 'Tab 10 Content', 'divi-bodyshop-woocommerce' ),
                '11'  => esc_html__( 'Tab 11 Content', 'divi-bodyshop-woocommerce' ),
                '12'  => esc_html__( 'Tab 12 Content', 'divi-bodyshop-woocommerce' ),
                '13'  => esc_html__( 'Tab 13 Content', 'divi-bodyshop-woocommerce' ),
                '14'  => esc_html__( 'Tab 14 Content', 'divi-bodyshop-woocommerce' ),
                '15'  => esc_html__( 'Tab 15 Content', 'divi-bodyshop-woocommerce' ),
                '16'  => esc_html__( 'Tab 16 Content', 'divi-bodyshop-woocommerce' ),
                '17'  => esc_html__( 'Tab 17 Content', 'divi-bodyshop-woocommerce' ),
                '18'  => esc_html__( 'Tab 18 Content', 'divi-bodyshop-woocommerce' ),
                '19'  => esc_html__( 'Tab 19 Content', 'divi-bodyshop-woocommerce' ),
                '20'  => esc_html__( 'Tab 20 Content', 'divi-bodyshop-woocommerce' ),
                '21'  => esc_html__( 'Tab 21 Content', 'divi-bodyshop-woocommerce' ),
                '22'  => esc_html__( 'Tab 22 Content', 'divi-bodyshop-woocommerce' ),
                '23'  => esc_html__( 'Tab 23 Content', 'divi-bodyshop-woocommerce' ),
          ),
          'toggle_slug'         => 'main_content',
              'description'       => __( 'Choose the tab content you want to display or leave as ALL to show all the tabs.', 'divi-bodyshop-woocommerce' ),

          ),
            'remove_description'=>array(
                        'label'=>'Remove description Tab',
                        'type'=>'yes_no_button',
                        'options'=>array(
                                    'off'=>'No'
                                    , 'on'=>'Yes'
                        ),
                				'toggle_slug' => 'main_content',
                        'description'=>'This will remove the description tab from the tab system.'
            ),
            'remove_reviews'=>array(
                        'label'=>'Remove Reviews Tab',
                        'type'=>'yes_no_button',
                        'options'=>array(
                                    'off'=>'No'
                                    , 'on'=>'Yes'
                        ),
                				'toggle_slug' => 'main_content',
                        'description'=>'This will remove the reviews tab from the tab system. You can use the Reviews module to show them anywhere else'
            ),
      			'remove_add_info' => array(
      				'label' => esc_html__( 'Remove Additional Info.', 'divi-bodyshop-woocommerce' ),
      				'type' => 'yes_no_button',
      				'options_category' => 'configuration',
      				'options' => array(
      					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
      					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
      				),
      				'default' => 'on',
      				'toggle_slug' => 'main_content',
      			),
      			'remove_default_style' => array(
      				'label' => esc_html__( 'Remove Tabs Style', 'divi-bodyshop-woocommerce' ),
      				'type' => 'yes_no_button',
      				'description' => esc_html__( 'This will remove the borders and heading backgrounds for the tabs', 'divi-bodyshop-woocommerce' ),
      				'options_category' => 'configuration',
      				'options' => array(
      					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
      					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
      				),
      				'default' => 'off',
      				'toggle_slug' => 'main_content',
      			),
      			'remove_tabs_labels' => array(
      				'label' => esc_html__( 'Remove Tabs Title', 'divi-bodyshop-woocommerce' ),
      				'type' => 'yes_no_button',
      				'description' => esc_html__( 'Inside each tab content, there is a title like Description, Additional Information ...', 'divi-bodyshop-woocommerce' ),
      				'options_category' => 'configuration',
      				'options' => array(
      					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
      					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
      				),
      				'default' => 'off',
      				'toggle_slug' => 'main_content',
      			),
            'star_primary' => array(
              'label'             => esc_html__( 'Primary Star Color', 'divi-bodyshop-woocommerce' ),
              'type'              => 'color-alpha',
              'custom_color'      => true,
      				'tab_slug' => 'advanced',
      				'toggle_slug' => 'misc',
              'description'       => esc_html__( 'This will chanege the color of the primary stars (the ones that indicate the number rating)', 'divi-bodyshop-woocommerce' ),
            ),
            'star_secondary' => array(
              'label'             => esc_html__( 'Secondary Star Color', 'divi-bodyshop-woocommerce' ),
              'type'              => 'color-alpha',
              'custom_color'      => true,
      				'tab_slug' => 'advanced',
      				'toggle_slug' => 'misc',
              'description'       => esc_html__( 'This will chanege the color of the secondary stars (the ones that indicate the missing number rating)', 'divi-bodyshop-woocommerce' ),
            ),
      			'tab_label_bg' => array(
      				'label'             => esc_html__( 'Heading Background', 'divi-bodyshop-woocommerce' ),
      				'type'     => 'color-alpha',
      				'default' => '#ffffff',
      				'tab_slug' => 'advanced',
      				'toggle_slug' => 'misc',
      			),
      			'active_tab_label_bg' => array(
      				'label'             => esc_html__( 'Active Heading Background', 'divi-bodyshop-woocommerce' ),
      				'type'     => 'color-alpha',
      				'default' => '#ffffff',
      				'tab_slug' => 'advanced',
      				'toggle_slug' => 'misc',
      			),
      			'hover_tab_label_bg' => array(
      				'label'             => esc_html__( 'Heading Hover Background', 'divi-bodyshop-woocommerce' ),
      				'type'     => 'color-alpha',
      				'default' => '#ffffff',
      				'tab_slug' => 'advanced',
      				'toggle_slug' => 'misc',
      			),
      			'tabs_content_bg' => array(
      				'label'             => esc_html__( 'Content Background', 'divi-bodyshop-woocommerce' ),
      				'type'     => 'color-alpha',
      				'default' => '#ffffff',
      				'tab_slug' => 'advanced',
      				'toggle_slug' => 'misc',
      			),
      			'tabs_head_text_orientation' => array(
      				'label'             => esc_html__( 'Tabs Headerts Text Alignment', 'divi-bodyshop-woocommerce' ),
      				'type'              => 'select',
      				'option_category'   => 'layout',
      				'options'           => et_builder_get_text_orientation_options(),
      				'description'       => esc_html__( 'This controls how your tabs headings are aligned within the module.', 'divi-bodyshop-woocommerce' ),
      				'tab_slug' => 'advanced',
      				'toggle_slug' => 'misc',
      			),
      			'ul_type' => array(
      				'label'             => esc_html__( 'Unordered List Style Type', 'et_builder' ),
      				'type'              => 'select',
      				'option_category'   => 'configuration',
      				'options'           => array(
      					'disc'    => esc_html__( 'Disc', 'et_builder' ),
      					'circle'  => esc_html__( 'Circle', 'et_builder' ),
      					'square'  => esc_html__( 'Square', 'et_builder' ),
      					'none'    => esc_html__( 'None', 'et_builder' ),
      				),
      				'priority'          => 80,
      				'default'           => 'disc',
      				'tab_slug'          => 'advanced',
      				'toggle_slug'       => 'text',
      				'sub_toggle'        => 'ul',
      			),
      			'ul_position' => array(
      				'label'             => esc_html__( 'Unordered List Style Position', 'et_builder' ),
      				'type'              => 'select',
      				'option_category'   => 'configuration',
      				'options'           => array(
      					'outside' => esc_html__( 'Outside', 'et_builder' ),
      					'inside'  => esc_html__( 'Inside', 'et_builder' ),
      				),
      				'priority'          => 85,
      				'default'           => 'outside',
      				'tab_slug'          => 'advanced',
      				'toggle_slug'       => 'text',
      				'sub_toggle'        => 'ul',
      			),
      			'ul_item_indent' => array(
      				'label'           => esc_html__( 'Unordered List Item Indent', 'et_builder' ),
      				'type'            => 'range',
      				'option_category' => 'configuration',
      				'tab_slug'        => 'advanced',
      				'toggle_slug'     => 'text',
      				'sub_toggle'      => 'ul',
      				'priority'        => 90,
      				'default'         => '0px',
      				'range_settings'  => array(
      					'min'  => '0',
      					'max'  => '100',
      					'step' => '1',
      				),
      			),
      			'ol_type' => array(
      				'label'             => esc_html__( 'Ordered List Style Type', 'et_builder' ),
      				'type'              => 'select',
      				'option_category'   => 'configuration',
      				'options'           => array(
      					'decimal'              => 'decimal',
      					'armenian'             => 'armenian',
      					'cjk-ideographic'      => 'cjk-ideographic',
      					'decimal-leading-zero' => 'decimal-leading-zero',
      					'georgian'             => 'georgian',
      					'hebrew'               => 'hebrew',
      					'hiragana'             => 'hiragana',
      					'hiragana-iroha'       => 'hiragana-iroha',
      					'katakana'             => 'katakana',
      					'katakana-iroha'       => 'katakana-iroha',
      					'lower-alpha'          => 'lower-alpha',
      					'lower-greek'          => 'lower-greek',
      					'lower-latin'          => 'lower-latin',
      					'lower-roman'          => 'lower-roman',
      					'upper-alpha'          => 'upper-alpha',
      					'upper-greek'          => 'upper-greek',
      					'upper-latin'          => 'upper-latin',
      					'upper-roman'          => 'upper-roman',
      					'none'                 => 'none',
      				),
      				'priority'          => 80,
      				'default'           => 'decimal',
      				'tab_slug'          => 'advanced',
      				'toggle_slug'       => 'text',
      				'sub_toggle'        => 'ol',
      			),
      			'ol_position' => array(
      				'label'             => esc_html__( 'Ordered List Style Position', 'et_builder' ),
      				'type'              => 'select',
      				'option_category'   => 'configuration',
      				'options'           => array(
      					'outside' => esc_html__( 'Outside', 'et_builder' ),
      					'inside'  => esc_html__( 'Inside', 'et_builder' ),
      				),
      				'priority'          => 85,
      				'default'           => 'outside',
      				'tab_slug'          => 'advanced',
      				'toggle_slug'       => 'text',
      				'sub_toggle'        => 'ol',
      			),
      			'ol_item_indent' => array(
      				'label'           => esc_html__( 'Ordered List Item Indent', 'et_builder' ),
      				'type'            => 'range',
      				'option_category' => 'configuration',
      				'tab_slug'        => 'advanced',
      				'toggle_slug'     => 'text',
      				'sub_toggle'      => 'ol',
      				'priority'        => 90,
      				'default'         => '0px',
      				'range_settings'  => array(
      					'min'  => '0',
      					'max'  => '100',
      					'step' => '1',
      				),
      			),
      			'quote_border_weight' => array(
      				'label'           => esc_html__( 'Blockquote Border Weight', 'et_builder' ),
      				'type'            => 'range',
      				'option_category' => 'configuration',
      				'tab_slug'        => 'advanced',
      				'toggle_slug'     => 'text',
      				'sub_toggle'      => 'quote',
      				'priority'        => 85,
      				'default'         => '5px',
      				'range_settings'  => array(
      					'min'  => '0',
      					'max'  => '100',
      					'step' => '1',
      				),
      			),
      			'quote_border_color' => array(
      				'label'           => esc_html__( 'Blockquote Border Color', 'et_builder' ),
      				'type'            => 'color-alpha',
      				'option_category' => 'configuration',
      				'custom_color'    => true,
      				'tab_slug'        => 'advanced',
      				'toggle_slug'     => 'text',
      				'sub_toggle'      => 'quote',
      				'field_template'  => 'color-alpha',
      				'priority'        => 90,
      			),
			'button_alignment' => array(
				'label'            => esc_html__( 'Button Alignment', 'et_builder' ),
				'description'      => esc_html__( 'Align your button to the left, right or center of the module.', 'et_builder' ),
				'type'             => 'text_align',
				'option_category'  => 'configuration',
				'options'          => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'alignment',
				'description'      => esc_html__( 'Here you can define the alignment of Button', 'et_builder' ),
			),
    		);

    		return $fields;
    	}


            public function get_button_alignment( $device = 'desktop' ) {
        $suffix           = 'desktop' !== $device ? "_{$device}" : '';
        $text_orientation = isset( $this->props["button_alignment{$suffix}"] ) ? $this->props["button_alignment{$suffix}"] : '';

        return et_pb_get_alignment( $text_orientation );
      }

                  function render( $attrs, $content = null, $render_slug ) {


                    $show_tabs						= $this->props['show_tabs'];

                    $remove_description						= $this->props['remove_description'];
                		$remove_add_info					= $this->props['remove_add_info'];
                		$remove_reviews					= $this->props['remove_reviews'];
                		$remove_default_style			= $this->props['remove_default_style'];
                		$remove_tabs_labels				= $this->props['remove_tabs_labels'];
                		$tabs_head_text_orientation		= $this->props['tabs_head_text_orientation'];

                		$star_primary     				= $this->props['star_primary'];
                    $star_secondary     				= $this->props['star_secondary'];

                    	$tab_label_bg      				= $this->props['tab_label_bg'];
                		$active_tab_label_bg      		= $this->props['active_tab_label_bg'];
                		$hover_tab_label_bg      		= $this->props['hover_tab_label_bg'];
                		$tabs_content_bg      		= $this->props['tabs_content_bg'];
										
                		$button_bg_color       			= $this->props['button_bg_color'];

                		$ul_type              = $this->props['ul_type'];
                		$ul_position          = $this->props['ul_position'];
                		$ul_item_indent       = $this->props['ul_item_indent'];
                		$ol_type              = $this->props['ol_type'];
                		$ol_position          = $this->props['ol_position'];
                		$ol_item_indent       = $this->props['ol_item_indent'];
                		$quote_border_weight  = $this->props['quote_border_weight'];
                		$quote_border_color   = $this->props['quote_border_color'];



                                        $button_alignment                = $this->get_button_alignment();
                                              // Button Alignment.
                                    		$button_alignments = sprintf( 'et_pb_button_alignment_%1$s', esc_attr( $button_alignment ) );


                                          $this->add_classname( $button_alignments );


                                        if( $remove_tabs_labels == 'on' ){
                                          $this->add_classname('hide-titles');
                                  			}


                    $data = '';
                  //////////////////////////////////////////////////////////////////////
                    if( is_admin() ){
                      return;
                    }

                      ob_start();

                    $tabs_head_text_orientation != '' ? $this->add_classname('tabs-text-align-' . esc_attr( $tabs_head_text_orientation ) ) : '';
              			$remove_default_style == 'on' ?  $this->add_classname('remove-default-style') : '';

                    if ($remove_add_info  == "on") {
				self::$tabs_to_remove[] = 'additional_information';
        }

        if ($remove_reviews  == "on") {
				self::$tabs_to_remove[] = 'reviews';
}

                    if ($remove_description  == "on") {
				self::$tabs_to_remove[] = 'description';
        }


        if ($show_tabs == "all" || $show_tabs == "") {
        add_filter( 'woocommerce_product_tabs', array( $this, 'remove_tabs' ), 98 );
        $tabs = DEBC_INIT::content_buffer( 'woocommerce_output_product_data_tabs' );
        echo $tabs;
      } else {

        $tabs = apply_filters( 'woocommerce_product_tabs', array() );

        if ( ! empty( $tabs ) ) :

          $show_tabs_minus = --$show_tabs;

          $selected_tab = array_keys($tabs)[$show_tabs_minus];

          if ( isset( $tabs[$selected_tab]["callback"] ) ) { call_user_func( $tabs[$selected_tab]["callback"] ); }

        endif;

      }
                    $data = ob_get_clean();


                    if( !empty( $star_secondary ) ){

                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%% .star-rating:before, %%order_class%% .star-rating:before',
                        'declaration' => "color: ". esc_attr( $star_secondary ) ."!important;",
                      ) );
                    }

                    if( !empty( $star_primary ) ){

                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%% .comment-form-rating .stars a , %%order_class%% .star-rating span::before, %%order_class%% .star-rating span::before',
                        'declaration' => "color: ". esc_attr( $star_primary ) ."!important;",
                      ) );
                    }

                    if( !empty( $tab_label_bg ) ){

              				ET_Builder_Element::set_style( $render_slug, array(
              					'selector'    => '%%order_class%% .woocommerce-tabs ul.tabs li a',
              					'declaration' => "background-color: ". esc_attr( $tab_label_bg ) ."!important;",
              				) );
              			}

              			if( !empty( $active_tab_label_bg ) ){

              				ET_Builder_Element::set_style( $render_slug, array(
              					'selector'    => '%%order_class%% .woocommerce-tabs ul.tabs li.active a ',
              					'declaration' => "background-color: ". esc_attr( $active_tab_label_bg ) ."!important;",
              				) );
              			}

              			if( !empty( $hover_tab_label_bg ) ){

              				ET_Builder_Element::set_style( $render_slug, array(
              					'selector'    => '	%%order_class%% .woocommerce-tabs ul.tabs li a:hover',
              					'declaration' => "background-color: ". esc_attr( $hover_tab_label_bg ) ."!important;",
              				) );
										}
										
										if( !empty( $tabs_content_bg ) ){

              				ET_Builder_Element::set_style( $render_slug, array(
              					'selector'    => '	%%order_class%% .woocommerce-tabs .panel',
              					'declaration' => "background-color: ". esc_attr( $tabs_content_bg ) ."!important;",
              				) );
										}									

              			if( !empty( $button_bg_color ) ){

              				ET_Builder_Element::set_style( $render_slug, array(
              					'selector'    => '%%order_class%% #review_form #respond .form-submit input',
              					'declaration' => "background:". esc_attr( $button_bg_color ) ."!important;",
              				) );
              			}

              			if ( '' !== $ul_type || '' !== $ul_position || '' !== $ul_item_indent ) {
              				ET_Builder_Element::set_style( $render_slug, array(
              					'selector'    => '%%order_class%% .woocommerce-Tabs-panel--description ul',
              					'declaration' => sprintf(
              						'%1$s
              						%2$s
              						%3$s',
              						'' !== $ul_type ? sprintf( 'list-style-type: %1$s !important;', esc_html( $ul_type ) ) : '',
              						'' !== $ul_position ? sprintf( 'list-style-position: %1$s !important;', esc_html( $ul_position ) ) : '',
              						'' !== $ul_item_indent ? sprintf( 'padding-left: %1$s !important;', esc_html( $ul_item_indent ) ) : ''
              					),
              				) );
              			}

              			if ( '' !== $ol_type || '' !== $ol_position || '' !== $ol_item_indent ) {
              				ET_Builder_Element::set_style( $render_slug, array(
              					'selector'    => '%%order_class%% .woocommerce-Tabs-panel--description ol',
              					'declaration' => sprintf(
              						'%1$s
              						%2$s
              						%3$s',
              						'' !== $ol_type ? sprintf( 'list-style-type: %1$s !important;', esc_html( $ol_type ) ) : '',
              						'' !== $ol_position ? sprintf( 'list-style-position: %1$s !important;', esc_html( $ol_position ) ) : '',
              						'' !== $ol_item_indent ? sprintf( 'padding-left: %1$s !important;', esc_html( $ol_item_indent ) ) : ''
              					),
              				) );
              			}

              			if ( '' !== $quote_border_weight || '' !== $quote_border_color ) {
              				ET_Builder_Element::set_style( $render_slug, array(
              					'selector'    => '%%order_class%% .woocommerce-Tabs-panel--description blockquote',
              					'declaration' => sprintf(
              						'%1$s
              						%2$s',
              						'' !== $quote_border_weight ? sprintf( 'border-width: %1$s;', esc_html( $quote_border_weight ) ) : '',
              						'' !== $quote_border_color ? sprintf( 'border-color: %1$s;', esc_html( $quote_border_color ) ) : ''
              					),
              				) );
              			}
                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_tabs_code;

?>