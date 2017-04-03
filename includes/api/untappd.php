<?php

namespace WP_Bottle_Share\API\Untappd;

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
 * @param  string  $action Action to perform (user/checkins, beer/info, etc).
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

function get_client_id() {
	return get_option( 'wp-bottle-share-untappd-client-id' );
}

function get_client_secret() {
	return get_option( 'wp-bottle-share-untappd-client-secret' );
}
