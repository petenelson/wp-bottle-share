<?php

namespace WP_Bottle_Share\Untappd\API\Beer;

/**
 * Returns a list of beer styles.
 *
 * @return array
 */
function get_styles() {

	$json = file_get_contents( WP_BOTTLE_SHARE_PATH . 'includes/untappd/assets/beer-styles.json' );

	return json_decode( $json );
}
