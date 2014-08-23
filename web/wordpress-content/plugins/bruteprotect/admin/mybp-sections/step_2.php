<?php
global $privacy_opt_in, $remote_security_options;
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

            &nbsp;

        </div> <!-- // btngroup -->

    </header>


    <div class="brutecontainer columns large-12">


        <div class="hover apipanel" data-equalizer data-equalizer-watch>

            <div class="front" data-equalizer-watch>
                <div class="frontinner" data-equalizer-watch>

                    <h2 class="steptitle">STEP 2</h2>

                    <h3 class="attn">We need your permission to do the following</h3>

                    <form action="" method="post" accept-charset="utf-8" id="bp-settings-form">

                        <input type="hidden" name="privacy_opt_in[submitted]" value="1" id="privacy_opt_in[submitted]" />

                        <div class="row checkrow" data-equalizer>

                            <?php if ( is_array( $remote_security_options ) ) : ?>
                                <?php foreach ( $remote_security_options as $key => $desc ) : ?>
                                    <?php $checked = (isset( $privacy_opt_in[ $key ] )) ? 'checked="checked"' : ''; ?>
                                    <div class="row checkrow" data-equalizer>

                                        <div class="columns large-1 medium-1 small-12" data-equalizer-watch>
                                            <input name="privacy_opt_in[<?php echo $key; ?>]" type="checkbox" value="1" class="bp_privacy_opt_in_checkbox" <?php echo $checked; ?> />
                                        </div><?php // lrg-1 ?>

                                        <div class="columns large-11 medium-11 small-12" data-equalizer-watch>
                                            <label for="privacy_opt_in[<?php echo $key; ?>]" class="setting"><?php echo $desc; ?></label>
                                        </div><?php // lrg-11 ?>

                                    </div><!-- row -->
                                <?php endforeach; ?>
                            <?php endif; ?>


                        </div><!-- row -->



                            <input type="submit" value="Save Settings" class="right permission">

                    </form>

                    <div class="stepholder columns large-12">
                        <div class="steps">

                            <em>Step 2 of 3</em>

                        </div><!-- // steps -->
                    </div><!-- // stepholder -->


                </div><?php // frontinner ?>
            </div> <?php // front of flip ?>

        </div> <?php // hover ?>


    </div> <!-- // brute container -->
</div> <!-- // brute api -->