<?php
/**
 * Booking integrations: Stripe Checkout (take payment for paid sessions) and Google Calendar
 * (create the event with a Google Meet link, invite the client, and hide times you are busy).
 *
 * Settings live in Settings > Payments & calendar and are stored in the database, never in the repo.
 * Each secret can also be set as a constant in wp-config.php, which wins over the database value:
 *   BY_STRIPE_SECRET_KEY, BY_STRIPE_WEBHOOK_SECRET, BY_GOOGLE_CLIENT_ID, BY_GOOGLE_CLIENT_SECRET
 *
 * Everything here is off until it is configured: no Stripe key = no payment step, no Google
 * connection = bookings work exactly as before (email + .ics).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- Settings ---------- */
function by_int_opt( $key ) {
	$const = array( 'stripe_secret' => 'BY_STRIPE_SECRET_KEY', 'stripe_whsec' => 'BY_STRIPE_WEBHOOK_SECRET', 'google_client_id' => 'BY_GOOGLE_CLIENT_ID', 'google_client_secret' => 'BY_GOOGLE_CLIENT_SECRET' );
	if ( isset( $const[ $key ] ) && defined( $const[ $key ] ) && constant( $const[ $key ] ) ) return constant( $const[ $key ] );
	$o = get_option( 'by_integrations', array() );
	return isset( $o[ $key ] ) ? $o[ $key ] : '';
}
function by_int_set( $key, $val ) {
	$o = get_option( 'by_integrations', array() );
	$o[ $key ] = $val;
	update_option( 'by_integrations', $o, false );
}
function by_stripe_on() { return (bool) by_int_opt( 'stripe_secret' ) && by_int_opt( 'stripe_enabled' ); }
function by_gcal_on()   { return (bool) by_int_opt( 'google_refresh' ) && by_int_opt( 'google_client_id' ) && by_int_opt( 'google_client_secret' ); }
function by_gcal_redirect_uri() { return rest_url( 'betteryet/v1/google-callback' ); }
function by_stripe_webhook_url() { return rest_url( 'betteryet/v1/stripe-webhook' ); }

/** Whole dollars in a price string ("$990", "$1,250 + GST") -> cents. 0 when there is no number. */
function by_price_cents( $str ) {
	if ( ! preg_match( '/\$?\s*([0-9][0-9,]*(?:\.[0-9]{1,2})?)/', (string) $str, $m ) ) return 0;
	return (int) round( (float) str_replace( ',', '', $m[1] ) * 100 );
}
/** Amount to charge for a call type, in cents (0 = free / not charged online). */
function by_call_amount( $type ) {
	if ( ! by_stripe_on() ) return 0;
	if ( 'audit' === $type ) {
		$override = trim( (string) by_int_opt( 'audit_amount' ) );
		return by_price_cents( $override !== '' ? $override : by_opt( 'audit_price' ) );
	}
	return 0;
}

add_action( 'admin_menu', function () {
	add_options_page( 'Payments & calendar', 'Payments & calendar', 'manage_options', 'by-integrations', 'by_integrations_page' );
} );

add_action( 'admin_post_by_integrations_save', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
	check_admin_referer( 'by_integrations_save' );
	$text = array( 'stripe_secret', 'stripe_whsec', 'audit_amount', 'google_client_id', 'google_client_secret', 'google_calendar' );
	foreach ( $text as $k ) {
		if ( ! isset( $_POST[ $k ] ) ) continue;
		$v = trim( sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) );
		// Secret fields are shown masked; an unchanged mask means "keep what is saved"
		if ( in_array( $k, array( 'stripe_secret', 'stripe_whsec', 'google_client_secret' ), true ) && $v !== '' && strpos( $v, '••••' ) !== false ) continue;
		by_int_set( $k, $v );
	}
	by_int_set( 'stripe_enabled', empty( $_POST['stripe_enabled'] ) ? '' : '1' );
	by_int_set( 'google_busy', empty( $_POST['google_busy'] ) ? '' : '1' );
	delete_transient( 'by_gcal_busy' );
	wp_safe_redirect( admin_url( 'options-general.php?page=by-integrations&saved=1' ) );
	exit;
} );

