<?php

namespace WP_Bottle_Share\Admin\User_Profile;

add_action( 'show_user_profile', __NAMESPACE__ . '\untappd_fields' );
add_action( 'edit_user_profile', __NAMESPACE__ . '\untappd_fields' );

function untappd_fields( $user ) {

	$user_id = $user->ID;

	$url = \WP_Bottle_Share\Untappd\API\get_user_url( $user_id );

	if ( ! empty( $url ) ) {
		$bio = \WP_Bottle_Share\Untappd\API\get_user_property( 'bio', $user_id );
	}

	?>

	<h2>Untappd</h2>

	<table class="form-table">
		<tr>
			<th>
				<label for="wp-bottle-share-untappd-connect"><?php esc_html_e( 'Untappd Profile', 'wp-bottle-share' ); ?></label>
			</th>
			<td>
				<?php if ( ! empty( $url ) ) : ?>

					<a href="<?php echo esc_url( $url ); ?>"><img src="<?php echo esc_url( \WP_Bottle_Share\Untappd\API\get_user_avatar( $user_id ) ) ?>" /></a>
					<br/>
					<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( \WP_Bottle_Share\Untappd\API\get_user_name( $user_id ) ); ?></a>

					<?php if ( ! empty( $bio ) ) : ?>
						<p class="description"><?php echo esc_html( $bio ); ?></p>
					<?php endif; ?>

				<?php else : ?>

					<a href="<?php echo esc_url( \WP_Bottle_Share\Untappd\OAuth\get_oauth_url() ); ?> "><?php esc_html_e( 'Connect to Untappd', 'wp-bottle-share' ); ?></a>

				<?php endif; ?>
			</td>
		</tr>
	</table>
	<?php

}
