<?php

namespace WP_Bottle_Share\Admin\Settings;

add_action( 'admin_init', __NAMESPACE__ . '\add_untappd_api_fields' );


/**
 * Adds fields for Untappd settings.
 *
 * @return void
 */
function add_untappd_api_fields() {

	$page = get_settings_page();
	$section = $page . '-untappd';

	// Add the Untappd section.
	add_settings_section( $section, __( 'Untappd API Settings', 'wp-bottle-share' ), null, get_settings_page() );

	// Register the fields.
	register_setting( $page, $section . '-client-id', 'sanitize_text_field' );
	register_setting( $page, $section . '-client-secret', 'sanitize_text_field' );

	// Add the settings fields.
	add_settings_field(
		$section . '-client-id',
		esc_html__( 'Client ID', 'wp-bottle-share' ),
		'\WP_Bottle_Share\Admin\Settings\input_field',
		$page,
		$section,
		array(
			'name' => $section . '-client-id',
			)
	);

	add_settings_field(
		$section . '-client-secret',
		esc_html__( 'Client Secret', 'wp-bottle-share' ),
		'\WP_Bottle_Share\Admin\Settings\input_field',
		$page,
		$section,
		array(
			'name' => $section . '-client-secret',
			)
	);


	add_settings_field(
		$section . '-numer-of-api-requests',
		esc_html__( '# of API Requests', 'wp-bottle-share' ),
		__NAMESPACE__ . '\display_api_request_count',
		$page,
		$section
	);
}

/**
 * Displays the number of API requests in the past 60 minutes.
 *
 * @return void.
 */
function display_api_request_count() {
	?>
		// TODO
	<?php
}
