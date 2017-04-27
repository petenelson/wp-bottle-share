<?php

namespace WP_Bottle_Share\Admin\Settings;

add_action( 'admin_menu', __NAMESPACE__ . '\add_settings_page' );

/**
 * Registers the Bottle Share admin menu,
 *
 * @return void
 */
function add_settings_page() {
	add_options_page(
		esc_html__( 'WP Bottle Share Settings', 'wp-bottle-share' ),
		esc_html__( 'WP Bottle Share', 'wp-bottle-share' ),
		'manage_options',
		get_settings_page(),
		__NAMESPACE__ . '\display_settings_page'
	);
}

/**
 * Gets the settings page slug for the plugin.
 *
 * @return string
 */
function get_settings_page() {
	return 'wp-bottle-share';
}

/**
 * Displays the settings page for the plugin.
 *
 * @return void
 */
function display_settings_page() {

	$page = get_settings_page();

	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'WP Bottle Share', 'wp-bottle-share' ); ?></h1>
		<form method="post" action="options.php" class="options-form">
			<?php settings_fields( $page ); ?>
			<?php do_settings_sections( $page ); ?>
			<?php submit_button( __( 'Save Changes' ), 'primary', 'submit', true ); ?>
		</form>
	</div>

	<?php

	$settings_updated = filter_input( INPUT_GET, 'settings-updated', FILTER_SANITIZE_STRING );
	if ( ! empty( $settings_updated ) ) {
		do_action( 'wp-bottle-share-settings-updated' );
	}
}

/**
 * Displays an input field.
 *
 * @param  array $args
 * @return void
 */
function input_field( $args ) {

	$args = wp_parse_args( $args,
		array(
			'name' => '',
			'maxlength' => 50,
			'after' => '',
			'type' => 'text',
			'min' => 0,
			'max' => 0,
			'step' => 1,
			'class' => 'regular-text',
		)
	);

	$name      = $args['name'];
	$maxlength = $args['maxlength'];
	$after     = $args['after'];
	$type      = $args['type'];
	$min       = $args['min'];
	$max       = $args['max'];
	$step      = $args['step'];

	$value     = get_option( $name );

	$min_max_step = '';
	if ( $type === 'number' ) {
		$min = intval( $args['min'] );
		$max = intval( $args['max'] );
		$step = intval( $args['step'] );
		$min_max_step = " step='{$step}' min='{$min}' max='{$max}' ";
	}

	?>

	<input
		id="<?php echo esc_attr( $name ); ?>"
		name="<?php echo esc_attr( $name ); ?>"
		type="<?php echo esc_attr( $type ); ?>"
		value="<?php echo esc_attr( $value ); ?>"
		maxlength="<?php echo esc_attr( $maxlength ); ?>"
		class="<?php echo sanitize_html_class( $args['class'] ); ?>"
		<?php echo $min_max_step ?>
	/>

	<?php

	output_after( $after );
}

/**
 * Outputs text for content after a settings field.
 *
 * @param  string $after Text to display.
 * @return void
 */
function output_after( $after ) {
	if ( ! empty( $after ) ) {
		echo wp_kses_post( $after );
	}
}
