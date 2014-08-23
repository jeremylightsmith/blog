<?php
if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'unlink_owner_from_site' ) {
	global  $brute_success;
    $this->unlink_site();
    $brute_success = 'This site was successfully disconnected from My.BruteProtect.com';
}

if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'get_api_key' && is_email( $_POST['email_address'] ) ) {
	global $wp_version, $brute_error, $brute_success;
    $host = $this->brute_get_local_host();
	$post_host = $this->get_bruteprotect_host() . 'endpoints/get_key';
	$brute_ua  = "WordPress/{$wp_version} | ";
	$brute_ua .= 'BruteProtect/' . constant( 'BRUTEPROTECT_VERSION' );

	$request['email'] = $_POST['email_address'];
	$request['site']  = $host;
	$request['directory_url'] = $this->is_subdirectory();
	$request['url_protocol'] = $this->brute_get_protocol();

	$args = array(
		'body'        => $request,
		'user-agent'  => $brute_ua,
		'httpversion' => '1.0',
		'timeout'     => 15
	);

	$response_json = wp_remote_post( $post_host, $args );
	
	if( is_wp_error( $response_json )) {
		$brute_error = 'There was an error generating your API key.  Please try again later.  Sorry!';
	}
	

	if ( isset($response_json['response']['code']) && $response_json['response']['code'] == 200 ) {
		$key = $response_json['body'];
		update_site_option( 'bruteprotect_api_key', $key );
		$brute_success = 'Your BruteProtect API Key was successfully created.';
	} else {
        $brute_error = 'There was an error generating your API key.  Please try again later.  Sorry!';
	}
}

if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'update_key' ) {
	update_site_option( 'bruteprotect_api_key', $_POST['brute_api_key'] );
    $brute_success = 'API key updated.';
}

if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'remove_key' ) {
    global $brute_success, $current_user;
    $delete_all = true;
    $this->unlink_site($delete_all);
    $brute_success = 'API key removed.';
}

if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'link_owner_to_site' ) {
    global $is_linking, $linking_error, $linking_success, $current_user;

    $is_linking = true;
	$action = 'link_owner_to_site';
	$core_update = brute_protect_get_core_update();
	$plugin_updates = bruteprotect_get_out_of_date_plugins();
	$theme_updates = bruteprotect_get_out_of_date_themes();
	$additional_data = array(
		'username'  => $_POST['username'],
		'password'  => $_POST['password'],
		'remote_id' => strval( $current_user->ID ),
		'core_update' => $core_update,
		'plugin_updates' => strval(count( $plugin_updates )),
		'theme_updates' => strval(count( $theme_updates )),
	);
	$sign = true;

	$response = $this->brute_call( $action, $additional_data, $sign );
	if ( isset($response['link_key']) ) {
		update_user_meta( $current_user->ID, 'bruteprotect_user_linked', $response['link_key'] );
		update_site_option( 'bruteprotect_user_linked', '1' );
        $linking_success = $response['message'];
	} else {
        $linking_error = $response['message'];
    }
}

// save privacy settings
if ( isset( $_POST['privacy_opt_in']['submitted'] ) ) {
    global $privacy_success;
    unset( $_POST['privacy_opt_in']['submitted'] );
	update_site_option( 'brute_privacy_opt_in', $_POST['privacy_opt_in'] );
	$action          = 'update_settings';
	$additional_data = array();
	$sign            = true;
	$this->brute_call( $action, $additiional_data, $sign );
    update_site_option('brute_privacy_options_saved', true );

    $privacy_success = 'Your privacy settings were saved.';
}

// process an general_update action which updates privacy settings. uses Bruteprotect::call()
if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'general_update' && current_user_can( 'manage_options' ) ) {
    global $wordpress_success;
	// save dashboard widget settings
	if ( isset( $_POST['brute_dashboard_widget_hide'] ) ) {
		update_site_option( 'brute_dashboard_widget_hide', $_POST['brute_dashboard_widget_hide'] );
	}
	// save dashboard widget settings
	if ( isset( $_POST['brute_dashboard_widget_admin_only'] ) ) {
		update_site_option( 'brute_dashboard_widget_admin_only', $_POST['brute_dashboard_widget_admin_only'] );
	}
    $wordpress_success = 'Your WordPress settings were saved.';

}

if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'register_and_link' ) {
    global $register_error, $linking_success, $current_user;

    $action = 'register_and_link';
    $core_update = brute_protect_get_core_update();
    $plugin_updates = bruteprotect_get_out_of_date_plugins();
    $theme_updates = bruteprotect_get_out_of_date_themes();
    $additional_data = array(
        'first_name' => $_POST['first_name'],
        'last_name'=> $_POST['last_name'],
        'email'=> $_POST['email'],
        'company'=> $_POST['company'],
        'password'=> $_POST['password'],
        'remote_id' => strval( $current_user->ID ),
        'core_update' => $core_update,
        'plugin_updates' => strval(count( $plugin_updates )),
        'theme_updates' => strval(count( $theme_updates )),
    );
    $sign = true;

    $response = $this->brute_call( $action, $additional_data, $sign );
    if ( isset($response['link_key']) ) {
        update_user_meta( $current_user->ID, 'bruteprotect_user_linked', $response['link_key'] );
        update_site_option( 'bruteprotect_user_linked', '1' );
        $linking_success = $response['message'];
    } else {
        $register_error = $response['message'];
    }
}

if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'update_brute_whitelist' ) {
    global $whitelist_success;
	//check the whitelist to make sure that it's clean
	$whitelist = $_POST['brute_ip_whitelist'];

	$wl_items = explode( PHP_EOL, $whitelist );

	if ( is_array( $wl_items ) ) :  foreach ( $wl_items as $key => $item ) :
		$item   = trim( $item );
		$ckitem = str_replace( '*', '1', $item );
		$ckval  = ip2long( $ckitem );
		if ( ! $ckval ) {
			unset( $wl_items[ $key ] );
			continue;
		}
		$exploded_item = explode( '.', $item );
		if ( $exploded_item[0] == '*' ) {
			unset( $wl_items[ $key ] );
		}

		if ( $exploded_item[1] == '*' && ! ( $exploded_item[2] == '*' && $exploded_item[3] == '*' ) ) {
			unset( $wl_items[ $key ] );
		}

		if ( $exploded_item[2] == '*' && $exploded_item[3] != '*' ) {
			unset( $wl_items[ $key ] );
		}

	endforeach; endif;

	$whitelist = implode( PHP_EOL, $wl_items );
    $whitelist_success = 'Your white list was updated.';

	update_site_option( 'brute_ip_whitelist', $whitelist );
}
