<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_images_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PP Gallery - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_images';

                    $this->fields_defaults = array(
                      'use_icon'            => array( 'off' ),
			                'icon_color'          => array( '#2ea3f2', 'add_default_setting' ),
                      'icon_color_next'     => array( '#2ea3f2', 'add_default_setting' ),
			                'auto'                   => array( 'off' ),
			                'auto_speed'             => array( '7000' ),
			                   'disable_lightbox' 	=> array( 'off' ),
   			                   'disable_lightbox_sliders' 	=> array( 'on' ),
     			                   'disable_zoom_sliders' 	=> array( 'on' ),
                         'gallery_style' 	=> array( 'default' ),
                    );

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles'  => array(
					'gallery'      => esc_html__( 'Gallery', 'divi-bodyshop-woocommerce' ),
          'slider_settings'  => esc_html__( 'Slider Settings (only custom gallery sliders)', 'divi-bodyshop-woocommerce' ),
          'slider_thumb_settings'  => esc_html__( 'Slider Thumbnail Settings (only custom gallery sliders)', 'divi-bodyshop-woocommerce' ),
          'main_content' => esc_html__( 'Images', 'divi-bodyshop-woocommerce' ),
					'elements'     => esc_html__( 'Elements', 'divi-bodyshop-woocommerce' ),
      				),
      			),
      			'advanced' => array(
				'toggles' => array(
					'layout'  => esc_html__( 'Layout', 'divi-bodyshop-woocommerce' ),
					'overlay' => esc_html__( 'Overlay', 'divi-bodyshop-woocommerce' ),
					'text'    => array(
						'title'    => esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
						'priority' => 49,
					),
				),
      			),
			'custom_css' => array(
				'toggles' => array(
					'animation' => array(
						'title'    => esc_html__( 'Animation', 'divi-bodyshop-woocommerce' ),
						'priority' => 90,
					),
				),
			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
                  'fonts' => array(
          				'caption' => array(
          					'label'    => esc_html__( 'Caption', 'divi-bodyshop-woocommerce' ),
          					'use_all_caps' => true,
          					'css'      => array(
          						'main' => "{$this->main_css_element} .mfp-title, {$this->main_css_element} .et_pb_gallery_caption",
          					),
          					'font_size' => array(
          						'default' => '14px',
          					),
          					'line_height' => array(
          						'default' => '1.7em',
          					),
          				),
          				'title'   => array(
          					'label'    => esc_html__( 'Title', 'divi-bodyshop-woocommerce' ),
          					'css'      => array(
          						'main' => "{$this->main_css_element} .et_pb_gallery_item h3",
          					),
          					'font_size' => array(
          						'default' => '18px',
          					),
          					'line_height' => array(
          						'default' => '1em',
          					),
          				),
          				'image_title'   => array(
          					'label'    => esc_html__( 'Image Name', 'divi-bodyshop-woocommerce' ),
          					'css'      => array(
          						'main' => "{$this->main_css_element} .thumb-title",
          					),
          					'font_size' => array(
          						'default' => '18px',
          					),
          					'line_height' => array(
          						'default' => '1em',
          					),
          				),
          			),
                'borders'               => array(
  				'default' => array(
  					'css' => array(
  						'main' => array(
  							'border_radii'  => "{$this->main_css_element}",
  							'border_styles' => "{$this->main_css_element}",
  						),
  					),
  				),
  				'image' => array(
  					'css' => array(
  						'main' => array(
  							'border_radii'  => "{$this->main_css_element} .woocommerce-product-gallery .flex-viewport, {$this->main_css_element} .flex-control-thumbs li",
  							'border_styles' => "{$this->main_css_element} .woocommerce-product-gallery .flex-viewport, {$this->main_css_element} .flex-control-thumbs li",
                  'important' => 'all',
  						)
  					),
  					'label_prefix'    => esc_html__( 'Images', 'divi-bodyshop-woocommerce' ),
  				),
  			),

        'box_shadow' => array(
  'default' => array(),
  'image' => array(
    'css' => array(
        'main'  => "{$this->main_css_element} .woocommerce-product-gallery .flex-viewport, {$this->main_css_element} .flex-control-thumbs li",
        'important' => 'all',
				'overlay' => 'inset',
    ),
    'label'    => esc_html__( 'Images', 'divi-bodyshop-woocommerce' ),
  ),
        ),

        'custom_margin_padding' => array(
      'css' => array(
        'important' => 'all',
      ),
    ),
        		);


            $this->custom_css_fields = array(
          			'gallery_item' => array(
          				'label'    => esc_html__( 'Gallery Item', 'divi-bodyshop-woocommerce' ),
          				'selector' => '.et_pb_gallery_item',
          			),
          			'overlay' => array(
          				'label'    => esc_html__( 'Overlay', 'divi-bodyshop-woocommerce' ),
          				'selector' => '.et_overlay',
          			),
          			'overlay_icon' => array(
          				'label'    => esc_html__( 'Overlay Icon', 'divi-bodyshop-woocommerce' ),
          				'selector' => '.et_overlay:before',
          			),
          			'gallery_item_title' => array(
          				'label'    => esc_html__( 'Gallery Item Title', 'divi-bodyshop-woocommerce' ),
          				'selector' => '.et_pb_gallery_title',
          			),
          			'gallery_item_caption' => array(
          				'label'    => esc_html__( 'Gallery Item Caption', 'divi-bodyshop-woocommerce' ),
          				'selector' => '.et_pb_gallery_caption',
          			),
          			'gallery_pagination' => array(
          				'label'    => esc_html__( 'Gallery Pagination', 'divi-bodyshop-woocommerce' ),
          				'selector' => '.et_pb_gallery_pagination',
          			),
          			'gallery_pagination_active' => array(
          				'label'    => esc_html__( 'Pagination Active Page', 'divi-bodyshop-woocommerce' ),
          				'selector' => '.et_pb_gallery_pagination a.active',
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
                        'gallery_style' => array(
                            'label'           => __( 'Gallery Style', 'divi-bodyshop-woocommerce' ),
                            'type'            => 'select',
                            'option_category' => 'basic_option',
                    				'computed_affects' => array(
                    					'__getprogallery',
                    				),
                            'options'           => array(
                              'default' => esc_html__( 'Default', 'divi-bodyshop-woocommerce' ),
                              'single'  => esc_html__( 'Single Slider', 'divi-bodyshop-woocommerce' ),
                              'horizontal'  => esc_html__( 'Horizontal Slider', 'divi-bodyshop-woocommerce' ),
                              'vertical'  => esc_html__( 'Vertical Slider', 'divi-bodyshop-woocommerce' ),
                              'expandable'  => esc_html__( 'Expandable', 'divi-bodyshop-woocommerce' ),
                        ),
                        'toggle_slug'         => 'gallery',
                            'description'       => __( 'Choose the gallery style you wish to use.', 'divi-bodyshop-woocommerce' ),

                        ),
			'disable_lightbox_sliders' => array(
				'label' => esc_html__( 'Disable Lightbox (Custom Sliders)', 'divi-bodyshop-woocommerce' ),
				'description' => esc_html__( 'Enabling this option will disable the lightbox slider for the images', 'divi-bodyshop-woocommerce' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array(
					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
				),
				'toggle_slug' => 'gallery',
			),
'disable_zoom_sliders' => array(
'label' => esc_html__( 'Disable Image Zoom (Custom Sliders)', 'divi-bodyshop-woocommerce' ),
'description' => esc_html__( 'Enabling this option will disable the image zoom for the images', 'divi-bodyshop-woocommerce' ),
'type' => 'yes_no_button',
'options_category' => 'configuration',
'options' => array(
'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
),
'toggle_slug' => 'gallery',
),
'enable_image_title_sliders' => array(
'label' => esc_html__( 'Enable Name Title (Custom Sliders)', 'divi-bodyshop-woocommerce' ),
'description' => esc_html__( 'Enabling this option will add the image name below the image', 'divi-bodyshop-woocommerce' ),
'type' => 'yes_no_button',
'options_category' => 'configuration',
'default' => 'off',
'options' => array(
'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
),
'toggle_slug' => 'gallery',
),
			'disable_lightbox' => array(
				'label' => esc_html__( 'Disable Lightbox (Default Gallery)', 'divi-bodyshop-woocommerce' ),
				'description' => esc_html__( 'Enabling this option will hide the magnifying glass over the image.', 'divi-bodyshop-woocommerce' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array(
					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
				),
				'toggle_slug' => 'gallery',
			),
                        'hide_thumbnails' => array(
                                    'label'           => __( 'Hide Thumbnails? (Default Gallery)', 'divi-bodyshop-woocommerce' ),
                                    'type'            => 'yes_no_button',
                                    'option_category' => 'configuration',
                                    'options'         => array(
                                                    'off' => __( 'No', 'divi-bodyshop-woocommerce' ),
                                                    'on'  => __( 'Yes', 'divi-bodyshop-woocommerce' ),
                                    ),
                            				'toggle_slug'         => 'gallery',
                                    'description'       => __( 'If you would like to hide the thumbnails then select Yes', 'divi-bodyshop-woocommerce' ),
                        ),
                        'main_image_height' => array(
                                    'label'           => __( 'Adaptive image height', 'divi-bodyshop-woocommerce' ),
                                    'type'            => 'yes_no_button',
                                    'option_category' => 'configuration',
                                    'options'         => array(
                                                    'off' => __( 'No', 'divi-bodyshop-woocommerce' ),
                                                    'on'  => __( 'Yes', 'divi-bodyshop-woocommerce' ),
                                    ),
                                    'default' => 'on',
                            				'toggle_slug'         => 'slider_settings',
                                    'description'       => __( 'The main image gets set a certain height - set to "yes" to be auto for this not to be a set height.', 'divi-bodyshop-woocommerce' ),
                        ),
                        'main_image_size' => array(
                          'label'           => esc_html__( 'Main Image Size', 'divi-bodyshop-woocommerce' ),
                          'type'            => 'select',
                          'option_category' => 'configuration',
                          'options'         => array(
                            'default' => esc_html__( 'Default', 'divi-bodyshop-woocommerce' ),
                            'full-size'  => esc_html__( 'Full Size', 'divi-bodyshop-woocommerce' ),
                          ),
                          'default'         	=> 'default',
                          'toggle_slug'     => 'slider_settings',
                          'description'       => esc_html__( 'Choose the size of image you want to serve, if you are having issues with them looking blury, enable full size.', 'divi-bodyshop-woocommerce' ),
                        ),
                  //       'custom_image' => array(
                  //         'label'           => esc_html__( 'Custom Image shown/slide', 'divi-bodyshop-woocommerce' ),
                  //         'type'            => 'yes_no_button',
                  //         'option_category' => 'configuration',
                  //         'options'         => array(
                  //           'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                  //           'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                  //         ),
                  //         'toggle_slug'     => 'slider_settings',
                  //         'affects'         => array(
                  //           'posts_number_desktop',
                  // 'posts_number_desktop_slide',
                  // 'posts_number_tablet',
                  // 'posts_number_slide_tablet',
                  // 'posts_number_tablet_land',
                  // 'posts_number_slide_tablet_land',
                  // 'posts_number_mobile',
                  // 'posts_number_slide_mobile',
                  //         ),
                  //         'description' => esc_html__( 'Change the number of images shown and the number of them that slide.', 'divi-bodyshop-woocommerce' ),
                  //         'default_on_front'=> 'off',
                  //       ),
                  //
                  //       'posts_number_desktop' => array(
                  //               'default'           => 1,
                  //               'label'             => esc_html__( 'Desktop Images Number in view', 'divi-bodyshop-woocommerce' ),
                  //               'type'              => 'text',
                  //               'option_category'   => 'configuration',
                  //               'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
                  //               'toggle_slug'       => 'slider_settings',
                  //             ),
                  //             'posts_number_desktop_slide' => array(
                  //               'default'           => 1,
                  //               'label'             => esc_html__( 'Desktop Images Number to Slide', 'divi-bodyshop-woocommerce' ),
                  //               'type'              => 'text',
                  //               'option_category'   => 'configuration',
                  //               'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
                  //               'toggle_slug'       => 'slider_settings',
                  //             ),
                  //             'posts_number_tablet' => array(
                  //               'default'           => 1,
                  //               'label'             => esc_html__( 'Tablet Portrait Images Number in view', 'divi-bodyshop-woocommerce' ),
                  //               'type'              => 'text',
                  //               'option_category'   => 'configuration',
                  //               'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
                  //               'toggle_slug'       => 'slider_settings',
                  //             ),
                  //             'posts_number_slide_tablet' => array(
                  //               'default'           => 1,
                  //               'label'             => esc_html__( 'Tablet Portrait Images Number to Slide', 'divi-bodyshop-woocommerce' ),
                  //               'type'              => 'text',
                  //               'option_category'   => 'configuration',
                  //               'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
                  //               'toggle_slug'       => 'slider_settings',
                  //             ),
                  //             'posts_number_tablet_land' => array(
                  //               'default'           => 1,
                  //               'label'             => esc_html__( 'Tablet Landscape Images Number in view', 'divi-bodyshop-woocommerce' ),
                  //               'type'              => 'text',
                  //               'option_category'   => 'configuration',
                  //               'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
                  //               'toggle_slug'       => 'slider_settings',
                  //             ),
                  //             'posts_number_slide_tablet_land' => array(
                  //               'default'           => 1,
                  //               'label'             => esc_html__( 'Tablet Landscape Images Number to Slide', 'divi-bodyshop-woocommerce' ),
                  //               'type'              => 'text',
                  //               'option_category'   => 'configuration',
                  //               'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
                  //               'toggle_slug'       => 'slider_settings',
                  //             ),
                  //             'posts_number_mobile' => array(
                  //               'default'           => 1,
                  //               'label'             => esc_html__( 'Mobile Images Number in view', 'divi-bodyshop-woocommerce' ),
                  //               'type'              => 'text',
                  //               'option_category'   => 'configuration',
                  //               'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
                  //               'toggle_slug'       => 'slider_settings',
                  //             ),
                  //             'posts_number_slide_mobile' => array(
                  //               'default'           => 1,
                  //               'label'             => esc_html__( 'Mobile Images Number to Slide', 'divi-bodyshop-woocommerce' ),
                  //               'type'              => 'text',
                  //               'option_category'   => 'configuration',
                  //               'description'       => esc_html__( 'Define the number of images that should be displayed per page.', 'divi-bodyshop-woocommerce' ),
                  //               'toggle_slug'       => 'slider_settings',
                  //             ),


                        'use_icon' => array(
                          'label'           => esc_html__( 'Custom arrows icon & color?', 'divi-bodyshop-woocommerce' ),
                          'type'            => 'yes_no_button',
                          'option_category' => 'configuration',
                          'options'         => array(
                            'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                            'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                          ),
                          'toggle_slug'     => 'slider_settings',
                          'affects'         => array(
                            'font_icon',
                            'icon_color',
                            'font_icon_next',
                            'icon_color_next',
                            'icon_font_size',
                            'icon_font_size_next',
                            'icon_font_top',
                            'icon_font_top_next',
                          ),
                          'description' => esc_html__( 'Customise the custom gallery slider icons here.', 'divi-bodyshop-woocommerce' ),
                          'default_on_front'=> 'off',
                        ),
'font_icon' => array(
  'label'               => esc_html__( 'Previous Icon', 'divi-bodyshop-woocommerce' ),
  'type'                => 'select_icon',
  'option_category'     => 'configuration',
  'class'               => array( 'et-pb-font-icon' ),
  'description'         => esc_html__( 'Choose the previous icon', 'divi-bodyshop-woocommerce' ),
  'depends_show_if'     => 'on',
  'toggle_slug'     => 'slider_settings',
),
'icon_color' => array(
  'default'           => '#2ea3f2',
  'label'             => esc_html__( 'Previous Icon Color', 'divi-bodyshop-woocommerce' ),
  'type'              => 'color-alpha',
  'option_category'     => 'configuration',
  'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi-bodyshop-woocommerce' ),
  'depends_show_if'   => 'on',
  'toggle_slug'     => 'slider_settings',
),
'icon_font_size' => array(
  'label'           => esc_html__( 'Previous Icon Font Size', 'divi-bodyshop-woocommerce' ),
  'type'            => 'range',
  'option_category' => 'configuration',
  'toggle_slug'     => 'slider_settings',
  'default'         => '56px',
  'default_unit'    => 'px',
  'default_on_front'=> '',
  'range_settings' => array(
    'min'  => '1',
    'max'  => '120',
    'step' => '1',
  ),
  'depends_show_if' => 'on',
),
'icon_font_top' => array(
  'label'           => esc_html__( 'Previous Icon Top', 'divi-bodyshop-woocommerce' ),
  'type'            => 'range',
  'option_category' => 'configuration',
  'toggle_slug'     => 'slider_settings',
  'description'       => esc_html__( 'Choose how far from the top you want the icon', 'divi-bodyshop-woocommerce' ),
  'default'         => '0px',
  'default_unit'    => 'px',
  'default_on_front'=> '',
  'range_settings' => array(
    'min'  => '0',
    'max'  => '500',
    'step' => '1',
  ),
  'depends_show_if' => 'on',
),
'font_icon_next' => array(
'label'               => esc_html__( 'Next Icon', 'divi-bodyshop-woocommerce' ),
'type'                => 'select_icon',
'option_category'     => 'configuration',
'class'               => array( 'et-pb-font-icon' ),
'toggle_slug'         => 'slider_settings',
'description'         => esc_html__( 'Choose the next icon.', 'divi-bodyshop-woocommerce' ),
'depends_show_if'     => 'on',
),
'icon_color_next' => array(
'default'           => '#2ea3f2',
'label'             => esc_html__( 'Next Icon Color', 'divi-bodyshop-woocommerce' ),
'type'              => 'color-alpha',
'option_category'     => 'configuration',
'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi-bodyshop-woocommerce' ),
'depends_show_if'   => 'on',
'toggle_slug'     => 'slider_settings',
),
'icon_font_size_next' => array(
'label'           => esc_html__( 'Next Icon Font Size', 'divi-bodyshop-woocommerce' ),
'type'            => 'range',
'option_category' => 'configuration',
'toggle_slug'     => 'slider_settings',
'default'         => '56px',
'default_unit'    => 'px',
'default_on_front'=> '',
'range_settings' => array(
'min'  => '1',
'max'  => '120',
'step' => '1',
),
'depends_show_if' => 'on',
),
'icon_font_top_next' => array(
'label'           => esc_html__( 'Next Icon Top', 'divi-bodyshop-woocommerce' ),
'type'            => 'range',
'option_category' => 'configuration',
'toggle_slug'     => 'slider_settings',
'description'       => esc_html__( 'Choose how far from the top you want the icon', 'divi-bodyshop-woocommerce' ),
'default'         => '0px',
'default_unit'    => 'px',
'default_on_front'=> '',
'range_settings' => array(
'min'  => '0',
'max'  => '500',
'step' => '1',
),
'depends_show_if' => 'on',
),

'dots_color' => array(
  'label'           => esc_html__( 'Custom navigation dots size & color', 'divi-bodyshop-woocommerce' ),
  'type'            => 'yes_no_button',
  'option_category' => 'configuration',
  'options'         => array(
    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
    'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
  ),
  'toggle_slug'     => 'slider_settings',
  'affects'         => array(
    'active_color',
    'deactive_color',
    'dots_size',
  ),
  'description' => esc_html__( 'Customise the custom gallery slider icons here.', 'divi-bodyshop-woocommerce' ),
  'default_on_front'=> 'off',
),
'active_color' => array(
'default'           => '#000000',
'label'             => esc_html__( 'Active dot color', 'divi-bodyshop-woocommerce' ),
'type'              => 'color-alpha',
'option_category'     => 'configuration',
'description'       => esc_html__( 'Change the color of the active dot.', 'divi-bodyshop-woocommerce' ),
'depends_show_if'   => 'on',
'toggle_slug'     => 'slider_settings',
),
'deactive_color' => array(
'default'           => '#ececec',
'label'             => esc_html__( 'Deactive dot color', 'divi-bodyshop-woocommerce' ),
'type'              => 'color-alpha',
'option_category'     => 'configuration',
'description'       => esc_html__( 'Change the color of the deactive dot.', 'divi-bodyshop-woocommerce' ),
'depends_show_if'   => 'on',
'toggle_slug'     => 'slider_settings',
),
'dots_size' => array(
'label'           => esc_html__( 'Dot size', 'divi-bodyshop-woocommerce' ),
'type'            => 'range',
'option_category' => 'configuration',
'toggle_slug'     => 'slider_settings',
'default'         => '20px',
'default_unit'    => 'px',
'default_on_front'=> '',
'range_settings' => array(
'min'  => '1',
'max'  => '120',
'step' => '1',
),
'depends_show_if' => 'on',
),

			'auto' => array(
				'label'           => esc_html__( 'Automatic Animation', 'divi-bodyshop-woocommerce' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'Off', 'divi-bodyshop-woocommerce' ),
					'on'  => esc_html__( 'On', 'divi-bodyshop-woocommerce' ),
				),
				'affects' => array(
					'auto_speed',
				),
        'toggle_slug'     => 'slider_settings',
				'description'       => esc_html__( 'If you would like the slider to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'divi-bodyshop-woocommerce' ),
			),
			'auto_speed' => array(
				'label'             => esc_html__( 'Automatic Animation Speed (in ms)', 'divi-bodyshop-woocommerce' ),
				'type'              => 'text',
        'option_category' => 'configuration',
        'toggle_slug'     => 'slider_settings',
				'default'         	=> '7000',
				'depends_show_if' 	=> 'on',
				'description'       => esc_html__( "Here you can designate how fast the slider fades between each slide, if 'Automatic Animation' option is enabled above. The higher the number the longer the pause between each rotation.", 'divi-bodyshop-woocommerce' ),
			),

      'enable_arrows' => array(
				'label'           => esc_html__( 'Show Arrows', 'divi-bodyshop-woocommerce' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'false' => esc_html__( 'Disable', 'divi-bodyshop-woocommerce' ),
					'true'  => esc_html__( 'Enable', 'divi-bodyshop-woocommerce' ),
				),
				'default'         	=> 'true',
        'toggle_slug'     => 'slider_settings',
				'description'       => esc_html__( 'If you do not want the arrows, disable this.', 'divi-bodyshop-woocommerce' ),
			),

      'arrow_location' => array(
				'label'           => esc_html__( 'Vertical/Horizontal Slider Arrow Postion on Dekstop', 'divi-bodyshop-woocommerce' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'thumbnails' => esc_html__( 'Thumbnails', 'divi-bodyshop-woocommerce' ),
					'main'  => esc_html__( 'Main Image', 'divi-bodyshop-woocommerce' ),
				),
				'default'         	=> 'thumbnails',
        'toggle_slug'     => 'slider_settings',
				'description'       => esc_html__( 'If you are using the vertical or horizontal slider, choose where you want the arrows to be.', 'divi-bodyshop-woocommerce' ),
			),

      'enable_dots' => array(
				'label'           => esc_html__( 'Show Dots', 'divi-bodyshop-woocommerce' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'false' => esc_html__( 'Disable', 'divi-bodyshop-woocommerce' ),
					'true'  => esc_html__( 'Enable', 'divi-bodyshop-woocommerce' ),
				),
				'default'         	=> 'true',
        'toggle_slug'     => 'slider_settings',
				'description'       => esc_html__( 'If you do not want the dots, disable this.', 'divi-bodyshop-woocommerce' ),
			),

      'enable_fade' => array(
				'label'           => esc_html__( 'Enable Fade', 'divi-bodyshop-woocommerce' ),
        'type'            => 'yes_no_button',
        'option_category' => 'configuration',
        'options'         => array(
          'off' => esc_html__( 'Off', 'divi-bodyshop-woocommerce' ),
          'on'  => esc_html__( 'On', 'divi-bodyshop-woocommerce' ),
        ),
				'default'         	=> 'on',
        'affects' => array(
          'css_ease',
        ),
        'toggle_slug'     => 'slider_settings',
				'description'       => esc_html__( 'If you do not want to enable image fade, enable this.', 'divi-bodyshop-woocommerce' ),
			),

      'css_ease' => array(
				'label'           => esc_html__( 'CSS Ease', 'divi-bodyshop-woocommerce' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'linear' => esc_html__( 'Linear', 'divi-bodyshop-woocommerce' ),
					'ease'  => esc_html__( 'Ease', 'divi-bodyshop-woocommerce' ),
					'ease-in'  => esc_html__( 'Ease In', 'divi-bodyshop-woocommerce' ),
					'ease-out'  => esc_html__( 'Ease Out', 'divi-bodyshop-woocommerce' ),
					'ease-in-out'  => esc_html__( 'Ease In Out', 'divi-bodyshop-woocommerce' ),
				),
				'default'         	=> 'linear',
        'toggle_slug'     => 'slider_settings',
				'description'       => esc_html__( 'If you want to add an image fade transition, enable this.', 'divi-bodyshop-woocommerce' ),
			),

      'thumb_image_size' => array(
        'label'           => esc_html__( 'Thumbnail Image Size', 'divi-bodyshop-woocommerce' ),
        'type'            => 'select',
        'option_category' => 'configuration',
        'options'         => array(
          'default' => esc_html__( 'Default', 'divi-bodyshop-woocommerce' ),
          'full-size'  => esc_html__( 'Full Size', 'divi-bodyshop-woocommerce' ),
        ),
        'default'         	=> 'default',
        'toggle_slug'     => 'slider_thumb_settings',
        'description'       => esc_html__( 'Choose the size of image you want to serve for your thumbnails, if you are having issues with them looking blury, enable full size.', 'divi-bodyshop-woocommerce' ),
      ),
      'thumb_slides_show' => array(
                    'default'           => 1,
                    'label'             => esc_html__( 'Slides to show', 'divi-bodyshop-woocommerce' ),
                    'type'              => 'text',
                    'option_category'   => 'configuration',
            				'default'         	=> '3',
                    'description'       => esc_html__( 'Define the number of thumbnails you want to show in one go.', 'divi-bodyshop-woocommerce' ),
                    'toggle_slug'       => 'slider_thumb_settings',
                  ),

                  'thumb_slides_scroll' => array(
                                'default'           => 1,
                                'label'             => esc_html__( 'Slides to scroll', 'divi-bodyshop-woocommerce' ),
                                'type'              => 'text',
                                'option_category'   => 'configuration',
                        				'default'         	=> '1',
                                'description'       => esc_html__( 'Define how many you want to scroll.', 'divi-bodyshop-woocommerce' ),
                                'toggle_slug'       => 'slider_thumb_settings',
                              ),


                              'center_mode' => array(
                        				'label'           => esc_html__( 'Center Thumbnails', 'divi-bodyshop-woocommerce' ),
                        				'type'            => 'select',
                        				'option_category' => 'configuration',
                        				'options'         => array(
                        					'false' => esc_html__( 'Disable', 'divi-bodyshop-woocommerce' ),
                        					'true'  => esc_html__( 'Enable', 'divi-bodyshop-woocommerce' ),
                        				),
                        				'default'         	=> 'true',
                                'toggle_slug'     => 'slider_thumb_settings',
                        				'description'       => esc_html__( 'If you want to center the thumnails, enable this. Disable if you want the thumbnails to fit edge to edge.', 'divi-bodyshop-woocommerce' ),
                        			),
                              'admin_label' => array(
                                  'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                                  'type'        => 'text',
                                  'toggle_slug'     => 'main_content',
                                  'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                              ),
                              '__getprogallery' => array(
                              'type' => 'computed',
                              'computed_callback' => array( 'db_images_code', 'get_pro_gallery' ),
                              'computed_depends_on' => array(
                              'gallery_style'
                              ),
                              ),
                      );

                      return $fields;
                  }


                  public static function get_pro_gallery( $args = array(), $conditional_tags = array(), $current_page = array() ){
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

do_action( 'woocommerce_before_single_product_summary' );

              //*---------------------------------------------------------------------------------------------------*//

                    $first = false;
                } else {

                }
              endwhile; wp_reset_query(); // Remember to reset


                    $data = ob_get_clean();

                  return $data;

                  }

                  function render( $attrs, $content = null, $render_slug ) {

                    $hide_thumbnails         = $this->props['hide_thumbnails'];
                    $gallery_style           = $this->props['gallery_style'];
		                 $disable_lightbox     = $this->props['disable_lightbox'];
 		                 $disable_lightbox_sliders     = $this->props['disable_lightbox_sliders'];
 		                 $disable_zoom_sliders     = $this->props['disable_zoom_sliders'];

                    $use_icon                = $this->props['use_icon'];
                    $font_icon               = $this->props['font_icon'];
                    $font_icon_next          = $this->props['font_icon_next'];
                    $icon_color              = $this->props['icon_color'];
                    $icon_font_size          = $this->props['icon_font_size'];
                    $icon_color_next         = $this->props['icon_color_next'];
                    $icon_font_size_next     = $this->props['icon_font_size_next'];
                    $icon_top                = $this->props['icon_font_top'];
                    $icon_top_next           = $this->props['icon_font_top_next'];

                    $enable_image_title_sliders           = $this->props['enable_image_title_sliders'];


                    $num = mt_rand(100000,999999);

                    $css_class              = $render_slug . "_" . $num;

                    $auto                = $this->props['auto'];
                    $auto_speed          = $this->props['auto_speed'];

                    $thumb_slides_show         = $this->props['thumb_slides_show'];
                    $thumb_slides_scroll         = $this->props['thumb_slides_scroll'];

                    $main_image_height         = $this->props['main_image_height'];


                    $enable_arrows          = $this->props['enable_arrows'];
                    $arrow_location           = $this->props['arrow_location'];

                    if ($arrow_location == "main" && $enable_arrows == "true") {
                      $arrow_location_main = "true";
                      $arrow_location_thumb = "false";
                    } else {
                      $arrow_location_main = "false";
                      $arrow_location_thumb = "true";
                    }


                    $enable_dots          = $this->props['enable_dots'];
                    $enable_fade          = $this->props['enable_fade'];
                    $css_ease          = $this->props['css_ease'];
                    $center_mode          = $this->props['center_mode'];


                    $active_color         = $this->props['active_color'];
                    $deactive_color          = $this->props['deactive_color'];
                    $dots_size          = $this->props['dots_size'];



                    $main_image_size         = $this->props['main_image_size'];
                    $thumb_image_size         = $this->props['thumb_image_size'];


                    if ($enable_fade == "on") {
                      $enable_fade = "true";
                    }
                    else {
                      $enable_fade = "false";
                    }



                    if ($main_image_height == "on") {
                      $this->add_classname( 'adaptive_height' );
                        $main_image_height_dis = "";
                    } else {
                        $main_image_height_dis = ".slick-list {height: 100%!important;};";
                            }



                            global $db_woo_li_image_size, $db_woo_li_thumbnail_size, $db_woo_li_thumbnail_cols;

                            if (is_admin()) {
                                return;
                            }


                    $font_icon_dis = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $font_icon ) );
                    $font_icon_next_dis = preg_replace( '/(&amp;#x)|;/', '', et_pb_process_font_icon( $font_icon_next ) );

                    $db_woo_li_thumbnail_cols_css = 'inherit';

                    if ($hide_thumbnails == 'on') {
                        remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
                        $db_woo_li_thumbnail_cols_css = '';
                    } else {

                    }

                    if( 'on' === $auto ) {
                      $autoslide = "autoplay: true,";
                      $autoislidespeed = "autoplaySpeed: ".$auto_speed.",";
                    }
                    else {
                      $autoslide = "autoplay: false,";
                      $autoislidespeed = "autoplaySpeed: 7000,";
                    }

                    if( $disable_lightbox == 'on' ){

    ET_Builder_Element::set_style( $render_slug, array(
      'selector'    => '%%order_class%% .woocommerce-product-gallery__trigger',
      'declaration' => 'display:none !important;',
    ) );
  }

  if( $enable_image_title_sliders == 'on' ){
ET_Builder_Element::set_style( $render_slug, array(
'selector'    => '%%order_class%% .thumb-title',
'declaration' => 'display:block !important;',
) );
}


                  //////////////////////////////////////////////////////////////////////


                                  if( is_admin() ){
                                    return;
                                  }

                                  ob_start();
                                  if ($use_icon == "on") {

                                  $content_prev =  sprintf('<style>.et_pb_db_images .slick-prev::before {content:"\%1s" !important;font-size:%2s;color:%3s;top:%4s;}</style>',$font_icon_dis, $icon_font_size, $icon_color, $icon_top);
                                  $content_next =  sprintf('<style>.et_pb_db_images .slick-next::before {content:"\%1s" !important;font-size:%2s;color:%3s;top:%4s;}</style>',$font_icon_next_dis, $icon_font_size_next, $icon_color_next, $icon_top_next );

                                  echo $content_prev;
                                  echo $content_next;

                                  }
