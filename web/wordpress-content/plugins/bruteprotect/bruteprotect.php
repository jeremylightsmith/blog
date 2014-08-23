<?php
/**
 *
 * @package BruteProtect
 */
/*
Plugin Name: BruteProtect
Plugin URI: http://bruteprotect.com/
Description: BruteProtect allows the millions of WordPress bloggers to work together to defeat Brute Force attacks. It keeps your site protected from brute force security attacks even while you sleep. To get started: 1) Click the "Activate" link to the left of this description, 2) Sign up for a BruteProtect API key, and 3) Go to your BruteProtect configuration page, and save your API key.

Version: 2.1
Author: Parka, LLC
Author URI: http://getparka.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/



define( 'BRUTEPROTECT_VERSION', '2.1' );

define( 'BRUTEPROTECT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

$use_https = get_site_transient( 'bruteprotect_use_https' );
define( 'MYBP_URL', 'https://my.bruteprotect.com/' );


if ( is_admin() ) :
	require_once dirname( __FILE__ ) . '/admin.php';
	require_once dirname( __FILE__ ) . '/admin/inc/shoutouts.php';
	new BruteProtect_Admin;
	new BruteProtect_Shoutouts;
endif;

require_once dirname( __FILE__ ) . '/clear_transients.php';
require_once dirname( __FILE__ ) . '/math-fallback.php';
require_once dirname( __FILE__ ) . '/admin/pro/functions.php';

/**
 * Collection of functions to make BruteProtect work
 *
 */
class BruteProtect {
	private $user_ip;
	private $use_https;
	private $api_key;
	private $local_host;
	private $api_endpoint;
	private $admin;

	/**
	 * Hooks into WordPress actions with self-contained callbacks
	 *
	 * @return VOID
	 */
	function __construct() {
		add_action( 'login_head', array( &$this, 'brute_check_use_math' ) );
		add_action( 'login_form', array( &$this, 'brute_maybe_use_secure_login' ) );
		add_action( 'init', array( &$this, 'brute_access_check_generator' ) );
		add_filter( 'authenticate', array( &$this, 'brute_check_preauth' ), 10, 3 );
		add_action( 'wp_login_failed', array( &$this, 'brute_log_failed_attempt' ) );
		if ( isset( $_GET['bruteprotect_pro'] ) ) {
			add_action( 'init', array( &$this, 'load_bruteprotect_pro' ) );
		}
		add_action( 'wp_footer', array( &$this, 'brute_pro_ping_checkval' ) );
		add_action( 'login_footer', array( &$this, 'brute_pro_ping_checkval' ) );

	}

	/**
	 * Bootstrap any pro functionality as needed
	 *
	 * @since 2.0
	 *
	 * @return void Makes an include choice based on requested bpp_action
	 */
	function load_bruteprotect_pro() {
		$bruteprotect_host = $this->get_bruteprotect_host();
		switch ( $_GET['bpp_action'] ) {
			case 'bp_verify_secure_login':
				include 'admin/pro/secure_login/bp_secure_login_process.php';
				break;
			case 'bp_secure_login':
				include 'admin/pro/secure_login/log_me_in.php';
				break;
			case 'bp_scan':
				include 'admin/pro/updater/scan.php';
				break;
			case 'bp_update':
				include 'admin/pro/updater/update.php';
				break;
			case 'unlink_site':
				include 'admin/pro/unlink_site.php';
				break;
			default:
				break;
		}
	}

	/**
	 * Add html comment to footer for BruteProtect Pro uptime monitor
	 *
	 * @since 2.0
	 *
	 * @return void
	 */
	function brute_pro_ping_checkval() {
		$privacy_opt_in = get_site_option( 'brute_privacy_opt_in' );
		if ( ! isset($privacy_opt_in['remote_monitoring']) )
			return;

        if(empty( $privacy_opt_in['remote_monitoring'] ))
            return;

		echo '<!-- 7ads6x98y -->';
	}

