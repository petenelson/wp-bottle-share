<?php
/**
 * Template for unhad beers shortcode.
 *
 * @package petenelson/wp-bottle-share
 */

$venue_url = filter_input( INPUT_GET, 'wpbs-unhad-venue-url', FILTER_SANITIZE_URL );
$nonce = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
$beers = array();
$venue_id = 0;

if ( is_user_logged_in() ) {
	$untappd_user = \WP_Bottle_Share\Untappd\API\get_untappd_user();
}

if ( ! empty( $venue_url ) && wp_verify_nonce( $nonce, 'get-unhad-beers' ) ) {

	if ( ! empty( $untappd_user ) ) {

		// Get the venue ID from the URL.
		$url_parts = wp_parse_url( $venue_url );

		if ( ! empty( $url_parts ) && ! empty( $url_parts['path'] ) ) {

			// Get the venue ID from the last item in the path.
			$parts = explode( '/', $url_parts['path'] );
			$venue_id = absint( end( $parts ) );

			if ( ! empty( $venue_id ) ) {
				$beers = \WP_Bottle_Share\Untappd\API\Venue\get_unhad_beers( $venue_id, get_current_user_id() );
			}
		}
	}
}

?>
<div class="wpbs-unhad-shortcode">
	<?php if ( ! is_user_logged_in() ) : ?>
		<?php wp_login_form(); ?>
	<?php else : ?>

		<?php if ( ! isset( $untappd_user ) || empty( $untappd_user ) ) : ?>
			<a href="<?php echo esc_url( \WP_Bottle_Share\Untappd\OAuth\get_oauth_url() ); ?> "><?php esc_html_e( 'Connect to Untappd', 'wp-bottle-share' ); ?></a>
		<?php else : ?>

			<form method="get">
				<?php wp_nonce_field( 'get-unhad-beers' ); ?>
				<label for="wpbs-unhad-venue-url"><?php esc_html_e( 'Untappd Venue URL', 'wp-bottle-share' ); ?></label>
				<input type="text" name="wpbs-unhad-venue-url" id="wpbs-unhad-venue-url" class="regular-text" value="<?php echo esc_url( $venue_url ); ?>" />
				<p></p>
				<button type="submit"><?php esc_html_e( 'Show Me Beers', 'wp-bottle-share' ); ?></button>
			</form>

			<?php if ( ! empty( $venue_id ) && empty( $beers ) ) : ?>
				<p>
					<?php esc_html_e( 'You\'ve had all the beers at this venue.', 'wp-bottle-share' ); ?>
				</p>
			<?php endif; ?>

			<?php if ( ! empty( $beers ) ) : ?>
				<p></p>
				<ul class="wpbs-unhad-list">
					<?php foreach ( $beers as $beer ) : ?>
						<li>
							<a href="<?php echo esc_url( $beer->url ) ?>"><?php echo esc_html( $beer->beer_name ); ?></a>
							<?php if ( ! empty( $beer->brewery ) ) : ?>
								<span class="wpbs-unhad-by-brewery">
									<?php
									// Translators: Link to brewery in list of checkins.
									echo wp_kses_post( sprintf( __( 'by <a href="%1$ss">%2$s</a>', 'wp-bottle-share' ),
										esc_url( $beer->brewery->url ),
										esc_html( $beer->brewery->brewery_name )
									) ); ?>
								</span>
							<?php endif; ?>

							<div class="wpbs-unhad-style-abv">
								<span class="wpbs-unhad-style"><?php echo esc_html( $beer->beer_style . ',' ); ?></span>
								<span class="wpbs-unhad-abv"><?php echo esc_html( $beer->beer_abv . '%' ); ?></span>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>

			<?php endif; ?>

		<?php endif; ?>
	<?php endif; ?>
</div>
