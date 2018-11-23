jQuery(document).ready(function () {
    /**
     * iinit timepicker
     */
    jQuery('#en_time').timepicker({'timeFormat': 'H:i:s', 'disableTextInput': true, 'step': 60});
    jQuery('#strt_time').timepicker({'timeFormat': 'H:i:s', 'disableTextInput': true, 'step': 60});

    //Fetching currency
    var currency = jQuery("#currency").val();

    //rating button reset
    jQuery("#reset-rating-button").click(function () {
        jQuery('input[name=ratingg]').attr('checked', false);
    });

    /**
     * Taking highest price
     */
    var highest_p = jQuery("#highest_price").val();
    /**
     * Iniit slider without endrange
     */
    jQuery("#slider").slider({
        min: 1,
        max: highest_p,
        value: jQuery("#min_price").val(),
        slide: function (event, ui) {
            jQuery("#amount").val(currency + ui.value);
            jQuery("#min_price").val(ui.value);
        }
    });
    var value = jQuery("#slider").slider("option", "value");
    jQuery("#amount").val(value + currency);

    /**
     * Iniit slider  endrange
     */

    jQuery("#slider-range").slider({
        range: true,
        min: 1,
        max: highest_p,
        values: [jQuery("#min_price").val(), jQuery("#max_price").val()],
        slide: function (event, ui) {
            jQuery("#amount1").val(currency + ui.values[ 0 ] + " - " + currency + ui.values[ 1 ]);
            jQuery("#min_price").val(ui.values[0]);
            jQuery("#max_price").val(ui.values[1]);
        }
    });

    jQuery("#amount1").val(currency + jQuery("#slider-range").slider("values", 0) +
            " - " + currency + jQuery("#slider-range").slider("values", 1));
    /**
     * Checks if #amount input type text exists in html page
     * (actually, if end price range is not selected then this ID will appear and changes max_price val to null)
     * so it can perform search based on only starting price
     */
    if (jQuery("#amount").length != 0)
    {
        jQuery("#max_price").val("");
    }

    /**
     * Working of date  formate
     */
    var arr;
    var set;
    var format = jQuery("#date_format").val();
    jQuery("#end_date").datepicker({minDate: 0, dateFormat: format});
    jQuery("#start_date").datepicker({minDate: 0, dateFormat: format});


    /**
     * Reset button click action triggers all fields to reset.
     */
    jQuery("#reset").click(function () {
        jQuery("#start_date").val("");
        jQuery('input[name=ratingg]').attr('checked', false);
        jQuery("#end_date").val("");
        jQuery("#strt_time").val("");
        jQuery("#en_time").val("");
        jQuery("#wcbf_product_name").val("");
        jQuery("#min_price_input").val("1");
        jQuery("#slider").slider({
            value: 1
        });
        jQuery("#amount").val(currency + "1");
        jQuery("#min_price").val("1");
        jQuery("#slider-range").slider({
            values: [1, highest_p]
        });
        jQuery("#amount1").val(currency + 1 + " - " + currency + highest_p);

        //if max price enabled
        if (jQuery("#amount").length == 0)
        {
            jQuery("#max_price").val(highest_p);
        }
    });

    jQuery("#sub").click(function (e) {
        e.preventDefault();
        if (validate())
        {
            jQuery("#sub").unbind('click').click();
        }
    });


});

function getRFVSettings() {
    set = jQuery("#RFV_settings").val();
    arr = set.split('-');
    return arr;
}
function countTrue(p)
{
    var counter = 0;
    for (var i = 0; i < p.length; i++) {
        if (p [ i ] === 'yes')
            counter++;
    }
    return counter;
}

function validate() {
    var setting = getRFVSettings();
    var trueCounts = countTrue(setting);
    var ourCounts = 0;
    var sdate = jQuery("#start_date").val();
    var edate = jQuery("#end_date").val();
    var stime = jQuery("#strt_time").val();
    var etime = jQuery("#en_time").val();



    if ((sdate != "" && arr[0] == 'yes')) {
        jQuery("#sd-td").html("");
        ourCounts++;
    } else if (arr[0] == 'yes') {
        jQuery("#sd-td").show("slow").html("You must enter this field.");
    }

    if ((edate != "" && arr[1] === 'yes')) {
        jQuery("#ed-td").html("");
        ourCounts++;
    } else if (arr[1] === 'yes') {

        jQuery("#ed-td").show("slow").html("You must enter this field.");
    }

    if ((stime != "" && arr[2] === 'yes')) {
        jQuery("#st-td").html("");
        ourCounts++;
    } else if (arr[2] == 'yes') {
        jQuery("#st-td").show("slow").html("You must enter this field.");
    }

    if ((etime != "" && arr[3] === 'yes')) {
        jQuery("#et-td").html("");
        ourCounts++;
    } else if (arr[3] === 'yes') {
        jQuery("#et-td").show("slow").html("You must enter this field.");

    }

    if (ourCounts === trueCounts) {
        return  true;
    }

    jQuery("#sd-td").css('color', 'red');
    jQuery("#ed-td").css('color', 'red');
    jQuery("#st-td").css('color', 'red');
    jQuery("#et-td").css('color', 'red');
}