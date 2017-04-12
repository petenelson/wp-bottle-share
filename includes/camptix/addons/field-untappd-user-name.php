<?php

namespace WP_Bottle_Share\CampTix\Addons;

class Field_Untappd_User_Name extends \CampTix_Addon {

	/**
	 * Register hook callbacks
	 */
	public function camptix_init() {
		add_filter( 'camptix_question_field_types',   array( $this, 'question_field_types' ) );
		add_action( 'camptix_question_field_untappd_user_name', array( $this, 'question_field' ), 10, 3 );
	}

	public function question_field_types( $types ) {
		return array_merge( $types, array(
			'untappd_user_name' => esc_html__( 'Untappd User Name', 'wp-bottle-share' ),
		) );
	}

	/**
	 * Render the Untappd user name field on the front-end.
	 */
	function question_field( $name, $user_value, $question ) {

		?>
			<input type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $user_value) ?>" />
			<p class="description">
				<?php echo wp_kses_post( 'Don\'t have an Untappd account? <a href="https://untappd.com" target="_blank">Sign up</a>!', 'wp-bottle-share' );  ?>
			</p>
		<?php
	}
}

camptix_register_addon( 'WP_Bottle_Share\CampTix\Addons\Field_Untappd_User_Name' );
