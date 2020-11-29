<?php

class XforWC_Live_Editor_Frontend {

	public static $path;
	public static $url_path;
	public static $settings;
	public static $version;

	public static function init() {
		$class = __CLASS__;
		new $class;
	}

	function __construct() {

		if ( !class_exists('Woocommerce') ) {
			return;
		}
		self::$version = Wfsm()->version();

		add_shortcode( 'wfsm_new_product', array( &$this, 'shortcode' ) );

		self::$settings['user'] = wp_get_current_user();
		if ( !self::$settings['user']->exists() ) {
			return;
		}

		self::$settings['mode'] = get_option( 'wc_settings_wfsm_mode', 'wfsm_mode_logo' );
		self::$settings['style'] = get_option( 'wc_settings_wfsm_style', 'wfsm_style_default' );
		if ( !in_array( self::$settings['style'], array( 'wfsm_style_default', 'wfsm_style_flat', 'wfsm_style_dark' ) ) ) {
			self::$settings['style'] = 'wfsm_style_default';
		}
		self::$settings['logo'] = get_option( 'wc_settings_wfsm_logo', '' );
		self::$settings['hidden'] = get_option( 'wc_settings_wfsm_show_hidden_products', 'no' );
		self::$settings['groups'] = get_option( 'wc_settings_wfsm_vendor_groups', array() );
		self::$settings['max_products'] = get_option( 'wc_settings_wfsm_vendor_max_products', '' );
		self::$settings['woocommerce']['decimal_sep'] = get_option( 'woocommerce_price_decimal_sep' );
		self::$settings['custom_settings'] = get_option( 'wc_settings_wfsm_custom_settings', array() );
		self::$settings['new_button'] = get_option( 'wc_settings_wfsm_new_button', 'no' );

		do_action( 'wfsm_add_settings' );

		if ( self::$settings['user']->has_cap( 'administrator' ) || self::$settings['user']->has_cap( 'manage_woocommerce' ) ) {
			self::$settings['user_permissions'] = array();
			self::$settings['admin_mode'] = true;
		}
		else {

			if ( !empty( self::$settings['groups'] ) ) {
				$curr_group = get_user_meta( self::$settings['user']->ID, 'wfsm_group', true );

				if ( $curr_group !== '' && array_key_exists( $curr_group, self::$settings['groups'] ) ) {
					self::$settings['user_permissions'] = isset( self::$settings['groups'][$curr_group]['permissions'] ) ? self::$settings['groups'][$curr_group]['permissions'] : array();
				}
				else {
					self::$settings['user_permissions'] = get_option( 'wc_settings_wfsm_default_permissions', array() );
				}
			}
			else {
				self::$settings['user_permissions'] = get_option( 'wc_settings_wfsm_default_permissions', array() );
			}

			if ( !is_array( self::$settings['user_permissions'] ) ) {
				self::$settings['user_permissions'] = array();
			}

		}

		self::$path = plugin_dir_path( __FILE__ );
		self::$url_path = Wfsm()->plugin_url();

		add_action( 'wp_enqueue_scripts', array(&$this, 'wfsm_scripts') );
		add_action( 'wp_footer', array(&$this, 'wfsm_check_scripts') );

		self::$settings['wc_settings_wfsm_archive_action'] = get_option( 'wc_settings_wfsm_archive_action', '' );
		if ( self::$settings['wc_settings_wfsm_archive_action'] == '' ) {
			self::$settings['wc_settings_wfsm_archive_action'] = 'woocommerce_before_shop_loop_item:0';
		}

		$curr_action = array();
		$curr_action = explode( ':', self::$settings['wc_settings_wfsm_archive_action'] );
		$curr_action[1] = isset( $curr_action[1] ) ? intval( $curr_action[1] ) : 10;
		add_action( $curr_action[0],  array(&$this, 'wfsm_content'), $curr_action[1] );


		self::$settings['wc_settings_wfsm_single_action'] = get_option( 'wc_settings_wfsm_single_action', '' );
		if ( self::$settings['wc_settings_wfsm_single_action'] == '' ) {
			self::$settings['wc_settings_wfsm_single_action'] = 'woocommerce_before_single_product_summary:5';
		}

		$curr_action = array();
		$curr_action = explode( ':', self::$settings['wc_settings_wfsm_single_action'] );
		$curr_action[1] = isset( $curr_action[1] ) ? intval( $curr_action[1] ) : 10;
		add_action( $curr_action[0],  array(&$this, 'wfsm_content'), $curr_action[1] );

		add_action( 'wp_ajax_wfsm_respond', array(&$this, 'wfsm_respond') );
		add_action( 'wp_ajax_wfsm_save', array(&$this, 'wfsm_save') );

		if ( self::$settings['hidden'] == 'yes' ) {
			add_filter( 'pre_get_posts', array(&$this, 'wfsm_query' ), 1000000, 1);
		}

		$wfsm_permission = array( 'create_simple_product', 'create_grouped_product', 'create_external_product', 'create_variable_product' );
		if ( count ( array_intersect( self::$settings['user_permissions'], $wfsm_permission ) ) < 4 ) {
			if ( self::$settings['new_button'] == 'no' ) {
				add_action( 'wp_footer', array(&$this, 'wfsm_add_product') );
			}
			add_action( 'wp_ajax_wfsm_add_product_respond', array(&$this, 'wfsm_add_product_respond') );
			add_action( 'wp_ajax_wfsm_delete_product', array(&$this, 'wfsm_delete_product') );
		}

		if ( !in_array( 'product_content' , self::$settings['user_permissions'] ) ) {
			add_action( 'wp_ajax_wfsm_editor', array(&$this, 'wfsm_editor') );
			add_action( 'wp_ajax_wfsm_editor_save', array(&$this, 'wfsm_editor_save') );
		}

		if ( !in_array( 'variable_add_variations' , self::$settings['user_permissions'] ) ) {
			add_action( 'wp_ajax_wfsm_add_variation_respond', array(&$this, 'wfsm_add_variation_respond') );
		}

		if ( !in_array( 'product_clone' , self::$settings['user_permissions'] ) ) {
			add_action( 'wp_ajax_wfsm_clone', array(&$this, 'wfsm_clone') );
		}
		
		if ( !in_array( 'product_delete' , self::$settings['user_permissions'] ) || !in_array( 'variable_delete' , self::$settings['user_permissions'] ) ) {
			add_action( 'wp_ajax_wfsm_trash', array(&$this, 'wfsm_trash') );
		}

		if ( !in_array( 'product_attributes' , self::$settings['user_permissions'] ) ) {
			add_action( 'wp_ajax_wfsm_create_attribute', array(&$this, 'wfsm_create_attribute') );
		}

		add_action( 'init', array(&$this, 'add_settings') );

		add_action( 'wfsm_get_loop_buttons', array( &$this, 'wfsm_content' ) );

		add_filter( 'mnthemes_add_meta_information_used', array( &$this, 'wfsm_info' ) );

	}

	function wfsm_info( $val ) {
		return array_merge( $val, array( 'Live Product Editor for WooCommerce' ) );
	}

	function wfsm_scripts() {

		wp_enqueue_style( 'jquery-ui', Wfsm()->plugin_url() . '/assets/css/jquery_ui.css' );
		wp_enqueue_style( 'wfsm-style', Wfsm()->plugin_url() . '/assets/css/' . self::$settings['style'] . '.css', false, self::$version );

		wp_register_script( 'wfsm-tinymce', '//cloud.tinymce.com/stable/tinymce.min.js', false, self::$version, true );
		wp_register_script( 'wfsm-selectize', Wfsm()->plugin_url() . '/assets/js/selectize.min.js', array( 'jquery' ), self::$version, true );
		wp_register_script( 'wfsm-scripts', Wfsm()->plugin_url() . '/assets/js/scripts.js', array( 'jquery' ), self::$version, true );
		wp_register_script( 'wfsm-init', Wfsm()->plugin_url() . '/assets/js/scripts-init.js', array( 'jquery' ), self::$version, false );
		wp_enqueue_media();
		wp_enqueue_script( array( 'wfsm-init', 'jquery-ui-sortable', 'jquery-ui-datepicker', 'wfsm-selectize', 'wfsm-scripts', 'wfsm-tinymce' ) );

	}

	function wfsm_check_scripts() {

		global $wfsm_global;

		if ( !isset( $wfsm_global['init'] ) && get_option( 'wc_settings_wfsm_force_scripts' ,'no' ) == 'no' ) {
			wp_dequeue_script( array( 'wfsm-init', 'wfsm-selectize', 'wfsm-scripts', 'wfsm-tinymce' ) );
		}
		else if ( wp_script_is( 'wfsm-scripts', 'enqueued' ) ) {

			$curr_args = array(
				'ajax' => admin_url( 'admin-ajax.php' ),
				'decimal_separator' => self::$settings['woocommerce']['decimal_sep'],
				'new_button' => self::$settings['new_button'],
				'localization' => array(
					'downloads' => array(
						'discard' => esc_html__( 'Delete File?', 'woocommerce-frontend-shop-manager' ),
						'file_name' => esc_html__( 'File Name', 'woocommerce-frontend-shop-manager' ),
						'choose_file_ui' => esc_html__( 'Choose file', 'woocommerce-frontend-shop-manager' ),
						'choose_file' => esc_html__( 'Choose File', 'woocommerce-frontend-shop-manager' )
					),
					'clone' => array(
						'question' => esc_html__( 'Duplicate product?', 'woocommerce-frontend-shop-manager' ),
						'confirmed' => esc_html__( 'Product duplicated!', 'woocommerce-frontend-shop-manager' )
					),
					'trash' => array(
						'simple' => esc_html__( 'Trash product?', 'woocommerce-frontend-shop-manager' ),
						'variation' => esc_html__( 'Trash variation?', 'woocommerce-frontend-shop-manager' )
					),
					'errors' => array(
						'decimal' => esc_html__( 'Use only numbers and the decimal separator!', 'woocommerce-frontend-shop-manager' ) . ' ( ' . self::$settings['woocommerce']['decimal_sep'] . ' )',
					),
					'discard' => array(
						'question' => esc_html__( 'Discard product?', 'woocommerce-frontend-shop-manager' ),
						'confirmed' => esc_html__( 'Product discarded!', 'woocommerce-frontend-shop-manager' )
					)
				)
			);

			wp_localize_script( 'wfsm-scripts', 'wfsm', $curr_args );

		}

	}

	function wfsm_query( $query ) {

		global $prdctfltr_global;

		if ( is_admin() && ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			return;
		}
		else if ( !is_admin() && ( isset( $query->query['prdctfltr'] ) && $query->query['prdctfltr'] == 'active' ) !== false ) {
			$pf_mode = 'shortcode';
		}
		else if ( !is_admin() && $query->is_main_query() && ( $query->is_tax( get_object_taxonomies( 'product' ) ) || $query->is_post_type_archive( 'product' ) || ( isset( $query->query_vars['page_id'] ) && $query->query_vars['page_id'] == ( self::wfsm_wpml_get_id( wc_get_page_id( 'shop' ) ) ) ) ) ) {
			$pf_mode = 'archive';
		}
		else if ( isset( $prdctfltr_global['ajax'] ) && ( defined('DOING_AJAX') && DOING_AJAX ) ) {
			$pf_mode = 'shortcode_ajax';
		}
		else { 
			return;
		}

		$query->set( 'post_status', apply_filters( 'wfsm_archive_post_statuses', array( 'publish', 'pending', 'draft' ) ) );

	}

	function wfsm_wpml_get_id( $post_id = 0, $type = 'post_product' ){
		global $post, $sitepress;

		if ( empty( $post ) || empty( $sitepress ) ) {
			return 0;
		}

		$output = array();

		$p_ID = $post_id == 0 ? $post->ID : $post_id;

		$el_trid = $sitepress->get_element_trid( $p_ID, $type );

		$el_translations = $sitepress->get_element_translations( $el_trid, $type );

		if( !empty( $el_translations ) ) {
			$is_original = FALSE;
			foreach( $el_translations as $lang => $details ) {
				if( $details->original == 1 && $details->element_id == $p_ID ) {
					$is_original = TRUE;
				}
				if( $details->original == 1 ) {
					$original_ID = $details->element_id;
				}
			}
			$output['is_original'] = $is_original;
			$output['original_ID'] = $original_ID;
		}
		else {
			$output['original_ID'] = $p_ID;
		}

		
		return isset( $output['original_ID'] ) ? absint( $output['original_ID'] ) : $p_ID;
	}

	function wfsm_add_product() {

		if ( !is_woocommerce() ) {
			return;
		}

		global $wfsm_global;

		if ( !isset( $wfsm_global['init'] ) ) {
			$wfsm_global['init'] = true;
		}

		$buttons_class = !in_array( 'backend_buttons' , self::$settings['user_permissions'] ) ? '' : ' wfsm-backend-side-disabled'; // OK

	?>
		<div class="wfsm-buttons wfsm-side-buttons<?php echo esc_attr( $buttons_class ); ?>">
			<a href="#" class="wfsm-button wfsm-add-product" title="<?php esc_html_e( 'Add New Product', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-activate"></i></a>
		<?php
			if ( !in_array( 'backend_buttons' , self::$settings['user_permissions'] ) ) {
		?>
			<a href="<?php echo esc_url( admin_url( 'post.php?action=edit&post=' ) ); ?>" class="wfsm-button wfsm-edit" title="<?php esc_html_e( 'Edit product in the backend', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-edit"></i></a>
		<?php
			}
		?>
			<a href="#" class="wfsm-button wfsm-save" title="<?php esc_html_e( 'Save changes', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-save"></i></a>
			<a href="#" class="wfsm-button wfsm-discard" title="<?php esc_html_e( 'Discard changes', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-discard"></i></a>
			<div class="wfsm-add-product-type">
		<?php
			if ( !in_array( 'create_simple_product' , self::$settings['user_permissions'] ) ) {
			?>
				<a href="#" class="wfsm-product-type" data-type="simple"><?php esc_html_e( 'Simple', 'woocommerce-frontend-shop-manager' ); ?></a>
			<?php
			}

			if ( !in_array( 'create_grouped_product' , self::$settings['user_permissions'] ) ) {
			?>
				<a href="#" class="wfsm-product-type" data-type="grouped"><?php esc_html_e( 'Grouped', 'woocommerce-frontend-shop-manager' ); ?></a>
			<?php
			}

			if ( !in_array( 'create_external_product' , self::$settings['user_permissions'] ) ) {
			?>
				<a href="#" class="wfsm-product-type" data-type="external"><?php esc_html_e( 'External', 'woocommerce-frontend-shop-manager' ); ?></a>
			<?php
			}

			if ( !in_array( 'create_variable_product' , self::$settings['user_permissions'] ) ) {
			?>
				<a href="#" class="wfsm-product-type" data-type="variable"><?php esc_html_e( 'Variable', 'woocommerce-frontend-shop-manager' ); ?></a>
			<?php
			}

			if ( !in_array( 'create_custom_product' , self::$settings['user_permissions'] ) ) {
				$curr_terms = get_terms( 'product_type');
				foreach ( $curr_terms as $k => $v ) {
					if ( !in_array( $v->slug, array( 'simple', 'grouped', 'external', 'variable' ) ) ) {
					?>
						<a href="#" class="wfsm-product-type"  data-type="<?php echo esc_attr( $v->slug ); ?>"><?php echo ucfirst( esc_html( $v->name ) ); ?></a>
					<?php
					}
				}
			}
		?>
			</div>
		</div>
	<?php
	}

	function wfsm_add_product_lite() {

		if ( !is_woocommerce() ) {
			return;
		}

		$buttons_class = !in_array( 'backend_buttons' , self::$settings['user_permissions'] ) ? '' : ' wfsm-backend-side-disabled'; // OK

	?>
		<div class="wfsm-buttons wfsm-side-buttons<?php echo esc_attr( $buttons_class ); ?>">
			<a href="#" class="wfsm-button wfsm-add-product" title="<?php esc_html_e( 'Add New Product', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-activate"></i></a>
		<?php
			if ( !in_array( 'backend_buttons' , self::$settings['user_permissions'] ) ) {
		?>
			<a href="<?php echo esc_url( admin_url( 'post.php?action=edit&post=' ) ); ?>" class="wfsm-button wfsm-edit" title="<?php esc_html_e( 'Edit product in the backend', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-edit"></i></a>
		<?php
			}
		?>
			<a href="#" class="wfsm-button wfsm-save" title="<?php esc_html_e( 'Save changes', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-save"></i></a>
			<a href="#" class="wfsm-button wfsm-discard" title="<?php esc_html_e( 'Discard changes', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-discard"></i></a>
		</div>
	<?php
	}


