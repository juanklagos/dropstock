<?php
/**
 * Registration handler.
 *
 * @package WooCommerce_Builder_Elementor
 * @since 1.0.0
 */

/**
 * A class to handle everything related to product registration
 *
 * @since 1.0.0
 */
class DTWCBE_WooCommerce_Builder_Elementor_Product_Registration{
	/**
	 * The option group name.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var string
	 */
	private $option_group_slug = 'woocommerce_builder_elementor_registration';
	
	/**
	 * The option name.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var string
	 */
	private $option_name = 'woocommerce_builder_elementor_registration';
	
	/**
	 * The option array.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var array
	 */
	private $option;
	
	/**
	 * The Envato token.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var string
	 */
	private $token;
	
	/**
	 * Whether the token is valid and for the specified product or not.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var array
	 */
	private $registered = array();
	
	/**
	 * The arguments that are used in the constructor.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var array
	*/
	private $args = array();
	
	/**
	 * The product-name converted to ID.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var string
	*/
	private $product_id = '';
	
	/**
	 * Updater
	 *
	 * @access private
	 * @since 1.1.0
	 * @var null|object DTWCBE_WooCommerce_Builder_Elementor_Updater.
	 */
	private $updater = null;
	
	/**
	 * An instance of the DTWCBE_WooCommerce_Builder_Elementor_Envato_API class.
	 *
	 * @access private
	 * @since 1.1.0
	 * @var null|object DTWCBE_WooCommerce_Builder_Elementor_Envato_API.
	 */
	private $envato_api = null;
	
	/**
	 * The class constructor.
	 *
	 * @since 1.1.0
	 * @access public
	 * @param array $args An array of our arguments [string "type", string "name"].
	 */
	public function __construct( $args = array() ) {
	
		$this->args       = $args;
		$this->product_id = sanitize_key( $args['name'] );
	
		self::init_globals();
	
		// Register the settings.
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	
		// Instantiate the updater.
		if ( null === $this->updater ) {
			$this->updater = new DTWCBE_WooCommerce_Builder_Elementor_Updater( $this );
		}
	
	}
	
	/**
	 * Initialize the variables.
	 *
	 * @access private
	 * @since 1.1.0
	 * @return void
	 */
	private function init_globals() {
	
		$this->token  = false;
		$this->option = get_option( $this->option_name );
		if ( isset( $this->option[ $this->product_id ] ) && isset( $this->option[ $this->product_id ]['token'] ) ) {
			$this->token = $this->option[ $this->product_id ]['token'];
		}
		$this->registered = get_option( 'woocommerce_builder_elementor_registered' );
	
	}
	
	/**
	 * Returns the option name.
	 *
	 * @access public
	 * @since 1.1.0
	 * @return string The option name.
	 */
	public function get_option_name() {
	
		return $this->option_name;
	
	}
	
	/**
	 * Returns the option group name.
	 *
	 * @access public
	 * @since 1.1.0
	 * @return string The option group name.
	 */
	public function get_option_group_slug() {
	
		return $this->option_group_slug;
	
	}
	
	/**
	 * Sets a new token.
	 *
	 * @access public
	 * @since 1.1.0
	 * @param string $token A new token.
	 * @return void
	 */
	public function set_token( $token ) {
	
		$this->token = $token;
	
	}
	
	/**
	 * Returns the current token.
	 *
	 * @access public
	 * @since 1.1.0
	 * @return string The current token.
	 */
	public function get_token() {
	
		if ( null === $this->token || ! $this->token ) {
			if ( ! empty( $this->option ) && is_array( $this->option ) && isset( $this->option[ $this->product_id ] ) && isset( $this->option[ $this->product_id ]['token'] ) ) {
				return $this->option[ $this->product_id ]['token'];
			}
		}
		return $this->token;
	
	}
	
	/**
	 * Gets the arguments.
	 *
	 * @access public
	 * @since 1.1.0
	 * @return array
	 */
	public function get_args() {
	
		return $this->args;
	
	}
	
	/**
	 * Registers the setting field(s) for the registration form.
	 *
	 * @access public
	 * @since 1.1.0
	 * @return void
	 */
	public function register_settings() {
	
		// Setting.
		register_setting(
		$this->get_option_group_slug(),
		$this->option_name,
		array( $this, 'check_registration' )
		);
	
		// Token setting.
		add_settings_field(
		'token',
		esc_attr__( 'Token', 'woocommerce-builder-elementor' ),
		array( $this, 'render_token_setting_callback' ),
		$this->get_option_group_slug()
		);
	
	}
	
