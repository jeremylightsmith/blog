jQuery(document).ready(function(){
    jQuery('.phone').hide();
    var pass_obj = jQuery('#password');
    var strengthbar_obj = jQuery('#strengthbar');
    jQuery(pass_obj).keyup(function() {
        var analysis = zxcvbn(pass_obj.val());
        var entropy = analysis.entropy;
        jQuery('#cracktime span').html(analysis.crack_time_display);
        pass_obj.removeClass().addClass("strength"+analysis.score);
    });

    jQuery('#hidepass').click(function(){

        if( pass_obj.attr('type') == 'text' ){
            pass_obj.removeAttr('type').prop('type', 'password');
            jQuery(this).html('show password');
        }else {
            pass_obj.removeAttr('type').prop('type', 'text');
            jQuery(this).html('hide password');
        }
        return false;
    });

    jQuery( "#submitpro" ).click(function() {
        jQuery("#going_pro").val("true");
    });
    jQuery( "#submitfree" ).click(function() {
        jQuery("#going_pro").val("false");
    });

});


function validate_reg_form(){
//alert('validating');

    var form_objs = new Array( jQuery('#first_name'), jQuery('#last_name'), jQuery('#email'), jQuery('#password') );
    var errorcount = 0;

    jQuery.each( form_objs, function( key, value ) {
        if(value.val() == "" || value.val() == "required" ){
            value.val("required");
            value.addClass("error");
            errorcount++;
        }
        if(key == 2 && value.val() != "required"){
            if(isValidEmailAddress(value.val()) == false){
                errorcount++
                value.val("sorry, your email address wasn't written correctly");
            }
        }
        if(key == 3){
            if(value.val().length < 6 || value.val() == "password must be at least 6 characters long"){
                value.val('password must be at least 6 characters long');
                errorcount++;
            }
        }
    });
    if(errorcount > 0)return false;
    else return true;

};


function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};