add_action( 'admin_post_by_gcal_disconnect', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
	check_admin_referer( 'by_gcal_disconnect' );
	by_int_set( 'google_refresh', '' );
	by_int_set( 'google_account', '' );
	delete_transient( 'by_gcal_token' );
	delete_transient( 'by_gcal_busy' );
	wp_safe_redirect( admin_url( 'options-general.php?page=by-integrations&gcal=off' ) );
	exit;
} );

add_action( 'admin_post_by_gcal_connect', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
	check_admin_referer( 'by_gcal_connect' );
	$state = wp_generate_password( 24, false );
	set_transient( 'by_gcal_state_' . $state, get_current_user_id(), 15 * MINUTE_IN_SECONDS );
	$url = add_query_arg( array(
		'client_id'     => by_int_opt( 'google_client_id' ),
		'redirect_uri'  => by_gcal_redirect_uri(),
		'response_type' => 'code',
		'scope'         => 'https://www.googleapis.com/auth/calendar.events https://www.googleapis.com/auth/calendar.freebusy https://www.googleapis.com/auth/calendar.calendarlist.readonly openid email',
		'access_type'   => 'offline',
		'prompt'        => 'consent',
		'state'         => $state,
	), 'https://accounts.google.com/o/oauth2/v2/auth' );
	wp_redirect( $url ); // external: Google's sign-in page
	exit;
} );

function by_mask( $v ) { return $v ? substr( $v, 0, 7 ) . '••••' . substr( $v, -4 ) : ''; }

