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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'smsfasso_wpspaa');

/** MySQL database username */
define('DB_USER', 'smsfasso_wpspaa');

/** MySQL database password */
define('DB_PASSWORD', '[1i7S8!PSN');

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
define('AUTH_KEY',         '038xfhepd6gmerbca3iyx2as24jxbzfa1lifksm5a6rdhh5zo5maw7dxt6iv75gx');
define('SECURE_AUTH_KEY',  'lkauhjrehxskbtj0zcskrskvcv9smwdfcv0iztt8k8fiejvcekn0k6uz7kazis3h');
define('LOGGED_IN_KEY',    'gxm5ztcfmkfkx5xxzscrdvwuxxw3pgvtwyp8dzb3nl88xrhwz1fp6wmu5gwj04xf');
define('NONCE_KEY',        '39fdeoas26xcs5jxq442azm2ylk3bp8mrvye95tz5kczwpvufeajxxny2urldrjp');
define('AUTH_SALT',        'jee2thjlqn99ld1pnakbmthvsyjttmub4xiz3aa25nuw6o7rkdmamocuvv8b3zxl');
define('SECURE_AUTH_SALT', 'rvu8lnchshyefhlufuoaaom20zxq7m5zgguegzrleskq4hgvcvqrlzhxrdvjlv0j');
define('LOGGED_IN_SALT',   'n6wld4rccdraybjviqtpkjtwyn9zvrr2lgftrjfv9aignzec7nwkajs6zph7ccdv');
define('NONCE_SALT',       'jayksaw09mfceqpoviibwbkaq1n3mxqoefekemrwyirsvqimpmva8g6zendxps6z');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true	);
define('DISABLE_WP_CRON', true);
define('WP_MEMORY_LIMIT', '256M');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
