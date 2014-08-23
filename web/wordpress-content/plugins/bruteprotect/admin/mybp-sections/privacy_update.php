<?php 

function bruteprotect_privacyupdate_html( $remote_security_options, $privacy_opt_in, $issaved = false ) {
	echo '<div class="halfbox left alignright stepdos">';
	if ($issaved) :
		echo '<h3 class="green">';
		_e( 'Step 2: Your remote settings are saved' );
		echo '</h3>';
	else :
		echo '<h3 class="orange">';
		_e( 'Step 2: With your permission BruteProtect can' );
		echo '</h3>';
	endif;
	
	echo '<form action="" method="post" accept-charset="utf-8" id="bp-settings-form">
			<input type="hidden" name="privacy_opt_in[submitted]" value="1" id="privacy_opt_in[submitted]" />';

	if ( is_array( $remote_security_options ) ) :  foreach ( $remote_security_options as $key => $desc ) :
		echo '<label for="privacy_opt_in[' . $key . ']" class="setting"><input name="privacy_opt_in[' . $key . ']" type="checkbox" value="1" class="bp_privacy_opt_in_checkbox"';
		if ( isset( $privacy_opt_in[ $key ] ) ) {
			echo 'checked="checked"';
		}
		echo '>' . $desc . '</label>';
	endforeach; endif;


	echo '<input type="submit" value="';
	
	if( $issaved )
		echo 'Update Settings';
	else
		echo 'Save Settings';
	
	echo '" class="button button-primary alignright ';
	if( $issaved )
		echo 'green';
	else
		echo 'orange';
	echo '" /></form></div>';
}