function by_integrations_page() {
	if ( ! current_user_can( 'manage_options' ) ) return;
	$o = function ( $k ) { return by_int_opt( $k ); };
	$fromConst = function ( $c ) { return defined( $c ) && constant( $c ); };
	$audit_cents = by_price_cents( trim( (string) $o( 'audit_amount' ) ) !== '' ? $o( 'audit_amount' ) : by_opt( 'audit_price' ) );
	$test = strpos( (string) $o( 'stripe_secret' ), '_test_' ) !== false;
	?>
	<div class="wrap">
		<h1>Payments &amp; calendar</h1>
		<?php if ( isset( $_GET['saved'] ) ) : ?><div class="notice notice-success"><p>Saved.</p></div><?php endif; ?>
		<?php if ( isset( $_GET['gcal'] ) && 'ok' === $_GET['gcal'] ) : ?><div class="notice notice-success"><p>Google Calendar connected.</p></div><?php endif; ?>
		<?php if ( isset( $_GET['gcal'] ) && 'err' === $_GET['gcal'] ) : ?><div class="notice notice-error"><p>Google did not connect: <?php echo esc_html( isset( $_GET['why'] ) ? sanitize_text_field( wp_unslash( $_GET['why'] ) ) : 'unknown error' ); ?></p></div><?php endif; ?>
		<p>These settings power the booking page at <a href="<?php echo esc_url( by_book_url() ); ?>"><?php echo esc_html( by_book_url() ); ?></a>. Free discovery calls never ask for payment.</p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="by_integrations_save">
			<?php wp_nonce_field( 'by_integrations_save' ); ?>

			<h2>1. Stripe (payments)</h2>
			<p>In Stripe: Developers &rarr; API keys &rarr; copy the <strong>Secret key</strong>. Then Developers &rarr; Webhooks &rarr; Add endpoint with the URL below and the event <code>checkout.session.completed</code>, and copy its <strong>Signing secret</strong>. Use test keys (sk_test_…) first.</p>
			<table class="form-table">
				<tr><th>Take payment for paid sessions</th><td><label><input type="checkbox" name="stripe_enabled" value="1" <?php checked( $o( 'stripe_enabled' ) ); ?>> On</label>
					<?php if ( $test && $o( 'stripe_enabled' ) ) : ?><p class="description" style="color:#b32d2e"><strong>Test mode:</strong> no real money is taken. Swap in the live key (sk_live_…) to go live.</p><?php endif; ?></td></tr>
				<tr><th><label for="stripe_secret">Secret key</label></th><td>
					<?php if ( $fromConst( 'BY_STRIPE_SECRET_KEY' ) ) : ?>Set in wp-config.php<?php else : ?>
					<input class="regular-text" id="stripe_secret" name="stripe_secret" value="<?php echo esc_attr( by_mask( $o( 'stripe_secret' ) ) ); ?>" autocomplete="off" placeholder="sk_live_… or sk_test_…"><?php endif; ?></td></tr>
				<tr><th>Webhook URL</th><td><code><?php echo esc_html( by_stripe_webhook_url() ); ?></code></td></tr>
				<tr><th><label for="stripe_whsec">Webhook signing secret</label></th><td>
					<?php if ( $fromConst( 'BY_STRIPE_WEBHOOK_SECRET' ) ) : ?>Set in wp-config.php<?php else : ?>
					<input class="regular-text" id="stripe_whsec" name="stripe_whsec" value="<?php echo esc_attr( by_mask( $o( 'stripe_whsec' ) ) ); ?>" autocomplete="off" placeholder="whsec_…"><?php endif; ?>
					<p class="description">Optional but recommended: confirms a booking even if the client closes the tab straight after paying.</p></td></tr>
				<tr><th><label for="audit_amount">Audit session charge</label></th><td>
					<input class="small-text" id="audit_amount" name="audit_amount" value="<?php echo esc_attr( $o( 'audit_amount' ) ); ?>" placeholder="<?php echo esc_attr( by_opt( 'audit_price' ) ); ?>">
					<p class="description">Blank uses the audit price from Customize (now <?php echo esc_html( by_opt( 'audit_price' ) ); ?>, charged as AUD <?php echo esc_html( number_format( $audit_cents / 100, 2 ) ); ?>). Enter a smaller number to take a deposit instead.</p></td></tr>
			</table>

			<h2>2. Google Calendar (events and Meet links)</h2>
			<p>In Google Cloud Console: create a project, enable the <strong>Google Calendar API</strong>, set up the OAuth consent screen (choose <strong>Internal</strong> on Google Workspace; on a personal Google account choose External and <strong>Publish app</strong>, or the connection expires after 7 days), and create an <strong>OAuth client ID</strong> of type Web application with this redirect URI:<br><code><?php echo esc_html( by_gcal_redirect_uri() ); ?></code></p>
			<table class="form-table">
				<tr><th><label for="google_client_id">Client ID</label></th><td>
					<?php if ( $fromConst( 'BY_GOOGLE_CLIENT_ID' ) ) : ?>Set in wp-config.php<?php else : ?>
					<input class="large-text" id="google_client_id" name="google_client_id" value="<?php echo esc_attr( $o( 'google_client_id' ) ); ?>" autocomplete="off"><?php endif; ?></td></tr>
				<tr><th><label for="google_client_secret">Client secret</label></th><td>
					<?php if ( $fromConst( 'BY_GOOGLE_CLIENT_SECRET' ) ) : ?>Set in wp-config.php<?php else : ?>
					<input class="regular-text" id="google_client_secret" name="google_client_secret" value="<?php echo esc_attr( by_mask( $o( 'google_client_secret' ) ) ); ?>" autocomplete="off"><?php endif; ?></td></tr>
				<tr><th><label for="google_calendar">Calendar</label></th><td>
					<input class="regular-text" id="google_calendar" name="google_calendar" value="<?php echo esc_attr( $o( 'google_calendar' ) ); ?>" placeholder="primary">
					<p class="description">Blank = the main calendar of the connected account. For a shared calendar, paste its Calendar ID (Google Calendar &rarr; Settings &rarr; the calendar &rarr; Integrate calendar).</p></td></tr>
				<tr><th>Hide times I'm busy</th><td><label><input type="checkbox" name="google_busy" value="1" <?php checked( $o( 'google_busy' ) ); ?>> Don't offer slots that clash with events already in this calendar</label></td></tr>
			</table>
			<?php submit_button( 'Save settings' ); ?>
		</form>

		<h3>Connection</h3>
		<?php if ( by_gcal_on() ) : ?>
			<p>Connected<?php echo $o( 'google_account' ) ? ' as <strong>' . esc_html( $o( 'google_account' ) ) . '</strong>' : ''; ?>. New bookings create an event with a Google Meet link and invite the client.</p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"><input type="hidden" name="action" value="by_gcal_disconnect"><?php wp_nonce_field( 'by_gcal_disconnect' ); ?><?php submit_button( 'Disconnect Google', 'secondary', 'submit', false ); ?></form>
		<?php elseif ( $o( 'google_client_id' ) && $o( 'google_client_secret' ) ) : ?>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"><input type="hidden" name="action" value="by_gcal_connect"><?php wp_nonce_field( 'by_gcal_connect' ); ?><?php submit_button( 'Connect Google Calendar', 'primary', 'submit', false ); ?></form>
		<?php else : ?>
			<p>Save the Client ID and secret first, then a <em>Connect Google Calendar</em> button appears here.</p>
		<?php endif; ?>
	</div>
	<?php
}

