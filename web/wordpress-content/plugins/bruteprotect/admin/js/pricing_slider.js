jQuery(document).ready( function() {
    jQuery( "#slider" ).slider({
        animate: "fast",
        slide: function( event, ui ) { display_slide_value(ui.value) },
        max: 100,
        min: 0,
        value: 7,
    });

    jQuery("#manualsitecount").keyup(function(){
        process_manual_count(jQuery(this).val());
    });

    display_slide_value(7);

    jQuery(".ui-slider-handle").hover( function() { jQuery(this).css('cursor', 'pointer') });
});

function display_slide_value(sitecount, manual){
    var price;
    if(sitecount < 1 || sitecount == null) {
        price = 0;
    }
    else if(sitecount < 2) price = 5;
    else if(sitecount < 101) price = calculate_bp_pro_price(sitecount);
    else if(sitecount > 100) price = .7;

    var modsitecount = sitecount;
    if(modsitecount == '')modsitecount = 0;
    jQuery( "#slidersitestotal" ).html(modsitecount);
    jQuery( "#manualsitecount" ).val(sitecount);
    jQuery( "#pricepersite" ).html(price);
    jQuery( "#desired_sitecount" ).val(sitecount);
    var pricepermonth = sitecount * price;
    jQuery( "#pricepermonth" ).html(pricepermonth.toFixed(2));
    jQuery( "#priceperyear" ).html((pricepermonth*10).toFixed(2));
    var sliderpos;
    if(sitecount<101) sliderpos = (sitecount*.95)+2.5+"%";
    else sliderpos = (100*.90)+2.5+"%";

    jQuery( "#sliderinfo" ).css("left", sliderpos);
    if(manual === true)jQuery( ".ui-slider-handle" ).css("left", sliderpos);

}



function process_manual_count(manualsitecount){
    if( manualsitecount<0 || manualsitecount == null )manualsitecount=0;
    if( manualsitecount>100 ){
        jQuery("#sliderinfo").hide();
        jQuery("#slider").hide("slow");
    }else if( jQuery("#slider").is(":hidden") ){
        jQuery("#sliderinfo").show(500);
        jQuery("#slider").show(400);
    }

    display_slide_value(manualsitecount, true);
}

function calculate_bp_pro_price( sitecount ){
    var price_per_site = 5.4 * Math.pow(sitecount,-.44);
    return price_per_site.toFixed(2);
}