echo '<style>'.$main_image_height_dis.'body .slick-dots li button {background: '. $deactive_color .' !important;width: '. $dots_size .';height: '. $dots_size .';}body .slick-dots li.slick-active button {background: '. $active_color .' !important;}.woocommerce #content div.product div.images, .woocommerce div.product div.images, .woocommerce-page #content div.product div.images, .woocommerce-page div.product div.images { width: 100% !important; }.woocommerce div.product div.images .woocommerce-main-image img { width: inherit !important; }' . ($db_woo_li_thumbnail_cols && $db_woo_li_thumbnail_cols_css ? '.woocommerce #content div.product div.thumbnails a, .woocommerce div.product div.thumbnails a, .woocommerce-page #content div.product div.thumbnails a, .woocommerce-page div.product div.thumbnails a, .woocommerce div.product div.images .woocommerce-product-gallery__image:nth-child(n+2) { width: ' . $db_woo_li_thumbnail_cols_css . ' !important; }':'') . '</style>';



                                  if ($gallery_style == "default"){

                                    global $product, $woocommerce;


                          wc_get_template( 'single-product/product-image.php' );
                          wc_get_template( 'single-product/sale-flash.php' );



                                  }
                                  else if ($gallery_style == "horizontal" || $gallery_style == "single"){

                                    wc_get_template( 'single-product/sale-flash.php' );

                                    $this->add_classname( 'bc-custom-slider' );

                                    wp_enqueue_script( 'bodycommerce-product-gallery', plugins_url() . '/divi-bodycommerce/scripts/product-gallery.min.js', array('jquery'), DE_DB_WOO_VERSION, true );

                                    global $post, $woocommerce, $product;


                                    if (has_post_thumbnail()) {

                                    $post_thumbnail_id = $product->get_image_id();
                                    $image         = wp_get_attachment_image($post_thumbnail_id, 'shop_single', true,array( "class" => "attachment-shop_single size-shop_single wp-post-image" ));


                                    $wrapper_classes = apply_filters('woocommerce_single_product_image_gallery_classes', array(
                                        'debodycommerce',
                                        'debodycommerce--' . (has_post_thumbnail() ? 'with-images' : 'without-images'),
                                        'images',

                                    ));

                                                                      ?>
                                  <div class="<?php echo $css_class ?>">


                                    <?php if ($disable_zoom_sliders == "off") {
                                      $css_mag= "magnify";
                                    } else {
                                      $css_mag = "";
                                    }
                                    ?>

                                    <?php if ($disable_lightbox_sliders == "off") {
                                      $css_lightbox = "venobox ".$css_mag."";
                                      ?>
                                      <span href="#" class="woocommerce-product-gallery__trigger"></span>
                                      <?php
                                    } else {
                                      $css_lightbox = "no-venobox ".$css_mag."";
                                    }
                                    ?>

<?php if ($gallery_style == "horizontal") { ?>
                                  <div class="bc-horizontal-slider-for <?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>">
<?php } else if ($gallery_style == "single") { ?>
                                  <div class="bc-simple-slider <?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>">
<?php }



    $lightbox_src = wc_get_product_attachment_props($post_thumbnail_id);
$title = get_post(get_post_thumbnail_id())->post_title;
  $featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');


    echo '<div class="woocommerce-product-gallery__image single-product-main-image"><a class="'.$css_lightbox.'"  title="'.$lightbox_src['title'].'" data-gall="debodycommerce-lightbox" href="'.$lightbox_src['url'].'" >';
if( isset($featured_img_url) ){
    echo  '<div class="large" style="background-image: url('. $featured_img_url .');background-repeat:no-repeat"></div>';
  }
    echo $image;
    ?>
  <?php if ($disable_zoom_sliders == "off") { ?>
    <img src="<?php echo $featured_img_url ?>" class="imagezoom">
    <?php
  } else {  }
  ?>
  </a>
  <p class="thumb-title" style="padding-bottom: 30px;display:none;"><?php echo esc_html ($title); ?></p>
</div>
    <?php

      $attachment_ids = $product->get_gallery_image_ids();

    if ($attachment_ids) {
        foreach ($attachment_ids as $attachment_id) {

          if ($main_image_size == "default") {
             $thumbnail_image     = wp_get_attachment_image($attachment_id, 'shop_single');
          } else {
            $thumbnail_image     = wp_get_attachment_image($attachment_id, 'full');
          }

             $lightbox_src = wc_get_product_attachment_props($attachment_id);
             $full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
             $attachment_title = get_the_title($attachment_id);
            // fw_print($thumbnail_src);
            ?>
            <div class="bodycommerce-slider-cont"> <?php
              echo '<a class="'.$css_lightbox.'" data-gall="debodycommerce-lightbox" title="'.$lightbox_src['title'].'" href="'.$lightbox_src['url'].'" >';
if( isset($featured_img_url) ){
              echo  '<div class="large" style="background-image: url('. $full_size_image[0] .');background-repeat:no-repeat"></div>';
            }
              echo  $thumbnail_image;
              ?>
            <?php if ($disable_zoom_sliders == "off") { ?>
              <img src="<?php echo $full_size_image[0] ?>" class="imagezoom">
              <?php
            } else {  }
              ?>
              </a>
              <p class="thumb-title" style="padding-bottom: 30px;display:none;"><?php echo esc_html ($attachment_title); ?></p>
              </div>
              <?php

        }
    }
                                    ?>
                                    </div>

<?php
$post_thumbnail_id = $product->get_image_id();


 $attachment_ids = $product->get_gallery_image_ids() ;

$gallery_thumbnail = wc_get_image_size('gallery_thumbnail');

if ( $attachment_ids && has_post_thumbnail() ) {
 ?>

                                  <div class="bc-horizontal-slider-nav">
                                  <?php

  if ($thumb_image_size == "default") {
$image         = wp_get_attachment_image($post_thumbnail_id, 'shop_thumbnail',true);
  } else {
$image         = wp_get_attachment_image($post_thumbnail_id, 'full',true);
  }

	echo '<div>'.$image.'</div>';

	foreach ( $attachment_ids as $attachment_id ) {

     if ($thumb_image_size == "default") {
     $thumbnail_size    = apply_filters('woocommerce_gallery_thumbnail_size', array($gallery_thumbnail['width'], $gallery_thumbnail['height']));
   		 $thumbnail_image     = wp_get_attachment_image($attachment_id, $thumbnail_size);
     } else {
   		 $thumbnail_image     = wp_get_attachment_image($attachment_id, 'full',true);
     }

              echo '<div>' . $thumbnail_image . '</div>';
	} ?>
                                  </div>
<?php } ?>

                                  </div>
                                  <?php
                                                            }
                                   ?>

                                   <?php if ($gallery_style == "horizontal") { ?>
<script>
jQuery(document).ready(function( $ ) {$(".no-venobox").click(function( event ) {event.preventDefault();});$('.<?php echo $css_class ?> .bc-horizontal-slider-for').slick({adaptiveHeight: true,<?php echo $autoslide; echo $autoislidespeed;?>slidesToShow: 1,slidesToScroll: 1,fade: <?php echo $enable_fade ?>,cssEase: '<?php echo $css_ease ?>',asNavFor: '.<?php echo $css_class ?> .bc-horizontal-slider-nav',draggable: true,arrows: <?php echo $arrow_location_main ?>,responsive: [{breakpoint: 980,settings: {slidesToShow: 1,slidesToScroll: 1,infinite: true,arrows: true,dots:  <?php echo $enable_dots ?>,asNavFor: null}}]});$('.<?php echo $css_class ?> .bc-horizontal-slider-nav').slick({slidesToShow: <?php echo $thumb_slides_show ?>,slidesToScroll:  <?php echo $thumb_slides_scroll ?>,asNavFor: '.<?php echo $css_class ?> .bc-horizontal-slider-for',dots:  <?php echo $enable_dots ?>,centerMode: <?php echo $center_mode ?>,arrows: <?php echo $arrow_location_thumb ?>,focusOnSelect: true,draggable: true,});});
</script>
                                   <?php } else if ($gallery_style == "single") { ?>
<script>
jQuery(document).ready(function( $ ) {$(".no-venobox").click(function( event ) {event.preventDefault();});$('.<?php echo $css_class ?> .bc-simple-slider').slick({adaptiveHeight: true,<?php echo $autoslide;echo $autoislidespeed;?>slidesToShow: 1,slidesToScroll: 1,fade: <?php echo $enable_fade ?>,cssEase: '<?php echo $css_ease ?>',asNavFor: '.<?php echo $css_class ?> .bc-horizontal-slider-nav',draggable: true,arrows: <?php echo $enable_arrows ?>,dots:  <?php echo $enable_dots ?>,responsive: [{breakpoint: 980,settings: {slidesToShow: 1,slidesToScroll: 1,infinite: true,arrows: <?php echo $enable_arrows ?>,dots:  <?php echo $enable_dots ?>,asNavFor: null}}]});$('.<?php echo $css_class ?> .bc-horizontal-slider-nav').slick({dots: false,slidesToShow: <?php echo $thumb_slides_show ?>,slidesToScroll:  <?php echo $thumb_slides_scroll ?>,asNavFor: '.<?php echo $css_class ?> .bc-simple-slider',dots:  false,centerMode: <?php echo $center_mode ?>,focusOnSelect: true,draggable: true,});});
</script>
                                   <?php }
                                  }
                                  else if ($gallery_style == "vertical"){


                                      wc_get_template( 'single-product/sale-flash.php' );


                                      $this->add_classname( 'bc-custom-slider' );

                                      wp_enqueue_script( 'bodycommerce-product-gallery', plugins_url() . '/divi-bodycommerce/scripts/product-gallery.min.js', array('jquery'), DE_DB_WOO_VERSION, true );

                                      global $post, $woocommerce, $product;
                                      $post_thumbnail_id = $product->get_image_id();
                                      $image         = wp_get_attachment_image($post_thumbnail_id, 'shop_single', true,array( "class" => "attachment-shop_single size-shop_single wp-post-image" ));

                                                                          if ( has_post_thumbnail() ) {
                                                                            $lightbox_src = wc_get_product_attachment_props($post_thumbnail_id);

                                                                            $wrapper_classes = apply_filters('woocommerce_single_product_image_gallery_classes', array(
                                                                              'debodycommerce',
                                                                              'debodycommerce--' . (has_post_thumbnail() ? 'with-images' : 'without-images'),
                                                                              'images',

                                                                            ));

                                                                        ?>
                                    <div class="<?php echo $css_class ?>">


                                      <?php if ($disable_zoom_sliders == "off") {
                                        $css_mag= "magnify";
                                      } else {
                                        $css_mag = "";
                                      }
                                      ?>

                                      <?php if ($disable_lightbox_sliders == "off") {
                                        $css_lightbox = "venobox ".$css_mag."";
                                        ?>
                                        <span href="#" class="woocommerce-product-gallery__trigger"></span>
                                        <?php
                                      } else {
                                        $css_lightbox = "no-venobox ".$css_mag."";
                                      }
                                      ?>
<div class="bc-vertical-wrapper">

                                    <div class="bc-vertical-slider-for <?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>" style="height: 400px;">
                                      <?php



                                          $lightbox_src = wc_get_product_attachment_props($post_thumbnail_id);




                              $featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');
                          $title = get_post(get_post_thumbnail_id())->post_title;



                                          echo '<div class="woocommerce-product-gallery__image single-product-main-image"><a class="'.$css_lightbox.'"  title="'.$lightbox_src['title'].'" data-gall="debodycommerce-lightbox" href="'.$lightbox_src['url'].'" >';
                                          if( isset($featured_img_url) ){
                                          echo  '<div class="large" style="background-image: url('. $featured_img_url .');background-repeat:no-repeat"></div>';
                                          }
                                          echo $image;
    ?>
  <?php if ($disable_zoom_sliders == "off") { ?>
    <img src="<?php echo $featured_img_url ?>" class="imagezoom">
    <?php
  } else {  }
  ?>
  </a>
  <p class="thumb-title" style="padding-bottom: 30px;display:none;"><?php echo esc_html ($title); ?></p>
</div>
    <?php

                                      $attachment_ids = $product->get_gallery_image_ids();
                                      if ($attachment_ids) {
                                          foreach ($attachment_ids as $attachment_id) {

                                            if ($main_image_size == "default") {
                                               $thumbnail_image     = wp_get_attachment_image($attachment_id, 'shop_single');
                                            } else {
                                              $thumbnail_image     = wp_get_attachment_image($attachment_id, 'full');
                                            }

                                                         $lightbox_src = wc_get_product_attachment_props($attachment_id);
                                                         $full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
                                                         $attachment_title = get_the_title($attachment_id);
                                              // fw_print($thumbnail_src);
                                              ?>
                                              <div class="bodycommerce-slider-cont"> <?php
                                              echo '<a class="'.$css_lightbox.'" data-gall="debodycommerce-lightbox" title="'.$lightbox_src['title'].'" href="'.$lightbox_src['url'].'" >';
                                              if( isset($featured_img_url) ){
                                              echo  '<div class="large" style="background-image: url('. $full_size_image[0] .');background-repeat:no-repeat"></div>';
                                              }
                                              echo  $thumbnail_image;
                                                ?>
                                                <?php if ($disable_zoom_sliders == "off") { ?>
                                                  <img src="<?php echo $full_size_image[0] ?>" class="imagezoom">
                                                  <?php
                                                } else {  }
                                                  ?>
                                                  </a>
                                                  <p class="thumb-title" style="padding-bottom: 30px;display:none;"><?php echo esc_html ($attachment_title); ?></p>
                                                  </div>
                                                  <?php

                                          }
                                      }
                                      ?>
                                      </div>

          <?php
          $post_thumbnail_id = $product->get_image_id();


          $attachment_ids = $product->get_gallery_image_ids() ;

          $gallery_thumbnail = wc_get_image_size('gallery_thumbnail');

          if ( $attachment_ids && has_post_thumbnail() ) {
          ?>

                                    <div class="bc-vertical-slider-nav">
                                  <?php


  if ($thumb_image_size == "default") {
$image         = wp_get_attachment_image($post_thumbnail_id, 'shop_thumbnail',true);
  } else {
$image         = wp_get_attachment_image($post_thumbnail_id, 'full',true);
  }

	echo '<div>'.$image.'</div>';

	foreach ( $attachment_ids as $attachment_id ) {

     if ($thumb_image_size == "default") {
     $thumbnail_size    = apply_filters('woocommerce_gallery_thumbnail_size', array($gallery_thumbnail['width'], $gallery_thumbnail['height']));
   		 $thumbnail_image     = wp_get_attachment_image($attachment_id, $thumbnail_size);
     } else {
   		 $thumbnail_image     = wp_get_attachment_image($attachment_id, 'full',true);
     }

              echo '<div>' . $thumbnail_image . '</div>';
	} ?>
                                  </div>
          <?php } ?>
                                              </div>

                                    </div>
                                    <?php
                                                              }
                                     ?>
<style>@media only screen and (max-width:980px){body .bc-vertical-slider-for .slick-next:before,body .bc-vertical-slider-for .slick-prev:before{transform:rotate(-90deg);bottom:auto!important}body .bc-vertical-slider-for .slick-prev{height:100%!important;width:50%!important;left:0!important;transform:none!important}body .bc-vertical-slider-for .slick-next{height:100%!important;width:50%!important;left:auto!important;transform:none!important;top:0!important;right:0!important}}.bc-vertical-slider-for {height: auto !important;}</style>
<script>
jQuery(document).ready(function( $ ) {$(".no-venobox").click(function( event ) {event.preventDefault();});$('.<?php echo $css_class ?> .bc-vertical-slider-for').slick({<?php echo $autoslide; echo $autoislidespeed;?>slidesToShow: 1,slidesToScroll: 1,arrows: <?php echo $arrow_location_main ?>,fade: true,asNavFor: '.<?php echo $css_class ?> .bc-vertical-slider-nav',draggable: true,responsive: [{breakpoint: 980,settings: {slidesToShow: 1,slidesToScroll: 1,infinite: true,arrows: true,dots:  <?php echo $enable_dots ?>,asNavFor: null}}]});
$('.<?php echo $css_class ?> .bc-vertical-slider-nav').slick({
  slidesToShow: <?php echo $thumb_slides_show ?>,slidesToScroll:  <?php echo $thumb_slides_scroll ?>,asNavFor: '.<?php echo $css_class ?> .bc-vertical-slider-for',centerMode: <?php echo $center_mode ?>,arrows: <?php echo $arrow_location_thumb ?>,dots:  <?php echo $enable_dots ?>,focusOnSelect: true,vertical: true,draggable: true,});var image_height = $(".<?php echo $css_class ?> .bc-vertical-slider-for.slick-initialized.slick-slider .slick-slide img").height();$( ".<?php echo $css_class ?> .bc-vertical-slider-nav" ).attr('style',  'height:' + image_height + "px !important;");$( ".<?php echo $css_class ?> .slick-slide img" ).click(function() {setTimeout(function(){var image_height = $(".<?php echo $css_class ?> .bc-vertical-slider-for.slick-initialized.slick-slider .slick-slide.slick-current.slick-active img").height();$( ".<?php echo $css_class ?> .bc-vertical-slider-nav" ).attr('style',  'height:' + image_height + "px !important;");}, 200);});
$( window ).resize(function() {var image_height = $(".<?php echo $css_class ?> .bc-vertical-slider-for.slick-initialized.slick-slider .slick-slide.slick-current.slick-active img").height();$( ".<?php echo $css_class ?> .bc-vertical-slider-nav" ).attr('style',  'height:' + image_height + "px !important;");});});
</script>
                                  <?php
                                  }
                                  else if ($gallery_style == "expandable"){

                                    wp_enqueue_script( 'bodycommerce-product-gallery', plugins_url() . '/divi-bodycommerce/scripts/product-gallery.min.js', array('jquery'), DE_DB_WOO_VERSION, true );
                                  // if ($overlay_icon == ""){
                                  //
                                  // }
                                  // else {
                                  //   echo esc_attr( et_pb_process_font_icon( $overlay_icon ) );
                                  //   $output = sprintf( '.bc-expandable-slider .et_overlay:before {content:"\%s";}', esc_attr( et_pb_process_font_icon( $overlay_icon ) ) );
                                  // echo '<style>
                                  // '.$output.'
                                  // </style>';
                                  // }

                                  ?>
                                  <section class="bc-expandable-single-item">
                                  <div class="bc-expandable-slider-wrapper">

                                  <ul class="bc-expandable-slider">

                                  <?php
                                  global $post, $woocommerce, $product;

                                  if ( has_post_thumbnail() ) {
                                  $featured_img_url = get_the_post_thumbnail_url($post->ID, 'full');
                                  $thumb_id = get_post_thumbnail_id(get_the_ID());
                                  $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                                  ?>
                                  <li class="selected"><img src="<?php echo $featured_img_url;?>" alt="<?php echo $alt; ?>"><span class="et_overlay"></span></li>

                                  <?php

                                  $attachment_ids = $product->get_gallery_image_ids();
                                  if ( $attachment_ids && has_post_thumbnail() ) {
                                  foreach ( $attachment_ids as $attachment_id ) {
                                  $full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
                                  $alt_text = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                                  ?>

                                  <li><img src="<?php echo $full_size_image[0]; ?>" alt="<?php echo $alt_text; ?>"><span class="et_overlay"></span></li>

                                  <?php
                                  }
                                  }
                                  }
                                  ?>

                                  </ul> <!-- bc-expandable-slider -->

                                  <ul class="bc-expandable-slider-navigation">
                                  <li><a href="#0" class="bc-expandable-prev inactive">Next</a></li>
                                  <li><a href="#0" class="bc-expandable-next">Prev</a></li>
                                  </ul> <!-- bc-expandable-slider-navigation -->

                                  <a href="#0" class="bc-expandable-close">Close</a>
                                  </div> <!-- bc-expandable-slider-wrapper -->


                                  </section> <!-- bc-expandable-single-item -->

                                  <?php
                                  }
                                  else {
                            do_action( 'woocommerce_before_single_product_summary' );
                            echo "</div>";
                                  }

                                  $data = ob_get_clean();

                                   //////////////////////////////////////////////////////////////////////

                                return $data;
                  }
              }

            new db_images_code;

?>
