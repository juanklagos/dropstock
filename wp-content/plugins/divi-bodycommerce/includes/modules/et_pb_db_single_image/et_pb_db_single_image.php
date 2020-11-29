<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_single_image_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.PP Product Image - Product Page', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_single_image';

                    $animation_option_name = sprintf( '%1$s-animation', $this->slug );
                    $global_animation_direction = ET_Global_Settings::get_value( $animation_option_name );
                    $default_animation = $global_animation_direction && '' !== $global_animation_direction ? $global_animation_direction : 'left';


                    $this->fields_defaults = array(
                      'show_in_lightbox'        => array( 'off' ),
                      'animation'               => array( $default_animation ),
                      'sticky'                  => array( 'off' ),
                      'align'                   => array( 'left' ),
                      'force_fullwidth'         => array( 'off' ),
                      'always_center_on_mobile' => array( 'on' ),
                      'use_overlay'             => array( 'off' ),
                    );

          $this->settings_modal_toggles = array(
                  			'general'  => array(
                  				'toggles' => array(
                  					'main_content' => esc_html__( 'Image', 'divi-bodyshop-woocommerce' ),
                  					'options'         => esc_html__( 'Image Options', 'divi-bodyshop-woocommerce' ),
                  				),
                  			),
                  			'advanced' => array(
                  				'toggles' => array(
                  					'overlay'    => esc_html__( 'Overlay', 'divi-bodyshop-woocommerce' ),
                  					'alignment'  => esc_html__( 'Alignment', 'divi-bodyshop-woocommerce' ),
                  					'width'      => array(
                  						'title'    => esc_html__( 'Sizing', 'divi-bodyshop-woocommerce' ),
                  						'priority' => 65,
                  					),
                  				),
                  			),
                  			'custom_css' => array(
                  				'toggles' => array(
                  					'animation' => array(
                  						'title'    => esc_html__( 'Animation', 'divi-bodyshop-woocommerce' ),
                  						'priority' => 90,
                  					),
                  					'attributes' => array(
                  						'title'    => esc_html__( 'Attributes', 'divi-bodyshop-woocommerce' ),
                  						'priority' => 95,
                  					),
                  				),
                  			),
      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
                  			'background' => array(
                  				'css' => array(
                  					'main' => "{$this->main_css_element}",
                  				),
                  				'settings' => array(
                  					'color' => 'alpha',
                  				),
                  			),
                  			'border'                => array(),
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
                  		// List of animation options
                  		$animation_options_list = array(
                  			'left'    => esc_html__( 'Left To Right', 'divi-bodyshop-woocommerce' ),
                  			'right'   => esc_html__( 'Right To Left', 'divi-bodyshop-woocommerce' ),
                  			'top'     => esc_html__( 'Top To Bottom', 'divi-bodyshop-woocommerce' ),
                  			'bottom'  => esc_html__( 'Bottom To Top', 'divi-bodyshop-woocommerce' ),
                  			'fade_in' => esc_html__( 'Fade In', 'divi-bodyshop-woocommerce' ),
                  			'off'     => esc_html__( 'No Animation', 'divi-bodyshop-woocommerce' ),
                  		);

                  		$animation_option_name       = sprintf( '%1$s-animation', $this->slug );
                  		$default_animation_direction = ET_Global_Settings::get_value( $animation_option_name );

                  		// If user modifies default animation option via Customizer, we'll need to change the order
                  		if ( 'left' !== $default_animation_direction && ! empty( $default_animation_direction ) && array_key_exists( $default_animation_direction, $animation_options_list ) ) {
                  			// The options, sans user's preferred direction
                  			$animation_options_wo_default = $animation_options_list;
                  			unset( $animation_options_wo_default[ $default_animation_direction ] );

                  			// All animation options
                  			$animation_options = array_merge(
                  				array( $default_animation_direction => $animation_options_list[$default_animation_direction] ),
                  				$animation_options_wo_default
                  			);
                  		} else {
                  			// Simply copy the animation options
                  			$animation_options = $animation_options_list;
                  		}

                  		$fields = array(
                  			'show_in_lightbox' => array(
                  				'label'             => esc_html__( 'Open in Lightbox', 'divi-bodyshop-woocommerce' ),
                  				'type'              => 'yes_no_button',
                  				'option_category'   => 'configuration',
                  				'options'           => array(
                  					'off' => esc_html__( "No", 'divi-bodyshop-woocommerce' ),
                  					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                  				),
                  				'affects'           => array(
                  					'use_overlay'
                  				),
                  				'toggle_slug'       => 'options',
                  				'description'       => esc_html__( 'Here you can choose whether or not the image should open in Lightbox.', 'divi-bodyshop-woocommerce' ),
                  			),
                        'chosen_image' => array(
                        'label'             => esc_html__( 'Gallery Image', 'divi-bodyshop-woocommerce' ),
                        'type'              => 'select',
                        'toggle_slug'       => 'options',
                        'options'           => array(
                        1  => esc_html__( 'Featured Image', 'divi-bodyshop-woocommerce' ),
                        2  => esc_html__( '2nd', 'divi-bodyshop-woocommerce' ),
                        3  => esc_html__( '3rd', 'divi-bodyshop-woocommerce' ),
                        4  => esc_html__( '4th', 'divi-bodyshop-woocommerce' ),
                        5  => esc_html__( '5th', 'divi-bodyshop-woocommerce' ),
                        6  => esc_html__( '6th', 'divi-bodyshop-woocommerce' ),
                        7  => esc_html__( '7th', 'divi-bodyshop-woocommerce' ),
                        8  => esc_html__( '8th', 'divi-bodyshop-woocommerce' ),
                        9  => esc_html__( '9th', 'divi-bodyshop-woocommerce' ),
                        10  => esc_html__( '10th', 'divi-bodyshop-woocommerce' ),
                        ),
                        'description'        => esc_html__( 'If you want to show a specific image in your gallery choose the number here. If you want the 2nd image for example, choose "2nd".', 'divi-bodyshop-woocommerce' ),
                        'default'            => '1',
                        ),
                    			'hide_image_no_image' => array(
                    				'label'             => esc_html__( 'Show featured image when no image?', 'divi-bodyshop-woocommerce' ),
                    				'type'              => 'yes_no_button',
                    				'option_category'   => 'configuration',
                    				'options'           => array(
                    					'off' => esc_html__( "No", 'divi-bodyshop-woocommerce' ),
                    					'on'  => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                    				),
                    				'toggle_slug'       => 'options',
                            'default'           => 'on',
                    				'description'       => esc_html__( 'If you have chosen the 4th image for example and there are only 2 images uploaded, do you want to show the featured or nothing?.', 'divi-bodyshop-woocommerce' ),
                    			),
                  			'use_overlay' => array(
                  				'label'             => esc_html__( 'Image Overlay', 'divi-bodyshop-woocommerce' ),
                  				'type'              => 'yes_no_button',
                  				'option_category'   => 'layout',
                  				'depends_show_if'   => 'on',
                  				'options'           => array(
                  					'off' => esc_html__( 'Off', 'divi-bodyshop-woocommerce' ),
                  					'on'  => esc_html__( 'On', 'divi-bodyshop-woocommerce' ),
                  				),
                  				'affects'           => array(
                  					'overlay_icon_color',
                  					'hover_overlay_color',
                  					'hover_icon',
                  				),
                  				'depends_show_if'   => 'on',
                  				'tab_slug'          => 'advanced',
                  				'toggle_slug'       => 'overlay',
                  				'description'       => esc_html__( 'If enabled, an overlay color and icon will be displayed when a visitors hovers over the image', 'divi-bodyshop-woocommerce' ),
                  			),
                  			'overlay_icon_color' => array(
                  				'label'             => esc_html__( 'Overlay Icon Color', 'divi-bodyshop-woocommerce' ),
                  				'type'              => 'color-alpha',
                  				'custom_color'      => true,
                  				'depends_show_if'   => 'on',
                  				'tab_slug'          => 'advanced',
                  				'toggle_slug'       => 'overlay',
                  				'description'       => esc_html__( 'Here you can define a custom color for the overlay icon', 'divi-bodyshop-woocommerce' ),
                  			),
                  			'hover_overlay_color' => array(
                  				'label'             => esc_html__( 'Hover Overlay Color', 'divi-bodyshop-woocommerce' ),
                  				'type'              => 'color-alpha',
                  				'custom_color'      => true,
                  				'depends_show_if'   => 'on',
                  				'tab_slug'          => 'advanced',
                  				'toggle_slug'       => 'overlay',
                  				'description'       => esc_html__( 'Here you can define a custom color for the overlay', 'divi-bodyshop-woocommerce' ),
                  			),
                  			'hover_icon' => array(
                  				'label'               => esc_html__( 'Hover Icon Picker', 'divi-bodyshop-woocommerce' ),
                  				'type'                => 'text',
                  				'option_category'     => 'configuration',
                  				'class'               => array( 'et-pb-font-icon' ),
                  				'renderer'            => 'select_icon',
                  				'renderer_with_field' => true,
                  				'depends_show_if'     => 'on',
                  				'tab_slug'            => 'advanced',
                  				'toggle_slug'         => 'overlay',
                  				'description'       => esc_html__( 'Here you can define a custom icon for the overlay', 'divi-bodyshop-woocommerce' ),
                  			),
                  			'animation' => array(
                  				'label'             => esc_html__( 'Animation', 'divi-bodyshop-woocommerce' ),
                  				'type'              => 'select',
                  				'option_category'   => 'configuration',
                  				'options'           => $animation_options,
                  				'tab_slug'          => 'custom_css',
                  				'toggle_slug'       => 'animation',
                  				'description'       => esc_html__( 'This controls the direction of the lazy-loading animation.', 'divi-bodyshop-woocommerce' ),
                  			),
                  			'sticky' => array(
                  				'label'             => esc_html__( 'Remove Space Below The Image', 'divi-bodyshop-woocommerce' ),
                  				'type'              => 'yes_no_button',
                  				'option_category'   => 'layout',
                  				'options'           => array(
                  					'off'     => esc_html__( 'No', 'divi-bodyshop-woocommerce' ),
                  					'on'      => esc_html__( 'Yes', 'divi-bodyshop-woocommerce' ),
                  				),
                  				'tab_slug'          => 'advanced',
                  				'toggle_slug'       => 'alignment',
                  				'description'       => esc_html__( 'Here you can choose whether or not the image should have a space below it.', 'divi-bodyshop-woocommerce' ),
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
                  				'mobile_options'  => true,
                  			),
                        'admin_label' => array(
                            'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
                            'type'        => 'text',
                            'toggle_slug'     => 'main_content',
                            'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
                        ),
                        '__getprofeatimage' => array(
                        'type' => 'computed',
                        'computed_callback' => array( 'db_single_image_code', 'get_pro_featimage' ),
                        'computed_depends_on' => array(
                        'admin_label'
                        ),
                        ),
                  		);

                  		return $fields;
                  }

                  public function get_alignment( $device = 'desktop' ) {
                		$is_desktop = 'desktop' === $device;
                		$suffix     = ! $is_desktop ? "_{$device}" : '';
                		$alignment  = $is_desktop && isset( $this->props["align"] ) ? $this->props["align"] : '';

                		if ( ! $is_desktop && et_pb_responsive_options()->is_responsive_enabled( $this->props, 'align' ) ) {
                			$alignment = et_pb_responsive_options()->get_any_value( $this->props, "align{$suffix}" );
                		}

                		return et_pb_get_alignment( $alignment );
                	}

                  public static function get_pro_featimage ( $args = array(), $conditional_tags = array(), $current_page = array() ){
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
if( has_post_thumbnail() ){
  $src = get_the_post_thumbnail_url();
  $thumbnail_id = get_post_thumbnail_id();
  $alt = esc_attr( get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) );
}else{
  $src = esc_url( wc_placeholder_img_src() );
}
                ?>
                <div class="et_pb_db_image et_pb_module et_pb_image">
                  <img src="<?php echo $src; ?>" />
                </div>
                <?php
