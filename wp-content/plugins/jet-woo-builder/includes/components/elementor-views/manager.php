<?php
/**
 * Define dynamic manager class
 *
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Woo_Builder_Elementor_Views' ) ) {

	/**
	 * Define Jet_Woo_Builder_Elementor_Views class
	 */
	class Jet_Woo_Builder_Elementor_Views {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor for the class
		 */
		function init() {

			add_action( 'elementor/init', array( $this, 'init_module' ) );

			add_filter( 'jet-woo-builder/elementor-views/frontend/archive-item-content', array( $this, 'add_archive_product_card_dynamic_css' ), 10, 3 );

			add_action( 'elementor/element/before_parse_css', array( $this, 'fix_missing_bg_properties' ), 10, 2 );

			// Prevent enqueue default dynamic CSS for listings templates
			add_action( 'elementor/css-file/post/enqueue', array( $this, 'remove_enqueue_default_dynamic_css' ), 9 );
			add_action( 'elementor/css-file/post/enqueue', array( $this, 'add_enqueue_default_dynamic_css' ), 11 );
		}

		/**
		 * Initialize module
		 *
		 * @return void
		 */
		public function init_module() {
			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0-beta4', '>=' ) ) {
				require jet_woo_builder()->plugin_path( 'includes/components/elementor-views/dynamic-css.php' );
			}
		}

		/**
		 * Add dynamic CSS to the archive product card
		 *
		 * @param $content
		 * @param $template_id
		 *
		 * @return string
		 */
		public function add_archive_product_card_dynamic_css( $content, $template_id, $object ) {

			if ( ! class_exists( 'Elementor\Core\DynamicTags\Dynamic_CSS' ) ) {
				return $content;
			}

			$class          = get_class( $object );
			$reset_object   = false;
			$default_object = null;

			switch ( $class ) {
				case 'WP_Post':
					$post_id = $object->ID;
					break;

				case 'WP_Term':
					$post_id = $object->term_id;

					if ( function_exists( 'jet_engine' ) ) {
						$reset_object   = true;
						$default_object = jet_engine()->listings->data->get_current_object();

						jet_engine()->listings->data->set_current_object( get_term( $post_id ) );
					}
					break;

				default:
					$post_id = get_the_ID();
			}

			if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.0.0-beta4', '>=' ) ) {
				$css_file = Jet_Woo_Builder_Elementor_Dynamic_CSS::create( $post_id, $template_id );
			} else {
				$css_file = Elementor\Core\DynamicTags\Dynamic_CSS::create( $post_id, $template_id );
			}

			$css = $css_file->get_content();

			if ( $reset_object ) {
				jet_engine()->listings->data->set_current_object( $default_object );
			}

			if ( empty( $css ) ) {
				return $content;
			}

			$css = str_replace( '.elementor-' . $post_id, '.jet-woo-builder-archive-item-' . $post_id, $css );
			$css = sprintf( '<style type="text/css">%s</style>', $css );

			return $css . $content;

		}

		/**
		 * Fix missing background properties
		 *
		 * @param Elementor\Core\Files\CSS\Post $post_css
		 * @param Elementor\Controls_Stack      $element
		 */
		public function fix_missing_bg_properties( $post_css, $element ) {

			if ( wp_doing_ajax() && ! $this->is_editor_ajax() ) {
				return;
			}

			if ( $post_css instanceof Elementor\Core\DynamicTags\Dynamic_CSS ) {
				return;
			}

			if ( jet_woo_builder_post_type()->slug() !== get_post_type( $post_css->get_post_id() ) ) {
				return;
			}

			$dynamic_settings = $element->get_settings( '__dynamic__' );

			if ( empty( $dynamic_settings ) ) {
				return;
			}

			$all_controls           = $element->get_controls();
			$media_dynamic_settings = array();

			foreach ( $dynamic_settings as $setting => $tag ) {
				if ( Elementor\Controls_Manager::MEDIA !== $all_controls[ $setting ]['type'] ) {
					continue;
				}

				$media_dynamic_settings[] = $setting;
			}

			if ( empty( $media_dynamic_settings ) ) {
				return;
			}

			$media_conditions_keys = array_map( function ( $key ) {
				return $key . '[url]!';
			}, $media_dynamic_settings );

			foreach ( $all_controls as $control_id => $control ) {
				if ( empty( $control['selectors'] ) || empty( $control['condition'] ) ) {
					continue;
				}

				foreach ( $control['condition'] as $condition_key => $condition_value ) {
					if ( ! in_array( $condition_key, $media_conditions_keys ) ) {
						continue;
					}

					unset( $control['condition'][ $condition_key ] );

					$element->update_control( $control_id, array(
						'condition' => $control['condition'],
					) );
				}
			}

		}

		/**
		 * Remove action for enqueue default dynamic css
		 *
		 * @param Elementor\Core\Files\CSS\Post $css_file
		 */
		public function remove_enqueue_default_dynamic_css( $css_file ) {

			if ( $css_file instanceof Elementor\Core\DynamicTags\Dynamic_CSS ) {
				return;
			}

			if ( jet_woo_builder_post_type()->slug() !== get_post_type( $css_file->get_post_id() ) ) {
				return;
			}

			$dynamic_tags = Elementor\Plugin::instance()->dynamic_tags;

			remove_action( 'elementor/css-file/post/enqueue', array( $dynamic_tags, 'after_enqueue_post_css' ) );
		}

		/**
		 * Add action for enqueue default dynamic css
		 *
		 * @param Elementor\Core\Files\CSS\Post $css_file
		 */
		public function add_enqueue_default_dynamic_css( $css_file ) {

			if ( $css_file instanceof Elementor\Core\DynamicTags\Dynamic_CSS ) {
				return;
			}

			if ( jet_woo_builder_post_type()->slug() !== get_post_type( $css_file->get_post_id() ) ) {
				return;
			}

			$dynamic_tags = Elementor\Plugin::instance()->dynamic_tags;

			add_action( 'elementor/css-file/post/enqueue', array( $dynamic_tags, 'after_enqueue_post_css' ) );
		}

		/**
		 * Is editor ajax.
		 *
		 * @return bool
		 */
		public function is_editor_ajax() {
			return is_admin() && isset( $_REQUEST['action'] ) && 'elementor_ajax' === $_REQUEST['action'];
		}

		/**
		 * Returns the instance.
		 *
		 * @return object
		 * @since  1.0.0
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

	}

}

/**
 * Returns instance of Jet_Woo_Builder_Elementor_Views
 *
 * @return object
 */
function jet_woo_builder_elementor_views() {
	return Jet_Woo_Builder_Elementor_Views::get_instance();
}