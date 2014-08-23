<?php
$host = $this->brute_get_local_host();
global $current_user;

$remote_security_options = array(
	'remote_monitoring' => __( 'Yes, BruteProtect may remotely monitor my site uptime and scan for malware' ),
	'remote_version' => __( 'Yes, BruteProtect may remotely track the versions of WordPress, plugins and themes I have installed' ),
	'remote_update' => __( 'Yes, BruteProtect may remotely update my site' ),
	'remote_login' => __( 'Yes, BruteProtect may provide a secure login gateway for my site' ),
);

if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'get_api_key' && is_email( $_POST['email_address'] ) ) {
	global $wp_version;

	$post_host = $this->get_bruteprotect_host() . '/get_key.php';
	$brute_ua = "WordPress/{$wp_version} | ";
	$brute_ua .= 'BruteProtect/' . constant( 'BRUTEPROTECT_VERSION' );

	$request['email'] = $_POST['email_address'];
	$request['site'] = $host;

	$args = array(
		'body'        => $request,
		'user-agent'  => $brute_ua,
		'httpversion' => '1.0',
		'timeout'     => 15
	);

	$response_json = wp_remote_post( $post_host, $args );

	?>
	<script type="text/javascript">
	<!--
	window.location = "admin.php?page=bruteprotect-config&get_key=success"
	//-->
	</script>
	<?php
	exit;
}


if ( isset( $_POST['brute_action'] ) && $_POST['brute_action'] == 'general_update' && current_user_can( 'manage_options' ) ) :
	if( isset( $_POST[ 'brute_dashboard_widget_hide' ] ) )
		update_site_option( 'brute_dashboard_widget_hide', $_POST[ 'brute_dashboard_widget_hide' ] );
	
	if( isset( $_POST[ 'brute_dashboard_widget_admin_only' ] ) )
		update_site_option( 'brute_dashboard_widget_admin_only', $_POST[ 'brute_dashboard_widget_admin_only' ] );
	
	if( isset( $_POST[ 'privacy_opt_in' ][ 'submitted' ] ) ) :
		unset( $_POST[ 'privacy_opt_in' ][ 'submitted' ] );
		update_site_option( 'brute_privacy_opt_in', $_POST[ 'privacy_opt_in' ] );
	endif;
	
endif;

$brute_dashboard_widget_hide = get_site_option('brute_dashboard_widget_hide');
$brute_dashboard_widget_admin_only = get_site_option('brute_dashboard_widget_admin_only');
$privacy_opt_in = get_site_option('brute_privacy_opt_in');


$key = get_site_option( 'bruteprotect_api_key' );
$invalid_key = false;
delete_site_option( 'bruteprotect_error' );

$response = $this->brute_call( 'check_key' );

if(isset($response['error'])) :
	if( $response['error'] == 'Invalid API Key' || $response['error'] == 'API Key Required' ) :
		$invalid_key = 'invalid';
	endif;
	if( $response['error'] == 'Host match error' ) :
		$invalid_key = 'host';
	endif;
endif;

if( !$this->check_bruteprotect_access() ) : //server cannot access API
	$invalid_key = 'server_access';
endif;

if( isset($response['ckval']) )
	update_site_option( 'bruteprotect_ckval', $response['ckval'] );
?>
<div class="wrap">
<h2 style="clear: both; margin-bottom: 15px;"><img src="<?php echo BRUTEPROTECT_PLUGIN_URL ?>images/BruteProtect-Logo-Text-Only-40.png" alt="BruteProtect" width="250" height="40" style="margin-bottom: -2px;"/> &nbsp; General Settings</h2>

<?php if ( false != $key && $invalid_key == 'invalid' ) : ?>
	<div class="error below-h2" id="message"><p><?php _e( '<strong>Invalid API Key!</strong> You have entered an invalid API key. Please copy and paste it from the email you have received, or request a new key.' ); ?></p></div>
<?php endif ?>

<?php if ( false != $key && $invalid_key == 'host' ) : ?>
	<div class="error below-h2" id="message"><p><?php _e( '<strong>Invalid API Key!</strong> You have entered an API key which is not valid for this server.  Every site must have its own API key.' ); ?></p></div>
<?php endif ?>

<?php if ( $invalid_key == 'server_access' ) : 
	include 'inc/api_access_error.php';
	return; 
endif; ?>

<?php if ( current_user_can('manage_options') ) : ?>
	<img src="<?php echo BRUTEPROTECT_PLUGIN_URL ?>images/wp-pro-ad.png" alt="BruteProtect Pro is Coming!" style="float: right;">

	<form action="" method="post" accept-charset="utf-8" id="bp-settings-form">

