
<?php global $is_linking, $register_error, $linking_error, $current_user; ?>
<div id="bpregister">
    <a href="#" class="right button" id="alreadyaccount">Already have an account? Log in</a>

    <h3 class="attn">Register for BruteProtect Dashboard Access</h3>

    <?php if ( !empty($register_error) ) : ?>
        <div class="error">
            <?php _e( $register_error ); ?>
        </div>
    <?php endif; ?>

    <form action="#tab-1" method="post" onsubmit="return validate_reg_form()">
        <div class="large-6 columns padrightonly">


            <div class="large-6 columns padrightonly">
                <p>First Name* <input type="text" id="first_name" name="first_name" value="<?php echo $current_user->user_firstname; ?>" tabindex="1"></p>
            </div>
            <div class="large-6 columns nopad">
                <p>Last Name* <input type="text" id="last_name" name="last_name" value="<?php echo $current_user->user_lastname; ?>" tabindex="2"></p>

            </div>
            <p>Company <input type="text" name="company" value="" tabindex="3"></p>
            <p>Email* <input type="text" id="email" name="email" value="<?php echo $current_user->user_email; ?>" tabindex="4"></p>
            <p id="cracktime">Password* (Crack Time: <span></span>) <i data-tooltip="" class="has-tip fa fa-question-circle" data-selector="tooltip-hxoym3bq0" title="Amount of time it will take to crack your password."></i><a href="#" id="hidepass">hide password</a>
                <input type="text" id="password" class="strength0" name="password" autocomplete="off" value="" tabindex="5"></p>
            <p><em>By signing up for My BruteProtect, you agree to our <a href="https://bruteprotect.com/terms-service/" target="blank">terms and conditions</a></em></p>
            <input type="hidden" name="brute_action" value="register_and_link" />
        </div>
        <div class="large-6 columns">
            <p>Access to the My BruteProtect and its botnet protection services <strong>will always be free</strong> for unlimited websites. You will automatically receive a 14 day free trial of our pro services. <a href="https://bruteprotect.com" target="_blank">Learn more. </a>
            </p>

            <div class="pricecontainer">
                <h2>Add Pro Services</h2>

                <div class="btmprice">


                    <div class="row">
                        <div class="columns large-7 medium-7 small-12">
                            <span class="upper">Number of Sites </span> <input type="tel" id="manualsitecount" />
                        </div>
                        <div class="columns large-5 medium-5 small-12 persite">
                            $<span id="pricepersite">2.29</span> <span class="upper">per site</span>
                        </div>
                    </div>			<div class="row">
                        <div class="slidepad">
                            <p id="sliderinfo" style="left: 9.149999999999999%;"><span id="slidersitestotal">7</span></p>
                            <div id="slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false"><div id="innerslider"></div><a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 7.000000000000001%;"></a></div>
                        </div></div>			<div class="row">
                        <p class="permonth large-12 small-12">Total cost per month $<span id="pricepermonth">16.03</span></p> 		</div>	</div>
            </div>					<br>
            <div class="row">
                <div class="columns large-6">
                    &nbsp;
                </div>
                <div class="columns large-6">
                    <input type="submit" name="starttrial" id="starttrial" value="Start Free Trial" class="btn-go-pro button" tabindex="6">
                </div>

            </div>
        </div>

    </form> <!-- end register -->
</div>

<div id="bp_link">
    <h3 class="attn center">Access your site through the BruteProtect Dashboard, it's free</h3>
    <?php if ( !empty($linking_error) ) : ?>
        <div class="error">
            <?php _e( $linking_error ); ?>
        </div>
    <?php endif; ?>
    <div class="clearfix" data-equalizer>

        <div class="columns large-6 linkcreds" data-equalizer-watch>
            <p><em>Enter your My BruteProtect username &amp; password to link this site to your account.</em></p>

            <form action="#tab-1" method="post" class="regform">
                <label for="email"><strong>Email:</strong>
                    <input type="text" name="username">
                </label>

                <label for="password"><strong>Password:</strong>
                    <input type="password" name="password">
                </label>
                <br><br>
                <input type="hidden" name="brute_action" value="link_owner_to_site">
                <input type="submit" value="Link this site" class="button orange">

            </form>

        </div><?php // lrg6 ?>

        <div class="columns large-1" data-equalizer-watch>

            <h5 class="vertalign center"><strong>or</strong></h5>

        </div><?php // lrg1 ?>
        <div class="columns large-5" data-equalizer-watch>
            <a href="#" class="button medium vertalign" id="register_return">Don't have a BruteProtect account?<br />Register now!</a>
        </div><?php // lrg5 ?>

    </div><?php // clearfix ?>
</div>




<script type="text/javascript">

    jQuery(document).ready( function() {

        <?php if($is_linking === true ) : ?>
            jQuery("#bpregister").hide();
        <?php else : ?>
            jQuery("#bp_link").hide();
        <?php endif; ?>

        jQuery('#alreadyaccount').on( "click", function() {
            jQuery("#bp_link").show();
            jQuery("#bpregister").hide();

        });
        jQuery("#register_return").on("click", function() {
            jQuery("#bp_link").hide();
            jQuery("#bpregister").show();
        });
    });


</script>