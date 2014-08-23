<?php
/**
 * Logs a user after they've authenticated throught bruteprotect api secure login feature
 *
 * Requires a nonce set in bp_secure_login_process
 *
 * @package Bruteprotect
 *
 * @since 2.0
 */

$uid   = $_GET['user'];
$nonce = $_GET['nonce'];

$tval = get_site_transient( 'brute_login_' . $uid );

if ( ! isset( $nonce ) || $nonce != $tval ) {
	wp_die( 'Login Error BP300' );
}

delete_site_transient( 'brute_login_' . $uid );

wp_set_auth_cookie( $uid );
$redirect = urldecode( $_GET['redirect'] );
if ( empty( $redirect ) ) {
	$redirect = home_url() . '/wp-admin';
}
wp_redirect( $redirect );
exit;
?>