<?php

namespace WP_Bottle_Share\Untappd\API;

function get_untappd_user( $user_id = 0 ) {

	$response = false;

	if ( empty( $user_id ) ) {
		$user_id = get_current_user_id();
	}

	if ( ! empty( $user_id ) && ! empty( \WP_Bottle_Share\Untappd\API\get_access_token( $user_id ) ) ) {

		// We don't need the username to get the current user info based
		// on their access token.
		$response = untappd_remote_get( 'user/info', $user_id );
	}

	return ! empty( $response ) && ! empty( $response->user ) ? $response->user : false;
}

function get_user_property( $property, $user_id = 0, $default = '' ) {

	$user = get_untappd_user( $user_id );

	if ( ! empty( $user ) && isset( $user->{$property} ) ) {
		return $user->{$property};
	} else {
		return $default;
	}
}

function get_user_name( $user_id = 0 ) {
	return get_user_property( 'user_name', $user_id );
}

function get_user_url( $user_id = 0 ) {
	return get_user_property( 'untappd_url', $user_id );
}

function get_user_avatar( $user_id = 0 ) {
	return get_user_property( 'user_avatar', $user_id );
}