/* ---------- REST endpoints: Google OAuth callback + Stripe webhook ---------- */
add_action( 'rest_api_init', function () {
	register_rest_route( 'betteryet/v1', '/google-callback', array( 'methods' => 'GET', 'callback' => 'by_gcal_callback', 'permission_callback' => '__return_true' ) );
	register_rest_route( 'betteryet/v1', '/stripe-webhook', array( 'methods' => 'POST', 'callback' => 'by_stripe_webhook', 'permission_callback' => '__return_true' ) );
} );

function by_gcal_callback( WP_REST_Request $req ) {
	$back = function ( $ok, $why = '' ) {
		wp_safe_redirect( admin_url( 'options-general.php?page=by-integrations&gcal=' . ( $ok ? 'ok' : 'err' ) . ( $why ? '&why=' . rawurlencode( $why ) : '' ) ) );
		exit;
	};
	$state = sanitize_text_field( (string) $req->get_param( 'state' ) );
	if ( ! $state || ! get_transient( 'by_gcal_state_' . $state ) ) $back( false, 'the sign-in link expired, please try again' );
	delete_transient( 'by_gcal_state_' . $state );
	if ( $req->get_param( 'error' ) ) $back( false, sanitize_text_field( (string) $req->get_param( 'error' ) ) );
	$res = wp_remote_post( 'https://oauth2.googleapis.com/token', array( 'timeout' => 15, 'body' => array(
		'code' => (string) $req->get_param( 'code' ), 'client_id' => by_int_opt( 'google_client_id' ), 'client_secret' => by_int_opt( 'google_client_secret' ),
		'redirect_uri' => by_gcal_redirect_uri(), 'grant_type' => 'authorization_code',
	) ) );
	$j = is_wp_error( $res ) ? array() : json_decode( wp_remote_retrieve_body( $res ), true );
	if ( empty( $j['refresh_token'] ) ) $back( false, isset( $j['error_description'] ) ? $j['error_description'] : 'no refresh token returned' );
	by_int_set( 'google_refresh', $j['refresh_token'] );
	if ( ! empty( $j['access_token'] ) ) set_transient( 'by_gcal_token', $j['access_token'], max( 60, (int) ( isset( $j['expires_in'] ) ? $j['expires_in'] : 3600 ) - 120 ) );
	if ( ! empty( $j['id_token'] ) ) {
		$parts = explode( '.', $j['id_token'] );
		$claims = isset( $parts[1] ) ? json_decode( base64_decode( strtr( $parts[1], '-_', '+/' ) ), true ) : array();
		if ( ! empty( $claims['email'] ) ) by_int_set( 'google_account', sanitize_email( $claims['email'] ) );
	}
	delete_transient( 'by_gcal_busy' );
	$back( true );
}