<h3 class="title"><?php _e( 'Remote Integration', 'bruteprotect' ) ?></h3>
<div style="background-color: #d8ecda; padding: 20px; border: 2px solid #336633; margin-bottom: 20px; width: 660px;" id="bruteprotect_permissions_description"><?php _e( 'With your permission, <strong>BruteProtect</strong> can remotely interact with your server to...', 'bruteprotect' ) ?>:
	<ul style="margin-left: 40px;list-style: initial;">
		<li style="margin-bottom: 1px"><?php _e( 'Notify you of downtime', 'bruteprotect' ) ?></li>
		<li style="margin-bottom: 1px"><?php _e( 'Notify you of the existance of malware on your site', 'bruteprotect' ) ?></li>
		<li style="margin-bottom: 1px"><?php _e( 'Notify you of out of date plugins which pose a security vulnerability', 'bruteprotect' ) ?></li>
		<li style="margin-bottom: 1px"><?php _e( 'Notify you of other potential security vulnerabilities', 'bruteprotect' ) ?></li>
		<li style="margin-bottom: 1px"><?php _e( 'Automatically update plugins you select', 'bruteprotect' ) ?></li>		
		<li style="margin-bottom: 1px"><?php _e( 'Allow you and your users to login through a secure gateway', 'bruteprotect' ) ?></li>		
	</ul>
	<em><?php _e( 'Some of these options may require a pro subscription which will be available in April 2014', 'bruteprotect' ) ?></em>
	<h3 style="margin-bottom: 0;"><a href="#" onclick="jQuery('.bp_privacy_opt_in_checkbox').attr('checked', 'checked'); jQuery('#bruteprotect_permissions_description').slideUp(); jQuery('#bp-settings-form').submit(); return false;">Click here</a> to allow these permissions.</h3>
</div>

<input type="hidden" name="privacy_opt_in[submitted]" value="1" id="privacy_opt_in[submitted]" />
<table class="form-table" style="clear: none; width: auto;">
<tbody>
	<tr valign="top">
	<th scope="row"><?php _e( 'Remote Permissions', 'bruteprotect' ) ?></th>
	<td>
<?php if(is_array($remote_security_options)) :  foreach($remote_security_options as $key => $desc) : ?>
	<label for="privacy_opt_in[<?php echo $key ?>]"><input name="privacy_opt_in[<?php echo $key ?>]" type="checkbox" value="1" class="bp_privacy_opt_in_checkbox" <?php if( isset( $privacy_opt_in[ $key ] ) ) echo 'checked="checked"'; ?>> <?php echo $desc ?></label><br />
<?php endforeach; endif; ?>
</td>
</tbody>
</table>

<input type="submit" value="<?php _e( 'Save Changes' ) ?>" class="button button-primary" style="margin-top: 10px;margin-bottom: 10px;" />
<br />
<h3 class="title"><?php _e( 'Widget Settings', 'bruteprotect' ) ?></h3>
<table class="form-table" style="clear: none; width: auto;">
<tbody>
<?php if ( is_multisite() ): ?>
	<tr valign="top">
	<th scope="row"><label for="default_category"><?php _e( 'Multisite Widget Display', 'bruteprotect' ) ?></label></th>
	<td>
		<select name="brute_dashboard_widget_hide" id="brute_dashboard_widget_hide">
			<option value="0"><?php _e( 'On network admin dashboard and on all blog dashboards', 'bruteprotect' ) ?></option>
			<option value="1" <?php if (isset($brute_dashboard_widget_hide) && $brute_dashboard_widget_hide == 1) { echo 'selected="selected"'; } ?>><?php _e( 'On network admin dashboard only', 'bruteprotect' ) ?></option>
		</select>
	</td>
	</tr>
<?php endif; ?>
	<tr valign="top">
	<th scope="row"><label for="default_category"><?php _e( 'Dashboard Widget Display', 'bruteprotect' ) ?></label></th>
	<td>
		<select name="brute_dashboard_widget_admin_only" id="brute_dashboard_widget_admin_only">
			<option value="0"><?php _e( 'All users who can see the dashboard', 'bruteprotect' ) ?></option>
			<option value="1" <?php if (isset($brute_dashboard_widget_admin_only) && $brute_dashboard_widget_admin_only == 1) { echo 'selected="selected"'; } ?>><?php _e( 'Admins Only', 'bruteprotect' ) ?></option>
		</select>
	</td>
	</tr>
</tbody></table>
<input type="hidden" name="brute_action" value="general_update" id="brute_action">
<input type="submit" value="<?php _e( 'Save Changes' ) ?>" class="button button-primary" style="margin-top: 10px;margin-bottom: 10px;" />
</form>

<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function() {
		var checked_boxes = jQuery('.bp_privacy_opt_in_checkbox:checked').length;
		if( checked_boxes == <?php echo count( $remote_security_options ) ?> ) {
			jQuery("#bruteprotect_permissions_description").hide();
		}
	});
	
</script>

<?php endif; ?>

<div style="clear: both;">
	&nbsp;
</div>

</div>