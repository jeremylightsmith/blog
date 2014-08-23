<?php
/**
 * Displays the 3 step configuration page for BruteProtect and connection to my.bruteprotect.com
 *
 * @package BruteProtect
 *
 * @since 1.0
 */

global $brute_success, $brute_error, $privacy_opt_in,$remote_security_options, $local_host;

$local_host = str_replace( 'http://', '', home_url() );
$local_host = str_replace( 'https://', '', $local_host );

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    // load processing scripts if necessary
	require 'mybp-post_processing.php';
}

// grab default variables
$key = get_site_option( 'bruteprotect_api_key' );
$invalid_key = false;
$remote_security_options = array(
    'remote_monitoring' => __( 'Remotely monitor your site uptime and scan for malware; Remotely track the versions of WordPress, plugins, & themes you have installed; Remotely update your site' ),
    'remote_login'      => __( 'Provide a secure login gateway for your site' ),
);

// reset any errors
delete_site_option( 'bruteprotect_error' );
// check the api
$response = $this->brute_call( 'check_key' );

// determine if the api key is valid, show error message if needed
if ( isset( $response['error'] ) ) :
	if ( $response['error'] == 'Invalid API Key' ) :
		$invalid_key = true;
        $brute_error = 'Sorry, your API Key is invalid';
	endif;
	if ( $response['error'] == 'Host match error' ) :
		$invalid_key = true;
        // their api key is used on an other site. no error message is required. just prompt them to get a new key
	endif;
	if ( $response['error'] == 'API Key Required' ) :
		$invalid_key = true;
        // they don't have a key yet. no error message is required.
	endif;
endif;

// save info from api
bruteprotect_save_pro_info( $response );
$privacy_opt_in = get_site_option( 'brute_privacy_opt_in' );
// load in override styles
?>

