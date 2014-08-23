<?php
/**
 * Answers a request from the api to unlink a site for the given user.
 *
 * Outputs results to json
 *
 * @package Bruteprotect
 * @since 2.0
 */

// if the nonce doesn't check out, bail
if ( ! verify_bp_nonce( $bruteprotect_host, $_POST ) ) {
	$response = array( 'error' => true, 'message' => 'Could not verify nonce' );
	echo json_encode( $response );
	exit;
}

if( isset( $_POST['wp_user_id'])) {
	// remove the user meta
	$user_id = $_POST['wp_user_id'];
	delete_user_meta( $user_id, 'bruteprotect_user_linked');
}

if( isset( $_POST['remaining_users'])) {
	// if their are no remaining users for this site on my.bruteprotect, delete the site option as well
	$remaing_users = $_POST['remaining_users'];
	if( $remaing_users == '0' ) {
		delete_site_option( 'bruteprotect_user_linked' );
	}
}

$response = array(
	'error'         => false,
	'message'		=> 'User unlinked.',
);
echo json_encode( $response );
exit;

?>