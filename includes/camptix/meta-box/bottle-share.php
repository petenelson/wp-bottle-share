<?php

namespace WP_Bottle_Share\CampTix\Meta_Box\Bottle_Share;

add_action( 'add_meta_boxes', __NAMESPACE__ . '\add_meta_box' );
add_action( 'save_post', __NAMESPACE__ . '\save_meta_box' );