<!-- MOVE THIS INTO SCSS -->
    <style>


    /* override wp ui buttons */

    body.wp-core-ui {
        background: transparent;
    }

    .wp-core-ui .wp-submenu-wrap {
        margin-left: 0;
    }

    .wp-core-ui .button {
        display: inline-block;
        text-decoration: none;
        font-size: 1rem;
        line-height: 125%;
        height: auto;
        margin: 0;
        padding: 15px 20px;
        border: none;
        -webkit-appearance: none;
        -webkit-border-radius: 0;
        border-radius: 0;
        background: #f26722;
        color: #fff;
        box-shadow: none;

    }

    .wp-core-ui .button:hover {
        background-color: #db5c1c;
        color: #fff;
    }

        #wpwrap { /*position: fixed !important;*/ }
       div.error { background-color: #d80000 !important; padding: 0.61875rem !important; border-left: none !important; }

        #bruteprotect-warning {
        margin-left: 0;
        margin-top: 0;
        }

        .row.wpauxlinks, #bruteapi.row.new_ui, #bruteprotect-warning {
            margin-left: 0;
            margin-right: 15px;
            max-width: 98%;
        }


        #disconnect_bp_button {
            color: #999;
        }

        #disconnect_bp_button:hover {
            color: #bbb !important;
        }


        .new_ui .already:hover {
            text-decoration: underline;
        }


        .new_ui .padrightonly {
            padding-left: 0;
        }


        .new_ui #starttrial {
            width: 100%;
            margin-top: 0;
        }



        .wp-core-ui .new_ui input[type="submit"].btn-go-pro {
            text-transform: uppercase;
            font-style: normal;
            background: #f26722;
            color: #fff;
            border: 0;
        }

        .wp-core-ui .new_ui input[type="submit"].btn-go-pro:hover {
            background-color: #db5c1c !important;
        }

        .new_ui .bpwpoptions select {
            padding-left: 15px;
        }

        .new_ui .dashholder .step.a3 {
            padding-top: 0;
        }

        .new_ui .dashholder .step input.strength0 { border: 1px solid #f00!important; }
        .new_ui .dashholder .step input.strength1 { border: 1px solid #f26722!important; }
        .new_ui .dashholder .step input.strength2 { border: 1px solid #ff00ff!important; }
        .new_ui .dashholder .step input.strength3 { border: 1px solid #0099ff!important; }
        .new_ui .dashholder .step input.strength4 { border: 1px solid #0f0!important; }



/* ===========

BP UI - tab / accordion behavior based on WP menu width (full and folded)

============== */


/* start behavior based on full width WP menu */

/* ===========  For screens smaller than 1215px */
@media only screen and (max-width : 1215px) {

     body .new_ui .r-tabs .r-tabs-nav .r-tabs-tab .r-tabs-anchor {
    font-size: .8rem;
}


} /* smaller than 1215 */


/* ===========  For screens smaller than 1090px */
@media only screen and (max-width : 1090px) {

/* ====================================== Dashboard within WordPress */


    body .new_ui .r-tabs .r-tabs-nav {
        display: none;
    }

    body .new_ui .r-tabs .r-tabs-accordion-title {
        display: block;
    }
} /* ===========  end max width 1090 */



/* end behavior based on full width WP menu */


/* start behavior based on condensed WP menu */


/* ===========  For screens smaller than 1090px */
@media only screen and (max-width : 1090px) {

/* ====================================== Dashboard within WordPress */


     body.folded .new_ui .r-tabs .r-tabs-nav .r-tabs-tab .r-tabs-anchor {
        font-size: .8rem;
    }

} /* ===========  end max width 1090 */



/* ===========  For screens larger than 966px */
@media only screen and (min-width : 966px) {

/* ====================================== Dashboard within WordPress */

    body.folded .new_ui .r-tabs .r-tabs-nav {
        display: block;
    }

    body.folded .new_ui .r-tabs .r-tabs-accordion-title {
        display: none;
    }


} /* ===========  end min width 966 */



/* ===========  For screens smaller than 965px */
@media only screen and (max-width : 965px) {

/* ====================================== Dashboard within WordPress */

    body.folded .new_ui .r-tabs .r-tabs-nav {
        display: none;
    }

    body.folded .new_ui .r-tabs .r-tabs-accordion-title {
        display: block;
    }


} /* ===========  end max width 965 */

/* end behavior based on condensed WP menu */
/* end  tab / accordion behavior based on WP menu width (full and folded) */





/* GENERAL RESPONSIVE STYLES */


/* ===========  For screens smaller than 1100px */
@media only screen and (max-width : 1100px) {

     body .new_ui .r-tabs .button {
    font-size: .8rem;
}

.new_ui .brutecontainer h3.attn {
    font-size: 1.5rem;
}


} /* smaller than 1100 */


    /* ===========  For screens smaller than 885px */
    @media only screen and (max-width : 885px) {

        .new_ui form.apiholder input[type="text"],
        .new_ui form.apiholder input[type="submit"] {
            width: 100%;
            margin-bottom: 2px;
            border-right: 1px #e2e2e2 solid;
        }


        .new_ui .brutecontainer h3.attn {
    font-size: 1.35rem;
}

    } /* end small than 885 */


    /* ===========  For screens smaller than 750px */
    @media only screen and (max-width : 750px) {



        .new_ui .brutecontainer h3.attn {
    text-align: center;
    width: 100%;
}

    } /* end small than 750 */


    /* ===========  For screens smaller than 650px */
    @media only screen and (max-width : 650px) {

        .new_ui #bp-settings-form input[type="checkbox"] {
                    zoom: 1.0;
                    top: 0;
                    /*ms-transform: translate(0%, -50%);
                    -webkit-transform: translate(0, -50%);
                    transform: translate(0, -50%);*/
                    position: static;
                }

        .new_ui #bp-settings-form .checkrow label {
            margin-top: 5px;
            margin-bottom: 25px;
        }

        .new_ui #bp-settings-form .checkrow .checkholder {
            text-align: center;
        }


        .new_ui .brutecontainer input[type="submit"].submit_email {
            width: 100% !important;
        }


        .new_ui .brutecontainer input[type="text"].apifield {
            border-right: 1px #e2e2e2 solid;
        }


    } /* end small than 650 */


                


    /* ===========  For screens smaller than 640px */
    @media only screen and (max-width : 640px) {

                .new_ui .brutecontainer input[type="email"], .new_ui .brutecontainer input[type="text"], .new_ui .brutecontainer input[type="password"] {
                    border-right: 1px;
                    border-bottom: 1px !important;
                }

                .new_ui .brutecontainer input[type="submit"] {
                    width: 100%;
                }

                .new_ui .brutecontainer {
                    padding: 0 !important;
                }

                .new_ui .logogroup {
                    padding-bottom: 15px !important;
                }

                .new_ui .uiheader .btngroup {
                    text-align: center;
                }

                .new_ui .bpwpoptions select {
                    padding: 15px;
                    width: 100%;
                    margin-bottom: 2px;
                    height: auto !important;
                }

                .new_ui .stepholder {
                    margin-bottom: 10px;
                }



    } /* end 640 */




    /* ===========  For screens smaller than 600px */
    @media only screen and (max-width : 600px) {


.new_ui .r-tabs .r-tabs-panel.apioptions form {
    margin: 10px 0 25px !important;
}

} /* end 600 */


    </style>
<script>
   jQuery(document).ready( function() {
        jQuery(document).foundation();
    });
</script>

<?php if ( !empty($brute_error) ) : ?>
    <div class="error">
        <?php _e( $brute_error ); ?>
    </div>
<?php endif; ?>
<?php if( !empty($brute_success) && empty($brute_error) ) : ?>
    <div class="alert-box success">
        <?php _e( $brute_success ); ?>
    </div>
<?php endif; ?>
<?php

if( isset($_GET['force_mybp_step'])) {
    include 'mybp-sections/' . $_GET['force_mybp_step'] . '.php';
    return;
}

// determine where we are in the BruteProtect process
// step 1: get key
// step 2: save privacy settings
// step 3: link your site to my.bruteprotect.com
// we will include an output file based on what step we are on

if ( $invalid_key === true ) {
    // we are not working with a valid api key, let's prompt them to generate a new one
	include 'mybp-sections/step_1.php';
    return;
}
$brute_privacy_options_saved = get_site_option('brute_privacy_options_saved', false );
if( empty($brute_privacy_options_saved) ) {
    // there is no evidence of the user setting their privacy settings, we need to prompt them to save their settings
	include 'mybp-sections/step_2.php';
    return;
}

// if the api key is valid and there are privacy settings, let's show the tabs
include 'mybp-sections/step_3.php';
return;
?>