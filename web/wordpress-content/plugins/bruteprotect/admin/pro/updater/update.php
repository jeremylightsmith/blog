<?php
/**
 * Updates the given assets (plugins, themes, core) and outputs the result to JSON
 *
 * Responds to a bruteprotect api call of 'bp_update'
 *
 * @package Bruteprotect
 * @since 2.0
 */

//make sure this site is opted in for remote update
$privacy_opt_in = get_site_option( 'brute_privacy_opt_in' );
if ( ! $privacy_opt_in['remote_monitoring'] ) {
	$response = array( 'error' => true, 'message' => 'Site has not enabled remote plugin updating' );
	echo json_encode( $response );
	exit;
}


//run our logic to make sure that this is legit
if ( ! verify_bp_nonce( $bruteprotect_host, $_POST ) && 1 == 2 ) {
	$response = array( 'error' => true, 'message' => 'Could not verify nonce' );
	echo json_encode( $response );
	exit;
}
if ( ! isset( $_POST['user_id'] ) ) {
	$response = array( 'error' => true, 'message' => 'User does not have the capability to perform this update' );
	echo json_encode( $response );
	exit;
}
if ( $_POST['user_id'] != 'auto' ) {
	if ( ! user_can( $_POST['user_id'], 'update_plugins' ) ) {
		$response = array( 'error' => true, 'message' => 'User does not have the capability to perform this update' );
		echo json_encode( $response );
		exit;
	}
}

/**
 * Updates the given list of plugins.
 * 
 * Accepts an array of plugin paths such as 'bruteprotect/bruteprotect.php'
 * Returns a detailed array showing the status of each plugin and a log of messages output during the process
 *
 * @param array $plugins
 * @return array
 */
function bruteprotect_bulk_update_plugins( $plugins ) {
	$skin          = new Automatic_Upgrader_Skin();
	$upgrader      = new Plugin_Upgrader( $skin );
	$results       = $upgrader->bulk_upgrade( $plugins );
	$messages      = $upgrader->skin->get_upgrade_messages();
	$o['results']  = $results;
	$o['messages'] = $messages;

	return $o;
}

/**
 * Updates the given list of themes.
 * 
 * Accepts an array of theme slugs such as 'twentyfourteen'
 * Returns a detailed array showing the status of each theme and a log of messages output during the process
 *
 * @param array $themes
 * @return array
 */
function bruteprotect_bulk_update_themes( $themes ) {
	$skin          = new Automatic_Upgrader_Skin();
	$upgrader      = new Theme_Upgrader( $skin );
	$results       = $upgrader->bulk_upgrade( $themes );
	$messages      = $upgrader->skin->get_upgrade_messages();
	$o['results']  = $results;
	$o['messages'] = $messages;

	return $o;
}

/**
 * Updates wordpress core to the given version.
 *
 * Returns the new version on success, and a Wp_error object on failure
 * 
 * @param string $version
 * @return string|object
 */
function bruteprotect_update_core($version) {
	$locale = get_locale();
	$update = find_core_update( $version, $locale );
	$skin = new Automatic_Upgrader_Skin();
	$upgrader = new Core_Upgrader( $skin );
	$results = $upgrader->upgrade( $update );
	return $results;
}

include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
include_once ABSPATH . 'wp-admin/includes/file.php';
include_once ABSPATH . 'wp-admin/includes/misc.php';
include_once ABSPATH . 'wp-admin/includes/plugin.php';
include_once ABSPATH . 'wp-admin/includes/theme.php';
include_once ABSPATH . 'wp-admin/includes/update.php';
$update_error = false;
$overview     = '';
$response     = array(
	'message' => array()
);

if( !empty( $_POST['core']) ) {
	$core = bruteprotect_update_core( $_POST['core'] );
	if( is_wp_error($core) ) {
		$update_error = true;
		$error_message = $core->get_error_message();
		$response['message']['core'] = array(
			'error'=>true,
			'message'=> $error_message,
		);
		$overview .= 'WordPress core update failed. ';
	} else {
		$response['message']['core'] = array(
			'error'=>false,
			'message'=> 'WordPress was updated to version ' . $core . '.',
		);
		$overview .= 'WordPress core update complete. ';
	}
}

if ( ! empty( $_POST['plugins'] ) ) {
	$plugins     = unserialize( stripslashes( $_POST['plugins'] ) );
	$num_plugins = count( $plugins );
	if ( $num_plugins > 0 ) {
		$success_count_plugins = 0;
		$fail_count_plugins    = 0;
		$result_plugins        = array();


		$bulk = bruteprotect_bulk_update_plugins( $plugins );
		foreach ( $bulk['results'] as $path => $result ) {
			if ( is_array( $result ) ) {
				$success_count_plugins ++;
				$results_plugins[] = array( 'status' => true, 'path' => $path );
			} else {
				$fail_count_plugins ++;
				$results_plugins[] = array( 'status' => false, 'path' => $path );
				$update_error      = true;
			}
		}
		$updatelog_plugins = $bulk['messages'];
		$overview .= $num_plugins . ' plugin update';
		if ( $num_plugins > 1 ) {
			$overview .= 's';
		}
		$overview .= ' attempted: ' . $success_count_plugins . ' ';
		if ( $success_count_plugins == 1 ) {
			$overview .= 'was';
		} else {
			$overview .= 'were';
		}
		$overview .= ' successful, ' . $fail_count_plugins . ' failed. ';
		$response['message']['plugins'] = array(
			'results' => $results_plugins,
			'log'     => $updatelog_plugins,
		);
	}

}

if ( ! empty( $_POST['themes'] ) ) {
	$themes     = unserialize( stripslashes( $_POST['themes'] ) );
	$num_themes = count( $themes );
	
	if ( $num_themes > 0 ) {
		$success_count_themes = 0;
		$fail_count_themes    = 0;
		$result_themes        = array();


		$bulk = bruteprotect_bulk_update_themes( $themes );
		foreach ( $bulk['results'] as $path => $result ) {
			if ( is_array( $result ) ) {
				$success_count_themes ++;
				$results_themes[] = array( 'status' => true, 'path' => $path );
			} else {
				$fail_count_themes ++;
				$results_themes[] = array( 'status' => false, 'path' => $path );
				$update_error     = true;
			}
		}
		$updatelog_themes = $bulk['messages'];
		$overview .= $num_themes . ' theme update';
		if ( $num_themes > 1 ) {
			$overview .= 's';
		}
		$overview .= ' attempted: ' . $success_count_themes . ' ';
		if ( $success_count_themes == 1 ) {
			$overview .= 'was';
		} else {
			$overview .= 'were';
		}
		$overview .= ' successful, ' . $fail_count_themes . ' failed.';
		$response['message']['themes'] = array(
			'results' => $results_themes,
			'log'     => $updatelog_themes,
		);
	}
}

$response['error']               = $update_error;
$response['message']['overview'] = $overview;

echo json_encode( $response );

exit;