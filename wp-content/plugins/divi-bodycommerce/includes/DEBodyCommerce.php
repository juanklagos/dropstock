<?php

class DE_BodyCommerce extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'divi-bodyshop-woocommerce';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $name = 'divi-bodyshop-woocommerce';

	/**
	 * The extension's version
	 *
	 * @since 2.1.5
	 *
	 * @var string
	 */
	public $version = DE_DB_WOO_VERSION;
	/**
	 * DE_BodyCommerce constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'divi-bodyshop-woocommerce', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}


}

new DE_BodyCommerce;
