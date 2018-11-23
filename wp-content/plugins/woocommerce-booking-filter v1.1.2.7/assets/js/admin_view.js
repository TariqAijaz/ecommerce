
jQuery(document).ready(function () {

    jQuery("#wcbf_search_type").parent().parent().parent().parent().css('border-bottom', '1px solid #ccc');
    jQuery("#wcbf_RF_s_date").parent().parent().parent().parent().css('border-bottom', '1px solid #ccc');
    jQuery("#wcbf_is_end_date_enabled").parent().parent().parent().parent().parent().parent().css('border-bottom', '1px solid #ccc');
    jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().css('border-bottom', '1px solid #ccc');
    jQuery("#wcbf_fuzzy_end_time").parent().parent().parent().parent().parent().parent().css('border-bottom', '1px solid #ccc');
    jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().css('border-bottom', '1px solid #ccc');
    jQuery("#wcbf_max_price").parent().parent().parent().parent().parent().parent().css('border-bottom', '1px solid #ccc');
    jQuery("#wcbf_is_rating_enabled").parent().parent().parent().parent().parent().parent().css('border-bottom', '1px solid #ccc');
    jQuery("#wcbf_is_keyword_search_enabled").parent().parent().parent().parent().parent().parent().css('border-bottom', '1px solid #ccc');

    /**
     * End date check
     */
    if (!jQuery("#wcbf_is_end_date_enabled").attr("checked")) {
        jQuery("#wcbf_is_end_date_enabled").parent().parent().parent().parent().next().css('display', 'none');
        jQuery("#wcbf_is_end_date_enabled").parent().parent().parent().parent().next().next().css('display', 'none');
    }
    jQuery("#wcbf_is_end_date_enabled").change(function () {
        if (!jQuery("#wcbf_is_end_date_enabled").attr("checked")) {
            jQuery("#wcbf_is_end_date_enabled").parent().parent().parent().parent().next().hide("slow");
            jQuery("#wcbf_is_end_date_enabled").parent().parent().parent().parent().next().next().hide("slow");
        } else {
            jQuery("#wcbf_is_end_date_enabled").parent().parent().parent().parent().next().show("slow");
            jQuery("#wcbf_is_end_date_enabled").parent().parent().parent().parent().next().next().show("slow");
        }
    });
    /**
     * Dropdown checks
     */
    if (jQuery("#wcbf_search_type").val() === "Fixed") {
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().css('display', 'none');
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().prev().css('display', 'none');
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().prev().prev().css('display', 'none');
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().css('display', 'none');
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().css('display', 'none');
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().next().css('display', 'none');        
        /**
         * Disabling checkbox 'ENDDATE'
         */
        jQuery("#wcbf_RF_e_date").attr('disabled',true);

    }
    jQuery('#wcbf_search_type').change(function () {
        if (jQuery(this).val() === "Fixed") {
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().prev().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().prev().prev().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().next().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").prop("checked", false);
            jQuery("#wcbf_fuzzy_end_time").prop("checked", false);
            jQuery("#wcbf_RF_e_date").attr('disabled',true);
            jQuery("#wcbf_RF_e_date").prop("checked", true);
        } else if (jQuery(this).val() === "Fuzzy") {
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().show("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().prev().show("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().prev().prev().show("slow");
            jQuery("#wcbf_RF_e_date").attr('disabled',false);
        }
    });
    /**
     * start time checks
     */
    if (!jQuery("#wcbf_fuzzy_time_en").attr("checked"))
    {
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().next().css('display', 'none');
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().next().next().css('display', 'none');
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().css('display', 'none');
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().css('display', 'none');
        jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().next().css('display', 'none');
    }
    jQuery("#wcbf_fuzzy_time_en").change(function () {
        if (!jQuery("#wcbf_fuzzy_time_en").attr("checked")) {
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().next().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().next().next().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().next().hide("slow");
            jQuery("#wcbf_fuzzy_end_time").prop("checked", false);
        } else {
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().next().show("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().next().next().show("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().show("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().show("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().next().show("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().next().find('tbody').find('tr').next().hide("slow");
            jQuery("#wcbf_fuzzy_time_en").parent().parent().parent().parent().parent().parent().next().next().next().find('tbody').find('tr').next().next().hide("slow");
        }
    });
    /**
     * End date check
     */
    if (!jQuery("#wcbf_fuzzy_end_time").attr("checked")) {
        jQuery("#wcbf_fuzzy_end_time").parent().parent().parent().parent().next().css('display', 'none');
        jQuery("#wcbf_fuzzy_end_time").parent().parent().parent().parent().next().next().css('display', 'none');
    }
    jQuery("#wcbf_fuzzy_end_time").change(function () {
        if (!jQuery("#wcbf_fuzzy_end_time").attr("checked")) {
            jQuery("#wcbf_fuzzy_end_time").parent().parent().parent().parent().next().hide("slow");
            jQuery("#wcbf_fuzzy_end_time").parent().parent().parent().parent().next().next().hide("slow");
        } else {
            jQuery("#wcbf_fuzzy_end_time").parent().parent().parent().parent().next().show("slow");
            jQuery("#wcbf_fuzzy_end_time").parent().parent().parent().parent().next().next().show("slow");
        }
    });

    /**
     * Min price check
     */
    if (!jQuery("#wcbf_min_price").attr("checked"))
    {
        jQuery("#wcbf_min_price").parent().parent().parent().parent().next().css('display', 'none');
        jQuery("#wcbf_min_price").parent().parent().parent().parent().next().next().css('display', 'none');
        jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().css('display', 'none');
        jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().next().css('display', 'none');
        jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().next().next().css('display', 'none');
    }
    jQuery("#wcbf_min_price").change(function () {
        if (!jQuery("#wcbf_min_price").attr("checked")) {
            jQuery("#wcbf_min_price").parent().parent().parent().parent().next().hide("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().next().next().hide("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().hide("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().next().hide("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().next().next().hide("slow");
            jQuery("#wcbf_max_price").prop("checked", false);
        } else {
            jQuery("#wcbf_min_price").parent().parent().parent().parent().next().show("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().next().next().show("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().show("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().next().show("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().next().next().show("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().next().next().find('tbody').find('tr').next().hide("slow");
            jQuery("#wcbf_min_price").parent().parent().parent().parent().parent().parent().next().next().next().find('tbody').find('tr').next().next().hide("slow");
        }
    });
    /**
     * Max Price check
     */
    if (!jQuery("#wcbf_max_price").attr("checked")) {
        jQuery("#wcbf_max_price").parent().parent().parent().parent().next().css('display', 'none');
    }
    jQuery("#wcbf_max_price").change(function () {
        if (!jQuery("#wcbf_max_price").attr("checked")) {
            jQuery("#wcbf_max_price").parent().parent().parent().parent().next().hide("slow");
        } else {
            jQuery("#wcbf_max_price").parent().parent().parent().parent().next().show("slow");
        }
    });
    /**
     * Rating check
     */
    if (!jQuery("#wcbf_is_rating_enabled").attr("checked")) {
        jQuery("#wcbf_is_rating_enabled").parent().parent().parent().parent().next().css('display', 'none');
        jQuery("#wcbf_is_rating_enabled").parent().parent().parent().parent().next().next().css('display', 'none');
    }
    jQuery("#wcbf_is_rating_enabled").change(function () {
        if (!jQuery("#wcbf_is_rating_enabled").attr("checked")) {
            jQuery("#wcbf_is_rating_enabled").parent().parent().parent().parent().next().hide("slow");
            jQuery("#wcbf_is_rating_enabled").parent().parent().parent().parent().next().next().hide("slow");
        } else {
            jQuery("#wcbf_is_rating_enabled").parent().parent().parent().parent().next().show("slow");
            jQuery("#wcbf_is_rating_enabled").parent().parent().parent().parent().next().next().show("slow");
        }
    });
    /**
     * Keyword type search
     */
    if (!jQuery("#wcbf_is_keyword_search_enabled").attr("checked")) {
        jQuery("#wcbf_is_keyword_search_enabled").parent().parent().parent().parent().next().css('display', 'none');
        jQuery("#wcbf_is_keyword_search_enabled").parent().parent().parent().parent().next().next().css('display', 'none');
    }
    jQuery("#wcbf_is_keyword_search_enabled").change(function () {
        if (!jQuery("#wcbf_is_keyword_search_enabled").attr("checked")) {
            jQuery("#wcbf_is_keyword_search_enabled").parent().parent().parent().parent().next().hide("slow");
            jQuery("#wcbf_is_keyword_search_enabled").parent().parent().parent().parent().next().next().hide("slow");
        } else {
            jQuery("#wcbf_is_keyword_search_enabled").parent().parent().parent().parent().next().show("slow");
            jQuery("#wcbf_is_keyword_search_enabled").parent().parent().parent().parent().next().next().show("slow");
        }
    });
    /**
     * Handling enddate checkbox
     */
    jQuery("#mainform").submit(function() {
    jQuery("#wcbf_RF_e_date").removeAttr("disabled");
    });
});