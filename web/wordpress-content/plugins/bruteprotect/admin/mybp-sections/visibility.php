<?php $admins = get_site_option( 'brute_dashboard_widget_admin_only' ); ?>
<div class="halfbox right">
	<h3 class="blue">Who should see the BruteProtect Dashboard Widget?</h3>

	<form action="" method="post" accept-charset="utf-8" id="bp-settings-form">
		<select name="brute_dashboard_widget_admin_only" id="brute_dashboard_widget_admin_only">
			<option value="0" <?php if($admins=='0') echo 'selected="selected"'; ?>>All users who can see the dashboard</option>
			<option value="1" <?php if($admins=='1') echo 'selected="selected"'; ?>>Admins Only</option>
		</select>
		<input type="hidden" name="brute_action" value="general_update" id="brute_action">
		<input type="submit" value="Save Changes" class="button button-primary blue alignright">
	</form>
	<div class="clear"></div>
</div>