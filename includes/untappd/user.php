<?php

namespace WP_Bottle_Share\Untappd\API;

function get_untappd_user( $username = '' ) {

	$response = false;

	if ( ! empty( $username ) ) {

		// Get the user by their username.
		$response = untappd_remote_get( 'user/info/' . trim( sanitize_key( $username ) ) );
	} else if ( ! empty( \WP_Bottle_Share\Untappd\API\get_access_token() ) ) {

		// We don't need the username to get the current user info based
		// on their access token.
		$response = untappd_remote_get( 'user/info' );
	}

	return ! empty( $response ) && ! empty( $response->user ) ? $response->user : false;
}

function get_user_property( $property, $user = '', $default = '' ) {

	$user = get_untappd_user( $user );

	if ( ! empty( $user ) && isset( $user->{$property} ) ) {
		return $user->{$property};
	} else {
		return $default;
	}
}

function get_user_name( $user_id = 0 ) {
	return get_user_property( 'user_name' );
}

function get_user_url( $user_id = 0 ) {
	return get_user_property( 'untappd_url' );
}

function get_user_avatar( $user_id = 0 ) {
	return get_user_property( 'user_avatar' );
}
