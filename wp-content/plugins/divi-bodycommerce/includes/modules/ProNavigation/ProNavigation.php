<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_pro_navigation_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PP Pro Navigation - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_pro_navigation';

                    $this->fields_defaults = array(
                			'nav_type' 			=> array( 'links' ),
                			'next_icon' 			=> array( '$' ),
                			'prev_icon' 			=> array( '#' ),
                			'from_same_cat' 			=> array( 'off' ),
                			'nav_text_orientation' 		=> array( 'center' ),
                      'image_max_size'        => array( '100' ),
                      'link_prev_text'        => array( 'Previous Product' ),
                      'link_next_text'        => array( 'Next Product' ),
                      'image_position'        => array( 'top' ),
                		);


          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Navigation Options', 'divi-bodyshop-woocommerce' ),
      				),
      			),
      			'advanced' => array(
      				'toggles' => array(
      					'text' => esc_html__( 'Icons Settings', 'divi-bodyshop-woocommerce' ),
      				),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';


                      $this->advanced_fields = array(
                  			'fonts' => array(
                  				'nav_links' => array(
                  					'label'    => esc_html__( 'Navigation', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                  						'main' => "{$this->main_css_element} a",
                  					),
                  					'font_size' => array(
                  						'default' => '15px',
                  					),
                  					'line_height' => array(
                  						'default' => '1.3em',
                  					),
                  				),
                  				'nav_links_on_hover' => array(
                  					'label'    => esc_html__( 'On Hover', 'divi-bodyshop-woocommerce' ),
                  					'css'      => array(
                  						'main' => "{$this->main_css_element} a:hover",
                  					),
                  					'font_size' => array(
                  						'default' => '15px',
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
                      $this->custom_css_fields = array(
                    			'nav_links' => array(
                    				'label' => esc_html__( 'Navigation Links', 'divi-bodyshop-woocommerce' ),
                    				'selector' => "{$this->main_css_element} a",
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
                			'nav_type' => array(
                				'label' => esc_html__( 'Navigation Type', 'divi-bodyshop-woocommerce' ),
                				'type' => 'select',
                				'options_category' => 'basic_option',
                				'options' => array(
                					'links'  		=> esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
                					'icons' 		=> esc_html__( 'Icons', 'divi-bodyshop-woocommerce' ),
                				),
                				'affects' => array(
                					'link_next_text',
                					'link_prev_text',
                					'next_icon',
                					'prev_icon',
                					'icon_background',
                					'icon_hover_background',
                					'icon_font_size',
                				),
                				'toggle_slug' => 'main_content',
                			),
                			'link_prev_text' => array(
                				'label'       => esc_html__( 'Previous Product Text', 'divi-bodyshop-woocommerce' ),
                				'type'        => 'text',
                				'description' => esc_html__( 'If you leave this empty, the product title will be used', 'divi-bodyshop-woocommerce' ),
                				'toggle_slug' => 'main_content',
                				'depends_show_if' => 'links',
                			),
                			'link_next_text' => array(
                				'label'       => esc_html__( 'Next Product Text', 'divi-bodyshop-woocommerce' ),
                				'type'        => 'text',
                				'description' => esc_html__( 'If you leave this empty, the product title will be used', 'divi-bodyshop-woocommerce' ),
                				'toggle_slug' => 'main_content',
                				'depends_show_if' => 'links',
                			),
                			'prev_icon' => array(
                				'label'               => esc_html__( 'Previous Icon', 'divi-bodyshop-woocommerce' ),
				                 'type'                => 'select_icon',
				                 'option_category'     => 'basic_option',
				                 'class'               => array( 'et-pb-font-icon' ),
				                 'default'				=> '#',
				                 'toggle_slug'         => 'main_content',
				                 'depends_show_if'     => 'icons',
                			),
                			'next_icon' => array(
                				'label'               => esc_html__( 'Next Icon', 'divi-bodyshop-woocommerce' ),
				                 'type'                => 'select_icon',
				                 'option_category'     => 'basic_option',
				                 'class'               => array( 'et-pb-font-icon' ),
				                 'default'				=> '$',
				                 'toggle_slug'         => 'main_content',
				                 'depends_show_if'     => 'icons',
                			),
                			'icon_font_size' => array(
                				'label'           => esc_html__( 'Icons Font Size', 'divi-bodyshop-woocommerce' ),
                				'type'            => 'range',
                				'option_category' => 'font_option',
                				'tab_slug'        => 'advanced',
                				'toggle_slug'     => 'icon_settings',
                				'default'         => '20px',
                				'range_settings' => array(
                					'min'  => '1',
                					'max'  => '120',
                					'step' => '1',
                				),
                				'mobile_options'  => true,
                				'show_if' => true,
                				'depends_show_if'     => 'icons',
                			),
                			'icon_font_size_tablet' => array(
                				'type'        => 'skip',
                				'tab_slug'    => 'advanced',
                				'toggle_slug' => 'icon_settings',
                			),
                			'icon_font_size_phone' => array(
                				'type'        => 'skip',
                				'tab_slug'    => 'advanced',
                				'toggle_slug' => 'icon_settings',
                			),
                			'icon_font_size_last_edited' => array(
                				'type'        => 'skip',
                				'tab_slug'    => 'advanced',
                				'toggle_slug' => 'icon_settings',
                			),
                			'icon_background' => array(
                				'label' 			=> esc_html__( 'Icon Background', 'divi-bodyshop-woocommerce' ),
                				'type'        		=> 'color-alpha',
                				'tab_slug'    		=> 'advanced',
                				'toggle_slug' 		=> 'icon_settings',
                				'depends_show_if'   => 'icons',
                			),
                			'icon_hover_background' => array(
                				'label' 			=> esc_html__( 'Icon Hover Background', 'divi-bodyshop-woocommerce' ),
                				'type'        		=> 'color-alpha',
                				'tab_slug'    		=> 'advanced',
                				'toggle_slug' 		=> 'icon_settings',
                				'depends_show_if'   => 'icons',
                			),
                			'from_same_cat' => array(
                				'label'           => esc_html__( 'From The Same Category', 'divi-bodyshop-woocommerce' ),
                				'type'            => 'yes_no_button',
                				'option_category' => 'basic_option','options' => array(
                					'off' 		=> esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                					'on'  		=> esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                				),
                				'toggle_slug' => 'main_content',
                			),
                			'show_product_img' => array(
                				'label'           => esc_html__( 'Show Product Featured Image', 'divi-bodyshop-woocommerce' ),
                				'type'            => 'yes_no_button',
                				'option_category' => 'basic_option','options' => array(
                					'off' 		=> esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                					'on'  		=> esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                				),
                				'affects'=>array(
                					'image_position',
                  				'image_max_size',
                          'image_border_radius'
                				),
                				'toggle_slug' => 'main_content',
                			),
                			'image_position' => array(
                				'label'             => esc_html__( 'Image Position', 'divi-bodyshop-woocommerce' ),
                				'type' => 'select',
                				'options_category' => 'layout',
                				'options' => array(
                					'top'  		=> esc_html__( 'Top', 'divi-bodyshop-woocommerce' ),
                					'bottom' 		=> esc_html__( 'Bottom', 'divi-bodyshop-woocommerce' ),
                				),
                				'description'       => esc_html__( 'Choose where you want to put the image', 'divi-bodyshop-woocommerce' ),
                				'toggle_slug' => 'main_content',
                			),
                      'image_max_size' => array(
                        'label'       => esc_html__( 'Image Max Width', 'divi-bodyshop-woocommerce' ),
                        'type'        => 'number',
                        'default'     => '100',
                        'description' => esc_html__( 'Enter in the max width that you want the featured image to be in PIXELS', 'divi-bodyshop-woocommerce' ),
                				'toggle_slug' => 'main_content',
                      ),
                      'image_border_radius' => array(
                        'label'       => esc_html__( 'Image Border Radius', 'divi-bodyshop-woocommerce' ),
                        'type'        => 'number',
                        'description' => esc_html__( 'Enter in the border-radius of the image in PIXELS', 'divi-bodyshop-woocommerce' ),
                				'toggle_slug' => 'main_content',
                      ),
                			'nav_text_orientation' => array(
                				'label'             => esc_html__( 'Nav Floating', 'divi-bodyshop-woocommerce' ),
                				'type'              => 'select',
                				'option_category'   => 'layout',
                				'options'           => array(
                					'left' => esc_html__( 'left', 'divi-bodyshop-woocommerce' ),
                					'right' => esc_html__( 'Right', 'divi-bodyshop-woocommerce' ),
                					'center' => esc_html__( 'Center', 'divi-bodyshop-woocommerce' ),
                					'edge_to_edge' => esc_html__( 'Edge to Edge', 'divi-bodyshop-woocommerce' ),
                				),
                				'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'divi-bodyshop-woocommerce' ),
                				'toggle_slug' => 'main_content',
                				'default'	=> 'center',
                			),
                		);

    		return $fields;
    	}

                  function render( $attrs, $content = null, $render_slug ) {

                    $nav_type 					= $this->props['nav_type'];
                    $link_next_text 			= $this->props['link_next_text'];
                    $link_prev_text 			= $this->props['link_prev_text'];

                    $next_icon 					= $this->props['next_icon'];
                    $prev_icon 					= $this->props['prev_icon'];

                    $icon_background 			= $this->props['icon_background'];
                    $icon_hover_background 		= $this->props['icon_hover_background'];

                    $icon_font_size 			= $this->props['icon_font_size'];
                    $icon_font_size_tablet 		= $this->props['icon_font_size_tablet'];
                    $icon_font_size_phone  		= $this->props['icon_font_size_phone'];
                    $icon_font_size_last_edited  = $this->props['icon_font_size_last_edited'];

                    $from_same_cat 				= $this->props['from_same_cat'];

                    $nav_text_orientation 		= $this->props['nav_text_orientation'];

                    $show_product_img 		= $this->props['show_product_img'];
                    $image_position 		= $this->props['image_position'];
                    $image_max_size 		= $this->props['image_max_size'];
                    $image_border_radius		= $this->props['image_border_radius'];

                      if( is_admin() ){
                        return;
                      }


                    	ob_start();

                    if( function_exists( 'is_product' ) && is_product() ){

                      global $post, $product;

                			$data = '';
                			$from_same_cat = $from_same_cat == 'on' ? true : false;
                			$nav_text_orientation = esc_attr( $nav_text_orientation );

                      $prevPost = get_previous_post();

                if ($show_product_img == "on") {
                      $prevThumbnail = get_the_post_thumbnail($prevPost, 'thumbnail');


                      if( !empty( $image_max_size ) ){

                        ET_Builder_Element::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .pro_next_image',
                          'declaration' => "width: ". esc_attr( $image_max_size ) ."px;height: ". esc_attr( $image_max_size ) ."px;",
                        ) );
                      }

                      if( !empty( $image_border_radius ) ){

                        ET_Builder_Element::set_style( $render_slug, array(
                          'selector'    => '%%order_class%% .pro_next_image',
                          'declaration' => "border-radius: ". esc_attr( $image_border_radius ) ."px;overflow:hidden;",
                        ) );
                      }

                      if ($image_max_size != "") {
                        $image_max_size_dis = $image_max_size;
                      }
                      else {
                        $image_max_size_dis = "0";
                      }

                      if ($image_border_radius != "") {
                        $image_border_radius_dis = $image_border_radius;
                      }
                      else {
                        $image_border_radius_dis = "0";
                      }

                    } else {
                      $prevThumbnail = "";
                    }


                      $nextPost = get_next_post();


                      if ($show_product_img == "on") {
                      $nextThumbnail = get_the_post_thumbnail($nextPost, 'thumbnail');
                    } else {
                      $nextThumbnail = "";
                    }

                    if( !empty( $nav_text_orientation ) ){
                      $this->add_classname( "et_pb_text_align_{$nav_text_orientation}" );
                    }

                			// links navigation
                			if( $nav_type == 'links' ){

                				$next_content = empty( $link_next_text ) ? '<div class="db_pro_nav_title">%title</div>' : esc_attr( $link_next_text );
                				$prev_content = empty( $link_prev_text ) ? '<div class="db_pro_nav_title">%title</div>' : esc_attr( $link_prev_text );

                			}

                			// icons navigation
                			if( $nav_type == 'icons' ){

                				$this->add_classname( 'icons_nav' );
                				$font_size_responsive_active = et_pb_get_responsive_status( $icon_font_size_last_edited );

                				$font_size_values = array(
                					'desktop' => $icon_font_size,
                					'tablet'  => $font_size_responsive_active ? $icon_font_size_tablet : '',
                					'phone'   => $font_size_responsive_active ? $icon_font_size_phone : '',
                				);

                				et_pb_generate_responsive_css( $font_size_values, '%%order_class%% .et-pb-icon', 'font-size', $render_slug );

                				if( !empty( $icon_background ) ){

                					ET_Builder_Element::set_style( $render_slug, array(
                						'selector'    => '%%order_class%% a',
                						'declaration' => "background: ". esc_attr( $icon_background ) .";",
                					) );
                				}

                				if( !empty( $icon_hover_background ) ){

                					ET_Builder_Element::set_style( $render_slug, array(
                						'selector'    => '%%order_class%% a:hover',
                						'declaration' => "background: ". esc_attr( $icon_hover_background ) .";",
                					) );
                				}



                				// generating icons
                				$prev_content = empty( $prev_icon ) ? '<span class="db_pro_nav_title">%title</span>' : '<span class="et-pb-icon">' . esc_attr( et_pb_process_font_icon( $prev_icon ) ) . "</span>";
                				$next_content = empty( $next_icon ) ? '<span class="db_pro_nav_title">%title</span>' : '<span class="et-pb-icon">' . esc_attr( et_pb_process_font_icon( $next_icon ) ) . "</span>";

                			}


											//////////////////////////////////////////////////////////////////////
											

                				?>
                        <div class="prev_next_cont">
                				<div class="db_pro_prev_product">
                          <?php
                          if ($image_position == "top"){
                           echo $prevThumbnail;
                         }
                           ?>
                					<div class="pro_next_link">	<?php previous_post_link( '%link', $prev_content, $from_same_cat, '', 'product_cat' ); ?></div>
                          <div class="pro_next_image"><?php
                          if ($image_position == "bottom"){
                           echo $prevThumbnail;
                         }
                          ?>
                				</div>
                				</div>

                				<div class="db_pro_next_product">
                          <?php
                          if ($image_position == "top"){
                           echo $nextThumbnail;
                         }  ?>
                				<div class="pro_next_link">	<?php next_post_link( '%link', $next_content, $from_same_cat, '', 'product_cat' ); ?></div>
                        <div class="pro_next_image"><?php
                          if ($image_position == "bottom"){
                           echo $nextThumbnail;
                         }
                         ?>
                				</div>
                				</div>
                      </div>
                				<?php
                				$data = ob_get_contents();
                			ob_end_clean();
                    }
                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_pro_navigation_code;

?>
