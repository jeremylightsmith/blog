<?php
echo '<div class="halfbox left alignleft stepuno">';
echo '<h3 class="green">';
_e( 'Step 1: BruteProtect is actively protecting your site' );
echo '</h3>	
			
<p><em>';
_e( 'BruteProtect Shield is now and will always be 100% free for unlimited sites.' );
echo '<br>';
_e( 'Every website requires a unique API Key.' );
echo '</em></p>

<form action="" method="post">
			<strong>';
_e( 'Enter your key: ' );
echo '</strong><br />
			<input type="text" name="brute_api_key" value="' . get_site_option( 'bruteprotect_api_key' ) . '" id="brute_api_key" />
			<input type="hidden" name="brute_action" value="update_key" />
			<input type="submit" value="Update API Key" class="button green alignright"/>
</form></div>';