	/**
	 * Checks for loginability BEFORE authentication so that bots don't get to go around the log in form.
	 *
	 * If we are using our math fallback, authenticate via math-fallback.php
	 *
	 * @param string $username Passed via WordPress action. Not used.
	 *
	 * @return VOID
	 */
	function brute_check_preauth( $user = 'Not Used By BruteProtect', $username = 'Not Used By BruteProtect', $password = 'Not Used By BruteProtect' ) {
		$this->brute_check_loginability( true );
		$bum = get_site_transient( 'brute_use_math' );

		if ( $bum == 1 && isset( $_POST['log'] ) ) :

			BruteProtect_Math_Authenticate::brute_math_authenticate();

		endif;
	}

	/**
	 * Loads in the secure login form, and shows it for pro users
	 *
	 * @return VOID
	 */
	function brute_maybe_use_secure_login() {
		
		global $error;

		if ( empty($wp_error) )
			$wp_error = new WP_Error();
		
		// In case a plugin uses $error rather than the $wp_errors object
		if ( !empty( $error ) ) {
			$wp_error->add('error', $error);
			unset($error);
		}
		
		// turn off secure login if we're already on ssl or the user has opted for standard login or they had a failed login
		if( isset( $_GET['bp_sl_off'] ) || is_ssl() || $wp_error->get_error_code() ) {
			return;
		}
		
		$response = $this->brute_call( 'check_key' );

		if ( ! isset( $response['privacy_settings'] ) ) {
			// there is no response from the api, don't show secure login
			return;
		}
		
		// gets the user's most up-to-date account info
		bruteprotect_save_pro_info( $response );

		if ( ! bruteprotect_has_secure_login() )
			return;

        $site_linked = get_site_option( 'bruteprotect_user_linked', false );

        if( empty( $site_linked ))
            return;

		$bruteprotect_host = $this->get_bruteprotect_host();
		$local_host = $this->brute_get_local_host();
		$key        = get_site_option( 'bruteprotect_api_key' );
		$api_key    = md5( get_site_option( 'bruteprotect_api_key' ) );
		include 'admin/pro/secure_login/secure_login.php';
	}

	/**
	 * Retrives and sets the ip address the person logging in
	 *
	 * @return string
	 */
	function brute_get_ip() {
		if ( isset( $this->user_ip ) ) {
			return $this->user_ip;
		}

		$server_headers = array(
			'HTTP_CLIENT_IP',
			'HTTP_CF_CONNECTING_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		);

		if ( function_exists( 'filter_var' ) ) :
			foreach ( $server_headers as $key ) :
				if ( array_key_exists( $key, $_SERVER ) === true ) :
					foreach ( explode( ',', $_SERVER[ $key ] ) as $ip ) :
						$ip = trim( $ip ); // just to be safe

						if ( $ip == '127.0.0.1' || $ip == '::1' )
							return $ip;

						if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) :
							$this->user_ip = $ip;

							return $this->user_ip;
						endif;
					endforeach;
				endif;
			endforeach;
		else : // PHP filter extension isn't available
			foreach ( $server_headers as $key ) :
				if ( array_key_exists( $key, $_SERVER ) === true ) :
					foreach ( explode( ',', $_SERVER[ $key ] ) as $ip ) :
						$ip            = trim( $ip ); // just to be safe
						$this->user_ip = $ip;

						return $this->user_ip;
					endforeach;
				endif;
			endforeach;
		endif;
	}

	function get_privacy_key() {
		return substr( md5( NONCE_SALT ), 5, 10 );
	}

