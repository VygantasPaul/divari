<?php
// define( 'WP_ALLOW_MULTISITE', true );
define('WP_MEMORY_LIMIT', '296M');
define( 'WP_MAX_MEMORY_LIMIT', '296M' );
define('WP_CACHE',false);
define('ALLOW_UNFILTERED_UPLOADS', true);
/**
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dirilt_eshop' );

/** Database username */
define( 'DB_USER', 'dirilt_dirilt' );

/** Database password */
define( 'DB_PASSWORD', '2c27N7NHgasG92Hh' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'x]wq3S6.>)JGeSAyZ)fhGPyYuT6G@kxtxNg$eY5}(]K?{e!;p5L3y1ndaTd-Sf^l' );
define( 'SECURE_AUTH_KEY',  '.~`XdK{ }|HcH:}V*9S]K_<oD{9JM9zcs1lzw+lnm_6xzgR],6jcia-S~j=I,Vim' );
define( 'LOGGED_IN_KEY',    '0W}:<6z=0K>[!/wi5>YgIa~&/BmVP5Jc<,UMk{5-?F$O~Uo[Nu rkvx}(ioccE]1' );
define( 'NONCE_KEY',        '>?W$:upb N;3B<[u08f:M7ZXAkY&U/3BmVQTy3%y2u-8X>s4VZCB&$+MM k!Vnzi' );
define( 'AUTH_SALT',        'A9i?vHIB=hzZj8iB<%WUa/2N~?]h6Vq=0F>%;L7Hh_,cXPc#Mlfd!)9@MR(>9tv}' );
define( 'SECURE_AUTH_SALT', 'XZ{)nKc!:~kngN44h`SoPP p/pJXkQDK cRoxT8l24|D_Jx:|e?1Z=M^/FaWK#pu' );
define( 'LOGGED_IN_SALT',   '8m^XEfhOv!i>0@[lh=%G8BODe.[M$Hi(2d~SL~}iv@EobU1tX[WN_udND3$3`vVd' );
define( 'NONCE_SALT',       'N,9a zY&q:ikOxxhR|i&Q0D[u!{I~IrNRiz)D(u PxS=~GvZ@n%M%(K|-fT%t>M!' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';