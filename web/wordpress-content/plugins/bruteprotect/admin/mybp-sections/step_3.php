<?php
    global $privacy_opt_in, $remote_security_options, $local_host;
    global $register_error, $linking_error, $linking_success;
    global $privacy_success;
    global $wordpress_success;
    global $whitelist_success;
    $brute_ip_whitelist = get_site_option( 'brute_ip_whitelist' );
    $admins = get_site_option( 'brute_dashboard_widget_admin_only' );
    $iframe_url = get_mybp_iframe_url($privacy_opt_in);
    include('header.php');
?>

<div id="bruteapi" class="new_ui row">

<header class="uiheader clearfix" data-equalizer>

    <div class="columns large-9 medium-8 small-12 logogroup" data-equalizer-watch>

        <h2 class="status" >
            <div class="logo" >
                <img src="<?PHP echo MYBP_URL; ?>assets/images/bruteprotect-dark.png" alt="BruteProtect">
                <span class="msg"><i class="fa fa-check-square "></i> <span>BruteProtect is working</span></span>
            </div><?php // logo ?>
        </h2>

    </div> <!-- // logogroup -->

    <div class="columns large-3 medium-4 small-12 btngroup" data-equalizer-watch>
        <?php if( !empty($iframe_url) ) : ?>
            <form action="" method="post" class="regform" id="disconnect_bp">
                 <input type="hidden" name="brute_action" value="unlink_owner_from_site"/>
                 <input type="submit" value="Disconnect Site" class="button" id="disconnect_bp_button" />
            </form>
            <script>
                jQuery( document ). ready( function() {
                    jQuery( "#disconnect_bp_button" ).click( function(e) {
                        e.preventDefault();
                        var d = confirm( "Are you sure you want to disconnect this site from your my.bruteprotect.com account? BruteProtect Shield will still be active.");
                        if( d ) {
                            jQuery( "#disconnect_bp" ).submit();
                        }
                    });
                });
            </script>
        <?php endif; ?>

    </div> <!-- // btngroup -->

</header>


<div class="brutecontainer columns large-12 finalstep">


<div class="hover apipanel" data-equalizer data-equalizer-watch>

<div class="front" data-equalizer-watch>
<div class="frontinner" data-equalizer-watch>

<div id="horizontalTab">
<ul>
    <li><a href="#tab-1">My BruteProtect <i class="fa fa-plus"></i><i class="fa fa-minus"></i></a></li>
    <li><a href="#tab-2">API &amp; Privacy Settings <i class="fa fa-plus"></i><i class="fa fa-minus"></i></a></li>
    <li><a href="#tab-3">Whitelist IPs <i class="fa fa-plus"></i><i class="fa fa-minus"></i></a></li>
    <li><a href="#tab-4">WordPress Settings <i class="fa fa-plus"></i><i class="fa fa-minus"></i></a></li>
    <li><a href="#tab-5">Partners <i class="fa fa-plus"></i><i class="fa fa-minus"></i></a></li>
    <li class="whypro"><a href="#tab-6">Why Pro? <i class="fa fa-plus"></i><i class="fa fa-minus"></i></a></li>
</ul>



<div id="tab-1" class="dashholder">


    <div class="step a3 clearfix">


        <?php if( false == $iframe_url ) : ?>

            <?php include('register.php'); ?>

        <?php else : ?>

            <?php if( !empty($linking_success) ) : ?>
                <div class="alert-box success">
                    <?php _e( $linking_success ); ?>
                </div>
            <?php endif; ?>

             <iframe src="<?php echo $iframe_url; ?>" width="100%" height="780" ></iframe>

        <?php endif; ?>

    </div> <?php // end step ?>


</div> <?php // tab 1 ?>


