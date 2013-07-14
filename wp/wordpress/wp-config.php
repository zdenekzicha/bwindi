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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'kAx:_{h,slw Sq9I_BiYJ3D +p=x)}zh/gH~)h!{h`NNyKg|V_ {o4Q)8Du,Fd@,');
define('SECURE_AUTH_KEY',  'QAUNqi]M.[yh!4~Egl}kyeJ%*lTGmO&L2+a(f7z+z11HCc-IJ7tVHfUs@Xl+{Z6@');
define('LOGGED_IN_KEY',    '3Vuug+*rswjKw,BtKaTR8e!{0F|]=0ZLbbEh@-3V/tl{JE{.)=a&lPaEaL< 4te(');
define('NONCE_KEY',        'cQh9|7r.+xKe1ow)^+8%r`o**DU-=03dCew~iLH+U({996%;wW8SC<r-((!B-@1B');
define('AUTH_SALT',        ')@,!%d;i@{_:wdWyWhkCQ5S zH&]x$Rqs,SuwD|x)?qldG/Y?--MeSPb$*oW|f~R');
define('SECURE_AUTH_SALT', '0(xUFqK@Jpm=V}B([JKm1.+]U{I|se1]Abi,1&qD5%&coId> D)%RwRs7`#wJS0G');
define('LOGGED_IN_SALT',   'B_[d0Qr%+p8=mX^fVOot|#c28l<>=5hER-L.6@8=^2m5[R|@(X1`-lLm5mnha9+s');
define('NONCE_SALT',       '8 (T1_0~fz^2?wj32sQT!6OyBLVm!&Z]9:.p|`--{@BB4pdvi)?+V4CDX%`?Ye)n');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
