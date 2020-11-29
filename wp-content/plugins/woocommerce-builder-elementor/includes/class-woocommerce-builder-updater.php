<?php
/**
 * Envato API class.
 *
 * @package WooCommerce_Builder_Elementor
 */

/**
 * Creates the Envato API connection.
 *
 * @class DTWCBE_WooCommerce_Builder_Elementor_Updater
 * @version 5.0.0
 * @since 5.0.0
 */
final class DTWCBE_WooCommerce_Builder_Elementor_Updater {

	/**
	 * The arguments that are used in the DTWCBE_WooCommerce_Builder_Elementor_Product_Registration class.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var array
	 */
	private $args = array();

	/**
	 * An instance of the DTWCBE_WooCommerce_Builder_Elementor_Product_Registration class.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var object DTWCBE_WooCommerce_Builder_Elementor_Product_Registration.
	*/
	private $registration;

	/**
	 * Constructor
	 *
	 * @access public
	 * @param object $registration An instance of the DTWCBE_WooCommerce_Builder_Elementor_Product_Registration class.
	 */
	public function __construct( $registration ) {

		$this->registration = $registration;
		$this->args         = $registration->get_args();

		// Inject plugin updates into the response array.
		add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'update_plugins' ] );
		add_filter( 'pre_set_transient_update_plugins', [ $this, 'update_plugins' ] );

		// Inject plugin information into the API calls.
		add_filter( 'plugins_api', [ $this, 'plugins_api' ], 10, 3 );

		// Deferred Download.
		add_action( 'upgrader_package_options', [ $this, 'maybe_deferred_download' ], 9 );

	}

	/**
	 * Deferred item download URL.
	 *
	 * @since 1.1.0
	 *
	 * @param int $id The item ID.
	 * @return string.
	 */
	public function deferred_download( $id ) {
		if ( empty( $id ) ) {
			return '';
		}

		$args = array(
			'deferred_download' => true,
			'item_id'           => $id,
		);
		return add_query_arg( $args, esc_url( admin_url( 'edit.php?post_type=dtwcbe_woo_library&dtwcbe_woo_library_type=registration' ) ) );
	}

	/**
	 * Get the item download.
	 *
	 * @since 1.1.0
	 *
	 * @param  int   $id The item ID.
	 * @param  array $args The arguments passed to `wp_remote_get`.
	 * @return bool|array The HTTP response.
	 */
	public function download( $id, $args = array() ) {
		if ( empty( $id ) ) {
			return false;
		}

		$url      = 'https://api.envato.com/v2/market/buyer/download?item_id=' . $id . '&shorten_url=true';
		$response = $this->registration->envato_api()->request( $url, $args );

		// @todo Find out which errors could be returned & handle them in the UI.
		if ( is_wp_error( $response ) || empty( $response ) || ! empty( $response['error'] ) ) {
			return false;
		}

		if ( ! empty( $response['wordpress_plugin'] ) ) {
			return $response['wordpress_plugin'];
		}

		return false;
	}

	/**
	 * Inject update data for WooCommerce product page builder.
	 *
	 * @since 1.1.0
	 * @param object $transient The pre-saved value of the `update_plugins` site transient.
	 * @return object
	 */
	public function update_plugins( $transient ) {

		// Get the array of arguments.
		$plugins = $this->registration->envato_api()->plugins();

		// Set plugin file name.
		$plugin_file = 'woocommerce-builder-elementor/init.php';
		$plugin_data = get_plugin_data( DTWCBE_PLUGIN_FILE );

		// Loop through all the plugins and process WooCommerce product page builder plugin updates.
		foreach ( $plugins as $key => $plugin ) {
			if ( 'WooCommerce Page Builder For Elementor' === $plugin['name'] ) {
				if ( version_compare( DTWCBE_VERSION, $plugin['version'], '<' ) ) {
					$_plugin = array(
						'slug'        => dirname( $plugin_file ),
						'plugin'      => $plugin_data,
						'new_version' => $plugin['version'],
						'url'         => $plugin['url'],
						'package'     => $this->deferred_download( $plugin['id'] ),
// 						'icons'       => [
// 							'1x' => esc_url_raw( $plugins_info[ $bundled_plugin_slug ]['icon'] ),
// 							'2x' => esc_url_raw( $plugins_info[ $bundled_plugin_slug ]['icon'] ),
// 						],
					);

					$transient->response[ $plugin_file ] = (object) $_plugin;
				}
				break;
			}
		}

		return $transient;
	}

	/**
	 * Defers building the API download url until the last responsible moment to limit file requests.
	 *
	 * Filter the package options before running an update.
	 *
	 * @since 1.1.0
	 *
	 * @param array $options {
	 *     Options used by the upgrader.
	 *
	 *     @type string $package                     Package for update.
	 *     @type string $destination                 Update location.
	 *     @type bool   $clear_destination           Clear the destination resource.
	 *     @type bool   $clear_working               Clear the working resource.
	 *     @type bool   $abort_if_destination_exists Abort if the Destination directory exists.
	 *     @type bool   $is_multi                    Whether the upgrader is running multiple times.
	 *     @type array  $hook_extra                  Extra hook arguments.
	 * }
	 */
	public function maybe_deferred_download( $options ) {
		$package = $options['package'];

		if ( false !== strrpos( $package, 'deferred_download' ) && false !== strrpos( $package, 'item_id' ) ) {
			parse_str( wp_parse_url( $package, PHP_URL_QUERY ), $vars );
			if ( '23339868' === $vars['item_id'] ) {
				$args               = $this->set_bearer_args();
				$options['package'] = $this->download( $vars['item_id'], $args );
			}
		}
		return $options;
	}

	/**
	 * Returns the bearer arguments for a request with a single use API Token.
	 *
	 * @since 1.1.0
	 * @return array
	 */
	public function set_bearer_args() {
		$args  = array();
		$token = $this->registration->get_token();
		if ( ! empty( $token ) ) {
			$args = array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $token,
					'User-Agent'    => 'WordPress - WooCommerce Page Builder For Elementor',
				),
				'timeout' => 20,
			);
		}
		return $args;
	}

	/**
	 * Inject API data for premium plugins.
	 *
	 * @since 1.1.0
	 *
	 * @param bool   $response Always false.
	 * @param string $action The API action being performed.
	 * @param object $args Plugin arguments.
	 * @return bool|object $response The plugin info or false.
	 */
	public function plugins_api( $response, $action, $args ) {
		global $wp_version;

		// Process premium plugin updates.
		if ( 'plugin_information' === $action && isset( $args->slug ) ) {
			$installed = $this->registration->envato_api()->plugins();
			foreach ( $installed as $slug => $plugin ) {
				if ( 'woocommerce-builder-elementor' === $args->slug && 23339868 === $plugin['id'] ) {
					$response                 = new stdClass();
					$response->slug           = $args->slug;
					$response->plugin         = $slug;
					$response->plugin_name    = $plugin['name'];
					$response->name           = $plugin['name'];
					$response->version        = $plugin['version'];
					$response->author         = $plugin['author'];
					$response->author_profile = 'https://codecanyon.net/user/dawnthemes';
					$response->homepage       = $plugin['url'];
					$response->requires       = $plugin['requires'];
					$response->tested         = $wp_version;
					$response->downloaded     = $plugin['number_of_sales'];
					$response->last_updated   = $plugin['updated_at'];
					$response->sections       = array(
						'description' => $plugin['description'],
					);
					$response->banners['low'] = $plugin['landscape_url'];
					$response->rating         = $plugin['rating']['rating'] / 5 * 100;
					$response->num_ratings    = $plugin['rating']['count'];
					$response->download_link  = $this->deferred_download( $plugin['id'] );

					break;
				}
			}
		}
		return $response;
	}
}