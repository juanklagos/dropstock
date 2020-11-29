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
define( 'DB_NAME', 'drop' );

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
define( 'AUTH_KEY',         'KZf7dG9v6q68jWfzzC8Ysl7vXEEbLNoxbXesAzxp2o5G12MCZSfNIJWDCAHV5bcf' );
define( 'SECURE_AUTH_KEY',  '53j51Gtha1Qog9XEbLbPmTa2kRmCPfQOnuRcOfmWr9CNR4JZohuyIn1Sk62fL6S4' );
define( 'LOGGED_IN_KEY',    'Q0dLB3ChiLyXlpsuGBh3CIE9GC2CK5i30hPDU3HiOsMCciUcUo5LiuFJDOcm7YCy' );
define( 'NONCE_KEY',        'KzvJOY07DaPTvyTPY4AIt2tFIUNXtHpaz1B0AzO9bb3KcCATaTeSx471UgQDcLTz' );
define( 'AUTH_SALT',        'ROacNrzpl0Q14eXxqlLZmsqcVa3kmKcmT9Ng3GgOAqWR8hpq1lWj0alKVJPr6BSY' );
define( 'SECURE_AUTH_SALT', 'OT9jNFMEMQU9LOR9CCbpvwrrhJnOZMEV9QZNw7LTYSe8Y8Qm0ypnds9JH4IhxPVf' );
define( 'LOGGED_IN_SALT',   'ZNuUAqTnB9IrRVp6YJtpFHzGPgbmNeMAhWBXL6CPnQbnJkp9RHpKEhKcboVFN8GU' );
define( 'NONCE_SALT',       'elwFbuGwwKjWvtpieFRa9CSDG4y4v6eGe2C9NXQZMvaMj4J0ryI6UQKmaBoDqQdP' );

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
