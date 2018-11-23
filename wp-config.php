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
define('DB_NAME', 'ecommerce');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'L_s]=V9+?>>2@*=&.sBA/cNF`nS/-:N ioRm==eF8[79ba;,~=+Naq=z{&y2y)xt');
define('SECURE_AUTH_KEY',  '|Na}W7ZPubc=BEvml+XR$SZzjTrKi2a2{ Vq-K8^$Xx0=XG9~|,vpD(Qe!mqW:r*');
define('LOGGED_IN_KEY',    'i#_gZBFK,Zn7R>@?E{?EFKtkC3Oh*i^Uo.o}-Nl~1=hU)NxqjI2.ve_k0PV@NKuz');
define('NONCE_KEY',        'IVX`.VmjPPUF38{RzcGU>=46i]Vx>;ja_.}|*0&P9C1IDk6L0IU1N1BTdNZEzt6h');
define('AUTH_SALT',        'G:/R977WP Y&Q7M/fORxlQ)#+s4`RxC/anu:VCr[o25KU:GKQz$Tw@;j-Ez67%sY');
define('SECURE_AUTH_SALT', 'k9 .hZ3LV&2@SvC}D-L2KI,Hf+#p@ETp^[7`:<2a*iOgMH5L=6]_nOR()7PX./Is');
define('LOGGED_IN_SALT',   '8]~X|=<6k&<9m.rY=^`SEv&uj&82T$j~6,3)JqqS<>BR,|OM:JGP^H{<GxtY B3|');
define('NONCE_SALT',       ',-]9|-eTQp!;5gT<+MFWaA]t`w[9#0.4_E^C !Ii1{:fJbj Esuz$rzlr9<KUO8;');

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
