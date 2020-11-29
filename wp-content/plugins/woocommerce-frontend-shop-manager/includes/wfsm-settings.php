<?php

class XforWC_Live_Editor_Settings {

	public static $settings;

	public static function init() {

		if ( isset($_GET['page'], $_GET['tab']) && ($_GET['page'] == 'wc-settings' ) && $_GET['tab'] == 'live_editor' ) {
			$init = true;
			add_filter( 'svx_plugins_settings', __CLASS__ . '::get_settings', 50 );
		}

		if ( isset($_GET['page']) && $_GET['page'] == 'xforwoocommerce' ) {
			$init = true;
		}
		if ( isset( $init ) ) {
			return false;
		}

		self::$settings['restrictions'] = array(
			'create_simple_product' => esc_html__( 'Create Simple Products', 'woocommerce-frontend-shop-manager' ),
			'create_grouped_product' => esc_html__( 'Create Grouped Products', 'woocommerce-frontend-shop-manager' ),
			'create_external_product' => esc_html__( 'Create External Products', 'woocommerce-frontend-shop-manager' ),
			'create_variable_product' => esc_html__( 'Create Variable Products', 'woocommerce-frontend-shop-manager' ),
			'create_custom_product' => esc_html__( 'Create Custom Products', 'woocommerce-frontend-shop-manager' ),
			'product_status' => esc_html__( 'Product Status', 'woocommerce-frontend-shop-manager' ),
			'product_feature' => esc_html__( 'Feature Product', 'woocommerce-frontend-shop-manager' ),
			'product_content' => esc_html__( 'Product Content and Description', 'woocommerce-frontend-shop-manager' ),
			'product_featured_image' => esc_html__( 'Featured Image', 'woocommerce-frontend-shop-manager' ),
			'product_gallery' => esc_html__( 'Product Gallery', 'woocommerce-frontend-shop-manager' ),
			'product_downloadable' => esc_html__( 'Downloadable Products', 'woocommerce-frontend-shop-manager' ),
			'product_virtual' => esc_html__( 'Virtual Products', 'woocommerce-frontend-shop-manager' ),
			'product_name' => esc_html__( 'Product Name', 'woocommerce-frontend-shop-manager' ),
			'product_slug' => esc_html__( 'Product Slug', 'woocommerce-frontend-shop-manager' ),
			'external_product_url' => esc_html__( 'Product External URL (External/Affilate)', 'woocommerce-frontend-shop-manager' ),
			'external_button_text' => esc_html__( 'Product External Button Text', 'woocommerce-frontend-shop-manager' ),
			'product_sku' => esc_html__( 'Product SKU', 'woocommerce-frontend-shop-manager' ),
			'product_taxes' => esc_html__( 'Product Tax', 'woocommerce-frontend-shop-manager' ),
			'product_prices' => esc_html__( 'Product Prices', 'woocommerce-frontend-shop-manager' ),
			'product_sold_individually' => esc_html__( 'Sold Individually', 'woocommerce-frontend-shop-manager' ),
			'product_stock' => esc_html__( 'Product Stock', 'woocommerce-frontend-shop-manager' ),
			'product_schedule_sale' => esc_html__( 'Product Schedule Sale', 'woocommerce-frontend-shop-manager' ),
			'product_grouping' => esc_html__( 'Product Grouping', 'woocommerce-frontend-shop-manager' ),
			'product_note' => esc_html__( 'Product Purchase Note', 'woocommerce-frontend-shop-manager' ),
			'product_shipping' => esc_html__( 'Product Shipping', 'woocommerce-frontend-shop-manager' ),
			'product_downloads' => esc_html__( 'Manage Downloads', 'woocommerce-frontend-shop-manager' ),
			'product_download_settings' => esc_html__( 'Manage Download Extended Settings', 'woocommerce-frontend-shop-manager' ),
			'product_cat' => esc_html__( 'Edit Product Categories', 'woocommerce-frontend-shop-manager' ),
			'product_tag' => esc_html__( 'Edit Product Tags', 'woocommerce-frontend-shop-manager' ),
			'product_attributes' => esc_html__( 'Edit Product Attributes', 'woocommerce-frontend-shop-manager' ),
			'product_new_terms' => esc_html__( 'Add New Taxonomy Terms', 'woocommerce-frontend-shop-manager' ),
			'variable_add_variations' => esc_html__( 'Add Variation (Variable)', 'woocommerce-frontend-shop-manager' ),
			'variable_edit_variations' => esc_html__( 'Edit Variations (Variable)', 'woocommerce-frontend-shop-manager' ),
			'variable_delete' => esc_html__( 'Delete Variation (Variable)', 'woocommerce-frontend-shop-manager' ),
			'variable_product_attributes' => esc_html__( 'Edit Product Attributes (Variable)', 'woocommerce-frontend-shop-manager' ),
			'product_clone' => esc_html__( 'Duplicate Products', 'woocommerce-frontend-shop-manager' ),
			'product_delete' => esc_html__( 'Delete Products', 'woocommerce-frontend-shop-manager' ),
			'backend_buttons' => esc_html__( 'Backend Buttons', 'woocommerce-frontend-shop-manager' ),
		);

		self::$settings['vendor_groups'] = get_option( 'wc_settings_wfsm_vendor_groups', array() );
		self::$settings['custom_settings'] = get_option( 'wc_settings_wfsm_custom_settings', array() );

		if ( is_array( self::$settings['custom_settings'] ) ) {
			foreach( self::$settings['custom_settings'] as $set ) {
				$set['name'] = isset( $set['name'] ) ? $set['name'] : esc_html__( 'Opton Name', 'woocommerce-frontend-shop-manager' );
	
				$slug = sanitize_title( $set['name'] );
				self::$settings['restrictions']['wfsm_custom_' . $slug] = $set['name'];
			}
		}

		add_action( 'admin_enqueue_scripts', __CLASS__ . '::wfsm_settings_scripts', 9 );

	}