	function brute_access_check_generator() {
		if ( ! isset( $_GET['bpc'] ) )
			return;

		if ( $_GET['bpc'] != $this->get_privacy_key() )
			return;

		require_once dirname( __FILE__ ) . '/admin.php';

		$this->admin = new BruteProtect_Admin;

		$can_access = $this->admin->check_bruteprotect_access();

		if ( $can_access ) {
			wp_die( '<h2 style="clear: both; margin-bottom: 15px;"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/BruteProtect-Logo-Text-Only-40.png" alt="BruteProtect" width="250" height="40" style="margin-bottom: -2px;"/> &nbsp; All Clear</h2>Everything is working perfectly, thanks for getting it fixed!' );
		}

		$data = $this->admin->get_error_reporting_data();

		echo '<h2 style="clear: both; margin-bottom: 15px;"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/BruteProtect-Logo-Text-Only-40.png" alt="BruteProtect" width="250" height="40" style="margin-bottom: -2px;"/> &nbsp; Error Report</h2>';
		echo '<h3 style="margin-top: 20px;">Installation Basics:</h3>';
		echo '<strong>WordPress Version</strong>: ' . $data['wp_version'] . '<br />';
		echo '<strong>BruteProtect Version</strong>: ' . BRUTEPROTECT_VERSION . '<br />';
		echo '<strong>BruteProtect API Server</strong>: https://api.bruteprotect.com/<br />';
		echo '<strong>Current Domain</strong>: ' . $this->brute_get_local_host() . '<br />';
		echo '<strong>Current IP</strong>: ' . $this->brute_get_ip() . '<br />';
		echo '<strong>If you can visit this URL, BruteProtect is currently online</strong>: <a href="http://api.bruteprotect.com/up.php">http://api.bruteprotect.com/up.php</a><br />';

		echo '<h3 style="margin-top: 20px;">Connection Errors:</h3>';
		/////////////////////////////////////////////////////////////////////
		echo '<pre>';
		print_r( $data['error'] );
		echo '</pre>';
		/////////////////////////////////////////////////////////////////////

		wp_die();
	}

	function is_on_localhost() {
		$ip = $this->brute_get_ip();
		//return false;
		//Never block login from localhost
		if ( $ip == '127.0.0.1' || $ip == '::1' ) {
			return true;
		}

		return false;
	}

	/**
	 * Checks the status for a given IP. API results are cached as transients in the wp_options table
	 *
	 * @param bool $preauth Wether or not we are checking prior to authorization
	 *
	 * @return bool Either returns true, fires $this->brute_kill_login, or includes a math fallback
	 */
	function brute_check_loginability( $preauth = false ) {

		$ip = $this->brute_get_ip();

		//Never block login from localhost
		if ( $this->is_on_localhost() ) {
			return true;
		}

		$transient_name  = 'brute_loginable_' . str_replace( '.', '_', $ip );
		$transient_value = get_site_transient( $transient_name );

		//Never block login from whitelisted IPs
		$whitelist = get_site_option( 'brute_ip_whitelist' );
		$wl_items  = explode( PHP_EOL, $whitelist );
		$iplong    = ip2long( $ip );

		if ( is_array( $wl_items ) ) :  foreach ( $wl_items as $item ) :

			$item = trim( $item );

			if ( $ip == $item ) //exact match
				return true;

			if ( strpos( $item, '*' ) === false ) //no match, no wildcard
				continue;

			$ip_low  = ip2long( str_replace( '*', '0', $item ) );
			$ip_high = ip2long( str_replace( '*', '255', $item ) );

			if ( $iplong >= $ip_low && $iplong <= $ip_high ) //IP is within wildcard range
				return true;

		endforeach; endif;


		//Check out our transients
		if ( isset( $transient_value ) && $transient_value['status'] == 'ok' ) {
			return true;
		}

		if ( isset( $transient_value ) && $transient_value['status'] == 'blocked' ) {
			if ( $transient_value['expire'] < time() ) {
				//the block is expired but the transient didn't go away naturally, clear it out and allow login.
				delete_site_transient( $transient_name );

				return true;
			}
			//there is a current block-- prevent login
			$this->brute_kill_login();
		}

		//If we've reached this point, this means that the IP isn't cached.
		//Now we check with the bruteprotect.com servers to see if we should allow login
		$response = $this->brute_call( $action = 'check_ip' );

		if ( isset( $response['math'] ) && ! function_exists( 'brute_math_authenticate' ) ) {
			include_once 'math-fallback.php';

		}

		if ( $response['status'] == 'blocked' ) {
			$this->brute_kill_login( $response['blocked_attempts'] );
		}

		return true;
	}

