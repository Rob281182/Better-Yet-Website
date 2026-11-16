<?php
/**
 * Booking: a /book/ page with on-site time-slot booking (no plugin needed).
 * Bookings are saved under "Bookings" in the dashboard, emailed to the team, confirmed to the
 * visitor with a calendar (.ics) file, and optionally POSTed to the CRM webhook.
 * Paid sessions go through Stripe Checkout first, and confirmed bookings land in Google Calendar with a Meet link
 * when those are set up (see inc/integrations.php, Settings > Payments & calendar).
 * If a Calendly/Cal.com style link is set and "Embed booking link" is ticked, the page embeds that instead.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ---------- Availability settings (Appearance > Customize > Better Yet settings) ---------- */
function by_booking_defaults() {
	return array(
		'booking_tz'      => 'Australia/Brisbane',
		'booking_days'    => 'Mon,Tue,Wed,Thu,Fri',
		'booking_start'   => '09:00',
		'booking_end'     => '16:00',
		'booking_slot'    => '30',   // minutes between start times
		'booking_notice'  => '24',   // hours of notice needed
		'booking_horizon' => '21',   // days ahead that can be booked
		'booking_embed'   => '',     // "1" = embed booking_url on the page instead of our own form
		'booking_how'     => 'We call you on the number you give us, or send a video link if you prefer.',
	);
}
add_filter( 'by_defaults', function ( $d ) { return array_merge( $d, by_booking_defaults() ); } );

