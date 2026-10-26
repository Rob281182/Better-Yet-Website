<?php
/**
 * Better Yet theme functions.
 * Settings: Appearance > Customize > Better Yet settings.
 * Enquiries: saved under "Enquiries" in the dashboard, emailed, and optionally sent to a webhook (Zapier/Make/CRM).
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'BY_VERSION', '2.0.0' );

/* ---------- Settings ---------- */
function by_defaults() {
	return array(
		'brand'       => 'Better Yet',
		'tagline'     => 'Smarter systems. More time back.',
		'email'       => 'hello@betteryet.com.au',
		'notify'      => '',   // where enquiries are emailed; blank = site admin email
		'phone'       => '',
		'abn'         => '',
		'instagram'   => '',
		'linkedin'    => '',
		'booking_url' => '',
		'webhook_url' => '',
		'ga4_id'      => '',
		'pixel_id'    => '',
		// Offer and pricing (v1.5.0). Leave a price blank and the site says "Quoted on the call".
		'audit_name'     => 'The Time-Back Audit',
		'audit_price'    => '',
		'audit_founding' => '',
		'fix_price'      => '',
		'call_price'     => '',
		'plan_price'     => '',
		'project_price'  => '',
		'credit_text'    => '',
		'guarantee_text' => '',
	);
}

/* Price helper: returns the set price or a fallback phrase. */
function by_price( $key, $fallback = 'Quoted on the call' ) {
	$v = trim( (string) by_opt( $key ) );
	return $v !== '' ? $v : $fallback;
}
function by_has( $key ) { return trim( (string) by_opt( $key ) ) !== ''; }

function by_opt( $key ) {
	$d = by_defaults();
	return get_theme_mod( 'by_' . $key, isset( $d[ $key ] ) ? $d[ $key ] : '' );
}

function by_privacy_url() {
	$url = get_privacy_policy_url();
	return $url ? $url : home_url( '/privacy-policy/' );
}

add_action( 'customize_register', function ( $wp ) {
	$wp->add_section( 'by_settings', array(
		'title'    => 'Better Yet settings',
		'priority' => 20,
	) );
	$fields = array(
		'brand'       => array( 'Business name', 'text', 'Not locked yet? Change it here and it updates across the site.' ),
		'tagline'     => array( 'Tagline', 'text', '' ),
		'email'       => array( 'Public email address', 'email', 'Shown on the site.' ),
		'notify'      => array( 'Send enquiries to', 'text', 'Email address(es) that receive form enquiries, comma separated. Blank uses the site admin email.' ),
		'phone'       => array( 'Phone', 'text', '' ),
		'abn'         => array( 'ABN line', 'text', 'e.g. ABN 12 345 678 901' ),
		'instagram'   => array( 'Instagram URL', 'url', '' ),
		'linkedin'    => array( 'LinkedIn URL', 'url', '' ),
		'booking_url' => array( 'Booking link', 'url', 'Calendly, Cal.com, Google Calendar appointment page or Microsoft Bookings. "Book a call" buttons open it.' ),
		'webhook_url' => array( 'CRM / automation webhook URL', 'url', 'Optional. Each enquiry is POSTed here as JSON (Zapier, Make, n8n, HubSpot, GoHighLevel...).' ),
		'ga4_id'      => array( 'Google Analytics 4 ID', 'text', 'e.g. G-XXXXXXXXXX' ),
		'pixel_id'    => array( 'Meta Pixel ID', 'text', 'For Instagram/Facebook ads. Enquiries are tracked as Lead.' ),
		'audit_name'     => array( 'Audit name', 'text', 'Shown as the product name of the audit.' ),
		'audit_price'    => array( 'Audit price', 'text', 'e.g. "$995 + GST". Blank shows "Quoted on the call". Competitor report suggests $995 + GST.' ),
		'audit_founding' => array( 'Audit founding offer', 'text', 'Optional line under the price, e.g. "Founding price $695 + GST for our first three clients".' ),
		'fix_price'      => array( 'First fix price', 'text', 'e.g. "from $1,500 + GST". One workflow built in 2 to 3 weeks.' ),
		'call_price'     => array( 'Missed-call catcher price', 'text', 'e.g. "from $1,200 setup + $150 a month".' ),
		'plan_price'     => array( 'Keep it working plan price', 'text', 'e.g. "from $300 a month". Report suggests $300 to $600.' ),
		'project_price'  => array( 'Projects price', 'text', 'e.g. "from $3,000 + GST".' ),
		'credit_text'    => array( 'Audit credit line', 'text', 'Optional. e.g. "The full audit fee is credited against any build booked within 60 days." Blank hides it.' ),
		'guarantee_text' => array( 'Guarantee line', 'text', 'Optional. e.g. "If we can\'t find at least 5 hours a week to hand back, you don\'t pay." Blank hides it.' ),
	);
	$d = by_defaults();
	foreach ( $fields as $key => $f ) {
		$san = 'sanitize_text_field';
		if ( 'url' === $f[1] ) $san = 'esc_url_raw';
		if ( 'email' === $f[1] ) $san = 'sanitize_email';
		$wp->add_setting( 'by_' . $key, array( 'default' => $d[ $key ], 'sanitize_callback' => $san ) );
		$wp->add_control( 'by_' . $key, array(
			'label'       => $f[0],
			'description' => $f[2],
			'section'     => 'by_settings',
			'type'        => $f[1],
		) );
	}
} );