	/**
	 * Checks for a WordPress transient to decide if we must use our math fall back
	 *
	 * @return VOID
	 */
	function brute_check_use_math() {
		$bp_use_math = get_site_transient( 'brute_use_math' );

		if ( $bp_use_math ) {
			include_once 'math-fallback.php';
			new BruteProtect_Math_Authenticate;
		}
	}

	function brute_kill_login() {
		do_action( 'brute_kill_login', $this->brute_get_ip() );
		$this->brute_log_blocked_attempt();
		wp_die( 'Your IP (' . $this->brute_get_ip() . ') has been flagged for potential security violations.  Please try again in a little while...' );
	}

	/**
	 * Called via WP action wp_login_failed to log failed attempt with the api
	 *
	 * Fires custom, plugable action brute_log_failed_attempt with
	 *
	 * @return void
	 */
	function brute_log_failed_attempt() {
		do_action( 'brute_log_failed_attempt', $this->brute_get_ip() );
		$this->brute_call( 'failed_attempt' );
	}

	function brute_get_local_host() {
		if ( isset( $this->local_host ) )
			return $this->local_host;

		$uri = 'http://' . strtolower( $_SERVER['HTTP_HOST'] );

		if ( is_multisite() ) {
			$uri = network_home_url();
		}

		$uridata = parse_url( $uri );

		$domain = $uridata['host'];

		//if we still don't have it, get the site_url
		if ( ! $domain ) {
			$uri     = get_site_url( 1 );
			$uridata = parse_url( $uri );
			$domain  = $uridata['host'];
		}

		$this->local_host = $domain;

		return $this->local_host;
	}

	/**
	 * Checks if server can use https, and returns api endpoint
	 *
	 * @return string URL of api with either http or https protocol
	 */
	function get_bruteprotect_host() {
		if ( isset( $this->api_endpoint ) )
			return $this->api_endpoint;

		//Some servers can't access https-- we'll check once a day to see if we can.
		$use_https = get_site_transient( 'bruteprotect_use_https' );

		if ( $use_https == 'yes' ) {
			$this->api_endpoint = 'http://api.bruteprotect.com/';
		} else {
			$this->api_endpoint = 'http://api.bruteprotect.com/';
		}

		if ( ! $use_https ) {
			$test      = wp_remote_get( $this->api_endpoint . 'https_check.php' );
			$use_https = 'no';
			if ( ! is_wp_error( $test ) && $test['body'] == 'ok' ) {
				$use_https = 'yes';
			}
			set_site_transient( 'bruteprotect_use_https', $use_https, 86400 );
		}

		return $this->api_endpoint;
	}

	function brute_get_blocked_attempts() {
		$blocked_count = get_site_option( 'bruteprotect_blocked_attempt_count' );
		if ( ! $blocked_count )
			$blocked_count = 0;

		return $blocked_count;
	}

	function brute_log_blocked_attempt( $api_count = 0 ) {
		$attempt_count = $this->brute_get_blocked_attempts();

		if ( ! $attempt_count )
			$attempt_count = 0;

		if ( $attempt_count < $api_count ) {
			$attempt_count = $api_count;
		}
		$attempt_count ++;

		update_site_option( 'bruteprotect_blocked_attempt_count', $attempt_count );

		return $attempt_count;
	}

