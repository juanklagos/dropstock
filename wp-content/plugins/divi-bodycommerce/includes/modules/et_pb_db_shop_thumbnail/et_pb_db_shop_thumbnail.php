<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_shop_thumbnail_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.LL Thumbnail - Loop Layout', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_shop_thumbnail';

                    $this->settings_modal_toggles = array(

      			'general' => array(
      			),

      		);



                      $this->main_css_element = '%%order_class%%';
                      $this->fields_defaults = array(
                      'link_product'   => array( 'on' ),
                    );

                    $this->settings_modal_toggles = array(
                      'advanced' => array(
                        'toggles' => array(
                          'overlay' => esc_html__( 'Overlay', 'et_builder' ),
                        ),
                      ),
                    );

                      $this->advanced_fields = array(
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
                      $this->custom_css_fields = array();

            $this->help_videos = array(
              array(
                'id'   => esc_html__( 'n2karNiwJ3A', 'divi-bodyshop-woocommerce' ), // YouTube video ID
                'name' => esc_html__( 'BodyCommcerce Product Page Template Guide', 'divi-bodyshop-woocommerce' ),
              ),
            );
          }

                  function get_fields() {

                    $options = DEBC_INIT::get_image_sizes();


                      $fields = array(
            'thumb_image_size' => array(
                'label' => __('Thumbnail Image Size', 'et_builder'),
                'type' => 'select',
                'options' => $options,
                'default' => 'woocommerce_thumbnail',
                'description' => __('Pick a size for the thumbnail image from the list. This will only work on the no overlay and flip image options.', 'et_builder'),
            ),
                        'link_product' => array(
                        'label'             => esc_html__( 'Link Image to Product Page', 'et_builder' ),
                        'type'              => 'yes_no_button',
                        'option_category'   => 'configuration',
                        'options'           => array(
                        'on'  => esc_html__( 'Yes', 'et_builder' ),
                        'off' => esc_html__( 'No', 'et_builder' ),
                        ),
                        'description'        => esc_html__( 'Enable this if you want to allow the user to click on the image to go to the product page.)', 'et_builder' ),
                        ),

                        'image_style' => array(
                          'label'             => esc_html__( 'Image Style', 'et_builder' ),
                          'type'              => 'select',
                          // 'option_category'   => 'color_option',
                          'options'           => array(
                            'default'  => esc_html__( 'Default', 'et_builder' ),
                            'no_overlay' => esc_html__( 'Image Only (no overlay)', 'et_builder' ),
                            'flip_image'  => esc_html__( 'Flip Image', 'et_builder' ),
                          ),
                          // 'tab_slug'          => 'advanced',
                          // 'toggle_slug'       => 'text',
                          'description'       => esc_html__( 'Choose what style of thumbnail you want, for example if you want the first image of your gallery to flip to when hovering over the thumbnail, select "Flip Hover".', 'et_builder' ),
                        ),

                        'icon_hover_color' => array(
                          'label'             => esc_html__( 'Icon Hover Color', 'et_builder' ),
                          'type'              => 'color-alpha',
                          'custom_color'      => true,
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'overlay',
                        ),
                        'hover_overlay_color' => array(
                          'label'             => esc_html__( 'Hover Overlay Color', 'et_builder' ),
                          'type'              => 'color-alpha',
                          'custom_color'      => true,
                          'tab_slug'          => 'advanced',
                          'toggle_slug'       => 'overlay',
                        ),
                        'hover_icon' => array(
				'label'               => esc_html__( 'Hover Icon Picker', 'et_builder' ),
				'type'                => 'select_icon',
				'option_category'     => 'configuration',
				'default'			=> 'P',
				'class'               => array( 'et-pb-font-icon' ),
				'depends_show_if'     => 'on',
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'overlay',
				'description'         => esc_html__( 'Here you can define a custom icon for the overlay', 'et_builder' ),
			),
      'align' => array(
				'label'           => esc_html__( 'Image Alignment', 'et_builder' ),
				'type'            => 'text_align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default_on_front' => 'left',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'alignment',
				'description'     => esc_html__( 'Here you can choose the image alignment.', 'et_builder' ),
				'options_icon'    => 'module_align',
			),
			'force_fullwidth' => array(
				'label'             => esc_html__( 'Force Fullwidth', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'layout',
				'options'           => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'default_on_front' => 'off',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'width',
				'affects' => array(
					'max_width',
				),
			),
			'always_center_on_mobile' => array(
				'label'             => esc_html__( 'Always Center Image On Mobile', 'et_builder' ),
				'type'              => 'yes_no_button',
				'option_category'   => 'layout',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'default_on_front' => 'on',
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'alignment',
			),
      'admin_label' => array(
          'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
          'type'        => 'text',
          'toggle_slug'     => 'main_content',
          'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
      ),
      '__getthumbnail' => array(
        'type' => 'computed',
        'computed_callback' => array( 'db_shop_thumbnail_code', 'get_thumbnail' ),
        'computed_depends_on' => array(
          'admin_label'
        ),
      ),
                      );

                      return $fields;
                  }


                  public static function get_thumbnail( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
$products = get_posts($args);

$first = true;
foreach($products AS $product){

  if ( $first )  {

        $product_id = $product->get_id();

        $image = get_the_post_thumbnail_url($product_id);

        $first = false;
    } else {

    }

}

?>
<div class='de_db_product_image'><span class="et_shop_image"><img width="300" height="300" src="<?php echo $image ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" /><span class="et_overlay"></span></span></div>
<?php


                    $data = ob_get_clean();

                        return $data;

                      }


                  public function get_alignment() {
                		$alignment = isset( $this->props['align'] ) ? $this->props['align'] : '';

                		return et_pb_get_alignment( $alignment );
                	}

                  function render( $attrs, $content = null, $render_slug ) {

                    if (is_admin()) {
                        return;
                    }

                          $link_product      = $this->props['link_product'];
                          $image_style     = $this->props['image_style'];
                          $align                   = $this->get_alignment();
                      		$force_fullwidth         = $this->props['force_fullwidth'];
                      		$always_center_on_mobile = $this->props['always_center_on_mobile'];
                      		$icon_hover_color     = $this->props['icon_hover_color'];
                      		$hover_overlay_color     = $this->props['hover_overlay_color'];
                      		$hover_icon              = $this->props['hover_icon'];
                      		$animation_style         = $this->props['animation_style'];
                      		$thumb_image_size         = $this->props['thumb_image_size'];





                                              		if ( '' !== $icon_hover_color ) {
                                              			ET_Builder_Element::set_style( $render_slug, array(
                                              				'selector'    => '%%order_class%% .et_overlay:before',
                                              				'declaration' => sprintf(
                                              					'color: %1$s !important;',
                                              					esc_html( $icon_hover_color )
                                              				),
                                              			) );
                                              		}

                                              		if ( '' !== $hover_overlay_color ) {
                                              			ET_Builder_Element::set_style( $render_slug, array(
                                              				'selector'    => '%%order_class%% .et_overlay',
                                              				'declaration' => sprintf(
                                              					'background-color: %1$s !important;
                                              					border-color: %1$s;',
                                              					esc_html( $hover_overlay_color )
                                              				),
                                              			) );
                                              		}

  if ( ! $this->_is_field_default( 'align', $align ) ) {
  ET_Builder_Element::set_style( $render_slug, array(
    'selector'    => '%%order_class%%',
    'declaration' => sprintf(
      'text-align: %1$s;',
      esc_html( $align )
    ),
  ) );
}

if ( 'center' !== $align ) {
  ET_Builder_Element::set_style( $render_slug, array(
    'selector'    => '%%order_class%%',
    'declaration' => sprintf(
      'margin-%1$s: 0;',
      esc_html( $align )
    ),
  ) );
}

if ( 'on' === $force_fullwidth ) {
  ET_Builder_Element::set_style( $render_slug, array(
    'selector'    => '%%order_class%%',
    'declaration' => 'max-width: 100% !important;',
  ) );

  ET_Builder_Element::set_style( $render_slug, array(
    'selector'    => '%%order_class%% .et_pb_image_wrap, %%order_class%% img',
    'declaration' => 'width: 100%;',
  ) );
}

if ( 'on' === $always_center_on_mobile ) {
  $this->add_classname( 'et_always_center_on_mobile' );
    }


    if ($image_style == "flip_image"){
      $this->add_classname( 'flip-image-thumbnail' );
        }

    if ( ! in_array( $animation_style, array( '', 'none' ) ) ) {
			$this->add_classname( 'et-waypoint' );
		}



if ( '' !== $hover_overlay_color ) {
  ET_Builder_Element::set_style( $render_slug, array(
    'selector'    => '%%order_class%% .et_overlay',
    'declaration' => sprintf(
      'background-color: %1$s;',
      esc_html( $hover_overlay_color )
    ),
  ) );
}


$css_icon_hover = DEBC_INIT::et_icon_css_content( esc_attr($hover_icon) );

ET_Builder_Element::set_style( $render_slug, array(
  'selector'    => '%%order_class%% .et_overlay:before',
  'declaration' => sprintf(
    'content: "%1$s";',
    esc_html( $css_icon_hover )
  ),
) );

// $data_icon = '' !== $hover_icon
//     ? sprintf(
//       ' data-icon="%1$s"',
//       esc_attr( et_pb_process_font_icon( $hover_icon ) )
//     )
//     : '';
//
//     $overlay_output = sprintf(
//       '<span class="et_overlay%1$s"%2$s></span>',
//       ( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
//       $data_icon
//     );
                                                  //////////////////////////////////////////////////////////////////////

                                                  if( is_admin() ){
                                                    return;
                                                  }

                                                  ob_start();


                                                  if ($link_product == 'on') {
                                                  global $product;

                                                  $product_id = $product->get_id();
                                                  $url = get_permalink( $product_id );
                                                  echo '<a href="'.$url.'" >';
                                                }

                          if ($image_style == "flip_image"){
                                    global $product;
                              $attachment_ids = $product->get_gallery_image_ids();


                                echo woocommerce_show_product_loop_sale_flash();
                                // echo woocommerce_get_product_thumbnail();


                                ?><div class="flip-image-cont"> <?php

                                if (!empty($attachment_ids)) {

                                $image_info = wp_get_attachment_image_src( $attachment_ids[0], $thumb_image_size );

                                    $attachment_first[1] = get_post_thumbnail_id( $product->get_id() );
                                    $attachment = wp_get_attachment_image_src( $attachment_first[1], $thumb_image_size );
                                    $w = $attachment[1];
                                    $h = $attachment[2];

                                  echo '<img class="secondary-image" src="'.$image_info[0].'" height="'.$h.'" width="'.$w.'">';

                                                }

                                                global $product;
                                                $image_size = apply_filters( 'single_product_archive_thumbnail_size', $thumb_image_size );
                                                echo $product ? $product->get_image( $image_size ) : '';


                                ?> </div> <?php

                          }
                          else if ($image_style == "no_overlay") {
                            echo woocommerce_show_product_loop_sale_flash();
                            // echo woocommerce_get_product_thumbnail();
                            global $product;
                            $image_size = apply_filters( 'single_product_archive_thumbnail_size', $thumb_image_size );
                            echo $product ? $product->get_image( $image_size ) : '';
                          }
                          else {
                          do_action( 'woocommerce_before_shop_loop_item_title' );
                          }


                                                  if ($link_product == 'on') {
                                                  echo '</a>';
                                                  }




                                                  $data = ob_get_clean();

                  return $data;

                  }
              }

            new db_shop_thumbnail_code;

?>
