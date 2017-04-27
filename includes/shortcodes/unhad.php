<?php
/**
 * Functionality for unhad beers shortcode.
 *
 * @package petenelson/wp-bottle-share
 */

namespace WP_Bottle_Share\Shortcodes\Unhad;

add_action( 'init', __NAMESPACE__ . '\add_unhad_shortcode' );

/**
 * Adds the wpbs-unhad shortcode.
 *
 * @return void
 */
function add_unhad_shortcode() {
	add_shortcode( 'wpbs-unhad', __NAMESPACE__ . '\unhad_shortcode' );
}

/**
 * Generates the wpbs-unhad shortcode HTML.
 *
 * @param array $args The shortcode args.
 * @return string
 */
function unhad_shortcode( $args ) {

	$template = apply_filters( 'wp-bottle-share-shortcode-template-unhad',
		WP_BOTTLE_SHARE_PATH . 'templates/shortcode-unhad.php'
	);

	ob_start();

	include_once $template;

	return ob_get_clean();
}
