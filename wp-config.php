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
define( 'DB_NAME', 'pipefy' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'oFH.}tWJ D.w>Eof3+r5FJH_w[C-cm*%W3ww1O$F]k+%jU*:62qS1CQFIS[$?#T~' );
define( 'SECURE_AUTH_KEY',  'u2QG x](-@xENb-%S##{>Idt)U-b`miq^1a72%(Ho9aiEdg[xQA qe%FK7 $h1hb' );
define( 'LOGGED_IN_KEY',    '(d.30^op$!oS=PWJRP7MBhNfs_VdY>(hZ CI9S8Okvb2;SZxi9sZ@9#Tj-]>sPT:' );
define( 'NONCE_KEY',        'V7f?@ptZ}V$P_g@IKvt442a-^|;Y2B! !4a8Q%`:])vK.S(k-W>Fvff<VzHRj-Ua' );
define( 'AUTH_SALT',        'sy[X}NPh|(CcV[I~)Yb,+V$!gs~Ks;O:_n%gSO%K=)h)@-}$vAgEvoi9J_@cy#;A' );
define( 'SECURE_AUTH_SALT', 'R:x_Aphb$@+jIwnH+-h4CU}01.JebO[gL3h=C~-8zoLGB$Eed5EX:M[FP5gT6-*K' );
define( 'LOGGED_IN_SALT',   'KI;d:adi.0XP0S#,] Ylj^t~Ci_18f72o+aqiKU`4[^27y/uxaEm G`.SGbY-m)U' );
define( 'NONCE_SALT',       'GqGES,d2Ilc,85IS$tur,/XlGz09K$6F@E%_7e-5J[XUXFW4W02zEBLu@x3`Yb3P' );

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
