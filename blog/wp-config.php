<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'chrish_wp813');

/** MySQL database username */
define('DB_USER', 'chrish_rab');

/** MySQL database password */
define('DB_PASSWORD', '6qchP77Sad');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'zwu8vgscj1tx8adel8nda1w0btvk4sdszlvbesbnuhkmmoxiyhaa8k5la7mquvlp');
define('SECURE_AUTH_KEY',  'zz6c1h6ma7whkqugskcp6bj2jkglklzvmcf7kjionqrguyfpeyhi66wtvjdttlzn');
define('LOGGED_IN_KEY',    'qyripina2vm9f5a7anjnxnk6x0oufabyz9iqdqrl1uezgnvssomqbwlns44x7ryf');
define('NONCE_KEY',        'hddga7lbsccisjvwomeq2qorfb9pbmuooql9epkg3bxjmhbeu0lt4mf34ofix8a3');
define('AUTH_SALT',        'qgis7poziytn696pcd5rijl5hayzzsruw8rc4aw6f4uoyuia5edeab7smqpwjtxz');
define('SECURE_AUTH_SALT', 'djvm0dholsqa6ybobdkjzi080rmgpxeqr6idrvmpobxm69kp2vi8etjpvtnuemmg');
define('LOGGED_IN_SALT',   'nylmfmlmep22swl2d78hbqahaa0siqtoxjr9tvzmnpjpbbxjcgowokkuhzsfgihj');
define('NONCE_SALT',       'c4flxfqvqauqqtx4zef67duaslzx0vecg3hh4hadiuuerotzaz2ttrscx6j4nu7x');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
