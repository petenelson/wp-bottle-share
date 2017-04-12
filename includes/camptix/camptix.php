<?php

namespace WP_Bottle_Share\CampTix;

if ( function_exists( 'camptix_register_addon' ) ) {

	$addons_files = array(
		// 'field-untappd-user-name.php',
		'field-favorite-beer-style.php',
	);

	foreach( $addons_files as $addon_file ) {
		require_once WP_BOTTLE_SHARE_PATH . 'includes/camptix/addons/' . $addon_file;
	}
}