	/**
	 * Renders the token settings field.
	 *
	 * @access public
	 * @since 1.1.0
	 * @return void
	 */
	public function render_token_setting_callback() {
		?>
			<input type="text" name="<?php esc_attr( "{$this->option_name}[{$this->product_id}][token]" ); ?>" class="widefat" value="<?php echo esc_html( $this->get_token() ); ?>" autocomplete="off">
			<?php
	
		}
	
		/**
		 * Envato API class.
		 *
		 * @access public
		 * @since 1.1.0
		 * @return DTWCBE_WooCommerce_Builder_Elementor_Envato_API
		 */
		public function envato_api() {
	
			if ( null === $this->envato_api ) {
				$this->envato_api = new DTWCBE_WooCommerce_Builder_Elementor_Envato_API( $this );
			}
			return $this->envato_api;
	
		}
	
		/**
		 * Checks if the product is part of the plugins
		 * purchased by the user belonging to the token.
		 *
		 * @access public
		 * @since 1.1.0
		 * @param string $new_value The new token to check.
		 */
		public function check_registration( $new_value ) {
	
			$this->init_globals();
	
			// Get the old value.
			$value = get_option( $this->get_option_name(), array() );
	
			// Check that the new value is properly formatted.
			if ( is_array( $new_value ) && isset( $new_value[ $this->product_id ]['token'] ) ) {
				// If token field is empty, copy is not registered.
				$this->registered[ $this->product_id ] = false;
				if ( ! empty( $new_value[ $this->product_id ]['token'] ) && 32 === strlen( $new_value[ $this->product_id ]['token'] ) ) {
					// Remove spaces from the beginning and end of the token.
					$new_value[ $this->product_id ]['token'] = trim( $new_value[ $this->product_id ]['token'] );
					// Check if new token is valid.
					$this->registered[ $this->product_id ] = $this->product_exists( $new_value[ $this->product_id ]['token'] );
				}
			} else {
				$new_value[ $this->product_id ] = array(
					'token' => '',
				);
			}
			$value = array_replace( $value, $new_value );
	
			// Check the token scopes and update the option accordingly.
			$this->registered['scopes'] = $this->envato_api()->get_token_scopes( $value[ $this->product_id ]['token'] );
			
			// Update the 'woocommerce_builder_elementor_registered' option.
			update_option( 'woocommerce_builder_elementor_registered', $this->registered );
	
			// Return the new value.
			return $value;
	
		}
	
		/**
		 * Checks if the product is part of the plugins
		 * purchased by the user belonging to the token.
		 *
		 * @access private
		 * @since 1.1.0
		 * @param string $token A token to check.
		 * @param int    $page  The page number if one is necessary.
		 * @return bool
		 */
		private function product_exists( $token = '', $page = '' ) {
	
			// Set the new token for the API call.
			if ( '' !== $token ) {
				$this->envato_api()->set_token( $token );
			}
	
			$products = $this->envato_api()->plugins( array(), $page );
	
			// If a WP Error object is returned we need to check if API is down.
			if ( is_wp_error( $products ) ) {
				// 401 ( unauthorized ) and 403 ( forbidden ) mean the token is invalid, apart from that Envato API is down.
				if ( 401 !== $products->get_error_code() && 403 !== $products->get_error_code() && '' !== $products->get_error_message() ) {
					set_site_transient( 'woocommerce_builder_elementor_envato_api_down', true, 600 );
				}
				return false;
			}
	
			// Check if product is part of the purchased plugins.
			foreach ( $products as $product ) {
				if ( isset( $product['name'] ) ) {
					if ( $this->args['name'] === $product['name'] ) {
						return true;
					}
				}
			}
	
			if ( 100 === count( $products ) ) {
				$page = ( ! $page ) ? 2 : $page + 1;
				return $this->product_exists( '', $page );
			}
			return false;
		}
	
		/**
		 * Has user associated with current token purchased this product?
		 *
		 * @access public
		 * @since 1.1.0
		 * @return bool
		 */
		public function is_registered() {
			
			// Is the product registered?
			if ( isset( $this->registered[ $this->product_id ] ) && true === $this->registered[ $this->product_id ] ) {
				return true;
			}
			// Is the Envato API down?
			if ( get_site_transient( 'woocommerce_builder_elementor_envato_api_down' ) ) {
				return true;
			}
			// Fallback to false.
			return false;
	
		}
	
