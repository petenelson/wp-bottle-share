<?php

namespace WP_Bottle_Share\Meta_Box\Bottle_Share;

add_action( 'add_meta_boxes', __NAMESPACE__ . '\add_meta_box' );
add_action( 'save_post', __NAMESPACE__ . '\save_meta_box' );

function add_meta_box() {

	\add_meta_box( $id,
		esc_html__( 'Details', 'wp-bottle-share' ),
		__NAMESPACE__ . '\display_meta_box',
		\WP_Bottle_Share\Post_Type\Bottle_Share\get_post_type()
	);

}

function display_meta_box( $post ) {

	$post_id = $post->ID;

	wp_nonce_field( 'wp-bottle-share-details', 'wp-bottle-share-details-nonce' );

	$location_name = get_post_meta( $post_id, get_key_location_name(), true );
	$location_url = get_post_meta( $post_id, get_key_location_url(), true );
	$location_address = get_post_meta( $post_id, get_key_location_address(), true );

	?>

		<table class="form-table">
			<tr>
				<th>
					<label for="wp-bottle-share-location-name"><?php esc_html_e( 'Location Name', 'wp-bottle-share' ); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="<?php echo esc_attr( get_key_location_name() ); ?>" value="<?php echo esc_attr( $location_name ); ?>" />
				</td>
			</tr>

			<tr>
				<th>
					<label for="wp-bottle-share-location-url"><?php esc_html_e( 'Location URL', 'wp-bottle-share' ); ?></label>
				</th>
				<td>
					<input type="text" class="regular-text" name="<?php echo esc_attr( get_key_location_url() ); ?>" value="<?php echo esc_attr( $location_url ); ?>" />
				</td>
			</tr>

			<tr>
				<th>
					<label for="wp-bottle-share-location-address"><?php esc_html_e( 'Location address', 'wp-bottle-share' ); ?></label>
				</th>
				<td>
					<textarea rows="4" type="text" class="regular-text" name="<?php echo esc_attr( get_key_location_address() ); ?>"><?php echo esc_html( $location_address ) ?></textarea>
				</td>
			</tr>

		</table>

	<?php

}

function save_meta_box( $post_id ) {

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		die('a');
		return;
	}

	$nonce = filter_input( INPUT_POST, 'wp-bottle-share-details-nonce', FILTER_SANITIZE_STRING );
	if ( ! wp_verify_nonce( $nonce, 'wp-bottle-share-details' ) ) {
		return;
	}

	$location_name = filter_input( INPUT_POST, get_key_location_name(), FILTER_SANITIZE_STRING );
	$location_url = filter_input( INPUT_POST, get_key_location_url(), FILTER_SANITIZE_URL );
	$location_address = filter_input( INPUT_POST, get_key_location_address(), FILTER_SANITIZE_STRING );

	update_post_meta( $post_id, get_key_location_name(), $location_name );
	update_post_meta( $post_id, get_key_location_url(), $location_url );
	update_post_meta( $post_id, get_key_location_address(), $location_address );

}

function get_key_location_name() {
	return 'wp-bottle-share-location-name';
}

function get_key_location_url() {
	return 'wp-bottle-share-location-url';
}

function get_key_location_address() {
	return 'wp-bottle-share-location-address';
}

function get_key_location_address_url() {
	return 'wp-bottle-share-location-address-url';
}

function get_key_date_time() {
	return 'wp-bottle-share-date-time';
}

function get_key_is_primary() {
	return 'wp-bottle-share-is-primary';
}
