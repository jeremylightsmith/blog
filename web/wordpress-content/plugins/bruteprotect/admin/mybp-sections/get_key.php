<div class="halfbox left alignleft stepuno">

<?php if ( 'invalid' == $invalid_key ) : ?>
		<h3 class="red"><?php _e( 'Step 1: Sorry, your API Key is invalid' ); ?></h3>
<?php else : ?>
		<h3 class="orange"><?php _e( 'Step 1: Get your free API Key' ); ?></h3>
<?php endif; ?>

		<p><em><?php _e( 'BruteProtect Shield is now and will always be 100% free for unlimited sites.' ); ?>
				<br><?php _e( 'Every website requires a unique API Key.' ); ?></em></p>

		<div class="getapikey">
			<form action="" method="post">
				<?php if ( isset( $_GET['get_key'] ) && $_GET['get_key'] == 'fail' ) : ?>
					<strong
						style="font-size: 18px;"><?php _e( 'There was an error generating your API key.  Please try again later.  Sorry!' ); ?></strong>

				<?php else : ?>

					<label for="email_address"><strong><?php _e( 'Email Address' ); ?>:</strong> 
					<input type="text" name="email_address" value="<?php echo $current_user->user_email ?>" id="brute_get_api_key"/>

</label>
					
					<a href="#" id="gotapikey" class="alignleft"><em>I already have a unique API Key for this website</em></a>

					<input type="submit" value="Get an API Key" class="button orange alignright"/>
					<input type="hidden" name="brute_action" value="get_api_key"/>


				<?php endif; ?>
			</form>
		</div>
		<div class="gotapikey">
			<form action="" method="post">
				<label for="brute_api_key"><strong><?php _e( 'Enter your key: ' ); ?></strong>:
				<input type="text" name="brute_api_key" value="<?php echo get_site_option( 'bruteprotect_api_key' ) ?>" id="brute_api_key"/>
				</label>
				<input type="hidden" name="brute_action" value="update_key"/>
				<a href="#" id="getapikey" class="button blue">Generate a new API Key</a>
				<input type="submit" value="Save API Key" class="button orange alignright"
				       style="margin-top: 10px;margin-bottom: 10px;"/>
			</form>
		</div>
</div><!-- end setupapi -->		