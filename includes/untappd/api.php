<?php

namespace WP_Bottle_Share\Untappd\API;

// https://untappd.com/api/docs

/**
 * Gets the Untappd API endpoint
 *
 * @return string
 */
function get_endpoint() {
	return apply_filters( 'wp-bottle-share-untappd-endpoint', 'https://api.untappd.com/v4' );
}

/**
 * Gets a Untappd action URL.
 *
 * @param  string $action Action to perform (user/checkins, beer/info, etc).
 * @return string
 */
function get_action_url( $action ) {

	// Get the endpoint URL.
	$url = trailingslashit( get_endpoint() ) . trim( $action );

	if ( is_user_logged_in() ) {

		// Add the user's access token.
		$access_token = get_user_meta( get_current_user_id(), 'wp-bottle-share-untappd-access-token', true );
		if ( ! empty( $access_token ) ) {
			$url = add_query_arg( 'access_token', rawurlencode( $access_token ), $url );
		}
	} else {

		// Add the client ID and secret.
		$url = add_query_arg(
			array(
				'client_id' => rawurlencode( get_client_id() ),
				'client_secrect' => rawurlencode( get_client_secret() ),
			),
			$url
		);
	}

	return apply_filters( 'wp-bottle-share-untappd-action-url', $url );
}

/**
 * Gets the Untappd Client ID.
 *
 * @return string
 */
function get_client_id() {
	return get_option( 'wp-bottle-share-untappd-client-id' );
}

/**
 * Gets the Untappd Client Secret.
 *
 * @return string
 */
function get_client_secret() {
	return get_option( 'wp-bottle-share-untappd-client-secret' );
}

/**
 * Performs a API request against the Untappd API.
 *
 * @param  string $action Action to perform (user/checkins, beer/info, etc).
 * @param  array  $args   Additional args for wp_remote_get().
 * @return object
 */
function untappd_remote( $action, $method = 'GET', $args = array() ) {

	$args = wp_parse_args( $args, array(
		'timeout' => 5,
		)
	);

	// Get the base URL.
	$url = get_action_url( $action );

	// Add any query args.
	if ( ! empty( $args['query'] ) && is_array( $args['query'] ) ) {

		foreach( $args['query'] as $key => $value ) {
			$url = add_query_arg( $key, rawurlencode( $value ), $url );
		}
		unset( $args['query'] );
	}

	// Check for cached response first.
	$cache_key = get_cache_key( $url, $method, $args );
	$data = get_transient( $cache_key );
	if ( false !== $data ) {
		return $data;
	}

	switch ( $method ) {
		case 'POST':
			$response = wp_remote_post( $url, $args );
			break;
		
		default:
			$response = wp_remote_get( $url, $args );
			break;
	}

	// Make sure the request succeeded
	if ( ! is_wp_error( $response ) && 200 === absint( wp_remote_retrieve_response_code( $response ) ) ) {

		$body = wp_remote_retrieve_body( $response );

		if ( ! empty( $body ) ) {
			// Make sure this is a valid response before caching and
			// returning the response.

			$o = json_decode( $body );

			if ( ! empty( $o ) && ! empty( $o->meta ) && ! empty( $o->meta->code ) && 200 === $o->meta->code && ! empty( $o->response ) ) {

				$cache_time = apply_filters( 'wp-bottle-share-untappd-cache-time', MINUTE_IN_SECONDS * 5, $action );

				// Cache the response data.
				set_transient( $cache_key, $o->response, $cache_time );

				return $o->response;
			}
		}
	}

	return false;
}

function untappd_remote_get( $action, $args = array() ) {
	return untappd_remote( $action, 'GET', $args );
}

function untappd_remote_post( $action, $args = array() ) {
	return untappd_remote( $action, 'POST', $args );
}

/**
 * Gets the access token for the current user or the supplied user ID.
 *
 * @return string
 */
function get_access_token( $user_id = 0 ) {

	if ( empty( $user_id ) && is_user_logged_in() ) {
		$user_id = get_current_user_id();
	}

	if ( ! empty( $user_id ) ) {
		return get_user_meta( get_current_user_id(), 'wp-bottle-share-untappd-access-token', true );
	} else {
		return false;
	}
}

/**
 * Builds a cache key based on the URL and args.
 *
 * @param  string $url  Untappd API URL.  
 * @param  array  $args Additional args for wp_remote_get().
 * @return string
 */
function get_cache_key( $url, $method, $args ) {
	return md5( $url . $method . json_encode( $args ) );
}