	/**
	 * Finds out if this site has wordpress installed in the domain root, or within a subdirectory
	 *
	 * @return bool|string  Returns false if not a subdirectory. Returns the site url including subdirectory otherwise.
	 */
	function is_subdirectory() {
		if( is_multisite() )
			return false;
		
		$is_subdomain_install = false;
		$wp_site_url = get_site_url();
		$wp_site_url_parts = parse_url( $wp_site_url );
		if( isset( $wp_site_url_parts ) && is_array( $wp_site_url_parts ) && isset( $wp_site_url_parts[ 'path' ] ) && $wp_site_url_parts[ 'path' ] && $wp_site_url_parts[ 'path' ] != '/' ) {
			$is_subdomain_install = true;
		} else {
			return false;
		}
		return $wp_site_url;
	}
	/**
	 * Finds out if this site is using http or https
	 *
	 * @return string
	 */
	function brute_get_protocol() {
		$protocol = ( is_ssl() ) ? "https://" : "http://";
		return $protocol;
	}

	/**
	 * Calls over to the api using wp_remote_post
	 *
	 * @param string $action 'check_ip', 'check_key', or 'failed_attempt'
	 * @param array $request Any custom data to post to the api
	 * @param bool $sign Should we sign the request?
	 *
	 * @return array
	 */
	function brute_call( $action = 'check_ip', $request = array(), $sign = false ) {
		global $wp_version, $wpdb, $current_user;

		$api_key = get_site_option( 'bruteprotect_api_key' );

		$brute_ua = "WordPress/{$wp_version} | ";
		$brute_ua .= 'BruteProtect/' . constant( 'BRUTEPROTECT_VERSION' );

		$request['action']               = $action;
		$request['ip']                   = $this->brute_get_ip();
		$request['host']                 = $this->brute_get_local_host();
		$request['protocol']			 = $this->brute_get_protocol();
		$request['blocked_attempts']     = strval( $this->brute_get_blocked_attempts() );
		$request['privacy_settings']     = serialize( get_site_option( 'brute_privacy_opt_in' ) );
		$request['bruteprotect_version'] = constant( 'BRUTEPROTECT_VERSION' );
		$request['wordpress_version']    = $wp_version;
		$request['api_key']              = $api_key;
		$request['subdirectory']         =  strval( $this->is_subdirectory() );
		$request['multisite']            = "0";
		$request['wp_user_id']			 = strval( $current_user->ID );

		if ( is_multisite() ) {
			$request['multisite'] = get_blog_count();
			if ( ! $request['multisite'] ) {
				$request['multisite'] = $wpdb->get_var( "SELECT COUNT(blog_id) as c FROM $wpdb->blogs WHERE spam = '0' AND deleted = '0' and archived = '0'" );
			}
		}

		if ( $sign === true ) {
			$chkval               = get_site_option( 'bruteprotect_ckval' );
			$serialized           = serialize( $request );
			$request['signature'] = sha1( $serialized . $chkval );
			$request['wp_serialized'] = $serialized;
		}
		$log['request'] = $request;
		$args           = array(
			'body'        => $request,
			'user-agent'  => $brute_ua,
			'httpversion' => '1.0',
			'timeout'     => 15
		);

		$response_json   = wp_remote_post( $this->get_bruteprotect_host(), $args );
		$log['response'] = $response_json;
		//error_log( print_r($log,true),1, 'rocco@hotchkissconsulting.net');
		$ip             = $_SERVER['REMOTE_ADDR'];
		$transient_name = 'brute_loginable_' . str_replace( '.', '_', $ip );
		delete_site_transient( $transient_name );

		if ( is_array( $response_json ) )
			$response = json_decode( $response_json['body'], true );

		if ( isset( $response['status'] ) && ! isset( $response['error'] ) ) :
			$response['expire'] = time() + $response['seconds_remaining'];
			set_site_transient( $transient_name, $response, $response['seconds_remaining'] );
			delete_site_transient( 'brute_use_math' );
		else :

			//no response from the API host?  Let's use math!
			set_site_transient( 'brute_use_math', 1, 600 );
			$response['status'] = 'ok';
			$response['math']   = true;
		endif;

		if ( isset( $response['error'] ) ) :
			update_site_option( 'bruteprotect_error', $response['error'] );
		else :
			delete_site_option( 'bruteprotect_error' );
		endif;

		return $response;
	}
}