<div id="tab-2" class="apioptions">

    <?php if( !empty($privacy_success) ) : ?>
        <div class="alert-box success">
            <?php _e( $privacy_success ); ?>
        </div>
    <?php endif; ?>

    <h3 class="attn">API Key for: <em><?php echo $local_host; ?></em></h3>



    <form action="" method="post" class="apiholder clearfix" id="remove_api_key_form">
        <input type="text" name="brute_api_key" value="8616cbccf08024357ce95c942fd5433514d6de78" id="brute_api_key" disabled="disabled" />
        <input type="hidden" name="brute_action" value="remove_key" />
        <input type="submit" value="Remove API Key" class="button green alignright" id="remove_api_key_button" />

        <script>
            jQuery( document ). ready( function() {
                jQuery( "#remove_api_key_button" ).click( function(e) {
                    e.preventDefault();
                    var d = confirm( "Are you sure you want to remove your API key? It will remove any pro features you have, as well as brute force protection. But you can easily get a new key afterwards.");
                    if( d ) {
                        jQuery( "#remove_api_key_form" ).submit();
                    }
                });
            });
        </script>
    </form>


    <h3 class="attn">Privacy Settings</h3>


    <form action="#tab-2" method="post" accept-charset="utf-8" id="bp-settings-form">

        <input type="hidden" name="privacy_opt_in[submitted]" value="1" id="privacy_opt_in[submitted]">

        <div class="row checkrow" data-equalizer>

            <?php if ( is_array( $remote_security_options ) ) : ?>
                <?php foreach ( $remote_security_options as $key => $desc ) : ?>
                    <?php $checked = (isset( $privacy_opt_in[ $key ] )) ? 'checked="checked"' : ''; ?>
                    <div class="row checkrow" data-equalizer>

                        <div class="columns large-1 medium-12 small-12 checkholder" data-equalizer-watch>
                            <input name="privacy_opt_in[<?php echo $key; ?>]" type="checkbox" value="1" class="bp_privacy_opt_in_checkbox" <?php echo $checked; ?> />
                        </div><?php // lrg-1 ?>

                        <div class="columns large-11 medium-12 small-12" data-equalizer-watch>
                            <label for="privacy_opt_in[<?php echo $key; ?>]" class="setting"><?php echo $desc; ?></label>
                        </div><?php // lrg-11 ?>

                    </div><!-- row -->
                <?php endforeach; ?>
            <?php endif; ?>

        </div><!-- row -->

        <div class="row">
            <input type="submit" value="Save Settings" class="right permission">
        </div><!-- row -->

    </form>


</div> <?php // tab 2 ?>



<div id="tab-3" class="whitelistoptions">

    <?php if( !empty($whitelist_success) ) : ?>
        <div class="alert-box success">
            <?php _e( $whitelist_success ); ?>
        </div>
    <?php endif; ?>

    <h3 class="attn">IP Whitelist: Always allow access from the following IP's</h3>



    <h4>Your current IP address is: <strong><?php echo $this->brute_get_ip(); ?></strong></h4>

    <p>Enter one IPv4 per line, * for wildcard octet<br />
        <em>(ie: <code>192.168.0.1</code>
            and <code>192.168.*.*</code> are valid, <code>192.168.*</code> and <code>192.168.*.1</code> are invalid)</em></p>

    <form action="#tab-3" method="post" class="clearfix">

        <textarea name="brute_ip_whitelist" class="ipholder"><?php echo $brute_ip_whitelist ?></textarea>

        <input type="hidden" name="brute_action" value="update_brute_whitelist"><br>
        <input type="submit" value="Save IP Whitelist" class="button blue alignright">
    </form>



</div><?php // tab 3 ?>



<div id="tab-4" class="bpwpoptions clearfix">
    <?php if( !empty($wordpress_success) ) : ?>
        <div class="alert-box success">
            <?php _e( $wordpress_success ); ?>
        </div>
    <?php endif; ?>
    <h3 class="attn">BruteProtect dashboard widget should be visible to...</h3>



    <form action="#tab-4" method="post" accept-charset="utf-8" id="bp-settings-form">
        <select name="brute_dashboard_widget_admin_only" id="brute_dashboard_widget_admin_only">
            <option value="0" <?php if($admins=='0') echo 'selected="selected"'; ?>>All users who can see the dashboard</option>
            <option value="1" <?php if($admins=='1') echo 'selected="selected"'; ?>>Admins Only</option>
        </select>
        <input type="hidden" name="brute_action" value="general_update" id="brute_action">
        <input type="submit" value="Save Changes" class="button button-primary blue alignright">
    </form>

</div> <?php // tab 4 ?>




