<?php
/**
 * One-off importer for the Higgsfield images (remove after use).
 * Fixed URL list, idempotent, writes to wp-content/uploads/better-yet/.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', function () {
	if ( ! isset( $_GET['by_import'] ) || 'k7Qx2pLm9vTz' !== $_GET['by_import'] ) { return; }
	$base = 'https://d8j0ntlcm91z4.cloudfront.net/user_3KhkWBKxc7moSbEjwJ1rySc6h0a/';
	$ids  = array(
		'hf_20261026_070830_726bd6ef-24b5-40f1-8d70-f911c5d65764',
		'hf_20261026_070831_2630459f-8516-42c6-a474-7fd61c6b2e82',
		'hf_20261026_070831_cc5c684f-dac2-405e-a6ee-0834758d03a9',
		'hf_20261026_070832_1614edad-d7f2-4787-9a42-408e4df5bd0f',
		'hf_20261026_070908_40727e0e-fdbc-40b0-80bb-92b0620c00e3',
		'hf_20261026_070908_407ddab5-9727-45c5-b851-cacd9445a09c',
		'hf_20261026_070910_517b5ab2-4d0b-474c-bf66-48d91876c281',
		'hf_20261026_070910_c8bcb7cc-4752-4f9a-af3d-00d74c581302',
		'hf_20261026_070951_607608a4-e51b-437a-893e-ed6f558f130b',
	);
	$up  = wp_upload_dir();
	$dir = trailingslashit( $up['basedir'] ) . 'better-yet';
	wp_mkdir_p( $dir );
	$out = array();
	$txt = '';
	foreach ( $ids as $i => $id ) {
		$n    = sprintf( 'hf-%02d', $i + 1 );
		$file = "$dir/$n.png";
		if ( ! file_exists( $file ) ) {
			$r = wp_remote_get( $base . $id . '.png', array( 'timeout' => 60 ) );
			if ( is_wp_error( $r ) ) { $out[ $n ] = $r->get_error_message(); continue; }
			if ( 200 !== wp_remote_retrieve_response_code( $r ) ) { $out[ $n ] = 'http ' . wp_remote_retrieve_response_code( $r ); continue; }
			file_put_contents( $file, wp_remote_retrieve_body( $r ) );
		}
		$size = @getimagesize( $file );
		$out[ $n ] = $size ? $size[0] . 'x' . $size[1] . ' ' . round( filesize( $file ) / 1024 ) . 'KB' : 'bad';
		// Web-size JPEG for the site and a small thumb for review.
		foreach ( array( 'web' => array( 1600, 82 ), 'thumb' => array( 420, 55 ) ) as $kind => $spec ) {
			$ed = wp_get_image_editor( $file );
			if ( is_wp_error( $ed ) ) { $out[ $n ] .= ' noeditor:' . $ed->get_error_message(); continue; }
			$ed->resize( $spec[0], $spec[0], false );
			$ed->set_quality( $spec[1] );
			$dest = 'web' === $kind ? "$dir/$n.jpg" : "$dir/$n-thumb.jpg";
			$ed->save( $dest, 'image/jpeg' );
			if ( 'thumb' === $kind && file_exists( $dest ) ) {
				$txt .= "== $n\n" . chunk_split( base64_encode( file_get_contents( $dest ) ), 2000, "\n" );
			}
		}
	}
	file_put_contents( "$dir/thumbs.txt", $txt );
	header( 'Content-Type: text/plain' );
	echo "uploads url: " . $up['baseurl'] . "/better-yet/\n";
	foreach ( $out as $k => $v ) { echo "$k: $v\n"; }
	exit;
} );