/* ---------- Google Calendar API ---------- */
function by_gcal_token() {
	$t = get_transient( 'by_gcal_token' );
	if ( $t ) return $t;
	if ( ! by_gcal_on() ) return '';
	$res = wp_remote_post( 'https://oauth2.googleapis.com/token', array( 'timeout' => 15, 'body' => array(
		'client_id' => by_int_opt( 'google_client_id' ), 'client_secret' => by_int_opt( 'google_client_secret' ),
		'refresh_token' => by_int_opt( 'google_refresh' ), 'grant_type' => 'refresh_token',
	) ) );
	$j = is_wp_error( $res ) ? array() : json_decode( wp_remote_retrieve_body( $res ), true );
	if ( empty( $j['access_token'] ) ) {
		if ( isset( $j['error'] ) && 'invalid_grant' === $j['error'] ) by_int_set( 'google_refresh', '' ); // revoked or expired: show "Connect" again
		error_log( 'Better Yet: Google token refresh failed: ' . wp_remote_retrieve_body( $res ) );
		return '';
	}
	set_transient( 'by_gcal_token', $j['access_token'], max( 60, (int) $j['expires_in'] - 120 ) );
	return $j['access_token'];
}
function by_gcal_calendar() { $c = trim( (string) by_int_opt( 'google_calendar' ) ); return $c !== '' ? $c : 'primary'; }

function by_gcal_request( $method, $path, $body = null ) {
	$token = by_gcal_token();
	if ( ! $token ) return null;
	$args = array( 'method' => $method, 'timeout' => 15, 'headers' => array( 'Authorization' => 'Bearer ' . $token, 'Content-Type' => 'application/json' ) );
	if ( null !== $body ) $args['body'] = wp_json_encode( $body );
	$res = wp_remote_request( 'https://www.googleapis.com/calendar/v3' . $path, $args );
	if ( is_wp_error( $res ) ) { error_log( 'Better Yet: Google Calendar error: ' . $res->get_error_message() ); return null; }
	$code = wp_remote_retrieve_response_code( $res );
	$j = json_decode( wp_remote_retrieve_body( $res ), true );
	if ( $code >= 300 ) { error_log( 'Better Yet: Google Calendar ' . $code . ': ' . wp_remote_retrieve_body( $res ) ); return null; }
	return $j;
}

/** Busy blocks from the Google calendar for the booking horizon, as [ ['utc'=>ts,'mins'=>n], ... ]. Cached 5 minutes. */
function by_gcal_busy() {
	if ( ! by_gcal_on() || ! by_int_opt( 'google_busy' ) ) return array();
	$cached = get_transient( 'by_gcal_busy' );
	if ( is_array( $cached ) ) return $cached;
	$horizon = min( 60, max( 1, (int) by_opt( 'booking_horizon' ) ?: 21 ) ) + 1;
	$j = by_gcal_request( 'POST', '/freeBusy', array( 'timeMin' => gmdate( 'c' ), 'timeMax' => gmdate( 'c', time() + $horizon * DAY_IN_SECONDS ), 'items' => array( array( 'id' => by_gcal_calendar() ) ) ) );
	$out = array();
	if ( $j && ! empty( $j['calendars'] ) ) {
		foreach ( $j['calendars'] as $cal ) {
			if ( empty( $cal['busy'] ) ) continue;
			foreach ( $cal['busy'] as $b ) {
				$s = strtotime( $b['start'] ); $e = strtotime( $b['end'] );
				if ( $s && $e > $s ) $out[] = array( 'utc' => $s, 'mins' => (int) ceil( ( $e - $s ) / 60 ) );
			}
		}
	}
	set_transient( 'by_gcal_busy', $out, $j ? 5 * MINUTE_IN_SECONDS : MINUTE_IN_SECONDS );
	return $out;
}