<div id="tab-5" class="bppartners">

    <h3 class="attn">BruteProtect recommends</h3>

    <div class="row" data-equalizer>
        <div class="columns large-6 clefholder" data-equalizer-watch>


            <div class="cleflogo">
                <a href="http://www.getclef.com" target="_blank"><img src="<?PHP echo MYBP_URL; ?>assets/images/clef-clear.png"></a>
            </div>

            <p>Clef is a <strong>free</strong> security plugin that replaces your password in less than 60 seconds. Recommended by BruteProtect, <a href="https://support.cloudflare.com/hc/en-us/articles/200908270-Can-CloudFlare-protect-me-against-WordPress-brute-force-attacks-" target="_blank">CloudFlare</a>, the <a href="bits.blogs.nytimes.com/2013/12/18/new-clef-plug-in-lets-you-forget-about-your-password/" target="_blank">New York Times</a>, and <a href="http://wordpress.org/support/view/plugin-reviews/wpclef?filter=5" target="_blank">WordPress users everywhere</a>.

            </p>

            <a href="http://wordpress.org/plugins/wpclef/" class="button">Install and set up Clef in 30 seconds</a>


        </div><?php // lrg 6 ?>

        <div class="columns large-6 writtenholder" data-equalizer-watch>


            <div class="writtenlogo">
                <a href="http://written.com" target="_blank"><img src="<?PHP echo MYBP_URL; ?>assets/images/written-clear.png"></a>
            </div>


            <p>
                Written.com facilitates a marketplace for proven content, allowing bloggers and brands to safely exchange in content licensing, content syndication, and full-page sponsorship agreements. Our goal is simple, to increase the ROI on content.
            </p>

            <a href="http://written.com" class="button">Learn more about Written.com</a>


        </div><?php // lrg 6 ?>

    </div><?php // row ?>
    <div class="row" >

        <div class="columns large-12 partnersoon" >

            <div class="">
                <br />&nbsp;<br />
                <h3>Want to partner with BruteProtect?</h3>
                <h4><a href="https://bruteprotect.com/support-contact/" target="_blank">Get in touch with us!</a></h4>
                <br />&nbsp;<br />
            </div><?php // vert align ?>


        </div><?php // lrg 6 ?>


    </div><?php // row ?>

</div><?php // tab 5 ?>


<div id="tab-6" class="whyproholder">

    <h3 class="attn">BruteProtect has great pro features!</h3>



    <div class="row" data-equalizer>

        <div class="columns large-6" data-equalizer-watch>
            <h3><strong>Secure Log in</strong></h3>
            <p>Our Secure Log In feature is intended for users who aren’t protected by SSL when signing in to their site.  Why does this matter? SSL reduces the chances of a password being stolen when connecting to public WIFI.  Visitors to your site can still access your site via wp-admin, but will use a new page that’s unique to your site and can’t be found as easily as the standard log-in page.</p>
        </div>

        <div class="columns large-6" data-equalizer-watch>
            <h3><strong>Uptime Monitoring</strong></h3>
            <p>We leverage multiple systems to monitor the uptime of your sites. We scan every five minutes to provide up-to-date information. You’ll see how many days without incident, a screen capture during downtime, and receive email notifications.</p>
        </div>

    </div>

    <div class="row" data-equalizer>

        <div class="columns large-6" data-equalizer-watch >
            <h3><strong>Remote Updates and Monitoring</strong></h3>
            <p>We know that updating themes, plugins, and WordPress core across multiple sites is time consuming and difficult to manage. We make this task easier with My BruteProtect, a dashboard that houses and displays your site information in a visually stunning way.</p>
        </div>
        <div class="columns large-6" data-equalizer-watch >
            <h3><strong>Scalable Pricing</strong></h3>
            <p>With BruteProtect Pro, you only pay for what you need. Our pro prices are as low as .70¢ per site per month. Whether it’s 1 site or 100, we can meet your needs. We even support users with a high number of sites or large multi-site networks. And don’t forget, BruteProtect will always release and support a free version of the plugin for brute force protection.</p>
            <p><a href="https://bruteprotect.com/faqs/pricing-faq/" title="Pricing FAQ" class="button pronow" target="_blank">Learn more or calculate pricing now!</a></p>
        </div>

    </div>
    <br />
    <a href="https://bruteprotect.com/upcoming-features/" target="_blank" class="button">We've got some great upcoming features on the way too!</a>


</div> <?php // tab 6 ?>


</div> <?php // horizontalTab ?>

<!-- put these in the footer file -->
<script src="<?PHP echo MYBP_URL; ?>assets/js/jquery.responsiveTabs.min.js" type="text/javascript"></script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('#horizontalTab').responsiveTabs({
        });

        jQuery('#start-rotation').on('click', function() {
            jQuery('#horizontalTab').responsiveTabs('active');
        });
        jQuery('#stop-rotation').on('click', function() {
            jQuery('#horizontalTab').responsiveTabs('stopRotation');
        });
        jQuery('#start-rotation').on('click', function() {
            jQuery('#horizontalTab').responsiveTabs('active');
        });
        jQuery('.select-tab').on('click', function() {
            jQuery('#horizontalTab').responsiveTabs('activate', jQuery(this).val());
        });

    });
</script>


</div><?php // frontinner ?>
</div> <?php // front of flip ?>

</div> <?php // hover ?>


</div> <!-- // brute container -->
</div> <!-- // brute api -->
