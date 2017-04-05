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

	?>

	Hello world

	<?php

}

function save_meta_box( $post_id ) {

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$nonce = filter_input( INPUT_GET, 'wp-bottle-share-details-nonce', FILTER_SANITIZE_STRING );
	if ( ! wp_verify_nonce( $nonce, 'wp-bottle-share-details' ) ) {
		return;
	}

	// TODO save details.

}