	function wfsm_delete_product() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset($_POST) && isset( $_POST['wfsm_id'] ) ) {
			$curr_post_id = intval( stripslashes( $_POST['wfsm_id'] ) );
			if ( get_post_status( $curr_post_id ) === false ) {
				die( 'Error!' );
				exit;
			}
		}
		else {
			die( 'Error!' );
			exit;
		}

		$curr_post_author = self::wfsm_check_premissions( $curr_post_id );

		if ( $curr_post_author === false ) {
			die( 'Error!' );
			exit;
		}

		wp_delete_post($curr_post_id);

		die('1');
		exit;

	}

	function wfsm_content() {

		global $post, $woocommerce_loop, $wfsm_global;

		if ( !isset( $wfsm_global['init'] ) ) {
			$wfsm_global['init'] = true;
		}

		$curr_id = absint( ( class_exists('SitePress') ? self::wfsm_wpml_get_id() : $post->ID ) );

		if ( !isset( self::$settings['admin_mode'] ) && absint( $post->post_author ) !== self::$settings['user']->ID ) {
			return;
		}

		$add_loop = 'single';

		if ( strpos( self::$settings['wc_settings_wfsm_single_action'], current_filter() ) === false ) {
			if ( isset( $woocommerce_loop['loop'] ) && isset( $woocommerce_loop['columns'] ) ) {
				$add_loop = $woocommerce_loop['loop'] . '|' . $woocommerce_loop['columns'];
			}
		}

		$buttons_class = ( !in_array( 'product_clone' , self::$settings['user_permissions'] ) ? '' : 'wfsm-clone-disabled' );
		$buttons_class .= ( !in_array( 'product_delete' , self::$settings['user_permissions'] ) ? '' : ' wfsm-delete-disabled' );
		$buttons_class .= ( !in_array( 'backend_buttons' , self::$settings['user_permissions'] ) ? '' : ' wfsm-backend-disabled' ); // OK

	?>
		<div class="wfsm-buttons wfsm-top-buttons <?php echo esc_attr( $buttons_class ); ?>" data-id="<?php echo esc_attr( $curr_id ); ?>" data-loop="<?php echo esc_attr( $add_loop ); ?>">
			<a href="#" class="wfsm-button wfsm-activate" title="<?php esc_html_e( 'Quick edit product', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-activate"></i></a>
		<?php
			if ( !in_array( 'backend_buttons' , self::$settings['user_permissions'] ) ) {
		?>
			<a href="<?php echo esc_url( admin_url( 'post.php?post=' . $curr_id . '&action=edit' ) ); ?>" class="wfsm-button wfsm-edit" title="<?php esc_html_e( 'Edit product in the backend', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-edit"></i></a>
		<?php
			}
			if ( !in_array( 'product_clone' , self::$settings['user_permissions'] ) ) {
		?>
			<a href="#" class="wfsm-button wfsm-clone" title="<?php esc_html_e( 'Duplicate product', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-clone"></i></a>
		<?php
			}
			if ( !in_array( 'product_delete' , self::$settings['user_permissions'] ) ) {
		?>
			<a href="#" class="wfsm-button wfsm-trash" title="<?php esc_html_e( 'Delete product', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-trash"></i></a>
		<?php
			}
		?>
			<a href="#" class="wfsm-button wfsm-save" title="<?php esc_html_e( 'Save changes', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-save"></i></a>
			<a href="#" class="wfsm-button wfsm-discard" title="<?php esc_html_e( 'Discard changes', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-discard"></i></a>
			<span class="wfsm-show-post-status">
				<span>
				<?php
					switch ( $post_status = get_post_status( $curr_id ) ) :
					case 'publish' :
						esc_html_e( 'Published', 'woocommerce-frontend-shop-manager' );
					break;
					case 'draft' :
						esc_html_e( 'Draft', 'woocommerce-frontend-shop-manager' );
					break;
					case 'pending' :
						esc_html_e( 'Pending', 'woocommerce-frontend-shop-manager' );
					break;
					default :
						echo esc_html( $post_status );
					break;
					endswitch;
				?>
				</span>
			</span>
			<span class="wfsm-editing">
				<img width="64" height="64" src="<?php echo esc_url( Wfsm()->plugin_url() . '/assets/images/editing.png' ); ?>" />
				<small>
					<?php esc_html_e( 'Currently Editing', 'woocommerce-frontend-shop-manager' ) ; ?><br/>
					<?php esc_html_e( 'Tap to Save', 'woocommerce-frontend-shop-manager' ) ; ?>
				</small>
			</span>
		</div>
	<?php

	}

	function wfsm_add_product_respond() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		$user_id = get_current_user_id();

		if ( self::$settings['max_products'] !== '' && intval( self::$settings['max_products'] ) > 0 ) {
			$product_count = count_user_posts( $user_id , 'product' );
			if ( $product_count >= self::$settings['max_products'] ) {
				die(0);
				exit;
			}
		}

		$curr_create = array(
			'post_title'     => esc_html__( 'New Product', 'woocommerce-frontend-shop-manager' ),
			'post_content'   => '',
			'post_name'      => 'new-product',
			'post_status'    => get_option( 'wc_settings_wfsm_create_status', 'pending' ),
			'post_type'      => 'product',
			'comment_status' => get_option('default_comment_status'),
			'ping_status'    => get_option('default_ping_status'),
			'post_author'    => $user_id
		);

		$curr_dummy = wp_insert_post( $curr_create );

		$product_type = empty( $_POST['wfsm_type'] ) ? 'simple' : sanitize_title( stripslashes( $_POST['wfsm_type'] ) );

		wp_set_object_terms( $curr_dummy, $product_type, 'product_type' );
		update_post_meta( $curr_dummy, '_visibility', 'visible' );
		update_post_meta( $curr_dummy, '_sku', '' );
		update_post_meta( $curr_dummy, '_stock_status', 'instock' );
		update_post_meta( $curr_dummy, '_total_sales', '0' );

		$is_virtual = get_option( 'wc_settings_wfsm_create_virtual', 'no' ) == 'yes' ? 'yes' : 'no';
		update_post_meta( $curr_dummy, '_virtual', $is_virtual );

		$is_downloadable = get_option( 'wc_settings_wfsm_create_downloadable', 'no' ) == 'yes' ? 'yes' : 'no';
		update_post_meta( $curr_dummy, '_downloadable', $is_downloadable );

		update_post_meta( $curr_dummy, '_featured', 'no' );

		die( (string) $curr_dummy );
		exit;
	}

	function wfsm_respond() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset($_POST) && isset( $_POST['wfsm_id'] ) ) {
			$curr_post_id = absint( stripslashes( $_POST['wfsm_id'] ) );
			if ( get_post_status( $curr_post_id ) === false ) {
				die( 'Error!' );
				exit;
			}
		}
		else {
			die( 'Error!' );
			exit;
		}

		$curr_post_author = self::wfsm_check_premissions( $curr_post_id );

		if ( $curr_post_author === false ) {
			die( 'Error!' );
			exit;
		}

		global $product;

		$product = wc_get_product( $curr_post_id );

		if ( $product->is_type( 'simple' ) ) {
			$product_type_class = ' wfsm-simple-product';
			$product_information = esc_html__( 'Simple Product', 'woocommerce-frontend-shop-manager' ) . '<br/> #ID ' . $curr_post_id;
		}
		else if ( $product->is_type( 'variable' ) ) {
			$product_type_class = ' wfsm-variable-product';
			$product_information = esc_html__( 'Variable Product', 'woocommerce-frontend-shop-manager' ) . '<br/> #ID ' . $curr_post_id;
		}
		else if ( $product->is_type( 'external' ) ) {
			$product_type_class = ' wfsm-external-product';
			$product_information = esc_html__( 'External Product', 'woocommerce-frontend-shop-manager' ) . '<br/> #ID ' . $curr_post_id;
		}
		else if ( $product->is_type( 'grouped' ) ) {
			$product_type_class = ' wfsm-grouped-product';
			$product_information = esc_html__( 'Grouped Product', 'woocommerce-frontend-shop-manager' ) . '<br/> #ID ' . $curr_post_id;
		}
		else {
			$product_type_class = ' wfsm-' . $product->get_type() . '-product';
			$product_information = esc_html__( 'Product', 'woocommerce-frontend-shop-manager' ) . ' #ID ' . $curr_post_id;
		}

		$buttons_class = !in_array( 'backend_buttons' , self::$settings['user_permissions'] ) ? '' : ' wfsm-backend-side-disabled'; // OK

		ob_start();

	?>
		<div class="wfsm-quick-editor">
			<div class="wfsm-screen<?php echo esc_attr( $product_type_class ); ?>">
				<div class="wfsm-controls<?php echo esc_attr( $buttons_class ); ?>">
					<div class="wfsm-about">
				<?php
					if ( self::$settings['mode'] == 'wfsm_mode_user' ) {
						global $current_user; get_currentuserinfo();
						echo get_avatar( $current_user->user_email, 100 ); ?>
						<?php echo esc_html( $current_user->user_login ) . ', ' . esc_html__('welcome back!', 'woocommerce-frontend-shop-manager' ); ?>
						<small><?php echo wp_kses_post( $product_information ); ?></small>
					<?php
					}
					else {
						if ( self::$settings['logo'] == '' ) {
					?>
						<img width="50" height="50" src="<?php echo Wfsm()->plugin_url() . '/assets/images/about.png'; ?>" />
					<?php
						}
						else {
					?>
						<img width="50" height="50" src="<?php echo esc_url( self::$settings['logo'] ); ?>" />
					<?php
						}
					?>
						<?php bloginfo('name'); ?>
						<small><?php echo wp_kses_post( $product_information ); ?></small>
					<?php
					}
				?>
					</div>
					<span class="wfsm-expand"><i class="wfsmico-expand"></i></span>
					<span class="wfsm-contract"><i class="wfsmico-contract"></i></span>
				<?php
					if ( !in_array( 'backend_buttons' , self::$settings['user_permissions'] ) ) {
				?>
					<span class="wfsm-side-edit"><i class="wfsmico-edit"></i></span>
				<?php
					}
				?>
					<span class="wfsm-side-save"><i class="wfsmico-save"></i></span>
					<span class="wfsm-side-discard"><i class="wfsmico-discard"></i></span>
					<div class="wfsm-clear"></div>
				</div>
				<span class="wfsm-headline wfsm-headline-content"><?php esc_html_e( 'Product Content', 'woocommerce-frontend-shop-manager' ); ?></span>
				<div class="wfsm-group wfsm-group-content">
				<?php
					if ( !in_array( 'product_status' , self::$settings['user_permissions'] ) ) {
				?>
					<label for="wfsm-product-status" class="wfsm-label-status">
					<?php
						$wfsm_selected = ( ( $post_status = get_post_status( $curr_post_id ) ) ? $post_status : '' );
					?>
						<span><?php esc_html_e( 'Product Status', 'woocommerce-frontend-shop-manager' ); ?></span>
						<select id="wfsm-product-status" name="wfsm-product-status" class="wfsm-collect-data">
						<?php
							$wfsm_select_options = apply_filters( 'wfsm_edit_post_status', array(
								'publish' => esc_html__( 'Published', 'woocommerce-frontend-shop-manager' ),
								'draft'   => esc_html__( 'Draft', 'woocommerce-frontend-shop-manager' ),
								'pending' => esc_html__( 'Pending', 'woocommerce-frontend-shop-manager' ),
								'trash'   => esc_html__( 'Trash', 'woocommerce-frontend-shop-manager' )
							) );
							foreach ( $wfsm_select_options as $wk => $wv ) {
						?>
								<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
						<?php
							}
						?>
						</select>
					</label>
				<?php
					}
					if ( !in_array( 'product_feature' , self::$settings['user_permissions'] ) ) {

						$is_featured = ( has_term( 'featured', 'product_visibility', $curr_post_id ) ? 'yes' : 'no' ); // OK
	
					?>
						<label for="wfsm-featured" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $is_featured ); ?>">
							<span class="wfsm-show-yes"><?php esc_html_e( 'Product is Featured', 'woocommerce-frontend-shop-manager' ); ?></span>
							<span class="wfsm-show-no"><?php esc_html_e( 'Product is not Featured', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-featured" name="wfsm-featured" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $is_featured ); ?>"/>
						</label>
				<?php
					}
					if ( !in_array( 'product_name' , self::$settings['user_permissions'] ) ) {
				?>
					<label for="wfsm-product-name">
						<span><?php esc_html_e( 'Product Name', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-product-name" name="wfsm-product-name" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( get_the_title( $curr_post_id ) ); ?>"/>
					</label>
				<?php
					}
					if ( !in_array( 'product_slug' , self::$settings['user_permissions'] ) ) {
				?>
					<label for="wfsm-product-slug">
						<span><?php esc_html_e( 'Product Slug', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-product-slug" name="wfsm-product-slug" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo self::utf8_urldecode( $product->get_slug() ); ?>"/>
					</label>
				<?php
					}
					if ( !in_array( 'product_content' , self::$settings['user_permissions'] ) ) {
				?>
					<span class="wfsm-dummy-title"><?php esc_html_e( 'Edit Product', 'woocommerce-frontend-shop-manager' ); ?></span>
					<a href="#" class="wfms-plain-button wfsm-edit-content"><?php esc_html_e( 'Product Content', 'woocommerce-frontend-shop-manager' ); ?></a>
					<a href="#" class="wfms-plain-button wfsm-edit-desc"><?php esc_html_e( 'Product Description', 'woocommerce-frontend-shop-manager' ); ?></a>
				<?php
					}
					if ( !in_array( 'product_featured_image' , self::$settings['user_permissions'] ) ) {
				?>
					<span class="wfsm-dummy-title"><?php esc_html_e( 'Featured Image', 'woocommerce-frontend-shop-manager' ); ?></span>
					<label for="wfsm-featured-image" class="wfsm-featured-image">
						<a href="#" class="wfsm-featured-image-trigger">
						<?php
							if ( has_post_thumbnail( $curr_post_id ) ) {
								$curr_image = wp_get_attachment_image_src( $curr_image_id = get_post_thumbnail_id( $curr_post_id ), 'thumbnail' );
							?>
								<img width="64" height="64" src="<?php echo esc_url( $curr_image[0] ); ?>" />
							<?php
							}
							else {
								$curr_image_id = 0;
							?>
								<img width="64" height="64" src="<?php echo esc_url( Wfsm()->plugin_url() . '/assets/images/placeholder.gif' ); ?>" />
						<?php
							}
						?>
						</a>
						<input id="wfsm-featured-image" name="wfsm-featured-image" class="wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $curr_image_id ); ?>" />
					</label>
					<div class="wfsm-featured-image-controls">
						<a href="#" class="wfsm-editor-button wfsm-change-image"><?php esc_html_e( 'Change Image', 'woocommerce-frontend-shop-manager' ); ?></a>
						<a href="#" class="wfsm-editor-button wfsm-remove-image"><?php esc_html_e( 'Discard Image', 'woocommerce-frontend-shop-manager' ); ?></a>
					</div>
					<div class="wfsm-clear"></div>
				<?php
					}

					if ( !in_array( 'product_gallery' , self::$settings['user_permissions'] ) ) {
						$product_gallery = ( $gallery = get_post_meta( $curr_post_id, '_product_image_gallery', true ) ) ? $gallery : '';
					?>
						<span class="wfsm-dummy-title"><?php esc_html_e( 'Product Gallery', 'woocommerce-frontend-shop-manager' ); ?></span>
						<div class="wfsm-product-gallery-images">
						<?php
							$curr_gallery = ( strpos( $product_gallery , ',' ) !== false ? explode( ',', $product_gallery ) : array( $product_gallery ) );
							foreach( $curr_gallery as $img_id ) {
								if ( $img_id == '' ) continue;
								$curr_image = wp_get_attachment_image_src( $img_id, 'thumbnail' );
							?>
								<span class="wfsm-product-gallery-image" data-id="<?php echo esc_attr( $img_id ); ?>">
									<img width="64" height="64" src="<?php echo esc_url( $curr_image[0] ); ?>" />
									<a href="#" class="wfsm-remove-gallery-image"><i class="wfsmico-discard"></i></a>
								</span>
						<?php
							}
						?>
							<div class="wfsm-clear"></div>
						</div>
						<label for="wfsm-product-gallery" class="wfsm-product-gallery">
							<a href="#" class="wfsm-editor-button wfsm-add-gallery-image"><?php esc_html_e( 'Add Image', 'woocommerce-frontend-shop-manager' ); ?></a>
							<select id="wfsm-product-gallery" name="wfsm-product-gallery" class="wfsm-reset-this wfsm-collect-data" multiple="multiple">
						<?php
								foreach( $curr_gallery as $img_id ) {
							?>
									<option value="<?php echo esc_attr( $img_id ); ?>" selected="selected"><?php echo esc_html( $img_id ); ?></option>
							<?php
								}
						?>
							</select>
						</label>
					<?php
					}
				?>
				</div>
				<span class="wfsm-headline wfsm-headline-data"><?php esc_html_e( 'Product Data', 'woocommerce-frontend-shop-manager' ); ?></span>
				<div class="wfsm-group wfsm-group-data">
				<?php
					if ( !in_array( 'external_product_url' , self::$settings['user_permissions'] ) && $product->is_type( 'external' ) ) {
						$product_http = ( $product_http_meta = get_post_meta( $curr_post_id, '_product_url', true ) ) ? $product_http_meta : '';
				?>
						<label for="wfsm-product-http">
							<span><?php esc_html_e( 'Product External URL', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-product-http" name="wfsm-product-http" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_url( $product_http ); ?>"/>
						</label>
				<?php
					}
					if ( !in_array( 'external_button_text' , self::$settings['user_permissions'] ) && $product->is_type( 'external' ) ) {
						$product_button = ( $product_button_text = get_post_meta( $curr_post_id, '_button_text', true ) ) ? $product_button_text : '';
				?>
						<label for="wfsm-button-text">
							<span><?php esc_html_e( 'Product Button Text', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-button-text" name="wfsm-button-text" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_button ); ?>"/>
						</label>
				<?php
					}
					if ( $product->is_type( 'simple' ) ) {
						if ( !in_array( 'product_virtual' , self::$settings['user_permissions'] ) ) {
							$is_virtual = ( $virtual = get_post_meta( $curr_post_id, '_virtual', true ) ) ? $virtual : 'no';
						?>
							<label for="wfsm-virtual" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $is_virtual ); ?>" data-linked="shipping">
								<span class="wfsm-show-yes"><?php esc_html_e( 'Product is Virtual', 'woocommerce-frontend-shop-manager' ); ?></span>
								<span class="wfsm-show-no"><?php esc_html_e( 'Product is not Virtual', 'woocommerce-frontend-shop-manager' ); ?></span>
								<input id="wfsm-virtual" name="wfsm-virtual" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $is_virtual ); ?>"/>
							</label>
						<?php
						}
						if ( !in_array( 'product_downloadable' , self::$settings['user_permissions'] ) ) {
							$is_downloadable = ( $downloadable = get_post_meta( $curr_post_id, '_downloadable', true ) ) ? $downloadable : 'no';
						?>
							<label for="wfsm-downloadable" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $is_downloadable ); ?>" data-linked="downloads">
								<span class="wfsm-show-yes"><?php esc_html_e( 'Product is Downloadable', 'woocommerce-frontend-shop-manager' ); ?></span>
								<span class="wfsm-show-no"><?php esc_html_e( 'Product is not Downloadable', 'woocommerce-frontend-shop-manager' ); ?></span>
								<input id="wfsm-downloadable" name="wfsm-downloadable" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $is_downloadable ); ?>"/>
							</label>
						<?php
						}
					}
					if ( !in_array( 'product_sku' , self::$settings['user_permissions'] ) && wc_product_sku_enabled() && !$product->is_type( 'grouped' ) ) {
				?>
					<label for="wfsm-sku">
						<span><?php esc_html_e( 'SKU', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-sku" name="wfsm-sku" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product->get_sku() ); ?>" />
					</label>
				<?php
					}
					if ( !in_array( 'product_prices' , self::$settings['user_permissions'] ) && !$product->is_type( 'variable' ) && !$product->is_type( 'grouped' ) ) {
				?>
					<label for="wfsm-regular-price" class="wfsm-label-half wfsm-label-first">
						<span><?php esc_html_e( 'Regular Price', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-regular-price" name="wfsm-regular-price" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product->get_regular_price() ); ?>"/>
					</label>
					<label for="wfsm-sale-price" class="wfsm-label-half">
						<span><?php esc_html_e( 'Sale Price', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-sale-price" name="wfsm-sale-price" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product->get_sale_price() ); ?>"/>
					</label>
					<div class="wfsm-clear"></div>
				<?php
					}
					if ( !in_array( 'product_taxes' , self::$settings['user_permissions'] ) && !$product->is_type( 'grouped' ) ) {

						$tax_status = array(
							'taxable' => esc_html__( 'Taxable', 'woocommerce-frontend-shop-manager' ),
							'shipping' => esc_html__( 'Shipping', 'woocommerce-frontend-shop-manager' ),
							'class' => esc_html__( 'None', 'woocommerce-frontend-shop-manager' )
						);

						if ( !empty( $tax_status ) ) {
						?>
							<label for="wfsm-tax-status" class="wfsm-selectize">
							<?php
								$wfsm_selected = ( ( $status = get_post_meta( $curr_post_id, '_tax_status', true ) ) !== '' ? $status : '' );
							?>
								<span><?php esc_html_e( 'Tax Status', 'woocommerce-frontend-shop-manager' ); ?></span>
								<select id="wfsm-tax-status" name="wfsm-tax-status" class="wfsm-collect-data">
								<?php
									foreach ( $tax_status as $wk => $wv ) {
								?>
										<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
								<?php
									}
								?>
								</select>
							</label>
						<?php
						}

						$tax_classes = WC_Tax::get_tax_classes();
						$classes_options = array();
						$classes_options[''] = esc_html__( 'Standard', 'woocommerce-frontend-shop-manager' );

						if ( $tax_classes ) {
							foreach ( $tax_classes as $class ) {
								$classes_options[ sanitize_title( $class ) ] = esc_html( $class );
							}
						}

						if ( !empty( $classes_options ) ) {
						?>
							<label for="wfsm-tax-class" class="wfsm-selectize">
							<?php
								$wfsm_selected = ( ( $class = get_post_meta( $curr_post_id, '_tax_class', true ) ) !== '' ? $class : '' );
							?>
								<span><?php esc_html_e( 'Tax Class', 'woocommerce-frontend-shop-manager' ); ?></span>
								<select id="wfsm-tax-class" name="wfsm-tax-class" class="wfsm-collect-data">
								<?php
									foreach ( $classes_options as $wk => $wv ) {
								?>
										<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
								<?php
									}
								?>
								</select>
							</label>
						<?php
						}

					}

					if ( !in_array( 'product_sold_individually' , self::$settings['user_permissions'] ) && !$product->is_type( 'external' ) && !$product->is_type( 'grouped' ) ) {
						$sold_individually = ( $individually = get_post_meta( $curr_post_id, '_sold_individually', true ) ) ? $individually : 'no';
					?>
						<label for="wfsm-sold-individually" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $sold_individually ); ?>">
							<span class="wfsm-show-yes"><?php esc_html_e( 'Product is Sold Individually', 'woocommerce-frontend-shop-manager' ); ?></span>
							<span class="wfsm-show-no"><?php esc_html_e( 'Product is not Sold Individually', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-sold-individually" name="wfsm-sold-individually" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $sold_individually ); ?>"/>
						</label>
					<?php
					}

					$option_manage_stock = get_option( 'woocommerce_manage_stock' );
					if ( 'yes' == $option_manage_stock && !in_array( 'product_stock' , self::$settings['user_permissions'] ) && !$product->is_type( 'external' ) && !$product->is_type( 'grouped' ) ) {
						if ( !$product->is_type( 'variable' ) ) {
							$in_stock_status = ( $stock = get_post_meta( $curr_post_id, '_stock_status', true ) ) ? $stock : 'instock';
						?>
								<label for="wfsm-product-stock" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $in_stock_status ); ?>">
									<span class="wfsm-show-instock"><?php esc_html_e( 'Product is In Stock', 'woocommerce-frontend-shop-manager' ); ?></span>
									<span class="wfsm-show-outofstock"><?php esc_html_e( 'Product is currently Out of Stock', 'woocommerce-frontend-shop-manager' ); ?></span>
									<input id="wfsm-product-stock" name="wfsm-product-stock" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $in_stock_status ); ?>"/>
								</label>
							<?php
						}
						$wfsm_class = ( ( get_post_meta( $curr_post_id, '_manage_stock', true ) ) == 'yes' ? ' wfsm-visible' : ' wfsm-hidden' ); // OK
					?>
						<div class="wfsm-manage-stock-quantity<?php echo esc_attr( $wfsm_class ); ?>">
							<label for="wfsm-stock-quantity" class="wfsm-label-quantity">
								<span><?php esc_html_e( 'Stock Quantity', 'woocommerce-frontend-shop-manager' ); ?></span>
							<?php
								$stock_count = get_post_meta( $curr_post_id, '_stock', true );
							?>
								<input id="wfsm-stock-quantity" name="wfsm-stock-quantity" class="wfsm-reset-this wfsm-collect-data" type="number" value="<?php echo esc_attr( wc_stock_amount( $stock_count ) ); ?>" />
							</label>
							<label for="wfsm-backorders" class="wfsm-selectize">
							<?php
								$wfsm_selected = ( ( $backorders = get_post_meta( $curr_post_id, '_backorders', true ) ) ? $backorders : '' );
							?>
								<span><?php esc_html_e( 'Allow Backorders', 'woocommerce-frontend-shop-manager' ); ?></span>
								<select id="wfsm-backorders" name="wfsm-backorders" class="wfsm-collect-data">
								<?php
									$wfsm_select_options = array(
										'no'     => esc_html__( 'Do not allow', 'woocommerce-frontend-shop-manager' ),
										'notify' => esc_html__( 'Allow, but notify customer', 'woocommerce-frontend-shop-manager' ),
										'yes'    => esc_html__( 'Allow', 'woocommerce-frontend-shop-manager' )
									);
									foreach ( $wfsm_select_options as $wk => $wv ) {
								?>
										<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
								<?php
									}
								?>
								</select>
							</label>
						</div>
					<?php
						$wfsm_button_class = ( $wfsm_class == ' wfsm-visible' ? ' wfsm-active' : '' ); // OK
					?>
						<a href="#" class="wfsm-editor-button wfsm-manage-stock-quantity<?php echo esc_attr( $wfsm_button_class ); ?>"><?php esc_html_e( 'Manage Stock', 'woocommerce-frontend-shop-manager' ); ?></a>
				<?php
					}
					if ( !in_array( 'product_schedule_sale' , self::$settings['user_permissions'] ) && !$product->is_type( 'variable' ) && !$product->is_type( 'grouped' ) ) {

						$sale_price_dates_from = ( $date_from = get_post_meta( $curr_post_id, '_sale_price_dates_from', true ) ) ? date_i18n( 'Y-m-d', $date_from ) : '';
						$sale_price_dates_to = ( $date_to = get_post_meta( $curr_post_id, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date_to ) : '';

						$wfsm_class = ( $sale_price_dates_from !== '' || $sale_price_dates_to !== '' ? ' wfsm-visible' : ' wfsm-hidden' ); // OK
					?>
						<div class="wfsm-schedule-sale<?php echo esc_attr( $wfsm_class ); ?>">
							<label for="wfsm-schedule-sale-start" class="wfsm-label-half wfsm-label-first">
								<span><?php esc_html_e( 'Start Sale', 'woocommerce-frontend-shop-manager' ); ?></span>
								<input id="wfsm-schedule-sale-start" name="wfsm-schedule-sale-start" class="wfsm-reset-this wfsm-date-picker wfsm-collect-data" type="text" value="<?php echo esc_attr( $sale_price_dates_from ); ?>" placeholder="<?php esc_html_e( 'From&hellip; YYYY-MM-DD', 'woocommerce-frontend-shop-manager' ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" />
							</label>
							<label for="wfsm-schedule-sale-end" class="wfsm-label-half">
								<span><?php esc_html_e( 'End Sale', 'woocommerce-frontend-shop-manager' ); ?></span>
								<input id="wfsm-schedule-sale-end" name="wfsm-schedule-sale-end" class="wfsm-reset-this wfsm-date-picker wfsm-collect-data" type="text" value="<?php echo esc_attr( $sale_price_dates_to ); ?>" placeholder="<?php esc_html_e( 'To&hellip; YYYY-MM-DD', 'woocommerce-frontend-shop-manager' ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" />
							</label>
							<div class="wfsm-clear"></div>
							<script type="text/javascript">
								(function($){
									"use strict";
									var curr_dates = $('#wfsm-schedule-sale-start, #wfsm-schedule-sale-end').datepicker( {
										dateFormat: 'yy/mm/dd',
										defaultDate: "+1w",
										minDate: new Date(),
										onSelect: function(curr_selected) {
											var option = this.id == "wfsm-schedule-sale-start" ? "minDate" : "maxDate",
											instance = $(this).data("datepicker"),
											date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, curr_selected, instance.settings);
											curr_dates.not(this).datepicker("option", option, date);
										}
									} );
								})(jQuery);
							</script>
						</div>
					<?php
						$wfsm_button_class = ( $wfsm_class == ' wfsm-visible' ? ' wfsm-active' : '' ); // OK
					?>
						<a href="#" class="wfsm-editor-button wfsm-schedule-sale<?php echo esc_attr( $wfsm_button_class ); ?>"><?php esc_html_e( 'Schedule Sale', 'woocommerce-frontend-shop-manager' ); ?></a>
				<?php
					}

					if ( !in_array( 'product_grouping' , self::$settings['user_permissions'] ) ) {

						$post_parents = array();
						$post_parents[''] = esc_html__( 'Choose a grouped product&hellip;', 'woocommerce-frontend-shop-manager' );

						if ( $grouped_term = get_term_by( 'slug', 'grouped', 'product_type' ) ) {

							$posts_in = array_unique( (array) get_objects_in_term( $grouped_term->term_id, 'product_type' ) );

							if ( sizeof( $posts_in ) > 0 ) {

								$args = array(
									'post_type'        => 'product',
									'post_status'      => 'any',
									'numberposts'      => -1,
									'orderby'          => 'title',
									'order'            => 'asc',
									'post_parent'      => 0,
									'suppress_filters' => 0,
									'include'          => $posts_in,
								);

								$grouped_products = get_posts( $args );

								if ( $grouped_products ) {

									foreach ( $grouped_products as $sel_product ) {

										if ( $sel_product->ID == $curr_post_id ) {
											continue;
										}

										$post_parents[ $sel_product->ID ] = $sel_product->post_title;
									}
								}
							}

						}
						if ( !empty($post_parents) ) {
						?>
							<label for="wfsm-grouping" class="wfsm-selectize">
							<?php
								$wfsm_selected = ( ( $grouping = wp_get_post_parent_id( $curr_post_id ) ) !== '' ? $grouping : '' );
							?>
								<span><?php esc_html_e( 'Grouping', 'woocommerce-frontend-shop-manager' ); ?></span>
								<select id="wfsm-grouping" name="wfsm-grouping" class="wfsm-collect-data">
								<?php
									foreach ( $post_parents as $wk => $wv ) {
								?>
										<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
								<?php
									}
								?>
								</select>
							</label>
						<?php
						}

					}

					if ( !in_array( 'product_note' , self::$settings['user_permissions'] ) ) {

						$purchase_note = ( $note = get_post_meta( $curr_post_id, '_purchase_note', true ) ) ? $note : '';
					?>
						<label for="wfsm-purchase-note" class="wfsm-label-textarea">
							<span><?php esc_html_e( 'Purchase Note', 'woocommerce-frontend-shop-manager' ); ?></span>
							<textarea id="wfsm-purchase-note" name="wfsm-purchase-note" class="wfsm-reset-this wfsm-collect-data"><?php echo wp_kses_post( $purchase_note ); ?></textarea>
						</label>
				<?php
					}
				?>
				</div>
			<?php
				if ( !in_array( 'product_shipping' , self::$settings['user_permissions'] ) && !$product->is_type( 'external' ) && !$product->is_type( 'grouped' ) ) {
				?>
					<span class="wfsm-headline wfsm-headline-shipping<?php echo !isset( $is_virtual ) && !$product->is_type( 'variable' ) || isset( $is_virtual ) && $is_virtual == 'yes' ? ' wfsm-group-notvisible' : ' wfsm-group-visible'; ?>"><?php esc_html_e( 'Product Shipping', 'woocommerce-frontend-shop-manager' ); ?></span>
					<div class="wfsm-group wfsm-group-shipping">
					
					<?php
						$product_weight = ( $weight = get_post_meta( $curr_post_id, '_weight', true ) ) ? $weight : '';
					?>
						<label for="wfsm-weight">
							<span><?php esc_html_e( 'Weight', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-weight" name="wfsm-weight" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_weight ); ?>" />
						</label>

					<?php
						$product_length = ( $length = get_post_meta( $curr_post_id, '_length', true ) ) ? $length : '';
					?>
						<label for="wfsm-length" class="wfsm-label-third wfsm-label-first">
							<span><?php esc_html_e( 'Length', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-length" name="wfsm-length" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_length ); ?>"/>
						</label>

					<?php
						$product_width = ( $width = get_post_meta( $curr_post_id, '_width', true ) ) ? $width : '';
					?>
						<label for="wfsm-width" class="wfsm-label-third">
							<span><?php esc_html_e( 'Width', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-width" name="wfsm-width" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_width ); ?>"/>
						</label>

					<?php
						$product_height = ( $height = get_post_meta( $curr_post_id, '_height', true ) ) ? $height : '';
					?>
						<label for="wfsm-height" class="wfsm-label-third">
							<span><?php esc_html_e( 'Height', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-height" name="wfsm-height" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_height ); ?>"/>
						</label>
						<div class="wfsm-clear"></div>


						<label for="wfsm-shipping-class" class="wfsm-selectize">
						<?php

							$shipping_classes = get_the_terms( $curr_post_id, 'product_shipping_class' );
							if ( $shipping_classes && ! is_wp_error( $shipping_classes ) ) {
								$current_shipping_class = current( $shipping_classes )->term_id;
							}
							else {
								$current_shipping_class = '';
							}

							$args = array(
								'taxonomy'         => 'product_shipping_class',
								'hide_empty'       => 0,
								'show_option_none' => esc_html__( 'No shipping class', 'woocommerce-frontend-shop-manager' ),
								'name'             => 'wfsm-shipping-class',
								'id'               => 'wfsm-shipping-class',
								'selected'         => $current_shipping_class,
								'class'            => 'wfsm-collect-data'
							);

						?>
							<span><?php esc_html_e( 'Shipping Class', 'woocommerce-frontend-shop-manager' ); ?></span>
							<?php wp_dropdown_categories( $args ); ?>
						</label>


					</div>
			<?php
				}
				if ( !in_array( 'product_downloads' , self::$settings['user_permissions'] ) && $product->is_type( 'simple' ) ) {
				?>
					<span class="wfsm-headline wfsm-headline-downloads<?php echo !isset( $is_downloadable ) ||  $is_downloadable == 'no' ? ' wfsm-group-notvisible' : ' wfsm-group-visible'; ?>"><?php esc_html_e( 'Product Downloads', 'woocommerce-frontend-shop-manager' ); ?></span>
					<div class="wfsm-group wfsm-group-downloads">
						<div class="wfsm-downloads-add-files">
						<?php
							$downloadable_files = get_post_meta( $curr_post_id, '_downloadable_files', true );
							if ( $downloadable_files ) {
								foreach ( $downloadable_files as $key => $file ) {
								?>
									<div class="wfsm-downloads-file">
										<a href="#" class="wfsm-downloads-move"><i class="wfsmico-move"></i></a>
										<span class="wfsm-downloads-file-name"><input type="text" placeholder="<?php esc_html_e( 'File Name', 'woocommerce-frontend-shop-manager' ); ?>" name="wfsm-file-names[]" value="<?php echo esc_attr( $file['name'] ); ?>" class="wfsm-collect-data" /></span>
										<span class="wfsm-downloads-file-url"><input type="text" placeholder="<?php esc_html_e( "http://", 'woocommerce-frontend-shop-manager' ); ?>" name="wfsm-file-urls[]" value="<?php echo esc_attr( $file['file'] ); ?>" class="wfsm-collect-data" /></span>
										<a href="#" class="wfsm-downloads-file-choose" data-choose="<?php esc_html_e( 'Choose file', 'woocommerce-frontend-shop-manager' ); ?>" data-update="<?php esc_html_e( 'Insert file URL', 'woocommerce-frontend-shop-manager' ); ?>"><?php esc_html_e( 'Choose File', 'woocommerce-frontend-shop-manager' ); ?></a>
										<a href="#" class="wfsm-downloads-file-discard"><i class="wfsmico-discard"></i></a>
									</div>
								<?php
								}
							}
						?>

						</div>
						<a href="#" class="wfms-plain-button wfsm-add-file"><?php esc_html_e( 'Add File', 'woocommerce-frontend-shop-manager' ); ?></a>

					<?php
						if ( !in_array( 'product_download_settings' , self::$settings['user_permissions'] ) ) {
							$product_limit = ( $limit = get_post_meta( $curr_post_id, '_download_limit', true ) ) ? $limit : '';
						?>
							<label for="wfsm-download-limit" class="wfsm-label">
								<span><?php esc_html_e( 'Download Limit', 'woocommerce-frontend-shop-manager' ); ?></span>
								<input id="wfsm-download-limit" name="wfsm-download-limit" class="wfsm-reset-this wfsm-collect-data" type="number" value="<?php echo esc_attr( $product_limit ); ?>"/>
							</label>

						<?php
							$product_expiry = ( $expiry = get_post_meta( $curr_post_id, '_download_expiry', true ) ) ? $expiry : '';
						?>
							<label for="wfsm-download-expiry" class="wfsm-label">
								<span><?php esc_html_e( 'Download Expiry', 'woocommerce-frontend-shop-manager' ); ?></span>
								<input id="wfsm-download-expiry" name="wfsm-download-expiry" class="wfsm-reset-this wfsm-collect-data" type="number" value="<?php echo esc_attr( $product_expiry ); ?>"/>
							</label>

						<?php
							$download_type = array(
								'' => esc_html__( 'Standard Product', 'woocommerce-frontend-shop-manager' ),
								'application' => esc_html__( 'Application/Software', 'woocommerce-frontend-shop-manager' ),
								'music' => esc_html__( 'Music', 'woocommerce-frontend-shop-manager' )
							);

							if ( !empty( $download_type ) ) {
							?>
								<label for="wfsm-download-type" class="wfsm-selectize">
								<?php
									$wfsm_selected = ( ( $curr_download_type = get_post_meta( $curr_post_id, '_tax_status', true ) ) !== '' ? $curr_download_type : '' );
								?>
									<span><?php esc_html_e( 'Download Type', 'woocommerce-frontend-shop-manager' ); ?></span>
									<select id="wfsm-download-type" name="wfsm-download-type" class="wfsm-collect-data">
									<?php
										foreach ( $download_type as $wk => $wv ) {
									?>
											<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
									<?php
										}
									?>
									</select>
								</label>
							<?php
							}
						}
					?>

					</div>
			<?php
				}
			?>
				<span class="wfsm-headline wfsm-headline-taxonomies"><?php esc_html_e( 'Product Taxnonomies and Terms', 'woocommerce-frontend-shop-manager' ); ?></span>
				<div class="wfsm-group wfsm-group-taxonomies">
				<?php
					if ( !in_array( 'product_cat' , self::$settings['user_permissions'] ) ) {
					?>
						<label for="wfsm-select-product_cat" class="wfsm-selectize">
							<span><?php esc_html_e( 'Product Categories', 'woocommerce-frontend-shop-manager' ); ?></span>
							<select id="wfsm-select-product_cat" name="wfsm-select-product_cat" class="wfsm-collect-data" multiple="multiple">
							<?php
								$product_cats = wp_get_post_terms( $curr_post_id, 'product_cat', array( 'fields' => 'slugs' ) );
								foreach( get_terms('product_cat','hide_empty=0') as $term ) {
									$wfsm_selected = in_array( $term->slug , $product_cats ) ? 'added' : 'notadded' ;
								?>
									<option class="si" <?php echo ( $wfsm_selected == 'added' ? ' selected="selected"' : '' ); ?> value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
								<?php
								}
							?>
							</select>
						</label>
					<?php
					}

					if ( !in_array( 'product_tag' , self::$settings['user_permissions'] ) ) {
					?>
						<label for="wfsm-select-product_tag" class="wfsm-selectize">
							<span><?php esc_html_e( 'Product Tags', 'woocommerce-frontend-shop-manager' ); ?></span>
							<select id="wfsm-select-product_tag" name="wfsm-select-product_tag" class="wfsm-collect-data" multiple="multiple">
							<?php
								$product_tags = wp_get_post_terms($curr_post_id, 'product_tag', array( 'fields' => 'slugs' ) );
								foreach( get_terms('product_tag','hide_empty=0') as $term ) {
									$wfsm_selected = in_array( $term->slug , $product_tags ) ? 'added' : 'notadded' ;
								?>
									<option <?php echo ( $wfsm_selected == 'added' ? ' selected="selected"' : '' ); ?> value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
								<?php
								}
							?>
							</select>
						</label>
					<?php
					}

					$product_taxonomies = get_object_taxonomies( 'product' );
					$product_taxonomies = array_diff( $product_taxonomies, apply_filters( 'wfsm_restricted_taxonomies', array( 'product_cat', 'product_tag', 'product_visibility', 'product_type', 'product_shipping_class' ) ) );

					if ( !in_array( 'product_taxonomies' , self::$settings['user_permissions'] ) ) {
						foreach( $product_taxonomies as $product_taxonomy ) {
							if ( substr( $product_taxonomy, 0, 3 ) == 'pa_' ) {
								continue;
							}

						?>
							<label for="wfsm-select-<?php echo esc_attr( $product_taxonomy ); ?>" class="wfsm-selectize">
								<span><?php echo ucfirst( wc_attribute_label( $product_taxonomy ) ); ?></span>
								<select id="wfsm-select-<?php echo esc_attr( $product_taxonomy ); ?>" name="wfsm-select-<?php echo esc_attr( $product_taxonomy ); ?>" class="wfsm-collect-data" multiple="multiple">
								<?php
									$product_tax = wp_get_post_terms($curr_post_id, $product_taxonomy, array( 'fields' => 'slugs' ) );
									foreach( get_terms($product_taxonomy,'hide_empty=0') as $term ) {
										$wfsm_selected = in_array( $term->slug , $product_tax ) ? 'added' : 'notadded' ;
									?>
										<option <?php echo ( $wfsm_selected == 'added' ? ' selected="selected"' : '' ); ?> value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
									<?php
									}
								?>
								</select>
							</label>
						<?php
						}

					}

					if ( !in_array( 'product_attributes' , self::$settings['user_permissions'] ) ) {

						$attribute_taxonomies = wc_get_attribute_taxonomies();
						$product_attributes = $product->get_attributes();

					?>
						<label for="wfsm-select-attributes" class="wfsm-selectize">
							<span><?php esc_html_e( 'Product Attributes', 'woocommerce-frontend-shop-manager' ); ?></span>
							<select id="wfsm-select-attributes" name="wfsm-select-attributes" class="wfsm-collect-data" multiple="multiple">
							<?php
								foreach ($attribute_taxonomies as $tax) {
									$tax_name_sanitized = sanitize_title( $tax->attribute_name );
									$wfsm_selected = array_key_exists( 'pa_' . $tax_name_sanitized , $product_attributes ) ? 'added' : 'notadded' ;
							?>
									<option value="<?php echo 'pa_' . $tax_name_sanitized;?>"<?php echo ( $wfsm_selected == 'added' ? ' selected="selected"' : '' ); ?>><?php echo wc_attribute_label( $tax->attribute_name ); ?></option>
							<?php
								}
							?>
							</select>
						</label>
					<?php
						$curr_atts = array();

						if ( !empty( $attribute_taxonomies ) && !is_wp_error( $attribute_taxonomies ) ){
							foreach ($attribute_taxonomies as $tax) {
								if ( !array_key_exists( 'pa_' . sanitize_title( $tax->attribute_name ), $product_attributes ) ) {
									continue;
								}
								$curr_name = sanitize_title($tax->attribute_name);
								$curr_paname = 'pa_' . $tax->attribute_name;
								$curr_paname_sanitized = esc_attr( 'pa_' . sanitize_title( $tax->attribute_name ) ); // OK
						?>
							<div class="wfsm-attribute-<?php echo esc_attr( $curr_paname_sanitized ); ?>">
								<label for="wfsm-select-<?php echo esc_attr( $curr_paname_sanitized ); ?>" class="wfsm-selectize">
									<span><?php echo esc_html__( 'Product', 'woocommerce-frontend-shop-manager' ) . ' ' . ucfirst( $tax->attribute_label); ?></span>
									<select id="wfsm-select-<?php echo esc_attr( $curr_paname_sanitized ); ?>" name="wfsm-select-<?php echo esc_attr( $curr_paname_sanitized ); ?>" class="wfsm-collect-data" multiple="multiple">
									<?php
										$product_atts = wp_get_post_terms($curr_post_id, $curr_paname, array( 'fields' => 'slugs' ) );
										foreach( get_terms($curr_paname,'hide_empty=0') as $term ) {
											$wfsm_selected = in_array( $term->slug , $product_atts ) ? 'added' : 'notadded' ;
										?>
											<option <?php echo ( $wfsm_selected == 'added' ? ' selected="selected"' : '' ); ?> value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
										<?php
										}
									?>
									</select>
								</label>
							<?php
								$curr_value = ( ( isset( $product_attributes[$curr_paname_sanitized]) && $product_attributes[$curr_paname_sanitized]['is_visible'] == 1 ) ? 'isvisible' : 'notvisible' );
							?>
								<label for="wfsm-visible-<?php echo esc_attr( $curr_paname_sanitized ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $curr_value ); ?>">
									<span class="wfsm-show-isvisible"><?php esc_html_e( 'Attribute is visible on product page', 'woocommerce-frontend-shop-manager' ); ?></span>
									<span class="wfsm-show-notvisible"><?php esc_html_e( 'Attribute is not visible on product page', 'woocommerce-frontend-shop-manager' ); ?></span>
									<input id="wfsm-visible-<?php echo esc_attr( $curr_paname_sanitized ); ?>" name="wfsm-visible-<?php echo esc_attr( $curr_paname_sanitized ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $curr_value ); ?>"/>
								</label>
							<?php
								if ( $product->is_type( 'variable' ) ) {
									$curr_value = ( ( isset( $product_attributes[$curr_paname_sanitized]) && $product_attributes[$curr_paname_sanitized]['is_variation'] == 1 ) ? 'isvariation' : 'notvariation' );
							?>
								<label for="wfsm-variation-<?php echo esc_attr( $curr_paname_sanitized ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $curr_value ); ?>">
									<span class="wfsm-show-isvariation"><?php esc_html_e( 'Attribute is used in variations', 'woocommerce-frontend-shop-manager' ); ?></span>
									<span class="wfsm-show-notvariation"><?php esc_html_e( 'Attribute is not used in variations', 'woocommerce-frontend-shop-manager' ); ?></span>
									<input id="wfsm-variation-<?php echo esc_attr( $curr_paname_sanitized ); ?>" name="wfsm-variation-<?php echo esc_attr( $curr_paname_sanitized ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $curr_value ); ?>"/>
								</label>
							<?php
								}
							?>
							</div>
						<?php
							}
						}
					}
			?>
				</div>
			<?php

				do_action( 'wfsm_after_default_settings' );

				$custom_settings = self::$settings['custom_settings'];

				if ( !empty( $custom_settings ) ) {

					foreach( $custom_settings as $k => $v ) {
						$name = esc_attr( sanitize_title( $v['name'] ) ); // OK

						if ( !in_array( $name, self::$settings['user_permissions'] ) ) {
						?>
							<span class="wfsm-headline wfsm-headline-<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $v['name'] ); ?></span>
							<div class="wfsm-group wfsm-group-<?php echo esc_attr( $name ); ?>">
								<?php
									for( $i = 0; $i < count( $v['type'] ); $i++ ) {
										$setting_name = esc_attr( sanitize_title( $v['setting-name'][$i] ) ); // OK

										switch( $v['type'][$i] ) {

											case 'checkbox' :
													if ( $v['key'][$i] == '' ) {
														$curr_value = '';
													}
													else {
														$curr_value = ( $value = get_post_meta( $curr_post_id, $v['key'][$i], true ) ) && !empty( $value ) ? $value : ( $v['default'][$i] == 'yes' ? 'yes' : 'no' );
													}
													if ( $curr_value == '' ) {
														$curr_value = $v['default'][$i] == 'yes' ? 'yes' : 'no';
													}

													$curr_options = array();

													if ( is_array( $v['options'][$i] ) ) {
														$curr_options = $v['options'][$i];
													}
													else if ( is_string( $v['options'][$i] ) && substr( $v['options'][$i], 0, 1 ) == '{' ) {
														$curr_options = json_decode( stripslashes( $v['options'][$i] ), true );
													}

													$chckbx_yes = $v['setting-name'][$i] . ' - ' . esc_html__( 'Enabled', 'woocommerce-frontend-shop-manager' );
													$chckbx_no = $v['setting-name'][$i] . ' - ' . esc_html__( 'Disabled', 'woocommerce-frontend-shop-manager' );
													if ( is_array( $curr_options ) && isset( $curr_options['yes'], $curr_options['no'] ) ) {
														$chckbx_yes = $curr_options['yes'];
														$chckbx_no = $curr_options['no'];
													}
												?>
													<label for="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $curr_value ); ?>">
														<span class="wfsm-show-yes"><?php echo esc_html( $chckbx_yes ); ?></span>
														<span class="wfsm-show-no"><?php echo esc_html( $chckbx_no ); ?></span>
														<input id="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" name="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $curr_value ); ?>"/>
													</label>
												<?php
											break;

											case 'select' :
												if ( $v['key'][$i] == '' ) {
													$curr_value = '';
												}
												else {
													$curr_value = ( $value = get_post_meta( $curr_post_id, $v['key'][$i], true ) ) && !empty( $value )  ? $value : $v['default'][$i];
												}

												$curr_options = array();
												if ( is_array( $v['options'][$i] ) ) {
													$curr_options = $v['options'][$i];
												}
												else if ( is_string( $v['options'][$i] ) && substr( $v['options'][$i], 0, 1 ) == '{' ) {
													$curr_options = json_decode( stripslashes( $v['options'][$i] ), true );
												}

												if ( is_array( $curr_options ) ) {
											?>
												<label for="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_html( $curr_value ); ?>">
													<span><?php echo esc_html( $v['setting-name'][$i] ); ?></span>
													<select id="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" name="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" class="wfsm-collect-data">
													<?php
														foreach ( $curr_options as $wk => $wv ) {
													?>
															<option value="<?php echo esc_html( $wk );?>"<?php echo ( $curr_value == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
													<?php
														}
													?>
													</select>
												</label>
											<?php
												}
											break;
											case 'textarea' :
													if ( $v['key'][$i] == '' ) {
														$curr_value = '';
													}
													else {
														$curr_value = ( $value = get_post_meta( $curr_post_id, $v['key'][$i], true ) ) && !empty( $value ) ? $value : $v['default'][$i];
													}
												?>
													<label for="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>">
														<span><?php echo esc_html( $v['setting-name'][$i] ); ?></span>
														<textarea id="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" name="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" class="wfsm-reset-this wfsm-collect-data"><?php echo wp_kses_post( $curr_value ); ?></textarea>
													</label>
												<?php
											break;
											case 'input' :
													if ( $v['key'][$i] == '' ) {
														$curr_value = '';
													}
													else {
														$curr_value = ( $value = get_post_meta( $curr_post_id, $v['key'][$i], true ) ) && !empty( $value ) ? $value : $v['default'][$i];
													}
												?>
													<label for="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>">
														<span><?php echo esc_html( $v['setting-name'][$i] ); ?></span>
														<input id="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" name="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $curr_value ); ?>"/>
													</label>
												<?php
											break;
											default :
												?>
													<label for="wfsm-cs-<?php echo esc_attr( $setting_name ); ?>">
														<span><?php echo esc_html( $v['setting-name'][$i] ); ?></span>
														<?php echo wp_kses_post( apply_filters( 'wfsm_custom_setting_' . $v['type'][$i], '', $curr_post_id ) ); ?>
													</label>
												<?php
											break;
										}
									}
								?>
							</div>
						<?php
						}
					}
				}

				do_action( 'wfsm_after_custom_settings' );

				if ( !in_array( 'variable_edit_variations' , self::$settings['user_permissions'] ) && $product->is_type( 'variable' ) ) {
					$available_variations = $product->get_available_variations();
				?>
					<div class="wfsm-variations">
				<?php
					$curr_variable_attributes = get_post_meta( $curr_post_id, '_product_attributes', true );

					foreach ( $available_variations as $var ) {

						$var['variation_id'] = intval( $var['variation_id'] ); // OK

						$curr_product[$var['variation_id']] = new WC_Product_Variation( $var['variation_id'] );
					?>
						<span class="wfsm-headline"><?php echo esc_html__( 'Product Variation #ID', 'woocommerce-frontend-shop-manager' ) . ' ' . intval( $var['variation_id'] ); ?><?php if ( !in_array( 'variable_delete' , self::$settings['user_permissions'] ) ) { ?><a href="#" class="wfsm-trash-variation" title="<?php esc_html_e( 'Delete variation', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-discard"></i></a><?php } ?></span>
						<div class="wfsm-variation" data-id="<?php echo intval( $var['variation_id'] ); ?>">
						<?php
							if ( !in_array( 'variable_product_attributes' , self::$settings['user_permissions'] ) ) {
							?>
								<div class="wfsm-variation-attributes">
								<?php
									foreach ( $curr_variable_attributes as $ak => $av ) {

										$curr_term = $av['name'];
										$curr_term_sanitized = esc_attr( sanitize_title( $curr_term ) ); //

										$curr_attributes = get_terms( $curr_term, array(
											'hide_empty' => 0
										) );

										$curr_product_atts = wp_get_post_terms($curr_post_id, $curr_term, array( 'fields' => 'slugs' ) );

										$variation_meta = get_post_meta( $var['variation_id'] );
										foreach ( $variation_meta as $key => $value ) {
											if ( false !== strpos( $key, 'attribute_' ) ) {
												$variation_data[ $key ] = $value;
											}
										}

									?>
										<label for="wfsm-attribute-<?php echo intval( $var['variation_id'] ); ?>-<?php echo esc_attr( $curr_term_sanitized ); ?>" class="wfsm-selectize">
									<?php
										$wfsm_selected = $variation_data['attribute_' . $curr_term_sanitized][0];
									?>
										<span><?php echo wc_attribute_label( $curr_term ); ?></span>
										<select id="wfsm-attribute-<?php echo intval( $var['variation_id'] ); ?>-<?php echo esc_attr( $curr_term_sanitized ); ?>" name="wfsm-attribute-<?php echo intval( $var['variation_id'] ); ?>-<?php echo esc_attr( $curr_term_sanitized ); ?>" class="wfsm-collect-data">
											<option value=""><?php echo esc_html__( 'Any', 'woocommerce-frontend-shop-manager' ) . ' ' . $curr_label . '...'; ?></option>
										<?php
											foreach ( $curr_attributes as $wk => $wv ) {
												if ( !in_array( $wv->slug, $curr_product_atts ) ) {
													continue;
												}

										?>
												<option value="<?php echo esc_attr( $wv->slug ); ?>"<?php echo ( $wfsm_selected == $wv->slug ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv->name ); ?></option>
										<?php
											}
										?>
										</select>
									</label>
								<?php
									}
								?>
								</div>
							<?php
							}

							if ( !in_array( 'product_featured_image' , self::$settings['user_permissions'] ) ) {
								?>
								<span class="wfsm-dummy-title"><?php esc_html_e( 'Featured Image', 'woocommerce-frontend-shop-manager' ); ?></span>
								<label for="wfsm-featured-image-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-featured-image">
									<a href="#" class="wfsm-featured-image-trigger">
									<?php
										if ( has_post_thumbnail( $var['variation_id'] ) ) {
											$curr_image = wp_get_attachment_image_src( $curr_image_id = get_post_thumbnail_id( $var['variation_id'] ), 'thumbnail' );
										?>
											<img width="64" height="64" src="<?php echo esc_url( $curr_image[0] ); ?>" />
										<?php
										}
										else {
											$curr_image_id = 0;
										?>
											<img width="64" height="64" src="<?php echo Wfsm()->plugin_url() . '/assets/images/placeholder.gif'; ?>" />
									<?php
										}
									?>
									</a>
									<input id="wfsm-featured-image-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-featured-image-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $curr_image_id ); ?>" />
								</label>
								<div class="wfsm-featured-image-controls">
									<a href="#" class="wfsm-editor-button wfsm-change-image"><?php esc_html_e( 'Change Image', 'woocommerce-frontend-shop-manager' ); ?></a>
									<a href="#" class="wfsm-editor-button wfsm-remove-image"><?php esc_html_e( 'Discard Image', 'woocommerce-frontend-shop-manager' ); ?></a>
								</div>
								<div class="wfsm-clear"></div>
						<?php
							}

							if ( !in_array( 'product_sku' , self::$settings['user_permissions'] ) && wc_product_sku_enabled() ) {
							?>
								<label for="wfsm-sku-<?php echo intval( $var['variation_id'] ); ?>">
									<span><?php esc_html_e( 'SKU', 'woocommerce-frontend-shop-manager' ); ?></span>
									<input id="wfsm-sku-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-sku-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $curr_product[$var['variation_id']]->get_sku() ); ?>" />
								</label>
							<?php
							}

							if ( !in_array( 'product_prices' , self::$settings['user_permissions'] ) ) {
							?>
								<label for="wfsm-regular-price-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-half wfsm-label-first">
									<span><?php esc_html_e( 'Regular Price', 'woocommerce-frontend-shop-manager' ); ?></span>
									<input id="wfsm-regular-price-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-regular-price-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr($curr_product[$var['variation_id']]->get_regular_price() ); ?>"/>
								</label>
								<label for="wfsm-sale-price-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-half">
									<span><?php esc_html_e( 'Sale Price', 'woocommerce-frontend-shop-manager' ); ?></span>
									<input id="wfsm-sale-price-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-sale-price-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr($curr_product[$var['variation_id']]->get_sale_price() ); ?>"/>
								</label>
								<div class="wfsm-clear"></div>
							<?php
							}

							if ( !in_array( 'product_stock' , self::$settings['user_permissions'] ) ) {
								$in_stock_status = ( $stock = get_post_meta( $var['variation_id'], '_stock_status', true ) ) ? $stock : 'instock';
							?>
								<label for="wfsm-product-stock-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $in_stock_status ); ?>">
									<span class="wfsm-show-instock"><?php esc_html_e( 'Product is In Stock', 'woocommerce-frontend-shop-manager' ); ?></span>
									<span class="wfsm-show-outofstock"><?php esc_html_e( 'Product is currently Out of Stock', 'woocommerce-frontend-shop-manager' ); ?></span>
									<input id="wfsm-product-stock-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-product-stock-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr($in_stock_status ); ?>"/>
								</label>
							<?php
								if ( 'yes' == $option_manage_stock ) {
									$wfsm_class = ( ( get_post_meta( $var['variation_id'], '_manage_stock', true ) ) == 'yes' ? ' wfsm-visible' : ' wfsm-hidden' ); // OK
								?>
									<div class="wfsm-manage-stock-quantity-<?php echo intval( $var['variation_id'] ); ?><?php echo esc_attr( $wfsm_class ); ?>">
										<label for="wfsm-stock-quantity-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-quantity">
											<span><?php esc_html_e( 'Stock Quantity', 'woocommerce-frontend-shop-manager' ); ?></span>
										<?php
											$stock_count = get_post_meta( $var['variation_id'], '_stock', true );
										?>
											<input id="wfsm-stock-quantity-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-stock-quantity-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="number" value="<?php echo esc_attr( wc_stock_amount( $stock_count ) ); ?>" />
										</label>
										<label for="wfsm-backorders-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-selectize">
										<?php
											$wfsm_selected = ( ( $backorders = get_post_meta( $var['variation_id'], '_backorders', true ) ) ? $backorders : '' );
										?>
											<span><?php esc_html_e( 'Allow Backorders', 'woocommerce-frontend-shop-manager' ); ?></span>
											<select id="wfsm-backorders-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-backorders-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-collect-data">
											<?php
												$wfsm_select_options = array(
													'no'     => esc_html__( 'Do not allow', 'woocommerce-frontend-shop-manager' ),
													'notify' => esc_html__( 'Allow, but notify customer', 'woocommerce-frontend-shop-manager' ),
													'yes'    => esc_html__( 'Allow', 'woocommerce-frontend-shop-manager' )
												);
												foreach ( $wfsm_select_options as $wk => $wv ) {
											?>
													<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
											<?php
												}
											?>
											</select>
										</label>
									</div>
								<?php
									$wfsm_button_class = ( $wfsm_class == ' wfsm-visible' ? ' wfsm-active' : '' ); // OK
								?>
									<a href="#" class="wfsm-editor-button wfsm-manage-stock-quantity-<?php echo intval( $var['variation_id'] ); ?><?php echo esc_attr( $wfsm_button_class ); ?>"><?php esc_html_e( 'Manage Stock', 'woocommerce-frontend-shop-manager' ); ?></a>
								<?php
								}
							}

							if ( !in_array( 'product_schedule_sale' , self::$settings['user_permissions'] ) ) {
								$sale_price_dates_from = ( $date = get_post_meta( $var['variation_id'], '_sale_price_dates_from', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
								$sale_price_dates_to = ( $date = get_post_meta( $var['variation_id'], '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';

								$wfsm_class = ( $sale_price_dates_from !== '' || $sale_price_dates_to !== '' ? ' wfsm-visible' : ' wfsm-hidden' ); // OK
							?>
								<div class="wfsm-schedule-sale<?php echo esc_attr( $wfsm_class ); ?>">
									<label for="wfsm-schedule-sale-start-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-half wfsm-label-first">
										<span><?php esc_html_e( 'Start Sale', 'woocommerce-frontend-shop-manager' ); ?></span>
										<input id="wfsm-schedule-sale-start-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-schedule-sale-start-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-date-picker wfsm-collect-data" type="text" value="<?php echo esc_attr( $sale_price_dates_from ); ?>" placeholder="<?php esc_html_e( 'From&hellip; YYYY-MM-DD', 'woocommerce-frontend-shop-manager' ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" />
									</label>
									<label for="wfsm-schedule-sale-end-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-half">
										<span><?php esc_html_e( 'End Sale', 'woocommerce-frontend-shop-manager' ); ?></span>
										<input id="wfsm-schedule-sale-end-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-schedule-sale-end-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-date-picker wfsm-collect-data" type="text" value="<?php echo esc_attr( $sale_price_dates_to ); ?>" placeholder="<?php esc_html_e( 'To&hellip; YYYY-MM-DD', 'woocommerce-frontend-shop-manager' ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" />
									</label>
									<div class="wfsm-clear"></div>
									<script type="text/javascript">
										(function($){
											"use strict";
											var curr_dates = $('#wfsm-schedule-sale-start-<?php echo intval( $var['variation_id'] ); ?>, #wfsm-schedule-sale-end-<?php echo intval( $var['variation_id'] ); ?>').datepicker( {
												dateFormat: 'yy/mm/dd',
												defaultDate: "+1w",
												minDate: new Date(),
												onSelect: function(curr_selected) {
													var option = this.id == "wfsm-schedule-sale-start-<?php echo intval( $var['variation_id'] ); ?>" ? "minDate" : "maxDate",
													instance = $(this).data("datepicker"),
													date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, curr_selected, instance.settings);
													curr_dates.not(this).datepicker("option", option, date);
												}
											} );
										})(jQuery);
									</script>
								</div>
							<?php
								$wfsm_button_class = ( $wfsm_class == ' wfsm-visible' ? ' wfsm-active' : '' ); // OK
							?>
								<a href="#" class="wfsm-editor-button wfsm-schedule-sale<?php echo esc_attr( $wfsm_button_class ); ?>"><?php esc_html_e( 'Schedule Sale', 'woocommerce-frontend-shop-manager' ); ?></a>
							<?php
							}

							if ( !in_array( 'product_taxes' , self::$settings['user_permissions'] ) ) {

								$tax_classes = WC_Tax::get_tax_classes();
								$classes_options = array();
								$classes_options['parent'] = esc_html__( 'Same as parent', 'woocommerce-frontend-shop-manager' );
								$classes_options[''] = esc_html__( 'Standard', 'woocommerce-frontend-shop-manager' );

								if ( $tax_classes ) {
									foreach ( $tax_classes as $class ) {
										$classes_options[ sanitize_title( $class ) ] = esc_html( $class );
									}
								}

								if ( !empty( $classes_options ) ) {
								?>
									<label for="wfsm-tax-class-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-selectize">
									<?php
										$wfsm_selected = ( ( $class = get_post_meta( $var['variation_id'], '_tax_class', true ) ) !== '' ? $class : '' );
									?>
										<span><?php esc_html_e( 'Tax Class', 'woocommerce-frontend-shop-manager' ); ?></span>
										<select id="wfsm-tax-class-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-tax-class" class="wfsm-collect-data">
										<?php
											foreach ( $classes_options as $wk => $wv ) {
										?>
												<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
										<?php
											}
										?>
										</select>
									</label>
								<?php
								}

							}

							if ( !in_array( 'product_virtual' , self::$settings['user_permissions'] ) ) {
								$is_virtual = ( $virtual = get_post_meta( $var['variation_id'], '_virtual', true ) ) ? $virtual : 'no';
							?>
								<label for="wfsm-virtual-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $is_virtual ); ?>" data-variable-linked="shipping">
									<span class="wfsm-show-yes"><?php esc_html_e( 'Product is Virtual', 'woocommerce-frontend-shop-manager' ); ?></span>
									<span class="wfsm-show-no"><?php esc_html_e( 'Product is not Virtual', 'woocommerce-frontend-shop-manager' ); ?></span>
									<input id="wfsm-virtual-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-virtual-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $is_virtual ); ?>"/>
								</label>
							<?php
							}

							if ( !in_array( 'product_shipping' , self::$settings['user_permissions'] ) ) {
							?>
								<div class="wfsm-variable-group wfsm-group-variable-shipping wfsm-group-variable-shipping<?php echo esc_attr( ( $is_virtual == 'no' ? ' wfsm-group-visible' : ' wfsm-group-notvisible' ) );?>">
								
								<?php
									$product_weight = ( $weight = get_post_meta( $var['variation_id'], '_weight', true ) ) ? $weight : '';
								?>
									<label for="wfsm-weight-<?php echo intval( $var['variation_id'] ); ?>">
										<span><?php esc_html_e( 'Weight', 'woocommerce-frontend-shop-manager' ); ?></span>
										<input id="wfsm-weight-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-weight-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_weight ); ?>" />
									</label>

								<?php
									$product_length = ( $length = get_post_meta( $var['variation_id'], '_length', true ) ) ? $length : '';
								?>
									<label for="wfsm-length-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-third wfsm-label-first">
										<span><?php esc_html_e( 'Length', 'woocommerce-frontend-shop-manager' ); ?></span>
										<input id="wfsm-length-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-length-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_length ); ?>"/>
									</label>

								<?php
									$product_width = ( $width = get_post_meta( $var['variation_id'], '_width', true ) ) ? $width : '';
								?>
									<label for="wfsm-width-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-third">
										<span><?php esc_html_e( 'Width', 'woocommerce-frontend-shop-manager' ); ?></span>
										<input id="wfsm-width-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-width-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_width ); ?>"/>
									</label>

								<?php
									$product_height = ( $height = get_post_meta( $var['variation_id'], '_height', true ) ) ? $height : '';
								?>
									<label for="wfsm-height-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-third">
										<span><?php esc_html_e( 'Height', 'woocommerce-frontend-shop-manager' ); ?></span>
										<input id="wfsm-height-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-height-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_height ); ?>"/>
									</label>
									<div class="wfsm-clear"></div>


									<label for="wfsm-shipping-class-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-selectize">
									<?php

										$args = array(
											'taxonomy'         => 'product_shipping_class',
											'hide_empty'       => 0,
											'show_option_none' => esc_html__( 'Same as parent', 'woocommerce-frontend-shop-manager' ),
											'name'             => 'wfsm-shipping-class-' . $var['variation_id'],
											'id'               => 'wfsm-shipping-class-' . $var['variation_id'],
											'selected'         => $current_shipping_class,
											'class'            => 'wfsm-collect-data'
										);

									?>
										<span><?php esc_html_e( 'Shipping Class', 'woocommerce-frontend-shop-manager' ); ?></span>
										<?php wp_dropdown_categories( $args ); ?>
									</label>

								</div>
						<?php
							}

							if ( !in_array( 'product_downloads' , self::$settings['user_permissions'] ) ) {
								$is_downloadable = ( $downloadable = get_post_meta( $var['variation_id'], '_downloadable', true ) ) ? $downloadable : 'no';
							?>
								<label for="wfsm-downloadable-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $is_downloadable ); ?>" data-variable-linked="downloads">
									<span class="wfsm-show-yes"><?php esc_html_e( 'Product is Downloadable', 'woocommerce-frontend-shop-manager' ); ?></span>
									<span class="wfsm-show-no"><?php esc_html_e( 'Product is not Downloadable', 'woocommerce-frontend-shop-manager' ); ?></span>
									<input id="wfsm-downloadable-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-downloadable-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $is_downloadable ); ?>"/>
								</label>
							<?php
							}

							if ( !in_array( 'product_downloads' , self::$settings['user_permissions'] ) ) {
							?>
								<div class="wfsm-variable-group wfsm-group-variable-downloads wfsm-group-variable-downloads<?php echo esc_attr( ( $is_downloadable == 'yes' ? ' wfsm-group-visible' : ' wfsm-group-notvisible' ) );?>">
									<div class="wfsm-downloads-add-files">
									<?php
										$downloadable_files = get_post_meta( $var['variation_id'], '_downloadable_files', true );
										if ( $downloadable_files ) {
											foreach ( $downloadable_files as $key => $file ) {
											?>
												<div class="wfsm-downloads-file">
													<a href="#" class="wfsm-downloads-move"><i class="wfsmico-move"></i></a>
													<span class="wfsm-downloads-file-name"><input type="text" placeholder="<?php esc_html_e( 'File Name', 'woocommerce-frontend-shop-manager' ); ?>" name="wfsm-file-names-<?php echo intval( $var['variation_id'] ); ?>[]" value="<?php echo esc_attr( $file['name'] ); ?>" class="wfsm-collect-data" /></span>
													<span class="wfsm-downloads-file-url"><input type="text" placeholder="<?php esc_html_e( "http://", 'woocommerce-frontend-shop-manager' ); ?>" name="wfsm-file-urls-<?php echo intval( $var['variation_id'] ); ?>[]" value="<?php echo esc_attr( $file['file'] ); ?>" class="wfsm-collect-data" /></span>
													<a href="#" class="wfsm-downloads-file-choose" data-choose="<?php esc_html_e( 'Choose file', 'woocommerce-frontend-shop-manager' ); ?>" data-update="<?php esc_html_e( 'Insert file URL', 'woocommerce-frontend-shop-manager' ); ?>"><?php esc_html_e( 'Choose File', 'woocommerce-frontend-shop-manager' ); ?></a>
													<a href="#" class="wfsm-downloads-file-discard"><i class="wfsmico-discard"></i></a>
												</div>
											<?php
											}
										}
									?>

									</div>

									<a href="#" class="wfms-plain-button wfsm-add-file"><?php esc_html_e( 'Add File', 'woocommerce-frontend-shop-manager' ); ?></a>

								<?php
									if ( !in_array( 'product_download_settings' , self::$settings['user_permissions'] ) ) {
										$product_limit = ( $limit = get_post_meta( $var['variation_id'], '_download_limit', true ) ) ? $limit : '';
									?>
										<label for="wfsm-download-limit-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label">
											<span><?php esc_html_e( 'Download Limit', 'woocommerce-frontend-shop-manager' ); ?></span>
											<input id="wfsm-download-limit-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-download-limit-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="number" value="<?php echo esc_attr( $product_limit ); ?>"/>
										</label>

									<?php
										$product_expiry = ( $expiry = get_post_meta( $var['variation_id'], '_download_expiry', true ) ) ? $expiry : '';
									?>
										<label for="wfsm-download-expiry-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-label">
											<span><?php esc_html_e( 'Download Expiry', 'woocommerce-frontend-shop-manager' ); ?></span>
											<input id="wfsm-download-expiry-<?php echo intval( $var['variation_id'] ); ?>" name="wfsm-download-expiry-<?php echo intval( $var['variation_id'] ); ?>" class="wfsm-reset-this wfsm-collect-data" type="number" value="<?php echo esc_attr( $product_expiry ); ?>"/>
										</label>

									<?php
									}
								?>

								</div>
						<?php
							}
						?>
						</div>
					<?php
						}

						if ( !in_array( 'variable_add_variations' , self::$settings['user_permissions'] ) ) {
						?>
							<span class="wfsm-add-variation"><?php echo esc_html__( 'Add New Variation', 'woocommerce-frontend-shop-manager' ); ?></span>
						<?php
						}

						if ( !in_array( 'variable_product_attributes' , self::$settings['user_permissions'] ) ) {
						?>
							<span class="wfsm-refresh-attributes"><?php esc_html_e( 'Update Attributes and Variations', 'woocommerce-frontend-shop-manager' ); ?></span>
						<?php
						}
					?>
					</div>
				<?php

					do_action( 'wfsm_after_variation_settings' );

				}

				do_action( 'wfsm_after_settings' );

			?>
				<div class="wfsm-info">
					<?php echo apply_filters( 'wfsm_manager_info', 'Live Product Editor for WooCommerce v' . self::$version ); ?>
				</div>
				<div class="wfsm-clear"></div>
				<script type="text/javascript">
					(function($){
						"use strict";

						<?php if ( !in_array( 'product_content' , self::$settings['user_permissions'] ) ) { ?>
						$(document).on('click', '.wfsm-editor-add-image', function () {

							var el = $(this);

							if ( $.isEmptyObject(window.wfsm_frame) == false ) {

								window.wfsm_frame.off('select');

								window.wfsm_frame.on( 'select', function() {

									var attachment = window.wfsm_frame.state().get('selection').first();
									window.wfsm_frame.close();

									tinymce.activeEditor.execCommand('mceInsertContent', false, '<img src="'+attachment.attributes.sizes.full.url+'" />');

								});

								window.wfsm_frame.open();

								return false;
							}


							window.wfsm_frame = wp.media({
								title: '<?php echo esc_attr( esc_html__('Insert Image','wfsm') ); ?>',
								button: {
									text: '<?php echo esc_attr( esc_html__('Add Image','wfsm') ); ?>',
									close: false
								},
								multiple: false,
								default_tab: 'upload',
								tabs: 'upload, library',
								returned_image_size: 'full'
							});

							window.wfsm_frame.off('select');

							window.wfsm_frame.on( 'select', function() {

								var attachment = window.wfsm_frame.state().get('selection').first();
								window.wfsm_frame.close();

								tinymce.activeEditor.execCommand('mceInsertContent', false, '<img src="'+attachment.attributes.sizes.full.url+'" />');

							});

							window.wfsm_frame.open();

							return false;

						});
						<?php } ?>


						<?php if ( !in_array( 'product_featured_image' , self::$settings['user_permissions'] ) ) { ?>
						$(document).on('click', '.wfsm-quick-editor label.wfsm-featured-image > a.wfsm-featured-image-trigger, .wfsm-change-image', function () {

							if ( $(this).hasClass('wfsm-change-image') ) {
								var el = $(this).parent().prev().find('.wfsm-featured-image-trigger');
							}
							else {
								var el = $(this);
							}

							var curr = el.parent();

							if ( $.isEmptyObject(window.wfsm_frame) == false ) {

								window.wfsm_frame.off('select');

								window.wfsm_frame.on( 'select', function() {

									var attachment = window.wfsm_frame.state().get('selection').first();
									window.wfsm_frame.close();

									curr.find('input:hidden').val(attachment.id);
									if ( attachment.attributes.type == 'image' ) {
										el.html('<img width="64" height="64" src="'+attachment.attributes.sizes.thumbnail.url+'" />');
									}

								});

								window.wfsm_frame.open();

								return false;
							}


							window.wfsm_frame = wp.media({
								title: '<?php echo esc_attr( esc_html__('Set Featured Image','wfsm') ); ?>',
								button: {
									text: el.data("update"),
									close: false
								},
								multiple: false,
								default_tab: 'upload',
								tabs: 'upload, library',
								returned_image_size: 'thumbnail'
							});

							window.wfsm_frame.off('select');

							window.wfsm_frame.on( 'select', function() {

								var attachment = window.wfsm_frame.state().get('selection').first();
								window.wfsm_frame.close();

								curr.find('input:hidden').val(attachment.id);
								if ( attachment.attributes.type == 'image' ) {
									el.html('<img width="64" height="64" src="'+attachment.attributes.sizes.thumbnail.url+'" />');
								}

							});

							window.wfsm_frame.open();

							return false;

						});
						<?php } ?>

						<?php if ( !in_array( 'product_gallery' , self::$settings['user_permissions'] ) ) { ?>
						$(document).on('click', '.wfsm-quick-editor label.wfsm-product-gallery > .wfsm-add-gallery-image', function () {

							var curr_input = $(this).next();
							var curr = $(this).parent().prev();

							if ( $.isEmptyObject(window.wfsm_frame_gallery) == false ) {

								window.wfsm_frame_gallery.off("select");

								window.wfsm_frame_gallery.on( 'select', function() {

									var attachment = window.wfsm_frame_gallery.state().get('selection');
									window.wfsm_frame_gallery.close();

									attachment.each( function(curr_att) {
										curr_input.prepend('<option value="'+curr_att.id+'" selected="selected">'+curr_att.id+'</option>');
										if ( curr_att.attributes.type == 'image' ) {
											curr.prepend('<span class="wfsm-product-gallery-image" data-id="'+curr_att.id+'"><img width="64" height="64" src="'+curr_att.attributes.sizes.thumbnail.url+'" /><a href="#" class="wfsm-remove-gallery-image"><i class="wfsmico-discard"></i></a></span>');
										}
									});

								});

								window.wfsm_frame_gallery.open();

								return false;
							}


							window.wfsm_frame_gallery = wp.media({
								title: '<?php echo esc_attr( esc_html__('Select Product Images','wfsm') ); ?>',
								button: {
									text: '<?php echo esc_attr( esc_html__( 'Add Images', 'woocommerce-frontend-shop-manager' ) ); ?>',
									close: false
								},
								multiple: true,
								default_tab: 'upload',
								tabs: 'upload, library',
								returned_image_size: 'thumbnail'
							});

							window.wfsm_frame_gallery.off('select');

							window.wfsm_frame_gallery.on( 'select', function() {

								var attachment = window.wfsm_frame_gallery.state().get('selection');
								window.wfsm_frame_gallery.close();

								attachment.each( function(curr_att) {
									curr_input.prepend('<option value="'+curr_att.id+'" selected="selected">'+curr_att.id+'</option>');
									if ( curr_att.attributes.type == 'image' ) {
										curr.prepend('<span class="wfsm-product-gallery-image" data-id="'+curr_att.id+'"><img width="64" height="64" src="'+curr_att.attributes.sizes.thumbnail.url+'" /><a href="#" class="wfsm-remove-gallery-image"><i class="wfsmico-discard"></i></a></span>');
									}
								});

							});

							window.wfsm_frame_gallery.open();

							return false;

						});

						$(document).on('click', '.wfsm-remove-gallery-image', function () {

							var el = $(this).parent();
							var curr = el.parent().next();
							var el_id = el.attr('data-id');

							el.remove();
							curr.find('select option[value="'+el_id+'"]').remove();

							return false;

						});

						$(document).on('click', '.wfsm-remove-image', function () {

							var el = $(this).parent().prev().find('.wfsm-featured-image-trigger');
							var curr = el.parent();

							el.html('<img width="64" height="64" src="<?php echo Wfsm()->plugin_url() . '/assets/images/placeholder.gif'; ?>">');
							curr.find('input').val('0');

							return false;

						});
						<?php } ?>

						$('.wfsm-group-taxonomies .wfsm-selectize select').each( function() {
							var curr = $(this);

							curr.selectize({
								plugins: ['remove_button'],
								delimiter: ',',
								persist: false<?php if ( !in_array( 'product_new_terms' , self::$settings['user_permissions'] ) ) { ?>,
								onItemAdd: function(input) {
									if ( curr.closest('label').attr('for') == 'wfsm-select-attributes' ) {

										var el = $('.wfsm-buttons.wfsm-active');

										var curr_data = {
											action: 'wfsm_create_attribute',
											wfsm_id: el.attr('data-id'),
											wfsm_add: input
										}

										$.post('<?php echo admin_url( 'admin-ajax.php' ); ?>', curr_data, function(response) {
											if (response) {

												curr.closest('.wfsm-screen').find('.wfsm-group-taxonomies').append(response);
												curr.closest('.wfsm-screen').find('.wfsm-group-taxonomies').find('div:last select:first').selectize({
													plugins: ['remove_button'],
													delimiter: ',',
													persist: false,
													create: function(input) {
														return {
															value: input,
															text: input
														}
													}
												});

											}
											else {
												alert('Error!');
											}
										});

									}
								},
								onItemRemove: function(input) {
									if ( curr.closest('label').attr('for') == 'wfsm-select-attributes' ) {
										var curr_attribute = $(document.getElementsByClassName('wfsm-attribute-'+input)[0]);
										curr_attribute.remove();
									}
								},
								create: function(input) {
									return {
										value: input,
										text: input
									}
								}<?php } ?>
							});
						});

						<?php if ( !in_array( 'product_downloads' , self::$settings['user_permissions'] ) ) { ?>
						$('.wfsm-downloads-add-files').sortable({
							cursor:'move'
						});

						$(document).on('click', '.wfsm-downloads-file-choose', function () {

							var el = $(this);

							var curr = el.parent();

							if ( $.isEmptyObject(window.wfsm_frame_files) == false ) {

								window.wfsm_frame_files.off('select');

								window.wfsm_frame_files.on( 'select', function() {

									var attachment = window.wfsm_frame_files.state().get('selection').first();
									window.wfsm_frame_files.close();

									curr.find('.wfsm-downloads-file-url input').val(attachment.attributes.url);

								});

								window.wfsm_frame_files.open();

								return false;
							}


							window.wfsm_frame_files = wp.media({
								title: '<?php echo esc_attr( esc_html__('Choose File','wfsm') ); ?>',
								button: {
									text: el.data('update'),
									close: false
								},
								multiple: false,
								default_tab: 'upload',
								tabs: 'upload, library'
							});

							window.wfsm_frame_files.off('select');

							window.wfsm_frame_files.on( 'select', function() {

								var attachment = window.wfsm_frame_files.state().get('selection').first();
								window.wfsm_frame_files.close();

								curr.find('.wfsm-downloads-file-url input').val(attachment.attributes.url);

							});

							window.wfsm_frame_files.open();

							return false;

						});
						<?php } ?>

					})(jQuery);
				</script>
			</div>
		</div>
	<?php
		$out = ob_get_clean();

		die($out);
		exit;

	}

	function wfsm_add_variation_respond() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset($_POST) && isset( $_POST['wfsm_id'] ) ) {
			$curr_post_id = absint( stripslashes( $_POST['wfsm_id'] ) );
			if ( get_post_status( $curr_post_id ) === false ) {
				die( 'Error!' );
				exit;
			}
		}
		else {
			die( 'Error!' );
			exit;
		}

		$curr_post_author = self::wfsm_check_premissions( $curr_post_id );

		if ( $curr_post_author === false ) {
			die( 'Error!' );
			exit;
		}

		if ( ( isset( $_POST['wfsm_mode'] ) && $_POST['wfsm_mode'] == 'get' ) === false ) {

			$curr_create = array(
				'post_title'     => '',
				'post_content'   => '',
				'post_name'      => 'product-' . $curr_post_id . '-variation',
				'post_status'    => 'publish',
				'post_type'      => 'product_variation',
				'post_parent'    => $curr_post_id,
				'comment_status' => get_option('default_comment_status'),
				'ping_status'    => get_option('default_ping_status'),
				'menu_order'     => ( isset( $_POST['wfsm_order'] ) ? $_POST['wfsm_order'] : 0 ),
				'post_author'    => $curr_post_author
			);

			$curr_dummy =  wp_insert_post( $curr_create );

			$args = array(
				'post_type'   => 'product_variation',
				'post_status' => array( 'private', 'publish' ),
				'numberposts' => -1,
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
				'fields'      => 'ids',
				'post_parent' => $curr_post_id
			);

			$variations = get_posts( $args );

			$transient_name = 'wc_product_children_ids_' . $curr_post_id . WC_Cache_Helper::get_transient_version( 'product' );

			set_transient( $transient_name, $variations, DAY_IN_SECONDS * 30 );

			$curr_parent = new WC_Product( $curr_post_id );
			$curr_parent_id = $curr_post_id;

			$add_attributes = $curr_parent->get_attributes();

			foreach( $add_attributes as $k => $v ) {
				update_post_meta( $curr_dummy, 'attribute_' . $k, '');
			}

			update_post_meta( $curr_dummy, '_visibility', 'visible' );
			update_post_meta( $curr_dummy, '_sku', '' );
			update_post_meta( $curr_dummy, '_stock_status', 'instock' );
			update_post_meta( $curr_dummy, '_total_sales', '0' );

			$is_virtual = get_option( 'wc_settings_wfsm_create_virtual', 'no' ) == 'yes' ? 'yes' : 'no';
			update_post_meta( $curr_dummy, '_virtual', $is_virtual );

			$is_downloadable = get_option( 'wc_settings_wfsm_create_downloadable', 'no' ) == 'yes' ? 'yes' : 'no';
			update_post_meta( $curr_dummy, '_downloadable', $is_downloadable );

			update_post_meta( $curr_dummy, '_featured', 'no' );

		}
		else {
			$curr_dummy = $curr_post_id; // OK
		}

		do_action( 'woocommerce_update_product_variation', $curr_dummy );

		if ( !isset( $curr_parent_id ) ) {
			$curr_parent_id = wp_get_post_parent_id( $curr_dummy );
		}

		$curr_product[$curr_dummy] = new WC_Product_Variation( $curr_dummy );
		$curr_variable_attributes = get_post_meta( $curr_parent_id, '_product_attributes', true );

		ob_start();

	?>
		<span class="wfsm-headline"><?php echo esc_html__( 'Product Variation #ID', 'woocommerce-frontend-shop-manager' ) . ' ' . intval( $curr_dummy ); ?><?php if ( !in_array( 'variable_delete' , self::$settings['user_permissions'] ) ) { ?><a href="#" class="wfsm-trash-variation" title="<?php esc_html_e( 'Delete variation', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-discard"></i></a><?php } ?></span>
		<div class="wfsm-variation" data-id="<?php echo intval( $curr_dummy ); ?>">
		<?php
			if ( !in_array( 'variable_product_attributes' , self::$settings['user_permissions'] ) && is_array( $curr_variable_attributes ) ) {
			?>
				<div class="wfsm-variation-attributes">
				<?php
					foreach ( $curr_variable_attributes as $ak => $av ) {

						$curr_term = $av['name'];
						$curr_term_sanitized = sanitize_title( $curr_term );

						$curr_attributes = get_terms( $curr_term, array(
							'hide_empty' => 0
						) );

						$curr_product_atts = wp_get_post_terms( $curr_parent_id, $curr_term, array( 'fields' => 'slugs' ) );

						$variation_meta = get_post_meta( $curr_dummy );
						foreach ( $variation_meta as $key => $value ) {
							if ( false !== strpos( $key, 'attribute_' ) ) {
								$variation_data[ $key ] = $value;
							}
						}
					?>
						<label for="wfsm-attribute-<?php echo intval( $curr_dummy ); ?>-<?php echo esc_attr( $curr_term_sanitized ); ?>" class="wfsm-selectize">
					<?php
						$wfsm_selected = $variation_data['attribute_' . $curr_term_sanitized][0];
					?>
						<span><?php echo wc_attribute_label( $curr_term ); ?></span>
						<select id="wfsm-attribute-<?php echo intval( $curr_dummy ); ?>-<?php echo esc_attr( $curr_term_sanitized ); ?>" name="wfsm-attribute-<?php echo intval( $curr_dummy ); ?>-<?php echo esc_attr( $curr_term_sanitized ); ?>" class="wfsm-collect-data">
							<option value=""><?php echo esc_html__( 'Any', 'woocommerce-frontend-shop-manager' ) . ' ' . wc_attribute_label( $curr_term ) . '...'; ?></option>
						<?php
							foreach ( $curr_attributes as $wk => $wv ) {
								if ( !in_array( $wv->slug, $curr_product_atts ) ) {
									continue;
								}

						?>
								<option value="<?php echo esc_attr( $wv->slug ); ?>"<?php echo ( $wfsm_selected == $wv->slug ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv->name ); ?></option>
						<?php
							}
						?>
						</select>
					</label>
				<?php
					}
				?>
				</div>
			<?php
			}

			if ( !in_array( 'product_featured_image' , self::$settings['user_permissions'] ) ) {
				?>
				<span class="wfsm-dummy-title"><?php esc_html_e( 'Featured Image', 'woocommerce-frontend-shop-manager' ); ?></span>
				<label for="wfsm-featured-image-<?php echo intval( $curr_dummy ); ?>" class="wfsm-featured-image">
					<a href="#" class="wfsm-featured-image-trigger">
					<?php
						if ( has_post_thumbnail( $curr_dummy ) ) {
							$curr_image = wp_get_attachment_image_src( $curr_image_id = get_post_thumbnail_id( $curr_dummy ), 'thumbnail' );
						?>
							<img width="64" height="64" src="<?php echo esc_url( $curr_image[0] ); ?>" />
						<?php
						}
						else {
							$curr_image_id = 0;
						?>
							<img width="64" height="64" src="<?php echo Wfsm()->plugin_url() . '/assets/images/placeholder.gif'; ?>" />
					<?php
						}
					?>
					</a>
					<input id="wfsm-featured-image-<?php echo intval( $curr_dummy ); ?>" name="wfsm-featured-image-<?php echo intval( $curr_dummy ); ?>" class="wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $curr_image_id ); ?>" />
				</label>
				<div class="wfsm-featured-image-controls">
					<a href="#" class="wfsm-editor-button wfsm-change-image"><?php esc_html_e( 'Change Image', 'woocommerce-frontend-shop-manager' ); ?></a>
					<a href="#" class="wfsm-editor-button wfsm-remove-image"><?php esc_html_e( 'Discard Image', 'woocommerce-frontend-shop-manager' ); ?></a>
				</div>
				<div class="wfsm-clear"></div>
		<?php
			}

			if ( !in_array( 'product_sku' , self::$settings['user_permissions'] ) && wc_product_sku_enabled() ) {
			?>
				<label for="wfsm-sku-<?php echo intval( $curr_dummy ); ?>">
					<span><?php esc_html_e( 'SKU', 'woocommerce-frontend-shop-manager' ); ?></span>
					<input id="wfsm-sku-<?php echo intval( $curr_dummy ); ?>" name="wfsm-sku-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $curr_product[$curr_dummy]->get_sku() ); ?>" />
				</label>
			<?php
			}

			if ( !in_array( 'product_prices' , self::$settings['user_permissions'] ) ) {
			?>
				<label for="wfsm-regular-price-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-half wfsm-label-first">
					<span><?php esc_html_e( 'Regular Price', 'woocommerce-frontend-shop-manager' ); ?></span>
					<input id="wfsm-regular-price-<?php echo intval( $curr_dummy ); ?>" name="wfsm-regular-price-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $curr_product[$curr_dummy]->get_regular_price() ); ?>"/>
				</label>
				<label for="wfsm-sale-price-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-half">
					<span><?php esc_html_e( 'Sale Price', 'woocommerce-frontend-shop-manager' ); ?></span>
					<input id="wfsm-sale-price-<?php echo intval( $curr_dummy ); ?>" name="wfsm-sale-price-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $curr_product[$curr_dummy]->get_sale_price() ); ?>"/>
				</label>
				<div class="wfsm-clear"></div>
			<?php
			}

			if ( !in_array( 'product_stock' , self::$settings['user_permissions'] ) ) {
				$in_stock_status = ( $stock = get_post_meta( $curr_dummy, '_stock_status', true ) ) ? $stock : 'instock';
			?>
				<label for="wfsm-product-stock-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $in_stock_status ); ?>">
					<span class="wfsm-show-instock"><?php esc_html_e( 'Product is In Stock', 'woocommerce-frontend-shop-manager' ); ?></span>
					<span class="wfsm-show-outofstock"><?php esc_html_e( 'Product is currently Out of Stock', 'woocommerce-frontend-shop-manager' ); ?></span>
					<input id="wfsm-product-stock-<?php echo intval( $curr_dummy ); ?>" name="wfsm-product-stock-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $in_stock_status ); ?>"/>
				</label>
			<?php
				$option_manage_stock = get_option( 'woocommerce_manage_stock' );
				if ( 'yes' == $option_manage_stock ) {
					$wfsm_class = ( ( get_post_meta( $curr_dummy, '_manage_stock', true ) ) == 'yes' ? ' wfsm-visible' : ' wfsm-hidden' ); // OK
				?>
					<div class="wfsm-manage-stock-quantity-<?php echo intval( $curr_dummy ); ?><?php echo esc_attr( $wfsm_class ); ?>">
						<label for="wfsm-stock-quantity-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-quantity">
							<span><?php esc_html_e( 'Stock Quantity', 'woocommerce-frontend-shop-manager' ); ?></span>
						<?php
							$stock_count = get_post_meta( $curr_dummy, '_stock', true );
						?>
							<input id="wfsm-stock-quantity-<?php echo intval( $curr_dummy ); ?>" name="wfsm-stock-quantity-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="number" value="<?php echo esc_attr( wc_stock_amount( $stock_count ) ); ?>" />
						</label>
						<label for="wfsm-backorders-<?php echo intval( $curr_dummy ); ?>" class="wfsm-selectize">
						<?php
							$wfsm_selected = ( ( $backorders = get_post_meta( $curr_dummy, '_backorders', true ) ) ? $backorders : '' );
						?>
							<span><?php esc_html_e( 'Allow Backorders', 'woocommerce-frontend-shop-manager' ); ?></span>
							<select id="wfsm-backorders-<?php echo intval( $curr_dummy ); ?>" name="wfsm-backorders-<?php echo intval( $curr_dummy ); ?>" class="wfsm-collect-data">
							<?php
								$wfsm_select_options = array(
									'no'     => esc_html__( 'Do not allow', 'woocommerce-frontend-shop-manager' ),
									'notify' => esc_html__( 'Allow, but notify customer', 'woocommerce-frontend-shop-manager' ),
									'yes'    => esc_html__( 'Allow', 'woocommerce-frontend-shop-manager' )
								);
								foreach ( $wfsm_select_options as $wk => $wv ) {
							?>
									<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
							<?php
								}
							?>
							</select>
						</label>
					</div>
				<?php
					$wfsm_button_class = ( $wfsm_class == ' wfsm-visible' ? ' wfsm-active' : '' ); // OK
				?>
					<a href="#" class="wfsm-editor-button wfsm-manage-stock-quantity-<?php echo intval( $curr_dummy ); ?><?php echo esc_attr( $wfsm_button_class ); ?>"><?php esc_html_e( 'Manage Stock', 'woocommerce-frontend-shop-manager' ); ?></a>
				<?php
				}
			}

			if ( !in_array( 'product_schedule_sale' , self::$settings['user_permissions'] ) ) {
				$sale_price_dates_from = ( $date = get_post_meta( $curr_dummy, '_sale_price_dates_from', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
				$sale_price_dates_to = ( $date = get_post_meta( $curr_dummy, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';

				$wfsm_class = ( $sale_price_dates_from !== '' || $sale_price_dates_to !== '' ? ' wfsm-visible' : ' wfsm-hidden' ); // OK
			?>
				<div class="wfsm-schedule-sale<?php echo esc_attr( $wfsm_class ); ?>">
					<label for="wfsm-schedule-sale-start-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-half wfsm-label-first">
						<span><?php esc_html_e( 'Start Sale', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-schedule-sale-start-<?php echo intval( $curr_dummy ); ?>" name="wfsm-schedule-sale-start-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-date-picker wfsm-collect-data" type="text" value="<?php echo esc_attr( $sale_price_dates_from ); ?>" placeholder="<?php esc_html_e( 'From&hellip; YYYY-MM-DD', 'woocommerce-frontend-shop-manager' ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" />
					</label>
					<label for="wfsm-schedule-sale-end-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-half">
						<span><?php esc_html_e( 'End Sale', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-schedule-sale-end-<?php echo intval( $curr_dummy ); ?>" name="wfsm-schedule-sale-end-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-date-picker wfsm-collect-data" type="text" value="<?php echo esc_attr( $sale_price_dates_to ); ?>" placeholder="<?php esc_html_e( 'To&hellip; YYYY-MM-DD', 'woocommerce-frontend-shop-manager' ); ?>" maxlength="10" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" />
					</label>
					<div class="wfsm-clear"></div>
				</div>
			<?php
				$wfsm_button_class = ( $wfsm_class == ' wfsm-visible' ? ' wfsm-active' : '' ); // OK
			?>
				<a href="#" class="wfsm-editor-button wfsm-schedule-sale<?php echo esc_attr( $wfsm_button_class ); ?>"><?php esc_html_e( 'Schedule Sale', 'woocommerce-frontend-shop-manager' ); ?></a>
			<?php
			}

			if ( !in_array( 'product_taxes' , self::$settings['user_permissions'] ) ) {

				$tax_classes = WC_Tax::get_tax_classes();
				$classes_options = array();
				$classes_options['parent'] = esc_html__( 'Same as parent', 'woocommerce-frontend-shop-manager' );
				$classes_options[''] = esc_html__( 'Standard', 'woocommerce-frontend-shop-manager' );

				if ( $tax_classes ) {
					foreach ( $tax_classes as $class ) {
						$classes_options[ sanitize_title( $class ) ] = esc_html( $class );
					}
				}

				if ( !empty( $classes_options ) ) {
				?>
					<label for="wfsm-tax-class-<?php echo intval( $curr_dummy ); ?>" class="wfsm-selectize">
					<?php
						$wfsm_selected = ( ( $class = get_post_meta( $curr_dummy, '_tax_class', true ) ) !== '' ? $class : '' );
					?>
						<span><?php esc_html_e( 'Tax Class', 'woocommerce-frontend-shop-manager' ); ?></span>
						<select id="wfsm-tax-class-<?php echo intval( $curr_dummy ); ?>" name="wfsm-tax-class" class="wfsm-collect-data">
						<?php
							foreach ( $classes_options as $wk => $wv ) {
						?>
								<option value="<?php echo esc_attr( $wk );?>"<?php echo ( $wfsm_selected == $wk ? ' selected="selected"' : '' ); ?>><?php echo esc_html( $wv ); ?></option>
						<?php
							}
						?>
						</select>
					</label>
				<?php
				}

			}

			if ( !in_array( 'product_virtual' , self::$settings['user_permissions'] ) ) {
				$is_virtual = ( $virtual = get_post_meta( $curr_dummy, '_virtual', true ) ) ? $virtual : 'no';
			?>
				<label for="wfsm-virtual-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $is_virtual ); ?>" data-variable-linked="shipping">
					<span class="wfsm-show-yes"><?php esc_html_e( 'Product is Virtual', 'woocommerce-frontend-shop-manager' ); ?></span>
					<span class="wfsm-show-no"><?php esc_html_e( 'Product is not Virtual', 'woocommerce-frontend-shop-manager' ); ?></span>
					<input id="wfsm-virtual-<?php echo intval( $curr_dummy ); ?>" name="wfsm-virtual-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $is_virtual ); ?>"/>
				</label>
			<?php
			}

			if ( !in_array( 'product_shipping' , self::$settings['user_permissions'] ) ) {
			?>
				<div class="wfsm-variable-group wfsm-group-variable-shipping wfsm-group-variable-shipping<?php echo esc_attr( ( $is_virtual == 'no' ? ' wfsm-group-visible' : ' wfsm-group-notvisible' ) );?>">
				
				<?php
					$product_weight = ( $weight = get_post_meta( $curr_dummy, '_weight', true ) ) ? $weight : '';
				?>
					<label for="wfsm-weight-<?php echo intval( $curr_dummy ); ?>">
						<span><?php esc_html_e( 'Weight', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-weight-<?php echo intval( $curr_dummy ); ?>" name="wfsm-weight-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_weight ); ?>" />
					</label>

				<?php
					$product_length = ( $length = get_post_meta( $curr_dummy, '_length', true ) ) ? $length : '';
				?>
					<label for="wfsm-length-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-third wfsm-label-first">
						<span><?php esc_html_e( 'Length', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-length-<?php echo intval( $curr_dummy ); ?>" name="wfsm-length-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_length ); ?>"/>
					</label>

				<?php
					$product_width = ( $width = get_post_meta( $curr_dummy, '_width', true ) ) ? $width : '';
				?>
					<label for="wfsm-width-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-third">
						<span><?php esc_html_e( 'Width', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-width-<?php echo intval( $curr_dummy ); ?>" name="wfsm-width-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_width ); ?>"/>
					</label>

				<?php
					$product_height = ( $height = get_post_meta( $curr_dummy, '_height', true ) ) ? $height : '';
				?>
					<label for="wfsm-height-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-third">
						<span><?php esc_html_e( 'Height', 'woocommerce-frontend-shop-manager' ); ?></span>
						<input id="wfsm-height-<?php echo intval( $curr_dummy ); ?>" name="wfsm-height-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="text" value="<?php echo esc_attr( $product_height ); ?>"/>
					</label>
					<div class="wfsm-clear"></div>


					<label for="wfsm-shipping-class-<?php echo intval( $curr_dummy ); ?>" class="wfsm-selectize">
					<?php

						$shipping_classes = get_the_terms( $curr_post_id, 'product_shipping_class' );
						if ( $shipping_classes && ! is_wp_error( $shipping_classes ) ) {
							$current_shipping_class = current( $shipping_classes )->term_id;
						}
						else {
							$current_shipping_class = '';
						}

						$args = array(
							'taxonomy'         => 'product_shipping_class',
							'hide_empty'       => 0,
							'show_option_none' => esc_html__( 'Same as parent', 'woocommerce-frontend-shop-manager' ),
							'name'             => 'wfsm-shipping-class-' . $curr_dummy,
							'id'               => 'wfsm-shipping-class-' . $curr_dummy,
							'selected'         => $current_shipping_class,
							'class'            => 'wfsm-collect-data'
						);

					?>
						<span><?php esc_html_e( 'Shipping Class', 'woocommerce-frontend-shop-manager' ); ?></span>
						<?php wp_dropdown_categories( $args ); ?>
					</label>

				</div>
		<?php
			}

			if ( !in_array( 'product_downloadable' , self::$settings['user_permissions'] ) ) {
				$is_downloadable = ( $downloadable = get_post_meta( $curr_dummy, '_downloadable', true ) ) ? $downloadable : 'no';
			?>
				<label for="wfsm-downloadable-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $is_downloadable ); ?>" data-variable-linked="downloads">
					<span class="wfsm-show-yes"><?php esc_html_e( 'Product is Downloadable', 'woocommerce-frontend-shop-manager' ); ?></span>
					<span class="wfsm-show-no"><?php esc_html_e( 'Product is not Downloadable', 'woocommerce-frontend-shop-manager' ); ?></span>
					<input id="wfsm-downloadable-<?php echo intval( $curr_dummy ); ?>" name="wfsm-downloadable-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $is_downloadable ); ?>"/>
				</label>
			<?php
			}

			if ( !in_array( 'product_downloads' , self::$settings['user_permissions'] ) ) {
			?>
				<div class="wfsm-variable-group wfsm-group-variable-downloads wfsm-group-variable-downloads<?php echo esc_attr( ( $is_downloadable == 'yes' ? ' wfsm-group-visible' : ' wfsm-group-notvisible' ) );?>">
					<div class="wfsm-downloads-add-files">
					<?php
						$downloadable_files = get_post_meta( $curr_dummy, '_downloadable_files', true );
						if ( $downloadable_files ) {
							foreach ( $downloadable_files as $key => $file ) {
							?>
								<div class="wfsm-downloads-file">
									<a href="#" class="wfsm-downloads-move"><i class="wfsmico-move"></i></a>
									<span class="wfsm-downloads-file-name"><input type="text" placeholder="<?php esc_html_e( 'File Name', 'woocommerce-frontend-shop-manager' ); ?>" name="wfsm-file-names-<?php echo intval( $curr_dummy ); ?>[]" value="<?php echo esc_attr( $file['name'] ); ?>" class="wfsm-collect-data" /></span>
									<span class="wfsm-downloads-file-url"><input type="text" placeholder="<?php esc_html_e( "http://", 'woocommerce-frontend-shop-manager' ); ?>" name="wfsm-file-urls-<?php echo intval( $curr_dummy ); ?>[]" value="<?php echo esc_attr( $file['file'] ); ?>" class="wfsm-collect-data" /></span>
									<a href="#" class="wfsm-downloads-file-choose" data-choose="<?php esc_html_e( 'Choose file', 'woocommerce-frontend-shop-manager' ); ?>" data-update="<?php esc_html_e( 'Insert file URL', 'woocommerce-frontend-shop-manager' ); ?>"><?php esc_html_e( 'Choose File', 'woocommerce-frontend-shop-manager' ); ?></a>
									<a href="#" class="wfsm-downloads-file-discard"><i class="wfsmico-discard"></i></a>
								</div>
							<?php
							}
						}
					?>

					</div>
					<a href="#" class="wfms-plain-button wfsm-add-file"><?php esc_html_e( 'Add File', 'woocommerce-frontend-shop-manager' ); ?></a>

				<?php
					if ( !in_array( 'product_download_settings' , self::$settings['user_permissions'] ) ) {
						$product_limit = ( $limit = get_post_meta( $curr_dummy, '_download_limit', true ) ) ? $limit : '';
					?>
						<label for="wfsm-download-limit-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label">
							<span><?php esc_html_e( 'Download Limit', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-download-limit-<?php echo intval( $curr_dummy ); ?>" name="wfsm-download-limit-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="number" value="<?php echo esc_attr( $product_limit ); ?>"/>
						</label>

					<?php
						$product_expiry = ( $expiry = get_post_meta( $curr_dummy, '_download_expiry', true ) ) ? $expiry : '';
					?>
						<label for="wfsm-download-expiry-<?php echo intval( $curr_dummy ); ?>" class="wfsm-label">
							<span><?php esc_html_e( 'Download Expiry', 'woocommerce-frontend-shop-manager' ); ?></span>
							<input id="wfsm-download-expiry-<?php echo intval( $curr_dummy ); ?>" name="wfsm-download-expiry-<?php echo intval( $curr_dummy ); ?>" class="wfsm-reset-this wfsm-collect-data" type="number" value="<?php echo esc_attr( $product_expiry ); ?>"/>
						</label>

					<?php
					}
				?>

				</div>
		<?php
			}

		?>
		</div>
	<?php

		$out = ob_get_clean();

		die( $out );
		exit;
	}

	function wfsm_save() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset($_POST) && isset( $_POST['wfsm_id'] ) ) {
			$curr_post_id = intval( stripslashes( $_POST['wfsm_id'] ) );
			if ( get_post_status( $curr_post_id ) === false ) {
				die( 'Error!' );
				exit;
			}
		}
		else {
			die( 'Error!' );
			exit;
		}

		$curr_post_author = self::wfsm_check_premissions( $curr_post_id );

		if ( $curr_post_author === false ) {
			die( 'Error!' );
			exit;
		}

		$curr_data = array();
		$curr_data = json_decode( stripslashes( $_POST['wfsm_save'] ), true );

		$curr_post['ID'] = $curr_post_id;

		if ( !in_array( 'product_name' , self::$settings['user_permissions'] ) && isset($curr_data['wfsm-product-name']) && $curr_data['wfsm-product-name'] !== '' ) {
			$curr_post['post_title'] = $curr_data['wfsm-product-name'];
		}

		if ( !in_array( 'product_status' , self::$settings['user_permissions'] ) && isset($curr_data['wfsm-product-status']) && $curr_data['wfsm-product-status'] !== '' ) {
			$curr_post['post_status'] = $curr_data['wfsm-product-status'];
		}

		if ( !in_array( 'product_slug' , self::$settings['user_permissions'] ) && isset($curr_data['wfsm-product-slug']) && $curr_data['wfsm-product-slug'] !== '' ) {
			$curr_post['post_name'] = sanitize_title( $curr_data['wfsm-product-slug'] );
		}

		wp_update_post( $curr_post );

		if ( !in_array( 'product_featured_image' , self::$settings['user_permissions'] ) && isset($curr_data['wfsm-featured-image']) ) {
			update_post_meta( $curr_post_id, '_thumbnail_id', $curr_data['wfsm-featured-image'] );
		}

		if ( !in_array( 'product_gallery' , self::$settings['user_permissions'] ) ) {
			if ( isset($curr_data['wfsm-product-gallery']) && $curr_data['wfsm-product-gallery'] !== null && is_array( $curr_data['wfsm-product-gallery'] ) ) {
				if ( count($curr_data['wfsm-product-gallery']) > 1 ) {
					$curr_gallery_images = implode( ',', $curr_data['wfsm-product-gallery'] );
				}
				else {
					$curr_gallery_images = $curr_data['wfsm-product-gallery'][0];
				}
				update_post_meta( $curr_post_id, '_product_image_gallery', $curr_gallery_images );
			}
			else if ( isset($curr_data['wfsm-product-gallery']) && $curr_data['wfsm-product-gallery'] == null ) {
				update_post_meta( $curr_post_id, '_product_image_gallery', '' );
			}
		}

		$save_post = get_post( $curr_post_id );

		if ( $terms = wp_get_object_terms( $curr_post_id, 'product_type' ) ) {
			$product_type = sanitize_title( current( $terms )->name );
		} else {
			$product_type = apply_filters( 'default_product_type', 'simple' );
		}

		if ( !in_array( 'product_cat' , self::$settings['user_permissions'] ) ) {
			if ( isset($curr_data['wfsm-select-product_cat']) && $curr_data['wfsm-select-product_cat'] !== null && is_array( $curr_data['wfsm-select-product_cat'] ) ) {

				$add_terms = array();

				foreach ( $curr_data['wfsm-select-product_cat'] as $curr_tax ) {

					$curr_slug = sanitize_title( $curr_tax );

					if ( in_array( 'product_new_terms' , self::$settings['user_permissions'] ) && !get_term_by( 'slug', $curr_slug, 'product_cat' ) ) {
						continue;
					}

					if ( !get_term_by( 'slug', $curr_slug, 'product_cat' ) ) {
						wp_insert_term( $curr_tax, 'product_cat', array( 'slug' => $curr_tax ) );
					}
					$add_terms[] = $curr_slug;
				}
				wp_set_object_terms( $curr_post_id, $add_terms, 'product_cat' );

			}
			else {
				wp_set_object_terms( $curr_post_id, array(), 'product_cat' );
			}
		}

		if ( !in_array( 'product_tag' , self::$settings['user_permissions'] ) ) {
			if ( isset($curr_data['wfsm-select-product_tag']) && $curr_data['wfsm-select-product_tag'] !== null && is_array( $curr_data['wfsm-select-product_tag'] ) ) {

				$add_terms = array();

				foreach ( $curr_data['wfsm-select-product_tag'] as $curr_tax ) {

					$curr_slug = sanitize_title( $curr_tax );

					if ( in_array( 'product_new_terms' , self::$settings['user_permissions'] ) && !get_term_by( 'slug', $curr_slug, 'product_tag' ) ) {
						continue;
					}

					if ( !get_term_by( 'slug', $curr_slug, 'product_tag' ) ) {
						wp_insert_term( $curr_tax, 'product_tag', array( 'slug' => $curr_tax ) );
					}
					$add_terms[] = $curr_slug;
				}
				wp_set_object_terms( $curr_post_id, $add_terms, 'product_tag' );

			}
			else {
				wp_set_object_terms( $curr_post_id, array(), 'product_tag' );
			}
		}


		$product_taxonomies = get_object_taxonomies( 'product' );
		$product_taxonomies = array_diff( $product_taxonomies, apply_filters( 'wfsm_restricted_taxonomies', array( 'product_cat', 'product_tag', 'product_visibility', 'product_type', 'product_shipping_class' ) ) );

		if ( !in_array( 'product_taxonomies' , self::$settings['user_permissions'] ) ) {
			foreach( $product_taxonomies as $product_taxonomy ) {
				if ( substr( $product_taxonomy, 0, 3 ) == 'pa_' ) {
					continue;
				}

				if ( isset($curr_data['wfsm-select-' . $product_taxonomy]) && $curr_data['wfsm-select-' . $product_taxonomy] !== null && is_array( $curr_data['wfsm-select-' . $product_taxonomy] ) ) {

					$add_terms = array();

					foreach ( $curr_data['wfsm-select-' . $product_taxonomy] as $curr_tax ) {

						$curr_slug = sanitize_title( $curr_tax );

						if ( in_array( 'product_new_terms' , self::$settings['user_permissions'] ) && !get_term_by( 'slug', $curr_slug, $product_taxonomy ) ) {
							continue;
						}

						if ( !get_term_by( 'slug', $curr_slug, $product_taxonomy ) ) {
							wp_insert_term( $curr_tax, $product_taxonomy, array( 'slug' => $curr_tax ) );
						}
						$add_terms[] = $curr_slug;
					}
					wp_set_object_terms( $curr_post_id, $add_terms, $product_taxonomy );

				}
				else {
					wp_set_object_terms( $curr_post_id, array(), $product_taxonomy );
				}

			}
		}

		if ( !in_array( 'product_attributes' , self::$settings['user_permissions'] ) ) {
			if ( isset($curr_data['wfsm-select-attributes']) && $curr_data['wfsm-select-attributes'] !== null && is_array( $curr_data['wfsm-select-attributes'] ) ) {

				global $wpdb;

				$add_terms = array();

				$i = 0;
				foreach ( $curr_data['wfsm-select-attributes'] as $curr_tax ) {

					$curr_slug = wc_sanitize_taxonomy_name( self::utf8_urldecode( $curr_tax ) );

					if ( in_array( 'product_new_terms' , self::$settings['user_permissions'] ) && !taxonomy_exists( $curr_slug ) ) {
						continue;
					}

					if ( substr($curr_slug, 0, 3) !== 'pa_' && !taxonomy_exists( $curr_slug ) ) {

						$curr_slug_sanitized = sanitize_title( wc_sanitize_taxonomy_name( $curr_tax ) );

						$curr_attribute = array(
							'attribute_label'   => ucfirst( $curr_tax ),
							'attribute_name'    => $curr_slug,
							'attribute_type'    => 'select',
							'attribute_orderby' => 'menu_order',
							'attribute_public'  => 0
						);

						$wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $curr_attribute );

						$add_terms['pa_' . $curr_slug_sanitized] = array(
							'name' => 'pa_' . $curr_slug,
							'value' => '',
							'position' => $i,
							'is_visible' => ( isset( $curr_data['wfsm-visible-pa_' . $curr_slug_sanitized] ) && $curr_data['wfsm-visible-pa_' . $curr_slug_sanitized] == 'isvisible' ? '1' : '0' ),
							'is_variation' => ( isset( $curr_data['wfsm-variation-pa_' . $curr_slug_sanitized] ) && $curr_data['wfsm-variation-pa_' . $curr_slug_sanitized] == 'isvariation' ? '1' : '0' ),
							'is_taxonomy' => '1'
						);

						$curr_tax_args = array(
							'label' => ucfirst($curr_tax),
							'rewrite' => array( 'slug' => 'pa_' . $curr_slug ),
							'hierarchical' => true
						);
						register_taxonomy( 'pa_' . $curr_slug, 'product', $curr_tax_args );

						$refresh = 'added';
						$i++;
					}
					else if ( substr($curr_slug, 0, 3) == 'pa_' && taxonomy_exists( $curr_slug ) ) {

						$curr_slug_sanitized = $curr_tax;

						$add_terms[$curr_slug_sanitized] = array(
							'name' => $curr_slug,
							'value' => '',
							'position' => $i,
							'is_visible' => ( isset( $curr_data['wfsm-visible-' . $curr_slug_sanitized] ) && $curr_data['wfsm-visible-' . $curr_slug_sanitized] == 'isvisible' ? '1' : '0' ),
							'is_variation' => ( isset( $curr_data['wfsm-variation-' . $curr_slug_sanitized] ) && $curr_data['wfsm-variation-' . $curr_slug_sanitized] == 'isvariation' ? '1' : '0' ),
							'is_taxonomy' => '1'
						);
						$i++;
					}

				}

				if ( isset($refresh) ) {
					delete_transient( 'wc_attribute_taxonomies' );
				}

				update_post_meta( $curr_post_id, '_product_attributes', $add_terms );

				foreach ($add_terms as $tax_key => $tax) {

					$curr_paname = $tax['name'];
					$curr_paname_sanitized = $tax_key;

					if ( $curr_data['wfsm-select-' . $curr_paname_sanitized] !== null && is_array( $curr_data['wfsm-select-' . $curr_paname_sanitized] ) ) {
						$add_terms = array();

						foreach ( $curr_data['wfsm-select-' . $curr_paname_sanitized] as $curr_tax ) {

							$curr_slug = sanitize_title( $curr_tax );

							if ( in_array( 'product_new_terms' , self::$settings['user_permissions'] ) && !get_term_by( 'slug', $curr_slug, $curr_paname_sanitized ) ) {
								continue;
							}

							if ( !get_term_by( 'slug', $curr_slug, $curr_paname ) ) {
								wp_insert_term( $curr_tax, $curr_paname, array( 'slug' => $curr_slug ) );
							}
							$add_terms[] = $curr_slug;
						}
						wp_set_object_terms( $curr_post_id, $add_terms, $curr_paname );

					}
					else {
						wp_set_object_terms( $curr_post_id, array(), $curr_paname );
					}

				}

			}
			else if ( isset($curr_data['wfsm-select-attributes']) && $curr_data['wfsm-select-attributes'] === null ) {
				update_post_meta( $curr_post_id, '_product_attributes', array() );
			}
		}


		if ( !in_array( 'variable_edit_variations' , self::$settings['user_permissions'] ) && isset($curr_data['wfsm-variations-ids']) && is_array($curr_data['wfsm-variations-ids']) ) {

			$curr_variable_count = 0;
			global $wpdb;

			foreach ( $curr_data['wfsm-variations-ids'] as $curr_variation ) {

				$variation_post_title = sprintf( esc_html__( 'Variation #%s of %s', 'woocommerce-frontend-shop-manager' ), absint( $curr_variation ), esc_html( get_the_title( $curr_post_id ) ) );

				$wpdb->update( $wpdb->posts, array( 'post_title' => $variation_post_title, 'menu_order' => $curr_variable_count ), array( 'ID' => $curr_variation ) );

				do_action( 'woocommerce_update_product_variation', $curr_variation );

				if ( !in_array( 'variable_product_attributes' , self::$settings['user_permissions'] ) ) {

					$attributes = (array) maybe_unserialize( get_post_meta( $curr_post_id, '_product_attributes', true ) );

					$updated_attribute_keys = array();
					foreach ( $attributes as $attribute ) {

						if ( $attribute['is_variation'] ) {

							$attribute_key = 'attribute_' . sanitize_title( $attribute['name'] );

							$value = isset( $curr_data[ 'wfsm-attribute-' . $curr_variation . '-' . sanitize_title( $attribute['name'] ) ] ) ? $curr_data[ 'wfsm-attribute-' . $curr_variation . '-' . sanitize_title( stripslashes( $attribute['name'] ) ) ] : '';

							$updated_attribute_keys[] = $attribute_key;

							update_post_meta( $curr_variation, $attribute_key, $value );

						}
					}

					$delete_attribute_keys = $wpdb->get_col( $wpdb->prepare( "SELECT meta_key FROM {$wpdb->postmeta} WHERE meta_key LIKE 'attribute_%%' AND meta_key NOT IN ( '" . implode( "','", $updated_attribute_keys ) . "' ) AND post_id = %d;", $curr_variation ) );

					foreach ( $delete_attribute_keys as $key ) {
						delete_post_meta( $curr_variation, $key );
					}

				}

				$curr_variable_count++;

			}

		}

		$curr_data = apply_filters( 'wfsm_before_product_save', $curr_data );

		self::wfsm_save_product_data( $curr_post_id, $save_post , $curr_data, $product_type );

		do_action( 'wfsm_save_product', $curr_post_id, $curr_data );

		$wfsm_settings = strpos( $_POST['wfsm_loop'], '|' ) ? explode( '|', $_POST['wfsm_loop'] ) : $_POST['wfsm_loop'];

		$out = '1';

		if ( $_POST['wfsm_loop'] !== 'single' && is_array( $wfsm_settings ) ) {

			global $woocommerce_loop;

			if ( is_array( $wfsm_settings ) ) {
				$woocommerce_loop = array(
					'loop' => $wfsm_settings[0]-1,
					'columns' => $wfsm_settings[1]
				);
			}

			$curr_products = new WP_Query( array( 'post_type' => 'product', 'post__in' => array( $curr_post_id ) ) );

			ob_start();

			if ( $curr_products->have_posts() ) {

				while ( $curr_products->have_posts() ) : $curr_products->the_post();

					if ( $_POST['wfsm_loop'] !== 'single' ) {
						wc_get_template_part( 'content', 'product' );
					}
					else {
						$out = 'single';
					}

				endwhile;

			}

			$out = ob_get_clean();

		}

		die($out);
		exit;
	}

	function wfsm_clone() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset($_POST) && isset( $_POST['wfsm_id'] ) ) {
			$curr_post_id = intval( stripslashes( $_POST['wfsm_id'] ) );
			if ( get_post_status( $curr_post_id ) === false ) {
				die( 'Error!' );
				exit;
			}
		}
		else {
			die( 'Error!' );
			exit;
		}

		$curr_post_author = self::wfsm_check_premissions( $curr_post_id );

		if ( $curr_post_author === false ) {
			die( 'Error!' );
			exit;
		}

		$post = self::wfsm_get_product_to_duplicate( $curr_post_id );

		$duplicate = self::wfsm_duplicate_product( $post );

		die('1');
		exit;

	}

	function wfsm_trash() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset($_POST) && isset( $_POST['wfsm_id'] ) ) {
			$curr_post_id = intval( stripslashes( $_POST['wfsm_id'] ) );
			if ( get_post_status( $curr_post_id ) === false ) {
				die( 'Error!' );
				exit;
			}
		}
		else {
			die( 'Error!' );
			exit;
		}

		$curr_post_author = self::wfsm_check_premissions( $curr_post_id );

		if ( $curr_post_author === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset( $_POST['wfsm_mode'] ) && $_POST['wfsm_mode'] == 'variation' ) {
			wp_delete_post($curr_post_id);
		}
		else {
			wp_trash_post($curr_post_id);
		}

		die('1');
		exit;

	}

	function wfsm_editor() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset($_POST) && isset( $_POST['wfsm_id'] ) ) {
			$curr_post_id = intval( stripslashes( $_POST['wfsm_id'] ) );
			if ( get_post_status( $curr_post_id ) === false ) {
				die( 'Error!' );
				exit;
			}
		}
		else {
			die( 'Error!' );
			exit;
		}

		$curr_post_author = self::wfsm_check_premissions( $curr_post_id );

		if ( $curr_post_author === false ) {
			die( 'Error!' );
			exit;
		}

		$post = get_post( $curr_post_id, OBJECT, 'edit' );

		if ( $_POST['wfsm_mode'] == 'content' ) {
			$content = $post->post_content;
		}
		else {
			$content = $post->post_excerpt;
		}

		ob_start();

	?>
		<div class="wfsm-editor-buttons" data-id="<?php echo esc_attr( $curr_post_id ); ?>" data-mode="<?php echo esc_attr( $_POST['wfsm_mode'] ); ?>">
			<a href="#" class="wfsm-editor-add-image" title="<?php esc_html_e( 'Add image', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-image"></i></a>
			<a href="#" class="wfsm-editor-save" title="<?php esc_html_e( 'Save changes', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-save"></i></a>
			<a href="#" class="wfsm-editor-discard" title="<?php esc_html_e( 'Discard changes', 'woocommerce-frontend-shop-manager' ); ?>"><i class="wfsmico-discard"></i></a>
		</div>
		<div id="wfsm-the-editor">
			<textarea id="wfsm-tinymce"><?php echo wp_kses_post( $content ); ?></textarea>
		</div>

	<?php
		$out = ob_get_clean();

		die( $out );
		exit;

	}

	function wfsm_editor_save() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset($_POST) && isset( $_POST['wfsm_id'] ) ) {
			$curr_post_id = intval( stripslashes( $_POST['wfsm_id'] ) );
			if ( get_post_status( $curr_post_id ) === false ) {
				die( 'Error!' );
				exit;
			}
		}
		else {
			die( 'Error!' );
			exit;
		}

		$curr_post_author = self::wfsm_check_premissions( $curr_post_id );

		if ( $curr_post_author === false ) {
			die( 'Error!' );
			exit;
		}

		$curr_args = array(
			'ID' => $curr_post_id
		);

		if ( $_POST['wfsm_mode'] == 'content' ) {
			$curr_args['post_content'] = $_POST['wfsm_content'];
		}
		else {
			$curr_args['post_excerpt'] = $_POST['wfsm_content'];
		}

		wp_update_post( $curr_args );

		die('1');
		exit;

	}

	function wfsm_create_attribute() {

		if ( ( defined('DOING_AJAX') && DOING_AJAX ) === false ) {
			die( 'Error!' );
			exit;
		}

		if ( isset($_POST) && isset( $_POST['wfsm_id'] ) ) {
			$curr_post_id = intval( stripslashes( $_POST['wfsm_id'] ) );
			if ( get_post_status( $curr_post_id ) === false ) {
				die( 'Error!' );
				exit;
			}
		}
		else {
			die( 'Error!' );
			exit;
		}

		$curr_post_author = self::wfsm_check_premissions( $curr_post_id );

		if ( $curr_post_author === false ) {
			die( 'Error!' );
			exit;
		}

		$product = wc_get_product( $curr_post_id );

			ob_start();

			$curr_slug = wc_sanitize_taxonomy_name( $_POST['wfsm_add'] );

			if ( substr($curr_slug, 0, 3) !== 'pa_' && !taxonomy_exists( $curr_slug ) ) {
				$curr_name = ucfirst( $curr_slug );
				$curr_paname = 'pa_' . $curr_slug;
				$curr_paname_desanitized = esc_attr( 'pa_' . sanitize_title ( $curr_slug ) ); // OK
			}
			else if ( substr($curr_slug, 0, 3) == 'pa_' && taxonomy_exists( $curr_slug ) ) {
				$tax = get_taxonomy( $curr_slug );
				$curr_name = $tax->label;
				$curr_paname = $curr_slug;
				$curr_paname_desanitized = esc_attr( sanitize_title( $tax->name ) ); // OK
			}
		?>
			<div class="wfsm-attribute-<?php echo esc_attr( $curr_paname_desanitized ); ?>">
				<label for="wfsm-select-<?php echo esc_attr( $curr_paname_desanitized ); ?>" class="wfsm-selectize">
					<span><?php echo esc_html__( 'Product', 'woocommerce-frontend-shop-manager' ) . ' ' . esc_html( $curr_name ); ?></span>
					<select id="wfsm-select-<?php echo esc_attr( $curr_paname_desanitized ); ?>" name="wfsm-select-<?php echo esc_attr( $curr_paname_desanitized ); ?>" class="wfsm-collect-data" multiple="multiple">
					<?php
							if ( isset($tax) ) {
							$product_atts = wp_get_post_terms( $curr_post_id, $curr_paname, array( 'fields' => 'slugs' ) );
							foreach( get_terms($curr_paname,'hide_empty=0') as $term ) {
								$wfsm_selected = in_array( $term->slug , $product_atts ) ? 'added' : 'notadded' ;
							?>
								<option <?php echo ( $wfsm_selected == 'added' ? ' selected="selected"' : '' ); ?> value="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></option>
							<?php
							}
						}

					?>
					</select>
				</label>
			<?php
				$product_attributes = $product->get_attributes();
				$curr_value = ( ( isset( $product_attributes[$curr_paname_desanitized]) && $product_attributes[$curr_paname_desanitized]['is_visible'] == 1 ) ? 'isvisible' : 'notvisible' ); // OK
			?>
				<label for="wfsm-visible-<?php echo esc_attr( $curr_paname_desanitized ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $curr_value ); ?>">
					<span class="wfsm-show-isvisible"><?php esc_html_e( 'Attribute is visible on product page', 'woocommerce-frontend-shop-manager' ); ?></span>
					<span class="wfsm-show-notvisible"><?php esc_html_e( 'Attribute is not visible on product page', 'woocommerce-frontend-shop-manager' ); ?></span>
					<input id="wfsm-visible-<?php echo esc_attr( $curr_paname_desanitized ); ?>" name="wfsm-visible-<?php echo esc_attr( $curr_paname_desanitized ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $curr_value ); ?>"/>
				</label>
			<?php
				if ( $product->is_type( 'variable' ) ) {
					$curr_value = ( ( isset( $product_attributes[$curr_paname_desanitized]) && $product_attributes[$curr_paname_desanitized]['is_variation'] == 1 ) ? 'isvariation' : 'notvariation' ); // OK
			?>
				<label for="wfsm-variation-<?php echo esc_attr( $curr_paname_desanitized ); ?>" class="wfsm-label-checkbox wfsm-<?php echo esc_attr( $curr_value ); ?>">
					<span class="wfsm-show-isvariation"><?php esc_html_e( 'Attribute is used in variations', 'woocommerce-frontend-shop-manager' ); ?></span>
					<span class="wfsm-show-notvariation"><?php esc_html_e( 'Attribute is not used in variations', 'woocommerce-frontend-shop-manager' ); ?></span>
					<input id="wfsm-variation-<?php echo esc_attr( $curr_paname_desanitized ); ?>" name="wfsm-variation-<?php echo esc_attr( $curr_paname_desanitized ); ?>" class="wfsm-reset-this wfsm-collect-data" type="hidden" value="<?php echo esc_attr( $curr_value ); ?>"/>
				</label>
			<?php
				}
		?>
			</div>
		<?php

			$out = ob_get_clean();

			die($out);
			exit;

	}

	public static function wfsm_duplicate_product( $post, $parent = 0, $post_status = '' ) {

		global $wpdb;

		$new_post_author    = get_current_user_id();
		$new_post_date      = current_time( 'mysql' );
		$new_post_date_gmt  = get_gmt_from_date( $new_post_date );

		if ( $parent > 0 ) {
			$post_parent        = $parent;
			$post_status        = $post_status ? $post_status : 'publish';
			$suffix             = '';
		} else {
			$post_parent        = $post->post_parent;
			$post_status        = $post_status ? $post_status : 'draft';
			$suffix             = ' ' . esc_html__( '(Copy)', 'woocommerce-frontend-shop-manager' );
		}

		$wpdb->insert(
			$wpdb->posts,
			array(
				'post_author'               => $new_post_author,
				'post_date'                 => $new_post_date,
				'post_date_gmt'             => $new_post_date_gmt,
				'post_content'              => $post->post_content,
				'post_content_filtered'     => $post->post_content_filtered,
				'post_title'                => $post->post_title . $suffix,
				'post_excerpt'              => $post->post_excerpt,
				'post_status'               => $post_status,
				'post_type'                 => $post->post_type,
				'comment_status'            => $post->comment_status,
				'ping_status'               => $post->ping_status,
				'post_password'             => $post->post_password,
				'to_ping'                   => $post->to_ping,
				'pinged'                    => $post->pinged,
				'post_modified'             => $new_post_date,
				'post_modified_gmt'         => $new_post_date_gmt,
				'post_parent'               => $post_parent,
				'menu_order'                => $post->menu_order,
				'post_mime_type'            => $post->post_mime_type
			)
		);

		$new_post_id = $wpdb->insert_id;

		$post_type = $post->post_type;

		$taxonomies = get_object_taxonomies( $post_type );

		foreach ( $taxonomies as $taxonomy ) {

			$post_terms = wp_get_object_terms( $post->ID, $taxonomy );
			$post_terms_count = sizeof( $post_terms );

			for ( $i=0; $i<$post_terms_count; $i++ ) {
				wp_set_object_terms( $new_post_id, $post_terms[$i]->slug, $taxonomy, true );
			}
		}

		$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=%d AND meta_key NOT IN ( 'total_sales' );", absint( $post->ID ) ) );

		if ( count( $post_meta_infos ) != 0 ) {

			$sql_query_sel = array();
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";

			foreach ( $post_meta_infos as $meta_info ) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes( $meta_info->meta_value );
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}

			$sql_query.= implode( " UNION ALL ", $sql_query_sel );
			$wpdb->query($sql_query);
		}

		if ( $children_products = get_children( 'post_parent=' . $post->ID . '&post_type=product_variation' ) ) {

			if ( $children_products ) {

				foreach ( $children_products as $child ) {
					self::wfsm_duplicate_product( self::wfsm_get_product_to_duplicate( $child->ID ), $new_post_id, $child->post_status );
				}
			}
		}

		update_post_meta( $new_post_id, '_visibility', 'visible' );

		do_action( 'woocommerce_duplicate_product', $new_post_id, $post );

		return $new_post_id;
	}

	public static function wfsm_get_product_to_duplicate( $id ) {
		global $wpdb;

		$id = absint( $id );

		if ( ! $id ) {
			return false;
		}

		$post = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID=%d", absint( $id ) ) );

		if ( isset( $post->post_type ) && $post->post_type == "revision" ) {
			$id   = $post->post_parent;
			$post = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID=%d", absint( $id ) ) );
		}

		return $post[0];
	}

	public static function wfsm_check_premissions( $curr_post_id ) {

		$curr_post_author = absint( get_post_field( 'post_author', $curr_post_id ) );

		$curr_logged_user = get_current_user_id();

		$curr_user = get_user_by( 'id', $curr_logged_user );

		if ( $curr_user->has_cap( 'administrator' ) || $curr_user->has_cap( 'manage_woocommerce' ) ) {
			$curr_admin = true;
		}

		if ( !isset( $curr_admin ) && absint( $curr_post_author ) !== $curr_logged_user ) {
			return false;
		}
		else {
			return $curr_post_author;
		}

	}

	public static function product_exist( $sku ) {
		global $wpdb;
		$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value= %s LIMIT 1", $sku ) );
		return $product_id;
	}
	
	public static function utf8_urldecode($str) {
		$str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
		return html_entity_decode($str,null,'UTF-8');
	}

	function wfsm_save_product_data( $post_id, $post, $curr_data, $product_type ) {

		global $wpdb;

		add_post_meta( $post_id, 'total_sales', '0', true );

		if ( !in_array( 'product_prices' , self::$settings['user_permissions'] ) ) {
			if ( isset( $curr_data['wfsm-regular-price'] ) ) {
				update_post_meta( $post_id, '_regular_price', ( $curr_data['wfsm-regular-price'] === '' ) ? '' : wc_format_decimal( $curr_data['wfsm-regular-price'] ) );
			}

			if ( isset( $curr_data['wfsm-sale-price'] ) ) {
				update_post_meta( $post_id, '_sale_price', ( $curr_data['wfsm-sale-price'] === '' ? '' : wc_format_decimal( $curr_data['wfsm-sale-price'] ) ) );
			}

			if ( '' !== $curr_data['wfsm-sale-price'] ) {
				update_post_meta( $post_id, '_price', wc_format_decimal( $curr_data['wfsm-sale-price'] ) );
			} else {
				update_post_meta( $post_id, '_price', ( $curr_data['wfsm-regular-price'] === '' ) ? '' : wc_format_decimal( $curr_data['wfsm-regular-price'] ) );
			}

		}


		if ( !in_array( 'product_taxes' , self::$settings['user_permissions'] ) ) {
			if ( isset( $curr_data['wfsm-tax-status'] ) ) {
				update_post_meta( $post_id, '_tax_status', wc_clean( $curr_data['wfsm-tax-status'] ) );
			}

			if ( isset( $curr_data['wfsm-tax-class'] ) ) {
				update_post_meta( $post_id, '_tax_class', wc_clean( $curr_data['wfsm-tax-class'] ) );
			}
		}

		if ( !in_array( 'product_note' , self::$settings['user_permissions'] ) ) {
			if ( isset( $curr_data['wfsm-purchase-note'] ) ) {
				update_post_meta( $post_id, '_purchase_note', wp_kses_post( stripslashes( $curr_data['wfsm-purchase-note'] ) ) );
			}
		}

		if ( !in_array( 'product_feature' , self::$settings['user_permissions'] ) ) {
			if ( XforWC_Live_Editor::version_check() ) {
				if ( $curr_data['wfsm-featured'] == 'yes' ) {
					if ( ! is_wp_error( wp_set_post_terms( $post_id, array( 'featured' ), 'product_visibility', true ) ) ) {
						delete_transient( 'wc_featured_products' );
					}
				}
				else {
					wp_remove_object_terms( $post_id, 'featured', 'product_visibility' );
					delete_transient( 'wc_featured_products' );
				}
			}
			else {
				if ( update_post_meta( $post_id, '_featured', isset( $curr_data['wfsm-featured'] ) && $curr_data['wfsm-featured'] == 'yes' ? 'yes' : 'no' ) ) {
					delete_transient( 'wc_featured_products' );
				}
			}

		}

		$is_virtual = isset( $curr_data['wfsm-virtual'] ) && $curr_data['wfsm-virtual'] == 'yes' ? 'yes' : 'no';

		if ( !in_array( 'product_virtual' , self::$settings['user_permissions'] ) ) {
			update_post_meta( $post_id, '_virtual', $is_virtual );
		}

		if ( !in_array( 'product_shipping' , self::$settings['user_permissions'] ) ) {
			if ( 'no' == $is_virtual ) {

				if ( isset( $curr_data['wfsm-weight'] ) ) {
					update_post_meta( $post_id, '_weight', ( '' === $curr_data['wfsm-weight'] ) ? '' : wc_format_decimal( $curr_data['wfsm-weight'] ) );
				}

				if ( isset( $curr_data['wfsm-length'] ) ) {
					update_post_meta( $post_id, '_length', ( '' === $curr_data['wfsm-length'] ) ? '' : wc_format_decimal( $curr_data['wfsm-length'] ) );
				}

				if ( isset( $curr_data['wfsm-width'] ) ) {
					update_post_meta( $post_id, '_width', ( '' === $curr_data['wfsm-width'] ) ? '' : wc_format_decimal( $curr_data['wfsm-width'] ) );
				}

				if ( isset( $curr_data['wfsm-height'] ) ) {
					update_post_meta( $post_id, '_height', ( '' === $curr_data['wfsm-height'] ) ? '' : wc_format_decimal( $curr_data['wfsm-height'] ) );
				}

			} else {
				update_post_meta( $post_id, '_weight', '' );
				update_post_meta( $post_id, '_length', '' );
				update_post_meta( $post_id, '_width', '' );
				update_post_meta( $post_id, '_height', '' );
			}

			$product_shipping_class = $curr_data['wfsm-shipping-class'] > 0 && $product_type != 'external' ? absint( $curr_data['wfsm-shipping-class'] ) : '';
			wp_set_object_terms( $post_id, $product_shipping_class, 'product_shipping_class');
		}

		if ( !in_array( 'product_sku' , self::$settings['user_permissions'] ) ) {
			$sku     = get_post_meta( $post_id, '_sku', true );
			$new_sku = wc_clean( stripslashes( $curr_data['wfsm-sku'] ) );

			if ( '' == $new_sku ) {
				update_post_meta( $post_id, '_sku', '' );
			} elseif ( $new_sku !== $sku ) {

				if ( ! empty( $new_sku ) ) {

					$unique_sku = wc_product_has_unique_sku( $post_id, $new_sku );

					if ( ! $unique_sku ) {
					} else {
						update_post_meta( $post_id, '_sku', $new_sku );
					}

					if ( $unique_sku ) {
						update_post_meta( $post_id, '_sku', $new_sku );
					}

				} else {
					update_post_meta( $post_id, '_sku', '' );
				}
			}
		}

		if ( !in_array( 'product_schedule_sale' , self::$settings['user_permissions'] ) ) {
			if ( in_array( $product_type, array( 'variable', 'grouped' ) ) ) {

				update_post_meta( $post_id, '_regular_price', '' );
				update_post_meta( $post_id, '_sale_price', '' );
				update_post_meta( $post_id, '_sale_price_dates_from', '' );
				update_post_meta( $post_id, '_sale_price_dates_to', '' );
				update_post_meta( $post_id, '_price', '' );

			} else {

				$date_from = isset( $curr_data['wfsm-schedule-sale-start'] ) ? wc_clean( $curr_data['wfsm-schedule-sale-start'] ) : '';
				$date_to   = isset( $curr_data['wfsm-schedule-sale-end'] ) ? wc_clean( $curr_data['wfsm-schedule-sale-end'] ) : '';

				if ( $date_from ) {
					update_post_meta( $post_id, '_sale_price_dates_from', strtotime( $date_from ) );
				} else {
					update_post_meta( $post_id, '_sale_price_dates_from', '' );
				}

				if ( $date_to ) {
					update_post_meta( $post_id, '_sale_price_dates_to', strtotime( $date_to ) );
				} else {
					update_post_meta( $post_id, '_sale_price_dates_to', '' );
				}

				if ( $date_to && ! $date_from ) {
					update_post_meta( $post_id, '_sale_price_dates_from', strtotime( 'NOW', current_time( 'timestamp' ) ) );
				}

				if ( '' !== $curr_data['wfsm-sale-price'] && '' == $date_to && '' == $date_from ) {
					update_post_meta( $post_id, '_price', wc_format_decimal( $curr_data['wfsm-sale-price'] ) );
				} else {
					update_post_meta( $post_id, '_price', ( $curr_data['wfsm-regular-price'] === '' ) ? '' : wc_format_decimal( $curr_data['wfsm-regular-price'] ) );
				}

				if ( '' !== $curr_data['wfsm-sale-price'] && $date_from && strtotime( $date_from ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
					update_post_meta( $post_id, '_price', wc_format_decimal( $curr_data['wfsm-sale-price'] ) );
				}

				if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
					update_post_meta( $post_id, '_price', ( $curr_data['wfsm-regular-price'] === '' ) ? '' : wc_format_decimal( $curr_data['wfsm-regular-price'] ) );
					update_post_meta( $post_id, '_sale_price_dates_from', '' );
					update_post_meta( $post_id, '_sale_price_dates_to', '' );
				}
			}
		}

		if ( !in_array( 'product_grouping' , self::$settings['user_permissions'] ) ) {
			if ( $post->post_parent > 0 || 'grouped' == $product_type || $curr_data['wfsm-grouping'] > 0 ) {

				$clear_parent_ids = array();

				if ( $post->post_parent > 0 ) {
					$clear_parent_ids[] = $post->post_parent;
				}

				if ( 'grouped' == $product_type ) {
					$clear_parent_ids[] = $post_id;
				}

				if ( $curr_data['wfsm-grouping'] > 0 ) {
					$clear_parent_ids[] = absint( $curr_data['wfsm-grouping'] );
				}

				if ( $clear_parent_ids ) {
					foreach ( $clear_parent_ids as $clear_id ) {
						$children_by_price = get_posts( array(
							'post_parent'    => $clear_id,
							'orderby'        => 'meta_value_num',
							'order'          => 'asc',
							'meta_key'       => '_price',
							'posts_per_page' => 1,
							'post_type'      => 'product',
							'fields'         => 'ids'
						) );

						if ( $children_by_price ) {
							foreach ( $children_by_price as $child ) {
								$child_price = get_post_meta( $child, '_price', true );
								update_post_meta( $clear_id, '_price', $child_price );
							}
						}

						wc_delete_product_transients( $clear_id );
					}
				}
			}
		}

		if ( !in_array( 'product_grouping' , self::$settings['user_permissions'] ) ) {
			if ( isset( $curr_data['wfsm-sold-individually'] ) && $curr_data['wfsm-sold-individually'] == 'yes' ) {
				update_post_meta( $post_id, '_sold_individually', 'yes' );
			} else {
				update_post_meta( $post_id, '_sold_individually', '' );
			}
		}

		if ( !in_array( 'product_stock' , self::$settings['user_permissions'] ) ) {

			if ( !isset( $curr_data['wfsm-product-stock'] ) ) {
				$curr_data['wfsm-product-stock'] = '';
			}
			if ( 'yes' === get_option( 'woocommerce_manage_stock' ) ) {

				$manage_stock = 'no';
				$backorders   = 'no';
				$stock_status = wc_clean( $curr_data['wfsm-product-stock'] );

				if ( 'external' === $product_type ) {

					$stock_status = 'instock';

				} elseif ( 'variable' === $product_type ) {

					$stock_status = '';

					if ( $curr_data['wfsm-manage-stock-quantity'] == 'yes' ) {
						$manage_stock = 'yes';
						$backorders   = wc_clean( $curr_data['wfsm-backorders'] );
					}

				} elseif ( 'grouped' !== $product_type && $curr_data['wfsm-manage-stock-quantity'] == 'yes' ) {
					$manage_stock = 'yes';
					$backorders   = wc_clean( $curr_data['wfsm-backorders'] );
				}

				update_post_meta( $post_id, '_manage_stock', $manage_stock );
				update_post_meta( $post_id, '_backorders', $backorders );

				if ( $stock_status ) {
					wc_update_product_stock_status( $post_id, $stock_status );
				}

				if ( $curr_data['wfsm-manage-stock-quantity'] == 'yes' ) {
					wc_update_product_stock( $post_id, wc_stock_amount( $curr_data['wfsm-stock-quantity'] ) );
				} else {
					update_post_meta( $post_id, '_stock', '' );
				}

			} else {
				wc_update_product_stock_status( $post_id, wc_clean( $curr_data['wfsm-product-stock'] ) );
			}
		}

		$is_downloadable = isset( $curr_data['wfsm-downloadable'] ) && $curr_data['wfsm-downloadable'] == 'yes' ? 'yes' : 'no';

		if ( !in_array( 'product_downloadable' , self::$settings['user_permissions'] ) ) {
			update_post_meta( $post_id, '_downloadable', $is_downloadable );
		}

		if ( !in_array( 'product_downloads' , self::$settings['user_permissions'] ) ) {

			if ( 'yes' == $is_downloadable ) {

				$_download_limit = isset( $curr_data['wfsm-download-limit'] ) ? absint( $curr_data['wfsm-download-limit'] ) : null;
				if ( ! $_download_limit ) {
					$_download_limit = '';
				}

				$_download_expiry = isset( $curr_data['wfsm-download-expiry'] ) ? absint( $curr_data['wfsm-download-expiry'] ) : null;
				if ( ! $_download_expiry ) {
					$_download_expiry = '';
				}

				$files = array();

				if ( isset( $curr_data['wfsm-file-urls'] ) ) {
					$file_names         = isset( $curr_data['wfsm-file-names'] ) ? $curr_data['wfsm-file-names'] : array();
					$file_urls          = isset( $curr_data['wfsm-file-urls'] )  ? array_map( 'trim', $curr_data['wfsm-file-urls'] ) : array();
					$file_url_size      = sizeof( $file_urls );
					$allowed_file_types = get_allowed_mime_types();

					for ( $i = 0; $i < $file_url_size; $i ++ ) {
						if ( ! empty( $file_urls[ $i ] ) ) {

							if ( 0 === strpos( $file_urls[ $i ], 'http' ) ) {
								$file_is  = 'absolute';
								$file_url = esc_url_raw( $file_urls[ $i ] );
							} elseif ( '[' === substr( $file_urls[ $i ], 0, 1 ) && ']' === substr( $file_urls[ $i ], -1 ) ) {
								$file_is  = 'shortcode';
								$file_url = wc_clean( $file_urls[ $i ] );
							} else {
								$file_is = 'relative';
								$file_url = wc_clean( $file_urls[ $i ] );
							}

							$file_name = wc_clean( $file_names[ $i ] );
							$file_hash = md5( $file_url );

							if ( in_array( $file_is, array( 'absolute', 'relative' ) ) ) {
								$file_type  = wp_check_filetype( strtok( $file_url, '?' ) );
								$parsed_url = parse_url( $file_url, PHP_URL_PATH );
								$extension  = pathinfo( $parsed_url, PATHINFO_EXTENSION );

								if ( ! empty( $extension ) && ! in_array( $file_type['type'], $allowed_file_types ) ) {
									continue;
								}
							}

							if ( 'relative' === $file_is ) {
								$_file_url = '..' === substr( $file_url, 0, 2 ) ? realpath( ABSPATH . $file_url ) : $file_url;

								if ( ! apply_filters( 'woocommerce_downloadable_file_exists', file_exists( $_file_url ), $file_url ) ) {
									continue;
								}
							}

							$files[ $file_hash ] = array(
								'name' => $file_name,
								'file' => $file_url
							);
						}
					}
				}

				do_action( 'woocommerce_process_product_file_download_paths', $post_id, 0, $files );

				update_post_meta( $post_id, '_downloadable_files', $files );

				if ( !in_array( 'product_download_settings' , self::$settings['user_permissions'] ) ) {
					update_post_meta( $post_id, '_download_limit', $_download_limit );
					update_post_meta( $post_id, '_download_expiry', $_download_expiry );

					if ( isset( $curr_data['wfsm-download-type'] ) ) {
						update_post_meta( $post_id, '_download_type', wc_clean( $curr_data['wfsm-download-type'] ) );
					}
				}
			}
		}

		if ( 'external' == $product_type ) {

			if ( !in_array( 'external_product_url' , self::$settings['user_permissions'] ) ) {
				if ( isset( $curr_data['wfsm-product-http'] ) ) {
					update_post_meta( $post_id, '_product_url', esc_url_raw( $curr_data['wfsm-product-http'] ) );
				}
			}

			if ( !in_array( 'external_button_text' , self::$settings['user_permissions'] ) ) {
				if ( isset( $curr_data['wfsm-button-text'] ) ) {
					update_post_meta( $post_id, '_button_text', wc_clean( $curr_data['wfsm-button-text'] ) );
				}
			}
		}

		$custom_settings = self::$settings['custom_settings'];

		if ( !empty( $custom_settings ) ) {

			foreach( $custom_settings as $k => $v ) {
				$name = sanitize_title( $v['name'] );
				if ( !in_array( $name, self::$settings['user_permissions'] ) ) {
					for( $i = 0; $i < count( $v['key'] ); $i++ ) {
						if ( in_array( $v['type'][$i], array( 'input', 'textarea', 'checkbox', 'select' ) ) ) {
							$opt_name = sanitize_title( $v['setting-name'][$i] );
							if ( isset( $curr_data['wfsm-cs-' . $opt_name] ) ) {
								update_post_meta( $post_id, $v['key'][$i], wc_clean( $curr_data['wfsm-cs-' . $opt_name] ) );
							}
						}
					}
				}
			}

		}

		if ( 'variable' == $product_type ) {
			self::save_variation_product_data( $post_id, $post, $curr_data );
		}

		do_action( 'woocommerce_process_product_meta_' . $product_type, $post_id );

		wc_delete_product_transients( $post_id );

	}

	public static function save_variation_product_data( $post_id, $post, $curr_data ) {

		global $wpdb;

		$attributes = (array) maybe_unserialize( get_post_meta( $post_id, '_product_attributes', true ) );

		if ( isset( $curr_data['wfsm-variations-ids'] ) ) {

			$variable_post_id               = $curr_data['wfsm-variations-ids'];

			$max_loop = max( array_keys( $variable_post_id ) );

			for ( $i = 0; $i <= $max_loop; $i ++ ) {
				if ( ! isset( $variable_post_id[ $i ] ) ) {
					continue;
				}

				$variation_id = absint( $variable_post_id[ $i ] );

				$variable_sku[$i]                   = isset( $curr_data['wfsm-sku-' . $variation_id] ) ? $curr_data['wfsm-sku-' . $variation_id] : '';
				$variable_regular_price[$i]         = isset( $curr_data['wfsm-regular-price-' . $variation_id] ) ? $curr_data['wfsm-regular-price-' . $variation_id] : '';
				$variable_sale_price[$i]            = isset( $curr_data['wfsm-sale-price-' . $variation_id] ) ? $curr_data['wfsm-sale-price-' . $variation_id] : '';
				$upload_image_id[$i]                = isset( $curr_data['wfsm-featured-image-' . $variation_id] ) ? $curr_data['wfsm-featured-image-' . $variation_id] : '';
				$variable_download_limit[$i]        = isset( $curr_data['wfsm-download-limit-' . $variation_id] ) ? $curr_data['wfsm-download-limit-' . $variation_id] : '';
				$variable_download_expiry[$i]       = isset( $curr_data['wfsm-download-expiry-' . $variation_id] ) ? $curr_data['wfsm-download-expiry-' . $variation_id] : '';
				$variable_shipping_class[$i]        = isset( $curr_data['wfsm-shipping-class-' . $variation_id] ) ? $curr_data['wfsm-shipping-class-' . $variation_id] : '';
				$variable_tax_class[$i]             = isset( $curr_data['wfsm-tax-class-' . $variation_id] ) ? $curr_data['wfsm-tax-class-' . $variation_id] : '';
				$variable_sale_price_dates_from[$i] = isset( $curr_data['wfsm-schedule-sale-start-' . $variation_id] ) ? $curr_data['wfsm-schedule-sale-start-' . $variation_id] : '';
				$variable_sale_price_dates_to[$i]   = isset( $curr_data['wfsm-schedule-sale-end-' . $variation_id] ) ? $curr_data['wfsm-schedule-sale-end-' . $variation_id] : '';

				$variable_weight[$i]                = isset( $curr_data['wfsm-weight-' . $variation_id] ) ? $curr_data['wfsm-weight-' . $variation_id] : '';
				$variable_length[$i]                = isset( $curr_data['wfsm-length-' . $variation_id] ) ? $curr_data['wfsm-length-' . $variation_id] : '';
				$variable_width[$i]                 = isset( $curr_data['wfsm-width-' . $variation_id] ) ? $curr_data['wfsm-width-' . $variation_id] : '';
				$variable_height[$i]                = isset( $curr_data['wfsm-height-' . $variation_id] ) ? $curr_data['wfsm-height-' . $variation_id] : '';
				$variable_is_virtual[$i]            = isset( $curr_data['wfsm-virtual-' . $variation_id] ) ? $curr_data['wfsm-virtual-' . $variation_id] : '';
				$variable_is_downloadable[$i]       = isset( $curr_data['wfsm-downloadable-' . $variation_id] ) ? $curr_data['wfsm-downloadable-' . $variation_id] : '';

				$variable_manage_stock[$i]          = isset( $curr_data['wfsm-manage-stock-quantity-' . $variation_id] ) ? $curr_data['wfsm-manage-stock-quantity-' . $variation_id] : '';
				$variable_stock[$i]                 = isset( $curr_data['wfsm-stock-quantity-' . $variation_id] ) ? wc_stock_amount( $curr_data['wfsm-stock-quantity-' . $variation_id] ) : '';
				$variable_backorders[$i]            = isset( $curr_data['wfsm-backorders-' . $variation_id] ) ? $curr_data['wfsm-backorders-' . $variation_id] : '';
				$variable_stock_status[$i]          = isset( $curr_data['wfsm-product-stock-' . $variation_id] ) ? $curr_data['wfsm-product-stock-' . $variation_id] : '';

			}


			for ( $i = 0; $i <= $max_loop; $i ++ ) {

				if ( ! isset( $variable_post_id[ $i ] ) ) {
					continue;
				}

				$variation_id = absint( $variable_post_id[ $i ] );

				if ( ! $variation_id ) {
					continue;
				}


				if ( !in_array( 'product_sku' , self::$settings['user_permissions'] ) ) {
					$sku     = get_post_meta( $variation_id, '_sku', true );
					$new_sku = wc_clean( stripslashes( $variable_sku[ $i ] ) );

					if ( '' == $new_sku ) {
						update_post_meta( $variation_id, '_sku', '' );
					} elseif ( $new_sku !== $sku ) {

						if ( ! empty( $new_sku ) ) {
							$unique_sku = wc_product_has_unique_sku( $variation_id, $new_sku );

							if ( ! $unique_sku ) {
								//WC_Admin_Meta_Boxes::add_error( esc_html__( 'Variation SKU must be unique.', 'woocommerce-frontend-shop-manager' ) );
							} else {
								update_post_meta( $variation_id, '_sku', $new_sku );
							}
						} else {
							update_post_meta( $variation_id, '_sku', '' );
						}
					}
				}

				if ( !in_array( 'product_featured_image' , self::$settings['user_permissions'] ) ) {
					update_post_meta( $variation_id, '_thumbnail_id', absint( $upload_image_id[ $i ] ) );
				}

				$is_virtual          = isset( $variable_is_virtual[ $i ] ) && $variable_is_virtual[ $i ] == 'yes' ? 'yes' : 'no';
				if ( !in_array( 'product_virtual' , self::$settings['user_permissions'] ) ) {
					update_post_meta( $variation_id, '_virtual', wc_clean( $is_virtual ) );
				}

				if ( !in_array( 'product_shipping' , self::$settings['user_permissions'] ) ) {
					if ( isset( $variable_weight[ $i ] ) ) {
						update_post_meta( $variation_id, '_weight', ( '' === $variable_weight[ $i ] ) ? '' : wc_format_decimal( $variable_weight[ $i ] ) );
					}

					if ( isset( $variable_length[ $i ] ) ) {
						update_post_meta( $variation_id, '_length', ( '' === $variable_length[ $i ] ) ? '' : wc_format_decimal( $variable_length[ $i ] ) );
					}

					if ( isset( $variable_width[ $i ] ) ) {
						update_post_meta( $variation_id, '_width', ( '' === $variable_width[ $i ] ) ? '' : wc_format_decimal( $variable_width[ $i ] ) );
					}

					if ( isset( $variable_height[ $i ] ) ) {
						update_post_meta( $variation_id, '_height', ( '' === $variable_height[ $i ] ) ? '' : wc_format_decimal( $variable_height[ $i ] ) );
					}

					$variable_shipping_class[ $i ] = ! empty( $variable_shipping_class[ $i ] ) ? (int) $variable_shipping_class[ $i ] : '';
					wp_set_object_terms( $variation_id, $variable_shipping_class[ $i ], 'product_shipping_class');
				}

				if ( !in_array( 'product_stock' , self::$settings['user_permissions'] ) ) {

					$manage_stock        = isset( $variable_manage_stock[ $i ] ) && $variable_manage_stock[ $i ] == 'yes' ? 'yes' : 'no';
					update_post_meta( $variation_id, '_manage_stock', $manage_stock );

					if ( ! empty( $variable_stock_status[ $i ] ) ) {
						wc_update_product_stock_status( $variation_id, $variable_stock_status[ $i ] );
					}

					if ( 'yes' === $manage_stock ) {
						update_post_meta( $variation_id, '_backorders', wc_clean( $variable_backorders[ $i ] ) );
						wc_update_product_stock( $variation_id, wc_stock_amount( $variable_stock[ $i ] ) );
					} else {
						delete_post_meta( $variation_id, '_backorders' );
						delete_post_meta( $variation_id, '_stock' );
					}
				}

				$regular_price = wc_format_decimal( $variable_regular_price[ $i ] );
				$sale_price    = $variable_sale_price[ $i ] === '' ? '' : wc_format_decimal( $variable_sale_price[ $i ] );

				if ( !in_array( 'product_prices' , self::$settings['user_permissions'] ) ) {

					update_post_meta( $variation_id, '_regular_price', $regular_price );
					update_post_meta( $variation_id, '_sale_price', $sale_price );

					if ( '' !== $sale_price ) {
						update_post_meta( $variation_id, '_price', $sale_price );
					} else {
						update_post_meta( $variation_id, '_price', $regular_price );
					}
				}

				if ( !in_array( 'product_schedule_sale' , self::$settings['user_permissions'] ) ) {

					$date_from     = wc_clean( $variable_sale_price_dates_from[ $i ] );
					$date_to       = wc_clean( $variable_sale_price_dates_to[ $i ] );

					update_post_meta( $variation_id, '_sale_price_dates_from', $date_from ? strtotime( $date_from ) : '' );
					update_post_meta( $variation_id, '_sale_price_dates_to', $date_to ? strtotime( $date_to ) : '' );

					if ( $date_to && ! $date_from ) {
						update_post_meta( $variation_id, '_sale_price_dates_from', strtotime( 'NOW', current_time( 'timestamp' ) ) );
					}

					if ( '' !== $sale_price && '' === $date_to && '' === $date_from ) {
						update_post_meta( $variation_id, '_price', $sale_price );
					} else {
						update_post_meta( $variation_id, '_price', $regular_price );
					}

					if ( '' !== $sale_price && $date_from && strtotime( $date_from ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
						update_post_meta( $variation_id, '_price', $sale_price );
					}

					if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
						update_post_meta( $variation_id, '_price', $regular_price );
						update_post_meta( $variation_id, '_sale_price_dates_from', '' );
						update_post_meta( $variation_id, '_sale_price_dates_to', '' );
					}

					if ( isset( $variable_tax_class[ $i ] ) && $variable_tax_class[ $i ] !== 'parent' ) {
						update_post_meta( $variation_id, '_tax_class', wc_clean( $variable_tax_class[ $i ] ) );
					} else {
						delete_post_meta( $variation_id, '_tax_class' );
					}
				}


				$is_downloadable     = isset( $variable_is_downloadable[ $i ] ) && $variable_is_downloadable[ $i ] == 'yes' ? 'yes' : 'no';

				if ( !in_array( 'product_downloadable' , self::$settings['user_permissions'] ) ) {
					update_post_meta( $variation_id, '_downloadable', wc_clean( $is_downloadable ) );
				}

				if ( !in_array( 'product_downloads' , self::$settings['user_permissions'] ) ) {
					if ( 'yes' == $is_downloadable ) {
						if ( !in_array( 'product_download_settings' , self::$settings['user_permissions'] ) ) {
							update_post_meta( $variation_id, '_download_limit', wc_clean( $variable_download_limit[ $i ] ) );
							update_post_meta( $variation_id, '_download_expiry', wc_clean( $variable_download_expiry[ $i ] ) );
						}

						$files              = array();
						$file_names         = isset( $curr_data['wfsm-file-names-' . $variation_id] ) ? array_map( 'wc_clean', $curr_data['wfsm-file-names-' . $variation_id] ) : array();
						$file_urls          = isset( $curr_data['wfsm-file-urls-' . $variation_id] ) ? array_map( 'wc_clean', $curr_data['wfsm-file-urls-' . $variation_id] ) : array();
						$file_url_size      = sizeof( $file_urls );
						$allowed_file_types = get_allowed_mime_types();

						for ( $ii = 0; $ii < $file_url_size; $ii ++ ) {
							if ( ! empty( $file_urls[ $ii ] ) ) {

								if ( 0 === strpos( $file_urls[ $ii ], 'http' ) ) {
									$file_is  = 'absolute';
									$file_url = esc_url_raw( $file_urls[ $ii ] );
								} elseif ( '[' === substr( $file_urls[ $ii ], 0, 1 ) && ']' === substr( $file_urls[ $ii ], -1 ) ) {
									$file_is  = 'shortcode';
									$file_url = wc_clean( $file_urls[ $ii ] );
								} else {
									$file_is = 'relative';
									$file_url = wc_clean( $file_urls[ $ii ] );
								}

								$file_name = wc_clean( $file_names[ $ii ] );
								$file_hash = md5( $file_url );

								if ( in_array( $file_is, array( 'absolute', 'relative' ) ) ) {
									$file_type  = wp_check_filetype( strtok( $file_url, '?' ) );
									$parsed_url = parse_url( $file_url, PHP_URL_PATH );
									$extension  = pathinfo( $parsed_url, PATHINFO_EXTENSION );

									if ( ! empty( $extension ) && ! in_array( $file_type['type'], $allowed_file_types ) ) {
										continue;
									}
								}

								if ( 'relative' === $file_is && ! apply_filters( 'woocommerce_downloadable_file_exists', file_exists( $file_url ), $file_url ) ) {
									continue;
								}

								$files[ $file_hash ] = array(
									'name' => $file_name,
									'file' => $file_url
								);
							}
						}

						do_action( 'woocommerce_process_product_file_download_paths', $post_id, $variation_id, $files );

						update_post_meta( $variation_id, '_downloadable_files', $files );
					} else {
						if ( !in_array( 'product_download_settings' , self::$settings['user_permissions'] ) ) {
							update_post_meta( $variation_id, '_download_limit', '' );
							update_post_meta( $variation_id, '_download_expiry', '' );
						}
						update_post_meta( $variation_id, '_downloadable_files', '' );
					}
				}
			}

			do_action( 'woocommerce_save_product_variation', $variation_id, $i );

		}

		WC_Product_Variable::sync( $post_id );

	}

	function shortcode( $atts, $content = null ) {

		if ( !self::$settings['user']->exists() ) {
			return '';
		}

		global $wfsm_global;

		if ( !isset( $wfsm_global['init'] ) ) {
			$wfsm_global['init'] = true;
		}

		$shortcode_atts = shortcode_atts( array(
			'product_type' => '',
			'class' => 'button'
		), $atts );

		extract( $shortcode_atts );

		if ( !in_array( $product_type, array( 'simple', 'grouped', 'variable', 'external', 'any' ) ) ) {
			$product_type = 'any';
		}

		if ( $class !== '' ) {
			$class = esc_attr( $class );
			$class = !empty( $class ) ? ' ' . $class : '';
		}

		$button = '<a href="#" class="wfsm-new-product' . $class . '" data-type="' . $product_type . '">';

		$button .= empty( $content ) ? esc_html__( 'New product', 'woocommerce-frontend-shop-manager' ) : $content;

		$button .= '</a>';

		ob_start();

		if ( $product_type == 'any' ) {
			$this->wfsm_add_product();
		}
		else {
			$this->wfsm_add_product_lite();
		}

		$button .= ob_get_clean();

		return $button;

	}

}

add_action( 'init', array( 'XforWC_Live_Editor_Frontend', 'init' ), 998 );

if ( !function_exists( 'mnthemes_add_meta_information' ) ) {
	function mnthemes_add_meta_information_action() {
		echo '<meta name="generator" content="' . esc_attr( implode( ', ', apply_filters( 'mnthemes_add_meta_information_used', array() ) ) ) . '"/>';
	}
	function mnthemes_add_meta_information() {
		add_action( 'wp_head', 'mnthemes_add_meta_information_action', 99 );
	}
	mnthemes_add_meta_information();
}

?>