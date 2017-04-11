<?php

namespace WP_Bottle_Share\Admin\Scripts;

add_action( 'admin_init', __NAMESPACE__ . '\register_styles' );
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_styles' );
add_action( 'admin_footer', __NAMESPACE__ . '\admin_footer_style' );

function register_styles() {
	wp_register_style(
		'wp-bottle-share-font-awesome',
		'https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
	);
}

function enqueue_styles() {
	wp_enqueue_style( 'wp-bottle-share-font-awesome' );
}

function admin_footer_style() {

	// Eventually we'll move this into a real stylesheet.

	?>
	<style type="text/css">
		#adminmenu .menu-icon-bottle-share div.wp-menu-image:before {
			font-family: Fontawesome !important;
			content: "\f0fc";
		}
	</style>

	<?php
}