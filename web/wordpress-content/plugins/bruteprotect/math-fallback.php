<?php
/**
 * If the API is unavailable, we fall back and block spam by math!
 *
 * @package BruteProtect
 * @subpackage MathFallback
 */
if ( ! class_exists( 'BruteProtect_Math_Authenticate' ) ) {

	/**
	 *
	 */
	class BruteProtect_Math_Authenticate extends BruteProtect {

		/**
		 * hooks into Worpress action login_form with our callback
		 */
		function __construct() {
			add_action( 'login_form', array( &$this, 'brute_math_form' ) );
		}

		/**
		 * Verifies that a user answered the math problem correctly while loggin in.
		 *
		 * @return bool Returns true if the math is correct
		 * @throws BP100 if insuffient $_POST variables are present.
		 * @throws Error message if the math is wrong
		 */
		static function brute_math_authenticate() {
			$salt        = get_site_option( 'bruteprotect_api_key' ) . get_site_option( 'siteurl' );
			$ans         = (int) $_POST['brute_num'];
			$salted_ans  = sha1( $salt . $ans );
			$correct_ans = $_POST['brute_ck'];

			if ( ! $correct_ans ) {
				wp_die( __( '<strong>Error BP100: This site is not properly configured.</strong> Please ask this site\'s web developer to review <a href="http://bruteprotect.com/faqs/error-bp100/">for information on how to resolve this issue</a>.' ) );
			} elseif ( $salted_ans != $correct_ans ) {
				wp_die( __( '<strong>You failed to correctly answer the math problem.</strong>  This is used to combat spam when the BruteProtect API is unavailable.  Please use your browser\'s back button to return to the login form, press the "refresh" button to generate a new math problem, and try to log in again.' ) );
			} else {
				return true;
			}
		}

		/**
		 * Requires a user to solve a simple equation. Added to any WordPress login form.
		 *
		 * @return VOID outputs html
		 */
		static function brute_math_form() {
			$salt = get_site_option( 'bruteprotect_api_key' ) . get_site_option( 'siteurl' );
			$num1 = rand( 0, 10 );
			$num2 = rand( 0, 10 );
			$sum  = $num1 + $num2;
			$ans  = sha1( $salt . $sum );
			?>
			<div style="margin: 5px 0 20px;">
				<strong>Prove your humanity: </strong>
				<?php echo $num1 ?> &nbsp; + &nbsp; <?php echo $num2 ?> &nbsp; = &nbsp; <input type="input"
				                                                                               name="brute_num" value=""
				                                                                               size="2"/>
				<input type="hidden" name="brute_ck" value="<?php echo $ans; ?>" id="brute_ck"/>
			</div>
		<?php
		}

	}
}