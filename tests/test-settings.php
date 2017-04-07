<?php

use WP_Mock as M;

class WP_Bottle_Share_Test_Settings extends WP_Bottle_Share_Base_Test {

	public function require_files() {
		require_once PROJECT . '/includes/admin/settings.php';
	}

	public function test_settings() {
		M::expectActionAdded( 'admin_menu', 'WP_Bottle_Share\Admin\Settings\add_settings_page' );
		$this->require_files();
	}

	public function test_add_settings_page() {
		$this->require_files();

		M::wpFunction( 'add_options_page', array(
			'times' => 1,
			'args' => array(
				'WP Bottle Share Settings',
				'WP Bottle Share',
				'manage_options',
				WP_Bottle_Share\Admin\Settings\get_settings_page(),
				'WP_Bottle_Share\Admin\Settings\display_settings_page',
				)
			)
		);

		WP_Bottle_Share\Admin\Settings\add_settings_page();
	}
}
