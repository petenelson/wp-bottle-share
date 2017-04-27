<?php
/**
 * REST API functionality for Untappd venues.
 *
 * @package petenelson/wp-bottle-share
 */

namespace WP_Bottle_Share\REST_API\Venue;

add_action( 'rest_api_init', __NAMESPACE__ . '\register_venue_route' );

/**
 * Registers the venue/info route.
 *
 * @return void
 */
function register_venue_route() {

	register_rest_route(
		'wp-bottle-share/v1',
		'venue/info/(?<id>\d+)',
		array(
			'callback' => __NAMESPACE__ . '\info_route',
			'methods' => 'GET',
			'permission_callback' => 'is_user_logged_in',
			'args' => array(
				'id' => array(
					'required' => true,
					'sanitizie_callback' => 'absint',
					),
				'user_id' => array(
					'required' => true,
					'sanitizie_callback' => 'absint',
					),
				),
			)
	);

	register_rest_route(
		'wp-bottle-share/v1',
		'venue/unhad/(?<id>\d+)',
		array(
			'callback' => __NAMESPACE__ . '\unhad_route',
			'methods' => 'GET',
			'permission_callback' => 'is_user_logged_in',
			'args' => array(
				'id' => array(
					'required' => true,
					'sanitizie_callback' => 'absint',
					),
				'user_id' => array(
					'required' => true,
					'sanitizie_callback' => 'absint',
					),
				),
			)
	);

}

/**
 * Handler for the venue/info route.
 *
 * @param  WP_REST_Request $request The REST request.
 * @return WP_REST_Response.
 */
function info_route( $request ) {

	$response = \WP_Bottle_Share\Untappd\API\Venue\get_info( $request['id'], $request['user_id'] );

	return rest_ensure_response( $response );
}

/**
 * Handler for the venue/unhad route.
 *
 * @param  WP_REST_Request $request The REST request.
 * @return WP_REST_Response.
 */
function unhad_route( $request ) {

	$response = \WP_Bottle_Share\Untappd\API\Venue\get_unhad_beers( $request['id'], $request['user_id'] );

	return rest_ensure_response( $response );
}