		/**
		 * Prints the registration form.
		 *
		 * @access public
		 * @since 1.1.0
		 * @return void
		 */
		public function the_form() {
	
			// Print styles.
			$this->form_styles();
			?>
			<div class="woocommerce-builder-elementor-important-notice registration-form-container">
				<?php if ( $this->is_registered() ) : ?>
					<p class="about-description"><?php esc_attr_e( 'Congratulations! Your product is registered now.', 'woocommerce-builder-elementor' ); ?></p>
				<?php else : ?>
					<p class="about-description"><?php esc_attr_e( 'Please enter your Envato token to complete registration.', 'woocommerce-builder-elementor' ); ?></p>
				<?php endif; ?>
				<div class="woocommerce-builder-elementor-registration-form">
					<form id="woocommerce_builder_elementor_product_registration" method="post" action="options.php">
						<?php $show_form = true; ?>
						<?php
						$invalid_token = false;
						$token         = $this->get_token();
						settings_fields( $this->get_option_group_slug() );
						?>
						<?php if ( $token && ! empty( $token ) ) : ?>
							<?php if ( $this->is_registered() ) : ?>
								<span class="dashicons dashicons-yes woocommerce-builder-elementor-icon-key<?php echo ( ! $show_form ) ? ' toggle-hidden hidden' : ''; ?>"></span>
							<?php else : ?>
								<?php $invalid_token = true; ?>
								<span class="dashicons dashicons-no woocommerce-builder-elementor-icon-key<?php echo ( ! $show_form ) ? ' toggle-hidden hidden' : ''; ?>"></span>
							<?php endif; ?>
						<?php else : ?>
							<span class="dashicons dashicons-admin-network woocommerce-builder-elementor-icon-key<?php echo ( ! $show_form ) ? ' toggle-hidden hidden' : ''; ?>"></span>
						<?php endif; ?>
						<input <?php echo ( ! $show_form ) ? 'class="toggle-hidden hidden" ' : ''; ?>type="text" name="<?php echo esc_attr( "{$this->option_name}[{$this->product_id}][token]" ); ?>" value="<?php echo esc_attr( $token ); ?>" />
						<?php
						$button_classes = array( 'primary', 'large', 'woocommerce-builder-elementor-large-button', 'woocommerce-builder-elementor-register' );
						if ( ! $show_form ) {
							$button_classes[] = 'toggle-hidden';
							$button_classes[] = 'hidden';
						}
						?>
						<?php submit_button( esc_attr__( 'Submit', 'woocommerce-builder-elementor' ), $button_classes ); ?>
					</form>
	
					<?php if ( $invalid_token ) : ?>
						<p class="error-invalid-token">
							<?php if ( 36 === strlen( $token ) && 4 === substr_count( $token, '-' ) ) : ?>
								<?php esc_attr_e( 'Registration could not be completed because the value entered above is a purchase code. A token key is needed to register. Please read the directions below to find out how to create a token key to complete registration.', 'woocommerce-builder-elementor' ); ?>
							<?php else : ?>
								<?php /* translators: The product name for the license. */ ?>
								<?php printf( esc_attr__( 'Invalid token, or corresponding Envato account does not have %s purchased.', 'woocommerce-builder-elementor' ), esc_attr( $this->args['name'] ) ); ?>
							<?php endif; ?>
						</p>
					<?php elseif ( $token && ! empty( $token ) ) : ?>
						<?php
						// If the token scopes don't exist, make sure we create them and save them.
						if ( ! isset( $this->registered['scopes'] ) || ! is_array( $this->registered['scopes'] ) ) {
							$this->registered['scopes'] = $this->envato_api()->get_token_scopes();
							update_option( 'woocommerce_builder_elementor_registered', $this->registered );
						}
						$scopes_ok = $this->envato_api()->check_token_scopes( $this->registered['scopes'] );
						?>
						<?php if ( ! $scopes_ok ) : ?>
							<p class="error-invalid-token">
								<?php esc_html_e( 'Token does not have the necessary permissions. Please create a new token and make sure the following permissions are enabled for it: View Your Envato Account Username, Download Your Purchased Items, List Purchases You\'ve Made, Verify Purchases You\'ve Made.', 'woocommerce-builder-elementor' ); // phpcs:ignore ?>
							</p>
						<?php endif; ?>
					<?php endif; ?>
	
					<?php if ( ! $this->is_registered() ) : ?>
	
						<div <?php echo ( ! $show_form ) ? 'class="toggle-hidden hidden" ' : ''; ?>style="font-size:17px;line-height:27px;margin-top:1em;padding-top:1em">
							<hr>
	
							<h3><?php esc_attr_e( 'Instructions For Generating A Token', 'woocommerce-builder-elementor' ); ?></h3>
							<ol>
							<li>
								<?php
								printf(
									/* translators: "Generate A Personal Token" link. */
									__( 'Click on this %1$s link. <strong>IMPORTANT:</strong> You must be logged into the same Codecanyon account that purchased <strong>%2$s</strong>. If you are logged in already, look in the top menu bar to ensure it is the right account. If you are not logged in, you will be directed to login then directed back to the Create A Token Page.', 'woocommerce-builder-elementor' ), // phpcs:ignore WordPress.Security.EscapeOutput
									'<a href="https://build.envato.com/create-token/?user:username=t&purchase:download=t&purchase:verify=t&purchase:list=t" target="_blank">' . esc_html__( 'Generate A Personal Token', 'woocommerce-builder-elementor' ) . '</a>',
									esc_html( $this->args['name'] )
								);
								?>
							</li>
							<li>
								<?php
								_e( 'Enter a name for your token, then check the boxes for <strong>View the user\'s Envato Account username, Download the user\'s purchased items, List purchases the user has made</strong> and <strong>Verify purchases the user has made</strong> from the permissions needed section. Check the box to agree to the terms and conditions, then click the <strong>Create Token button</strong>', 'woocommerce-builder-elementor' ); // phpcs:ignore WordPress.Security.EscapeOutput
								?>
							</li>
							<li>
								<?php
								_e( 'A new page will load with a token number in a box. Copy the token number then come back to this registration page and paste it into the field below and click the <strong>Submit</strong> button.', 'woocommerce-builder-elementor' ); // phpcs:ignore WordPress.Security.EscapeOutput
								?>
							</li>
							 <li>
								<?php
								printf(
									/* translators: "documentation post" link. */
									esc_html__( 'You will see a green check mark for success, or a failure message if something went wrong. If it failed, please make sure you followed the steps above correctly.', 'woocommerce-builder-elementor' ),
									'<a href="#" target="_blank">' . esc_html__( 'documentation post', 'woocommerce-builder-elementor' ) . '</a>'
								);
								?>
							</li>
						</ol>
	
						</div>
	
					<?php endif; ?>
				</div>
			</div>
			<?php
	
		}
	
