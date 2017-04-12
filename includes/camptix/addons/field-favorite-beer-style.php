<?php

namespace WP_Bottle_Share\CampTix\Addons;

class Field_Favorite_Beer_Style extends \CampTix_Addon {

	/**
	 * Register hook callbacks
	 */
	public function camptix_init() {
		add_filter( 'camptix_question_field_types',   array( $this, 'question_field_types' ) );
		add_action( 'camptix_question_field_favorite_beer_style', array( $this, 'question_field' ), 10, 3 );
	}

	public function question_field_types( $types ) {
		return array_merge( $types, array(
			'favorite_beer_style' => esc_html__( 'Favorite Beer Style', 'wp-bottle-share' ),
		) );
	}

	/**
	 * Render the Untappd user name field on the front-end.
	 */
	function question_field( $name, $user_value, $question ) {

		$beer_styles = \WP_Bottle_Share\Untappd\API\Beer\get_styles();

		?>
			<select name="<?php echo esc_attr( $name ); ?>">
				<option value=""><?php esc_html_e( 'Undecided', 'wb-bottle-share' ); ?></option>
				<?php foreach( $beer_styles as $beer_style) : ?>
					<option value="<?php echo esc_attr( $beer_style->beer_style_id ); ?>" <?php selected( $beer_style->beer_style_id, absint( $user_value ) ); ?>>
						<?php echo esc_html( $beer_style->beer_style ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		<?php
	}
}

camptix_register_addon( 'WP_Bottle_Share\CampTix\Addons\Field_Favorite_Beer_Style' );
