<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_account_nav_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP Navigation - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_account_nav';

		$this->fields_defaults = array(
			'show_as_buttons'  		=> array( 'off' ),
			'display_inline'  		=> array( 'off' ),
		);

          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
      				),
      			),
      			'advanced' => array(
      				'toggles' => array(
					           'alignment'  => esc_html__( 'Alignment', 'et_builder' ),
      					'text' => esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
      				),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
        			'fonts' => array(
        				'meta'   => array(
        					'label'    => esc_html__( 'Nav Links', 'divi-bodyshop-woocommerce' ),
        					'css'      => array(
        						'main' => "{$this->main_css_element} .woocommerce-MyAccount-navigation a",
        					),
        					'font_size' => array(
        						'default' => '14px',
        					),
        					'line_height' => array(
        						'default' => '1.3em',
        					),
        				),
        				'active_link'   => array(
        					'label'    => esc_html__( 'Active Link', 'divi-bodyshop-woocommerce' ),
        					'css'      => array(
        						'main' => "{$this->main_css_element} .woocommerce-MyAccount-navigation .is-active a",
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

              'button' => array(
      'button' => array(
        'label' => esc_html__( 'Button', 'divi-bodyshop-woocommerce' ),
        'css' => array(
          'main' => "{$this->main_css_element} .et_pb_button",
          'important' => 'all',
        ),
        'box_shadow'  => array(
          'css' => array(
            'main' => "{$this->main_css_element} .et_pb_button",
                'important' => 'all',
          ),
        ),
        'margin_padding' => array(
        'css'           => array(
          'main' => "{$this->main_css_element} .et_pb_button",
          'important' => 'all',
        ),
        ),
      ),

    ),

        		);

                  }

                  function get_fields() {
    		$fields = array(
            'title' => array(
                'label' => __('Title', 'et_builder'),
                'type' => 'text',
                'toggle_slug' => 'main_content',
                'description' => __('If you want a title for the navigation, add it here', 'et_builder'),
            ),
            'show_as_buttons' => array(
                'label' => esc_html__('Show as Buttons', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
                'affects' => array(
                  'display_inline',
                  'fullwidth_button'
                ),
                'description' => 'By default the navigation will be shown as a list with bullet points. If you would like it to show as buttons, check this to "yes"',
            ),
            'display_inline' => array(
                'label' => esc_html__('Show Inline', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'depends_show_if' => 'on',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
                'description' => 'When showing buttons should they be shown one per line or adjacent to each other. Check this to "yes" to make the buttons sit side by side',
            ),
            'fullwidth_button' => array(
                'label' => esc_html__('Make buttons fullwidth?', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'depends_show_if' => 'on',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
                'description' => 'Enabling this will make the buttons fullwidth',
            ),
            'hide_dashboard' => array(
                'label' => esc_html__('Hide Dashboard Link/Button', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
            ),
            'hide_orders' => array(
                'label' => esc_html__('Hide Orders Link/Button', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
            ),
            'hide_downloads' => array(
                'label' => esc_html__('Hide Downloads Link/Button', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
            ),
            'hide_addresses' => array(
                'label' => esc_html__('Hide Addresses Link/Button', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
            ),
            'hide_account_details' => array(
                'label' => esc_html__('Hide Account Details Link/Button', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
            ),
            'hide_payment' => array(
                'label' => esc_html__('Hide Payment Methods', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
            ),
            'hide_logout' => array(
                'label' => esc_html__('Hide Logout Link/Button', 'et_builder'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'main_content',
                'options' => array(
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ),
            ),
            // 'space_button' => array(
            //   'label'           => esc_html__( 'Space Between Buttons', 'et_builder' ),
            //   'type'            => 'range',
            //   'default'         => '10px',
            //   'default_unit'    => 'px',
            //   'default_on_front'=> '',
            //   'range_settings' => array(
            //     'min'  => '0',
            //     'max'  => '200',
            //     'step' => '1',
            //   ),
            //   'toggle_slug' => 'main_content',
            //   'depends_show_if' => 'on',
            // ),
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

                    if (is_admin()) {
                        return;
                    }


                    $title = $this->props['title'];
                    $buttons = $this->props['show_as_buttons'];
                    $inline = $this->props['display_inline'];
                    $fullwidth_button = $this->props['fullwidth_button'];
                    // $space_button = $this->props['space_button'];
                    $button_use_icon          	= $this->props['button_use_icon'];
                    $custom_icon          		= $this->props['button_icon'];
                    $button_custom        		= $this->props['custom_button'];
                    $button_bg_color       		= $this->props['button_bg_color'];
		                $button_icon_placement 		= $this->props['button_icon_placement'];


                    $hide_dashboard 		= $this->props['hide_dashboard'];
		                $hide_orders 		= $this->props['hide_orders'];
		                $hide_downloads 		= $this->props['hide_downloads'];
		                $hide_addresses 		= $this->props['hide_addresses'];
		                $hide_account_details 		= $this->props['hide_account_details'];
                    $hide_payment 		= $this->props['hide_payment'];
		                $hide_logout 		= $this->props['hide_logout'];


                    $button_alignment                = $this->get_button_alignment();
                          // Button Alignment.
                		$button_alignments = sprintf( 'et_pb_button_alignment_%1$s', esc_attr( $button_alignment ) );

                    if( $fullwidth_button !== 'et_pb_button_alignment_' ){
                      $this->add_classname( $button_alignments );
                    }


                    if( $fullwidth_button == 'on' ){
                      $this->add_classname( 'fullwidth_buttons' );
                      $this->add_classname( 'et_pb_button_module_wrapper' );
                    }
                    if( $hide_dashboard == 'on' ){
                      $this->add_classname( 'hide_dashboard' );
                    }
                    if( $hide_orders == 'on' ){
                      $this->add_classname( 'hide_orders' );
                    }
                    if( $hide_downloads == 'on' ){
                      $this->add_classname( 'hide_downloads' );
                    }
                    if( $hide_addresses == 'on' ){
                      $this->add_classname( 'hide_addresses' );
                    }
                    if( $hide_account_details == 'on' ){
                      $this->add_classname( 'hide_account_details' );
                    }
                    if( $hide_payment == 'on' ){
                      $this->add_classname( 'hide_payment_methods' );
                    }
                    if( $hide_logout == 'on' ){
                      $this->add_classname( 'hide_logout' );
                    }


                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();

                    if ($title) {
                        echo '<h3 class="module_title">' . $title . '</h3>';
                    }

                    do_action('woocommerce_before_account_navigation');

                    if ($buttons == 'on') {

                        foreach (wc_get_account_menu_items() as $endpoint => $label) {
                            if ($inline != 'on') {
                                echo '<p class="bc-account-nav-buttons woocommerce-MyAccount-navigation-link--'.esc_html($endpoint).'">';
                            }
                            echo '<a class="' . ($inline == 'on' ? 'inline-button  woocommerce-MyAccount-navigation-link--'.esc_html($endpoint).'' : '') . ' et_pb_button" href="' . esc_url(wc_get_account_endpoint_url($endpoint)) . '" name="'.esc_html($label).'">' . esc_html($label) . '</a>';

                            if ($inline != 'on') {
                                echo '</p>';
                            }
                        }

                    } else {
                        echo '<nav class="woocommerce-MyAccount-navigation">
                            <ul>';

                        foreach (wc_get_account_menu_items() as $endpoint => $label) {
                            echo '<li class="' . wc_get_account_menu_item_classes($endpoint) . '">
                                        <a href="' . esc_url(wc_get_account_endpoint_url($endpoint)) . '">' . esc_html($label) . '</a>
                                    </li>';
                        }

                        echo '</ul>
                        </nav>';
                    }

                    do_action('woocommerce_after_account_navigation');



                if( $custom_icon != '' ){

                  $IconSelector = '';
                					if( $button_icon_placement == 'right' ){
                						$IconSelector = '%%order_class%% .et_pb_button:after';
                					}elseif( $button_icon_placement == 'left' ){
                						$IconSelector = '%%order_class%% .et_pb_button:before';
                					}

                          if( !empty( $IconContent ) && !empty( $IconSelector ) ){
          ET_Builder_Element::set_style( $render_slug, array(
            'selector' => $IconSelector,
            'declaration' => "content: '{$IconContent}'!important;font-family:ETmodules!important;"
            )
          );
        }

                }


                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_account_nav_code;

?>