//*---------------------------------------------------------------------------------------------------*//
                    $first = false;
                } else {

                }
              endwhile; wp_reset_query(); // Remember to reset

                    $data = ob_get_clean();

                  return $data;

                  }

                  function render( $attrs, $content = null, $render_slug ) {

                      $animation               = $this->props['animation'];
                  		$show_in_lightbox        = $this->props['show_in_lightbox'];
                  		$sticky                  = $this->props['sticky'];
                  		$overlay_icon_color      = $this->props['overlay_icon_color'];
                  		$hover_overlay_color     = $this->props['hover_overlay_color'];
                  		$hover_icon              = $this->props['hover_icon'];
                  		$use_overlay             = $this->props['use_overlay'];
                  		$chosen_image             = $this->props['chosen_image'];
                  		$align                   = $this->get_alignment();
                  		$align_tablet            = $this->get_alignment( 'tablet' );
                  		$align_phone             = $this->get_alignment( 'phone' );

                      $hide_image_no_image             = $this->props['hide_image_no_image'];


                      // Responsive Image Alignment.
                  		// Set CSS properties and values for the image alignment.
                  		// 1. Text Align is necessary, just set it from current image alignment value.
                  		// 2. Margin {Side} is optional. Used to pull the image to right/left side.
                  		// 3. Margin Left and Right are optional. Used by Center to reset custom margin of point 2.
                  		$align_values = array(
                  			'desktop' => array(
                  				'text-align'      => esc_html( $align ),
                  				"margin-{$align}" => ! empty( $align ) && 'center' !== $align ? '0' : '',
                  			),
                  			'tablet'  => array(
                  				'text-align'             => esc_html( $align_tablet ),
                  				'margin-left'            => 'left' !== $align_tablet ? 'auto' : '',
                  				'margin-right'           => 'left' !== $align_tablet ? 'auto' : '',
                  				"margin-{$align_tablet}" => ! empty( $align_tablet ) && 'center' !== $align_tablet ? '0' : '',
                  			),
                  			'phone'   => array(
                  				'text-align'            => esc_html( $align_phone ),
                  				'margin-left'           => 'left' !== $align_phone ? 'auto' : '',
                  				'margin-right'          => 'left' !== $align_phone ? 'auto' : '',
                  				"margin-{$align_phone}" => ! empty( $align_phone ) && 'center' !== $align_phone ? '0' : '',
                  			),
                  		);

                  		et_pb_responsive_options()->generate_responsive_css( $align_values, '%%order_class%%', '', $render_slug, '', 'alignment' );


                  //////////////////////////////////////////////////////////////////////


                                  if( is_admin() ){
                                    return;
                                  }

                                  ob_start();


                                    global $product;

                                  $title_text = get_the_title();
                  $alt = '';

                  if( has_post_thumbnail() ){
                    $src = get_the_post_thumbnail_url();
                    $thumbnail_id = get_post_thumbnail_id();
                    $alt = esc_attr( get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ) );
                  }else{
                    $src = esc_url( wc_placeholder_img_src() );
                  }

                  if(empty( $alt ) ){
                    $alt = $title_text;
                  }

                  // overlay can be applied only if image has link or if lightbox enabled
  $is_overlay_applied = 'on' === $use_overlay && 'on' === $show_in_lightbox ? 'on' : 'off';


  if ( 'on' === $is_overlay_applied ) {
    if ( '' !== $overlay_icon_color ) {
      ET_Builder_Element::set_style( $function_name, array(
        'selector'    => '%%order_class%% .et_overlay:before',
        'declaration' => sprintf(
          'color: %1$s !important;',
          esc_html( $overlay_icon_color )
        ),
      ) );
    }

    if ( '' !== $hover_overlay_color ) {
      ET_Builder_Element::set_style( $function_name, array(
        'selector'    => '%%order_class%% .et_overlay',
        'declaration' => sprintf(
          'background-color: %1$s;',
          esc_html( $hover_overlay_color )
        ),
      ) );
    }

    $data_icon = '' !== $hover_icon
      ? sprintf(
        ' data-icon="%1$s"',
        esc_attr( et_pb_process_font_icon( $hover_icon ) )
      )
      : '';

    $overlay_output = sprintf(
      '<span class="et_overlay%1$s"%2$s></span>',
      ( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
      $data_icon
    );
  }

  $attachment_ids = $product->get_gallery_image_ids();


if ($chosen_image == 1) {
  $image_src = esc_url( $src );

  $output = sprintf(
    '<img src="%1$s" alt="%2$s"%3$s />
    %4$s',
    $image_src,
    esc_attr( $alt ),
    ( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' ),
    'on' === $is_overlay_applied ? $overlay_output : ''
  );

}
else {
$chosen_image_number = $chosen_image - 2;
if(array_key_exists($chosen_image_number, $attachment_ids)){
  $image_link = wp_get_attachment_url( $attachment_ids[$chosen_image_number] );
  $image_src = $image_link;

  $output = sprintf(
    '<img src="%1$s" alt="%2$s"%3$s />
    %4$s',
    $image_src,
    esc_attr( $alt ),
    ( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' ),
    'on' === $is_overlay_applied ? $overlay_output : ''
  );

}
else {
  if ($hide_image_no_image == "on") {
    $image_src = esc_url( $src );

    $output = sprintf(
      '<img src="%1$s" alt="%2$s"%3$s />
      %4$s',
      $image_src,
      esc_attr( $alt ),
      ( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' ),
      'on' === $is_overlay_applied ? $overlay_output : ''
    );

  } else {
  $output = "";
}
}
}







  if ( 'on' === $show_in_lightbox ) {
    $output = sprintf( '<a href="%1$s" class="et_pb_lightbox_image" title="%3$s">%2$s</a>',
      $image_src,
      $output,
      esc_attr( $title_text )
    );
  }




  $animation = '' === $animation ? ET_Global_Settings::get_value( 'et_pb_image-animation' ) : $animation;

  $output = sprintf(
    '<div%4$s class="et_pb_db_image et_pb_module et-waypoint et_pb_image%2$s%3$s">
      %1$s
    </div>',
    $output,
    esc_attr( " et_pb_animation_{$animation}" ),
    ( 'on' === $sticky ? esc_attr( ' et_pb_image_sticky' ) : '' ),
    'on' === $is_overlay_applied ? ' et_pb_has_overlay' : ''
  );

                    		echo $output;


                                  $data = ob_get_clean();

                                   //////////////////////////////////////////////////////////////////////

                                return $data;
                  }
              }

            new db_single_image_code;

?>