add_action( 'customize_register', function ( $wp ) {
	$fields = array(
		'booking_tz'      => array( 'Booking timezone', 'text', 'PHP timezone name, e.g. Australia/Brisbane, Australia/Sydney, Australia/Melbourne.' ),
		'booking_days'    => array( 'Booking days', 'text', 'Comma separated: Mon,Tue,Wed,Thu,Fri' ),
		'booking_start'   => array( 'First call can start at', 'text', '24h time, e.g. 09:00' ),
		'booking_end'     => array( 'Last call must end by', 'text', '24h time, e.g. 16:00' ),
		'booking_slot'    => array( 'Slot spacing (minutes)', 'text', 'Start times every N minutes, e.g. 30' ),
		'booking_notice'  => array( 'Minimum notice (hours)', 'text', 'e.g. 24' ),
		'booking_horizon' => array( 'How far ahead (days)', 'text', 'e.g. 21' ),
		'booking_how'     => array( 'How the call happens', 'text', 'Shown on the booking page and in the confirmation email.' ),
		'booking_embed'   => array( 'Embed the booking link instead', 'checkbox', 'Tick to show your Calendly / Cal.com / Google appointment page on /book/ instead of the built-in time picker. Needs the Booking link above.' ),
	);
	$d = by_booking_defaults();
	foreach ( $fields as $key => $f ) {
		$wp->add_setting( 'by_' . $key, array( 'default' => $d[ $key ], 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp->add_control( 'by_' . $key, array( 'label' => $f[0], 'description' => $f[2], 'section' => 'by_settings', 'type' => $f[1] ) );
	}
}, 20 );

/* ---------- Call types ---------- */
function by_call_types() {
	$types = array(
		'discovery' => array( 'name' => 'Discovery call', 'mins' => 20, 'price' => 'Free', 'blurb' => 'Tell us where the hours go. We tell you, honestly, whether we can help and what we would look at first.' ),
	);
	$paid = function_exists( 'by_call_amount' ) && by_call_amount( 'audit' ) > 0;
	$types['audit'] = array( 'name' => by_opt( 'audit_name' ) . ' session', 'mins' => 75, 'price' => by_price( 'audit_price', 'Price confirmed before the call' ), 'paid' => $paid,
		'blurb' => $paid
			? 'Already decided? Book the 60 to 90 minute working session that starts the audit, and pay the fee securely by card to lock in your time.'
			: 'Already decided? Book the 60 to 90 minute working session that starts the audit. We confirm the fee and send an invoice before the call.' );
	return $types;
}

/* ---------- Bookings post type ---------- */
add_action( 'init', function () {
	register_post_type( 'by_booking', array(
		'labels'          => array( 'name' => 'Bookings', 'singular_name' => 'Booking', 'all_items' => 'All bookings' ),
		'public'          => false,
		'show_ui'         => true,
		'menu_icon'       => 'dashicons-calendar-alt',
		'menu_position'   => 4,
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
	// Booking page, created once
	if ( ! get_option( 'by_book_page_id' ) ) {
		$page = get_page_by_path( 'book' );
		$id   = $page ? $page->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Book a call', 'post_name' => 'book', 'post_content' => '' ) );
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'page-book.php' );
			update_option( 'by_book_page_id', $id );
		}
	}
} );
function by_book_url() {
	$id = (int) get_option( 'by_book_page_id' );
	return $id ? get_permalink( $id ) : home_url( '/book/' );
}

add_filter( 'manage_by_booking_posts_columns', function ( $cols ) {
	return array( 'cb' => $cols['cb'], 'by_when' => 'When', 'title' => 'Who', 'by_type' => 'Call', 'by_status' => 'Status', 'by_email' => 'Email', 'by_phone' => 'Phone', 'date' => 'Booked' );
} );
add_action( 'manage_by_booking_posts_custom_column', function ( $col, $id ) {
	$map = array( 'by_when' => '_by_when_label', 'by_type' => '_by_type_label', 'by_email' => '_by_email', 'by_phone' => '_by_phone' );
	if ( isset( $map[ $col ] ) ) echo esc_html( get_post_meta( $id, $map[ $col ], true ) );
	if ( 'by_status' === $col ) {
		echo esc_html( by_booking_status_label( $id ) );
		$m = get_post_meta( $id, '_by_meet', true );
		if ( $m ) echo '<br><a href="' . esc_url( $m ) . '" target="_blank" rel="noopener">Meet link</a>';
	}
}, 10, 2 );
add_filter( 'manage_edit-by_booking_sortable_columns', function ( $c ) { $c['by_when'] = 'by_when'; return $c; } );
add_action( 'pre_get_posts', function ( $q ) {
	if ( is_admin() && $q->is_main_query() && 'by_booking' === $q->get( 'post_type' ) ) {
		if ( ! $q->get( 'orderby' ) || 'by_when' === $q->get( 'orderby' ) ) { $q->set( 'meta_key', '_by_when' ); $q->set( 'orderby', 'meta_value' ); if ( ! $q->get( 'order' ) ) $q->set( 'order', 'ASC' ); }
	}
} );

/* ---------- Slot engine ---------- */
function by_booking_tz() {
	try { return new DateTimeZone( by_opt( 'booking_tz' ) ?: 'Australia/Brisbane' ); } catch ( Exception $e ) { return new DateTimeZone( 'Australia/Brisbane' ); }
}
/** Start times already taken (any call type), as "Y-m-d H:i" in the booking timezone, with the minutes each one blocks. */
function by_booked_slots() {
	$q = new WP_Query( array( 'post_type' => 'by_booking', 'post_status' => array( 'private', 'publish' ), 'posts_per_page' => 500, 'fields' => 'ids', 'no_found_rows' => true,
		'meta_query' => array( array( 'key' => '_by_when', 'value' => gmdate( 'Y-m-d H:i', time() - DAY_IN_SECONDS ), 'compare' => '>=' ) ) ) );
	$out = array();
	foreach ( $q->posts as $id ) {
		$st = get_post_meta( $id, '_by_status', true );
		if ( 'cancelled' === $st ) continue;
		if ( 'awaiting_payment' === $st && (int) get_post_meta( $id, '_by_hold_until', true ) < time() ) continue; // unpaid hold expired
		$when = get_post_meta( $id, '_by_when', true ); // UTC "Y-m-d H:i"
		$mins = (int) get_post_meta( $id, '_by_mins', true ) ?: 30;
		if ( $when ) $out[] = array( 'utc' => strtotime( $when . ' UTC' ), 'mins' => $mins );
	}
	if ( function_exists( 'by_gcal_busy' ) ) $out = array_merge( $out, by_gcal_busy() );
	return $out;
}
/** All bookable start times for the next N days: [ 'Y-m-d' => [ ['t'=>'09:00','iso'=>'2026-10-27T09:00:00+10:00'], ... ] ] */
function by_available_slots( $type_mins = 30 ) {
	$tz      = by_booking_tz();
	$days    = array_map( 'trim', explode( ',', strtolower( by_opt( 'booking_days' ) ) ) );
	$step    = max( 15, (int) by_opt( 'booking_slot' ) ?: 30 );
	$notice  = (int) by_opt( 'booking_notice' );
	$horizon = min( 60, max( 1, (int) by_opt( 'booking_horizon' ) ?: 21 ) );
	list( $sh, $sm ) = array_map( 'intval', explode( ':', by_opt( 'booking_start' ) ?: '09:00' ) );
	list( $eh, $em ) = array_map( 'intval', explode( ':', by_opt( 'booking_end' ) ?: '16:00' ) );
	$earliest = time() + $notice * HOUR_IN_SECONDS;
	$booked   = by_booked_slots();
	$out      = array();
	$day      = new DateTime( 'today', $tz );
	for ( $i = 0; $i < $horizon + 1; $i++ ) {
		if ( in_array( strtolower( $day->format( 'D' ) ), $days, true ) ) {
			$slots = array();
			$t = clone $day; $t->setTime( $sh, $sm );
			$end = clone $day; $end->setTime( $eh, $em );
			while ( $t->getTimestamp() + $type_mins * 60 <= $end->getTimestamp() ) {
				$ts = $t->getTimestamp();
				$free = $ts >= $earliest;
				if ( $free ) foreach ( $booked as $b ) {
					if ( $ts < $b['utc'] + $b['mins'] * 60 && $ts + $type_mins * 60 > $b['utc'] ) { $free = false; break; }
				}
				if ( $free ) $slots[] = array( 't' => $t->format( 'H:i' ), 'label' => $t->format( 'g:i a' ), 'iso' => $t->format( 'c' ) );
				$t->modify( '+' . $step . ' minutes' );
			}
			if ( $slots ) $out[ $day->format( 'Y-m-d' ) ] = array( 'label' => $day->format( 'D j M' ), 'full' => $day->format( 'l j F' ), 'slots' => $slots );
		}
		$day->modify( '+1 day' );
	}
	return $out;
}

/* ---------- Handler ---------- */
function by_booking_handler() {
	$fail = function ( $msg, $code ) { wp_send_json( array( 'ok' => false, 'error' => $msg ), $code ); };
	if ( ! isset( $_POST['by_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['by_nonce'] ) ), 'by_booking' ) ) {
		$fail( 'Your session expired. Please refresh the page and try again.', 403 );
	}
	if ( ! empty( $_POST['website'] ) ) wp_send_json( array( 'ok' => true ) );
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	if ( $ip && get_transient( 'by_book_' . md5( $ip ) ) ) $fail( 'Please wait a moment before booking again.', 429 );

	$f = function ( $k, $max = 200 ) { return isset( $_POST[ $k ] ) ? mb_substr( sanitize_text_field( wp_unslash( $_POST[ $k ] ) ), 0, $max ) : ''; };
	$types = by_call_types();
	$type  = isset( $types[ $f( 'call_type', 20 ) ] ) ? $f( 'call_type', 20 ) : 'discovery';
	$mins  = $types[ $type ]['mins'];
	$date  = $f( 'date', 10 );
	$time  = $f( 'time', 5 );
	$d = array(
		'name'     => $f( 'name', 120 ),
		'email'    => sanitize_email( $f( 'email', 200 ) ),
		'phone'    => $f( 'phone', 40 ),
		'business' => $f( 'business', 160 ),
		'team_size' => by_team_size( $f( 'team_size', 10 ) ),
		'notes'    => isset( $_POST['notes'] ) ? mb_substr( sanitize_textarea_field( wp_unslash( $_POST['notes'] ) ), 0, 2000 ) : '',
		'consent'  => ! empty( $_POST['consent'] ),
	);
	if ( ! $d['name'] || ! is_email( $d['email'] ) || ! $d['phone'] ) $fail( 'Please add your name, a valid email and a phone number.', 422 );
	if ( ! $d['consent'] ) $fail( 'Please tick the box so we can contact you about the call.', 422 );

	// Validate the slot against live availability (prevents double booking and stale pages)
	$avail = by_available_slots( $mins );
	$ok    = false;
	if ( isset( $avail[ $date ] ) ) foreach ( $avail[ $date ]['slots'] as $s ) { if ( $s['t'] === $time ) { $ok = $s; break; } }
	if ( ! $ok ) $fail( 'That time was just taken or is no longer available. Please pick another slot.', 409 );

	$tz     = by_booking_tz();
	$start  = new DateTime( $date . ' ' . $time, $tz );
	$amount = function_exists( 'by_call_amount' ) ? by_call_amount( $type ) : 0;

	$post_id = wp_insert_post( array( 'post_type' => 'by_booking', 'post_status' => 'private', 'post_title' => $d['name'] . ( $d['business'] ? ' (' . $d['business'] . ')' : '' ), 'post_content' => '' ) );
	if ( ! $post_id || is_wp_error( $post_id ) ) $fail( 'Sorry, we could not save your booking right now.', 500 );
	$utc = clone $start; $utc->setTimezone( new DateTimeZone( 'UTC' ) );
	update_post_meta( $post_id, '_by_when', $utc->format( 'Y-m-d H:i' ) );
	update_post_meta( $post_id, '_by_when_label', $start->format( 'D j M, g:i a' ) );
	update_post_meta( $post_id, '_by_mins', $mins );
	update_post_meta( $post_id, '_by_type', $type );
	update_post_meta( $post_id, '_by_type_label', $types[ $type ]['name'] );
	update_post_meta( $post_id, '_by_email', $d['email'] );
	update_post_meta( $post_id, '_by_phone', $d['phone'] );
	update_post_meta( $post_id, '_by_data', $d );
	update_post_meta( $post_id, '_by_key', wp_generate_password( 20, false ) );
	if ( $ip ) set_transient( 'by_book_' . md5( $ip ), 1, 60 );

	if ( $amount > 0 ) {
		// Paid session: hold the slot for 30 minutes and send them to Stripe Checkout.
		update_post_meta( $post_id, '_by_status', 'awaiting_payment' );
		update_post_meta( $post_id, '_by_hold_until', time() + 31 * MINUTE_IN_SECONDS );
		by_booking_write_body( $post_id );
		$url = by_stripe_checkout( $post_id, $amount, $types[ $type ]['name'] . ' with ' . by_opt( 'brand' ), $d['email'], by_booking_label( $post_id ) );
		if ( ! $url ) { wp_delete_post( $post_id, true ); $fail( 'Sorry, the payment page would not open. Please try again, or email us and we will book you in.', 502 ); }
		wp_send_json( array( 'ok' => true, 'redirect' => $url ) );
	}

	$out = by_booking_confirm( $post_id );
	if ( $out ) wp_send_json( array_merge( array( 'ok' => true ), $out ) );
	$fail( 'Sorry, we could not save your booking right now.', 500 );
}

/** "Monday 1 December 2026, 9:00 am to 10:15 am (AEST)" for a booking. */
function by_booking_label( $post_id ) {
	$tz    = by_booking_tz();
	$start = new DateTime( '@' . strtotime( get_post_meta( $post_id, '_by_when', true ) . ' UTC' ) ); $start->setTimezone( $tz );
	$end   = clone $start; $end->modify( '+' . ( (int) get_post_meta( $post_id, '_by_mins', true ) ?: 30 ) . ' minutes' );
	return $start->format( 'l j F Y, g:i a' ) . ' to ' . $end->format( 'g:i a' ) . ' (' . $start->format( 'T' ) . ')';
}
function by_booking_write_body( $post_id ) {
	$d    = (array) get_post_meta( $post_id, '_by_data', true );
	$g    = function ( $k ) use ( $d ) { return isset( $d[ $k ] ) ? $d[ $k ] : ''; };
	$st   = by_booking_status_label( $post_id );
	$paid = get_post_meta( $post_id, '_by_paid', true );
	$meet = get_post_meta( $post_id, '_by_meet', true );
	$body = 'When: ' . by_booking_label( $post_id ) . "\nCall: " . get_post_meta( $post_id, '_by_type_label', true ) . ' (' . get_post_meta( $post_id, '_by_mins', true ) . " min)\nStatus: {$st}\n"
	      . ( $paid ? "Paid: {$paid}\n" : '' ) . ( $meet ? "Google Meet: {$meet}\n" : '' )
	      . 'Business: ' . $g( 'business' ) . "\nTeam size: " . $g( 'team_size' ) . "\nEmail: " . $g( 'email' ) . "\nPhone: " . $g( 'phone' ) . "\n\nWhat's slowing them down:\n" . $g( 'notes' ) . "\n";
	wp_update_post( array( 'ID' => $post_id, 'post_content' => $body ) );
	return $body;
}
function by_booking_status_label( $post_id ) {
	$s = get_post_meta( $post_id, '_by_status', true );
	if ( 'awaiting_payment' === $s ) {
		return (int) get_post_meta( $post_id, '_by_hold_until', true ) < time() ? 'Payment not completed' : 'Awaiting payment';
	}
	if ( 'cancelled' === $s ) return 'Payment cancelled';
	return get_post_meta( $post_id, '_by_paid', true ) ? 'Paid, confirmed' : 'Confirmed';
}

/**
 * Confirm a booking: create the Google Calendar event (with Meet link), email the team and the client,
 * and POST to the CRM webhook. Safe to call more than once; only the first call does anything.
 * Returns the data the booking page shows on the "You're in" screen.
 */
function by_booking_confirm( $post_id ) {
	$d     = (array) get_post_meta( $post_id, '_by_data', true );
	if ( empty( $d['email'] ) ) return null;
	$brand = by_opt( 'brand' );
	$tz    = by_booking_tz();
	$start = new DateTime( '@' . strtotime( get_post_meta( $post_id, '_by_when', true ) . ' UTC' ) ); $start->setTimezone( $tz );
	$mins  = (int) get_post_meta( $post_id, '_by_mins', true ) ?: 30;
	$end   = clone $start; $end->modify( '+' . $mins . ' minutes' );
	$tname = get_post_meta( $post_id, '_by_type_label', true );
	$label = by_booking_label( $post_id );

	// Only the first caller (webhook or return page) runs the side effects.
	if ( ! add_post_meta( $post_id, '_by_confirmed', time(), true ) ) {
		$meet = get_post_meta( $post_id, '_by_meet', true );
		return array( 'label' => $label, 'type' => $tname, 'meet' => $meet, 'how' => by_booking_how( $meet ), 'ics' => by_booking_ics( $start, $end, $tname . ' with ' . $brand, by_booking_how( $meet ), $d['email'] ) );
	}
	update_post_meta( $post_id, '_by_status', 'confirmed' );
	delete_post_meta( $post_id, '_by_hold_until' );

	$meet = '';
	if ( function_exists( 'by_gcal_create_event' ) ) {
		$ev = by_gcal_create_event( $post_id );
		if ( $ev ) {
			update_post_meta( $post_id, '_by_gcal_event', $ev['id'] );
			update_post_meta( $post_id, '_by_meet', $ev['meet'] );
			update_post_meta( $post_id, '_by_gcal_link', $ev['link'] );
			$meet = $ev['meet'];
		}
	}
	$how  = by_booking_how( $meet );
	$paid = get_post_meta( $post_id, '_by_paid', true );
	$body = by_booking_write_body( $post_id );

	// Calendar file
	$ics  = by_booking_ics( $start, $end, $tname . ' with ' . $brand, "With {$d['name']}" . ( $d['business'] ? " ({$d['business']})" : '' ) . "\n" . $how, $d['email'], $meet );
	if ( ! function_exists( 'wp_tempnam' ) ) require_once ABSPATH . 'wp-admin/includes/file.php'; // not loaded on the front end / REST
	$tmp  = wp_tempnam( 'better-yet-call.ics' );
	file_put_contents( $tmp, $ics );
	$icsf = dirname( $tmp ) . '/better-yet-call.ics';
	@rename( $tmp, $icsf ) || $icsf = $tmp;

	// Email the team (skip the .ics when the event is already in Google Calendar)
	$to   = by_opt( 'notify' ) ? array_map( 'trim', explode( ',', by_opt( 'notify' ) ) ) : get_option( 'admin_email' );
	$from = is_array( $to ) ? $to[0] : $to;
	$gl   = get_post_meta( $post_id, '_by_gcal_link', true );
	wp_mail( $to, ( $paid ? 'New paid booking: ' : 'New booking: ' ) . "{$d['name']}, " . $start->format( 'D j M g:i a' ),
		"New call booked on the website\n\nName: {$d['name']}\n" . $body . ( $gl ? "\nIn your calendar: {$gl}" : '' ) . "\nManage bookings: " . admin_url( 'edit.php?post_type=by_booking' ),
		array( 'Reply-To: ' . $d['name'] . ' <' . $d['email'] . '>' ), $gl ? array() : array( $icsf ) );

	// Confirm to the visitor (Google also sends them its own invite when the calendar is connected)
	$txt = "Hi {$d['name']},\n\nYou're booked in.\n\n{$tname} with {$brand}\n{$label}\n\n" . $how . "\n\n"
	     . ( $paid ? "Payment received: {$paid}. Stripe has emailed your receipt.\n\n" : '' )
	     . "Before the call, it helps to jot down the two or three jobs that eat your week. No preparation beyond that.\n\n"
	     . "Need to change the time? Reply to this email.\n\n{$brand}\n" . by_opt( 'tagline' ) . "\n" . home_url( '/' );
	wp_mail( $d['email'], "Confirmed: {$tname} with {$brand}, " . $start->format( 'D j M g:i a' ), $txt, array( 'Reply-To: ' . $brand . ' <' . $from . '>' ), array( $icsf ) );
	@unlink( $icsf );

	$hook = by_opt( 'webhook_url' );
	if ( $hook ) wp_remote_post( $hook, array( 'timeout' => 8, 'headers' => array( 'Content-Type' => 'application/json' ), 'body' => wp_json_encode( array_merge( $d, array( 'kind' => 'booking', 'call_type' => get_post_meta( $post_id, '_by_type', true ), 'start' => $start->format( 'c' ), 'end' => $end->format( 'c' ), 'paid' => $paid, 'meet' => $meet ) ) ) ) );

	return array( 'label' => $label, 'type' => $tname, 'meet' => $meet, 'ics' => $ics, 'how' => $how );
}
function by_booking_how( $meet = '' ) {
	return $meet ? 'Join on Google Meet: ' . $meet : by_opt( 'booking_how' );
}

/** Visitor came back from Stripe without paying: release the slot. */
function by_booking_cancel_pending( $post_id, $key ) {
	if ( 'by_booking' !== get_post_type( $post_id ) || ! $key || ! hash_equals( (string) get_post_meta( $post_id, '_by_key', true ), (string) $key ) ) return false;
	if ( 'awaiting_payment' !== get_post_meta( $post_id, '_by_status', true ) ) return false;
	update_post_meta( $post_id, '_by_status', 'cancelled' );
	delete_post_meta( $post_id, '_by_hold_until' );
	by_booking_write_body( $post_id );
	return true;
}
add_action( 'admin_post_nopriv_by_booking', 'by_booking_handler' );
add_action( 'admin_post_by_booking', 'by_booking_handler' );

function by_booking_ics( DateTime $start, DateTime $end, $summary, $description, $attendee = '', $location = '' ) {
	$u = function ( DateTime $d ) { $c = clone $d; $c->setTimezone( new DateTimeZone( 'UTC' ) ); return $c->format( 'Ymd\THis\Z' ); };
	$esc = function ( $s ) { return str_replace( array( '\\', ';', ',', "\n" ), array( '\\\\', '\;', '\,', '\n' ), $s ); };
	$lines = array( 'BEGIN:VCALENDAR', 'VERSION:2.0', 'PRODID:-//Better Yet//Booking//EN', 'METHOD:PUBLISH', 'BEGIN:VEVENT',
		'UID:' . wp_generate_uuid4() . '@' . wp_parse_url( home_url(), PHP_URL_HOST ), 'DTSTAMP:' . gmdate( 'Ymd\THis\Z' ), 'DTSTART:' . $u( $start ), 'DTEND:' . $u( $end ),
		'SUMMARY:' . $esc( $summary ), 'DESCRIPTION:' . $esc( $description ), 'URL:' . ( $location ? $location : home_url( '/' ) ) );
	if ( $location ) $lines[] = 'LOCATION:' . $esc( $location );
	if ( $attendee ) $lines[] = 'ATTENDEE;CN=' . $esc( $attendee ) . ':mailto:' . $attendee;
	$lines[] = 'BEGIN:VALARM'; $lines[] = 'TRIGGER:-PT30M'; $lines[] = 'ACTION:DISPLAY'; $lines[] = 'DESCRIPTION:' . $esc( $summary ); $lines[] = 'END:VALARM';
	$lines[] = 'END:VEVENT'; $lines[] = 'END:VCALENDAR';
	return implode( "\r\n", $lines ) . "\r\n";
}
