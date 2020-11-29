<?php
if( !defined( 'ABSPATH' ) ) exit; // exit if accessed directly

/**
 * @since 2.1.0
  */

class db_product_search extends ET_Builder_Module {

	public $vb_support = 'on';
	protected $module_credits = array(
	  'module_uri' => DE_DB_PRODUCT_URL,
	  'author'     => DE_DB_AUTHOR,
	  'author_uri' => DE_DB_URL,
	);

	function init() {
		$this->name       = esc_html__( '.G Product Search - Global', 'divi-bodyshop-woocommerce' );
		$this->slug       = 'et_pb_db_products_search';

        $this->main_css_element = '%%order_class%%';

        $this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Main Content', 'divi-bodyshop-woocommerce' ),
				),
            ),
            'advanced' => array(
                'toggles' => array(
                    'misc' => esc_html__( 'Miscellaneous', 'divi-bodyshop-woocommerce' ),
                    'search_field_border' => esc_html__( 'Search Field Border', 'divi-bodyshop-woocommerce' ),
                ),
            ),
        );

		$this->advanced_fields = array(
			'fonts' => array(
				'search_field'   => array(
					'label'    => esc_html__( 'Search Field', 'divi-bodyshop-woocommerce' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .search-field",
					),
					'font_size' => array(
						'default' => '20px',
					),
					'line_height' => array(
						'default' => '1.7em',
					),
				),
			),
			'background' => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'borders'               => array(
				'default' => array(),
				'image'   => array(
					'css'             => array(
						'main' => array(
							'border_radii' => "%%order_class%% .search-field",
							'border_styles' => "%%order_class%% .search-field",
						)
					),
					'defaults' => array(
						'border_radii' => 'on|3|3|3|3',
						'border_styles' => array(
							'width' => '2px',
							'color' => '#bbbbbb',
							'style' => 'solid',
						),
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'search_field_border',
				),
			),
			'custom_margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
			'button' => array(
				'button' => array(
					'label' => esc_html__( 'Search Button', 'divi-bodyshop-woocommerce' ),
					'css' => array(
						'main' => "{$this->main_css_element} button.button",
						'important' => 'all',
					),
					'box_shadow'  => array(
						'css' => array(
							'main' => 'body #page-container %%order_class%% .button',
							'important' => 'all',
						),
					),
					'margin_padding' => array(
					'css'           => array(
					  'main' => "{$this->main_css_element} .button",
					  'important' => 'all',
					),
					),
				),
            ),
            'text' => false,
		);
		$this->custom_css_fields = array(
			'search_input' => array(
				'label' => esc_html__( 'Search Field', 'divi-bodyshop-woocommerce' ),
				'selector' => "{$this->main_css_element} .search-field",
			),
			'search_button' => array(
				'label' => esc_html__( 'Search Button', 'divi-bodyshop-woocommerce' ),
				'selector' => "{$this->main_css_element} .button",
			),
		);
	}

	function get_fields() {
		$fields = array(
            'enable_button' => array(
                'label'           => esc_html__( 'Show Search Button', 'divi-bodyshop-woocommerce' ),
                'type'            => 'yes_no_button',
                'options' => array(
                    'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                ),
                'default' => 'on',
                'toggle_slug'       => 'main_content',
                'affects' => array(
                    'search_button_text',
                    'fullwidth_elements',
                ),
            ),
			'search_button_text' => array(
				'label'           => esc_html__( 'Button Text', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'computed_affects' => array(
					'__getprosearch',
				),
				'default'			=> esc_html_x( 'Search', 'submit button', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text. Default is: Search, or leav empty if you want to use just an icon.', 'divi-bodyshop-woocommerce' ),
                'toggle_slug'       => 'main_content',
                'dependes_show_if' => 'on',
			),
			'search_field_placeholder' => array(
				'label'           => esc_html__( 'Search Field Placeholder', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'computed_affects' => array(
					'__getprosearch',
				),
				'default'			=> esc_attr__( 'Search products...', 'divi-bodyshop-woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Search input placeholder.', 'divi-bodyshop-woocommerce' ),
				'toggle_slug'       => 'main_content',
            ),
			'fullwidth_elements' => array(
				'label'           => esc_html__( 'Full-width Elements', 'divi-bodyshop-woocommerce' ),
                'type'            => 'yes_no_button',
                'options' => array(
                    'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                    'on' => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                ),
				'default'			=> 'off',
				'description'     => esc_html__( 'If you enable this, both the search field and the button will be full-width.', 'divi-bodyshop-woocommerce' ),
                'tab_slug'       => 'advanced',
                'toggle_slug'       => 'misc',
                'depends_show_if' => 'on',
            ),
            'search_field_bg' => array(
                'label' => esc_html__( 'Search Field Background', 'divi-bodyshop-woocommerce' ),
                'type' => 'color-alpha',
                'default' => '#ffffff',
                'tab_slug' => 'advanced',
                'toggle_slug'       => 'misc',
            ),
						'admin_label' => array(
								'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
								'type'        => 'text',
								'toggle_slug'     => 'main_content',
								'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
						),
						'__getprosearch' => array(
						'type' => 'computed',
						'computed_callback' => array( 'db_product_search', 'get_pro_search' ),
						'computed_depends_on' => array(
						'admin_label',
						'search_button_text',
			'search_field_placeholder'
						),
						),
		);

		return $fields;
	}


	public static function get_pro_search ( $args = array(), $conditional_tags = array(), $current_page = array() ){
		if (!is_admin()) {
			return;
		}

		ob_start();

		$search_button_text         = $args['search_button_text'];
		$search_field_placeholder   = $args['search_field_placeholder'];

		$button_html = "<button type='submit' class='button'>". esc_attr( $search_button_text ) ."</button>";


		$output = "
				<form role='search' method='get' action=''>
						<input type='search' class='search-field' placeholder='". esc_attr( $search_field_placeholder )."' value='' name='s' />
						{$button_html}
						<input type='hidden' name='post_type' value='product' />
				</form>
		";

		echo $output;

		$data = ob_get_clean();

	return $data;

	}


	function render( $attrs, $content = null, $render_slug ) {
        $enable_button              = $this->props['enable_button'];
        $search_button_text         = $this->props['search_button_text'];
        $search_field_placeholder   = $this->props['search_field_placeholder'];
        $fullwidth_elements         = $this->props['fullwidth_elements'];
        $search_field_bg            = $this->props['search_field_bg'];

        $custom_button  			= $this->props['custom_button'];
        $button_use_icon  			= $this->props['button_use_icon'];
		$button_icon 				= $this->props['button_icon'];
		$button_icon_placement 		= $this->props['button_icon_placement'];
		$button_bg_color       		= $this->props['button_bg_color'];


		if (is_admin()) {
				return;
		}

        /* button html */
        $button_html = '';
        if( $enable_button == 'on' ){

            if( $fullwidth_elements == 'on' ){
                $this->add_classname( 'fullwidth-elements' );
            }

            $button_text = esc_attr( $search_button_text );
            $button_html = "<button type='submit' class='button'>". esc_attr( $search_button_text ) ."</button>";

            // button icon and background
            if( $custom_button == 'on' ){

                // button icon
                if( $button_icon !== '' ){
                    $iconContent = DEBC_INIT::et_icon_css_content( esc_attr($button_icon) );

                    $iconSelector = '';
                    if( $button_icon_placement == 'right' ){
                        $iconSelector = '%%order_class%% .button:after';
                    }elseif( $button_icon_placement == 'left' ){
                        $iconSelector = '%%order_class%% .button:before';
                    }

                    if( !empty( $iconContent ) && !empty( $iconSelector ) ){
                        ET_Builder_Element::set_style( $render_slug, array(
                            'selector' => $iconSelector,
                            'declaration' => "content: '{$iconContent}'!important;font-family:ETmodules!important;"
                            )
                        );
                    }
				}

				// fix the button padding if has no icon
				if( $button_use_icon == 'off' ){
					ET_Builder_Element::set_style( $render_slug, array(
						'selector' => 'body.woocommerce %%order_class%% .button',
						'declaration' => "padding: 0.3em 1em!important"
						)
					);
				}

                // button background
                if( !empty( $button_bg_color ) ){
                    ET_Builder_Element::set_style( $render_slug, array(
                        'selector'    => 'body #page-container %%order_class%% .button',
                        'declaration' => "background-color:". esc_attr( $button_bg_color ) ."!important;",
                    ) );
                }
            }
        }else{
            $this->add_classname( 'no-button' );
        }

        // search field bg
        if( !empty( $search_field_bg ) ){
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .searchfield',
                'declaration' => "background:". esc_attr( $search_field_bg ) ."!important;"
                )
            );
        }

        $output = "
            <form role='search' method='get' action='". esc_url( home_url( '/' ) ) ."'>
                <input type='search' class='search-field' placeholder='". esc_attr( $search_field_placeholder )."' value='". get_search_query() ."' name='s' />
                {$button_html}
                <input type='hidden' name='post_type' value='product' />
            </form>
        ";

        return $output;
	}
}
new db_product_search;
