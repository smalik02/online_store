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
define('DB_NAME', 'wordpress_shoppe');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Malick_9601');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'L?3=YG:h]PyvW~!H^6/QREToq#-x}39cD6Wu(q`)bv<S7sEGeF^|2GrmLddCAT+z');
define('SECURE_AUTH_KEY',  'g1$.[_5LAmHE@*p5W%rf`:mn>340Gn<acuX|Kq&H+bH`Mc ]1aAK>wK)/n2DqROi');
define('LOGGED_IN_KEY',    'JuIOVs5:+3f+QxM7_k&FG(EMf T@4-<,u~hhn^6/.+Q~*d_X;nV nq4L|Ti<=}}8');
define('NONCE_KEY',        '#i%3(yW;&zrd=X*};3>6=O^L$#|5=oEKeLF}EiENwf|l~S- yI!&oPk-c*Fk}aTG');
define('AUTH_SALT',        'VApVh=xAj;-3gz6wLE=$sF&T:w3D3d)*i)_NDMQC]},2D:DAmnhgq.+(Jk,DkRv^');
define('SECURE_AUTH_SALT', ']_-+Utbg|=grFnXwFcm +F?3KDHqbwJB8xU}_$a2f;qADwg3;>SLS@!JLdUf BO#');
define('LOGGED_IN_SALT',   'qgvR&UlMc+I#n,2jx7Ed-k]h3rFE}8u8gN&S}5cRc=7YhhgHb%b1d|p,B{]bf:D_');
define('NONCE_SALT',       ' |U8L{?tR4LumtYoj*/vr}Q`[P(*,f9su>TbucC.TPZnzgoUI?t)ej3iKMm-i@Z(');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
