<?php

namespace WP_Bottle_Share\Untappd\OAuth;

add_action( 'init', __NAMESPACE__ . '\register_oauth_endpoint' );
add_action( 'parse_request', __NAMESPACE__ . '\oauth_endpoint' );
add_filter( 'query_vars', __NAMESPACE__ . '\add_query_vars' );

// https://untappd.com/api/docs#authentication

/**
 * Gets the page slug to use for the oauth endpoint.
 *
 * @return string
 */
function get_oauth_page() {
	return apply_filters( 'wp-bottle-share-untappd-oauth-endpoint', 'untappd-oauth' );
}

/**
 * Registers oauth endpoint.
 *
 * @return void
 */
function register_oauth_endpoint() {
	add_rewrite_rule( '^' . get_oauth_page() . '/?$', 'index.php?_untappd_oauth=1', top );
}

/**
 * Adds additional query vars.
 *
 * @param array $query_vars List of query vars.
 */
function add_query_vars( $query_vars ) {
	$query_vars[] = '_untappd_oauth';
	return $query_vars;
}

/**
 * Handles the oauth response from Untappd.
 *
 * @return void
 */
function oauth_endpoint( $query ) {

	if ( ! empty( $query->query_vars['_untappd_oauth'] ) && '1' === $query->query_vars['_untappd_oauth'] ) {

		$code = filter_input( INPUT_GET, 'code', FILTER_SANITIZE_STRING );
		if ( ! empty( $code ) ) {

			// Get the access token from Untappd.
			$url = add_query_arg(
				array(
					'client_id' => rawurlencode( \WP_Bottle_Share\Untappd\API\get_client_id() ),
					'client_secret' => rawurlencode( \WP_Bottle_Share\Untappd\API\get_client_secret() ),
					'redirect_url' => rawurlencode( get_redirect_url() ),
					'response_type' => rawurlencode( 'code' ),
					'code' => rawurlencode( $code ),
				),
				'https://untappd.com/oauth/authorize/'
			);

			$response = wp_remote_get( $url );

			if ( ! is_wp_error( $response ) && 200 === absint( wp_remote_retrieve_response_code( $response ) ) ) {

				$body = wp_remote_retrieve_body( $response );
				if ( ! empty( $body ) ) {

					$access_data = json_decode( $body );

					if ( ! empty( $access_data ) && ! empty( $access_data->response ) && ! empty( $access_data->response->access_token ) ) {

						// Add the access token to the user's account.
						update_user_meta(
							get_current_user_id(),
							'wp-bottle-share-untappd-access-token',
							sanitize_text_field( $access_data->response->access_token )
						);

						// So we can put a profile notification.
						update_user_meta(
							get_current_user_id(),
							'wp-bottle-share-untappd-access-token-added',
							'1'
						);

						wp_safe_redirect( home_url( '/' ) );
						exit;
					}

				}
			}
		}

		// If we did not redirect, then there was some sort of error in auth.
		wp_die(
			__( 'Unable to authenticate with Untappd', 'wp-bottle-share' ),
			__( 'Untappd error', 'wp-bottle-share' ),
			array(
				'back_link' => true,
				)
			);

	}
}

/**
 * Gets the redirect URL for the Untapp oauth call.
 *
 * @return string
 */
function get_redirect_url() {
	return home_url( get_oauth_page() );
}

/**
 * Gets the OAuth URL for Untappd access.
 *
 * @return string
 */
function get_oauth_url() {

	$url = add_query_arg(
		array(
			'client_id' => rawurlencode( \WP_Bottle_Share\Untappd\API\get_client_id() ),
			'redirect_url' => rawurlencode( get_redirect_url() ),
			'response_type' => rawurlencode( 'code' ),
		),
		'https://untappd.com/oauth/authenticate/'
	);

	return $url;
}
