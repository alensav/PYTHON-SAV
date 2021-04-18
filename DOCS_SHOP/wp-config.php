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
define('DB_NAME', 'h901105040_s1');

/** MySQL database username */
define('DB_USER', 'h901105040_u2');

/** MySQL database password */
define('DB_PASSWORD', 'BQuL51w8d-');

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
define('AUTH_KEY',         ')BG)t&)SULWoN2JEBv4YjHUq5Giv)*8jBv4Oq58)4^OL02#E^#7GMZO)VHnMlOF)');
define('SECURE_AUTH_KEY',  'A8t3(mh^SOSIkfX6@sd!qHEjReXrkE)ISALUz^IK^kMZ74rAnrYUpTWAHxKY5)@V');
define('LOGGED_IN_KEY',    'V@lWWU#SA@oy(#1hnB8JhnZXrX6sYpqf0&#7sjn&(Wo1YYJs%3t7mPUlvkgwYB2T');
define('NONCE_KEY',        'WaFE!EE0dnYVYirOHxziDl%W%XGkTWX85p&Z^sbpuI%#3x#n)AAA6Yt#K%OY4GqQ');
define('AUTH_SALT',        '%UsTH5UZjk&VIOoc%beTa*nzuY61TS&8hRN1i*WwQylEDPpL7gb2*2FZP34!KmvJ');
define('SECURE_AUTH_SALT', 'W*)D9jf)bxy*@O!UFINoIpAF*unw5iR181xK4EgKiD^J04S8Dt5K#EC3M4OCaJoO');
define('LOGGED_IN_SALT',   'mcc(hATttrX2FibU0TqoQK9Et@vG&QKO6x8nRt(4vHddPsPp(emudoC6#gU&1Jql');
define('NONCE_SALT',       '9v6)yILBmO2rYHKg&GRlHdp7V17!oPtEHq(!SohsWDeSsdB6hFF6*Zw5gXFzZ^0o');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'cms_wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
