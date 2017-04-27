<?php
/**
 * Functionality for Untappd venues.
 *
 * @package petenelson/wp-bottle-share
 */

namespace WP_Bottle_Share\Untappd\API\Venue;

/**
 * Gets information for a venue.
 *
 * @param  int $venue_id The Untappd venue ID.
 * @param  int $user_id  The WP user ID.
 * @return object
 */
function get_info( $venue_id, $user_id ) {
	return \WP_Bottle_Share\Untappd\API\untappd_remote_get( 'venue/info/' . absint( $venue_id ), $user_id );
}

/**
 * Gets checkins for a venur.
 *
 * @param  int $venue_id The Untappd venue ID.
 * @param  int $user_id  The WP user ID.
 * @return array
 */
function get_checkins( $venue_id, $user_id ) {

	return \WP_Bottle_Share\Untappd\API\untappd_remote_get( 'venue/checkins/' . absint( $venue_id ), $user_id,
		array(
			'query' => array(
				'limit' => 50,
				),
			)
	);
}

/**
 * Gets beers at a venue that the user has not checked into.
 *
 * @param  int $venue_id The Untappd venue ID.
 * @param  int $user_id  The WP user ID.
 * @return array
 */
function get_unhad_beers( $venue_id, $user_id ) {

	$beers = array();

	$response = get_checkins( $venue_id, $user_id );

	if ( ! empty( $response ) && ! empty( $response->checkins ) && ! empty( $response->checkins->items ) ) {

		foreach ( $response->checkins->items as $item ) {
			if ( false === $item->beer->has_had && ! isset( $beers[ $item->beer->bid ] ) ) {

				// Set the URL for Untappd.
				$item->beer->url = 'https://untappd.com/b/' . $item->beer->beer_slug . '/' . $item->beer->bid;

				// Add the brewery.
				if ( ! empty( $item->brewery ) ) {

					// Brewery URL.
					$item->brewery->url = 'https://untappd.com/w/' . $item->brewery->brewery_slug . '/' . $item->brewery->brewery_id;

					// Add the brewery to the beer.
					$item->beer->brewery = $item->brewery;
				}

				// Add the beer to the response list.
				$beers[ $item->beer->bid ] = $item->beer;
			}
		}
	}

	return $beers;
}
