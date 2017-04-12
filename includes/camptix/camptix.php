<?php

namespace WP_Bottle_Share\CampTix;

add_filter( 'camptix_default_addons', __NAMESPACE__ . '\add_default_addons' );

function add_default_addons( $addons ) {

	if ( ! isset( $addons['require-login'] ) ) {
		$addons['require-login'] = $GLOBALS['camptix']->get_default_addon_path( 'require-login.php' );
	}

	return $addons;
}
