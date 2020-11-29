<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_content_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

	public static $heading, $show_heading;
	public static function change_tab_heading( $hd ){

		if( self::$show_heading == 'off' ){
			$hd = '';
		}elseif( self::$show_heading == 'on' ){
			if( self::$heading != '' ){
				$hd = esc_attr( self::$heading );
			}
		}

		return $hd;
	}

                function init() {
                    $this->name       = esc_html__( '.PP Product Content - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_content';



          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
      				),
      			),
      			'advanced' => array(
      				'toggles' => array(

                'text' => array(
                      'title'    => esc_html__( 'Description', 'divi-bodyshop-woocommerce' ),
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
					               'width' => array(
						                     'title'    => esc_html__( 'Sizing', 'divi-bodyshop-woocommerce' ),
						                     'priority' => 65,
					                                ),
      				),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';

		$this->fields_defaults = array(
			'show_heading' => array( 'off' ),
		);
                      $this->advanced_fields = array(
                        'fonts' => array(
            				'text'   => array(
            					'label'    => esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'line_height' => "{$this->main_css_element} p",
            						'color' => "{$this->main_css_element} p",
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
            					'label'    => esc_html__( 'Link', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} a",
            						'color' => "{$this->main_css_element} a",
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
            					'label'    => esc_html__( 'Unordered List', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main'        => "{$this->main_css_element} ul",
            						'color'       => "{$this->main_css_element} ul",
            						'line_height' => "{$this->main_css_element} ul li",
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
            					'label'    => esc_html__( 'Ordered List', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main'        => "{$this->main_css_element} ol",
            						'color'       => "{$this->main_css_element} ol",
            						'line_height' => "{$this->main_css_element} ol li",
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
            					'label'    => esc_html__( 'Blockquote', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} blockquote, {$this->main_css_element} blockquote p",
            						'color' => "{$this->main_css_element} blockquote, {$this->main_css_element} blockquote p",
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
            					'label'    => esc_html__( 'Heading', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} h1",
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
            					'label'    => esc_html__( 'Heading 2', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} h2",
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
            					'label'    => esc_html__( 'Heading 3', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} h3",
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
            					'label'    => esc_html__( 'Heading 4', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} h4",
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
            					'label'    => esc_html__( 'Heading 5', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} h5",
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
            					'label'    => esc_html__( 'Heading 6', 'divi-bodyshop-woocommerce' ),
            					'css'      => array(
            						'main' => "{$this->main_css_element} h6",
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

			'show_heading' => array(
				'label' => esc_html__( 'Show Heading', 'divi-bodyshop-woocommerce' ),
				'type' => 'yes_no_button',
				'options_category' => 'configuration',
				'options' => array(
					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
					'off' => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
				),
				'affects' => array(
					'heading',
				),
				'toggle_slug' => 'main_content',
			),
			'heading' => array(
				'label'           => esc_html__( 'Custom Heading', 'divi-bodyshop-woocommerce' ),
				'type'            => 'text',
				'default'		=> esc_html__( 'Description', 'woocommerce' ),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'The Heading of the module. If left empty, default is: Product Description', 'divi-bodyshop-woocommerce' ),
				'depends_show_if'   => 'on',
				'toggle_slug' => 'main_content',
			),
                        'excerpt_only' => array(
                                        'label'           => __( 'Use Excert if Defined', 'divi-bodyshop-woocommerce' ),
                                        'type'            => 'yes_no_button',
                                        'option_category' => 'configuration',
                                        'toggle_slug'     => 'main_content',
                                        'options'         => array(
                                                        'off' => __( 'No', 'divi-bodyshop-woocommerce' ),
                                                        'on'  => __( 'Yes', 'divi-bodyshop-woocommerce' ),
                                        ),
                                        'description'       => __( 'Enable this option if you want to show the excert and not the whole content', 'divi-bodyshop-woocommerce' ),
                        ),
                        'ul_type' => array(
                        				'label'             => esc_html__( 'Unordered List Style Type', 'divi-bodyshop-woocommerce' ),
                        				'type'              => 'select',
                        				'option_category'   => 'configuration',
                        				'options'           => array(
                        					'disc'    => esc_html__( 'Disc', 'divi-bodyshop-woocommerce' ),
                        					'circle'  => esc_html__( 'Circle', 'divi-bodyshop-woocommerce' ),
                        					'square'  => esc_html__( 'Square', 'divi-bodyshop-woocommerce' ),
                        					'none'    => esc_html__( 'None', 'divi-bodyshop-woocommerce' ),
                        				),
                        				'priority'          => 80,
                        				'default'           => 'disc',
                        				'tab_slug'          => 'advanced',
                        				'toggle_slug'       => 'text',
                        				'sub_toggle'        => 'ul',
                        			),
                        			'ul_position' => array(
                        				'label'             => esc_html__( 'Unordered List Style Position', 'divi-bodyshop-woocommerce' ),
                        				'type'              => 'select',
                        				'option_category'   => 'configuration',
                        				'options'           => array(
                        					'outside' => esc_html__( 'Outside', 'divi-bodyshop-woocommerce' ),
                        					'inside'  => esc_html__( 'Inside', 'divi-bodyshop-woocommerce' ),
                        				),
                        				'priority'          => 85,
                        				'default'           => 'outside',
                        				'tab_slug'          => 'advanced',
                        				'toggle_slug'       => 'text',
                        				'sub_toggle'        => 'ul',
                        			),
                        			'ul_item_indent' => array(
                        				'label'           => esc_html__( 'Unordered List Item Indent', 'divi-bodyshop-woocommerce' ),
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
                        				'label'             => esc_html__( 'Ordered List Style Type', 'divi-bodyshop-woocommerce' ),
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
                        				'label'             => esc_html__( 'Ordered List Style Position', 'divi-bodyshop-woocommerce' ),
                        				'type'              => 'select',
                        				'option_category'   => 'configuration',
                        				'options'           => array(
                        					'outside' => esc_html__( 'Outside', 'divi-bodyshop-woocommerce' ),
                        					'inside'  => esc_html__( 'Inside', 'divi-bodyshop-woocommerce' ),
                        				),
                        				'priority'          => 85,
                        				'default'           => 'outside',
                        				'tab_slug'          => 'advanced',
                        				'toggle_slug'       => 'text',
                        				'sub_toggle'        => 'ol',
                        			),
                        			'ol_item_indent' => array(
                        				'label'           => esc_html__( 'Ordered List Item Indent', 'divi-bodyshop-woocommerce' ),
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
                        				'label'           => esc_html__( 'Blockquote Border Weight', 'divi-bodyshop-woocommerce' ),
                        				'type'            => 'range',
                        				'option_category' => 'configuration',
                        				'tab_slug'        => 'advanced',
                        				'toggle_slug'     => 'text',
                        				'sub_toggle'      => 'quote',
                        				'priority'        => 85,
                        				'default'         => '5px',
                        				'default_unit'    => 'px',
                        				'default_on_front' => '',
                        				'range_settings'  => array(
                        					'min'  => '0',
                        					'max'  => '100',
                        					'step' => '1',
                        				),
                        			),
                        			'quote_border_color' => array(
                        				'label'           => esc_html__( 'Blockquote Border Color', 'divi-bodyshop-woocommerce' ),
                        				'type'            => 'color-alpha',
                        				'option_category' => 'configuration',
                        				'custom_color'    => true,
                        				'tab_slug'        => 'advanced',
                        				'toggle_slug'     => 'text',
                        				'sub_toggle'      => 'quote',
                        				'field_template'  => 'color',
                        				'priority'        => 90,
                        			),
                              'admin_label' => array(
                                  'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                                  'type'        => 'text',
                                  'toggle_slug'     => 'main_content',
                                  'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                              ),
                              '__getprocontent' => array(
                              'type' => 'computed',
                              'computed_callback' => array( 'db_content_code', 'get_pro_content' ),
                              'computed_depends_on' => array(
                              'admin_label'
                              ),
                              ),
                        		);

                      return $fields;
                  }


                  public static function get_pro_content ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
//
$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
if( $is_page_builder_used ) {
  $shop = "<div class='no-html-output'><p>We do not have support for when you use the Divi builder in the content yet. We are working on this still. It will still work as expected on the front-end, you will just not get a live preview.</p></div>";
  echo $shop;
} else {
  the_content();
}

//*---------------------------------------------------------------------------------------------------*//
                    $first = false;
                } else {

                }
              endwhile; wp_reset_query(); // Remember to reset

                    $data = ob_get_clean();

                  return $data;

                  }


                  function render( $attrs, $content = null, $render_slug ) {
		self::$show_heading		= $this->props['show_heading'];
		self::$heading 			= $this->props['heading'];

    $ul_type              = $this->props['ul_type'];
		$ul_position          = $this->props['ul_position'];
		$ul_item_indent       = $this->props['ul_item_indent'];
		$ol_type              = $this->props['ol_type'];
		$ol_position          = $this->props['ol_position'];
		$ol_item_indent       = $this->props['ol_item_indent'];
		$quote_border_weight  = $this->props['quote_border_weight'];
		$quote_border_color   = $this->props['quote_border_color'];
    $excerpt_only         = $this->props['excerpt_only'];


    if (is_admin()) {
        return;
    }
                  //////////////////////////////////////////////////////////////////////
                  if( !is_product() ){
                			return;
                		}

                		$data = '';
                		// check if the content has the description module
                		global $post;

                		if( has_shortcode( $post->post_content, 'et_pb_woopro_description' ) ){
                			return;
                		}

                		// only load description if the product has
                		$all_tabs = woocommerce_default_product_tabs();

                		if( isset( $all_tabs['description'] ) ){

                			add_filter( 'woocommerce_product_description_heading', array( $this, 'change_tab_heading' ) );

                			$data = DEBC_INIT::content_buffer( 'woocommerce_product_description_tab' );

                			// remove the new title to not affect the tabs module if used
                			remove_filter( 'woocommerce_product_description_heading', array( $this, 'change_tab_heading' ) );

                		}

                		if ( '' !== $ul_type || '' !== $ul_position || '' !== $ul_item_indent ) {
                			ET_Builder_Element::set_style( $render_slug, array(
                				'selector'    => '%%order_class%% ul',
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
                				'selector'    => '%%order_class%% ol',
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
                				'selector'    => '%%order_class%% blockquote',
                				'declaration' => sprintf(
                					'%1$s
                					%2$s',
                					'' !== $quote_border_weight ? sprintf( 'border-width: %1$s;', esc_html( $quote_border_weight ) ) : '',
                					'' !== $quote_border_color ? sprintf( 'border-color: %1$s;', esc_html( $quote_border_color ) ) : ''
                				),
                			) );
                		}

                		return $data;
                  }
              }

            new db_content_code;

?>