/** Create the calendar event with a Meet link for a booking. Returns [ 'id' => ..., 'meet' => ..., 'link' => ... ] or null. */
function by_gcal_create_event( $post_id ) {
	if ( ! by_gcal_on() ) return null;
	$d     = (array) get_post_meta( $post_id, '_by_data', true );
	$start = strtotime( get_post_meta( $post_id, '_by_when', true ) . ' UTC' );
	$mins  = (int) get_post_meta( $post_id, '_by_mins', true ) ?: 30;
	$brand = by_opt( 'brand' );
	$type  = get_post_meta( $post_id, '_by_type_label', true );
	$paid  = get_post_meta( $post_id, '_by_paid', true );
	$desc  = "Booked on the website.\n\nName: " . ( isset( $d['name'] ) ? $d['name'] : '' ) . "\nBusiness: " . ( isset( $d['business'] ) ? $d['business'] : '' ) . "\nTeam size: " . ( isset( $d['team_size'] ) ? $d['team_size'] : '' )
	       . "\nEmail: " . ( isset( $d['email'] ) ? $d['email'] : '' ) . "\nPhone: " . ( isset( $d['phone'] ) ? $d['phone'] : '' )
	       . ( $paid ? "\nPaid: " . $paid : '' ) . "\n\nWhat's slowing them down:\n" . ( isset( $d['notes'] ) ? $d['notes'] : '' );
	$event = array(
		'summary'     => $type . ': ' . ( isset( $d['name'] ) ? $d['name'] : '' ) . ( ! empty( $d['business'] ) ? ' (' . $d['business'] . ')' : '' ) . ' with ' . $brand,
		'description' => $desc,
		'start'       => array( 'dateTime' => gmdate( 'c', $start ), 'timeZone' => by_booking_tz()->getName() ),
		'end'         => array( 'dateTime' => gmdate( 'c', $start + $mins * 60 ), 'timeZone' => by_booking_tz()->getName() ),
		'attendees'   => ! empty( $d['email'] ) ? array( array( 'email' => $d['email'], 'displayName' => isset( $d['name'] ) ? $d['name'] : '' ) ) : array(),
		'conferenceData' => array( 'createRequest' => array( 'requestId' => 'by-' . $post_id . '-' . wp_generate_password( 8, false ), 'conferenceSolutionKey' => array( 'type' => 'hangoutsMeet' ) ) ),
		'reminders'   => array( 'useDefault' => true ),
	);
	$j = by_gcal_request( 'POST', '/calendars/' . rawurlencode( by_gcal_calendar() ) . '/events?conferenceDataVersion=1&sendUpdates=all', $event );
	if ( ! $j || empty( $j['id'] ) ) return null;
	$meet = isset( $j['hangoutLink'] ) ? $j['hangoutLink'] : '';
	if ( ! $meet && ! empty( $j['conferenceData']['entryPoints'] ) ) {
		foreach ( $j['conferenceData']['entryPoints'] as $ep ) { if ( 'video' === $ep['entryPointType'] ) { $meet = $ep['uri']; break; } }
	}
	delete_transient( 'by_gcal_busy' );
	return array( 'id' => $j['id'], 'meet' => $meet, 'link' => isset( $j['htmlLink'] ) ? $j['htmlLink'] : '' );
}

/* ---------- Stripe ---------- */
function by_stripe_request( $method, $path, $body = array() ) {
	$args = array( 'method' => $method, 'timeout' => 20, 'headers' => array( 'Authorization' => 'Bearer ' . by_int_opt( 'stripe_secret' ) ) );
	if ( $body ) $args['body'] = $body;
	$res = wp_remote_request( 'https://api.stripe.com/v1' . $path, $args );
	if ( is_wp_error( $res ) ) { error_log( 'Better Yet: Stripe error: ' . $res->get_error_message() ); return null; }
	$j = json_decode( wp_remote_retrieve_body( $res ), true );
	if ( wp_remote_retrieve_response_code( $res ) >= 300 ) { error_log( 'Better Yet: Stripe ' . wp_remote_retrieve_response_code( $res ) . ': ' . wp_remote_retrieve_body( $res ) ); return null; }
	return $j;
}