		/**
		 * Print styles for the form.
		 *
		 * @access private
		 * @since 1.1.0
		 * @return void
		 */
		private function form_styles() {
			?>
			<style>
			.registration-form-container {
				margin-bottom: 0;
				padding-bottom: 40px;
			}
			.woocommerce-builder-elementor-library-important-notice{
				padding: 30px;
				background: #fff;
				margin: 0 0 30px;
			}
			.dashicons.dashicons-admin-network.woocommerce-builder-elementor-icon-key {
				line-height: 30px;
				height: 30px;
				margin-right: 10px;
				width: 30px;
			}
	
			#woocommerce-builder-elementor-product-registration {
				float: left;
				width: 100%;
				margin-bottom: 30px;
			}
			#woocommerce_builder_elementor_product_registration {
				display: -webkit-flex;
				display: -ms-flexbox;
				display: flex;
				flex-wrap: wrap;
	
				-webkit-align-items: center;
				-ms-align-items: center;
				align-items: center;
			}
	
			.woocommerce-builder-elementor-registration-form input[type="text"],
			.woocommerce-builder-elementor-registration-form input#submit {
				margin: 0 1em;
				padding: 10px 15px;
				width: calc(100% - 2em - 180px);
				height: 40px;
			}
	
			.woocommerce-builder-elementor-registration-form input#submit {
				margin: 0;
				width: 150px;
				line-height: 1;
			}
	
			#woocommerce_builder_elementor_product_registration p.submit {
				margin: 0;
				padding: 0;
			}
	
			#woocommerce_builder_elementor_product_registration .dashicons {
				margin: 0;
				color: #333333;
				width: 30px;
				height: 32px;
				line-height: 32px;
				font-size: 36px;
			}
	
			#woocommerce_builder_elementor_product_registration .dashicons-yes {
				color: #43A047;
			}
	
			#woocommerce_builder_elementor_product_registration .dashicons-no {
				color:#c00;
			}
	
			.woocommerce-builder-elementor-important-notice p.error-invalid-token {
				margin: 1em 0 0 0 !important;
				padding:1em;
				color:#fff;
				background-color:#c00;
				text-align:center;
			}
			.woocommerce-builder-elementor-thanks {
				margin: 30px 0;
			}
			</style>
			<?php
		}
}