/* ---------- Hand-drawn blue marks (brand board: scribbles, circles, arrows) ---------- */
function by_scribble( $kind ) {
	$a = 'class="scribble scribble--' . esc_attr( $kind ) . '" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"';
	switch ( $kind ) {
		case 'underline': return '<svg ' . $a . ' viewBox="0 0 300 24" preserveAspectRatio="none"><path stroke-width="5" d="M4 14c48-8 96-10 150-8 44 1 90 5 142 2M18 20c70-5 150-8 262-6"/></svg>';
		case 'circle':    return '<svg ' . $a . ' viewBox="0 0 320 120" preserveAspectRatio="none"><path stroke-width="5" d="M232 14C150 2 30 10 16 54c-12 38 70 60 160 56 92-4 136-34 128-60-6-22-48-36-110-40"/></svg>';
		case 'arrow':     return '<svg ' . $a . ' viewBox="0 0 120 60"><path stroke-width="4" d="M6 44C34 18 70 10 110 22M92 10l20 12-16 16"/></svg>';
		case 'loop':      return '<svg ' . $a . ' viewBox="0 0 400 200"><path stroke-width="4" d="M20 150c40-90 110-130 150-100 36 28-20 90-60 80-44-10 4-90 70-100 70-10 120 40 150 80 24 32 10 70-40 60-46-10-30-70 30-80 50-8 70 40 60 90"/></svg>';
		case 'star':      return '<svg ' . $a . ' viewBox="0 0 60 60"><path stroke-width="3.5" d="M30 4l6 20 20 2-16 12 6 20-16-12-16 12 6-20L4 26l20-2z"/></svg>';
	}
	return '';
}

