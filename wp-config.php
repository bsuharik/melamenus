<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'melamenu_wp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'LRdzaWdj4DT9qo' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'CP>K5+Hze/[PK3uQz2qud+P{lm}knbT{q-))Qdr%lR,2NI?ZBpFIc WCzk/oJ$A(' );
define( 'SECURE_AUTH_KEY',   '&v*.|(#D!Zq?*qT<,w/QUjSbv!}w-=C<1I]%Ia[wgx#I^j$*,uC|K_vEr+VZB^J?' );
define( 'LOGGED_IN_KEY',     'v$jV<PY/gS386.az?<j5AYBZZk5;,Bg3dm33?v%ro~4 :<7&GnbsKn0qf#8f$=#^' );
define( 'NONCE_KEY',         'GI8-<al/i{gET[7|sSV7{is*N+c@7ys1u4An.Y7B(5P+29mMy?/U][wcqHoNVfu#' );
define( 'AUTH_SALT',         'saL(Zts-/iE#ncXj_=+_2>N^R+{IMI;@=0rlG7xyOMaD.Pwn6o=G/S[3m!w`pLMZ' );
define( 'SECURE_AUTH_SALT',  '!mkU@t6$XuPY1P,3ne rLQ!jJ ?iK-i#~l?Yion=P-B9+*be{5*GATs-/]~_Mw_m' );
define( 'LOGGED_IN_SALT',    'Pz+>BMX_s3Z*s,bt]Gh@1={U}P@,?McQ(m4S`;nU7+y]([B>Bx,WyPK/e!mhHT w' );
define( 'NONCE_SALT',        'Sk$nzH?dR<Jg%qhW=MA)F-U6-KeN tfCzR{|Czkj;r|ZD}Mh^^L3S[MH.z!F:lGL' );
define( 'WP_CACHE_KEY_SALT', '@z;Vlbx_J]yiI:Df8i#bq7[ET=E+#5(BuI.nC$sDz/4UGzi%PerK}n@N;&T#EZub' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

define( 'FS_METHOD', 'direct' );
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