	public static function wfsm_settings_scripts( $settings_tabs ) {

		if ( isset($_GET['page'], $_GET['tab']) && ( $_GET['page'] == 'wc-settings' ) && $_GET['tab'] == 'live_editor' ) {
			wp_register_script( 'wfsm-admin', Wfsm()->plugin_url() . '/assets/js/admin.js', array( 'jquery' ), Wfsm()->version(), true );
			wp_enqueue_script( array( 'wfsm-admin' ) );
		}

	}

	public static function get_settings( $plugins ) {

		$wfsm_styles = apply_filters( 'wfsm_editor_styles', array(
			'wfsm_style_default' => esc_html__( 'Default', 'woocommerce-frontend-shop-manager' ),
			'wfsm_style_flat' => esc_html__( 'Flat', 'woocommerce-frontend-shop-manager' ),
			'wfsm_style_dark' => esc_html__( 'Dark', 'woocommerce-frontend-shop-manager' )
		) );

		$plugins['live_editor'] = array(
			'slug' => 'live_editor',
			'name' => function_exists( 'XforWC' ) ? esc_html__( 'Live product editor', 'woocommerce-frontend-shop-manager' ) : esc_html__( 'Live Product Editor for WooCommerce', 'woocommerce-frontend-shop-manager' ),
			'desc' => function_exists( 'XforWC' ) ? esc_html__( 'Live Product Editor for WooCommerce', 'woocommerce-frontend-shop-manager' ) . ' v' . Wfsm()->version() : esc_html__( 'Settings page for Live Product Editor for WooCommerce!', 'woocommerce-frontend-shop-manager' ),
			'link' => 'https://xforwoocommerce.com/store/live-product-editing/',
			'ref' => array(
				'name' => esc_html__( 'Visit XforWooCommerce.com', 'woocommerce-frontend-shop-manager' ),
				'url' => 'https://xforwoocommerce.com',
			),
			'doc' => array(
				'name' => esc_html__( 'Get help', 'woocommerce-frontend-shop-manager' ),
				'url' => 'https://help.xforwoocommerce.com',
			),
			'sections' => array(
				'dashboard' => array(
					'name' => esc_html__( 'Dashboard', 'woocommerce-frontend-shop-manager' ),
					'desc' => esc_html__( 'Dashboard Overview', 'woocommerce-frontend-shop-manager' ),
				),
				'general' => array(
					'name' => esc_html__( 'General', 'woocommerce-frontend-shop-manager' ),
					'desc' => esc_html__( 'General Options', 'woocommerce-frontend-shop-manager' ),
				),
				'products' => array(
					'name' => esc_html__( 'Products', 'woocommerce-frontend-shop-manager' ),
					'desc' => esc_html__( 'Products Options', 'woocommerce-frontend-shop-manager' ),
				),
				'vendors' => array(
					'name' => esc_html__( 'Vendors', 'woocommerce-frontend-shop-manager' ),
					'desc' => esc_html__( 'Vendors Options', 'woocommerce-frontend-shop-manager' ),
				),
				'custom' => array(
					'name' => esc_html__( 'Custom Options', 'woocommerce-frontend-shop-manager' ),
					'desc' => esc_html__( 'Custom Options Settings', 'woocommerce-frontend-shop-manager' ),
				),
				'installation' => array(
					'name' => esc_html__( 'Installation', 'woocommerce-frontend-shop-manager' ),
					'desc' => esc_html__( 'Installation Options', 'woocommerce-frontend-shop-manager' ),
				),
			),
			'settings' => array(

				'wcmn_dashboard' => array(
					'type' => 'html',
					'id' => 'wcmn_dashboard',
					'desc' => '
					<img src="' . Wfsm()->plugin_url() . '/assets/images/live-manager-for-woocommerce-shop.png" class="svx-dashboard-image" />
					<h3><span class="dashicons dashicons-store"></span> XforWooCommerce</h3>
					<p>' . esc_html__( 'Visit XforWooCommerce.com store, demos and knowledge base.', 'woocommerce-frontend-shop-manager' ) . '</p>
					<p><a href="https://xforwoocommerce.com" class="xforwc-button-primary x-color" target="_blank">XforWooCommerce.com</a></p>

					<br /><hr />

					<h3><span class="dashicons dashicons-admin-tools"></span> ' . esc_html__( 'Help Center', 'woocommerce-frontend-shop-manager' ) . '</h3>
					<p>' . esc_html__( 'Need support? Visit the Help Center.', 'woocommerce-frontend-shop-manager' ) . '</p>
					<p><a href="https://help.xforwoocommerce.com" class="xforwc-button-primary red" target="_blank">XforWooCommerce.com HELP</a></p>
					
					<br /><hr />

					<h3><span class="dashicons dashicons-update"></span> ' . esc_html__( 'Automatic Updates', 'woocommerce-frontend-shop-manager' ) . '</h3>
					<p>' . esc_html__( 'Get automatic updates, by downloading and installing the Envato Market plugin.', 'woocommerce-frontend-shop-manager' ) . '</p>
					<p><a href="https://envato.com/market-plugin/" class="svx-button" target="_blank">Envato Market Plugin</a></p>
					
					<br />',
					'section' => 'dashboard',
				),


				'wcmn_utility' => array(
					'name' => esc_html__( 'Plugin Options', 'woocommerce-frontend-shop-manager' ),
					'type' => 'utility',
					'id' => 'wcmn_utility',
					'desc' => esc_html__( 'Quick export/import, backup and restore, or just reset your optons here', 'woocommerce-frontend-shop-manager' ),
					'section' => 'dashboard',
				),

				'wc_settings_wfsm_logo' => array(
					'name' => esc_html__( 'Custom Logo', 'woocommerce-frontend-shop-manager' ),
					'type' => 'file',
					'desc' => esc_html__( 'Use custom logo and enter logo URL. Use square images (200x200px)!', 'woocommerce-frontend-shop-manager' ),
					'id'   => 'wc_settings_wfsm_logo',
					'default' => '',
					'autoload' => false,
					'section' => 'general'
				),
				'wc_settings_wfsm_mode' => array(
					'name' => esc_html__( 'Show Logo/User', 'woocommerce-frontend-shop-manager' ),
					'type' => 'select',
					'desc' => esc_html__( 'Select what to show in the Live Product Editor header, logo or logged in user.', 'woocommerce-frontend-shop-manager' ),
					'id' => 'wc_settings_wfsm_mode',
					'options' => array(
						'wfsm_mode_logo' => esc_html__( 'Show Logo', 'woocommerce-frontend-shop-manager' ),
						'wfsm_mode_user' => esc_html__( 'Show Logged User', 'woocommerce-frontend-shop-manager' )
					),
					'default' => 'wfsm_logo',
					'autoload' => false,
					'section' => 'general'
				),
				'wc_settings_wfsm_style' => array(
					'name' => esc_html__( 'Live Editor Style', 'woocommerce-frontend-shop-manager' ),
					'type' => 'select',
					'desc' => esc_html__( 'Select Live Product Editor style/skin.', 'woocommerce-frontend-shop-manager' ),
					'id' => 'wc_settings_wfsm_style',
					'options' => $wfsm_styles,
					'default' => 'wfsm_style_default',
					'autoload' => false,
					'section' => 'general'
				),

				'wc_settings_wfsm_archive_action' => array(
					'name' => esc_html__( 'Shop Init Action', 'woocommerce-frontend-shop-manager' ),
					'type' => 'text',
					'desc' => esc_html__( 'Use custom initialization action for Shop/Product Archives. Use actions initiated in your content-product.php template. Please enter action name in following format action_name:priority', 'woocommerce-frontend-shop-manager' ) . ' ( default: woocommerce_before_shop_loop_item:0 )',
					'id' => 'wc_settings_wfsm_archive_action',
					'autoload' => true,
					'section' => 'installation'
				),
				'wc_settings_wfsm_single_action' => array(
					'name' => esc_html__( 'Single Product Init Action', 'woocommerce-frontend-shop-manager' ),
					'type' => 'text',
					'desc' => esc_html__( 'Use custom initialization action on Single Product Pages. Use actions initiated in your content-single-product.php template. Please enter action name in following format action_name:priority', 'woocommerce-frontend-shop-manager' ) . ' ( default: woocommerce_before_single_product_summary:5 )',
					'id' => 'wc_settings_wfsm_single_action',
					'autoload' => true,
					'section' => 'installation'
				),
				'wc_settings_wfsm_force_scripts' => array(
					'name' => esc_html__( 'Plugin Scripts', 'woocommerce-frontend-shop-manager' ),
					'type' => 'checkbox',
					'desc' => esc_html__( 'Check this option to load plugin scripts in all pages. This option fixes issues in Quick Views, AJAX loads and similar.', 'woocommerce-frontend-shop-manager' ),
					'id'   => 'wc_settings_wfsm_force_scripts',
					'default' => 'no',
					'autoload' => true,
					'section' => 'installation'
				),

				'wc_settings_wfsm_show_hidden_products' => array(
					'name' => esc_html__( 'Show Hidden Products', 'woocommerce-frontend-shop-manager' ),
					'type' => 'checkbox',
					'desc' => esc_html__( 'Check this option to enable pending and draft products in Shop/Product Archives.', 'woocommerce-frontend-shop-manager' ),
					'id' => 'wc_settings_wfsm_show_hidden_products',
					'default' => 'yes',
					'autoload' => true,
					'section' => 'products'
				),
				'wc_settings_wfsm_new_button' => array(
					'name' => esc_html__( 'New Product Button', 'woocommerce-frontend-shop-manager' ),
					'type' => 'checkbox',
					'desc' => esc_html__( 'Check this option to hide the New Product Button (Create Product). Use [wfsm_new_product] shortcode if you need a custom New Product Button.', 'woocommerce-frontend-shop-manager' ),
					'id' => 'wc_settings_wfsm_new_button',
					'default' => 'no',
					'autoload' => false,
					'section' => 'products'
				),
				'wc_settings_wfsm_create_status' => array(
					'name' => esc_html__( 'New Product Status', 'woocommerce-frontend-shop-manager' ),
					'type' => 'select',
					'desc' => esc_html__( 'Select the default status for newly created products.', 'woocommerce-frontend-shop-manager' ),
					'id' => 'wc_settings_wfsm_create_status',
					'options' => array(
						'publish' => esc_html__( 'Published', 'woocommerce-frontend-shop-manager' ),
						'pending' => esc_html__( 'Pending', 'woocommerce-frontend-shop-manager' ),
						'draft' => esc_html__( 'Draft', 'woocommerce-frontend-shop-manager' )
					),
					'default' => 'pending',
					'autoload' => false,
					'section' => 'products'
				),
				'wc_settings_wfsm_create_virtual' => array(
					'name' => esc_html__( 'New Product is Virtual', 'woocommerce-frontend-shop-manager' ),
					'type' => 'checkbox',
					'desc' => esc_html__( 'Check this option to set virtual by default (not shipped) for new products.', 'woocommerce-frontend-shop-manager' ),
					'id' => 'wc_settings_wfsm_create_virtual',
					'default' => 'no',
					'autoload' => false,
					'section' => 'products'
				),
				'wc_settings_wfsm_create_downloadable' => array(
					'name' => esc_html__( 'New Product is Downloadable', 'woocommerce-frontend-shop-manager' ),
					'type' => 'checkbox',
					'desc' => esc_html__( 'Check this option to set downloadable by default for new products.', 'woocommerce-frontend-shop-manager' ),
					'id' => 'wc_settings_wfsm_create_downloadable',
					'default' => 'no',
					'autoload' => false,
					'section' => 'products'
				),

				'wc_settings_wfsm_custom_settings' => array(
					'name' => esc_html__( 'Custom Product Options', 'woocommerce-frontend-shop-manager' ),
					'type' => 'list',
					'id'   => 'wc_settings_wfsm_custom_settings',
					'desc' => esc_html__( 'Click Add Custom Settings Group button to add special product options in the Live Product Editor.', 'woocommerce-frontend-shop-manager' ),
					'autoload' => false,
					'section' => 'custom',
					'title' => esc_html__( 'Group Name', 'woocommerce-frontend-shop-manager' ),
					'translate' => true,
					'options' => 'list',
					'settings' => array(
						'name' => array(
							'name' => esc_html__( 'Group Name', 'woocommerce-frontend-shop-manager' ),
							'type' => 'text',
							'id' => 'name',
							'desc' => esc_html__( 'Enter group name', 'woocommerce-frontend-shop-manager' ),
							'default' => '',
						),
						'options' => array(
							'name' => esc_html__( 'Options', 'woocommerce-frontend-shop-manager' ),
							'type' => 'list-select',
							'id' => 'options',
							'desc' => esc_html__( 'Add options to options group', 'woocommerce-frontend-shop-manager' ),
							'default' => array(),
							'title' => esc_html__( 'Option Name', 'woocommerce-frontend-shop-manager' ),
							'options' => 'list',
							'selects' => array(
								'input' => esc_html__( 'Input', 'woocommerce-frontend-shop-manager' ),
								'checkbox' => esc_html__( 'Checkbox', 'woocommerce-frontend-shop-manager' ),
								'select' => esc_html__( 'Select Box', 'woocommerce-frontend-shop-manager' ),
								'textarea' => esc_html__( 'Textarea', 'woocommerce-frontend-shop-manager' ),
							),
							'settings' => array(
								'input' => array(
									'name' => array(
										'name' => esc_html__( 'Name', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'name',
										'desc' => esc_html__( 'Enter option name', 'woocommerce-frontend-shop-manager' ),
										'default' =>'',
									),
									'key' => array(
										'name' => esc_html__( 'Key', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'key',
										'desc' => esc_html__( 'Enter database key', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
									'default' => array(
										'name' => esc_html__( 'Default Value', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'default',
										'desc' => esc_html__( 'Enter default value', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
								),
								'textarea' => array(
									'name' => array(
										'name' => esc_html__( 'Name', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'name',
										'desc' => esc_html__( 'Enter option name', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
									'key' => array(
										'name' => esc_html__( 'Key', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'key',
										'desc' => esc_html__( 'Enter database key', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
									'default' => array(
										'name' => esc_html__( 'Default Value', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'default',
										'desc' => esc_html__( 'Enter default value', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
								),
								'checkbox' => array(
									'name' => array(
										'name' => esc_html__( 'Name', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'name',
										'desc' => esc_html__( 'Enter option name', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
									'key' => array(
										'name' => esc_html__( 'Key', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'key',
										'desc' => esc_html__( 'Enter database key', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
									'options' => array(
										'name' => esc_html__( 'Options', 'woocommerce-frontend-shop-manager' ),
										'type' => 'textarea',
										'id' => 'options',
										'desc' => esc_html__( 'Enter options (JSON string)', 'woocommerce-frontend-shop-manager' ),
										'default' => '{
	"yes" : "This option is now checked",
	"no" : "You have unchecked this option"
}',
									),
									'default' => array(
										'name' => esc_html__( 'Default Value', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'default',
										'desc' => esc_html__( 'Enter default value', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
								),
								'select' => array(
									'name' => array(
										'name' => esc_html__( 'Name', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'name',
										'desc' => esc_html__( 'Enter option name', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
									'key' => array(
										'name' => esc_html__( 'Key', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'key',
										'desc' => esc_html__( 'Enter database key', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
									'options' => array(
										'name' => esc_html__( 'Options', 'woocommerce-frontend-shop-manager' ),
										'type' => 'textarea',
										'id' => 'options',
										'desc' => esc_html__( 'Enter options (JSON string)', 'woocommerce-frontend-shop-manager' ),
										'default' => '{
	"apple" : "Citric Apple",
	"pear" : "Sweet Pear",
	"bannana" : "Yellow Bananna"
}',
									),
									'default' => array(
										'name' => esc_html__( 'Default Value', 'woocommerce-frontend-shop-manager' ),
										'type' => 'text',
										'id' => 'default',
										'desc' => esc_html__( 'Enter default value', 'woocommerce-frontend-shop-manager' ),
										'default' => '',
									),
								)
							)
						),
					),
				),

				'wc_settings_wfsm_vendor_max_products' => array(
					'name' => esc_html__( 'Products per Vendor', 'woocommerce-frontend-shop-manager' ),
					'type' => 'number',
					'desc' => esc_html__( 'Maximum number of products vendor can create.', 'woocommerce-frontend-shop-manager' ),
					'id' => 'wc_settings_wfsm_vendor_max_products',
					'default' => '',
					'autoload' => false,
					'section' => 'vendors'
				),
				'wc_settings_wfsm_default_permissions' => array(
					'name' => esc_html__( 'Default Vendor Restrictions', 'woocommerce-frontend-shop-manager' ),
					'type' => 'multiselect',
					'desc' => esc_html__( 'Selected product options vendors will not be able to edit.', 'woocommerce-frontend-shop-manager' ),
					'id' => 'wc_settings_wfsm_default_permissions',
					'options' => self::$settings['restrictions'],
					'default' => array(),
					'autoload' => false,
					'section' => 'vendors',
					'class' => 'svx-selectize'
				),
				'wc_settings_wfsm_vendor_groups' => array(
					'name' => esc_html__( 'Vendor Groups Manager', 'woocommerce-frontend-shop-manager' ),
					'type' => 'list',
					'id' => 'wc_settings_wfsm_vendor_groups',
					'desc' => esc_html__( 'Click Add Vendor Premission Group button to customize user editing permissions for specified users.', 'woocommerce-frontend-shop-manager' ),
					'autoload' => false,
					'section' => 'vendors',
					'title' => esc_html__( 'Group Name', 'woocommerce-frontend-shop-manager' ),
					'options' => 'list',
					'settings' => array(
						'name' => array(
							'name' => esc_html__( 'Group Name', 'woocommerce-frontend-shop-manager' ),
							'type' => 'text',
							'id' => 'name',
							'desc' => esc_html__( 'Enter group name', 'woocommerce-frontend-shop-manager' ),
							'default' => ''
						),
						'users' => array(
							'name' => esc_html__( 'Select Users', 'woocommerce-frontend-shop-manager' ),
							'type' => 'multiselect',
							'id' => 'users',
							'desc' => esc_html__( 'Select users', 'woocommerce-frontend-shop-manager' ),
							'default' => '',
							'options' => 'ajax:users',
							'class' => 'svx-selectize'
						),
						'permissions' => array(
							'name' => esc_html__( 'Select Options', 'woocommerce-frontend-shop-manager' ),
							'type' => 'multiselect',
							'id' => 'permissions',
							'desc' => esc_html__( 'Selected product options vendors from this group will not be able to edit', 'woocommerce-frontend-shop-manager' ),
							'options' => self::$settings['restrictions'],
							'default' => '',
							'class' => 'svx-selectize'
						)
					)
				),

			)
		);

		foreach ( $plugins['live_editor']['settings'] as $k => $v ) {
			$get = isset( $v['translate'] ) && !empty( SevenVX()->language() ) ? $v['id'] . '_' . SevenVX()->language() : $v['id'];
			$std = isset( $v['default'] ) ?  $v['default'] : '';
			$set = ( $set = get_option( $get, false ) ) === false ? $std : $set;
			$plugins['live_editor']['settings'][$k]['val'] = SevenVX()->stripslashes_deep( $set );
		}

		$plugins['live_editor']['key'] = SevenVX()->get_key( 'live_editor' );

		return apply_filters( 'wc_wfsm_settings', $plugins );
	}

}

add_action( 'init', array( 'XforWC_Live_Editor_Settings', 'init' ), 100 );

add_action( 'svx_ajax_saved_settings_live_editor', 'svx_add_live_editor_user_groups' );
function svx_add_live_editor_user_groups( $opt ) {
	if ( $_POST['svx']['plugin']=='live_editor') {
		$opt = $opt['std']['wc_settings_wfsm_vendor_groups'];
		if ( !empty( $opt ) ) {
			foreach( $opt as $k => $v ) {
				foreach( $v['users'] as $user ) {
					update_user_meta( $user, 'wfsm_group', $k );
				}
			}
		}
	}
}

?>