<?php
/**
 * Outputs JSON of all installed themes, plugins, and the wordpress version number
 *
 * Responds to a bruteprotect api call of 'bp_scan'
 *
 * @package Bruteprotect
 * @since 2.0
 */

// if we aren't cleared to track versions, bail
$privacy_opt_in = get_site_option( 'brute_privacy_opt_in' );
if ( ! isset( $privacy_opt_in['remote_monitoring'] ) ) {
	$response = array( 'error' => true, 'message' => 'This site is not authorized for version tracking. Settings: '.serialize($privacy_opt_in) );
	echo json_encode( $response );
	exit;
}
// if the nonce doesn't check out, bail
if ( ! verify_bp_nonce( $bruteprotect_host, $_POST ) ) {
	$response = array( 'error' => true, 'message' => 'Could not verify nonce' );
	echo json_encode( $response );
	exit;
}
$user_can_update = false;
if ( ! empty( $_POST['wp_user'] ) ) {
	$user_can_update = user_can( $_POST['wp_user'], 'update_plugins' );
}

wp_update_plugins();
wp_update_themes();

$response = array(
	'plugins'         => bruteprotect_get_plugins(),
	'themes'          => bruteprotect_get_themes(),
	'wp_version'      => get_bloginfo( 'version' ),
	'core_update'     => brute_protect_get_core_update(),
	'user_can_update' => $user_can_update,
);
echo json_encode( $response );
exit;

?>