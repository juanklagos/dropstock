<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dropstock' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'eX0EGiJv5yHbRsnOKSSzqKXv1tKJjArMhNyjWccATPA5fCxlobTg1s2EkNLiu6F4' );
define( 'SECURE_AUTH_KEY',  'FufOFeAUj7Eg8jNLIfAxLUNAS6NTKFUeJMNBlHBtjEHTlV86B96sKb0WNBXZfawK' );
define( 'LOGGED_IN_KEY',    'sqvAFez8uwKpYNweEuf7bBRypYeu7G2aU4XyQq9XGjoi7Xbp46j9fFv0lKJTgMDS' );
define( 'NONCE_KEY',        'ic7p5SpwIBeaBvuk48r3Kawn71sEVUOQvOk3J6Ry5lBhgJ7SrTbiEvyI9l0AY89D' );
define( 'AUTH_SALT',        'nBqOFH1CnVSGnYkp425WtJS398UsmKVjpskDNf88seZOMD4hlvffmf78TovAbeKq' );
define( 'SECURE_AUTH_SALT', 'om55tdThVWI1DZHf07A7Ux51PXO7UbIlt9Vc4y1rRokds1esmp1gfghO0zD21UzW' );
define( 'LOGGED_IN_SALT',   'B6LKEDQdNTUUujtPXCrueAM6xCodaQvI2IJSHt4ugHM4DYGl1pF8BsACTltcXUIe' );
define( 'NONCE_SALT',       'Ss9yEkuzMaUZU6IFEXnBQoGTzyyukUDxphXz8itMFJi2DsStw7CVMnh08ZyXhnCN' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
