<?php
/**
 * Process a secure login request from the brute protect api
 *
 * Sets a nonce for use in log_me_in.php
 *
 * @package Bruteprotect
 *
 * @since 2.0
 */

if ( verify_bp_nonce( $bruteprotect_host, $_POST ) ) {

	$username = $_POST['un'];
	$password = $_POST['ps'];
	$redirect = $_POST['redirect'];
	$ckval    = get_site_option( 'bruteprotect_ckval' );
	$salt     = substr( $ckval, 2, 16 );

	global $wpdb;

	$sql      = $wpdb->prepare( "select AES_DECRYPT(UNHEX(%s), '%s') AS password", $password, $salt );
	$password = $wpdb->get_var( $sql );

	$user = wp_authenticate( $username, $password );

	if ( is_wp_error( $user ) ) {
		http_response_code( 200 );
		$o['status'] = 'failure';
		echo json_encode( $o );
		exit;
	}

	//$login_destination = plugins_url( 'log_me_in.php' , __FILE__ ) . '?user='.$user->ID;
	$login_destination = home_url() . '/?bruteprotect_pro=true&bpp_action=bp_secure_login&user=' . $user->ID . '&redirect=' . urlencode($redirect);

	$tname = 'brute_login_' . $user->ID;
	$tval  = substr( md5( rand( 0, 1000000000000 ) ), 3, 20 );
	set_site_transient( $tname, $tval, 300 );

	$login_destination .= '&nonce=' . $tval;

	$o['status']      = 'success';
	$o['destination'] = $login_destination;


} else {
	$o['status'] = 'fail';
	$o['error']  = 'Could not verify nonce';
}
echo json_encode( $o );
exit;

?>