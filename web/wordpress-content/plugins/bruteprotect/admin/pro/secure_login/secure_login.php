<?php
/**
 * Adds Secure Login button to the wp-login.php page
 * 
 * Added via WordPress action login_footer. Opens a new window to the BruteProtect API's
 * secure servers.
 *
 * @package BruteProtect
 * @subpackage SecureLogin
 */

$login_url = $local_host . $_SERVER[ 'REQUEST_URI' ];
$login_url_bits = explode( '?', $login_url );
$login_url = $login_url_bits[ 0 ];
$login_url = str_replace( '/wp-login.php', '', $login_url );
$redirect = '';
if(isset($_GET['redirect_to'])) {
	$redirect = $_GET['redirect_to'];
}

$wp_login_url = wp_login_url() . '?bp_sl_off=true';
if( !empty( $_GET['redirect_to'])) {
	$wp_login_url .= '&redirect_to=' . urlencode($_GET['redirect_to']);
}
if( !empty( $_GET['reauth'])) {
	$wp_login_url .= '&reauth=' . $_GET['reauth'];
}

?>
<div id="newbutton">
<a class="btn bfm bfme icon-arrow-right" href="/" onclick="PopupCenter('<?php echo $bruteprotect_host; ?>ui/login/to/<?php echo rawurlencode( $login_url ); ?>/<?php echo $api_key; ?>/<?php echo base64_encode($redirect); ?>', 'Secure Login', 400, 300); return false;">
	<span class="btext">
		<?php echo apply_filters( 'brute_secure_login_button', 'Log In Securely with BruteProtect' ); ?>
	</span>
</a>
<a class="btn bwp" href="<?php echo $wp_login_url; ?>">
	<span class="btext">
		<?php echo apply_filters( 'brute_default_button', 'Log in with WordPress' ); ?>
	</span>
</a>
</div>
<style type="text/css">

/* secure login btn */

#newbutton * {
	-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
}


.login form {
	padding: 20px;
}

#login .btext {
	padding: 17px 10px 15px 50px;
	display: inline-block;
	line-height: 100%;
}

#login .bwp .btext {
	padding: 17px 10px 15px 10px;
	text-align: center;
}

#login  .blogo {
	padding: 7px 5px 5px 5px;
	border-right: 1px #d65210 solid;
	display: inline-block;
	background-color: #f29e0d; 
}


.btn {
	border: none;
	font-family: inherit;
	font-size: inherit;
	color: #fff;
	background: none;
	cursor: pointer;
	padding: 0;
	display: inline-block;
	font-weight: 700;
	outline: none;
	position: relative;
	width: 100%;
	-webkit-transition: all 0.3s;
	-moz-transition: all 0.3s;
	transition: all 0.3s;
}

.btn:after {
	content: '';
	position: absolute;
	z-index: -1;
	-webkit-transition: all 0.3s;
	-moz-transition: all 0.3s;
	transition: all 0.3s;
}

.icon-arrow-right:before {
	content: "";
}

.bwp {
	background: #1e8cbe;
	color: #fff;
	text-align: center;
}

.bwp:hover {
	background: #117eaf;
	color: #fff;
}

.bfm {
	background: #f29e0d;
	color: #fff;
	margin: 0 0 10px 0;
}

.bfm:hover {
	background: #15b100;
	color: #fff;
}

.bfm:hover .btext {
	padding-left: 50px;
}

.bfm:active {
	background: #f58500;
	top: 2px;
}

.bfm:before {
	position: absolute;
	height: 100%;
	left: 0;
	top: 0;
	line-height: 3;
	font-size: 140%;
	width: 60px;
}

.bfme {
	overflow: hidden;
}

.bfme:before {
	left: auto;
	right: 10px;
	z-index: 2;
}

.bfme:after {
	width: 15%;
	height: 100%;
	background: #f29e0d url('../wp-content/plugins/bruteprotect/images/single-lock.png') 50% 50% no-repeat;
	z-index: 1;
	left: 0;
	top: 0;
	margin: 0;
}

.bfme:hover:after {
	width: 100%;
	background: #129900 url('../wp-content/plugins/bruteprotect/images/single-lock.png') 50% 50% no-repeat;
}


/* clef ovverides */

#loginform h2 {  /* overrides clef h2 styling */
	margin-top: 20px !important;
	font-style: italic;
	color: #aaa !important;
}

.clef-login-form .clef-button-container {
	margin-bottom: 0;
}


/* end secure login btn */



	 label[for=user_login], label[for=user_pass], .submit, .forgetmenot {
		 display: none;
	 }
 	.jetpack-sso-wrap {
 		margin: 10px auto!important;
 		display: block;
 		text-align: center!important;
 		float: none!important;
 	}
</style>
<script type="text/javascript" charset="utf-8">
	function PopupCenter(url, title, w, h) {
	    // Fixes dual-screen position                         Most browsers      Firefox
	    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
	    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

	    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
	    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

	    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
	    var top = ((height / 2) - (h / 2)) + dualScreenTop;
	    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

	    // Puts focus on the newWindow
	    if (window.focus) {
	        newWindow.focus();
	    }
	}
</script>