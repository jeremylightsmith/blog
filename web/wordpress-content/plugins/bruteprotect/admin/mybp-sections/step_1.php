<?php
    global $brute_error, $brute_success, $local_host, $current_user;
    include('header.php');
?>

<div id="bruteapi" class="new_ui row">

    <header class="uiheader clearfix" data-equalizer>

        <div class="columns large-9 medium-8 small-12 logogroup" data-equalizer-watch>

            <h2 class="status" >
                <div class="logo" >
                    <img src="<?PHP echo MYBP_URL; ?>assets/images/bruteprotect-dark.png" alt="BruteProtect">
                    <span class="msg">API Key</span>
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

                    <h2 class="steptitle">STEP 1</h2>

                    <h3 class="attn">In order to protect <?php echo $local_host; ?>, you must first obtain a free API key.</h3>

                    <form action="" class="row emailholder" method="post">
                        <input type="hidden" name="brute_action" value="get_api_key" />
                        <div class="columns large-8 medium-8">
                            <label for="email_address"><input type="email" name="email_address" placeholder="youremail@domain.com" id="brute_get_api_key" class="email" value="<?php echo $current_user->user_email; ?>" /></label>
                        </div>
                        <div class="columns large-4 medium-4">
                            <input type="submit" name="submit_email" value="Start protecting my site" class="submit_email " /> <!-- move to step 2 -->
                        </div>

                    </form>

                    <a href="#" class="already" id="alreadyapi">I already have an API key for <?php echo $local_host; ?></a>

                    <div class="stepholder columns large-12">
                        <div class="steps">

                            <em>Step 1 of 3</em>

                        </div><!-- // steps -->
                    </div><!-- // stepholder -->


                </div><?php // frontinner ?>
            </div> <?php // front of flip ?>

            <div class="back" data-equalizer-watch>
                <div class="backinner" data-equalizer-watch>


                    <h3 class="attn">Enter your API key.</h3>


                    <form id="api_retrieve" class="row emailholder" action="" method="post">
                        <input type="hidden" name="brute_action" value="update_key"/>
                        <div class="columns large-8 medium-8">
                            <label for="unique_api"><input type="text" name="brute_api_key" placeholder="" id="brute_get_api_key" class="apifield" /></label>
                        </div>
                        <div class="columns large-4 medium-4">
                            <input type="submit" name="submit_api" value="Start protecting my site" class="submit_api " /> <!-- move to step 2 -->
                        </div>

                    </form>


                    <h4 class="attn">Remember you need a unique API key for every site. <br />If you need a new one <a href="#" id="flip_return2" class="">click here.</a></h4>



                </div><?php // back inner ?>
            </div> <?php // back of flip ?>


        </div> <?php // hover ?>

        <script type="text/javascript">


            /**
             * Handler for fliping over to the api field
             */
            jQuery('#alreadyapi').on( "click", function() {
                jQuery(".hover").addClass('flip');

            });

            /**
             * Handler for fliping over to the checkout window
             */
            jQuery("#flip_return,#flip_return2").on("click", function() {
                jQuery(".hover").removeClass('flip');
            });


        </script>



        <!-- UNUSED - REPLACED BY HEADER

        <div class="stepbg">
        Step 1
        </div> // step bg -->

    </div> <!-- // brute container -->
</div> <!-- // brute api -->