<?php 

use WP_Mock as M;

class WP_Bottle_Share_Base_Test extends PHPUnit_Framework_TestCase {

	public function setUp() {
		M::setUp();

		M::wpPassthruFunction( 'esc_html__' );

	}

	public function tearDown() {
		M::tearDown();
	}

}
