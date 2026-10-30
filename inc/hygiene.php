<?php
/**
 * Launch hygiene (v2.1.1): en-AU, noindex on the staging host, per-page meta and Open Graph,
 * locally hosted case-study images.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Language: Australian English regardless of the WP install language */
add_filter( 'language_attributes', function ( $out ) {
	return preg_replace( '/lang="[^"]*"/', 'lang="en-AU"', $out ) ?: 'lang="en-AU"';
} );

/* Staging: keep the temporary Hostinger address out of Google. Lifts itself once the real domain is live. */
function by_is_staging() {
	$host = wp_parse_url( home_url(), PHP_URL_HOST );
	return $host && ( substr( $host, -18 ) === '.hostingersite.com' || substr( $host, -10 ) === '.hstgr.site' );
}
add_action( 'wp_head', function () { if ( by_is_staging() ) echo '<meta name="robots" content="noindex, nofollow">' . "\n"; }, 1 );
add_action( 'send_headers', function () { if ( by_is_staging() && ! headers_sent() ) header( 'X-Robots-Tag: noindex, nofollow', true ); } );

/* Per-page description and Open Graph */
function by_page_meta() {
	$brand = by_opt( 'brand' );
	$desc  = $brand . ' helps Australian businesses of every size, from sole traders to corporates, find where time and money are being lost, then fixes it with practical automation and smarter systems. Start with ' . by_opt( 'audit_name' ) . '.';
	if ( is_page( 'book' ) )      $desc = 'Book a free 20-minute call or a ' . by_opt( 'audit_name' ) . ' session with ' . $brand . '. Pick a time that suits you; confirmation and calendar invite sent straight away.';
	if ( is_page( 'our-work' ) )  $desc = 'What ' . $brand . ' has built for real businesses: an automated bike builder, a clinic front door, an artist\'s online studio, franchise enrolments and a custom candle shop.';
	if ( is_page( 'contact' ) )   $desc = 'Tell ' . $brand . ' where your week goes. We reply within one business day with times for a free 20-minute call.';
	if ( is_page( 'privacy-policy' ) ) $desc = 'How ' . $brand . ' handles the personal information collected through this website.';
	return apply_filters( 'by_page_meta', array( 'description' => $desc ) );
}
add_action( 'wp_head', function () {
	$m     = by_page_meta();
	$title = wp_get_document_title();
	$url   = is_front_page() ? home_url( '/' ) : get_permalink();
	$img   = get_template_directory_uri() . '/assets/og.png?v=' . BY_VERSION;
	echo '<meta name="description" content="' . esc_attr( $m['description'] ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( by_opt( 'brand' ) ) . '">' . "\n";
	echo '<meta property="og:locale" content="en_AU">' . "\n";
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $m['description'] ) . '">' . "\n";
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
	echo '<meta property="og:image:width" content="1200"><meta property="og:image:height" content="630">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	if ( ! by_is_staging() ) echo '<link rel="canonical" href="' . esc_url( $url ) . '">' . "\n";
}, 3 );

/* Structured data: the business, and the FAQ on the home page */
add_action( 'wp_head', function () {
	$brand = by_opt( 'brand' );
	$org   = array( '@context' => 'https://schema.org', '@type' => 'ProfessionalService', 'name' => $brand, 'url' => home_url( '/' ), 'description' => by_page_meta()['description'], 'areaServed' => 'AU', 'email' => by_opt( 'email' ) );
	if ( by_opt( 'phone' ) ) $org['telephone'] = by_opt( 'phone' );
	$same = array_filter( array( by_opt( 'instagram' ), by_opt( 'linkedin' ) ) );
	if ( $same ) $org['sameAs'] = array_values( $same );
	echo '<script type="application/ld+json">' . wp_json_encode( $org, JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 4 );

/* ---------- Case-study images: serve local copies instead of hotlinking client sites ----------
 * The templates still reference the client URLs (one list to maintain). On output, any image URL that has a
 * local copy in wp-content/uploads/better-yet/work/ is swapped for it. Copies are fetched by a logged-in admin visiting the
 * page with ?by_import_work=1 (already run on 27 Oct 2026; re-run after adding images).
 */
function by_media_map() { return get_option( 'by_media_map', array() ); }
function by_media_hosts() { return array( 'heiden.bike', 'roamorthotics.com.au', 'stephanieannestudio.com', 'www.readysteadygokids.com.au', 'rsgk-assets-dev.s3.ap-southeast-2.amazonaws.com', 'www.damselfly.com.au', 'damselfly.com.au', 'cdn.shopify.com' );
}
add_action( 'template_redirect', function () {
	if ( ! ( is_front_page() || is_page( 'our-work' ) ) ) return;
	$import = isset( $_GET['by_import_work'] ) && current_user_can( 'manage_options' ); // admins: visit /?by_import_work=1 and /our-work/?by_import_work=1 to (re)fetch copies
	ob_start( function ( $html ) use ( $import ) {
		$map   = by_media_map();
		$hosts = by_media_hosts();
		if ( $import ) {
			$up  = wp_upload_dir();
			$dir = trailingslashit( $up['basedir'] ) . 'better-yet/work';
			wp_mkdir_p( $dir );
			preg_match_all( '/\b(?:src|data-src)="(https?:\/\/[^"]+\.(?:jpe?g|png|webp|gif)(?:\?[^"]*)?)"/i', $html, $mm );
			$log = array();
			foreach ( array_unique( $mm[1] ) as $u ) {
				$u = html_entity_decode( $u );
				if ( ! in_array( wp_parse_url( $u, PHP_URL_HOST ), $hosts, true ) ) continue;
				if ( isset( $map[ $u ] ) ) { $log[ $u ] = 'kept'; continue; }
				$ext  = strtolower( pathinfo( wp_parse_url( $u, PHP_URL_PATH ), PATHINFO_EXTENSION ) ) ?: 'jpg';
				$name = substr( md5( $u ), 0, 12 ) . '-' . sanitize_file_name( basename( wp_parse_url( $u, PHP_URL_PATH ) ) );
				$r    = wp_remote_get( $u, array( 'timeout' => 40, 'user-agent' => 'Mozilla/5.0 (BetterYet site importer)' ) );
				$code = wp_remote_retrieve_response_code( $r );
				$body = is_wp_error( $r ) ? '' : wp_remote_retrieve_body( $r );
				if ( 200 === $code && strlen( $body ) > 1000 && @getimagesizefromstring( $body ) ) {
					file_put_contents( "$dir/$name", $body );
					$map[ $u ] = trailingslashit( $up['baseurl'] ) . 'better-yet/work/' . $name;
					$log[ $u ] = 'saved ' . round( strlen( $body ) / 1024 ) . 'KB';
				} else {
					$log[ $u ] = 'failed ' . ( is_wp_error( $r ) ? $r->get_error_message() : $code );
				}
			}
			update_option( 'by_media_map', $map, false );
			header( 'Content-Type: text/plain' );
			$out = '';
			foreach ( $log as $k => $v ) $out .= "$v  $k\n";
			return $out ?: "nothing found\n";
		}
		if ( ! $map ) return $html;
		return str_replace( array_map( 'esc_url', array_keys( $map ) ), array_map( 'esc_url', array_values( $map ) ), $html );
	} );
} );
