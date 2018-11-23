<?php
class WC_Settings_Tab {
    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_settings_tab', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_settings_tab', __CLASS__ . '::update_settings' );
    }
    
    
    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['settings_tab'] = __( 'Booking Filter Settings', 'wcbf-filter-setting' );
        return $settings_tabs;
    }
    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }
    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }
    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {
        return $settings = apply_filters(
            'woocommerce_settings_booking', array(

                array(
                    'title' => __( 'Booking Filter Settings', 'wcbf-filter-setting' ),
                    'desc'  => __( 'You can change your WooBooking filter settings from here. <br>Use <code>[filter]</code> on any of your page to make your filter visible there.', 'wcbf-filter-setting' ),
                    'type'  => 'title',
                    'id'    => 'wc_settings_tab_section_title',
                ),
                
                array(
                    'name'    => __( 'Select your search type', 'wcbf-filter-setting' ),
                    'type'    => 'select',
                    'desc_tip'=> true,
                    'options' => array( 'Fuzzy' => 'Fuzzy', "Fixed" => "Fixed" ),
                    'desc'    => __( 'Select your search criteria (i.e. Fixed for fix search (Will search bookable products only if completely available in available time range), Fuzzy for when any available bookable product within range.)', 'wcbf-filter-setting' ),
                    'id'      => 'wcbf_search_type'
                ),
                
                array(
                    'type' => 'sectionend',
                    'id'   => 'wc_settings_tab_section_title',
                ),

                array(
                    'title' => __( 'Start Date', 'wcbf-filter-setting' ),
                    'desc'  => __( 'You can change your WooBooking filter settings from here.', 'wcbf-filter-setting' ),
                    'type'  => 'title',
                    'id'    => 'wcbf_start_date_setting',
                ),

                array(
                    'name' => __( 'Customize text', 'wcbf-filter-setting' ),
                    'type' => 'text',
                    'desc_tip'=>true,
                    'desc' => __( ' Customized label for your widget shown to your customers.' ),
                    'id'   => 'wcbf_text_from'
                ),

                array(
                'name' => __( 'Required?', 'wcbf-filter-setting' ),
                'type' => 'checkbox',
                'desc' => __( ' Is start date field required? ' ),
                'id'   => 'wcbf_RF_s_date'
                ),

                array(
                    'type' => 'sectionend',
                    'id'   => 'wcbf_start_date_setting',
                ),

                array(
                    'title' => __( 'End Date', 'wcbf-filter-setting' ),
                    'type'  => 'title',
                    'desc'  => __( 'All the settings related to End Date.', 'wcbf-filter-setting' ),
                    'id'    => 'wcbf_end_date_setting',
                ),

                array(
                    'name' => __( 'End Date', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'desc' => __( 'Enable this option if you want your customers to enter end date.' ),
                    'id'   => 'wcbf_is_end_date_enabled'
                ),
                
                array(
                    'name' => __( 'Customize text', 'wcbf-filter-setting' ),
                    'type' => 'text',
                    'desc_tip'=>true,
                    'desc' => __( 'Customized label for your widget shown to your customers. ' ),
                    'id'   => 'wcbf_text_to'
                ),

                array(
                    'name' => __( 'Required', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'enable' => 'false',
                    'desc' => __( 'Is end date field required? ' ),
                    'id'   => 'wcbf_RF_e_date'
                ),
                array(
                    'type' => 'sectionend',
                    'id'   => 'wcbf_end_date_setting',
                ),
                array(
                    'title' => __( 'Start Time', 'wcbf-filter-setting' ),
                    'type'  => 'title',
                    'desc'  => __( 'All the settings related to Start Time.', 'wcbf-filter-setting' ),
                    'id'    => 'wcbf_is_start_time_enabled',
                ),

                array(
                    'name' => __( 'Start Time', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'desc' => __( 'Enable this option if you want time specific search. ' ),
                    'id'   => 'wcbf_fuzzy_time_en'
                ),

                array(
                    'name' => __( 'Customize text', 'wcbf-filter-setting' ),
                    'type' => 'text',
                    'desc_tip'=>true,
                    'desc' => __( 'Customized label for your widget shown to your customers. ' ),
                    'id'   => 'wcbf_time_from'
                ),

                array(
                    'name' => __( 'Required', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'desc' => __( 'Is start time field required?  ' ),
                    'id'   => 'wcbf_RF_s_time'
                ),

                array(
                    'type' => 'sectionend',
                    'id'   => 'wcbf_is_start_time_enabled',
                ),
                

                array(
                    'title' => __( 'End Time', 'wcbf-filter-setting' ),
                    'type'  => 'title',
                    'desc'  => __( 'All the settings related to End Time.', 'wcbf-filter-setting' ),
                    'id'    => 'wcbf_is_end_time_enabled',
                ),

                array(
                    'name' => __( 'End Time', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'desc' => __( 'Enable this option if you want end time specific search.' ),
                    'id'   => 'wcbf_fuzzy_end_time'
                ),

                array(
                    'name' => __( 'Customize text', 'wcbf-filter-setting' ),
                    'type' => 'text',
                    'desc_tip'=>true,
                    'desc' => __( 'Customized label for your widget shown to your customers. ' ),
                    'id'   => 'wcbf_time_to'
                ),

                array(
                    'name' => __( 'Required', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'desc' => __( ' Is end date field required? ' ),
                    'id'   => 'wcbf_RF_e_time'
                ),

                array(
                    'type' => 'sectionend',
                    'id'   => 'wcbf_is_end_time_enabled',
                ),
                        //extension
                        //prcing here
                array(
                    'title' => __( 'Price Filter', 'wcbf-filter-setting' ),
                    'type'  => 'title',
                    'desc'  => __( 'All the settings of filter related to pricing.', 'wcbf-filter-setting' ),
                    'id'    => 'wcbf_is_price_setting_enabled',
                ),

                array(
                    'name' => __( 'Price', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'desc' => __( 'Enable this option if you want price specific search.  ' ),
                    'id'   => 'wcbf_min_price'
                ),

                array(
                    'name' => __( 'Customize text', 'wcbf-filter-setting' ),
                    'type' => 'text',
                    'desc_tip'=>true,
                    'desc' => __( 'Customized label for your widget shown to your customers. ' ),
                    'id'   => 'wcbf_min_price_text'
                ),

                array(
                    'type' => 'sectionend',
                    'id'   => 'wcbf_is_price_setting_enabled',
                ),
                        //max price
                array(
                    'title' => __( 'Maximum Price', 'wcbf-filter-setting' ),
                    'type'  => 'title',
                    'desc'  => __( 'All the settings for maximum price of filter.', 'wcbf-filter-setting' ),
                    'id'    => 'wcbf_is_max_price_setting_enabled',
                ),

                array(
                    'name' => __( 'Max Price', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'desc' => __( 'Enable this option if you want Max Price in search.  ' ),
                    'id'   => 'wcbf_max_price'
                ),


                array(
                    'type' => 'sectionend',
                    'id'   => 'wcbf_is_max_price_setting_enabled',
                ),

                //review ratting
                array(
                    'title' => __( 'Search by Rating', 'wcbf-filter-setting' ),
                    'type'  => 'title',
                    'desc'  => __( 'Let your customer search for your product based on your ratings.', 'wcbf-filter-setting' ),
                    'id'    => 'wcbf_rating_setting',
                ),

                array(
                    'name' => __( 'Include Rating?', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'desc' => __( 'Ratings wise search will be enabled when this option is checked.' ),
                    'id'   => 'wcbf_is_rating_enabled'
                ),

                array(
                    'name' => __( 'Customize text', 'wcbf-filter-setting' ),
                    'type' => 'text',
                    'desc_tip'=>true,
                    'desc' => __( 'Customized label for your widget shown to your customers. ' ),
                    'id'   => 'wcbf_rating_text'
                ),


                array(
                    'type' => 'sectionend',
                    'id'   => 'wcbf_rating_setting',
                ),
                    //SEARCH BY KEYWORD
                array(
                    'title' => __( 'Search by Keyword', 'wcbf-filter-setting' ),
                    'type'  => 'title',
                    'desc'  => __( "Let your customer search for your product based on your bookable product's title.", 'wcbf-filter-setting' ),
                    'id'    => 'wcbf_keyword_setting',
                ),

                array(
                    'name' => __( 'Enable Search by Name?', 'wcbf-filter-setting' ),
                    'type' => 'checkbox',
                    'desc' => __( 'Name-wise search will be enabled when this option is checked.' ),
                    'id'   => 'wcbf_is_keyword_search_enabled'
                ),

                array(
                    'name' => __( 'Customize text', 'wcbf-filter-setting' ),
                    'type' => 'text',
                    'desc_tip'=>true,
                    'desc' => __( 'Customized label for your widget shown to your customers. ' ),
                    'id'   => 'wcbf_keyword_search_text'
                ),

                array(
                    'type' => 'sectionend',
                    'id'   => 'wcbf_keyword_setting',
                ),
            )
        );
    }
}
WC_Settings_Tab::init();