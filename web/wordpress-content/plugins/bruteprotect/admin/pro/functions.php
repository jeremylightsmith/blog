<?php
/**
 * Collection of common pro-level functions
 *
 * @since 2.0
 */

/**
 * Determines if this site is a pro-level site
 *
 * @since 2.0
 *
 * @return bool
 */
function bruteprotect_is_linked() {
    global $current_user;
    $bruteprotect_user_linked = get_user_meta( $current_user->ID, 'bruteprotect_user_linked', false );
    if( $bruteprotect_user_linked == false )
        return false;
    $site_linked = get_site_option( 'bruteprotect_user_linked', false );
    if( $site_linked == false )
        return false;

    return true;
}

/**
 * Determines if this site can use secure login
 *
 * @since 2.0
 *
 * @return bool
 */
function bruteprotect_has_secure_login() {
	$privacy_opt_in = get_site_option( 'brute_privacy_opt_in' );
	if ( isset( $privacy_opt_in['remote_login'] ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Saves info from a 'check_key' api call
 *
 * @since 2.0
 *
 * @param array $response
 *
 * @return void
 */

function bruteprotect_save_pro_info( $response ) {
	if ( isset( $response['ckval'] ) ) {
		update_site_option( 'bruteprotect_ckval', $response['ckval'] );
	}

	if ( isset( $response['site_id'] ) ) {
		update_site_option( 'bruteprotect_site_id', $response['site_id'] );
	}

	// remote_monitoring, remote_version, remote_update, remote_login
	if ( isset($response['privacy_settings']) && is_array( $response['privacy_settings'] ) ) {
		$privacy_opt_in = get_site_option( 'brute_privacy_opt_in' );
		foreach ( $response['privacy_settings'] as $k => $v ) {
			if ( $v == '0' ) {
				if ( isset( $privacy_opt_in[ $k ] ) ) {
					unset( $privacy_opt_in[ $k ] );
				}
			} else {
				$privacy_opt_in[ $k ] = $v;
			}
		}

		update_site_option( 'brute_privacy_opt_in', $privacy_opt_in );
	}
}

/**
 * Calls the api to verify that an action can be taken
 *
 * @since 2.0
 *
 * @param string $url
 * @param array $data
 *
 * @return bool
 */
function verify_bp_nonce( $url, $data ) {

	$verified = false;
	if ( isset( $data['bpnonce'] ) ) {

		if ( isset( $data['action'] ) ) {
			unset( $data['action'] );
		}

		$data['action'] = 'verify_nonce';

		$args = array(
			'body'        => $data,
			'httpversion' => '1.0',
			'timeout'     => 15
		);

		$response_json = wp_remote_post( $url, $args );
		if ( is_array( $response_json ) ) {
			$response = json_decode( $response_json['body'], true );
			if ( isset( $response['verified'] ) ) {
				$chkval = get_site_option( 'bruteprotect_ckval' );
				$key    = sha1( $chkval . $data['bpnonce'] );
				if ( $key == $response['verified'] ) {
					$verified = true;
				}
			}
		}
	}

	return $verified;
}

/**
 * Returns an array of installed plugins
 *
 * @since 2.0
 *
 * @return array
 */
function bruteprotect_get_plugins() {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	$installed_plugins   = get_plugins();
	$out_of_date_plugins = bruteprotect_get_out_of_date_plugins();
	$bp_plugins          = array();
	if ( is_array( $installed_plugins ) ) :
		foreach ( $installed_plugins as $key => &$plugin ) :
			$needs_update                = ( isset( $out_of_date_plugins[ $key ] ) ) ? '1' : '0';
			$update_to_version           = ( isset( $out_of_date_plugins[ $key ] ) ) ? $out_of_date_plugins[ $key ]->new_version : '';
			$key_parts                   = explode( '/', $key );
			$plugin['slug']              = $key_parts[0];
			$plugin['path']              = $key;
			$plugin['needs_update']      = $needs_update;
			$plugin['update_to_version'] = $update_to_version;
			if ( is_plugin_active( $key ) ) {
				$plugin['active'] = '1';
			} else {
				$plugin['active'] = '0';
			}
			$bp_plugins[] = $plugin;
		endforeach;
	endif;

	return $bp_plugins;
}

/**
 * Returns an array of installed themes
 *
 * @since 2.0
 *
 * @return array
 */
function bruteprotect_get_themes() {
	if ( ! function_exists( 'wp_get_themes' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/theme.php' );
	}
	$themes             = wp_get_themes();
	$out_of_date_themes = bruteprotect_get_out_of_date_themes();
	$installed_themes   = array();
	$current_theme      = get_template();
	if ( is_array( $themes ) ) :
		foreach ( $themes as $slug => $theme ) {
			$needs_update                                   = ( isset( $out_of_date_themes[ $slug ] ) ) ? '1' : '0';
			$update_to_version                              = ( isset( $out_of_date_themes[ $slug ] ) ) ? $out_of_date_themes[ $slug ]['new_version'] : '';
			$active                                         = ( $current_theme == $slug ) ? '1' : '0';
			$installed_themes[ $slug ]['Name']              = $theme->get( 'Name' );
			$installed_themes[ $slug ]['ThemeURI']          = $theme->get( 'ThemeURI' );
			$installed_themes[ $slug ]['Description']       = $theme->get( 'Description' );
			$installed_themes[ $slug ]['Author']            = $theme->get( 'Author' );
			$installed_themes[ $slug ]['AuthorURI']         = $theme->get( 'AuthorURI' );
			$installed_themes[ $slug ]['Version']           = $theme->get( 'Version' );
			$installed_themes[ $slug ]['Template']          = $theme->get( 'Template' );
			$installed_themes[ $slug ]['Status']            = $theme->get( 'Status' );
			$installed_themes[ $slug ]['Tags']              = $theme->get( 'Tags' );
			$installed_themes[ $slug ]['TextDomain']        = $theme->get( 'TextDomain' );
			$installed_themes[ $slug ]['DomainPath']        = $theme->get( 'DomainPath' );
			$installed_themes[ $slug ]['needs_update']      = $needs_update;
			$installed_themes[ $slug ]['update_to_version'] = $update_to_version;
			$installed_themes[ $slug ]['active']            = $active;
		}
	endif;

	return $installed_themes;
}


/**
 * Adds support for http_response_code if it's not already there
 *
 * @since 2.0
 *
 * @return array
 */
if ( ! function_exists( 'http_response_code' ) ) {
	function http_response_code( $code = null ) {

		if ( $code !== null ) {

			switch ( $code ) {
				case 100:
					$text = 'Continue';
					break;
				case 101:
					$text = 'Switching Protocols';
					break;
				case 200:
					$text = 'OK';
					break;
				case 201:
					$text = 'Created';
					break;
				case 202:
					$text = 'Accepted';
					break;
				case 203:
					$text = 'Non-Authoritative Information';
					break;
				case 204:
					$text = 'No Content';
					break;
				case 205:
					$text = 'Reset Content';
					break;
				case 206:
					$text = 'Partial Content';
					break;
				case 300:
					$text = 'Multiple Choices';
					break;
				case 301:
					$text = 'Moved Permanently';
					break;
				case 302:
					$text = 'Moved Temporarily';
					break;
				case 303:
					$text = 'See Other';
					break;
				case 304:
					$text = 'Not Modified';
					break;
				case 305:
					$text = 'Use Proxy';
					break;
				case 400:
					$text = 'Bad Request';
					break;
				case 401:
					$text = 'Unauthorized';
					break;
				case 402:
					$text = 'Payment Required';
					break;
				case 403:
					$text = 'Forbidden';
					break;
				case 404:
					$text = 'Not Found';
					break;
				case 405:
					$text = 'Method Not Allowed';
					break;
				case 406:
					$text = 'Not Acceptable';
					break;
				case 407:
					$text = 'Proxy Authentication Required';
					break;
				case 408:
					$text = 'Request Time-out';
					break;
				case 409:
					$text = 'Conflict';
					break;
				case 410:
					$text = 'Gone';
					break;
				case 411:
					$text = 'Length Required';
					break;
				case 412:
					$text = 'Precondition Failed';
					break;
				case 413:
					$text = 'Request Entity Too Large';
					break;
				case 414:
					$text = 'Request-URI Too Large';
					break;
				case 415:
					$text = 'Unsupported Media Type';
					break;
				case 500:
					$text = 'Internal Server Error';
					break;
				case 501:
					$text = 'Not Implemented';
					break;
				case 502:
					$text = 'Bad Gateway';
					break;
				case 503:
					$text = 'Service Unavailable';
					break;
				case 504:
					$text = 'Gateway Time-out';
					break;
				case 505:
					$text = 'HTTP Version not supported';
					break;
				default:
					exit( 'Unknown http status code "' . htmlentities( $code ) . '"' );
					break;
			}

			$protocol = ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' );

			header( $protocol . ' ' . $code . ' ' . $text );

			$GLOBALS['http_response_code'] = $code;

		} else {

			$code = ( isset( $GLOBALS['http_response_code'] ) ? $GLOBALS['http_response_code'] : 200 );

		}

		return $code;

	}
}

/**
 * Gets an array of out of date plugins from the site's transient
 *
 * @since 2.0
 *
 * @return array
 */
function bruteprotect_get_out_of_date_plugins() {
	$out_of_date    = array();
	$update_plugins = get_site_transient( 'update_plugins' );
	if ( empty( $update_plugins ) ) {
		return $out_of_date;
	}

	$out_of_date = $update_plugins->response;

	return $out_of_date;
}

/**
 * Gets an array of out of date themes from the site's transient
 *
 * @since 2.0
 *
 * @return array
 */
function bruteprotect_get_out_of_date_themes() {
	$out_of_date   = array();
	$update_themes = get_site_transient( 'update_themes' );
	if ( empty( $update_themes ) ) {
		return $out_of_date;
	}

	$out_of_date = $update_themes->response;

	return $out_of_date;
}

/**
 * Checks site transient to see if we need a core update or not
 *
 * @since 2.0
 *
 * @return string '1' or '0'
 */
function brute_protect_get_core_update() {
	$core_update = '0';
	$update_core = get_site_transient( 'update_core' );
	if ( ! isset( $update_core->updates ) ) {
		return $core_update;
	}

	if ( ! is_array( $update_core->updates ) ) {
		return $core_update;
	}

	$updates = $update_core->updates[0];

	if ( ! isset( $updates->response ) || $updates->response == 'latest' ) {
		return $core_update;
	}

	return '1';
}

function brute_site_unlinked_notice() {
    ?>
       <div class="updated">
           <p>This site was unlinked from your my.bruteprotect.com account.</p>
       </div>
       <?php
}

/**
 * Gets users on this site who have linked to an account on my.bruteprotect
 */
function get_bruteprotect_users() {
	$args = array(
		'meta_query' => array(
			array(
				'key' => 'bruteprotect_user_linked',
				'compare'=>'EXISTS',
			),
		),
	);
	$bp_users = get_users( $args );
	return $bp_users;
}

/**
 * @param $privacy_options
 * @return string | bool
 */
function get_mybp_iframe_url( $privacy_options ) {
    global $current_user;
    $user_linked = get_user_meta( $current_user->ID, 'bruteprotect_user_linked', true );

    // if the user has not linked yet, return false
    if( empty( $user_linked ))
        return false;

    // if the user chose not to allow BP to monitor their site, we tell that MyBruteProtect is not available
    if( !is_array($privacy_options) || !isset($privacy_options['remote_monitoring']))
        return MYBP_URL . 'wp/no_permissions/';
    $site_id = get_site_option( 'bruteprotect_site_id' );

    return MYBP_URL . 'wp/dash/' . $site_id . '/' . $user_linked;

}