/** Start a Stripe Checkout session for a pending booking. Returns the checkout URL or ''. */
function by_stripe_checkout( $post_id, $amount, $name, $email, $label ) {
	$book = by_book_url();
	$j = by_stripe_request( 'POST', '/checkout/sessions', array(
		'mode'                       => 'payment',
		'customer_email'             => $email,
		'client_reference_id'        => (string) $post_id,
		'line_items[0][quantity]'    => 1,
		'line_items[0][price_data][currency]'                 => 'aud',
		'line_items[0][price_data][unit_amount]'              => $amount,
		'line_items[0][price_data][product_data][name]'       => $name,
		'line_items[0][price_data][product_data][description]' => $label,
		'metadata[booking_id]'       => (string) $post_id,
		'payment_intent_data[description]' => $name . ', ' . $label,
		'payment_intent_data[metadata][booking_id]' => (string) $post_id,
		'expires_at'                 => time() + 31 * MINUTE_IN_SECONDS,
		'success_url'                => add_query_arg( 'paid', '{CHECKOUT_SESSION_ID}', $book ),
		'cancel_url'                 => add_query_arg( array( 'cancelled' => $post_id, 'k' => get_post_meta( $post_id, '_by_key', true ) ), $book ),
	) );
	if ( ! $j || empty( $j['url'] ) ) return '';
	update_post_meta( $post_id, '_by_stripe_session', $j['id'] );
	return $j['url'];
}

/** Check a Checkout session with Stripe and confirm its booking if paid. Returns the booking id or 0. */
function by_stripe_settle_session( $session_id ) {
	if ( ! preg_match( '/^cs_[A-Za-z0-9_]+$/', $session_id ) || ! by_int_opt( 'stripe_secret' ) ) return 0;
	$s = by_stripe_request( 'GET', '/checkout/sessions/' . $session_id );
	return $s ? by_stripe_apply_session( $s ) : 0;
}
function by_stripe_apply_session( $s ) {
	$id = isset( $s['metadata']['booking_id'] ) ? (int) $s['metadata']['booking_id'] : 0;
	if ( ! $id || 'by_booking' !== get_post_type( $id ) ) return 0;
	if ( get_post_meta( $id, '_by_stripe_session', true ) !== $s['id'] ) return 0;
	if ( ! isset( $s['payment_status'] ) || 'paid' !== $s['payment_status'] ) return 0;
	if ( ! get_post_meta( $id, '_by_paid', true ) ) {
		update_post_meta( $id, '_by_paid', 'AUD ' . number_format( ( isset( $s['amount_total'] ) ? (int) $s['amount_total'] : 0 ) / 100, 2 ) . ' via Stripe' );
		update_post_meta( $id, '_by_payment_intent', isset( $s['payment_intent'] ) ? $s['payment_intent'] : '' );
	}
	by_booking_confirm( $id );
	return $id;
}

function by_stripe_webhook( WP_REST_Request $req ) {
	$secret  = by_int_opt( 'stripe_whsec' );
	$payload = $req->get_body();
	$sig     = (string) $req->get_header( 'stripe_signature' );
	if ( ! $secret || ! $sig ) return new WP_REST_Response( array( 'ok' => false ), 400 );
	$t = ''; $v1 = array();
	foreach ( explode( ',', $sig ) as $part ) {
		$kv = explode( '=', trim( $part ), 2 );
		if ( count( $kv ) !== 2 ) continue;
		if ( 't' === $kv[0] ) $t = $kv[1];
		if ( 'v1' === $kv[0] ) $v1[] = $kv[1];
	}
	$expected = hash_hmac( 'sha256', $t . '.' . $payload, $secret );
	$valid = false;
	foreach ( $v1 as $s ) { if ( hash_equals( $expected, $s ) ) $valid = true; }
	if ( ! $valid || abs( time() - (int) $t ) > 600 ) return new WP_REST_Response( array( 'ok' => false, 'error' => 'bad signature' ), 400 );
	$event = json_decode( $payload, true );
	if ( isset( $event['type'] ) && in_array( $event['type'], array( 'checkout.session.completed', 'checkout.session.async_payment_succeeded' ), true ) ) {
		by_stripe_apply_session( $event['data']['object'] );
	}
	return new WP_REST_Response( array( 'ok' => true ), 200 );
}
