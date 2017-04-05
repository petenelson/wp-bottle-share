<?php

namespace WP_Bottle_Share\Post_Type\Bottle_Share;

add_action( 'init', __NAMESPACE__ . '\register_bottle_share' );

function register_bottle_share() {
	register_post_type( get_post_type(), get_register_args() );
}

function get_post_type() {
	return apply_filters( 'wp-bottle-share-post-type', 'bottle-share' );
}

function get_register_args() {

	$labels = array(
		'name'                => __( 'Bottle Shares', 'wp-bottle-share' ),
		'singular_name'       => __( 'Bottle Share', 'wp-bottle-share' ),
		'add_new'             => _x( 'Add New Bottle Share', 'wp-bottle-share', 'wp-bottle-share' ),
		'add_new_item'        => __( 'Add New Bottle Share', 'wp-bottle-share' ),
		'edit_item'           => __( 'Edit Bottle Share', 'wp-bottle-share' ),
		'new_item'            => __( 'New Bottle Share', 'wp-bottle-share' ),
		'view_item'           => __( 'View Bottle Share', 'wp-bottle-share' ),
		'search_items'        => __( 'Search Bottle Shares', 'wp-bottle-share' ),
		'not_found'           => __( 'No Bottle Shares found', 'wp-bottle-share' ),
		'not_found_in_trash'  => __( 'No Bottle Shares found in Trash', 'wp-bottle-share' ),
		'parent_item_colon'   => __( 'Parent Bottle Share:', 'wp-bottle-share' ),
		'menu_name'           => __( 'Bottle Shares', 'wp-bottle-share' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'description',
		'taxonomies'          => array(),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => null,
		'menu_icon'           => null,
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'supports'            => array(
			'title', 'editor', 'thumbnail',
			'excerpt', 'revisions',
			),
	);
	
	return apply_filters( 'wp-bottle-share-register-bottle-share-args', $args );
}
