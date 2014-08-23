<div class="clear"></div>
<div class="halfbox left alignleft whitelist">
	<h3 class="blue"><?php _e( 'IP Whitelist: Always allow access from the following IP\'s' ); ?></h3>

	<form action="" method="post">

		<textarea name="brute_ip_whitelist" rows="15" cols="40"
		          class="alignleft"><?php echo $brute_ip_whitelist ?></textarea>
		<small class="alignright"><?php _e( 'Your current IP address is: ' ); ?><?php echo $this->brute_get_ip(); ?>
			<br/><?php _e( 'Enter one IPv4 per line, * for wildcard octet' ); ?><br/>(ie: <code>192.168.0.1</code>
			and <code>192.168.*.*</code> are valid, <code>192.168.*</code> and <code>192.168.*.1</code> are invalid)
		</small>
		<input type="hidden" name="brute_action" value="update_brute_whitelist"/><br/>
		<input type="submit" value="Save IP Whitelist" class="button blue alignright"/>
	</form>
</div>
