<?php
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
define( 'DB_NAME', 'wpvotingsystem' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'pDIpGQ].M0?y^?WM@@hM-X;FPpXKKUB*JEHxUoYHuuUvR!HbypF|+#U=3pk (&0%' );
define( 'SECURE_AUTH_KEY',  'rHCn!yY&Nj$E:XE1Oxnsf:-5|S3nxd$i.kw=*61D%,GDGML:-n~Jl|Ck6DEmsNfs' );
define( 'LOGGED_IN_KEY',    'JN<K9MphayLSTqRj@AxD6#N4M$k5{.1F=T b|=7LU^+aTzo*Dql/C13:QVB-.}Jh' );
define( 'NONCE_KEY',        '>yN$5Y0+k:SY;4sl^RXv?<n,FO<-&7?Ers?}X2y|-u(Rgkr1Qq+G|&tYo(_j)}v>' );
define( 'AUTH_SALT',        'mpF%ijd8uZ4JiY;lXe;=T!V5@FUQzKZf]M&  >&K?5&V,&?Pf85j$fx9PmZ$s=0O' );
define( 'SECURE_AUTH_SALT', 'Xp7frx@+Rs!fs%ZJL%btALpZ#JkGru(B(36(ht4M=PML/,>&b.J?/0m!<8VO^.aj' );
define( 'LOGGED_IN_SALT',   'RqcDZ_C^i0KD|ued;^q,#!9a4}8nq29 Hl~@^A:gpbg36wA2}+# Q&^t>|<{&&m1' );
define( 'NONCE_SALT',       'y?w> d8pgok08I&2mQeALfQv$3b<Vah M9I  gRq0a*_P:X1uaF[56kJ$Oj_tpq[' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