/* ---------- Theme setup and assets ---------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'script', 'style', 'search-form', 'gallery', 'caption' ) );
} );

add_filter( 'document_title_parts', function ( $parts ) {
	if ( is_front_page() ) {
		$parts = array( 'title' => by_opt( 'brand' ), 'tagline' => by_opt( 'tagline' ) );
	}
	return $parts;
} );
add_filter( 'document_title_separator', function () { return '|'; } );

add_action( 'wp_enqueue_scripts', function () {
	$dir = get_template_directory_uri() . '/assets';
	wp_enqueue_style( 'by-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Caveat:wght@500;600&display=swap', array(), null );
	wp_enqueue_style( 'by-site', $dir . '/site.css', array( 'by-fonts' ), BY_VERSION );
	wp_enqueue_script( 'by-site', $dir . '/site.js', array(), BY_VERSION, true );
	$site = array(
		'brand'       => by_opt( 'brand' ),
		'tagline'     => by_opt( 'tagline' ),
		'email'       => by_opt( 'email' ),
		'phone'       => by_opt( 'phone' ),
		'abn'         => by_opt( 'abn' ),
		'instagram'   => by_opt( 'instagram' ),
		'linkedin'    => by_opt( 'linkedin' ),
		'bookingUrl'  => by_opt( 'booking_url' ),
		'ga4Id'       => by_opt( 'ga4_id' ),
		'metaPixelId' => by_opt( 'pixel_id' ),
	);
	wp_add_inline_script( 'by-site', 'window.SITE = ' . wp_json_encode( $site ) . ';', 'before' );
} );

add_action( 'wp_head', function () {
	echo '<link rel="icon" href="' . esc_url( get_template_directory_uri() . '/assets/favicon.svg' ) . '" type="image/svg+xml">' . "\n";
}, 2 );

/* ---------- Enquiries (saved in the dashboard) ---------- */
add_action( 'init', function () {
	register_post_type( 'by_enquiry', array(
		'labels'          => array(
			'name'          => 'Enquiries',
			'singular_name' => 'Enquiry',
			'all_items'     => 'All enquiries',
		),
		'public'          => false,
		'show_ui'         => true,
		'menu_icon'       => 'dashicons-email-alt',
		'menu_position'   => 3,
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
} );

add_filter( 'manage_by_enquiry_posts_columns', function ( $cols ) {
	return array(
		'cb'       => $cols['cb'],
		'title'    => 'Name',
		'by_email' => 'Email',
		'by_phone' => 'Phone',
		'by_int'   => 'Interest',
		'date'     => 'Received',
	);
} );
add_action( 'manage_by_enquiry_posts_custom_column', function ( $col, $id ) {
	$map = array( 'by_email' => '_by_email', 'by_phone' => '_by_phone', 'by_int' => '_by_interest' );
	if ( isset( $map[ $col ] ) ) echo esc_html( get_post_meta( $id, $map[ $col ], true ) );
}, 10, 2 );

function by_enquiry_handler() {
	$fail = function ( $msg, $code ) { wp_send_json( array( 'ok' => false, 'error' => $msg ), $code ); };

	if ( ! isset( $_POST['by_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['by_nonce'] ) ), 'by_enquiry' ) ) {
		$fail( 'Your session expired. Please refresh the page and try again.', 403 );
	}
	// Honeypot: bots fill the hidden "website" field
	if ( ! empty( $_POST['website'] ) ) wp_send_json( array( 'ok' => true ) );

	$f = function ( $k, $max = 200 ) {
		return isset( $_POST[ $k ] ) ? mb_substr( sanitize_text_field( wp_unslash( $_POST[ $k ] ) ), 0, $max ) : '';
	};
	$kind = $f( 'kind', 20 ) === 'report' ? 'report' : 'enquiry';
	$d = array(
		'kind'          => $kind,
		'name'          => $f( 'name', 120 ),
		'business'      => $f( 'business', 160 ),
		'email'         => sanitize_email( $f( 'email' ) ),
		'phone'         => $f( 'phone', 40 ),
		'interest'      => $f( 'interest', 80 ),
		'message'       => isset( $_POST['message'] ) ? mb_substr( sanitize_textarea_field( wp_unslash( $_POST['message'] ) ), 0, 4000 ) : '',
		'calc_estimate' => $f( 'calc_estimate', 300 ),
		'consent'       => empty( $_POST['consent'] ) ? 'no' : 'yes',
		'submitted_at'  => current_time( 'c' ),
		'source'        => home_url( '/' ),
	);

	if ( 'report' === $kind && '' === $d['name'] && is_email( $d['email'] ) ) $d['name'] = ucfirst( strtok( $d['email'], '@' ) );
	if ( '' === $d['name'] || ! is_email( $d['email'] ) ) $fail( 'Please add your name and a valid email.', 422 );
	if ( 'yes' !== $d['consent'] ) $fail( 'Please tick the consent box.', 422 );

	// Rate limit: one enquiry per 30 seconds per visitor
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key = 'by_rl_' . md5( $ip );
	if ( get_transient( $key ) ) $fail( 'Please wait a moment before sending again.', 429 );
	set_transient( $key, 1, 30 );

	// 1. Save in the dashboard
	$body = "Business: {$d['business']}\nEmail: {$d['email']}\nPhone: {$d['phone']}\nInterest: {$d['interest']}\n";
	if ( $d['calc_estimate'] ) $body .= "Calculator: {$d['calc_estimate']}\n";
	$body .= "\nWhere time is being lost:\n{$d['message']}\n";
	$post_id = wp_insert_post( array(
		'post_type'    => 'by_enquiry',
		'post_status'  => 'private',
		'post_title'   => ( 'report' === $kind ? 'Time-back report: ' : '' ) . $d['name'] . ( $d['business'] ? ' (' . $d['business'] . ')' : '' ),
		'post_content' => $body,
	) );
	if ( $post_id && ! is_wp_error( $post_id ) ) {
		update_post_meta( $post_id, '_by_email', $d['email'] );
		update_post_meta( $post_id, '_by_phone', $d['phone'] );
		update_post_meta( $post_id, '_by_interest', $d['interest'] );
	}

	// 2. Email
	$to      = by_opt( 'notify' ) ? array_map( 'trim', explode( ',', by_opt( 'notify' ) ) ) : get_option( 'admin_email' );
	$subject = ( 'report' === $kind ? 'Time-back report request: ' : 'New ' . by_opt( 'brand' ) . ' enquiry: ' ) . $d['name'];
	$mailed  = wp_mail( $to, $subject, "New website enquiry\n\nName: {$d['name']}\n" . $body, array( 'Reply-To: ' . $d['name'] . ' <' . $d['email'] . '>' ) );

	// 2b. Calculator lead magnet: send the person their estimate straight away
	if ( 'report' === $kind ) {
		$brand = by_opt( 'brand' );
		$txt   = "Hi {$d['name']},\n\nHere is your time-back estimate from the {$brand} calculator:\n\n{$d['calc_estimate']}\n\n"
		       . "That is a rough figure based on handing over part of your repetitive admin. " . by_opt( 'audit_name' ) . " turns it into real numbers: your top five time drains in hours and dollars, the fixes ranked, and a fixed price for the first one.\n\n"
		       . "Reply to this email and tell us what eats your week, or book a free 20-minute call: " . ( by_opt( 'booking_url' ) ? by_opt( 'booking_url' ) : home_url( '/#contact' ) ) . "\n\n{$brand}\n" . by_opt( 'tagline' ) . "\n" . home_url( '/' );
		$from  = is_array( $to ) ? $to[0] : $to;
		wp_mail( $d['email'], 'Your time-back estimate from ' . $brand, $txt, array( 'Reply-To: ' . $brand . ' <' . $from . '>' ) );
	}

	// 3. Webhook (CRM / automation)
	$hook = by_opt( 'webhook_url' );
	if ( $hook ) {
		wp_remote_post( $hook, array(
			'timeout' => 8,
			'headers' => array( 'Content-Type' => 'application/json' ),
			'body'    => wp_json_encode( $d ),
		) );
	}

	if ( $post_id || $mailed ) wp_send_json( array( 'ok' => true ) );
	$fail( 'Sorry, we could not send your message right now.', 500 );
}
add_action( 'admin_post_nopriv_by_enquiry', 'by_enquiry_handler' );
add_action( 'admin_post_by_enquiry', 'by_enquiry_handler' );

/* ---------- On activation: create the privacy policy page ---------- */
add_action( 'after_switch_theme', function () {
	$existing = (int) get_option( 'wp_page_for_privacy_policy' );
	if ( $existing && 'publish' === get_post_status( $existing ) ) return;

	$content = <<<HTML
<!-- wp:paragraph --><p>Last updated: October 2026</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Better Yet ("we", "us") respects your privacy. This policy explains how we handle personal information collected through this website.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>What we collect</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>When you send an enquiry we collect the details you provide: your name, business name, email, phone number and message, plus any time-back calculator estimate you choose to send. If analytics or advertising tools are switched on, we also collect anonymous usage data such as pages visited and device type through cookies.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>How we use it</h2><!-- /wp:heading -->
<!-- wp:list --><ul><li>To respond to your enquiry and arrange a discovery call.</li><li>To provide and improve our services.</li><li>To measure how our website and advertising perform.</li></ul><!-- /wp:list -->
<!-- wp:paragraph --><p>We will not sell your personal information. We will only send you marketing if you have agreed to it, and you can opt out at any time.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Who we share it with</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>We use trusted service providers to run our business, such as our website host, email provider, CRM and scheduling tools, and analytics and advertising platforms (for example Google and Meta). Some of these providers may store data outside Australia.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Keeping it safe</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>We take reasonable steps to protect your information from misuse, loss and unauthorised access, and we delete it when it is no longer needed.</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Access and correction</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>You can ask to see or correct the personal information we hold about you, or make a privacy complaint, by emailing us using the address on our home page. If you are not satisfied with our response you can contact the Office of the Australian Information Commissioner (oaic.gov.au).</p><!-- /wp:paragraph -->
HTML;

	$id = wp_insert_post( array(
		'post_type'    => 'page',
		'post_status'  => 'publish',
		'post_title'   => 'Privacy policy',
		'post_name'    => 'privacy-policy',
		'post_content' => $content,
	) );
	if ( $id && ! is_wp_error( $id ) ) update_option( 'wp_page_for_privacy_policy', $id );
} );

/* ---------- "Our work" page: created once, uses the page-our-work.php template ---------- */
add_action( 'init', function () {
	if ( get_option( 'by_work_page_id' ) ) return;
	$page = get_page_by_path( 'our-work' );
	if ( ! $page ) {
		$id = wp_insert_post( array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Our work',
			'post_name'    => 'our-work',
			'post_content' => '',
		) );
	} else {
		$id = $page->ID;
	}
	if ( $id && ! is_wp_error( $id ) ) {
		update_post_meta( $id, '_wp_page_template', 'page-our-work.php' );
		update_option( 'by_work_page_id', $id );
	}
} );

function by_work_url() {
	$id = (int) get_option( 'by_work_page_id' );
	return $id ? get_permalink( $id ) : home_url( '/our-work/' );
}

/* One-off image importer (remove after use) */
require_once get_template_directory() . '/inc/by-import.php';
