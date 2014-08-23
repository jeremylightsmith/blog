<?php
/**
 * Used to present the Clef install page and install the Clef plugin.
 *
 * Initialized and used in the BruteProtect admin.
 *
 * @package BruteProtect
 * @subpackage Clef
 */
if ( ! class_exists( 'BruteProtect_Clef' ) ) {
	class BruteProtect_Clef extends BruteProtect {

		function __construct() {
			$this->slug = 'wpclef';
		}

		function clef_active() {
			return is_plugin_active( 'wpclef/wpclef.php' );
		}

		function display_settings() {
			$install_url = wp_nonce_url(
				add_query_arg(
					array(
						'action' => 'install-plugin',
						'plugin' => $this->slug,
					),
					admin_url( 'update.php' )
				),
				'install-plugin_' . $this->slug
			);

			include 'clef_settings.php';
		}
	}
}
