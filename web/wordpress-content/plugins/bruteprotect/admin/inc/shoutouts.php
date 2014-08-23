<?php
if ( ! class_exists( 'BruteProtect_Shoutouts' ) ) {
	class BruteProtect_Shoutouts extends BruteProtect {

		function __construct() {
			if ( isset( $_GET['dismiss_bruteprotect_shoutout'] ) ) {
				$this->process_dismissed_shoutout( $_GET['dismiss_bruteprotect_shoutout'] );
			}

			//only show our shoutouts on the BP pages
			if ( ! isset( $_GET['page'] ) || ! strpos( $_GET['page'], 'bruteprotect' ) ) {
				return;
			}

			add_action( 'admin_notices', array( &$this, 'generate_notice' ), 90 );
		}

		function get_shoutouts() {
			$o['auditing'] = '<a href="https://bruteprotect.com/security-audits/" class="wp-core-ui button-primary" style="float: right; margin: 25px 0 0 20px;" target="_blank">Learn More and Sign Up</a><strong>Need help securing your site?</strong> The security gurus at BruteProtect can perform a security review of your site, repair any vulnerabilities, make sure you\'re following best practices, and save you hours of frustration, starting at just $99<br /><br /><strong>Did you know?</strong> The creators of BruteProtect have spoken about WordPress security to thousands of users and developers around the world.';

			return $o;
		}

		function process_dismissed_shoutout( $shoutout_slug ) {
			$dismissed_shoutouts = get_site_option( 'bruteprotect_dismissed_shoutouts' );
			if ( isset( $dismissed_shoutouts[ $shoutout_slug ] ) ) {
				return;
			}

			$dismissed_shoutouts[ $shoutout_slug ] = time();
			update_site_option( 'bruteprotect_dismissed_shoutouts', $dismissed_shoutouts );
		}

		function generate_notice() {
			global $bruteprotect_showing_warning;

			//Don't show a shoutout if we're showing a warning
			if ( $bruteprotect_showing_warning || isset( $_GET['dismiss_bruteprotect_shoutout'] ) ) {
				return;
			}

			$shoutouts = $this->get_shoutouts();

			// Check to see if we have shown a shoutout in the last week.  We will not show any shoutouts for 7 days after having a shoutout dismissed, because we don't want to bug people...
			$dismissed_shoutouts = get_site_option( 'bruteprotect_dismissed_shoutouts' );
			$week_ago            = time() - WEEK_IN_SECONDS;
			if ( is_array( $dismissed_shoutouts ) ) :  foreach ( $dismissed_shoutouts as $shoutout_shortname => $dismissed_time ) :
				unset( $shoutouts[ $shoutout_shortname ] );
				if ( $dismissed_time > $week_ago )
					return;
			endforeach; endif;

			// Check to see if we have any shoutouts which haven't been dismissed yet...
			if ( ! $shoutouts )
				return;

			if ( is_array( $shoutouts ) ) :  foreach ( $shoutouts as $slug => $so ) :
				?>
				<div class="updated after-h2 bruteprotect-shoutout"
				     style="padding: 20px; border-color: #ff6600; background-color: #fff; position: relative;">
					<img src="<?php echo BRUTEPROTECT_PLUGIN_URL ?>/images/BruteProtect-lock.png"
					     style="float: left; margin-right: 20px;"/>
					<?php echo $so; ?>
					<div style="clear: both;"></div>
					<a href="<?php echo add_query_arg( 'dismiss_bruteprotect_shoutout', $slug ); ?>" class="dismiss"
					   style="position: absolute;top: 5px;right: 10px;font-weight: bold;color: #AAA;font-size: 20px;"
					   onclick="jQuery('.bruteprotect-shoutout').slideUp();">&times;</a>
				</div>
				<?php
				return;
			endforeach; endif;
		}
	}
}


