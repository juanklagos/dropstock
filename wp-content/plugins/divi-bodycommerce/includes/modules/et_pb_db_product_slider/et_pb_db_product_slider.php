<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_post_slider_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.G Product Slider - Global', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_product_slider';

                    $this->fields_defaults = array(
                      'featured_only'           => array( 'off' ),
                        'popular_only'           => array( 'off' ),
                			'show_arrows'             => array( 'on' ),
                			'show_pagination'         => array( 'on' ),
                			'auto'                    => array( 'off' ),
                			'auto_speed'              => array( '7000' ),
                			'auto_ignore_hover'       => array( 'off' ),
                			'parallax'                => array( 'off' ),
                			'parallax_method'         => array( 'off' ),
                			'show_inner_shadow'       => array( 'on' ),
                			'background_position'     => array( 'center' ),
                			'background_size'         => array( 'cover' ),
                			'show_content_on_mobile'  => array( 'on' ),
                			'show_cta_on_mobile'      => array( 'on' ),
                			'show_image_video_mobile' => array( 'off' ),
                			'more_text'               => array( 'Read More' ),
                			'background_color'        => array( '' ),
                			'image_placement'         => array( 'background' ),
                			'background_layout'       => array( 'dark' ),
                			'orderby'                 => array( 'date_desc' ),
                			'excerpt_length'          => array( '270' ),
                			'use_bg_overlay'          => array( 'on' ),
                			'show_more_button'        => array( 'on' ),
                			'show_image'              => array( 'on' ),
                			'text_orientation'        => array( 'center' ),
                		);

          $this->settings_modal_toggles = array(
            'general'  => array(
              'toggles' => array(
                'main_content'   => esc_html__( 'Content', 'et_builder' ),
                'elements'       => esc_html__( 'Elements', 'et_builder' ),
                'featured_image' => esc_html__( 'Featured Image', 'et_builder' ),
                'background'     => esc_html__( 'Background', 'et_builder' ),
              ),
            ),
            'advanced' => array(
              'toggles' => array(
                'layout'     => esc_html__( 'Layout', 'et_builder' ),
                'overlay'    => esc_html__( 'Overlay', 'et_builder' ),
                'navigation' => esc_html__( 'Navigation', 'et_builder' ),
                'text'       => array(
                  'title'    => esc_html__( 'Text', 'et_builder' ),
                  'priority' => 49,
                ),
              ),
            ),
			'custom_css' => array(
				'toggles' => array(
					'animation' => array(
						'title'    => esc_html__( 'Animation', 'et_builder' ),
						'priority' => 90,
					),
				),
			),

      		);


                      $this->main_css_element = '%%order_class%%.et_pb_slider';
                      $this->advanced_fields = array(
                        'fonts' => array(
                          'header' => array(
                            'label'    => esc_html__( 'Header', 'et_builder' ),
                            'css'      => array(
                              'main' => "{$this->main_css_element} .et_pb_slide_description .et_pb_slide_title",
                              'important' => array( 'size', 'font-size', 'plugin_all' ),
                            ),
                          ),
                            'price' => array(
                              'label'    => esc_html__( 'Price', 'et_builder' ),
                              'css'      => array(
                                'main' => "{$this->main_css_element} .et_pb_slide_description .price .amount",
                                'important' => array( 'size', 'font-size', 'plugin_all' ),
                              ),
                            ),
                          'body'   => array(
                            'label'    => esc_html__( 'Body', 'et_builder' ),
                            'css'      => array(
                              'line_height' => "{$this->main_css_element}, {$this->main_css_element} .et_pb_slide_content",
                              'main' => "{$this->main_css_element} .et_pb_slide_content, {$this->main_css_element} .et_pb_slide_content div",
                              'important' => 'all',
                            ),
                          ),
                        ),
                        'button' => array(
                  				'button' => array(
                  					'label' => esc_html__( 'Button', 'et_builder' ),
                  					'css' => array(
                  						'plugin_main' => "{$this->main_css_element} .et_pb_more_button.et_pb_button",
                  						'alignment' => "{$this->main_css_element} .et_pb_button_wrapper",
                  					),
                            'box_shadow'  => array(
                              'css' => array(
                                'main' => "{$this->main_css_element} .et_pb_more_button.et_pb_button",
                              ),
                            ),
                  					'use_alignment' => true,
                  				),
                  			),
                  			'background' => array(
                  				'css' => array(
                  					'main' => "{$this->main_css_element}, {$this->main_css_element}.et_pb_bg_layout_dark"
                  				),
                  			),
                          'border' => array(
                              'css' => array(
                                  'important' => 'all',
                              ),
                          ),
                    			'custom_margin_padding' => array(
                    				'css' => array(
                    					'main' => '%%order_class%%',
                    					'padding' => '%%order_class%% .et_pb_slide_description, .et_pb_slider_fullwidth_off%%order_class%% .et_pb_slide_description',
                    					'important' => array( 'custom_margin' ), // needed to overwrite last module margin-bottom styling
                    				),
                    			),
                      );

                  		$this->custom_css_fields = array(
                  			'slide_description' => array(
                  				'label'    => esc_html__( 'Slide Description', 'et_builder' ),
                  				'selector' => '.et_pb_slide_description',
                  			),
                  			'slide_title' => array(
                  				'label'    => esc_html__( 'Slide Title', 'et_builder' ),
                  				'selector' => '.et_pb_slide_description .et_pb_slide_title',
                  			),
                  			'slide_button' => array(
                  				'label'    => esc_html__( 'Slide Button', 'et_builder' ),
                  				'selector' => '.et_pb_slider a.et_pb_more_button.et_pb_button',
                  				'no_space_before_selector' => true,
                  			),
                  			'slide_controllers' => array(
                  				'label'    => esc_html__( 'Slide Controllers', 'et_builder' ),
                  				'selector' => '.et-pb-controllers',
                  			),
                  			'slide_active_controller' => array(
                  				'label'    => esc_html__( 'Slide Active Controller', 'et_builder' ),
                  				'selector' => '.et-pb-controllers .et-pb-active-control',
                  			),
                  			'slide_image' => array(
                  				'label'    => esc_html__( 'Slide Image', 'et_builder' ),
                  				'selector' => '.et_pb_slide_image',
                  			),
                  			'slide_arrows' => array(
                  				'label'    => esc_html__( 'Slide Arrows', 'et_builder' ),
                  				'selector' => '.et-pb-slider-arrows a',
                  			),
                  		);

                  }

                  function get_fields() {
    $options = DEBC_INIT::get_divi_layouts();


    		$fields = array(
          'posts_number' => array(
            'label'             => esc_html__( 'Product Display Number', 'et_builder' ),
            'type'              => 'text',
            'option_category'   => 'configuration',
            'description'       => esc_html__( 'Choose how many products you would like to display in the slider.', 'et_builder' ),
            'toggle_slug'       => 'main_content',
            'computed_affects'  => array(
              '58',
            ),
          ),
          'include_categories' =>  array(
            'label'             => esc_html__( 'Include Categories', 'et_builder' ),
            'type'              => 'text',
            'option_category'   => 'configuration',
            'description'       => esc_html__( 'Add the categories/category you ONLY want to be shown (comma-seperated). You need to use the category slug so no spaces with "-" between if you have a space in the category name', 'et_builder' ),
            'toggle_slug'       => 'main_content',
            'computed_affects'  => array(
              '__products',
            ),
          ),
          'featured_only' => array(
            'label'             => esc_html__( 'Display featured products ONLY?', 'et_builder' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'toggle_slug'       => 'main_content',
            'options'           => array(
              'on'  => esc_html__( 'Yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
          ),
          'popular_only' => array(
            'label'             => esc_html__( 'Display Most Popular products ONLY?', 'et_builder' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'toggle_slug'       => 'main_content',
            'options'           => array(
              'on'  => esc_html__( 'Yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
          ),
          'orderby' => array(
            'label'             => esc_html__( 'Order By', 'et_builder' ),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'options'           => array(
              'date_desc'  => esc_html__( 'Date: new to old', 'et_builder' ),
              'date_asc'   => esc_html__( 'Date: old to new', 'et_builder' ),
              'title_asc'  => esc_html__( 'Title: a-z', 'et_builder' ),
              'title_desc' => esc_html__( 'Title: z-a', 'et_builder' ),
              'rand'       => esc_html__( 'Random', 'et_builder' ),
            ),
            'toggle_slug'       => 'main_content',
            'description'       => esc_html__( 'Here you can adjust the order in which products are displayed.', 'et_builder' ),
            'computed_affects'  => array(
              '__products',
            ),
          ),
          'show_arrows'         => array(
            'label'           => esc_html__( 'Show Arrows', 'et_builder' ),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'options'         => array(
              'on'  => esc_html__( 'yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'toggle_slug'     => 'elements',
            'description'     => esc_html__( 'This setting will turn on and off the navigation arrows.', 'et_builder' ),
          ),
          'show_pagination' => array(
            'label'             => esc_html__( 'Show Controls', 'et_builder' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'options'           => array(
              'on'  => esc_html__( 'Yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'toggle_slug'       => 'elements',
            'description'       => esc_html__( 'This setting will turn on and off the circle buttons at the bottom of the slider.', 'et_builder' ),
          ),
          'show_more_button' => array(
            'label'             => esc_html__( 'Show Read More Button', 'et_builder' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'options'           => array(
              'on'  => esc_html__( 'yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'affects' => array(
              'more_text',
            ),
            'toggle_slug'       => 'elements',
            'description'       => esc_html__( 'This setting will turn on and off the read more button.', 'et_builder' ),
          ),
          'more_text' => array(
            'label'             => esc_html__( 'Button Text', 'et_builder' ),
            'type'              => 'text',
            'option_category'   => 'configuration',
            'depends_show_if'   => 'on',
            'toggle_slug'       => 'main_content',
            'description'       => esc_html__( 'Define the text which will be displayed on "Read More" button. leave blank for default ( Read More )', 'et_builder' ),
          ),
          'content_source' => array(
            'label'             => esc_html__( 'Content Display', 'et_builder' ),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'options'           => array(
              'off' => esc_html__( 'Show Short Description', 'et_builder' ),
              'on'  => esc_html__( 'Show Content', 'et_builder' ),
            ),
            'default' => 'off',
            'affects' => array(
              'use_manual_excerpt',
              'excerpt_length',
            ),
            'description'       => esc_html__( 'Showing the full content will not truncate your products in the slider. Showing the Short Description will only display the Short Description text.', 'et_builder' ),
            'toggle_slug'       => 'main_content',
            'computed_affects'  => array(
              '__products',
            ),
          ),
          'use_manual_excerpt' => array(
            'label'             => esc_html__( 'Use Product Short Description if Defined', 'et_builder' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'options'           => array(
              'on'  => esc_html__( 'Yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'depends_show_if'   => 'off',
            'description'       => esc_html__( 'Disable this option if you want to ignore manually defined Short Descriptions and always generate it automatically.', 'et_builder' ),
            'toggle_slug'       => 'main_content',
            'computed_affects'  => array(
              '__products',
            ),
          ),
          'excerpt_length' => array(
            'label'             => esc_html__( 'Automatic Short Description Length', 'et_builder' ),
            'type'              => 'text',
            'option_category'   => 'configuration',
            'depends_show_if'   => 'off',
            'description'       => esc_html__( 'Define the length of automatically generated Short Description. Leave blank for default ( 270 ) ', 'et_builder' ),
            'toggle_slug'       => 'main_content',
            'computed_affects'  => array(
              '__products',
            ),
          ),
          'background_layout' => array(
            'label'           => esc_html__( 'Text Color', 'et_builder' ),
            'type'            => 'select',
            'option_category' => 'color_option',
            'options'         => array(
              'dark'  => esc_html__( 'Light', 'et_builder' ),
              'light' => esc_html__( 'Dark', 'et_builder' ),
            ),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'text',
            'description'     => esc_html__( 'Here you can choose whether your text is light or dark. If you have a slide with a dark background, then choose light text. If you have a light background, then use dark text.' , 'et_builder' ),
          ),
          'show_image' => array(
            'label'             => esc_html__( 'Show Product Image', 'et_builder' ),
            'type'              => 'yes_no_button',
            'option_category'   => 'configuration',
            'options'           => array(
              'on'  => esc_html__( 'yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'affects' => array(
              'image_placement',
            ),
            'toggle_slug'       => 'featured_image',
            'description'       => esc_html__( 'This setting will turn on and off the featured image in the slider.', 'et_builder' ),
          ),
          'image_placement' => array(
            'label'             => esc_html__( 'Image Placement', 'et_builder' ),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'options'           => array(
              'background' => esc_html__( 'Background', 'et_builder' ),
              'left'       => esc_html__( 'Left', 'et_builder' ),
              'right'      => esc_html__( 'Right', 'et_builder' ),
              'top'        => esc_html__( 'Top', 'et_builder' ),
              'bottom'     => esc_html__( 'Bottom', 'et_builder' ),
            ),
            'depends_show_if'   => 'on',
            'toggle_slug'       => 'featured_image',
            'description'       => esc_html__( 'Select how you would like to display the featured image in slides', 'et_builder' ),
          ),
          'use_bg_overlay'      => array(
            'label'           => esc_html__( 'Use Background Overlay', 'et_builder' ),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'options'         => array(
              'on'  => esc_html__( 'yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'affects'           => array(
              'bg_overlay_color',
            ),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'overlay',
            'description'     => esc_html__( 'When enabled, a custom overlay color will be added above your background image and behind your slider content.', 'et_builder' ),
          ),
          'bg_overlay_color' => array(
            'label'             => esc_html__( 'Background Overlay Color', 'et_builder' ),
            'type'              => 'color-alpha',
            'custom_color'      => true,
            'depends_show_if'   => 'on',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'overlay',
            'description'       => esc_html__( 'Use the color picker to choose a color for the background overlay.', 'et_builder' ),
          ),
          'use_text_overlay'      => array(
            'label'           => esc_html__( 'Use Text Overlay', 'et_builder' ),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'options'         => array(
              'off' => esc_html__( 'No', 'et_builder' ),
              'on'  => esc_html__( 'yes', 'et_builder' ),
            ),
            'affects'           => array(
              'text_overlay_color',
              'text_border_radius',
            ),
            'tab_slug'         => 'advanced',
            'toggle_slug'      => 'overlay',
            'description'      => esc_html__( 'When enabled, a background color is added behind the slider text to make it more readable atop background images.', 'et_builder' ),
          ),
          'text_overlay_color' => array(
            'label'             => esc_html__( 'Text Overlay Color', 'et_builder' ),
            'type'              => 'color-alpha',
            'custom_color'      => true,
            'depends_show_if'   => 'on',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'overlay',
            'description'       => esc_html__( 'Use the color picker to choose a color for the text overlay.', 'et_builder' ),
          ),
          'show_inner_shadow'   => array(
            'label'           => esc_html__( 'Show Inner Shadow', 'et_builder' ),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'options'         => array(
              'on'  => esc_html__( 'Yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'layout',
          ),
          'show_content_on_mobile' => array(
            'label'           => esc_html__( 'Show Content On Mobile', 'et_builder' ),
            'type'            => 'yes_no_button',
            'option_category' => 'layout',
            'options'         => array(
              'on'  => esc_html__( 'Yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'tab_slug'        => 'custom_css',
            'toggle_slug'     => 'visibility',
          ),
          'show_cta_on_mobile' => array(
            'label'           => esc_html__( 'Show CTA On Mobile', 'et_builder' ),
            'type'            => 'yes_no_button',
            'option_category' => 'layout',
            'options'         => array(
              'on'  => esc_html__( 'Yes', 'et_builder' ),
              'off' => esc_html__( 'No', 'et_builder' ),
            ),
            'tab_slug'        => 'custom_css',
            'toggle_slug'     => 'visibility',
          ),
          'show_image_video_mobile' => array(
            'label'           => esc_html__( 'Show Image On Mobile', 'et_builder' ),
            'type'            => 'yes_no_button',
            'option_category' => 'layout',
            'options'         => array(
              'off' => esc_html__( 'No', 'et_builder' ),
              'on'  => esc_html__( 'Yes', 'et_builder' ),
            ),
            'tab_slug'        => 'custom_css',
            'toggle_slug'     => 'visibility',
          ),
          'text_border_radius' => array(
            'label'           => esc_html__( 'Text Overlay Border Radius', 'et_builder' ),
            'type'            => 'range',
            'option_category' => 'layout',
            'default'         => '3',
            'range_settings'  => array(
              'min'  => '0',
              'max'  => '100',
              'step' => '1',
            ),
            'depends_show_if' => 'on',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'overlay',
          ),
          'arrows_custom_color' => array(
            'label'        => esc_html__( 'Arrows Custom Color', 'et_builder' ),
            'type'         => 'color-alpha',
            'custom_color' => true,
            'tab_slug'     => 'advanced',
            'toggle_slug'  => 'navigation',
          ),
          'dot_nav_custom_color' => array(
            'label'        => esc_html__( 'Dot Nav Custom Color', 'et_builder' ),
            'type'         => 'color-alpha',
            'custom_color' => true,
            'tab_slug'     => 'advanced',
            'toggle_slug'  => 'navigation',
          ),
          'disabled_on' => array(
            'label'           => esc_html__( 'Disable on', 'et_builder' ),
            'type'            => 'multiple_checkboxes',
            'options'         => array(
              'phone'   => esc_html__( 'Phone', 'et_builder' ),
              'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
              'desktop' => esc_html__( 'Desktop', 'et_builder' ),
            ),
            'additional_att'  => 'disable_on',
            'option_category' => 'configuration',
            'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
            'tab_slug'        => 'custom_css',
            'toggle_slug'     => 'visibility',
          ),


          'auto' => array(
				'label'           => esc_html__( 'Automatic Animation', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'Off', 'et_builder' ),
					'on'  => esc_html__( 'On', 'et_builder' ),
				),
				'affects' => array(
					'auto_speed',
					'auto_ignore_hover',
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'animation',
				'description' => esc_html__( 'If you would like the slider to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'et_builder' ),
				'default'     => 'off',
			),
      'auto_speed' => array(
				'label'           => esc_html__( 'Automatic Animation Speed (in ms)', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'depends_show_if' => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'animation',
				'description'     => esc_html__( "Here you can designate how fast the slider fades between each slide, if 'Automatic Animation' option is enabled above. The higher the number the longer the pause between each rotation.", 'et_builder' ),
				'default'         => '7000',
			),
  'auto_ignore_hover' => array(
				'label'           => esc_html__( 'Continue Automatic Slide on Hover', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'depends_show_if' => 'on',
				'options'         => array(
					'off' => esc_html__( 'Off', 'et_builder' ),
					'on'  => esc_html__( 'On', 'et_builder' ),
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'animation',
				'description' => esc_html__( 'Turning this on will allow automatic sliding to continue on mouse hover.', 'et_builder' ),
				'default'     => 'off',
			),
                  'admin_label' => array(
                      'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                      'type'        => 'text',
                      'toggle_slug'     => 'main_content',
                      'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                  ),
      '__getproslider' => array(
        'type' => 'computed',
        'computed_callback' => array( 'db_post_slider_code', 'get_product_slider_code' ),
        'computed_depends_on' => array(
          'admin_label'
        ),
      ),


    		);

    		return $fields;
    	}


      public static function get_product_slider_code ( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}


        $shop = "<div class='no-html-output'><p>We do not have compatibility for the slider yet. We are working on this still. It will still work as expected on the front-end, you will just not get a live preview.</p></div>";

        return $shop;

      }



                  function render( $attrs, $content = null, $render_slug ) {



                    if (is_admin()) {
                        return;
                    }

                    $background_layout = '';

                    $module_id               = $this->props['module_id'];
                		$module_class            = $this->props['module_class'];
                		$show_arrows             = $this->props['show_arrows'];
                		$show_pagination         = $this->props['show_pagination'];
                		$parallax                = $this->props['parallax'];
                		$parallax_method         = $this->props['parallax_method'];
                		$auto                    = $this->props['auto'];
                		$auto_speed              = $this->props['auto_speed'];
                		$auto_ignore_hover       = $this->props['auto_ignore_hover'];
                		$body_font_size          = $this->props['body_font_size'];
                		$show_inner_shadow       = $this->props['show_inner_shadow'];
                		$show_content_on_mobile  = $this->props['show_content_on_mobile'];
                		$show_cta_on_mobile      = $this->props['show_cta_on_mobile'];
                		$show_image_video_mobile = $this->props['show_image_video_mobile'];
                		$background_position     = $this->props['background_position'];
                		$background_size         = $this->props['background_size'];
                		$background_repeat       = $this->props['background_repeat'];
                		$background_blend        = $this->props['background_blend'];
                		$posts_number            = $this->props['posts_number'];
                		$include_categories      = $this->props['include_categories'];
                		$show_more_button        = $this->props['show_more_button'];
                		$more_text               = $this->props['more_text'];
                		$content_source          = $this->props['content_source'];
                		$background_color        = $this->props['background_color'];
                		$show_image              = $this->props['show_image'];
                		$image_placement         = $this->props['image_placement'];
                		$background_image        = $this->props['background_image'];
                		$background_layout       = $this->props['background_layout'];
                		$use_bg_overlay          = $this->props['use_bg_overlay'];
                		$bg_overlay_color        = $this->props['bg_overlay_color'];
                		$use_text_overlay        = $this->props['use_text_overlay'];
                		$text_overlay_color      = $this->props['text_overlay_color'];
                		$orderby                 = $this->props['orderby'];
                		$button_custom           = $this->props['custom_button'];
                		$custom_icon             = $this->props['button_icon'];
                		$use_manual_excerpt      = $this->props['use_manual_excerpt'];
                		$excerpt_length          = $this->props['excerpt_length'];
                		$text_border_radius      = $this->props['text_border_radius'];
                		$dot_nav_custom_color    = $this->props['dot_nav_custom_color'];
                		$arrows_custom_color     = $this->props['arrows_custom_color'];
                		$button_rel              = $this->props['button_rel'];
                    $featured_only              = $this->props['featured_only'];
                    $popular_only              = $this->props['popular_only'];


                    if ( 'on' === $auto ) {
                			$this->add_classname( array(
                				'et_slider_auto',
                				"et_slider_speed_{$auto_speed}",
                			) );
                		}

                		if ( 'on' === $auto_ignore_hover ) {
                			$this->add_classname( 'et_slider_auto_ignore_hover' );
                		}

                    $post_index = 0;

                    $module_class = ET_Builder_Element::add_module_order_class( $module_class, $render_slug );

                    $hide_on_mobile_class = self::HIDE_ON_MOBILE;

                    // Applying backround-related style to slide item since advanced_option only targets module wrapper
                    if ( 'on' === $this->props['show_image'] && 'background' === $this->props['image_placement'] && 'off' === $parallax ) {
                      if ('' !== $background_color) {
                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide:not(.et_pb_slide_with_no_image)',
                          'declaration' => sprintf(
                            'background-color: %1$s;',
                            esc_html( $background_color )
                          ),
                        ) );
                      }

                      if ( '' !== $background_size && 'default' !== $background_size ) {
                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide',
                          'declaration' => sprintf(
                            '-moz-background-size: %1$s;
                            -webkit-background-size: %1$s;
                            background-size: %1$s;',
                            esc_html( $background_size )
                          ),
                        ) );

                        if ( 'initial' === $background_size ) {
                          ET_Builder_Module::set_style( $render_slug, array(
                            'selector'    => 'body.ie %%order_class%% .et_pb_slide',
                            'declaration' => '-moz-background-size: auto; -webkit-background-size: auto; background-size: auto;',
                          ) );
                        }
                      }

                      if ( '' !== $background_position && 'default' !== $background_position ) {
                        $processed_position = str_replace( '_', ' ', $background_position );

                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide',
                          'declaration' => sprintf(
                            'background-position: %1$s;',
                            esc_html( $processed_position )
                          ),
                        ) );
                      }

                      if ( '' !== $background_repeat ) {
                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide',
                          'declaration' => sprintf(
                            'background-repeat: %1$s;',
                            esc_html( $background_repeat )
                          ),
                        ) );
                      }

                      if ( '' !== $background_blend ) {
                        ET_Builder_Module::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .et_pb_slide',
                          'declaration' => sprintf(
                            'background-blend-mode: %1$s;',
                            esc_html( $background_blend )
                          ),
                        ) );
                      }
                    }

                    if ( 'on' === $use_bg_overlay && '' !== $bg_overlay_color ) {
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%% .et_pb_slide .et_pb_slide_overlay_container',
                        'declaration' => sprintf(
                          'background-color: %1$s;',
                          esc_html( $bg_overlay_color )
                        ),
                      ) );
                    }

                    if ( 'on' === $use_text_overlay && '' !== $text_overlay_color ) {
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%% .et_pb_slide .et_pb_slide_title, %%order_class%% .et_pb_slide .et_pb_slide_content',
                        'declaration' => sprintf(
                          'background-color: %1$s;',
                          esc_html( $text_overlay_color )
                        ),
                      ) );
                    }

                    if ( '' !== $text_border_radius ) {
                      $border_radius_value = et_builder_process_range_value( $text_border_radius );
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%%.et_pb_slider_with_text_overlay h3.et_pb_slide_title',
                        'declaration' => sprintf(
                          '-webkit-border-top-left-radius: %1$s;
                          -webkit-border-top-right-radius: %1$s;
                          -moz-border-radius-topleft: %1$s;
                          -moz-border-radius-topright: %1$s;
                          border-top-left-radius: %1$s;
                          border-top-right-radius: %1$s;',
                          esc_html( $border_radius_value )
                        ),
                      ) );
                      ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => '%%order_class%%.et_pb_slider_with_text_overlay .et_pb_slide_content',
                        'declaration' => sprintf(
                          '-webkit-border-bottom-right-radius: %1$s;
                          -webkit-border-bottom-left-radius: %1$s;
                          -moz-border-radius-bottomright: %1$s;
                          -moz-border-radius-bottomleft: %1$s;
                          border-bottom-right-radius: %1$s;
                          border-bottom-left-radius: %1$s;',
                          esc_html( $border_radius_value )
                        ),
                      ) );
                    }

                    $fullwidth = 'et_pb_fullwidth_slider' === $render_slug ? 'on' : 'off';

                    $class  = '';
                    $class .= 'off' === $fullwidth ? ' et_pb_slider_fullwidth_off' : '';
                    $class .= 'off' === $show_arrows ? ' et_pb_slider_no_arrows' : '';
                    $class .= 'off' === $show_pagination ? ' et_pb_slider_no_pagination' : '';
                    $class .= 'on' === $parallax ? ' et_pb_slider_parallax' : '';
                    $class .= 'on' === $auto ? ' et_slider_auto et_slider_speed_' . esc_attr( $auto_speed ) : '';
                    $class .= 'on' === $auto_ignore_hover ? ' et_slider_auto_ignore_hover' : '';
                    $class .= 'on' !== $show_inner_shadow ? ' et_pb_slider_no_shadow' : '';
                    $class .= 'on' === $show_image_video_mobile ? ' et_pb_slider_show_image' : '';
                    $class .= ' et_pb_post_slider_image_' . $image_placement;
                    $class .= 'on' === $use_bg_overlay ? ' et_pb_slider_with_overlay' : '';
                    $class .= 'on' === $use_text_overlay ? ' et_pb_slider_with_text_overlay' : '';

                    $data_dot_nav_custom_color = '' !== $dot_nav_custom_color
                      ? sprintf( ' data-dots_color="%1$s"', esc_attr( $dot_nav_custom_color ) )
                      : '';

                    $data_arrows_custom_color = '' !== $arrows_custom_color
                      ? sprintf( ' data-arrows_color="%1$s"', esc_attr( $arrows_custom_color ) )
                      : '';

                    $video_background = $this->video_background();
                    $parallax_image_background = $this->get_parallax_image_background();

                    $data_dot_nav_custom_color = '' !== $dot_nav_custom_color
                      ? sprintf( ' data-dots_color="%1$s"', esc_attr( $dot_nav_custom_color ) )
                      : '';

                    $data_arrows_custom_color = '' !== $arrows_custom_color
                      ? sprintf( ' data-arrows_color="%1$s"', esc_attr( $arrows_custom_color ) )
                      : '';

                    ob_start();


                    if ($featured_only == "on") {
                      $customclass = "featured-products";
                      $tax_query[] = array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                          'operator' => 'IN',
                        );
                      $args = array(
                        'posts_per_page' => $posts_number,
                        'post_type'   => 'product',
                        'post_status'    => 'publish',
                        'tax_query'           => $tax_query,
                        'product_cat'   =>  $include_categories,
                        'orderby' => $orderby,
                      );
                    }
                    else if ($popular_only == "on") {
                      $customclass = "popular-products";
                        $args = array(
                          'posts_per_page' => $posts_number,
                          'post_type'   => 'product',
                          'post_status'    => 'publish',
                          'meta_key' => 'total_sales',
                          'orderby' => 'meta_value_num',
                          'product_cat'   =>  $include_categories,
                        );
                    }
                    else {
                      $args = array(
                        'posts_per_page' => $posts_number,
                        'post_type'   => 'product',
                        'post_status'    => 'publish',
                        'product_cat'   =>  $include_categories,
                        'orderby' => $orderby,
                      );
                    }

                                    // Re-used self::get_blog_posts() for builder output


                        $query = new WP_Query( $args );

                        if ( $query->have_posts() ) {
                          while ( $query->have_posts() ) {
                            $query->the_post();

                            $slide_class = 'off' !== $show_image && in_array( $image_placement, array( 'left', 'right' ) ) && has_post_thumbnail() ? ' et_pb_slide_with_image' : '';
                            $slide_class .= 'off' !== $show_image && ! has_post_thumbnail() ? ' et_pb_slide_with_no_image' : '';
                            $slide_class .= " et_pb_bg_layout_{$background_layout}";
                          ?>
                          <div class="et_pb_slide et_pb_media_alignment_center<?php echo esc_attr( $slide_class ); ?>" <?php if ( 'on' !== $parallax && 'off' !== $show_image && 'background' === $image_placement ) { printf( 'style="background-image:url(%1$s)"', esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ) );  } ?><?php echo $data_dot_nav_custom_color; echo $data_arrows_custom_color; ?>>
                            <?php if ( 'on' === $parallax && 'off' !== $show_image && 'background' === $image_placement ) { ?>
                              <div class="et_parallax_bg<?php if ( 'off' === $parallax_method ) { echo ' et_pb_parallax_css'; } ?>" style="background-image: url(<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>);"></div>
                            <?php } ?>
                            <?php if ( 'on' === $use_bg_overlay ) { ?>
                              <div class="et_pb_slide_overlay_container"></div>
                            <?php } ?>
                            <div class="et_pb_container clearfix">
                              <div class="et_pb_slider_container_inner">
                                <?php if ( 'off' !== $show_image && has_post_thumbnail() && ! in_array( $image_placement, array( 'background', 'bottom' ) ) ) { ?>
                                  <div class="et_pb_slide_image">
                                    <?php the_post_thumbnail(); ?>
                                  </div>
                                <?php } ?>
                                <div class="et_pb_slide_description">
                                  <h3 class="et_pb_slide_title"><?php the_title(); ?></h3>
                                  <div class="et_pb_slide_content <?php if ( 'on' !== $show_content_on_mobile ) { echo esc_attr( $hide_on_mobile_class ); } ?>">
<div>
                                    <?php

if ($content_source == "off") { // short desc
                                        echo $query->posts[ $post_index ]->post_excerpt;

} else { // CONTENT
                                        echo $query->posts[ $post_index ]->post_content;
}
                                      ?>
</div>
                                      <div class="clearfix"></div><?php
                                      global $woocommerce;
                                      $product = new WC_Product(get_the_ID());
                                      ?>
                                    <p class="price" style="padding-top:20px;"><?php  echo $product->get_price_html(); ?> </p>

                                  </div>
                                  <?php if ( 'off' !== $show_more_button && '' !== $more_text ) {
                                      printf(
                                        '<div class="et_pb_button_wrapper"><a href="%1$s" class="et_pb_more_button et_pb_button%4$s%5$s"%3$s%6$s>%2$s</a></div>',
                                        esc_url( get_permalink() ),
                                        esc_html( $more_text ),
                                        '' !== $custom_icon && 'on' === $button_custom ? sprintf(
                                          ' data-icon="%1$s"',
                                          esc_attr( et_pb_process_font_icon( $custom_icon ) )
                                        ) : '',
                                        '' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : '',
                                        'on' !== $show_cta_on_mobile ? esc_attr( " {$hide_on_mobile_class}" ) : '',
                                        $this->get_rel_attributes( $button_rel )
                                      );
                                    }
                                  ?>
                                </div> <!-- .et_pb_slide_description -->
                                <?php if ( 'off' !== $show_image && has_post_thumbnail() && 'bottom' === $image_placement ) { ?>
                                  <div class="et_pb_slide_image">
                                    <?php the_post_thumbnail(); ?>
                                  </div>
                                <?php } ?>
                              </div>
                            </div> <!-- .et_pb_container -->
                          </div> <!-- .et_pb_slide -->
                        <?php
                          $post_index++;

                          } // end while
                          wp_reset_query();
                        } // end if

                        $content = ob_get_contents();


                        ob_end_clean();

                        $output = sprintf(
                          '<div%3$s class="et_pb_module et_pb_slider et_DB_product_slider%1$s%4$s%5$s%7$s">
                            %8$s
                            %6$s
                            <div class="et_pb_slides">
                              %2$s
                            </div> <!-- .et_pb_slides -->
                          </div> <!-- .et_pb_slider -->
                          ',
                          $class,
                          $content,
                          ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                          ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
                          '' !== $video_background ? ' et_pb_section_video et_pb_preload' : '',
                          $video_background,
                          '' !== $parallax_image_background ? ' et_pb_section_parallax' : '',
                          $parallax_image_background
                        );

                        if( isset($customclass) ){
                          $this->add_classname( $customclass );
                        }

                        return $output;

                  }
              }

            new db_post_slider_code;

?>
