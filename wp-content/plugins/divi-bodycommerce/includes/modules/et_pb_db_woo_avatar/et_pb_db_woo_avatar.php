<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class db_woo_avatar_code extends ET_Builder_Module {

public $vb_support = 'on';

protected $module_credits = array(
  'module_uri' => DE_DB_PRODUCT_URL,
  'author'     => DE_DB_AUTHOR,
  'author_uri' => DE_DB_URL,
);

                function init() {
                    $this->name       = esc_html__( '.AP Avatar - Account Pages', 'divi-bodyshop-woocommerce' );
                    $this->slug = 'et_pb_db_woo_avatar';


          $this->settings_modal_toggles = array(
      			'general' => array(
      				'toggles' => array(
      					'main_content' => esc_html__( 'Module Options', 'divi-bodyshop-woocommerce' ),
      				),
      			),
      			'advanced' => array(
      				'toggles' => array(
      					'text' => esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
      				),
      			),

      		);


                      $this->main_css_element = '%%order_class%%';
                      $this->advanced_fields = array(
        			'fonts' => array(
        				'text'   => array(
        					'label'    => esc_html__( 'Text', 'divi-bodyshop-woocommerce' ),
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

                  }

                  function get_fields() {
    		$fields = array(
          'src' => array(
    				'label'              => esc_html__( 'Backup Image', 'et_builder' ),
    				'type'               => 'upload',
    				'option_category'    => 'basic_option',
    				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
    				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
    				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
    				'computed_affects' => array(
    					'__getavatar',
    				),
    				'affects'            => array(
    					'alt',
    					'title_text',
    				),
    				'description'        => esc_html__( 'Upload a default avatar if the user has no image', 'et_builder' ),
    				'toggle_slug'        => 'main_content',
    			),
    			'alt' => array(
    				'label'           => esc_html__( 'Image Alternative Text', 'et_builder' ),
    				'type'            => 'text',
    				'option_category' => 'basic_option',
    				'show_if' => true,
    				'depends_to'      => array(
    					'src',
    				),
    				'description'     => esc_html__( 'This defines the HTML ALT text. A short description of your image can be placed here.', 'et_builder' ),
    				'tab_slug'        => 'custom_css',
    				'toggle_slug'     => 'attributes',
    			),
    			'title_text' => array(
    				'label'           => esc_html__( 'Image Title Text', 'et_builder' ),
    				'type'            => 'text',
    				'option_category' => 'basic_option',
    				'toggle_slug'        => 'main_content',
    				'show_if' => true,
),
'admin_label' => array(
    'label'       => __( 'Admin Label', 'divi-bodyshop-woocommerce' ),
    'type'        => 'text',
    'toggle_slug'     => 'main_content',
    'description' => __( 'This will change the label of the module in the builder for easy identification.', 'divi-bodyshop-woocommerce' ),
),
'__getavatar' => array(
  'type' => 'computed',
  'computed_callback' => array( 'db_woo_avatar_code', 'get_avatar' ),
  'computed_depends_on' => array(
    'admin_label'
  ),
),
    		);

    		return $fields;
    	}

      public static function get_avatar( $args = array(), $conditional_tags = array(), $current_page = array() ){
        if (!is_admin()) {
    			return;
    		}

if( isset( $args['src'] ) ){
        $src_dis  = $args['src'];
      } else {$src_dis = "";}




        $data = '';
      //////////////////////////////////////////////////////////////////////

        ob_start();

        $user = wp_get_current_user();


  if( get_avatar_url( $user->ID ) == "http://0.gravatar.com/avatar/6c8aa3d93eecfd074a8dd41d3c681ea8?s=96&d=mm&r=g" ){

if ($src == "") {
  $imageurl = "http://0.gravatar.com/avatar/6c8aa3d93eecfd074a8dd41d3c681ea8?s=96&d=mm&r=g";
}
else {
  $imageurl = $src_dis;
}

    $output = sprintf(
            '<img src="%1$s" />',
      $imageurl
    );

}else{

        $output = sprintf(
                '<img src="%1$s"  />',
          esc_url( get_avatar_url( $user->ID ))
        );
}

echo $output;

        $data = ob_get_clean();

       //////////////////////////////////////////////////////////////////////

      return $data;


      }

                  function render( $attrs, $content = null, $render_slug ) {

                    if (is_admin()) {
                        return;
                    }

                    $src                     = $this->props['src'];
                		$alt                     = $this->props['alt'];
                		$title_text              = $this->props['title_text'];




                    $data = '';
                  //////////////////////////////////////////////////////////////////////

                    ob_start();

                    $user = wp_get_current_user();


              if( get_avatar_url( $user->ID ) == "http://0.gravatar.com/avatar/6c8aa3d93eecfd074a8dd41d3c681ea8?s=96&d=mm&r=g" ){

            if ($src == "") {
              $imageurl = "http://0.gravatar.com/avatar/6c8aa3d93eecfd074a8dd41d3c681ea8?s=96&d=mm&r=g";
            }
            else {
              $imageurl = $src;
            }

                $output = sprintf(
                        '<img src="%1$s" alt="%2$s"%3$s />',
                  $imageurl,
                  esc_attr( $alt ),
                  ( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' )
                );

            }else{

                		$output = sprintf(
                            '<img src="%1$s" alt="%2$s"%3$s />',
                			esc_url( get_avatar_url( $user->ID )),
                			esc_attr( $alt ),
                			( '' !== $title_text ? sprintf( ' title="%1$s"', esc_attr( $title_text ) ) : '' )
                		);
            }

            echo $output;

                    $data = ob_get_clean();

                   //////////////////////////////////////////////////////////////////////

                  return $data;
                  }
              }

            new db_woo_avatar_code;

?>