$bruteProtect = new BruteProtect;

if ( isset( $pagenow ) && $pagenow == 'wp-login.php' ) {
	$bruteProtect->brute_check_loginability();
} else {
	//	This is in case the wp-login.php pagenow variable fails
	add_action( 'login_head', array( &$bruteProtect, 'brute_check_loginability' ) );
}

register_activation_hook( __FILE__, 'bruteprotect_activate' );
register_deactivation_hook( __FILE__, 'bruteprotect_deactivate' );

/**
 * When someone deactivates bruteprotect, we need to do some cleanup
 *
 * Privacy settings are saved to a separate option, in case we need to re-activate
 *
 * @return void
 */
function bruteprotect_deactivate() {
	global $bruteProtect;
	$settings = get_site_option( 'brute_privacy_opt_in' );
	update_site_option( 'bruteprotect_saved_settings', $settings );
	update_site_option( 'bruteprotect_deactivated', '1');
	// call the api
	$action = 'deactivate_site';
	$additional_data = array();
	$sign = true;
	$bruteProtect->brute_call( $action, $additional_data, $sign );
}

/**
 * On activation we create site options and force redirection to our settings page
 *
 * Also, if there are saved privacy settings we send them over to the API
 * so that we can reapply the settings
 */
function bruteprotect_activate() {
	update_site_option( 'bruteprotect_version', BRUTEPROTECT_VERSION );
	
	$deactivated = get_site_option('bruteprotect_deactivated');
	
	if( !empty($deactivated) ) {
		$saved_settings = get_site_option( 'bruteprotect_saved_settings', array() );
		$bruteProtect = new BruteProtect;
		$action          = 'reactive_site';
		$additional_data = array('saved_settings'=>serialize($saved_settings));
		$sign            = true;
		delete_site_option('bruteprotect_saved_settings');
		delete_site_option('bruteprotect_deactivated');
		$bruteProtect->brute_call( $action, $additional_data, $sign );
	}
	
	
	add_site_option( 'bruteprotect_do_activation_redirect', true );
}


/////////////////////////////////////////////////////////////////////
// BP Widget!
/////////////////////////////////////////////////////////////////////

/**
 * BP Widget Class
 */
