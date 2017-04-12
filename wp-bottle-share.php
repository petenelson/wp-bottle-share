<?php
/**
 * Plugin Name: WP Bottle Share
 * Description: Manage craft beer bottle shares
 * Author: Pete Nelson
 * Version: 1.0.0
 * Plugin URI: https://github.com/petenelson/wp-bottle-share
 * Text Domain: wp-bottle-share
 * Domain Path: /languages
 * License: GPL2+
 *
 * @package wp-bottle-share
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WP_BOTTLE_SHARE_VERSION' ) ) {
	define( 'WP_BOTTLE_SHARE_VERSION', '1.0.0' );
}

if ( ! defined( 'WP_BOTTLE_SHARE_ROOT' ) ) {
	define( 'WP_BOTTLE_SHARE_ROOT', trailingslashit( dirname( __FILE__ ) ) );
}

if ( ! defined( 'WP_BOTTLE_SHARE_PATH' ) ) {
	define( 'WP_BOTTLE_SHARE_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'WP_BOTTLE_SHARE_URL' ) ) {
	define( 'WP_BOTTLE_SHARE_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}

if ( ! defined( 'WP_BOTTLE_SHARE_FILE' ) ) {
	define( 'WP_BOTTLE_SHARE_FILE', __FILE__ );
}

if ( ! defined( 'WP_BOTTLE_SHARE_BASENAME' ) ) {
	define( 'WP_BOTTLE_SHARE_BASENAME', plugin_basename( WP_BOTTLE_SHARE_FILE ) );
}

$requires = array(
	'admin/settings.php',
	'admin/scripts.php',
	'admin/untappd.php',
	'admin/user-profile.php',
	'untappd/api.php',
	'untappd/oauth.php',
	'untappd/user.php',
	'untappd/beer.php',
	'post-type/bottle-share.php',
	'meta-box/bottle-share.php',
	'camptix/camptix.php',
);

foreach( $requires as $require ) {
	require_once WP_BOTTLE_SHARE_PATH . 'includes/' . $require;
}