class bp_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'bp_widget',
			__( 'BruteProtect Widget', 'text_domain' ),
			array( 'description' => __( 'Let everyone know your site is protected', 'text_domain' ), )
		);
	}

	/**
	 * Back-end widget options
	 */
	public function form( $instance ) {
		$showsitestats = esc_attr( $instance['showsitestats'] );
		$choose_logo_color = esc_attr( $instance['choose_logo_color'] );

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( get_bloginfo( 'name' ) . ' is Protected by', 'text_domain' );
		}

		?>

		<!--Title-->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>

		<!--Show site stats
		<p>
			<input id="<?php echo $this->get_field_id( 'showsitestats' ); ?>"
			       name="<?php echo $this->get_field_name( 'showsitestats' ); ?>" type="checkbox"
			       value="1" <?php checked( '1', $showsitestats ); ?> />
			<label
				for="<?php echo $this->get_field_id( 'showsitestats' ); ?>"><?php _e( 'Show your stats?' ); ?></label>
				<?php
				$attacks_blocked = get_site_option( 'bruteprotect_blocked_attempt_count', '0' );
				$plural = ($attacks_blocked > 1 || $attacks_blocked === '0') ? 's' : '';
				?>
			<br/>(Currently <?php echo $attacks_blocked; ?> attack<?php echo $plural; ?> blocked)
		</p>-->
		
		<!--Choose Logo Color-->
		<p>
			<label for="<?php echo $this->get_field_id('choose_logo_color'); ?>"><?php _e('Choose Logo Color: '); ?></label>
			<select name="<?php echo $this->get_field_name('choose_logo_color'); ?>" id="<?php echo $this->get_field_id('choose_logo_color'); ?>" class="widefat">
			<?php
			$options = array( 'White - Default', 'White', 'White with orange lock', 'Black - Default', 'Black', 'Black with orange lock', 'Grey - Default', 'Grey', 'Grey with orange lock', 'Orange' );
			foreach ( $options as $option ) {
			echo '<option value="' . $option . '" id="' . $option . '"', $choose_logo_color == $option ? ' selected="selected"' : '', '>', $option, '</option>';
			}
			?>
			</select>
		</p>
		
	<?php
	}

	/**
	 * Save widget form values
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = array();
		$instance['title']         = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		//$instance['showsitestats'] = strip_tags( $new_instance['showsitestats'] );
		$instance['choose_logo_color'] = strip_tags( $new_instance['choose_logo_color'] );

		return $instance;
	}

	/**
	 * Front-end display of widget
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title      	   = apply_filters( 'widget_title', $instance['title'] );
		$choose_logo_color = apply_filters( 'choose_logo_color', $instance['choose_logo_color'] );
		
		/*Widget Logo Colors*/
		if ( $choose_logo_color == 'White - Default' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-white-default.png" width="80%"></a>';
				} else if ( $choose_logo_color == 'Black - Default' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-black-default.png" width="80%"></a>';
				} else if ( $choose_logo_color == 'Grey - Default' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-grey-default.png" width="80%"></a>';
				} else if ( $choose_logo_color == 'White with orange lock' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-white-orangelock.png" width="80%"></a>';
				} else if ( $choose_logo_color == 'White' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-white.png" width="80%"></a>';
				} else if ( $choose_logo_color == 'Black' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-black.png" width="80%"></a>';
				} else if ( $choose_logo_color == 'Black with orange lock' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-black-orangelock.png" width="80%"></a>';
				} else if ( $choose_logo_color == 'Grey' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-grey.png" width="80%"></a>';
				} else if ( $choose_logo_color == 'Grey with orange lock' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-grey-orangelock.png" width="80%"></a>';
				} else if ( $choose_logo_color == 'Orange' ) {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-orange.png" width="80%"></a>';
				} else {
				$widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="' . BRUTEPROTECT_PLUGIN_URL . 'images/bp-white-default.png" width="80%"></a>';
			}
			
		// $widgetlogo = '<a href="http://bruteprotect.com" target="_blank"><img src="../wp-content/plugins/bruteprotect/images/BruteProtect-Logo-Text-Only-40.png" width="60%"></a>';

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			/*set title*/
			echo $args['before_title'] . $title . $args['after_title'];
		echo '<div id="brutewidget">' . '<center>' . $widgetlogo . '</center>';

		/*show site stats
		if ( $instance['showsitestats'] AND $instance['showsitestats'] == '1' && get_site_option( 'bruteprotect_blocked_attempt_count' ) > 0 ) {
			echo '<center>' . 'Protected from ' . get_site_option( 'bruteprotect_blocked_attempt_count' ) . ' attacks!' . '</center>' . '</div>';
		} elseif( $instance['showsitestats'] AND $instance['showsitestats'] == '1' && get_site_option( 'bruteprotect_blocked_attempt_count' ) == '1' ) {
			echo '<center>' . 'Protected from ' . get_site_option( 'bruteprotect_blocked_attempt_count' ) . ' attack!' . '</center>' . '</div>';
		} else {
			echo '</div>';
		}*/

		echo $args['after_widget'];
	}

} // class bp_widget

// register bp_widget widget
function register_bp_widget() {
	register_widget( 'bp_widget' );
}

add_action( 'widgets_init', 'register_bp_widget' );